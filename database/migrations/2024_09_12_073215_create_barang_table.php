<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id(); // ID Barang
            $table->string('nama_barang'); // Nama Barang
            $table->string('kode_barang'); // Kode Barang
            $table->date('tanggal_pembelian'); // Tanggal Pembelian
            $table->string('spesifikasi'); // Spesifikasi Barang
            $table->bigInteger('harga'); // Mengganti harga menjadi angka tanpa decimal
            $table->enum('status', ['Tersedia', 'Dipinjam', 'Rusak', 'Diperbaiki']); // Status Barang
            $table->timestamps(); // Created At dan Updated At
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang');
    }
}