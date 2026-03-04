<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\DokumenPendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $request->validate([
            // Data Siswa
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat_siswa' => 'required|string',
            // Data Orang Tua
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'alamat_ortu' => 'required|string',
            // Dokumen
            'akta_kelahiran' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'kartu_keluarga' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'foto' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Simpan data pendaftaran
        $registration = Registration::create([
            'nama_lengkap' => $request->nama_lengkap,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat_siswa' => $request->alamat_siswa,
            'nama_ayah' => $request->nama_ayah,
            'nama_ibu' => $request->nama_ibu,
            'pekerjaan_ayah' => $request->pekerjaan_ayah,
            'pekerjaan_ibu' => $request->pekerjaan_ibu,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'alamat_ortu' => $request->alamat_ortu,
            'status' => 'pending',
        ]);

        // Simpan dokumen
        $dokumenTypes = [
            'akta_kelahiran' => 'Akta Kelahiran',
            'kartu_keluarga' => 'Kartu Keluarga',
            'foto' => 'Pas Foto',
        ];

        foreach ($dokumenTypes as $fieldName => $jenisDokumen) {
            if ($request->hasFile($fieldName)) {
                $file = $request->file($fieldName);
                $filename = time() . '_' . $fieldName . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('dokumen_pendaftaran/' . $registration->id, $filename, 'public');

                DokumenPendaftaran::create([
                    'registration_id' => $registration->id,
                    'jenis_dokumen' => $jenisDokumen,
                    'nama_file' => $file->getClientOriginalName(),
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('pendaftaran.success')->with('registration_id', $registration->id);
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
        $registration = null;
        if ($request->has('email')) {
            $registration = Registration::where('email', $request->email)->latest()->first();
        }
        return view('pendaftaran.cek-status', compact('registration'));
    }
}
