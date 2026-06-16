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
    // Function ini menjalankan proses utama saat command atau middleware dipanggil oleh Laravel.
    // Isinya menentukan langkah yang harus dilakukan sistem pada proses tersebut.
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
