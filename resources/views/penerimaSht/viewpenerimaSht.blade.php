@extends('sht.master')

@section('content')
    <div>
        <div class="form-group mb-3">
            <h1 class="h3 text-black-1000">Data Peserta</h1>
        </div>

        @if (session('error'))
            <div class="alert alert-danger">
                <b>Opps!</b> {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('viewpenerimaSht', $penerima_sht->no_penerima_sht) }}" method="GET"
            enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="nomorPegawai" class="form-label">Nomor Pegawai</label>
                <input type="text" name="nomor_pegawai" class="form-control" id="nomorPegawai" required readonly
                    value="{{ old('nomor_pegawai', $penerima_sht->nomor_pegawai) }}">
            </div>

            <div class="mb-3">
                <label for="namaPeserta" class="form-label">Nama Peserta</label>
                <input type="text" name="nama_peserta" class="form-control" id="namaPeserta" required readonly
                    value="{{ old('nama_peserta', $penerima_sht->nama_peserta) }}">
            </div>

            <div class="mb-3">
                <label for="noPeserta" class="form-label">No Peserta</label>
                <input type="text" name="no_peserta" class="form-control" id="noPeserta" required readonly
                    value="{{ old('no_peserta', $penerima_sht->no_peserta) }}">
            </div>

            <div class="mb-3">
                <label for="jenisKelamin" class="form-label">Jenis Kelamin</label>
                <input type="text" name="jenis_kelamin" class="form-control" id="jenisKelamin" required readonly
                    value="{{ old('jenis_kelamin', $penerima_sht->jenis_kelamin) }}">
            </div>

            <div class="mb-3">
                <label for="noPesertaLama" class="form-label">No Peserta Lama</label>
                <input type="text" name="no_peserta_lama" class="form-control" id="noPesertaLama" required readonly
                    value="{{ old('no_peserta_lama', $penerima_sht->no_peserta_lama) }}">
            </div>

            <div class="mb-3">
                <label for="kdJenisPensiun" class="form-label">Kode Jenis Pensiun</label>
                <input type="text" name="kd_jenis_pensiun" class="form-control" id="kdJenisPensiun" required readonly
                    value="{{ old('kd_jenis_pensiun', $penerima_sht->kd_jenis_pensiun) }}">
            </div>

            {{-- <div class="mb-3">
                @if ($jenis_pensiun)
    <input type="text" name="nama_jenis_pensiun" class="form-control" id="namaJenisPensiun" required readonly
        value="{{ old('nama_jenis_pensiun', $jenis_pensiun->nama_jenis_pensiun) }}">
@else
    <input type="text" name="nama_jenis_pensiun" class="form-control" id="namaJenisPensiun" required readonly
        value="Tidak ada data">
@endif

            </div> --}}

            <div class="mb-3">
                <label for="nilaiManfaatPensiun" class="form-label">Nilai Manfaat Pensiun</label>
                <input type="text" name="nilai_manfaat_pensiun" class="form-control" id="nilaiManfaatPensiun" required
                    readonly value="{{ old('nilai_manfaat_pensiun', $penerima_sht->nilai_manfaat_pensiun) }}">
            </div>

            <div class="mb-3">
                <label for="namaBank" class="form-label">Nama Bank</label>
                <input type="text" name="nama_bank" class="form-control" id="namaBank" required readonly
                    value="{{ old('nama_bank', $penerima_sht->nama_bank) }}">
            </div>

            <div class="mb-3">
                <label for="noRekening" class="form-label">No Rekening</label>
                <input type="text" name="no_rekening" class="form-control" id="noRekening" required readonly
                    value="{{ old('no_rekening', $penerima_sht->no_rekening) }}">
            </div>

            <div class="mb-3">
                <label for="atasNama" class="form-label">Atas Nama</label>
                <input type="text" name="atas_nama" class="form-control" id="atasNama" required readonly
                    value="{{ old('atas_nama', $penerima_sht->atas_nama) }}">
            </div>

            <a href="/penerimasht" class="btn btn-secondary">Back</a>
        </form>
    </div><br>
@endsection

<!-- Optional JavaScript; choose one of the two! -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="js/demo/chart-area-demo.js"></script>
<script src="js/demo/chart-pie-demo.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Popper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!-- Bootstrap 4 JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<!-- Bootstrap 4 CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<script src="http://localhost:8080/js/app.js"></script>
