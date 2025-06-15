<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\simpanTransaksiController;

// Route halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Route dashboard (hanya user terverifikasi)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes profile pengguna (auth middleware)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

// Routes admin (middleware auth dan role admin)
Route::middleware(['auth', 'role:admin|superadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    Route::resource('kategori', KategoriController::class);
    Route::resource('barang', BarangController::class);
    Route::resource('distributor', DistributorController::class);

    // Tambahkan route khusus untuk barang
    Route::get('barang/stock-alert', [BarangController::class, 'stockAlert'])->name('barang.stock-alert');
    Route::get('barang/export/{format}', [BarangController::class, 'export'])->name('barang.export');

});
// Routes untuk manajemen pengguna (hanya superadmin)
Route::middleware(['auth', 'role:superadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);

    Route::put('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.role');
});
// Routes kasir (middleware auth dan role kasir)
Route::middleware(['auth', 'role:kasir|admin|superadmin'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/', [KasirController::class, 'index'])->name('dashboard');
    Route::post('/simpan-transaksi', [KasirController::class, 'simpanTransaksi'])->name('simpanTransaksi');
    Route::get('/api/produk', [BarangController::class, 'getProdukApi'])->name('api.produk');
});



Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/barang/data', [BarangController::class, 'getData'])->name('barang.data');



require __DIR__.'/auth.php';
