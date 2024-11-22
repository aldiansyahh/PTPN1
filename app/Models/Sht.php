<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Sht extends Model
{
    use HasFactory;

    protected $table = 'sht';

    protected $primaryKey = 'id';

    // Model Sht.php
    public function jenisPensiun()
    {
        return $this->belongsTo(JenisPensiun::class, 'kd_jenis_pensiun', 'kd_jenis_pensiun');
    }

    protected $fillable = [
        'id',
        'nomor_pegawai',              // No Register
        'nama',                     // Nama Peserta
        'tgl_lahir',            // Tanggal Lahir
        'tgl_masuk',            // Tanggal Masuk
        'mkg',                      // MKG
        'gol',                 // Golongan
        'jabatan',                  // Jabatan
        'jumlah_sht',               // Jumlah SHT
        'kebun',                    // Kebun
        'jenis_pensiun',            // Jenis Pensiun
        'bulan',                    // Bulan
        'periode_pensiun',          // Periode Pensiun
        'keterangan',                // Keterangan
        'no_spp'
    ];

    protected $guarded = [];


    public $timestamps = true;
}
