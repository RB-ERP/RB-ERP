<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangController extends Controller
{
    // Fungsi untuk menampilkan data barang dengan filter
    public function index(Request $request)
    {
        // Ambil parameter pencarian dari request
        $search = $request->input('search');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        // Buat query dasar
        $query = Barang::query();

        // Jika ada parameter pencarian berdasarkan nama
        if (!empty($search)) {
            $query->where('nama_barang', 'LIKE', '%' . $search . '%');
        }

        // Jika ada parameter filter tanggal
        if (!empty($startDate) && !empty($endDate)) {
            $query->whereBetween('tanggal_pembelian', [$startDate, $endDate]);
        }

        // Dapatkan data dengan paginasi
        $barangs = $query->paginate(10);

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
    public function edit($id) {
        $barang = Barang::find($id); // Temukan data barang berdasarkan ID
        $source = request()->query('source'); // Ambil nilai 'source' dari URL

        return view('superadmin.formeditbarang', compact('barang', 'source')); // Kirim barang dan source ke view
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
    public function update(Request $request, $id) {
        $barang = Barang::find($id);

        // Update data barang
        $barang->nama_barang = $request->input('nama_barang');
        $barang->kode_barang = $request->input('kode_barang');
        $barang->tanggal_pembelian = $request->input('tanggal_pembelian');
        $barang->spesifikasi = $request->input('spesifikasi');
        $barang->harga = $request->input('harga');
        $barang->status = $request->input('status');

        // Jika ada data perubahan, simpan ke kolom perubahan
        if ($request->has('tanggal_perubahan')) {
            $barang->tanggal_perubahan = $request->input('tanggal_perubahan');
            $barang->jenis_perubahan = $request->input('jenis_perubahan');
            $barang->deskripsi_perubahan = $request->input('deskripsi_perubahan');
            $barang->biaya_perubahan = $request->input('biaya_perubahan');
        }

        // Simpan perubahan ke database
        $barang->save();

        // Redirect dengan pesan sukses
        return redirect()->route('superadmin.databarang')->with('success', 'Data berhasil diperbarui!');
    }


    public function generatePDF()
    {
        // Ambil semua data barang dari database
        $barangs = Barang::all();

        // Return PDF view yang berisi data barang
        $pdf = Pdf::loadView('superadmin.pdfdatabarang', compact('barangs'));

        // Download file PDF
        return $pdf->download('laporan_data_barang.pdf');
    }

    public function list() {
        // Fetch and return the list of items (barang)
        $barangs = Barang::all();
        return view('databarang.list', compact('barangs'));
    }

}