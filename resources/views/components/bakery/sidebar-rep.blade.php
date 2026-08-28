<!-- Sidebar : Rep -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="mark">PB</div>
        <div class="name">Peoples Bakers
            <small>Rep Console</small>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Overview</div>
        <a href="{{ route('rep.dashboard') }}" class="nav-link {{ request()->routeIs('rep.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>

        <div class="nav-section-label">Orders</div>
        <a href="{{ route('rep.pending-order') }}" class="nav-link {{ request()->routeIs('rep.pending-order*') ? 'active' : '' }}">
            <i class="bi bi-hourglass-split"></i> Pending Orders
        </a>
        <a href="{{ route('rep.processing-order') }}" class="nav-link {{ request()->routeIs('rep.processing-order*') ? 'active' : '' }}">
            <i class="bi bi-arrow-repeat"></i> Processing Orders
        </a>
        <a href="{{ route('rep.under-review-order') }}" class="nav-link {{ request()->routeIs('rep.under-review-order*') ? 'active' : '' }}">
            <i class="bi bi-search"></i> Under Review
        </a>
        <a href="{{ route('rep.complete-order') }}" class="nav-link {{ request()->routeIs('rep.complete-order*') ? 'active' : '' }}">
            <i class="bi bi-check2-circle"></i> Completed Orders
        </a>
        <a href="{{ route('rep.create-order') }}" class="nav-link {{ request()->routeIs('rep.create-order*') ? 'active' : '' }}">
            <i class="bi bi-plus-square"></i> Create Order
        </a>

        <div class="nav-section-label">Shops</div>
        <a href="{{ route('rep.my-shops') }}" class="nav-link {{ request()->routeIs('rep.my-shops*') ? 'active' : '' }}">
            <i class="bi bi-shop"></i> All My Shops
        </a>

        <div class="nav-section-label">Reports</div>
        <a href="/rep/export-report" class="nav-link {{ request()->is('rep/export-report*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-arrow-down"></i> Export Report
        </a>
        <a href="{{ route('rep.shop-report-morning') }}" class="nav-link {{ request()->routeIs('rep.shop-report-*') ? 'active' : '' }}">
            <i class="bi bi-clipboard-data"></i> Shop Report
        </a>
        <a href="{{ route('rep.final-report-morning') }}" class="nav-link {{ request()->routeIs('rep.final-report-*') ? 'active' : '' }}">
            <i class="bi bi-journal-text"></i> Final Report
        </a>
    </nav>

    <div class="sidebar-foot">
        <div class="user">
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <div>
                <div class="u-name">{{ Auth::user()->name }}</div>
                <div class="u-role">Representative</div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="ms-auto mb-0">
                @csrf
                <button type="submit" class="btn p-0 border-0" title="Logout"
                    style="color:var(--sidebar-text-muted); background:none;">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</aside>
