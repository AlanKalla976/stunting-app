@extends('layouts.app')

@section('page_title', 'Tambah Data Balita (Petugas)')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-custom border-0 bg-white p-4">
            <h5 class="fw-bold mb-4 text-secondary">Tambah Balita Baru</h5>

            @if ($errors->any())
                <div class="alert alert-danger border-0 small">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('petugas.balita.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="nama_balita" class="form-label fw-semibold small text-secondary">Nama Balita</label>
                    <input type="text" class="form-control" id="nama_balita" name="nama_balita" value="{{ old('nama_balita') }}" required>
                </div>

                <div class="mb-3">
                    <label for="umur" class="form-label fw-semibold small text-secondary">Umur (Bulan)</label>
                    <input type="number" class="form-control" id="umur" name="umur" value="{{ old('umur') }}" required>
                </div>

                <div class="mb-3">
                    <label for="jenis_kelamin" class="form-label fw-semibold small text-secondary">Jenis Kelamin</label>
                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                        <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="alamat" class="form-label fw-semibold small text-secondary">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('petugas.balita.index') }}" class="btn btn-outline-secondary px-4 rounded-pill">Batal</a>
                    <button type="submit" class="btn btn-primary btn-primary-custom px-4 rounded-pill">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
