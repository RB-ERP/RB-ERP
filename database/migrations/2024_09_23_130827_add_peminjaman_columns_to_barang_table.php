<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPeminjamanColumnsToBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->string('nama_peminjam')->nullable()->after('harga');
            $table->date('tanggal_peminjaman')->nullable()->after('nama_peminjam');
            $table->date('tanggal_pengembalian')->nullable()->after('tanggal_peminjaman');
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
            $table->dropColumn('nama_peminjam');
            $table->dropColumn('tanggal_peminjaman');
            $table->dropColumn('tanggal_pengembalian');
        });
    }
}