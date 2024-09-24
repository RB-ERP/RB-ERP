<head>
    <link rel="stylesheet" href="{{ asset('css/formtambahdataperubahanbarang.css') }}" />
</head>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2>Edit Perubahan Data Barang</h2>
                </div>
                <div class="card-body">
                    @if(isset($barang))
                    <form action="{{ route('perubahan.update', $barang->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Informasi Barang -->
                        <label>Nama Barang</label>
                        <input type="text" name="nama_barang" value="{{ $barang->nama_barang }}" required readonly>

                        <label>Kode Barang</label>
                        <input type="text" name="kode_barang" value="{{ $barang->kode_barang }}" required readonly>

                        <label>Tanggal Pembelian</label>
                        <input type="date" name="tanggal_pembelian" value="{{ $barang->tanggal_pembelian }}" required readonly>

                        <label>Spesifikasi</label>
                        <input type="text" name="spesifikasi" value="{{ $barang->spesifikasi }}" required readonly>

                        <label>Harga</label>
                        <input type="number" name="harga" value="{{ $barang->harga }}" required readonly>

                        <label>Status</label>
                        <select name="status" disabled>
                            <option value="Tersedia" @if($barang->status == 'Tersedia') selected @endif>Tersedia</option>
                            <option value="Dipinjam" @if($barang->status == 'Dipinjam') selected @endif>Dipinjam</option>
                            <option value="Rusak" @if($barang->status == 'Rusak') selected @endif>Rusak</option>
                            <option value="Diperbaiki" @if($barang->status == 'Diperbaiki') selected @endif>Diperbaiki</option>
                        </select>

                        <!-- Kolom Perubahan -->
                        <label>Tanggal Perubahan</label>
                        <input type="date" name="tanggal_perubahan" value="{{ $barang->tanggal_perubahan }}">

                        <label>Jenis Perubahan</label>
                        <select name="jenis_perubahan">
                            <option value="">-- Pilih --</option>
                            <option value="Upgrade" @if($barang->jenis_perubahan == 'Upgrade') selected @endif>Upgrade</option>
                            <option value="Perbaikan" @if($barang->jenis_perubahan == 'Perbaikan') selected @endif>Perbaikan</option>
                        </select>

                        <label>Deskripsi Perubahan</label>
                        <textarea name="deskripsi_perubahan">{{ $barang->deskripsi_perubahan }}</textarea>

                        <label>Biaya Perubahan</label>
                        <input type="number" name="biaya_perubahan" value="{{ $barang->biaya_perubahan }}">

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('superadmin.perubahandatabrg') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                    @else
                        <p>Data tidak ditemukan atau barang bukan Upgrade.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
