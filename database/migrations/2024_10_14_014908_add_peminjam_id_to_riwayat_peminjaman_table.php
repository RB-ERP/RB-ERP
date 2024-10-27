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
        Schema::table('riwayat_peminjaman', function (Blueprint $table) {
            $table->unsignedBigInteger('peminjam_id')->nullable();
            $table->foreign('peminjam_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('riwayat_peminjaman', function (Blueprint $table) {
            $table->dropForeign(['peminjam_id']);
            $table->dropColumn('peminjam_id');
        });
    }

};