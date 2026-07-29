<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Balita;
use App\Models\Kriteria;
use App\Models\Nilai;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NilaiController extends Controller
{
    /**
     * Tampilkan daftar balita beserta status penilaiannya.
     */
    public function index()
    {
        $balita = Balita::withCount('nilai')->orderBy('nama_balita')->paginate(10);

        return view('admin.nilai.index', compact('balita'));
    }

    /**
     * Tampilkan form input nilai untuk satu balita spesifik.
     */
    public function create($id_balita)
    {
        $balita = Balita::findOrFail($id_balita);

        // Cegah input ganda kalau balita ini sudah pernah dinilai
        if (Nilai::where('id_balita', $balita->id_balita)->exists()) {
            return redirect()
                ->route('admin.nilai.index')
                ->with('error', 'Balita ini sudah memiliki nilai. Silakan gunakan menu edit.');
        }

        $kriteria = Kriteria::with('subKriteria')->orderBy('nama_kriteria')->get();

        return view('admin.nilai.create', compact('balita', 'kriteria'));
    }

    /**
     * Simpan nilai baru untuk seluruh kriteria balita terkait.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_balita'  => ['required', 'exists:balita,id_balita'],
            'nilai'      => ['required', 'array'],
            'nilai.*'    => ['required'],
        ]);

        // Pastikan balita belum pernah dinilai (jaga-jaga akses langsung ke store)
        if (Nilai::where('id_balita', $validated['id_balita'])->exists()) {
            return redirect()
                ->route('admin.nilai.index')
                ->with('error', 'Balita ini sudah memiliki nilai. Silakan gunakan menu edit.');
        }

        $kriteria = Kriteria::with('subKriteria')->get();

        foreach ($validated['nilai'] as $id_kriteria => $value) {
            $k = $kriteria->firstWhere('id_kriteria', $id_kriteria);

            if (! $k) {
                continue;
            }

            if ($k->subKriteria->isNotEmpty()) {
                // Kriteria kualitatif -> value adalah id_sub
                // Ambil skor (nilai_bobot) dari sub kriteria yang dipilih
                $sub = $k->subKriteria->firstWhere('id_sub', $value);

                if (! $sub) {
                    continue; // id_sub yang dikirim tidak valid/tidak ditemukan
                }

                Nilai::create([
                    'id_balita'   => $validated['id_balita'],
                    'id_kriteria' => $id_kriteria,
                    'id_sub'      => $sub->id_sub,
                    'nilai'       => $sub->nilai_bobot,
                ]);
            } else {
                // Kriteria kuantitatif -> value adalah angka langsung
                Nilai::create([
                    'id_balita'   => $validated['id_balita'],
                    'id_kriteria' => $id_kriteria,
                    'id_sub'      => null,
                    'nilai'       => $value,
                ]);
            }
        }

        return redirect()
            ->route('admin.nilai.index')
            ->with('success', 'Nilai balita berhasil disimpan.');
    }

    /**
     * Tampilkan form edit nilai balita.
     */
    public function edit($id_balita)
    {
        $balita = Balita::findOrFail($id_balita);

        $kriteria = Kriteria::with('subKriteria')->orderBy('nama_kriteria')->get();

        // Kumpulan nilai balita ini, dikelompokkan per id_kriteria agar mudah diakses di view
        $nilai = Nilai::where('id_balita', $id_balita)
            ->get()
            ->keyBy('id_kriteria');

        return view('admin.nilai.edit', compact('balita', 'kriteria', 'nilai'));
    }

    /**
     * Perbarui nilai balita untuk seluruh kriteria.
     */
    public function update(Request $request, $id_balita)
    {
        $validated = $request->validate([
            'nilai'   => ['required', 'array'],
            'nilai.*' => ['required'],
        ]);

        $balita = Balita::findOrFail($id_balita);
        $kriteria = Kriteria::with('subKriteria')->get();

        foreach ($validated['nilai'] as $id_kriteria => $value) {
            $k = $kriteria->firstWhere('id_kriteria', $id_kriteria);

            if (! $k) {
                continue;
            }

            if ($k->subKriteria->isNotEmpty()) {
                $sub = $k->subKriteria->firstWhere('id_sub', $value);

                if (! $sub) {
                    continue;
                }

                $payload = [
                    'id_sub' => $sub->id_sub,
                    'nilai'  => $sub->nilai_bobot,
                ];
            } else {
                $payload = [
                    'id_sub' => null,
                    'nilai'  => $value,
                ];
            }

            Nilai::updateOrCreate(
                [
                    'id_balita'   => $balita->id_balita,
                    'id_kriteria' => $id_kriteria,
                ],
                $payload
            );
        }

        return redirect()
            ->route('admin.nilai.index')
            ->with('success', 'Nilai balita berhasil diperbarui.');
    }

    /**
     * Hapus seluruh nilai balita terkait.
     */
    public function destroy($id_balita)
    {
        Nilai::where('id_balita', $id_balita)->delete();

        return redirect()
            ->route('admin.nilai.index')
            ->with('success', 'Nilai balita berhasil dihapus.');
    }
}