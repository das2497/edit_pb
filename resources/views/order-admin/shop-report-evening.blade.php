@extends('layouts.bakery')

@section('title', 'Evening Shop Report | Perera Bakers')

@push('styles')
<style>
        .div {
            height: 400px;
            /* max-width: 100vw; */
            overflow-x: auto;
            overflow-y: auto;
            position: relative;
            /* margin-top: 100px; */
        }

        table {
            border-collapse: collapse;
            table-layout: fixed;

        }

        thead {
            th {
                position: sticky;
                top: 0;
                left: 0;


                &:first-child {
                    z-index: 3;
                }
            }
        }

        th,
        td {
            /* padding: 10px 100px; */
            text-transform: capitalize;
            border: 1px solid var(--border);
            padding-inline: 20px;
        }

        th {
            background: var(--surface);
            /* color: white; */
            white-space: nowrap;

            &:first-child,
            &:nth-child(2)

            /* &:nth-child(3)  */
                {
                position: sticky;
                left: 0px;
                z-index: 3;
                background-color: var(--surface-2);
                color: var(--text);
            }
        }

        td {

            &:first-child,
            &:nth-child(2)

            /* &:nth-child(3)  */
                {
                position: sticky;
                left: 0px;
                z-index: 2;
                background-color: var(--surface-2);
                color: var(--text);
            }
        }
        /* bakery theme overrides for report grids */
        .div table, .div2 table { color: var(--text); background: var(--surface); }
        .div th, .div td, .div2 th, .div2 td { color: var(--text); }
        .div .table-primary, .div2 .table-primary { background: rgba(91,127,166,.28) !important; color: var(--text); }
        .div .table-danger, .div2 .table-danger { background: rgba(178,58,72,.24) !important; color: var(--text); }
        .div .table-warning, .div2 .table-warning { background: rgba(201,138,59,.32) !important; color: var(--text); }
        .div .table-success, .div2 .table-success { background: rgba(76,124,107,.3) !important; color: var(--text); }
        .div .table-info, .div2 .table-info { background: rgba(91,127,166,.22) !important; color: var(--text); }
        .div .bg-light, .div2 .bg-light { background: var(--surface-2) !important; color: var(--text); }

</style>
@endpush

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
    <div>
        <h1 class="display-font page-title mb-1">Evening Shop Report</h1>
        <div class="page-sub">Dashboard / Evening Shop Report</div>
    </div>
    <div class="d-flex gap-2">
        <a class="btn btn-soft" href="/order-admin/shop-report">Morning Report</a>
        <a class="btn btn-accent" href="/order-admin/shop-report-full-screen-evening">Full Screen</a>
    </div>
</div>

@include('components.bakery.alerts')

<div class="panel">
    <div class="panel-head">
        <div>
            <h2>Today Evening Shop Report</h2>
            <div class="sub">{{ now()->format('Y-m-d') }}</div>
        </div>
    </div>
    <div class="div">
                                        <table class="table-bordered border-dark">
                                            <thead class="bg-light ">
                                                <tr>
                                                    <th>#</th>
                                                    <th style="min-width: 280px;">Item Code | Item</th>
                                                    @foreach ($header_normal as $head)
                                                    <th style="min-width: 200px;" colspan="2">
                                                        <h6>{{$head->shop_name}}</h6>
                                                        <h6>{{$head->branch_code}}</h6>
                                                    </th>
                                                    @endforeach
                                                    <th class="table-primary">
                                                        <h6>Normal Route Total</h6>
                                                    </th>

                                                    @foreach ($header_special as $head)
                                                    <th style="min-width: 200px;" colspan="2">
                                                        <h6>{{$head->shop_name}}</h6>
                                                        <h6>{{$head->branch_code}}</h6>
                                                    </th>
                                                    @endforeach
                                                    <th class="table-danger">
                                                        <h6>Special Route Total</h6>
                                                    </th>

                                                    @foreach ($header_pbd as $head)
                                                    <th style="min-width: 200px;" colspan="2">
                                                        <h6>{{$head->shop_name}}</h6>
                                                        <h6>{{$head->branch_code}}</h6>
                                                    </th>
                                                    @endforeach
                                                    <th class="table-danger">
                                                        <h6>PBD Route Total</h6>
                                                    </th>

                                                    <th class="table-warning">
                                                        <h6>Total</h6>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody style="max-height: 400px;">
                                                @php
                                                $total_normal = 0;
                                                $total_special = 0;
                                                $total_pbd = 0;
                                                $index = 0;
                                                $timeZone = 'Asia/Colombo';
                                                $currentDate = new DateTime();
                                                @endphp
                                                @foreach ($products as $product)
                                                @php
                                                // Reset the totals for each product
                                                $total_normal = 0;
                                                $total_special = 0;
                                                $total_pbd = 0;
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $product->item_number }} | {{ $product->name_english }}</td>

                                                    {{-- Normal Route --}}
                                                    @foreach ($header_normal as $head)
                                                    @php
                                                    $order = DB::table('orders')
                                                    ->join('carts', 'orders.unique_id', '=', 'carts.order_number')
                                                    ->where('orders.shop', '=', $head->branch_code)
                                                    ->where('carts.item_number', '=', $product->item_number)
                                                    ->where('orders.time_period', '=', 'Evening')
                                                    ->where('orders.status','=','Processing')
                                                    ->whereDate('orders.created_at', $currentDate)
                                                    ->select('carts.*', 'orders.*')
                                                    ->first();

                                                    $orderQty = $order ? $order->qty : 0; // Check if $order exists
                                                    if ($order) {
                                                    $total_normal += $orderQty;
                                                    }
                                                    @endphp
                                                    <th class="{{ $orderQty != 0 ? 'table-success' : '' }}">
                                                        {{ $orderQty }}
                                                    </th>
                                                    <th style="max-width: 180px; overflow-x: scroll;">
                                                        <span>{{ $order ? $order->remarke : '' }}</span>
                                                    </th>
                                                    @endforeach

                                                    <td class="table-primary">{{ $total_normal }}</td>

                                                    {{-- Special Route --}}
                                                    @foreach ($header_special as $head)
                                                    @php
                                                    $order = DB::table('orders')
                                                    ->join('carts', 'orders.unique_id', '=', 'carts.order_number')
                                                    ->where('orders.shop', '=', $head->branch_code)
                                                    ->where('carts.item_number', '=', $product->item_number)
                                                    ->where('orders.time_period', '=', 'Evening')
                                                    ->where('orders.status','=','Processing')
                                                    ->whereDate('orders.created_at', $currentDate)
                                                    ->select('carts.*', 'orders.*')
                                                    ->first();

                                                    $orderQty = $order ? $order->qty : 0; // Check if $order exists
                                                    if ($order) {
                                                    $total_special += $orderQty;
                                                    }
                                                    @endphp
                                                    <th class="{{ $orderQty != 0 ? 'table-success' : '' }}">
                                                        {{ $orderQty }}
                                                    </th>
                                                    <th style="max-width: 180px; overflow-x: scroll;">
                                                        <span>{{ $order ? $order->remarke : '' }}</span>
                                                    </th>
                                                    @endforeach

                                                    <td class="table-danger">{{ $total_special }}</td>

                                                    {{-- PBD Route --}}
                                                    @foreach ($header_pbd as $head)
                                                    @php
                                                    $order = DB::table('orders')
                                                    ->join('carts', 'orders.unique_id', '=', 'carts.order_number')
                                                    ->where('orders.shop', '=', $head->branch_code)
                                                    ->where('carts.item_number', '=', $product->item_number)
                                                    ->where('orders.time_period', '=', 'Evening')
                                                    ->where('orders.status','=','Processing')
                                                    ->whereDate('orders.created_at', $currentDate)
                                                    ->select('carts.*', 'orders.*')
                                                    ->first();

                                                    $orderQty = $order ? $order->qty : 0; // Check if $order exists
                                                    if ($order) {
                                                    $total_pbd += $orderQty;
                                                    }
                                                    @endphp
                                                    <th class="{{ $orderQty != 0 ? 'table-success' : '' }}">
                                                        {{ $orderQty }}
                                                    </th>
                                                    <th style="max-width: 180px; overflow-x: scroll;">
                                                        <span>{{ $order ? $order->remarke : '' }}</span>
                                                    </th>
                                                    @endforeach

                                                    <td class="table-danger">{{ $total_pbd }}</td>

                                                    {{-- Total for all routes --}}
                                                    <td class="table-warning">{{ $total_normal + $total_special + $total_pbd }}</td>
                                                </tr>
                                                @php
                                                $index++;
                                                @endphp
                                                @endforeach
                                            </tbody>

                                        </table>
    </div>
    <div class="mt-3">{{ $products->links() }}</div>
</div>

@endsection
