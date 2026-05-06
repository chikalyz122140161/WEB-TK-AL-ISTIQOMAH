@extends('layouts.app')

@section('title', 'Aktivitas Tahun Ajaran')

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
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="page-header__left">
        <h1 class="page-header__title">Aktivitas Tahun Ajaran</h1>
        <p class="page-header__subtitle">Kaitkan mata pelajaran, ekstrakurikuler, dan konseling ke setiap tahun ajaran</p>
    </div>
</div>

@if(session('success'))
<div class="alert alert--success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card__header">
        <h3 class="card__title">Daftar Tahun Ajaran</h3>
        <span class="badge badge--primary">{{ count($rows) }} Tahun Ajaran</span>
    </div>
    <div class="card__body p-0">
        @if(count($rows) === 0)
        <div style="padding:3rem;text-align:center;">
            <p style="color:#6b7280;">Belum ada tahun ajaran. Tambahkan dulu di menu <strong>Kelola Tahun Ajaran</strong>.</p>
        </div>
        @else
        <table class="aktivitas-table">
            <thead>
                <tr>
                    <th style="width:60px;">No</th>
                    <th style="width:200px;">Tahun Ajaran</th>
                    <th>Aktivitas Terkait</th>
                    <th style="width:140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rows as $i => $row)
                <tr>
                    <td class="row-no">{{ $i + 1 }}</td>
                    <td>
                        <div class="tahun-text">{{ $row['tahun_ajaran'] }}</div>
                        <span class="semester-pill semester-pill--{{ $row['semester'] }}">
                            Semester {{ ucfirst($row['semester']) }}
                        </span>
                    </td>
                    <td>
                        <div class="assign-block">
                            <div class="assign-label">
                                Mata Pelajaran
                                <span class="assign-count">{{ count($row['mata_pelajaran']) }}</span>
                            </div>
                            @if(count($row['mata_pelajaran']) === 0)
                                <span class="chip-empty">Belum ada</span>
                            @else
                                <div class="chip-row">
                                    @foreach($row['mata_pelajaran'] as $name)
                                        <span class="chip chip--mapel">{{ $name }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="assign-block">
                            <div class="assign-label">
                                Ekstrakurikuler
                                <span class="assign-count">{{ count($row['ekstrakurikuler']) }}</span>
                            </div>
                            @if(count($row['ekstrakurikuler']) === 0)
                                <span class="chip-empty">Belum ada</span>
                            @else
                                <div class="chip-row">
                                    @foreach($row['ekstrakurikuler'] as $name)
                                        <span class="chip chip--ekskul">{{ $name }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="assign-block">
                            <div class="assign-label">
                                Konseling
                                <span class="assign-count">{{ count($row['konseling']) }}</span>
                            </div>
                            @if(count($row['konseling']) === 0)
                                <span class="chip-empty">Belum ada</span>
                            @else
                                <div class="chip-row">
                                    @foreach($row['konseling'] as $name)
                                        <span class="chip chip--konseling">{{ $name }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="btn-row">
                            <a href="{{ route('admin.aktivitas_tahun_ajaran.edit', $row['id']) }}" class="btn btn--secondary btn--sm">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="15" height="15"><path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z"/></svg>
                                Atur
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
