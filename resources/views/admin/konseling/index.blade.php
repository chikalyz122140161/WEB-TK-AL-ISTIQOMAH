@extends('layouts.app')

@section('title', 'Kelola Konseling')
@section('page_title', 'Kelola Konseling')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@push('styles')
<style>
.konseling-table {
    width: 100%;
    border-collapse: collapse;
}
.konseling-table thead tr {
    background: #f8fafb;
    border-bottom: 2px solid #e5e7eb;
}
.konseling-table th {
    padding: 14px 20px;
    font-size: .8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: #5D4037;
    text-align: left;
    white-space: nowrap;
}
.konseling-table td {
    padding: 16px 20px;
    font-size: .95rem;
    color: #374151;
    border-bottom: 1px solid #f3f4f6;
    vertical-align: middle;
}
.konseling-table tbody tr:last-child td {
    border-bottom: none;
}
.konseling-table tbody tr:hover td {
    background: #FFFDE7;
}
.konseling-name {
    font-weight: 600;
    color: #111827;
}
.row-no {
    color: #9ca3af;
    font-size: .875rem;
    font-weight: 500;
}
.poin-chips {
    display: flex;
    flex-wrap: wrap;
    gap: .35rem;
}
.poin-chip {
    display: inline-flex;
    align-items: center;
    background: rgba(76,175,130,0.12);
    color: #2E8B60;
    border: 1px solid rgba(76,175,130,0.3);
    border-radius: 99px;
    padding: .25rem .7rem;
    font-size: .8rem;
    font-weight: 500;
}
.poin-empty {
    color: #9ca3af;
    font-style: italic;
    font-size: .875rem;
}
.poin-count {
    display: inline-block;
    background: #FFFDE7;
    color: #5D4037;
    border: 1px solid #e6db00;
    border-radius: 99px;
    padding: .2rem .65rem;
    font-size: .75rem;
    font-weight: 600;
    margin-left: .35rem;
}
.btn-row {
    display: flex;
    align-items: center;
    gap: .5rem;
}
.modal-overlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s;
}
.modal-overlay.active {
    opacity: 1;
    visibility: visible;
}
.modal-box {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    max-width: 420px;
    width: 90%;
    text-align: center;
    transform: scale(0.9);
    transition: transform 0.3s;
}
.modal-overlay.active .modal-box { transform: scale(1); }
.modal-icon {
    width: 64px;
    height: 64px;
    background: #F0629220;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
}
.modal-icon svg {
    width: 32px;
    height: 32px;
    color: #d81b72;
}
.modal-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #3E2723;
    margin-bottom: 0.5rem;
}
.modal-message {
    color: #5D4037;
    margin-bottom: 1.5rem;
}
.modal-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
}
.modal-actions .btn { min-width: 100px; }
.card__body {
    overflow-x: scroll;
}
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="page-header__left">
    </div>
    <div class="page-header__actions">
        <a href="{{ route('admin.konseling.create') }}" class="btn btn--primary">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
            Tambah Konseling
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert--success">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert--danger">{{ session('error') }}</div>
@endif

<div class="card">
    <div class="card__header">
        <h3 class="card__title">Daftar Konseling</h3>
        <span class="badge badge--primary">{{ $konseling->count() }} Konseling</span>
    </div>
    <div class="card__body p-0">
        @if($konseling->isEmpty())
        <div class="empty-state" style="padding: 3rem; text-align:center;">
            <p style="color:#6b7280;margin-bottom:1rem;">Belum ada konseling yang ditambahkan.</p>
            <a href="{{ route('admin.konseling.create') }}" class="btn btn--primary">Tambah Konseling Pertama</a>
        </div>
        @else
        <table class="konseling-table">
            <thead>
                <tr>
                    <th style="width:60px;">No</th>
                    <th style="width:260px;">Nama Konseling</th>
                    <th>Poin Penilaian</th>
                    <th style="width:160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($konseling as $i => $k)
                <tr>
                    <td class="row-no">{{ $i + 1 }}</td>
                    <td>
                        <span class="konseling-name">{{ $k->name }}</span>
                        <span class="poin-count">{{ $k->assessments->count() }} poin</span>
                    </td>
                    <td>
                        @if($k->assessments->isEmpty())
                            <span class="poin-empty">Belum ada poin penilaian</span>
                        @else
                            <div class="poin-chips">
                                @foreach($k->assessments as $p)
                                    <span class="poin-chip">{{ $p->name }}</span>
                                @endforeach
                            </div>
                        @endif
                    </td>
                    <td>
                        <div class="btn-row">
                            <a href="{{ route('admin.konseling.edit', $k->id) }}" class="btn btn--secondary btn--sm">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="15" height="15"><path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z"/></svg>
                                Edit
                            </a>
                            <button type="button" class="btn btn--danger btn--sm"
                                    onclick="showDeleteModal('{{ $k->id }}', '{{ $k->name }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="15" height="15"><path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd"/></svg>
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

<div id="deleteModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
            </svg>
        </div>
        <h3 class="modal-title">Hapus Konseling?</h3>
        <p class="modal-message">Apakah Anda yakin ingin menghapus konseling <strong id="deleteKonselingName"></strong>? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="modal-actions">
            <button type="button" class="btn btn--secondary" onclick="closeDeleteModal()">Batal</button>
            <form id="deleteForm" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn--primary" style="background:#d81b60;">Hapus</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showDeleteModal(id, name) {
    document.getElementById('deleteKonselingName').textContent = name;
    document.getElementById('deleteForm').action = "{{ url('admin/konseling') }}/" + id;
    document.getElementById('deleteModal').classList.add('active');
}
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('active');
}
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
</script>
@endpush
