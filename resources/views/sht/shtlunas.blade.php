    @extends('sht.master')


    @section('content')
        <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">

        <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <!-- Modal Alert -->
        <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="alertModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="alertModalBody"></div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>


        <nav aria-label="breadcrumb bg-none">
            <ol class="breadcrumb bg-transparent">
                <li class="breadcrumb-item"><a href="{{ route('sht') }}" class="text-decoration-none">Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">SHT</li>
            </ol>
        </nav>
        <div class="w-min">
            <div class="card-header">
                <div class="container-fluid flex d-flex flex-column justify-content-center">
                    <div class="d-flex flex justify-content-center mt-2 ">
                        <form method="GET" action="{{ route('sht') }}" class="d-flex btn">
                            <select name="year" class="form-select" aria-label="Pilih Tahun" required
                                style="height: 35px; width:110px; padding: 5px;">
                                <option value="">Pilih Tahun</option>
                                {{-- @foreach ($years as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach --}}
                            </select>

                            <select name="month" class="form-select mx-2" aria-label="Pilih Bulan"
                                style="height: 35px; width:110px; padding: 5px;">
                                <option value="">Pilih Bulan</option>
                                {{-- @foreach ($months as $month)
                <option value="{{ $month }}">{{ $month }}</option>
            @endforeach --}}
                            </select>
                        </form>
                    </div>
                    <div
                        class="d-flex flex flex-column justify-content-center border border-dark col-max mb-3 rounded shadow mt-2 ">
                        <!-- Total yang Harus dibayarkan -->
                        <div class="d-flex flex-row justify-content-between w-100 border-bottom border-dark">
                            <p class="mt-4 mb-1 ml-2 text-gray-600 font-weight-bold">
                                Total yang harus dibayarkan
                            </p>
                            <p class="mt-4 mb-1 mr-2 font-weight-bold">
                                Rp{{ number_format($grandTotal, 0, ',', '.') }}
                            </p>
                        </div>
                        <!-- Total yang Sudah dibayarkan -->
                        <div class="d-flex flex-row justify-content-between w-100 border-bottom border-dark">
                            <p class="mt-4 mb-1 ml-2 text-gray-600 font-weight-bold">
                                Total yang belum dibayarkan
                            </p>
                            <p class="mt-4 mb-1 mr-2 font-weight-bold">
                                Rp{{ number_format($totalJumlahBayar, 0, ',', '.') }}
                            </p>
                        </div>
                        <!-- Total yang Belum dibayarkan -->
                        <div class="d-flex flex-row justify-content-between w-100 border-bottom border-dark mb-4">
                            <p class="mt-4 mb-1 ml-2 text-gray-600 font-weight-bold">
                                Total yang sudah dibayarkan
                            </p>
                            <p class="mt-4 mb-1 mr-2 font-weight-bold">
                                Rp{{ number_format($totalNilaiManfaat, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <div class="d-flex flex-row justify-content-between mt-3">
                        <form method="POST" action="{{ route('uploadData') }}">
                            @csrf
                            <input type="hidden" name="criteria" value="{{ request()->get('criteria') }}">
                            <input type="hidden" name="search" value="{{ request()->get('search') }}">
                            <input type="hidden" name="year" value="{{ request()->get('year') }}">
                            <input type="hidden" name="month" value="{{ request()->get('month') }}">
                            <div class="mr-1">
                                <button class="btn btn-success pr-5 pl-5" type="submit"
                                    onclick="return confirm('Klik Oke untuk memindahkan data ke Sudah Dibayar?')">Cancel
                                    Upload
                                    <i class="fas 	fas fa-upload"></i></button>
                            </div>
                        </form>
                        <form method="GET" action="{{ route('cetakPdf') }}">
                            <input type="hidden" name="year" value="{{ request()->get('year') }}">
                            <input type="hidden" name="month" value="{{ request()->get('month') }}">
                            <div class="ml-1">
                                <button class="btn btn-success pr-5 pl-5" type="submit">Cetak <i
                                        class="fas fa-file-pdf"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body shadow mt-3 mb-4">
            <div class="d-flex justify-content-between mt-3 mb-4">
                <div class="d-flex flex-row">
                    <a href="/insertSht" class="btn btn-success" style=" margin-top: -13px;">Tambah
                        <i class="fas fa-plus-square"></i></a>

                </div>

                <div class="d-flex flex-row">
                    <a href="{{ route('exportsht') }}" class="btn btn-success" style=" margin-top: -13px;">Unduh
                        <i class="fas fa-file-excel"></i> </a>
                </div>
            </div>
            <table class="table table-bordered table-responsive h-4" id="myTable">
                <thead>
                    <tr>
                        <th class="center">No</th>
                        <th class="center">No Register</th>
                        <th class="center">Nama</th>
                        <th class="center">Tanggal Lahir</th>
                        <th class="center">Tanggal Masuk</th>
                        <th class="center">MKG</th>
                        <th class="center">Golongan</th>
                        <th class="center">Jabatan</th>
                        <th class="center">Jumlah SHT</th>
                        <th class="center">Kebun</th>
                        <th class="center">Jenis Pensiun</th>
                        <th class="center">Bulan</th>
                        <th class="center">Periode Pensiun</th>
                        <th class="center">Keterangan</th>
                        <th class="center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($sht->count() > 0)
                        @foreach ($sht as $item)
                            @if ($item->keterangan == 'Lunas')
                                <tr>
                                    <td>{{ $loop->iteration + ($sht->currentPage() - 1) * $sht->perPage() }}</td>
                                    <td>{{ $item->nomor_pegawai }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->tgl_lahir }}</td>
                                    <td>{{ $item->tgl_masuk }}</td>
                                    <td>{{ $item->mkg }}</td>
                                    <td>{{ $item->gol }}</td>
                                    <td>{{ $item->jabatan }}</td>
                                    <td>{{ $item->jumlah_sht }}</td>
                                    <td>{{ $item->kebun }}</td>
                                    <td>{{ $item->jenis_pensiun }}</td>
                                    <td>{{ $item->bulan }}</td>
                                    <td>{{ $item->periode_pensiun }}</td>
                                    <td>{{ $item->keterangan }}</td>
                                    <td>
                                        <div class="d-flex flex-row justify-content-start">
                                            <a href="{{ route('editSht', $item->id) }}"
                                                class="btn btn-success mt-1 mb-1 mr-1" style="margin-right:30px;"><i
                                                    class="fas fa-pen"></i></a>
                                            <a href="/shtDelete/{{ $item->id }}"
                                                class="btn btn-success mb-1 mt-1 mr-1"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i
                                                    class="fas fa-trash-alt"></i></a>
                                            <a href="{{ route('viewSht', $item->id) }}"
                                                class="btn btn-success mb-1 mt-1"><i class="fas fa-info-circle"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @else
                        <tr>
                            <td colspan="12">Tidak ada data yang ditemukan.</td>
                        </tr>
                    @endif
                </tbody>

            </table>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>

        <script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#myTable').DataTable({
                    searching: true,
                    paging: true,
                    ordering: true,
                    info: true,
                    pageLength: 10, // Jumlah entri yang ditampilkan per halaman
                    lengthMenu: [10, 25, 50, 100], // Opsi untuk jumlah entri yang ditampilkan
                    columnDefs: [{
                            targets: [0, 1, 2, 3, 5, 10], // Indeks kolom yang bisa dicari
                            searchable: true // Aktifkan pencarian untuk kolom ini
                        },
                        {
                            targets: '_all', // Semua kolom lainnya
                            searchable: false // Nonaktifkan pencarian untuk kolom lainnya
                        }
                    ],
                    language: {
                        search: "", // Menghilangkan label "Search:"
                        searchPlaceholder: "Search...", // Placeholder untuk search box
                        lengthMenu: "Show _MENU_ entries", // Menu untuk memilih jumlah entri
                        paginate: {
                            previous: "Previous", // Label untuk tombol "Previous"
                            next: "Next" // Label untuk tombol "Next"
                        },
                        info: "Showing _START_ to _END_ of _TOTAL_ entries", // Informasi entri
                    }
                });
            });
        </script>
    @endsection
