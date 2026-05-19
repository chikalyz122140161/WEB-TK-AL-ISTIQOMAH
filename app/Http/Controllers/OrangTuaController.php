<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Student;
use App\Models\Presence;
use App\Models\Report;
use App\Models\StudentEnrollment;
use App\Models\ClassSchedule;
use App\Models\ActivitySchedule;
use App\Models\ClassTerm;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use Illuminate\Support\Str;

class OrangTuaController extends Controller
{
    private function getStudentData(): array
    {
        $s = Student::first();
        return $s ? [
            'id'    => $s->id,
            'nama'  => $s->name,
            'class' => 'TK ' . $s->kelas,
        ] : ['id' => 1, 'nama' => '-', 'class' => '-'];
    }

    public function dashboard()
    {
        return view('orangtua.dashboard');
    }

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

    private function yearForMonth(int $month, string $academicYear): int
    {
        $parts = explode('/', $academicYear);
        if (count($parts) === 2) {
            return $month >= 7 ? (int) $parts[0] : (int) $parts[1];
        }
        return now()->year;
    }

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

    // ═══════════════════════════════════════════════════════
    // JADWAL (dengan sub-fitur)
    // ═══════════════════════════════════════════════════════
    
    public function jadwal(Request $request)
    {
        return redirect()->route('orangtua.jadwal.pembelajaran');
    }

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


    // ═══════════════════════════════════════════════════════
    // RAPOT SEMESTER
    // ═══════════════════════════════════════════════════════
    
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
    
    public function rapotDownload($id)
    {
        $rapot = [
            'id'             => $id,
            'tahun_ajaran'   => '2025/2026',
            'semester'       => 'Ganjil',
            'kelas'          => 'TK A',
            'tanggal_terbit' => '20 Desember 2025',
            'siswa'          => [
                'nama' => 'Ahmad Fauzi',
                'nis'  => '20240001',
            ],
            'guru'           => 'Bu Siti, S.Pd',
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

    // ═══════════════════════════════════════════════════════
    // BIMBINGAN KONSELING
    // ═══════════════════════════════════════════════════════

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
                'waktu'   => $latest ? $latest->created_at->format('H:i') : '',
            ];
        })->toArray();

        $aktif   = null;
        $aktifId = $roomId;
        $pesan   = [];

        if ($roomId) {
            $activeRoom = ChatRoom::with(['messages.sender', 'userA', 'userB'])->find($roomId);
            if ($activeRoom) {
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
                    'waktu'   => $msg->created_at->format('H:i'),
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

    private function dummyJadwalKonselingOrangtua(): array
    {
        // Gabungan jadwal untuk Ahmad Fauzi (anak dari Ibu Siti)
        // sumber = 'guru' (jadwal dari guru) atau 'pengajuan' (diajukan orang tua)
        return [
            // ── Pending / Upcoming ────────────────────────────────────────────────
            [
                'id'           => 501,
                'tanggal'      => '19 Mei 2026',
                'tanggal_sort' => '2026-05-19',
                'waktu'        => '10:00 - 11:00',
                'guru'         => 'Bu Siti, S.Pd',
                'topik'        => 'Tindak Lanjut Asesmen April',
                'status'       => 'pending',
                'sumber'       => 'guru',
                'catatan'      => 'Akan membahas hasil asesmen bulan April.',
            ],
            [
                'id'           => 502,
                'tanggal'      => '27 Mar 2026',
                'tanggal_sort' => '2026-03-27',
                'waktu'        => '09:00 - 10:00',
                'guru'         => 'Bu Siti, S.Pd',
                'topik'        => 'Perkembangan Sosial-Emosional',
                'status'       => 'disetujui',
                'sumber'       => 'guru',
                'catatan'      => 'Hadir tepat waktu di ruang BK lantai 2.',
            ],
            [
                'id'           => 503,
                'tanggal'      => '18 Mar 2026',
                'tanggal_sort' => '2026-03-18',
                'waktu'        => '14:00 - 15:00',
                'guru'         => 'Bu Siti, S.Pd',
                'topik'        => 'Konsultasi Perilaku & Kebiasaan',
                'status'       => 'disetujui',
                'sumber'       => 'pengajuan',
                'catatan'      => '-',
            ],
            [
                'id'           => 504,
                'tanggal'      => '15 Mar 2026',
                'tanggal_sort' => '2026-03-15',
                'waktu'        => '11:00 - 12:00',
                'guru'         => 'Bu Siti, S.Pd',
                'topik'        => 'Diskusi Pola Belajar di Rumah',
                'status'       => 'pending',
                'sumber'       => 'pengajuan',
                'catatan'      => '-',
            ],
            // ── Selesai ───────────────────────────────────────────────────────────
            [
                'id'           => 505,
                'tanggal'      => '05 Mar 2026',
                'tanggal_sort' => '2026-03-05',
                'waktu'        => '09:00 - 10:00',
                'guru'         => 'Bu Siti, S.Pd',
                'topik'        => 'Perkembangan Sosial Semester Genap',
                'status'       => 'selesai',
                'sumber'       => 'guru',
                'catatan'      => 'Ahmad menunjukkan perkembangan sosial yang sangat baik.',
            ],
            [
                'id'           => 506,
                'tanggal'      => '20 Feb 2026',
                'tanggal_sort' => '2026-02-20',
                'waktu'        => '13:00 - 14:00',
                'guru'         => 'Bu Siti, S.Pd',
                'topik'        => 'Kesulitan Konsentrasi Belajar di Rumah',
                'status'       => 'selesai',
                'sumber'       => 'pengajuan',
                'catatan'      => 'Guru memberikan tips kegiatan belajar yang menyenangkan.',
            ],
            [
                'id'           => 507,
                'tanggal'      => '22 Jan 2026',
                'tanggal_sort' => '2026-01-22',
                'waktu'        => '10:00 - 11:00',
                'guru'         => 'Bu Siti, S.Pd',
                'topik'        => 'Tindak Lanjut Asesmen Semester Ganjil',
                'status'       => 'selesai',
                'sumber'       => 'guru',
                'catatan'      => 'Ahmad telah menunjukkan perkembangan signifikan. Program dilanjutkan.',
            ],
            [
                'id'           => 508,
                'tanggal'      => '29 Nov 2024',
                'tanggal_sort' => '2024-11-29',
                'waktu'        => '10:00 - 11:00',
                'guru'         => 'Bu Siti, S.Pd',
                'topik'        => 'Perkembangan Sosial-Emosional',
                'status'       => 'selesai',
                'sumber'       => 'guru',
                'catatan'      => 'Anak menunjukkan kemajuan dalam interaksi dengan teman sebaya.',
            ],
        ];
    }

    public function konseling()
    {
        $jadwalKonseling = $this->dummyJadwalKonselingOrangtua();
        $student         = $this->getStudentData();

        return view('orangtua.konseling', compact('jadwalKonseling', 'student'));
    }

    public function konselingAjukanForm()
    {
        $guruBK = [
            ['id' => 1, 'nama' => 'Pak Ahmad - Konselor'],
            ['id' => 2, 'nama' => 'Bu Siti, S.Pd - Guru Kelas TK A'],
        ];
        $student = $this->getStudentData();

        return view('orangtua.konseling_ajukan', compact('guruBK', 'student'));
    }

    public function ajukanKonseling(Request $request)
    {
        return redirect()->route('orangtua.konseling')->with('success', 'Konseling berhasil diajukan!');
    }

    public function konselingEditForm($id)
    {
        $jadwal = collect($this->dummyJadwalKonselingOrangtua())->firstWhere('id', (int) $id);

        if (!$jadwal || $jadwal['sumber'] !== 'pengajuan' || $jadwal['status'] !== 'pending') {
            return redirect()->route('orangtua.konseling')->with('error', 'Jadwal tidak dapat diedit.');
        }

        $guruBK = [
            ['id' => 1, 'nama' => 'Pak Ahmad - Konselor'],
            ['id' => 2, 'nama' => 'Bu Siti, S.Pd - Guru Kelas TK A'],
        ];
        $student = $this->getStudentData();

        return view('orangtua.konseling_edit', compact('jadwal', 'guruBK', 'student'));
    }

    public function konselingUpdate(Request $request, $id)
    {
        return redirect()->route('orangtua.konseling')->with('success', 'Pengajuan konseling berhasil diperbarui!');
    }

    public function konselingBatal($id)
    {
        return redirect()->route('orangtua.konseling')->with('success', 'Pengajuan konseling berhasil dibatalkan.');
    }
}
