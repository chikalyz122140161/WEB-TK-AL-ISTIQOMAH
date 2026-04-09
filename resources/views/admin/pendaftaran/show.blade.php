@extends('layouts.app')

@section('title', 'Detail Pendaftaran')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="page-header">
    <div class="page-header__left">
        <h1 class="page-header__title">Detail Pendaftaran</h1>
        <p class="page-header__subtitle">Informasi lengkap data pendaftaran siswa</p>
    </div>
    <div class="page-header__actions">
        <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn--secondary">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path fill-rule="evenodd" d="M7.28 7.72a.75.75 0 0 1 0 1.06l-2.47 2.47H21a.75.75 0 0 1 0 1.5H4.81l2.47 2.47a.75.75 0 1 1-1.06 1.06l-3.75-3.75a.75.75 0 0 1 0-1.06l3.75-3.75a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/></svg>
            Kembali
        </a>
        @if($pendaftaran['status'] == 'Pending')
        <button type="button" class="btn btn--success" onclick="showAcceptModal()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/></svg>
            Terima
        </button>
        <button type="button" class="btn btn--danger" onclick="showRejectModal()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
            Tolak
        </button>
        @endif
    </div>
</div>

<!-- Status Banner -->
<div class="status-banner status-banner--{{ strtolower($pendaftaran['status']) }}">
    <div class="status-banner__icon">
        @if($pendaftaran['status'] == 'Pending')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd"/></svg>
        @elseif($pendaftaran['status'] == 'Diterima')
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd"/></svg>
        @else
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd"/></svg>
        @endif
    </div>
    <div class="status-banner__content">
        <span class="status-banner__label">Status Pendaftaran</span>
        <span class="status-banner__value">{{ $pendaftaran['status'] }}</span>
    </div>
    <div class="status-banner__date">
        Tanggal Daftar: {{ $pendaftaran['tanggal_daftar'] }}
    </div>
</div>

<div class="detail-grid">
    <!-- Data Siswa -->
    <div class="card">
        <div class="card__header">
            <h3 class="card__title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd"/></svg>
                Data Calon Siswa
            </h3>
        </div>
        <div class="card__body">
            <div class="detail-row">
                <div class="detail-item">
                    <label>Nama Lengkap</label>
                    <span>{{ $pendaftaran['nama_siswa'] }}</span>
                </div>
                <div class="detail-item">
                    <label>Nama Panggilan</label>
                    <span>{{ $pendaftaran['nama_panggilan'] ?? '-' }}</span>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-item">
                    <label>Tempat, Tanggal Lahir</label>
                    <span>{{ $pendaftaran['tempat_lahir'] }}, {{ $pendaftaran['tanggal_lahir'] }}</span>
                </div>
                <div class="detail-item">
                    <label>Jenis Kelamin</label>
                    <span>{{ $pendaftaran['jenis_kelamin'] }}</span>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-item">
                    <label>Agama</label>
                    <span>{{ $pendaftaran['agama'] ?? 'Islam' }}</span>
                </div>
                <div class="detail-item">
                    <label>Anak ke / Jumlah Saudara</label>
                    <span>{{ $pendaftaran['anak_ke'] ?? '-' }} / {{ $pendaftaran['jumlah_saudara'] ?? '-' }}</span>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-item full-width">
                    <label>Alamat</label>
                    <span>{{ $pendaftaran['alamat_siswa'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Orang Tua -->
    <div class="card">
        <div class="card__header">
            <h3 class="card__title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M10.5 1.875a1.125 1.125 0 0 1 2.25 0v8.219c.517.162 1.02.382 1.5.659V3.375a1.125 1.125 0 0 1 2.25 0v10.937a4.505 4.505 0 0 0-3.25 2.373 8.963 8.963 0 0 1-4-.188V3.375a1.125 1.125 0 0 1 2.25 0v7.5a.75.75 0 0 0 1.5 0V1.875ZM4.5 6.75A1.125 1.125 0 0 1 5.625 5.625h.375a.75.75 0 0 0 0-1.5h-.375A2.625 2.625 0 0 0 3 6.75v10.5A2.625 2.625 0 0 0 5.625 19.875H6a.75.75 0 0 0 0-1.5h-.375A1.125 1.125 0 0 1 4.5 17.25V6.75Z"/><path d="M18.375 5.625h.375a.75.75 0 0 1 0 1.5h-.375c-.621 0-1.125.504-1.125 1.125v2.344A4.467 4.467 0 0 1 18.75 10.5c.103 0 .206.003.308.009V6.75A2.625 2.625 0 0 0 16.5 4.125H16.125a.75.75 0 0 0 0 1.5H16.5c.621 0 1.125.504 1.125 1.125v.375c0 .621.504 1.125 1.125 1.125ZM18.75 12a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm4.5 3a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z"/></svg>
                Data Orang Tua / Wali
            </h3>
        </div>
        <div class="card__body">
            <h4 class="subsection-title">Ayah</h4>
            <div class="detail-row">
                <div class="detail-item">
                    <label>Nama Ayah</label>
                    <span>{{ $pendaftaran['nama_ayah'] }}</span>
                </div>
                <div class="detail-item">
                    <label>Pekerjaan</label>
                    <span>{{ $pendaftaran['pekerjaan_ayah'] ?? '-' }}</span>
                </div>
            </div>
            
            <h4 class="subsection-title">Ibu</h4>
            <div class="detail-row">
                <div class="detail-item">
                    <label>Nama Ibu</label>
                    <span>{{ $pendaftaran['nama_ibu'] }}</span>
                </div>
                <div class="detail-item">
                    <label>Pekerjaan</label>
                    <span>{{ $pendaftaran['pekerjaan_ibu'] ?? '-' }}</span>
                </div>
            </div>
            
            <h4 class="subsection-title">Kontak</h4>
            <div class="detail-row">
                <div class="detail-item">
                    <label>Nomor Telepon</label>
                    <span>{{ $pendaftaran['telepon'] }}</span>
                </div>
                <div class="detail-item">
                    <label>Email</label>
                    <span>{{ $pendaftaran['email'] }}</span>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-item full-width">
                    <label>Alamat Orang Tua</label>
                    <span>{{ $pendaftaran['alamat_ortu'] ?? $pendaftaran['alamat_siswa'] }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Dokumen Pendaftaran -->
<div class="card">
    <div class="card__header">
        <h3 class="card__title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd"/><path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z"/></svg>
            Dokumen Pendaftaran
        </h3>
    </div>
    <div class="card__body">
        <div class="documents-grid">
            @forelse($pendaftaran['dokumen'] ?? [] as $doc)
            <div class="document-item">
                <div class="document-icon">
                    @if(in_array(pathinfo($doc['file'], PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd"/></svg>
                    @else
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" clip-rule="evenodd"/><path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z"/></svg>
                    @endif
                </div>
                <div class="document-info">
                    <span class="document-name">{{ $doc['nama'] }}</span>
                    <span class="document-type">{{ strtoupper(pathinfo($doc['file'], PATHINFO_EXTENSION)) }}</span>
                </div>
                <a href="#" class="document-download" title="Download">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path fill-rule="evenodd" d="M12 2.25a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V3a.75.75 0 0 1 .75-.75Zm-9 13.5a.75.75 0 0 1 .75.75v2.25a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5V16.5a.75.75 0 0 1 1.5 0v2.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V16.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
                </a>
            </div>
            @empty
            <div class="no-documents">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="48" height="48"><path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875ZM12.75 12a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V18a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V12Z" clip-rule="evenodd"/><path d="M14.25 5.25a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963A5.23 5.23 0 0 0 16.5 7.5h-1.875a.375.375 0 0 1-.375-.375V5.25Z"/></svg>
                <p>Belum ada dokumen yang diunggah</p>
            </div>
            @endforelse
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

.page-header__actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1rem;
    border-radius: 8px;
    font-weight: 500;
    font-size: 0.875rem;
    cursor: pointer;
    border: none;
    transition: all 0.2s;
}

.btn--secondary {
    background: #f1f5f9;
    color: #5D4037;
}

.btn--secondary:hover {
    background: #e2e8f0;
}

.btn--success {
    background: #16a34a;
    color: white;
}

.btn--success:hover {
    background: #15803d;
}

.btn--danger {
    background: #dc2626;
    color: white;
}

.btn--danger:hover {
    background: #b91c1c;
}

/* Status Banner */
.status-banner {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.5rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
}

.status-banner--pending {
    background: rgba(245, 158, 11, 0.1);
    border: 1px solid rgba(245, 158, 11, 0.3);
}

.status-banner--diterima {
    background: rgba(34, 197, 94, 0.1);
    border: 1px solid rgba(34, 197, 94, 0.3);
}

.status-banner--ditolak {
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.status-banner__icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.status-banner__icon svg {
    width: 28px;
    height: 28px;
}

.status-banner--pending .status-banner__icon {
    background: rgba(245, 158, 11, 0.2);
    color: #d97706;
}

.status-banner--diterima .status-banner__icon {
    background: rgba(34, 197, 94, 0.2);
    color: #16a34a;
}

.status-banner--ditolak .status-banner__icon {
    background: rgba(239, 68, 68, 0.2);
    color: #dc2626;
}

.status-banner__content {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.status-banner__label {
    font-size: 0.8rem;
    color: #5D4037;
}

.status-banner__value {
    font-size: 1.25rem;
    font-weight: 700;
    color: #3E2723;
}

.status-banner__date {
    font-size: 0.875rem;
    color: #5D4037;
}

/* Detail Grid */
.detail-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

/* Card */
.card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.05);
}

.card__header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #3E272315;
}

.card__title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1rem;
    font-weight: 600;
    color: #3E2723;
}

.card__title svg {
    color: #4CAF82;
}

.card__body {
    padding: 1.5rem;
}

/* Detail Row */
.detail-row {
    display: flex;
    gap: 1.5rem;
    margin-bottom: 1rem;
}

.detail-row:last-child {
    margin-bottom: 0;
}

.detail-item {
    flex: 1;
}

.detail-item.full-width {
    flex: 100%;
}

.detail-item label {
    display: block;
    font-size: 0.75rem;
    font-weight: 500;
    color: #5D4037;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.25rem;
}

.detail-item span {
    display: block;
    font-size: 0.95rem;
    color: #3E2723;
    font-weight: 500;
}

/* Subsection Title */
.subsection-title {
    font-size: 0.85rem;
    font-weight: 600;
    color: #4CAF82;
    margin-top: 1.25rem;
    margin-bottom: 0.75rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px dashed #4CAF8230;
}

.subsection-title:first-child {
    margin-top: 0;
}

/* Documents Grid */
.documents-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1rem;
}

.document-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: #FFFDE7;
    border-radius: 8px;
    border: 1px solid rgba(0,0,0,0.05);
}

.document-icon {
    width: 44px;
    height: 44px;
    background: white;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #4CAF82;
    flex-shrink: 0;
}

.document-icon svg {
    width: 24px;
    height: 24px;
}

.document-info {
    flex: 1;
    min-width: 0;
}

.document-name {
    display: block;
    font-weight: 500;
    color: #3E2723;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.document-type {
    font-size: 0.75rem;
    color: #5D4037;
}

.document-download {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #4CAF82;
    transition: all 0.2s;
}

.document-download:hover {
    background: white;
}

.no-documents {
    grid-column: 1 / -1;
    text-align: center;
    padding: 2rem;
    color: #5D4037;
}

.no-documents svg {
    color: #cbd5e1;
    margin-bottom: 0.5rem;
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

@media (max-width: 768px) {
    .detail-grid {
        grid-template-columns: 1fr;
    }
    
    .detail-row {
        flex-direction: column;
        gap: 1rem;
    }
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
        <h3 class="modal-title">Terima Pendaftaran?</h3>
        <p class="modal-message">Apakah Anda yakin ingin menerima pendaftaran <strong>{{ $pendaftaran['nama_siswa'] }}</strong>? Data siswa dan akun orang tua akan diaktifkan.</p>
        <div class="modal-actions">
            <button type="button" class="btn btn--secondary" onclick="closeAcceptModal()">Batal</button>
            <form action="{{ route('admin.pendaftaran.terima', $pendaftaran['id']) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn--primary">Ya, Terima</button>
            </form>
        </div>
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
        <p class="modal-message">Apakah Anda yakin ingin menolak pendaftaran <strong>{{ $pendaftaran['nama_siswa'] }}</strong>?</p>
        <form action="{{ route('admin.pendaftaran.tolak', $pendaftaran['id']) }}" method="POST">
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
function showAcceptModal() {
    document.getElementById('acceptModal').classList.add('active');
}

function closeAcceptModal() {
    document.getElementById('acceptModal').classList.remove('active');
}

function showRejectModal() {
    document.getElementById('rejectModal').classList.add('active');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.remove('active');
}

document.getElementById('acceptModal').addEventListener('click', function(e) {
    if (e.target === this) closeAcceptModal();
});

document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) closeRejectModal();
});
</script>
@endsection
