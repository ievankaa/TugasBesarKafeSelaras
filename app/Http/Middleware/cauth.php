<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class cauth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $isUser = session('is_admin');
        $isAdmin = $role === 'admin' ? 1 : 0;

        if ($isUser === null || $isUser !== $isAdmin) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
