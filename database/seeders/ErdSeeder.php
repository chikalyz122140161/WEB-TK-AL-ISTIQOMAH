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
use Illuminate\Support\Str;

class ErdSeeder extends Seeder
{
    public function run(): void
    {
        /* ── 1. USER (Kepala Sekolah + Guru) ─────────────────── */
        $admin = User::create([
            'name'       => 'Baini, S.Pd',
            'email'      => 'baini.kepsek@tkalistiqomah.sch.id',
            'password'   => Hash::make('password'),
            'phone'      => '081200000000',
            'role'       => 'admin',
            'status'     => 'aktif',
            'isGraduate' => false,
        ]);

        $guruA = User::create([
            'name'       => 'Reita Wigianti, S.Si, S.Pd., Gr',
            'email'      => 'reita.wigianti@tkalistiqomah.sch.id',
            'password'   => Hash::make('password'),
            'phone'      => '081211111111',
            'role'       => 'guru',
            'status'     => 'aktif',
            'isGraduate' => false,
        ]);

        $guruB1 = User::create([
            'name'       => 'Lucia Untari, S.Pd',
            'email'      => 'lucia.untari@tkalistiqomah.sch.id',
            'password'   => Hash::make('password'),
            'phone'      => '081222222222',
            'role'       => 'guru',
            'status'     => 'aktif',
            'isGraduate' => false,
        ]);

        $guruB2 = User::create([
            'name'       => 'Fitriyah Hariani, S.Pd',
            'email'      => 'fitriyah.hariani@tkalistiqomah.sch.id',
            'password'   => Hash::make('password'),
            'phone'      => '081233333333',
            'role'       => 'guru',
            'status'     => 'aktif',
            'isGraduate' => false,
        ]);

        /* ── 2. CLASS ─────────────────── */
        $kelasA  = Classroom::create(['name' => 'A',  'maximum' => 20]);
        $kelasB1 = Classroom::create(['name' => 'B1', 'maximum' => 20]);
        $kelasB2 = Classroom::create(['name' => 'B2', 'maximum' => 20]);

        /* ── 3. ACADEMIC TERM ─────────────────── */
        $taGanjil = AcademicTerm::create(['academic_year' => '2025/2026', 'semester' => 'ganjil']);
        $taGenap  = AcademicTerm::create(['academic_year' => '2024/2025', 'semester' => 'genap']);

        /* ── 4. CLASS TERM ─────────────────── */
        $ctA  = ClassTerm::create(['class_id' => $kelasA->id,  'academic_term_id' => $taGanjil->id, 'isPass' => false]);
        $ctB1 = ClassTerm::create(['class_id' => $kelasB1->id, 'academic_term_id' => $taGanjil->id, 'isPass' => false]);
        $ctB2 = ClassTerm::create(['class_id' => $kelasB2->id, 'academic_term_id' => $taGanjil->id, 'isPass' => false]);

        $kelasMap = [
            'A'  => ['classroom' => $kelasA,  'class_term' => $ctA],
            'B1' => ['classroom' => $kelasB1, 'class_term' => $ctB1],
            'B2' => ['classroom' => $kelasB2, 'class_term' => $ctB2],
        ];

        /* ── 5. SISWA ─────────────────── */
        $siswaData = $this->getSiswaData();

        foreach ($siswaData as $row) {
            $student = Student::create([
                'name'           => $row['name'],
                'gender'         => $row['gender'],
                'nis'            => $row['nis'],
                'nisn'           => $row['nisn'],
                'pob'            => $row['pob'],
                'dob'            => $row['dob'],
                'nik'            => $row['nik'],
                'address'        => $row['address'],
                'phone'          => $row['phone'] ?? null,
                'religion'       => 'islam',
                'kelas'          => $row['kelas'],
                'nomor_induk'    => $row['nis'],
                'tempat_lahir'   => $row['pob'],
                'birth_date'     => $row['dob'],
                'telepon'        => $row['phone'] ?? null,
                'nama_ayah'      => $row['ayah_nama'] ?? null,
                'pekerjaan_ayah' => $row['ayah_kerja'] ?? null,
                'nama_ibu'       => $row['ibu_nama'] ?? null,
                'pekerjaan_ibu'  => $row['ibu_kerja'] ?? null,
            ]);

            // Enrollment ke class_term sesuai kelas
            StudentEnrollment::create([
                'student_id'    => $student->id,
                'class_term_id' => $kelasMap[$row['kelas']]['class_term']->id,
                'status'        => 'aktif',
            ]);

            // Parent records
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
        }

        /* ── 6. SUBJECT ─────────────────── */
        $subjects = [];
        foreach ([
            'Nilai Agama & Moral', 'Fisik Motorik', 'Kognitif',
            'Bahasa', 'Sosial Emosional', 'Seni',
        ] as $name) {
            $subjects[] = Subject::create(['name' => $name]);
        }

        /* ── 7. EKSTRAKURIKULER ─────────────────── */
        $ekMenari = Extracurricular::create(['name' => 'Menari']);
        foreach (['Kelenturan', 'Ekspresi', 'Hafalan Gerakan'] as $a) {
            ExtracurricularAssessment::create(['extracurricular_id' => $ekMenari->id, 'name' => $a]);
        }
        $ekMewarnai = Extracurricular::create(['name' => 'Mewarnai']);
        foreach (['Kerapian', 'Kreativitas Warna', 'Ketepatan Bidang'] as $a) {
            ExtracurricularAssessment::create(['extracurricular_id' => $ekMewarnai->id, 'name' => $a]);
        }

        /* ── 8. KONSELING ─────────────────── */
        $konSosial = Counseling::create(['name' => 'Perkembangan Sosial']);
        foreach (['Interaksi dengan teman', 'Kemampuan berbagi', 'Kepatuhan aturan'] as $a) {
            CounselingAssessment::create(['counseling_id' => $konSosial->id, 'name' => $a]);
        }
        $konEmosi = Counseling::create(['name' => 'Perkembangan Emosi']);
        foreach (['Mengelola emosi', 'Empati terhadap teman'] as $a) {
            CounselingAssessment::create(['counseling_id' => $konEmosi->id, 'name' => $a]);
        }
        $konKognitif = Counseling::create(['name' => 'Perkembangan Kognitif']);
        foreach (['Daya tangkap', 'Kreativitas berpikir'] as $a) {
            CounselingAssessment::create(['counseling_id' => $konKognitif->id, 'name' => $a]);
        }

        /* ── 9. CLASS TERM × ACTIVITIES ─────────────────── */
        foreach ([$ctA, $ctB1, $ctB2] as $ct) {
            foreach ($subjects as $s) {
                ClassTermSubject::create(['class_term_id' => $ct->id, 'subject_id' => $s->id]);
            }
            foreach ([$ekMenari, $ekMewarnai] as $e) {
                ClassTermExtracurricular::create(['class_term_id' => $ct->id, 'extracurricular_id' => $e->id]);
            }
            foreach ([$konSosial, $konEmosi, $konKognitif] as $k) {
                ClassTermCounseling::create(['class_term_id' => $ct->id, 'counseling_id' => $k->id]);
            }
        }

        $this->command->info('✓ Seeder selesai: 4 user (Kepsek + 3 Guru), 3 kelas, 3 class_term, '
            . count($siswaData) . ' siswa dengan data orang tua.');
    }

    /**
     * Data siswa lengkap dari PDF resmi sekolah.
     */
    private function getSiswaData(): array
    {
        return [
            // ── KELAS A (11 siswa) ──────────────────────────────
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

            // ── KELAS B1 (14 siswa) ─────────────────────────────
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
             'address' => 'JL WIJAYA KUSUMA PERUM PANCABAKTI LK II', 'phone' => '08133132380661',
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
             'address' => 'JL UNTUNG SUROPATI GG RUKUN I LK I', 'phone' => '0895323160753',
             'ayah_nama' => 'Endi Hermawan', 'ayah_kerja' => 'Buruh',
             'ibu_nama' => 'Umiga Utami', 'ibu_kerja' => 'Karyawan Swasta'],

            ['kelas' => 'B1', 'nis' => '143', 'nisn' => '3191730870', 'name' => 'WILDAN AMRILAH', 'gender' => 'L',
             'pob' => 'Bandar Lampung', 'dob' => '2019-04-11', 'nik' => '1871141104190003',
             'address' => 'JL UNTUNG SUROPATI GG MAKARTI LK II', 'phone' => '081274811062',
             'ayah_nama' => 'Yana Rodiana', 'ayah_kerja' => 'Buruh',
             'ibu_nama' => 'Usniawati', 'ibu_kerja' => 'Tidak bekerja'],

            // ── KELAS B2 (11 siswa) ─────────────────────────────
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
             'ayah_nama' => 'Ari Susilo, S.Kom', 'ayah_kerja' => 'Karyawan Swasta',
             'ibu_nama' => 'Faradillah Chairunnisa, S.P', 'ibu_kerja' => 'Tidak bekerja'],

            ['kelas' => 'B2', 'nis' => '140', 'nisn' => '3208144690', 'name' => 'SALAHUDDIN KAHFI PRAWIRANEGARA', 'gender' => 'L',
             'pob' => 'Bandar Lampung', 'dob' => '2020-01-02', 'nik' => '1871140201200001',
             'address' => 'Jl Wijaya Kusuma Gg Mawar Perum Golden Green Estate LK II', 'phone' => '081379014810',
             'ayah_nama' => 'Agung Setiawan, SH. MH', 'ayah_kerja' => 'Karyawan Swasta',
             'ibu_nama' => 'Ika Kusumawardani', 'ibu_kerja' => 'Karyawan Swasta'],

            ['kelas' => 'B2', 'nis' => '136', 'nisn' => '3192524958', 'name' => 'SHEZAN NAILA SALSABILA', 'gender' => 'P',
             'pob' => 'Bandar Lampung', 'dob' => '2019-11-29', 'nik' => '1871146911190001',
             'address' => 'JL WIJAYA KUSUMA GG TANJUNG NO 174 LK II', 'phone' => '089644228742',
             'ayah_nama' => 'Muhamad Rizki', 'ayah_kerja' => 'Karyawan Swasta',
             'ibu_nama' => 'Dini Oktavianti', 'ibu_kerja' => 'Karyawan Swasta'],
        ];
    }
}
