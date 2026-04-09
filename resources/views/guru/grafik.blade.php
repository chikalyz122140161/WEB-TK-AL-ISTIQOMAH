@extends('layouts.app')

@section('title', 'Grafik Perkembangan - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Grafik Perkembangan Siswa')

@push('styles')
<style>
    /* ── Filter ──────────────────────────────────────── */
    .filter-bar {
        background: #fff;
        border: 1px solid #3E272320;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 24px;
    }
    .filter-section__title {
        font-size: 14px;
        font-weight: 600;
        color: #3E2723;
        margin-bottom: 16px;
    }
    .filter-row {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
        align-items: flex-end;
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
        min-width: 180px;
        cursor: pointer;
        font-family: inherit;
    }
    .filter-group select:focus {
        outline: none;
        border-color: #4CAF82;
        box-shadow: 0 0 0 3px rgba(76,175,130,0.1);
    }
    .btn-filter {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
        color: #3E2723;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        border-radius: 6px;
        transition: all 0.3s;
        font-family: inherit;
    }
    .btn-filter:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(76,175,130,0.3);
    }
    .btn-filter svg { width: 16px; height: 16px; fill: currentColor; }

    /* Summary Cards */
    .summary-row {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 12px;
        margin-bottom: 24px;
    }
    @media (max-width: 1200px) { .summary-row { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 768px) { .summary-row { grid-template-columns: repeat(2, 1fr); } }
    .summary-card {
        background: #fff;
        border: 1px solid #3E272320;
        border-radius: 8px;
        padding: 16px;
        text-align: center;
    }
    .summary-card__icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px;
    }
    .summary-card__icon svg { width: 20px; height: 20px; fill: #fff; }
    .summary-card__icon--fisik    { background: #F06292; }
    .summary-card__icon--kognitif { background: #F59E0B; }
    .summary-card__icon--bahasa   { background: #10B981; }
    .summary-card__icon--sosial   { background: #4CAF82; }
    .summary-card__icon--agama    { background: #8B5CF6; }
    .summary-card__icon--seni     { background: #EC4899; }
    .summary-card__label {
        font-size: 11px;
        font-weight: 500;
        color: #5D4037;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }
    .summary-card__value {
        font-size: 24px;
        font-weight: 700;
        color: #3E2723;
    }
    .summary-card__desc {
        font-size: 11px;
        color: #5D4037;
        margin-top: 4px;
    }

    /* Chart Card */
    .chart-card {
        background: #fff;
        border: 1px solid #3E272320;
        border-radius: 8px;
        margin-bottom: 24px;
        overflow: hidden;
    }
    .chart-card__header {
        padding: 16px 20px;
        border-bottom: 1px solid #3E272310;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }
    .chart-card__title {
        font-size: 15px;
        font-weight: 600;
        color: #3E2723;
    }
    .chart-card__legend {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
    }
    .legend-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: #5D4037;
    }
    .legend-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }
    .legend-dot--fisik    { background: #F06292; }
    .legend-dot--kognitif { background: #F59E0B; }
    .legend-dot--bahasa   { background: #10B981; }
    .legend-dot--sosial   { background: #4CAF82; }
    .legend-dot--agama    { background: #8B5CF6; }
    .legend-dot--seni     { background: #EC4899; }
    .chart-card__body {
        padding: 20px;
        min-height: 320px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .chart-card__body canvas { width: 100% !important; }

    /* Keterangan Skala */
    .skala-card {
        background: #fff;
        border: 1px solid #3E272320;
        border-radius: 8px;
        padding: 16px 20px;
        margin-bottom: 24px;
    }
    .skala-card__title {
        font-size: 13px;
        font-weight: 600;
        color: #3E2723;
        margin-bottom: 12px;
    }
    .skala-list {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    .skala-item {
        display: flex;
        align-items: center;
        gap: 6px;
        background: #f0fdf4;
        border: 1px solid #3E272315;
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 12px;
        color: #3E2723;
    }
    .skala-item strong {
        color: #3E2723;
        font-weight: 700;
        font-size: 14px;
    }

        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }
    .filter-bar label {
        font-size: 13px;
        font-weight: 600;
        color: #3E2723;
        white-space: nowrap;
    }
    .filter-bar select {
        height: 38px;
        padding: 0 32px 0 12px;
        font-size: 13px;
        color: #3E2723;
        background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%236B7280'%3E%3Cpath fill-rule='evenodd' d='M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z' clip-rule='evenodd'/%3E%3C/svg%3E") no-repeat right 8px center;
        background-size: 18px;
        border: 1px solid #3E272330;
        border-radius: 8px;
        outline: none;
        -webkit-appearance: none;
        appearance: none;
        cursor: pointer;
        font-family: inherit;
        min-width: 160px;
        transition: border-color .15s;
    }
    .filter-bar select:focus { border-color: #4CAF82; box-shadow: 0 0 0 3px rgba(76,175,130,.15); }

    /* ── Chart card ──────────────────────────────────── */
    .chart-card {
        background: #fff;
        border: 1px solid #3E272320;
        border-radius: 12px;
        padding: 20px 24px 16px;
        margin-bottom: 24px;
    }
    .chart-card__top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 16px;
    }
    .chart-card__heading {
        font-size: 15px;
        font-weight: 700;
        color: #3E2723;
    }
    .chart-legend {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
    }
    .chart-legend__item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: #3E2723;
    }
    .chart-legend__dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }
    .chart-wrapper { position: relative; }
    .chart-wrapper--line  { height: 320px; }
    .chart-wrapper--radar { height: 320px; max-width: 520px; margin: 0 auto; }

    /* ── Skala ───────────────────────────────────────── */
    .skala-card {
        background: #fff;
        border: 1px solid #3E272320;
        border-radius: 12px;
        padding: 16px 20px;
    }
    .skala-card__title {
        font-size: 13px;
        font-weight: 700;
        color: #3E2723;
        text-transform: uppercase;
        letter-spacing: .4px;
        margin-bottom: 12px;
    }
    .skala-list {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    .skala-item {
        display: flex;
        align-items: center;
        gap: 6px;
        background: #FFFDE7;
        border: 1px solid #3E272320;
        border-radius: 6px;
        padding: 5px 12px;
        font-size: 12px;
        color: #3E2723;
    }
    .skala-item strong { font-weight: 700; color: #3E2723; font-size: 13px; }
</style>
@endpush

{{-- SIDEBAR --}}
@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

{{-- CONTENT --}}
@section('content')

    {{-- Filter bar --}}
    <div class="filter-bar">
        <label for="selectSiswa">Pilih Siswa:</label>
        <select id="selectSiswa">
            @foreach ($daftarSiswa as $s)
                <option value="{{ $s['id'] }}" {{ $s['id'] == ($siswaAktif['id'] ?? 0) ? 'selected' : '' }}>{{ $s['nama'] }}</option>
            @endforeach
        </select>
        <label for="selectTahunAjaran">Tahun Ajaran:</label>
        <select id="selectTahunAjaran">
            <option value="2025/2026" selected>2025/2026</option>
            <option value="2024/2025">2024/2025</option>
        </select>
        <label for="selectSemester">Semester:</label>
        <select id="selectSemester">
            <option value="Ganjil">Ganjil</option>
            <option value="Genap">Genap</option>
        </select>
    </div>

    {{-- Line Chart --}}
    <div class="chart-card">
        <div class="chart-card__top">
            <span class="chart-card__heading" id="lineChartTitle">Grafik Perkembangan Satu Semester</span>
            <div class="chart-legend">
                <div class="chart-legend__item"><div class="chart-legend__dot" style="background:#F06292"></div>Fisik</div>
                <div class="chart-legend__item"><div class="chart-legend__dot" style="background:#F59E0B"></div>Kognitif</div>
                <div class="chart-legend__item"><div class="chart-legend__dot" style="background:#10B981"></div>Bahasa</div>
                <div class="chart-legend__item"><div class="chart-legend__dot" style="background:#4CAF82"></div>Sosial</div>
                <div class="chart-legend__item"><div class="chart-legend__dot" style="background:#8B5CF6"></div>Agama</div>
                <div class="chart-legend__item"><div class="chart-legend__dot" style="background:#EC4899"></div>Seni</div>
            </div>
        </div>
        <div class="chart-wrapper chart-wrapper--line">
            <canvas id="lineChart"></canvas>
        </div>
    </div>

    {{-- Radar Chart --}}
    <div class="chart-card">
        <div class="chart-card__top">
            <span class="chart-card__heading">Profil Perkembangan (Rata-rata)</span>
        </div>
        <div class="chart-wrapper chart-wrapper--radar">
            <canvas id="radarChart"></canvas>
        </div>
    </div>

    {{-- Keterangan Skala --}}
    <div class="skala-card">
        <div class="skala-card__title">Keterangan Skala Penilaian</div>
        <div class="skala-list">
            <div class="skala-item"><strong>BB</strong> = Belum Berkembang</div>
            <div class="skala-item"><strong>MB</strong> = Mulai Berkembang</div>
            <div class="skala-item"><strong>BSH</strong> = Berkembang Sesuai Harapan</div>
            <div class="skala-item"><strong>BSB</strong> = Berkembang Sangat Baik</div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const dataSiswa  = @json($daftarSiswa);
    const dataNilai  = @json($nilaiPerSiswa);  // { siswa_id: { minggu: { aspek: nilai } } }
    const dataMinggu = @json($daftarMinggu);   // [1,2,...,12]

    const aspekKeys   = ['fisik_motorik','kognitif','bahasa','sosial_emosional','nilai_agama_moral','seni'];
    const aspekLabels = ['Fisik-Motorik','Kognitif','Bahasa','Sosial-Emosional','Agama & Moral','Seni'];
    const aspekShort  = ['Fisik','Kognitif','Bahasa','Sosial','Agama','Seni'];
    const aspekColors = ['#F06292','#F59E0B','#10B981','#4CAF82','#8B5CF6','#EC4899'];
    const skalaLabels = { 1: 'BB', 2: 'MB', 3: 'BSH', 4: 'BSB' };

    // Ambil series data per aspek untuk satu siswa (semua minggu)
    function buildLineDatasets(siswaId) {
        const nilaiSiswa = dataNilai[siswaId] || {};
        return aspekKeys.map((key, i) => ({
            label: aspekShort[i],
            data: dataMinggu.map(m => (nilaiSiswa[m] || {})[key] ?? null),
            borderColor:           aspekColors[i],
            backgroundColor:       aspekColors[i] + '22',
            pointBackgroundColor:  aspekColors[i],
            pointBorderColor:      '#fff',
            pointRadius: 5,
            pointHoverRadius: 7,
            borderWidth: 2.5,
            tension: 0.4,
            fill: false,
            spanGaps: true,
        }));
    }

    // Rata-rata setiap aspek untuk satu siswa (semua minggu)
    function buildRadarData(siswaId) {
        const nilaiSiswa = dataNilai[siswaId] || {};
        return aspekKeys.map(key => {
            const vals = dataMinggu.map(m => (nilaiSiswa[m] || {})[key]).filter(v => v != null);
            if (!vals.length) return 0;
            return parseFloat((vals.reduce((a, b) => a + b, 0) / vals.length).toFixed(2));
        });
    }

    function getSiswaId() { return document.getElementById('selectSiswa').value; }
    function getSiswaName() {
        const siswa = dataSiswa.find(s => String(s.id) === String(getSiswaId()));
        return siswa ? siswa.nama : '-';
    }

    // ── Line Chart ──────────────────────────────────────
    const lineCtx = document.getElementById('lineChart').getContext('2d');
    const lineChart = new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: dataMinggu.map(m => 'Bulan ' + m),
            datasets: buildLineDatasets(getSiswaId()),
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: item => ' ' + item.dataset.label + ': ' + (skalaLabels[Math.round(item.raw)] || item.raw)
                    }
                }
            },
            scales: {
                y: {
                    min: 1, max: 4,
                    ticks: {
                        stepSize: 1,
                        color: '#5D4037',
                        font: { size: 12 },
                        callback: val => skalaLabels[val] || val,
                    },
                    grid:  { color: '#FFFDE7' },
                    border: { color: '#3E272320' },
                },
                x: {
                    ticks: { color: '#5D4037', font: { size: 12 } },
                    grid:  { display: false },
                    border: { color: '#3E272320' },
                }
            }
        }
    });

    // ── Radar Chart ─────────────────────────────────────
    const radarCtx = document.getElementById('radarChart').getContext('2d');
    const radarChart = new Chart(radarCtx, {
        type: 'radar',
        data: {
            labels: aspekLabels,
            datasets: [{
                label: 'Rata-rata',
                data: buildRadarData(getSiswaId()),
                fill: true,
                backgroundColor: 'rgba(76,175,130,0.15)',
                borderColor: '#4CAF82',
                pointBackgroundColor: '#4CAF82',
                pointBorderColor: '#fff',
                pointRadius: 5,
                borderWidth: 2.5,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                r: {
                    min: 1, max: 4,
                    ticks: {
                        stepSize: 1,
                        color: '#5D4037',
                        backdropColor: 'transparent',
                        callback: val => skalaLabels[val] || val,
                    },
                    grid: { color: '#3E272320' },
                    angleLines: { color: '#3E272320' },
                    pointLabels: { color: '#3E2723', font: { size: 12, weight: '600' } },
                }
            },
            plugins: {
                legend: { display: true, position: 'top', labels: { font: { size:12 }, color:'#3E2723', boxWidth:16 } }
            }
        }
    });

    // ── Update saat ganti siswa ──────────────────────────
    function updateCharts() {
        const id = getSiswaId();
        // line
        lineChart.data.datasets = buildLineDatasets(id);
        lineChart.update();
        // radar
        radarChart.data.datasets[0].data = buildRadarData(id);
        radarChart.update();
    }

    document.getElementById('selectSiswa').addEventListener('change', updateCharts);
</script>
@endpush
