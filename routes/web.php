<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DistributorController;

// Route untuk admin dengan middleware 'auth' dan 'role:admin'
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Route resource untuk kategori
    Route::resource('kategori', KategoriController::class);
    // Route untuk halaman admin
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    // Route untuk halaman barang
    Route::resource('/barang', BarangController::class);
    // Route untuk halaman distributor
    Route::resource('/distributor', DistributorController::class);
});

// Route untuk kasir dengan middleware 'auth' dan 'role:kasir'
Route::middleware(['auth', 'role:kasir'])->get('/kasir', [KasirController::class, 'index'])->name('kasir.dashboard');

// Route untuk halaman dashboard, hanya pengguna yang sudah terverifikasi
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route untuk mengelola profile pengguna
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route untuk halaman utama
Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';
