<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TK AL-ISTIQOMAH</title>
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
            background: linear-gradient(135deg, #FFFDE7 0%, #F9FBE7 50%, #E8F5E9 100%);
            display: flex;
            position: relative;
            overflow-x: hidden;
        }

        /* Decorative Background Elements */
        .bg-decoration {
            position: fixed;
            pointer-events: none;
            z-index: 0;
        }

        .circle-1 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, rgba(76, 175, 130, 0.15) 0%, rgba(61, 155, 114, 0.1) 100%);
            border-radius: 50%;
            top: -100px;
            left: -100px;
        }

        .circle-2 {
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, rgba(244, 114, 182, 0.12) 0%, rgba(236, 72, 153, 0.08) 100%);
            border-radius: 50%;
            top: 60%;
            left: 10%;
        }

        .circle-3 {
            width: 250px;
            height: 250px;
            background: linear-gradient(135deg, rgba(56, 189, 248, 0.12) 0%, rgba(14, 165, 233, 0.08) 100%);
            border-radius: 50%;
            bottom: -80px;
            right: -80px;
        }

        .circle-4 {
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, rgba(74, 222, 128, 0.12) 0%, rgba(34, 197, 94, 0.08) 100%);
            border-radius: 50%;
            top: 20%;
            right: 15%;
        }

        /* Wave decoration at bottom */
        .wave-bottom {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 120px;
            z-index: 0;
        }

        /* Main Layout */
        .main-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        .login-wrapper {
            display: flex;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(255, 255, 255, 0.5);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            backdrop-filter: blur(10px);
        }

        /* Left side - Illustration */
        .illustration-side {
            flex: 1;
            background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 30%, #2E8B60 60%, #E8F5E9 100%);
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
            min-height: 500px;
        }

        .illustration-side::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
        }

        .illustration-side::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -30px;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .illustration-content {
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .school-illustration {
            width: 200px;
            height: 200px;
            margin-bottom: 24px;
        }

        .illustration-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 12px;
        }

        .illustration-subtitle {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.6;
            max-width: 280px;
        }

        /* Decorative shapes inside illustration */
        .shape {
            position: absolute;
            opacity: 0.2;
        }

        .shape-star {
            width: 30px;
            height: 30px;
            top: 20%;
            left: 15%;
        }

        .shape-heart {
            width: 25px;
            height: 25px;
            bottom: 25%;
            right: 20%;
        }

        .shape-book {
            width: 35px;
            height: 35px;
            top: 70%;
            left: 25%;
        }

        /* Right side - Login Form */
        .login-side {
            flex: 1;
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo-container {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 100%);
            border-radius: 18px;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 16px rgba(76, 175, 130, 0.25);
        }

        .logo-container svg {
            width: 36px;
            height: 36px;
            color: white;
        }

        .login-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #3E2723;
            margin-bottom: 4px;
        }

        .login-subtitle {
            font-size: 0.9rem;
            color: #5D4037;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #3E2723;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper svg {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            color: #5D4037;
            transition: color 0.2s;
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px 14px 46px;
            border: 2px solid #3E272320;
            border-radius: 12px;
            font-size: 0.95rem;
            font-family: inherit;
            color: #3E2723;
            background: #FFFDE7;
            transition: all 0.2s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #3D9B72;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(76, 175, 130, 0.1);
        }

        .form-group input:focus + svg,
        .input-wrapper:focus-within svg {
            color: #3D9B72;
        }

        .form-group input::placeholder {
            color: #5D4037;
        }

        /* Login Button */
        .btn-login {
            width: 100%;
            padding: 16px 24px;
            background: linear-gradient(135deg, #3D9B72 0%, #2E8B60 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px rgba(76, 175, 130, 0.35);
            margin-top: 8px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(76, 175, 130, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Error Message */
        .error-message {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border: 1px solid #fecaca;
            color: #c0392b;
            padding: 14px 16px;
            border-radius: 12px;
            font-size: 0.875rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .error-message svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        /* Role Section */
        .role-section {
            margin-top: 28px;
            padding-top: 24px;
            border-top: 1px solid #3E272320;
        }

        .role-title {
            text-align: center;
            font-size: 0.8rem;
            color: #5D4037;
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .role-badges {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .role-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .role-badge svg {
            width: 16px;
            height: 16px;
        }

        .role-badge.admin {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #2E8B60;
        }

        .role-badge.guru {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #047857;
        }

        .role-badge.ortu {
            background: #FFF176;
            color: #5D4037;
        }

        /* Registration Section */
        .registration-section {
            margin-top: 24px;
            text-align: center;
        }

        .registration-text {
            font-size: 0.875rem;
            color: #5D4037;
            margin-bottom: 12px;
        }

        .btn-register {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: linear-gradient(135deg, #3D9B72 0%, #16a34a 100%);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px rgba(34, 197, 94, 0.3);
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(34, 197, 94, 0.35);
        }

        .btn-register svg {
            width: 18px;
            height: 18px;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 16px;
            color: #5D4037;
            font-size: 0.75rem;
            margin-top: 20px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                background: linear-gradient(180deg, #4CAF82 0%, #3D9B72 15%, #FFFDE7 30%, #F9FBE7 60%, #E8F5E9 100%);
            }

            .main-container {
                padding: 16px;
                align-items: flex-start;
                padding-top: 20px;
            }

            .login-wrapper {
                flex-direction: column;
                max-width: 400px;
            }

            .illustration-side {
                min-height: auto;
                padding: 32px 24px;
            }

            .school-illustration {
                width: 120px;
                height: 120px;
                margin-bottom: 16px;
            }

            .illustration-title {
                font-size: 1.35rem;
            }

            .illustration-subtitle {
                font-size: 0.9rem;
            }

            .login-side {
                padding: 32px 24px;
            }

            .login-header {
                margin-bottom: 24px;
            }

            .logo-container {
                width: 60px;
                height: 60px;
                border-radius: 14px;
            }

            .logo-container svg {
                width: 28px;
                height: 28px;
            }

            .login-title {
                font-size: 1.25rem;
            }

            .role-badges {
                gap: 8px;
            }

            .role-badge {
                padding: 6px 12px;
                font-size: 0.75rem;
            }
        }

        @media (max-width: 480px) {
            .main-container {
                padding: 12px;
            }

            .illustration-side {
                padding: 24px 20px;
            }

            .login-side {
                padding: 24px 20px;
            }

            .form-group input {
                padding: 12px 14px 12px 42px;
            }

            .btn-login {
                padding: 14px 20px;
            }

            .role-badges {
                flex-direction: column;
                align-items: center;
            }

            .role-badge {
                width: 100%;
                justify-content: center;
            }
        }

        /* Large screens */
        @media (min-width: 1200px) {
            .login-wrapper {
                max-width: 1000px;
            }

            .illustration-side {
                padding: 60px;
            }

            .school-illustration {
                width: 240px;
                height: 240px;
            }

            .login-side {
                padding: 60px 50px;
            }
        }

        /* Demo Credentials Styles */
        .demo-credentials {
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfeff 100%);
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .demo-title {
            font-size: 0.75rem;
            font-weight: 600;
            color: #166534;
            margin-bottom: 0.5rem;
        }

        .demo-list {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-bottom: 0.5rem;
        }

        .demo-item {
            display: flex;
            align-items: center;
            gap: 0.35rem;
            background: white;
            border: 1px solid #3E272330;
            border-radius: 6px;
            padding: 0.35rem 0.6rem;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.75rem;
        }

        .demo-item:hover {
            border-color: #3E2723;
            background: #f0fdf4;
        }

        .demo-role {
            font-weight: 600;
            font-size: 0.65rem;
            padding: 0.15rem 0.4rem;
            border-radius: 4px;
        }

        .demo-role.admin {
            background: #d1fae5;
            color: #2E8B60;
        }

        .demo-role.guru {
            background: #FFF176;
            color: #92400e;
        }

        .demo-role.ortu {
            background: #F9FBE7;
            color: #9d174d;
        }

        .demo-email {
            color: #3E2723;
        }

        .demo-password {
            font-size: 0.75rem;
            color: #5D4037;
            margin: 0;
        }

        .demo-password strong {
            color: #3E2723;
            font-family: monospace;
            background: #FFFDE7;
            padding: 0.1rem 0.4rem;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <!-- Background Decorations -->
    <div class="bg-decoration circle-1"></div>
    <div class="bg-decoration circle-2"></div>
    <div class="bg-decoration circle-3"></div>
    <div class="bg-decoration circle-4"></div>

    <!-- Wave Bottom -->
    <svg class="wave-bottom" viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0 120L60 105C120 90 240 60 360 50C480 40 600 50 720 60C840 70 960 80 1080 75C1200 70 1320 50 1380 40L1440 30V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="rgba(255,255,255,0.4)"/>
        <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 80C1200 80 1320 70 1380 65L1440 60V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="rgba(255,255,255,0.6)"/>
    </svg>

    <div class="main-container">
        <div class="login-wrapper">
            <!-- Left Side - Illustration -->
            <div class="illustration-side">
                <!-- Decorative Shapes -->
                <svg class="shape shape-star" viewBox="0 0 24 24" fill="white">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                <svg class="shape shape-heart" viewBox="0 0 24 24" fill="white">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
                <svg class="shape shape-book" viewBox="0 0 24 24" fill="white">
                    <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/>
                </svg>

                <div class="illustration-content">
                    <!-- School Building SVG Illustration -->
                    <svg class="school-illustration" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Sky elements -->
                        <circle cx="160" cy="30" r="20" fill="rgba(255,255,255,0.3)"/>
                        <circle cx="40" cy="45" r="12" fill="rgba(255,255,255,0.25)"/>
                        <circle cx="30" cy="25" r="8" fill="rgba(255,255,255,0.2)"/>
                        
                        <!-- Ground -->
                        <ellipse cx="100" cy="185" rx="90" ry="12" fill="rgba(255,255,255,0.2)"/>
                        
                        <!-- Main Building -->
                        <rect x="40" y="90" width="120" height="80" rx="4" fill="white"/>
                        
                        <!-- Roof -->
                        <path d="M30 95L100 50L170 95H30Z" fill="#fff5eb"/>
                        <path d="M40 90L100 55L160 90" stroke="#3D9B72" stroke-width="3" fill="none"/>
                        
                        <!-- Flag pole -->
                        <rect x="97" y="30" width="6" height="30" fill="#3D9B72"/>
                        <path d="M103 30L103 45L118 37.5L103 30Z" fill="#F06292"/>
                        
                        <!-- Windows row 1 -->
                        <rect x="52" y="105" width="25" height="20" rx="2" fill="#fcd34d"/>
                        <rect x="87" y="105" width="25" height="20" rx="2" fill="#fcd34d"/>
                        <rect x="122" y="105" width="25" height="20" rx="2" fill="#fcd34d"/>
                        
                        <!-- Window details -->
                        <line x1="64.5" y1="105" x2="64.5" y2="125" stroke="white" stroke-width="2"/>
                        <line x1="52" y1="115" x2="77" y2="115" stroke="white" stroke-width="2"/>
                        <line x1="99.5" y1="105" x2="99.5" y2="125" stroke="white" stroke-width="2"/>
                        <line x1="87" y1="115" x2="112" y2="115" stroke="white" stroke-width="2"/>
                        <line x1="134.5" y1="105" x2="134.5" y2="125" stroke="white" stroke-width="2"/>
                        <line x1="122" y1="115" x2="147" y2="115" stroke="white" stroke-width="2"/>
                        
                        <!-- Door -->
                        <rect x="85" y="140" width="30" height="35" rx="15 15 0 0" fill="#3D9B72"/>
                        <circle cx="108" cy="160" r="3" fill="#fcd34d"/>
                        
                        <!-- Trees -->
                        <ellipse cx="25" cy="150" rx="18" ry="25" fill="#3D9B72"/>
                        <rect x="22" y="165" width="6" height="15" fill="#a16207"/>
                        <ellipse cx="175" cy="152" rx="16" ry="22" fill="#16a34a"/>
                        <rect x="172" y="167" width="6" height="13" fill="#a16207"/>
                        
                        <!-- Small flowers -->
                        <circle cx="55" cy="178" r="4" fill="#f472b6"/>
                        <circle cx="65" cy="180" r="3" fill="#fbbf24"/>
                        <circle cx="135" cy="179" r="4" fill="#a78bfa"/>
                        <circle cx="145" cy="177" r="3" fill="#f472b6"/>
                        
                        <!-- Children silhouettes -->
                        <circle cx="70" cy="165" r="5" fill="#5D4037"/>
                        <ellipse cx="70" cy="177" rx="4" ry="6" fill="#5D4037"/>
                        <circle cx="130" cy="166" r="5" fill="#5D4037"/>
                        <ellipse cx="130" cy="178" rx="4" ry="6" fill="#5D4037"/>
                    </svg>

                    <h2 class="illustration-title">Selamat Datang!</h2>
                    <p class="illustration-subtitle">Sistem Informasi Pendidikan TK Al-Istiqomah untuk memantau perkembangan anak tercinta</p>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="login-side">
                <div class="login-header">
                    <div class="logo-container">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h1 class="login-title">TK AL-ISTIQOMAH</h1>
                    <p class="login-subtitle">Masuk ke akun Anda</p>
                </div>

                <!-- Demo Credentials -->
                <div class="demo-credentials">
                    <p class="demo-title">Demo Login:</p>
                    <div class="demo-list">
                        <div class="demo-item" onclick="fillCredentials('admin@mail.com')">
                            <span class="demo-role admin">Admin</span>
                            <span class="demo-email">admin@mail.com</span>
                        </div>
                        <div class="demo-item" onclick="fillCredentials('guru@mail.com')">
                            <span class="demo-role guru">Guru</span>
                            <span class="demo-email">guru@mail.com</span>
                        </div>
                        <div class="demo-item" onclick="fillCredentials('ortu@mail.com')">
                            <span class="demo-role ortu">Ortu</span>
                            <span class="demo-email">ortu@mail.com</span>
                        </div>
                    </div>
                    <p class="demo-password">Password: <strong>password</strong></p>
                </div>

                @if ($errors->any())
                    <div class="error-message">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                        </span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.process') }}">
                    @csrf

                    <div class="form-group">
                        <label>Email</label>
                        <div class="input-wrapper">
                            <input type="text" name="email" value="{{ old('email') }}" placeholder="Masukkan email Anda" required autofocus>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-wrapper">
                            <input type="password" name="password" placeholder="Masukkan password" required>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                    </div>

                    <button type="submit" class="btn-login">MASUK</button>
                </form>

                <div class="role-section">
                    <p class="role-title">Login sebagai</p>
                    <div class="role-badges">
                        <span class="role-badge admin">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Admin
                        </span>
                        <span class="role-badge guru">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Guru
                        </span>
                        <span class="role-badge ortu">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Orang Tua
                        </span>
                    </div>
                </div>

                <div class="registration-section">
                    <p class="registration-text">Belum terdaftar sebagai siswa?</p>
                    <a href="{{ route('pendaftaran.create') }}" class="btn-register">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        DAFTAR SISWA BARU
                    </a>
                </div>

                <div class="footer">
                    &copy; 2026 TK Al-Istiqomah. All rights reserved.
                </div>
            </div>
        </div>
    </div>

    <script>
    function fillCredentials(email) {
        document.querySelector('input[name="email"]').value = email;
        document.querySelector('input[name="password"]').value = 'password';
        document.querySelector('input[name="email"]').focus();
    }
    </script>
</body>
</html>
