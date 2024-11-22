<?php

namespace App\Exports;

use App\Models\Sht;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ShtExport implements FromCollection, WithHeadings
{
    /**
     * Mengambil koleksi data dari model Sht dan menambahkan nomor urut.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Mengambil semua data dari tabel Sht
        $data = Sht::select(
            'nomor_pegawai',
            'nama',
            'tgl_lahir',
            'tgl_masuk',
            'mkg',
            'gol',
            'jabatan',
            'jumlah_sht',
            'kebun',
            'jenis_pensiun',
            'bulan',
            'periode_pensiun',
            'keterangan',
            'no_spp'
        )->get();

        // Menambahkan nomor urut secara manual
        $dataWithNumbers = $data->map(function ($item, $index) {
            return [
                'no' => $index + 1, // Nomor urut dimulai dari 1
                'nomor_pegawai' => $item->nomor_pegawai,
                'nama' => $item->nama,
                'tgl_lahir' => $item->tgl_lahir,
                'tgl_masuk' => $item->tgl_masuk,
                'mkg' => $item->mkg,
                'gol' => $item->gol,
                'jabatan' => $item->jabatan,
                'jumlah_sht' => $item->jumlah_sht,
                'kebun' => $item->kebun,
                'jenis_pensiun' => $item->jenis_pensiun,
                'bulan' => $item->bulan,
                'periode_pensiun' => $item->periode_pensiun,
                'keterangan' => $item->keterangan,
                'no_spp' => $item->no_spp,
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
            "Nomor Pegawai",
            "Nama",
            "Tanggal Lahir",
            "Tanggal Masuk",
            "Masa Kerja (MKG)",
            "Golongan",
            "Jabatan",
            "Jumlah SHT",
            "Kebun",
            "Jenis Pensiun",
            "Bulan",
            "Periode Pensiun",
            "Keterangan",
            "No SPP"
        ];
    }
}
