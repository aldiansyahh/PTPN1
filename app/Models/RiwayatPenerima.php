<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPenerima extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari konvensi
    protected $table = 'riwayat_penerima';

    // Tentukan primary key
    protected $primaryKey = 'no_riwayat_penerima';

    // Tentukan apakah primary key auto-increment atau tidak
    public $incrementing = true;

    // Tentukan tipe primary key (integer atau string)
    protected $keyType = 'int';

    // Tentukan kolom-kolom yang dapat diisi (mass assignment)
    protected $fillable = [
        'no_peserta',
        'nomor_pegawai',
        'nama_peserta',
        'jenis_kelamin',
        'no_peserta_lama',
        'kd_jenis_pensiun',
        'nilai_manfaat_pensiun',
        'nama_bank',
        'no_rekening',
        'atas_nama',
    ];

    // Relasi ke model Sht (Foreign key)
    public function penerimasht()
    {
        return $this->belongsTo(PenerimaSht::class, 'no_peserta', 'no_peserta');
    }
}
