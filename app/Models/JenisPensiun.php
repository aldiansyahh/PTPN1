<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPensiun extends Model
{
    use HasFactory;

    protected $table = 'jenis_pensiun'; // Nama tabel
    protected $primaryKey = 'no_jenis_pensiun'; // Primary key
    public $incrementing = true; // Auto-increment


    public $timestamps = false; // Nonaktifkan timestamp jika kolom tidak ada

    protected $fillable = [
        'kd_jenis_pensiun',
        'nama_jenis_pensiun',
    ];
    protected $guarded = [];
}
