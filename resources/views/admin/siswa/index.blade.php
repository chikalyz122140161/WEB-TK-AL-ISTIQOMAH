@extends('layouts.app')

@section('title', 'Kelola Siswa')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="page-header">
    <div class="page-header__left">
        <h1 class="page-header__title">Kelola Siswa</h1>
        <p class="page-header__subtitle">Manajemen data siswa TK Al-Istiqomah</p>
    </div>
    <div class="page-header__actions">
        <a href="{{ route('admin.siswa.create') }}" class="btn btn--primary">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
            Tambah Siswa
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert--success">
    {{ session('success') }}
</div>
@endif

<!-- Filter Section -->
<div class="card mb-4">
    <div class="card__body">
        <div class="filter-row">
            <div class="filter-group">
                <label for="search">Cari</label>
                <input type="text" id="search" placeholder="NIS atau nama siswa..." class="form-input">
            </div>
            <div class="filter-group">
                <label for="kelas">Kelas</label>
                <select id="kelas" class="form-select">
                    <option value="">Semua Kelas</option>
                    <option value="TK A">TK A</option>
                    <option value="TK B">TK B</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="jk">Jenis Kelamin</label>
                <select id="jk" class="form-select">
                    <option value="">Semua</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="status">Status</label>
                <select id="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="lulus">Lulus</option>
                    <option value="pindah">Pindah</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Table -->
<div class="card">
    <div class="card__body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Jenis Kelamin</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $index => $s)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><span class="badge badge--outline">{{ $s['nis'] }}</span></td>
                        <td>
                            <div class="student-cell">
                                <div class="student-cell__avatar {{ $s['jk'] == 'P' ? 'student-cell__avatar--female' : '' }}">
                                    {{ substr($s['nama'], 0, 1) }}
                                </div>
                                <span>{{ $s['nama'] }}</span>
                            </div>
                        </td>
                        <td><span class="badge badge--kelas">{{ $s['kelas'] }}</span></td>
                        <td>{{ $s['jk'] == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td>
                            <span class="badge badge--{{ $s['status'] == 'Aktif' ? 'success' : 'secondary' }}">{{ $s['status'] }}</span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.siswa.edit', $s['id']) }}" class="btn btn--icon btn--secondary" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z"/></svg>
                                </a>
                                <form action="{{ route('admin.siswa.destroy', $s['id']) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn--icon btn--danger" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">Belum ada data siswa</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
/* Page Header with Actions */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.page-header__left {
    flex: 1;
}

/* Filter Row */
.filter-row {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    min-width: 150px;
}

.filter-group label {
    font-size: 0.8rem;
    font-weight: 500;
    color: #475d5b;
}

.form-input, .form-select {
    padding: 0.5rem 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.875rem;
    background: white;
}

.form-input:focus, .form-select:focus {
    outline: none;
    border-color: #00473e;
    box-shadow: 0 0 0 3px rgba(0, 71, 62, 0.1);
}

/* Table Styles */
.table-responsive {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th,
.data-table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid #e5e7eb;
}

.data-table th {
    background: #f8fafc;
    font-weight: 600;
    color: #00473e;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.data-table tbody tr:hover {
    background: #f8fafc;
}

/* Student Cell */
.student-cell {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.student-cell__avatar {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, #00473e, #0d9488);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.875rem;
}

.student-cell__avatar--female {
    background: linear-gradient(135deg, #ec4899, #f472b6);
}

/* Badges */
.badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
}

.badge--outline {
    background: transparent;
    border: 1px solid #d1d5db;
    color: #475d5b;
}

.badge--kelas {
    background: rgba(0, 71, 62, 0.1);
    color: #00473e;
}

.badge--success {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
}

.badge--secondary {
    background: #f1f5f9;
    color: #64748b;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn--icon {
    width: 32px;
    height: 32px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}

.btn--secondary {
    background: #f1f5f9;
    color: #475d5b;
}

.btn--secondary:hover {
    background: #e2e8f0;
    color: #00473e;
}

.btn--danger {
    background: #fee2e2;
    color: #dc2626;
}

.btn--danger:hover {
    background: #fecaca;
}

/* Alerts */
.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.alert--success {
    background: #dcfce7;
    color: #166534;
    border: 1px solid #86efac;
}

.mb-4 { margin-bottom: 1rem; }
.p-0 { padding: 0 !important; }
.py-4 { padding-top: 1rem; padding-bottom: 1rem; }
.text-center { text-align: center; }
</style>
@endsection
