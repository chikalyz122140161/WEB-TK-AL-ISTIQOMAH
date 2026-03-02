<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\OrangTuaController;

// Dashboard Admin
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// Dashboard Guru
Route::get('/guru/dashboard', [GuruController::class, 'dashboard'])->name('guru.dashboard');

// Input Perkembangan
Route::get('/guru/input-perkembangan', [GuruController::class, 'inputPerkembangan'])->name('guru.input_perkembangan');
Route::post('/guru/input-perkembangan', [GuruController::class, 'storeInputPerkembangan'])->name('guru.input_perkembangan.store');

// Grafik Perkembangan
Route::get('/guru/grafik', [GuruController::class, 'grafik'])->name('guru.grafik');

// Laporan Perkembangan
Route::get('/guru/laporan', [GuruController::class, 'laporan'])->name('guru.laporan');

// Chat
Route::get('/guru/chat', [GuruController::class, 'chat'])->name('guru.chat');
Route::post('/guru/chat/kirim', [GuruController::class, 'kirimChat'])->name('guru.chat.kirim');

// Jadwal Konseling
Route::get('/guru/jadwal-konseling', [GuruController::class, 'jadwalKonseling'])->name('guru.jadwal_konseling');
Route::post('/guru/jadwal-konseling', [GuruController::class, 'storeJadwalKonseling'])->name('guru.jadwal_konseling.store');

// Dashboard Orang Tua
Route::get('/orangtua/dashboard', [OrangTuaController::class, 'dashboard'])->name('orangtua.dashboard');
