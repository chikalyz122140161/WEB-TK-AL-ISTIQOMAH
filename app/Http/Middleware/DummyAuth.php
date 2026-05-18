<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DummyAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->withErrors(['email' => 'Silakan login terlebih dahulu.']);
        }

        if (auth()->user()->status !== 'active') {
            auth()->logout();
            $request->session()->invalidate();
            return redirect()->route('login')->withErrors(['email' => 'Akun Anda tidak aktif. Hubungi admin.']);
        }

        return $next($request);
    }
}
