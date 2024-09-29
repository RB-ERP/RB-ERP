<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laporan Inventaris Perbaikan Barang - InvenTrack</title>
    <link rel="stylesheet" href="/css/laporanperbaikan.css" />
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
          <a href="#" class="active" class="dropbtn">
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
            <h1>Laporan Perbaikan Data Barang</h1>
            <div class="search-filter-container">
                <!-- Search bar -->
                <input type="text" id="searchInput" class="search-bar" placeholder="Search Bar" onkeyup="searchFunction()">

                <!-- Dropdown Filter -->
                <select id="filterCriteria" onchange="searchFunction()">
                  <option value="nama">Nama Barang</option>
                  <option value="tanggal">Tanggal Pembelian</option>
                </select>
            </div>
        </div>

      <div class="data-barang-actions">
        <button class="btn-pdf" onclick="window.location.href='{{ route('superadmin.laporanperbaikan.pdf') }}'">
            <img src="/asset/pdf.png" alt="PDF Icon" />Cetak PDF
        </button>
      </div>

      <table class="data-barang-table">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Kode Barang</th>
            <th>Tanggal Pembelian</th>
            <th>Spesifikasi</th>
            <th>Harga</th>
            <th>Tanggal Perubahan</th>
            <th>Jenis Perubahan</th>
            <th>Deskripsi Perubahan</th>
            <th>Biaya Perubahan</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($barangs as $barang)
              <tr>
                  <td>{{ ($barangs->currentPage() - 1) * $barangs->perPage() + $loop->iteration }}</td>
                  <td>{{ $barang->nama_barang }}</td>
                  <td>{{ $barang->kode_barang }}</td>
                  <td>{{ $barang->tanggal_pembelian }}</td>
                  <td>{{ $barang->spesifikasi }}</td>
                  <td>Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                  <td>{{ $barang->tanggal_perubahan }}</td>
                  <td>
                    <span class="jenis-perubahan {{ strtolower($barang->jenis_perubahan) }}">{{ $barang->jenis_perubahan }}</span>
                  </td>
                  <td>{{ $barang->deskripsi_perubahan }}</td>
                  <td>Rp {{ number_format($barang->biaya_perubahan, 0, ',', '.') }}</td>
              </tr>
          @endforeach
        </tbody>
    </table>
    <div class="pagination">
        {{ $barangs->links() }} <!-- Tambahkan pagination jika diperlukan -->
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
