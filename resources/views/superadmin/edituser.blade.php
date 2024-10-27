<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit User - InvenTrack</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            width: 50%;
            margin: 0 auto;
            background-color: #eef5ff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: 600;
        }

        .btn-container {
        display: flex;
        justify-content: space-between; /* Memisahkan tombol ke kiri dan kanan */
        width: 100%; /* Mengatur lebar penuh untuk container tombol */
        }

        .btn-primary {
        background-color: #ffffff;
        color: #007bff;
        border: 2px solid #007bff;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 5px;
        }

        .btn-secondary {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 5px;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h1>Edit User</h1>
        <form action="{{ route('user.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="name">Nama Lengkap</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="role">Role</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="super_admin" {{ $user->role == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="password">Password (Optional)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <div class="btn-container">
                <button type="submit" class="btn btn-primary">Update User</button>
                <a href="{{ route('superadmin.user') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

</body>
</html>
