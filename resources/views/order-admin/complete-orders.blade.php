@extends('layouts.bakery')

@section('title', 'Complete Orders | Perera Bakers')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
    <div>
        <h1 class="display-font page-title mb-1">Complete Orders</h1>
        <div class="page-sub">Dashboard / Complete Orders</div>
    </div>
</div>

@include('components.bakery.alerts')

<div class="panel">
    <div class="panel-head">
        <div>
            <h2>Complete Orders</h2>
            <div class="sub">{{ count($Orders) }} order(s)</div>
        </div>
        <form action="/order-admin/complete-orders" method="GET" class="d-flex flex-wrap gap-2">
            <input type="date" class="form-control form-control-sm" name="date">
            <input type="text" class="form-control form-control-sm" placeholder="Search orders…" name="search" style="min-width:200px;">
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
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Orders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="mono">{{ $order->unique_id }}</td>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->time_period }}</td>
                    <td>{{ $order->order_time }}</td>
                    <td>{{ $order->note }}</td>
                    <td class="mono">රු. {{ number_format($order->total_price, 2) }}</td>
                    <td><a href="{{ route('order-admin-complete-orders-view', ['id' => $order->unique_id]) }}" class="btn btn-soft btn-sm">View</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
