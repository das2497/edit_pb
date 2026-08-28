<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peoples Bakers | Forgot Password</title>
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}">

    @include('auth.partials.auth-theme')
</head>

<body>
    <div class="login-shell d-flex">
        <div class="row g-0 flex-grow-1 w-100">

            <!-- Left : forgot password form -->
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

                    <h1>Forgot your <strong>password?</strong></h1>
                    <p class="login-subtitle">No problem. Enter the email address linked to your account and we'll send you a link to reset your password.</p>

                    @if (session('status'))
                        <div class="status-msg">{{ session('status') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="error-msg">{{ $errors->first() }}</div>
                    @endif

                    <form action="{{ route('password.email') }}" method="POST" id="forgotForm">
                        @csrf

                        <div class="input-group-card">
                            <div class="field">
                                <label for="email">Email address</label>
                                <input type="email" id="email" name="email" placeholder="your-email@gmail.com"
                                    value="{{ old('email') }}" autocomplete="off" required autofocus>
                            </div>
                        </div>

                        <button type="submit" class="btn-login" id="sendbtn">
                            <span class="spinner" id="sendSpinner"></span>
                            <span id="sendBtnText">Email password reset link</span>
                        </button>
                    </form>

                    <a href="{{ route('login') }}" class="back-link">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                        Back to login
                    </a>

                    <div class="footer-text">&copy; {{ date('Y') }} Peoples Bakers</div>
                </div>
            </div>

            <!-- Right : image -->
            <div class="col-lg-7 image-panel d-none d-lg-block">
                <img src="{{ asset('assets/images/login-bg.jpg') }}" alt="Peoples Bakers">
                <div class="image-overlay"></div>
                <div class="image-caption">
                    <div class="eyebrow">Account recovery</div>
                    <h2>We'll get you back to your orders in no time.</h2>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.getElementById('forgotForm').addEventListener('submit', function () {
            document.getElementById('sendSpinner').style.display = 'inline-block';
            document.getElementById('sendBtnText').textContent = 'Sending…';
            document.getElementById('sendbtn').disabled = true;
        });
    </script>
</body>

</html>
