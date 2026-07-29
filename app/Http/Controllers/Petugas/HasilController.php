<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Hasil;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class HasilController extends Controller
{
    public function index()
    {
        $hasil = Hasil::with('balita')->orderBy('ranking')->get();
        return view('petugas.hasil.index', compact('hasil'));
    }

    public function cetak()
    {
        $hasil = Hasil::with('balita')->orderBy('ranking')->get();
        
        $pdf = Pdf::loadView('petugas.hasil.cetak', compact('hasil'));
        return $pdf->download('laporan-spk-stunting-' . date('Y-m-d') . '.pdf');
    }
}
