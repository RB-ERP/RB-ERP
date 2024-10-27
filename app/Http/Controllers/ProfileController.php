<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    // Method untuk menampilkan profil
    public function showProfile()
    {
        $user = Auth::user(); // Mendapatkan user yang sedang login

        // Tentukan view berdasarkan role
        if ($user->role === 'super_admin') {
            $view = 'superadmin.profile';
        } elseif ($user->role === 'admin') {
            $view = 'admin.profile';
        } else {
            $view = 'user.profile';
        }

        return view($view, compact('user')); // Tampilkan view yang sesuai
    }


    // Method untuk menampilkan halaman edit profil
    public function editProfile()
    {
        $user = Auth::user();

        // Tentukan view berdasarkan role
        if ($user->role === 'super_admin') {
            $view = 'superadmin.editprofile';
        } elseif ($user->role === 'admin') {
            $view = 'admin.editprofile';
        } else {
            $view = 'user.editprofile';
        }

        return view($view, compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:8',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Update data user
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        // Jika ada upload foto
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profile_pictures'), $filename);

            // Simpan path foto di database
            $user->profile_picture = $filename;
        }

        $user->save();

        // Redirect ke halaman profil berdasarkan role
        if ($user->role === 'super_admin') {
            return redirect()->route('superadmin.profile')->with('success', 'Profil berhasil diperbarui');
        } elseif ($user->role === 'admin') {
            return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui');
        } else {
            return redirect()->route('user.profile')->with('success', 'Profil berhasil diperbarui');
        }
    }

}
