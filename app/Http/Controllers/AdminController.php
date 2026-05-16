<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\StudentEnrollment;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // DASHBOARD
    public function dashboard()
    {
        $totalSiswa      = Student::count();
        $totalGuru       = User::where('role', 'guru')->count();
        $orangTerdaftar  = User::where('role', 'orangtua')->count();
        $totalKelas      = Classroom::count();

        $aktivitas = [
            ['title' => 'Data Siswa Baru Ditambahkan', 'time' => '2 jam yang lalu'],
            ['title' => 'Pengguna Baru Terdaftar', 'time' => '5 jam yang lalu'],
            ['title' => 'Backup Database Berhasil', 'time' => 'Kemarin'],
        ];

        // Statistik siswa per kelas — via student_enrollment → class_term → class
        $statistik = Classroom::with('classTerms')->get()->map(function ($k) {
            $classTermIds = $k->classTerms->pluck('id');
            $jumlah = StudentEnrollment::whereIn('class_term_id', $classTermIds)
                ->where('status', 'aktif')
                ->distinct('student_id')
                ->count('student_id');
            return ['label' => 'TK ' . $k->name, 'value' => $jumlah . ' Siswa'];
        })->all();

        $statistik[] = ['label' => 'Total Siswa', 'value' => $totalSiswa . ' Siswa'];

        return view('admin.dashboard', compact('totalSiswa', 'totalGuru', 'orangTerdaftar', 'totalKelas', 'aktivitas', 'statistik'));
    }
    
    // KELOLA PENGGUNA
    public function penggunaIndex(Request $request)
    {
        // Dummy data - replace with actual database query
        $pengguna = [
            ['id' => 1, 'nama' => 'Baiq, S.Pd', 'email' => 'admin@tkalistiqomah.sch.id', 'role' => 'Admin', 'status' => 'Aktif', 'tgl_daftar' => '01 Jan 2024'],
            ['id' => 2, 'nama' => 'Rista Wijianti, S.Pd', 'email' => 'rista@tkalistiqomah.sch.id', 'role' => 'Guru', 'status' => 'Aktif', 'tgl_daftar' => '01 Jan 2024'],
            ['id' => 3, 'nama' => 'Ibu Siti', 'email' => 'ibu.siti@gmail.com', 'role' => 'Orang Tua', 'status' => 'Aktif', 'tgl_daftar' => '05 Jan 2024'],
            ['id' => 4, 'nama' => 'Bapak Budi', 'email' => 'budi@gmail.com', 'role' => 'Orang Tua', 'status' => 'Aktif', 'tgl_daftar' => '06 Jan 2024'],
            ['id' => 5, 'nama' => 'Ibu Dewi', 'email' => 'dewi@gmail.com', 'role' => 'Orang Tua', 'status' => 'Aktif', 'tgl_daftar' => '07 Jan 2024'],
            ['id' => 6, 'nama' => 'Julia Sari', 'email' => 'julia.sari@email.com', 'role' => 'Orang Tua', 'status' => 'Pending', 'tgl_daftar' => '05 Mar 2026'],
            ['id' => 7, 'nama' => 'Ratna Sari', 'email' => 'ratna@gmail.com', 'role' => 'Orang Tua', 'status' => 'Pending', 'tgl_daftar' => '06 Mar 2026'],
        ];
        
        return view('admin.pengguna.index', compact('pengguna'));
    }
    
    public function penggunaCreate()
    {
        $siswaOrphan = Student::whereNull('parent_id')
            ->orderBy('kelas')->orderBy('name')
            ->get(['id', 'name', 'kelas', 'nomor_induk', 'nama_ibu', 'nama_ayah']);
        return view('admin.pengguna.create', compact('siswaOrphan'));
    }

    public function penggunaStore(Request $request)
    {
        $request->validate([
            'nama'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'role'                  => 'required|in:admin,guru,orangtua',
            'password'              => 'required|min:6|confirmed',
            'siswa_id'              => 'nullable|exists:students,id',
        ], [
            'email.unique'          => 'Email sudah digunakan.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
            'password.min'          => 'Password minimal 6 karakter.',
        ]);

        $user = User::create([
            'name'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        if ($request->role === 'orangtua' && $request->filled('siswa_id')) {
            Student::where('id', $request->siswa_id)->update(['parent_id' => $user->id]);
        }

        return redirect()->route('admin.pengguna.index')
            ->with('success', 'Pengguna berhasil ditambahkan!');
    }
    
    public function penggunaEdit($id)
    {
        // Get user by id
        $pengguna = [
            'id' => $id,
            'nama' => 'User Name',
            'email' => 'user@example.com',
            'role' => 'orangtua',
            'status' => 'Pending',
            'nomor_telepon' => '08123456789',
        ];
        
        return view('admin.pengguna.edit', compact('pengguna'));
    }
    
    public function penggunaUpdate(Request $request, $id)
    {
        // Dummy - redirect with success
        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil diupdate!');
    }
    
    public function penggunaDestroy($id)
    {
        // Delete user logic here
        
        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil dihapus!');
    }
    
    // KELOLA SISWA
    public function siswaIndex(Request $request)
    {
        $siswa = Student::with('parent')->orderBy('kelas')->orderBy('name')->get()->map(function ($s) {
            $namaOrtu = collect([$s->nama_ayah, $s->nama_ibu])->filter()->implode(' / ');
            return [
                'id'         => $s->id,
                'nis'        => $s->nomor_induk ?? '-',
                'nama'       => $s->name,
                'kelas'      => $s->kelas ? 'TK ' . $s->kelas : '-',
                'jk'         => $s->gender,
                'status'     => 'Aktif',
                'nama_ortu'  => $namaOrtu ?: '-',
                'email_ortu' => $s->parent?->email ?? '-',
            ];
        })->toArray();

        return view('admin.siswa.index', compact('siswa'));
    }
    
    public function siswaCreate()
    {
        return view('admin.siswa.create');
    }
    
    public function siswaStore(Request $request)
    {
        // Dummy - redirect with success
        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil ditambahkan!');
    }
    
    public function siswaEdit($id)
    {
        // Get siswa by id with related orangtua data - sesuai form pendaftaran fisik
        $siswa = [
            'id' => $id,
            'nis' => '2024001',
            // I. Identitas Anak
            'nama' => 'Erlangga Pradipa Bimantara',
            'nama_panggilan' => 'Angga',
            'jenis_kelamin' => 'Laki-laki',
            'tempat_lahir' => 'Bandar Lampung',
            'tanggal_lahir' => '2021-09-25',
            'anak_ke' => 2,
            'jumlah_saudara' => 1,
            'agama' => 'Islam',
            'suku_bangsa' => '',
            'berat_badan' => '13',
            'tinggi_badan' => '',
            'riwayat_penyakit' => '',
            'alamat' => 'Jl. Harum Bunga Perumahan Panca Bakti Bandar Lampung',
            'no_telp' => '0822 8965 2973',
            'kelas' => 'TK A',
            'status' => 'Pending',
            // II. Identitas Orang Tua / Wali Murid
            // 1. Ayah
            'nama_ayah' => 'Sudir',
            'tempat_lahir_ayah' => 'Pemalang',
            'tanggal_lahir_ayah' => '1982-09-01',
            'pekerjaan_ayah' => 'Buruh',
            // 2. Ibu
            'nama_ibu' => 'Julia Sari',
            'tempat_lahir_ibu' => 'Teratkulon',
            'tanggal_lahir_ibu' => '1994-07-04',
            'pekerjaan_ibu' => 'Pengurus Rumah Tangga',
            // 3. Wali
            'nama_wali' => '',
            'tempat_lahir_wali' => '',
            'tanggal_lahir_wali' => '',
            'pekerjaan_wali' => '',
            // Akun Orang Tua
            'email_ortu' => 'julia.sari@email.com',
            'status_akun_ortu' => 'Pending',
            // Dokumen siswa
            'dokumen' => [
                ['id' => 1, 'nama' => 'Akta Kelahiran', 'file' => 'akta_kelahiran_001.pdf', 'type' => 'akta_kelahiran'],
                ['id' => 2, 'nama' => 'Kartu Keluarga', 'file' => 'kk_001.pdf', 'type' => 'kartu_keluarga'],
                ['id' => 3, 'nama' => 'Pas Foto', 'file' => 'foto_001.jpg', 'type' => 'foto'],
            ],
        ];
        
        return view('admin.siswa.edit', compact('siswa'));
    }
    
    public function siswaUpdate(Request $request, $id)
    {
        // Dummy - redirect with success
        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diupdate!');
    }
    
    public function siswaDestroy($id)
    {
        // Delete siswa logic here
        
        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus!');
    }
    
    // BACKUP DATABASE
    public function backupIndex()
    {
        // Dummy backup history - replace with actual file listing
        $backups = [
            ['filename' => 'backup_tk_2024-01-10.sql.gz', 'tanggal' => '10 Jan 2024', 'ukuran' => '2.4 MB'],
            ['filename' => 'backup_tk_2024-01-05.sql.gz', 'tanggal' => '05 Jan 2024', 'ukuran' => '2.1 MB'],
        ];
        
        return view('admin.backup.index', compact('backups'));
    }
    
    public function backupCreate(Request $request)
    {
        // Create backup logic here
        // This would typically use mysqldump or a package like spatie/laravel-backup
        
        return redirect()->route('admin.backup.index')->with('success', 'Backup database berhasil dibuat!');
    }
    
    public function backupRestore(Request $request)
    {
        // Dummy - redirect with success
        return redirect()->route('admin.backup.index')->with('success', 'Database berhasil di-restore!');
    }
    
    public function backupDelete($filename)
    {
        // Delete backup file logic here
        
        return redirect()->route('admin.backup.index')->with('success', 'File backup berhasil dihapus!');
    }
    
    // ═══════════════════════════════════════════════════════
    // KELOLA PENDAFTARAN
    // ═══════════════════════════════════════════════════════
    public function pendaftaranIndex()
    {
        // Dummy data - replace with actual database query
        $pendaftaran = [
            [
                'id' => 1,
                'tanggal_daftar' => '05 Mar 2026',
                'nama_siswa' => 'Erlangga Pradipa Bimantara',
                'nama_panggilan' => 'Angga',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Bandar Lampung',
                'tanggal_lahir' => '25 Sep 2021',
                'agama' => 'Islam',
                'anak_ke' => 2,
                'jumlah_saudara' => 1,
                'alamat_siswa' => 'Jl. Harum Bunga Perumahan Panca Bakti Bandar Lampung',
                'nama_ayah' => 'Sudir',
                'pekerjaan_ayah' => 'Buruh',
                'nama_ibu' => 'Julia Sari',
                'pekerjaan_ibu' => 'Pengurus Rumah Tangga',
                'telepon' => '0822 8965 2973',
                'email' => 'julia.sari@email.com',
                'status' => 'Pending',
                'dokumen' => [
                    ['id' => 1, 'nama' => 'Akta Kelahiran', 'file' => 'akta_kelahiran_001.pdf'],
                    ['id' => 2, 'nama' => 'Kartu Keluarga', 'file' => 'kk_001.pdf'],
                    ['id' => 3, 'nama' => 'Pas Foto', 'file' => 'foto_001.jpg'],
                ],
            ],
            [
                'id' => 2,
                'tanggal_daftar' => '06 Mar 2026',
                'nama_siswa' => 'Putri Amelia',
                'nama_panggilan' => 'Amel',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Bandar Lampung',
                'tanggal_lahir' => '15 Jan 2021',
                'agama' => 'Islam',
                'anak_ke' => 1,
                'jumlah_saudara' => 0,
                'alamat_siswa' => 'Jl. Kenanga No. 45 Bandar Lampung',
                'nama_ayah' => 'Rudi Hartono',
                'pekerjaan_ayah' => 'Wiraswasta',
                'nama_ibu' => 'Ratna Sari',
                'pekerjaan_ibu' => 'Guru',
                'telepon' => '0813 9876 5432',
                'email' => 'ratna@gmail.com',
                'status' => 'Pending',
                'dokumen' => [
                    ['id' => 1, 'nama' => 'Akta Kelahiran', 'file' => 'akta_kelahiran_002.pdf'],
                    ['id' => 2, 'nama' => 'Kartu Keluarga', 'file' => 'kk_002.pdf'],
                ],
            ],
            [
                'id' => 3,
                'tanggal_daftar' => '01 Feb 2026',
                'nama_siswa' => 'Muhammad Rizky',
                'nama_panggilan' => 'Rizky',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Metro',
                'tanggal_lahir' => '20 Agu 2021',
                'agama' => 'Islam',
                'anak_ke' => 1,
                'jumlah_saudara' => 1,
                'alamat_siswa' => 'Jl. Melati No. 10 Metro',
                'nama_ayah' => 'Ahmad Fauzi',
                'pekerjaan_ayah' => 'PNS',
                'nama_ibu' => 'Siti Fatimah',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'telepon' => '0812 3456 7890',
                'email' => 'ahmad.fauzi@email.com',
                'status' => 'Diterima',
                'dokumen' => [],
            ],
            [
                'id' => 4,
                'tanggal_daftar' => '25 Jan 2026',
                'nama_siswa' => 'Dina Rahmawati',
                'nama_panggilan' => 'Dina',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Bandar Lampung',
                'tanggal_lahir' => '05 Des 2020',
                'agama' => 'Islam',
                'anak_ke' => 2,
                'jumlah_saudara' => 1,
                'alamat_siswa' => 'Jl. Anggrek No. 5 Bandar Lampung',
                'nama_ayah' => 'Budi Santoso',
                'pekerjaan_ayah' => 'Pedagang',
                'nama_ibu' => 'Dewi Lestari',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'telepon' => '0856 1234 5678',
                'email' => 'budi.s@email.com',
                'status' => 'Ditolak',
                'dokumen' => [],
            ],
        ];
        
        $totalPending = count(array_filter($pendaftaran, fn($p) => $p['status'] == 'Pending'));
        $totalDiterima = count(array_filter($pendaftaran, fn($p) => $p['status'] == 'Diterima'));
        $totalDitolak = count(array_filter($pendaftaran, fn($p) => $p['status'] == 'Ditolak'));
        $totalSemua = count($pendaftaran);
        
        return view('admin.pendaftaran.index', compact('pendaftaran', 'totalPending', 'totalDiterima', 'totalDitolak', 'totalSemua'));
    }
    
    public function pendaftaranShow($id)
    {
        // Dummy data - replace with actual database query
        $pendaftaran = [
            'id'                  => $id,
            'tanggal_daftar'      => '05 Mar 2026',
            'status'              => 'Pending',

            // Identitas Anak
            'nama_siswa'          => 'Erlangga Pradipa Bimantara',
            'nama_panggilan'      => 'Angga',
            'nik'                 => '1871020509210001',
            'jenis_kelamin'       => 'Laki-laki',
            'agama'               => 'Islam',
            'tempat_lahir'        => 'Bandar Lampung',
            'tanggal_lahir'       => '25 September 2021',
            'anak_ke'             => 2,
            'jumlah_saudara'      => 1,
            'suku_bangsa'         => 'Jawa',
            'riwayat_penyakit'    => '-',
            'berat_badan'         => '13 kg',
            'tinggi_badan'        => '95 cm',
            'alamat_siswa'        => 'Jl. Harum Bunga Perumahan Panca Bakti Bandar Lampung',

            // Data Ayah
            'nama_ayah'           => 'Sudir',
            'pekerjaan_ayah'      => 'Buruh',
            'pendidikan_ayah'     => 'SMA/SMK',
            'tempat_lahir_ayah'   => 'Pemalang',
            'tanggal_lahir_ayah'  => '12 Maret 1985',
            'no_telp_ayah'        => '0822 8965 2973',

            // Data Ibu
            'nama_ibu'            => 'Julia Sari',
            'pekerjaan_ibu'       => 'Pengurus Rumah Tangga',
            'pendidikan_ibu'      => 'SMA/SMK',
            'tempat_lahir_ibu'    => 'Bandar Lampung',
            'tanggal_lahir_ibu'   => '20 Juli 1988',
            'no_telp_ibu'         => '0813 5678 9012',

            // Data Wali
            'nama_wali'           => '-',
            'pekerjaan_wali'      => '-',
            'pendidikan_wali'     => '-',
            'tempat_lahir_wali'   => '-',
            'tanggal_lahir_wali'  => '-',
            'no_telp_wali'        => '-',

            // Kontak
            'telepon'             => '0822 8965 2973',
            'email'               => 'julia.sari@email.com',
            'alamat_ortu'         => 'Jl. Harum Bunga Perumahan Panca Bakti Bandar Lampung',

            // Dokumen
            'dokumen' => [
                ['id' => 1, 'nama' => 'Akta Kelahiran', 'file' => 'akta_kelahiran_001.pdf'],
                ['id' => 2, 'nama' => 'Kartu Keluarga',  'file' => 'kk_001.pdf'],
                ['id' => 3, 'nama' => 'Pas Foto',         'file' => 'foto_001.jpg'],
            ],
        ];
        
        return view('admin.pendaftaran.show', compact('pendaftaran'));
    }
    
    public function pendaftaranTerima(Request $request, $id)
    {
        $kelas       = $request->input('kelas', '-');
        $tahunAjaran = $request->input('tahun_ajaran', '-');
        $semester    = $request->input('semester', '-');

        return redirect()->route('admin.pendaftaran.index')
            ->with('success', "Pendaftaran berhasil diterima! Siswa ditempatkan di Kelas {$kelas}, TA {$tahunAjaran} Semester " . ucfirst($semester) . ".");
    }
    
    public function pendaftaranTolak(Request $request, $id)
    {
        // Logic to reject registration:
        // 1. Update registration status to 'Ditolak'
        // 2. Store rejection reason
        // 3. Send notification email with reason
        
        $alasan = $request->input('alasan_penolakan', 'Tidak memenuhi persyaratan');
        
        return redirect()->route('admin.pendaftaran.index')->with('success', 'Pendaftaran telah ditolak.');
    }
    
    // ═══════════════════════════════════════════════════════
    // KELOLA TAHUN AJARAN
    // ═══════════════════════════════════════════════════════
    private function dummyTahunAjaran()
    {
        return [
            ['id' => 1, 'tahun_ajaran' => '2023/2024', 'semester' => 'ganjil', 'status' => 'selesai'],
            ['id' => 2, 'tahun_ajaran' => '2023/2024', 'semester' => 'genap',  'status' => 'selesai'],
            ['id' => 3, 'tahun_ajaran' => '2024/2025', 'semester' => 'ganjil', 'status' => 'selesai'],
            ['id' => 4, 'tahun_ajaran' => '2024/2025', 'semester' => 'genap',  'status' => 'aktif'],
            ['id' => 5, 'tahun_ajaran' => '2025/2026', 'semester' => 'ganjil', 'status' => 'menunggu'],
        ];
    }

    private function dummyRiwayatKenaikan()
    {
        // Riwayat perubahan class term per siswa, dikelompokkan per tahun ajaran (yang sudah selesai)
        return [
            // Tahun Ajaran 2023/2024 Ganjil (id=1)
            1 => [
                ['siswa_nama' => 'Ahmad Fauzi',     'nis' => '2023001', 'kelas_asal' => 'A1', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'A1 — 2023/2024 Genap'],
                ['siswa_nama' => 'Siti Nurhaliza',  'nis' => '2023002', 'kelas_asal' => 'A1', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'A1 — 2023/2024 Genap'],
                ['siswa_nama' => 'Budi Santoso',    'nis' => '2023003', 'kelas_asal' => 'A1', 'aksi' => 'tinggal_kelas',  'class_term_tujuan' => 'A1 — 2023/2024 Genap'],
                ['siswa_nama' => 'Dewi Lestari',    'nis' => '2023004', 'kelas_asal' => 'B1', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'B1 — 2023/2024 Genap'],
                ['siswa_nama' => 'Eko Prasetyo',    'nis' => '2023005', 'kelas_asal' => 'B2', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'B2 — 2023/2024 Genap'],
            ],
            // Tahun Ajaran 2023/2024 Genap (id=2)
            2 => [
                ['siswa_nama' => 'Ahmad Fauzi',     'nis' => '2023001', 'kelas_asal' => 'A1', 'aksi' => 'ganti_kelas',   'class_term_tujuan' => 'B1 — 2024/2025 Ganjil'],
                ['siswa_nama' => 'Siti Nurhaliza',  'nis' => '2023002', 'kelas_asal' => 'A1', 'aksi' => 'ganti_kelas',   'class_term_tujuan' => 'B2 — 2024/2025 Ganjil'],
                ['siswa_nama' => 'Budi Santoso',    'nis' => '2023003', 'kelas_asal' => 'A1', 'aksi' => 'tinggal_kelas',  'class_term_tujuan' => 'A1 — 2024/2025 Ganjil'],
                ['siswa_nama' => 'Dewi Lestari',    'nis' => '2023004', 'kelas_asal' => 'B1', 'aksi' => 'ganti_kelas',   'class_term_tujuan' => 'B1 — 2024/2025 Ganjil'],
                ['siswa_nama' => 'Eko Prasetyo',    'nis' => '2023005', 'kelas_asal' => 'B2', 'aksi' => 'ganti_kelas',   'class_term_tujuan' => 'B2 — 2024/2025 Ganjil'],
            ],
            // Tahun Ajaran 2024/2025 Ganjil (id=3)
            3 => [
                ['siswa_nama' => 'Ahmad Fauzi',     'nis' => '2024001', 'kelas_asal' => 'B1', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'B1 — 2024/2025 Genap'],
                ['siswa_nama' => 'Siti Nurhaliza',  'nis' => '2024002', 'kelas_asal' => 'B2', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'B2 — 2024/2025 Genap'],
                ['siswa_nama' => 'Budi Santoso',    'nis' => '2023003', 'kelas_asal' => 'A1', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'A1 — 2024/2025 Genap'],
                ['siswa_nama' => 'Dewi Lestari',    'nis' => '2023004', 'kelas_asal' => 'B1', 'aksi' => 'tinggal_kelas',  'class_term_tujuan' => 'B1 — 2024/2025 Genap'],
                ['siswa_nama' => 'Eko Prasetyo',    'nis' => '2023005', 'kelas_asal' => 'B2', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'B2 — 2024/2025 Genap'],
                ['siswa_nama' => 'Fitri Handayani', 'nis' => '2024006', 'kelas_asal' => 'A1', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'A1 — 2024/2025 Genap'],
            ],
        ];
    }

    public function tahunAjaranIndex()
    {
        $data = collect($this->dummyTahunAjaran());
        return view('admin.tahun_ajaran.index', compact('data'));
    }

    public function tahunAjaranShow($id)
    {
        $item = collect($this->dummyTahunAjaran())->firstWhere('id', (int) $id);
        if (!$item || $item['status'] !== 'selesai') {
            return redirect()->route('admin.tahun_ajaran.index')->with('error', 'Riwayat hanya tersedia untuk tahun ajaran yang sudah selesai.');
        }

        $riwayat = $this->dummyRiwayatKenaikan()[(int) $id] ?? [];

        return view('admin.tahun_ajaran.show', compact('item', 'riwayat'));
    }

    public function tahunAjaranCreate()
    {
        return view('admin.tahun_ajaran.create');
    }

    public function tahunAjaranStore(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string',
            'semester'     => 'required|in:ganjil,genap',
        ]);

        return redirect()->route('admin.tahun_ajaran.index')
            ->with('success', "Tahun Ajaran {$request->tahun_ajaran} Semester " . ucfirst($request->semester) . " berhasil ditambahkan.");
    }

    public function tahunAjaranEdit($id)
    {
        $row  = collect($this->dummyTahunAjaran())->firstWhere('id', (int) $id);
        $item = (object) ($row ?? abort(404));
        return view('admin.tahun_ajaran.edit', compact('item'));
    }

    public function tahunAjaranUpdate(Request $request, $id)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string',
            'semester'     => 'required|in:ganjil,genap',
        ]);

        return redirect()->route('admin.tahun_ajaran.index')
            ->with('success', "Tahun Ajaran {$request->tahun_ajaran} Semester " . ucfirst($request->semester) . " berhasil diperbarui.");
    }

    public function tahunAjaranDestroy($id)
    {
        $row  = collect($this->dummyTahunAjaran())->firstWhere('id', (int) $id);
        $label = $row ? "{$row['tahun_ajaran']} " . ucfirst($row['semester']) : 'Tidak diketahui';

        return redirect()->route('admin.tahun_ajaran.index')
            ->with('success', "Tahun Ajaran {$label} berhasil dihapus.");
    }

    // ═══════════════════════════════════════════════════════
    // KELOLA KELAS
    // ═══════════════════════════════════════════════════════
    private function dummyKelas()
    {
        return [
            ['id' => 1, 'nama' => 'A1', 'jumlah_maksimum' => 20],
            ['id' => 2, 'nama' => 'B1', 'jumlah_maksimum' => 20],
            ['id' => 3, 'nama' => 'B2', 'jumlah_maksimum' => 18],
        ];
    }

    public function kelasIndex()
    {
        $kelas = collect($this->dummyKelas());
        return view('admin.kelas.index', compact('kelas'));
    }

    public function kelasCreate()
    {
        $available = ['A1', 'B1', 'B2'];
        return view('admin.kelas.create', compact('available'));
    }

    public function kelasStore(Request $request)
    {
        $request->validate([
            'nama'            => 'required|in:A1,B1,B2',
            'jumlah_maksimum' => 'required|integer|min:1|max:50',
        ]);

        return redirect()->route('admin.kelas.index')
            ->with('success', "Kelas {$request->nama} berhasil ditambahkan.");
    }

    public function kelasEdit($id)
    {
        $data  = collect($this->dummyKelas())->firstWhere('id', (int) $id);
        $kelas = (object) ($data ?? abort(404));
        return view('admin.kelas.edit', compact('kelas'));
    }

    public function kelasUpdate(Request $request, $id)
    {
        $request->validate([
            'nama'            => 'required|in:A1,B1,B2',
            'jumlah_maksimum' => 'required|integer|min:1|max:50',
        ]);

        return redirect()->route('admin.kelas.index')
            ->with('success', "Kelas {$request->nama} berhasil diperbarui.");
    }

    public function kelasDestroy($id)
    {
        $data = collect($this->dummyKelas())->firstWhere('id', (int) $id);
        $nama = $data ? $data['nama'] : 'Tidak diketahui';

        return redirect()->route('admin.kelas.index')
            ->with('success', "Kelas {$nama} berhasil dihapus.");
    }

    // ═══════════════════════════════════════════════════════
    // KELOLA EKSTRAKURIKULER (DUMMY)
    // ═══════════════════════════════════════════════════════
    private function dummyEkstrakurikuler()
    {
        return [
            [
                'id'        => 1,
                'nama'      => 'Menari',
                'penilaian' => [
                    ['id' => 1, 'nama' => 'Kelenturan'],
                    ['id' => 2, 'nama' => 'Ekspresi'],
                    ['id' => 3, 'nama' => 'Hafalan Gerakan'],
                ],
            ],
            [
                'id'        => 2,
                'nama'      => 'Mewarnai',
                'penilaian' => [
                    ['id' => 4, 'nama' => 'Kerapian'],
                    ['id' => 5, 'nama' => 'Kreativitas Warna'],
                    ['id' => 6, 'nama' => 'Ketepatan Bidang'],
                ],
            ],
            [
                'id'        => 3,
                'nama'      => 'Sains Sederhana',
                'penilaian' => [
                    ['id' => 7, 'nama' => 'Rasa Ingin Tahu'],
                    ['id' => 8, 'nama' => 'Ketelitian'],
                ],
            ],
            [
                'id'        => 4,
                'nama'      => 'Bercerita',
                'penilaian' => [
                    ['id' => 9,  'nama' => 'Kelancaran'],
                    ['id' => 10, 'nama' => 'Intonasi'],
                    ['id' => 11, 'nama' => 'Kepercayaan Diri'],
                ],
            ],
        ];
    }

    public function ekstrakurikulerIndex()
    {
        $ekstrakurikuler = collect($this->dummyEkstrakurikuler());
        return view('admin.ekstrakurikuler.index', compact('ekstrakurikuler'));
    }

    public function ekstrakurikulerCreate()
    {
        return view('admin.ekstrakurikuler.create');
    }

    public function ekstrakurikulerStore(Request $request)
    {
        $request->validate([
            'nama'        => 'required|string|max:100',
            'penilaian'   => 'nullable|array',
            'penilaian.*' => 'nullable|string|max:100',
        ]);

        return redirect()->route('admin.ekstrakurikuler.index')
            ->with('success', "Ekstrakurikuler {$request->nama} berhasil ditambahkan.");
    }

    public function ekstrakurikulerEdit($id)
    {
        $data = collect($this->dummyEkstrakurikuler())->firstWhere('id', (int) $id);
        if (!$data) {
            abort(404);
        }
        $ekstrakurikuler = (object) $data;
        return view('admin.ekstrakurikuler.edit', compact('ekstrakurikuler'));
    }

    public function ekstrakurikulerUpdate(Request $request, $id)
    {
        $request->validate([
            'nama'        => 'required|string|max:100',
            'penilaian'   => 'nullable|array',
            'penilaian.*' => 'nullable|string|max:100',
        ]);

        return redirect()->route('admin.ekstrakurikuler.index')
            ->with('success', "Ekstrakurikuler {$request->nama} berhasil diperbarui.");
    }

    public function ekstrakurikulerDestroy($id)
    {
        $data = collect($this->dummyEkstrakurikuler())->firstWhere('id', (int) $id);
        $nama = $data ? $data['nama'] : 'Tidak diketahui';

        return redirect()->route('admin.ekstrakurikuler.index')
            ->with('success', "Ekstrakurikuler {$nama} berhasil dihapus.");
    }

    // ═══════════════════════════════════════════════════════
    // KELOLA KONSELING (DUMMY)
    // ═══════════════════════════════════════════════════════
    private function dummyKonseling()
    {
        return [
            [
                'id'        => 1,
                'nama'      => 'Konseling Sosial-Emosional',
                'penilaian' => [
                    ['id' => 1, 'nama' => 'Kemampuan Berinteraksi'],
                    ['id' => 2, 'nama' => 'Pengelolaan Emosi'],
                    ['id' => 3, 'nama' => 'Empati'],
                ],
            ],
            [
                'id'        => 2,
                'nama'      => 'Konseling Perilaku',
                'penilaian' => [
                    ['id' => 4, 'nama' => 'Kepatuhan Aturan'],
                    ['id' => 5, 'nama' => 'Kemandirian'],
                    ['id' => 6, 'nama' => 'Tanggung Jawab'],
                ],
            ],
            [
                'id'        => 3,
                'nama'      => 'Konseling Belajar',
                'penilaian' => [
                    ['id' => 7, 'nama' => 'Konsentrasi'],
                    ['id' => 8, 'nama' => 'Minat Belajar'],
                ],
            ],
            [
                'id'        => 4,
                'nama'      => 'Konseling Komunikasi',
                'penilaian' => [
                    ['id' => 9,  'nama' => 'Kemampuan Bercerita'],
                    ['id' => 10, 'nama' => 'Kepercayaan Diri'],
                    ['id' => 11, 'nama' => 'Kemampuan Mendengarkan'],
                ],
            ],
        ];
    }

    public function konselingIndex()
    {
        $konseling = collect($this->dummyKonseling());
        return view('admin.konseling.index', compact('konseling'));
    }

    public function konselingCreate()
    {
        return view('admin.konseling.create');
    }

    public function konselingStore(Request $request)
    {
        $request->validate([
            'nama'        => 'required|string|max:100',
            'penilaian'   => 'nullable|array',
            'penilaian.*' => 'nullable|string|max:100',
        ]);

        return redirect()->route('admin.konseling.index')
            ->with('success', "Konseling {$request->nama} berhasil ditambahkan.");
    }

    public function konselingEdit($id)
    {
        $data = collect($this->dummyKonseling())->firstWhere('id', (int) $id);
        if (!$data) {
            abort(404);
        }
        $konseling = (object) $data;
        return view('admin.konseling.edit', compact('konseling'));
    }

    public function konselingUpdate(Request $request, $id)
    {
        $request->validate([
            'nama'        => 'required|string|max:100',
            'penilaian'   => 'nullable|array',
            'penilaian.*' => 'nullable|string|max:100',
        ]);

        return redirect()->route('admin.konseling.index')
            ->with('success', "Konseling {$request->nama} berhasil diperbarui.");
    }

    public function konselingDestroy($id)
    {
        $data = collect($this->dummyKonseling())->firstWhere('id', (int) $id);
        $nama = $data ? $data['nama'] : 'Tidak diketahui';

        return redirect()->route('admin.konseling.index')
            ->with('success', "Konseling {$nama} berhasil dihapus.");
    }

    // ═══════════════════════════════════════════════════════
    // KELOLA MATA PELAJARAN (DUMMY)
    // ═══════════════════════════════════════════════════════
    private function dummyMataPelajaran()
    {
        return [
            ['id' => 1, 'nama' => 'Pendidikan Agama Islam'],
            ['id' => 2, 'nama' => 'Sentra Balok'],
            ['id' => 3, 'nama' => 'Sentra Bahan Alam'],
            ['id' => 4, 'nama' => 'Sentra Seni'],
            ['id' => 5, 'nama' => 'Sentra Peran'],
            ['id' => 6, 'nama' => 'Bahasa Indonesia'],
            ['id' => 7, 'nama' => 'Berhitung'],
            ['id' => 8, 'nama' => 'Menyanyi & Musik'],
            ['id' => 9, 'nama' => 'Senam & Olahraga'],
        ];
    }

    public function mataPelajaranIndex()
    {
        $mataPelajaran = collect($this->dummyMataPelajaran());
        return view('admin.mata_pelajaran.index', compact('mataPelajaran'));
    }

    public function mataPelajaranCreate()
    {
        return view('admin.mata_pelajaran.create');
    }

    public function mataPelajaranStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
        ]);

        return redirect()->route('admin.mata_pelajaran.index')
            ->with('success', "Mata pelajaran {$request->nama} berhasil ditambahkan.");
    }

    public function mataPelajaranEdit($id)
    {
        $data = collect($this->dummyMataPelajaran())->firstWhere('id', (int) $id);
        if (!$data) {
            abort(404);
        }
        $mataPelajaran = (object) $data;
        return view('admin.mata_pelajaran.edit', compact('mataPelajaran'));
    }

    public function mataPelajaranUpdate(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
        ]);

        return redirect()->route('admin.mata_pelajaran.index')
            ->with('success', "Mata pelajaran {$request->nama} berhasil diperbarui.");
    }

    public function mataPelajaranDestroy($id)
    {
        $data = collect($this->dummyMataPelajaran())->firstWhere('id', (int) $id);
        $nama = $data ? $data['nama'] : 'Tidak diketahui';

        return redirect()->route('admin.mata_pelajaran.index')
            ->with('success', "Mata pelajaran {$nama} berhasil dihapus.");
    }

    // ═══════════════════════════════════════════════════════
    // KELOLA AKTIVITAS TAHUN AJARAN (DUMMY)
    // Mengaitkan mata pelajaran, ekstrakurikuler, konseling ke class_term (tahun ajaran)
    // ═══════════════════════════════════════════════════════
    private function dummyAktivitasTahunAjaran()
    {
        // Pivot dummy: untuk tiap class_term_id, simpan array id mapel/ekskul/konseling yang sudah di-assign
        return [
            1 => [
                'mata_pelajaran_ids' => [1, 2, 4, 6, 7],
                'ekstrakurikuler_ids' => [1, 2],
                'konseling_ids' => [1, 3],
            ],
            2 => [
                'mata_pelajaran_ids' => [1, 3, 5, 8],
                'ekstrakurikuler_ids' => [3],
                'konseling_ids' => [2],
            ],
            3 => [
                'mata_pelajaran_ids' => [],
                'ekstrakurikuler_ids' => [],
                'konseling_ids' => [],
            ],
        ];
    }

    public function aktivitasTahunAjaranIndex()
    {
        $tahunAjaran     = collect($this->dummyTahunAjaran());
        $aktivitas       = $this->dummyAktivitasTahunAjaran();
        $mataPelajaran   = collect($this->dummyMataPelajaran())->keyBy('id');
        $ekstrakurikuler = collect($this->dummyEkstrakurikuler())->keyBy('id');
        $konseling       = collect($this->dummyKonseling())->keyBy('id');

        $rows = $tahunAjaran->map(function ($ta) use ($aktivitas, $mataPelajaran, $ekstrakurikuler, $konseling) {
            $assign = $aktivitas[$ta['id']] ?? ['mata_pelajaran_ids' => [], 'ekstrakurikuler_ids' => [], 'konseling_ids' => []];

            return [
                'id'              => $ta['id'],
                'tahun_ajaran'    => $ta['tahun_ajaran'],
                'semester'        => $ta['semester'],
                'mata_pelajaran'  => collect($assign['mata_pelajaran_ids'])->map(fn($id) => $mataPelajaran[$id]['nama'] ?? null)->filter()->values()->all(),
                'ekstrakurikuler' => collect($assign['ekstrakurikuler_ids'])->map(fn($id) => $ekstrakurikuler[$id]['nama'] ?? null)->filter()->values()->all(),
                'konseling'       => collect($assign['konseling_ids'])->map(fn($id) => $konseling[$id]['nama'] ?? null)->filter()->values()->all(),
            ];
        });

        return view('admin.aktivitas_tahun_ajaran.index', compact('rows'));
    }

    public function aktivitasTahunAjaranEdit($id)
    {
        $ta = collect($this->dummyTahunAjaran())->firstWhere('id', (int) $id);
        if (!$ta) {
            abort(404);
        }

        $aktivitas      = $this->dummyAktivitasTahunAjaran();
        $assigned       = $aktivitas[$ta['id']] ?? ['mata_pelajaran_ids' => [], 'ekstrakurikuler_ids' => [], 'konseling_ids' => []];

        $tahunAjaran     = (object) $ta;
        $mataPelajaran   = collect($this->dummyMataPelajaran());
        $ekstrakurikuler = collect($this->dummyEkstrakurikuler());
        $konseling       = collect($this->dummyKonseling());

        return view('admin.aktivitas_tahun_ajaran.edit', compact(
            'tahunAjaran', 'mataPelajaran', 'ekstrakurikuler', 'konseling', 'assigned'
        ));
    }

    public function aktivitasTahunAjaranUpdate(Request $request, $id)
    {
        $request->validate([
            'mata_pelajaran_ids'   => 'nullable|array',
            'mata_pelajaran_ids.*' => 'integer',
            'ekstrakurikuler_ids'  => 'nullable|array',
            'ekstrakurikuler_ids.*' => 'integer',
            'konseling_ids'        => 'nullable|array',
            'konseling_ids.*'      => 'integer',
        ]);

        $ta = collect($this->dummyTahunAjaran())->firstWhere('id', (int) $id);
        $label = $ta ? "{$ta['tahun_ajaran']} " . ucfirst($ta['semester']) : 'Tidak diketahui';

        return redirect()->route('admin.aktivitas_tahun_ajaran.index')
            ->with('success', "Aktivitas Tahun Ajaran {$label} berhasil diperbarui.");
    }

    // ═══════════════════════════════════════════════════════
    // REKAP DATA DAPODIK
    // ═══════════════════════════════════════════════════════
    public function dapodikIndex()
    {
        $siswa = Student::orderBy('kelas')->orderBy('name')->get()->map(function ($s) {
            return [
                'id'            => $s->id,
                'nisn'          => $s->nisn ?? '-',
                'nik'           => $s->nik ?? '-',
                'nama'          => $s->name,
                'jenis_kelamin' => $s->gender == 'L' ? 'Laki-laki' : 'Perempuan',
                'tempat_lahir'  => $s->tempat_lahir ?? '-',
                'tanggal_lahir' => $s->birth_date ? \Carbon\Carbon::parse($s->birth_date)->format('d-m-Y') : '-',
                'agama'         => 'Islam',
                'alamat'        => $s->address ?? '-',
                'nama_ayah'     => $s->nama_ayah ?? '-',
                'nama_ibu'      => $s->nama_ibu ?? '-',
                'kelas'         => $s->kelas ? 'TK ' . $s->kelas : '-',
                'status'        => 'Aktif',
            ];
        })->toArray();

        $totalSiswa     = count($siswa);
        $totalLaki      = collect($siswa)->where('jenis_kelamin', 'Laki-laki')->count();
        $totalPerempuan = collect($siswa)->where('jenis_kelamin', 'Perempuan')->count();
        $totalTKA       = collect($siswa)->where('kelas', 'TK A')->count();
        $totalTKB       = collect($siswa)->filter(fn($s) => in_array($s['kelas'], ['TK B1', 'TK B2']))->count();

        return view('admin.dapodik.index', compact('siswa', 'totalSiswa', 'totalLaki', 'totalPerempuan', 'totalTKA', 'totalTKB'));
    }

    // ═══════════════════════════════════════════════════════
    // KENAIKAN SISWA
    // ═══════════════════════════════════════════════════════

    private function dummyClassTerms()
    {
        return [
            // 2023/2024 Ganjil (tahun_ajaran_id=1) — selesai, isPass=true
            ['id' => 1,  'kelas_id' => 1, 'kelas_nama' => 'A1', 'tahun_ajaran_id' => 1, 'tahun_ajaran' => '2023/2024', 'semester' => 'ganjil', 'status' => 'selesai', 'isPass' => true],
            ['id' => 2,  'kelas_id' => 2, 'kelas_nama' => 'B1', 'tahun_ajaran_id' => 1, 'tahun_ajaran' => '2023/2024', 'semester' => 'ganjil', 'status' => 'selesai', 'isPass' => true],
            ['id' => 3,  'kelas_id' => 3, 'kelas_nama' => 'B2', 'tahun_ajaran_id' => 1, 'tahun_ajaran' => '2023/2024', 'semester' => 'ganjil', 'status' => 'selesai', 'isPass' => true],
            // 2023/2024 Genap (tahun_ajaran_id=2) — selesai, isPass=true
            ['id' => 4,  'kelas_id' => 1, 'kelas_nama' => 'A1', 'tahun_ajaran_id' => 2, 'tahun_ajaran' => '2023/2024', 'semester' => 'genap',  'status' => 'selesai', 'isPass' => true],
            ['id' => 5,  'kelas_id' => 2, 'kelas_nama' => 'B1', 'tahun_ajaran_id' => 2, 'tahun_ajaran' => '2023/2024', 'semester' => 'genap',  'status' => 'selesai', 'isPass' => true],
            ['id' => 6,  'kelas_id' => 3, 'kelas_nama' => 'B2', 'tahun_ajaran_id' => 2, 'tahun_ajaran' => '2023/2024', 'semester' => 'genap',  'status' => 'selesai', 'isPass' => true],
            // 2024/2025 Ganjil (tahun_ajaran_id=3) — selesai, isPass=true
            ['id' => 7,  'kelas_id' => 1, 'kelas_nama' => 'A1', 'tahun_ajaran_id' => 3, 'tahun_ajaran' => '2024/2025', 'semester' => 'ganjil', 'status' => 'selesai', 'isPass' => true],
            ['id' => 8,  'kelas_id' => 2, 'kelas_nama' => 'B1', 'tahun_ajaran_id' => 3, 'tahun_ajaran' => '2024/2025', 'semester' => 'ganjil', 'status' => 'selesai', 'isPass' => true],
            ['id' => 9,  'kelas_id' => 3, 'kelas_nama' => 'B2', 'tahun_ajaran_id' => 3, 'tahun_ajaran' => '2024/2025', 'semester' => 'ganjil', 'status' => 'selesai', 'isPass' => true],
            // 2024/2025 Genap (tahun_ajaran_id=4) — aktif, isPass=false
            ['id' => 10, 'kelas_id' => 1, 'kelas_nama' => 'A1', 'tahun_ajaran_id' => 4, 'tahun_ajaran' => '2024/2025', 'semester' => 'genap',  'status' => 'aktif',   'isPass' => false],
            ['id' => 11, 'kelas_id' => 2, 'kelas_nama' => 'B1', 'tahun_ajaran_id' => 4, 'tahun_ajaran' => '2024/2025', 'semester' => 'genap',  'status' => 'aktif',   'isPass' => false],
            ['id' => 12, 'kelas_id' => 3, 'kelas_nama' => 'B2', 'tahun_ajaran_id' => 4, 'tahun_ajaran' => '2024/2025', 'semester' => 'genap',  'status' => 'aktif',   'isPass' => false],
            // 2025/2026 Ganjil (tahun_ajaran_id=5) — menunggu, isPass=false
            ['id' => 13, 'kelas_id' => 1, 'kelas_nama' => 'A1', 'tahun_ajaran_id' => 5, 'tahun_ajaran' => '2025/2026', 'semester' => 'ganjil', 'status' => 'menunggu', 'isPass' => false],
            ['id' => 14, 'kelas_id' => 2, 'kelas_nama' => 'B1', 'tahun_ajaran_id' => 5, 'tahun_ajaran' => '2025/2026', 'semester' => 'ganjil', 'status' => 'menunggu', 'isPass' => false],
            ['id' => 15, 'kelas_id' => 3, 'kelas_nama' => 'B2', 'tahun_ajaran_id' => 5, 'tahun_ajaran' => '2025/2026', 'semester' => 'ganjil', 'status' => 'menunggu', 'isPass' => false],
        ];
    }

    private function dummyEnrollmentHistory()
    {
        return [
            // class_term 1: A1 2023/2024 Ganjil
            1 => [
                ['siswa_nama' => 'Ahmad Fauzi',    'nis' => '2023001', 'nisn' => '0111111111', 'gender' => 'L', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'A1 — 2023/2024 Genap'],
                ['siswa_nama' => 'Siti Nurhaliza', 'nis' => '2023002', 'nisn' => '0111111112', 'gender' => 'P', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'A1 — 2023/2024 Genap'],
                ['siswa_nama' => 'Budi Santoso',   'nis' => '2023003', 'nisn' => '0111111113', 'gender' => 'L', 'enrollment_status' => 'selesai', 'aksi' => 'tinggal_kelas',  'class_term_tujuan' => 'A1 — 2023/2024 Genap'],
            ],
            // class_term 2: B1 2023/2024 Ganjil
            2 => [
                ['siswa_nama' => 'Dewi Lestari',   'nis' => '2023004', 'nisn' => '0111111114', 'gender' => 'P', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'B1 — 2023/2024 Genap'],
                ['siswa_nama' => 'Eko Prasetyo',   'nis' => '2023005', 'nisn' => '0111111115', 'gender' => 'L', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'B1 — 2023/2024 Genap'],
            ],
            // class_term 3: B2 2023/2024 Ganjil
            3 => [
                ['siswa_nama' => 'Fitri Handayani','nis' => '2023006', 'nisn' => '0111111116', 'gender' => 'P', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'B2 — 2023/2024 Genap'],
                ['siswa_nama' => 'Galih Wirawan',  'nis' => '2023007', 'nisn' => '0111111117', 'gender' => 'L', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'B2 — 2023/2024 Genap'],
            ],
            // class_term 4: A1 2023/2024 Genap
            4 => [
                ['siswa_nama' => 'Ahmad Fauzi',    'nis' => '2023001', 'nisn' => '0111111111', 'gender' => 'L', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_kelas',   'class_term_tujuan' => 'B1 — 2024/2025 Ganjil'],
                ['siswa_nama' => 'Siti Nurhaliza', 'nis' => '2023002', 'nisn' => '0111111112', 'gender' => 'P', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_kelas',   'class_term_tujuan' => 'B2 — 2024/2025 Ganjil'],
                ['siswa_nama' => 'Budi Santoso',   'nis' => '2023003', 'nisn' => '0111111113', 'gender' => 'L', 'enrollment_status' => 'selesai', 'aksi' => 'tinggal_kelas',  'class_term_tujuan' => 'A1 — 2024/2025 Ganjil'],
            ],
            // class_term 5: B1 2023/2024 Genap
            5 => [
                ['siswa_nama' => 'Dewi Lestari',   'nis' => '2023004', 'nisn' => '0111111114', 'gender' => 'P', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_kelas',   'class_term_tujuan' => 'B1 — 2024/2025 Ganjil'],
                ['siswa_nama' => 'Eko Prasetyo',   'nis' => '2023005', 'nisn' => '0111111115', 'gender' => 'L', 'enrollment_status' => 'selesai', 'aksi' => 'tinggal_kelas',  'class_term_tujuan' => 'B1 — 2024/2025 Ganjil'],
            ],
            // class_term 6: B2 2023/2024 Genap
            6 => [
                ['siswa_nama' => 'Fitri Handayani','nis' => '2023006', 'nisn' => '0111111116', 'gender' => 'P', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_kelas',   'class_term_tujuan' => 'B2 — 2024/2025 Ganjil'],
                ['siswa_nama' => 'Galih Wirawan',  'nis' => '2023007', 'nisn' => '0111111117', 'gender' => 'L', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_kelas',   'class_term_tujuan' => 'B2 — 2024/2025 Ganjil'],
            ],
            // class_term 7: A1 2024/2025 Ganjil
            7 => [
                ['siswa_nama' => 'Budi Santoso',   'nis' => '2023003', 'nisn' => '0111111113', 'gender' => 'L', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'A1 — 2024/2025 Genap'],
                ['siswa_nama' => 'Hana Rahmawati', 'nis' => '2024008', 'nisn' => '0123456788', 'gender' => 'P', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'A1 — 2024/2025 Genap'],
            ],
            // class_term 8: B1 2024/2025 Ganjil
            8 => [
                ['siswa_nama' => 'Ahmad Fauzi',    'nis' => '2024001', 'nisn' => '0123456781', 'gender' => 'L', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'B1 — 2024/2025 Genap'],
                ['siswa_nama' => 'Dewi Lestari',   'nis' => '2023004', 'nisn' => '0111111114', 'gender' => 'P', 'enrollment_status' => 'selesai', 'aksi' => 'tinggal_kelas',  'class_term_tujuan' => 'B1 — 2024/2025 Genap'],
                ['siswa_nama' => 'Eko Prasetyo',   'nis' => '2023005', 'nisn' => '0111111115', 'gender' => 'L', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'B1 — 2024/2025 Genap'],
            ],
            // class_term 9: B2 2024/2025 Ganjil
            9 => [
                ['siswa_nama' => 'Siti Nurhaliza', 'nis' => '2024002', 'nisn' => '0123456782', 'gender' => 'P', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'B2 — 2024/2025 Genap'],
                ['siswa_nama' => 'Fitri Handayani','nis' => '2023006', 'nisn' => '0111111116', 'gender' => 'P', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'B2 — 2024/2025 Genap'],
                ['siswa_nama' => 'Galih Wirawan',  'nis' => '2023007', 'nisn' => '0111111117', 'gender' => 'L', 'enrollment_status' => 'selesai', 'aksi' => 'ganti_semester', 'class_term_tujuan' => 'B2 — 2024/2025 Genap'],
            ],
        ];
    }

    private function dummyStudents()
    {
        return [
            ['id' => 1, 'nama' => 'Ahmad Fauzi',       'nis' => '2024001', 'nisn' => '0123456781', 'gender' => 'L'],
            ['id' => 2, 'nama' => 'Siti Nurhaliza',    'nis' => '2024002', 'nisn' => '0123456782', 'gender' => 'P'],
            ['id' => 3, 'nama' => 'Budi Santoso',      'nis' => '2024003', 'nisn' => '0123456783', 'gender' => 'L'],
            ['id' => 4, 'nama' => 'Dewi Lestari',      'nis' => '2024004', 'nisn' => '0123456784', 'gender' => 'P'],
            ['id' => 5, 'nama' => 'Eko Prasetyo',      'nis' => '2024005', 'nisn' => '0123456785', 'gender' => 'L'],
            ['id' => 6, 'nama' => 'Fitri Handayani',   'nis' => '2024006', 'nisn' => '0123456786', 'gender' => 'P'],
            ['id' => 7, 'nama' => 'Galih Wirawan',     'nis' => '2024007', 'nisn' => '0123456787', 'gender' => 'L'],
            ['id' => 8, 'nama' => 'Hana Rahmawati',    'nis' => '2024008', 'nisn' => '0123456788', 'gender' => 'P'],
            ['id' => 9, 'nama' => 'Irfan Maulana',     'nis' => '2024009', 'nisn' => '0123456789', 'gender' => 'L'],
            ['id' => 10,'nama' => 'Julia Santika',     'nis' => '2024010', 'nisn' => '0123456790', 'gender' => 'P'],
        ];
    }

    private function dummyEnrollments()
    {
        return [
            // class_term 10 → A1 2024/2025 Genap (aktif)
            ['id' => 1, 'student_id' => 1, 'class_term_id' => 10, 'status' => 'aktif'],
            ['id' => 2, 'student_id' => 2, 'class_term_id' => 10, 'status' => 'aktif'],
            ['id' => 3, 'student_id' => 3, 'class_term_id' => 10, 'status' => 'aktif'],
            ['id' => 4, 'student_id' => 4, 'class_term_id' => 10, 'status' => 'aktif'],
            // class_term 11 → B1 2024/2025 Genap (aktif)
            ['id' => 5, 'student_id' => 5, 'class_term_id' => 11, 'status' => 'aktif'],
            ['id' => 6, 'student_id' => 6, 'class_term_id' => 11, 'status' => 'aktif'],
            ['id' => 7, 'student_id' => 7, 'class_term_id' => 11, 'status' => 'aktif'],
            // class_term 12 → B2 2024/2025 Genap (aktif)
            ['id' => 8,  'student_id' => 8,  'class_term_id' => 12, 'status' => 'aktif'],
            ['id' => 9,  'student_id' => 9,  'class_term_id' => 12, 'status' => 'aktif'],
            ['id' => 10, 'student_id' => 10, 'class_term_id' => 12, 'status' => 'aktif'],
        ];
    }

    public function kenaikanIndex()
    {
        $enrollments = collect($this->dummyEnrollments());
        $history     = $this->dummyEnrollmentHistory();

        $classTerms = collect($this->dummyClassTerms())->map(function ($ct) use ($enrollments, $history) {
            if ($ct['isPass']) {
                $ct['jumlah_siswa'] = count($history[$ct['id']] ?? []);
            } else {
                $ct['jumlah_siswa'] = $enrollments->where('class_term_id', $ct['id'])->count();
            }
            return $ct;
        });

        // Group by tahun_ajaran untuk tampilan terorganisir
        $grouped = $classTerms->groupBy('tahun_ajaran');

        return view('admin.kenaikan.index', compact('grouped'));
    }

    public function kenaikanDetail($id)
    {
        $classTerm = collect($this->dummyClassTerms())->firstWhere('id', (int) $id);
        if (!$classTerm || !$classTerm['isPass']) {
            return redirect()->route('admin.kenaikan.index')->with('error', 'Detail hanya tersedia untuk class term yang sudah diproses.');
        }

        $history = $this->dummyEnrollmentHistory()[(int) $id] ?? [];

        return view('admin.kenaikan.detail', compact('classTerm', 'history'));
    }

    public function kenaikanShow($id)
    {
        $classTerm = collect($this->dummyClassTerms())->firstWhere('id', (int) $id);
        if (!$classTerm || $classTerm['status'] !== 'aktif') {
            return redirect()->route('admin.kenaikan.index')->with('error', 'Class term tidak ditemukan.');
        }

        $enrollments = collect($this->dummyEnrollments())
            ->where('class_term_id', (int) $id)
            ->values();

        $students = collect($this->dummyStudents());

        $siswaList = $enrollments->map(function ($e) use ($students) {
            $s = $students->firstWhere('id', $e['student_id']);
            return array_merge($e, $s ?? []);
        });

        // Semua class term kecuali yang sedang diproses, untuk dipilih sebagai tujuan
        $classTermOptions = collect($this->dummyClassTerms())
            ->where('id', '!=', (int) $id)
            ->values();

        return view('admin.kenaikan.show', compact('classTerm', 'siswaList', 'classTermOptions'));
    }

    public function kenaikanProses(Request $request, $id)
    {
        return redirect()->route('admin.kenaikan.index')
            ->with('success', 'Proses kenaikan siswa berhasil disimpan. Class term telah ditutup.');
    }
}
