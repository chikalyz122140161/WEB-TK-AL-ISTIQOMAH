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

    // Dashboard Orang Tua
    Route::get('/orangtua/dashboard', [OrangTuaController::class, 'dashboard'])->name('orangtua.dashboard');
});

