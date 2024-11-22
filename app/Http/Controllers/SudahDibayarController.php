<?php

namespace App\Http\Controllers;

use App\Models\SudahDibayar; // Import model SudahDibayar
use App\Models\Sht; // Import model Sht
use Illuminate\Support\Facades\Log; // Import log system Laravel
use Illuminate\Http\Request;

class SudahDibayarController extends Controller
{
    // Method untuk menampilkan form upload data
    public function index()
    {
        return view('sudah_dibayar'); // Ganti dengan nama view yang sesuai
    }

    // Method untuk menangani upload data
    public function uploadData(Request $request)
    {
        // Log semua input yang diterima
        Log::info($request->all());

        // Validasi input dari request
        $request->validate([
            'search' => 'required|string',
            'criteria' => 'required|string',
        ]);

        // Ambil data berdasarkan kriteria dan search
        $data = Sht::where($request->criteria, 'LIKE', '%' . $request->search . '%')->get();
        // dd($data);

        // Periksa jika data ditemukan
        if ($data->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data yang ditemukan untuk dipindahkan.');
        }


        // Pindahkan data ke tabel sudah_dibayar
        foreach ($data as $item) {

            $array = array(
                'no_peserta' => $item->no_peserta,
                'nomor_pegawai' => $item->nomor_pegawai,
                'nama_peserta' => $item->nama_peserta,
                'jenis_kelamin' => $item->jenis_kelamin,
                'no_peserta_lama' => $item->no_peserta_lama,
                'kd_jenis_pensiun' => $item->kd_jenis_pensiun,
                'nama_jenis_pensiun' => $item->nama_jenis_pensiun,
                'nilai_manfaat_pensiun' => $item->nilai_manfaat_pensiun,
                'nama_bank' => $item->nama_bank,
                'no_rekening' => $item->no_rekening,
                'atas_nama' => $item->atas_nama
            );


            SudahDibayar::create($array);

            // Hapus data dari tabel sht setelah berhasil dipindahkan
        }

        Sht::where($request->criteria, 'LIKE', '%' . $request->search . '%')->delete();


        return redirect()->back()->with('success', 'Data berhasil dipindahkan.');
    }
}
