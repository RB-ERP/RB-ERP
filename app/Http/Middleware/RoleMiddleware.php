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
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Ambil user yang sedang login
        $user = Auth::user();

        // Cek apakah user memiliki role yang diizinkan
        if ($user->role !== $role) {
            // Jika tidak sesuai, arahkan ke halaman yang diinginkan, misalnya ke halaman 403 (akses ditolak)
            return abort(403, 'Unauthorized');
        }

        // Jika role sesuai, lanjutkan ke request berikutnya
        return $next($request);
    }
}