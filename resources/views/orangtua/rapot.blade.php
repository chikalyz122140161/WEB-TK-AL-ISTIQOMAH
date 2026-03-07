@extends('layouts.app')

@section('title', 'Rapot Semester - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Rapot Semester')

@section('sidebar')
    @include('orangtua.partials.sidebar')
@endsection

@push('styles')
<style>
    /* Info Banner */
    .info-banner {
        background: linear-gradient(135deg, #00473e 0%, #006b5a 100%);
        border-radius: 12px;
        padding: 20px 24px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .info-banner__icon {
        width: 56px;
        height: 56px;
        background: rgba(250, 174, 43, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .info-banner__icon svg {
        width: 28px;
        height: 28px;
        fill: #faae2b;
    }
    .info-banner__content h3 {
        color: #fff;
        font-size: 18px;
        margin: 0 0 4px 0;
    }
    .info-banner__content p {
        color: rgba(255,255,255,0.8);
        font-size: 14px;
        margin: 0;
    }
    
    /* Rapot Grid (Responsive) */
    .rapot-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 20px;
    }
    
    @media (max-width: 640px) {
        .rapot-grid {
            grid-template-columns: 1fr;
        }
    }
    
    /* Rapot Card */
    .rapot-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: all 0.3s;
    }
    .rapot-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .rapot-card__header {
        background: linear-gradient(135deg, #faae2b 0%, #f5a623 100%);
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .rapot-card__semester {
        font-size: 14px;
        font-weight: 700;
        color: #00473e;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .rapot-card__year {
        font-size: 12px;
        font-weight: 600;
        color: #00473e;
        background: rgba(0,71,62,0.1);
        padding: 4px 10px;
        border-radius: 20px;
    }
    .rapot-card__body {
        padding: 20px;
    }
    .rapot-info {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 16px;
    }
    .rapot-info__item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        color: #475d5b;
    }
    .rapot-info__item svg {
        width: 18px;
        height: 18px;
        fill: #faae2b;
        flex-shrink: 0;
    }
    .rapot-info__label {
        color: #6b7280;
        min-width: 100px;
    }
    .rapot-info__value {
        font-weight: 600;
        color: #00473e;
    }
    .rapot-card__actions {
        display: flex;
        gap: 10px;
        padding-top: 16px;
        border-top: 1px solid #f0f0f0;
    }
    .btn-lihat {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: linear-gradient(135deg, #00473e 0%, #006b5a 100%);
        color: #fff;
        padding: 12px 16px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s;
    }
    .btn-lihat:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,71,62,0.3);
    }
    .btn-lihat svg {
        width: 16px;
        height: 16px;
        fill: currentColor;
    }
    .btn-download {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: linear-gradient(135deg, #faae2b 0%, #f5a623 100%);
        color: #00473e;
        padding: 12px 16px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s;
    }
    .btn-download:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(250, 174, 43, 0.3);
    }
    .btn-download svg {
        width: 16px;
        height: 16px;
        fill: currentColor;
    }
    
    /* Empty State */
    .empty-state {
        background: #fff;
        border-radius: 12px;
        text-align: center;
        padding: 60px 40px;
        color: #475d5b;
    }
    .empty-state svg {
        width: 80px;
        height: 80px;
        fill: #d1d5db;
        margin-bottom: 20px;
    }
    .empty-state h3 {
        color: #00473e;
        font-size: 18px;
        margin: 0 0 8px 0;
    }
    .empty-state p {
        margin: 0;
        font-size: 14px;
    }
    
    /* Responsive adjustments */
    @media (max-width: 480px) {
        .info-banner {
            flex-direction: column;
            text-align: center;
            padding: 16px;
        }
        .rapot-card__actions {
            flex-direction: column;
        }
        .btn-lihat, .btn-download {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')

    {{-- Info Banner --}}
    <div class="info-banner">
        <div class="info-banner__icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 4.8 11.06a.75.75 0 0 1-.231-1.337A60.65 60.65 0 0 1 11.7 2.805Z"/><path d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.833 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286a48.45 48.45 0 0 1 7.667 3.282.75.75 0 0 0 1.12 0Z"/></svg>
        </div>
        <div class="info-banner__content">
            <h3>Rapot Semester {{ $student->name ?? 'Anak Anda' }}</h3>
            <p>Laporan perkembangan akhir semester berdasarkan Kurikulum Merdeka PAUD</p>
        </div>
    </div>

    {{-- Rapot Grid --}}
    @if(!empty($rapotList) && count($rapotList) > 0)
        <div class="rapot-grid">
            @foreach($rapotList as $rapot)
                <div class="rapot-card">
                    <div class="rapot-card__header">
                        <span class="rapot-card__semester">Semester {{ $rapot['semester'] }}</span>
                        <span class="rapot-card__year">{{ $rapot['tahun_ajaran'] }}</span>
                    </div>
                    <div class="rapot-card__body">
                        <div class="rapot-info">
                            <div class="rapot-info__item">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z" clip-rule="evenodd"/></svg>
                                <span class="rapot-info__label">Kelas</span>
                                <span class="rapot-info__value">{{ $rapot['kelas'] }}</span>
                            </div>
                            <div class="rapot-info__item">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd"/></svg>
                                <span class="rapot-info__label">Terbit</span>
                                <span class="rapot-info__value">{{ $rapot['tanggal_terbit'] }}</span>
                            </div>
                        </div>
                        <div class="rapot-card__actions">
                            <a href="{{ route('orangtua.rapot.detail', $rapot['id']) }}" class="btn-lihat">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd"/></svg>
                                Lihat Detail
                            </a>
                            <a href="{{ route('orangtua.rapot.download', $rapot['id']) }}" class="btn-download">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M12 2.25a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V3a.75.75 0 0 1 .75-.75Zm-9 13.5a.75.75 0 0 1 .75.75v2.25a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5V16.5a.75.75 0 0 1 1.5 0v2.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V16.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
                                PDF
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z"/><path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z"/></svg>
            <h3>Belum Ada Rapot</h3>
            <p>Rapot semester akan tersedia setelah akhir semester.</p>
        </div>
    @endif

@endsection
