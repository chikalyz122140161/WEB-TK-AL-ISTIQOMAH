@extends('layouts.app')

@section('title', 'Riwayat Kenaikan - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Riwayat Kenaikan Siswa')

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
    .info-banner__icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .info-banner__icon svg { width: 22px; height: 22px; fill: #6b7280; }
    .info-banner__details { flex: 1; }
    .info-banner__details h3 { font-size: 15px; font-weight: 600; color: #3E2723; margin: 0 0 4px; }
    .info-banner__details p  { font-size: 13px; color: #78716c; margin: 0; }
    .status-pill-selesai {
        display: inline-block;
        background: #f3f4f6;
        color: #6b7280;
        font-size: 12px;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 20px;
    }
    .semester-pill {
        display: inline-block;
        border-radius: 99px;
        padding: .25rem .8rem;
        font-size: .8rem;
        font-weight: 600;
    }
    .semester-pill--ganjil { background: #fef3c7; color: #92400e; }
    .semester-pill--genap  { background: #dbeafe; color: #1e40af; }

    .riwayat-table-wrap {
        background: #fff;
        border: 1px solid #e7e5e4;
        border-radius: 10px;
        overflow: hidden;
    }
    .riwayat-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }
    .riwayat-table thead th {
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
    .riwayat-table tbody td {
        padding: 13px 16px;
        color: #3E2723;
        border-bottom: 1px solid #f5f5f4;
        vertical-align: middle;
    }
    .riwayat-table tbody tr:last-child td { border-bottom: none; }
    .riwayat-table tbody tr:hover { background: #fafaf9; }

    .kelas-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: linear-gradient(135deg, #3D9B72, #2E8B60);
        color: #fff;
        font-size: 12px;
        font-weight: 700;
    }

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

    .arrow-icon { color: #a8a29e; font-size: 16px; }

    .empty-state {
        text-align: center;
        padding: 48px 20px;
        color: #a8a29e;
    }
    .empty-state svg { width: 40px; height: 40px; fill: #d6d3d1; margin-bottom: 10px; }
    .empty-state p { font-size: 14px; margin: 0; }

    .aksi-label {
        ganti_semester: 'Ganti Semester';
    }
</style>
@endpush

@section('content')
    <a href="{{ route('admin.tahun_ajaran.index') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M7.28 7.72a.75.75 0 0 1 0 1.06l-2.47 2.47H21a.75.75 0 0 1 0 1.5H4.81l2.47 2.47a.75.75 0 1 1-1.06 1.06l-3.75-3.75a.75.75 0 0 1 0-1.06l3.75-3.75a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/>
        </svg>
        Kembali ke Daftar Tahun Ajaran
    </a>

    <div class="info-banner">
        <div class="info-banner__icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd"/></svg>
        </div>
        <div class="info-banner__details">
            <h3>Riwayat Kenaikan — {{ $item['tahun_ajaran'] }}</h3>
            <p>
                <span class="semester-pill semester-pill--{{ $item['semester'] }}">{{ ucfirst($item['semester']) }}</span>
                &nbsp;·&nbsp; {{ count($riwayat) }} perubahan tercatat
            </p>
        </div>
        <span class="status-pill-selesai">Selesai</span>
    </div>

    <div class="riwayat-table-wrap">
        @if (count($riwayat) === 0)
            <div class="empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875Zm5.845 17.03a.75.75 0 0 0 1.06 0l3-3a.75.75 0 1 0-1.06-1.06l-1.72 1.72V12a.75.75 0 0 0-1.5 0v4.19l-1.72-1.72a.75.75 0 0 0-1.06 1.06l3 3Z" clip-rule="evenodd"/></svg>
                <p>Belum ada riwayat kenaikan untuk tahun ajaran ini.</p>
            </div>
        @else
            <table class="riwayat-table">
                <thead>
                    <tr>
                        <th style="width:36px;">No</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th>Kelas Asal</th>
                        <th>Aksi</th>
                        <th>Class Term Tujuan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($riwayat as $i => $row)
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
                            <td><span class="kelas-badge">{{ $row['kelas_asal'] }}</span></td>
                            <td>
                                <span class="aksi-badge aksi-badge--{{ $row['aksi'] }}">{{ $aksiLabel }}</span>
                            </td>
                            <td style="color:#57534e;">
                                <span class="arrow-icon">→</span>
                                {{ $row['class_term_tujuan'] }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
