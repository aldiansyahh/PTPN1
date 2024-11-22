<?php

namespace App\Imports;

use App\Models\Sht;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ShtImport implements ToModel
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

        // Mengonversi tanggal Excel ke format YYYY-MM-DD
        $tgl_lahir = $this->transformDate($row[3]);
        $tgl_masuk = $this->transformDate($row[4]);
        $bulan = $this->transformDate($row[11]);

        return new Sht([
            'nomor_pegawai' => $row[1],
            'nama' => $row[2],
            'tgl_lahir' => $tgl_lahir,
            'tgl_masuk' => $tgl_masuk,
            'mkg' => $row[5],
            'gol' => $row[6],
            'jabatan' => $row[7],
            'jumlah_sht' => $row[8],
            'kebun' => $row[9],
            'jenis_pensiun' => $row[10],
            'bulan' => $bulan,
            'periode_pensiun' => $row[12],
            'keterangan' => $row[13],
            'no_spp' => $row[14],
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
