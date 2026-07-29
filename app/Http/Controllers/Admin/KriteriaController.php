<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::all();
        return view('admin.kriteria.index', compact('kriteria'));
    }

    public function create()
    {
        return view('admin.kriteria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kriteria' => 'required|string|max:100',
            'jenis' => 'required|in:benefit,cost',
            'bobot' => 'required|numeric|between:0,1',
        ]);

        Kriteria::create($request->all());

        return redirect()->route('admin.kriteria.index')->with('success', 'Data kriteria berhasil ditambahkan');
    }

    public function edit(Kriteria $kriterium)
    {
        return view('admin.kriteria.edit', ['kriteria' => $kriterium]);
    }

    public function update(Request $request, Kriteria $kriterium)
    {
        $request->validate([
            'nama_kriteria' => 'required|string|max:100',
            'jenis' => 'required|in:benefit,cost',
            'bobot' => 'required|numeric|between:0,1',
        ]);

        $kriterium->update($request->all());

        return redirect()->route('admin.kriteria.index')->with('success', 'Data kriteria berhasil diperbarui');
    }

    public function destroy(Kriteria $kriterium)
    {
        $kriterium->delete();

        return redirect()->route('admin.kriteria.index')->with('success', 'Data kriteria berhasil dihapus');
    }
}
