<?php

use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\GuestMiddleware;
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
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PengajuanPenghapusanController;

// Route untuk guest (hanya bisa diakses jika belum login)
Route::middleware(GuestMiddleware::class)->group(function () {
    Route::get('/', function () {
        return redirect('/welcome');
    });

    Route::get('/welcome', function () {
        return view('welcome');
    });

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Route logout (hanya bisa diaksedas jika sudah login)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/logout', function () {
    return redirect('/login')->with('error', 'Logout hanya bisa dilakukan melalui POST.');
})->middleware('auth');


// Route untuk pengguna yang sudah login dengan middleware role
Route::middleware('auth')->group(function () {

    // Route untuk Super Admin
    Route::middleware(RoleMiddleware::class . ':super_admin')->prefix('superadmin')->group(function () {

        // Route Data Barang
        Route::get('/dashboard', [AuthController::class, 'superAdminDashboard'])->name('superadmin.dashboard');
        Route::get('/databarang', [BarangController::class, 'index'])->name('superadmin.databarang');
        // Route::get('/databarang', [BarangController::class, 'index'])->name('barang.index');
        Route::post('/databarang/store', [BarangController::class, 'store'])->name('barang.store');
        Route::get('/databarang/create', [BarangController::class, 'create'])->name('barang.create');
        Route::get('/databarang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
        Route::get('/databarang/list', [BarangController::class, 'list'])->name('databarang.list');
        Route::delete('/databarang/{id}', [BarangController::class, 'destroy'])->name('superadmin.barang.destroy');
        Route::put('/databarang/{id}', [BarangController::class, 'update'])->name('superadmin.barang.update');
        // Route untuk generate PDF
        Route::get('/databarang/pdf', [BarangController::class, 'generatePDF'])->name('barang.pdf');

        // Route untuk Perubahan Data Barang
        Route::get('/perubahandatabrg', [PerubahanBarangController::class, 'index'])->name('superadmin.perubahandatabrg');
        Route::get('/barang/edit/{id}/{source}', [PerubahanBarangController::class, 'edit'])->name('perubahan.edit');
        Route::put('/barang/update/{id}', [PerubahanBarangController::class, 'update'])->name('perubahan.update');
        Route::delete('/barang/destroy/{id}', [PerubahanBarangController::class, 'destroy'])->name('barang.destroy');
        Route::get('/perubahanbarang/pdf', [PerubahanBarangController::class, 'generatePDF'])->name('perubahanbarang.pdf');

        // Route Upgrade Barang
        Route::get('/upgradebarang', [UpgradeBarangController::class, 'index'])->name('upgradebarang.index');
        Route::get('/upgradebarang/items', [BarangController::class, 'getUpgradedItems'])->name('upgradebarang.items');
        Route::delete('/upgradebarang/destroy/{id}', [UpgradeBarangController::class, 'destroy'])->name('upgradebarang.destroy');
        Route::get('/upgradebarang/create', [UpgradeBarangController::class, 'create'])->name('upgradebarang.create');
        Route::get('/pdfupgradebarang/pdf', [UpgradeBarangController::class, 'generatePDF'])->name('upgradebarang.pdf');

        // Route untuk halaman perbaikan barang
        Route::get('/perbaikan', [PerbaikanBarangController::class, 'index'])->name('superadmin.perbaikan');
        Route::get('/perbaikan/{id}/edit', [PerbaikanBarangController::class, 'edit'])->name('perbaikan.edit');
        Route::put('/perbaikan/{id}', [PerbaikanBarangController::class, 'update'])->name('perbaikan.update');
        Route::get('/pdfperbaikan/pdf', [PerbaikanBarangController::class, 'generatePDF'])->name('perbaikanbarang.pdf');
        Route::delete('/perbaikan/destroy/{id}', [PerbaikanBarangController::class, 'destroy'])->name('perbaikanbarang.destroy');
        // Route untuk halaman peminjaman barang
        Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('superadmin.peminjaman');
        Route::put('/peminjaman/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
        Route::get('/peminjaman/form', [PeminjamanController::class, 'form'])->name('peminjaman.form');
        Route::post('/peminjaman/store', [PeminjamanController::class, 'store'])->name('peminjaman.store');

        // Route untuk halaman pengembalian barang
        Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('superadmin.pengembalian');
        Route::post('/pengembalian/{id}', [PengembalianController::class, 'update'])->name('pengembalian.pengembalianBarang');
        Route::get('/superadmin/pengembalian/pdf', [PengembalianController::class, 'generatePDF'])->name('superadmin.pengembalian.pdf');


        // route riwayat peminjaman
        Route::get('/riwayat-peminjaman', [RiwayatPeminjaman::class, 'index'])->name('superadmin.riwayat-peminjaman');

        // Route laporan umum
        Route::get('/laporan', [LaporanController::class, 'index'])->name('superadmin.laporan');
        Route::get('/laporan/pdf', [LaporanController::class, 'generatePDF'])->name('superadmin.laporan.pdf');

        // Route untuk mengelola User
        Route::get('/user', [UserController::class, 'index'])->name('superadmin.user');
        Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/user', [UserController::class, 'store'])->name('user.store');
        Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

        // Route untuk menampilkan profil user
        Route::get('/profile', [ProfileController::class, 'showProfile'])->name('superadmin.profile');
        Route::get('/profile/edit', [ProfileController::class, 'editProfile'])->name('superadmin.profile.edit');
        Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('superadmin.profile.update');

        Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
        Route::post('/notifikasi', [NotifikasiController::class, 'store']);
        Route::put('/notifikasi/{id}', [NotifikasiController::class, 'updateStatus']);
        Route::post('/notifikasi/accept', [NotifikasiController::class, 'accept'])->name('notifikasi.accept');
        Route::post('/notifikasi/reject', [NotifikasiController::class, 'reject'])->name('notifikasi.reject');
        Route::post('/notifikasi/return', [NotifikasiController::class, 'acceptReturn'])->name('notifikasi.return');

    });

    // Route untuk Admin
    Route::middleware(RoleMiddleware::class . ':admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('admin.notifikasi');
        Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('admin.peminjaman');
        Route::post('/peminjaman/store', [PeminjamanController::class, 'store'])->name('admin.store');
        Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('admin.pengembalian');
        // Route untuk databarang user
        Route::get('/databarang', [BarangController::class, 'index'])->name('admin.databarang');
        Route::get('/databarang/{id}/edit', [BarangController::class, 'edit'])->name('admin.barang.edit');
        Route::post('/databarang/store', [BarangController::class, 'store'])->name('admin.barang.store');
        Route::delete('/databarang/{id}', [BarangController::class, 'destroy'])->name('admin.barang.destroy');
        Route::put('/databarang/{id}', [BarangController::class, 'update'])->name('admin.barang.update');
        Route::get('/databarang/pdf', [BarangController::class, 'generatePDF'])->name('admin.barang.pdf');
        Route::get('/databarang/create', [BarangController::class, 'create'])->name('admin.barang.create');
        // Route untuk Perubahan Data Barang
        Route::get('/perubahandatabrg', [PerubahanBarangController::class, 'adminIndex'])->name('admin.perubahandatabrg');
        Route::get('/barang/edit/{id}/{source}', [PerubahanBarangController::class, 'edit'])->name('admin.perubahan.edit');
        Route::put('/barang/update/{id}', [PerubahanBarangController::class, 'update'])->name('admin.perubahan.update');
        Route::delete('/barang/destroy/{id}', [PerubahanBarangController::class, 'destroy'])->name('admin.perubahanbarang.destroy');
        Route::get('/perubahanbarang/pdf', [PerubahanBarangController::class, 'generatePDF'])->name('admin.perubahanbarang.pdf');
        // Route untuk Upgrade
        Route::get('/upgrade', [UpgradeBarangController::class, 'adminIndex'])->name('admin.upgradebarang');
        Route::get('/upgradebarang/items', [BarangController::class, 'getUpgradedItems'])->name('admin.upgradebarang.items');
        Route::get('/upgradebarang/{id}/edit', [UpgradeBarangController::class, 'edit'])->name('admin.upgradebarang.edit');
        Route::put('/upgradebarang/{id}', [UpgradeBarangController::class, 'update'])->name('admin.upgradebarang.update');
        Route::delete('/upgradebarang/destroy/{id}', [UpgradeBarangController::class, 'destroy'])->name('admin.upgradebarang.destroy');
        Route::get('/upgradebarang/create', [UpgradeBarangController::class, 'create'])->name('admin.upgradebarang.create');
        Route::get('/upgradebarang/pdf', [UpgradeBarangController::class, 'generatePDF'])->name('admin.upgradebarang.pdf');
        // Route untuk perbaikan
        Route::get('/perbaikan', [PerbaikanBarangController::class, 'adminIndex'])->name('admin.perbaikan');
        Route::get('/perbaikan/{id}/edit', [PerbaikanBarangController::class, 'edit'])->name('admin.perbaikan.edit');
        Route::put('/perbaikan/{id}', [PerbaikanBarangController::class, 'update'])->name('admin.perbaikan.update');
        Route::delete('/perbaikan/destroy/{id}', [PerbaikanBarangController::class, 'destroy'])->name('admin.perbaikan.destroy');
        Route::get('/perbaikanbarang/pdf', [PerbaikanBarangController::class, 'generatePDF'])->name('admin.perbaikan.pdf');
        // Route untuk pengembalian
        Route::post('/pengembalian/{id}', [PengembalianController::class, 'update'])->name('admin.pengembalianBarang');
        Route::get('/admin/pengembalian/pdf', [PengembalianController::class, 'generatePDF'])->name('admin.pengembalian.pdf');
        // Route laporan umum
        Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan');
        Route::get('/laporan/pdf', [LaporanController::class, 'generatePDF'])->name('admin.laporan.pdf');
        // Route untuk menampilkan profil user
        Route::get('/profile', [ProfileController::class, 'showProfile'])->name('admin.profile');
        Route::get('/profile/edit', [ProfileController::class, 'editProfile'])->name('admin.profile.edit');
        Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('admin.profile.update');

    });

    // Route untuk User
    Route::middleware(RoleMiddleware::class . ':user')->prefix('user')->group(function () {
        Route::get('/dashboard', [AuthController::class, 'userDashboard'])->name('user.dashboard');
        // Route untuk databarang user
        Route::get('/databarang', [BarangController::class, 'userIndex'])->name('user.databarang');
        Route::get('/databarang/create', [BarangController::class, 'create'])->name('user.barang.create');
        Route::post('/databarang/store', [BarangController::class, 'store'])->name('user.barang.store');
        // Route untuk perubahandatabarang user
        Route::get('/perubahandatabrg', [PerubahanBarangController::class, 'userIndex'])->name('user.perubahandatabrg');
        // Route untuk halaman perbaikan barang (user)
        Route::get('/perbaikan', [PerbaikanBarangController::class, 'userIndex'])->name('user.perbaikan');
        // Route untuk halaman upgrade barang (user)
        Route::get('/upgrade', [UpgradeBarangController::class, 'userIndex'])->name('user.upgradebarang');
        // Route peminjaman, pengembalian, notif
        Route::get('/peminjaman', [PeminjamanController::class, 'userIndex'])->name('user.peminjaman');
        Route::get('/pengembalian', [PengembalianController::class, 'userIndex'])->name('user.pengembalian');
        Route::get('/user/pengembalian/pdf', [PengembalianController::class, 'generatePDF'])->name('user.pengembalian.pdf');
        Route::post('/pengembalian/{id}', [PengembalianController::class, 'update'])->name('user.pengembalianBarang');
        Route::get('/notifikasi', [NotifikasiController::class, 'userIndex'])->name('user.notifikasi');
        Route::post('/peminjaman/store', [PeminjamanController::class, 'store'])->name('user.store');
        // Route untuk halaman profile user
        Route::get('/profile', [ProfileController::class, 'showProfile'])->name('user.profile');
        Route::get('/profile/edit', [ProfileController::class, 'editProfile'])->name('user.profile.edit');
        Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('user.profile.update');

    });

    Route::middleware('auth')->group(function () {
        // Rute untuk generate QR code PDF, bisa diakses oleh semua role (superadmin, admin, user)
        Route::get('/databarang/{id}/qrcode/pdf', [BarangController::class, 'generateQrCodePdf'])
            ->name('barang.qrcode.pdf');
    });

});