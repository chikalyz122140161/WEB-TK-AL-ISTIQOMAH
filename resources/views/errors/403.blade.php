<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak - TK AL-ISTIQOMAH</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Nunito', sans-serif;
            min-height: 100vh;
            background: #FFFDE7;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
            overflow: hidden;
        }

        .bg-circle {
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
        }
        .bg-circle-1 {
            width: 350px; height: 350px;
            background: radial-gradient(circle, rgba(240,98,146,0.10) 0%, transparent 70%);
            top: -120px; right: -80px;
        }
        .bg-circle-2 {
            width: 280px; height: 280px;
            background: radial-gradient(circle, rgba(76,175,130,0.10) 0%, transparent 70%);
            bottom: -80px; left: -60px;
        }
        .bg-circle-3 {
            width: 180px; height: 180px;
            background: radial-gradient(circle, rgba(255,241,118,0.25) 0%, transparent 70%);
            top: 40%; left: 5%;
        }

        .card {
            background: rgba(255,255,255,0.97);
            border-radius: 28px;
            box-shadow: 0 30px 60px -10px rgba(0,0,0,0.12), 0 0 0 1px rgba(255,255,255,0.6);
            padding: 56px 48px;
            max-width: 480px;
            width: 100%;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .icon-wrap {
            width: 96px;
            height: 96px;
            margin: 0 auto 28px;
            background: linear-gradient(135deg, rgba(240,98,146,0.15) 0%, rgba(240,98,146,0.08) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .icon-wrap::before {
            content: '';
            position: absolute;
            inset: -6px;
            border-radius: 50%;
            border: 2px dashed rgba(240,98,146,0.25);
            animation: spin 12s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .icon-wrap svg {
            width: 44px;
            height: 44px;
            color: #d81b72;
        }

        .badge-403 {
            display: inline-block;
            background: rgba(240,98,146,0.12);
            color: #d81b72;
            border: 1.5px solid rgba(240,98,146,0.25);
            border-radius: 20px;
            padding: 4px 16px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 16px;
        }

        h1 {
            font-size: 1.75rem;
            font-weight: 800;
            color: #3E2723;
            margin-bottom: 12px;
            line-height: 1.2;
        }

        .subtitle {
            font-size: 0.95rem;
            color: #6D4C41;
            line-height: 1.65;
            margin-bottom: 0;
        }

        .footer-text {
            margin-top: 28px;
            font-size: 0.75rem;
            color: #A1887F;
        }

        @media (max-width: 480px) {
            .card { padding: 40px 28px; }
            h1 { font-size: 1.45rem; }
        }
    </style>
</head>
<body>
    <div class="bg-circle bg-circle-1"></div>
    <div class="bg-circle bg-circle-2"></div>
    <div class="bg-circle bg-circle-3"></div>

    <div class="card">
        <div class="icon-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>

        <span class="badge-403">403 — Akses Ditolak</span>

        <h1>Anda Tidak Memiliki Akses</h1>
        <p class="subtitle">
            Halaman yang Anda coba buka tidak tersedia untuk akun Anda.
            Setiap peran hanya dapat mengakses area yang sesuai.
        </p>


        <p class="footer-text">&copy; {{ date('Y') }} TK Al-Istiqomah. All rights reserved.</p>
    </div>
</body>
</html>
