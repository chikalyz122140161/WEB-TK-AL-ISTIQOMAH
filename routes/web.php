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
Route::get('/pendaftaran/success/{kode}', [PendaftaranController::class, 'success'])->name('pendaftaran.success');
Route::get('/pendaftaran/cek-status', [PendaftaranController::class, 'cekStatus'])->name('pendaftaran.cek-status');

// LOGIN autentikasi dengan role
Route::middleware(['auth', 'role:admin'])->group(function () {
    // route khusus admin
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
});

Route::middleware(['auth', 'role:guru'])->group(function () {
    // route khusus guru
    Route::get('/guru/dashboard', [GuruController::class, 'dashboard']);
});

Route::middleware(['auth', 'role:orangtua'])->group(function () {
    // route khusus orang tua
    Route::get('/orangtua/dashboard', [OrangTuaController::class, 'dashboard']);
});

// DASHBOARD (butuh login) 
Route::middleware('auth')->group(function () {
    // Dashboard Admin
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Dashboard Guru
    Route::get('/guru/dashboard', [GuruController::class, 'dashboard'])->name('guru.dashboard');

    // Guru - Administrasi: Kehadiran
    Route::get('/guru/kehadiran', [GuruController::class, 'kehadiranIndex'])->name('guru.kehadiran.index');
    Route::post('/guru/kehadiran', [GuruController::class, 'kehadiranStore'])->name('guru.kehadiran.store');

    // Guru - Administrasi: Laporan
    Route::get('/guru/laporan-administrasi', [GuruController::class, 'laporanIndex'])->name('guru.laporan.index');
    Route::post('/guru/laporan-administrasi/generate', [GuruController::class, 'laporanGenerate'])->name('guru.laporan.generate');

    // Guru - Administrasi: Jadwal
    Route::get('/guru/jadwal', [GuruController::class, 'jadwalIndex'])->name('guru.jadwal.index');
    Route::post('/guru/jadwal', [GuruController::class, 'jadwalStore'])->name('guru.jadwal.store');

    // Guru - Bimbingan Konseling
    Route::get('/guru/input-perkembangan', [GuruController::class, 'inputPerkembangan'])->name('guru.input_perkembangan');
    Route::post('/guru/input-perkembangan', [GuruController::class, 'storeInputPerkembangan'])->name('guru.store_input_perkembangan');
    Route::get('/guru/grafik', [GuruController::class, 'grafik'])->name('guru.grafik');
    Route::get('/guru/laporan-bk', [GuruController::class, 'laporan'])->name('guru.laporan_bk');
    Route::get('/guru/chat', [GuruController::class, 'chat'])->name('guru.chat');
    Route::post('/guru/chat', [GuruController::class, 'kirimChat'])->name('guru.kirim_chat');
    Route::get('/guru/jadwal-konseling', [GuruController::class, 'jadwalKonseling'])->name('guru.jadwal_konseling');
    Route::post('/guru/jadwal-konseling', [GuruController::class, 'storeJadwalKonseling'])->name('guru.store_jadwal_konseling');

    // Dashboard Orang Tua
    Route::get('/orangtua/dashboard', [OrangTuaController::class, 'dashboard'])->name('orangtua.dashboard');
});

