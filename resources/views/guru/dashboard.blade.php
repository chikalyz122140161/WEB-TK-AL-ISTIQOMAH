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
    .db-hero__title { font-size: 20px; font-weight: 700; margin: 0 0 4px; }
    .db-hero__sub   { font-size: 13px; opacity: .82; margin: 0; }
    .db-hero__pills { display: flex; gap: 8px; flex-wrap: wrap; justify-content: flex-end; }
    .db-hero__pill  {
        background: rgba(255,255,255,.18);
        border: 1px solid rgba(255,255,255,.28);
        border-radius: 20px;
        padding: 5px 13px;
        font-size: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 5px;
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

    /* Shared label / value / sub */
    .dbs-label {
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: .07em;
        text-transform: uppercase;
        color: rgba(255,255,255,.82);
        display: flex;
        align-items: center;
        gap: 5px;
        margin-bottom: 4px;
    }
    .dbs-label svg { width: 13px; height: 13px; fill: currentColor; flex-shrink: 0; }
    .dbs-label--dark { color: rgba(62,39,35,.6); }
    .dbs-val {
        font-size: 40px;
        font-weight: 800;
        color: #fff;
        line-height: 1.1;
        margin-bottom: 3px;
    }
    .dbs-val--dark { color: #3E2723; }
    .dbs-sub { font-size: 12px; color: rgba(255,255,255,.75); }
    .dbs-sub--dark { color: rgba(62,39,35,.55); }

    /* ─── Green Card (Total Siswa + Hadir) ─── */
    .dbs-green {
        background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 55%, #2E8B60 100%);
        border-radius: 16px;
        padding: 20px 22px;
        color: #fff;
    }
    .dbs-green__top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 8px;
    }
    .dbs-green__top > div:last-child .dbs-label { justify-content: flex-end; }
    .dbs-green__values {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 16px;
    }
    .dbs-green__values > div:last-child { text-align: right; }
    .dbs-green__bar-wrap {
        background: rgba(255,255,255,.25);
        border-radius: 6px;
        height: 6px;
        overflow: hidden;
        margin-bottom: 7px;
    }
    .dbs-green__bar-fill {
        height: 100%;
        background: #fff;
        border-radius: 6px;
        transition: width .6s ease;
    }
    .dbs-green__bar-label { font-size: 11px; color: rgba(255,255,255,.75); }

    /* ─── Yellow Card (2 stats stacked) ─── */
    .dbs-yellow {
        background: #FFF176;
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .dbs-yellow__item { padding: 18px 22px; flex: 1; }
    .dbs-sep { height: 1px; background: rgba(62,39,35,.1); margin: 0 22px; }

    /* ─── Pink Card ─── */
    .dbs-pink {
        background: #F06292;
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .dbs-pink__item { padding: 22px 22px; }
    .dbs-sep--light { background: rgba(255,255,255,.22); margin: 0; }

    /* ─── Bottom Grid ─── */
    .db-bottom {
        display: grid;
        grid-template-columns: 1fr;
        gap: 16px;
        align-items: start;
    }

    /* ─── Jadwal Stack ─── */
    .db-jadwal-stack > .card + .card { margin-top: 14px; }
</style>
@endpush

{{-- ═══════════════════ HERO BANNER ═══════════════════ --}}
<div class="db-hero">
    <div>
        <p class="db-hero__title">Selamat Datang Kembali &#128075;</p>
        <p class="db-hero__sub">{!! $heroSub ?? 'Dashboard Guru' !!}</p>
    </div>
</div>

{{-- ═══════════════════ STAT CARDS ═══════════════════ --}}
@php
    $totalS = $totalSiswa ?? 0;
    $hadirS = $hadirHariIni ?? 0;
    $pct    = $totalS > 0 ? round($hadirS / $totalS * 100) : 0;
@endphp
<div class="db-stat-row">

    {{-- GREEN: Total Siswa + Hadir --}}
    <div class="dbs-green">
        <div class="dbs-green__top">
            <div>
                <div class="dbs-label">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2 7.5 4.019 7.5 6.5ZM20 21h1.5a.5.5 0 0 0 .5-.5C22 17.57 18.43 14 14.5 14h-5C5.57 14 2 17.57 2 20.5a.5.5 0 0 0 .5.5H20Z"/></svg>
                    Total Siswa
                </div>
            </div>
            <div>
                <div class="dbs-label">Hadir Hari Ini</div>
            </div>
        </div>
        <div class="dbs-green__values">
            <div>
                <div class="dbs-val">{{ $totalS }}</div>
                <div class="dbs-sub">Siswa terdaftar</div>
            </div>
            <div>
                <div class="dbs-val">{{ $hadirS }}</div>
                <div class="dbs-sub">Dari presensi</div>
            </div>
        </div>
        <div class="dbs-green__bar-wrap">
            <div class="dbs-green__bar-fill" style="width:{{ $pct }}%"></div>
        </div>
        <div class="dbs-green__bar-label">{{ $hadirS }} dari {{ $totalS }} hadir ({{ $pct }}%)</div>
        {{-- Selector class term --}}
        <form method="GET" action="{{ route('guru.dashboard') }}" style="margin-top:12px;">
            <select name="class_term_id" onchange="this.form.submit()"
                style="width:100%;padding:5px 8px;border-radius:8px;border:1px solid rgba(255,255,255,.4);background:rgba(255,255,255,.15);color:#fff;font-size:12px;cursor:pointer;">
                @foreach ($classTerms ?? [] as $ct)
                    <option value="{{ $ct->id }}"
                        {{ $ct->id == ($selectedClassTermId ?? '') ? 'selected' : '' }}
                        style="color:#333;">
                        {{ $ct->class?->name }} — {{ $ct->academicTerm?->academic_year }} {{ ucfirst($ct->academicTerm?->semester ?? '') }}
                        {{ !$ct->isPass ? '(Aktif)' : '' }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    {{-- YELLOW: Konseling Bulan Ini + Menunggu --}}
    <div class="dbs-yellow">
        <div class="dbs-yellow__item">
            <div class="dbs-label dbs-label--dark">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd"/></svg>
                Konseling Bulan Ini
            </div>
            <div class="dbs-val dbs-val--dark">{{ $konselingBulanIni ?? 0 }}</div>
            <div class="dbs-sub dbs-sub--dark">Sesi disetujui bulan ini</div>
        </div>
        <div class="dbs-sep"></div>
        <div class="dbs-yellow__item">
            <div class="dbs-label dbs-label--dark">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd"/></svg>
                Menunggu Persetujuan
            </div>
            <div class="dbs-val dbs-val--dark">{{ $konselingPending ?? 0 }}</div>
            <div class="dbs-sub dbs-sub--dark">Pengajuan dari orang tua</div>
        </div>
    </div>

    {{-- PINK: Jadwal Kegiatan Bulan Ini --}}
    <div class="dbs-pink">
        <div class="dbs-pink__item">
            <div class="dbs-label">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd"/></svg>
                Jadwal Kegiatan Bulan Ini
            </div>
            <div class="dbs-val">{{ $jadwalKegiatanCount ?? 0 }}</div>
            <div class="dbs-sub">Kegiatan terjadwal</div>
        </div>
    </div>

</div>

{{-- ═══════════════════ BOTTOM: JADWAL ═══════════════════ --}}
<div class="db-bottom">

    {{-- Jadwal Cards Stacked --}}
    <div class="db-jadwal-stack">

        <div class="card">
            <div class="card__header">
                <span class="card__title">Jadwal Kegiatan Bulan Ini</span>
                <span class="card__badge">{{ count($jadwalKegiatan ?? []) }} kegiatan</span>
            </div>
            <div class="card__body">
                @forelse ($jadwalKegiatan ?? [] as $jadwal)
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
                        @if (!empty($jadwal['lokasi']))
                        <div class="jadwal-box__row" style="color:#888;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="jadwal-box__icon"><path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 0 0 .281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 1 0 3 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 0 0 2.273 1.765 11.842 11.842 0 0 0 .976.544l.062.029.018.008.006.003ZM10 11.25a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z" clip-rule="evenodd"/></svg>
                            <span>{{ $jadwal['lokasi'] }}</span>
                        </div>
                        @endif
                        <a href="{{ route('guru.jadwal.index') }}" class="link">
                            Lihat Detail
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" style="width:12px;height:12px;"><path fill-rule="evenodd" d="M6.22 4.22a.75.75 0 0 1 1.06 0l3.25 3.25a.75.75 0 0 1 0 1.06l-3.25 3.25a.75.75 0 0 1-1.06-1.06L9.19 8 6.22 5.03a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
                        </a>
                    </div>
                @empty
                    <p style="font-size:13px;color:#888;">Belum ada jadwal kegiatan bulan ini.</p>
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="card__header">
                <span class="card__title">Jadwal Konseling Bulan Ini</span>
                <span class="card__badge">{{ count($jadwalKonselingMendatang ?? []) }} jadwal</span>
            </div>
            <div class="card__body">
                @forelse ($jadwalKonselingMendatang ?? [] as $jadwal)
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
                        <div class="jadwal-box__row" style="color:#888;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="jadwal-box__icon"><path d="M10 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.465 14.493a1.23 1.23 0 0 0 .41 1.412A9.957 9.957 0 0 0 10 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 0 0-13.074.003Z"/></svg>
                            <span>{{ $jadwal['siswa'] }}</span>
                        </div>
                        <a href="{{ route('guru.jadwal_konseling') }}" class="link">
                            Lihat Detail
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" style="width:12px;height:12px;"><path fill-rule="evenodd" d="M6.22 4.22a.75.75 0 0 1 1.06 0l3.25 3.25a.75.75 0 0 1 0 1.06l-3.25 3.25a.75.75 0 0 1-1.06-1.06L9.19 8 6.22 5.03a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
                        </a>
                    </div>
                @empty
                    <p style="font-size:13px;color:#888;">Belum ada jadwal konseling bulan ini.</p>
                @endforelse
            </div>
        </div>

    </div>{{-- end db-jadwal-stack --}}
</div>{{-- end db-bottom --}}

@endsection
