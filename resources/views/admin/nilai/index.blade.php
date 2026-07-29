@extends('layouts.app')

@section('page_title', 'Input Nilai Balita')

@section('content')
<style>
    table.table-nilai > thead > tr > th {
        background-color: #3b5bfd !important;
        color: #ffffff !important;
        border: none !important;
        vertical-align: middle;
    }
    table.table-nilai > thead > tr > th:first-child {
        border-top-left-radius: 12px !important;
        border-bottom-left-radius: 12px !important;
    }
    table.table-nilai > thead > tr > th:last-child {
        border-top-right-radius: 12px !important;
        border-bottom-right-radius: 12px !important;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0" style="color:#1e2129;">Penilaian Balita</h2>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4">

    <div class="table-responsive">
        <table class="table table-nilai align-middle mb-0" style="border-collapse: separate; border-spacing: 0;">
            <thead>
                <tr>
                    <th class="py-3 ps-4">No</th>
                    <th class="py-3">Nama Balita</th>
                    <th class="py-3">Status</th>
                    <th class="py-3">Nilai Per Kriteria</th>
                    <th class="py-3 pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($balita as $index => $item)
                    <tr style="border-bottom: 1px solid #eef0f4;">
                        <td class="ps-4 text-muted">{{ $balita->firstItem() + $index }}</td>
                        <td class="fw-semibold" style="color:#1e2129;">{{ $item->nama_balita }}</td>
                        <td>
                            @if($item->nilai->isEmpty())
                                <span class="badge rounded-pill px-3 py-2 fw-normal" style="background-color:#fde8e8; color:#e5484d; font-size:0.8rem;">
                                    Belum Dinilai
                                </span>
                            @else
                                <span class="badge rounded-pill px-3 py-2 fw-normal" style="background-color:#e3f6e8; color:#2e9e5b; font-size:0.8rem;">
                                    Sudah Dinilai
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($item->nilai->isNotEmpty())
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($item->nilai as $n)
                                        <span class="badge rounded-pill px-3 py-2 fw-normal" style="background-color:#e7ecff; color:#3b5bfd; font-size:0.75rem;">
                                            {{ $n->kriteria->nama_kriteria }}: <strong>{{ $n->nilai }}</strong>
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td class="pe-4">
                            @if($item->nilai->isNotEmpty())
                                <a href="{{ route('admin.nilai.edit', $item->id_balita) }}"
                                   class="btn btn-sm text-white rounded-3 px-3 me-1" style="background-color:#f5a623;">
                                    Edit
                                </a>
                                <form action="{{ route('admin.nilai.destroy', $item->id_balita) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus nilai balita ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm text-white rounded-3 px-3" style="background-color:#e5484d;">
                                        Hapus
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('admin.nilai.create', $item->id_balita) }}"
                                   class="btn btn-sm text-white rounded-3 px-3" style="background-color:#3b5bfd;">
                                    Input Nilai
                                </a>
                            @endif
                        </td>
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