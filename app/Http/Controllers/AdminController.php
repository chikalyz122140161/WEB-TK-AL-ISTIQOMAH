<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AcademicTerm;
use App\Models\ClassTerm;
use App\Models\Classroom;
use App\Models\Counseling;
use App\Models\CounselingAssessment;
use App\Models\Extracurricular;
use App\Models\ExtracurricularAssessment;
use App\Models\ClassTermCounseling;
use App\Models\ClassTermExtracurricular;
use App\Models\ClassTermSubject;
use App\Models\Subject;
use App\Models\Parents;
use App\Models\Registration;
use App\Models\StudentEnrollment;
use App\Models\StudentFile;
use App\Models\User;
use App\Models\Student;
use App\Services\DatabaseBackupService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // DASHBOARD
    public function dashboard()
    {
        $totalSiswa      = Student::count();
        $totalGuru       = User::where('role', 'guru')->count();
        $orangTerdaftar  = User::where('role', 'orangtua')->count();
        $totalKelas      = Classroom::count();

        $aktivitas = [
            ['title' => 'Data Siswa Baru Ditambahkan', 'time' => '2 jam yang lalu'],
            ['title' => 'Pengguna Baru Terdaftar', 'time' => '5 jam yang lalu'],
            ['title' => 'Backup Database Berhasil', 'time' => 'Kemarin'],
        ];

        // Statistik siswa per kelas — via student_enrollment → class_term → class
        $statistik = Classroom::with('classTerms')->get()->map(function ($k) {
            $classTermIds = $k->classTerms->pluck('id');
            $jumlah = StudentEnrollment::whereIn('class_term_id', $classTermIds)
                ->where('status', 'aktif')
                ->distinct('student_id')
                ->count('student_id');
            return ['label' => 'TK ' . $k->name, 'value' => $jumlah . ' Siswa'];
        })->all();

        $statistik[] = ['label' => 'Total Siswa', 'value' => $totalSiswa . ' Siswa'];

        return view('admin.dashboard', compact('totalSiswa', 'totalGuru', 'orangTerdaftar', 'totalKelas', 'aktivitas', 'statistik'));
    }
    
    // KELOLA PENGGUNA
    public function penggunaIndex(Request $request)
    {
        $roleMap = [
            'admin'    => 'Admin',
            'guru'     => 'Guru',
            'orangtua' => 'Orang Tua',
        ];
        $statusMap = [
            'active'   => 'Aktif',
            'pending'  => 'Pending',
            'inactive' => 'Nonaktif',
        ];

        $query = User::query()->orderByRaw("FIELD(role, 'admin', 'guru', 'orangtua')")
            ->orderBy('name');

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($w) use ($q) {
                $w->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%");
            });
        }

        $pengguna = $query->get()->map(fn($u) => [
            'id'         => $u->id,
            'nama'       => $u->name,
            'email'      => $u->email,
            'role'       => $roleMap[$u->role] ?? ucfirst($u->role),
            'role_raw'   => $u->role,
            'status'     => $statusMap[$u->status] ?? ucfirst($u->status),
            'status_raw' => $u->status,
            'tgl_daftar' => $u->created_at?->translatedFormat('d M Y') ?? '-',
        ])->all();

        return view('admin.pengguna.index', compact('pengguna'));
    }
    
    public function penggunaCreate()
    {
        $siswaOrphan = Student::whereNull('parent_id')
            ->orderBy('kelas')->orderBy('name')
            ->get(['id', 'name', 'kelas', 'nomor_induk', 'nama_ibu', 'nama_ayah']);
        return view('admin.pengguna.create', compact('siswaOrphan'));
    }

    public function penggunaStore(Request $request)
    {
        $request->validate([
            'nama'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'role'                  => 'required|in:admin,guru,orangtua',
            'password'              => 'required|min:6|confirmed',
            'siswa_id'              => 'nullable|exists:students,id',
        ], [
            'email.unique'          => 'Email sudah digunakan.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
            'password.min'          => 'Password minimal 6 karakter.',
        ]);

        $user = User::create([
            'name'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        if ($request->role === 'orangtua' && $request->filled('siswa_id')) {
            Student::where('id', $request->siswa_id)->update(['parent_id' => $user->id]);
        }

        return redirect()->route('admin.pengguna.index')
            ->with('success', 'Pengguna berhasil ditambahkan!');
    }
    
    public function penggunaEdit($id)
    {
        $user = User::findOrFail($id);
        $pengguna = [
            'id'            => $user->id,
            'nama'          => $user->name,
            'email'         => $user->email,
            'role'          => $user->role,
            'status'        => $user->status,
            'nomor_telepon' => $user->phone,
        ];

        return view('admin.pengguna.edit', compact('pengguna'));
    }

    public function penggunaUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama'   => 'required|string|max:255',
            'email'  => 'required|email|unique:user,email,' . $id,
            'role'   => 'required|in:admin,guru,orangtua',
            'status' => 'nullable|in:active,pending,inactive',
        ]);

        $user->update([
            'name'   => $request->input('nama'),
            'email'  => $request->input('email'),
            'role'   => $request->input('role'),
            'status' => $request->input('status', $user->status),
            'phone'  => $request->input('nomor_telepon', $user->phone),
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->input('password'))]);
        }

        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil diupdate!');
    }

    public function penggunaDestroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil dihapus!');
    }
    
    // KELOLA SISWA
    public function siswaIndex(Request $request)
    {
        $siswa = Student::with(['parents', 'user', 'enrollments.classTerm.class', 'enrollments.classTerm.academicTerm'])
            ->orderBy('name')->get()
            ->map(function ($s) {
                $ayah = $s->parents->firstWhere('category', 'ayah');
                $ibu  = $s->parents->firstWhere('category', 'ibu');
                $namaOrtu = collect([optional($ayah)->name, optional($ibu)->name])->filter()->implode(' / ');

                $activeEnrollment = $s->enrollments->where('status', 'aktif')->sortByDesc('created_at')->first();
                $ct = $activeEnrollment?->classTerm;

                return [
                    'id'              => $s->id,
                    'nis'             => $s->nis ?? '-',
                    'nama'            => $s->name,
                    'kelas'           => $ct?->class?->name ?? '-',
                    'class_term_id'   => $ct?->id,
                    'tahun_ajaran'    => $ct?->academicTerm?->academic_year ?? '-',
                    'semester'        => $ct?->academicTerm?->semester ?? '-',
                    'enrollment_id'   => $activeEnrollment?->id,
                    'jk'              => $s->gender,
                    'jk_raw'          => $s->gender,
                    'status'          => 'Aktif',
                    'status_raw'      => 'aktif',
                    'nama_ortu'       => $namaOrtu ?: '-',
                    'email_ortu'      => $s->user?->email ?? '-',
                ];
            })->toArray();

        $classTermOptions = ClassTerm::with(['class', 'academicTerm'])
            ->where('isPass', false)
            ->whereHas('academicTerm', fn($q) => $q->whereIn('status', ['aktif', 'menunggu']))
            ->get()
            ->map(fn($ct) => [
                'id'    => $ct->id,
                'label' => 'Kelas ' . ($ct->class?->name ?? '-') . ' — ' . ($ct->academicTerm?->academic_year ?? '-') . ' ' . ucfirst($ct->academicTerm?->semester ?? ''),
            ]);

        return view('admin.siswa.index', compact('siswa', 'classTermOptions'));
    }

    public function siswaUpdateClassTerm(Request $request, $id)
    {
        $request->validate(['class_term_id' => 'required|exists:class_term,id']);

        $student = Student::findOrFail($id);

        DB::transaction(function () use ($student, $request) {
            StudentEnrollment::where('student_id', $student->id)
                ->where('status', 'aktif')
                ->update(['status' => 'pindah']);

            StudentEnrollment::firstOrCreate(
                ['student_id' => $student->id, 'class_term_id' => $request->class_term_id],
                ['status' => 'aktif']
            )->update(['status' => 'aktif']);
        });

        return redirect()->route('admin.siswa.index')->with('success', 'Kelas siswa berhasil diperbarui.');
    }

    public function siswaCreate()
    {
        return view('admin.siswa.create');
    }

    public function siswaStore(Request $request)
    {
        $request->validate([
            'nis'            => 'required|string|max:20|unique:student,nis',
            'nama'           => 'required|string|max:255',
            'jenis_kelamin'  => 'required|in:L,P',
            'agama'          => 'required|in:islam,christian,catholic,hindu,buddhism,confucianism',
            'tempat_lahir'   => 'required|string|max:100',
            'tanggal_lahir'  => 'required|date',
            'anak_ke'        => 'required|integer|min:1',
            'jumlah_saudara' => 'required|integer|min:0',
            'alamat'         => 'required|string',
            'no_telp'        => 'required|string|max:20',
            'nama_ayah'      => 'required|string|max:255',
            'nama_ibu'       => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            $student = Student::create([
                'name'            => $request->nama,
                'nickname'        => $request->nama_panggilan,
                'gender'          => $request->jenis_kelamin,
                'nis'             => $request->nis,
                'pob'             => $request->tempat_lahir,
                'dob'             => $request->tanggal_lahir,
                'religion'        => $request->agama,
                'birth_order'     => $request->anak_ke,
                'siblings_count'  => $request->jumlah_saudara,
                'ethnicity'       => $request->suku_bangsa,
                'illness_history' => $request->riwayat_penyakit,
                'weight'          => $request->berat_badan ?: null,
                'height'          => $request->tinggi_badan ?: null,
                'address'         => $request->alamat,
                'phone'           => $request->no_telp,
            ]);

            Parents::create([
                'student_id' => $student->id, 'category' => 'ayah',
                'name' => $request->nama_ayah, 'work' => $request->pekerjaan_ayah,
                'pob'  => $request->tempat_lahir_ayah, 'dob' => $request->tanggal_lahir_ayah ?: null,
            ]);

            Parents::create([
                'student_id' => $student->id, 'category' => 'ibu',
                'name' => $request->nama_ibu, 'work' => $request->pekerjaan_ibu,
                'pob'  => $request->tempat_lahir_ibu, 'dob' => $request->tanggal_lahir_ibu ?: null,
            ]);

            if ($request->filled('nama_wali')) {
                Parents::create([
                    'student_id' => $student->id, 'category' => 'wali',
                    'name' => $request->nama_wali, 'work' => $request->pekerjaan_wali,
                    'pob'  => $request->tempat_lahir_wali, 'dob' => $request->tanggal_lahir_wali ?: null,
                ]);
            }
        });

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function siswaEdit($id)
    {
        $student = Student::with(['parents', 'user', 'files'])->findOrFail($id);

        $ayah = $student->parents->firstWhere('category', 'ayah');
        $ibu  = $student->parents->firstWhere('category', 'ibu');
        $wali = $student->parents->firstWhere('category', 'wali');

        $siswa = [
            'id'               => $student->id,
            'nis'              => $student->nis ?? '',
            'nama'             => $student->name,
            'nama_panggilan'   => $student->nickname ?? '',
            'jenis_kelamin'    => $student->gender,
            'agama'            => $student->religion ?? '',
            'tempat_lahir'     => $student->pob ?? '',
            'tanggal_lahir'    => $student->dob?->format('Y-m-d') ?? '',
            'anak_ke'          => $student->birth_order ?? '',
            'jumlah_saudara'   => $student->siblings_count ?? '',
            'suku_bangsa'      => $student->ethnicity ?? '',
            'riwayat_penyakit' => $student->illness_history ?? '',
            'berat_badan'      => $student->weight ?? '',
            'tinggi_badan'     => $student->height ?? '',
            'alamat'           => $student->address ?? '',
            'no_telp'          => $student->phone ?? '',
            // Ayah
            'nama_ayah'          => optional($ayah)->name ?? '',
            'pekerjaan_ayah'     => optional($ayah)->work ?? '',
            'tempat_lahir_ayah'  => optional($ayah)->pob ?? '',
            'tanggal_lahir_ayah' => optional($ayah)->dob?->format('Y-m-d') ?? '',
            // Ibu
            'nama_ibu'          => optional($ibu)->name ?? '',
            'pekerjaan_ibu'     => optional($ibu)->work ?? '',
            'tempat_lahir_ibu'  => optional($ibu)->pob ?? '',
            'tanggal_lahir_ibu' => optional($ibu)->dob?->format('Y-m-d') ?? '',
            // Wali
            'nama_wali'          => optional($wali)->name ?? '',
            'pekerjaan_wali'     => optional($wali)->work ?? '',
            'tempat_lahir_wali'  => optional($wali)->pob ?? '',
            'tanggal_lahir_wali' => optional($wali)->dob?->format('Y-m-d') ?? '',
            // Akun orang tua
            'email_ortu'       => $student->user?->email ?? '',
            'status_akun_ortu' => $student->user?->status ?? 'active',
            // Dokumen
            'dokumen' => $student->files->map(fn($f) => [
                'id'   => $f->id,
                'type' => $f->type,
                'nama' => ucwords(str_replace('_', ' ', $f->type)),
                'file' => basename($f->path),
                'path' => $f->path,
            ])->all(),
        ];

        return view('admin.siswa.edit', compact('siswa'));
    }

    public function siswaUpdate(Request $request, $id)
    {
        $student = Student::with(['parents', 'user'])->findOrFail($id);

        $request->validate([
            'nis'            => 'required|string|max:20|unique:student,nis,' . $id,
            'nama'           => 'required|string|max:255',
            'jenis_kelamin'  => 'required|in:L,P',
            'agama'          => 'required|in:islam,christian,catholic,hindu,buddhism,confucianism',
            'tempat_lahir'   => 'required|string|max:100',
            'tanggal_lahir'  => 'required|date',
            'anak_ke'        => 'required|integer|min:1',
            'jumlah_saudara' => 'required|integer|min:0',
            'alamat'         => 'required|string',
            'no_telp'        => 'required|string|max:20',
            'nama_ayah'      => 'required|string|max:255',
            'nama_ibu'       => 'required|string|max:255',
            'status_akun_ortu' => 'nullable|in:active,pending,inactive',
        ]);

        DB::transaction(function () use ($request, $student) {
            $student->update([
                'name'            => $request->nama,
                'nickname'        => $request->nama_panggilan,
                'gender'          => $request->jenis_kelamin,
                'nis'             => $request->nis,
                'pob'             => $request->tempat_lahir,
                'dob'             => $request->tanggal_lahir,
                'religion'        => $request->agama,
                'birth_order'     => $request->anak_ke,
                'siblings_count'  => $request->jumlah_saudara,
                'ethnicity'       => $request->suku_bangsa,
                'illness_history' => $request->riwayat_penyakit,
                'weight'          => $request->berat_badan ?: null,
                'height'          => $request->tinggi_badan ?: null,
                'address'         => $request->alamat,
                'phone'           => $request->no_telp,
            ]);

            // Replace parents
            $student->parents()->delete();
            Parents::create([
                'student_id' => $student->id, 'category' => 'ayah',
                'name' => $request->nama_ayah, 'work' => $request->pekerjaan_ayah,
                'pob'  => $request->tempat_lahir_ayah, 'dob' => $request->tanggal_lahir_ayah ?: null,
            ]);
            Parents::create([
                'student_id' => $student->id, 'category' => 'ibu',
                'name' => $request->nama_ibu, 'work' => $request->pekerjaan_ibu,
                'pob'  => $request->tempat_lahir_ibu, 'dob' => $request->tanggal_lahir_ibu ?: null,
            ]);
            if ($request->filled('nama_wali')) {
                Parents::create([
                    'student_id' => $student->id, 'category' => 'wali',
                    'name' => $request->nama_wali, 'work' => $request->pekerjaan_wali,
                    'pob'  => $request->tempat_lahir_wali, 'dob' => $request->tanggal_lahir_wali ?: null,
                ]);
            }

            // Update parent user account if linked
            if ($student->user) {
                $userData = [];
                if ($request->filled('email_ortu')) {
                    $userData['email'] = $request->email_ortu;
                }
                if ($request->filled('status_akun_ortu')) {
                    $userData['status'] = $request->status_akun_ortu;
                }
                if ($request->filled('password_ortu')) {
                    $userData['password'] = Hash::make($request->password_ortu);
                }
                if (!empty($userData)) {
                    $student->user->update($userData);
                }
            }
        });

        return redirect()->route('admin.siswa.index')
            ->with('success', "Data siswa {$student->name} berhasil diperbarui!");
    }

    public function siswaDestroy($id)
    {
        $student = Student::findOrFail($id);
        $nama = $student->name;

        DB::transaction(function () use ($student) {
            $student->parents()->delete();
            $student->files()->delete();
            $student->enrollments()->delete();
            $student->delete();
        });

        return redirect()->route('admin.siswa.index')
            ->with('success', "Data siswa {$nama} berhasil dihapus!");
    }
    
    // BACKUP DATABASE
    public function backupIndex(DatabaseBackupService $service)
    {
        $backups = collect($service->list())->map(function ($b) {
            $jakarta = $b['created_at']->copy()->setTimezone('Asia/Jakarta');
            return [
                'filename'   => $b['filename'],
                'tanggal'    => $jakarta->translatedFormat('d M Y H:i') . ' WIB',
                'ukuran'     => $b['size_human'],
                'sumber'     => $b['source'],
                'created_at' => $jakarta,
            ];
        })->all();

        return view('admin.backup.index', compact('backups'));
    }

    public function backupCreate(Request $request, DatabaseBackupService $service)
    {
        try {
            $filename = $service->create('manual');
            return redirect()->route('admin.backup.index')
                ->with('success', "Backup berhasil dibuat: {$filename}");
        } catch (\Throwable $e) {
            return redirect()->route('admin.backup.index')
                ->with('error', 'Gagal membuat backup: ' . $e->getMessage());
        }
    }

    public function backupRestore(Request $request, DatabaseBackupService $service)
    {
        $data = $request->validate([
            'backup_file' => 'required|string',
            'konfirmasi'  => 'required|string',
        ]);

        if (strtoupper(trim($data['konfirmasi'])) !== 'RESTORE') {
            return redirect()->route('admin.backup.index')
                ->with('error', 'Konfirmasi tidak valid. Ketik RESTORE untuk melanjutkan.');
        }

        try {
            $service->restore($data['backup_file']);
            return redirect()->route('admin.backup.index')
                ->with('success', 'Database berhasil di-restore dari ' . $data['backup_file']);
        } catch (\Throwable $e) {
            return redirect()->route('admin.backup.index')
                ->with('error', 'Gagal restore: ' . $e->getMessage());
        }
    }

    public function backupDelete($filename, DatabaseBackupService $service)
    {
        if ($service->delete($filename)) {
            return redirect()->route('admin.backup.index')
                ->with('success', "File backup {$filename} berhasil dihapus.");
        }
        return redirect()->route('admin.backup.index')
            ->with('error', "File backup tidak ditemukan: {$filename}");
    }

    public function backupDownload($filename, DatabaseBackupService $service)
    {
        $path = $service->path($filename);
        if (! $path) {
            return redirect()->route('admin.backup.index')
                ->with('error', "File backup tidak ditemukan: {$filename}");
        }
        return response()->download($path, basename($filename), [
            'Content-Type' => 'application/sql',
        ]);
    }
    
    // KELOLA PENDAFTARAN
    private function statusLabel(string $status): string
    {
        return match($status) {
            'active'   => 'Diterima',
            'inactive' => 'Ditolak',
            default    => 'Pending',
        };
    }

    private function genderLabel(?string $gender): string
    {
        return match($gender) {
            'L' => 'Laki-laki',
            'P' => 'Perempuan',
            default => '-',
        };
    }

    private function religionLabel(?string $religion): string
    {
        return match($religion) {
            'islam'        => 'Islam',
            'christian'    => 'Kristen',
            'catholic'     => 'Katolik',
            'hindu'        => 'Hindu',
            'buddhism'     => 'Buddha',
            'confucianism' => 'Konghucu',
            default => '-',
        };
    }

    private function buildPendaftaranRow(User $u): array
    {
        $s      = $u->student;
        $ayah   = $s?->parents->firstWhere('category', 'ayah');
        $ibu    = $s?->parents->firstWhere('category', 'ibu');
        $wali   = $s?->parents->firstWhere('category', 'wali');

        $typeLabel = ['akta' => 'Akta Kelahiran', 'kk' => 'Kartu Keluarga', 'foto' => 'Foto', 'ktp_ortu' => 'KTP Orang Tua', 'lainnya' => 'Lainnya'];

        return [
            'id'                 => $u->id,
            'tanggal_daftar'     => optional($u->created_at)->translatedFormat('d M Y') ?? '-',
            'tanggal_daftar_iso' => optional($u->created_at)->format('Y-m-d') ?? '',
            'status'             => $this->statusLabel($u->status ?? 'pending'),

            'nama_siswa'         => $s?->name ?? '-',
            'nama_panggilan'     => $s?->nickname ?? '-',
            'nik'                => $s?->nik ?? '-',
            'jenis_kelamin'      => $this->genderLabel($s?->gender),
            'agama'              => $s?->religion ?? '-',
            'tempat_lahir'       => $s?->pob ?? '-',
            'tanggal_lahir'      => optional($s?->dob)->translatedFormat('d F Y') ?? '-',
            'anak_ke'            => $s?->birth_order ?? '-',
            'jumlah_saudara'     => $s?->siblings_count ?? '-',
            'suku_bangsa'        => $s?->ethnicity ?? '-',
            'riwayat_penyakit'   => $s?->illness_history ?? '-',
            'berat_badan'        => $s?->weight ? $s->weight . ' kg' : '-',
            'tinggi_badan'       => $s?->height ? $s->height . ' cm' : '-',
            'alamat_siswa'       => $s?->address ?? '-',

            'nama_ayah'          => $ayah?->name ?? '-',
            'pekerjaan_ayah'     => $ayah?->work ?? '-',
            'pendidikan_ayah'    => $ayah?->education ?? '-',
            'tempat_lahir_ayah'  => $ayah?->pob ?? '-',
            'tanggal_lahir_ayah' => optional($ayah?->dob)->translatedFormat('d F Y') ?? '-',
            'no_telp_ayah'       => $u->phone ?? '-',

            'nama_ibu'           => $ibu?->name ?? '-',
            'pekerjaan_ibu'      => $ibu?->work ?? '-',
            'pendidikan_ibu'     => $ibu?->education ?? '-',
            'tempat_lahir_ibu'   => $ibu?->pob ?? '-',
            'tanggal_lahir_ibu'  => optional($ibu?->dob)->translatedFormat('d F Y') ?? '-',
            'no_telp_ibu'        => '-',

            'nama_wali'          => $wali?->name ?? '-',
            'pekerjaan_wali'     => $wali?->work ?? '-',
            'pendidikan_wali'    => $wali?->education ?? '-',
            'tempat_lahir_wali'  => $wali?->pob ?? '-',
            'tanggal_lahir_wali' => optional($wali?->dob)->translatedFormat('d F Y') ?? '-',
            'no_telp_wali'       => '-',

            'telepon'            => $u->phone ?? '-',
            'email'              => $u->email ?? '-',
            'alamat_ortu'        => $s?->address ?? '-',

            'dokumen'            => $s?->files->map(fn($f) => [
                'id'   => $f->id,
                'nama' => $typeLabel[$f->type] ?? ucfirst($f->type),
                'file' => $f->path,
            ])->all() ?? [],
        ];
    }

    public function pendaftaranIndex()
    {
        $users = User::where('role', 'orangtua')
            ->with(['student.parents', 'student.files'])
            ->orderByDesc('created_at')
            ->get();

        $pendaftaran   = $users->map(fn($u) => $this->buildPendaftaranRow($u))->all();
        $totalPending  = $users->where('status', 'pending')->count();
        $totalDiterima = $users->where('status', 'active')->count();
        $totalDitolak  = $users->where('status', 'inactive')->count();
        $totalSemua    = $users->count();

        $kelasList       = Classroom::orderBy('name')->get();
        $academicTermList = AcademicTerm::orderBy('academic_year')->orderBy('semester')->get();

        return view('admin.pendaftaran.index', compact(
            'pendaftaran', 'totalPending', 'totalDiterima', 'totalDitolak', 'totalSemua',
            'kelasList', 'academicTermList'
        ));
    }

    public function pendaftaranShow($id)
    {
        $user = User::with(['student.parents', 'student.files'])->findOrFail($id);

        $pendaftaran      = $this->buildPendaftaranRow($user);
        $kelasList        = Classroom::orderBy('name')->get();
        $academicTermList = AcademicTerm::orderBy('academic_year')->orderBy('semester')->get();

        return view('admin.pendaftaran.show', compact('pendaftaran', 'kelasList', 'academicTermList'));
    }

    public function pendaftaranTerima(Request $request, $id)
    {
        $request->validate([
            'class_id'         => 'required|exists:class,id',
            'academic_term_id' => 'required|exists:academic_term,id',
        ]);

        $user = User::with('student')->findOrFail($id);

        DB::transaction(function () use ($user, $request) {
            $user->update(['status' => 'active']);

            if ($user->student) {
                $classTerm = ClassTerm::firstOrCreate([
                    'class_id'         => $request->class_id,
                    'academic_term_id' => $request->academic_term_id,
                ]);

                StudentEnrollment::firstOrCreate(
                    ['student_id' => $user->student->id, 'class_term_id' => $classTerm->id],
                    ['status' => 'aktif']
                );
            }
        });

        return redirect()->route('admin.pendaftaran.index')
            ->with('success', "Pendaftaran {$user->student?->name} telah diterima. Akun orang tua sekarang aktif.");
    }

    public function pendaftaranTolak(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'inactive']);

        return redirect()->route('admin.pendaftaran.index')
            ->with('success', "Pendaftaran {$user->student?->name} telah ditolak.");
    }
    
    // KELOLA TAHUN AJARAN
    public function tahunAjaranIndex()
    {
        $data = AcademicTerm::orderBy('academic_year')->orderBy('semester')->get();
        return view('admin.tahun_ajaran.index', compact('data'));
    }

    public function tahunAjaranShow($id)
    {
        $academicTerm = AcademicTerm::with([
            'classTerms.class',
            'classTerms.enrollments.student',
        ])->findOrFail($id);

        $existingClassIds  = $academicTerm->classTerms->pluck('class_id')->toArray();
        $availableClasses  = Classroom::whereNotIn('id', $existingClassIds)->orderBy('name')->get();

        return view('admin.tahun_ajaran.show', compact('academicTerm', 'availableClasses'));
    }

    public function tahunAjaranClassTermStore(Request $request, $id)
    {
        $request->validate([
            'class_ids'   => 'required|array|min:1',
            'class_ids.*' => 'required|string|exists:class,id',
        ], [
            'class_ids.required' => 'Pilih minimal satu kelas.',
        ]);

        $academicTerm    = AcademicTerm::findOrFail($id);
        $existingClassIds = $academicTerm->classTerms()->pluck('class_id')->toArray();

        DB::transaction(function () use ($request, $academicTerm, $existingClassIds) {
            foreach ($request->class_ids as $classId) {
                if (!in_array($classId, $existingClassIds)) {
                    ClassTerm::create([
                        'class_id'         => $classId,
                        'academic_term_id' => $academicTerm->id,
                    ]);
                }
            }
        });

        return redirect()->route('admin.tahun_ajaran.show', $id)
            ->with('success', 'Kelas berhasil ditambahkan ke tahun ajaran ini.');
    }

    public function tahunAjaranClassTermDestroy($id, $classTermId)
    {
        $classTerm = ClassTerm::where('id', $classTermId)
            ->where('academic_term_id', $id)
            ->firstOrFail();

        if ($classTerm->enrollments()->count() > 0) {
            return redirect()->route('admin.tahun_ajaran.show', $id)
                ->with('error', 'Kelas tidak dapat dihapus karena masih memiliki siswa terdaftar.');
        }

        $classTerm->delete();

        return redirect()->route('admin.tahun_ajaran.show', $id)
            ->with('success', 'Kelas berhasil dihapus dari tahun ajaran ini.');
    }

    public function tahunAjaranCreate()
    {
        return view('admin.tahun_ajaran.create');
    }

    public function tahunAjaranStore(Request $request)
    {
        $request->validate([
            'academic_year' => 'required|string|max:20',
            'semester'      => 'required|in:ganjil,genap',
            'status'        => 'required|in:menunggu,aktif,selesai',
        ]);

        AcademicTerm::create([
            'academic_year' => $request->academic_year,
            'semester'      => $request->semester,
            'status'        => $request->status,
        ]);

        return redirect()->route('admin.tahun_ajaran.index')
            ->with('success', "Tahun Ajaran {$request->academic_year} Semester " . ucfirst($request->semester) . " berhasil ditambahkan.");
    }

    public function tahunAjaranEdit($id)
    {
        $item = AcademicTerm::findOrFail($id);
        return view('admin.tahun_ajaran.edit', compact('item'));
    }

    public function tahunAjaranUpdate(Request $request, $id)
    {
        $request->validate([
            'academic_year' => 'required|string|max:20',
            'semester'      => 'required|in:ganjil,genap',
            'status'        => 'required|in:menunggu,aktif,selesai',
        ]);

        $item = AcademicTerm::findOrFail($id);
        $item->update([
            'academic_year' => $request->academic_year,
            'semester'      => $request->semester,
            'status'        => $request->status,
        ]);

        return redirect()->route('admin.tahun_ajaran.index')
            ->with('success', "Tahun Ajaran {$item->academic_year} Semester " . ucfirst($item->semester) . " berhasil diperbarui.");
    }

    public function tahunAjaranDestroy($id)
    {
        $item = AcademicTerm::findOrFail($id);
        $label = "{$item->academic_year} " . ucfirst($item->semester);
        $item->delete();

        return redirect()->route('admin.tahun_ajaran.index')
            ->with('success', "Tahun Ajaran {$label} berhasil dihapus.");
    }

    // ═══════════════════════════════════════════════════════
    // KELOLA KELAS
    // ═══════════════════════════════════════════════════════
    public function kelasIndex()
    {
        $kelas = Classroom::orderBy('name')->get();
        return view('admin.kelas.index', compact('kelas'));
    }

    public function kelasCreate()
    {
        return view('admin.kelas.create');
    }

    public function kelasStore(Request $request)
    {
        $request->validate([
            'nama'            => 'required|string|max:20|unique:class,name',
            'jumlah_maksimum' => 'required|integer|min:1|max:50',
        ]);

        Classroom::create([
            'name'    => $request->nama,
            'maximum' => $request->jumlah_maksimum,
        ]);

        return redirect()->route('admin.kelas.index')
            ->with('success', "Kelas {$request->nama} berhasil ditambahkan.");
    }

    public function kelasEdit($id)
    {
        $kelas = Classroom::findOrFail($id);
        return view('admin.kelas.edit', compact('kelas'));
    }

    public function kelasUpdate(Request $request, $id)
    {
        $kelas = Classroom::findOrFail($id);

        $request->validate([
            'nama'            => 'required|string|max:20|unique:class,name,' . $id,
            'jumlah_maksimum' => 'required|integer|min:1|max:50',
        ]);

        $kelas->update([
            'name'    => $request->nama,
            'maximum' => $request->jumlah_maksimum,
        ]);

        return redirect()->route('admin.kelas.index')
            ->with('success', "Kelas {$request->nama} berhasil diperbarui.");
    }

    public function kelasDestroy($id)
    {
        $kelas = Classroom::findOrFail($id);
        $nama  = $kelas->name;
        $kelas->delete();

        return redirect()->route('admin.kelas.index')
            ->with('success', "Kelas {$nama} berhasil dihapus.");
    }

    // ═══════════════════════════════════════════════════════
    // KELOLA EKSTRAKURIKULER (DUMMY)
    // ═══════════════════════════════════════════════════════
    private function dummyEkstrakurikuler()
    {
        return [
            [
                'id'        => 1,
                'nama'      => 'Menari',
                'penilaian' => [
                    ['id' => 1, 'nama' => 'Kelenturan'],
                    ['id' => 2, 'nama' => 'Ekspresi'],
                    ['id' => 3, 'nama' => 'Hafalan Gerakan'],
                ],
            ],
            [
                'id'        => 2,
                'nama'      => 'Mewarnai',
                'penilaian' => [
                    ['id' => 4, 'nama' => 'Kerapian'],
                    ['id' => 5, 'nama' => 'Kreativitas Warna'],
                    ['id' => 6, 'nama' => 'Ketepatan Bidang'],
                ],
            ],
            [
                'id'        => 3,
                'nama'      => 'Sains Sederhana',
                'penilaian' => [
                    ['id' => 7, 'nama' => 'Rasa Ingin Tahu'],
                    ['id' => 8, 'nama' => 'Ketelitian'],
                ],
            ],
            [
                'id'        => 4,
                'nama'      => 'Bercerita',
                'penilaian' => [
                    ['id' => 9,  'nama' => 'Kelancaran'],
                    ['id' => 10, 'nama' => 'Intonasi'],
                    ['id' => 11, 'nama' => 'Kepercayaan Diri'],
                ],
            ],
        ];
    }

    public function ekstrakurikulerIndex()
    {
        $ekstrakurikuler = Extracurricular::with('assessments')->orderBy('name')->get();
        return view('admin.ekstrakurikuler.index', compact('ekstrakurikuler'));
    }

    public function ekstrakurikulerCreate()
    {
        return view('admin.ekstrakurikuler.create');
    }

    public function ekstrakurikulerStore(Request $request)
    {
        $request->validate([
            'nama'        => 'required|string|max:100',
            'penilaian'   => 'nullable|array',
            'penilaian.*' => 'nullable|string|max:100',
        ]);

        DB::transaction(function () use ($request) {
            $ekskul = Extracurricular::create(['name' => $request->nama]);
            foreach (array_filter($request->penilaian ?? []) as $poin) {
                ExtracurricularAssessment::create([
                    'extracurricular_id' => $ekskul->id,
                    'name'               => $poin,
                ]);
            }
        });

        return redirect()->route('admin.ekstrakurikuler.index')
            ->with('success', "Ekstrakurikuler {$request->nama} berhasil ditambahkan.");
    }

    public function ekstrakurikulerEdit($id)
    {
        $ekstrakurikuler = Extracurricular::with('assessments')->findOrFail($id);
        return view('admin.ekstrakurikuler.edit', compact('ekstrakurikuler'));
    }

    public function ekstrakurikulerUpdate(Request $request, $id)
    {
        $request->validate([
            'nama'        => 'required|string|max:100',
            'penilaian'   => 'nullable|array',
            'penilaian.*' => 'nullable|string|max:100',
        ]);

        $ekskul = Extracurricular::findOrFail($id);

        DB::transaction(function () use ($request, $ekskul) {
            $ekskul->update(['name' => $request->nama]);
            $ekskul->assessments()->delete();
            foreach (array_filter($request->penilaian ?? []) as $poin) {
                ExtracurricularAssessment::create([
                    'extracurricular_id' => $ekskul->id,
                    'name'               => $poin,
                ]);
            }
        });

        return redirect()->route('admin.ekstrakurikuler.index')
            ->with('success', "Ekstrakurikuler {$request->nama} berhasil diperbarui.");
    }

    public function ekstrakurikulerDestroy($id)
    {
        $ekskul = Extracurricular::findOrFail($id);
        $nama   = $ekskul->name;

        DB::transaction(function () use ($ekskul) {
            $ekskul->assessments()->delete();
            $ekskul->delete();
        });

        return redirect()->route('admin.ekstrakurikuler.index')
            ->with('success', "Ekstrakurikuler {$nama} berhasil dihapus.");
    }

    // ═══════════════════════════════════════════════════════
    // KELOLA KONSELING (DUMMY)
    // ═══════════════════════════════════════════════════════
    public function konselingIndex()
    {
        $konseling = Counseling::with('assessments')->orderBy('name')->get();
        return view('admin.konseling.index', compact('konseling'));
    }

    public function konselingCreate()
    {
        return view('admin.konseling.create');
    }

    public function konselingStore(Request $request)
    {
        $request->validate([
            'nama'        => 'required|string|max:100',
            'penilaian'   => 'nullable|array',
            'penilaian.*' => 'nullable|string|max:100',
        ]);

        DB::transaction(function () use ($request) {
            $konseling = Counseling::create(['name' => $request->nama]);
            foreach (array_filter($request->penilaian ?? []) as $poin) {
                CounselingAssessment::create([
                    'counseling_id' => $konseling->id,
                    'name'          => $poin,
                ]);
            }
        });

        return redirect()->route('admin.konseling.index')
            ->with('success', "Konseling {$request->nama} berhasil ditambahkan.");
    }

    public function konselingEdit($id)
    {
        $konseling = Counseling::with('assessments')->findOrFail($id);
        return view('admin.konseling.edit', compact('konseling'));
    }

    public function konselingUpdate(Request $request, $id)
    {
        $request->validate([
            'nama'        => 'required|string|max:100',
            'penilaian'   => 'nullable|array',
            'penilaian.*' => 'nullable|string|max:100',
        ]);

        $konseling = Counseling::findOrFail($id);

        DB::transaction(function () use ($request, $konseling) {
            $konseling->update(['name' => $request->nama]);
            $konseling->assessments()->delete();
            foreach (array_filter($request->penilaian ?? []) as $poin) {
                CounselingAssessment::create([
                    'counseling_id' => $konseling->id,
                    'name'          => $poin,
                ]);
            }
        });

        return redirect()->route('admin.konseling.index')
            ->with('success', "Konseling {$request->nama} berhasil diperbarui.");
    }

    public function konselingDestroy($id)
    {
        $konseling = Counseling::findOrFail($id);
        $nama = $konseling->name;

        DB::transaction(function () use ($konseling) {
            $konseling->assessments()->delete();
            $konseling->delete();
        });

        return redirect()->route('admin.konseling.index')
            ->with('success', "Konseling {$nama} berhasil dihapus.");
    }

    // ═══════════════════════════════════════════════════════
    // KELOLA MATA PELAJARAN (DUMMY)
    // ═══════════════════════════════════════════════════════
    public function mataPelajaranIndex()
    {
        $mataPelajaran = Subject::orderBy('name')->get();
        return view('admin.mata_pelajaran.index', compact('mataPelajaran'));
    }

    public function mataPelajaranCreate()
    {
        return view('admin.mata_pelajaran.create');
    }

    public function mataPelajaranStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:subject,name',
        ]);

        Subject::create(['name' => $request->nama]);

        return redirect()->route('admin.mata_pelajaran.index')
            ->with('success', "Mata pelajaran {$request->nama} berhasil ditambahkan.");
    }

    public function mataPelajaranEdit($id)
    {
        $mataPelajaran = Subject::findOrFail($id);
        return view('admin.mata_pelajaran.edit', compact('mataPelajaran'));
    }

    public function mataPelajaranUpdate(Request $request, $id)
    {
        $mataPelajaran = Subject::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100|unique:subject,name,' . $id,
        ]);

        $mataPelajaran->update(['name' => $request->nama]);

        return redirect()->route('admin.mata_pelajaran.index')
            ->with('success', "Mata pelajaran {$request->nama} berhasil diperbarui.");
    }

    public function mataPelajaranDestroy($id)
    {
        $mataPelajaran = Subject::findOrFail($id);
        $nama = $mataPelajaran->name;
        $mataPelajaran->delete();

        return redirect()->route('admin.mata_pelajaran.index')
            ->with('success', "Mata pelajaran {$nama} berhasil dihapus.");
    }

    // ═══════════════════════════════════════════════════════
    // KELOLA AKTIVITAS TAHUN AJARAN
    // Mengaitkan mata pelajaran, ekstrakurikuler, konseling ke class_term (tahun ajaran)
    // ═══════════════════════════════════════════════════════
    public function aktivitasTahunAjaranIndex()
    {
        $academicTerms = AcademicTerm::withCount('classTerms')
            ->orderBy('academic_year')->orderBy('semester')->get();
        return view('admin.aktivitas_tahun_ajaran.index', compact('academicTerms'));
    }

    public function aktivitasTahunAjaranShow($id)
    {
        $academicTerm = AcademicTerm::with([
            'classTerms.class',
            'classTerms.subjects.subject',
            'classTerms.extracurriculars.extracurricular',
            'classTerms.counselings.counseling',
        ])->findOrFail($id);
        return view('admin.aktivitas_tahun_ajaran.show', compact('academicTerm'));
    }

    public function aktivitasTahunAjaranEdit($id)
    {
        $classTerm = ClassTerm::with([
            'academicTerm', 'class',
            'subjects', 'extracurriculars', 'counselings',
        ])->findOrFail($id);

        $mataPelajaran   = Subject::orderBy('name')->get();
        $ekstrakurikuler = Extracurricular::orderBy('name')->get();
        $konseling       = Counseling::orderBy('name')->get();

        $assigned = [
            'mata_pelajaran_ids'  => $classTerm->subjects->pluck('subject_id')->all(),
            'ekstrakurikuler_ids' => $classTerm->extracurriculars->pluck('extracurricular_id')->all(),
            'konseling_ids'       => $classTerm->counselings->pluck('counseling_id')->all(),
        ];

        return view('admin.aktivitas_tahun_ajaran.edit', compact(
            'classTerm', 'mataPelajaran', 'ekstrakurikuler', 'konseling', 'assigned'
        ));
    }

    public function aktivitasTahunAjaranUpdate(Request $request, $id)
    {
        $classTerm = ClassTerm::with('academicTerm', 'class')->findOrFail($id);

        $request->validate([
            'mata_pelajaran_ids'    => 'nullable|array',
            'mata_pelajaran_ids.*'  => 'string|exists:subject,id',
            'ekstrakurikuler_ids'   => 'nullable|array',
            'ekstrakurikuler_ids.*' => 'string|exists:extracurricular,id',
            'konseling_ids'         => 'nullable|array',
            'konseling_ids.*'       => 'string|exists:counseling,id',
        ]);

        $subjectIds   = $request->mata_pelajaran_ids ?? [];
        $ekskuIds     = $request->ekstrakurikuler_ids ?? [];
        $konselingIds = $request->konseling_ids ?? [];

        DB::transaction(function () use ($classTerm, $subjectIds, $ekskuIds, $konselingIds) {
            $classTerm->subjects()->delete();
            foreach ($subjectIds as $sid) {
                ClassTermSubject::create(['class_term_id' => $classTerm->id, 'subject_id' => $sid]);
            }
            $classTerm->extracurriculars()->delete();
            foreach ($ekskuIds as $eid) {
                ClassTermExtracurricular::create(['class_term_id' => $classTerm->id, 'extracurricular_id' => $eid]);
            }
            $classTerm->counselings()->delete();
            foreach ($konselingIds as $kid) {
                ClassTermCounseling::create(['class_term_id' => $classTerm->id, 'counseling_id' => $kid]);
            }
        });

        return redirect()->route('admin.aktivitas_tahun_ajaran.show', $classTerm->academic_term_id)
            ->with('success', "Aktivitas kelas {$classTerm->class?->name} berhasil diperbarui.");
    }

    // ═══════════════════════════════════════════════════════
    // REKAP DATA DAPODIK
    // ═══════════════════════════════════════════════════════
    public function dapodikIndex(Request $request)
    {
        // Daftar academic term untuk dropdown
        $academicTerms = AcademicTerm::orderByDesc('academic_year')
            ->orderBy('semester')
            ->get()
            ->map(fn($t) => [
                'id'    => $t->id,
                'label' => $t->academic_year . ' — ' . ucfirst($t->semester),
                'year'  => $t->academic_year,
                'sem'   => $t->semester,
            ]);

        $selectedTermId = $request->input('academic_term_id');

        // Default: belum pilih → siapkan default ke yang aktif (atau term pertama)
        if (!$selectedTermId && $academicTerms->isNotEmpty()) {
            $activeTerm = AcademicTerm::where('status', 'aktif')->first()
                ?? AcademicTerm::orderByDesc('academic_year')->orderBy('semester')->first();
            $selectedTermId = $activeTerm?->id;
        }

        $siswa = [];
        $selectedTerm = null;

        if ($selectedTermId) {
            $selectedTerm = AcademicTerm::find($selectedTermId);

            // Ambil semua enrollment di semua class_term yang relasi ke academic_term ini
            $enrollments = StudentEnrollment::whereHas('classTerm', fn($q) =>
                    $q->where('academic_term_id', $selectedTermId))
                ->with(['student.parents', 'classTerm.class'])
                ->get();

            // Group by siswa (jaga unique) lalu map
            $uniqueByStudent = $enrollments->unique('student_id');

            $siswa = $uniqueByStudent->map(function ($e) {
                $s = $e->student;
                $kelas = $e->classTerm?->class?->name;
                $ayah = $s->parents->firstWhere('category', 'ayah');
                $ibu  = $s->parents->firstWhere('category', 'ibu');

                return [
                    'id'             => $s->id,
                    'nisn'           => $s->nisn ?? '-',
                    'nik'            => $s->nik ?? '-',
                    'nama'           => $s->name,
                    'jenis_kelamin'  => $s->gender === 'L' ? 'Laki-laki' : 'Perempuan',
                    'tempat_lahir'   => $s->pob ?? $s->tempat_lahir ?? '-',
                    'tanggal_lahir'  => $s->dob ? \Carbon\Carbon::parse($s->dob)->translatedFormat('d M Y') : '-',
                    'agama'          => $this->religionLabel($s->religion),
                    'alamat'         => $s->address ?? '-',
                    'hp'             => $s->phone ?? $s->telepon ?? '-',
                    'nama_ayah'      => optional($ayah)->name ?? $s->nama_ayah ?? '-',
                    'pekerjaan_ayah' => optional($ayah)->work ?? $s->pekerjaan_ayah ?? '-',
                    'nama_ibu'       => optional($ibu)->name ?? $s->nama_ibu ?? '-',
                    'pekerjaan_ibu'  => optional($ibu)->work ?? $s->pekerjaan_ibu ?? '-',
                    'kelas'          => $kelas ?? '-',
                    'rombel'         => $kelas ?? '-',
                    'nomor_induk'    => $s->nis ?? $s->nomor_induk ?? '-',
                    'status'         => 'Aktif',
                ];
            })->sortBy(fn($s) => [$s['kelas'], $s['nama']])->values()->all();
        }

        // Apply filter di view (search/kelas/jenis_kelamin)
        if ($request->filled('search')) {
            $q = strtolower($request->input('search'));
            $siswa = array_values(array_filter($siswa, fn($s) =>
                str_contains(strtolower($s['nama']), $q) ||
                str_contains(strtolower($s['nisn']), $q) ||
                str_contains(strtolower($s['nik']), $q)
            ));
        }
        if ($request->filled('kelas') && $request->input('kelas') !== 'semua') {
            $kFilter = $request->input('kelas');
            $siswa = array_values(array_filter($siswa, fn($s) => $s['kelas'] === $kFilter));
        }
        if ($request->filled('jenis_kelamin') && $request->input('jenis_kelamin') !== 'semua') {
            $jkFilter = $request->input('jenis_kelamin');
            $siswa = array_values(array_filter($siswa, fn($s) => $s['jenis_kelamin'] === $jkFilter));
        }

        $totalSiswa     = count($siswa);
        $totalLaki      = collect($siswa)->where('jenis_kelamin', 'Laki-laki')->count();
        $totalPerempuan = collect($siswa)->where('jenis_kelamin', 'Perempuan')->count();
        $totalTKA       = collect($siswa)->where('kelas', 'A')->count();
        $totalTKB       = collect($siswa)->filter(fn($s) => in_array($s['kelas'], ['B1', 'B2']))->count();

        return view('admin.dapodik.index', compact(
            'siswa', 'totalSiswa', 'totalLaki', 'totalPerempuan', 'totalTKA', 'totalTKB',
            'academicTerms', 'selectedTermId', 'selectedTerm'
        ));
    }

    public function dapodikExport(Request $request)
    {
        $termId = $request->input('academic_term_id');
        if (!$termId) {
            return redirect()->route('admin.dapodik.index')
                ->with('error', 'Pilih tahun ajaran terlebih dahulu.');
        }

        $term = AcademicTerm::findOrFail($termId);
        $filename = 'DAPODIK_TK_AL-ISTIQOMAH_' . str_replace('/', '-', $term->academic_year)
            . '_' . ucfirst($term->semester) . '.xlsx';

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\DapodikExport($termId),
            $filename
        );
    }

    // ═══════════════════════════════════════════════════════
    // KENAIKAN SISWA
    // ═══════════════════════════════════════════════════════

    public function kenaikanIndex()
    {
        $classTerms = ClassTerm::with(['class', 'academicTerm', 'enrollments'])
            ->get()
            ->map(function ($ct) {
                $status = $ct->isPass
                    ? 'selesai'
                    : ($ct->academicTerm?->status ?? 'menunggu');

                return [
                    'id'           => $ct->id,
                    'kelas_nama'   => $ct->class?->name ?? '-',
                    'tahun_ajaran' => $ct->academicTerm?->academic_year ?? '-',
                    'semester'     => $ct->academicTerm?->semester ?? '-',
                    'status'       => $status,
                    'isPass'       => $ct->isPass,
                    'jumlah_siswa' => $ct->enrollments->count(),
                ];
            });

        $grouped = $classTerms->groupBy('tahun_ajaran');

        return view('admin.kenaikan.index', compact('grouped'));
    }

    public function kenaikanDetail($id)
    {
        $ct = ClassTerm::with([
            'class',
            'academicTerm',
            'enrollments.student',
            'enrollments.classTermTujuan.class',
            'enrollments.classTermTujuan.academicTerm',
        ])->findOrFail($id);

        if (!$ct->isPass) {
            return redirect()->route('admin.kenaikan.index')
                ->with('error', 'Detail hanya tersedia untuk class term yang sudah diproses.');
        }

        $classTerm = [
            'kelas_nama'   => $ct->class?->name ?? '-',
            'tahun_ajaran' => $ct->academicTerm?->academic_year ?? '-',
            'semester'     => $ct->academicTerm?->semester ?? '-',
        ];

        $history = $ct->enrollments->map(function ($e) {
            $tujuan = $e->classTermTujuan
                ? ($e->classTermTujuan->class?->name ?? '-') . ' — ' .
                  ($e->classTermTujuan->academicTerm?->academic_year ?? '-') . ' ' .
                  ucfirst($e->classTermTujuan->academicTerm?->semester ?? '')
                : '-';

            return [
                'siswa_nama'        => $e->student?->name ?? '-',
                'nis'               => $e->student?->nis ?? '-',
                'nisn'              => $e->student?->nisn ?? '-',
                'gender'            => $e->student?->gender ?? '-',
                'enrollment_status' => $e->status,
                'aksi'              => $e->aksi ?? '-',
                'class_term_tujuan' => $tujuan,
            ];
        })->all();

        return view('admin.kenaikan.detail', compact('classTerm', 'history'));
    }

    public function kenaikanShow($id)
    {
        $ct = ClassTerm::with([
            'class',
            'academicTerm',
            'enrollments.student',
        ])->findOrFail($id);

        $academicTermStatus = $ct->academicTerm?->status ?? 'menunggu';
        if ($ct->isPass || $academicTermStatus !== 'aktif') {
            return redirect()->route('admin.kenaikan.index')
                ->with('error', 'Class term ini tidak dapat diproses kenaikan.');
        }

        $classTerm = [
            'id'           => $ct->id,
            'kelas_nama'   => $ct->class?->name ?? '-',
            'tahun_ajaran' => $ct->academicTerm?->academic_year ?? '-',
            'semester'     => $ct->academicTerm?->semester ?? '-',
        ];

        $siswaList = $ct->enrollments
            ->where('status', 'aktif')
            ->map(fn($e) => [
                'student_id' => $e->student_id,
                'nama'       => $e->student?->name ?? '-',
                'nis'        => $e->student?->nis ?? '-',
                'gender'     => $e->student?->gender ?? '-',
            ])
            ->values();

        $classTermOptions = ClassTerm::with(['class', 'academicTerm'])
            ->where('id', '!=', $id)
            ->get()
            ->map(fn($c) => [
                'id'           => $c->id,
                'kelas_nama'   => $c->class?->name ?? '-',
                'tahun_ajaran' => $c->academicTerm?->academic_year ?? '-',
                'semester'     => $c->academicTerm?->semester ?? '-',
            ]);

        return view('admin.kenaikan.show', compact('classTerm', 'siswaList', 'classTermOptions'));
    }

    public function kenaikanProses(Request $request, $id)
    {
        $request->validate([
            'siswa'                        => 'required|array|min:1',
            'siswa.*.student_id'           => 'required|string|exists:student,id',
            'siswa.*.aksi'                 => 'required|in:ganti_semester,ganti_kelas,tinggal_kelas',
            'siswa.*.class_term_tujuan_id' => 'required|string|exists:class_term,id',
        ]);

        $classTerm = ClassTerm::findOrFail($id);

        DB::transaction(function () use ($request, $classTerm) {
            foreach ($request->siswa as $item) {
                $studentId         = $item['student_id'];
                $aksi              = $item['aksi'];
                $classTermTujuanId = $item['class_term_tujuan_id'];

                $enrollmentStatus = $aksi === 'tinggal_kelas' ? 'tinggal' : 'naik';

                StudentEnrollment::where('student_id', $studentId)
                    ->where('class_term_id', $classTerm->id)
                    ->where('status', 'aktif')
                    ->update([
                        'status'               => $enrollmentStatus,
                        'aksi'                 => $aksi,
                        'class_term_tujuan_id' => $classTermTujuanId,
                    ]);

                StudentEnrollment::firstOrCreate(
                    ['student_id' => $studentId, 'class_term_id' => $classTermTujuanId],
                    ['status' => 'aktif']
                );
            }

            $classTerm->update(['isPass' => true]);
        });

        return redirect()->route('admin.kenaikan.index')
            ->with('success', 'Proses kenaikan siswa berhasil disimpan. Class term telah ditutup.');
    }
}
