# 📂 Struktur Project

## Overview
```
web-kasir-makanan/
├── app/                    # Core aplikasi Laravel
│   ├── Http/
│   │   ├── Controllers/    # Controllers untuk handle request
│   │   └── Middleware/     # Middleware (autentikasi, role)
│   └── Models/            # Eloquent Models (User, Order, Menu, dll)
├── bootstrap/             # Bootstrap Laravel
├── config/                # File konfigurasi
├── database/              # Database migrations & seeders
│   ├── migrations/        # Schema database
│   └── seeders/          # Data awal (demo accounts, menu)
├── public/                # Public assets & entry point
│   ├── css/              # Compiled CSS
│   ├── js/               # Compiled JavaScript
│   ├── images/           # Images & icons
│   ├── service-worker.js # PWA Service Worker
│   ├── index.php         # Entry point aplikasi
│   └── .htaccess         # Apache configuration
├── resources/             # Source files
│   ├── css/              # Tailwind CSS source
│   ├── js/               # JavaScript source
│   │   ├── app.js        # Main JS file
│   │   ├── db.js         # IndexedDB setup
│   │   ├── sync.js       # Offline sync logic
│   │   └── bootstrap.js  # Axios setup
│   └── views/            # Blade templates
│       ├── layouts/      # Layout templates
│       ├── auth/         # Login pages
│       ├── dashboard/    # Dashboard views
│       ├── pos/          # POS screen
│       ├── menu/         # Menu management
│       └── reports/      # Reports views
├── routes/                # Route definitions
│   └── web.php           # Web routes
├── storage/               # Storage files
│   ├── app/              # Uploaded files
│   ├── framework/        # Cache, sessions
│   └── logs/             # Log files
├── .env.example          # Environment template
├── composer.json         # PHP dependencies
├── package.json          # Node dependencies
├── tailwind.config.js    # Tailwind configuration
├── vite.config.js        # Vite build configuration
├── README.md             # Dokumentasi lengkap
└── INSTALL.md            # Panduan instalasi cepat
```

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
