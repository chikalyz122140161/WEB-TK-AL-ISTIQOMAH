@extends('layouts.app')

@section('title', 'Laporan Perkembangan - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Laporan Perkembangan Siswa')

@push('styles')
    <style>
        .lp-filter {
            background: #fff;
            border: 1px solid var(--border, #e7e5e4);
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 16px;
            box-shadow: var(--shadow-xs, 0 1px 3px rgba(0, 0, 0, 0.04));
        }

        .lp-filter-grid {
            flex-wrap: wrap;
            display: flex;
            gap: 8px;
            gap: 12px;
            align-items: end;
        }

        .lp-field {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .lp-field__label {
            font-size: 11px;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .lp-select {
            padding: 9px 13px;
            font-size: 13px;
            border: 1px solid #e7e5e4;
            border-radius: 7px;
            background: #fff;
            color: #3E2723;
            outline: none;
            cursor: pointer;
            font-family: inherit;
            transition: border-color .15s;
            appearance: none;
            width: 100%;
        }

        .lp-select:focus {
            border-color: #3D9B72;
            box-shadow: 0 0 0 3px rgba(61, 155, 114, 0.12);
        }

        .lp-btn {
            background: linear-gradient(135deg, #3D9B72 0%, #2E8B60 100%);
            color: #fff;
            border: none;
            padding: 10px 22px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            font-family: inherit;
            box-shadow: 0 2px 6px rgba(61, 155, 114, 0.25);
            transition: all .15s;
            white-space: nowrap;
        }

        .lp-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(61, 155, 114, 0.35);
        }

        .lp-btn--ghost {
            background: #FFF176;
            color: #5D4037;
            border: 1px solid #e6db00;
            box-shadow: none;
        }

        .lp-btn--ghost:hover {
            background: #f9ed50;
        }

        .lp-card {
            background: #fff;
            border: 1px solid #e7e5e4;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .lp-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .lp-table thead tr {
            background: linear-gradient(135deg, #3D9B72 0%, #2E8B60 100%);
        }

        .lp-table th {
            color: #fff;
            padding: 14px 16px;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
            white-space: nowrap;
        }

        .lp-table td {
            padding: 14px 16px;
            border-bottom: 1px solid #f3f4f6;
            color: #3E2723;
            vertical-align: middle;
        }

        .lp-table tbody tr:last-child td {
            border-bottom: none;
        }

        .lp-table tbody tr:hover td {
            background: #fafafa;
        }

        .lp-row-no {
            color: #9ca3af;
            font-size: 12px;
            font-weight: 500;
        }

        .lp-pill {
            display: inline-flex;
            align-items: center;
            background: rgba(76, 175, 130, 0.12);
            color: #2E8B60;
            border-radius: 99px;
            padding: 3px 10px;
            font-size: 11px;
            font-weight: 600;
            border: 1px solid rgba(76, 175, 130, 0.3);
        }

        .lp-pill--kelas {
            background: #FFFDE7;
            color: #5D4037;
            border-color: #e6db00;
        }

        .lp-pill--week {
            background: #FFF176;
            color: #5D4037;
            border-color: #e6db00;
        }

        .lp-rata {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            color: #3E2723;
        }

        .lp-rata__bar {
            width: 60px;
            height: 5px;
            background: #f3f4f6;
            border-radius: 99px;
            overflow: hidden;
        }

        .lp-rata__bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #3D9B72, #2E8B60);
            border-radius: 99px;
        }

        .lp-aksi {
            display: flex;
            gap: 6px;
            flex-wrap: nowrap;
            align-items: center;
        }

        .lp-aksi a {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 11px;
            font-size: 11px;
            font-weight: 600;
            border-radius: 6px;
            text-decoration: none;
            transition: all .15s;
        }

        .lp-aksi__view {
            background: rgba(76, 175, 130, 0.12);
            color: #2E8B60;
            border: 1px solid rgba(76, 175, 130, 0.3);
        }

        .lp-aksi__view:hover {
            background: rgba(76, 175, 130, 0.2);
        }

        .lp-aksi__edit {
            background: #FFF176;
            color: #3E2723;
            border: 1.5px solid #e6db00;
            font-weight: 700;
        }

        .lp-aksi__edit:hover {
            background: #f5e800;
            transform: translateY(-1px);
        }

        .lp-empty {
            padding: 50px 20px;
            text-align: center;
            color: #9ca3af;
            font-size: 13px;
        }

        .lp-info {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 12px;
        }
    </style>
@endpush

@section('sidebar')
    @include('guru.partials.sidebar')
@endsection

@section('content')

    @if (session('success'))
        <div
            style="background:rgba(76,175,130,0.12);border:1px solid rgba(76,175,130,0.3);color:#2E8B60;padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:13px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter --}}
    <form method="GET" action="{{ route('guru.laporan_bk') }}" class="lp-filter">
        <div class="lp-filter-grid">
            <div class="lp-field">
                <label class="lp-field__label">Class Term (Kelas & Semester)</label>
                <select class="lp-select" name="class_term_id">
                    <option value="">Semua Class Term</option>
                    @foreach ($classTerms as $ct)
                        <option value="{{ $ct['id'] }}"
                            {{ ($filters['class_term_id'] ?? '') === $ct['id'] ? 'selected' : '' }}>
                            {{ $ct['label'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="lp-field">
                <label class="lp-field__label">Minggu</label>
                <select class="lp-select" name="minggu">
                    <option value="">Semua Minggu</option>
                    @foreach ($weeks as $w)
                        <option value="{{ $w }}"
                            {{ (string) ($filters['minggu'] ?? '') === (string) $w ? 'selected' : '' }}>
                            Minggu {{ $w }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="lp-field" style="flex-direction:row;gap:8px;padding-bottom:1px;">
                <button type="submit" class="lp-btn">Filter</button>
                <a href="{{ route('guru.laporan_bk') }}" class="lp-btn lp-btn--ghost"
                    style="padding:10px 18px;text-decoration:none;display:inline-flex;align-items:center;">Reset</a>
            </div>
        </div>
    </form>

    {{-- Table --}}
    <div class="lp-card">
        @if (count($laporan) === 0)
            <div class="lp-empty">Belum ada data laporan untuk filter yang dipilih.</div>
        @else
        <div style="overflow-x:auto;">
            <table class="lp-table">
                <thead>
                    <tr>
                        <th style="width:50px;">No</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Semester</th>
                        <th>Minggu</th>
                        <th>Tanggal</th>
                        <th>Rata-rata</th>
                        <th style="width:160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($laporan as $i => $row)
                        @php
                            $pct = $row['rata_rata'] > 0 ? round(($row['rata_rata'] / 4) * 100) : 0;
                        @endphp
                        <tr>
                            <td class="lp-row-no">{{ $i + 1 }}</td>
                            <td style="font-weight:600;">{{ $row['student_name'] }}</td>
                            <td><span class="lp-pill lp-pill--kelas">{{ $row['kelas'] }}</span></td>
                            <td style="font-size:12px;color:#6b7280;">{{ $row['semester'] }}</td>
                            <td><span class="lp-pill lp-pill--week">Minggu {{ $row['week'] }}</span></td>
                            <td>{{ $row['tanggal_label'] }}</td>
                            <td>
                                <div class="lp-rata">
                                    <span>{{ number_format($row['rata_rata'], 1) }}</span>
                                    <div class="lp-rata__bar">
                                        <div class="lp-rata__bar-fill" style="width:{{ $pct }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="lp-aksi">
                                    <a href="{{ route('guru.laporan_bk.show', $row['report_id']) }}?week={{ $row['week'] }}"
                                        class="lp-aksi__view">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            width="13" height="13">
                                            <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                            <path fill-rule="evenodd"
                                                d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Lihat
                                    </a>
                                    <a href="{{ route('guru.laporan_bk.edit', $row['report_id']) }}?week={{ $row['week'] }}"
                                        class="lp-aksi__edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            width="13" height="13">
                                            <path
                                                d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                                        </svg>
                                        Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

@endsection
