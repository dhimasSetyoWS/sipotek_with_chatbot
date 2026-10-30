
import json
from pathlib import Path
from collections import Counter
from sklearn.model_selection import train_test_split

BASE_DIR = Path(__file__).parent

DEV_PATH = BASE_DIR / "dataset_dev.jsonl"
TEST_PATH = BASE_DIR / "dataset_test.jsonl"

TRAIN_PATH = BASE_DIR / "train.jsonl"
VAL_PATH = BASE_DIR / "validation.jsonl"


def load_jsonl(path):
    with path.open("r", encoding="utf-8") as file:
        return [
            json.loads(line)
            for line in file
            if line.strip()
        ]


def save_jsonl(path, data):
    with path.open("w", encoding="utf-8") as file:
        for item in data:
            file.write(
                json.dumps(item, ensure_ascii=False) + "\n"
            )


data = load_jsonl(DEV_PATH)
test_data = load_jsonl(TEST_PATH)

# Pastikan label tersedia.
for item in data:
    if not item.get("message") or not item.get("expected_intent"):
        raise ValueError(f"Data tidak lengkap: {item}")

# Cegah pesan identik masuk ke train dan test.
train_messages = {
    item["message"].strip().casefold()
    for item in data
}
test_messages = {
    item["message"].strip().casefold()
    for item in test_data
}

overlap = train_messages & test_messages

if overlap:
    raise ValueError(
        f"Ditemukan {len(overlap)} pesan yang sama "
        "antara dataset_dev dan dataset_test. "
        "Periksa pemisahan dataset sebelum melanjutkan."
    )

labels = [item["expected_intent"] for item in data]

train_data, val_data = train_test_split(
    data,
    test_size=0.2,
    random_state=42,
    stratify=labels,
)

save_jsonl(TRAIN_PATH, train_data)
save_jsonl(VAL_PATH, val_data)

for name, subset in [
    ("TRAIN", train_data),
    ("VALIDATION", val_data),
    ("TEST", test_data),
]:
    print(f"\n{name}: {len(subset)} data")
    for label, count in sorted(
        Counter(item["expected_intent"] for item in subset).items()
    ):
        print(f"  {label}: {count}")

print("\nPembagian data selesai.")
