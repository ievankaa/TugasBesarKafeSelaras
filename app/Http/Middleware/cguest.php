<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class cguest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isUser = session('is_admin');

        if ($isUser !== null) {
            return $isUser ? redirect('pemilik/absensi') : redirect('pegawai/absensi_pegawai');
        }

        return $next($request);
    }
}
