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
            <select class="gp-select" id="selSemester">
                @foreach ($grafikPayload['semesters'] as $sm)
                    <option value="{{ $sm['id'] }}">{{ $sm['label'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="gp-field">
            <label class="gp-field__label">Kelas</label>
            <select class="gp-select" id="selKelas">
                <option value="__all__">Semua Kelas</option>
                @foreach ($grafikPayload['kelas'] as $k)
                    <option value="{{ $k['id'] }}">{{ $k['nama'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="gp-field">
            <label class="gp-field__label">Siswa</label>
            <select class="gp-select" id="selSiswa">
                <option value="__all__">Semua Siswa</option>
            </select>
        </div>
        <div class="gp-field">
            <label class="gp-field__label">Minggu</label>
            <select class="gp-select" id="selMinggu">
                <option value="__all__">Semua Minggu</option>
                @foreach ($grafikPayload['weeks'] as $w)
                    <option value="{{ $w }}">Minggu {{ $w }}</option>
                @endforeach
            </select>
        </div>
        <div class="gp-field">
            <label class="gp-field__label">Konseling</label>
            <select class="gp-select" id="selKonseling">
                <option value="__all__">Semua Konseling</option>
                @foreach ($grafikPayload['konselings'] as $con)
                    <option value="{{ $con['id'] }}">{{ $con['nama'] }}</option>
                @endforeach
            </select>
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
            <li><span class="gp-skala__dot" style="background:#f87171"></span> <strong>1 (BB)</strong> — Belum Berkembang</li>
            <li><span class="gp-skala__dot" style="background:#facc15"></span> <strong>2 (MB)</strong> — Mulai Berkembang</li>
            <li><span class="gp-skala__dot" style="background:#4ade80"></span> <strong>3 (BSH)</strong> — Berkembang Sesuai Harapan</li>
            <li><span class="gp-skala__dot" style="background:#22c55e"></span> <strong>4 (BSB)</strong> — Berkembang Sangat Baik</li>
        </ul>
    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const PAYLOAD = @json($grafikPayload);

const KELAS_PALETTE = ['#3D9B72', '#F59E0B', '#3B82F6', '#EC4899'];
const SISWA_PALETTE = ['#3D9B72','#F59E0B','#3B82F6','#EC4899','#8B5CF6','#06B6D4','#EF4444','#10B981','#F97316','#6366F1','#14B8A6','#A855F7'];

const LV   = {1:'BB', 2:'MB', 3:'BSH', 4:'BSB'};
const TICK = '#5D4037';
const GRID = 'rgba(62,39,35,0.06)';

const selSemester = document.getElementById('selSemester');
const selKelas    = document.getElementById('selKelas');
const selSiswa    = document.getElementById('selSiswa');
const selMinggu   = document.getElementById('selMinggu');
const selKonseling= document.getElementById('selKonseling');
const chartGrid   = document.getElementById('chartGrid');
const emptyState  = document.getElementById('emptyState');

let charts = [];

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

function refreshSiswaDropdown() {
    const kelas = selKelas.value;
    let list = [];
    if (kelas === '__all__') {
        Object.values(PAYLOAD.siswaByKelas).forEach(arr => list = list.concat(arr));
    } else {
        list = PAYLOAD.siswaByKelas[kelas] || [];
    }
    const prev = selSiswa.value;
    selSiswa.innerHTML = '<option value="__all__">Semua Siswa</option>'
        + list.map(s => `<option value="${s.id}">${s.nama}</option>`).join('');
    selSiswa.value = list.find(s => s.id === prev) ? prev : '__all__';
}

[selSemester, selKelas, selSiswa, selMinggu, selKonseling].forEach(sel => {
    sel.addEventListener('change', () => {
        if (sel === selKelas) refreshSiswaDropdown();
        render();
    });
});

function render() {
    const f = {
        sem:   selSemester.value,
        kelas: selKelas.value,
        siswa: selSiswa.value,
        week:  selMinggu.value,
        kons:  selKonseling.value,
    };

    renderStats(f);
    renderCharts(f);
}

function getSiswaIdsInScope(f) {
    if (f.siswa !== '__all__') return [f.siswa];
    if (f.kelas !== '__all__') return (PAYLOAD.siswaByKelas[f.kelas] || []).map(s => s.id);
    return Object.values(PAYLOAD.siswaByKelas).flat().map(s => s.id);
}

function getKonselingsInScope(f) {
    return f.kons === '__all__' ? PAYLOAD.konselings : PAYLOAD.konselings.filter(c => c.id === f.kons);
}

function renderStats(f) {
    const counts = {1:0, 2:0, 3:0, 4:0};
    const siswaIds = getSiswaIdsInScope(f);
    const konselings = getKonselingsInScope(f);
    const weeks = f.week === '__all__' ? PAYLOAD.weeks : [parseInt(f.week, 10)];
    const rawSem = PAYLOAD.raw[f.sem] || {};

    siswaIds.forEach(sid => {
        konselings.forEach(con => {
            con.assessments.forEach(ca => {
                weeks.forEach(w => {
                    const v = (((rawSem[sid] || {})[ca.id]) || {})[w];
                    if (v !== undefined && counts[v] !== undefined) counts[v]++;
                });
            });
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
            <p class="gp-chart-card__sub" id="sub-${con.id}"></p>
            <div class="gp-chart-wrap"><canvas id="canvas-${con.id}"></canvas></div>
            <div class="gp-legend" id="legend-${con.id}"></div>
        `;
        chartGrid.appendChild(card);

        buildKonselingChart(con, f);
    });
}

function buildKonselingChart(con, f) {
    const labels = PAYLOAD.weeks.map(w => 'Mg' + w);
    let datasets = [];
    let subText = '';

    if (f.siswa !== '__all__') {
        // Single line: skor rata-rata siswa untuk konseling ini
        const data = ((PAYLOAD.bySiswa[f.sem] || {})[con.id] || {})[f.siswa] || {};
        const arr = PAYLOAD.weeks.map(w => data[w] ?? null);
        const siswaName = findSiswaName(f.siswa);
        datasets = [{
            label: siswaName,
            data: arr,
            borderColor: KELAS_PALETTE[0],
            backgroundColor: hexA(KELAS_PALETTE[0], 0.15),
            borderWidth: 2.5,
            pointRadius: 4,
            tension: 0.35,
            fill: true,
        }];
        subText = `Rata-rata skor ${siswaName} untuk ${con.assessments.length} poin penilaian.`;
    } else if (f.kelas !== '__all__') {
        // Lines per siswa di kelas itu
        const siswas = PAYLOAD.siswaByKelas[f.kelas] || [];
        datasets = siswas.map((s, i) => {
            const data = ((PAYLOAD.bySiswa[f.sem] || {})[con.id] || {})[s.id] || {};
            const color = SISWA_PALETTE[i % SISWA_PALETTE.length];
            return {
                label: s.nama,
                data: PAYLOAD.weeks.map(w => data[w] ?? null),
                borderColor: color,
                backgroundColor: hexA(color, 0.1),
                borderWidth: 2,
                pointRadius: 3,
                tension: 0.35,
                fill: false,
            };
        });
        subText = `Rata-rata skor per siswa di kelas ${f.kelas} untuk ${con.assessments.length} poin penilaian.`;
    } else {
        // Default: lines per kelas
        datasets = PAYLOAD.kelas.map((k, i) => {
            const data = ((PAYLOAD.byKelas[f.sem] || {})[con.id] || {})[k.id] || {};
            const color = KELAS_PALETTE[i % KELAS_PALETTE.length];
            return {
                label: 'Kelas ' + k.nama,
                data: PAYLOAD.weeks.map(w => data[w] ?? null),
                borderColor: color,
                backgroundColor: hexA(color, 0.1),
                borderWidth: 2,
                pointRadius: 3,
                tension: 0.35,
                fill: false,
            };
        });
        subText = `Rata-rata kelas (semua siswa × ${con.assessments.length} poin penilaian).`;
    }

    document.getElementById('sub-' + con.id).textContent = subText;

    // Render legend chips
    const legendEl = document.getElementById('legend-' + con.id);
    legendEl.innerHTML = datasets.map(ds => `
        <span class="gp-legend__item"><span class="gp-legend__dot" style="background:${ds.borderColor}"></span>${ds.label}</span>
    `).join('');

    // Vertical line annotation when minggu filtered
    const wIndex = f.week === '__all__' ? null : (PAYLOAD.weeks.indexOf(parseInt(f.week, 10)));

    const ctx = document.getElementById('canvas-' + con.id).getContext('2d');
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
                const x = chart.scales.x.getPixelForValue(wIndex);
                const ctx = chart.ctx;
                const top = chart.chartArea.top;
                const bot = chart.chartArea.bottom;
                ctx.save();
                ctx.strokeStyle = 'rgba(220,38,38,0.5)';
                ctx.lineWidth = 1.5;
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

function findSiswaName(id) {
    for (const arr of Object.values(PAYLOAD.siswaByKelas)) {
        const m = arr.find(s => s.id === id);
        if (m) return m.nama;
    }
    return id;
}

// Init
refreshSiswaDropdown();
render();
</script>
@endpush
