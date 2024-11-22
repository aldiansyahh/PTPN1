<?php

namespace App\Exports;

use App\Models\PenerimaSht;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PenerimaShtExport implements FromCollection, WithHeadings
{
    /**
     * Mengambil koleksi data dari model Sht dan menambahkan nomor urut.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Mengambil semua data dari tabel Sht dengan relasi ke jenis_pensiun
        $data = PenerimaSht::with('jenisPensiun')  // Eager loading relasi ke jenis_pensiun
            ->select(
                'no_peserta',
                'nama_peserta',
                'jenis_kelamin',
                'no_peserta_lama',
                'kd_jenis_pensiun',
                'nilai_manfaat_pensiun',
                'nama_bank',
                'no_rekening',
                'atas_nama'
            )->get();

        // Menambahkan nomor urut secara manual dan mengambil nama_jenis_pensiun
        $dataWithNumbers = $data->map(function ($item, $index) {
            return [
                'no' => $index + 1,  // Nomor urut dimulai dari 1
                'no_peserta' => $item->no_peserta,
                'nama_peserta' => $item->nama_peserta,
                'jenis_kelamin' => $item->jenis_kelamin,
                'no_peserta_lama' => $item->no_peserta_lama,
                'kd_jenis_pensiun' => $item->kd_jenis_pensiun,
                'nama_jenis_pensiun' => $item->jenisPensiun->nama_jenis_pensiun ?? '-',  // Mengambil nama_jenis_pensiun dari relasi
                'nilai_manfaat_pensiun' => $item->nilai_manfaat_pensiun,
                'nama_bank' => $item->nama_bank,
                'no_rekening' => $item->no_rekening,
                'atas_nama' => $item->atas_nama
            ];
        });

        return $dataWithNumbers;
    }

    /**
     * Mendefinisikan header untuk file Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            "No",  // Header untuk nomor urut
            "No Peserta",
            "Nama Peserta",
            "Jenis Kelamin",
            "No Peserta Lama",
            "Kode Jenis Pensiun",
            "Nama Jenis Pensiun",
            "Nilai Manfaat Pensiun",
            "Nama Bank",
            "No Rekening",
            "Atas Nama"
        ];
    }
}
