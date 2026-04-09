<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    /**
     * Tampilkan form pendaftaran (publik, tanpa login)
     */
    public function create()
    {
        return view('pendaftaran.create');
    }

    /**
     * Simpan data pendaftaran baru
     */
    public function store(Request $request)
    {
        // Hanya redirect dengan success (dummy)
        return redirect()->route('pendaftaran.success')->with('registration_id', 'P2026001');
    }

    /**
     * Halaman sukses pendaftaran
     */
    public function success()
    {
        return view('pendaftaran.success');
    }

    /**
     * Cek status pendaftaran
     */
    public function cekStatus(Request $request)
    {
        // Dummy data jika ada email
        $registration = null;
        if ($request->has('email')) {
            $registration = (object)[
                'id' => 1,
                'nama_lengkap' => 'Ahmad Fauzi',
                'email' => $request->email,
                'status' => 'pending',
                'created_at' => now()->subDays(3),
            ];
        }
        return view('pendaftaran.cek-status', compact('registration'));
    }
}
