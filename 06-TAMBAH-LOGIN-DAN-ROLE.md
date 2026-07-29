# 06 — Tambah Login dan Pembagian Role (Admin & Petugas)

Sampai sini fitur inti (CRUD + rumus SAW) sudah terbukti jalan tanpa login.
Sekarang kita "pasang pintunya": login terpisah untuk Admin dan Petugas,
dengan URL yang rapi dan konsisten.

## Peta URL Setelah Login Dipasang

| URL | Role | Fungsi |
|---|---|---|
| `/admin/login` | Admin | Login khusus admin |
| `/admin/dashboard` | Admin | Dashboard admin |
| `/admin/balita` | Admin | Lihat, tambah, edit, hapus data balita |
| `/admin/kriteria` | Admin | CRUD kriteria |
| `/admin/sub-kriteria` | Admin | CRUD sub kriteria |
| `/admin/nilai` | Admin | Input nilai balita |
| `/admin/hitung-saw` | Admin | Jalankan perhitungan SAW |
| `/admin/hasil` | Admin | Lihat & cetak hasil ranking |
| `/admin/user` | Admin | CRUD akun user |
| `/petugas/login` | Petugas | Login khusus petugas |
| `/petugas/dashboard` | Petugas | Dashboard petugas |
| `/petugas/balita` | Petugas | Lihat & tambah data balita (tanpa edit/hapus) |
| `/petugas/hasil` | Petugas | Lihat hasil ranking |
| `/register` | Publik → jadi akun Petugas | Pendaftaran akun baru |

Awalan URL langsung menunjukkan siapa yang boleh masuk — rapi dan gampang dijelaskan ke penguji sidang.

## Langkah 1 — Install Scaffolding Auth

```bash
php artisan ui bootstrap --auth
npm install && npm run dev
```

Ini generate `RegisterController`, `LoginController` bawaan, dan view
`/login`, `/register` default — yang akan kita modifikasi di langkah berikut.

## Langkah 2 — Dua Controller Login Terpisah

```bash
php artisan make:controller Auth/AdminLoginController
php artisan make:controller Auth/PetugasLoginController
```

```php
// app/Http/Controllers/Auth/AdminLoginController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin/dashboard';

    public function showLoginForm() { return view('auth.admin-login'); }

    protected function username() { return 'email'; }

    // Kunci pemisahannya: role ikut jadi syarat kredensial login
    protected function credentials(Request $request)
    {
        return array_merge(
            $request->only($this->username(), 'password'),
            ['role' => 'admin']
        );
    }
}
```

`PetugasLoginController` sama persis, tinggal ganti `'admin'` → `'petugas'`
dan `$redirectTo = '/petugas/dashboard'`, view `auth.petugas-login`.

> Kenapa begini? `Auth::attempt()` di dalam trait `AuthenticatesUsers` akan
> mencocokkan email + password **dan** `role` sekaligus. Kalau admin coba
> login lewat `/petugas/login`, walau email/password benar, tetap ditolak
> karena role-nya tidak cocok — otomatis, tanpa kode tambahan.

## Langkah 3 — Middleware Role

```bash
php artisan make:middleware CheckRole
```

```php
// app/Http/Middleware/CheckRole.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (auth()->check() && auth()->user()->role === $role) {
            return $next($request);
        }
        abort(403, 'Akses ditolak untuk halaman ini.');
    }
}
```

Daftarkan di `app/Http/Kernel.php`:

```php
protected $middlewareAliases = [
    // ...bawaan Laravel...
    'role' => \App\Http\Middleware\CheckRole::class,
];
```

## Langkah 4 — Susun Ulang Routes dengan Prefix

```php
// routes/web.php
use App\Http\Controllers\{
    BalitaController, KriteriaController, SubKriteriaController,
    NilaiController, PerhitunganController, HasilController,
    DashboardController, UserController
};
use App\Http\Controllers\Auth\{
    AdminLoginController, PetugasLoginController,
    RegisterController, ForgotPasswordController, ResetPasswordController
};

// --- Login terpisah ---
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login']);
Route::get('/petugas/login', [PetugasLoginController::class, 'showLoginForm'])->name('petugas.login');
Route::post('/petugas/login', [PetugasLoginController::class, 'login']);
Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

// --- Register: hasil akun selalu Petugas ---
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// --- Lupa password (dipakai bersama) ---
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// ==================== ADMIN — akses penuh ====================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('balita', BalitaController::class);
    Route::resource('kriteria', KriteriaController::class);
    Route::resource('sub-kriteria', SubKriteriaController::class);
    Route::resource('nilai', NilaiController::class);
    Route::resource('user', UserController::class);
    Route::post('/hitung-saw', [PerhitunganController::class, 'hitung'])->name('hitung.saw');
    Route::get('/hasil', [HasilController::class, 'index'])->name('hasil.index');
    Route::get('/hasil/cetak', [HasilController::class, 'cetak'])->name('hasil.cetak');
});

// ==================== PETUGAS — terbatas ====================
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/balita', [BalitaController::class, 'index'])->name('balita.index');
    Route::get('/balita/create', [BalitaController::class, 'create'])->name('balita.create');
    Route::post('/balita', [BalitaController::class, 'store'])->name('balita.store');
    Route::get('/hasil', [HasilController::class, 'index'])->name('hasil.index');
});
```

> `BalitaController` dan `HasilController` yang **sudah Anda buat di file 04
> dan 05 tetap dipakai sama persis** — tidak perlu bikin ulang. Yang berubah
> cuma routing-nya (sekarang pakai prefix + middleware) dan sedikit
> penyesuaian redirect di controller (langkah 6).

## Langkah 5 — Redirect "Harus Login Dulu" Sesuai Prefix

```php
// app/Http/Middleware/Authenticate.php
protected function redirectTo($request)
{
    if (! $request->expectsJson()) {
        return $request->is('admin/*') ? route('admin.login') : route('petugas.login');
    }
}
```

## Langkah 6 — Sesuaikan Redirect di Controller & Register

Karena nama route sekarang `admin.balita.index` / `petugas.balita.index`,
buat redirect otomatis ikut role yang login:

```php
// di BalitaController@store, update, destroy
return redirect()
    ->route(auth()->user()->role . '.balita.index')
    ->with('success', 'Data balita berhasil disimpan');
```

Pastikan akun hasil `/register` publik **selalu jadi Petugas**, bukan bisa
pilih sendiri:

```php
// app/Http/Controllers/Auth/RegisterController.php
protected function create(array $data)
{
    return \App\Models\User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => \Illuminate\Support\Facades\Hash::make($data['password']),
        'role' => 'petugas', // hardcode
    ]);
}
```

Akun Admin dibuat lewat seeder (`php artisan make:seeder AdminSeeder`) atau
menu Kelola User oleh admin lain — bukan lewat register publik.

## Langkah 7 — Sidebar Menyesuaikan Role

```blade
@php $role = auth()->user()->role; @endphp
<nav class="sidebar">
    <a href="{{ route($role . '.dashboard') }}">Dashboard</a>
    <a href="{{ route($role . '.balita.index') }}">Data Balita</a>
    <a href="{{ route($role . '.hasil.index') }}">Hasil Ranking</a>

    @if($role === 'admin')
        <a href="{{ route('admin.kriteria.index') }}">Kriteria</a>
        <a href="{{ route('admin.sub-kriteria.index') }}">Sub Kriteria</a>
        <a href="{{ route('admin.nilai.index') }}">Input Nilai</a>
        <a href="{{ route('admin.user.index') }}">Kelola User</a>
    @endif
</nav>
```

Di halaman list balita, sembunyikan tombol Edit/Hapus untuk petugas:

```blade
@if(auth()->user()->role === 'admin')
    <a href="{{ route('admin.balita.edit', $item->id_balita) }}">Edit</a>
    <form action="{{ route('admin.balita.destroy', $item->id_balita) }}" method="POST">
        @csrf @method('DELETE')
        <button type="submit">Hapus</button>
    </form>
@endif
```

## Matriks Hak Akses (ringkasan)

| Fitur | Admin | Petugas |
|---|:---:|:---:|
| Login | `/admin/login` | `/petugas/login` |
| Tambah & lihat data balita | ✅ | ✅ |
| Edit/hapus data balita | ✅ | ❌ |
| CRUD kriteria & sub kriteria | ✅ | ❌ |
| Input nilai | ✅ | ❌ |
| Jalankan hitung SAW | ✅ | ❌ |
| Lihat & cetak hasil | ✅ | ✅ |
| Kelola user | ✅ | ❌ |

## Checklist Sebelum Lanjut ke File 07

- [ ] Login admin di `/admin/login` berhasil, redirect ke `/admin/dashboard`
- [ ] Login petugas di `/petugas/login` berhasil, redirect ke `/petugas/dashboard`
- [ ] Admin coba login di `/petugas/login` → ditolak, begitu juga sebaliknya
- [ ] Petugas akses `/admin/kriteria` langsung lewat URL → ditolak (403)
- [ ] Petugas bisa tambah balita lewat `/petugas/balita`, tapi tidak ada tombol edit/hapus
- [ ] Register baru selalu menghasilkan akun role `petugas`
