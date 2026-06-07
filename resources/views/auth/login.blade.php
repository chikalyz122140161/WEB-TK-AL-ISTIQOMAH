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
            background: #FFFDE7;
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
            background: linear-gradient(135deg, rgba(240, 98, 146, 0.12) 0%, rgba(240, 98, 146, 0.08) 100%);
            border-radius: 50%;
            top: 60%;
            left: 10%;
        }

        .circle-3 {
            width: 250px;
            height: 250px;
            background: linear-gradient(135deg, rgba(76, 175, 130, 0.12) 0%, rgba(76, 175, 130, 0.08) 100%);
            border-radius: 50%;
            bottom: -80px;
            right: -80px;
        }

        .circle-4 {
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, rgba(76, 175, 130, 0.12) 0%, rgba(76, 175, 130, 0.08) 100%);
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
            background: linear-gradient(135deg, #4CAF82 0%, #3D9B72 30%, #2E8B60 60%, #FFFDE7 100%);
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
            min-height: 500px;
        }

        .illustration-content {
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .illustration-content img {
            width: 250px;
            height: 300px;
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
            background: linear-gradient(135deg, #F0629220 0%, #F0629220 100%);
            border: 1px solid #F0629230;
            color: #d81b72;
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
            background: linear-gradient(135deg, #4CAF8230 0%, #4CAF8230 100%);
            color: #2E8B60;
        }

        .role-badge.guru {
            background: linear-gradient(135deg, #4CAF8230 0%, #4CAF8230 100%);
            color: #2E8B60;
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
            background: linear-gradient(135deg, #3D9B72 0%, #4CAF82 100%);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px rgba(76, 175, 130, 0.3);
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(76, 175, 130, 0.35);
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
                background: linear-gradient(180deg, #4CAF82 0%, #3D9B72 15%, #FFFDE7 30%, #FFFDE7 60%, #FFFDE7 100%);
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

            .school-illustration {
                width: 120px;
                height: 120px;
                margin-bottom: 16px;
            }

            .illustration-side {
                padding: 14px 10px;
            }

            .illustration-title {
                font-size: 1.35rem;
            }

            .illustration-subtitle {
                font-size: 0.9rem;
                max-width: 400px;
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
                padding: 14px 10px;
                min-height: 100px;
            }

            .illustration-side img {
                width: 100px;
                height: 150px;
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
            background: linear-gradient(135deg, #4CAF8220 0%, #4CAF8220 100%);
            border: 1px solid #4CAF8230;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .demo-title {
            font-size: 0.75rem;
            font-weight: 600;
            color: #3E2723;
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
            background: #4CAF8220;
        }

        .demo-role {
            font-weight: 600;
            font-size: 0.65rem;
            padding: 0.15rem 0.4rem;
            border-radius: 4px;
        }

        .demo-role.admin {
            background: #4CAF8230;
            color: #2E8B60;
        }

        .demo-role.guru {
            background: #FFF176;
            color: #3E2723;
        }

        .demo-role.ortu {
            background: #FFFDE7;
            color: #d81b72;
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

    <div class="main-container">
        <div class="login-wrapper">
            <!-- Left Side - Illustration -->
            <div class="illustration-side">

                <div class="illustration-content">
                    <!-- School Building SVG Illustration -->
                    <img src="{{ asset('assets/img/logo.png') }}" alt="logo">

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
                        <div class="demo-item" onclick="fillCredentials('admin@tkalistiqomah.sch.id')">
                            <span class="demo-role admin">Admin</span>
                            <span class="demo-email">admin@tkalistiqomah.sch.id</span>
                        </div>
                        <div class="demo-item" onclick="fillCredentials('reita.wigianti@tkalistiqomah.sch.id')">
                            <span class="demo-role guru">Guru</span>
                            <span class="demo-email">reita.wigianti@tkalistiqomah.sch.id</span>
                        </div>
                        <div class="demo-item" onclick="fillCredentials('ortu1@tkalistiqomah.sch.id')">
                            <span class="demo-role ortu">Ortu</span>
                            <span class="demo-email">ortu1@tkalistiqomah.sch.id</span>
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
