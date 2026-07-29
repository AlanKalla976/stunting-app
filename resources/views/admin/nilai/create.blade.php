@extends('layouts.app')

@section('page_title', 'Input Nilai Balita')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h5 class="fw-bold mb-4" style="color:#1e2129;">Input Nilai Balita Baru</h5>

            @if ($errors->any())
                <div class="alert border-0 small" style="background-color:#fde8e8; color:#e5484d;">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.nilai.store') }}">
                @csrf

                <input type="hidden" name="id_balita" value="{{ $balita->id_balita }}">

                <div class="mb-4">
                    <label class="form-label fw-semibold small" style="color:#1e2129;">Nama Balita</label>
                    <input type="text" class="form-control bg-light" value="{{ $balita->nama_balita }} ({{ $balita->umur }} bulan, {{ $balita->alamat }})" readonly>
                </div>

                <hr class="my-4">
                <h6 class="fw-bold mb-3" style="color:#1e2129;">Nilai Per Kriteria</h6>

                @foreach($kriteria as $k)
                    <div class="mb-3">
                        <label class="form-label fw-semibold small" style="color:#1e2129;">
                            {{ $k->nama_kriteria }}
                            <span class="badge rounded-pill px-2 py-1 fw-normal ms-1" style="background-color:#e7ecff; color:#3b5bfd; font-size:0.75rem;">
                                {{ ucfirst($k->jenis) }} | Bobot: {{ $k->bobot }}
                            </span>
                        </label>

                        @if($k->subKriteria->isNotEmpty())
                            <select class="form-select" name="nilai[{{ $k->id_kriteria }}]" required>
                                <option value="" disabled {{ old('nilai.'.$k->id_kriteria) ? '' : 'selected' }}>
                                    Pilih {{ $k->nama_kriteria }}...
                                </option>
                                @foreach($k->subKriteria as $sub)
                                    <option value="{{ $sub->id_sub }}" {{ old('nilai.'.$k->id_kriteria) == $sub->id_sub ? 'selected' : '' }}>
                                        {{ $sub->nama_sub }} (Skor: {{ $sub->nilai_bobot }})
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <div class="alert border-0 small mb-0" style="background-color:#fff4e0; color:#c98a1c;">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                Belum ada sub kriteria untuk <strong>{{ $k->nama_kriteria }}</strong>.
                                Silakan tambahkan sub kriteria terlebih dahulu di menu
                                <a href="{{ route('admin.sub-kriteria.create') }}" class="fw-semibold" style="color:#c98a1c; text-decoration:underline;">Sub Kriteria</a>.
                            </div>
                        @endif
                    </div>
                @endforeach

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.nilai.index') }}" class="btn rounded-3 px-4" style="border:1px solid #dee2e6; color:#6c757d;">
                        Batal
                    </a>
                    <button type="submit" class="btn text-white rounded-3 px-4 fw-semibold" style="background-color:#3b5bfd;">
                        Simpan Nilai
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection