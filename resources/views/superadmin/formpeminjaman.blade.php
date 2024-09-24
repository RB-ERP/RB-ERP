<h2>Form Peminjaman Barang</h2>

<form action="{{ route('peminjaman.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="barang_id">Pilih Barang</label>
        <select name="barang_id" id="barang_id" class="form-control">
            @foreach($barangs as $barang)
                <option value="{{ $barang->id }}">{{ $barang->nama_barang }} - {{ $barang->kode_barang }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="nama_peminjam">Nama Peminjam</label>
        <input type="text" name="nama_peminjam" id="nama_peminjam" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="tanggal_peminjaman">Tanggal Peminjaman</label>
        <input type="date" name="tanggal_peminjaman" id="tanggal_peminjaman" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan Peminjaman</button>
</form>
