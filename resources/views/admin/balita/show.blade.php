@extends('layouts.app')

@section('page_title', 'Detail Data Balita (Admin)')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-custom border-0 bg-white p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold m-0 text-secondary">Detail Balita</h5>
                <span class="badge rounded-pill px-3 py-2 fw-normal"
                      style="background-color:#e7ecff; color:#3b5bfd; font-size:0.8rem;">
                    {{ $balita->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                </span>
            </div>

            <table class="table table-borderless mb-0">
                <tbody>
                    <tr>
                        <td class="text-muted fw-semibold" style="width:220px;">Nama Balita</td>
                        <td>: {{ $balita->nama_balita }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Umur</td>
                        <td>: {{ $balita->umur }} bulan</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Jenis Kelamin</td>
                        <td>: {{ $balita->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Tinggi Badan</td>
                        <td>: {{ $balita->tinggi_badan }} cm</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Berat Badan</td>
                        <td>: {{ $balita->berat_badan }} kg</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Alamat</td>
                        <td>: {{ $balita->alamat }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Kondisi Ekonomi</td>
                        <td>: {{ $balita->kondisi_ekonomi }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Sanitasi Lingkungan</td>
                        <td>: {{ $balita->sanitasi_lingkungan }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Riwayat ASI</td>
                        <td>: {{ $balita->riwayat_asi }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Status Imunisasi Dasar</td>
                        <td>
                            :
                            <span class="badge rounded-pill px-3 py-2 fw-normal"
                                  style="background-color: {{ $balita->status_imunisasi_dasar === 'Lengkap' ? '#e3f9e5' : '#fde8e8' }}; color: {{ $balita->status_imunisasi_dasar === 'Lengkap' ? '#1f9d55' : '#e5484d' }}; font-size:0.8rem;">
                                {{ $balita->status_imunisasi_dasar }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.balita.index') }}" class="btn btn-outline-secondary px-4 rounded-pill">Kembali</a>
                <a href="{{ route('admin.balita.edit', $balita->id_balita) }}" class="btn text-white px-4 rounded-pill" style="background-color:#f5a623;">Edit Data</a>
            </div>
        </div>
    </div>
</div>
@endsection