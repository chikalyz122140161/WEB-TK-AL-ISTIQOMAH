@extends('layouts.app')

@section('title', 'Input Perkembangan - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Input Perkembangan Anak')

@push('styles')
<style>
    .alert-success {
        background: rgba(76,175,130,0.12); border: 1px solid rgba(76,175,130,0.3); color: #2E8B60;
        padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;
        display: flex; align-items: center; gap: 8px; font-size: 14px;
    }

    /* Section card (mengikuti style rapot/siswa) */
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
    .field-group {
        display: flex; flex-direction: column; gap: 5px;
    }
    .field-label {
        font-size: 11px; font-weight: 600;
        color: #6b7280; text-transform: uppercase; letter-spacing: 0.03em;
    }
    .field-control {
        width: 100%; padding: 9px 12px; font-size: 13px;
        border: 1px solid #e7e5e4; border-radius: 7px;
        background: #fff; color: #3E2723; outline: none;
        box-sizing: border-box; transition: border-color 0.15s, box-shadow 0.15s;
        font-family: inherit;
    }
    .field-control:focus {
        border-color: #3D9B72; box-shadow: 0 0 0 3px rgba(61,155,114,0.12);
    }
    select.field-control { cursor: pointer; }

    /* Group box (counseling group) */
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
    .assessment-row__select { min-width: 160px; }

    select.lv-bb  { border-color: rgba(240,98,146,0.4); background: rgba(240,98,146,0.06); color: #d81b72; }
    select.lv-mb  { border-color: #e6db00; background: #FFFDE7; color: #5D4037; }
    select.lv-bsh { border-color: rgba(76,175,130,0.4); background: rgba(76,175,130,0.08); color: #2E8B60; }
    select.lv-bsb { border-color: rgba(76,175,130,0.6); background: rgba(76,175,130,0.12); color: #2E8B60; }

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

    /* Empty class term placeholder */
    .ct-placeholder {
        text-align: center; padding: 36px 20px;
        color: #9ca3af; font-size: 13px;
        background: #f9fafb; border-radius: 8px;
        border: 1px dashed #e7e5e4;
    }

    /* Class term block (toggled via JS) */
    .ct-block { display: none; }
    .ct-block.active { display: block; }

    /* Submit bar */
    .submit-bar {
        position: sticky; bottom: 0; z-index: 10;
        background: rgba(255,255,255,0.95); backdrop-filter: blur(4px);
        border-top: 1px solid #e7e5e4;
        padding: 14px 0; margin-top: 8px;
        display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
    }
    .btn-save {
        display: inline-flex; align-items: center; gap: 7px;
        background: linear-gradient(135deg, #3D9B72 0%, #2E8B60 100%);
        color: #fff; padding: 10px 22px; font-size: 14px; font-weight: 600;
        border: none; border-radius: 9px; cursor: pointer; transition: all 0.2s;
        box-shadow: 0 3px 8px rgba(61,155,114,0.3);
    }
    .btn-save:hover { transform: translateY(-1px); box-shadow: 0 5px 14px rgba(61,155,114,0.4); }
    .btn-save svg { width: 16px; height: 16px; fill: currentColor; }
    .btn-cancel {
        display: inline-flex; align-items: center; gap: 7px;
        background: #f3f4f6; color: #374151;
        padding: 10px 18px; font-size: 14px; font-weight: 600;
        border: none; border-radius: 9px; cursor: pointer;
        text-decoration: none; transition: background 0.2s;
    }
    .btn-cancel:hover { background: #e5e7eb; }
</style>
@endpush

@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

@section('content')

    @if (session('success'))
        <div class="alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('guru.store_input_perkembangan') }}">
        @csrf

        {{-- Card 1: Data Dasar --}}
        <div class="form-section">
            <div class="form-section__head">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd"/></svg>
                <h3 class="form-section__title">Data Dasar</h3>
            </div>
            <div class="form-section__body">
                <div class="field-grid">
                    <div class="field-group">
                        <label class="field-label" for="class_term_id">Tahun Ajaran (Class Term) *</label>
                        <select class="field-control" id="class_term_id" name="class_term_id" required>
                            <option value="" disabled selected>-- Pilih Class Term --</option>
                            @foreach ($classTerms as $ct)
                                <option value="{{ $ct['id'] }}">
                                    Kelas {{ $ct['kelas_nama'] }} — {{ $ct['tahun_ajaran'] }} {{ ucfirst($ct['semester']) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="siswa_id">Pilih Siswa *</label>
                        <select class="field-control" id="siswa_id" name="siswa_id" required>
                            <option value="" disabled selected>-- Pilih Class Term dulu --</option>
                            @foreach ($daftarSiswa as $siswa)
                                <option value="{{ $siswa['id'] }}" data-class-term="{{ $siswa['class_term_id'] }}">
                                    {{ $siswa['nama'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="minggu_ke">Minggu Ke *</label>
                        <input class="field-control" type="number" id="minggu_ke" name="minggu_ke"
                               min="1" max="52" placeholder="Contoh: 12" required>
                    </div>

                    <div class="field-group">
                        <label class="field-label" for="tanggal">Tanggal *</label>
                        <input class="field-control" type="date" id="tanggal" name="tanggal"
                               value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
            </div>
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

                <div id="ct-placeholder" class="ct-placeholder">
                    Pilih class term di atas untuk menampilkan poin penilaian konseling.
                </div>

                @foreach ($classTerms as $ct)
                    @php $counselings = $counselingByCt[$ct['id']] ?? []; @endphp
                    <div class="ct-block" data-class-term="{{ $ct['id'] }}">
                        @if (count($counselings) === 0)
                            <div class="ct-placeholder">
                                Belum ada konseling yang dikaitkan ke class term ini.
                            </div>
                        @else
                            @foreach ($counselings as $con)
                                <div class="group-box">
                                    <div class="group-box__head">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd"/></svg>
                                        {{ $con['nama'] }}
                                    </div>
                                    <div class="group-box__body">
                                        @foreach ($con['assessments'] as $ca)
                                            <div class="assessment-row">
                                                <div class="assessment-row__label">{{ $ca['nama'] }}</div>
                                                <div class="assessment-row__select">
                                                    <select name="counseling[{{ $ct['id'] }}][{{ $ca['id'] }}]"
                                                            class="field-control"
                                                            onchange="updateSelectStyle(this)">
                                                        <option value="">-- Pilih Level --</option>
                                                        <option value="BB">BB — Belum Berkembang</option>
                                                        <option value="MB">MB — Mulai Berkembang</option>
                                                        <option value="BSH">BSH — Berkembang Sesuai Harapan</option>
                                                        <option value="BSB">BSB — Berkembang Sangat Baik</option>
                                                    </select>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Submit bar --}}
        <div class="submit-bar">
            <button type="submit" class="btn-save">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/></svg>
                Simpan Perkembangan
            </button>
            <a href="{{ route('guru.dashboard') }}" class="btn-cancel">Batal</a>
        </div>
    </form>

@endsection

@push('scripts')
<script>
const levelClasses = { BB: 'lv-bb', MB: 'lv-mb', BSH: 'lv-bsh', BSB: 'lv-bsb' };

function updateSelectStyle(el) {
    el.classList.remove('lv-bb', 'lv-mb', 'lv-bsh', 'lv-bsb');
    if (el.value && levelClasses[el.value]) {
        el.classList.add(levelClasses[el.value]);
    }
}

const ctSelect      = document.getElementById('class_term_id');
const siswaSelect   = document.getElementById('siswa_id');
const placeholder   = document.getElementById('ct-placeholder');
const ctBlocks      = document.querySelectorAll('.ct-block');
const siswaOptions  = Array.from(siswaSelect.querySelectorAll('option[data-class-term]'));

function applyClassTerm(ctId) {
    // Toggle blok konseling
    ctBlocks.forEach(b => b.classList.toggle('active', b.dataset.classTerm === ctId));
    placeholder.style.display = ctId ? 'none' : 'block';

    // Filter dropdown siswa
    siswaSelect.value = '';
    siswaOptions.forEach(opt => {
        opt.hidden = opt.dataset.classTerm !== ctId;
    });
    const firstVisible = siswaOptions.find(o => !o.hidden);
    siswaSelect.querySelector('option[disabled]').textContent = ctId
        ? '-- Pilih Siswa --'
        : '-- Pilih Class Term dulu --';
    if (!firstVisible) {
        siswaSelect.querySelector('option[disabled]').textContent = 'Tidak ada siswa di class term ini';
    }
}

ctSelect.addEventListener('change', e => applyClassTerm(e.target.value));
applyClassTerm(ctSelect.value);
</script>
@endpush
