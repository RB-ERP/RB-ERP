<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class PerbaikanBarangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');

        // Query barang dengan filter
        $query = Barang::where('jenis_perubahan', 'Perbaikan');

        if ($search) {
            $query->where('nama_barang', 'LIKE', '%' . $search . '%');
        }

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_pembelian', [$startDate, $endDate]);
        }

        $barangs = $query->paginate(10); // Paginate data
        $user = auth()->user();

        return view('superadmin.perbaikan', compact('barangs', 'user'));
    }

    // Untuk user
    public function adminIndex(Request $request)
    {
        $search = $request->query('search');
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');

        // Query barang dengan filter
        $query = Barang::where('jenis_perubahan', 'Perbaikan');

        if ($search) {
            $query->where('nama_barang', 'LIKE', '%' . $search . '%');
        }

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_pembelian', [$startDate, $endDate]);
        }

        $barangs = $query->paginate(10); // Paginate data
        $user = auth()->user();

        return view('admin.perbaikan', compact('barangs', 'user'));
    }

    // Untuk user
    public function userIndex(Request $request)
    {

        $search = $request->query('search');
        $filter = $request->query('filter', 'nama');
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');

        $query = Barang::where('jenis_perubahan', 'Perbaikan');

        if ($filter === 'nama' && $search) {
            $query->where('nama_barang', 'LIKE', '%' . $search . '%');
        } elseif ($filter === 'tanggal' && $search) {
            $query->whereDate('tanggal_pembelian', $search);
        }

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_pembelian', [$startDate, $endDate]);
        }

        $barangs = $query->paginate(10);
        $user = auth()->user();

        return view('user.perbaikan', compact('barangs', 'user'));
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

    public function destroy($id)
    {
        // Ambil data barang berdasarkan ID
        $barang = Barang::findOrFail($id);

        // Hapus barang
        $barang->delete();

        $user = auth()->user();

        if (auth()->user()->role === 'super_admin') {
            return redirect()->route('superadmin.perbaikan')->with('success', 'Data barang berhasil dihapus!');
        } elseif (auth()->user()->role === 'admin') {
            return redirect()->route('admin.perbaikan')->with('success', 'Data barang berhasil dihapus!');
        }
        // Redirect ke halaman perbaikan dengan pesan sukses
        return back()->with('error', 'Anda tidak memiliki izin untuk menghapus data.');
    }

    public function generatePDF(Request $request)
    {
        $search = $request->query('search');
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');

        // Query hanya data dengan jenis 'Perbaikan'
        $query = Barang::where('jenis_perubahan', 'Perbaikan');

        if ($search) {
            $query->where('nama_barang', 'LIKE', '%' . $search . '%');
        }

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_pembelian', [$startDate, $endDate]);
        }

        $perbaikans = $query->get(); // Ambil data yang difilter

        // Tentukan view berdasarkan role pengguna
        $role = auth()->user()->role;
        $viewPath = match ($role) {
            'admin' => 'admin.pdfperbaikanbarang',
            'super_admin' => 'superadmin.pdfperbaikanbarang',
            'user' => 'user.pdfperbaikanbarang',
            default => abort(403, 'Role tidak valid.'),
        };

        // Generate PDF dengan view yang tepat
        $pdf = Pdf::loadView($viewPath, compact('perbaikans'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('laporan_perbaikan_barang.pdf');
    }

}