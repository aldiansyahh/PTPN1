<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Tambah SHT</title>
</head>

<body>

    @extends('sht.master') <!-- Menggunakan layout master -->

    @section('content')
        <div class="card-body">
            <!-- Tombol untuk download template -->
            <a href="{{ asset('assets/templates/sht.xlsx') }}" class="modal-title btn btn-success mb-1" id="exampleModalLabel"
                download>Download Template</a>

            <!-- Form untuk upload file -->
            <form method="post" action="{{ route('importsht') }}" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="file" name="file" required="required" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Import</button>
                    </div>
                </div>
            </form>

            <br><br>

            <!-- Form untuk memasukkan data secara manual -->
            <form action="{{ route('insertsht') }}" method="POST" enctype="multipart/form-data" id="dataForm">
                @csrf
                <div class="form-group mb-3">
                    <label for="noPegawai" class="form-label">No Register</label>
                    <input type="text" name="nomor_pegawai" class="form-control" id="noPegawai" required>
                </div>

                <div class="form-group mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" id="nama" required>
                </div>

                <div class="form-group mb-3">
                    <label for="tanggalLahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir" class="form-control" id="tanggalLahir" required>
                </div>

                <div class="form-group mb-3">
                    <label for="tanggalMasuk" class="form-label">Tanggal Masuk</label>
                    <input type="date" name="tgl_masuk" class="form-control" id="tanggalMasuk" required>
                </div>

                <div class="form-group mb-3">
                    <label for="mkg" class="form-label">MKG</label>
                    <input type="text" name="mkg" class="form-control" id="mkg" required>
                </div>

                <div class="form-group mb-3">
                    <label for="golongan" class="form-label">Golongan</label>
                    <input type="text" name="gol" class="form-control" id="golongan" required>
                </div>

                <div class="form-group mb-3">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control" id="jabatan" required>
                </div>

                <div class="form-group mb-3">
                    <label for="jumlahSht" class="form-label">Jumlah SHT</label>
                    <input type="number" name="jumlah_sht" class="form-control" id="jumlahSht" required>
                </div>

                <div class="form-group mb-3">
                    <label for="kebun" class="form-label">Kebun</label>
                    <input type="text" name="kebun" class="form-control" id="kebun" required>
                </div>

                <div class="form-group mb-3">
                    <label for="jenisPensiun" class="form-label">Jenis Pensiun</label>
                    <select name="jenis_pensiun" class="form-control" id="jenisPensiun" required>

                        <option value="">Pilih Jenis Pensiun</option>
                        <option value="Normal">Normal</option>
                        <option value="Non Normal">Non Normal</option>

                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="bulan" class="form-label">Tanggal Pensiun</label>
                    <input type="date" name="bulan" class="form-control" id="bulan" required>
                </div>

                <div class="form-group mb-3">
                    <label for="periodePensiun" class="form-label">Periode Pensiun</label>
                    <input type="text" name="periode_pensiun" class="form-control" id="periodePensiun" required>
                </div>

                <div class="form-group mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <select name="keterangan" class="form-control" id="jenisPensiun" required>

                        <option value="">Pilih Keterangan bayar</option>
                        <option value="Proses Rekon">Proses Rekon</option>
                        <option value="Lunas">Lunas</option>

                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('sht') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    @endsection

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
