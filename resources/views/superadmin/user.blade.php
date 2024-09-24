<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User - InvenTrack</title>
    <link rel="stylesheet" href="user.css" />
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
          <a href="#" class="dropbtn">
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
          <a href="#" class="active" class="dropbtn">
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
              <span class="username">Amalia Kartika</span>
              <span class="role">Super Admin</span>
            </div>
          </div>
        </div>

        <br />
        <div class="header-content">
          <h1>User</h1>
          <input type="text" class="search-bar" placeholder="Search Bar" />
        </div>
      </div>

      <div class="data-barang-actions">
        <button class="btn-filter"><img src="Asset/filter.png" alt="filter icon" />Filter</button>
        <button class="btn-tambah"><img src="Asset/tambah.png" alt="Add Icon" />Tambah User Baru</button>
      </div>

      <table class="data-barang-table">
        <thead>
          <tr>
            <th>No</th>
            <th>User Id</th>
            <th>Username</th>
            <th>Role</th>
            <th>Password</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Amalia23</td>
            <td>Amalia Kartika</td>
            <td>Super Admin</td>
            <td>12345678</td>
            <td><img src="Asset/edit.png" alt="Edit Icon" class="action-icon" /> <img src="Asset/delete.png" alt="Delete Icon" class="action-icon" /></td>
          </tr>
          <tr>
            <td>2</td>
            <td>Amalia23</td>
            <td>Amalia Kartika</td>
            <td>Super Admin</td>
            <td>12345678</td>
            <td><img src="Asset/edit.png" alt="Edit Icon" class="action-icon" /> <img src="Asset/delete.png" alt="Delete Icon" class="action-icon" /></td>
          </tr>
          <tr>
            <td>3</td>
            <td>Amalia23</td>
            <td>Amalia Kartika</td>
            <td>Super Admin</td>
            <td>12345678</td>
            <td><img src="Asset/edit.png" alt="Edit Icon" class="action-icon" /> <img src="Asset/delete.png" alt="Delete Icon" class="action-icon" /></td>
          </tr>
          <tr>
            <td>4</td>
            <td>Amalia23</td>
            <td>Amalia Kartika</td>
            <td>Super Admin</td>
            <td>12345678</td>
            <td><img src="Asset/edit.png" alt="Edit Icon" class="action-icon" /> <img src="Asset/delete.png" alt="Delete Icon" class="action-icon" /></td>
          </tr>
          <tr>
            <td>5</td>
            <td>Amalia23</td>
            <td>Amalia Kartika</td>
            <td>Super Admin</td>
            <td>12345678</td>
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
