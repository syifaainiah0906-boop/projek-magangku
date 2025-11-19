<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Pastikan user sudah login dan role-nya sesuai
        if (Auth::check() && Auth::user()->role === $role) {
            return $next($request);
        }

        // Kalau tidak sesuai role, arahkan ke halaman utama / landing
        return redirect('/');
    }
}
