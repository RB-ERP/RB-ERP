<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile - InvenTrack</title>
    <link rel="stylesheet" href="/css/profile.css" />
  </head>
  <body>
    <div class="sidebar">
      <div class="logo">
        <img src="/asset/rb_putih.png" alt="Logo" />
        <h2>InvenTrack</h2>
      </div>
      <ul>
        <li>
            <a href="{{ route('superadmin.databarang') }}"> <img src="/asset/dashboard.png" alt="Dashboard Icon" />Dashboard </a>
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
        <li>
            <a href="{{ route('superadmin.laporan')}}">
                <img src="/asset/laporan.png" alt="Report Icon" />Laporan
            </a>
        </li>
        <li class="dropdown">
          <a href="#" class="active">
            <img src="/asset/pengaturan.png" alt="Settings Icon" />Pengaturan
            <img src="/asset/tutup.png" alt="Toggle Arrow" class="toggle-icon" />
          </a>
          <ul class="dropdown-content">
            <li><a href="{{ route('superadmin.user')}}">User</a></li>
            <li><a href="{{ route('superadmin.profile')}}">Profile</a></li>
          </ul>
        </li>
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
                <h1>Profile Saya</h1>
            </div>
        </div>

        <div class="profile-card">
            <div class="profile-avatar">
                <img src="{{ asset($user->profile_picture ? 'uploads/profile_pictures/' . $user->profile_picture : 'default-avatar.png') }}" alt="Profile Picture">
            </div>
                <div class="profile-details">
                    <div class="profile-name">{{ $user->name }}</div>
                    <div class="profile-info">
                        <div class="detail">
                            <span class="label">Username: </span>
                            <span class="value">{{ $user->username }}</span>
                        </div>
                        <div class="detail">
                            <span class="label">Email: </span>
                            <span class="value">{{ $user->email }}</span>
                        </div>
                        <div class="detail">
                            <span class="label">Role: </span>
                            <span class="value">{{ $user->role }}</span>
                        </div>
                    </div>
                    <div class="profile-actions">
                        <a href="{{ route('superadmin.profile.edit') }}" class="action-btn edit">Edit Profil</a>
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
