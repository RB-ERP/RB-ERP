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
          <a href="#" class="active" class="dropbtn">
            <img src="/asset/transaksi.png" alt="Activity Icon" />Aktivitas Barang
            <img src="/asset/tutup.png" alt="Toggle Arrow" class="toggle-icon" />
          </a>
          <ul class="dropdown-content">
            <li><a href="{{ route('superadmin.peminjaman') }}">Peminjaman</a></li>
            <li>
                <a href="{{ route('superadmin.pengembalian') }}">Pengembalian Barang</a>
            </li>
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
            <h1>Pengembalian Barang</h1>
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
        <button class="btn-pdf"><img src="/asset/pdf.png" alt="PDF Icon" />Cetak PDF</button>
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
            <th>Status</th>
            <th>Nama Peminjam</th>
            <th>Tanggal Peminjaman</th>
            <th>Tanggal Pengembalian</th>
            <th>Action</th>
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
                    <td>
                        <span class="status {{ strtolower($barang->status) }}">{{ $barang->status }}</span>
                    </td>
                    <td>{{ $barang->nama_peminjam ?? '-' }}</td>
                    <td>{{ $barang->tanggal_peminjaman ?? '-' }}</td>
                    <td>{{ $barang->tanggal_pengembalian ?? '-' }}</td>
                    <td>
                        <!-- Tombol Edit -->
                        <a href="{{ route('barang.edit', ['id' => $barang->id, 'source' => 'peminjaman']) }}">
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

     <!-- Bagian Riwayat Peminjaman -->
     <h3>Riwayat Peminjaman</h3>
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
             @foreach ($riwayats as $riwayat)
                 <tr>
                     <td>{{ ($riwayats->currentPage() - 1) * $riwayats->perPage() + $loop->iteration }}</td>
                     <td>{{ $riwayat->barang->nama_barang }}</td>
                     <td>{{ $riwayat->nama_peminjam }}</td>
                     <td>{{ $riwayat->tanggal_peminjaman }}</td>
                     <td>{{ $riwayat->tanggal_pengembalian ?? '-' }}</td>
                     <td>{{ $riwayat->status }}</td>
                 </tr>
             @endforeach
         </tbody>
     </table>

     {{ $riwayats->links() }} <!-- Tambahkan pagination untuk riwayat jika ada -->

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

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

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
