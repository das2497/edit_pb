@extends('layouts.bakery')

@section('title', 'Rep | Cart')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
    <div>
        <h1 class="display-font page-title mb-1">{{ $shop->name }}'s Cart</h1>
        <div class="page-sub">Dashboard / Create Order / Cart — <span class="mono">{{ $branch_code ?? session('selected_shop') }}</span></div>
    </div>
    <div class="d-flex gap-2">
        <a href="/rep/clear-cart?shop={{ $branch_code }}" onclick="return confirmClear();" class="btn btn-soft btn-sm" style="color:var(--accent);">Clear cart</a>
        <a href="/rep/create-order?shop={{ $branch_code }}" class="btn btn-soft">Go Back</a>
    </div>
</div>

@include('components.bakery.alerts')

<div class="panel mb-4">
    <div class="panel-head">
        <div>
            <h2>Cart Items</h2>
            <div class="sub">{{ count($carts) }} item(s)</div>
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
                    <th>Price Range</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Remark</th>
                    <th>Total</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($carts as $cart)
                @php $fid = 'cart-'.$loop->iteration; @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><img class="img-thumb" src="{{ asset('assets/images/item-images/'.$cart->img) }}" alt=""></td>
                    <td class="mono">{{ $cart->item_number }}</td>
                    <td>{{ $cart->name_english }}</td>
                    <td>{{ $cart->price_range }}</td>
                    <td class="mono">රු. {{ number_format($cart->price, 2) }}</td>
                    <td><input type="number" name="qty" class="form-control form-control-sm" value="{{ $cart->qty }}" form="{{ $fid }}" style="min-width:100px;"></td>
                    <td><input type="text" name="remarke" class="form-control form-control-sm" value="{{ $cart->remarke }}" form="{{ $fid }}" style="min-width:120px;"></td>
                    <td class="mono">රු. {{ number_format($cart->price * $cart->qty, 2) }}</td>
                    <td>
                        <form action="/rep/cart/update-qty" method="POST" id="{{ $fid }}">
                            @csrf
                            <input type="hidden" name="item_number" value="{{ $cart->item_number }}">
                            <input type="hidden" name="branch_code" value="{{ $cart->shop_bc_number }}">
                            <button type="submit" class="btn btn-soft btn-sm">Update</button>
                        </form>
                    </td>
                    <td><button type="submit" form="{{ $fid }}" formaction="/rep/cart/delete-item" onclick="return confirmDelete();" class="btn btn-soft btn-sm" style="color:var(--accent);">Delete</button></td>
                </tr>
                @php $total += $cart->price * $cart->qty; @endphp
                @endforeach
                <tr>
                    <th colspan="8" class="text-end">Total Price :</th>
                    <th class="mono">රු. {{ number_format($total, 2) }}</th>
                    <th colspan="2"></th>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="panel">
    <div class="panel-head">
        <div>
            <h2>Place Order</h2>
            <div class="sub">Add a note and confirm</div>
        </div>
    </div>
    <form action="/rep/cart/order-process" method="POST" class="row g-3">
        @csrf
        <div class="col-12 col-md-6">
            <label for="order_note" class="form-label">Special Note</label>
            <textarea class="form-control" id="order_note" name="note" rows="4"></textarea>
        </div>
        @if ($shop->order_time == 'Both')
        <div class="col-12 col-md-6">
            <label for="order_time" class="form-label">Order Time</label>
            <select class="form-select" id="order_time" name="order_time">
                <option value="">Select Time</option>
                <option value="Morning">Morning</option>
                <option value="Evening">Evening</option>
            </select>
        </div>
        @elseif ($shop->order_time == 'Morning')
        <input type="hidden" name="order_time" value="Morning">
        @elseif ($shop->order_time == 'Evening')
        <input type="hidden" name="order_time" value="Evening">
        @endif
        <div class="col-12 col-md-6 offset-md-3">
            <input type="hidden" name="total" value="{{ $total }}">
            <input type="hidden" name="shop" value="{{ $shop->branch_code }}">
            <button class="btn btn-accent w-100" id="proceedbtn">Proceed</button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this item?');
    }
    function confirmClear() {
        return confirm('Are you sure you want to clear the cart?');
    }
    const proceed = document.getElementById('proceedbtn');
    if (proceed) {
        proceed.addEventListener('click', function(e) {
            const sel = document.querySelector('select[name="order_time"]');
            if (sel && sel.value == '') {
                alert('Please select the order time');
                e.preventDefault();
            }
        });
    }
</script>
@endpush
