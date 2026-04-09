@extends('layouts.app')
@php $userRole = 'Orang Tua'; @endphp

@section('title', 'Grafik Perkembangan - SISTEM BK TK AL-ISTIQOMAH')
@section('page_title', 'Grafik Perkembangan')

{{-- SIDEBAR --}}
@section('sidebar')
    @include('orangtua.partials.sidebar')
@endsection

{{-- CONTENT --}}
@section('content')

@push('styles')
<style>
    .grafik-container {
        max-width: 1000px;
    }

    /* Filter Section */
    .filter-section {
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
    }
    .filter-group select:focus {
        outline: none;
        border-color: #4CAF82;
        box-shadow: 0 0 0 3px rgba(76, 175, 130, 0.1);
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
    }
    .btn-filter:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(76,175,130, 0.3);
    }
    .btn-filter svg {
        width: 16px;
        height: 16px;
        fill: currentColor;
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
    }
    .chart-card__title {
        font-size: 16px;
        font-weight: 600;
        color: #3E2723;
    }
    .chart-card__legend {
        display: flex;
        gap: 16px;
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
    .legend-dot--fisik { background: #F06292; }
    .legend-dot--kognitif { background: #F59E0B; }
    .legend-dot--bahasa { background: #10B981; }
    .legend-dot--sosial { background: #4CAF82; }
    .legend-dot--agama { background: #8B5CF6; }
    .legend-dot--seni { background: #EC4899; }

    .chart-card__body {
        padding: 20px;
        min-height: 350px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Chart Container - Placeholder */
    .chart-placeholder {
        width: 100%;
        height: 300px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border: 2px dashed #3E272320;
        border-radius: 8px;
    }
    .chart-placeholder svg {
        width: 64px;
        height: 64px;
        fill: #4CAF82;
        margin-bottom: 16px;
    }
    .chart-placeholder p {
        font-size: 14px;
        color: #5D4037;
    }

    /* Summary Cards */
    .summary-row {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 12px;
        margin-bottom: 24px;
    }
    @media (max-width: 1200px) {
        .summary-row { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 768px) {
        .summary-row { grid-template-columns: repeat(2, 1fr); }
    }
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
    .summary-card__icon svg {
        width: 20px;
        height: 20px;
        fill: #fff;
    }
    .summary-card__icon--fisik { background: #F06292; }
    .summary-card__icon--kognitif { background: #F59E0B; }
    .summary-card__icon--bahasa { background: #10B981; }
    .summary-card__icon--sosial { background: #4CAF82; }
    .summary-card__icon--agama { background: #8B5CF6; }
    .summary-card__icon--seni { background: #EC4899; }

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
    .summary-card__trend {
        font-size: 12px;
        margin-top: 4px;
    }
    .summary-card__trend--up {
        color: #10B981;
    }
    .summary-card__trend--down {
        color: #F06292;
    }
    .summary-card__trend--neutral {
        color: #5D4037;
    }
</style>
@endpush

<div class="grafik-container">
    {{-- Filter Section --}}
    <div class="filter-section">
        <div class="filter-section__title">Filter Grafik</div>
        <div class="filter-row">
            <div class="filter-group">
                <label>Periode</label>
                <select id="filterPeriod">
                    <option value="1month">1 Bulan Terakhir</option>
                    <option value="3month" selected>3 Bulan Terakhir</option>
                    <option value="6month">6 Bulan Terakhir</option>
                    <option value="1year">1 Tahun</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Aspek</label>
                <select id="filterAspect">
                    <option value="all" selected>Semua Aspek</option>
                    <option value="fisik">Fisik-Motorik</option>
                    <option value="kognitif">Kognitif</option>
                    <option value="bahasa">Bahasa</option>
                    <option value="sosial">Sosial-Emosional</option>
                    <option value="agama">Nilai Agama & Moral</option>
                    <option value="seni">Seni</option>
                </select>
            </div>
            <button class="btn-filter" onclick="applyFilter()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M3.792 2.938A49.069 49.069 0 0 1 12 2.25c2.797 0 5.54.236 8.209.688a1.857 1.857 0 0 1 1.541 1.836v1.044a3 3 0 0 1-.879 2.121l-6.182 6.182a1.5 1.5 0 0 0-.439 1.061v2.927a3 3 0 0 1-1.658 2.684l-1.757.878A.75.75 0 0 1 9.75 21v-5.818a1.5 1.5 0 0 0-.44-1.06L3.13 7.938a3 3 0 0 1-.879-2.121V4.774c0-.897.64-1.683 1.542-1.836Z" clip-rule="evenodd"/></svg>
                Terapkan Filter
            </button>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="summary-row">
        <div class="summary-card">
            <div class="summary-card__icon summary-card__icon--fisik">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd"/></svg>
            </div>
            <div class="summary-card__label">Fisik-Motorik</div>
            <div class="summary-card__value">BSB</div>
            <div class="summary-card__trend summary-card__trend--up">↑ Meningkat</div>
        </div>
        <div class="summary-card">
            <div class="summary-card__icon summary-card__icon--kognitif">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002c-.114.06-.227.119-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 4.8 12.109a.75.75 0 0 1-.292-1.118A60.734 60.734 0 0 1 11.7 2.805Z"/><path d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286a48.4 48.4 0 0 1 7.666 3.282.75.75 0 0 1-.068 1.397 49.2 49.2 0 0 0-6.165 3.482c.134 1.11.282 2.212.447 3.304a.75.75 0 0 1-.318.689l-.001.001a.75.75 0 0 1-.869-.054c.022.165.043.33.066.495a.75.75 0 0 0 .803.642 48.15 48.15 0 0 0 7.666-3.282.75.75 0 0 1 .719 0 48.15 48.15 0 0 0 7.666 3.282.75.75 0 0 0 .803-.642c.023-.165.044-.33.066-.495a.75.75 0 0 1-.869.054h-.001a.75.75 0 0 1-.318-.689c.165-1.092.313-2.194.447-3.304a49.2 49.2 0 0 0-6.165-3.482.75.75 0 0 1-.068-1.397Z"/></svg>
            </div>
            <div class="summary-card__label">Kognitif</div>
            <div class="summary-card__value">BSB</div>
            <div class="summary-card__trend summary-card__trend--up">↑ Meningkat</div>
        </div>
        <div class="summary-card">
            <div class="summary-card__icon summary-card__icon--bahasa">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M4.804 21.644A6.707 6.707 0 0 0 6 21.75a6.721 6.721 0 0 0 3.583-1.029c.774.182 1.584.279 2.417.279 5.322 0 9.75-3.97 9.75-9 0-5.03-4.428-9-9.75-9s-9.75 3.97-9.75 9c0 2.09.768 4.04 2.084 5.558a8.96 8.96 0 0 1-1.603 2.596.75.75 0 0 0 .53 1.28 6.72 6.72 0 0 0 1.543-.09Z" clip-rule="evenodd"/></svg>
            </div>
            <div class="summary-card__label">Bahasa</div>
            <div class="summary-card__value">BSB</div>
            <div class="summary-card__trend summary-card__trend--up">↑ Meningkat</div>
        </div>
        <div class="summary-card">
            <div class="summary-card__icon summary-card__icon--sosial">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z"/><path d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z"/></svg>
            </div>
            <div class="summary-card__label">Sosial-Emosional</div>
            <div class="summary-card__value">BSH</div>
            <div class="summary-card__trend summary-card__trend--neutral">→ Stabil</div>
        </div>
        <div class="summary-card">
            <div class="summary-card__icon summary-card__icon--agama">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd"/></svg>
            </div>
            <div class="summary-card__label">Agama & Moral</div>
            <div class="summary-card__value">BSB</div>
            <div class="summary-card__trend summary-card__trend--up">↑ Meningkat</div>
        </div>
        <div class="summary-card">
            <div class="summary-card__icon summary-card__icon--seni">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M20.599 1.5c-.376 0-.743.111-1.055.32l-5.08 3.385a18.747 18.747 0 0 0-3.471 2.987 10.04 10.04 0 0 1 4.815 4.815 18.748 18.748 0 0 0 2.987-3.472l3.386-5.079A1.902 1.902 0 0 0 20.599 1.5Zm-8.3 14.025a18.76 18.76 0 0 0 1.896-1.207 8.026 8.026 0 0 0-4.513-4.513A18.75 18.75 0 0 0 8.475 11.7l-.278.5a5.26 5.26 0 0 1 3.601 3.602l.5-.278ZM6.75 13.5A3.75 3.75 0 0 0 3 17.25a1.5 1.5 0 0 1-1.601 1.497.75.75 0 0 0-.7 1.123 5.25 5.25 0 0 0 9.8-2.62 3.75 3.75 0 0 0-3.75-3.75Z" clip-rule="evenodd"/></svg>
            </div>
            <div class="summary-card__label">Seni</div>
            <div class="summary-card__value">BSB</div>
            <div class="summary-card__trend summary-card__trend--up">↑ Meningkat</div>
        </div>
    </div>

    {{-- Main Chart --}}
    <div class="chart-card">
        <div class="chart-card__header">
            <h3 class="chart-card__title">Grafik Perkembangan 6 Bulan Terakhir</h3>
            <div class="chart-card__legend">
                <div class="legend-item"><div class="legend-dot legend-dot--fisik"></div>Fisik</div>
                <div class="legend-item"><div class="legend-dot legend-dot--kognitif"></div>Kognitif</div>
                <div class="legend-item"><div class="legend-dot legend-dot--bahasa"></div>Bahasa</div>
                <div class="legend-item"><div class="legend-dot legend-dot--sosial"></div>Sosial</div>
                <div class="legend-item"><div class="legend-dot legend-dot--agama"></div>Agama</div>
                <div class="legend-item"><div class="legend-dot legend-dot--seni"></div>Seni</div>
            </div>
        </div>
        <div class="chart-card__body">
            <canvas id="developmentChart" width="100%" height="300"></canvas>
        </div>
    </div>

    {{-- Radar Chart --}}
    <div class="chart-card">
        <div class="chart-card__header">
            <h3 class="chart-card__title">Profil Perkembangan (Rata-rata)</h3>
        </div>
        <div class="chart-card__body">
            <canvas id="radarChart" width="100%" height="300"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const skalaLabels = {1: 'BB', 2: 'MB', 3: 'BSH', 4: 'BSB'};

    // Line Chart - Development Progress
    const ctx = document.getElementById('developmentChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Bulan 1', 'Bulan 2', 'Bulan 3', 'Bulan 4', 'Bulan 5', 'Bulan 6'],
            datasets: [
                {
                    label: 'Fisik-Motorik',
                    data: [2, 2, 3, 3, 3, 4],
                    borderColor: '#F06292',
                    backgroundColor: 'rgba(240, 98, 146, 0.1)',
                    tension: 0.4
                },
                {
                    label: 'Kognitif',
                    data: [2, 3, 3, 3, 4, 4],
                    borderColor: '#F59E0B',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    tension: 0.4
                },
                {
                    label: 'Bahasa',
                    data: [3, 3, 3, 4, 4, 4],
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4
                },
                {
                    label: 'Sosial-Emosional',
                    data: [2, 3, 3, 3, 3, 3],
                    borderColor: '#4CAF82',
                    backgroundColor: 'rgba(76, 175, 130, 0.1)',
                    tension: 0.4
                },
                {
                    label: 'Agama & Moral',
                    data: [2, 3, 3, 4, 4, 4],
                    borderColor: '#8B5CF6',
                    backgroundColor: 'rgba(139, 92, 246, 0.1)',
                    tension: 0.4
                },
                {
                    label: 'Seni',
                    data: [3, 3, 3, 3, 4, 4],
                    borderColor: '#EC4899',
                    backgroundColor: 'rgba(236, 72, 153, 0.1)',
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    min: 1,
                    max: 4,
                    ticks: {
                        stepSize: 1,
                        callback: function(val) {
                            return skalaLabels[val] || val;
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Radar Chart - Profile
    const radarCtx = document.getElementById('radarChart').getContext('2d');
    new Chart(radarCtx, {
        type: 'radar',
        data: {
            labels: ['Fisik-Motorik', 'Kognitif', 'Bahasa', 'Sosial-Emosional', 'Agama & Moral', 'Seni'],
            datasets: [{
                label: 'Rata-rata',
                data: [4, 4, 4, 3, 4, 4],
                fill: true,
                backgroundColor: 'rgba(76,175,130, 0.2)',
                borderColor: '#4CAF82',
                pointBackgroundColor: '#4CAF82',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#4CAF82'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                r: {
                    min: 1,
                    max: 4,
                    ticks: {
                        stepSize: 1,
                        callback: function(val) {
                            return skalaLabels[val] || val;
                        }
                    }
                }
            }
        }
    });

    function applyFilter() {
        // Logic to apply filter
        alert('Filter akan diterapkan');
    }
</script>
@endpush

@endsection
