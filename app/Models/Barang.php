<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PerubahanBarang;  // Pastikan relasi model sudah di-include

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';  // Nama tabel di database
    public $timestamps = false;

    protected $fillable = [
        'nama_barang',
        'kode_barang',
        'tanggal_pembelian',
        'spesifikasi',
        'harga',
        'status',
        'tanggal_perubahan',
        'jenis_perubahan',
        'deskripsi_perubahan',
        'biaya_perubahan',
        'keterangan', // Pastikan keterangan ada di sini
        'nama_peminjam',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
        'serial_number',
    ];

    // Relasi satu barang memiliki banyak perubahan
    // Model Barang
    public function perubahanBarang()
    {
        return $this->hasMany(PerubahanBarang::class, 'barang_id');
    }

    public function riwayatPeminjaman()
    {
        return $this->hasMany(RiwayatPeminjaman::class);
    }


}