# 📂 Struktur Project

## Overview
```
WEB-KASIR-MAKANAN/
│
├── 📁 app/
│   ├── 📁 Console/
│   │   └── Kernel.php
│   │
│   ├── 📁 Exceptions/
│   │   └── Handler.php
│   │
│   ├── 📁 Http/
│   │   ├── 📁 Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── Controller.php
│   │   │   ├── CustomerController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── MenuController.php
│   │   │   ├── POSController.php
│   │   │   ├── ReportController.php
│   │   │   └── UserController.php
│   │   │
│   │   └── 📁 Middleware/
│   │       ├── Authenticate.php
│   │       ├── EncryptCookies.php
│   │       ├── PreventRequestsDuringMaintenance.php
│   │       ├── RedirectIfAuthenticated.php
│   │       ├── TrimStrings.php
│   │       ├── TrustHosts.php
│   │       ├── TrustProxies.php
│   │       └── ValidateSignature.php
│   │
│   ├── 📁 Models/
│   │   ├── Category.php
│   │   ├── MenuItem.php
│   │   ├── Order.php
│   │   ├── OrderItem.php
│   │   ├── Transaction.php
│   │   └── User.php
│   │
│   └── 📁 Providers/
│       ├── AppServiceProvider.php
│       ├── AuthServiceProvider.php
│       ├── BroadcastServiceProvider.php
│       ├── EventServiceProvider.php
│       └── RouteServiceProvider.php
│
├── 📁 bootstrap/
│   ├── app.php
│   └── cache/
│
├── 📁 config/
│   ├── app.php
│   ├── auth.php
│   ├── cache.php
│   ├── database.php
│   ├── filesystems.php
│   ├── logging.php
│   ├── mail.php
│   ├── queue.php
│   ├── services.php
│   ├── session.php
│   └── view.php
│
├── 📁 database/
│   ├── 📁 factories/
│   │   └── UserFactory.php
│   │
│   ├── 📁 migrations/
│   │   ├── 2024_01_01_000001_create_users_table.php
│   │   ├── 2024_01_01_000002_create_categories_table.php
│   │   ├── 2024_01_01_000003_create_menu_items_table.php
│   │   ├── 2024_01_01_000004_create_orders_table.php
│   │   ├── 2024_01_01_000005_create_order_items_table.php
│   │   ├── 2024_01_01_000006_create_transactions_table.php
│   │   └── 2025_11_09_001120_add_order_type_to_orders_table.php
│   │
│   ├── 📁 seeders/
│   │   ├── CategorySeeder.php
│   │   ├── CustomerUserSeeder.php
│   │   ├── DatabaseSeeder.php
│   │   └── MenuItemSeeder.php
│   │
│   └── .gitignore
│
├── 📁 public/
│   ├── 📁 build/
│   │   ├── 📁 assets/
│   │   └── manifest.json
│   │
│   ├── 📁 storage/
│   │   ├── 📁 menu-photos/
│   │   │   ├── nasi-goreng.jpg
│   │   │   ├── mie-goreng.jpg
│   │   │   └── ...
│   │   └── .gitignore
│   │
│   ├── .htaccess
│   ├── favicon.ico
│   ├── index.php
│   ├── manifest.json          ← PWA Manifest
│   ├── robots.txt
│   └── service-worker.js      ← PWA Service Worker
│
├── 📁 resources/
│   ├── 📁 css/
│   │   └── app.css ⚠️ (Styling utama)
│   │
│   ├── 📁 js/
│   │   ├── app.js ⚠️ (PWA, Toast, POS Logic)
│   │   ├── bootstrap.js
│   │   ├── db.js              ← IndexedDB (Offline)
│   │   └── sync.js            ← Sync offline data
│   │
│   └── 📁 views/
│       ├── 📁 auth/
│       │   └── login.blade.php
│       │
│       ├── 📁 customer/
│       │   └── menu.blade.php
│       │
│       ├── 📁 dashboard/
│       │   └── index.blade.php ⚠️
│       │
│       ├── 📁 layouts/
│       │   ├── app.blade.php ⚠️ ⚠️ ⚠️ (FILE UTAMA YANG DIPERBAIKI!)
│       │   └── customer.blade.php
│       │
│       ├── 📁 menu/
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── index.blade.php ⚠️
│       │
│       ├── 📁 pos/
│       │   └── index.blade.php ⚠️
│       │
│       ├── 📁 reports/
│       │   ├── inventory.blade.php
│       │   └── sales.blade.php
│       │
│       └── 📁 users/
│           ├── create.blade.php
│           ├── edit.blade.php
│           └── index.blade.php ⚠️
│
├── 📁 routes/
│   ├── api.php
│   ├── channels.php
│   ├── console.php
│   └── web.php ⚠️ (Route utama)
│
├── 📁 storage/
│   ├── 📁 app/
│   │   ├── 📁 public/
│   │   │   └── 📁 menu-photos/
│   │   └── .gitignore
│   │
│   ├── 📁 framework/
│   │   ├── 📁 cache/
│   │   ├── 📁 sessions/
│   │   └── 📁 views/
│   │
│   └── 📁 logs/
│       └── laravel.log
│
├── 📁 tests/
│   ├── 📁 Feature/
│   │   └── ExampleTest.php
│   │
│   └── 📁 Unit/
│       └── ExampleTest.php
│
├── 📁 vendor/ (Composer dependencies)
│
├── .env ⚠️ (Konfigurasi database & app)
├── .env.example
├── .gitattributes
├── .gitignore
├── artisan
├── composer.json
├── composer.lock
├── package.json ⚠️ (NPM dependencies)
├── package-lock.json
├── phpunit.xml
├── postcss.config.js
├── README.md
├── tailwind.config.js ⚠️ (Tailwind CSS config)
├── TROUBLESHOOTING.md
└── vite.config.js ⚠️ (Vite bundler config)
## 🎯 File Penting

### Backend (PHP/Laravel)

#### Controllers
- `AuthController.php` - Handle login/logout
- `DashboardController.php` - Dashboard & statistik
- `POSController.php` - Point of Sale logic
- `MenuController.php` - CRUD menu items
- `ReportController.php` - Generate reports

#### Models
- `User.php` - User dengan role-based access
- `MenuItem.php` - Menu items dengan kategori
- `Order.php` - Pesanan/transaksi
- `OrderItem.php` - Detail item dalam order
- `Transaction.php` - Payment records
- `Category.php` - Kategori menu

#### Middleware
- `RoleMiddleware.php` - Check user role access

### Frontend

#### JavaScript
- `app.js` - Main JavaScript dengan POS functions
- `db.js` - IndexedDB setup menggunakan Dexie
- `sync.js` - Offline sync mechanism
- `bootstrap.js` - Axios HTTP client setup

#### CSS
- `app.css` - Tailwind + custom styles untuk POS

#### Views (Blade Templates)
- `layouts/app.blade.php` - Main layout dengan sidebar
- `auth/login.blade.php` - Login page
- `dashboard/index.blade.php` - Dashboard dengan stats
- `pos/index.blade.php` - POS screen (kasir)
- `menu/index.blade.php` - Menu management

### Database

#### Migrations
1. `create_users_table` - User accounts
2. `create_categories_table` - Menu categories
3. `create_menu_items_table` - Menu items
4. `create_orders_table` - Orders/transactions
5. `create_order_items_table` - Order details
6. `create_transactions_table` - Payment records

#### Seeder
- `DatabaseSeeder.php` - Demo data:
  - 4 users (admin, manajer, kasir, koki)
  - 4 categories (Makanan, Minuman, Snack, Dessert)
  - 16 menu items dengan harga dan stok

### Configuration

#### Environment (.env)
- Database credentials
- App settings
- PWA & Printer settings

#### Build Tools
- `tailwind.config.js` - Tailwind CSS config
- `vite.config.js` - Vite build config
- `postcss.config.js` - PostCSS config
- `package.json` - NPM dependencies
- `composer.json` - PHP dependencies

## 🔄 Alur Data

### Online Mode
```
User Input → Controller → Model → Database → Response → View
```

### Offline Mode
```
User Input → IndexedDB (Local) → Queue for Sync
         ↓
    When Online → Sync to Server → Database
```

## 🛠️ Teknologi yang Digunakan

### Backend
- **Laravel 10** - PHP Framework
- **MySQL** - Database
- **Eloquent ORM** - Database abstraction

### Frontend
- **Blade Templates** - Templating engine
- **Tailwind CSS** - Utility-first CSS
- **Vanilla JavaScript** - No framework, pure JS
- **Dexie.js** - IndexedDB wrapper

### PWA Features
- **Service Worker** - Offline caching
- **IndexedDB** - Local storage
- **Web App Manifest** - Install as app
- **Background Sync** - Auto sync when online

## 📱 User Roles & Permissions

### Admin
- Full access ke semua fitur
- Konfigurasi sistem
- Backup & restore

### Manajer
- Kelola menu & harga
- Lihat semua laporan
- Atur user & shift

### Kasir
- Buat pesanan
- Proses pembayaran
- Cetak struk
- Lihat laporan sederhana

### Koki
- Lihat tiket dapur
- Update status pesanan

## 🔐 Security Features

- ✅ CSRF Protection
- ✅ SQL Injection Protection (Eloquent)
- ✅ XSS Protection (Blade escaping)
- ✅ Password Hashing (bcrypt)
- ✅ Role-Based Access Control
- ✅ Session Management
- ✅ Input Validation

## 📊 Database Relations

```
User (1) ─── (N) Order
Category (1) ─── (N) MenuItem
Order (1) ─── (N) OrderItem
MenuItem (1) ─── (N) OrderItem
Order (1) ─── (1) Transaction
```

## 🎨 UI Components

### Reusable Classes (Tailwind)
- `.btn-primary` - Primary button
- `.btn-secondary` - Secondary button
- `.btn-success` - Success button (hijau)
- `.btn-danger` - Danger button (merah)
- `.card` - Card container
- `.menu-item-card` - Menu item card
- `.status-badge` - Status indicator
- `.input-field` - Input field styling

## 🚀 Deployment Checklist

1. ✅ Set `APP_ENV=production`
2. ✅ Set `APP_DEBUG=false`
3. ✅ Run `php artisan config:cache`
4. ✅ Run `php artisan route:cache`
5. ✅ Run `php artisan view:cache`
6. ✅ Run `npm run build`
7. ✅ Set file permissions (755)
8. ✅ Configure web server
9. ✅ Setup SSL certificate
10. ✅ Backup database

---

**Note**: Struktur ini mengikuti best practices Laravel 10 dan PWA development.
