<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\PendaftaranController;

// AUTH 
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// PENDAFTARAN (Public - tanpa login)
Route::get('/pendaftaran', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
Route::get('/pendaftaran/success', [PendaftaranController::class, 'success'])->name('pendaftaran.success');
Route::get('/pendaftaran/cek-status', [PendaftaranController::class, 'cekStatus'])->name('pendaftaran.cek-status');

// DASHBOARD (butuh login dengan dummy auth) 
Route::middleware('dummy.auth')->group(function () {
    // ═══════════════════════════════════════════════════════
    // ADMIN ROUTES
    // ═══════════════════════════════════════════════════════
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Admin - Kelola Pengguna
    Route::get('/admin/pengguna', [AdminController::class, 'penggunaIndex'])->name('admin.pengguna.index');
    Route::get('/admin/pengguna/create', [AdminController::class, 'penggunaCreate'])->name('admin.pengguna.create');
    Route::post('/admin/pengguna', [AdminController::class, 'penggunaStore'])->name('admin.pengguna.store');
    Route::get('/admin/pengguna/{id}/edit', [AdminController::class, 'penggunaEdit'])->name('admin.pengguna.edit');
    Route::put('/admin/pengguna/{id}', [AdminController::class, 'penggunaUpdate'])->name('admin.pengguna.update');
    Route::delete('/admin/pengguna/{id}', [AdminController::class, 'penggunaDestroy'])->name('admin.pengguna.destroy');
    
    // Admin - Kelola Siswa
    Route::get('/admin/siswa', [AdminController::class, 'siswaIndex'])->name('admin.siswa.index');
    Route::get('/admin/siswa/create', [AdminController::class, 'siswaCreate'])->name('admin.siswa.create');
    Route::post('/admin/siswa', [AdminController::class, 'siswaStore'])->name('admin.siswa.store');
    Route::get('/admin/siswa/{id}/edit', [AdminController::class, 'siswaEdit'])->name('admin.siswa.edit');
    Route::put('/admin/siswa/{id}', [AdminController::class, 'siswaUpdate'])->name('admin.siswa.update');
    Route::delete('/admin/siswa/{id}', [AdminController::class, 'siswaDestroy'])->name('admin.siswa.destroy');
    
    // Admin - Backup Database
    Route::get('/admin/backup', [AdminController::class, 'backupIndex'])->name('admin.backup.index');
    Route::post('/admin/backup/create', [AdminController::class, 'backupCreate'])->name('admin.backup.create');
    Route::post('/admin/backup/restore', [AdminController::class, 'backupRestore'])->name('admin.backup.restore');
    Route::delete('/admin/backup/{filename}', [AdminController::class, 'backupDelete'])->name('admin.backup.delete');

    // ═══════════════════════════════════════════════════════
    // GURU ROUTES
    // ═══════════════════════════════════════════════════════
    Route::get('/guru/dashboard', [GuruController::class, 'dashboard'])->name('guru.dashboard');

    // Guru - Administrasi: Kehadiran
    Route::get('/guru/kehadiran', [GuruController::class, 'kehadiranIndex'])->name('guru.kehadiran.index');
    Route::post('/guru/kehadiran', [GuruController::class, 'kehadiranStore'])->name('guru.kehadiran.store');
    Route::get('/guru/kehadiran/{id}/edit', [GuruController::class, 'kehadiranEdit'])->name('guru.kehadiran.edit');
    Route::put('/guru/kehadiran/{id}', [GuruController::class, 'kehadiranUpdate'])->name('guru.kehadiran.update');

    // Guru - Administrasi: Laporan
    Route::get('/guru/laporan-administrasi', [GuruController::class, 'laporanIndex'])->name('guru.laporan.index');
    Route::post('/guru/laporan-administrasi/generate', [GuruController::class, 'laporanGenerate'])->name('guru.laporan.generate');

    // Guru - Administrasi: Jadwal
    Route::get('/guru/jadwal', [GuruController::class, 'jadwalIndex'])->name('guru.jadwal.index');
    Route::post('/guru/jadwal', [GuruController::class, 'jadwalStore'])->name('guru.jadwal.store');
    Route::get('/guru/jadwal/{id}/edit', [GuruController::class, 'jadwalEdit'])->name('guru.jadwal.edit');
    Route::put('/guru/jadwal/{id}', [GuruController::class, 'jadwalUpdate'])->name('guru.jadwal.update');
    Route::delete('/guru/jadwal/{id}', [GuruController::class, 'jadwalDestroy'])->name('guru.jadwal.destroy');

    // Guru - Bimbingan Konseling
    Route::get('/guru/input-perkembangan', [GuruController::class, 'inputPerkembangan'])->name('guru.input_perkembangan');
    Route::post('/guru/input-perkembangan', [GuruController::class, 'storeInputPerkembangan'])->name('guru.store_input_perkembangan');
    Route::get('/guru/grafik', [GuruController::class, 'grafik'])->name('guru.grafik');
    Route::get('/guru/laporan-bk', [GuruController::class, 'laporan'])->name('guru.laporan_bk');
    Route::get('/guru/laporan-bk/{id}', [GuruController::class, 'laporanBkShow'])->name('guru.laporan_bk.show');
    Route::get('/guru/laporan-bk/{id}/edit', [GuruController::class, 'laporanBkEdit'])->name('guru.laporan_bk.edit');
    Route::put('/guru/laporan-bk/{id}', [GuruController::class, 'laporanBkUpdate'])->name('guru.laporan_bk.update');
    Route::get('/guru/chat', [GuruController::class, 'chat'])->name('guru.chat');
    Route::post('/guru/chat', [GuruController::class, 'kirimChat'])->name('guru.kirim_chat');
    Route::get('/guru/jadwal-konseling', [GuruController::class, 'jadwalKonseling'])->name('guru.jadwal_konseling');
    Route::post('/guru/jadwal-konseling', [GuruController::class, 'storeJadwalKonseling'])->name('guru.store_jadwal_konseling');
    Route::get('/guru/jadwal-konseling/{id}', [GuruController::class, 'jadwalKonselingShow'])->name('guru.jadwal_konseling.show');
    Route::get('/guru/jadwal-konseling/{id}/edit', [GuruController::class, 'jadwalKonselingEdit'])->name('guru.jadwal_konseling.edit');
    Route::put('/guru/jadwal-konseling/{id}', [GuruController::class, 'jadwalKonselingUpdate'])->name('guru.jadwal_konseling.update');
    Route::post('/guru/jadwal-konseling/{id}/setuju', [GuruController::class, 'jadwalKonselingSetuju'])->name('guru.jadwal_konseling.setuju');
    Route::post('/guru/jadwal-konseling/{id}/tolak', [GuruController::class, 'jadwalKonselingTolak'])->name('guru.jadwal_konseling.tolak');
    Route::post('/guru/jadwal-konseling/{id}/batalkan', [GuruController::class, 'jadwalKonselingBatalkan'])->name('guru.jadwal_konseling.batalkan');

    // Guru - Rapot Semester
    Route::get('/guru/rapot', [GuruController::class, 'rapotIndex'])->name('guru.rapot.index');
    Route::get('/guru/rapot/create', [GuruController::class, 'rapotCreate'])->name('guru.rapot.create');
    Route::post('/guru/rapot', [GuruController::class, 'rapotStore'])->name('guru.rapot.store');
    Route::get('/guru/rapot/{id}', [GuruController::class, 'rapotShow'])->name('guru.rapot.show');
    Route::get('/guru/rapot/{id}/edit', [GuruController::class, 'rapotEdit'])->name('guru.rapot.edit');
    Route::put('/guru/rapot/{id}', [GuruController::class, 'rapotUpdate'])->name('guru.rapot.update');
    Route::delete('/guru/rapot/{id}', [GuruController::class, 'rapotDestroy'])->name('guru.rapot.destroy');

    // ═══════════════════════════════════════════════════════
    // ORANG TUA ROUTES
    // ═══════════════════════════════════════════════════════
    // Administrasi
    Route::get('/orangtua/dashboard', [OrangTuaController::class, 'dashboard'])->name('orangtua.dashboard');
    Route::get('/orangtua/presensi', [OrangTuaController::class, 'presensi'])->name('orangtua.presensi');
    Route::get('/orangtua/laporan', [OrangTuaController::class, 'laporan'])->name('orangtua.laporan');
    Route::get('/orangtua/laporan/{id}', [OrangTuaController::class, 'laporanDetail'])->name('orangtua.laporan.detail');
    
    // Rapot Semester
    Route::get('/orangtua/rapot', [OrangTuaController::class, 'rapot'])->name('orangtua.rapot');
    Route::get('/orangtua/rapot/{id}', [OrangTuaController::class, 'rapotDetail'])->name('orangtua.rapot.detail');
    Route::get('/orangtua/rapot/{id}/download', [OrangTuaController::class, 'rapotDownload'])->name('orangtua.rapot.download');
    
    // Jadwal (dengan sub-fitur)
    Route::get('/orangtua/jadwal', [OrangTuaController::class, 'jadwal'])->name('orangtua.jadwal');
    Route::get('/orangtua/jadwal/pembelajaran', [OrangTuaController::class, 'jadwalPembelajaran'])->name('orangtua.jadwal.pembelajaran');
    Route::get('/orangtua/jadwal/kegiatan', [OrangTuaController::class, 'jadwalKegiatan'])->name('orangtua.jadwal.kegiatan');

    // Bimbingan Konseling
    Route::get('/orangtua/report-mingguan', [OrangTuaController::class, 'reportMingguan'])->name('orangtua.report_mingguan');
    Route::get('/orangtua/grafik', [OrangTuaController::class, 'grafik'])->name('orangtua.grafik');
    Route::get('/orangtua/chat', [OrangTuaController::class, 'chat'])->name('orangtua.chat');
    Route::post('/orangtua/chat', [OrangTuaController::class, 'kirimChat'])->name('orangtua.kirim_chat');
    Route::get('/orangtua/konseling', [OrangTuaController::class, 'konseling'])->name('orangtua.konseling');
    Route::post('/orangtua/konseling', [OrangTuaController::class, 'ajukanKonseling'])->name('orangtua.ajukan_konseling');
});

