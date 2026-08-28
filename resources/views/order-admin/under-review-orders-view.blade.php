@extends('layouts.bakery')

@section('title', 'Under Review Orders View | Perera Bakers')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
    <div>
        <h1 class="display-font page-title mb-1">Under Review Orders View</h1>
        <div class="page-sub">Dashboard / Under Review Orders / <span class="mono">{{ $order_number }}</span></div>
    </div>
    <div class="d-flex gap-2">
        @if (Auth::user()->role !== 'view')
        <a class="btn btn-accent" href="{{ route('order-admin-under-review-orders-add-items', ['order_number' => $order_number]) }}">
            <i class="bi bi-plus-square me-1"></i> Add product
        </a>
        @endif
        <a href="/order-admin/under-review-orders" class="btn btn-soft">Go Back</a>
    </div>
</div>

@include('components.bakery.alerts')

<div class="panel">
    <div class="panel-head">
        <div>
            <h2>Order Items</h2>
            <div class="sub">Note : {{ $order_note ?: '—' }}</div>
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
                    <th>Remark</th>
                    <th>Amount</th>
                    @if (Auth::user()->role !== 'view')
                    <th></th>
                    <th></th>
                    @endif
                </tr>
            </thead>
            @if (Auth::user()->role === 'view')
            <tbody>
                @php $total = 0; @endphp
                @foreach ($items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><img class="img-thumb" src="{{ asset('assets/images/item-images/' . $item->img) }}" alt=""></td>
                    <td class="mono">{{ $item->item_number }}</td>
                    <td>{{ $item->name_english }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ $item->remarke }}</td>
                    <td class="mono">රු. {{ number_format($item->price * $item->qty, 2) }}</td>
                </tr>
                @php $total += $item->price * $item->qty; @endphp
                @endforeach
                <tr>
                    <th colspan="6" class="text-end">Total :</th>
                    <th class="mono">රු. {{ number_format($total, 2) }}</th>
                </tr>
            </tbody>
            @else
            <tbody>
                @php $total = 0; @endphp
                @foreach ($items as $item)
                @php $fid = 'item-' . $loop->iteration; @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><img class="img-thumb" src="{{ asset('assets/images/item-images/' . $item->img) }}" alt=""></td>
                    <td class="mono">{{ $item->item_number }}</td>
                    <td>{{ $item->name_english }}</td>
                    <td><input type="number" class="form-control form-control-sm" min="0" step="0.01" required pattern="[0-9]+(\.[0-9]+)?" value="{{ $item->qty }}" name="qty" form="{{ $fid }}" style="min-width:100px;"></td>
                    <td><input type="text" class="form-control form-control-sm" value="{{ $item->remarke }}" name="remarke" form="{{ $fid }}" style="min-width:120px;"></td>
                    <td class="mono">රු. {{ number_format($item->price * $item->qty, 2) }}</td>
                    <td>
                        <form action="/order-admin/under-review-orders-update" method="POST" id="{{ $fid }}">
                            @csrf
                            <input type="hidden" name="item_number" value="{{ $item->item_number }}">
                            <input type="hidden" name="order_number" value="{{ $item->order_number }}">
                            <input type="hidden" name="shop" value="{{ $shop }}">
                            <button type="submit" class="btn btn-soft btn-sm">Update</button>
                        </form>
                    </td>
                    <td><button type="submit" form="{{ $fid }}" formaction="/order-admin/under-review-orders-delete" onclick="return confirmDelete();" class="btn btn-soft btn-sm" style="color:var(--accent);">Delete</button></td>
                </tr>
                @php $total += $item->price * $item->qty; @endphp
                @endforeach
                <tr>
                    <th colspan="6" class="text-end">Total :</th>
                    <th class="mono">රු. {{ number_format($total, 2) }}</th>
                    <th colspan="2"></th>
                </tr>
            </tbody>
            @endif
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this item?');
    }
</script>
@endpush
