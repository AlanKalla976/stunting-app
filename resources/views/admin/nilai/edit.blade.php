@extends('layouts.app')

@section('page_title', 'Edit Nilai Balita')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-custom border-0 bg-white p-4">
            <h5 class="fw-bold mb-4 text-secondary">Edit Nilai Balita</h5>

            @if ($errors->any())
                <div class="alert alert-danger border-0 small"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif

            <form method="POST" action="{{ route('admin.nilai.update', $balita->id_balita) }}">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="form-label fw-semibold small text-secondary">Nama Balita</label>
                    <input type="text" class="form-control bg-light" value="{{ $balita->nama_balita }} ({{ $balita->umur }} bulan)" readonly>
                </div>

                <hr class="my-4">
                <h6 class="fw-bold mb-3 text-secondary">Perbarui Nilai Kriteria</h6>

                @foreach($kriteria as $k)
                    @php
                        $currentNilai = $nilai->get($k->id_kriteria);
                        $selectedValue = $currentNilai ? ($currentNilai->id_sub ?: $currentNilai->nilai) : '';
                    @endphp
                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-secondary">
                            {{ $k->nama_kriteria }}
                            <span class="badge bg-light text-dark border ms-1">{{ ucfirst($k->jenis) }} | Bobot: {{ $k->bobot }}</span>
                        </label>
                        @if($k->subKriteria->isNotEmpty())
                            <select class="form-select" name="nilai[{{ $k->id_kriteria }}]" required>
                                <option value="" disabled>Pilih sub-kriteria...</option>
                                @foreach($k->subKriteria as $sub)
                                    <option value="{{ $sub->id_sub }}" {{ $selectedValue == $sub->id_sub ? 'selected' : '' }}>
                                        {{ $sub->nama_sub }} (Skor: {{ $sub->nilai_bobot }})
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <input type="number" step="0.01" class="form-control" name="nilai[{{ $k->id_kriteria }}]" value="{{ old('nilai.'.$k->id_kriteria, $selectedValue) }}" required>
                        @endif
                    </div>
                @endforeach

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.nilai.index') }}" class="btn btn-outline-secondary px-4 rounded-pill">Batal</a>
                    <button type="submit" class="btn btn-primary btn-primary-custom px-4 rounded-pill">Perbarui Nilai</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
