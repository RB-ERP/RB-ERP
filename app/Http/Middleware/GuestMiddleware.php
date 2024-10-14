<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            return $this->redirectToRoleDashboard(Auth::user());
        }

        return $next($request);
    }

    private function redirectToRoleDashboard($user)
    {
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        } elseif ($user->role === 'user') {
            return redirect('/user/dashboard');
        } elseif ($user->role === 'super_admin') {
            return redirect('/superadmin/dashboard');
        }

        return redirect('/welcome');
    }
}
