@extends('layouts.app')

@section('title', 'Atur Aktivitas Tahun Ajaran')
@section('page_title', 'Atur Aktivitas Tahun Ajaran')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@push('styles')
<style>
.ta-info {
    background: linear-gradient(135deg, rgba(76,175,130,0.08) 0%, rgba(76,175,130,0.15) 100%);
    border: 1px solid rgba(76,175,130,0.3);
    border-radius: 12px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}
.ta-info__icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.ta-info__title {
    font-size: 1.05rem;
    font-weight: 700;
    color: #064e3b;
}
.ta-info__sub {
    font-size: .85rem;
    color: #047857;
}
.assign-section {
    margin-bottom: 1.75rem;
}
.assign-section__head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: .75rem;
    padding-bottom: .5rem;
    border-bottom: 1px solid #e5e7eb;
}
.assign-section__title {
    font-size: .95rem;
    font-weight: 600;
    color: #1f2937;
    display: flex;
    align-items: center;
    gap: .5rem;
}
.assign-section__title svg {
    width: 18px;
    height: 18px;
}
.assign-section__actions {
    display: flex;
    gap: .5rem;
}
.btn-link {
    background: transparent;
    border: none;
    color: #3D9B72;
    font-size: .8rem;
    font-weight: 500;
    cursor: pointer;
    padding: .25rem .5rem;
}
.btn-link:hover {
    color: #2E8B60;
    text-decoration: underline;
}
.checkbox-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: .5rem;
}
.checkbox-item {
    display: flex;
    align-items: center;
    gap: .6rem;
    padding: .65rem .85rem;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    cursor: pointer;
    transition: all .15s;
    background: #fff;
}
.checkbox-item:hover {
    border-color: #3D9B72;
    background: rgba(76,175,130,0.06);
}
.checkbox-item input[type="checkbox"] {
    width: 16px;
    height: 16px;
    cursor: pointer;
    accent-color: #3D9B72;
}
.checkbox-item input[type="checkbox"]:checked + span {
    font-weight: 600;
    color: #2E8B60;
}
.checkbox-item:has(input:checked) {
    border-color: rgba(76,175,130,0.4);
    background: rgba(76,175,130,0.08);
}
.checkbox-item span {
    font-size: .9rem;
    color: #374151;
}
.empty-msg {
    color: #9ca3af;
    font-style: italic;
    font-size: .9rem;
    padding: 1rem 0;
}
.section-icon--mapel { color: #3D9B72; }
.section-icon--ekskul { color: #2E8B60; }
.section-icon--konseling { color: #3D9B72; }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="page-header__left">
    </div>
    <div class="page-header__actions">
        <a href="{{ route('admin.aktivitas_tahun_ajaran.index') }}" class="btn btn--secondary">
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
    <div class="card__body">
        <div class="ta-info">
            <div class="ta-info__icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="22" height="22"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd"/></svg>
            </div>
            <div>
                <div class="ta-info__title">Tahun Ajaran {{ $tahunAjaran->academic_year }}</div>
                <div class="ta-info__sub">Semester {{ ucfirst($tahunAjaran->semester) }}</div>
            </div>
        </div>

        <form action="{{ route('admin.aktivitas_tahun_ajaran.update', $tahunAjaran->id) }}" method="POST" id="assign-form">
            @csrf
            @method('PUT')

            {{-- Mata Pelajaran --}}
            <div class="assign-section">
                <div class="assign-section__head">
                    <div class="assign-section__title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="section-icon--mapel"><path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z"/></svg>
                        Mata Pelajaran ({{ $mataPelajaran->count() }})
                    </div>
                    <div class="assign-section__actions">
                        <button type="button" class="btn-link" onclick="toggleAll('mata_pelajaran_ids', true)">Pilih Semua</button>
                        <button type="button" class="btn-link" onclick="toggleAll('mata_pelajaran_ids', false)">Kosongkan</button>
                    </div>
                </div>
                @if($mataPelajaran->isEmpty())
                    <div class="empty-msg">Belum ada mata pelajaran. Tambah dulu di menu Kelola Mata Pelajaran.</div>
                @else
                    <div class="checkbox-grid">
                        @foreach($mataPelajaran as $m)
                            <label class="checkbox-item">
                                <input type="checkbox" name="mata_pelajaran_ids[]" value="{{ $m->id }}"
                                    {{ in_array($m->id, old('mata_pelajaran_ids', $assigned['mata_pelajaran_ids'])) ? 'checked' : '' }}>
                                <span>{{ $m->name }}</span>
                            </label>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Ekstrakurikuler --}}
            <div class="assign-section">
                <div class="assign-section__head">
                    <div class="assign-section__title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="section-icon--ekskul"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006Z" clip-rule="evenodd"/></svg>
                        Ekstrakurikuler ({{ $ekstrakurikuler->count() }})
                    </div>
                    <div class="assign-section__actions">
                        <button type="button" class="btn-link" onclick="toggleAll('ekstrakurikuler_ids', true)">Pilih Semua</button>
                        <button type="button" class="btn-link" onclick="toggleAll('ekstrakurikuler_ids', false)">Kosongkan</button>
                    </div>
                </div>
                @if($ekstrakurikuler->isEmpty())
                    <div class="empty-msg">Belum ada ekstrakurikuler. Tambah dulu di menu Kelola Ekstrakurikuler.</div>
                @else
                    <div class="checkbox-grid">
                        @foreach($ekstrakurikuler as $e)
                            <label class="checkbox-item">
                                <input type="checkbox" name="ekstrakurikuler_ids[]" value="{{ $e->id }}"
                                    {{ in_array($e->id, old('ekstrakurikuler_ids', $assigned['ekstrakurikuler_ids'])) ? 'checked' : '' }}>
                                <span>{{ $e->name }}</span>
                            </label>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Konseling --}}
            <div class="assign-section">
                <div class="assign-section__head">
                    <div class="assign-section__title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="section-icon--konseling"><path fill-rule="evenodd" d="M9 4.5a.75.75 0 0 1 .721.544l.813 2.846a3.75 3.75 0 0 0 2.576 2.576l2.846.813a.75.75 0 0 1 0 1.442l-2.846.813a3.75 3.75 0 0 0-2.576 2.576l-.813 2.846a.75.75 0 0 1-1.442 0l-.813-2.846a3.75 3.75 0 0 0-2.576-2.576l-2.846-.813a.75.75 0 0 1 0-1.442l2.846-.813A3.75 3.75 0 0 0 7.466 7.89l.813-2.846A.75.75 0 0 1 9 4.5ZM18 1.5a.75.75 0 0 1 .728.568l.258 1.036c.236.94.97 1.674 1.91 1.91l1.036.258a.75.75 0 0 1 0 1.456l-1.036.258c-.94.236-1.674.97-1.91 1.91l-.258 1.036a.75.75 0 0 1-1.456 0l-.258-1.036a2.625 2.625 0 0 0-1.91-1.91l-1.036-.258a.75.75 0 0 1 0-1.456l1.036-.258a2.625 2.625 0 0 0 1.91-1.91l.258-1.036A.75.75 0 0 1 18 1.5Z" clip-rule="evenodd"/></svg>
                        Konseling ({{ $konseling->count() }})
                    </div>
                    <div class="assign-section__actions">
                        <button type="button" class="btn-link" onclick="toggleAll('konseling_ids', true)">Pilih Semua</button>
                        <button type="button" class="btn-link" onclick="toggleAll('konseling_ids', false)">Kosongkan</button>
                    </div>
                </div>
                @if($konseling->isEmpty())
                    <div class="empty-msg">Belum ada konseling. Tambah dulu di menu Kelola Konseling.</div>
                @else
                    <div class="checkbox-grid">
                        @foreach($konseling as $k)
                            <label class="checkbox-item">
                                <input type="checkbox" name="konseling_ids[]" value="{{ $k->id }}"
                                    {{ in_array($k->id, old('konseling_ids', $assigned['konseling_ids'])) ? 'checked' : '' }}>
                                <span>{{ $k->name }}</span>
                            </label>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.aktivitas_tahun_ajaran.index') }}" class="btn btn--secondary">Batal</a>
                <button type="submit" class="btn btn--primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleAll(name, checked) {
    document.querySelectorAll(`input[name="${name}[]"]`).forEach(cb => cb.checked = checked);
}
</script>
@endpush
