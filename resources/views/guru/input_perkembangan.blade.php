@extends('layouts.app')

@section('title', 'Input Perkembangan - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Input Perkembangan Anak')

{{-- PAGE-SPECIFIC CSS --}}
@push('styles')
<style>
    /*  Form card */
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

    /* Penilaian section header */
    .penilaian-header {
        font-size: 13px;
        font-weight: 700;
        color: #374151;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin: 0 0 20px;
        padding: 0 0 10px;
        border-bottom: 2px solid #fb923c;
        display: inline-block;
    }

    /*  Single development area block  */
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

    /* Radio row  */
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

    /* Bottom action bar  */
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
        cursor: pointer;
        transition: background .15s, border-color .15s;
    }
    .btn-cancel:hover { background: #F3F4F6; border-color: #9CA3AF; }
</style>
@endpush

{{-- SIDEBAR --}}
@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

{{-- CONTENT --}}
@section('content')

    {{-- Title --}}
    <h2 style="margin:0 0 20px;font-size:20px;font-weight:700;color:#111827;text-transform:uppercase;letter-spacing:.5px;">
        Input Perkembangan Anak
    </h2>

    <form method="POST" action="{{ route('guru.store_input_perkembangan') }}">
        @csrf

        {{-- Card 1: Data Dasar  --}}
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

        {{--  Card 2: Penilaian Perkembangan  --}}
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

        {{--  Action buttons --}}
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
