from pathlib import Path
import torch
from transformers import AutoTokenizer, AutoModelForSequenceClassification
from fastapi import FastAPI
from pydantic import BaseModel, Field
import re
from safety import check_safety

app = FastAPI(title="Apotek AI Service")
# Lokasi model hasil training IndoBERT
BASE_DIR = Path(__file__).resolve().parent
MODEL_DIR = BASE_DIR / "models" / "indobert-intent"

# Tentukan perangkat yang digunakan
DEVICE = torch.device(
    "cuda" if torch.cuda.is_available() else "cpu"
)

# Load tokenizer dan model satu kali ketika aplikasi dimulai
tokenizer = AutoTokenizer.from_pretrained(str(MODEL_DIR))

model = AutoModelForSequenceClassification.from_pretrained(
    str(MODEL_DIR)
)

model.to(DEVICE)
model.eval()

# Ambil mapping ID kelas ke nama intent dari konfigurasi model
ID2LABEL = {
    int(key): value.lower()
    for key, value in model.config.id2label.items()
}

print(f"IndoBERT loaded from: {MODEL_DIR}")
print(f"Device: {DEVICE}")
print(f"Intent labels: {ID2LABEL}")
class AnalyzeRequest(BaseModel):
    message: str = Field(min_length=1, max_length=1000)

SYMPTOM_ALIASES = {
    "sakit kepala": ["sakit kepala", "nyeri kepala", "kepala sakit", "kepala saya sakit", "kepala terasa sakit", "kepala nyut nyutan", "kepala cenat cenut", "pusing di kepala", "nyut nyutan", "cenat cenut"],
    "demam": ["demam", "badan panas", "panas badan", "meriang"],
    "batuk": ["batuk", "terbatuk"],
    "pilek": ["pilek", "hidung meler", "ingusan", "hidung berair", "meler"],
    "mual": ["mual", "perut terasa mual", "ingin muntah"],
    "pusing": ["pusing", "kepala terasa berputar", "kunang kunang"],
}

NEGATION_WORDS = {"tidak", "bukan", "belum", "tanpa", "enggak", "nggak", "gak", "ga"}
CLAUSE_BOUNDARIES = {"tapi", "tetapi", "namun", "sedangkan", "melainkan", "cuma", "hanya", "justru"}

AVAILABILITY_PATTERNS = [
    r"\bstok\b", r"\bpersediaan\b", r"\btersedia\b", r"\bketersediaan\b",
    r"\bcek stok\b", r"\bmasih ada\b", r"\bada stok\b", r"\bada obat\b",
    r"\bpunya obat\b", r"\bapotek punya\b", r"\bobat\b.{0,45}\b(kosong|ada|tersedia)\b",
]
MEDICINE_INFO_PATTERNS = [
    r"\befek samping\b", r"\bkontraindikasi\b", r"\baturan pakai\b", r"\bcara minum\b",
    r"\bcara menggunakan\b", r"\bdigunakan untuk apa\b", r"\bfungsi\b", r"\bkegunaan\b",
    r"\bmanfaat\b", r"\bkandungan\b", r"\bperingatan\b", r"\binteraksi\b",
    r"\bdosis\b", r"\bgolongan obat\b", r"\baman digunakan\b", r"\binformasi obat\b",
]

def normalize_text(text: str) -> str:
    text = text.lower().strip().replace("nyut-nyutan", "nyut nyutan").replace("cenat-cenut", "cenat cenut")
    text = re.sub(r"[^\w\s]", " ", text)
    return re.sub(r"\s+", " ", text).strip()

def contains_phrase(text: str, phrase: str) -> bool:
    phrase = normalize_text(phrase)
    return re.search(rf"(?<!\w){re.escape(phrase)}(?!\w)", text) is not None

def _phrase_matches(text: str, phrase: str):
    phrase = normalize_text(phrase)
    return list(re.finditer(rf"(?<!\w){re.escape(phrase)}(?!\w)", text))

def _is_negated_occurrence(text: str, start: int, end: int) -> bool:
    words = text[:start].strip().split()
    boundary_index = max((i for i, word in enumerate(words) if word in CLAUSE_BOUNDARIES), default=-1)
    context_words = words[boundary_index + 1:][-4:]
    if any(word in NEGATION_WORDS for word in context_words):
        return True
    after = text[end:]
    return re.match(r"\s*(?:sekarang|kini|saat ini)\s+(?:(?:sudah|masih)\s+)?(?:tidak|bukan|belum|enggak|nggak|gak|ga)\b", after) is not None

def is_negated(text: str, phrase: str) -> bool:
    normalized = normalize_text(text)
    matches = _phrase_matches(normalized, phrase)
    return bool(matches and _is_negated_occurrence(normalized, matches[0].start(), matches[0].end()))

def _is_medicine_mention(text: str, start: int) -> bool:
    prefix = text[:start].strip()
    return re.search(r"\b(?:obat|obat untuk|obat sakit|obat batuk|obat demam|obat pilek|obat mual|obat pusing|obat kepala)\s*$", prefix) is not None

def extract_symptoms(text: str) -> dict:
    symptoms, negated_symptoms = [], []
    for symptom, aliases in SYMPTOM_ALIASES.items():
        positive_found = negated_found = False
        for alias in aliases:
            for match in _phrase_matches(text, alias):
                if _is_medicine_mention(text, match.start()):
                    continue
                if _is_negated_occurrence(text, match.start(), match.end()):
                    negated_found = True
                else:
                    positive_found = True
        if positive_found:
            symptoms.append(symptom)
        elif negated_found:
            negated_symptoms.append(symptom)
    return {"symptoms": symptoms, "negated_symptoms": negated_symptoms}

def _matches_any(text: str, patterns: list[str]) -> bool:
    return any(re.search(pattern, text) for pattern in patterns)

CONFIDENCE_THRESHOLD = 0.60

def predict_intent(text: str) -> str:
    inputs = tokenizer(
        text,
        return_tensors="pt",
        truncation=True,
        max_length=128,
    )

    inputs = {
        key: value.to(DEVICE)
        for key, value in inputs.items()
    }

    with torch.inference_mode():
        outputs = model(**inputs)
        probabilities = torch.softmax(
            outputs.logits,
            dim=1,
        )[0]

    predicted_id = int(
        torch.argmax(probabilities).item()
    )

    predicted_intent = ID2LABEL.get(
        predicted_id,
        "unknown",
    )

    confidence = float(
        probabilities[predicted_id].item()
    )

    print(f"Text       : {text}")
    print(f"Intent     : {predicted_intent}")
    print(f"Confidence : {confidence:.4f}")

    if confidence < CONFIDENCE_THRESHOLD:
        return "unknown"

    return predicted_intent

def classify_intent(text: str, symptoms: list[str]) -> str:
    return predict_intent(text)

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
    needs_clarification = intent == "unknown" or (intent == "symptom_inquiry" and not symptoms)
    return {
        "intent": intent,
        "normalized_text": normalized_text,
        "symptoms": symptoms,
        "negated_symptoms": negated_symptoms,
        "needs_clarification": needs_clarification,
        "safety": safety,
    }
