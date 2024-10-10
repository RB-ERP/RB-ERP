<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    // Method untuk menampilkan halaman laporan
    public function index(Request $request)
    {
        // Ambil input dari form
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $namaBarang = $request->input('nama_barang');
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $status = $request->input('status');

        // Query dasar untuk mendapatkan barang
        $query = Barang::query();

        // Filter berdasarkan nama barang jika diisi
        if (!empty($namaBarang)) {
            $query->where('nama_barang', 'LIKE', '%' . $namaBarang . '%');
        }

        // Filter berdasarkan bulan dan tahun jika diisi
        if (!empty($bulan) && !empty($tahun)) {
            $query->whereMonth('tanggal_pembelian', $bulan)
                  ->whereYear('tanggal_pembelian', $tahun);
        } elseif (!empty($bulan)) {
            $query->whereMonth('tanggal_pembelian', $bulan);
        } elseif (!empty($tahun)) {
            $query->whereYear('tanggal_pembelian', $tahun);
        }

        // Filter berdasarkan status jika diisi
        if (!empty($status)) {
            $query->where('status', $status);
        }

        // Filter berdasarkan rentang tanggal pembelian jika diisi
        if (!empty($start_date) && !empty($end_date)) {
            $query->whereBetween('tanggal_pembelian', [$start_date, $end_date]);
        }

        // Dapatkan hasil dengan pagination
        $barangs = $query->paginate(10);

        // Ambil user yang sedang login
        $user = auth()->user();

        return view('superadmin.laporan', compact('barangs', 'bulan', 'tahun', 'status', 'namaBarang', 'start_date', 'end_date', 'user'));
    }

    // Method untuk generate PDF
    public function generatePDF(Request $request)
    {
        // Ambil data filter dari request (tanggal mulai dan tanggal selesai)
        $tanggalMulai = $request->input('mulai');
        $tanggalSelesai = $request->input('selesai');

        // Filter data berdasarkan status dan tanggal peminjaman
        $barangs = Barang::when($tanggalMulai && $tanggalSelesai, function($query) use ($tanggalMulai, $tanggalSelesai) {
                            return $query->whereBetween('tanggal_peminjaman', [$tanggalMulai, $tanggalSelesai]);
                        })
                        ->get();

        // Buat PDF dengan data yang difilter
        $pdf = Pdf::loadView('superadmin.laporan_pdf', compact('barangs'))
                  ->setPaper('a4', 'landscape') // Atur orientasi landscape
                  ->setOptions(['defaultFont' => 'sans-serif']);

        // Download PDF dengan nama yang ditentukan
        return $pdf->download('laporan_barang.pdf');
    }
}