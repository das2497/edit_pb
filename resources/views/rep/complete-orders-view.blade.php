@extends('layouts.bakery')

@section('title', 'Rep | Complete Orders View')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
    <div>
        <h1 class="display-font page-title mb-1">Complete Orders View</h1>
        <div class="page-sub">Order: <span class="mono">{{ $order_number ?? request('id') }}</span></div>
    </div>
    <div>
        <a href="/rep/complete-order" class="btn btn-soft">Go Back</a>
    </div>
</div>

@include('components.bakery.alerts')

<div class="panel">
    <div class="panel-head">
        <div>
            <h2>Order Items</h2>
            <div class="sub">Completed order — read only</div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bakery align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Item Id</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><img class="img-thumb" src="{{ asset('assets/images/item-images/'.$item->img) }}" alt=""></td>
                    <td class="mono">{{ $item->item_number }}</td>
                    <td>{{ $item->name_english }}</td>
                    <td>{{ $item->qty }}</td>
                    <td class="mono">රු. {{ number_format($item->price * $item->qty, 2) }}</td>
                </tr>
                @php $total += $item->price * $item->qty; @endphp
                @endforeach
                <tr>
                    <th colspan="4"></th>
                    <th class="text-end">Total :</th>
                    <th class="mono">රු. {{ number_format($total, 2) }}</th>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
