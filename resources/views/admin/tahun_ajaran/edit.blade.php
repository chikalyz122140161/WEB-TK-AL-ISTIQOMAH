@extends('layouts.app')

@section('title', 'Edit Tahun Ajaran')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="page-header">
    <div class="page-header__left">
        <h1 class="page-header__title">Edit Tahun Ajaran</h1>
        <p class="page-header__subtitle">Perbarui data tahun ajaran dan semester</p>
    </div>
    <div class="page-header__actions">
        <a href="{{ route('admin.tahun_ajaran.index') }}" class="btn btn--secondary">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path fill-rule="evenodd" d="M7.28 7.72a.75.75 0 0 1 0 1.06l-2.47 2.47H21a.75.75 0 0 1 0 1.5H4.81l2.47 2.47a.75.75 0 1 1-1.06 1.06l-3.75-3.75a.75.75 0 0 1 0-1.06l3.75-3.75a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/></svg>
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

<div class="card" style="max-width:560px;">
    <div class="card__header">
        <h3 class="card__title">Form Edit Tahun Ajaran</h3>
    </div>
    <div class="card__body">
        <form action="{{ route('admin.tahun_ajaran.update', $item->id) }}" method="POST" class="form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="tahun_ajaran" class="form-label required">Tahun Ajaran</label>
                <input type="text" id="tahun_ajaran" name="tahun_ajaran" class="form-input"
                    value="{{ old('tahun_ajaran', $item->tahun_ajaran) }}" placeholder="contoh: 2025/2026" required>
            </div>

            <div class="form-group">
                <label for="semester" class="form-label required">Semester</label>
                <select id="semester" name="semester" class="form-select" required>
                    <option value="">-- Pilih Semester --</option>
                    <option value="ganjil" {{ old('semester', $item->semester) == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                    <option value="genap"  {{ old('semester', $item->semester) == 'genap'  ? 'selected' : '' }}>Genap</option>
                </select>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.tahun_ajaran.index') }}" class="btn btn--secondary">Batal</a>
                <button type="submit" class="btn btn--primary">Perbarui</button>
            </div>
        </form>
    </div>
</div>
@endsection
