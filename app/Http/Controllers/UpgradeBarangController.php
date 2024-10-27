<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request; // Jangan lupa untuk mengimpor Request
use App\Models\Barang;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class UpgradeBarangController extends Controller
{
    // Menampilkan daftar barang yang di-upgrade untuk superadmin
    public function index(Request $request)
    {
        $search = $request->query('search');
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');

        // Query barang dengan jenis_perubahan 'Upgrade'
        $query = Barang::where('jenis_perubahan', 'Upgrade');

        if ($search) {
            $query->where('nama_barang', 'LIKE', '%' . $search . '%');
        }

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_pembelian', [$startDate, $endDate]);
        }

        $barangs = $query->paginate(10)->appends($request->query());

        $user = auth()->user();
        return view('superadmin.upgradebarang', compact('barangs', 'user'));
    }


    // Menampilkan daftar upgrade untuk admin
    public function adminIndex(Request $request)
    {
        $search = $request->query('search');
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');

        $query = Barang::where('jenis_perubahan', 'Upgrade');

        if ($search) {
            $query->where('nama_barang', 'LIKE', '%' . $search . '%');
        }

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_pembelian', [$startDate, $endDate]);
        }

        $barangs = $query->paginate(10)->appends($request->query());

        $user = auth()->user();
        return view('admin.upgradebarang', compact('barangs', 'user'));
    }

    // Menampilkan daftar upgrade untuk user
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

        return view('user.upgradebarang', compact('barangs', 'user'));
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
        // Ambil user yang sedang login
        $user = auth()->user();

        // Batasi akses hanya untuk admin dan super_admin
        if (!in_array($user->role, ['admin', 'super_admin'])) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus data ini.');
        }

        // Hapus data barang berdasarkan ID
        DB::table('barang')->where('id', $id)->delete();

        // Redirect sesuai role
        if ($user->role === 'super_admin') {
            return redirect()->route('upgradebarang.index')->with('success', 'Data berhasil dihapus!');
        } elseif ($user->role === 'admin') {
            return redirect()->route('admin.upgradebarang')->with('success', 'Data berhasil dihapus!');
        }
    }

    // Generate PDF dengan filter
    public function generatePDF(Request $request)
    {
        $search = $request->query('search');
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');

        // Query barang dengan filter dan jenis_perubahan 'Upgrade'
        $query = Barang::where('jenis_perubahan', 'Upgrade');

        if ($search) {
            $query->where('nama_barang', 'LIKE', '%' . $search . '%');
        }

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_pembelian', [$startDate, $endDate]);
        }

        $upgrades = $query->get();

        // Pilih view berdasarkan role
        $role = auth()->user()->role;
        $viewPath = match ($role) {
            'admin' => 'admin.pdfupgradebarang',
            'super_admin' => 'superadmin.pdfupgradebarang',
            'user' => 'user.pdfupgradebarang',
            default => abort(403, 'Role tidak valid.'),
        };

        // Buat PDF dengan orientasi landscape
        $pdf = FacadePdf::loadView($viewPath, compact('upgrades'))
                        ->setPaper('a4', 'landscape');

        return $pdf->download('laporan_upgrade_barang.pdf');
    }

}