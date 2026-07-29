# 02 — Setup Lingkungan Pengembangan

Ikuti urutan ini dari atas ke bawah. Jangan loncat langkah — banyak error
pemula muncul karena versi PHP/Composer tidak cocok dengan Laravel.

## 1. Install Laragon

1. Download Laragon (Full edition, sudah termasuk PHP, MySQL, Apache/Nginx) dari laragon.org.
2. Install seperti biasa (Next-Next-Finish), default path `C:\laragon`.
3. Jalankan Laragon → klik **Start All** → pastikan Apache & MySQL berjalan (indikator hijau).
4. Buka `http://localhost` di browser — kalau muncul halaman Laragon, berarti sukses.

## 2. Cek Versi PHP & Composer

Laravel versi terbaru butuh PHP 8.2+. Buka terminal Laragon (klik kanan tray icon → Terminal), lalu:

```bash
php -v
composer -v
```

Jika Composer belum ada, download dari getcomposer.org dan install (Laragon biasanya sudah menyediakan opsi "Quick Add" untuk Composer).

## 3. Buat Project Laravel

Di terminal Laragon, arahkan ke folder `www` (folder default Laragon untuk semua project):

```bash
cd C:\laragon\www
composer create-project laravel/laravel spk-stunting
cd spk-stunting
```

Jalankan server dev:

```bash
php artisan serve
```

Buka `http://127.0.0.1:8000` — harus muncul halaman welcome Laravel.

> Alternatif: dengan Laragon, cukup akses `http://spk-stunting.test` (Laragon auto-detect virtual host untuk setiap folder di `www`).

## 4. Buat Database

1. Buka phpMyAdmin: `http://localhost/phpmyadmin`.
2. Buat database baru bernama `db_spk_stunting`.
3. Buka file `.env` di root project Laravel, sesuaikan:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_spk_stunting
DB_USERNAME=root
DB_PASSWORD=
```

(Default Laragon: username `root`, password kosong.)

## 5. Install Package Pendukung

```bash
composer require laravel/ui
npm install && npm run dev
```

> **Jangan jalankan `php artisan ui bootstrap --auth` dulu.** Login baru kita
> pasang di `06-TAMBAH-LOGIN-DAN-ROLE.md`, setelah fitur inti (CRUD + rumus
> SAW) terbukti jalan. Kalau dipasang sekarang, Anda cuma akan sibuk
> berurusan dengan halaman login padahal belum ada yang bisa di-login-i.

Untuk export hasil ke PDF (dipakai di fitur cetak hasil, nanti):

```bash
composer require barryvdh/laravel-dompdf
```

## 6. Setup Kolom Role (disiapkan sekarang, dipakai nanti)

Tabel `users` bawaan Laravel sudah otomatis dibuat oleh migration default.
Kita cukup siapkan kolom `role` sekarang (isinya baru kepakai nanti di file 06):

```bash
php artisan make:migration add_role_to_users_table --table=users
```

```php
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->enum('role', ['admin', 'petugas'])->default('petugas');
    });
}
```

Jalankan nanti bareng migration lain di `03-DESAIN-DATABASE.md`.

## 7. Struktur Git (opsional tapi disarankan)

```bash
git init
echo "/vendor
/node_modules
.env" >> .gitignore
git add .
git commit -m "Initial Laravel setup"
```

Gunanya: kalau ada revisi dari dosen pembimbing atau error saat coding, Anda
bisa rollback ke versi sebelumnya.

## Checklist Sebelum Lanjut ke Tahap Database

- [ ] `php artisan serve` berjalan tanpa error
- [ ] Halaman welcome Laravel muncul di browser
- [ ] Database `db_spk_stunting` sudah dibuat di phpMyAdmin
- [ ] `.env` sudah terhubung ke database (test dengan `php artisan migrate` — kalau tidak error berarti koneksi OK)
- [ ] Migration kolom `role` sudah dibuat (belum perlu dijalankan, tunggu digabung dengan migration lain di file 03)
