<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request; // Jangan lupa untuk mengimpor Request
use App\Models\Barang;


class UpgradeBarangController extends Controller
{
    // Menampilkan daftar barang yang di-upgrade
    public function index()
    {
        // Ambil hanya data barang dengan jenis_perubahan 'Upgrade'
        $barangs = Barang::where('jenis_perubahan', 'Upgrade')->paginate(10);

        return view('superadmin.upgradebarang', compact('barangs'));
    }

    public function create()
    {
        $barangs = DB::table('barang')->get();
        return view('superadmin.formtambahdataperubahanbarang', compact('barangs'));
    }

    // Fungsi untuk mengedit barang yang di-upgrade
    public function edit($id)
    {
        $perubahanBarang = DB::table('perubahan_barangs')
            ->join('barang', 'barang.id', '=', 'perubahan_barangs.barang_id')
            ->select('perubahan_barangs.*', 'barang.nama_barang', 'barang.spesifikasi')
            ->where('perubahan_barangs.id', $id)
            ->where('perubahan_barangs.jenis_perubahan', 'Upgrade') // Filter jenis perubahan Upgrade
            ->first();

        if (!$perubahanBarang) {
            return redirect()->route('upgradebarang.index')->withErrors('Data tidak ditemukan atau bukan upgrade.');
        }

        return view('superadmin.formeditupgrade', compact('perubahanBarang'));
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

        // Update data di tabel perubahan_barangs berdasarkan ID
        DB::table('perubahan_barangs')
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
}