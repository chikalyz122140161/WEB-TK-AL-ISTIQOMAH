<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        // Dummy student data
        $student = [
            'id' => 1,
            'nama' => 'Ahmad Fauzi',
            'class' => 'TK A',
        ];

        // Dummy presensi data
        $presensiData = ['hadir' => 18, 'izin' => 2, 'sakit' => 1, 'alpa' => 0];
        $detailPresensi = [
            ['tanggal' => '02 Mar 2026', 'hari' => 'Senin', 'status' => 'hadir', 'keterangan' => '-'],
            ['tanggal' => '03 Mar 2026', 'hari' => 'Selasa', 'status' => 'hadir', 'keterangan' => '-'],
            ['tanggal' => '04 Mar 2026', 'hari' => 'Rabu', 'status' => 'izin', 'keterangan' => 'Acara keluarga'],
            ['tanggal' => '05 Mar 2026', 'hari' => 'Kamis', 'status' => 'hadir', 'keterangan' => '-'],
            ['tanggal' => '06 Mar 2026', 'hari' => 'Jumat', 'status' => 'sakit', 'keterangan' => 'Demam'],
        ];

        return view('orangtua.presensi', compact('student', 'presensiData', 'detailPresensi'));
    }

    public function laporan(Request $request)
    {
        // Dummy student data
        $student = [
            'id' => 1,
            'nama' => 'Ahmad Fauzi',
            'class' => 'TK A',
        ];

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
        // Dummy data
        $student = ['id' => 1, 'nama' => 'Ahmad Fauzi', 'class' => 'TK A'];
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
        // Redirect ke halaman jadwal pembelajaran sebagai default
        return redirect()->route('orangtua.jadwal.pembelajaran');
    }
    
    public function jadwalPembelajaran(Request $request)
    {
        // Dummy data
        $student = ['id' => 1, 'nama' => 'Ahmad Fauzi', 'class' => 'TK A'];
        $kelas = 'TK A';
        
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

        // Dummy data
        $student = ['id' => 1, 'nama' => 'Ahmad Fauzi', 'class' => 'TK A'];

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
        
        $activeTab = 'kegiatan';
        
        return view('orangtua.jadwal', compact('jadwalKegiatan', 'student', 'bulan', 'tahun', 'activeTab'));
    }


    // ═══════════════════════════════════════════════════════
    // RAPOT SEMESTER
    // ═══════════════════════════════════════════════════════
    
    public function rapot(Request $request)
    {
        // Dummy data
        $student = ['id' => 1, 'nama' => 'Ahmad Fauzi', 'class' => 'TK A'];

        $rapotList = [
            [
                'id' => 1,
                'tahun_ajaran' => '2025/2026',
                'semester' => 'Ganjil',
                'kelas' => 'TK A',
                'tanggal_terbit' => '20 Des 2025',
            ],
            [
                'id' => 2,
                'tahun_ajaran' => '2024/2025',
                'semester' => 'Genap',
                'kelas' => 'Kelompok Bermain',
                'tanggal_terbit' => '15 Jun 2025',
            ],
            [
                'id' => 3,
                'tahun_ajaran' => '2024/2025',
                'semester' => 'Ganjil',
                'kelas' => 'Kelompok Bermain',
                'tanggal_terbit' => '18 Des 2024',
            ],
        ];

        return view('orangtua.rapot', compact('student', 'rapotList'));
    }
    
    public function rapotDetail($id)
    {
        // Dummy data
        $student = (object)[
            'id' => 1,
            'name' => 'Ahmad Fauzi',
            'class' => 'TK A',
            'nis' => '20240001',
        ];
        $teacher = (object)[
            'name' => 'Bu Siti, S.Pd',
        ];

        $rapot = (object)[
            'id' => $id,
            'tahun_ajaran' => '2025/2026',
            'semester' => 'Ganjil',
            'kelas' => 'TK A',
            'tanggal_terbit' => now(),
            'nilai_agama' => 85,
            'nilai_motorik' => 88,
            'nilai_kognitif' => 90,
            'nilai_bahasa' => 85,
            'nilai_sosial' => 87,
            'nilai_seni' => 92,
            'catatan' => 'Ahmad menunjukkan perkembangan yang sangat baik. Terus pertahankan!',
            'student' => $student,
            'teacher' => $teacher,
        ];

        return view('orangtua.rapot_detail', compact('rapot', 'student', 'teacher'));
    }
    
    public function rapotDownload($id)
    {
        // Dummy data
        $student = (object)[
            'id' => 1,
            'name' => 'Ahmad Fauzi',
            'class' => 'TK A',
            'nis' => '20240001',
        ];
        $teacher = (object)[
            'name' => 'Bu Siti, S.Pd',
        ];

        $rapot = (object)[
            'id' => $id,
            'tahun_ajaran' => '2025/2026',
            'semester' => 'Ganjil',
            'kelas' => 'TK A',
            'tanggal_terbit' => now(),
            'nilai_agama' => 85,
            'nilai_motorik' => 88,
            'nilai_kognitif' => 90,
            'nilai_bahasa' => 85,
            'nilai_sosial' => 87,
            'nilai_seni' => 92,
            'catatan' => 'Ahmad menunjukkan perkembangan yang sangat baik. Terus pertahankan!',
            'student' => $student,
            'teacher' => $teacher,
        ];

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
        // Hanya redirect dengan pesan sukses (dummy)
        return redirect()->route('orangtua.chat')->with('success', 'Pesan berhasil dikirim!');
    }

    public function konseling()
    {
        return view('orangtua.konseling');
    }

    public function ajukanKonseling(Request $request)
    {
        // Hanya redirect dengan pesan sukses (dummy)
        return redirect()->route('orangtua.konseling')->with('success', 'Konseling berhasil diajukan!');
    }
}
