@extends('layouts.app')
@php $userRole = 'Orang Tua'; @endphp

@section('title', 'Detail Rapot - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Detail Rapot Semester')

@section('sidebar')
    @include('orangtua.partials.sidebar')
@endsection

@push('styles')
<style>
    .back-link {
        display: inline-flex; align-items: center; gap: 6px;
        color: #5D4037; font-size: 13px; font-weight: 500;
        margin-bottom: 14px; transition: color .15s; text-decoration: none;
    }
    .back-link:hover { color: #3D9B72; }
    .back-link svg { width: 14px; height: 14px; fill: currentColor; }

    /* Header banner */
    .rapot-banner {
        background: linear-gradient(135deg, #3D9B72 0%, #2E8B60 100%);
        border-radius: 14px;
        padding: 24px 28px;
        color: #fff;
        margin-bottom: 18px;
        position: relative;
        box-shadow: 0 4px 14px rgba(61,155,114,0.25);
    }
    .rapot-banner__title { font-size: 22px; font-weight: 700; margin: 0 0 6px; }
    .rapot-banner__ta    { font-size: 14px; opacity: 0.92; margin: 0 0 16px; }
    .rapot-banner__meta  { display: flex; flex-wrap: wrap; gap: 18px; font-size: 13px; }
    .rapot-banner__meta span { display: inline-flex; align-items: center; gap: 6px; }
    .rapot-banner__meta svg  { width: 14px; height: 14px; fill: rgba(255,255,255,0.85); }
    .rapot-banner__kelas {
        position: absolute; top: 22px; right: 26px;
        background: rgba(255,255,255,0.18);
        padding: 6px 14px; border-radius: 99px;
        font-size: 13px; font-weight: 600;
    }

    .btn-download {
        display: inline-flex; align-items: center; gap: 8px;
        background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
        color: #fff;
        padding: 11px 22px; font-size: 13px; font-weight: 600;
        border: none; border-radius: 8px; text-decoration: none;
        margin-bottom: 18px;
        box-shadow: 0 2px 8px rgba(61,155,114,0.25);
        transition: all .2s;
    }
    .btn-download:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(76,175,130,0.4); }
    .btn-download svg { width: 16px; height: 16px; fill: currentColor; }

    /* Section card */
    .section-card {
        background: #fff;
        border: 1px solid #e7e5e4;
        border-radius: 12px;
        margin-bottom: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .section-card__head {
        background: linear-gradient(135deg, #3D9B72 0%, #2E8B60 100%);
        padding: 14px 22px;
        display: flex; align-items: center; gap: 10px;
    }
    .section-card__head svg { width: 18px; height: 18px; fill: rgba(255,255,255,0.9); }
    .section-card__title { color: #fff; font-size: 15px; font-weight: 700; margin: 0; }
    .section-card__body { padding: 20px 22px; }

    /* Legend */
    .legend-bar {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        padding: 10px 16px;
        margin-bottom: 16px;
        display: flex; flex-wrap: wrap; gap: 18px;
        font-size: 12px; color: #3E2723;
    }
    .legend-bar span { display: inline-flex; align-items: center; gap: 6px; }
    .legend-dot { width: 10px; height: 10px; border-radius: 50%; }
    .ld-bb  { background: #d81b72; }
    .ld-mb  { background: #e6db00; }
    .ld-bsh { background: #4CAF82; }
    .ld-bsb { background: #2E8B60; }

    /* Mata Pelajaran card */
    .mapel-card {
        border: 1px solid #e7e5e4;
        border-radius: 10px;
        padding: 16px 18px;
        margin-bottom: 12px;
        background: #fafaf8;
    }
    .mapel-card:last-child { margin-bottom: 0; }
    .mapel-card__head {
        display: flex; align-items: center; gap: 10px;
        margin-bottom: 10px;
    }
    .mapel-card__num {
        width: 26px; height: 26px;
        background: linear-gradient(135deg, #4CAF82, #3D9B72);
        color: #fff; font-size: 12px; font-weight: 700;
        border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
    }
    .mapel-card__name { font-size: 14px; font-weight: 700; color: #3E2723; }
    .mapel-card__desc {
        font-size: 13.5px; color: #57534e; line-height: 1.6;
        background: #fff; padding: 12px 14px;
        border-radius: 8px;
        border: 1px solid #e7e5e4;
        margin-bottom: 10px;
    }
    .mapel-card__foto {
        margin-top: 8px;
    }
    .mapel-card__foto img {
        width: 100%; max-width: 380px;
        height: auto; border-radius: 8px;
        border: 1px solid #e7e5e4;
        display: block;
    }
    .mapel-card__foto-label {
        font-size: 11px; color: #6b7280;
        text-transform: uppercase; letter-spacing: 0.04em;
        margin-bottom: 6px; font-weight: 600;
    }

    /* Ekstrakurikuler & Konseling table */
    .group-box {
        border: 1px solid #e7e5e4; border-radius: 8px;
        margin-bottom: 12px; overflow: hidden;
    }
    .group-box:last-child { margin-bottom: 0; }
    .group-box__head {
        background: #f9fafb;
        padding: 10px 16px;
        font-size: 13px; font-weight: 600; color: #3E2723;
        display: flex; align-items: center; gap: 7px;
        border-bottom: 1px solid #e7e5e4;
    }
    .group-box__head svg { width: 14px; height: 14px; fill: #3D9B72; }
    .group-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .group-table td {
        padding: 10px 16px;
        border-bottom: 1px solid #f3f4f6;
        color: #3E2723;
    }
    .group-table tr:last-child td { border-bottom: none; }
    .group-table td:last-child { text-align: right; width: 100px; }

    .lv-badge {
        display: inline-block;
        font-size: 11px; font-weight: 700;
        padding: 3px 10px; border-radius: 4px;
        min-width: 40px; text-align: center;
    }
    .lv-bb  { background: rgba(240,98,146,0.12); color: #d81b72; }
    .lv-mb  { background: #FFF176; color: #5D4037; }
    .lv-bsh { background: rgba(76,175,130,0.15); color: #2E8B60; }
    .lv-bsb { background: rgba(76,175,130,0.28); color: #2E8B60; }

    /* Catatan & Kehadiran */
    .info-row {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 16px;
        margin-bottom: 16px;
    }
    @media (max-width: 768px) { .info-row { grid-template-columns: 1fr; } }

    .catatan-box {
        background: #f9fafb;
        border-left: 4px solid #3D9B72;
        padding: 14px 16px;
        border-radius: 6px;
        font-size: 13.5px; color: #3E2723; line-height: 1.6;
    }
    .catatan-box strong { color: #2E8B60; }

    .kehadiran-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
    }
    .kehadiran-item {
        background: #f9fafb;
        border: 1px solid #e7e5e4;
        border-radius: 8px;
        padding: 10px 8px;
        text-align: center;
    }
    .kehadiran-item__value {
        font-size: 20px; font-weight: 700; line-height: 1;
        color: #3E2723;
    }
    .kehadiran-item__label {
        font-size: 11px; color: #6b7280;
        margin-top: 4px;
    }
</style>
@endpush

@section('content')

<a href="{{ route('orangtua.rapot') }}" class="back-link">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M7.28 7.72a.75.75 0 0 1 0 1.06l-2.47 2.47H21a.75.75 0 0 1 0 1.5H4.81l2.47 2.47a.75.75 0 1 1-1.06 1.06l-3.75-3.75a.75.75 0 0 1 0-1.06l3.75-3.75a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/></svg>
    Kembali ke Daftar Rapot
</a>

{{-- Banner --}}
<div class="rapot-banner">
    <span class="rapot-banner__kelas">{{ $rapot['kelas'] }}</span>
    <h2 class="rapot-banner__title">Rapot Semester {{ $rapot['semester'] }}</h2>
    <p class="rapot-banner__ta">Tahun Ajaran {{ $rapot['tahun_ajaran'] }}</p>
    <div class="rapot-banner__meta">
        <span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2 7.5 4.019 7.5 6.5ZM20 21h1.5a.5.5 0 0 0 .5-.5C22 17.57 18.43 14 14.5 14h-5C5.57 14 2 17.57 2 20.5a.5.5 0 0 0 .5.5H20Z"/></svg>
            {{ $rapot['siswa']['nama'] }}
        </span>
        <span>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
            Terbit: {{ $rapot['tanggal_terbit'] }}
        </span>
    </div>
</div>

<a href="{{ route('orangtua.rapot.download', $rapot['id']) }}" class="btn-download">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2.25a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V3a.75.75 0 0 1 .75-.75Zm-9 13.5a.75.75 0 0 1 .75.75v2.25a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5V16.5a.75.75 0 0 1 1.5 0v2.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V16.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
    Download Rapot (PDF)
</a>

<div class="legend-bar">
    <span><span class="legend-dot ld-bb"></span> <strong>BB</strong> Belum Berkembang</span>
    <span><span class="legend-dot ld-mb"></span> <strong>MB</strong> Mulai Berkembang</span>
    <span><span class="legend-dot ld-bsh"></span> <strong>BSH</strong> Berkembang Sesuai Harapan</span>
    <span><span class="legend-dot ld-bsb"></span> <strong>BSB</strong> Berkembang Sangat Baik</span>
</div>

{{-- 1. Mata Pelajaran --}}
<div class="section-card">
    <div class="section-card__head">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z"/></svg>
        <h3 class="section-card__title">Mata Pelajaran</h3>
    </div>
    <div class="section-card__body">
        @forelse ($rapot['mata_pelajaran'] ?? [] as $i => $mp)
            <div class="mapel-card">
                <div class="mapel-card__head">
                    <span class="mapel-card__num">{{ $i + 1 }}</span>
                    <span class="mapel-card__name">{{ $mp['nama'] }}</span>
                </div>
                <div class="mapel-card__desc">
                    {{ $mp['deskripsi'] }}
                </div>
                @if (!empty($mp['foto']))
                    <div class="mapel-card__foto">
                        <div class="mapel-card__foto-label">Lampiran Foto</div>
                        <img src="{{ $mp['foto'] }}" alt="Foto {{ $mp['nama'] }}">
                    </div>
                @endif
            </div>
        @empty
            <p style="color:#9ca3af;font-style:italic;margin:0;">Belum ada data mata pelajaran.</p>
        @endforelse
    </div>
</div>

{{-- 2. Ekstrakurikuler --}}
<div class="section-card">
    <div class="section-card__head">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006Z" clip-rule="evenodd"/></svg>
        <h3 class="section-card__title">Ekstrakurikuler</h3>
    </div>
    <div class="section-card__body">
        @forelse ($rapot['ekstrakurikuler'] ?? [] as $ek)
            <div class="group-box">
                <div class="group-box__head">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd"/></svg>
                    {{ $ek['nama'] }}
                </div>
                <table class="group-table">
                    @foreach ($ek['assessments'] as $ca)
                        <tr>
                            <td>{{ $ca['nama'] }}</td>
                            <td>
                                @if (!empty($ca['level']))
                                    <span class="lv-badge lv-{{ strtolower($ca['level']) }}">{{ $ca['level'] }}</span>
                                @else
                                    <span style="color:#9ca3af;">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @empty
            <p style="color:#9ca3af;font-style:italic;margin:0;">Belum mengikuti ekstrakurikuler.</p>
        @endforelse
    </div>
</div>

{{-- 3. Catatan & Kehadiran --}}
<div class="info-row">
    <div class="section-card" style="margin-bottom:0;">
        <div class="section-card__head">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z"/></svg>
            <h3 class="section-card__title">Catatan Guru</h3>
        </div>
        <div class="section-card__body">
            <div class="catatan-box">{{ $rapot['catatan_guru'] ?? '-' }}</div>
            @if (!empty($rapot['rekomendasi']))
                <div class="catatan-box" style="margin-top:10px;border-left-color:#F59E0B;">
                    <strong>Rekomendasi:</strong> {{ $rapot['rekomendasi'] }}
                </div>
            @endif
        </div>
    </div>

    <div class="section-card" style="margin-bottom:0;">
        <div class="section-card__head">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd"/></svg>
            <h3 class="section-card__title">Kehadiran</h3>
        </div>
        <div class="section-card__body">
            @php $kehadiran = $rapot['kehadiran'] ?? ['hadir'=>0,'izin'=>0,'sakit'=>0,'alpa'=>0]; @endphp
            <div class="kehadiran-grid">
                <div class="kehadiran-item">
                    <div class="kehadiran-item__value" style="color:#2E8B60;">{{ $kehadiran['hadir'] }}</div>
                    <div class="kehadiran-item__label">Hadir</div>
                </div>
                <div class="kehadiran-item">
                    <div class="kehadiran-item__value" style="color:#5D4037;">{{ $kehadiran['izin'] }}</div>
                    <div class="kehadiran-item__label">Izin</div>
                </div>
                <div class="kehadiran-item">
                    <div class="kehadiran-item__value" style="color:#5D4037;">{{ $kehadiran['sakit'] }}</div>
                    <div class="kehadiran-item__label">Sakit</div>
                </div>
                <div class="kehadiran-item">
                    <div class="kehadiran-item__value" style="color:#d81b72;">{{ $kehadiran['alpa'] }}</div>
                    <div class="kehadiran-item__label">Alpa</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 4. Bimbingan Konseling (paling bawah) --}}
<div class="section-card">
    <div class="section-card__head">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M4.804 21.644A6.707 6.707 0 0 0 6 21.75a6.721 6.721 0 0 0 3.583-1.029c.774.182 1.584.279 2.417.279 5.322 0 9.75-3.97 9.75-9 0-5.03-4.428-9-9.75-9s-9.75 3.97-9.75 9c0 2.09.768 4.04 2.084 5.558a8.96 8.96 0 0 1-1.603 2.596.75.75 0 0 0 .53 1.28 6.72 6.72 0 0 0 1.543-.09Z" clip-rule="evenodd"/></svg>
        <h3 class="section-card__title">Bimbingan Konseling</h3>
    </div>
    <div class="section-card__body">
        <p style="font-size:12px;color:#6b7280;margin:0 0 14px;font-style:italic;">
            Capaian dari hasil input perkembangan mingguan oleh guru selama semester berjalan.
        </p>
        @forelse ($rapot['konseling'] ?? [] as $kon)
            <div class="group-box">
                <div class="group-box__head">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd"/></svg>
                    {{ $kon['nama'] }}
                </div>
                <table class="group-table">
                    @foreach ($kon['assessments'] as $ca)
                        <tr>
                            <td>{{ $ca['nama'] }}</td>
                            <td>
                                @if (!empty($ca['level']))
                                    <span class="lv-badge lv-{{ strtolower($ca['level']) }}">{{ $ca['level'] }}</span>
                                @else
                                    <span style="color:#9ca3af;">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @empty
            <p style="color:#9ca3af;font-style:italic;margin:0;">Belum ada data konseling.</p>
        @endforelse
    </div>
</div>

@endsection
