@extends('layouts.app')

@section('title', 'Rekap Data DAPODIK')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="page-header">
    <div class="page-header__left">
        <h1 class="page-header__title">Rekap Data DAPODIK</h1>
        <p class="page-header__subtitle">Data Pokok Pendidikan - Export data siswa untuk sistem DAPODIK</p>
    </div>
    <div class="page-header__actions">
        <div class="dropdown">
            <button type="button" class="btn btn--secondary dropdown-toggle" onclick="toggleDropdown('exportDropdown')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path fill-rule="evenodd" d="M12 2.25a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V3a.75.75 0 0 1 .75-.75Zm-9 13.5a.75.75 0 0 1 .75.75v2.25a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5V16.5a.75.75 0 0 1 1.5 0v2.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V16.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
                Export Data
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="16" height="16"><path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" /></svg>
            </button>
            <div id="exportDropdown" class="dropdown-menu">
                <button type="button" class="dropdown-item" onclick="exportToPDF()">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" clip-rule="evenodd"/><path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z"/></svg>
                    <span>Export PDF</span>
                    <small>Dokumen siap cetak</small>
                </button>
                <button type="button" class="dropdown-item" onclick="exportToExcel()">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path fill-rule="evenodd" d="M1.5 5.625c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 18.375V5.625ZM21 9.375A.375.375 0 0 0 20.625 9h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5Zm-16.5 0A.375.375 0 0 0 4.125 9h7.5c.207 0 .375.168.375.375v1.5a.375.375 0 0 1-.375.375h-7.5a.375.375 0 0 1-.375-.375v-1.5Z" clip-rule="evenodd"/></svg>
                    <span>Export Excel (.xlsx)</span>
                    <small>Spreadsheet untuk edit</small>
                </button>
                <button type="button" class="dropdown-item" onclick="exportToCSV()">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875Z" clip-rule="evenodd"/><path d="M14.25 5.25a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963A5.23 5.23 0 0 0 16.5 7.5h-1.875a.375.375 0 0 1-.375-.375V5.25Z"/></svg>
                    <span>Export CSV</span>
                    <small>Untuk import DAPODIK</small>
                </button>
                <div class="dropdown-divider"></div>
                <button type="button" class="dropdown-item" onclick="previewPDF()">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18"><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd"/></svg>
                    <span>Preview & Cetak</span>
                    <small>Lihat sebelum cetak</small>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Info Box -->
<div class="info-box">
    <div class="info-box__icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd"/></svg>
    </div>
    <div class="info-box__content">
        <h4>Tentang DAPODIK</h4>
        <p>Data Pokok Pendidikan (DAPODIK) adalah sistem pendataan siswa yang dikelola oleh Kementerian Pendidikan dan Kebudayaan. Data ini digunakan untuk berbagai keperluan administrasi pendidikan termasuk BOS, PIP, dan bantuan lainnya.</p>
    </div>
</div>

<!-- Filter Section -->
<div class="card mb-4">
    <div class="card__body">
        <div class="filter-row">
            <div class="filter-group">
                <label for="search">Cari Siswa</label>
                <input type="text" id="search" placeholder="Nama atau NISN..." class="form-input" onkeyup="filterTable()">
            </div>
            <div class="filter-group">
                <label for="kelas">Kelas</label>
                <select id="kelas" class="form-select" onchange="filterTable()">
                    <option value="">Semua Kelas</option>
                    <option value="TK A">TK A</option>
                    <option value="TK B">TK B</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="jk">Jenis Kelamin</label>
                <select id="jk" class="form-select" onchange="filterTable()">
                    <option value="">Semua</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="status">Status</label>
                <select id="status" class="form-select" onchange="filterTable()">
                    <option value="">Semua Status</option>
                    <option value="Aktif" selected>Aktif</option>
                    <option value="Lulus">Lulus</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Stats Summary -->
<div class="stats-summary">
    <div class="stats-summary__item">
        <span class="stats-summary__value">{{ $totalSiswa }}</span>
        <span class="stats-summary__label">Total Siswa</span>
    </div>
    <div class="stats-summary__divider"></div>
    <div class="stats-summary__item">
        <span class="stats-summary__value">{{ $totalLaki }}</span>
        <span class="stats-summary__label">Laki-laki</span>
    </div>
    <div class="stats-summary__divider"></div>
    <div class="stats-summary__item">
        <span class="stats-summary__value">{{ $totalPerempuan }}</span>
        <span class="stats-summary__label">Perempuan</span>
    </div>
    <div class="stats-summary__divider"></div>
    <div class="stats-summary__item">
        <span class="stats-summary__value">{{ $totalTKA }}</span>
        <span class="stats-summary__label">TK A</span>
    </div>
    <div class="stats-summary__divider"></div>
    <div class="stats-summary__item">
        <span class="stats-summary__value">{{ $totalTKB }}</span>
        <span class="stats-summary__label">TK B</span>
    </div>
</div>

<!-- Data Table -->
<div class="card" id="printArea">
    <div class="card__header print-header">
        <div class="print-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo TK" onerror="this.style.display='none'">
            <div class="print-school-info">
                <h2>TK AL-ISTIQOMAH</h2>
                <p>Rekap Data Siswa untuk DAPODIK</p>
                <p class="print-date">Tanggal cetak: {{ date('d F Y') }}</p>
            </div>
        </div>
        <h3 class="card__title screen-only">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path fill-rule="evenodd" d="M1.5 5.625c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 18.375V5.625ZM21 9.375A.375.375 0 0 0 20.625 9h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5Zm0 3.75a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5Zm0 3.75a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5ZM10.875 18.75a.375.375 0 0 0 .375-.375v-1.5a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5ZM3.375 15h7.5a.375.375 0 0 0 .375-.375v-1.5a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375Zm0-3.75h7.5a.375.375 0 0 0 .375-.375v-1.5A.375.375 0 0 0 10.875 9h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375Z" clip-rule="evenodd"/></svg>
            Data Siswa untuk DAPODIK
        </h3>
    </div>
    <div class="card__body p-0">
        <div class="table-responsive">
            <table class="data-table" id="dataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th>NIK</th>
                        <th>Nama Lengkap</th>
                        <th>Jenis Kelamin</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Agama</th>
                        <th>Alamat</th>
                        <th>Nama Ayah</th>
                        <th>Nama Ibu</th>
                        <th>Kelas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $index => $s)
                    <tr data-kelas="{{ $s['kelas'] }}" data-jk="{{ $s['jenis_kelamin'] == 'Laki-laki' ? 'L' : 'P' }}" data-status="{{ $s['status'] }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $s['nisn'] ?? '-' }}</td>
                        <td>{{ $s['nik'] ?? '-' }}</td>
                        <td class="name-cell">{{ $s['nama'] }}</td>
                        <td>{{ $s['jenis_kelamin'] == 'Laki-laki' ? 'L' : 'P' }}</td>
                        <td>{{ $s['tempat_lahir'] ?? '-' }}</td>
                        <td>{{ $s['tanggal_lahir'] ?? '-' }}</td>
                        <td>{{ $s['agama'] ?? 'Islam' }}</td>
                        <td class="address-cell">{{ $s['alamat'] ?? '-' }}</td>
                        <td>{{ $s['nama_ayah'] ?? '-' }}</td>
                        <td>{{ $s['nama_ibu'] ?? '-' }}</td>
                        <td>{{ $s['kelas'] }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12" class="text-center py-4">Belum ada data siswa aktif</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Field Legend -->
<div class="card mt-4">
    <div class="card__header">
        <h3 class="card__title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm11.378-3.917c-.89-.777-2.366-.777-3.255 0a.75.75 0 0 1-.988-1.129c1.454-1.272 3.776-1.272 5.23 0 1.513 1.324 1.513 3.518 0 4.842a3.75 3.75 0 0 1-.837.552c-.676.396-1.028.802-1.028 1.152v.75a.75.75 0 0 1-1.5 0v-.75c0-1.279 1.06-2.107 1.875-2.502.182-.088.351-.199.503-.331.83-.727.83-1.857 0-2.584ZM12 18a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd"/></svg>
            Keterangan Field DAPODIK
        </h3>
    </div>
    <div class="card__body">
        <div class="legend-grid">
            <div class="legend-item">
                <strong>NISN</strong>
                <span>Nomor Induk Siswa Nasional (10 digit)</span>
            </div>
            <div class="legend-item">
                <strong>NIK</strong>
                <span>Nomor Induk Kependudukan (16 digit)</span>
            </div>
            <div class="legend-item">
                <strong>Nama Lengkap</strong>
                <span>Sesuai Akta Kelahiran</span>
            </div>
            <div class="legend-item">
                <strong>Jenis Kelamin</strong>
                <span>L = Laki-laki, P = Perempuan</span>
            </div>
            <div class="legend-item">
                <strong>Tempat, Tanggal Lahir</strong>
                <span>Sesuai Akta Kelahiran</span>
            </div>
            <div class="legend-item">
                <strong>Nama Orang Tua</strong>
                <span>Nama Ayah dan Ibu Kandung</span>
            </div>
        </div>
    </div>
</div>

<style>
/* Page Header */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.page-header__left { flex: 1; }

.page-header__actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1rem;
    border-radius: 8px;
    font-weight: 500;
    font-size: 0.875rem;
    cursor: pointer;
    border: none;
    transition: all 0.2s;
}

.btn--secondary {
    background: #f1f5f9;
    color: #5D4037;
}

.btn--secondary:hover {
    background: #e2e8f0;
}

.btn--primary {
    background: #4CAF82;
    color: white;
}

.btn--primary:hover {
    background: #3D9B72;
}

/* Dropdown */
.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-toggle {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    margin-top: 0.5rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
    border: 1px solid rgba(0,0,0,0.08);
    min-width: 220px;
    z-index: 100;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.2s ease;
}

.dropdown-menu.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    width: 100%;
    padding: 0.75rem 1rem;
    border: none;
    background: none;
    text-align: left;
    cursor: pointer;
    transition: background 0.15s;
}

.dropdown-item:first-child {
    border-radius: 12px 12px 0 0;
}

.dropdown-item:last-child {
    border-radius: 0 0 12px 12px;
}

.dropdown-item:hover {
    background: #f8fafc;
}

.dropdown-item svg {
    color: #4CAF82;
    flex-shrink: 0;
    margin-top: 2px;
}

.dropdown-item span {
    display: block;
    font-weight: 500;
    color: #3E2723;
    font-size: 0.875rem;
}

.dropdown-item small {
    display: block;
    font-size: 0.75rem;
    color: #5D4037;
    margin-top: 2px;
}

.dropdown-divider {
    height: 1px;
    background: #e2e8f0;
    margin: 0.25rem 0;
}

/* Info Box */
.info-box {
    display: flex;
    gap: 1rem;
    padding: 1rem 1.5rem;
    background: rgba(76, 175, 130, 0.1);
    border: 1px solid rgba(76, 175, 130, 0.3);
    border-radius: 12px;
    margin-bottom: 1.5rem;
}

.info-box__icon {
    width: 44px;
    height: 44px;
    background: rgba(76, 175, 130, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #4CAF82;
}

.info-box__icon svg {
    width: 24px;
    height: 24px;
}

.info-box__content h4 {
    font-size: 1rem;
    font-weight: 600;
    color: #3E2723;
    margin-bottom: 0.25rem;
}

.info-box__content p {
    font-size: 0.875rem;
    color: #5D4037;
    line-height: 1.5;
}

/* Filter */
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
    border-color: #4CAF82;
    box-shadow: 0 0 0 3px rgba(76, 175, 130, 0.1);
}

/* Stats Summary */
.stats-summary {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1.5rem;
    padding: 1rem;
    background: white;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    flex-wrap: wrap;
}

.stats-summary__item {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0 1rem;
}

.stats-summary__value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #4CAF82;
}

.stats-summary__label {
    font-size: 0.8rem;
    color: #5D4037;
}

.stats-summary__divider {
    width: 1px;
    height: 40px;
    background: #e2e8f0;
}

/* Card */
.card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.05);
}

.card__header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #3E272315;
}

.card__title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1rem;
    font-weight: 600;
    color: #3E2723;
}

.card__title svg {
    color: #4CAF82;
}

.card__body {
    padding: 1.5rem;
}

/* Table */
.table-responsive {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.8rem;
}

.data-table th,
.data-table td {
    padding: 0.75rem;
    text-align: left;
    border-bottom: 1px solid #3E272320;
    white-space: nowrap;
}

.data-table th {
    background: #FFFDE7;
    font-weight: 600;
    color: #3E2723;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    position: sticky;
    top: 0;
}

.data-table tbody tr:hover {
    background: #FFFDE7;
}

.name-cell {
    font-weight: 500;
    color: #3E2723;
    min-width: 180px;
    white-space: normal;
}

.address-cell {
    min-width: 200px;
    white-space: normal;
    font-size: 0.75rem;
}

/* Legend */
.legend-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1rem;
}

.legend-item {
    display: flex;
    flex-direction: column;
    padding: 0.75rem;
    background: #FFFDE7;
    border-radius: 8px;
}

.legend-item strong {
    font-size: 0.85rem;
    color: #3E2723;
    margin-bottom: 0.25rem;
}

.legend-item span {
    font-size: 0.8rem;
    color: #5D4037;
}

/* Utilities */
.mb-4 { margin-bottom: 1rem; }
.mt-4 { margin-top: 1rem; }
.p-0 { padding: 0 !important; }
.py-4 { padding-top: 1rem; padding-bottom: 1rem; }
.text-center { text-align: center; }

/* Print Styles */
.print-header {
    display: none;
}

.print-logo {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.print-logo img {
    width: 60px;
    height: 60px;
}

.print-school-info h2 {
    font-size: 1.25rem;
    margin: 0;
}

.print-school-info p {
    margin: 0;
    font-size: 0.9rem;
}

.print-date {
    font-size: 0.8rem;
    color: #666;
}

@media print {
    body {
        background: white !important;
        font-size: 10pt;
    }
    
    .layout { display: block !important; }
    .sidebar { display: none !important; }
    .main { margin-left: 0 !important; padding: 0 !important; }
    .page-header, .info-box, .filter-row, .stats-summary, .legend-grid { display: none !important; }
    .card { box-shadow: none !important; border: none !important; }
    
    .print-header {
        display: block !important;
        text-align: center;
        border-bottom: 2px solid #000;
        padding-bottom: 1rem;
        margin-bottom: 1rem;
    }
    
    .screen-only { display: none !important; }
    
    .print-logo {
        justify-content: center;
    }
    
    .data-table {
        font-size: 8pt;
    }
    
    .data-table th, .data-table td {
        padding: 0.35rem;
        border: 1px solid #000;
    }
    
    .data-table th {
        background: #f0f0f0 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
// Dropdown toggle
function toggleDropdown(id) {
    const dropdown = document.getElementById(id);
    dropdown.classList.toggle('show');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.dropdown')) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.classList.remove('show');
        });
    }
});

function filterTable() {
    const search = document.getElementById('search').value.toLowerCase();
    const kelas = document.getElementById('kelas').value;
    const jk = document.getElementById('jk').value;
    const status = document.getElementById('status').value;
    
    const rows = document.querySelectorAll('#dataTable tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        const rowKelas = row.dataset.kelas;
        const rowJk = row.dataset.jk;
        const rowStatus = row.dataset.status;
        
        const matchSearch = text.includes(search);
        const matchKelas = !kelas || rowKelas === kelas;
        const matchJk = !jk || rowJk === jk;
        const matchStatus = !status || rowStatus === status;
        
        row.style.display = (matchSearch && matchKelas && matchJk && matchStatus) ? '' : 'none';
    });
}

function getTableData() {
    const table = document.getElementById('dataTable');
    const rows = table.querySelectorAll('tbody tr');
    const headers = [];
    const data = [];
    
    // Get headers
    table.querySelectorAll('thead th').forEach(th => {
        headers.push(th.textContent.trim());
    });
    
    // Get visible rows
    rows.forEach(row => {
        if (row.style.display !== 'none') {
            const rowData = [];
            row.querySelectorAll('td').forEach(td => {
                rowData.push(td.textContent.trim());
            });
            if (rowData.length > 0) {
                data.push(rowData);
            }
        }
    });
    
    return { headers, data };
}

function exportToPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('l', 'mm', 'a4'); // Landscape for more columns
    
    const { headers, data } = getTableData();
    const today = new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
    
    // Header
    doc.setFontSize(16);
    doc.setFont('helvetica', 'bold');
    doc.text('TK AL-ISTIQOMAH', 148.5, 15, { align: 'center' });
    
    doc.setFontSize(12);
    doc.setFont('helvetica', 'normal');
    doc.text('REKAP DATA SISWA UNTUK DAPODIK', 148.5, 22, { align: 'center' });
    
    doc.setFontSize(10);
    doc.text('Tanggal: ' + today, 148.5, 28, { align: 'center' });
    
    // Line
    doc.setLineWidth(0.5);
    doc.line(14, 32, 283, 32);
    
    // Table
    doc.autoTable({
        head: [headers],
        body: data,
        startY: 38,
        theme: 'grid',
        styles: {
            fontSize: 8,
            cellPadding: 2,
            overflow: 'linebreak',
            halign: 'left'
        },
        headStyles: {
            fillColor: [76, 175, 130],
            textColor: 255,
            fontStyle: 'bold',
            halign: 'center'
        },
        columnStyles: {
            0: { halign: 'center', cellWidth: 10 },  // No
            1: { cellWidth: 25 },  // NISN
            2: { cellWidth: 35 },  // NIK
            3: { cellWidth: 35 },  // Nama
            4: { halign: 'center', cellWidth: 12 },  // JK
            5: { cellWidth: 25 },  // Tempat Lahir
            6: { cellWidth: 22 },  // Tanggal Lahir
            7: { cellWidth: 15 },  // Agama
            8: { cellWidth: 40 },  // Alamat
            9: { cellWidth: 25 },  // Nama Ayah
            10: { cellWidth: 25 }, // Nama Ibu
            11: { halign: 'center', cellWidth: 15 }  // Kelas
        },
        alternateRowStyles: {
            fillColor: [245, 245, 245]
        },
        margin: { left: 14, right: 14 }
    });
    
    // Footer
    const pageCount = doc.internal.getNumberOfPages();
    for (let i = 1; i <= pageCount; i++) {
        doc.setPage(i);
        doc.setFontSize(8);
        doc.setTextColor(128);
        doc.text('Halaman ' + i + ' dari ' + pageCount, 148.5, 200, { align: 'center' });
        doc.text('Dicetak dari Sistem Informasi TK Al-Istiqomah', 14, 200);
    }
    
    // Download
    doc.save('rekap_dapodik_' + new Date().toISOString().slice(0,10) + '.pdf');
    
    // Close dropdown
    document.getElementById('exportDropdown').classList.remove('show');
}

function previewPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('l', 'mm', 'a4');
    
    const { headers, data } = getTableData();
    const today = new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
    
    // Header
    doc.setFontSize(16);
    doc.setFont('helvetica', 'bold');
    doc.text('TK AL-ISTIQOMAH', 148.5, 15, { align: 'center' });
    
    doc.setFontSize(12);
    doc.setFont('helvetica', 'normal');
    doc.text('REKAP DATA SISWA UNTUK DAPODIK', 148.5, 22, { align: 'center' });
    
    doc.setFontSize(10);
    doc.text('Tanggal: ' + today, 148.5, 28, { align: 'center' });
    
    doc.setLineWidth(0.5);
    doc.line(14, 32, 283, 32);
    
    doc.autoTable({
        head: [headers],
        body: data,
        startY: 38,
        theme: 'grid',
        styles: {
            fontSize: 8,
            cellPadding: 2,
            overflow: 'linebreak',
            halign: 'left'
        },
        headStyles: {
            fillColor: [76, 175, 130],
            textColor: 255,
            fontStyle: 'bold',
            halign: 'center'
        },
        columnStyles: {
            0: { halign: 'center', cellWidth: 10 },
            1: { cellWidth: 25 },
            2: { cellWidth: 35 },
            3: { cellWidth: 35 },
            4: { halign: 'center', cellWidth: 12 },
            5: { cellWidth: 25 },
            6: { cellWidth: 22 },
            7: { cellWidth: 15 },
            8: { cellWidth: 40 },
            9: { cellWidth: 25 },
            10: { cellWidth: 25 },
            11: { halign: 'center', cellWidth: 15 }
        },
        alternateRowStyles: {
            fillColor: [245, 245, 245]
        },
        margin: { left: 14, right: 14 }
    });
    
    const pageCount = doc.internal.getNumberOfPages();
    for (let i = 1; i <= pageCount; i++) {
        doc.setPage(i);
        doc.setFontSize(8);
        doc.setTextColor(128);
        doc.text('Halaman ' + i + ' dari ' + pageCount, 148.5, 200, { align: 'center' });
        doc.text('Dicetak dari Sistem Informasi TK Al-Istiqomah', 14, 200);
    }
    
    // Open in new window for preview
    const pdfBlob = doc.output('blob');
    const pdfUrl = URL.createObjectURL(pdfBlob);
    window.open(pdfUrl, '_blank');
    
    document.getElementById('exportDropdown').classList.remove('show');
}

function exportToExcel() {
    const { headers, data } = getTableData();
    
    // Create workbook
    const wb = XLSX.utils.book_new();
    
    // Add title rows
    const titleData = [
        ['TK AL-ISTIQOMAH'],
        ['REKAP DATA SISWA UNTUK DAPODIK'],
        ['Tanggal: ' + new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })],
        [], // Empty row
        headers		
    ];
    
    // Add data rows
    data.forEach(row => titleData.push(row));
    
    // Create worksheet
    const ws = XLSX.utils.aoa_to_sheet(titleData);
    
    // Set column widths
    ws['!cols'] = [
        { wch: 5 },   // No
        { wch: 15 },  // NISN
        { wch: 20 },  // NIK
        { wch: 25 },  // Nama
        { wch: 8 },   // JK
        { wch: 18 },  // Tempat Lahir
        { wch: 15 },  // Tanggal Lahir
        { wch: 10 },  // Agama
        { wch: 35 },  // Alamat
        { wch: 20 },  // Nama Ayah
        { wch: 20 },  // Nama Ibu
        { wch: 10 }   // Kelas
    ];
    
    // Add to workbook
    XLSX.utils.book_append_sheet(wb, ws, 'Data DAPODIK');
    
    // Download
    XLSX.writeFile(wb, 'rekap_dapodik_' + new Date().toISOString().slice(0,10) + '.xlsx');
    
    document.getElementById('exportDropdown').classList.remove('show');
}

function exportToCSV() {
    const table = document.getElementById('dataTable');
    const rows = table.querySelectorAll('tr');
    
    let csv = [];
    
    rows.forEach(row => {
        if (row.style.display !== 'none' && !row.closest('tbody')?.querySelector('tr[style*="display: none"]')?.contains(row)) {
            const cols = row.querySelectorAll('td, th');
            const rowData = [];
            cols.forEach(col => {
                // Escape quotes and wrap in quotes
                let text = col.textContent.trim().replace(/"/g, '""');
                rowData.push('"' + text + '"');
            });
            if (rowData.length > 0) {
                csv.push(rowData.join(','));
            }
        }
    });
    
    // Get only visible rows
    const finalCSV = [];
    const headerRow = csv[0]; // Header
    finalCSV.push(headerRow);
    
    document.querySelectorAll('#dataTable tbody tr').forEach((row, index) => {
        if (row.style.display !== 'none') {
            finalCSV.push(csv[index + 1]);
        }
    });
    
    // Download with BOM for Excel UTF-8
    const csvContent = '\uFEFF' + finalCSV.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'rekap_dapodik_' + new Date().toISOString().slice(0,10) + '.csv';
    link.click();
    
    document.getElementById('exportDropdown').classList.remove('show');
}
</script>
@endsection
