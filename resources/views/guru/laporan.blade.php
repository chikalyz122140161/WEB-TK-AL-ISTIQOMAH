@extends('layouts.app')

@section('title', 'Laporan Perkembangan - SISTEM BK TK AL-ISTIQOMAH')
@section('page_title', 'Laporan Perkembangan Siswa')

@push('styles')
<style>
    /* ── Filter bar ─────────────────────────────────────── */
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
    .filter-select:focus { border-color: #63E6BE; box-shadow: 0 0 0 3px rgba(99,230,190,.15); }
    .btn-filter {
        height: 36px;
        padding: 0 20px;
        background: #065F46;
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        letter-spacing: .4px;
        transition: background .15s;
    }
    .btn-filter:hover { background: #064E3B; }

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
        background: #065F46;
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
    .laporan-table tbody tr:hover { background: #F0FDF4; }
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
        color: #065F46;
    }
    .rata-rata__bar {
        width: 48px;
        height: 6px;
        background: #D1FAE5;
        border-radius: 3px;
        overflow: hidden;
    }
    .rata-rata__fill {
        height: 100%;
        background: #63E6BE;
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

    /* ── Empty state ─────────────────────────────────────── */
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
    <a href="{{ route('guru.dashboard') }}" class="sidebar__item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z"/><path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15.75a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-4.5a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z"/></svg>
        Dashboard
    </a>

    <div class="sidebar__divider"></div>
    <span class="sidebar__label">Administrasi</span>

    <a href="#" class="sidebar__item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z"/><path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z"/></svg>
        Form Catat Kehadiran
    </a>
    <a href="#" class="sidebar__item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z" clip-rule="evenodd"/></svg>
        List Kehadiran
    </a>
    <a href="#" class="sidebar__item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd"/><path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z"/></svg>
        Form Generate Laporan
    </a>
    <a href="#" class="sidebar__item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.625 16.5a1.875 1.875 0 1 0 0-3.75 1.875 1.875 0 0 0 0 3.75Z"/><path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875Zm6 16.5a3.375 3.375 0 1 0 0-6.75 3.375 3.375 0 0 0 0 6.75Z" clip-rule="evenodd"/><path d="M16.875 6.375a3.75 3.75 0 0 0-.437-1.745 4.5 4.5 0 0 1 2.813 4.12v.163l-1.688-1.55a1.875 1.875 0 0 1-.688-1.988Z"/></svg>
        List Laporan
    </a>
    <a href="#" class="sidebar__item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd"/></svg>
        List Jadwal
    </a>
    <a href="#" class="sidebar__item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z"/></svg>
        Form Tambah Jadwal
    </a>

    <div class="sidebar__divider"></div>
    <span class="sidebar__label">Bimbingan Konseling</span>

    <a href="{{ route('guru.input_perkembangan') }}" class="sidebar__item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z"/><path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z"/></svg>
        Input Perkembangan
    </a>
    <a href="{{ route('guru.grafik') }}" class="sidebar__item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75ZM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 0 1-1.875-1.875V8.625ZM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 0 1 3 19.875v-6.75Z"/></svg>
        Grafik
    </a>
    <a href="{{ route('guru.laporan') }}" class="sidebar__item active">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd"/><path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z"/></svg>
        Laporan Perkembangan
    </a>
    <a href="#" class="sidebar__item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M4.804 21.644A6.707 6.707 0 0 0 6 21.75a6.721 6.721 0 0 0 3.583-1.029c.774.182 1.584.279 2.417.279 5.322 0 9.75-3.97 9.75-9 0-5.03-4.428-9-9.75-9s-9.75 3.97-9.75 9c0 2.09.768 4.04 2.084 5.558a8.96 8.96 0 0 1-1.603 2.596.75.75 0 0 0 .53 1.28 6.72 6.72 0 0 0 1.543-.09Z" clip-rule="evenodd"/></svg>
        Chat
    </a>
    <a href="#" class="sidebar__item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd"/></svg>
        Jadwal Konseling
    </a>
@endsection

{{-- CONTENT --}}
@section('content')

    <h2 style="margin:0 0 20px;font-size:20px;font-weight:700;color:#111827;text-transform:uppercase;letter-spacing:.5px;">
        Laporan Perkembangan Siswa
    </h2>

    {{-- Filter bar --}}
    <form method="GET" action="{{ route('guru.laporan') }}" class="filter-bar">
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
                            <a href="#" class="aksi-lihat">[LIHAT]</a>
                            <a href="#" class="aksi-edit">[EDIT]</a>
                            <a href="#" class="aksi-pdf">[PDF]</a>
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
