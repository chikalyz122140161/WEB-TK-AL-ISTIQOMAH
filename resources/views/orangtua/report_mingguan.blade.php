@extends('layouts.app')

@section('title', 'Laporan Perkembangan - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Laporan Perkembangan Anak')

@section('sidebar')
    @include('orangtua.partials.sidebar')
@endsection

@push('styles')
<style>
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
    .field-static {
        padding: 9px 12px; font-size: 13px;
        border: 1px solid #e7e5e4; border-radius: 7px;
        background: #f9fafb; color: #3E2723;
    }

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
        padding: 6px 0; border-bottom: 1px solid #f5f5f4;
    }
    .assessment-row:last-child { border-bottom: none; }
    .assessment-row__label {
        flex: 1; min-width: 180px; font-size: 13px; color: #57534e;
    }

    .lv-badge {
        display: inline-block; font-size: 12px; font-weight: 700;
        padding: 5px 14px; border-radius: 6px; border: 1.5px solid;
        letter-spacing: 0.02em;
    }
    .lv-BB  { background: rgba(240,98,146,0.06); border-color: rgba(240,98,146,0.4); color: #d81b72; }
    .lv-MB  { background: #FFFDE7; border-color: #e6db00; color: #5D4037; }
    .lv-BSH { background: rgba(76,175,130,0.08); border-color: rgba(76,175,130,0.4); color: #2E8B60; }
    .lv-BSB { background: rgba(76,175,130,0.12); border-color: rgba(76,175,130,0.6); color: #2E8B60; }
    .lv-- { background: #f5f5f4; border-color: #e7e5e4; color: #9ca3af; }

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

    .student-strip {
        background: #f9fafb; border: 1px solid #e7e5e4;
        border-radius: 8px; padding: 10px 16px;
        font-size: 13px; color: #57534e;
        display: flex; gap: 20px; flex-wrap: wrap;
        margin-bottom: 18px;
    }
    .student-strip strong { color: #3E2723; }

    .empty-state {
        text-align: center; padding: 40px 20px;
        color: #9ca3af; font-size: 13px;
        background: #f9fafb; border-radius: 8px;
        border: 1px dashed #e7e5e4;
    }
</style>
@endpush

@section('content')

    {{-- Filter Card --}}
    <div class="form-section">
        <div class="form-section__head">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd"/></svg>
            <h3 class="form-section__title">Data Dasar</h3>
        </div>
        <div class="form-section__body">
            @if(!empty($classTerms))
            <form method="GET" action="{{ route('orangtua.report_mingguan') }}">
                <div class="field-grid">
                    <div class="field-group">
                        <label class="field-label">Tahun Ajaran (Class Term)</label>
                        <select name="class_term_id" class="field-control" onchange="this.form.submit()">
                            @foreach($classTerms as $ct)
                                <option value="{{ $ct['id'] }}" {{ $classTermId === $ct['id'] ? 'selected' : '' }}>
                                    {{ $ct['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Minggu Ke</label>
                        @if(!empty($weeks))
                            <select name="week" class="field-control" onchange="this.form.submit()">
                                @foreach($weeks as $w)
                                    <option value="{{ $w }}" {{ $week == $w ? 'selected' : '' }}>
                                        Minggu {{ $w }}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <div class="field-static">Belum ada data minggu</div>
                        @endif
                    </div>
                </div>
            </form>
            @else
                <div class="empty-state">Tidak ada rapot yang tersedia untuk ditampilkan.</div>
            @endif
        </div>
    </div>

    @if($studentInfo && !empty($weeks))
    {{-- Info strip --}}
    <div class="student-strip">
        <span><strong>Nama:</strong> {{ $studentInfo['nama'] }}</span>
        <span><strong>NIS:</strong> {{ $studentInfo['nis'] }}</span>
        <span><strong>Kelas:</strong> {{ $studentInfo['kelas'] }}</span>
        <span><strong>Semester:</strong> {{ $studentInfo['semester'] }}</span>
        <span><strong>Minggu ke:</strong> {{ $week }}</span>
    </div>

    {{-- Konseling Card --}}
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

            @forelse($konseling as $k)
                <div class="group-box">
                    <div class="group-box__head">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd"/></svg>
                        {{ $k['nama'] }}
                    </div>
                    <div class="group-box__body">
                        @foreach($k['assessments'] as $a)
                            <div class="assessment-row">
                                <div class="assessment-row__label">{{ $a['nama'] }}</div>
                                <div>
                                    <span class="lv-badge lv-{{ $a['level'] }}">{{ $a['level'] ?: '-' }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="empty-state">Belum ada data konseling untuk minggu ini.</div>
            @endforelse
        </div>
    </div>
    @endif

@endsection
