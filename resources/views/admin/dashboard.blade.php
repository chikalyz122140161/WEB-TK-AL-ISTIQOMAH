@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-header__title">Dashboard Admin</h1>
    <p class="page-header__subtitle">Selamat datang, {{ Auth::user()->name ?? 'Admin' }}!</p>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card stat-card--teal">
        <div class="stat-card__icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="32" height="32"><path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 4.8 11.06a.75.75 0 0 1-.231-1.337A60.65 60.65 0 0 1 11.7 2.805Z"/><path d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.833 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286a48.45 48.45 0 0 1 7.667 3.282.75.75 0 0 0 1.12 0Z"/></svg>
        </div>
        <div class="stat-card__content">
            <div class="stat-card__value">{{ $totalSiswa }}</div>
            <div class="stat-card__label">Total Siswa</div>
        </div>
    </div>
    
    <div class="stat-card stat-card--golden">
        <div class="stat-card__icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="32" height="32"><path d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/></svg>
        </div>
        <div class="stat-card__content">
            <div class="stat-card__value">{{ $totalGuru }}</div>
            <div class="stat-card__label">Guru/Staff</div>
        </div>
    </div>
    
    <div class="stat-card stat-card--cyan">
        <div class="stat-card__icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="32" height="32"><path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z" clip-rule="evenodd"/><path d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z"/></svg>
        </div>
        <div class="stat-card__content">
            <div class="stat-card__value">{{ $orangTerdaftar }}</div>
            <div class="stat-card__label">Orang Terdaftar</div>
        </div>
    </div>
    
    <div class="stat-card stat-card--green">
        <div class="stat-card__icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="32" height="32"><path d="M11.584 2.376a.75.75 0 0 1 .832 0l9 6a.75.75 0 1 1-.832 1.248L12 3.901 3.416 9.624a.75.75 0 0 1-.832-1.248l9-6Z"/><path fill-rule="evenodd" d="M20.25 10.332v9.918H21a.75.75 0 0 1 0 1.5H3a.75.75 0 0 1 0-1.5h.75v-9.918a.75.75 0 0 1 .634-.74A49.109 49.109 0 0 1 12 9c2.59 0 5.134.202 7.616.592a.75.75 0 0 1 .634.74Zm-7.5 2.418a.75.75 0 0 0-1.5 0v6.75a.75.75 0 0 0 1.5 0v-6.75Zm3-.75a.75.75 0 0 1 .75.75v6.75a.75.75 0 0 1-1.5 0v-6.75a.75.75 0 0 1 .75-.75ZM9 12.75a.75.75 0 0 0-1.5 0v6.75a.75.75 0 0 0 1.5 0v-6.75Z" clip-rule="evenodd"/></svg>
        </div>
        <div class="stat-card__content">
            <div class="stat-card__value">{{ $totalKelas }}</div>
            <div class="stat-card__label">Total Kelas</div>
        </div>
    </div>
</div>

<!-- Two Column Grid -->
<div class="content-grid">
    <!-- Aktivitas Terbaru -->
    <div class="card">
        <div class="card__header">
            <h3 class="card__title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd"/></svg>
                Aktivitas Terbaru
            </h3>
        </div>
        <div class="card__body">
            <ul class="activity-list">
                @foreach($aktivitas as $item)
                <li class="activity-list__item">
                    <div class="activity-list__dot"></div>
                    <div class="activity-list__content">
                        <span class="activity-list__title">{{ $item['title'] }}</span>
                        <span class="activity-list__time">{{ $item['time'] }}</span>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    
    <!-- Statistik Sistem -->
    <div class="card">
        <div class="card__header">
            <h3 class="card__title">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75ZM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 0 1-1.875-1.875V8.625ZM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 0 1 3 19.875v-6.75Z"/></svg>
                Statistik Sistem
            </h3>
        </div>
        <div class="card__body">
            <div class="stats-info">
                @foreach($statistik as $stat)
                <div class="stats-info__item">
                    <span class="stats-info__label">{{ $stat['label'] }}</span>
                    <span class="stats-info__value">{{ $stat['value'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
}

@media (max-width: 1024px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 640px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
}

/* Stat Cards */
.stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    border-left: 4px solid;
}

.stat-card--teal {
    border-color: #00473e;
}

.stat-card--golden {
    border-color: #faae2b;
}

.stat-card--cyan {
    border-color: #0d9488;
}

.stat-card--green {
    border-color: #22c55e;
}

.stat-card__icon {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.stat-card--teal .stat-card__icon {
    background: rgba(0, 71, 62, 0.1);
    color: #00473e;
}

.stat-card--golden .stat-card__icon {
    background: rgba(250, 174, 43, 0.15);
    color: #d4920c;
}

.stat-card--cyan .stat-card__icon {
    background: rgba(13, 148, 136, 0.1);
    color: #0d9488;
}

.stat-card--green .stat-card__icon {
    background: rgba(34, 197, 94, 0.1);
    color: #22c55e;
}

.stat-card__value {
    font-size: 1.75rem;
    font-weight: 700;
    color: #00473e;
    line-height: 1;
}

.stat-card__label {
    font-size: 0.875rem;
    color: #475d5b;
    margin-top: 0.25rem;
}

/* Content Grid */
.content-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}

@media (max-width: 768px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
}

/* Activity List */
.activity-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.activity-list__item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 0.75rem 0;
    border-bottom: 1px solid #e5e7eb;
}

.activity-list__item:last-child {
    border-bottom: none;
}

.activity-list__dot {
    width: 10px;
    height: 10px;
    background: #faae2b;
    border-radius: 50%;
    margin-top: 4px;
    flex-shrink: 0;
}

.activity-list__content {
    flex: 1;
}

.activity-list__title {
    display: block;
    font-weight: 500;
    color: #00473e;
}

.activity-list__time {
    font-size: 0.8rem;
    color: #6b7280;
}

/* Stats Info */
.stats-info {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.stats-info__item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    background: #f8fafc;
    border-radius: 8px;
}

.stats-info__label {
    color: #475d5b;
}

.stats-info__value {
    font-weight: 600;
    color: #00473e;
}
</style>
@endsection
