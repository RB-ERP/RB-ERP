<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Perbaikan Barang - InvenTrack</title>
    <link rel="stylesheet" href="/css/perbaikanbrg.css" />
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
                <a href="{{ route('user.dashboard') }}"> <img src="/asset/dashboard.png"
                        alt="Dashboard Icon" />Dashboard </a>
            </li>
            <li>
                <a href="{{ route('user.databarang') }}"> <img src="/asset/databarang.png" alt="Data Icon" />Data Barang
                </a>
            </li>
            <li class="dropdown">
                <a href="{{ route('user.perubahandatabrg') }}" class="active" class="dropbtn">
                    <img src="/asset/perubahanbarang.png" alt="Change Icon" />Perubahan Barang
                    <img src="/asset/tutup.png" alt="Toggle Arrow" class="toggle-icon" />
                </a>
                <ul class="dropdown-content">
                    <li><a href="{{ route('upgradebarang.index') }}">Upgrade Barang</a></li>
                    <li><a href="{{ route('user.perbaikan') }}">Perbaikan Barang</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropbtn">
                    <img src="/asset/transaksi.png" alt="Activity Icon" />Aktivitas Barang
                    <img src="/asset/tutup.png" alt="Toggle Arrow" class="toggle-icon" />
                </a>
                <ul class="dropdown-content">
                    <li><a href="{{ route('user.peminjaman') }}">Peminjaman</a></li>
                    <li><a href="{{ route('user.pengembalian') }}">Riwayat Peminjaman</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#">
                    <img src="/asset/pengaturan.png" alt="Settings Icon" />Pengaturan
                    <img src="/asset/tutup.png" alt="Toggle Arrow" class="toggle-icon" />
                </a>
                <ul class="dropdown-content">
                    <li><a href="{{ route('user.profile') }}">Profile</a></li>
                </ul>
            </li>
            <li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a href="{{ route('logout') }}" class="logout"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <img src="/asset/logout.png" alt="Logout Icon" />Log Out
                </a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
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
                <h1>Perbaikan Barang</h1>
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

            <table class="data-barang-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Kode Barang</th>
                        <th>Jenis Perubahan</th>
                        <th>Deskripsi Perubahan</th>
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
                                    data-tanggal="{{ $barang->tanggal_pembelian }}"
                                    data-spesifikasi="{{ $barang->spesifikasi }}" data-harga="{{ $barang->harga }}"
                                    data-status="{{ $barang->status }}" data-keterangan="{{ $barang->keterangan }}"
                                    data-tanggal-perubahan="{{ $barang->tanggal_perubahan }}"
                                    data-jenis-perubahan="{{ $barang->jenis_perubahan }}"
                                    data-deskripsi-perubahan="{{ $barang->deskripsi_perubahan }}"
                                    data-biaya-perubahan="{{ $barang->biaya_perubahan }}">
                                    {{ $barang->nama_barang }}
                                </a>
                            </td>
                            <td>{{ $barang->kode_barang }}</td>
                            <td>
                                <span
                                    class="jenis-perubahan {{ strtolower($barang->jenis_perubahan) }}">{{ $barang->jenis_perubahan }}</span>
                            </td>
                            <td>{{ $barang->deskripsi_perubahan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Modal structure -->
            <div id="detailModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Detail Barang</h2>
                    <p><strong>Nama Barang:</strong> <span id="modalNamaBarang"></span></p>
                    <p><strong>Kode Barang:</strong> <span id="modalKodeBarang"></span></p>
                    <p><strong>Serial Number:</strong> <span id="modalSerialNumber"></span></p>
                    <p><strong>Tanggal Pembelian:</strong> <span id="modalTanggalPembelian"></span></p>
                    <p><strong>Spesifikasi:</strong> <span id="modalSpesifikasi"></span></p>
                    <p><strong>Harga:</strong> <span id="modalHarga"></span></p>
                    <p><strong>Status:</strong> <span id="modalStatus"></span></p>
                    <p><strong>Keterangan:</strong> <span id="modalKeterangan"></span></p>
                    <p><strong>Tanggal Perubahan:</strong> <span id="modalTanggalPerubahan"></span></p>
                    <p><strong>Jenis Perubahan:</strong> <span id="modalJenisPerubahan"></span></p>
                    <p><strong>Deskripsi Perubahan:</strong> <span id="modalDeskripsiPerubahan"></span></p>
                    <p><strong>Biaya Perubahan:</strong> <span id="modalBiayaPerubahan"></span></p>
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

            <script>
                // Get the modal
                var modal = document.getElementById("detailModal");

                // Get the <span> element that closes the modal
                var span = document.getElementsByClassName("close")[0];

                // When the user clicks on <span> (x), close the modal
                span.onclick = function() {
                    modal.style.display = "none";
                }

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }

                // Event handler for clicking on the item name to open the modal
                document.querySelectorAll('.barang-detail').forEach(function(element) {
                    element.addEventListener('click', function() {
                        // Fill modal with relevant data
                        document.getElementById("modalNamaBarang").textContent = this.dataset.nama;
                        document.getElementById("modalKodeBarang").textContent = this.dataset.kode;
                        document.getElementById("modalSerialNumber").textContent = this.dataset.serial;
                        document.getElementById("modalTanggalPembelian").textContent = this.dataset.tanggal;
                        document.getElementById("modalSpesifikasi").textContent = this.dataset.spesifikasi;
                        document.getElementById("modalHarga").textContent = "Rp " + this.dataset.harga;
                        document.getElementById("modalStatus").textContent = this.dataset.status;

                        // Add missing fields
                        document.getElementById("modalKeterangan").textContent = this.dataset.keterangan ||
                            "Tidak Ada";
                        document.getElementById("modalTanggalPerubahan").textContent = this.dataset
                            .tanggalPerubahan || "Tidak Ada";
                        document.getElementById("modalJenisPerubahan").textContent = this.dataset.jenisPerubahan ||
                            "Tidak Ada";
                        document.getElementById("modalDeskripsiPerubahan").textContent = this.dataset
                            .deskripsiPerubahan || "Tidak Ada";
                        document.getElementById("modalBiayaPerubahan").textContent = "Rp " + (this.dataset
                            .biayaPerubahan || "0");

                        // Show the modal
                        modal.style.display = "block";
                    });
                });
            </script>
</body>

</html>
