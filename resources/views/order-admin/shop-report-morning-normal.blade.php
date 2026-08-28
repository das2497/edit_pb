@extends('layouts.bakery')

@section('title', 'Morning Normal Shop Report | Perera Bakers')

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
        <h1 class="display-font page-title mb-1">Morning Normal Shop Report</h1>
        <div class="page-sub">Dashboard / Morning Normal Shop Report</div>
    </div>
    <div class="d-flex gap-2">
        <a class="btn btn-soft" href="/order-admin/shop-report-evening">Evening Normal Report</a>
        <a class="btn btn-accent" href="/order-admin/shop-report-normal-full-screen">Full Screen</a>
    </div>
</div>

@include('components.bakery.alerts')

<div class="panel">
    <div class="panel-head">
        <div>
            <h2>Today Morning Normal Shop Report</h2>
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
                                                    <th style="min-width: 200px;">
                                                        <h6>{{$head->shop_name}}</h6>
                                                        <h6>{{$head->branch_code}}</h6>
                                                    </th>
                                                    @endforeach
                                                    <th class="table-primary"><h6>Normal Route Total</h6></th>
                                                </tr>
                                            </thead>
                                            <tbody style="max-height: 400px;">
                                                @php
                                                $total_normal = 0;
                                                $total_special = 0;
                                                $index = 0;
                                                $timeZone = 'Asia/Colombo';
                                                $currentDate = new DateTime();
                                                @endphp
                                                @foreach ($products as $product)
                                                @php
                                                $total_normal = 0;
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $product->item_number }} | {{ $product->name_english }}</td>
                                                    @foreach ($header_normal as $head)
                                                    @php

                                                    $order = DB::table('orders')
                                                    ->join('carts', 'orders.unique_id', '=', 'carts.order_number')
                                                    ->where('orders.shop', '=', $head->branch_code)
                                                    ->where('carts.item_number', '=', $product->item_number)
                                                    ->where('orders.time_period', '=', 'Morning')
                                                    ->where('orders.status','=','Complete')
                                                    ->whereDate('orders.created_at', $currentDate)
                                                    ->select('carts.*', 'orders.*')
                                                    ->first();

                                                    $order_note = DB::table('orders')
                                                    ->where('shop','=',$head->branch_code)
                                                    ->where('orders.status','=','Complete')
                                                    ->where('orders.time_period', '=', 'Morning')
                                                    ->whereDate('orders.created_at', $currentDate)
                                                    ->first();

                                                    $words = explode(" ", $order_note->note ?? '');
                                                    @endphp

                                                    @if ($order)
                                                    @php
                                                    $total_normal += $order->qty;
                                                    @endphp
                                                    <th class="{{ $order->qty != 0 ? 'table-success' : 'table-danger' }}">
                                                        {{ $order->qty }} | {{ $words[$index] ?? '' }}
                                                    </th>
                                                    @else
                                                    <td>0 | {{ $words[$index] ?? '' }}</td>
                                                    @endif
                                                    @endforeach

                                                    <td class="table-primary">{{ $total_normal }}</td>
                                                </tr>
                                                @php
                                                $index++;
                                                @endphp
                                                @endforeach

                                            </tbody>
                                        </table>
    </div>
</div>

@endsection
