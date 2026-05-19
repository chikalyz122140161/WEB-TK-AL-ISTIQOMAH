@extends('layouts.app')
@php $userRole = 'Orang Tua'; @endphp

@section('title', 'Edit Pengajuan Konseling - SISTEM BK TK AL-ISTIQOMAH')
@section('page_title', 'Edit Pengajuan Konseling')

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
        background: rgba(255,241,118,0.18);
        border: 1px solid #e6db00;
        border-radius: 8px;
        padding: 14px 16px;
        margin-bottom: 18px;
        display: flex; align-items: flex-start; gap: 10px;
        font-size: 13px; color: #5D4037; line-height: 1.55;
    }
    .info-alert svg { width: 18px; height: 18px; fill: #b8860b; flex-shrink: 0; margin-top: 2px; }

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

@php
    $wParts   = explode(' - ', $jadwal['waktu']);
    $wMulai   = trim($wParts[0] ?? '');
    $wSelesai = trim($wParts[1] ?? '');
@endphp

<a href="{{ route('orangtua.konseling') }}" class="back-link">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M7.28 7.72a.75.75 0 0 1 0 1.06l-2.47 2.47H21a.75.75 0 0 1 0 1.5H4.81l2.47 2.47a.75.75 0 1 1-1.06 1.06l-3.75-3.75a.75.75 0 0 1 0-1.06l3.75-3.75a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/></svg>
    Kembali ke Jadwal Konseling
</a>

<div class="info-alert">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 1.999-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.501-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd"/></svg>
    <div>Anda sedang mengedit pengajuan konseling yang masih berstatus <strong>Menunggu</strong>.
    Perubahan akan menggantikan data pengajuan sebelumnya.</div>
</div>

<form action="{{ route('orangtua.konseling.update', $jadwal['id']) }}" method="POST" class="form-card">
    @csrf
    @method('PUT')
    <h3 class="form-card__title">Edit Pengajuan Konseling</h3>

    <div class="form-grid">
        <div class="form-group">
            <label>Nama Anak</label>
            <input type="text" value="{{ $student?->name ?? '-' }}" readonly>
        </div>
        <div class="form-group">
            <label>Kelas</label>
            <input type="text" value="{{ $activeCt['label'] ?? '-' }}" readonly>
        </div>
        <div class="form-group">
            <label>Pilih Tanggal <span class="req">*</span></label>
            <input type="date" name="tanggal" required
                   value="{{ old('tanggal', $jadwal['tanggal_sort'] ?? '') }}"
                   min="{{ date('Y-m-d') }}">
        </div>
        <div class="form-group">
            <label>Guru BK <span class="req">*</span></label>
            <select name="teacher_id" required>
                <option value="" disabled>-- Pilih Guru BK --</option>
                @foreach ($guruBK as $g)
                    <option value="{{ $g['id'] }}"
                        {{ old('teacher_id', $jadwal['teacher_id'] ?? '') == $g['id'] ? 'selected' : '' }}>
                        {{ $g['nama'] }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Jam Mulai <span class="req">*</span></label>
            <input type="time" name="waktu_mulai" required value="{{ old('waktu_mulai', $wMulai) }}">
        </div>
        <div class="form-group">
            <label>Jam Selesai <span class="req">*</span></label>
            <input type="time" name="waktu_selesai" required value="{{ old('waktu_selesai', $wSelesai) }}">
        </div>
        <div class="form-group form-group--full">
            <label>Topik / Permasalahan yang Ingin Dibahas <span class="req">*</span></label>
            <textarea name="topik" placeholder="Jelaskan topik atau permasalahan yang ingin dikonsultasikan..." required>{{ old('topik', $jadwal['topik']) }}</textarea>
            <div class="form-hint">Deskripsikan secara singkat agar guru BK dapat mempersiapkan materi konseling.</div>
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('orangtua.konseling') }}" class="btn-cancel">Batal</a>
        <button type="submit" class="btn-submit">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 0 1 1.04-.208Z" clip-rule="evenodd"/></svg>
            Simpan Perubahan
        </button>
    </div>
</form>

@endsection
