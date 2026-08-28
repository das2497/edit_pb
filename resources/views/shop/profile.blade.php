@extends('layouts.bakery')

@section('title', 'Shop | Profile')

@section('content')

    <div class="d-flex flex-wrap justify-content-between align-items-end mb-4 gap-2">
        <div>
            <h1 class="display-font page-title mb-1">Shop Profile</h1>
            <div class="page-sub">Update your shop account — {{ Auth::user()->email }}</div>
        </div>
        <a href="{{ route('shop.dashboard') }}" class="btn btn-soft btn-sm"><i class="bi bi-arrow-left me-1"></i> Back to Dashboard</a>
    </div>

    @include('components.bakery.alerts')

    <div class="row g-3">
        <div class="col-12 col-lg-5 col-xl-4">
            <div class="panel">
                <div class="panel-head">
                    <div>
                        <h2>Shop Details</h2>
                        <div class="sub">Login and contact info</div>
                    </div>
                    <div class="kpi-icon bg-tint-blueberry" style="width:42px;height:42px;border-radius:11px;display:flex;align-items:center;justify-content:center;"><i class="bi bi-shop"></i></div>
                </div>

                <form action="{{ route('shop.profile-update') }}" method="POST" class="vstack gap-3">
                    @csrf

                    <div>
                        <label for="inputName" class="form-label" style="font-size:.85rem;font-weight:600;">Shop Name</label>
                        <input id="inputName" type="text" class="form-control" placeholder="Shop name" value="{{ old('name', Auth::user()->name) }}" name="name" required>
                    </div>

                    <div>
                        <label for="inputEmail" class="form-label" style="font-size:.85rem;font-weight:600;">Shop Email</label>
                        <input id="inputEmail" type="email" class="form-control" placeholder="Shop email" value="{{ old('email', Auth::user()->email) }}" name="email" required>
                    </div>

                    <hr style="border-color:var(--border);">

                    <div>
                        <label for="inputPass" class="form-label" style="font-size:.85rem;font-weight:600;">New Password</label>
                        <input id="inputPass" type="password" class="form-control" placeholder="At least 8 characters" name="password" required>
                        <div class="form-text" style="color:var(--text-muted);font-size:.78rem;">Updates both shops and users tables.</div>
                    </div>

                    <div>
                        <label for="inputPass2" class="form-label" style="font-size:.85rem;font-weight:600;">Confirm Password</label>
                        <input id="inputPass2" type="password" class="form-control" placeholder="Confirm password" name="confirm" required>
                    </div>

                    <div class="d-flex gap-2 pt-2">
                        <button type="submit" class="btn btn-accent"><i class="bi bi-check2-circle me-1"></i> Update</button>
                        <a href="{{ route('shop.dashboard') }}" class="btn btn-soft">Cancel</a>
                    </div>
                </form>
            </div>

            <div class="panel mt-3">
                <div class="panel-head mb-2">
                    <div><h2>Note</h2><div class="sub">About email change</div></div>
                </div>
                <div style="font-size:.86rem;color:var(--text-muted);">
                    Email change will update both <code>shops</code> and <code>users</code> tables. Ensure the new email is unique and not used by another shop or rep.
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-7 col-xl-8">
            <div class="panel h-100">
                <div class="panel-head"><div><h2>Account Summary</h2><div class="sub">Current session</div></div></div>
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <div class="kpi-card">
                            <div class="kpi-label">Name</div>
                            <div class="kpi-value" style="font-size:1.2rem;">{{ Auth::user()->name }}</div>
                            <div class="kpi-delta"><i class="bi bi-shop"></i> Shop account</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="kpi-card">
                            <div class="kpi-label">Email</div>
                            <div class="kpi-value mono" style="font-size:1rem;">{{ Auth::user()->email }}</div>
                            <div class="kpi-delta"><i class="bi bi-envelope"></i> Primary email</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
