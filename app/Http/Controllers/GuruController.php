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
        $request->validate([
            'kontak_id' => 'required|integer',
            'pesan'     => 'required|string|max:1000',
        ]);

        // TODO: simpan pesan ke database
        // Chat::create(['dari'=>'guru','kontak_id'=>$request->kontak_id,'teks'=>$request->pesan]);

        return redirect()->route('guru.chat', ['kontak_id' => $request->kontak_id]);
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
        $request->validate([
            'siswa_id'              => 'required',
            'minggu_ke'             => 'required|integer|min:1|max:52',
            'tanggal'               => 'required|date',
            'nilai_fisik_motorik'   => 'required|integer|between:1,5',
            'nilai_kognitif'        => 'required|integer|between:1,5',
            'nilai_bahasa'          => 'required|integer|between:1,5',
            'nilai_sosial_emosional'=> 'required|integer|between:1,5',
            'nilai_nilai_agama_moral'=> 'required|integer|between:1,5',
            'nilai_seni'            => 'required|integer|between:1,5',
        ]);

        // TODO: simpan ke database
        // PerkembanganAnak::create($request->validated());

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
    // Tambahkan method kehadiran, laporan, jadwal, perkembangan, chat
}
