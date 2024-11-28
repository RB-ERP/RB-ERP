<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>InvenTrack - Radar Bogor</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/css/login.css" />
</head>

<body>
    <div class="header">
        <img src="asset/RB Logo.png" alt="Radar Bogor" />
    </div>
    <div class="container">
        <div class="login-box">
            <div class="welcome-text">
                <h1>Selamat Datang di InvenTrack</h1>
                <p>Sistem Inventaris Barang untuk Radar Bogor</p>
            </div>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Username" />

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" />

                <div class="options">
                    <label><input type="checkbox" id="show-password" /> Lihat Password</label>
                </div>

                <button type="submit">Log In</button>
            </form>
        </div>
        <div class="image-box">
            <img src="asset/Newsletter-rafiki.png" alt="Illustration" />
        </div>
    </div>
    <div class="wave-background">
        <img src="asset/gelombanghitam.png" class="wave-top-left" alt="Wave Top Left" />
        <img src="asset/gelombanghitam.png" class="wave-top-right" alt="Wave Top Right" />
        <img src="asset/gelombanghitam.png" class="wave-bottom-center" alt="Wave Bottom Left" />
    </div>

    <script>
        const showPasswordCheckbox = document.getElementById('show-password');
        const passwordInput = document.getElementById('password');

        showPasswordCheckbox.addEventListener('change', function() {
            if (this.checked) {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        });
    </script>
</body>

</html>
