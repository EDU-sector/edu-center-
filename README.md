# EduTricity 🎓

**Education Discovery and Comparison Platform**

EduTricity is a collaborative project to help students discover, explore, and compare educational institutions across Chandigarh, Mohali (SAS Nagar), and Panchkula.

## Objectives

- Discover schools, colleges, universities, coaching institutes, and skill-development institutes.
- Search and filter institutions by location and category.
- Compare institutions using available course, fee, and general institutional information.
- Explore institutions through a clean, searchable landing page.
- Allow users to suggest missing institutions.

## Technology Stack

| Component | Technology |
|---|---|
| Frontend | HTML, CSS, JavaScript |
| Backend | PHP |
| Database | MySQL |
| Rendering model | DOM-based server-rendered pages |
| Collaboration | Git and GitHub |

## Architecture

The project uses a straightforward PHP + MySQL architecture:

- PHP handles page rendering and backend logic.
- MySQL stores institutions, categories, locations, and suggestions.
- HTML + CSS render the user interface.
- JavaScript adds lightweight frontend interactivity.

See [`docs/architecture.md`](docs/architecture.md) for the full architecture overview.

## Project Structure

```text
project/
├── config/
│   └── database.php
├── database/
│   └── schema.sql
├── includes/
│   ├── header.php
│   └── footer.php
├── assets/
│   ├── css/
│   └── js/
├── index.php
├── process-suggestion.php
├── README.md
├── docs/
│   └── architecture.md
└── .gitignore
```

## Current Status

The project is currently focused on:
- institution discovery
- institutional search/filtering
- PHP + MySQL-backed data flow
- suggestion submission handling
- comparison-focused landing page experience

This project does not include a chatbot or AI service in the current stack.
