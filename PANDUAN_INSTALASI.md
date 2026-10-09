# Panduan Instalasi — Praktikum Manajemen Mahasiswa (Laravel 10 + PHP 8.2)

File-file dalam folder ini SUDAH JADI dan siap dipakai. Kamu tinggal:
1. Buat project Laravel + Breeze baru (kosong)
2. Copy/timpa file dari folder ini ke project kamu
3. Jalankan migrasi & seeder

Ikuti urutan di bawah ini persis, jangan diloncat.

---

## LANGKAH 1 — Buat Project Laravel Baru

Buka terminal di VS Code, lalu jalankan satu-satu:

```bash
composer create-project laravel/laravel praktikum-manajemen-mahasiswa
cd praktikum-manajemen-mahasiswa
```

Cek dulu versi Laravel & PHP kamu supaya sesuai:

```bash
php artisan --version
php -v
```

Pastikan hasilnya Laravel 10.x dan PHP 8.2.x. Kalau `composer create-project` menginstal Laravel 11 secara default, jalankan ini supaya dapat versi 10:

```bash
composer create-project laravel/laravel:^10.0 praktikum-manajemen-mahasiswa
```

## LANGKAH 2 — Install Breeze

```bash
composer require laravel/breeze --dev
php artisan breeze:install
```

Saat muncul pilihan stack, pilih **Blade**:

```
Which Breeze stack would you like to install?
> blade
```

Lanjutkan:

```bash
npm install
npm run build
```

## LANGKAH 3 — Setting Database

Edit file `.env`, sesuaikan dengan database kamu:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=praktikum_mahasiswa
DB_USERNAME=root
DB_PASSWORD=
```

Buat database `praktikum_mahasiswa` di phpMyAdmin/HeidiSQL/MySQL Workbench kamu (buat database kosong dengan nama itu).

## LANGKAH 4 — Copy File dari Paket Ini

Sekarang timpa/copy file-file berikut dari paket yang saya buat ini ke folder project Laravel kamu. **Struktur foldernya sudah sama**, tinggal copy-paste dan timpa (overwrite) kalau ada file yang sudah ada:

| File di paket ini | Ditaruh di project kamu | Keterangan |
|---|---|---|
| `app/Models/User.php` | `app/Models/User.php` | **TIMPA** file asli (tambahan kolom `role`) |
| `app/Models/Mahasiswa.php` | `app/Models/Mahasiswa.php` | File baru |
| `app/Http/Controllers/MahasiswaController.php` | `app/Http/Controllers/MahasiswaController.php` | File baru |
| `app/Http/Middleware/CheckRole.php` | `app/Http/Middleware/CheckRole.php` | File baru |
| `app/Http/Kernel.php` | `app/Http/Kernel.php` | **TIMPA** file asli (menambahkan alias `role`) |
| `routes/web.php` | `routes/web.php` | **TIMPA** file asli |
| `database/migrations/2024_01_01_000001_add_role_to_users_table.php` | `database/migrations/...` | File baru (migration) |
| `database/migrations/2024_01_01_000002_create_mahasiswas_table.php` | `database/migrations/...` | File baru (migration) |
| `database/seeders/UserSeeder.php` | `database/seeders/UserSeeder.php` | File baru |
| `database/seeders/DatabaseSeeder.php` | `database/seeders/DatabaseSeeder.php` | **TIMPA** file asli |
| `resources/views/mahasiswa/index.blade.php` | `resources/views/mahasiswa/index.blade.php` | File baru (buat folder `mahasiswa` dulu) |
| `resources/views/mahasiswa/create.blade.php` | `resources/views/mahasiswa/create.blade.php` | File baru |
| `resources/views/mahasiswa/edit.blade.php` | `resources/views/mahasiswa/edit.blade.php` | File baru |

> ⚠️ **PENTING soal `Kernel.php`**: file yang saya kasih adalah `Kernel.php` versi standar Laravel 10 + tambahan alias `role`. Kalau setelah `breeze:install` file `Kernel.php` asli kamu ada perubahan lain (biasanya tidak ada), cukup buka file `Kernel.php` bawaan project kamu, cari bagian `protected $middlewareAliases = [ ... ]`, lalu tambahkan baris ini secara manual di dalamnya (lebih aman daripada full-timpa):
> ```php
> 'role' => \App\Http\Middleware\CheckRole::class,
> ```

## LANGKAH 5 — Migrasi & Seeder

Setelah semua file di-copy, jalankan:

```bash
php artisan migrate
php artisan db:seed
```

Kalau error karena tabel sudah ada / bentrok, reset dulu total (⚠️ ini menghapus semua data, aman karena masih project baru):

```bash
php artisan migrate:fresh --seed
```

Ini akan otomatis membuat 2 akun testing:
- **Admin** → `admin@mail.com` / `password`
- **User** → `user@mail.com` / `password`

## LANGKAH 6 — Jalankan Server

```bash
php artisan serve
```

Buka browser ke:
```
http://127.0.0.1:8000/login
```

Login pakai salah satu akun di atas, lalu coba akses `http://127.0.0.1:8000/mahasiswa`.

## LANGKAH 7 — Testing Manual

Lakukan hal berikut untuk memastikan semua jalan sesuai skenario tugas:

1. Login sebagai **admin** → buka `/mahasiswa` → harus ada tombol **Tambah**, dan di setiap baris ada **Edit/Hapus**
2. Coba tambah, edit, hapus data mahasiswa sebagai admin → harus berhasil semua
3. Logout, lalu login sebagai **user** → buka `/mahasiswa` → tombol Tambah/Edit/Hapus **tidak muncul**
4. Sebagai user, coba ketik langsung di address bar: `http://127.0.0.1:8000/mahasiswa/create` → harus muncul halaman **403 Forbidden**
5. Logout dari kedua akun → harus balik ke halaman login

Kalau semua poin di atas sesuai, aplikasi kamu sudah berjalan dengan benar sesuai ketentuan tugas.

---

## Kalau Ada Error

Kirim pesan error lengkapnya (biasanya muncul di terminal atau di halaman browser), saya bantu debug.

Error yang sering muncul:
- **`Class "App\Http\Middleware\CheckRole" not found`** → jalankan `composer dump-autoload`
- **`SQLSTATE[42S02]: Base table or view not found`** → pastikan sudah `php artisan migrate`
- **`Route [mahasiswa.index] not defined`** → pastikan `routes/web.php` sudah ditimpa dengan benar
- **419 Page Expired saat submit form** → biasanya karena session expired, refresh halaman login ulang
