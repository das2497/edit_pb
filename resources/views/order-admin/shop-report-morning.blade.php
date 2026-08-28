@extends('layouts.bakery')

@section('title', 'Morning Shop Report | Perera Bakers')

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
        <h1 class="display-font page-title mb-1">Morning Shop Report</h1>
        <div class="page-sub">Dashboard / Morning Shop Report</div>
    </div>
    <div class="d-flex gap-2">
        <a class="btn btn-soft" href="/order-admin/shop-report-evening">Evening Report</a>
        <a class="btn btn-accent" href="/order-admin/shop-report-full-screen">Full Screen</a>
    </div>
</div>

@include('components.bakery.alerts')

<div class="panel">
    <div class="panel-head">
        <div>
            <h2>Today Morning Shop Report</h2>
            <div class="sub">{{ now()->format('Y-m-d') }}</div>
        </div>
                                        <form class="row" action="/order-admin/shop-report" method="GET">
                                            @csrf
                                            <div class="col-4">
                                                <input type="date" name="date" id="" class="form-control">
                                            </div>
                                            <div class="col-4">
                                                <select name="state" id="" class="form-control">
                                                    <option value="Processing">Processing</option>
                                                    <option value="Pending">Pending</option>
                                                    <option value="Complete">Complete</option>
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <button class="btn btn-primary" type="submit">Search</button>
                                            </div>
                                        </form>
    </div>
    <div class="div">
                                        <table class="table-bordered border-dark">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th style="min-width: 280px;">Item Code | Item</th>

                                                    {{-- Normal --}}
                                                    @foreach ($header_normal as $head)
                                                    <th style="min-width: 200px;" colspan="2">
                                                        <h6>{{ $head->shop_name }}</h6>
                                                        <h6>{{ $head->branch_code }}</h6>
                                                    </th>
                                                    @endforeach
                                                    <th class="table-primary">
                                                        <h6>Normal Route Total</h6>
                                                    </th>

                                                    {{-- Special --}}
                                                    @foreach ($header_special as $head)
                                                    <th style="min-width: 200px;" colspan="2">
                                                        <h6>{{ $head->shop_name }}</h6>
                                                        <h6>{{ $head->branch_code }}</h6>
                                                    </th>
                                                    @endforeach
                                                    <th class="table-danger">
                                                        <h6>Special Route Total</h6>
                                                    </th>

                                                    {{-- PBD --}}
                                                    @foreach ($header_pbd as $head)
                                                    <th style="min-width: 200px;" colspan="2">
                                                        <h6>{{ $head->shop_name }}</h6>
                                                        <h6>{{ $head->branch_code }}</h6>
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

                                            <tbody>
                                                @foreach ($products as $product)
                                                @php
                                                $total_normal = $total_special = $total_pbd = 0;
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $product->item_number }} | {{ $product->name_english }}</td>

                                                    {{-- Normal --}}
                                                    @foreach ($header_normal as $head)
                                                    @php
                                                    $order = $orderMap[$head->branch_code][$product->item_number] ?? null;
                                                    $qty = $order['qty'] ?? 0;
                                                    $remark = $order['remark'] ?? '';
                                                    $total_normal += $qty;
                                                    @endphp
                                                    <td class="{{ $qty ? 'table-success' : '' }}">{{ $qty }}</td>
                                                    <td style="max-width: 180px; overflow-x: auto;"><span>{{ $remark }}</span></td>
                                                    @endforeach
                                                    <td class="table-primary">{{ $total_normal }}</td>

                                                    {{-- Special --}}
                                                    @foreach ($header_special as $head)
                                                    @php
                                                    $order = $orderMap[$head->branch_code][$product->item_number] ?? null;
                                                    $qty = $order['qty'] ?? 0;
                                                    $remark = $order['remark'] ?? '';
                                                    $total_special += $qty;
                                                    @endphp
                                                    <td class="{{ $qty ? 'table-success' : '' }}">{{ $qty }}</td>
                                                    <td style="max-width: 180px; overflow-x: auto;"><span>{{ $remark }}</span></td>
                                                    @endforeach
                                                    <td class="table-danger">{{ $total_special }}</td>

                                                    {{-- PBD --}}
                                                    @foreach ($header_pbd as $head)
                                                    @php
                                                    $order = $orderMap[$head->branch_code][$product->item_number] ?? null;
                                                    $qty = $order['qty'] ?? 0;
                                                    $remark = $order['remark'] ?? '';
                                                    $total_pbd += $qty;
                                                    @endphp
                                                    <td class="{{ $qty ? 'table-success' : '' }}">{{ $qty }}</td>
                                                    <td style="max-width: 180px; overflow-x: auto;"><span>{{ $remark }}</span></td>
                                                    @endforeach
                                                    <td class="table-danger">{{ $total_pbd }}</td>

                                                    {{-- Grand Total --}}
                                                    <td class="table-warning">{{ $total_normal + $total_special + $total_pbd }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
    </div>
    <div class="mt-3">{{ $products->links() }}</div>
</div>

@endsection
