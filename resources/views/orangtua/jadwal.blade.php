@extends('layouts.app')

@section('title', 'Lihat Jadwal Kegiatan - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Lihat Jadwal Kegiatan')

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

    /* Jadwal Section */
    .jadwal-section {
        background: #fff;
        border: 1px solid #00473e20;
        border-radius: 8px;
        overflow: hidden;
    }
    .jadwal-section__header {
        padding: 16px 20px;
        border-bottom: 1px solid #00473e10;
        font-size: 14px;
        font-weight: 600;
        color: #00473e;
        text-transform: uppercase;
    }
    .jadwal-list {
        padding: 0;
    }
    .jadwal-item {
        padding: 20px 24px;
        border-bottom: 1px solid #00473e10;
        transition: background 0.2s;
    }
    .jadwal-item:last-child {
        border-bottom: none;
    }
    .jadwal-item:hover {
        background: #f2f7f5;
    }
    .jadwal-item__title {
        font-size: 15px;
        font-weight: 700;
        color: #00473e;
        margin-bottom: 8px;
    }
    .jadwal-item__detail {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .jadwal-item__row {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #475d5b;
    }
    .jadwal-item__row svg {
        width: 16px;
        height: 16px;
        fill: #faae2b;
        flex-shrink: 0;
    }
    .empty-state {
        text-align: center;
        padding: 40px;
        color: #475d5b;
        font-size: 14px;
    }
</style>
@endpush

@section('content')

    {{-- Filter --}}
    <form action="{{ route('orangtua.jadwal') }}" method="GET" class="filter-bar">
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

    @php
        $bulan = request('bulan', now()->month);
        $tahun = request('tahun', now()->year);
        $namaBulan = \Carbon\Carbon::create()->month($bulan)->translatedFormat('F');
    @endphp

    {{-- Jadwal List --}}
    <div class="jadwal-section">
        <div class="jadwal-section__header">
            JADWAL KEGIATAN – {{ $namaBulan }} {{ $tahun }}
        </div>
        <div class="jadwal-list">
            @forelse ($jadwalList ?? [
                ['nama' => 'Upacara Bendera', 'tanggal' => 'Senin, 16 Mar 2026 | 07:00 - 09:00', 'tempat' => 'Tempat: Lapangan | Kelas: Semua Kelas'],
                ['nama' => 'Outing Class', 'tanggal' => 'Minggu, 21 Mar 2026 | 10:00 - 12:00', 'tempat' => 'Tempat: Kebun Binatang | Kelas: TK A'],
                ['nama' => 'Lomba Mewarnai', 'tanggal' => 'Kamis, 24 Mar 2026 | 09:00 - 11:00', 'tempat' => 'Tempat: Ruang Kelas A | Kelas: TK A, TK B'],
            ] as $jadwal)
                <div class="jadwal-item">
                    <div class="jadwal-item__title">{{ $jadwal['nama'] }}</div>
                    <div class="jadwal-item__detail">
                        <div class="jadwal-item__row">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.75 2a.75.75 0 0 1 .75.75V4h7V2.75a.75.75 0 0 1 1.5 0V4h.25A2.75 2.75 0 0 1 18 6.75v8.5A2.75 2.75 0 0 1 15.25 18H4.75A2.75 2.75 0 0 1 2 15.25v-8.5A2.75 2.75 0 0 1 4.75 4H5V2.75A.75.75 0 0 1 5.75 2Zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75Z" clip-rule="evenodd"/></svg>
                            {{ $jadwal['tanggal'] }}
                        </div>
                        <div class="jadwal-item__row">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 0 0 .281-.145c.164-.093.413-.237.658-.42.528-.394 1.065-.957 1.065-1.857v-4.756l4.928-2.464A1.5 1.5 0 0 0 18 7.856V6.145a1.5 1.5 0 0 0-1.99-1.418L12 6.31V3.5A1.5 1.5 0 0 0 10.5 2h-1A1.5 1.5 0 0 0 8 3.5v2.81l-4.01-1.583A1.5 1.5 0 0 0 2 6.145v1.711a1.5 1.5 0 0 0 .734 1.424L7.5 11.744V16.5c0 .9.537 1.463 1.065 1.857.245.183.494.327.658.42a5.738 5.738 0 0 0 .28.145l.019.009.006.003Z" clip-rule="evenodd"/></svg>
                            {{ $jadwal['tempat'] }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">Belum ada jadwal kegiatan untuk bulan ini.</div>
            @endforelse
        </div>
    </div>

@endsection
