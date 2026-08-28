@extends('layouts.bakery')

@section('title', 'Create Order | Perera Bakers')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container .select2-selection--single{height:38px; background:var(--surface); border:1px solid var(--border); border-radius:10px;}
    .select2-container--default .select2-selection--single .select2-selection__rendered{line-height:36px; color:var(--text);}
    .select2-container--default .select2-selection--single .select2-selection__arrow{height:36px;}
    .select2-dropdown{background:var(--surface); border:1px solid var(--border); color:var(--text);}
    .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable{background:var(--accent);}
    .select2-search__field{background:var(--surface); color:var(--text);}
</style>
@endpush

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
    <div>
        <h1 class="display-font page-title mb-1">Create Order</h1>
        <div class="page-sub">Dashboard / Create Order</div>
    </div>
    <div>
        @if (!empty($my_shop) && $cart_item->contains('shop_bc_number', $my_shop))
        <a href="/order-admin/cart?shop={{ $my_shop }}" class="btn btn-accent cart-btn"><i class="bi bi-cart4 me-1"></i> Cart</a>
        @else
        <button class="btn btn-accent" onclick="cart_btn();"><i class="bi bi-cart4 me-1"></i> Cart</button>
        @endif
    </div>
</div>

@include('components.bakery.alerts')

<div class="alert alert-danger" style="display: none;" id="warning">
    <p class="text-center mb-0">Pleace select a shop and search or this dosn't have any item in the cart!</p>
</div>

<div class="panel">
    <div class="panel-head">
        <div>
            <h2>All Products</h2>
            <div class="sub">Items already in the cart are highlighted</div>
        </div>
    </div>
    <form action="/order-admin/create-order" method="GET" class="d-flex flex-wrap gap-2 mb-3">
        <input type="text" class="form-control" placeholder="Type To Search Products…" name="search" value="{{ old('search', session('input.search')) }}" style="max-width:260px;">
        <select class="form-select" id="category" name="category" style="max-width:220px;">
            <option value="" @selected(session('category') == '')>All category</option>
            @foreach ($categories as $category)
            <option value="{{ $category->category }}" @selected(session('category') == $category->category)>{{ $category->category }}</option>
            @endforeach
        </select>
        <select class="form-select select2" id="shop" name="shop" style="max-width:280px;">
            <option value="">Select Shop</option>
            @foreach ($shops as $shop)
            <option value="{{ $shop->branch_code }}" {{ (request()->input('shop') == $shop->branch_code || old('shop') == $shop->branch_code) ? 'selected' : '' }}>
                {{ $shop->name }}
            </option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-accent">Search</button>
    </form>

    <form action="{{ route('order-admin.add-to-cart-all') }}" method="POST" id="cart-all">
        @csrf
        @if ($my_shop)
        <input type="hidden" name="branch_code" value="{{ $my_shop }}">
        @endif
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
                    <th>Select</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                @php $inCart = isset($cart_item) && $cart_item->contains('item_number', $product->item_number); @endphp
                <tr @if ($inCart) class="in-cart" @endif>
                    <td>{{ $loop->iteration }}</td>
                    <td><img class="img-thumb" src="{{ asset('assets/images/item-images/' . $product->img) }}" alt=""></td>
                    <td class="mono">{{ $product->item_number }}</td>
                    <td>{{ $product->name_english }}</td>
                    <td>
                        @if ($inCart)
                        <input class="form-control form-control-sm" type="number" name="qty[{{ $product->item_number }}]" value="{{ $cart_item->firstWhere('item_number', $product->item_number)->qty }}" disabled style="max-width:120px;">
                        @else
                        <input class="form-control form-control-sm" type="number" name="qty[{{ $product->item_number }}]" min="0" step="0.01" required pattern="[0-9]+(\.[0-9]+)?" value="0" form="cart-all" style="max-width:120px;">
                        @endif
                    </td>
                    <td>
                        @if ($inCart)
                        <label class="switch mb-0">
                            <input type="checkbox" name="selected_items[]" value="{{ $product->item_number }}" disabled checked>
                            <span class="slider"></span>
                        </label>
                        @else
                        <input type="hidden" name="item_numbers[]" value="{{ $product->item_number }}" form="cart-all">
                        <label class="switch mb-0">
                            <input type="checkbox" name="selected_items[]" value="{{ $product->item_number }}" form="cart-all">
                            <span class="slider"></span>
                        </label>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end mt-3">
        @if ($my_shop)
        <button type="submit" form="cart-all" class="btn btn-accent">Add all to cart</button>
        @else
        <button disabled class="btn btn-accent">Add all to cart</button>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#shop').change(function() {
            let shop = $(this).val();
            let add_to_cart = $('.add-to-cart-btn');
            let cart = $('.cart-btn');
            if (shop == '') {
                add_to_cart.prop('disabled', true);
                cart.addClass('disabled');
            } else {
                add_to_cart.prop('disabled', false);
                cart.removeClass('disabled');
            }
        });
        $('#shop').trigger('change');

        $('#shop').select2({
            placeholder: "Select Shop",
            allowClear: true
        });
    });

    function cart_btn() {
        document.getElementById('warning').style.display = 'block';
    }
</script>
@endpush
