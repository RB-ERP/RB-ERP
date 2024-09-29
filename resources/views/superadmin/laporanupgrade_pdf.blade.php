<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Upgrade Barang</title>
</head>
<body>
    <h1>Laporan Inventaris Upgrade Barang</h1>

    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Nama Barang</th>
                <th style="width: 10%;">Kode Barang</th>
                <th style="width: 10%;">Serial Number</th>
                <th style="width: 15%;">Tanggal Pembelian</th>
                <th style="width: 15%;">Spesifikasi</th>
                <th style="width: 10%;">Harga</th>
                <th style="width: 15%;">Tanggal Perubahan</th>
                <th style="width: 10%;">Jenis Perubahan</th>
                <th style="width: 15%;">Deskripsi Perubahan</th>
                <th style="width: 10%;">Biaya Perubahan</th>
            </tr>
        </thead>
        <tbody>
          @foreach ($barangs as $barang)
              <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $barang->nama_barang }}</td>
                  <td>{{ $barang->kode_barang }}</td>
                  <td>{{ $barang->serial_number}}</td>
                  <td>{{ $barang->tanggal_pembelian }}</td>
                  <td>{{ $barang->spesifikasi }}</td>
                  <td>Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                  <td>{{ $barang->tanggal_perubahan }}</td>
                  <td>{{ $barang->jenis_perubahan }}</td>
                  <td>{{ $barang->deskripsi_perubahan }}</td>
                  <td>Rp {{ number_format($barang->biaya_perubahan, 0, ',', '.') }}</td>
              </tr>
          @endforeach
        </tbody>
    </table>
</body>
</html>
