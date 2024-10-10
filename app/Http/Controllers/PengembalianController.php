<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\Notifikasi;
use App\Models\RiwayatPeminjaman;

class PengembalianController extends Controller
{
    // Menampilkan barang yang statusnya 'Dipinjam' untuk dikembalikan
    public function index()
    {
        $riwayats = RiwayatPeminjaman::with('barang')->paginate(10); // Sesuaikan pagination dengan kebutuhan

        // Kirimkan data ke view
        return view('superadmin.pengembalian', compact('riwayats'));
    }

    // Proses pengembalian barang
    public function update(Request $request, $id)
    {
        // Cari barang yang ingin dikembalikan
        $barang = Barang::findOrFail($id);

        // Update status barang jadi 'Pengajuan Pengembalian'
        $barang->update([
            'status' => 'Pengajuan Pengembalian',
        ]);

        // Buat record baru di tabel Notifikasi
        Notifikasi::create([
            'barang_id' => $barang->id,
            'nama_peminjam' => $barang->nama_peminjam,
            'tipe' => 'Pengajuan Pengembalian',
            'status' => 'Belum Dibaca',
        ]);

        // Kirimkan respons JSON setelah proses berhasil
        return response()->json(['success' => true, 'message' => 'Pengembalian barang berhasil diajukan.']);
    }
}
