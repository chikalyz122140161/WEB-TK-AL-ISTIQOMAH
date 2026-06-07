@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard Admin')

@section('sidebar')
    @include('admin.partials.sidebar')
@endsection

@section('content')
    <div class="page-header">
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card stat-card--teal">
            <div class="stat-card__icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="32" height="32">
                    <path
                        d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 4.8 11.06a.75.75 0 0 1-.231-1.337A60.65 60.65 0 0 1 11.7 2.805Z" />
                    <path
                        d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.833 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286a48.45 48.45 0 0 1 7.667 3.282.75.75 0 0 0 1.12 0Z" />
                </svg>
            </div>
            <div class="stat-card__content">
                <div class="stat-card__value">{{ $totalSiswa }}</div>
                <div class="stat-card__label">Total Siswa</div>
            </div>
        </div>

        <div class="stat-card stat-card--golden">
            <div class="stat-card__icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="32"
                    height="32">
                    <path
                        d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                </svg>
            </div>
            <div class="stat-card__content">
                <div class="stat-card__value">{{ $totalGuru }}</div>
                <div class="stat-card__label">Guru/Staff</div>
            </div>
        </div>

        <div class="stat-card stat-card--cyan">
            <div class="stat-card__icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="32"
                    height="32">
                    <path fill-rule="evenodd"
                        d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z"
                        clip-rule="evenodd" />
                    <path
                        d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z" />
                </svg>
            </div>
            <div class="stat-card__content">
                <div class="stat-card__value">{{ $orangTerdaftar }}</div>
                <div class="stat-card__label">Orang Terdaftar</div>
            </div>
        </div>

        <div class="stat-card stat-card--green">
            <div class="stat-card__icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="32"
                    height="32">
                    <path
                        d="M11.584 2.376a.75.75 0 0 1 .832 0l9 6a.75.75 0 1 1-.832 1.248L12 3.901 3.416 9.624a.75.75 0 0 1-.832-1.248l9-6Z" />
                    <path fill-rule="evenodd"
                        d="M20.25 10.332v9.918H21a.75.75 0 0 1 0 1.5H3a.75.75 0 0 1 0-1.5h.75v-9.918a.75.75 0 0 1 .634-.74A49.109 49.109 0 0 1 12 9c2.59 0 5.134.202 7.616.592a.75.75 0 0 1 .634.74Zm-7.5 2.418a.75.75 0 0 0-1.5 0v6.75a.75.75 0 0 0 1.5 0v-6.75Zm3-.75a.75.75 0 0 1 .75.75v6.75a.75.75 0 0 1-1.5 0v-6.75a.75.75 0 0 1 .75-.75ZM9 12.75a.75.75 0 0 0-1.5 0v6.75a.75.75 0 0 0 1.5 0v-6.75Z"
                        clip-rule="evenodd" />
                </svg>
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
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20"
                        height="20">
                        <path fill-rule="evenodd"
                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z"
                            clip-rule="evenodd" />
                    </svg>
                    Aktivitas Terbaru
                </h3>
            </div>
            <div class="card__body">
                @if (empty($aktivitas))
                    <p style="color:#5D4037;text-align:center;padding:24px 0;font-size:13px;">Belum ada aktivitas.</p>
                @else
                    <ul class="activity-list">
                        @foreach ($aktivitas as $item)
                            @php
                                $color = $item['color'] ?? 'green';
                                $dotColor = match ($color) {
                                    'green' => '#4CAF82',
                                    'yellow' => '#e6db00',
                                    'pink' => '#d81b72',
                                    'gray' => '#9ca3af',
                                    default => '#4CAF82',
                                };
                                $iconPath = match ($item['icon'] ?? 'inbox') {
                                    'check' => 'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
                                    'user'
                                        => 'M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z',
                                    'graduate'
                                        => 'M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342',
                                    'calendar'
                                        => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75',
                                    'home'
                                        => 'm2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75',
                                    'star'
                                        => 'M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z',
                                    'book'
                                        => 'M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25',
                                    'chat'
                                        => 'M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.068.157 2.148.279 3.238.364.466.037.893.281 1.153.671L12 21l2.652-3.978c.26-.39.687-.634 1.153-.67 1.09-.086 2.17-.208 3.238-.365 1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z',
                                    'list'
                                        => 'M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z',
                                    'database'
                                        => 'M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375',
                                    'clipboard'
                                        => 'M9 12h6m-6 3h6m2.25-9h.375a1.125 1.125 0 0 1 1.125 1.125v15.75a1.125 1.125 0 0 1-1.125 1.125H6.375a1.125 1.125 0 0 1-1.125-1.125V7.125A1.125 1.125 0 0 1 6.375 6h.375M11.25 3.75h1.5a1.5 1.5 0 0 1 1.5 1.5v.75a1.5 1.5 0 0 1-1.5 1.5h-1.5a1.5 1.5 0 0 1-1.5-1.5v-.75a1.5 1.5 0 0 1 1.5-1.5Z',
                                    'document'
                                        => 'M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z',
                                    default
                                        => 'M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H6.911a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661Z',
                                };
                            @endphp
                            <li class="activity-list__item">
                                <div class="activity-list__icon"
                                    style="background: {{ $dotColor }}20; color: {{ $dotColor }};">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.8" stroke="currentColor" width="16" height="16">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconPath }}" />
                                    </svg>
                                </div>
                                <div class="activity-list__content">
                                    <span class="activity-list__title">{{ $item['title'] }}</span>
                                    @if (!empty($item['subtitle']))
                                        <span class="activity-list__subtitle">{{ $item['subtitle'] }}</span>
                                    @endif
                                    <span class="activity-list__time">{{ $item['time'] }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <!-- Statistik Sistem -->
        <div class="card">
            <div class="card__header">
                <h3 class="card__title">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20"
                        height="20">
                        <path
                            d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75ZM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 0 1-1.875-1.875V8.625ZM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 0 1 3 19.875v-6.75Z" />
                    </svg>
                    Statistik Sistem
                </h3>
            </div>
            <div class="card__body">
                <div class="stats-info">
                    @foreach ($statistik as $stat)
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
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 24px;
        }

        /* BASE CARD */
        .stat-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            gap: 18px;
            box-shadow: 0 4px 20px rgba(62, 39, 35, 0.02);
            border: 1px solid rgba(62, 39, 35, 0.05);
            position: relative;
            overflow: hidden;
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(61, 155, 114, 0.06);
        }

        .stat-card__content {
            display: flex;
            flex-direction: column;
        }

        .stat-card__value {
            font-size: 2rem;
            font-weight: 800;
            color: #2C1810;
            line-height: 1.1;
        }

        /* Label Deskripsi */
        .stat-card__label {
            font-size: 0.875rem;
            font-weight: 500;
            color: #7A665E;
            margin-top: 4px;
        }

        .stat-card__icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-card__icon svg {
            width: 26px;
            height: 26px;
        }

        /* 1. Teal Card (Total Siswa) */
        .stat-card--teal {
            background: rgba(76, 175, 130, 0.06);
            border: 1px solid rgba(76, 175, 130, 0.18);
            border-left: 8px solid rgba(76, 175, 130, 0.18);
        }

        .stat-card--teal .stat-card__icon {
            background: #4CAF82;
            color: #ffffff;
        }

        .stat-card--golden {
            background: rgba(255, 241, 118, 0.15);
            border: 1px solid rgba(230, 219, 0, 0.25);
            border-left: 8px solid rgba(230, 219, 0, 0.25);
        }

        .stat-card--golden .stat-card__icon {
            background: #FFF176;
            color: #6D4C41;
            border: 1px solid rgba(230, 219, 0, 0.2);
        }

        .stat-card--cyan {
            background: rgba(240, 98, 146, 0.07);
            border: 1px solid rgba(240, 98, 146, 0.2);
            border-left: 8px solid rgba(240, 98, 146, 0.2);

        }

        .stat-card--cyan .stat-card__icon {
            background: #F06292;
            color: #ffffff;
        }

        .stat-card--green {
            background: rgba(61, 155, 114, 0.06);
            border: 1px solid rgba(61, 155, 114, 0.18);
            border-left: 8px solid rgba(61, 155, 114, 0.18);
        }

        .stat-card--green .stat-card__icon {
            background: #3D9B72;
            color: #ffffff;
        }


        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
            }
        }

        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .stat-card {
                padding: 16px 20px;
            }

            .stat-card__value {
                font-size: 1.75rem;
            }
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
            padding: 0.75rem 0.5rem;
            border-bottom: 1px solid #3E272320;
        }

        .activity-list__item:last-child {
            border-bottom: none;
        }

        .activity-list__dot {
            display: none;
        }

        .activity-list__icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .activity-list__content {
            flex: 1;
            min-width: 0;
        }

        .activity-list__title {
            display: block;
            font-weight: 600;
            color: #3E2723;
            font-size: 0.875rem;
        }

        .activity-list__subtitle {
            display: block;
            font-size: 0.78rem;
            color: #5D4037;
            margin-top: 2px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .activity-list__time {
            display: block;
            font-size: 0.72rem;
            color: #9ca3af;
            margin-top: 3px;
            font-weight: 500;
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
            background: #FFFDE7;
            border-radius: 8px;
        }

        .stats-info__label {
            color: #5D4037;
        }

        .stats-info__value {
            font-weight: 600;
            color: #3E2723;
        }
    </style>
@endsection
