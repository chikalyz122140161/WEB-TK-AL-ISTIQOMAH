@extends('layouts.app')
@php $userRole = 'Orang Tua'; @endphp

@section('title', 'Jadwal - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Jadwal')

@section('sidebar')
    @include('orangtua.partials.sidebar')
@endsection

@push('styles')
<style>
    /* Tab Navigation */
    .tab-navigation {
        display: flex;
        gap: 0;
        margin-bottom: 24px;
        background: #fff;
        border-radius: 12px;
        padding: 6px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .tab-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 24px;
        font-size: 14px;
        font-weight: 600;
        color: #5D4037;
        background: transparent;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
    }
    .tab-btn:hover {
        background: #FFFDE7;
        color: #3E2723;
    }
    .tab-btn.active {
        background: linear-gradient(135deg, #3E2723 0%, #006b5a 100%);
        color: #fff;
    }
    .tab-btn svg {
        width: 20px;
        height: 20px;
    }
    .tab-btn.active svg {
        fill: #4CAF82;
    }

    /* Filter Bar */
    .filter-bar {
        display: flex;
        align-items: flex-end;
        gap: 12px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }
    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .filter-group label {
        font-size: 12px;
        font-weight: 500;
        color: #5D4037;
    }
    .filter-group select {
        padding: 10px 14px;
        border: 1px solid #3E272330;
        border-radius: 6px;
        font-size: 14px;
        color: #3E2723;
        background: #fff;
        min-width: 160px;
        cursor: pointer;
    }
    .filter-group select:focus {
        outline: none;
        border-color: #4CAF82;
        box-shadow: 0 0 0 3px rgba(76, 175, 130, 0.1);
    }
    .btn-tampilkan {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
        color: #3E2723;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        border-radius: 6px;
        transition: all 0.3s;
    }
    .btn-tampilkan:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(76,175,130, 0.3);
    }

    /* Info Banner */
    .info-banner {
        background: linear-gradient(135deg, #3E2723 0%, #006b5a 100%);
        border-radius: 12px;
        padding: 20px 24px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .info-banner__icon {
        width: 48px;
        height: 48px;
        background: rgba(76,175,130, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .info-banner__icon svg {
        width: 24px;
        height: 24px;
        fill: #4CAF82;
    }
    .info-banner__content h3 {
        color: #fff;
        font-size: 16px;
        margin: 0 0 4px 0;
    }
    .info-banner__content p {
        color: rgba(255,255,255,0.8);
        font-size: 13px;
        margin: 0;
    }

    /* Schedule Table - Pembelajaran */
    .schedule-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    .schedule-card__header {
        background: #FFFDE7;
        padding: 16px 20px;
        border-bottom: 1px solid #3E272320;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .schedule-card__day {
        font-size: 16px;
        font-weight: 700;
        color: #3E2723;
    }
    .schedule-card__badge {
        background: #4CAF82;
        color: #3E2723;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .schedule-table {
        width: 100%;
        border-collapse: collapse;
    }
    .schedule-table th,
    .schedule-table td {
        padding: 14px 20px;
        text-align: left;
        border-bottom: 1px solid #f0f0f0;
    }
    .schedule-table th {
        background: #fafbfc;
        font-size: 12px;
        font-weight: 600;
        color: #5D4037;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .schedule-table td {
        font-size: 14px;
        color: #3E2723;
    }
    .schedule-table tr:last-child td {
        border-bottom: none;
    }
    .schedule-table tr:hover td {
        background: #FFFDE7;
    }
    .time-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(0, 71, 62, 0.1);
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        color: #3E2723;
    }
    .time-badge svg {
        width: 14px;
        height: 14px;
        fill: #3E2723;
    }

    /* Kegiatan Cards */
    .kegiatan-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }
    .kegiatan-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: all 0.3s;
    }
    .kegiatan-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .kegiatan-card__header {
        background: linear-gradient(135deg, #3E2723 0%, #006b5a 100%);
        padding: 16px 20px;
    }
    .kegiatan-card__title {
        color: #fff;
        font-size: 16px;
        font-weight: 700;
        margin: 0;
    }
    .kegiatan-card__body {
        padding: 16px 20px;
    }
    .kegiatan-info {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .kegiatan-info__item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 13px;
        color: #5D4037;
    }
    .kegiatan-info__item svg {
        width: 18px;
        height: 18px;
        fill: #4CAF82;
        flex-shrink: 0;
        margin-top: 1px;
    }
    .kegiatan-info__item span {
        flex: 1;
    }
    .kegiatan-badge {
        display: inline-flex;
        align-items: center;
        background: rgba(76, 175, 130, 0.15);
        color: #d4920c;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 40px;
        color: #5D4037;
    }
    .empty-state svg {
        width: 64px;
        height: 64px;
        fill: #3E272330;
        margin-bottom: 16px;
    }
    .empty-state h3 {
        color: #3E2723;
        margin: 0 0 8px 0;
    }
    .empty-state p {
        margin: 0;
        font-size: 14px;
    }
</style>
@endpush

@section('content')

    {{-- Tab Navigation --}}
    <div class="tab-navigation">
        <a href="{{ route('orangtua.jadwal.pembelajaran') }}" class="tab-btn {{ ($activeTab ?? 'pembelajaran') == 'pembelajaran' ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 4.8 11.06a.75.75 0 0 1-.231-1.337A60.65 60.65 0 0 1 11.7 2.805Z"/><path d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.833 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286a48.45 48.45 0 0 1 7.667 3.282.75.75 0 0 0 1.12 0Z"/></svg>
            Jadwal Pembelajaran
        </a>
        <a href="{{ route('orangtua.jadwal.kegiatan') }}" class="tab-btn {{ ($activeTab ?? '') == 'kegiatan' ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd"/></svg>
            Jadwal Kegiatan
        </a>
    </div>

    @if(($activeTab ?? 'pembelajaran') == 'pembelajaran')
        {{-- JADWAL PEMBELAJARAN --}}
        
        {{-- Info Banner --}}
        <div class="info-banner">
            <div class="info-banner__icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 4.8 11.06a.75.75 0 0 1-.231-1.337A60.65 60.65 0 0 1 11.7 2.805Z"/></svg>
            </div>
            <div class="info-banner__content">
                <h3>Jadwal Pembelajaran {{ $student->name ?? 'Anak Anda' }}</h3>
                <p>Kelas: {{ $kelas ?? 'TK A' }} | Tahun Ajaran 2025/2026</p>
            </div>
        </div>

        {{-- Schedule per Hari --}}
        @forelse($jadwalPembelajaran ?? [] as $hari => $jadwal)
            <div class="schedule-card">
                <div class="schedule-card__header">
                    <span class="schedule-card__day">{{ $hari }}</span>
                    <span class="schedule-card__badge">{{ count($jadwal) }} Kegiatan</span>
                </div>
                <table class="schedule-table">
                    <thead>
                        <tr>
                            <th style="width: 180px;">Waktu</th>
                            <th>Kegiatan</th>
                            <th style="width: 200px;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jadwal as $item)
                        <tr>
                            <td>
                                <span class="time-badge">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z" clip-rule="evenodd"/></svg>
                                    {{ $item['waktu'] }}
                                </span>
                            </td>
                            <td><strong>{{ $item['kegiatan'] }}</strong></td>
                            <td>{{ $item['keterangan'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @empty
            <div class="schedule-card">
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd"/></svg>
                    <h3>Belum Ada Jadwal</h3>
                    <p>Jadwal pembelajaran belum tersedia.</p>
                </div>
            </div>
        @endforelse

    @else
        {{-- JADWAL KEGIATAN --}}
        
        {{-- Filter --}}
        <form action="{{ route('orangtua.jadwal.kegiatan') }}" method="GET" class="filter-bar">
            <div class="filter-group">
                <label>Pilih Bulan</label>
                <select name="bulan">
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ (request('bulan', now()->month) == $m) ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="filter-group">
                <label>Pilih Tahun</label>
                <select name="tahun">
                    @for ($y = now()->year; $y >= now()->year - 2; $y--)
                        <option value="{{ $y }}" {{ (request('tahun', now()->year) == $y) ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="btn-tampilkan">TAMPILKAN</button>
        </form>

        @php
            $bulan = request('bulan', now()->month);
            $tahun = request('tahun', now()->year);
            $namaBulan = \Carbon\Carbon::create()->month($bulan)->translatedFormat('F');
        @endphp

        {{-- Info Banner --}}
        <div class="info-banner">
            <div class="info-banner__icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
            </div>
            <div class="info-banner__content">
                <h3>Jadwal Kegiatan {{ $namaBulan }} {{ $tahun }}</h3>
                <p>Daftar kegiatan dan acara TK Al-Istiqomah</p>
            </div>
        </div>

        {{-- Kegiatan Grid --}}
        @if(!empty($jadwalKegiatan))
            <div class="kegiatan-grid">
                @foreach($jadwalKegiatan as $kegiatan)
                    <div class="kegiatan-card">
                        <div class="kegiatan-card__header">
                            <h3 class="kegiatan-card__title">{{ $kegiatan['nama'] }}</h3>
                        </div>
                        <div class="kegiatan-card__body">
                            <div class="kegiatan-info">
                                <div class="kegiatan-info__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd"/></svg>
                                    <span>{{ $kegiatan['tanggal'] }}</span>
                                </div>
                                <div class="kegiatan-info__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd"/></svg>
                                    <span>{{ $kegiatan['waktu'] }}</span>
                                </div>
                                <div class="kegiatan-info__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd"/></svg>
                                    <span>{{ $kegiatan['tempat'] }}</span>
                                </div>
                                <div class="kegiatan-info__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z" clip-rule="evenodd"/></svg>
                                    <span class="kegiatan-badge">{{ $kegiatan['kelas'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="schedule-card">
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
                    <h3>Belum Ada Kegiatan</h3>
                    <p>Tidak ada kegiatan untuk bulan {{ $namaBulan }} {{ $tahun }}.</p>
                </div>
            </div>
        @endif
    @endif

@endsection
