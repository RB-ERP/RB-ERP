<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laporan Inventaris - InvenTrack</title>
    <link rel="stylesheet" href="/css/laporanupgrade.css" />
</head>

<body>
    <div class="sidebar">
        <div class="logo">
            <img src="/asset/rb_putih.png" alt="Logo" />
            <h2>InvenTrack</h2>
        </div>
        <ul>
            <li>
                <a href="{{ route('admin.databarang') }}"> <img src="/asset/dashboard.png"
                        alt="Dashboard Icon" />Dashboard </a>
            </li>
            <li>
                <a href="{{ route('admin.databarang') }}"> <img src="/asset/databarang.png" alt="Data Icon" />Data
                    Barang </a>
            </li>
            <li class="dropdown">
                <a href="{{ route('admin.perubahandatabrg') }}" class="dropbtn">
                    <img src="/asset/perubahanbarang.png" alt="Change Icon" />Perubahan Barang
                    <img src="/asset/tutup.png" alt="Toggle Arrow" class="toggle-icon" />
                </a>
                <ul class="dropdown-content">
                    <li><a href="{{ route('admin.upgradebarang') }}">Upgrade Barang</a></li>
                    <li><a href="{{ route('admin.perbaikan') }}">Perbaikan Barang</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropbtn">
                    <img src="/asset/transaksi.png" alt="Activity Icon" />Aktivitas Barang
                    <img src="/asset/tutup.png" alt="Toggle Arrow" class="toggle-icon" />
                </a>
                <ul class="dropdown-content">
                    <li><a href="{{ route('admin.peminjaman') }}">Peminjaman</a></li>
                    <li><a href="{{ route('admin.pengembalian') }}">Riwayat Peminjaman</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('admin.laporan') }}" class="active">
                    <img src="/asset/laporan.png" alt="Report Icon" />Laporan
                </a>
            </li>
            <li class="dropdown">
                <a href="#" class="dropbtn">
                    <img src="/asset/pengaturan.png" alt="Settings Icon" />Pengaturan
                    <img src="/asset/tutup.png" alt="Toggle Arrow" class="toggle-icon" />
                </a>
                <ul class="dropdown-content">
                    <li><a href="{{ route('admin.profile') }}">Profile</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('logout') }}" class="logout"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <img src="/asset/logout.png" alt="Logout Icon" />Log Out
                </a>
            </li>
        </ul>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

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
                <h1>Laporan Inventaris Barang</h1>
                <form method="GET" action="{{ route('admin.laporan') }}" class="form-filter">
                    <input type="text" id="searchInput" class="search-bar" placeholder="Cari Nama Barang"
                        name="nama_barang" value="{{ request('nama_barang') }}">

                    <label for="bulan">Pilih Bulan:</label>
                    <select name="bulan" id="bulan">
                        <option value="">Semua Bulan</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ sprintf('%02d', $i) }}"
                                {{ request('bulan') == sprintf('%02d', $i) ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>

                    <label for="tahun">Pilih Tahun:</label>
                    <input type="number" name="tahun" id="tahun" value="{{ request('tahun') }}"
                        placeholder="Semua Tahun">

                    <label for="status">Pilih Status Barang:</label>
                    <select name="status" id="status">
                        <option value="">Semua</option>
                        <option value="Tersedia" {{ request('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia
                        </option>
                        <option value="Dipinjam" {{ request('status') == 'Dipinjam' ? 'selected' : '' }}>Dipinjam
                        </option>
                        <option value="Rusak" {{ request('status') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                        <option value="Diperbaiki" {{ request('status') == 'Diperbaiki' ? 'selected' : '' }}>
                            Diperbaiki</option>
                    </select>

                    <label for="startDate">Tanggal Pembelian Dari:</label>
                    <input type="date" id="startDate" name="start_date" value="{{ request('start_date') }}">

                    <label for="endDate">Tanggal Pembelian Sampai:</label>
                    <input type="date" id="endDate" name="end_date" value="{{ request('end_date') }}">

                    <button type="submit">Filter</button>
                </form>
            </div>

            <div class="data-barang-actions">
                <button class="btn-pdf"
                    onclick="window.location.href='{{ route('admin.laporan.pdf', request()->query()) }}'">
                    <img src="/asset/pdf.png" alt="PDF Icon" /> Cetak PDF
                </button>
            </div>

            <!-- Tabel Data Barang -->
            <table class="data-barang-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Kode Barang</th>
                        <th>Status</th>
                        <th>Tanggal Pembelian</th>
                        <th>Tanggal Peminjaman</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barangs as $barang)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $barang->nama_barang }}</td>
                            <td>{{ $barang->kode_barang }}</td>
                            <td>
                                <span
                                    class="status {{ strtolower(str_replace(' ', '-', $barang->status)) }}">{{ $barang->status }}
                                </span>
                            </td>
                            <td>{{ $barang->tanggal_pembelian }}</td>
                            <td>{{ $barang->tanggal_peminjaman }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

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

                // Fungsi filter berdasarkan status barang
                function filterByStatus(status) {
                    alert("Filter diterapkan untuk status: " + status);
                    // Simulasikan filtering, ganti ini dengan logika filtering sesungguhnya
                };

                // Fungsi untuk pencarian
                function searchFunction() {
                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById("searchInput").value.toUpperCase();
                    filter = document.getElementById("filterCriteria").value;
                    table = document.getElementById("tableBody");
                    tr = table.getElementsByTagName("tr");

                    for (i = 0; i < tr.length; i++) {
                        var showRow = false;

                        if (filter === "nama") {
                            td = tr[i].getElementsByTagName("td")[1]; // Kolom Nama Barang
                        } else if (filter === "tanggal") {
                            td = tr[i].getElementsByTagName("td")[5]; // Kolom Tanggal Peminjaman
                        } else if (filter === "status") {
                            td = tr[i].getElementsByTagName("td")[6]; // Kolom Status Barang
                        }

                        if (td) {
                            txtValue = td.textContent || td.innerText;
                            if (txtValue.toUpperCase().indexOf(input) > -1) {
                                showRow = true;
                            }
                        }

                        tr[i].style.display = showRow ? "" : "none";
                    }
                }
                // Fungsi untuk menampilkan input date ketika filter Tanggal dipilih
                function toggleDateFilter() {
                    var filter = document.getElementById("filterCriteria").value;
                    var dateFilter = document.getElementById("dateFilter");

                    if (filter === "tanggal") {
                        dateFilter.style.display = "block";
                    } else {
                        dateFilter.style.display = "none";
                        document.getElementById("startDate").value = "";
                        document.getElementById("endDate").value = "";
                    }
                }

                function searchFunction() {
                    var input, filter, table, tr, td, i, txtValue, startDate, endDate, itemDate;
                    input = document.getElementById("searchInput").value.toUpperCase();
                    filter = document.getElementById("filterCriteria").value;
                    startDate = document.getElementById("startDate").value;
                    endDate = document.getElementById("endDate").value;
                    table = document.querySelector(".data-barang-table tbody");
                    tr = table.getElementsByTagName("tr");

                    // Fungsi untuk mengubah format input tanggal menjadi objek Date
                    function parseDate(dateString) {
                        if (dateString) {
                            var dateParts = dateString.split('-');
                            // Pastikan format sesuai dengan yyyy-mm-dd
                            if (dateParts.length === 3) {
                                return new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
                            }
                        }
                        return null;
                    }

                    // Konversi input startDate dan endDate ke objek Date
                    var start = parseDate(startDate);
                    var end = parseDate(endDate);

                    for (i = 0; i < tr.length; i++) {
                        var showRow = false;

                        if (filter === "nama") {
                            td = tr[i].getElementsByTagName("td")[1]; // Kolom Nama Barang
                            if (td) {
                                txtValue = td.textContent || td.innerText;
                                if (txtValue.toUpperCase().indexOf(input) > -1) {
                                    showRow = true;
                                }
                            }
                        } else if (filter === "tanggal") {
                            td = tr[i].getElementsByTagName("td")[4]; // Kolom Tanggal Peminjaman
                            if (td) {
                                var itemDateText = td.textContent || td.innerText;
                                var itemDate = parseDate(itemDateText);

                                // Lakukan perbandingan tanggal
                                if ((!start || itemDate >= start) && (!end || itemDate <= end)) {
                                    showRow = true;
                                }
                            }
                        } else if (filter === "status") {
                            td = tr[i].getElementsByTagName("td")[6]; // Kolom Status Barang
                            if (td) {
                                txtValue = td.textContent || td.innerText;
                                if (txtValue.toUpperCase().indexOf(input) > -1) {
                                    showRow = true;
                                }
                            }
                        }

                        tr[i].style.display = showRow ? "" : "none";
                    }
                }
            </script>

</body>

</html>
