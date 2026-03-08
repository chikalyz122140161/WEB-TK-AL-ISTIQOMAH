@extends('layouts.app')

@section('title', 'Kelola Rapot Semester - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Kelola Rapot Semester')

@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

@push('styles')
<style>
    /* Header Actions */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 24px;
    }
    .page-header__title {
        font-size: 18px;
        font-weight: 700;
        color: #00473e;
        margin: 0;
    }
    .btn-tambah {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #faae2b 0%, #f5a623 100%);
        color: #00473e;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s;
    }
    .btn-tambah:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(250, 174, 43, 0.3);
    }
    .btn-tambah svg {
        width: 18px;
        height: 18px;
        fill: currentColor;
    }

    /* Filter Bar */
    .filter-bar {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .filter-bar__title {
        font-size: 14px;
        font-weight: 600;
        color: #00473e;
        margin-bottom: 16px;
    }
    .filter-row {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: flex-end;
    }
    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        min-width: 150px;
    }
    .filter-group label {
        font-size: 12px;
        font-weight: 500;
        color: #475d5b;
    }
    .filter-group select {
        padding: 10px 14px;
        border: 1px solid #00473e30;
        border-radius: 6px;
        font-size: 14px;
        color: #00473e;
        background: #fff;
        cursor: pointer;
    }
    .filter-group select:focus {
        outline: none;
        border-color: #faae2b;
        box-shadow: 0 0 0 3px rgba(250, 174, 43, 0.1);
    }
    .btn-filter {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, #00473e 0%, #006b5a 100%);
        color: #fff;
        padding: 10px 16px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        border-radius: 6px;
        transition: all 0.3s;
    }
    .btn-filter:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,71,62,0.3);
    }
    .btn-filter svg {
        width: 16px;
        height: 16px;
        fill: currentColor;
    }

    /* Data Table */
    .data-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    .data-table th,
    .data-table td {
        padding: 14px 16px;
        text-align: left;
        border-bottom: 1px solid #f0f0f0;
    }
    .data-table th {
        background: linear-gradient(135deg, #00473e 0%, #006b5a 100%);
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .data-table td {
        font-size: 14px;
        color: #475d5b;
    }
    .data-table tr:hover td {
        background: #f8fafc;
    }
    .data-table tr:last-child td {
        border-bottom: none;
    }

    /* Status Badge */
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
    }
    .status-badge.terbit {
        background: rgba(16, 185, 129, 0.15);
        color: #059669;
    }
    .status-badge.draft {
        background: rgba(245, 158, 11, 0.15);
        color: #d97706;
    }

    /* Action Buttons */
    .action-btns {
        display: flex;
        gap: 8px;
    }
    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }
    .btn-action svg {
        width: 16px;
        height: 16px;
        fill: currentColor;
    }
    .btn-action.view {
        background: rgba(59, 130, 246, 0.15);
        color: #3b82f6;
    }
    .btn-action.view:hover {
        background: #3b82f6;
        color: #fff;
    }
    .btn-action.edit {
        background: rgba(250, 174, 43, 0.15);
        color: #d4920c;
    }
    .btn-action.edit:hover {
        background: #faae2b;
        color: #00473e;
    }
    .btn-action.delete {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
    }
    .btn-action.delete:hover {
        background: #ef4444;
        color: #fff;
    }

    /* Alert */
    .alert {
        padding: 14px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
    }
    .alert-success {
        background: rgba(16, 185, 129, 0.15);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 60px 40px;
        color: #475d5b;
    }
    .empty-state svg {
        width: 64px;
        height: 64px;
        fill: #d1d5db;
        margin-bottom: 16px;
    }
    .empty-state h3 {
        color: #00473e;
        margin: 0 0 8px 0;
    }
    .empty-state p {
        margin: 0;
        font-size: 14px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .filter-row {
            flex-direction: column;
        }
        .filter-group {
            width: 100%;
        }
        .data-table {
            display: block;
            overflow-x: auto;
        }
    }
</style>
@endpush

@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Page Header --}}
    <div class="page-header">
        <h2 class="page-header__title">Daftar Rapot Semester</h2>
        <a href="{{ route('guru.rapot.create') }}" class="btn-tambah">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
            Tambah Rapot
        </a>
    </div>

    {{-- Filter Bar --}}
    <div class="filter-bar">
        <div class="filter-bar__title">Filter Data</div>
        <form action="{{ route('guru.rapot.index') }}" method="GET" class="filter-row">
            <div class="filter-group">
                <label>Kelas</label>
                <select name="kelas">
                    <option value="">Semua Kelas</option>
                    <option value="TK A" {{ $filterKelas == 'TK A' ? 'selected' : '' }}>TK A</option>
                    <option value="TK B" {{ $filterKelas == 'TK B' ? 'selected' : '' }}>TK B</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Semester</label>
                <select name="semester">
                    <option value="">Semua Semester</option>
                    <option value="Ganjil" {{ $filterSemester == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                    <option value="Genap" {{ $filterSemester == 'Genap' ? 'selected' : '' }}>Genap</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Tahun Ajaran</label>
                <select name="tahun">
                    <option value="">Semua Tahun</option>
                    <option value="2025/2026" {{ $filterTahun == '2025/2026' ? 'selected' : '' }}>2025/2026</option>
                    <option value="2024/2025" {{ $filterTahun == '2024/2025' ? 'selected' : '' }}>2024/2025</option>
                    <option value="2023/2024" {{ $filterTahun == '2023/2024' ? 'selected' : '' }}>2023/2024</option>
                </select>
            </div>
            <button type="submit" class="btn-filter">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M3.792 2.938A49.069 49.069 0 0 1 12 2.25c2.797 0 5.54.236 8.209.688a1.857 1.857 0 0 1 1.541 1.836v1.044a3 3 0 0 1-.879 2.121l-6.182 6.182a1.5 1.5 0 0 0-.439 1.061v2.927a3 3 0 0 1-1.658 2.684l-1.757.878A.75.75 0 0 1 9.75 21v-5.818a1.5 1.5 0 0 0-.44-1.06L3.13 7.938a3 3 0 0 1-.879-2.121V4.774c0-.897.64-1.683 1.542-1.836Z" clip-rule="evenodd"/></svg>
                Filter
            </button>
        </form>
    </div>

    {{-- Data Table --}}
    <div class="data-card">
        @if(count($rapotList) > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Tahun Ajaran</th>
                        <th>Semester</th>
                        <th>Tanggal Terbit</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rapotList as $index => $rapot)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $rapot['siswa'] }}</strong></td>
                            <td>{{ $rapot['kelas'] }}</td>
                            <td>{{ $rapot['tahun_ajaran'] }}</td>
                            <td>{{ $rapot['semester'] }}</td>
                            <td>{{ $rapot['tanggal_terbit'] ?? '-' }}</td>
                            <td>
                                <span class="status-badge {{ strtolower($rapot['status']) }}">
                                    {{ $rapot['status'] }}
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('guru.rapot.show', $rapot['id']) }}" class="btn-action view" title="Lihat">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113Z" clip-rule="evenodd"/></svg>
                                    </a>
                                    <a href="{{ route('guru.rapot.edit', $rapot['id']) }}" class="btn-action edit" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z"/></svg>
                                    </a>
                                    <button type="button" class="btn-action delete" title="Hapus" onclick="showDeleteModal('{{ $rapot['id'] }}', '{{ addslashes($rapot['siswa']) }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z"/><path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z"/></svg>
                <h3>Belum Ada Data Rapot</h3>
                <p>Klik tombol "Tambah Rapot" untuk menambahkan rapot semester baru.</p>
            </div>
        @endif
    </div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:12px;padding:32px;max-width:420px;width:90%;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,0.2);">
        <div style="width:56px;height:56px;background:#fee2e2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#dc2626" style="width:28px;height:28px;"><path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd"/></svg>
        </div>
        <h3 style="font-size:18px;font-weight:700;color:#00473e;margin:0 0 8px;">Hapus Rapot?</h3>
        <p style="font-size:14px;color:#475d5b;margin:0 0 24px;">Apakah Anda yakin ingin menghapus rapot milik <strong id="deleteRapotName"></strong>? Tindakan ini tidak dapat dibatalkan.</p>
        <div style="display:flex;gap:12px;justify-content:center;">
            <button type="button" onclick="closeDeleteModal()" style="padding:10px 24px;border-radius:8px;border:none;background:#f3f4f6;color:#475d5b;font-size:14px;font-weight:600;cursor:pointer;">Batal</button>
            <form id="deleteRapotForm" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" style="padding:10px 24px;border-radius:8px;border:none;background:#dc2626;color:#fff;font-size:14px;font-weight:600;cursor:pointer;">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showDeleteModal(id, name) {
    document.getElementById('deleteRapotName').textContent = name;
    document.getElementById('deleteRapotForm').action = "{{ url('guru/rapot') }}/" + id;
    var modal = document.getElementById('deleteModal');
    modal.style.display = 'flex';
}
function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
</script>
@endpush

@endsection
