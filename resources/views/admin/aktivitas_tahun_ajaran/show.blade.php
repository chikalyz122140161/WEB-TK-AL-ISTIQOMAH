@extends('layouts.app')

@section('title', 'Aktivitas Tahun Ajaran — Pilih Kelas')
@section('page_title', 'Aktivitas Tahun Ajaran')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@push('styles')
<style>
.back-link {
    display: inline-flex; align-items: center; gap: 6px;
    color: #5D4037; font-size: 14px; text-decoration: none;
    margin-bottom: 16px; transition: color 0.2s;
}
.back-link:hover { color: #3D9B72; }

.info-banner {
    background: #fff; border: 1px solid #e7e5e4; border-radius: 10px;
    padding: 16px 20px; margin-bottom: 20px;
    display: flex; align-items: center; gap: 16px; flex-wrap: wrap;
}
.info-banner__icon {
    width: 48px; height: 48px; border-radius: 12px;
    background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.info-banner__icon svg { width: 22px; height: 22px; fill: #fff; }
.info-banner__details h3 { font-size: 15px; font-weight: 600; color: #3E2723; margin: 0 0 4px; }
.info-banner__details p  { font-size: 13px; color: #78716c; margin: 0; }

.semester-pill {
    display: inline-block; border-radius: 99px; padding: .25rem .8rem;
    font-size: .8rem; font-weight: 600;
}
.semester-pill--ganjil { background: #FFF176; color: #5D4037; }
.semester-pill--genap  { background: rgba(76,175,130,0.15); color: #2E8B60; }

.kelas-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 16px;
}
.kelas-card {
    background: #fff;
    border: 1px solid #e7e5e4;
    border-radius: 12px;
    padding: 20px;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.kelas-card:hover {
    border-color: #4CAF82;
    box-shadow: 0 2px 8px rgba(76,175,130,0.15);
}
.kelas-card__header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 14px;
}
.kelas-badge {
    display: inline-flex; align-items: center; justify-content: center;
    width: 44px; height: 44px; border-radius: 10px;
    font-size: 1rem; font-weight: 800;
}
.kelas-badge--a { background: rgba(76,175,130,0.18); color: #2E8B60; }
.kelas-badge--b { background: #FFF176; color: #5D4037; }

.assign-summary { display: flex; flex-direction: column; gap: 8px; margin-bottom: 16px; }
.assign-row { display: flex; align-items: center; justify-content: space-between; font-size: 13px; }
.assign-row__label { color: #6b7280; font-weight: 500; }
.assign-row__count {
    background: #f3f4f6; color: #374151;
    border-radius: 99px; padding: 2px 10px;
    font-size: 12px; font-weight: 600;
}
.assign-row__count--filled { background: rgba(76,175,130,0.15); color: #2E8B60; }

.empty-state { text-align: center; padding: 40px 20px; color: #a8a29e; }
</style>
@endpush

@section('content')
<a href="{{ route('admin.aktivitas_tahun_ajaran.index') }}" class="back-link">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="16" height="16">
        <path fill-rule="evenodd" d="M7.28 7.72a.75.75 0 0 1 0 1.06l-2.47 2.47H21a.75.75 0 0 1 0 1.5H4.81l2.47 2.47a.75.75 0 1 1-1.06 1.06l-3.75-3.75a.75.75 0 0 1 0-1.06l3.75-3.75a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/>
    </svg>
    Kembali ke Daftar Tahun Ajaran
</a>

@if(session('success'))
<div class="alert alert--success">{{ session('success') }}</div>
@endif

<div class="info-banner">
    <div class="info-banner__icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd"/></svg>
    </div>
    <div class="info-banner__details">
        <h3>{{ $academicTerm->academic_year }} — Semester {{ ucfirst($academicTerm->semester) }}</h3>
        <p>
            <span class="semester-pill semester-pill--{{ $academicTerm->semester }}">{{ ucfirst($academicTerm->semester) }}</span>
            &nbsp;·&nbsp; {{ $academicTerm->classTerms->count() }} kelas terdaftar
        </p>
    </div>
</div>

@if($academicTerm->classTerms->isEmpty())
<div class="card">
    <div class="empty-state">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="40" height="40" style="fill:#d6d3d1;margin-bottom:10px;"><path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z"/></svg>
        <p>Belum ada kelas yang terdaftar untuk tahun ajaran ini.<br>Tambahkan kelas terlebih dahulu di menu <strong>Kelola Tahun Ajaran</strong>.</p>
    </div>
</div>
@else
<div class="kelas-grid">
    @foreach($academicTerm->classTerms as $ct)
    @php
        $jumlahMapel   = $ct->subjects->count();
        $jumlahEkskul  = $ct->extracurriculars->count();
        $jumlahKonseling = $ct->counselings->count();
    @endphp
    <div class="kelas-card">
        <div class="kelas-card__header">
            <span class="kelas-badge {{ str_starts_with($ct->class?->name ?? '', 'A') ? 'kelas-badge--a' : 'kelas-badge--b' }}">
                {{ $ct->class?->name ?? '-' }}
            </span>
            <a href="{{ route('admin.aktivitas_tahun_ajaran.edit', $ct->id) }}" class="btn btn--primary btn--sm">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="14" height="14"><path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z"/></svg>
                Atur
            </a>
        </div>
        <div class="assign-summary">
            <div class="assign-row">
                <span class="assign-row__label">Mata Pelajaran</span>
                <span class="assign-row__count {{ $jumlahMapel > 0 ? 'assign-row__count--filled' : '' }}">{{ $jumlahMapel }}</span>
            </div>
            <div class="assign-row">
                <span class="assign-row__label">Ekstrakurikuler</span>
                <span class="assign-row__count {{ $jumlahEkskul > 0 ? 'assign-row__count--filled' : '' }}">{{ $jumlahEkskul }}</span>
            </div>
            <div class="assign-row">
                <span class="assign-row__label">Konseling</span>
                <span class="assign-row__count {{ $jumlahKonseling > 0 ? 'assign-row__count--filled' : '' }}">{{ $jumlahKonseling }}</span>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection
