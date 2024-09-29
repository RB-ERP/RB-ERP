<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Upgrade Barang - InvenTrack</title>
    <link rel="stylesheet" href="/css/upgradebrg.css" />
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
            <img src="/asset/useraicon.png" alt="User Icon" class="user-icon" />
            <div class="text-info">
                <span class="username">{{ Auth::user()->name }}</span>
                <span class="role">{{ Auth::user()->role }}</span>
            </div>
          </div>
        </div>

        <br />
        <div class="header-content">
            <h1>Upgrade Barang</h1>
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
        <button class="btn-pdf" onclick="window.location.href='{{ route('upgradebarang.pdf') }}'">
            <img src="/asset/pdf.png" alt="PDF Icon" />Cetak PDF
        </button>
      </div>

      <table class="data-barang-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Kode Barang</th>
                    <th>Serial Number</th>
                    <th>Tanggal Pembelian</th>
                    <th>Spesifikasi</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Tanggal Perubahan</th>
                    <th>Jenis Perubahan</th>
                    <th>Deskripsi Perubahan</th>
                    <th>Biaya Perubahan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($barangs as $barang)
                    <tr>
                        <td>{{ ($barangs->currentPage() - 1) * $barangs->perPage() + $loop->iteration }}</td>
                        <td>{{ $barang->nama_barang }}</td>
                        <td>{{ $barang->kode_barang }}</td>
                        <td>{{ $barang->serial_number }}</td>
                        <td>{{ $barang->tanggal_pembelian }}</td>
                        <td>{{ $barang->spesifikasi }}</td>
                        <td>Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                        <td>
                            <span class="status {{ strtolower($barang->status) }}">{{ $barang->status }}</span>
                        </td>
                        <td>{{ $barang->tanggal_perubahan }}</td>
                        <td>
                            <span class="jenis-perubahan {{ strtolower($barang->jenis_perubahan) }}">{{ $barang->jenis_perubahan }}</span>
                        </td>
                        <td>{{ $barang->deskripsi_perubahan }}</td>
                        <td>Rp {{ number_format($barang->biaya_perubahan, 0, ',', '.') }}</td>
                        <td>
                            <!-- Tombol Edit -->
                            <a href="{{ route('barang.edit', ['id' => $barang->id, 'source' => 'perubahan']) }}">
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
      <div class="pagination">
        <button class="btn-prev">Previous</button>
        <span class="page-number">1</span>
        <button class="btn-next">Next</button>
      </div>
    </div>

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
  </body>
</html>
