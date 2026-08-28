@extends('layouts.bakery')

@section('title', 'Pending Orders | Perera Bakers')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
    <div>
        <h1 class="display-font page-title mb-1">Pending Orders</h1>
        <div class="page-sub">Dashboard / Pending Orders</div>
    </div>
</div>

@include('components.bakery.alerts')

<div class="panel">
    <div class="panel-head">
        <div>
            <h2>Pending Orders</h2>
            <div class="sub">{{ count($Orders) }} order(s)</div>
        </div>
        <form action="/order-admin/pending-orders" method="GET" class="d-flex gap-2">
            <input type="text" class="form-control form-control-sm" placeholder="Search orders…" name="search" style="min-width:220px;">
            <button type="submit" class="btn btn-soft btn-sm">Search</button>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-bakery align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Order Id</th>
                    <th>Outlet</th>
                    <th>Delivery Time</th>
                    <th>Created</th>
                    <th>Special Note</th>
                    <th>Estimate Amount</th>
                    @if (Auth::user()->role !== 'view')
                    <th>Cancel</th>
                    @endif
                    <th></th>
                    @if (Auth::user()->role !== 'view')
                    <th></th>
                    @endif
                </tr>
            </thead>
            @if (Auth::user()->role === 'view')
            <tbody>
                @foreach ($Orders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="mono">{{ $order->unique_id }}</td>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->time_period }}</td>
                    <td>{{ $order->order_created }}</td>
                    <td>{{ $order->note }}</td>
                    <td class="mono">රු. {{ number_format($order->total_price, 2) }}</td>
                    <td><a href="{{ route('order-admin-pending-orders-view', ['id' => $order->unique_id, 'note' => $order->note]) }}" class="btn btn-soft btn-sm">View</a></td>
                </tr>
                @endforeach
            </tbody>
            @else
            <tbody>
                @foreach ($Orders as $order)
                @php $fid = 'po-' . $loop->iteration; @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="mono">{{ $order->unique_id }}</td>
                    <td>{{ $order->name }}</td>
                    <td>
                        <select class="form-select form-select-sm" name="period" form="{{ $fid }}">
                            <option value="Morning" @selected($order->time_period == 'Morning')>Morning</option>
                            <option value="Evening" @selected($order->time_period == 'Evening')>Evening</option>
                        </select>
                    </td>
                    <td>{{ $order->order_created }}</td>
                    <td><input class="form-control form-control-sm" type="text" value="{{ $order->note }}" name="note" form="{{ $fid }}" style="min-width:140px;"></td>
                    <td class="mono">රු. {{ number_format($order->total_price, 2) }}</td>
                    <td>
                        <label class="switch mb-0">
                            <input type="checkbox" name="order_cancel" form="{{ $fid }}">
                            <span class="slider"></span>
                        </label>
                    </td>
                    <td><a href="{{ route('order-admin-pending-orders-view', ['id' => $order->unique_id, 'note' => $order->note]) }}" class="btn btn-soft btn-sm">View</a></td>
                    <td>
                        <form action="/order-admin/pending-orders-update-order" method="POST" id="{{ $fid }}">
                            @csrf
                            <input type="hidden" value="{{ $order->unique_id }}" name="order_id">
                            <input type="hidden" value="{{ $order->status }}" name="state">
                            <input type="hidden" value="{{ $order->shop }}" name="shop">
                            <button type="submit" class="btn btn-accent btn-sm">Update</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            @endif
        </table>
    </div>
</div>

@endsection
