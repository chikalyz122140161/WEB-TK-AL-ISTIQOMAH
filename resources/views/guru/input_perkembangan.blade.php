@extends('layouts.app')

@section('title', 'Input Perkembangan - SISTEM BK TK AL-ISTIQOMAH')
@section('page_title', 'Input Perkembangan Anak')

{{-- PAGE-SPECIFIC CSS --}}
@push('styles')
<style>
    /* ── Form card ─────────────────────────────────────── */
    .form-card {
        background: #fff;
        border: 1px solid #E5E7EB;
        border-radius: 12px;
        padding: 28px 32px;
        margin-bottom: 24px;
    }
    .form-card__title {
        font-size: 16px;
        font-weight: 700;
        color: #111827;
        margin: 0 0 24px;
        padding-bottom: 14px;
        border-bottom: 1px solid #F3F4F6;
        letter-spacing: .3px;
        text-transform: uppercase;
    }

    /* ── Field group ────────────────────────────────────── */
    .field-group {
        display: flex;
        flex-direction: column;
        gap: 4px;
        margin-bottom: 18px;
    }
    .field-group:last-child { margin-bottom: 0; }
    .field-label {
        font-size: 11px;
        font-weight: 700;
        color: #6B7280;
        letter-spacing: .5px;
        text-transform: uppercase;
    }
    .field-control {
        width: 100%;
        height: 42px;
        padding: 0 12px;
        font-size: 14px;
        color: #111827;
        background: #F9FAFB;
        border: 1px solid #E5E7EB;
        border-radius: 8px;
        outline: none;
        font-family: inherit;
        box-sizing: border-box;
        transition: border-color .15s;
    }
    .field-control:focus {
        border-color: #63E6BE;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(99,230,190,.15);
    }
    select.field-control { cursor: pointer; }
    textarea.field-control {
        height: 80px;
        padding: 10px 12px;
        resize: vertical;
        line-height: 1.5;
    }

    /* ── Penilaian section header ───────────────────────── */
    .penilaian-header {
        font-size: 13px;
        font-weight: 700;
        color: #374151;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin: 0 0 20px;
        padding: 0 0 10px;
        border-bottom: 2px solid #63E6BE;
        display: inline-block;
    }

    /* ── Single development area block ─────────────────── */
    .dev-block {
        margin-bottom: 22px;
        padding-bottom: 22px;
        border-bottom: 1px solid #F3F4F6;
    }
    .dev-block:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    .dev-block__title {
        font-size: 13px;
        font-weight: 700;
        color: #111827;
        text-transform: uppercase;
        letter-spacing: .3px;
        margin-bottom: 10px;
    }
    .dev-block__title span {
        color: #65A98F;
        font-weight: 800;
        margin-right: 4px;
    }

    /* ── Radio row ─────────────────────────────────────── */
    .radio-row {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 10px;
    }
    .radio-row label {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
        color: #374151;
        cursor: pointer;
        font-weight: 500;
    }
    .radio-row input[type="radio"] {
        width: 15px;
        height: 15px;
        accent-color: #065F46;
        cursor: pointer;
    }

    /* ── Bottom action bar ──────────────────────────────── */
    .form-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        padding-top: 4px;
    }
    .btn-save {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        height: 40px;
        padding: 0 24px;
        background: #065F46;
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        letter-spacing: .3px;
        transition: background .15s;
    }
    .btn-save:hover { background: #064E3B; }
    .btn-cancel {
        display: inline-flex;
        align-items: center;
        height: 40px;
        padding: 0 24px;
        background: #fff;
        color: #374151;
        font-size: 14px;
        font-weight: 600;
        border: 1px solid #D1D5DB;
        border-radius: 8px;
        cursor: pointer;
        transition: background .15s, border-color .15s;
    }
    .btn-cancel:hover { background: #F3F4F6; border-color: #9CA3AF; }
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

    <a href="{{ route('guru.input_perkembangan') }}" class="sidebar__item active">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z"/><path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z"/></svg>
        Input Perkembangan
    </a>
    <a href="#" class="sidebar__item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75ZM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 0 1-1.875-1.875V8.625ZM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 0 1 3 19.875v-6.75Z"/></svg>
        Grafik
    </a>
    <a href="#" class="sidebar__item">
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

    {{-- Title --}}
    <h2 style="margin:0 0 20px;font-size:20px;font-weight:700;color:#111827;text-transform:uppercase;letter-spacing:.5px;">
        Input Perkembangan Anak
    </h2>

    <form method="POST" action="{{ route('guru.input_perkembangan.store') }}">
        @csrf

        {{-- ── Card 1: Data Dasar ──────────────────────────────── --}}
        <div class="form-card">

            <div class="field-group">
                <label class="field-label" for="siswa_id">Pilih Siswa</label>
                <select class="field-control" id="siswa_id" name="siswa_id" required>
                    <option value="" disabled selected>-- Pilih Siswa --</option>
                    @foreach ($daftarSiswa ?? [] as $siswa)
                        <option value="{{ $siswa['id'] }}">{{ $siswa['nama'] }}</option>
                    @endforeach
                    {{-- Dummy options kalau belum ada data --}}
                    @if (empty($daftarSiswa))
                        <option value="1">Ahmad Rizky</option>
                        <option value="2">Anisa Putri</option>
                        <option value="3">Muhammad Fauzi</option>
                        <option value="4">Tika Rahayu</option>
                        <option value="5">Siti Aisyah</option>
                    @endif
                </select>
            </div>

            <div class="field-group">
                <label class="field-label" for="minggu_ke">Minggu Ke</label>
                <input
                    class="field-control"
                    type="number"
                    id="minggu_ke"
                    name="minggu_ke"
                    min="1"
                    max="52"
                    placeholder="Contoh: 12"
                    required
                >
            </div>

            <div class="field-group">
                <label class="field-label" for="tanggal">[Input] Tanggal</label>
                <input
                    class="field-control"
                    type="date"
                    id="tanggal"
                    name="tanggal"
                    value="{{ date('Y-m-d') }}"
                    required
                >
            </div>
        </div>

        {{-- ── Card 2: Penilaian Perkembangan ─────────────────── --}}
        <div class="form-card">
            <p class="form-card__title">Penilaian Perkembangan (Skala 1-5)</p>

            @php
                $aspek = [
                    ['key' => 'fisik_motorik',      'num' => '1', 'label' => 'Fisik-Motorik'],
                    ['key' => 'kognitif',            'num' => '2', 'label' => 'Kognitif'],
                    ['key' => 'bahasa',              'num' => '3', 'label' => 'Bahasa'],
                    ['key' => 'sosial_emosional',    'num' => '4', 'label' => 'Sosial-Emosional'],
                    ['key' => 'nilai_agama_moral',   'num' => '5', 'label' => 'Nilai Agama & Moral'],
                    ['key' => 'seni',                'num' => '6', 'label' => 'Seni'],
                ];
            @endphp

            @foreach ($aspek as $a)
            <div class="dev-block">
                <div class="dev-block__title">
                    <span>{{ $a['num'] }}.</span>{{ strtoupper($a['label']) }}
                </div>
                <div class="radio-row">
                    @for ($i = 1; $i <= 5; $i++)
                    <label>
                        <input type="radio" name="nilai_{{ $a['key'] }}" value="{{ $i }}" required>
                        {{ $i }}
                    </label>
                    @endfor
                </div>
                <div class="field-group" style="margin-bottom:0;">
                    <textarea
                        class="field-control"
                        name="catatan_{{ $a['key'] }}"
                        placeholder="[TEXTAREA] Catatan perkembangan {{ strtolower($a['label']) }}..."
                        rows="3"
                    ></textarea>
                </div>
            </div>
            @endforeach
        </div>

        {{-- ── Action buttons ──────────────────────────────────── --}}
        <div class="form-actions">
            <button type="submit" class="btn-save">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:16px;height:16px;">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd"/>
                </svg>
                SIMPAN
            </button>
            <a href="{{ route('guru.dashboard') }}" class="btn-cancel">BATAL</a>
        </div>

    </form>

@endsection
