@extends('layouts.app')

@section('title', 'Kelola Siswa')
@section('page_title', 'Kelola Siswa')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="page-header">
    <div class="page-header__left">
    </div>
    <div class="page-header__actions">
        <a href="{{ route('admin.siswa.create') }}" class="btn btn--primary">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
            Tambah Siswa
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert--success">
    {{ session('success') }}
</div>
@endif

<!-- Filter Section -->
<div class="card mb-4">
    <div class="card__body">
        <div class="filter-row">
            <div class="filter-group">
                <label for="search">Cari</label>
                <input type="text" id="search" placeholder="NIS atau nama siswa..." class="form-input">
            </div>
            <div class="filter-group">
                <label for="kelas">Kelas</label>
                <select id="kelas" class="form-select">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $kelasName)
                        <option value="{{ $kelasName }}">Kelas {{ $kelasName }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label for="jk">Jenis Kelamin</label>
                <select id="jk" class="form-select">
                    <option value="">Semua</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="status">Status</label>
                <select id="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="pending">Pending</option>
                    <option value="inactive">Nonaktif</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Table -->
<div class="card">
    <div class="card__body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Orang Tua</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $index => $s)
                    <tr data-kelas="{{ $s['kelas'] }}"
                        data-jk="{{ $s['jk_raw'] }}"
                        data-status="{{ $s['status_raw'] }}"
                        data-search="{{ strtolower($s['nis'] . ' ' . $s['nama'] . ' ' . $s['nama_ortu']) }}">
                        <td>{{ $index + 1 }}</td>
                        <td><span class="badge badge--outline">{{ $s['nis'] }}</span></td>
                        <td>
                            <div class="student-cell">
                                <div class="student-cell__avatar {{ $s['jk'] == 'P' ? 'student-cell__avatar--female' : '' }}">
                                    {{ substr($s['nama'], 0, 1) }}
                                </div>
                                <span>{{ $s['nama'] }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="kelas-cell">
                                <span class="badge badge--kelas">{{ $s['kelas'] }}</span>
                                @if($s['class_term_id'])
                                <span class="kelas-cell__sub">{{ $s['tahun_ajaran'] }} · {{ ucfirst($s['semester']) }}</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="parent-cell">
                                <span class="parent-cell__name">{{ $s['nama_ortu'] ?? '-' }}</span>
                                @if(isset($s['email_ortu']))
                                <span class="parent-cell__email">{{ $s['email_ortu'] }}</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            @php
                                $statusClass = match($s['status']) {
                                    'Aktif'    => 'success',
                                    'Pending'  => 'warning',
                                    'Nonaktif' => 'danger',
                                    default    => 'secondary'
                                };
                            @endphp
                            <span class="badge badge--{{ $statusClass }}">{{ $s['status'] }}</span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.siswa.edit', $s['id']) }}" class="btn btn--secondary btn--sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="14" height="14"><path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z"/></svg>
                                    Edit
                                </a>
                                <button type="button" class="btn btn--kelas-edit btn--sm" onclick="showEditKelasModal('{{ $s['id'] }}', '{{ addslashes($s['nama']) }}', '{{ $s['class_term_id'] }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="14" height="14"><path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z"/><path d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.71 47.87 47.87 0 0 1-8.105 2.874.75.75 0 0 1-.832-.586 48.055 48.055 0 0 1 1.476-4Z"/></svg>
                                    Kelas
                                </button>
                                <button type="button" class="btn btn--danger btn--sm" onclick="showDeleteModal('{{ $s['id'] }}', '{{ $s['nama'] }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="14" height="14"><path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd"/></svg>
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">Belum ada data siswa</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
/* Page Header with Actions */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.page-header__left {
    flex: 1;
}

/* Filter Row */
.filter-row {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    min-width: 150px;
}

.filter-group label {
    font-size: 0.8rem;
    font-weight: 500;
    color: #5D4037;
}

.form-input, .form-select {
    padding: 0.5rem 0.75rem;
    border: 1px solid #3E272330;
    border-radius: 8px;
    font-size: 0.875rem;
    background: white;
}

.form-input:focus, .form-select:focus {
    outline: none;
    border-color: #3E2723;
    box-shadow: 0 0 0 3px rgba(0, 71, 62, 0.1);
}

/* Table Styles */
.table-responsive {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th,
.data-table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid #3E272320;
}

.data-table th {
    background: #FFFDE7;
    font-weight: 600;
    color: #3E2723;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.data-table tbody tr:hover {
    background: #FFFDE7;
}

/* Student Cell */
.student-cell {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.student-cell__avatar {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.875rem;
}

.student-cell__avatar--female {
    background: linear-gradient(135deg, #F06292, #F06292);
}

/* Parent Cell */
.parent-cell {
    display: flex;
    flex-direction: column;
}

.parent-cell__name {
    font-weight: 500;
    color: #3E2723;
}

.parent-cell__email {
    font-size: 0.75rem;
    color: #5D4037;
}

/* Badges */
.badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
}

.badge--outline {
    background: transparent;
    border: 1px solid #3E272330;
    color: #5D4037;
}

.badge--kelas {
    background: rgba(0, 71, 62, 0.1);
    color: #3E2723;
}

.kelas-cell { display: flex; flex-direction: column; gap: 3px; }
.kelas-cell__sub { font-size: 11px; color: #78716c; }

.badge--success {
    background: rgba(76, 175, 130, 0.15);
    color: #4CAF82;
}

.badge--secondary {
    background: #f1f5f9;
    color: #5D4037;
}

.badge--warning {
    background: #FFF176;
    color: #5D4037;
}

.badge--danger {
    background: #F0629220;
    color: #d81b72;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn--icon {
    width: 32px;
    height: 32px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}

.btn--secondary {
    background: #FFF176;
    color: #3E2723;
    border: 1.5px solid #e6db00;
}

.btn--secondary:hover {
    background: #f9ed50;
    color: #3E2723;
}

.btn--danger {
    background: #F06292;
    color: #ffffff;
    border: none;
}

.btn--danger:hover {
    background: #e91e8c;
}

.btn--kelas-edit {
    background: rgba(76,175,130,0.15);
    color: #2E8B60;
    border: 1.5px solid rgba(76,175,130,0.4);
}

.btn--kelas-edit:hover {
    background: rgba(76,175,130,0.25);
    color: #2E8B60;
}

/* Alerts */
.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.alert--success {
    background: rgba(76,175,130,0.12);
    color: #2E8B60;
    border: 1px solid rgba(76,175,130,0.3);
}

.mb-4 { margin-bottom: 1rem; }
.p-0 { padding: 0 !important; }
.py-4 { padding-top: 1rem; padding-bottom: 1rem; }
.text-center { text-align: center; }

/* Delete Modal */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
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
    max-width: 400px;
    width: 90%;
    text-align: center;
    transform: scale(0.9);
    transition: transform 0.3s;
}

.modal-overlay.active .modal-box {
    transform: scale(1);
}

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

.modal-actions .btn {
    min-width: 100px;
}
</style>

<!-- Edit Kelas Modal -->
<div id="editKelasModal" class="modal-overlay">
    <div class="modal-box" style="text-align:left;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;">
            <h3 class="modal-title" style="margin:0;">Edit Kelas Siswa</h3>
            <button type="button" onclick="closeEditKelasModal()" style="background:none;border:none;cursor:pointer;color:#a8a29e;padding:4px;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
            </button>
        </div>
        <p style="font-size:13px;color:#78716c;margin-bottom:1rem;">Pilih kelas tujuan untuk siswa <strong id="editKelasNama"></strong>.</p>
        <form id="editKelasForm" method="POST">
            @csrf
            @method('PUT')
            <div style="margin-bottom:1.25rem;">
                <label style="font-size:13px;font-weight:600;color:#5D4037;display:block;margin-bottom:6px;">Kelas</label>
                <select name="class_term_id" id="editKelasSelect"
                        style="width:100%;padding:9px 12px;border:1px solid #e7e5e4;border-radius:8px;font-size:14px;color:#3E2723;background:#FFFDE7;font-family:inherit;">
                    <option value="" disabled selected>-- Pilih Kelas --</option>
                    @foreach ($classTermOptions as $ct)
                    <option value="{{ $ct['id'] }}">{{ $ct['label'] }}</option>
                    @endforeach
                </select>
                @if ($classTermOptions->isEmpty())
                <p style="font-size:12px;color:#d97706;margin-top:6px;">Belum ada kelas aktif. Tambahkan class term terlebih dahulu.</p>
                @endif
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <button type="button" onclick="closeEditKelasModal()" style="background:#f5f5f4;color:#57534e;border:none;padding:9px 18px;border-radius:8px;font-size:14px;cursor:pointer;">Batal</button>
                <button type="submit" style="background:linear-gradient(135deg,#4CAF82,#3D9B72);color:#fff;border:none;padding:9px 22px;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
            </svg>
        </div>
        <h3 class="modal-title">Hapus Data Siswa?</h3>
        <p class="modal-message">Apakah Anda yakin ingin menghapus data siswa <strong id="deleteSiswaName"></strong>? Data orang tua terkait juga akan terpengaruh.</p>
        <div class="modal-actions">
            <button type="button" class="btn btn--secondary" onclick="closeDeleteModal()">Batal</button>
            <form id="deleteForm" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn--primary" style="background: #d81b60;">Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
function applyFilters() {
    const search = document.getElementById('search').value.toLowerCase().trim();
    const kelas  = document.getElementById('kelas').value;
    const jk     = document.getElementById('jk').value;
    const status = document.getElementById('status').value;

    document.querySelectorAll('.data-table tbody tr[data-kelas]').forEach(row => {
        const matchSearch = !search || row.dataset.search.includes(search);
        const matchKelas  = !kelas  || row.dataset.kelas  === kelas;
        const matchJk     = !jk     || row.dataset.jk     === jk;
        const matchStatus = !status || row.dataset.status === status;
        row.style.display = (matchSearch && matchKelas && matchJk && matchStatus) ? '' : 'none';
    });
}

document.getElementById('search').addEventListener('input', applyFilters);
document.getElementById('kelas').addEventListener('change', applyFilters);
document.getElementById('jk').addEventListener('change', applyFilters);
document.getElementById('status').addEventListener('change', applyFilters);

function showEditKelasModal(studentId, nama, currentClassTermId) {
    document.getElementById('editKelasNama').textContent = nama;
    document.getElementById('editKelasForm').action = "{{ url('admin/siswa') }}/" + studentId + "/class-term";
    var sel = document.getElementById('editKelasSelect');
    sel.value = currentClassTermId || '';
    document.getElementById('editKelasModal').classList.add('active');
}

function closeEditKelasModal() {
    document.getElementById('editKelasModal').classList.remove('active');
}

document.getElementById('editKelasModal').addEventListener('click', function(e) {
    if (e.target === this) closeEditKelasModal();
});

function showDeleteModal(id, name) {
    document.getElementById('deleteSiswaName').textContent = name;
    document.getElementById('deleteForm').action = "{{ url('admin/siswa') }}/" + id;
    document.getElementById('deleteModal').classList.add('active');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('active');
}

document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
</script>
@endsection
