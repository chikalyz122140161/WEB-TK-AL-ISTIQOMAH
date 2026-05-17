@extends('layouts.app')

@section('title', 'Riwayat Tahun Ajaran')
@section('page_title', 'Riwayat Tahun Ajaran')

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
.info-banner__details { flex: 1; }
.info-banner__details h3 { font-size: 15px; font-weight: 600; color: #3E2723; margin: 0 0 4px; }
.info-banner__details p  { font-size: 13px; color: #78716c; margin: 0; }

.semester-pill {
    display: inline-block; border-radius: 99px; padding: .25rem .8rem;
    font-size: .8rem; font-weight: 600;
}
.semester-pill--ganjil { background: #FFF176; color: #5D4037; }
.semester-pill--genap  { background: rgba(76,175,130,0.15); color: #2E8B60; }

.status-badge {
    display: inline-block; font-size: 12px; font-weight: 600;
    padding: 4px 12px; border-radius: 20px;
}
.status-badge--selesai  { background: #f3f4f6; color: #6b7280; }
.status-badge--aktif    { background: rgba(76,175,130,0.15); color: #2E8B60; }
.status-badge--menunggu { background: #FFF176; color: #5D4037; }

/* Class term picker */
.picker-label {
    font-size: 14px; font-weight: 600; color: #5D4037; margin-bottom: 12px;
}
.class-picker {
    display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 24px;
}
.class-card {
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    width: 120px; padding: 16px 12px; border-radius: 12px; cursor: pointer;
    border: 2px solid #e7e5e4; background: #fff; transition: all 0.2s;
    user-select: none;
}
.class-card:hover { border-color: #4CAF82; background: rgba(76,175,130,0.05); }
.class-card.active { border-color: #4CAF82; background: rgba(76,175,130,0.12); }
.class-card__name {
    font-size: 22px; font-weight: 800; color: #3E2723; line-height: 1;
}
.class-card__count {
    font-size: 12px; color: #78716c; margin-top: 6px;
}
.class-card__empty { font-size: 11px; color: #d1d5db; margin-top: 4px; }

/* Student table */
.student-section { display: none; }
.student-section.visible { display: block; }
.section-title {
    font-size: 15px; font-weight: 600; color: #3E2723; margin-bottom: 12px;
    display: flex; align-items: center; gap: 8px;
}
.riwayat-table-wrap {
    background: #fff; border: 1px solid #e7e5e4; border-radius: 10px; overflow: hidden;
}
.riwayat-table { width: 100%; border-collapse: collapse; font-size: 14px; }
.riwayat-table thead th {
    background: #f5f5f4; color: #57534e; font-size: 12px; font-weight: 600;
    text-transform: uppercase; letter-spacing: 0.04em;
    padding: 11px 16px; text-align: left; border-bottom: 1px solid #e7e5e4; white-space: nowrap;
}
.riwayat-table tbody td {
    padding: 13px 16px; color: #3E2723; border-bottom: 1px solid #f5f5f4; vertical-align: middle;
}
.riwayat-table tbody tr:last-child td { border-bottom: none; }
.riwayat-table tbody tr:hover { background: #fafaf9; }

.avatar {
    width: 34px; height: 34px; border-radius: 50%; display: inline-flex;
    align-items: center; justify-content: center; font-weight: 700; font-size: 13px;
    background: linear-gradient(135deg, #4CAF82, #3D9B72); color: #fff; flex-shrink: 0;
}
.avatar--female { background: linear-gradient(135deg, #F06292, #e91e8c); }

.empty-state { text-align: center; padding: 40px 20px; color: #a8a29e; }
.empty-state svg { width: 40px; height: 40px; fill: #d6d3d1; margin-bottom: 10px; display: block; margin-left: auto; margin-right: auto; }
</style>
@endpush

@section('content')
<a href="{{ route('admin.tahun_ajaran.index') }}" class="back-link">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="16" height="16">
        <path fill-rule="evenodd" d="M7.28 7.72a.75.75 0 0 1 0 1.06l-2.47 2.47H21a.75.75 0 0 1 0 1.5H4.81l2.47 2.47a.75.75 0 1 1-1.06 1.06l-3.75-3.75a.75.75 0 0 1 0-1.06l3.75-3.75a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/>
    </svg>
    Kembali ke Daftar Tahun Ajaran
</a>

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
    <span class="status-badge status-badge--{{ $academicTerm->status }}">{{ ucfirst($academicTerm->status) }}</span>
</div>

@if($academicTerm->classTerms->isEmpty())
    <div class="card">
        <div class="empty-state" style="padding:3rem;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875Z" clip-rule="evenodd"/></svg>
            <p>Belum ada kelas yang terdaftar untuk tahun ajaran ini.</p>
        </div>
    </div>
@else
    <p class="picker-label">Pilih Kelas untuk melihat daftar siswa:</p>
    <div class="class-picker">
        @foreach($academicTerm->classTerms as $ct)
        <div class="class-card" onclick="showClass('{{ $ct->id }}')" id="card-{{ $ct->id }}">
            <div class="class-card__name">{{ $ct->class?->name ?? '-' }}</div>
            <div class="class-card__count">{{ $ct->enrollments->count() }} siswa</div>
        </div>
        @endforeach
    </div>

    @foreach($academicTerm->classTerms as $ct)
    <div class="student-section" id="section-{{ $ct->id }}">
        <div class="section-title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18" style="color:#4CAF82"><path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z"/><path d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.71 47.87 47.87 0 0 1-8.105 2.874.75.75 0 0 1-.832-.586 48.055 48.055 0 0 1 1.476-4Z"/></svg>
            Kelas {{ $ct->class?->name ?? '-' }} — {{ $ct->enrollments->count() }} Siswa
        </div>
        <div class="riwayat-table-wrap">
            @if($ct->enrollments->isEmpty())
            <div class="empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd"/></svg>
                <p>Belum ada siswa di kelas ini.</p>
            </div>
            @else
            <table class="riwayat-table">
                <thead>
                    <tr>
                        <th style="width:40px;">No</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th>Jenis Kelamin</th>
                        <th>Status Enrollment</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ct->enrollments as $idx => $enroll)
                    <tr>
                        <td style="color:#9ca3af;">{{ $idx + 1 }}</td>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <span class="avatar {{ $enroll->student?->gender === 'P' ? 'avatar--female' : '' }}">
                                    {{ substr($enroll->student?->name ?? '?', 0, 1) }}
                                </span>
                                <div>
                                    <div style="font-weight:600;">{{ $enroll->student?->name ?? '-' }}</div>
                                    <div style="font-size:12px;color:#78716c;">{{ $enroll->student?->nik ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $enroll->student?->nis ?? '-' }}</td>
                        <td>{{ $enroll->student?->gender === 'L' ? 'Laki-laki' : ($enroll->student?->gender === 'P' ? 'Perempuan' : '-') }}</td>
                        <td>
                            <span style="display:inline-block;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600;background:rgba(76,175,130,0.15);color:#2E8B60;">
                                {{ ucfirst($enroll->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
    @endforeach
@endif

<script>
function showClass(id) {
    document.querySelectorAll('.student-section').forEach(s => s.classList.remove('visible'));
    document.querySelectorAll('.class-card').forEach(c => c.classList.remove('active'));
    document.getElementById('section-' + id).classList.add('visible');
    document.getElementById('card-' + id).classList.add('active');
}
</script>
@endsection
