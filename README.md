# Laravel + Vue Fullstack boilerplate

## WebMobUi - Media Engineering - HEIG-VD

This is a fullstack Laravel and Vue.js boilerplate for the course

### Installation

# 1. Create a folder for the project

```bash
mkdir YourAppName
cd YourAppName
```

### 2. Clone the repository and chage the upstream to your oww repository (create it on GitHub first)

```bash
git clone https://github.com/Chabloz/WebMobUI52-fullstack.git .
git remote set-url origin https://github.com/YourGitHubUsername/YourAppName.git
```

### 3. Install the dependencies

```bash
npm install
npm run build
composer install
```

### 4. Copy the example environment file

```bash
cp .env.example .env
```

And edit the `.env` file to configure the database connection and other settings (if needed, sqlite is used by default).

### 5. Generate the application key and run the migrations

```bash
php artisan key:generate
php artisan migrate
```

### 6. Run the application

```bash
composer run dev
```