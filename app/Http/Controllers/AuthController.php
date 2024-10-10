<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user(); // Mendapatkan data user yang login

            // Cek role dan arahkan ke dashboard yang sesuai
            if ($user->role === 'super_admin') {
                return redirect()->intended('/superadmin/dashboard'); // Tidak perlu with()
            } elseif ($user->role === 'user') {
                return redirect()->intended('/user/dashboard'); // Tidak perlu with()
            } elseif ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard'); // Arahkan ke halaman dashboard admin
            }
        }

        return redirect()->back()->withErrors(['message' => 'Username atau password salah']);
    }


    // Dashboard untuk super admin
    public function superAdminDashboard()
    {
        // Ambil data user yang sedang login
        $user = Auth::user();

        return view('superadmin.dashboard', compact('user'));  // Sesuaikan dengan view untuk dashboard super admin
    }

    // data barang untuk super admin
    public function superAdminDataBarang()
    {
        return view('superadmin.databarang');  // Sesuaikan dengan view untuk data barang super admin
    }

    public function create()
    {
    return view('superadmin.formdatabarangbaru');
    }

    // Dashboard untuk user biasa
    public function userDashboard()
    {
        return view('user.dashboard');  // Sesuaikan dengan view untuk dashboard user
    }

    // Dashboard untuk user biasa
    public function adminDashboard()
    {
        return view('admin.dashboard');  // Sesuaikan dengan view untuk dashboard admin
    }

     // Method untuk logout
     public function logout(Request $request)
     {
         Auth::logout(); // Log out the user

         // Invalidasi sesi yang sedang aktif
         $request->session()->invalidate();

         // Regenerate CSRF token untuk keamanan
         $request->session()->regenerateToken();

         // Redirect ke halaman login atau halaman lain
         return redirect('login');
     }

}