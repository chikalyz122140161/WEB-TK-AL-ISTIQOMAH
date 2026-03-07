@extends('layouts.app')

@section('title', 'Detail Rapot Semester - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Detail Rapot Semester')

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

    /* Page Actions */
    .page-actions {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }
    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        font-size: 13px;
        font-weight: 600;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
    }
    .btn-action svg {
        width: 16px;
        height: 16px;
        fill: currentColor;
    }
    .btn-edit {
        background: linear-gradient(135deg, #faae2b 0%, #f5a623 100%);
        color: #00473e;
    }
    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(250, 174, 43, 0.3);
    }
    .btn-print {
        background: #00473e;
        color: #fff;
    }
    .btn-print:hover {
        background: #006b5a;
    }
    .btn-delete {
        background: #fee2e2;
        color: #dc2626;
    }
    .btn-delete:hover {
        background: #fecaca;
    }

    /* Student Header Card */
    .student-header {
        background: linear-gradient(135deg, #00473e 0%, #006b5a 100%);
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
        display: flex;
        gap: 20px;
        align-items: center;
    }
    .student-avatar {
        width: 80px;
        height: 80px;
        background: #faae2b;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: 700;
        color: #00473e;
        flex-shrink: 0;
    }
    .student-info {
        flex: 1;
    }
    .student-name {
        color: #fff;
        font-size: 22px;
        font-weight: 700;
        margin: 0 0 8px 0;
    }
    .student-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
    }
    .student-meta__item {
        color: rgba(255,255,255,0.8);
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .student-meta__item svg {
        width: 14px;
        height: 14px;
        fill: #faae2b;
    }
    .student-status {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .student-status.terbit {
        background: rgba(16,185,129,0.2);
        color: #10b981;
    }
    .student-status.draft {
        background: rgba(250,174,43,0.2);
        color: #faae2b;
    }
    @media (max-width: 600px) {
        .student-header {
            flex-direction: column;
            text-align: center;
        }
        .student-meta {
            justify-content: center;
        }
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
        background: linear-gradient(135deg, #00473e 0%, #006b5a 100%);
        padding: 16px 24px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .section-card__header svg {
        width: 22px;
        height: 22px;
        fill: #faae2b;
    }
    .section-card__title {
        color: #fff;
        font-size: 16px;
        font-weight: 600;
        margin: 0;
    }
    .section-card__body {
        padding: 24px;
    }

    /* Nilai Items */
    .nilai-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .nilai-item {
        background: #f8fafc;
        border-radius: 12px;
        padding: 20px;
        border-left: 4px solid #faae2b;
    }
    .nilai-item__header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }
    .nilai-item__title {
        font-size: 15px;
        font-weight: 600;
        color: #00473e;
    }
    .nilai-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .nilai-badge.bb {
        background: #fee2e2;
        color: #dc2626;
    }
    .nilai-badge.mb {
        background: #fef3c7;
        color: #d97706;
    }
    .nilai-badge.bsh {
        background: #d1fae5;
        color: #059669;
    }
    .nilai-badge.bsb {
        background: #dbeafe;
        color: #2563eb;
    }
    .nilai-item__desc {
        font-size: 14px;
        color: #475d5b;
        line-height: 1.6;
    }

    /* Kehadiran Grid */
    .kehadiran-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }
    @media (max-width: 600px) {
        .kehadiran-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    .kehadiran-item {
        background: #f8fafc;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
    }
    .kehadiran-item__value {
        font-size: 32px;
        font-weight: 700;
        color: #00473e;
        margin-bottom: 4px;
    }
    .kehadiran-item__label {
        font-size: 12px;
        color: #6b7280;
        text-transform: uppercase;
        font-weight: 600;
    }
    .kehadiran-item.hadir { border-bottom: 3px solid #10b981; }
    .kehadiran-item.izin { border-bottom: 3px solid #3b82f6; }
    .kehadiran-item.sakit { border-bottom: 3px solid #f59e0b; }
    .kehadiran-item.alpa { border-bottom: 3px solid #ef4444; }

    /* Catatan Box */
    .catatan-box {
        background: #fffbeb;
        border: 1px solid #fcd34d;
        border-radius: 10px;
        padding: 16px 20px;
        margin-bottom: 16px;
    }
    .catatan-box__label {
        font-size: 12px;
        font-weight: 600;
        color: #92400e;
        text-transform: uppercase;
        margin-bottom: 8px;
    }
    .catatan-box__text {
        font-size: 14px;
        color: #78350f;
        line-height: 1.6;
    }
    .catatan-box.rekomendasi {
        background: #ecfdf5;
        border-color: #6ee7b7;
    }
    .catatan-box.rekomendasi .catatan-box__label {
        color: #065f46;
    }
    .catatan-box.rekomendasi .catatan-box__text {
        color: #047857;
    }

    /* Legend */
    .legend-inline {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        padding: 12px 16px;
        background: #f0fdf4;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 11px;
        color: #475d5b;
    }
    .legend-inline__item {
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
</style>
@endpush

@section('content')

    {{-- Back Link --}}
    <a href="{{ route('guru.rapot.index') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M7.28 7.72a.75.75 0 0 1 0 1.06l-2.47 2.47H21a.75.75 0 0 1 0 1.5H4.81l2.47 2.47a.75.75 0 1 1-1.06 1.06l-3.75-3.75a.75.75 0 0 1 0-1.06l3.75-3.75a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/></svg>
        Kembali ke Daftar Rapot
    </a>

    {{-- Page Actions --}}
    <div class="page-actions">
        <a href="{{ route('guru.rapot.edit', $rapot['id']) }}" class="btn-action btn-edit">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/></svg>
            Edit Rapot
        </a>
        <button class="btn-action btn-print" onclick="window.print()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 0 0 3 3h.27l-.155 1.705A1.875 1.875 0 0 0 7.232 22.5h9.536a1.875 1.875 0 0 0 1.867-2.045l-.155-1.705h.27a3 3 0 0 0 3-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0 0 18 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM16.5 6.205v-2.83A.375.375 0 0 0 16.125 3h-8.25a.375.375 0 0 0-.375.375v2.83a49.353 49.353 0 0 1 9 0Zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 0 1-.374.413H7.232a.375.375 0 0 1-.374-.413l.526-5.784a.373.373 0 0 1 .333-.337 41.741 41.741 0 0 1 8.566 0Z" clip-rule="evenodd"/></svg>
            Cetak
        </button>
        <form action="{{ route('guru.rapot.destroy', $rapot['id']) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus rapot ini?')" style="display:inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-action btn-delete">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd"/></svg>
                Hapus
            </button>
        </form>
    </div>

    {{-- Student Header --}}
    <div class="student-header">
        <div class="student-avatar">{{ strtoupper(substr($rapot['siswa']['nama'], 0, 1)) }}</div>
        <div class="student-info">
            <h2 class="student-name">{{ $rapot['siswa']['nama'] }}</h2>
            <div class="student-meta">
                <div class="student-meta__item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002c-.114.06-.227.119-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z"/><path d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286a48.401 48.401 0 0 1 7.667 3.282 49.847 49.847 0 0 1 2.119.001Z"/></svg>
                    {{ $rapot['kelas'] }}
                </div>
                <div class="student-meta__item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
                    {{ $rapot['tahun_ajaran'] }}
                </div>
                <div class="student-meta__item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd"/></svg>
                    Semester {{ $rapot['semester'] }}
                </div>
                @if($rapot['tanggal_terbit'])
                <div class="student-meta__item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM7.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8.25 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM9.75 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM10.5 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM12.75 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM14.25 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 13.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"/><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd"/></svg>
                    Terbit: {{ \Carbon\Carbon::parse($rapot['tanggal_terbit'])->isoFormat('D MMMM Y') }}
                </div>
                @endif
            </div>
        </div>
        <span class="student-status {{ $rapot['status'] == 'Terbit' ? 'terbit' : 'draft' }}">{{ $rapot['status'] }}</span>
    </div>

    {{-- Capaian Perkembangan --}}
    <div class="section-card">
        <div class="section-card__header">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Z" clip-rule="evenodd"/></svg>
            <h3 class="section-card__title">Capaian Perkembangan</h3>
        </div>
        <div class="section-card__body">
            {{-- Legend --}}
            <div class="legend-inline">
                <div class="legend-inline__item"><span class="legend-dot bb"></span><strong>BB</strong> = Belum Berkembang</div>
                <div class="legend-inline__item"><span class="legend-dot mb"></span><strong>MB</strong> = Mulai Berkembang</div>
                <div class="legend-inline__item"><span class="legend-dot bsh"></span><strong>BSH</strong> = Berkembang Sesuai Harapan</div>
                <div class="legend-inline__item"><span class="legend-dot bsb"></span><strong>BSB</strong> = Berkembang Sangat Baik</div>
            </div>

            <div class="nilai-list">
                {{-- Agama & Moral --}}
                <div class="nilai-item">
                    <div class="nilai-item__header">
                        <span class="nilai-item__title">1. Nilai Agama & Moral</span>
                        <span class="nilai-badge {{ strtolower($rapot['nilai']['agama_moral']) }}">{{ $rapot['nilai']['agama_moral'] }}</span>
                    </div>
                    <p class="nilai-item__desc">{{ $rapot['nilai']['agama_moral_deskripsi'] }}</p>
                </div>

                {{-- Fisik Motorik --}}
                <div class="nilai-item">
                    <div class="nilai-item__header">
                        <span class="nilai-item__title">2. Fisik Motorik</span>
                        <span class="nilai-badge {{ strtolower($rapot['nilai']['fisik_motorik']) }}">{{ $rapot['nilai']['fisik_motorik'] }}</span>
                    </div>
                    <p class="nilai-item__desc">{{ $rapot['nilai']['fisik_motorik_deskripsi'] }}</p>
                </div>

                {{-- Kognitif --}}
                <div class="nilai-item">
                    <div class="nilai-item__header">
                        <span class="nilai-item__title">3. Kognitif</span>
                        <span class="nilai-badge {{ strtolower($rapot['nilai']['kognitif']) }}">{{ $rapot['nilai']['kognitif'] }}</span>
                    </div>
                    <p class="nilai-item__desc">{{ $rapot['nilai']['kognitif_deskripsi'] }}</p>
                </div>

                {{-- Bahasa --}}
                <div class="nilai-item">
                    <div class="nilai-item__header">
                        <span class="nilai-item__title">4. Bahasa</span>
                        <span class="nilai-badge {{ strtolower($rapot['nilai']['bahasa']) }}">{{ $rapot['nilai']['bahasa'] }}</span>
                    </div>
                    <p class="nilai-item__desc">{{ $rapot['nilai']['bahasa_deskripsi'] }}</p>
                </div>

                {{-- Sosial Emosional --}}
                <div class="nilai-item">
                    <div class="nilai-item__header">
                        <span class="nilai-item__title">5. Sosial Emosional</span>
                        <span class="nilai-badge {{ strtolower($rapot['nilai']['sosial_emosional']) }}">{{ $rapot['nilai']['sosial_emosional'] }}</span>
                    </div>
                    <p class="nilai-item__desc">{{ $rapot['nilai']['sosial_emosional_deskripsi'] }}</p>
                </div>

                {{-- Seni --}}
                <div class="nilai-item">
                    <div class="nilai-item__header">
                        <span class="nilai-item__title">6. Seni</span>
                        <span class="nilai-badge {{ strtolower($rapot['nilai']['seni']) }}">{{ $rapot['nilai']['seni'] }}</span>
                    </div>
                    <p class="nilai-item__desc">{{ $rapot['nilai']['seni_deskripsi'] }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Kehadiran --}}
    <div class="section-card">
        <div class="section-card__header">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" /></svg>
            <h3 class="section-card__title">Rekap Kehadiran</h3>
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
    @if($rapot['catatan_guru'] || $rapot['rekomendasi'])
    <div class="section-card">
        <div class="section-card__header">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z"/><path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z"/></svg>
            <h3 class="section-card__title">Catatan & Rekomendasi</h3>
        </div>
        <div class="section-card__body">
            @if($rapot['catatan_guru'])
            <div class="catatan-box">
                <div class="catatan-box__label">Catatan Guru</div>
                <p class="catatan-box__text">{{ $rapot['catatan_guru'] }}</p>
            </div>
            @endif
            
            @if($rapot['rekomendasi'])
            <div class="catatan-box rekomendasi">
                <div class="catatan-box__label">Rekomendasi</div>
                <p class="catatan-box__text">{{ $rapot['rekomendasi'] }}</p>
            </div>
            @endif
        </div>
    </div>
    @endif

@endsection
