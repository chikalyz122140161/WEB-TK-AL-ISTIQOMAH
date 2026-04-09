@extends('layouts.app')
@php $userRole = 'Orang Tua'; @endphp

@section('title', 'Detail Laporan - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Detail Laporan Perkembangan')

@section('sidebar')
    @include('orangtua.partials.sidebar')
@endsection

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
    }
    .back-link:hover { color: #3E2723; }
    .back-link svg { width: 16px; height: 16px; fill: currentColor; }

    .detail-card {
        background: #fff;
        border: 1px solid #3E272320;
        border-radius: 8px;
        overflow: hidden;
        max-width: 800px;
    }
    .detail-card__header {
        background: linear-gradient(135deg, #3E2723 0%, #006b5a 100%);
        color: #fff;
        padding: 24px;
    }
    .detail-card__title {
        font-size: 18px;
        font-weight: 700;
        margin: 0 0 8px;
    }
    .detail-card__info {
        font-size: 13px;
        opacity: 0.85;
        line-height: 1.6;
    }
    .detail-card__info p { margin: 0; }
    .detail-card__body {
        padding: 24px;
    }

    .aspect-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    @media (max-width: 768px) {
        .aspect-grid { grid-template-columns: 1fr; }
    }
    .aspect-item {
        background: #FFFDE7;
        border-radius: 8px;
        padding: 20px;
    }
    .aspect-item__label {
        font-size: 12px;
        font-weight: 600;
        color: #5D4037;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }
    .aspect-item__score {
        font-size: 32px;
        font-weight: 700;
        color: #3E2723;
        line-height: 1;
    }
    .aspect-item__bar {
        margin-top: 12px;
        height: 8px;
        background: #3E272320;
        border-radius: 4px;
        overflow: hidden;
    }
    .aspect-item__bar-fill {
        height: 100%;
        border-radius: 4px;
        background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
    }

    .note-section {
        background: #FFFDE7;
        border-radius: 8px;
        padding: 20px;
    }
    .note-section__label {
        font-size: 12px;
        font-weight: 600;
        color: #5D4037;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }
    .note-section__text {
        font-size: 14px;
        color: #3E2723;
        line-height: 1.7;
    }
</style>
@endpush

@section('content')

    <a href="{{ route('orangtua.laporan') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M17 10a.75.75 0 0 1-.75.75H5.612l4.158 3.96a.75.75 0 1 1-1.04 1.08l-5.5-5.25a.75.75 0 0 1 0-1.08l5.5-5.25a.75.75 0 1 1 1.04 1.08L5.612 9.25H16.25A.75.75 0 0 1 17 10Z" clip-rule="evenodd"/></svg>
        Kembali ke List Laporan
    </a>

    @php
        $report = $report ?? null;
        $cognitive = $report->cognitive ?? 80;
        $motoric = $report->motoric ?? 85;
        $social = $report->social ?? 90;
        $language = $report->language ?? 88;
        $note = $report->note ?? 'Perkembangan anak secara keseluruhan sangat baik. Menunjukkan peningkatan di aspek kognitif dan bahasa. Perlu sedikit bimbingan tambahan di aspek motorik halus.';
        $weekStart = $report->week_start ?? now()->startOfWeek()->format('d M Y');
        $weekEnd = $report->week_start ? \Carbon\Carbon::parse($report->week_start)->endOfWeek()->format('d M Y') : now()->endOfWeek()->format('d M Y');
        $studentName = $student->name ?? 'Ahmad Fauzi';
        $teacherName = $teacher->name ?? 'Bu Siti';
    @endphp

    <div class="detail-card">
        <div class="detail-card__header">
            <div class="detail-card__title">Laporan Perkembangan Mingguan</div>
            <div class="detail-card__info">
                <p>Siswa: {{ $studentName }}</p>
                <p>Periode: {{ $weekStart }} - {{ $weekEnd }}</p>
                <p>Guru: {{ $teacherName }}</p>
            </div>
        </div>
        <div class="detail-card__body">
            <div class="aspect-grid">
                <div class="aspect-item">
                    <div class="aspect-item__label">Kognitif</div>
                    <div class="aspect-item__score">{{ $cognitive }}</div>
                    <div class="aspect-item__bar">
                        <div class="aspect-item__bar-fill" style="width: {{ $cognitive }}%"></div>
                    </div>
                </div>
                <div class="aspect-item">
                    <div class="aspect-item__label">Motorik</div>
                    <div class="aspect-item__score">{{ $motoric }}</div>
                    <div class="aspect-item__bar">
                        <div class="aspect-item__bar-fill" style="width: {{ $motoric }}%"></div>
                    </div>
                </div>
                <div class="aspect-item">
                    <div class="aspect-item__label">Sosial</div>
                    <div class="aspect-item__score">{{ $social }}</div>
                    <div class="aspect-item__bar">
                        <div class="aspect-item__bar-fill" style="width: {{ $social }}%"></div>
                    </div>
                </div>
                <div class="aspect-item">
                    <div class="aspect-item__label">Bahasa</div>
                    <div class="aspect-item__score">{{ $language }}</div>
                    <div class="aspect-item__bar">
                        <div class="aspect-item__bar-fill" style="width: {{ $language }}%"></div>
                    </div>
                </div>
            </div>

            <div class="note-section">
                <div class="note-section__label">Catatan Guru</div>
                <div class="note-section__text">{{ $note }}</div>
            </div>
        </div>
    </div>

@endsection
