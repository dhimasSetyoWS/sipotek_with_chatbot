
import json
import random
from pathlib import Path

import numpy as np
import torch
from torch.utils.data import Dataset, DataLoader
from torch.optim import AdamW

from transformers import (
    AutoTokenizer,
    AutoModelForSequenceClassification,
    get_linear_schedule_with_warmup,
)

from sklearn.metrics import (
    accuracy_score,
    precision_recall_fscore_support,
    classification_report,
)


# ==================================================
# 1. KONFIGURASI
# ==================================================

BASE_DIR = Path(__file__).resolve().parent

TRAIN_PATH = BASE_DIR / "train.jsonl"
VAL_PATH = BASE_DIR / "validation.jsonl"

MODEL_NAME = "indobenchmark/indobert-base-p1"
OUTPUT_DIR = BASE_DIR / "models" / "indobert-intent"

MAX_LENGTH = 128
BATCH_SIZE = 8
EPOCHS = 5
LEARNING_RATE = 2e-5
RANDOM_SEED = 42

DEVICE = torch.device(
    "cuda" if torch.cuda.is_available() else "cpu"
)


# ==================================================
# 2. REPRODUKTIBILITAS
# ==================================================

def set_seed(seed):
    random.seed(seed)
    np.random.seed(seed)
    torch.manual_seed(seed)

    if torch.cuda.is_available():
        torch.cuda.manual_seed_all(seed)


set_seed(RANDOM_SEED)


# ==================================================
# 3. MEMBACA DATASET JSONL
# ==================================================

def load_jsonl(path):
    if not path.exists():
        raise FileNotFoundError(
            f"File dataset tidak ditemukan: {path}"
        )

    data = []

    with path.open("r", encoding="utf-8") as file:
        for line_number, line in enumerate(file, start=1):
            if not line.strip():
                continue

            try:
                item = json.loads(line)
            except json.JSONDecodeError as error:
                raise ValueError(
                    f"JSON tidak valid pada {path.name}, "
                    f"baris {line_number}"
                ) from error

            message = item.get("message")
            intent = item.get("expected_intent")

            if (
                not isinstance(message, str)
                or not message.strip()
                or not isinstance(intent, str)
                or not intent.strip()
            ):
                raise ValueError(
                    f"Message atau intent tidak valid: "
                    f"{path.name}, baris {line_number}"
                )

            item["message"] = message.strip()
            item["expected_intent"] = intent.strip()

            data.append(item)

    if not data:
        raise ValueError(f"Dataset kosong: {path.name}")

    return data


train_data = load_jsonl(TRAIN_PATH)
val_data = load_jsonl(VAL_PATH)

train_messages = {
    item["message"].casefold()
    for item in train_data
}

val_messages = {
    item["message"].casefold()
    for item in val_data
}

if train_messages & val_messages:
    raise ValueError(
        "Ada pesan duplikat antara train dan validation. "
        "Periksa pembagian dataset terlebih dahulu."
    )


# ==================================================
# 4. MEMBUAT LABEL INTENT
# ==================================================

labels = sorted({
    item["expected_intent"]
    for item in train_data
})

label2id = {
    label: index
    for index, label in enumerate(labels)
}

id2label = {
    index: label
    for label, index in label2id.items()
}

unknown_val_labels = {
    item["expected_intent"]
    for item in val_data
} - set(labels)

if unknown_val_labels:
    raise ValueError(
        "Ada label validation yang tidak ditemukan di train: "
        f"{sorted(unknown_val_labels)}"
    )

print(f"Device       : {DEVICE}")
print(f"Data train   : {len(train_data)}")
print(f"Data validasi: {len(val_data)}")
print(f"Jumlah intent: {len(labels)}")
print(f"Label        : {labels}")


# ==================================================
# 5. TOKENIZER DAN DATASET PYTORCH
# ==================================================

print("\nMemuat tokenizer IndoBERT...")

tokenizer = AutoTokenizer.from_pretrained(MODEL_NAME)


class IntentDataset(Dataset):
    def __init__(self, data):
        self.messages = [
            item["message"] for item in data
        ]

        self.targets = [
            label2id[item["expected_intent"]]
            for item in data
        ]

        self.encodings = tokenizer(
            self.messages,
            truncation=True,
            padding="max_length",
            max_length=MAX_LENGTH,
            return_tensors="pt",
        )

    def __len__(self):
        return len(self.targets)

    def __getitem__(self, index):
        item = {
            key: value[index]
            for key, value in self.encodings.items()
        }

        item["labels"] = torch.tensor(
            self.targets[index],
            dtype=torch.long,
        )

        return item


train_dataset = IntentDataset(train_data)
val_dataset = IntentDataset(val_data)

train_loader = DataLoader(
    train_dataset,
    batch_size=BATCH_SIZE,
    shuffle=True,
)

val_loader = DataLoader(
    val_dataset,
    batch_size=BATCH_SIZE,
    shuffle=False,
)


# ==================================================
# 6. MEMUAT MODEL INDOBERT
# ==================================================

print("\nMemuat model IndoBERT...")

model = AutoModelForSequenceClassification.from_pretrained(
    MODEL_NAME,
    num_labels=len(labels),
    label2id=label2id,
    id2label=id2label,
)

model.to(DEVICE)


# ==================================================
# 7. OPTIMIZER DAN LEARNING RATE SCHEDULER
# ==================================================

optimizer = AdamW(
    model.parameters(),
    lr=LEARNING_RATE,
)

total_steps = len(train_loader) * EPOCHS

scheduler = get_linear_schedule_with_warmup(
    optimizer,
    num_warmup_steps=0,
    num_training_steps=total_steps,
)


# ==================================================
# 8. FUNGSI EVALUASI
# ==================================================

def evaluate_model():
    model.eval()

    total_loss = 0.0
    all_predictions = []
    all_targets = []

    with torch.no_grad():
        for batch in val_loader:
            batch = {
                key: value.to(DEVICE)
                for key, value in batch.items()
            }

            outputs = model(**batch)

            total_loss += outputs.loss.item()

            predictions = torch.argmax(
                outputs.logits,
                dim=1,
            )

            all_predictions.extend(
                predictions.cpu().tolist()
            )

            all_targets.extend(
                batch["labels"].cpu().tolist()
            )

    accuracy = accuracy_score(
        all_targets,
        all_predictions,
    )

    precision, recall, f1, _ = (
        precision_recall_fscore_support(
            all_targets,
            all_predictions,
            average="macro",
            zero_division=0,
        )
    )

    return {
        "loss": total_loss / len(val_loader),
        "accuracy": accuracy,
        "precision_macro": precision,
        "recall_macro": recall,
        "f1_macro": f1,
        "predictions": all_predictions,
        "targets": all_targets,
    }


# ==================================================
# 9. PROSES TRAINING
# ==================================================

OUTPUT_DIR.mkdir(parents=True, exist_ok=True)

best_f1 = -1.0
history = []

print("\nMemulai fine-tuning IndoBERT...\n")

for epoch in range(EPOCHS):
    model.train()
    total_train_loss = 0.0

    for batch in train_loader:
        batch = {
            key: value.to(DEVICE)
            for key, value in batch.items()
        }

        optimizer.zero_grad()

        outputs = model(**batch)
        loss = outputs.loss

        loss.backward()

        # Mengurangi risiko gradien terlalu besar.
        torch.nn.utils.clip_grad_norm_(
            model.parameters(),
            max_norm=1.0,
        )

        optimizer.step()
        scheduler.step()

        total_train_loss += loss.item()

    train_loss = total_train_loss / len(train_loader)
    val_metrics = evaluate_model()

    epoch_result = {
        "epoch": epoch + 1,
        "train_loss": train_loss,
        "val_loss": val_metrics["loss"],
        "val_accuracy": val_metrics["accuracy"],
        "val_precision_macro": val_metrics["precision_macro"],
        "val_recall_macro": val_metrics["recall_macro"],
        "val_f1_macro": val_metrics["f1_macro"],
    }

    history.append(epoch_result)

    print(
        f"Epoch {epoch + 1}/{EPOCHS} | "
        f"Train Loss: {train_loss:.4f} | "
        f"Val Loss: {val_metrics['loss']:.4f} | "
        f"Accuracy: {val_metrics['accuracy']:.4f} | "
        f"Macro F1: {val_metrics['f1_macro']:.4f}"
    )

    # Simpan checkpoint dengan macro F1 terbaik.
    if val_metrics["f1_macro"] > best_f1:
        best_f1 = val_metrics["f1_macro"]

        model.save_pretrained(OUTPUT_DIR)
        tokenizer.save_pretrained(OUTPUT_DIR)

        with (
            OUTPUT_DIR / "labels.json"
        ).open("w", encoding="utf-8") as file:
            json.dump(
                {
                    "label2id": label2id,
                    "id2label": {
                        str(key): value
                        for key, value in id2label.items()
                    },
                },
                file,
                ensure_ascii=False,
                indent=2,
            )

        print("  -> Model terbaik berhasil disimpan.")


# ==================================================
# 10. MENYIMPAN RIWAYAT TRAINING
# ==================================================

with (OUTPUT_DIR / "training_history.json").open(
    "w", encoding="utf-8"
) as file:
    json.dump(
        history,
        file,
        ensure_ascii=False,
        indent=2,
    )


# ==================================================
# 11. LAPORAN VALIDASI MODEL TERBAIK
# ==================================================

print("\nMemuat kembali model terbaik...")

model = AutoModelForSequenceClassification.from_pretrained(
    OUTPUT_DIR
).to(DEVICE)
	
final_metrics = evaluate_model()

print("\nClassification Report - Validation")
print(
    classification_report(
        final_metrics["targets"],
        final_metrics["predictions"],
        labels=list(range(len(labels))),
        target_names=labels,
        zero_division=0,
    )
)

summary = {
    key: value
    for key, value in final_metrics.items()
    if key not in {"predictions", "targets"}
}

summary["best_validation_macro_f1"] = best_f1

with (OUTPUT_DIR / "metrics.json").open(
    "w", encoding="utf-8"
) as file:
    json.dump(
        summary,
        file,
        ensure_ascii=False,
        indent=2,
    )

print(f"\nModel tersimpan di: {OUTPUT_DIR}")
print("Training selesai.")
