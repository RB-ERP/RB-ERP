<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request; // Jangan lupa untuk mengimpor Request
use App\Models\Barang;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;



class UpgradeBarangController extends Controller
{
    // Menampilkan daftar barang yang di-upgrade
    public function index()
    {
        // Ambil hanya data barang dengan jenis_perubahan 'Upgrade'
        $barangs = Barang::where('jenis_perubahan', 'Upgrade')->paginate(10);

        // Ambil user yang sedang login
        $user = auth()->user();

        return view('superadmin.upgradebarang', compact('barangs', 'user'));
    }

    public function create()
    {
        $barangs = DB::table('barang')->get();
        return view('superadmin.formtambahdataperubahanbarang', compact('barangs'));
    }

    // Fungsi untuk mengedit barang yang di-upgrade
    public function edit($id)
    {
        // Mengambil data barang dari tabel 'barang' berdasarkan ID yang diberikan
        $barang = DB::table('barang')
            ->select('barang.*') // Mengambil semua kolom dari tabel barang
            ->where('barang.id', $id)
            ->first();

        if (!$barang) {
            return redirect()->route('upgradebarang.index')->withErrors('Data tidak ditemukan atau bukan upgrade.');
        }

        // Mengarahkan ke view 'formeditupgrade' dengan data barang yang diambil
        return view('superadmin.formeditupgrade', compact('barang'));
    }

    // Fungsi untuk mengupdate data barang yang di-upgrade
    public function update(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
            'jenis_perubahan' => 'required',
            'deskripsi_perubahan' => 'required',
            'biaya_perubahan' => 'required|numeric',
        ]);

        // Update data di tabel barang berdasarkan ID
        DB::table('barang')
            ->where('id', $id)
            ->update([
                'jenis_perubahan' => $request->jenis_perubahan,
                'deskripsi_perubahan' => $request->deskripsi_perubahan,
                'biaya_perubahan' => $request->biaya_perubahan,
            ]);

        return redirect()->route('upgradebarang.index')->with('success', 'Data berhasil diupdate');
    }

    // Fungsi untuk menghapus barang yang di-upgrade
    public function destroy($id)
    {
        // Menghapus data perubahan barang berdasarkan ID
        DB::table('perubahan_barangs')->where('id', $id)->delete();

        return redirect()->route('upgradebarang.index')->with('success', 'Data berhasil dihapus');
    }

    public function generatePDF()
    {
        $upgrades = Barang::where('jenis_perubahan', 'Upgrade')->get();
        $pdf = FacadePdf::loadView('superadmin.pdfupgradebarang', compact('upgrades'))->setPaper('a4', 'landscape');
        return $pdf->download('laporan_upgrade_barang.pdf');
    }



}
