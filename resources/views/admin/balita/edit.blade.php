@extends('layouts.app')

@section('page_title', 'Edit Data Balita (Admin)')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-custom border-0 bg-white p-4">
            <h5 class="fw-bold mb-4 text-secondary">Edit Data Balita</h5>

            @if ($errors->any())
                <div class="alert alert-danger border-0 small">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.balita.update', $balita->id_balita) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nama_balita" class="form-label fw-semibold small text-secondary">Nama Balita</label>
                    <input type="text" class="form-control" id="nama_balita" name="nama_balita" value="{{ old('nama_balita', $balita->nama_balita) }}" required>
                </div>

                <div class="mb-3">
                    <label for="umur" class="form-label fw-semibold small text-secondary">Umur (Bulan)</label>
                    <input type="number" class="form-control" id="umur" name="umur" value="{{ old('umur', $balita->umur) }}" required>
                </div>

                <div class="mb-3">
                    <label for="jenis_kelamin" class="form-label fw-semibold small text-secondary">Jenis Kelamin</label>
                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="L" {{ old('jenis_kelamin', $balita->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $balita->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tinggi_badan" class="form-label fw-semibold small text-secondary">Tinggi Badan (cm)</label>
                        <input type="number" step="0.01" class="form-control" id="tinggi_badan" name="tinggi_badan" value="{{ old('tinggi_badan', $balita->tinggi_badan) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="berat_badan" class="form-label fw-semibold small text-secondary">Berat Badan (kg)</label>
                        <input type="number" step="0.01" class="form-control" id="berat_badan" name="berat_badan" value="{{ old('berat_badan', $balita->berat_badan) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label fw-semibold small text-secondary">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ old('alamat', $balita->alamat) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="kondisi_ekonomi" class="form-label fw-semibold small text-secondary">Kondisi Ekonomi</label>
                    <select class="form-select" id="kondisi_ekonomi" name="kondisi_ekonomi" required>
                        <option value="Rendah" {{ old('kondisi_ekonomi', $balita->kondisi_ekonomi) === 'Rendah' ? 'selected' : '' }}>Rendah</option>
                        <option value="Menengah" {{ old('kondisi_ekonomi', $balita->kondisi_ekonomi) === 'Menengah' ? 'selected' : '' }}>Menengah</option>
                        <option value="Tinggi" {{ old('kondisi_ekonomi', $balita->kondisi_ekonomi) === 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="sanitasi_lingkungan" class="form-label fw-semibold small text-secondary">Sanitasi Lingkungan</label>
                    <select class="form-select" id="sanitasi_lingkungan" name="sanitasi_lingkungan" required>
                        <option value="Baik" {{ old('sanitasi_lingkungan', $balita->sanitasi_lingkungan) === 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Cukup" {{ old('sanitasi_lingkungan', $balita->sanitasi_lingkungan) === 'Cukup' ? 'selected' : '' }}>Cukup</option>
                        <option value="Kurang" {{ old('sanitasi_lingkungan', $balita->sanitasi_lingkungan) === 'Kurang' ? 'selected' : '' }}>Kurang</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="riwayat_asi" class="form-label fw-semibold small text-secondary">Riwayat ASI</label>
                    <select class="form-select" id="riwayat_asi" name="riwayat_asi" required>
                        <option value="ASI Eksklusif" {{ old('riwayat_asi', $balita->riwayat_asi) === 'ASI Eksklusif' ? 'selected' : '' }}>ASI Eksklusif</option>
                        <option value="Tidak ASI Eksklusif" {{ old('riwayat_asi', $balita->riwayat_asi) === 'Tidak ASI Eksklusif' ? 'selected' : '' }}>Tidak ASI Eksklusif</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="status_imunisasi_dasar" class="form-label fw-semibold small text-secondary">Status Imunisasi Dasar</label>
                    <select class="form-select" id="status_imunisasi_dasar" name="status_imunisasi_dasar" required>
                        <option value="Lengkap" {{ old('status_imunisasi_dasar', $balita->status_imunisasi_dasar) === 'Lengkap' ? 'selected' : '' }}>Lengkap</option>
                        <option value="Tidak Lengkap" {{ old('status_imunisasi_dasar', $balita->status_imunisasi_dasar) === 'Tidak Lengkap' ? 'selected' : '' }}>Tidak Lengkap</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.balita.index') }}" class="btn btn-outline-secondary px-4 rounded-pill">Batal</a>
                    <button type="submit" class="btn btn-primary btn-primary-custom px-4 rounded-pill">Perbarui Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection