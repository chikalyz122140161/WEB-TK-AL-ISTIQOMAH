<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

class GuruController extends Controller
{
    private function getDaftarSiswa(): array
    {
        return Student::orderBy('kelas')->orderBy('name')
            ->get()
            ->map(fn($s) => [
                'id'    => $s->id,
                'nama'  => $s->name,
                'kelas' => 'TK ' . $s->kelas,
            ])
            ->toArray();
    }

    public function jadwalKonseling(Request $request)
    {
        $bulanTahun = $request->get('bulan_tahun', date('Y-m'));
        [$tahunFilter, $bulan] = array_map('intval', explode('-', $bulanTahun));

        $daftarSiswa = Student::with('parent')->orderBy('name')->get()->map(fn($s) => [
            'id'          => $s->id,
            'nama'        => $s->name,
            'orang_tua_id'=> $s->parent_id,
        ])->toArray();

        $daftarOrangTua = \App\Models\User::where('role', 'orangtua')->orderBy('name')->get()
            ->map(fn($u) => ['id' => $u->id, 'nama' => $u->name])->toArray();

        // Class term + siswa per class term untuk form "Per Kelas" / "Per Siswa"
        $ds          = $this->dummyGrafikDataset();
        $classTerms  = [];
        foreach ($ds['semesters'] as $sm) {
            foreach ($ds['kelas'] as $k) {
                $siswas = $ds['siswaByKelas'][$k['id']] ?? [];
                $classTerms[] = [
                    'id'         => $sm['id'] . '__' . $k['id'],
                    'label'      => "Kelas {$k['nama']} â€” {$sm['label']}",
                    'kelas'      => $k['nama'],
                    'semester'   => $sm['label'],
                    'siswa'      => array_map(fn($s) => ['id' => $s['id'], 'nama' => $s['nama']], $siswas),
                    'siswa_count'=> count($siswas),
                ];
            }
        }

        $jadwal = collect($this->getDummyJadwalKonseling())
            ->where('bulan', $bulan)
            ->where('tahun', $tahunFilter)
            ->sortByDesc('tanggal_sort')
            ->values()
            ->all();

        return view('guru.jadwal_konseling', compact(
            'jadwal', 'bulan', 'bulanTahun', 'daftarSiswa', 'daftarOrangTua', 'classTerms'
        ));
    }

    public function storeJadwalKonseling(Request $request)
    {
        $mode = $request->input('mode', 'siswa'); // 'siswa' | 'kelas'

        if ($mode === 'kelas') {
            // Dummy: ambil class_term_id, lalu generate jadwal untuk semua siswa di kelas tsb
            $msg = "Jadwal berhasil dibuat untuk semua siswa di class term terpilih.";
        } else {
            $msg = "Jadwal berhasil dibuat untuk siswa terpilih.";
        }

        return redirect()->route('guru.jadwal_konseling')->with('success', $msg);
    }

    private function buildClassTermsForJadwal()
    {
        $ds = $this->dummyGrafikDataset();
        $classTerms = [];
        foreach ($ds['semesters'] as $sm) {
            foreach ($ds['kelas'] as $k) {
                $siswas = $ds['siswaByKelas'][$k['id']] ?? [];
                $classTerms[] = [
                    'id'          => $sm['id'] . '__' . $k['id'],
                    'label'       => "Kelas {$k['nama']} â€” {$sm['label']}",
                    'kelas'       => $k['nama'],
                    'semester'    => $sm['label'],
                    'siswa'       => array_map(fn($s) => ['id' => $s['id'], 'nama' => $s['nama']], $siswas),
                    'siswa_count' => count($siswas),
                ];
            }
        }
        return $classTerms;
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
        $jadwal = $this->getDummyJadwalKonseling()[$id] ?? abort(404);
        return view('guru.jadwal_konseling_show', compact('jadwal'));
    }

    public function jadwalKonselingEdit($id)
    {
        $jadwal         = $this->getDummyJadwalKonseling()[$id] ?? abort(404);
        $daftarSiswa    = $this->getDaftarSiswa();
        $daftarOrangTua = \App\Models\User::where('role', 'orangtua')->orderBy('name')->get()
            ->map(fn($u) => ['id' => $u->id, 'nama' => $u->name])->toArray();

        // Dummy class term untuk jadwal ini (sementara hardcode, nanti dari DB)
        $jadwal['class_term'] = $jadwal['class_term'] ?? 'Kelas A1 â€” 2025/2026 Ganjil';

        return view('guru.jadwal_konseling_edit', compact('jadwal', 'daftarSiswa', 'daftarOrangTua'));
    }

    public function jadwalKonselingUpdate(Request $request, $id)
    {
        return redirect()->route('guru.jadwal_konseling')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function jadwalKonselingSetuju(Request $request, $id)
    {
        return redirect()->route('guru.jadwal_konseling')->with('success', 'Jadwal konseling disetujui.');
    }

    public function jadwalKonselingTolak(Request $request, $id)
    {
        return redirect()->route('guru.jadwal_konseling')->with('success', 'Jadwal konseling ditolak.');
    }

    public function jadwalKonselingBatalkan(Request $request, $id)
    {
        return redirect()->route('guru.jadwal_konseling')->with('success', 'Jadwal konseling dibatalkan.');
    }

    public function chat(Request $request)
    {
        $kontak = [
            ['id' => 1, 'nama' => 'Ibu Siti',    'anak' => 'Ahmad Fauzi',   'kelas' => 'TK A', 'preview' => 'Terima kasih Bu...'],
            ['id' => 2, 'nama' => 'Bapak Budi',  'anak' => 'Siti Nurhaliza','kelas' => 'TK A', 'preview' => 'Baik Bu, saya akan...'],
            ['id' => 3, 'nama' => 'Ibu Dewi',    'anak' => 'Eko Prasetyo',  'kelas' => 'TK B', 'preview' => 'Kapan jadwal konseling...'],
            ['id' => 4, 'nama' => 'Bapak Ahmad', 'anak' => 'Rina Sudanti',  'kelas' => 'TK B', 'preview' => 'Mohon informasi...'],
        ];

        $aktifId = (int) $request->get('kontak_id', 1);
        $aktif   = collect($kontak)->firstWhere('id', $aktifId) ?? $kontak[0];

        // Dummy pesan â€” nanti ganti dengan query database
        $semuaPesan = [
            1 => [
                ['dari' => 'ortu', 'teks' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua', 'waktu' => '10:20'],
                ['dari' => 'guru', 'teks' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua', 'waktu' => '10:25'],
                ['dari' => 'ortu', 'teks' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt', 'waktu' => '10:40'],
                ['dari' => 'guru', 'teks' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua', 'waktu' => '10:45'],
                ['dari' => 'ortu', 'teks' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua', 'waktu' => '10:50'],
            ],
            2 => [
                ['dari' => 'ortu', 'teks' => 'Selamat siang Bu, saya mau tanya perkembangan anak saya.', 'waktu' => '09:00'],
                ['dari' => 'guru', 'teks' => 'Selamat siang Bapak Budi. Siti berkembang dengan baik minggu ini.', 'waktu' => '09:05'],
            ],
            3 => [
                ['dari' => 'ortu', 'teks' => 'Bu, kapan jadwal konseling bulan ini?', 'waktu' => '11:00'],
                ['dari' => 'guru', 'teks' => 'Jadwal konseling akan diumumkan minggu depan ya Bu Dewi.', 'waktu' => '11:10'],
            ],
            4 => [
                ['dari' => 'ortu', 'teks' => 'Mohon informasi terkait perkembangan Rina bu.', 'waktu' => '08:30'],
                ['dari' => 'guru', 'teks' => 'Baik Bapak Ahmad, saya akan kirimkan laporan lengkapnya segera.', 'waktu' => '08:45'],
            ],
        ];

        $pesan = $semuaPesan[$aktifId] ?? [];

        return view('guru.chat', compact('kontak', 'aktif', 'aktifId', 'pesan'));
    }

    public function kirimChat(Request $request)
    {
        // Dummy - redirect with success
        return redirect()->route('guru.chat', ['kontak_id' => $request->kontak_id ?? 1]);
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

    public function laporan(Request $request)
    {
        $ds      = $this->dummyGrafikDataset();
        $semua   = $this->buildDummyLaporanList();
        $laporan = collect($semua);

        // Filter
        $smFilter    = $request->input('semester');
        $kelasFilter = $request->input('kelas');
        $siswaFilter = $request->input('siswa');
        $mingguFilter= $request->input('minggu');

        if ($smFilter) {
            $laporan = $laporan->where('semester_id', $smFilter);
        }
        if ($kelasFilter) {
            $laporan = $laporan->where('kelas_id', $kelasFilter);
        }
        if ($siswaFilter) {
            $laporan = $laporan->where('siswa_id', $siswaFilter);
        }
        if ($mingguFilter) {
            $laporan = $laporan->where('minggu', (int) $mingguFilter);
        }

        // Default: tampilkan minggu terakhir saja kalau belum ada filter minggu (hindari overload row)
        if (!$mingguFilter) {
            $laporan = $laporan->groupBy('siswa_id')->map(fn($g) => $g->sortByDesc('minggu')->first())->values();
        } else {
            $laporan = $laporan->values();
        }

        return view('guru.laporan', [
            'laporan'   => $laporan->all(),
            'semesters' => $ds['semesters'],
            'kelas'     => $ds['kelas'],
            'siswaByKelas' => $ds['siswaByKelas'],
            'allSiswa'  => collect($ds['siswaByKelas'])->flatten(1)->values()->all(),
            'weeks'     => range(1, 12),
            'filters'   => [
                'semester' => $smFilter,
                'kelas'    => $kelasFilter,
                'siswa'    => $siswaFilter,
                'minggu'   => $mingguFilter,
            ],
        ]);
    }

    public function laporanBkShow($id)
    {
        $ds    = $this->dummyGrafikDataset();
        $semua = $this->buildDummyLaporanList();
        $row   = collect($semua)->firstWhere('id', (int) $id);

        if (!$row) {
            return redirect()->route('guru.laporan_bk')->with('error', 'Laporan tidak ditemukan.');
        }

        // Bangun struktur per konseling beserta skor per poin penilaian pada minggu ini
        $LV = [1 => 'BB', 2 => 'MB', 3 => 'BSH', 4 => 'BSB'];
        $LV_LABEL = [
            'BB'  => 'Belum Berkembang',
            'MB'  => 'Mulai Berkembang',
            'BSH' => 'Berkembang Sesuai Harapan',
            'BSB' => 'Berkembang Sangat Baik',
        ];

        $minggu = $row['minggu'];
        $konselings = [];
        $totalSum = 0; $totalCnt = 0;

        foreach ($ds['konselings'] as $con) {
            $items = [];
            $sum = 0; $cnt = 0;
            foreach ($con['assessments'] as $ca) {
                $level = $row['scores'][$ca['id']][$minggu] ?? null;
                if ($level !== null) {
                    $sum += $level; $cnt++;
                    $totalSum += $level; $totalCnt++;
                }
                $items[] = [
                    'nama'  => $ca['nama'],
                    'level' => $level,
                    'kode'  => $level !== null ? $LV[$level] : '-',
                    'label' => $level !== null ? $LV_LABEL[$LV[$level]] : '-',
                ];
            }
            $konselings[] = [
                'nama'  => $con['nama'],
                'items' => $items,
                'avg'   => $cnt ? round($sum / $cnt, 2) : 0,
                'count' => $cnt,
            ];
        }

        $laporan = [
            'id'            => $row['id'],
            'siswa_nama'    => $row['siswa_nama'],
            'kelas'         => $row['kelas'],
            'semester'      => $row['semester'],
            'minggu'        => $row['minggu'],
            'tanggal_label' => $row['tanggal_label'],
            'rata_rata'     => $totalCnt ? round($totalSum / $totalCnt, 2) : 0,
            'konselings'    => $konselings,
        ];

        return view('guru.laporan_detail', ['laporan' => $laporan]);
    }

    public function laporanBkEdit($id)
    {
        $ds    = $this->dummyGrafikDataset();
        $semua = $this->buildDummyLaporanList();
        $row   = collect($semua)->firstWhere('id', (int) $id);

        if (!$row) {
            return redirect()->route('guru.laporan_bk')->with('error', 'Laporan tidak ditemukan.');
        }

        $minggu = $row['minggu'];

        // Bangun struktur per konseling beserta level per poin penilaian (untuk prefill dropdown)
        $konselings = [];
        foreach ($ds['konselings'] as $con) {
            $items = [];
            foreach ($con['assessments'] as $ca) {
                $items[] = [
                    'id'    => $ca['id'],
                    'nama'  => $ca['nama'],
                    'level' => $row['scores'][$ca['id']][$minggu] ?? null,
                ];
            }
            $konselings[] = [
                'id'    => $con['id'],
                'nama'  => $con['nama'],
                'items' => $items,
            ];
        }

        $laporan = [
            'id'            => $row['id'],
            'siswa_id'      => $row['siswa_id'],
            'siswa_nama'    => $row['siswa_nama'],
            'kelas'         => $row['kelas'],
            'kelas_id'      => $row['kelas_id'],
            'semester_id'   => $row['semester_id'],
            'semester'      => $row['semester'],
            'minggu'        => $row['minggu'],
            'tanggal'       => $row['tanggal'],
            'tanggal_label' => $row['tanggal_label'],
            'konselings'    => $konselings,
        ];

        return view('guru.laporan_edit', [
            'laporan'   => $laporan,
            'semesters' => $ds['semesters'],
        ]);
    }

    public function laporanBkUpdate(Request $request, $id)
    {
        // Nanti diganti dengan logika update database
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

    public function grafik()
    {
        $ds         = $this->dummyGrafikDataset();
        $semesters  = $ds['semesters'];
        $kelas      = $ds['kelas'];
        $siswaByKelas = $ds['siswaByKelas'];
        $konselings = $ds['konselings'];
        $W = 12;

        // Generate weekly scores: $raw[semId][siswaId][assessmentId][week] = level (1-4)
        $raw = [];
        foreach ($semesters as $sm) {
            $smId = $sm['id'];
            foreach ($kelas as $k) {
                $siswas = $siswaByKelas[$k['id']] ?? [];
                foreach ($siswas as $s) {
                    foreach ($konselings as $con) {
                        foreach ($con['assessments'] as $ca) {
                            $seed = abs(crc32($smId . $s['id'] . $ca['id']));
                            $cur  = ($seed % 2) + 2; // start MB or BSH
                            for ($w = 1; $w <= $W; $w++) {
                                $r = abs(crc32($smId . $s['id'] . $ca['id'] . $w)) % 10;
                                if ($r >= 7 && $cur < 4) $cur++;
                                elseif ($r <= 1 && $cur > 1) $cur--;
                                $raw[$smId][$s['id']][$ca['id']][$w] = $cur;
                            }
                        }
                    }
                }
            }
        }

        // Aggregation: average per (sem, konseling, kelas, week) â†’ rata2 semua siswa di kelas Ã— semua poin di konseling
        $byKelas = [];
        // Aggregation: average per (sem, konseling, siswa, week) â†’ rata2 semua poin di konseling untuk siswa itu
        $bySiswa = [];

        foreach ($semesters as $sm) {
            $smId = $sm['id'];
            foreach ($konselings as $con) {
                $conId = $con['id'];
                $aIds  = array_column($con['assessments'], 'id');

                foreach ($kelas as $k) {
                    $kId = $k['id'];
                    $siswas = $siswaByKelas[$kId] ?? [];

                    for ($w = 1; $w <= $W; $w++) {
                        $sum = 0; $cnt = 0;
                        foreach ($siswas as $s) {
                            foreach ($aIds as $aId) {
                                $val = $raw[$smId][$s['id']][$aId][$w] ?? null;
                                if ($val !== null) { $sum += $val; $cnt++; }
                            }
                        }
                        $byKelas[$smId][$conId][$kId][$w] = $cnt ? round($sum / $cnt, 2) : 0;
                    }

                    foreach ($siswas as $s) {
                        for ($w = 1; $w <= $W; $w++) {
                            $sum = 0; $cnt = 0;
                            foreach ($aIds as $aId) {
                                $val = $raw[$smId][$s['id']][$aId][$w] ?? null;
                                if ($val !== null) { $sum += $val; $cnt++; }
                            }
                            $bySiswa[$smId][$conId][$s['id']][$w] = $cnt ? round($sum / $cnt, 2) : 0;
                        }
                    }
                }
            }
        }

        $grafikPayload = [
            'semesters'    => $semesters,
            'kelas'        => $kelas,
            'siswaByKelas' => $siswaByKelas,
            'konselings'   => $konselings,
            'weeks'        => range(1, $W),
            'byKelas'      => $byKelas,
            'bySiswa'      => $bySiswa,
            'raw'          => $raw,
        ];

        // Variabel lama tetap dikembalikan agar tidak break view kalau ada referensi lama
        $classTerms   = $this->dummyRapotClassTerms();
        $studentsByCt = $this->dummyRapotStudents();
        $subjectsByCt = $this->dummyRapotSubjectsAll();

        $W = 12;
        $levels     = ['BB', 'MB', 'BSH', 'BSB'];
        $shortNames = [
            'sub1' => 'NAM', 'sub2' => 'FM', 'sub3' => 'Kognitif',
            'sub4' => 'Bahasa', 'sub5' => 'Sosem', 'sub6' => 'Seni',
        ];

        $grafikData = [];

        foreach ($classTerms as $ct) {
            $ctId     = $ct['id'];
            $students = $studentsByCt[$ctId] ?? [];
            $subjects = $subjectsByCt[$ctId] ?? [];

            // Weekly scores per student per subject: 1â€“4
            $raw = [];
            foreach ($students as $s) {
                foreach ($subjects as $sub) {
                    $seed    = abs(crc32($ctId . $s['id'] . $sub['id']));
                    $cur     = ($seed % 2) + 2; // start MB or BSH
                    for ($w = 1; $w <= $W; $w++) {
                        $r = abs(crc32($ctId . $s['id'] . $sub['id'] . $w)) % 10;
                        if ($r >= 7 && $cur < 4) $cur++;
                        elseif ($r <= 1 && $cur > 1) $cur--;
                        $raw[$s['id']][$sub['id']][$w] = $cur;
                    }
                }
            }

            // Average per subject per week (class-level)
            $subAvg = [];
            foreach ($subjects as $sub) {
                for ($w = 1; $w <= $W; $w++) {
                    $vals = array_map(fn($s) => $raw[$s['id']][$sub['id']][$w] ?? 2, $students);
                    $subAvg[$sub['id']][$w] = count($vals) ? round(array_sum($vals) / count($vals), 2) : 0;
                }
            }

            // Overall class average per week
            $classAvg = [];
            for ($w = 1; $w <= $W; $w++) {
                $all = array_map(fn($sub) => $subAvg[$sub['id']][$w], $subjects);
                $classAvg[$w] = count($all) ? round(array_sum($all) / count($all), 2) : 0;
            }

            // Stats at current week (week = W) â€” hitung 4 level
            $bb = $mb = $bsh = $bsb = 0;
            foreach ($students as $s) {
                foreach ($subjects as $sub) {
                    $v = $raw[$s['id']][$sub['id']][$W] ?? 2;
                    if ($v === 1) $bb++;
                    elseif ($v === 2) $mb++;
                    elseif ($v === 3) $bsh++;
                    elseif ($v === 4) $bsb++;
                }
            }

            // Table: per student, level per subject at current week
            $table = [];
            foreach ($students as $s) {
                $scores = [];
                $sum    = 0;
                foreach ($subjects as $sub) {
                    $v = $raw[$s['id']][$sub['id']][$W] ?? 2;
                    $scores[$sub['id']] = $levels[$v - 1];
                    $sum += $v;
                }
                $table[] = [
                    'nama'   => $s['nama'],
                    'scores' => $scores,
                    'avg'    => count($subjects) ? round($sum / count($subjects), 1) : 0,
                ];
            }

            // Distribution at current week per subject
            $dist = [];
            foreach ($subjects as $sub) {
                $d = ['BB' => 0, 'MB' => 0, 'BSH' => 0, 'BSB' => 0];
                foreach ($students as $s) {
                    $v = $raw[$s['id']][$sub['id']][$W] ?? 2;
                    $d[$levels[$v - 1]]++;
                }
                $dist[$sub['id']] = $d;
            }

            // Radar: class avg per subject at current week
            $radar = [];
            foreach ($subjects as $sub) {
                $vals = array_map(fn($s) => $raw[$s['id']][$sub['id']][$W] ?? 2, $students);
                $radar[$sub['id']] = count($vals) ? round(array_sum($vals) / count($vals), 2) : 0;
            }

            $grafikData[$ctId] = [
                'class_term'   => ['kelas' => $ct['kelas_nama'], 'tahun_ajaran' => $ct['tahun_ajaran'], 'semester' => $ct['semester']],
                'total_siswa'  => count($students),
                'bsb_count'    => $bsb,
                'bsh_count'    => $bsh,
                'mb_count'     => $mb,
                'bb_count'     => $bb,
                'current_week' => $W,
                'weeks'        => range(1, $W),
                'subjects'     => array_map(fn($s) => [
                    'id'    => $s['id'],
                    'nama'  => $s['nama'],
                    'short' => $shortNames[$s['id']] ?? $s['nama'],
                ], $subjects),
                'subject_avg'  => $subAvg,
                'class_avg'    => $classAvg,
                'table'        => $table,
                'distribution' => $dist,
                'radar'        => $radar,
            ];
        }

        return view('guru.grafik', compact('classTerms', 'grafikData', 'grafikPayload'));
    }

    public function inputPerkembangan()
    {
        $classTerms     = $this->dummyRapotClassTerms();
        $studentsByCt   = $this->dummyRapotStudents();
        $counselingByCt = $this->dummyRapotCounselingAll();

        // Siswa di-flatten dengan info class_term untuk label
        $daftarSiswa = [];
        foreach ($studentsByCt as $ctId => $students) {
            $ct = collect($classTerms)->firstWhere('id', $ctId);
            $ctLabel = $ct
                ? "Kelas {$ct['kelas_nama']} - {$ct['tahun_ajaran']} " . ucfirst($ct['semester'])
                : '';
            foreach ($students as $s) {
                $daftarSiswa[] = [
                    'id'            => $s['id'],
                    'nama'          => $s['nama'],
                    'class_term_id' => $ctId,
                    'class_term_label' => $ctLabel,
                ];
            }
        }

        return view('guru.input_perkembangan', compact('daftarSiswa', 'classTerms', 'counselingByCt'));
    }

    public function storeInputPerkembangan(Request $request)
    {
        // Dummy - redirect with success
        return redirect()->route('guru.input_perkembangan')
            ->with('success', 'Data perkembangan berhasil disimpan.');
    }

    public function dashboard()
    {
        $data = [
            'userName'         => auth()->user()->name,
            'totalSiswa'       => Student::count(),
            'konselingBulanIni' => 15,
            'pengajuanJadwal'  => 3,
            'semester'         => 'Ganjil 2025/2026',
            'updates'          => [
                ['title' => 'Konseling Selesai - Muhammad',    'time' => '2 jam yang lalu'],
                ['title' => 'Input Perkembangan - Anisa',      'time' => '1 hari yang lalu'],
                ['title' => 'Pesan Baru dari Orang Tua Tika',  'time' => '2 hari yang lalu'],
            ],
            'jadwalMendatang'  => [
                [
                    'tanggal' => 'Jumat, 29 November 2024',
                    'waktu'   => '10:00 - 11:00 WIB',
                    'topik'   => 'Perkembangan Sosial Ahmad',
                ],
            ],
        ];

        return view('guru.dashboard', $data);
    }

    // ==================== ADMINISTRASI ====================

    /**
     * Kehadiran - Index (Form & List)
     */
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
                ->where('status', 'aktif')
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

    /**
     * Laporan Administrasi - Index (Form & List)
     */
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

    /**
     * Laporan Administrasi - Generate
     */
    public function laporanGenerate(Request $request)
    {
        // Dummy - redirect with success
        return redirect()->route('guru.laporan.index')->with('success', 'Laporan berhasil di-generate.');
    }

    /**
     * Jadwal - Index (Form & List)
     */
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

    /**
     * Jadwal - Create
     */
    public function jadwalCreate()
    {
        $classTerms = ClassTerm::with(['class', 'academicTerm'])->orderBy('created_at', 'desc')->get();
        return view('guru.jadwal.create', compact('classTerms'));
    }

    /**
     * Jadwal - Store
     */
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

        return redirect()->route('guru.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Jadwal - Edit
     */
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

    /**
     * Jadwal - Update
     */
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

        return redirect()->route('guru.jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Jadwal - Delete
     */
    public function jadwalDestroy(Request $request, $id)
    {
        $activity = ActivitySchedule::find($id);
        if ($activity) {
            $activity->delete();
        } else {
            ClassSchedule::findOrFail($id)->delete();
        }
        $classTermId = $request->input('class_term_id');
        return redirect()->route('guru.jadwal.index', $classTermId ? ['class_term_id' => $classTermId] : [])
            ->with('success', 'Jadwal berhasil dihapus.');
    }

    // ═══════════════════════════════════════════════════════
    // RAPOT SEMESTER
    // ═══════════════════════════════════════════════════════

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