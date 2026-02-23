<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Jika user belum login, lempar ke login
        if (! $request->user()) {
            return redirect('/login');
        }

        // Cek apakah role user ada di dalam daftar role yang diizinkan
        if (in_array($request->user()->role, $roles)) {
            return $next($request);
        }

        // Jika role tidak cocok, tampilkan Error 403 (Forbidden)
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}