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

        if ($kriteriaList->isEmpty()) {
            return [];
        }

        $totalKriteria = $kriteriaList->count();

        // Hanya ambil balita yang SUDAH dinilai lengkap
        $balitaList = Balita::withCount('nilai')
            ->having('nilai_count', '=', $totalKriteria)
            ->get();

        if ($balitaList->isEmpty()) {
            return [];
        }

        $idBalitaList = $balitaList->pluck('id_balita');

        // Ambil SEMUA nilai sekaligus dalam satu query
        $semuaNilai = Nilai::whereIn('id_balita', $idBalitaList)
            ->whereIn('id_kriteria', $kriteriaList->pluck('id_kriteria'))
            ->get()
            ->groupBy('id_balita');

        // 1. Susun matriks keputusan: [id_balita][id_kriteria] = nilai
        $matriks = [];
        foreach ($balitaList as $balita) {
            $nilaiBalita = $semuaNilai->get($balita->id_balita, collect())
                ->keyBy('id_kriteria');

            foreach ($kriteriaList as $kriteria) {
                $nilai = $nilaiBalita->get($kriteria->id_kriteria)?->nilai;
                $matriks[$balita->id_balita][$kriteria->id_kriteria] = (float) ($nilai ?? 0);
            }
        }

        // 2. Cari nilai max/min tiap kriteria
        $maxMin = [];
        foreach ($kriteriaList as $kriteria) {
            $kolom = array_column($matriks, $kriteria->id_kriteria);
            if (empty($kolom)) {
                $maxMin[$kriteria->id_kriteria] = ['max' => 1, 'min' => 1];
                continue;
            }
            $maxNilai = max($kolom);
            $minNilai = min($kolom);
            $maxMin[$kriteria->id_kriteria] = [
                'max' => $maxNilai > 0 ? $maxNilai : 1,
                'min' => $minNilai > 0 ? $minNilai : 1,
            ];
        }

        // 3. Normalisasi
        $normalisasi = [];
        foreach ($matriks as $idBalita => $baris) {
            foreach ($baris as $idKriteria => $nilai) {
                $kriteria = $kriteriaList->firstWhere('id_kriteria', $idKriteria);

                if ($nilai <= 0) {
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

        // 4 & 5. Kalikan bobot, jumlahkan -> nilai preferensi (Skor V)
        $preferensi = [];
        foreach ($normalisasi as $idBalita => $baris) {
            $total = 0;
            foreach ($baris as $idKriteria => $rNilai) {
                $bobot = (float) $kriteriaList->firstWhere('id_kriteria', $idKriteria)->bobot;
                $total += $bobot * $rNilai;
            }
            $preferensi[$idBalita] = round($total, 4);
        }

        // 6. RANKING: NILAI BESAR = RISIKO TERTINGGI = RANKING 1
        // arsort() mengurutkan array dari terbesar ke terkecil
        arsort($preferensi);

        $hasilAkhir = [];
        $posisi = 0;
        $rankingSaatIni = 0;
        $nilaiTerakhir = null;

        foreach ($preferensi as $idBalita => $nilaiPreferensi) {
            $posisi++;

            // Standard Competition Ranking (1, 1, 3, 4...)
            if ($nilaiPreferensi !== $nilaiTerakhir) {
                $rankingSaatIni = $posisi;
                $nilaiTerakhir = $nilaiPreferensi;
            }

            $hasilAkhir[] = [
                'id_balita' => $idBalita,
                'nilai_preferensi' => $nilaiPreferensi,
                'ranking' => $rankingSaatIni,
            ];
        }

        // Simpan ke DB
        Hasil::truncate();
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

    public static function kategoriRisiko(float $nilai): string
    {
        // Kategori sesuai batas skor pada foto
        return match (true) {
            $nilai >= 0.7 => 'Risiko Tinggi',
            $nilai >= 0.5 => 'Risiko Sedang',
            default => 'Risiko Rendah',
        };
    }
}