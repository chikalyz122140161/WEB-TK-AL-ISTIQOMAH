<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SISTEM BK TK AL-ISTIQOMAH')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <style>
        /*
         * COLOR PALETTE â€” Sage & Neutral
         *   sage-900 #2D4A33 | sage-700 #3D6B45 | sage-600 #4F7A56 | sage-100 #EAF2EB | sage-50 #F4F8F5
         *   gray-900 #111827 | gray-700 #374151 | gray-500 #6B7280 | gray-400 #9CA3AF
         *   gray-200 #E5E7EB | gray-100 #F3F4F6 | gray-50 #F9FAFB  | white #FFFFFF
         *   success #ECFDF5/#047857 | warning #FFFBEB/#B45309 | error #FEF2F2/#B91C1C | info #EFF6FF/#1D4ED8
         *
         * SPACING â€” kelipatan 8px
         *   4 8 12 16 24 32 40 48 56 64
         *
         * TYPOGRAPHY SCALE
         *   12px caption | 14px body | 16px body-lg | 20px title | 24px heading
         */

        /* RESET */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: #F9FAFB;
            color: #374151;
            min-height: 100vh;
            font-size: 14px;
            line-height: 1.5;
        }
        a { text-decoration: none; color: inherit; }

        /* â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
           LAYOUT: sidebar fixed left, main fills right
        â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
           SIDEBAR â€” 240px, fixed, full-height
        â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .sidebar {
            width: 240px;
            background: #63E6BE;
            border-right: 1px solid #38D9A9;
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
            border-bottom: 1px solid rgba(0,0,0,0.1);
            flex-shrink: 0;
        }
        .sidebar__logo-icon {
            width: 36px; height: 36px;
            background: rgba(0,0,0,0.1);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .sidebar__logo-icon svg { width: 20px; height: 20px; fill: #065F46; }
        .sidebar__logo-text {
            font-size: 14px;
            font-weight: 600;
            color: #065F46;
            line-height: 1.2;
        }
        .sidebar__logo-text span {
            display: block;
            font-size: 12px;
            font-weight: 400;
            color: rgba(0,0,0,0.45);
            margin-top: 1px;
        }

        /* Nav area */
        .sidebar__nav { flex: 1; padding: 8px 0; overflow-y: auto; }
        .sidebar__label {
            display: block;
            padding: 16px 16px 6px;
            font-size: 11px;
            font-weight: 600;
            color: rgba(0,0,0,0.45);
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
            color: #065F46;
            border: none;
            background: transparent;
            cursor: pointer;
            border-radius: 6px;
        }
        .sidebar__item:hover { background: rgba(0,0,0,0.08); color: #064E3B; }
        .sidebar__item.active { background: rgba(0,0,0,0.12); color: #064E3B; font-weight: 600; }
        .sidebar__item svg { width: 18px; height: 18px; flex-shrink: 0; fill: currentColor; }
        .sidebar__divider { height: 1px; background: rgba(0,0,0,0.1); margin: 4px 16px; }

        /* Profile area at bottom */
        .sidebar__profile {
            padding: 16px;
            border-top: 1px solid rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }
        .sidebar__avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: rgba(0,0,0,0.1);
            color: #065F46;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 700;
            flex-shrink: 0;
        }
        .sidebar__profile-info { flex: 1; min-width: 0; line-height: 1.3; }
        .sidebar__profile-name { font-size: 14px; font-weight: 600; color: #065F46; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sidebar__profile-role { font-size: 12px; color: rgba(0,0,0,0.5); }
        .sidebar__logout {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 6px;
            background: rgba(0,0,0,0.1);
            color: #065F46;
            font-size: 12px;
            font-weight: 600;
            flex-shrink: 0;
            white-space: nowrap;
        }
        .sidebar__logout:hover { background: rgba(0,0,0,0.18); }
        .sidebar__logout svg { width: 14px; height: 14px; fill: currentColor; }

        /* â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
           MAIN â€” offset by sidebar width
        â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .main {
            flex: 1;
            margin-left: 240px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
           CONTENT HEADER â€” 56px, sticky
        â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .content-header {
            height: 56px;
            background: #63E6BE;
            border-bottom: 1px solid #38D9A9;
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
            color: rgba(0,0,0,0.55);
        }
        .content-header__breadcrumb strong { color: #065F46; font-weight: 600; }
        .content-header__breadcrumb svg { width: 14px; height: 14px; fill: rgba(0,0,0,0.3); }
        .content-header__right {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        /* Search â€” removed */
        /* Icon button */
        .icon-btn {
            width: 36px; height: 36px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: #065F46;
            border: 1px solid rgba(0,0,0,0.15);
            background: rgba(0,0,0,0.08);
            cursor: pointer;
            position: relative;
        }
        .icon-btn:hover { background: rgba(0,0,0,0.14); }
        .icon-btn svg { width: 18px; height: 18px; fill: currentColor; }
        .notif-dot {
            position: absolute;
            top: 6px; right: 6px;
            width: 7px; height: 7px;
            border-radius: 50%;
            background: #FEF08A;
            border: 1.5px solid #63E6BE;
        }
        /* Header avatar */
        .header-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: rgba(0,0,0,0.1);
            color: #065F46;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 700;
            cursor: pointer;
        }
        .header-account { line-height: 1.3; }
        .header-account__name { font-size: 13px; font-weight: 600; color: #065F46; }
        .header-account__role { font-size: 11px; color: rgba(0,0,0,0.5); }

        /* â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
           CONTENT BODY
        â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .content-body {
            flex: 1;
            padding: 24px;
            background: #F9FAFB;
        }

        /* PAGE HEADER */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 24px;
        }
        .page-header__title { font-size: 20px; font-weight: 700; color: #111827; line-height: 1.2; }
        .page-header__sub { font-size: 14px; color: #9CA3AF; margin-top: 4px; }
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #63E6BE;
            color: #065F46;
            padding: 0 16px;
            height: 36px;
            font-size: 14px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            border-radius: 8px;
            white-space: nowrap;
        }
        .btn-primary:hover { background: #38D9A9; }
        .btn-primary svg { width: 16px; height: 16px; fill: currentColor; }

        /* â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
           STAT ROW â€” 4 cards, 16px gap
        â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .stat-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: #fff;
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            padding: 16px;
        }
        .stat-card__header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }
        .stat-card__label { font-size: 12px; color: #6B7280; font-weight: 500; }
        .stat-card__icon { width: 20px; height: 20px; fill: #9CA3AF; }
        .stat-card__icon--green  { fill: #9CA3AF; }
        .stat-card__icon--amber  { fill: #9CA3AF; }
        .stat-card__icon--rose   { fill: #9CA3AF; }
        .stat-card__icon--indigo { fill: #9CA3AF; }
        .stat-card__value { font-size: 24px; font-weight: 600; color: #111827; line-height: 1; }
        .stat-card__value--text  { font-size: 16px; font-weight: 600; }
        .stat-card__sub { font-size: 12px; color: #9CA3AF; margin-top: 6px; }

        /* â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
           BOTTOM ROW â€” 2-col, 16px gap
        â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
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
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            overflow: hidden;
        }
        .card__header {
            padding: 16px 16px 12px;
            border-bottom: 1px solid #F3F4F6;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card__title { font-size: 14px; font-weight: 600; color: #111827; }
        .card__badge {
            font-size: 12px; font-weight: 600;
            padding: 4px 8px; border-radius: 4px;
            background: #F0FDF4; color: #166534;
        }
        .card__body { padding: 16px; }

        /* â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
           UPDATE LIST
        â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .update-list { background: #fff; border: 1px solid #E5E7EB; border-radius: 8px; overflow: hidden; }
        .update-list__header {
            padding: 16px;
            border-bottom: 1px solid #F3F4F6;
            display: flex; align-items: center; justify-content: space-between;
        }
        .update-list__title { font-size: 14px; font-weight: 600; color: #111827; }
        .update-list__count {
            font-size: 12px; font-weight: 600;
            color: #166534; background: #F0FDF4;
            padding: 4px 8px; border-radius: 4px;
        }
        .update-item {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 16px;
            border-bottom: 1px solid #F9FAFB;
            cursor: pointer;
        }
        .update-item:last-child { border-bottom: none; }
        .update-item:hover { background: #FAFAFA; }
        .update-item__avatar {
            width: 32px; height: 32px; border-radius: 50%;
            background: #F3F4F6; color: #6B7280;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 600; flex-shrink: 0;
        }
        .update-item__body { flex: 1; min-width: 0; }
        .update-item__title { font-size: 14px; font-weight: 500; color: #374151; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .update-item__subtitle { font-size: 12px; color: #9CA3AF; margin-top: 2px; }
        .update-item__meta { display: flex; flex-direction: column; align-items: flex-end; gap: 4px; flex-shrink: 0; }
        .update-item__time { font-size: 12px; color: #9CA3AF; white-space: nowrap; }
        .update-item__badge { font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 4px; white-space: nowrap; }
        .update-item__badge--done { background: #ECFDF5; color: #065F46; }
        .update-item__badge--new  { background: #EFF6FF; color: #1D4ED8; }
        .update-item__badge--info { background: #FFFBEB; color: #B45309; }
        .update-item__arrow { width: 16px; height: 16px; fill: #D1D5DB; flex-shrink: 0; }
        .update-item:hover .update-item__arrow { fill: #9CA3AF; }

        /* â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
           JADWAL BOX
        â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
        .jadwal-box {
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 12px;
        }
        .jadwal-box:last-child { margin-bottom: 0; }
        .jadwal-box p { font-size: 14px; color: #374151; line-height: 1.6; }
        .jadwal-box p strong { color: #111827; }
        .jadwal-box__row {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #374151;
            margin-bottom: 6px;
        }
        .jadwal-box__row strong { color: #111827; font-size: 14px; }
        .jadwal-box__icon { width: 14px; height: 14px; fill: #9CA3AF; flex-shrink: 0; }
        .jadwal-box .link {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-top: 12px;
            font-size: 12px;
            font-weight: 600;
            color: #065F46;
            text-decoration: none;
        }
        .jadwal-box .link:hover { text-decoration: underline; }

        /* â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
           RESPONSIVE
        â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
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
                    <span>Sistem BK</span>
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
                        <div class="header-account__role">Guru BK</div>
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
