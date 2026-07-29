<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Balita;
use Illuminate\Http\Request;

class BalitaController extends Controller
{
    public function index()
    {
        $balita = Balita::latest()->paginate(10);
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
            'alamat' => 'required|string|max:100',
        ]);

        Balita::create($request->all());

        return redirect()->route('petugas.balita.index')->with('success', 'Data balita berhasil ditambahkan');
    }
}
