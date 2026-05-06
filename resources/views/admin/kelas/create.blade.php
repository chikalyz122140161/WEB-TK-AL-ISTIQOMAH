@extends('layouts.app')

@section('title', 'Tambah Kelas')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@push('styles')
<style>
.kelas-info-strip { display: flex; gap: 10px; margin-bottom: 16px; flex-wrap: wrap; }
.kelas-info-item { flex: 1; min-width: 140px; border-radius: 8px; padding: 12px 16px; font-size: 13px; }
.kelas-info-item--green { background: rgba(76,175,130,0.1); border: 1px solid rgba(76,175,130,0.3); color: #2E8B60; }
.kelas-info-item--yellow { background: #FFF176; border: 1px solid #e6db00; color: #5D4037; }
.kelas-info-item--pink { background: rgba(240,98,146,0.08); border: 1px solid rgba(240,98,146,0.25); color: #d81b72; }
.kelas-info-item strong { display: block; font-weight: 700; margin-bottom: 3px; }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="page-header__left">
        <h1 class="page-header__title">Tambah Kelas</h1>
        <p class="page-header__subtitle">Tambah data kelas baru</p>
    </div>
    <div class="page-header__actions">
        <a href="{{ route('admin.kelas.index') }}" class="btn btn--secondary">
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

<div class="kelas-info-strip">
    <div class="kelas-info-item kelas-info-item--green">
        <strong>TK A</strong>Kelas untuk anak usia 4–5 tahun
    </div>
    <div class="kelas-info-item kelas-info-item--yellow">
        <strong>TK B</strong>Kelas untuk anak usia 5–6 tahun
    </div>
    <div class="kelas-info-item kelas-info-item--pink">
        <strong>Perhatian</strong>Jumlah maksimum siswa per kelas berlaku
    </div>
</div>

<div class="card">
    <div class="card__header">
        <h3 class="card__title">Form Data Kelas</h3>
    </div>
    <div class="card__body">
        <form action="{{ route('admin.kelas.store') }}" method="POST" class="form">
            @csrf

            <div class="form-group">
                <label for="nama" class="form-label required">Nama Kelas</label>
                <select id="nama" name="nama" class="form-select" required>
                    <option value="">Pilih Kelas</option>
                    @foreach($available as $nama)
                        <option value="{{ $nama }}" {{ old('nama') == $nama ? 'selected' : '' }}>{{ $nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="jumlah_maksimum" class="form-label required">Jumlah Maksimum Siswa</label>
                <input type="number" id="jumlah_maksimum" name="jumlah_maksimum" class="form-input"
                    value="{{ old('jumlah_maksimum', 20) }}" required min="1" max="50">
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.kelas.index') }}" class="btn btn--secondary">Batal</a>
                <button type="submit" class="btn btn--primary">Simpan Kelas</button>
            </div>
        </form>
    </div>
</div>
@endsection
