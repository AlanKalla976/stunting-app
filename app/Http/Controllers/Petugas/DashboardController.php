<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Balita;
use App\Models\Kriteria;
use App\Models\Hasil;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBalita = Balita::count();
        $totalKriteria = Kriteria::count();
        $totalUser = User::count();
        
        $hasilTerakhir = Hasil::with('balita')->orderBy('ranking')->take(5)->get();

        $jumlahTinggi = Hasil::where('nilai_preferensi', '>=', 0.7)->count();
        $jumlahSedang = Hasil::where('nilai_preferensi', '>=', 0.4)->where('nilai_preferensi', '<', 0.7)->count();
        $jumlahRendah = Hasil::where('nilai_preferensi', '<', 0.4)->count();

        return view('petugas.dashboard', compact(
            'totalBalita',
            'totalKriteria',
            'totalUser',
            'hasilTerakhir',
            'jumlahTinggi',
            'jumlahSedang',
            'jumlahRendah'
        ));
    }
}
