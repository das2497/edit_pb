@extends('layouts.bakery')

@section('title', 'Add Shop | Perera Bakers')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
    <div>
        <h1 class="display-font page-title mb-1">Add Shop</h1>
        <div class="page-sub">Dashboard / Add Shop</div>
    </div>
    <div class="sub page-sub">
        <span class="me-3"><span class="legend-dot" style="background:rgba(76,124,107,.6);"></span>Ordered (all slots)</span>
        <span><span class="legend-dot" style="background:rgba(201,138,59,.65);"></span>Partially ordered</span>
    </div>
</div>

@include('components.bakery.alerts')

@if (Auth::user()->role === 'view')
<div class="panel">
    <div class="panel-head">
        <div>
            <h2>All Shops</h2>
        </div>
        <form action="/order-admin/add-shop" method="GET" class="d-flex gap-2">
            <input type="text" class="form-control form-control-sm" placeholder="Search Shops…" name="search" style="min-width:200px;">
            <button type="submit" class="btn btn-soft btn-sm">Search</button>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-bakery align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Branch Code</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Assigned Rep</th>
                    <th>Price Range</th>
                    <th>Morning Route</th>
                    <th>Evening Route</th>
                    <th>Order Time</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($shops as $shop)
                @php
                $orders = DB::table('orders')
                ->where('shop', '=', $shop->branch_code)
                ->where('status', '!=', 'Cancelled')
                ->where('status', '!=', 'Default')
                ->whereDate('created_at', '=', $date)
                ->count();
                $rowClass = '';
                if ($shop->order_time == 'Both' && $orders == 2) { $rowClass = 'row-good'; }
                elseif ($shop->order_time == 'Both' && $orders == 1) { $rowClass = 'row-warn'; }
                elseif (($shop->order_time == 'Morning' || $shop->order_time == 'Evening') && $orders == 1) { $rowClass = 'row-good'; }
                @endphp
                <tr class="{{ $rowClass }}">
                    <td>{{ $loop->iteration }}</td>
                    <td class="mono">{{ $shop->branch_code }}</td>
                    <td>{{ $shop->name }}</td>
                    <td>{{ $shop->email }}</td>
                    <td>{{ $shop->contact }}</td>
                    <td>{{ $shop->rep_name }}</td>
                    <td>{{ $shop->price_range }}</td>
                    <td>{{ $shop->morning_route }}</td>
                    <td>{{ $shop->evening_route }}</td>
                    <td>{{ $shop->order_time }}</td>
                    <td>{{ $shop->type }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $shops->links() }}</div>
</div>
@else
<div class="row g-4">
    <div class="col-xl-3 col-lg-12">
        <div class="panel">
            <div class="panel-head">
                <div>
                    <h2>Add Shop</h2>
                </div>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="sp_name" class="form-label">Shop Name</label>
                    <input name="name" id="sp_name" type="text" class="form-control" placeholder="Shop Name" value="{{ old('name') }}">
                </div>
                <div class="mb-3">
                    <label for="sp_name_sinhala" class="form-label">Shop Name Sinhala</label>
                    <input name="name_sinhala" id="sp_name_sinhala" type="text" class="form-control" placeholder="Shop Name" value="{{ old('name_sinhala') }}">
                </div>
                <div class="mb-3">
                    <label for="sp_branch_code" class="form-label">Branch Code Number</label>
                    <input name="branch_code" id="sp_branch_code" type="text" class="form-control" placeholder="Branch Code Number" value="{{ old('branch_code') }}">
                </div>
                <div class="mb-3">
                    <label for="sp_email" class="form-label">Email</label>
                    <input name="email" id="sp_email" type="text" placeholder="Email" class="form-control" value="{{ old('email') }}">
                </div>
                <div class="mb-3">
                    <label for="sp_contact" class="form-label">Contact No</label>
                    <input name="contact" id="sp_contact" type="text" placeholder="Contact No" class="form-control" value="{{ old('contact') }}">
                </div>
                <div class="mb-3">
                    <label for="sp_price_range" class="form-label">Select Price Range</label>
                    <select class="form-select" id="sp_price_range" name="price_range">
                        <option value="">Select Price Range</option>
                        <option value="Unit Price">Unit Price</option>
                        <option value="PB MRP">PB MRP</option>
                        <option value="PB Direct Sale Price">PB Direct Sale Price</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="sp_morning_route" class="form-label">Select Morning Route</label>
                    <select class="form-select" id="sp_morning_route" name="morning_route">
                        <option value="">Select Morning Route</option>
                        @foreach ($morning_routes as $morning_route)
                        <option value="{{ $morning_route->name }}">{{ $morning_route->name }}</option>
                        @endforeach
                        <option value="none">None</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="sp_evening_route" class="form-label">Select Evening Route</label>
                    <select class="form-select" id="sp_evening_route" name="evening_route">
                        <option value="">Select Evening Route</option>
                        @foreach ($evening_routes as $evening_route)
                        <option value="{{ $evening_route->name }}">{{ $evening_route->name }}</option>
                        @endforeach
                        <option value="none">None</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="sp_shop_type" class="form-label">Select Shop Type</label>
                    <select class="form-select" id="sp_shop_type" name="type">
                        <option value="">Select Shop Type</option>
                        <option value="Outlet">Outlet</option>
                        <option value="Route Rep">Route Rep</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="sp_order_time" class="form-label">Order Time</label>
                    <select class="form-select" id="sp_order_time" name="order_time">
                        <option value="">Select Order Time</option>
                        <option value="Morning">Morning</option>
                        <option value="Evening">Evening</option>
                        <option value="Both">Both</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="sp_password" class="form-label">Password</label>
                    <input name="password" id="sp_password" type="text" placeholder="Password" class="form-control" value="{{ old('password') }}">
                </div>
                <button type="submit" class="btn btn-accent w-100">Add</button>
            </form>
        </div>
    </div>
    <div class="col-xl-9 col-lg-12">
        <div class="panel">
            <div class="panel-head">
                <div>
                    <h2>All Shops</h2>
                </div>
                <form action="/order-admin/add-shop" method="GET" class="d-flex gap-2">
                    <input type="text" class="form-control form-control-sm" placeholder="Search Shops…" name="search" style="min-width:180px;">
                    <button type="submit" class="btn btn-soft btn-sm">Search</button>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-bakery align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Branch Code</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Assigned Rep</th>
                            <th>Price Range</th>
                            <th>Morning Route</th>
                            <th>Evening Route</th>
                            <th>Order Time</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shops as $shop)
                        @php
                        $orders = DB::table('orders')
                        ->where('shop', '=', $shop->branch_code)
                        ->where('status', '!=', 'Cancelled')
                        ->where('status', '!=', 'Default')
                        ->whereDate('created_at', '=', $date)
                        ->count();
                        $rowClass = '';
                        if ($shop->order_time == 'Both' && $orders == 2) { $rowClass = 'row-good'; }
                        elseif ($shop->order_time == 'Both' && $orders == 1) { $rowClass = 'row-warn'; }
                        elseif (($shop->order_time == 'Morning' || $shop->order_time == 'Evening') && $orders == 1) { $rowClass = 'row-good'; }
                        @endphp
                        <tr class="{{ $rowClass }}">
                            <td>{{ $loop->iteration }}</td>
                            <td class="mono">{{ $shop->branch_code }}</td>
                            <td>{{ $shop->name }}</td>
                            <td>{{ $shop->email }}</td>
                            <td>{{ $shop->contact }}</td>
                            <td>{{ $shop->rep_name }}</td>
                            <td>{{ $shop->price_range }}</td>
                            <td>{{ $shop->morning_route }}</td>
                            <td>{{ $shop->evening_route }}</td>
                            <td>{{ $shop->order_time }}</td>
                            <td>{{ $shop->type }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button type="button" class="btn btn-soft btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal{{ $shop->id }}">
                                        Update
                                    </button>
                                    <a onclick="return confirmDelete();" href="{{ route('shops.delete', ['id' => $shop->id]) }}" class="btn btn-soft btn-sm" style="color:var(--accent);">Delete</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $shops->links() }}</div>
        </div>
    </div>
</div>

@foreach ($shops as $shop)
<div class="modal fade" id="updateModal{{ $shop->id }}" tabindex="-1" aria-labelledby="updateModalLabel{{ $shop->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('shops.update', $shop->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel{{ $shop->id }}">Update Shop</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Branch Code</label>
                        <input type="text" class="form-control" name="branch_code" value="{{ $shop->branch_code }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $shop->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price Range</label>
                        <select class="form-select" name="price_range">
                            <option value="" @selected($shop->price_range == '')>Select Price Range</option>
                            <option value="Unit Price" @selected($shop->price_range == 'Unit Price')>Unit Price</option>
                            <option value="PB MRP" @selected($shop->price_range == 'PB MRP')>PB MRP</option>
                            <option value="PB Direct Sale Price" @selected($shop->price_range == 'PB Direct Sale Price')>PB Direct Sale Price</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Morning Route</label>
                        <select class="form-select" name="morning_route">
                            <option value="" @selected($shop->morning_route == '')>Select Morning Route</option>
                            @foreach ($morning_routes as $morning_route)
                            <option value="{{ $morning_route->name }}" @selected($shop->morning_route == $morning_route->name)>{{ $morning_route->name }}</option>
                            @endforeach
                            <option value="none" @selected($shop->morning_route == 'none')>None</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Evening Route</label>
                        <select class="form-select" name="evening_route">
                            <option value="" @selected($shop->evening_route == '')>Select Evening Route</option>
                            @foreach ($evening_routes as $evening_route)
                            <option value="{{ $evening_route->name }}" @selected($shop->evening_route == $evening_route->name)>{{ $evening_route->name }}</option>
                            @endforeach
                            <option value="none" @selected($shop->evening_route == 'none')>None</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Order Time</label>
                        <select class="form-select" name="order_time">
                            <option value="" @selected($shop->order_time == '')>Select Order Time</option>
                            <option value="Morning" @selected($shop->order_time == 'Morning')>Morning</option>
                            <option value="Evening" @selected($shop->order_time == 'Evening')>Evening</option>
                            <option value="Both" @selected($shop->order_time == 'Both')>Both</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Shop Type</label>
                        <select class="form-select" name="type">
                            <option value="" @selected($shop->type == '')>Select Shop Type</option>
                            <option value="Outlet" @selected($shop->type == 'Outlet')>Outlet</option>
                            <option value="Route Rep" @selected($shop->type == 'Route Rep')>Route Rep</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="name" value="{{ $shop->name }}">
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
        return confirm('Are you sure you want to delete this shop?');
    }
</script>
@endpush
