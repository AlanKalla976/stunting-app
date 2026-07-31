@extends('layouts.app')

@section('page_title', 'Admin Dashboard')

@section('content')
<style>
    table.table-dashboard > thead > tr > th {
        background-color: #3b5bfd !important;
        color: #ffffff !important;
        border: none !important;
        vertical-align: middle;
    }
    table.table-dashboard > thead > tr > th:first-child {
        border-top-left-radius: 12px !important;
        border-bottom-left-radius: 12px !important;
    }
    table.table-dashboard > thead > tr > th:last-child {
        border-top-right-radius: 12px !important;
        border-bottom-right-radius: 12px !important;
    }
</style>

<div class="row g-4 mb-4">
    <!-- Total Balita -->
    <div class="col-12 col-md-4">
        <div class="card card-custom p-3 border-0 bg-white">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 bg-primary-subtle text-primary rounded-circle p-3 me-3">
                    <i class="bi bi-people-fill fs-3"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1 text-uppercase fw-semibold" style="font-size: 0.75rem;">Total Balita</h6>
                    <h3 class="m-0 fw-bold">{{ $totalBalita }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Kriteria -->
    <div class="col-12 col-md-4">
        <div class="card card-custom p-3 border-0 bg-white">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 bg-success-subtle text-success rounded-circle p-3 me-3">
                    <i class="bi bi-list-stars fs-3"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1 text-uppercase fw-semibold" style="font-size: 0.75rem;">Total Kriteria</h6>
                    <h3 class="m-0 fw-bold">{{ $totalKriteria }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Users -->
    <div class="col-12 col-md-4">
        <div class="card card-custom p-3 border-0 bg-white">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 bg-info-subtle text-info rounded-circle p-3 me-3">
                    <i class="bi bi-person-badge-fill fs-3"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1 text-uppercase fw-semibold" style="font-size: 0.75rem;">Total Pengguna</h6>
                    <h3 class="m-0 fw-bold">{{ $totalUser }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Risk Categories Breakdowns -->
<div class="row g-4 mb-4">
    <div class="col-12 col-md-4">
        <div class="card card-custom border-0 text-white p-3" style="background-color:#e5484d;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 text-uppercase fw-semibold" style="font-size: 0.75rem; opacity: 0.85;">Risiko Tinggi</h6>
                    <h2 class="m-0 fw-bold">{{ $jumlahTinggi }}</h2>
                </div>
                <i class="bi bi-exclamation-triangle-fill fs-1" style="opacity: 0.5;"></i>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="card card-custom border-0 text-white p-3" style="background-color:#f5a623;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 text-uppercase fw-semibold" style="font-size: 0.75rem; opacity: 0.85;">Risiko Sedang</h6>
                    <h2 class="m-0 fw-bold">{{ $jumlahSedang }}</h2>
                </div>
                <i class="bi bi-exclamation-circle-fill fs-1" style="opacity: 0.5;"></i>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="card card-custom border-0 text-white p-3" style="background-color:#2e9e5b;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 text-uppercase fw-semibold" style="font-size: 0.75rem; opacity: 0.85;">Risiko Rendah</h6>
                    <h2 class="m-0 fw-bold">{{ $jumlahRendah }}</h2>
                </div>
                <i class="bi bi-check-circle-fill fs-1" style="opacity: 0.5;"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Latest calculation result -->
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold m-0" style="color:#1e2129;">5 Balita dengan Risiko Stunting Tertinggi</h5>
                <a href="{{ route('admin.hasil.index') }}" class="btn btn-sm rounded-3 px-3 fw-semibold" style="background-color:#e7ecff; color:#3b5bfd; border:none;">
                    Lihat Semua
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-dashboard align-middle mb-0" style="border-collapse: separate; border-spacing: 0;">
                    <thead>
                        <tr>
                            <th class="py-3 ps-4">Ranking</th>
                            <th class="py-3">Nama Balita</th>
                            <th class="py-3">Nilai Preferensi</th>
                            <th class="py-3">Status Risiko</th>
                            <th class="py-3 pe-4">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hasilTerakhir as $item)
                            @php
                                $kategori = \App\Services\SawService::kategoriRisiko($item->nilai_preferensi);
                                $rankBg = $item->ranking == 1 ? '#e5484d' : ($item->ranking == 2 ? '#f5a623' : ($item->ranking == 3 ? '#3b5bfd' : '#adb5bd'));
                            @endphp
                            <tr style="border-bottom: 1px solid #eef0f4;">
                                <td class="ps-4">
                                    <span class="text-white fw-bold rounded-circle d-inline-flex align-items-center justify-content-center"
                                          style="width:25px; height:25px; background-color: {{ $rankBg }}; font-size:0.8rem;">
                                        {{ $item->ranking }}
                                    </span>
                                </td>
                                <td class="fw-semibold" style="color:#1e2129;">{{ $item->balita->nama_balita ?? '-' }}</td>
                                <td class="text-muted">{{ number_format($item->nilai_preferensi, 3) }}</td>
                                <td>
                                    <span class="badge rounded-pill px-3 py-2 fw-normal"
                                          style="background-color: {{ $kategori === 'Risiko Tinggi' ? '#fde8e8' : ($kategori === 'Risiko Sedang' ? '#fff4e0' : '#e3f6e8') }};
                                                 color: {{ $kategori === 'Risiko Tinggi' ? '#e5484d' : ($kategori === 'Risiko Sedang' ? '#c98a1c' : '#2e9e5b') }};
                                                 font-size:0.8rem;">
                                        {{ $kategori }}
                                    </span>
                                </td>
                                <td class="pe-4 text-muted">{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') : '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Belum ada hasil perhitungan. Silakan jalankan perhitungan SAW.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection