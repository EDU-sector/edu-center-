from __future__ import annotations

from typing import Any, Dict, List, Optional

from fastapi import FastAPI, Query
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel

app = FastAPI(title="EduTricity API", version="1.0.0")

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

INSTITUTIONS: List[Dict[str, Any]] = [
    {
        "id": "chandigarh-university",
        "name": "Chandigarh University",
        "city": "Chandigarh",
        "category": "University",
        "ownership": "Private",
        "programmes": ["Engineering", "Management", "Computer Science"],
        "fees": "₹1.2L - ₹2.5L / year",
        "rating": 4.9,
        "description": "Strong engineering, management, and innovation-focused academic offerings.",
    },
    {
        "id": "government-college-for-girls",
        "name": "Government College for Girls",
        "city": "Chandigarh",
        "category": "College",
        "ownership": "Government",
        "programmes": ["Arts", "Science", "Commerce"],
        "fees": "₹10K - ₹35K / year",
        "rating": 4.7,
        "description": "Affordable higher education with strong academic support and public-sector access.",
    },
    {
        "id": "apeejay-school",
        "name": "Apeejay School",
        "city": "Mohali",
        "category": "School",
        "ownership": "Private",
        "programmes": ["CBSE", "STEM", "Sports"],
        "fees": "₹70K - ₹1.5L / year",
        "rating": 4.6,
        "description": "Well-rounded school education focused on academics and co-curricular growth.",
    },
    {
        "id": "target-coaching-centre",
        "name": "Target Coaching Centre",
        "city": "Panchkula",
        "category": "Coaching",
        "ownership": "Private",
        "programmes": ["JEE", "NEET", "Foundation"],
        "fees": "₹30K - ₹80K / year",
        "rating": 4.5,
        "description": "Entrance-focused coaching and test preparation with strong mentoring support.",
    },
    {
        "id": "govind-guru-college",
        "name": "Govind Guru College",
        "city": "Panchkula",
        "category": "College",
        "ownership": "Government",
        "programmes": ["Commerce", "Arts", "Science"],
        "fees": "₹12K - ₹40K / year",
        "rating": 4.4,
        "description": "Accessible public higher education with a broad curriculum mix.",
    },
    {
        "id": "new-era-skills",
        "name": "New Era Skills Academy",
        "city": "Mohali",
        "category": "Skill Development",
        "ownership": "Private",
        "programmes": ["Digital Marketing", "UI/UX", "Data Analytics"],
        "fees": "₹25K - ₹90K / course",
        "rating": 4.8,
        "description": "Career-oriented training for modern digital and analytical skills.",
    },
]


class SuggestionPayload(BaseModel):
    institution: str
    location: str
    details: Optional[str] = None


@app.get("/health")
def health() -> Dict[str, str]:
    return {"status": "ok", "service": "EduTricity API"}


@app.get("/api/institutions")
def get_institutions(query: str = "") -> Dict[str, Any]:
    q = query.strip().lower()
    if not q:
        results = INSTITUTIONS
    else:
        results = [
            item
            for item in INSTITUTIONS
            if q in item["name"].lower()
            or q in item["city"].lower()
            or q in item["category"].lower()
            or any(q in programme.lower() for programme in item["programmes"])
        ]

    return {"count": len(results), "results": results}


@app.get("/api/compare")
def compare_institutions(names: List[str] = Query(default=[])) -> Dict[str, Any]:
    normalized = {name.strip().lower() for name in names if name and name.strip()}
    selected = [
        item
        for item in INSTITUTIONS
        if item["name"].lower() in normalized
    ]

    return {
        "count": len(selected),
        "criteria": ["name", "city", "category", "ownership", "fees", "programmes"],
        "results": selected,
    }


@app.post("/api/suggestions")
def create_suggestion(payload: SuggestionPayload) -> Dict[str, Any]:
    return {
        "success": True,
        "message": f"Thank you! “{payload.institution}” has been queued for review.",
        "payload": {
            "institution": payload.institution,
            "location": payload.location,
            "details": payload.details,
        },
    }


if __name__ == "__main__":
    import uvicorn

    uvicorn.run("backend.app:app", host="0.0.0.0", port=8001, reload=True)
