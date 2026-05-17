<?php

namespace App\Http\Controllers;

use App\Models\Parents;
use App\Models\Student;
use App\Models\StudentFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PendaftaranController extends Controller
{
    public function create()
    {
        return view('pendaftaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'               => 'required|string|max:255',
            'nama_panggilan'     => 'required|string|max:100',
            'nik'                => 'required|string|size:16',
            'jenis_kelamin'      => 'required|in:L,P',
            'agama'              => 'required|string|max:50',
            'tempat_lahir'       => 'required|string|max:100',
            'tanggal_lahir'      => 'required|date',
            'anak_ke'            => 'required|integer|min:1',
            'jumlah_saudara'     => 'required|integer|min:0',
            'suku_bangsa'        => 'nullable|string|max:100',
            'riwayat_penyakit'   => 'nullable|string|max:255',
            'berat_badan'        => 'nullable|numeric|min:0',
            'tinggi_badan'       => 'nullable|numeric|min:0',
            'alamat'             => 'required|string',
            'nama_ayah'          => 'required|string|max:255',
            'pekerjaan_ayah'     => 'nullable|string|max:100',
            'pendidikan_ayah'    => 'nullable|string|max:50',
            'tempat_lahir_ayah'  => 'nullable|string|max:100',
            'tanggal_lahir_ayah' => 'nullable|date',
            'no_telp_ayah'       => 'nullable|string|max:20',
            'nama_ibu'           => 'required|string|max:255',
            'pekerjaan_ibu'      => 'nullable|string|max:100',
            'pendidikan_ibu'     => 'nullable|string|max:50',
            'tempat_lahir_ibu'   => 'nullable|string|max:100',
            'tanggal_lahir_ibu'  => 'nullable|date',
            'no_telp_ibu'        => 'nullable|string|max:20',
            'nama_wali'          => 'nullable|string|max:255',
            'pekerjaan_wali'     => 'nullable|string|max:100',
            'pendidikan_wali'    => 'nullable|string|max:50',
            'tempat_lahir_wali'  => 'nullable|string|max:100',
            'tanggal_lahir_wali' => 'nullable|date',
            'no_telp_wali'       => 'nullable|string|max:20',
            'email_ortu'         => 'required|email|unique:user,email',
            'password_ortu'      => 'required|string|min:6',
            'akta_kelahiran'     => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'kartu_keluarga'     => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'foto'               => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::transaction(function () use ($request) {
            // Create user account for orangtua
            $user = User::create([
                'name'     => $request->nama_ayah,
                'email'    => $request->email_ortu,
                'password' => Hash::make($request->password_ortu),
                'phone'    => $request->no_telp_ayah,
                'role'     => 'orangtua',
                'status'   => 'pending',
            ]);

            // Create student
            $student = Student::create([
                'user_id'         => $user->id,
                'name'            => $request->nama,
                'nickname'        => $request->nama_panggilan,
                'gender'          => $request->jenis_kelamin,
                'nis'             => null,
                'nik'             => $request->nik,
                'pob'             => $request->tempat_lahir,
                'dob'             => $request->tanggal_lahir,
                'religion'        => $request->agama,
                'birth_order'     => $request->anak_ke,
                'siblings_count'  => $request->jumlah_saudara,
                'ethnicity'       => $request->suku_bangsa,
                'illness_history' => $request->riwayat_penyakit,
                'weight'          => $request->berat_badan,
                'height'          => $request->tinggi_badan,
                'address'         => $request->alamat,
                'phone'           => $request->no_telp_ayah,
            ]);

            // Create parent records
            Parents::create([
                'student_id' => $student->id,
                'category'   => 'ayah',
                'name'       => $request->nama_ayah,
                'work'       => $request->pekerjaan_ayah,
                'education'  => $request->pendidikan_ayah,
                'pob'        => $request->tempat_lahir_ayah,
                'dob'        => $request->tanggal_lahir_ayah ?: null,
            ]);

            Parents::create([
                'student_id' => $student->id,
                'category'   => 'ibu',
                'name'       => $request->nama_ibu,
                'work'       => $request->pekerjaan_ibu,
                'education'  => $request->pendidikan_ibu,
                'pob'        => $request->tempat_lahir_ibu,
                'dob'        => $request->tanggal_lahir_ibu ?: null,
            ]);

            if ($request->filled('nama_wali')) {
                Parents::create([
                    'student_id' => $student->id,
                    'category'   => 'wali',
                    'name'       => $request->nama_wali,
                    'work'       => $request->pekerjaan_wali,
                    'education'  => $request->pendidikan_wali,
                    'pob'        => $request->tempat_lahir_wali,
                    'dob'        => $request->tanggal_lahir_wali ?: null,
                ]);
            }

            // Upload and save student files
            $dir = 'students/' . $student->id;

            $aktaPath = $request->file('akta_kelahiran')->store($dir, 'public');
            StudentFile::create([
                'student_id' => $student->id,
                'type'       => 'akta',
                'path'       => $aktaPath,
            ]);

            $kkPath = $request->file('kartu_keluarga')->store($dir, 'public');
            StudentFile::create([
                'student_id' => $student->id,
                'type'       => 'kk',
                'path'       => $kkPath,
            ]);

            $fotoPath = $request->file('foto')->store($dir, 'public');
            StudentFile::create([
                'student_id' => $student->id,
                'type'       => 'foto',
                'path'       => $fotoPath,
            ]);
        });

        return redirect()->route('pendaftaran.success')->with('registration_id', $request->nik);
    }

    public function success()
    {
        return view('pendaftaran.success');
    }

    public function cekStatus(Request $request)
    {
        $registration = null;

        if ($request->filled('email')) {
            $user = User::where('email', $request->email)
                ->where('role', 'orangtua')
                ->with('student')
                ->first();

            if ($user && $user->student) {
                $registration = (object)[
                    'nama_lengkap' => $user->student->name,
                    'email'        => $user->email,
                    'status'       => 'terdaftar',
                    'created_at'   => $user->created_at,
                ];
            }
        }

        return view('pendaftaran.cek-status', compact('registration'));
    }
}
