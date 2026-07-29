@extends('layouts.app')

@section('page_title', 'Tambah User')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-custom border-0 bg-white p-4">
            <h5 class="fw-bold mb-4 text-secondary">Tambah User Baru</h5>

            @if ($errors->any())
                <div class="alert alert-danger border-0 small"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
            @endif

            <form method="POST" action="{{ route('admin.user.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-secondary">Nama</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-secondary">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-secondary">Role</label>
                    <select class="form-select" name="role" required>
                        <option value="" disabled selected>Pilih Role</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="petugas" {{ old('role') === 'petugas' ? 'selected' : '' }}>Petugas</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-secondary">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold small text-secondary">Konfirmasi Password</label>
                    <input type="password" class="form-control" name="password_confirmation" required>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary px-4 rounded-pill">Batal</a>
                    <button type="submit" class="btn btn-primary btn-primary-custom px-4 rounded-pill">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
