/* Peoples Bakers admin template — shared behaviour (theme + mobile sidebar) */
(function () {
    var root = document.documentElement;

    // ---- Theme toggle (persisted in localStorage, falls back to system preference) ----
    var themeToggle = document.getElementById('themeToggle');
    var themeIcon = document.getElementById('themeIcon');

    function applyTheme(mode) {
        root.setAttribute('data-theme', mode);
        if (themeIcon) {
            themeIcon.className = mode === 'dark' ? 'bi bi-moon-stars-fill' : 'bi bi-sun-fill';
        }
        try { localStorage.setItem('pb-theme', mode); } catch (e) { /* private mode */ }
        // let pages (charts etc.) react to theme changes
        document.dispatchEvent(new CustomEvent('pb:theme-changed', { detail: { mode: mode } }));
    }

    var saved = null;
    try { saved = localStorage.getItem('pb-theme'); } catch (e) { /* private mode */ }
    var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
    applyTheme(saved || (prefersDark ? 'dark' : 'light'));

    if (themeToggle) {
        themeToggle.addEventListener('click', function () {
            applyTheme(root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
        });
    }

    // ---- Mobile sidebar ----
    var sidebar = document.getElementById('sidebar');
    var backdrop = document.getElementById('backdrop');
    var toggleBtn = document.getElementById('sidebarToggle');

    if (toggleBtn && sidebar && backdrop) {
        toggleBtn.addEventListener('click', function () {
            sidebar.classList.add('show');
            backdrop.classList.add('show');
        });
        backdrop.addEventListener('click', function () {
            sidebar.classList.remove('show');
            backdrop.classList.remove('show');
        });
    }

    // ---- Helper for pages: read current chart colours from CSS variables ----
    window.pbChartColors = function () {
        var s = getComputedStyle(root);
        return {
            accent: s.getPropertyValue('--accent').trim(),
            caramel: s.getPropertyValue('--caramel').trim(),
            mint: s.getPropertyValue('--mint').trim(),
            blueberry: s.getPropertyValue('--blueberry').trim(),
            grid: s.getPropertyValue('--border').trim(),
            text: s.getPropertyValue('--text-muted').trim()
        };
    };
})();
