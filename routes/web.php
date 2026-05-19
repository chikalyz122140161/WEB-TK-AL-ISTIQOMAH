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

// DASHBOARD (butuh login + role check)

// ═══════════════════════════════════════════════════════
// ADMIN ROUTES
// ═══════════════════════════════════════════════════════
Route::middleware(['dummy.auth', 'role:admin'])->group(function () {
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
    Route::put('/admin/siswa/{id}/class-term', [AdminController::class, 'siswaUpdateClassTerm'])->name('admin.siswa.update_class_term');
    
    // Admin - Kelola Pendaftaran
    Route::get('/admin/pendaftaran', [AdminController::class, 'pendaftaranIndex'])->name('admin.pendaftaran.index');
    Route::get('/admin/pendaftaran/{id}', [AdminController::class, 'pendaftaranShow'])->name('admin.pendaftaran.show');
    Route::post('/admin/pendaftaran/{id}/terima', [AdminController::class, 'pendaftaranTerima'])->name('admin.pendaftaran.terima');
    Route::post('/admin/pendaftaran/{id}/tolak', [AdminController::class, 'pendaftaranTolak'])->name('admin.pendaftaran.tolak');
    
    // Admin - Kelola Tahun Ajaran
    Route::get('/admin/tahun-ajaran', [AdminController::class, 'tahunAjaranIndex'])->name('admin.tahun_ajaran.index');
    Route::get('/admin/tahun-ajaran/create', [AdminController::class, 'tahunAjaranCreate'])->name('admin.tahun_ajaran.create');
    Route::post('/admin/tahun-ajaran', [AdminController::class, 'tahunAjaranStore'])->name('admin.tahun_ajaran.store');
    Route::get('/admin/tahun-ajaran/{id}', [AdminController::class, 'tahunAjaranShow'])->name('admin.tahun_ajaran.show');
    Route::get('/admin/tahun-ajaran/{id}/edit', [AdminController::class, 'tahunAjaranEdit'])->name('admin.tahun_ajaran.edit');
    Route::put('/admin/tahun-ajaran/{id}', [AdminController::class, 'tahunAjaranUpdate'])->name('admin.tahun_ajaran.update');
    Route::delete('/admin/tahun-ajaran/{id}', [AdminController::class, 'tahunAjaranDestroy'])->name('admin.tahun_ajaran.destroy');
    Route::post('/admin/tahun-ajaran/{id}/class-term', [AdminController::class, 'tahunAjaranClassTermStore'])->name('admin.tahun_ajaran.class_term.store');
    Route::delete('/admin/tahun-ajaran/{id}/class-term/{classTermId}', [AdminController::class, 'tahunAjaranClassTermDestroy'])->name('admin.tahun_ajaran.class_term.destroy');

    // Admin - Kelola Kelas
    Route::get('/admin/kelas', [AdminController::class, 'kelasIndex'])->name('admin.kelas.index');
    Route::get('/admin/kelas/create', [AdminController::class, 'kelasCreate'])->name('admin.kelas.create');
    Route::post('/admin/kelas', [AdminController::class, 'kelasStore'])->name('admin.kelas.store');
    Route::get('/admin/kelas/{id}/edit', [AdminController::class, 'kelasEdit'])->name('admin.kelas.edit');
    Route::put('/admin/kelas/{id}', [AdminController::class, 'kelasUpdate'])->name('admin.kelas.update');
    Route::delete('/admin/kelas/{id}', [AdminController::class, 'kelasDestroy'])->name('admin.kelas.destroy');

    // Admin - Kelola Ekstrakurikuler
    Route::get('/admin/ekstrakurikuler', [AdminController::class, 'ekstrakurikulerIndex'])->name('admin.ekstrakurikuler.index');
    Route::get('/admin/ekstrakurikuler/create', [AdminController::class, 'ekstrakurikulerCreate'])->name('admin.ekstrakurikuler.create');
    Route::post('/admin/ekstrakurikuler', [AdminController::class, 'ekstrakurikulerStore'])->name('admin.ekstrakurikuler.store');
    Route::get('/admin/ekstrakurikuler/{id}/edit', [AdminController::class, 'ekstrakurikulerEdit'])->name('admin.ekstrakurikuler.edit');
    Route::put('/admin/ekstrakurikuler/{id}', [AdminController::class, 'ekstrakurikulerUpdate'])->name('admin.ekstrakurikuler.update');
    Route::delete('/admin/ekstrakurikuler/{id}', [AdminController::class, 'ekstrakurikulerDestroy'])->name('admin.ekstrakurikuler.destroy');

    // Admin - Kelola Konseling
    Route::get('/admin/konseling', [AdminController::class, 'konselingIndex'])->name('admin.konseling.index');
    Route::get('/admin/konseling/create', [AdminController::class, 'konselingCreate'])->name('admin.konseling.create');
    Route::post('/admin/konseling', [AdminController::class, 'konselingStore'])->name('admin.konseling.store');
    Route::get('/admin/konseling/{id}/edit', [AdminController::class, 'konselingEdit'])->name('admin.konseling.edit');
    Route::put('/admin/konseling/{id}', [AdminController::class, 'konselingUpdate'])->name('admin.konseling.update');
    Route::delete('/admin/konseling/{id}', [AdminController::class, 'konselingDestroy'])->name('admin.konseling.destroy');

    // Admin - Kelola Mata Pelajaran
    Route::get('/admin/mata-pelajaran', [AdminController::class, 'mataPelajaranIndex'])->name('admin.mata_pelajaran.index');
    Route::get('/admin/mata-pelajaran/create', [AdminController::class, 'mataPelajaranCreate'])->name('admin.mata_pelajaran.create');
    Route::post('/admin/mata-pelajaran', [AdminController::class, 'mataPelajaranStore'])->name('admin.mata_pelajaran.store');
    Route::get('/admin/mata-pelajaran/{id}/edit', [AdminController::class, 'mataPelajaranEdit'])->name('admin.mata_pelajaran.edit');
    Route::put('/admin/mata-pelajaran/{id}', [AdminController::class, 'mataPelajaranUpdate'])->name('admin.mata_pelajaran.update');
    Route::delete('/admin/mata-pelajaran/{id}', [AdminController::class, 'mataPelajaranDestroy'])->name('admin.mata_pelajaran.destroy');

    // Admin - Kelola Aktivitas Tahun Ajaran (assign mapel/ekskul/konseling ke class term)
    Route::get('/admin/aktivitas-tahun-ajaran', [AdminController::class, 'aktivitasTahunAjaranIndex'])->name('admin.aktivitas_tahun_ajaran.index');
    Route::get('/admin/aktivitas-tahun-ajaran/class-term/{id}/edit', [AdminController::class, 'aktivitasTahunAjaranEdit'])->name('admin.aktivitas_tahun_ajaran.edit');
    Route::put('/admin/aktivitas-tahun-ajaran/class-term/{id}', [AdminController::class, 'aktivitasTahunAjaranUpdate'])->name('admin.aktivitas_tahun_ajaran.update');
    Route::get('/admin/aktivitas-tahun-ajaran/{id}', [AdminController::class, 'aktivitasTahunAjaranShow'])->name('admin.aktivitas_tahun_ajaran.show');

    // Admin - Kenaikan Siswa
    Route::get('/admin/kenaikan', [AdminController::class, 'kenaikanIndex'])->name('admin.kenaikan.index');
    Route::get('/admin/kenaikan/{id}/detail', [AdminController::class, 'kenaikanDetail'])->name('admin.kenaikan.detail');
    Route::get('/admin/kenaikan/{id}', [AdminController::class, 'kenaikanShow'])->name('admin.kenaikan.show');
    Route::post('/admin/kenaikan/{id}/proses', [AdminController::class, 'kenaikanProses'])->name('admin.kenaikan.proses');

    // Admin - Rekap Data DAPODIK
    Route::get('/admin/dapodik', [AdminController::class, 'dapodikIndex'])->name('admin.dapodik.index');
    Route::get('/admin/dapodik/export', [AdminController::class, 'dapodikExport'])->name('admin.dapodik.export');
    
    // Admin - Backup Database
    Route::get('/admin/backup', [AdminController::class, 'backupIndex'])->name('admin.backup.index');
    Route::post('/admin/backup/create', [AdminController::class, 'backupCreate'])->name('admin.backup.create');
    Route::post('/admin/backup/restore', [AdminController::class, 'backupRestore'])->name('admin.backup.restore');
    Route::get('/admin/backup/download/{filename}', [AdminController::class, 'backupDownload'])
        ->where('filename', '.*\\.sql')
        ->name('admin.backup.download');
    Route::delete('/admin/backup/{filename}', [AdminController::class, 'backupDelete'])
        ->where('filename', '.*\\.sql')
        ->name('admin.backup.delete');

});

// ═══════════════════════════════════════════════════════
// GURU ROUTES
// ═══════════════════════════════════════════════════════
Route::middleware(['dummy.auth', 'role:guru'])->group(function () {
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
    Route::get('/guru/jadwal/create', [GuruController::class, 'jadwalCreate'])->name('guru.jadwal.create');
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
    Route::post('/guru/chat/room', [GuruController::class, 'openOrCreateRoom'])->name('guru.open_chat_room');
    Route::post('/guru/chat', [GuruController::class, 'kirimChat'])->name('guru.kirim_chat');
    Route::get('/guru/jadwal-konseling', [GuruController::class, 'jadwalKonseling'])->name('guru.jadwal_konseling');
    Route::get('/guru/jadwal-konseling/buat/siswa', [GuruController::class, 'jadwalKonselingCreateSiswa'])->name('guru.jadwal_konseling.create_siswa');
    Route::get('/guru/jadwal-konseling/buat/kelas', [GuruController::class, 'jadwalKonselingCreateKelas'])->name('guru.jadwal_konseling.create_kelas');
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
    Route::get('/guru/rapot/{classTermId}/siswa/{studentId}', [GuruController::class, 'rapotSiswaForm'])->name('guru.rapot.siswa.form');
    Route::post('/guru/rapot/{classTermId}/siswa/{studentId}', [GuruController::class, 'rapotSiswaSave'])->name('guru.rapot.siswa.save');
});

// ═══════════════════════════════════════════════════════
// ORANG TUA ROUTES
// ═══════════════════════════════════════════════════════
Route::middleware(['dummy.auth', 'role:orangtua'])->group(function () {
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
    Route::post('/orangtua/chat/room', [OrangTuaController::class, 'openOrCreateRoom'])->name('orangtua.open_chat_room');
    Route::post('/orangtua/chat', [OrangTuaController::class, 'kirimChat'])->name('orangtua.kirim_chat');
    Route::get('/orangtua/konseling', [OrangTuaController::class, 'konseling'])->name('orangtua.konseling');
    Route::get('/orangtua/konseling/ajukan', [OrangTuaController::class, 'konselingAjukanForm'])->name('orangtua.konseling.ajukan_form');
    Route::post('/orangtua/konseling', [OrangTuaController::class, 'ajukanKonseling'])->name('orangtua.ajukan_konseling');
    Route::get('/orangtua/konseling/{id}/edit', [OrangTuaController::class, 'konselingEditForm'])->name('orangtua.konseling.edit');
    Route::put('/orangtua/konseling/{id}', [OrangTuaController::class, 'konselingUpdate'])->name('orangtua.konseling.update');
    Route::delete('/orangtua/konseling/{id}', [OrangTuaController::class, 'konselingBatal'])->name('orangtua.konseling.batal');
});

