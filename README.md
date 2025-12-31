# 🏪 Aplikasi Toko Grosir & Eceran (Laravel)

Aplikasi **Manajemen Toko Grosir dan Eceran** berbasis **Laravel** yang dirancang untuk membantu pengelolaan stok barang, transaksi penjualan, keuangan, serta laporan secara **terintegrasi dan real-time**.

Aplikasi ini ditujukan untuk mempermudah operasional toko, baik **grosir** maupun **eceran**, dengan sistem multi-role yang aman dan mudah digunakan.

---

## 🚀 Fitur Utama

### 🔐 Manajemen Pengguna (Multi Role)
- Owner
- Kasir
- Gudang
- Hak akses berbasis role

### 📦 Manajemen Barang & Stok
- CRUD produk
- Stok masuk & keluar
- Update stok otomatis
- Monitoring stok real-time

### 🧾 Transaksi & POS
- Sistem kasir (Point of Sale)
- Transaksi grosir & eceran
- Cetak struk
- Riwayat transaksi

### 💰 Manajemen Keuangan
- Pemasukan
- Pengeluaran
- Rekap keuangan harian / bulanan

### 📊 Laporan & Dashboard
- Grafik penjualan
- Laporan stok
- Laporan transaksi
- Export PDF / Excel

### 🔒 Keamanan
- Authentication & Authorization
- CSRF Protection
- Validasi input
- Session management

---

## 🛠️ Teknologi yang Digunakan

- **Backend** : Laravel
- **Frontend** : Blade Template, Bootstrap, jQuery
- **Database** : MySQL
- **Chart** : Chart.js
- **Export** : PDF & Excel
- **Auth** : Laravel Authentication

---

## 📁 Struktur Project (Ringkas)

app/
├── Http/Controllers
├── Models
└── Providers

resources/
├── views
├── css
└── js

routes/
├── web.php

database/
├── migrations
└── seeders

yaml
Salin kode

---

## ⚙️ Instalasi & Menjalankan Project

### 1️⃣ Clone Repository
```bash
git clone https://github.com/faiz-jihad/ApkTokoGrosir-eceran.git
cd ApkTokoGrosir-eceran
2️⃣ Install Dependency
bash
Salin kode
composer install
npm install
npm run build
3️⃣ Konfigurasi Environment
bash
Salin kode
cp .env.example .env
php artisan key:generate
Atur database di file .env

4️⃣ Migrasi & Seeder
bash
Salin kode
php artisan migrate --seed
5️⃣ Jalankan Server
bash
Salin kode
php artisan serve
Akses aplikasi di:

cpp
Salin kode
http://127.0.0.1:8000
👤 Akun Default (Jika Ada Seeder)
Email : admin@example.com

Password : password

(Sesuaikan dengan data seeder di project)

🎯 Tujuan Pengembangan
Digitalisasi manajemen toko grosir & eceran

Mempermudah pencatatan transaksi

Mengurangi kesalahan stok manual

Menyediakan laporan yang akurat dan cepat


🤝 Kontribusi
Kontribusi sangat terbuka:

Fork repository

Buat branch fitur

Commit perubahan

Pull request

📄 Lisensi
Project ini bersifat open-source dan digunakan untuk keperluan pembelajaran dan pengembangan.

👨‍💻 Author
Faiz Jihad Albaihaqi
Mahasiswa Teknik Informatika
Politeknik Negeri Indramayu
