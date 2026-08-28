@extends('layouts.bakery')

@section('title', 'Export Shop Report | Rep')

@push('styles')
<style>
    .table-wrapper {
        overflow-x: auto;
        overflow-y: auto;
        position: relative;
        -webkit-overflow-scrolling: touch;
    }
    table {
        border-collapse: collapse;
        min-width: 100%;
        width: max-content;
    }
    th, td {
        border: 1px solid var(--border);
        padding: 12px 20px;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
        text-transform: capitalize;
    }
    thead th {
        background: var(--surface);
        position: sticky;
        top: 0;
        z-index: 5;
    }
    th:nth-child(1), td:nth-child(1),
    th:nth-child(2), td:nth-child(2),
    th:nth-child(3), td:nth-child(3) {
        position: sticky;
        z-index: 4;
    }
    th:nth-child(1), td:nth-child(1) { left: 0; min-width: 60px; width: 60px; }
    th:nth-child(2), td:nth-child(2) { left: 60px; min-width: 120px; }
    th:nth-child(3), td:nth-child(3) { left: 180px; min-width: 280px; }
    tbody td:nth-child(1),
    tbody td:nth-child(2),
    tbody td:nth-child(3) {
        background-color: var(--surface-2);
    }
    tfoot td { background-color: inherit !important; }
    #ordersTable { color: var(--text); --bs-table-bg: transparent; }
    #ordersTable th, #ordersTable td { color: var(--text); }
    #ordersTable .table-info { background: rgba(91,127,166,.22) !important; color: var(--text); }
    #ordersTable .table-warning { background: rgba(201,138,59,.32) !important; color: var(--text); }
    #ordersTable .table-secondary { background: var(--surface-2) !important; color: var(--text); }
    #ordersTable .table-success { background: rgba(76,124,107,.3) !important; color: var(--text); }
    #ordersTable .bg-light { background: var(--surface-2) !important; color: var(--text); }
</style>
@endpush

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
    <div>
        <h1 class="display-font page-title mb-1">Export Shop Report</h1>
        <div class="page-sub">Rep / Export Shop Report</div>
    </div>
</div>

@include('components.bakery.alerts')

<div class="panel">
    <div class="panel-head">
        <div>
            <h2>Export Shop Report</h2>
            <div class="sub">Filter, review and export to Excel</div>
        </div>
    </div>

    <form class="row border p-2 m-2" method="GET" action="/rep/export-report">
        @csrf
        <div class="col-12 col-lg-4 mb-3">
            <label for="startDate" class="form-label">Start Date </label><small class="float-end text-danger">Default Today</small>
            <input type="date" class="form-control" id="startDate" name="start_date" value="{{ $fromDate }}">
        </div>
        <div class="col-12 col-lg-4 mb-3">
            <label for="endDate" class="form-label">End Date</label><small class="float-end text-danger">Default Today</small>
            <input type="date" class="form-control" id="endDate" name="end_date" value="{{ $toDate }}">
        </div>
        <div class="col-12 col-lg-4 mb-3">
            <label for="routeSelect" class="form-label">Route</label><small class="float-end text-danger">Default Route 1</small>
            <select id="routeSelect" name="route" class="form-control">
                @foreach ($routes as $routeItem)
                <option value="{{ $routeItem->name }}" @selected($route==$routeItem->name)>{{ $routeItem->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-lg-4 mb-3">
            <label for="categorySelect" class="form-label">Categories</label><small class="float-end text-danger">Default none</small>
            <select name="categories[]" class="form-control" id="categorySelect" multiple size="5" onchange="getCategories();">
                @foreach ($categories as $category)
                <option value="{{ $category->category }}" @if(in_array($category->category, $selectedCategories ?? [])) selected @endif>{{ $category->category }}</option>
                @endforeach
            </select>
            <div class="mt-1"><small><strong>Tip:</strong> Hold Ctrl (Cmd) to select multiple</small></div>
            <div id="selectedDisplay" class="selected-display mt-2"><em>No categories selected</em></div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="row">
                <div class="col-12">
                    <label for="time_period">Time period</label><small class="float-end text-danger">Default Morning</small>
                    <select id="time_period" name="time_period" class="form-control">
                        <option value="Morning" @selected($timePeriod=='Morning')>Morning</option>
                        <option value="Evening" @selected($timePeriod=='Evening')>Evening</option>
                    </select>
                </div>
                <div class="col-12 pt-2">
                    <label for="state">State</label><small class="float-end text-danger">Default Pending</small>
                    <select id="state" name="state" class="form-control">
                        <option value="Pending" @selected($state=='Pending')>Pending</option>
                        <option value="Processing" @selected($state=='Processing')>Processing</option>
                        <option value="Complete" @selected($state=='Complete')>Complete</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4 mb-3 d-flex align-items-end">
            <button class="btn btn-accent w-100" type="submit">Search</button>
        </div>
    </form>

    <div class="row border p-2 m-2">
        <div class="col-12 col-lg-6">
            <button class="btn btn-soft" onclick="exportToExcel()"><i class="bi bi-file-earmark-arrow-down me-1"></i> Export to Excel</button>
        </div>
        <div class="col-12 col-lg-6">
            <div class="row">
                <div class="col-6 d-flex justify-content-end align-items-center">
                    <label class="form-label mb-0">Remark</label>
                </div>
                <div class="col-6">
                    <label class="switch mb-0">
                        <input type="checkbox" name="access" onchange="rmkManege();" checked>
                        <span class="slider"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 mb-3">
        <h4 class="text-center">{{ $route }} &nbsp;&nbsp;&nbsp; {{ $fromDate }} 00:00 - {{ $toDate }} 23:59</h4>
        <p class="text-center text-muted mb-0">
            Time Period: <strong>{{ ucfirst($timePeriod) }}</strong> | Status: <strong>{{ ucfirst($state) }}</strong>
            @if(!empty($selectedCategories))
                | Categories: <strong>{{ implode(', ', $selectedCategories) }}</strong>
            @endif
        </p>
    </div>

    <div class="table-wrapper">
        @php
            $reportDate = \Carbon\Carbon::now()->format('Y-m-d');
            $columnTotals = [];
            $grandTotal = 0;
        @endphp
        <table class="table table-bordered border-dark m-2" id="ordersTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th style="min-width: 100px;">Item Code</th>
                    <th style="min-width: 280px;">Item</th>
                    @foreach ($shops as $shop)
                    <th colspan="2" class="text-center">
                        <strong>{{ $shop->shop_name }}</strong><br>
                        <small>{{ $shop->branch_code }}</small>
                    </th>
                    @endforeach
                    <th class="table-warning text-center">Total</th>
                </tr>
                <tr class="table-secondary">
                    <th></th>
                    <th></th>
                    <th></th>
                    @foreach ($shops as $shop)
                    <th class="text-center" id="qty">Qty</th>
                    <th class="text-center" id="rmk">Remark</th>
                    @endforeach
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                @php $rowTotal = 0; @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><strong>{{ $product->item_number }}</strong></td>
                    <td>{{ $product->name_sinhala }}</td>
                    @foreach ($shops as $shop)
                    @php
                        $code = trim($shop->branch_code);
                        $qty = $aggregatedOrders[$code][$product->item_number]['qty'] ?? 0;
                        $remark = $aggregatedOrders[$code][$product->item_number]['remark'] ?? '';
                        $rowTotal += $qty;
                        $columnTotals[$code] = ($columnTotals[$code] ?? 0) + $qty;
                    @endphp
                    <td class="text-center" id="qty">{{ $qty }}</td>
                    <td id="rmk">{{ $remark }}</td>
                    @endforeach
                    @php $grandTotal += $rowTotal; @endphp
                    <td class="table-warning text-center fw-bold">{{ $rowTotal }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="table-success fw-bold">
                <tr>
                    <td></td>
                    <td></td>
                    <td class="text-end">Grand Total</td>
                    @foreach ($shops as $shop)
                    @php $code = trim($shop->branch_code); @endphp
                    <td class="text-center" colspan="2" id="qty">{{ $columnTotals[$code] ?? 0 }}</td>
                    <td id="rmk"></td>
                    @endforeach
                    <td class="table-warning text-center">{{ $grandTotal }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    function getCategories() {
        const selectBox = document.getElementById('categorySelect');
        const selectedValues = Array.from(selectBox.selectedOptions).map(option => option.value);
        const displayElement = document.getElementById('selectedDisplay');
        if (selectedValues.length === 0) {
            displayElement.innerHTML = '<em>No categories selected</em>';
        } else if (selectedValues.length === 1) {
            displayElement.textContent = `Selected: ${selectedValues[0]}`;
        } else {
            displayElement.textContent = `Selected: ${selectedValues.join(', ')} (${selectedValues.length} categories)`;
        }
    }
    function rmkManege() {
        const checkBox = document.querySelector('input[name="access"]');
        const rmkCells = document.querySelectorAll('#rmk');
        const qtyCells = document.querySelectorAll('#qty');
        if (checkBox.checked) {
            rmkCells.forEach(cell => cell.style.display = '');
            qtyCells.forEach(cell => cell.colSpan = 1);
        } else {
            rmkCells.forEach(cell => cell.style.display = 'none');
            qtyCells.forEach(cell => cell.colSpan = 2);
        }
    }
    function exportToExcel() {
        var table = document.getElementById('ordersTable');
        var clonedTable = table.cloneNode(true);
        var checkBox = document.querySelector('input[name="access"]');
        var rmks = clonedTable.querySelectorAll('#rmk');
        var qtys = clonedTable.querySelectorAll('#qty');
        if (checkBox.checked) {
            qtys.forEach(function(q) { q.colSpan = 1; });
        } else {
            rmks.forEach(function(header) { header.parentNode.removeChild(header); });
            qtys.forEach(function(q) { q.colSpan = 2; });
        }
        var wb = XLSX.utils.table_to_book(clonedTable, { sheet: "Sheet1" });
        XLSX.writeFile(wb, 'Rep_Export_Report_{{ $fromDate }}_{{ $toDate }}.xlsx');
    }
    getCategories();
</script>
@endpush
