@extends('layouts.app')

@section('title', 'Detail Laporan Perkembangan - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Detail Laporan Perkembangan')

@push('styles')
<style>
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
        font-weight: 500;
        color: #5D4037;
        margin-bottom: 20px;
        transition: color 0.2s;
        text-decoration: none;
    }
    .back-link:hover { color: #3E2723; }
    .back-link svg { width: 16px; height: 16px; fill: currentColor; }

    .detail-card {
        background: #fff;
        border: 1px solid #3E272320;
        border-radius: 12px;
        overflow: hidden;
        max-width: 820px;
    }
    .detail-card__header {
        background: linear-gradient(135deg, #3D9B72 0%, #2E8B60 100%);
        color: #fff;
        padding: 24px 28px;
    }
    .detail-card__title {
        font-size: 18px;
        font-weight: 700;
        margin: 0 0 10px;
        letter-spacing: .3px;
    }
    .detail-card__meta {
        display: flex;
        flex-wrap: wrap;
        gap: 8px 24px;
        font-size: 13px;
        opacity: 0.92;
        line-height: 1.6;
    }
    .detail-card__meta span {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .detail-card__meta svg { width: 14px; height: 14px; fill: currentColor; }

    .detail-card__body {
        padding: 28px;
    }

    /* Score section header */
    .section-label {
        font-size: 11px;
        font-weight: 700;
        color: #5D4037;
        text-transform: uppercase;
        letter-spacing: .6px;
        margin: 0 0 16px;
        padding-bottom: 10px;
        border-bottom: 2px solid #fb923c;
        display: inline-block;
    }

    /* Aspect grid */
    .aspect-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
        margin-bottom: 28px;
    }
    @media (max-width: 600px) {
        .aspect-grid { grid-template-columns: 1fr; }
    }
    .aspect-item {
        background: #FFF7ED;
        border: 1px solid #FED7AA;
        border-radius: 10px;
        padding: 18px 20px;
    }
    .aspect-item__label {
        font-size: 11px;
        font-weight: 700;
        color: #ffffff;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 8px;
    }
    .aspect-item__score {
        font-size: 34px;
        font-weight: 800;
        color: #2E8B60;
        line-height: 1;
        margin-bottom: 10px;
    }
    .aspect-item__score span {
        font-size: 14px;
        font-weight: 500;
        color: #5D4037;
    }
    .aspect-item__bar {
        height: 8px;
        background: #FED7AA;
        border-radius: 4px;
        overflow: hidden;
    }
    .aspect-item__bar-fill {
        height: 100%;
        border-radius: 4px;
        background: linear-gradient(90deg, #3D9B72 0%, #4CAF82 100%);
        transition: width .4s;
    }
    .aspect-item__desc {
        font-size: 11px;
        color: #5D4037;
        margin-top: 6px;
    }

    /* Rata-rata card */
    .rata-card {
        background: linear-gradient(135deg, #3D9B72 0%, #2E8B60 100%);
        border-radius: 10px;
        padding: 18px 22px;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: #fff;
    }
    .rata-card__label {
        font-size: 13px;
        font-weight: 700;
        opacity: .85;
        letter-spacing: .3px;
    }
    .rata-card__value {
        font-size: 36px;
        font-weight: 800;
        line-height: 1;
    }
    .rata-card__sub {
        font-size: 12px;
        opacity: .75;
        margin-top: 2px;
    }

    /* Notes section */
    .note-section {
        background: #FFFDE7;
        border: 1px solid #3E272320;
        border-radius: 10px;
        padding: 20px;
    }
    .note-section__label {
        font-size: 11px;
        font-weight: 700;
        color: #5D4037;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 10px;
    }
    .note-section__text {
        font-size: 14px;
        color: #3E2723;
        line-height: 1.8;
    }
</style>
@endpush

@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

@section('content')

    <a href="{{ route('guru.laporan_bk') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M17 10a.75.75 0 0 1-.75.75H5.612l4.158 3.96a.75.75 0 1 1-1.04 1.08l-5.5-5.25a.75.75 0 0 1 0-1.08l5.5-5.25a.75.75 0 1 1 1.04 1.08L5.612 9.25H16.25A.75.75 0 0 1 17 10Z" clip-rule="evenodd"/></svg>
        Kembali ke Laporan Perkembangan
    </a>

    @php
        $aspekList = [
            ['key' => 'fisik_motorik',    'label' => 'Fisik-Motorik'],
            ['key' => 'kognitif',          'label' => 'Kognitif'],
            ['key' => 'bahasa',            'label' => 'Bahasa'],
            ['key' => 'sosial_emosional',  'label' => 'Sosial-Emosional'],
            ['key' => 'nilai_agama_moral', 'label' => 'Agama & Moral'],
            ['key' => 'seni',              'label' => 'Seni'],
        ];
        $skalaDesc = ['', 'Belum Berkembang', 'Mulai Berkembang', 'Berkembang Sesuai Harapan', 'Berkembang Sangat Baik'];
    @endphp

    <div class="detail-card">
        <div class="detail-card__header">
            <div class="detail-card__title">Laporan Perkembangan Mingguan</div>
            <div class="detail-card__meta">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd"/></svg>
                    {{ $laporan['nama'] }} &mdash; {{ $laporan['kelas'] }}
                </span>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
                    Minggu {{ $laporan['minggu'] }} &mdash; {{ $laporan['tanggal'] }}
                </span>
            </div>
        </div>

        <div class="detail-card__body">

            {{-- Rata-rata --}}
            <div class="rata-card">
                <div>
                    <div class="rata-card__label">Rata-rata Nilai Perkembangan</div>
                    <div class="rata-card__sub">BB / MB / BSH / BSB</div>
                </div>
                <div>
                    <div class="rata-card__value">{{ number_format($laporan['rata_rata'], 1) }}</div>
                </div>
            </div>

            {{-- Aspek perkembangan --}}
            <p class="section-label">Capaian Per Aspek</p>
            <div class="aspect-grid">
                @foreach ($aspekList as $a)
                @php $skor = $laporan['nilai'][$a['key']] ?? 0; @endphp
                <div class="aspect-item">
                    <div class="aspect-item__label">{{ $a['label'] }}</div>
                    <div class="aspect-item__score">{{ $skor }} <span>/ 4</span></div>
                    <div class="aspect-item__bar">
                        <div class="aspect-item__bar-fill" style="width: {{ ($skor / 4) * 100 }}%"></div>
                    </div>
                    <div class="aspect-item__desc">{{ $skalaDesc[$skor] ?? '' }}</div>
                </div>
                @endforeach
            </div>

            {{-- Catatan guru --}}
            <div class="note-section">
                <div class="note-section__label">Catatan Guru</div>
                <div class="note-section__text">{{ $laporan['catatan'] }}</div>
            </div>

        </div>
    </div>

@endsection
