<?php

namespace Database\Seeders;

use App\Models\AcademicTerm;
use App\Models\ActivitySchedule;
use App\Models\ClassSchedule;
use App\Models\ClassTerm;
use App\Models\ClassTermCounseling;
use App\Models\ClassTermExtracurricular;
use App\Models\ClassTermSubject;
use App\Models\Classroom;
use App\Models\Counseling;
use App\Models\CounselingAssessment;
use App\Models\Extracurricular;
use App\Models\ExtracurricularAssessment;
use App\Models\Parents;
use App\Models\PrivateCounselingSchedule;
use App\Models\Student;
use App\Models\StudentEnrollment;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ErdSeeder extends Seeder
{
    public function run(): void
    {
        /* ══════════════════════════════════════════════════
         *  1. USERS — Admin + 3 Guru
         * ══════════════════════════════════════════════════ */
        $admin = User::create([
            'name'       => 'Baini, S.Pd',
            'email'      => 'admin@tkalistiqomah.sch.id',
            'password'   => Hash::make('password'),
            'phone'      => '081200000000',
            'role'       => 'admin',
            'status'     => 'active',
            'isGraduate' => false,
        ]);

        $guruA = User::create([
            'name'       => 'Reita Wigianti, S.Si, S.Pd., Gr',
            'email'      => 'reita.wigianti@tkalistiqomah.sch.id',
            'password'   => Hash::make('password'),
            'phone'      => '081211111111',
            'role'       => 'guru',
            'status'     => 'active',
            'isGraduate' => false,
        ]);

        $guruB1 = User::create([
            'name'       => 'Lucia Untari, S.Pd',
            'email'      => 'lucia.untari@tkalistiqomah.sch.id',
            'password'   => Hash::make('password'),
            'phone'      => '081222222222',
            'role'       => 'guru',
            'status'     => 'active',
            'isGraduate' => false,
        ]);

        $guruB2 = User::create([
            'name'       => 'Fitriyah Hariani, S.Pd',
            'email'      => 'fitriyah.hariani@tkalistiqomah.sch.id',
            'password'   => Hash::make('password'),
            'phone'      => '081233333333',
            'role'       => 'guru',
            'status'     => 'active',
            'isGraduate' => false,
        ]);

        $guruByKelas = ['A' => $guruA, 'B1' => $guruB1, 'B2' => $guruB2];

        /* ══════════════════════════════════════════════════
         *  2. KELAS
         * ══════════════════════════════════════════════════ */
        $kelasA  = Classroom::create(['name' => 'A',  'maximum' => 20]);
        $kelasB1 = Classroom::create(['name' => 'B1', 'maximum' => 20]);
        $kelasB2 = Classroom::create(['name' => 'B2', 'maximum' => 20]);

        /* ══════════════════════════════════════════════════
         *  3. ACADEMIC TERM  —  2025/2026 Ganjil (selesai) + Genap (aktif)
         * ══════════════════════════════════════════════════ */
        $taGanjil = AcademicTerm::create([
            'academic_year' => '2025/2026',
            'semester'      => 'ganjil',
            'status'        => 'selesai',
        ]);
        $taGenap = AcademicTerm::create([
            'academic_year' => '2025/2026',
            'semester'      => 'genap',
            'status'        => 'aktif',
        ]);

        /* ══════════════════════════════════════════════════
         *  4. CLASS TERM
         *     Ganjil → isPass true (sudah selesai proses kenaikan)
         *     Genap  → isPass false (sedang berjalan)
         * ══════════════════════════════════════════════════ */
        $ctAGanjil  = ClassTerm::create(['class_id' => $kelasA->id,  'academic_term_id' => $taGanjil->id, 'isPass' => true]);
        $ctB1Ganjil = ClassTerm::create(['class_id' => $kelasB1->id, 'academic_term_id' => $taGanjil->id, 'isPass' => true]);
        $ctB2Ganjil = ClassTerm::create(['class_id' => $kelasB2->id, 'academic_term_id' => $taGanjil->id, 'isPass' => true]);

        $ctAGenap  = ClassTerm::create(['class_id' => $kelasA->id,  'academic_term_id' => $taGenap->id, 'isPass' => false]);
        $ctB1Genap = ClassTerm::create(['class_id' => $kelasB1->id, 'academic_term_id' => $taGenap->id, 'isPass' => false]);
        $ctB2Genap = ClassTerm::create(['class_id' => $kelasB2->id, 'academic_term_id' => $taGenap->id, 'isPass' => false]);

        $ganjilMap = ['A' => $ctAGanjil,  'B1' => $ctB1Ganjil, 'B2' => $ctB2Ganjil];
        $genapMap  = ['A' => $ctAGenap,   'B1' => $ctB1Genap,  'B2' => $ctB2Genap];
        $allCTs    = [$ctAGanjil, $ctB1Ganjil, $ctB2Ganjil, $ctAGenap, $ctB1Genap, $ctB2Genap];

        /* ══════════════════════════════════════════════════
         *  5. MATA PELAJARAN
         * ══════════════════════════════════════════════════ */
        $subjects = [];
        foreach ([
            'Nilai Agama & Moral',
            'Fisik Motorik',
            'Kognitif',
            'Bahasa',
            'Sosial Emosional',
            'Seni',
        ] as $name) {
            $subjects[] = Subject::create(['name' => $name]);
        }

        /* ══════════════════════════════════════════════════
         *  6. EKSTRAKURIKULER + ASPEK PENILAIAN
         * ══════════════════════════════════════════════════ */
        $ekMenari = Extracurricular::create(['name' => 'Menari']);
        foreach (['Kelenturan Tubuh', 'Ekspresi & Penghayatan', 'Hafalan Gerakan'] as $a) {
            ExtracurricularAssessment::create(['extracurricular_id' => $ekMenari->id, 'name' => $a]);
        }

        $ekMewarnai = Extracurricular::create(['name' => 'Mewarnai']);
        foreach (['Kerapian', 'Kreativitas Warna', 'Ketepatan Bidang Warna'] as $a) {
            ExtracurricularAssessment::create(['extracurricular_id' => $ekMewarnai->id, 'name' => $a]);
        }

        $ekDrumband = Extracurricular::create(['name' => 'Drumband']);
        foreach (['Koordinasi Gerak', 'Kedisiplinan', 'Kekompakan Tim'] as $a) {
            ExtracurricularAssessment::create(['extracurricular_id' => $ekDrumband->id, 'name' => $a]);
        }

        $allExtras = [$ekMenari, $ekMewarnai, $ekDrumband];

        /* ══════════════════════════════════════════════════
         *  7. KONSELING + ASPEK PENILAIAN
         * ══════════════════════════════════════════════════ */
        $konSosial = Counseling::create(['name' => 'Perkembangan Sosial']);
        foreach (['Interaksi dengan Teman', 'Kemampuan Berbagi', 'Kepatuhan Aturan Kelas'] as $a) {
            CounselingAssessment::create(['counseling_id' => $konSosial->id, 'name' => $a]);
        }

        $konEmosi = Counseling::create(['name' => 'Perkembangan Emosi']);
        foreach (['Mengelola Emosi', 'Empati terhadap Teman', 'Kemampuan Mengungkapkan Perasaan'] as $a) {
            CounselingAssessment::create(['counseling_id' => $konEmosi->id, 'name' => $a]);
        }

        $konKognitif = Counseling::create(['name' => 'Perkembangan Kognitif']);
        foreach (['Daya Tangkap', 'Kreativitas Berpikir', 'Kemampuan Memecahkan Masalah'] as $a) {
            CounselingAssessment::create(['counseling_id' => $konKognitif->id, 'name' => $a]);
        }

        $konBahasa = Counseling::create(['name' => 'Perkembangan Bahasa']);
        foreach (['Kemampuan Bercerita', 'Penguasaan Kosakata', 'Kemampuan Mendengarkan'] as $a) {
            CounselingAssessment::create(['counseling_id' => $konBahasa->id, 'name' => $a]);
        }

        $konFisik = Counseling::create(['name' => 'Perkembangan Fisik Motorik']);
        foreach (['Motorik Kasar', 'Motorik Halus', 'Koordinasi Mata-Tangan'] as $a) {
            CounselingAssessment::create(['counseling_id' => $konFisik->id, 'name' => $a]);
        }

        $allCounselings = [$konSosial, $konEmosi, $konKognitif, $konBahasa, $konFisik];

        /* ══════════════════════════════════════════════════
         *  8. LINK Class Term × Mapel × Ekskul × Konseling
         *     (berlaku untuk semua class term ganjil & genap)
         * ══════════════════════════════════════════════════ */
        foreach ($allCTs as $ct) {
            foreach ($subjects as $s) {
                ClassTermSubject::create(['class_term_id' => $ct->id, 'subject_id' => $s->id]);
            }
            foreach ($allExtras as $e) {
                ClassTermExtracurricular::create(['class_term_id' => $ct->id, 'extracurricular_id' => $e->id]);
            }
            foreach ($allCounselings as $k) {
                ClassTermCounseling::create(['class_term_id' => $ct->id, 'counseling_id' => $k->id]);
            }
        }

        /* ══════════════════════════════════════════════════
         *  9. JADWAL KELAS (Senin–Jumat) — untuk semua class term
         * ══════════════════════════════════════════════════ */
        $jadwalHarian = [
            // Senin
            ['day' => 1, 'name' => 'Upacara & Doa Pagi',         'start_hour' => '07:30', 'end_hour' => '07:45'],
            ['day' => 1, 'name' => 'Kegiatan Motorik Kasar',     'start_hour' => '07:45', 'end_hour' => '08:15'],
            ['day' => 1, 'name' => 'Pembelajaran Tema',           'start_hour' => '08:15', 'end_hour' => '09:15'],
            ['day' => 1, 'name' => 'Istirahat & Makan',          'start_hour' => '09:15', 'end_hour' => '09:45'],
            ['day' => 1, 'name' => 'Kegiatan Inti / Sentra',     'start_hour' => '09:45', 'end_hour' => '10:30'],
            ['day' => 1, 'name' => 'Penutup & Doa Pulang',       'start_hour' => '10:30', 'end_hour' => '10:45'],
            // Selasa
            ['day' => 2, 'name' => 'Doa Pagi & Hafalan Surat',   'start_hour' => '07:30', 'end_hour' => '07:45'],
            ['day' => 2, 'name' => 'Senam Pagi',                  'start_hour' => '07:45', 'end_hour' => '08:15'],
            ['day' => 2, 'name' => 'Pembelajaran Bahasa',         'start_hour' => '08:15', 'end_hour' => '09:15'],
            ['day' => 2, 'name' => 'Istirahat & Makan',          'start_hour' => '09:15', 'end_hour' => '09:45'],
            ['day' => 2, 'name' => 'Kegiatan Seni & Kreasi',     'start_hour' => '09:45', 'end_hour' => '10:30'],
            ['day' => 2, 'name' => 'Penutup & Doa Pulang',       'start_hour' => '10:30', 'end_hour' => '10:45'],
            // Rabu
            ['day' => 3, 'name' => 'Doa Pagi & Hadits',          'start_hour' => '07:30', 'end_hour' => '07:45'],
            ['day' => 3, 'name' => 'Senam Ceria',                 'start_hour' => '07:45', 'end_hour' => '08:15'],
            ['day' => 3, 'name' => 'Pembelajaran Matematika',     'start_hour' => '08:15', 'end_hour' => '09:15'],
            ['day' => 3, 'name' => 'Istirahat & Makan',          'start_hour' => '09:15', 'end_hour' => '09:45'],
            ['day' => 3, 'name' => 'Mewarnai / Melukis',         'start_hour' => '09:45', 'end_hour' => '10:30'],
            ['day' => 3, 'name' => 'Penutup & Doa Pulang',       'start_hour' => '10:30', 'end_hour' => '10:45'],
            // Kamis
            ['day' => 4, 'name' => 'Doa Pagi & Asmaul Husna',    'start_hour' => '07:30', 'end_hour' => '07:45'],
            ['day' => 4, 'name' => 'Menari',                      'start_hour' => '07:45', 'end_hour' => '08:30'],
            ['day' => 4, 'name' => 'Pembelajaran Sains Sederhana','start_hour' => '08:30', 'end_hour' => '09:15'],
            ['day' => 4, 'name' => 'Istirahat & Makan',          'start_hour' => '09:15', 'end_hour' => '09:45'],
            ['day' => 4, 'name' => 'Bermain Peran / Sentra Drama','start_hour' => '09:45', 'end_hour' => '10:30'],
            ['day' => 4, 'name' => 'Penutup & Doa Pulang',       'start_hour' => '10:30', 'end_hour' => '10:45'],
            // Jumat
            ['day' => 5, 'name' => 'Doa Pagi & Surat Pendek',    'start_hour' => '07:30', 'end_hour' => '07:45'],
            ['day' => 5, 'name' => 'Drumband',                    'start_hour' => '07:45', 'end_hour' => '08:30'],
            ['day' => 5, 'name' => 'Bermain Bebas Terbimbing',    'start_hour' => '08:30', 'end_hour' => '09:15'],
            ['day' => 5, 'name' => 'Istirahat & Makan',          'start_hour' => '09:15', 'end_hour' => '09:45'],
            ['day' => 5, 'name' => 'Review Mingguan & Penutup',  'start_hour' => '09:45', 'end_hour' => '10:30'],
        ];

        foreach ($allCTs as $ct) {
            foreach ($jadwalHarian as $j) {
                ClassSchedule::create([
                    'class_term_id' => $ct->id,
                    'name'          => $j['name'],
                    'day'           => $j['day'],
                    'start_hour'    => $j['start_hour'],
                    'end_hour'      => $j['end_hour'],
                ]);
            }
        }

        /* ══════════════════════════════════════════════════
         *  10. JADWAL KEGIATAN (Activity Schedule) — semester genap
         * ══════════════════════════════════════════════════ */
        $activities = [
            [
                'name'        => 'Kunjungan Belajar ke Kebun Binatang',
                'date'        => '2026-02-14',
                'start_hour'  => '08:00',
                'end_hour'    => '13:00',
                'location'    => 'Taman Kupu-Kupu Gita Persada, Bandar Lampung',
                'description' => 'Mengenal berbagai jenis hewan dan lingkungan alam secara langsung',
            ],
            [
                'name'        => 'Peringatan Hari Kartini',
                'date'        => '2026-04-21',
                'start_hour'  => '07:30',
                'end_hour'    => '11:00',
                'location'    => 'Halaman Sekolah',
                'description' => 'Pentas seni budaya dan parade busana daerah',
            ],
            [
                'name'        => 'Outbond & Fun Games',
                'date'        => '2026-03-15',
                'start_hour'  => '08:00',
                'end_hour'    => '12:00',
                'location'    => 'Taman Bermain Kota',
                'description' => 'Kegiatan permainan dan olah raga bersama untuk meningkatkan kerjasama',
            ],
            [
                'name'        => 'Pentas Seni Akhir Semester Genap',
                'date'        => '2026-05-30',
                'start_hour'  => '08:00',
                'end_hour'    => '12:00',
                'location'    => 'Aula TK Al-Istiqomah',
                'description' => 'Penampilan seni siswa: menari, menyanyi, dan drumband',
            ],
        ];

        foreach ([$ctAGenap, $ctB1Genap, $ctB2Genap] as $ct) {
            foreach ($activities as $act) {
                ActivitySchedule::create([
                    'class_term_id' => $ct->id,
                    'name'          => $act['name'],
                    'date'          => $act['date'],
                    'start_hour'    => $act['start_hour'],
                    'end_hour'      => $act['end_hour'],
                    'location'      => $act['location'],
                    'description'   => $act['description'],
                ]);
            }
        }

        // Aktivitas ganjil (sudah terlaksana, diisi sebagai histori)
        $activitiesGanjil = [
            [
                'name'        => 'Masa Pengenalan Lingkungan Sekolah (MPLS)',
                'date'        => '2025-07-14',
                'start_hour'  => '07:30',
                'end_hour'    => '10:30',
                'location'    => 'Sekolah',
                'description' => 'Pengenalan lingkungan sekolah bagi siswa baru',
            ],
            [
                'name'        => 'Peringatan Maulid Nabi Muhammad SAW',
                'date'        => '2025-09-15',
                'start_hour'  => '08:00',
                'end_hour'    => '10:00',
                'location'    => 'Aula TK Al-Istiqomah',
                'description' => 'Ceramah dan kegiatan islami',
            ],
            [
                'name'        => 'Lomba Antar Kelas HUT RI',
                'date'        => '2025-08-16',
                'start_hour'  => '08:00',
                'end_hour'    => '11:00',
                'location'    => 'Halaman Sekolah',
                'description' => 'Berbagai perlombaan dalam rangka HUT Kemerdekaan RI ke-80',
            ],
        ];

        foreach ([$ctAGanjil, $ctB1Ganjil, $ctB2Ganjil] as $ct) {
            foreach ($activitiesGanjil as $act) {
                ActivitySchedule::create([
                    'class_term_id' => $ct->id,
                    'name'          => $act['name'],
                    'date'          => $act['date'],
                    'start_hour'    => $act['start_hour'],
                    'end_hour'      => $act['end_hour'],
                    'location'      => $act['location'],
                    'description'   => $act['description'],
                ]);
            }
        }

        /* ══════════════════════════════════════════════════
         *  11. SISWA, ORANG TUA, & ENROLLMENT
         *      - Ganjil : status naik, aksi ganti_semester → ke Genap
         *      - Genap  : status aktif
         * ══════════════════════════════════════════════════ */
        $siswaData = $this->getSiswaData();
        $createdStudents = [];  // untuk sample konseling jadwal

        foreach ($siswaData as $idx => $row) {
            // Buat user akun orang tua
            $parentUser = User::create([
                'name'     => $row['ayah_nama'] ?? ('Orang Tua ' . $row['name']),
                'email'    => 'ortu' . ($idx + 1) . '@tkalistiqomah.sch.id',
                'password' => Hash::make('password'),
                'phone'    => $row['phone'] ?? null,
                'role'     => 'orangtua',
                'status'   => 'active',
            ]);

            $student = Student::create([
                'user_id'   => $parentUser->id,
                'name'      => $row['name'],
                'gender'    => $row['gender'],
                'nis'       => $row['nis'],
                'nisn'      => $row['nisn'],
                'pob'       => $row['pob'],
                'dob'       => $row['dob'],
                'nik'       => $row['nik'],
                'address'   => $row['address'],
                'phone'     => $row['phone'] ?? null,
                'religion'  => 'islam',
            ]);

            // Enrollment Ganjil → naik (proses kenaikan sudah dilakukan)
            StudentEnrollment::create([
                'student_id'           => $student->id,
                'class_term_id'        => $ganjilMap[$row['kelas']]->id,
                'status'               => 'naik',
                'aksi'                 => 'ganti_semester',
                'class_term_tujuan_id' => $genapMap[$row['kelas']]->id,
            ]);

            // Enrollment Genap → aktif (semester yang sedang berjalan)
            StudentEnrollment::create([
                'student_id'    => $student->id,
                'class_term_id' => $genapMap[$row['kelas']]->id,
                'status'        => 'aktif',
            ]);

            // Data orang tua
            if (!empty($row['ayah_nama'])) {
                Parents::create([
                    'student_id' => $student->id,
                    'category'   => 'ayah',
                    'name'       => $row['ayah_nama'],
                    'work'       => $row['ayah_kerja'] ?? null,
                ]);
            }
            if (!empty($row['ibu_nama'])) {
                Parents::create([
                    'student_id' => $student->id,
                    'category'   => 'ibu',
                    'name'       => $row['ibu_nama'],
                    'work'       => $row['ibu_kerja'] ?? null,
                ]);
            }

            $createdStudents[] = ['student' => $student, 'kelas' => $row['kelas']];
        }

        /* ══════════════════════════════════════════════════
         *  12. JADWAL KONSELING PRIVAT (sample)
         *      Beberapa sesi konseling antara guru dan siswa
         * ══════════════════════════════════════════════════ */
        $sampleSessions = [
            // [student_index, status, date, start, end, topic]
            [0,  'disetujui', '2026-02-10', '09:00:00', '09:30:00', 'Penyesuaian diri di semester baru'],
            [1,  'disetujui', '2026-02-12', '09:00:00', '09:30:00', 'Perkembangan sosial dan bermain bersama'],
            [11, 'selesai',   '2026-02-05', '10:00:00', '10:30:00', 'Kemampuan berkomunikasi dan berinteraksi'],
            [12, 'selesai',   '2026-02-07', '10:00:00', '10:30:00', 'Pengelolaan emosi saat bermain'],
            [25, 'pending',   '2026-02-20', '09:00:00', '09:30:00', 'Perkembangan motorik halus'],
            [26, 'pending',   '2026-02-21', '09:00:00', '09:30:00', 'Kesulitan konsentrasi saat belajar'],
        ];

        foreach ($sampleSessions as [$sidx, $status, $date, $start, $end, $topic]) {
            if (!isset($createdStudents[$sidx])) {
                continue;
            }
            $info  = $createdStudents[$sidx];
            $guru  = $guruByKelas[$info['kelas']];
            $ctGen = $genapMap[$info['kelas']];

            PrivateCounselingSchedule::create([
                'student_id'    => $info['student']->id,
                'teacher_id'    => $guru->id,
                'class_term_id' => $ctGen->id,
                'status'        => $status,
                'date'          => $date,
                'start_hour'    => $start,
                'end_hour'      => $end,
                'topic'         => $topic,
            ]);
        }

        $this->command->info('✓ Seeder selesai:');
        $this->command->info('  • 4 user (Admin + 3 Guru)');
        $this->command->info('  • ' . count($siswaData) . ' user orangtua + ' . count($siswaData) . ' siswa dengan data orang tua');
        $this->command->info('  • 3 kelas (A, B1, B2)');
        $this->command->info('  • 2 tahun ajaran (2025/2026 Ganjil selesai, Genap aktif)');
        $this->command->info('  • 6 class term (3 ganjil + 3 genap)');
        $this->command->info('  • 6 mata pelajaran, 3 ekstrakurikuler, 5 konseling');
        $this->command->info('  • Jadwal kelas (Senin-Jumat) untuk semua class term');
        $this->command->info('  • Jadwal kegiatan (3 ganjil + 4 genap) per kelas');
        $this->command->info('  • 6 sample jadwal konseling privat');
    }

    /* ══════════════════════════════════════════════════════════════
     *  DATA SISWA — dari dokumen resmi sekolah
     * ══════════════════════════════════════════════════════════════ */
    private function getSiswaData(): array
    {
        return [
            // ── KELAS A (11 siswa) ──────────────────────────────────
            ['kelas' => 'A', 'nis' => '121', 'nisn' => '3202858632', 'name' => 'ALVARO ATHAYA ARIYUN', 'gender' => 'L',
             'pob' => 'Bandar Lampung', 'dob' => '2020-11-07', 'nik' => '1871140711200001',
             'address' => 'Jl Untung Suropati LK II', 'phone' => '081271459987',
             'ayah_nama' => 'Ari Kristianto', 'ayah_kerja' => 'Wiraswasta',
             'ibu_nama' => 'Nurwahyuni', 'ibu_kerja' => 'Tidak bekerja'],

            ['kelas' => 'A', 'nis' => '144', 'nisn' => '3201575054', 'name' => 'M. RAFFA ALFATIH AFRIYADI', 'gender' => 'L',
             'pob' => 'Solo', 'dob' => '2020-11-22', 'nik' => '1871102211200001',
             'address' => 'Jl. Untung Suropati Gg Harum No 65', 'phone' => '085273678410',
             'ayah_nama' => 'Ujang Afriyadi', 'ayah_kerja' => 'Wiraswasta',
             'ibu_nama' => 'Diana Utami Putri Apandi', 'ibu_kerja' => 'Tidak bekerja'],

            ['kelas' => 'A', 'nis' => null, 'nisn' => '3219058996', 'name' => 'MAHENDRA ANDRIAN', 'gender' => 'L',
             'pob' => 'Bandar Lampung', 'dob' => '2021-03-10', 'nik' => '1871141003210001',
             'address' => 'Komp. Perum Pancabakti No 63',
             'ayah_nama' => 'Andrian Suryana', 'ayah_kerja' => 'Karyawan Swasta',
             'ibu_nama' => 'Kencana Wulan Sari', 'ibu_kerja' => 'Tidak bekerja'],

            ['kelas' => 'A', 'nis' => '148', 'nisn' => '3203532466', 'name' => 'MUHAMMAD AMMAR FADHILAH', 'gender' => 'L',
             'pob' => 'Bandar Lampung', 'dob' => '2020-12-03', 'nik' => '1871140312200001',
             'address' => 'JL. WIJAYA KUSUMA PANCA BAKTI NO. 8 LK. II', 'phone' => '089529894444',
             'ayah_nama' => 'Alek Efendi', 'ayah_kerja' => 'Lainnya',
             'ibu_nama' => 'Anggraeni Dwi Puspitasari', 'ibu_kerja' => 'Lainnya'],

            ['kelas' => 'A', 'nis' => '145', 'nisn' => '3205821892', 'name' => 'MUHAMMAD MIKAIL WIJAYA', 'gender' => 'L',
             'pob' => 'Bandar Lampung', 'dob' => '2020-10-22', 'nik' => '1871142210200001',
             'address' => 'Jl Untung Suropati Gg Tanjung No 179 LK II', 'phone' => '081990518952',
             'ayah_nama' => 'Indra Wijaya', 'ayah_kerja' => 'Karyawan Swasta',
             'ibu_nama' => 'Qonaatul Choiro', 'ibu_kerja' => 'Tidak bekerja'],

            ['kelas' => 'A', 'nis' => '133', 'nisn' => '3211693324', 'name' => 'MUHAMMAD ZABDAN ANDRIAN', 'gender' => 'L',
             'pob' => 'Bandar Lampung', 'dob' => '2021-03-18', 'nik' => '1871141803210003',
             'address' => 'KOMP. P PANCA BAKTI GG. TANJUNG LK III', 'phone' => '082176151536',
             'ayah_nama' => 'Herri Adinata', 'ayah_kerja' => 'PNS/TNI/Polri',
             'ibu_nama' => 'Indah Putri Agustina', 'ibu_kerja' => 'PNS/TNI/Polri'],

            ['kelas' => 'A', 'nis' => '146', 'nisn' => '3201201694', 'name' => 'REINA MECCA KURNIAWAN', 'gender' => 'P',
             'pob' => 'Bandar Lampung', 'dob' => '2020-10-19', 'nik' => '1871145910200002',
             'address' => 'JL. BUMI MANTI GG. SURYA KENCANA NO.21 LK I', 'phone' => '082175824510',
             'ayah_nama' => 'Ari Kurniawan Saputra', 'ayah_kerja' => 'Karyawan Swasta',
             'ibu_nama' => 'Cahyani Mutiara Wan P', 'ibu_kerja' => 'Karyawan Swasta'],

            ['kelas' => 'A', 'nis' => null, 'nisn' => '3218872635', 'name' => 'YUKI MAHARANI', 'gender' => 'P',
             'pob' => 'Lampung Barat', 'dob' => '2021-03-21', 'nik' => '1804116103210001',
             'address' => 'Jl Untung Suropati Gg Dahlia',
             'ayah_nama' => 'Hendriawan', 'ayah_kerja' => 'Wiraswasta',
             'ibu_nama' => 'Diana Febriana', 'ibu_kerja' => 'Tidak bekerja'],

            ['kelas' => 'A', 'nis' => '147', 'nisn' => '3208775515', 'name' => 'ZEVANYA KIMBERLY', 'gender' => 'P',
             'pob' => 'Bandar Lampung', 'dob' => '2020-09-25', 'nik' => '1871146509200001',
             'address' => 'JL UNTUNG SUROPATI GG RUKUN II LK II',
             'ayah_nama' => 'Adi Setiawan', 'ayah_kerja' => 'Buruh',
             'ibu_nama' => 'Indah Wahyu Setiawati', 'ibu_kerja' => 'Tidak bekerja'],

            ['kelas' => 'A', 'nis' => '149', 'nisn' => null, 'name' => 'ERLANGGA PRADIPTA BIMANTARA', 'gender' => 'L',
             'pob' => 'Bandar Lampung', 'dob' => '2021-09-25', 'nik' => '1802052509210003',
             'address' => 'Jl Untung Suropati',
             'ayah_nama' => 'Sudirman', 'ayah_kerja' => 'Wiraswasta',
             'ibu_nama' => 'Julia Sari', 'ibu_kerja' => 'IRT'],

            ['kelas' => 'A', 'nis' => '150', 'nisn' => null, 'name' => 'ISHKA AGNIA', 'gender' => 'P',
             'pob' => 'Bandar Lampung', 'dob' => '2022-06-10', 'nik' => '1871145006220002',
             'address' => 'Perum Pancabakti No.95',
             'ayah_nama' => 'Radi Aditama Sanjaya', 'ayah_kerja' => 'Karyawan Swasta',
             'ibu_nama' => 'Nuraini', 'ibu_kerja' => 'Guru'],

            // ── KELAS B1 (14 siswa) ─────────────────────────────────
            ['kelas' => 'B1', 'nis' => '119', 'nisn' => '3193713608', 'name' => 'ABIL ALTAIR ERDHAFEN', 'gender' => 'L',
             'pob' => 'Bandar Lampung', 'dob' => '2019-12-03', 'nik' => '1871140312190001',
             'address' => 'JL. UNTUNG SUROPATI PANCA BAKTI NO 61 LK I', 'phone' => '082282746766',
             'ayah_nama' => 'Erpandi', 'ayah_kerja' => 'Buruh',
             'ibu_nama' => 'Jumiati', 'ibu_kerja' => 'Tidak bekerja'],

            ['kelas' => 'B1', 'nis' => '120', 'nisn' => '3196671765', 'name' => 'AISYAH PUTRI INAYAH', 'gender' => 'P',
             'pob' => 'Bandar Lampung', 'dob' => '2019-10-25', 'nik' => '1871146510190001',
             'address' => 'JL UNTUNG SUROPATI GG RUKUN 4 LK. II', 'phone' => '089561006419',
             'ayah_nama' => 'Hendri Nopriyanto', 'ayah_kerja' => 'Buruh',
             'ibu_nama' => 'Soraya', 'ibu_kerja' => 'Tidak bekerja'],

            ['kelas' => 'B1', 'nis' => '122', 'nisn' => '3207566962', 'name' => 'AKSYAHRA VYANTA HUMAIRA MECCA', 'gender' => 'P',
             'pob' => 'Tulang Bawang', 'dob' => '2020-03-21', 'nik' => '1811046103200001',
             'address' => 'Jl Raja Ratu Gg Sejahtera 2', 'phone' => '082280041105',
             'ayah_nama' => 'Akbar Syah Putra', 'ayah_kerja' => 'Karyawan Swasta',
             'ibu_nama' => 'Fina Alfianita Sari', 'ibu_kerja' => 'Wiraswasta'],

            ['kelas' => 'B1', 'nis' => '125', 'nisn' => '3208035104', 'name' => 'AQILA ZALFA HASANAH', 'gender' => 'P',
             'pob' => 'Bandar Lampung', 'dob' => '2020-01-14', 'nik' => '1871165401200001',
             'address' => 'JL. UNTUNG SUROPATI GG. FAMILY 6', 'phone' => '083863766583',
             'ayah_nama' => 'Hasan Nudin', 'ayah_kerja' => 'Buruh',
             'ibu_nama' => 'Aulia Bunga Safitri', 'ibu_kerja' => 'Tidak bekerja'],

            ['kelas' => 'B1', 'nis' => '127', 'nisn' => '3191726611', 'name' => 'ARSYILA RAFIFAH ADELIA', 'gender' => 'P',
             'pob' => 'Bandar Lampung', 'dob' => '2019-11-27', 'nik' => '1871146711190001',
             'address' => 'JL UNTUNG SUROPATI GG RAJA RATU LK I', 'phone' => '089570066040',
             'ayah_nama' => 'Juliyanto', 'ayah_kerja' => 'Wiraswasta',
             'ibu_nama' => 'Apriliyawati', 'ibu_kerja' => 'Tidak bekerja'],

            ['kelas' => 'B1', 'nis' => '123', 'nisn' => '3198334668', 'name' => 'ATHALLA MAHER', 'gender' => 'L',
             'pob' => 'Bogor', 'dob' => '2019-12-28', 'nik' => '3271062812190005',
             'address' => 'JL WIJAYA KUSUMA GG MATAHARI 4', 'phone' => '0895618980507',
             'ayah_nama' => 'Janssen Cahyadi', 'ayah_kerja' => 'Karyawan Swasta',
             'ibu_nama' => 'Putri Syadza Sausan', 'ibu_kerja' => 'Tidak bekerja'],

            ['kelas' => 'B1', 'nis' => '128', 'nisn' => '3199983429', 'name' => 'CHEISYA SALSABILA', 'gender' => 'P',
             'pob' => 'Bandar Lampung', 'dob' => '2019-12-25', 'nik' => '1871146512190001',
             'address' => 'Jl. Untung Suropati P. Bakti Gg. asoka no 94 LK III',
             'ayah_nama' => 'Beny Septianto', 'ayah_kerja' => 'Karyawan Swasta',
             'ibu_nama' => 'Vivi Selvia Athaga', 'ibu_kerja' => 'Tidak bekerja'],

            ['kelas' => 'B1', 'nis' => '130', 'nisn' => '3192155289', 'name' => 'DEWI HAFIZAH IRWANA', 'gender' => 'P',
             'pob' => 'Bandar Lampung', 'dob' => '2019-06-30', 'nik' => '1871027006190002',
             'address' => 'JL WIJAYA KUSUMA PERUM PANCABAKTI LK II', 'phone' => '081331323806',
             'ayah_nama' => 'Irawan Suki', 'ayah_kerja' => 'Karyawan Swasta',
             'ibu_nama' => 'Irna Wati', 'ibu_kerja' => 'Karyawan Swasta'],

            ['kelas' => 'B1', 'nis' => '129', 'nisn' => '3195197158', 'name' => 'DIRGA ANDRIAN', 'gender' => 'L',
             'pob' => 'Bandar Lampung', 'dob' => '2019-12-17', 'nik' => '1871141712190003',
             'address' => 'Komp Perum Pancabakti No 63', 'phone' => '088286242966',
             'ayah_nama' => 'Andrian Suryana', 'ayah_kerja' => 'Karyawan Swasta',
             'ibu_nama' => 'Kencana Wulan Sari', 'ibu_kerja' => 'Tidak bekerja'],

            ['kelas' => 'B1', 'nis' => '131', 'nisn' => '3193605334', 'name' => 'MARYAM GEBRINA KUSUMA', 'gender' => 'P',
             'pob' => 'Bandar Lampung', 'dob' => '2019-09-14', 'nik' => '1871175409190001',
             'address' => 'JL FLAMBOYAN GG.SADAR NO.8 LK.II', 'phone' => '083866483095',
             'ayah_nama' => 'Aria Kusuma', 'ayah_kerja' => 'Wiraswasta',
             'ibu_nama' => 'Puji Saka Anggraini', 'ibu_kerja' => 'Tidak bekerja'],

            ['kelas' => 'B1', 'nis' => '137', 'nisn' => '3199561634', 'name' => 'REYHAN ALFA RISKI', 'gender' => 'L',
             'pob' => 'Bandar Lampung', 'dob' => '2019-09-14', 'nik' => '1871111409190002',
             'address' => 'JL.S.HATTA GG.PEPAYA I NO.20',
             'ayah_nama' => 'Thoni Riswandi', 'ayah_kerja' => 'Buruh',
             'ibu_nama' => 'Sutinah', 'ibu_kerja' => 'Tidak bekerja'],

            ['kelas' => 'B1', 'nis' => '141', 'nisn' => '3206973252', 'name' => 'SYAFIQ RADEVA VERDIANTO', 'gender' => 'L',
             'pob' => 'Bandar Lampung', 'dob' => '2020-03-31', 'nik' => '1871143103200004',
             'address' => 'Jl Untung Suropati Gg Rukun 2 LK II',
             'ayah_nama' => 'Jefriyanto', 'ayah_kerja' => 'Karyawan Swasta',
             'ibu_nama' => 'Febri Ratna Sari', 'ibu_kerja' => 'Tidak bekerja'],

            ['kelas' => 'B1', 'nis' => '142', 'nisn' => '3207434745', 'name' => 'TEGUH SATRIA', 'gender' => 'L',
             'pob' => 'Bandar Lampung', 'dob' => '2020-01-31', 'nik' => '1871143101200001',
             'address' => 'JL UNTUNG SUROPATI GG RUKUN I LK I', 'phone' => '089532316075',
             'ayah_nama' => 'Endi Hermawan', 'ayah_kerja' => 'Buruh',
             'ibu_nama' => 'Umiga Utami', 'ibu_kerja' => 'Karyawan Swasta'],

            ['kelas' => 'B1', 'nis' => '143', 'nisn' => '3191730870', 'name' => 'WILDAN AMRILAH', 'gender' => 'L',
             'pob' => 'Bandar Lampung', 'dob' => '2019-04-11', 'nik' => '1871141104190003',
             'address' => 'JL UNTUNG SUROPATI GG MAKARTI LK II', 'phone' => '081274811062',
             'ayah_nama' => 'Yana Rodiana', 'ayah_kerja' => 'Buruh',
             'ibu_nama' => 'Usniawati', 'ibu_kerja' => 'Tidak bekerja'],

            // ── KELAS B2 (11 siswa) ─────────────────────────────────
            ['kelas' => 'B2', 'nis' => null, 'nisn' => '3200671971', 'name' => 'ANDHANU RHADITYA', 'gender' => 'L',
             'pob' => 'Bandar Lampung', 'dob' => '2020-03-01', 'nik' => '1871140103200002',
             'address' => 'Jl Wijaya Kusuma Komp Pancabakti Gg Matahari LK II',
             'ayah_nama' => 'Slamet Riyadi Dame', 'ayah_kerja' => 'Wiraswasta',
             'ibu_nama' => 'Evi Haryanti', 'ibu_kerja' => 'Tidak bekerja'],

            ['kelas' => 'B2', 'nis' => null, 'nisn' => '3201524080', 'name' => 'ANDHARU ADITYA', 'gender' => 'L',
             'pob' => 'Bandar Lampung', 'dob' => '2020-03-01', 'nik' => '1871140103200001',
             'address' => 'Jl Wijaya Kusuma Komp Pancabakti Gg Matahari VII LK II',
             'ayah_nama' => 'Slamet Riyadi Dame', 'ayah_kerja' => 'Wiraswasta',
             'ibu_nama' => 'Evi Haryanti', 'ibu_kerja' => 'Tidak bekerja'],

            ['kelas' => 'B2', 'nis' => '124', 'nisn' => '3200846419', 'name' => 'ANINDIRA CHAYRA PRATISTA', 'gender' => 'P',
             'pob' => 'Bandar Lampung', 'dob' => '2020-04-09', 'nik' => '1871144904200001',
             'address' => 'JL. UNTUNG SUROPATI GG. SEPAKAT NO 1A LK II', 'phone' => '085758922300',
             'ayah_nama' => 'Andri Hadi', 'ayah_kerja' => 'Wiraswasta',
             'ibu_nama' => 'Menik Anjarwati', 'ibu_kerja' => 'Tidak bekerja'],

            ['kelas' => 'B2', 'nis' => '126', 'nisn' => null, 'name' => 'ARRASYA NATHANAEL WIDIANTO', 'gender' => 'L',
             'pob' => 'Bandar Lampung', 'dob' => '2019-11-13', 'nik' => '1871051311190005',
             'address' => 'JL. SRIKRESNA GG. WARU 20', 'phone' => '08988142292',
             'ayah_nama' => 'Al Roy Triwidianto', 'ayah_kerja' => 'Karyawan Swasta',
             'ibu_nama' => 'Putri Meika Andriani', 'ibu_kerja' => 'Tidak bekerja'],

            ['kelas' => 'B2', 'nis' => '132', 'nisn' => '3209801539', 'name' => 'KHAIRA NADHIFA SATRIYA JASA', 'gender' => 'P',
             'pob' => 'Bandar Lampung', 'dob' => '2020-02-18', 'nik' => '1871105802200001',
             'address' => 'JL. SRIKRISNA KP BAYUR', 'phone' => '081274568944',
             'ayah_nama' => 'Joni Satriya', 'ayah_kerja' => 'Karyawan Swasta',
             'ibu_nama' => 'Fizri Via Agustina', 'ibu_kerja' => 'Tidak bekerja'],

            ['kelas' => 'B2', 'nis' => '134', 'nisn' => '3196466268', 'name' => 'LUTHPI HASBI', 'gender' => 'L',
             'pob' => 'Simalungun', 'dob' => '2019-08-09', 'nik' => '1208030908190001',
             'address' => 'Jl Soekarno Hatta LK I',
             'ayah_nama' => 'Nazarudin', 'ayah_kerja' => 'Wiraswasta',
             'ibu_nama' => 'Tio Dorma Silalahi', 'ibu_kerja' => 'Tidak bekerja'],

            ['kelas' => 'B2', 'nis' => '138', 'nisn' => '3209376025', 'name' => 'NAUFAL RAMADHAN', 'gender' => 'L',
             'pob' => 'Gunung Sugih Besar', 'dob' => '2020-05-01', 'nik' => '3603020105200002',
             'address' => 'Kampung Baru', 'phone' => '085269119394',
             'ayah_nama' => 'Ahmad Yani', 'ayah_kerja' => 'Wiraswasta',
             'ibu_nama' => 'Ela Lastari', 'ibu_kerja' => 'Tidak bekerja'],

            ['kelas' => 'B2', 'nis' => '135', 'nisn' => '3202483333', 'name' => 'NAYLA NANDA PUTRI', 'gender' => 'P',
             'pob' => 'Bandar Lampung', 'dob' => '2020-03-23', 'nik' => '1871146303200002',
             'address' => 'JL UNTUNG SUROPATI GG RAJA RATU LK I', 'phone' => '081532722932',
             'ayah_nama' => 'Somad Pinanda', 'ayah_kerja' => 'Petani',
             'ibu_nama' => 'Tuti Maryati', 'ibu_kerja' => 'Tidak bekerja'],

            ['kelas' => 'B2', 'nis' => '139', 'nisn' => '3206861787', 'name' => 'RENATA ARSY SUSILO', 'gender' => 'P',
             'pob' => 'Bandar Lampung', 'dob' => '2020-04-30', 'nik' => '1871147004200001',
             'address' => 'Jl Untung Suropati Gg Tanjung No 20', 'phone' => '081231087001',
             'ayah_nama' => 'Ari Susilo', 'ayah_kerja' => 'Karyawan Swasta',
             'ibu_nama' => 'Faradillah Chairunnisa', 'ibu_kerja' => 'Tidak bekerja'],

            ['kelas' => 'B2', 'nis' => '140', 'nisn' => '3208144690', 'name' => 'SALAHUDDIN KAHFI PRAWIRANEGARA', 'gender' => 'L',
             'pob' => 'Bandar Lampung', 'dob' => '2020-01-02', 'nik' => '1871140201200001',
             'address' => 'Jl Wijaya Kusuma Gg Mawar Perum Golden Green Estate LK II', 'phone' => '081379014810',
             'ayah_nama' => 'Agung Setiawan', 'ayah_kerja' => 'Karyawan Swasta',
             'ibu_nama' => 'Ika Kusumawardani', 'ibu_kerja' => 'Karyawan Swasta'],

            ['kelas' => 'B2', 'nis' => '136', 'nisn' => '3192524958', 'name' => 'SHEZAN NAILA SALSABILA', 'gender' => 'P',
             'pob' => 'Bandar Lampung', 'dob' => '2019-11-29', 'nik' => '1871146911190001',
             'address' => 'JL WIJAYA KUSUMA GG TANJUNG NO 174 LK II', 'phone' => '089644228742',
             'ayah_nama' => 'Muhamad Rizki', 'ayah_kerja' => 'Karyawan Swasta',
             'ibu_nama' => 'Dini Oktavianti', 'ibu_kerja' => 'Karyawan Swasta'],
        ];
    }
}
