<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PerubahanBarangController extends Controller
{
    // Untuk super admin
    public function index(Request $request)
    {
        $search = $request->query('search');
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');

        // Query barang dengan filter sesuai parameter
        $query = Barang::query();

        if ($search) {
            $query->where('nama_barang', 'LIKE', '%' . $search . '%');
        }

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_pembelian', [$startDate, $endDate]);
        }

        // Ambil data ter-filter dengan pagination
        $barangs = $query->paginate(10)->appends($request->query());

        $user = auth()->user();

        return view('superadmin.perubahandatabrg', compact('barangs', 'user'));
    }


    // Untuk admin
    public function adminIndex(Request $request)
    {
        $search = $request->query('search');
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');

        // Query barang dengan filter
        $query = Barang::query();

        if ($search) {
            $query->where('nama_barang', 'LIKE', '%' . $search . '%');
        }

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_pembelian', [$startDate, $endDate]);
        }

        $barangs = $query->paginate(10); // Paginate untuk halaman
        $user = auth()->user();

        return view('admin.perubahandatabrg', compact('barangs', 'user'));
    }


    // Untuk user
    public function userIndex(Request $request)
    {
        $search = $request->query('search');
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');

        // Query barang dengan filter
        $query = Barang::query();

        if ($search) {
            $query->where('nama_barang', 'LIKE', '%' . $search . '%');
        }

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_pembelian', [$startDate, $endDate]);
        }

        $barangs = $query->paginate(10); // Paginate untuk halaman
        $user = auth()->user();

        return view('user.perubahandatabrg', compact('barangs', 'user'));
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
            'keterangan' => 'nullable|string',  // Tambahkan keterangan di validasi
        ]);

        // Simpan data ke tabel barang
        Barang::create($validatedData);

        return redirect()->route('barang.index')->with('success', 'Data berhasil ditambahkan!');
    }

    // Fungsi untuk menghapus barang
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        $user = auth()->user();

        if (auth()->user()->role === 'super_admin') {
            return redirect()->route('superadmin.databarang')->with('success', 'Barang berhasil dihapus!');
        } elseif (auth()->user()->role === 'admin') {
            return redirect()->route('admin.databarang')->with('success', 'Barang berhasil dihapus!');
        }


        return back()->with('error', 'Anda tidak memiliki izin untuk menghapus data.');
    }

    public function edit($id, $source)
    {
        $barang = Barang::findOrFail($id); // Ambil data barang berdasarkan ID
        $user = auth()->user(); // Ambil user yang login

        // Cek role dan arahkan ke view yang sesuai
        if ($user->role === 'super_admin') {
            return view('superadmin.formeditperubahanbarang', compact('barang', 'source'));
        } elseif ($user->role === 'admin') {
            return view('admin.formeditperubahanbarang', compact('barang', 'source'));
        } else {
            abort(403, 'Anda tidak memiliki izin untuk mengedit barang.');
        }
    }



    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_barang' => 'required',
            'kode_barang' => 'required|string|unique:barang,kode_barang,' . $id,
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

        $barang = Barang::findOrFail($id);
        $barang->update($validatedData);

        $user = auth()->user();

        if ($user->role === 'super_admin') {
            return redirect()->route('superadmin.perubahandatabrg')->with('success', 'Data barang berhasil diperbarui!');
        } elseif ($user->role === 'admin') {
            return redirect()->route('admin.perubahandatabrg')->with('success', 'Data barang berhasil diperbarui!');
        } else {
            abort(403, 'Anda tidak memiliki izin untuk melakukan perubahan ini.');
        }
    }



    // Function untuk generate PDF dengan Query Parameters
    public function generatePDF(Request $request)
    {
        $search = $request->query('search');
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');

        // Query barang dengan filter sesuai parameter
        $query = Barang::query();

        if ($search) {
            $query->where('nama_barang', 'LIKE', '%' . $search . '%');
        }

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_pembelian', [$startDate, $endDate]);
        }

        $barangs = $query->get(); // Ambil data barang yang difilter

        // Buat PDF dengan orientasi landscape
        $pdf = Pdf::loadView('superadmin.pdfperubahandatabarang', compact('barangs'))
                ->setPaper('a4', 'landscape');

        return $pdf->download('laporan_perubahan_barang.pdf');
    }

}