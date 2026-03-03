<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TK AL-ISTIQOMAH</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #e8e8e8;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .top-bar {
            width: 100%;
            height: 8px;
            background-color: #00bcd4;
        }

        .bottom-bar {
            width: 100%;
            height: 8px;
            background-color: #00bcd4;
            margin-top: auto;
        }

        .container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .login-box {
            width: 100%;
            max-width: 480px;
        }

        .breadcrumb {
            color: #555;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .breadcrumb span {
            margin-right: 4px;
        }

        .logo-placeholder {
            width: 100%;
            height: 120px;
            background-color: #9e9e9e;
            border-radius: 2px;
            margin-bottom: 16px;
        }

        .school-name {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            color: #222;
            margin-bottom: 28px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            color: #333;
            margin-bottom: 6px;
        }

        .form-group input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 14px;
            background: #fff;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-group input:focus {
            border-color: #00bcd4;
        }

        .btn-masuk {
            background-color: #555;
            color: #fff;
            border: none;
            padding: 10px 28px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 3px;
            cursor: pointer;
            letter-spacing: 1px;
            transition: background-color 0.2s;
        }

        .btn-masuk:hover {
            background-color: #333;
        }

        .error-message {
            background-color: #ffebee;
            border: 1px solid #ef5350;
            color: #c62828;
            padding: 10px 14px;
            border-radius: 3px;
            font-size: 13px;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
    <div class="top-bar"></div>

    <div class="container">
        <div class="login-box">
            <div class="breadcrumb">
                <span>🏠</span> HALAMAN LOGIN
            </div>

            <div class="logo-placeholder"></div>

            <div class="school-name">TK AL-ISTIQOMAH</div>

            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login.process') }}">
                @csrf

                <div class="form-group">
                    <label>Email / Username :</label>
                    <input type="text" name="email" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label>Password :</label>
                    <input type="password" name="password" required>
                </div>

                <button type="submit" class="btn-masuk">MASUK</button>
            </form>
        </div>
    </div>

    <div class="bottom-bar"></div>
</body>
</html>
