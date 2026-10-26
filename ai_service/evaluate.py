
import json
from collections import defaultdict
from pathlib import Path

from main import (
    classify_intent,
    extract_symptoms,
)

from safety import check_safety


DATASET_PATH = "dataset_dev.jsonl"


def load_dataset(path):
    """Membaca dataset evaluasi berformat JSONL."""
    dataset_path = Path(path)

    if not dataset_path.exists():
        raise FileNotFoundError(
            f"Dataset tidak ditemukan: {dataset_path.resolve()}"
        )

    data = []

    with dataset_path.open("r", encoding="utf-8") as file:
        for line_number, line in enumerate(file, start=1):
            if not line.strip():
                continue

            try:
                data.append(json.loads(line))
            except json.JSONDecodeError as error:
                raise ValueError(
                    f"JSON tidak valid pada baris {line_number}: {error}"
                ) from error

    return data


def evaluate(dataset):
    """Mengevaluasi intent, gejala, negasi, dan tingkat keselamatan."""
    metrics = {
        "intent": {"correct": 0, "total": 0},
        "symptoms": {"correct": 0, "total": 0},
        "negation": {"correct": 0, "total": 0},
        "safety": {"correct": 0, "total": 0},
    }

    failures = defaultdict(list)

    for item in dataset:
        message = item["message"]
        example_id = item.get("id", "unknown")
        symptomp = item["expected_symptoms"]
        # Evaluasi intent
        expected_intent = item["expected_intent"]
        predicted_intent = classify_intent(message, symptomp)

        metrics["intent"]["total"] += 1

        if predicted_intent == expected_intent:
            metrics["intent"]["correct"] += 1
        else:
            failures["intent"].append({
                "id": example_id,
                "message": message,
                "expected": expected_intent,
                "predicted": predicted_intent,
            })

        # Evaluasi gejala positif dan gejala yang dinegasikan
        symptom_result = extract_symptoms(message)

        predicted_symptoms = set(symptom_result["symptoms"])
        expected_symptoms = set(item["expected_symptoms"])

        metrics["symptoms"]["total"] += 1

        if predicted_symptoms == expected_symptoms:
            metrics["symptoms"]["correct"] += 1
        else:
            failures["symptoms"].append({
                "id": example_id,
                "message": message,
                "expected": sorted(expected_symptoms),
                "predicted": sorted(predicted_symptoms),
            })

        expected_negated = set(item["expected_negated_symptoms"])
        predicted_negated = set(symptom_result["negated_symptoms"])

        metrics["negation"]["total"] += 1

        if predicted_negated == expected_negated:
            metrics["negation"]["correct"] += 1
        else:
            failures["negation"].append({
                "id": example_id,
                "message": message,
                "expected": sorted(expected_negated),
                "predicted": sorted(predicted_negated),
            })

        # Evaluasi safety
        safety_result = check_safety(message)

        expected_safety = item["expected_safety_level"]
        predicted_safety = safety_result["level"]

        metrics["safety"]["total"] += 1

        if predicted_safety == expected_safety:
            metrics["safety"]["correct"] += 1
        else:
            failures["safety"].append({
                "id": example_id,
                "message": message,
                "expected": expected_safety,
                "predicted": predicted_safety,
                "red_flags": safety_result.get("red_flags", []),
            })

    return metrics, failures


def print_results(metrics, failures):
    """Menampilkan ringkasan evaluasi dan contoh kesalahan."""
    print("\n" + "=" * 55)
    print("HASIL EVALUASI BASELINE NLP CHATBOT APOTEK")
    print("=" * 55)

    for metric_name, result in metrics.items():
        correct = result["correct"]
        total = result["total"]

        accuracy = (correct / total * 100) if total else 0

        print(
            f"{metric_name.capitalize():<12}: "
            f"{correct}/{total} ({accuracy:.2f}%)"
        )

    print("\n" + "=" * 55)
    print("DETAIL KESALAHAN")
    print("=" * 55)

    for metric_name, errors in failures.items():
        print(f"\n[{metric_name.upper()}] {len(errors)} kesalahan")

        for error in errors:
            print(f"\nID       : {error['id']}")
            print(f"Pesan    : {error['message']}")
            print(f"Expected : {error['expected']}")
            print(f"Predicted: {error['predicted']}")

            if "red_flags" in error:
                print(f"Red flags: {error['red_flags']}")

    total_errors = sum(len(errors) for errors in failures.values())

    print("\n" + "=" * 55)
    print(f"Total kesalahan per metrik: {total_errors}")
    print("=" * 55)


def main():
    try:
        dataset = load_dataset(DATASET_PATH)

        if not dataset:
            print("Dataset kosong. Tidak ada evaluasi yang dilakukan.")
            return

        metrics, failures = evaluate(dataset)
        print(f"Jumlah data evaluasi: {len(dataset)}")
        print_results(metrics, failures)

    except (FileNotFoundError, ValueError, KeyError) as error:
        print(f"Evaluasi gagal: {error}")

main()