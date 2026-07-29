# 03 — Desain Database

Struktur di bawah ini diambil langsung dari BAB IV proposal Anda (Tabel 6–11
dan penjelasan ERD), supaya laporan skripsi dan implementasi tetap konsisten.

## Entity Relationship Diagram (ringkasan hubungan)

```
User (1) ────────< tidak berelasi langsung ke data master, hanya untuk login >

Balita (1) ───< Nilai >─── (1) Kriteria ───< Sub_Kriteria
Balita (1) ───< Hasil   (1:1 — tiap balita punya satu hasil akhir)
```

- Satu **Balita** bisa punya banyak **Nilai** (satu nilai per kriteria).
- Satu **Kriteria** bisa punya banyak **Nilai** dan banyak **Sub_Kriteria**.
- Satu **Balita** menghasilkan satu **Hasil** (1:1).

## Struktur Tabel

### 1. Tabel `users`
| Field | Tipe | Keterangan |
|---|---|---|
| id_user (PK) | int, auto increment | sudah otomatis dibuat migration default Laravel |
| username / name | varchar(50) | |
| password | varchar(255) | di-hash pakai bcrypt (Laravel default) |
| email | varchar(100) | sudah ada dari migration default |
| role | enum('admin','petugas') | ditambahkan di file 02 |

> Tabel ini belum dipakai untuk login sampai file `06-TAMBAH-LOGIN-DAN-ROLE.md`.
> Sekarang cukup pastikan strukturnya siap.

### 2. Tabel `balita`
| Field | Tipe | Keterangan |
|---|---|---|
| id_balita (PK) | int, auto increment | |
| nama_balita | varchar(100) | |
| umur | varchar(10) | |
| jenis_kelamin | enum('L','P') | |
| alamat | varchar(100) | |

### 3. Tabel `kriteria`
| Field | Tipe | Keterangan |
|---|---|---|
| id_kriteria (PK) | int, auto increment | |
| nama_kriteria | varchar(100) | |
| jenis | enum('benefit','cost') | |
| bobot | float | nilai 0–1, total seluruh bobot kriteria = 1 |

### 4. Tabel `sub_kriteria`
| Field | Tipe | Keterangan |
|---|---|---|
| id_sub (PK) | int, auto increment | |
| nama_sub | varchar(100) | |
| id_kriteria (FK → kriteria) | int | |
| nilai_bobot | float | **ditambahkan**: nilai skor untuk sub kriteria ini (mis. "Ekonomi Rendah" = 0.25, "Sedang" = 0.5, "Tinggi" = 1) — dipakai supaya input nilai balita tidak harus mengetik angka manual, cukup pilih sub kriteria |

### 5. Tabel `nilai`
| Field | Tipe | Keterangan |
|---|---|---|
| id_nilai (PK) | int, auto increment | |
| id_balita (FK → balita) | int | |
| id_kriteria (FK → kriteria) | int | |
| id_sub (FK → sub_kriteria, nullable) | int | opsional, kalau input lewat sub kriteria |
| nilai | float | nilai mentah kriteria untuk balita ini |

### 6. Tabel `hasil`
| Field | Tipe | Keterangan |
|---|---|---|
| id_hasil (PK) | int, auto increment | |
| id_balita (FK → balita) | int | |
| nilai_preferensi | float | hasil akhir V_i dari rumus SAW |
| ranking | int | posisi ranking berdasarkan nilai_preferensi tertinggi |
| tanggal | date | tanggal perhitungan dijalankan |

> **Catatan penyesuaian dari proposal:** saya menambahkan kolom `email` di
> `users` dan `nilai_bobot` di `sub_kriteria` karena dibutuhkan agar fitur
> "Lupa Password" dan "Input Nilai via Sub Kriteria" (yang sudah dijelaskan
> di narasi Activity Diagram Anda) benar-benar bisa berjalan. Ini penambahan
> minor, tidak mengubah struktur inti ERD di proposal — cukup sebutkan di
> BAB VI (Hasil dan Pembahasan) sebagai penyempurnaan teknis saat implementasi.

## Migration Laravel

Buat file migration (kolom `role` untuk `users` sudah dibuat di file 02, sekarang buat sisanya):

```bash
php artisan make:migration create_balita_table
php artisan make:migration create_kriteria_table
php artisan make:migration create_sub_kriteria_table
php artisan make:migration create_nilai_table
php artisan make:migration create_hasil_table
```

Isi tiap migration:

**`create_balita_table`**
```php
public function up()
{
    Schema::create('balita', function (Blueprint $table) {
        $table->id('id_balita');
        $table->string('nama_balita', 100);
        $table->string('umur', 10);
        $table->enum('jenis_kelamin', ['L', 'P']);
        $table->string('alamat', 100);
        $table->timestamps();
    });
}
```

**`create_kriteria_table`**
```php
public function up()
{
    Schema::create('kriteria', function (Blueprint $table) {
        $table->id('id_kriteria');
        $table->string('nama_kriteria', 100);
        $table->enum('jenis', ['benefit', 'cost']);
        $table->float('bobot');
        $table->timestamps();
    });
}
```

**`create_sub_kriteria_table`**
```php
public function up()
{
    Schema::create('sub_kriteria', function (Blueprint $table) {
        $table->id('id_sub');
        $table->string('nama_sub', 100);
        $table->foreignId('id_kriteria')->constrained('kriteria', 'id_kriteria')->onDelete('cascade');
        $table->float('nilai_bobot');
        $table->timestamps();
    });
}
```

**`create_nilai_table`**
```php
public function up()
{
    Schema::create('nilai', function (Blueprint $table) {
        $table->id('id_nilai');
        $table->foreignId('id_balita')->constrained('balita', 'id_balita')->onDelete('cascade');
        $table->foreignId('id_kriteria')->constrained('kriteria', 'id_kriteria')->onDelete('cascade');
        $table->foreignId('id_sub')->nullable()->constrained('sub_kriteria', 'id_sub')->nullOnDelete();
        $table->float('nilai');
        $table->timestamps();
    });
}
```

**`create_hasil_table`**
```php
public function up()
{
    Schema::create('hasil', function (Blueprint $table) {
        $table->id('id_hasil');
        $table->foreignId('id_balita')->constrained('balita', 'id_balita')->onDelete('cascade');
        $table->float('nilai_preferensi');
        $table->integer('ranking');
        $table->date('tanggal');
        $table->timestamps();
    });
}
```

Jalankan semua migration:

```bash
php artisan migrate
```

## Seeder (data awal untuk testing)

Buat seeder supaya tidak perlu input manual berkali-kali saat development:

```bash
php artisan make:seeder KriteriaSeeder
```

```php
// database/seeders/KriteriaSeeder.php
public function run()
{
    DB::table('kriteria')->insert([
        ['nama_kriteria' => 'Tinggi Badan', 'jenis' => 'cost', 'bobot' => 0.3],
        ['nama_kriteria' => 'Berat Badan', 'jenis' => 'cost', 'bobot' => 0.25],
        ['nama_kriteria' => 'Usia', 'jenis' => 'benefit', 'bobot' => 0.15],
        ['nama_kriteria' => 'Kondisi Ekonomi', 'jenis' => 'cost', 'bobot' => 0.2],
        ['nama_kriteria' => 'Sanitasi Lingkungan', 'jenis' => 'cost', 'bobot' => 0.1],
    ]);
}
```

> Sesuaikan nama kriteria, jenis (benefit/cost), dan bobot sesuai data yang
> Anda peroleh dari wawancara/observasi di Puskesmas Losari (lihat BAB D
> Metodologi Penelitian proposal Anda — bagian Teknik Pengumpulan Data).
> Total seluruh bobot kriteria **harus = 1**.

Jalankan seeder:

```bash
php artisan db:seed --class=KriteriaSeeder
```

## Checklist Sebelum Lanjut

- [ ] Semua 6 migration berhasil dijalankan tanpa error
- [ ] Cek di phpMyAdmin: tabel `users`, `balita`, `kriteria`, `sub_kriteria`, `nilai`, `hasil` sudah muncul dengan foreign key yang benar
- [ ] Seeder kriteria berhasil dijalankan dan total bobot = 1
