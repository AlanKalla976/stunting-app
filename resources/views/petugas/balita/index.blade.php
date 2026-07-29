@extends('layouts.app')

@section('page_title', 'Data Balita (Petugas)')

@section('content')
<style>
    table.table-balita-petugas > thead > tr > th {
        background-color: #3b5bfd !important;
        color: #ffffff !important;
        border: none !important;
        vertical-align: middle;
    }
    table.table-balita-petugas > thead > tr > th:first-child {
        border-top-left-radius: 12px !important;
        border-bottom-left-radius: 12px !important;
    }
    table.table-balita-petugas > thead > tr > th:last-child {
        border-top-right-radius: 12px !important;
        border-bottom-right-radius: 12px !important;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0" style="color:#1e2129;">Daftar Balita</h2>
    <a href="{{ route('petugas.balita.create') }}" class="btn text-white rounded-3 px-4 py-2 fw-semibold" style="background-color:#3b5bfd;">
        <i class="bi bi-plus-lg me-1"></i> Tambah Balita
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4">

    <div class="table-responsive">
        <table class="table table-balita-petugas align-middle mb-0" style="border-collapse: separate; border-spacing: 0;">
            <thead>
                <tr>
                    <th class="py-3 ps-4">No</th>
                    <th class="py-3">Nama Balita</th>
                    <th class="py-3">Umur (Bulan)</th>
                    <th class="py-3">Jenis Kelamin</th>
                    <th class="py-3 pe-4">Alamat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($balita as $index => $item)
                    <tr style="border-bottom: 1px solid #eef0f4;">
                        <td class="ps-4 text-muted">{{ $balita->firstItem() + $index }}</td>
                        <td class="fw-semibold" style="color:#1e2129;">{{ $item->nama_balita }}</td>
                        <td class="text-muted">{{ $item->umur }} bulan</td>
                        <td>
                            <span class="badge rounded-pill px-3 py-2 fw-normal"
                                  style="background-color: {{ $item->jenis_kelamin === 'L' ? '#e7ecff' : '#fde8e8' }}; color: {{ $item->jenis_kelamin === 'L' ? '#3b5bfd' : '#e5484d' }}; font-size:0.8rem;">
                                {{ $item->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </td>
                        <td class="pe-4 text-muted">{{ $item->alamat }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada data balita.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $balita->links() }}
    </div>
</div>
@endsection