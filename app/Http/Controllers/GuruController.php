<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Student;
use App\Models\ClassTerm;
use App\Models\StudentEnrollment;
use App\Models\Presence;
use App\Models\ClassSchedule;
use App\Models\ActivitySchedule;
use App\Models\ClassTermSubject;
use App\Models\ClassTermExtracurricular;
use App\Models\ClassTermCounseling;
use App\Models\Report;
use App\Models\ReportSubject;
use App\Models\ReportSubjectImage;
use App\Models\ReportExtracurricular;
use App\Models\ReportExtracurricularScore;
use App\Models\ReportCounseling;
use App\Models\ReportCounselingScore;
use App\Models\ExtracurricularAssessment;
use App\Models\CounselingAssessment;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Models\PrivateCounselingSchedule;
use Illuminate\Support\Str;

class GuruController extends Controller
{
    private function academicTermLabel($at): string
    {
        if (!$at) return '-';
        return trim(($at->academic_year ?? '') . ' ' . ucfirst($at->semester ?? ''));
    }

    private function buildClassTermsForJadwal(): array
    {
        return ClassTerm::with(['class', 'academicTerm', 'enrollments.student'])
            ->get()
            ->map(function ($ct) {
                $students = $ct->enrollments
                    ->filter(fn($e) => $e->student)
                    ->map(fn($e) => ['id' => $e->student->id, 'nama' => $e->student->name])
                    ->values()->toArray();
                $semLabel = $this->academicTermLabel($ct->academicTerm);
                return [
                    'id'          => $ct->id,
                    'label'       => ($ct->class->name ?? '-') . ' — ' . $semLabel,
                    'kelas'       => $ct->class->name ?? '-',
                    'semester'    => $semLabel,
                    'siswa'       => $students,
                    'siswa_count' => count($students),
                ];
            })->toArray();
    }

    private function scheduleToArray(PrivateCounselingSchedule $s): array
    {
        $isKelas   = is_null($s->student_id);
        $classTerm = $s->classTerm;
        $count     = $isKelas ? ($classTerm ? $classTerm->enrollments()->count() : 0) : 0;
        $siswa     = $isKelas
            ? ($classTerm?->class?->name ?? 'Kelas') . ' (' . $count . ' siswa)'
            : ($s->student?->name ?? '-');
        $semLabel = $this->academicTermLabel($classTerm?->academicTerm);
        return [
            'id'          => $s->id,
            'tanggal'     => $s->date?->translatedFormat('d M Y') ?? '-',
            'tanggal_raw' => $s->date?->format('Y-m-d') ?? '',
            'tanggal_sort'=> $s->date?->format('Y-m-d') ?? '',
            'waktu'       => ($s->start_hour ?? '') . ' - ' . ($s->end_hour ?? ''),
            'orang_tua'   => $s->student?->user?->email ?? '-',
            'siswa'       => $siswa,
            'class_term'  => ($classTerm?->class?->name ?? '-') . ' — ' . $semLabel,
            'kelas'       => $classTerm?->class?->name ?? '-',
            'tipe'        => $isKelas ? 'per_kelas' : 'per_siswa',
            'dari'        => 'guru',
            'topik'       => $s->topic ?? '',
            'status'      => $s->status ?? 'pending',
            'bulan'       => (int) ($s->date?->format('n') ?? 0),
            'tahun'       => (int) ($s->date?->format('Y') ?? 0),
            'catatan'     => '',
        ];
    }

    // Jadwal Konseling
    public function jadwalKonseling(Request $request)
    {
        $bulanTahun = $request->get('bulan_tahun', date('Y-m'));
        [$tahunFilter, $bulan] = array_map('intval', explode('-', $bulanTahun));

        $jadwal = PrivateCounselingSchedule::with(['student.user', 'classTerm.class', 'classTerm.academicTerm'])
            ->whereYear('date', $tahunFilter)
            ->whereMonth('date', $bulan)
            ->orderByDesc('date')
            ->get()
            ->map(fn($s) => $this->scheduleToArray($s))
            ->values()->all();

        return view('guru.jadwal_konseling', compact('jadwal', 'bulan', 'bulanTahun'));
    }

    public function storeJadwalKonseling(Request $request)
    {
        $request->validate([
            'mode'          => 'required|in:siswa,kelas',
            'class_term_id' => 'required|exists:class_term,id',
            'tanggal'       => 'required|date',
            'waktu_mulai'   => 'required',
            'waktu_selesai' => 'required',
            'topik'         => 'required|string|max:1000',
        ]);

        $base = [
            'class_term_id' => $request->class_term_id,
            'teacher_id'    => auth()->id(),
            'date'          => $request->tanggal,
            'start_hour'    => $request->waktu_mulai,
            'end_hour'      => $request->waktu_selesai,
            'topic'         => $request->topik,
            'status'        => 'pending',
        ];

        if ($request->mode === 'kelas') {
            PrivateCounselingSchedule::create(array_merge($base, ['student_id' => null]));
            $msg = 'Jadwal konseling per kelas berhasil dibuat.';
            Activity::log("membuat jadwal konseling per kelas pada {$request->tanggal}");
        } else {
            $request->validate(['siswa_id' => 'required|exists:student,id']);
            PrivateCounselingSchedule::create(array_merge($base, ['student_id' => $request->siswa_id]));
            $msg = 'Jadwal konseling berhasil dibuat.';
            $studentName = Student::find($request->siswa_id)?->name ?? '-';
            Activity::log("membuat jadwal konseling untuk {$studentName} pada {$request->tanggal}");
        }

        return redirect()->route('guru.jadwal_konseling')->with('success', $msg);
    }

    public function jadwalKonselingCreateSiswa()
    {
        $classTerms = $this->buildClassTermsForJadwal();
        return view('guru.jadwal_konseling_create', [
            'mode'       => 'siswa',
            'classTerms' => $classTerms,
        ]);
    }

    public function jadwalKonselingCreateKelas()
    {
        $classTerms = $this->buildClassTermsForJadwal();
        return view('guru.jadwal_konseling_create', [
            'mode'       => 'kelas',
            'classTerms' => $classTerms,
        ]);
    }

    private function getDummyJadwalKonseling(): array
    {
        // tipe: 'per_siswa' | 'per_kelas' | 'pengajuan'
        // dari: 'guru' (per_siswa & per_kelas) | 'orang_tua' (pengajuan)
        $data = [
            // â”€â”€ NOVEMBER 2024 â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
            ['id'=>1,  'tanggal'=>'29 Nov 2024','tanggal_sort'=>'2024-11-29','waktu'=>'10:00 - 11:00','orang_tua'=>'Ibu Siti',    'siswa'=>'Ahmad Fauzi',         'kelas'=>'A1','tipe'=>'per_siswa','dari'=>'guru',      'topik'=>'Perkembangan Sosial-Emosional',       'status'=>'selesai',   'bulan'=>11,'tahun'=>2024,'catatan'=>'Anak menunjukkan kemajuan dalam interaksi dengan teman sebaya.'],
            ['id'=>2,  'tanggal'=>'27 Nov 2024','tanggal_sort'=>'2024-11-27','waktu'=>'08:00 - 09:30','orang_tua'=>'-',           'siswa'=>'Kelas A1 (8 siswa)',  'kelas'=>'A1','tipe'=>'per_kelas','dari'=>'guru',      'topik'=>'Evaluasi Asesmen Bulanan Kelas A1',   'status'=>'selesai',   'bulan'=>11,'tahun'=>2024,'catatan'=>'Seluruh wali murid Kelas A1 hadir. Diskusi berjalan kondusif.'],
            ['id'=>3,  'tanggal'=>'26 Nov 2024','tanggal_sort'=>'2024-11-26','waktu'=>'09:00 - 10:00','orang_tua'=>'Bapak Budi',  'siswa'=>'Siti Nurhaliza',      'kelas'=>'A1','tipe'=>'pengajuan','dari'=>'orang_tua', 'topik'=>'Konsultasi Perilaku di Rumah',        'status'=>'selesai',   'bulan'=>11,'tahun'=>2024,'catatan'=>'Orang tua melaporkan kesulitan dalam rutinitas belajar di rumah.'],
            ['id'=>4,  'tanggal'=>'25 Nov 2024','tanggal_sort'=>'2024-11-25','waktu'=>'13:00 - 14:00','orang_tua'=>'Ibu Dewi',    'siswa'=>'Eko Prasetyo',        'kelas'=>'A1','tipe'=>'per_siswa','dari'=>'guru',      'topik'=>'Perkembangan Kognitif & Kreativitas', 'status'=>'selesai',   'bulan'=>11,'tahun'=>2024,'catatan'=>'Eko menunjukkan perkembangan kognitif yang baik, aktif dalam kegiatan.'],
            ['id'=>5,  'tanggal'=>'22 Nov 2024','tanggal_sort'=>'2024-11-22','waktu'=>'10:00 - 11:00','orang_tua'=>'Ibu Ani',     'siswa'=>'Rina Susanti',        'kelas'=>'A2','tipe'=>'pengajuan','dari'=>'orang_tua', 'topik'=>'Penyesuaian Diri & Perhatian di Rumah','status'=>'selesai',  'bulan'=>11,'tahun'=>2024,'catatan'=>'Sesi berjalan dengan baik. Orang tua akan menerapkan saran guru.'],
            ['id'=>6,  'tanggal'=>'21 Nov 2024','tanggal_sort'=>'2024-11-21','waktu'=>'08:00 - 09:30','orang_tua'=>'-',           'siswa'=>'Kelas A2 (8 siswa)',  'kelas'=>'A2','tipe'=>'per_kelas','dari'=>'guru',      'topik'=>'Evaluasi Asesmen Bulanan Kelas A2',   'status'=>'selesai',   'bulan'=>11,'tahun'=>2024,'catatan'=>'Evaluasi berjalan lancar. Beberapa siswa perlu perhatian ekstra di aspek motorik.'],
            ['id'=>7,  'tanggal'=>'20 Nov 2024','tanggal_sort'=>'2024-11-20','waktu'=>'14:00 - 15:00','orang_tua'=>'Bapak Hadi',  'siswa'=>'Doni Saputra',        'kelas'=>'A2','tipe'=>'per_siswa','dari'=>'guru',      'topik'=>'Perkembangan Motorik Kasar & Halus',  'status'=>'selesai',   'bulan'=>11,'tahun'=>2024,'catatan'=>'Perkembangan motorik Doni meningkat pesat bulan ini.'],

            // â”€â”€ DECEMBER 2024 â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
            ['id'=>8,  'tanggal'=>'18 Des 2024','tanggal_sort'=>'2024-12-18','waktu'=>'08:00 - 09:30','orang_tua'=>'-',           'siswa'=>'Kelas A1 (8 siswa)',  'kelas'=>'A1','tipe'=>'per_kelas','dari'=>'guru',      'topik'=>'Persiapan & Evaluasi Semester Ganjil','status'=>'selesai',   'bulan'=>12,'tahun'=>2024,'catatan'=>'Semua wali hadir. Hasil asesmen semester dibagikan.'],
            ['id'=>9,  'tanggal'=>'17 Des 2024','tanggal_sort'=>'2024-12-17','waktu'=>'10:00 - 11:30','orang_tua'=>'-',           'siswa'=>'Kelas A2 (8 siswa)',  'kelas'=>'A2','tipe'=>'per_kelas','dari'=>'guru',      'topik'=>'Persiapan & Evaluasi Semester Ganjil','status'=>'selesai',   'bulan'=>12,'tahun'=>2024,'catatan'=>'Orang tua diberikan laporan perkembangan akhir semester.'],
            ['id'=>10, 'tanggal'=>'16 Des 2024','tanggal_sort'=>'2024-12-16','waktu'=>'13:00 - 14:00','orang_tua'=>'Ibu Ratna',   'siswa'=>'Anisa Putri',         'kelas'=>'A2','tipe'=>'per_siswa','dari'=>'guru',      'topik'=>'Konsultasi Perilaku & Kemandirian',   'status'=>'selesai',   'bulan'=>12,'tahun'=>2024,'catatan'=>'Anisa sudah menunjukkan peningkatan kemandirian. Tetap dipantau.'],
            ['id'=>11, 'tanggal'=>'12 Des 2024','tanggal_sort'=>'2024-12-12','waktu'=>'09:00 - 10:00','orang_tua'=>'Bapak Farid', 'siswa'=>'Farid Ridwan',        'kelas'=>'B1','tipe'=>'pengajuan','dari'=>'orang_tua', 'topik'=>'Perkembangan Bicara & Bahasa',        'status'=>'selesai',   'bulan'=>12,'tahun'=>2024,'catatan'=>'Orang tua menyampaikan kekhawatiran bicara. Akan di-refer ke terapis.'],
            ['id'=>12, 'tanggal'=>'10 Des 2024','tanggal_sort'=>'2024-12-10','waktu'=>'08:00 - 09:30','orang_tua'=>'-',           'siswa'=>'Kelas B1 (7 siswa)',  'kelas'=>'B1','tipe'=>'per_kelas','dari'=>'guru',      'topik'=>'Evaluasi Semester Ganjil Kelas B1',   'status'=>'selesai',   'bulan'=>12,'tahun'=>2024,'catatan'=>'Evaluasi dilakukan bersama seluruh wali murid Kelas B1.'],
            ['id'=>13, 'tanggal'=>'05 Des 2024','tanggal_sort'=>'2024-12-05','waktu'=>'11:00 - 12:00','orang_tua'=>'Bapak Zainal','siswa'=>'Zahra Aulia',         'kelas'=>'B1','tipe'=>'per_siswa','dari'=>'guru',      'topik'=>'Tindak Lanjut Hasil Asesmen Kognitif','status'=>'selesai',   'bulan'=>12,'tahun'=>2024,'catatan'=>'Zahra perlu pendampingan lebih dalam aspek konsentrasi.'],

            // â”€â”€ JANUARY 2026 â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
            ['id'=>14, 'tanggal'=>'27 Jan 2026','tanggal_sort'=>'2026-01-27','waktu'=>'08:00 - 09:30','orang_tua'=>'-',           'siswa'=>'Kelas A1 (8 siswa)',  'kelas'=>'A1','tipe'=>'per_kelas','dari'=>'guru',      'topik'=>'Orientasi Semester Genap 2025/2026',  'status'=>'selesai',   'bulan'=>1, 'tahun'=>2026,'catatan'=>'Orang tua mendapatkan informasi program semester genap.'],
            ['id'=>15, 'tanggal'=>'26 Jan 2026','tanggal_sort'=>'2026-01-26','waktu'=>'10:00 - 11:30','orang_tua'=>'-',           'siswa'=>'Kelas B1 (7 siswa)',  'kelas'=>'B1','tipe'=>'per_kelas','dari'=>'guru',      'topik'=>'Orientasi Semester Genap 2025/2026',  'status'=>'selesai',   'bulan'=>1, 'tahun'=>2026,'catatan'=>'Seluruh wali hadir dan antusias dengan program baru.'],
            ['id'=>16, 'tanggal'=>'22 Jan 2026','tanggal_sort'=>'2026-01-22','waktu'=>'10:00 - 11:00','orang_tua'=>'Ibu Siti',    'siswa'=>'Ahmad Fauzi',         'kelas'=>'A1','tipe'=>'per_siswa','dari'=>'guru',      'topik'=>'Tindak Lanjut Asesmen Semester Ganjil','status'=>'selesai',  'bulan'=>1, 'tahun'=>2026,'catatan'=>'Ahmad telah menunjukkan perkembangan signifikan. Program dilanjutkan.'],
            ['id'=>17, 'tanggal'=>'20 Jan 2026','tanggal_sort'=>'2026-01-20','waktu'=>'13:00 - 14:00','orang_tua'=>'Ibu Maya',    'siswa'=>'Maya Indah',          'kelas'=>'B1','tipe'=>'pengajuan','dari'=>'orang_tua', 'topik'=>'Perkembangan Motorik Halus',          'status'=>'selesai',   'bulan'=>1, 'tahun'=>2026,'catatan'=>'Ibu Maya khawatir dengan keterampilan motorik Maya. Diberikan latihan di rumah.'],
            ['id'=>18, 'tanggal'=>'16 Jan 2026','tanggal_sort'=>'2026-01-16','waktu'=>'09:00 - 10:00','orang_tua'=>'Bapak Zainal','siswa'=>'Zahra Aulia',         'kelas'=>'B1','tipe'=>'per_siswa','dari'=>'guru',      'topik'=>'Perkembangan Sosial-Emosional',       'status'=>'selesai',   'bulan'=>1, 'tahun'=>2026,'catatan'=>'Zahra mulai lebih percaya diri dalam bergaul dengan teman.'],
            ['id'=>19, 'tanggal'=>'13 Jan 2026','tanggal_sort'=>'2026-01-13','waktu'=>'11:00 - 12:00','orang_tua'=>'Ibu Lina',    'siswa'=>'Budi Santoso',        'kelas'=>'B2','tipe'=>'pengajuan','dari'=>'orang_tua', 'topik'=>'Konsultasi Awal Semester Genap',      'status'=>'selesai',   'bulan'=>1, 'tahun'=>2026,'catatan'=>'Diskusi lancar. Program di rumah diselaraskan dengan program sekolah.'],

            // â”€â”€ FEBRUARY 2026 â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
            ['id'=>20, 'tanggal'=>'26 Feb 2026','tanggal_sort'=>'2026-02-26','waktu'=>'08:00 - 09:30','orang_tua'=>'-',           'siswa'=>'Kelas B1 (7 siswa)',  'kelas'=>'B1','tipe'=>'per_kelas','dari'=>'guru',      'topik'=>'Asesmen Perkembangan Bulanan Feb',    'status'=>'selesai',   'bulan'=>2, 'tahun'=>2026,'catatan'=>'Hasil asesmen menunjukkan kemajuan baik di aspek bahasa dan kognitif.'],
            ['id'=>21, 'tanggal'=>'24 Feb 2026','tanggal_sort'=>'2026-02-24','waktu'=>'10:00 - 11:00','orang_tua'=>'Bapak Budi',  'siswa'=>'Siti Nurhaliza',      'kelas'=>'A1','tipe'=>'per_siswa','dari'=>'guru',      'topik'=>'Konsultasi Perkembangan Awal Semester','status'=>'selesai',  'bulan'=>2, 'tahun'=>2026,'catatan'=>'Siti sangat aktif dan menunjukkan kepemimpinan dalam kelompok.'],
            ['id'=>22, 'tanggal'=>'20 Feb 2026','tanggal_sort'=>'2026-02-20','waktu'=>'13:00 - 14:00','orang_tua'=>'Ibu Siti',    'siswa'=>'Ahmad Fauzi',         'kelas'=>'A1','tipe'=>'pengajuan','dari'=>'orang_tua', 'topik'=>'Kesulitan Konsentrasi Belajar di Rumah','status'=>'disetujui','bulan'=>2, 'tahun'=>2026,'catatan'=>'Guru akan memantau lebih dekat dan memberikan saran praktis.'],
            ['id'=>23, 'tanggal'=>'18 Feb 2026','tanggal_sort'=>'2026-02-18','waktu'=>'09:00 - 10:00','orang_tua'=>'Ibu Dewi',    'siswa'=>'Eko Prasetyo',        'kelas'=>'A1','tipe'=>'per_siswa','dari'=>'guru',      'topik'=>'Tindak Lanjut Asesmen Bulanan',       'status'=>'selesai',   'bulan'=>2, 'tahun'=>2026,'catatan'=>'Eko terus berkembang. Orang tua diminta mendukung latihan di rumah.'],
            ['id'=>24, 'tanggal'=>'14 Feb 2026','tanggal_sort'=>'2026-02-14','waktu'=>'10:00 - 11:00','orang_tua'=>'Ibu Ratna',   'siswa'=>'Anisa Putri',         'kelas'=>'A2','tipe'=>'pengajuan','dari'=>'orang_tua', 'topik'=>'Penyesuaian Diri & Sosialisasi',      'status'=>'selesai',   'bulan'=>2, 'tahun'=>2026,'catatan'=>'Anisa sudah mulai lebih mudah bergaul dengan teman baru.'],
            ['id'=>25, 'tanggal'=>'12 Feb 2026','tanggal_sort'=>'2026-02-12','waktu'=>'08:00 - 09:30','orang_tua'=>'-',           'siswa'=>'Kelas A2 (8 siswa)',  'kelas'=>'A2','tipe'=>'per_kelas','dari'=>'guru',      'topik'=>'Asesmen Perkembangan Bulanan Feb',    'status'=>'selesai',   'bulan'=>2, 'tahun'=>2026,'catatan'=>'Evaluasi berjalan baik. Beberapa siswa ditandai untuk perhatian ekstra.'],
            ['id'=>26, 'tanggal'=>'07 Feb 2026','tanggal_sort'=>'2026-02-07','waktu'=>'13:00 - 14:00','orang_tua'=>'Ibu Ani',     'siswa'=>'Rina Susanti',        'kelas'=>'A2','tipe'=>'per_siswa','dari'=>'guru',      'topik'=>'Perkembangan Bahasa & Komunikasi',    'status'=>'selesai',   'bulan'=>2, 'tahun'=>2026,'catatan'=>'Kosakata Rina berkembang pesat. Keterampilan bercerita sangat baik.'],

            // â”€â”€ MARCH 2026 â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
            ['id'=>27, 'tanggal'=>'27 Mar 2026','tanggal_sort'=>'2026-03-27','waktu'=>'09:00 - 10:00','orang_tua'=>'Ibu Siti',    'siswa'=>'Ahmad Fauzi',         'kelas'=>'A1','tipe'=>'per_siswa','dari'=>'guru',      'topik'=>'Perkembangan Sosial-Emosional',       'status'=>'disetujui', 'bulan'=>3, 'tahun'=>2026,'catatan'=>''],
            ['id'=>28, 'tanggal'=>'25 Mar 2026','tanggal_sort'=>'2026-03-25','waktu'=>'10:00 - 11:00','orang_tua'=>'Bapak Budi',  'siswa'=>'Siti Nurhaliza',      'kelas'=>'A1','tipe'=>'pengajuan','dari'=>'orang_tua', 'topik'=>'Konsultasi Perkembangan Umum',        'status'=>'pending',   'bulan'=>3, 'tahun'=>2026,'catatan'=>''],
            ['id'=>29, 'tanggal'=>'22 Mar 2026','tanggal_sort'=>'2026-03-22','waktu'=>'13:00 - 14:00','orang_tua'=>'Ibu Dewi',    'siswa'=>'Eko Prasetyo',        'kelas'=>'A1','tipe'=>'pengajuan','dari'=>'orang_tua', 'topik'=>'Perkembangan Kognitif & Kreativitas', 'status'=>'pending',   'bulan'=>3, 'tahun'=>2026,'catatan'=>''],
            ['id'=>30, 'tanggal'=>'20 Mar 2026','tanggal_sort'=>'2026-03-20','waktu'=>'08:00 - 09:00','orang_tua'=>'-',           'siswa'=>'Kelas B1 (7 siswa)',  'kelas'=>'B1','tipe'=>'per_kelas','dari'=>'guru',      'topik'=>'Evaluasi Perkembangan Bulanan Mar',   'status'=>'disetujui', 'bulan'=>3, 'tahun'=>2026,'catatan'=>''],
            ['id'=>31, 'tanggal'=>'18 Mar 2026','tanggal_sort'=>'2026-03-18','waktu'=>'14:00 - 15:00','orang_tua'=>'Ibu Siti',    'siswa'=>'Ahmad Fauzi',         'kelas'=>'A1','tipe'=>'pengajuan','dari'=>'orang_tua', 'topik'=>'Konsultasi Perilaku & Kebiasaan',     'status'=>'disetujui', 'bulan'=>3, 'tahun'=>2026,'catatan'=>''],
            ['id'=>32, 'tanggal'=>'15 Mar 2026','tanggal_sort'=>'2026-03-15','waktu'=>'11:00 - 12:00','orang_tua'=>'Ibu Siti',    'siswa'=>'Ahmad Fauzi',         'kelas'=>'A1','tipe'=>'pengajuan','dari'=>'orang_tua', 'topik'=>'Diskusi Pola Belajar di Rumah',       'status'=>'pending',   'bulan'=>3, 'tahun'=>2026,'catatan'=>''],
            ['id'=>33, 'tanggal'=>'12 Mar 2026','tanggal_sort'=>'2026-03-12','waktu'=>'08:00 - 09:00','orang_tua'=>'Ibu Ani',     'siswa'=>'Rina Susanti',        'kelas'=>'A2','tipe'=>'per_siswa','dari'=>'guru',      'topik'=>'Perkembangan Bahasa & Literasi',      'status'=>'disetujui', 'bulan'=>3, 'tahun'=>2026,'catatan'=>''],
            ['id'=>34, 'tanggal'=>'10 Mar 2026','tanggal_sort'=>'2026-03-10','waktu'=>'13:00 - 14:00','orang_tua'=>'Bapak Farid', 'siswa'=>'Farid Ridwan',        'kelas'=>'B1','tipe'=>'pengajuan','dari'=>'orang_tua', 'topik'=>'Perkembangan Bicara & Artikulasi',    'status'=>'pending',   'bulan'=>3, 'tahun'=>2026,'catatan'=>''],
            ['id'=>35, 'tanggal'=>'07 Mar 2026','tanggal_sort'=>'2026-03-07','waktu'=>'10:00 - 11:00','orang_tua'=>'Bapak Hadi',  'siswa'=>'Doni Saputra',        'kelas'=>'A2','tipe'=>'per_siswa','dari'=>'guru',      'topik'=>'Konsultasi Perilaku Sosial',          'status'=>'disetujui', 'bulan'=>3, 'tahun'=>2026,'catatan'=>''],
            ['id'=>36, 'tanggal'=>'05 Mar 2026','tanggal_sort'=>'2026-03-05','waktu'=>'09:00 - 10:00','orang_tua'=>'Ibu Siti',    'siswa'=>'Ahmad Fauzi',         'kelas'=>'A1','tipe'=>'per_siswa','dari'=>'guru',      'topik'=>'Perkembangan Sosial Semester Genap',  'status'=>'disetujui', 'bulan'=>3, 'tahun'=>2026,'catatan'=>''],

            // â”€â”€ APRIL 2026 â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
            ['id'=>37, 'tanggal'=>'28 Apr 2026','tanggal_sort'=>'2026-04-28','waktu'=>'08:00 - 09:30','orang_tua'=>'-',           'siswa'=>'Kelas A1 (8 siswa)',  'kelas'=>'A1','tipe'=>'per_kelas','dari'=>'guru',      'topik'=>'Asesmen Perkembangan Q2 Kelas A1',   'status'=>'pending',   'bulan'=>4, 'tahun'=>2026,'catatan'=>''],
            ['id'=>38, 'tanggal'=>'25 Apr 2026','tanggal_sort'=>'2026-04-25','waktu'=>'10:00 - 11:00','orang_tua'=>'Ibu Maya',    'siswa'=>'Maya Indah',          'kelas'=>'B1','tipe'=>'per_siswa','dari'=>'guru',      'topik'=>'Perkembangan Seni & Kreativitas',     'status'=>'pending',   'bulan'=>4, 'tahun'=>2026,'catatan'=>''],
            ['id'=>39, 'tanggal'=>'22 Apr 2026','tanggal_sort'=>'2026-04-22','waktu'=>'08:00 - 09:30','orang_tua'=>'-',           'siswa'=>'Kelas A2 (8 siswa)',  'kelas'=>'A2','tipe'=>'per_kelas','dari'=>'guru',      'topik'=>'Evaluasi Bulanan April Kelas A2',     'status'=>'disetujui', 'bulan'=>4, 'tahun'=>2026,'catatan'=>''],
            ['id'=>40, 'tanggal'=>'18 Apr 2026','tanggal_sort'=>'2026-04-18','waktu'=>'13:00 - 14:00','orang_tua'=>'Bapak Zainal','siswa'=>'Zahra Aulia',         'kelas'=>'B1','tipe'=>'pengajuan','dari'=>'orang_tua', 'topik'=>'Perkembangan Bicara & Kepercayaan Diri','status'=>'pending', 'bulan'=>4, 'tahun'=>2026,'catatan'=>''],
            ['id'=>41, 'tanggal'=>'15 Apr 2026','tanggal_sort'=>'2026-04-15','waktu'=>'10:00 - 11:00','orang_tua'=>'Bapak Farid', 'siswa'=>'Farid Ridwan',        'kelas'=>'B1','tipe'=>'per_siswa','dari'=>'guru',      'topik'=>'Konsultasi Perilaku Lanjutan',        'status'=>'tolak',     'bulan'=>4, 'tahun'=>2026,'catatan'=>'Jadwal bentrok dengan kegiatan kelas. Diminta dijadwal ulang.'],
            ['id'=>42, 'tanggal'=>'10 Apr 2026','tanggal_sort'=>'2026-04-10','waktu'=>'09:00 - 10:00','orang_tua'=>'Ibu Dewi',    'siswa'=>'Eko Prasetyo',        'kelas'=>'A1','tipe'=>'pengajuan','dari'=>'orang_tua', 'topik'=>'Konsultasi Perkembangan Umum',        'status'=>'disetujui', 'bulan'=>4, 'tahun'=>2026,'catatan'=>''],

            // â”€â”€ MAY 2026 â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
            ['id'=>43, 'tanggal'=>'22 Mei 2026','tanggal_sort'=>'2026-05-22','waktu'=>'08:00 - 09:30','orang_tua'=>'-',           'siswa'=>'Kelas A1 (8 siswa)',  'kelas'=>'A1','tipe'=>'per_kelas','dari'=>'guru',      'topik'=>'Evaluasi Bulanan Mei Kelas A1',       'status'=>'pending',   'bulan'=>5, 'tahun'=>2026,'catatan'=>''],
            ['id'=>44, 'tanggal'=>'20 Mei 2026','tanggal_sort'=>'2026-05-20','waktu'=>'08:00 - 09:30','orang_tua'=>'-',           'siswa'=>'Kelas B1 (7 siswa)',  'kelas'=>'B1','tipe'=>'per_kelas','dari'=>'guru',      'topik'=>'Asesmen Perkembangan Semester Genap', 'status'=>'disetujui', 'bulan'=>5, 'tahun'=>2026,'catatan'=>''],
            ['id'=>45, 'tanggal'=>'19 Mei 2026','tanggal_sort'=>'2026-05-19','waktu'=>'10:00 - 11:00','orang_tua'=>'Ibu Siti',    'siswa'=>'Ahmad Fauzi',         'kelas'=>'A1','tipe'=>'per_siswa','dari'=>'guru',      'topik'=>'Tindak Lanjut Asesmen April',         'status'=>'pending',   'bulan'=>5, 'tahun'=>2026,'catatan'=>''],
            ['id'=>46, 'tanggal'=>'16 Mei 2026','tanggal_sort'=>'2026-05-16','waktu'=>'13:00 - 14:00','orang_tua'=>'Bapak Budi',  'siswa'=>'Siti Nurhaliza',      'kelas'=>'A1','tipe'=>'per_siswa','dari'=>'guru',      'topik'=>'Perkembangan Sosial & Emosi',         'status'=>'pending',   'bulan'=>5, 'tahun'=>2026,'catatan'=>''],
            ['id'=>47, 'tanggal'=>'14 Mei 2026','tanggal_sort'=>'2026-05-14','waktu'=>'09:00 - 10:00','orang_tua'=>'Bapak Hadi',  'siswa'=>'Doni Saputra',        'kelas'=>'A2','tipe'=>'pengajuan','dari'=>'orang_tua', 'topik'=>'Konsultasi Kebiasaan & Rutinitas Anak','status'=>'pending',  'bulan'=>5, 'tahun'=>2026,'catatan'=>''],
            ['id'=>48, 'tanggal'=>'12 Mei 2026','tanggal_sort'=>'2026-05-12','waktu'=>'11:00 - 12:00','orang_tua'=>'Ibu Lina',    'siswa'=>'Budi Santoso',        'kelas'=>'B2','tipe'=>'pengajuan','dari'=>'orang_tua', 'topik'=>'Perkembangan Motorik & Koordinasi',   'status'=>'pending',   'bulan'=>5, 'tahun'=>2026,'catatan'=>''],
            ['id'=>49, 'tanggal'=>'09 Mei 2026','tanggal_sort'=>'2026-05-09','waktu'=>'14:00 - 15:00','orang_tua'=>'Ibu Ratna',   'siswa'=>'Anisa Putri',         'kelas'=>'A2','tipe'=>'per_siswa','dari'=>'guru',      'topik'=>'Konsultasi Perkembangan Bulanan',     'status'=>'pending',   'bulan'=>5, 'tahun'=>2026,'catatan'=>''],
        ];

        return collect($data)->keyBy('id')->all();
    }

    public function jadwalKonselingShow($id)
    {
        $s = PrivateCounselingSchedule::with(['student.user', 'classTerm.class', 'classTerm.academicTerm'])
            ->findOrFail($id);
        $jadwal = $this->scheduleToArray($s);
        return view('guru.jadwal_konseling_show', compact('jadwal'));
    }

    public function jadwalKonselingEdit($id)
    {
        $s = PrivateCounselingSchedule::with(['student.user', 'classTerm.class', 'classTerm.academicTerm'])
            ->findOrFail($id);
        $jadwal = $this->scheduleToArray($s);
        return view('guru.jadwal_konseling_edit', compact('jadwal'));
    }

    public function jadwalKonselingUpdate(Request $request, $id)
    {
        $request->validate([
            'tanggal'      => 'required|date',
            'waktu_mulai'  => 'required',
            'waktu_selesai'=> 'required',
            'topik'        => 'required|string|max:1000',
        ]);
        PrivateCounselingSchedule::findOrFail($id)->update([
            'date'       => $request->tanggal,
            'start_hour' => $request->waktu_mulai,
            'end_hour'   => $request->waktu_selesai,
            'topic'      => $request->topik,
        ]);
        return redirect()->route('guru.jadwal_konseling')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function jadwalKonselingSetuju(Request $request, $id)
    {
        PrivateCounselingSchedule::findOrFail($id)->update(['status' => 'approved']);
        return redirect()->route('guru.jadwal_konseling')->with('success', 'Jadwal konseling disetujui.');
    }

    public function jadwalKonselingTolak(Request $request, $id)
    {
        PrivateCounselingSchedule::findOrFail($id)->update(['status' => 'rejected']);
        return redirect()->route('guru.jadwal_konseling')->with('success', 'Jadwal konseling ditolak.');
    }

    public function jadwalKonselingBatalkan(Request $request, $id)
    {
        PrivateCounselingSchedule::findOrFail($id)->update(['status' => 'canceled']);
        return redirect()->route('guru.jadwal_konseling')->with('success', 'Jadwal konseling dibatalkan.');
    }

    // Chat
    public function chat(Request $request)
    {
        $me     = auth()->user();
        $roomId = $request->get('room');

        // All rooms for current user, sorted by latest message
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
                'sub'     => ucfirst($other?->role ?? 'orangtua'),
                'preview' => $latest ? Str::limit($latest->message, 35) : 'Belum ada pesan',
                'waktu'   => $latest ? $latest->created_at->format('H:i') : '',
            ];
        })->toArray();

        // Active room
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
                    'sub'     => ucfirst($other?->role ?? 'orangtua'),
                ];
                $pesan = $activeRoom->messages->map(fn($msg) => [
                    'is_mine' => $msg->sender_id === $me->id,
                    'teks'    => $msg->message,
                    'waktu'   => $msg->created_at->format('H:i'),
                    'initial' => strtoupper(mb_substr($msg->sender?->name ?? '?', 0, 1)),
                ])->toArray();
            }
        }

        // All active users not yet in a room with current user
        $existingPartners = ChatRoom::where('user_a_id', $me->id)->pluck('user_b_id')
            ->merge(ChatRoom::where('user_b_id', $me->id)->pluck('user_a_id'));

        $orangtua = \App\Models\User::where('id', '!=', $me->id)
            ->where('role', '!=', 'admin')
            ->whereNotIn('id', $existingPartners)
            ->orderBy('name')
            ->get()
            ->map(fn($u) => [
                'id'      => $u->id,
                'nama'    => $u->name,
                'initial' => strtoupper(mb_substr($u->name, 0, 1)),
                'role'    => ucfirst($u->role ?? ''),
            ])->toArray();

        return view('guru.chat', compact('kontak', 'aktif', 'aktifId', 'pesan', 'orangtua'));
    }

    public function openOrCreateRoom(Request $request)
    {
        $request->validate(['target_user_id' => 'required|exists:user,id']);
        $me       = auth()->id();
        $targetId = $request->target_user_id;

        $room = ChatRoom::where(function ($q) use ($me, $targetId) {
            $q->where('user_a_id', $me)->where('user_b_id', $targetId);
        })->orWhere(function ($q) use ($me, $targetId) {
            $q->where('user_a_id', $targetId)->where('user_b_id', $me);
        })->first();

        if (!$room) {
            $room = ChatRoom::create(['user_a_id' => $me, 'user_b_id' => $targetId]);
        }

        return redirect()->route('guru.chat', ['room' => $room->id]);
    }

    public function kirimChat(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:chat_room,id',
            'pesan'   => 'required|string|max:2000',
        ]);

        $me = auth()->id();
        $room = ChatRoom::where('id', $request->room_id)
            ->where(fn($q) => $q->where('user_a_id', $me)->orWhere('user_b_id', $me))
            ->firstOrFail();

        ChatMessage::create([
            'chat_room_id' => $room->id,
            'sender_id'    => $me,
            'message'      => $request->pesan,
        ]);

        return redirect()->route('guru.chat', ['room' => $room->id]);
    }

    /**
     * Bangun semua dummy laporan perkembangan dari dataset grafik.
     * Setiap (semester Ã— siswa Ã— minggu) jadi satu laporan dengan id deterministic.
     */
    private function buildDummyLaporanList()
    {
        $ds   = $this->dummyGrafikDataset();
        $W    = 12;
        $rows = [];
        $id   = 1;

        // Tanggal anchor per semester (minggu 1)
        $anchors = [
            'sm1' => '2025-08-01', // 2025/2026 Ganjil
            'sm2' => '2025-01-13', // 2024/2025 Genap
        ];

        // Bangun lookup raw scores yang sama dengan grafik() agar konsisten
        foreach ($ds['semesters'] as $sm) {
            $smId   = $sm['id'];
            $anchor = $anchors[$smId] ?? '2025-08-01';

            foreach ($ds['kelas'] as $k) {
                $kelasId = $k['id'];
                $siswas  = $ds['siswaByKelas'][$kelasId] ?? [];

                foreach ($siswas as $s) {
                    // Generate skor yang sama dengan grafik() (deterministic)
                    $rawSiswa = [];
                    foreach ($ds['konselings'] as $con) {
                        foreach ($con['assessments'] as $ca) {
                            $seed = abs(crc32($smId . $s['id'] . $ca['id']));
                            $cur  = ($seed % 2) + 2;
                            for ($w = 1; $w <= $W; $w++) {
                                $r = abs(crc32($smId . $s['id'] . $ca['id'] . $w)) % 10;
                                if ($r >= 7 && $cur < 4) $cur++;
                                elseif ($r <= 1 && $cur > 1) $cur--;
                                $rawSiswa[$ca['id']][$w] = $cur;
                            }
                        }
                    }

                    for ($w = 1; $w <= $W; $w++) {
                        // Hitung rata-rata semua poin pada minggu ini
                        $sum = 0; $cnt = 0;
                        foreach ($ds['konselings'] as $con) {
                            foreach ($con['assessments'] as $ca) {
                                $sum += $rawSiswa[$ca['id']][$w];
                                $cnt++;
                            }
                        }
                        $avg = $cnt ? round($sum / $cnt, 2) : 0;

                        $tanggal = date('Y-m-d', strtotime($anchor . ' +' . ($w - 1) . ' weeks'));

                        $rows[] = [
                            'id'           => $id++,
                            'semester_id'  => $smId,
                            'semester'     => $sm['label'],
                            'kelas_id'     => $kelasId,
                            'kelas'        => $k['nama'],
                            'siswa_id'     => $s['id'],
                            'siswa_nama'   => $s['nama'],
                            'minggu'       => $w,
                            'tanggal'      => $tanggal,
                            'tanggal_label'=> date('d M Y', strtotime($tanggal)),
                            'rata_rata'    => $avg,
                            'scores'       => $rawSiswa, // [assessmentId => [week => level]]
                        ];
                    }
                }
            }
        }

        return $rows;
    }

    // Laporan Perkembangan BK
    public function laporan(Request $request)
    {
        $classTerms = ClassTerm::with(['class', 'academicTerm'])->get()->map(fn($ct) => [
            'id'    => $ct->id,
            'label' => ($ct->class->name ?? '-') . ' — ' . ($ct->academicTerm->academic_year ?? '') . ' ' . ucfirst($ct->academicTerm->semester ?? ''),
        ])->toArray();

        $ctFilter   = $request->input('class_term_id');
        $weekFilter = $request->input('minggu');

        $lvMap = ['BB' => 1, 'MB' => 2, 'BSH' => 3, 'BSB' => 4];

        $query = ReportCounselingScore::with([
            'reportCounseling.report.studentEnrollment.student',
            'reportCounseling.report.studentEnrollment.classTerm.class',
            'reportCounseling.report.studentEnrollment.classTerm.academicTerm',
        ])->whereNotNull('week');

        if ($weekFilter) {
            $query->where('week', (int) $weekFilter);
        }

        $scores = $query->get();

        // Collect all distinct weeks for dropdown
        $weeksSet = [];
        foreach ($scores as $sc) {
            if ($sc->week) $weeksSet[(int) $sc->week] = true;
        }
        $allWeeks = array_keys($weeksSet);
        sort($allWeeks);

        // Group by (report_id, week) → one row per student per week
        $grouped = [];
        foreach ($scores as $sc) {
            $rc  = $sc->reportCounseling; if (!$rc) continue;
            $rep = $rc->report;            if (!$rep) continue;
            $enr = $rep->studentEnrollment; if (!$enr) continue;
            $ct  = $enr->classTerm;        if (!$ct) continue;

            if ($ctFilter && $ct->id !== $ctFilter) continue;

            $key = $rep->id . '__' . (int) $sc->week;
            if (!isset($grouped[$key])) {
                $grouped[$key] = [
                    'report_id'    => $rep->id,
                    'week'         => (int) $sc->week,
                    'student_name' => $enr->student->name ?? '-',
                    'kelas'        => $ct->class->name ?? '-',
                    'semester'     => trim(($ct->academicTerm->academic_year ?? '') . ' ' . ucfirst($ct->academicTerm->semester ?? '')),
                    'tanggal'      => $sc->date,
                    'sum'          => 0,
                    'cnt'          => 0,
                ];
            }
            $lv = $lvMap[$sc->level] ?? null;
            if ($lv) { $grouped[$key]['sum'] += $lv; $grouped[$key]['cnt']++; }
            if ($sc->date && !$grouped[$key]['tanggal']) {
                $grouped[$key]['tanggal'] = $sc->date;
            }
        }

        $laporan = [];
        foreach ($grouped as $item) {
            $tanggal = $item['tanggal'];
            $laporan[] = [
                'report_id'    => $item['report_id'],
                'week'         => $item['week'],
                'student_name' => $item['student_name'],
                'kelas'        => $item['kelas'],
                'semester'     => $item['semester'],
                'tanggal_label'=> $tanggal ? \Carbon\Carbon::parse($tanggal)->format('d M Y') : '-',
                'rata_rata'    => $item['cnt'] ? round($item['sum'] / $item['cnt'], 1) : 0,
            ];
        }

        usort($laporan, fn($a, $b) => strcmp($a['kelas'] . $a['student_name'], $b['kelas'] . $b['student_name']));

        return view('guru.laporan', [
            'laporan'    => $laporan,
            'classTerms' => $classTerms,
            'weeks'      => $allWeeks,
            'filters'    => ['class_term_id' => $ctFilter, 'minggu' => $weekFilter],
        ]);
    }

    public function laporanBkShow($id)
    {
        $week = (int) request()->input('week');

        $report = Report::with([
            'studentEnrollment.student',
            'studentEnrollment.classTerm.class',
            'studentEnrollment.classTerm.academicTerm',
            'studentEnrollment.classTerm.counselings.counseling.assessments',
            'counselings.scores',
            'counselings.counseling',
        ])->find($id);

        if (!$report || !$week) {
            return redirect()->route('guru.laporan_bk')->with('error', 'Laporan tidak ditemukan.');
        }

        $enr = $report->studentEnrollment;
        $ct  = $enr->classTerm;

        $LV_LABEL = ['BB' => 'Belum Berkembang', 'MB' => 'Mulai Berkembang', 'BSH' => 'Berkembang Sesuai Harapan', 'BSB' => 'Berkembang Sangat Baik'];
        $lvMap    = ['BB' => 1, 'MB' => 2, 'BSH' => 3, 'BSB' => 4];

        // Build score lookup: [assessment_id => level]
        $scoreLookup = [];
        $dateLabel   = null;
        foreach ($report->counselings as $rc) {
            foreach ($rc->scores->where('week', $week) as $sc) {
                $scoreLookup[$sc->counseling_assessment_id] = $sc->level;
                if (!$dateLabel && $sc->date) {
                    $dateLabel = \Carbon\Carbon::parse($sc->date)->format('d M Y');
                }
            }
        }

        $konselings = [];
        $totalSum = 0; $totalCnt = 0;

        foreach ($ct->counselings as $ctc) {
            $con   = $ctc->counseling;
            if (!$con) continue;
            $items = [];
            $sum = 0; $cnt = 0;
            foreach ($con->assessments as $ca) {
                $kode = $scoreLookup[$ca->id] ?? null;
                $lv   = $kode ? ($lvMap[$kode] ?? null) : null;
                if ($lv) { $sum += $lv; $cnt++; $totalSum += $lv; $totalCnt++; }
                $items[] = [
                    'nama'  => $ca->name,
                    'level' => $lv,
                    'kode'  => $kode ?? '-',
                    'label' => $kode ? ($LV_LABEL[$kode] ?? '-') : '-',
                ];
            }
            $konselings[] = ['nama' => $con->name, 'items' => $items, 'avg' => $cnt ? round($sum / $cnt, 2) : 0, 'count' => $cnt];
        }

        $laporan = [
            'id'            => $report->id,
            'week'          => $week,
            'siswa_nama'    => $enr->student->name ?? '-',
            'kelas'         => $ct->class->name ?? '-',
            'semester'      => trim(($ct->academicTerm->academic_year ?? '') . ' ' . ucfirst($ct->academicTerm->semester ?? '')),
            'minggu'        => $week,
            'tanggal_label' => $dateLabel ?? '-',
            'rata_rata'     => $totalCnt ? round($totalSum / $totalCnt, 2) : 0,
            'konselings'    => $konselings,
        ];

        return view('guru.laporan_detail', ['laporan' => $laporan]);
    }

    public function laporanBkEdit($id)
    {
        $week = (int) request()->input('week');

        $report = Report::with([
            'studentEnrollment.student',
            'studentEnrollment.classTerm.class',
            'studentEnrollment.classTerm.academicTerm',
            'studentEnrollment.classTerm.counselings.counseling.assessments',
            'counselings.scores',
            'counselings.counseling',
        ])->find($id);

        if (!$report || !$week) {
            return redirect()->route('guru.laporan_bk')->with('error', 'Laporan tidak ditemukan.');
        }

        $enr = $report->studentEnrollment;
        $ct  = $enr->classTerm;

        // Score lookup: [assessment_id => level]
        $scoreLookup = [];
        $tanggal     = null;
        foreach ($report->counselings as $rc) {
            foreach ($rc->scores->where('week', $week) as $sc) {
                $scoreLookup[$sc->counseling_assessment_id] = $sc->level;
                if (!$tanggal && $sc->date) {
                    $tanggal = \Carbon\Carbon::parse($sc->date)->format('Y-m-d');
                }
            }
        }

        $konselings = [];
        foreach ($ct->counselings as $ctc) {
            $con = $ctc->counseling;
            if (!$con) continue;
            $items = [];
            foreach ($con->assessments as $ca) {
                $items[] = ['id' => $ca->id, 'nama' => $ca->name, 'level' => $scoreLookup[$ca->id] ?? null];
            }
            $konselings[] = ['id' => $con->id, 'nama' => $con->name, 'items' => $items];
        }

        $laporan = [
            'id'          => $report->id,
            'week'        => $week,
            'siswa_nama'  => $enr->student->name ?? '-',
            'kelas'       => $ct->class->name ?? '-',
            'semester'    => trim(($ct->academicTerm->academic_year ?? '') . ' ' . ucfirst($ct->academicTerm->semester ?? '')),
            'minggu'      => $week,
            'tanggal'     => $tanggal ?? date('Y-m-d'),
            'konselings'  => $konselings,
        ];

        return view('guru.laporan_edit', ['laporan' => $laporan]);
    }

    public function laporanBkUpdate(Request $request, $id)
    {
        $request->validate([
            'week'    => 'required|integer|min:1|max:52',
            'tanggal' => 'required|date',
        ]);

        $report = Report::with([
            'counselings.scores',
            'counselings.counseling',
        ])->find($id);

        if (!$report) {
            return redirect()->route('guru.laporan_bk')->with('error', 'Laporan tidak ditemukan.');
        }

        $week    = (int) $request->week;
        $tanggal = $request->tanggal;

        foreach ($request->input('counseling', []) as $conId => $assessments) {
            $rc = $report->counselings->firstWhere('counseling_id', $conId);
            if (!$rc) continue;
            foreach ($assessments as $assessmentId => $level) {
                if (!$level) continue;
                $score = $rc->scores->where('counseling_assessment_id', $assessmentId)->where('week', $week)->first();
                if ($score) {
                    $score->update(['level' => $level, 'date' => $tanggal]);
                } else {
                    ReportCounselingScore::create([
                        'report_counseling_id'     => $rc->id,
                        'counseling_assessment_id' => $assessmentId,
                        'level'                    => $level,
                        'week'                     => $week,
                        'date'                     => $tanggal,
                    ]);
                }
            }
        }

        $studentName = $report->studentEnrollment?->student?->name ?? '-';
        Activity::log("mengedit laporan perkembangan minggu ke-{$week} untuk siswa {$studentName}");

        return redirect()->route('guru.laporan_bk')->with('success', 'Laporan perkembangan berhasil diperbarui.');
    }

    private function dummyGrafikDataset()
    {
        return [
            'semesters' => [
                ['id' => 'sm1', 'label' => '2025/2026 Ganjil'],
                ['id' => 'sm2', 'label' => '2024/2025 Genap'],
            ],
            'kelas' => [
                ['id' => 'A1', 'nama' => 'A1'],
                ['id' => 'A2', 'nama' => 'A2'],
                ['id' => 'B1', 'nama' => 'B1'],
                ['id' => 'B2', 'nama' => 'B2'],
            ],
            'siswaByKelas' => [
                'A1' => [
                    ['id' => 's1', 'nama' => 'Aulia Rahma'],
                    ['id' => 's2', 'nama' => 'Bima Saputra'],
                    ['id' => 's3', 'nama' => 'Citra Maharani'],
                ],
                'A2' => [
                    ['id' => 's4', 'nama' => 'Dimas Pratama'],
                    ['id' => 's5', 'nama' => 'Eka Putri'],
                    ['id' => 's6', 'nama' => 'Fadhil Hakim'],
                ],
                'B1' => [
                    ['id' => 's7',  'nama' => 'Gita Lestari'],
                    ['id' => 's8',  'nama' => 'Hafiz Ramadhan'],
                    ['id' => 's9',  'nama' => 'Indah Sari'],
                ],
                'B2' => [
                    ['id' => 's10', 'nama' => 'Jihan Aulia'],
                    ['id' => 's11', 'nama' => 'Kenzo Putra'],
                ],
            ],
            'konselings' => [
                [
                    'id' => 'con1', 'nama' => 'Perkembangan Sosial',
                    'assessments' => [
                        ['id' => 'ca1', 'nama' => 'Interaksi dengan teman'],
                        ['id' => 'ca2', 'nama' => 'Kemampuan berbagi'],
                        ['id' => 'ca3', 'nama' => 'Kepatuhan aturan'],
                    ],
                ],
                [
                    'id' => 'con2', 'nama' => 'Perkembangan Emosi',
                    'assessments' => [
                        ['id' => 'ca4', 'nama' => 'Mengelola emosi'],
                        ['id' => 'ca5', 'nama' => 'Empati terhadap teman'],
                    ],
                ],
                [
                    'id' => 'con3', 'nama' => 'Perkembangan Kognitif',
                    'assessments' => [
                        ['id' => 'ca6', 'nama' => 'Daya tangkap'],
                        ['id' => 'ca7', 'nama' => 'Kreativitas berpikir'],
                    ],
                ],
            ],
        ];
    }

    // Grafik Perkembangan
    public function grafik()
    {
        // ── 1. Load ClassTerms: semesters, kelas, siswa, counselings ───
        $ctModels = ClassTerm::with([
            'class',
            'academicTerm',
            'enrollments.student',
            'counselings.counseling.assessments',
        ])->get();

        $semesterMap       = [];
        $kelasMap          = [];
        $siswaByKelas      = [];
        $counselingMap     = [];
        $seenStudents      = [];
        $studentClassBySem = [];

        foreach ($ctModels as $ct) {
            $at    = $ct->academicTerm;
            $class = $ct->class;
            if (!$at || !$class) continue;

            if (!isset($semesterMap[$at->id])) {
                $semesterMap[$at->id] = [
                    'id'    => $at->id,
                    'label' => trim(($at->academic_year ?? '') . ' ' . ucfirst($at->semester ?? '')),
                ];
            }

            if (!isset($kelasMap[$class->id])) {
                $kelasMap[$class->id] = ['id' => $class->id, 'nama' => $class->name];
            }

            foreach ($ct->enrollments as $e) {
                $s = $e->student;
                if (!$s) continue;
                $uniq = $class->id . '|' . $s->id;
                if (!isset($seenStudents[$uniq])) {
                    $seenStudents[$uniq]        = true;
                    $siswaByKelas[$class->id][] = ['id' => $s->id, 'nama' => $s->name];
                }
                $studentClassBySem[$at->id][$s->id] = $class->id;
            }

            foreach ($ct->counselings as $ctc) {
                $con = $ctc->counseling;
                if (!$con || isset($counselingMap[$con->id])) continue;
                $counselingMap[$con->id] = [
                    'id'          => $con->id,
                    'nama'        => $con->name,
                    'assessments' => $con->assessments->map(fn($a) => [
                        'id'   => $a->id,
                        'nama' => $a->name,
                    ])->toArray(),
                ];
            }
        }

        $semesters  = array_values($semesterMap);
        $kelas      = array_values($kelasMap);
        $konselings = array_values($counselingMap);

        // ── 2. Load scores → raw[semId][studentId][assessmentId][week] ─
        $allScores = ReportCounselingScore::with([
            'reportCounseling.report.studentEnrollment.classTerm',
        ])->whereNotNull('week')->get();

        $lvMap    = ['BB' => 1, 'MB' => 2, 'BSH' => 3, 'BSB' => 4];
        $raw      = [];
        $weeksSet = [];

        foreach ($allScores as $score) {
            $rc  = $score->reportCounseling;
            if (!$rc) continue;
            $rep = $rc->report;
            if (!$rep) continue;
            $enr = $rep->studentEnrollment;
            if (!$enr) continue;
            $ct  = $enr->classTerm;
            if (!$ct) continue;

            $semId = $ct->academic_term_id;
            $sid   = $enr->student_id;
            $aId   = $score->counseling_assessment_id;
            $week  = (int) $score->week;
            $lv    = $lvMap[$score->level] ?? null;
            if (!$lv || !$week) continue;

            $raw[$semId][$sid][$aId][$week] = $lv;
            $weeksSet[$week]                = true;
        }

        $weeks = array_keys($weeksSet);
        sort($weeks);

        // ── 3. Aggregate byKelas and bySiswa ───────────────────────────
        $byKelas = [];
        $bySiswa = [];

        foreach ($raw as $semId => $byStudent) {
            foreach ($konselings as $con) {
                $conId = $con['id'];
                $aIds  = array_column($con['assessments'], 'id');
                if (empty($aIds)) continue;

                foreach ($byStudent as $sid => $byAssessment) {
                    foreach ($weeks as $w) {
                        $sum = 0; $cnt = 0;
                        foreach ($aIds as $aId) {
                            $val = $byAssessment[$aId][$w] ?? null;
                            if ($val !== null) { $sum += $val; $cnt++; }
                        }
                        if ($cnt > 0) {
                            $bySiswa[$semId][$conId][$sid][$w] = round($sum / $cnt, 2);
                        }
                    }
                }

                foreach ($kelas as $k) {
                    $kId = $k['id'];
                    foreach ($weeks as $w) {
                        $sum = 0; $cnt = 0;
                        foreach (($studentClassBySem[$semId] ?? []) as $sId => $cId) {
                            if ($cId !== $kId) continue;
                            foreach ($aIds as $aId) {
                                $val = $raw[$semId][$sId][$aId][$w] ?? null;
                                if ($val !== null) { $sum += $val; $cnt++; }
                            }
                        }
                        $byKelas[$semId][$conId][$kId][$w] = $cnt ? round($sum / $cnt, 2) : null;
                    }
                }
            }
        }

        $grafikPayload = [
            'semesters'    => $semesters,
            'kelas'        => $kelas,
            'siswaByKelas' => $siswaByKelas,
            'konselings'   => $konselings,
            'weeks'        => $weeks,
            'byKelas'      => $byKelas,
            'bySiswa'      => $bySiswa,
            'raw'          => $raw,
        ];

        return view('guru.grafik', compact('grafikPayload'));
    }

    // Input Perkembangan
    public function inputPerkembangan()
    {
        $ctModels = ClassTerm::with([
            'class', 'academicTerm',
            'enrollments.student',
            'counselings.counseling.assessments',
        ])->get();

        $classTerms = $ctModels->map(fn($ct) => [
            'id'           => $ct->id,
            'kelas_nama'   => $ct->class->name ?? '-',
            'tahun_ajaran' => $ct->academicTerm->academic_year ?? '-',
            'semester'     => $ct->academicTerm->semester ?? '-',
        ])->toArray();

        $daftarSiswa = [];
        foreach ($ctModels as $ct) {
            $ctLabel = "Kelas {$ct->class->name} - {$ct->academicTerm->academic_year} " . ucfirst($ct->academicTerm->semester ?? '');
            foreach ($ct->enrollments as $e) {
                $daftarSiswa[] = [
                    'id'               => $e->student->id,
                    'nama'             => $e->student->name,
                    'class_term_id'    => $ct->id,
                    'class_term_label' => $ctLabel,
                ];
            }
        }

        $counselingByCt = [];
        foreach ($ctModels as $ct) {
            $counselingByCt[$ct->id] = $ct->counselings->map(fn($ctc) => [
                'id'          => $ctc->counseling->id,
                'nama'        => $ctc->counseling->name,
                'assessments' => $ctc->counseling->assessments
                    ->map(fn($a) => ['id' => $a->id, 'nama' => $a->name])->toArray(),
            ])->toArray();
        }

        return view('guru.input_perkembangan', compact('daftarSiswa', 'classTerms', 'counselingByCt'));
    }

    public function storeInputPerkembangan(Request $request)
    {
        $request->validate([
            'class_term_id' => 'required|exists:class_term,id',
            'siswa_id'      => 'required|exists:student,id',
            'minggu_ke'     => 'required|integer|min:1|max:52',
            'tanggal'       => 'required|date',
        ]);

        $classTermId = $request->class_term_id;
        $studentId   = $request->siswa_id;
        $week        = (int) $request->minggu_ke;
        $date        = $request->tanggal;

        $enrollment = StudentEnrollment::where('class_term_id', $classTermId)
            ->where('student_id', $studentId)
            ->firstOrFail();

        $report = $enrollment->report
            ?? Report::create(['student_enrollment_id' => $enrollment->id]);

        // Block duplicate week for this student's report
        $alreadyExists = ReportCounselingScore::whereHas(
            'reportCounseling',
            fn($q) => $q->where('report_id', $report->id)
        )->where('week', $week)->exists();

        if ($alreadyExists) {
            return back()->withInput()
                ->withErrors(['minggu_ke' => "Penilaian untuk minggu ke-{$week} sudah ada untuk siswa ini."]);
        }

        $counselingInput = $request->input('counseling.' . $classTermId, []);

        foreach ($counselingInput as $assessmentId => $level) {
            if (!$level) continue;

            $assessment = CounselingAssessment::find($assessmentId);
            if (!$assessment) continue;

            $rc = ReportCounseling::firstOrCreate([
                'report_id'     => $report->id,
                'counseling_id' => $assessment->counseling_id,
            ]);

            ReportCounselingScore::create([
                'report_counseling_id'     => $rc->id,
                'counseling_assessment_id' => $assessmentId,
                'level'                    => $level,
                'week'                     => $week,
                'date'                     => $date,
            ]);
        }

        $studentName = Student::find($studentId)?->name ?? '-';
        Activity::log("membuat laporan perkembangan minggu ke-{$week} untuk siswa {$studentName}");

        return redirect()->route('guru.input_perkembangan')
            ->with('success', "Perkembangan minggu ke-{$week} berhasil disimpan.");
    }

    // Dashboard Guru
    public function dashboard(Request $request)
    {
        $now = now();

        // Class terms untuk selector
        $classTerms = ClassTerm::with(['class', 'academicTerm'])
            ->orderByDesc('created_at')
            ->get();

        // Default: class term yang isPass = false (sedang berjalan), fallback ke terbaru
        $defaultClassTermId = ClassTerm::whereHas('academicTerm')
            ->where('isPass', false)
            ->orderByDesc('created_at')
            ->value('id');

        $selectedClassTermId = $request->input('class_term_id', $defaultClassTermId);
        $selectedClassTerm   = $classTerms->firstWhere('id', $selectedClassTermId);

        // Total siswa di class term terpilih
        $enrollmentIds = StudentEnrollment::where('class_term_id', $selectedClassTermId)
            ->pluck('id');
        $totalSiswa = $enrollmentIds->count();

        // Hadir hari ini
        $hadirHariIni = Presence::whereIn('student_class_id', $enrollmentIds)
            ->where('date', $now->toDateString())
            ->whereIn('attendance', ['hadir', 'izin']) // hadir = masuk
            ->count();

        // Konseling bulan ini: milik guru yang login, bulan ini, disetujui
        $konselingBulanIni = PrivateCounselingSchedule::where('teacher_id', auth()->id())
            ->whereYear('date', $now->year)
            ->whereMonth('date', $now->month)
            ->where('status', 'approved')
            ->count();

        // Konseling menunggu persetujuan
        $konselingPending = PrivateCounselingSchedule::where('teacher_id', auth()->id())
            ->where('status', 'pending')
            ->count();

        // Jadwal kegiatan bulan ini (count)
        $jadwalKegiatanCount = ActivitySchedule::whereYear('date', $now->year)
            ->whereMonth('date', $now->month)
            ->count();

        // List jadwal kegiatan bulan ini
        $jadwalKegiatan = ActivitySchedule::with('classTerm.class')
            ->whereYear('date', $now->year)
            ->whereMonth('date', $now->month)
            ->orderBy('date')
            ->orderBy('start_hour')
            ->get()
            ->map(fn($a) => [
                'tanggal'   => \Carbon\Carbon::parse($a->date)->translatedFormat('l, j F Y'),
                'waktu'     => substr($a->start_hour, 0, 5) . ' - ' . substr($a->end_hour, 0, 5) . ' WIB',
                'topik'     => $a->name,
                'lokasi'    => $a->location,
            ]);

        // List jadwal konseling bulan ini
        $jadwalKonselingMendatang = PrivateCounselingSchedule::with(['student', 'teacher'])
            ->whereYear('date', $now->year)
            ->whereMonth('date', $now->month)
            ->whereNotIn('status', ['canceled', 'rejected'])
            ->orderBy('date')
            ->orderBy('start_hour')
            ->get()
            ->map(fn($s) => [
                'tanggal' => \Carbon\Carbon::parse($s->date)->translatedFormat('l, j F Y'),
                'waktu'   => substr($s->start_hour, 0, 5) . ' - ' . substr($s->end_hour, 0, 5) . ' WIB',
                'topik'   => $s->topic,
                'siswa'   => $s->student?->name ?? '-',
                'status'  => $s->status,
            ]);

        // Label hero
        $ct = $selectedClassTerm;
        $heroSub = $ct
            ? ($ct->academicTerm?->academic_year ?? '') . ' ' . ucfirst($ct->academicTerm?->semester ?? '') . ' &middot; Kelas ' . ($ct->class?->name ?? '')
            : 'Pilih Kelas Term';

        return view('guru.dashboard', compact(
            'classTerms', 'selectedClassTermId', 'selectedClassTerm',
            'totalSiswa', 'hadirHariIni',
            'konselingBulanIni', 'konselingPending', 'jadwalKegiatanCount',
            'jadwalKegiatan', 'jadwalKonselingMendatang',
            'heroSub'
        ));
    }

    // Kehadiran Siswa
    public function kehadiranIndex(Request $request)
    {
        $classTerms = ClassTerm::with(['class', 'academicTerm'])
            ->orderBy('created_at', 'desc')
            ->get();

        $selectedClassTermId = $request->input('class_term_id');
        $tanggal             = $request->input('tanggal', date('Y-m-d'));
        $selectedClassTerm   = null;
        $enrollments         = collect();
        $existingPresences   = collect();
        $kehadiranList       = collect();

        if ($selectedClassTermId) {
            $selectedClassTerm = ClassTerm::with(['class', 'academicTerm'])->find($selectedClassTermId);

            $enrollments = StudentEnrollment::with('student')
                ->where('class_term_id', $selectedClassTermId)
                ->orderBy('created_at')
                ->get();

            $existingPresences = Presence::whereIn('student_class_id', $enrollments->pluck('id'))
                ->where('date', $tanggal)
                ->get()
                ->keyBy('student_class_id');

            $kehadiranList = Presence::whereIn('student_class_id', $enrollments->pluck('id'))
                ->where('date', $tanggal)
                ->with('studentEnrollment.student')
                ->orderBy('created_at')
                ->get();
        }

        return view('guru.kehadiran.index', compact(
            'classTerms', 'selectedClassTermId', 'selectedClassTerm',
            'tanggal', 'enrollments', 'existingPresences', 'kehadiranList'
        ));
    }

    public function kehadiranStore(Request $request)
    {
        $request->validate([
            'class_term_id' => 'required|exists:class_term,id',
            'tanggal'       => 'required|date',
            'attendance'    => 'required|array',
        ]);

        foreach ($request->attendance as $enrollmentId => $value) {
            Presence::updateOrCreate(
                ['student_class_id' => $enrollmentId, 'date' => $request->tanggal],
                [
                    'attendance'  => $value,
                    'description' => $request->input("description.{$enrollmentId}"),
                ]
            );
        }

        $ct = ClassTerm::with('class', 'academicTerm')->find($request->class_term_id);
        $label = $ct ? ('kelas ' . ($ct->class?->name ?? '-')) : 'kelas';
        Activity::log("mencatat presensi {$label} untuk tanggal {$request->tanggal}");

        return redirect()->route('guru.kehadiran.index', [
            'class_term_id' => $request->class_term_id,
            'tanggal'       => $request->tanggal,
        ])->with('success', 'Kehadiran berhasil disimpan.');
    }

    public function kehadiranEdit($id)
    {
        $presence = Presence::with('studentEnrollment.student', 'studentEnrollment.classTerm.class', 'studentEnrollment.classTerm.academicTerm')
            ->findOrFail($id);

        return view('guru.kehadiran.edit', compact('presence'));
    }

    public function kehadiranUpdate(Request $request, $id)
    {
        $presence = Presence::findOrFail($id);

        $request->validate([
            'attendance'  => 'required|in:hadir,izin,sakit,alpa',
            'description' => 'nullable|string|max:255',
        ]);

        $presence->update([
            'attendance'  => $request->attendance,
            'description' => $request->description,
        ]);

        $classTermId = $presence->studentEnrollment->class_term_id;

        return redirect()->route('guru.kehadiran.index', [
            'class_term_id' => $classTermId,
            'tanggal'       => $presence->date->format('Y-m-d'),
        ])->with('success', 'Kehadiran berhasil diperbarui.');
    }

    // Laporan Administrasi
    public function laporanIndex(Request $request)
    {
        // Dummy data siswa
        $siswaList = [
            ['id' => 1, 'nama' => 'Ahmad Fauzi'],
            ['id' => 2, 'nama' => 'Siti Nurhaliza'],
            ['id' => 3, 'nama' => 'Budi Santoso'],
            ['id' => 4, 'nama' => 'Dewi Lestari'],
            ['id' => 5, 'nama' => 'Eko Prasetyo'],
        ];

        // Dummy data laporan
        $laporanList = [
            ['id' => 1, 'judul' => 'Laporan Kehadiran TK A', 'jenis' => 'Kehadiran', 'periode' => '1 - 28 Feb 2026', 'tanggal' => '01 Mar 2026', 'status' => 'generated'],
            ['id' => 2, 'judul' => 'Laporan Perkembangan Ahmad Fauzi', 'jenis' => 'Perkembangan', 'periode' => 'Feb 2026', 'tanggal' => '28 Feb 2026', 'status' => 'generated'],
            ['id' => 3, 'judul' => 'Laporan Bulanan TK B', 'jenis' => 'Bulanan', 'periode' => 'Feb 2026', 'tanggal' => '28 Feb 2026', 'status' => 'generated'],
            ['id' => 4, 'judul' => 'Laporan Kehadiran TK B', 'jenis' => 'Kehadiran', 'periode' => '1 - 4 Mar 2026', 'tanggal' => '04 Mar 2026', 'status' => 'pending'],
            ['id' => 5, 'judul' => 'Laporan Perkembangan Siti', 'jenis' => 'Perkembangan', 'periode' => 'Mar 2026', 'tanggal' => '03 Mar 2026', 'status' => 'draft'],
        ];

        return view('guru.laporan.index', compact('siswaList', 'laporanList'));
    }

    public function laporanGenerate(Request $request)
    {
        // Dummy - redirect with success
        return redirect()->route('guru.laporan.index')->with('success', 'Laporan berhasil di-generate.');
    }

    // Kelola Jadwal
    public function jadwalIndex(Request $request)
    {
        $classTerms          = ClassTerm::with(['class', 'academicTerm'])->orderBy('created_at', 'desc')->get();
        $selectedClassTermId = $request->input('class_term_id');
        $selectedClassTerm   = null;
        $jadwalKegiatan      = collect();
        $jadwalPembelajaran  = collect();

        $hariMap = [1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat'];

        if ($selectedClassTermId) {
            $selectedClassTerm = ClassTerm::with(['class', 'academicTerm'])->find($selectedClassTermId);

            $jadwalKegiatan = ActivitySchedule::where('class_term_id', $selectedClassTermId)
                ->orderBy('date')
                ->get();

            $jadwalPembelajaran = ClassSchedule::where('class_term_id', $selectedClassTermId)
                ->orderBy('day')
                ->orderBy('start_hour')
                ->get()
                ->groupBy('day');
        }

        return view('guru.jadwal.index', compact(
            'classTerms', 'selectedClassTermId', 'selectedClassTerm',
            'jadwalKegiatan', 'jadwalPembelajaran', 'hariMap'
        ));
    }

    public function jadwalCreate()
    {
        $classTerms = ClassTerm::with(['class', 'academicTerm'])->orderBy('created_at', 'desc')->get();
        return view('guru.jadwal.create', compact('classTerms'));
    }

    public function jadwalStore(Request $request)
    {
        if ($request->jenis_jadwal === 'kegiatan') {
            $request->validate([
                'class_term_id' => 'required|exists:class_term,id',
                'nama'          => 'required|string|max:255',
                'tanggal'       => 'required|date',
                'start_hour'    => 'nullable|date_format:H:i',
                'end_hour'      => 'nullable|date_format:H:i',
                'lokasi'        => 'nullable|string|max:255',
                'deskripsi'     => 'nullable|string',
            ]);
            ActivitySchedule::create([
                'class_term_id' => $request->class_term_id,
                'name'          => $request->nama,
                'date'          => $request->tanggal,
                'start_hour'    => $request->start_hour ?: null,
                'end_hour'      => $request->end_hour ?: null,
                'location'      => $request->lokasi,
                'description'   => $request->deskripsi,
            ]);
        } else {
            $request->validate([
                'class_term_id' => 'required|exists:class_term,id',
                'nama'          => 'required|string|max:255',
                'day'           => 'required|integer|between:1,5',
                'start_hour'    => 'required|date_format:H:i',
                'end_hour'      => 'nullable|date_format:H:i',
            ]);
            ClassSchedule::create([
                'class_term_id' => $request->class_term_id,
                'name'          => $request->nama,
                'day'           => $request->day,
                'start_hour'    => $request->start_hour,
                'end_hour'      => $request->end_hour,
            ]);
        }

        $jenisLabel = $request->jenis_jadwal === 'kegiatan' ? 'kegiatan' : 'pembelajaran';
        Activity::log("membuat jadwal {$jenisLabel}: {$request->nama}");

        return redirect()->route('guru.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function jadwalEdit(Request $request, $id)
    {
        $jenis      = $request->query('jenis', 'kegiatan');
        $classTerms = ClassTerm::with(['class', 'academicTerm'])->orderBy('created_at', 'desc')->get();

        if ($jenis === 'pembelajaran') {
            $jadwal = ClassSchedule::findOrFail($id);
        } else {
            $jadwal = ActivitySchedule::findOrFail($id);
        }

        return view('guru.jadwal.edit', compact('jadwal', 'classTerms', 'jenis'));
    }

    public function jadwalUpdate(Request $request, $id)
    {
        $jenis = $request->input('jenis_jadwal', 'kegiatan');

        if ($jenis === 'kegiatan') {
            $request->validate([
                'class_term_id' => 'required|exists:class_term,id',
                'nama'          => 'required|string|max:255',
                'tanggal'       => 'required|date',
                'start_hour'    => 'nullable|date_format:H:i',
                'end_hour'      => 'nullable|date_format:H:i',
                'lokasi'        => 'nullable|string|max:255',
                'deskripsi'     => 'nullable|string',
            ]);
            ActivitySchedule::findOrFail($id)->update([
                'class_term_id' => $request->class_term_id,
                'name'          => $request->nama,
                'date'          => $request->tanggal,
                'start_hour'    => $request->start_hour ?: null,
                'end_hour'      => $request->end_hour ?: null,
                'location'      => $request->lokasi,
                'description'   => $request->deskripsi,
            ]);
        } else {
            $request->validate([
                'class_term_id' => 'required|exists:class_term,id',
                'nama'          => 'required|string|max:255',
                'day'           => 'required|integer|between:1,5',
                'start_hour'    => 'required|date_format:H:i',
                'end_hour'      => 'nullable|date_format:H:i',
            ]);
            ClassSchedule::findOrFail($id)->update([
                'class_term_id' => $request->class_term_id,
                'name'          => $request->nama,
                'day'           => $request->day,
                'start_hour'    => $request->start_hour,
                'end_hour'      => $request->end_hour,
            ]);
        }

        $jenisLabel = $jenis === 'kegiatan' ? 'kegiatan' : 'pembelajaran';
        Activity::log("mengedit jadwal {$jenisLabel}: {$request->nama}");

        return redirect()->route('guru.jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function jadwalDestroy(Request $request, $id)
    {
        $activity = ActivitySchedule::find($id);
        if ($activity) {
            $namaJadwal = $activity->name ?? '-';
            $activity->delete();
            Activity::log("menghapus jadwal kegiatan: {$namaJadwal}");
        } else {
            $cs = ClassSchedule::findOrFail($id);
            $namaJadwal = $cs->name ?? '-';
            $cs->delete();
            Activity::log("menghapus jadwal pembelajaran: {$namaJadwal}");
        }
        $classTermId = $request->input('class_term_id');
        return redirect()->route('guru.jadwal.index', $classTermId ? ['class_term_id' => $classTermId] : [])
            ->with('success', 'Jadwal berhasil dihapus.');
    }

    // Rapot Semester
    public function rapotIndex()
    {
        $classTerms = ClassTerm::with(['class', 'academicTerm', 'enrollments.report'])->get();

        $grouped = $classTerms->map(function ($ct) {
            $total      = $ct->enrollments->count();
            $sudahRapot = $ct->enrollments->filter(fn($e) => $e->report !== null)->count();
            return [
                'id'           => $ct->id,
                'kelas_nama'   => $ct->class->name ?? '-',
                'tahun_ajaran' => $ct->academicTerm->academic_year ?? '-',
                'semester'     => $ct->academicTerm->semester ?? '-',
                'status'       => $ct->isPass ? 'selesai' : ($ct->academicTerm->status ?? 'aktif'),
                'total_siswa'  => $total,
                'sudah_rapot'  => $sudahRapot,
            ];
        })->groupBy('tahun_ajaran');

        return view('guru.rapot.index', compact('grouped'));
    }

    public function rapotShow($classTermId)
    {
        $ct = ClassTerm::with(['class', 'academicTerm'])->findOrFail($classTermId);

        $enrollments = StudentEnrollment::with(['student', 'report'])
            ->where('class_term_id', $classTermId)->get();

        $classTerm = [
            'id'           => $ct->id,
            'kelas_nama'   => $ct->class->name ?? '-',
            'tahun_ajaran' => $ct->academicTerm->academic_year ?? '-',
            'semester'     => $ct->academicTerm->semester ?? '-',
        ];

        $students = $enrollments->map(fn($e) => [
            'id'            => $e->student->id,
            'nama'          => $e->student->name,
            'nis'           => $e->student->nis ?? '-',
            'jenis_kelamin' => $e->student->gender ?? 'L',
            'has_report'    => $e->report !== null,
        ])->values();

        $total      = $students->count();
        $sudahRapot = $students->where('has_report', true)->count();

        return view('guru.rapot.show', compact('classTerm', 'students', 'sudahRapot', 'total'));
    }

    public function rapotSiswaForm($classTermId, $studentId)
    {
        $ct         = ClassTerm::with(['class', 'academicTerm'])->findOrFail($classTermId);
        $student    = Student::findOrFail($studentId);
        $enrollment = StudentEnrollment::where('class_term_id', $classTermId)
                        ->where('student_id', $studentId)->firstOrFail();
        $report     = $enrollment->report;

        $classTerm = [
            'id'           => $ct->id,
            'kelas_nama'   => $ct->class->name ?? '-',
            'tahun_ajaran' => $ct->academicTerm->academic_year ?? '-',
            'semester'     => $ct->academicTerm->semester ?? '-',
        ];

        $studentArr = [
            'id'   => $student->id,
            'nama' => $student->name,
            'nis'  => $student->nis ?? '-',
        ];

        $subjects = ClassTermSubject::with('subject')
            ->where('class_term_id', $classTermId)->get()
            ->map(fn($cts) => ['id' => $cts->subject->id, 'nama' => $cts->subject->name])
            ->values()->toArray();

        $extracurriculars = ClassTermExtracurricular::with(['extracurricular.assessments'])
            ->where('class_term_id', $classTermId)->get()
            ->map(fn($cte) => [
                'id'          => $cte->extracurricular->id,
                'nama'        => $cte->extracurricular->name,
                'assessments' => $cte->extracurricular->assessments
                    ->map(fn($a) => ['id' => $a->id, 'nama' => $a->name])->toArray(),
            ])->values()->toArray();

        $counselings = ClassTermCounseling::with(['counseling.assessments'])
            ->where('class_term_id', $classTermId)->get()
            ->map(fn($ctc) => [
                'id'          => $ctc->counseling->id,
                'nama'        => $ctc->counseling->name,
                'assessments' => $ctc->counseling->assessments
                    ->map(fn($a) => ['id' => $a->id, 'nama' => $a->name])->toArray(),
            ])->values()->toArray();

        $scores = ['subjects' => [], 'extracurriculars' => [], 'counselings' => []];
        if ($report) {
            $report->load(['subjects.images', 'extracurriculars.scores', 'counselings.scores']);

            foreach ($report->subjects as $rs) {
                $img = $rs->images->first();
                $scores['subjects'][$rs->subject_id] = [
                    'deskripsi' => $rs->description ?? '',
                    'foto'      => $img ? asset('storage/' . $img->description) : null,
                ];
            }
            foreach ($report->extracurriculars as $re) {
                foreach ($re->scores as $res) {
                    $scores['extracurriculars'][$res->extracurricular_assessment_id] = $res->level;
                }
            }
            foreach ($report->counselings as $rc) {
                foreach ($rc->scores as $rcs) {
                    $scores['counselings'][$rcs->counseling_assessment_id] = $rcs->level;
                }
            }
        }

        return view('guru.rapot.siswa', [
            'classTerm'        => $classTerm,
            'student'          => $studentArr,
            'hasReport'        => $report !== null,
            'subjects'         => $subjects,
            'extracurriculars' => $extracurriculars,
            'counselings'      => $counselings,
            'scores'           => $scores,
        ]);
    }

    public function rapotSiswaSave(Request $request, $classTermId, $studentId)
    {
        $enrollment = StudentEnrollment::where('class_term_id', $classTermId)
            ->where('student_id', $studentId)->firstOrFail();

        $report = $enrollment->report
            ?? Report::create(['student_enrollment_id' => $enrollment->id]);

        foreach ($request->input('subjects', []) as $subjectId => $data) {
            $rs = ReportSubject::firstOrNew(['report_id' => $report->id, 'subject_id' => $subjectId]);
            $rs->description = $data['deskripsi'] ?? '';
            $rs->save();

            if ($request->hasFile("subjects.{$subjectId}.foto")) {
                $file = $request->file("subjects.{$subjectId}.foto");
                if ($file && $file->isValid()) {
                    $path = $file->store('rapot-foto', 'public');
                    ReportSubjectImage::updateOrCreate(
                        ['report_subject_id' => $rs->id],
                        ['description'       => $path]
                    );
                }
            }
        }

        foreach ($request->input('extracurriculars', []) as $assessmentId => $level) {
            if (!$level) continue;
            $assessment = ExtracurricularAssessment::find($assessmentId);
            if (!$assessment) continue;

            $re = ReportExtracurricular::firstOrCreate([
                'report_id'          => $report->id,
                'extracurricular_id' => $assessment->extracurricular_id,
            ]);

            ReportExtracurricularScore::updateOrCreate(
                [
                    'report_extracurricular_id'     => $re->id,
                    'extracurricular_assessment_id' => $assessmentId,
                ],
                ['level' => $level]
            );
        }

        foreach ($request->input('counselings', []) as $assessmentId => $level) {
            if (!$level) continue;
            $assessment = CounselingAssessment::find($assessmentId);
            if (!$assessment) continue;

            $rc = ReportCounseling::firstOrCreate([
                'report_id'     => $report->id,
                'counseling_id' => $assessment->counseling_id,
            ]);

            ReportCounselingScore::updateOrCreate(
                [
                    'report_counseling_id'     => $rc->id,
                    'counseling_assessment_id' => $assessmentId,
                ],
                ['level' => $level]
            );
        }

        $studentName = Student::find($studentId)?->name ?? '-';
        $verb = $report->wasRecentlyCreated ? 'menginput' : 'mengedit';
        Activity::log("{$verb} rapot untuk siswa {$studentName}");

        return redirect()->route('guru.rapot.show', $classTermId)
            ->with('success', 'Nilai rapot berhasil disimpan.');
    }

    public function rapotCreate()
    {
        return redirect()->route('guru.rapot.index');
    }

    public function rapotStore(Request $request)
    {
        return redirect()->route('guru.rapot.index');
    }

    public function rapotEdit($id)
    {
        return redirect()->route('guru.rapot.show', $id);
    }

    public function rapotUpdate(Request $request, $id)
    {
        return redirect()->route('guru.rapot.index');
    }

    public function rapotDestroy($id)
    {
        return redirect()->route('guru.rapot.index');
    }
}