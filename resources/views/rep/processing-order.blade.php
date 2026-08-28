@extends('layouts.bakery')

@section('title', 'Rep | Processing Orders')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
    <div>
        <h1 class="display-font page-title mb-1">Processing Orders</h1>
        <div class="page-sub">Dashboard / Processing Orders — {{ count($Orders) }} order(s)</div>
    </div>
</div>

@include('components.bakery.alerts')

<div class="panel">
    <div class="panel-head">
        <div>
            <h2>Processing Orders</h2>
            <div class="sub">Your assigned shops processing orders</div>
        </div>
        <form action="/rep/processing-order" method="GET" class="d-flex gap-2">
            <input type="text" class="form-control form-control-sm" placeholder="Type shop name or order id…" name="search" value="{{ request('search') }}" style="min-width:220px;">
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
                    <th>Amount</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($Orders as $order)
                @php $fid = 'note-p-'.$loop->iteration; @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="mono">{{ $order->unique_id }}</td>
                    <td>{{ $order->shop_name }}</td>
                    <td><span class="status-pill status-baking">{{ $order->time_period }}</span></td>
                    <td class="mono" style="font-size:.82rem;">{{ $order->created_at }}</td>
                    <td style="min-width:200px;">
                        <div class="d-flex gap-1">
                            <input class="form-control form-control-sm" type="text" value="{{ $order->note }}" name="note" form="{{ $fid }}">
                            <input type="hidden" name="order_number" value="{{ $order->unique_id }}" form="{{ $fid }}">
                            <button type="submit" form="{{ $fid }}" class="btn btn-soft btn-sm"><i class="bi bi-arrow-clockwise"></i></button>
                        </div>
                        <form action="/rep/processing-orders-note-update" method="POST" id="{{ $fid }}" class="d-none">
                            @csrf
                        </form>
                    </td>
                    <td class="mono">රු. {{ number_format($order->total_price, 2) }}</td>
                    <td>
                        <a href="{{ route('rep.processing-orders-view', ['id' => $order->unique_id, 'note' => $order->note]) }}" class="btn btn-soft btn-sm">View</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted">No processing orders</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
