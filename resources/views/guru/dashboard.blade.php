@extends('layouts.app')

@section('title', 'Dashboard Guru - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Dashboard Guru')

{{-- SIDEBAR --}}
@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

{{-- CONTENT --}}
@section('content')

    {{-- Stats --}}
    <div class="stat-row">
        <div class="stat-card">
            <div class="stat-card__header">
                <span class="stat-card__label">Total Siswa</span>
                <svg class="stat-card__icon stat-card__icon--green" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2 7.5 4.019 7.5 6.5ZM20 21h1.5a.5.5 0 0 0 .5-.5C22 17.57 18.43 14 14.5 14h-5C5.57 14 2 17.57 2 20.5a.5.5 0 0 0 .5.5H20Z"/></svg>
            </div>
            <div class="stat-card__value">{{ $totalSiswa ?? 20 }}</div>
            <div class="stat-card__sub">Siswa aktif terdaftar</div>
        </div>
        <div class="stat-card">
            <div class="stat-card__header">
                <span class="stat-card__label">Konseling Bulan Ini</span>
                <svg class="stat-card__icon stat-card__icon--amber" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd"/></svg>
            </div>
            <div class="stat-card__value">{{ $konselingBulanIni ?? 15 }}</div>
            <div class="stat-card__sub">Sesi selesai & terjadwal</div>
        </div>
        <div class="stat-card">
            <div class="stat-card__header">
                <span class="stat-card__label">Pengajuan Jadwal</span>
                <svg class="stat-card__icon stat-card__icon--rose" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd"/></svg>
            </div>
            <div class="stat-card__value">{{ $pengajuanJadwal ?? 3 }}</div>
            <div class="stat-card__sub">Menunggu persetujuan</div>
        </div>
        <div class="stat-card">
            <div class="stat-card__header">
                <span class="stat-card__label">Semester</span>
                <svg class="stat-card__icon stat-card__icon--indigo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.174v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z"/><path d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286a48.4 48.4 0 0 1 6.085 2.563.198.198 0 0 0 .14 0c1.2-.538 2.42-1.036 3.561-1.48Z"/></svg>
            </div>
            <div class="stat-card__value stat-card__value--text">{{ $semester ?? 'Ganjil 2024/2025' }}</div>
            <div class="stat-card__sub">Tahun ajaran berjalan</div>
        </div>
    </div>

    {{-- Bottom Row --}}
    <div class="bottom-row">

        {{-- Update Terbaru --}}
        <div class="update-list">
            <div class="update-list__header">
                <span class="update-list__title">Update Terbaru</span>
                <span class="update-list__count">{{ count($updates ?? [1,2,3]) }} baru</span>
            </div>

            @forelse ($updates ?? [
                ['title' => 'Konseling Selesai - Muhammad', 'subtitle' => 'Sesi konseling individual', 'time' => '2 jam lalu', 'badge' => 'Selesai', 'badge_type' => 'done', 'initial' => 'M'],
                ['title' => 'Input Perkembangan - Anisa',   'subtitle' => 'Data perkembangan baru',    'time' => '1 hari lalu', 'badge' => 'Baru',    'badge_type' => 'new',  'initial' => 'A'],
                ['title' => 'Pesan dari Orang Tua Tika',    'subtitle' => 'Konsultasi jadwal',         'time' => '2 hari lalu', 'badge' => 'Pesan',   'badge_type' => 'info', 'initial' => 'T'],
            ] as $update)
                <div class="update-item">
                    <div class="update-item__avatar">{{ $update['initial'] ?? 'U' }}</div>
                    <div class="update-item__body">
                        <div class="update-item__title">{{ $update['title'] }}</div>
                        <div class="update-item__subtitle">{{ $update['subtitle'] ?? '' }}</div>
                    </div>
                    <div class="update-item__meta">
                        <span class="update-item__time">{{ $update['time'] }}</span>
                        <span class="update-item__badge update-item__badge--{{ $update['badge_type'] ?? 'info' }}">{{ $update['badge'] ?? '' }}</span>
                    </div>
                    <svg class="update-item__arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
                </div>
            @empty
                <div style="padding:16px;font-size:13px;color:#9CA3AF;">Belum ada update.</div>
            @endforelse
        </div>

        {{-- Jadwal Konseling Mendatang --}}
        <div class="card">
            <div class="card__header">
                <span class="card__title">Jadwal Konseling Mendatang</span>
                <span class="card__badge">{{ count($jadwalMendatang ?? [1]) }} jadwal</span>
            </div>
            <div class="card__body">
            @forelse ($jadwalMendatang ?? [
                [
                    'tanggal' => 'Jumat, 29 November 2024',
                    'waktu'   => '10:00 - 11:00 WIB',
                    'topik'   => 'Perkembangan Sosial Ahmad',
                ],
            ] as $jadwal)
                <div class="jadwal-box">
                    <div class="jadwal-box__row">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="jadwal-box__icon"><path fill-rule="evenodd" d="M5.75 2a.75.75 0 0 1 .75.75V4h7V2.75a.75.75 0 0 1 1.5 0V4h.25A2.75 2.75 0 0 1 18 6.75v8.5A2.75 2.75 0 0 1 15.25 18H4.75A2.75 2.75 0 0 1 2 15.25v-8.5A2.75 2.75 0 0 1 4.75 4H5V2.75A.75.75 0 0 1 5.75 2Zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75Z" clip-rule="evenodd"/></svg>
                        <strong>{{ $jadwal['tanggal'] }}</strong>
                    </div>
                    <div class="jadwal-box__row">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="jadwal-box__icon"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z" clip-rule="evenodd"/></svg>
                        <span>{{ $jadwal['waktu'] }}</span>
                    </div>
                    <div class="jadwal-box__row">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="jadwal-box__icon"><path fill-rule="evenodd" d="M4.5 2A1.5 1.5 0 0 0 3 3.5v13A1.5 1.5 0 0 0 4.5 18h11a1.5 1.5 0 0 0 1.5-1.5V7.621a1.5 1.5 0 0 0-.44-1.06l-4.12-4.122A1.5 1.5 0 0 0 11.378 2H4.5Zm2.25 8.5a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5h-6.5Zm0 3a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5h-6.5Z" clip-rule="evenodd"/></svg>
                        <span>{{ $jadwal['topik'] }}</span>
                    </div>
                    <a href="#" class="link">
                        Lihat Detail
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" style="width:12px;height:12px;"><path fill-rule="evenodd" d="M6.22 4.22a.75.75 0 0 1 1.06 0l3.25 3.25a.75.75 0 0 1 0 1.06l-3.25 3.25a.75.75 0 0 1-1.06-1.06L9.19 8 6.22 5.03a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
                    </a>
                </div>
            @empty
                <p style="font-size:13px;color:#9CA3AF;">Belum ada jadwal mendatang.</p>
            @endforelse
            </div>
        </div>

    </div>

@endsection
