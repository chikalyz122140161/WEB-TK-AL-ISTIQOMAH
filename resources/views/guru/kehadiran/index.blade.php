@extends('layouts.app')

@section('title', 'Kehadiran - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Catat Kehadiran')

@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

@push('styles')
<style>
    .form-section {
        background: #fff;
        border: 1px solid #3E272320;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .form-section__title {
        font-size: 16px;
        font-weight: 600;
        color: #3E2723;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 2px solid #4CAF82;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .form-section__title svg { width: 20px; height: 20px; fill: #4CAF82; }

    .filter-grid {
        display: flex;
        gap: 14px;
        align-items: flex-start;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    .filter-grid .form-group:nth-child(1) { flex: 0 0 150px; min-width: 0; }
    .filter-grid .form-group:nth-child(2) { flex: 0 0 150px; min-width: 0; }
    .filter-grid .form-group:nth-child(3) { flex: 0 0 auto; }
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .form-group label {
        font-size: 13px;
        font-weight: 600;
        color: #5D4037;
    }
    .form-group select,
    .form-group input {
        padding: 10px 12px;
        border: 1.5px solid #3E272320;
        border-radius: 8px;
        font-size: 14px;
        color: #3E2723;
        background: #FFFDE7;
        font-family: inherit;
        transition: all 0.2s;
    }
    .form-group select:focus,
    .form-group input:focus {
        outline: none;
        border-color: #4CAF82;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(76,175,130,0.15);
    }
    .btn-filter {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 18px;
        background: linear-gradient(135deg, #3D9B72 0%, #2E8B60 100%);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        font-family: inherit;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(61,155,114,0.25);
        transition: all 0.2s;
        white-space: nowrap;
    }
    .btn-filter:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(61,155,114,0.35); }
    .btn-filter svg { width: 16px; height: 16px; fill: currentColor; }

    .class-term-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, rgba(76,175,130,0.12) 0%, rgba(76,175,130,0.08) 100%);
        border: 1.5px solid rgba(76,175,130,0.25);
        border-radius: 10px;
        padding: 10px 16px;
        margin-bottom: 18px;
        font-size: 14px;
        font-weight: 600;
        color: #2E8B60;
    }
    .class-term-badge svg { width: 18px; height: 18px; fill: #4CAF82; }

    /* Attendance rows */
    .attendance-form-container { display: grid; gap: 10px; }
    .student-attendance-row {
        display: grid;
        grid-template-columns: 1.3fr auto 1fr;
        gap: 16px;
        align-items: center;
        padding: 12px 16px;
        background: #FFFDE7;
        border-radius: 8px;
        border: 1px solid #3E272315;
        transition: all 0.15s;
    }
    .student-attendance-row:hover {
        background: rgba(76,175,130,0.06);
        border-color: rgba(76,175,130,0.30);
    }
    .student-info { display: flex; align-items: center; gap: 12px; }
    .student-avatar {
        width: 38px; height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        flex-shrink: 0;
    }
    .student-name { font-weight: 600; color: #3E2723; font-size: 14px; }
    .student-sub  { font-size: 12px; color: #78716c; margin-top: 1px; }

    .status-options { display: flex; gap: 6px; }
    .status-option {
        padding: 6px 12px;
        border: 2px solid #3E272318;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s;
        background: white;
        user-select: none;
        color: #5D4037;
    }
    .status-option input[type="radio"] { display: none; }
    .status-option:hover { border-color: #4CAF82; }
    .status-option.active-hadir  { border-color: #4CAF82; background: rgba(76,175,130,0.12); color: #2E8B60; }
    .status-option.active-izin   { border-color: #d4a000; background: rgba(255,241,118,0.45); color: #7a5c00; }
    .status-option.active-sakit  { border-color: #3b82f6; background: rgba(59,130,246,0.10); color: #1d4ed8; }
    .status-option.active-alpa   { border-color: #d81b72; background: rgba(240,98,146,0.10); color: #d81b72; }
    .status-option.opt-alpa      { color: #d81b72; border-color: rgba(240,98,146,0.25); }
    .status-option.opt-alpa:hover { border-color: #d81b72; background: rgba(240,98,146,0.06); }

    .note-input {
        padding: 8px 12px;
        border: 1.5px solid #3E272318;
        border-radius: 6px;
        font-size: 13px;
        width: 100%;
        box-sizing: border-box;
        font-family: inherit;
        background: #fff;
        color: #3E2723;
    }
    .note-input:focus { outline: none; border-color: #4CAF82; }

    .btn-save {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
        color: #fff;
        padding: 11px 22px;
        font-size: 14px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        border-radius: 8px;
        box-shadow: 0 4px 14px rgba(76,175,130,0.30);
        transition: all 0.25s;
        font-family: inherit;
        margin-top: 16px;
    }
    .btn-save:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(76,175,130,0.40); }
    .btn-save svg { width: 16px; height: 16px; fill: currentColor; }

    /* Table */
    .table-wrap { overflow-x: auto; }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th, .data-table td { padding: 11px 12px; text-align: left; border-bottom: 1px solid #3E272318; }
    .data-table th { background: rgba(76,175,130,0.10); font-size: 12px; font-weight: 700; color: #3E2723; text-transform: uppercase; letter-spacing: 0.5px; }
    .data-table td { font-size: 13.5px; color: #5D4037; }
    .data-table tr:hover td { background: #FFFDE7; }

    .status-badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 20px; font-size: 12px; font-weight: 700; }
    .badge-hadir  { background: rgba(76,175,130,0.14); color: #2E8B60; }
    .badge-izin   { background: rgba(255,241,118,0.55); color: #7a5c00; }
    .badge-sakit  { background: rgba(59,130,246,0.12); color: #1d4ed8; }
    .badge-alpa   { background: rgba(240,98,146,0.12); color: #d81b72; }

    .btn-edit {
        display: inline-flex; align-items: center; gap: 5px;
        background: #FFF176; color: #3E2723; padding: 5px 10px;
        font-size: 12px; font-weight: 700; border: 1.5px solid #e6db00;
        cursor: pointer; border-radius: 6px; text-decoration: none;
        transition: all 0.15s; font-family: inherit;
    }
    .btn-edit:hover { background: #f5e800; transform: translateY(-1px); }
    .btn-edit svg { width: 13px; height: 13px; fill: #3E2723; }

    .alert-success {
        background: rgba(76,175,130,0.12); border: 1px solid rgba(76,175,130,0.30);
        color: #2E8B60; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px;
        display: flex; align-items: center; gap: 8px; font-size: 14px;
    }
    .empty-hint {
        padding: 40px 20px; text-align: center; color: #a0826d; font-size: 14px;
    }
    .empty-hint svg { width: 40px; height: 40px; fill: #d5bfba; margin-bottom: 8px; display: block; margin-left: auto; margin-right: auto; }

    @media (max-width: 768px) {
        .student-attendance-row { grid-template-columns: 1fr; gap: 10px; }
        .status-options { flex-wrap: wrap; }
    }
</style>
@endpush

@section('content')

@if (session('success'))
    <div class="alert-success">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:18px;height:18px;">
            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd"/>
        </svg>
        {{ session('success') }}
    </div>
@endif

<!-- ══ FORM CATAT KEHADIRAN ══════════════════════════════════════ -->
<div class="form-section">
    <div class="form-section__title">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z"/>
            <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z"/>
        </svg>
        Form Catat Kehadiran
    </div>

    {{-- Filter: Pilih Kelas & Tanggal --}}
    <form method="GET" action="{{ route('guru.kehadiran.index') }}" id="filterForm">
        <div class="filter-grid">
            <div class="form-group">
                <label>Kelas</label>
                <select name="class_term_id" id="classTermSelect" onchange="document.getElementById('filterForm').submit()">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($classTerms as $ct)
                        <option value="{{ $ct->id }}" {{ $selectedClassTermId == $ct->id ? 'selected' : '' }}>
                            Kelas {{ $ct->class->name ?? '-' }} &mdash; {{ $ct->academicTerm->academic_year ?? '' }} {{ ucfirst($ct->academicTerm->semester ?? '') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" value="{{ $tanggal }}" onchange="document.getElementById('filterForm').submit()">
            </div>
            <div class="form-group" style="flex-shrink:0;">
                <label style="opacity:0;pointer-events:none;user-select:none;">‎</label>
                <button type="submit" class="btn-filter">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd"/></svg>
                    Tampilkan
                </button>
            </div>
        </div>
    </form>

    @if ($selectedClassTerm)
        {{-- Info kelas terpilih --}}
        <div class="class-term-badge">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.174v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z"/></svg>
            Kelas {{ $selectedClassTerm->class->name ?? '-' }} &mdash; {{ $selectedClassTerm->academicTerm->academic_year ?? '' }} {{ ucfirst($selectedClassTerm->academicTerm->semester ?? '') }}
            &nbsp;&bull;&nbsp; Tanggal: {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
        </div>

        @if ($enrollments->isEmpty())
            <div class="empty-hint">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd"/></svg>
                Tidak ada siswa aktif di kelas ini.
            </div>
        @else
            <form action="{{ route('guru.kehadiran.store') }}" method="POST">
                @csrf
                <input type="hidden" name="class_term_id" value="{{ $selectedClassTermId }}">
                <input type="hidden" name="tanggal" value="{{ $tanggal }}">

                <div class="attendance-form-container">
                    @foreach ($enrollments as $enrollment)
                        @php
                            $existing   = $existingPresences->get($enrollment->id);
                            $savedValue = $existing?->attendance ?? 'hadir';
                        @endphp
                        <div class="student-attendance-row">
                            <div class="student-info">
                                <div class="student-avatar">{{ strtoupper(substr($enrollment->student->name ?? '?', 0, 1)) }}</div>
                                <div>
                                    <div class="student-name">{{ $enrollment->student->name ?? '-' }}</div>
                                    <div class="student-sub">NIS: {{ $enrollment->student->nis ?? '-' }}</div>
                                </div>
                            </div>

                            <div class="status-options" data-enrollment="{{ $enrollment->id }}">
                                @foreach (['hadir' => 'Hadir', 'izin' => 'Izin', 'sakit' => 'Sakit', 'alpa' => 'Alpa'] as $val => $label)
                                    <label class="status-option {{ $val === 'alpa' ? 'opt-alpa' : '' }} {{ $savedValue === $val ? 'active-' . $val : '' }}">
                                        <input type="radio" name="attendance[{{ $enrollment->id }}]" value="{{ $val }}" {{ $savedValue === $val ? 'checked' : '' }}>
                                        {{ $label }}
                                    </label>
                                @endforeach
                            </div>

                            <input type="text"
                                   name="description[{{ $enrollment->id }}]"
                                   class="note-input"
                                   placeholder="Keterangan (opsional)"
                                   value="{{ $existing?->description ?? '' }}">
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn-save">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/></svg>
                    Simpan Kehadiran
                </button>
            </form>
        @endif

    @else
        <div class="empty-hint">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Z" clip-rule="evenodd"/></svg>
            Pilih kelas dan tanggal untuk memulai pencatatan kehadiran.
        </div>
    @endif
</div>

<!-- ══ LIST KEHADIRAN ════════════════════════════════════════════ -->
@if ($selectedClassTerm && $kehadiranList->isNotEmpty())
<div class="form-section">
    <div class="form-section__title">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd"/>
            <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z" clip-rule="evenodd"/>
        </svg>
        Riwayat Kehadiran — Kelas {{ $selectedClassTerm->class->name ?? '' }}
    </div>

    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $attendanceLabel = ['hadir' => 'Hadir', 'izin' => 'Izin', 'sakit' => 'Sakit', 'alpa' => 'Alpa'];
                    $attendanceBadge = ['hadir' => 'badge-hadir', 'izin' => 'badge-izin', 'sakit' => 'badge-sakit', 'alpa' => 'badge-alpa'];
                @endphp
                @foreach ($kehadiranList as $i => $pres)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $pres->studentEnrollment->student->name ?? '-' }}</td>
                        <td>{{ $pres->date->translatedFormat('d M Y') }}</td>
                        <td>
                            <span class="status-badge {{ $attendanceBadge[$pres->attendance] ?? '' }}">
                                {{ $attendanceLabel[$pres->attendance] ?? $pres->attendance }}
                            </span>
                        </td>
                        <td>{{ $pres->description ?: '-' }}</td>
                        <td>
                            <a href="{{ route('guru.kehadiran.edit', $pres->id) }}" class="btn-edit">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z"/></svg>
                                Edit
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
    // Radio button visual toggle
    document.querySelectorAll('.status-options').forEach(function(group) {
        group.querySelectorAll('.status-option').forEach(function(label) {
            label.addEventListener('click', function() {
                group.querySelectorAll('.status-option').forEach(function(l) {
                    l.classList.remove('active-hadir','active-izin','active-sakit','active-alpa');
                });
                const val = this.querySelector('input[type="radio"]').value;
                this.classList.add('active-' + val);
            });
        });
    });
</script>
@endpush
