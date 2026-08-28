@extends('layouts.bakery')

@section('title', 'Rep | Under Review Orders')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
    <div>
        <h1 class="display-font page-title mb-1">Under Review Orders</h1>
        <div class="page-sub">Dashboard / Under Review — {{ count($Orders) }} order(s)</div>
    </div>
</div>

@include('components.bakery.alerts')

<div class="panel">
    <div class="panel-head">
        <div>
            <h2>Under Review Orders</h2>
            <div class="sub">Orders awaiting review</div>
        </div>
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
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($Orders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="mono">{{ $order->unique_id }}</td>
                    <td>{{ $order->shop_name }}</td>
                    <td><span class="status-pill status-late">{{ $order->time_period }}</span></td>
                    <td class="mono" style="font-size:.82rem;">{{ $order->created_at }}</td>
                    <td>{{ $order->note }}</td>
                    <td class="mono">රු. {{ number_format($order->total_price, 2) }}</td>
                    <td><a href="{{ route('rep.under-review-orders-view', ['id' => $order->unique_id]) }}" class="btn btn-soft btn-sm">View</a></td>
                    <td>
                        <form action="{{ route('rep.under-review-orders-delete', ['id' => $order->unique_id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-soft btn-sm" style="color:var(--accent);" onclick="return confirmDelete();">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center text-muted">No under review orders</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this order?');
    }
</script>
@endpush
