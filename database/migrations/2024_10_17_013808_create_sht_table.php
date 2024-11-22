<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sht', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pegawai')->unique(); // Misalkan ini adalah primary key
            $table->string('nama')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->date('tgl_masuk')->nullable();
            $table->string('mkg', 50)->nullable();
            $table->string('gol', 50)->nullable();
            $table->string('jabatan', 255)->nullable();
            $table->bigInteger('jumlah_sht')->nullable();
            $table->string('kebun', 50)->nullable();
            $table->string('jenis_pensiun', 50)->nullable();
            $table->date('bulan')->nullable();
            $table->year('periode_pensiun')->nullable();
            $table->string('keterangan', 50)->nullable();
            $table->string('no_spp', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sht');
    }
};
