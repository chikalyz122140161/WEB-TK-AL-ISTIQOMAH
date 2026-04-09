<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Student;

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
        $bulan   = $request->input('bulan', now()->month);
        $tahun   = $request->input('tahun', now()->year);
        $student = $this->getStudentData();

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
        // Redirect ke halaman jadwal pembelajaran sebagai default
        return redirect()->route('orangtua.jadwal.pembelajaran');
    }
    
    public function jadwalPembelajaran(Request $request)
    {
        $student = $this->getStudentData();
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

        $student = $this->getStudentData();

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
        $student = $this->getStudentData();

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
        $rapot = [
            'id'             => $id,
            'tahun_ajaran'   => '2025/2026',
            'semester'       => 'Ganjil',
            'kelas'          => 'TK A',
            'tanggal_terbit' => '20 Desember 2025',
            'status'         => 'Terbit',
            'siswa'          => [
                'nama' => 'Ahmad Fauzi',
                'nis'  => '20240001',
            ],
            'guru'           => 'Bu Siti, S.Pd',
            'nilai'          => [
                'agama_moral'              => 'BSH',
                'agama_moral_deskripsi'    => 'Ahmad memahami nilai-nilai agama dengan baik. Ia selalu berdoa sebelum dan sesudah kegiatan serta menunjukkan sikap sopan santun kepada teman dan guru.',
                'fisik_motorik'            => 'BSB',
                'fisik_motorik_deskripsi'  => 'Perkembangan fisik dan motorik Ahmad sangat baik. Ia sangat aktif dalam kegiatan gerak tubuh, mampu berlari, melompat, dan menangkap bola dengan koordinasi yang baik.',
                'kognitif'                 => 'BSH',
                'kognitif_deskripsi'       => 'Ahmad mampu mengenali bentuk, warna, dan angka sederhana. Ia menunjukkan kemampuan berpikir logis yang sesuai dengan usianya.',
                'bahasa'                   => 'MB',
                'bahasa_deskripsi'         => 'Ahmad mulai berkembang dalam kemampuan berbahasa. Ia mampu berkomunikasi dengan teman-temannya, namun masih perlu latihan dalam mengungkapkan ide secara runtut.',
                'sosial_emosional'         => 'BSH',
                'sosial_emosional_deskripsi' => 'Ahmad menunjukkan kemampuan bersosialisasi yang baik. Ia senang bermain bersama teman, mampu berbagi, dan menunjukkan empati kepada temannya.',
                'seni'                     => 'BSB',
                'seni_deskripsi'           => 'Ahmad memiliki bakat seni yang menonjol. Ia sangat antusias dalam kegiatan menggambar dan mewarnai, serta menunjukkan kreativitas yang tinggi.',
            ],
            'kehadiran'      => [
                'hadir' => 78,
                'izin'  => 3,
                'sakit' => 2,
                'alpa'  => 1,
            ],
            'catatan_guru'   => 'Ahmad menunjukkan perkembangan yang sangat membanggakan selama semester ini. Ia rajin, semangat belajar tinggi, dan memiliki interaksi sosial yang baik dengan teman-temannya.',
            'rekomendasi'    => 'Diharapkan orang tua terus mendukung kebiasaan membaca dan bercerita di rumah untuk meningkatkan kemampuan bahasa. Pertahankan kegiatan olah raga dan seni yang Ahmad sukai.',
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
