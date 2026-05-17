@extends('layouts.app')

@section('title', 'Proses Kenaikan - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Proses Kenaikan Siswa')

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
        background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
        color: #fff;
        font-size: 18px;
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
    .semester-pill--ganjil  { background: #FFF176; color: #5D4037; }
    .semester-pill--genap   { background: rgba(76,175,130,0.15); color: #2E8B60; }
    .semester-pill--menunggu{ background: rgba(62,39,35,0.08); color: #5D4037; }

    .notice-box {
        background: #FFF176;
        border: 1px solid #e6db00;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 20px;
        font-size: 13px;
        color: #5D4037;
        display: flex;
        align-items: flex-start;
        gap: 8px;
    }
    .notice-box svg { flex-shrink: 0; margin-top: 1px; }

    .siswa-table-wrap {
        background: #fff;
        border: 1px solid #e7e5e4;
        border-radius: 10px;
        overflow: auto;
        margin-bottom: 24px;
    }
    .siswa-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
        min-width: 700px;
    }
    .siswa-table thead th {
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
    .siswa-table tbody td {
        padding: 12px 16px;
        color: #3E2723;
        border-bottom: 1px solid #f5f5f4;
        vertical-align: middle;
    }
    .siswa-table tbody tr:last-child td { border-bottom: none; }
    .siswa-table tbody tr:hover { background: #fafaf9; }

    .gender-badge {
        display: inline-block;
        font-size: 11px;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 12px;
    }
    .gender-badge--l { background: rgba(76,175,130,0.15); color: #2E8B60; }
    .gender-badge--p { background: rgba(240,98,146,0.12); color: #d81b72; }

    .td-select {
        padding: 8px 10px;
        border: 1px solid #e7e5e4;
        border-radius: 6px;
        font-size: 13px;
        color: #3E2723;
        background: #FFFDE7;
        font-family: inherit;
        cursor: pointer;
        transition: all 0.2s;
        width: 100%;
    }
    .td-select:focus {
        outline: none;
        border-color: #3D9B72;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(61,155,114,0.1);
    }
    .td-aksi  { min-width: 175px; }
    .td-tujuan{ min-width: 240px; }

    .btn-row { display: flex; gap: 12px; align-items: center; }
    .btn-simpan {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
        color: #fff;
        padding: 10px 24px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        border-radius: 8px;
        box-shadow: 0 4px 14px rgba(61,155,114,0.3);
        transition: all 0.3s;
    }
    .btn-simpan:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(61,155,114,0.4); }
    .btn-simpan svg { width: 16px; height: 16px; fill: currentColor; }
    .btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f5f5f4;
        color: #57534e;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 500;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        transition: background 0.2s;
    }
    .btn-cancel:hover { background: #e7e5e4; }
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
            <p>{{ $siswaList->count() }} siswa terdaftar &nbsp;·&nbsp; Semester <strong>{{ ucfirst($classTerm['semester']) }}</strong></p>
        </div>
        <span class="semester-pill semester-pill--{{ $classTerm['semester'] }}">{{ ucfirst($classTerm['semester']) }}</span>
    </div>

    <div class="notice-box">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="16" height="16">
            <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd"/>
        </svg>
        Pilih aksi dan class term tujuan untuk setiap siswa. Setelah disimpan, class term ini akan berubah menjadi <strong>Selesai</strong>.
    </div>

    @if ($classTermOptions->isEmpty())
    <div style="background:#fff;border:1px solid #fde68a;border-radius:10px;padding:20px 24px;margin-bottom:20px;display:flex;align-items:flex-start;gap:14px;">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#f59e0b" width="22" height="22" style="flex-shrink:0;margin-top:1px;">
            <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd"/>
        </svg>
        <div>
            <div style="font-size:14px;font-weight:600;color:#92400e;margin-bottom:4px;">Belum ada Class Term tujuan</div>
            <div style="font-size:13px;color:#78716c;line-height:1.6;">
                Untuk memproses kenaikan, Anda perlu membuat <strong>Class Term baru</strong> sebagai tujuan siswa terlebih dahulu.<br>
                Contoh: buat tahun ajaran <em>semester berikutnya</em> lalu tambahkan kelas ke dalamnya.
            </div>
            <a href="{{ route('admin.tahun_ajaran.index') }}"
               style="display:inline-flex;align-items:center;gap:6px;margin-top:12px;background:#f59e0b;color:#fff;padding:7px 16px;border-radius:7px;font-size:13px;font-weight:600;text-decoration:none;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="14" height="14"><path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/></svg>
                Buat Class Term Baru
            </a>
        </div>
    </div>
    @endif

    <form action="{{ route('admin.kenaikan.proses', $classTerm['id']) }}" method="POST">
        @csrf

        <div class="siswa-table-wrap">
            <table class="siswa-table">
                <thead>
                    <tr>
                        <th style="width:36px;">No</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th>L/P</th>
                        <th class="td-aksi">Aksi</th>
                        <th class="td-tujuan">Class Term Selanjutnya</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($siswaList as $i => $siswa)
                        <tr>
                            <td style="color:#a8a29e;">{{ $i + 1 }}</td>
                            <td><strong>{{ $siswa['nama'] }}</strong></td>
                            <td style="color:#78716c; font-size:13px;">{{ $siswa['nis'] }}</td>
                            <td>
                                <span class="gender-badge gender-badge--{{ strtolower($siswa['gender']) }}">
                                    {{ $siswa['gender'] === 'L' ? 'L' : 'P' }}
                                </span>
                            </td>
                            <td>
                                <input type="hidden" name="siswa[{{ $i }}][student_id]" value="{{ $siswa['student_id'] }}">
                                <select name="siswa[{{ $i }}][aksi]" class="td-select" required>
                                    <option value="" disabled selected>-- Pilih --</option>
                                    <option value="ganti_semester">Ganti Semester</option>
                                    <option value="ganti_kelas">Ganti Kelas</option>
                                    <option value="tinggal_kelas">Tinggal Kelas</option>
                                </select>
                            </td>
                            <td>
                                <select name="siswa[{{ $i }}][class_term_tujuan_id]" class="td-select" required>
                                    <option value="" disabled selected>-- Pilih Class Term --</option>
                                    @foreach ($classTermOptions as $ct)
                                        <option value="{{ $ct['id'] }}">
                                            {{ $ct['kelas_nama'] }} — {{ $ct['tahun_ajaran'] }} {{ ucfirst($ct['semester']) }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; color:#a8a29e; padding:32px;">
                                Tidak ada siswa terdaftar di class term ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($siswaList->isNotEmpty())
            <div class="btn-row">
                <button type="submit" class="btn-simpan">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd"/></svg>
                    Simpan & Tutup Class Term
                </button>
                <a href="{{ route('admin.kenaikan.index') }}" class="btn-cancel">Batal</a>
            </div>
        @endif
    </form>
@endsection
