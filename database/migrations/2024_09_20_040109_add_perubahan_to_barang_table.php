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
            $table->enum('jenis_perubahan', ['Upgrade', 'Perbaikan'])->nullable();
            $table->text('deskripsi_perubahan')->nullable();
            $table->bigInteger('biaya_perubahan')->nullable();
            $table->date('tanggal_perubahan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            //
        });
    }
};