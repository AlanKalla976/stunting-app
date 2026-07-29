@extends('layouts.app')

@section('page_title', 'Data Kriteria')

@section('content')
<style>
    table.table-kriteria > thead > tr > th {
        background-color: #3b5bfd !important;
        color: #ffffff !important;
        border: none !important;
        vertical-align: middle;
    }
    table.table-kriteria > thead > tr > th:first-child {
        border-top-left-radius: 12px !important;
        border-bottom-left-radius: 12px !important;
    }
    table.table-kriteria > thead > tr > th:last-child {
        border-top-right-radius: 12px !important;
        border-bottom-right-radius: 12px !important;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0" style="color:#1e2129;">Daftar Kriteria SAW</h2>
    <a href="{{ route('admin.kriteria.create') }}" class="btn text-white rounded-3 px-4 py-2 fw-semibold" style="background-color:#3b5bfd;">
        <i class="bi bi-plus-lg me-1"></i> Tambah Kriteria
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4">

    <div class="table-responsive">
        <table class="table table-kriteria align-middle mb-0" style="border-collapse: separate; border-spacing: 0;">
            <thead>
                <tr>
                    <th class="py-3 ps-4">No</th>
                    <th class="py-3">Nama Kriteria</th>
                    <th class="py-3">Jenis</th>
                    <th class="py-3">Bobot</th>
                    <th class="py-3 pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $totalBobot = 0; @endphp
                @forelse($kriteria as $index => $item)
                    @php $totalBobot += $item->bobot; @endphp
                    <tr style="border-bottom: 1px solid #eef0f4;">
                        <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                        <td class="fw-semibold" style="color:#1e2129;">{{ $item->nama_kriteria }}</td>
                        <td>
                            <span class="badge rounded-pill px-3 py-2 fw-normal"
                                  style="background-color: {{ $item->jenis === 'benefit' ? '#e3f6e8' : '#fff4e0' }}; color: {{ $item->jenis === 'benefit' ? '#2e9e5b' : '#c98a1c' }}; font-size:0.8rem;">
                                {{ ucfirst($item->jenis) }}
                            </span>
                        </td>
                        <td class="text-muted">{{ $item->bobot }}</td>
                        <td class="pe-4">
                            <a href="{{ route('admin.kriteria.edit', $item->id_kriteria) }}"
                               class="btn btn-sm text-white rounded-3 px-3 me-1" style="background-color:#f5a623;">
                                Edit
                            </a>
                            <form action="{{ route('admin.kriteria.destroy', $item->id_kriteria) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus kriteria ini?')">
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
                        <td colspan="5" class="text-center text-muted py-4">Belum ada data kriteria.</td>
                    </tr>
                @endforelse
            </tbody>
            @if(!$kriteria->isEmpty())
                <tfoot>
                    <tr class="fw-bold" style="background-color:#f7f8fa;">
                        <td colspan="3" class="text-end py-3 ps-4">Total Bobot:</td>
                        <td colspan="2" class="py-3 pe-4 {{ abs($totalBobot - 1) < 0.0001 ? '' : '' }}"
                            style="color: {{ abs($totalBobot - 1) < 0.0001 ? '#2e9e5b' : '#e5484d' }};">
                            {{ $totalBobot }}
                            @if(abs($totalBobot - 1) > 0.0001)
                                <small class="d-block fw-normal" style="color:#e5484d;">(Peringatan: Total bobot harus = 1.0!)</small>
                            @endif
                        </td>
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection