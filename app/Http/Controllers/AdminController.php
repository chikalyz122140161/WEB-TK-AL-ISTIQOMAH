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
            'status'     => $statusMap[$u->status] ?? ucfirst($u->status),
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
            'status'        => ucfirst($user->status),
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
        $siswa = Student::with('parents')
            ->orderBy('kelas')->orderBy('name')->get()
            ->map(function ($s) {
                // Ambil nama ortu dari relasi `parents` (ERD baru); fallback ke legacy field
                $ayah = optional($s->parents->firstWhere('category', 'ayah'))->name ?? $s->nama_ayah;
                $ibu  = optional($s->parents->firstWhere('category', 'ibu'))->name  ?? $s->nama_ibu;
                $namaOrtu = collect([$ayah, $ibu])->filter()->implode(' / ');

                return [
                    'id'         => $s->id,
                    'nis'        => $s->nis ?? $s->nomor_induk ?? '-',
                    'nama'       => $s->name,
                    'kelas'      => $s->kelas ? 'TK ' . $s->kelas : '-',
                    'jk'         => $s->gender,
                    'status'     => 'Aktif',
                    'nama_ortu'  => $namaOrtu ?: '-',
                    'email_ortu' => '-',
                ];
            })->toArray();

        return view('admin.siswa.index', compact('siswa'));
    }
    
    public function siswaCreate()
    {
        return view('admin.siswa.create');
    }
    
    public function siswaStore(Request $request)
    {
        // Dummy - redirect with success
        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil ditambahkan!');
    }
    
    public function siswaEdit($id)
    {
        // Get siswa by id with related orangtua data - sesuai form pendaftaran fisik
        $siswa = [
            'id' => $id,
            'nis' => '2024001',
            // I. Identitas Anak
            'nama' => 'Erlangga Pradipa Bimantara',
            'nama_panggilan' => 'Angga',
            'jenis_kelamin' => 'Laki-laki',
            'tempat_lahir' => 'Bandar Lampung',
            'tanggal_lahir' => '2021-09-25',
            'anak_ke' => 2,
            'jumlah_saudara' => 1,
            'agama' => 'Islam',
            'suku_bangsa' => '',
            'berat_badan' => '13',
            'tinggi_badan' => '',
            'riwayat_penyakit' => '',
            'alamat' => 'Jl. Harum Bunga Perumahan Panca Bakti Bandar Lampung',
            'no_telp' => '0822 8965 2973',
            'kelas' => 'TK A',
            'status' => 'Pending',
            // II. Identitas Orang Tua / Wali Murid
            // 1. Ayah
            'nama_ayah' => 'Sudir',
            'tempat_lahir_ayah' => 'Pemalang',
            'tanggal_lahir_ayah' => '1982-09-01',
            'pekerjaan_ayah' => 'Buruh',
            // 2. Ibu
            'nama_ibu' => 'Julia Sari',
            'tempat_lahir_ibu' => 'Teratkulon',
            'tanggal_lahir_ibu' => '1994-07-04',
            'pekerjaan_ibu' => 'Pengurus Rumah Tangga',
            // 3. Wali
            'nama_wali' => '',
            'tempat_lahir_wali' => '',
            'tanggal_lahir_wali' => '',
            'pekerjaan_wali' => '',
            // Akun Orang Tua
            'email_ortu' => 'julia.sari@email.com',
            'status_akun_ortu' => 'Pending',
            // Dokumen siswa
            'dokumen' => [
                ['id' => 1, 'nama' => 'Akta Kelahiran', 'file' => 'akta_kelahiran_001.pdf', 'type' => 'akta_kelahiran'],
                ['id' => 2, 'nama' => 'Kartu Keluarga', 'file' => 'kk_001.pdf', 'type' => 'kartu_keluarga'],
                ['id' => 3, 'nama' => 'Pas Foto', 'file' => 'foto_001.jpg', 'type' => 'foto'],
            ],
        ];
        
        return view('admin.siswa.edit', compact('siswa'));
    }
    
    public function siswaUpdate(Request $request, $id)
    {
        // Dummy - redirect with success
        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diupdate!');
    }
    
    public function siswaDestroy($id)
    {
        // Delete siswa logic here
        
        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus!');
    }
    
    // BACKUP DATABASE
    public function backupIndex()
    {
        // Dummy backup history - replace with actual file listing
        $backups = [
            ['filename' => 'backup_tk_2024-01-10.sql.gz', 'tanggal' => '10 Jan 2024', 'ukuran' => '2.4 MB'],
            ['filename' => 'backup_tk_2024-01-05.sql.gz', 'tanggal' => '05 Jan 2024', 'ukuran' => '2.1 MB'],
        ];
        
        return view('admin.backup.index', compact('backups'));
    }
    
    public function backupCreate(Request $request)
    {
        // Create backup logic here
        // This would typically use mysqldump or a package like spatie/laravel-backup
        
        return redirect()->route('admin.backup.index')->with('success', 'Backup database berhasil dibuat!');
    }
    
    public function backupRestore(Request $request)
    {
        // Dummy - redirect with success
        return redirect()->route('admin.backup.index')->with('success', 'Database berhasil di-restore!');
    }
    
    public function backupDelete($filename)
    {
        // Delete backup file logic here
        
        return redirect()->route('admin.backup.index')->with('success', 'File backup berhasil dihapus!');
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

        return view('admin.pendaftaran.index', compact('pendaftaran', 'totalPending', 'totalDiterima', 'totalDitolak', 'totalSemua'));
    }

    public function pendaftaranShow($id)
    {
        $user = User::with(['student.parents', 'student.files'])->findOrFail($id);

        $pendaftaran = $this->buildPendaftaranRow($user);

        return view('admin.pendaftaran.show', compact('pendaftaran'));
    }

    public function pendaftaranTerima(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $kelas       = $request->input('kelas', '');
        $tahunAjaran = $request->input('tahun_ajaran', '');

        DB::transaction(function () use ($user, $kelas, $tahunAjaran) {
            $user->update(['status' => 'active']);

            if ($kelas && $tahunAjaran && $user->student) {
                $classTerm = ClassTerm::whereHas('class', fn($q) => $q->where('name', $kelas))
                    ->whereHas('academicTerm', fn($q) => $q->where('academic_year', $tahunAjaran))
                    ->first();

                if ($classTerm) {
                    StudentEnrollment::firstOrCreate(
                        ['student_id' => $user->student->id, 'class_term_id' => $classTerm->id],
                        ['status' => 'aktif']
                    );
                }
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

        return view('admin.tahun_ajaran.show', compact('academicTerm'));
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
        $academicTerms = AcademicTerm::with([
            'classTerms.subjects.subject',
            'classTerms.extracurriculars.extracurricular',
            'classTerms.counselings.counseling',
        ])->orderBy('academic_year')->orderBy('semester')->get();

        $rows = $academicTerms->map(function ($ta) {
            $mataPelajaran   = $ta->classTerms->flatMap(fn($ct) => $ct->subjects->map(fn($s) => $s->subject?->name))->filter()->unique()->values();
            $ekstrakurikuler = $ta->classTerms->flatMap(fn($ct) => $ct->extracurriculars->map(fn($e) => $e->extracurricular?->name))->filter()->unique()->values();
            $konseling       = $ta->classTerms->flatMap(fn($ct) => $ct->counselings->map(fn($k) => $k->counseling?->name))->filter()->unique()->values();

            return [
                'id'              => $ta->id,
                'tahun_ajaran'    => $ta->academic_year,
                'semester'        => $ta->semester,
                'mata_pelajaran'  => $mataPelajaran->all(),
                'ekstrakurikuler' => $ekstrakurikuler->all(),
                'konseling'       => $konseling->all(),
            ];
        });

        return view('admin.aktivitas_tahun_ajaran.index', compact('rows'));
    }

    public function aktivitasTahunAjaranEdit($id)
    {
        $tahunAjaran = AcademicTerm::with([
            'classTerms.subjects',
            'classTerms.extracurriculars',
            'classTerms.counselings',
        ])->findOrFail($id);

        $mataPelajaran   = Subject::orderBy('name')->get();
        $ekstrakurikuler = Extracurricular::orderBy('name')->get();
        $konseling       = Counseling::orderBy('name')->get();

        $assigned = [
            'mata_pelajaran_ids'  => $tahunAjaran->classTerms->flatMap(fn($ct) => $ct->subjects->pluck('subject_id'))->unique()->values()->all(),
            'ekstrakurikuler_ids' => $tahunAjaran->classTerms->flatMap(fn($ct) => $ct->extracurriculars->pluck('extracurricular_id'))->unique()->values()->all(),
            'konseling_ids'       => $tahunAjaran->classTerms->flatMap(fn($ct) => $ct->counselings->pluck('counseling_id'))->unique()->values()->all(),
        ];

        return view('admin.aktivitas_tahun_ajaran.edit', compact(
            'tahunAjaran', 'mataPelajaran', 'ekstrakurikuler', 'konseling', 'assigned'
        ));
    }

    public function aktivitasTahunAjaranUpdate(Request $request, $id)
    {
        $request->validate([
            'mata_pelajaran_ids'    => 'nullable|array',
            'mata_pelajaran_ids.*'  => 'string|exists:subject,id',
            'ekstrakurikuler_ids'   => 'nullable|array',
            'ekstrakurikuler_ids.*' => 'string|exists:extracurricular,id',
            'konseling_ids'         => 'nullable|array',
            'konseling_ids.*'       => 'string|exists:counseling,id',
        ]);

        $academicTerm  = AcademicTerm::with('classTerms')->findOrFail($id);
        $subjectIds    = $request->mata_pelajaran_ids ?? [];
        $ekskuIds      = $request->ekstrakurikuler_ids ?? [];
        $konselingIds  = $request->konseling_ids ?? [];

        DB::transaction(function () use ($academicTerm, $subjectIds, $ekskuIds, $konselingIds) {
            foreach ($academicTerm->classTerms as $ct) {
                $ct->subjects()->delete();
                foreach ($subjectIds as $sid) {
                    ClassTermSubject::create(['class_term_id' => $ct->id, 'subject_id' => $sid]);
                }
                $ct->extracurriculars()->delete();
                foreach ($ekskuIds as $eid) {
                    ClassTermExtracurricular::create(['class_term_id' => $ct->id, 'extracurricular_id' => $eid]);
                }
                $ct->counselings()->delete();
                foreach ($konselingIds as $kid) {
                    ClassTermCounseling::create(['class_term_id' => $ct->id, 'counseling_id' => $kid]);
                }
            }
        });

        return redirect()->route('admin.aktivitas_tahun_ajaran.index')
            ->with('success', "Aktivitas Tahun Ajaran {$academicTerm->academic_year} berhasil diperbarui.");
    }

    // ═══════════════════════════════════════════════════════
    // REKAP DATA DAPODIK
    // ═══════════════════════════════════════════════════════
    public function dapodikIndex()
    {
        $siswa = Student::orderBy('kelas')->orderBy('name')->get()->map(function ($s) {
            return [
                'id'            => $s->id,
                'nisn'          => $s->nisn ?? '-',
                'nik'           => $s->nik ?? '-',
                'nama'          => $s->name,
                'jenis_kelamin' => $s->gender == 'L' ? 'Laki-laki' : 'Perempuan',
                'tempat_lahir'  => $s->tempat_lahir ?? '-',
                'tanggal_lahir' => $s->birth_date ? \Carbon\Carbon::parse($s->birth_date)->format('d-m-Y') : '-',
                'agama'         => 'Islam',
                'alamat'        => $s->address ?? '-',
                'nama_ayah'     => $s->nama_ayah ?? '-',
                'nama_ibu'      => $s->nama_ibu ?? '-',
                'kelas'         => $s->kelas ? 'TK ' . $s->kelas : '-',
                'status'        => 'Aktif',
            ];
        })->toArray();

        $totalSiswa     = count($siswa);
        $totalLaki      = collect($siswa)->where('jenis_kelamin', 'Laki-laki')->count();
        $totalPerempuan = collect($siswa)->where('jenis_kelamin', 'Perempuan')->count();
        $totalTKA       = collect($siswa)->where('kelas', 'TK A')->count();
        $totalTKB       = collect($siswa)->filter(fn($s) => in_array($s['kelas'], ['TK B1', 'TK B2']))->count();

        return view('admin.dapodik.index', compact('siswa', 'totalSiswa', 'totalLaki', 'totalPerempuan', 'totalTKA', 'totalTKB'));
    }

    // ═══════════════════════════════════════════════════════
    // KENAIKAN SISWA
    // ═══════════════════════════════════════════════════════

    private function dummyClassTerms()
    {
        return [
            // 2023/2024 Ganjil (tahun_ajaran_id=1) — selesai, isPass=true
            ['id' => 1,  'kelas_id' => 1, 'kelas_nama' => 'A1', 'tahun_ajaran_id' => 1, 'tahun_ajaran' => '2023/2024', 'semester' => 'ganjil', 'status' => 'selesai', 'isPass' => true],
            ['id' => 2,  'kelas_id' => 2, 'kelas_nama' => 'B1', 'tahun_ajaran_id' => 1, 'tahun_ajaran' => '2023/2024', 'semester' => 'ganjil', 'status' => 'selesai', 'isPass' => true],
            ['id' => 3,  'kelas_id' => 3, 'kelas_nama' => 'B2', 'tahun_ajaran_id' => 1, 'tahun_ajaran' => '2023/2024', 'semester' => 'ganjil', 'status' => 'selesai', 'isPass' => true],
            // 2023/2024 Genap (tahun_ajaran_id=2) — selesai, isPass=true
            ['id' => 4,  'kelas_id' => 1, 'kelas_nama' => 'A1', 'tahun_ajaran_id' => 2, 'tahun_ajaran' => '2023/2024', 'semester' => 'genap',  'status' => 'selesai', 'isPass' => true],
            ['id' => 5,  'kelas_id' => 2, 'kelas_nama' => 'B1', 'tahun_ajaran_id' => 2, 'tahun_ajaran' => '2023/2024', 'semester' => 'genap',  'status' => 'selesai', 'isPass' => true],
            ['id' => 6,  'kelas_id' => 3, 'kelas_nama' => 'B2', 'tahun_ajaran_id' => 2, 'tahun_ajaran' => '2023/2024', 'semester' => 'genap',  'status' => 'selesai', 'isPass' => true],
            // 2024/2025 Ganjil (tahun_ajaran_id=3) — selesai, isPass=true
            ['id' => 7,  'kelas_id' => 1, 'kelas_nama' => 'A1', 'tahun_ajaran_id' => 3, 'tahun_ajaran' => '2024/2025', 'semester' => 'ganjil', 'status' => 'selesai', 'isPass' => true],
            ['id' => 8,  'kelas_id' => 2, 'kelas_nama' => 'B1', 'tahun_ajaran_id' => 3, 'tahun_ajaran' => '2024/2025', 'semester' => 'ganjil', 'status' => 'selesai', 'isPass' => true],
            ['id' => 9,  'kelas_id' => 3, 'kelas_nama' => 'B2', 'tahun_ajaran_id' => 3, 'tahun_ajaran' => '2024/2025', 'semester' => 'ganjil', 'status' => 'selesai', 'isPass' => true],
            // 2024/2025 Genap (tahun_ajaran_id=4) — aktif, isPass=false
            ['id' => 10, 'kelas_id' => 1, 'kelas_nama' => 'A1', 'tahun_ajaran_id' => 4, 'tahun_ajaran' => '2024/2025', 'semester' => 'genap',  'status' => 'aktif',   'isPass' => false],
            ['id' => 11, 'kelas_id' => 2, 'kelas_nama' => 'B1', 'tahun_ajaran_id' => 4, 'tahun_ajaran' => '2024/2025', 'semester' => 'genap',  'status' => 'aktif',   'isPass' => false],
            ['id' => 12, 'kelas_id' => 3, 'kelas_nama' => 'B2', 'tahun_ajaran_id' => 4, 'tahun_ajaran' => '2024/2025', 'semester' => 'genap',  'status' => 'aktif',   'isPass' => false],
            // 2025/2026 Ganjil (tahun_ajaran_id=5) — menunggu, isPass=false
            ['id' => 13, 'kelas_id' => 1, 'kelas_nama' => 'A1', 'tahun_ajaran_id' => 5, 'tahun_ajaran' => '2025/2026', 'semester' => 'ganjil', 'status' => 'menunggu', 'isPass' => false],
            ['id' => 14, 'kelas_id' => 2, 'kelas_nama' => 'B1', 'tahun_ajaran_id' => 5, 'tahun_ajaran' => '2025/2026', 'semester' => 'ganjil', 'status' => 'menunggu', 'isPass' => false],
            ['id' => 15, 'kelas_id' => 3, 'kelas_nama' => 'B2', 'tahun_ajaran_id' => 5, 'tahun_ajaran' => '2025/2026', 'semester' => 'ganjil', 'status' => 'menunggu', 'isPass' => false],
        ];
    }

    private function dummyEnrollmentHistory()
    {
        return [
            // class_term 1: A1 2023/2024 Ganjil
            1 => [
                ['siswa_nama' => 'Ahmad Fauzi',    'nis' => '2023001', 'nisn' => '0111111111', 'gender' => 'L', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'A1 — 2023/2024 Genap'],
                ['siswa_nama' => 'Siti Nurhaliza', 'nis' => '2023002', 'nisn' => '0111111112', 'gender' => 'P', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'A1 — 2023/2024 Genap'],
                ['siswa_nama' => 'Budi Santoso',   'nis' => '2023003', 'nisn' => '0111111113', 'gender' => 'L', 'enrollment_status' => 'selesai', 'aksi' => 'tinggal_kelas',  'class_term_tujuan' => 'A1 — 2023/2024 Genap'],
            ],
            // class_term 2: B1 2023/2024 Ganjil
            2 => [
                ['siswa_nama' => 'Dewi Lestari',   'nis' => '2023004', 'nisn' => '0111111114', 'gender' => 'P', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'B1 — 2023/2024 Genap'],
                ['siswa_nama' => 'Eko Prasetyo',   'nis' => '2023005', 'nisn' => '0111111115', 'gender' => 'L', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'B1 — 2023/2024 Genap'],
            ],
            // class_term 3: B2 2023/2024 Ganjil
            3 => [
                ['siswa_nama' => 'Fitri Handayani','nis' => '2023006', 'nisn' => '0111111116', 'gender' => 'P', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'B2 — 2023/2024 Genap'],
                ['siswa_nama' => 'Galih Wirawan',  'nis' => '2023007', 'nisn' => '0111111117', 'gender' => 'L', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'B2 — 2023/2024 Genap'],
            ],
            // class_term 4: A1 2023/2024 Genap
            4 => [
                ['siswa_nama' => 'Ahmad Fauzi',    'nis' => '2023001', 'nisn' => '0111111111', 'gender' => 'L', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_kelas',   'class_term_tujuan' => 'B1 — 2024/2025 Ganjil'],
                ['siswa_nama' => 'Siti Nurhaliza', 'nis' => '2023002', 'nisn' => '0111111112', 'gender' => 'P', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_kelas',   'class_term_tujuan' => 'B2 — 2024/2025 Ganjil'],
                ['siswa_nama' => 'Budi Santoso',   'nis' => '2023003', 'nisn' => '0111111113', 'gender' => 'L', 'enrollment_status' => 'selesai', 'aksi' => 'tinggal_kelas',  'class_term_tujuan' => 'A1 — 2024/2025 Ganjil'],
            ],
            // class_term 5: B1 2023/2024 Genap
            5 => [
                ['siswa_nama' => 'Dewi Lestari',   'nis' => '2023004', 'nisn' => '0111111114', 'gender' => 'P', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_kelas',   'class_term_tujuan' => 'B1 — 2024/2025 Ganjil'],
                ['siswa_nama' => 'Eko Prasetyo',   'nis' => '2023005', 'nisn' => '0111111115', 'gender' => 'L', 'enrollment_status' => 'selesai', 'aksi' => 'tinggal_kelas',  'class_term_tujuan' => 'B1 — 2024/2025 Ganjil'],
            ],
            // class_term 6: B2 2023/2024 Genap
            6 => [
                ['siswa_nama' => 'Fitri Handayani','nis' => '2023006', 'nisn' => '0111111116', 'gender' => 'P', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_kelas',   'class_term_tujuan' => 'B2 — 2024/2025 Ganjil'],
                ['siswa_nama' => 'Galih Wirawan',  'nis' => '2023007', 'nisn' => '0111111117', 'gender' => 'L', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_kelas',   'class_term_tujuan' => 'B2 — 2024/2025 Ganjil'],
            ],
            // class_term 7: A1 2024/2025 Ganjil
            7 => [
                ['siswa_nama' => 'Budi Santoso',   'nis' => '2023003', 'nisn' => '0111111113', 'gender' => 'L', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'A1 — 2024/2025 Genap'],
                ['siswa_nama' => 'Hana Rahmawati', 'nis' => '2024008', 'nisn' => '0123456788', 'gender' => 'P', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'A1 — 2024/2025 Genap'],
            ],
            // class_term 8: B1 2024/2025 Ganjil
            8 => [
                ['siswa_nama' => 'Ahmad Fauzi',    'nis' => '2024001', 'nisn' => '0123456781', 'gender' => 'L', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'B1 — 2024/2025 Genap'],
                ['siswa_nama' => 'Dewi Lestari',   'nis' => '2023004', 'nisn' => '0111111114', 'gender' => 'P', 'enrollment_status' => 'selesai', 'aksi' => 'tinggal_kelas',  'class_term_tujuan' => 'B1 — 2024/2025 Genap'],
                ['siswa_nama' => 'Eko Prasetyo',   'nis' => '2023005', 'nisn' => '0111111115', 'gender' => 'L', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'B1 — 2024/2025 Genap'],
            ],
            // class_term 9: B2 2024/2025 Ganjil
            9 => [
                ['siswa_nama' => 'Siti Nurhaliza', 'nis' => '2024002', 'nisn' => '0123456782', 'gender' => 'P', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'B2 — 2024/2025 Genap'],
                ['siswa_nama' => 'Fitri Handayani','nis' => '2023006', 'nisn' => '0111111116', 'gender' => 'P', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'B2 — 2024/2025 Genap'],
                ['siswa_nama' => 'Galih Wirawan',  'nis' => '2023007', 'nisn' => '0111111117', 'gender' => 'L', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'B2 — 2024/2025 Genap'],
            ],
        ];
    }

    private function dummyStudents()
    {
        return [
            ['id' => 1, 'nama' => 'Ahmad Fauzi',       'nis' => '2024001', 'nisn' => '0123456781', 'gender' => 'L'],
            ['id' => 2, 'nama' => 'Siti Nurhaliza',    'nis' => '2024002', 'nisn' => '0123456782', 'gender' => 'P'],
            ['id' => 3, 'nama' => 'Budi Santoso',      'nis' => '2024003', 'nisn' => '0123456783', 'gender' => 'L'],
            ['id' => 4, 'nama' => 'Dewi Lestari',      'nis' => '2024004', 'nisn' => '0123456784', 'gender' => 'P'],
            ['id' => 5, 'nama' => 'Eko Prasetyo',      'nis' => '2024005', 'nisn' => '0123456785', 'gender' => 'L'],
            ['id' => 6, 'nama' => 'Fitri Handayani',   'nis' => '2024006', 'nisn' => '0123456786', 'gender' => 'P'],
            ['id' => 7, 'nama' => 'Galih Wirawan',     'nis' => '2024007', 'nisn' => '0123456787', 'gender' => 'L'],
            ['id' => 8, 'nama' => 'Hana Rahmawati',    'nis' => '2024008', 'nisn' => '0123456788', 'gender' => 'P'],
            ['id' => 9, 'nama' => 'Irfan Maulana',     'nis' => '2024009', 'nisn' => '0123456789', 'gender' => 'L'],
            ['id' => 10,'nama' => 'Julia Santika',     'nis' => '2024010', 'nisn' => '0123456790', 'gender' => 'P'],
        ];
    }

    private function dummyEnrollments()
    {
        return [
            // class_term 10 → A1 2024/2025 Genap (aktif)
            ['id' => 1, 'student_id' => 1, 'class_term_id' => 10, 'status' => 'aktif'],
            ['id' => 2, 'student_id' => 2, 'class_term_id' => 10, 'status' => 'aktif'],
            ['id' => 3, 'student_id' => 3, 'class_term_id' => 10, 'status' => 'aktif'],
            ['id' => 4, 'student_id' => 4, 'class_term_id' => 10, 'status' => 'aktif'],
            // class_term 11 → B1 2024/2025 Genap (aktif)
            ['id' => 5, 'student_id' => 5, 'class_term_id' => 11, 'status' => 'aktif'],
            ['id' => 6, 'student_id' => 6, 'class_term_id' => 11, 'status' => 'aktif'],
            ['id' => 7, 'student_id' => 7, 'class_term_id' => 11, 'status' => 'aktif'],
            // class_term 12 → B2 2024/2025 Genap (aktif)
            ['id' => 8,  'student_id' => 8,  'class_term_id' => 12, 'status' => 'aktif'],
            ['id' => 9,  'student_id' => 9,  'class_term_id' => 12, 'status' => 'aktif'],
            ['id' => 10, 'student_id' => 10, 'class_term_id' => 12, 'status' => 'aktif'],
        ];
    }

    public function kenaikanIndex()
    {
        $enrollments = collect($this->dummyEnrollments());
        $history     = $this->dummyEnrollmentHistory();

        $classTerms = collect($this->dummyClassTerms())->map(function ($ct) use ($enrollments, $history) {
            if ($ct['isPass']) {
                $ct['jumlah_siswa'] = count($history[$ct['id']] ?? []);
            } else {
                $ct['jumlah_siswa'] = $enrollments->where('class_term_id', $ct['id'])->count();
            }
            return $ct;
        });

        // Group by tahun_ajaran untuk tampilan terorganisir
        $grouped = $classTerms->groupBy('tahun_ajaran');

        return view('admin.kenaikan.index', compact('grouped'));
    }

    public function kenaikanDetail($id)
    {
        $classTerm = collect($this->dummyClassTerms())->firstWhere('id', (int) $id);
        if (!$classTerm || !$classTerm['isPass']) {
            return redirect()->route('admin.kenaikan.index')->with('error', 'Detail hanya tersedia untuk class term yang sudah diproses.');
        }

        $history = $this->dummyEnrollmentHistory()[(int) $id] ?? [];

        return view('admin.kenaikan.detail', compact('classTerm', 'history'));
    }

    public function kenaikanShow($id)
    {
        $classTerm = collect($this->dummyClassTerms())->firstWhere('id', (int) $id);
        if (!$classTerm || $classTerm['status'] !== 'aktif') {
            return redirect()->route('admin.kenaikan.index')->with('error', 'Class term tidak ditemukan.');
        }

        $enrollments = collect($this->dummyEnrollments())
            ->where('class_term_id', (int) $id)
            ->values();

        $students = collect($this->dummyStudents());

        $siswaList = $enrollments->map(function ($e) use ($students) {
            $s = $students->firstWhere('id', $e['student_id']);
            return array_merge($e, $s ?? []);
        });

        // Semua class term kecuali yang sedang diproses, untuk dipilih sebagai tujuan
        $classTermOptions = collect($this->dummyClassTerms())
            ->where('id', '!=', (int) $id)
            ->values();

        return view('admin.kenaikan.show', compact('classTerm', 'siswaList', 'classTermOptions'));
    }

    public function kenaikanProses(Request $request, $id)
    {
        return redirect()->route('admin.kenaikan.index')
            ->with('success', 'Proses kenaikan siswa berhasil disimpan. Class term telah ditutup.');
    }
}
