@extends('layouts.app')
@php $userRole = 'Orang Tua'; @endphp

@section('title', 'Pengajuan Konseling - SISTEM BK TK AL-ISTIQOMAH')
@section('page_title', 'Pengajuan Konseling')

{{-- SIDEBAR --}}
@section('sidebar')
    @include('orangtua.partials.sidebar')
@endsection

{{-- CONTENT --}}
@section('content')

@push('styles')
<style>
    .konseling-container {
        max-width: 100%;
    }

    /* Section Header */
    .section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 2px solid #4CAF82;
    }
    .section-header__icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .section-header__icon svg {
        width: 22px;
        height: 22px;
        fill: #3E2723;
    }
    .section-header__text h2 {
        font-size: 18px;
        font-weight: 700;
        color: #3E2723;
        margin: 0;
    }
    .section-header__text p {
        font-size: 13px;
        color: #5D4037;
        margin: 2px 0 0;
    }

    /* Form Card */
    .form-card {
        background: #fff;
        border: 1px solid #3E272320;
        border-radius: 8px;
        padding: 24px;
        margin-bottom: 24px;
    }
    .form-card__title {
        font-size: 16px;
        font-weight: 600;
        color: #3E2723;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #3E272310;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    @media (max-width: 768px) {
        .form-grid { grid-template-columns: 1fr; }
    }
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .form-group--full {
        grid-column: 1 / -1;
    }
    .form-group label {
        font-size: 13px;
        font-weight: 600;
        color: #3E2723;
    }
    .form-group label span {
        color: #F06292;
    }
    .form-group input,
    .form-group select,
    .form-group textarea {
        padding: 12px 14px;
        border: 1px solid #3E272320;
        border-radius: 8px;
        font-size: 14px;
        color: #3E2723;
        background: #f8f9fa;
        transition: all 0.2s;
        font-family: inherit;
    }
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #4CAF82;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(76, 175, 130, 0.1);
    }
    .form-group textarea {
        resize: vertical;
        min-height: 120px;
    }
    .form-hint {
        font-size: 12px;
        color: #5D4037;
        margin-top: 4px;
    }

    /* Time inputs */
    .time-inputs {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .time-inputs span {
        font-size: 13px;
        color: #5D4037;
        white-space: nowrap;
    }

    /* Submit Button */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #3E272310;
    }
    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
        color: #3E2723;
        padding: 12px 24px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        border-radius: 8px;
        transition: all 0.3s;
    }
    .btn-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(76,175,130, 0.4);
    }
    .btn-submit svg {
        width: 18px;
        height: 18px;
        fill: currentColor;
    }
    .btn-reset {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #FFFDE7;
        color: #3E2723;
        padding: 12px 24px;
        font-size: 14px;
        font-weight: 500;
        border: 1px solid #3E272330;
        cursor: pointer;
        border-radius: 8px;
        transition: all 0.3s;
    }
    .btn-reset:hover {
        background: #3E272320;
    }

    /* Riwayat Konseling */
    .history-card {
        background: #fff;
        border: 1px solid #3E272320;
        border-radius: 8px;
        overflow: hidden;
    }
    .history-card__header {
        padding: 16px 20px;
        border-bottom: 1px solid #3E272310;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .history-card__title {
        font-size: 16px;
        font-weight: 600;
        color: #3E2723;
    }
    .history-card { overflow-x: auto; }
    .history-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 820px;
    }
    .history-table th,
    .history-table td {
        padding: 12px 16px;
        text-align: left;
        border-bottom: 1px solid #3E272308;
        vertical-align: middle;
    }
    .history-table th {
        background: #f8f9fa;
        font-size: 11px;
        font-weight: 600;
        color: #5D4037;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }
    .history-table td {
        font-size: 13px;
        color: #3E2723;
    }
    .history-table tr:last-child td { border-bottom: none; }
    .history-table tr:hover td { background: #f8f9fa; }
    /* Fixed column widths */
    .history-table th:nth-child(1),
    .history-table td:nth-child(1) { min-width: 90px; white-space: nowrap; }   /* Tanggal */
    .history-table th:nth-child(2),
    .history-table td:nth-child(2) { min-width: 100px; white-space: nowrap; }  /* Waktu */
    .history-table th:nth-child(3),
    .history-table td:nth-child(3) { min-width: 110px; white-space: nowrap; }  /* Guru BK */
    .history-table th:nth-child(4),
    .history-table td:nth-child(4) { min-width: 160px; }                       /* Topik */
    .history-table th:nth-child(5),
    .history-table td:nth-child(5) { min-width: 90px; white-space: nowrap; }   /* Status */
    .history-table th:nth-child(6),
    .history-table td:nth-child(6) { min-width: 80px; white-space: nowrap; }   /* Sumber */
    .history-table th:nth-child(7),
    .history-table td:nth-child(7) { min-width: 140px; }                       /* Catatan */
    .history-table th:nth-child(8),
    .history-table td:nth-child(8) { min-width: 130px; text-align: center; }   /* Aksi */

    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    .status-badge--pending {
        background: #FFFBEB;
        color: #5D4037;
    }
    .status-badge--approved {
        background: rgba(76,175,130,0.12);
        color: #2E8B60;
    }
    .status-badge--completed {
        background: rgba(76,175,130,0.12);
        color: #2E8B60;
    }
    .status-badge--cancelled {
        background: #F0629220;
        color: #d81b72;
    }

    /* Aksi buttons */
    .aksi-btns {
        display: flex; align-items: center; gap: 6px; flex-wrap: nowrap;
    }
    .aksi-btns .btn-edit,
    .aksi-btns .btn-batal {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 5px 10px; font-size: 11px; font-weight: 600;
        border-radius: 6px; border: none; cursor: pointer;
        text-decoration: none; white-space: nowrap;
        font-family: inherit; transition: all .15s;
        line-height: 1;
    }
    .aksi-btns .btn-edit {
        background: #FFF176; color: #3E2723;
        border: 1.5px solid #e6db00;
    }
    .aksi-btns .btn-edit:hover { background: #ffe500; }
    .aksi-btns .btn-batal {
        background: #F06292; color: #fff;
    }
    .aksi-btns .btn-batal:hover { background: #e91e8c; }
    .aksi-btns svg { width: 12px; height: 12px; fill: currentColor; flex-shrink: 0; }

    /* Info Alert */
    .info-alert {
        background: rgba(76,175,130,0.10);
        border: 1px solid rgba(76,175,130,0.25);
        border-radius: 8px;
        padding: 16px 20px;
        margin-bottom: 24px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }
    .info-alert svg {
        width: 20px;
        height: 20px;
        fill: #2E8B60;
        flex-shrink: 0;
        margin-top: 2px;
    }
    .info-alert__text {
        font-size: 14px;
        color: #2E8B60;
        line-height: 1.6;
    }
</style>
@endpush

<div class="konseling-container">
    {{-- Section Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:18px;flex-wrap:wrap;">
        <h2 style="font-size:22px;font-weight:700;color:#3E2723;margin:0;">Konseling</h2>
        <a href="{{ route('orangtua.konseling.ajukan_form') }}"
           style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#4CAF82 0%,#3D9B72 100%);color:#fff;padding:11px 22px;font-size:13px;font-weight:600;border-radius:8px;text-decoration:none;box-shadow:0 2px 8px rgba(61,155,114,0.25);transition:all .15s;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="16" height="16">
                <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/>
            </svg>
            Ajukan Konseling Baru
        </a>
    </div>

    {{-- Info Alert --}}
    <div class="info-alert">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd"/></svg>
        <div class="info-alert__text">
            Konseling dapat dijadwalkan pada hari kerja (Senin - Jumat) pukul 08:00 - 15:00.
            Setelah pengajuan disetujui, Anda akan mendapat notifikasi melalui SMS dan email.
        </div>
    </div>

    {{-- Tabel Jadwal Konseling (gabungan dari guru + pengajuan sendiri) --}}
    <div class="history-card">
        <div class="history-card__header">
            <h3 class="history-card__title" style="display:inline-flex;align-items:center;gap:8px;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#3D9B72" width="18" height="18"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
                Jadwal Konseling
            </h3>
            <span style="font-size:11px;color:#5D4037;background:rgba(76,175,130,0.12);padding:3px 10px;border-radius:99px;border:1px solid rgba(76,175,130,0.3);font-weight:600;">
                {{ count($jadwalKonseling ?? []) }} jadwal
            </span>
        </div>
        <table class="history-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Guru BK</th>
                    <th>Topik</th>
                    <th>Status</th>
                    <th>Sumber</th>
                    <th>Catatan</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jadwalKonseling ?? [] as $jadwal)
                    @php
                        $statusMap = [
                            'pending'   => ['cls' => 'pending',   'label' => 'Menunggu'],
                            'disetujui' => ['cls' => 'approved',  'label' => 'Disetujui'],
                            'selesai'   => ['cls' => 'completed', 'label' => 'Selesai'],
                            'ditolak'   => ['cls' => 'cancelled', 'label' => 'Ditolak'],
                        ];
                        $st = $statusMap[$jadwal['status']] ?? ['cls' => 'pending', 'label' => $jadwal['status']];
                        $sumberLabel = $jadwal['sumber'] === 'guru' ? 'Dari Guru' : 'Pengajuan';
                    @endphp
                    <tr>
                        <td>{{ $jadwal['tanggal'] }}</td>
                        <td>{{ $jadwal['waktu'] }}</td>
                        <td>{{ $jadwal['guru'] }}</td>
                        <td>{{ $jadwal['topik'] }}</td>
                        <td><span class="status-badge status-badge--{{ $st['cls'] }}">{{ $st['label'] }}</span></td>
                        <td style="font-size:12px;color:#5D4037;">{{ $sumberLabel }}</td>
                        <td style="font-size:12px;color:#5D4037;">{{ $jadwal['catatan'] ?: '—' }}</td>
                        <td style="text-align:center;">
                            @if ($jadwal['sumber'] === 'pengajuan' && $jadwal['status'] === 'pending')
                            <div class="aksi-btns" style="justify-content:center;">
                                <a href="{{ route('orangtua.konseling.edit', $jadwal['id']) }}" class="btn-edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z"/></svg>
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('orangtua.konseling.batal', $jadwal['id']) }}" style="margin:0;" onsubmit="return confirm('Batalkan pengajuan konseling ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-batal">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
                                        Batal
                                    </button>
                                </form>
                            </div>
                            @else
                            <span style="color:#9ca3af;font-size:12px;">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center;padding:30px;color:#9ca3af;font-style:italic;">
                            Belum ada jadwal konseling.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>



@endsection
