@extends('layouts.app')

@section('title', ($hasReport ? 'Edit' : 'Input') . ' Nilai Rapot - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Rapot Semester')

@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

@push('styles')
<style>
    .back-link {
        display: inline-flex; align-items: center; gap: 7px;
        color: #3E2723; font-size: 13px; font-weight: 500;
        text-decoration: none; margin-bottom: 20px; transition: color 0.2s;
    }
    .back-link:hover { color: #3D9B72; }
    .back-link svg { width: 15px; height: 15px; fill: currentColor; }

    /* Student header */
    .student-banner {
        background: linear-gradient(135deg, #3E2723 0%, #2E8B60 100%);
        border-radius: 12px; padding: 20px 24px; margin-bottom: 22px;
        display: flex; align-items: center; gap: 16px; flex-wrap: wrap;
    }
    .student-avatar {
        width: 52px; height: 52px; border-radius: 50%;
        background: rgba(255,255,255,0.2);
        color: #fff; font-size: 20px; font-weight: 700;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .student-banner__info { flex: 1; }
    .student-banner__name { color: #fff; font-size: 17px; font-weight: 700; margin: 0 0 4px; }
    .student-banner__meta { display: flex; flex-wrap: wrap; gap: 14px; }
    .student-banner__meta span {
        color: rgba(255,255,255,0.8); font-size: 12px;
        display: flex; align-items: center; gap: 5px;
    }
    .student-banner__meta svg { width: 12px; height: 12px; fill: rgba(255,255,255,0.6); }
    .mode-pill {
        padding: 5px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;
    }
    .mode-pill--input { background: #fef9c3; color: #854d0e; }
    .mode-pill--edit  { background: #dcfce7; color: #166534; }

    /* Legend */
    .legend-bar {
        display: flex; flex-wrap: wrap; gap: 14px;
        background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px;
        padding: 10px 16px; margin-bottom: 20px; font-size: 12px; color: #3E2723;
    }
    .legend-bar span { display: flex; align-items: center; gap: 6px; }
    .legend-dot { width: 9px; height: 9px; border-radius: 50%; }
    .ld-bb  { background: #f87171; }
    .ld-mb  { background: #facc15; }
    .ld-bsh { background: #4ade80; }
    .ld-bsb { background: #22c55e; }

    /* Section card */
    .form-section {
        background: #fff; border: 1px solid #e7e5e4;
        border-radius: 12px; margin-bottom: 18px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04); overflow: hidden;
    }
    .form-section__head {
        background: linear-gradient(135deg, #3D9B72 0%, #2E8B60 100%);
        padding: 13px 20px; display: flex; align-items: center; gap: 10px;
    }
    .form-section__head svg { width: 18px; height: 18px; fill: rgba(255,255,255,0.85); }
    .form-section__title { color: #fff; font-size: 14px; font-weight: 600; margin: 0; }

    .form-section__body { padding: 20px; }

    /* Subject row */
    .subject-row {
        background: #f9fafb; border: 1px solid #e7e5e4;
        border-radius: 8px; padding: 14px 16px; margin-bottom: 12px;
    }
    .subject-row:last-child { margin-bottom: 0; }
    .subject-row__label {
        font-size: 13px; font-weight: 600; color: #3E2723; margin-bottom: 10px;
        display: flex; align-items: center; gap: 6px;
    }
    .subject-row__label .counter {
        width: 20px; height: 20px; border-radius: 50%;
        background: linear-gradient(135deg, #3D9B72, #2E8B60);
        color: #fff; font-size: 10px; font-weight: 700;
        display: inline-flex; align-items: center; justify-content: center;
    }
    .subject-row__fields { display: flex; gap: 12px; flex-wrap: wrap; }
    .field-level { min-width: 160px; flex-shrink: 0; }
    .field-catatan { flex: 1; min-width: 180px; }

    /* Extracurricular / Counseling group */
    .group-box {
        border: 1px solid #e7e5e4; border-radius: 8px;
        margin-bottom: 12px; overflow: hidden;
    }
    .group-box:last-child { margin-bottom: 0; }
    .group-box__head {
        background: #f9fafb; padding: 10px 14px;
        font-size: 13px; font-weight: 600; color: #3E2723;
        display: flex; align-items: center; gap: 7px;
        border-bottom: 1px solid #e7e5e4;
    }
    .group-box__head svg { width: 14px; height: 14px; fill: #3D9B72; }
    .group-box__body { padding: 14px; display: flex; flex-direction: column; gap: 10px; }

    .assessment-row {
        display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
    }
    .assessment-row__label {
        flex: 1; min-width: 130px; font-size: 13px; color: #57534e;
    }
    .assessment-row__select { min-width: 140px; }

    /* Form controls */
    label.lbl {
        display: block; font-size: 11px; font-weight: 600;
        color: #6b7280; text-transform: uppercase; letter-spacing: 0.03em;
        margin-bottom: 5px;
    }
    select.form-select, textarea.form-textarea {
        width: 100%; padding: 8px 11px; font-size: 13px;
        border: 1px solid #e7e5e4; border-radius: 7px;
        background: #fff; color: #3E2723; outline: none;
        box-sizing: border-box; transition: border-color 0.15s, box-shadow 0.15s;
    }
    select.form-select:focus, textarea.form-textarea:focus {
        border-color: #3D9B72; box-shadow: 0 0 0 3px rgba(61,155,114,0.12);
    }
    textarea.form-textarea { resize: vertical; min-height: 60px; }

    /* Level badge colors */
    select.form-select option[value="BB"]  { color: #dc2626; }
    select.form-select option[value="MB"]  { color: #ca8a04; }
    select.form-select option[value="BSH"] { color: #16a34a; }
    select.form-select option[value="BSB"] { color: #15803d; }

    /* Level highlight on select */
    select.lv-bb  { border-color: #fca5a5; background: #fff5f5; color: #dc2626; }
    select.lv-mb  { border-color: #fde68a; background: #fffdf0; color: #ca8a04; }
    select.lv-bsh { border-color: #86efac; background: #f0fff4; color: #16a34a; }
    select.lv-bsb { border-color: #4ade80; background: #f0fff4; color: #15803d; }

    /* Catatan guru */
    .catatan-wrap { margin-top: 4px; }

    /* Sticky submit bar */
    .submit-bar {
        position: sticky; bottom: 0; z-index: 10;
        background: rgba(255,255,255,0.95); backdrop-filter: blur(4px);
        border-top: 1px solid #e7e5e4;
        padding: 14px 0; margin-top: 24px;
        display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
    }
    .btn-save {
        display: inline-flex; align-items: center; gap: 7px;
        background: linear-gradient(135deg, #3D9B72 0%, #2E8B60 100%);
        color: #fff; padding: 10px 22px; font-size: 14px; font-weight: 600;
        border: none; border-radius: 9px; cursor: pointer; transition: all 0.2s;
        box-shadow: 0 3px 8px rgba(61,155,114,0.3);
    }
    .btn-save:hover { transform: translateY(-1px); box-shadow: 0 5px 14px rgba(61,155,114,0.4); }
    .btn-save svg { width: 16px; height: 16px; fill: currentColor; }
    .btn-cancel {
        display: inline-flex; align-items: center; gap: 7px;
        background: #f3f4f6; color: #374151;
        padding: 10px 18px; font-size: 14px; font-weight: 600;
        border: none; border-radius: 9px; cursor: pointer;
        text-decoration: none; transition: background 0.2s;
    }
    .btn-cancel:hover { background: #e5e7eb; }
</style>
@endpush

@section('content')
    <a href="{{ route('guru.rapot.show', $classTerm['id']) }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M7.28 7.72a.75.75 0 0 1 0 1.06l-2.47 2.47H21a.75.75 0 0 1 0 1.5H4.81l2.47 2.47a.75.75 0 1 1-1.06 1.06l-3.75-3.75a.75.75 0 0 1 0-1.06l3.75-3.75a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/></svg>
        Kembali ke Daftar Siswa
    </a>

    {{-- Student header --}}
    <div class="student-banner">
        <div class="student-avatar">{{ strtoupper(substr($student['nama'], 0, 1)) }}</div>
        <div class="student-banner__info">
            <h2 class="student-banner__name">{{ $student['nama'] }}</h2>
            <div class="student-banner__meta">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 4.8 11.06a.75.75 0 0 1-.231-1.337A60.65 60.65 0 0 1 11.7 2.805Z"/></svg>
                    Kelas {{ $classTerm['kelas_nama'] }}
                </span>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
                    {{ $classTerm['tahun_ajaran'] }} — {{ ucfirst($classTerm['semester']) }}
                </span>
                <span>NIS {{ $student['nis'] }}</span>
            </div>
        </div>
        <span class="mode-pill {{ $hasReport ? 'mode-pill--edit' : 'mode-pill--input' }}">
            {{ $hasReport ? 'Mode Edit' : 'Input Baru' }}
        </span>
    </div>

    {{-- Level legend --}}
    <div class="legend-bar">
        <span><span class="legend-dot ld-bb"></span> <strong>BB</strong> = Belum Berkembang</span>
        <span><span class="legend-dot ld-mb"></span> <strong>MB</strong> = Mulai Berkembang</span>
        <span><span class="legend-dot ld-bsh"></span> <strong>BSH</strong> = Berkembang Sesuai Harapan</span>
        <span><span class="legend-dot ld-bsb"></span> <strong>BSB</strong> = Berkembang Sangat Baik</span>
    </div>

    <form action="{{ route('guru.rapot.siswa.save', [$classTerm['id'], $student['id']]) }}" method="POST" id="rapotForm">
        @csrf

        {{-- ── 1. Mata Pelajaran ─────────────────────────────────────────── --}}
        <div class="form-section">
            <div class="form-section__head">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z"/></svg>
                <h3 class="form-section__title">Mata Pelajaran</h3>
            </div>
            <div class="form-section__body">
                @foreach ($subjects as $i => $sub)
                    @php
                        $subScore = $scores['subjects'][$sub['id']] ?? ['level' => null, 'catatan' => ''];
                        $lvl      = $subScore['level'] ?? '';
                        $lvCls    = $lvl ? 'lv-' . strtolower($lvl) : '';
                    @endphp
                    <div class="subject-row">
                        <div class="subject-row__label">
                            <span class="counter">{{ $i + 1 }}</span>
                            {{ $sub['nama'] }}
                        </div>
                        <div class="subject-row__fields">
                            <div class="field-level">
                                <label class="lbl">Level Pencapaian</label>
                                <select name="subjects[{{ $sub['id'] }}][level]"
                                        class="form-select {{ $lvCls }}"
                                        onchange="updateSelectStyle(this)">
                                    <option value="">-- Pilih --</option>
                                    <option value="BB"  {{ $lvl === 'BB'  ? 'selected' : '' }}>BB — Belum Berkembang</option>
                                    <option value="MB"  {{ $lvl === 'MB'  ? 'selected' : '' }}>MB — Mulai Berkembang</option>
                                    <option value="BSH" {{ $lvl === 'BSH' ? 'selected' : '' }}>BSH — Berkembang Sesuai Harapan</option>
                                    <option value="BSB" {{ $lvl === 'BSB' ? 'selected' : '' }}>BSB — Berkembang Sangat Baik</option>
                                </select>
                            </div>
                            <div class="field-catatan">
                                <label class="lbl">Catatan (opsional)</label>
                                <textarea name="subjects[{{ $sub['id'] }}][catatan]"
                                          class="form-textarea"
                                          placeholder="Deskripsi perkembangan...">{{ $subScore['catatan'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ── 2. Ekstrakurikuler ────────────────────────────────────────── --}}
        @if (count($extracurriculars) > 0)
        <div class="form-section">
            <div class="form-section__head">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Z" clip-rule="evenodd"/></svg>
                <h3 class="form-section__title">Ekstrakurikuler</h3>
            </div>
            <div class="form-section__body">
                @foreach ($extracurriculars as $ext)
                    <div class="group-box">
                        <div class="group-box__head">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M4.5 5.653c0-1.427 1.529-2.33 2.779-1.643l11.54 6.347c1.295.712 1.295 2.573 0 3.286L7.28 19.99c-1.25.687-2.779-.217-2.779-1.643V5.653Z" clip-rule="evenodd"/></svg>
                            {{ $ext['nama'] }}
                        </div>
                        <div class="group-box__body">
                            @foreach ($ext['assessments'] as $ea)
                                @php
                                    $eaLvl = $scores['extracurriculars'][$ea['id']] ?? null;
                                    $eaCls = $eaLvl ? 'lv-' . strtolower($eaLvl) : '';
                                @endphp
                                <div class="assessment-row">
                                    <div class="assessment-row__label">{{ $ea['nama'] }}</div>
                                    <div class="assessment-row__select">
                                        <select name="extracurriculars[{{ $ea['id'] }}]"
                                                class="form-select {{ $eaCls }}"
                                                onchange="updateSelectStyle(this)">
                                            <option value="">-- Pilih --</option>
                                            <option value="BB"  {{ $eaLvl === 'BB'  ? 'selected' : '' }}>BB</option>
                                            <option value="MB"  {{ $eaLvl === 'MB'  ? 'selected' : '' }}>MB</option>
                                            <option value="BSH" {{ $eaLvl === 'BSH' ? 'selected' : '' }}>BSH</option>
                                            <option value="BSB" {{ $eaLvl === 'BSB' ? 'selected' : '' }}>BSB</option>
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ── 3. Bimbingan Konseling ────────────────────────────────────── --}}
        @if (count($counselings) > 0)
        <div class="form-section">
            <div class="form-section__head">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M4.804 21.644A6.707 6.707 0 0 0 6 21.75a6.721 6.721 0 0 0 3.583-1.029c.774.182 1.584.279 2.417.279 5.322 0 9.75-3.97 9.75-9 0-5.03-4.428-9-9.75-9s-9.75 3.97-9.75 9c0 2.09.768 4.04 2.084 5.558a8.96 8.96 0 0 1-1.603 2.596.75.75 0 0 0 .53 1.28 6.72 6.72 0 0 0 1.543-.09Z" clip-rule="evenodd"/></svg>
                <h3 class="form-section__title">Bimbingan Konseling</h3>
            </div>
            <div class="form-section__body">
                @foreach ($counselings as $con)
                    <div class="group-box">
                        <div class="group-box__head">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd"/></svg>
                            {{ $con['nama'] }}
                        </div>
                        <div class="group-box__body">
                            @foreach ($con['assessments'] as $ca)
                                @php
                                    $caLvl = $scores['counseling'][$ca['id']] ?? null;
                                    $caCls = $caLvl ? 'lv-' . strtolower($caLvl) : '';
                                @endphp
                                <div class="assessment-row">
                                    <div class="assessment-row__label">{{ $ca['nama'] }}</div>
                                    <div class="assessment-row__select">
                                        <select name="counseling[{{ $ca['id'] }}]"
                                                class="form-select {{ $caCls }}"
                                                onchange="updateSelectStyle(this)">
                                            <option value="">-- Pilih --</option>
                                            <option value="BB"  {{ $caLvl === 'BB'  ? 'selected' : '' }}>BB</option>
                                            <option value="MB"  {{ $caLvl === 'MB'  ? 'selected' : '' }}>MB</option>
                                            <option value="BSH" {{ $caLvl === 'BSH' ? 'selected' : '' }}>BSH</option>
                                            <option value="BSB" {{ $caLvl === 'BSB' ? 'selected' : '' }}>BSB</option>
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ── 4. Catatan Guru ───────────────────────────────────────────── --}}
        <div class="form-section">
            <div class="form-section__head">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z"/><path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z"/></svg>
                <h3 class="form-section__title">Catatan Guru</h3>
            </div>
            <div class="form-section__body">
                <label class="lbl">Catatan perkembangan umum siswa (opsional)</label>
                <textarea name="catatan_guru"
                          class="form-textarea catatan-wrap"
                          style="min-height:90px"
                          placeholder="Tulis catatan perkembangan siswa selama semester ini...">{{ $scores['catatan_guru'] ?? '' }}</textarea>
            </div>
        </div>

        {{-- Submit bar --}}
        <div class="submit-bar">
            <button type="submit" class="btn-save">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/></svg>
                {{ $hasReport ? 'Perbarui Nilai' : 'Simpan Nilai' }}
            </button>
            <a href="{{ route('guru.rapot.show', $classTerm['id']) }}" class="btn-cancel">Batal</a>
        </div>
    </form>
@endsection

@push('scripts')
<script>
const levelClasses = { BB: 'lv-bb', MB: 'lv-mb', BSH: 'lv-bsh', BSB: 'lv-bsb' };

function updateSelectStyle(el) {
    el.classList.remove('lv-bb', 'lv-mb', 'lv-bsh', 'lv-bsb');
    if (el.value && levelClasses[el.value]) {
        el.classList.add(levelClasses[el.value]);
    }
}

document.querySelectorAll('select.form-select').forEach(function(el) {
    updateSelectStyle(el);
});
</script>
@endpush
