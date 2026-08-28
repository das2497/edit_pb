@extends('layouts.bakery')

@section('title', 'Add Products | Perera Bakers')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
    <div>
        <h1 class="display-font page-title mb-1">Add Products</h1>
        <div class="page-sub">Dashboard / Add Products</div>
    </div>
</div>

@include('components.bakery.alerts')

@if (Auth::user()->role === 'view')
<div class="panel mb-4">
    <div class="panel-head">
        <div>
            <h2>All Products</h2>
        </div>
        <form action="/order-admin/add-products" method="GET" class="d-flex gap-2">
            <input type="text" class="form-control form-control-sm" placeholder="Search Products…" name="search" style="min-width:200px;">
            <button type="submit" class="btn btn-soft btn-sm">Search</button>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-bakery align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Item ID</th>
                    <th>Name English</th>
                    <th>Name Sinhala</th>
                    <th>Category</th>
                    <th>Visibility</th>
                    <th>PB Unit Price</th>
                    <th>PB MRP</th>
                    <th>PB Direct Sale Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><img class="img-thumb" style="width:64px; height:64px;" src="{{ asset('assets/images/item-images/' . $product->img) }}" alt=""></td>
                    <td class="mono">{{ $product->item_number }}</td>
                    <td>{{ $product->name_english }}</td>
                    <td>{{ $product->name_sinhala }}</td>
                    <td>{{ $product->category }}</td>
                    <td>{{ $product->visibility }}</td>
                    <td class="mono">{{ $product->unit_price }}</td>
                    <td class="mono">{{ $product->mrp }}</td>
                    <td class="mono">{{ $product->direct_sale_price }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $products->links() }}</div>
</div>
<div class="panel">
    <div class="panel-head">
        <div>
            <h2>All Categories</h2>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bakery align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Category</th>
                    <th>Main Category</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $category->category }}</td>
                    <td>{{ $category->main_category }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $categories->links() }}</div>
</div>
@else
<div class="row g-4">
    <div class="col-xl-3 col-lg-12">
        <div class="panel mb-4">
            <div class="panel-head">
                <div>
                    <h2>Add Products</h2>
                </div>
            </div>
            <form action="{{ route('order-admin-add-products') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="file" class="form-label">Item Image</label>
                    <input name="file" id="file" type="file" class="form-control" value="{{ old('file') }}">
                </div>
                <div class="mb-3">
                    <label for="item_num" class="form-label">Item Number</label>
                    <input name="item_number" id="item_num" type="text" class="form-control" placeholder="Item Number" value="{{ old('item_number') }}">
                </div>
                <div class="mb-3">
                    <label for="item_name_e" class="form-label">Item Name English</label>
                    <input name="item_name_e" id="item_name_e" type="text" placeholder="Item Name" class="form-control" value="{{ old('item_name_e') }}">
                </div>
                <div class="mb-3">
                    <label for="item_name_s" class="form-label">Item Name Sinhala</label>
                    <input name="item_name_s" id="item_name_s" type="text" placeholder="Item Name" class="form-control" value="{{ old('item_name_s') }}">
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Product Category</label>
                    <select class="form-select" id="category" name="category">
                        <option value="">Select Category</option>
                        @foreach ($product_categories_drop_down as $category)
                        <option value="{{ $category->category }}">{{ $category->category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="visibility" class="form-label">Select Visibility</label>
                    <select class="form-select" id="visibility" name="visibility">
                        <option value="">Select Visibility</option>
                        <option value="All">All</option>
                        <option value="Rep">Rep</option>
                        <option value="Shop">Shop</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="pb_unit_price" class="form-label">PB Unit Price</label>
                    <input name="pb_unit_price" id="pb_unit_price" type="text" placeholder="PB Unit Price" class="form-control" value="{{ old('pb_unit_price') }}">
                </div>
                <div class="mb-3">
                    <label for="pb_mrp" class="form-label">PB MRP</label>
                    <input name="pb_mrp" id="pb_mrp" type="text" placeholder="PB MRP" class="form-control" value="{{ old('pb_mrp') }}">
                </div>
                <div class="mb-3">
                    <label for="pb_direct_sale_price" class="form-label">PB Direct Sale Price</label>
                    <input name="pb_direct_sale_price" id="pb_direct_sale_price" type="text" placeholder="PB Direct Sale price" class="form-control" value="{{ old('pb_direct_sale_price') }}">
                </div>
                <button type="submit" class="btn btn-accent w-100">Add</button>
            </form>
        </div>
        <div class="panel">
            <div class="panel-head">
                <div>
                    <h2>Add Category</h2>
                </div>
            </div>
            <form action="{{ route('order-admin-add-product-category') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="main-category" class="form-label">Main Category</label>
                    <select class="form-select" name="main_category" id="main-category">
                        <option value="">Select Main Category</option>
                        <option value="PB">PB</option>
                        <option value="NPB">NPB</option>
                        <option value="PB Premium">PB Premium</option>
                        <option value="PBI">PBI</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="item_catgry" class="form-label">Category Name</label>
                    <input id="item_catgry" name="category" type="text" placeholder="Type Category Name" class="form-control">
                </div>
                <button class="btn btn-accent w-100" type="submit">Add</button>
            </form>
        </div>
    </div>
    <div class="col-xl-9 col-lg-12">
        <div class="panel mb-4">
            <div class="panel-head">
                <div>
                    <h2>All Products</h2>
                </div>
                <form action="/order-admin/add-products" method="GET" class="d-flex gap-2">
                    <input type="text" class="form-control form-control-sm" placeholder="Search Products…" name="search" style="min-width:180px;">
                    <button type="submit" class="btn btn-soft btn-sm">Search</button>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-bakery align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Item ID</th>
                            <th>Name English</th>
                            <th>Name Sinhala</th>
                            <th>Category</th>
                            <th>Visibility</th>
                            <th>PB Unit Price</th>
                            <th>PB MRP</th>
                            <th>PB Direct Sale Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><img class="img-thumb" style="width:64px; height:64px;" src="{{ asset('assets/images/item-images/' . $product->img) }}" alt=""></td>
                            <td class="mono">{{ $product->item_number }}</td>
                            <td>{{ $product->name_english }}</td>
                            <td>{{ $product->name_sinhala }}</td>
                            <td>{{ $product->category }}</td>
                            <td>{{ $product->visibility }}</td>
                            <td class="mono">{{ $product->unit_price }}</td>
                            <td class="mono">{{ $product->mrp }}</td>
                            <td class="mono">{{ $product->direct_sale_price }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button type="button" class="btn btn-soft btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal{{ $product->id }}">
                                        Update
                                    </button>
                                    <form method="POST" action="{{ route('order-admin-products.delete', $product->id) }}">
                                        @csrf
                                        <button type="submit" onclick="return confirmDelete();" class="btn btn-soft btn-sm" style="color:var(--accent);">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $products->links() }}</div>
        </div>
        <div class="panel">
            <div class="panel-head">
                <div>
                    <h2>All Categories</h2>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bakery align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Main Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->category }}</td>
                            <td>{{ $category->main_category }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button type="button" class="btn btn-soft btn-sm" data-bs-toggle="modal" data-bs-target="#updateCatModal{{ $category->id }}">
                                        Update
                                    </button>
                                    <form method="POST" action="{{ route('order-admin-delete-product-category', $category->id) }}">
                                        @csrf
                                        <button type="submit" onclick="return confirmDelete();" class="btn btn-soft btn-sm" style="color:var(--accent);">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $categories->links() }}</div>
        </div>
    </div>
</div>

@foreach ($products as $product)
<div class="modal fade" id="updateModal{{ $product->id }}" tabindex="-1" aria-labelledby="updateModalLabel{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('order-admin-products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel{{ $product->id }}">Update Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Item ID</label>
                        <input type="text" class="form-control" name="item_number" value="{{ $product->item_number }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Item Name English</label>
                        <input type="text" class="form-control" name="name_english" value="{{ $product->name_english }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Item Name Sinhala</label>
                        <input type="text" class="form-control" name="name_sinhala" value="{{ $product->name_sinhala }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select class="form-select" name="category">
                            <option value="">Select Category</option>
                            @foreach ($product_categories_drop_down as $category)
                            <option value="{{ $category->category }}" @selected($product->category == $category->category)>
                                {{ $category->category }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Select Visibility</label>
                        <select class="form-select" name="visibility">
                            <option value="">Select Visibility</option>
                            <option value="All" @selected($product->visibility === 'All')>All</option>
                            <option value="Rep" @selected($product->visibility === 'Rep')>Rep</option>
                            <option value="Shop" @selected($product->visibility === 'Shop')>Shop</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">PB Unit Price</label>
                        <input type="text" class="form-control" name="unit_price" value="{{ $product->unit_price }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">PB MRP</label>
                        <input type="text" class="form-control" name="mrp" value="{{ $product->mrp }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">PB Direct Sale Price</label>
                        <input type="text" class="form-control" name="direct_sale_price" value="{{ $product->direct_sale_price }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Item Image</label>
                        <input type="file" class="form-control" name="img">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-accent">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@foreach ($categories as $category)
<div class="modal fade" id="updateCatModal{{ $category->id }}" tabindex="-1" aria-labelledby="updateCatModalLabel{{ $category->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('order-admin-update-product-category', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="updateCatModalLabel{{ $category->id }}">Update Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <input type="text" class="form-control" name="category" value="{{ $category->category }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Main Category</label>
                        <select class="form-select" name="main_category">
                            <option value="">Select Main Category</option>
                            <option value="PB" @selected($category->main_category == 'PB')>PB</option>
                            <option value="NPB" @selected($category->main_category == 'NPB')>NPB</option>
                            <option value="PB Premium" @selected($category->main_category == 'PB Premium')>PB Premium</option>
                            <option value="PBI" @selected($category->main_category == 'PBI')>PBI</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-accent">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endif

@endsection

@push('scripts')
<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this?');
    }
</script>
@endpush
