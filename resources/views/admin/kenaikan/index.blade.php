@extends('layouts.app')

@section('title', 'Kenaikan Siswa - SISTEM TK AL-ISTIQOMAH')
@section('page_title', 'Kenaikan Siswa')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@push('styles')
<style>
    .alert-success {
        background: #d1fae5;
        border: 1px solid #34d399;
        color: #065f46;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
    }
    .alert-success svg { flex-shrink: 0; }

    .section-header {
        margin-bottom: 20px;
    }
    .section-header h2 {
        font-size: 15px;
        font-weight: 600;
        color: #3E2723;
        margin: 0 0 4px;
    }
    .section-header p {
        font-size: 13px;
        color: #78716c;
        margin: 0;
    }

    .ct-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 16px;
    }
    .ct-card {
        background: #fff;
        border: 1px solid #e7e5e4;
        border-radius: 10px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        transition: box-shadow 0.2s;
    }
    .ct-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.08); }

    .ct-card__head {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .ct-kelas-badge {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: linear-gradient(135deg, #3D9B72, #2E8B60);
        color: #fff;
        font-size: 16px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .ct-status-pill {
        font-size: 11px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 20px;
        text-transform: capitalize;
    }
    .ct-status-pill--aktif    { background: #d1fae5; color: #065f46; }
    .ct-status-pill--selesai  { background: #f3f4f6; color: #6b7280; }
    .ct-status-pill--menunggu { background: #fef9c3; color: #854d0e; }

    .ct-card__body { font-size: 13px; color: #57534e; line-height: 1.7; }
    .ct-card__body strong { color: #3E2723; }

    .ct-card__footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 8px;
        border-top: 1px solid #f5f5f4;
    }
    .ct-siswa-count {
        font-size: 13px;
        color: #78716c;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .ct-siswa-count svg { width: 15px; height: 15px; fill: #a8a29e; }

    .btn-proses {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, #3D9B72 0%, #2E8B60 100%);
        color: #fff;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.2s;
        box-shadow: 0 2px 8px rgba(61,155,114,0.3);
    }
    .btn-proses:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(61,155,114,0.4); }
    .btn-proses svg { width: 14px; height: 14px; fill: currentColor; }
    .btn-detail {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f3f4f6;
        color: #374151;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-detail:hover { background: #e5e7eb; }
    .btn-detail svg { width: 14px; height: 14px; fill: currentColor; }
    .group-label {
        font-size: 13px;
        font-weight: 600;
        color: #78716c;
        margin: 24px 0 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .group-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e7e5e4;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #a8a29e;
    }
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
        <h2>Semua Class Term</h2>
        <p>Class term dengan status <strong>isPass = true</strong> menampilkan riwayat enrollment per siswa.</p>
    </div>

    @if ($grouped->isEmpty())
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd"/></svg>
            <p>Belum ada class term.</p>
        </div>
    @else
        @foreach ($grouped as $tahunAjaran => $terms)
            <div class="group-label">{{ $tahunAjaran }}</div>
            <div class="ct-grid">
                @foreach ($terms as $ct)
                    <div class="ct-card">
                        <div class="ct-card__head">
                            <div class="ct-kelas-badge">{{ $ct['kelas_nama'] }}</div>
                            <span class="ct-status-pill ct-status-pill--{{ $ct['status'] }}">
                                {{ ucfirst($ct['status']) }}
                            </span>
                        </div>
                        <div class="ct-card__body">
                            <strong>Tahun Ajaran</strong> {{ $ct['tahun_ajaran'] }}<br>
                            <strong>Semester</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ ucfirst($ct['semester']) }}
                        </div>
                        <div class="ct-card__footer">
                            <span class="ct-siswa-count">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 4.8 11.06a.75.75 0 0 1-.231-1.337A60.65 60.65 0 0 1 11.7 2.805Z"/><path d="M6 16.5a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0v-3.75a.75.75 0 0 1 .75-.75Zm9.75 0a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0v-3.75a.75.75 0 0 1 .75-.75Z"/></svg>
                                {{ $ct['jumlah_siswa'] }} siswa
                            </span>

                            @if ($ct['isPass'])
                                <a href="{{ route('admin.kenaikan.detail', $ct['id']) }}" class="btn-detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path fill-rule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clip-rule="evenodd"/></svg>
                                    Lihat Detail
                                </a>
                            @elseif ($ct['status'] === 'aktif')
                                <a href="{{ route('admin.kenaikan.show', $ct['id']) }}" class="btn-proses">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M4.5 5.653c0-1.427 1.529-2.33 2.779-1.643l11.54 6.347c1.295.712 1.295 2.573 0 3.286L7.28 19.99c-1.25.687-2.779-.217-2.779-1.643V5.653Z" clip-rule="evenodd"/></svg>
                                    Proses Kenaikan
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    @endif
@endsection
