<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peoples Bakers | Reset Password</title>
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}">

    @include('auth.partials.auth-theme')
</head>

<body>
    <div class="login-shell d-flex">
        <div class="row g-0 flex-grow-1 w-100">

            <!-- Left : reset password form -->
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

                    <h1>Set a new <strong>password</strong></h1>
                    <p class="login-subtitle">Choose a strong new password for your account. You'll be able to log in with it right away.</p>

                    @if ($errors->any())
                        <div class="error-msg">{{ $errors->first() }}</div>
                    @endif

                    <form action="{{ route('password.store') }}" method="POST" id="resetForm">
                        @csrf

                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="input-group-card">
                            <div class="field">
                                <label for="email">Email address</label>
                                <input type="email" id="email" name="email" placeholder="your-email@gmail.com"
                                    value="{{ old('email', $request->email) }}" autocomplete="username" required autofocus>
                            </div>
                            <div class="field">
                                <label for="password">New password</label>
                                <input type="password" id="password" name="password" placeholder="New password"
                                    autocomplete="new-password" required>
                                <button type="button" class="toggle-pass" data-target="password" aria-label="Show password">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                            <div class="field">
                                <label for="password_confirmation">Confirm new password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    placeholder="Repeat new password" autocomplete="new-password" required>
                                <button type="button" class="toggle-pass" data-target="password_confirmation" aria-label="Show password">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn-login" id="resetbtn">
                            <span class="spinner" id="resetSpinner"></span>
                            <span id="resetBtnText">Reset password</span>
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
                    <h2>Fresh password, fresh start — back to the bakery.</h2>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Show / hide password toggles
        document.querySelectorAll('.toggle-pass').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const input = document.getElementById(btn.dataset.target);
                input.type = input.type === 'password' ? 'text' : 'password';
            });
        });

        // Loading state
        document.getElementById('resetForm').addEventListener('submit', function () {
            document.getElementById('resetSpinner').style.display = 'inline-block';
            document.getElementById('resetBtnText').textContent = 'Resetting…';
            document.getElementById('resetbtn').disabled = true;
        });
    </script>
</body>

</html>
