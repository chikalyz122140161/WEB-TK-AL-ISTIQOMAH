@extends('layouts.app')
@php $userRole = 'Orang Tua'; @endphp

@section('title', 'Ajukan Konseling - SISTEM BK TK AL-ISTIQOMAH')
@section('page_title', 'Ajukan Konseling Baru')

@section('sidebar')
    @include('orangtua.partials.sidebar')
@endsection

@push('styles')
<style>
    .back-link {
        display: inline-flex; align-items: center; gap: 6px;
        color: #5D4037; font-size: 13px; font-weight: 500;
        margin-bottom: 14px; text-decoration: none;
        transition: color .15s;
    }
    .back-link:hover { color: #3D9B72; }
    .back-link svg { width: 14px; height: 14px; fill: currentColor; }

    .form-card {
        background: #fff;
        border: 1px solid #3E272320;
        border-radius: 10px;
        padding: 24px;
        max-width: 900px;
    }
    .form-card__title {
        font-size: 16px; font-weight: 600;
        color: #3E2723; margin: 0 0 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #3E272310;
    }
    .info-alert {
        background: rgba(76,175,130,0.10);
        border: 1px solid rgba(76,175,130,0.25);
        border-radius: 8px;
        padding: 14px 16px;
        margin-bottom: 18px;
        display: flex; align-items: flex-start; gap: 10px;
        font-size: 13px; color: #2E8B60; line-height: 1.55;
    }
    .info-alert svg { width: 18px; height: 18px; fill: #2E8B60; flex-shrink: 0; margin-top: 2px; }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
    @media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; } }
    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group--full { grid-column: 1 / -1; }
    .form-group label { font-size: 13px; font-weight: 600; color: #3E2723; }
    .form-group label .req { color: #F06292; }
    .form-group input, .form-group select, .form-group textarea {
        padding: 11px 14px;
        border: 1px solid #3E272320;
        border-radius: 7px;
        font-size: 13px; color: #3E2723;
        background: #f8f9fa;
        font-family: inherit; transition: all .15s;
    }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
        outline: none; border-color: #4CAF82; background: #fff;
        box-shadow: 0 0 0 3px rgba(76,175,130,0.1);
    }
    .form-group input[readonly] { background: #f3f4f6; color: #6b7280; cursor: default; }
    .form-group textarea { resize: vertical; min-height: 110px; }
    .form-hint { font-size: 11px; color: #5D4037; margin-top: 3px; }

    .form-actions {
        display: flex; justify-content: flex-end; gap: 10px;
        margin-top: 22px; padding-top: 18px;
        border-top: 1px solid #3E272310;
    }
    .btn-submit {
        display: inline-flex; align-items: center; gap: 8px;
        background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
        color: #fff;
        padding: 11px 22px; font-size: 13px; font-weight: 600;
        border: none; border-radius: 8px; cursor: pointer;
        transition: all .15s; font-family: inherit;
        box-shadow: 0 2px 6px rgba(61,155,114,0.25);
    }
    .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(76,175,130,0.4); }
    .btn-submit svg { width: 16px; height: 16px; fill: currentColor; }
    .btn-submit:disabled {
        opacity: .55; cursor: not-allowed;
        transform: none; box-shadow: none;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
    .btn-submit .icon-spin {
        animation: spin .7s linear infinite;
        display: none;
    }
    .btn-cancel {
        display: inline-flex; align-items: center;
        background: #f3f4f6; color: #374151;
        padding: 11px 18px; font-size: 13px; font-weight: 600;
        border-radius: 8px; text-decoration: none;
        transition: background .15s;
    }
    .btn-cancel:hover { background: #e5e7eb; }
</style>
@endpush

@section('content')

<a href="{{ route('orangtua.konseling') }}" class="back-link">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M7.28 7.72a.75.75 0 0 1 0 1.06l-2.47 2.47H21a.75.75 0 0 1 0 1.5H4.81l2.47 2.47a.75.75 0 1 1-1.06 1.06l-3.75-3.75a.75.75 0 0 1 0-1.06l3.75-3.75a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/></svg>
    Kembali ke Jadwal Konseling
</a>

<div class="info-alert">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd"/></svg>
    <div>
        Konseling dapat dijadwalkan pada hari kerja (Senin – Jumat) pukul 08:00 – 15:00.
        Setelah pengajuan disetujui, Anda akan mendapat notifikasi melalui SMS dan email.
    </div>
</div>

<form action="{{ route('orangtua.ajukan_konseling') }}" method="POST" class="form-card" id="ajukanForm">
    @csrf
    <h3 class="form-card__title">Form Pengajuan Konseling</h3>

    <div class="form-grid">
        <div class="form-group">
            <label>Nama Anak</label>
            <input type="text" value="{{ $student?->name ?? '-' }}" readonly>
        </div>
        <div class="form-group">
            <label>Kelas</label>
            <input type="text" value="{{ $activeCt['label'] ?? '-' }}" readonly>
            <input type="hidden" name="class_term_id" value="{{ $activeCt['id'] ?? '' }}">
        </div>
        <div class="form-group">
            <label>Pilih Tanggal <span class="req">*</span></label>
            <input type="date" name="tanggal" required min="{{ date('Y-m-d') }}" value="{{ old('tanggal') }}">
        </div>
        <div class="form-group">
            <label>Guru BK <span class="req">*</span></label>
            <select name="teacher_id" required>
                <option value="" disabled selected>-- Pilih Guru BK --</option>
                @foreach ($guruBK as $g)
                    <option value="{{ $g['id'] }}" {{ old('teacher_id') == $g['id'] ? 'selected' : '' }}>{{ $g['nama'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Jam Mulai <span class="req">*</span></label>
            <input type="time" name="waktu_mulai" required>
        </div>
        <div class="form-group">
            <label>Jam Selesai <span class="req">*</span></label>
            <input type="time" name="waktu_selesai" required>
        </div>
        <div class="form-group form-group--full">
            <label>Topik / Permasalahan yang Ingin Dibahas <span class="req">*</span></label>
            <textarea name="topik" placeholder="Jelaskan topik atau permasalahan yang ingin dikonsultasikan..." required></textarea>
            <div class="form-hint">Deskripsikan secara singkat agar guru BK dapat mempersiapkan materi konseling.</div>
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('orangtua.konseling') }}" class="btn-cancel">Batal</a>
        <button type="submit" class="btn-submit" id="submitBtn">
            <svg class="icon-default" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd"/></svg>
            <svg class="icon-spin" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="9" fill="none" stroke="white" stroke-width="2.5"
                    stroke-dasharray="28" stroke-dashoffset="10"/>
            </svg>
            <span id="btnLabel">Ajukan Konseling</span>
        </button>
    </div>
</form>

@endsection

@push('scripts')
<script>
    const ajukanForm  = document.getElementById('ajukanForm');
    const submitBtn   = document.getElementById('submitBtn');
    const btnLabel    = document.getElementById('btnLabel');
    const iconDefault = submitBtn?.querySelector('.icon-default');
    const iconSpin    = submitBtn?.querySelector('.icon-spin');

    ajukanForm?.addEventListener('submit', function () {
        if (submitBtn.disabled) return;
        submitBtn.disabled        = true;
        iconDefault.style.display = 'none';
        iconSpin.style.display    = '';
        btnLabel.textContent      = 'Mengajukan...';
    });

    // Restore saat kembali via tombol Back browser
    window.addEventListener('pageshow', function (e) {
        if (e.persisted && submitBtn) {
            submitBtn.disabled        = false;
            iconDefault.style.display = '';
            iconSpin.style.display    = 'none';
            btnLabel.textContent      = 'Ajukan Konseling';
        }
    });
</script>
@endpush
