@extends('layouts.app')

@section('title', 'Edit Laporan Perkembangan - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Edit Laporan Perkembangan')

@push('styles')
<style>
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
        font-weight: 500;
        color: #475d5b;
        margin-bottom: 20px;
        transition: color 0.2s;
        text-decoration: none;
    }
    .back-link:hover { color: #00473e; }
    .back-link svg { width: 16px; height: 16px; fill: currentColor; }

    /*  Form card */
    .form-card {
        background: #fff;
        border: 1px solid #E5E7EB;
        border-radius: 12px;
        padding: 28px 32px;
        margin-bottom: 24px;
    }
    .form-card__title {
        font-size: 14px;
        font-weight: 700;
        color: #111827;
        margin: 0 0 24px;
        padding-bottom: 12px;
        border-bottom: 2px solid #fb923c;
        letter-spacing: .3px;
        text-transform: uppercase;
        display: inline-block;
    }

    /*  Field group */
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
        border-color: #fb923c;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(251,146,60,.15);
    }
    select.field-control { cursor: pointer; }
    textarea.field-control {
        height: 80px;
        padding: 10px 12px;
        resize: vertical;
        line-height: 1.5;
    }
    .field-control[type="number"] {
        -moz-appearance: textfield;
        appearance: textfield;
    }
    .field-control[type="number"]::-webkit-outer-spin-button,
    .field-control[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Two-column grid */
    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    @media (max-width: 640px) { .form-grid-2 { grid-template-columns: 1fr; } }

    /* Dev block */
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
        color: #f97316;
        font-weight: 800;
        margin-right: 4px;
    }

    /* Radio row */
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
        accent-color: #f97316;
        cursor: pointer;
    }

    /* Action buttons */
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
        background: #f97316;
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        letter-spacing: .3px;
        transition: background .15s;
    }
    .btn-save:hover { background: #ea580c; }
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
        text-decoration: none;
        transition: background .15s, border-color .15s;
    }
    .btn-cancel:hover { background: #F3F4F6; border-color: #9CA3AF; }
</style>
@endpush

@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

@section('content')

    <a href="{{ route('guru.laporan_bk') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M17 10a.75.75 0 0 1-.75.75H5.612l4.158 3.96a.75.75 0 1 1-1.04 1.08l-5.5-5.25a.75.75 0 0 1 0-1.08l5.5-5.25a.75.75 0 1 1 1.04 1.08L5.612 9.25H16.25A.75.75 0 0 1 17 10Z" clip-rule="evenodd"/></svg>
        Kembali ke Laporan Perkembangan
    </a>

    <h2 style="margin:0 0 20px;font-size:20px;font-weight:700;color:#111827;text-transform:uppercase;letter-spacing:.5px;">
        Edit Laporan Perkembangan
    </h2>

    <form method="POST" action="{{ route('guru.laporan_bk.update', $laporan['id']) }}">
        @csrf
        @method('PUT')

        {{-- Card 1: Data Dasar --}}
        <div class="form-card">
            <p class="form-card__title">Data Dasar</p>

            <div class="field-group">
                <label class="field-label" for="siswa_id">Siswa</label>
                <select class="field-control" id="siswa_id" name="siswa_id" required>
                    @foreach ($daftarSiswa as $s)
                        <option value="{{ $s['id'] }}" {{ $s['id'] == $laporan['siswa_id'] ? 'selected' : '' }}>
                            {{ $s['nama'] }} — {{ $s['kelas'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-grid-2">
                <div class="field-group">
                    <label class="field-label" for="tahun_ajaran">Tahun Ajaran</label>
                    <input
                        class="field-control"
                        type="number"
                        id="tahun_ajaran"
                        name="tahun_ajaran"
                        min="2000"
                        max="2100"
                        value="{{ $laporan['tahun_ajaran'] }}"
                        required
                    >
                </div>
                <div class="field-group">
                    <label class="field-label" for="semester">Semester</label>
                    <select class="field-control" id="semester" name="semester" required>
                        <option value="Ganjil" {{ $laporan['semester'] == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                        <option value="Genap"  {{ $laporan['semester'] == 'Genap'  ? 'selected' : '' }}>Genap</option>
                    </select>
                </div>
            </div>

            <div class="form-grid-2">
                <div class="field-group">
                    <label class="field-label" for="minggu_ke">Minggu Ke</label>
                    <input
                        class="field-control"
                        type="number"
                        id="minggu_ke"
                        name="minggu_ke"
                        min="1"
                        max="52"
                        value="{{ $laporan['minggu'] }}"
                        required
                    >
                </div>
                <div class="field-group">
                    <label class="field-label" for="tanggal">Tanggal</label>
                    <input
                        class="field-control"
                        type="date"
                        id="tanggal"
                        name="tanggal"
                        value="{{ $laporan['tanggal'] }}"
                        required
                    >
                </div>
            </div>
        </div>

        {{-- Card 2: Penilaian Perkembangan --}}
        <div class="form-card">
            <p class="form-card__title">Penilaian Perkembangan (Skala 1–5)</p>

            @php
                $aspek = [
                    ['key' => 'fisik_motorik',    'num' => '1', 'label' => 'Fisik-Motorik'],
                    ['key' => 'kognitif',          'num' => '2', 'label' => 'Kognitif'],
                    ['key' => 'bahasa',            'num' => '3', 'label' => 'Bahasa'],
                    ['key' => 'sosial_emosional',  'num' => '4', 'label' => 'Sosial-Emosional'],
                    ['key' => 'nilai_agama_moral', 'num' => '5', 'label' => 'Nilai Agama & Moral'],
                    ['key' => 'seni',              'num' => '6', 'label' => 'Seni'],
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
                        <input
                            type="radio"
                            name="nilai_{{ $a['key'] }}"
                            value="{{ $i }}"
                            {{ ($laporan['nilai'][$a['key']] ?? 0) == $i ? 'checked' : '' }}
                            required
                        >
                        {{ $i }}
                    </label>
                    @endfor
                </div>
                <div class="field-group" style="margin-bottom:0;">
                    <textarea
                        class="field-control"
                        name="catatan_{{ $a['key'] }}"
                        placeholder="Catatan perkembangan {{ strtolower($a['label']) }}..."
                        rows="3"
                    >{{ $laporan['catatan'][$a['key']] ?? '' }}</textarea>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Card 3: Catatan Umum --}}
        <div class="form-card">
            <p class="form-card__title">Catatan Umum Guru</p>
            <div class="field-group" style="margin-bottom:0;">
                <textarea
                    class="field-control"
                    name="catatan_umum"
                    rows="5"
                    placeholder="Tuliskan catatan umum tentang perkembangan anak..."
                >{{ $laporan['catatan_umum'] ?? '' }}</textarea>
            </div>
        </div>

        {{-- Action buttons --}}
        <div class="form-actions">
            <button type="submit" class="btn-save">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:16px;height:16px;">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd"/>
                </svg>
                SIMPAN PERUBAHAN
            </button>
            <a href="{{ route('guru.laporan_bk') }}" class="btn-cancel">BATAL</a>
        </div>

    </form>

@endsection
