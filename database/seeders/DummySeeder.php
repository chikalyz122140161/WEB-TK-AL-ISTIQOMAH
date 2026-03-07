<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Report;
use App\Models\Schedule;
use App\Models\Chat;
use App\Models\Notification;
use App\Models\Registration;
use App\Models\SemesterReport;

class DummySeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Guru
        $guru = User::create([
            'name' => 'Guru',
            'email' => 'guru@example.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
        ]);

        // Orang Tua
        $parent = User::create([
            'name' => 'Orang Tua',
            'email' => 'ortu@example.com',
            'password' => Hash::make('password'),
            'role' => 'orangtua',
        ]);

        // Siswa
        $student = Student::create([
            'name' => 'Siswa Satu',
            'parent_id' => $parent->id,
            'birth_date' => '2015-01-01',
            'gender' => 'L',
            'address' => 'Jl. Contoh No.1',
        ]);

        // Kehadiran
        Attendance::create([
            'student_id' => $student->id,
            'teacher_id' => $guru->id,
            'date' => now(),
            'status' => 'Hadir',
            'note' => 'Hadir tepat waktu',
        ]);

        // Laporan Perkembangan
        Report::create([
            'student_id' => $student->id,
            'teacher_id' => $guru->id,
            'week_start' => now()->startOfWeek(),
            'cognitive' => 80,
            'motoric' => 85,
            'social' => 90,
            'language' => 88,
            'note' => 'Perkembangan baik',
        ]);

        // Jadwal
        Schedule::create([
            'student_id' => $student->id,
            'teacher_id' => $guru->id,
            'type' => 'bk',
            'date' => now()->addDays(2),
            'description' => 'Konseling mingguan',
        ]);

        // Chat
        Chat::create([
            'sender_id' => $guru->id,
            'receiver_id' => $parent->id,
            'message' => 'Assalamualaikum, ini laporan perkembangan anak Anda.',
            'is_read' => false,
        ]);

        // Notifikasi
        Notification::create([
            'user_id' => $parent->id,
            'message' => 'Laporan perkembangan anak telah diupdate.',
            'read' => false,
        ]);

        // Pendaftaran Siswa Baru
        Registration::create([
            'kode_pendaftaran' => 'REG-' . strtoupper(substr(md5(time()), 0, 6)),
            'nama_lengkap' => 'Siswa Baru',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2020-06-15',
            'jenis_kelamin' => 'L',
            'alamat_siswa' => 'Jl. Contoh No.2, Jakarta',
            'nama_ayah' => 'Ayah Siswa Baru',
            'nama_ibu' => 'Ibu Siswa Baru',
            'pekerjaan_ayah' => 'Wiraswasta',
            'pekerjaan_ibu' => 'Ibu Rumah Tangga',
            'telepon' => '08123456789',
            'email' => 'ortu.baru@example.com',
            'alamat_ortu' => 'Jl. Contoh No.2, Jakarta',
            'status' => 'pending',
        ]);

        // Rapot Semester
        SemesterReport::create([
            'student_id' => $student->id,
            'teacher_id' => $guru->id,
            'tahun_ajaran' => '2025/2026',
            'semester' => 'Ganjil',
            'kelas' => 'TK A',
            'agama_moral' => 'BSH',
            'agama_moral_deskripsi' => 'Anak sudah mampu melaksanakan ibadah sederhana (berdoa sebelum dan sesudah makan), mengenal ciptaan Tuhan, serta menunjukkan sikap santun dan hormat kepada guru dan teman.',
            'fisik_motorik' => 'BSB',
            'fisik_motorik_deskripsi' => 'Anak sangat aktif dalam kegiatan motorik kasar seperti berlari dan melompat. Motorik halus juga berkembang baik, mampu memegang pensil dengan benar dan mewarnai dalam garis.',
            'kognitif' => 'BSH',
            'kognitif_deskripsi' => 'Anak mampu mengenal angka 1-10, menghitung benda konkrit, mengenal warna dasar, dan menyelesaikan puzzle sederhana dengan baik.',
            'bahasa' => 'BSH',
            'bahasa_deskripsi' => 'Anak mampu berkomunikasi dengan jelas, menceritakan pengalaman sederhana, mengenal huruf vokal, dan menyimak cerita dengan antusias.',
            'sosial_emosional' => 'BSH',
            'sosial_emosional_deskripsi' => 'Anak dapat bermain bersama teman, berbagi mainan, mengantri dengan tertib, dan menunjukkan empati ketika teman sedih.',
            'seni' => 'BSB',
            'seni_deskripsi' => 'Anak sangat kreatif dalam kegiatan seni, suka menggambar dan mewarnai, aktif bernyanyi dan mengikuti gerak lagu dengan semangat.',
            'hadir' => 85,
            'izin' => 3,
            'sakit' => 2,
            'alpa' => 0,
            'catatan_guru' => 'Ananda menunjukkan perkembangan yang sangat baik selama semester ini. Aktif dalam setiap kegiatan pembelajaran dan dapat bekerja sama dengan teman-temannya. Perlu terus didukung untuk pengembangan kemampuan bahasa dan kognitifnya.',
            'rekomendasi' => 'Disarankan untuk terus memberikan stimulasi membaca di rumah dengan buku cerita bergambar. Ajak anak berdiskusi tentang lingkungan sekitar untuk meningkatkan kemampuan bahasa dan berpikir kritis.',
            'tanggal_terbit' => now()->subMonths(1),
        ]);

        // Rapot Semester sebelumnya
        SemesterReport::create([
            'student_id' => $student->id,
            'teacher_id' => $guru->id,
            'tahun_ajaran' => '2024/2025',
            'semester' => 'Genap',
            'kelas' => 'TK A',
            'agama_moral' => 'MB',
            'agama_moral_deskripsi' => 'Anak mulai mengenal doa-doa pendek dan menunjukkan sikap sopan santun kepada orang yang lebih tua.',
            'fisik_motorik' => 'BSH',
            'fisik_motorik_deskripsi' => 'Perkembangan motorik kasar baik, dapat berjalan seimbang. Motorik halus masih perlu latihan untuk koordinasi.',
            'kognitif' => 'MB',
            'kognitif_deskripsi' => 'Anak mulai mengenal angka dan warna. Masih perlu bimbingan dalam menyelesaikan tugas berhitung.',
            'bahasa' => 'MB',
            'bahasa_deskripsi' => 'Anak dapat mengungkapkan keinginan dengan kata-kata sederhana. Perlu stimulasi lebih untuk memperkaya kosakata.',
            'sosial_emosional' => 'BSH',
            'sosial_emosional_deskripsi' => 'Anak mulai dapat bermain bersama teman dan menunggu giliran dengan bimbingan.',
            'seni' => 'BSH',
            'seni_deskripsi' => 'Anak senang menggambar dan mewarnai meskipun masih keluar garis. Suka mengikuti kegiatan menyanyi.',
            'hadir' => 80,
            'izin' => 5,
            'sakit' => 4,
            'alpa' => 1,
            'catatan_guru' => 'Perkembangan ananda cukup baik di semester ini. Masih memerlukan bimbingan lebih untuk aspek kognitif dan bahasa.',
            'rekomendasi' => 'Orang tua disarankan lebih sering membacakan buku cerita dan mengajak anak berhitung benda di sekitar rumah.',
            'tanggal_terbit' => now()->subMonths(7),
        ]);
    }
}
