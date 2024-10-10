<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Perubahan Data Barang - InvenTrack</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="/css/perubahandatabrg.css" />
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
              <a href="{{ route('user.dashboard') }}"> <img src="/asset/dashboard.png" alt="Dashboard Icon" />Dashboard </a>
          </li>
          <li>
              <a href="{{ route('user.databarang') }}" > <img src="/asset/databarang.png" alt="Data Icon" />Data Barang </a>
          </li>
          <li class="dropdown">
              <a href="{{ route('user.perubahandatabrg') }}" class="active" class="dropbtn">
                  <img src="/asset/perubahanbarang.png" alt="Change Icon" />Perubahan Barang
                  <img src="/asset/tutup.png" alt="Toggle Arrow" class="toggle-icon" />
              </a>
            <ul class="dropdown-content">
              <li><a href="{{ route('user.upgradebarang') }}">Upgrade Barang</a></li>
              <li><a href="{{ route('user.perbaikan') }}">Perbaikan Barang</a></li>
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
              <img src="/asset/pengaturan.png" alt="Settings Icon" />Pengaturan
              <img src="/asset/tutup.png" alt="Toggle Arrow" class="toggle-icon" />
            </a>
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
            <img src="{{ asset($user->profile_picture ? 'uploads/profile_pictures/' . $user->profile_picture : 'default-avatar.png') }}" alt="Profile Picture" class="user-icon">
            <div class="text-info">
              <span class="username">{{ Auth::user()->name }}</span>
              <span class="role">{{ Auth::user()->role }}</span>
            </div>
          </div>
        </div>
        <br />
        <div class="header-content">
          <h1>Perubahan Data Barang</h1>
          <div class="search-filter-container">
            <input type="text" id="searchInput" class="search-bar" placeholder="Search Bar" onkeyup="searchFunction()">
            <select id="filterCriteria" onchange="toggleDateFilter()">
              <option value="nama">Nama Barang</option>
              <option value="tanggal">Tanggal Pembelian</option>
            </select>
            <div id="dateFilter" style="display: none;">
              <label for="startDate">Mulai:</label>
              <input type="date" id="startDate" onchange="searchFunction()">
              <label for="endDate">Selesai:</label>
              <input type="date" id="endDate" onchange="searchFunction()">
            </div>
          </div>
        </div>

        <div class="data-barang-actions">
          <button class="btn-pdf" onclick="window.location.href='{{ route('perubahanbarang.pdf') }}'">
            <img src="/asset/pdf.png" alt="PDF Icon" />Cetak PDF
          </button>
        </div>

        <table class="data-barang-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Barang</th>
              <th>Kode Barang</th>
              <th>Status</th>
              <th>Keterangan</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($barangs as $barang)
            <tr>
              <td>{{ ($barangs->currentPage() - 1) * $barangs->perPage() + $loop->iteration }}</td>
              <td>
                <a href="javascript:void(0)" class="barang-detail"
                   data-nama="{{ $barang->nama_barang }}"
                   data-kode="{{ $barang->kode_barang }}"
                   data-serial="{{ $barang->serial_number }}"
                   data-tanggal="{{ $barang->tanggal_pembelian }}"
                   data-spesifikasi="{{ $barang->spesifikasi }}"
                   data-harga="{{ $barang->harga }}"
                   data-status="{{ $barang->status }}"
                   data-keterangan="{{ $barang->keterangan }}"
                   data-tanggal-perubahan="{{ $barang->tanggal_perubahan }}"
                   data-jenis-perubahan="{{ $barang->jenis_perubahan }}"
                   data-deskripsi-perubahan="{{ $barang->deskripsi_perubahan }}"
                   data-biaya-perubahan="{{ $barang->biaya_perubahan }}">
                   {{ $barang->nama_barang }}
                </a>
              </td>
              <td>{{ $barang->kode_barang }}</td>
              <td><span class="status {{ strtolower($barang->status) }}">{{ $barang->status }}</span></td>
              <td>{{ $barang->keterangan }}</td>
              <td>
                @if (Auth::user()->role == 'super_admin')
                   <!-- Tombol Edit -->
                   <a href="{{ route('perubahan.edit', ['id' => $barang->id, 'source' => 'perubahan']) }}">
                      <img src="/asset/edit.png" alt="Edit Icon" class="action-icon" />
                   </a>

                   <!-- Tombol Hapus -->
                   <form id="delete-form-{{ $barang->id }}" action="{{ route('barang.destroy', $barang->id) }}" method="POST" style="display: inline;">
                       @csrf
                       @method('DELETE')
                       <input type="hidden" name="source" value="perubahan">
                       <button type="button" style="border: none; background: none;" onclick="confirmDelete({{ $barang->id }})">
                           <img src="/asset/delete.png" alt="Delete Icon" class="action-icon" />
                       </button>
                   </form>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>

        <!-- Modal structure -->
        <div id="detailModal" class="modal">
          <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Detail Barang</h2>
            <p><strong>Nama Barang:</strong> <span id="modalNamaBarang"></span></p>
            <p><strong>Kode Barang:</strong> <span id="modalKodeBarang"></span></p>
            <p><strong>Serial Number:</strong> <span id="modalSerialNumber"></span></p>
            <p><strong>Tanggal Pembelian:</strong> <span id="modalTanggalPembelian"></span></p>
            <p><strong>Spesifikasi:</strong> <span id="modalSpesifikasi"></span></p>
            <p><strong>Harga:</strong> <span id="modalHarga"></span></p>
            <p><strong>Status:</strong> <span id="modalStatus"></span></p>
            <p><strong>Keterangan:</strong> <span id="modalKeterangan"></span></p>
            <p><strong>Tanggal Perubahan:</strong> <span id="modalTanggalPerubahan"></span></p>
            <p><strong>Jenis Perubahan:</strong> <span id="modalJenisPerubahan"></span></p>
            <p><strong>Deskripsi Perubahan:</strong> <span id="modalDeskripsiPerubahan"></span></p>
            <p><strong>Biaya Perubahan:</strong> <span id="modalBiayaPerubahan"></span></p>
          </div>
        </div>

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

        @if(session('success'))
        <script>
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}'
          });
        </script>
        @endif

        @if(session('error'))
        <script>
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}'
          });
        </script>
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
          $(document).ready(function() {
            $('.barang-detail').on('click', function() {
              $('#modalNamaBarang').text($(this).data('nama'));
              $('#modalKodeBarang').text($(this).data('kode'));
              $('#modalSerialNumber').text($(this).data('serial'));
              $('#modalTanggalPembelian').text($(this).data('tanggal'));
              $('#modalSpesifikasi').text($(this).data('spesifikasi'));
              $('#modalHarga').text("Rp " + parseFloat($(this).data('harga')).toLocaleString());
              $('#modalStatus').text($(this).data('status'));
              $('#modalKeterangan').text($(this).data('keterangan'));
              $('#modalTanggalPerubahan').text($(this).data('tanggal-perubahan'));
              $('#modalJenisPerubahan').text($(this).data('jenis-perubahan'));
              $('#modalDeskripsiPerubahan').text($(this).data('deskripsi-perubahan'));
              $('#modalBiayaPerubahan').text("Rp " + parseFloat($(this).data('biaya-perubahan')).toLocaleString());
              $('#detailModal').fadeIn();
            });

            $('.close').on('click', function() {
              $('#detailModal').fadeOut();
            });

            $(window).on('click', function(e) {
              if ($(e.target).is('#detailModal')) {
                $('#detailModal').fadeOut();
              }
            });
          });

          function confirmDelete(id) {
            Swal.fire({
              title: 'Apakah kamu yakin?',
              text: "Data yang dihapus tidak dapat dikembalikan!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ya, hapus!',
              cancelButtonText: 'Batal'
            }).then((result) => {
              if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
              }
            });
          }
        </script>
      </div>
    </div>
  </body>
</html>