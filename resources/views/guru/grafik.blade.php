@extends('layouts.app')

@section('title', 'Grafik Perkembangan Konseling - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Grafik Perkembangan Konseling')

@push('styles')
<style>
    .filter-card {
        background: #fff;
        border: 1px solid #e7e5e4;
        border-radius: 12px;
        padding: 18px 20px;
        margin-bottom: 18px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 14px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .field-group { display: flex; flex-direction: column; gap: 5px; }
    .field-label {
        font-size: 11px; font-weight: 600;
        color: #6b7280; text-transform: uppercase; letter-spacing: 0.03em;
    }
    .field-control {
        width: 100%; padding: 9px 12px; font-size: 13px;
        border: 1px solid #e7e5e4; border-radius: 7px;
        background: #fff; color: #3E2723; outline: none;
        cursor: pointer; transition: border-color .15s, box-shadow .15s;
        font-family: inherit;
    }
    .field-control:focus {
        border-color: #3D9B72; box-shadow: 0 0 0 3px rgba(61,155,114,0.12);
    }

    /* Info banner */
    .info-banner {
        background: linear-gradient(135deg, #3E2723 0%, #2E8B60 100%);
        border-radius: 12px;
        padding: 18px 22px;
        margin-bottom: 16px;
        display: flex; align-items: center; gap: 16px; flex-wrap: wrap;
        color: #fff;
    }
    .info-banner__avatar {
        width: 48px; height: 48px; border-radius: 50%;
        background: rgba(255,255,255,0.2);
        font-size: 18px; font-weight: 700;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .info-banner__main { flex: 1; min-width: 200px; }
    .info-banner__name { font-size: 16px; font-weight: 700; margin: 0 0 4px; }
    .info-banner__meta {
        display: flex; flex-wrap: wrap; gap: 12px;
        font-size: 12px; opacity: 0.9;
    }
    .info-banner__stat {
        text-align: right;
    }
    .info-banner__stat-num {
        font-size: 24px; font-weight: 700; line-height: 1;
    }
    .info-banner__stat-label {
        font-size: 11px; opacity: 0.85; text-transform: uppercase; letter-spacing: 0.03em;
    }

    /* Chart card */
    .chart-card {
        background: #fff;
        border: 1px solid #e7e5e4;
        border-radius: 12px;
        padding: 20px 24px;
        margin-bottom: 18px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .chart-card__head {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 14px;
    }
    .chart-card__title {
        font-size: 14px; font-weight: 700; color: #3E2723; margin: 0;
        display: flex; align-items: center; gap: 8px;
    }
    .chart-card__title svg { width: 16px; height: 16px; fill: #3D9B72; }
    .chart-card__sub {
        font-size: 12px; color: #6b7280; margin: 0;
    }
    .chart-wrapper {
        position: relative;
        height: 380px;
    }

    /* Group legend (above chart) */
    .group-legend {
        display: flex; flex-wrap: wrap; gap: 6px;
        margin-bottom: 12px;
    }
    .group-legend__item {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 5px 12px;
        background: #f9fafb; border: 1px solid #e7e5e4;
        border-radius: 99px;
        font-size: 12px; color: #3E2723;
    }
    .group-legend__dot {
        width: 10px; height: 10px; border-radius: 50%;
    }

    /* Weekly summary */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 8px;
        margin-top: 16px;
    }
    .summary-cell {
        background: #f9fafb;
        border: 1px solid #e7e5e4;
        border-radius: 8px;
        padding: 8px 10px;
        text-align: center;
    }
    .summary-cell__week {
        font-size: 10px; color: #9ca3af;
        text-transform: uppercase; letter-spacing: 0.04em;
        margin-bottom: 2px;
    }
    .summary-cell__count {
        font-size: 16px; font-weight: 700; color: #3D9B72;
    }
    .summary-cell__avg {
        font-size: 11px; color: #6b7280; margin-top: 1px;
    }

    /* Skala legend */
    .skala-card {
        background: #fff;
        border: 1px solid #e7e5e4;
        border-radius: 12px;
        padding: 14px 18px;
        font-size: 12px;
    }
    .skala-card__title {
        font-size: 12px; font-weight: 700; color: #3E2723;
        text-transform: uppercase; letter-spacing: 0.04em;
        margin: 0 0 10px;
    }
    .skala-list {
        list-style: none; margin: 0; padding: 0;
        display: flex; flex-wrap: wrap; gap: 14px;
    }
    .skala-list li {
        display: flex; align-items: center; gap: 6px;
        color: #57534e;
    }
    .skala-list li strong { color: #3E2723; }
    .skala-dot { width: 10px; height: 10px; border-radius: 50%; }

    /* Empty state */
    .empty-state {
        background: #fff; border: 1px dashed #d6d3d1;
        border-radius: 12px;
        padding: 50px 20px; text-align: center;
        color: #9ca3af; font-size: 14px;
    }
</style>
@endpush

@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

@section('content')

    <h2 style="margin:0 0 18px;font-size:18px;font-weight:700;color:#3E2723;">
        Grafik Perkembangan Konseling
    </h2>

    {{-- Filter --}}
    <div class="filter-card">
        <div class="field-group">
            <label class="field-label" for="selectClassTerm">Class Term (Tahun Ajaran)</label>
            <select class="field-control" id="selectClassTerm">
                <option value="" disabled selected>-- Pilih Class Term --</option>
                @foreach ($classTerms as $ct)
                    <option value="{{ $ct['id'] }}">
                        Kelas {{ $ct['kelas_nama'] }} — {{ $ct['tahun_ajaran'] }} {{ ucfirst($ct['semester']) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="field-group">
            <label class="field-label" for="selectSiswa">Siswa</label>
            <select class="field-control" id="selectSiswa" disabled>
                <option value="" disabled selected>-- Pilih Class Term dulu --</option>
            </select>
        </div>

        <div class="field-group">
            <label class="field-label" for="selectCounseling">Counseling</label>
            <select class="field-control" id="selectCounseling" disabled>
                <option value="" disabled selected>-- Pilih Siswa dulu --</option>
            </select>
        </div>
    </div>

    {{-- Info banner & Chart container --}}
    <div id="chartContainer" style="display: none;">
        <div class="info-banner">
            <div class="info-banner__avatar" id="bannerAvatar">-</div>
            <div class="info-banner__main">
                <h3 class="info-banner__name" id="bannerName">Pilih siswa</h3>
                <div class="info-banner__meta" id="bannerMeta"></div>
            </div>
            <div class="info-banner__stat">
                <div class="info-banner__stat-num" id="bannerTotalAssessment">0</div>
                <div class="info-banner__stat-label">Total Poin Konseling</div>
            </div>
        </div>

        <div class="chart-card">
            <div class="chart-card__head">
                <div>
                    <h3 class="chart-card__title">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 0 1 8.25-8.25.75.75 0 0 1 .75.75v6.75H18a.75.75 0 0 1 .75.75 8.25 8.25 0 0 1-16.5 0Z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M12.75 3a.75.75 0 0 1 .75-.75 8.25 8.25 0 0 1 8.25 8.25.75.75 0 0 1-.75.75h-7.5a.75.75 0 0 1-.75-.75V3Z" clip-rule="evenodd"/></svg>
                        Tren Skor per Minggu
                    </h3>
                    <p class="chart-card__sub" id="chartSub"></p>
                </div>
            </div>

            <div class="group-legend" id="groupLegend"></div>

            <div class="chart-wrapper">
                <canvas id="grafikChart"></canvas>
            </div>

            <div class="summary-grid" id="summaryGrid"></div>
        </div>

        <div class="skala-card">
            <p class="skala-card__title">Keterangan Skala</p>
            <ul class="skala-list">
                <li><span class="skala-dot" style="background:#f87171;"></span> <strong>1 (BB)</strong> — Belum Berkembang</li>
                <li><span class="skala-dot" style="background:#facc15;"></span> <strong>2 (MB)</strong> — Mulai Berkembang</li>
                <li><span class="skala-dot" style="background:#4ade80;"></span> <strong>3 (BSH)</strong> — Berkembang Sesuai Harapan</li>
                <li><span class="skala-dot" style="background:#22c55e;"></span> <strong>4 (BSB)</strong> — Berkembang Sangat Baik</li>
            </ul>
        </div>
    </div>

    <div id="emptyState" class="empty-state">
        Pilih class term dan siswa untuk menampilkan grafik perkembangan konseling.
    </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const studentsByCt = @json($studentsByCt);
    const chartData    = @json($chartData);

    // Palet warna per poin penilaian (ketika filter ke 1 counseling)
    const assessmentPalette = [
        '#3D9B72', '#F59E0B', '#3B82F6', '#EC4899',
        '#8B5CF6', '#06B6D4', '#EF4444', '#10B981',
        '#F97316', '#6366F1'
    ];

    const ctSelect         = document.getElementById('selectClassTerm');
    const siswaSelect      = document.getElementById('selectSiswa');
    const counselingSelect = document.getElementById('selectCounseling');
    const container        = document.getElementById('chartContainer');
    const emptyState       = document.getElementById('emptyState');

    const bannerAvatar = document.getElementById('bannerAvatar');
    const bannerName   = document.getElementById('bannerName');
    const bannerMeta   = document.getElementById('bannerMeta');
    const bannerTotal  = document.getElementById('bannerTotalAssessment');
    const chartSub     = document.getElementById('chartSub');
    const groupLegend  = document.getElementById('groupLegend');
    const summaryGrid  = document.getElementById('summaryGrid');

    const ctx = document.getElementById('grafikChart').getContext('2d');
    let chart = null;

    function hexToRgba(hex, alpha) {
        const r = parseInt(hex.slice(1,3), 16);
        const g = parseInt(hex.slice(3,5), 16);
        const b = parseInt(hex.slice(5,7), 16);
        return `rgba(${r},${g},${b},${alpha})`;
    }

    function getCurrentData() {
        const ctId = ctSelect.value;
        const studentId = siswaSelect.value;
        return chartData[ctId + '__' + studentId];
    }

    ctSelect.addEventListener('change', e => {
        const ctId = e.target.value;
        const students = studentsByCt[ctId] || [];

        siswaSelect.innerHTML = students.length === 0
            ? '<option value="" disabled selected>Tidak ada siswa</option>'
            : '<option value="" disabled selected>-- Pilih Siswa --</option>'
                + students.map(s => `<option value="${s.id}">${s.nama}</option>`).join('');
        siswaSelect.disabled = students.length === 0;

        counselingSelect.innerHTML = '<option value="" disabled selected>-- Pilih Siswa dulu --</option>';
        counselingSelect.disabled = true;

        container.style.display = 'none';
        emptyState.style.display = 'block';
    });

    siswaSelect.addEventListener('change', () => {
        const data = getCurrentData();
        if (!data) return;

        // Populate counseling dropdown
        const opts = ['<option value="__all__">Semua Counseling</option>']
            .concat(data.groups.map((g, i) => `<option value="${i}">${g.nama} (${g.assessments.length} poin)</option>`));
        counselingSelect.innerHTML = opts.join('');
        counselingSelect.disabled = false;
        counselingSelect.value = '__all__';

        renderAll(data, '__all__');
    });

    counselingSelect.addEventListener('change', e => {
        const data = getCurrentData();
        if (!data) return;
        renderAll(data, e.target.value);
    });

    function renderAll(data, counselingFilter) {
        const groups = counselingFilter === '__all__'
            ? data.groups
            : [data.groups[parseInt(counselingFilter, 10)]];

        renderInfo(data, groups, counselingFilter);
        renderChart(data, groups, counselingFilter);
        renderSummary(data, groups);

        emptyState.style.display = 'none';
        container.style.display = 'block';
    }

    function renderInfo(data, groups, counselingFilter) {
        bannerAvatar.textContent = data.siswa.nama.charAt(0).toUpperCase();
        bannerName.textContent = data.siswa.nama;
        bannerMeta.innerHTML = `
            <span>Kelas ${data.class_term.kelas}</span>
            <span>${data.class_term.tahun_ajaran} — ${data.class_term.semester.charAt(0).toUpperCase() + data.class_term.semester.slice(1)}</span>
            <span>NIS ${data.siswa.nis}</span>
        `;

        const totalShown = groups.reduce((sum, g) => sum + g.assessments.length, 0);
        bannerTotal.textContent = totalShown;

        if (counselingFilter === '__all__') {
            chartSub.textContent = `Menampilkan ${totalShown} poin penilaian dari ${groups.length} kelompok konseling, dipantau selama ${data.weeks.length} minggu.`;
        } else {
            const g = groups[0];
            chartSub.textContent = `Counseling: ${g.nama} — ${g.assessments.length} poin penilaian, dipantau selama ${data.weeks.length} minggu.`;
        }

        if (counselingFilter === '__all__') {
            groupLegend.innerHTML = groups.map(g => `
                <span class="group-legend__item">
                    <span class="group-legend__dot" style="background:${g.color}"></span>
                    ${g.nama} <span style="color:#9ca3af;">(${g.assessments.length})</span>
                </span>
            `).join('');
        } else {
            const g = groups[0];
            groupLegend.innerHTML = g.assessments.map((ca, i) => {
                const color = assessmentPalette[i % assessmentPalette.length];
                return `
                    <span class="group-legend__item">
                        <span class="group-legend__dot" style="background:${color}"></span>
                        ${ca.nama}
                    </span>
                `;
            }).join('');
        }
    }

    function renderChart(data, groups, counselingFilter) {
        const datasets = [];

        if (counselingFilter === '__all__') {
            // Mode "Semua": semua group, warna ikut group, line dibedakan dengan dash
            groups.forEach(group => {
                group.assessments.forEach((ca, idx) => {
                    datasets.push({
                        label: ca.nama + ' · ' + group.nama,
                        data: ca.scores,
                        borderColor: group.color,
                        backgroundColor: hexToRgba(group.color, 0.1),
                        borderWidth: 2,
                        tension: 0.35,
                        pointRadius: 3,
                        pointHoverRadius: 5,
                        fill: false,
                        borderDash: idx === 0 ? [] : (idx === 1 ? [4,3] : [2,2]),
                    });
                });
            });
        } else {
            // Mode satu counseling: tiap poin penilaian punya warna sendiri
            const g = groups[0];
            g.assessments.forEach((ca, idx) => {
                const color = assessmentPalette[idx % assessmentPalette.length];
                datasets.push({
                    label: ca.nama,
                    data: ca.scores,
                    borderColor: color,
                    backgroundColor: hexToRgba(color, 0.12),
                    borderWidth: 2.5,
                    tension: 0.35,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: false,
                });
            });
        }

        if (chart) chart.destroy();
        chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.weeks.map(w => 'Minggu ' + w),
                datasets,
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'nearest', intersect: false },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { size: 11 },
                            boxWidth: 12,
                            padding: 8,
                        },
                    },
                    tooltip: {
                        callbacks: {
                            label: (item) => {
                                const labels = ['', 'BB', 'MB', 'BSH', 'BSB'];
                                return ' ' + item.dataset.label + ': ' + item.raw + ' (' + labels[item.raw] + ')';
                            }
                        }
                    },
                },
                scales: {
                    y: {
                        min: 0, max: 4,
                        ticks: {
                            stepSize: 1,
                            callback: (v) => {
                                const labels = ['', 'BB', 'MB', 'BSH', 'BSB'];
                                return labels[v] || '';
                            },
                            color: '#5D4037',
                        },
                        grid: { color: '#F3F4F6' },
                    },
                    x: {
                        ticks: { font: { size: 11 }, color: '#3E2723' },
                        grid: { display: false },
                    },
                }
            }
        });
    }

    function renderSummary(data, groups) {
        const allAssessments = groups.flatMap(g => g.assessments);
        const total = allAssessments.length;

        const cells = data.weeks.map((week, idx) => {
            const scores = allAssessments.map(ca => ca.scores[idx]).filter(x => x != null);
            const sum = scores.reduce((a,b) => a + b, 0);
            const avg = scores.length ? (sum / scores.length).toFixed(2) : '-';
            return `
                <div class="summary-cell">
                    <div class="summary-cell__week">Minggu ${week}</div>
                    <div class="summary-cell__count">${scores.length}/${total}</div>
                    <div class="summary-cell__avg">Rata: ${avg}</div>
                </div>
            `;
        }).join('');

        summaryGrid.innerHTML = cells;
    }
</script>
@endpush
