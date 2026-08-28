@extends('layouts.bakery')

@section('title', 'Routes | Perera Bakers')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
    <div>
        <h1 class="display-font page-title mb-1">Routes</h1>
        <div class="page-sub">Dashboard / Routes</div>
    </div>
</div>

@include('components.bakery.alerts')

@if (Auth::user()->role === 'view')
<div class="panel">
    <div class="panel-head">
        <div>
            <h2>All Routes</h2>
        </div>
        <form action="/order-admin/routes" method="GET" class="d-flex gap-2">
            <input type="text" class="form-control form-control-sm" placeholder="Search Routes…" name="search" style="min-width:200px;">
            <button type="submit" class="btn btn-soft btn-sm">Search</button>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-bakery align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Route Index</th>
                    <th>Route Name</th>
                    <th>Route Type</th>
                    <th>Route Time</th>
                    <th>Shops</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($routes as $route)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $route->index }}</td>
                    <td>{{ $route->name }}</td>
                    <td>{{ $route->type }}</td>
                    <td>{{ $route->time }}</td>
                    <td>
                        @php
                        $shops = DB::table('shops')->where('morning_route', $route->name)->orWhere('evening_route', $route->name)->get();
                        @endphp
                        @foreach ($shops as $shop)
                        <span>{{ $shop->branch_code . ' ' . $shop->name }} | </span>
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $routes->links() }}</div>
</div>
@else
<div class="row g-4">
    <div class="col-xl-4 col-lg-12">
        <div class="panel">
            <div class="panel-head">
                <div>
                    <h2>Add Route</h2>
                </div>
            </div>
            <form action="/order-admin/add-route" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="route_index" class="form-label">Route Index</label>
                    <input name="index" id="route_index" type="text" class="form-control" placeholder="Route Index" value="{{ old('index') }}">
                </div>
                <div class="mb-3">
                    <label for="route_name" class="form-label">Route Name</label>
                    <input name="name" id="route_name" type="text" placeholder="Route Name" class="form-control" value="{{ old('name') }}">
                </div>
                <div class="mb-3">
                    <label for="route_type" class="form-label">Route Type</label>
                    <select class="form-select" id="route_type" name="type">
                        <option value="">Select Route Type</option>
                        <option value="Normal">Normal</option>
                        <option value="Special">Special</option>
                        <option value="PBD">PBD</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="route_time" class="form-label">Route Time</label>
                    <select class="form-select" id="route_time" name="time">
                        <option value="">Select Route Time</option>
                        <option value="Morning">Morning</option>
                        <option value="Evening">Evening</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-accent w-100">Add</button>
            </form>
        </div>
    </div>
    <div class="col-xl-8 col-lg-12">
        <div class="panel">
            <div class="panel-head">
                <div>
                    <h2>All Routes</h2>
                </div>
                <form action="/order-admin/routes" method="GET" class="d-flex gap-2">
                    <input type="text" class="form-control form-control-sm" placeholder="Search Routes…" name="search" style="min-width:180px;">
                    <button type="submit" class="btn btn-soft btn-sm">Search</button>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-bakery align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Route Index</th>
                            <th>Route Name</th>
                            <th>Route Type</th>
                            <th>Route Time</th>
                            <th>Shops</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($routes as $route)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $route->index }}</td>
                            <td>{{ $route->name }}</td>
                            <td>{{ $route->type }}</td>
                            <td>{{ $route->time }}</td>
                            <td>
                                @php
                                $shops = DB::table('shops')->where('morning_route', $route->name)->orWhere('evening_route', $route->name)->get();
                                @endphp
                                @foreach ($shops as $shop)
                                <span>{{ $shop->branch_code . ' ' . $shop->name }} | </span>
                                @endforeach
                            </td>
                            <td>
                                <button type="button" class="btn btn-soft btn-sm" data-bs-toggle="modal" data-bs-target="#updateRouteModal{{ $route->id }}">
                                    Update
                                </button>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('order-admin-delete-route', $route->id) }}">
                                    @csrf
                                    <button type="submit" onclick="return confirmDelete();" class="btn btn-soft btn-sm" style="color:var(--accent);">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $routes->links() }}</div>
        </div>
    </div>
</div>

@foreach ($routes as $route)
<div class="modal fade" id="updateRouteModal{{ $route->id }}" tabindex="-1" aria-labelledby="updateModalLabel{{ $route->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('order-admin-update-route', $route->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel{{ $route->id }}">Update Route</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Route Index</label>
                        <input type="text" class="form-control" name="index" value="{{ $route->index }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Route Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $route->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Route Type</label>
                        <select class="form-select" name="type">
                            <option value="">Select Route Type</option>
                            <option value="Normal" @selected($route->type === 'Normal')>Normal</option>
                            <option value="Special" @selected($route->type === 'Special')>Special</option>
                            <option value="PBD" @selected($route->type === 'PBD')>PBD</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Route Time</label>
                        <select class="form-select" name="time">
                            <option value="">Select Route Time</option>
                            <option value="Morning" @selected($route->time === 'Morning')>Morning</option>
                            <option value="Evening" @selected($route->time === 'Evening')>Evening</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-accent">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endif

@endsection

@push('scripts')
<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this route?');
    }
</script>
@endpush
