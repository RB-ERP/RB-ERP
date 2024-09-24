<?php

namespace App\Models;

use App\Http\Controllers\Controller;
use App\Models\RiwayatPeminjaman; // Import model RiwayatPeminjaman

class PeminjamanController extends Controller
{
    // Method untuk menampilkan riwayat peminjaman
    public function index()
    {
        // Ambil data riwayat peminjaman dari database dengan paginasi
        $riwayats = RiwayatPeminjaman::paginate(10);

        // Kirimkan data riwayats ke view
        return view('superadmin.peminjaman', compact('riwayats'));
    }
}
