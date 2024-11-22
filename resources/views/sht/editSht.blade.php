<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit SHT</title>
</head>

<body>
    @extends('sht.master') <!-- Menggunakan layout master -->

    @section('content')
        <div class="card-body">
            <h4>Edit Data SHT</h4>

            <!-- Form untuk mengedit data -->
            <form action="{{ route('updatesht', $sht->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="noPegawai" class="form-label">No Register</label>
                    <input type="text" name="nomor_pegawai" class="form-control" id="noPegawai"
                        value="{{ old('nomor_pegawai', $sht->nomor_pegawai) }}">
                </div>

                <div class="form-group mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" id="nama"
                        value="{{ old('nama', $sht->nama) }}">
                </div>

                <div class="form-group mb-3">
                    <label for="tanggalLahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir" class="form-control" id="tanggalLahir"
                        value="{{ old('tgl_lahir', $sht->tgl_lahir) }}">
                </div>

                <div class="form-group mb-3">
                    <label for="tanggalMasuk" class="form-label">Tanggal Masuk</label>
                    <input type="date" name="tgl_masuk" class="form-control" id="tanggalMasuk"
                        value="{{ old('tgl_masuk', $sht->tgl_masuk) }}">
                </div>

                <div class="form-group mb-3">
                    <label for="mkg" class="form-label">MKG</label>
                    <input type="text" name="mkg" class="form-control" id="mkg"
                        value="{{ old('mkg', $sht->mkg) }}">
                </div>

                <div class="form-group mb-3">
                    <label for="golongan" class="form-label">Golongan</label>
                    <input type="text" name="gol" class="form-control" id="golongan"
                        value="{{ old('gol', $sht->gol) }}">
                </div>

                <div class="form-group mb-3">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control" id="jabatan"
                        value="{{ old('jabatan', $sht->jabatan) }}">
                </div>

                <div class="form-group mb-3">
                    <label for="jumlahSht" class="form-label">Jumlah SHT</label>
                    <input type="number" name="jumlah_sht" class="form-control" id="jumlahSht"
                        value="{{ old('jumlah_sht', $sht->jumlah_sht) }}">
                </div>

                <div class="form-group mb-3">
                    <label for="kebun" class="form-label">Kebun</label>
                    <input type="text" name="kebun" class="form-control" id="kebun"
                        value="{{ old('kebun', $sht->kebun) }}">
                </div>

                <div class="form-group mb-3">
                    <label for="jenisPensiun" class="form-label">Jenis Pensiun</label>
                    <select name="jenis_pensiun" class="form-control" id="jenisPensiun">
                        <option value="">Pilih Jenis Pensiun</option>
                        <option value="Normal"
                            {{ old('jenis_pensiun', $sht->jenis_pensiun) == 'Normal' ? 'selected' : '' }}>Normal</option>
                        <option value="Non Normal"
                            {{ old('jenis_pensiun', $sht->jenis_pensiun) == 'Non Normal' ? 'selected' : '' }}>Non Normal
                        </option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="bulan" class="form-label">Tanggal Pensiun</label>
                    <input type="date" name="bulan" class="form-control" id="bulan"
                        value="{{ old('bulan', $sht->bulan) }}">
                </div>

                <div class="form-group mb-3">
                    <label for="periodePensiun" class="form-label">Periode Pensiun</label>
                    <input type="text" name="periode_pensiun" class="form-control" id="periodePensiun"
                        value="{{ old('periode_pensiun', $sht->periode_pensiun) }}">
                </div>

                <div class="form-group mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <select name="keterangan" class="form-control" id="keterangan">
                        <option value="">Pilih Keterangan Bayar</option>
                        <option value="Proses Rekon"
                            {{ old('keterangan', $sht->keterangan) == 'Proses Rekon' ? 'selected' : '' }}>Proses Rekon
                        </option>
                        <option value="Lunas" {{ old('keterangan', $sht->keterangan) == 'Lunas' ? 'selected' : '' }}>
                            Lunas</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('sht') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    @endsection

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
