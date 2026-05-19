@extends('layouts.app')

@section('title', 'Edit Pengguna')
@section('page_title', 'Edit Pengguna')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="page-header">
    <div class="page-header__left">
    </div>
    <div class="page-header__actions">
        <a href="{{ route('admin.pengguna.index') }}" class="btn btn--secondary">
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
        <h3 class="card__title">Form Edit Pengguna</h3>
    </div>
    <div class="card__body">
        <form action="{{ route('admin.pengguna.update', $pengguna['id']) }}" method="POST" class="form">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label for="nama" class="form-label required">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" class="form-input" value="{{ old('nama', $pengguna['nama']) }}" required>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label required">Email</label>
                    <input type="email" id="email" name="email" class="form-input" value="{{ old('email', $pengguna['email']) }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="role" class="form-label required">Role</label>
                    <select id="role" name="role" class="form-select" required onchange="handleRoleChange(this.value)">
                        <option value="">Pilih Role</option>
                        <option value="admin"    {{ old('role', $pengguna['role']) == 'admin'    ? 'selected' : '' }}>Admin</option>
                        <option value="guru"     {{ old('role', $pengguna['role']) == 'guru'     ? 'selected' : '' }}>Guru</option>
                        <option value="orangtua" {{ old('role', $pengguna['role']) == 'orangtua' ? 'selected' : '' }}>Orang Tua</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status" class="form-label required">Status Akun</label>
                    <select id="status" name="status" class="form-select status-select" required>
                        <option value="pending"  {{ old('status', $pengguna['status']) == 'pending'  ? 'selected' : '' }}>Pending</option>
                        <option value="active"   {{ old('status', $pengguna['status']) == 'active'   ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status', $pengguna['status']) == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    <small class="form-hint">Status "Pending" untuk akun dari pendaftaran online yang belum diaktivasi</small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                    <input type="tel" id="nomor_telepon" name="nomor_telepon" class="form-input" value="{{ old('nomor_telepon', $pengguna['nomor_telepon'] ?? '') }}" placeholder="08xxxxxxxxxx">
                </div>
                <div class="form-group"></div>
            </div>

            {{-- Hubungkan ke Siswa — muncul hanya jika role = orangtua --}}
            <div class="form-row" id="siswa-section" style="display:none;">
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label class="form-label">Hubungkan ke Siswa</label>

                    <input type="hidden" id="siswa_id" name="siswa_id" value="{{ old('siswa_id', $siswaTerhubung?->id ?? '') }}">

                    @php
                        $currentSiswa = $siswaTerhubung ?? null;
                        $currentLabel = $currentSiswa
                            ? '[TK '.$currentSiswa->kelas.'] '.$currentSiswa->name.($currentSiswa->nomor_induk ? ' (No. Induk: '.$currentSiswa->nomor_induk.')' : '')
                            : '';
                        // Jika ada old() dari validasi gagal, cari label-nya dari siswaList
                        $oldSiswaId = old('siswa_id');
                        if ($oldSiswaId) {
                            $oldSiswa = $siswaList->firstWhere('id', $oldSiswaId);
                            if ($oldSiswa) {
                                $currentLabel = '[TK '.$oldSiswa->kelas.'] '.$oldSiswa->name.($oldSiswa->nomor_induk ? ' (No. Induk: '.$oldSiswa->nomor_induk.')' : '');
                            }
                        }
                    @endphp
                    <div class="combobox" id="siswa-combobox">
                        <div class="combobox__input-wrap">
                            <input type="text" id="siswa-search" class="form-input combobox__input"
                                placeholder="Ketik nama siswa untuk mencari..."
                                value="{{ $currentLabel }}"
                                autocomplete="off">
                            <button type="button" class="combobox__clear" id="siswa-clear" style="{{ $currentLabel ? 'display:inline' : 'display:none' }}" title="Hapus pilihan">✕</button>
                        </div>

                        <div class="combobox__dropdown" id="siswa-dropdown" style="display:none;">
                            <div class="combobox__list" id="siswa-list">
                                @foreach($siswaList as $s)
                                    <div class="combobox__item"
                                        data-value="{{ $s->id }}"
                                        data-label="[TK {{ $s->kelas }}] {{ $s->name }}{{ $s->nomor_induk ? ' (No. Induk: '.$s->nomor_induk.')' : '' }}"
                                        data-search="{{ strtolower($s->name) }} {{ strtolower($s->kelas) }} {{ $s->nomor_induk }}"
                                        data-nama="{{ $s->nama_ibu ?? $s->nama_ayah ?? '' }}">
                                        <span class="combobox__item-kelas">TK {{ $s->kelas }}</span>
                                        <span class="combobox__item-nama">{{ $s->name }}</span>
                                        @if($s->nomor_induk)
                                            <span class="combobox__item-nis">No. {{ $s->nomor_induk }}</span>
                                        @endif
                                        @if($s->user_id)
                                            <span class="combobox__item-badge">Terhubung</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <div class="combobox__empty" id="siswa-empty" style="display:none;">Tidak ada siswa ditemukan.</div>
                        </div>
                    </div>

                    <small class="form-hint">Menampilkan siswa yang belum memiliki akun orang tua, termasuk siswa yang sudah terhubung dengan akun ini.</small>
                </div>
            </div>

            <div class="form-divider">
                <span>Ubah Password (opsional)</span>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password" class="form-label">Password Baru</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Kosongkan jika tidak ingin mengubah">
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="Ulangi password baru">
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.pengguna.index') }}" class="btn btn--secondary">Batal</a>
                <button type="submit" class="btn btn--primary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/></svg>
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.form { max-width: 800px; }

.form-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

@media (max-width: 640px) {
    .form-row { grid-template-columns: 1fr; }
}

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
    color: #d81b72;
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

.form-input::placeholder { color: #5D4037; }

.form-divider {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin: 1.5rem 0;
}

.form-divider::before,
.form-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #3E272320;
}

.form-divider span {
    color: #5D4037;
    font-size: 0.875rem;
    font-weight: 500;
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #3E272320;
}

.form-hint {
    color: #5D4037;
    font-size: 0.75rem;
    margin-top: 0.25rem;
}

.alert--danger {
    background: #F0629220;
    color: #d81b72;
    border: 1px solid #F0629230;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.alert--danger ul { margin: 0; padding-left: 1.25rem; }
.mb-0 { margin-bottom: 0; }

.status-select option[value="pending"]  { background: #FFF176; color: #3E2723; }
.status-select option[value="active"]   { background: rgba(76,175,130,0.15); color: #2E8B60; }
.status-select option[value="inactive"] { background: #f1f5f9; color: #5D4037; }

/* Combobox */
.combobox { position: relative; }

.combobox__input-wrap {
    position: relative;
    display: flex;
    align-items: center;
}
.combobox__input { width: 100%; padding-right: 2.5rem !important; }
.combobox__clear {
    position: absolute;
    right: 0.75rem;
    background: none;
    border: none;
    cursor: pointer;
    color: #5D4037;
    font-size: 0.85rem;
    line-height: 1;
    padding: 0.25rem;
}
.combobox__clear:hover { color: #d81b72; }

.combobox__dropdown {
    position: absolute;
    top: calc(100% + 4px);
    left: 0; right: 0;
    background: white;
    border: 1px solid #3E272330;
    border-radius: 8px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    z-index: 100;
    max-height: 260px;
    overflow-y: auto;
}

.combobox__list { padding: 0.25rem; }

.combobox__item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 0.75rem;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.875rem;
    transition: background 0.15s;
}
.combobox__item:hover,
.combobox__item.active { background: #3E272315; }

.combobox__item-kelas {
    background: #3E272320;
    color: #3E2723;
    font-size: 0.7rem;
    font-weight: 600;
    padding: 0.15rem 0.4rem;
    border-radius: 4px;
    white-space: nowrap;
}
.combobox__item-nama  { flex: 1; font-weight: 500; color: #3E2723; }
.combobox__item-nis   { font-size: 0.75rem; color: #795548; white-space: nowrap; }
.combobox__item-badge {
    font-size: 0.7rem;
    font-weight: 600;
    padding: 0.15rem 0.5rem;
    border-radius: 4px;
    background: rgba(76,175,130,0.15);
    color: #2E8B60;
    white-space: nowrap;
}

.combobox__empty {
    padding: 0.75rem 1rem;
    color: #795548;
    font-size: 0.875rem;
    text-align: center;
}
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('siswa-search');
    const dropdown    = document.getElementById('siswa-dropdown');
    const list        = document.getElementById('siswa-list');
    const emptyMsg    = document.getElementById('siswa-empty');
    const clearBtn    = document.getElementById('siswa-clear');
    const hiddenInput = document.getElementById('siswa_id');
    const items       = list ? list.querySelectorAll('.combobox__item') : [];

    function openDropdown()  { dropdown.style.display = 'block'; }
    function closeDropdown() { dropdown.style.display = 'none'; }

    function filterItems(q) {
        q = q.toLowerCase().trim();
        let count = 0;
        items.forEach(item => {
            const match = !q || item.dataset.search.includes(q);
            item.style.display = match ? 'flex' : 'none';
            if (match) count++;
        });
        emptyMsg.style.display = count === 0 ? 'block' : 'none';
    }

    function selectItem(item) {
        hiddenInput.value        = item.dataset.value;
        searchInput.value        = item.dataset.label;
        clearBtn.style.display   = 'inline';
        items.forEach(i => i.classList.remove('active'));
        item.classList.add('active');
        closeDropdown();
        filterItems('');
    }

    items.forEach(item => {
        item.addEventListener('mousedown', function (e) {
            e.preventDefault();
            selectItem(this);
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            hiddenInput.value      = '';
            clearBtn.style.display = 'none';
            filterItems(this.value);
            openDropdown();
        });

        searchInput.addEventListener('focus', function () {
            filterItems(this.value);
            openDropdown();
        });

        searchInput.addEventListener('blur', function () {
            setTimeout(closeDropdown, 150);
        });
    }

    if (clearBtn) {
        clearBtn.addEventListener('click', function () {
            hiddenInput.value      = '';
            searchInput.value      = '';
            this.style.display     = 'none';
            items.forEach(i => i.classList.remove('active'));
            filterItems('');
        });
    }

    // Highlight item yang sudah terpilih (nilai sudah di-set dari PHP)
    const preVal = hiddenInput ? hiddenInput.value : '';
    if (preVal) {
        const match = [...items].find(i => i.dataset.value === preVal);
        if (match) match.classList.add('active');
    }

    // Toggle section saat role berubah
    window.handleRoleChange = function (role) {
        const section = document.getElementById('siswa-section');
        if (!section) return;
        if (role === 'orangtua') {
            section.style.display = 'grid';
        } else {
            section.style.display  = 'none';
            if (hiddenInput) hiddenInput.value = '';
            if (searchInput) searchInput.value = '';
            if (clearBtn)    clearBtn.style.display = 'none';
            items.forEach(i => i.classList.remove('active'));
            filterItems('');
        }
    };

    // Jalankan saat halaman load
    const roleEl = document.getElementById('role');
    if (roleEl && roleEl.value) handleRoleChange(roleEl.value);
});
</script>
@endpush
