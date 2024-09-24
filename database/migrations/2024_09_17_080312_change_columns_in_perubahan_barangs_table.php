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
        Schema::table('perubahan_barangs', function (Blueprint $table) {
            $table->bigInteger('biaya_perubahan')->change(); // Mengubah kolom 'biaya_perubahan'
            $table->enum('jenis_perubahan', ['Upgrade', 'Perbaikan'])->change(); // Mengubah kolom 'jenis_perubahan' jadi enum
        });
    }

    public function down()
    {
        Schema::table('perubahan_barangs', function (Blueprint $table) {
            $table->decimal('biaya_perubahan', 10, 2)->change(); // Mengembalikan kolom 'biaya_perubahan' ke tipe sebelumnya
            $table->string('jenis_perubahan')->change(); // Mengembalikan kolom 'jenis_perubahan' ke tipe sebelumnya
        });
    }
};