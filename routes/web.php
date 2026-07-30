<?php

use App\Http\Controllers\Admin\BalitaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HasilController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\NilaiController;
use App\Http\Controllers\Admin\PerhitunganController;
use App\Http\Controllers\Admin\SubKriteriaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\PetugasAuthController;
use App\Http\Controllers\Petugas\BalitaController as PetugasBalitaController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Petugas\HasilController as PetugasHasilController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

/*
|--------------------------------------------------------------------------
| Auth Routes - Admin
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // ----- Guest (belum login sebagai admin) -----
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    });

    // ----- Authenticated sebagai admin -----
    Route::middleware('auth:admin')->group(function () {

        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/balita/cetak/pdf', [BalitaController::class, 'cetak'])->name('balita.cetak');

        Route::resource('balita', BalitaController::class)
            ->parameters(['balita' => 'balitum']);

        Route::resource('kriteria', KriteriaController::class)
            ->parameters(['kriteria' => 'kriterium']);

        Route::resource('sub-kriteria', SubKriteriaController::class)
            ->parameters(['sub-kriteria' => 'subKriterium']);

        Route::prefix('nilai')->name('nilai.')->group(function () {
            Route::get('/', [NilaiController::class, 'index'])->name('index');
            Route::get('/create/{id_balita}', [NilaiController::class, 'create'])->name('create');
            Route::post('/', [NilaiController::class, 'store'])->name('store');
            Route::get('/{id_balita}/edit', [NilaiController::class, 'edit'])->name('edit');
            Route::put('/{id_balita}', [NilaiController::class, 'update'])->name('update');
            Route::delete('/{id_balita}', [NilaiController::class, 'destroy'])->name('destroy');
        });

        Route::post('/perhitungan/hitung', [PerhitunganController::class, 'hitung'])->name('perhitungan.hitung');

        Route::get('/hasil/cetak', [HasilController::class, 'cetak'])->name('hasil.cetak');
        Route::get('/hasil', [HasilController::class, 'index'])->name('hasil.index');

        Route::resource('user', UserController::class);
    });
});

/*
|--------------------------------------------------------------------------
| Auth Routes - Petugas
|--------------------------------------------------------------------------
*/
Route::prefix('petugas')->name('petugas.')->group(function () {

    // ----- Guest (belum login sebagai petugas) -----
    Route::middleware('guest:petugas')->group(function () {
        Route::get('/login', [PetugasAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [PetugasAuthController::class, 'login'])->name('login.post');

        Route::get('/register', [PetugasAuthController::class, 'showRegister'])->name('register');
        Route::post('/register', [PetugasAuthController::class, 'register'])->name('register.post');
    });

    // ----- Authenticated sebagai petugas -----
    Route::middleware('auth:petugas')->group(function () {

        Route::post('/logout', [PetugasAuthController::class, 'logout'])->name('logout');

        Route::get('/dashboard', [PetugasDashboardController::class, 'index'])->name('dashboard');

        Route::prefix('balita')->name('balita.')->group(function () {
            Route::get('/', [PetugasBalitaController::class, 'index'])->name('index');
            Route::get('/create', [PetugasBalitaController::class, 'create'])->name('create');
            Route::post('/', [PetugasBalitaController::class, 'store'])->name('store');
            Route::get('/{balitum}', [PetugasBalitaController::class, 'show'])->name('show');
            Route::get('/{balitum}/edit', [PetugasBalitaController::class, 'edit'])->name('edit');
            Route::put('/{balitum}', [PetugasBalitaController::class, 'update'])->name('update');
        });

        Route::get('/hasil/cetak', [PetugasHasilController::class, 'cetak'])->name('hasil.cetak');
        Route::get('/hasil', [PetugasHasilController::class, 'index'])->name('hasil.index');
    });
});