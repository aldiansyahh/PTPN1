<!DOCTYPE html>
<html>

<head>
    <title>Laporan PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .content th,
        .content td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            font-size: 18px;
            /* Ukuran teks 18px */
        }

        .content tr {
            margin-top: 5px;
            /* Margin atas */
        }

        .content td {
            text-align: right;
            font-size: 24px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .content {
            width: 100%;
            border-collapse: collapse;
        }

        .content th,
        .content td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .date {
            text-align: right;
            font-size: 12px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="header text-left">
        <h1>Laporan Pembayaran</h1>
        <h1>{{ $year }}&ensp;-&ensp; {{ $month }}</h1>
        <br><br>
        <h1>No SPP : {{ $no_spp }}</h1>

    </div>

    <table class="content mt-2 mb-2">
        <tr class="mt-2 mb-2">
            <th>Total yang Harus Dibayarkan</th>
            <td>Rp{{ number_format($totalNilaiManfaat, 0, ',', '.') }}</td>
        </tr>
        <tr class="mt-2 mb-2">
            <th>Total yang Sudah Dibayarkan</th>
            <td>Rp{{ number_format($totalLunasManfaat, 0, ',', '.') }}</td>
        </tr>
        <tr class="mt-2 mb-2">
            <th>Total yang Belum Dibayarkan</th>
            <td>Rp{{ number_format($totalRekonManfaat, 0, ',', '.') }}</td>
        </tr>

    </table>
    @if (!empty($rekapPerBulan) && count($rekapPerBulan) > 0)
        <table class="content">
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Sudah Dibayarkan</th>
                    <th>Belum Dibayarkan</th>
                    <th>Total yang Harus Dibayarkan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rekapPerBulan as $rekap)
                    <tr>
                        <td>{{ DateTime::createFromFormat('!m', $rekap->bulan)->format('F') }}</td>
                        <td>Rp{{ number_format($rekap->sudah_dibayar, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($rekap->belum_dibayar, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($rekap->total_yang_harus_dibayar, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tidak ada data untuk rincian bulanan.</p>
    @endif
    <div class="date">
        <br><br><br>
        <br><br>Bandung, {{ date('d F Y') }} <!-- Menampilkan tanggal saat ini -->
    </div>



</body>

</html>
