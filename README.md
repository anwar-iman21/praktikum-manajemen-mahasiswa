# Sistem Manajemen Data Mahasiswa Berbasis Role

Aplikasi web sederhana untuk mengelola data mahasiswa dengan dua jenis pengguna: **Admin** (dapat CRUD data mahasiswa) dan **User** (hanya dapat melihat data mahasiswa). Dibangun menggunakan Laravel dengan autentikasi Laravel Breeze dan pembatasan akses berbasis middleware.

Dibuat untuk memenuhi tugas praktikum mata kuliah **Pemrograman Web III**.

---

## Informasi Teknis

| Komponen | Versi/Detail |
|---|---|
| Framework | Laravel 12 |
| PHP | 8.2 |
| Autentikasi | Laravel Breeze (stack Blade) |
| Database | MySQL |
| Testing Framework | PHPUnit |

---

## Fitur Utama

- Autentikasi: Register, Login, Logout (Laravel Breeze)
- Registrasi akun dengan pilihan role (`admin` / `user`) saat mendaftar
- Middleware kustom (`CheckRole`) untuk membatasi akses berdasarkan role
- CRUD data mahasiswa (NIM, Nama, Program Studi, Email, Angkatan)
- Pembatasan akses di sisi server — bukan hanya menyembunyikan tombol di tampilan

### Matriks Hak Akses

| Fitur | Admin | User |
|---|---|---|
| Login / Logout | ✅ | ✅ |
| Dashboard | ✅ | ✅ |
| Melihat data mahasiswa | ✅ | ✅ |
| Menambah mahasiswa | ✅ | ❌ |
| Mengubah mahasiswa | ✅ | ❌ |
| Menghapus mahasiswa | ✅ | ❌ |

---

## Prasyarat

Pastikan sudah terinstall di komputer:

- [PHP](https://www.php.net/downloads) versi 8.2 atau lebih baru
- [Composer](https://getcomposer.org/download/)
- [Node.js](https://nodejs.org/) & npm
- Server MySQL — bisa lewat [XAMPP](https://www.apachefriends.org/) atau [Laragon](https://laragon.org/)
- Git (opsional, untuk clone repository)

Cek versi PHP dan Composer yang terpasang:

```bash
php -v
composer -v
```

---

## Cara Instalasi & Menjalankan Project

### 1. Clone atau Download Project

```bash
git clone <link-repository-github-anda>
cd praktikum-manajemen-mahasiswa
```

Atau extract file .zip project ke folder pilihan Anda, lalu buka folder tersebut di terminal/VS Code.

### 2. Install Dependency PHP (Composer)

```bash
composer install
```

### 3. Install Dependency JavaScript (npm)

```bash
npm install
npm run build
```

### 4. Salin File Environment

```bash
cp .env.example .env
```

> Di Windows (Command Prompt), gunakan:
> ```bash
> copy .env.example .env
> ```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Buat Database di MySQL

1. Jalankan MySQL (via XAMPP/Laragon), pastikan service **MySQL** aktif
2. Buka **phpMyAdmin** (`http://localhost/phpmyadmin`)
3. Klik tab **Databases** → buat database baru dengan nama:
   ```
   praktikum_mahasiswa
   ```
4. Klik **Create** (database dibiarkan kosong, tabel akan dibuat otomatis lewat migration)

### 7. Konfigurasi Koneksi Database

Buka file `.env`, sesuaikan bagian berikut:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=praktikum_mahasiswa
DB_USERNAME=root
DB_PASSWORD=
```

> Sesuaikan `DB_USERNAME` dan `DB_PASSWORD` dengan konfigurasi MySQL di komputer Anda. Default XAMPP/Laragon biasanya `root` tanpa password.

### 8. Jalankan Migration & Seeder

```bash
php artisan migrate:fresh --seed
```

Perintah ini akan:
- Membuat seluruh tabel (`users`, `mahasiswas`, dll)
- Menambahkan kolom `role` pada tabel `users`
- Mengisi 2 akun testing secara otomatis (lihat bagian **Akun Default** di bawah)

### 9. Jalankan Server Laravel

```bash
php artisan serve
```

### 10. Buka di Browser

```
http://127.0.0.1:8000
```

---

## Akun Default (Hasil Seeder)

| Role | Email | Password |
|---|---|---|
| Admin | admin@mail.com | password |
| User | user@mail.com | password |

Anda juga bisa mendaftarkan akun baru sendiri melalui halaman `/register`, di mana terdapat pilihan role (**Admin**/**User**) saat mendaftar.

---

## Struktur Halaman & Route Penting

| Route | Keterangan | Akses |
|---|---|---|
| `/register` | Halaman pendaftaran akun | Semua (belum login) |
| `/login` | Halaman login | Semua (belum login) |
| `/dashboard` | Halaman dashboard setelah login | Admin & User |
| `/mahasiswa` | Melihat daftar mahasiswa | Admin & User |
| `/mahasiswa/create` | Form tambah mahasiswa | Admin saja |
| `/mahasiswa/{id}/edit` | Form edit mahasiswa | Admin saja |

Menu navigasi **"Data Mahasiswa"** tersedia di navbar setelah login (baik di tampilan desktop maupun mobile).

---

## Cara Menguji Pembatasan Akses (Role)

1. Login sebagai **user** (`user@mail.com`)
2. Buka `/mahasiswa` → pastikan tombol Tambah/Edit/Hapus **tidak muncul**
3. Coba akses langsung lewat address bar:
   ```
   http://127.0.0.1:8000/mahasiswa/create
   ```
4. Seharusnya muncul halaman **403 Forbidden** — ini membuktikan pembatasan dilakukan di server (middleware), bukan hanya menyembunyikan tombol di tampilan
5. Logout, login sebagai **admin** (`admin@mail.com`), lalu ulangi langkah 3 → seharusnya berhasil masuk ke halaman tambah mahasiswa

---

## Struktur File Penting Project

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/RegisteredUserController.php   # Registrasi + penyimpanan role
│   │   └── MahasiswaController.php             # CRUD data mahasiswa
│   └── Middleware/
│       └── CheckRole.php                       # Middleware pembatasan akses role
├── Models/
│   ├── User.php                                # Model user (+ atribut role)
│   └── Mahasiswa.php                           # Model data mahasiswa

bootstrap/
└── app.php                                     # Registrasi alias middleware 'role'

database/
├── migrations/
│   ├── ..._add_role_to_users_table.php
│   └── ..._create_mahasiswas_table.php
└── seeders/
    ├── DatabaseSeeder.php
    └── UserSeeder.php                          # Seeder akun admin & user

resources/views/
├── auth/register.blade.php                     # Form register + pilihan role
├── layouts/navigation.blade.php                 # Navbar + menu Data Mahasiswa
└── mahasiswa/
    ├── index.blade.php
    ├── create.blade.php
    └── edit.blade.php

routes/
└── web.php                                      # Definisi route + middleware
```

---

## Menjalankan Unit Test (Opsional)

Project ini menggunakan PHPUnit. Untuk menjalankan test bawaan:

```bash
php artisan test
```

---

## Troubleshooting Umum

| Masalah | Solusi |
|---|---|
| `SQLSTATE[HY000] [2002] Connection refused` | Pastikan service MySQL sudah *running* di XAMPP/Laragon |
| `Target class [role] does not exist` | Pastikan alias middleware `role` sudah didaftarkan di `bootstrap/app.php` |
| `Route [mahasiswa.index] not defined` | Pastikan `routes/web.php` sudah berisi route mahasiswa dan jalankan `php artisan route:clear` |
| `Class "Laravel\Sanctum\HasApiTokens" not found` | Pastikan `app/Models/User.php` tidak memakai trait `HasApiTokens` (tidak dibutuhkan untuk stack Blade) |
| Halaman blank/error 500 setelah edit file | Jalankan `php artisan config:clear && php artisan view:clear && php artisan route:clear` |
| CSS/tampilan tidak muncul (polos) | Jalankan `npm run build` ulang |

---

## Catatan Keamanan (untuk Pembelajaran)

Fitur pemilihan role saat registrasi (`/register`) dibuat **khusus untuk keperluan pengujian/demo tugas praktikum**, agar mudah membuat akun Admin maupun User. Pada aplikasi produksi sesungguhnya, hal ini **tidak disarankan** karena memungkinkan siapa saja mendaftar langsung sebagai Admin. Idealnya, penetapan role dilakukan oleh Admin yang sudah ada (melalui panel pengelolaan user), bukan oleh pengguna itu sendiri saat mendaftar.

---

## Kontributor

- **Nama**: Ahmad Anwarul Iman Alfaqih
- **Mata Kuliah**: Pemrograman Web III
