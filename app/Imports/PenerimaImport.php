<?php

namespace App\Imports;

use App\Models\PenerimaSht;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PenerimaImport implements ToModel
{
    /**
     * Memetakan data dari Excel ke model Sht.
     *
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Validasi: Abaikan baris jika nomor_pegawai kosong
        if (empty($row[1])) {
            return null;
        }



        return new PenerimaSht([
            'nomor_pegawai' => $row[1],
            'nama_peserta' => $row[2],
            'no_peserta' => $row[3],
            'jenis_kelamin' => $row[4],
            'no_peserta_lama' => $row[5],
            'kd_jenis_pensiun' => $row[6],
            'nilai_manfaat_pensiun' => $row[7],
            'nama_bank' => $row[8],
            'no_rekening' => $row[9],
            'atas_nama' => $row[10],
        ]);
    }

    /**
     * Mengubah serial date dari Excel ke format tanggal (YYYY-MM-DD).
     *
     * @param mixed $excelDate
     * @return string|null
     */
    private function transformDate($excelDate)
    {
        if (is_numeric($excelDate)) {
            return Date::excelToDateTimeObject($excelDate)->format('Y-m-d');
        }
        return null;
    }
}
