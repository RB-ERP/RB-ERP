<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\Notifikasi;
use App\Models\RiwayatPeminjaman;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PengembalianController extends Controller
{
    // Menampilkan riwayat peminjaman dengan filter tanggal
    public function index(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $user = auth()->user();

        $query = RiwayatPeminjaman::with('barang');

        // Jika ada filter tanggal
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_peminjaman', [$startDate, $endDate]);
        }

        $riwayats = $query->paginate(10);

        if ($user->role == 'super_admin') {
            return view('superadmin.pengembalian', compact('riwayats'));
        } else {
            return view('admin.pengembalian', compact('riwayats'));
        }
    }

    // Proses pengembalian barang
    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        if ($barang->status != 'Dipinjam') {
            return response()->json(['success' => false, 'message' => 'Barang ini tidak sedang dipinjam.']);
        }

        $barang->update(['status' => 'Pengajuan Pengembalian']);

        if (!$barang->nama_peminjam || !$barang->peminjam_id) {
            return response()->json(['success' => false, 'message' => 'Data peminjam tidak valid.']);
        }

        Notifikasi::create([
            'barang_id' => $barang->id,
            'nama_peminjam' => $barang->nama_peminjam,
            'peminjam_id' => $barang->peminjam_id,
            'tipe' => 'Pengajuan Pengembalian',
            'status' => 'Belum Dibaca',
        ]);

        return response()->json(['success' => true, 'message' => 'Pengembalian barang berhasil diajukan.']);
    }


    public function userIndex()
    {
        $riwayats = RiwayatPeminjaman::with('barang')->where('peminjam_id', Auth::user()->id)->paginate(10);

        $user = Auth::user();

        if ($user->role == 'super_admin'){
            return view('superadmin.pengembalian', compact('riwayats'));
        } elseif ($user->role == 'user'){
            return view('user.pengembalian', compact('riwayats'));
        }
        // Kirimkan data ke view
        return view('superadmin.pengembalian', compact('riwayats'));
    }

    // Fungsi untuk cetak PDF
    public function generatePDF(Request $request)
    {
        $user = auth()->user();  // Dapatkan user yang sedang login
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');

        // Query data riwayat peminjaman
        $query = RiwayatPeminjaman::with('barang');

        // Jika user adalah 'user', filter berdasarkan peminjam_id
        if ($user->role === 'user') {
            $query->where('peminjam_id', $user->id);  // Hanya tampilkan data milik user
        }

        // Filter tanggal jika ada
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_peminjaman', [$startDate, $endDate]);
        }

        $riwayats = $query->get();  // Ambil data yang sesuai

        // Pilih view sesuai role
        $view = match ($user->role) {
            'super_admin' => 'superadmin.pdf_riwayat_peminjaman',
            'admin' => 'admin.pdf_riwayat_peminjaman',
            'user' => 'user.pdf_riwayat_peminjaman',
            default => abort(403, 'Role tidak diizinkan untuk mencetak PDF.'),
        };

        // Buat PDF menggunakan view yang sesuai
        $pdf = Pdf::loadView($view, compact('riwayats'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('riwayat_peminjaman.pdf');
    }


}