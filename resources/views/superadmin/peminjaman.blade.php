<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Peminjaman - InvenTrack</title>
    <link rel="stylesheet" href="/css/peminjaman.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                <a href="{{ route('superadmin.databarang') }}"> <img src="/asset/databarang.png" alt="Data Icon" />Data
                    Barang </a>
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
                <a href="#" class="active" class="dropbtn">
                    <img src="/asset/transaksi.png" alt="Activity Icon" />Aktivitas Barang
                    <img src="/asset/tutup.png" alt="Toggle Arrow" class="toggle-icon" />
                </a>
                <ul class="dropdown-content">
                    <li><a href="{{ route('superadmin.peminjaman') }}">Peminjaman</a></li>
                    <li><a href="{{ route('superadmin.pengembalian') }}">Pengembalian Barang</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropbtn">
                    <img src="/asset/laporan.png" alt="Report Icon" />Laporan
                    <img src="/asset/tutup.png" alt="Toggle Arrow" class="toggle-icon" />
                </a>
                <ul class="dropdown-content">
                    <li><a href="{{ route('superadmin.laporanperbaikan') }}">Laporan Perbaikan</a></li>
                    <li><a href="laporanupgrade.html">Laporan Upgrade</a></li>
                    <li><a href="laporanpembaruan.html">Laporan Pembaruan</a></li>
                </ul>
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
                    <img src="/asset/useraicon.png" alt="User Icon" class="user-icon" />
                    <div class="text-info">
                        <span class="username">{{ Auth::user()->name }}</span>
                        <span class="role">{{ Auth::user()->role }}</span>
                    </div>
                </div>
            </div>

            <br />
            <div class="header-content">
                <h1>Peminjaman Barang</h1>
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

            <div class="filter-barang-status">
                <button class="barang-status selected" onclick="selectedTable('available')">
                    <p>Barang Tersedia</p>
                </button>
                <button class="barang-status" onclick="selectedTable('dipinjam')">
                    <p>Barang Dipinjam</p>
                </button>
            </div>

            <div class="data-barang-actions">
                <button class="btn-pdf"><img src="/asset/pdf.png" alt="PDF Icon" />Cetak PDF</button>
            </div>

            <table class="data-barang-table available-barang">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Kode Barang</th>
                        <th>Spesifikasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barangsAvailable as $barangAvailable)
                        <tr>
                            <td>{{ ($barangsAvailable->currentPage() - 1) * $barangsAvailable->perPage() + $loop->iteration }}
                            </td>
                            <td>{{ $barangAvailable->nama_barang }}</td>
                            <td>{{ $barangAvailable->kode_barang }}</td>
                            <td>{{ $barangAvailable->spesifikasi }}</td>
                            <td><span
                                    class="status {{ strtolower($barangAvailable->status) }}">{{ $barangAvailable->status }}</span>
                            </td>
                            <td class="action-style">
                                <button class="borrow-button">
                                    <i class="fa-solid fa-clipboard marginRight"></i> Pinjam Sekarang
                                </button>
                                <button class="detail-button">
                                    <i class="fa-solid fa-circle-info"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <table class="data-barang-table dipinjam-barang">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Kode Barang</th>
                        <th>Nama Peminjam</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barangsDipinjam as $barangDipinjam)
                        <tr>
                            <td>{{ ($barangsDipinjam->currentPage() - 1) * $barangsDipinjam->perPage() + $loop->iteration }}
                            </td>
                            <td>{{ $barangDipinjam->nama_barang }}</td>
                            <td>{{ $barangDipinjam->kode_barang }}</td>
                            <td>{{ $barangDipinjam->nama_peminjam }}</td>
                            <td>{{ $barangDipinjam->tanggal_peminjaman   }}</td>
                            <td class="action-style">
                                <button class="borrow-button">
                                  <i class="fa-solid fa-reply marginRight"></i> Kembalikan Sekarang
                                </button>
                                <button class="detail-button">
                                    <i class="fa-solid fa-circle-info"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="pagination">
                <button class="btn-prev">Previous</button>
                <span class="page-number">1</span>
                <button class="btn-next">Next</button>
            </div>
        </div>

        <script>
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

            function selectedTable(status) {
                const buttons = document.querySelectorAll('.barang-status');

                buttons.forEach((button) => {
                    button.classList.remove('selected');
                });

                if (status === 'available') {
                    buttons[0].classList.add('selected');
                } else if (status === 'dipinjam') {
                    buttons[1].classList.add('selected');
                }

                const availableTable = document.querySelector('.available-barang');
                const dipinjamTable = document.querySelector('.dipinjam-barang');

                if (status === 'available') {
                    availableTable.style.display = 'block';
                    dipinjamTable.style.display = 'none';
                } else if (status === 'dipinjam') {
                    availableTable.style.display = 'none';
                    dipinjamTable.style.display = 'block';
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                selectedTable('available');
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
        </script>

</body>

</html>
