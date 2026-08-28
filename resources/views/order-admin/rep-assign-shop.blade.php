@extends('layouts.bakery')

@section('title', 'Rep Assign Shops | Perera Bakers')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
    <div>
        <h1 class="display-font page-title mb-1">Rep Assign Shops</h1>
        <div class="page-sub">Dashboard / Rep Assign Shops</div>
    </div>
</div>

@include('components.bakery.alerts')

@if (Auth::user()->role === 'view')
<div class="panel">
    <div class="panel-head">
        <div>
            <h2>Assigned Shops</h2>
        </div>
        <form action="/order-admin/rep-assign" method="GET" class="d-flex gap-2">
            <input type="text" class="form-control form-control-sm" placeholder="Search…" name="search" style="min-width:200px;">
            <button type="submit" class="btn btn-soft btn-sm">Search</button>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-bakery align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Shop Name</th>
                    <th>Rep Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $key => $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->shop_name }}</td>
                    <td>{{ $data->rep_name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $datas->links() }}</div>
</div>
@else
<div class="row g-4">
    <div class="col-xl-4 col-lg-12">
        <div class="panel">
            <div class="panel-head">
                <div>
                    <h2>Assign Shops To Representative</h2>
                    <div class="sub">Only unassigned shops are listed</div>
                </div>
            </div>
            <form action="/order-admin/rep-assign" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="assign_rep" class="form-label">Select Rep</label>
                    <select class="form-select" id="assign_rep" name="rep_id">
                        <option value="">Select Rep</option>
                        @foreach ($reps as $rep)
                        <option value="{{ $rep->id }}">{{ $rep->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="assign_shop" class="form-label">Select Shop</label>
                    <select class="form-select" id="assign_shop" name="shop_id">
                        <option value="">Select Shop</option>
                        @foreach ($shops as $shop)
                        <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-accent w-100" type="submit">Assign</button>
            </form>
        </div>
    </div>
    <div class="col-xl-8 col-lg-12">
        <div class="panel">
            <div class="panel-head">
                <div>
                    <h2>Assigned Shops</h2>
                </div>
                <form action="/order-admin/rep-assign" method="GET" class="d-flex gap-2">
                    <input type="text" class="form-control form-control-sm" placeholder="Search…" name="search" style="min-width:180px;">
                    <button type="submit" class="btn btn-soft btn-sm">Search</button>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-bakery align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Shop Name</th>
                            <th>Rep Name</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $key => $data)
                        @php $fid = 'assign-' . $loop->iteration; @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->shop_name }}</td>
                            <td>
                                <select class="form-select form-select-sm" name="rep_id" form="{{ $fid }}" style="min-width:160px;">
                                    @foreach ($reps as $rep)
                                    <option value="{{ $rep->id }}" @selected($rep->name == $data->rep_name)>{{ $rep->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <form action="/order-admin/rep-assign-update" method="POST" id="{{ $fid }}">
                                    @csrf
                                    <input type="hidden" value="{{ $data->shop_id }}" name="shop_id">
                                    <button class="btn btn-soft btn-sm">Update</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $datas->links() }}</div>
        </div>
    </div>
</div>
@endif

@endsection
