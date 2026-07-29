<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SawService;
use Illuminate\Http\Request;

class PerhitunganController extends Controller
{
    public function hitung()
    {
        $sawService = new SawService();
        $hasil = $sawService->hitung();

        if (empty($hasil)) {
            return redirect()->back()->with('error', 'Gagal melakukan perhitungan. Pastikan data balita, kriteria, dan nilai sudah terisi.');
        }

        return redirect()->route('admin.hasil.index')->with('success', 'Perhitungan SAW berhasil dijalankan.');
    }
}
