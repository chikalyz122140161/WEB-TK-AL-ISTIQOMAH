@extends('layouts.app')

@section('title', 'Grafik Perkembangan - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Grafik Perkembangan Siswa')

@push('styles')
<style>
    /* ── Filter card ─────────────────────────────────── */
    .filter-card {
        background: #fff;
        border: 1px solid #E5E7EB;
        border-radius: 10px;
        padding: 16px 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }
    .filter-card__label {
        font-size: 13px;
        font-weight: 700;
        color: #374151;
        text-transform: uppercase;
        letter-spacing: .4px;
        white-space: nowrap;
    }
    .filter-select {
        height: 38px;
        padding: 0 32px 0 12px;
        font-size: 13px;
        color: #111827;
        background: #F9FAFB url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%236B7280'%3E%3Cpath fill-rule='evenodd' d='M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z' clip-rule='evenodd'/%3E%3C/svg%3E") no-repeat right 8px center;
        background-size: 18px;
        border: 1px solid #D1D5DB;
        border-radius: 8px;
        outline: none;
        appearance: none;
        cursor: pointer;
        font-family: inherit;
        min-width: 160px;
        transition: border-color .15s;
    }
    .filter-select:focus { border-color: #fb923c; box-shadow: 0 0 0 3px rgba(251,146,60,.15); }

    /* ── Chart card ──────────────────────────────────── */
    .chart-card {
        background: #fff;
        border: 1px solid #E5E7EB;
        border-radius: 10px;
        padding: 24px 24px 20px;
        margin-bottom: 20px;
    }
    .chart-card__title {
        text-align: center;
        font-size: 14px;
        font-weight: 700;
        color: #c2410c;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin: 0 0 24px;
    }
    .chart-wrapper {
        position: relative;
        height: 300px;
    }

    /* ── Legend card ─────────────────────────────────── */
    .legend-card {
        background: #fff;
        border: 1px solid #E5E7EB;
        border-radius: 10px;
        padding: 18px 20px;
    }
    .legend-card__title {
        font-size: 12px;
        font-weight: 700;
        color: #374151;
        text-transform: uppercase;
        letter-spacing: .4px;
        margin: 0 0 10px;
    }
    .legend-card__list {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .legend-card__list li {
        font-size: 13px;
        color: #4B5563;
    }
    .legend-card__list li strong {
        color: #c2410c;
        font-weight: 700;
    }
</style>
@endpush

{{-- SIDEBAR --}}
@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

{{-- CONTENT --}}
@section('content')

    {{-- Title --}}
    <h2 style="margin:0 0 20px;font-size:20px;font-weight:700;color:#111827;text-transform:uppercase;letter-spacing:.5px;">
        Grafik Perkembangan Siswa
    </h2>

    {{-- Filter --}}
    <div class="filter-card">
        <span class="filter-card__label">Pilih Siswa:</span>
        <select class="filter-select" id="selectSiswa">
            @foreach ($daftarSiswa as $s)
                <option value="{{ $s['id'] }}" {{ $s['id'] == ($siswaAktif['id'] ?? 0) ? 'selected' : '' }}>
                    {{ $s['nama'] }}
                </option>
            @endforeach
        </select>
        <select class="filter-select" id="selectMinggu">
            @foreach ($daftarMinggu as $m)
                <option value="{{ $m }}" {{ $m == ($mingguAktif ?? 0) ? 'selected' : '' }}>
                    Minggu {{ $m }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Chart card --}}
    <div class="chart-card">
        <div class="chart-card__title" id="chartTitle">
            Grafik Perkembangan &mdash; {{ $siswaAktif['nama'] ?? '-' }} (Minggu {{ $mingguAktif ?? '-' }})
        </div>
        <div class="chart-wrapper">
            <canvas id="grafikChart"></canvas>
        </div>
    </div>

    {{-- Legend --}}
    <div class="legend-card">
        <p class="legend-card__title">Keterangan Skala:</p>
        <ul class="legend-card__list">
            <li><strong>1</strong> = Belum Berkembang</li>
            <li><strong>2</strong> = Mulai Berkembang</li>
            <li><strong>3</strong> = Berkembang Sesuai Harapan</li>
            <li><strong>4</strong> = Berkembang Sangat Baik</li>
            <li><strong>5</strong> = Sangat Memuaskan</li>
        </ul>
    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Data dari controller (PHP → JSON)
    const dataSiswa  = @json($daftarSiswa);
    const dataNilai  = @json($nilaiPerSiswa);   // { siswa_id: { minggu: { aspek: nilai } } }
    const dataMinggu = @json($daftarMinggu);

    const aspekLabels = ['FISIK-\nMOTORIK', 'KOGNITIF', 'BAHASA', 'SOSIAL-\nEMOSIONAL', 'AGAMA &\nMORAL', 'SENI'];
    const aspekKeys   = ['fisik_motorik', 'kognitif', 'bahasa', 'sosial_emosional', 'nilai_agama_moral', 'seni'];

    // Chart init
    const ctx = document.getElementById('grafikChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: aspekLabels,
            datasets: [{
                label: 'Nilai',
                data: getValues(),
                backgroundColor: 'rgba(249,115,22,0.72)',
                borderColor:     '#ea580c',
                borderWidth: 1.5,
                borderRadius: 4,
                barPercentage: 0.55,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        title: (items) => aspekKeys[items[0].dataIndex].replace(/_/g,' ').toUpperCase(),
                        label: (item) => ' Nilai: ' + item.raw
                    }
                },
                datalabels: { display: false }
            },
            scales: {
                y: {
                    min: 0, max: 5,
                    ticks: { stepSize: 1, font: { size: 12 }, color: '#6B7280' },
                    grid:  { color: '#F3F4F6' },
                    border: { color: '#E5E7EB' }
                },
                x: {
                    ticks: { font: { size: 11 }, color: '#374151' },
                    grid:  { display: false },
                    border: { color: '#E5E7EB' }
                }
            }
        },
        plugins: [{
            // Show value labels on top of each bar
            id: 'topLabels',
            afterDatasetsDraw(chart) {
                const { ctx, data, scales: { x, y } } = chart;
                ctx.save();
                ctx.font = 'bold 13px Inter, sans-serif';
                ctx.fillStyle = '#111827';
                ctx.textAlign = 'center';
                data.datasets[0].data.forEach((val, i) => {
                    const bar = chart.getDatasetMeta(0).data[i];
                    const bx  = bar.x;
                    const by  = y.getPixelForValue(val) - 8;
                    ctx.fillText(val, bx, by);
                });
                ctx.restore();
            }
        }]
    });

    function getValues() {
        const siswaId = document.getElementById('selectSiswa').value;
        const minggu  = document.getElementById('selectMinggu').value;
        const record  = (dataNilai[siswaId] || {})[minggu] || {};
        return aspekKeys.map(k => record[k] ?? 0);
    }

    function getSiswaName() {
        const siswaId = document.getElementById('selectSiswa').value;
        const siswa   = dataSiswa.find(s => String(s.id) === String(siswaId));
        return siswa ? siswa.nama : '-';
    }

    function updateChart() {
        const minggu = document.getElementById('selectMinggu').value;
        chart.data.datasets[0].data = getValues();
        chart.update();
        document.getElementById('chartTitle').innerHTML =
            'Grafik Perkembangan &mdash; ' + getSiswaName() + ' (Minggu ' + minggu + ')';
    }

    document.getElementById('selectSiswa').addEventListener('change', updateChart);
    document.getElementById('selectMinggu').addEventListener('change', updateChart);
</script>
@endpush
