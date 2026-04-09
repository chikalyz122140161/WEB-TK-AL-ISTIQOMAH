<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // DASHBOARD
    public function dashboard()
    {
        // Stats data
        $totalSiswa = 45;
        $totalGuru = 8;
        $orangTerdaftar = 45;
        $totalKelas = 2;
        
        // Aktivitas terbaru
        $aktivitas = [
            ['title' => 'Data Siswa Baru Ditambahkan', 'time' => '2 jam yang lalu'],
            ['title' => 'Pengguna Baru Terdaftar', 'time' => '5 jam yang lalu'],
            ['title' => 'Backup Database Berhasil', 'time' => 'Kemarin'],
        ];
        
        // Statistik sistem
        $statistik = [
            ['label' => 'TK A', 'value' => '22 Siswa'],
            ['label' => 'TK B', 'value' => '23 Siswa'],
            ['label' => 'Kelompok Bermain', 'value' => '0 Siswa'],
            ['label' => 'Laporan Minggu Ini', 'value' => '48 Laporan'],
        ];
        
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
        return view('admin.pengguna.create');
    }
    
    public function penggunaStore(Request $request)
    {
        // Dummy - redirect with success
        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil ditambahkan!');
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
        // Dummy data - with orangtua relation (sesuai form pendaftaran fisik)
        $siswa = [
            ['id' => 1, 'nis' => '2024001', 'nama' => 'Ahmad Fauzi', 'kelas' => 'TK A', 'jk' => 'L', 'status' => 'Aktif', 'nama_ortu' => 'Budi Santoso / Siti Rahayu', 'email_ortu' => 'budi@email.com'],
            ['id' => 2, 'nis' => '2024002', 'nama' => 'Siti Aisyah', 'kelas' => 'TK A', 'jk' => 'P', 'status' => 'Aktif', 'nama_ortu' => 'Ahmad Ibrahim / Fatimah', 'email_ortu' => 'ahmad@email.com'],
            ['id' => 3, 'nis' => '2024003', 'nama' => 'Budi Santoso Jr', 'kelas' => 'TK B', 'jk' => 'L', 'status' => 'Aktif', 'nama_ortu' => 'Hendra Wijaya / Dewi', 'email_ortu' => 'hendra@email.com'],
            ['id' => 4, 'nis' => '2024004', 'nama' => 'Dewi Rahayu', 'kelas' => 'TK B', 'jk' => 'P', 'status' => 'Aktif', 'nama_ortu' => 'Eko Prasetyo / Sri', 'email_ortu' => 'eko@email.com'],
            ['id' => 5, 'nis' => '2026001', 'nama' => 'Erlangga Pradipa Bimantara', 'kelas' => 'TK A', 'jk' => 'L', 'status' => 'Pending', 'nama_ortu' => 'Sudir / Julia Sari', 'email_ortu' => 'julia.sari@email.com'],
            ['id' => 6, 'nis' => '2026002', 'nama' => 'Putri Amelia', 'kelas' => 'TK A', 'jk' => 'P', 'status' => 'Pending', 'nama_ortu' => 'Ratna Sari / Indah', 'email_ortu' => 'ratna@gmail.com'],
        ];
        
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
            'id' => $id,
            'tanggal_daftar' => '05 Mar 2026',
            'nama_siswa' => 'Erlangga Pradipa Bimantara',
            'nama_panggilan' => 'Angga',
            'jenis_kelamin' => 'Laki-laki',
            'tempat_lahir' => 'Bandar Lampung',
            'tanggal_lahir' => '25 September 2021',
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
            'alamat_ortu' => 'Jl. Harum Bunga Perumahan Panca Bakti Bandar Lampung',
            'status' => 'Pending',
            'dokumen' => [
                ['id' => 1, 'nama' => 'Akta Kelahiran', 'file' => 'akta_kelahiran_001.pdf'],
                ['id' => 2, 'nama' => 'Kartu Keluarga', 'file' => 'kk_001.pdf'],
                ['id' => 3, 'nama' => 'Pas Foto', 'file' => 'foto_001.jpg'],
            ],
        ];
        
        return view('admin.pendaftaran.show', compact('pendaftaran'));
    }
    
    public function pendaftaranTerima($id)
    {
        // Logic to accept registration:
        // 1. Update registration status to 'Diterima'
        // 2. Create student record
        // 3. Create/activate parent user account
        // 4. Send notification email
        
        return redirect()->route('admin.pendaftaran.index')->with('success', 'Pendaftaran berhasil diterima! Akun orang tua telah diaktifkan.');
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
    // REKAP DATA DAPODIK
    // ═══════════════════════════════════════════════════════
    public function dapodikIndex()
    {
        // Dummy data - replace with actual database query
        // Data siswa aktif dengan format sesuai kebutuhan DAPODIK
        $siswa = [
            [
                'id' => 1,
                'nisn' => '3201234567',
                'nik' => '1871012509210001',
                'nama' => 'Ahmad Fauzi',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Bandar Lampung',
                'tanggal_lahir' => '15-03-2020',
                'agama' => 'Islam',
                'alamat' => 'Jl. Sudirman No. 10 Bandar Lampung',
                'nama_ayah' => 'Budi Santoso',
                'nama_ibu' => 'Siti Rahayu',
                'kelas' => 'TK A',
                'status' => 'Aktif'
            ],
            [
                'id' => 2,
                'nisn' => '3201234568',
                'nik' => '1871011501210002',
                'nama' => 'Siti Aisyah',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Bandar Lampung',
                'tanggal_lahir' => '20-05-2020',
                'agama' => 'Islam',
                'alamat' => 'Jl. Diponegoro No. 25 Bandar Lampung',
                'nama_ayah' => 'Ahmad Ibrahim',
                'nama_ibu' => 'Fatimah',
                'kelas' => 'TK A',
                'status' => 'Aktif'
            ],
            [
                'id' => 3,
                'nisn' => '3201234569',
                'nik' => '1871010208200003',
                'nama' => 'Budi Santoso Jr',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Metro',
                'tanggal_lahir' => '02-08-2019',
                'agama' => 'Islam',
                'alamat' => 'Jl. Kartini No. 15 Metro',
                'nama_ayah' => 'Hendra Wijaya',
                'nama_ibu' => 'Dewi',
                'kelas' => 'TK B',
                'status' => 'Aktif'
            ],
            [
                'id' => 4,
                'nisn' => '3201234570',
                'nik' => '1871011012190004',
                'nama' => 'Dewi Rahayu',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Bandar Lampung',
                'tanggal_lahir' => '10-12-2019',
                'agama' => 'Islam',
                'alamat' => 'Jl. Ahmad Yani No. 30 Bandar Lampung',
                'nama_ayah' => 'Eko Prasetyo',
                'nama_ibu' => 'Sri',
                'kelas' => 'TK B',
                'status' => 'Aktif'
            ],
            [
                'id' => 5,
                'nisn' => '3201234571',
                'nik' => '1871012003200005',
                'nama' => 'Rizki Pratama',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Bandar Lampung',
                'tanggal_lahir' => '20-03-2020',
                'agama' => 'Islam',
                'alamat' => 'Jl. Gatot Subroto No. 5 Bandar Lampung',
                'nama_ayah' => 'Dedi Kurniawan',
                'nama_ibu' => 'Rina',
                'kelas' => 'TK A',
                'status' => 'Aktif'
            ],
            [
                'id' => 6,
                'nisn' => '3201234572',
                'nik' => '1871010505200006',
                'nama' => 'Anisa Putri',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Pringsewu',
                'tanggal_lahir' => '05-05-2020',
                'agama' => 'Islam',
                'alamat' => 'Jl. Teuku Umar No. 12 Pringsewu',
                'nama_ayah' => 'Agus Setiawan',
                'nama_ibu' => 'Lina',
                'kelas' => 'TK A',
                'status' => 'Aktif'
            ],
            [
                'id' => 7,
                'nisn' => '3201234573',
                'nik' => '1871011507190007',
                'nama' => 'Fajar Ramadhan',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Bandar Lampung',
                'tanggal_lahir' => '15-07-2019',
                'agama' => 'Islam',
                'alamat' => 'Jl. Imam Bonjol No. 8 Bandar Lampung',
                'nama_ayah' => 'Wahyu Hidayat',
                'nama_ibu' => 'Yuni',
                'kelas' => 'TK B',
                'status' => 'Aktif'
            ],
            [
                'id' => 8,
                'nisn' => '3201234574',
                'nik' => '1871012208190008',
                'nama' => 'Nabila Azzahra',
                'jenis_kelamin' => 'Perempuan',
                'tempat_lahir' => 'Bandar Lampung',
                'tanggal_lahir' => '22-08-2019',
                'agama' => 'Islam',
                'alamat' => 'Jl. Cut Nyak Dien No. 20 Bandar Lampung',
                'nama_ayah' => 'Andi Firmansyah',
                'nama_ibu' => 'Mega',
                'kelas' => 'TK B',
                'status' => 'Aktif'
            ],
        ];
        
        $totalSiswa = count($siswa);
        $totalLaki = count(array_filter($siswa, fn($s) => $s['jenis_kelamin'] == 'Laki-laki'));
        $totalPerempuan = count(array_filter($siswa, fn($s) => $s['jenis_kelamin'] == 'Perempuan'));
        $totalTKA = count(array_filter($siswa, fn($s) => $s['kelas'] == 'TK A'));
        $totalTKB = count(array_filter($siswa, fn($s) => $s['kelas'] == 'TK B'));
        
        return view('admin.dapodik.index', compact('siswa', 'totalSiswa', 'totalLaki', 'totalPerempuan', 'totalTKA', 'totalTKB'));
    }
}
