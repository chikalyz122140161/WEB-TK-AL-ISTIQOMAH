<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function jadwalKonseling(Request $request)
    {
        $bulan = (int) $request->get('bulan', date('n'));

        // TODO: query database
        $semua = [
            ['tanggal' => '29 Nov 2024', 'waktu' => '10:00 - 11:00', 'orang_tua' => 'Ibu Siti',   'siswa' => 'Ahmad Fauzi',    'topik' => 'Perkembangan Sosial',   'status' => 'disetujui', 'bulan' => 11],
            ['tanggal' => '28 Nov 2024', 'waktu' => '09:00 - 10:00', 'orang_tua' => 'Bapak Budi', 'siswa' => 'Siti Nurhaliza', 'topik' => 'Konsultasi Umum',       'status' => 'pending',   'bulan' => 11],
            ['tanggal' => '27 Nov 2024', 'waktu' => '13:00 - 14:00', 'orang_tua' => 'Ibu Dewi',   'siswa' => 'Eko Prasetyo',   'topik' => 'Perkembangan Kognitif', 'status' => 'disetujui', 'bulan' => 11],
            ['tanggal' => '22 Nov 2024', 'waktu' => '10:00 - 11:00', 'orang_tua' => 'Ibu Ani',    'siswa' => 'Rina Susanti',   'topik' => 'Perkembangan Bahasa',   'status' => 'selesai',   'bulan' => 11],
            ['tanggal' => '20 Nov 2024', 'waktu' => '14:00 - 15:00', 'orang_tua' => 'Bapak Hadi', 'siswa' => 'Doni Saputra',   'topik' => 'Perkembangan Motorik',  'status' => 'selesai',   'bulan' => 11],
        ];

        $jadwal = collect($semua)->where('bulan', $bulan)->values()->all();

        return view('guru.jadwal_konseling', compact('jadwal', 'bulan'));
    }

    public function storeJadwalKonseling(Request $request)
    {
        // TODO: simpan ke database
        return redirect()->route('guru.jadwal_konseling')->with('success', 'Jadwal berhasil dibuat.');
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
        $daftarSiswa = [
            ['id' => 1, 'nama' => 'Ahmad Fauzi',   'kelas' => 'TK A'],
            ['id' => 2, 'nama' => 'Siti Nurhaliza', 'kelas' => 'TK A'],
            ['id' => 3, 'nama' => 'Budi Santoso',   'kelas' => 'TK B'],
            ['id' => 4, 'nama' => 'Dewi Lestari',   'kelas' => 'TK A'],
            ['id' => 5, 'nama' => 'Eko Prasetyo',   'kelas' => 'TK B'],
        ];

        // Dummy data laporan — nanti diganti query database
        $semua = [
            ['id' => 1, 'siswa_id' => 1, 'nama' => 'Ahmad Fauzi',   'kelas' => 'TK A', 'minggu' => 12, 'tanggal' => '22 Nov 2024', 'rata_rata' => 4.2],
            ['id' => 2, 'siswa_id' => 2, 'nama' => 'Siti Nurhaliza', 'kelas' => 'TK A', 'minggu' => 12, 'tanggal' => '22 Nov 2024', 'rata_rata' => 4.5],
            ['id' => 3, 'siswa_id' => 3, 'nama' => 'Budi Santoso',   'kelas' => 'TK B', 'minggu' => 12, 'tanggal' => '22 Nov 2024', 'rata_rata' => 3.8],
            ['id' => 4, 'siswa_id' => 4, 'nama' => 'Dewi Lestari',   'kelas' => 'TK A', 'minggu' => 12, 'tanggal' => '22 Nov 2024', 'rata_rata' => 4.0],
            ['id' => 5, 'siswa_id' => 5, 'nama' => 'Eko Prasetyo',   'kelas' => 'TK B', 'minggu' => 12, 'tanggal' => '22 Nov 2024', 'rata_rata' => 4.3],
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

    public function grafik()
    {
        $daftarSiswa = [
            ['id' => 1, 'nama' => 'Ahmad Rizky'],
            ['id' => 2, 'nama' => 'Anisa Putri'],
            ['id' => 3, 'nama' => 'Muhammad Fauzi'],
            ['id' => 4, 'nama' => 'Tika Rahayu'],
            ['id' => 5, 'nama' => 'Siti Aisyah'],
        ];

        $daftarMinggu = range(1, 20);
        $siswaAktif   = $daftarSiswa[2];   // default: Ahmad Fauzi
        $mingguAktif  = 12;

        // Dummy data perkembangan — nanti diganti query database
        $nilaiPerSiswa = [
            1 => [
                10 => ['fisik_motorik'=>3,'kognitif'=>4,'bahasa'=>3,'sosial_emosional'=>2,'nilai_agama_moral'=>4,'seni'=>3],
                12 => ['fisik_motorik'=>4,'kognitif'=>5,'bahasa'=>4,'sosial_emosional'=>3,'nilai_agama_moral'=>5,'seni'=>4],
            ],
            2 => [
                12 => ['fisik_motorik'=>5,'kognitif'=>4,'bahasa'=>5,'sosial_emosional'=>4,'nilai_agama_moral'=>5,'seni'=>5],
            ],
            3 => [
                12 => ['fisik_motorik'=>4,'kognitif'=>5,'bahasa'=>4,'sosial_emosional'=>3,'nilai_agama_moral'=>5,'seni'=>4],
            ],
            4 => [
                12 => ['fisik_motorik'=>3,'kognitif'=>3,'bahasa'=>3,'sosial_emosional'=>4,'nilai_agama_moral'=>3,'seni'=>3],
            ],
            5 => [
                12 => ['fisik_motorik'=>4,'kognitif'=>4,'bahasa'=>3,'sosial_emosional'=>4,'nilai_agama_moral'=>4,'seni'=>5],
            ],
        ];

        return view('guru.grafik', compact(
            'daftarSiswa', 'daftarMinggu', 'siswaAktif', 'mingguAktif', 'nilaiPerSiswa'
        ));
    }

    public function inputPerkembangan()
    {
        // Nanti diganti query ke model Siswa
        $daftarSiswa = [
            ['id' => 1, 'nama' => 'Ahmad Rizky'],
            ['id' => 2, 'nama' => 'Anisa Putri'],
            ['id' => 3, 'nama' => 'Muhammad Fauzi'],
            ['id' => 4, 'nama' => 'Tika Rahayu'],
            ['id' => 5, 'nama' => 'Siti Aisyah'],
        ];

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
        // Data dummy — nanti diganti query database
        $data = [
            'userName'         => 'Ibu Siti',
            'totalSiswa'       => 20,
            'konselingBulanIni' => 15,
            'pengajuanJadwal'  => 3,
            'semester'         => 'Ganjil 2024/2025',
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
        // Dummy data siswa
        $siswaList = [
            ['id' => 1, 'nama' => 'Ahmad Fauzi', 'kelas' => 'TK A'],
            ['id' => 2, 'nama' => 'Siti Nurhaliza', 'kelas' => 'TK A'],
            ['id' => 3, 'nama' => 'Budi Santoso', 'kelas' => 'TK B'],
            ['id' => 4, 'nama' => 'Dewi Lestari', 'kelas' => 'TK A'],
            ['id' => 5, 'nama' => 'Eko Prasetyo', 'kelas' => 'TK B'],
        ];

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
            ['id' => 1, 'hari' => 'Senin', 'waktu' => '08:00 - 09:00', 'mapel' => 'Sentra Balok', 'kelas' => 'TK A', 'guru' => 'Bu Siti'],
            ['id' => 2, 'hari' => 'Senin', 'waktu' => '09:00 - 10:00', 'mapel' => 'Sentra Seni', 'kelas' => 'TK A', 'guru' => 'Bu Ani'],
            ['id' => 3, 'hari' => 'Senin', 'waktu' => '08:00 - 09:00', 'mapel' => 'Sentra Alam', 'kelas' => 'TK B', 'guru' => 'Bu Dewi'],
            ['id' => 4, 'hari' => 'Selasa', 'waktu' => '08:00 - 09:00', 'mapel' => 'Sentra Peran', 'kelas' => 'TK A', 'guru' => 'Bu Siti'],
            ['id' => 5, 'hari' => 'Selasa', 'waktu' => '08:00 - 09:00', 'mapel' => 'Sentra Balok', 'kelas' => 'TK B', 'guru' => 'Bu Ani'],
            ['id' => 6, 'hari' => 'Rabu', 'waktu' => '08:00 - 09:00', 'mapel' => 'Agama Islam', 'kelas' => 'TK A', 'guru' => 'Ustadzah Maya'],
            ['id' => 7, 'hari' => 'Rabu', 'waktu' => '08:00 - 09:00', 'mapel' => 'Agama Islam', 'kelas' => 'TK B', 'guru' => 'Ustadzah Maya'],
        ];

        return view('guru.jadwal.index', compact('jadwalKegiatan', 'jadwalPembelajaran'));
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
    public function jadwalEdit($id)
    {
        // Dummy data jadwal
        $allJadwal = [
            1 => ['id' => 1, 'jenis' => 'kegiatan', 'nama' => 'Upacara Bendera', 'tanggal_raw' => '2026-03-10', 'waktu_mulai' => '07:00', 'waktu_selesai' => '08:00', 'lokasi' => 'Lapangan', 'kelas' => 'Semua', 'deskripsi' => ''],
            2 => ['id' => 2, 'jenis' => 'kegiatan', 'nama' => 'Senam Pagi', 'tanggal_raw' => '2026-03-11', 'waktu_mulai' => '07:30', 'waktu_selesai' => '08:00', 'lokasi' => 'Lapangan', 'kelas' => 'Semua', 'deskripsi' => ''],
            3 => ['id' => 3, 'jenis' => 'kegiatan', 'nama' => 'Outing Class', 'tanggal_raw' => '2026-03-12', 'waktu_mulai' => '08:00', 'waktu_selesai' => '12:00', 'lokasi' => 'Kebun Binatang', 'kelas' => 'TK B', 'deskripsi' => ''],
            4 => ['id' => 4, 'jenis' => 'kegiatan', 'nama' => 'Lomba Mewarnai', 'tanggal_raw' => '2026-03-13', 'waktu_mulai' => '09:00', 'waktu_selesai' => '11:00', 'lokasi' => 'Aula', 'kelas' => 'Semua', 'deskripsi' => ''],
        ];

        if (!isset($allJadwal[$id])) {
            return redirect()->route('guru.jadwal.index')->with('error', 'Jadwal tidak ditemukan.');
        }

        $jadwal = $allJadwal[$id];

        return view('guru.jadwal.edit', compact('jadwal'));
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

    /**
     * Rapot - Index (Daftar semua rapot)
     */
    public function rapotIndex(Request $request)
    {
        $filterKelas = $request->input('kelas', '');
        $filterSemester = $request->input('semester', '');
        $filterTahun = $request->input('tahun', '');

        // Dummy data rapot
        $rapotList = [
            ['id' => 1, 'siswa' => 'Ahmad Fauzi', 'kelas' => 'TK A', 'tahun_ajaran' => '2025/2026', 'semester' => 'Ganjil', 'tanggal_terbit' => '15 Des 2025', 'status' => 'Terbit'],
            ['id' => 2, 'siswa' => 'Siti Nurhaliza', 'kelas' => 'TK A', 'tahun_ajaran' => '2025/2026', 'semester' => 'Ganjil', 'tanggal_terbit' => '15 Des 2025', 'status' => 'Terbit'],
            ['id' => 3, 'siswa' => 'Budi Santoso', 'kelas' => 'TK B', 'tahun_ajaran' => '2025/2026', 'semester' => 'Ganjil', 'tanggal_terbit' => '15 Des 2025', 'status' => 'Terbit'],
            ['id' => 4, 'siswa' => 'Dewi Lestari', 'kelas' => 'TK A', 'tahun_ajaran' => '2025/2026', 'semester' => 'Ganjil', 'tanggal_terbit' => null, 'status' => 'Draft'],
            ['id' => 5, 'siswa' => 'Eko Prasetyo', 'kelas' => 'TK B', 'tahun_ajaran' => '2024/2025', 'semester' => 'Genap', 'tanggal_terbit' => '20 Jun 2025', 'status' => 'Terbit'],
        ];

        // Filter data
        $rapotList = collect($rapotList)->filter(function ($item) use ($filterKelas, $filterSemester, $filterTahun) {
            if ($filterKelas && $item['kelas'] !== $filterKelas) return false;
            if ($filterSemester && $item['semester'] !== $filterSemester) return false;
            if ($filterTahun && $item['tahun_ajaran'] !== $filterTahun) return false;
            return true;
        })->values()->all();

        return view('guru.rapot.index', compact('rapotList', 'filterKelas', 'filterSemester', 'filterTahun'));
    }

    /**
     * Rapot - Create (Form tambah rapot baru)
     */
    public function rapotCreate()
    {
        // Dummy data siswa
        $siswaList = [
            ['id' => 1, 'nama' => 'Ahmad Fauzi', 'kelas' => 'TK A'],
            ['id' => 2, 'nama' => 'Siti Nurhaliza', 'kelas' => 'TK A'],
            ['id' => 3, 'nama' => 'Budi Santoso', 'kelas' => 'TK B'],
            ['id' => 4, 'nama' => 'Dewi Lestari', 'kelas' => 'TK A'],
            ['id' => 5, 'nama' => 'Eko Prasetyo', 'kelas' => 'TK B'],
            ['id' => 6, 'nama' => 'Rina Susanti', 'kelas' => 'TK A'],
            ['id' => 7, 'nama' => 'Doni Saputra', 'kelas' => 'TK B'],
        ];

        return view('guru.rapot.create', compact('siswaList'));
    }

    /**
     * Rapot - Store (Simpan rapot baru)
     */
    public function rapotStore(Request $request)
    {
        // Dummy - redirect with success
        return redirect()->route('guru.rapot.index')->with('success', 'Rapot berhasil ditambahkan.');
    }

    /**
     * Rapot - Show (Detail rapot)
     */
    public function rapotShow($id)
    {
        // Dummy data rapot detail dengan struktur nested
        $rapot = [
            'id' => $id,
            'siswa' => [
                'id' => 1,
                'nama' => 'Ahmad Fauzi',
            ],
            'kelas' => 'TK A',
            'tahun_ajaran' => '2025/2026',
            'semester' => 'Ganjil',
            'tanggal_terbit' => '2025-12-15',
            'status' => 'Terbit',
            'nilai' => [
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
            ],
            'kehadiran' => [
                'hadir' => 85,
                'izin' => 3,
                'sakit' => 2,
                'alpa' => 0,
            ],
            'catatan_guru' => 'Ananda menunjukkan perkembangan yang sangat baik selama semester ini. Aktif dalam setiap kegiatan pembelajaran dan dapat bekerja sama dengan teman-temannya.',
            'rekomendasi' => 'Disarankan untuk terus memberikan stimulasi membaca di rumah dengan buku cerita bergambar. Ajak anak berdiskusi tentang lingkungan sekitar.',
        ];

        return view('guru.rapot.show', compact('rapot'));
    }

    /**
     * Rapot - Edit (Form edit rapot)
     */
    public function rapotEdit($id)
    {
        // Dummy data siswa
        $siswaList = [
            ['id' => 1, 'nama' => 'Ahmad Fauzi', 'kelas' => 'TK A'],
            ['id' => 2, 'nama' => 'Siti Nurhaliza', 'kelas' => 'TK A'],
            ['id' => 3, 'nama' => 'Budi Santoso', 'kelas' => 'TK B'],
            ['id' => 4, 'nama' => 'Dewi Lestari', 'kelas' => 'TK A'],
            ['id' => 5, 'nama' => 'Eko Prasetyo', 'kelas' => 'TK B'],
        ];

        // Dummy data rapot untuk edit dengan struktur nested
        $rapot = [
            'id' => $id,
            'siswa' => [
                'id' => 1,
                'nama' => 'Ahmad Fauzi',
            ],
            'kelas' => 'TK A',
            'tahun_ajaran' => '2025/2026',
            'semester' => 'Ganjil',
            'tanggal_terbit' => '2025-12-15',
            'status' => 'Terbit',
            'nilai' => [
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
            ],
            'kehadiran' => [
                'hadir' => 85,
                'izin' => 3,
                'sakit' => 2,
                'alpa' => 0,
            ],
            'catatan_guru' => 'Ananda menunjukkan perkembangan yang sangat baik selama semester ini. Aktif dalam setiap kegiatan pembelajaran dan dapat bekerja sama dengan teman-temannya.',
            'rekomendasi' => 'Disarankan untuk terus memberikan stimulasi membaca di rumah dengan buku cerita bergambar. Ajak anak berdiskusi tentang lingkungan sekitar.',
        ];

        return view('guru.rapot.edit', compact('rapot', 'siswaList'));
    }

    /**
     * Rapot - Update (Update rapot)
     */
    public function rapotUpdate(Request $request, $id)
    {
        // Dummy - redirect with success
        return redirect()->route('guru.rapot.index')->with('success', 'Rapot berhasil diupdate.');
    }

    /**
     * Rapot - Destroy (Hapus rapot)
     */
    public function rapotDestroy($id)
    {
        // Dummy - redirect with success
        return redirect()->route('guru.rapot.index')->with('success', 'Rapot berhasil dihapus.');
    }
}
