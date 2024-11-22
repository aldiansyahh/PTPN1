<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PenerimaSht extends Model
{
    use HasFactory;

    protected $table = 'penerima_sht';

    protected $primaryKey = 'no_penerima_sht';

    // Model penerima_sht.php
    public function jenisPensiun()
    {
        return $this->belongsTo(JenisPensiun::class, 'kd_jenis_pensiun', 'kd_jenis_pensiun');
    }

    protected $fillable = [
        'no_penerima_sht',
        'nomor_pegawai',
        'nama_peserta',
        'no_peserta',
        'jenis_kelamin',
        'no_peserta_lama',
        'kd_jenis_pensiun',
        'nama_jenis_pensiun',
        'nilai_manfaat_pensiun',
        'nama_bank',
        'no_rekening',
        'atas_nama'
    ];
    protected $guarded = [];


    public $timestamps = true;
    public function penerimasht()
    {
        return $this->belongsTo(PenerimaSht::class, 'no_peserta', 'no_peserta');
    }
}