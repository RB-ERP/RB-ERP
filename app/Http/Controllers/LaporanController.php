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

        // Ambil hasil dengan pagination
        $barangs = $query->paginate(10);

        // Ambil user yang sedang login
        $user = auth()->user();

        // Pilih view berdasarkan role user
        if ($user->role === 'super_admin') {
            $view = 'superadmin.laporan';
        } elseif ($user->role === 'admin') {
            $view = 'admin.laporan';
        } else {
            return redirect()->back()->withErrors(['message' => 'Akses tidak diizinkan.']);
        }

        // Render view yang sesuai dengan role
        return view($view, compact('barangs', 'bulan', 'tahun', 'status', 'namaBarang', 'start_date', 'end_date', 'user'));
    }

    // Method untuk generate PDF
    public function generatePDF(Request $request)
    {
        // Inisialisasi query untuk data barang
        $query = Barang::query();

        // Filter Nama Barang jika diisi
        if ($request->has('nama_barang') && !empty($request->nama_barang)) {
            $query->where('nama_barang', 'LIKE', '%' . $request->nama_barang . '%');
        }

        // Filter berdasarkan Bulan dan Tahun
        if ($request->has('bulan') && $request->has('tahun')) {
            $query->whereMonth('tanggal_pembelian', $request->bulan)
                  ->whereYear('tanggal_pembelian', $request->tahun);
        } elseif ($request->has('bulan')) {
            $query->whereMonth('tanggal_pembelian', $request->bulan);
        } elseif ($request->has('tahun')) {
            $query->whereYear('tanggal_pembelian', $request->tahun);
        }

        // Filter berdasarkan Status Barang jika diisi
        if ($request->has('status') && $request->status != 'Semua') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan Rentang Tanggal Pembelian jika diisi
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tanggal_pembelian', [$request->start_date, $request->end_date]);
        }

        // Ambil data barang berdasarkan filter
        $barangs = $query->get();

        // Tentukan view yang akan digunakan berdasarkan role pengguna
        $user = auth()->user();
        $view = $user->role === 'admin' ? 'admin.laporan_pdf' : 'superadmin.laporan_pdf';

        // Generate PDF dari view yang sesuai
        $pdf = Pdf::loadView($view, compact('barangs'))
                  ->setPaper('a4', 'landscape')
                  ->setOptions(['defaultFont' => 'sans-serif']);

        // Kembalikan file PDF untuk didownload
        return $pdf->download('laporan_barang.pdf');
    }


}
