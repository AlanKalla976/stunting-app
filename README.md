# Panduan Implementasi (Final) — SPK Risiko Stunting Metode SAW

Studi Kasus: Puskesmas Losari — Berdasarkan Usulan Penelitian S1 Rias Fahmi Taftazani.

## Filosofi Urutan Pengerjaan

Banyak orang bingung karena mulai dari login/role dulu — padahal itu bukan
inti aplikasi. Urutan yang benar:

1. **Bangun dulu "mesin hitungnya"**: data balita, kriteria, dan rumus SAW —
   sampai perhitungannya benar-benar terbukti benar (dicek manual).
2. **Baru pasang "pintu"nya**: login, dan pembagian akses Admin/Petugas.

Kalau dibalik (login dulu baru fitur), Anda akan sibuk urus middleware dan
role padahal belum tahu apakah rumus SAW-nya sudah benar — buang waktu kalau
ternyata harus banyak revisi di bagian inti.

## Daftar File (kerjakan berurutan)

| No | File | Isi |
|---|---|---|
| 1 | `01-RINGKASAN-APLIKASI.md` | Apa aplikasi ini sebenarnya, dalam bahasa sederhana |
| 2 | `02-SETUP-LINGKUNGAN.md` | Install Laragon, Laravel, database |
| 3 | `03-DESAIN-DATABASE.md` | Struktur tabel + migration Laravel |
| 4 | `04-BANGUN-FITUR-INTI.md` | CRUD balita/kriteria/nilai — **tanpa login dulu**, biar cepat lihat hasil |
| 5 | `05-ALGORITMA-SAW.md` | Rumus SAW, contoh hitung manual, kode PHP-nya |
| 6 | `06-TAMBAH-LOGIN-DAN-ROLE.md` | Baru di sini pasang login terpisah Admin/Petugas + proteksi halaman |
| 7 | `07-ROADMAP-DAN-PENGUJIAN.md` | Jadwal pengerjaan mingguan + checklist testing sebelum sidang |

## Cara Pakai

Baca dan kerjakan **satu file, selesai, baru lanjut ke file berikutnya**.
Jangan loncat ke file 6 sebelum file 4 dan 5 benar-benar berjalan — itu
kesalahan paling umum yang bikin bingung.
