<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\RiwayatPeminjaman;


class PengembalianController extends Controller
{
    // Menampilkan barang yang statusnya 'Dipinjam' untuk dikembalikan
    public function index()
    {
        // Ambil barang yang statusnya 'Dipinjam'
        $barangs = Barang::where('status', 'Dipinjam')->paginate(10);

        // Ambil riwayat peminjaman yang sudah ada tanggal pengembaliannya
        $riwayats = RiwayatPeminjaman::whereNotNull('tanggal_pengembalian')->paginate(10);

        return view('superadmin.pengembalian', compact('barangs', 'riwayats'));
    }



   // Menghandle proses pengembalian barang
   public function update(Request $request, $id)
    {
        // Cari barang yang ingin dikembalikan
        $barang = Barang::findOrFail($id);

        // Cari riwayat peminjaman yang belum dikembalikan
        $riwayat = RiwayatPeminjaman::where('barang_id', $barang->id)
            ->whereNull('tanggal_pengembalian') // Cari riwayat yang belum dikembalikan
            ->first();

        // Update tanggal pengembalian di riwayat peminjaman
        if ($riwayat) {
            $riwayat->update([
                'tanggal_pengembalian' => now(),
            ]);
        }

        // Update status barang jadi 'Tersedia' dan kosongkan nama_peminjam dan tanggal_peminjaman
        $barang->update([
            'status' => 'Tersedia',
            'nama_peminjam' => null, // kosongkan nama_peminjam
            'tanggal_peminjaman' => null, // kosongkan tanggal_peminjaman
        ]);

        return redirect()->route('superadmin.pengembalian')->with('success', 'Barang berhasil dikembalikan!');
    }

}
