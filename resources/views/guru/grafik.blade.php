@extends('layouts.app')

@section('title', 'Grafik Perkembangan - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Grafik Perkembangan')

@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

@push('styles')
<style>
    /* ── Filter ─────────────────────────────── */
    .gp-filter-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 14px 16px;
        display: flex; gap: 12px; flex-wrap: wrap;
        margin-bottom: 16px;
        box-shadow: var(--shadow-xs);
    }
    .gp-select {
        flex: 1; min-width: 200px;
        padding: 9px 13px; font-size: 13px;
        border: 1px solid var(--border); border-radius: 7px;
        background: #fff; color: var(--text); outline: none;
        cursor: pointer; font-family: inherit;
        transition: border-color .15s;
        appearance: none;
    }
    .gp-select:focus  { border-color: var(--green); box-shadow: 0 0 0 3px var(--green-12); }
    .gp-select:disabled { background: #f9fafb; color: #9ca3af; cursor: default; }

    /* ── Stats ───────────────────────────────── */
    .gp-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px; margin-bottom: 16px;
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
    .gp-tab:not(.is-active):hover {
        border-color: var(--green); color: var(--green-dark);
    }

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

    /* ── Student table ───────────────────────── */
    .gp-table-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 16px 18px 20px;
        box-shadow: var(--shadow-xs);
    }
    .gp-table-title {
        font-size: 13px; font-weight: 700;
        color: var(--text); margin: 0 0 12px;
    }
    .gp-tbl-wrap { overflow-x: auto; }
    .gp-tbl {
        width: 100%; border-collapse: collapse;
        font-size: 12px; white-space: nowrap;
    }
    .gp-tbl th {
        padding: 8px 10px; text-align: left;
        color: var(--text-mid); font-size: 11px;
        font-weight: 600; text-transform: uppercase; letter-spacing: .04em;
        border-bottom: 1px solid var(--border);
    }
    .gp-tbl td {
        padding: 9px 10px;
        border-bottom: 1px solid var(--border-subtle);
        color: var(--text); vertical-align: middle;
    }
    .gp-tbl tbody tr:last-child td { border-bottom: none; }
    .gp-tbl tbody tr:hover td { background: #fafaf8; }

    .lv {
        display: inline-block; font-size: 10px; font-weight: 700;
        padding: 2px 8px; border-radius: 4px;
    }
    .lv-BB  { background: #fee2e2; color: #b91c1c; }
    .lv-MB  { background: #fef3c7; color: #92400e; }
    .lv-BSH { background: #dcfce7; color: #166534; }
    .lv-BSB { background: #bbf7d0; color: #14532d; }
    .lv-avg { font-weight: 700; color: var(--text); }

    /* ── Empty ───────────────────────────────── */
    .gp-empty {
        text-align: center; padding: 60px 20px;
        color: #a8a29e; font-size: 14px;
        background: #fff; border: 1px dashed var(--border);
        border-radius: 12px;
    }
</style>
@endpush

@section('content')

    {{-- Header --}}
    <div style="margin-bottom:16px">
        <span style="background:linear-gradient(135deg,var(--green),var(--green-dark));color:#fff;padding:7px 16px;border-radius:8px;font-size:14px;font-weight:700;box-shadow:0 2px 8px var(--green-20);">
            Grafik Perkembangan — Guru
        </span>
    </div>

    {{-- Filters --}}
    <div class="gp-filter-card">
        <select class="gp-select" id="selCt">
            <option value="" disabled selected>-- Pilih Kelas --</option>
            @foreach ($classTerms as $ct)
                <option value="{{ $ct['id'] }}">
                    Kelas {{ $ct['kelas_nama'] }} — {{ $ct['tahun_ajaran'] }} {{ ucfirst($ct['semester']) }}
                </option>
            @endforeach
        </select>
        <select class="gp-select" id="selAspek" disabled>
            <option value="__all__">Semua Aspek</option>
        </select>
    </div>

    {{-- Stats --}}
    <div class="gp-stats" id="statsRow" style="display:none">
        <div class="stat-card stat-card--primary">
            <div class="stat-card__header">
                <span class="stat-card__label">Total Siswa</span>
                <svg class="stat-card__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2 7.5 4.019 7.5 6.5ZM20 21h1.5a.5.5 0 0 0 .5-.5C22 17.57 18.43 14 14.5 14h-5C5.57 14 2 17.57 2 20.5a.5.5 0 0 0 .5.5H20Z"/></svg>
            </div>
            <div class="stat-card__value" id="sSiswa">0</div>
            <div class="stat-card__sub">Siswa di kelas ini</div>
        </div>
        <div class="stat-card stat-card--secondary">
            <div class="stat-card__header">
                <span class="stat-card__label">BSB Minggu Ini</span>
                <svg class="stat-card__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd"/></svg>
            </div>
            <div class="stat-card__value" id="sBsb">0</div>
            <div class="stat-card__sub">Berkembang Sangat Baik</div>
        </div>
        <div class="stat-card stat-card--accent">
            <div class="stat-card__header">
                <span class="stat-card__label">Perlu Perhatian</span>
                <svg class="stat-card__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd"/></svg>
            </div>
            <div class="stat-card__value" id="sBb">0</div>
            <div class="stat-card__sub">Belum Berkembang (BB)</div>
        </div>
        <div class="stat-card stat-card--neutral">
            <div class="stat-card__header">
                <span class="stat-card__label">Minggu Aktif</span>
                <svg class="stat-card__icon stat-card__icon--green" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
            </div>
            <div class="stat-card__value stat-card__value--text" id="sWeek">Mg. -</div>
            <div class="stat-card__sub">Periode berjalan</div>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="gp-tabs" id="tabRow" style="display:none">
        <button class="gp-tab is-active" data-tab="tren">Tren Kelas</button>
        <button class="gp-tab" data-tab="distribusi">Distribusi</button>
        <button class="gp-tab" data-tab="radar">Radar Aspek</button>
    </div>

    {{-- Chart card --}}
    <div class="gp-chart-card" id="chartCard" style="display:none">
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

    {{-- Student table --}}
    <div class="gp-table-card" id="tableSection" style="display:none">
        <p class="gp-table-title" id="tableTitle">Status siswa — minggu -</p>
        <div class="gp-tbl-wrap">
            <table class="gp-tbl">
                <thead id="tblHead"></thead>
                <tbody id="tblBody"></tbody>
            </table>
        </div>
    </div>

    {{-- Empty --}}
    <div class="gp-empty" id="emptyState">
        Pilih kelas untuk menampilkan grafik perkembangan.
    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const grafikData = @json($grafikData);

const selCt      = document.getElementById('selCt');
const selAspek   = document.getElementById('selAspek');
const statsRow   = document.getElementById('statsRow');
const tabRow     = document.getElementById('tabRow');
const chartCard  = document.getElementById('chartCard');
const tableSection = document.getElementById('tableSection');
const emptyState = document.getElementById('emptyState');

let ctData    = null;
let activeTab = 'tren';
let chart     = null;

const TICK  = '#5D4037';
const GRID  = 'rgba(62,39,35,0.06)';
const BORD  = 'rgba(62,39,35,0.12)';
const TTBG  = '#ffffff';
const TTBC  = 'rgba(62,39,35,0.15)';
const LV    = {1:'BB', 2:'MB', 3:'BSH', 4:'BSB'};
const GREEN = '#4CAF82';
const GREEN_DARK = '#3D9B72';

function shortName(name) {
    const p = name.trim().split(' ');
    return p.length > 1 ? p[0] + ' ' + p[p.length - 1][0] + '.' : p[0];
}

selCt.addEventListener('change', () => {
    ctData = grafikData[selCt.value] || null;
    if (!ctData) return;
    selAspek.innerHTML = '<option value="__all__">Semua Aspek</option>'
        + ctData.subjects.map(s => `<option value="${s.id}">${s.nama}</option>`).join('');
    selAspek.disabled = false;
    selAspek.value    = '__all__';
    render('__all__');
});

selAspek.addEventListener('change', () => {
    if (ctData) render(selAspek.value);
});

document.querySelectorAll('.gp-tab').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.gp-tab').forEach(b => b.classList.remove('is-active'));
        btn.classList.add('is-active');
        activeTab = btn.dataset.tab;
        if (!ctData) return;
        buildChart(selAspek.value);
        tableSection.style.display = activeTab === 'tren' ? 'block' : 'none';
    });
});

function render(aspekId) {
    document.getElementById('sSiswa').textContent = ctData.total_siswa;
    document.getElementById('sBsb').textContent   = ctData.bsb_count;
    document.getElementById('sBb').textContent    = ctData.bb_count;
    document.getElementById('sWeek').textContent  = 'Mg. ' + ctData.current_week;

    buildChart(aspekId);
    buildTable();

    statsRow.style.display     = 'grid';
    tabRow.style.display       = 'flex';
    chartCard.style.display    = 'block';
    emptyState.style.display   = 'none';
    tableSection.style.display = activeTab === 'tren' ? 'block' : 'none';
}

function buildChart(aspekId) {
    if (chart) { chart.destroy(); chart = null; }
    const ctx = document.getElementById('myChart').getContext('2d');
    if      (activeTab === 'tren')       trenChart(ctx, aspekId);
    else if (activeTab === 'distribusi') distribusiChart(ctx, aspekId);
    else if (activeTab === 'radar')      radarChart(ctx);
}

/* ── Tren Kelas (line) ── */
function trenChart(ctx, aspekId) {
    const weeks  = ctData.weeks;
    const labels = weeks.map(w => 'Mg' + w);
    let lineData, lineLabel;

    if (aspekId === '__all__') {
        lineData  = weeks.map(w => ctData.class_avg[w]);
        lineLabel = 'Rata-rata Kelas';
    } else {
        lineData  = weeks.map(w => ctData.subject_avg[aspekId][w]);
        const sub = ctData.subjects.find(s => s.id === aspekId);
        lineLabel = sub ? sub.short : aspekId;
    }

    chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [
                {
                    label: lineLabel,
                    data: lineData,
                    borderColor: GREEN,
                    backgroundColor: 'rgba(76,175,130,0.1)',
                    borderWidth: 2.5,
                    tension: 0.35,
                    pointRadius: 4,
                    pointBackgroundColor: GREEN,
                    fill: true,
                },
                {
                    label: 'Target BSH',
                    data: Array(weeks.length).fill(3),
                    borderColor: 'rgba(76,175,130,0.35)',
                    borderDash: [6, 4],
                    borderWidth: 1.5,
                    pointRadius: 0,
                    fill: false,
                },
            ],
        },
        options: chartOptions(),
    });
}

/* ── Distribusi (bar) ── */
function distribusiChart(ctx, aspekId) {
    const subjects = aspekId === '__all__'
        ? ctData.subjects
        : ctData.subjects.filter(s => s.id === aspekId);

    const lvColors = { BB:'#f87171', MB:'#fbbf24', BSH:'#4CAF82', BSB:'#2E8B60' };
    const datasets = ['BB','MB','BSH','BSB'].map(lv => ({
        label: lv,
        data: subjects.map(s => (ctData.distribution[s.id] || {})[lv] || 0),
        backgroundColor: lvColors[lv],
        borderRadius: 4,
    }));

    chart = new Chart(ctx, {
        type: 'bar',
        data: { labels: subjects.map(s => s.short), datasets },
        options: {
            ...chartOptions(),
            plugins: {
                ...chartOptions().plugins,
                legend: {
                    position: 'bottom',
                    labels: { color: TICK, font: { size: 11 }, boxWidth: 10, padding: 12 },
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
            labels: ctData.subjects.map(s => s.short),
            datasets: [{
                label: 'Rata-rata Kelas',
                data: ctData.subjects.map(s => ctData.radar[s.id] || 0),
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
                tooltip: ttOptions(),
            },
            scales: {
                r: {
                    min: 0, max: 4,
                    ticks: { stepSize: 1, callback: v => LV[v] || '', color: TICK, backdropColor: 'transparent', font: { size: 10 } },
                    grid: { color: GRID },
                    angleLines: { color: BORD },
                    pointLabels: { color: TICK, font: { size: 12, weight: '600' } },
                },
            },
        },
    });
}

function chartOptions() {
    return {
        responsive: true, maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false },
        plugins: {
            legend: { display: false },
            tooltip: ttOptions(),
        },
        scales: {
            y: {
                min: 1, max: 4,
                ticks: { stepSize: 1, callback: v => LV[v] || '', color: TICK, font: { size: 11 } },
                grid: { color: GRID }, border: { color: BORD },
            },
            x: {
                ticks: { color: TICK, font: { size: 11 } },
                grid: { display: false }, border: { color: BORD },
            },
        },
    };
}

function ttOptions() {
    return {
        backgroundColor: TTBG,
        titleColor: '#3E2723',
        bodyColor: '#5D4037',
        borderColor: TTBC,
        borderWidth: 1,
        callbacks: {
            label: item => {
                if (item.dataset.label === 'Target BSH') return null;
                const v = item.raw;
                const tag = LV[Math.round(v)] ? ` (${LV[Math.round(v)]})` : '';
                return ` ${item.dataset.label}: ${v}${tag}`;
            }
        }
    };
}

/* ── Student table ── */
function buildTable() {
    const subjects = ctData.subjects;
    document.getElementById('tableTitle').textContent = `Status siswa — minggu ${ctData.current_week}`;
    document.getElementById('tblHead').innerHTML =
        '<tr><th>Siswa</th>' + subjects.map(s => `<th>${s.short}</th>`).join('') + '<th>Rata</th></tr>';
    document.getElementById('tblBody').innerHTML = ctData.table.map(row => {
        const cells = subjects.map(s => {
            const lv = row.scores[s.id] || '-';
            return `<td><span class="lv lv-${lv}">${lv}</span></td>`;
        }).join('');
        return `<tr><td style="font-weight:600">${shortName(row.nama)}</td>${cells}<td><span class="lv-avg">${row.avg}</span></td></tr>`;
    }).join('');
}
</script>
@endpush
