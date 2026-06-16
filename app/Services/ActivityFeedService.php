<?php

namespace App\Services;

use App\Models\Activity;
use Carbon\Carbon;

class ActivityFeedService
{
    /**
     * Ambil N entri activity log terbaru, dengan ikon & warna otomatis dari kata kunci description.
     *
     * @return array<int, array{type:string,title:string,subtitle:?string,time:string,time_raw:Carbon,icon:string,color:string}>
     */
    // Function ini mengambil daftar aktivitas terbaru dari sistem.
    // Data tersebut biasanya ditampilkan di dashboard sebagai ringkasan kegiatan terakhir.
    public function recent(int $limit = 5): array
    {
        return Activity::orderByDesc('created_at')
            ->limit($limit)
            ->get()
            ->map(function (Activity $a) {
                $desc = $a->description ?? '';
                [$title, $subtitle] = $this->splitTitle($desc);
                return [
                    'type'     => 'activity',
                    'title'    => $title,
                    'subtitle' => $subtitle,
                    'time_raw' => $a->created_at,
                    'time'     => $this->relativeTime($a->created_at),
                    'icon'     => $this->pickIcon($desc),
                    'color'    => $this->pickColor($desc),
                ];
            })
            ->all();
    }

    /**
     * Description format dari Activity::log() = "{Role} {Name} — {action}".
     * Split jadi title (action) + subtitle (siapa yang melakukan).
     *
     * @return array{0:string,1:?string}
     */
    // Function ini memecah deskripsi aktivitas menjadi judul dan keterangan singkat.
    // Tujuannya agar aktivitas lebih rapi saat ditampilkan di dashboard.
    private function splitTitle(string $desc): array
    {
        if (str_contains($desc, ' — ')) {
            [$actor, $action] = explode(' — ', $desc, 2);
            return [ucfirst(trim($action)), trim($actor)];
        }
        return [$desc, null];
    }

    // Function ini memilih ikon yang sesuai dengan jenis aktivitas.
    // Ikon membantu user memahami jenis aktivitas secara cepat.
    private function pickIcon(string $desc): string
    {
        $d = mb_strtolower($desc);

        return match (true) {
            str_contains($d, 'pendaftaran')      => 'check',
            str_contains($d, 'pengguna')         => 'user',
            str_contains($d, 'siswa')            => 'graduate',
            str_contains($d, 'tahun ajaran')     => 'calendar',
            str_contains($d, 'kelas')            => 'home',
            str_contains($d, 'ekstrakurikuler')  => 'star',
            str_contains($d, 'mata pelajaran')   => 'book',
            str_contains($d, 'konseling')        => 'chat',
            str_contains($d, 'aktivitas')        => 'list',
            str_contains($d, 'backup')           => 'database',
            str_contains($d, 'presensi')         => 'clipboard',
            str_contains($d, 'jadwal')           => 'calendar',
            str_contains($d, 'rapot')            => 'document',
            str_contains($d, 'laporan')          => 'document',
            default                              => 'inbox',
        };
    }

    // Function ini memilih warna tampilan berdasarkan jenis aktivitas.
    // Warna dipakai agar daftar aktivitas lebih mudah dibaca dan dibedakan.
    private function pickColor(string $desc): string
    {
        $d = mb_strtolower($desc);

        return match (true) {
            str_contains($d, 'menolak') || str_contains($d, 'menghapus') => 'pink',
            str_contains($d, 'mengedit')                                  => 'yellow',
            default                                                       => 'green',
        };
    }

    // Function ini mengubah waktu aktivitas menjadi format yang mudah dibaca.
    // Contohnya waktu asli dibuat menjadi keterangan seperti beberapa menit lalu atau beberapa hari lalu.
    private function relativeTime(?Carbon $time): string
    {
        if (! $time) return '-';

        $now  = Carbon::now();
        $diff = $time->diffInMinutes($now);

        if ($diff < 1)    return 'Baru saja';
        if ($diff < 60)   return (int) $diff . ' menit yang lalu';
        if ($diff < 1440) return (int) floor($diff / 60) . ' jam yang lalu';
        if ($diff < 2880) return 'Kemarin';
        if ($diff < 10080) return (int) floor($diff / 1440) . ' hari yang lalu';
        return $time->translatedFormat('d M Y');
    }
}
