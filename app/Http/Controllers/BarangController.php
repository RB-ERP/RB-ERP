<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\RiwayatPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BarangController extends Controller
{
    // Fungsi untuk menampilkan data barang dengan filter
    public function index(Request $request)
    {
        $search = $request->input('search');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $query = Barang::query();

        if (!empty($search)) {
            $query->where('nama_barang', 'LIKE', '%' . $search . '%');
        }

        if (!empty($startDate) && !empty($endDate)) {
            $query->whereBetween('tanggal_pembelian', [$startDate, $endDate]);
        }

        $barangs = $query->paginate(10);

        // Ambil user yang sedang login
        $user = auth()->user();

        // Cek role user
        if ($user->role === 'super_admin') {
            return view('superadmin.databarang', compact('barangs', 'user'));
        } elseif ($user->role === 'admin') {
            return view('admin.databarang', compact('barangs', 'user'));
        } elseif ($user->role === 'user') {
            return view('user.databarang', compact('barangs', 'user'));
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_barang' => 'required',
            'kode_barang' => 'required|string|unique:barang,kode_barang',
            'serial_number' => 'required|string|unique:barang,serial_number',
            'tanggal_pembelian' => 'required|date',
            'spesifikasi' => 'required',
            'harga' => 'required|numeric',
            'status' => 'required',
        ]);

        Barang::create($validatedData);

        $user = auth()->user();

        // Redirect sesuai role
        if ($user->role === 'super_admin') {
            return redirect()->route('superadmin.databarang')->with('success', 'Data berhasil ditambahkan!');
        } elseif ($user->role === 'admin') {
            return redirect()->route('admin.databarang')->with('success', 'Data berhasil ditambahkan!');
        } else {
            // Redirect untuk user biasa
            return redirect()->route('user.databarang')->with('success', 'Data berhasil ditambahkan!');
        }
    }

    // Fungsi untuk menampilkan form tambah barang
    public function create()
    {
        $user = auth()->user();

        // Periksa role user untuk menentukan view yang benar
        if ($user->role === 'super_admin') {
            return view('superadmin.formdatabarangbaru'); // View untuk admin/super_admin
        } elseif ($user->role === 'admin') {
            return view('admin.formdatabarangbaru'); // View khusus untuk admin
        } elseif ($user->role === 'user') {
            return view('user.formdatabarangbaru'); // View khusus untuk user
        }
    }

    // Fungsi untuk mengedit barang
    public function edit($id, Request $request)
    {
        $barang = Barang::findOrFail($id); // Cari barang berdasarkan ID
        $source = $request->query('source'); // Ambil parameter 'source' dari URL
        $user = auth()->user(); // Ambil user yang sedang login

        // Cek role user untuk menentukan view mana yang digunakan
        if ($user->role === 'super_admin') {
            return view('superadmin.formeditbarang', compact('barang', 'source'));
        } elseif ($user->role === 'admin') {
            return view('admin.formeditbarang', compact('barang', 'source'));
        } else {
            abort(403, 'Anda tidak memiliki akses untuk mengedit barang.');
        }
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


    // Fungsi untuk mengupdate barang yang sudah diubah
    public function update(Request $request, $id)
    {
        Log::info('Memulai update barang ID: ' . $id);

        $validatedData = $request->validate([
            'nama_barang' => 'required',
            'kode_barang' => 'required|string|unique:barang,kode_barang,' . $id,
            'serial_number' => 'required|string|unique:barang,serial_number,' . $id,
            'tanggal_pembelian' => 'required|date',
            'spesifikasi' => 'required',
            'harga' => 'required|numeric',
            'status' => 'required',
        ]);

        Log::info('Data valid: ' . json_encode($validatedData));

        $barang = Barang::findOrFail($id);
        $barang->update($validatedData);

        $user = auth()->user();
        if ($user->role === 'super_admin') {
            return redirect()->route('superadmin.databarang')->with('success', 'Data berhasil diperbarui!');
        } elseif ($user->role === 'admin') {
            return redirect()->route('admin.databarang')->with('success', 'Data berhasil diperbarui!');
        }
    }

    // Fungsi untuk generate PDF
    public function generatePDF(Request $request)
    {
        $user = auth()->user();

        // Batasi akses hanya untuk admin atau super_admin
        if (!in_array($user->role, ['admin', 'super_admin'])) {
            abort(403, 'Anda tidak memiliki izin untuk mencetak PDF.');
        }

        // Inisialisasi query untuk filter data
        $query = Barang::query();

        // Filter berdasarkan rentang tanggal
        if ($request->has('startDate') && $request->has('endDate')) {
            $query->whereBetween('tanggal_pembelian', [$request->startDate, $request->endDate]);
        }

        // Filter berdasarkan pencarian nama barang
        if ($request->has('search')) {
            $query->where('nama_barang', 'LIKE', '%' . $request->search . '%');
        }

        // Ambil data sesuai filter atau semua data jika tidak ada filter
        $barangs = $query->get();

        // Buat PDF menggunakan view
        $view = $user->role === 'admin' ? 'admin.pdfdatabarang' : 'superadmin.pdfdatabarang';
        $pdf = Pdf::loadView($view, compact('barangs'));

        return $pdf->download('laporan_data_barang.pdf');
    }

    // Fungsi untuk generate QR code PDF
    public function generateQrCodePdf($id)
    {
        $user = auth()->user();

        // Pengecekan role, hanya izinkan akses untuk admin, superadmin, atau user
        if (!in_array($user->role, ['admin', 'super_admin', 'user'])) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        // Ambil data barang berdasarkan ID
        $barang = Barang::findOrFail($id);

        // Gabungkan data untuk QR code
        $qrCodeText = "Nama Barang: {$barang->nama_barang}\n"
                    . "Kode Barang: {$barang->kode_barang}\n"
                    . "Serial Number: {$barang->serial_number}\n"
                    . "Tanggal Pembelian: {$barang->tanggal_pembelian}\n"
                    . "Spesifikasi: {$barang->spesifikasi}\n"
                    . "Status: {$barang->status}\n"
                    . "Jenis Perubahan: {$barang->jenis_perubahan}\n"
                    . "Tanggal Perubahan: {$barang->tanggal_perubahan}\n"
                    . "Harga: Rp {$barang->harga}";

        // Generate QR code dalam format base64 image
        $qrCode = base64_encode(QrCode::format('svg')->size(150)->generate($qrCodeText));

        // Load view untuk generate PDF
        $pdf = Pdf::loadView('qrcode.qrcode', compact('barang', 'qrCode'));

        // Download PDF
        return $pdf->download('qrcode_barang_' . $barang->kode_barang . '.pdf');
    }

    public function laporan(Request $request)
    {
        $bulan = $request->input('bulan') ?: date('m'); // Default bulan ini
        $tahun = $request->input('tahun') ?: date('Y'); // Default tahun ini
        $status = $request->input('status'); // Filter status dari request

        // Query untuk mendapatkan barang yang sesuai filter
        $query = Barang::whereMonth('tanggal_peminjaman', $bulan)
                       ->whereYear('tanggal_peminjaman', $tahun);

        if ($status) {
            $query->where('status', $status);
        }

        $barangs = $query->paginate(10); // Gunakan pagination

        // Ambil user yang sedang login
        $user = auth()->user();

        // Cek role dan arahkan ke view yang sesuai
        if ($user->role === 'super_admin') {
            return view('superadmin.laporan', compact('barangs', 'bulan', 'tahun', 'status', 'user'));
        } elseif ($user->role === 'admin') {
            return view('admin.laporan', compact('barangs', 'bulan', 'tahun', 'status', 'user'));
        }
    }

    public function barangDipinjamLebih90Hari()
    {
        $barangs = Barang::where('status', 'Dipinjam')
                        ->whereRaw('DATEDIFF(CURRENT_DATE(), tanggal_peminjaman) > 90')
                        ->get();

        return view('superadmin.baranglebih90hari', compact('barangs'));
    }

    public function userIndex()
    {
        // Ambil data barang, misal hanya yang diizinkan dilihat oleh user
        $barangs = Barang::paginate(10);

        // Return view untuk user
        return view('user.databarang', compact('barangs'));
    }

    public function peminjaman()
    {
        // Mengambil barang yang tersedia
        $barangsAvailable = Barang::where('status', 'Tersedia')->paginate(10);

        // Mengambil barang yang dipinjam atau dalam pengajuan pengembalian
        $barangsDipinjam = Barang::whereIn('status', ['Dipinjam', 'Pengajuan Pengembalian'])->paginate(10);

        return view('superadmin.peminjaman', compact('barangsAvailable', 'barangsDipinjam'));
    }

    public function pengembalian(Request $request, $id)
    {
        try {
            // Temukan barang berdasarkan ID
            $barang = Barang::findOrFail($id);

            // Perbarui status menjadi 'Tersedia' dan kosongkan nama peminjam
            $barang->update([
                'status' => 'Tersedia',
                'nama_peminjam' => null, // Kosongkan nama peminjam
                'peminjam_id' => null // Kosongkan peminjam_id jika ada
            ]);

            // Perbarui status di Riwayat Peminjaman
            RiwayatPeminjaman::where('barang_id', $id)
                ->where('status', 'Dipinjam')
                ->update([
                    'status' => 'Dikembalikan',
                    'tanggal_pengembalian' => now()
                ]);

            return response()->json(['success' => true, 'message' => 'Barang berhasil dikembalikan.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Kesalahan saat mengembalikan barang.'], 500);
        }
    }

}
