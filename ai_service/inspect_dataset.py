
import json
from collections import Counter
from pathlib import Path

dataset_path = Path("dataset_dev.jsonl")

data = []

with dataset_path.open("r", encoding="utf-8") as file:
    for line in file:
        if line.strip():
            data.append(json.loads(line))

print("Jumlah data:", len(data))

intent_counts = Counter(
    item.get("expected_intent")
    for item in data
)

print("\nDistribusi intent:")
for intent, count in intent_counts.items():
    print(f"{intent}: {count}")

print("\nContoh data:")
for item in data[:5]:
    print({
        "message": item.get("message"),
        "expected_intent": item.get("expected_intent"),
    })
