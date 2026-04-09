@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="page-header">
    <div class="page-header__left">
        <h1 class="page-header__title">Tambah Pengguna</h1>
        <p class="page-header__subtitle">Tambah pengguna baru ke sistem</p>
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
        <h3 class="card__title">Form Data Pengguna</h3>
    </div>
    <div class="card__body">
        <form action="{{ route('admin.pengguna.store') }}" method="POST" class="form">
            @csrf
            
            <div class="form-row">
                <div class="form-group">
                    <label for="nama" class="form-label required">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" class="form-input" value="{{ old('nama') }}" required placeholder="Masukkan nama lengkap">
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label required">Email</label>
                    <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" required placeholder="contoh@email.com">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="role" class="form-label required">Role</label>
                    <select id="role" name="role" class="form-select" required onchange="handleRoleChange(this.value)">
                        <option value="">Pilih Role</option>
                        <option value="admin"     {{ old('role') == 'admin'     ? 'selected' : '' }}>Admin</option>
                        <option value="guru"      {{ old('role') == 'guru'      ? 'selected' : '' }}>Guru</option>
                        <option value="orangtua"  {{ old('role') == 'orangtua'  ? 'selected' : '' }}>Orang Tua</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                    <input type="tel" id="nomor_telepon" name="nomor_telepon" class="form-input" value="{{ old('nomor_telepon') }}" placeholder="08xxxxxxxxxx">
                </div>
            </div>

            {{-- Pilih siswa — muncul hanya jika role = orangtua --}}
            <div class="form-row" id="siswa-section" style="display:none;">
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label class="form-label required">Hubungkan ke Siswa</label>

                    {{-- Hidden input yang dikirim ke server --}}
                    <input type="hidden" id="siswa_id" name="siswa_id" value="{{ old('siswa_id') }}">

                    {{-- Combobox wrapper --}}
                    <div class="combobox" id="siswa-combobox">
                        <div class="combobox__input-wrap">
                            <input type="text" id="siswa-search" class="form-input combobox__input"
                                placeholder="Ketik nama siswa untuk mencari..."
                                autocomplete="off">
                            <button type="button" class="combobox__clear" id="siswa-clear" style="display:none" title="Hapus pilihan">✕</button>
                        </div>

                        <div class="combobox__dropdown" id="siswa-dropdown" style="display:none;">
                            <div class="combobox__list" id="siswa-list">
                                @foreach($siswaOrphan as $s)
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
                                    </div>
                                @endforeach
                            </div>
                            <div class="combobox__empty" id="siswa-empty" style="display:none;">Tidak ada siswa ditemukan.</div>
                        </div>
                    </div>

                    <small class="form-hint">Hanya menampilkan siswa yang belum memiliki akun orang tua.</small>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="password" class="form-label required">Password</label>
                    <input type="password" id="password" name="password" class="form-input" required placeholder="Minimal 6 karakter">
                </div>
                
                <div class="form-group">
                    <label for="password_confirmation" class="form-label required">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required placeholder="Ulangi password">
                </div>
            </div>
            
            <div class="form-actions">
                <button type="reset" class="btn btn--secondary">Reset</button>
                <button type="submit" class="btn btn--primary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/></svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<style>
/* Form Styles */
.form {
    max-width: 800px;
}

.form-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

@media (max-width: 640px) {
    .form-row {
        grid-template-columns: 1fr;
    }
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
    color: #c0392b;
}

.form-input,
.form-select,
.form-textarea {
    padding: 0.75rem 1rem;
    border: 1px solid #3E272330;
    border-radius: 8px;
    font-size: 0.875rem;
    transition: all 0.2s;
    background: white;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    outline: none;
    border-color: #3E2723;
    box-shadow: 0 0 0 3px rgba(0, 71, 62, 0.1);
}

.form-input::placeholder {
    color: #5D4037;
}

.form-hint {
    color: #5D4037;
    font-size: 0.75rem;
    margin-top: 0.25rem;
}

.form-hint a {
    color: #3E2723;
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

/* Alert */
.alert--danger {
    background: #fee2e2;
    color: #c0392b;
    border: 1px solid #fecaca;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.alert--danger ul {
    margin: 0;
    padding-left: 1.25rem;
}

.mb-0 { margin-bottom: 0; }

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
.combobox__clear:hover { color: #c0392b; }

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
.combobox__item-nama { flex: 1; font-weight: 500; color: #3E2723; }
.combobox__item-nis  { font-size: 0.75rem; color: #795548; white-space: nowrap; }

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

    // ── Elemen ──────────────────────────────────────────────
    const searchInput = document.getElementById('siswa-search');
    const dropdown    = document.getElementById('siswa-dropdown');
    const list        = document.getElementById('siswa-list');
    const emptyMsg    = document.getElementById('siswa-empty');
    const clearBtn    = document.getElementById('siswa-clear');
    const hiddenInput = document.getElementById('siswa_id');
    const namaInput   = document.getElementById('nama');
    const items       = list.querySelectorAll('.combobox__item');

    // ── Tampilkan dropdown ───────────────────────────────────
    function openDropdown() { dropdown.style.display = 'block'; }
    function closeDropdown() { dropdown.style.display = 'none'; }

    // ── Filter item ──────────────────────────────────────────
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

    // ── Pilih item ───────────────────────────────────────────
    function selectItem(item) {
        const value = item.dataset.value;
        const label = item.dataset.label;
        const nama  = item.dataset.nama;

        hiddenInput.value  = value;
        searchInput.value  = label;
        clearBtn.style.display = 'inline';

        // Auto-isi Nama Lengkap jika masih kosong
        if (nama && !namaInput.value) {
            namaInput.value = nama;
        }

        // Highlight item terpilih
        items.forEach(i => i.classList.remove('active'));
        item.classList.add('active');

        closeDropdown();
        filterItems(''); // reset filter
    }

    // ── Klik item ────────────────────────────────────────────
    items.forEach(item => {
        item.addEventListener('mousedown', function (e) {
            e.preventDefault(); // cegah blur dulu
            selectItem(this);
        });
    });

    // ── Input search ─────────────────────────────────────────
    searchInput.addEventListener('input', function () {
        hiddenInput.value = ''; // reset pilihan saat mengetik ulang
        clearBtn.style.display = 'none';
        filterItems(this.value);
        openDropdown();
    });

    searchInput.addEventListener('focus', function () {
        filterItems(this.value);
        openDropdown();
    });

    searchInput.addEventListener('blur', function () {
        // Tutup dropdown setelah klik item selesai
        setTimeout(closeDropdown, 150);
    });

    // ── Tombol clear ─────────────────────────────────────────
    clearBtn.addEventListener('click', function () {
        hiddenInput.value      = '';
        searchInput.value      = '';
        this.style.display     = 'none';
        items.forEach(i => i.classList.remove('active'));
        filterItems('');
    });

    // ── Restore state jika ada old input (validasi gagal) ────
    const oldVal = hiddenInput.value;
    if (oldVal) {
        const match = [...items].find(i => i.dataset.value === oldVal);
        if (match) selectItem(match);
    }

    // ── Toggle section saat role berubah ────────────────────
    window.handleRoleChange = function (role) {
        const section = document.getElementById('siswa-section');
        if (role === 'orangtua') {
            section.style.display = 'grid';
        } else {
            section.style.display  = 'none';
            hiddenInput.value      = '';
            searchInput.value      = '';
            clearBtn.style.display = 'none';
            items.forEach(i => i.classList.remove('active'));
            filterItems('');
        }
    };

    // Jalankan jika role sudah terpilih (old input)
    const roleEl = document.getElementById('role');
    if (roleEl.value) handleRoleChange(roleEl.value);
});
</script>
@endpush
