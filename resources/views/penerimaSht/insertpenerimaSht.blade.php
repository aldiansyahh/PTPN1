<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Tambah Penerima Sht</title>
</head>

<body>

    @extends('sht.master') <!-- Jika Anda menggunakan layout -->

    @section('content')
        <div class="form-group mb-3">

        </div>
        <div class="card-body">
            <a href="{{ asset('assets/templates/penerima_sht.xlsx') }}" class="modal-title btn btn-success mb-1"
                id="exampleModalLabel" download>Download Template</a>

            <form method="post" action="{{ route('importpenerimaSht') }}" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">

                    </div>
                    <div class="modal-body">

                        {{ csrf_field() }}

                        <label></label>
                        <div class="form-group">
                            <input type="file" name="file"="">
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="btn btn-success">Import</button>
                    </div>

                </div>
            </form>
            <br><br>

            <form action="{{ route('insertpenerimaSht') }}" method="POST" enctype="multipart/form-data" id="dataForm">


                @csrf
                <div class="form-group mb-3">
                    <label for="nomorPegawai" class="form-label">No Register </label>
                    <input type="text" name="nomor_pegawai" class="form-control" id="nomorPegawai">
                </div>


                <div class="form-group mb-3">
                    <label for="namaPeserta" class="form-label">Nama Peserta</label>
                    <input type="text" name="nama_peserta" class="form-control" id="namaPeserta">
                </div>

                <div class="form-group mb-3">
                    <label for="noPeserta" class="form-label">No Peserta</label>
                    <input type="text" name="no_peserta" class="form-control" id="noPeserta">
                </div>

                <div class="form-group mb-3">
                    <label for="jenisKelamin" class="form-label">Jenis Kelamin</label>
                    <input type="text" name="jenis_kelamin" class="form-control" id="jenisKelamin">
                </div>

                <div class="form-group mb-3">
                    <label for="noPesertaLama" class="form-label">No Peserta Lama</label>
                    <input type="text" name="no_peserta_lama" class="form-control" id="noPesertaLama">
                </div>

                <div class="form-group mb-3">
                    <label for="kdJenisPensiun" class="form-label">Kode Jenis Pensiun</label>
                    <select name="kd_jenis_pensiun" class="form-control" id="kdJenisPensiun">
                        <option value="">Pilih Jenis Pensiun</option>
                        <option value="01">01 (Pensiun Normal)</option>
                        <option value="02">02 (Pensiun Dipercepat)</option>
                        <option value="06">06 (Pensiun Janda/Duda)</option>
                        <option value="07">07 (Pensiun Anak)</option>
                        <option value="08">08 (Pensiun Sekaligus)</option>
                        <option value="09">09 (Pensiun Dipercepat)</option>
                        <option value="11">11 (Pensiun Janda/Duda)</option>
                        <option value="12">12 (Pensiun Janda/Duda)</option>
                        <option value="13">13 (Pensiun Janda/Duda)</option>
                        <option value="14">14 (Pensiun Janda/Duda)</option>
                        <option value="19">19 (Pensiun Janda/Duda)</option>
                        <option value="21">21 (Pensiun Anak)</option>
                        <option value="22">22 (Pensiun Anak)</option>
                        <option value="26">26 (Pensiun Anak)</option>
                        <option value="31">31 (Pensiun Anak)</option>
                        <option value="32">32 (Pensiun Anak)</option>
                        <option value="36">36 (Pensiun Anak)</option>
                        <option value="46">46 (Pensiun Janda/Duda)</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="nilaiManfaatPensiun" class="form-label">Nilai Manfaat Pensiun</label>
                    <input type="text" name="nilai_manfaat_pensiun" class="form-control" id="nilaiManfaatPensiun">
                </div>

                <div class="form-group mb-3">
                    <label for="namaBank" class="form-label">Nama Bank</label>
                    <input type="text" name="nama_bank" class="form-control" id="namaBank">
                </div>

                <div class="form-group mb-3">
                    <label for="noRekening" class="form-label">No Rekening</label>
                    <input type="text" name="no_rekening" class="form-control" id="noRekening">
                </div>

                <div class="form-group mb-3">
                    <label for="atasNama" class="form-label">Atas Nama</label>
                    <input type="text" name="atas_nama" class="form-control" id="atasNama">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="penerimaSht" type="submit" class="btn btn-secondary">Cancel</a>
            </form>
            <br>
        </div>
    @endsection
    </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
