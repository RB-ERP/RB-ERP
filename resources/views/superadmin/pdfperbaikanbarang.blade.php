<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Perbaikan Barang</title>
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
    <h2>Laporan Perbaikan Barang</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Kode Barang</th>
                <th>Serial Number</th>
                <th>Tanggal Perubahan</th>
                <th>Jenis Perbaikan</th>
                <th>Deskripsi Perbaikan</th>
                <th>Biaya Perbaikan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($perbaikans as $perbaikan)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $perbaikan->nama_barang }}</td>
                <td>{{ $perbaikan->kode_barang }}</td>
                <td>{{ $perbaikan->serial_number }}</td>
                <td>{{ $perbaikan->tanggal_perubahan }}</td>
                <td>{{ $perbaikan->jenis_perubahan }}</td>
                <td>{{ $perbaikan->deskripsi_perubahan }}</td>
                <td>Rp {{ number_format($perbaikan->biaya_perubahan, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
