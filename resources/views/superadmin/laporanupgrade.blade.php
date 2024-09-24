<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laporan Inventaris Upgrade Barang - InvenTrack</title>
    <link rel="stylesheet" href="upgradebrg.css" />
  </head>
  <body>
    <div class="sidebar">
      <div class="logo">
        <img src="Asset/rb putih.png" alt="Logo" />
        <h2>InvenTrack</h2>
      </div>
      <!-- Sidebar content with dropdown -->
      <ul>
        <li>
          <a href="dashboard.html"> <img src="Asset/dashboard.png" alt="Dashboard Icon" />Dashboard </a>
        </li>
        <li>
          <a href="databarang.html"> <img src="Asset/databarang.png" alt="Data Icon" />Data Barang </a>
        </li>
        <li class="dropdown">
          <a href="perubahandatabrg.html" class="dropbtn">
            <img src="Asset/perubahanbarang.png" alt="Change Icon" />Perubahan Barang
            <img src="Asset/tutup.png" alt="Toggle Arrow" class="toggle-icon" />
          </a>
          <ul class="dropdown-content">
            <li><a href="upgradebrg.html">Upgrade Barang</a></li>
            <li><a href="perbaikanbrg.html">Perbaikan Barang</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropbtn">
            <img src="Asset/transaksi.png" alt="Activity Icon" />Aktivitas Barang
            <img src="Asset/tutup.png" alt="Toggle Arrow" class="toggle-icon" />
          </a>
          <ul class="dropdown-content">
            <li><a href="peminjaman.html">Peminjaman</a></li>
            <li><a href="pengembalian.html">Pengembalian</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="active" class="dropbtn">
            <img src="Asset/laporan.png" alt="Report Icon" />Laporan
            <img src="Asset/tutup.png" alt="Toggle Arrow" class="toggle-icon" />
          </a>
          <ul class="dropdown-content">
            <li><a href="laporanperbaikan.html">Laporan Perbaikan</a></li>
            <li><a href="laporanupgrade.html">Laporan Upgrade</a></li>
            <li><a href="laporanpembaruan.html">Laporan Pembaruan</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropbtn">
            <img src="Asset/pengaturan.png" alt="Settings Icon" />Pengaturan
            <img src="Asset/tutup.png" alt="Toggle Arrow" class="toggle-icon" />
          </a>
          <ul class="dropdown-content">
            <li><a href="user.html">User</a></li>
            <li><a href="profile.html">Profile</a></li>
          </ul>
        </li>
        <li>
          <a href="index.html" class="logout"> <img src="Asset/logout.png" alt="Logout Icon" />Log Out </a>
        </li>
      </ul>
    </div>

    <div class="main-content">
      <div class="header">
        <div class="navbar">
          <div class="navbar-logo">
            <img src="Asset/RB Logo.png" alt="Radar Bogor Logo" />
          </div>
          <div class="user-info">
            <img src="Asset/useraicon.png" alt="User Icon" class="user-icon" />
            <div class="text-info">
                <span class="username">{{ Auth::user()->name }}</span>
                <span class="role">{{ Auth::user()->role }}</span>
            </div>
          </div>
        </div>

        <br />
        <div class="header-content">
          <h1>Laporan Inventaris Upgrade Barang</h1>
          <input type="text" class="search-bar" placeholder="Search Bar" />
        </div>
      </div>

      <div class="data-barang-actions">
        <button class="btn-filter"><img src="Asset/filter.png" alt="Filter Icon" />Filter</button>
        <button class="btn-pdf"><img src="Asset/pdf.png" alt="PDF Icon" />Cetak PDF</button>
        <button class="btn-print"><img src="Asset/print.png" alt="Print Icon" />Print</button>
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
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Asus Expert</td>
            <td>01A</td>
            <td>27 Agustus 2023</td>
            <td>Intel Core i5</td>
            <td>Rp 10.000.000</td>
            <td>27 Agustus 2024</td>
            <td><span class="jenis-perubahan upgrade">Upgrade</span></td>
            <td>Ganti LCD</td>
            <td>Rp 200.000</td>
            <td><img src="Asset/edit.png" alt="Edit Icon" class="action-icon" /> <img src="Asset/delete.png" alt="Delete Icon" class="action-icon" /></td>
          </tr>
          <tr>
            <td>2</td>
            <td>Asus Expert</td>
            <td>01A</td>
            <td>27 Agustus 2023</td>
            <td>Intel Core i5</td>
            <td>Rp 10.000.000</td>
            <td>27 Agustus 2024</td>
            <td><span class="jenis-perubahan upgrade">Upgrade</span></td>
            <td>Ganti Keyboard</td>
            <td>Rp 200.000</td>
            <td><img src="Asset/edit.png" alt="Edit Icon" class="action-icon" /> <img src="Asset/delete.png" alt="Delete Icon" class="action-icon" /></td>
          </tr>
          <tr>
            <td>3</td>
            <td>Asus Expert</td>
            <td>01A</td>
            <td>27 Agustus 2023</td>
            <td>Intel Core i5</td>
            <td>Rp 10.000.000</td>
            <td>27 Agustus 2024</td>
            <td><span class="jenis-perubahan upgrade">Upgrade</span></td>
            <td>Penambahan RAM 32GB</td>
            <td>Rp 1.000.000</td>
            <td><img src="Asset/edit.png" alt="Edit Icon" class="action-icon" /> <img src="Asset/delete.png" alt="Delete Icon" class="action-icon" /></td>
          </tr>
          <tr>
            <td>4</td>
            <td>Asus Expert</td>
            <td>01A</td>
            <td>27 Agustus 2023</td>
            <td>Intel Core i5</td>
            <td>Rp 10.000.000</td>
            <td>27 Agustus 2024</td>
            <td><span class="jenis-perubahan upgrade">Upgrade</span></td>
            <td>Ganti LCD</td>
            <td>Rp 200.000</td>
            <td><img src="Asset/edit.png" alt="Edit Icon" class="action-icon" /> <img src="Asset/delete.png" alt="Delete Icon" class="action-icon" /></td>
          </tr>
          <tr>
            <td>5</td>
            <td>Asus Expert</td>
            <td>01A</td>
            <td>27 Agustus 2023</td>
            <td>Intel Core i5</td>
            <td>Rp 10.000.000</td>
            <td>27 Agustus 2024</td>
            <td><span class="jenis-perubahan upgrade">Upgrade</span></td>
            <td>Ganti LCD</td>
            <td>Rp 200.000</td>
            <td><img src="Asset/edit.png" alt="Edit Icon" class="action-icon" /> <img src="Asset/delete.png" alt="Delete Icon" class="action-icon" /></td>
          </tr>
        </tbody>
      </table>
      <div class="pagination">
        <button class="btn-prev">Previous</button>
        <span class="page-number">1</span>
        <button class="btn-next">Next</button>
      </div>
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
  </body>
</html>
