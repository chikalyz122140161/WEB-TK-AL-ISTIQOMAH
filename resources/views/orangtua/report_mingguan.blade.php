@extends('layouts.app')

@section('title', 'Laporan Perkembangan - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Laporan Perkembangan Anak')

@push('styles')
<style>
    /* Section card */
    .form-section {
        background: #fff; border: 1px solid #e7e5e4;
        border-radius: 12px; margin-bottom: 18px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04); overflow: hidden;
    }
    .form-section__head {
        background: linear-gradient(135deg, #3D9B72 0%, #2E8B60 100%);
        padding: 13px 20px; display: flex; align-items: center; gap: 10px;
    }
    .form-section__head svg { width: 18px; height: 18px; fill: rgba(255,255,255,0.85); }
    .form-section__title { color: #fff; font-size: 14px; font-weight: 600; margin: 0; }

    .form-section__body { padding: 20px; }

    /* Field group */
    .field-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 14px;
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
        box-sizing: border-box; transition: border-color 0.15s, box-shadow 0.15s;
        font-family: inherit; cursor: pointer;
    }
    .field-control:focus {
        border-color: #3D9B72; box-shadow: 0 0 0 3px rgba(61,155,114,0.12);
    }

    /* Group box */
    .group-box {
        border: 1px solid #e7e5e4; border-radius: 8px;
        margin-bottom: 12px; overflow: hidden;
    }
    .group-box:last-child { margin-bottom: 0; }
    .group-box__head {
        background: #f9fafb; padding: 10px 14px;
        font-size: 13px; font-weight: 600; color: #3E2723;
        display: flex; align-items: center; gap: 7px;
        border-bottom: 1px solid #e7e5e4;
    }
    .group-box__head svg { width: 14px; height: 14px; fill: #3D9B72; }
    .group-box__body { padding: 14px; display: flex; flex-direction: column; gap: 10px; }

    .assessment-row {
        display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
    }
    .assessment-row__label {
        flex: 1; min-width: 180px; font-size: 13px; color: #57534e;
    }
    .assessment-row__badge { min-width: 160px; }

    /* Level badge (read-only) */
    .lv-badge {
        display: inline-block; font-size: 12px; font-weight: 700;
        padding: 5px 14px; border-radius: 6px; border: 1.5px solid;
        letter-spacing: 0.02em;
    }
    .lv-BB  { background: rgba(240,98,146,0.06); border-color: rgba(240,98,146,0.4); color: #d81b72; }
    .lv-MB  { background: #FFFDE7; border-color: #e6db00; color: #5D4037; }
    .lv-BSH { background: rgba(76,175,130,0.08); border-color: rgba(76,175,130,0.4); color: #2E8B60; }
    .lv-BSB { background: rgba(76,175,130,0.12); border-color: rgba(76,175,130,0.6); color: #2E8B60; }

    /* Legend */
    .legend-bar {
        display: flex; flex-wrap: wrap; gap: 14px;
        background: rgba(76,175,130,0.06); border: 1px solid rgba(76,175,130,0.2); border-radius: 8px;
        padding: 10px 16px; margin-bottom: 18px; font-size: 12px; color: #3E2723;
    }
    .legend-bar span { display: flex; align-items: center; gap: 6px; }
    .legend-dot { width: 9px; height: 9px; border-radius: 50%; }
    .ld-bb  { background: #d81b72; }
    .ld-mb  { background: #e6db00; }
    .ld-bsh { background: #4CAF82; }
    .ld-bsb { background: #2E8B60; }

    /* Student info strip */
    .student-strip {
        background: #f9fafb; border: 1px solid #e7e5e4;
        border-radius: 8px; padding: 10px 16px;
        font-size: 13px; color: #57534e;
        display: flex; gap: 20px; flex-wrap: wrap;
        margin-bottom: 18px;
    }
    .student-strip strong { color: #3E2723; }

    .ct-placeholder {
        text-align: center; padding: 36px 20px;
        color: #9ca3af; font-size: 13px;
        background: #f9fafb; border-radius: 8px;
        border: 1px dashed #e7e5e4;
    }
    .ct-block { display: none; }
    .ct-block.active { display: block; }
    .week-block { display: none; }
    .week-block.active { display: block; }
</style>
@endpush

@section('sidebar')
    @include('orangtua.partials.sidebar')
@endsection

@section('content')

    {{-- Data dummy (semua dikelola JS) --}}

    {{-- Card 1: Filter --}}
    <div class="form-section">
        <div class="form-section__head">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd"/></svg>
            <h3 class="form-section__title">Data Dasar</h3>
        </div>
        <div class="form-section__body">
            <div class="field-grid">
                <div class="field-group">
                    <label class="field-label" for="selClassTerm">Tahun Ajaran (Class Term)</label>
                    <select class="field-control" id="selClassTerm"></select>
                </div>
                <div class="field-group">
                    <label class="field-label" for="selMinggu">Minggu Ke</label>
                    <select class="field-control" id="selMinggu"></select>
                </div>
                <div class="field-group">
                    <label class="field-label">Siswa</label>
                    <div style="padding:9px 12px;font-size:13px;border:1px solid #e7e5e4;border-radius:7px;background:#f9fafb;color:#3E2723;" id="siswaDisplay">—</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Info siswa strip --}}
    <div class="student-strip" id="studentStrip" style="display:none">
        <span><strong>Nama:</strong> <span id="infoNama">—</span></span>
        <span><strong>NIS:</strong> <span id="infoNis">—</span></span>
        <span><strong>Kelas:</strong> <span id="infoKelas">—</span></span>
        <span><strong>Semester:</strong> <span id="infoSem">—</span></span>
        <span><strong>Minggu ke:</strong> <span id="infoMinggu">—</span></span>
    </div>

    {{-- Card 2: Bimbingan Konseling --}}
    <div class="form-section">
        <div class="form-section__head">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M4.804 21.644A6.707 6.707 0 0 0 6 21.75a6.721 6.721 0 0 0 3.583-1.029c.774.182 1.584.279 2.417.279 5.322 0 9.75-3.97 9.75-9 0-5.03-4.428-9-9.75-9s-9.75 3.97-9.75 9c0 2.09.768 4.04 2.084 5.558a8.96 8.96 0 0 1-1.603 2.596.75.75 0 0 0 .53 1.28 6.72 6.72 0 0 0 1.543-.09Z" clip-rule="evenodd"/></svg>
            <h3 class="form-section__title">Bimbingan Konseling</h3>
        </div>
        <div class="form-section__body">
            <div class="legend-bar">
                <span><span class="legend-dot ld-bb"></span> <strong>BB</strong> = Belum Berkembang</span>
                <span><span class="legend-dot ld-mb"></span> <strong>MB</strong> = Mulai Berkembang</span>
                <span><span class="legend-dot ld-bsh"></span> <strong>BSH</strong> = Berkembang Sesuai Harapan</span>
                <span><span class="legend-dot ld-bsb"></span> <strong>BSB</strong> = Berkembang Sangat Baik</span>
            </div>

            <div id="konselingPlaceholder" class="ct-placeholder">
                Pilih class term dan minggu di atas untuk menampilkan laporan perkembangan.
            </div>
            <div id="konselingContent" style="display:none"></div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
/* ── Dummy data ── */
const DUMMY = {
    student: { nama: 'Ahmad Fauzi', nis: '2024001' },
    classTerms: [
        { id: 'ct1', label: 'Kelas A — 2025/2026 Ganjil',  kelas: 'A', semester: 'Ganjil',  tahun: '2025/2026' },
        { id: 'ct2', label: 'Kelas A — 2024/2025 Genap',   kelas: 'A', semester: 'Genap',   tahun: '2024/2025' },
    ],
    weeks: [1,2,3,4,5,6,7,8,9,10,11,12],
    konselings: [
        {
            id: 'kon1', nama: 'Nilai Agama & Moral',
            assessments: [
                { id: 'a1', nama: 'Berdoa sebelum dan sesudah kegiatan' },
                { id: 'a2', nama: 'Mengenal perilaku baik/sopan' },
                { id: 'a3', nama: 'Mengenal agama yang dianut' },
            ]
        },
        {
            id: 'kon2', nama: 'Fisik Motorik',
            assessments: [
                { id: 'b1', nama: 'Motorik kasar (berlari, melompat)' },
                { id: 'b2', nama: 'Motorik halus (menggunting, mewarnai)' },
                { id: 'b3', nama: 'Kebersihan dan kesehatan diri' },
            ]
        },
        {
            id: 'kon3', nama: 'Kognitif',
            assessments: [
                { id: 'c1', nama: 'Mengenal konsep bilangan dan angka' },
                { id: 'c2', nama: 'Memecahkan masalah sederhana' },
                { id: 'c3', nama: 'Mengenal bentuk geometri' },
            ]
        },
        {
            id: 'kon4', nama: 'Bahasa',
            assessments: [
                { id: 'd1', nama: 'Menyimak cerita/percakapan' },
                { id: 'd2', nama: 'Mengungkapkan pikiran secara verbal' },
                { id: 'd3', nama: 'Mengenal huruf dan kata sederhana' },
            ]
        },
        {
            id: 'kon5', nama: 'Sosial Emosional',
            assessments: [
                { id: 'e1', nama: 'Berinteraksi dengan teman sebaya' },
                { id: 'e2', nama: 'Mengendalikan emosi diri' },
                { id: 'e3', nama: 'Menunjukkan rasa empati' },
            ]
        },
        {
            id: 'kon6', nama: 'Seni',
            assessments: [
                { id: 'f1', nama: 'Menggambar dan mewarnai' },
                { id: 'f2', nama: 'Kegiatan musik dan bernyanyi' },
                { id: 'f3', nama: 'Kegiatan prakarya/kolase' },
            ]
        },
    ],
    /* scores[ct_id][week][assessment_id] = level (BB/MB/BSH/BSB) */
    scores: {
        ct1: {
             1: { a1:'MB',  a2:'MB',  a3:'MB',  b1:'MB',  b2:'BB',  b3:'MB',  c1:'BB',  c2:'MB',  c3:'MB',  d1:'MB',  d2:'BSH', d3:'MB',  e1:'BB',  e2:'BB',  e3:'MB',  f1:'MB',  f2:'MB',  f3:'BB'  },
             2: { a1:'MB',  a2:'BSH', a3:'MB',  b1:'MB',  b2:'MB',  b3:'MB',  c1:'MB',  c2:'MB',  c3:'MB',  d1:'MB',  d2:'BSH', d3:'MB',  e1:'MB',  e2:'BB',  e3:'MB',  f1:'MB',  f2:'MB',  f3:'MB'  },
             3: { a1:'BSH', a2:'BSH', a3:'MB',  b1:'BSH', b2:'MB',  b3:'BSH', c1:'MB',  c2:'MB',  c3:'BSH', d1:'BSH', d2:'BSH', d3:'MB',  e1:'MB',  e2:'MB',  e3:'MB',  f1:'MB',  f2:'BSH', f3:'MB'  },
             4: { a1:'BSH', a2:'BSH', a3:'BSH', b1:'BSH', b2:'MB',  b3:'BSH', c1:'MB',  c2:'BSH', c3:'BSH', d1:'BSH', d2:'BSH', d3:'BSH', e1:'MB',  e2:'MB',  e3:'BSH', f1:'BSH', f2:'BSH', f3:'MB'  },
             5: { a1:'BSH', a2:'BSH', a3:'BSH', b1:'BSH', b2:'BSH', b3:'BSH', c1:'BSH', c2:'BSH', c3:'BSH', d1:'BSH', d2:'BSB', d3:'BSH', e1:'BSH', e2:'MB',  e3:'BSH', f1:'BSH', f2:'BSH', f3:'BSH' },
             6: { a1:'BSH', a2:'BSB', a3:'BSH', b1:'BSH', b2:'BSH', b3:'BSH', c1:'BSH', c2:'BSH', c3:'BSH', d1:'BSB', d2:'BSB', d3:'BSH', e1:'BSH', e2:'BSH', e3:'BSH', f1:'BSH', f2:'BSH', f3:'BSH' },
             7: { a1:'BSB', a2:'BSB', a3:'BSH', b1:'BSB', b2:'BSH', b3:'BSH', c1:'BSH', c2:'BSH', c3:'BSB', d1:'BSB', d2:'BSB', d3:'BSH', e1:'BSH', e2:'BSH', e3:'BSH', f1:'BSH', f2:'BSB', f3:'BSH' },
             8: { a1:'BSB', a2:'BSB', a3:'BSB', b1:'BSB', b2:'BSH', b3:'BSB', c1:'BSH', c2:'BSB', c3:'BSB', d1:'BSB', d2:'BSB', d3:'BSB', e1:'BSH', e2:'BSH', e3:'BSH', f1:'BSB', f2:'BSB', f3:'BSH' },
             9: { a1:'BSB', a2:'BSB', a3:'BSB', b1:'BSB', b2:'BSB', b3:'BSB', c1:'BSB', c2:'BSB', c3:'BSB', d1:'BSB', d2:'BSB', d3:'BSB', e1:'BSH', e2:'BSH', e3:'BSH', f1:'BSB', f2:'BSB', f3:'BSB' },
            10: { a1:'BSB', a2:'BSB', a3:'BSB', b1:'BSB', b2:'BSB', b3:'BSB', c1:'BSB', c2:'BSB', c3:'BSB', d1:'BSB', d2:'BSB', d3:'BSB', e1:'BSH', e2:'BSH', e3:'BSB', f1:'BSB', f2:'BSB', f3:'BSB' },
            11: { a1:'BSB', a2:'BSB', a3:'BSB', b1:'BSB', b2:'BSB', b3:'BSB', c1:'BSB', c2:'BSB', c3:'BSB', d1:'BSB', d2:'BSB', d3:'BSB', e1:'BSB', e2:'BSH', e3:'BSB', f1:'BSB', f2:'BSB', f3:'BSB' },
            12: { a1:'BSB', a2:'BSB', a3:'BSB', b1:'BSB', b2:'BSB', b3:'BSB', c1:'BSB', c2:'BSB', c3:'BSB', d1:'BSB', d2:'BSB', d3:'BSB', e1:'BSB', e2:'BSB', e3:'BSB', f1:'BSB', f2:'BSB', f3:'BSB' },
        },
        ct2: {
             1: { a1:'BB',  a2:'BB',  a3:'BB',  b1:'MB',  b2:'BB',  b3:'MB',  c1:'BB',  c2:'BB',  c3:'MB',  d1:'MB',  d2:'MB',  d3:'BB',  e1:'BB',  e2:'BB',  e3:'BB',  f1:'MB',  f2:'MB',  f3:'BB'  },
             2: { a1:'MB',  a2:'BB',  a3:'MB',  b1:'MB',  b2:'MB',  b3:'MB',  c1:'BB',  c2:'MB',  c3:'MB',  d1:'MB',  d2:'MB',  d3:'MB',  e1:'BB',  e2:'BB',  e3:'MB',  f1:'MB',  f2:'MB',  f3:'MB'  },
             3: { a1:'MB',  a2:'MB',  a3:'MB',  b1:'MB',  b2:'MB',  b3:'MB',  c1:'MB',  c2:'MB',  c3:'MB',  d1:'MB',  d2:'BSH', d3:'MB',  e1:'MB',  e2:'BB',  e3:'MB',  f1:'MB',  f2:'MB',  f3:'MB'  },
             4: { a1:'MB',  a2:'BSH', a3:'MB',  b1:'BSH', b2:'MB',  b3:'MB',  c1:'MB',  c2:'MB',  c3:'MB',  d1:'BSH', d2:'BSH', d3:'MB',  e1:'MB',  e2:'MB',  e3:'MB',  f1:'MB',  f2:'BSH', f3:'MB'  },
             5: { a1:'BSH', a2:'BSH', a3:'MB',  b1:'BSH', b2:'MB',  b3:'BSH', c1:'MB',  c2:'BSH', c3:'MB',  d1:'BSH', d2:'BSH', d3:'BSH', e1:'MB',  e2:'MB',  e3:'MB',  f1:'BSH', f2:'BSH', f3:'MB'  },
             6: { a1:'BSH', a2:'BSH', a3:'BSH', b1:'BSH', b2:'BSH', b3:'BSH', c1:'BSH', c2:'BSH', c3:'BSH', d1:'BSH', d2:'BSH', d3:'BSH', e1:'BSH', e2:'MB',  e3:'BSH', f1:'BSH', f2:'BSH', f3:'BSH' },
             7: { a1:'BSH', a2:'BSH', a3:'BSH', b1:'BSH', b2:'BSH', b3:'BSH', c1:'BSH', c2:'BSH', c3:'BSH', d1:'BSB', d2:'BSH', d3:'BSH', e1:'BSH', e2:'BSH', e3:'BSH', f1:'BSH', f2:'BSH', f3:'BSH' },
             8: { a1:'BSB', a2:'BSH', a3:'BSH', b1:'BSB', b2:'BSH', b3:'BSH', c1:'BSH', c2:'BSH', c3:'BSH', d1:'BSB', d2:'BSB', d3:'BSH', e1:'BSH', e2:'BSH', e3:'BSH', f1:'BSH', f2:'BSB', f3:'BSH' },
             9: { a1:'BSB', a2:'BSB', a3:'BSH', b1:'BSB', b2:'BSH', b3:'BSB', c1:'BSB', c2:'BSH', c3:'BSH', d1:'BSB', d2:'BSB', d3:'BSH', e1:'BSH', e2:'BSH', e3:'BSH', f1:'BSB', f2:'BSB', f3:'BSH' },
            10: { a1:'BSB', a2:'BSB', a3:'BSB', b1:'BSB', b2:'BSB', b3:'BSB', c1:'BSB', c2:'BSB', c3:'BSH', d1:'BSB', d2:'BSB', d3:'BSB', e1:'BSH', e2:'BSH', e3:'BSH', f1:'BSB', f2:'BSB', f3:'BSB' },
            11: { a1:'BSB', a2:'BSB', a3:'BSB', b1:'BSB', b2:'BSB', b3:'BSB', c1:'BSB', c2:'BSB', c3:'BSB', d1:'BSB', d2:'BSB', d3:'BSB', e1:'BSB', e2:'BSH', e3:'BSB', f1:'BSB', f2:'BSB', f3:'BSB' },
            12: { a1:'BSB', a2:'BSB', a3:'BSB', b1:'BSB', b2:'BSB', b3:'BSB', c1:'BSB', c2:'BSB', c3:'BSB', d1:'BSB', d2:'BSB', d3:'BSB', e1:'BSB', e2:'BSB', e3:'BSB', f1:'BSB', f2:'BSB', f3:'BSB' },
        },
    },
};

const selCT    = document.getElementById('selClassTerm');
const selMggu  = document.getElementById('selMinggu');
const siswaDisp= document.getElementById('siswaDisplay');
const strip    = document.getElementById('studentStrip');
const placeholder = document.getElementById('konselingPlaceholder');
const content  = document.getElementById('konselingContent');

/* Populate dropdowns */
DUMMY.classTerms.forEach(ct => {
    const o = document.createElement('option');
    o.value = ct.id; o.textContent = ct.label;
    selCT.appendChild(o);
});

function populateWeeks() {
    selMggu.innerHTML = '';
    DUMMY.weeks.forEach(w => {
        const o = document.createElement('option');
        o.value = w; o.textContent = 'Minggu ' + w;
        selMggu.appendChild(o);
    });
    selMggu.value = 12;
}
populateWeeks();

[selCT, selMggu].forEach(el => el.addEventListener('change', render));

function render() {
    const ctId = selCT.value;
    const week = parseInt(selMggu.value, 10);
    const ct   = DUMMY.classTerms.find(c => c.id === ctId);
    const scores = (DUMMY.scores[ctId] || {})[week] || {};

    /* Update siswa info */
    siswaDisp.textContent = DUMMY.student.nama;
    document.getElementById('infoNama').textContent  = DUMMY.student.nama;
    document.getElementById('infoNis').textContent   = DUMMY.student.nis;
    document.getElementById('infoKelas').textContent = ct ? ct.kelas : '—';
    document.getElementById('infoSem').textContent   = ct ? ct.semester + ' ' + ct.tahun : '—';
    document.getElementById('infoMinggu').textContent= week;
    strip.style.display = 'flex';

    /* Build konseling content */
    placeholder.style.display = 'none';
    content.style.display = 'block';
    content.innerHTML = DUMMY.konselings.map(kon => `
        <div class="group-box">
            <div class="group-box__head">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd"/></svg>
                ${kon.nama}
            </div>
            <div class="group-box__body">
                ${kon.assessments.map(ca => {
                    const lv = scores[ca.id] || 'BB';
                    return `
                        <div class="assessment-row">
                            <div class="assessment-row__label">${ca.nama}</div>
                            <div class="assessment-row__badge">
                                <span class="lv-badge lv-${lv}">${lv}</span>
                            </div>
                        </div>
                    `;
                }).join('')}
            </div>
        </div>
    `).join('');
}

// Init
render();
</script>
@endpush
