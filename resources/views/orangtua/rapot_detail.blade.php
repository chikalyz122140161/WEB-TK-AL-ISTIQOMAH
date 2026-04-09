@extends('layouts.app')
@php $userRole = 'Orang Tua'; @endphp

@section('title', 'Detail Rapot - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Detail Rapot Semester')

@section('sidebar')
    @include('orangtua.partials.sidebar')
@endsection

@push('styles')
<style>
    /* Back Button */
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #3E2723;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        margin-bottom: 20px;
        transition: all 0.2s;
    }
    .back-link:hover {
        color: #4CAF82;
    }
    .back-link svg {
        width: 16px;
        height: 16px;
        fill: currentColor;
    }
    
    /* Rapot Header */
    .rapot-header {
        background: linear-gradient(135deg, #3E2723 0%, #006b5a 100%);
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
        color: #fff;
    }
    .rapot-header__top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 16px;
    }
    .rapot-header__info {
        flex: 1;
    }
    .rapot-header__title {
        font-size: 22px;
        font-weight: 700;
        margin: 0 0 8px 0;
    }
    .rapot-header__subtitle {
        font-size: 14px;
        opacity: 0.9;
    }
    .rapot-header__badge {
        background: rgba(76,175,130, 0.2);
        color: #4CAF82;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }
    .rapot-header__meta {
        display: flex;
        flex-wrap: wrap;
        gap: 24px;
    }
    .rapot-meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
    }
    .rapot-meta-item svg {
        width: 16px;
        height: 16px;
        fill: #4CAF82;
    }
    
    .btn-download-pdf {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
        color: #3E2723;
        padding: 12px 20px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s;
    }
    .btn-download-pdf:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(76,175,130, 0.4);
    }
    .btn-download-pdf svg {
        width: 18px;
        height: 18px;
        fill: currentColor;
    }
    
    /* Section Card */
    .section-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        margin-bottom: 24px;
    }
    .section-card__header {
        background: linear-gradient(135deg, #4CAF8220 0%, #4CAF8230 100%);
        padding: 16px 20px;
        border-bottom: 1px solid #4CAF8240;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .section-card__header svg {
        width: 22px;
        height: 22px;
        fill: #4CAF82;
    }
    .section-card__title {
        font-size: 15px;
        font-weight: 700;
        color: #3E2723;
        margin: 0;
    }
    .section-card__body {
        padding: 20px;
    }
    
    /* Nilai Grid */
    .nilai-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 16px;
    }
    @media (max-width: 640px) {
        .nilai-grid {
            grid-template-columns: 1fr;
        }
    }
    .nilai-item {
        background: #FFFDE7;
        border-radius: 10px;
        padding: 16px;
        border-left: 4px solid #4CAF82;
    }
    .nilai-item__header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    .nilai-item__label {
        font-size: 13px;
        font-weight: 600;
        color: #3E2723;
    }
    .nilai-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        color: #fff;
    }
    .nilai-badge.bb { background: #F06292; }
    .nilai-badge.mb { background: #f59e0b; }
    .nilai-badge.bsh { background: #10b981; }
    .nilai-badge.bsb { background: #4CAF82; }
    .nilai-item__desc {
        font-size: 13px;
        color: #5D4037;
        line-height: 1.6;
    }
    
    /* Kehadiran */
    .kehadiran-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
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
        background: #FFFDE7;
        border-radius: 10px;
        padding: 16px;
        text-align: center;
    }
    .kehadiran-item__value {
        font-size: 28px;
        font-weight: 700;
        color: #3E2723;
        margin-bottom: 4px;
    }
    .kehadiran-item__label {
        font-size: 12px;
        color: #5D4037;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .kehadiran-item.hadir { border-top: 3px solid #10b981; }
    .kehadiran-item.izin { border-top: 3px solid #4CAF82; }
    .kehadiran-item.sakit { border-top: 3px solid #f59e0b; }
    .kehadiran-item.alpa { border-top: 3px solid #d81b60; }
    
    /* Catatan */
    .catatan-box {
        background: #FFFDE7;
        border-radius: 10px;
        padding: 16px;
        margin-bottom: 12px;
    }
    .catatan-box:last-child {
        margin-bottom: 0;
    }
    .catatan-box__label {
        font-size: 12px;
        font-weight: 600;
        color: #4CAF82;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }
    .catatan-box__text {
        font-size: 14px;
        color: #5D4037;
        line-height: 1.7;
    }
    
    /* Legend */
    .legend-box {
        background: #FFFDE7;
        border-radius: 10px;
        padding: 16px;
    }
    .legend-title {
        font-size: 13px;
        font-weight: 600;
        color: #3E2723;
        margin-bottom: 12px;
    }
    .legend-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 10px;
    }
    @media (max-width: 480px) {
        .legend-grid {
            grid-template-columns: 1fr;
        }
    }
    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        color: #5D4037;
    }
    .legend-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .legend-dot.bb { background: #F06292; }
    .legend-dot.mb { background: #f59e0b; }
    .legend-dot.bsh { background: #10b981; }
    .legend-dot.bsb { background: #4CAF82; }
    
    /* Teacher Info */
    .teacher-info {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px;
        background: #FFFDE7;
        border-radius: 10px;
    }
    .teacher-avatar {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #3E2723 0%, #006b5a 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .teacher-avatar svg {
        width: 24px;
        height: 24px;
        fill: #4CAF82;
    }
    .teacher-detail h4 {
        font-size: 14px;
        font-weight: 600;
        color: #3E2723;
        margin: 0 0 4px 0;
    }
    .teacher-detail p {
        font-size: 12px;
        color: #5D4037;
        margin: 0;
    }
</style>
@endpush

@section('content')

    {{-- Back Link --}}
    <a href="{{ route('orangtua.rapot') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M7.28 7.72a.75.75 0 0 1 0 1.06l-2.47 2.47H21a.75.75 0 0 1 0 1.5H4.81l2.47 2.47a.75.75 0 1 1-1.06 1.06l-3.75-3.75a.75.75 0 0 1 0-1.06l3.75-3.75a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/></svg>
        Kembali ke Daftar Rapot
    </a>

    {{-- Rapot Header --}}
    <div class="rapot-header">
        <div class="rapot-header__top">
            <div class="rapot-header__info">
                <h1 class="rapot-header__title">Rapot Semester {{ $rapot['semester'] }}</h1>
                <p class="rapot-header__subtitle">Tahun Ajaran {{ $rapot['tahun_ajaran'] }}</p>
            </div>
            <div class="rapot-header__badge">{{ $rapot['kelas'] }}</div>
        </div>
        <div class="rapot-header__meta">
            <div class="rapot-meta-item">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd"/></svg>
                {{ $rapot['siswa']['nama'] }}
            </div>
            <div class="rapot-meta-item">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" /></svg>
                Terbit: {{ $rapot['tanggal_terbit'] }}
            </div>
        </div>
    </div>

    {{-- Download Button --}}
    <div style="margin-bottom: 24px;">
        <a href="{{ route('orangtua.rapot.download', $rapot['id']) }}" class="btn-download-pdf">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M12 2.25a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V3a.75.75 0 0 1 .75-.75Zm-9 13.5a.75.75 0 0 1 .75.75v2.25a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5V16.5a.75.75 0 0 1 1.5 0v2.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V16.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
            Download Rapot (PDF)
        </a>
    </div>

    {{-- Capaian Perkembangan --}}
    <div class="section-card">
        <div class="section-card__header">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Z" clip-rule="evenodd"/></svg>
            <h3 class="section-card__title">Capaian Perkembangan Anak</h3>
        </div>
        <div class="section-card__body">
            {{-- Legend --}}
            <div class="legend-box" style="margin-bottom: 20px;">
                <div class="legend-title">Keterangan Capaian:</div>
                <div class="legend-grid">
                    <div class="legend-item"><span class="legend-dot bb"></span><span><strong>BB</strong> - Belum Berkembang</span></div>
                    <div class="legend-item"><span class="legend-dot mb"></span><span><strong>MB</strong> - Mulai Berkembang</span></div>
                    <div class="legend-item"><span class="legend-dot bsh"></span><span><strong>BSH</strong> - Berkembang Sesuai Harapan</span></div>
                    <div class="legend-item"><span class="legend-dot bsb"></span><span><strong>BSB</strong> - Berkembang Sangat Baik</span></div>
                </div>
            </div>

            <div class="nilai-grid">
                <div class="nilai-item">
                    <div class="nilai-item__header">
                        <span class="nilai-item__label">1. Nilai Agama & Moral</span>
                        <span class="nilai-badge {{ strtolower($rapot['nilai']['agama_moral']) }}">{{ $rapot['nilai']['agama_moral'] }}</span>
                    </div>
                    <p class="nilai-item__desc">{{ $rapot['nilai']['agama_moral_deskripsi'] ?: 'Deskripsi belum tersedia.' }}</p>
                </div>
                <div class="nilai-item">
                    <div class="nilai-item__header">
                        <span class="nilai-item__label">2. Fisik Motorik</span>
                        <span class="nilai-badge {{ strtolower($rapot['nilai']['fisik_motorik']) }}">{{ $rapot['nilai']['fisik_motorik'] }}</span>
                    </div>
                    <p class="nilai-item__desc">{{ $rapot['nilai']['fisik_motorik_deskripsi'] ?: 'Deskripsi belum tersedia.' }}</p>
                </div>
                <div class="nilai-item">
                    <div class="nilai-item__header">
                        <span class="nilai-item__label">3. Kognitif</span>
                        <span class="nilai-badge {{ strtolower($rapot['nilai']['kognitif']) }}">{{ $rapot['nilai']['kognitif'] }}</span>
                    </div>
                    <p class="nilai-item__desc">{{ $rapot['nilai']['kognitif_deskripsi'] ?: 'Deskripsi belum tersedia.' }}</p>
                </div>
                <div class="nilai-item">
                    <div class="nilai-item__header">
                        <span class="nilai-item__label">4. Bahasa</span>
                        <span class="nilai-badge {{ strtolower($rapot['nilai']['bahasa']) }}">{{ $rapot['nilai']['bahasa'] }}</span>
                    </div>
                    <p class="nilai-item__desc">{{ $rapot['nilai']['bahasa_deskripsi'] ?: 'Deskripsi belum tersedia.' }}</p>
                </div>
                <div class="nilai-item">
                    <div class="nilai-item__header">
                        <span class="nilai-item__label">5. Sosial Emosional</span>
                        <span class="nilai-badge {{ strtolower($rapot['nilai']['sosial_emosional']) }}">{{ $rapot['nilai']['sosial_emosional'] }}</span>
                    </div>
                    <p class="nilai-item__desc">{{ $rapot['nilai']['sosial_emosional_deskripsi'] ?: 'Deskripsi belum tersedia.' }}</p>
                </div>
                <div class="nilai-item">
                    <div class="nilai-item__header">
                        <span class="nilai-item__label">6. Seni</span>
                        <span class="nilai-badge {{ strtolower($rapot['nilai']['seni']) }}">{{ $rapot['nilai']['seni'] }}</span>
                    </div>
                    <p class="nilai-item__desc">{{ $rapot['nilai']['seni_deskripsi'] ?: 'Deskripsi belum tersedia.' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Kehadiran --}}
    <div class="section-card">
        <div class="section-card__header">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" /></svg>
            <h3 class="section-card__title">Rekap Kehadiran Semester</h3>
        </div>
        <div class="section-card__body">
            <div class="kehadiran-grid">
                <div class="kehadiran-item hadir">
                    <div class="kehadiran-item__value">{{ $rapot['kehadiran']['hadir'] }}</div>
                    <div class="kehadiran-item__label">Hadir</div>
                </div>
                <div class="kehadiran-item izin">
                    <div class="kehadiran-item__value">{{ $rapot['kehadiran']['izin'] }}</div>
                    <div class="kehadiran-item__label">Izin</div>
                </div>
                <div class="kehadiran-item sakit">
                    <div class="kehadiran-item__value">{{ $rapot['kehadiran']['sakit'] }}</div>
                    <div class="kehadiran-item__label">Sakit</div>
                </div>
                <div class="kehadiran-item alpa">
                    <div class="kehadiran-item__value">{{ $rapot['kehadiran']['alpa'] }}</div>
                    <div class="kehadiran-item__label">Alpa</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Catatan & Rekomendasi --}}
    <div class="section-card">
        <div class="section-card__header">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z"/><path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z"/></svg>
            <h3 class="section-card__title">Catatan & Rekomendasi</h3>
        </div>
        <div class="section-card__body">
            <div class="catatan-box">
                <div class="catatan-box__label">Catatan Guru</div>
                <p class="catatan-box__text">{{ $rapot['catatan_guru'] ?: 'Tidak ada catatan.' }}</p>
            </div>
            <div class="catatan-box">
                <div class="catatan-box__label">Rekomendasi</div>
                <p class="catatan-box__text">{{ $rapot['rekomendasi'] ?: 'Tidak ada rekomendasi.' }}</p>
            </div>
        </div>
    </div>

    {{-- Guru Pengajar --}}
    <div class="section-card">
        <div class="section-card__header">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd"/></svg>
            <h3 class="section-card__title">Guru Kelas</h3>
        </div>
        <div class="section-card__body">
            <div class="teacher-info">
                <div class="teacher-avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd"/></svg>
                </div>
                <div class="teacher-detail">
                    <h4>{{ $rapot['guru'] }}</h4>
                    <p>Guru Kelas {{ $rapot['kelas'] }}</p>
                </div>
            </div>
        </div>
    </div>

@endsection
