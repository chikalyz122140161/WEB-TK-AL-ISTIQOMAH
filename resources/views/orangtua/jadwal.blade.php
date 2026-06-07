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
        .tab-label {
            font-size: 12px;
            font-weight: 500;
            color: #5D4037;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .tab-navigation {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
            border-radius: 12px;
            padding: 6px;

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
            color: #3D9B72;
            background: rgba(76, 175, 130, 0.08);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }

        .tab-btn:hover {
            background: rgba(76, 175, 130, 0.08);
            color: #2E8B60;
        }

        .tab-btn.active {
            background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
            color: #fff;
            box-shadow: 0 2px 8px rgba(76, 175, 130, 0.35);
        }

        .tab-btn--kegiatan {
            color: #d81b72;
            background: linear-gradient(135deg, #f0629116 0%, #e435870f 100%);
            box-shadow: 0 2px 8px rgba(240, 98, 145, 0.186);
        }

        .tab-btn--kegiatan:hover {
            color: #d81b72;
            background: linear-gradient(135deg, #f0629120 0%, #d81b730a 100%);
            box-shadow: 0 2px 8px rgba(240, 98, 146, 0.35);
        }

        .tab-btn--kegiatan svg {
            fill: #d81b72;
        }

        .tab-btn--kegiatan.active {
            background: linear-gradient(135deg, #e43885 0%, #d81b72 100%);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(216, 27, 114, 0.2);
        }

        .tab-btn svg {
            width: 18px;
            height: 18px;
        }

        .tab-btn.active svg {
            fill: #fff;
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
            background: linear-gradient(135deg, #3D9B72 0%, #2E8B60 100%);
            color: #fff;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(61, 155, 114, 0.25);
            transition: all 0.2s;
        }

        .btn-tampilkan:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(76, 175, 130, 0.3);
        }

        /* Info Banner */
        .info-banner {
            border-radius: 12px;
            padding: 20px 24px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .info-banner--green {
            background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
            box-shadow: 0 4px 14px rgba(76, 175, 130, 0.3);
        }

        .info-banner--pink {
            background: linear-gradient(135deg, #F06292 0%, #d81b72 100%);
            box-shadow: 0 4px 14px rgba(240, 98, 146, 0.3);
        }

        .info-banner__icon {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .info-banner__icon svg {
            width: 24px;
            height: 24px;
            fill: #fff;
        }

        .info-banner__content h3 {
            color: #fff;
            font-size: 16px;
            margin: 0 0 4px 0;
        }

        .info-banner__content p {
            color: rgba(255, 255, 255, 0.85);
            font-size: 13px;
            margin: 0;
        }

        /* Schedule Table - Pembelajaran */
        .schedule-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .schedule-card__header {
            background: linear-gradient(135deg, #3D9B72 0%, #2E8B60 100%);
            padding: 16px 20px;
            border-bottom: none;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .schedule-card__day {
            font-size: 16px;
            font-weight: 700;
            color: #fff;
        }

        .schedule-card__badge {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
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
            background: rgba(61, 155, 114, 0.12);
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            color: #2E8B60;
        }

        .time-badge svg {
            width: 14px;
            height: 14px;
            fill: #2E8B60;
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
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        .kegiatan-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .kegiatan-card__header {
            padding: 16px 20px;
        }

        /* Tiga varian warna header card */
        .kegiatan-card__header--green {
            background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
        }

        .kegiatan-card__header--yellow {
            background: #FFF176;
            border-bottom: 1px solid #e6db00;
        }

        .kegiatan-card__header--pink {
            background: linear-gradient(135deg, #F06292 0%, #d81b72 100%);
        }

        .kegiatan-card__title {
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            margin: 0;
        }

        .kegiatan-card__header--yellow .kegiatan-card__title {
            color: #3E2723;
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

        .kegiatan-card__header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .jadwal-item {
            padding: 10px 0;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .jadwal-item--border {
            border-bottom: 1px solid #f0f0f0;
        }

        .jadwal-item__waktu {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            color: #4CAF82;
            font-weight: 600;
            fill: #4CAF82;
        }

        .jadwal-item__kegiatan {
            font-size: 14px;
            font-weight: 600;
            color: #3E2723;
        }

        .jadwal-item__ket {
            font-size: 12px;
            color: #795548;
        }

        .kegiatan-badge {
            display: inline-flex;
            align-items: center;
            background: rgba(76, 175, 130, 0.12);
            color: #2E8B60;
            border: 1px solid rgba(76, 175, 130, 0.3);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
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

        .empty-state p span {
            color: #d81b72;
        }
    </style>
@endpush

@section('content')

    @if (($activeTab ?? 'pembelajaran') == 'pembelajaran')
        {{-- Info Banner --}}
        <div class="info-banner info-banner--green">
            <div class="info-banner__icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path
                        d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 4.8 11.06a.75.75 0 0 1-.231-1.337A60.65 60.65 0 0 1 11.7 2.805Z" />
                    <path
                        d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.833 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286a48.45 48.45 0 0 1 7.667 3.282.75.75 0 0 0 1.12 0Z" />
                </svg>
            </div>
            <div class="info-banner__content">
                <h3>Jadwal Pembelajaran {{ $student?->name ?? 'Anak Anda' }}</h3>
                <p>Kelas: {{ $kelas ?? ($student['class'] ?? '-') }} | Tahun Ajaran 2025/2026</p>
            </div>
        </div>
    @else
        @php
            $namaBulan = \Carbon\Carbon::create()
                ->month($bulan ?? now()->month)
                ->translatedFormat('F');
        @endphp
        {{-- Info Banner --}}
        <div class="info-banner info-banner--pink">
            <div class="info-banner__icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="info-banner__content">
                <h3>Jadwal Kegiatan {{ $namaBulan }} {{ $tahun }}</h3>
                <p>Daftar kegiatan dan acara TK Al-Istiqomah</p>
            </div>
        </div>
    @endif

    {{-- Class Term Selector --}}
    @if (!empty($classTerms))
        <form method="GET"
            action="{{ ($activeTab ?? 'pembelajaran') == 'pembelajaran' ? route('orangtua.jadwal.pembelajaran') : route('orangtua.jadwal.kegiatan') }}"
            class="filter-bar" style="margin-bottom:20px;">
            <div class="filter-group">
                <label>Pilih Kelas</label>
                <select name="class_term_id" onchange="this.form.submit()">
                    @foreach ($classTerms as $ct)
                        <option value="{{ $ct['id'] }}" {{ $classTermId === $ct['id'] ? 'selected' : '' }}>
                            {{ $ct['label'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            @if (($activeTab ?? '') === 'kegiatan')
                <div class="filter-group">
                    <label>Pilih Bulan</label>
                    <select name="bulan">
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ ($bulan ?? now()->month) == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <button type="submit" class="btn-tampilkan">TAMPILKAN</button>
            @endif
        </form>
    @endif

    {{-- Tab Navigation --}}
    <label class="tab-label">Pilih Jadwal</label>
    <div class="tab-navigation">
        <a href="{{ route('orangtua.jadwal.pembelajaran', ['class_term_id' => $classTermId ?? '']) }}"
            class="tab-btn tab-btn--pembelajaran {{ ($activeTab ?? 'pembelajaran') == 'pembelajaran' ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path
                    d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 4.8 11.06a.75.75 0 0 1-.231-1.337A60.65 60.65 0 0 1 11.7 2.805Z" />
                <path
                    d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.833 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286a48.45 48.45 0 0 1 7.667 3.282.75.75 0 0 0 1.12 0Z" />
            </svg>
            Jadwal Pembelajaran
        </a>
        <a href="{{ route('orangtua.jadwal.kegiatan', ['class_term_id' => $classTermId ?? '']) }}"
            class="tab-btn tab-btn--kegiatan {{ ($activeTab ?? '') == 'kegiatan' ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z"
                    clip-rule="evenodd" />
            </svg>
            Jadwal Kegiatan
        </a>
    </div>

    @if (($activeTab ?? 'pembelajaran') == 'pembelajaran')
        {{-- JADWAL PEMBELAJARAN --}}

        {{-- Satu card per hari --}}
        @php
            $cardColors = ['green', 'yellow', 'pink'];
            $ci = 0;
        @endphp
        <div class="kegiatan-grid">
            @forelse($jadwalPembelajaran ?? [] as $hari => $jadwal)
                @php
                    $cc = $cardColors[$ci % 3];
                    $ci++;
                @endphp
                <div class="kegiatan-card">
                    <div class="kegiatan-card__header kegiatan-card__header--{{ $cc }}">
                        <h3 class="kegiatan-card__title">{{ $hari }}</h3>
                        <span
                            style="color:{{ $cc === 'yellow' ? 'rgba(62,39,35,0.6)' : 'rgba(255,255,255,0.75)' }}; font-size:12px;">{{ count($jadwal) }}
                            kegiatan</span>
                    </div>
                    <div class="kegiatan-card__body">
                        @foreach ($jadwal as $item)
                            <div class="jadwal-item {{ !$loop->last ? 'jadwal-item--border' : '' }}">
                                <div class="jadwal-item__waktu">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        width="14" height="14">
                                        <path fill-rule="evenodd"
                                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $item['waktu'] }}
                                </div>
                                <div class="jadwal-item__kegiatan">{{ $item['kegiatan'] }}</div>
                                @if ($item['keterangan'] && $item['keterangan'] !== '-')
                                    <div class="jadwal-item__ket">{{ $item['keterangan'] }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="schedule-card" style="grid-column: 1 / -1;">
                    <div class="empty-state">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z"
                                clip-rule="evenodd" />
                        </svg>
                        <h3>Belum Ada Jadwal</h3>
                        <p>Jadwal pembelajaran belum tersedia.</p>
                    </div>
                </div>
            @endforelse
        </div>{{-- end kegiatan-grid --}}
    @else
        {{-- JADWAL KEGIATAN --}}

        @php
            $namaBulan = \Carbon\Carbon::create()
                ->month($bulan ?? now()->month)
                ->translatedFormat('F');
        @endphp


        {{-- Kegiatan Grid --}}
        @if (!empty($jadwalKegiatan))
            @php
                $cardColors = ['green', 'yellow', 'pink'];
                $ki = 0;
            @endphp
            <div class="kegiatan-grid">
                @foreach ($jadwalKegiatan as $kegiatan)
                    @php
                        $kc = $cardColors[$ki % 3];
                        $ki++;
                    @endphp
                    <div class="kegiatan-card">
                        <div class="kegiatan-card__header kegiatan-card__header--{{ $kc }}">
                            <h3 class="kegiatan-card__title">{{ $kegiatan['nama'] }}</h3>
                        </div>
                        <div class="kegiatan-card__body">
                            <div class="kegiatan-info">
                                <div class="kegiatan-info__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ $kegiatan['tanggal'] }}</span>
                                </div>
                                <div class="kegiatan-info__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ $kegiatan['waktu'] }}</span>
                                </div>
                                <div class="kegiatan-info__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ $kegiatan['tempat'] }}</span>
                                </div>
                                @if (!empty($kegiatan['deskripsi']))
                                    <div class="kegiatan-info__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M4.848 2.771A49.144 49.144 0 0 1 12 2.25c2.43 0 4.817.178 7.152.52 1.978.292 3.348 2.024 3.348 3.97v6.02c0 1.946-1.37 3.678-3.348 3.97a48.901 48.901 0 0 1-3.476.383.39.39 0 0 0-.297.17l-2.755 4.133a.75.75 0 0 1-1.248 0l-2.755-4.133a.39.39 0 0 0-.297-.17 48.9 48.9 0 0 1-3.476-.384c-1.978-.29-3.348-2.024-3.348-3.97V6.741c0-1.946 1.37-3.68 3.348-3.97Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span>{{ $kegiatan['deskripsi'] }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="schedule-card">
                <div class="empty-state">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Z"
                            clip-rule="evenodd" />
                    </svg>
                    <h3>Belum Ada Kegiatan</h3>
                    <p>Tidak ada kegiatan untuk bulan <span class="">{{ $namaBulan }} {{ $tahun }}</span>.</p>
                </div>
            </div>
        @endif
    @endif

@endsection
