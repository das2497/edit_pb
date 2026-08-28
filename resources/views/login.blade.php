<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peoples Bakers | Login</title>
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts: Fraunces (bakery-warm display serif) + Inter (clean UI sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --crust: #2B1B12;      /* deep espresso-crust brown, primary text/ink */
            --crust-soft: #4A3222; /* softer brown for secondary ink */
            --wheat: #C89B3C;      /* toasted wheat gold, accent */
            --wheat-deep: #A9812E; /* pressed state of accent */
            --flour: #FBF7F0;      /* warm flour-white background */
            --flour-dim: #F1EADC; /* card / field background */
            --line: #E4D9C6;       /* hairline borders */
            --taupe: #8B7864;      /* muted secondary text */
            --paprika: #B5482F;    /* error/alert */
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--flour);
            color: var(--crust);
            min-height: 100vh;
        }

        .login-shell { min-height: 100vh; }

        /* ---------- Left : form panel ---------- */
        .login-panel {
            background: var(--flour);
            position: relative;
            padding: 3rem 1.5rem;
        }

        .login-box { width: 100%; max-width: 400px; }

        .brand-row {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 2.5rem;
        }

        .brand-row img {
            width: 42px;
            height: 42px;
            object-fit: contain;
            border-radius: 8px;
        }

        .brand-row span {
            font-family: 'Fraunces', serif;
            font-weight: 600;
            font-size: 1.15rem;
            letter-spacing: 0.01em;
            color: var(--crust);
        }

        /* wheat-stalk score mark — the signature divider, echoes a baker's bread score */
        .score-mark {
            display: block;
            width: 46px;
            height: 10px;
            margin-bottom: 1.25rem;
            opacity: 0.85;
        }

        .login-box h1 {
            font-family: 'Fraunces', serif;
            font-weight: 500;
            font-size: 2rem;
            line-height: 1.2;
            margin-bottom: 0.6rem;
            color: var(--crust);
        }

        .login-box h1 strong { font-weight: 700; }

        .login-subtitle {
            font-size: 0.92rem;
            color: var(--taupe);
            line-height: 1.55;
            margin-bottom: 2.25rem;
        }

        .input-group-card {
            border: 1px solid var(--line);
            border-radius: 10px;
            background: #fff;
            margin-bottom: 1.15rem;
            overflow: hidden;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .input-group-card:focus-within {
            border-color: var(--wheat);
            box-shadow: 0 0 0 3px rgba(200, 155, 60, 0.18);
        }

        .field { padding: 0.65rem 1rem 0.7rem; position: relative; }
        .field + .field { border-top: 1px solid var(--line); }

        .field label {
            display: block;
            font-size: 0.66rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--taupe);
            margin-bottom: 0.25rem;
        }

        .field input {
            width: 100%;
            border: none;
            outline: none;
            font-family: 'Inter', sans-serif;
            font-size: 0.97rem;
            color: var(--crust);
            background: transparent;
            padding-right: 1.75rem;
        }

        .field input::placeholder { color: #C7BCA9; }

        .toggle-pass {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(6%);
            background: none;
            border: none;
            padding: 0;
            color: var(--taupe);
            cursor: pointer;
            line-height: 0;
        }

        .toggle-pass:hover { color: var(--crust); }

        .options-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.75rem;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: var(--crust-soft);
            cursor: pointer;
            user-select: none;
        }

        .remember input {
            width: 15px;
            height: 15px;
            accent-color: var(--wheat-deep);
            cursor: pointer;
        }

        .forgot-link {
            font-size: 0.85rem;
            color: var(--taupe);
            text-decoration: none;
            border-bottom: 1px solid var(--line);
        }

        .forgot-link:hover { color: var(--wheat-deep); border-color: var(--wheat-deep); }

        .error-msg {
            color: var(--paprika);
            background: rgba(181, 72, 47, 0.08);
            border: 1px solid rgba(181, 72, 47, 0.25);
            border-radius: 8px;
            font-size: 0.85rem;
            padding: 0.55rem 0.8rem;
            margin-bottom: 1rem;
        }

        .btn-login {
            width: 100%;
            padding: 0.85rem;
            background: var(--crust);
            color: #fff;
            font-family: 'Inter', sans-serif;
            font-size: 0.96rem;
            font-weight: 600;
            letter-spacing: 0.01em;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.15s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-login:hover { background: #1c110b; transform: translateY(-1px); }
        .btn-login:disabled { opacity: 0.75; cursor: progress; transform: none; }

        .spinner {
            width: 15px; height: 15px;
            border: 2px solid rgba(255,255,255,0.35);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            display: none;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        .footer-text {
            margin-top: 2.5rem;
            font-size: 0.78rem;
            color: #C7BCA9;
        }

        /* ---------- Right : image panel ---------- */
        .image-panel {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
        }

        .image-panel img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(43,27,18,0.05) 0%, rgba(43,27,18,0.75) 100%);
        }

        .image-caption {
            position: absolute;
            left: 2.5rem;
            right: 2.5rem;
            bottom: 2.75rem;
            color: #fff;
        }

        .image-caption .eyebrow {
            font-size: 0.72rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--wheat);
            font-weight: 600;
            margin-bottom: 0.6rem;
        }

        .image-caption h2 {
            font-family: 'Fraunces', serif;
            font-weight: 500;
            font-size: 1.7rem;
            line-height: 1.3;
            max-width: 420px;
        }

        @media (max-width: 991.98px) {
            .login-panel { padding: 2.5rem 1.25rem; min-height: 100vh; }
        }
    </style>
</head>

<body>
    <div class="login-shell d-flex">
        <div class="row g-0 flex-grow-1 w-100">

            <!-- Left : login form -->
            <div class="col-lg-5 login-panel d-flex align-items-center justify-content-center">
                <div class="login-box">

                    <div class="brand-row">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Peoples Bakers logo">
                        <span>PEOPLES BAKERS</span>
                    </div>

                    <svg class="score-mark" viewBox="0 0 46 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 5 L11 1 L11 9 Z" fill="#C89B3C"/>
                        <path d="M15 5 L25 1 L25 9 Z" fill="#C89B3C" opacity="0.7"/>
                        <path d="M29 5 L39 1 L39 9 Z" fill="#C89B3C" opacity="0.45"/>
                    </svg>

                    <h1>Login to <strong>Peoples Bakers</strong></h1>
                    <p class="login-subtitle">Welcome back. Please sign in to your account to continue managing your orders.</p>

                    @if ($errors->any())
                        <div class="error-msg">{{ $errors->first() }}</div>
                    @endif

                    <form action="{{ route('login') }}" method="POST" id="loginForm">
                        @csrf
                        <div class="input-group-card">
                            <div class="field">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" placeholder="your-email@gmail.com"
                                    value="{{ old('email') }}" autocomplete="off" required autofocus>
                            </div>
                            <div class="field">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" placeholder="Your password" required>
                                <button type="button" class="toggle-pass" id="togglePass" aria-label="Show password">
                                    <svg id="eyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="options-row">
                            <label class="remember">
                                <input type="checkbox" name="remember" checked>
                                Remember me
                            </label>
                            <a href="{{ route('password.request') }}" class="forgot-link">Forgot password</a>
                        </div>

                        <button type="submit" class="btn-login" id="loginbtn">
                            <span class="spinner" id="loginSpinner"></span>
                            <span id="loginBtnText">Log in</span>
                        </button>
                    </form>

                    <div class="footer-text">&copy; {{ date('Y') }} Peoples Bakers</div>
                </div>
            </div>

            <!-- Right : image -->
            <div class="col-lg-7 image-panel d-none d-lg-block">
                <img src="{{ asset('assets/images/login-bg.jpg') }}" alt="Peoples Bakers">
                <div class="image-overlay"></div>
                <div class="image-caption">
                    <div class="eyebrow">Order management</div>
                    <h2>Every loaf, every order, tracked from oven to doorstep.</h2>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show / hide password
        const togglePass = document.getElementById('togglePass');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        togglePass.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            eyeIcon.innerHTML = isPassword
                ? '<path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a21.5 21.5 0 0 1 5.06-6.06M9.9 4.24A10.94 10.94 0 0 1 12 5c7 0 11 7 11 7a21.5 21.5 0 0 1-3.22 4.3M1 1l22 22"></path><path d="M14.12 14.12A3 3 0 1 1 9.88 9.88"></path>'
                : '<path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"></path><circle cx="12" cy="12" r="3"></circle>';
        });

        // Loading state on submit
        document.getElementById('loginForm').addEventListener('submit', function () {
            const btn = document.getElementById('loginbtn');
            document.getElementById('loginSpinner').style.display = 'inline-block';
            document.getElementById('loginBtnText').textContent = 'Logging in…';
            btn.disabled = true;
        });
    </script>
</body>

</html>