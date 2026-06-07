@extends('layouts.app')

@section('title', 'Aktivitas Tahun Ajaran')
@section('page_title', 'Aktivitas Tahun Ajaran')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@push('styles')
<style>
.aktivitas-table {
    width: 100%;
    border-collapse: collapse;
}
.aktivitas-table thead tr {
    background: #f8fafb;
    border-bottom: 2px solid #e5e7eb;
}
.aktivitas-table th {
    padding: 14px 20px;
    font-size: .8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: #6b7280;
    text-align: left;
    white-space: nowrap;
}
.aktivitas-table td {
    padding: 16px 20px;
    font-size: .95rem;
    color: #374151;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: top;
}
.aktivitas-table tbody tr:last-child td {
    border-bottom: none;
}
.aktivitas-table tbody tr:hover td {
    background: #f9fafb;
}
.tahun-text {
    font-weight: 600;
    font-size: 1rem;
    color: #111827;
}
.row-no {
    color: #9ca3af;
    font-size: .875rem;
    font-weight: 500;
}
.semester-pill {
    display: inline-block;
    border-radius: 99px;
    padding: .2rem .75rem;
    font-size: .75rem;
    font-weight: 600;
    margin-top: .35rem;
}
.semester-pill--ganjil {
    background: #FFF176;
    color: #5D4037;
}
.semester-pill--genap {
    background: rgba(76,175,130,0.15);
    color: #2E8B60;
}
.assign-block {
    margin-bottom: .65rem;
}
.assign-block:last-child { margin-bottom: 0; }
.assign-label {
    font-size: .72rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: .04em;
    margin-bottom: .3rem;
    display: flex;
    align-items: center;
    gap: .35rem;
}
.assign-count {
    background: #f3f4f6;
    color: #374151;
    border-radius: 99px;
    padding: .1rem .55rem;
    font-size: .7rem;
}
.chip-row {
    display: flex;
    flex-wrap: wrap;
    gap: .3rem;
}
.chip {
    display: inline-flex;
    align-items: center;
    border-radius: 99px;
    padding: .2rem .65rem;
    font-size: .78rem;
    font-weight: 500;
}
.chip--mapel {
    background: #FFFDE7;
    color: #5D4037;
    border: 1px solid #e6db00;
}
.chip--ekskul {
    background: rgba(76,175,130,0.12);
    color: #2E8B60;
    border: 1px solid rgba(76,175,130,0.3);
}
.chip--konseling {
    background: rgba(76,175,130,0.12);
    color: #2E8B60;
    border: 1px solid rgba(76,175,130,0.3);
}
.chip-empty {
    color: #9ca3af;
    font-style: italic;
    font-size: .8rem;
}
.btn-row {
    display: flex;
    align-items: center;
    gap: .5rem;
}
.card__body {
    overflow-x: scroll;
}
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="page-header__left">
    </div>
</div>

@if(session('success'))
<div class="alert alert--success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card__header">
        <h3 class="card__title">Daftar Tahun Ajaran</h3>
        <span class="badge badge--primary">{{ $academicTerms->count() }} Tahun Ajaran</span>
    </div>
    <div class="card__body p-0">
        @if($academicTerms->isEmpty())
        <div style="padding:3rem;text-align:center;">
            <p style="color:#6b7280;">Belum ada tahun ajaran. Tambahkan dulu di menu <strong>Kelola Tahun Ajaran</strong>.</p>
        </div>
        @else
        <table class="aktivitas-table">
            <thead>
                <tr>
                    <th style="width:60px;">No</th>
                    <th>Tahun Ajaran</th>
                    <th style="width:140px;">Jumlah Kelas</th>
                    <th style="width:140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($academicTerms as $i => $ta)
                <tr>
                    <td class="row-no">{{ $i + 1 }}</td>
                    <td>
                        <div class="tahun-text">{{ $ta->academic_year }}</div>
                        <span class="semester-pill semester-pill--{{ $ta->semester }}">
                            Semester {{ ucfirst($ta->semester) }}
                        </span>
                    </td>
                    <td>
                        <span class="assign-count" style="font-size:.9rem;">{{ $ta->class_terms_count }} kelas</span>
                    </td>
                    <td>
                        <div class="btn-row">
                            <a href="{{ route('admin.aktivitas_tahun_ajaran.show', $ta->id) }}" class="btn btn--secondary btn--sm">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="15" height="15"><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd"/></svg>
                                Pilih Kelas
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection
