<head>
    <link rel="stylesheet" href="{{ asset('css/formdatabarangbaru.css') }}">
</head>

<div class="form-container">
    <h2>Edit Barang</h2>
    <form action="{{ route('superadmin.barang.update', $barang->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama_barang">Nama Barang</label>
            <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                   value="{{ $barang->nama_barang }}" required>
        </div>

        <div class="form-group">
            <label for="kode_barang">Kode Barang</label>
            <input type="text" class="form-control" id="kode_barang" name="kode_barang"
                   value="{{ $barang->kode_barang }}" required>
        </div>

        <div class="form-group">
            <label for="serial_number">Serial Number</label>
            <input type="text" class="form-control" id="serial_number" name="serial_number"
                   value="{{ $barang->serial_number }}" required>
        </div>

        <div class="form-group">
            <label for="tanggal_pembelian">Tanggal Pembelian</label>
            <input type="date" class="form-control" id="tanggal_pembelian" name="tanggal_pembelian"
                   value="{{ $barang->tanggal_pembelian }}" required>
        </div>

        <div class="form-group">
            <label for="spesifikasi">Spesifikasi</label>
            <input type="text" class="form-control" id="spesifikasi" name="spesifikasi"
                   value="{{ $barang->spesifikasi }}" required>
        </div>

        <div class="form-group">
            <label for="harga">Harga</label>
            <input type="number" class="form-control" id="harga" name="harga"
                   value="{{ $barang->harga }}" required>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status">
                <option value="Tersedia" {{ $barang->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="Dipinjam" {{ $barang->status == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                <option value="Rusak" {{ $barang->status == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                <option value="Diperbaiki" {{ $barang->status == 'Diperbaiki' ? 'selected' : '' }}>Diperbaiki</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('superadmin.databarang') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
