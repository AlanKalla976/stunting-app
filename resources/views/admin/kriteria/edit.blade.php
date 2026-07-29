@extends('layouts.app')

@section('page_title', 'Edit Kriteria')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-custom border-0 bg-white p-4">
            <h5 class="fw-bold mb-4 text-secondary">Edit Kriteria</h5>

            @if ($errors->any())
                <div class="alert alert-danger border-0 small"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif

            <form method="POST" action="{{ route('admin.kriteria.update', $kriteria->id_kriteria) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-secondary">Nama Kriteria</label>
                    <input type="text" class="form-control" name="nama_kriteria" value="{{ old('nama_kriteria', $kriteria->nama_kriteria) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-secondary">Jenis</label>
                    <select class="form-select" name="jenis" required>
                        <option value="benefit" {{ old('jenis', $kriteria->jenis) === 'benefit' ? 'selected' : '' }}>Benefit</option>
                        <option value="cost" {{ old('jenis', $kriteria->jenis) === 'cost' ? 'selected' : '' }}>Cost</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold small text-secondary">Bobot (0.00 - 1.00)</label>
                    <input type="number" step="0.01" min="0" max="1" class="form-control" name="bobot" value="{{ old('bobot', $kriteria->bobot) }}" required>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.kriteria.index') }}" class="btn btn-outline-secondary px-4 rounded-pill">Batal</a>
                    <button type="submit" class="btn btn-primary btn-primary-custom px-4 rounded-pill">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
