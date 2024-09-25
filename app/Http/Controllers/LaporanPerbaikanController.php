<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanPerbaikanController extends Controller
{
    // Method to display the Laporan Perbaikan page
    public function index()
    {
        // Ambil semua data yang jenis_perubahannya 'Perbaikan'
        $barangs = Barang::where('jenis_perubahan', 'Perbaikan')->paginate(10);

        // Return ke view laporanperbaikan dengan data yang didapatkan
        return view('superadmin.laporanperbaikan', compact('barangs'));
    }

    // Method to generate PDF
    public function generatePDF()
    {
        // Ambil data barang yang perlu diubah ke PDF
        $barangs = Barang::where('jenis_perubahan', 'Perbaikan')->get();

        // Buat PDF dengan pengaturan landscape dan margin
        $pdf = Pdf::loadView('superadmin.laporanperbaikan_pdf', compact('barangs'))
                  ->setPaper('a4', 'landscape') // Atur orientasi landscape
                  ->setOptions(['defaultFont' => 'sans-serif']);

        // Download PDF dengan nama yang ditentukan
        return $pdf->download('laporan_perbaikan.pdf');
    }

}
