<?php

namespace Database\Seeders;

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

    private array $targetNames = [
        'ALVARO ATHAYA ARIYUN',
        'M. RAFFA ALFATIH AFRIYADI',
        'MAHENDRA ANDRIAN',
        'YUKI MAHARANI',
        'ABIL ALTAIR ERDHAFEN',
        'AKSYAHRA VYANTA HUMAIRA MECCA',
        'AISYAH PUTRI INAYAH',
        'ATHALLA MAHER',
        'ANDHANU RHADITYA',
        'NAUFAL RAMADHAN',
        'NAYLA NANDA PUTRI',
        'RENATA ARSY SUSILO',
    ];

    public function run(): void
    {
        // Bersihkan data rapot lama untuk siswa target agar bisa re-seed
        $this->cleanOldReports();

        $subjects         = Subject::all()->keyBy('name');
        $extracurriculars = Extracurricular::with('assessments')->get();
        $counselings      = Counseling::with('assessments')->get();

        $enrollments = StudentEnrollment::with([
                'student',
                'classTerm.academicTerm',
                'classTerm.extracurriculars',
            ])
            ->whereHas('classTerm.academicTerm', fn($q) => $q->where('semester', 'ganjil'))
            ->whereHas('student', fn($q) => $q->whereIn('name', $this->targetNames))
            ->whereDoesntHave('report')
            ->get();

        foreach ($enrollments as $enrollment) {
            $student = $enrollment->student;
            $nama    = ucwords(strtolower($student->name));
            $seed    = abs(crc32($student->name));
            $quality = ($seed % 3 === 0) ? 'high' : (($seed % 3 === 1) ? 'medium' : 'high');

            $report = Report::create([
                'student_enrollment_id' => $enrollment->id,
            ]);
            $report->created_at = Carbon::create(2025, 12, 20, 8, 0, 0);
            $report->save();

            // ── Mata Pelajaran ──────────────────────────────────
            foreach ($subjects as $subjectName => $subject) {
                $template = $this->descTemplates[$subjectName] ?? null;
                $desc = $template
                    ? str_replace('{nama}', $nama, $template[$quality])
                    : "{$nama} menunjukkan perkembangan yang baik dalam {$subjectName}.";

                ReportSubject::create([
                    'report_id'   => $report->id,
                    'subject_id'  => $subject->id,
                    'description' => $desc,
                ]);
            }

            // ── Ekstrakurikuler (2 dari yang ada) ───────────────
            $ekList = $extracurriculars->shuffle()->take(2);
            foreach ($ekList as $ek) {
                $re = ReportExtracurricular::create([
                    'report_id'          => $report->id,
                    'extracurricular_id' => $ek->id,
                ]);
                foreach ($ek->assessments as $i => $assessment) {
                    ReportExtracurricularScore::create([
                        'report_extracurricular_id'     => $re->id,
                        'extracurricular_assessment_id' => $assessment->id,
                        'level'                         => $this->levels[($seed + $i) % 4],
                    ]);
                }
            }

            // ── Konseling: 12 minggu per kategori ───────────────
            // Level berkembang dari BB/MB di minggu awal ke BSH/BSB di minggu akhir
            $baseDate   = Carbon::create(2025, 7, 7); // Minggu pertama semester ganjil
            $startLevel = ($seed % 2);                // 0=BB atau 1=MB sebagai titik awal

            foreach ($counselings as $counseling) {
                $rc = ReportCounseling::create([
                    'report_id'     => $report->id,
                    'counseling_id' => $counseling->id,
                ]);

                for ($week = 1; $week <= 12; $week++) {
                    // Level meningkat seiring minggu: mulai dari startLevel, naik tiap ~3 minggu
                    $progress = $startLevel + intval(($week - 1) / 3);

                    foreach ($counseling->assessments as $ai => $assessment) {
                        // Sedikit variasi antar assessment agar tidak semua sama
                        $variation = ($seed + $ai) % 2 === 0 ? 0 : 0;
                        $lvIdx     = min(3, $progress + $variation);

                        ReportCounselingScore::create([
                            'report_counseling_id'     => $rc->id,
                            'counseling_assessment_id' => $assessment->id,
                            'level'                    => $this->levels[$lvIdx],
                            'week'                     => $week,
                            'date'                     => $baseDate->copy()->addWeeks($week - 1)->toDateString(),
                        ]);
                    }
                }
            }
        }

        $this->command->info('RapotSeeder: rapot berhasil dibuat untuk ' . $enrollments->count() . ' siswa.');
    }

    private function cleanOldReports(): void
    {
        $enrollmentIds = StudentEnrollment::whereHas(
            'student', fn($q) => $q->whereIn('name', $this->targetNames)
        )->pluck('id');

        $reportIds = Report::whereIn('student_enrollment_id', $enrollmentIds)->pluck('id');

        if ($reportIds->isEmpty()) return;

        // Hapus dari tabel paling dalam dulu (hard delete agar bersih)
        \DB::table('report_counseling_score')
            ->whereIn('report_counseling_id', function ($q) use ($reportIds) {
                $q->select('id')->from('report_counseling')->whereIn('report_id', $reportIds);
            })->delete();

        \DB::table('report_extracurricular_score')
            ->whereIn('report_extracurricular_id', function ($q) use ($reportIds) {
                $q->select('id')->from('report_extracurricular')->whereIn('report_id', $reportIds);
            })->delete();

        \DB::table('report_subject_image')
            ->whereIn('report_subject_id', function ($q) use ($reportIds) {
                $q->select('id')->from('report_subject')->whereIn('report_id', $reportIds);
            })->delete();

        \DB::table('report_counseling')->whereIn('report_id', $reportIds)->delete();
        \DB::table('report_extracurricular')->whereIn('report_id', $reportIds)->delete();
        \DB::table('report_subject')->whereIn('report_id', $reportIds)->delete();
        \DB::table('report')->whereIn('id', $reportIds)->delete();

        $this->command->info('RapotSeeder: membersihkan ' . $reportIds->count() . ' rapot lama.');
    }
}
