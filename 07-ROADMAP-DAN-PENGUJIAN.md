# 07 — Roadmap & Pengujian

## Roadmap Mingguan (dipetakan ke jadwal proposal, April–Agustus)

| Minggu | Kerjakan | File Panduan |
|---|---|---|
| 1–2 | Analisis: konfirmasi kriteria & bobot final ke Puskesmas Losari | `01` |
| 3–4 | Setup lingkungan + desain database final | `02`, `03` |
| 5–6 | Bangun fitur inti: CRUD balita, kriteria, sub kriteria, nilai — **tanpa login** | `04` |
| 7 | Bangun rumus SAW, validasi vs hitungan manual | `05` |
| 8 | Pasang login terpisah Admin/Petugas + proteksi halaman | `06` |
| 9–10 | Styling Bootstrap, dashboard, cetak PDF | — |
| 11–12 | Black Box Testing menyeluruh, perbaikan bug | file ini |
| 13 | Demo/serah terima, siap sidang | — |

## Checklist Pengujian (Black Box Testing)

### Fitur Inti (sebelum login dipasang)
- [ ] CRUD data balita berjalan benar
- [ ] CRUD kriteria & sub kriteria berjalan benar
- [ ] Input nilai per balita per kriteria berjalan benar
- [ ] Perhitungan SAW menghasilkan angka yang sama dengan hitungan manual
- [ ] Ranking terurut benar (nilai tertinggi = ranking 1)

### Login & Role
- [ ] Login admin & petugas masing-masing di URL yang benar
- [ ] Admin tidak bisa login lewat `/petugas/login`, begitu juga sebaliknya
- [ ] Petugas tidak bisa akses halaman kriteria/sub kriteria/nilai/user (403)
- [ ] Petugas bisa tambah & lihat balita, tapi tidak ada tombol edit/hapus
- [ ] Register publik selalu menghasilkan akun petugas
- [ ] Logout berhasil, session terhapus

### Umum
- [ ] Validasi form: field kosong ditolak dengan pesan jelas
- [ ] Cetak hasil ke PDF berhasil, isi sesuai data
- [ ] Tampilan rapi di layar kecil (responsive)
- [ ] Aplikasi bisa dijalankan dari instalasi baru (fresh install) tanpa error

## Sebelum Sidang

- [ ] Semua checklist di atas berstatus lulus
- [ ] Screenshot tiap fitur utama untuk BAB VI skripsi
- [ ] Tabel perbandingan hasil manual vs sistem sudah didokumentasikan
- [ ] Backup database (`.sql`) sebagai cadangan
- [ ] Siapkan akun demo Admin dan Petugas terpisah untuk ditunjukkan ke penguji
