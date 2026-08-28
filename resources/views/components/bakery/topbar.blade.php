<header class="topbar">
    <button class="icon-btn sidebar-toggle-btn" id="sidebarToggle" aria-label="Open menu"><i class="bi bi-list"></i></button>

    <div class="search-box">
        <i class="bi bi-search"></i>
        <input type="text" id="topbarSearch" placeholder="Search…">
    </div>

    <div class="d-flex align-items-center gap-2 ms-auto">
        @hasSection('topbar-actions')
            @yield('topbar-actions')
        @endif
        <div class="theme-toggle" id="themeToggle" role="button" aria-label="Toggle light and dark mode">
            <div class="knob"><i class="bi bi-sun-fill" id="themeIcon"></i></div>
        </div>
    </div>
</header>
