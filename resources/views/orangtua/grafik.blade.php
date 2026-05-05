@extends('layouts.app')
@php $userRole = 'Orang Tua'; @endphp

@section('title', 'Grafik Perkembangan - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Grafik Perkembangan')

@section('sidebar')
    @include('orangtua.partials.sidebar')
@endsection

@push('styles')
<style>
    /* ── Banner ──────────────────────────────── */
    .gp-banner {
        background: linear-gradient(135deg, var(--green) 0%, var(--green-darker) 100%);
        border-radius: 10px;
        padding: 14px 18px;
        display: flex; align-items: center; gap: 14px; flex-wrap: wrap;
        margin-bottom: 14px;
        box-shadow: 0 2px 10px var(--green-20);
    }
    .gp-banner__avatar {
        width: 44px; height: 44px; border-radius: 50%;
        background: rgba(255,255,255,0.25);
        color: #fff; font-size: 17px; font-weight: 700;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .gp-banner__name { color: #fff; font-size: 15px; font-weight: 700; margin: 0 0 2px; }
    .gp-banner__meta { color: rgba(255,255,255,0.85); font-size: 12px; margin: 0; }

    /* ── Filter ─────────────────────────────── */
    .gp-filter-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 12px 16px;
        margin-bottom: 14px;
        box-shadow: var(--shadow-xs);
    }
    .gp-select {
        width: 100%; padding: 9px 13px; font-size: 13px;
        border: 1px solid var(--border); border-radius: 7px;
        background: #fff; color: var(--text); outline: none;
        cursor: pointer; font-family: inherit;
        transition: border-color .15s; appearance: none;
    }
    .gp-select:focus { border-color: var(--green); box-shadow: 0 0 0 3px var(--green-12); }

    /* ── Stats ───────────────────────────────── */
    .gp-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px; margin-bottom: 14px;
    }
    @media (max-width: 640px) { .gp-stats { grid-template-columns: repeat(2, 1fr); } }

    /* ── Tabs ────────────────────────────────── */
    .gp-tabs {
        display: flex; gap: 8px;
        flex-wrap: wrap; margin-bottom: 14px;
    }
    .gp-tab {
        padding: 8px 18px; font-size: 13px; font-weight: 600;
        border-radius: 8px; cursor: pointer;
        border: 1.5px solid var(--border); outline: none;
        font-family: inherit; transition: all .15s;
        background: #fff; color: var(--text-mid);
    }
    .gp-tab.is-active {
        background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%);
        color: #fff; border-color: transparent;
        box-shadow: 0 2px 8px var(--green-20);
    }
    .gp-tab:not(.is-active):hover { border-color: var(--green); color: var(--green-dark); }

    /* ── Chart card ──────────────────────────── */
    .gp-chart-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 20px 20px 14px;
        margin-bottom: 14px;
        box-shadow: var(--shadow-xs);
    }
    .gp-chart-wrap { position: relative; height: 300px; }

    /* ── Legend ──────────────────────────────── */
    .gp-legend {
        display: flex; flex-wrap: wrap; gap: 14px;
        margin-top: 14px; padding-top: 12px;
        border-top: 1px solid var(--border-subtle);
    }
    .gp-legend__item {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 12px; color: var(--text-mid);
    }
    .gp-legend__dot { width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0; }

    /* ── Status table ────────────────────────── */
    .gp-status-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 16px 18px 20px;
        box-shadow: var(--shadow-xs);
    }
    .gp-status-title {
        font-size: 13px; font-weight: 700;
        color: var(--text); margin: 0 0 12px;
    }
    .gp-tbl { width: 100%; border-collapse: collapse; font-size: 13px; }
    .gp-tbl th {
        padding: 8px 12px; text-align: left;
        color: var(--text-mid); font-size: 11px;
        font-weight: 600; text-transform: uppercase; letter-spacing: .04em;
        border-bottom: 1px solid var(--border);
    }
    .gp-tbl td {
        padding: 10px 12px;
        border-bottom: 1px solid var(--border-subtle);
        color: var(--text); vertical-align: middle;
    }
    .gp-tbl tbody tr:last-child td { border-bottom: none; }
    .gp-tbl tbody tr:hover td { background: #fafaf8; }

    .lv {
        display: inline-block; font-size: 11px; font-weight: 700;
        padding: 3px 9px; border-radius: 5px;
    }
    .lv-BB  { background: #fee2e2; color: #b91c1c; }
    .lv-MB  { background: #fef3c7; color: #92400e; }
    .lv-BSH { background: #dcfce7; color: #166534; }
    .lv-BSB { background: #bbf7d0; color: #14532d; }

    .trend-up   { color: #166534; font-size: 12px; font-weight: 600; }
    .trend-same { color: var(--text-mid); font-size: 12px; }
    .trend-down { color: #b91c1c; font-size: 12px; font-weight: 600; }
</style>
@endpush

@section('content')

    {{-- Badge --}}
    <div style="margin-bottom:14px">
        <span style="background:linear-gradient(135deg,var(--green),var(--green-dark));color:#fff;padding:7px 16px;border-radius:8px;font-size:14px;font-weight:700;box-shadow:0 2px 8px var(--green-20);">
            Grafik Perkembangan — Orang Tua
        </span>
    </div>

    {{-- Student banner --}}
    <div class="gp-banner">
        <div class="gp-banner__avatar">{{ strtoupper(substr($grafikData['student']['nama'], 0, 1)) }}</div>
        <div>
            <p class="gp-banner__name">{{ $grafikData['student']['nama'] }}</p>
            <p class="gp-banner__meta">
                Kelas {{ $grafikData['class_term']['kelas'] }} &nbsp;·&nbsp;
                {{ $grafikData['class_term']['tahun_ajaran'] }} {{ $grafikData['class_term']['semester'] }} &nbsp;·&nbsp;
                NIS {{ $grafikData['student']['nis'] }}
            </p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="gp-filter-card">
        <select class="gp-select" id="selAspek">
            <option value="__all__">Semua Aspek</option>
            @foreach ($grafikData['subjects'] as $s)
                <option value="{{ $s['id'] }}">{{ $s['nama'] }}</option>
            @endforeach
        </select>
    </div>

    {{-- Stats --}}
    <div class="gp-stats">
        <div class="stat-card stat-card--primary">
            <div class="stat-card__header">
                <span class="stat-card__label">BSB</span>
                <svg class="stat-card__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd"/></svg>
            </div>
            <div class="stat-card__value">{{ $grafikData['bsb'] }}</div>
            <div class="stat-card__sub">Berkembang Sangat Baik</div>
        </div>
        <div class="stat-card stat-card--neutral">
            <div class="stat-card__header">
                <span class="stat-card__label">BSH</span>
                <svg class="stat-card__icon stat-card__icon--green" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd"/></svg>
            </div>
            <div class="stat-card__value">{{ $grafikData['bsh'] }}</div>
            <div class="stat-card__sub">Berkembang Sesuai Harapan</div>
        </div>
        <div class="stat-card stat-card--secondary">
            <div class="stat-card__header">
                <span class="stat-card__label">MB</span>
                <svg class="stat-card__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd"/></svg>
            </div>
            <div class="stat-card__value">{{ $grafikData['mb'] }}</div>
            <div class="stat-card__sub">Mulai Berkembang</div>
        </div>
        <div class="stat-card stat-card--accent">
            <div class="stat-card__header">
                <span class="stat-card__label">Perlu Perhatian</span>
                <svg class="stat-card__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd"/></svg>
            </div>
            <div class="stat-card__value">{{ $grafikData['bb'] }}</div>
            <div class="stat-card__sub">Belum Berkembang (BB)</div>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="gp-tabs">
        <button class="gp-tab is-active" data-tab="distribusi">Distribusi Level</button>
        <button class="gp-tab" data-tab="radar">Radar Aspek</button>
    </div>

    {{-- Chart card --}}
    <div class="gp-chart-card">
        <div class="gp-chart-wrap">
            <canvas id="myChart"></canvas>
        </div>
        <div class="gp-legend">
            <span class="gp-legend__item"><span class="gp-legend__dot" style="background:#f87171"></span>BB — Belum Berkembang</span>
            <span class="gp-legend__item"><span class="gp-legend__dot" style="background:#fbbf24"></span>MB — Mulai Berkembang</span>
            <span class="gp-legend__item"><span class="gp-legend__dot" style="background:#4CAF82"></span>BSH — Berkembang Sesuai Harapan</span>
            <span class="gp-legend__item"><span class="gp-legend__dot" style="background:#2E8B60"></span>BSB — Berkembang Sangat Baik</span>
        </div>
    </div>

    {{-- Status per aspek --}}
    <div class="gp-status-card">
        <p class="gp-status-title">Status Perkembangan — Minggu {{ $grafikData['current_week'] }}</p>
        <table class="gp-tbl">
            <thead>
                <tr>
                    <th>Aspek</th>
                    <th>Level Saat Ini</th>
                    <th>Tren</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $keterangan = ['BSB'=>'Berkembang Sangat Baik','BSH'=>'Berkembang Sesuai Harapan','MB'=>'Mulai Berkembang','BB'=>'Belum Berkembang'];
                    $lvMap = [1=>'BB',2=>'MB',3=>'BSH',4=>'BSB'];
                @endphp
                @foreach ($grafikData['subjects'] as $s)
                    @php
                        $cw   = $grafikData['current_week'];
                        $vNow = $grafikData['scores'][$s['id']][$cw];
                        $vPrv = $cw > 1 ? $grafikData['scores'][$s['id']][$cw - 1] : $vNow;
                        $lv   = $lvMap[$vNow];
                        $diff = $vNow - $vPrv;
                    @endphp
                    <tr>
                        <td style="font-weight:600">{{ $s['nama'] }}</td>
                        <td><span class="lv lv-{{ $lv }}">{{ $lv }}</span></td>
                        <td>
                            @if ($diff > 0)  <span class="trend-up">↑ Meningkat</span>
                            @elseif ($diff < 0) <span class="trend-down">↓ Menurun</span>
                            @else <span class="trend-same">→ Stabil</span>
                            @endif
                        </td>
                        <td style="color:var(--text-mid);font-size:12px">{{ $keterangan[$lv] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const grafikData = @json($grafikData);
const selAspek   = document.getElementById('selAspek');

let activeTab = 'distribusi';
let chart     = null;

const TICK  = '#5D4037';
const GRID  = 'rgba(62,39,35,0.06)';
const BORD  = 'rgba(62,39,35,0.12)';
const TTBG  = '#ffffff';
const LV    = {1:'BB', 2:'MB', 3:'BSH', 4:'BSB'};
const GREEN = '#4CAF82';

selAspek.addEventListener('change', () => buildChart(selAspek.value));

document.querySelectorAll('.gp-tab').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.gp-tab').forEach(b => b.classList.remove('is-active'));
        btn.classList.add('is-active');
        activeTab = btn.dataset.tab;
        buildChart(selAspek.value);
    });
});

function buildChart(aspekId) {
    if (chart) { chart.destroy(); chart = null; }
    const ctx = document.getElementById('myChart').getContext('2d');
    if      (activeTab === 'distribusi') distribusiChart(ctx, aspekId);
    else if (activeTab === 'radar')      radarChart(ctx);
}

function ttOptions() {
    return {
        backgroundColor: TTBG,
        titleColor: '#3E2723',
        bodyColor: '#5D4037',
        borderColor: 'rgba(62,39,35,0.15)',
        borderWidth: 1,
    };
}

/* ── Distribusi Level (bar) ── */
function distribusiChart(ctx, aspekId) {
    const subjects = aspekId === '__all__'
        ? grafikData.subjects
        : grafikData.subjects.filter(s => s.id === aspekId);

    const cw  = grafikData.current_week;
    const lvColors = { BB:'#f87171', MB:'#fbbf24', BSH:'#4CAF82', BSB:'#2E8B60' };
    const barColors = subjects.map(s => lvColors[LV[grafikData.scores[s.id][cw]]] || GREEN);

    chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: subjects.map(s => s.short),
            datasets: [{
                label: `Skor Minggu ${cw}`,
                data: subjects.map(s => grafikData.scores[s.id][cw]),
                backgroundColor: barColors,
                borderRadius: 6,
            }],
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    ...ttOptions(),
                    callbacks: {
                        label: item => {
                            const tag = LV[item.raw] ? ` — ${LV[item.raw]}` : '';
                            return ` Skor: ${item.raw}${tag}`;
                        }
                    }
                },
            },
            scales: {
                y: {
                    min: 0, max: 4,
                    ticks: { stepSize: 1, callback: v => LV[v] || '', color: TICK, font: { size: 11 } },
                    grid: { color: GRID }, border: { color: BORD },
                },
                x: {
                    ticks: { color: TICK, font: { size: 12, weight: '600' } },
                    grid: { display: false }, border: { color: BORD },
                },
            },
        },
    });
}

/* ── Radar Aspek ── */
function radarChart(ctx) {
    chart = new Chart(ctx, {
        type: 'radar',
        data: {
            labels: grafikData.subjects.map(s => s.short),
            datasets: [{
                label: grafikData.student.nama,
                data: grafikData.subjects.map(s => grafikData.radar[s.id] || 0),
                backgroundColor: 'rgba(76,175,130,0.2)',
                borderColor: GREEN,
                pointBackgroundColor: GREEN,
                borderWidth: 2,
            }],
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    ...ttOptions(),
                    callbacks: {
                        label: item => {
                            const tag = LV[Math.round(item.raw)] ? ` (${LV[Math.round(item.raw)]})` : '';
                            return ` ${item.label}: ${item.raw}${tag}`;
                        }
                    }
                },
            },
            scales: {
                r: {
                    min: 0, max: 4,
                    ticks: { stepSize: 1, callback: v => LV[v] || '', color: TICK, backdropColor: '#fff', font: { size: 10 } },
                    grid: { color: GRID },
                    angleLines: { color: BORD },
                    pointLabels: { color: TICK, font: { size: 12, weight: '600' } },
                },
            },
        },
    });
}

// Init
buildChart('__all__');
</script>
@endpush
