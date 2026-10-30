
import json
from pathlib import Path

import torch
from torch.utils.data import DataLoader, Dataset
from transformers import (
    AutoTokenizer,
    AutoModelForSequenceClassification,
)
from sklearn.metrics import (
    accuracy_score,
    classification_report,
    confusion_matrix,
    precision_recall_fscore_support,
)

BASE_DIR = Path(__file__).resolve().parent
MODEL_DIR = BASE_DIR / "models" / "indobert-intent"
TEST_PATH = BASE_DIR / "dataset_test.jsonl"

DEVICE = torch.device(
    "cuda" if torch.cuda.is_available() else "cpu"
)
BATCH_SIZE = 8
MAX_LENGTH = 128


def load_jsonl(path):
    if not path.exists():
        raise FileNotFoundError(f"File tidak ditemukan: {path}")

    with path.open("r", encoding="utf-8") as file:
        data = [
            json.loads(line)
            for line in file
            if line.strip()
        ]

    if not data:
        raise ValueError("Dataset test kosong.")

    for item in data:
        if not item.get("message") or not item.get("expected_intent"):
            raise ValueError(f"Data test tidak lengkap: {item}")

    return data


data = load_jsonl(TEST_PATH)

tokenizer = AutoTokenizer.from_pretrained(MODEL_DIR)
model = AutoModelForSequenceClassification.from_pretrained(
    MODEL_DIR
).to(DEVICE)
model.eval()

label2id = model.config.label2id
id2label = {
    int(key): value
    for key, value in model.config.id2label.items()
}

expected_labels = {
    item["expected_intent"]
    for item in data
}
model_labels = set(id2label.values())

if not expected_labels.issubset(model_labels):
    raise ValueError(
        "Ada label test yang tidak dikenal model: "
        f"{sorted(expected_labels - model_labels)}"
    )


class TestDataset(Dataset):
    def __init__(self, records):
        self.messages = [r["message"].strip() for r in records]
        self.targets = [
            label2id[r["expected_intent"]]
            for r in records
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


loader = DataLoader(
    TestDataset(data),
    batch_size=BATCH_SIZE,
    shuffle=False,
)

all_predictions = []
all_targets = []

with torch.no_grad():
    for batch in loader:
        targets = batch["labels"].tolist()

        inputs = {
            key: value.to(DEVICE)
            for key, value in batch.items()
            if key != "labels"
        }

        outputs = model(**inputs)
        predictions = outputs.logits.argmax(dim=1).cpu().tolist()

        all_predictions.extend(predictions)
        all_targets.extend(targets)

accuracy = accuracy_score(all_targets, all_predictions)

precision, recall, f1, _ = precision_recall_fscore_support(
    all_targets,
    all_predictions,
    labels=list(range(len(id2label))),
    average="macro",
    zero_division=0,
)

print(f"Device: {DEVICE}")
print(f"Jumlah data test: {len(data)}")
print(f"Accuracy: {accuracy:.4f}")
print(f"Macro precision: {precision:.4f}")
print(f"Macro recall: {recall:.4f}")
print(f"Macro F1: {f1:.4f}")

print("\nClassification Report:")
print(
    classification_report(
        all_targets,
        all_predictions,
        labels=list(range(len(id2label))),
        target_names=[id2label[i] for i in range(len(id2label))],
        zero_division=0,
    )
)

print("\nConfusion Matrix:")
print(
    confusion_matrix(
        all_targets,
        all_predictions,
        labels=list(range(len(id2label))),
    )
)

print("\nContoh prediksi yang salah:")
for item, actual, predicted in zip(
    data, all_targets, all_predictions
):
    if actual != predicted:
        print(f"- Pesan: {item['message']}")
        print(f"  Aktual   : {id2label[actual]}")
        print(f"  Prediksi : {id2label[predicted]}")
