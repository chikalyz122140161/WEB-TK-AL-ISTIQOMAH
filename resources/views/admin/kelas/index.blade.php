@extends('layouts.app')

@section('title', 'Kelola Kelas')
@section('page_title', 'Kelola Kelas')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@push('styles')
<style>
.kelas-table {
    width: 100%;
    border-collapse: collapse;
}
.kelas-table thead tr {
    background: #f8fafb;
    border-bottom: 2px solid #e5e7eb;
}
.kelas-table th {
    padding: 14px 20px;
    font-size: .8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: #6b7280;
    text-align: left;
    white-space: nowrap;
}
.kelas-table td {
    padding: 16px 20px;
    font-size: .95rem;
    color: #374151;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
}
.kelas-table tbody tr:last-child td {
    border-bottom: none;
}
.kelas-table tbody tr:hover td {
    background: #f9fafb;
}
.kelas-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 700;
    letter-spacing: .03em;
}
.kelas-badge--a {
    background: rgba(76,175,130,0.18);
    color: #2E8B60;
}
.kelas-badge--b {
    background: #FFF176;
    color: #5D4037;
}
.row-no {
    color: #9ca3af;
    font-size: .875rem;
    font-weight: 500;
}
.maks-pill {
    display: inline-block;
    background: #f3f4f6;
    color: #374151;
    border-radius: 99px;
    padding: .3rem .85rem;
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
    </div>
    <div class="page-header__actions">
        <a href="{{ route('admin.kelas.create') }}" class="btn btn--primary">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
            Tambah Kelas
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
        <h3 class="card__title">Daftar Kelas</h3>
        <span class="badge badge--primary">{{ count($kelas) }} Kelas</span>
    </div>
    <div class="card__body p-0">
        @if(count($kelas) === 0)
        <div class="empty-state" style="padding: 3rem; text-align:center;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="48" height="48" style="color:#d1d5db;margin-bottom:1rem;"><path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 4.8 11.06a.75.75 0 0 1-.231-1.337A60.65 60.65 0 0 1 11.7 2.805Z"/></svg>
            <p style="color:#6b7280;margin-bottom:1rem;">Belum ada kelas yang ditambahkan.</p>
            <a href="{{ route('admin.kelas.create') }}" class="btn btn--primary">Tambah Kelas Pertama</a>
        </div>
        @else
        <table class="kelas-table">
            <thead>
                <tr>
                    <th style="width:60px;">No</th>
                    <th>Nama Kelas</th>
                    <th>Maks. Siswa</th>
                    <th style="width:160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kelas as $i => $k)
                <tr>
                    <td class="row-no">{{ $i + 1 }}</td>
                    <td>
                        <span class="kelas-badge {{ $k['nama'] === 'A1' ? 'kelas-badge--a' : 'kelas-badge--b' }}">
                            {{ $k['nama'] }}
                        </span>
                    </td>
                    <td>
                        <span class="maks-pill">{{ $k['jumlah_maksimum'] }} siswa</span>
                    </td>
                    <td>
                        <div class="btn-row">
                            <a href="{{ route('admin.kelas.edit', $k['id']) }}" class="btn btn--secondary btn--sm">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="15" height="15"><path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z"/></svg>
                                Edit
                            </a>
                            <form action="{{ route('admin.kelas.destroy', $k['id']) }}" method="POST"
                                  onsubmit="return confirm('Hapus kelas {{ $k['nama'] }}?')">
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
