@extends('layouts.app')

@section('title', 'Laporan Administrasi - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Laporan Administrasi')

@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

@push('styles')
<style>
    /* Orange Theme Colors */
    .form-section {
        background: #fff;
        border: 1px solid #3E272320;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .form-section__title {
        font-size: 16px;
        font-weight: 600;
        color: #3E2723;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 2px solid #3D9B72;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .form-section__title svg {
        width: 20px;
        height: 20px;
        fill: #3D9B72;
    }
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
    }
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .form-group label {
        font-size: 13px;
        font-weight: 500;
        color: #3E2723;
    }
    .form-group input,
    .form-group select,
    .form-group textarea {
        padding: 10px 12px;
        border: 1px solid #3E272320;
        border-radius: 6px;
        font-size: 14px;
        color: #3E2723;
        background: #FFFDE7;
        transition: all 0.2s;
        font-family: inherit;
    }
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #3D9B72;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(76, 175, 130, 0.1);
    }
    .btn-orange {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #3D9B72 0%, #2E8B60 100%);
        color: white;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        border-radius: 8px;
        box-shadow: 0 4px 14px rgba(76, 175, 130, 0.3);
        transition: all 0.3s;
    }
    .btn-orange:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(76, 175, 130, 0.4);
    }
    .btn-orange svg {
        width: 16px;
        height: 16px;
        fill: currentColor;
    }
    .btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #3E272320;
        color: #3E2723;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        border-radius: 8px;
        transition: all 0.2s;
    }
    .btn-secondary:hover {
        background: #3E272330;
    }
    .btn-green {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #3D9B72 0%, #16a34a 100%);
        color: white;
        padding: 8px 14px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-green:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
    }
    .btn-green svg {
        width: 14px;
        height: 14px;
        fill: currentColor;
    }
    .btn-blue {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
        color: white;
        padding: 8px 14px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-blue:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(76, 175, 130, 0.35);
    }
    .btn-blue svg {
        width: 14px;
        height: 14px;
        fill: currentColor;
    }
    .btn-row {
        display: flex;
        gap: 12px;
        margin-top: 16px;
    }
    
    /* Table */
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    .data-table th,
    .data-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #3E272320;
    }
    .data-table th {
        background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
        font-size: 12px;
        font-weight: 600;
        color: #ffffff;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .data-table td {
        font-size: 14px;
        color: #3E2723;
    }
    .data-table tr:hover td {
        background: #FFFDE7;
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .status-badge--generated {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #047857;
    }
    .status-badge--pending {
        background: #FFF176;
        color: #5D4037;
    }
    .status-badge--draft {
        background: linear-gradient(135deg, #3E272320 0%, #3E272330 100%);
        color: #5D4037;
    }
    
    /* Filter Row */
    .filter-row {
        display: flex;
        gap: 12px;
        margin-bottom: 16px;
        flex-wrap: wrap;
        align-items: flex-end;
    }
    .filter-row .form-group {
        min-width: 150px;
    }
    
    /* Alert */
    .alert-success {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border: 1px solid #34d399;
        color: #047857;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
    }
    
    /* Report Type Selector */
    .report-type-tabs {
        display: flex;
        gap: 8px;
        margin-bottom: 20px;
    }
    .report-type-tab {
        padding: 10px 20px;
        border: 2px solid #3E272320;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        background: white;
        color: #5D4037;
    }
    .report-type-tab:hover {
        border-color: #3D9B72;
        color: #3D9B72;
    }
    .report-type-tab.active {
        border-color: #3D9B72;
        background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
        color: #c2410c;
    }
    .report-type-tab input {
        display: none;
    }
    
    /* Action buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
    }
    
    @media (max-width: 768px) {
        .filter-row {
            flex-direction: column;
        }
        .filter-row .form-group {
            width: 100%;
        }
        .report-type-tabs {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
    @if (session('success'))
        <div class="alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:20px;height:20px;">
                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Generate Laporan -->
    <div class="form-section">
        <div class="form-section__title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd"/>
                <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z"/>
            </svg>
            Form Generate Laporan
        </div>
        
        <form action="{{ route('guru.laporan.generate') }}" method="POST">
            @csrf
            
            <div class="report-type-tabs">
                <label class="report-type-tab active">
                    <input type="radio" name="jenis_laporan" value="kehadiran" checked>
                    Laporan Kehadiran
                </label>
                <label class="report-type-tab">
                    <input type="radio" name="jenis_laporan" value="perkembangan">
                    Laporan Perkembangan
                </label>
                <label class="report-type-tab">
                    <input type="radio" name="jenis_laporan" value="bulanan">
                    Laporan Bulanan
                </label>
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label>Periode Awal</label>
                    <input type="date" name="periode_awal" value="{{ date('Y-m-01') }}" required>
                </div>
                <div class="form-group">
                    <label>Periode Akhir</label>
                    <input type="date" name="periode_akhir" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label>Kelas</label>
                    <select name="kelas">
                        <option value="">Semua Kelas</option>
                        <option value="TK A">TK A</option>
                        <option value="TK B">TK B</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Siswa</label>
                    <select name="siswa_id">
                        <option value="">Semua Siswa</option>
                        @forelse ($siswaList ?? [
                            ['id' => 1, 'nama' => 'Ahmad Fauzi'],
                            ['id' => 2, 'nama' => 'Siti Nurhaliza'],
                            ['id' => 3, 'nama' => 'Budi Santoso'],
                            ['id' => 4, 'nama' => 'Dewi Lestari'],
                            ['id' => 5, 'nama' => 'Eko Prasetyo'],
                        ] as $siswa)
                            <option value="{{ $siswa['id'] }}">{{ $siswa['nama'] }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>
            
            <div class="form-group" style="margin-top: 16px;">
                <label>Catatan Tambahan (Opsional)</label>
                <textarea name="catatan" rows="3" placeholder="Tambahkan catatan untuk laporan..."></textarea>
            </div>
            
            <div class="btn-row">
                <button type="submit" class="btn-orange">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M9.315 7.584C12.195 3.883 16.695 1.5 21.75 1.5a.75.75 0 0 1 .75.75c0 5.056-2.383 9.555-6.084 12.436A6.75 6.75 0 0 1 9.75 22.5a.75.75 0 0 1-.75-.75v-4.131A15.838 15.838 0 0 1 6.382 15H2.25a.75.75 0 0 1-.75-.75 6.75 6.75 0 0 1 7.815-6.666ZM15 6.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" clip-rule="evenodd"/>
                        <path d="M5.26 17.242a.75.75 0 1 0-.897-1.203 5.243 5.243 0 0 0-2.05 5.022.75.75 0 0 0 .625.627 5.243 5.243 0 0 0 5.022-2.051.75.75 0 1 0-1.202-.897 3.744 3.744 0 0 1-3.008 1.51c0-1.23.592-2.323 1.51-3.008Z"/>
                    </svg>
                    Generate Laporan
                </button>
            </div>
        </form>
    </div>

    <!-- List Laporan -->
    <div class="form-section">
        <div class="form-section__title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M11.625 16.5a1.875 1.875 0 1 0 0-3.75 1.875 1.875 0 0 0 0 3.75Z"/>
                <path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875Zm6 16.5a3.375 3.375 0 1 0 0-6.75 3.375 3.375 0 0 0 0 6.75Z" clip-rule="evenodd"/>
            </svg>
            List Laporan
        </div>
        
        <form action="" method="GET" class="filter-row">
            <div class="form-group">
                <label>Jenis Laporan</label>
                <select name="jenis">
                    <option value="">Semua Jenis</option>
                    <option value="kehadiran">Kehadiran</option>
                    <option value="perkembangan">Perkembangan</option>
                    <option value="bulanan">Bulanan</option>
                </select>
            </div>
            <div class="form-group">
                <label>Bulan</label>
                <select name="bulan">
                    <option value="">Semua Bulan</option>
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3" selected>Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="">Semua Status</option>
                    <option value="generated">Selesai</option>
                    <option value="pending">Pending</option>
                    <option value="draft">Draft</option>
                </select>
            </div>
            <button type="submit" class="btn-secondary">Filter</button>
        </form>
        
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Laporan</th>
                        <th>Jenis</th>
                        <th>Periode</th>
                        <th>Tanggal Dibuat</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporanList ?? [
                        ['id' => 1, 'judul' => 'Laporan Kehadiran TK A', 'jenis' => 'Kehadiran', 'periode' => '1 - 28 Feb 2026', 'tanggal' => '01 Mar 2026', 'status' => 'generated'],
                        ['id' => 2, 'judul' => 'Laporan Perkembangan Ahmad Fauzi', 'jenis' => 'Perkembangan', 'periode' => 'Feb 2026', 'tanggal' => '28 Feb 2026', 'status' => 'generated'],
                        ['id' => 3, 'judul' => 'Laporan Bulanan TK B', 'jenis' => 'Bulanan', 'periode' => 'Feb 2026', 'tanggal' => '28 Feb 2026', 'status' => 'generated'],
                        ['id' => 4, 'judul' => 'Laporan Kehadiran TK B', 'jenis' => 'Kehadiran', 'periode' => '1 - 4 Mar 2026', 'tanggal' => '04 Mar 2026', 'status' => 'pending'],
                        ['id' => 5, 'judul' => 'Laporan Perkembangan Siti', 'jenis' => 'Perkembangan', 'periode' => 'Mar 2026', 'tanggal' => '03 Mar 2026', 'status' => 'draft'],
                    ] as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item['judul'] }}</td>
                            <td>{{ $item['jenis'] }}</td>
                            <td>{{ $item['periode'] }}</td>
                            <td>{{ $item['tanggal'] }}</td>
                            <td>
                                <span class="status-badge status-badge--{{ $item['status'] }}">
                                    @if($item['status'] == 'generated') Selesai
                                    @elseif($item['status'] == 'pending') Pending
                                    @else Draft
                                    @endif
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button type="button" class="btn-blue" onclick="alert('Menampilkan laporan: {{ $item['judul'] }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm.53 5.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 0 0 1.06 1.06l1.72-1.72v5.69a.75.75 0 0 0 1.5 0v-5.69l1.72 1.72a.75.75 0 1 0 1.06-1.06l-3-3Z" clip-rule="evenodd"/>
                                        </svg>
                                        Lihat
                                    </button>
                                    <button type="button" class="btn-green" onclick="alert('Mengunduh laporan: {{ $item['judul'] }}')">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M12 2.25a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V3a.75.75 0 0 1 .75-.75Zm-9 13.5a.75.75 0 0 1 .75.75v2.25a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5V16.5a.75.75 0 0 1 1.5 0v2.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V16.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/>
                                        </svg>
                                        Unduh
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; color: #5D4037; padding: 40px;">
                                Belum ada data laporan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Toggle report type tab active state
    document.querySelectorAll('.report-type-tab').forEach(function(tab) {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.report-type-tab').forEach(function(t) {
                t.classList.remove('active');
            });
            this.classList.add('active');
        });
    });
</script>
@endpush
