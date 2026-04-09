<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SISTEM TK AL-ISTIQOMAH')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <style>
        /*
         * COLOR PALETTE — School Theme (Teal & Golden Yellow)
         *   Primary (Button/Highlight):
         *     golden #4CAF82
         *   Dark Teal (Headlines & Text):
         *     headline #3E2723 | paragraph #5D4037 | stroke #2C1810
         *   Light (Backgrounds):
         *     background #FFFDE7 | main #FFFDE7
         *   Accent Colors:
         *     secondary/pink #FFF176 | tertiary/coral #F06292
         *   Status Colors:
         *     success #ECFDF5/#047857 | warning #FFFBEB/#5D4037 | error #FEF2F2/#B91C1C | info #ecfdf5/#2E8B60
         *
         * SPACING — kelipatan 8px
         *   4 8 12 16 24 32 40 48 56 64
         *
         * TYPOGRAPHY SCALE
         *   12px caption | 14px body | 16px body-lg | 20px title | 24px heading
         */

        /* RESET */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: #FFFDE7;
            color: #5D4037;
            min-height: 100vh;
            font-size: 14px;
            line-height: 1.5;
        }
        a { text-decoration: none; color: inherit; }

        /* ═══════════════════════════════════
           LAYOUT: sidebar fixed left, main fills right
        ═══════════════════════════════════ */
        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* ═══════════════════════════════════
           SIDEBAR — 240px, fixed, full-height
        ═══════════════════════════════════ */
        .sidebar {
            width: 240px;
            background: linear-gradient(180deg, #4CAF82 0%, #3D9B72 100%);
            border-right: 1px solid #3D9B72;
            position: fixed;
            top: 0; bottom: 0; left: 0;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            z-index: 200;
        }

        /* Logo area */
        .sidebar__logo {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 20px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            flex-shrink: 0;
        }
        .sidebar__logo-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .sidebar__logo-icon svg { width: 20px; height: 20px; fill: #ffffff; }
        .sidebar__logo-text {
            font-size: 14px;
            font-weight: 600;
            color: #ffffff;
            line-height: 1.2;
        }
        .sidebar__logo-text span {
            display: block;
            font-size: 12px;
            font-weight: 400;
            color: rgba(255,255,255,0.75);
            margin-top: 1px;
        }

        /* Nav area */
        .sidebar__nav { flex: 1; padding: 8px 0; overflow-y: auto; }
        .sidebar__label {
            display: block;
            padding: 16px 16px 6px;
            font-size: 11px;
            font-weight: 600;
            color: rgba(255,255,255,0.65);
            letter-spacing: .6px;
            text-transform: uppercase;
        }
        .sidebar__item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            margin: 1px 8px;
            font-size: 14px;
            font-weight: 500;
            color: rgba(255,255,255,0.88);
            border: none;
            background: transparent;
            cursor: pointer;
            border-radius: 8px;
        }
        .sidebar__item:hover { background: rgba(255,255,255,0.18); color: #ffffff; }
        .sidebar__item.active { background: #ffffff; color: #3D9B72; font-weight: 700; box-shadow: 0 2px 8px rgba(0,0,0,0.12); }
        .sidebar__item svg { width: 18px; height: 18px; flex-shrink: 0; fill: currentColor; }
        .sidebar__divider { height: 1px; background: rgba(255,255,255,0.2); margin: 4px 16px; }

        /* Profile area at bottom */
        .sidebar__profile {
            padding: 16px;
            border-top: 1px solid rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }
        .sidebar__avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: rgba(255,255,255,0.25);
            color: #ffffff;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 700;
            flex-shrink: 0;
        }
        .sidebar__profile-info { flex: 1; min-width: 0; line-height: 1.3; }
        .sidebar__profile-name { font-size: 14px; font-weight: 600; color: #ffffff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sidebar__profile-role { font-size: 12px; color: rgba(255,255,255,0.75); }
        .sidebar__logout {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 6px;
            background: rgba(255,255,255,0.15);
            color: #ffffff;
            font-size: 12px;
            font-weight: 600;
            flex-shrink: 0;
            white-space: nowrap;
        }
        .sidebar__logout:hover { background: rgba(255,255,255,0.28); }
        .sidebar__logout svg { width: 14px; height: 14px; fill: currentColor; }

        /* ═══════════════════════════════════
           MAIN — offset by sidebar width
        ═══════════════════════════════════ */
        .main {
            flex: 1;
            margin-left: 240px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ═══════════════════════════════════
           CONTENT HEADER — 56px, sticky
        ═══════════════════════════════════ */
        .content-header {
            height: 56px;
            background: linear-gradient(90deg, #4CAF82 0%, #3D9B72 100%);
            border-bottom: 1px solid rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 100;
            flex-shrink: 0;
        }
        .content-header__breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: rgba(255,255,255,0.75);
        }
        .content-header__breadcrumb strong { color: #ffffff; font-weight: 600; }
        .content-header__breadcrumb svg { width: 14px; height: 14px; fill: rgba(255,255,255,0.5); }
        .content-header__right {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        /* Icon button */
        .icon-btn {
            width: 36px; height: 36px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: #ffffff;
            border: 1px solid rgba(255,255,255,0.3);
            background: rgba(255,255,255,0.2);
            cursor: pointer;
            position: relative;
        }
        .icon-btn:hover { background: rgba(255,255,255,0.6); }
        .icon-btn svg { width: 18px; height: 18px; fill: currentColor; }
        .notif-dot {
            position: absolute;
            top: 6px; right: 6px;
            width: 7px; height: 7px;
            border-radius: 50%;
            background: #F06292;
            border: 1.5px solid #ffffff;
        }
        /* Header avatar */
        .header-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: rgba(255,255,255,0.25);
            color: #ffffff;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 700;
            cursor: pointer;
        }
        .header-account { line-height: 1.3; }
        .header-account__name { font-size: 13px; font-weight: 600; color: #ffffff; }
        .header-account__role { font-size: 11px; color: rgba(255,255,255,0.75); }

        /* ═══════════════════════════════════
           CONTENT BODY
        ═══════════════════════════════════ */
        .content-body {
            flex: 1;
            padding: 24px;
            background: #FFFDE7;
        }

        /* PAGE HEADER */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 24px;
        }
        .page-header__title { font-size: 20px; font-weight: 700; color: #3E2723; line-height: 1.2; }
        .page-header__sub { font-size: 14px; color: #5D4037; margin-top: 4px; }
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
            color: #ffffff;
            padding: 0 16px;
            height: 36px;
            font-size: 14px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            border-radius: 8px;
            white-space: nowrap;
            box-shadow: 0 2px 4px rgba(76,175,130, 0.3);
        }
        .btn-primary:hover { background: linear-gradient(135deg, #3D9B72 0%, #2E8B60 100%); box-shadow: 0 4px 8px rgba(76,175,130, 0.4); }
        .btn-primary svg { width: 16px; height: 16px; fill: currentColor; }

        /* ═══════════════════════════════════
           STAT ROW — 4 cards, 16px gap
        ═══════════════════════════════════ */
        .stat-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: #fff;
            border: 1px solid #3E272320;
            border-radius: 8px;
            padding: 16px;
        }
        .stat-card__header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }
        .stat-card__label { font-size: 12px; color: #5D4037; font-weight: 500; }
        .stat-card__icon { width: 20px; height: 20px; fill: #5D4037; }
        .stat-card__icon--green  { fill: #3E2723; }
        .stat-card__icon--amber  { fill: #4CAF82; }
        .stat-card__icon--rose   { fill: #F06292; }
        .stat-card__icon--indigo { fill: #2C1810; }
        .stat-card__value { font-size: 24px; font-weight: 600; color: #3E2723; line-height: 1; }
        .stat-card__value--text  { font-size: 16px; font-weight: 600; }
        .stat-card__sub { font-size: 12px; color: #5D4037; margin-top: 6px; }

        /* Colored stat card variants */
        .stat-card--primary {
            background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
            border-color: transparent;
        }
        .stat-card--primary .stat-card__label,
        .stat-card--primary .stat-card__sub { color: rgba(255,255,255,0.88); }
        .stat-card--primary .stat-card__value { color: #ffffff; }
        .stat-card--primary .stat-card__icon,
        .stat-card--primary .stat-card__icon--green,
        .stat-card--primary .stat-card__icon--amber,
        .stat-card--primary .stat-card__icon--rose { fill: rgba(255,255,255,0.88); }

        .stat-card--secondary {
            background: #FFF176;
            border-color: #e6db00;
        }
        .stat-card--secondary .stat-card__label,
        .stat-card--secondary .stat-card__sub { color: #5D4037; }
        .stat-card--secondary .stat-card__value { color: #2C1810; }
        .stat-card--secondary .stat-card__icon,
        .stat-card--secondary .stat-card__icon--green,
        .stat-card--secondary .stat-card__icon--amber,
        .stat-card--secondary .stat-card__icon--rose { fill: #3E2723; }

        .stat-card--accent {
            background: linear-gradient(135deg, #F06292 0%, #d81b72 100%);
            border-color: transparent;
        }
        .stat-card--accent .stat-card__label,
        .stat-card--accent .stat-card__sub { color: rgba(255,255,255,0.88); }
        .stat-card--accent .stat-card__value { color: #ffffff; }
        .stat-card--accent .stat-card__icon,
        .stat-card--accent .stat-card__icon--green,
        .stat-card--accent .stat-card__icon--amber,
        .stat-card--accent .stat-card__icon--rose { fill: rgba(255,255,255,0.88); }

        /* ═══════════════════════════════════
           BOTTOM ROW — 2-col, 16px gap
        ═══════════════════════════════════ */
        .bottom-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        .bottom-row .update-list,
        .bottom-row .card { height: fit-content; }

        /* Generic card */
        .card {
            background: #fff;
            border: 1px solid #3E272320;
            border-radius: 8px;
            overflow: hidden;
        }
        .card__header {
            padding: 16px 16px 12px;
            border-bottom: 1px solid #3E272310;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card__title { font-size: 14px; font-weight: 600; color: #3E2723; }
        .card__badge {
            font-size: 12px; font-weight: 600;
            padding: 4px 8px; border-radius: 4px;
            background: #4CAF8230; color: #3E2723;
        }
        .card__body { padding: 16px; }

        /* ═══════════════════════════════════
           UPDATE LIST
        ═══════════════════════════════════ */
        .update-list { background: #fff; border: 1px solid #3E272320; border-radius: 8px; overflow: hidden; }
        .update-list__header {
            padding: 16px;
            border-bottom: 1px solid #3E272310;
            display: flex; align-items: center; justify-content: space-between;
        }
        .update-list__title { font-size: 14px; font-weight: 600; color: #3E2723; }
        .update-list__count {
            font-size: 12px; font-weight: 600;
            color: #3E2723; background: #4CAF8230;
            padding: 4px 8px; border-radius: 4px;
        }
        .update-item {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 16px;
            border-bottom: 1px solid #3E272308;
            cursor: pointer;
        }
        .update-item:last-child { border-bottom: none; }
        .update-item:hover { background: #FFFDE7; }
        .update-item__avatar {
            width: 32px; height: 32px; border-radius: 50%;
            background: #4CAF8230; color: #3E2723;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 600; flex-shrink: 0;
        }
        .update-item__body { flex: 1; min-width: 0; }
        .update-item__title { font-size: 14px; font-weight: 500; color: #3E2723; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .update-item__subtitle { font-size: 12px; color: #5D4037; margin-top: 2px; }
        .update-item__meta { display: flex; flex-direction: column; align-items: flex-end; gap: 4px; flex-shrink: 0; }
        .update-item__time { font-size: 12px; color: #5D4037; white-space: nowrap; }
        .update-item__badge { font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 4px; white-space: nowrap; }
        .update-item__badge--done { background: #4CAF8230; color: #3E2723; }
        .update-item__badge--new  { background: #ecfdf5; color: #2E8B60; }
        .update-item__badge--info { background: #FFF17630; color: #2C1810; }
        .update-item__arrow { width: 16px; height: 16px; fill: #5D4037; flex-shrink: 0; }
        .update-item:hover .update-item__arrow { fill: #3E2723; }

        /* ═══════════════════════════════════
           JADWAL BOX
        ═══════════════════════════════════ */
        .jadwal-box {
            border: 1px solid #3E272320;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 12px;
        }
        .jadwal-box:last-child { margin-bottom: 0; }
        .jadwal-box p { font-size: 14px; color: #5D4037; line-height: 1.6; }
        .jadwal-box p strong { color: #3E2723; }
        .jadwal-box__row {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #5D4037;
            margin-bottom: 6px;
        }
        .jadwal-box__row strong { color: #3E2723; font-size: 14px; }
        .jadwal-box__icon { width: 14px; height: 14px; fill: #5D4037; flex-shrink: 0; }
        .jadwal-box .link {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-top: 12px;
            font-size: 12px;
            font-weight: 600;
            color: #3E2723;
            text-decoration: none;
        }
        .jadwal-box .link:hover { text-decoration: underline; color: #2C1810; }

        /* ═══════════════════════════════════
           RESPONSIVE
        ═══════════════════════════════════ */
        @media (max-width: 1024px) {
            .stat-row { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .main { margin-left: 0; }
            .stat-row { grid-template-columns: repeat(2, 1fr); }
            .bottom-row { grid-template-columns: 1fr; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <div class="layout">
        <aside class="sidebar">
            <div class="sidebar__logo">
                <div class="sidebar__logo-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.174v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z"/><path d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286a48.4 48.4 0 0 1 6.085 2.563.198.198 0 0 0 .14 0c1.2-.538 2.42-1.036 3.561-1.48Z"/></svg>
                </div>
                <div class="sidebar__logo-text">
                    TK Al-Istiqomah
                    <span>Sistem Sekolah</span>
                </div>
            </div>
            <nav class="sidebar__nav">
                @yield('sidebar')
            </nav>
        </aside>

        <div class="main">
            <header class="content-header">
                <div class="content-header__breadcrumb">
                    <strong>@yield('page_title', 'Dashboard')</strong>
                </div>
                <div class="content-header__right">
                    <button class="icon-btn" title="Notifikasi">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0 1 13.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 0 1-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 1 1-7.48 0 24.585 24.585 0 0 1-4.831-1.244.75.75 0 0 1-.298-1.205A8.217 8.217 0 0 0 5.25 9.75V9Zm4.502 8.9a2.25 2.25 0 1 0 4.496 0 25.057 25.057 0 0 1-4.496 0Z" clip-rule="evenodd"/></svg>
                        <span class="notif-dot"></span>
                    </button>
                    <div class="header-avatar">{{ strtoupper(substr($userName ?? 'P', 0, 1)) }}</div>
                    <div class="header-account">
                        <div class="header-account__name">{{ $userName ?? 'Pengguna' }}</div>
                        <div class="header-account__role">{{ $userRole ?? 'Guru' }}</div>
                    </div>
                    <a href="{{ url('/logout') }}" class="sidebar__logout" title="Logout">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M7.5 3.75A1.5 1.5 0 0 0 6 5.25v13.5a1.5 1.5 0 0 0 1.5 1.5h6a1.5 1.5 0 0 0 1.5-1.5V15a.75.75 0 0 1 1.5 0v3.75a3 3 0 0 1-3 3h-6a3 3 0 0 1-3-3V5.25a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3V9A.75.75 0 0 1 15 9V5.25a1.5 1.5 0 0 0-1.5-1.5h-6Zm10.72 4.72a.75.75 0 0 1 1.06 0l3 3a.75.75 0 0 1 0 1.06l-3 3a.75.75 0 1 1-1.06-1.06l1.72-1.72H9a.75.75 0 0 1 0-1.5h10.94l-1.72-1.72a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
                        Logout
                    </a>
                </div>
            </header>

            <div class="content-body">
                @yield('content')
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>