<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifikasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('nama_peminjam'); // Nama peminjam bukan user_id
            $table->foreignId('barang_id')->constrained('barang')->onDelete('cascade'); // Relasi ke tabel Barang
            $table->string('tipe'); // Tipe Notifikasi, contoh: Pengajuan Peminjaman
            $table->enum('status', ['Belum Dibaca', 'Dibaca'])->default('Belum Dibaca'); // Status Notifikasi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifikasi');
    }
}
