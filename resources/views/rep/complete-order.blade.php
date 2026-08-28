@extends('layouts.bakery')

@section('title', 'Rep | Complete Orders')

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
            <div class="sub">Completed order history</div>
        </div>
        <form action="{{ route('rep.complete-order') }}" method="GET" class="d-flex flex-wrap gap-2">
            <input type="date" class="form-control form-control-sm" name="date" value="{{ request('date') }}">
            <input type="text" class="form-control form-control-sm" placeholder="Search orders…" name="search" value="{{ request('search') }}" style="min-width:200px;">
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
                    <th>Delivery</th>
                    <th>Created</th>
                    <th>Note</th>
                    <th>Amount</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($Orders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="mono">{{ $order->unique_id }}</td>
                    <td>{{ $order->name ?? $order->shop_name ?? '' }}</td>
                    <td><span class="status-pill status-ready">{{ $order->time_period }}</span></td>
                    <td class="mono" style="font-size:.82rem;">{{ $order->order_time ?? $order->created_at }}</td>
                    <td>{{ $order->note }}</td>
                    <td class="mono">රු. {{ number_format($order->total_price, 2) }}</td>
                    <td><a href="{{ route('rep.complete-orders-view', ['id' => $order->unique_id]) }}" class="btn btn-soft btn-sm">View</a></td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted">No complete orders</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $Orders->links() }}
    </div>
</div>

@endsection
