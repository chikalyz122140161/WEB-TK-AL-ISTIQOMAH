@extends('layouts.app')

@section('title', 'Jadwal Konseling - SISTEM BK TK AL-ISTIQOMAH')
@section('page_title', 'Jadwal Konseling')

@push('styles')
<style>
    /* ── Toolbar ─────────────────────────────────────── */
    .toolbar {
        background: #fff;
        border: 1px solid #E5E7EB;
        border-radius: 10px;
        padding: 14px 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }
    .btn-new {
        height: 38px;
        padding: 0 18px;
        background: #065F46;
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        letter-spacing: .3px;
        white-space: nowrap;
        transition: background .15s;
    }
    .btn-new:hover { background: #064E3B; }
    .filter-select {
        height: 38px;
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
        min-width: 140px;
        transition: border-color .15s;
    }
    .filter-select:focus { border-color: #63E6BE; box-shadow: 0 0 0 3px rgba(99,230,190,.15); }

    /* ── Table card ───────────────────────────────────── */
    .table-card {
        background: #fff;
        border: 1px solid #E5E7EB;
        border-radius: 10px;
        overflow: hidden;
    }
    .jadwal-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .jadwal-table thead tr { background: #065F46; color: #fff; }
    .jadwal-table thead th {
        padding: 12px 14px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .5px;
        text-transform: uppercase;
        white-space: nowrap;
    }
    .jadwal-table thead th:first-child { width: 44px; text-align: center; }
    .jadwal-table tbody tr {
        border-bottom: 1px solid #F3F4F6;
        transition: background .1s;
    }
    .jadwal-table tbody tr:last-child { border-bottom: none; }
    .jadwal-table tbody tr:hover { background: #F0FDF4; }
    .jadwal-table tbody td {
        padding: 11px 14px;
        color: #374151;
        vertical-align: middle;
    }
    .jadwal-table tbody td:first-child { text-align: center; color: #9CA3AF; font-weight: 600; }

    /* ── Status badges ────────────────────────────────── */
    .badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 5px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .3px;
        text-transform: uppercase;
        white-space: nowrap;
    }
    .badge--disetujui { background: #D1FAE5; color: #065F46; }
    .badge--pending   { background: #F3F4F6; color: #6B7280; border: 1px solid #D1D5DB; }
    .badge--selesai   { background: #1F2937; color: #F9FAFB; }
    .badge--tolak     { background: #FEE2E2; color: #B91C1C; }

    /* ── Aksi links ───────────────────────────────────── */
    .aksi-links {
        display: flex;
        align-items: center;
        gap: 5px;
        flex-wrap: nowrap;
    }
    .aksi-links a {
        font-size: 12px;
        font-weight: 600;
        padding: 4px 9px;
        border-radius: 5px;
        text-decoration: none;
        white-space: nowrap;
        transition: background .12s;
    }
    .aksi-lihat     { background: #EFF6FF; color: #1D4ED8; }
    .aksi-lihat:hover     { background: #DBEAFE; }
    .aksi-edit      { background: #FFFBEB; color: #B45309; }
    .aksi-edit:hover      { background: #FEF3C7; }
    .aksi-batalkan  { background: #FEF2F2; color: #B91C1C; }
    .aksi-batalkan:hover  { background: #FEE2E2; }
    .aksi-setuju    { background: #D1FAE5; color: #065F46; }
    .aksi-setuju:hover    { background: #A7F3D0; }
    .aksi-tolak     { background: #FEF2F2; color: #B91C1C; }
    .aksi-tolak:hover     { background: #FEE2E2; }
    .aksi-catatan   { background: #F3F4F6; color: #374151; }
    .aksi-catatan:hover   { background: #E5E7EB; }

    /* ── Empty state ──────────────────────────────────── */
    .empty-state {
        text-align: center;
        padding: 48px 24px;
        color: #9CA3AF;
        font-size: 14px;
    }

    /* ── Modal (Buat Jadwal Baru) ─────────────────────── */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.4);
        z-index: 200;
        align-items: center;
        justify-content: center;
    }
    .modal-overlay.open { display: flex; }
    .modal {
        background: #fff;
        border-radius: 12px;
        padding: 28px 32px;
        width: 100%;
        max-width: 480px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    }
    .modal__title {
        font-size: 16px;
        font-weight: 700;
        color: #111827;
        margin: 0 0 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #F3F4F6;
        text-transform: uppercase;
        letter-spacing: .3px;
    }
    .field-group { display: flex; flex-direction: column; gap: 4px; margin-bottom: 14px; }
    .field-label {
        font-size: 11px;
        font-weight: 700;
        color: #6B7280;
        letter-spacing: .5px;
        text-transform: uppercase;
    }
    .field-control {
        width: 100%;
        height: 40px;
        padding: 0 12px;
        font-size: 13px;
        color: #111827;
        background: #F9FAFB;
        border: 1px solid #E5E7EB;
        border-radius: 8px;
        outline: none;
        font-family: inherit;
        box-sizing: border-box;
        transition: border-color .15s;
    }
    .field-control:focus { border-color: #63E6BE; background: #fff; box-shadow: 0 0 0 3px rgba(99,230,190,.15); }
    .modal-actions { display: flex; gap: 10px; margin-top: 20px; }
    .btn-modal-save {
        flex: 1;
        height: 38px;
        background: #065F46;
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-modal-save:hover { background: #064E3B; }
    .btn-modal-cancel {
        height: 38px;
        padding: 0 20px;
        background: #fff;
        color: #374151;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid #D1D5DB;
        border-radius: 8px;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-modal-cancel:hover { background: #F3F4F6; }
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
    <a href="{{ route('guru.laporan') }}" class="sidebar__item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd"/><path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z"/></svg>
        Laporan Perkembangan
    </a>
    <a href="{{ route('guru.chat') }}" class="sidebar__item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M4.804 21.644A6.707 6.707 0 0 0 6 21.75a6.721 6.721 0 0 0 3.583-1.029c.774.182 1.584.279 2.417.279 5.322 0 9.75-3.97 9.75-9 0-5.03-4.428-9-9.75-9s-9.75 3.97-9.75 9c0 2.09.768 4.04 2.084 5.558a8.96 8.96 0 0 1-1.603 2.596.75.75 0 0 0 .53 1.28 6.72 6.72 0 0 0 1.543-.09Z" clip-rule="evenodd"/></svg>
        Chat
    </a>
    <a href="{{ route('guru.jadwal_konseling') }}" class="sidebar__item active">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd"/></svg>
        Jadwal Konseling
    </a>
@endsection

{{-- CONTENT --}}
@section('content')

    <h2 style="margin:0 0 16px;font-size:20px;font-weight:700;color:#111827;text-transform:uppercase;letter-spacing:.5px;">
        Jadwal Konseling
    </h2>

    {{-- Toolbar --}}
    <form method="GET" action="{{ route('guru.jadwal_konseling') }}" class="toolbar">
        <button type="button" class="btn-new" onclick="document.getElementById('modalBuat').classList.add('open')">
            BUAT JADWAL BARU
        </button>
        <select class="filter-select" name="bulan" onchange="this.form.submit()">
            @foreach (['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $bln)
                <option value="{{ $i + 1 }}" {{ request('bulan', date('n')) == $i + 1 ? 'selected' : '' }}>
                    {{ $bln }}
                </option>
            @endforeach
        </select>
    </form>

    {{-- Table --}}
    <div class="table-card">
        <table class="jadwal-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Orang Tua</th>
                    <th>Siswa</th>
                    <th>Topik</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jadwal as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $row['tanggal'] }}</td>
                    <td style="white-space:nowrap;">{{ $row['waktu'] }}</td>
                    <td>{{ $row['orang_tua'] }}</td>
                    <td>{{ $row['siswa'] }}</td>
                    <td>{{ $row['topik'] }}</td>
                    <td>
                        @if ($row['status'] === 'disetujui')
                            <span class="badge badge--disetujui">Disetujui</span>
                        @elseif ($row['status'] === 'pending')
                            <span class="badge badge--pending">Pending</span>
                        @elseif ($row['status'] === 'selesai')
                            <span class="badge badge--selesai">Selesai</span>
                        @else
                            <span class="badge badge--tolak">Ditolak</span>
                        @endif
                    </td>
                    <td>
                        <div class="aksi-links">
                            <a href="#" class="aksi-lihat">[LIHAT]</a>
                            @if ($row['status'] === 'disetujui')
                                <a href="#" class="aksi-edit">[EDIT]</a>
                                <a href="#" class="aksi-batalkan">[BATALKAN]</a>
                            @elseif ($row['status'] === 'pending')
                                <a href="#" class="aksi-setuju">[SETUJU]</a>
                                <a href="#" class="aksi-tolak">[TOLAK]</a>
                            @elseif ($row['status'] === 'selesai')
                                <a href="#" class="aksi-catatan">[CATATAN]</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">Belum ada jadwal konseling bulan ini.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal Buat Jadwal Baru --}}
    <div class="modal-overlay" id="modalBuat" onclick="if(event.target===this)this.classList.remove('open')">
        <div class="modal">
            <p class="modal__title">Buat Jadwal Baru</p>
            <form method="POST" action="{{ route('guru.jadwal_konseling.store') }}">
                @csrf
                <div class="field-group">
                    <label class="field-label" for="m_tanggal">Tanggal</label>
                    <input class="field-control" type="date" id="m_tanggal" name="tanggal" required>
                </div>
                <div class="field-group">
                    <label class="field-label" for="m_waktu_mulai">Waktu Mulai</label>
                    <input class="field-control" type="time" id="m_waktu_mulai" name="waktu_mulai" required>
                </div>
                <div class="field-group">
                    <label class="field-label" for="m_waktu_selesai">Waktu Selesai</label>
                    <input class="field-control" type="time" id="m_waktu_selesai" name="waktu_selesai" required>
                </div>
                <div class="field-group">
                    <label class="field-label" for="m_orang_tua">Orang Tua</label>
                    <input class="field-control" type="text" id="m_orang_tua" name="orang_tua" placeholder="Nama orang tua" required>
                </div>
                <div class="field-group">
                    <label class="field-label" for="m_siswa">Siswa</label>
                    <input class="field-control" type="text" id="m_siswa" name="siswa" placeholder="Nama siswa" required>
                </div>
                <div class="field-group">
                    <label class="field-label" for="m_topik">Topik</label>
                    <input class="field-control" type="text" id="m_topik" name="topik" placeholder="Topik konseling" required>
                </div>
                <div class="modal-actions">
                    <button type="submit" class="btn-modal-save">SIMPAN</button>
                    <button type="button" class="btn-modal-cancel"
                        onclick="document.getElementById('modalBuat').classList.remove('open')">
                        BATAL
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
