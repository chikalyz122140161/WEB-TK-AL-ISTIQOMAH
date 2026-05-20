<?php

namespace Database\Seeders;

use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $admin = 'Admin Baini, S.Pd';
        $guruA = 'Guru Reita Wigianti, S.Si, S.Pd., Gr';
        $guruB1 = 'Guru Lucia Untari, S.Pd';
        $guruB2 = 'Guru Fitriyah Hariani, S.Pd';
        $ortu1 = 'Orang Tua Ari Kristianto';
        $ortu2 = 'Orang Tua Ujang Afriyadi';
        $ortu3 = 'Orang Tua Erpandi';

        $now = Carbon::now();

        // Format: [actor, action, created_at]
        $entries = [
            // ── Admin: pendaftaran ───────────────────────────────
            [$admin, 'menerima pendaftaran siswa ABIL ALTAIR ERDHAFEN',          $now->copy()->subDays(30)->setTime(8, 15)],
            [$admin, 'menerima pendaftaran siswa AISYAH PUTRI INAYAH',           $now->copy()->subDays(29)->setTime(9, 0)],
            [$admin, 'menolak pendaftaran siswa RANGGA PRATAMA',                 $now->copy()->subDays(28)->setTime(10, 30)],

            // ── Admin: kelola pengguna ───────────────────────────
            [$admin, 'menambah pengguna Reita Wigianti, S.Si, S.Pd., Gr (guru)', $now->copy()->subDays(27)->setTime(8, 10)],
            [$admin, 'mengedit pengguna Lucia Untari, S.Pd',                     $now->copy()->subDays(20)->setTime(14, 5)],
            [$admin, 'menghapus pengguna Test Akun',                             $now->copy()->subDays(18)->setTime(11, 20)],

            // ── Admin: kelola siswa ──────────────────────────────
            [$admin, 'menambah siswa ALVARO ATHAYA ARIYUN',                      $now->copy()->subDays(26)->setTime(9, 45)],
            [$admin, 'mengedit siswa M. RAFFA ALFATIH AFRIYADI',                 $now->copy()->subDays(15)->setTime(13, 30)],
            [$admin, 'menghapus siswa Data Lama Test',                           $now->copy()->subDays(12)->setTime(15, 15)],

            // ── Admin: tahun ajaran ──────────────────────────────
            [$admin, 'menambah tahun ajaran 2025/2026 Genap',                    $now->copy()->subDays(25)->setTime(7, 50)],
            [$admin, 'mengedit tahun ajaran 2024/2025 Genap',                    $now->copy()->subDays(22)->setTime(10, 0)],
            [$admin, 'menghapus tahun ajaran 2022/2023 Ganjil',                  $now->copy()->subDays(21)->setTime(12, 10)],

            // ── Admin: kelas ─────────────────────────────────────
            [$admin, 'menambah kelas B2',                                        $now->copy()->subDays(24)->setTime(8, 30)],
            [$admin, 'mengedit kelas A',                                         $now->copy()->subDays(17)->setTime(14, 0)],
            [$admin, 'menghapus kelas C (uji coba)',                             $now->copy()->subDays(16)->setTime(9, 20)],

            // ── Admin: ekstrakurikuler ───────────────────────────
            [$admin, 'menambah ekstrakurikuler Menari',                          $now->copy()->subDays(23)->setTime(8, 0)],
            [$admin, 'mengedit ekstrakurikuler Mewarnai',                        $now->copy()->subDays(14)->setTime(11, 30)],
            [$admin, 'menghapus ekstrakurikuler Renang',                         $now->copy()->subDays(13)->setTime(13, 45)],

            // ── Admin: mata pelajaran ────────────────────────────
            [$admin, 'menambah mata pelajaran Pendidikan Agama Islam',           $now->copy()->subDays(11)->setTime(9, 0)],
            [$admin, 'mengedit mata pelajaran Bahasa Indonesia',                 $now->copy()->subDays(10)->setTime(10, 30)],
            [$admin, 'menghapus mata pelajaran Sains (uji coba)',                $now->copy()->subDays(9)->setTime(14, 20)],

            // ── Admin: konseling ─────────────────────────────────
            [$admin, 'menambah konseling Perkembangan Sosial Emosional',        $now->copy()->subDays(8)->setTime(8, 15)],
            [$admin, 'mengedit konseling Perkembangan Bahasa',                  $now->copy()->subDays(7)->setTime(13, 50)],
            [$admin, 'menghapus konseling Bimbingan Karir (uji coba)',          $now->copy()->subDays(6)->setTime(11, 0)],

            // ── Admin: aktivitas tahun ajaran ────────────────────
            [$admin, 'mengedit aktivitas tahun ajaran untuk kelas A — 2025/2026 Genap', $now->copy()->subDays(5)->setTime(9, 30)],

            // ── Admin: backup database ───────────────────────────
            [$admin, 'melakukan backup database (backup_web_tk_alistiqomah_2026-05-13_000001.sql)', $now->copy()->subDays(7)->setTime(0, 0, 5)],
            [$admin, 'melakukan backup database (backup_web_tk_alistiqomah_2026-05-20_000001.sql)', $now->copy()->subDays(0)->setTime(0, 0, 7)],

            // ── Guru A: presensi & jadwal ────────────────────────
            [$guruA, 'mencatat presensi kelas A untuk tanggal ' . $now->copy()->subDays(4)->toDateString(), $now->copy()->subDays(4)->setTime(7, 30)],
            [$guruA, 'mencatat presensi kelas A untuk tanggal ' . $now->copy()->subDays(3)->toDateString(), $now->copy()->subDays(3)->setTime(7, 32)],
            [$guruA, 'membuat jadwal kegiatan: Outing Class — Kebun Binatang',   $now->copy()->subDays(10)->setTime(15, 0)],
            [$guruA, 'mengedit jadwal pembelajaran: Bahasa Inggris',             $now->copy()->subDays(8)->setTime(14, 20)],
            [$guruA, 'menghapus jadwal kegiatan: Bermain Peran (lama)',          $now->copy()->subDays(6)->setTime(10, 45)],

            // ── Guru A: rapot & laporan perkembangan ─────────────
            [$guruA, 'menginput rapot untuk siswa ABIL ALTAIR ERDHAFEN',          $now->copy()->subDays(5)->setTime(16, 0)],
            [$guruA, 'mengedit rapot untuk siswa AISYAH PUTRI INAYAH',            $now->copy()->subDays(2)->setTime(15, 30)],
            [$guruA, 'membuat laporan perkembangan minggu ke-12 untuk siswa ABIL ALTAIR ERDHAFEN', $now->copy()->subDays(4)->setTime(13, 15)],
            [$guruA, 'mengedit laporan perkembangan minggu ke-11 untuk siswa AISYAH PUTRI INAYAH', $now->copy()->subDays(3)->setTime(11, 50)],

            // ── Guru A: jadwal konseling ─────────────────────────
            [$guruA, 'membuat jadwal konseling untuk ALVARO ATHAYA ARIYUN pada ' . $now->copy()->subDays(2)->toDateString(), $now->copy()->subDays(9)->setTime(10, 0)],
            [$guruA, 'membuat jadwal konseling per kelas pada ' . $now->copy()->addDays(3)->toDateString(),                  $now->copy()->subDays(1)->setTime(8, 45)],

            // ── Guru B1 ──────────────────────────────────────────
            [$guruB1, 'mencatat presensi kelas B1 untuk tanggal ' . $now->copy()->subDays(2)->toDateString(), $now->copy()->subDays(2)->setTime(7, 35)],
            [$guruB1, 'menginput rapot untuk siswa AKSYAHRA VYANTA HUMAIRA MECCA', $now->copy()->subDays(3)->setTime(16, 10)],
            [$guruB1, 'membuat laporan perkembangan minggu ke-12 untuk siswa M. RAFFA ALFATIH AFRIYADI', $now->copy()->subHours(20)->setTime(14, 30)],

            // ── Guru B2 ──────────────────────────────────────────
            [$guruB2, 'mencatat presensi kelas B2 untuk tanggal ' . $now->copy()->subDays(1)->toDateString(), $now->copy()->subDays(1)->setTime(7, 40)],
            [$guruB2, 'membuat jadwal pembelajaran: Praktik Wudhu',               $now->copy()->subHours(8)],
            [$guruB2, 'membuat jadwal konseling untuk MAHENDRA ANDRIAN pada ' . $now->copy()->addDays(5)->toDateString(), $now->copy()->subHours(5)],

            // ── Orang tua: pengajuan konseling ───────────────────
            [$ortu1, 'mengajukan jadwal konseling untuk siswa ALVARO ATHAYA ARIYUN pada ' . $now->copy()->addDays(7)->toDateString(),  $now->copy()->subDays(4)->setTime(20, 15)],
            [$ortu2, 'mengajukan jadwal konseling untuk siswa M. RAFFA ALFATIH AFRIYADI pada ' . $now->copy()->addDays(4)->toDateString(), $now->copy()->subDays(2)->setTime(19, 30)],
            [$ortu3, 'mengajukan jadwal konseling untuk siswa ABIL ALTAIR ERDHAFEN pada ' . $now->copy()->addDays(2)->toDateString(),       $now->copy()->subHours(3)],
        ];

        foreach ($entries as [$actor, $action, $createdAt]) {
            Activity::create([
                'description' => $actor . ' — ' . $action,
                'created_at'  => $createdAt,
                'updated_at'  => $createdAt,
            ]);
        }
    }
}
