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
            background: rgba(76, 175, 130, 0.06);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(76, 175, 130, 0.25);
            border-radius: 20px;
            padding: 18px 30px;
            margin-bottom: 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            color: #2E8B60;
            box-shadow: 0 4px 20px rgba(62, 39, 35, 0.015);
        }

        .db-hero__left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .db-hero__av {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #3D9B72;
            border: 2px solid #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 800;
            color: #ffffff;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(61, 155, 114, 0.2);
        }

        .db-hero__title {
            font-size: 19px;
            font-weight: 700;
            margin: 0 0 3px;
        }

        .db-hero__sub {
            font-size: 13px;
            color: #5d6b64;
            font-weight: 400;
            margin: 0;
        }

        .db-hero__pills {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .db-hero__pill {
            background: #ffffff;
            border: 1px solid rgba(61, 155, 114, 0.15);
            border-radius: 20px;
            padding: 6px 14px;
            font-size: 12px;
            font-weight: 600;
            color: #3D9B72;
            display: flex;
            align-items: center;
            gap: 5px;
            box-shadow: 0 2px 6px rgba(61, 155, 114, 0.05);
        }

        .db-hero__pill svg {
            width: 13px;
            height: 13px;
            fill: currentColor;
            flex-shrink: 0;
        }

        @media (max-width: 768px) {
            .db-hero {
                flex-direction: column;
                align-items: flex-start;
            }

            .db-hero__pills {
                justify-content: flex-start;
            }
        }

        /* ─── Stat Row ─── */
        .db-stat-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            margin-bottom: 24px;
        }

        @media (max-width: 1024px) {
            .db-stat-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .db-stat-row {
                grid-template-columns: 1fr;
            }
        }

        .dbs-label {
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .82);
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 4px;
        }

        .dbs-label svg {
            width: 13px;
            height: 13px;
            fill: currentColor;
            flex-shrink: 0;
        }

        .dbs-label--dark {
            color: rgba(62, 39, 35, .6);
        }

        .dbs-val {
            font-size: 40px;
            font-weight: 800;
            color: #fff;
            line-height: 1.1;
            margin-bottom: 3px;
        }

        .dbs-val--dark {
            color: #3E2723;
        }

        .dbs-sub {
            font-size: 12px;
            color: rgba(255, 255, 255, .75);
        }

        .dbs-sub--dark {
            color: rgba(62, 39, 35, .55);
        }

        /* ─── Green Card ─── */
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

        .dbs-green__values {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 16px;
        }

        .dbs-green__values>div:last-child {
            text-align: right;
        }

        .dbs-green__bar-wrap {
            background: rgba(255, 255, 255, .25);
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

        .dbs-green__bar-label {
            font-size: 11px;
            color: rgba(255, 255, 255, .75);
        }

        /* ─── Yellow Card ─── */
        .dbs-yellow {
            background: #FFF176;
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .dbs-yellow__item {
            padding: 18px 22px;
            flex: 1;
        }

        .dbs-sep {
            height: 1px;
            background: transparent;
            border-top: 2px dashed rgba(62, 39, 35, 0.12);
            margin: 0 24px;
        }

        /* ─── Pink Card ─── */
        .dbs-pink {
            background: #F06292;
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            flex-direction: row;
        }

        .dbs-pink__item {
            padding: 18px 22px;
            flex: 1;
        }

        .dbs-sep--light {
            background: rgba(255, 255, 255, 0.42);
            margin: 0;
            height: 140px;
            width: 1px;
        }

        /* ─── Bottom Grid ─── */
        .db-bottom {
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
            align-items: start;
        }

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
            box-shadow: 0 6px 18px rgba(61, 155, 114, 0.12);
        }

        .qa-card__icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #4CAF8222, #3D9B7222);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qa-card__icon svg {
            width: 22px;
            height: 22px;
            fill: #4CAF82;
        }

        .qa-card__title {
            font-size: 13px;
            font-weight: 600;
            color: #3E2723;
        }

        .qa-card__desc {
            font-size: 11px;
            color: #5D4037;
        }

        .db-right-stack>.card+.card {
            margin-top: 14px;
        }
    </style>
@endpush

@section('content')

    @php
        $hadir = $hadirBulanIni ?? 0;
    @endphp

    {{-- ═══════════ HERO BANNER ═══════════ --}}
    <div class="db-hero">
        <div class="db-hero__left">
            <div class="db-hero__av">{{ substr($namaAnak ?? '-', 0, 1) }}</div>
            <div>
                <p class="db-hero__title">{{ $namaAnak ?? '-' }}</p>
                <p class="db-hero__sub">Kelas: {{ $kelasAnak ?? '-' }} &nbsp;&middot;&nbsp; {{ $tahunAjaran ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- ═══════════ STAT CARDS ═══════════ --}}
    <div class="db-stat-row">

        {{-- GREEN: Kehadiran --}}
        <div class="dbs-green" style="display:flex;flex-direction:column;justify-content:center;">
            <div class="dbs-label">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                        clip-rule="evenodd" />
                </svg>
                Hadir Bulan Ini
            </div>
            <div class="dbs-val">{{ $hadir }}</div>
            <div class="dbs-sub">Hari hadir</div>
        </div>

        {{-- YELLOW: Report Tersedia --}}
        <div class="dbs-yellow">
            <div class="dbs-yellow__item" style="display:flex;flex-direction:column;justify-content:center;">
                <div class="dbs-label dbs-label--dark">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z"
                            clip-rule="evenodd" />
                        <path
                            d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                    </svg>
                    Report Tersedia
                </div>
                <div class="dbs-val dbs-val--dark">{{ $totalReport ?? 0 }}</div>
                <div class="dbs-sub dbs-sub--dark">Laporan perkembangan</div>
            </div>
        </div>

        {{-- PINK: Konseling Mendatang + Menunggu --}}
        <div class="dbs-pink">
            <div class="dbs-pink__item">
                <div class="dbs-label">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                            clip-rule="evenodd" />
                    </svg>
                    Konseling Mendatang
                </div>
                <div class="dbs-val">{{ $konselingMendatang ?? 0 }}</div>
                <div class="dbs-sub">Sesi disetujui</div>
            </div>
            <div class="dbs-sep dbs-sep--light"></div>
            <div class="dbs-pink__item">
                <div class="dbs-label">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z"
                            clip-rule="evenodd" />
                    </svg>
                    Menunggu Persetujuan
                </div>
                <div class="dbs-val">{{ $konselingPending ?? 0 }}</div>
                <div class="dbs-sub">Pengajuan konseling</div>
            </div>
        </div>

    </div>

    {{-- ═══════════ BOTTOM: AKSES CEPAT ═══════════ --}}
    <div class="db-bottom">

        {{-- Akses Cepat --}}
        <div class="card">
            <div class="card__header">
                <span class="card__title">Akses Cepat</span>
                <span class="card__badge">Menu utama</span>
            </div>
            <div class="card__body">
                <div class="quick-actions">
                    <a href="{{ route('orangtua.presensi') }}" class="qa-card">
                        <div class="qa-card__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h3A1.5 1.5 0 0 0 13.5 3ZM3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="qa-card__title">Lihat Presensi</div>
                        <div class="qa-card__desc">Cek kehadiran anak</div>
                    </a>

                    <a href="{{ route('orangtua.laporan') }}" class="qa-card">
                        <div class="qa-card__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z"
                                    clip-rule="evenodd" />
                                <path
                                    d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                            </svg>
                        </div>
                        <div class="qa-card__title">Lihat Laporan</div>
                        <div class="qa-card__desc">Laporan perkembangan anak</div>
                    </a>

                    <a href="{{ route('orangtua.jadwal') }}" class="qa-card">
                        <div class="qa-card__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="qa-card__title">Lihat Jadwal</div>
                        <div class="qa-card__desc">Jadwal kegiatan sekolah</div>
                    </a>

                    <a href="{{ route('orangtua.konseling') }}" class="qa-card">
                        <div class="qa-card__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M4.804 21.644A6.707 6.707 0 0 0 6 21.75a6.721 6.721 0 0 0 3.583-1.029c.774.182 1.584.279 2.417.279 5.322 0 9.75-3.97 9.75-9 0-5.03-4.428-9-9.75-9s-9.75 3.97-9.75 9c0 2.09.768 4.04 2.084 5.558a8.96 8.96 0 0 1-1.603 2.596.75.75 0 0 0 .53 1.28 6.72 6.72 0 0 0 1.543-.09Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="qa-card__title">Konseling</div>
                        <div class="qa-card__desc">Jadwal & pengajuan</div>
                    </a>
                </div>
            </div>
        </div>

    </div>{{-- end db-bottom --}}

@endsection
