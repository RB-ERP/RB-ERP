<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Barang;  // Pastikan relasi model barang sudah di-include

class PerubahanBarang extends Model
{
    use HasFactory;

    protected $table = 'barang'; // Nama tabel di database
    public $timestamps = false;

    protected $fillable = [
        'nama_barang',
        'kode_barang',
        'tanggal_pembelian',
        'spesifikasi',
        'harga'
    ];

    // Relasi ke barang
    // app/Models/PerubahanBarang.php
    // Model PerubahanBarang
    // Model PerubahanBarang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}