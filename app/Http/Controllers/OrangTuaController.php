"[OrangTuaController.php](c:/Users/yesav/Documents/WEB-TK-AL-ISTIQOMAH/app/Http/Controllers/OrangTuaController.php) adalah file yang mengatur semua fitur yang digunakan oleh orang tua atau wali murid. Sederhananya, controller ini mengambil data anak yang terhubung dengan akun orang tua yang sedang login, lalu menampilkannya di halaman orang tua, seperti dashboard, presensi anak, laporan perkembangan, jadwal pembelajaran dan kegiatan, rapot, report mingguan, grafik perkembangan, chat dengan guru, serta pengajuan jadwal konseling. Jadi, ketika orang tua membuka menu di aplikasi, file ini bertugas mengambil data yang sesuai dari database, memastikan data yang tampil adalah data anaknya sendiri, lalu mengirimkannya ke tampilan agar orang tua bisa memantau perkembangan anak dengan mudah."
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Activity;
use App\Models\Student;
use App\Models\Presence;
use App\Models\Report;
use App\Models\StudentEnrollment;
use App\Models\ClassSchedule;
use App\Models\ActivitySchedule;
use App\Models\ClassTerm;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Models\PrivateCounselingSchedule;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\KonselingPengajuanMail;

class OrangTuaController extends Controller
{
    // Function ini mengambil data siswa yang terhubung dengan user atau fitur terkait.
    // Data siswa ini kemudian dipakai untuk menampilkan presensi, rapot, jadwal, atau laporan.
    private function getStudentData(): array
    {
        $s = Student::first();
        return $s ? [
            'id'    => $s->id,
            'nama'  => $s->name,
            'class' => 'TK ' . $s->kelas,
        ] : ['id' => 1, 'nama' => '-', 'class' => '-'];
    }

    // Function ini menyiapkan data ringkasan untuk halaman dashboard.
    // Data yang ditampilkan biasanya berupa jumlah, statistik, dan aktivitas terbaru.
    public function dashboard()
    {
        $user    = auth()->user();
        $student = $user->student;
        $now     = now();

        // Enrollment aktif (class term yang isPass = false)
        $enrollment = $student
            ? StudentEnrollment::where('student_id', $student->id)
                ->whereHas('classTerm', fn($q) => $q->where('isPass', false))
                ->with(['classTerm.class', 'classTerm.academicTerm'])
                ->latest()->first()
            : null;

        $classTerm   = $enrollment?->classTerm;
        $namaAnak    = $student?->name ?? '-';
        $kelasAnak   = $classTerm?->class?->name ?? '-';
        $tahunAjaran = ($classTerm?->academicTerm?->academic_year ?? '') . ' ' . ucfirst($classTerm?->academicTerm?->semester ?? '');

        // Hadir bulan ini dari presence
        $enrollmentId  = $enrollment?->id;
        $hadirBulanIni = $enrollmentId
            ? Presence::where('student_class_id', $enrollmentId)
                ->whereYear('date', $now->year)
                ->whereMonth('date', $now->month)
                ->where('attendance', 'hadir')
                ->count()
            : 0;

        // Target = total hari yang ada presensi bulan ini
        $targetHadir = $enrollmentId
            ? Presence::where('student_class_id', $enrollmentId)
                ->whereYear('date', $now->year)
                ->whereMonth('date', $now->month)
                ->distinct('date')->count('date')
            : 0;

        // Total report tersedia untuk student
        $totalReport = $student
            ? Report::whereHas('studentEnrollment', fn($q) => $q->where('student_id', $student->id))
                ->count()
            : 0;

        $activeClassTermId = $enrollment?->class_term_id;

        // Konseling mendatang (approved, belum lewat) — per siswa + per kelas
        $konselingMendatang = PrivateCounselingSchedule::where(function ($q) use ($user, $activeClassTermId) {
                $q->where('student_id', $user->id);
                if ($activeClassTermId) {
                    $q->orWhere(function ($q2) use ($activeClassTermId) {
                        $q2->whereNull('student_id')->where('class_term_id', $activeClassTermId);
                    });
                }
            })
            ->where('status', 'approved')
            ->where('date', '>=', $now->toDateString())
            ->count();

        // Konseling menunggu persetujuan (pending) — pengajuan orang tua
        $konselingPending = PrivateCounselingSchedule::where('student_id', $user->id)
            ->where('status', 'pending')
            ->count();

        return view('orangtua.dashboard', compact(
            'namaAnak', 'kelasAnak', 'tahunAjaran',
            'hadirBulanIni', 'targetHadir',
            'totalReport',
            'konselingMendatang', 'konselingPending'
        ));
    }

    // Function ini mengelola atau menampilkan data kehadiran siswa.
    // Data yang diproses biasanya berupa hadir, izin, sakit, atau alpa.
    public function presensi(Request $request)
    {
        $user    = auth()->user();
        $student = Student::where('user_id', $user->id)
            ->with(['enrollments.classTerm.class', 'enrollments.classTerm.academicTerm'])
            ->first();

        $empty = [
            'student'        => ['id' => null, 'nama' => '-'],
            'presensiData'   => ['hadir' => 0, 'izin' => 0, 'sakit' => 0, 'alpa' => 0],
            'detailPresensi' => [],
            'classTerms'     => [],
            'classTermId'    => null,
            'bulan'          => now()->month,
            'activeCt'       => ['id' => null, 'label' => '-', 'tahun_ajaran' => '', 'bulan_aktif' => range(1, 12)],
            'namaBulan'      => now()->translatedFormat('F'),
            'tahun'          => now()->year,
        ];

        if (!$student) {
            return view('orangtua.presensi', $empty);
        }

        $classTerms = $student->enrollments->map(function ($e) {
            $ct  = $e->classTerm;
            $at  = $ct?->academicTerm;
            $sem = ucfirst($at?->semester ?? '');
            $yr  = $at?->academic_year ?? '';
            $months = range(1, 12);
            return [
                'id'            => $ct->id,
                'enrollment_id' => $e->id,
                'label'         => ($ct?->class?->name ?? '-') . ' — ' . $yr . ' ' . $sem,
                'tahun_ajaran'  => $yr,
                'semester'      => $sem,
                'kelas'         => $ct?->class?->name ?? '-',
                'bulan_aktif'   => $months,
            ];
        })->values()->toArray();

        if (empty($classTerms)) {
            return view('orangtua.presensi', array_merge($empty, ['student' => ['id' => $student->id, 'nama' => $student->name]]));
        }

        $classTermId = $request->input('class_term_id', $classTerms[0]['id']);
        $activeCt    = collect($classTerms)->firstWhere('id', $classTermId) ?? $classTerms[0];
        $classTermId = $activeCt['id'];
        $bulan       = (int) $request->input('bulan', $activeCt['bulan_aktif'][0] ?? now()->month);

        $enrollment = $student->enrollments->first(fn($e) => $e->classTerm?->id === $classTermId);

        $namaBulan = \Carbon\Carbon::create()->month($bulan)->translatedFormat('F');
        $tahun     = $this->yearForMonth($bulan, $activeCt['tahun_ajaran']);

        $presences      = collect();
        $detailPresensi = [];
        $hadir = $izin = $sakit = $alpa = 0;

        if ($enrollment) {
            $presences = Presence::where('student_class_id', $enrollment->id)
                ->whereYear('date', $tahun)
                ->whereMonth('date', $bulan)
                ->orderBy('date')
                ->get();

            $hadir = $presences->where('attendance', 'hadir')->count();
            $izin  = $presences->where('attendance', 'izin')->count();
            $sakit = $presences->where('attendance', 'sakit')->count();
            $alpa  = $presences->where('attendance', 'alpa')->count();

            $detailPresensi = $presences->map(fn($p) => [
                'tanggal'    => $p->date->translatedFormat('d M Y'),
                'hari'       => $p->date->translatedFormat('l'),
                'status'     => $p->attendance,
                'keterangan' => $p->description ?? '-',
            ])->toArray();
        }

        $presensiData = compact('hadir', 'izin', 'sakit', 'alpa');
        $student      = ['id' => $student->id, 'nama' => $student->name];

        return view('orangtua.presensi', compact(
            'student', 'presensiData', 'detailPresensi',
            'classTerms', 'classTermId', 'bulan', 'activeCt', 'namaBulan', 'tahun'
        ));
    }

    // Function ini menentukan tahun akademik berdasarkan bulan dan tahun ajaran.
    // Ini penting karena satu tahun ajaran biasanya melewati dua tahun kalender.
    private function yearForMonth(int $month, string $academicYear): int
    {
        $parts = explode('/', $academicYear);
        if (count($parts) === 2) {
            return $month >= 7 ? (int) $parts[0] : (int) $parts[1];
        }
        return now()->year;
    }

    // Function ini mengelola atau menampilkan data laporan.
    // Laporan dipakai untuk melihat hasil administrasi atau perkembangan siswa.
    public function laporan(Request $request)
    {
        $student = $this->getStudentData();

        // Dummy laporan list
        $laporanList = [
            ['id' => 1, 'minggu' => 'Minggu 1 (02-08 Mar 2026)', 'kognitif' => 4, 'motorik' => 4, 'sosial' => 3, 'bahasa' => 4],
            ['id' => 2, 'minggu' => 'Minggu 4 (23-28 Feb 2026)', 'kognitif' => 3, 'motorik' => 4, 'sosial' => 4, 'bahasa' => 3],
            ['id' => 3, 'minggu' => 'Minggu 3 (16-22 Feb 2026)', 'kognitif' => 4, 'motorik' => 3, 'sosial' => 4, 'bahasa' => 4],
        ];

        return view('orangtua.laporan', compact('student', 'laporanList'));
    }

    // Function ini menampilkan informasi detail dari data yang dipilih.
    // Tujuannya agar user bisa melihat isi data secara lebih lengkap.
    public function laporanDetail($id)
    {
        $student = $this->getStudentData();
        $teacher = ['nama' => 'Bu Siti, S.Pd'];
        
        $report = [
            'id' => $id,
            'week_start' => '2026-03-02',
            'cognitive' => 4,
            'motoric' => 4,
            'social' => 3,
            'language' => 4,
            'notes' => 'Anak menunjukkan perkembangan yang baik dalam berbagai aspek.',
        ];

        return view('orangtua.laporan_detail', compact('report', 'student', 'teacher'));
    }

    // Function ini mengelola atau menampilkan data jadwal sesuai kebutuhan fitur.
    // Jadwal bisa berupa pembelajaran, kegiatan, atau konseling.
    public function jadwal(Request $request)
    {
        return redirect()->route('orangtua.jadwal.pembelajaran');
    }

    // Function ini mengambil data siswa yang terhubung dengan user atau fitur terkait.
    // Data siswa ini kemudian dipakai untuk menampilkan presensi, rapot, jadwal, atau laporan.
    private function getStudentClassTerms(): array
    {
        $user    = auth()->user();
        $student = Student::where('user_id', $user->id)
            ->with(['enrollments.classTerm.class', 'enrollments.classTerm.academicTerm'])
            ->first();

        if (!$student) return ['student' => null, 'classTerms' => []];

        $classTerms = $student->enrollments->map(function ($e) {
            $ct = $e->classTerm;
            $at = $ct?->academicTerm;
            return [
                'id'    => $ct->id,
                'label' => ($ct->class?->name ?? '-') . ' — ' . ($at?->academic_year ?? '') . ' ' . ucfirst($at?->semester ?? ''),
                'kelas' => $ct->class?->name ?? '-',
            ];
        })->values()->toArray();

        return ['student' => $student, 'classTerms' => $classTerms];
    }

    // Function ini mengelola atau menampilkan data jadwal sesuai kebutuhan fitur.
    // Jadwal bisa berupa pembelajaran, kegiatan, atau konseling.
    public function jadwalPembelajaran(Request $request)
    {
        ['student' => $student, 'classTerms' => $classTerms] = $this->getStudentClassTerms();

        $classTermId = $request->input('class_term_id', $classTerms[0]['id'] ?? null);
        $activeCt    = collect($classTerms)->firstWhere('id', $classTermId) ?? ($classTerms[0] ?? null);
        $classTermId = $activeCt['id'] ?? null;
        $kelas       = $activeCt['kelas'] ?? '-';

        $dayNames = [1=>'Senin',2=>'Selasa',3=>'Rabu',4=>'Kamis',5=>'Jumat',6=>'Sabtu',7=>'Minggu'];
        $jadwalPembelajaran = [];

        if ($classTermId) {
            $schedules = ClassSchedule::where('class_term_id', $classTermId)
                ->orderBy('day')->orderBy('start_hour')
                ->get();

            foreach ($schedules as $s) {
                $day = $dayNames[$s->day] ?? "Hari {$s->day}";
                $start = substr($s->start_hour ?? '', 0, 5);
                $end   = $s->end_hour ? ' - ' . substr($s->end_hour, 0, 5) : '';
                $jadwalPembelajaran[$day][] = [
                    'waktu'      => $start . $end,
                    'kegiatan'   => $s->name,
                    'keterangan' => $s->description ?? '',
                ];
            }
        }

        $activeTab = 'pembelajaran';

        return view('orangtua.jadwal', compact(
            'jadwalPembelajaran', 'student', 'kelas', 'activeTab', 'classTerms', 'classTermId'
        ));
    }

    // Function ini mengelola atau menampilkan data jadwal sesuai kebutuhan fitur.
    // Jadwal bisa berupa pembelajaran, kegiatan, atau konseling.
    public function jadwalKegiatan(Request $request)
    {
        ['student' => $student, 'classTerms' => $classTerms] = $this->getStudentClassTerms();

        $classTermId = $request->input('class_term_id', $classTerms[0]['id'] ?? null);
        $activeCt    = collect($classTerms)->firstWhere('id', $classTermId) ?? ($classTerms[0] ?? null);
        $classTermId = $activeCt['id'] ?? null;

        $bulan = (int) $request->input('bulan', now()->month);

        // Tahun diambil dari academic year class term yang dipilih
        $classTerm = $classTermId ? ClassTerm::with('academicTerm')->find($classTermId) : null;
        $academicYear = $classTerm?->academicTerm?->academic_year ?? now()->year . '/' . (now()->year + 1);
        [$yearStart, $yearEnd] = array_map('intval', explode('/', $academicYear) + [now()->year, now()->year + 1]);
        $tahun = ($bulan >= 7) ? $yearStart : $yearEnd;

        $jadwalKegiatan = [];

        if ($classTermId) {
            $activities = ActivitySchedule::where('class_term_id', $classTermId)
                ->whereYear('date', $tahun)
                ->whereMonth('date', $bulan)
                ->orderBy('date')->orderBy('start_hour')
                ->get();

            foreach ($activities as $a) {
                $start = substr($a->start_hour ?? '', 0, 5);
                $end   = $a->end_hour ? ' - ' . substr($a->end_hour, 0, 5) : '';
                $jadwalKegiatan[] = [
                    'nama'        => $a->name,
                    'tanggal'     => \Carbon\Carbon::parse($a->date)->translatedFormat('l, d F Y'),
                    'waktu'       => $start . $end,
                    'tempat'      => $a->location ?? '-',
                    'deskripsi'   => $a->description ?? '',
                ];
            }
        }

        $activeTab = 'kegiatan';

        return view('orangtua.jadwal', compact(
            'jadwalKegiatan', 'student', 'bulan', 'tahun', 'activeTab', 'classTerms', 'classTermId'
        ));
    }


    // Function ini mengelola atau menampilkan data rapot siswa.
    // Rapot berisi hasil pembelajaran, ekstrakurikuler, konseling, dan informasi kehadiran.
    public function rapot(Request $request)
    {
        $user    = auth()->user();
        $student = Student::where('user_id', $user->id)->first();

        $rapotList = [];

        if ($student) {
            $enrollments = StudentEnrollment::where('student_id', $student->id)
                ->whereHas('report')
                ->with([
                    'classTerm.class',
                    'classTerm.academicTerm',
                    'report',
                ])
                ->get();

            foreach ($enrollments as $enrollment) {
                $ct  = $enrollment->classTerm;
                $at  = $ct?->academicTerm;
                $rapotList[] = [
                    'id'             => $enrollment->report->id,
                    'tahun_ajaran'   => $at?->academic_year ?? '-',
                    'semester'       => ucfirst($at?->semester ?? '-'),
                    'kelas'          => $ct?->class?->name ?? '-',
                    'tanggal_terbit' => $enrollment->report->created_at->translatedFormat('d M Y'),
                ];
            }
        }

        return view('orangtua.rapot', compact('student', 'rapotList'));
    }
    
    // Function ini menampilkan informasi detail dari data yang dipilih.
    // Tujuannya agar user bisa melihat isi data secara lebih lengkap.
    public function rapotDetail($id)
    {
        $report = Report::with([
            'subjects.subject',
            'subjects.images',
            'extracurriculars.extracurricular',
            'extracurriculars.scores.assessment',
            'counselings.counseling',
            'counselings.scores.assessment',
            'studentEnrollment.student',
            'studentEnrollment.classTerm.class',
            'studentEnrollment.classTerm.academicTerm',
        ])->findOrFail($id);

        $enrollment = $report->studentEnrollment;
        $student    = $enrollment->student;
        $ct         = $enrollment->classTerm;
        $at         = $ct?->academicTerm;

        // Mata Pelajaran
        $mataPelajaran = $report->subjects->map(function ($rs) {
            $img = $rs->images->first();
            return [
                'id'        => $rs->id,
                'nama'      => $rs->subject->name ?? '-',
                'deskripsi' => $rs->description ?? '',
                'foto'      => $img ? asset('storage/' . $img->description) : null,
                'foto_list' => $rs->images->map(fn($i) => asset('storage/' . $i->description))->toArray(),
            ];
        })->toArray();

        // Ekstrakurikuler
        $ekstrakurikuler = $report->extracurriculars->map(function ($re) {
            return [
                'id'          => $re->id,
                'nama'        => $re->extracurricular->name ?? '-',
                'assessments' => $re->scores->map(fn($s) => [
                    'nama'  => $s->assessment->name ?? '-',
                    'level' => $s->level,
                ])->toArray(),
            ];
        })->toArray();

        // Konseling / BK
        $konseling = $report->counselings->map(function ($rc) {
            $latestScores = $rc->scores
                ->sortByDesc('date')
                ->unique('counseling_assessment_id');
            return [
                'id'          => $rc->id,
                'nama'        => $rc->counseling->name ?? '-',
                'assessments' => $latestScores->map(fn($s) => [
                    'nama'  => $s->assessment->name ?? '-',
                    'level' => $s->level,
                ])->values()->toArray(),
            ];
        })->toArray();

        // Kehadiran dari tabel presence
        $presences = Presence::where('student_class_id', $enrollment->id)->get();
        $kehadiran = [
            'hadir' => $presences->where('attendance', 'hadir')->count(),
            'izin'  => $presences->where('attendance', 'izin')->count(),
            'sakit' => $presences->where('attendance', 'sakit')->count(),
            'alpa'  => $presences->where('attendance', 'alpa')->count(),
        ];

        $rapot = [
            'id'             => $report->id,
            'tahun_ajaran'   => $at?->academic_year ?? '-',
            'semester'       => ucfirst($at?->semester ?? '-'),
            'kelas'          => $ct?->class?->name ?? '-',
            'tanggal_terbit' => $report->created_at->translatedFormat('d F Y'),
            'siswa'          => [
                'nama' => $student->name ?? '-',
                'nis'  => $student->nis  ?? '-',
            ],
            'mata_pelajaran'  => $mataPelajaran,
            'ekstrakurikuler' => $ekstrakurikuler,
            'konseling'       => $konseling,
            'kehadiran'       => $kehadiran,
        ];

        return view('orangtua.rapot_detail', compact('rapot'));
    }
    
    // Function ini menyiapkan file atau laporan agar bisa diunduh user.
    // File yang dimaksud bisa berupa backup, PDF, atau dokumen lain.
    public function rapotDownload($id)
    {
        $report = Report::with([
            'studentEnrollment.student',
            'studentEnrollment.classTerm.class',
            'studentEnrollment.classTerm.academicTerm',
        ])->findOrFail($id);

        $at = $report->studentEnrollment->classTerm->academicTerm ?? null;
        $ct = $report->studentEnrollment->classTerm ?? null;
        $student = $report->studentEnrollment->student ?? null;

        $rapot = [
            'id'             => $report->id,
            'tahun_ajaran'   => $at?->academic_year ?? '-',
            'semester'       => ucfirst($at?->semester ?? '-'),
            'kelas'          =>  $ct?->class?->name ?? '-',
            'tanggal_terbit' => $report->created_at->translatedFormat('d F Y'),
            'siswa'          => [
                'nama' => $student->name ?? '-',
                'nis'  => $student->nis  ?? '-',
            ],
            'guru'           => 'Bu ' . ($student->teacher->name ?? 'Tidak Diketahui') . ', S.Pd',
            'nilai'          => [
                'agama_moral'              => 'BSH',
                'agama_moral_deskripsi'    => 'Ahmad memahami nilai-nilai agama dengan baik. Ia selalu berdoa sebelum dan sesudah kegiatan serta menunjukkan sikap sopan santun.',
                'fisik_motorik'            => 'BSB',
                'fisik_motorik_deskripsi'  => 'Perkembangan fisik dan motorik Ahmad sangat baik. Ia sangat aktif dalam kegiatan gerak tubuh.',
                'kognitif'                 => 'BSH',
                'kognitif_deskripsi'       => 'Ahmad mampu mengenali bentuk, warna, dan angka sederhana.',
                'bahasa'                   => 'MB',
                'bahasa_deskripsi'         => 'Ahmad mulai berkembang dalam kemampuan berbahasa namun masih perlu latihan.',
                'sosial_emosional'         => 'BSH',
                'sosial_emosional_deskripsi' => 'Ahmad menunjukkan kemampuan bersosialisasi yang baik.',
                'seni'                     => 'BSB',
                'seni_deskripsi'           => 'Ahmad memiliki bakat seni yang menonjol dan sangat antusias dalam kegiatan menggambar.',
            ],
            'kehadiran'      => [
                'hadir' => 78,
                'izin'  => 3,
                'sakit' => 2,
                'alpa'  => 1,
            ],
            'catatan_guru'   => 'Ahmad menunjukkan perkembangan yang sangat membanggakan selama semester ini.',
            'rekomendasi'    => 'Diharapkan orang tua terus mendukung kebiasaan membaca dan bercerita di rumah.',
        ];

        $pdf = Pdf::loadView('orangtua.rapot_pdf', compact('rapot'));
        $pdf->setPaper('a4', 'portrait');

        $filename = 'Rapot_' . $rapot['siswa']['nama'] . '_' . $rapot['semester'] . '_' . str_replace('/', '-', $rapot['tahun_ajaran']) . '.pdf';

        return $pdf->download($filename);
    }

    // Function ini menjalankan logika {reportMingguan} pada file ini.
    // Secara umum function ini membantu controller, model, atau service menyelesaikan tugas tertentu di aplikasi.
    public function reportMingguan(Request $request)
    {
        $user    = auth()->user();
        $student = Student::where('user_id', $user->id)
            ->with(['enrollments.classTerm.class', 'enrollments.classTerm.academicTerm', 'enrollments.report'])
            ->first();

        if (!$student) {
            return view('orangtua.report_mingguan', [
                'student'     => null,
                'classTerms'  => [],
                'classTermId' => null,
                'weeks'       => [],
                'week'        => null,
                'konseling'   => [],
                'studentInfo' => null,
            ]);
        }

        // Build class terms dari enrollment yang punya report
        $classTerms = $student->enrollments
            ->filter(fn($e) => $e->report !== null)
            ->map(function ($e) {
                $ct = $e->classTerm;
                $at = $ct?->academicTerm;
                return [
                    'id'    => $ct->id,
                    'label' => ($ct->class?->name ?? '-') . ' — ' . ($at?->academic_year ?? '') . ' ' . ucfirst($at?->semester ?? ''),
                    'kelas' => $ct->class?->name ?? '-',
                    'semester' => ucfirst($at?->semester ?? ''),
                    'tahun_ajaran' => $at?->academic_year ?? '-',
                    'report_id' => $e->report->id,
                ];
            })->values()->toArray();

        if (empty($classTerms)) {
            return view('orangtua.report_mingguan', [
                'student'     => $student,
                'classTerms'  => [],
                'classTermId' => null,
                'weeks'       => [],
                'week'        => null,
                'konseling'   => [],
                'studentInfo' => null,
            ]);
        }

        $classTermId = $request->input('class_term_id', $classTerms[0]['id']);
        $activeCt    = collect($classTerms)->firstWhere('id', $classTermId) ?? $classTerms[0];
        $classTermId = $activeCt['id'];
        $reportId    = $activeCt['report_id'];

        // Ambil minggu yang tersedia dari report_counseling_score
        $weeks = \DB::table('report_counseling_score as rcs')
            ->join('report_counseling as rc', 'rc.id', '=', 'rcs.report_counseling_id')
            ->where('rc.report_id', $reportId)
            ->whereNull('rcs.deleted_at')
            ->whereNull('rc.deleted_at')
            ->whereNotNull('rcs.week')
            ->where('rcs.week', '>', 0)
            ->distinct()
            ->orderBy('rcs.week')
            ->pluck('rcs.week')
            ->toArray();

        $week = (int) $request->input('week', end($weeks) ?: 1);
        if (!in_array($week, $weeks) && !empty($weeks)) {
            $week = end($weeks);
        }

        // Ambil data konseling beserta scores untuk minggu terpilih
        $reportCounselings = \App\Models\ReportCounseling::with([
                'counseling.assessments',
                'scores' => fn($q) => $q->where('week', $week)->whereNull('deleted_at'),
                'scores.assessment',
            ])
            ->where('report_id', $reportId)
            ->whereNull('deleted_at')
            ->get();

        $konseling = $reportCounselings->map(function ($rc) {
            $scoreMap = $rc->scores->keyBy('counseling_assessment_id');
            return [
                'nama'        => $rc->counseling->name ?? '-',
                'assessments' => ($rc->counseling->assessments ?? collect())->map(fn($a) => [
                    'nama'  => $a->name,
                    'level' => $scoreMap[$a->id]->level ?? '-',
                ])->toArray(),
            ];
        })->toArray();

        $studentInfo = [
            'nama'         => $student->name,
            'nis'          => $student->nis ?? '-',
            'kelas'        => $activeCt['kelas'],
            'semester'     => $activeCt['semester'] . ' ' . $activeCt['tahun_ajaran'],
            'tahun_ajaran' => $activeCt['tahun_ajaran'],
        ];

        return view('orangtua.report_mingguan', compact(
            'student', 'classTerms', 'classTermId', 'weeks', 'week', 'konseling', 'studentInfo'
        ));
    }

    // Function ini menyiapkan data grafik perkembangan siswa.
    // Data nilai diolah agar bisa ditampilkan dalam bentuk visual di halaman.
    public function grafik()
    {
        $user    = auth()->user();
        $student = Student::where('user_id', $user->id)
            ->with(['enrollments.classTerm.class', 'enrollments.classTerm.academicTerm', 'enrollments.report'])
            ->first();

        if (!$student) {
            return view('orangtua.grafik', ['payload' => null]);
        }

        $enrollmentsWithReport = $student->enrollments->filter(fn($e) => $e->report !== null);

        $classTerms = $enrollmentsWithReport->map(function ($e) {
            $ct = $e->classTerm;
            $at = $ct?->academicTerm;
            return [
                'id'        => $ct->id,
                'label'     => ($ct->class?->name ?? '-') . ' — ' . ($at?->academic_year ?? '') . ' ' . ucfirst($at?->semester ?? ''),
                'report_id' => $e->report->id,
            ];
        })->values()->toArray();

        if (empty($classTerms)) {
            return view('orangtua.grafik', ['payload' => null]);
        }

        $levelMap  = ['BB' => 1, 'MB' => 2, 'BSH' => 3, 'BSB' => 4];
        $konselings = [];
        $allScores  = [];
        $allWeeks   = [];

        foreach ($classTerms as $ct) {
            $reportId = $ct['report_id'];

            $weeks = \DB::table('report_counseling_score as rcs')
                ->join('report_counseling as rc', 'rc.id', '=', 'rcs.report_counseling_id')
                ->where('rc.report_id', $reportId)
                ->whereNull('rcs.deleted_at')->whereNull('rc.deleted_at')
                ->whereNotNull('rcs.week')->where('rcs.week', '>', 0)
                ->distinct()->orderBy('rcs.week')
                ->pluck('rcs.week')->toArray();

            $allWeeks[$ct['id']] = $weeks;

            $reportCounselings = \App\Models\ReportCounseling::with([
                'counseling.assessments',
                'scores' => fn($q) => $q->whereNotNull('week')->where('week', '>', 0)->whereNull('deleted_at'),
            ])
            ->where('report_id', $reportId)->whereNull('deleted_at')->get();

            if (empty($konselings)) {
                $konselings = $reportCounselings->map(fn($rc) => [
                    'id'                => $rc->counseling_id,
                    'nama'              => $rc->counseling->name ?? '-',
                    'assessments_count' => $rc->counseling->assessments->count(),
                ])->values()->toArray();
            }

            $ctScores = [];
            foreach ($reportCounselings as $rc) {
                $conId      = $rc->counseling_id;
                $weekGroups = $rc->scores->groupBy('week');
                foreach ($weekGroups as $week => $scores) {
                    $vals = $scores->map(fn($s) => $levelMap[$s->level] ?? 0)->filter();
                    $ctScores[$conId][$week] = $vals->isNotEmpty() ? round($vals->avg(), 2) : null;
                }
            }

            $allScores[$ct['id']] = $ctScores;
        }

        $payload = [
            'student'    => ['nama' => $student->name, 'nis' => $student->nis ?? '-'],
            'classTerms' => $classTerms,
            'konselings' => $konselings,
            'scores'     => $allScores,
            'weeks'      => $allWeeks,
        ];

        return view('orangtua.grafik', compact('payload'));
    }

    // Function ini menampilkan halaman chat beserta daftar percakapan.
    // Sistem mengambil ruang chat, pesan, dan lawan bicara user yang sedang login.
    public function chat(Request $request)
    {
        $me     = auth()->user();
        $roomId = $request->get('room');

        $rooms = ChatRoom::with(['userA', 'userB', 'latestMessage'])
            ->where('user_a_id', $me->id)
            ->orWhere('user_b_id', $me->id)
            ->get()
            ->sortByDesc(fn($r) => optional($r->latestMessage)->created_at ?? $r->created_at)
            ->values();

        $kontak = $rooms->map(function ($room) use ($me) {
            $other  = $room->otherUser($me->id);
            $latest = $room->latestMessage;
            return [
                'room_id' => $room->id,
                'nama'    => $other?->name ?? '-',
                'initial' => strtoupper(mb_substr($other?->name ?? '?', 0, 1)),
                'sub'     => ucfirst($other?->role ?? ''),
                'preview' => $latest ? Str::limit($latest->message, 35) : 'Belum ada pesan',
                'waktu'   => $latest ? $latest->created_at->setTimezone('Asia/Jakarta')->format('H:i') : '',
            ];
        })->toArray();

        $aktif   = null;
        $aktifId = $roomId;
        $pesan   = [];

        if ($roomId) {
            $activeRoom = ChatRoom::with(['messages.sender', 'userA', 'userB'])->find($roomId);
            if ($activeRoom) {
                // Mark unread messages from the other user as read
                ChatMessage::where('chat_room_id', $activeRoom->id)
                    ->where('sender_id', '!=', $me->id)
                    ->where('isRead', false)
                    ->update(['isRead' => true]);

                $other = $activeRoom->otherUser($me->id);
                $aktif = [
                    'room_id' => $activeRoom->id,
                    'nama'    => $other?->name ?? '-',
                    'initial' => strtoupper(mb_substr($other?->name ?? '?', 0, 1)),
                    'sub'     => ucfirst($other?->role ?? ''),
                ];
                $pesan = $activeRoom->messages->map(fn($msg) => [
                    'is_mine' => $msg->sender_id === $me->id,
                    'teks'    => $msg->message,
                    'waktu'   => $msg->created_at->setTimezone('Asia/Jakarta')->format('H:i'),
                    'initial' => strtoupper(mb_substr($msg->sender?->name ?? '?', 0, 1)),
                ])->toArray();
            }
        }

        // Untuk "chat baru": hanya guru dan admin, yang belum punya room dengan user ini
        $existingPartners = ChatRoom::where('user_a_id', $me->id)->pluck('user_b_id')
            ->merge(ChatRoom::where('user_b_id', $me->id)->pluck('user_a_id'));

        $targetUsers = \App\Models\User::where('id', '!=', $me->id)
            ->where('role', 'guru')
            ->whereNotIn('id', $existingPartners)
            ->orderBy('name')
            ->get()
            ->map(fn($u) => [
                'id'      => $u->id,
                'nama'    => $u->name,
                'initial' => strtoupper(mb_substr($u->name, 0, 1)),
                'role'    => ucfirst($u->role ?? ''),
            ])->toArray();

        return view('orangtua.chat', compact('kontak', 'aktif', 'aktifId', 'pesan', 'targetUsers'));
    }

    // Function ini membuka ruang chat yang sudah ada atau membuat ruang chat baru.
    // Tujuannya agar dua user bisa langsung mulai berkomunikasi di ruang yang sama.
    public function openOrCreateRoom(Request $request)
    {
        $request->validate(['target_user_id' => 'required|exists:user,id']);
        $me       = auth()->id();
        $targetId = $request->target_user_id;

        // Pastikan target adalah guru atau admin
        $target = \App\Models\User::where('role', 'guru')->find($targetId);
        abort_if(!$target, 403);

        $room = ChatRoom::where(function ($q) use ($me, $targetId) {
            $q->where('user_a_id', $me)->where('user_b_id', $targetId);
        })->orWhere(function ($q) use ($me, $targetId) {
            $q->where('user_a_id', $targetId)->where('user_b_id', $me);
        })->first();

        if (!$room) {
            $room = ChatRoom::create(['user_a_id' => $me, 'user_b_id' => $targetId]);
        }

        return redirect()->route('orangtua.chat', ['room' => $room->id]);
    }

    // Function ini menampilkan halaman chat beserta daftar percakapan.
    // Sistem mengambil ruang chat, pesan, dan lawan bicara user yang sedang login.
    public function kirimChat(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:chat_room,id',
            'pesan'   => 'required|string|max:2000',
        ]);

        $me   = auth()->id();
        $room = ChatRoom::where('id', $request->room_id)
            ->where(fn($q) => $q->where('user_a_id', $me)->orWhere('user_b_id', $me))
            ->firstOrFail();

        ChatMessage::create([
            'chat_room_id' => $room->id,
            'sender_id'    => $me,
            'message'      => $request->pesan,
        ]);

        return redirect()->route('orangtua.chat', ['room' => $room->id]);
    }

    // Function ini mengelola atau menampilkan data konseling siswa.
    // Data konseling dipakai untuk pengajuan, persetujuan, dan pemantauan perkembangan siswa.
    public function konseling()
    {
        $user    = auth()->user();
        $student = Student::where('user_id', $user->id)->first();

        $jadwalKonseling = [];

        if ($student) {
            $activeClassTermId = \App\Models\StudentEnrollment::where('student_id', $student->id)
                ->whereHas('classTerm', fn($q) => $q->where('isPass', false))
                ->latest()
                ->value('class_term_id');

            $schedules = PrivateCounselingSchedule::with('teacher')
                ->where(function ($q) use ($user, $activeClassTermId) {
                    $q->where('student_id', $user->id);
                    if ($activeClassTermId) {
                        $q->orWhere(function ($q2) use ($activeClassTermId) {
                            $q2->whereNull('student_id')
                               ->where('class_term_id', $activeClassTermId);
                        });
                    }
                })
                ->orderByDesc('date')
                ->get();

            $jadwalKonseling = $schedules->map(function ($s) {
                $start = substr($s->start_hour ?? '', 0, 5);
                $end   = $s->end_hour ? ' - ' . substr($s->end_hour, 0, 5) : '';
                return [
                    'id'           => $s->id,
                    'tanggal'      => $s->date?->translatedFormat('d M Y') ?? '-',
                    'tanggal_sort' => $s->date?->format('Y-m-d') ?? '',
                    'waktu'        => $start . $end,
                    'guru'         => $s->teacher?->name ?? '-',
                    'teacher_id'   => $s->teacher_id,
                    'topik'        => $s->topic ?? '-',
                    'status'       => $s->status,
                ];
            })->toArray();
        }

        return view('orangtua.konseling', compact('jadwalKonseling', 'student'));
    }

    // Function ini mengambil class term aktif dari siswa yang sedang diproses.
    // Class term aktif dipakai untuk mengetahui kelas dan semester siswa saat ini.
    private function getActiveClassTerm(Student $student): array
    {
        $enrollment = \App\Models\StudentEnrollment::where('student_id', $student->id)
            ->whereHas('classTerm', fn($q) => $q->where('isPass', false))
            ->with(['classTerm.class', 'classTerm.academicTerm'])
            ->latest()
            ->first();

        $ct = $enrollment?->classTerm;
        $at = $ct?->academicTerm;
        $label = $ct
            ? ($ct->class?->name ?? '-') . ' — ' . ($at?->academic_year ?? '') . ' ' . ucfirst($at?->semester ?? '')
            : '-';

        return ['id' => $ct?->id, 'label' => $label];
    }

    // Function ini mengelola atau menampilkan data konseling siswa.
    // Data konseling dipakai untuk pengajuan, persetujuan, dan pemantauan perkembangan siswa.
    public function konselingAjukanForm()
    {
        $user    = auth()->user();
        $student = Student::where('user_id', $user->id)->first();

        $activeCt = $student ? $this->getActiveClassTerm($student) : ['id' => null, 'label' => '-'];

        $guruBK = User::where('role', 'guru')
            ->orderBy('name')
            ->get()
            ->map(fn($u) => ['id' => $u->id, 'nama' => $u->name])
            ->toArray();

        return view('orangtua.konseling_ajukan', compact('guruBK', 'student', 'activeCt'));
    }

    // Function ini mengelola atau menampilkan data konseling siswa.
    // Data konseling dipakai untuk pengajuan, persetujuan, dan pemantauan perkembangan siswa.
    public function ajukanKonseling(Request $request)
    {
        $request->validate([
            'teacher_id'    => 'required|exists:user,id',
            'class_term_id' => 'nullable|exists:class_term,id',
            'tanggal'       => 'required|date|after_or_equal:today',
            'waktu_mulai'   => 'required',
            'waktu_selesai' => 'required',
            'topik'         => 'required|string|max:1000',
        ]);

        $user    = auth()->user();
        $student = Student::where('user_id', $user->id)->firstOrFail();

        abort_if(!User::where('role', 'guru')->where('id', $request->teacher_id)->exists(), 403);

        PrivateCounselingSchedule::create([
            'student_id'    => $user->id,
            'teacher_id'    => $request->teacher_id,
            'class_term_id' => $request->class_term_id,
            'status'        => 'pending',
            'date'          => $request->tanggal,
            'start_hour'    => $request->waktu_mulai,
            'end_hour'      => $request->waktu_selesai,
            'topic'         => $request->topik,
            'source'        => 'orangtua',
        ]);

        Activity::log("mengajukan jadwal konseling untuk siswa {$student->name} pada {$request->tanggal}");

        try {
            $guru = User::find($request->teacher_id);
            if ($guru && $guru->email) {
                Mail::to($guru->email)->send(new KonselingPengajuanMail(
                    namaGuru:  $guru->name,
                    namaOrtu:  $user->name,
                    namaSiswa: $student->name,
                    tanggal:   $request->tanggal,
                    waktu:     $request->waktu_mulai . ' - ' . $request->waktu_selesai,
                    topik:     $request->topik,
                ));
            }
        } catch (\Exception $e) {
            \Log::warning('Gagal kirim email pengajuan konseling: ' . $e->getMessage());
        }

        return redirect()->route('orangtua.konseling')->with('success', 'Konseling berhasil diajukan!');
    }

    // Function ini mengelola atau menampilkan data konseling siswa.
    // Data konseling dipakai untuk pengajuan, persetujuan, dan pemantauan perkembangan siswa.
    public function konselingEditForm($id)
    {
        $user    = auth()->user();
        $student = Student::where('user_id', $user->id)->firstOrFail();

        $schedule = PrivateCounselingSchedule::with('teacher')
            ->where('id', $id)
            ->where('student_id', $user->id)
            ->firstOrFail();

        if ($schedule->status !== 'pending') {
            return redirect()->route('orangtua.konseling')->with('error', 'Jadwal tidak dapat diedit karena status bukan pending.');
        }

        $start = substr($schedule->start_hour ?? '', 0, 5);
        $end   = substr($schedule->end_hour ?? '', 0, 5);

        $jadwal = [
            'id'           => $schedule->id,
            'tanggal_sort' => $schedule->date?->format('Y-m-d') ?? '',
            'waktu'        => $start . ($end ? ' - ' . $end : ''),
            'guru'         => $schedule->teacher?->name ?? '-',
            'teacher_id'   => $schedule->teacher_id,
            'topik'        => $schedule->topic ?? '',
            'status'       => $schedule->status,
        ];

        $guruBK = User::where('role', 'guru')
            ->orderBy('name')
            ->get()
            ->map(fn($u) => ['id' => $u->id, 'nama' => $u->name])
            ->toArray();

        $activeCt = $this->getActiveClassTerm($student);

        return view('orangtua.konseling_edit', compact('jadwal', 'guruBK', 'student', 'activeCt'));
    }

    // Function ini memvalidasi input dari form edit lalu memperbarui data di database.
    // Data lama diganti dengan data baru yang dikirim user.
    public function konselingUpdate(Request $request, $id)
    {
        $request->validate([
            'teacher_id'    => 'required|exists:user,id',
            'tanggal'       => 'required|date|after_or_equal:today',
            'waktu_mulai'   => 'required',
            'waktu_selesai' => 'required',
            'topik'         => 'required|string|max:1000',
        ]);

        $user    = auth()->user();
        $student = Student::where('user_id', $user->id)->firstOrFail();

        $schedule = PrivateCounselingSchedule::where('id', $id)
            ->where('student_id', $user->id)
            ->firstOrFail();

        abort_if($schedule->status !== 'pending', 403, 'Jadwal tidak dapat diedit.');
        abort_if(!User::where('role', 'guru')->where('id', $request->teacher_id)->exists(), 403);

        $schedule->update([
            'teacher_id' => $request->teacher_id,
            'date'       => $request->tanggal,
            'start_hour' => $request->waktu_mulai,
            'end_hour'   => $request->waktu_selesai,
            'topic'      => $request->topik,
        ]);

        return redirect()->route('orangtua.konseling')->with('success', 'Pengajuan konseling berhasil diperbarui!');
    }

    // Function ini membatalkan data atau pengajuan yang masih boleh dibatalkan.
    // Status data biasanya diubah agar tidak lagi dianggap aktif.
    public function konselingBatal($id)
    {
        $user    = auth()->user();
        $student = Student::where('user_id', $user->id)->firstOrFail();

        $schedule = PrivateCounselingSchedule::where('id', $id)
            ->where('student_id', $user->id)
            ->firstOrFail();

        abort_if($schedule->status !== 'pending', 403, 'Jadwal tidak dapat dibatalkan.');

        $schedule->update(['status' => 'canceled']);

        return redirect()->route('orangtua.konseling')->with('success', 'Pengajuan konseling berhasil dibatalkan.');
    }
}
