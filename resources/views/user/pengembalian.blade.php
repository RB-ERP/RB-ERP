<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pengembalian - InvenTrack</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="/css/pengembalian.css" />
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
                <a href="{{ route('user.databarang') }}"> <img src="/asset/databarang.png" alt="Data Icon" />Data
                    Barang </a>
            </li>
            <li class="dropdown">
                <a href="{{ route('user.perubahandatabrg') }}" class="dropbtn">
                    <img src="/asset/perubahanbarang.png" alt="Change Icon" />Perubahan Barang
                    <img src="/asset/tutup.png" alt="Toggle Arrow" class="toggle-icon" />
                </a>
                <ul class="dropdown-content">
                    <li><a href="{{ route('upgradebarang.index') }}">Upgrade Barang</a></li>
                    <li><a href="{{ route('user.perbaikan') }}">Perbaikan Barang</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropbtn" onclick="toggleDropdown(this)">
                    <img src="/asset/transaksi.png" alt="Activity Icon" />Aktivitas Barang
                    <img src="/asset/tutup.png" alt="Toggle Arrow" class="toggle-icon" />
                </a>

                <ul class="dropdown-content">
                    <li><a href="{{ route('user.peminjaman') }}">Peminjaman</a></li>
                    <li><a href="{{ route('user.pengembalian') }}">Pengembalian Barang</a></li>
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
                    <li><a href="user.html">User</a></li>
                    <li><a href="profile.html">Profile</a></li>
                </ul>
            </li>
            <li>
                <a href="index.html" class="logout"> <img src="/asset/logout.png" alt="Logout Icon" />Log Out </a>
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
                    <a href="/notifikasi" class="notification-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="23" viewBox="0 0 20 23"
                            fill="none">
                            <path
                                d="M19.1062 15.7071C19.0219 15.6056 18.9391 15.504 18.8578 15.406C17.7407 14.0547 17.0648 13.2392 17.0648 9.41383C17.0648 7.43336 16.591 5.80836 15.6571 4.58961C14.9685 3.68926 14.0377 3.00625 12.8108 2.50148C12.795 2.4927 12.7809 2.48118 12.7692 2.46746C12.3279 0.989726 11.1203 0 9.75835 0C8.3964 0 7.18933 0.989726 6.74804 2.46594C6.73628 2.47917 6.72237 2.49033 6.7069 2.49895C3.84386 3.67758 2.45245 5.93887 2.45245 9.4123C2.45245 13.2392 1.77757 14.0547 0.659366 15.4045C0.578116 15.5025 0.495342 15.602 0.411046 15.7056C0.193296 15.9682 0.0553337 16.2877 0.013486 16.6263C-0.0283616 16.9648 0.0276571 17.3083 0.174913 17.616C0.488233 18.2762 1.15601 18.686 1.91823 18.686H17.6041C18.3627 18.686 19.0259 18.2767 19.3403 17.6196C19.4882 17.3118 19.5447 16.968 19.5032 16.6291C19.4617 16.2901 19.3239 15.9702 19.1062 15.7071ZM9.75835 22.75C10.4922 22.7494 11.2121 22.5502 11.8419 22.1736C12.4716 21.7969 12.9877 21.2568 13.3354 20.6106C13.3518 20.5796 13.3598 20.5449 13.3589 20.5099C13.3579 20.4749 13.3479 20.4407 13.3298 20.4107C13.3117 20.3807 13.2861 20.3559 13.2556 20.3387C13.2251 20.3215 13.1906 20.3125 13.1556 20.3125H6.3621C6.32702 20.3124 6.29251 20.3213 6.26193 20.3385C6.23134 20.3557 6.20573 20.3805 6.18758 20.4105C6.16942 20.4405 6.15935 20.4747 6.15835 20.5098C6.15734 20.5449 6.16543 20.5796 6.18183 20.6106C6.52944 21.2567 7.04544 21.7968 7.6751 22.1734C8.30477 22.5501 9.02463 22.7493 9.75835 22.75Z"
                                fill="#0089D0" />
                        </svg>
                    </a>
                    <div style="display: flex; align-items: center;">
                        <img src="/asset/useraicon.png" alt="User Icon" class="user-icon" />
                        <div class="text-info">
                            <span class="username">{{ Auth::user()->name }}</span>
                            <span class="role">{{ Auth::user()->role }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <br />
            <div class="header-content">
                <h1>Riwayat Peminjaman</h1>
                <div class="search-filter-container">
                    <!-- Search bar -->
                    <input type="text" id="searchInput" class="search-bar" placeholder="Search Bar"
                        onkeyup="searchFunction()">

                    <!-- Dropdown Filter -->
                    <select id="filterCriteria" onchange="searchFunction()">
                        <option value="nama">Nama Barang</option>
                        <option value="tanggal">Tanggal Pembelian</option>
                    </select>
                </div>
            </div>

            <div class="data-barang-actions">
                <button class="btn-pdf"><img src="/asset/pdf.png" alt="PDF Icon" />Cetak PDF</button>
            </div>
            <table class="data-barang-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Nama Peminjam</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayats as $riwayat)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $riwayat->barang->nama_barang }}</td>
                            <td>{{ $riwayat->nama_peminjam }}</td>
                            <td>{{ $riwayat->tanggal_peminjaman ? $riwayat->tanggal_peminjaman->format('d M Y') : '-' }}
                            </td>
                            <td>{{ $riwayat->tanggal_pengembalian ? $riwayat->tanggal_pengembalian->format('d M Y') : '-' }}
                            </td>
                            <td>{{ $riwayat->status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center;">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="pagination-container available-pagination">
                <ul class="pagination">
                    <li class="page-item {{ $riwayats->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $riwayats->previousPageUrl() }}">&laquo; Previous</a>
                    </li>

                    {{-- Nomor Halaman --}}
                    @for ($i = 1; $i <= $riwayats->lastPage(); $i++)
                        <li class="page-item {{ $i == $riwayats->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $riwayats->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    {{-- Tombol Next --}}
                    <li class="page-item {{ $riwayats->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $riwayats->nextPageUrl() }}">Next &raquo;</a>
                    </li>
                </ul>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

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
            function searchFunction() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("searchInput").value.toUpperCase();
                filter = document.getElementById("filterCriteria").value;
                table = document.querySelector(".data-barang-table tbody");
                tr = table.getElementsByTagName("tr");

                for (i = 0; i < tr.length; i++) {
                    // Cek filter apakah mencari berdasarkan Nama Barang atau Tanggal Pembelian
                    if (filter === "nama") {
                        td = tr[i].getElementsByTagName("td")[1]; // Kolom Nama Barang
                    } else if (filter === "tanggal") {
                        td = tr[i].getElementsByTagName("td")[4]; // Kolom Tanggal Pembelian
                    }

                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(input) > -1) {
                            tr[i].style.display = ""; // Menampilkan baris yang sesuai
                        } else {
                            tr[i].style.display = "none"; // Menyembunyikan baris yang tidak sesuai
                        }
                    }
                }
            }

            function toggleDropdown(element) {
                const dropdownContent = element.nextElementSibling;

                // Tutup semua dropdown lainnya sebelum membuka yang baru
                document.querySelectorAll('.dropdown-content').forEach((content) => {
                    if (content !== dropdownContent) {
                        content.classList.remove('show');
                    }
                });

                // Toggle dropdown yang di-klik
                dropdownContent.classList.toggle('show');
            }
        </script>

</body>

</html>
