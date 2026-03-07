<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Dummy login - redirect berdasarkan email yang dimasukkan
        $email = $request->input('email', '');
        
        // Simpan role di session untuk akses dummy
        if (str_contains(strtolower($email), 'admin')) {
            session(['dummy_role' => 'admin', 'dummy_email' => $email]);
            return redirect()->route('admin.dashboard');
        } elseif (str_contains(strtolower($email), 'guru')) {
            session(['dummy_role' => 'guru', 'dummy_email' => $email]);
            return redirect()->route('guru.dashboard');
        } else {
            session(['dummy_role' => 'orangtua', 'dummy_email' => $email]);
            return redirect()->route('orangtua.dashboard');
        }
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
