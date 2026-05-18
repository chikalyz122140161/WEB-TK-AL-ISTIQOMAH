@extends('layouts.app')

@section('title', 'Tambah Jadwal - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Tambah Jadwal')

@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

@push('styles')
<style>
    .form-section {
        background: #fff;
        border: 1px solid #3E272320;
        border-radius: 8px;
        padding: 24px;
        margin-bottom: 20px;
        max-width: 600px;
    }
    .form-section__title {
        font-size: 16px;
        font-weight: 600;
        color: #3E2723;
        margin-bottom: 20px;
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
        user-select: none;
    }
    .schedule-type-tab:hover {
        border-color: #3D9B72;
        color: #3D9B72;
    }
    .schedule-type-tab.active {
        border-color: #3D9B72;
        background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
        color: #fff;
    }
    .schedule-type-tab input[type="radio"] {
        display: none;
    }
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 16px;
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
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
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
        text-decoration: none;
    }
    .btn-orange:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(76, 175, 130, 0.4);
    }
    .btn-orange svg { width: 16px; height: 16px; fill: currentColor; }
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
    .btn-secondary:hover { background: #3E272330; }
    .btn-secondary svg { width: 16px; height: 16px; fill: currentColor; }
    .btn-row {
        display: flex;
        gap: 12px;
        margin-top: 8px;
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
    .back-link:hover { color: #3D9B72; }
    .back-link svg { width: 16px; height: 16px; fill: currentColor; }
    .tab-panel { display: none; }
    .tab-panel.active { display: block; }
</style>
@endpush

@section('content')
    <a href="{{ route('guru.jadwal.index') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M7.28 7.72a.75.75 0 0 1 0 1.06l-2.47 2.47H21a.75.75 0 0 1 0 1.5H4.81l2.47 2.47a.75.75 0 1 1-1.06 1.06l-3.75-3.75a.75.75 0 0 1 0-1.06l3.75-3.75a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/>
        </svg>
        Kembali ke List Jadwal
    </a>

    <div class="form-section">
        <div class="form-section__title">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/>
            </svg>
            Tambah Jadwal
        </div>

        <div class="schedule-type-tabs">
            <label class="schedule-type-tab active" id="tab-kegiatan">
                <input type="radio" name="_tab" value="kegiatan" checked>
                Jadwal Kegiatan
            </label>
            <label class="schedule-type-tab" id="tab-pembelajaran">
                <input type="radio" name="_tab" value="pembelajaran">
                Jadwal Pembelajaran
            </label>
        </div>

        {{-- Form: Jadwal Kegiatan --}}
        <div class="tab-panel active" id="panel-kegiatan">
            <form action="{{ route('guru.jadwal.store') }}" method="POST">
                @csrf
                <input type="hidden" name="jenis_jadwal" value="kegiatan">

                <div class="form-grid">
                    <div class="form-group">
                        <label>Nama Kegiatan</label>
                        <input type="text" name="nama" placeholder="Contoh: Upacara Bendera" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Jam Mulai</label>
                        <input type="time" name="start_hour">
                    </div>
                    <div class="form-group">
                        <label>Jam Selesai</label>
                        <input type="time" name="end_hour">
                    </div>
                    <div class="form-group">
                        <label>Kelas</label>
                        <select name="class_term_id" required>
                            <option value="" disabled selected>-- Pilih Kelas --</option>
                            @foreach($classTerms as $ct)
                                <option value="{{ $ct->id }}">{{ $ct->class->name ?? '-' }} — {{ $ct->academicTerm->academic_year ?? '' }} {{ ucfirst($ct->academicTerm->semester ?? '') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Lokasi</label>
                        <input type="text" name="lokasi" placeholder="Contoh: Lapangan, Aula">
                    </div>
                </div>

                <div class="form-group" style="margin-top:4px;">
                    <label>Deskripsi (Opsional)</label>
                    <textarea name="deskripsi" rows="3" placeholder="Tambahkan deskripsi kegiatan..."></textarea>
                </div>

                <div class="btn-row">
                    <button type="submit" class="btn-orange">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/></svg>
                        Simpan
                    </button>
                    <a href="{{ route('guru.jadwal.index') }}" class="btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
                        Batal
                    </a>
                </div>
            </form>
        </div>

        {{-- Form: Jadwal Pembelajaran --}}
        <div class="tab-panel" id="panel-pembelajaran">
            <form action="{{ route('guru.jadwal.store') }}" method="POST">
                @csrf
                <input type="hidden" name="jenis_jadwal" value="pembelajaran">

                <div class="form-group">
                    <label>Nama Mata Pelajaran</label>
                    <input type="text" name="nama" placeholder="Contoh: Sentra Balok, Bahasa Indonesia">
                </div>

                <div class="form-group">
                    <label>Kelas</label>
                    <select name="class_term_id" required>
                        <option value="" disabled selected>-- Pilih Kelas --</option>
                        @foreach($classTerms as $ct)
                            <option value="{{ $ct->id }}">{{ $ct->class->name ?? '-' }} — {{ $ct->academicTerm->academic_year ?? '' }} {{ ucfirst($ct->academicTerm->semester ?? '') }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Hari</label>
                    <select name="day" required>
                        <option value="" disabled selected>-- Pilih Hari --</option>
                        <option value="1">Senin</option>
                        <option value="2">Selasa</option>
                        <option value="3">Rabu</option>
                        <option value="4">Kamis</option>
                        <option value="5">Jumat</option>
                    </select>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Jam Mulai</label>
                        <input type="time" name="start_hour" required>
                    </div>
                    <div class="form-group">
                        <label>Jam Selesai</label>
                        <input type="time" name="end_hour">
                    </div>
                </div>

                <div class="btn-row">
                    <button type="submit" class="btn-orange">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/></svg>
                        Simpan
                    </button>
                    <a href="{{ route('guru.jadwal.index') }}" class="btn-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
                        Batal
                    </a>
                </div>
            </form>
        </div>
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

            var val = this.querySelector('input[type="radio"]').value;
            document.querySelectorAll('.tab-panel').forEach(function(p) {
                p.classList.remove('active');
            });
            document.getElementById('panel-' + val).classList.add('active');
        });
    });
</script>
@endpush
