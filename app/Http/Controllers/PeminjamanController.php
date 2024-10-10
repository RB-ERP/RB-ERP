<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\RiwayatPeminjaman; // Tambahkan ini
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;



class PeminjamanController extends Controller
{
    // Fungsi untuk menampilkan daftar barang yang sedang dipinjam
    public function index()
    {
        // Ambil barang yang statusnya 'Tersedia'
        $barangsAvailable = Barang::whereIn('status', ['Tersedia', 'Pengajuan Peminjaman'])->paginate(10);

        // Ambil barang yang statusnya 'Dipinjam'
        $barangsDipinjam = Barang::whereIn('status', ['Dipinjam', 'Pengajuan Pengembalian'])->paginate(10);

        // Kirim kedua variabel ke view
        return view('superadmin.peminjaman', compact('barangsAvailable', 'barangsDipinjam'));
    }


    // Controller method for form peminjaman
    public function form()
    {
        // Ambil barang yang statusnya 'Tersedia' untuk ditampilkan di form peminjaman
        $barangs = Barang::where('status', 'Tersedia')->get();

        return view('superadmin.formpeminjaman', compact('barangs'));
    }

    // Fungsi untuk menyimpan data peminjaman
    // Store peminjaman baru
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'barang_id' => 'required',
            'nama_peminjam' => 'required',
            'tanggal_peminjaman' => 'required|date',
        ]);
        

        $barang = Barang::findOrFail($validatedData['barang_id']);

        $barang->update([
            'status' => 'Pengajuan Peminjaman',
            'nama_peminjam' => $validatedData['nama_peminjam'],
            'tanggal_peminjaman' => $validatedData['tanggal_peminjaman'],
        ]);

        // Buat notifikasi baru
        Notifikasi::create([
            'nama_peminjam' => $validatedData['nama_peminjam'],
            'barang_id' => $barang->id,
            'tipe' => 'Pengajuan Peminjaman',
            'status' => 'Belum Dibaca',
        ]);

        return redirect()->route('superadmin.peminjaman')->with('success', 'Peminjaman berhasil disimpan!');
    }



    // Fungsi untuk mengupdate status peminjaman barang
    public function update(Request $request, $id)
    {
        // Validasi input data
        $validatedData = $request->validate([
            'nama_peminjam' => 'required|string',
            'tanggal_peminjaman' => 'required|date',
        ]);

        // Cari barang berdasarkan ID
        $barang = Barang::findOrFail($id);

        // Update nama peminjam dan tanggal peminjaman
        $barang->update([
            'nama_peminjam' => $request->input('nama_peminjam'),
            'tanggal_peminjaman' => $request->input('tanggal_peminjaman'),
            'status' => 'Dipinjam',  // Pastikan status juga berubah menjadi Dipinjam
        ]);

        // Redirect setelah update berhasil
        return redirect()->route('superadmin.peminjaman')->with('success', 'Data peminjaman berhasil diperbarui!');
    }
}
