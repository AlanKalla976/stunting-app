# 05 — Algoritma Simple Additive Weighting (SAW)

Ini bagian **paling penting** dari skripsi Anda — penguji hampir pasti akan
menguji apakah Anda benar-benar paham rumus ini, bukan cuma copy-paste kode.
Pahami dulu manual sebelum coding.

## Langkah SAW (sesuai Landasan Teori proposal)

1. Tentukan alternatif (balita) dan kriteria.
2. Susun matriks keputusan (nilai tiap balita untuk tiap kriteria).
3. Normalisasi matriks:
   - Kriteria **benefit** (semakin besar semakin baik/berisiko):
     `Rij = xij / max(xij)`
   - Kriteria **cost** (semakin kecil semakin baik/berisiko):
     `Rij = min(xij) / xij`
4. Kalikan hasil normalisasi dengan bobot kriteria.
5. Jumlahkan untuk mendapat nilai preferensi tiap alternatif: `Vi = Σ(Wj × Rij)`.
6. Urutkan (ranking) dari nilai tertinggi ke terendah.

> **Penting:** rumus normalisasi proposal Anda menulis `Rij = xij/min(xij)`
> untuk kriteria kedua — ini penyederhanaan penulisan di banyak referensi SAW.
> Rumus yang benar secara matematis dan konsisten dengan teori aslinya
> (Fishburn/MADM) untuk kriteria **cost** adalah `Rij = min(xij) / xij`.
> Gunakan rumus ini di implementasi, dan di laporan Anda bisa jelaskan bahwa
> ini adalah rumus standar cost dalam metode SAW.

## Contoh Perhitungan Manual

Misal 3 balita dinilai dengan 3 kriteria:

| Kriteria | Jenis | Bobot |
|---|---|---|
| C1: Tinggi Badan (rendah = risiko tinggi) | cost | 0.4 |
| C2: Kondisi Ekonomi (rendah = risiko tinggi) | cost | 0.35 |
| C3: Usia (semakin tinggi usia balita berisiko, contoh) | benefit | 0.25 |

Matriks nilai mentah (skala 1–5, di mana untuk cost: nilai kecil = kondisi
buruk/berisiko tinggi):

| Balita | C1 | C2 | C3 |
|---|---|---|---|
| A | 2 | 3 | 4 |
| B | 4 | 2 | 3 |
| C | 3 | 4 | 5 |

**Normalisasi C1 (cost)**: min = 2 → R = 2/xij
- A: 2/2 = 1.0
- B: 2/4 = 0.5
- C: 2/3 = 0.667

**Normalisasi C2 (cost)**: min = 2 → R = 2/xij
- A: 2/3 = 0.667
- B: 2/2 = 1.0
- C: 2/4 = 0.5

**Normalisasi C3 (benefit)**: max = 5 → R = xij/5
- A: 4/5 = 0.8
- B: 3/5 = 0.6
- C: 5/5 = 1.0

**Nilai preferensi Vi = (0.4×R1) + (0.35×R2) + (0.25×R3)**
- A: (0.4×1.0) + (0.35×0.667) + (0.25×0.8) = 0.4 + 0.2335 + 0.2 = **0.6335**
- B: (0.4×0.5) + (0.35×1.0) + (0.25×0.6) = 0.2 + 0.35 + 0.15 = **0.7**
- C: (0.4×0.667) + (0.35×0.5) + (0.25×1.0) = 0.2668 + 0.175 + 0.25 = **0.6918**

**Ranking**: B (0.7) > C (0.6918) > A (0.6335)
→ Balita B memiliki nilai preferensi tertinggi → risiko stunting tertinggi
(karena kriteria yang dipilih memodelkan risiko, bukan kelayakan/prestasi).

> Simpan tabel contoh ini di laporan skripsi BAB VI sebagai bukti validasi
> perhitungan manual vs sistem (sesuai rencana pengujian di proposal Anda).

## Implementasi PHP (Service Class Laravel)

Buat file `app/Services/SawService.php`:

```php
<?php

namespace App\Services;

use App\Models\Balita;
use App\Models\Kriteria;
use App\Models\Nilai;
use App\Models\Hasil;
use Carbon\Carbon;

class SawService
{
    public function hitung(): array
    {
        $kriteriaList = Kriteria::all();
        $balitaList = Balita::all();

        // 1. Susun matriks keputusan: [id_balita][id_kriteria] = nilai
        $matriks = [];
        foreach ($balitaList as $balita) {
            foreach ($kriteriaList as $kriteria) {
                $nilai = Nilai::where('id_balita', $balita->id_balita)
                    ->where('id_kriteria', $kriteria->id_kriteria)
                    ->value('nilai');
                $matriks[$balita->id_balita][$kriteria->id_kriteria] = $nilai ?? 0;
            }
        }

        // 2. Cari nilai max/min tiap kriteria
        $maxMin = [];
        foreach ($kriteriaList as $kriteria) {
            $kolom = array_column($matriks, $kriteria->id_kriteria);
            $maxMin[$kriteria->id_kriteria] = [
                'max' => max($kolom),
                'min' => min($kolom),
            ];
        }

        // 3. Normalisasi
        $normalisasi = [];
        foreach ($matriks as $idBalita => $baris) {
            foreach ($baris as $idKriteria => $nilai) {
                $kriteria = $kriteriaList->firstWhere('id_kriteria', $idKriteria);
                if ($nilai == 0) {
                    $normalisasi[$idBalita][$idKriteria] = 0;
                    continue;
                }
                if ($kriteria->jenis === 'benefit') {
                    $normalisasi[$idBalita][$idKriteria] = $nilai / $maxMin[$idKriteria]['max'];
                } else { // cost
                    $normalisasi[$idBalita][$idKriteria] = $maxMin[$idKriteria]['min'] / $nilai;
                }
            }
        }

        // 4 & 5. Kalikan bobot, jumlahkan -> nilai preferensi
        $preferensi = [];
        foreach ($normalisasi as $idBalita => $baris) {
            $total = 0;
            foreach ($baris as $idKriteria => $rNilai) {
                $bobot = $kriteriaList->firstWhere('id_kriteria', $idKriteria)->bobot;
                $total += $bobot * $rNilai;
            }
            $preferensi[$idBalita] = $total;
        }

        // 6. Ranking (nilai tertinggi = risiko tertinggi = ranking 1)
        arsort($preferensi);
        $ranking = 1;
        $hasilAkhir = [];
        foreach ($preferensi as $idBalita => $nilaiPreferensi) {
            $hasilAkhir[] = [
                'id_balita' => $idBalita,
                'nilai_preferensi' => round($nilaiPreferensi, 4),
                'ranking' => $ranking++,
            ];
        }

        // Simpan ke tabel hasil
        Hasil::where('tanggal', Carbon::today())->delete(); // hapus hasil hari ini biar tidak duplikat
        foreach ($hasilAkhir as $item) {
            Hasil::create([
                'id_balita' => $item['id_balita'],
                'nilai_preferensi' => $item['nilai_preferensi'],
                'ranking' => $item['ranking'],
                'tanggal' => Carbon::today(),
            ]);
        }

        return $hasilAkhir;
    }
}
```

## Kategori Risiko (opsional, tapi memudahkan interpretasi hasil di UI)

Karena nilai preferensi berupa angka 0–1, tambahkan pemetaan kategori supaya
petugas puskesmas mudah membaca:

```php
function kategoriRisiko(float $nilai): string
{
    return match (true) {
        $nilai >= 0.7 => 'Risiko Tinggi',
        $nilai >= 0.4 => 'Risiko Sedang',
        default => 'Risiko Rendah',
    };
}
```

> Ambang batas (0.7 dan 0.4) ini contoh awal — sebaiknya didiskusikan dengan
> pembimbing/pihak puskesmas berdasarkan data riil, lalu dicantumkan sebagai
> justifikasi di BAB VI.

## Menghubungkan ke Controller & Route (Masih Tanpa Login)

```bash
php artisan make:controller PerhitunganController
php artisan make:controller HasilController
```

```php
// app/Http/Controllers/PerhitunganController.php
class PerhitunganController extends Controller
{
    public function hitung()
    {
        (new \App\Services\SawService())->hitung();
        return redirect()->route('hasil.index')->with('success', 'Perhitungan SAW berhasil dijalankan');
    }
}
```

```php
// app/Http/Controllers/HasilController.php
class HasilController extends Controller
{
    public function index()
    {
        $hasil = \App\Models\Hasil::with('balita')->orderBy('ranking')->get();
        return view('hasil.index', compact('hasil'));
    }
}
```

```php
// routes/web.php — tambahkan di bawah routes dari file 04
Route::post('/hitung-saw', [\App\Http\Controllers\PerhitunganController::class, 'hitung'])->name('hitung.saw');
Route::get('/hasil', [\App\Http\Controllers\HasilController::class, 'index'])->name('hasil.index');
```

Buat halaman `resources/views/hasil/index.blade.php` menampilkan tabel hasil
(nama balita, nilai preferensi, ranking) + tombol untuk memicu `hitung-saw`.

## Checklist Sebelum Lanjut ke File 06

- [ ] Tombol "Hitung SAW" berhasil menjalankan perhitungan dan menyimpan ke tabel `hasil`
- [ ] Hasil ranking yang tampil di halaman **sama persis** dengan hitungan manual (bandingkan angkanya satu-satu)
- [ ] Kalau ada data balita baru ditambahkan lalu dihitung ulang, ranking ter-update dengan benar

Kalau ini semua sudah benar — **baru** lanjut ke file 06 untuk memasang
login dan pembagian akses Admin/Petugas.

## Unit Test untuk Validasi Rumus

Supaya yakin implementasi PHP sama persis dengan hitungan manual:

```bash
php artisan make:test SawServiceTest --unit
```

```php
public function test_perhitungan_saw_sesuai_manual()
{
    // Seed data balita A, B, C dan nilai sesuai contoh di dokumen ini
    // ...
    $hasil = (new \App\Services\SawService())->hitung();
    $this->assertEquals(0.7, round($hasil[0]['nilai_preferensi'] ?? 0, 4));
}
```

Ini juga jadi bukti pengujian otomatis yang bisa disebut di BAB V (Pengujian).
