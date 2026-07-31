@extends('layouts.app')

@section('page_title', 'Data Balita (Admin)')

@section('content')
<style>
    table.table-balita {
        font-size: 0.82rem;
    }
    table.table-balita > thead > tr > th {
        background-color: #3b5bfd !important;
        color: #ffffff !important;
        border: none !important;
        vertical-align: middle;
        font-size: 0.78rem;
        white-space: nowrap;
        padding-top: 10px !important;
        padding-bottom: 10px !important;
    }
    table.table-balita > thead > tr > th:first-child {
        border-top-left-radius: 12px !important;
        border-bottom-left-radius: 12px !important;
    }
    table.table-balita > thead > tr > th:last-child {
        border-top-right-radius: 12px !important;
        border-bottom-right-radius: 12px !important;
    }
    table.table-balita > tbody > tr > td {
        padding-top: 8px !important;
        padding-bottom: 8px !important;
        vertical-align: middle;
    }
    table.table-balita .badge {
        font-size: 0.72rem !important;
        padding: 5px 10px !important;
    }
    table.table-balita .btn-sm {
        font-size: 0.72rem;
        padding: 4px 10px;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0" style="color:#1e2129;">Daftar Balita</h2>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.balita.cetak') }}" target="_blank"
           class="btn rounded-3 px-4 py-2 fw-semibold" style="background-color:#e5484d; color:#ffffff;">
            <i class="bi bi-printer me-1"></i> Cetak PDF
        </a>
        <a href="{{ route('admin.balita.create') }}" class="btn text-white rounded-3 px-4 py-2 fw-semibold" style="background-color:#3b5bfd;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Balita
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4">

    <form method="GET" class="row g-2 mb-4 align-items-end">
        <div class="col-md-4">
            <label class="form-label small fw-semibold text-secondary mb-1">Cari</label>
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama atau alamat..." style="height:45px;">
        </div>

        <div class="col-md-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-select" style="height:45px;">
                <option value="">Semua</option>
                <option value="L" {{ request('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ request('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label small fw-semibold text-secondary mb-1">Status Imunisasi</label>
            <select name="status_imunisasi_dasar" class="form-select" style="height:45px;">
                <option value="">Semua</option>
                <option value="Lengkap" {{ request('status_imunisasi_dasar') === 'Lengkap' ? 'selected' : '' }}>Lengkap</option>
                <option value="Tidak Lengkap" {{ request('status_imunisasi_dasar') === 'Tidak Lengkap' ? 'selected' : '' }}>Tidak Lengkap</option>
            </select>
        </div>

        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn text-white fw-semibold w-100" style="background-color:#3b5bfd; height:45px; border-radius:8px;">
                Filter
            </button>
        </div>

        @if (request('search') || request('jenis_kelamin') || request('status_imunisasi_dasar'))
            <div class="col-12">
                <a href="{{ route('admin.balita.index') }}" class="small text-muted text-decoration-none">
                    <i class="bi bi-x-circle me-1"></i>Reset filter
                </a>
            </div>
        @endif
    </form>

    <div class="table-responsive">
        <table class="table table-balita align-middle mb-0" style="border-collapse: separate; border-spacing: 0;">
            <thead>
                <tr>
                    <th class="py-2 ps-3">No</th>
                    <th class="py-2">Nama</th>
                    <th class="py-2">Umur</th>
                    <th class="py-2">JK</th>
                    <th class="py-2">TB</th>
                    <th class="py-2">BB</th>
                    <th class="py-2">Alamat</th>
                    <th class="py-2">Ekonomi</th>
                    <th class="py-2">Sanitasi</th>
                    <th class="py-2">Riwayat ASI</th>
                    <th class="py-2">Imunisasi</th>
                    <th class="py-2 pe-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($balita as $index => $item)
                    <tr style="border-bottom: 1px solid #eef0f4;">
                        <td class="ps-3 text-muted">{{ $balita->firstItem() + $index }}</td>
                        <td class="fw-semibold" style="color:#1e2129;">{{ $item->nama_balita }}</td>
                        <td class="text-muted">{{ $item->umur }} bln</td>
                        <td>
                            <span class="badge rounded-pill fw-normal"
                                  style="background-color: {{ $item->jenis_kelamin === 'L' ? '#e7ecff' : '#fde8e8' }}; color: {{ $item->jenis_kelamin === 'L' ? '#3b5bfd' : '#e5484d' }};">
                                {{ $item->jenis_kelamin }}
                            </span>
                        </td>
                        <td class="text-muted">{{ $item->tinggi_badan }}</td>
                        <td class="text-muted">{{ $item->berat_badan }}</td>
                        <td class="text-muted text-truncate" style="max-width:120px;" title="{{ $item->alamat }}">{{ $item->alamat }}</td>
                        <td class="text-muted">{{ $item->kondisi_ekonomi }}</td>
                        <td class="text-muted">{{ $item->sanitasi_lingkungan }}</td>
                        <td class="text-muted">{{ $item->riwayat_asi }}</td>
                        <td>
                            <span class="badge rounded-pill fw-normal"
                                  style="background-color: {{ $item->status_imunisasi_dasar === 'Lengkap' ? '#e3f9e5' : '#fde8e8' }}; color: {{ $item->status_imunisasi_dasar === 'Lengkap' ? '#1f9d55' : '#e5484d' }};">
                                {{ $item->status_imunisasi_dasar }}
                            </span>
                        </td>
                        <td class="pe-3">
                            <div class="d-flex flex-column gap-1">
                                <a href="{{ route('admin.balita.show', $item->id_balita) }}"
                                   class="btn btn-sm text-white rounded-3" style="background-color:#3b5bfd;">
                                    Lihat
                                </a>
                                <a href="{{ route('admin.balita.edit', $item->id_balita) }}"
                                   class="btn btn-sm text-white rounded-3" style="background-color:#f5a623;">
                                    Edit
                                </a>
                                <form action="{{ route('admin.balita.destroy', $item->id_balita) }}" method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm text-white rounded-3 w-100" style="background-color:#e5484d;">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center text-muted py-4">Belum ada data balita.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $balita->appends(request()->query())->links() }}
    </div>
</div>
@endsection