# 🧾 POS Backend - Laravel Project

Ini adalah backend sistem Point of Sale (POS) berbasis Laravel. Project ini mencakup manajemen produk, pengguna, transaksi, dan pelaporan berbasis API serta dashboard admin.

---

## 🔗 Demo

---

## 🚀 Fitur Utama

-   Manajemen Produk, Kategori, dan Pengguna
-   Autentikasi dan Role-based Access
-   CRUD Produk dan Pengguna
-   Transaksi dan Riwayat Pesanan
-   Laporan Penjualan
-   API JSON untuk frontend Flutter
-   Middleware proteksi akses
-   Seeder untuk data awal

---

## 🛠️ Cara Install (Local Development)

### 1. Clone Repositori

```bash
git clone https://github.com/LemanArt/POS-Backend.git
cd POS-Backend
```

### 2. Install Dependency

```bash
composer install
```

### 3. Copy File `.env` dan Generate App Key

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi `.env`

Edit file `.env` untuk menyesuaikan dengan koneksi database kamu:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pos_backend
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Migrasi & Seeder

```bash
php artisan migrate
php artisan db:seed
```

### 6. Optimasi Aplikasi (Opsional)

```bash
php artisan optimize
```

### 7. Jalankan Server

```bash
php artisan serve
```

Buka browser ke: [http://localhost:8000](http://localhost:8000)

---

## 🔑 Login Default (Seeder)

```txt
Email: admin@example.com
Password: password
```

---

## 🧰 Tools & Teknologi

-   Laravel 10+
-   Blade Template
-   Laravel Seeder
-   Laravel Migration
-   MySQL/MariaDB
-   REST API (untuk frontend Flutter)

---

## Create Image For Deploy

```bash
docker login # once
username=mydockerhubuser version=1.0 ./deploy.sh
```

## 📄 License

MIT © LemanArt
