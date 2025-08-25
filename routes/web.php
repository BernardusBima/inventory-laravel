<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // SEMUA USER (Admin & Karyawan) BISA MELIHAT DAFTAR BARANG
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/{barang}', [BarangController::class, 'show'])->name('barang.show');
    
    // HANYA ADMIN YANG BISA TAMBAH, EDIT, HAPUS
    Route::middleware('admin')->group(function () {
        Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
        Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
        Route::get('/barang/{barang}/edit', [BarangController::class, 'edit'])->name('barang.edit');
        Route::put('/barang/{barang}', [BarangController::class, 'update'])->name('barang.update');
        Route::delete('/barang/{barang}', [BarangController::class, 'destroy'])->name('barang.destroy');
        Route::get('/barang/masuk', [App\Http\Controllers\PergerakanBarangController::class, 'createMasuk'])->name('barang.masuk');
        Route::post('/barang/masuk', [App\Http\Controllers\PergerakanBarangController::class, 'storeMasuk'])->name('barang.storeMasuk');
        Route::get('/barang/keluar', [App\Http\Controllers\PergerakanBarangController::class, 'createKeluar'])->name('barang.keluar');
        Route::post('/barang/keluar', [App\Http\Controllers\PergerakanBarangController::class, 'storeKeluar'])->name('barang.storeKeluar');
        Route::resource('kategori', KategoriController::class)->except(['show']);
        Route::resource('supplier', SupplierController::class)->except(['show']);
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/export', [LaporanController::class, 'exportPDF'])->name('laporan.export');
    });
});

require __DIR__.'/auth.php';