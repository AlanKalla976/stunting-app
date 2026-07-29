@extends('layouts.app')

@section('page_title', 'Hasil Perhitungan SAW')

@section('content')
<style>
    table.table-hasil > thead > tr > th {
        background-color: #3b5bfd !important;
        color: #ffffff !important;
        border: none !important;
        vertical-align: middle;
    }
    table.table-hasil > thead > tr > th:first-child {
        border-top-left-radius: 12px !important;
        border-bottom-left-radius: 12px !important;
    }
    table.table-hasil > thead > tr > th:last-child {
        border-top-right-radius: 12px !important;
        border-bottom-right-radius: 12px !important;
    }
</style>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <h2 class="fw-bold m-0" style="color:#1e2129;">Hasil Pemeringkatan Risiko Stunting Balita</h2>
    <div class="d-flex gap-2">
        <form action="{{ route('admin.perhitungan.hitung') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn text-white rounded-3 px-4 py-2 fw-semibold" style="background-color:#3b5bfd;">
                <i class="bi bi-cpu me-1"></i> Mulai Hitung SAW
            </button>
        </form>
        @if($hasil->isNotEmpty())
            <a href="{{ route('admin.hasil.cetak') }}" class="btn text-white rounded-3 px-4 py-2 fw-semibold" style="background-color:#e5484d;">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Cetak PDF
            </a>
        @endif
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4">

    <div class="table-responsive">
        <table class="table table-hasil align-middle mb-0" style="border-collapse: separate; border-spacing: 0;">
            <thead>
                <tr>
                    <th class="py-3 ps-4">Ranking</th>
                    <th class="py-3">Nama Balita</th>
                    <th class="py-3">Umur</th>
                    <th class="py-3">Alamat</th>
                    <th class="py-3">Skor (V)</th>
                    <th class="py-3">Risiko</th>
                    <th class="py-3 pe-4">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($hasil as $item)
                    @php
                        $kategori = \App\Services\SawService::kategoriRisiko($item->nilai_preferensi);
                        $rankBg = $item->ranking == 1 ? '#e5484d' : ($item->ranking == 2 ? '#f5a623' : ($item->ranking == 3 ? '#3b5bfd' : '#adb5bd'));
                    @endphp
                    <tr style="border-bottom: 1px solid #eef0f4;">
                        <td class="ps-4">
                            <span class="text-white fw-bold rounded-circle d-inline-flex align-items-center justify-content-center"
                                  style="width:28px; height:28px; background-color: {{ $rankBg }}; font-size:0.85rem;">
                                {{ $item->ranking }}
                            </span>
                        </td>
                        <td class="fw-semibold" style="color:#1e2129;">{{ $item->balita->nama_balita }}</td>
                        <td class="text-muted">{{ $item->balita->umur }} bln</td>
                        <td class="text-muted">{{ $item->balita->alamat }}</td>
                        <td class="fw-bold" style="color:#3b5bfd;">{{ $item->nilai_preferensi }}</td>
                        <td>
                            <span class="badge rounded-pill px-3 py-2 fw-normal"
                                  style="background-color: {{ $kategori === 'Risiko Tinggi' ? '#fde8e8' : ($kategori === 'Risiko Sedang' ? '#fff4e0' : '#e3f6e8') }};
                                         color: {{ $kategori === 'Risiko Tinggi' ? '#e5484d' : ($kategori === 'Risiko Sedang' ? '#c98a1c' : '#2e9e5b') }};
                                         font-size:0.8rem;">
                                {{ $kategori }}
                            </span>
                        </td>
                        <td class="pe-4">
                            @if($kategori === 'Risiko Tinggi')
                                <span class="small fw-semibold" style="color:#e5484d;">Prioritas Penanganan</span>
                            @elseif($kategori === 'Risiko Sedang')
                                <span class="small fw-semibold" style="color:#c98a1c;">Perlu Pemantauan</span>
                            @else
                                <span class="small" style="color:#2e9e5b;">Normal / Aman</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted p-4">
                            <i class="bi bi-info-circle fs-3 d-block mb-2 text-secondary"></i>
                            Belum ada hasil. Klik <strong>Mulai Hitung SAW</strong> untuk memulai kalkulasi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection