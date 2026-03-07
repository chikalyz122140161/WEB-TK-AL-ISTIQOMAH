<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\Registration;
use App\Models\SemesterReport;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class OrangTuaController extends Controller
{
    public function dashboard()
    {
        return view('orangtua.dashboard');
    }

    public function presensi(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $students = Student::where('parent_id', Auth::id())->get();
        $student = $students->first();

        $presensiData = ['hadir' => 0, 'izin' => 0, 'sakit' => 0, 'alpa' => 0];
        $detailPresensi = [];

        if ($student) {
            $attendances = Attendance::where('student_id', $student->id)
                ->whereMonth('date', $bulan)
                ->whereYear('date', $tahun)
                ->orderBy('date', 'asc')
                ->get();

            foreach ($attendances as $att) {
                $status = strtolower($att->status);
                if (isset($presensiData[$status])) {
                    $presensiData[$status]++;
                }
                $detailPresensi[] = [
                    'tanggal' => \Carbon\Carbon::parse($att->date)->format('d M Y'),
                    'hari' => \Carbon\Carbon::parse($att->date)->translatedFormat('l'),
                    'status' => $status,
                    'keterangan' => $att->note ?? '-',
                ];
            }
        }

        return view('orangtua.presensi', compact('student', 'presensiData', 'detailPresensi'));
    }

    public function laporan(Request $request)
    {
        $students = Student::where('parent_id', Auth::id())->get();
        $student = $students->first();

        $laporanList = [];

        if ($student) {
            $reports = Report::where('student_id', $student->id)
                ->orderBy('week_start', 'desc')
                ->get();

            foreach ($reports as $index => $report) {
                $weekStart = \Carbon\Carbon::parse($report->week_start);
                $weekEnd = $weekStart->copy()->endOfWeek();
                $weekNum = $weekStart->weekOfMonth;

                $laporanList[] = [
                    'id' => $report->id,
                    'minggu' => "Minggu {$weekNum} ({$weekStart->format('d')}-{$weekEnd->format('d M Y')})",
                    'kognitif' => $report->cognitive,
                    'motorik' => $report->motoric,
                    'sosial' => $report->social,
                    'bahasa' => $report->language,
                ];
            }
        }

        return view('orangtua.laporan', compact('student', 'laporanList'));
    }

    public function laporanDetail($id)
    {
        $report = Report::with(['student', 'teacher'])->findOrFail($id);
        $student = $report->student;
        $teacher = $report->teacher;

        return view('orangtua.laporan_detail', compact('report', 'student', 'teacher'));
    }

    // ═══════════════════════════════════════════════════════
    // JADWAL (dengan sub-fitur)
    // ═══════════════════════════════════════════════════════
    
    public function jadwal(Request $request)
    {
        // Redirect ke halaman jadwal pembelajaran sebagai default
        return redirect()->route('orangtua.jadwal.pembelajaran');
    }
    
    public function jadwalPembelajaran(Request $request)
    {
        $students = Student::where('parent_id', Auth::id())->get();
        $student = $students->first();
        $kelas = $student ? ($student->class ?? 'TK A') : 'TK A';
        
        // Jadwal pembelajaran harian (dummy data - bisa diganti dengan data dari database)
        $jadwalPembelajaran = [
            'Senin' => [
                ['waktu' => '07:30 - 08:00', 'kegiatan' => 'Upacara & Senam Pagi', 'keterangan' => 'Lapangan'],
                ['waktu' => '08:00 - 08:30', 'kegiatan' => 'Berdoa & Muroja\'ah', 'keterangan' => 'Kelas'],
                ['waktu' => '08:30 - 09:30', 'kegiatan' => 'Kegiatan Inti 1', 'keterangan' => 'Tema: Keluargaku'],
                ['waktu' => '09:30 - 10:00', 'kegiatan' => 'Istirahat & Snack', 'keterangan' => '-'],
                ['waktu' => '10:00 - 11:00', 'kegiatan' => 'Kegiatan Inti 2', 'keterangan' => 'Mewarnai'],
                ['waktu' => '11:00 - 11:30', 'kegiatan' => 'Pulang', 'keterangan' => '-'],
            ],
            'Selasa' => [
                ['waktu' => '07:30 - 08:00', 'kegiatan' => 'Senam Pagi', 'keterangan' => 'Lapangan'],
                ['waktu' => '08:00 - 08:30', 'kegiatan' => 'Berdoa & Muroja\'ah', 'keterangan' => 'Kelas'],
                ['waktu' => '08:30 - 09:30', 'kegiatan' => 'Kegiatan Inti 1', 'keterangan' => 'Mengenal Angka'],
                ['waktu' => '09:30 - 10:00', 'kegiatan' => 'Istirahat & Snack', 'keterangan' => '-'],
                ['waktu' => '10:00 - 11:00', 'kegiatan' => 'Kegiatan Inti 2', 'keterangan' => 'Bermain Balok'],
                ['waktu' => '11:00 - 11:30', 'kegiatan' => 'Pulang', 'keterangan' => '-'],
            ],
            'Rabu' => [
                ['waktu' => '07:30 - 08:00', 'kegiatan' => 'Senam Pagi', 'keterangan' => 'Lapangan'],
                ['waktu' => '08:00 - 08:30', 'kegiatan' => 'Berdoa & Muroja\'ah', 'keterangan' => 'Kelas'],
                ['waktu' => '08:30 - 09:30', 'kegiatan' => 'Kegiatan Inti 1', 'keterangan' => 'Mengenal Huruf'],
                ['waktu' => '09:30 - 10:00', 'kegiatan' => 'Istirahat & Snack', 'keterangan' => '-'],
                ['waktu' => '10:00 - 11:00', 'kegiatan' => 'Kegiatan Inti 2', 'keterangan' => 'Prakarya'],
                ['waktu' => '11:00 - 11:30', 'kegiatan' => 'Pulang', 'keterangan' => '-'],
            ],
            'Kamis' => [
                ['waktu' => '07:30 - 08:00', 'kegiatan' => 'Senam Pagi', 'keterangan' => 'Lapangan'],
                ['waktu' => '08:00 - 08:30', 'kegiatan' => 'Berdoa & Muroja\'ah', 'keterangan' => 'Kelas'],
                ['waktu' => '08:30 - 09:30', 'kegiatan' => 'Kegiatan Inti 1', 'keterangan' => 'Seni & Musik'],
                ['waktu' => '09:30 - 10:00', 'kegiatan' => 'Istirahat & Snack', 'keterangan' => '-'],
                ['waktu' => '10:00 - 11:00', 'kegiatan' => 'Kegiatan Inti 2', 'keterangan' => 'Motorik Halus'],
                ['waktu' => '11:00 - 11:30', 'kegiatan' => 'Pulang', 'keterangan' => '-'],
            ],
            'Jumat' => [
                ['waktu' => '07:30 - 08:00', 'kegiatan' => 'Senam Pagi', 'keterangan' => 'Lapangan'],
                ['waktu' => '08:00 - 08:30', 'kegiatan' => 'Berdoa & Sholat Dhuha', 'keterangan' => 'Mushola'],
                ['waktu' => '08:30 - 09:30', 'kegiatan' => 'Kegiatan Inti', 'keterangan' => 'Praktik Ibadah'],
                ['waktu' => '09:30 - 10:00', 'kegiatan' => 'Istirahat & Snack', 'keterangan' => '-'],
                ['waktu' => '10:00 - 10:30', 'kegiatan' => 'Pulang', 'keterangan' => '-'],
            ],
        ];
        
        $activeTab = 'pembelajaran';
        
        return view('orangtua.jadwal', compact('jadwalPembelajaran', 'student', 'kelas', 'activeTab'));
    }
    
    public function jadwalKegiatan(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $students = Student::where('parent_id', Auth::id())->get();
        $student = $students->first();
        $studentIds = $students->pluck('id');

        // Ambil jadwal kegiatan dari database
        $schedules = Schedule::whereIn('student_id', $studentIds)
            ->whereMonth('date', $bulan)
            ->whereYear('date', $tahun)
            ->where('type', 'kegiatan')
            ->orderBy('date', 'asc')
            ->get();

        $jadwalKegiatan = [];
        foreach ($schedules as $schedule) {
            $date = \Carbon\Carbon::parse($schedule->date);
            $jadwalKegiatan[] = [
                'nama' => $schedule->description,
                'tanggal' => $date->translatedFormat('l, d F Y'),
                'waktu' => $schedule->time ?? '07:00 - Selesai',
                'tempat' => $schedule->location ?? 'TK Al-Istiqomah',
                'kelas' => $schedule->class ?? 'Semua Kelas',
            ];
        }
        
        // Dummy data jika belum ada data
        if (empty($jadwalKegiatan)) {
            $jadwalKegiatan = [
                [
                    'nama' => 'Upacara Bendera',
                    'tanggal' => 'Senin, 16 Maret 2026',
                    'waktu' => '07:00 - 09:00',
                    'tempat' => 'Lapangan',
                    'kelas' => 'Semua Kelas',
                ],
                [
                    'nama' => 'Outing Class ke Kebun Binatang',
                    'tanggal' => 'Sabtu, 21 Maret 2026',
                    'waktu' => '08:00 - 12:00',
                    'tempat' => 'Kebun Binatang',
                    'kelas' => 'TK A & TK B',
                ],
                [
                    'nama' => 'Lomba Mewarnai',
                    'tanggal' => 'Kamis, 26 Maret 2026',
                    'waktu' => '09:00 - 11:00',
                    'tempat' => 'Aula TK',
                    'kelas' => 'TK A & TK B',
                ],
                [
                    'nama' => 'Pentas Seni Akhir Bulan',
                    'tanggal' => 'Sabtu, 28 Maret 2026',
                    'waktu' => '08:00 - 11:00',
                    'tempat' => 'Aula TK',
                    'kelas' => 'Semua Kelas',
                ],
            ];
        }
        
        $activeTab = 'kegiatan';
        
        return view('orangtua.jadwal', compact('jadwalKegiatan', 'student', 'bulan', 'tahun', 'activeTab'));
    }


    // ═══════════════════════════════════════════════════════
    // RAPOT SEMESTER
    // ═══════════════════════════════════════════════════════
    
    public function rapot(Request $request)
    {
        $students = Student::where('parent_id', Auth::id())->get();
        $student = $students->first();

        $rapotList = [];

        if ($student) {
            $rapots = SemesterReport::where('student_id', $student->id)
                ->orderBy('tahun_ajaran', 'desc')
                ->orderBy('semester', 'desc')
                ->get();

            foreach ($rapots as $rapot) {
                $rapotList[] = [
                    'id' => $rapot->id,
                    'tahun_ajaran' => $rapot->tahun_ajaran,
                    'semester' => $rapot->semester,
                    'kelas' => $rapot->kelas,
                    'tanggal_terbit' => $rapot->tanggal_terbit ? $rapot->tanggal_terbit->format('d M Y') : '-',
                ];
            }
        }

        return view('orangtua.rapot', compact('student', 'rapotList'));
    }
    
    public function rapotDetail($id)
    {
        $rapot = SemesterReport::with(['student', 'teacher'])->findOrFail($id);
        $student = $rapot->student;
        $teacher = $rapot->teacher;

        // Verifikasi bahwa rapot ini milik anak dari orangtua yang login
        if ($student->parent_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('orangtua.rapot_detail', compact('rapot', 'student', 'teacher'));
    }
    
    public function rapotDownload($id)
    {
        $rapot = SemesterReport::with(['student', 'teacher'])->findOrFail($id);
        $student = $rapot->student;
        $teacher = $rapot->teacher;

        // Verifikasi bahwa rapot ini milik anak dari orangtua yang login
        if ($student->parent_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $pdf = Pdf::loadView('orangtua.rapot_pdf', compact('rapot', 'student', 'teacher'));
        $pdf->setPaper('a4', 'portrait');
        
        $filename = 'Rapot_' . $student->name . '_' . $rapot->semester . '_' . str_replace('/', '-', $rapot->tahun_ajaran) . '.pdf';
        
        return $pdf->download($filename);
    }

    // ═══════════════════════════════════════════════════════
    // BIMBINGAN KONSELING
    // ═══════════════════════════════════════════════════════

    public function reportMingguan()
    {
        return view('orangtua.report_mingguan');
    }

    public function grafik()
    {
        return view('orangtua.grafik');
    }

    public function chat()
    {
        return view('orangtua.chat');
    }

    public function kirimChat(Request $request)
    {
        $request->validate(['message' => 'required|string']);

        \App\Models\Chat::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id ?? 1,
            'message' => $request->message,
            'is_read' => false,
        ]);

        return redirect()->route('orangtua.chat')->with('success', 'Pesan berhasil dikirim!');
    }

    public function konseling()
    {
        return view('orangtua.konseling');
    }

    public function ajukanKonseling(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string',
        ]);

        $students = Student::where('parent_id', Auth::id())->get();
        $student = $students->first();

        if ($student) {
            Schedule::create([
                'student_id' => $student->id,
                'teacher_id' => $request->teacher_id ?? 1,
                'type' => 'bk',
                'date' => $request->tanggal,
                'description' => $request->keterangan,
            ]);
        }

        return redirect()->route('orangtua.konseling')->with('success', 'Konseling berhasil diajukan!');
    }
}
