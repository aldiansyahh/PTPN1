<?php

namespace App\Http\Controllers;

use App\Models\PenerimaSht;
use App\Models\RiwayatPenerima; // Import model RiwayatPenerima
use App\Models\Sht; // Import model Sht
use Illuminate\Http\Request;

class RiwayatPenerimaController extends Controller
{
    // Fungsi untuk menyimpan data lama ke riwayat dan kemudian update data di Sht
    public function riwayatSht(Request $request)
    {
        // Start with a base query
        $query = RiwayatPenerima::query();

        // Apply search criteria if provided
        $search = $request->input('search');
        $criteria = $request->input('criteria');
        if ($search) {
            if ($criteria == 'nama') {
                $query->where('nama', 'like', '%' . $search . '%');
            } elseif ($criteria == 'nomor_pegawai') {
                $query->where('nomor_pegawai', 'like', '%' . $search . '%');
            } elseif ($criteria == 'no_peserta') {
                $query->where('no_peserta', 'like', '%' . $search . '%');
            } elseif ($criteria == 'no_peserta_lama') {
                $query->where('no_peserta_lama', 'like', '%' . $search . '%');
            } elseif ($criteria == 'bulan') {
                $query->where('bulan', 'like', '%' . $search . '%');
            } else {
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('nomor_pegawai', 'like', '%' . $search . '%')
                        ->orWhere('bulan', 'like', '%' . $search . '%');
                });
            }
        }

        // Sort by ID
        $query->orderBy('no_riwayat_penerima', 'desc');

        // Get 'perPage' value, defaulting to 10 if not provided
        $perPage = $request->input('perPage', 10);

        // Paginate the results
        $riwayat_penerima = $query->paginate($perPage)->appends($request->except('page'));

        // Return view with all relevant data
        return view('penerimaSht.riwayat', compact('riwayat_penerima', 'perPage'));
    }
}
