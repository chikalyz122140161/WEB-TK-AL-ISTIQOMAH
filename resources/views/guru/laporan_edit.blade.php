@extends('layouts.app')

@section('title', 'Edit Laporan Perkembangan - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Edit Laporan Perkembangan')

@push('styles')
<style>
    .back-link {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 14px; font-weight: 500; color: #5D4037;
        margin-bottom: 16px; transition: color .2s;
        text-decoration: none;
    }
    .back-link:hover { color: #3E2723; }
    .back-link svg { width: 16px; height: 16px; fill: currentColor; }

    /* Section card (mengikuti style input_perkembangan) */
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

    /* Field grid */
    .field-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 14px;
    }
    .field-group { display: flex; flex-direction: column; gap: 5px; }
    .field-label {
        font-size: 11px; font-weight: 600;
        color: #6b7280; text-transform: uppercase; letter-spacing: .03em;
    }
    .field-control {
        width: 100%; padding: 9px 12px; font-size: 13px;
        border: 1px solid #e7e5e4; border-radius: 7px;
        background: #fff; color: #3E2723; outline: none;
        box-sizing: border-box; transition: border-color .15s, box-shadow .15s;
        font-family: inherit;
    }
    .field-control:focus {
        border-color: #3D9B72; box-shadow: 0 0 0 3px rgba(61,155,114,0.12);
    }
    .field-control[disabled],
    .field-control[readonly] {
        background: #f9fafb; color: #6b7280; cursor: default;
    }

    /* Group box (konseling) */
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

    select.lv-bb  { border-color: #fca5a5; background: #fff5f5; color: #dc2626; }
    select.lv-mb  { border-color: #fde68a; background: #fffdf0; color: #ca8a04; }
    select.lv-bsh { border-color: #86efac; background: #f0fff4; color: #16a34a; }
    select.lv-bsb { border-color: #4ade80; background: #f0fff4; color: #15803d; }

    /* Legend */
    .legend-bar {
        display: flex; flex-wrap: wrap; gap: 14px;
        background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px;
        padding: 10px 16px; margin-bottom: 18px; font-size: 12px; color: #3E2723;
    }
    .legend-bar span { display: flex; align-items: center; gap: 6px; }
    .legend-dot { width: 9px; height: 9px; border-radius: 50%; }
    .ld-bb  { background: #f87171; }
    .ld-mb  { background: #facc15; }
    .ld-bsh { background: #4ade80; }
    .ld-bsb { background: #22c55e; }

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
        border: none; border-radius: 9px; cursor: pointer; transition: all .2s;
        box-shadow: 0 3px 8px rgba(61,155,114,0.3);
    }
    .btn-save:hover { transform: translateY(-1px); box-shadow: 0 5px 14px rgba(61,155,114,0.4); }
    .btn-save svg { width: 16px; height: 16px; fill: currentColor; }
    .btn-cancel {
        display: inline-flex; align-items: center; gap: 7px;
        background: #f3f4f6; color: #374151;
        padding: 10px 18px; font-size: 14px; font-weight: 600;
        border: none; border-radius: 9px; cursor: pointer;
        text-decoration: none; transition: background .2s;
    }
    .btn-cancel:hover { background: #e5e7eb; }
</style>
@endpush

@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

@section('content')

    <a href="{{ route('guru.laporan_bk') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M17 10a.75.75 0 0 1-.75.75H5.612l4.158 3.96a.75.75 0 1 1-1.04 1.08l-5.5-5.25a.75.75 0 0 1 0-1.08l5.5-5.25a.75.75 0 1 1 1.04 1.08L5.612 9.25H16.25A.75.75 0 0 1 17 10Z" clip-rule="evenodd"/></svg>
        Kembali ke Laporan Perkembangan
    </a>

    <form method="POST" action="{{ route('guru.laporan_bk.update', $laporan['id']) }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="week" value="{{ $laporan['week'] }}">

        {{-- Data Dasar --}}
        <div class="form-section">
            <div class="form-section__head">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd"/></svg>
                <h3 class="form-section__title">Data Dasar</h3>
            </div>
            <div class="form-section__body">
                <div class="field-grid">
                    <div class="field-group">
                        <label class="field-label">Tahun Ajaran / Kelas</label>
                        <input class="field-control" type="text" value="{{ $laporan['semester'] }} — Kelas {{ $laporan['kelas'] }}" readonly>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Siswa</label>
                        <input class="field-control" type="text" value="{{ $laporan['siswa_nama'] }}" readonly>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Minggu Ke</label>
                        <input class="field-control" type="number" readonly value="{{ $laporan['minggu'] }}">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Tanggal</label>
                        <input class="field-control" type="date" name="tanggal" value="{{ $laporan['tanggal'] }}" required>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bimbingan Konseling --}}
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

                @forelse ($laporan['konselings'] as $kon)
                    <div class="group-box">
                        <div class="group-box__head">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd"/></svg>
                            {{ $kon['nama'] }}
                        </div>
                        <div class="group-box__body">
                            @foreach ($kon['items'] as $item)
                                @php
                                    $kode = $item['level'] ?? '';
                                    $cls  = $kode ? 'lv-' . strtolower($kode) : '';
                                @endphp
                                <div class="assessment-row">
                                    <div class="assessment-row__label">{{ $item['nama'] }}</div>
                                    <div class="assessment-row__select">
                                        <select name="counseling[{{ $kon['id'] }}][{{ $item['id'] }}]"
                                                class="field-control {{ $cls }}"
                                                onchange="updateSelectStyle(this)">
                                            <option value="">-- Pilih Level --</option>
                                            <option value="BB"  {{ $kode === 'BB'  ? 'selected' : '' }}>BB — Belum Berkembang</option>
                                            <option value="MB"  {{ $kode === 'MB'  ? 'selected' : '' }}>MB — Mulai Berkembang</option>
                                            <option value="BSH" {{ $kode === 'BSH' ? 'selected' : '' }}>BSH — Berkembang Sesuai Harapan</option>
                                            <option value="BSB" {{ $kode === 'BSB' ? 'selected' : '' }}>BSB — Berkembang Sangat Baik</option>
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <p style="color:#9ca3af;font-style:italic;">Belum ada konseling yang dikaitkan.</p>
                @endforelse
            </div>
        </div>

        {{-- Submit bar --}}
        <div class="submit-bar">
            <button type="submit" class="btn-save">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/></svg>
                Simpan Perubahan
            </button>
            <a href="{{ route('guru.laporan_bk') }}" class="btn-cancel">Batal</a>
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
</script>
@endpush
