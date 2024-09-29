<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanPembaruanController extends Controller
{
    // Method untuk menampilkan halaman laporan pembaruan
    public function index()
    {
        // Ambil semua data barang tanpa filter jenis perubahan
        $barangs = Barang::paginate(10);

        // Tampilkan view laporanpembaruan dengan semua data barang
        return view('superadmin.laporanpembaruan', compact('barangs'));
    }

    // Method untuk generate PDF
    public function generatePDF(Request $request)
    {
        // Ambil data filter dari request jika ada
        $tanggalMulai = $request->input('mulai');
        $tanggalSelesai = $request->input('selesai');

        // Ambil semua data barang, gunakan filter tanggal jika ada
        $barangs = Barang::when($tanggalMulai && $tanggalSelesai, function($query) use ($tanggalMulai, $tanggalSelesai) {
                             return $query->whereBetween('tanggal_pembelian', [$tanggalMulai, $tanggalSelesai]);
                         })
                         ->get();

        // Generate PDF dengan semua data atau data yang difilter
        $pdf = Pdf::loadView('superadmin.laporanpembaruan_pdf', compact('barangs'))
                  ->setPaper('a4', 'landscape')
                  ->setOptions(['defaultFont' => 'sans-serif']);

        // Download PDF
        return $pdf->download('laporan_pembaruan.pdf');
    }
}