<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil - TK AL-ISTIQOMAH</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #d1fae5 0%, #E8F5E9 50%, #FFFDE7 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Decorative Background */
        .bg-decoration {
            position: fixed;
            pointer-events: none;
            z-index: 0;
        }

        .circle-1 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.15) 0%, rgba(16, 185, 129, 0.1) 100%);
            border-radius: 50%;
            top: -100px;
            right: -100px;
        }

        .circle-2 {
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, rgba(56, 189, 248, 0.12) 0%, rgba(14, 165, 233, 0.08) 100%);
            border-radius: 50%;
            bottom: 10%;
            left: -80px;
        }

        /* Confetti Animation */
        .confetti {
            position: fixed;
            width: 10px;
            height: 10px;
            background: #fbbf24;
            animation: fall 3s linear infinite;
            opacity: 0.8;
        }

        .confetti:nth-child(1) { left: 10%; animation-delay: 0s; background: #f472b6; }
        .confetti:nth-child(2) { left: 20%; animation-delay: 0.5s; background: #3D9B72; }
        .confetti:nth-child(3) { left: 30%; animation-delay: 1s; background: #4CAF82; }
        .confetti:nth-child(4) { left: 40%; animation-delay: 1.5s; background: #fbbf24; }
        .confetti:nth-child(5) { left: 50%; animation-delay: 0.3s; background: #3D9B72; }
        .confetti:nth-child(6) { left: 60%; animation-delay: 0.8s; background: #a78bfa; }
        .confetti:nth-child(7) { left: 70%; animation-delay: 1.3s; background: #f472b6; }
        .confetti:nth-child(8) { left: 80%; animation-delay: 0.6s; background: #3D9B72; }
        .confetti:nth-child(9) { left: 90%; animation-delay: 1.1s; background: #4CAF82; }

        @keyframes fall {
            0% { transform: translateY(-100vh) rotate(0deg); opacity: 1; }
            100% { transform: translateY(100vh) rotate(720deg); opacity: 0; }
        }

        .success-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
            padding: 48px;
            max-width: 480px;
            width: 90%;
            text-align: center;
            position: relative;
            z-index: 1;
            backdrop-filter: blur(10px);
        }

        .success-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #3D9B72 0%, #16a34a 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 28px;
            box-shadow: 0 10px 30px rgba(34, 197, 94, 0.35);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .success-icon svg {
            width: 50px;
            height: 50px;
            color: white;
        }

        .success-card h1 {
            font-size: 1.75rem;
            font-weight: 800;
            color: #3E2723;
            margin-bottom: 12px;
        }

        .success-card > p {
            color: #5D4037;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 28px;
        }

        .registration-code-box {
            background: linear-gradient(135deg, #FFFDE7 0%, #fef9c3 100%);
            border: 3px dashed #3D9B72;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
        }

        .registration-code-box span {
            display: block;
            font-size: 0.8rem;
            color: #5D4037;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .registration-code-box strong {
            font-size: 2rem;
            font-weight: 800;
            color: #3D9B72;
            letter-spacing: 3px;
        }

        .info-box {
            background: linear-gradient(135deg, #E8F5E9 0%, #bae6fd 100%);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 28px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            text-align: left;
        }

        .info-box svg {
            width: 24px;
            height: 24px;
            color: #0284c7;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .info-box p {
            color: #0369a1;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .button-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .btn-primary {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 16px 28px;
            background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            font-family: inherit;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px rgba(76, 175, 130, 0.35);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(76, 175, 130, 0.4);
        }

        .btn-primary svg {
            width: 20px;
            height: 20px;
        }

        .btn-secondary {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px 28px;
            background: #f1f5f9;
            color: #5D4037;
            border: none;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            font-family: inherit;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
        }

        .btn-secondary svg {
            width: 18px;
            height: 18px;
        }

        .footer {
            margin-top: 24px;
            color: #5D4037;
            font-size: 0.75rem;
        }

        @media (max-width: 480px) {
            .success-card {
                padding: 32px 24px;
            }

            .success-icon {
                width: 80px;
                height: 80px;
            }

            .success-icon svg {
                width: 40px;
                height: 40px;
            }

            .success-card h1 {
                font-size: 1.4rem;
            }

            .registration-code-box strong {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Background Decorations -->
    <div class="bg-decoration circle-1"></div>
    <div class="bg-decoration circle-2"></div>

    <!-- Confetti -->
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>
    <div class="confetti"></div>

    <div class="success-card">
        <div class="success-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <h1>Pendaftaran Berhasil!</h1>
        <p>Terima kasih telah mendaftarkan putra/putri Anda di TK Al-Istiqomah. Data pendaftaran telah kami terima dan akan segera diproses.</p>

        <div class="registration-code-box">
            <span>Kode Pendaftaran</span>
            <strong>{{ $kode_pendaftaran }}</strong>
        </div>

        <div class="info-box">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p>Simpan kode pendaftaran ini untuk mengecek status pendaftaran. Kami akan menghubungi Anda melalui nomor telepon atau email yang terdaftar.</p>
        </div>

        <div class="button-group">
            <a href="{{ route('pendaftaran.cek-status') }}" class="btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                Cek Status Pendaftaran
            </a>
            <a href="{{ route('login') }}" class="btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Kembali ke Beranda
            </a>
        </div>

        <div class="footer">
            &copy; 2026 TK Al-Istiqomah. All rights reserved.
        </div>
    </div>
</body>
</html>
