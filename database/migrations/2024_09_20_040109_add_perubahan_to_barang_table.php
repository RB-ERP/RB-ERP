<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPerubahanColumnsToBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->date('tanggal_perubahan')->nullable();
            $table->string('jenis_perubahan')->nullable();
            $table->text('deskripsi_perubahan')->nullable();
            $table->decimal('biaya_perubahan', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn('tanggal_perubahan');
            $table->dropColumn('jenis_perubahan');
            $table->dropColumn('deskripsi_perubahan');
            $table->dropColumn('biaya_perubahan');
        });
    }
}