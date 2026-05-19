<?php

namespace Database\Seeders;

use App\Models\CounselingAssessment;
use App\Models\ExtracurricularAssessment;
use App\Models\Report;
use App\Models\ReportCounseling;
use App\Models\ReportCounselingScore;
use App\Models\ReportExtracurricular;
use App\Models\ReportExtracurricularScore;
use App\Models\ReportSubject;
use App\Models\StudentEnrollment;
use App\Models\Subject;
use App\Models\Counseling;
use App\Models\Extracurricular;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RapotSeeder extends Seeder
{
    private array $levels = ['BB', 'MB', 'BSH', 'BSB'];

    // Deskripsi template per mata pelajaran, diindex per level kecakapan siswa
    private array $descTemplates = [
        'Nilai Agama & Moral' => [
            'high'   => '{nama} memahami nilai-nilai agama dengan baik. Ia selalu berdoa sebelum dan sesudah kegiatan serta menunjukkan sikap sopan santun kepada teman dan guru.',
            'medium' => '{nama} mulai menunjukkan pemahaman nilai agama. Ia sudah terbiasa berdoa dan bersikap sopan dalam kegiatan sehari-hari.',
            'low'    => '{nama} masih dalam proses memahami nilai-nilai agama. Perlu bimbingan lebih lanjut dalam membiasakan doa dan sikap sopan.',
        ],
        'Fisik Motorik' => [
            'high'   => 'Perkembangan fisik dan motorik {nama} sangat baik. Ia aktif dalam kegiatan gerak tubuh, mampu berlari, melompat, dan menangkap bola dengan koordinasi yang baik.',
            'medium' => '{nama} menunjukkan perkembangan motorik yang cukup baik. Ia cukup aktif dalam kegiatan fisik dan koordinasi geraknya terus berkembang.',
            'low'    => '{nama} masih perlu latihan dalam kegiatan motorik. Koordinasi gerak kasar dan halus masih dalam tahap berkembang.',
        ],
        'Kognitif' => [
            'high'   => '{nama} mampu mengenali bentuk, warna, dan angka sederhana. Ia menunjukkan kemampuan berpikir logis yang sesuai dengan usianya.',
            'medium' => '{nama} cukup mampu mengenal bentuk dan warna dasar. Kemampuan berpikir logisnya terus berkembang dengan baik.',
            'low'    => '{nama} masih belajar mengenal konsep dasar kognitif. Dengan stimulasi yang tepat, kemampuannya akan terus berkembang.',
        ],
        'Bahasa' => [
            'high'   => '{nama} mampu berkomunikasi dengan baik dan mengungkapkan ide secara runtut. Penguasaan kosakatanya sesuai dengan usianya.',
            'medium' => '{nama} cukup baik dalam berkomunikasi dengan teman-temannya. Kemampuan mengungkapkan ide terus berkembang.',
            'low'    => '{nama} masih dalam proses mengembangkan kemampuan bahasa. Perlu didukung dengan stimulasi membaca dan bercerita di rumah.',
        ],
        'Sosial Emosional' => [
            'high'   => '{nama} menunjukkan kemampuan bersosialisasi yang baik. Ia senang bermain bersama teman, mampu berbagi, dan menunjukkan empati.',
            'medium' => '{nama} cukup baik dalam bersosialisasi dengan teman. Kemampuan berbagi dan empatinya terus berkembang.',
            'low'    => '{nama} masih perlu bimbingan dalam berinteraksi dengan teman-temannya. Proses sosialisasi dan pengelolaan emosi terus didampingi.',
        ],
        'Seni' => [
            'high'   => '{nama} memiliki bakat seni yang menonjol. Ia sangat antusias dalam kegiatan menggambar dan mewarnai dengan kreativitas yang tinggi.',
            'medium' => '{nama} cukup antusias dalam kegiatan seni. Ia mulai menunjukkan kreativitas dalam menggambar dan mewarnai.',
            'low'    => '{nama} masih dalam proses mengembangkan kemampuan seni. Perlu didorong untuk lebih aktif dalam kegiatan kreatif.',
        ],
    ];

    public function run(): void
    {
        $subjects      = Subject::all()->keyBy('name');
        $extracurriculars = Extracurricular::with('assessments')->get();
        $counselings   = Counseling::with('assessments')->get();

        // Ambil enrollments ganjil 2025/2026 — 4 siswa per kelas (A, B1, B2)
        $targetNames = [
            // Kelas A
            'ALVARO ATHAYA ARIYUN',
            'M. RAFFA ALFATIH AFRIYADI',
            'MAHENDRA ANDRIAN',
            'YUKI MAHARANI',
            // Kelas B1
            'ABIL ALTAIR ERDHAFEN',
            'AKSYAHRA VYANTA HUMAIRA MECCA',
            'AISYAH PUTRI INAYAH',
            'ATHALLA MAHER',
            // Kelas B2
            'ANDHANU RHADITYA',
            'NAUFAL RAMADHAN',
            'NAYLA NANDA PUTRI',
            'RENATA ARSY SUSILO',
        ];

        $enrollments = StudentEnrollment::with([
                'student',
                'classTerm.academicTerm',
                'classTerm.extracurriculars',
            ])
            ->whereHas('classTerm.academicTerm', fn($q) => $q->where('semester', 'ganjil'))
            ->whereHas('student', fn($q) => $q->whereIn('name', $targetNames))
            ->whereDoesntHave('report')
            ->get();

        foreach ($enrollments as $enrollment) {
            $student = $enrollment->student;
            $nama    = ucwords(strtolower($student->name));

            // Pilih "level kecakapan" pseudo-random tapi deterministik per siswa
            $seed   = crc32($student->name);
            $high   = ($seed % 3 === 0) ? 'high' : (($seed % 3 === 1) ? 'medium' : 'high');

            $report = Report::create([
                'student_enrollment_id' => $enrollment->id,
            ]);

            // Buat created_at mundur ke Desember 2025 agar terlihat "sudah terbit"
            $report->created_at = Carbon::create(2025, 12, 20, 8, 0, 0);
            $report->save();

            // ── Mata Pelajaran ─────────────────────────────────
            foreach ($subjects as $subjectName => $subject) {
                $template = $this->descTemplates[$subjectName] ?? null;
                $desc = $template
                    ? str_replace('{nama}', $nama, $template[$high])
                    : "{$nama} menunjukkan perkembangan yang baik dalam {$subjectName}.";

                ReportSubject::create([
                    'report_id'   => $report->id,
                    'subject_id'  => $subject->id,
                    'description' => $desc,
                ]);
            }

            // ── Ekstrakurikuler (2 dari 3, variatif per siswa) ─
            $ekList = $extracurriculars->shuffle()->take(2);
            foreach ($ekList as $ek) {
                $re = ReportExtracurricular::create([
                    'report_id'           => $report->id,
                    'extracurricular_id'  => $ek->id,
                ]);

                foreach ($ek->assessments as $i => $assessment) {
                    $levelIndex = ($seed + $i) % 4;
                    ReportExtracurricularScore::create([
                        'report_extracurricular_id'   => $re->id,
                        'extracurricular_assessment_id' => $assessment->id,
                        'level' => $this->levels[$levelIndex],
                    ]);
                }
            }

            // ── Konseling (semua kategori, 1 entry per assessment) ─
            $baseDate = Carbon::create(2025, 12, 1);
            foreach ($counselings as $ci => $counseling) {
                $rc = ReportCounseling::create([
                    'report_id'    => $report->id,
                    'counseling_id' => $counseling->id,
                ]);

                foreach ($counseling->assessments as $ai => $assessment) {
                    $levelIndex = ($seed + $ci + $ai) % 4;
                    ReportCounselingScore::create([
                        'report_counseling_id'      => $rc->id,
                        'counseling_assessment_id'  => $assessment->id,
                        'level' => $this->levels[$levelIndex],
                        'week'  => $ci + 1,
                        'date'  => $baseDate->copy()->addWeeks($ci)->toDateString(),
                    ]);
                }
            }
        }

        $this->command->info('RapotSeeder: rapot berhasil dibuat untuk ' . $enrollments->count() . ' siswa.');
    }
}
