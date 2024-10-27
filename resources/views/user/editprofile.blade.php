<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Profil - InvenTrack</title>
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
                <a href="{{ route('user.dashboard') }}"> <img src="/asset/dashboard.png" alt="Dashboard Icon" />Dashboard </a>
            </li>
            <li>
                <a href="{{ route('user.databarang') }}"> <img src="/asset/databarang.png" alt="Data Icon" />Data Barang </a>
            </li>
            <li class="dropdown">
                <a href="{{ route('user.perubahandatabrg') }}" class="dropbtn">
                    <img src="/asset/perubahanbarang.png" alt="Change Icon" />Perubahan Barang
                    <img src="/asset/tutup.png" alt="Toggle Arrow" class="toggle-icon" />
                </a>
              <ul class="dropdown-content">
                <li><a href="{{ route('upgradebarang.index') }}">Upgrade Barang</a></li>
                <li><a href="{{ route('user.perbaikan') }}">Perbaikan Barang</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropbtn">
                <img src="/asset/transaksi.png" alt="Activity Icon" />Aktivitas Barang
                <img src="/asset/tutup.png" alt="Toggle Arrow" class="toggle-icon" />
              </a>
              <ul class="dropdown-content">
                <li><a href="{{ route('user.peminjaman') }}">Peminjaman</a></li>
                <li><a href="{{ route('user.pengembalian') }}">Riwayat Peminjaman</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="active">
                <img src="/asset/pengaturan.png" alt="Settings Icon" />Pengaturan
                <img src="/asset/tutup.png" alt="Toggle Arrow" class="toggle-icon" />
              </a>
              <ul class="dropdown-content">
                <li><a href="{{ route('user.profile')}}">Profile</a></li>
              </ul>
            </li>
            <li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <img src="/asset/logout.png" alt="Logout Icon" /> Log Out
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
                    <img src="/asset/useraicon.png" alt="User Icon" class="user-icon" />
                    <div class="text-info">
                        <span class="username">{{ $user->name }}</span>
                        <span class="role">{{ $user->role }}</span>
                    </div>
                </div>
            </div>
            <br />
            <div class="header-content">
                <h1>Edit Profil</h1>
            </div>
        </div>
        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="profile-card">
                <div class="profile-avatar">
                    @if($user->profile_picture)
                        <img src="{{ asset('uploads/profile_pictures/' . $user->profile_picture) }}" alt="Profile Avatar" />
                    @else
                        <img src="{{ asset('uploads/profile_pictures/default.png') }}" alt="Default Avatar" />
                    @endif
                </div>
                <div class="form-group">
                    <label for="profile_picture">Upload Foto Profil</label>
                    <input type="file" name="profile_picture" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" name="name" value="{{ $user->name }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" required>
                </div>
                <div class="form-group">
                    <label for="password">Password (Opsional)</label>
                    <input type="password" name="password">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation">
                </div>
                <div class="profile-actions">
                    <button type="submit" class="action-btn edit">Simpan Perubahan</button>
                    <a href="{{ route('user.profile') }}" class="action-btn cancel">Batal</a> <!-- Tambahkan button batal -->
                </div>
            </div>
        </form>
    </div>
</body>
</html>
