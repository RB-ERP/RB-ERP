<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\Barang;
use App\Models\RiwayatPeminjaman;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        // Ambil notifikasi yang belum dibaca
        $notifikasiBelumDibaca = Notifikasi::where('status', 'Belum Dibaca')
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil notifikasi yang sudah dibaca
        $notifikasiDibaca = Notifikasi::where('status', 'Dibaca')
            ->orderBy('created_at', 'desc')
            ->get();

        // Kembalikan kedua kategori notifikasi ke view notification.blade.php
        return view('superadmin.notification', compact('notifikasiBelumDibaca', 'notifikasiDibaca'));
    }


    public function store(Request $request)
    {
        Notifikasi::create([
            'nama_peminjam' => $request->nama_peminjam,
            'barang_id' => $request->barang_id,
            'tipe' => $request->tipe,
            'status' => 'Belum Dibaca',
        ]);

        return response()->json(['message' => 'Notifikasi berhasil dibuat!']);
    }

    public function updateStatus($id, Request $request)
    {
        $notifikasi = Notifikasi::find($id);
        $notifikasi->status = $request->status;
        $notifikasi->save();

        return response()->json(['message' => 'Status notifikasi diperbarui!']);
    }

    public function accept(Request $request)
    {
        $notifikasi = Notifikasi::findOrFail($request->notifikasi_id);

        // Ubah status notifikasi menjadi 'Dibaca'
        $notifikasi->status = 'Dibaca';
        $notifikasi->save();

        // Ubah status barang menjadi 'Dipinjam'
        $barang = Barang::findOrFail($notifikasi->barang_id);
        $barang->status = 'Dipinjam';
        $barang->save();

        return response()->json(['message' => 'Peminjaman diterima dan status barang diperbarui.']);
    }

    public function reject(Request $request)
    {
        // Validasi data yang diterima
        $validated = $request->validate([
            'notifikasi_id' => 'required|exists:notifikasi,id',
        ]);

        // Temukan notifikasi berdasarkan ID
        $notifikasi = Notifikasi::findOrFail($validated['notifikasi_id']);

        // Ubah status notifikasi menjadi 'Dibaca'
        $notifikasi->status = 'Dibaca';
        $notifikasi->save();

        // Ubah status barang menjadi 'Tersedia' (jika pengembalian ditolak)
        $barang = Barang::findOrFail($notifikasi->barang_id);
        $barang->status = 'Tersedia';
        $barang->save();

        // Simpan ke Riwayat Peminjaman
        RiwayatPeminjaman::create([
            'barang_id' => $barang->id,
            'nama_peminjam' => $barang->nama_peminjam,
            'tanggal_peminjaman' => $barang->tanggal_peminjaman,
            'tanggal_pengembalian' => null,
            'status' => 'Ditolak',
        ]);

        return response()->json(['message' => 'Permintaan ditolak dan status barang diperbarui.']);
    }



    public function acceptReturn(Request $request)
    {
        $notifikasi = Notifikasi::findOrFail($request->notifikasi_id);

        // Ubah status notifikasi menjadi 'Dibaca'
        $notifikasi->status = 'Dibaca';
        $notifikasi->save();

        // Ubah status barang menjadi 'Tersedia'
        $barang = Barang::findOrFail($notifikasi->barang_id);
        $barang->status = 'Tersedia';
        $barang->save();

        // Simpan ke Riwayat Peminjaman
        RiwayatPeminjaman::create([
            'barang_id' => $barang->id,
            'nama_peminjam' => $barang->nama_peminjam,
            'tanggal_peminjaman' => $barang->tanggal_peminjaman,
            'tanggal_pengembalian' => now(),
            'status' => 'Dikembalikan',
        ]);

        return response()->json(['message' => 'Pengembalian diterima dan barang tersedia.']);
    }
}