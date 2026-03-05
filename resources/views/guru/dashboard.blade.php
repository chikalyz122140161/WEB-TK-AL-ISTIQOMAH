@extends('layouts.app')

@section('title', 'Dashboard Guru - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Dashboard Guru')

{{-- SIDEBAR --}}
@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

{{-- CONTENT --}}
@section('content')

@push('styles')
<style>
    .section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 2px solid #faae2b;
    }
    .section-header__icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #faae2b 0%, #f5a623 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .section-header__icon svg {
        width: 22px;
        height: 22px;
        fill: #00473e;
    }
    .section-header__text h2 {
        font-size: 18px;
        font-weight: 700;
        color: #00473e;
        margin: 0;
    }
    .section-header__text p {
        font-size: 13px;
        color: #475d5b;
        margin: 2px 0 0;
    }
    .section-wrapper {
        margin-bottom: 32px;
    }
    .stat-row-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 16px;
    }
    @media (max-width: 1024px) {
        .stat-row-3 { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .stat-row-3 { grid-template-columns: 1fr; }
    }
</style>
@endpush

    {{-- ═══════════════════════════════════════════════════════
         SECTION: ADMINISTRASI 
    ═══════════════════════════════════════════════════════ --}}
    <div class="section-wrapper">
        <div class="section-header">
            <div class="section-header__icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z" clip-rule="evenodd"/></svg>
            </div>
            <div class="section-header__text">
                <h2>Administrasi</h2>
                <p>Kelola kehadiran, laporan, dan jadwal kegiatan</p>
            </div>
        </div>

        <div class="stat-row-3">
            <div class="stat-card">
                <div class="stat-card__header">
                    <span class="stat-card__label">Hadir Hari Ini</span>
                    <svg class="stat-card__icon stat-card__icon--green" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd"/></svg>
                </div>
                <div class="stat-card__value">{{ $hadirHariIni ?? 18 }}</div>
                <div class="stat-card__sub">dari {{ $totalSiswa ?? 22 }} siswa</div>
            </div>
            <div class="stat-card">
                <div class="stat-card__header">
                    <span class="stat-card__label">Laporan Bulan Ini</span>
                    <svg class="stat-card__icon stat-card__icon--amber" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd"/><path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z"/></svg>
                </div>
                <div class="stat-card__value">{{ $laporanBulanIni ?? 10 }}</div>
                <div class="stat-card__sub">Laporan dibuat</div>
            </div>
            <div class="stat-card">
                <div class="stat-card__header">
                    <span class="stat-card__label">Jadwal Kegiatan</span>
                    <svg class="stat-card__icon stat-card__icon--rose" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd"/></svg>
                </div>
                <div class="stat-card__value">{{ $jadwalMingguIni ?? 5 }}</div>
                <div class="stat-card__sub">Minggu ini</div>
            </div>
        </div>

        <div class="bottom-row">
            {{-- Update Administrasi --}}
            <div class="update-list">
                <div class="update-list__header">
                    <span class="update-list__title">Update Administrasi</span>
                    <span class="update-list__count">{{ count($updateAdmin ?? [1,2,3]) }} baru</span>
                </div>
                @forelse ($updateAdmin ?? [
                    ['title' => 'Laporan Ahmad Fauzi Dibuat', 'subtitle' => 'Laporan kehadiran', 'time' => '1 jam lalu', 'badge' => 'Laporan', 'badge_type' => 'done', 'initial' => 'L'],
                    ['title' => 'Kehadiran Hari Ini Dicatat', 'subtitle' => '22 siswa tercatat', 'time' => '3 jam lalu', 'badge' => 'Kehadiran', 'badge_type' => 'new', 'initial' => 'K'],
                    ['title' => 'Jadwal Upacara Ditambahkan', 'subtitle' => 'Senin, 10 Maret 2026', 'time' => 'Kemarin', 'badge' => 'Jadwal', 'badge_type' => 'info', 'initial' => 'J'],
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
                    <div style="padding:16px;font-size:13px;color:#475d5b;">Belum ada update.</div>
                @endforelse
            </div>

            {{-- Jadwal Kegiatan Mendatang --}}
            <div class="card">
                <div class="card__header">
                    <span class="card__title">Jadwal Kegiatan Mendatang</span>
                    <span class="card__badge">{{ count($jadwalKegiatan ?? [1,2]) }} kegiatan</span>
                </div>
                <div class="card__body">
                @forelse ($jadwalKegiatan ?? [
                    ['tanggal' => 'Senin, 10 Maret 2026', 'waktu' => '07:00 - 08:00 WIB', 'topik' => 'Upacara Bendera'],
                    ['tanggal' => 'Minggu, 16 Maret 2026', 'waktu' => '08:00 - 12:00 WIB', 'topik' => 'Outing Class - Kebun Binatang'],
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
                        <a href="{{ route('guru.jadwal.index') }}" class="link">
                            Lihat Detail
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" style="width:12px;height:12px;"><path fill-rule="evenodd" d="M6.22 4.22a.75.75 0 0 1 1.06 0l3.25 3.25a.75.75 0 0 1 0 1.06l-3.25 3.25a.75.75 0 0 1-1.06-1.06L9.19 8 6.22 5.03a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
                        </a>
                    </div>
                @empty
                    <p style="font-size:13px;color:#475d5b;">Belum ada jadwal mendatang.</p>
                @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════
         SECTION: BIMBINGAN KONSELING 
    ═══════════════════════════════════════════════════════ --}}
    <div class="section-wrapper">
        <div class="section-header">
            <div class="section-header__icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z"/></svg>
            </div>
            <div class="section-header__text">
                <h2>Bimbingan Konseling</h2>
                <p>Pantau perkembangan siswa dan kelola konseling</p>
            </div>
        </div>

        <div class="stat-row-3">
            <div class="stat-card">
                <div class="stat-card__header">
                    <span class="stat-card__label">Total Siswa</span>
                    <svg class="stat-card__icon stat-card__icon--green" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2 7.5 4.019 7.5 6.5ZM20 21h1.5a.5.5 0 0 0 .5-.5C22 17.57 18.43 14 14.5 14h-5C5.57 14 2 17.57 2 20.5a.5.5 0 0 0 .5.5H20Z"/></svg>
                </div>
                <div class="stat-card__value">{{ $totalSiswa ?? 22 }}</div>
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
                    <span class="stat-card__label">Pesan Belum Dibaca</span>
                    <svg class="stat-card__icon stat-card__icon--rose" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M4.913 2.658c2.075-.27 4.19-.408 6.337-.408 2.147 0 4.262.139 6.337.408 1.922.25 3.291 1.861 3.405 3.727a4.403 4.403 0 0 0-1.032-.211 50.89 50.89 0 0 0-8.42 0c-2.358.196-4.04 2.19-4.04 4.434v4.286a4.47 4.47 0 0 0 2.433 3.984L7.28 21.53A.75.75 0 0 1 6 21v-4.03a48.527 48.527 0 0 1-1.087-.128C2.905 16.58 1.5 14.833 1.5 12.862V6.638c0-1.97 1.405-3.718 3.413-3.979Z"/><path d="M15.75 7.5c-1.376 0-2.739.057-4.086.169C10.124 7.797 9 9.103 9 10.609v4.285c0 1.507 1.128 2.814 2.67 2.94 1.243.102 2.5.157 3.768.165l2.782 2.781a.75.75 0 0 0 1.28-.53v-2.39l.33-.026c1.542-.125 2.67-1.433 2.67-2.94v-4.286c0-1.505-1.125-2.811-2.664-2.94A49.392 49.392 0 0 0 15.75 7.5Z"/></svg>
                </div>
                <div class="stat-card__value">{{ $pesanBelumDibaca ?? 3 }}</div>
                <div class="stat-card__sub">Dari orang tua</div>
            </div>
        </div>

        <div class="bottom-row">
            {{-- Update BK --}}
            <div class="update-list">
                <div class="update-list__header">
                    <span class="update-list__title">Update Bimbingan Konseling</span>
                    <span class="update-list__count">{{ count($updateBK ?? [1,2,3]) }} baru</span>
                </div>
                @forelse ($updateBK ?? [
                    ['title' => 'Konseling Selesai - Muhammad', 'subtitle' => 'Sesi konseling individual', 'time' => '2 jam lalu', 'badge' => 'Selesai', 'badge_type' => 'done', 'initial' => 'M'],
                    ['title' => 'Input Perkembangan - Anisa', 'subtitle' => 'Data perkembangan baru', 'time' => '1 hari lalu', 'badge' => 'Baru', 'badge_type' => 'new', 'initial' => 'A'],
                    ['title' => 'Pesan dari Orang Tua Tika', 'subtitle' => 'Konsultasi jadwal', 'time' => '2 hari lalu', 'badge' => 'Pesan', 'badge_type' => 'info', 'initial' => 'T'],
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
                    <div style="padding:16px;font-size:13px;color:#475d5b;">Belum ada update.</div>
                @endforelse
            </div>

            {{-- Jadwal Konseling Mendatang --}}
            <div class="card">
                <div class="card__header">
                    <span class="card__title">Jadwal Konseling Mendatang</span>
                    <span class="card__badge">{{ count($jadwalKonselingMendatang ?? [1]) }} jadwal</span>
                </div>
                <div class="card__body">
                @forelse ($jadwalKonselingMendatang ?? [
                    ['tanggal' => 'Jumat, 7 Maret 2026', 'waktu' => '10:00 - 11:00 WIB', 'topik' => 'Perkembangan Sosial Ahmad'],
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
                        <a href="{{ route('guru.jadwal_konseling') }}" class="link">
                            Lihat Detail
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" style="width:12px;height:12px;"><path fill-rule="evenodd" d="M6.22 4.22a.75.75 0 0 1 1.06 0l3.25 3.25a.75.75 0 0 1 0 1.06l-3.25 3.25a.75.75 0 0 1-1.06-1.06L9.19 8 6.22 5.03a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
                        </a>
                    </div>
                @empty
                    <p style="font-size:13px;color:#475d5b;">Belum ada jadwal mendatang.</p>
                @endforelse
                </div>
            </div>
        </div>
    </div>

@endsection
