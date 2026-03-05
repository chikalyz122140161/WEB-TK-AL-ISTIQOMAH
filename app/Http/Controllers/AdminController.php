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
        ];
        
        return view('admin.pengguna.index', compact('pengguna'));
    }
    
    public function penggunaCreate()
    {
        return view('admin.pengguna.create');
    }
    
    public function penggunaStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,guru,orangtua',
        ]);
        
        // Create user logic here
        // User::create([...]);
        
        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }
    
    public function penggunaEdit($id)
    {
        // Get user by id
        $pengguna = [
            'id' => $id,
            'nama' => 'User Name',
            'email' => 'user@example.com',
            'role' => 'guru',
            'nomor_telepon' => '08123456789',
        ];
        
        return view('admin.pengguna.edit', compact('pengguna'));
    }
    
    public function penggunaUpdate(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'role' => 'required|in:admin,guru,orangtua',
        ]);
        
        // Update user logic here
        
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
        // Dummy data - replace with actual database query
        $siswa = [
            ['id' => 1, 'nis' => '2024001', 'nama' => 'Ahmad Fauzi', 'kelas' => 'TK A', 'jk' => 'L', 'status' => 'Aktif'],
            ['id' => 2, 'nis' => '2024002', 'nama' => 'Siti Aisyah', 'kelas' => 'TK A', 'jk' => 'P', 'status' => 'Aktif'],
            ['id' => 3, 'nis' => '2024003', 'nama' => 'Budi Santoso', 'kelas' => 'TK B', 'jk' => 'L', 'status' => 'Aktif'],
            ['id' => 4, 'nis' => '2024004', 'nama' => 'Dewi Rahayu', 'kelas' => 'TK B', 'jk' => 'P', 'status' => 'Aktif'],
        ];
        
        return view('admin.siswa.index', compact('siswa'));
    }
    
    public function siswaCreate()
    {
        return view('admin.siswa.create');
    }
    
    public function siswaStore(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|unique:siswa,nis',
            'nama' => 'required|string|max:255',
            'kelas' => 'required|in:TK A,TK B',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
        ]);
        
        // Create siswa logic here
        
        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil ditambahkan!');
    }
    
    public function siswaEdit($id)
    {
        // Get siswa by id
        $siswa = [
            'id' => $id,
            'nis' => '2024001',
            'nama' => 'Ahmad Fauzi',
            'kelas' => 'TK A',
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '2020-05-15',
            'alamat' => 'Jl. Contoh No. 123',
            'status' => 'Aktif',
        ];
        
        return view('admin.siswa.edit', compact('siswa'));
    }
    
    public function siswaUpdate(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'required|in:TK A,TK B',
        ]);
        
        // Update siswa logic here
        
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
        $request->validate([
            'backup_file' => 'required',
            'konfirmasi' => 'required|in:RESTORE',
        ]);
        
        // Restore backup logic here
        
        return redirect()->route('admin.backup.index')->with('success', 'Database berhasil di-restore!');
    }
    
    public function backupDelete($filename)
    {
        // Delete backup file logic here
        
        return redirect()->route('admin.backup.index')->with('success', 'File backup berhasil dihapus!');
    }
}
