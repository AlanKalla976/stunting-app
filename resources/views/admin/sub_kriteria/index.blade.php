@extends('layouts.app')

@section('page_title', 'Sub Kriteria')

@section('content')
<style>
    table.table-sub-kriteria > thead > tr > th {
        background-color: #3b5bfd !important;
        color: #ffffff !important;
        border: none !important;
        vertical-align: middle;
    }
    table.table-sub-kriteria > thead > tr > th:first-child {
        border-top-left-radius: 12px !important;
        border-bottom-left-radius: 12px !important;
    }
    table.table-sub-kriteria > thead > tr > th:last-child {
        border-top-right-radius: 12px !important;
        border-bottom-right-radius: 12px !important;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0" style="color:#1e2129;">Daftar Sub Kriteria</h2>
    <a href="{{ route('admin.sub-kriteria.create') }}" class="btn text-white rounded-3 px-4 py-2 fw-semibold" style="background-color:#3b5bfd;">
        <i class="bi bi-plus-lg me-1"></i> Tambah Sub Kriteria
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4">

    <div class="table-responsive">
        <table class="table table-sub-kriteria align-middle mb-0" style="border-collapse: separate; border-spacing: 0;">
            <thead>
                <tr>
                    <th class="py-3 ps-4">No</th>
                    <th class="py-3">Kriteria Induk</th>
                    <th class="py-3">Nama Sub Kriteria</th>
                    <th class="py-3">Skor Nilai</th>
                    <th class="py-3 pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subKriteria as $index => $item)
                    <tr style="border-bottom: 1px solid #eef0f4;">
                        <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                        <td>
                            <span class="badge rounded-pill px-3 py-2 fw-normal"
                                  style="background-color:#e7ecff; color:#3b5bfd; font-size:0.8rem;">
                                {{ $item->kriteria->nama_kriteria }}
                            </span>
                        </td>
                        <td class="fw-semibold" style="color:#1e2129;">{{ $item->nama_sub }}</td>
                        <td class="text-muted">{{ $item->nilai_bobot }}</td>
                        <td class="pe-4">
                            <a href="{{ route('admin.sub-kriteria.edit', $item->id_sub) }}"
                               class="btn btn-sm text-white rounded-3 px-3 me-1" style="background-color:#f5a623;">
                                Edit
                            </a>
                            <form action="{{ route('admin.sub-kriteria.destroy', $item->id_sub) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus sub kriteria ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm text-white rounded-3 px-3" style="background-color:#e5484d;">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada data sub kriteria.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection