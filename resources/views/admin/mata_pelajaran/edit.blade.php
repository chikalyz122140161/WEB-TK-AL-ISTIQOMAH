@extends('layouts.app')

@section('title', 'Edit Mata Pelajaran')
@section('page_title', 'Edit Mata Pelajaran')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="page-header">
    <div class="page-header__left">
    </div>
    <div class="page-header__actions">
        <a href="{{ route('admin.mata_pelajaran.index') }}" class="btn btn--secondary">
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
        <h3 class="card__title">Form Edit Mata Pelajaran</h3>
    </div>
    <div class="card__body">
        <form action="{{ route('admin.mata_pelajaran.update', $mataPelajaran->id) }}" method="POST" class="form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nama" class="form-label required">Nama Mata Pelajaran</label>
                <input type="text" id="nama" name="nama" class="form-input"
                    value="{{ old('nama', $mataPelajaran->name) }}" placeholder="Contoh: Sentra Balok, Bahasa Indonesia" required maxlength="100">
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.mata_pelajaran.index') }}" class="btn btn--secondary">Batal</a>
                <button type="submit" class="btn btn--primary">Perbarui Mata Pelajaran</button>
            </div>
        </form>
    </div>
</div>
@endsection
