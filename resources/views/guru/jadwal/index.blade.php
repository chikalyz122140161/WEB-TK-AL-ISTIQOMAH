@extends('layouts.app')

@section('title', 'Jadwal - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Jadwal')

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
    .btn-danger {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, #F06292 0%, #d81b60 100%);
        color: white;
        padding: 8px 14px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        border-radius: 6px;
        transition: all 0.2s;
    }
    .btn-danger:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(240, 98, 146, 0.3);
    }
    .btn-danger svg {
        width: 14px;
        height: 14px;
        fill: currentColor;
    }
    .btn-edit {
        display: inline-flex;
        align-items: center;
        gap: 6px;
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
    .btn-edit:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(76, 175, 130, 0.35);
    }
    .btn-edit svg {
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
    
    /* Schedule Type Badge */
    .type-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .type-badge--kegiatan {
        background: #FFF176;
        color: #5D4037;
    }
    .type-badge--pembelajaran {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #2E8B60;
    }
    .type-badge--lainnya {
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
    
    /* Schedule Type Selector */
    .schedule-type-tabs {
        display: flex;
        gap: 8px;
        margin-bottom: 20px;
    }
    .schedule-type-tab {
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
    .schedule-type-tab:hover {
        border-color: #3D9B72;
        color: #3D9B72;
    }
    .schedule-type-tab.active {
        border-color: #3D9B72;
        background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
        color: #c2410c;
    }
    .schedule-type-tab input {
        display: none;
    }
    
    /* Action buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
    }

    /* Delete Modal */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        animation: fadeIn 0.2s ease;
    }
    .modal-overlay.show {
        display: flex;
    }
    .modal-box {
        background: white;
        border-radius: 16px;
        padding: 32px;
        max-width: 420px;
        width: 90%;
        text-align: center;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: slideUp 0.3s ease;
    }
    .modal-icon {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }
    .modal-icon svg {
        width: 28px;
        height: 28px;
        fill: #d81b60;
    }
    .modal-title {
        font-size: 18px;
        font-weight: 700;
        color: #3E2723;
        margin-bottom: 8px;
    }
    .modal-desc {
        font-size: 14px;
        color: #5D4037;
        margin-bottom: 24px;
        line-height: 1.5;
    }
    .modal-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
    }
    .modal-btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 24px;
        background: #3E272320;
        color: #3E2723;
        font-size: 14px;
        font-weight: 600;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .modal-btn-cancel:hover {
        background: #3E272330;
    }
    .modal-btn-delete {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 24px;
        background: linear-gradient(135deg, #F06292 0%, #d81b60 100%);
        color: white;
        font-size: 14px;
        font-weight: 600;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(240, 98, 146, 0.3);
    }
    .modal-btn-delete:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(240, 98, 146, 0.4);
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Tabs for List */
    .list-tabs {
        display: flex;
        gap: 0;
        margin-bottom: 20px;
        border-bottom: 2px solid #3E272320;
    }
    .list-tab {
        padding: 12px 24px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        background: transparent;
        color: #5D4037;
        border: none;
        border-bottom: 2px solid transparent;
        margin-bottom: -2px;
    }
    .list-tab:hover {
        color: #3D9B72;
    }
    .list-tab.active {
        color: #3D9B72;
        border-bottom-color: #3D9B72;
    }
    
    /* Tab Content */
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
    }
    
    /* Schedule Card */
    .schedule-cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 16px;
    }
    .schedule-card {
        background: white;
        border: 1px solid #3E272320;
        border-radius: 12px;
        padding: 16px;
        transition: all 0.2s;
    }
    .schedule-card:hover {
        border-color: #fdba74;
        box-shadow: 0 4px 12px rgba(76, 175, 130, 0.1);
    }
    .schedule-card__header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }
    .schedule-card__title {
        font-size: 15px;
        font-weight: 600;
        color: #3E2723;
    }
    .schedule-card__row {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #5D4037;
        margin-bottom: 8px;
    }
    .schedule-card__row svg {
        width: 16px;
        height: 16px;
        fill: #5D4037;
    }
    .schedule-card__actions {
        display: flex;
        gap: 8px;
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid #3E272320;
    }
    
    @media (max-width: 768px) {
        .filter-row {
            flex-direction: column;
        }
        .filter-row .form-group {
            width: 100%;
        }
        .schedule-type-tabs {
            flex-direction: column;
        }
        .schedule-cards {
            grid-template-columns: 1fr;
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

    <!-- Form Tambah Jadwal -->
    <div class="form-section">
        <div class="form-section__title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z"/>
            </svg>
            Form Tambah Jadwal
        </div>
        
        <form action="{{ route('guru.jadwal.store') }}" method="POST">
            @csrf
            
            <div class="schedule-type-tabs">
                <label class="schedule-type-tab active">
                    <input type="radio" name="jenis_jadwal" value="kegiatan" checked>
                    Jadwal Kegiatan
                </label>
                <label class="schedule-type-tab">
                    <input type="radio" name="jenis_jadwal" value="pembelajaran">
                    Jadwal Pembelajaran
                </label>
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label>Nama Kegiatan / Mata Pelajaran</label>
                    <input type="text" name="nama" placeholder="Contoh: Upacara Bendera, Sentra Balok" required>
                </div>
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label>Waktu Mulai</label>
                    <input type="time" name="waktu_mulai" value="08:00" required>
                </div>
                <div class="form-group">
                    <label>Waktu Selesai</label>
                    <input type="time" name="waktu_selesai" value="09:00" required>
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
                    <label>Lokasi</label>
                    <input type="text" name="lokasi" placeholder="Contoh: Lapangan, Ruang Kelas A">
                </div>
            </div>
            
            <div class="form-group" style="margin-top: 16px;">
                <label>Deskripsi (Opsional)</label>
                <textarea name="deskripsi" rows="3" placeholder="Tambahkan deskripsi kegiatan..."></textarea>
            </div>
            
            <div class="btn-row">
                <button type="submit" class="btn-orange">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/>
                    </svg>
                    Tambah Jadwal
                </button>
            </div>
        </form>
    </div>

    <!-- List Jadwal -->
    <div class="form-section">
        <div class="form-section__title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd"/>
            </svg>
            List Jadwal
        </div>
        
        <!-- Tabs -->
        <div class="list-tabs">
            <button class="list-tab active" data-tab="kegiatan">Jadwal Kegiatan</button>
            <button class="list-tab" data-tab="pembelajaran">Jadwal Pembelajaran</button>
        </div>
        
        <form action="" method="GET" class="filter-row">
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}">
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
        
        <!-- Tab Content: Jadwal Kegiatan -->
        <div id="tab-kegiatan" class="tab-content active">
            <div class="schedule-cards">
                @forelse ($jadwalKegiatan ?? [
                    ['id' => 1, 'nama' => 'Upacara Bendera', 'tanggal' => 'Senin, 10 Mar 2026', 'waktu' => '07:00 - 08:00', 'lokasi' => 'Lapangan', 'kelas' => 'Semua'],
                    ['id' => 2, 'nama' => 'Senam Pagi', 'tanggal' => 'Selasa, 11 Mar 2026', 'waktu' => '07:30 - 08:00', 'lokasi' => 'Lapangan', 'kelas' => 'Semua'],
                    ['id' => 3, 'nama' => 'Outing Class', 'tanggal' => 'Rabu, 12 Mar 2026', 'waktu' => '08:00 - 12:00', 'lokasi' => 'Kebun Binatang', 'kelas' => 'TK B'],
                    ['id' => 4, 'nama' => 'Lomba Mewarnai', 'tanggal' => 'Kamis, 13 Mar 2026', 'waktu' => '09:00 - 11:00', 'lokasi' => 'Aula', 'kelas' => 'Semua'],
                ] as $jadwal)
                    <div class="schedule-card">
                        <div class="schedule-card__header">
                            <div class="schedule-card__title">{{ $jadwal['nama'] }}</div>
                            <span class="type-badge type-badge--kegiatan">Kegiatan</span>
                        </div>
                        <div class="schedule-card__row">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd"/>
                            </svg>
                            {{ $jadwal['tanggal'] }}
                        </div>
                        <div class="schedule-card__row">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd"/>
                            </svg>
                            {{ $jadwal['waktu'] }}
                        </div>
                        <div class="schedule-card__row">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd"/>
                            </svg>
                            {{ $jadwal['lokasi'] }}
                        </div>
                        <div class="schedule-card__row">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z"/>
                            </svg>
                            Kelas: {{ $jadwal['kelas'] }}
                        </div>
                        <div class="schedule-card__actions">
                            <a href="{{ route('guru.jadwal.edit', $jadwal['id']) }}" class="btn-edit">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z"/>
                                </svg>
                                Edit
                            </a>
                            <button type="button" class="btn-danger" onclick="openDeleteModal({{ $jadwal['id'] }}, '{{ $jadwal['nama'] }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd"/>
                                </svg>
                                Hapus
                            </button>
                        </div>
                    </div>
                @empty
                    <p style="color: #5D4037; padding: 40px; text-align: center; grid-column: 1 / -1;">
                        Belum ada jadwal kegiatan.
                    </p>
                @endforelse
            </div>
        </div>
        
        <!-- Tab Content: Jadwal Pembelajaran -->
        <div id="tab-pembelajaran" class="tab-content">
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Hari</th>
                            <th>Waktu</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Guru</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jadwalPembelajaran ?? [
                            ['id' => 1, 'hari' => 'Senin', 'waktu' => '08:00 - 09:00', 'mapel' => 'Sentra Balok', 'kelas' => 'TK A', 'guru' => 'Bu Siti'],
                            ['id' => 2, 'hari' => 'Senin', 'waktu' => '09:00 - 10:00', 'mapel' => 'Sentra Seni', 'kelas' => 'TK A', 'guru' => 'Bu Ani'],
                            ['id' => 3, 'hari' => 'Senin', 'waktu' => '08:00 - 09:00', 'mapel' => 'Sentra Alam', 'kelas' => 'TK B', 'guru' => 'Bu Dewi'],
                            ['id' => 4, 'hari' => 'Selasa', 'waktu' => '08:00 - 09:00', 'mapel' => 'Sentra Peran', 'kelas' => 'TK A', 'guru' => 'Bu Siti'],
                            ['id' => 5, 'hari' => 'Selasa', 'waktu' => '08:00 - 09:00', 'mapel' => 'Sentra Balok', 'kelas' => 'TK B', 'guru' => 'Bu Ani'],
                            ['id' => 6, 'hari' => 'Rabu', 'waktu' => '08:00 - 09:00', 'mapel' => 'Agama Islam', 'kelas' => 'TK A', 'guru' => 'Ustadzah Maya'],
                            ['id' => 7, 'hari' => 'Rabu', 'waktu' => '08:00 - 09:00', 'mapel' => 'Agama Islam', 'kelas' => 'TK B', 'guru' => 'Ustadzah Maya'],
                        ] as $jadwal)
                            <tr>
                                <td><strong>{{ $jadwal['hari'] }}</strong></td>
                                <td>{{ $jadwal['waktu'] }}</td>
                                <td>{{ $jadwal['mapel'] }}</td>
                                <td>
                                    <span class="type-badge type-badge--pembelajaran">{{ $jadwal['kelas'] }}</span>
                                </td>
                                <td>{{ $jadwal['guru'] }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('guru.jadwal.edit', $jadwal['id']) }}" class="btn-edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z"/>
                                            </svg>
                                            Edit
                                        </a>
                                        <button type="button" class="btn-danger" onclick="openDeleteModal({{ $jadwal['id'] }}, '{{ $jadwal['mapel'] }}')">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; color: #5D4037; padding: 40px;">
                                    Belum ada jadwal pembelajaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal-box">
            <div class="modal-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="modal-title">Hapus Jadwal?</div>
            <div class="modal-desc">Apakah Anda yakin ingin menghapus jadwal <strong id="deleteItemName"></strong>? Tindakan ini tidak dapat dibatalkan.</div>
            <div class="modal-actions">
                <button type="button" class="modal-btn-cancel" onclick="closeDeleteModal()">Batal</button>
                <form id="deleteForm" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="modal-btn-delete">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width:16px;height:16px;fill:currentColor;">
                            <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Z" clip-rule="evenodd"/>
                        </svg>
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Toggle schedule type tab active state
    document.querySelectorAll('.schedule-type-tab').forEach(function(tab) {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.schedule-type-tab').forEach(function(t) {
                t.classList.remove('active');
            });
            this.classList.add('active');
        });
    });
    
    // Delete modal functions
    function openDeleteModal(id, nama) {
        document.getElementById('deleteItemName').textContent = nama;
        document.getElementById('deleteForm').action = '/guru/jadwal/' + id;
        document.getElementById('deleteModal').classList.add('show');
    }
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('show');
    }
    // Close modal on overlay click
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });
    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDeleteModal();
    });

    // List tabs functionality
    document.querySelectorAll('.list-tab').forEach(function(tab) {
        tab.addEventListener('click', function() {
            // Remove active from all tabs
            document.querySelectorAll('.list-tab').forEach(function(t) {
                t.classList.remove('active');
            });
            // Add active to clicked tab
            this.classList.add('active');
            
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(function(content) {
                content.classList.remove('active');
            });
            
            // Show corresponding tab content
            var tabId = this.getAttribute('data-tab');
            document.getElementById('tab-' + tabId).classList.add('active');
        });
    });
</script>
@endpush
