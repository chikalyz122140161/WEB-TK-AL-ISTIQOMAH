@extends('layouts.app')

@section('title', 'Edit Kehadiran - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Edit Kehadiran')

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
    .form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 18px; }
    .form-group label { font-size: 13px; font-weight: 600; color: #5D4037; }
    .form-group textarea {
        padding: 10px 12px; border: 1.5px solid #3E272320; border-radius: 8px;
        font-size: 14px; color: #3E2723; background: #FFFDE7;
        font-family: inherit; resize: vertical; transition: all 0.2s;
    }
    .form-group textarea:focus { outline: none; border-color: #4CAF82; background: #fff; box-shadow: 0 0 0 3px rgba(76,175,130,0.15); }

    .student-info-card {
        display: flex; align-items: center; gap: 16px;
        padding: 14px 16px;
        background: rgba(76,175,130,0.07);
        border: 1.5px solid rgba(76,175,130,0.20);
        border-radius: 10px;
        margin-bottom: 22px;
    }
    .student-info-card__avatar {
        width: 46px; height: 46px; border-radius: 50%;
        background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
        color: #fff; display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 17px; flex-shrink: 0;
    }
    .student-info-card__name { font-size: 15px; font-weight: 700; color: #3E2723; }
    .student-info-card__detail { font-size: 12.5px; color: #5D4037; margin-top: 2px; }

    .status-selector { display: flex; gap: 10px; flex-wrap: wrap; }
    .status-opt {
        display: flex; align-items: center; gap: 7px;
        padding: 11px 18px;
        border: 2px solid #3E272318; border-radius: 10px;
        font-size: 14px; font-weight: 600; cursor: pointer;
        transition: all 0.15s; background: white; color: #5D4037;
        min-width: 100px; justify-content: center;
    }
    .status-opt input { display: none; }
    .status-opt svg { width: 17px; height: 17px; }
    .status-opt.sel-hadir  { border-color: #4CAF82; background: rgba(76,175,130,0.12); color: #2E8B60; }
    .status-opt.sel-izin   { border-color: #d4a000; background: rgba(255,241,118,0.45); color: #7a5c00; }
    .status-opt.sel-sakit  { border-color: #3b82f6; background: rgba(59,130,246,0.10); color: #1d4ed8; }
    .status-opt.sel-alpa   { border-color: #d81b72; background: rgba(240,98,146,0.10); color: #d81b72; }

    .btn-row { display: flex; gap: 12px; margin-top: 4px; }
    .btn-save {
        display: inline-flex; align-items: center; gap: 8px;
        background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
        color: #fff; padding: 10px 22px; font-size: 14px; font-weight: 700;
        border: none; cursor: pointer; border-radius: 8px;
        box-shadow: 0 4px 14px rgba(76,175,130,0.30); transition: all 0.25s; font-family: inherit;
    }
    .btn-save:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(76,175,130,0.40); }
    .btn-save svg { width: 16px; height: 16px; fill: currentColor; }
    .btn-cancel {
        display: inline-flex; align-items: center; gap: 8px;
        background: #3E272315; color: #3E2723; padding: 10px 20px;
        font-size: 14px; font-weight: 600; border: none; cursor: pointer;
        border-radius: 8px; text-decoration: none; transition: all 0.2s; font-family: inherit;
    }
    .btn-cancel:hover { background: #3E272325; }
    .btn-cancel svg { width: 16px; height: 16px; fill: currentColor; }
    .back-link {
        display: inline-flex; align-items: center; gap: 6px;
        color: #5D4037; font-size: 14px; text-decoration: none; margin-bottom: 16px;
    }
    .back-link:hover { color: #4CAF82; }
    .back-link svg { width: 16px; height: 16px; fill: currentColor; }
</style>
@endpush

@section('content')
    @php
        $classTermId = $presence->studentEnrollment->class_term_id;
        $tanggal     = $presence->date->format('Y-m-d');
    @endphp

    <a href="{{ route('guru.kehadiran.index', ['class_term_id' => $classTermId, 'tanggal' => $tanggal]) }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M7.28 7.72a.75.75 0 0 1 0 1.06l-2.47 2.47H21a.75.75 0 0 1 0 1.5H4.81l2.47 2.47a.75.75 0 1 1-1.06 1.06l-3.75-3.75a.75.75 0 0 1 0-1.06l3.75-3.75a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/></svg>
        Kembali
    </a>

    <div class="form-section">
        <div class="form-section__title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z"/></svg>
            Edit Kehadiran
        </div>

        <div class="student-info-card">
            <div class="student-info-card__avatar">{{ strtoupper(substr($presence->studentEnrollment->student->name ?? '?', 0, 1)) }}</div>
            <div>
                <div class="student-info-card__name">{{ $presence->studentEnrollment->student->name ?? '-' }}</div>
                <div class="student-info-card__detail">
                    Kelas {{ $presence->studentEnrollment->classTerm->class->name ?? '-' }}
                    &bull; {{ $presence->studentEnrollment->classTerm->academicTerm->academic_year ?? '' }}
                    {{ ucfirst($presence->studentEnrollment->classTerm->academicTerm->semester ?? '') }}
                    &bull; {{ $presence->date->translatedFormat('d F Y') }}
                </div>
            </div>
        </div>

        <form action="{{ route('guru.kehadiran.update', $presence->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Status Kehadiran</label>
                <div class="status-selector" id="statusSelector">
                    @foreach (['hadir' => ['Hadir','sel-hadir'], 'izin' => ['Izin','sel-izin'], 'sakit' => ['Sakit','sel-sakit'], 'alpa' => ['Alpa','sel-alpa']] as $val => [$label, $cls])
                        <label class="status-opt {{ $presence->attendance === $val ? $cls : '' }}" data-cls="{{ $cls }}">
                            <input type="radio" name="attendance" value="{{ $val }}" {{ $presence->attendance === $val ? 'checked' : '' }}>
                            {{ $label }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="description" rows="3" placeholder="Keterangan (opsional)">{{ $presence->description ?? '' }}</textarea>
            </div>

            <div class="btn-row">
                <button type="submit" class="btn-save">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/></svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('guru.kehadiran.index', ['class_term_id' => $classTermId, 'tanggal' => $tanggal]) }}" class="btn-cancel">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('#statusSelector .status-opt').forEach(function(label) {
        label.addEventListener('click', function() {
            document.querySelectorAll('#statusSelector .status-opt').forEach(function(l) {
                l.classList.remove('sel-hadir','sel-izin','sel-sakit','sel-alpa');
            });
            this.classList.add(this.dataset.cls);
        });
    });
</script>
@endpush
