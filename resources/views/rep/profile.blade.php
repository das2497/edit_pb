@extends('layouts.bakery')

@section('title', 'Rep | Profile')

@section('content')

    <div class="d-flex flex-wrap justify-content-between align-items-end mb-4 gap-2">
        <div>
            <h1 class="display-font page-title mb-1">Rep Profile</h1>
            <div class="page-sub">Update your account details — {{ Auth::user()->email }}</div>
        </div>
        <a href="{{ route('rep.dashboard') }}" class="btn btn-soft btn-sm"><i class="bi bi-arrow-left me-1"></i> Back to Dashboard</a>
    </div>

    @include('components.bakery.alerts')

    <div class="row g-3">
        <div class="col-12 col-lg-5 col-xl-4">
            <div class="panel">
                <div class="panel-head">
                    <div>
                        <h2>Rep Details</h2>
                        <div class="sub">Your login and contact info</div>
                    </div>
                    <div class="kpi-icon bg-tint-accent" style="width:42px;height:42px;border-radius:11px;display:flex;align-items:center;justify-content:center;"><i class="bi bi-person-circle"></i></div>
                </div>

                <form action="{{ route('rep.profile-update') }}" method="POST" class="vstack gap-3">
                    @csrf

                    <div>
                        <label for="inputName" class="form-label" style="font-size:.85rem;font-weight:600;">Rep Name</label>
                        <input id="inputName" type="text" class="form-control" placeholder="Rep name" value="{{ old('name', Auth::user()->name) }}" name="name" required>
                    </div>

                    <div>
                        <label for="inputEmail" class="form-label" style="font-size:.85rem;font-weight:600;">Rep Email</label>
                        <input id="inputEmail" type="email" class="form-control" placeholder="Rep email" value="{{ old('email', Auth::user()->email) }}" name="email" required>
                    </div>

                    <hr style="border-color:var(--border);">

                    <div>
                        <label for="inputPass" class="form-label" style="font-size:.85rem;font-weight:600;">New Password</label>
                        <input id="inputPass" type="password" class="form-control" placeholder="At least 8 characters" name="password" required>
                        <div class="form-text" style="color:var(--text-muted);font-size:.78rem;">Password will be updated for both rep and login accounts.</div>
                    </div>

                    <div>
                        <label for="inputPass2" class="form-label" style="font-size:.85rem;font-weight:600;">Confirm Password</label>
                        <input id="inputPass2" type="password" class="form-control" placeholder="Confirm password" name="confirm" required>
                    </div>

                    <div class="d-flex gap-2 pt-2">
                        <button type="submit" class="btn btn-accent"><i class="bi bi-check2-circle me-1"></i> Update Profile</button>
                        <a href="{{ route('rep.dashboard') }}" class="btn btn-soft">Cancel</a>
                    </div>
                </form>
            </div>

            <div class="panel mt-3">
                <div class="panel-head mb-2">
                    <div>
                        <h2>Security Tip</h2>
                        <div class="sub">Keep your account safe</div>
                    </div>
                </div>
                <ul class="mb-0" style="font-size:.86rem;color:var(--text-muted);padding-left:1.2rem;">
                    <li>Use a strong password with letters, numbers and symbols.</li>
                    <li>Do not share your login with others.</li>
                    <li>Update password periodically.</li>
                </ul>
            </div>
        </div>

        <div class="col-12 col-lg-7 col-xl-8">
            <div class="panel h-100">
                <div class="panel-head">
                    <div>
                        <h2>Account Summary</h2>
                        <div class="sub">Current session info</div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <div class="kpi-card">
                            <div class="kpi-label">Name</div>
                            <div class="kpi-value" style="font-size:1.2rem;">{{ Auth::user()->name }}</div>
                            <div class="kpi-delta"><i class="bi bi-person"></i> Logged in user</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="kpi-card">
                            <div class="kpi-label">Email</div>
                            <div class="kpi-value mono" style="font-size:1rem;">{{ Auth::user()->email }}</div>
                            <div class="kpi-delta"><i class="bi bi-envelope"></i> Primary email</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="alert" style="background:color-mix(in srgb, var(--blueberry) 12%, var(--surface)); border:1px solid var(--border); color:var(--text); border-radius:12px;">
                            <i class="bi bi-info-circle me-2"></i> Changing email will affect both <strong>reps</strong> table and <strong>users</strong> login table. Make sure the new email is not already used by another rep or shop.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
