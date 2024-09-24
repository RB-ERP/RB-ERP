<head>
    <link rel="stylesheet" href="{{ asset('css/formdatabarangbaru.css') }}">
</head>

<div class="form-container">
    <h2>Data Baru</h2>
    <form action="{{ route('barang.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama_barang">Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" id="nama_barang" placeholder="Masukan Nama Barang">
        </div>

        <div class="form-group">
            <label for="kode_barang">Kode Barang</label>
            <input type="text" name="kode_barang" class="form-control" id="kode_barang" placeholder="Masukan Kode Barang">
        </div>

        <div class="form-group">
            <label for="serial_number">Serial Number</label>
            <input type="text" name="serial_number" class="form-control" id="serial_number" placeholder="Masukkan Serial Number">
        </div>

        <div class="form-group">
            <label for="tanggal_pembelian">Tanggal Pembelian</label>
            <input type="date" name="tanggal_pembelian" class="form-control" id="tanggal_pembelian" required>
        </div>

        <div class="form-group">
            <label for="spesifikasi">Spesifikasi</label>
            <input type="text" name="spesifikasi" class="form-control" id="spesifikasi" placeholder="Masukan Spesifikasi Barang">
        </div>

        <div class="form-group">
            <label for="harga">Harga</label>
            <input type="number" name="harga" class="form-control" id="harga" required>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" class="form-control" id="status" required>
                <option value="Tersedia">Tersedia</option>
                <option value="Dipinjam">Dipinjam</option>
                <option value="Rusak">Rusak</option>
                <option value="Diperbaiki">Diperbaiki</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">Simpan</button>
            <a href="{{ route('superadmin.databarang') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>
