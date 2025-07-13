<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowedRoles = ['admin', 'kasir', 'gudang', 'owner', 'karyawan'];
        if (!Auth::check() || !in_array(Auth::user()->role, $allowedRoles)) {
            abort(403, 'Akses ditolak.');
        }
        return $next($request);
    }
}
