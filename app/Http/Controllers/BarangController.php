<?php

namespace App\Http\Controllers;

use App\Models\Barang;
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
        if ($user->role == 'super_admin') {
            return view('superadmin.databarang', compact('barangs', 'user'));
        } elseif ($user->role == 'user') {
            return view('user.databarang', compact('barangs', 'user')); // Tampilkan halaman khusus user
        }
    }

    // Fungsi untuk menambahkan barang baru
    public function store(Request $request)
    {
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

        Barang::create($validatedData);

        Log::info('Barang baru berhasil ditambahkan: ' . $validatedData['nama_barang']);

        return redirect()->route('superadmin.databarang')->with('success', 'Data berhasil ditambahkan!');
    }

    // Fungsi untuk menampilkan form tambah barang
    public function create()
    {
        Log::info('Form tambah data diakses.');
        return view('superadmin.formdatabarangbaru');
    }

    // Fungsi untuk mengedit barang
    public function edit($id)
    {
        $barang = Barang::find($id);
        $source = request()->query('source');

        return view('superadmin.formeditbarang', compact('barang', 'source'));
    }

    // Fungsi untuk menghapus barang
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();
        return redirect()->route('superadmin.databarang')->with('success', 'Barang berhasil dihapus');
    }

    // Fungsi untuk mengupdate barang yang sudah diubah
    public function update(Request $request, $id)
    {
        $barang = Barang::find($id);

        $barang->nama_barang = $request->input('nama_barang');
        $barang->kode_barang = $request->input('kode_barang');
        $barang->serial_number = $request->input('serial_number');
        $barang->tanggal_pembelian = $request->input('tanggal_pembelian');
        $barang->spesifikasi = $request->input('spesifikasi');
        $barang->harga = $request->input('harga');
        $barang->status = $request->input('status');

        if ($request->has('tanggal_perubahan')) {
            $barang->tanggal_perubahan = $request->input('tanggal_perubahan');
            $barang->jenis_perubahan = $request->input('jenis_perubahan');
            $barang->deskripsi_perubahan = $request->input('deskripsi_perubahan');
            $barang->biaya_perubahan = $request->input('biaya_perubahan');
        }

        $barang->save();

        return redirect()->route('superadmin.databarang')->with('success', 'Data berhasil diperbarui!');
    }

    // Fungsi untuk generate PDF
    public function generatePDF()
    {
        $barangs = Barang::all();

        $pdf = Pdf::loadView('superadmin.pdfdatabarang', compact('barangs'));

        return $pdf->download('laporan_data_barang.pdf');
    }

    // Fungsi untuk generate QR code PDF
    public function generateQrCodePdf($id)
    {
        // Ambil data barang berdasarkan ID
        $barang = Barang::findOrFail($id);

        // Gabungkan data yang ingin ditampilkan dalam QR code
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
        $qrCode = base64_encode(QrCode::format('svg')->size(300)->generate($qrCodeText));

        // Load view untuk PDF yang berisi QR code
        $pdf = Pdf::loadView('qrcode.qrcode', compact('barang', 'qrCode'));

        // Download file PDF
        return $pdf->download('qrcode_barang_'.$barang->kode_barang.'.pdf');
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

        return view('superadmin.laporan', compact('barangs', 'bulan', 'tahun', 'status'));
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

}
