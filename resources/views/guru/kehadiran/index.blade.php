@extends('layouts.app')

@section('title', 'Kehadiran - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Catat Kehadiran')

@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

@push('styles')
<style>
    /* Teal/Golden Theme Colors */
    .form-section {
        background: #fff;
        border: 1px solid #00473e20;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .form-section__title {
        font-size: 16px;
        font-weight: 600;
        color: #00473e;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 2px solid #faae2b;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .form-section__title svg {
        width: 20px;
        height: 20px;
        fill: #faae2b;
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
        color: #475d5b;
    }
    .form-group input,
    .form-group select {
        padding: 10px 12px;
        border: 1px solid #00473e20;
        border-radius: 6px;
        font-size: 14px;
        color: #475d5b;
        background: #f2f7f5;
        transition: all 0.2s;
    }
    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #faae2b;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(250, 174, 43, 0.15);
    }
    .btn-orange {
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
        box-shadow: 0 4px 14px rgba(250, 174, 43, 0.3);
        transition: all 0.3s;
    }
    .btn-orange:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(250, 174, 43, 0.4);
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
        background: #00473e20;
        color: #00473e;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        border-radius: 8px;
        transition: all 0.2s;
    }
    .btn-secondary:hover {
        background: #00473e30;
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
        border-bottom: 1px solid #00473e20;
    }
    .data-table th {
        background: linear-gradient(135deg, #faae2b20 0%, #faae2b30 100%);
        font-size: 12px;
        font-weight: 600;
        color: #00473e;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .data-table td {
        font-size: 14px;
        color: #475d5b;
    }
    .data-table tr:hover td {
        background: #f2f7f5;
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
    .status-badge--hadir {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #047857;
    }
    .status-badge--izin {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #b45309;
    }
    .status-badge--sakit {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1d4ed8;
    }
    .status-badge--alpa {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #dc2626;
    }
    .btn-edit {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-edit:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
    .btn-edit svg {
        width: 14px;
        height: 14px;
        fill: currentColor;
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
    
    /* Attendance Form */
    .attendance-form-container {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
    }
    .student-attendance-row {
        display: grid;
        grid-template-columns: 1fr 200px 1fr;
        gap: 16px;
        align-items: center;
        padding: 12px 16px;
        background: #f2f7f5;
        border-radius: 8px;
        border: 1px solid #00473e20;
    }
    .student-attendance-row:hover {
        background: #faae2b15;
        border-color: #faae2b;
    }
    .student-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .student-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #faae2b 0%, #f5a623 100%);
        color: #00473e;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
    }
    .student-name {
        font-weight: 600;
        color: #00473e;
        font-size: 14px;
    }
    .student-class {
        font-size: 12px;
        color: #475d5b;
    }
    .status-options {
        display: flex;
        gap: 8px;
    }
    .status-option {
        padding: 6px 12px;
        border: 2px solid #00473e20;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        background: white;
    }
    .status-option:hover {
        border-color: #faae2b;
    }
    .status-option.active {
        border-color: #faae2b;
        background: #faae2b20;
        color: #00473e;
    }
    .status-option input {
        display: none;
    }
    .note-input {
        padding: 8px 12px;
        border: 1px solid #00473e20;
        border-radius: 6px;
        font-size: 13px;
        width: 100%;
    }
    .note-input:focus {
        outline: none;
        border-color: #faae2b;
    }
    
    @media (max-width: 768px) {
        .student-attendance-row {
            grid-template-columns: 1fr;
            gap: 12px;
        }
        .filter-row {
            flex-direction: column;
        }
        .filter-row .form-group {
            width: 100%;
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

    <!-- Form Catat Kehadiran -->
    <div class="form-section">
        <div class="form-section__title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z"/>
                <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z"/>
            </svg>
            Form Catat Kehadiran
        </div>
        
        <form action="{{ route('guru.kehadiran.store') }}" method="POST">
            @csrf
            <div class="form-grid" style="margin-bottom: 20px;">
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label>Kelas</label>
                    <select name="kelas" id="filterKelas">
                        <option value="">Semua Kelas</option>
                        <option value="TK A">TK A</option>
                        <option value="TK B">TK B</option>
                    </select>
                </div>
            </div>
            
            <div class="attendance-form-container">
                @forelse ($siswaList ?? [
                    ['id' => 1, 'nama' => 'Ahmad Fauzi', 'kelas' => 'TK A'],
                    ['id' => 2, 'nama' => 'Siti Nurhaliza', 'kelas' => 'TK A'],
                    ['id' => 3, 'nama' => 'Budi Santoso', 'kelas' => 'TK B'],
                    ['id' => 4, 'nama' => 'Dewi Lestari', 'kelas' => 'TK A'],
                    ['id' => 5, 'nama' => 'Eko Prasetyo', 'kelas' => 'TK B'],
                ] as $siswa)
                    <div class="student-attendance-row">
                        <div class="student-info">
                            <div class="student-avatar">{{ strtoupper(substr($siswa['nama'], 0, 1)) }}</div>
                            <div>
                                <div class="student-name">{{ $siswa['nama'] }}</div>
                                <div class="student-class">{{ $siswa['kelas'] }}</div>
                            </div>
                        </div>
                        <div class="status-options">
                            <label class="status-option active">
                                <input type="radio" name="status[{{ $siswa['id'] }}]" value="hadir" checked>
                                Hadir
                            </label>
                            <label class="status-option">
                                <input type="radio" name="status[{{ $siswa['id'] }}]" value="izin">
                                Izin
                            </label>
                            <label class="status-option">
                                <input type="radio" name="status[{{ $siswa['id'] }}]" value="sakit">
                                Sakit
                            </label>
                            <label class="status-option">
                                <input type="radio" name="status[{{ $siswa['id'] }}]" value="alpa">
                                Alpa
                            </label>
                        </div>
                        <input type="text" name="keterangan[{{ $siswa['id'] }}]" class="note-input" placeholder="Keterangan (opsional)">
                    </div>
                @empty
                    <p style="color: #6B7280; padding: 20px; text-align: center;">Belum ada data siswa.</p>
                @endforelse
            </div>
            
            <div class="btn-row">
                <button type="submit" class="btn-orange">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/>
                    </svg>
                    Simpan Kehadiran
                </button>
            </div>
        </form>
    </div>

    <!-- List Kehadiran -->
    <div class="form-section">
        <div class="form-section__title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd"/>
                <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z" clip-rule="evenodd"/>
            </svg>
            List Kehadiran
        </div>
        
        <form action="{{ route('guru.kehadiran.index') }}" method="GET" class="filter-row">
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" value="{{ request('tanggal', date('Y-m-d')) }}">
            </div>
            <div class="form-group">
                <label>Kelas</label>
                <select name="kelas">
                    <option value="">Semua Kelas</option>
                    <option value="TK A" {{ request('kelas') == 'TK A' ? 'selected' : '' }}>TK A</option>
                    <option value="TK B" {{ request('kelas') == 'TK B' ? 'selected' : '' }}>TK B</option>
                </select>
            </div>
            <button type="submit" class="btn-secondary">Filter</button>
        </form>
        
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kehadiranList ?? [
                        ['id' => 1, 'nama' => 'Ahmad Fauzi', 'kelas' => 'TK A', 'tanggal' => '04 Mar 2026', 'status' => 'hadir', 'keterangan' => '-'],
                        ['id' => 2, 'nama' => 'Siti Nurhaliza', 'kelas' => 'TK A', 'tanggal' => '04 Mar 2026', 'status' => 'hadir', 'keterangan' => '-'],
                        ['id' => 3, 'nama' => 'Budi Santoso', 'kelas' => 'TK B', 'tanggal' => '04 Mar 2026', 'status' => 'izin', 'keterangan' => 'Acara keluarga'],
                        ['id' => 4, 'nama' => 'Dewi Lestari', 'kelas' => 'TK A', 'tanggal' => '04 Mar 2026', 'status' => 'sakit', 'keterangan' => 'Demam'],
                        ['id' => 5, 'nama' => 'Eko Prasetyo', 'kelas' => 'TK B', 'tanggal' => '04 Mar 2026', 'status' => 'hadir', 'keterangan' => '-'],
                    ] as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item['nama'] }}</td>
                            <td>{{ $item['kelas'] }}</td>
                            <td>{{ $item['tanggal'] }}</td>
                            <td>
                                <span class="status-badge status-badge--{{ $item['status'] }}">
                                    {{ ucfirst($item['status']) }}
                                </span>
                            </td>
                            <td>{{ $item['keterangan'] }}</td>
                            <td>
                                <a href="{{ route('guru.kehadiran.edit', $item['id']) }}" class="btn-edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z"/>
                                    </svg>
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; color: #6B7280; padding: 40px;">
                                Belum ada data kehadiran.
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
    // Toggle status option active state
    document.querySelectorAll('.status-option').forEach(function(option) {
        option.addEventListener('click', function() {
            const parent = this.closest('.status-options');
            parent.querySelectorAll('.status-option').forEach(function(opt) {
                opt.classList.remove('active');
            });
            this.classList.add('active');
        });
    });

    // Filter students by class in attendance form
    document.getElementById('filterKelas').addEventListener('change', function() {
        const selectedKelas = this.value;
        const rows = document.querySelectorAll('.student-attendance-row');
        
        rows.forEach(function(row) {
            const studentClass = row.querySelector('.student-class').textContent.trim();
            if (selectedKelas === '' || studentClass === selectedKelas) {
                row.style.display = 'grid';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endpush
