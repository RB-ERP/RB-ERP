<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanUpgradeController extends Controller
{
    // Method to display the Laporan Upgrade page
    public function index()
    {
        // Ambil semua data yang jenis_perubahannya 'Upgrade'
        $barangs = Barang::where('jenis_perubahan', 'Upgrade')->paginate(10);

        // Return ke view laporanupgrade dengan data yang didapatkan
        return view('superadmin.laporanupgrade', compact('barangs'));
    }

    // Method to generate PDF
    public function generatePDF(Request $request)
    {
        // Ambil data filter dari request (tanggal mulai dan tanggal selesai)
        $tanggalMulai = $request->input('mulai');
        $tanggalSelesai = $request->input('selesai');

        // Debug untuk memastikan parameter diterima dengan benar
        // dd($tanggalMulai, $tanggalSelesai);

        // Cek apakah filter tanggal diberikan, jika tidak ambil semua data
        $barangs = Barang::where('jenis_perubahan', 'Upgrade')
                         ->when($tanggalMulai && $tanggalSelesai, function($query) use ($tanggalMulai, $tanggalSelesai) {
                             return $query->whereBetween('tanggal_pembelian', [$tanggalMulai, $tanggalSelesai]);
                         })
                         ->get();

        // Buat PDF dengan data yang difilter
        $pdf = Pdf::loadView('superadmin.laporanupgrade_pdf', compact('barangs'))
                  ->setPaper('a4', 'landscape') // Atur orientasi landscape
                  ->setOptions(['defaultFont' => 'sans-serif']);

        // Download PDF dengan nama yang ditentukan
        return $pdf->download('laporan_upgrade.pdf');
    }
}
