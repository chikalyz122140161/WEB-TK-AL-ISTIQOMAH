@extends('layouts.app')

@section('title', 'Kelola Tahun Ajaran')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@push('styles')
<style>
.ta-table {
    width: 100%;
    border-collapse: collapse;
}
.ta-table thead tr {
    background: #f8fafb;
    border-bottom: 2px solid #e5e7eb;
}
.ta-table th {
    padding: 14px 20px;
    font-size: .8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: #6b7280;
    text-align: left;
    white-space: nowrap;
}
.ta-table td {
    padding: 16px 20px;
    font-size: .95rem;
    color: #374151;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
}
.ta-table tbody tr:last-child td {
    border-bottom: none;
}
.ta-table tbody tr:hover td {
    background: #f9fafb;
}
.semester-pill {
    display: inline-block;
    border-radius: 99px;
    padding: .3rem 1rem;
    font-size: .82rem;
    font-weight: 600;
    text-transform: capitalize;
}
.semester-pill--ganjil {
    background: #fef3c7;
    color: #92400e;
}
.semester-pill--genap {
    background: #dbeafe;
    color: #1e40af;
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
        <h1 class="page-header__title">Kelola Tahun Ajaran</h1>
        <p class="page-header__subtitle">Manajemen data tahun ajaran dan semester TK Al-Istiqomah</p>
    </div>
    <div class="page-header__actions">
        <a href="{{ route('admin.tahun_ajaran.create') }}" class="btn btn--primary">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
            Tambah Tahun Ajaran
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert--success">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert--danger">{{ session('error') }}</div>
@endif

<div class="card">
    <div class="card__header">
        <h3 class="card__title">Daftar Tahun Ajaran</h3>
        <span class="badge badge--primary">{{ count($data) }} Data</span>
    </div>
    <div class="card__body p-0">
        @if(count($data) === 0)
        <div style="padding:3rem;text-align:center;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="48" height="48" style="color:#d1d5db;margin-bottom:1rem;"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd"/></svg>
            <p style="color:#6b7280;margin-bottom:1rem;">Belum ada data tahun ajaran.</p>
            <a href="{{ route('admin.tahun_ajaran.create') }}" class="btn btn--primary">Tambah Sekarang</a>
        </div>
        @else
        <table class="ta-table">
            <thead>
                <tr>
                    <th style="width:60px;">No</th>
                    <th>Tahun Ajaran</th>
                    <th>Semester</th>
                    <th style="width:160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $i => $item)
                <tr>
                    <td class="row-no">{{ $i + 1 }}</td>
                    <td class="tahun-text">{{ $item['tahun_ajaran'] }}</td>
                    <td>
                        <span class="semester-pill semester-pill--{{ $item['semester'] }}">
                            {{ ucfirst($item['semester']) }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-row">
                            <a href="{{ route('admin.tahun_ajaran.edit', $item['id']) }}" class="btn btn--secondary btn--sm">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="15" height="15"><path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z"/></svg>
                                Edit
                            </a>
                            <form action="{{ route('admin.tahun_ajaran.destroy', $item['id']) }}" method="POST"
                                  onsubmit="return confirm('Hapus Tahun Ajaran {{ $item['tahun_ajaran'] }} Semester {{ ucfirst($item['semester']) }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn--danger btn--sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="15" height="15"><path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd"/></svg>
                                    Hapus
                                </button>
                            </form>
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
