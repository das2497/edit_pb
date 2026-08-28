<!-- Shared auth theme — matches login.blade.php bakery design -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --crust: #2B1B12;
        --crust-soft: #4A3222;
        --wheat: #C89B3C;
        --wheat-deep: #A9812E;
        --flour: #FBF7F0;
        --flour-dim: #F1EADC;
        --line: #E4D9C6;
        --taupe: #8B7864;
        --paprika: #B5482F;
        --basil: #4A7C43;
    }

    * { box-sizing: border-box; }

    body {
        font-family: 'Inter', sans-serif;
        background: var(--flour);
        color: var(--crust);
        min-height: 100vh;
    }

    .login-shell { min-height: 100vh; }

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

    .error-msg {
        color: var(--paprika);
        background: rgba(181, 72, 47, 0.08);
        border: 1px solid rgba(181, 72, 47, 0.25);
        border-radius: 8px;
        font-size: 0.85rem;
        padding: 0.55rem 0.8rem;
        margin-bottom: 1rem;
    }

    .status-msg {
        color: var(--basil);
        background: rgba(74, 124, 67, 0.08);
        border: 1px solid rgba(74, 124, 67, 0.3);
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

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        margin-top: 1.5rem;
        font-size: 0.85rem;
        color: var(--taupe);
        text-decoration: none;
        border-bottom: 1px solid var(--line);
    }

    .back-link:hover { color: var(--wheat-deep); border-color: var(--wheat-deep); }

    .footer-text {
        margin-top: 2.5rem;
        font-size: 0.78rem;
        color: #C7BCA9;
    }

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
