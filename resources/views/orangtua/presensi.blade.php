@extends('layouts.app')
@php $userRole = 'Orang Tua'; @endphp

@section('title', 'Lihat Presensi Anak - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Lihat Presensi Anak')

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
        color: #5D4037;
    }
    .filter-group select {
        padding: 10px 14px;
        border: 1px solid #3E272330;
        border-radius: 6px;
        font-size: 14px;
        color: #3E2723;
        background: #fff;
        min-width: 160px;
        cursor: pointer;
    }
    .filter-group select:focus {
        outline: none;
        border-color: #4CAF82;
        box-shadow: 0 0 0 3px rgba(76, 175, 130, 0.1);
    }
    .btn-tampilkan {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #3D9B72 0%, #2E8B60 100%);
        color: #fff;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(61,155,114,0.25);
        transition: all 0.2s;
    }
    .btn-tampilkan:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(76,175,130, 0.3);
    }

    /* Stat Cards */
    .stat-row-5 {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    @media (max-width: 1024px) {
        .stat-row-5 { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 768px) {
        .stat-row-5 { grid-template-columns: repeat(2, 1fr); }
    }
    .presensi-stat {
        background: #fff;
        border: 1px solid #3E272320;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
    }
    .presensi-stat__value {
        font-size: 32px;
        font-weight: 700;
        color: #3E2723;
        line-height: 1;
    }
    .presensi-stat__value--green { color: #2E8B60; }
    .presensi-stat__value--amber { color: #5D4037; }
    .presensi-stat__value--blue { color: #2E8B60; }
    .presensi-stat__value--red { color: #d81b72; }
    .presensi-stat__value--teal { color: #3E2723; }
    .presensi-stat__label {
        font-size: 13px;
        color: #5D4037;
        margin-top: 6px;
    }

    /* Detail Section */
    .detail-section {
        background: #fff;
        border: 1px solid #3E272320;
        border-radius: 8px;
        overflow: hidden;
    }
    .detail-section__header {
        padding: 16px 20px;
        border-bottom: 1px solid #3E272310;
        font-size: 14px;
        font-weight: 600;
        color: #3E2723;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    .data-table th,
    .data-table td {
        padding: 12px 16px;
        text-align: left;
        border-bottom: 1px solid #3E272310;
    }
    .data-table th {
        background: linear-gradient(135deg, #4CAF8220 0%, #4CAF8230 100%);
        font-size: 12px;
        font-weight: 600;
        color: #3E2723;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .data-table td {
        font-size: 14px;
        color: #5D4037;
    }
    .data-table tr:hover td {
        background: #FFFDE7;
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .status-badge--hadir {
        background: linear-gradient(135deg, #4CAF8230 0%, #4CAF8230 100%);
        color: #2E8B60;
    }
    .status-badge--izin {
        background: #FFF176;
        color: #5D4037;
    }
    .status-badge--sakit {
        background: linear-gradient(135deg, #4CAF8230 0%, #4CAF8230 100%);
        color: #2E8B60;
    }
    .status-badge--alpa {
        background: linear-gradient(135deg, #F0629220 0%, #F0629230 100%);
        color: #d81b72;
    }
    .empty-state {
        text-align: center;
        padding: 40px;
        color: #5D4037;
        font-size: 14px;
    }
    .not-connected-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 16px;
        padding: 80px 24px;
        text-align: center;
        color: #5D4037;
    }
    .not-connected-state svg {
        color: #3E272340;
    }
    .not-connected-state h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #3E2723;
        margin: 0;
    }
    .not-connected-state p {
        font-size: 0.9rem;
        margin: 0;
        line-height: 1.6;
        color: #795548;
    }
</style>
@endpush

@section('content')

@if(is_null($student['id']))
    <div class="not-connected-state">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="56" height="56"><path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd"/></svg>
        <h3>Tidak Terhubung dengan Siswa</h3>
        <p>Akun Anda belum terhubung dengan data siswa manapun.<br>Silakan hubungi administrator sekolah untuk menghubungkan akun Anda.</p>
    </div>
@else

    {{-- Filter --}}
    <form action="{{ route('orangtua.presensi') }}" method="GET" class="filter-bar">
        <div class="filter-group">
            <label>Pilih Class Term</label>
            <select name="class_term_id" id="selectClassTerm">
                @foreach ($classTerms as $ct)
                    <option value="{{ $ct['id'] }}"
                            data-bulan="{{ json_encode($ct['bulan_aktif']) }}"
                            {{ $classTermId === $ct['id'] ? 'selected' : '' }}>
                        {{ $ct['label'] }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="filter-group">
            <label>Pilih Bulan</label>
            <select name="bulan" id="selectBulan">
                @foreach ($activeCt['bulan_aktif'] as $m)
                    <option value="{{ $m }}" {{ (int)$bulan === (int)$m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn-tampilkan">TAMPILKAN</button>
    </form>

    {{-- Statistik Presensi --}}
    @php
        $hadir = $presensiData['hadir'] ?? 0;
        $izin  = $presensiData['izin']  ?? 0;
        $sakit = $presensiData['sakit'] ?? 0;
        $alpa  = $presensiData['alpa']  ?? 0;
        $total = $hadir + $izin + $sakit + $alpa;
        $persen = $total > 0 ? round(($hadir / $total) * 100) : 0;
    @endphp

    <div class="stat-row-5">
        <div class="presensi-stat">
            <div class="presensi-stat__value presensi-stat__value--green">{{ $hadir }}</div>
            <div class="presensi-stat__label">Hadir</div>
        </div>
        <div class="presensi-stat">
            <div class="presensi-stat__value presensi-stat__value--amber">{{ $izin }}</div>
            <div class="presensi-stat__label">Izin</div>
        </div>
        <div class="presensi-stat">
            <div class="presensi-stat__value presensi-stat__value--blue">{{ $sakit }}</div>
            <div class="presensi-stat__label">Sakit</div>
        </div>
        <div class="presensi-stat">
            <div class="presensi-stat__value presensi-stat__value--red">{{ $alpa }}</div>
            <div class="presensi-stat__label">Alpa</div>
        </div>
        <div class="presensi-stat">
            <div class="presensi-stat__value presensi-stat__value--teal">{{ $persen }}%</div>
            <div class="presensi-stat__label">% Hadir</div>
        </div>
    </div>

    {{-- Detail Kehadiran --}}
    <div class="detail-section">
        <div class="detail-section__header">
            DETAIL KEHADIRAN – {{ $namaBulan }} {{ $tahun }}
            <span style="color:#5D4037;font-weight:500;font-size:12px;margin-left:6px;">
                ({{ $activeCt['label'] }})
            </span>
            | {{ $student['nama'] ?? 'Ahmad Fauzi' }}
        </div>
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Hari</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($detailPresensi ?? [
                        ['tanggal' => '01 Mar 2026', 'hari' => "Jum'at", 'status' => 'hadir', 'keterangan' => '-'],
                        ['tanggal' => '04 Mar 2026', 'hari' => 'Senin', 'status' => 'hadir', 'keterangan' => '-'],
                        ['tanggal' => '05 Mar 2026', 'hari' => 'Selasa', 'status' => 'sakit', 'keterangan' => 'Demam'],
                        ['tanggal' => '06 Mar 2026', 'hari' => 'Rabu', 'status' => 'hadir', 'keterangan' => '-'],
                    ] as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item['tanggal'] }}</td>
                            <td>{{ $item['hari'] }}</td>
                            <td>
                                <span class="status-badge status-badge--{{ strtolower($item['status']) }}">
                                    {{ strtoupper($item['status']) }}
                                </span>
                            </td>
                            <td>{{ $item['keterangan'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state">Belum ada data presensi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Filter bulan otomatis ter-update saat class_term diubah
        (function () {
            var BULAN_NAMA = ['', 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
            var ctSel    = document.getElementById('selectClassTerm');
            var bulanSel = document.getElementById('selectBulan');
            if (!ctSel || !bulanSel) return;

            ctSel.addEventListener('change', function () {
                var opt = ctSel.options[ctSel.selectedIndex];
                var bulanList = JSON.parse(opt.dataset.bulan || '[]');
                bulanSel.innerHTML = bulanList.map(function (m) {
                    return '<option value="' + m + '">' + BULAN_NAMA[m] + '</option>';
                }).join('');
            });
        })();
    </script>

@endif

@endsection
