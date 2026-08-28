<!-- Sidebar : Order Admin -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="mark">PB</div>
        <div class="name">Peoples Bakers
            <small>Order Admin</small>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Overview</div>
        <a href="/order-admin/dashboard" class="nav-link {{ request()->is('order-admin/dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>

        <div class="nav-section-label">Orders</div>
        <a href="/order-admin/pending-orders" class="nav-link {{ request()->is('order-admin/pending-orders*') ? 'active' : '' }}">
            <i class="bi bi-hourglass-split"></i> Pending Orders
        </a>
        <a href="/order-admin/processing-orders" class="nav-link {{ request()->is('order-admin/processing-orders*') ? 'active' : '' }}">
            <i class="bi bi-arrow-repeat"></i> Processing Orders
        </a>
        <a href="/order-admin/under-review-orders" class="nav-link {{ request()->is('order-admin/under-review-orders*') ? 'active' : '' }}">
            <i class="bi bi-search"></i> Under Review
        </a>
        <a href="/order-admin/complete-orders" class="nav-link {{ request()->is('order-admin/complete-orders*') ? 'active' : '' }}">
            <i class="bi bi-check2-circle"></i> Completed Orders
        </a>
        <a href="/order-admin/create-order" class="nav-link {{ request()->is('order-admin/create-order*') ? 'active' : '' }}">
            <i class="bi bi-plus-square"></i> Create Order
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
        <a href="/order-admin/add-products" class="nav-link {{ request()->is('order-admin/add-products*') ? 'active' : '' }}">
            <i class="bi bi-cake2"></i> Products
        </a>

        <div class="nav-section-label">Reports</div>
        <a href="/order-admin/export-report" class="nav-link {{ request()->is('order-admin/export-report*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-arrow-down"></i> Export Report
        </a>
        <a href="/order-admin/shop-report" class="nav-link {{ request()->is('order-admin/shop-report*') ? 'active' : '' }}">
            <i class="bi bi-clipboard-data"></i> Shop Report
        </a>
        <a href="/order-admin/final-report" class="nav-link {{ request()->is('order-admin/final-report*') ? 'active' : '' }}">
            <i class="bi bi-journal-text"></i> Final Report
        </a>

        <div class="nav-section-label">System</div>
        <a href="/order-admin/log" class="nav-link {{ request()->is('order-admin/log*') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i> Logs
        </a>
    </nav>

    <div class="sidebar-foot">
        <div class="user">
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <div>
                <div class="u-name">{{ Auth::user()->name }}</div>
                <div class="u-role">Order Admin</div>
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
