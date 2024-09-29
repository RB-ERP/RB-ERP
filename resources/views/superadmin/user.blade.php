<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User - InvenTrack</title>
    <link rel="stylesheet" href="/css/user.css" />
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
          <a href="#" class="active" class="dropbtn">
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
          <h1>User</h1>
          <input type="text" class="search-bar" placeholder="Search Bar" />
        </div>
      </div>

      <div class="data-barang-actions">
        <button class="btn-filter"><img src="/asset/filter.png" alt="filter icon" />Filter</button>
        <button class="btn-tambah">
            <img src="/asset/tambah.png" alt="Add Icon" />Tambah User Baru
        </button>
      </div>

      <table class="data-barang-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Nama Lengkap</th>
                <th>Role</th>
                <th>Password</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $index => $user)
            <tr>
                <td>{{ $users->firstItem() + $index }}</td> <!-- Menampilkan nomor urut -->
                <td>{{ $user->username }}</td> <!-- Menampilkan username -->
                <td>{{ $user->name }}</td> <!-- Menampilkan nama pengguna -->
                <td>{{ ucfirst($user->role) }}</td> <!-- Menampilkan role pengguna dengan huruf kapital di awal -->
                <td>******</td> <!-- Menyembunyikan password -->
                <td>
                    <!-- Tombol Edit -->
                    <a href="{{ route('user.edit', $user->id) }}">
                        <img src="/asset/edit.png" alt="Edit Icon" class="action-icon" />
                    </a>
                    <!-- Tombol Delete -->
                    <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="border: none; background: none;">
                            <img src="/asset/delete.png" alt="Delete Icon" class="action-icon" />
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination">
        {{ $users->links() }}
    </div>


        <!-- Modal Tambah User Baru -->
        <div id="userModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Tambah User</h2>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select id="role" name="role" required>
                            <option value="super_admin">Super Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Ulangi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required>
                    </div>
                    <button type="submit" class="btn-save">Save</button>
                    <button type="button" class="btn-cancel">Cancel</button>
                </form>
            </div>
        </div>

    <script>
        // Get modal element
        var modal = document.getElementById("userModal");

        // Get the button that opens the modal
        var btn = document.querySelector(".btn-tambah");

        // Get the <span> element that closes the modal
        var span = document.querySelector(".close");

        // When the user clicks the button, open the modal
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
            modal.style.display = "none";
            }
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
  </body>
</html>
