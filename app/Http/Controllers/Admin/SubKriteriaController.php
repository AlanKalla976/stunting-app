<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class SubKriteriaController extends Controller
{
    public function index()
    {
        $subKriteria = SubKriteria::with('kriteria')->latest()->get();
        return view('admin.sub_kriteria.index', compact('subKriteria'));
    }

    public function create()
    {
        $kriteria = Kriteria::all();
        return view('admin.sub_kriteria.create', compact('kriteria'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sub' => 'required|string|max:100',
            'id_kriteria' => 'required|exists:kriteria,id_kriteria',
            'nilai_bobot' => 'required|numeric',
        ]);

        SubKriteria::create($request->all());

        return redirect()->route('admin.sub-kriteria.index')->with('success', 'Data sub kriteria berhasil ditambahkan');
    }

    public function edit(SubKriteria $subKriterium)
    {
        $kriteria = Kriteria::all();
        return view('admin.sub_kriteria.edit', ['subKriteria' => $subKriterium, 'kriteria' => $kriteria]);
    }

    public function update(Request $request, SubKriteria $subKriterium)
    {
        $request->validate([
            'nama_sub' => 'required|string|max:100',
            'id_kriteria' => 'required|exists:kriteria,id_kriteria',
            'nilai_bobot' => 'required|numeric',
        ]);

        $subKriterium->update($request->all());

        return redirect()->route('admin.sub-kriteria.index')->with('success', 'Data sub kriteria berhasil diperbarui');
    }

    public function destroy(SubKriteria $subKriterium)
    {
        $subKriterium->delete();

        return redirect()->route('admin.sub-kriteria.index')->with('success', 'Data sub kriteria berhasil dihapus');
    }
}
