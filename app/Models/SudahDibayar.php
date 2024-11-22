<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SudahDibayar extends Model
{
    use HasFactory;

    protected $table = 'sudah_dibayar'; // Nama tabel
    protected $primaryKey = 'no_sudah_dibayar'; // Primary key
    public $incrementing = true; // Auto-increment


    public $timestamps = false; // Nonaktifkan timestamp jika kolom tidak ada

    protected $fillable = [
        'no_peserta',
        'nomor_pegawai',
        'nama_peserta',
        'jenis_kelamin',
        'no_peserta_lama',
        'kd_jenis_pensiun',
        'nama_jenis_pensiun',
        'nilai_manfaat_pensiun',
        'nama_bank',
        'no_rekening',
        'atas_nama',
    ];
}
