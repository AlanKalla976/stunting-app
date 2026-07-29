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
        // (jumlah nilai yang tersimpan == jumlah total kriteria)
        $balitaList = Balita::withCount('nilai')
            ->having('nilai_count', '=', $totalKriteria)
            ->get();

        if ($balitaList->isEmpty()) {
            return [];
        }

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
            if (empty($kolom)) {
                $maxMin[$kriteria->id_kriteria] = ['max' => 1, 'min' => 1];
                continue;
            }
            $maxMin[$kriteria->id_kriteria] = [
                'max' => max($kolom) ?: 1,
                'min' => min($kolom) ?: 1,
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
        Hasil::truncate(); // hapus SEMUA hasil lama, bukan cuma hari ini
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
        return match (true) {
            $nilai >= 0.7 => 'Risiko Tinggi',
            $nilai >= 0.4 => 'Risiko Sedang',
            default => 'Risiko Rendah',
        };
    }
}