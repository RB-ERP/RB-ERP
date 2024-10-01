<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Barang - InvenTrack</title>
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
            <a href="{{ route('superadmin.dashboard') }}"> <img src="/asset/dashboard.png" alt="Dashboard Icon" />Dashboard </a>
        </li>
        <li>
            <a href="{{ route('superadmin.databarang') }}" class="active"> <img src="/asset/databarang.png" alt="Data Icon" />Data Barang </a>
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
            <li><a href="{{ route('superadmin.laporanupgrade')}}">Laporan Upgrade</a></li>
            <li><a href="{{ route('superadmin.laporanpembaruan')}}">Laporan Pembaruan</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropbtn">
            <img src="/asset/pengaturan.png" alt="Settings Icon" />Pengaturan
            <img src="/asset/tutup.png" alt="Toggle Arrow" class="toggle-icon" />
          </a>
          <ul class="dropdown-content">
            <li><a href="{{ route('superadmin.user')}}">User</a></li>
            <li><a href="profile.html">Profile</a></li>
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
      < class="header">
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
            <h1>Data Barang</h1>
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
          <a href="{{ route('barang.create') }}" class="btn-tambah">
            <img src="/asset/tambah.png" alt="Add Icon" /> Tambah Data Baru
          </a>
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
                <a href="javascript:void(0)" class="barang-detail" data-nama="{{ $barang->nama_barang }}" data-kode="{{ $barang->kode_barang }}" data-serial="{{ $barang->serial_number }}" data-spesifikasi="{{ $barang->spesifikasi }}" data-harga="{{ $barang->harga }}" data-status="{{ $barang->status }}" data-tanggal="{{ $barang->tanggal_pembelian }}">
                  {{ $barang->nama_barang }}
                </a>
              </td>
              <td>{{ $barang->kode_barang }}</td>
              <td>
                <span class="status {{ strtolower($barang->status) }}">{{ $barang->status }}</span>
              </td>
              <td>{{ $barang->nama_peminjam }}</td>
              <td>
                <!-- Tombol Edit -->
                <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-edit">
                  <img src="/asset/edit.png" alt="Edit Icon" />
                </a>

                <!-- Tombol Hapus -->
                <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" style="display: inline;">
                  @csrf
                  @method('DELETE')
                  <button type="button" class="btn btn-delete" onclick="confirmDelete({{ $barang->id }})">
                    <img src="/asset/delete.png" alt="Delete Icon" />
                  </button>
                </form>
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

        <div class="pagination">
            {{ $barangs->links() }}
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

        @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}'
            });
        </script>
    @endif

    @if(session('error'))
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
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form jika konfirmasi Ya
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>

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

    <!-- Modal JavaScript -->
    <script>
      $(document).ready(function () {
        // Open modal when clicking on barang name
        $('.barang-detail').on('click', function () {
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
      $('.close').on('click', function () {
        $('#detailModal').fadeOut();
      });

      // Close modal when clicking outside the modal content
      $(window).on('click', function (e) {
        if ($(e.target).is('#detailModal')) {
          $('#detailModal').fadeOut();
            }
        });
      });
    </script>
          <style>
            /* Modal styles */
            .modal {
              display: none;
              position: fixed;
              z-index: 1;
              left: 0;
              top: 0;
              width: 100%;
              height: 100%;
              overflow: auto;
              background-color: rgb(0, 0, 0);
              background-color: rgba(0, 0, 0, 0.4);
            }

            .modal-content {
              background-color: #fefefe;
              margin: 15% auto;
              padding: 20px;
              border: 1px solid #888;
              width: 80%;
            }

            .close {
              color: #aaa;
              float: right;
              font-size: 28px;
              font-weight: bold;
            }

            .close:hover,
            .close:focus {
              color: black;
              text-decoration: none;
              cursor: pointer;
            }
          </style>

  </body>
</html>
