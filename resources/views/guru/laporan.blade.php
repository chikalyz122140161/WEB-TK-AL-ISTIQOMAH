@extends('layouts.app')

@section('title', 'Laporan Perkembangan - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Laporan Perkembangan Siswa')

@push('styles')
<style>
    /* Filter bar */
    .filter-bar {
        background: #fff;
        border: 1px solid #E5E7EB;
        border-radius: 10px;
        padding: 14px 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .filter-select {
        height: 36px;
        padding: 0 32px 0 12px;
        font-size: 13px;
        color: #111827;
        background: #F9FAFB url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%236B7280'%3E%3Cpath fill-rule='evenodd' d='M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z' clip-rule='evenodd'/%3E%3C/svg%3E") no-repeat right 8px center;
        background-size: 18px;
        border: 1px solid #D1D5DB;
        border-radius: 8px;
        outline: none;
        appearance: none;
        cursor: pointer;
        font-family: inherit;
        min-width: 150px;
        transition: border-color .15s;
    }
    .filter-select:focus { border-color: #fb923c; box-shadow: 0 0 0 3px rgba(251,146,60,.15); }
    .btn-filter {
        height: 36px;
        padding: 0 20px;
        background: #f97316;
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        letter-spacing: .4px;
        transition: background .15s;
    }
    .btn-filter:hover { background: #ea580c; }

    /* ── Table card ─────────────────────────────────────── */
    .table-card {
        background: #fff;
        border: 1px solid #E5E7EB;
        border-radius: 10px;
        overflow: hidden;
    }
    .laporan-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .laporan-table thead tr {
        background: #f97316;
        color: #fff;
    }
    .laporan-table thead th {
        padding: 12px 16px;
        text-align: left;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .4px;
        text-transform: uppercase;
        white-space: nowrap;
    }
    .laporan-table thead th:first-child { width: 48px; text-align: center; }
    .laporan-table tbody tr {
        border-bottom: 1px solid #F3F4F6;
        transition: background .1s;
    }
    .laporan-table tbody tr:last-child { border-bottom: none; }
    .laporan-table tbody tr:hover { background: #fff7ed; }
    .laporan-table tbody td {
        padding: 11px 16px;
        color: #374151;
        vertical-align: middle;
    }
    .laporan-table tbody td:first-child { text-align: center; color: #9CA3AF; font-weight: 600; }
    .rata-rata {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-weight: 700;
        color: #c2410c;
    }
    .rata-rata__bar {
        width: 48px;
        height: 6px;
        background: #ffedd5;
        border-radius: 3px;
        overflow: hidden;
    }
    .rata-rata__fill {
        height: 100%;
        background: #fb923c;
        border-radius: 3px;
    }

    /* ── Action links ────────────────────────────────────── */
    .aksi-links {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: nowrap;
    }
    .aksi-links a {
        font-size: 12px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 5px;
        text-decoration: none;
        white-space: nowrap;
        transition: background .12s, color .12s;
    }
    .aksi-lihat  { background: #EFF6FF; color: #1D4ED8; }
    .aksi-lihat:hover  { background: #DBEAFE; }
    .aksi-edit   { background: #FFFBEB; color: #B45309; }
    .aksi-edit:hover   { background: #FEF3C7; }
    .aksi-pdf    { background: #FEF2F2; color: #B91C1C; }
    .aksi-pdf:hover    { background: #FEE2E2; }

    /* Empty state  */
    .empty-state {
        text-align: center;
        padding: 48px 24px;
        color: #9CA3AF;
        font-size: 14px;
    }
</style>
@endpush

{{-- SIDEBAR --}}
@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

{{-- CONTENT --}}
@section('content')

    <h2 style="margin:0 0 20px;font-size:20px;font-weight:700;color:#111827;text-transform:uppercase;letter-spacing:.5px;">
        Laporan Perkembangan Siswa
    </h2>

    {{-- Filter bar --}}
    <form method="GET" action="{{ route('guru.laporan_bk') }}" class="filter-bar">
        <select class="filter-select" name="siswa_id">
            <option value="">Semua Siswa</option>
            @foreach ($daftarSiswa as $s)
                <option value="{{ $s['id'] }}" {{ request('siswa_id') == $s['id'] ? 'selected' : '' }}>
                    {{ $s['nama'] }}
                </option>
            @endforeach
        </select>
        <select class="filter-select" name="minggu">
            <option value="">Semua Minggu</option>
            @foreach (range(1, 20) as $m)
                <option value="{{ $m }}" {{ request('minggu') == $m ? 'selected' : '' }}>
                    Minggu {{ $m }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn-filter">FILTER</button>
    </form>

    {{-- Table --}}
    <div class="table-card">
        <table class="laporan-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Minggu</th>
                    <th>Tanggal</th>
                    <th>Rata-rata</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporan as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $row['nama'] }}</td>
                    <td>{{ $row['kelas'] }}</td>
                    <td>{{ $row['minggu'] }}</td>
                    <td>{{ $row['tanggal'] }}</td>
                    <td>
                        <div class="rata-rata">
                            {{ number_format($row['rata_rata'], 1) }}
                            <div class="rata-rata__bar">
                                <div class="rata-rata__fill" style="width:{{ ($row['rata_rata'] / 5) * 100 }}%"></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="aksi-links">
                            <a href="javascript:void(0)" class="aksi-lihat" onclick="alert('Melihat laporan perkembangan {{ $row['nama'] }} - Minggu {{ $row['minggu'] }}')">[LIHAT]</a>
                            <a href="javascript:void(0)" class="aksi-edit" onclick="alert('Edit laporan perkembangan {{ $row['nama'] }}')">[EDIT]</a>
                            <a href="javascript:void(0)" class="aksi-pdf" onclick="alert('Mengunduh PDF laporan {{ $row['nama'] }}')">[PDF]</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">Belum ada data laporan.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
