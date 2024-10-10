<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Method untuk menampilkan daftar user
    public function index()
    {
        // Ambil semua data user dengan paginasi
        $users = User::paginate(10);

        // Ambil user yang sedang login
        $user = auth()->user();

        // Return view dengan data users dan user yang login
        return view('superadmin.user', compact('users', 'user')); // Kirim $user dan $users
    }


    // Method untuk menampilkan halaman tambah user
    public function create()
    {
        return view('superadmin.formtambahuser'); // Menampilkan form tambah user
    }

    // Method untuk menyimpan user baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // Validasi email
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|confirmed|min:8',
            'role' => 'required|string',
        ]);

        // Simpan user baru
        User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')), // Enkripsi password
            'role' => $request->input('role'),
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('superadmin.user')->with('success', 'User berhasil ditambahkan');
    }

    // Method untuk menampilkan halaman edit user
    public function edit($id)
    {
        // Ambil data user berdasarkan ID
        $user = User::findOrFail($id);

        // Ambil semua data user untuk menampilkan di view jika diperlukan
        $users = User::paginate(10); // Ambil data user dengan paginasi jika dibutuhkan

        // Return view edit user
        return view('superadmin.edituser', compact('user', 'users')); // Kirim data user dan users jika perlu
    }

    // Method untuk memperbarui data user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'username' => 'required|string|max:255|unique:users,username,'.$id,
            'role' => 'required|string',
            'password' => 'nullable|min:8'
        ]);

        // Update data user
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'role' => $request->input('role'),
            'password' => $request->filled('password') ? bcrypt($request->input('password')) : $user->password,
        ]);

        return redirect()->route('superadmin.user')->with('success', 'User berhasil diperbarui');
    }

    // Method untuk menghapus user
    public function destroy($id)
    {
        // Temukan user berdasarkan ID
        $user = User::findOrFail($id);

        // Hapus user
        $user->delete();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('superadmin.user')->with('success', 'User berhasil dihapus');
    }

}