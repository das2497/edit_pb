@extends('layouts.bakery')

@section('title', 'Rep | Processing Orders Add Items')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
    <div>
        <h1 class="display-font page-title mb-1">Processing Orders — Add Items</h1>
        <div class="page-sub">Order: <span class="mono">{{ $order_number }}</span> / Add Items</div>
    </div>
    <div>
        <a href="/rep/processing-orders-view/{{ $order_number }}" class="btn btn-soft">Go Back</a>
    </div>
</div>

@include('components.bakery.alerts')

<div class="panel">
    <div class="panel-head">
        <div>
            <h2>Products</h2>
            <div class="sub">Items already in the order are highlighted</div>
        </div>
    </div>
    <form action="/rep/processing-orders-add-item" method="GET" class="d-flex flex-wrap gap-2 mb-3">
        <input type="text" class="form-control" placeholder="Search products…" name="search" value="{{ request('search') }}" style="max-width:280px;">
        <select class="form-select" name="category" style="max-width:240px;">
            <option value="" @selected(request('category') == '' || session('category') == '')>All category</option>
            @foreach ($categories as $category)
            <option value="{{ $category->category }}" @selected(request('category') == $category->category || session('category') == $category->category)>{{ $category->category }}</option>
            @endforeach
        </select>
        <input type="hidden" value="{{ $order_number }}" name="order_number">
        <button type="submit" class="btn btn-accent">Search</button>
    </form>
    <div class="table-responsive">
        <table class="table table-bakery align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Item Id</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                @php $inCart = isset($cart_items) && $cart_items->contains('item_number', $product->item_number); @endphp
                <tr @if($inCart) class="in-cart" @endif>
                    <td>{{ $loop->iteration }}</td>
                    <td><img class="img-thumb" src="{{ asset('assets/images/item-images/'.$product->img) }}" alt=""></td>
                    <td class="mono">{{ $product->item_number }}</td>
                    <td>{{ $product->name_english }}</td>
                    @if ($inCart)
                    <td><input class="form-control form-control-sm" type="number" value="{{ $cart_items->firstWhere('item_number', $product->item_number)->qty }}" disabled style="max-width:120px;"></td>
                    <td><button class="btn btn-soft btn-sm disabled">Already added</button></td>
                    @else
                    @php $fid = 'add-p-'.$loop->iteration; @endphp
                    <td><input class="form-control form-control-sm" type="number" min="0" step="0.01" required pattern="[0-9]+(\.[0-9]+)?" name="qty" form="{{ $fid }}" style="max-width:120px;"></td>
                    <td>
                        <form action="{{ route('rep.processing-orders-add-items-process') }}" method="POST" id="{{ $fid }}">
                            @csrf
                            <input type="hidden" name="order_number" value="{{ $order_number }}">
                            <input type="hidden" name="item_number" value="{{ $product->item_number }}">
                            <input type="hidden" name="shop" value="{{ $shop }}">
                            <button type="submit" class="btn btn-accent btn-sm">Add item</button>
                        </form>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
