    @extends('sht.master')


    @section('content')
        <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">

        <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <!-- Modal Alert -->
        <div class="container">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
        <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="alertModalLabel"></h5>

                    </div>
                    <div class="modal-body" id="alertModalBody"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="alertModalOkButton" data-bs-dismiss="modal">
                            Oke
                        </button>

                    </div>
                </div>
            </div>
        </div>


        <nav aria-label="breadcrumb bg-none" class="flex d-flex flex-row justify-content-between">
            <div class="d-flex flex">
                <ol class="breadcrumb bg-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route('sht') }}" class="text-decoration-none">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Penerima SHT</li>
                </ol>
            </div>

        </nav>


        <div class="w-min">

        </div>
        <div class="card-body shadow mt-3 mb-4">
            <div class="d-flex justify-content-between mb-4 mt-2">
                <div class="d-flex flex-row">
                    <a href="/insertpenerimaSht" class="btn btn-success" style=" margin-top: -13px;">Tambah
                        <i class="fas fa-plus-square"></i></a>

                </div>

                <div class="d-flex flex-row">
                    <a href="{{ route('exportpenerimaSht') }}" class="btn btn-success" style=" margin-top: -13px;">Unduh
                        <i class="fas fa-file-excel"></i> </a>
                </div>
            </div>


            <form action="{{ url('penerimasht') }}" method="GET" id="filterForm">
                <div class="form-row mb-3 d-flex justify-content-between">
                    <!-- Items per page -->

                    <div class="ml-1 d-flex align-items-center position-relative" style="width: 130px">
                        <select name="perPage" id="perPage" class="form-select form-control custom-dropdown">
                            <option value="10" {{ request('perPage') == '10' ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('perPage') == '25' ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('perPage') == '50' ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('perPage') == '100' ? 'selected' : '' }}>100</option>
                        </select>
                        <label for="perPage" class="ml-1 mb-0 d-flex align-items-center">Entries</label>
                    </div>





                    <!-- Criteria filter -->
                    <div class="d-flex align-items-center justify-content-end mr-1">
                        <form method="GET" action="{{ url()->current() }}">
                            <!-- Dropdown untuk Kriteria lainnya -->
                            <select name="criteria" id="criteriaSelect"
                                class="form-select form-control col-4 align-items-center">
                                <option value="" {{ request('criteria') == '' ? 'selected' : '' }}>Pilih Criteria
                                </option>
                                <option value="nomor_pegawai"
                                    {{ request('criteria') == 'nomor_pegawai' ? 'selected' : '' }}>No Register</option>
                                <option value="nama_peserta" {{ request('criteria') == 'nama_peserta' ? 'selected' : '' }}>
                                    Nama</option>
                                <option value="no_peserta" {{ request('criteria') == 'no_peserta' ? 'selected' : '' }}>No
                                    Peserta</option>
                                <option value="no_peserta_lama"
                                    {{ request('criteria') == 'no_peserta_lama' ? 'selected' : '' }}>No Peserta Lama
                                </option>

                            </select>


                            <input type="text" name="search" id="search" class="form-control col-4" value=""
                                placeholder="Search">



                            <!-- Search button -->
                            <button type="submit" class="btn btn-primary ml-1">Search</button>
                        </form>
                    </div>




                </div>
            </form>


            <!-- Filter Pencarian -->

            <table class="table table-bordered table-responsive h-4" id="myTable">
                <thead>
                    <tr>
                        <th class="center">No</th>
                        <th class="center">No Register</th>
                        <th class="center">Nama</th>
                        <th class="center">No Peserta</th>
                        <th class="center">Jenis Kelamin</th>
                        <th class="center">No Peserta Lama</th>
                        <th class="center">Kode Jenis Pensiun</th>
                        <th class="center">Nama Jenis Pensiun</th>
                        <th class="center">Nilai Manfaat Pensiun</th>
                        <th class="center">Nama Bank</th>
                        <th class="center">No Rekening</th>
                        <th class="center">Atas Nama</th>
                        <th class="center">Keterangan</th>
                        <th class="center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($penerima_sht->count() > 0)
                        @foreach ($penerima_sht as $item)
                            <tr>
                                <td>{{ $loop->iteration + ($penerima_sht->currentPage() - 1) * $penerima_sht->perPage() }}
                                </td>
                                <td>{{ $item->nomor_pegawai }}</td>
                                <td>{{ $item->nama_peserta }}</td>
                                <td>{{ $item->no_peserta }}</td>
                                <td>{{ $item->jenis_kelamin }}</td>
                                <td>{{ $item->no_peserta_lama }}</td>
                                <td>{{ $item->kd_jenis_pensiun }}</td>
                                <td>
                                    @php
                                        $jenisPensiun = \App\Models\JenisPensiun::where(
                                            'kd_jenis_pensiun',
                                            $item->kd_jenis_pensiun,
                                        )->first();
                                    @endphp
                                    {{ $jenisPensiun->nama_jenis_pensiun ?? 'Nama tidak ditemukan' }}
                                </td>
                                <td>{{ $item->nilai_manfaat_pensiun }}</td>
                                <td>{{ $item->nama_bank }}</td>
                                <td>{{ $item->no_rekening }}</td>
                                <td>{{ $item->atas_nama }}</td>
                                <td>{{ $item->keterangan }}</td>
                                <td>
                                    <div class="d-flex flex-row justify-content-start">
                                        <a href="{{ route('editpenerimaSht', $item->no_penerima_sht) }}"
                                            class="btn btn-success mt-1 mb-1 mr-1" style="margin-right:30px;"><i
                                                class="fas fa-pen"></i></a>
                                        <a href="/penerimashtDelete/{{ $item->no_penerima_sht }}"
                                            class="btn btn-success mb-1 mt-1 mr-1"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i
                                                class="fas fa-trash-alt"></i></a>
                                        <a href="{{ route('viewpenerimaSht', $item->no_penerima_sht) }}"
                                            class="btn btn-success mb-1 mt-1"><i class="fas fa-info-circle"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="12">Tidak ada data yang ditemukan.</td>
                        </tr>
                    @endif
                </tbody>

            </table>

            @if ($penerima_sht->count() > 0)
                <div class="d-flex justify-content-between mt-2">
                    <div>
                        Showing
                        {{ $penerima_sht->firstItem() }}
                        to
                        {{ $penerima_sht->lastItem() }}
                        of
                        {{ $penerima_sht->total() }}
                        entries
                    </div>

                    <!-- Pagination: Previous and Next buttons -->
                    <div class="d-flex justify-content-center d-flex align-items-center 2">
                        <div class="pagination-wrapper">
                            <!-- Previous Page Link -->
                            @if ($penerima_sht->onFirstPage())
                                <span class="pagination-link disabled">Previous</span>
                            @else
                                <a href="{{ $penerima_sht->previousPageUrl() }}&criteria={{ request('criteria') }}&search={{ request('search') }}&perPage={{ request('perPage') }}"
                                    class="pagination-link btn btn-secondary">
                                    Previous
                                </a>
                            @endif


                            <!-- Next Page Link -->
                            @if ($penerima_sht->hasMorePages())
                                <a href="{{ $penerima_sht->nextPageUrl() }}&criteria={{ request('criteria') }}&search={{ request('search') }}&perPage={{ request('perPage') }}"
                                    class="pagination-link btn btn-secondary pr-4 pl-4">
                                    Next
                                </a>
                            @else
                                <span class="pagination-link disabled">Next</span>
                            @endif
                        </div>
                    </div>
            @endif

        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>

        <script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>


        <script>
            // Ambil elemen tombol dan container input
            const showUploadFieldsButton = document.getElementById('showUploadFieldsButton');
            const uploadFields = document.getElementById('uploadFields');

            // Event ketika tombol 'Klik untuk Upload' ditekan
            showUploadFieldsButton.addEventListener('click', function() {
                // Tampilkan input No SPP dan tombol Upload
                uploadFields.style.display = 'block';

                // Sembunyikan tombol 'Klik untuk Upload'
                showUploadFieldsButton.style.display = 'none';
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const yearSelect = document.getElementById('yearSelect');
                const criteriaSelect = document.getElementById('criteriaSelect');

                // Fungsi untuk mengubah criteria menjadi "Tanggal Pensiun" saat year terisi
                function autoSelectCriteria() {
                    // Jika year terisi dan criteria belum dipilih atau bukan "Tanggal Pensiun"
                    if (yearSelect.value !== '' && criteriaSelect.value === '') {
                        criteriaSelect.value = 'bulan'; // Mengubah criteria ke "Tanggal Pensiun"
                    }
                }

                // Listener untuk perubahan pada dropdown year
                yearSelect.addEventListener('change', autoSelectCriteria);

                // Memastikan saat page load juga melakukan cek
                autoSelectCriteria();
            });
        </script>
        <script>
            // Auto-submit form when "Items per page" is changed
            document.getElementById('perPage').addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });

            // Listen for pagination link clicks and append the current filters to the URL
            document.querySelectorAll('.pagination a').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    let url = new URL(link.href);

                    // Append search filters to the pagination URL
                    let params = new URLSearchParams(url.search);
                    params.set('criteria', document.getElementById('criteria').value);
                    params.set('search', document.getElementById('search').value);
                    params.set('perPage', document.getElementById('perPage').value);

                    // Redirect to the new URL
                    window.location.href = url.pathname + '?' + params.toString();
                });
            });
        </script>

        <script>
            // Auto-submit form when "Items per page" is changed
            document.getElementById('perPage').addEventListener('change', function() {
                // Trigger form submit automatically when items per page is changed
                document.getElementById('filterForm').submit();
            });
        </script>
        <script>
            // Enable or disable the upload button based on year, month, and status selection
            document.addEventListener('DOMContentLoaded', function() {
                var yearSelect = document.querySelector('select[name="year"]');
                var monthSelect = document.querySelector('select[name="month"]'); // Menambahkan bulan
                var statusSelect = document.querySelector(
                    'select[name="status"]'); // Menggunakan dropdown select untuk status
                var uploadButton = document.getElementById('uploadButton');
                var errorMessage = document.getElementById('errorMessage'); // Elemen untuk menampilkan pesan error

                // Function to check if year, month, and status are selected
                function toggleUploadButton() {
                    var yearSelected = yearSelect.value !== '';
                    var monthSelected = monthSelect.value !== ''; // Menambahkan pengecekan bulan
                    var statusSelected = statusSelect.value !== ''; // Memeriksa apakah status telah dipilih

                    // Reset error message
                    errorMessage.textContent = '';

                    // Logic to show error messages
                    if (!yearSelected) {
                        errorMessage.textContent = "Mohon Mengisi Tahun";
                        uploadButton.disabled = true;
                    } else if (!statusSelected) {
                        errorMessage.textContent = "Mohon Mengisi Status";
                        uploadButton.disabled = true;
                    } else if (!monthSelected) {
                        errorMessage.textContent = "Yakin Tidak Mengisi Bulan ?";
                        uploadButton.disabled = false; // Tetap mengizinkan upload jika bulan kosong
                    } else {
                        uploadButton.disabled = false; // Enable upload button when all are selected
                    }
                }

                // Event listener for year selection
                yearSelect.addEventListener('change', toggleUploadButton);

                // Event listener for month selection
                monthSelect.addEventListener('change', toggleUploadButton);

                // Event listener for status selection
                statusSelect.addEventListener('change', toggleUploadButton);

                // Initial check when page is loaded
                toggleUploadButton();
            });
        </script>


        <!-- Error Message Element -->




        </script>
        <script>
            $('#myTable').DataTable({
                data: data,
                columns: [{
                        "data": "no"
                    },
                    {
                        "data": "nomor_pegawai"
                    },
                    {
                        "data": "nama_peserta"
                    },
                    {
                        "data": "no_peserta"
                    },
                    {
                        "data": "jenis_kelamin"
                    },
                    {
                        "data": "no_peserta_lama"
                    },
                    {
                        "data": "kd_jenis_pensiun"
                    },
                    {
                        "data": "nilai_manfaat_pensiun"
                    },
                    {
                        "data": "nama_bank"
                    },
                    {
                        "data": "no_rekening"
                    },
                    {
                        "data": "atas_nama"
                    },
                    {
                        "data": "keterangan"
                    }
                ],
                searching: false, // Nonaktifkan pencarian
                paging: false, // Nonaktifkan pagination
                ordering: false, // Nonaktifkan pengurutan
                info: false, // Nonaktifkan informasi jumlah entri
                pageLength: 10, // Jumlah entri yang ditampilkan per halaman
                lengthMenu: [10, 25, 50, 100], // Opsi jumlah entri
                language: {
                    search: "",
                    searchPlaceholder: "Search...",
                    lengthMenu: "Show _MENU_ entries",
                    paginate: {
                        previous: "Previous",
                        next: "Next"
                    },
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    emptyTable: "No data available",
                    zeroRecords: "No matching records found"
                }
            });
        </script>

        </script>


    @endsection
