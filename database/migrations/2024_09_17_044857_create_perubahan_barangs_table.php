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
        // database/migrations/xxxx_xx_xx_create_perubahan_barangs_table.php
        Schema::create('perubahan_barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barang')->onDelete('cascade');
            $table->date('tanggal_perubahan')->nullable();
            $table->enum('jenis_perubahan', ['Upgrade', 'Perbaikan']);
            $table->text('deskripsi_perubahan')->nullable();
            $table->bigInteger('biaya_perubahan'); // Sama untuk biaya perubahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perubahan_barangs');
    }
};