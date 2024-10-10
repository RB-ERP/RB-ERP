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
            <a href="{{ route('superadmin.dashboard') }}"> <img src="/asset/dashboard.png" alt="Dashboard Icon" />Dashboard </a>
        </li>
        <li>
            <a href="{{ route('superadmin.databarang') }}"> <img src="/asset/databarang.png" alt="Data Icon" />Data Barang </a>
        </li>
        <li class="dropdown">
            <a href="{{ route('superadmin.perubahandatabrg') }}" class="active" class="dropbtn">
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
            <li><a href="{{ route('superadmin.pengembalian') }}">Pengembalian Barang</a></li>
          </ul>
        </li>
        <li>
            <a href="{{ route('superadmin.laporan')}}">
                <img src="/asset/laporan.png" alt="Report Icon" />Laporan
            </a>
        </li>
        <li class="dropdown">
          <a href="#" class="dropbtn">
            <img src="/asset/pengaturan.png" alt="Settings Icon" />Pengaturan
            <img src="/asset/tutup.png" alt="Toggle Arrow" class="toggle-icon" />
          </a>
          <ul class="dropdown-content">
            <li><a href="{{ route('superadmin.user')}}">User</a></li>
            <li><a href="{{ route('superadmin.profile')}}">Profile</a></li>
          </ul>
        </li>
        <li>
            <a href="{{ route('logout') }}" class="logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
            <img src="{{ asset($user->profile_picture ? 'uploads/profile_pictures/' . $user->profile_picture : 'default-avatar.png') }}" alt="Profile Picture" class="user-icon">
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
              <input type="text" id="searchInput" class="search-bar" placeholder="Search Bar" onkeyup="searchFunction()">

              <!-- Dropdown Filter -->
              <select id="filterCriteria" onchange="toggleDateFilter()">
                <option value="nama">Nama Barang</option>
                <option value="tanggal">Tanggal Pembelian</option>
              </select>

              <!-- Rentang Tanggal -->
              <div id="dateFilter" style="display: none;">
                <label for="startDate">Mulai:</label>
                <input type="date" id="startDate" onchange="searchFunction()">
                <label for="endDate">Selesai:</label>
                <input type="date" id="endDate" onchange="searchFunction()">
              </div>
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
                <th>Kode Barang</th>
                <th>Jenis Perubahan</th>
                <th>Deskripsi Perubahan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangs as $barang)
                <tr>
                    <td>{{ ($barangs->currentPage() - 1) * $barangs->perPage() + $loop->iteration }}</td>
                    <td>
                        <a href="javascript:void(0)" class="barang-detail"
                           data-nama="{{ $barang->nama_barang }}"
                           data-kode="{{ $barang->kode_barang }}"
                           data-serial="{{ $barang->serial_number }}"
                           data-tanggal="{{ $barang->tanggal_pembelian }}"
                           data-spesifikasi="{{ $barang->spesifikasi }}"
                           data-harga="{{ $barang->harga }}"
                           data-status="{{ $barang->status }}"
                           data-keterangan="{{ $barang->keterangan }}"
                           data-tanggal-perubahan="{{ $barang->tanggal_perubahan }}"
                           data-jenis-perubahan="{{ $barang->jenis_perubahan }}"
                           data-deskripsi-perubahan="{{ $barang->deskripsi_perubahan }}"
                           data-biaya-perubahan="{{ $barang->biaya_perubahan }}">
                           {{ $barang->nama_barang }}
                        </a>
                    </td>
                    <td>{{ $barang->kode_barang }}</td>
                    <td>
                        <span class="jenis-perubahan {{ strtolower($barang->jenis_perubahan) }}">{{ $barang->jenis_perubahan }}</span>
                    </td>
                    <td>{{ $barang->deskripsi_perubahan }}</td>
                    <td>
                        <!-- Tombol Edit -->
                        <a href="{{ route('perbaikan.edit', ['id' => $barang->id, 'source' => 'perbaikan']) }}">
                            <img src="/asset/edit.png" alt="Edit Icon" class="action-icon" />
                        </a>

                        <!-- Tombol Hapus -->
                        <form id="delete-form-{{ $barang->id }}" action="{{ route('barang.destroy', $barang->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" style="border: none; background: none;" onclick="confirmDelete({{ $barang->id }})">
                                <img src="/asset/delete.png" alt="Delete Icon" class="action-icon" />
                            </button>
                        </form>
                    </td>
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

        <div class="pagination-container">
            <ul class="pagination">
                {{-- Tombol Previous --}}
                <li class="page-item {{ $barangs->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $barangs->previousPageUrl() }}">&laquo; Previous</a>
                </li>

                {{-- Nomor Halaman --}}
                @for ($i = 1; $i <= $barangs->lastPage(); $i++)
                    <li class="page-item {{ $i == $barangs->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $barangs->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor

                {{-- Tombol Next --}}
                <li class="page-item {{ $barangs->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $barangs->nextPageUrl() }}">Next &raquo;</a>
                </li>
            </ul>
        </div>

        <script>
        // Event untuk toggle dropdown saat ikon panah diklik
        document.querySelectorAll('.toggle-icon').forEach((icon) => {
            icon.addEventListener('click', function (event) {
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
                td = tr[i].getElementsByTagName("td")[4]; // Kolom Tanggal Pembelian (pastikan indeks kolomnya benar)
                if (td) {
                    var itemDateText = td.textContent || td.innerText;
                    var itemDate = parseDate(itemDateText);

                    // Lakukan perbandingan tanggal
                    if ((!start || itemDate >= start) && (!end || itemDate <= end)) {
                    showRow = true;
                    }
                }
                }

                tr[i].style.display = showRow ? "" : "none";
            }
            }
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
                    document.getElementById("modalKeterangan").textContent = this.dataset.keterangan || "Tidak Ada";
                    document.getElementById("modalTanggalPerubahan").textContent = this.dataset.tanggalPerubahan || "Tidak Ada";
                    document.getElementById("modalJenisPerubahan").textContent = this.dataset.jenisPerubahan || "Tidak Ada";
                    document.getElementById("modalDeskripsiPerubahan").textContent = this.dataset.deskripsiPerubahan || "Tidak Ada";
                    document.getElementById("modalBiayaPerubahan").textContent = "Rp " + (this.dataset.biayaPerubahan || "0");

                    // Show the modal
                    modal.style.display = "block";
                });
            });
        </script>
  </body>
</html>
