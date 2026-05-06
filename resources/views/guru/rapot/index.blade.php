@extends('layouts.app')

@section('title', 'Rapot Semester - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Rapot Semester')

@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

@push('styles')
<style>
    .alert-success {
        background: rgba(76,175,130,0.12); border: 1px solid rgba(76,175,130,0.3); color: #2E8B60;
        padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;
        display: flex; align-items: center; gap: 8px; font-size: 14px;
    }

    .section-header { margin-bottom: 20px; }
    .section-header h2 { font-size: 15px; font-weight: 600; color: #3E2723; margin: 0 0 4px; }
    .section-header p  { font-size: 13px; color: #78716c; margin: 0; }

    .ta-group { margin-bottom: 28px; }
    .ta-group__label {
        font-size: 13px; font-weight: 600; color: #3E2723;
        margin: 0 0 10px;
        display: flex; align-items: center; gap: 8px;
    }
    .ta-group__label svg { width: 14px; height: 14px; fill: #3D9B72; }
    .ta-group__count {
        background: rgba(62,39,35,0.08); color: #5D4037;
        border-radius: 99px; padding: 1px 9px;
        font-size: 11px; font-weight: 600;
    }

    .rapot-card {
        background: #fff; border: 1px solid #e7e5e4;
        border-radius: 10px; overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

    .rapot-table {
        width: 100%;
        border-collapse: collapse;
    }
    .rapot-table thead tr {
        background: #f9fafb;
        border-bottom: 1px solid #e7e5e4;
    }
    .rapot-table th {
        padding: 12px 16px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: #6b7280;
        text-align: left;
        white-space: nowrap;
    }
    .rapot-table td {
        padding: 14px 16px;
        font-size: 13px;
        color: #3E2723;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }
    .rapot-table tbody tr:last-child td { border-bottom: none; }
    .rapot-table tbody tr:hover td { background: #fafafa; }

    .rapot-table .row-no { color: #a8a29e; font-size: 12px; font-weight: 500; }

    .ct-kelas-badge {
        width: 38px; height: 38px; border-radius: 9px;
        background: linear-gradient(135deg, #3D9B72, #2E8B60);
        color: #fff; font-size: 13px; font-weight: 700;
        display: inline-flex; align-items: center; justify-content: center;
    }

    .semester-pill {
        display: inline-block;
        font-size: 11px; font-weight: 600;
        padding: 3px 10px; border-radius: 99px;
        text-transform: capitalize;
    }
    .semester-pill--ganjil { background: #FFF176; color: #5D4037; }
    .semester-pill--genap  { background: rgba(76,175,130,0.15); color: #2E8B60; }

    .ct-status-pill {
        font-size: 11px; font-weight: 600; padding: 3px 10px;
        border-radius: 99px; text-transform: capitalize;
    }
    .ct-status-pill--aktif    { background: rgba(76,175,130,0.15); color: #2E8B60; }
    .ct-status-pill--selesai  { background: rgba(62,39,35,0.08); color: #5D4037; }
    .ct-status-pill--menunggu { background: #FFF176; color: #5D4037; }

    .progress-cell { min-width: 180px; }
    .progress-cell__label {
        font-size: 11px; color: #78716c;
        margin-bottom: 4px;
        display: flex; justify-content: space-between;
    }
    .progress-bar {
        height: 6px; background: #e7e5e4; border-radius: 99px; overflow: hidden;
    }
    .progress-bar__fill {
        height: 100%; background: linear-gradient(90deg, #3D9B72, #2E8B60);
        border-radius: 99px; transition: width 0.4s;
    }

    .ct-siswa-count {
        font-size: 12px; color: #57534e;
        display: inline-flex; align-items: center; gap: 5px;
    }
    .ct-siswa-count svg { width: 13px; height: 13px; fill: #a8a29e; }

    .btn-input {
        display: inline-flex; align-items: center; gap: 6px;
        background: linear-gradient(135deg, #3D9B72 0%, #2E8B60 100%);
        color: #fff; padding: 7px 14px; font-size: 12px; font-weight: 600;
        border-radius: 7px; text-decoration: none; transition: all 0.2s;
        box-shadow: 0 2px 6px rgba(61,155,114,0.2);
    }
    .btn-input:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(61,155,114,0.3); }
    .btn-input svg { width: 12px; height: 12px; fill: currentColor; }

    .empty-state { text-align: center; padding: 60px 20px; color: #a8a29e; }
    .empty-state svg { width: 48px; height: 48px; fill: #d6d3d1; margin-bottom: 12px; }
    .empty-state p { font-size: 14px; margin: 0; }
</style>
@endpush

@section('content')
    @if (session('success'))
        <div class="alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="section-header">
        <h2>Pilih Class Term</h2>
        <p>Pilih class term untuk mulai mengisi atau melihat rapot semester siswa.</p>
    </div>

    @if ($grouped->isEmpty())
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" clip-rule="evenodd"/></svg>
            <p>Belum ada class term tersedia.</p>
        </div>
    @else
        @foreach ($grouped as $tahunAjaran => $terms)
            <div class="ta-group">
                <div class="ta-group__label">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
                    Tahun Ajaran {{ $tahunAjaran }}
                    <span class="ta-group__count">{{ count($terms) }} class term</span>
                </div>

                <div class="rapot-card">
                    <table class="rapot-table">
                        <thead>
                            <tr>
                                <th style="width:50px;">No</th>
                                <th style="width:90px;">Kelas</th>
                                <th>Semester</th>
                                <th>Status</th>
                                <th>Total Siswa</th>
                                <th>Progres Rapot</th>
                                <th style="width:110px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($terms as $i => $ct)
                                @php
                                    $pct = $ct['total_siswa'] > 0 ? round(($ct['sudah_rapot'] / $ct['total_siswa']) * 100) : 0;
                                @endphp
                                <tr>
                                    <td class="row-no">{{ $i + 1 }}</td>
                                    <td><div class="ct-kelas-badge">{{ $ct['kelas_nama'] }}</div></td>
                                    <td>
                                        <span class="semester-pill semester-pill--{{ strtolower($ct['semester']) }}">
                                            {{ ucfirst($ct['semester']) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="ct-status-pill ct-status-pill--{{ $ct['status'] }}">
                                            {{ ucfirst($ct['status']) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="ct-siswa-count">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 4.8 11.06a.75.75 0 0 1-.231-1.337A60.65 60.65 0 0 1 11.7 2.805Z"/><path d="M6 16.5a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0v-3.75a.75.75 0 0 1 .75-.75Zm9.75 0a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0v-3.75a.75.75 0 0 1 .75-.75Z"/></svg>
                                            {{ $ct['total_siswa'] }} siswa
                                        </span>
                                    </td>
                                    <td>
                                        <div class="progress-cell">
                                            <div class="progress-cell__label">
                                                <span>{{ $ct['sudah_rapot'] }}/{{ $ct['total_siswa'] }} siswa</span>
                                                <span><strong>{{ $pct }}%</strong></span>
                                            </div>
                                            <div class="progress-bar">
                                                <div class="progress-bar__fill" style="width: {{ $pct }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('guru.rapot.show', $ct['id']) }}" class="btn-input">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M4.5 5.653c0-1.427 1.529-2.33 2.779-1.643l11.54 6.347c1.295.712 1.295 2.573 0 3.286L7.28 19.99c-1.25.687-2.779-.217-2.779-1.643V5.653Z" clip-rule="evenodd"/></svg>
                                            Buka
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endif
@endsection
