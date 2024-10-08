<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PerubahanBarangController;
use App\Http\Controllers\UpgradeBarangController;
use App\Http\Controllers\PerbaikanBarangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Models\RiwayatPeminjaman;

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route untuk super admin
Route::middleware('auth')->group(function () {
    Route::get('/superadmin/dashboard', [AuthController::class, 'superAdminDashboard'])->name('superadmin.dashboard');
    // Route Data Barang
    Route::get('/superadmin/databarang', [BarangController::class, 'index'])->name('superadmin.databarang');
    Route::get('/superadmin/databarang', [BarangController::class, 'index'])->name('barang.index');
    Route::post('/superadmin/databarang/store', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/superadmin/databarang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::get('/superadmin/databarang/edit/{id}/{source}', [BarangController::class, 'edit'])->name('barang.edit');
    Route::delete('/superadmin/databarang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
    Route::put('/superadmin/databarang/{id}', [BarangController::class, 'update'])->name('barang.update');

     // Route untuk Perubahan Data Barang
     Route::get('/superadmin/perubahandatabrg', [PerubahanBarangController::class, 'index'])->name('superadmin.perubahandatabrg');
     Route::get('/barang/edit/{id}/{source}', [PerubahanBarangController::class, 'edit'])->name('perubahan.edit');
     Route::put('/barang/update/{id}', [PerubahanBarangController::class, 'update'])->name('perubahan.update');
     Route::delete('/barang/destroy/{id}', [PerubahanBarangController::class, 'destroy'])->name('barang.destroy');
     Route::delete('/superadmin/perubahandatabrg/{id}', [PerubahanBarangController::class, 'destroy'])->name('perubahan.destroy');
     Route::put('/superadmin/perubahandatabrg/{id}', [PerubahanBarangController::class, 'update'])->name('perubahan.update');
     Route::get('/superadmin/perubahandatabrg/create', [PerubahanBarangController::class, 'create'])->name('perubahan.create');


    // Route Upgrade Barang
    Route::get('/superadmin/upgradebarang', [UpgradeBarangController::class, 'index'])->name('upgradebarang.index');
    // Route untuk mengambil barang yang diupgrade
    Route::get('/superadmin/upgradebarang/items', [BarangController::class, 'getUpgradedItems'])->name('upgradebarang.items');
    // Route untuk menampilkan halaman edit
    Route::get('/superadmin/upgradebarang/{id}/edit', [UpgradeBarangController::class, 'edit'])->name('upgradebarang.edit');
    // Route untuk mengupdate data barang yang di-upgrade
    Route::put('/superadmin/upgradebarang/{id}', [UpgradeBarangController::class, 'update'])->name('upgradebarang.update');
    // Route untuk menghapus data barang yang di-upgrade
    Route::delete('/superadmin/upgradebarang/{id}', [UpgradeBarangController::class, 'destroy'])->name('upgradebarang.destroy');
    // Route untuk menampilkan halaman tambah data
    Route::get('/superadmin/upgradebarang/create', [UpgradeBarangController::class, 'create'])->name('upgradebarang.create');

    // Route untuk halaman perbaikan barang
    Route::get('/superadmin/perbaikan', [PerbaikanBarangController::class, 'index'])->name('superadmin.perbaikan');

    // Route untuk halaman peminjaman barang
    Route::get('/superadmin/peminjaman', [PeminjamanController::class, 'index'])->name('superadmin.peminjaman');
    Route::put('/superadmin/peminjaman/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
    Route::get('/superadmin/peminjaman/form', [PeminjamanController::class, 'form'])->name('peminjaman.form');
    Route::post('/superadmin/peminjaman/form', [PeminjamanController::class, 'store'])->name('peminjaman.store');

    // Route untuk halaman pengembalian barang
    Route::get('/superadmin/pengembalian', [PengembalianController::class, 'index'])->name('superadmin.pengembalian');
    Route::put('/superadmin/pengembalian/{id}', [PengembalianController::class, 'update'])->name('pengembalian.update');

    Route::get('/superadmin/riwayat-peminjaman', [RiwayatPeminjaman::class, 'index'])->name('superadmin.riwayat-peminjaman');

    // Route untuk user biasa
    Route::get('/user/dashboard', [AuthController::class, 'userDashboard'])->name('user.dashboard');
});