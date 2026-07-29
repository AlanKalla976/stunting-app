@extends('layouts.app')

@section('page_title', 'Petugas Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <!-- Total Balita -->
    <div class="col-12 col-md-6">
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
    <div class="col-12 col-md-6">
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
</div>

<!-- Risk Categories Breakdowns -->
<div class="row g-4 mb-4">
    <div class="col-12 col-md-4">
        <div class="card card-custom border-0 bg-danger text-white p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 text-uppercase fw-semibold" style="font-size: 0.75rem; opacity: 0.8;">Risiko Tinggi (>= 0.7)</h6>
                    <h2 class="m-0 fw-bold">{{ $jumlahTinggi }}</h2>
                </div>
                <i class="bi bi-exclamation-triangle-fill fs-1" style="opacity: 0.5;"></i>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="card card-custom border-0 bg-warning text-dark p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 text-uppercase fw-semibold" style="font-size: 0.75rem; opacity: 0.8;">Risiko Sedang (0.4 - 0.7)</h6>
                    <h2 class="m-0 fw-bold">{{ $jumlahSedang }}</h2>
                </div>
                <i class="bi bi-exclamation-circle-fill fs-1" style="opacity: 0.5;"></i>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="card card-custom border-0 bg-success text-white p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 text-uppercase fw-semibold" style="font-size: 0.75rem; opacity: 0.8;">Risiko Rendah (< 0.4)</h6>
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
        <div class="card card-custom border-0 bg-white p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold m-0 text-secondary">5 Balita dengan Risiko Stunting Tertinggi</h5>
                <a href="{{ route('petugas.hasil.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Ranking</th>
                            <th>Nama Balita</th>
                            <th>Nilai Preferensi</th>
                            <th>Status Risiko</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hasilTerakhir as $item)
                            <tr>
                                <td class="fw-bold"><span class="badge bg-dark rounded-circle p-2" style="width: 25px; height: 25px; display: inline-flex; align-items: center; justify-content: center;">{{ $item->ranking }}</span></td>
                                <td>{{ $item->balita->nama_balita }}</td>
                                <td>{{ $item->nilai_preferensi }}</td>
                                <td>
                                    @php
                                        $kategori = \App\Services\SawService::kategoriRisiko($item->nilai_preferensi);
                                    @endphp
                                    <span class="badge {{ $kategori === 'Risiko Tinggi' ? 'bg-danger' : ($kategori === 'Risiko Sedang' ? 'bg-warning text-dark' : 'bg-success') }}">
                                        {{ $kategori }}
                                    </span>
                                </td>
                                <td>{{ $item->tanggal }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada hasil perhitungan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
