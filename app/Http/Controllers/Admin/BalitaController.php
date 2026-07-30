<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Balita;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class BalitaController extends Controller
{
    public function index()
    {
        $balita = Balita::latest()->paginate(10);
        return view('admin.balita.index', compact('balita'));
    }

    public function cetak()
    {
        $balita = Balita::latest()->get();

        $pdf = Pdf::loadView('admin.balita.cetak', compact('balita'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('data-balita-' . now()->format('Y-m-d') . '.pdf');
    }

    public function create()
    {
        return view('admin.balita.create');
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

        return redirect()->route('admin.balita.index')->with('success', 'Data balita berhasil ditambahkan');
    }

    public function show(Balita $balitum)
    {
        return view('admin.balita.show', ['balita' => $balitum]);
    }

    public function edit(Balita $balitum)
    {
        return view('admin.balita.edit', ['balita' => $balitum]);
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

        return redirect()->route('admin.balita.index')->with('success', 'Data balita berhasil diperbarui');
    }

    public function destroy(Balita $balitum)
    {
        $balitum->delete();

        return redirect()->route('admin.balita.index')->with('success', 'Data balita berhasil dihapus');
    }
}