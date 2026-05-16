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
        /* ── 1. USER ─────────────────── */
        // Kepala Sekolah (sekaligus admin sistem)
        $admin = User::create([
            'name'       => 'Baini, S.Pd',
            'email'      => 'baini.kepsek@tkalistiqomah.sch.id',
            'password'   => Hash::make('password'),
            'phone'      => '081200000000',
            'role'       => 'admin',
            'status'     => 'aktif',
            'isGraduate' => false,
        ]);

        // Guru Kelas A — Reita Wigianti, S.Si, S.Pd., Gr (NUPTK. 7760760661130212)
        $guruA = User::create([
            'name'       => 'Reita Wigianti, S.Si, S.Pd., Gr',
            'email'      => 'reita.wigianti@tkalistiqomah.sch.id',
            'password'   => Hash::make('password'),
            'phone'      => '081211111111',
            'role'       => 'guru',
            'status'     => 'aktif',
            'isGraduate' => false,
        ]);

        // Guru Kelas B1 — Lucia Untari, S.Pd (NIP. 196501131986052003)
        $guruB1 = User::create([
            'name'       => 'Lucia Untari, S.Pd',
            'email'      => 'lucia.untari@tkalistiqomah.sch.id',
            'password'   => Hash::make('password'),
            'phone'      => '081222222222',
            'role'       => 'guru',
            'status'     => 'aktif',
            'isGraduate' => false,
        ]);

        // Guru Kelas B2 — Fitriyah Hariani, S.Pd (NUPTK. 6344752654300063)
        $guruB2 = User::create([
            'name'       => 'Fitriyah Hariani, S.Pd',
            'email'      => 'fitriyah.hariani@tkalistiqomah.sch.id',
            'password'   => Hash::make('password'),
            'phone'      => '081233333333',
            'role'       => 'guru',
            'status'     => 'aktif',
            'isGraduate' => false,
        ]);

        // Alias kompatibilitas untuk kode lama
        $guru1 = $guruA;
        $guru2 = $guruB1;

        // Orang tua dummy (sample)
        $ortu1 = User::create([
            'name'       => 'Ibu Siti Aminah',
            'email'      => 'ibu.siti@example.com',
            'password'   => Hash::make('password'),
            'phone'      => '081244444444',
            'role'       => 'orangtua',
            'status'     => 'aktif',
            'isGraduate' => false,
        ]);

        $ortu2 = User::create([
            'name'       => 'Bapak Budi',
            'email'      => 'bapak.budi@example.com',
            'password'   => Hash::make('password'),
            'phone'      => '081255555555',
            'role'       => 'orangtua',
            'status'     => 'aktif',
            'isGraduate' => false,
        ]);

        /* ── 2. CLASS ─────────────────── */
        $kelasA1 = Classroom::create(['name' => 'A1', 'maximum' => 20]);
        $kelasB1 = Classroom::create(['name' => 'B1', 'maximum' => 20]);
        $kelasB2 = Classroom::create(['name' => 'B2', 'maximum' => 18]);

        /* ── 3. ACADEMIC TERM ─────────────────── */
        $taGanjil = AcademicTerm::create(['academic_year' => '2025/2026', 'semester' => 'ganjil']);
        $taGenap  = AcademicTerm::create(['academic_year' => '2024/2025', 'semester' => 'genap']);

        /* ── 4. CLASS TERM ─────────────────── */
        $ctA1Ganjil = ClassTerm::create(['class_id' => $kelasA1->id, 'academic_term_id' => $taGanjil->id, 'isPass' => false]);
        $ctB1Ganjil = ClassTerm::create(['class_id' => $kelasB1->id, 'academic_term_id' => $taGanjil->id, 'isPass' => false]);
        $ctB2Ganjil = ClassTerm::create(['class_id' => $kelasB2->id, 'academic_term_id' => $taGanjil->id, 'isPass' => false]);
        $ctA1Genap  = ClassTerm::create(['class_id' => $kelasA1->id, 'academic_term_id' => $taGenap->id,  'isPass' => true]);

        /* ── 5. STUDENT ─────────────────── */
        $siswa1 = Student::create([
            'user_id'        => null,
            'name'           => 'Ahmad Fauzi',
            'gender'         => 'L',
            'nis'            => '2025001',
            'nisn'           => '0123456789',
            'pob'            => 'Bandar Lampung',
            'dob'            => '2020-05-15',
            'nik'            => '1871010505200001',
            'address'        => 'Jl. Merdeka No. 1',
            'phone'          => '081255555555',
            'religion'       => 'islam',
            'birth_order'    => 1,
            'siblings_count' => 1,
            'ethnicity'      => 'Jawa',
            'nickname'       => 'Fauzi',
        ]);

        $siswa2 = Student::create([
            'name'           => 'Siti Nurhaliza',
            'gender'         => 'P',
            'nis'            => '2025002',
            'pob'            => 'Bandar Lampung',
            'dob'            => '2020-08-20',
            'religion'       => 'islam',
            'birth_order'    => 2,
            'siblings_count' => 3,
            'nickname'       => 'Hali',
        ]);

        $siswa3 = Student::create([
            'name'     => 'Budi Santoso',
            'gender'   => 'L',
            'nis'      => '2025003',
            'pob'      => 'Metro',
            'dob'      => '2019-11-10',
            'religion' => 'islam',
            'nickname' => 'Budi',
        ]);

        /* ── 6. PARENT ─────────────────── */
        Parents::create([
            'student_id' => $siswa1->id, 'category' => 'ibu',  'name' => 'Ibu Siti Aminah', 'work' => 'Ibu Rumah Tangga',
        ]);
        Parents::create([
            'student_id' => $siswa1->id, 'category' => 'ayah', 'name' => 'Bapak Suparto',  'work' => 'PNS',
        ]);
        Parents::create([
            'student_id' => $siswa2->id, 'category' => 'ibu',  'name' => 'Ibu Maryam',     'work' => 'Wiraswasta',
        ]);
        Parents::create([
            'student_id' => $siswa3->id, 'category' => 'ayah', 'name' => 'Bapak Budiyono', 'work' => 'Buruh',
        ]);

        /* ── 7. STUDENT ENROLLMENT ─────────────────── */
        StudentEnrollment::create(['student_id' => $siswa1->id, 'class_term_id' => $ctA1Ganjil->id, 'status' => 'aktif']);
        StudentEnrollment::create(['student_id' => $siswa2->id, 'class_term_id' => $ctA1Ganjil->id, 'status' => 'aktif']);
        StudentEnrollment::create(['student_id' => $siswa3->id, 'class_term_id' => $ctB1Ganjil->id, 'status' => 'aktif']);

        /* ── 8. SUBJECT ─────────────────── */
        $subjects = [];
        foreach ([
            'Pendidikan Agama Islam', 'Sentra Balok', 'Sentra Bahan Alam',
            'Sentra Seni', 'Sentra Peran', 'Bahasa Indonesia',
            'Berhitung', 'Menyanyi & Musik', 'Senam & Olahraga',
        ] as $name) {
            $subjects[] = Subject::create(['name' => $name]);
        }

        /* ── 9. EXTRACURRICULAR + ASSESSMENTS ─────────────────── */
        $ekMenari = Extracurricular::create(['name' => 'Menari']);
        ExtracurricularAssessment::create(['extracurricular_id' => $ekMenari->id, 'name' => 'Kelenturan']);
        ExtracurricularAssessment::create(['extracurricular_id' => $ekMenari->id, 'name' => 'Ekspresi']);
        ExtracurricularAssessment::create(['extracurricular_id' => $ekMenari->id, 'name' => 'Hafalan Gerakan']);

        $ekMewarnai = Extracurricular::create(['name' => 'Mewarnai']);
        ExtracurricularAssessment::create(['extracurricular_id' => $ekMewarnai->id, 'name' => 'Kerapian']);
        ExtracurricularAssessment::create(['extracurricular_id' => $ekMewarnai->id, 'name' => 'Kreativitas Warna']);
        ExtracurricularAssessment::create(['extracurricular_id' => $ekMewarnai->id, 'name' => 'Ketepatan Bidang']);

        /* ── 10. COUNSELING + ASSESSMENTS ─────────────────── */
        $konSosial = Counseling::create(['name' => 'Perkembangan Sosial']);
        CounselingAssessment::create(['counseling_id' => $konSosial->id, 'name' => 'Interaksi dengan teman']);
        CounselingAssessment::create(['counseling_id' => $konSosial->id, 'name' => 'Kemampuan berbagi']);
        CounselingAssessment::create(['counseling_id' => $konSosial->id, 'name' => 'Kepatuhan aturan']);

        $konEmosi = Counseling::create(['name' => 'Perkembangan Emosi']);
        CounselingAssessment::create(['counseling_id' => $konEmosi->id, 'name' => 'Mengelola emosi']);
        CounselingAssessment::create(['counseling_id' => $konEmosi->id, 'name' => 'Empati terhadap teman']);

        $konKognitif = Counseling::create(['name' => 'Perkembangan Kognitif']);
        CounselingAssessment::create(['counseling_id' => $konKognitif->id, 'name' => 'Daya tangkap']);
        CounselingAssessment::create(['counseling_id' => $konKognitif->id, 'name' => 'Kreativitas berpikir']);

        /* ── 11. CLASS TERM × SUBJECT / EKSKUL / KONSELING ─────────────────── */
        // Subject: semua mata pelajaran ke ctA1Ganjil
        foreach ($subjects as $sub) {
            ClassTermSubject::create(['class_term_id' => $ctA1Ganjil->id, 'subject_id' => $sub->id]);
        }
        // 5 mata pelajaran pertama ke ctB1Ganjil
        foreach (array_slice($subjects, 0, 5) as $sub) {
            ClassTermSubject::create(['class_term_id' => $ctB1Ganjil->id, 'subject_id' => $sub->id]);
        }

        // Ekskul: Menari & Mewarnai ke A1, B1
        foreach ([$ctA1Ganjil, $ctB1Ganjil] as $ct) {
            ClassTermExtracurricular::create(['class_term_id' => $ct->id, 'extracurricular_id' => $ekMenari->id]);
            ClassTermExtracurricular::create(['class_term_id' => $ct->id, 'extracurricular_id' => $ekMewarnai->id]);
        }

        // Konseling: semua 3 group ke A1 Ganjil, 2 group ke B1
        foreach ([$konSosial, $konEmosi, $konKognitif] as $kon) {
            ClassTermCounseling::create(['class_term_id' => $ctA1Ganjil->id, 'counseling_id' => $kon->id]);
        }
        foreach ([$konSosial, $konEmosi] as $kon) {
            ClassTermCounseling::create(['class_term_id' => $ctB1Ganjil->id, 'counseling_id' => $kon->id]);
        }

        /* ── 12. CLASS SCHEDULE ─────────────────── */
        // Senin = 1 ... Jumat = 5
        ClassSchedule::create(['class_term_id' => $ctA1Ganjil->id, 'name' => 'Pembukaan & Doa', 'day' => 1, 'hour' => '07:30 - 08:00']);
        ClassSchedule::create(['class_term_id' => $ctA1Ganjil->id, 'name' => 'Sentra Balok',     'day' => 1, 'hour' => '08:00 - 09:00']);
        ClassSchedule::create(['class_term_id' => $ctA1Ganjil->id, 'name' => 'Motorik Halus',    'day' => 1, 'hour' => '09:00 - 10:00']);
        ClassSchedule::create(['class_term_id' => $ctA1Ganjil->id, 'name' => 'Senam Pagi',       'day' => 2, 'hour' => '07:30 - 08:00']);
        ClassSchedule::create(['class_term_id' => $ctA1Ganjil->id, 'name' => 'Sentra Seni',      'day' => 2, 'hour' => '08:00 - 09:00']);

        /* ── 13. ACTIVITY SCHEDULE ─────────────────── */
        ActivitySchedule::create([
            'class_term_id' => $ctA1Ganjil->id,
            'name'          => 'Upacara Bendera',
            'date'          => '2026-03-10',
            'hour'          => '07:00 - 08:00',
            'location'      => 'Lapangan',
            'description'   => 'Upacara rutin Senin',
        ]);
        ActivitySchedule::create([
            'class_term_id' => $ctA1Ganjil->id,
            'name'          => 'Outing Class',
            'date'          => '2026-03-12',
            'hour'          => '08:00 - 12:00',
            'location'      => 'Kebun Binatang',
            'description'   => 'Kunjungan tematik',
        ]);

        /* ── 14. PRIVATE COUNSELING SCHEDULE ─────────────────── */
        PrivateCounselingSchedule::create([
            'student_id'    => $siswa1->id,
            'teacher_id'    => $guru1->id,
            'class_term_id' => $ctA1Ganjil->id,
            'status'        => 'disetujui',
            'date'          => '2026-03-05',
            'start_hour'    => '09:00:00',
            'end_hour'      => '10:00:00',
            'topic'         => 'Perkembangan Sosial',
        ]);
        PrivateCounselingSchedule::create([
            'student_id'    => $siswa2->id,
            'teacher_id'    => $guru2->id,
            'class_term_id' => $ctA1Ganjil->id,
            'status'        => 'pending',
            'date'          => '2026-03-07',
            'start_hour'    => '10:00:00',
            'end_hour'      => '11:00:00',
            'topic'         => 'Konsultasi Umum',
        ]);

        $this->command->info('✓ ERD Seeder selesai — 5 user, 3 kelas, 4 class_term, 3 siswa, 9 mapel, 2 ekskul, 3 konseling, 5 jadwal kelas, 2 kegiatan, 2 jadwal konseling.');
    }
}
