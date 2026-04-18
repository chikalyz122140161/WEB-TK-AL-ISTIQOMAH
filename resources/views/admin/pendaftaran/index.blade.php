@extends('layouts.app')

@section('title', 'Kelola Pendaftaran')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="page-header">
    <div class="page-header__left">
        <h1 class="page-header__title">Kelola Pendaftaran</h1>
        <p class="page-header__subtitle">Manajemen pendaftaran siswa baru dan verifikasi data</p>
    </div>
</div>

@if(session('success'))
<div class="alert alert--success">
    {{ session('success') }}
</div>
@endif

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card stat-card--warning">
        <div class="stat-card__icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd"/></svg>
        </div>
        <div class="stat-card__content">
            <span class="stat-card__value">{{ $totalPending }}</span>
            <span class="stat-card__label">Menunggu Verifikasi</span>
        </div>
    </div>
    <div class="stat-card stat-card--success">
        <div class="stat-card__icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd"/></svg>
        </div>
        <div class="stat-card__content">
            <span class="stat-card__value">{{ $totalDiterima }}</span>
            <span class="stat-card__label">Diterima</span>
        </div>
    </div>
    <div class="stat-card stat-card--danger">
        <div class="stat-card__icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd"/></svg>
        </div>
        <div class="stat-card__content">
            <span class="stat-card__value">{{ $totalDitolak }}</span>
            <span class="stat-card__label">Ditolak</span>
        </div>
    </div>
    <div class="stat-card stat-card--info">
        <div class="stat-card__icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z"/><path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z"/></svg>
        </div>
        <div class="stat-card__content">
            <span class="stat-card__value">{{ $totalSemua }}</span>
            <span class="stat-card__label">Total Pendaftaran</span>
        </div>
    </div>
</div>

<!-- Tabs Navigation -->
<div class="tabs-nav">
    <button class="tabs-nav__item active" data-tab="pending">
        <span class="tabs-nav__badge warning">{{ $totalPending }}</span>
        Menunggu Verifikasi
    </button>

    <button class="tabs-nav__item" data-tab="diterima">
        <span class="tabs-nav__badge success">{{ $totalDiterima }}</span>
        Diterima
    </button>
    <button class="tabs-nav__item" data-tab="ditolak">
        <span class="tabs-nav__badge danger">{{ $totalDitolak }}</span>
        Ditolak
    </button>
    <button class="tabs-nav__item" data-tab="semua">
        Semua Data
    </button>
</div>

<!-- Filter Section -->
<div class="card mb-4">
    <div class="card__body">
        <div class="filter-row">
            <div class="filter-group">
                <label for="search">Cari</label>
                <input type="text" id="search" placeholder="Nama siswa atau email..." class="form-input">
            </div>
            <div class="filter-group">
                <label for="tanggal">Tanggal Daftar</label>
                <input type="date" id="tanggal" class="form-input">
            </div>
            <div class="filter-group">
                <label for="kelas">Kelas Tujuan</label>
                <select id="kelas" class="form-select">
                    <option value="">Semua Kelas</option>
                    <option value="TK A">TK A</option>
                    <option value="TK B1">TK B1</option>
                    <option value="TK B2">TK B2</option>
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
                        <th>Tanggal Daftar</th>
                        <th>Data Siswa</th>
                        <th>Data Orang Tua</th>
                        <th>Kontak</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftaran as $index => $p)
                    <tr data-status="{{ strtolower($p['status']) }}">
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <span class="date-cell">{{ $p['tanggal_daftar'] }}</span>
                        </td>
                        <td>
                            <div class="student-cell">
                                <div class="student-cell__avatar {{ $p['jenis_kelamin'] == 'Perempuan' ? 'student-cell__avatar--female' : '' }}">
                                    {{ substr($p['nama_siswa'], 0, 1) }}
                                </div>
                                <div class="student-cell__info">
                                    <span class="student-cell__name">{{ $p['nama_siswa'] }}</span>
                                    <span class="student-cell__detail">{{ $p['jenis_kelamin'] }} • {{ $p['tempat_lahir'] }}, {{ $p['tanggal_lahir'] }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="parent-cell">
                                <span class="parent-cell__name">{{ $p['nama_ayah'] }} / {{ $p['nama_ibu'] }}</span>
                                <span class="parent-cell__job">{{ $p['pekerjaan_ayah'] ?? '-' }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="contact-cell">
                                <span class="contact-cell__email">{{ $p['email'] }}</span>
                                <span class="contact-cell__phone">{{ $p['telepon'] }}</span>
                            </div>
                        </td>
                        <td>
                            @php
                                $statusClass = match($p['status']) {
                                    'Pending' => 'warning',
                                    'Wawancara' => 'orange',
                                    'Diterima' => 'success',
                                    'Ditolak' => 'danger',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge badge--{{ $statusClass }}">{{ $p['status'] }}</span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.pendaftaran.show', $p['id']) }}" class="btn btn--icon btn--info" title="Lihat Detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd"/></svg>
                                </a>
                                @if($p['status'] == 'Pending')
                                <button type="button" class="btn btn--icon btn--success" title="Terima & Pilih Kelas" onclick="showAcceptModal('{{ $p['id'] }}', '{{ $p['nama_siswa'] }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/></svg>
                                </button>
                                <button type="button" class="btn btn--icon btn--danger" title="Tolak" onclick="showRejectModal('{{ $p['id'] }}', '{{ $p['nama_siswa'] }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">Belum ada data pendaftaran</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
/* Page Header */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.page-header__left { flex: 1; }

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.05);
}

.stat-card__icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stat-card__icon svg {
    width: 24px;
    height: 24px;
}

.stat-card--warning .stat-card__icon {
    background: rgba(245, 158, 11, 0.15);
    color: #d97706;
}

.stat-card--success .stat-card__icon {
    background: rgba(34, 197, 94, 0.15);
    color: #16a34a;
}

.stat-card--danger .stat-card__icon {
    background: rgba(239, 68, 68, 0.15);
    color: #dc2626;
}

.stat-card--info .stat-card__icon {
    background: rgba(76, 175, 130, 0.15);
    color: #4CAF82;
}

.stat-card__content {
    display: flex;
    flex-direction: column;
}

.stat-card__value {
    font-size: 1.75rem;
    font-weight: 700;
    color: #3E2723;
    line-height: 1;
}

.stat-card__label {
    font-size: 0.8rem;
    color: #5D4037;
    margin-top: 0.25rem;
}

/* Tabs Navigation */
.tabs-nav {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.tabs-nav__item {
    padding: 0.625rem 1rem;
    background: white;
    border: 1px solid rgba(0,0,0,0.1);
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    color: #5D4037;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
}

.tabs-nav__item:hover {
    background: #f8fafc;
    border-color: #4CAF82;
}

.tabs-nav__item.active {
    background: #4CAF82;
    color: white;
    border-color: #4CAF82;
}

.tabs-nav__badge {
    padding: 0.125rem 0.5rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
}

.tabs-nav__badge.warning {
    background: rgba(245, 158, 11, 0.2);
    color: #d97706;
}

.tabs-nav__badge.orange {
    background: rgba(234, 88, 12, 0.15);
    color: #ea580c;
}

.tabs-nav__badge.success {
    background: rgba(34, 197, 94, 0.2);
    color: #16a34a;
}

.tabs-nav__badge.danger {
    background: rgba(239, 68, 68, 0.2);
    color: #dc2626;
}

.tabs-nav__item.active .tabs-nav__badge {
    background: rgba(255,255,255,0.25);
    color: white;
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
    color: #5D4037;
}

.form-input, .form-select {
    padding: 0.5rem 0.75rem;
    border: 1px solid #3E272330;
    border-radius: 8px;
    font-size: 0.875rem;
    background: white;
}

.form-input:focus, .form-select:focus {
    outline: none;
    border-color: #4CAF82;
    box-shadow: 0 0 0 3px rgba(76, 175, 130, 0.1);
}

/* Table Styles */
.table-responsive { overflow-x: auto; }

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th,
.data-table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid #3E272320;
}

.data-table th {
    background: #FFFDE7;
    font-weight: 600;
    color: #3E2723;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.data-table tbody tr:hover {
    background: #FFFDE7;
}

/* Cells */
.date-cell {
    font-size: 0.85rem;
    color: #5D4037;
}

.student-cell {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.student-cell__avatar {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #3E2723, #4CAF82);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.95rem;
    flex-shrink: 0;
}

.student-cell__avatar--female {
    background: linear-gradient(135deg, #ec4899, #f472b6);
}

.student-cell__info {
    display: flex;
    flex-direction: column;
}

.student-cell__name {
    font-weight: 600;
    color: #3E2723;
}

.student-cell__detail {
    font-size: 0.75rem;
    color: #5D4037;
}

.parent-cell {
    display: flex;
    flex-direction: column;
}

.parent-cell__name {
    font-weight: 500;
    color: #3E2723;
}

.parent-cell__job {
    font-size: 0.75rem;
    color: #5D4037;
}

.contact-cell {
    display: flex;
    flex-direction: column;
}

.contact-cell__email {
    font-weight: 500;
    color: #3E2723;
    font-size: 0.85rem;
}

.contact-cell__phone {
    font-size: 0.75rem;
    color: #5D4037;
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

.badge--warning {
    background: rgba(245, 158, 11, 0.15);
    color: #d97706;
}

.badge--success {
    background: rgba(34, 197, 94, 0.15);
    color: #16a34a;
}

.badge--danger {
    background: rgba(239, 68, 68, 0.15);
    color: #dc2626;
}

.badge--orange {
    background: rgba(234, 88, 12, 0.12);
    color: #ea580c;
}

.badge--secondary {
    background: #f1f5f9;
    color: #5D4037;
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

.btn--info {
    background: rgba(76, 175, 130, 0.15);
    color: #4CAF82;
}

.btn--info:hover {
    background: rgba(76, 175, 130, 0.25);
}

.btn--success {
    background: rgba(34, 197, 94, 0.15);
    color: #16a34a;
}

.btn--success:hover {
    background: rgba(34, 197, 94, 0.25);
}

.btn--danger {
    background: #fee2e2;
    color: #c0392b;
}

.btn--danger:hover {
    background: #fecaca;
}

.btn--orange {
    background: rgba(234, 88, 12, 0.12);
    color: #ea580c;
}

.btn--orange:hover {
    background: rgba(234, 88, 12, 0.22);
}

/* Utilities */
.mb-4 { margin-bottom: 1rem; }
.p-0 { padding: 0 !important; }
.py-4 { padding-top: 1rem; padding-bottom: 1rem; }
.text-center { text-align: center; }

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

/* Modal */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s;
}

.modal-overlay.active {
    opacity: 1;
    visibility: visible;
}

.modal-box {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    max-width: 450px;
    width: 90%;
    text-align: center;
    transform: scale(0.9);
    transition: transform 0.3s;
}

.modal-overlay.active .modal-box {
    transform: scale(1);
}

.modal-icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
}

.modal-icon--success {
    background: #dcfce7;
}

.modal-icon--success svg {
    width: 32px;
    height: 32px;
    color: #16a34a;
}

.modal-icon--danger {
    background: #fee2e2;
}

.modal-icon--danger svg {
    width: 32px;
    height: 32px;
    color: #c0392b;
}

.modal-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #3E2723;
    margin-bottom: 0.5rem;
}

.modal-message {
    color: #5D4037;
    margin-bottom: 1.5rem;
}

.modal-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.modal-actions .btn {
    min-width: 100px;
    padding: 0.625rem 1.25rem;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    border: none;
}

.btn--secondary {
    background: #f1f5f9;
    color: #5D4037;
}

.btn--secondary:hover {
    background: #e2e8f0;
}

.btn--primary {
    background: #4CAF82;
    color: white;
}

.btn--primary:hover {
    background: #3D9B72;
}

.form-textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #3E272330;
    border-radius: 8px;
    font-size: 0.875rem;
    resize: vertical;
    margin-top: 1rem;
    text-align: left;
}

/* Kelas Grid */
.kelas-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
    margin-top: 1rem;
}

.kelas-option {
    cursor: pointer;
}

.kelas-option input[type="radio"] {
    display: none;
}

.kelas-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    border-radius: 10px;
    border: 2px solid transparent;
    transition: all 0.2s;
    cursor: pointer;
}

.kelas-card--a {
    background: rgba(76, 175, 130, 0.08);
    border-color: rgba(76, 175, 130, 0.2);
}

.kelas-card--b {
    background: rgba(99, 102, 241, 0.08);
    border-color: rgba(99, 102, 241, 0.2);
}

.kelas-option input[type="radio"]:checked + .kelas-card--a {
    border-color: #4CAF82;
    background: rgba(76, 175, 130, 0.15);
    box-shadow: 0 0 0 3px rgba(76, 175, 130, 0.2);
}

.kelas-option input[type="radio"]:checked + .kelas-card--b {
    border-color: #6366f1;
    background: rgba(99, 102, 241, 0.15);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
}

.kelas-label {
    font-size: 1.5rem;
    font-weight: 800;
    color: #3E2723;
    line-height: 1;
}

.kelas-desc {
    font-size: 0.75rem;
    color: #5D4037;
    margin-top: 0.25rem;
}
</style>

<!-- Accept Confirmation Modal -->
<div id="acceptModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-icon modal-icon--success">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </div>
        <h3 class="modal-title">Terima & Pilih Kelas</h3>
        <p class="modal-message">Pilih kelas untuk <strong id="acceptSiswaName"></strong></p>
        <form id="acceptForm" method="POST">
            @csrf
            <div class="kelas-grid">
                <label class="kelas-option">
                    <input type="radio" name="kelas" value="A1" required>
                    <span class="kelas-card kelas-card--a">
                        <span class="kelas-label">A1</span>
                        <span class="kelas-desc">TK A - Kelas 1</span>
                    </span>
                </label>
                <label class="kelas-option">
                    <input type="radio" name="kelas" value="A2" required>
                    <span class="kelas-card kelas-card--a">
                        <span class="kelas-label">A2</span>
                        <span class="kelas-desc">TK A - Kelas 2</span>
                    </span>
                </label>
                <label class="kelas-option">
                    <input type="radio" name="kelas" value="B1" required>
                    <span class="kelas-card kelas-card--b">
                        <span class="kelas-label">B1</span>
                        <span class="kelas-desc">TK B - Kelas 1</span>
                    </span>
                </label>
                <label class="kelas-option">
                    <input type="radio" name="kelas" value="B2" required>
                    <span class="kelas-card kelas-card--b">
                        <span class="kelas-label">B2</span>
                        <span class="kelas-desc">TK B - Kelas 2</span>
                    </span>
                </label>
            </div>
            <div class="modal-actions" style="margin-top: 1.5rem;">
                <button type="button" class="btn btn--secondary" onclick="closeAcceptModal()">Batal</button>
                <button type="submit" class="btn btn--primary">Terima & Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Reject Confirmation Modal -->
<div id="rejectModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-icon modal-icon--danger">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
            </svg>
        </div>
        <h3 class="modal-title">Tolak Pendaftaran?</h3>
        <p class="modal-message">Apakah Anda yakin ingin menolak pendaftaran <strong id="rejectSiswaName"></strong>?</p>
        <form id="rejectForm" method="POST">
            @csrf
            <textarea name="alasan_penolakan" class="form-textarea" rows="3" placeholder="Alasan penolakan (opsional)..."></textarea>
            <div class="modal-actions" style="margin-top: 1rem;">
                <button type="button" class="btn btn--secondary" onclick="closeRejectModal()">Batal</button>
                <button type="submit" class="btn btn--primary" style="background: #dc2626;">Ya, Tolak</button>
            </div>
        </form>
    </div>
</div>

<script>
// Tab Filtering
document.querySelectorAll('.tabs-nav__item').forEach(tab => {
    tab.addEventListener('click', function() {
        document.querySelectorAll('.tabs-nav__item').forEach(t => t.classList.remove('active'));
        this.classList.add('active');

        const status = this.dataset.tab;
        document.querySelectorAll('.data-table tbody tr').forEach(row => {
            if (status === 'semua') {
                row.style.display = '';
            } else {
                row.style.display = row.dataset.status === status ? '' : 'none';
            }
        });
    });
});

// Accept Modal
function showAcceptModal(id, name) {
    document.getElementById('acceptSiswaName').textContent = name;
    document.getElementById('acceptForm').action = "{{ url('admin/pendaftaran') }}/" + id + "/terima";
    document.getElementById('acceptModal').classList.add('active');
}

function closeAcceptModal() {
    document.getElementById('acceptModal').classList.remove('active');
    document.querySelectorAll('#acceptForm input[type="radio"]').forEach(r => r.checked = false);
}

// Reject Modal
function showRejectModal(id, name) {
    document.getElementById('rejectSiswaName').textContent = name;
    document.getElementById('rejectForm').action = "{{ url('admin/pendaftaran') }}/" + id + "/tolak";
    document.getElementById('rejectModal').classList.add('active');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.remove('active');
}

// Close modals when clicking outside
document.getElementById('acceptModal').addEventListener('click', function(e) {
    if (e.target === this) closeAcceptModal();
});

document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) closeRejectModal();
});
</script>
@endsection
