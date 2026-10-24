
import json
from urllib.request import Request, urlopen
from urllib.error import URLError, HTTPError

API_URL = "http://127.0.0.1:8001/analyze"
DATASET_PATH = "dataset.jsonl"


def load_dataset(path):
    dataset = []

    with open(path, "r", encoding="utf-8") as file:
        for line_number, line in enumerate(file, start=1):
            if not line.strip():
                continue

            try:
                dataset.append(json.loads(line))
            except json.JSONDecodeError as exc:
                raise ValueError(
                    f"JSON tidak valid pada baris {line_number}: {exc}"
                ) from exc

    return dataset


def call_api(message):
    payload = json.dumps({"message": message}).encode("utf-8")

    request = Request(
        API_URL,
        data=payload,
        headers={"Content-Type": "application/json"},
        method="POST",
    )

    with urlopen(request, timeout=10) as response:
        return json.loads(response.read().decode("utf-8"))


def exact_match(actual, expected):
    return set(actual or []) == set(expected or [])


def percentage(correct, total):
    if total == 0:
        return 0.0

    return correct / total * 100


def main():
    dataset = load_dataset(DATASET_PATH)

    if not dataset:
        print("Dataset kosong.")
        return

    results = []

    for item in dataset:
        try:
            actual = call_api(item["message"])
        except (URLError, HTTPError, TimeoutError, ValueError) as exc:
            print(f"Gagal menguji {item['id']}: {exc}")
            continue

        safety = actual.get("safety") or {}

        checks = {
            "intent": (
                actual.get("intent")
                == item["expected_intent"]
            ),
            "symptoms": exact_match(
                actual.get("symptoms", []),
                item["expected_symptoms"],
            ),
            "negation": exact_match(
                actual.get("negated_symptoms", []),
                item["expected_negated_symptoms"],
            ),
            "safety": (
                safety.get("level")
                == item["expected_safety_level"]
            ),
        }

        results.append({
            "id": item["id"],
            "message": item["message"],
            "checks": checks,
            "actual": actual,
            "expected": item,
        })

    if not results:
        print("Tidak ada pengujian yang berhasil dijalankan.")
        return

    total = len(results)

    metrics = {
        key: sum(
            result["checks"][key]
            for result in results
        )
        for key in ("intent", "symptoms", "negation", "safety")
    }

    print(f"\nJumlah contoh berhasil diuji: {total}\n")

    for name, correct in metrics.items():
        print(
            f"{name:10s}: "
            f"{correct}/{total} "
            f"({percentage(correct, total):.2f}%)"
        )

    print("\n--- Kasus yang gagal ---")

    failures = 0

    for result in results:
        failed_checks = [
            name
            for name, passed in result["checks"].items()
            if not passed
        ]

        if not failed_checks:
            continue

        failures += 1

        print(f"\n[{result['id']}] {result['message']}")
        print("Bagian gagal:", ", ".join(failed_checks))
        print("Ekspektasi:")
        print(json.dumps(result["expected"], ensure_ascii=False))
        print("Aktual:")
        print(json.dumps(result["actual"], ensure_ascii=False))

    if failures == 0:
        print("Semua pemeriksaan cocok dengan label dataset.")


if __name__ == "__main__":
    main()
