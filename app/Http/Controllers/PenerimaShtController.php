<?php

namespace App\Http\Controllers;

use App\Models\PenerimaSht;
use App\Imports\PenerimaShtImport;
use Illuminate\Http\Request;
use App\Models\SudahDibayar;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PenerimaShtExport;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controllers;
use App\Imports\PenerimaImport;
use App\Models\Sht;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;


class PenerimaShtController extends Controller
{


    public function penerimaSht(Request $request)
    {
        // Start with a base query
        $query = PenerimaSht::query();


        // Filter by 'status' if provided
        if ($request->has('status') && in_array($request->status, ['Lunas', 'Proses Rekon'])) {
            $query->where('keterangan', $request->status);
        }

        // Filter by year if provided
        if ($request->filled('year')) {
            $query->whereYear('bulan', $request->input('year'));
        }

        // Filter by month if provided
        if ($request->filled('month')) {
            $monthNumber = date('m', strtotime($request->input('month')));
            $query->whereMonth('bulan', $monthNumber);
        }

        // Apply search criteria if provided
        $search = $request->input('search');
        $criteria = $request->input('criteria');
        if ($search) {
            if ($criteria == 'nama_peserta') {
                $query->where('nama_peserta', 'like', '%' . $search . '%');
            } elseif ($criteria == 'nomor_pegawai') {
                $query->where('nomor_pegawai', 'like', '%' . $search . '%');
            } elseif ($criteria == 'no_peserta') {
                $query->where('no_peserta', 'like', '%' . $search . '%');
            } elseif ($criteria == 'no_peserta_lama') {
                $query->where('no_peserta_lama', 'like', '%' . $search . '%');
            } else {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_peserta', 'like', '%' . $search . '%')
                        ->orWhere('nomor_pegawai', 'like', '%' . $search . '%')
                        ->orWhere('no_peserta', 'like', '%' . $search . '%')
                        ->orWhere('no_peserta_lama', 'like', '%' . $search . '%');
                });
            }
        }


        // Sort by ID
        $query->orderBy('no_penerima_sht', 'desc');

        // Get 'perPage' value, defaulting to 10 if not provided
        $perPage = $request->input('perPage', 10);

        // Paginate the results
        $penerima_sht = $query->paginate($perPage)->appends($request->except('page'));



        // Return view with all relevant data
        return view('penerimaSht.penerimaSht', compact('penerima_sht',  'perPage'));
    }





    // PenerimaShtController.php
    public function penerimaShtexport()
    {
        return Excel::download(new PenerimaShtExport, 'penerima_sht.xlsx');
    }

    public function penerima_shtimportexcel(Request $request)
    {
        // Memastikan file diunggah
        $file = $request->file('file');
        $namaFile = $file->getClientOriginalName();

        // Memindahkan file ke folder Uploadpenerima_sht di dalam folder public
        $file->move(public_path('Uploadpenerima_sht'), $namaFile);

        try {
            Excel::import(new PenerimaImport, public_path('Uploadpenerima_sht/' . $namaFile));
            return redirect('/penerimasht')->with('success', 'Data berhasil diimpor!');
        } catch (\Exception $e) {
            // Menampilkan alert gagal
            return redirect('/penerimasht')->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }

    public function tambahpenerimaSht()
    {

        $nomorPegawai = PenerimaSht::pluck('nomor_pegawai', 'nomor_pegawai'); // Optional
        return view('penerimaSht.insertpenerimaSht', compact('nomorPegawai'));
    }


    public function insertpenerimaSht(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'nomor_pegawai' => 'required', // Add validation rules as needed
            'nama_peserta' => 'required',
        ]);

        // Insert data into the database
        PenerimaSht::create($request->all());

        // Redirect with success message
        return redirect()->route('penerimasht')->with('success', 'Data Berhasil Ditambahkan!');
    }



    protected function findpenerimaSht($no_penerima_sht)
    {
        return PenerimaSht::where('no_penerima_sht', $no_penerima_sht)->first();
    }


    public function penerimaShtDelete(Request $request, $no_penerima_sht)
    {
        // Temukan data berdasarkan no_penerima_sht
        $penerima_sht = $this->findpenerimaSht($no_penerima_sht);

        // Cek jika data tidak ditemukan
        if (!$penerima_sht) {
            return redirect()->route('penerima_sht')->with('error', 'Data tidak ditemukan!');
        }

        // Hapus data
        $penerima_sht->delete();

        // Redirect ke rute yang sesuai dengan pesan sukses
        return redirect()->route('penerimasht', ['search' => $request->input('search')])->with('delete', 'Data berhasil dihapus');
    }



    public function editpenerimasht($no_penerima_sht)
    {
        // Debugging: Melihat nilai no_penerima_sht yang diterima


        $penerima_sht = PenerimaSht::find($no_penerima_sht); // Ganti 'penerima_sht' dengan model Anda

        if (!$penerima_sht) {
            return redirect('/penerimasht')->with('error', 'penerima sht tidak ditemukan');
        }

        return view('penerimaSht.editpenerimaSht', compact('penerima_sht'));
    }
    public function edit($no_penerima_sht)
    {


        // Tampilkan view edit
        return view('penerimaSht.editpenerimaSht', compact('item'));
    }

    public function viewpenerimaSht($no_penerima_sht)
    {
        // Debugging: Melihat nilai no_penerima_sht yang diterima


        $penerima_sht = PenerimaSht::where('no_penerima_sht', $no_penerima_sht)->first();

        if (!$penerima_sht) {
            return redirect('/penerimaSht')->with('error', 'penerima sht tidak ditemukan');
        }

        return view('penerimaSht.viewpenerimaSht', compact('penerima_sht'));
    }


    public function updatepenerimasht(Request $request, $no_penerima_sht)
    {
        // Valno_penerima_shtasi data yang diterima
        $request->validate([
            'nomor_pegawai' => 'required',
            // Tambahkan valno_penerima_shtasi lainnya sesuai kebutuhan
        ]);

        // Cari penerima_sht berdasarkan no_penerima_sht
        $penerima_sht = PenerimaSht::find($no_penerima_sht);
        if (!$penerima_sht) {
            return redirect('/penerimasht')->with('error', 'penerima sht tidak ditemukan');
        }

        // Perbarui data penerima_sht
        $penerima_sht->update($request->all());

        return redirect('/penerimasht')->with('success', 'Data penerima sht berhasil diperbarui.');
    }
}
