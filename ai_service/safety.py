
import re


RED_FLAG_PATTERNS = {
    "difficulty_breathing": [
        r"\bsesak napas\b",
        r"\bsulit bernapas\b",
        r"\bsusah bernapas\b",
        r"\bnapas sangat sesak\b",
    ],
    "chest_pain": [
        r"\bnyeri dada\b",
        r"\bnyeri di dada\b",
        r"\bdada terasa sakit\b",
    ],
    "loss_of_consciousness": [
        r"\bpingsan\b",
        r"\btidak sadarkan diri\b",
        r"\bkehilangan kesadaran\b",
    ],
    "seizure": [
        r"\bkejang\b",
    ],
    "severe_bleeding": [
        r"\bpendarahan hebat\b",
        r"\bperdarahan hebat\b",
        r"\bdarah tidak berhenti\b",
    ],
}


URGENT_MESSAGE = (
    "Keluhan yang Anda sampaikan mungkin memerlukan "
    "pertolongan medis segera. Jangan mengandalkan chatbot "
    "untuk menentukan pengobatan. Segera cari pertolongan "
    "medis atau pergi ke IGD, terutama jika gejala sedang "
    "berlangsung atau memburuk."
)


def check_safety(normalized_text: str) -> dict:
    detected_flags = []

    for flag, patterns in RED_FLAG_PATTERNS.items():
        for pattern in patterns:
            if re.search(pattern, normalized_text):
                detected_flags.append(flag)
                break

    if detected_flags:
        return {
            "level": "urgent",
            "red_flags": detected_flags,
            "allow_retrieval": False,
            "message": URGENT_MESSAGE,
        }

    return {
        "level": "normal",
        "red_flags": [],
        "allow_retrieval": True,
        "message": None,
    }
