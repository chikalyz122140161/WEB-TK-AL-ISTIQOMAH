"[AuthController.php](c:/Users/yesav/Documents/WEB-TK-AL-ISTIQOMAH/app/Http/Controllers/AuthController.php) adalah file yang mengatur proses masuk dan keluar pengguna dari aplikasi. Sederhananya, file ini menangani halaman login, mengecek apakah email dan password yang dimasukkan benar, memastikan akun pengguna sudah berstatus aktif, lalu mengarahkan pengguna ke dashboard sesuai rolenya, yaitu admin, guru, atau orang tua. Jika akun belum aktif atau password salah, pengguna akan dikembalikan ke halaman login dengan pesan error. File ini juga mengatur proses logout, yaitu menghapus session login agar pengguna benar-benar keluar dari sistem."
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Function ini menampilkan halaman login untuk user yang belum masuk.
    // Jika user sudah login, sistem langsung mengarahkannya ke dashboard sesuai role.
    public function showLogin()
    {
        if (auth()->check()) {
            return $this->redirectByRole(auth()->user()->role);
        }
        return view('auth.login');
    }

    // Function ini memproses email dan password yang dikirim dari form login.
    // Jika data benar dan akun aktif, user diarahkan ke dashboard sesuai role.
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->withInput(['email' => $request->email]);
        }

        $user = auth()->user();

        if ($user->status !== 'active') {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Akun Anda belum aktif atau telah dinonaktifkan. Hubungi admin.',
            ])->withInput(['email' => $request->email]);
        }

        $request->session()->regenerate();

        return $this->redirectByRole($user->role);
    }

    // Function ini mengeluarkan user dari sistem.
    // Session login dihapus agar user harus login ulang jika ingin masuk lagi.
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // Function ini menentukan tujuan halaman setelah user berhasil login.
    // Admin, guru, dan orang tua diarahkan ke dashboard yang berbeda.
    private function redirectByRole(string $role)
    {
        return match ($role) {
            'admin'     => redirect()->route('admin.dashboard'),
            'guru'      => redirect()->route('guru.dashboard'),
            'orangtua'  => redirect()->route('orangtua.dashboard'),
            default     => redirect('/'),
        };
    }
}
