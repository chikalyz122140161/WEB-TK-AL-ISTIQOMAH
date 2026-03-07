@extends('layouts.app')

@section('title', 'Lihat Laporan Anak - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Lihat Laporan Anak')

@section('sidebar')
    @include('orangtua.partials.sidebar')
@endsection

@push('styles')
<style>
    .filter-bar {
        display: flex;
        align-items: flex-end;
        gap: 12px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }
    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .filter-group label {
        font-size: 12px;
        font-weight: 500;
        color: #475d5b;
    }
    .filter-group select {
        padding: 10px 14px;
        border: 1px solid #00473e30;
        border-radius: 6px;
        font-size: 14px;
        color: #00473e;
        background: #fff;
        min-width: 160px;
        cursor: pointer;
    }
    .filter-group select:focus {
        outline: none;
        border-color: #faae2b;
        box-shadow: 0 0 0 3px rgba(250, 174, 43, 0.1);
    }
    .btn-tampilkan {
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
        border-radius: 6px;
        transition: all 0.3s;
    }
    .btn-tampilkan:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(250, 174, 43, 0.3);
    }

    /* Laporan List */
    .laporan-section {
        background: #fff;
        border: 1px solid #00473e20;
        border-radius: 8px;
        overflow: hidden;
    }
    .laporan-section__header {
        padding: 16px 20px;
        border-bottom: 1px solid #00473e10;
        font-size: 14px;
        font-weight: 600;
        color: #00473e;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    .data-table th,
    .data-table td {
        padding: 12px 16px;
        text-align: left;
        border-bottom: 1px solid #00473e10;
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
    .btn-detail {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, #faae2b 0%, #f5a623 100%);
        color: #00473e;
        padding: 6px 14px;
        font-size: 12px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-detail:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(250, 174, 43, 0.3);
    }
    .btn-detail svg {
        width: 14px;
        height: 14px;
        fill: currentColor;
    }
    .score-bar {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .score-bar__track {
        flex: 1;
        height: 8px;
        background: #f2f7f5;
        border-radius: 4px;
        overflow: hidden;
        max-width: 80px;
    }
    .score-bar__fill {
        height: 100%;
        border-radius: 4px;
        background: linear-gradient(135deg, #faae2b 0%, #f5a623 100%);
    }
    .score-bar__value {
        font-size: 13px;
        font-weight: 600;
        color: #00473e;
        min-width: 24px;
    }
    .empty-state {
        text-align: center;
        padding: 40px;
        color: #475d5b;
        font-size: 14px;
    }

    /* Detail Modal / Card */
    .detail-card {
        background: #fff;
        border: 1px solid #00473e20;
        border-radius: 8px;
        padding: 24px;
        margin-top: 24px;
    }
    .detail-card__header {
        background: linear-gradient(135deg, #00473e 0%, #006b5a 100%);
        color: #fff;
        padding: 20px 24px;
        border-radius: 8px 8px 0 0;
        margin: -24px -24px 24px;
    }
    .detail-card__title {
        font-size: 18px;
        font-weight: 700;
        margin: 0 0 4px;
    }
    .detail-card__subtitle {
        font-size: 13px;
        opacity: 0.85;
    }
    .aspect-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-bottom: 20px;
    }
    @media (max-width: 768px) {
        .aspect-grid { grid-template-columns: 1fr; }
    }
    .aspect-item {
        background: #f2f7f5;
        border-radius: 8px;
        padding: 16px;
    }
    .aspect-item__label {
        font-size: 12px;
        font-weight: 600;
        color: #475d5b;
        text-transform: uppercase;
        margin-bottom: 8px;
    }
    .aspect-item__score {
        font-size: 28px;
        font-weight: 700;
        color: #00473e;
    }
    .aspect-item__bar {
        margin-top: 8px;
        height: 6px;
        background: #00473e20;
        border-radius: 3px;
        overflow: hidden;
    }
    .aspect-item__bar-fill {
        height: 100%;
        border-radius: 3px;
        background: linear-gradient(135deg, #faae2b 0%, #f5a623 100%);
    }
    .note-section {
        background: #f2f7f5;
        border-radius: 8px;
        padding: 16px;
    }
    .note-section__label {
        font-size: 12px;
        font-weight: 600;
        color: #475d5b;
        text-transform: uppercase;
        margin-bottom: 8px;
    }
    .note-section__text {
        font-size: 14px;
        color: #00473e;
        line-height: 1.6;
    }
</style>
@endpush

@section('content')

    {{-- Filter --}}
    <form action="{{ route('orangtua.laporan') }}" method="GET" class="filter-bar">
        <div class="filter-group">
            <label>Pilih Bulan</label>
            <select name="bulan">
                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ (request('bulan', now()->month) == $m) ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>
        </div>
        <div class="filter-group">
            <label>Pilih Tahun</label>
            <select name="tahun">
                @for ($y = now()->year; $y >= now()->year - 2; $y--)
                    <option value="{{ $y }}" {{ (request('tahun', now()->year) == $y) ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <button type="submit" class="btn-tampilkan">TAMPILKAN</button>
    </form>

    {{-- Laporan List --}}
    <div class="laporan-section">
        <div class="laporan-section__header">
            LIST LAPORAN PERKEMBANGAN | {{ $student->name ?? 'Ahmad Fauzi' }}
        </div>
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Minggu</th>
                        <th>Kognitif</th>
                        <th>Motorik</th>
                        <th>Sosial</th>
                        <th>Bahasa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($laporanList ?? [
                        ['id' => 1, 'minggu' => 'Minggu 1 (01-07 Mar 2026)', 'kognitif' => 80, 'motorik' => 85, 'sosial' => 90, 'bahasa' => 88],
                        ['id' => 2, 'minggu' => 'Minggu 2 (08-14 Mar 2026)', 'kognitif' => 82, 'motorik' => 87, 'sosial' => 88, 'bahasa' => 90],
                    ] as $index => $laporan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $laporan['minggu'] }}</td>
                            <td>
                                <div class="score-bar">
                                    <div class="score-bar__track"><div class="score-bar__fill" style="width: {{ $laporan['kognitif'] }}%"></div></div>
                                    <span class="score-bar__value">{{ $laporan['kognitif'] }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="score-bar">
                                    <div class="score-bar__track"><div class="score-bar__fill" style="width: {{ $laporan['motorik'] }}%"></div></div>
                                    <span class="score-bar__value">{{ $laporan['motorik'] }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="score-bar">
                                    <div class="score-bar__track"><div class="score-bar__fill" style="width: {{ $laporan['sosial'] }}%"></div></div>
                                    <span class="score-bar__value">{{ $laporan['sosial'] }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="score-bar">
                                    <div class="score-bar__track"><div class="score-bar__fill" style="width: {{ $laporan['bahasa'] }}%"></div></div>
                                    <span class="score-bar__value">{{ $laporan['bahasa'] }}</span>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('orangtua.laporan.detail', $laporan['id'] ?? 1) }}" class="btn-detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/><path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd"/></svg>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state">Belum ada laporan perkembangan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
