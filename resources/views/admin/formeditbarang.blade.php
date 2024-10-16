<head>
    <link rel="stylesheet" href="{{ asset('css/formdatabarangbaru.css') }}">
</head>

<div class="form-container">
    <h2>Edit Barang</h2>
    <form action="{{ route('admin.barang.update', $barang->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nama_barang">Nama Barang</label>
            <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="{{ $barang->nama_barang }}" required>
        </div>

        <div class="form-group">
            <label for="kode_barang">Kode Barang</label>
            <input type="text" class="form-control" id="kode_barang" name="kode_barang" value="{{ $barang->kode_barang }}" required>
        </div>

        <div class="form-group">
            <label for="serial_number">Serial Number</label>
            <input type="text" class="form-control" id="serial_number" name="serial_number" value="{{ $barang->serial_number}}" required>
        </div>

        <div class="form-group">
            <label for="tanggal_pembelian">Tanggal Pembelian</label>
            <input type="date" class="form-control" id="tanggal_pembelian" name="tanggal_pembelian" value="{{ $barang->tanggal_pembelian }}" required>
        </div>

        <div class="form-group">
            <label for="spesifikasi">Spesifikasi</label>
            <input type="text" class="form-control" id="spesifikasi" name="spesifikasi" value="{{ $barang->spesifikasi }}" required>
        </div>

        <div class="form-group">
            <label for="harga">Harga</label>
            <input type="number" class="form-control" id="harga" name="harga" value="{{ $barang->harga }}" required>
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

        <!-- Kondisi jika source dari perubahan barang -->
        @if($source == 'perubahan')
            <div class="form-group">
                <label for="tanggal_perubahan">Tanggal Perubahan</label>
                <input type="date" class="form-control" id="tanggal_perubahan" name="tanggal_perubahan" value="{{ $barang->tanggal_perubahan }}">
            </div>

            <div class="form-group">
                <label for="jenis_perubahan">Jenis Perubahan</label>
                <select class="form-control" id="jenis_perubahan" name="jenis_perubahan">
                    <option value="">-- Pilih --</option>
                    <option value="Upgrade" {{ $barang->jenis_perubahan == 'Upgrade' ? 'selected' : '' }}>Upgrade</option>
                    <option value="Perbaikan" {{ $barang->jenis_perubahan == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="deskripsi_perubahan">Deskripsi Perubahan</label>
                <textarea class="form-control" id="deskripsi_perubahan" name="deskripsi_perubahan">{{ $barang->deskripsi_perubahan }}</textarea>
            </div>

            <div class="form-group">
                <label for="biaya_perubahan">Biaya Perubahan</label>
                <input type="number" class="form-control" id="biaya_perubahan" name="biaya_perubahan" value="{{ $barang->biaya_perubahan }}">
            </div>
        @endif


        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.databarang') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
