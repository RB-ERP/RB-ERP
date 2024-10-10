<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PerubahanBarangController;
use App\Http\Controllers\UpgradeBarangController;
use App\Http\Controllers\PerbaikanBarangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Models\RiwayatPeminjaman;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

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
    Route::get('/databarang', [BarangController::class, 'index'])->name('barang.index');
    Route::post('/superadmin/databarang/store', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/superadmin/databarang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::get('/databarang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
    Route::get('/databarang/list', [BarangController::class, 'list'])->name('databarang.list');
    Route::delete('/superadmin/databarang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
    Route::put('/superadmin/databarang/{id}', [BarangController::class, 'update'])->name('barang.update');
    // Route untuk generate PDF
    Route::get('/superadmin/databarang/pdf', [BarangController::class, 'generatePDF'])->name('barang.pdf');
    // Route untuk generate QR Code dalam bentuk PDF
    Route::get('/databarang/{id}/qrcode/pdf', [BarangController::class, 'generateQrCodePdf'])->name('barang.qrcode.pdf');


    // Route untuk Perubahan Data Barang
    Route::get('/superadmin/perubahandatabrg', [PerubahanBarangController::class, 'index'])->name('superadmin.perubahandatabrg');
    Route::get('/barang/edit/{id}/{source}', [PerubahanBarangController::class, 'edit'])->name('perubahan.edit');
    Route::put('/barang/update/{id}', [PerubahanBarangController::class, 'update'])->name('perubahan.update');
    Route::delete('/barang/destroy/{id}', [PerubahanBarangController::class, 'destroy'])->name('barang.destroy');
    Route::get('/superadmin/perubahanbarang/pdf', [PerubahanBarangController::class, 'generatePDF'])->name('perubahanbarang.pdf');

    // Route Upgrade Barang
    Route::get('/superadmin/upgradebarang', [UpgradeBarangController::class, 'index'])->name('upgradebarang.index');
    Route::get('/superadmin/upgradebarang/items', [BarangController::class, 'getUpgradedItems'])->name('upgradebarang.items');
    Route::get('/superadmin/upgradebarang/{id}/edit', [UpgradeBarangController::class, 'edit'])->name('upgradebarang.edit');
    Route::put('/superadmin/upgradebarang/{id}', [UpgradeBarangController::class, 'update'])->name('upgradebarang.update');
    Route::delete('/superadmin/upgradebarang/{id}', [UpgradeBarangController::class, 'destroy'])->name('upgradebarang.destroy');
    Route::get('/superadmin/upgradebarang/create', [UpgradeBarangController::class, 'create'])->name('upgradebarang.create');
    Route::get('/superadmin/upgradebarang/pdf', [UpgradeBarangController::class, 'generatePDF'])->name('upgradebarang.pdf');

    // Route untuk halaman perbaikan barang
    Route::get('/superadmin/perbaikan', [PerbaikanBarangController::class, 'index'])->name('superadmin.perbaikan');
    // Route untuk halaman edit perbaikan barang
    Route::get('/superadmin/perbaikan/{id}/edit', [PerbaikanBarangController::class, 'edit'])->name('perbaikan.edit');
    // Route untuk update data perbaikan barang
    Route::put('/superadmin/perbaikan/{id}', [PerbaikanBarangController::class, 'update'])->name('perbaikan.update');

    // Route untuk halaman peminjaman barang
    Route::get('/superadmin/peminjaman', [PeminjamanController::class, 'index'])->name('superadmin.peminjaman');
    Route::put('/superadmin/peminjaman/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
    Route::get('/superadmin/peminjaman/form', [PeminjamanController::class, 'form'])->name('peminjaman.form');
    Route::post('/superadmin/peminjaman/form', [PeminjamanController::class, 'store'])->name('peminjaman.store');

    // Route untuk halaman pengembalian barang
    Route::get('/superadmin/pengembalian', [PengembalianController::class, 'index'])->name('superadmin.pengembalian');
    Route::put('/superadmin/pengembalian/{id}', [PengembalianController::class, 'update'])->name('pengembalian.update');

    // route riwayat peminjaman
    Route::get('/superadmin/riwayat-peminjaman', [RiwayatPeminjaman::class, 'index'])->name('superadmin.riwayat-peminjaman');

    // Route laporan umum
    Route::get('/superadmin/laporan', [LaporanController::class, 'index'])->name('superadmin.laporan');
    Route::get('/superadmin/laporan/pdf', [LaporanController::class, 'generatePDF'])->name('superadmin.laporan.pdf');

    // Route untuk mengelola User
    Route::get('/superadmin/user', [UserController::class, 'index'])->name('superadmin.user');
    Route::get('/superadmin/user/create', [UserController::class, 'create'])->name('user.create'); // Ini untuk membuka halaman formtambahuser.blade.php
    Route::post('/superadmin/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/superadmin/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/superadmin/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/superadmin/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    // Route untuk menampilkan profil user
    Route::get('/superadmin/profile', [ProfileController::class, 'showProfile'])->name('superadmin.profile');
    // Route untuk halaman edit profil
    Route::get('/superadmin/profile/edit', [ProfileController::class, 'editProfile'])->name('superadmin.profile.edit');
    // Route untuk memperbarui profil
    Route::post('/superadmin/profile/update', [ProfileController::class, 'updateProfile'])->name('superadmin.profile.update');

    // Route untuk user biasa
    Route::get('/user/dashboard', [AuthController::class, 'userDashboard'])->name('user.dashboard');
    // Route untuk databarang user
    Route::get('/user/databarang', [BarangController::class, 'userIndex'])->name('user.databarang');
    // Route untuk perubahandatabarang user
    Route::get('/user/perubahandatabrg', [PerubahanBarangController::class, 'userIndex'])->name('user.perubahandatabrg');
    // Route untuk halaman perbaikan barang (user)
    Route::get('/user/perbaikan', [PerbaikanBarangController::class, 'userIndex'])->name('user.perbaikan');
    // Route untuk halaman upgrade barang (user)
    Route::get('/user/upgrade', [UpgradeBarangController::class, 'userIndex'])->name('user.upgradebarang');


    //route untuk admin
    Route::get('/admin/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');
});