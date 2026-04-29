<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

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

        $jadwal = collect($this->getDummyJadwalKonseling())->where('bulan', $bulan)->values()->all();

        return view('guru.jadwal_konseling', compact('jadwal', 'bulan', 'bulanTahun', 'daftarSiswa', 'daftarOrangTua'));
    }

    public function storeJadwalKonseling(Request $request)
    {
        // TODO: simpan ke database
        return redirect()->route('guru.jadwal_konseling')->with('success', 'Jadwal berhasil dibuat.');
    }

    private function getDummyJadwalKonseling(): array
    {
        return [
            1 => ['id' => 1, 'tanggal' => '29 Nov 2024', 'waktu' => '10:00 - 11:00', 'orang_tua' => 'Ibu Siti',   'siswa' => 'Ahmad Fauzi',    'topik' => 'Perkembangan Sosial',   'status' => 'disetujui', 'bulan' => 11, 'catatan' => 'Anak menunjukkan perkembangan sosial yang baik.'],
            2 => ['id' => 2, 'tanggal' => '28 Nov 2024', 'waktu' => '09:00 - 10:00', 'orang_tua' => 'Bapak Budi', 'siswa' => 'Siti Nurhaliza', 'topik' => 'Konsultasi Umum',       'status' => 'pending',   'bulan' => 11, 'catatan' => ''],
            3 => ['id' => 3, 'tanggal' => '27 Nov 2024', 'waktu' => '13:00 - 14:00', 'orang_tua' => 'Ibu Dewi',   'siswa' => 'Eko Prasetyo',   'topik' => 'Perkembangan Kognitif', 'status' => 'disetujui', 'bulan' => 11, 'catatan' => ''],
            4 => ['id' => 4, 'tanggal' => '22 Nov 2024', 'waktu' => '10:00 - 11:00', 'orang_tua' => 'Ibu Ani',    'siswa' => 'Rina Susanti',   'topik' => 'Perkembangan Bahasa',   'status' => 'selesai',   'bulan' => 11, 'catatan' => 'Sesi berjalan dengan baik.'],
            5 => ['id' => 5, 'tanggal' => '20 Nov 2024', 'waktu' => '14:00 - 15:00', 'orang_tua' => 'Bapak Hadi', 'siswa' => 'Doni Saputra',   'topik' => 'Perkembangan Motorik',  'status' => 'selesai',   'bulan' => 11, 'catatan' => ''],
            6 => ['id' => 6, 'tanggal' => '05 Mar 2026', 'waktu' => '09:00 - 10:00', 'orang_tua' => 'Ibu Siti',   'siswa' => 'Ahmad Fauzi',    'topik' => 'Perkembangan Sosial',   'status' => 'disetujui', 'bulan' => 3,  'catatan' => ''],
            7 => ['id' => 7, 'tanggal' => '07 Mar 2026', 'waktu' => '10:00 - 11:00', 'orang_tua' => 'Bapak Budi', 'siswa' => 'Siti Nurhaliza', 'topik' => 'Konsultasi Umum',       'status' => 'pending',   'bulan' => 3,  'catatan' => ''],
            8 => ['id' => 8, 'tanggal' => '10 Mar 2026', 'waktu' => '13:00 - 14:00', 'orang_tua' => 'Ibu Dewi',   'siswa' => 'Eko Prasetyo',   'topik' => 'Perkembangan Kognitif', 'status' => 'pending',   'bulan' => 3,  'catatan' => ''],
            9 => ['id' => 9, 'tanggal' => '12 Mar 2026', 'waktu' => '08:00 - 09:00', 'orang_tua' => 'Ibu Ani',    'siswa' => 'Rina Susanti',   'topik' => 'Perkembangan Bahasa',   'status' => 'disetujui', 'bulan' => 3,  'catatan' => ''],
        ];
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

        // Dummy pesan — nanti ganti dengan query database
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

    public function laporan(Request $request)
    {
        $daftarSiswa = $this->getDaftarSiswa();

        // Dummy data laporan — nanti diganti query database
        $semua = [
            ['id' => 1, 'siswa_id' => 1, 'nama' => 'Ahmad Fauzi',   'kelas' => 'TK A', 'minggu' => 12, 'tanggal' => '22 Nov 2024', 'rata_rata' => 3.8],
            ['id' => 2, 'siswa_id' => 2, 'nama' => 'Siti Nurhaliza', 'kelas' => 'TK A', 'minggu' => 12, 'tanggal' => '22 Nov 2024', 'rata_rata' => 4.0],
            ['id' => 3, 'siswa_id' => 3, 'nama' => 'Budi Santoso',   'kelas' => 'TK B', 'minggu' => 12, 'tanggal' => '22 Nov 2024', 'rata_rata' => 3.7],
            ['id' => 4, 'siswa_id' => 4, 'nama' => 'Dewi Lestari',   'kelas' => 'TK A', 'minggu' => 12, 'tanggal' => '22 Nov 2024', 'rata_rata' => 4.0],
            ['id' => 5, 'siswa_id' => 5, 'nama' => 'Eko Prasetyo',   'kelas' => 'TK B', 'minggu' => 12, 'tanggal' => '22 Nov 2024', 'rata_rata' => 4.0],
        ];

        // Filter
        $laporan = collect($semua);
        if ($request->filled('siswa_id')) {
            $laporan = $laporan->where('siswa_id', (int) $request->siswa_id);
        }
        if ($request->filled('minggu')) {
            $laporan = $laporan->where('minggu', (int) $request->minggu);
        }

        return view('guru.laporan', [
            'laporan'     => $laporan->values()->all(),
            'daftarSiswa' => $daftarSiswa,
        ]);
    }

    public function laporanBkShow($id)
    {
        // Dummy data — nanti diganti query database
        $semua = [
            1 => ['id' => 1, 'nama' => 'Ahmad Fauzi',   'kelas' => 'TK A', 'minggu' => 12, 'tanggal' => '22 Nov 2024', 'rata_rata' => 3.8,
                  'nilai' => ['fisik_motorik'=>4,'kognitif'=>4,'bahasa'=>4,'sosial_emosional'=>3,'nilai_agama_moral'=>4,'seni'=>4],
                  'catatan' => 'Ahmad menunjukkan perkembangan yang sangat baik. Aktif dan antusias dalam kegiatan belajar.'],
            2 => ['id' => 2, 'nama' => 'Siti Nurhaliza', 'kelas' => 'TK A', 'minggu' => 12, 'tanggal' => '22 Nov 2024', 'rata_rata' => 4.0,
                  'nilai' => ['fisik_motorik'=>4,'kognitif'=>4,'bahasa'=>4,'sosial_emosional'=>4,'nilai_agama_moral'=>4,'seni'=>4],
                  'catatan' => 'Siti sangat aktif berkomunikasi dan berinteraksi dengan teman-temannya. Kemampuan bahasa sangat menonjol.'],
            3 => ['id' => 3, 'nama' => 'Budi Santoso',   'kelas' => 'TK B', 'minggu' => 12, 'tanggal' => '22 Nov 2024', 'rata_rata' => 3.7,
                  'nilai' => ['fisik_motorik'=>4,'kognitif'=>4,'bahasa'=>3,'sosial_emosional'=>4,'nilai_agama_moral'=>4,'seni'=>3],
                  'catatan' => 'Budi berkembang baik. Perlu sedikit pendampingan di aspek bahasa dan seni.'],
            4 => ['id' => 4, 'nama' => 'Dewi Lestari',   'kelas' => 'TK A', 'minggu' => 12, 'tanggal' => '22 Nov 2024', 'rata_rata' => 4.0,
                  'nilai' => ['fisik_motorik'=>4,'kognitif'=>4,'bahasa'=>4,'sosial_emosional'=>4,'nilai_agama_moral'=>4,'seni'=>4],
                  'catatan' => 'Dewi berkembang sesuai harapan di semua aspek. Tetap pertahankan dan tingkatkan.'],
            5 => ['id' => 5, 'nama' => 'Eko Prasetyo',   'kelas' => 'TK B', 'minggu' => 12, 'tanggal' => '22 Nov 2024', 'rata_rata' => 4.0,
                  'nilai' => ['fisik_motorik'=>4,'kognitif'=>4,'bahasa'=>4,'sosial_emosional'=>4,'nilai_agama_moral'=>4,'seni'=>4],
                  'catatan' => 'Eko sangat aktif secara fisik dan memiliki nilai agama yang baik. Tetap semangat!'],
        ];

        $laporan = $semua[$id] ?? $semua[1];

        return view('guru.laporan_detail', ['laporan' => $laporan]);
    }

    public function laporanBkEdit($id)
    {
        $daftarSiswa = $this->getDaftarSiswa();

        $semua = [
            1 => ['id' => 1, 'siswa_id' => 1, 'nama' => 'Ahmad Fauzi',   'kelas' => 'TK A', 'minggu' => 12, 'tanggal' => '2024-11-22', 'tahun_ajaran' => 2024, 'semester' => 'Ganjil', 'rata_rata' => 3.8,
                  'nilai' => ['fisik_motorik'=>4,'kognitif'=>4,'bahasa'=>4,'sosial_emosional'=>3,'nilai_agama_moral'=>4,'seni'=>4],
                  'catatan' => ['fisik_motorik'=>'','kognitif'=>'','bahasa'=>'','sosial_emosional'=>'','nilai_agama_moral'=>'','seni'=>''],
                  'catatan_umum' => 'Ahmad menunjukkan perkembangan yang sangat baik.'],
            2 => ['id' => 2, 'siswa_id' => 2, 'nama' => 'Siti Nurhaliza', 'kelas' => 'TK A', 'minggu' => 12, 'tanggal' => '2024-11-22', 'tahun_ajaran' => 2024, 'semester' => 'Ganjil', 'rata_rata' => 4.0,
                  'nilai' => ['fisik_motorik'=>4,'kognitif'=>4,'bahasa'=>4,'sosial_emosional'=>4,'nilai_agama_moral'=>4,'seni'=>4],
                  'catatan' => ['fisik_motorik'=>'','kognitif'=>'','bahasa'=>'','sosial_emosional'=>'','nilai_agama_moral'=>'','seni'=>''],
                  'catatan_umum' => 'Siti sangat aktif berkomunikasi dan berinteraksi dengan teman-temannya.'],
            3 => ['id' => 3, 'siswa_id' => 3, 'nama' => 'Budi Santoso',   'kelas' => 'TK B', 'minggu' => 12, 'tanggal' => '2024-11-22', 'tahun_ajaran' => 2024, 'semester' => 'Ganjil', 'rata_rata' => 3.7,
                  'nilai' => ['fisik_motorik'=>4,'kognitif'=>4,'bahasa'=>3,'sosial_emosional'=>4,'nilai_agama_moral'=>4,'seni'=>3],
                  'catatan' => ['fisik_motorik'=>'','kognitif'=>'','bahasa'=>'','sosial_emosional'=>'','nilai_agama_moral'=>'','seni'=>''],
                  'catatan_umum' => 'Budi berkembang baik. Perlu sedikit pendampingan di aspek bahasa dan seni.'],
            4 => ['id' => 4, 'siswa_id' => 4, 'nama' => 'Dewi Lestari',   'kelas' => 'TK A', 'minggu' => 12, 'tanggal' => '2024-11-22', 'tahun_ajaran' => 2024, 'semester' => 'Ganjil', 'rata_rata' => 4.0,
                  'nilai' => ['fisik_motorik'=>4,'kognitif'=>4,'bahasa'=>4,'sosial_emosional'=>4,'nilai_agama_moral'=>4,'seni'=>4],
                  'catatan' => ['fisik_motorik'=>'','kognitif'=>'','bahasa'=>'','sosial_emosional'=>'','nilai_agama_moral'=>'','seni'=>''],
                  'catatan_umum' => 'Dewi berkembang sesuai harapan di semua aspek.'],
            5 => ['id' => 5, 'siswa_id' => 5, 'nama' => 'Eko Prasetyo',   'kelas' => 'TK B', 'minggu' => 12, 'tanggal' => '2024-11-22', 'tahun_ajaran' => 2024, 'semester' => 'Ganjil', 'rata_rata' => 4.0,
                  'nilai' => ['fisik_motorik'=>4,'kognitif'=>4,'bahasa'=>4,'sosial_emosional'=>4,'nilai_agama_moral'=>4,'seni'=>4],
                  'catatan' => ['fisik_motorik'=>'','kognitif'=>'','bahasa'=>'','sosial_emosional'=>'','nilai_agama_moral'=>'','seni'=>''],
                  'catatan_umum' => 'Eko sangat aktif secara fisik dan memiliki nilai agama yang baik.'],
        ];

        $laporan = $semua[$id] ?? $semua[1];

        return view('guru.laporan_edit', ['laporan' => $laporan, 'daftarSiswa' => $daftarSiswa]);
    }

    public function laporanBkUpdate(Request $request, $id)
    {
        // Nanti diganti dengan logika update database
        return redirect()->route('guru.laporan_bk')->with('success', 'Laporan perkembangan berhasil diperbarui.');
    }

    public function grafik()
    {
        $daftarSiswa = $this->getDaftarSiswa();

        // 6 bulan (1 semester)
        $daftarMinggu = range(1, 6);
        $siswaAktif   = $daftarSiswa[0]; // default: Ahmad Rizky
        $mingguAktif  = 6;

        // Dummy data per siswa per bulan (6 bulan = 1 semester) — nanti diganti query database
        // Format: nilaiPerSiswa[siswa_id][bulan] = [aspek => nilai]
        // Skala: 1=BB, 2=MB, 3=BSH, 4=BSB
        $nilaiPerSiswa = [
            1 => [ // Ahmad Rizky — mulai MB, akhir BSH-BSB
                1 => ['fisik_motorik'=>2,'kognitif'=>2,'bahasa'=>2,'sosial_emosional'=>2,'nilai_agama_moral'=>2,'seni'=>2],
                2 => ['fisik_motorik'=>2,'kognitif'=>2,'bahasa'=>3,'sosial_emosional'=>2,'nilai_agama_moral'=>2,'seni'=>2],
                3 => ['fisik_motorik'=>3,'kognitif'=>3,'bahasa'=>3,'sosial_emosional'=>2,'nilai_agama_moral'=>3,'seni'=>3],
                4 => ['fisik_motorik'=>3,'kognitif'=>3,'bahasa'=>3,'sosial_emosional'=>3,'nilai_agama_moral'=>3,'seni'=>3],
                5 => ['fisik_motorik'=>3,'kognitif'=>4,'bahasa'=>4,'sosial_emosional'=>3,'nilai_agama_moral'=>4,'seni'=>3],
                6 => ['fisik_motorik'=>4,'kognitif'=>4,'bahasa'=>4,'sosial_emosional'=>4,'nilai_agama_moral'=>4,'seni'=>4],
            ],
            2 => [ // Anisa Putri — cepat berkembang
                1 => ['fisik_motorik'=>2,'kognitif'=>2,'bahasa'=>3,'sosial_emosional'=>2,'nilai_agama_moral'=>2,'seni'=>3],
                2 => ['fisik_motorik'=>3,'kognitif'=>2,'bahasa'=>3,'sosial_emosional'=>3,'nilai_agama_moral'=>3,'seni'=>3],
                3 => ['fisik_motorik'=>3,'kognitif'=>3,'bahasa'=>4,'sosial_emosional'=>3,'nilai_agama_moral'=>3,'seni'=>4],
                4 => ['fisik_motorik'=>4,'kognitif'=>3,'bahasa'=>4,'sosial_emosional'=>4,'nilai_agama_moral'=>4,'seni'=>4],
                5 => ['fisik_motorik'=>4,'kognitif'=>4,'bahasa'=>4,'sosial_emosional'=>4,'nilai_agama_moral'=>4,'seni'=>4],
                6 => ['fisik_motorik'=>4,'kognitif'=>4,'bahasa'=>4,'sosial_emosional'=>4,'nilai_agama_moral'=>4,'seni'=>4],
            ],
            3 => [ // Muhammad Fauzi — kognitif menonjol
                1 => ['fisik_motorik'=>2,'kognitif'=>3,'bahasa'=>2,'sosial_emosional'=>2,'nilai_agama_moral'=>3,'seni'=>2],
                2 => ['fisik_motorik'=>2,'kognitif'=>3,'bahasa'=>2,'sosial_emosional'=>2,'nilai_agama_moral'=>3,'seni'=>2],
                3 => ['fisik_motorik'=>3,'kognitif'=>4,'bahasa'=>3,'sosial_emosional'=>3,'nilai_agama_moral'=>4,'seni'=>3],
                4 => ['fisik_motorik'=>3,'kognitif'=>4,'bahasa'=>3,'sosial_emosional'=>3,'nilai_agama_moral'=>4,'seni'=>3],
                5 => ['fisik_motorik'=>3,'kognitif'=>4,'bahasa'=>4,'sosial_emosional'=>3,'nilai_agama_moral'=>4,'seni'=>4],
                6 => ['fisik_motorik'=>4,'kognitif'=>4,'bahasa'=>4,'sosial_emosional'=>4,'nilai_agama_moral'=>4,'seni'=>4],
            ],
            4 => [ // Tika Rahayu — mulai BB, berkembang perlahan
                1 => ['fisik_motorik'=>1,'kognitif'=>1,'bahasa'=>2,'sosial_emosional'=>2,'nilai_agama_moral'=>1,'seni'=>1],
                2 => ['fisik_motorik'=>2,'kognitif'=>2,'bahasa'=>2,'sosial_emosional'=>2,'nilai_agama_moral'=>2,'seni'=>2],
                3 => ['fisik_motorik'=>2,'kognitif'=>2,'bahasa'=>3,'sosial_emosional'=>3,'nilai_agama_moral'=>2,'seni'=>2],
                4 => ['fisik_motorik'=>3,'kognitif'=>3,'bahasa'=>3,'sosial_emosional'=>3,'nilai_agama_moral'=>3,'seni'=>3],
                5 => ['fisik_motorik'=>3,'kognitif'=>3,'bahasa'=>3,'sosial_emosional'=>4,'nilai_agama_moral'=>3,'seni'=>3],
                6 => ['fisik_motorik'=>4,'kognitif'=>4,'bahasa'=>4,'sosial_emosional'=>4,'nilai_agama_moral'=>4,'seni'=>4],
            ],
            5 => [ // Siti Aisyah — seni menonjol sejak awal
                1 => ['fisik_motorik'=>2,'kognitif'=>2,'bahasa'=>2,'sosial_emosional'=>2,'nilai_agama_moral'=>2,'seni'=>3],
                2 => ['fisik_motorik'=>2,'kognitif'=>2,'bahasa'=>2,'sosial_emosional'=>3,'nilai_agama_moral'=>3,'seni'=>4],
                3 => ['fisik_motorik'=>3,'kognitif'=>3,'bahasa'=>3,'sosial_emosional'=>3,'nilai_agama_moral'=>3,'seni'=>4],
                4 => ['fisik_motorik'=>3,'kognitif'=>3,'bahasa'=>3,'sosial_emosional'=>4,'nilai_agama_moral'=>4,'seni'=>4],
                5 => ['fisik_motorik'=>3,'kognitif'=>4,'bahasa'=>4,'sosial_emosional'=>4,'nilai_agama_moral'=>4,'seni'=>4],
                6 => ['fisik_motorik'=>4,'kognitif'=>4,'bahasa'=>4,'sosial_emosional'=>4,'nilai_agama_moral'=>4,'seni'=>4],
            ],
        ];

        return view('guru.grafik', compact(
            'daftarSiswa', 'daftarMinggu', 'siswaAktif', 'mingguAktif', 'nilaiPerSiswa'
        ));
    }

    public function inputPerkembangan()
    {
        $daftarSiswa = $this->getDaftarSiswa();

        return view('guru.input_perkembangan', compact('daftarSiswa'));
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
            'userName'         => 'Guru',
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
        $siswaList = $this->getDaftarSiswa();

        // Dummy data kehadiran
        $kehadiranList = [
            ['id' => 1, 'nama' => 'Ahmad Fauzi', 'kelas' => 'TK A', 'tanggal' => '04 Mar 2026', 'status' => 'hadir', 'keterangan' => '-'],
            ['id' => 2, 'nama' => 'Siti Nurhaliza', 'kelas' => 'TK A', 'tanggal' => '04 Mar 2026', 'status' => 'hadir', 'keterangan' => '-'],
            ['id' => 3, 'nama' => 'Budi Santoso', 'kelas' => 'TK B', 'tanggal' => '04 Mar 2026', 'status' => 'izin', 'keterangan' => 'Acara keluarga'],
            ['id' => 4, 'nama' => 'Dewi Lestari', 'kelas' => 'TK A', 'tanggal' => '04 Mar 2026', 'status' => 'sakit', 'keterangan' => 'Demam'],
            ['id' => 5, 'nama' => 'Eko Prasetyo', 'kelas' => 'TK B', 'tanggal' => '04 Mar 2026', 'status' => 'hadir', 'keterangan' => '-'],
        ];

        return view('guru.kehadiran.index', compact('siswaList', 'kehadiranList'));
    }

    /**
     * Kehadiran - Store
     */
    public function kehadiranStore(Request $request)
    {
        // Dummy - redirect with success
        return redirect()->route('guru.kehadiran.index')->with('success', 'Kehadiran berhasil disimpan.');
    }

    /**
     * Kehadiran - Edit
     */
    public function kehadiranEdit($id)
    {
        // Dummy data - nanti bisa diganti dengan query database
        $allKehadiran = [
            1 => ['id' => 1, 'nama' => 'Ahmad Fauzi', 'kelas' => 'TK A', 'tanggal' => '2026-03-04', 'status' => 'hadir', 'keterangan' => '-'],
            2 => ['id' => 2, 'nama' => 'Siti Nurhaliza', 'kelas' => 'TK A', 'tanggal' => '2026-03-04', 'status' => 'hadir', 'keterangan' => '-'],
            3 => ['id' => 3, 'nama' => 'Budi Santoso', 'kelas' => 'TK B', 'tanggal' => '2026-03-04', 'status' => 'izin', 'keterangan' => 'Acara keluarga'],
            4 => ['id' => 4, 'nama' => 'Dewi Lestari', 'kelas' => 'TK A', 'tanggal' => '2026-03-04', 'status' => 'sakit', 'keterangan' => 'Demam'],
            5 => ['id' => 5, 'nama' => 'Eko Prasetyo', 'kelas' => 'TK B', 'tanggal' => '2026-03-04', 'status' => 'hadir', 'keterangan' => '-'],
        ];

        if (!isset($allKehadiran[$id])) {
            return redirect()->route('guru.kehadiran.index')->with('error', 'Data kehadiran tidak ditemukan.');
        }

        $kehadiran = $allKehadiran[$id];

        return view('guru.kehadiran.edit', compact('kehadiran'));
    }

    /**
     * Kehadiran - Update
     */
    public function kehadiranUpdate(Request $request, $id)
    {
        // Dummy - redirect with success
        return redirect()->route('guru.kehadiran.index')->with('success', 'Data kehadiran berhasil diperbarui.');
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
        // Dummy data jadwal kegiatan
        $jadwalKegiatan = [
            ['id' => 1, 'nama' => 'Upacara Bendera', 'tanggal' => 'Senin, 10 Mar 2026', 'waktu' => '07:00 - 08:00', 'lokasi' => 'Lapangan', 'kelas' => 'Semua'],
            ['id' => 2, 'nama' => 'Senam Pagi', 'tanggal' => 'Selasa, 11 Mar 2026', 'waktu' => '07:30 - 08:00', 'lokasi' => 'Lapangan', 'kelas' => 'Semua'],
            ['id' => 3, 'nama' => 'Outing Class', 'tanggal' => 'Rabu, 12 Mar 2026', 'waktu' => '08:00 - 12:00', 'lokasi' => 'Kebun Binatang', 'kelas' => 'TK B'],
            ['id' => 4, 'nama' => 'Lomba Mewarnai', 'tanggal' => 'Kamis, 13 Mar 2026', 'waktu' => '09:00 - 11:00', 'lokasi' => 'Aula', 'kelas' => 'Semua'],
        ];

        // Dummy data jadwal pembelajaran
        $jadwalPembelajaran = [
            // Senin
            ['id' =>  1, 'hari' => 'Senin',  'waktu' => '07:30 - 08:00', 'mapel' => 'Pembukaan & Doa',   'kelas' => 'Semua'],
            ['id' =>  2, 'hari' => 'Senin',  'waktu' => '08:00 - 09:00', 'mapel' => 'Sentra Balok',      'kelas' => 'TK A'],
            ['id' =>  3, 'hari' => 'Senin',  'waktu' => '08:00 - 09:00', 'mapel' => 'Sentra Alam',       'kelas' => 'TK B'],
            ['id' =>  4, 'hari' => 'Senin',  'waktu' => '09:00 - 10:00', 'mapel' => 'Motorik Halus',     'kelas' => 'Semua'],
            // Selasa
            ['id' =>  5, 'hari' => 'Selasa', 'waktu' => '07:30 - 08:00', 'mapel' => 'Senam Pagi',        'kelas' => 'Semua'],
            ['id' =>  6, 'hari' => 'Selasa', 'waktu' => '08:00 - 09:00', 'mapel' => 'Sentra Seni',       'kelas' => 'TK A'],
            ['id' =>  7, 'hari' => 'Selasa', 'waktu' => '08:00 - 09:00', 'mapel' => 'Sentra Peran',      'kelas' => 'TK B'],
            ['id' =>  8, 'hari' => 'Selasa', 'waktu' => '09:00 - 10:00', 'mapel' => 'Menggambar Bebas',  'kelas' => 'Semua'],
            // Rabu
            ['id' =>  9, 'hari' => 'Rabu',   'waktu' => '07:30 - 08:00', 'mapel' => 'Pembukaan & Doa',   'kelas' => 'Semua'],
            ['id' => 10, 'hari' => 'Rabu',   'waktu' => '08:00 - 09:00', 'mapel' => 'Agama Islam',       'kelas' => 'TK A'],
            ['id' => 11, 'hari' => 'Rabu',   'waktu' => '08:00 - 09:00', 'mapel' => 'Agama Islam',       'kelas' => 'TK B'],
            ['id' => 12, 'hari' => 'Rabu',   'waktu' => '09:00 - 10:00', 'mapel' => 'Berhitung',         'kelas' => 'Semua'],
            // Kamis
            ['id' => 13, 'hari' => 'Kamis',  'waktu' => '07:30 - 08:00', 'mapel' => 'Senam Pagi',        'kelas' => 'Semua'],
            ['id' => 14, 'hari' => 'Kamis',  'waktu' => '08:00 - 09:00', 'mapel' => 'Sentra Balok',      'kelas' => 'TK B'],
            ['id' => 15, 'hari' => 'Kamis',  'waktu' => '08:00 - 09:00', 'mapel' => 'Sentra Bahan Alam', 'kelas' => 'TK A'],
            ['id' => 16, 'hari' => 'Kamis',  'waktu' => '09:00 - 10:00', 'mapel' => 'Menyanyi & Musik',  'kelas' => 'Semua'],
            // Jumat
            ['id' => 17, 'hari' => 'Jumat',  'waktu' => '07:30 - 08:00', 'mapel' => 'Senam & Olahraga',  'kelas' => 'Semua'],
            ['id' => 18, 'hari' => 'Jumat',  'waktu' => '08:00 - 09:00', 'mapel' => 'Sentra Peran',      'kelas' => 'TK A'],
            ['id' => 19, 'hari' => 'Jumat',  'waktu' => '08:00 - 09:00', 'mapel' => 'Sentra Seni',       'kelas' => 'TK B'],
            ['id' => 20, 'hari' => 'Jumat',  'waktu' => '09:00 - 10:00', 'mapel' => 'Cerita & Literasi', 'kelas' => 'Semua'],
        ];

        return view('guru.jadwal.index', compact('jadwalKegiatan', 'jadwalPembelajaran'));
    }

    /**
     * Jadwal - Create
     */
    public function jadwalCreate()
    {
        $kelasList = [
            ['id' => 1, 'nama' => 'A1'],
            ['id' => 2, 'nama' => 'B1'],
            ['id' => 3, 'nama' => 'B2'],
        ];
        return view('guru.jadwal.create', compact('kelasList'));
    }

    /**
     * Jadwal - Store
     */
    public function jadwalStore(Request $request)
    {
        // Dummy - redirect with success
        return redirect()->route('guru.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

/**
     * Jadwal - Edit
     */
    public function jadwalEdit(Request $request, $id)
    {
        $jenis = $request->query('jenis', 'kegiatan');

        $kegiatanData = [
            1 => ['id' => 1, 'jenis' => 'kegiatan', 'nama' => 'Upacara Bendera', 'tanggal_raw' => '2026-03-10', 'waktu' => '07:00 - 08:00', 'lokasi' => 'Lapangan', 'kelas' => 'Semua', 'deskripsi' => ''],
            2 => ['id' => 2, 'jenis' => 'kegiatan', 'nama' => 'Senam Pagi', 'tanggal_raw' => '2026-03-11', 'waktu' => '07:30 - 08:00', 'lokasi' => 'Lapangan', 'kelas' => 'Semua', 'deskripsi' => ''],
            3 => ['id' => 3, 'jenis' => 'kegiatan', 'nama' => 'Outing Class', 'tanggal_raw' => '2026-03-12', 'waktu' => '08:00 - 12:00', 'lokasi' => 'Kebun Binatang', 'kelas' => 'TK B', 'deskripsi' => ''],
            4 => ['id' => 4, 'jenis' => 'kegiatan', 'nama' => 'Lomba Mewarnai', 'tanggal_raw' => '2026-03-13', 'waktu' => '09:00 - 11:00', 'lokasi' => 'Aula', 'kelas' => 'Semua', 'deskripsi' => ''],
        ];

        $pembelajaranData = [
            1  => ['id' => 1,  'jenis' => 'pembelajaran', 'mapel' => 'Pembukaan & Doa',   'hari' => 'Senin',  'waktu' => '07:30 - 08:00', 'kelas' => 'Semua'],
            2  => ['id' => 2,  'jenis' => 'pembelajaran', 'mapel' => 'Sentra Balok',      'hari' => 'Senin',  'waktu' => '08:00 - 09:00', 'kelas' => 'TK A'],
            3  => ['id' => 3,  'jenis' => 'pembelajaran', 'mapel' => 'Sentra Alam',       'hari' => 'Senin',  'waktu' => '08:00 - 09:00', 'kelas' => 'TK B'],
            4  => ['id' => 4,  'jenis' => 'pembelajaran', 'mapel' => 'Motorik Halus',     'hari' => 'Senin',  'waktu' => '09:00 - 10:00', 'kelas' => 'Semua'],
            5  => ['id' => 5,  'jenis' => 'pembelajaran', 'mapel' => 'Senam Pagi',        'hari' => 'Selasa', 'waktu' => '07:30 - 08:00', 'kelas' => 'Semua'],
            6  => ['id' => 6,  'jenis' => 'pembelajaran', 'mapel' => 'Sentra Seni',       'hari' => 'Selasa', 'waktu' => '08:00 - 09:00', 'kelas' => 'TK A'],
            7  => ['id' => 7,  'jenis' => 'pembelajaran', 'mapel' => 'Sentra Peran',      'hari' => 'Selasa', 'waktu' => '08:00 - 09:00', 'kelas' => 'TK B'],
            8  => ['id' => 8,  'jenis' => 'pembelajaran', 'mapel' => 'Menggambar Bebas',  'hari' => 'Selasa', 'waktu' => '09:00 - 10:00', 'kelas' => 'Semua'],
            9  => ['id' => 9,  'jenis' => 'pembelajaran', 'mapel' => 'Pembukaan & Doa',   'hari' => 'Rabu',   'waktu' => '07:30 - 08:00', 'kelas' => 'Semua'],
            10 => ['id' => 10, 'jenis' => 'pembelajaran', 'mapel' => 'Agama Islam',       'hari' => 'Rabu',   'waktu' => '08:00 - 09:00', 'kelas' => 'TK A'],
            11 => ['id' => 11, 'jenis' => 'pembelajaran', 'mapel' => 'Agama Islam',       'hari' => 'Rabu',   'waktu' => '08:00 - 09:00', 'kelas' => 'TK B'],
            12 => ['id' => 12, 'jenis' => 'pembelajaran', 'mapel' => 'Berhitung',         'hari' => 'Rabu',   'waktu' => '09:00 - 10:00', 'kelas' => 'Semua'],
            13 => ['id' => 13, 'jenis' => 'pembelajaran', 'mapel' => 'Senam Pagi',        'hari' => 'Kamis',  'waktu' => '07:30 - 08:00', 'kelas' => 'Semua'],
            14 => ['id' => 14, 'jenis' => 'pembelajaran', 'mapel' => 'Sentra Balok',      'hari' => 'Kamis',  'waktu' => '08:00 - 09:00', 'kelas' => 'TK B'],
            15 => ['id' => 15, 'jenis' => 'pembelajaran', 'mapel' => 'Sentra Bahan Alam', 'hari' => 'Kamis',  'waktu' => '08:00 - 09:00', 'kelas' => 'TK A'],
            16 => ['id' => 16, 'jenis' => 'pembelajaran', 'mapel' => 'Menyanyi & Musik',  'hari' => 'Kamis',  'waktu' => '09:00 - 10:00', 'kelas' => 'Semua'],
            17 => ['id' => 17, 'jenis' => 'pembelajaran', 'mapel' => 'Senam & Olahraga',  'hari' => 'Jumat',  'waktu' => '07:30 - 08:00', 'kelas' => 'Semua'],
            18 => ['id' => 18, 'jenis' => 'pembelajaran', 'mapel' => 'Sentra Peran',      'hari' => 'Jumat',  'waktu' => '08:00 - 09:00', 'kelas' => 'TK A'],
            19 => ['id' => 19, 'jenis' => 'pembelajaran', 'mapel' => 'Sentra Seni',       'hari' => 'Jumat',  'waktu' => '08:00 - 09:00', 'kelas' => 'TK B'],
            20 => ['id' => 20, 'jenis' => 'pembelajaran', 'mapel' => 'Cerita & Literasi', 'hari' => 'Jumat',  'waktu' => '09:00 - 10:00', 'kelas' => 'Semua'],
        ];

        $source = $jenis === 'pembelajaran' ? $pembelajaranData : $kegiatanData;

        if (!isset($source[$id])) {
            return redirect()->route('guru.jadwal.index')->with('error', 'Jadwal tidak ditemukan.');
        }

        $jadwal = $source[$id];

        $kelasList = [
            ['id' => 1, 'nama' => 'A1'],
            ['id' => 2, 'nama' => 'B1'],
            ['id' => 3, 'nama' => 'B2'],
        ];

        return view('guru.jadwal.edit', compact('jadwal', 'kelasList'));
    }

    /**
     * Jadwal - Update
     */
    public function jadwalUpdate(Request $request, $id)
    {
        // Dummy - redirect with success
        return redirect()->route('guru.jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Jadwal - Delete
     */
    public function jadwalDestroy($id)
    {
        // Dummy - redirect with success
        return redirect()->route('guru.jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
    }

    // ═══════════════════════════════════════════════════════
    // RAPOT SEMESTER
    // ═══════════════════════════════════════════════════════

    private function dummyRapotClassTerms(): array
    {
        return [
            ['id' => 'ct1', 'kelas_nama' => 'A1', 'tahun_ajaran' => '2025/2026', 'semester' => 'ganjil', 'status' => 'aktif'],
            ['id' => 'ct2', 'kelas_nama' => 'A2', 'tahun_ajaran' => '2025/2026', 'semester' => 'ganjil', 'status' => 'aktif'],
            ['id' => 'ct3', 'kelas_nama' => 'B1', 'tahun_ajaran' => '2025/2026', 'semester' => 'ganjil', 'status' => 'aktif'],
            ['id' => 'ct4', 'kelas_nama' => 'B2', 'tahun_ajaran' => '2025/2026', 'semester' => 'ganjil', 'status' => 'aktif'],
            ['id' => 'ct5', 'kelas_nama' => 'A1', 'tahun_ajaran' => '2024/2025', 'semester' => 'genap',  'status' => 'selesai'],
            ['id' => 'ct6', 'kelas_nama' => 'B1', 'tahun_ajaran' => '2024/2025', 'semester' => 'genap',  'status' => 'selesai'],
        ];
    }

    private function dummyRapotStudents(): array
    {
        return [
            'ct1' => [
                ['id' => 's1',  'nama' => 'Ahmad Fauzi',     'nis' => '2025001', 'jenis_kelamin' => 'L', 'has_report' => true],
                ['id' => 's2',  'nama' => 'Siti Nurhaliza',  'nis' => '2025002', 'jenis_kelamin' => 'P', 'has_report' => true],
                ['id' => 's3',  'nama' => 'Budi Santoso',    'nis' => '2025003', 'jenis_kelamin' => 'L', 'has_report' => false],
                ['id' => 's4',  'nama' => 'Dewi Lestari',    'nis' => '2025004', 'jenis_kelamin' => 'P', 'has_report' => false],
            ],
            'ct2' => [
                ['id' => 's5',  'nama' => 'Eko Prasetyo',    'nis' => '2025005', 'jenis_kelamin' => 'L', 'has_report' => false],
                ['id' => 's6',  'nama' => 'Rina Susanti',    'nis' => '2025006', 'jenis_kelamin' => 'P', 'has_report' => false],
                ['id' => 's7',  'nama' => 'Doni Saputra',    'nis' => '2025007', 'jenis_kelamin' => 'L', 'has_report' => false],
            ],
            'ct3' => [
                ['id' => 's8',  'nama' => 'Fitri Handayani', 'nis' => '2025008', 'jenis_kelamin' => 'P', 'has_report' => true],
                ['id' => 's9',  'nama' => 'Gilang Permana',  'nis' => '2025009', 'jenis_kelamin' => 'L', 'has_report' => false],
                ['id' => 's10', 'nama' => 'Hana Pertiwi',    'nis' => '2025010', 'jenis_kelamin' => 'P', 'has_report' => false],
            ],
            'ct4' => [
                ['id' => 's11', 'nama' => 'Indra Kusuma',    'nis' => '2025011', 'jenis_kelamin' => 'L', 'has_report' => false],
                ['id' => 's12', 'nama' => 'Julia Safitri',   'nis' => '2025012', 'jenis_kelamin' => 'P', 'has_report' => false],
                ['id' => 's13', 'nama' => 'Kevin Pratama',   'nis' => '2025013', 'jenis_kelamin' => 'L', 'has_report' => false],
            ],
            'ct5' => [
                ['id' => 's1',  'nama' => 'Ahmad Fauzi',     'nis' => '2025001', 'jenis_kelamin' => 'L', 'has_report' => true],
                ['id' => 's2',  'nama' => 'Siti Nurhaliza',  'nis' => '2025002', 'jenis_kelamin' => 'P', 'has_report' => true],
                ['id' => 's3',  'nama' => 'Budi Santoso',    'nis' => '2025003', 'jenis_kelamin' => 'L', 'has_report' => true],
                ['id' => 's4',  'nama' => 'Dewi Lestari',    'nis' => '2025004', 'jenis_kelamin' => 'P', 'has_report' => true],
            ],
            'ct6' => [
                ['id' => 's8',  'nama' => 'Fitri Handayani', 'nis' => '2025008', 'jenis_kelamin' => 'P', 'has_report' => true],
                ['id' => 's9',  'nama' => 'Gilang Permana',  'nis' => '2025009', 'jenis_kelamin' => 'L', 'has_report' => true],
                ['id' => 's10', 'nama' => 'Hana Pertiwi',    'nis' => '2025010', 'jenis_kelamin' => 'P', 'has_report' => true],
            ],
        ];
    }

    private function dummyRapotSubjectsAll(): array
    {
        $subjects = [
            ['id' => 'sub1', 'nama' => 'Nilai Agama & Moral'],
            ['id' => 'sub2', 'nama' => 'Fisik Motorik'],
            ['id' => 'sub3', 'nama' => 'Kognitif'],
            ['id' => 'sub4', 'nama' => 'Bahasa'],
            ['id' => 'sub5', 'nama' => 'Sosial Emosional'],
            ['id' => 'sub6', 'nama' => 'Seni'],
        ];
        return array_fill_keys(['ct1', 'ct2', 'ct3', 'ct4', 'ct5', 'ct6'], $subjects);
    }

    private function dummyRapotExtracurricularsAll(): array
    {
        return [
            'ct1' => [
                ['id' => 'ext1', 'nama' => 'Menggambar', 'assessments' => [
                    ['id' => 'ea1', 'nama' => 'Kreativitas'],
                    ['id' => 'ea2', 'nama' => 'Ketelitian'],
                    ['id' => 'ea3', 'nama' => 'Kebersihan Karya'],
                ]],
                ['id' => 'ext2', 'nama' => 'Menyanyi', 'assessments' => [
                    ['id' => 'ea4', 'nama' => 'Intonasi'],
                    ['id' => 'ea5', 'nama' => 'Hafalan Lagu'],
                ]],
            ],
            'ct2' => [
                ['id' => 'ext1', 'nama' => 'Menggambar', 'assessments' => [
                    ['id' => 'ea1', 'nama' => 'Kreativitas'],
                    ['id' => 'ea2', 'nama' => 'Ketelitian'],
                ]],
                ['id' => 'ext3', 'nama' => 'Olahraga', 'assessments' => [
                    ['id' => 'ea6', 'nama' => 'Kecepatan'],
                    ['id' => 'ea7', 'nama' => 'Ketangkasan'],
                ]],
            ],
            'ct3' => [
                ['id' => 'ext4', 'nama' => 'Tari Tradisional', 'assessments' => [
                    ['id' => 'ea8',  'nama' => 'Ketepatan Gerakan'],
                    ['id' => 'ea9',  'nama' => 'Ekspresi'],
                    ['id' => 'ea10', 'nama' => 'Hafalan Koreografi'],
                ]],
            ],
            'ct4' => [
                ['id' => 'ext2', 'nama' => 'Menyanyi', 'assessments' => [
                    ['id' => 'ea4', 'nama' => 'Intonasi'],
                    ['id' => 'ea5', 'nama' => 'Hafalan Lagu'],
                ]],
                ['id' => 'ext3', 'nama' => 'Olahraga', 'assessments' => [
                    ['id' => 'ea6', 'nama' => 'Kecepatan'],
                    ['id' => 'ea7', 'nama' => 'Ketangkasan'],
                ]],
            ],
            'ct5' => [
                ['id' => 'ext1', 'nama' => 'Menggambar', 'assessments' => [
                    ['id' => 'ea1', 'nama' => 'Kreativitas'],
                    ['id' => 'ea2', 'nama' => 'Ketelitian'],
                ]],
                ['id' => 'ext2', 'nama' => 'Menyanyi', 'assessments' => [
                    ['id' => 'ea4', 'nama' => 'Intonasi'],
                    ['id' => 'ea5', 'nama' => 'Hafalan Lagu'],
                ]],
            ],
            'ct6' => [
                ['id' => 'ext4', 'nama' => 'Tari Tradisional', 'assessments' => [
                    ['id' => 'ea8', 'nama' => 'Ketepatan Gerakan'],
                    ['id' => 'ea9', 'nama' => 'Ekspresi'],
                ]],
                ['id' => 'ext3', 'nama' => 'Olahraga', 'assessments' => [
                    ['id' => 'ea6', 'nama' => 'Kecepatan'],
                    ['id' => 'ea7', 'nama' => 'Ketangkasan'],
                ]],
            ],
        ];
    }

    private function dummyRapotCounselingAll(): array
    {
        return [
            'ct1' => [
                ['id' => 'con1', 'nama' => 'Perkembangan Sosial', 'assessments' => [
                    ['id' => 'ca1', 'nama' => 'Interaksi dengan teman'],
                    ['id' => 'ca2', 'nama' => 'Kemampuan berbagi'],
                    ['id' => 'ca3', 'nama' => 'Kepatuhan aturan'],
                ]],
                ['id' => 'con2', 'nama' => 'Perkembangan Emosi', 'assessments' => [
                    ['id' => 'ca4', 'nama' => 'Mengelola emosi'],
                    ['id' => 'ca5', 'nama' => 'Empati terhadap teman'],
                ]],
            ],
            'ct2' => [
                ['id' => 'con1', 'nama' => 'Perkembangan Sosial', 'assessments' => [
                    ['id' => 'ca1', 'nama' => 'Interaksi dengan teman'],
                    ['id' => 'ca2', 'nama' => 'Kemampuan berbagi'],
                ]],
                ['id' => 'con3', 'nama' => 'Perkembangan Kognitif', 'assessments' => [
                    ['id' => 'ca6', 'nama' => 'Daya tangkap'],
                    ['id' => 'ca7', 'nama' => 'Kreativitas berpikir'],
                ]],
            ],
            'ct3' => [
                ['id' => 'con2', 'nama' => 'Perkembangan Emosi', 'assessments' => [
                    ['id' => 'ca4', 'nama' => 'Mengelola emosi'],
                    ['id' => 'ca5', 'nama' => 'Empati terhadap teman'],
                ]],
                ['id' => 'con3', 'nama' => 'Perkembangan Kognitif', 'assessments' => [
                    ['id' => 'ca6', 'nama' => 'Daya tangkap'],
                    ['id' => 'ca7', 'nama' => 'Kreativitas berpikir'],
                ]],
            ],
            'ct4' => [
                ['id' => 'con1', 'nama' => 'Perkembangan Sosial', 'assessments' => [
                    ['id' => 'ca1', 'nama' => 'Interaksi dengan teman'],
                    ['id' => 'ca2', 'nama' => 'Kemampuan berbagi'],
                    ['id' => 'ca3', 'nama' => 'Kepatuhan aturan'],
                ]],
            ],
            'ct5' => [
                ['id' => 'con1', 'nama' => 'Perkembangan Sosial', 'assessments' => [
                    ['id' => 'ca1', 'nama' => 'Interaksi dengan teman'],
                    ['id' => 'ca2', 'nama' => 'Kemampuan berbagi'],
                ]],
                ['id' => 'con2', 'nama' => 'Perkembangan Emosi', 'assessments' => [
                    ['id' => 'ca4', 'nama' => 'Mengelola emosi'],
                    ['id' => 'ca5', 'nama' => 'Empati terhadap teman'],
                ]],
            ],
            'ct6' => [
                ['id' => 'con3', 'nama' => 'Perkembangan Kognitif', 'assessments' => [
                    ['id' => 'ca6', 'nama' => 'Daya tangkap'],
                    ['id' => 'ca7', 'nama' => 'Kreativitas berpikir'],
                ]],
                ['id' => 'con2', 'nama' => 'Perkembangan Emosi', 'assessments' => [
                    ['id' => 'ca4', 'nama' => 'Mengelola emosi'],
                    ['id' => 'ca5', 'nama' => 'Empati terhadap teman'],
                ]],
            ],
        ];
    }

    private function dummyRapotPrefilledScores(string $classTermId, string $studentId): array
    {
        $levels = ['BSH', 'BSB', 'MB', 'BSH'];

        $subjectScores = [];
        foreach (($this->dummyRapotSubjectsAll()[$classTermId] ?? []) as $sub) {
            $idx = abs(crc32($studentId . $sub['id'])) % 4;
            $subjectScores[$sub['id']] = ['level' => $levels[$idx], 'catatan' => ''];
        }

        $extScores = [];
        foreach (($this->dummyRapotExtracurricularsAll()[$classTermId] ?? []) as $ext) {
            foreach ($ext['assessments'] as $ea) {
                $idx = abs(crc32($studentId . $ea['id'])) % 4;
                $extScores[$ea['id']] = $levels[$idx];
            }
        }

        $conScores = [];
        foreach (($this->dummyRapotCounselingAll()[$classTermId] ?? []) as $con) {
            foreach ($con['assessments'] as $ca) {
                $idx = abs(crc32($studentId . $ca['id'])) % 4;
                $conScores[$ca['id']] = $levels[$idx];
            }
        }

        return [
            'subjects'         => $subjectScores,
            'extracurriculars' => $extScores,
            'counseling'       => $conScores,
            'catatan_guru'     => 'Ananda menunjukkan perkembangan yang baik selama semester ini.',
        ];
    }

    private function buildEmptyScores(string $classTermId): array
    {
        $subjectScores = [];
        foreach (($this->dummyRapotSubjectsAll()[$classTermId] ?? []) as $sub) {
            $subjectScores[$sub['id']] = ['level' => null, 'catatan' => ''];
        }
        $extScores = [];
        foreach (($this->dummyRapotExtracurricularsAll()[$classTermId] ?? []) as $ext) {
            foreach ($ext['assessments'] as $ea) {
                $extScores[$ea['id']] = null;
            }
        }
        $conScores = [];
        foreach (($this->dummyRapotCounselingAll()[$classTermId] ?? []) as $con) {
            foreach ($con['assessments'] as $ca) {
                $conScores[$ca['id']] = null;
            }
        }
        return ['subjects' => $subjectScores, 'extracurriculars' => $extScores, 'counseling' => $conScores, 'catatan_guru' => ''];
    }

    private function getRapotScores(string $classTermId, string $studentId, bool $hasDummyReport): array
    {
        $key = 'rapot_' . $classTermId . '_' . $studentId;
        if (session()->has($key)) {
            return session($key);
        }
        if ($hasDummyReport) {
            return $this->dummyRapotPrefilledScores($classTermId, $studentId);
        }
        return $this->buildEmptyScores($classTermId);
    }

    public function rapotIndex()
    {
        $allStudents = $this->dummyRapotStudents();

        $classTerms = collect($this->dummyRapotClassTerms())->map(function ($ct) use ($allStudents) {
            $students   = $allStudents[$ct['id']] ?? [];
            $total      = count($students);
            $sudahRapot = collect($students)->filter(function ($s) use ($ct) {
                return $s['has_report'] || session()->has('rapot_' . $ct['id'] . '_' . $s['id']);
            })->count();
            $ct['total_siswa'] = $total;
            $ct['sudah_rapot'] = $sudahRapot;
            return $ct;
        });

        $grouped = $classTerms->groupBy('tahun_ajaran');
        return view('guru.rapot.index', compact('grouped'));
    }

    public function rapotShow($id)
    {
        $classTerm = collect($this->dummyRapotClassTerms())->firstWhere('id', $id);
        if (!$classTerm) {
            return redirect()->route('guru.rapot.index')->with('error', 'Class term tidak ditemukan.');
        }

        $students = collect($this->dummyRapotStudents()[$id] ?? [])
            ->map(function ($s) use ($id) {
                $s['has_report'] = $s['has_report'] || session()->has('rapot_' . $id . '_' . $s['id']);
                return $s;
            })
            ->values();

        $sudahRapot = $students->where('has_report', true)->count();
        $total      = $students->count();

        return view('guru.rapot.show', compact('classTerm', 'students', 'sudahRapot', 'total'));
    }

    public function rapotSiswaForm($classTermId, $studentId)
    {
        $classTerm = collect($this->dummyRapotClassTerms())->firstWhere('id', $classTermId);
        if (!$classTerm) abort(404);

        $student = collect($this->dummyRapotStudents()[$classTermId] ?? [])->firstWhere('id', $studentId);
        if (!$student) abort(404);

        $hasReport        = $student['has_report'] || session()->has('rapot_' . $classTermId . '_' . $studentId);
        $subjects         = $this->dummyRapotSubjectsAll()[$classTermId] ?? [];
        $extracurriculars = $this->dummyRapotExtracurricularsAll()[$classTermId] ?? [];
        $counselings      = $this->dummyRapotCounselingAll()[$classTermId] ?? [];
        $scores           = $this->getRapotScores($classTermId, $studentId, $student['has_report']);

        return view('guru.rapot.siswa', compact(
            'classTerm', 'student', 'hasReport',
            'subjects', 'extracurriculars', 'counselings', 'scores'
        ));
    }

    public function rapotSiswaSave(Request $request, $classTermId, $studentId)
    {
        $key = 'rapot_' . $classTermId . '_' . $studentId;
        session([$key => [
            'subjects'         => $request->input('subjects', []),
            'extracurriculars' => $request->input('extracurriculars', []),
            'counseling'       => $request->input('counseling', []),
            'catatan_guru'     => $request->input('catatan_guru', ''),
        ]]);

        return redirect()->route('guru.rapot.show', $classTermId)
            ->with('success', 'Nilai rapot berhasil disimpan.');
    }

    public function rapotCreate()
    {
        $siswaList = [
            ['id' => 1, 'nama' => 'Ahmad Fauzi',    'kelas' => 'TK A'],
            ['id' => 2, 'nama' => 'Siti Nurhaliza', 'kelas' => 'TK A'],
            ['id' => 3, 'nama' => 'Budi Santoso',   'kelas' => 'TK B'],
        ];
        return view('guru.rapot.create', compact('siswaList'));
    }

    public function rapotStore(Request $request)
    {
        return redirect()->route('guru.rapot.index')->with('success', 'Rapot berhasil ditambahkan.');
    }

    public function rapotEdit($id)
    {
        $siswaList = [['id' => 1, 'nama' => 'Ahmad Fauzi', 'kelas' => 'TK A']];
        $rapot = [
            'id' => $id, 'siswa' => ['id' => 1, 'nama' => 'Ahmad Fauzi'],
            'kelas' => 'TK A', 'tahun_ajaran' => '2025/2026', 'semester' => 'Ganjil',
            'tanggal_terbit' => '2025-12-15', 'status' => 'Terbit',
            'nilai' => [
                'agama_moral' => 'BSH', 'agama_moral_deskripsi' => '',
                'fisik_motorik' => 'BSB', 'fisik_motorik_deskripsi' => '',
                'kognitif' => 'BSH', 'kognitif_deskripsi' => '',
                'bahasa' => 'BSH', 'bahasa_deskripsi' => '',
                'sosial_emosional' => 'BSH', 'sosial_emosional_deskripsi' => '',
                'seni' => 'BSB', 'seni_deskripsi' => '',
            ],
            'kehadiran'    => ['hadir' => 85, 'izin' => 3, 'sakit' => 2, 'alpa' => 0],
            'catatan_guru' => '', 'rekomendasi' => '',
        ];
        return view('guru.rapot.edit', compact('rapot', 'siswaList'));
    }

    public function rapotUpdate(Request $request, $id)
    {
        return redirect()->route('guru.rapot.index')->with('success', 'Rapot berhasil diupdate.');
    }

    public function rapotDestroy($id)
    {
        return redirect()->route('guru.rapot.index')->with('success', 'Rapot berhasil dihapus.');
    }
}
