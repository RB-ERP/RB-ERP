<h2>Form Peminjaman Barang</h2>

<form action="{{ route('superadmin.peminjaman.store') }}" method="POST">
    @csrf
    <label for="barang">Pilih Barang:</label>
    <select name="barang_id" id="barang">
        @foreach($barangs as $barang)
            <option value="{{ $barang->id }}">{{ $barang->nama_barang }}</option>
        @endforeach
    </select>

    <label for="nama_peminjam">Nama Peminjam:</label>
    <input type="text" name="nama_peminjam" required>

    <label for="tanggal_peminjaman">Tanggal Peminjaman:</label>
    <input type="date" name="tanggal_peminjaman" required>

    <button type="submit">Pinjam Barang</button>
</form>
