<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';

    protected $fillable = [
        'nama_peminjam',
        'barang_id',
        'tipe',
        'peminjam_id',
        'status',
    ];

    // Relasi ke tabel User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke tabel Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

}
