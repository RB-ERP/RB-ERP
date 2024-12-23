<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Barang - InvenTrack</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="/css/databarang.css" />
</head>

<body>
    <div class="sidebar">
        <div class="logo">
            <img src="/asset/rb_putih.png" alt="Logo" />
            <h2>InvenTrack</h2>
        </div>
        <!-- Sidebar content with dropdown -->
        <ul>
            <li>
                <a href="{{ route('superadmin.dashboard') }}"> <img src="/asset/dashboard.png"
                        alt="Dashboard Icon" />Dashboard </a>
            </li>
            <li>
                <a href="{{ route('superadmin.databarang') }}" class="active"> <img src="/asset/databarang.png"
                        alt="Data Icon" />Data Barang </a>
            </li>
            <li class="dropdown">
                <a href="{{ route('superadmin.perubahandatabrg') }}" class="dropbtn">
                    <img src="/asset/perubahanbarang.png" alt="Change Icon" />Perubahan Barang
                    <img src="/asset/tutup.png" alt="Toggle Arrow" class="toggle-icon" />
                </a>
                <ul class="dropdown-content">
                    <li><a href="{{ route('upgradebarang.index') }}">Upgrade Barang</a></li>
                    <li><a href="{{ route('superadmin.perbaikan') }}">Perbaikan Barang</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropbtn">
                    <img src="/asset/transaksi.png" alt="Activity Icon" />Aktivitas Barang
                    <img src="/asset/tutup.png" alt="Toggle Arrow" class="toggle-icon" />
                </a>
                <ul class="dropdown-content">
                    <li><a href="{{ route('superadmin.peminjaman') }}">Peminjaman</a></li>
                    <li><a href="{{ route('superadmin.pengembalian') }}">Riwayat Peminjaman</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('superadmin.laporan') }}">
                    <img src="/asset/laporan.png" alt="Report Icon" />Laporan
                </a>
            </li>
            <li class="dropdown">
                <a href="#" class="dropbtn">
                    <img src="/asset/pengaturan.png" alt="Settings Icon" />Pengaturan
                    <img src="/asset/tutup.png" alt="Toggle Arrow" class="toggle-icon" />
                </a>
                <ul class="dropdown-content">
                    <li><a href="{{ route('superadmin.user') }}">User</a></li>
                    <li><a href="{{ route('superadmin.profile') }}">Profile</a></li>
                </ul>
            </li>
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="logout">
                    <img src="/asset/logout.png" alt="Logout Icon" />Log Out
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>


    <div class="main-content">
        < class="header">
            <div class="navbar">
                <div class="navbar-logo">
                    <img src="/asset/RB Logo.png" alt="Radar Bogor Logo" />
                </div>
                <div class="user-info">
                    <img src="{{ asset($user->profile_picture ? 'uploads/profile_pictures/' . $user->profile_picture : 'default-avatar.png') }}"
                        alt="Profile Picture" class="user-icon">
                    <div class="text-info">
                        <span class="username">{{ Auth::user()->name }}</span>
                        <span class="role">{{ Auth::user()->role }}</span>
                    </div>
                </div>
            </div>

            <br />
            <div class="header-content">
                <h1>Data Barang</h1>
                <div class="search-filter-container">
                    <!-- Search bar -->
                    <input type="text" id="searchInput" class="search-bar" placeholder="Search Bar"
                        onkeyup="searchFunction()">

                    <!-- Dropdown Filter -->
                    <select id="filterCriteria" onchange="toggleDateFilter()">
                        <option value="nama">Nama Barang</option>
                        <option value="tanggal">Tanggal Pembelian</option>
                        <option value="clear">Clear Filter</option> <!-- Tambahkan opsi Clear Filter -->
                    </select>

                    <!-- Rentang Tanggal -->
                    <div id="dateFilter" style="display: none;">
                        <label for="startDate">Mulai:</label>
                        <input type="date" id="startDate" value="{{ request('startDate') }}"
                            onchange="searchFunction()">
                        <label for="endDate">Selesai:</label>
                        <input type="date" id="endDate" value="{{ request('endDate') }}"
                            onchange="searchFunction()">
                    </div>
                </div>
            </div>

            <div class="data-barang-actions">
                <a href="{{ route('barang.create') }}" class="btn-tambah">
                    <img src="/asset/tambah.png" alt="Add Icon" /> Tambah Data Baru
                </a>
                <button class="btn-pdf"
                    onclick="window.location.href='{{ route('barang.pdf', request()->query()) }}'">
                    <img src="/asset/pdf.png" alt="PDF Icon" /> Cetak PDF
                </button>
            </div>

            <table class="data-barang-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Kode Barang</th>
                        <th>Status</th>
                        <th>Nama Peminjam</th>
                        <th>Action</th> <!-- Tambahkan kolom Action -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barangs as $barang)
                        <tr>
                            <td>{{ ($barangs->currentPage() - 1) * $barangs->perPage() + $loop->iteration }}</td>
                            <td>
                                <a href="javascript:void(0)" class="barang-detail"
                                    data-nama="{{ $barang->nama_barang }}" data-kode="{{ $barang->kode_barang }}"
                                    data-serial="{{ $barang->serial_number }}"
                                    data-spesifikasi="{{ $barang->spesifikasi }}" data-harga="{{ $barang->harga }}"
                                    data-status="{{ $barang->status }}"
                                    data-tanggal="{{ $barang->tanggal_pembelian }}">
                                    {{ $barang->nama_barang }}
                                </a>
                            </td>
                            <td>{{ $barang->kode_barang }}</td>
                            <td>
                                <span class="status {{ strtolower($barang->status) }}">{{ $barang->status }}</span>
                            </td>
                            <td>
                                @if ($barang->status == 'Dipinjam')
                                    {{ $barang->nama_peminjam }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <!-- Tombol Edit -->
                                <a href="{{ route('barang.edit', ['id' => $barang->id, 'source' => 'databarang']) }}">
                                    <img src="/asset/edit.png" alt="Edit Icon" class="action-icon" />
                                </a>

                                <!-- Tombol Hapus -->
                                <form id="delete-form-{{ $barang->id }}"
                                    action="{{ route('superadmin.barang.destroy', $barang->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" style="border: none; background: none;"
                                        onclick="confirmDelete({{ $barang->id }})">
                                        <img src="/asset/delete.png" alt="Delete Icon" class="action-icon" />
                                    </button>
                                </form>
                                <!-- Tombol QR Code PDF -->
                                <a href="{{ route('barang.qrcode.pdf', $barang->id) }}" class="btn btn-qr-code">
                                    <img src="/asset/pdf.png" alt="QR Code Icon" class="action-icon" />
                                    QR Code PDF
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Modal structure -->
            <div id="detailModal" class="modal" style="display:none;">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Detail Barang</h2>
                    <p><strong>Nama Barang:</strong> <span id="modalNamaBarang"></span></p>
                    <p><strong>Kode Barang:</strong> <span id="modalKodeBarang"></span></p>
                    <p><strong>Serial Number:</strong> <span id="modalSerialNumber"></span></p>
                    <p><strong>Spesifikasi:</strong> <span id="modalSpesifikasi"></span></p>
                    <p><strong>Harga:</strong> <span id="modalHarga"></span></p>
                    <p><strong>Status:</strong> <span id="modalStatus"></span></p>
                    <p><strong>Tanggal Pembelian:</strong> <span id="modalTanggalPembelian"></span></p>
                </div>
            </div>

            <div class="mt-3">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        {{-- Previous Button --}}
                        <li class="page-item {{ $barangs->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link"
                                href="{{ $barangs->previousPageUrl() }}&limit={{ $barangs->perPage() }}"
                                aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>

                        {{-- Page Numbers --}}
                        @php
                            $currentPage = $barangs->currentPage();
                            $lastPage = $barangs->lastPage();
                            $startPage = max(1, $currentPage - 1);
                            $endPage = min($lastPage, $currentPage + 1);
                        @endphp

                        {{-- First Page link --}}
                        @if ($startPage > 1)
                            <li class="page-item">
                                <a class="page-link"
                                    href="{{ $barangs->url(1) }}&limit={{ $barangs->perPage() }}">1</a>
                            </li>
                            @if ($startPage > 2)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                        @endif

                        {{-- Page Range --}}
                        @for ($i = $startPage; $i <= $endPage; $i++)
                            <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                <a class="page-link"
                                    href="{{ $barangs->url($i) }}&limit={{ $barangs->perPage() }}">{{ $i }}</a>
                            </li>
                        @endfor

                        {{-- Last Page link --}}
                        @if ($endPage < $lastPage)
                            @if ($endPage < $lastPage - 1)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                            <li class="page-item">
                                <a class="page-link"
                                    href="{{ $barangs->url($lastPage) }}&limit={{ $barangs->perPage() }}">{{ $lastPage }}</a>
                            </li>
                        @endif

                        {{-- Next Button --}}
                        <li class="page-item {{ $barangs->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link"
                                href="{{ $barangs->nextPageUrl() }}&limit={{ $barangs->perPage() }}"
                                aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: '{{ session('success') }}'
                    });
                </script>
            @endif

            @if (session('error'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: '{{ session('error') }}'
                    });
                </script>
            @endif

            <script>
                function confirmDelete(id) {
                    Swal.fire({
                        title: 'Apakah kamu yakin?',
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('delete-form-' + id).submit();
                        }
                    });
                }
            </script>

            <script>
                // Event untuk toggle dropdown saat ikon panah diklik
                document.querySelectorAll('.toggle-icon').forEach((icon) => {
                    icon.addEventListener('click', function(event) {
                        event.preventDefault(); // Mencegah tindakan default jika diperlukan
                        const dropdownContent = this.parentElement.nextElementSibling;

                        // Tutup semua dropdown lainnya sebelum membuka yang baru
                        document.querySelectorAll('.dropdown-content').forEach((content) => {
                            if (content !== dropdownContent) {
                                content.classList.remove('show');
                            }
                        });

                        // Toggle dropdown yang di-klik
                        dropdownContent.classList.toggle('show');
                    });
                });
            </script>

            <script>
                // Fungsi untuk menampilkan input date ketika filter Tanggal Pembelian dipilih
                function toggleDateFilter() {
                    var filter = document.getElementById("filterCriteria").value;
                    var dateFilter = document.getElementById("dateFilter");

                    if (filter === "tanggal") {
                        dateFilter.style.display = "block";
                    } else if (filter === "clear") {
                        clearFilter(); // Panggil fungsi clearFilter jika Clear Filter dipilih
                    } else {
                        dateFilter.style.display = "none";
                        document.getElementById("startDate").value = "";
                        document.getElementById("endDate").value = "";
                    }
                };

                function clearFilter() {
                    // Ambil URL saat ini tanpa parameter query
                    var currentUrl = window.location.href.split('?')[0];

                    // Redirect ke URL baru tanpa parameter filter
                    window.location.href = currentUrl + '?page=1';
                };

                function searchFunction() {
                    var input = document.getElementById("searchInput").value.toUpperCase();
                    var filter = document.getElementById("filterCriteria").value;
                    var startDate = document.getElementById("startDate").value;
                    var endDate = document.getElementById("endDate").value;

                    // Ambil URL saat ini tanpa parameter query
                    var currentUrl = window.location.href.split('?')[0];

                    // Ambil parameter halaman (page) saat ini dari URL
                    var params = new URLSearchParams(window.location.search);
                    var page = params.get('page') || 1; // Jika tidak ada page, setel default ke halaman 1

                    // Buat URL baru dengan parameter filter dan halaman
                    var newUrl = currentUrl + '?startDate=' + startDate + '&endDate=' + endDate + '&search=' + input + '&page=' +
                        page;

                    // Redirect ke URL baru dengan parameter filter dan pagination
                    window.location.href = newUrl;
                };

                function clearFilter() {
                    // Ambil URL saat ini tanpa parameter query
                    var currentUrl = window.location.href.split('?')[0];

                    // Redirect ke URL baru tanpa parameter filter
                    window.location.href = currentUrl + '?page=1';
                };
            </script>

            <!-- Modal JavaScript -->
            <script>
                $(document).ready(function() {
                    // Open modal when clicking on barang name
                    $('.barang-detail').on('click', function() {
                        $('#modalNamaBarang').text($(this).data('nama'));
                        $('#modalKodeBarang').text($(this).data('kode'));
                        $('#modalSerialNumber').text($(this).data('serial'));
                        $('#modalSpesifikasi').text($(this).data('spesifikasi'));
                        $('#modalHarga').text("Rp " + parseFloat($(this).data('harga')).toLocaleString());
                        $('#modalStatus').text($(this).data('status'));
                        $('#modalTanggalPembelian').text($(this).data('tanggal'));
                        $('#detailModal').fadeIn();
                    });

                    // Close modal when clicking on close button
                    $('.close').on('click', function() {
                        $('#detailModal').fadeOut();
                    });

                    // Close modal when clicking outside the modal content
                    $(window).on('click', function(e) {
                        if ($(e.target).is('#detailModal')) {
                            $('#detailModal').fadeOut();
                        }
                    });
                });
            </script>
</body>

</html>
