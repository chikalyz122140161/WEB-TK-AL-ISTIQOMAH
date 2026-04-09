@extends('layouts.app')

@section('title', 'Backup Database')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-header__title">Backup Database</h1>
    <p class="page-header__subtitle">Kelola backup dan restore database sistem</p>
</div>

@if(session('success'))
<div class="alert alert--success">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert--danger">
    {{ session('error') }}
</div>
@endif

<!-- Backup Actions -->
<div class="backup-grid">
    <!-- Create Backup -->
    <div class="card">
        <div class="card__header">
            <h3 class="card__title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm.53 5.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l1.72-1.72v5.69a.75.75 0 0 0 1.5 0v-5.69l1.72 1.72a.75.75 0 1 0 1.06-1.06l-3-3Z" clip-rule="evenodd"/></svg>
                Buat Backup Baru
            </h3>
        </div>
        <div class="card__body">
            <p class="text-muted mb-4">Buat backup database untuk menyimpan semua data sistem saat ini.</p>
            
            <form action="{{ route('admin.backup.create') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn--primary btn--lg" onclick="return confirm('Buat backup database sekarang?')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm.53 5.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l1.72-1.72v5.69a.75.75 0 0 0 1.5 0v-5.69l1.72 1.72a.75.75 0 1 0 1.06-1.06l-3-3Z" clip-rule="evenodd"/></svg>
                    Buat Backup Sekarang
                </button>
            </form>
        </div>
    </div>
    
    <!-- Restore Backup -->
    <div class="card">
        <div class="card__header">
            <h3 class="card__title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-.53 14.03a.75.75 0 0 0 1.06 0l3-3a.75.75 0 1 0-1.06-1.06l-1.72 1.72V8.25a.75.75 0 0 0-1.5 0v5.69l-1.72-1.72a.75.75 0 0 0-1.06 1.06l3 3Z" clip-rule="evenodd"/></svg>
                Restore Database
            </h3>
        </div>
        <div class="card__body">
            <p class="text-muted mb-4">Pulihkan database dari file backup sebelumnya.</p>
            
            <form action="{{ route('admin.backup.restore') }}" method="POST" id="restoreForm">
                @csrf
                <div class="form-group mb-4">
                    <label for="backup_file" class="form-label required">Pilih File Backup</label>
                    <select id="backup_file" name="backup_file" class="form-select" required>
                        <option value="">-- Pilih Backup --</option>
                        @foreach($backups as $backup)
                            <option value="{{ $backup['filename'] }}">{{ $backup['filename'] }} ({{ $backup['tanggal'] }})</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group mb-4">
                    <label for="konfirmasi" class="form-label required">Konfirmasi</label>
                    <input type="text" id="konfirmasi" name="konfirmasi" class="form-input" placeholder="Ketik RESTORE untuk konfirmasi" required>
                    <small class="form-help">Ketik RESTORE untuk mengkonfirmasi restore database</small>
                </div>
                
                <div class="alert alert--warning mb-4">
                    <strong>Peringatan!</strong> Proses restore akan mengganti semua data saat ini dengan data dari backup. Tindakan ini tidak dapat dibatalkan.
                </div>
                
                <button type="submit" class="btn btn--warning btn--lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-.53 14.03a.75.75 0 0 0 1.06 0l3-3a.75.75 0 1 0-1.06-1.06l-1.72 1.72V8.25a.75.75 0 0 0-1.5 0v5.69l-1.72-1.72a.75.75 0 0 0-1.06 1.06l3 3Z" clip-rule="evenodd"/></svg>
                    Restore Database
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Backup History -->
<div class="card mt-4">
    <div class="card__header">
        <h3 class="card__title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd"/></svg>
            Riwayat Backup
        </h3>
    </div>
    <div class="card__body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama File</th>
                        <th>Tanggal</th>
                        <th>Ukuran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($backups as $index => $backup)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div class="file-cell">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20" class="file-icon"><path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd"/><path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z"/></svg>
                                <span>{{ $backup['filename'] }}</span>
                            </div>
                        </td>
                        <td>{{ $backup['tanggal'] }}</td>
                        <td><span class="badge badge--outline">{{ $backup['ukuran'] }}</span></td>
                        <td>
                            <div class="action-buttons">
                                <a href="#" class="btn btn--icon btn--secondary" title="Download">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path fill-rule="evenodd" d="M12 2.25a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V3a.75.75 0 0 1 .75-.75Zm-9 13.5a.75.75 0 0 1 .75.75v2.25a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5V16.5a.75.75 0 0 1 1.5 0v2.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V16.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
                                </a>
                                <form action="{{ route('admin.backup.delete', $backup['filename']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn--icon btn--danger" title="Hapus" onclick="showDeleteBackupModal('{{ $backup['filename'] }}', '{{ addslashes($backup['filename']) }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">Belum ada backup</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Delete Backup Confirmation Modal -->
<div id="deleteBackupModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:12px;padding:32px;max-width:420px;width:90%;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,0.2);">
        <div style="width:56px;height:56px;background:#fee2e2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#d81b60" style="width:28px;height:28px;"><path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd"/></svg>
        </div>
        <h3 style="font-size:18px;font-weight:700;color:#3E2723;margin:0 0 8px;">Hapus Backup?</h3>
        <p style="font-size:14px;color:#5D4037;margin:0 0 24px;">Apakah Anda yakin ingin menghapus file backup <strong id="deleteBackupName"></strong>? Tindakan ini tidak dapat dibatalkan.</p>
        <div style="display:flex;gap:12px;justify-content:center;">
            <button type="button" onclick="closeDeleteBackupModal()" style="padding:10px 24px;border-radius:8px;border:none;background:#FFFDE7;color:#5D4037;font-size:14px;font-weight:600;cursor:pointer;">Batal</button>
            <form id="deleteBackupForm" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" style="padding:10px 24px;border-radius:8px;border:none;background:#d81b60;color:#fff;font-size:14px;font-weight:600;cursor:pointer;">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
function showDeleteBackupModal(filename, label) {
    document.getElementById('deleteBackupName').textContent = label;
    document.getElementById('deleteBackupForm').action = "{{ url('admin/backup') }}/" + encodeURIComponent(filename);
    var modal = document.getElementById('deleteBackupModal');
    modal.style.display = 'flex';
}
function closeDeleteBackupModal() {
    document.getElementById('deleteBackupModal').style.display = 'none';
}
document.getElementById('deleteBackupModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteBackupModal();
});
</script>

<style>
/* Backup Grid */
.backup-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}

@media (max-width: 768px) {
    .backup-grid {
        grid-template-columns: 1fr;
    }
}

/* Text Styles */
.text-muted {
    color: #5D4037;
}

/* Alerts */
.alert {
    padding: 1rem;
    border-radius: 8px;
}

.alert--success {
    background: #dcfce7;
    color: #166534;
    border: 1px solid #86efac;
    margin-bottom: 1rem;
}

.alert--danger {
    background: #fee2e2;
    color: #c0392b;
    border: 1px solid #fecaca;
    margin-bottom: 1rem;
}

.alert--warning {
    background: #FFF176;
    color: #92400e;
    border: 1px solid #fcd34d;
}

/* Form Styles */
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
.form-select {
    padding: 0.75rem 1rem;
    border: 1px solid #3E272330;
    border-radius: 8px;
    font-size: 0.875rem;
    transition: all 0.2s;
    background: white;
}

.form-input:focus,
.form-select:focus {
    outline: none;
    border-color: #3E2723;
    box-shadow: 0 0 0 3px rgba(0, 71, 62, 0.1);
}

.form-help {
    font-size: 0.75rem;
    color: #5D4037;
}

/* Button Large */
.btn--lg {
    padding: 0.875rem 1.5rem;
    font-size: 1rem;
}

.btn--warning {
    background: #f59e0b;
    color: white;
}

.btn--warning:hover {
    background: #d97706;
}

/* File Cell */
.file-cell {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.file-icon {
    color: #3E2723;
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

/* Badge */
.badge--outline {
    background: transparent;
    border: 1px solid #3E272330;
    color: #5D4037;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
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
    background: #f1f5f9;
    color: #5D4037;
}

.btn--secondary:hover {
    background: #e2e8f0;
    color: #3E2723;
}

.btn--danger {
    background: #fee2e2;
    color: #c0392b;
}

.btn--danger:hover {
    background: #fecaca;
}

/* Utilities */
.mb-4 { margin-bottom: 1rem; }
.mt-4 { margin-top: 1rem; }
.p-0 { padding: 0 !important; }
.py-4 { padding-top: 1rem; padding-bottom: 1rem; }
.text-center { text-align: center; }
</style>
@endsection
