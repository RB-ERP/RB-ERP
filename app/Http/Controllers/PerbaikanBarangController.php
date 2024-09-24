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
}