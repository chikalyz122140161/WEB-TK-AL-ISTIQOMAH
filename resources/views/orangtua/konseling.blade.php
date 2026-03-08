@extends('layouts.app')

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
        max-width: 900px;
    }

    /* Section Header */
    .section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 2px solid #faae2b;
    }
    .section-header__icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #faae2b 0%, #f5a623 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .section-header__icon svg {
        width: 22px;
        height: 22px;
        fill: #00473e;
    }
    .section-header__text h2 {
        font-size: 18px;
        font-weight: 700;
        color: #00473e;
        margin: 0;
    }
    .section-header__text p {
        font-size: 13px;
        color: #475d5b;
        margin: 2px 0 0;
    }

    /* Form Card */
    .form-card {
        background: #fff;
        border: 1px solid #00473e20;
        border-radius: 8px;
        padding: 24px;
        margin-bottom: 24px;
    }
    .form-card__title {
        font-size: 16px;
        font-weight: 600;
        color: #00473e;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #00473e10;
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
        color: #00473e;
    }
    .form-group label span {
        color: #EF4444;
    }
    .form-group input,
    .form-group select,
    .form-group textarea {
        padding: 12px 14px;
        border: 1px solid #00473e20;
        border-radius: 8px;
        font-size: 14px;
        color: #00473e;
        background: #f8f9fa;
        transition: all 0.2s;
        font-family: inherit;
    }
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #faae2b;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(250, 174, 43, 0.1);
    }
    .form-group textarea {
        resize: vertical;
        min-height: 120px;
    }
    .form-hint {
        font-size: 12px;
        color: #6B7280;
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
        color: #6B7280;
        white-space: nowrap;
    }

    /* Submit Button */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #00473e10;
    }
    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #faae2b 0%, #f5a623 100%);
        color: #00473e;
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
        box-shadow: 0 4px 12px rgba(250, 174, 43, 0.4);
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
        background: #f3f4f6;
        color: #374151;
        padding: 12px 24px;
        font-size: 14px;
        font-weight: 500;
        border: 1px solid #D1D5DB;
        cursor: pointer;
        border-radius: 8px;
        transition: all 0.3s;
    }
    .btn-reset:hover {
        background: #e5e7eb;
    }

    /* Riwayat Konseling */
    .history-card {
        background: #fff;
        border: 1px solid #00473e20;
        border-radius: 8px;
        overflow: hidden;
    }
    .history-card__header {
        padding: 16px 20px;
        border-bottom: 1px solid #00473e10;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .history-card__title {
        font-size: 16px;
        font-weight: 600;
        color: #00473e;
    }
    .history-table {
        width: 100%;
        border-collapse: collapse;
    }
    .history-table th,
    .history-table td {
        padding: 14px 20px;
        text-align: left;
        border-bottom: 1px solid #00473e08;
    }
    .history-table th {
        background: #f8f9fa;
        font-size: 12px;
        font-weight: 600;
        color: #475d5b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .history-table td {
        font-size: 14px;
        color: #00473e;
    }
    .history-table tr:last-child td {
        border-bottom: none;
    }
    .history-table tr:hover td {
        background: #f8f9fa;
    }

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
        color: #B45309;
    }
    .status-badge--approved {
        background: #ECFDF5;
        color: #047857;
    }
    .status-badge--completed {
        background: #EFF6FF;
        color: #1D4ED8;
    }
    .status-badge--cancelled {
        background: #FEF2F2;
        color: #B91C1C;
    }

    /* Info Alert */
    .info-alert {
        background: #EFF6FF;
        border: 1px solid #BFDBFE;
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
        fill: #1D4ED8;
        flex-shrink: 0;
        margin-top: 2px;
    }
    .info-alert__text {
        font-size: 14px;
        color: #1E40AF;
        line-height: 1.6;
    }
</style>
@endpush

<div class="konseling-container">
    {{-- Section Header --}}
    <div class="section-header">
        <div class="section-header__icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd"/></svg>
        </div>
        <div class="section-header__text">
            <h2>Pengajuan Konseling</h2>
            <p>Ajukan jadwal konseling dengan guru BK</p>
        </div>
    </div>

    {{-- Info Alert --}}
    <div class="info-alert">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd"/></svg>
        <div class="info-alert__text">
            Konseling dapat dijadwalkan pada hari kerja (Senin - Jumat) pukul 08:00 - 15:00. 
            Setelah pengajuan disetujui, Anda akan mendapat notifikasi melalui SMS dan email.
        </div>
    </div>

    {{-- Form Pengajuan --}}
    <form action="#" method="POST" class="form-card">
        @csrf
        <h3 class="form-card__title">Form Pengajuan Konseling</h3>
        
        <div class="form-grid">
            <div class="form-group">
                <label>Nama Anak</label>
                <input type="text" value="{{ $student->nama ?? 'Ahmad Fauzi' }}" readonly>
            </div>
            <div class="form-group">
                <label>Kelas</label>
                <input type="text" value="{{ $student->kelas ?? 'TK A' }}" readonly>
            </div>
            <div class="form-group">
                <label>Pilih Tanggal <span>*</span></label>
                <input type="date" name="tanggal" required min="{{ date('Y-m-d') }}">
            </div>
            <div class="form-group">
                <label>Guru BK <span>*</span></label>
                <select name="guru_id" required>
                    <option value="">Pilih Guru BK</option>
                    <option value="1">Pak Ahmad - Konselor</option>
                    <option value="2">Bu Siti - Guru Kelas TK A</option>
                </select>
            </div>
            <div class="form-group">
                <label>Jam Mulai <span>*</span></label>
                <input type="time" name="waktu_mulai" required>
            </div>
            <div class="form-group">
                <label>Jam Selesai <span>*</span></label>
                <input type="time" name="waktu_selesai" required>
            </div>
            <div class="form-group form-group--full">
                <label>Topik/Permasalahan yang Ingin Dibahas <span>*</span></label>
                <textarea name="topik" placeholder="Jelaskan topik atau permasalahan yang ingin dikonsultasikan..." required></textarea>
                <div class="form-hint">Deskripsikan secara singkat agar guru BK dapat mempersiapkan materi konseling.</div>
            </div>
        </div>

        <div class="form-actions">
            <button type="reset" class="btn-reset">Reset Form</button>
            <button type="submit" class="btn-submit">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd"/></svg>
                Ajukan Konseling
            </button>
        </div>
    </form>

    {{-- Riwayat Konseling --}}
    <div class="history-card">
        <div class="history-card__header">
            <h3 class="history-card__title">Riwayat Pengajuan Konseling</h3>
        </div>
        <table class="history-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Guru BK</th>
                    <th>Topik</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>25 Nov 2024</td>
                    <td>09:00 - 10:00</td>
                    <td>Pak Ahmad</td>
                    <td>Perkembangan sosial-emosional</td>
                    <td><span class="status-badge status-badge--completed">Selesai</span></td>
                </tr>
                <tr>
                    <td>28 Nov 2024</td>
                    <td>14:00 - 15:00</td>
                    <td>Bu Siti</td>
                    <td>Konsultasi nilai kognitif</td>
                    <td><span class="status-badge status-badge--approved">Disetujui</span></td>
                </tr>
                <tr>
                    <td>02 Des 2024</td>
                    <td>11:00 - 12:00</td>
                    <td>Pak Ahmad</td>
                    <td>Perilaku bermain dengan teman</td>
                    <td><span class="status-badge status-badge--pending">Menunggu</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>



@endsection
