@extends('layouts.app')

@section('page_title', 'Input Nilai Balita')

@section('content')
<style>
    /* Styling Tabel Utama & Font Mungil */
    table.table-nilai {
        font-size: 0.75rem;
    }

    table.table-nilai > thead > tr > th {
        background-color: #3b5bfd !important;
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        vertical-align: middle;
        font-size: 0.78rem;
        padding-top: 6px !important;
        padding-bottom: 6px !important;
        text-align: center;
    }

    table.table-nilai > thead > tr > th.text-start {
        text-align: left !important;
    }

    /* Padding Baris Tabel Utama Dipadatkan */
    table.table-nilai > tbody > tr > td {
        padding-top: 6px !important;
        padding-bottom: 6px !important;
        vertical-align: middle;
    }

    /* Penyesuaian Ukuran Tombol Aksi */
    .btn-action-custom {
        font-size: 0.7rem !important;
        padding: 0 8px !important;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0" style="color:#1e2129;">Penilaian Balita</h2>
</div>

<div class="card border-0 shadow-sm rounded-4 p-3">

    <div class="table-responsive">
        @php
            // Ambil daftar kriteria secara otomatis dari data balita atau dari Model Kriteria
            $kriteriaList = collect();
            foreach($balita as $b) {
                if($b->nilai->isNotEmpty()) {
                    $kriteriaList = $b->nilai->map(fn($n) => $n->kriteria);
                    break;
                }
            }
            if($kriteriaList->isEmpty() && class_exists('\App\Models\Kriteria')) {
                $kriteriaList = \App\Models\Kriteria::all();
            }
            $totalKriteria = $kriteriaList->count() > 0 ? $kriteriaList->count() : 1;
        @endphp

        <table class="table table-nilai align-middle mb-0" style="border-collapse: separate; border-spacing: 0; width: 100%;">
            <thead>
                {{-- Baris Header Pertama (Tingkat 1) --}}
                <tr>
                    <th rowspan="2" class="py-2 ps-3 text-start" style="width: 45px; border-top-left-radius: 10px !important;">No</th>
                    <th rowspan="2" class="py-2 text-start" style="min-width: 140px;">Nama Balita</th>
                    <th rowspan="2" class="py-2" style="min-width: 110px;">Status</th>
                    
                    {{-- Judul Utama tetap Nilai Per Kriteria (Menggabungkan Kolom di bawahnya) --}}
                    <th colspan="{{ $totalKriteria }}" class="py-2 text-center">Nilai Per Kriteria</th>
                    
                    <th rowspan="2" class="py-2 pe-3 text-center" style="width: 140px; border-top-right-radius: 10px !important;">Aksi</th>
                </tr>

                {{-- Baris Header Kedua (Tingkat 2: Nama Kriteria di Bawah Judul Utama) --}}
                <tr>
                    @if($kriteriaList->isNotEmpty())
                        @foreach($kriteriaList as $k)
                            <th class="py-1 text-center" style="min-width: 75px; font-size: 0.72rem; background-color: #2b4be3 !important;">
                                {{ $k->nama_kriteria }}
                            </th>
                        @endforeach
                    @else
                        <th class="py-1 text-center" style="min-width: 100px; font-size: 0.72rem; background-color: #2b4be3 !important;">
                            -
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($balita as $index => $item)
                    <tr style="border-bottom: 1px solid #eef0f4;">
                        <td class="ps-3 text-muted text-start">{{ $balita->firstItem() + $index }}</td>
                        <td class="fw-semibold text-start" style="color:#1e2129;">{{ $item->nama_balita }}</td>
                        <td class="text-center">
                            @if($item->nilai->isEmpty())
                                <span class="badge rounded-pill px-2 py-1 fw-normal" style="background-color:#fde8e8; color:#e5484d; font-size:0.68rem;">
                                    Belum Dinilai
                                </span>
                            @else
                                <span class="badge rounded-pill px-2 py-1 fw-normal" style="background-color:#e3f6e8; color:#2e9e5b; font-size:0.68rem;">
                                    Sudah Dinilai
                                </span>
                            @endif
                        </td>

                        {{-- Isi Nilai Berada Tepat di Bawah Kolom Nama Kriteria Masing-Masing --}}
                        @if($kriteriaList->isNotEmpty())
                            @foreach($kriteriaList as $k)
                                @php
                                    $nilaiKriteria = $item->nilai->firstWhere('id_kriteria', $k->id_kriteria);
                                @endphp
                                <td class="text-center fw-semibold text-dark">
                                    {{ $nilaiKriteria ? $nilaiKriteria->nilai : '-' }}
                                </td>
                            @endforeach
                        @else
                            <td class="text-center text-muted small">-</td>
                        @endif

                        <td class="pe-3 text-center">
                            @if($item->nilai->isNotEmpty())
                                <div class="d-inline-flex align-items-center justify-content-center gap-1">
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('admin.nilai.edit', $item->id_balita) }}" 
                                       class="btn btn-sm text-white rounded-3 btn-action-custom d-inline-flex align-items-center justify-content-center" 
                                       style="background-color:#f5a623; min-width: 55px; height: 26px;">
                                        Edit
                                    </a>

                                    {{-- Form & Tombol Hapus --}}
                                    <form action="{{ route('admin.nilai.destroy', $item->id_balita) }}" 
                                          method="POST" 
                                          class="d-inline m-0 p-0" 
                                          onsubmit="return confirm('Hapus nilai balita ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm text-white rounded-3 btn-action-custom d-inline-flex align-items-center justify-content-center" 
                                                style="background-color:#e5484d; min-width: 55px; height: 26px;">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            @else
                                {{-- Tombol Input Nilai --}}
                                <a href="{{ route('admin.nilai.create', $item->id_balita) }}" 
                                   class="btn btn-sm text-white rounded-3 btn-action-custom d-inline-flex align-items-center justify-content-center" 
                                   style="background-color:#3b5bfd; min-width: 85px; height: 26px;">
                                    Input Nilai
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ 4 + $totalKriteria }}" class="text-center text-muted py-3">
                            Belum ada data balita.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $balita->links() }}
    </div>
</div>
@endsection