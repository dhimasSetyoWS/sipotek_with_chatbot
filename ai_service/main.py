
from fastapi import FastAPI
from pydantic import BaseModel, Field
from safety import check_safety
import re

app = FastAPI(title="Apotek AI Service")


class AnalyzeRequest(BaseModel):
    message: str = Field(min_length=1, max_length=1000)


# Kamus gejala dan variasi kata yang mungkin digunakan pengguna.
SYMPTOM_ALIASES = {
    "sakit kepala": [
        "sakit kepala",
        "nyeri kepala",
        "kepala sakit",
        "kepala nyut nyutan",
        "pusing di kepala",
        "nyut nyutan"
    ],
    "demam": [
        "demam",
        "badan panas",
        "panas badan",
    ],
    "batuk": [
        "batuk",
        "terbatuk",
    ],
    "pilek": [
        "pilek",
        "hidung meler",
        "ingusan",
        "hidung berair",
    ],
    "mual": [
        "mual",
        "perut terasa mual",
        "ingin muntah",
    ],
    "pusing": [
        "pusing",
        "kepala terasa berputar",
        "kunang kunang",
    ],
}

NEGATION_WORDS = {
    "tidak",
    "bukan",
    "belum",
    "tanpa",
    "enggak",
    "nggak",
    "gak",
    "ga",
}

AVAILABILITY_KEYWORDS = [
    "stok",
    "persediaan",
    "tersedia",
    "ketersediaan",
    "ada obat",
    "obat apa yang ada",
]

MEDICINE_INFO_KEYWORDS = [
    "kegunaan obat",
    "fungsi obat",
    "efek samping",
    "kontraindikasi",
    "aturan pakai",
    "cara minum",
]


CLAUSE_BOUNDARIES = {
    "tapi",
    "tetapi",
    "namun",
    "sedangkan",
    "melainkan",
}

def normalize_text(text: str) -> str:
    """Merapikan teks agar lebih mudah diproses."""
    text = text.lower().strip()

    # Samakan beberapa variasi penulisan informal.
    text = re.sub(r"\b(nyut-nyutan|nyut nyutan)\b", "nyut nyutan", text)

    # Hilangkan tanda baca dan rapikan spasi.
    text = re.sub(r"[^\w\s]", " ", text)
    text = re.sub(r"\s+", " ", text)

    return text.strip()


def contains_phrase(text: str, phrase: str) -> bool:
    """Memastikan frasa cocok sebagai kata/frasa utuh."""
    pattern = rf"(?<!\w){re.escape(phrase)}(?!\w)"
    return re.search(pattern, text) is not None


def is_negated(text: str, phrase: str) -> bool:
    pattern = rf"(?<!\w){re.escape(phrase)}(?!\w)"
    match = re.search(pattern, text)

    if not match:
        return False

    # Ambil teks sebelum gejala yang sedang diperiksa.
    preceding_text = text[:match.start()].strip()
    preceding_words = preceding_text.split()

    # Cari batas klausa terdekat.
    last_boundary_index = -1

    for i, word in enumerate(preceding_words):
        if word in CLAUSE_BOUNDARIES:
            last_boundary_index = i

    # Periksa hanya kata-kata setelah batas klausa.
    current_clause = preceding_words[last_boundary_index + 1:]

    # Periksa maksimal tiga kata sebelum gejala.
    context_words = current_clause[-3:]

    return any(
        word in NEGATION_WORDS
        for word in context_words
    )


def extract_symptoms(text: str) -> dict:
    symptoms = []
    negated_symptoms = []

    for symptom, aliases in SYMPTOM_ALIASES.items():
        found_positive = False
        found_negated = False

        for alias in aliases:
            if not contains_phrase(text, alias):
                continue

            if is_negated(text, alias):
                found_negated = True
            else:
                found_positive = True

        if found_positive:
            symptoms.append(symptom)
        elif found_negated:
            negated_symptoms.append(symptom)

    return {
        "symptoms": symptoms,
        "negated_symptoms": negated_symptoms,
    }


def classify_intent(text: str, symptoms: list[str]) -> str:
    """Menentukan tujuan utama pesan berdasarkan aturan sederhana."""

    if any(
        contains_phrase(text, keyword)
        for keyword in AVAILABILITY_KEYWORDS
    ):
        return "medicine_availability"

    if any(
        contains_phrase(text, keyword)
        for keyword in MEDICINE_INFO_KEYWORDS
    ):
        return "medicine_information"

    if symptoms:
        return "symptom_inquiry"

    return "unknown"


@app.get("/health")
def health():
    return {"status": "ok"}


@app.post("/analyze")
def analyze(data: AnalyzeRequest):
    normalized_text = normalize_text(data.message)
    safety = check_safety(normalized_text)
    extracted = extract_symptoms(normalized_text)
    symptoms = extracted["symptoms"]
    negated_symptoms = extracted["negated_symptoms"]

    intent = classify_intent(normalized_text, symptoms)

    needs_clarification = (
        intent == "unknown"
        or (
            intent == "symptom_inquiry"
            and len(symptoms) == 0
        )
    )

    return {
        "intent": intent,
        "normalized_text": normalized_text,
        "symptoms": symptoms,
        "negated_symptoms": negated_symptoms,
        "needs_clarification": needs_clarification,
        "safety" : safety
    }
