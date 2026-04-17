# 📦 Product Management Fullstack App

A comprehensive fullstack application for managing products with a modern decoupled architecture.

---

## 🏗 System Architecture

- 🖥 **Frontend:** Nuxt.js (Client-facing interface)
- ⚙ **Backend API:** NestJS (Core Business Logic & API)
- 🛠 **Admin Panel:** Laravel + Filament (Back-office management)
- 🗄 **Database:** PostgreSQL (Centralized storage)

---

## 🚀 Project Setup

### 1. Clone Repository

```bash
git clone https://github.com/piyo12052004/nuxt-nest-filament-product-app.git
cd nuxt-nest-filament-product-app

---

⚙️ Backend API (NestJS)

Location: be_nest-js

🔧 Setup & Run
- cd be_nest-js
- npm install
- npm run start:dev

🌐 Runs on: http://localhost:3000

---
🎨 Frontend (Nuxt.js)

Location: fe_nuxt

🔧 Setup & Run
- cd fe_nuxt
- npm install
- npm run dev

🌐 Runs on: http://localhost:3000

(Note: May default to 3001 if NestJS is using 3000)

---
🛠 Admin Panel (Laravel Filament)

Location: be_laravel

🔧 Setup Steps
cd be_laravel
cp .env.example .env
composer install
php artisan key:generate
npm install 
php artisan serve

🌐 Runs on: http://localhost:8000

---
🗄 Database Setup

Configure PostgreSQL connection in .env files:

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_password

---
🧪 Features
Frontend (Nuxt)
✨ Product list display
🔍 Search & Pagination
📦 Product detail views
📝 Add product form
---
Backend (NestJS)
🚀 High-performance REST API
🛣 GET /api/products
🛣 POST /api/products
🛡 Validation & Error handling
---
Admin (Laravel Filament)
📊 Admin dashboard
🛠 Full CRUD for products
⚡ Advanced search & filtering
⚡ Tech Stack
---
Nuxt 3
NestJS
Laravel 11
Filament Admin
PostgreSQL
Tailwind CSS
Alpine.js
---
🧠 Important Notes
Ensure all services run in separate terminal instances
NestJS should be active before Nuxt frontend fetches data
Laravel service requires a properly configured .env file
---
📌 Run Order (Recommended)
PostgreSQL (ensure service is active)
NestJS (npm run start:dev)
Laravel (php artisan serve & npm run dev)
Nuxt (npm run dev)