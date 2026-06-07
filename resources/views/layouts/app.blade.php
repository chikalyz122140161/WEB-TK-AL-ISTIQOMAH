<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SISTEM TK AL-ISTIQOMAH')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo.png') }}">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
    <style>
        /* ═══════════════════════════════════════════════════════════
           DESIGN SYSTEM — TK AL-ISTIQOMAH
           CSS Custom Properties (Design Tokens)
        ═══════════════════════════════════════════════════════════ */
        :root {
            /* Colors */
            --green: #4CAF82;
            --green-dark: #3D9B72;
            --green-darker: #2E8B60;
            --green-12: rgba(76, 175, 130, 0.12);
            --green-20: rgba(76, 175, 130, 0.20);
            --green-30: rgba(76, 175, 130, 0.30);

            --yellow: #FFF176;
            --yellow-border: #e6db00;
            --yellow-bg: #FFFDE7;
            --yellow-20: rgba(255, 241, 118, 0.20);

            --pink: #F06292;
            --pink-dark: #d81b72;
            --pink-12: rgba(240, 98, 146, 0.12);
            --pink-20: rgba(240, 98, 146, 0.20);

            --text: #3E2723;
            --text-mid: #5D4037;
            --text-dark: #2C1810;

            --border: rgba(62, 39, 35, 0.12);
            --border-subtle: rgba(62, 39, 35, 0.06);
            --border-mid: rgba(62, 39, 35, 0.20);

            --surface: #ffffff;
            --bg: #FFFDE7;

            /* Shadows */
            --shadow-xs: 0 1px 2px rgba(0, 0, 0, 0.06);
            --shadow-sm: 0 1px 4px rgba(0, 0, 0, 0.08);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.10);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.12);
            --shadow-green: 0 4px 14px rgba(76, 175, 130, 0.32);
            --shadow-pink: 0 4px 14px rgba(240, 98, 146, 0.30);

            /* Radius */
            --r-sm: 6px;
            --r-md: 8px;
            --r-lg: 12px;
            --r-xl: 16px;
            --r-2xl: 20px;
            --r-full: 9999px;

            /* Transitions */
            --t: all 0.18s ease;
            --t-slow: all 0.30s ease;
        }

        /* ─── RESET ───────────────────────────────────────────── */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text-mid);
            min-height: 100vh;
            font-size: 14px;
            line-height: 1.55;
            -webkit-font-smoothing: antialiased;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button {
            font-family: inherit;
            cursor: pointer;
            border: none;
        }

        input,
        select,
        textarea {
            font-family: inherit;
        }

        /* ═══════════════════════════════════════════════════════════
           LAYOUT
        ═══════════════════════════════════════════════════════════ */
        .body {
            width: 100%;
        }

        .layout {
            display: flex;
            min-height: 100vh;
            width: 100vw;
            min-width: 100vw;
            overflow-x: hidden;
            box-sizing: border-box;
        }

        /* ═══════════════════════════════════════════════════════════
           SIDEBAR
        ═══════════════════════════════════════════════════════════ */
        .sidebar {
            width: 250px;
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            z-index: 200;
            border-right: 1px solid rgba(62, 39, 35, 0.05);
            /* Mengganti bayangan pekat dengan border super tipis */
            box-shadow: none;
        }

        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            /* background: rgba(255, 255, 255, 0.2); */
            background: linear-gradient(180deg, #3D9B72 0%, #2E8B60 100%);
            border-radius: 2px;
        }

        /* Logo */
        .sidebar__logo {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px 12px;
            border-bottom: 1px solid #3D9B72;
            flex-shrink: 0;
        }

        .sidebar__logo-icon {
            width: 38px;
            height: 38px;
            background: rgba(255, 255, 255, 0.20);
            /* background: #ffffff; */
            border-radius: var(--r-md);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .sidebar__logo-icon svg {
            width: 22px;
            height: 22px;
            fill: linear-gradient(180deg, #3D9B72 0%, #2E8B60 100%);
            ;
        }

        .sidebar__logo-text {
            font-size: 13.5px;
            font-weight: 700;
            /* color: #ffffff; */
            color: #111827;
            line-height: 1.25;
            letter-spacing: -0.01em;
        }

        .sidebar__logo-text span {
            display: block;
            font-size: 11px;
            font-weight: 400;
            /* color: rgba(255, 255, 255, 0.65); */
            color: #6b7280;
            margin-top: 2px;
        }

        /* Nav */
        .sidebar__nav {
            flex: 1;
            padding: 10px 0 8px;
            overflow-y: auto;
        }

        .sidebar__label {
            display: block;
            padding: 14px 16px 5px;
            font-size: 10.5px;
            font-weight: 700;
            /* color: rgba(255, 255, 255, 0.50); */
            color: #6b7280;
            letter-spacing: .7px;
            text-transform: uppercase;
        }

        .sidebar__item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 9px 12px;
            margin: 1px 8px;
            font-size: 13.5px;
            font-weight: 500;
            /* color: rgba(255, 255, 255, 0.82); */
            color: #1f2937;
            border-radius: var(--r-md);
            transition: var(--t);
            position: relative;
        }

        .sidebar__item:hover {
            background: rgba(61, 155, 114, 0.08);
            color: linear-gradient(180deg, #3D9B72 0%, #2E8B60 100%);
            padding-left: 20px;
        }

        .sidebar__item.active {
            /* background: #ffffff; */
            background: linear-gradient(180deg, #3D9B72 0%, #2E8B60 100%);
            /* color: var(--green-dark); */
            color: rgba(255, 255, 255, 0.82);
            font-weight: 700;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
        }

        .sidebar__item svg {
            width: 17px;
            height: 17px;
            flex-shrink: 0;
            fill: currentColor;
        }

        .sidebar__item_logout {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            color: #cc3333;
            font-size: 13px;
            font-weight: 600;
            border-radius: var(--r-md);
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .sidebar__item_logout:hover {
            background: rgba(204, 51, 51, 0.08);
            color: #b32424;
        }

        .sidebar__item_logout svg {
            width: 16px;
            height: 16px;
            fill: currentColor;
            flex-shrink: 0;
        }

        .sidebar__divider {
            height: 1px;
            background: rgba(0, 0, 0, 0.06);
            margin: 5px 16px;
        }

        /* Profile */
        .sidebar__profile {
            padding: 14px 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .sidebar__avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #FFF176;
            color: #5D4037;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            flex-shrink: 0;
            border: 1.5px solid #e6db00;
        }

        .sidebar__profile-info {
            flex: 1;
            min-width: 0;
            line-height: 1.3;
        }

        .sidebar__profile-name {
            font-size: 13px;
            font-weight: 600;
            color: #ffffff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar__profile-role {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.65);
        }

        .sidebar__logout {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            color: #cc3333;
            font-size: 13px;
            font-weight: 600;
            border-radius: var(--r-md);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .sidebar__logout:hover {
            background: rgba(204, 51, 51, 0.08);
            color: #b32424;
        }

        .sidebar__logout svg {
            width: 16px;
            height: 16px;
            fill: currentColor;
        }

        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--text-mid);
            padding: 6px;
            cursor: pointer;
            border-radius: 8px;
            transition: background 0.2s ease;
        }

        .sidebar-toggle:hover {
            background: rgba(62, 39, 35, 0.05);
        }

        .sidebar-toggle svg {
            width: 20px;
            height: 20px;
            color: #ffffff;
        }



        /* ═══════════════════════════════════════════════════════════
           MAIN CONTENT AREA
        ═══════════════════════════════════════════════════════════ */
        .main {
            flex: 1;
            margin-left: 248px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            min-width: 0;
            max-width: 100vw;
        }

        /* ─── CONTENT HEADER ────────────────────────────────────── */
        .content-header {
            height: 64px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-subtle);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 100;
            flex-shrink: 0;
            box-shadow: 0 4px 20px rgba(62, 39, 35, 0.015);
        }

        .content-header__breadcrumb {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text);
            font-size: 15px;
        }

        .content-header__breadcrumb strong {
            color: var(--text);
            font-size: 16px;
            font-weight: 700;
        }

        .content-header__breadcrumb svg {
            width: 34px;
            height: 34px;
            background: rgba(62, 39, 35, 0.03);
            border: 1px solid rgba(62, 39, 35, 0.08);
            padding: 2px;
            color: var(--text-mid);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .content-header__right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Icon button */
        .icon-btn {
            background: rgba(62, 39, 35, 0.03);
            border: 1px solid rgba(62, 39, 35, 0.08);
            color: var(--text-mid);
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .icon-btn:hover {
            background: rgba(76, 175, 130, 0.1);
            color: var(--green-darker);
            transform: scale(1.05);
        }

        .notif-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #FF5252;
            color: white;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 10px;
            border: 2px solid #ffffff;
            line-height: 1;
        }

        .icon-btn svg {
            width: 18px;
            height: 18px;
            fill: currentColor;
        }

        .notif-dot {
            position: absolute;
            top: 7px;
            right: 7px;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--yellow);
            border: 1.5px solid var(--green);
        }

        .notif-wrapper {
            position: relative;
        }

        .notif-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            min-width: 18px;
            height: 18px;
            padding: 0 4px;
            border-radius: 9px;
            background: #e53935;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--green);
            pointer-events: none;
        }

        .notif-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 280px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            z-index: 999;
            overflow: hidden;
            display: none;
        }

        .notif-dropdown.open {
            display: block;
        }

        .notif-dropdown__header {
            padding: 12px 16px 10px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #888;
            border-bottom: 1px solid #f0f0f0;
        }

        .notif-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            text-decoration: none;
            color: inherit;
            border-bottom: 1px solid #f7f7f7;
            transition: background 0.15s;
        }

        .notif-item:last-child {
            border-bottom: none;
        }

        .notif-item:hover {
            background: #f5faf7;
        }

        .notif-item__avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            flex-shrink: 0;
            background: var(--green);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
        }

        .notif-item__body {
            flex: 1;
            min-width: 0;
        }

        .notif-item__name {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 13px;
            font-weight: 600;
            color: #2d2d2d;
        }

        .notif-item__count {
            background: #e53935;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 1px 6px;
            border-radius: 8px;
            flex-shrink: 0;
        }

        .notif-item__preview {
            font-size: 12px;
            color: #888;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-top: 2px;
        }

        .notif-empty {
            padding: 20px 16px;
            text-align: center;
            font-size: 13px;
            color: #aaa;
        }

        /* Header avatar */
        .header-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #FFF176;
            color: #5D4037;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            border: 1.5px solid #e6db00;
        }

        .header-account__name {
            font-weight: 600;
            font-size: 13.5px;
            color: var(--text);
        }

        .header-account__role {
            font-size: 11px;
            font-weight: 500;
            color: var(--text-mid);
        }

        /* ─── CONTENT BODY ──────────────────────────────────────── */
        .content-body {
            flex: 1;
            padding: 24px;
            background: var(--bg);
            min-width: 0;
            overflow-x: hidden;
        }

        /* ═══════════════════════════════════════════════════════════
           PAGE HEADER
        ═══════════════════════════════════════════════════════════ */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 24px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .page-header__left {
            flex: 1;
        }

        .page-header__title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text);
            line-height: 1.25;
        }

        .page-header__subtitle,
        .page-header__sub {
            font-size: 13.5px;
            color: var(--text-mid);
            margin-top: 3px;
        }

        .page-header__actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        /* Section header (dipakai di dalam halaman) */
        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--green-20);
        }

        .section-header__icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%);
            border-radius: var(--r-md);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: var(--shadow-green);
        }

        .section-header__icon svg {
            width: 20px;
            height: 20px;
            fill: #ffffff;
        }

        .section-header__text h2 {
            font-size: 16px;
            font-weight: 700;
            color: var(--text);
            margin: 0;
        }

        .section-header__text p {
            font-size: 12.5px;
            color: var(--text-mid);
            margin: 2px 0 0;
        }

        .section-wrapper {
            margin-bottom: 28px;
        }

        /* ═══════════════════════════════════════════════════════════
           BUTTON SYSTEM
        ═══════════════════════════════════════════════════════════ */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 0 16px;
            height: 36px;
            font-size: 13.5px;
            font-weight: 600;
            border: none;
            border-radius: var(--r-md);
            cursor: pointer;
            white-space: nowrap;
            transition: var(--t);
            text-decoration: none;
            font-family: inherit;
            letter-spacing: 0.01em;
        }

        .btn svg {
            width: 16px;
            height: 16px;
            fill: currentColor;
            flex-shrink: 0;
        }

        .btn:active {
            transform: translateY(1px);
        }

        /* Primary — green */
        .btn--primary,
        .btn-primary {
            background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%);
            color: #ffffff;
            box-shadow: var(--shadow-green);
        }

        .btn--primary:hover,
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--green-dark) 0%, var(--green-darker) 100%);
            box-shadow: 0 6px 18px rgba(76, 175, 130, 0.40);
            transform: translateY(-1px);
        }

        .btn-primary svg {
            width: 16px;
            height: 16px;
            fill: currentColor;
        }

        /* Secondary — yellow (Edit) */
        .btn--secondary {
            background: var(--yellow);
            color: var(--text);
            border: 1.5px solid var(--yellow-border);
        }

        .btn--secondary:hover {
            background: #f5e800;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(230, 219, 0, 0.35);
        }

        .btn--secondary svg {
            fill: var(--text);
        }

        /* Danger — pink solid (Hapus) */
        .btn--danger {
            background: var(--pink);
            color: #ffffff;
            border: none;
            box-shadow: none;
        }

        .btn--danger:hover {
            background: var(--pink-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(240, 98, 146, 0.40);
        }

        .btn--danger svg {
            fill: #ffffff;
        }

        /* Success — hijau solid */
        .btn--success {
            background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%);
            color: #ffffff;
            box-shadow: var(--shadow-green);
        }

        .btn--success:hover {
            background: linear-gradient(135deg, var(--green-dark) 0%, var(--green-darker) 100%);
            transform: translateY(-1px);
        }

        /* Ghost — transparent with border */
        .btn--ghost {
            background: transparent;
            color: var(--text);
            border: 1.5px solid var(--border-mid);
        }

        .btn--ghost:hover {
            background: var(--green-12);
            border-color: var(--green);
            color: var(--green-dark);
        }

        /* Outline-danger */
        .btn--outline-danger {
            background: transparent;
            color: var(--pink-dark);
            border: 1.5px solid var(--pink);
        }

        .btn--outline-danger:hover {
            background: var(--pink-12);
            border-color: var(--pink-dark);
        }

        /* Icon-only */
        .btn--icon {
            width: 34px;
            height: 34px;
            padding: 0;
            border-radius: var(--r-md);
        }

        /* Info (teal outline) */
        .btn--info {
            background: var(--green-12);
            color: var(--green-dark);
            border: 1px solid var(--green-20);
        }

        .btn--info:hover {
            background: var(--green-20);
        }

        /* Sizes */
        .btn--sm {
            height: 30px;
            padding: 0 12px;
            font-size: 12.5px;
        }

        .btn--lg {
            height: 44px;
            padding: 0 24px;
            font-size: 15px;
        }

        .btn--full {
            width: 100%;
        }

        /* ═══════════════════════════════════════════════════════════
           BADGE / STATUS SYSTEM
        ═══════════════════════════════════════════════════════════ */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: var(--r-full);
            font-size: 11.5px;
            font-weight: 600;
            line-height: 1;
        }

        /* Success — diterima */
        .badge--success {
            background: var(--green-20);
            color: var(--green-darker);
        }

        /* Warning — pending */
        .badge--warning {
            background: var(--yellow);
            color: var(--text);
            border: 1px solid var(--yellow-border);
        }

        /* Danger — ditolak */
        .badge--danger {
            background: var(--pink-20);
            color: var(--pink-dark);
        }

        /* Info */
        .badge--info {
            background: var(--green-12);
            color: var(--green-dark);
        }

        /* Orange — wawancara */
        .badge--orange {
            background: rgba(255, 241, 118, 0.40);
            color: var(--text-dark);
            border: 1px solid rgba(230, 219, 0, 0.40);
        }

        /* Neutral */
        .badge--secondary {
            background: var(--border);
            color: var(--text-mid);
        }

        /* Outline */
        .badge--outline {
            background: transparent;
            border: 1px solid var(--border-mid);
            color: var(--text-mid);
        }

        /* Status dot */
        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            display: inline-block;
            flex-shrink: 0;
        }

        .status-dot--green {
            background: var(--green);
        }

        .status-dot--yellow {
            background: var(--yellow-border);
        }

        .status-dot--pink {
            background: var(--pink);
        }

        /* ═══════════════════════════════════════════════════════════
           ALERT SYSTEM
        ═══════════════════════════════════════════════════════════ */
        .alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 16px;
            border-radius: var(--r-lg);
            margin-bottom: 16px;
            font-size: 13.5px;
            line-height: 1.5;
        }

        .alert svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .alert strong {
            font-weight: 700;
        }

        .alert--success {
            background: var(--green-12);
            border: 1px solid var(--green-20);
            color: var(--green-darker);
        }

        .alert--success svg {
            fill: var(--green-dark);
        }

        .alert--warning {
            background: var(--yellow);
            border: 1px solid var(--yellow-border);
            color: var(--text);
        }

        .alert--warning svg {
            fill: var(--text);
        }

        .alert--danger {
            background: var(--pink-12);
            border: 1px solid var(--pink-20);
            color: var(--pink-dark);
        }

        .alert--danger svg {
            fill: var(--pink-dark);
        }

        .alert--info {
            background: var(--green-12);
            border: 1px solid var(--green-20);
            color: var(--green-dark);
        }

        .alert--info svg {
            fill: var(--green-dark);
        }

        /* ═══════════════════════════════════════════════════════════
           FORM SYSTEM
        ═══════════════════════════════════════════════════════════ */
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 16px;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .form-label {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text);
            letter-spacing: 0.01em;
        }

        .form-label .required,
        .form-label.required::after {
            content: " *";
            color: var(--pink);
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 9px 12px;
            border: 1.5px solid var(--border-mid);
            border-radius: var(--r-md);
            font-size: 13.5px;
            color: var(--text);
            background: var(--surface);
            transition: var(--t);
            font-family: inherit;
            appearance: none;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--green);
            box-shadow: 0 0 0 3px var(--green-12);
        }

        .form-input::placeholder,
        .form-textarea::placeholder {
            color: var(--text-mid);
            opacity: 0.6;
        }

        .form-input:hover:not(:focus),
        .form-select:hover:not(:focus),
        .form-textarea:hover:not(:focus) {
            border-color: var(--green-dark);
        }

        .form-help {
            font-size: 11.5px;
            color: var(--text-mid);
            margin-top: 3px;
        }

        .form-error {
            font-size: 11.5px;
            color: var(--pink-dark);
            margin-top: 3px;
        }

        .input-group {
            display: flex;
            gap: 8px;
        }

        .input-group .form-input {
            flex: 1;
        }

        /* ═══════════════════════════════════════════════════════════
           CARD SYSTEM
        ═══════════════════════════════════════════════════════════ */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r-lg);
            overflow: hidden;
            box-shadow: var(--shadow-xs);
        }

        .card__header {
            padding: 14px 18px 12px;
            border-bottom: 1px solid var(--border-subtle);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card__title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card__title svg {
            width: 18px;
            height: 18px;
            fill: var(--green-dark);
        }

        .card__badge {
            font-size: 11.5px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: var(--r-sm);
            background: var(--green-20);
            color: var(--green-darker);
        }

        .card__body {
            padding: 18px;
        }

        .card__footer {
            padding: 12px 18px;
            border-top: 1px solid var(--border-subtle);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
        }

        /* ═══════════════════════════════════════════════════════════
           STAT CARD SYSTEM (unified)
        ═══════════════════════════════════════════════════════════ */
        .stat-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-row-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 16px;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r-lg);
            padding: 18px 16px;
            position: relative;
            overflow: hidden;
            transition: var(--t);
            box-shadow: var(--shadow-xs);
        }

        .stat-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .stat-card__header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .stat-card__label {
            font-size: 12px;
            color: var(--text-mid);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .stat-card__icon {
            width: 20px;
            height: 20px;
            fill: var(--text-mid);
            flex-shrink: 0;
        }

        .stat-card__icon--green {
            fill: var(--green);
        }

        .stat-card__icon--amber {
            fill: var(--text);
        }

        .stat-card__icon--rose {
            fill: var(--pink);
        }

        .stat-card__icon--indigo {
            fill: var(--text-dark);
        }

        .stat-card__value {
            font-size: 26px;
            font-weight: 700;
            color: var(--text);
            line-height: 1;
            letter-spacing: -0.02em;
        }

        .stat-card__value--text {
            font-size: 17px;
            font-weight: 700;
        }

        .stat-card__sub {
            font-size: 12px;
            color: var(--text-mid);
            margin-top: 6px;
        }

        /* Primary — hijau gradient */
        .stat-card--primary {
            background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%);
            border-color: transparent;
            box-shadow: var(--shadow-green);
        }

        .stat-card--primary .stat-card__label,
        .stat-card--primary .stat-card__sub {
            color: rgba(255, 255, 255, 0.80);
        }

        .stat-card--primary .stat-card__value {
            color: #ffffff;
        }

        .stat-card--primary .stat-card__icon,
        .stat-card--primary .stat-card__icon--green,
        .stat-card--primary .stat-card__icon--amber,
        .stat-card--primary .stat-card__icon--rose {
            fill: rgba(255, 255, 255, 0.85);
        }

        /* Secondary — kuning */
        .stat-card--secondary {
            background: var(--yellow);
            border-color: var(--yellow-border);
        }

        .stat-card--secondary .stat-card__label,
        .stat-card--secondary .stat-card__sub {
            color: var(--text-mid);
        }

        .stat-card--secondary .stat-card__value {
            color: var(--text-dark);
        }

        .stat-card--secondary .stat-card__icon,
        .stat-card--secondary .stat-card__icon--green,
        .stat-card--secondary .stat-card__icon--amber,
        .stat-card--secondary .stat-card__icon--rose {
            fill: var(--text);
        }

        /* Accent — pink gradient */
        .stat-card--accent {
            background: linear-gradient(135deg, var(--pink) 0%, var(--pink-dark) 100%);
            border-color: transparent;
            box-shadow: var(--shadow-pink);
        }

        .stat-card--accent .stat-card__label,
        .stat-card--accent .stat-card__sub {
            color: rgba(255, 255, 255, 0.80);
        }

        .stat-card--accent .stat-card__value {
            color: #ffffff;
        }

        .stat-card--accent .stat-card__icon,
        .stat-card--accent .stat-card__icon--green,
        .stat-card--accent .stat-card__icon--amber,
        .stat-card--accent .stat-card__icon--rose {
            fill: rgba(255, 255, 255, 0.85);
        }

        /* Neutral — white */
        .stat-card--neutral {
            background: var(--surface);
            border-color: var(--border);
        }

        /* Alias untuk admin dashboard */
        .stat-card--teal {
            background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%);
            border-color: transparent;
            box-shadow: var(--shadow-green);
        }

        .stat-card--golden {
            background: var(--yellow);
            border-color: var(--yellow-border);
        }

        .stat-card--cyan {
            background: linear-gradient(135deg, var(--pink) 0%, var(--pink-dark) 100%);
            border-color: transparent;
            box-shadow: var(--shadow-pink);
        }

        .stat-card--green {
            background: linear-gradient(135deg, var(--green-dark) 0%, var(--green-darker) 100%);
            border-color: transparent;
            box-shadow: var(--shadow-green);
        }

        .stat-card--teal .stat-card__icon,
        .stat-card--cyan .stat-card__icon,
        .stat-card--green .stat-card__icon {
            background: rgba(255, 255, 255, 0.18);
            color: #ffffff;
        }

        .stat-card--golden .stat-card__icon {
            background: rgba(62, 39, 35, 0.08);
            color: var(--text);
        }

        /* Shared icon box for admin dashboard cards */
        .stat-card__icon-box {
            width: 52px;
            height: 52px;
            border-radius: var(--r-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-card__icon-box svg {
            width: 28px;
            height: 28px;
        }

        /* ─── OLD stat-card content layout (admin dashboard) ────── */
        .stat-card__content {
            display: flex;
            flex-direction: column;
        }

        /* ═══════════════════════════════════════════════════════════
           TABLE SYSTEM
        ═══════════════════════════════════════════════════════════ */
        .table-responsive {
            overflow-x: auto;
            border-radius: var(--r-lg);
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13.5px;
        }

        .data-table thead {
            background: var(--surface);
        }

        .data-table th {
            background: rgba(76, 175, 130, 0.03);
            font-size: 12px;
            font-weight: 700;
            color: var(--text);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 11px 16px;
            text-align: left;
            border-bottom: 1.5px solid var(--border);
            white-space: nowrap;
        }

        .data-table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border-subtle);
            color: var(--text-mid);
            vertical-align: middle;
        }

        .data-table tbody tr:nth-child(even) {
            background: rgba(241, 241, 241, 0.52);
        }

        .data-table tbody tr {
            transition: var(--t);
        }

        .data-table tbody tr:hover {
            background: rgba(76, 175, 130, 0.04);
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ═══════════════════════════════════════════════════════════
           UPDATE LIST
        ═══════════════════════════════════════════════════════════ */
        .update-list {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r-lg);
            overflow: hidden;
            box-shadow: var(--shadow-xs);
        }

        .update-list__header {
            padding: 14px 18px;
            border-bottom: 1px solid var(--border-subtle);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .update-list__title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text);
        }

        .update-list__count {
            font-size: 11.5px;
            font-weight: 700;
            color: var(--green-darker);
            background: var(--green-20);
            padding: 3px 10px;
            border-radius: var(--r-sm);
        }

        .update-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 18px;
            border-bottom: 1px solid var(--border-subtle);
            cursor: pointer;
            transition: var(--t);
        }

        .update-item:last-child {
            border-bottom: none;
        }

        .update-item:hover {
            background: rgba(76, 175, 130, 0.04);
        }

        .update-item__avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--green-20);
            color: var(--green-darker);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .update-item__body {
            flex: 1;
            min-width: 0;
        }

        .update-item__title {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .update-item__subtitle {
            font-size: 12px;
            color: var(--text-mid);
            margin-top: 2px;
        }

        .update-item__meta {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 4px;
            flex-shrink: 0;
        }

        .update-item__time {
            font-size: 11.5px;
            color: var(--text-mid);
            white-space: nowrap;
        }

        .update-item__badge {
            font-size: 11px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: var(--r-sm);
            white-space: nowrap;
        }

        .update-item__badge--done {
            background: var(--green-20);
            color: var(--green-darker);
        }

        .update-item__badge--new {
            background: var(--green-12);
            color: var(--green-dark);
        }

        .update-item__badge--info {
            background: var(--yellow-20);
            color: var(--text-dark);
        }

        .update-item__arrow {
            width: 15px;
            height: 15px;
            fill: var(--border-mid);
            flex-shrink: 0;
            transition: var(--t);
        }

        .update-item:hover .update-item__arrow {
            fill: var(--green-dark);
            transform: translateX(2px);
        }

        /* ═══════════════════════════════════════════════════════════
           JADWAL BOX
        ═══════════════════════════════════════════════════════════ */
        .jadwal-box {
            border: 1px solid var(--border);
            border-radius: var(--r-md);
            padding: 14px 16px;
            margin-bottom: 10px;
            transition: var(--t);
            background: var(--surface);
        }

        .jadwal-box:hover {
            border-color: var(--green-20);
            box-shadow: var(--shadow-sm);
        }

        .jadwal-box:last-child {
            margin-bottom: 0;
        }

        .jadwal-box p {
            font-size: 13.5px;
            color: var(--text-mid);
            line-height: 1.6;
        }

        .jadwal-box p strong {
            color: var(--text);
        }

        .jadwal-box__row {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text-mid);
            margin-bottom: 5px;
        }

        .jadwal-box__row strong {
            color: var(--text);
            font-size: 13.5px;
        }

        .jadwal-box__icon {
            width: 13px;
            height: 13px;
            fill: var(--text-mid);
            flex-shrink: 0;
        }

        .jadwal-box .link {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-top: 10px;
            font-size: 12px;
            font-weight: 600;
            color: var(--green-dark);
            transition: var(--t);
        }

        .jadwal-box .link:hover {
            color: var(--green-darker);
            text-decoration: underline;
        }

        /* ═══════════════════════════════════════════════════════════
           BOTTOM ROW (2-col layout)
        ═══════════════════════════════════════════════════════════ */
        .bottom-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .bottom-row .update-list,
        .bottom-row .card {
            height: fit-content;
        }

        /* ═══════════════════════════════════════════════════════════
           MODAL SYSTEM
        ═══════════════════════════════════════════════════════════ */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(62, 39, 35, 0.40);
            backdrop-filter: blur(4px);
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            visibility: hidden;
            transition: var(--t-slow);
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-box {
            background: var(--surface);
            border-radius: var(--r-xl);
            padding: 28px;
            max-width: 460px;
            width: 100%;
            box-shadow: var(--shadow-lg);
            transform: translateY(12px) scale(0.97);
            transition: var(--t-slow);
        }

        .modal-overlay.active .modal-box {
            transform: translateY(0) scale(1);
        }

        .modal-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
        }

        .modal-icon svg {
            width: 28px;
            height: 28px;
        }

        .modal-icon--success {
            background: var(--green-20);
        }

        .modal-icon--success svg {
            fill: var(--green-darker);
        }

        .modal-icon--danger {
            background: var(--pink-20);
        }

        .modal-icon--danger svg {
            fill: var(--pink-dark);
        }

        .modal-icon--warning {
            background: var(--yellow);
        }

        .modal-icon--warning svg {
            fill: var(--text);
        }

        .modal-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text);
            text-align: center;
            margin-bottom: 8px;
        }

        .modal-desc {
            font-size: 13.5px;
            color: var(--text-mid);
            text-align: center;
            line-height: 1.6;
            margin-bottom: 22px;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
        }

        .modal-actions .btn {
            flex: 1;
            justify-content: center;
        }

        /* ═══════════════════════════════════════════════════════════
           ACTION BUTTONS (icon row in tables)
        ═══════════════════════════════════════════════════════════ */
        .action-buttons {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* ═══════════════════════════════════════════════════════════
           STATUS BANNER
        ═══════════════════════════════════════════════════════════ */
        .status-banner {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 20px;
            border-radius: var(--r-lg);
            margin-bottom: 24px;
            border: 1px solid transparent;
        }

        .status-banner--pending {
            background: var(--yellow);
            border-color: var(--yellow-border);
        }

        .status-banner--diterima {
            background: var(--green-12);
            border-color: var(--green-20);
        }

        .status-banner--ditolak {
            background: var(--pink-12);
            border-color: var(--pink-20);
        }

        .status-banner__icon {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .status-banner__icon svg {
            width: 24px;
            height: 24px;
        }

        .status-banner--pending .status-banner__icon {
            background: rgba(62, 39, 35, 0.10);
        }

        .status-banner--pending .status-banner__icon svg {
            fill: var(--text);
        }

        .status-banner--diterima .status-banner__icon {
            background: var(--green-20);
        }

        .status-banner--diterima .status-banner__icon svg {
            fill: var(--green-darker);
        }

        .status-banner--ditolak .status-banner__icon {
            background: var(--pink-20);
        }

        .status-banner--ditolak .status-banner__icon svg {
            fill: var(--pink-dark);
        }

        .status-banner__content {
            flex: 1;
        }

        .status-banner__label {
            font-size: 11.5px;
            color: var(--text-mid);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            display: block;
        }

        .status-banner__value {
            font-size: 18px;
            font-weight: 700;
            color: var(--text);
            display: block;
            margin-top: 2px;
        }

        .status-banner__date {
            font-size: 12.5px;
            color: var(--text-mid);
            white-space: nowrap;
        }

        /* ═══════════════════════════════════════════════════════════
           TABS NAVIGATION
        ═══════════════════════════════════════════════════════════ */

        .card__tabs-body {
            padding: 4px 18px;
        }

        .tabs-nav-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 16px;
            padding: 10px 18px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r-lg);
            width: 100%;
            box-sizing: border-box;
        }

        .tabs-nav__info {
            display: flex;
            align-items: center;
            flex-shrink: 0;
        }

        .tabs-nav__info label {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-mid);
            position: relative;
            padding-left: 12px;
        }

        .tabs-nav__info label::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 5px;
            height: 5px;
            background: var(--green);
            border-radius: 50%;
        }

        .tabs-nav__list {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .tabs-nav__item {
            padding: 8px 16px;
            background: transparent;
            border: 1px solid var(--border);
            border-radius: var(--r-md);
            font-size: 13px;
            font-weight: 600;
            color: var(--text-mid);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: var(--t);
            white-space: nowrap;
        }

        .tabs-nav__item:hover {
            background: var(--green-12);
            color: var(--green-dark);
            border-color: rgba(76, 175, 130, 0.2);
        }

        .tabs-nav__item.active {
            background: var(--green);
            color: #ffffff;
            border-color: var(--green);
            box-shadow: var(--shadow-green);
        }

        .tabs-nav__badge {
            padding: 2px 7px;
            border-radius: var(--r-full);
            font-size: 11px;
            font-weight: 700;
            line-height: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .tabs-nav__badge.warning {
            background: var(--yellow);
            color: var(--text);
        }

        .tabs-nav__badge.success {
            background: var(--green-20);
            color: var(--green-darker);
        }

        .tabs-nav__badge.danger {
            background: var(--pink-20);
            color: var(--pink-dark);
        }

        .tabs-nav__badge.orange {
            background: var(--yellow-20);
            color: var(--text-dark);
        }

        .tabs-nav__item.active .tabs-nav__badge {
            background: rgba(255, 255, 255, 0.25);
            color: #ffffff;
        }

        @media (max-width: 992px) {
            .tabs-nav-container {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
                padding: 14px;
            }

            .tabs-nav__list {
                width: 100%;
            }

            .tabs-nav__item {
                flex: 1;
                justify-content: center;
            }
        }

        /* ═══════════════════════════════════════════════════════════
           FILTER ROW
        ═══════════════════════════════════════════════════════════ */
        .filter-row {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
            min-width: 200px;
        }

        .filter-group label {
            font-size: 11.5px;
            font-weight: 700;
            color: var(--text);
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .filter-card-wrapper {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid rgba(62, 39, 35, 0.06);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.02);
            overflow: hidden;
        }

        .card__tabs-header {
            padding: 18px;
            border-bottom: 1px solid rgba(62, 39, 35, 0.06);
        }

        .card__tabs-header .tabs-nav {
            border: none;
            background: transparent;
            padding: 0;
            margin-bottom: 12px;
        }

        .filter-row {
            display: flex;
            align-items: flex-end;
            gap: 16px;
            width: 100%;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            flex: 1;
        }

        .filter-group--search {
            flex: 2;
        }

        .filter-group label {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-mid);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input,
        .form-select {
            width: 100%;
            height: 40px;
            padding: 8px 14px;
            background: #ffffff;
            border: 1px solid rgba(62, 39, 35, 0.15);
            border-radius: 10px;
            font-size: 13.5px;
            color: var(--text);
            transition: all 0.2s ease;
            outline: none;
        }

        .form-input:focus,
        .form-select:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 3px var(--green-12);
        }


        @media (max-width: 768px) {
            .filter-row {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }

            .filter-group {
                flex: none;
                width: 100%;
            }

            .card__tabs-header {
                padding: 14px 16px 0px 16px;
            }
        }

        /* ═══════════════════════════════════════════════════════════
           QUICK ACTION CARDS
        ═══════════════════════════════════════════════════════════ */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 24px;
        }

        .quick-action-card {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--r-lg);
            padding: 18px 14px;
            text-align: center;
            cursor: pointer;
            transition: var(--t);
            display: block;
        }

        .quick-action-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
            border-color: var(--green);
            background: rgba(76, 175, 130, 0.03);
        }

        .quick-action-card__icon {
            width: 46px;
            height: 46px;
            background: var(--green-12);
            border-radius: var(--r-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            transition: var(--t);
        }

        .quick-action-card:hover .quick-action-card__icon {
            background: var(--green-20);
        }

        .quick-action-card__icon svg {
            width: 22px;
            height: 22px;
            fill: var(--green-dark);
        }

        .quick-action-card__title {
            font-size: 13px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 3px;
        }

        .quick-action-card__desc {
            font-size: 11.5px;
            color: var(--text-mid);
        }

        /* ═══════════════════════════════════════════════════════════
           PROFILE CARD (orangtua)
        ═══════════════════════════════════════════════════════════ */
        .child-profile-card {
            background: linear-gradient(135deg, var(--green) 0%, var(--green-darker) 100%);
            border-radius: var(--r-xl);
            padding: 24px;
            margin-bottom: 24px;
            color: #fff;
            box-shadow: var(--shadow-green);
            position: relative;
            overflow: hidden;
        }

        .child-profile-card::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 160px;
            height: 160px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }

        .child-profile-card::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: 30%;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 50%;
        }

        .child-profile-card__header {
            display: flex;
            align-items: center;
            gap: 16px;
            position: relative;
            z-index: 1;
        }

        .child-profile-card__avatar {
            width: 68px;
            height: 68px;
            background: rgba(255, 255, 255, 0.22);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            font-weight: 700;
            color: #ffffff;
            border: 2px solid rgba(255, 255, 255, 0.35);
        }

        .child-profile-card__info h3 {
            font-size: 20px;
            font-weight: 700;
            margin: 0 0 4px;
        }

        .child-profile-card__info p {
            font-size: 13.5px;
            opacity: 0.80;
            margin: 0;
        }

        .child-profile-card__stats {
            display: flex;
            gap: 28px;
            margin-top: 20px;
            padding-top: 18px;
            border-top: 1px solid rgba(255, 255, 255, 0.18);
            position: relative;
            z-index: 1;
        }

        .child-profile-card__stat {
            text-align: center;
        }

        .child-profile-card__stat-value {
            font-size: 22px;
            font-weight: 700;
            color: #ffffff;
        }

        .child-profile-card__stat-label {
            font-size: 11.5px;
            opacity: 0.80;
            margin-top: 2px;
        }

        /* ═══════════════════════════════════════════════════════════
           ACTIVITY LIST (orangtua dashboard)
        ═══════════════════════════════════════════════════════════ */
        .activity-list {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--r-lg);
            overflow: hidden;
            box-shadow: var(--shadow-xs);
        }

        .activity-item {
            padding: 14px 18px;
            border-bottom: 1px solid var(--border-subtle);
            display: flex;
            align-items: flex-start;
            gap: 12px;
            transition: var(--t);
        }

        .activity-item:hover {
            background: rgba(76, 175, 130, 0.03);
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
            background: var(--green-12);
        }

        .activity-item__icon--report svg {
            fill: var(--green-dark);
        }

        .activity-item__icon--attendance {
            background: var(--green-20);
        }

        .activity-item__icon--attendance svg {
            fill: var(--green-darker);
        }

        .activity-item__icon--chat {
            background: var(--yellow);
        }

        .activity-item__icon--chat svg {
            fill: var(--text);
        }

        .activity-item__icon svg {
            width: 17px;
            height: 17px;
        }

        .activity-item__content {
            flex: 1;
        }

        .activity-item__title {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 2px;
        }

        .activity-item__desc {
            font-size: 12.5px;
            color: var(--text-mid);
        }

        .activity-item__time {
            font-size: 11.5px;
            color: var(--text-mid);
            white-space: nowrap;
        }

        /* ═══════════════════════════════════════════════════════════
           UTILITY CLASSES
        ═══════════════════════════════════════════════════════════ */
        .text-muted {
            color: var(--text-mid);
        }

        .text-green {
            color: var(--green-dark);
        }

        .text-pink {
            color: var(--pink-dark);
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .mb-2 {
            margin-bottom: 8px;
        }

        .mb-3 {
            margin-bottom: 12px;
        }

        .mb-4 {
            margin-bottom: 16px;
        }

        .mb-6 {
            margin-bottom: 24px;
        }

        .mt-2 {
            margin-top: 8px;
        }

        .mt-4 {
            margin-top: 16px;
        }

        .mt-6 {
            margin-top: 24px;
        }

        .p-0 {
            padding: 0;
        }

        .py-3 {
            padding-top: 12px;
            padding-bottom: 12px;
        }

        .py-4 {
            padding-top: 16px;
            padding-bottom: 16px;
        }

        .px-4 {
            padding-left: 16px;
            padding-right: 16px;
        }

        .d-flex {
            display: flex;
        }

        .gap-2 {
            gap: 8px;
        }

        .gap-3 {
            gap: 12px;
        }

        .align-center {
            align-items: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .divider {
            height: 1px;
            background: var(--border);
            margin: 16px 0;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-mid);
            cursor: not-allowed;
        }

        .empty-state svg {
            width: 48px;
            height: 48px;
            fill: var(--border-mid);
            margin-bottom: 12px;
        }

        .empty-state p {
            font-size: 13.5px;
        }

        /* ═══════════════════════════════════════════════════════════
           RESPONSIVE
        ═══════════════════════════════════════════════════════════ */
        @media (max-width: 1200px) {
            .stat-row {
                grid-template-columns: repeat(2, 1fr);
            }

            .quick-actions {
                grid-template-columns: repeat(2, 1fr);
            }

            .sidebar-toggle {
                display: inline-flex;
            }
        }

        @media (max-width: 1024px) {
            .stat-row-3 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {

            .main {
                margin-left: 0;
            }

            .stat-row {
                grid-template-columns: repeat(2, 1fr);
            }

            .stat-row-3 {
                grid-template-columns: 1fr;
            }

            .bottom-row {
                grid-template-columns: 1fr;
            }

            .quick-actions {
                grid-template-columns: repeat(2, 1fr);
            }

            .tabs-nav {
                width: 100%;
            }

            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                index: 999;
                box-shadow: none;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .layout {
                position: relative;
            }

            .sidebar-overlay {
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.35);
                z-index: 150;
                display: none;
            }

            .sidebar-overlay.show {
                display: block;
            }
        }

        @media (max-width: 480px) {
            .stat-row {
                grid-template-columns: 1fr;
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }

            .content-body {
                padding: 16px;
            }

            .notif-dropdown {
                position: absolute;
                top: 46px;
                right: -130px;
                width: 280px;
            }

            .notif-dropdown.open {
                display: block;
            }

            .content-header {
                padding: 0px 12px;
            }

            .sidebar__logout {
                display: none;
            }

            .header-account__name {
                word-break: break-all;
                width: 100px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
        }

        @media (min-width: 993px) {

            .menu-header-logout {
                display: flex !important;
                margin-left: 12px;
            }

            .menu-sidebar-logout {
                display: none !important;
            }
        }

        @media (max-width: 992px) {

            .menu-sidebar-logout {
                display: flex !important;
                margin: 20px 14px 10px;
                /* Jarak aman di dasar menu */
                padding: 12px 16px;
                /* Diperbesar agar mudah ditekan di HP/Tablet */
                font-size: 14px;
                background: rgba(204, 51, 51, 0.03);
                border: 1px solid rgba(204, 51, 51, 0.1);
            }
        }
    </style>
    @stack('styles')
</head>

<body>

    <div class="layout">
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        <aside class="sidebar" id="sidebar">
            <div class="sidebar__logo">
                <div class="sidebar__logo-icon">
                    {{-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path
                            d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.174v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z" />
                        <path
                            d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286a48.4 48.4 0 0 1 6.085 2.563.198.198 0 0 0 .14 0c1.2-.538 2.42-1.036 3.561-1.48Z" />
                    </svg> --}}
                    <img src="{{ asset('assets/img/logo.png') }}" alt="logo" width="70" height="50">
                </div>
                <div class="sidebar__logo-text">
                    TK Al-Istiqomah
                    <span>Sistem Sekolah</span>
                </div>
            </div>
            <nav class="sidebar__nav">
                @yield('sidebar')
            </nav>
            <a href="{{ url('/logout') }}" class="sidebar__item_logout menu-sidebar-logout" title="Logout">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M7.5 3.75A1.5 1.5 0 0 0 6 5.25v13.5a1.5 1.5 0 0 0 1.5 1.5h6a1.5 1.5 0 0 0 1.5-1.5V15a.75.75 0 0 1 1.5 0v3.75a3 3 0 0 1-3 3h-6a3 3 0 0 1-3-3V5.25a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3V9A.75.75 0 0 1 15 9V5.25a1.5 1.5 0 0 0-1.5-1.5h-6Zm10.72 4.72a.75.75 0 0 1 1.06 0l3 3a.75.75 0 0 1 0 1.06l-3 3a.75.75 0 1 1-1.06-1.06l1.72-1.72H9a.75.75 0 0 1 0-1.5h10.94l-1.72-1.72a.75.75 0 0 1 0-1.06Z"
                        clip-rule="evenodd" />
                </svg>
                Logout
            </a>
        </aside>

        <div class="main">
            <header class="content-header">
                <div class="content-header__breadcrumb">
                    <button type="button" class="sidebar-toggle" id="sidebarToggle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M3.75 6.75A.75.75 0 0 1 4.5 6h15a.75.75 0 0 1 0 1.5h-15a.75.75 0 0 1-.75-.75Zm0 5.25a.75.75 0 0 1 .75-.75h15a.75.75 0 0 1 0 1.5h-15a.75.75 0 0 1-.75-.75Zm0 5.25a.75.75 0 0 1 .75-.75h15a.75.75 0 0 1 0 1.5h-15a.75.75 0 0 1-.75-.75Z" />
                        </svg>
                    </button>

                    <strong>@yield('page_title', 'Dashboard')</strong>
                </div>
                <div class="content-header__right">
                    @if (auth()->user()->role !== 'admin')
                        @php
                            $notifUserId = auth()->id();
                            $notifRoomIds = \App\Models\ChatRoom::where('user_a_id', $notifUserId)
                                ->orWhere('user_b_id', $notifUserId)
                                ->pluck('id');
                            $notifMsgs = \App\Models\ChatMessage::whereIn('chat_room_id', $notifRoomIds)
                                ->where('sender_id', '!=', $notifUserId)
                                ->where('isRead', false)
                                ->with('sender')
                                ->latest()
                                ->get();
                            $notifCount = $notifMsgs->count();
                            $notifGroups = $notifMsgs
                                ->groupBy('sender_id')
                                ->map(function ($msgs) {
                                    $first = $msgs->first();
                                    return [
                                        'nama' => $first->sender?->name ?? '-',
                                        'initial' => strtoupper(mb_substr($first->sender?->name ?? '?', 0, 1)),
                                        'count' => $msgs->count(),
                                        'preview' => \Illuminate\Support\Str::limit($first->message, 42),
                                        'room_id' => $first->chat_room_id,
                                    ];
                                })
                                ->values();
                            $notifChatRoute = auth()->user()->role === 'guru' ? 'guru.chat' : 'orangtua.chat';
                        @endphp
                        <div class="notif-wrapper">
                            <button class="icon-btn" id="notifBtn" title="Notifikasi">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M5.25 9a6.75 6.75 0 0 1 13.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 0 1-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 1 1-7.48 0 24.585 24.585 0 0 1-4.831-1.244.75.75 0 0 1-.298-1.205A8.217 8.217 0 0 0 5.25 9.75V9Zm4.502 8.9a2.25 2.25 0 1 0 4.496 0 25.057 25.057 0 0 1-4.496 0Z"
                                        clip-rule="evenodd" />
                                </svg>
                                @if ($notifCount > 0)
                                    <span class="notif-badge">{{ $notifCount > 99 ? '99+' : $notifCount }}</span>
                                @endif
                            </button>
                            <div class="notif-dropdown" id="notifDropdown">
                                <div class="notif-dropdown__header">Notifikasi</div>
                                @if ($notifCount > 0)
                                    @foreach ($notifGroups as $group)
                                        <a href="{{ route($notifChatRoute, ['room' => $group['room_id']]) }}"
                                            class="notif-item">
                                            <div class="notif-item__avatar">{{ $group['initial'] }}</div>
                                            <div class="notif-item__body">
                                                <div class="notif-item__name">
                                                    {{ $group['nama'] }}
                                                    <span class="notif-item__count">{{ $group['count'] }}</span>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                @else
                                    <div class="notif-empty">Tidak ada notifikasi terbaru</div>
                                @endif
                            </div>
                        </div>
                    @endif
                    <div class="header-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'P', 0, 1)) }}</div>
                    <div class="header-account">
                        <div class="header-account__name">{{ auth()->user()->name ?? 'Pengguna' }}</div>
                        <div class="header-account__role">
                            @php
                                $roleLabel = match (auth()->user()->role ?? '') {
                                    'admin' => 'Admin',
                                    'guru' => 'Guru',
                                    'orangtua' => 'Orang Tua',
                                    default => ucfirst(auth()->user()->role ?? ''),
                                };
                            @endphp
                            {{ $roleLabel }}
                        </div>
                    </div>
                    <a href="{{ url('/logout') }}" class="sidebar__logout" title="Logout">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M7.5 3.75A1.5 1.5 0 0 0 6 5.25v13.5a1.5 1.5 0 0 0 1.5 1.5h6a1.5 1.5 0 0 0 1.5-1.5V15a.75.75 0 0 1 1.5 0v3.75a3 3 0 0 1-3 3h-6a3 3 0 0 1-3-3V5.25a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3V9A.75.75 0 0 1 15 9V5.25a1.5 1.5 0 0 0-1.5-1.5h-6Zm10.72 4.72a.75.75 0 0 1 1.06 0l3 3a.75.75 0 0 1 0 1.06l-3 3a.75.75 0 1 1-1.06-1.06l1.72-1.72H9a.75.75 0 0 1 0-1.5h10.94l-1.72-1.72a.75.75 0 0 1 0-1.06Z"
                                clip-rule="evenodd" />
                        </svg>
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
    <script>
        (function() {
            const sidebar = document.querySelector('.sidebar');
            const toggle = document.getElementById('sidebarToggle');
            const overlay = document.getElementById('sidebarOverlay');

            if (!sidebar || !toggle || !overlay) return;

            function openSidebar() {
                sidebar.classList.add('open');
                overlay.classList.add('show');
            }

            function closeSidebar() {
                sidebar.classList.remove('open');
                overlay.classList.remove('show');
            }

            toggle.addEventListener('click', function(e) {
                e.stopPropagation();
                sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
            });

            overlay.addEventListener('click', closeSidebar);

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') closeSidebar();
            });
        })();

        (function() {
            var btn = document.getElementById('notifBtn');
            var dropdown = document.getElementById('notifDropdown');
            if (!btn || !dropdown) return;
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdown.classList.toggle('open');
            });
            document.addEventListener('click', function() {
                dropdown.classList.remove('open');
            });
            dropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        })();
    </script>
</body>

</html>
