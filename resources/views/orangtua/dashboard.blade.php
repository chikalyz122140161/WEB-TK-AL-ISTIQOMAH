@extends('layouts.app')
@php $userRole = 'Orang Tua'; @endphp

@section('title', 'Dashboard Orang Tua - SISTEM BK TK AL-ISTIQOMAH')
@section('page_title', 'Dashboard Orang Tua')

@section('sidebar')
    @include('orangtua.partials.sidebar')
@endsection

@push('styles')
<style>
    /* ─── Hero Banner ─── */
    .db-hero {
        background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 50%, #2E8B60 100%);
        border-radius: 16px;
        padding: 22px 28px;
        margin-bottom: 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        color: #fff;
        box-shadow: 0 4px 20px rgba(61,155,114,0.22);
    }
    .db-hero__left { display: flex; align-items: center; gap: 16px; }
    .db-hero__av {
        width: 56px; height: 56px; border-radius: 50%;
        background: rgba(255,255,255,0.22);
        border: 2px solid rgba(255,255,255,0.35);
        display: flex; align-items: center; justify-content: center;
        font-size: 22px; font-weight: 800; color: #fff; flex-shrink: 0;
    }
    .db-hero__title { font-size: 19px; font-weight: 700; margin: 0 0 3px; }
    .db-hero__sub   { font-size: 12.5px; opacity: .82; margin: 0; }
    .db-hero__pills { display: flex; gap: 8px; flex-wrap: wrap; justify-content: flex-end; }
    .db-hero__pill  {
        background: rgba(255,255,255,.18);
        border: 1px solid rgba(255,255,255,.28);
        border-radius: 20px;
        padding: 5px 13px;
        font-size: 12px; font-weight: 600;
        display: flex; align-items: center; gap: 5px;
    }
    .db-hero__pill svg { width: 13px; height: 13px; fill: currentColor; flex-shrink: 0; }
    @media (max-width: 768px) {
        .db-hero { flex-direction: column; align-items: flex-start; }
        .db-hero__pills { justify-content: flex-start; }
    }

    /* ─── Stat Row ─── */
    .db-stat-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 24px;
    }
    @media (max-width: 1024px) { .db-stat-row { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 640px)  { .db-stat-row { grid-template-columns: 1fr; } }

    .dbs-label {
        font-size: 10.5px; font-weight: 700;
        letter-spacing: .07em; text-transform: uppercase;
        color: rgba(255,255,255,.82);
        display: flex; align-items: center; gap: 5px;
        margin-bottom: 4px;
    }
    .dbs-label svg { width: 13px; height: 13px; fill: currentColor; flex-shrink: 0; }
    .dbs-label--dark { color: rgba(62,39,35,.6); }
    .dbs-val { font-size: 40px; font-weight: 800; color: #fff; line-height: 1.1; margin-bottom: 3px; }
    .dbs-val--dark { color: #3E2723; }
    .dbs-sub { font-size: 12px; color: rgba(255,255,255,.75); }
    .dbs-sub--dark { color: rgba(62,39,35,.55); }

    /* ─── Green Card ─── */
    .dbs-green {
        background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 55%, #2E8B60 100%);
        border-radius: 16px; padding: 20px 22px; color: #fff;
    }
    .dbs-green__top {
        display: flex; justify-content: space-between;
        align-items: flex-start; margin-bottom: 8px;
    }
    .dbs-green__values {
        display: flex; justify-content: space-between;
        align-items: flex-end; margin-bottom: 16px;
    }
    .dbs-green__values > div:last-child { text-align: right; }
    .dbs-green__bar-wrap {
        background: rgba(255,255,255,.25);
        border-radius: 6px; height: 6px; overflow: hidden; margin-bottom: 7px;
    }
    .dbs-green__bar-fill { height: 100%; background: #fff; border-radius: 6px; transition: width .6s ease; }
    .dbs-green__bar-label { font-size: 11px; color: rgba(255,255,255,.75); }

    /* ─── Yellow Card ─── */
    .dbs-yellow {
        background: #FFF176; border-radius: 16px;
        overflow: hidden; display: flex; flex-direction: column;
    }
    .dbs-yellow__item { padding: 18px 22px; flex: 1; }
    .dbs-sep { height: 1px; background: rgba(62,39,35,.1); margin: 0 22px; }

    /* ─── Pink Card ─── */
    .dbs-pink {
        background: #F06292; border-radius: 16px;
        overflow: hidden; display: flex; flex-direction: column;
    }
    .dbs-pink__item { padding: 18px 22px; flex: 1; }
    .dbs-sep--light { background: rgba(255,255,255,.22); margin: 0; }

    /* ─── Bottom Grid ─── */
    .db-bottom {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 16px;
        align-items: start;
    }
    @media (max-width: 1100px) { .db-bottom { grid-template-columns: 1fr; } }

    /* ─── Quick Action Cards ─── */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }
    .qa-card {
        background: #fff;
        border: 1px solid #3E272318;
        border-radius: 12px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        text-decoration: none;
        transition: all .15s;
        gap: 8px;
    }
    .qa-card:hover {
        border-color: #4CAF82;
        background: #f0fdf4;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(61,155,114,0.12);
    }
    .qa-card__icon {
        width: 44px; height: 44px;
        background: linear-gradient(135deg, #4CAF8222, #3D9B7222);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
    }
    .qa-card__icon svg { width: 22px; height: 22px; fill: #4CAF82; }
    .qa-card__title { font-size: 13px; font-weight: 600; color: #3E2723; }
    .qa-card__desc  { font-size: 11px; color: #5D4037; }

    .db-right-stack > .card + .card { margin-top: 14px; }
</style>
@endpush

@section('content')

@php
    $namaAnak    = $student->nama ?? 'Ahmad Fauzi';
    $kelasAnak   = $student->kelas ?? 'TK A';
    $tahunAjaran = $student->tahun_ajaran ?? '2024/2025';
    $hadir       = $kehadiranBulanIni ?? 18;
    $totalReport = $totalReport ?? 12;
    $avgScore    = $avgScore ?? '3.8';
    $pesanBaru   = $pesanBaru ?? 2;
    $targetHadir = 22;
    $pct         = $targetHadir > 0 ? round($hadir / $targetHadir * 100) : 0;
@endphp

{{-- ═══════════ HERO BANNER ═══════════ --}}
<div class="db-hero">
    <div class="db-hero__left">
        <div class="db-hero__av">{{ substr($namaAnak, 0, 1) }}</div>
        <div>
            <p class="db-hero__title">{{ $namaAnak }}</p>
            <p class="db-hero__sub">Kelas: {{ $kelasAnak }} &nbsp;&middot;&nbsp; Tahun Ajaran: {{ $tahunAjaran }}</p>
        </div>
    </div>
</div>

{{-- ═══════════ STAT CARDS ═══════════ --}}
<div class="db-stat-row">

    {{-- GREEN: Kehadiran --}}
    <div class="dbs-green">
        <div class="dbs-green__top">
            <div>
                <div class="dbs-label">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd"/></svg>
                    Hadir Bulan Ini
                </div>
            </div>
            <div><div class="dbs-label">Target</div></div>
        </div>
        <div class="dbs-green__values">
            <div>
                <div class="dbs-val">{{ $hadir }}</div>
                <div class="dbs-sub">Hari hadir</div>
            </div>
            <div>
                <div class="dbs-val">{{ $targetHadir }}</div>
                <div class="dbs-sub">Hari aktif</div>
            </div>
        </div>
        <div class="dbs-green__bar-wrap">
            <div class="dbs-green__bar-fill" style="width:{{ $pct }}%"></div>
        </div>
        <div class="dbs-green__bar-label">{{ $hadir }} dari {{ $targetHadir }} hari ({{ $pct }}%)</div>
    </div>

    {{-- YELLOW: Report + Rata-rata --}}
    <div class="dbs-yellow">
        <div class="dbs-yellow__item">
            <div class="dbs-label dbs-label--dark">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd"/><path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z"/></svg>
                Report Tersedia
            </div>
            <div class="dbs-val dbs-val--dark">{{ $totalReport }}</div>
            <div class="dbs-sub dbs-sub--dark">Laporan perkembangan</div>
        </div>
        <div class="dbs-sep"></div>
        <div class="dbs-yellow__item">
            <div class="dbs-label dbs-label--dark">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd"/></svg>
                Rata-rata Nilai
            </div>
            <div class="dbs-val dbs-val--dark">{{ $avgScore }}</div>
            <div class="dbs-sub dbs-sub--dark">Semester ini</div>
        </div>
    </div>

    {{-- PINK: Pesan Baru + Konseling --}}
    <div class="dbs-pink">
        <div class="dbs-pink__item">
            <div class="dbs-label">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M4.913 2.658c2.075-.27 4.19-.408 6.337-.408 2.147 0 4.262.139 6.337.408 1.922.25 3.291 1.861 3.405 3.727a4.403 4.403 0 0 0-1.032-.211 50.89 50.89 0 0 0-8.42 0c-2.358.196-4.04 2.19-4.04 4.434v4.286a4.47 4.47 0 0 0 2.433 3.984L7.28 21.53A.75.75 0 0 1 6 21v-4.03a48.527 48.527 0 0 1-1.087-.128C2.905 16.58 1.5 14.833 1.5 12.862V6.638c0-1.97 1.405-3.718 3.413-3.979Z"/><path d="M15.75 7.5c-1.376 0-2.739.057-4.086.169C10.124 7.797 9 9.103 9 10.609v4.285c0 1.507 1.128 2.814 2.67 2.94 1.243.102 2.5.157 3.768.165l2.782 2.781a.75.75 0 0 0 1.28-.53v-2.39l.33-.026c1.542-.125 2.67-1.433 2.67-2.94v-4.286c0-1.505-1.125-2.811-2.664-2.94A49.392 49.392 0 0 0 15.75 7.5Z"/></svg>
                Pesan Baru
            </div>
            <div class="dbs-val">{{ $pesanBaru }}</div>
            <div class="dbs-sub">Dari guru</div>
        </div>
        <div class="dbs-sep dbs-sep--light"></div>
        <div class="dbs-pink__item">
            <div class="dbs-label">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd"/></svg>
                Konseling Aktif
            </div>
            <div class="dbs-val">{{ $konselingAktif ?? 1 }}</div>
            <div class="dbs-sub">Jadwal mendatang</div>
        </div>
    </div>

</div>

{{-- ═══════════ BOTTOM: ACTIVITY + SIDEBAR ═══════════ --}}
<div class="db-bottom">

    {{-- Aktivitas Terbaru --}}
    <div class="update-list">
        <div class="update-list__header">
            <span class="update-list__title">Aktivitas Terbaru</span>
            <span class="update-list__count">Update terkini tentang anak Anda</span>
        </div>

        <a href="{{ route('orangtua.laporan') }}" class="update-item" style="text-decoration:none;display:flex;">
            <div class="update-item__avatar">L</div>
            <div class="update-item__body">
                <div class="update-item__title">Report Minggu 12 Tersedia</div>
                <div class="update-item__subtitle">Perkembangan anak periode 18-22 November 2024 telah diupdate</div>
            </div>
            <div class="update-item__meta">
                <span class="update-item__time">2 jam lalu</span>
                <span class="update-item__badge update-item__badge--done">Laporan</span>
            </div>
            <svg class="update-item__arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
        </a>

        <a href="{{ route('orangtua.presensi') }}" class="update-item" style="text-decoration:none;display:flex;">
            <div class="update-item__avatar">K</div>
            <div class="update-item__body">
                <div class="update-item__title">Kehadiran Tercatat</div>
                <div class="update-item__subtitle">{{ $namaAnak }} hadir di sekolah hari ini</div>
            </div>
            <div class="update-item__meta">
                <span class="update-item__time">5 jam lalu</span>
                <span class="update-item__badge update-item__badge--new">Hadir</span>
            </div>
            <svg class="update-item__arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
        </a>

        <a href="{{ route('orangtua.chat') }}" class="update-item" style="text-decoration:none;display:flex;">
            <div class="update-item__avatar">P</div>
            <div class="update-item__body">
                <div class="update-item__title">Pesan dari Guru</div>
                <div class="update-item__subtitle">Bu Siti mengirimkan pesan tentang kegiatan outdoor minggu depan</div>
            </div>
            <div class="update-item__meta">
                <span class="update-item__time">Kemarin</span>
                <span class="update-item__badge update-item__badge--info">Pesan</span>
            </div>
            <svg class="update-item__arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
        </a>

        <a href="{{ route('orangtua.laporan') }}" class="update-item" style="text-decoration:none;display:flex;">
            <div class="update-item__avatar">L</div>
            <div class="update-item__body">
                <div class="update-item__title">Report Minggu 11 Tersedia</div>
                <div class="update-item__subtitle">Perkembangan anak periode 11-15 November 2024</div>
            </div>
            <div class="update-item__meta">
                <span class="update-item__time">1 minggu lalu</span>
                <span class="update-item__badge update-item__badge--done">Laporan</span>
            </div>
            <svg class="update-item__arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
        </a>
    </div>

    {{-- Kanan: Akses Cepat --}}
    <div class="db-right-stack">
        <div class="card">
            <div class="card__header">
                <span class="card__title">Akses Cepat</span>
                <span class="card__badge">Menu utama</span>
            </div>
            <div class="card__body">
                <div class="quick-actions">
                    <a href="{{ route('orangtua.presensi') }}" class="qa-card">
                        <div class="qa-card__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h3A1.5 1.5 0 0 0 13.5 3ZM3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z" clip-rule="evenodd"/></svg>
                        </div>
                        <div class="qa-card__title">Lihat Presensi</div>
                        <div class="qa-card__desc">Cek kehadiran anak</div>
                    </a>

                    <a href="{{ route('orangtua.laporan') }}" class="qa-card">
                        <div class="qa-card__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd"/><path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z"/></svg>
                        </div>
                        <div class="qa-card__title">Lihat Laporan</div>
                        <div class="qa-card__desc">Laporan perkembangan anak</div>
                    </a>

                    <a href="{{ route('orangtua.jadwal') }}" class="qa-card">
                        <div class="qa-card__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd"/></svg>
                        </div>
                        <div class="qa-card__title">Lihat Jadwal</div>
                        <div class="qa-card__desc">Jadwal kegiatan sekolah</div>
                    </a>

                    <a href="{{ route('orangtua.konseling') }}" class="qa-card">
                        <div class="qa-card__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M4.804 21.644A6.707 6.707 0 0 0 6 21.75a6.721 6.721 0 0 0 3.583-1.029c.774.182 1.584.279 2.417.279 5.322 0 9.75-3.97 9.75-9 0-5.03-4.428-9-9.75-9s-9.75 3.97-9.75 9c0 2.09.768 4.04 2.084 5.558a8.96 8.96 0 0 1-1.603 2.596.75.75 0 0 0 .53 1.28 6.72 6.72 0 0 0 1.543-.09Z" clip-rule="evenodd"/></svg>
                        </div>
                        <div class="qa-card__title">Konseling</div>
                        <div class="qa-card__desc">Jadwal & pengajuan</div>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>{{-- end db-bottom --}}

@endsection
