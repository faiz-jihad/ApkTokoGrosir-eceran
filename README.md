# 📊 Toko Roni - Sistem Manajemen Toko Retail

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.x-7952B3?style=for-the-badge&logo=bootstrap)
![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1?style=for-the-badge&logo=mysql)
![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php)

**Sistem Manajemen Toko Retail** yang komprehensif dengan fitur multi-role, manajemen produk, transaksi, dan laporan keuangan.

## 🌟 Fitur Utama

### 👥 **Manajemen Pengguna Multi-Role**
- **Owner** - Akses penuh sistem
- **Kasir** - Proses transaksi dan penjualan
- **Gudang** - Manajemen stok produk
- Autentikasi dengan Laravel Breeze
- Manajemen profil pengguna

### 🛒 **Manajemen Produk**
- CRUD produk lengkap
- Sistem kategori produk
- Manajemen stok real-time
- Upload gambar produk
- Riwayat stok masuk/keluar

### 💰 **Sistem Transaksi**
- POS (Point of Sale) modern
- Multi-item checkout
- Cetak struk transaksi
- Riwayat transaksi lengkap
- Filter berdasarkan tanggal

### 📈 **Laporan & Analytics**
- Dashboard statistik real-time
- Laporan penjualan harian/bulanan
- Grafik pendapatan
- Export data ke Excel/PDF
- Statistik produk terlaris

### 🔧 **Manajemen Pengguna (Admin)**
- ![Tabel Pengguna](https://img.shields.io/badge/📋-Tabel_Pengguna-blue)
- ![Filter Lanjutan](https://img.shields.io/badge/🔍-Filter_Lanjutan-green)
- ![Bulk Actions](https://img.shields.io/badge/⚡-Bulk_Actions-orange)
- ![Export Data](https://img.shields.io/badge/📊-Export_Data-purple)
- ![Multi-Role](https://img.shields.io/badge/👥-Multi_Role-yellow)

## 🚀 Instalasi & Setup

### Prerequisites
- PHP 8.2+
- Composer 2.0+
- MySQL 8.0+
- Node.js 18+ & NPM

### Langkah Instalasi

1. **Clone Repository**
```bash
git clone https://github.com/yourusername/toko-roni.git
cd toko-roni
```

2. **Instal Dependencies**
```bash
composer install
npm install
npm run build
```

3. **Setup Environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Konfigurasi Database**
```bash
# Edit .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=toko_roni
DB_USERNAME=root
DB_PASSWORD=
```

5. **Migrasi Database**
```bash
php artisan migrate
php artisan db:seed
```

6. **Jalankan Server**
```bash
php artisan serve
```

7. **Akses Aplikasi**
```
http://localhost:8000
```

### Akun Default
```
Owner:
Email: owner@toko.com
Password: password

Kasir:
Email: kasir@toko.com
Password: password

Gudang:
Email: gudang@toko.com
Password: password
```

## 🏗️ Arsitektur Teknis

### Struktur Direktori
```
toko-roni/
├── app/
│   ├── Http/Controllers/
│   │   ├── UserController.php      # Manajemen pengguna
│   │   ├── ProductController.php   # Manajemen produk
│   │   ├── TransactionController.php # Sistem transaksi
│   │   └── DashboardController.php # Dashboard & laporan
│   ├── Models/
│   │   ├── User.php
│   │   ├── Product.php
│   │   └── Transaction.php
│   └── Http/Middleware/
│       └── RoleMiddleware.php      # Middleware multi-role
├── resources/
│   ├── views/
│   │   ├── users/                  # UI manajemen pengguna
│   │   ├── products/              # UI produk
│   │   ├── transactions/          # UI transaksi
│   │   └── layouts/               # Template layout
│   └── css/
│       └── app.css               # Custom styling
├── database/
│   ├── migrations/
│   └── seeders/
└── routes/
    └── web.php                    # Routing aplikasi
```

### Teknologi Stack
- **Backend**: Laravel 12, PHP 8.4
- **Frontend**: Bootstrap 5, jQuery, Chart.js
- **Database**: MySQL 8.0
- **Auth**: Laravel Breeze
- **Export**: Laravel Excel, DomPDF
- **Icons**: Font Awesome 6

## 📱 Fitur UI/UX

### Dashboard Interaktif
![Dashboard Preview](https://via.placeholder.com/800x400/667eea/ffffff?text=Dashboard+Toko+Roni)

### Manajemen Pengguna
```html
<!-- Fitur Unggulan -->
✅ Filter multi-kriteria
✅ Search real-time
✅ Bulk operations
✅ Export data
✅ Responsive design
✅ Animasi smooth
✅ Dark/Light mode ready
```

### Komponen UI
- **Cards** dengan gradient dan shadow
- **Tables** dengan hover effects
- **Modals** dengan animasi
- **Forms** dengan validasi real-time
- **Charts** interaktif
- **Notifications** toast

## 🔒 Keamanan

### Fitur Keamanan
- ✅ **Authentication** - Laravel Breeze
- ✅ **Authorization** - Middleware multi-role
- ✅ **CSRF Protection** - Built-in Laravel
- ✅ **XSS Protection** - Blade templating
- ✅ **SQL Injection** - Eloquent ORM
- ✅ **Input Validation** - Form request validation
- ✅ **File Upload Security** - MIME type validation

### Role-Based Access Control
```php
// Middleware Role
Route::middleware(['auth', 'role:owner'])->group(function () {
    // Routes khusus owner
});

Route::middleware(['auth', 'role:kasir,owner'])->group(function () {
    // Routes untuk kasir dan owner
});
```

## 📊 Database Schema

### Tabel Utama
```sql
-- Users Table
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('owner', 'kasir', 'gudang') DEFAULT 'kasir',
    is_active BOOLEAN DEFAULT true,
    image VARCHAR(255) NULL,
    phone VARCHAR(20) NULL,
    last_login_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Products Table
CREATE TABLE products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    min_stock INT NOT NULL DEFAULT 10,
    image VARCHAR(255) NULL,
    description TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Transactions Table
CREATE TABLE transactions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    invoice VARCHAR(50) UNIQUE NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    total DECIMAL(12,2) NOT NULL,
    cash DECIMAL(12,2) NOT NULL,
    change DECIMAL(12,2) NOT NULL,
    items JSON NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

## 🎨 Custom Styling

### Theme Colors
```css
:root {
    --primary: #667eea;
    --secondary: #764ba2;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --dark: #1f2937;
    --light: #f9fafb;
}
```

### Components
```css
/* Card dengan efek hover */
.card-hover {
    transition: transform 0.3s, box-shadow 0.3s;
}
.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

/* Tombol gradient */
.btn-gradient {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: white;
    border: none;
}
```

## 🚦 Development

### Development Commands
```bash
# Jalankan development server
php artisan serve

# Compile assets
npm run dev

# Watch untuk perubahan
npm run watch

# Build untuk production
npm run build

# Jalankan tests
php artisan test

# Clear cache
php artisan optimize:clear
```

### Coding Standards
```bash
# Format kode PHP
./vendor/bin/pint

# Analisis kode
./vendor/bin/phpstan analyse

# Cek coding style
./vendor/bin/phpcs
```

## 📈 Performance Optimization

### Teknik Optimasi
- **Lazy Loading** untuk gambar
- **Pagination** untuk data besar
- **Caching** dengan Redis
- **Database Indexing**
- **Minified Assets**
- **HTTP/2 Support**

### Best Practices
- ✅ Gunakan Eloquent Relationships
- ✅ Implementasi Eager Loading
- ✅ Gunakan Queue untuk tugas berat
- ✅ Cache data statis
- ✅ Optimasi queries

## 🔧 Troubleshooting

### Common Issues & Solutions

1. **Route not found error**
```bash
php artisan route:clear
php artisan cache:clear
```

2. **Migration error**
```bash
php artisan migrate:fresh --seed
```

3. **Composer dependencies error**
```bash
composer install --no-dev --optimize-autoloader
```

4. **Asset compilation error**
```bash
npm install --force
npm run build
```

### Debug Mode
```env
APP_DEBUG=true
APP_ENV=local
```

## 🤝 Kontribusi

### Guidelines
1. Fork repository
2. Create feature branch
3. Commit perubahan
4. Push ke branch
5. Create Pull Request

### Branch Naming
```
feature/     # New features
bugfix/      # Bug fixes
hotfix/      # Critical fixes
improvement/ # Improvements
```

## 📄 Lisensi

MIT License - lihat [LICENSE](LICENSE) untuk detail

## 👨‍💻 Tim Pengembang

- **Project Lead** - Faiz Jihad A
- **Backend Developer** - Ivan Febriansyah
- **Frontend Developer** - Tino NC
- **UI/UX Designer** - Affan R

## 📞 Kontak & Support

- **Email**: faizalba74@gmail.com
- **Issues**: [GitHub Issues](https://github.com/yourusername/toko-roni/issues)
- **Documentation**: [Wiki](https://github.com/yourusername/toko-roni/wiki)

---

<div align="center">
  <p>Dibuat dengan ❤️ menggunakan Laravel & Bootstrap</p>
  
  ![Statistik](https://img.shields.io/badge/⚡-Production_Ready-success)
  ![Versi](https://img.shields.io/badge/🚀-v1.0.0-blue)
  ![Status](https://img.shields.io/badge/✅-Active_Development-brightgreen)
</div>

## 📱 Screenshots

### Login Page
![Login](https://via.placeholder.com/400x250/667eea/ffffff?text=Login+Page)

### Dashboard
![Dashboard](https://via.placeholder.com/400x250/10b981/ffffff?text=Dashboard)

### Manajemen Produk
![Produk](https://via.placeholder.com/400x250/f59e0b/ffffff?text=Manajemen+Produk)

### Point of Sale
![POS](https://via.placeholder.com/400x250/ef4444/ffffff?text=Point+of+Sale)

---

**Toko Roni** © 2024 - Sistem Manajemen Toko Retail Terintegrasi
