<head>
    <link rel="stylesheet" href="{{ asset('css/formdatabarangbaru.css') }}">
</head>

<div class="form-container">
    <h2>Edit Perubahan Barang</h2>
    <form action="{{ route('admin.perubahan.update', $barang->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama_barang">Nama Barang <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="{{ $barang->nama_barang }}" required>
        </div>

        <div class="form-group">
            <label for="kode_barang">Kode Barang <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="kode_barang" name="kode_barang" value="{{ $barang->kode_barang }}" required>
        </div>

        <div class="form-group">
            <label for="tanggal_pembelian">Tanggal Pembelian <span class="text-danger">*</span></label>
            <input type="date" class="form-control" id="tanggal_pembelian" name="tanggal_pembelian" value="{{ $barang->tanggal_pembelian }}" required>
        </div>

        <div class="form-group">
            <label for="spesifikasi">Spesifikasi <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="spesifikasi" name="spesifikasi" value="{{ $barang->spesifikasi }}" required>
        </div>

        <div class="form-group">
            <label for="harga">Harga <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="harga" name="harga" value="{{ $barang->harga }}" required>
        </div>

        <div class="form-group">
            <label for="status">Status <span class="text-danger">*</span></label>
            <select class="form-control" id="status" name="status" required>
                <option value="Tersedia" {{ $barang->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="Dipinjam" {{ $barang->status == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                <option value="Rusak" {{ $barang->status == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                <option value="Diperbaiki" {{ $barang->status == 'Diperbaiki' ? 'selected' : '' }}>Diperbaiki</option>
            </select>
        </div>

        <!-- Tambahan kolom Keterangan -->
        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea class="form-control" id="keterangan" name="keterangan">{{ old('keterangan', $barang->keterangan) }}</textarea>
        </div>

        <div class="form-group">
            <label for="tanggal_perubahan">Tanggal Perubahan</label>
            <input type="date" name="tanggal_perubahan" class="form-control" id="tanggal_perubahan" value="{{ $barang->tanggal_perubahan }}">
        </div>

        <div class="form-group">
            <label for="jenis_perubahan">Jenis Perubahan</label>
            <select name="jenis_perubahan" class="form-control" id="jenis_perubahan">
                <option value="">-- Pilih --</option>
                <option value="Upgrade" {{ $barang->jenis_perubahan == 'Upgrade' ? 'selected' : '' }}>Upgrade</option>
                <option value="Perbaikan" {{ $barang->jenis_perubahan == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>
            </select>
        </div>

        <div class="form-group">
            <label for="deskripsi_perubahan">Deskripsi Perubahan</label>
            <textarea name="deskripsi_perubahan" class="form-control" id="deskripsi_perubahan">{{ $barang->deskripsi_perubahan }}</textarea>
        </div>

        <div class="form-group">
            <label for="biaya_perubahan">Biaya Perubahan</label>
            <input type="number" name="biaya_perubahan" class="form-control" id="biaya_perubahan" value="{{ $barang->biaya_perubahan }}">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ url('admin/perubahandatabrg') }}'">Cancel</button>
        </div>
    </form>
</div>
