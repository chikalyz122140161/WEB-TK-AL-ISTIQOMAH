<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;

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

    public function jadwal(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $students = Student::where('parent_id', Auth::id())->get();
        $studentIds = $students->pluck('id');

        $schedules = Schedule::whereIn('student_id', $studentIds)
            ->whereMonth('date', $bulan)
            ->whereYear('date', $tahun)
            ->orderBy('date', 'asc')
            ->get();

        $jadwalList = [];
        foreach ($schedules as $schedule) {
            $date = \Carbon\Carbon::parse($schedule->date);
            $jadwalList[] = [
                'nama' => $schedule->description,
                'tanggal' => $date->translatedFormat('l, d M Y'),
                'tempat' => "Tipe: " . strtoupper($schedule->type),
            ];
        }

        return view('orangtua.jadwal', compact('jadwalList'));
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
