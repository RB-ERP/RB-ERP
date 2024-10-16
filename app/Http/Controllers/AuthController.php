<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Barang;
use App\Models\User;

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
        $user = Auth::user();

        // Hitung total barang
        $totalBarang = Barang::count();

        // Hitung barang yang dipinjam
        $barangDipinjam = Barang::where('status', 'Dipinjam')->count();

        // Hitung total user
        $totalUser = User::count();

        return view('superadmin.dashboard', compact('user', 'totalBarang', 'barangDipinjam', 'totalUser'));
    }

    // data barang untuk super admin
    public function superAdminDataBarang()
    {
        // Ambil data barang
        $barangs = Barang::all(); // Ambil semua data barang

        return view('superadmin.databarang', compact('barangs'));
    }

    public function create()
    {
    return view('superadmin.formdatabarangbaru');
    }

    // Dashboard untuk admin biasa
    public function adminDashboard()
    {
        $user = Auth::user(); // Ambil user yang login

        // Hitung total barang
        $totalBarang = Barang::count();

        // Hitung barang yang sedang dipinjam (misalnya dengan status 'Dipinjam')
        $barangDipinjam = Barang::where('status', 'Dipinjam')->count();

        // Kirim data ke view
        return view('admin.dashboard', compact('user', 'totalBarang', 'barangDipinjam'));
    }

    // dashboard untuk user
    public function userDashboard()
    {
        $user = Auth::user();

        // Data untuk user (jika dibutuhkan, Anda bisa menyesuaikan)
        $totalBarang = Barang::count();
        $barangDipinjam = Barang::where('status', 'Dipinjam')->count();

        return view('user.dashboard', compact('user', 'totalBarang', 'barangDipinjam'));
    }


     // Method untuk logout
     public function logout(Request $request)
     {
         Auth::logout(); // Log out the user

         // Invalidasi sesi yang sedang aktif
         $request->session()->invalidate();

         // Regenerate CSRF token untuk keamanan
         $request->session()->regenerateToken();


         return redirect('/welcome');
     }

}