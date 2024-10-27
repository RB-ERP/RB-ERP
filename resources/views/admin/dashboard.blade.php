<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - InvenTrack</title>
    <link rel="stylesheet" href="/css/dashboard.css">
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
          <a href="{{ route('admin.dashboard') }}" class="active"> <img src="/asset/dashboard.png" alt="Dashboard Icon" />Dashboard </a>
        </li>
        <li>
          <a href="{{ route('admin.databarang') }}"> <img src="/asset/databarang.png" alt="Data Icon" />Data Barang </a>
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
            <a href="{{ route('admin.laporan')}}">
                <img src="/asset/laporan.png" alt="Report Icon" />Laporan
            </a>
        </li>
        <li class="dropdown">
          <a href="#" class="dropbtn">
            <img src="/asset/pengaturan.png" alt="Settings Icon" />Pengaturan
            <img src="/asset/tutup.png" alt="Toggle Arrow" class="toggle-icon" />
          </a>
          <ul class="dropdown-content">
            <li><a href="{{ route('admin.profile')}}">Profile</a></li>
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
          <h1>Dashboard</h1>
          <input type="text" class="search-bar" placeholder="Search Bar" />
        </div>
      </div>

      <div class="dashboard-stats">
        <div class="stat-item" style="background-image: url('/asset/batik1.png')">
          <h2>Total Barang</h2>
          <p>{{ $totalBarang }}</p>
          <img src="/asset/totalbarang.png" alt="Total Barang Icon" class="stat-icon" />
        </div>
        <div class="stat-item" style="background-image: url('/asset/batik2.png'); transform: none">
          <h2>Dipinjam</h2>
          <p>{{ $barangDipinjam }}</p>
          <img src="/asset/dipinjam.png" alt="Dipinjam Icon" class="stat-icon" />
        </div>
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
