@extends('layouts.app')

@section('title', 'Daftar Siswa - Rapot Semester')
@section('page_title', 'Rapot Semester')

@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

@push('styles')
<style>
    .back-link {
        display: inline-flex; align-items: center; gap: 7px;
        color: #3E2723; font-size: 13px; font-weight: 500;
        text-decoration: none; margin-bottom: 20px; transition: color 0.2s;
    }
    .back-link:hover { color: #3D9B72; }
    .back-link svg { width: 15px; height: 15px; fill: currentColor; }

    .ct-banner {
        background: linear-gradient(135deg, #3D9B72 0%, #2E8B60 100%);
        border-radius: 12px; padding: 20px 24px; margin-bottom: 22px;
        display: flex; align-items: center; gap: 18px; flex-wrap: wrap;
    }
    .ct-banner__badge {
        width: 52px; height: 52px; border-radius: 12px;
        background: rgba(255,255,255,0.2);
        color: #fff; font-size: 18px; font-weight: 800;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .ct-banner__info { flex: 1; }
    .ct-banner__title { color: #fff; font-size: 17px; font-weight: 700; margin: 0 0 4px; }
    .ct-banner__meta  { display: flex; flex-wrap: wrap; gap: 14px; }
    .ct-banner__meta span {
        color: rgba(255,255,255,0.85); font-size: 12px;
        display: flex; align-items: center; gap: 5px;
    }
    .ct-banner__meta svg { width: 13px; height: 13px; fill: rgba(255,255,255,0.7); }
    .ct-banner__progress { text-align: right; }
    .ct-banner__progress .num { color: #fff; font-size: 26px; font-weight: 800; line-height: 1; }
    .ct-banner__progress .lbl { color: rgba(255,255,255,0.75); font-size: 11px; }

    .alert-success {
        background: #d1fae5; border: 1px solid #34d399; color: #065f46;
        padding: 11px 16px; border-radius: 8px; margin-bottom: 16px;
        display: flex; align-items: center; gap: 8px; font-size: 13px;
    }
    .alert-success svg { width: 16px; height: 16px; flex-shrink: 0; fill: currentColor; }

    .table-wrap {
        background: #fff; border: 1px solid #e7e5e4;
        border-radius: 10px; overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }
    .data-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .data-table thead th {
        background: #f9fafb; color: #6b7280; font-weight: 600;
        font-size: 11px; text-transform: uppercase; letter-spacing: 0.04em;
        padding: 11px 14px; text-align: left; border-bottom: 1px solid #e7e5e4;
        white-space: nowrap;
    }
    .data-table tbody tr { border-bottom: 1px solid #f5f5f4; transition: background 0.15s; }
    .data-table tbody tr:last-child { border-bottom: none; }
    .data-table tbody tr:hover { background: #f9fafb; }
    .data-table tbody td { padding: 12px 14px; color: #3E2723; vertical-align: middle; }

    .avatar {
        width: 34px; height: 34px; border-radius: 50%;
        background: linear-gradient(135deg, #3D9B72, #2E8B60);
        color: #fff; font-size: 13px; font-weight: 700;
        display: inline-flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .student-name-cell { display: flex; align-items: center; gap: 10px; }

    .jk-pill {
        font-size: 11px; font-weight: 600; padding: 2px 9px; border-radius: 20px;
    }
    .jk-pill--L { background: #dbeafe; color: #1d4ed8; }
    .jk-pill--P { background: #fce7f3; color: #be185d; }

    .rapot-pill {
        font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 20px;
        display: inline-flex; align-items: center; gap: 5px;
    }
    .rapot-pill--sudah { background: #dcfce7; color: #166534; }
    .rapot-pill--belum { background: #fef9c3; color: #854d0e; }
    .rapot-pill svg { width: 11px; height: 11px; fill: currentColor; }

    .btn-input {
        display: inline-flex; align-items: center; gap: 5px;
        background: linear-gradient(135deg, #3D9B72 0%, #2E8B60 100%);
        color: #fff; padding: 6px 13px; font-size: 12px; font-weight: 600;
        border-radius: 7px; text-decoration: none; transition: all 0.2s;
        box-shadow: 0 2px 6px rgba(61,155,114,0.25); white-space: nowrap;
    }
    .btn-input:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(61,155,114,0.35); }
    .btn-input svg { width: 12px; height: 12px; fill: currentColor; }

    .btn-edit {
        display: inline-flex; align-items: center; gap: 5px;
        background: #f3f4f6; color: #374151;
        padding: 6px 13px; font-size: 12px; font-weight: 600;
        border-radius: 7px; text-decoration: none; transition: background 0.2s;
        white-space: nowrap;
    }
    .btn-edit:hover { background: #e5e7eb; }
    .btn-edit svg { width: 12px; height: 12px; fill: currentColor; }
</style>
@endpush

@section('content')
    <a href="{{ route('guru.rapot.index') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M7.28 7.72a.75.75 0 0 1 0 1.06l-2.47 2.47H21a.75.75 0 0 1 0 1.5H4.81l2.47 2.47a.75.75 0 1 1-1.06 1.06l-3.75-3.75a.75.75 0 0 1 0-1.06l3.75-3.75a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/></svg>
        Kembali ke Daftar Class Term
    </a>

    {{-- Banner --}}
    <div class="ct-banner">
        <div class="ct-banner__badge">{{ $classTerm['kelas_nama'] }}</div>
        <div class="ct-banner__info">
            <h2 class="ct-banner__title">Kelas {{ $classTerm['kelas_nama'] }}</h2>
            <div class="ct-banner__meta">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
                    {{ $classTerm['tahun_ajaran'] }}
                </span>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd"/></svg>
                    Semester {{ ucfirst($classTerm['semester']) }}
                </span>
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 4.8 11.06a.75.75 0 0 1-.231-1.337A60.65 60.65 0 0 1 11.7 2.805Z"/></svg>
                    {{ $total }} Siswa
                </span>
            </div>
        </div>
        <div class="ct-banner__progress">
            <div class="num">{{ $sudahRapot }}/{{ $total }}</div>
            <div class="lbl">rapot terisi</div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>NIS</th>
                    <th>Jenis Kelamin</th>
                    <th>Status Rapot</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $i => $s)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <div class="student-name-cell">
                                <div class="avatar">{{ strtoupper(substr($s['nama'], 0, 1)) }}</div>
                                <span style="font-weight:600">{{ $s['nama'] }}</span>
                            </div>
                        </td>
                        <td style="color:#78716c">{{ $s['nis'] }}</td>
                        <td>
                            <span class="jk-pill jk-pill--{{ $s['jenis_kelamin'] }}">
                                {{ $s['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </td>
                        <td>
                            @if ($s['has_report'])
                                <span class="rapot-pill rapot-pill--sudah">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd"/></svg>
                                    Sudah Diisi
                                </span>
                            @else
                                <span class="rapot-pill rapot-pill--belum">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd"/></svg>
                                    Belum Diisi
                                </span>
                            @endif
                        </td>
                        <td>
                            @if ($s['has_report'])
                                <a href="{{ route('guru.rapot.siswa.form', [$classTerm['id'], $s['id']]) }}" class="btn-edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/></svg>
                                    Edit Nilai
                                </a>
                            @else
                                <a href="{{ route('guru.rapot.siswa.form', [$classTerm['id'], $s['id']]) }}" class="btn-input">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
                                    Input Nilai
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:40px;color:#a8a29e;font-size:13px;">
                            Belum ada siswa terdaftar di class term ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
