@extends('layouts.app')

@section('title', 'Tambah Siswa')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="page-header">
    <div class="page-header__left">
        <h1 class="page-header__title">Tambah Siswa</h1>
        <p class="page-header__subtitle">Tambah data siswa baru</p>
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
        <h3 class="card__title">Form Data Siswa</h3>
    </div>
    <div class="card__body">
        <form action="{{ route('admin.siswa.store') }}" method="POST" class="form">
            @csrf
            
            <div class="form-section">
                <h4 class="form-section__title">Data Pribadi</h4>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="nis" class="form-label required">NIS</label>
                        <input type="text" id="nis" name="nis" class="form-input" value="{{ old('nis') }}" required placeholder="Nomor Induk Siswa">
                    </div>
                    
                    <div class="form-group">
                        <label for="nama" class="form-label required">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" class="form-input" value="{{ old('nama') }}" required placeholder="Nama lengkap siswa">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="kelas" class="form-label required">Kelas</label>
                        <select id="kelas" name="kelas" class="form-select" required>
                            <option value="">Pilih Kelas</option>
                            <option value="TK A" {{ old('kelas') == 'TK A' ? 'selected' : '' }}>TK A</option>
                            <option value="TK B" {{ old('kelas') == 'TK B' ? 'selected' : '' }}>TK B</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="jenis_kelamin" class="form-label required">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-select" required>
                            <option value="">Pilih</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-input" value="{{ old('tempat_lahir') }}" placeholder="Kota tempat lahir">
                    </div>
                    
                    <div class="form-group">
                        <label for="tanggal_lahir" class="form-label required">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-input" value="{{ old('tanggal_lahir') }}" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea id="alamat" name="alamat" class="form-textarea" rows="3" placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
                </div>
            </div>
            
            <div class="form-section">
                <h4 class="form-section__title">Data Orang Tua</h4>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="nama_ayah" class="form-label">Nama Ayah</label>
                        <input type="text" id="nama_ayah" name="nama_ayah" class="form-input" value="{{ old('nama_ayah') }}" placeholder="Nama lengkap ayah">
                    </div>
                    
                    <div class="form-group">
                        <label for="nama_ibu" class="form-label">Nama Ibu</label>
                        <input type="text" id="nama_ibu" name="nama_ibu" class="form-input" value="{{ old('nama_ibu') }}" placeholder="Nama lengkap ibu">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="nomor_telepon_ortu" class="form-label">Nomor Telepon</label>
                        <input type="tel" id="nomor_telepon_ortu" name="nomor_telepon_ortu" class="form-input" value="{{ old('nomor_telepon_ortu') }}" placeholder="08xxxxxxxxxx">
                    </div>
                    
                    <div class="form-group">
                        <label for="pekerjaan_ortu" class="form-label">Pekerjaan Orang Tua</label>
                        <input type="text" id="pekerjaan_ortu" name="pekerjaan_ortu" class="form-input" value="{{ old('pekerjaan_ortu') }}" placeholder="Pekerjaan orang tua">
                    </div>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="reset" class="btn btn--secondary">Reset</button>
                <button type="submit" class="btn btn--primary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/></svg>
                    Simpan
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
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
}

.form-section:last-of-type {
    border-bottom: none;
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

.form-input::placeholder,
.form-textarea::placeholder {
    color: #9ca3af;
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
