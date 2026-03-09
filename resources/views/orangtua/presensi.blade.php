@extends('layouts.app')
@php $userRole = 'Orang Tua'; @endphp

@section('title', 'Lihat Presensi Anak - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Lihat Presensi Anak')

@section('sidebar')
    @include('orangtua.partials.sidebar')
@endsection

@push('styles')
<style>
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

    /* Stat Cards */
    .stat-row-5 {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    @media (max-width: 1024px) {
        .stat-row-5 { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 768px) {
        .stat-row-5 { grid-template-columns: repeat(2, 1fr); }
    }
    .presensi-stat {
        background: #fff;
        border: 1px solid #3E272320;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
    }
    .presensi-stat__value {
        font-size: 32px;
        font-weight: 700;
        color: #3E2723;
        line-height: 1;
    }
    .presensi-stat__value--green { color: #047857; }
    .presensi-stat__value--amber { color: #5D4037; }
    .presensi-stat__value--blue { color: #2E8B60; }
    .presensi-stat__value--red { color: #c0392b; }
    .presensi-stat__value--teal { color: #3E2723; }
    .presensi-stat__label {
        font-size: 13px;
        color: #5D4037;
        margin-top: 6px;
    }

    /* Detail Section */
    .detail-section {
        background: #fff;
        border: 1px solid #3E272320;
        border-radius: 8px;
        overflow: hidden;
    }
    .detail-section__header {
        padding: 16px 20px;
        border-bottom: 1px solid #3E272310;
        font-size: 14px;
        font-weight: 600;
        color: #3E2723;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    .data-table th,
    .data-table td {
        padding: 12px 16px;
        text-align: left;
        border-bottom: 1px solid #3E272310;
    }
    .data-table th {
        background: linear-gradient(135deg, #4CAF8220 0%, #4CAF8230 100%);
        font-size: 12px;
        font-weight: 600;
        color: #3E2723;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .data-table td {
        font-size: 14px;
        color: #5D4037;
    }
    .data-table tr:hover td {
        background: #FFFDE7;
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .status-badge--hadir {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #047857;
    }
    .status-badge--izin {
        background: #FFF176;
        color: #5D4037;
    }
    .status-badge--sakit {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #2E8B60;
    }
    .status-badge--alpa {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #c0392b;
    }
    .empty-state {
        text-align: center;
        padding: 40px;
        color: #5D4037;
        font-size: 14px;
    }
</style>
@endpush

@section('content')

    {{-- Filter --}}
    <form action="{{ route('orangtua.presensi') }}" method="GET" class="filter-bar">
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

    {{-- Statistik Presensi --}}
    @php
        $bulan = request('bulan', now()->month);
        $tahun = request('tahun', now()->year);
        $namaBulan = \Carbon\Carbon::create()->month($bulan)->translatedFormat('F');

        $hadir = $presensiData['hadir'] ?? 18;
        $izin = $presensiData['izin'] ?? 1;
        $sakit = $presensiData['sakit'] ?? 1;
        $alpa = $presensiData['alpa'] ?? 0;
        $total = $hadir + $izin + $sakit + $alpa;
        $persen = $total > 0 ? round(($hadir / $total) * 100) : 0;
    @endphp

    <div class="stat-row-5">
        <div class="presensi-stat">
            <div class="presensi-stat__value presensi-stat__value--green">{{ $hadir }}</div>
            <div class="presensi-stat__label">Hadir</div>
        </div>
        <div class="presensi-stat">
            <div class="presensi-stat__value presensi-stat__value--amber">{{ $izin }}</div>
            <div class="presensi-stat__label">Izin</div>
        </div>
        <div class="presensi-stat">
            <div class="presensi-stat__value presensi-stat__value--blue">{{ $sakit }}</div>
            <div class="presensi-stat__label">Sakit</div>
        </div>
        <div class="presensi-stat">
            <div class="presensi-stat__value presensi-stat__value--red">{{ $alpa }}</div>
            <div class="presensi-stat__label">Alpa</div>
        </div>
        <div class="presensi-stat">
            <div class="presensi-stat__value presensi-stat__value--teal">{{ $persen }}%</div>
            <div class="presensi-stat__label">% Hadir</div>
        </div>
    </div>

    {{-- Detail Kehadiran --}}
    <div class="detail-section">
        <div class="detail-section__header">
            DETAIL KEHADIRAN – {{ $namaBulan }} {{ $tahun }} | {{ $student->name ?? 'Ahmad Fauzi' }}
        </div>
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Hari</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($detailPresensi ?? [
                        ['tanggal' => '01 Mar 2026', 'hari' => "Jum'at", 'status' => 'hadir', 'keterangan' => '-'],
                        ['tanggal' => '04 Mar 2026', 'hari' => 'Senin', 'status' => 'hadir', 'keterangan' => '-'],
                        ['tanggal' => '05 Mar 2026', 'hari' => 'Selasa', 'status' => 'sakit', 'keterangan' => 'Demam'],
                        ['tanggal' => '06 Mar 2026', 'hari' => 'Rabu', 'status' => 'hadir', 'keterangan' => '-'],
                    ] as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item['tanggal'] }}</td>
                            <td>{{ $item['hari'] }}</td>
                            <td>
                                <span class="status-badge status-badge--{{ strtolower($item['status']) }}">
                                    {{ strtoupper($item['status']) }}
                                </span>
                            </td>
                            <td>{{ $item['keterangan'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state">Belum ada data presensi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
