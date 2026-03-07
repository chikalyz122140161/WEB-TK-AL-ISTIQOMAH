@extends('layouts.app')

@section('title', 'Dashboard Orang Tua - SISTEM BK TK AL-ISTIQOMAH')
@section('page_title', 'Dashboard Orang Tua')

{{-- SIDEBAR --}}
@section('sidebar')
    @include('orangtua.partials.sidebar')
@endsection

{{-- CONTENT --}}
@section('content')

@push('styles')
<style>
    .section-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 2px solid #faae2b;
    }
    .section-header__icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #faae2b 0%, #f5a623 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .section-header__icon svg {
        width: 22px;
        height: 22px;
        fill: #00473e;
    }
    .section-header__text h2 {
        font-size: 18px;
        font-weight: 700;
        color: #00473e;
        margin: 0;
    }
    .section-header__text p {
        font-size: 13px;
        color: #475d5b;
        margin: 2px 0 0;
    }
    .section-wrapper {
        margin-bottom: 32px;
    }

    /* Info Card for Child Profile */
    .child-profile-card {
        background: linear-gradient(135deg, #00473e 0%, #006b5a 100%);
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
        color: #fff;
    }
    .child-profile-card__header {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .child-profile-card__avatar {
        width: 72px;
        height: 72px;
        background: linear-gradient(135deg, #faae2b 0%, #f5a623 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 700;
        color: #00473e;
    }
    .child-profile-card__info h3 {
        font-size: 20px;
        font-weight: 700;
        margin: 0 0 4px;
    }
    .child-profile-card__info p {
        font-size: 14px;
        opacity: 0.85;
        margin: 0;
    }
    .child-profile-card__stats {
        display: flex;
        gap: 32px;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid rgba(255,255,255,0.2);
    }
    .child-profile-card__stat {
        text-align: center;
    }
    .child-profile-card__stat-value {
        font-size: 24px;
        font-weight: 700;
        color: #faae2b;
    }
    .child-profile-card__stat-label {
        font-size: 12px;
        opacity: 0.85;
        margin-top: 2px;
    }

    /* Quick Actions */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    @media (max-width: 1024px) {
        .quick-actions { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .quick-actions { grid-template-columns: 1fr; }
    }
    .quick-action-card {
        background: #fff;
        border: 1px solid #00473e20;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
    }
    .quick-action-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,71,62,0.1);
        border-color: #faae2b;
    }
    .quick-action-card__icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #faae2b20 0%, #f5a62320 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
    }
    .quick-action-card__icon svg {
        width: 24px;
        height: 24px;
        fill: #faae2b;
    }
    .quick-action-card__title {
        font-size: 14px;
        font-weight: 600;
        color: #00473e;
        margin-bottom: 4px;
    }
    .quick-action-card__desc {
        font-size: 12px;
        color: #475d5b;
    }

    /* Recent Activity */
    .activity-list {
        background: #fff;
        border: 1px solid #00473e20;
        border-radius: 8px;
        overflow: hidden;
    }
    .activity-item {
        padding: 16px 20px;
        border-bottom: 1px solid #00473e10;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }
    .activity-item:last-child {
        border-bottom: none;
    }
    .activity-item__icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .activity-item__icon--report {
        background: #EFF6FF;
    }
    .activity-item__icon--report svg {
        fill: #1D4ED8;
    }
    .activity-item__icon--attendance {
        background: #ECFDF5;
    }
    .activity-item__icon--attendance svg {
        fill: #047857;
    }
    .activity-item__icon--chat {
        background: #FFF7ED;
    }
    .activity-item__icon--chat svg {
        fill: #C2410C;
    }
    .activity-item__icon svg {
        width: 18px;
        height: 18px;
    }
    .activity-item__content {
        flex: 1;
    }
    .activity-item__title {
        font-size: 14px;
        font-weight: 500;
        color: #00473e;
        margin-bottom: 2px;
    }
    .activity-item__desc {
        font-size: 13px;
        color: #475d5b;
    }
    .activity-item__time {
        font-size: 12px;
        color: #475d5b;
        white-space: nowrap;
    }
</style>
@endpush

    {{-- CHILD PROFILE CARD --}}
    <div class="child-profile-card">
        <div class="child-profile-card__header">
            <div class="child-profile-card__avatar">
                {{ substr($student->nama ?? 'Ahmad Fauzi', 0, 1) }}
            </div>
            <div class="child-profile-card__info">
                <h3>{{ $student->nama ?? 'Ahmad Fauzi' }}</h3>
                <p>Kelas: {{ $student->kelas ?? 'TK A' }} | Tahun Ajaran: {{ $student->tahun_ajaran ?? '2024/2025' }}</p>
            </div>
        </div>
        <div class="child-profile-card__stats">
            <div class="child-profile-card__stat">
                <div class="child-profile-card__stat-value">{{ $kehadiranBulanIni ?? 18 }}</div>
                <div class="child-profile-card__stat-label">Hadir Bulan Ini</div>
            </div>
            <div class="child-profile-card__stat">
                <div class="child-profile-card__stat-value">{{ $totalReport ?? 12 }}</div>
                <div class="child-profile-card__stat-label">Report Tersedia</div>
            </div>
            <div class="child-profile-card__stat">
                <div class="child-profile-card__stat-value">{{ $avgScore ?? '4.2' }}</div>
                <div class="child-profile-card__stat-label">Rata-rata Nilai</div>
            </div>
            <div class="child-profile-card__stat">
                <div class="child-profile-card__stat-value">{{ $pesanBaru ?? 2 }}</div>
                <div class="child-profile-card__stat-label">Pesan Baru</div>
            </div>
        </div>
    </div>

    {{-- QUICK ACTIONS --}}
    <div class="section-wrapper">
        <div class="section-header">
            <div class="section-header__icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h12a3 3 0 0 1 3 3v12a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm4.5 7.5a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-1.5 0v-2.25a.75.75 0 0 1 .75-.75Zm3.75-1.5a.75.75 0 0 0-1.5 0v4.5a.75.75 0 0 0 1.5 0V12Zm2.25-3a.75.75 0 0 1 .75.75v6.75a.75.75 0 0 1-1.5 0V9.75A.75.75 0 0 1 13.5 9Zm3.75-1.5a.75.75 0 0 0-1.5 0v9a.75.75 0 0 0 1.5 0v-9Z" clip-rule="evenodd"/></svg>
            </div>
            <div class="section-header__text">
                <h2>Akses Cepat</h2>
                <p>Menu yang sering digunakan</p>
            </div>
        </div>

        <div class="quick-actions">
            <a href="{{ route('orangtua.presensi') }}" class="quick-action-card">
                <div class="quick-action-card__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h3A1.5 1.5 0 0 0 13.5 3ZM3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z" clip-rule="evenodd"/></svg>
                </div>
                <div class="quick-action-card__title">Lihat Presensi</div>
                <div class="quick-action-card__desc">Cek kehadiran anak</div>
            </a>

            <a href="{{ route('orangtua.laporan') }}" class="quick-action-card">
                <div class="quick-action-card__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd"/><path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z"/></svg>
                </div>
                <div class="quick-action-card__title">Lihat Laporan</div>
                <div class="quick-action-card__desc">Laporan perkembangan anak</div>
            </a>

            <a href="{{ route('orangtua.jadwal') }}" class="quick-action-card">
                <div class="quick-action-card__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3a.75.75 0 0 1 1.5 0v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd"/></svg>
                </div>
                <div class="quick-action-card__title">Lihat Jadwal</div>
                <div class="quick-action-card__desc">Jadwal kegiatan sekolah</div>
            </a>


    {{-- RECENT ACTIVITY --}}
    <div class="section-wrapper">
        <div class="section-header">
            <div class="section-header__icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd"/></svg>
            </div>
            <div class="section-header__text">
                <h2>Aktivitas Terbaru</h2>
                <p>Update terkini tentang anak Anda</p>
            </div>
        </div>

        <div class="activity-list">
            <div class="activity-item">
                <div class="activity-item__icon activity-item__icon--report">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd"/><path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z"/></svg>
                </div>
                <div class="activity-item__content">
                    <div class="activity-item__title">Report Minggu 12 Tersedia</div>
                    <div class="activity-item__desc">Perkembangan anak periode 18-22 November 2024 telah diupdate</div>
                </div>
                <div class="activity-item__time">2 jam lalu</div>
            </div>

            <div class="activity-item">
                <div class="activity-item__icon activity-item__icon--attendance">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd"/></svg>
                </div>
                <div class="activity-item__content">
                    <div class="activity-item__title">Kehadiran Tercatat</div>
                    <div class="activity-item__desc">Ahmad Fauzi hadir di sekolah hari ini</div>
                </div>
                <div class="activity-item__time">5 jam lalu</div>
            </div>

            <div class="activity-item">
                <div class="activity-item__icon activity-item__icon--chat">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M4.804 21.644A6.707 6.707 0 0 0 6 21.75a6.721 6.721 0 0 0 3.583-1.029c.774.182 1.584.279 2.417.279 5.322 0 9.75-3.97 9.75-9 0-5.03-4.428-9-9.75-9s-9.75 3.97-9.75 9c0 2.09.768 4.04 2.084 5.558a8.96 8.96 0 0 1-1.603 2.596.75.75 0 0 0 .53 1.28 6.72 6.72 0 0 0 1.543-.09Z" clip-rule="evenodd"/></svg>
                </div>
                <div class="activity-item__content">
                    <div class="activity-item__title">Pesan dari Guru</div>
                    <div class="activity-item__desc">Bu Siti mengirimkan pesan tentang kegiatan outdoor minggu depan</div>
                </div>
                <div class="activity-item__time">Kemarin</div>
            </div>

            <div class="activity-item">
                <div class="activity-item__icon activity-item__icon--report">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625ZM7.5 15a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 7.5 15Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H8.25Z" clip-rule="evenodd"/><path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z"/></svg>
                </div>
                <div class="activity-item__content">
                    <div class="activity-item__title">Report Minggu 11 Tersedia</div>
                    <div class="activity-item__desc">Perkembangan anak periode 11-15 November 2024</div>
                </div>
                <div class="activity-item__time">1 minggu lalu</div>
            </div>
        </div>
    </div>

@endsection
