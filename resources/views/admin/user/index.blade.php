@extends('layouts.app')

@section('page_title', 'Kelola Pengguna')

@section('content')
<style>
    table.table-user > thead > tr > th {
        background-color: #3b5bfd !important;
        color: #ffffff !important;
        border: none !important;
        vertical-align: middle;
    }
    table.table-user > thead > tr > th:first-child {
        border-top-left-radius: 12px !important;
        border-bottom-left-radius: 12px !important;
    }
    table.table-user > thead > tr > th:last-child {
        border-top-right-radius: 12px !important;
        border-bottom-right-radius: 12px !important;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0" style="color:#1e2129;">Daftar Pengguna</h2>
    <a href="{{ route('admin.user.create') }}" class="btn text-white rounded-3 px-4 py-2 fw-semibold" style="background-color:#3b5bfd;">
        <i class="bi bi-plus-lg me-1"></i> Tambah User
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4">

    <form method="GET" class="d-flex mb-4" style="max-width: 500px;">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control rounded-start-3 border-end-0" placeholder="Cari nama atau email..." style="height:45px;">
        <button type="submit" class="btn text-white rounded-end-3 px-4 fw-semibold" style="background-color:#2b2f3a; height:45px;">Cari</button>
    </form>

    <div class="table-responsive">
        <table class="table table-user align-middle mb-0" style="border-collapse: separate; border-spacing: 0;">
            <thead>
                <tr>
                    <th class="py-3 ps-4">No</th>
                    <th class="py-3">Nama</th>
                    <th class="py-3">Email</th>
                    <th class="py-3">Role</th>
                    <th class="py-3 pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $item)
                    <tr style="border-bottom: 1px solid #eef0f4;">
                        <td class="ps-4 text-muted">{{ $users->firstItem() + $index }}</td>
                        <td class="fw-semibold" style="color:#1e2129;">{{ $item->name }}</td>
                        <td class="text-muted">{{ $item->email }}</td>
                        <td>
                            <span class="badge rounded-pill px-3 py-2 fw-normal"
                                  style="background-color: {{ $item->role === 'admin' ? '#fde8e8' : '#e7ecff' }}; color: {{ $item->role === 'admin' ? '#e5484d' : '#3b5bfd' }}; font-size:0.8rem;">
                                {{ strtoupper($item->role) }}
                            </span>
                        </td>
                        <td class="pe-4">
                            <a href="{{ route('admin.user.edit', $item->id) }}"
                               class="btn btn-sm text-white rounded-3 px-3 me-1" style="background-color:#f5a623;">
                                Edit
                            </a>
                            <form action="{{ route('admin.user.destroy', $item->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm text-white rounded-3 px-3" style="background-color:#e5484d;"
                                        {{ auth()->id() === $item->id ? 'disabled' : '' }}>
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada data user.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection