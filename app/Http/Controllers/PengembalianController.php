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
        // Ambil data barang dengan status 'Dipinjam' atau 'Tersedia'
        $barangs = Barang::whereIn('status', ['Dipinjam', 'Tersedia'])->paginate(10);

        return view('superadmin.pengembalian', compact('barangs'));
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

        // Update status barang jadi 'Tersedia'
        $barang->update([
            'status' => 'Tersedia',
            'nama_peminjam' => null,
            'tanggal_peminjaman' => null,
            'tanggal_pengembalian' => null,
        ]);

        return redirect()->route('superadmin.pengembalian')->with('success', 'Barang berhasil dikembalikan!');
    }

}