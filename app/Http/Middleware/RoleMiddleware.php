<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|array  $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login'); // Jika belum login, redirect ke login
        }

        // Ambil user yang sedang login
        $user = Auth::user();

        // Jika 'roles' adalah array, cek apakah role user sesuai
        if (is_array($roles)) {
            if (!in_array($user->role, $roles)) {
                return $this->redirectToRoleDashboard($user);
            }
        } else {
            // Jika 'roles' adalah string, cek apakah role user cocok
            if ($user->role !== $roles) {
                return $this->redirectToRoleDashboard($user);
            }
        }

        // Jika role sesuai, lanjutkan ke request berikutnya
        return $next($request);
    }

    private function redirectToRoleDashboard($user)
    {
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        } elseif ($user->role === 'user') {
            return redirect('/user/dashboard');
        } elseif ($user->role === 'super_admin') {
            return redirect('/welcome');
        }

        return redirect('/welcome');
    }
}