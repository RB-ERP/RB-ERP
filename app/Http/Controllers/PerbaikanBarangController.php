<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class PerbaikanBarangController extends Controller
{
    /**
     * Display a listing of items with 'Perbaikan' status.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Ambil data barang yang jenis_perubahannya adalah 'Perbaikan'
        $barangs = Barang::where('jenis_perubahan', 'Perbaikan')->paginate(10);

        // Return the view for the repair page, passing the 'barangs' data
        return view('superadmin.perbaikan', compact('barangs'));
    }

    /**
     * Show the form for editing the specified item.
     */
    public function edit($id, Request $request)
    {
        // Ambil data barang berdasarkan ID
        $barang = Barang::findOrFail($id);

        // Tangkap nilai parameter 'source' dari URL
        $source = $request->input('source');

        // Return view 'formeditperbaikan' dengan data barang dan source
        return view('superadmin.formeditperbaikan', compact('barang', 'source'));
    }

    /**
     * Update the specified item in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input dari form
        $request->validate([
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
            'keterangan' => 'nullable|string',
        ]);

        // Ambil data barang berdasarkan ID dan update
        $barang = Barang::findOrFail($id);
        $barang->update($request->all());

        // Redirect kembali ke halaman perbaikan dengan pesan sukses
        return redirect()->route('superadmin.perbaikan')->with('success', 'Data barang berhasil diperbarui!');
    }
}