@extends('layouts.app')

@section('page_title', 'Edit Sub Kriteria')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-custom border-0 bg-white p-4">
            <h5 class="fw-bold mb-4 text-secondary">Edit Sub Kriteria</h5>

            @if ($errors->any())
                <div class="alert alert-danger border-0 small"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif

            <form method="POST" action="{{ route('admin.sub-kriteria.update', $subKriteria->id_sub) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-secondary">Kriteria Induk</label>
                    <select class="form-select" name="id_kriteria" required>
                        @foreach($kriteria as $item)
                            <option value="{{ $item->id_kriteria }}" {{ old('id_kriteria', $subKriteria->id_kriteria) == $item->id_kriteria ? 'selected' : '' }}>{{ $item->nama_kriteria }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-secondary">Nama Sub Kriteria</label>
                    <input type="text" class="form-control" name="nama_sub" value="{{ old('nama_sub', $subKriteria->nama_sub) }}" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold small text-secondary">Skor / Nilai Bobot</label>
                    <input type="number" step="0.01" class="form-control" name="nilai_bobot" value="{{ old('nilai_bobot', $subKriteria->nilai_bobot) }}" required>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.sub-kriteria.index') }}" class="btn btn-outline-secondary px-4 rounded-pill">Batal</a>
                    <button type="submit" class="btn btn-primary btn-primary-custom px-4 rounded-pill">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
