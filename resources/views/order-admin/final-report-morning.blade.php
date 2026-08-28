@extends('layouts.bakery')

@section('title', 'Final Morning Report | Perera Bakers')

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

        .div2 {
            height: 800px;
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
            /* min-width: 160px; */
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
        <h1 class="display-font page-title mb-1">Final Morning Report</h1>
        <div class="page-sub">Dashboard / Final Morning Report</div>
    </div>
    <div class="d-flex gap-2">
        <a class="btn btn-soft" href="/order-admin/final-report-evening">Evening Report</a>
        <a class="btn btn-accent" href="/order-admin/final-report-full-screen">Full Screen</a>
    </div>
</div>

@include('components.bakery.alerts')

<div class="panel">
    <div class="panel-head">
        <div>
            <h2>Today Morning Final Report</h2>
            <div class="sub">{{ now()->format('Y-m-d') }}</div>
        </div>
    </div>
    <div class="div">
                                        <table class="table-bordered border-dark">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th style="min-width: 280px;">Item Code | Item</th>
                                                    @foreach ($routes_normal as $route)
                                                    <th style="min-width: 200px;">
                                                        {{$route->name}}
                                                    </th>
                                                    @endforeach

                                                    <th class="table-primary">Normal Rout Total</th>

                                                    @foreach ($routes_special as $route)
                                                    <th style="min-width: 200px;">
                                                        {{$route->name}}
                                                    </th>
                                                    @endforeach

                                                    <th class="table-danger">Special Rout Total</th>

                                                    @foreach ($routes_pbd as $route)
                                                    <th style="min-width: 200px;">
                                                        {{$route->name}}
                                                    </th>
                                                    @endforeach

                                                    <th class="table-info">PBD Total</th>
                                                    <th class="table-warning">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody style="max-height: 400px;">
                                                @php
                                                $currentDate = new DateTime();
                                                @endphp
                                                @foreach ($products as $product)
                                                @php
                                                $normal_total = 0;
                                                $special_total = 0;
                                                $pbd_total = 0;
                                                @endphp
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$product->item_number}} | {{$product->name_english}}</td>

                                                    @foreach ($routes_normal as $route)
                                                    @php
                                                    $qty = DB::table('orders')
                                                    ->join('carts', 'orders.unique_id', '=', 'carts.order_number')
                                                    ->join('shops','orders.shop','=','shops.branch_code')
                                                    ->where('carts.item_number', $product->item_number)
                                                    ->whereDate('orders.created_at', $currentDate)
                                                    ->where('shops.morning_route', $route->name)
                                                    ->where('orders.status', '=', 'Processing')
                                                    ->where('orders.time_period', '=', 'Morning')
                                                    ->sum('carts.qty');
                                                    $normal_total += $qty;
                                                    @endphp
                                                    <td>{{$qty}}</td>
                                                    @endforeach

                                                    <td class="table-primary">{{$normal_total}}</td>

                                                    @foreach ($routes_special as $route)
                                                    @php
                                                    $qty = DB::table('orders')
                                                    ->join('carts', 'orders.unique_id', '=', 'carts.order_number')
                                                    ->join('shops','orders.shop','=','shops.branch_code')
                                                    ->where('carts.item_number', $product->item_number)
                                                    ->whereDate('orders.created_at', $currentDate)
                                                    ->where('shops.morning_route', $route->name)
                                                    ->where('orders.status', '=', 'Processing')
                                                    ->where('orders.time_period', '=', 'Morning')
                                                    ->sum('carts.qty');
                                                    $special_total += $qty;
                                                    @endphp
                                                    <td>{{$qty}}</td>
                                                    @endforeach
                                                    <td class="table-danger">{{$special_total}}</td>


                                                    @foreach ($routes_pbd as $route)
                                                    @php
                                                    $qty = DB::table('orders')
                                                    ->join('carts', 'orders.unique_id', '=', 'carts.order_number')
                                                    ->join('shops','orders.shop','=','shops.branch_code')
                                                    ->where('carts.item_number', $product->item_number)
                                                    ->whereDate('orders.created_at', $currentDate)
                                                    ->where('shops.morning_route', $route->name)
                                                    ->where('orders.status', '=', 'Processing')
                                                    ->where('orders.time_period', '=', 'Morning')
                                                    ->sum('carts.qty');
                                                    $pbd_total += $qty;
                                                    @endphp
                                                    <td>{{$qty}}</td>
                                                    @endforeach
                                                    <td class="table-info">{{$pbd_total}}</td>
                                                    <td class="table-warning">{{$normal_total+$special_total+$pbd_total}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
    </div>
    <div class="mt-3">{{ $products->links() }}</div>
</div>

@endsection
