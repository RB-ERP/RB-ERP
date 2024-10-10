<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Notifikasi</title>
    <link rel="stylesheet" href="/css/peminjaman.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .notification-content {
            padding: 20px;
            background-color: #f9fafb;
            border-radius: 8px;
        }

        .notification-header {
            font-size: 28px;
            font-weight: bold;
            margin-block: 10px;
            color: #374151;
        }

        .notification-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #374151;
        }

        .notification-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .notification-item {
            display: flex;
            /* align-items: center; */
            background-color: white;
            padding: 15px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .notification-icon {
            font-size: 40px;
            color: #6b7280;
            margin-right: 20px;
        }

        .notification-details {
            flex-grow: 1;
        }

        .notification-title {
            font-size: 16px;
            font-weight: bold;
            color: #1f2937;
        }

        .notification-time {
            font-size: 14px;
            color: #6b7280;
            margin-top: 4px;
        }

        .notification-description {
            font-size: 14px;
            color: #4b5563;
            margin-top: 4px;
        }

        .notification-status {
            background-color: #3b82f6;
            color: white;
            font-size: 12px;
            padding: 6px 12px;
            border-radius: 12px;
            text-transform: uppercase;
            font-weight: bold;
            height: fit-content;
        }

        .notification-actions {
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }

        .accept-btn,
        .reject-btn {
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .accept-btn {
            background-color: #34d399;
            /* Warna hijau untuk tombol Terima */
            color: white;
        }

        .accept-btn:hover {
            background-color: #059669;
            /* Warna lebih gelap saat hover */
        }

        .reject-btn {
            background-color: #f87171;
            /* Warna merah untuk tombol Tolak */
            color: white;
        }

        .reject-btn:hover {
            background-color: #e11d48;
            /* Warna lebih gelap saat hover */
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            text-align: center;
        }

        .modal-actions {
            margin-top: 20px;
            display: flex;
            justify-content: space-around;
        }

        .close {
            position: absolute;
            right: 10px;
            top: 10px;
            font-size: 18px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <!-- Modal Konfirmasi -->
    <div id="confirmationModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Konfirmasi</h2>
            <p id="confirmationMessage">Apakah Anda ycakin ingin menerima peminjaman dari <b></b>?</p>
            <div class="modal-actions">
                <button class="accept-btn" id="confirmAcceptBtn">Ya</button>
                <button class="reject-btn" id="cancelBtn">Tidak</button>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Penolakan -->
    <div id="rejectModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Konfirmasi Penolakan</h2>
            <p id="rejectMessage">Apakah Anda yakin ingin menolak permintaan dari <b></b>?</p>
            <div class="modal-actions">
                <button class="reject-btn" id="confirmRejectBtn">Ya</button>
                <button class="accept-btn" id="cancelRejectBtn">Tidak</button>
            </div>
        </div>
    </div>


    {{-- side bar --}}
    <div class="sidebar">
        <div class="logo">
            <img src="/asset/rb_putih.png" alt="Logo" />
            <h2>InvenTrack</h2>
        </div>
        <!-- Sidebar content with dropdown -->
        <ul>
            <li>
                <a href="{{ route('superadmin.dashboard') }}"> <img src="/asset/dashboard.png"
                        alt="Dashboard Icon" />Dashboard </a>
            </li>
            <li>
                <a href="{{ route('superadmin.databarang') }}"> <img src="/asset/databarang.png" alt="Data Icon" />Data
                    Barang </a>
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
                    <li><a href="{{ route('superadmin.pengembalian') }}">Riwayat Peminjaman</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropbtn">
                    <img src="/asset/laporan.png" alt="Report Icon" />Laporan
                    <img src="/asset/tutup.png" alt="Toggle Arrow" class="toggle-icon" />
                </a>
                <ul class="dropdown-content">
                    <li><a href="{{ route('superadmin.laporanperbaikan') }}">Laporan Perbaikan</a></li>
                    <li><a href="laporanupgrade.html">Laporan Upgrade</a></li>
                    <li><a href="laporanpembaruan.html">Laporan Pembaruan</a></li>
                </ul>
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
                <a href="index.html" class="logout"> <img src="/asset/logout.png" alt="Logout Icon" />Log Out
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
                    <a href="/notifikasi" class="notification-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="23" viewBox="0 0 20 23"
                            fill="none">
                            <path
                                d="M19.1062 15.7071C19.0219 15.6056 18.9391 15.504 18.8578 15.406C17.7407 14.0547 17.0648 13.2392 17.0648 9.41383C17.0648 7.43336 16.591 5.80836 15.6571 4.58961C14.9685 3.68926 14.0377 3.00625 12.8108 2.50148C12.795 2.4927 12.7809 2.48118 12.7692 2.46746C12.3279 0.989726 11.1203 0 9.75835 0C8.3964 0 7.18933 0.989726 6.74804 2.46594C6.73628 2.47917 6.72237 2.49033 6.7069 2.49895C3.84386 3.67758 2.45245 5.93887 2.45245 9.4123C2.45245 13.2392 1.77757 14.0547 0.659366 15.4045C0.578116 15.5025 0.495342 15.602 0.411046 15.7056C0.193296 15.9682 0.0553337 16.2877 0.013486 16.6263C-0.0283616 16.9648 0.0276571 17.3083 0.174913 17.616C0.488233 18.2762 1.15601 18.686 1.91823 18.686H17.6041C18.3627 18.686 19.0259 18.2767 19.3403 17.6196C19.4882 17.3118 19.5447 16.968 19.5032 16.6291C19.4617 16.2901 19.3239 15.9702 19.1062 15.7071ZM9.75835 22.75C10.4922 22.7494 11.2121 22.5502 11.8419 22.1736C12.4716 21.7969 12.9877 21.2568 13.3354 20.6106C13.3518 20.5796 13.3598 20.5449 13.3589 20.5099C13.3579 20.4749 13.3479 20.4407 13.3298 20.4107C13.3117 20.3807 13.2861 20.3559 13.2556 20.3387C13.2251 20.3215 13.1906 20.3125 13.1556 20.3125H6.3621C6.32702 20.3124 6.29251 20.3213 6.26193 20.3385C6.23134 20.3557 6.20573 20.3805 6.18758 20.4105C6.16942 20.4405 6.15935 20.4747 6.15835 20.5098C6.15734 20.5449 6.16543 20.5796 6.18183 20.6106C6.52944 21.2567 7.04544 21.7968 7.6751 22.1734C8.30477 22.5501 9.02463 22.7493 9.75835 22.75Z"
                                fill="#0089D0" />
                        </svg>
                    </a>
                    <div style="display: flex; align-items: center;">
                        <img src="/asset/useraicon.png" alt="User Icon" class="user-icon" />
                        <div class="text-info">
                            <span class="username">{{ Auth::user()->name }}</span>
                            <span class="role">{{ Auth::user()->role }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <br />
            <div class="notification-content">
                <h1 class="notification-header">Notification</h1>

                <!-- Notifikasi Belum Dibaca -->
                <h2 style="color: #eb2525">Belum Dibaca</h2>
                <div class="notification-list">
                    @foreach ($notifikasiBelumDibaca as $notif)
                        <div class="notification-item" data-id="{{ $notif->id }}">
                            <div class="notification-icon">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <div class="notification-details">
                                <h3 class="notification-title">{{ $notif->tipe }}</h3>
                                <p class="notification-time">{{ $notif->created_at->format('d M Y | H:i A') }}</p>
                                <p class="notification-description">
                                    @if ($notif->tipe == 'Pengajuan Peminjaman')
                                        Peminjaman barang oleh <b>"{{ $notif->nama_peminjam }}"</b> sedang menunggu
                                        persetujuan
                                    @elseif ($notif->tipe == 'Pengajuan Pengembalian')
                                        Pengembalian barang oleh <b>"{{ $notif->nama_peminjam }}"</b> sedang menunggu
                                        persetujuan
                                    @endif
                                </p>
                                <div class="notification-actions">
                                    @if ($notif->tipe == 'Pengajuan Peminjaman')
                                        <button class="accept-btn">Terima</button>
                                        <button class="reject-btn">Tolak</button>
                                    @elseif ($notif->tipe == 'Pengajuan Pengembalian')
                                        <button class="accept-btn">Terima</button>
                                    @endif

                                </div>
                            </div>
                            <span class="notification-status">Baru</span>
                        </div>
                    @endforeach
                </div>

                <!-- Pemisah antar status -->
                <br><br>
                <hr>

                <!-- Notifikasi Dibaca -->
                <h2 style="margin-block: 8px; color: #2563eb">Dibaca</h2>
                <div class="notification-list">
                    @foreach ($notifikasiDibaca as $notif)
                        <div class="notification-item" data-id="{{ $notif->id }}">
                            <div class="notification-icon">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <div class="notification-details">
                                <h3 class="notification-title">{{ $notif->tipe }}</h3>
                                <p class="notification-time">{{ $notif->created_at->format('d M Y | H:i A') }}</p>
                                <p class="notification-description">
                                    @if ($notif->tipe == 'Pengajuan Peminjaman')
                                        Peminjaman barang oleh <b>"{{ $notif->nama_peminjam }}"</b> sudah diproses
                                    @elseif ($notif->tipe == 'Pengajuan Pengembalian')
                                        Pengembalian barang oleh <b>"{{ $notif->nama_peminjam }}"</b> sudah diproses
                                    @endif
                                </p>
                            </div>
                            <span class="notification-status">Dibaca</span>
                        </div>
                    @endforeach
                </div>
            </div>


            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Ambil elemen modal dan elemen lainnya
                    var modal = document.getElementById("confirmationModal");
                    var confirmMessage = document.getElementById("confirmationMessage");
                    var closeBtn = document.querySelector('.close');
                    var cancelBtn = document.getElementById('cancelBtn');
                    var confirmAcceptBtn = document.getElementById('confirmAcceptBtn');

                    // Variabel untuk menyimpan ID notifikasi yang sedang diproses
                    var currentNotifikasiId = null;

                    // Ambil semua tombol "Terima" di dalam notifikasi
                    var acceptButtons = document.querySelectorAll('.notification-item .accept-btn');

                    // Loop setiap tombol "Terima" di dalam notifikasi
                    acceptButtons.forEach(function(button) {
                        button.addEventListener('click', function(event) {
                            event.preventDefault();

                            // Ambil nama peminjam dan ID notifikasi dari elemen terdekat
                            var notificationItem = this.closest('.notification-item');
                            var namaPeminjam = notificationItem.querySelector('.notification-description b')
                                .innerText;
                            currentNotifikasiId = notificationItem.getAttribute('data-id');

                            // Set pesan konfirmasi dengan nama peminjam
                            confirmMessage.innerHTML =
                                `Apakah Anda yakin ingin menerima permintaan dari <b>${namaPeminjam}</b>?`;

                            // Tampilkan modal konfirmasi
                            modal.style.display = "flex";
                        });
                    });

                    // Tutup modal saat tombol close atau cancel diklik
                    closeBtn.onclick = function() {
                        modal.style.display = "none";
                    }

                    cancelBtn.onclick = function() {
                        modal.style.display = "none";
                    }

                    // Saat tombol "Ya" di modal diklik
                    confirmAcceptBtn.onclick = function() {
                        if (currentNotifikasiId) {
                            // Kirimkan request menggunakan fetch
                            fetch('{{ route('notifikasi.accept') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        notifikasi_id: currentNotifikasiId
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    alert(data.message);
                                    modal.style.display = "none";
                                    // Refresh halaman untuk menampilkan update notifikasi
                                    location.reload();
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('Terjadi kesalahan.');
                                });
                        }
                    };

                    // Tutup modal jika klik di luar modal
                    window.onclick = function(event) {
                        if (event.target == modal) {
                            modal.style.display = "none";
                        }
                    }
                });
            </script>


            <script>
                // Ambil elemen modal untuk penolakan
                var rejectModal = document.getElementById("rejectModal");
                var rejectMessage = document.getElementById("rejectMessage");

                // Ambil tombol "Tolak"
                var rejectButtons = document.querySelectorAll('.reject-btn');

                // Ambil tombol untuk menutup modal penolakan
                var closeRejectBtn = document.querySelector('#rejectModal .close');
                var cancelRejectBtn = document.getElementById('cancelRejectBtn');
                var confirmRejectBtn = document.getElementById('confirmRejectBtn');

                // Loop semua tombol "Tolak"
                rejectButtons.forEach(function(button) {
                    button.addEventListener('click', function(event) {
                        event.preventDefault();
                        var notificationItem = this.closest('.notification-item');
                        var namaPeminjam = notificationItem.querySelector('.notification-description b').innerText;
                        currentNotifikasiId = notificationItem.getAttribute(
                            'data-id'); // Perbarui currentNotifikasiId

                        rejectMessage.innerHTML =
                            `Apakah Anda yakin ingin menolak permintaan dari <b>${namaPeminjam}</b>?`;

                        // Tampilkan modal penolakan
                        rejectModal.style.display = "flex";
                    });
                });


                // Tutup modal jika klik tombol close atau cancel
                closeRejectBtn.onclick = function() {
                    rejectModal.style.display = "none";
                }

                cancelRejectBtn.onclick = function() {
                    rejectModal.style.display = "none";
                }

                // Konfirmasi tolak
                confirmRejectBtn.onclick = function() {
                    if (currentNotifikasiId) {
                        // Kirimkan request menggunakan fetch untuk memperbarui status barang dan notifikasi
                        fetch('{{ route('notifikasi.reject') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    notifikasi_id: currentNotifikasiId
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                alert(data.message); // Tampilkan alert setelah berhasil
                                rejectModal.style.display = "none";
                                // Refresh halaman untuk menampilkan update notifikasi
                                location.reload();
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Terjadi kesalahan.');
                            });
                    }
                };


                // Tutup modal jika klik di luar modal penolakan
                window.onclick = function(event) {
                    if (event.target == rejectModal) {
                        rejectModal.style.display = "none";
                    }
                }

                document.addEventListener('DOMContentLoaded', function() {
                    // Ambil elemen modal dan elemen lainnya
                    var modal = document.getElementById("confirmationModal");
                    var confirmMessage = document.getElementById("confirmationMessage");
                    var closeBtn = document.querySelector('.close');
                    var cancelBtn = document.getElementById('cancelBtn');
                    var confirmAcceptBtn = document.getElementById('confirmAcceptBtn');

                    // Variabel untuk menyimpan ID notifikasi dan tipe yang sedang diproses
                    var currentNotifikasiId = null;
                    var currentTipe = null;

                    // Ambil semua tombol "Terima" di dalam notifikasi
                    var acceptButtons = document.querySelectorAll('.notification-item .accept-btn');

                    // Loop setiap tombol "Terima" di dalam notifikasi
                    acceptButtons.forEach(function(button) {
                        button.addEventListener('click', function(event) {
                            event.preventDefault();

                            // Ambil nama peminjam dan ID notifikasi dari elemen terdekat
                            var notificationItem = this.closest('.notification-item');
                            var namaPeminjam = notificationItem.querySelector('.notification-description b')
                                .innerText;
                            currentNotifikasiId = notificationItem.getAttribute('data-id');
                            currentTipe = notificationItem.querySelector('.notification-title')
                                .innerText; // Ambil tipe notifikasi

                            // Set pesan konfirmasi dengan nama peminjam
                            confirmMessage.innerHTML =
                                `Apakah Anda yakin ingin menerima permintaan dari <b>${namaPeminjam}</b>?`;

                            // Tampilkan modal konfirmasi
                            modal.style.display = "flex";
                        });
                    });

                    // Tutup modal saat tombol close atau cancel diklik
                    closeBtn.onclick = function() {
                        modal.style.display = "none";
                    }

                    cancelBtn.onclick = function() {
                        modal.style.display = "none";
                    }

                    // Saat tombol "Ya" di modal diklik
                    confirmAcceptBtn.onclick = function() {
                        if (currentNotifikasiId && currentTipe) {
                            let url = ''; // Variable for the fetch URL based on type
                            let message = ''; // Variable for the success message

                            if (currentTipe === 'Pengajuan Peminjaman') {
                                // Pengajuan peminjaman
                                url = '{{ route('notifikasi.accept') }}'; // Route peminjaman
                                message = 'Peminjaman diterima dan status barang diperbarui.';
                            } else if (currentTipe === 'Pengajuan Pengembalian') {
                                // Pengajuan pengembalian
                                url = '{{ route('notifikasi.return') }}'; // Route pengembalian
                                message = 'Pengembalian diterima dan status barang diperbarui.';
                            }

                            fetch(url, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        notifikasi_id: currentNotifikasiId
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    alert(message);
                                    modal.style.display = "none";
                                    location.reload(); // Refresh halaman
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('Terjadi kesalahan.');
                                });
                        }
                    };

                    // Tutup modal jika klik di luar modal
                    window.onclick = function(event) {
                        if (event.target == modal) {
                            modal.style.display = "none";
                        }
                    }
                });
            </script>

</body>

</html>
