<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'riwayat_peminjaman'; // Sesuaikan dengan nama tabel di database

    protected $fillable = [
        'barang_id',
        'nama_peminjam',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
    ];

    // Relasi ke model Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

}
