@extends('layouts.app')

@section('title', 'Detail Enrollment - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Detail Enrollment Siswa')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@push('styles')
<style>
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #5D4037;
        font-size: 14px;
        text-decoration: none;
        margin-bottom: 16px;
        transition: color 0.2s;
    }
    .back-link:hover { color: #3D9B72; }
    .back-link svg { width: 16px; height: 16px; fill: currentColor; }

    .info-banner {
        background: #fff;
        border: 1px solid #e7e5e4;
        border-radius: 10px;
        padding: 16px 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }
    .info-banner__kelas {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        background: #f3f4f6;
        color: #6b7280;
        font-size: 16px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .info-banner__details { flex: 1; }
    .info-banner__details h3 { font-size: 15px; font-weight: 600; color: #3E2723; margin: 0 0 4px; }
    .info-banner__details p  { font-size: 13px; color: #78716c; margin: 0; }
    .semester-pill {
        font-size: 12px;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 20px;
    }
    .semester-pill--ganjil { background: #fef9c3; color: #854d0e; }
    .semester-pill--genap  { background: #dbeafe; color: #1e40af; }
    .ispass-pill {
        font-size: 11px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 20px;
        background: #f3f4f6;
        color: #6b7280;
    }

    .table-wrap {
        background: #fff;
        border: 1px solid #e7e5e4;
        border-radius: 10px;
        overflow: hidden;
    }
    .enrollment-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }
    .enrollment-table thead th {
        background: #f5f5f4;
        color: #57534e;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        padding: 11px 16px;
        text-align: left;
        border-bottom: 1px solid #e7e5e4;
        white-space: nowrap;
    }
    .enrollment-table tbody td {
        padding: 13px 16px;
        color: #3E2723;
        border-bottom: 1px solid #f5f5f4;
        vertical-align: middle;
    }
    .enrollment-table tbody tr:last-child td { border-bottom: none; }
    .enrollment-table tbody tr:hover { background: #fafaf9; }

    .gender-badge {
        display: inline-block;
        font-size: 11px;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 12px;
    }
    .gender-badge--l { background: #dbeafe; color: #1e40af; }
    .gender-badge--p { background: #fce7f3; color: #9d174d; }

    .aksi-badge {
        display: inline-block;
        font-size: 12px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 20px;
    }
    .aksi-badge--ganti_semester { background: #dbeafe; color: #1e40af; }
    .aksi-badge--ganti_kelas    { background: #d1fae5; color: #065f46; }
    .aksi-badge--tinggal_kelas  { background: #fef3c7; color: #92400e; }

    .enrollment-status {
        font-size: 11px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 12px;
        background: #f3f4f6;
        color: #6b7280;
        text-transform: capitalize;
    }

    .empty-state {
        text-align: center;
        padding: 48px 20px;
        color: #a8a29e;
    }
    .empty-state svg { width: 40px; height: 40px; fill: #d6d3d1; margin-bottom: 10px; }
    .empty-state p { font-size: 14px; margin: 0; }
</style>
@endpush

@section('content')
    <a href="{{ route('admin.kenaikan.index') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M7.28 7.72a.75.75 0 0 1 0 1.06l-2.47 2.47H21a.75.75 0 0 1 0 1.5H4.81l2.47 2.47a.75.75 0 1 1-1.06 1.06l-3.75-3.75a.75.75 0 0 1 0-1.06l3.75-3.75a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/>
        </svg>
        Kembali ke Daftar Class Term
    </a>

    <div class="info-banner">
        <div class="info-banner__kelas">{{ $classTerm['kelas_nama'] }}</div>
        <div class="info-banner__details">
            <h3>Kelas {{ $classTerm['kelas_nama'] }} — {{ $classTerm['tahun_ajaran'] }}</h3>
            <p>
                <span class="semester-pill semester-pill--{{ $classTerm['semester'] }}">{{ ucfirst($classTerm['semester']) }}</span>
                &nbsp;·&nbsp; {{ count($history) }} siswa tercatat
            </p>
        </div>
        <span class="ispass-pill">isPass: true</span>
    </div>

    <div class="table-wrap">
        @if (count($history) === 0)
            <div class="empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875Z" clip-rule="evenodd"/></svg>
                <p>Tidak ada data enrollment untuk class term ini.</p>
            </div>
        @else
            <table class="enrollment-table">
                <thead>
                    <tr>
                        <th style="width:36px;">No</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th>NISN</th>
                        <th>L/P</th>
                        <th>Status Enrollment</th>
                        <th>Aksi</th>
                        <th>Class Term Tujuan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($history as $i => $row)
                        @php
                            $aksiLabel = [
                                'ganti_semester' => 'Ganti Semester',
                                'ganti_kelas'    => 'Ganti Kelas',
                                'tinggal_kelas'  => 'Tinggal Kelas',
                            ][$row['aksi']] ?? $row['aksi'];
                        @endphp
                        <tr>
                            <td style="color:#a8a29e;">{{ $i + 1 }}</td>
                            <td><strong>{{ $row['siswa_nama'] }}</strong></td>
                            <td style="color:#78716c; font-size:13px;">{{ $row['nis'] }}</td>
                            <td style="color:#78716c; font-size:13px;">{{ $row['nisn'] }}</td>
                            <td>
                                <span class="gender-badge gender-badge--{{ strtolower($row['gender']) }}">
                                    {{ $row['gender'] === 'L' ? 'L' : 'P' }}
                                </span>
                            </td>
                            <td>
                                <span class="enrollment-status">{{ $row['enrollment_status'] }}</span>
                            </td>
                            <td>
                                <span class="aksi-badge aksi-badge--{{ $row['aksi'] }}">{{ $aksiLabel }}</span>
                            </td>
                            <td style="color:#57534e;">
                                → {{ $row['class_term_tujuan'] }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
