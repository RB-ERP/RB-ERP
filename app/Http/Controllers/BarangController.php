<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BarangController extends Controller
{
    // Fungsi untuk menampilkan data barang dengan filter
    public function index()
    {
        // Paginate the data with 10 items per page
        $barangs = Barang::paginate(10);
        Log::info('Data barang ditampilkan di halaman index.');
        return view('superadmin.databarang', compact('barangs'));
    }

    // Fungsi untuk menambahkan barang baru
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_barang' => 'required',
            'kode_barang' => 'required|string|unique:barang,kode_barang,NULL,id,serial_number,' . $request->serial_number,
            'serial_number' => 'required|string',
            'tanggal_pembelian' => 'required|date',
            'spesifikasi' => 'required',
            'harga' => 'required|numeric',
            'status' => 'required',
        ], [
            'kode_barang.unique' => 'Kombinasi Kode Barang dan Serial Number sudah ada!',
        ]);

        // Create new record in barang table
        Barang::create($validatedData);

        Log::info('Barang baru berhasil ditambahkan: ' . $validatedData['nama_barang']);

        // Redirect back to the index page with success message
        return redirect()->route('superadmin.databarang')->with('success', 'Data berhasil ditambahkan!');
    }

    // Fungsi untuk menampilkan form tambah barang
    public function create()
    {
        Log::info('Form tambah data diakses.');
        return view('superadmin.formdatabarangbaru');
    }

    // Fungsi untuk mengedit barang
    public function edit($id, $source)
    {
        $barang = Barang::findOrFail($id);
        Log::info('Form edit barang diakses untuk barang ID: ' . $id);
        return view('superadmin.formeditbarang', compact('barang', 'source'));
    }

    // Fungsi untuk menghapus barang
    public function destroy($id)
    {
        try {
            $barang = Barang::findOrFail($id);
            $barang->delete();

            Log::info('Barang ID: ' . $id . ' berhasil dihapus.');
            return redirect()->route('superadmin.databarang')->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus barang ID: ' . $id . '. Error: ' . $e->getMessage());
            return redirect()->route('superadmin.databarang')->with('error', 'Data gagal dihapus!');
        }
    }

    // Fungsi untuk mengupdate barang yang sudah diubah
    public function update(Request $request, $id)
    {
        // Validasi input data
        $validatedData = $request->validate([
            'nama_barang' => 'required',
            'kode_barang' => 'required',
            'tanggal_pembelian' => 'required|date',
            'spesifikasi' => 'required',
            'harga' => 'required|numeric',
            'status' => 'required',
        ]);

        // Cari barang berdasarkan ID
        $barang = Barang::findOrFail($id);

        // Update barang dengan data yang tervalidasi
        $barang->update($validatedData);

        Log::info('Barang ID: ' . $id . ' berhasil diperbarui.');

        // Redirect setelah update berhasil
        return redirect()->route('superadmin.databarang')->with('success', 'Data berhasil diperbarui!');
    }
}