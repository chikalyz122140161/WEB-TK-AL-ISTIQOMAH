@extends('layouts.app')

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
        color: #475d5b;
    }
    .filter-group select {
        padding: 10px 14px;
        border: 1px solid #00473e30;
        border-radius: 6px;
        font-size: 14px;
        color: #00473e;
        background: #fff;
        min-width: 160px;
        cursor: pointer;
    }
    .filter-group select:focus {
        outline: none;
        border-color: #faae2b;
        box-shadow: 0 0 0 3px rgba(250, 174, 43, 0.1);
    }
    .btn-tampilkan {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #faae2b 0%, #f5a623 100%);
        color: #00473e;
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
        box-shadow: 0 4px 12px rgba(250, 174, 43, 0.3);
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
        border: 1px solid #00473e20;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
    }
    .presensi-stat__value {
        font-size: 32px;
        font-weight: 700;
        color: #00473e;
        line-height: 1;
    }
    .presensi-stat__value--green { color: #047857; }
    .presensi-stat__value--amber { color: #b45309; }
    .presensi-stat__value--blue { color: #1d4ed8; }
    .presensi-stat__value--red { color: #dc2626; }
    .presensi-stat__value--teal { color: #00473e; }
    .presensi-stat__label {
        font-size: 13px;
        color: #475d5b;
        margin-top: 6px;
    }

    /* Detail Section */
    .detail-section {
        background: #fff;
        border: 1px solid #00473e20;
        border-radius: 8px;
        overflow: hidden;
    }
    .detail-section__header {
        padding: 16px 20px;
        border-bottom: 1px solid #00473e10;
        font-size: 14px;
        font-weight: 600;
        color: #00473e;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    .data-table th,
    .data-table td {
        padding: 12px 16px;
        text-align: left;
        border-bottom: 1px solid #00473e10;
    }
    .data-table th {
        background: linear-gradient(135deg, #faae2b20 0%, #faae2b30 100%);
        font-size: 12px;
        font-weight: 600;
        color: #00473e;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .data-table td {
        font-size: 14px;
        color: #475d5b;
    }
    .data-table tr:hover td {
        background: #f2f7f5;
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
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #b45309;
    }
    .status-badge--sakit {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1d4ed8;
    }
    .status-badge--alpa {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #dc2626;
    }
    .empty-state {
        text-align: center;
        padding: 40px;
        color: #475d5b;
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
