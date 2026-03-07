@extends('layouts.app')

@section('title', 'Tambah Rapot Semester - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Tambah Rapot Semester')

@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

@push('styles')
<style>
    /* Back Link */
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #00473e;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        margin-bottom: 20px;
        transition: all 0.2s;
    }
    .back-link:hover {
        color: #faae2b;
    }
    .back-link svg {
        width: 16px;
        height: 16px;
        fill: currentColor;
    }

    /* Form Card */
    .form-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        margin-bottom: 24px;
    }
    .form-card__header {
        background: linear-gradient(135deg, #00473e 0%, #006b5a 100%);
        padding: 16px 24px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .form-card__header svg {
        width: 22px;
        height: 22px;
        fill: #faae2b;
    }
    .form-card__title {
        color: #fff;
        font-size: 16px;
        font-weight: 600;
        margin: 0;
    }
    .form-card__body {
        padding: 24px;
    }

    /* Form Grid */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    .form-grid.full {
        grid-template-columns: 1fr;
    }
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Form Group */
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .form-group.full-width {
        grid-column: 1 / -1;
    }
    .form-group label {
        font-size: 13px;
        font-weight: 600;
        color: #00473e;
    }
    .form-group label .required {
        color: #ef4444;
    }
    .form-group input,
    .form-group select,
    .form-group textarea {
        padding: 12px 14px;
        border: 1px solid #00473e30;
        border-radius: 8px;
        font-size: 14px;
        color: #00473e;
        background: #fff;
        transition: all 0.2s;
    }
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #faae2b;
        box-shadow: 0 0 0 3px rgba(250, 174, 43, 0.1);
    }
    .form-group textarea {
        min-height: 100px;
        resize: vertical;
    }
    .form-group .hint {
        font-size: 11px;
        color: #6b7280;
    }

    /* Nilai Section */
    .nilai-section {
        background: #f8fafc;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 16px;
    }
    .nilai-section__header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }
    .nilai-section__title {
        font-size: 14px;
        font-weight: 600;
        color: #00473e;
    }
    .nilai-select {
        min-width: 120px;
    }

    /* Kehadiran Grid */
    .kehadiran-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }
    @media (max-width: 768px) {
        .kehadiran-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 480px) {
        .kehadiran-grid {
            grid-template-columns: 1fr;
        }
    }
    .kehadiran-item {
        text-align: center;
    }
    .kehadiran-item label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #475d5b;
        margin-bottom: 8px;
        text-transform: uppercase;
    }
    .kehadiran-item input {
        width: 100%;
        text-align: center;
        font-size: 18px;
        font-weight: 600;
    }

    /* Legend */
    .legend-box {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 20px;
    }
    .legend-title {
        font-size: 12px;
        font-weight: 600;
        color: #00473e;
        margin-bottom: 8px;
    }
    .legend-items {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        font-size: 11px;
        color: #475d5b;
    }
    .legend-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .legend-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }
    .legend-dot.bb { background: #ef4444; }
    .legend-dot.mb { background: #f59e0b; }
    .legend-dot.bsh { background: #10b981; }
    .legend-dot.bsb { background: #3b82f6; }

    /* Action Buttons */
    .form-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        padding-top: 20px;
        border-top: 1px solid #f0f0f0;
        margin-top: 20px;
    }
    .btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f3f4f6;
        color: #475d5b;
        padding: 12px 24px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s;
    }
    .btn-cancel:hover {
        background: #e5e7eb;
    }
    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #faae2b 0%, #f5a623 100%);
        color: #00473e;
        padding: 12px 24px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        border-radius: 8px;
        transition: all 0.3s;
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(250, 174, 43, 0.3);
    }
    .btn-submit svg {
        width: 18px;
        height: 18px;
        fill: currentColor;
    }
</style>
@endpush

@section('content')

    {{-- Back Link --}}
    <a href="{{ route('guru.rapot.index') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M7.28 7.72a.75.75 0 0 1 0 1.06l-2.47 2.47H21a.75.75 0 0 1 0 1.5H4.81l2.47 2.47a.75.75 0 1 1-1.06 1.06l-3.75-3.75a.75.75 0 0 1 0-1.06l3.75-3.75a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/></svg>
        Kembali ke Daftar Rapot
    </a>

    <form action="{{ route('guru.rapot.store') }}" method="POST">
        @csrf

        {{-- Info Dasar --}}
        <div class="form-card">
            <div class="form-card__header">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd"/></svg>
                <h3 class="form-card__title">Informasi Dasar</h3>
            </div>
            <div class="form-card__body">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Siswa <span class="required">*</span></label>
                        <select name="siswa_id" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($siswaList as $siswa)
                                <option value="{{ $siswa['id'] }}">{{ $siswa['nama'] }} - {{ $siswa['kelas'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kelas <span class="required">*</span></label>
                        <select name="kelas" required>
                            <option value="">-- Pilih Kelas --</option>
                            <option value="TK A">TK A</option>
                            <option value="TK B">TK B</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tahun Ajaran <span class="required">*</span></label>
                        <select name="tahun_ajaran" required>
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            <option value="2025/2026" selected>2025/2026</option>
                            <option value="2024/2025">2024/2025</option>
                            <option value="2023/2024">2023/2024</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Semester <span class="required">*</span></label>
                        <select name="semester" required>
                            <option value="">-- Pilih Semester --</option>
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Terbit</label>
                        <input type="date" name="tanggal_terbit">
                        <span class="hint">Kosongkan jika masih draft</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Capaian Perkembangan --}}
        <div class="form-card">
            <div class="form-card__header">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Z" clip-rule="evenodd"/></svg>
                <h3 class="form-card__title">Capaian Perkembangan</h3>
            </div>
            <div class="form-card__body">
                {{-- Legend --}}
                <div class="legend-box">
                    <div class="legend-title">Keterangan Capaian:</div>
                    <div class="legend-items">
                        <div class="legend-item"><span class="legend-dot bb"></span><strong>BB</strong> = Belum Berkembang</div>
                        <div class="legend-item"><span class="legend-dot mb"></span><strong>MB</strong> = Mulai Berkembang</div>
                        <div class="legend-item"><span class="legend-dot bsh"></span><strong>BSH</strong> = Berkembang Sesuai Harapan</div>
                        <div class="legend-item"><span class="legend-dot bsb"></span><strong>BSB</strong> = Berkembang Sangat Baik</div>
                    </div>
                </div>

                {{-- Nilai Agama & Moral --}}
                <div class="nilai-section">
                    <div class="nilai-section__header">
                        <span class="nilai-section__title">1. Nilai Agama & Moral</span>
                        <select name="agama_moral" class="nilai-select" required>
                            <option value="BB">BB - Belum Berkembang</option>
                            <option value="MB">MB - Mulai Berkembang</option>
                            <option value="BSH" selected>BSH - Berkembang Sesuai Harapan</option>
                            <option value="BSB">BSB - Berkembang Sangat Baik</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="agama_moral_deskripsi" placeholder="Tuliskan deskripsi perkembangan anak pada aspek agama dan moral..."></textarea>
                    </div>
                </div>

                {{-- Fisik Motorik --}}
                <div class="nilai-section">
                    <div class="nilai-section__header">
                        <span class="nilai-section__title">2. Fisik Motorik</span>
                        <select name="fisik_motorik" class="nilai-select" required>
                            <option value="BB">BB - Belum Berkembang</option>
                            <option value="MB">MB - Mulai Berkembang</option>
                            <option value="BSH" selected>BSH - Berkembang Sesuai Harapan</option>
                            <option value="BSB">BSB - Berkembang Sangat Baik</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="fisik_motorik_deskripsi" placeholder="Tuliskan deskripsi perkembangan fisik motorik anak..."></textarea>
                    </div>
                </div>

                {{-- Kognitif --}}
                <div class="nilai-section">
                    <div class="nilai-section__header">
                        <span class="nilai-section__title">3. Kognitif</span>
                        <select name="kognitif" class="nilai-select" required>
                            <option value="BB">BB - Belum Berkembang</option>
                            <option value="MB">MB - Mulai Berkembang</option>
                            <option value="BSH" selected>BSH - Berkembang Sesuai Harapan</option>
                            <option value="BSB">BSB - Berkembang Sangat Baik</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="kognitif_deskripsi" placeholder="Tuliskan deskripsi perkembangan kognitif anak..."></textarea>
                    </div>
                </div>

                {{-- Bahasa --}}
                <div class="nilai-section">
                    <div class="nilai-section__header">
                        <span class="nilai-section__title">4. Bahasa</span>
                        <select name="bahasa" class="nilai-select" required>
                            <option value="BB">BB - Belum Berkembang</option>
                            <option value="MB">MB - Mulai Berkembang</option>
                            <option value="BSH" selected>BSH - Berkembang Sesuai Harapan</option>
                            <option value="BSB">BSB - Berkembang Sangat Baik</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="bahasa_deskripsi" placeholder="Tuliskan deskripsi perkembangan bahasa anak..."></textarea>
                    </div>
                </div>

                {{-- Sosial Emosional --}}
                <div class="nilai-section">
                    <div class="nilai-section__header">
                        <span class="nilai-section__title">5. Sosial Emosional</span>
                        <select name="sosial_emosional" class="nilai-select" required>
                            <option value="BB">BB - Belum Berkembang</option>
                            <option value="MB">MB - Mulai Berkembang</option>
                            <option value="BSH" selected>BSH - Berkembang Sesuai Harapan</option>
                            <option value="BSB">BSB - Berkembang Sangat Baik</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="sosial_emosional_deskripsi" placeholder="Tuliskan deskripsi perkembangan sosial emosional anak..."></textarea>
                    </div>
                </div>

                {{-- Seni --}}
                <div class="nilai-section">
                    <div class="nilai-section__header">
                        <span class="nilai-section__title">6. Seni</span>
                        <select name="seni" class="nilai-select" required>
                            <option value="BB">BB - Belum Berkembang</option>
                            <option value="MB">MB - Mulai Berkembang</option>
                            <option value="BSH" selected>BSH - Berkembang Sesuai Harapan</option>
                            <option value="BSB">BSB - Berkembang Sangat Baik</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="seni_deskripsi" placeholder="Tuliskan deskripsi perkembangan seni anak..."></textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kehadiran --}}
        <div class="form-card">
            <div class="form-card__header">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" /></svg>
                <h3 class="form-card__title">Rekap Kehadiran</h3>
            </div>
            <div class="form-card__body">
                <div class="kehadiran-grid">
                    <div class="kehadiran-item">
                        <label>Hadir</label>
                        <input type="number" name="hadir" value="0" min="0" required>
                    </div>
                    <div class="kehadiran-item">
                        <label>Izin</label>
                        <input type="number" name="izin" value="0" min="0" required>
                    </div>
                    <div class="kehadiran-item">
                        <label>Sakit</label>
                        <input type="number" name="sakit" value="0" min="0" required>
                    </div>
                    <div class="kehadiran-item">
                        <label>Alpa</label>
                        <input type="number" name="alpa" value="0" min="0" required>
                    </div>
                </div>
            </div>
        </div>

        {{-- Catatan & Rekomendasi --}}
        <div class="form-card">
            <div class="form-card__header">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z"/><path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z"/></svg>
                <h3 class="form-card__title">Catatan & Rekomendasi</h3>
            </div>
            <div class="form-card__body">
                <div class="form-grid full">
                    <div class="form-group">
                        <label>Catatan Guru</label>
                        <textarea name="catatan_guru" rows="4" placeholder="Tuliskan catatan umum tentang perkembangan anak selama semester ini..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Rekomendasi</label>
                        <textarea name="rekomendasi" rows="4" placeholder="Tuliskan rekomendasi untuk orang tua dalam mendukung perkembangan anak..."></textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('guru.rapot.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/></svg>
                        Simpan Rapot
                    </button>
                </div>
            </div>
        </div>
    </form>

@endsection
