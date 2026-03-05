@extends('layouts.app')

@section('title', 'Edit Siswa')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="page-header">
    <div class="page-header__left">
        <h1 class="page-header__title">Edit Siswa</h1>
        <p class="page-header__subtitle">Perbarui data siswa</p>
    </div>
    <div class="page-header__actions">
        <a href="{{ route('admin.siswa.index') }}" class="btn btn--secondary">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path fill-rule="evenodd" d="M7.28 7.72a.75.75 0 0 1 0 1.06l-2.47 2.47H21a.75.75 0 0 1 0 1.5H4.81l2.47 2.47a.75.75 0 1 1-1.06 1.06l-3.75-3.75a.75.75 0 0 1 0-1.06l3.75-3.75a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/></svg>
            Kembali
        </a>
    </div>
</div>

@if($errors->any())
<div class="alert alert--danger">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card">
    <div class="card__header">
        <h3 class="card__title">Form Edit Siswa</h3>
    </div>
    <div class="card__body">
        <form action="{{ route('admin.siswa.update', $siswa['id']) }}" method="POST" class="form">
            @csrf
            @method('PUT')
            
            <div class="form-section">
                <h4 class="form-section__title">Data Pribadi</h4>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="nis" class="form-label required">NIS</label>
                        <input type="text" id="nis" name="nis" class="form-input" value="{{ old('nis', $siswa['nis']) }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="nama" class="form-label required">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" class="form-input" value="{{ old('nama', $siswa['nama']) }}" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="kelas" class="form-label required">Kelas</label>
                        <select id="kelas" name="kelas" class="form-select" required>
                            <option value="">Pilih Kelas</option>
                            <option value="TK A" {{ old('kelas', $siswa['kelas']) == 'TK A' ? 'selected' : '' }}>TK A</option>
                            <option value="TK B" {{ old('kelas', $siswa['kelas']) == 'TK B' ? 'selected' : '' }}>TK B</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="jenis_kelamin" class="form-label required">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-select" required>
                            <option value="">Pilih</option>
                            <option value="L" {{ old('jenis_kelamin', $siswa['jenis_kelamin']) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $siswa['jenis_kelamin']) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="tanggal_lahir" class="form-label required">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-input" value="{{ old('tanggal_lahir', $siswa['tanggal_lahir']) }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="status" class="form-label required">Status</label>
                        <select id="status" name="status" class="form-select" required>
                            <option value="Aktif" {{ old('status', $siswa['status']) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Lulus" {{ old('status', $siswa['status']) == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                            <option value="Pindah" {{ old('status', $siswa['status']) == 'Pindah' ? 'selected' : '' }}>Pindah</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea id="alamat" name="alamat" class="form-textarea" rows="3">{{ old('alamat', $siswa['alamat'] ?? '') }}</textarea>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="reset" class="btn btn--secondary">Reset</button>
                <button type="submit" class="btn btn--primary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/></svg>
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<style>
/* Form Styles */
.form {
    max-width: 900px;
}

.form-section {
    margin-bottom: 2rem;
}

.form-section__title {
    color: #00473e;
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.form-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

@media (max-width: 640px) {
    .form-row {
        grid-template-columns: 1fr;
    }
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-label {
    font-weight: 500;
    color: #00473e;
    font-size: 0.875rem;
}

.form-label.required::after {
    content: " *";
    color: #dc2626;
}

.form-input,
.form-select,
.form-textarea {
    padding: 0.75rem 1rem;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.875rem;
    transition: all 0.2s;
    background: white;
}

.form-textarea {
    resize: vertical;
    min-height: 80px;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: #00473e;
    box-shadow: 0 0 0 3px rgba(0, 71, 62, 0.1);
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e5e7eb;
}

/* Alert */
.alert--danger {
    background: #fee2e2;
    color: #dc2626;
    border: 1px solid #fecaca;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.alert--danger ul {
    margin: 0;
    padding-left: 1.25rem;
}

.mb-0 { margin-bottom: 0; }
</style>
@endsection
