# 🔧 Troubleshooting Guide

## Error yang Sering Terjadi dan Solusinya

### 1. Error: "Method configure does not exist"
**Penyebab**: File bootstrap/app.php menggunakan syntax Laravel 11  
**Solusi**: Sudah diperbaiki! File bootstrap/app.php sekarang menggunakan format Laravel 10

### 2. Error saat `composer install`

#### A. "composer not found"
```bash
# Download dan install Composer
# Windows: https://getcomposer.org/Composer-Setup.exe
# Linux/Mac:
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

#### B. "requires ext-xxx"
```bash
# Install PHP extensions yang diperlukan
# Untuk Ubuntu/Debian:
sudo apt-get install php8.1-mbstring php8.1-xml php8.1-curl php8.1-zip

# Untuk Windows dengan XAMPP:
# Edit php.ini dan uncomment extension yang diperlukan
```

### 3. Error saat `npm install`

#### "npm not found"
```bash
# Install Node.js (termasuk npm)
# Download dari: https://nodejs.org/
# Pilih versi LTS (Long Term Support)
```

#### "EACCES permission denied"
```bash
# Linux/Mac:
sudo npm install -g npm
# Atau gunakan nvm (Node Version Manager)
```

### 4. Database Connection Errors

#### "SQLSTATE[HY000] [1045] Access denied"
**Solusi**:
1. Cek kredensial di file `.env`
2. Pastikan MySQL sudah running
3. Test koneksi:
```bash
mysql -u root -p
# Masukkan password
```

#### "SQLSTATE[HY000] [2002] Connection refused"
**Solusi**:
1. Start MySQL service:
```bash
# Windows (XAMPP):
# Buka XAMPP Control Panel → Start MySQL

# Linux:
sudo service mysql start

# Mac:
brew services start mysql
```

#### "Database 'web_kasir_makanan' doesn't exist"
**Solusi**:
```bash
mysql -u root -p
CREATE DATABASE web_kasir_makanan;
exit;
```

### 5. Migration Errors

#### "Class not found" saat migrate
**Solusi**:
```bash
composer dump-autoload
php artisan migrate
```

#### "Foreign key constraint fails"
**Solusi**:
```bash
# Drop semua tabel dan migrate ulang
php artisan migrate:fresh
php artisan db:seed
```

### 6. Permission Errors

#### "The stream or file could not be opened"
**Solusi Linux/Mac**:
```bash
sudo chmod -R 755 storage bootstrap/cache
sudo chown -R $USER:www-data storage bootstrap/cache
```

**Solusi Windows**:
- Klik kanan folder → Properties → Security
- Beri full control ke user Anda

### 7. Vite/Asset Errors

#### "Vite manifest not found"
**Solusi**:
```bash
# Build assets terlebih dahulu
npm run build

# Atau untuk development:
npm run dev
```

#### "npm ERR! missing script: dev"
**Solusi**:
```bash
# Install dependencies dulu
npm install
# Kemudian:
npm run dev
```

### 8. .env Errors

#### "APP_KEY not set"
**Solusi**:
```bash
php artisan key:generate
```

#### "Environment file not found"
**Solusi**:
```bash
cp .env.example .env
php artisan key:generate
```

### 9. Route Errors

#### "Route not defined"
**Solusi**:
```bash
php artisan route:clear
php artisan route:cache
```

### 10. View Errors

#### "View not found"
**Solusi**:
```bash
php artisan view:clear
# Pastikan file blade ada di resources/views/
```

### 11. Seeder Errors

#### "Class DatabaseSeeder does not exist"
**Solusi**:
```bash
composer dump-autoload
php artisan db:seed
```

### 12. Storage Link Error

#### "The [public/storage] link already exists"
**Solusi**:
```bash
# Windows:
rmdir public\storage
php artisan storage:link

# Linux/Mac:
rm public/storage
php artisan storage:link
```

### 13. Session Errors

#### "Session store not set"
**Solusi**:
```bash
# Pastikan SESSION_DRIVER di .env
SESSION_DRIVER=file

# Clear cache
php artisan cache:clear
php artisan config:clear
```

### 14. PWA Not Working

#### Service Worker tidak register
**Solusi**:
1. Pastikan akses via HTTPS atau localhost
2. Clear browser cache
3. Cek console browser untuk error
4. Pastikan file `public/service-worker.js` ada

### 15. Port Already in Use

#### "Port 8000 is already in use"
**Solusi**:
```bash
# Gunakan port lain
php artisan serve --port=8001

# Atau kill process di port 8000:
# Windows:
netstat -ano | findstr :8000
taskkill /PID [PID_NUMBER] /F

# Linux/Mac:
lsof -ti:8000 | xargs kill -9
```

## 📝 Checklist Instalasi

Pastikan sudah melakukan langkah-langkah ini:

- [ ] PHP 8.1+ terinstall
- [ ] Composer terinstall
- [ ] Node.js & npm terinstall
- [ ] MySQL/MariaDB terinstall dan running
- [ ] File .env sudah dikonfigurasi
- [ ] Database sudah dibuat
- [ ] `composer install` berhasil
- [ ] `npm install` berhasil
- [ ] `php artisan key:generate` berhasil
- [ ] `php artisan migrate` berhasil
- [ ] `php artisan db:seed` berhasil
- [ ] `npm run build` berhasil
- [ ] `php artisan storage:link` berhasil

## 🆘 Masih Error?

### Clear All Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
composer dump-autoload
```

### Fresh Install
```bash
# Hapus semua cache dan dependencies
rm -rf vendor node_modules
rm composer.lock package-lock.json

# Install ulang
composer install
npm install
npm run build

# Reset database
php artisan migrate:fresh --seed
```

### Debug Mode
Edit `.env`:
```
APP_DEBUG=true
APP_ENV=local
```

Kemudian cek error di browser atau di `storage/logs/laravel.log`

## 📞 Support

Jika masih mengalami masalah:
1. Cek file `storage/logs/laravel.log`
2. Gunakan `php artisan tinker` untuk debug
3. Enable error reporting di `.env`

---

**Note**: Pastikan requirement system terpenuhi sebelum instalasi!
