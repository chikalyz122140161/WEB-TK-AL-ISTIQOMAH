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
    }
}
