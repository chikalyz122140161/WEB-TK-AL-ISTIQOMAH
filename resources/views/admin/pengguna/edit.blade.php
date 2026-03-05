@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="page-header">
    <div class="page-header__left">
        <h1 class="page-header__title">Edit Pengguna</h1>
        <p class="page-header__subtitle">Perbarui data pengguna</p>
    </div>
    <div class="page-header__actions">
        <a href="{{ route('admin.pengguna.index') }}" class="btn btn--secondary">
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
        <h3 class="card__title">Form Edit Pengguna</h3>
    </div>
    <div class="card__body">
        <form action="{{ route('admin.pengguna.update', $pengguna['id']) }}" method="POST" class="form">
            @csrf
            @method('PUT')
            
            <div class="form-row">
                <div class="form-group">
                    <label for="nama" class="form-label required">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" class="form-input" value="{{ old('nama', $pengguna['nama']) }}" required>
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label required">Email</label>
                    <input type="email" id="email" name="email" class="form-input" value="{{ old('email', $pengguna['email']) }}" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="role" class="form-label required">Role</label>
                    <select id="role" name="role" class="form-select" required>
                        <option value="">Pilih Role</option>
                        <option value="admin" {{ old('role', $pengguna['role']) == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="guru" {{ old('role', $pengguna['role']) == 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="orangtua" {{ old('role', $pengguna['role']) == 'orangtua' ? 'selected' : '' }}>Orang Tua</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                    <input type="tel" id="nomor_telepon" name="nomor_telepon" class="form-input" value="{{ old('nomor_telepon', $pengguna['nomor_telepon'] ?? '') }}">
                </div>
            </div>
            
            <div class="form-divider">
                <span>Ubah Password (opsional)</span>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="password" class="form-label">Password Baru</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Kosongkan jika tidak ingin mengubah">
                </div>
                
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="Ulangi password baru">
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
    max-width: 800px;
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
.form-select {
    padding: 0.75rem 1rem;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.875rem;
    transition: all 0.2s;
    background: white;
}

.form-input:focus,
.form-select:focus {
    outline: none;
    border-color: #00473e;
    box-shadow: 0 0 0 3px rgba(0, 71, 62, 0.1);
}

.form-input::placeholder {
    color: #9ca3af;
}

.form-divider {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin: 1.5rem 0;
}

.form-divider::before,
.form-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #e5e7eb;
}

.form-divider span {
    color: #6b7280;
    font-size: 0.875rem;
    font-weight: 500;
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
