# EduTricity 🎓

**Education Discovery and Intelligence Platform**

EduTricity is a collaborative project to help students discover, explore, and compare educational institutions across Chandigarh, Mohali (SAS Nagar), and Panchkula.

## 🎯 Objectives

- Discover schools, colleges, universities, coaching institutes, and skill-development institutes.
- Search and filter institutions by location, education sector, and ownership.
- Compare institutions using available course, fee, eligibility, and facility information.
- Explore institutions through map-based discovery.
- Build an AI education assistant that provides evidence-based answers using current data.
- Keep institution information updateable without retraining the language model.

## ✨ Planned Features

- Education-sector homepage and search bar
- Institution listings and detailed profiles
- Private, government, and affiliated college categories
- Institution comparison
- Nearby institution and map search
- Institution suggestion form and FAQs
- AI-powered conversational education assistant
- Retrieval from official admission documents

## 🛠️ Technology Stack

| Component | Technology |
|---|---|
| Frontend | HTML, CSS, JavaScript |
| Existing backend | PHP |
| Database | MySQL |
| AI service | Python, FastAPI |
| Local model runtime | Ollama |
| Initial model candidate | Qwen3 4B |
| Document retrieval (planned) | ChromaDB, Sentence Transformers |
| Collaboration | Git and GitHub |

The final implementation will be confirmed after auditing the existing codebase and database.

## 🏗️ Architecture

The frontend communicates with backend APIs. PHP handles existing website functionality, while a separate Python service handles AI conversations and approved search tools. MySQL remains the source of truth for structured institution data.

AI-generated factual answers must be grounded in retrieved records or relevant official documents.

See [`docs/architecture.md`](docs/architecture.md) for the detailed design.

## 📍 Initial Scope

The first release focuses on Chandigarh, Mohali, and Panchkula.

## 👥 Team Collaboration

- GitHub Issues track tasks and bugs.
- Feature branches isolate development work.
- Pull requests are reviewed before merging.
- The `main` branch should remain stable.
- Secrets, credentials, and private data must never be committed.

## 🚧 Project Status

**Current phase:** Repository setup, architecture documentation, and existing-application audit.

Features listed above are planned unless explicitly marked as implemented.

## 📄 License

To be decided before public release.
