<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Balita;
use Illuminate\Http\Request;

class BalitaController extends Controller
{
    public function index(Request $request)
    {
        $balita = Balita::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('nama_balita', 'like', '%' . $request->search . '%')
                      ->orWhere('alamat', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->filled('jenis_kelamin'), function ($query) use ($request) {
                $query->where('jenis_kelamin', $request->jenis_kelamin);
            })
            ->when($request->filled('status_imunisasi_dasar'), function ($query) use ($request) {
                $query->where('status_imunisasi_dasar', $request->status_imunisasi_dasar);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('petugas.balita.index', compact('balita'));
    }

    public function create()
    {
        return view('petugas.balita.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_balita' => 'required|string|max:100',
            'umur' => 'required|string|max:10',
            'jenis_kelamin' => 'required|in:L,P',
            'tinggi_badan' => 'required|numeric|min:0|max:200',
            'berat_badan' => 'required|numeric|min:0|max:100',
            'alamat' => 'required|string|max:100',
            'kondisi_ekonomi' => 'required|in:Rendah,Menengah,Tinggi',
            'sanitasi_lingkungan' => 'required|in:Baik,Cukup,Kurang',
            'riwayat_asi' => 'required|in:ASI Eksklusif,Tidak ASI Eksklusif',
            'status_imunisasi_dasar' => 'required|in:Lengkap,Tidak Lengkap',
        ]);

        Balita::create($request->all());

        return redirect()->route('petugas.balita.index')->with('success', 'Data balita berhasil ditambahkan');
    }

    public function show(Balita $balitum)
    {
        return view('petugas.balita.show', ['balita' => $balitum]);
    }

    public function edit(Balita $balitum)
    {
        return view('petugas.balita.edit', ['balita' => $balitum]);
    }

    public function update(Request $request, Balita $balitum)
    {
        $request->validate([
            'nama_balita' => 'required|string|max:100',
            'umur' => 'required|string|max:10',
            'jenis_kelamin' => 'required|in:L,P',
            'tinggi_badan' => 'required|numeric|min:0|max:200',
            'berat_badan' => 'required|numeric|min:0|max:100',
            'alamat' => 'required|string|max:100',
            'kondisi_ekonomi' => 'required|in:Rendah,Menengah,Tinggi',
            'sanitasi_lingkungan' => 'required|in:Baik,Cukup,Kurang',
            'riwayat_asi' => 'required|in:ASI Eksklusif,Tidak ASI Eksklusif',
            'status_imunisasi_dasar' => 'required|in:Lengkap,Tidak Lengkap',
        ]);

        $balitum->update($request->all());

        return redirect()->route('petugas.balita.index')->with('success', 'Data balita berhasil diperbarui');
    }
}