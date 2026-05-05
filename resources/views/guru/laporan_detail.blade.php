@extends('layouts.app')

@section('title', 'Detail Laporan Perkembangan - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Detail Laporan Perkembangan')

@push('styles')
<style>
    .ld-back {
        display: inline-flex; align-items: center; gap: 6px;
        color: #3E2723; font-size: 13px; font-weight: 500;
        text-decoration: none; margin-bottom: 14px;
        transition: color .15s;
    }
    .ld-back:hover { color: #3D9B72; }
    .ld-back svg { width: 14px; height: 14px; fill: currentColor; }

    .ld-banner {
        background: linear-gradient(135deg, #3D9B72 0%, #2E8B60 100%);
        border-radius: 14px;
        padding: 22px 26px;
        color: #fff;
        margin-bottom: 16px;
        box-shadow: 0 3px 10px rgba(61,155,114,0.25);
    }
    .ld-banner__title { font-size: 18px; font-weight: 700; margin: 0 0 12px; }
    .ld-banner__meta {
        display: flex; flex-wrap: wrap; gap: 18px;
        font-size: 13px; opacity: 0.95;
    }
    .ld-banner__meta span { display: inline-flex; align-items: center; gap: 6px; }
    .ld-banner__meta svg { width: 14px; height: 14px; fill: rgba(255,255,255,0.85); }

    .ld-avg {
        background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
        border-radius: 12px;
        padding: 18px 22px;
        margin-bottom: 18px;
        color: #fff;
        display: flex; justify-content: space-between; align-items: center;
        box-shadow: 0 2px 8px rgba(61,155,114,0.22);
    }
    .ld-avg__title { font-size: 14px; font-weight: 600; margin: 0; }
    .ld-avg__sub   { font-size: 11px; opacity: 0.85; margin-top: 3px; }
    .ld-avg__value { font-size: 36px; font-weight: 800; line-height: 1; }

    .ld-section-title {
        font-size: 13px; font-weight: 700;
        color: #3E2723; text-transform: uppercase; letter-spacing: .04em;
        margin: 0 0 12px;
        padding-bottom: 6px;
        border-bottom: 2px solid #3D9B72;
        display: inline-block;
    }

    .ld-konseling {
        background: #fff;
        border: 1px solid #e7e5e4;
        border-radius: 12px;
        margin-bottom: 14px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .ld-konseling__head {
        background: #f9fafb;
        padding: 12px 18px;
        border-bottom: 1px solid #e7e5e4;
        display: flex; align-items: center; justify-content: space-between;
        gap: 10px;
    }
    .ld-konseling__title {
        font-size: 14px; font-weight: 700; color: #3E2723;
        display: inline-flex; align-items: center; gap: 8px;
        margin: 0;
    }
    .ld-konseling__title svg { width: 16px; height: 16px; fill: #3D9B72; }
    .ld-konseling__meta {
        display: flex; gap: 8px; align-items: center;
        font-size: 11px; color: #6b7280;
    }
    .ld-konseling__avg {
        background: #ecfdf5; color: #065f46;
        padding: 3px 10px; border-radius: 99px;
        font-weight: 700; font-size: 11px;
        border: 1px solid #a7f3d0;
    }

    .ld-items { padding: 0; }
    .ld-item {
        padding: 12px 18px;
        border-bottom: 1px solid #f3f4f6;
        display: flex; align-items: center; justify-content: space-between;
        gap: 14px;
    }
    .ld-item:last-child { border-bottom: none; }
    .ld-item__label { font-size: 13px; color: #3E2723; flex: 1; }
    .ld-item__score { display: inline-flex; align-items: center; gap: 10px; }

    .ld-bar {
        width: 110px; height: 6px;
        background: #f3f4f6; border-radius: 99px; overflow: hidden;
    }
    .ld-bar__fill { height: 100%; border-radius: 99px; transition: width .35s; }
    .ld-bar--bb  .ld-bar__fill { background: #f87171; }
    .ld-bar--mb  .ld-bar__fill { background: #facc15; }
    .ld-bar--bsh .ld-bar__fill { background: #4ade80; }
    .ld-bar--bsb .ld-bar__fill { background: #22c55e; }

    .ld-badge {
        display: inline-block;
        font-size: 10px; font-weight: 700;
        padding: 3px 9px; border-radius: 4px;
        min-width: 36px; text-align: center;
    }
    .ld-badge--bb  { background: #fee2e2; color: #b91c1c; }
    .ld-badge--mb  { background: #fef3c7; color: #92400e; }
    .ld-badge--bsh { background: #dcfce7; color: #166534; }
    .ld-badge--bsb { background: #bbf7d0; color: #14532d; }
    .ld-badge--none{ background: #f3f4f6; color: #9ca3af; }

    .ld-skala {
        background: #fff;
        border: 1px solid #e7e5e4;
        border-radius: 10px;
        padding: 12px 18px;
        margin-top: 14px;
        font-size: 12px;
    }
    .ld-skala__title {
        font-size: 11px; font-weight: 700;
        color: #3E2723; text-transform: uppercase;
        letter-spacing: .04em; margin: 0 0 8px;
    }
    .ld-skala__list {
        list-style: none; margin: 0; padding: 0;
        display: flex; flex-wrap: wrap; gap: 14px;
    }
    .ld-skala__list li {
        display: inline-flex; align-items: center; gap: 6px;
        color: #57534e;
    }
    .ld-skala__dot { width: 10px; height: 10px; border-radius: 50%; }
</style>
@endpush

@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

@section('content')
    <a href="{{ route('guru.laporan_bk') }}" class="ld-back">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M7.28 7.72a.75.75 0 0 1 0 1.06l-2.47 2.47H21a.75.75 0 0 1 0 1.5H4.81l2.47 2.47a.75.75 0 1 1-1.06 1.06l-3.75-3.75a.75.75 0 0 1 0-1.06l3.75-3.75a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/></svg>
        Kembali ke Daftar Laporan
    </a>

    <div class="ld-banner">
        <h2 class="ld-banner__title">Laporan Perkembangan Mingguan</h2>
        <div class="ld-banner__meta">
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2 7.5 4.019 7.5 6.5ZM20 21h1.5a.5.5 0 0 0 .5-.5C22 17.57 18.43 14 14.5 14h-5C5.57 14 2 17.57 2 20.5a.5.5 0 0 0 .5.5H20Z"/></svg>
                {{ $laporan['siswa_nama'] }} — Kelas {{ $laporan['kelas'] }}
            </span>
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
                Minggu {{ $laporan['minggu'] }} — {{ $laporan['tanggal_label'] }}
            </span>
            <span>{{ $laporan['semester'] }}</span>
        </div>
    </div>

    <div class="ld-avg">
        <div>
            <h3 class="ld-avg__title">Rata-rata Nilai Perkembangan</h3>
            <p class="ld-avg__sub">BB / MB / BSH / BSB</p>
        </div>
        <div class="ld-avg__value">{{ number_format($laporan['rata_rata'], 1) }}</div>
    </div>

    <h3 class="ld-section-title">Capaian per Konseling</h3>

    @forelse ($laporan['konselings'] as $kon)
        <div class="ld-konseling">
            <div class="ld-konseling__head">
                <h4 class="ld-konseling__title">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd"/></svg>
                    {{ $kon['nama'] }}
                </h4>
                <div class="ld-konseling__meta">
                    <span>{{ $kon['count'] }} poin penilaian</span>
                    <span class="ld-konseling__avg">Rata: {{ number_format($kon['avg'], 1) }}</span>
                </div>
            </div>
            <div class="ld-items">
                @foreach ($kon['items'] as $item)
                    @php
                        $kode = $item['kode'];
                        $level = $item['level'];
                        $pct = $level !== null ? ($level / 4) * 100 : 0;
                        $barCls = $level !== null ? 'ld-bar--' . strtolower($kode) : '';
                        $badgeCls = $level !== null ? 'ld-badge--' . strtolower($kode) : 'ld-badge--none';
                    @endphp
                    <div class="ld-item">
                        <div class="ld-item__label">{{ $item['nama'] }}</div>
                        <div class="ld-item__score">
                            <div class="ld-bar {{ $barCls }}">
                                <div class="ld-bar__fill" style="width: {{ $pct }}%"></div>
                            </div>
                            <span class="ld-badge {{ $badgeCls }}">{{ $kode }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <p style="color:#9ca3af;font-style:italic;">Belum ada data konseling untuk laporan ini.</p>
    @endforelse

    <div class="ld-skala">
        <p class="ld-skala__title">Keterangan Skala</p>
        <ul class="ld-skala__list">
            <li><span class="ld-skala__dot" style="background:#f87171"></span> <strong>BB</strong> — Belum Berkembang</li>
            <li><span class="ld-skala__dot" style="background:#facc15"></span> <strong>MB</strong> — Mulai Berkembang</li>
            <li><span class="ld-skala__dot" style="background:#4ade80"></span> <strong>BSH</strong> — Berkembang Sesuai Harapan</li>
            <li><span class="ld-skala__dot" style="background:#22c55e"></span> <strong>BSB</strong> — Berkembang Sangat Baik</li>
        </ul>
    </div>

@endsection
