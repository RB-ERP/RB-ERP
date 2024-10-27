<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Peminjaman - InvenTrack</title>
    <link rel="stylesheet" href="/css/peminjaman.css" />
    <link rel="stylesheet" href="/css/notification.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    {{-- Modal Detail Barang --}}
    <div id="detailModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2>Detail Barang</h2>
            <ul class="detail-list">
                <li><strong>Nama Barang:</strong> <span id="modal_nama_barang"></span></li>
                <li><strong>Kode Barang:</strong> <span id="modal_kode_barang"></span></li>
                <li><strong>Tanggal Pembelian:</strong> <span id="modal_tanggal_pembelian"></span></li>
                <li><strong>Spesifikasi:</strong> <span id="modal_spesifikasi"></span></li>
                <li><strong>Harga:</strong> <span id="modal_harga"></span></li>
                <li><strong>Status:</strong> <span id="modal_status"></span></li>
            </ul>
        </div>
    </div>

    <div id="popupForm" class="popup-form">
        <div class="popup-content">
            <span class="close-btn" id="closeBtn">&times;</span>
            <h2>Peminjaman Barang</h2>
            <form action="{{ route('peminjaman.store') }}" method="POST">
                @csrf
                <input type="hidden" id="barang_id" name="barang_id" value="">
                <label for="nama">Nama Peminjam <span>*</span></label>
                <input type="text" id="nama" name="nama_peminjam" placeholder="Masukkan nama peminjam"
                    value="{{ Auth::user()->name }}" required>

                <label for="tanggal">Tanggal Peminjaman <span>*</span></label>
                <input type="date" id="tanggal" name="tanggal_peminjaman" required>
                <input type="hidden" id="peminjam_id" name="peminjam_id" value="{{ Auth::user()->id }}" required>


                <div class="form-actions">
                    <button type="button" class="cancel-btn">Cancel</button>
                    <button type="submit" class="submit-btn">Pinjam</button>
                </div>
            </form>

        </div>
    </div>

    {{-- Sidebar --}}
    <div class="sidebar">
        <div class="logo">
            <img src="/asset/rb_putih.png" alt="Logo" />
            <h2>InvenTrack</h2>
        </div>
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
                <a href="#" class="active" class="dropbtn" onclick="toggleDropdown(this)">
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

    {{-- Main Content --}}
    <div class="main-content">
        <div class="header">
            <div class="navbar">
                <div class="navbar-logo">
                    <img src="/asset/RB Logo.png" alt="Radar Bogor Logo" />
                </div>
                <div class="user-info">
                    <a href="{{ route('notifikasi.index') }}" class="notification-icon">
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

            {{-- Table Data Barang --}}
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
                                    class="status @if ($barangAvailable->status == 'Tersedia') tersedia
                                    @elseif($barangAvailable->status == 'Pengajuan Peminjaman')
                                        pengajuan-peminjaman @endif">{{ $barangAvailable->status }}</span>
                            </td>
                            <td class="action-style"
                                @if ($barangAvailable->status == 'Pengajuan Peminjaman') style="min-height: 65px; justify-content: space-between; padding-inline: 12px;" @endif>
                                <button
                                    class="borrow-button pinjamBtn {{ $barangAvailable->status != 'Pengajuan Peminjaman' ? '' : 'disabled-button' }}"
                                    data-id="{{ $barangAvailable->id }}"
                                    @if ($barangAvailable->status == 'Pengajuan Peminjaman') disabled @endif>
                                    <i
                                        class="{{ $barangAvailable->status != 'Pengajuan Peminjaman' ? 'fa-solid fa-arrow-up-right-from-square' : 'fa-regular fa-clock' }} marginRight"></i>
                                    {{ $barangAvailable->status != 'Pengajuan Peminjaman' ? 'Pinjam Sekarang' : 'Pengajuan ...' }}
                                </button>
                                <button class="detail-button"
                                    onclick="openModal('{{ $barangAvailable->nama_barang }}', '{{ $barangAvailable->kode_barang }}', '{{ $barangAvailable->tanggal_pembelian }}', '{{ $barangAvailable->spesifikasi }}', '{{ $barangAvailable->harga }}', '{{ $barangAvailable->status }}')">
                                    <i class="fa-solid fa-circle-info"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Table Data Barang Dipinjam --}}
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
                    @forelse ($barangsDipinjam as $barangDipinjam)
                        <tr>
                            <td>{{ ($barangsDipinjam->currentPage() - 1) * $barangsDipinjam->perPage() + $loop->iteration }}
                            </td>
                            <td>{{ $barangDipinjam->nama_barang }}</td>
                            <td>{{ $barangDipinjam->kode_barang }}</td>
                            <td>{{ $barangDipinjam->nama_peminjam }}</td>
                            <td>{{ $barangDipinjam->tanggal_peminjaman }}</td>
                            <td class="action-style">
                                @if ($barangDipinjam->status == 'Dipinjam')
                                    <button
                                        class="borrow-button return-btn  @if ($barangDipinjam->peminjam_id != Auth::user()->id) disabled-button @endif"
                                        data-id="{{ $barangDipinjam->id }}"
                                        @if ($barangDipinjam->peminjam_id != Auth::user()->id) @disabled(true) @endif>
                                        <i class="fa-solid fa-reply marginRight"></i> Kembalikan Sekarang
                                    </button>
                                @elseif($barangDipinjam->status == 'Pengajuan Pengembalian')
                                    <button class="disabled-button" disabled data-id="{{ $barangDipinjam->id }}">
                                        <i class="fa-regular fa-clock marginRight"></i> Sedang diajukan
                                    </button>
                                @endif
                                <button class="detail-button"
                                    onclick="openModal('{{ $barangDipinjam->nama_barang }}', '{{ $barangDipinjam->kode_barang }}', '{{ $barangDipinjam->tanggal_pembelian }}', '{{ $barangDipinjam->spesifikasi }}', '{{ $barangDipinjam->harga }}', '{{ $barangDipinjam->status }}')">
                                    <i class="fa-solid fa-circle-info"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center;">Tidak Ada Data tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <!-- Pagination untuk Barang Available -->
            <div class="pagination-container available-pagination" style="display: none;">
                <ul class="pagination">
                    {{-- Tombol Previous --}}
                    <li class="page-item {{ $barangsAvailable->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $barangsAvailable->previousPageUrl() }}">&laquo; Previous</a>
                    </li>

                    {{-- Nomor Halaman --}}
                    @for ($i = 1; $i <= $barangsAvailable->lastPage(); $i++)
                        <li class="page-item {{ $i == $barangsAvailable->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $barangsAvailable->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    {{-- Tombol Next --}}
                    <li class="page-item {{ $barangsAvailable->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $barangsAvailable->nextPageUrl() }}">Next &raquo;</a>
                    </li>
                </ul>
            </div>

            <!-- Pagination untuk Barang Dipinjam -->
            <div class="pagination-container dipinjam-pagination" style="display: none;">
                <ul class="pagination">
                    {{-- Tombol Previous --}}
                    <li class="page-item {{ $barangsDipinjam->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $barangsDipinjam->previousPageUrl() }}">&laquo; Previous</a>
                    </li>

                    {{-- Nomor Halaman --}}
                    @for ($i = 1; $i <= $barangsDipinjam->lastPage(); $i++)
                        <li class="page-item {{ $i == $barangsDipinjam->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $barangsDipinjam->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    {{-- Tombol Next --}}
                    <li class="page-item {{ $barangsDipinjam->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $barangsDipinjam->nextPageUrl() }}">Next &raquo;</a>
                    </li>
                </ul>
            </div>

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

            const availableTable = document.querySelector('.available-barang');
            const dipinjamTable = document.querySelector('.dipinjam-barang');
            const availablePagination = document.querySelector('.available-pagination');
            const dipinjamPagination = document.querySelector('.dipinjam-pagination');

            if (status === 'available') {
                buttons[0].classList.add('selected');
                availableTable.style.display = 'block';
                dipinjamTable.style.display = 'none';
                availablePagination.style.display = 'block';
                dipinjamPagination.style.display = 'none';
            } else if (status === 'dipinjam') {
                buttons[1].classList.add('selected');
                availableTable.style.display = 'none';
                dipinjamTable.style.display = 'block';
                availablePagination.style.display = 'none';
                dipinjamPagination.style.display = 'block';
            }

            // Simpan status pilihan ke localStorage
            localStorage.setItem('selectedStatus', status);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const savedStatus = localStorage.getItem('selectedStatus') ||
                'available';
            selectedTable(savedStatus);
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        const pinjamButtons = document.querySelectorAll('.pinjamBtn');
        const popupForm = document.getElementById('popupForm');
        const barangIdInput = document.getElementById('barang_id');
        const closeBtn = document.getElementById('closeBtn');
        const cancelBtn = document.querySelector('.cancel-btn');

        // Loop melalui setiap tombol untuk menambahkan event listener
        pinjamButtons.forEach(button => {
            button.addEventListener('click', () => {
                const barangId = button.getAttribute('data-id'); // Ambil ID barang dari tombol
                barangIdInput.value = barangId; // Isi input hidden dengan ID barang
                console.log('Barang ID:', barangId); // Cek apakah barang_id terisi dengan benar
                popupForm.style.display = 'flex'; // Tampilkan popup
            });
        });


        // Menutup popup ketika tombol close atau cancel diklik
        closeBtn.addEventListener('click', () => {
            popupForm.style.display = 'none'; // Tutup popup
        });

        cancelBtn.addEventListener('click', () => {
            popupForm.style.display = 'none'; // Tutup popup
        });

        // Menutup popup ketika area di luar popup diklik
        window.addEventListener('click', (event) => {
            if (event.target == popupForm) {
                popupForm.style.display = 'none'; // Tutup popup
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            var returnButtons = document.querySelectorAll('.return-btn');

            returnButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();

                    var barangId = this.getAttribute('data-id');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Anda ingin mengajukan pengembalian barang ini!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, ajukan pengembalian!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Kirim request ke server untuk memperbarui status dan membuat notifikasi baru
                            fetch(`/superadmin/pengembalian/${barangId}`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        barang_id: barangId
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        // Tampilkan SweetAlert sukses
                                        Swal.fire(
                                            'Diajukan!',
                                            data.message,
                                            'success'
                                        ).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire('Terjadi kesalahan!', data.message,
                                            'error');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire('Terjadi kesalahan!',
                                        'Kesalahan saat mengajukan pengembalian.',
                                        'error');
                                });
                        }
                    });
                });
            });
        });
    </script>

    <script>
        // Fungsi untuk membuka modal dengan data barang
        function openModal(namaBarang, kodeBarang, tanggalPembelian, spesifikasi, harga, status) {
            document.getElementById('modal_nama_barang').innerText = namaBarang;
            document.getElementById('modal_kode_barang').innerText = kodeBarang;
            document.getElementById('modal_tanggal_pembelian').innerText = tanggalPembelian;
            document.getElementById('modal_spesifikasi').innerText = spesifikasi;
            document.getElementById('modal_harga').innerText = harga;
            document.getElementById('modal_status').innerText = status;

            // Menampilkan modal
            document.getElementById('detailModal').style.display = 'flex';
        }

        // Fungsi untuk menutup modal
        function closeModal() {
            document.getElementById('detailModal').style.display = 'none';
        }

        // Menutup modal jika area di luar modal diklik
        window.onclick = function(event) {
            var modal = document.getElementById('detailModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>

</body>

</html>
