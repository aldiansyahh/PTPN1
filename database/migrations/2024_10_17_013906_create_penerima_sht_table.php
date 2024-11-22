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
        Schema::create('penerima_sht', function (Blueprint $table) {
            $table->id('no_penerima_sht');  // Primary key
            $table->string('nomor_pegawai')->nullable();
            $table->string('no_peserta')->nullable();
            $table->string('nama_peserta')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('no_peserta_lama')->nullable();
            $table->string('kd_jenis_pensiun')->nullable();
            $table->foreign('kd_jenis_pensiun')
                ->references('kd_jenis_pensiun')
                ->on('jenis_pensiun')
                ->onDelete('cascade');
            $table->decimal('nilai_manfaat_pensiun', 15, 2)->nullable();
            $table->string('nama_bank')->nullable();
            $table->string('no_rekening')->nullable();
            $table->string('atas_nama')->nullable();
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('penerima_sht');
    }
};
