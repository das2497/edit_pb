<!-- Sidebar : Shop -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="mark">PB</div>
        <div class="name">Peoples Bakers
            <small>Shop Console</small>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Overview</div>
        <a href="{{ route('shop.dashboard') }}" class="nav-link {{ request()->routeIs('shop.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>

        <div class="nav-section-label">Orders</div>
        <a href="/shop/all-orders" class="nav-link {{ request()->is('shop/all-orders*') ? 'active' : '' }}">
            <i class="bi bi-collection"></i> All Orders
        </a>
        <a href="/shop/pending-orders" class="nav-link {{ request()->is('shop/pending-orders*') ? 'active' : '' }}">
            <i class="bi bi-hourglass-split"></i> Pending
        </a>
        <a href="/shop/processing-orders" class="nav-link {{ request()->is('shop/processing-orders*') ? 'active' : '' }}">
            <i class="bi bi-arrow-repeat"></i> Processing
        </a>
        <a href="/shop/under-review-orders" class="nav-link {{ request()->is('shop/under-review-orders*') ? 'active' : '' }}">
            <i class="bi bi-search"></i> Under Review
        </a>
        <a href="/shop/complete-orders" class="nav-link {{ request()->is('shop/complete-orders*') ? 'active' : '' }}">
            <i class="bi bi-check2-circle"></i> Completed
        </a>
        <a href="/shop/default-orders" class="nav-link {{ request()->is('shop/default-orders*') ? 'active' : '' }}">
            <i class="bi bi-star"></i> Default Order
        </a>

        <div class="nav-section-label">Create</div>
        <a href="/shop/create-order" class="nav-link {{ request()->is('shop/create-order*') ? 'active' : '' }}">
            <i class="bi bi-plus-square"></i> Create Order
        </a>
        <a href="/shop/cart" class="nav-link {{ request()->is('shop/cart*') ? 'active' : '' }}">
            <i class="bi bi-cart3"></i> Cart
        </a>

        <div class="nav-section-label">Account</div>
        <a href="{{ route('shop.profile') }}" class="nav-link {{ request()->routeIs('shop.profile') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i> Profile
        </a>
    </nav>

    <div class="sidebar-foot">
        <div class="user">
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <div>
                <div class="u-name">{{ Auth::user()->name }}</div>
                <div class="u-role">Shop</div>
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
