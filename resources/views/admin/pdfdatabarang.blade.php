<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Barang</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 3px;
            text-align: center;
            font-size: 10px;
        }
        th {
            background-color: #f2f2f2;
        }
        td {
            word-wrap: break-word;
            max-width: 1px;
        }
    </style>
</head>
<body>
    <h1>Laporan Data Barang</h1>
    <table>
        <thead>
            <tr>
                <th style="width: 3%;">No</th>
                <th style="width: 12%;">Nama Barang</th>
                <th style="width: 8%;">Kode Barang</th>
                <th style="width: 8%;">Serial Number</th>
                <th style="width: 12%;">Tanggal Pembelian</th>
                <th style="width: 12%;">Spesifikasi</th>
                <th style="width: 8%;">Harga</th>
                <th style="width: 8%;">Status</th>
                <th style="width: 12%;">Tanggal Perubahan</th>
                <th style="width: 8%;">Jenis Perubahan</th>
                <th style="width: 12%;">Deskripsi Perubahan</th>
                <th style="width: 8%;">Biaya Perubahan</th>
                <th style="width: 10%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangs as $barang)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $barang->nama_barang }}</td>
                    <td>{{ $barang->kode_barang }}</td>
                    <td>{{ $barang->serial_number }}</td>
                    <td>{{ $barang->tanggal_pembelian }}</td>
                    <td>{{ $barang->spesifikasi }}</td>
                    <td>Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                    <td>{{ $barang->status }}</td>
                    <td>{{ $barang->tanggal_perubahan }}</td>
                    <td>{{ $barang->jenis_perubahan }}</td>
                    <td>{{ $barang->deskripsi_perubahan }}</td>
                    <td>Rp {{ number_format($barang->biaya_perubahan, 0, ',', '.') }}</td>
                    <td>{{ $barang->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
