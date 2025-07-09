# coffee-api
---

````
# ☕ Coffee API

![CI](https://img.shields.io/badge/build-passing-brightgreen)  
RESTful API sederhana untuk aplikasi manajemen pengguna dan menu kopi, dibangun dengan CodeIgniter 4.

---

## 🚀 Fitur

- ✅ Register & login user
- 🔐 JWT-like token authorization
- 📋 CRUD data menu kopi
- 🧩 Struktur MVC rapi
- 📡 JSON response sesuai standar REST API

---

## 📦 Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/yuiawen/coffee-api.git
cd coffee-api
````

### 2. Install Dependency

```bash
composer install
```

### 3. Konfigurasi `.env`

```bash
cp .env.example .env
```

Edit `.env` dan isi data database-mu:

```
database.default.hostname = localhost
database.default.database = coffee_db
database.default.username = root
database.default.password = 
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

Server akan aktif di `http://localhost:8080`

---

## 🧪 Seed & Testing

### Seed User Dummy

```bash
php spark db:seed UserSeeder
```

### Tes Endpoint di Postman / REST Client

Contoh login:

```
POST /login
Body:
{
  "email": "admin@example.com",
  "password": "admin"
}
```

Gunakan token di header:

```
Authorization: Bearer <token>
```

---

## 🔀 Daftar Endpoint

| Method | Endpoint      | Keterangan            |
| ------ | ------------- | --------------------- |
| POST   | `/register`   | Registrasi user       |
| POST   | `/login`      | Login dan ambil token |
| POST   | `/logout`     | Logout user (auth)    |
| GET    | `/menus`      | Ambil semua menu kopi |
| POST   | `/menus`      | Tambah menu (auth)    |
| PUT    | `/menus/{id}` | Update menu (auth)    |
| DELETE | `/menus/{id}` | Hapus menu (auth)     |

---

## 📁 Struktur Folder Utama

```
app/
├── Controllers/
├── Filters/
├── Models/
├── Config/
public/
writable/
```

---

## 📄 Lisensi

Kode ini dilisensikan di bawah [MIT License](LICENSE).

---

> 🧑‍💻 Dibuat oleh [@yuiawen](https://github.com/yuiawen)

```

---

```
