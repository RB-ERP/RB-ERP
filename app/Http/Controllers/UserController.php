<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Method untuk menampilkan daftar user
    public function index()
    {
        // Ambil semua data user
        $users = User::paginate(10);

        // Return view dengan data user
        return view('superadmin.user', compact('users')); // Ubah ke 'users'
    }

    // Method untuk menampilkan halaman tambah user
    public function create()
    {
        // Return view tambah user
        return view('superadmin.user.create');
    }

    // Method untuk menyimpan user baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // email harus unik
            'username' => 'required|string|max:255|unique:users,username', // username harus unik
            'password' => 'required|confirmed|min:8',
            'role' => 'required|string',
        ]);

         // Buat user baru dengan data dari form
        User::create([
            'name' => $request->input('name'), // Nama Lengkap
            'username' => $request->input('username'), // Username
            'email' => $request->input('email'), // Email
            'password' => bcrypt($request->input('password')), // Enkripsi password
            'role' => $request->input('role'), // Role
        ]);

        // Redirect ke halaman daftar user dengan pesan sukses
        return redirect()->route('superadmin.user')->with('success', 'User berhasil ditambahkan');
    }

    // Method untuk menampilkan halaman edit user
    public function edit($id)
    {
        // Ambil data user berdasarkan ID
        $user = User::findOrFail($id);

        // Return view edit user
        return view('superadmin.user.edit', compact('users'));
    }

    // Method untuk memperbarui data user
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required|string',
        ]);

        // Ambil data user berdasarkan ID
        $user = User::findOrFail($id);

        // Perbarui data user
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
            // Update password jika diisi
            'password' => $request->filled('password') ? bcrypt($request->input('password')) : $user->password,
        ]);

        // Redirect kembali ke daftar user
        return redirect()->route('superadmin.user')->with('success', 'User berhasil diperbarui');
    }

    // Method untuk menghapus user
    public function destroy($id)
    {
        // Ambil data user berdasarkan ID
        $user = User::findOrFail($id);

        // Hapus user
        $user->delete();

        // Redirect kembali ke daftar user
        return redirect()->route('superadmin.user')->with('success', 'User berhasil dihapus');
    }
}