<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Riwayat Peminjaman</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Nama Peminjam</th>
                <th>Tanggal Peminjaman</th>
                <th>Tanggal Pengembalian</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($riwayats as $riwayat)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $riwayat->barang->nama_barang }}</td>
                    <td>{{ $riwayat->nama_peminjam }}</td>
                    <td>{{ $riwayat->tanggal_peminjaman ? $riwayat->tanggal_peminjaman->format('d M Y') : '-' }}</td>
                    <td>{{ $riwayat->tanggal_pengembalian ? $riwayat->tanggal_pengembalian->format('d M Y') : '-' }}</td>
                    <td>{{ $riwayat->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
