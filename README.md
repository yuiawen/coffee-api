
# ☕ Caffe Lento - Admin Panel & API

![CI](https://img.shields.io/badge/CodeIgniter-4-orange) ![PHP](https://img.shields.io/badge/PHP-8.2-blue)

Aplikasi web **hybrid** yang dibangun dengan CodeIgniter 4. Proyek ini menyediakan dua fitur utama:
1.  **Dashboard Admin**: Antarmuka web (MVC) untuk manajemen produk kopi dan makanan.
2.  **RESTful API**: Endpoint JSON untuk diakses oleh aplikasi frontend terpisah.

---

## 🚀 Fitur

- ✅ **Dashboard Admin Lengkap**: Tampilan web untuk mengelola data.
- 🔐 **Otentikasi JWT**: Mengamankan endpoint API menggunakan JSON Web Token.
- ☕ **CRUD Kopi**: Manajemen penuh untuk data produk kopi.
- 🍔 **CRUD Makanan**: Manajemen penuh untuk data produk makanan.
- 🔍 **Pencarian & Paginasi**: Fitur pencarian dan paginasi di halaman daftar produk.
- 📡 **RESTful API**: Menyediakan data JSON untuk aplikasi lain.
- 🧩 **Struktur Folder Rapi**: Pemisahan controller untuk `Web` dan `Api`.

---

## 📦 Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/yuiawen/coffee-api.git
cd coffee-api
```

### 2. Install Dependencies

Pastikan Anda telah menginstal [Composer](https://getcomposer.org/).

```bash
composer install
composer require fluent/cors firebase/php-jwt
```

### 3. Konfigurasi Lingkungan (.env)

Salin file contoh konfigurasi:

```bash
cp .env.example .env
```

Lalu sesuaikan dengan pengaturan lokal Anda:

```dotenv
database.default.hostname = localhost
database.default.database = coffee_db
database.default.username = root
database.default.password = 
app.baseURL = http://localhost:8080/
JWT_SECRET = rahasia_jwt_anda
JWT_ISSUER = kopi-api
```

### 4. Generate App Key

```bash
php spark key:generate
```

### 5. Migrasi Database

```bash
php spark migrate
```

### 6. Jalankan Server

```bash
php spark serve
```

Aplikasi dapat diakses melalui `http://localhost:8080`.

---

## 🧪 Testing (API)

Gunakan Postman atau REST Client lainnya.

**Contoh Login:**
```
POST http://localhost:8080/api/login
```

**Body (JSON):**
```json
{
  "username": "nama_admin_anda",
  "password": "password_anda"
}
```

Tambahkan token ke header:
```
Authorization: Bearer <token_anda>
```

---

## 🔀 Daftar Rute & Endpoint

### 🖥️ Rute Web (Dashboard)

| Method | Endpoint         | Keterangan                    |
|--------|------------------|-------------------------------|
| GET    | `/`              | Halaman dashboard utama       |
| GET    | `/coffees`       | Daftar produk kopi            |
| GET    | `/coffees/new`   | Form tambah kopi              |
| GET    | `/foods`         | Daftar produk makanan         |
| GET    | `/foods/new`     | Form tambah makanan           |

### 📡 Endpoint API (JSON)

#### 🔐 Autentikasi

| Method | Endpoint         | Keterangan                     |
|--------|------------------|--------------------------------|
| POST   | `/api/register`  | Registrasi admin               |
| POST   | `/api/login`     | Login dan mendapatkan token    |

#### ☕ Kopi

| Method | Endpoint             | Keterangan                     |
|--------|----------------------|--------------------------------|
| GET    | `/api/coffees`       | Ambil semua kopi               |
| POST   | `/api/coffees`       | Tambah kopi (Auth)             |
| PUT    | `/api/coffees/{id}`  | Update kopi (Auth)             |
| DELETE | `/api/coffees/{id}`  | Hapus kopi (Auth)              |

#### 🍔 Makanan

| Method | Endpoint             | Keterangan                     |
|--------|----------------------|--------------------------------|
| GET    | `/api/foods`         | Ambil semua makanan            |
| POST   | `/api/foods`         | Tambah makanan (Auth)          |
| PUT    | `/api/foods/{id}`    | Update makanan (Auth)          |
| DELETE | `/api/foods/{id}`    | Hapus makanan (Auth)           |

---

## 📁 Struktur Folder Controller

```
app/
└── Controllers/
    ├── Web/
    │   ├── Coffees.php
    │   ├── Dashboard.php
    │   └── Foods.php
    ├── Api/
    │   ├── Auth.php
    │   ├── Coffees.php
    │   └── Foods.php
    └── BaseController.php
```

---

## 🌐 Frontend

Aplikasi frontend terhubung dengan API ini tersedia di:

👉 [https://coffee-app-nu.vercel.app/](https://coffee-app-nu.vercel.app/)

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](https://choosealicense.com/licenses/mit/)
