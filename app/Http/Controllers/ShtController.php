<?php

namespace App\Http\Controllers;

use App\Models\Sht;
use App\Imports\ShtImport;
use Illuminate\Http\Request;
use App\Models\SudahDibayar;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ShtExport;
use DateTime;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controllers;
use App\Models\PenerimaSht;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;


class ShtController extends Controller
{


    public function sht(Request $request)
    {
        // Start with a base query
        $query = Sht::query();


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
            if ($criteria == 'nama') {
                $query->where('nama', 'like', '%' . $search . '%');
            } elseif ($criteria == 'nomor_pegawai') {
                $query->where('nomor_pegawai', 'like', '%' . $search . '%');
            } elseif ($criteria == 'jenis_pensiun') {
                $query->where('jenis_pensiun', 'like', '%' . $search . '%');
            } elseif ($criteria == 'bulan') {
                $query->where('bulan', 'like', '%' . $search . '%');
            } else {
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('nomor_pegawai', 'like', '%' . $search . '%')
                        ->orWhere('bulan', 'like', '%' . $search . '%')
                        ->orWhere('jenis_pensiun', 'like', '%' . $search . '%');
                });
            }
        }
        if ($criteria === 'status_lunas') {
            $query->where('keterangan', 'Lunas');
        } elseif ($criteria === 'status_rekon') {
            $query->where('keterangan', 'Proses Rekon');
        } elseif ($criteria) {
            $query->where($criteria, 'like', "%{$search}%");
        }

        // Get distinct years and months
        $years = Sht::selectRaw('YEAR(bulan) as year')
            ->distinct()
            ->pluck('year')
            ->sort();

        $months = Sht::selectRaw('MONTH(bulan) as month')
            ->distinct()
            ->pluck('month')
            ->map(function ($month) {
                return DateTime::createFromFormat('!m', $month)->format('F');
            })
            ->sort();


        // Sort by ID
        $query->orderBy('id', 'desc');

        // Get 'perPage' value, defaulting to 10 if not provided
        $perPage = $request->input('perPage', 10);

        // Paginate the results
        $sht = $query->paginate($perPage)->appends($request->except('page'));
        // Total values
        $totalLunasManfaat = Sht::where('keterangan', 'Lunas')->sum('jumlah_sht');
        $totalRekonManfaat = Sht::where('keterangan', 'Proses Rekon')->sum('jumlah_sht');
        $totalNilaiManfaat = Sht::sum('jumlah_sht');

        // Rekap per tahun
        $rekapPerTahun = Sht::selectRaw("
            YEAR(bulan) as tahun,
            SUM(CASE WHEN keterangan = 'Lunas' THEN jumlah_sht ELSE 0 END) as sudah_dibayar,
            SUM(CASE WHEN keterangan != 'Lunas' THEN jumlah_sht ELSE 0 END) as belum_dibayar,
            SUM(jumlah_sht) as total_yang_harus_dibayar
        ")
            ->groupByRaw("YEAR(bulan)")
            ->orderByRaw("YEAR(bulan)")
            ->get();

        $rekapPerBulan = [];
        if ($years && !$months) {
            $rekapPerBulan = Sht::selectRaw("
        MONTH(bulan) as bulan,
        SUM(CASE WHEN keterangan = 'Lunas' THEN nilai_manfaat_pensiun ELSE 0 END) as sudah_dibayar,
        SUM(CASE WHEN keterangan != 'Lunas' THEN nilai_manfaat_pensiun ELSE 0 END) as belum_dibayar,
        SUM(nilai_manfaat_pensiun) as total_yang_harus_dibayar
    ")
                ->whereYear('bulan', $years)
                ->groupByRaw("MONTH(bulan)")
                ->orderByRaw("MONTH(bulan)")
                ->get();
        }




        // Return view with all relevant data
        return view('sht.sht', compact('sht', 'totalNilaiManfaat', 'rekapPerTahun', 'totalLunasManfaat', 'totalRekonManfaat', 'rekapPerBulan', 'years', 'months', 'perPage'));
    }



    public function updateData(Request $request)
    {
        // Validasi jika perlu
        $validated = $request->validate([
            'status' => 'required|in:Proses Rekon,Lunas',
            'no_spp' => 'required|string|max:255', // Validasi input no_spp
        ]);

        // Ambil filter data berdasarkan tahun dan bulan
        $query = Sht::query();

        // Filter berdasarkan tahun jika ada
        if ($request->has('year') && $request->year) {
            $query->whereYear('bulan', $request->year);
        }

        // Mengonversi bulan menjadi angka (misalnya "April" menjadi 4)
        if ($request->has('month') && $request->month) {
            $months = [
                'January' => 1,
                'February' => 2,
                'March' => 3,
                'April' => 4,
                'May' => 5,
                'June' => 6,
                'July' => 7,
                'August' => 8,
                'September' => 9,
                'October' => 10,
                'November' => 11,
                'December' => 12,
            ];

            $monthNumber = $months[$request->month] ?? null;

            if ($monthNumber) {
                $query->whereMonth('bulan', $monthNumber);
            }
        }

        // Perbarui status berdasarkan kondisi dan simpan no_spp
        $updatedRows = $query->update([
            'keterangan' => $request->status,
            'no_spp' => $request->no_spp, // Menyimpan input no_spp ke dalam tabel
        ]);

        // Cek apakah ada data yang berhasil diperbarui
        if ($updatedRows > 0) {
            return redirect()->route('sht')
                ->with('status', 'Status berhasil diperbarui menjadi ' . $request->status);
        } else {
            return redirect()->route('sht')
                ->with('status', 'Tidak ada data yang diperbarui.');
        }
    }













    public function generatePdf(Request $request)
    {
        $year = $request->get('year');
        $month = $request->get('month');
        $status = $request->get('status');
        $search = $request->input('search');
        $criteria = $request->input('criteria');

        // Membuat query Sht
        $query = Sht::query();

        // Filter berdasarkan tahun
        if ($year) {
            $query->whereYear('bulan', $year);
        }

        // Filter berdasarkan bulan
        if ($month) {
            $monthNumber = date('m', strtotime($month));
            $query->whereMonth('bulan', $monthNumber);
        }

        // Filter berdasarkan status
        if (in_array($status, ['Lunas', 'Proses Rekon'])) {
            $query->where('keterangan', $status);
        }

        // Filter pencarian
        if ($search) {
            if ($criteria == 'nama') {
                $query->where('nama', 'like', '%' . $search . '%');
            } elseif ($criteria == 'nomor_pegawai') {
                $query->where('nomor_pegawai', 'like', '%' . $search . '%');
            } else {
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%')
                        ->orWhere('nomor_pegawai', 'like', '%' . $search . '%')
                        ->orWhere('bulan', 'like', '%' . $search . '%');
                });
            }
        }

        // Mengambil data yang sesuai dengan filter
        $shtData = $query->first(); // Ambil data pertama, untuk no_spp dan detail lainnya

        // Periksa apakah no_spp ada atau tidak
        $no_spp = $shtData && $shtData->no_spp ? $shtData->no_spp : 'Belum Dibuat';

        // Menghitung total dari kedua tabel sesuai dengan filter yang diterapkan
        $totalNilaiManfaat = Sht::whereYear('bulan', $year)
            ->when($month, fn($q) => $q->whereMonth('bulan', $monthNumber))
            ->sum('jumlah_sht');

        $totalLunasManfaat = Sht::where('keterangan', 'Lunas')
            ->whereYear('bulan', $year)
            ->when($month, fn($q) => $q->whereMonth('bulan', $monthNumber))
            ->sum('jumlah_sht');

        $totalRekonManfaat = Sht::where('keterangan', 'Proses Rekon')
            ->whereYear('bulan', $year)
            ->when($month, fn($q) => $q->whereMonth('bulan', $monthNumber))
            ->sum('jumlah_sht');

        // Data untuk PDF
        $data = [
            'totalNilaiManfaat' => $totalNilaiManfaat,
            'totalLunasManfaat' => $totalLunasManfaat,
            'totalRekonManfaat' => $totalRekonManfaat,
            'year' => $year,
            'month' => $month,
            'no_spp' => $no_spp, // Menambahkan no_spp
        ];

        // Generate PDF menggunakan view dan data
        $pdf = Pdf::loadView('Sht.pdf_file', $data);

        // Mendownload file PDF
        return $pdf->download('laporan_pembayaran.pdf');
    }





    public function uploadAndGeneratePdf(Request $request)
    {
        // 1. Proses upload (memindahkan data ke tabel `sudah_dibayar`)
        $this->uploadData($request);

        // 2. Cetak PDF setelah upload
        return $this->cetakPdf($request);
    }

    public function shtexport()
    {

        return Excel::download(new ShtExport, 'sht.xlsx');
    }


    public function shtimportexcel(Request $request)
    {
        // Memastikan file diunggah
        $file = $request->file('file');

        // Jika file tidak ada, kirimkan pesan error
        if (!$file) {
            return redirect()->back()->with('error', 'File tidak ditemukan. Harap unggah file.');
        }

        $namaFile = $file->getClientOriginalName();

        // Memindahkan file ke folder UploadSht di dalam folder public
        $file->move(public_path('UploadSht'), $namaFile);

        try {
            // Mengimpor data dari file Excel
            Excel::import(new ShtImport, public_path('UploadSht/' . $namaFile));

            // Menampilkan alert sukses
            return redirect('/sht')->with('success', 'Data berhasil diimpor!');
        } catch (\Exception $e) {
            // Menampilkan alert gagal
            return redirect('/sht')->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }

    public function tambahsht()
    {
        return view('sht.insertsht');
    }

    public function showProses(Request $request)
    {
        $sht = Sht::where('keterangan', 'Proses Rekon')->paginate(10);

        return view('sht.sht', compact('sht'));
    }

    public function showLunas(Request $request)
    {
        // Menginisialisasi query untuk mengambil data "Lunas"
        $query = Sht::where('keterangan', 'Lunas');

        // Menambahkan filter pencarian jika ada
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('nama_peserta', 'LIKE', "%{$search}%")
                ->orWhere('nomor_pegawai', 'LIKE', "%{$search}%");
        }

        // Mengurutkan data berdasarkan ID secara menurun
        $query->orderBy('id', 'desc');

        // Mendapatkan semua data
        $allData = $query->get();

        // Setup pagination
        $perPage = 2000;
        $currentPage = $request->input('page', 1);
        $currentPageItems = $allData->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $sht = new LengthAwarePaginator($currentPageItems, $allData->count(), $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        // Menghitung total dari tabel
        $totalNilaiManfaat = Sht::where('keterangan', 'Lunas')->sum('jumlah_sht'); // Hanya menghitung nilai dari "Lunas"
        $totalJumlahBayar =  Sht::where('keterangan', 'Proses Rekon')->sum('jumlah_sht');
        $grandTotal = $totalNilaiManfaat + $totalJumlahBayar;

        // Mengembalikan view dengan data "Lunas"
        return view('sht.shtlunas', compact('sht', 'totalNilaiManfaat', 'totalJumlahBayar', 'grandTotal'));
    }



    public function insertsht(request $request)
    {
        Sht::create($request->all());
        return redirect()->route('sht')->with('success', 'Data Berhasil Ditambahkan!');
    }


    private function findSht($id)
    {
        return Sht::where('id', $id)->first();
    }
    public function noloop()
    {
        $sht = Sht::paginate(10); // Misalkan 10 item per halaman
        return view('your_view_name', compact('sht'));
    }

    public function shtDelete(Request $request, $id)
    {
        $sht = $this->findSht($id);

        if (!$sht) {
            return redirect()->route('sht')->with('error', 'Data tidak ditemukan!');
        }

        $sht->delete();
        return redirect()->route('sht', ['search' => $request->input('search')])->with('delete', 'Data berhasil dihapus');
    }




    public function viewSht($id)
    {
        // Debugging: Melihat nilai ID yang diterima


        $sht = Sht::find($id); // Ganti 'sht' dengan model Anda

        if (!$sht) {
            return redirect('/sht')->with('error', 'sht tidak ditemukan');
        }

        return view('sht.viewSht', compact('sht'));
    }


    public function editSht($id)
    {
        // Debugging: Melihat nilai ID yang diterima


        $sht = Sht::find($id); // Ganti 'sht' dengan model Anda

        if (!$sht) {
            return redirect('/sht')->with('error', 'sht tidak ditemukan');
        }

        return view('sht.editSht', compact('sht'))->with('error', 'sht gagal diubah!');
    }

    public function updatesht(Request $request, $id)
    {
        // Validasi data yang diterima
        $request->validate([
            'nomor_pegawai' => 'required',

        ]);

        // Cari sht berdasarkan ID
        $sht = Sht::find($id);
        if (!$sht) {
            return redirect('/sht')->with('error', 'sht tidak ditemukan');
        }
        // Perbarui data sht
        $sht->update($request->all());

        return redirect('/sht')->with('success', 'Data sht berhasil diperbarui.');
    }
}
