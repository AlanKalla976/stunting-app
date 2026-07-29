<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Balita;
use Illuminate\Http\Request;

class BalitaController extends Controller
{
    public function index()
    {
        $balita = Balita::latest()->paginate(10);
        return view('admin.balita.index', compact('balita'));
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
            'alamat' => 'required|string|max:100',
        ]);

        Balita::create($request->all());

        return redirect()->route('admin.balita.index')->with('success', 'Data balita berhasil ditambahkan');
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
            'alamat' => 'required|string|max:100',
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
