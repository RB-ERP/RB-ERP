<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile - InvenTrack</title>
    <link rel="stylesheet" href="profile.css" />
  </head>
  <body>
    <div class="sidebar">
      <div class="logo">
        <img src="Asset/rb putih.png" alt="Logo" />
        <h2>InvenTrack</h2>
      </div>
      <ul>
        <li>
          <a href="dashboard.html"><img src="Asset/dashboard.png" alt="Dashboard Icon" />Dashboard</a>
        </li>
        <li>
          <a href="databarang.html"><img src="Asset/databarang.png" alt="Data Icon" />Data Barang</a>
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
          <a href="#" class="active">
            <img src="Asset/pengaturan.png" alt="Settings Icon" />Pengaturan
            <img src="Asset/tutup.png" alt="Toggle Arrow" class="toggle-icon" />
          </a>
          <ul class="dropdown-content">
            <li><a href="user.html">User</a></li>
            <li><a href="profile.html">Profile</a></li>
          </ul>
        </li>
        <li>
          <a href="index.html" class="logout"><img src="Asset/logout.png" alt="Logout Icon" />Log Out</a>
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
          <h1>Profile</h1>
          <input type="text" class="search-bar" placeholder="Search Bar" />
        </div>
      </div>

      <div class="profile-card">
        <div class="profile-avatar">
          <img src="Asset/useraicon.png" alt="Profile Avatar" />
        </div>
        <div class="profile-details">
          <div class="profile-name">Amalia Kartika Putri</div>
          <div class="profile-info">
            <div class="detail">
              <span class="label">User ID: </span>
              <span class="value">Amalia23</span>
            </div>
            <div class="detail">
              <span class="label">Role: </span>
              <span class="value">Super Admin</span>
            </div>
          </div>
          <div class="profile-actions">
            <button class="action-btn edit">Edit Profile</button>
          </div>
        </div>
      </div>
    </div>

    <script>
      // Event for toggling dropdown when the arrow icon is clicked
      document.querySelectorAll('.toggle-icon').forEach((icon) => {
        icon.addEventListener('click', function (event) {
          event.preventDefault();
          const dropdownContent = this.parentElement.nextElementSibling;
          document.querySelectorAll('.dropdown-content').forEach((content) => {
            if (content !== dropdownContent) {
              content.classList.remove('show');
            }
          });
          dropdownContent.classList.toggle('show');
        });
      });
    </script>
  </body>
</html>
