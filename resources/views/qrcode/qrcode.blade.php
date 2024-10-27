<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Barang</title>
    <style>
        body{
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }

        .qrcode {
            text-align: center;
        }

        h1{
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>QR Code Barang</h1>

    <!-- Tampilkan QR Code sebagai gambar -->
    <div class="qrcode">
        <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code">
    </div>
</body>
</html>
