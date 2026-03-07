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
        <form action="{{ route('admin.siswa.update', $siswa['id']) }}" method="POST" class="form" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-section">
                <h4 class="form-section__title">I. Identitas Anak</h4>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="nis" class="form-label required">NIS</label>
                        <input type="text" id="nis" name="nis" class="form-input" value="{{ old('nis', $siswa['nis']) }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="nama" class="form-label required">Nama Anak</label>
                        <input type="text" id="nama" name="nama" class="form-input" value="{{ old('nama', $siswa['nama']) }}" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="nama_panggilan" class="form-label required">Nama Panggilan</label>
                        <input type="text" id="nama_panggilan" name="nama_panggilan" class="form-input" value="{{ old('nama_panggilan', $siswa['nama_panggilan'] ?? '') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="kelas" class="form-label required">Kelas</label>
                        <select id="kelas" name="kelas" class="form-select" required>
                            <option value="">Pilih Kelas</option>
                            <option value="TK A" {{ old('kelas', $siswa['kelas']) == 'TK A' ? 'selected' : '' }}>TK A</option>
                            <option value="TK B" {{ old('kelas', $siswa['kelas']) == 'TK B' ? 'selected' : '' }}>TK B</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="jenis_kelamin" class="form-label required">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-select" required>
                            <option value="">Pilih</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin', $siswa['jenis_kelamin']) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $siswa['jenis_kelamin']) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="agama" class="form-label required">Agama</label>
                        <select id="agama" name="agama" class="form-select" required>
                            <option value="">Pilih Agama</option>
                            <option value="Islam" {{ old('agama', $siswa['agama'] ?? '') == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('agama', $siswa['agama'] ?? '') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ old('agama', $siswa['agama'] ?? '') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('agama', $siswa['agama'] ?? '') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('agama', $siswa['agama'] ?? '') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Konghucu" {{ old('agama', $siswa['agama'] ?? '') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="tempat_lahir" class="form-label required">Tempat Lahir</label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-input" value="{{ old('tempat_lahir', $siswa['tempat_lahir'] ?? '') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="tanggal_lahir" class="form-label required">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-input" value="{{ old('tanggal_lahir', $siswa['tanggal_lahir']) }}" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="anak_ke" class="form-label required">Anak ke</label>
                        <input type="number" id="anak_ke" name="anak_ke" class="form-input" value="{{ old('anak_ke', $siswa['anak_ke'] ?? '') }}" required min="1">
                    </div>
                    
                    <div class="form-group">
                        <label for="jumlah_saudara" class="form-label required">Jumlah Saudara</label>
                        <input type="number" id="jumlah_saudara" name="jumlah_saudara" class="form-input" value="{{ old('jumlah_saudara', $siswa['jumlah_saudara'] ?? '') }}" required min="0">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="suku_bangsa" class="form-label">Suku Bangsa</label>
                        <input type="text" id="suku_bangsa" name="suku_bangsa" class="form-input" value="{{ old('suku_bangsa', $siswa['suku_bangsa'] ?? '') }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="riwayat_penyakit" class="form-label">Riwayat Penyakit</label>
                        <input type="text" id="riwayat_penyakit" name="riwayat_penyakit" class="form-input" value="{{ old('riwayat_penyakit', $siswa['riwayat_penyakit'] ?? '') }}">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="berat_badan" class="form-label">Berat Badan (kg)</label>
                        <input type="text" id="berat_badan" name="berat_badan" class="form-input" value="{{ old('berat_badan', $siswa['berat_badan'] ?? '') }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="tinggi_badan" class="form-label">Tinggi Badan (cm)</label>
                        <input type="text" id="tinggi_badan" name="tinggi_badan" class="form-input" value="{{ old('tinggi_badan', $siswa['tinggi_badan'] ?? '') }}">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="alamat" class="form-label required">Alamat</label>
                    <textarea id="alamat" name="alamat" class="form-textarea" rows="3" required>{{ old('alamat', $siswa['alamat'] ?? '') }}</textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="no_telp" class="form-label required">No. Telp / HP</label>
                        <input type="text" id="no_telp" name="no_telp" class="form-input" value="{{ old('no_telp', $siswa['no_telp'] ?? '') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="status" class="form-label required">Status</label>
                        <select id="status" name="status" class="form-select status-select" required>
                            <option value="Pending" {{ old('status', $siswa['status']) == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Aktif" {{ old('status', $siswa['status']) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Lulus" {{ old('status', $siswa['status']) == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                            <option value="Pindah" {{ old('status', $siswa['status']) == 'Pindah' ? 'selected' : '' }}>Pindah</option>
                        </select>
                        <small class="form-hint">Status "Pending" untuk akun yang belum diaktivasi</small>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h4 class="form-section__title">II. Identitas Orang Tua / Wali Murid</h4>
                <p class="form-section__desc">Data orang tua yang terhubung dengan siswa ini</p>
                
                <h5 class="form-subsection__title">1. Ayah</h5>
                <div class="form-row">
                    <div class="form-group">
                        <label for="nama_ayah" class="form-label required">Nama Ayah</label>
                        <input type="text" id="nama_ayah" name="nama_ayah" class="form-input" value="{{ old('nama_ayah', $siswa['nama_ayah'] ?? '') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="pekerjaan_ayah" class="form-label">Pekerjaan / Pendidikan</label>
                        <input type="text" id="pekerjaan_ayah" name="pekerjaan_ayah" class="form-input" value="{{ old('pekerjaan_ayah', $siswa['pekerjaan_ayah'] ?? '') }}">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="tempat_lahir_ayah" class="form-label">Tempat Lahir Ayah</label>
                        <input type="text" id="tempat_lahir_ayah" name="tempat_lahir_ayah" class="form-input" value="{{ old('tempat_lahir_ayah', $siswa['tempat_lahir_ayah'] ?? '') }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="tanggal_lahir_ayah" class="form-label">Tanggal Lahir Ayah</label>
                        <input type="date" id="tanggal_lahir_ayah" name="tanggal_lahir_ayah" class="form-input" value="{{ old('tanggal_lahir_ayah', $siswa['tanggal_lahir_ayah'] ?? '') }}">
                    </div>
                </div>
                
                <h5 class="form-subsection__title">2. Ibu</h5>
                <div class="form-row">
                    <div class="form-group">
                        <label for="nama_ibu" class="form-label required">Nama Ibu</label>
                        <input type="text" id="nama_ibu" name="nama_ibu" class="form-input" value="{{ old('nama_ibu', $siswa['nama_ibu'] ?? '') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="pekerjaan_ibu" class="form-label">Pekerjaan / Pendidikan</label>
                        <input type="text" id="pekerjaan_ibu" name="pekerjaan_ibu" class="form-input" value="{{ old('pekerjaan_ibu', $siswa['pekerjaan_ibu'] ?? '') }}">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="tempat_lahir_ibu" class="form-label">Tempat Lahir Ibu</label>
                        <input type="text" id="tempat_lahir_ibu" name="tempat_lahir_ibu" class="form-input" value="{{ old('tempat_lahir_ibu', $siswa['tempat_lahir_ibu'] ?? '') }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="tanggal_lahir_ibu" class="form-label">Tanggal Lahir Ibu</label>
                        <input type="date" id="tanggal_lahir_ibu" name="tanggal_lahir_ibu" class="form-input" value="{{ old('tanggal_lahir_ibu', $siswa['tanggal_lahir_ibu'] ?? '') }}">
                    </div>
                </div>
                
                <h5 class="form-subsection__title">3. Wali (Opsional)</h5>
                <p class="form-section__desc">Isi jika ada wali selain orang tua</p>
                <div class="form-row">
                    <div class="form-group">
                        <label for="nama_wali" class="form-label">Nama Wali</label>
                        <input type="text" id="nama_wali" name="nama_wali" class="form-input" value="{{ old('nama_wali', $siswa['nama_wali'] ?? '') }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="pekerjaan_wali" class="form-label">Pekerjaan / Pendidikan</label>
                        <input type="text" id="pekerjaan_wali" name="pekerjaan_wali" class="form-input" value="{{ old('pekerjaan_wali', $siswa['pekerjaan_wali'] ?? '') }}">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="tempat_lahir_wali" class="form-label">Tempat Lahir Wali</label>
                        <input type="text" id="tempat_lahir_wali" name="tempat_lahir_wali" class="form-input" value="{{ old('tempat_lahir_wali', $siswa['tempat_lahir_wali'] ?? '') }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="tanggal_lahir_wali" class="form-label">Tanggal Lahir Wali</label>
                        <input type="date" id="tanggal_lahir_wali" name="tanggal_lahir_wali" class="form-input" value="{{ old('tanggal_lahir_wali', $siswa['tanggal_lahir_wali'] ?? '') }}">
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h4 class="form-section__title">Akun Orang Tua</h4>
                <p class="form-section__desc">Akun login orang tua untuk memantau perkembangan anak</p>
                
                <div class="linked-account-box">
                    <div class="linked-account-info">
                        <div class="linked-account-avatar">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd"/></svg>
                        </div>
                        <div class="linked-account-detail">
                            <span class="linked-account-name">{{ $siswa['nama_ayah'] ?? 'Orang Tua' }} / {{ $siswa['nama_ibu'] ?? '' }}</span>
                            <span class="linked-account-email">{{ $siswa['email_ortu'] ?? 'orangtua@example.com' }}</span>
                        </div>
                    </div>
                    <span class="badge badge--{{ ($siswa['status_akun_ortu'] ?? 'Aktif') == 'Pending' ? 'warning' : 'success' }}">{{ $siswa['status_akun_ortu'] ?? 'Terhubung' }}</span>
                </div>
                
                <div class="form-row" style="margin-top: 1rem;">
                    <div class="form-group">
                        <label for="email_ortu" class="form-label">Email Orang Tua</label>
                        <input type="email" id="email_ortu" name="email_ortu" class="form-input" value="{{ old('email_ortu', $siswa['email_ortu'] ?? '') }}" placeholder="email@contoh.com">
                    </div>
                    
                    <div class="form-group">
                        <label for="password_ortu" class="form-label">Password Baru</label>
                        <input type="password" id="password_ortu" name="password_ortu" class="form-input" placeholder="Kosongkan jika tidak diubah">
                        <small class="form-hint">Biarkan kosong jika tidak ingin mengubah password</small>
                    </div>
                </div>
                
                <div class="form-row" style="margin-top: 1rem;">
                    <div class="form-group">
                        <label for="status_akun_ortu" class="form-label required">Status Akun Orang Tua</label>
                        <select id="status_akun_ortu" name="status_akun_ortu" class="form-select status-select" required>
                            <option value="Pending" {{ old('status_akun_ortu', $siswa['status_akun_ortu'] ?? 'Aktif') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Aktif" {{ old('status_akun_ortu', $siswa['status_akun_ortu'] ?? 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Nonaktif" {{ old('status_akun_ortu', $siswa['status_akun_ortu'] ?? 'Aktif') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        <small class="form-hint">Aktifkan akun agar orang tua dapat login ke sistem</small>
                    </div>
                    <div class="form-group"></div>
                </div>
            </div>
            
            <div class="form-section">
                <h4 class="form-section__title">Dokumen Siswa</h4>
                <p class="form-section__desc">Kelola dokumen pendaftaran siswa (akta kelahiran, kartu keluarga, pas foto)</p>
                
                <!-- Existing Documents -->
                <div class="documents-list">
                    @php
                        $dokumen = $siswa['dokumen'] ?? [
                            ['id' => 1, 'nama' => 'Akta Kelahiran', 'file' => 'akta_kelahiran_001.pdf', 'type' => 'akta_kelahiran'],
                            ['id' => 2, 'nama' => 'Kartu Keluarga', 'file' => 'kk_001.pdf', 'type' => 'kartu_keluarga'],
                            ['id' => 3, 'nama' => 'Pas Foto', 'file' => 'foto_001.jpg', 'type' => 'foto'],
                        ];
                    @endphp
                    
                    @foreach($dokumen as $doc)
                    <div class="document-item" id="doc-{{ $doc['id'] }}">
                        <div class="document-info">
                            <div class="document-icon">
                                @if(str_contains($doc['file'], '.pdf'))
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd"/><path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z"/></svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24" height="24"><path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd"/></svg>
                                @endif
                            </div>
                            <div class="document-detail">
                                <span class="document-name">{{ $doc['nama'] }}</span>
                                <span class="document-filename">{{ $doc['file'] }}</span>
                            </div>
                        </div>
                        <div class="document-actions">
                            <a href="#" class="btn-doc btn-doc--view" title="Lihat">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd"/></svg>
                            </a>
                            <button type="button" class="btn-doc btn-doc--delete" onclick="deleteDocument({{ $doc['id'] }})" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd"/></svg>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Upload New Document -->
                <div class="upload-section">
                    <h5 class="upload-title">Tambah/Ganti Dokumen</h5>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="akta_kelahiran" class="form-label">Akta Kelahiran</label>
                            <input type="file" id="akta_kelahiran" name="akta_kelahiran" class="form-input-file" accept=".pdf,.jpg,.jpeg,.png">
                            <small class="form-hint">PDF, JPG, PNG (Maks. 2MB) - Kosongkan jika tidak diubah</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="kartu_keluarga" class="form-label">Kartu Keluarga</label>
                            <input type="file" id="kartu_keluarga" name="kartu_keluarga" class="form-input-file" accept=".pdf,.jpg,.jpeg,.png">
                            <small class="form-hint">PDF, JPG, PNG (Maks. 2MB) - Kosongkan jika tidak diubah</small>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="foto" class="form-label">Pas Foto Anak</label>
                            <input type="file" id="foto" name="foto" class="form-input-file" accept=".jpg,.jpeg,.png">
                            <small class="form-hint">JPG, PNG (Maks. 2MB) - Ukuran 3x4</small>
                        </div>
                        <div class="form-group"></div>
                    </div>
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
    margin-bottom: 0.5rem;
}

.form-section__desc {
    color: #64748b;
    font-size: 0.85rem;
    margin-bottom: 1rem;
}

.form-subsection__title {
    color: #374151;
    font-size: 0.9rem;
    font-weight: 600;
    margin: 1.25rem 0 0.75rem 0;
    padding-bottom: 0.5rem;
    border-bottom: 1px dashed #d1d5db;
}

.form-hint {
    color: #64748b;
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

/* Linked Account Box */
.linked-account-box {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 1rem;
}

.linked-account-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.linked-account-avatar {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #00473e, #0d9488);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.linked-account-detail {
    display: flex;
    flex-direction: column;
}

.linked-account-name {
    font-weight: 600;
    color: #00473e;
}

.linked-account-email {
    font-size: 0.85rem;
    color: #64748b;
}

.badge--success {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
}

.badge--warning {
    background: rgba(245, 158, 11, 0.15);
    color: #d97706;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
}

/* Status Select Styling */
.status-select option[value="Pending"] {
    background: #fef3c7;
    color: #d97706;
}

.status-select option[value="Aktif"] {
    background: #dcfce7;
    color: #16a34a;
}

.status-select option[value="Nonaktif"],
.status-select option[value="Lulus"],
.status-select option[value="Pindah"] {
    background: #f1f5f9;
    color: #64748b;
}

/* Documents List */
.documents-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.document-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 0.875rem 1rem;
    transition: all 0.2s;
}

.document-item:hover {
    background: #f1f5f9;
    border-color: #cbd5e1;
}

.document-info {
    display: flex;
    align-items: center;
    gap: 0.875rem;
}

.document-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #00473e, #0d9488);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.document-icon svg {
    width: 20px;
    height: 20px;
}

.document-detail {
    display: flex;
    flex-direction: column;
}

.document-name {
    font-weight: 600;
    color: #00473e;
    font-size: 0.9rem;
}

.document-filename {
    font-size: 0.8rem;
    color: #64748b;
}

.document-actions {
    display: flex;
    gap: 0.5rem;
}

.btn-doc {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-doc--view {
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
}

.btn-doc--view:hover {
    background: rgba(59, 130, 246, 0.2);
}

.btn-doc--delete {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
}

.btn-doc--delete:hover {
    background: rgba(239, 68, 68, 0.2);
}

/* Upload Section */
.upload-section {
    background: #f8fafc;
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    padding: 1.25rem;
}

.upload-title {
    color: #00473e;
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.form-input-file {
    padding: 0.5rem;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.875rem;
    background: white;
    width: 100%;
}

.form-input-file::-webkit-file-upload-button {
    background: linear-gradient(135deg, #00473e, #0d9488);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    cursor: pointer;
    margin-right: 0.75rem;
    font-weight: 500;
}

.form-input-file::-webkit-file-upload-button:hover {
    background: linear-gradient(135deg, #003830, #0a7d71);
}

.mb-0 { margin-bottom: 0; }
</style>

<script>
function deleteDocument(docId) {
    if(confirm('Apakah Anda yakin ingin menghapus dokumen ini?')) {
        // Dummy delete - just hide the element
        document.getElementById('doc-' + docId).style.display = 'none';
        // In real implementation, this would send an AJAX request to delete
    }
}
</script>
@endsection
