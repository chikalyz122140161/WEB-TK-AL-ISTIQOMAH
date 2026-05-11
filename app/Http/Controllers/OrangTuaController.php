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

    private function dummyClassTermsForPresensi(): array
    {
        return [
            [
                'id'           => 'ct1',
                'label'        => 'Kelas A1 — 2025/2026 Ganjil',
                'tahun_ajaran' => '2025/2026',
                'semester'     => 'Ganjil',
                'kelas'        => 'A1',
                'bulan_aktif'  => [7, 8, 9, 10, 11, 12], // Juli – Desember
            ],
            [
                'id'           => 'ct2',
                'label'        => 'Kelas A1 — 2024/2025 Genap',
                'tahun_ajaran' => '2024/2025',
                'semester'     => 'Genap',
                'kelas'        => 'A1',
                'bulan_aktif'  => [1, 2, 3, 4, 5, 6], // Januari – Juni
            ],
        ];
    }

    public function presensi(Request $request)
    {
        $student     = $this->getStudentData();
        $classTerms  = $this->dummyClassTermsForPresensi();

        $classTermId = $request->input('class_term_id', $classTerms[0]['id']);
        $bulan       = (int) $request->input('bulan', now()->month);

        $activeCt = collect($classTerms)->firstWhere('id', $classTermId) ?? $classTerms[0];

        // Dummy presensi yang berbeda per (class_term, bulan) untuk simulasi
        $seed = abs(crc32($classTermId . '_' . $bulan));
        $hadir = 14 + ($seed % 6);
        $izin  = ($seed >> 3) % 3;
        $sakit = ($seed >> 5) % 3;
        $alpa  = ($seed >> 7) % 2;
        $presensiData = compact('hadir', 'izin', 'sakit', 'alpa');

        // Detail presensi dummy untuk bulan terpilih
        $namaBulan = \Carbon\Carbon::create()->month($bulan)->translatedFormat('F');
        $tahun     = explode('/', $activeCt['tahun_ajaran'])[$bulan <= 6 ? 1 : 0];

        $detailPresensi = [];
        $statusPool = ['hadir', 'hadir', 'hadir', 'hadir', 'hadir', 'izin', 'sakit'];
        $hariNames  = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        for ($i = 1; $i <= 8; $i++) {
            $tgl = sprintf('%02d', $i + 1);
            $idx = ($seed + $i) % count($statusPool);
            $status = $statusPool[$idx];
            $ket = match ($status) {
                'izin'  => 'Acara keluarga',
                'sakit' => 'Demam',
                default => '-',
            };
            $detailPresensi[] = [
                'tanggal'    => "$tgl " . substr($namaBulan, 0, 3) . " $tahun",
                'hari'       => $hariNames[($i - 1) % 5],
                'status'     => $status,
                'keterangan' => $ket,
            ];
        }

        return view('orangtua.presensi', compact(
            'student', 'presensiData', 'detailPresensi',
            'classTerms', 'classTermId', 'bulan', 'activeCt', 'namaBulan', 'tahun'
        ));
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
        // Dummy mata pelajaran (deskripsi + foto opsional) — sesuai input guru
        $mataPelajaran = [
            [
                'id'        => 'mp1',
                'nama'      => 'Nilai Agama & Moral',
                'deskripsi' => 'Ahmad memahami nilai-nilai agama dengan baik. Ia selalu berdoa sebelum dan sesudah kegiatan serta menunjukkan sikap sopan santun kepada teman dan guru.',
                'foto'      => null,
            ],
            [
                'id'        => 'mp2',
                'nama'      => 'Fisik & Motorik',
                'deskripsi' => 'Perkembangan fisik dan motorik Ahmad sangat baik. Ia sangat aktif dalam kegiatan gerak tubuh, mampu berlari, melompat, dan menangkap bola dengan koordinasi yang baik.',
                'foto'      => 'https://placehold.co/600x400/4CAF82/ffffff?text=Foto+Olahraga',
            ],
            [
                'id'        => 'mp3',
                'nama'      => 'Kognitif',
                'deskripsi' => 'Ahmad mampu mengenali bentuk, warna, dan angka sederhana. Ia menunjukkan kemampuan berpikir logis yang sesuai dengan usianya.',
                'foto'      => null,
            ],
            [
                'id'        => 'mp4',
                'nama'      => 'Bahasa',
                'deskripsi' => 'Ahmad mulai berkembang dalam kemampuan berbahasa. Ia mampu berkomunikasi dengan teman-temannya, namun masih perlu latihan dalam mengungkapkan ide secara runtut.',
                'foto'      => null,
            ],
            [
                'id'        => 'mp5',
                'nama'      => 'Sosial Emosional',
                'deskripsi' => 'Ahmad menunjukkan kemampuan bersosialisasi yang baik. Ia senang bermain bersama teman, mampu berbagi, dan menunjukkan empati kepada temannya.',
                'foto'      => null,
            ],
            [
                'id'        => 'mp6',
                'nama'      => 'Seni',
                'deskripsi' => 'Ahmad memiliki bakat seni yang menonjol. Ia sangat antusias dalam kegiatan menggambar dan mewarnai, serta menunjukkan kreativitas yang tinggi.',
                'foto'      => 'https://placehold.co/600x400/F59E0B/ffffff?text=Karya+Seni+Ahmad',
            ],
        ];

        // Dummy ekstrakurikuler — group dengan poin penilaian level
        $ekstrakurikuler = [
            [
                'id' => 'ek1', 'nama' => 'Menari',
                'assessments' => [
                    ['nama' => 'Kelenturan',       'level' => 'BSH'],
                    ['nama' => 'Ekspresi',         'level' => 'BSB'],
                    ['nama' => 'Hafalan Gerakan',  'level' => 'BSH'],
                ],
            ],
            [
                'id' => 'ek2', 'nama' => 'Mewarnai',
                'assessments' => [
                    ['nama' => 'Kerapian',          'level' => 'BSB'],
                    ['nama' => 'Kreativitas Warna', 'level' => 'BSB'],
                    ['nama' => 'Ketepatan Bidang',  'level' => 'BSH'],
                ],
            ],
        ];

        // Dummy konseling — diambil dari input perkembangan (aggregate / latest)
        $konseling = [
            [
                'id' => 'con1', 'nama' => 'Perkembangan Sosial',
                'assessments' => [
                    ['nama' => 'Interaksi dengan teman', 'level' => 'BSH'],
                    ['nama' => 'Kemampuan berbagi',      'level' => 'BSB'],
                    ['nama' => 'Kepatuhan aturan',       'level' => 'BSH'],
                ],
            ],
            [
                'id' => 'con2', 'nama' => 'Perkembangan Emosi',
                'assessments' => [
                    ['nama' => 'Mengelola emosi',      'level' => 'BSH'],
                    ['nama' => 'Empati terhadap teman','level' => 'MB'],
                ],
            ],
            [
                'id' => 'con3', 'nama' => 'Perkembangan Kognitif',
                'assessments' => [
                    ['nama' => 'Daya tangkap',         'level' => 'BSH'],
                    ['nama' => 'Kreativitas berpikir', 'level' => 'BSB'],
                ],
            ],
        ];

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
            'guru'             => 'Bu Siti, S.Pd',
            'mata_pelajaran'   => $mataPelajaran,
            'ekstrakurikuler'  => $ekstrakurikuler,
            'konseling'        => $konseling,
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
        $W      = 12;
        $levels = ['BB', 'MB', 'BSH', 'BSB'];

        $student   = ['id' => 's1', 'nama' => 'Ahmad Faruq', 'nis' => '2025001'];
        $classTerm = ['kelas' => 'A1', 'tahun_ajaran' => '2025/2026', 'semester' => 'Ganjil'];

        $subjects = [
            ['id' => 'sub1', 'nama' => 'Nilai Agama & Moral', 'short' => 'NAM'],
            ['id' => 'sub2', 'nama' => 'Fisik Motorik',       'short' => 'FM'],
            ['id' => 'sub3', 'nama' => 'Kognitif',            'short' => 'Kognitif'],
            ['id' => 'sub4', 'nama' => 'Bahasa',              'short' => 'Bahasa'],
            ['id' => 'sub5', 'nama' => 'Sosial Emosional',    'short' => 'Sosem'],
            ['id' => 'sub6', 'nama' => 'Seni',                'short' => 'Seni'],
        ];

        // Deterministic weekly scores per subject
        $raw = [];
        foreach ($subjects as $sub) {
            $seed = abs(crc32('ct1' . $student['id'] . $sub['id']));
            $cur  = ($seed % 2) + 2;
            for ($w = 1; $w <= $W; $w++) {
                $r = abs(crc32('ct1' . $student['id'] . $sub['id'] . $w)) % 10;
                if ($r >= 7 && $cur < 4) $cur++;
                elseif ($r <= 1 && $cur > 1) $cur--;
                $raw[$sub['id']][$w] = $cur;
            }
        }

        // Current week stats
        $bsb = $bsh = $mb = $bb = 0;
        foreach ($subjects as $sub) {
            $v = $raw[$sub['id']][$W];
            if ($v === 4)      $bsb++;
            elseif ($v === 3)  $bsh++;
            elseif ($v === 2)  $mb++;
            else               $bb++;
        }

        // Radar: score per subject at current week
        $radar = [];
        foreach ($subjects as $sub) {
            $radar[$sub['id']] = $raw[$sub['id']][$W];
        }

        // Weekly summary: avg across all subjects per week
        $weekAvg = [];
        for ($w = 1; $w <= $W; $w++) {
            $vals = array_map(fn($s) => $raw[$s['id']][$w], $subjects);
            $weekAvg[$w] = round(array_sum($vals) / count($vals), 2);
        }

        $grafikData = [
            'student'      => $student,
            'class_term'   => $classTerm,
            'bsb'          => $bsb,
            'bsh'          => $bsh,
            'mb'           => $mb,
            'bb'           => $bb,
            'current_week' => $W,
            'weeks'        => range(1, $W),
            'subjects'     => $subjects,
            'scores'       => $raw,
            'radar'        => $radar,
            'week_avg'     => $weekAvg,
        ];

        return view('orangtua.grafik', compact('grafikData'));
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
