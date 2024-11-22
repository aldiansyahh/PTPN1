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
        Schema::create('riwayat_penerima', function (Blueprint $table) {
            $table->id('no_riwayat_penerima');
            $table->string('nomor_pegawai');
            $table->foreign('nomor_pegawai')
                ->references('nomor_pegawai')
                ->on('sht')
                ->onDelete('cascade');
            $table->string('no_peserta');
            $table->string('nama_peserta');
            $table->string('jenis_kelamin');
            $table->string('no_peserta_lama');
            $table->string('kd_jenis_pensiun');
            $table->foreign('kd_jenis_pensiun')
                ->references('kd_jenis_pensiun')
                ->on('jenis_pensiun')
                ->onDelete('cascade');
            $table->decimal('nilai_manfaat_pensiun', 15, 2);
            $table->string('nama_bank');
            $table->string('no_rekening');
            $table->string('atas_nama');
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
        Schema::dropIfExists('riwayat_penerima');
    }
};
