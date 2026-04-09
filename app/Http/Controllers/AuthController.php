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
        $email = $request->input('email', '');
        $password = $request->input('password', '');
        
        // Dummy login dengan kredensial tetap
        $dummyUsers = [
            'admin@mail.com' => 'admin',
            'guru@mail.com' => 'guru',
            'ortu@mail.com' => 'orangtua',
        ];
        
        // Cek email dan password
        if (isset($dummyUsers[$email]) && $password === 'password') {
            $role = $dummyUsers[$email];
            session(['dummy_role' => $role, 'dummy_email' => $email]);
            
            return match ($role) {
                'admin' => redirect()->route('admin.dashboard'),
                'guru' => redirect()->route('guru.dashboard'),
                'orangtua' => redirect()->route('orangtua.dashboard'),
                default => redirect('/'),
            };
        }
        
        // Login gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput(['email' => $email]);
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
