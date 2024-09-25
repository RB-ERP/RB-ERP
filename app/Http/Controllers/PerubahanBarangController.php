<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PerubahanBarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::paginate(10);
        return view('superadmin.perubahandatabrg', compact('barangs'));
    }

    // Fungsi untuk menampilkan form tambah barang dan perubahan
    public function create()
    {
        $barangs = Barang::all();  // Mengambil semua data barang untuk dropdown
        return view('superadmin.formtambahupgrade', compact('barangs'));
    }

    // Fungsi untuk menyimpan barang dan perubahan baru
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_barang' => 'required',
            'kode_barang' => 'required',
            'tanggal_pembelian' => 'required|date',
            'spesifikasi' => 'required',
            'harga' => 'required|numeric',
            'status' => 'required',
            'tanggal_perubahan' => 'nullable|date',
            'jenis_perubahan' => 'nullable|string',
            'deskripsi_perubahan' => 'nullable|string',
            'biaya_perubahan' => 'nullable|numeric',
        ]);

        // Simpan data ke tabel barang
        Barang::create($validatedData);

        return redirect()->route('barang.index')->with('success', 'Data berhasil ditambahkan!');
    }

    // Fungsi untuk mengedit barang dan perubahan
    public function edit($id, $source)
    {
        $barang = Barang::findOrFail($id);

        return view('superadmin.formeditbarang', compact('barang', 'source'));
    }

    // Fungsi untuk menghapus barang
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Data berhasil dihapus!');
    }

    // Fungsi untuk mengupdate barang dan perubahan
    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_barang' => 'required',
            'kode_barang' => 'required',
            'tanggal_pembelian' => 'required|date',
            'spesifikasi' => 'required',
            'harga' => 'required|numeric',
            'status' => 'required',
            'tanggal_perubahan' => 'nullable|date',
            'jenis_perubahan' => 'nullable|string',
            'deskripsi_perubahan' => 'nullable|string',
            'biaya_perubahan' => 'nullable|numeric',
        ]);

        // Ambil data barang berdasarkan ID dan update
        $barang = Barang::findOrFail($id);
        $barang->update($validatedData);

        return redirect()->route('superadmin.databarang')->with('success', 'Data barang berhasil diperbarui!');
    }

    // Function untuk generate PDF
    public function generatePDF()
    {
        $barangs = Barang::all(); // Ambil data perubahan barang

        // Buat PDF dengan orientasi landscape
        $pdf = Pdf::loadView('superadmin.pdfperubahandatabarang', compact('barangs'))->setPaper('a4', 'landscape');

        return $pdf->download('laporan_perubahan_barang.pdf');
    }
}
