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
        <h1>{{ '2020' }}-{{ '08' }}</h1>
    </div>

    <table class="content mt-2 mb-2">
        <tr class="mt-2 mb-2">
            <th>Total yang Harus Dibayarkan</th>
            <td>Rp{{ number_format($grandTotal, 0, ',', '.') }}</td>
        </tr>
        <tr class="mt-2 mb-2">
            <th>Total yang Sudah Dibayarkan</th>
            <td>Rp{{ number_format($totalJumlahBayar, 0, ',', '.') }}</td>
        </tr>
        <tr class="mt-2 mb-2">
            <th>Total yang Belum Dibayarkan</th>
            <td>Rp{{ number_format($totalNilaiManfaat, 0, ',', '.') }}</td>
        </tr>
        <tr class="mt-2 mb-2">
            <th>Total yang Akan Dibayarkan</th>
            <td>Rp{{ number_format($totalNilaiManfaat - $totalJumlahBayar, 0, ',', '.') }}</td>
        </tr>
    </table>
    <div class="date">
        <br><br><br>
        <br><br>Bandung, {{ date('d F Y') }} <!-- Menampilkan tanggal saat ini -->
    </div>
</body>

</html>
