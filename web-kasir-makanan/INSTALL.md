# 📦 PANDUAN INSTALASI CEPAT

## Quick Start (5 Menit)

### 1. Extract & Install Dependencies
```bash
cd web-kasir-makanan
composer install
npm install
```

### 2. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Konfigurasi Database
Edit `.env`:
```
DB_DATABASE=web_kasir_makanan
DB_USERNAME=root
DB_PASSWORD=your_password
```

Buat database:
```bash
mysql -u root -p
CREATE DATABASE web_kasir_makanan;
exit;
```

### 4. Migrasi & Seed
```bash
php artisan migrate
php artisan db:seed
```

### 5. Build & Run
```bash
npm run build
php artisan storage:link
php artisan serve
```

### 6. Login
Buka: http://localhost:8000

**Demo Account:**
- Email: `kasir@kasir.com`
- Password: `password`

## ✅ Selesai!

Aplikasi siap digunakan. Lihat README.md untuk dokumentasi lengkap.

## 🆘 Troubleshooting

**Error: composer not found**
```bash
# Install composer terlebih dahulu
# https://getcomposer.org/download/
```

**Error: npm not found**
```bash
# Install Node.js & npm terlebih dahulu
# https://nodejs.org/
```

**Error: Database connection**
- Pastikan MySQL sudah running
- Cek kredensial di file .env
- Pastikan database sudah dibuat

**Error: Permission denied**
```bash
chmod -R 755 storage bootstrap/cache
```
