<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Peoples Bakers')</title>
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Fonts: Plus Jakarta Sans (display), Inter (body), JetBrains Mono (data) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Bakery template styles -->
    <link rel="stylesheet" href="{{ asset('assets/template/bakery.css') }}">

    <!-- Apply saved theme before first paint (avoids flash) -->
    <script>
        (function () {
            try {
                var t = localStorage.getItem('pb-theme');
                if (t) document.documentElement.setAttribute('data-theme', t);
            } catch (e) { }
        })();
    </script>

    @stack('styles')
</head>

<body>

    <div class="sidebar-backdrop" id="backdrop"></div>

    <div class="app-shell">

        {{-- Role-aware sidebar --}}
        @if (Auth::user()->role === 'rep')
            @include('components.bakery.sidebar-rep')
        @elseif (Auth::user()->role === 'shop')
            @include('components.bakery.sidebar-shop')
        @elseif (Auth::user()->role === 'sales_admin')
            @include('components.bakery.sidebar-sales-admin')
        @else
            @include('components.bakery.sidebar-order-admin')
        @endif

        <!-- Main -->
        <div class="main">

            @include('components.bakery.topbar')

            <main class="content">
                @yield('content')
            </main>

        </div>
    </div>

    <!-- Bootstrap bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Template behaviour (theme + mobile sidebar) -->
    <script src="{{ asset('assets/template/bakery.js') }}"></script>

    @stack('scripts')
</body>

</html>
