@extends('layouts.app')

@section('title', 'Edit Jadwal - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Edit Jadwal')

@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

@push('styles')
<style>
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
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-secondary:hover {
        background: #3E272330;
    }
    .btn-secondary svg {
        width: 16px;
        height: 16px;
        fill: currentColor;
    }
    .btn-row {
        display: flex;
        gap: 12px;
        margin-top: 20px;
    }
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
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #5D4037;
        font-size: 14px;
        text-decoration: none;
        margin-bottom: 16px;
        transition: color 0.2s;
    }
    .back-link:hover {
        color: #3D9B72;
    }
    .back-link svg {
        width: 16px;
        height: 16px;
        fill: currentColor;
    }
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

    @media (max-width: 768px) {
        .schedule-type-tabs {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
    <a href="{{ route('guru.jadwal.index') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M7.28 7.72a.75.75 0 0 1 0 1.06l-2.47 2.47H21a.75.75 0 0 1 0 1.5H4.81l2.47 2.47a.75.75 0 1 1-1.06 1.06l-3.75-3.75a.75.75 0 0 1 0-1.06l3.75-3.75a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/>
        </svg>
        Kembali ke List Jadwal
    </a>

    @if (session('success'))
        <div class="alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:20px;height:20px;">
                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="form-section">
        <div class="form-section__title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z"/>
            </svg>
            Edit Jadwal: {{ $jadwal['nama'] ?? '' }}
        </div>

        <form action="{{ route('guru.jadwal.update', $jadwal['id']) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="schedule-type-tabs">
                <label class="schedule-type-tab {{ ($jadwal['jenis'] ?? 'kegiatan') == 'kegiatan' ? 'active' : '' }}">
                    <input type="radio" name="jenis_jadwal" value="kegiatan" {{ ($jadwal['jenis'] ?? 'kegiatan') == 'kegiatan' ? 'checked' : '' }}>
                    Jadwal Kegiatan
                </label>
                <label class="schedule-type-tab {{ ($jadwal['jenis'] ?? 'kegiatan') == 'pembelajaran' ? 'active' : '' }}">
                    <input type="radio" name="jenis_jadwal" value="pembelajaran" {{ ($jadwal['jenis'] ?? 'kegiatan') == 'pembelajaran' ? 'checked' : '' }}>
                    Jadwal Pembelajaran
                </label>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label>Nama Kegiatan / Mata Pelajaran</label>
                    <input type="text" name="nama" value="{{ $jadwal['nama'] ?? '' }}" placeholder="Contoh: Upacara Bendera, Sentra Balok" required>
                </div>
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" value="{{ $jadwal['tanggal_raw'] ?? date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label>Waktu Mulai</label>
                    <input type="time" name="waktu_mulai" value="{{ $jadwal['waktu_mulai'] ?? '08:00' }}" required>
                </div>
                <div class="form-group">
                    <label>Waktu Selesai</label>
                    <input type="time" name="waktu_selesai" value="{{ $jadwal['waktu_selesai'] ?? '09:00' }}" required>
                </div>
                <div class="form-group">
                    <label>Kelas</label>
                    <select name="kelas">
                        <option value="" {{ ($jadwal['kelas'] ?? '') == '' || ($jadwal['kelas'] ?? '') == 'Semua' ? 'selected' : '' }}>Semua Kelas</option>
                        <option value="TK A" {{ ($jadwal['kelas'] ?? '') == 'TK A' ? 'selected' : '' }}>TK A</option>
                        <option value="TK B" {{ ($jadwal['kelas'] ?? '') == 'TK B' ? 'selected' : '' }}>TK B</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Lokasi</label>
                    <input type="text" name="lokasi" value="{{ $jadwal['lokasi'] ?? '' }}" placeholder="Contoh: Lapangan, Ruang Kelas A">
                </div>
            </div>

            <div class="form-group" style="margin-top: 16px;">
                <label>Deskripsi (Opsional)</label>
                <textarea name="deskripsi" rows="3" placeholder="Tambahkan deskripsi kegiatan...">{{ $jadwal['deskripsi'] ?? '' }}</textarea>
            </div>

            <div class="btn-row">
                <button type="submit" class="btn-orange">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/>
                    </svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('guru.jadwal.index') }}" class="btn-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
                    </svg>
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.schedule-type-tab').forEach(function(tab) {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.schedule-type-tab').forEach(function(t) {
                t.classList.remove('active');
            });
            this.classList.add('active');
        });
    });
</script>
@endpush
