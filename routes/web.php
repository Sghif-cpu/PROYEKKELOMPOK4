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
    
    // Pendaftaran
    Route::prefix('pendaftaran')->name('pendaftaran.')->group(function () {
        Route::get('/', function () {
            return view('pendaftaran.index');
        })->name('index');
        
        Route::get('/pasien-baru', [PasienController::class, 'create'])->name('pasien-baru');
        Route::get('/pasien-lama', [PasienController::class, 'index'])->name('pasien-lama');
    });
    
    // Laboratorium
    Route::prefix('laboratorium')->name('laboratorium.')->group(function () {
        Route::get('/', [LaboratoriumController::class, 'index'])->name('index');
        Route::get('/data', [LaboratoriumController::class, 'getData'])->name('data');
    });
    
    // Kasir
    Route::prefix('kasir')->name('kasir.')->group(function () {
        Route::get('/', [KasirController::class, 'index'])->name('index');
    });
    
    // Pasien - ROUTE YANG DIPERBAIKI
    Route::prefix('pasien')->name('pasien.')->group(function () {
        // Route untuk daftar pasien
        Route::get('/', [PasienController::class, 'index'])->name('index');
        
        // Route untuk Pasien Baru
        Route::get('/create', [PasienController::class, 'create'])->name('create');
        Route::post('/', [PasienController::class, 'store'])->name('store');
        
        // Route untuk detail, edit, update, delete pasien - INI YANG DITAMBAHKAN
        Route::get('/{id}', [PasienController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [PasienController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PasienController::class, 'update'])->name('update');
        Route::delete('/{id}', [PasienController::class, 'destroy'])->name('destroy');
        
        // Route khusus untuk redirect setelah simpan
        Route::get('/lama/{id}', [PasienController::class, 'show'])->name('lama');
    });
});