@extends('layouts.app')

@section('title', 'Edit Konseling')
@section('page_title', 'Edit Konseling')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@push('styles')
<style>
.poin-list {
    display: flex;
    flex-direction: column;
    gap: .6rem;
}
.poin-row {
    display: flex;
    align-items: center;
    gap: .6rem;
}
.poin-row .form-input {
    flex: 1;
}
.poin-empty-msg {
    color: #9ca3af;
    font-style: italic;
    font-size: .9rem;
    padding: .85rem 0;
}
.btn-remove-poin {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border: 1px solid rgba(240,98,146,0.3);
    background: rgba(240,98,146,0.08);
    color: #d81b72;
    border-radius: 8px;
    cursor: pointer;
    transition: all .15s;
}
.btn-remove-poin:hover {
    background: rgba(240,98,146,0.15);
}
.btn-add-poin {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    background: rgba(76,175,130,0.10);
    color: #2E8B60;
    border: 1px dashed rgba(76,175,130,0.5);
    padding: .55rem 1rem;
    border-radius: 8px;
    font-size: .875rem;
    font-weight: 500;
    cursor: pointer;
    margin-top: .5rem;
    transition: all .15s;
}
.btn-add-poin:hover {
    background: rgba(76,175,130,0.18);
}
.section-divider {
    margin: 1.5rem 0 1rem;
    padding-bottom: .5rem;
    border-bottom: 1px solid #e5e7eb;
    font-size: .9rem;
    font-weight: 600;
    color: #374151;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.section-hint {
    font-size: .8rem;
    color: #6b7280;
    font-weight: 400;
}
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="page-header__left">
    </div>
    <div class="page-header__actions">
        <a href="{{ route('admin.konseling.index') }}" class="btn btn--secondary">
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
        <h3 class="card__title">Form Edit Konseling</h3>
    </div>
    <div class="card__body">
        <form action="{{ route('admin.konseling.update', $konseling->id) }}" method="POST" class="form" id="konseling-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nama" class="form-label required">Nama Konseling</label>
                <input type="text" id="nama" name="nama" class="form-input"
                    value="{{ old('nama', $konseling->nama) }}" placeholder="Contoh: Konseling Sosial-Emosional" required maxlength="100">
            </div>

            <div class="section-divider">
                <span>Poin Penilaian</span>
                <span class="section-hint">Tambahkan poin penilaian sebanyak yang dibutuhkan</span>
            </div>

            @php
                $oldPoin = old('penilaian');
                if ($oldPoin === null) {
                    $oldPoin = collect($konseling->penilaian)->pluck('nama')->all();
                }
            @endphp

            <div class="poin-list" id="poin-list">
                @if(empty($oldPoin))
                    <div class="poin-empty-msg" id="poin-empty-msg">Belum ada poin penilaian. Klik tombol di bawah untuk menambah.</div>
                @else
                    @foreach($oldPoin as $p)
                    <div class="poin-row">
                        <input type="text" name="penilaian[]" class="form-input" value="{{ $p }}" placeholder="Contoh: Empati" maxlength="100">
                        <button type="button" class="btn-remove-poin" onclick="removePoin(this)" title="Hapus poin">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
                        </button>
                    </div>
                    @endforeach
                @endif
            </div>

            <button type="button" class="btn-add-poin" onclick="addPoin()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
                Tambah Poin Penilaian
            </button>

            <div class="form-actions" style="margin-top: 1.5rem;">
                <a href="{{ route('admin.konseling.index') }}" class="btn btn--secondary">Batal</a>
                <button type="submit" class="btn btn--primary">Perbarui Konseling</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function addPoin(value = '') {
    const list = document.getElementById('poin-list');
    const empty = document.getElementById('poin-empty-msg');
    if (empty) empty.remove();

    const row = document.createElement('div');
    row.className = 'poin-row';
    row.innerHTML = `
        <input type="text" name="penilaian[]" class="form-input" value="${value}" placeholder="Contoh: Empati" maxlength="100">
        <button type="button" class="btn-remove-poin" onclick="removePoin(this)" title="Hapus poin">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
        </button>
    `;
    list.appendChild(row);
    row.querySelector('input').focus();
}

function removePoin(btn) {
    btn.closest('.poin-row').remove();
    const list = document.getElementById('poin-list');
    if (list.children.length === 0) {
        const msg = document.createElement('div');
        msg.className = 'poin-empty-msg';
        msg.id = 'poin-empty-msg';
        msg.textContent = 'Belum ada poin penilaian. Klik tombol di bawah untuk menambah.';
        list.appendChild(msg);
    }
}
</script>
@endpush
