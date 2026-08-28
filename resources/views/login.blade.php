<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PEOPLES BAKERS | Login</title>
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}">

    <!-- Google Fonts (Inter - Modern & Clean) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: #ffffff;
            color: #1a1a1a;
        }

        .login-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ---------- Left : form panel ---------- */
        .login-panel {
            flex: 0 0 42%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
            background: #fff;
        }

        .login-box {
            width: 100%;
            max-width: 380px;
        }

        .login-box h1 {
            font-size: 1.75rem;
            font-weight: 400;
            margin-bottom: 0.75rem;
            color: #111;
        }

        .login-box h1 strong {
            font-weight: 700;
        }

        .login-subtitle {
            font-size: 0.9rem;
            color: #9aa0a6;
            line-height: 1.5;
            margin-bottom: 2.25rem;
        }

        /* Grouped input card like the reference */
        .input-group-card {
            border: 1px solid #e3e6ea;
            border-radius: 6px;
            background: #fff;
            margin-bottom: 1.1rem;
            overflow: hidden;
        }

        .field {
            padding: 0.7rem 1rem 0.75rem;
        }

        .field+.field {
            border-top: 1px solid #e3e6ea;
        }

        .field label {
            display: block;
            font-size: 0.62rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: #b3b8bf;
            margin-bottom: 0.25rem;
        }

        .field input {
            width: 100%;
            border: none;
            outline: none;
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            color: #222;
            background: transparent;
        }

        .field input::placeholder {
            color: #c2c7cd;
        }

        /* remember / forgot row */
        .options-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 0.45rem;
            font-size: 0.82rem;
            color: #444;
            cursor: pointer;
            user-select: none;
        }

        .remember input {
            width: 15px;
            height: 15px;
            accent-color: #2f80ed;
            cursor: pointer;
        }

        .forgot-link {
            font-size: 0.82rem;
            color: #8a8f96;
            text-decoration: underline;
        }

        .forgot-link:hover {
            color: #2f80ed;
        }

        .error-msg {
            color: #d32f2f;
            font-size: 0.85rem;
            margin-bottom: 1rem;
            min-height: 1rem;
        }

        .btn-login {
            width: 100%;
            padding: 0.85rem;
            background: #2f80ed;
            color: #fff;
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            font-weight: 500;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.15s ease;
        }

        .btn-login:hover {
            background: #1f6fdb;
            transform: translateY(-1px);
        }

        .footer-text {
            margin-top: 2.5rem;
            font-size: 0.78rem;
            color: #b3b8bf;
        }

        /* ---------- Right : image panel ---------- */
        .image-panel {
            flex: 1 1 58%;
            position: relative;
            overflow: hidden;
        }

        .image-panel img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        /* ---------- Responsive ---------- */
        @media (max-width: 820px) {
            .image-panel {
                display: none;
            }

            .login-panel {
                flex: 1 1 100%;
            }
        }
    </style>
</head>

<body>
    <div class="login-wrapper">

        <!-- Left : login form -->
        <div class="login-panel">
            <div class="login-box">
                <h1>Login to <strong>Peoples Bakers</strong></h1>
                <p class="login-subtitle">Welcome back. Please sign in to your account to continue managing your orders.</p>

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="input-group-card">
                        <div class="field">
                            <label for="email">Username</label>
                            <input type="email" id="email" name="email" placeholder="your-email@gmail.com"
                                value="{{ old('email') }}" autocomplete="off" required autofocus>
                        </div>
                        <div class="field">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="Your Password" required>
                        </div>
                    </div>

                    <div class="options-row">
                        <label class="remember">
                            <input type="checkbox" name="remember" checked>
                            Remember me
                        </label>
                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password</a>
                    </div>

                    <div class="error-msg" id="lg_warn">
                        @if ($errors->any())
                            {{ $errors->first() }}
                        @endif
                    </div>

                    <button type="submit" class="btn-login" id="loginbtn">Log In</button>
                </form>

                <div class="footer-text">
                    &copy; {{ date('Y') }} Peoples Bakers
                </div>
            </div>
        </div>

        <!-- Right : image -->
        <div class="image-panel">
            <img src="{{ asset('assets/images/login-bg.jpg') }}" alt="Peoples Bakers">
        </div>

    </div>
</body>

</html>
