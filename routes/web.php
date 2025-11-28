<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaboratoriumController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\AuthController;

// Route publik
Route::get('/', function () {
    return redirect()->route('login');
});

// Route Authentication
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route yang memerlukan autentikasi
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | ROUTE PENDAFTARAN PASIEN
    |--------------------------------------------------------------------------
    */
    Route::prefix('pendaftaran')->name('pendaftaran.')->group(function () {

        // Halaman utama pendaftaran
        Route::get('/', function () {
            return view('pendaftaran.index');
        })->name('index');

        // Tambah pasien baru (FORM)
        Route::get('/pasien-baru', [PasienController::class, 'create'])->name('pasien-baru');

        // Pasien lama -> daftar pasien
        Route::get('/pasien-lama', [PasienController::class, 'index'])->name('pasien-lama');
    });


    /*
    |--------------------------------------------------------------------------
    | ROUTE LABORATORIUM
    |--------------------------------------------------------------------------
    */
    Route::prefix('laboratorium')->name('laboratorium.')->group(function () {
        Route::get('/', [LaboratoriumController::class, 'index'])->name('index');
        Route::get('/data', [LaboratoriumController::class, 'getData'])->name('data');
    });


    /*
    |--------------------------------------------------------------------------
    | ROUTE KASIR
    |--------------------------------------------------------------------------
    */
    Route::prefix('kasir')->name('kasir.')->group(function () {
        Route::get('/', [KasirController::class, 'index'])->name('index');
    });


    /*
    |--------------------------------------------------------------------------
    | ROUTE PASIEN (CRUD LENGKAP)
    |--------------------------------------------------------------------------
    */
    Route::prefix('pasien')->name('pasien.')->group(function () {

        // Daftar pasien
        Route::get('/', [PasienController::class, 'index'])->name('index');

        // Create pasien baru
        Route::get('/create', [PasienController::class, 'create'])->name('create');
        Route::post('/', [PasienController::class, 'store'])->name('store');

        // Detail pasien
        Route::get('/{id}', [PasienController::class, 'show'])->name('show');

        // Edit pasien
        Route::get('/{id}/edit', [PasienController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PasienController::class, 'update'])->name('update');

        // Hapus pasien
        Route::delete('/{id}', [PasienController::class, 'destroy'])->name('destroy');

        // Pasien lama masuk dari pendaftaran
        Route::get('/lama/{id}', [PasienController::class, 'show'])->name('lama');
    });
});
