# 01 — Ringkasan Aplikasi (Bahasa Sederhana)

## Satu Kalimat

Aplikasi web yang memasukkan data balita + nilai per kriteria, lalu sistem
menghitung otomatis dan menampilkan **urutan balita dari yang paling
berisiko stunting sampai yang paling aman**.

## Alur Inti (ini yang harus jalan duluan, sebelum mikir login)

```
Input data balita  →  Input kriteria & bobot  →  Input nilai tiap balita
     per kriteria  →  Sistem hitung (SAW)  →  Tampil hasil ranking
```

## Data yang Dibutuhkan

| Data | Contoh |
|---|---|
| Balita | Nama, umur, jenis kelamin, alamat |
| Kriteria | Tinggi Badan, Kondisi Ekonomi, dst — beserta bobot kepentingan |
| Nilai | Angka penilaian tiap balita untuk tiap kriteria |
| Hasil | Skor akhir + ranking, dihitung otomatis oleh sistem |

## Siapa yang Pakai (baru dipikirkan setelah fitur inti jalan)

| Aktor | Boleh Apa |
|---|---|
| **Admin** | Semua — kelola data, kelola kriteria, input nilai, hitung SAW, kelola user |
| **Petugas** | Tambah & lihat data balita, lihat hasil ranking — tidak bisa ubah/hapus, tidak bisa atur kriteria |

## Teknologi

PHP + Laravel + MySQL + Bootstrap, dijalankan lokal pakai Laragon saat development.

## Target Akhir

Aplikasi yang bisa didemokan: buka browser → input data → klik hitung →
muncul daftar balita terurut dari risiko tertinggi → bisa dicetak PDF.
Login & role ditambahkan setelah bagian ini terbukti benar.
