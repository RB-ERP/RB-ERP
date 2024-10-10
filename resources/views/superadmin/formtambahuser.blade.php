<head>
    <link rel="stylesheet" href="{{ asset('css/formdatabarangbaru.css') }}">
</head>

<div class="form-container">
    <h2>Tambah User Baru</h2>
    <form action="{{ route('user.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Masukkan Nama Lengkap" required>
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control" id="username" placeholder="Masukkan Username" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Masukkan Email" required>
        </div>

        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" class="form-control" id="role" required>
                <option value="">Pilih Role</option>
                <option value="super_admin">Super Admin</option>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan Password" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Masukkan Password Lagi" required>
        </div>


        <div class="form-actions">
            <button type="submit" class="btn-primary">Simpan</button>
            <a href="{{ route('superadmin.user') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
</div>
