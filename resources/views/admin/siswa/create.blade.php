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
                <h4 class="form-section__title">I. Identitas Anak</h4>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="nis" class="form-label required">NIS</label>
                        <input type="text" id="nis" name="nis" class="form-input" value="{{ old('nis') }}" required placeholder="Nomor Induk Siswa">
                    </div>
                    
                    <div class="form-group">
                        <label for="nama" class="form-label required">Nama Anak</label>
                        <input type="text" id="nama" name="nama" class="form-input" value="{{ old('nama') }}" required placeholder="Nama lengkap anak">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="nama_panggilan" class="form-label required">Nama Panggilan</label>
                        <input type="text" id="nama_panggilan" name="nama_panggilan" class="form-input" value="{{ old('nama_panggilan') }}" required placeholder="Nama panggilan sehari-hari">
                    </div>
                    
                    <div class="form-group">
                        <label for="kelas" class="form-label required">Kelas</label>
                        <select id="kelas" name="kelas" class="form-select" required>
                            <option value="">Pilih Kelas</option>
                            <option value="TK A" {{ old('kelas') == 'TK A' ? 'selected' : '' }}>TK A</option>
                            <option value="TK B" {{ old('kelas') == 'TK B' ? 'selected' : '' }}>TK B</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="jenis_kelamin" class="form-label required">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-select" required>
                            <option value="">Pilih</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="agama" class="form-label required">Agama</label>
                        <select id="agama" name="agama" class="form-select" required>
                            <option value="">Pilih Agama</option>
                            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="tempat_lahir" class="form-label required">Tempat Lahir</label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-input" value="{{ old('tempat_lahir') }}" required placeholder="Contoh: Bandar Lampung">
                    </div>
                    
                    <div class="form-group">
                        <label for="tanggal_lahir" class="form-label required">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-input" value="{{ old('tanggal_lahir') }}" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="anak_ke" class="form-label required">Anak ke</label>
                        <input type="number" id="anak_ke" name="anak_ke" class="form-input" value="{{ old('anak_ke') }}" required min="1" placeholder="Contoh: 2">
                    </div>
                    
                    <div class="form-group">
                        <label for="jumlah_saudara" class="form-label required">Jumlah Saudara</label>
                        <input type="number" id="jumlah_saudara" name="jumlah_saudara" class="form-input" value="{{ old('jumlah_saudara') }}" required min="0" placeholder="Contoh: 1">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="suku_bangsa" class="form-label">Suku Bangsa</label>
                        <input type="text" id="suku_bangsa" name="suku_bangsa" class="form-input" value="{{ old('suku_bangsa') }}" placeholder="Contoh: Jawa, Lampung">
                    </div>
                    
                    <div class="form-group">
                        <label for="riwayat_penyakit" class="form-label">Riwayat Penyakit</label>
                        <input type="text" id="riwayat_penyakit" name="riwayat_penyakit" class="form-input" value="{{ old('riwayat_penyakit') }}" placeholder="Kosongkan jika tidak ada">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="berat_badan" class="form-label">Berat Badan (kg)</label>
                        <input type="text" id="berat_badan" name="berat_badan" class="form-input" value="{{ old('berat_badan') }}" placeholder="Contoh: 13">
                    </div>
                    
                    <div class="form-group">
                        <label for="tinggi_badan" class="form-label">Tinggi Badan (cm)</label>
                        <input type="text" id="tinggi_badan" name="tinggi_badan" class="form-input" value="{{ old('tinggi_badan') }}" placeholder="Contoh: 95">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="alamat" class="form-label required">Alamat</label>
                    <textarea id="alamat" name="alamat" class="form-textarea" rows="3" placeholder="Alamat lengkap" required>{{ old('alamat') }}</textarea>
                </div>
                
                <div class="form-group">
                    <label for="no_telp" class="form-label required">No. Telp / HP</label>
                    <input type="text" id="no_telp" name="no_telp" class="form-input" value="{{ old('no_telp') }}" required placeholder="Contoh: 0822 8965 2973">
                </div>
            </div>
            
            <div class="form-section">
                <h4 class="form-section__title">II. Identitas Orang Tua / Wali Murid</h4>
                <p class="form-section__desc">Data orang tua akan otomatis terhubung dengan akun siswa</p>
                
                <h5 class="form-subsection__title">1. Ayah</h5>
                <div class="form-row">
                    <div class="form-group">
                        <label for="nama_ayah" class="form-label required">Nama Ayah</label>
                        <input type="text" id="nama_ayah" name="nama_ayah" class="form-input" value="{{ old('nama_ayah') }}" required placeholder="Nama lengkap ayah">
                    </div>
                    
                    <div class="form-group">
                        <label for="pekerjaan_ayah" class="form-label">Pekerjaan / Pendidikan</label>
                        <input type="text" id="pekerjaan_ayah" name="pekerjaan_ayah" class="form-input" value="{{ old('pekerjaan_ayah') }}" placeholder="Contoh: Buruh">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="tempat_lahir_ayah" class="form-label">Tempat Lahir Ayah</label>
                        <input type="text" id="tempat_lahir_ayah" name="tempat_lahir_ayah" class="form-input" value="{{ old('tempat_lahir_ayah') }}" placeholder="Contoh: Pemalang">
                    </div>
                    
                    <div class="form-group">
                        <label for="tanggal_lahir_ayah" class="form-label">Tanggal Lahir Ayah</label>
                        <input type="date" id="tanggal_lahir_ayah" name="tanggal_lahir_ayah" class="form-input" value="{{ old('tanggal_lahir_ayah') }}">
                    </div>
                </div>
                
                <h5 class="form-subsection__title">2. Ibu</h5>
                <div class="form-row">
                    <div class="form-group">
                        <label for="nama_ibu" class="form-label required">Nama Ibu</label>
                        <input type="text" id="nama_ibu" name="nama_ibu" class="form-input" value="{{ old('nama_ibu') }}" required placeholder="Nama lengkap ibu">
                    </div>
                    
                    <div class="form-group">
                        <label for="pekerjaan_ibu" class="form-label">Pekerjaan / Pendidikan</label>
                        <input type="text" id="pekerjaan_ibu" name="pekerjaan_ibu" class="form-input" value="{{ old('pekerjaan_ibu') }}" placeholder="Contoh: Pengurus Rumah Tangga">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="tempat_lahir_ibu" class="form-label">Tempat Lahir Ibu</label>
                        <input type="text" id="tempat_lahir_ibu" name="tempat_lahir_ibu" class="form-input" value="{{ old('tempat_lahir_ibu') }}" placeholder="Contoh: Teratkulon">
                    </div>
                    
                    <div class="form-group">
                        <label for="tanggal_lahir_ibu" class="form-label">Tanggal Lahir Ibu</label>
                        <input type="date" id="tanggal_lahir_ibu" name="tanggal_lahir_ibu" class="form-input" value="{{ old('tanggal_lahir_ibu') }}">
                    </div>
                </div>
                
                <h5 class="form-subsection__title">3. Wali (Opsional)</h5>
                <p class="form-section__desc">Isi jika ada wali selain orang tua</p>
                <div class="form-row">
                    <div class="form-group">
                        <label for="nama_wali" class="form-label">Nama Wali</label>
                        <input type="text" id="nama_wali" name="nama_wali" class="form-input" value="{{ old('nama_wali') }}" placeholder="Nama lengkap wali">
                    </div>
                    
                    <div class="form-group">
                        <label for="pekerjaan_wali" class="form-label">Pekerjaan / Pendidikan</label>
                        <input type="text" id="pekerjaan_wali" name="pekerjaan_wali" class="form-input" value="{{ old('pekerjaan_wali') }}" placeholder="Pekerjaan wali">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="tempat_lahir_wali" class="form-label">Tempat Lahir Wali</label>
                        <input type="text" id="tempat_lahir_wali" name="tempat_lahir_wali" class="form-input" value="{{ old('tempat_lahir_wali') }}" placeholder="Tempat lahir wali">
                    </div>
                    
                    <div class="form-group">
                        <label for="tanggal_lahir_wali" class="form-label">Tanggal Lahir Wali</label>
                        <input type="date" id="tanggal_lahir_wali" name="tanggal_lahir_wali" class="form-input" value="{{ old('tanggal_lahir_wali') }}">
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h4 class="form-section__title">Akun Orang Tua</h4>
                <p class="form-section__desc">Buat akun untuk orang tua agar dapat login ke sistem dan memantau perkembangan anak</p>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="email_ortu" class="form-label required">Email Orang Tua</label>
                        <input type="email" id="email_ortu" name="email_ortu" class="form-input" value="{{ old('email_ortu') }}" required placeholder="email@contoh.com">
                        <small class="form-hint">Email ini akan digunakan untuk login</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="password_ortu" class="form-label required">Password</label>
                        <input type="password" id="password_ortu" name="password_ortu" class="form-input" required placeholder="Minimal 6 karakter">
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
    border-bottom: 1px solid #3E272320;
}

.form-section:last-of-type {
    border-bottom: none;
}

.form-section__title {
    color: #3E2723;
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.form-section__desc {
    color: #5D4037;
    font-size: 0.85rem;
    margin-bottom: 1rem;
}

.form-subsection__title {
    color: #3E2723;
    font-size: 0.9rem;
    font-weight: 600;
    margin: 1.25rem 0 0.75rem 0;
    padding-bottom: 0.5rem;
    border-bottom: 1px dashed #3E272330;
}

.form-hint {
    color: #5D4037;
    font-size: 0.75rem;
    margin-top: 0.25rem;
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
    color: #3E2723;
    font-size: 0.875rem;
}

.form-label.required::after {
    content: " *";
    color: #c0392b;
}

.form-input,
.form-select,
.form-textarea {
    padding: 0.75rem 1rem;
    border: 1px solid #3E272330;
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
    border-color: #3E2723;
    box-shadow: 0 0 0 3px rgba(0, 71, 62, 0.1);
}

.form-input::placeholder,
.form-textarea::placeholder {
    color: #5D4037;
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #3E272320;
}

/* Alert */
.alert--danger {
    background: #fee2e2;
    color: #c0392b;
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
