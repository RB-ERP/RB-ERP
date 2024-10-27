<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Upgrade Barang</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
            font-size: 12px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Laporan Upgrade Barang</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Kode Barang</th>
                <th>Serial Number</th>
                <th>Tanggal Pembelian</th>
                <th>Spesifikasi</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Tanggal Perubahan</th>
                <th>Jenis Perubahan</th>
                <th>Deskripsi Perubahan</th>
                <th>Biaya Perubahan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($upgrades as $upgrade)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $upgrade->nama_barang }}</td>
                <td>{{ $upgrade->kode_barang }}</td>
                <td>{{ $upgrade->serial_number }}</td>
                <td>{{ $upgrade->tanggal_pembelian }}</td>
                <td>{{ $upgrade->spesifikasi }}</td>
                <td>Rp {{ number_format($upgrade->harga, 0, ',', '.') }}</td>
                <td>{{ $upgrade->status }}</td>
                <td>{{ $upgrade->tanggal_perubahan }}</td>
                <td>{{ $upgrade->jenis_perubahan }}</td>
                <td>{{ $upgrade->deskripsi_perubahan }}</td>
                <td>Rp {{ number_format($upgrade->biaya_perubahan, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
