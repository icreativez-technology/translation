# 🌐 Translation Manager

A simple and efficient translation management system built with **Laravel 12**, **Inertia.js**, **Vue 3**, and **TailwindCSS**. Easily manage your app's translations in multiple languages via a web interface.

---

## 📁 Installation Guide

Follow the steps below to install and run this project locally.

### 🔧 Requirements

- PHP >= 8.2
- Composer >= 2.x
- Node.js >= 18.x
- NPM or Yarn
- MySQL / MariaDB
- Git

---

### 🚀 Setup Steps

1. **Clone the Repository**

```bash
git clone https://github.com/icreativez-technology/translation.git
cd translation

Install PHP Dependencies

bash
Copy
Edit
composer install

Install JavaScript Dependencies

bash
Copy
Edit
npm install
# OR
yarn

Copy .env and Set App Key

bash
Copy
Edit
cp .env.example .env
php artisan key:generate
Configure Database

Edit your .env file:

ini
Copy
Edit
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
Run Migrations and Seeders

bash
Copy
Edit
php artisan migrate


Run with custom count and batch size:

bash
php artisan translations:seed --count=100000 --batch=10000

Build Frontend Assets

bash
Copy
Edit
npm run build
# OR during development
npm run dev
Run the Development Server

bash
Copy
Edit
php artisan serve
Visit: http://localhost:8000

📂 Project Structure
app/Models/Translation.php – Translation model

resources/js/Pages/Translations – Vue components

routes/web.php – All translation routes

app/Http/Controllers/TranslationController.php – Controller logic


