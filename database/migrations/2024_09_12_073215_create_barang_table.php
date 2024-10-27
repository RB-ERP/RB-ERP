<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->string('kode_barang');
            $table->date('tanggal_pembelian');
            $table->string('spesifikasi');
            $table->bigInteger('harga');
            $table->enum('status', [
                'Tersedia', 
                'Dipinjam', 
                'Rusak', 
                'Diperbaiki', 
                'Pengajuan Peminjaman', 
                'Pengajuan Pengembalian'
            ])->default('Tersedia'); 
            $table->string('serial_number')->nullable();
            $table->unsignedBigInteger('peminjam_id')->nullable();
            $table->foreign('peminjam_id')->references('id')->on('users')->onDelete('set null'); // Menambahkan kolom id_peminjam dan relasi ke tabel users
            $table->string('nama_peminjam')->nullable();
            $table->date('tanggal_peminjaman')->nullable();
            $table->date('tanggal_pengembalian')->nullable();
            $table->date('tanggal_perubahan')->nullable();
            $table->string('jenis_perubahan')->nullable();
            $table->text('deskripsi_perubahan')->nullable();
            $table->decimal('biaya_perubahan', 10, 2)->nullable();
            $table->string('keterangan')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
