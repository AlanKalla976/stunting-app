<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        // Pastikan user sudah login
        if (!auth()->check()) {
            abort(403, 'Akses ditolak. Silakan login terlebih dahulu.');
        }

        $userRole = auth()->user()->role;

        // Admin bisa akses semua area (admin & petugas)
        if ($userRole === 'admin') {
            return $next($request);
        }

        // Petugas hanya bisa akses area petugas
        if ($userRole === $role) {
            return $next($request);
        }

        abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk halaman ini.');
    }
}
