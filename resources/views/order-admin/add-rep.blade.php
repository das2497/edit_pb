@extends('layouts.bakery')

@section('title', 'Add Rep | Perera Bakers')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
    <div>
        <h1 class="display-font page-title mb-1">Add Rep</h1>
        <div class="page-sub">Dashboard / Add Rep</div>
    </div>
</div>

@include('components.bakery.alerts')

@if (Auth::user()->role === 'view')
<div class="panel">
    <div class="panel-head">
        <div>
            <h2>All Representatives</h2>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bakery align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Rep Type</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reps as $rep)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $rep->name }}</td>
                    <td>{{ $rep->email }}</td>
                    <td>{{ $rep->contact }}</td>
                    <td>{{ $rep->type }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $reps->links() }}</div>
</div>
@else
<div class="row g-4">
    <div class="col-xl-4 col-lg-12">
        <div class="panel">
            <div class="panel-head">
                <div>
                    <h2>Add Representative</h2>
                    <div class="sub">Create a new rep account</div>
                </div>
            </div>
            <form action="" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="rp_name" class="form-label">Name</label>
                    <input id="rp_name" type="text" class="form-control" placeholder="Name" name="name">
                </div>
                <div class="mb-3">
                    <label for="rp_email" class="form-label">Email</label>
                    <input id="rp_email" type="email" placeholder="Email" class="form-control" name="email">
                </div>
                <div class="mb-3">
                    <label for="rp_contact" class="form-label">Contact</label>
                    <input id="rp_contact" type="text" class="form-control" placeholder="Contact" name="contact">
                </div>
                <div class="mb-3">
                    <label for="rp_type" class="form-label">Representative Type</label>
                    <select class="form-select" id="rp_type" name="type">
                        <option value="">Select Type</option>
                        <option value="Outlet">Outlet</option>
                        <option value="PBD">PBD</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="rp_pass" class="form-label">Password</label>
                    <input id="rp_pass" type="text" class="form-control" placeholder="Password" name="password">
                </div>
                <button type="submit" class="btn btn-accent w-100">Add</button>
            </form>
        </div>
    </div>
    <div class="col-xl-8 col-lg-12">
        <div class="panel">
            <div class="panel-head">
                <div>
                    <h2>All Representatives</h2>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bakery align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Rep Type</th>
                            <th>Access</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reps as $rep)
                        @php $fid = 'acc-' . $loop->iteration; @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $rep->name }}</td>
                            <td>{{ $rep->email }}</td>
                            <td>{{ $rep->contact }}</td>
                            <td>{{ $rep->type }}</td>
                            <td>
                                <label class="switch mb-0">
                                    <input type="checkbox" name="access" form="{{ $fid }}" {{ $rep->access == 'on' ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </td>
                            <td>
                                <form action="/order-admin/rep-update-access" method="POST" id="{{ $fid }}">
                                    @csrf
                                    <input type="hidden" value="{{ $rep->email }}" name="rep_email">
                                    <button type="submit" class="btn btn-soft btn-sm">Update Access</button>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('reps.delete', ['id' => $rep->id]) }}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{ $rep->email }}" name="rep_email">
                                    <button type="submit" onclick="return confirmDelete();" class="btn btn-soft btn-sm" style="color:var(--accent);">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $reps->links() }}</div>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this representative?');
    }
</script>
@endpush
