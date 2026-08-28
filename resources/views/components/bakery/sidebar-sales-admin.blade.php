<!-- Sidebar : Sales Admin -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="mark">PB</div>
        <div class="name">Peoples Bakers
            <small>Sales Admin</small>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Overview</div>
        <a href="/order-admin/dashboard" class="nav-link {{ request()->is('order-admin/dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>

        <div class="nav-section-label">Management</div>
        <a href="/order-admin/add-rep" class="nav-link {{ request()->is('order-admin/add-rep*') ? 'active' : '' }}">
            <i class="bi bi-person-badge"></i> Representatives
        </a>
        <a href="/order-admin/rep-assign" class="nav-link {{ request()->is('order-admin/rep-assign*') ? 'active' : '' }}">
            <i class="bi bi-diagram-3"></i> Assign Shops
        </a>
        <a href="/order-admin/routes" class="nav-link {{ request()->is('order-admin/routes*') ? 'active' : '' }}">
            <i class="bi bi-signpost-split"></i> Routes
        </a>
        <a href="/order-admin/add-shop" class="nav-link {{ request()->is('order-admin/add-shop*') ? 'active' : '' }}">
            <i class="bi bi-shop"></i> Shops
        </a>
    </nav>

    <div class="sidebar-foot">
        <div class="user">
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <div>
                <div class="u-name">{{ Auth::user()->name }}</div>
                <div class="u-role">Sales Admin</div>
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
