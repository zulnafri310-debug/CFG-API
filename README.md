# Context-Free Grammar (CFG) Dialogue API

A procedural, surreal text generation REST API built with Laravel, inspired by games like *Hylics*. 

The engine uses Context-Free Grammar (CFG) expansion, tree pruning, backtracking with failure recovery, weighted random sampling, deterministic seeding, and a regex-based phonetic post-processor ("car wash").

---

## 🌟 Key Features

1. **Recursive CFG Engine:** Recursively expands non-terminal `{tags}` into terminal words using database-driven production rules.
2. **Tree Pruning:** Depth-limiting guards prevent runaway recursion and stack overflows.
3. **Backtracking & Safety Fallbacks:** Gracefully recovers and self-heals when encountering missing or empty word categories.
4. **Weighted Sampling:** Raffle-ticket algorithms ensure rare, mystical words stay rare while common words provide structure.
5. **Deterministic Seeding:** Pass a `seed` parameter to reproduce the exact same procedural sentence across runs and players.
6. **Grammar Post-Processor ("The Car Wash"):**
   - Resolves *"a"* vs. *"an"* phonetic assimilation (`\b(a)\s+([aeiou])/i`).
   - Collapses accidental multi-spaces and floating punctuation.
   - Crushes duplicate punctuation marks.
   - Trims edges, capitalizes the first letter, and guarantees terminal punctuation.
7. **Full RESTful Management:** CRUD endpoints for words, categories, and grammar templates.

---

## 🚀 Quick Start

### 1. Install Dependencies
```bash
composer install
```

### 2. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Run Migrations & Seeders
```bash
php artisan migrate --seed
```

### 4. Start Local Server
```bash
php artisan serve
```

---

## 📡 API Endpoints

### 🎲 Dialogue Generation

#### `GET /api/dialogue/generate`
Generates procedural dialogue lines.

**Query Parameters:**
| Parameter | Type | Default | Description |
| :--- | :--- | :--- | :--- |
| `count` | integer (1–10) | `1` | Number of dialogue lines to generate. |
| `seed` | integer | `null` | Optional seed for deterministic reproduction. |
| `group` | string | `null` | Filter by archetype group (e.g. `ominous`, `cryptic`, `prophecy`). |

**Example Request:**
```http
GET /api/dialogue/generate?count=2&group=cryptic
```

**Example Response:**
```json
{
  "status": "success",
  "count": 2,
  "seed": null,
  "group": "cryptic",
  "dialogue": [
    "Decant the visage before your visage turns to fibrous loam.",
    "Never pour tea across the clay cavern."
  ]
}
```

---

### 📚 Management Endpoints (CRUD)

| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `GET` | `/api/category` | List all categories with word counts |
| `POST` | `/api/category` | Create a new word category |
| `GET` | `/api/word` | List words (filter with `?category_id=`) |
| `POST` | `/api/word` | Add a new word with weight |
| `GET` | `/api/grammar-template` | List templates (filter with `?group=`) |
| `POST` | `/api/grammar-template` | Create a new template pattern |

---

## 📜 License
Open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
