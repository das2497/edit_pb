@extends('layouts.bakery')

@section('title', 'Rep | My Shops')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
    <div>
        <h1 class="display-font page-title mb-1">My Shops</h1>
        <div class="page-sub">Your assigned shops — today: {{ $date }} | green = fully ordered, amber = partially</div>
    </div>
</div>

@include('components.bakery.alerts')

<div class="panel">
    <div class="panel-head">
        <div>
            <h2>My Shops</h2>
            <div class="sub">{{ count($shops) }} shop(s) assigned</div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="legend-dot" style="background:rgba(76,124,107,.6);"></span><small class="text-muted">Done</small>
            <span class="legend-dot" style="background:rgba(201,138,59,.7);"></span><small class="text-muted">Partial</small>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bakery align-middle" id="myShopsTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Branch Code</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Morning Route</th>
                    <th>Evening Route</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($shops as $shop)
                @php
                $orders = DB::table('orders')
                    ->where('shop', '=', $shop->branch_code)
                    ->where('status', '!=', 'Cancelled')
                    ->where('status', '!=', 'Default')
                    ->whereDate('created_at', '=', $date)
                    ->count();
                $rowClass = '';
                if ($shop->order_time == 'Both' && $orders == 2) $rowClass = 'row-good';
                elseif ($shop->order_time == 'Both' && $orders == 1) $rowClass = 'row-warn';
                elseif (($shop->order_time == 'Morning' || $shop->order_time == 'Evening') && $orders == 1) $rowClass = 'row-good';
                @endphp
                <tr class="{{ $rowClass }}">
                    <td>{{ $loop->iteration }}</td>
                    <td class="mono">{{ $shop->branch_code }}</td>
                    <td>{{ $shop->name }}</td>
                    <td class="mono" style="font-size:.82rem;">{{ $shop->contact }}</td>
                    <td class="mono" style="font-size:.82rem;">{{ $shop->email }}</td>
                    <td>{{ $shop->morning_route }}</td>
                    <td>{{ $shop->evening_route }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Simple client search (like old id ordering_admin_all_items_srch)
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.createElement('input');
        input.type = 'text';
        input.placeholder = 'Search shops…';
        input.className = 'form-control form-control-sm mb-3';
        input.style.maxWidth = '280px';
        const panel = document.querySelector('.panel');
        if (panel) panel.insertBefore(input, panel.querySelector('.table-responsive'));
        input.addEventListener('keyup', function () {
            const term = this.value.toLowerCase();
            document.querySelectorAll('#myShopsTable tbody tr').forEach(tr => {
                tr.style.display = tr.textContent.toLowerCase().includes(term) ? '' : 'none';
            });
        });
    });
</script>
@endpush
