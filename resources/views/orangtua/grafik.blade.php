@extends('layouts.app')

@section('title', 'Grafik Perkembangan - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Grafik Perkembangan')

@section('sidebar')
    @include('orangtua.partials.sidebar')
@endsection

@push('styles')
<style>
    /* ── Filter ─────────────────────────────── */
    .gp-filter-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 14px 16px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 12px;
        margin-bottom: 16px;
        box-shadow: var(--shadow-xs);
    }
    .gp-field { display: flex; flex-direction: column; gap: 4px; }
    .gp-field__label {
        font-size: 11px; font-weight: 600;
        color: var(--text-mid); text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .gp-select {
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

    /* ── Chart card grid ─────────────────────── */
    .gp-chart-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }
    .gp-chart-grid.is-single { grid-template-columns: 1fr; }
    @media (max-width: 900px) { .gp-chart-grid { grid-template-columns: 1fr; } }

    .gp-chart-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 16px 18px 14px;
        box-shadow: var(--shadow-xs);
    }
    .gp-chart-card__head {
        display: flex; justify-content: space-between; align-items: center;
        gap: 10px; margin-bottom: 8px;
    }
    .gp-chart-card__title {
        font-size: 14px; font-weight: 700;
        color: var(--text); margin: 0;
        display: flex; align-items: center; gap: 8px;
    }
    .gp-chart-card__title svg { width: 16px; height: 16px; fill: var(--green-dark); }
    .gp-chart-card__sub {
        font-size: 11px; color: var(--text-mid);
    }
    .gp-chart-card__count {
        background: #f3f4f6; color: #374151;
        border-radius: 99px; padding: 2px 9px;
        font-size: 11px; font-weight: 600;
    }
    .gp-chart-wrap { position: relative; height: 260px; }
    .gp-chart-grid.is-single .gp-chart-wrap { height: 320px; }

    /* ── Legend ──────────────────────────────── */
    .gp-legend {
        display: flex; flex-wrap: wrap; gap: 10px;
        margin-top: 10px; padding-top: 8px;
        border-top: 1px solid var(--border-subtle);
    }
    .gp-legend__item {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 11px; color: var(--text-mid);
    }
    .gp-legend__dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }

    /* ── Skala ──────────────────────────────── */
    .gp-skala {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 12px 16px;
        margin-top: 14px;
        font-size: 12px;
    }
    .gp-skala__title {
        font-size: 11px; font-weight: 700; color: var(--text);
        text-transform: uppercase; letter-spacing: 0.04em; margin: 0 0 8px;
    }
    .gp-skala__list {
        list-style: none; margin: 0; padding: 0;
        display: flex; flex-wrap: wrap; gap: 14px;
    }
    .gp-skala__list li {
        display: flex; align-items: center; gap: 6px;
        color: var(--text-mid);
    }
    .gp-skala__list li strong { color: var(--text); }
    .gp-skala__dot { width: 10px; height: 10px; border-radius: 50%; }

    /* ── Empty ───────────────────────────────── */
    .gp-empty {
        text-align: center; padding: 50px 20px;
        color: #a8a29e; font-size: 13px;
        background: #fff; border: 1px dashed var(--border);
        border-radius: 12px;
    }
</style>
@endpush

@section('content')

    {{-- Header --}}
    <div style="margin-bottom:16px">
        <span style="background:linear-gradient(135deg,var(--green),var(--green-dark));color:#fff;padding:7px 16px;border-radius:8px;font-size:14px;font-weight:700;box-shadow:0 2px 8px var(--green-20);">
            Grafik Perkembangan Konseling
        </span>
    </div>

    {{-- Filters --}}
    <div class="gp-filter-card">
        <div class="gp-field">
            <label class="gp-field__label">Semester</label>
            <select class="gp-select" id="selSemester"></select>
        </div>
        <div class="gp-field">
            <label class="gp-field__label">Minggu</label>
            <select class="gp-select" id="selMinggu"></select>
        </div>
        <div class="gp-field">
            <label class="gp-field__label">Konseling</label>
            <select class="gp-select" id="selKonseling"></select>
        </div>
    </div>

    {{-- Stats --}}
    <div class="gp-stats" id="statsRow">
        <div class="stat-card stat-card--primary">
            <div class="stat-card__header">
                <span class="stat-card__label">BSB</span>
                <svg class="stat-card__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd"/></svg>
            </div>
            <div class="stat-card__value" id="sBsb">0</div>
            <div class="stat-card__sub">Berkembang Sangat Baik</div>
        </div>
        <div class="stat-card">
            <div class="stat-card__header">
                <span class="stat-card__label">BSH</span>
                <svg class="stat-card__icon stat-card__icon--green" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd"/></svg>
            </div>
            <div class="stat-card__value" id="sBsh">0</div>
            <div class="stat-card__sub">Berkembang Sesuai Harapan</div>
        </div>
        <div class="stat-card stat-card--secondary">
            <div class="stat-card__header">
                <span class="stat-card__label">MB</span>
                <svg class="stat-card__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd"/></svg>
            </div>
            <div class="stat-card__value" id="sMb">0</div>
            <div class="stat-card__sub">Mulai Berkembang</div>
        </div>
        <div class="stat-card stat-card--accent">
            <div class="stat-card__header">
                <span class="stat-card__label">BB</span>
                <svg class="stat-card__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd"/></svg>
            </div>
            <div class="stat-card__value" id="sBb">0</div>
            <div class="stat-card__sub">Belum Berkembang</div>
        </div>
    </div>

    {{-- Chart grid --}}
    <div class="gp-chart-grid" id="chartGrid"></div>

    <div class="gp-empty" id="emptyState" style="display:none">
        Tidak ada data untuk filter yang dipilih.
    </div>

    {{-- Skala --}}
    <div class="gp-skala">
        <p class="gp-skala__title">Keterangan Skala</p>
        <ul class="gp-skala__list">
            <li><span class="gp-skala__dot" style="background:#d81b72"></span> <strong>1 (BB)</strong> — Belum Berkembang</li>
            <li><span class="gp-skala__dot" style="background:#e6db00"></span> <strong>2 (MB)</strong> — Mulai Berkembang</li>
            <li><span class="gp-skala__dot" style="background:#4CAF82"></span> <strong>3 (BSH)</strong> — Berkembang Sesuai Harapan</li>
            <li><span class="gp-skala__dot" style="background:#2E8B60"></span> <strong>4 (BSB)</strong> — Berkembang Sangat Baik</li>
        </ul>
    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
/* ── Dummy data ── */
const PAYLOAD = {
    student: { id: 'siswa_1', nama: 'Ahmad Fauzi', nis: '2024001' },
    semesters: [
        { id: 'sem1_2025', label: 'Semester 1 — 2025/2026' },
        { id: 'sem2_2024', label: 'Semester 2 — 2024/2025' },
    ],
    weeks: [1,2,3,4,5,6,7,8,9,10,11,12],
    konselings: [
        {
            id: 'kon1', nama: 'Nilai Agama & Moral',
            assessments: [{id:'a1'},{id:'a2'},{id:'a3'}]
        },
        {
            id: 'kon2', nama: 'Fisik Motorik',
            assessments: [{id:'b1'},{id:'b2'},{id:'b3'}]
        },
        {
            id: 'kon3', nama: 'Kognitif',
            assessments: [{id:'c1'},{id:'c2'},{id:'c3'}]
        },
        {
            id: 'kon4', nama: 'Bahasa',
            assessments: [{id:'d1'},{id:'d2'},{id:'d3'}]
        },
        {
            id: 'kon5', nama: 'Sosial Emosional',
            assessments: [{id:'e1'},{id:'e2'},{id:'e3'}]
        },
        {
            id: 'kon6', nama: 'Seni',
            assessments: [{id:'f1'},{id:'f2'},{id:'f3'}]
        },
    ],
    /* scores[sem][konseling_id][week] = avg score (1-4) */
    scores: {
        'sem1_2025': {
            kon1: { 1:2, 2:2, 3:3, 4:3, 5:3, 6:3, 7:4, 8:4, 9:4, 10:4, 11:4, 12:4 },
            kon2: { 1:2, 2:2, 3:2, 4:3, 5:3, 6:3, 7:3, 8:4, 9:4, 10:4, 11:4, 12:4 },
            kon3: { 1:1, 2:2, 3:2, 4:2, 5:3, 6:3, 7:3, 8:3, 9:4, 10:4, 11:4, 12:4 },
            kon4: { 1:2, 2:3, 3:3, 4:3, 5:3, 6:4, 7:4, 8:4, 9:4, 10:4, 11:4, 12:4 },
            kon5: { 1:1, 2:1, 3:2, 4:2, 5:3, 6:3, 7:3, 8:3, 9:3, 10:4, 11:4, 12:4 },
            kon6: { 1:2, 2:2, 3:2, 4:3, 5:3, 6:3, 7:3, 8:4, 9:4, 10:4, 11:4, 12:4 },
        },
        'sem2_2024': {
            kon1: { 1:1, 2:2, 3:2, 4:2, 5:3, 6:3, 7:3, 8:3, 9:4, 10:4, 11:4, 12:4 },
            kon2: { 1:1, 2:1, 3:2, 4:2, 5:2, 6:3, 7:3, 8:3, 9:3, 10:4, 11:4, 12:4 },
            kon3: { 1:1, 2:1, 3:1, 4:2, 5:2, 6:2, 7:3, 8:3, 9:3, 10:3, 11:4, 12:4 },
            kon4: { 1:2, 2:2, 3:2, 4:3, 5:3, 6:3, 7:3, 8:3, 9:4, 10:4, 11:4, 12:4 },
            kon5: { 1:1, 2:2, 3:2, 4:2, 5:2, 6:3, 7:3, 8:3, 9:3, 10:3, 11:4, 12:4 },
            kon6: { 1:2, 2:2, 3:3, 4:3, 5:3, 6:3, 7:4, 8:4, 9:4, 10:4, 11:4, 12:4 },
        },
    },
};

const PALETTE = ['#3D9B72', '#F59E0B', '#3B82F6', '#EC4899', '#8B5CF6', '#06B6D4'];
const LV      = {1:'BB', 2:'MB', 3:'BSH', 4:'BSB'};
const TICK    = '#5D4037';
const GRID    = 'rgba(62,39,35,0.06)';

const selSemester  = document.getElementById('selSemester');
const selMinggu    = document.getElementById('selMinggu');
const selKonseling = document.getElementById('selKonseling');
const chartGrid    = document.getElementById('chartGrid');
const emptyState   = document.getElementById('emptyState');

let charts = [];

/* ── Populate dropdowns ── */
PAYLOAD.semesters.forEach(sm => {
    const o = document.createElement('option');
    o.value = sm.id; o.textContent = sm.label;
    selSemester.appendChild(o);
});

const optAll = document.createElement('option');
optAll.value = '__all__'; optAll.textContent = 'Semua Minggu';
selMinggu.appendChild(optAll);
PAYLOAD.weeks.forEach(w => {
    const o = document.createElement('option');
    o.value = w; o.textContent = 'Minggu ' + w;
    selMinggu.appendChild(o);
});

const optAllK = document.createElement('option');
optAllK.value = '__all__'; optAllK.textContent = 'Semua Konseling';
selKonseling.appendChild(optAllK);
PAYLOAD.konselings.forEach(con => {
    const o = document.createElement('option');
    o.value = con.id; o.textContent = con.nama;
    selKonseling.appendChild(o);
});

[selSemester, selMinggu, selKonseling].forEach(sel => {
    sel.addEventListener('change', render);
});

function hexA(hex, a) {
    const r = parseInt(hex.slice(1,3),16),
          g = parseInt(hex.slice(3,5),16),
          b = parseInt(hex.slice(5,7),16);
    return `rgba(${r},${g},${b},${a})`;
}

function destroyCharts() {
    charts.forEach(c => c.destroy());
    charts = [];
}

function getKonselingsInScope(f) {
    return f.kons === '__all__'
        ? PAYLOAD.konselings
        : PAYLOAD.konselings.filter(c => c.id === f.kons);
}

function render() {
    const f = {
        sem:  selSemester.value,
        week: selMinggu.value,
        kons: selKonseling.value,
    };
    renderStats(f);
    renderCharts(f);
}

function renderStats(f) {
    const counts = {1:0, 2:0, 3:0, 4:0};
    const konselings = getKonselingsInScope(f);
    const weeks = f.week === '__all__' ? PAYLOAD.weeks : [parseInt(f.week, 10)];
    const semScores = PAYLOAD.scores[f.sem] || {};

    konselings.forEach(con => {
        weeks.forEach(w => {
            const v = (semScores[con.id] || {})[w];
            if (v !== undefined && counts[v] !== undefined) counts[v]++;
        });
    });

    document.getElementById('sBsb').textContent = counts[4];
    document.getElementById('sBsh').textContent = counts[3];
    document.getElementById('sMb').textContent  = counts[2];
    document.getElementById('sBb').textContent  = counts[1];
}

function renderCharts(f) {
    destroyCharts();
    chartGrid.innerHTML = '';

    const konselings = getKonselingsInScope(f);
    chartGrid.classList.toggle('is-single', konselings.length === 1);

    if (konselings.length === 0) {
        emptyState.style.display = 'block';
        return;
    }
    emptyState.style.display = 'none';

    konselings.forEach((con, idx) => {
        const card = document.createElement('div');
        card.className = 'gp-chart-card';
        card.innerHTML = `
            <div class="gp-chart-card__head">
                <h3 class="gp-chart-card__title">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 0 1 8.25-8.25.75.75 0 0 1 .75.75v6.75H18a.75.75 0 0 1 .75.75 8.25 8.25 0 0 1-16.5 0Z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M12.75 3a.75.75 0 0 1 .75-.75 8.25 8.25 0 0 1 8.25 8.25.75.75 0 0 1-.75.75h-7.5a.75.75 0 0 1-.75-.75V3Z" clip-rule="evenodd"/></svg>
                    ${con.nama}
                </h3>
                <span class="gp-chart-card__count">${con.assessments.length} poin</span>
            </div>
            <p class="gp-chart-card__sub" id="sub-${con.id}">Skor perkembangan ${PAYLOAD.student.nama} — ${con.nama}</p>
            <div class="gp-chart-wrap"><canvas id="canvas-${con.id}"></canvas></div>
            <div class="gp-legend" id="legend-${con.id}"></div>
        `;
        chartGrid.appendChild(card);

        buildKonselingChart(con, f, idx);
    });
}

function buildKonselingChart(con, f, idx) {
    const labels    = PAYLOAD.weeks.map(w => 'Mg' + w);
    const semScores = PAYLOAD.scores[f.sem] || {};
    const data      = semScores[con.id] || {};
    const arr       = PAYLOAD.weeks.map(w => data[w] ?? null);
    const color     = PALETTE[idx % PALETTE.length];

    const datasets = [{
        label: PAYLOAD.student.nama,
        data: arr,
        borderColor: color,
        backgroundColor: hexA(color, 0.15),
        borderWidth: 2.5,
        pointRadius: 4,
        tension: 0.35,
        fill: true,
    }];

    const legendEl = document.getElementById('legend-' + con.id);
    legendEl.innerHTML = `
        <span class="gp-legend__item">
            <span class="gp-legend__dot" style="background:${color}"></span>
            ${PAYLOAD.student.nama}
        </span>
    `;

    const wIndex = f.week === '__all__' ? null : (PAYLOAD.weeks.indexOf(parseInt(f.week, 10)));
    const ctx    = document.getElementById('canvas-' + con.id).getContext('2d');

    const chart = new Chart(ctx, {
        type: 'line',
        data: { labels, datasets },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'nearest', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#fff',
                    titleColor: '#3E2723',
                    bodyColor: '#5D4037',
                    borderColor: 'rgba(62,39,35,0.15)',
                    borderWidth: 1,
                    callbacks: {
                        label: item => {
                            const v = item.raw;
                            if (v == null) return ' ' + item.dataset.label + ': -';
                            const tag = LV[Math.round(v)] ? ` (${LV[Math.round(v)]})` : '';
                            return ` ${item.dataset.label}: ${v}${tag}`;
                        }
                    }
                },
            },
            scales: {
                y: {
                    min: 1, max: 4,
                    ticks: { stepSize: 1, callback: v => LV[v] || '', color: TICK, font: { size: 11 } },
                    grid: { color: GRID },
                },
                x: {
                    ticks: { color: TICK, font: { size: 11 } },
                    grid: { display: false },
                },
            },
        },
        plugins: wIndex !== null ? [{
            id: 'weekHighlight',
            afterDraw(chart) {
                const x   = chart.scales.x.getPixelForValue(wIndex);
                const ctx = chart.ctx;
                const top = chart.chartArea.top;
                const bot = chart.chartArea.bottom;
                ctx.save();
                ctx.strokeStyle = 'rgba(220,38,38,0.5)';
                ctx.lineWidth   = 1.5;
                ctx.setLineDash([4, 3]);
                ctx.beginPath();
                ctx.moveTo(x, top);
                ctx.lineTo(x, bot);
                ctx.stroke();
                ctx.restore();
            }
        }] : [],
    });
    charts.push(chart);
}

// Init
render();
</script>
@endpush
