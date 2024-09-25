<?php

namespace App\Models;

use App\Http\Controllers\Controller;
use App\Models\RiwayatPeminjaman; // Import model RiwayatPeminjaman

class PeminjamanController extends Controller
{
    // Method untuk menampilkan riwayat peminjaman
    public function index()
    {
        // Ambil semua riwayat peminjaman
        $riwayats = RiwayatPeminjaman::paginate(10);

        return view('superadmin.riwayat', compact('riwayats'));
    }

}