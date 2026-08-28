@extends('layouts.bakery')

@section('title', 'Morning Final Report - Full Screen | Rep')

@push('styles')
<style>

        .div {
            height: 600px;
            /* max-width: 100vw; */
            overflow-x: auto;
            overflow-y: auto;
            position: relative;
            /* margin-top: 100px; */
        }

        .div2 {
            height: 600px;
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
            color: var(--text);
            /* min-width: 160px; */
        }

        th {
            /* background: white; */
            color: var(--text);
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
    
    /* bakery theme overrides */
    #productsTable { color: var(--text); --bs-table-bg: transparent; }
    #productsTable th, #productsTable td { color: var(--text); }
    #productsTable .table-info { background: rgba(91,127,166,.22) !important; color: var(--text); }
    #productsTable .table-warning { background: rgba(201,138,59,.32) !important; color: var(--text); }
    #productsTable .table-secondary { background: var(--surface-2) !important; color: var(--text); }
    #productsTable .table-success { background: rgba(76,124,107,.3) !important; color: var(--text); }
    #productsTable .bg-light { background: var(--surface-2) !important; color: var(--text); }

</style>
@endpush

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
    <div>
        <h1 class="display-font page-title mb-1">Morning Final Report - Full Screen</h1>
        <div class="page-sub">Rep / Full Screen Final Report</div>
    </div>
    <div class="d-flex gap-2">
        <a href="/rep/final-report-morning" class="btn btn-soft btn-sm"><i class="bi bi-arrow-left me-1"></i> Back to Report</a>
        <a href="/rep/final-report-morning-full-screen" class="btn btn-accent btn-sm d-none"></a>
    </div>
</div>

@include('components.bakery.alerts')

<div class="panel">
    <div class="panel-head">
        <div>
            <h2>Morning Final Report - Full Screen</h2>
            <div class="sub">Full screen view - scroll horizontally & vertically</div>
        </div>
        <div class="d-flex gap-2">
            <a href="/rep/final-report-morning" class="btn btn-soft btn-sm"><i class="bi bi-arrow-left me-1"></i> Back to Report</a>
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
                                        $special_total += $qty;
                                        @endphp
                                        <td>{{$qty}}</td>
                                        @endforeach

                                        <td class="table-info">{{$pbd_total}}</td>
                                        <td class="table-warning">{{$normal_total+$special_total}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <p class="text-center">{{$products->links()}}</p>
                    </div>
                </div>
            </div>
        </div>
</div>

@endsection
