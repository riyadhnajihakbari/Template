# Web Kasir Makanan - Offline-First POS System

![Version](https://img.shields.io/badge/version-1.1.0-blue)
![Laravel](https://img.shields.io/badge/Laravel-10-red)
![PWA](https://img.shields.io/badge/PWA-Ready-green)

Aplikasi Point of Sale (POS) berbasis web dengan kemampuan offline-first menggunakan Progressive Web App (PWA), dibangun dengan Laravel 10 dan Tailwind CSS.

## 🚀 Fitur Utama

### Core Features
- ✅ **Multi-user Login** dengan role-based access (Kasir, Koki, Manajer, Admin)
- ✅ **Dashboard Penjualan** dengan statistik real-time
- ✅ **POS Screen** untuk input pesanan cepat dan intuitif
- ✅ **Manajemen Menu** (kategori, item, harga, stok)
- ✅ **Pembayaran Multi-method** (Tunai, QRIS, Debit, Credit)
- ✅ **Cetak Struk** otomatis setelah pembayaran
- ✅ **Laporan Penjualan** harian, mingguan, bulanan

### Offline Capabilities
- 🔄 **PWA Support** - Install di device seperti aplikasi native
- 💾 **IndexedDB Storage** - Data tersimpan lokal menggunakan Dexie.js
- 📦 **Service Worker Caching** - Cache assets dan API responses
- 🔁 **Auto Background Sync** - Sinkronisasi otomatis saat online
- 🖨️ **Offline Receipt Printing** - Cetak struk tanpa koneksi internet

### Advanced Features
- 📊 Menu populer dan statistik penjualan
- 🏪 Support untuk meja, takeaway, dan delivery
- 📱 Responsive design untuk tablet dan desktop
- 🎨 Modern UI dengan Tailwind CSS
- 🔒 Secure authentication dengan Laravel Sanctum

## 📋 Requirements

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL/MariaDB >= 5.7
- Web server (Apache/Nginx)

## 🛠️ Instalasi

### 1. Clone atau Extract Project

```bash
cd web-kasir-makanan
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

### 3. Konfigurasi Environment

```bash
# Copy file environment
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=web_kasir_makanan
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Migrasi dan Seeding Database

```bash
# Buat database terlebih dahulu
mysql -u root -p
CREATE DATABASE web_kasir_makanan;
exit;

# Jalankan migrasi
php artisan migrate

# Seed data awal (users, categories, menu items)
php artisan db:seed
```

### 6. Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### 7. Storage Link

```bash
php artisan storage:link
```

### 8. Jalankan Aplikasi

```bash
# Development server
php artisan serve

# Aplikasi akan berjalan di http://localhost:8000
```

## 👥 Demo Accounts

Setelah seeding, gunakan akun berikut untuk login:

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@kasir.com | password |
| **Manajer** | manajer@kasir.com | password |
| **Kasir** | kasir@kasir.com | password |
| **Koki** | koki@kasir.com | password |

## 🎯 Cara Penggunaan

### Untuk Kasir

1. **Login** menggunakan akun kasir
2. Buka menu **POS / Kasir**
3. Pilih menu dengan klik pada card menu
4. Item akan masuk ke keranjang
5. Atur nomor meja jika perlu
6. Klik **Bayar Tunai** atau **Bayar QRIS**
7. Masukkan jumlah pembayaran
8. Klik **Proses** untuk menyelesaikan transaksi
9. Struk akan otomatis tercetak

### Mode Offline

1. Aplikasi tetap bisa digunakan tanpa internet
2. Transaksi akan tersimpan di IndexedDB lokal
3. Saat koneksi internet kembali, data akan otomatis tersinkronisasi
4. Indikator status online/offline ada di pojok kanan atas

### Untuk Manajer

1. **Login** sebagai manajer
2. Akses **Kelola Menu** untuk tambah/edit menu
3. Lihat **Laporan** untuk analisis penjualan
4. Monitor **Dashboard** untuk statistik real-time

## 📱 Install sebagai PWA

### Di Android (Chrome)
1. Buka aplikasi di Chrome
2. Klik menu (⋮) → "Install app" atau "Add to Home Screen"
3. Aplikasi akan muncul di app drawer

### Di iOS (Safari)
1. Buka aplikasi di Safari
2. Tap tombol Share (⬆️)
3. Scroll dan tap "Add to Home Screen"

### Di Desktop (Chrome/Edge)
1. Klik icon install (➕) di address bar
2. Atau menu → "Install Web Kasir Makanan"

## 🗂️ Struktur Database

### Tables
- `users` - Data user dengan role-based access
- `categories` - Kategori menu
- `menu_items` - Item menu dengan harga dan stok
- `orders` - Data pesanan/transaksi
- `order_items` - Detail item dalam pesanan
- `transactions` - Rekaman pembayaran

## 🔧 Konfigurasi

### Printer Settings

Edit file `.env` untuk konfigurasi printer:

```env
PRINTER_TYPE=html
PRINTER_WIDTH=58mm
```

### PWA Settings

```env
PWA_ENABLED=true
PWA_OFFLINE_MODE=true
```

## 📊 Tech Stack

- **Backend**: Laravel 10 (PHP 8.1+)
- **Frontend**: Blade Templates
- **Styling**: Tailwind CSS 3
- **JavaScript**: Vanilla JS + Dexie.js
- **Database**: MySQL/MariaDB
- **PWA**: Service Worker + IndexedDB
- **Build Tool**: Vite

## 🔐 Security

- Authentication menggunakan Laravel's built-in authentication
- CSRF protection pada semua forms
- SQL injection protection dengan Eloquent ORM
- XSS protection dengan Blade templating
- Password hashing dengan bcrypt
- Role-based access control (RBAC)

## 🚀 Deployment

### Production Setup

1. Set `APP_ENV=production` di `.env`
2. Set `APP_DEBUG=false`
3. Run `php artisan config:cache`
4. Run `php artisan route:cache`
5. Run `php artisan view:cache`
6. Set proper file permissions:
```bash
chmod -R 755 storage bootstrap/cache
```

### Recommended Hosting
- VPS (DigitalOcean, AWS, Vultr)
- Shared Hosting dengan PHP 8.1+
- Laravel Forge
- Cloudways

## 📝 License

MIT License - feel free to use for personal and commercial projects.

## 🤝 Support

Untuk bantuan dan pertanyaan:
- Email: support@example.com
- Documentation: [Link to docs]
- Issues: [Link to issues]

## 🎉 Credits

Developed with ❤️ using:
- Laravel Framework
- Tailwind CSS
- Dexie.js
- Workbox

---

**Version**: 1.1.0  
**Last Updated**: 2024

Happy selling! 🎊
