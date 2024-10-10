<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusPengajuanToBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->enum('status', [
                'Tersedia', 
                'Dipinjam', 
                'Rusak', 
                'Diperbaiki', 
                'Pengajuan Peminjaman', 
                'Pengajuan Pengembalian'
            ])->default('Tersedia')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->enum('status', [
                'Tersedia', 
                'Dipinjam', 
                'Rusak', 
                'Diperbaiki'
            ])->default('Tersedia')->change();
        });
    }
}
