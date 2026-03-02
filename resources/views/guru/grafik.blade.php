@extends('layouts.app')

@section('title', 'Grafik Perkembangan - SISTEM BK TK AL-ISTIQOMAH')
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
    .filter-select:focus { border-color: #63E6BE; box-shadow: 0 0 0 3px rgba(99,230,190,.15); }

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
        color: #065F46;
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
        color: #065F46;
        font-weight: 700;
    }
</style>
@endpush

{{-- SIDEBAR --}}
@section('sidebar')
    <a href="{{ route('guru.dashboard') }}" class="sidebar__item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z"/><path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15.75a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-4.5a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z"/></svg>
        Dashboard
    </a>

    <div class="sidebar__divider"></div>
    <span class="sidebar__label">Administrasi</span>

    <a href="#" class="sidebar__item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z"/><path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z"/></svg>
        Form Catat Kehadiran
    </a>
    <a href="#" class="sidebar__item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z" clip-rule="evenodd"/></svg>
        List Kehadiran
    </a>
    <a href="#" class="sidebar__item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd"/><path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z"/></svg>
        Form Generate Laporan
    </a>
    <a href="#" class="sidebar__item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.625 16.5a1.875 1.875 0 1 0 0-3.75 1.875 1.875 0 0 0 0 3.75Z"/><path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875Zm6 16.5a3.375 3.375 0 1 0 0-6.75 3.375 3.375 0 0 0 0 6.75Z" clip-rule="evenodd"/><path d="M16.875 6.375a3.75 3.75 0 0 0-.437-1.745 4.5 4.5 0 0 1 2.813 4.12v.163l-1.688-1.55a1.875 1.875 0 0 1-.688-1.988Z"/></svg>
        List Laporan
    </a>
    <a href="#" class="sidebar__item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd"/></svg>
        List Jadwal
    </a>
    <a href="#" class="sidebar__item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z"/></svg>
        Form Tambah Jadwal
    </a>

    <div class="sidebar__divider"></div>
    <span class="sidebar__label">Bimbingan Konseling</span>

    <a href="{{ route('guru.input_perkembangan') }}" class="sidebar__item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z"/><path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z"/></svg>
        Input Perkembangan
    </a>
    <a href="{{ route('guru.grafik') }}" class="sidebar__item active">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75ZM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 0 1-1.875-1.875V8.625ZM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 0 1 3 19.875v-6.75Z"/></svg>
        Grafik
    </a>
    <a href="#" class="sidebar__item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd"/><path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z"/></svg>
        Laporan Perkembangan
    </a>
    <a href="#" class="sidebar__item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M4.804 21.644A6.707 6.707 0 0 0 6 21.75a6.721 6.721 0 0 0 3.583-1.029c.774.182 1.584.279 2.417.279 5.322 0 9.75-3.97 9.75-9 0-5.03-4.428-9-9.75-9s-9.75 3.97-9.75 9c0 2.09.768 4.04 2.084 5.558a8.96 8.96 0 0 1-1.603 2.596.75.75 0 0 0 .53 1.28 6.72 6.72 0 0 0 1.543-.09Z" clip-rule="evenodd"/></svg>
        Chat
    </a>
    <a href="#" class="sidebar__item">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd"/></svg>
        Jadwal Konseling
    </a>
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
                backgroundColor: 'rgba(6,95,70,0.72)',
                borderColor:     '#065F46',
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
