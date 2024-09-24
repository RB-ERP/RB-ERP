<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->bigInteger('harga')->change(); // Mengubah kolom 'harga' di tabel 'barang'
        });
    }

    public function down()
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->decimal('harga', 10, 2)->change(); // Mengembalikan kolom 'harga' ke tipe sebelumnya
        });
    }
};