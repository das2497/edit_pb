@extends('layouts.bakery')

@section('title', 'Shop | Dashboard')

@section('content')

    <div class="d-flex flex-wrap justify-content-between align-items-end mb-4 gap-2">
        <div>
            <h1 class="display-font page-title mb-1">{{ Auth::user()->name }} Dashboard 🥐</h1>
            <div class="page-sub">Shop overview — {{ now()->format('l, d F Y') }}</div>
        </div>
    </div>

    @include('components.bakery.alerts')

    {{-- KPI counts --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="kpi-card">
                <div class="kpi-top">
                    <div class="kpi-icon bg-tint-caramel"><i class="bi bi-hourglass-split"></i></div>
                    <span class="status-pill status-pending">Pending</span>
                </div>
                <div class="kpi-label">Pending Orders</div>
                <div class="kpi-value">{{ $pending_orders_count }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="kpi-card">
                <div class="kpi-top">
                    <div class="kpi-icon bg-tint-blueberry"><i class="bi bi-arrow-repeat"></i></div>
                    <span class="status-pill status-baking">Processing</span>
                </div>
                <div class="kpi-label">Processing Orders</div>
                <div class="kpi-value">{{ $processing_orders_count }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="kpi-card">
                <div class="kpi-top">
                    <div class="kpi-icon bg-tint-mint"><i class="bi bi-check2-circle"></i></div>
                    <span class="status-pill status-ready">Complete</span>
                </div>
                <div class="kpi-label">Completed Orders</div>
                <div class="kpi-value">{{ $complete_orders_count }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="kpi-card">
                <div class="kpi-top">
                    <div class="kpi-icon bg-tint-accent"><i class="bi bi-search"></i></div>
                    <span class="status-pill status-late">Review</span>
                </div>
                <div class="kpi-label">Under Review Orders</div>
                <div class="kpi-value">{{ $under_review_orders_count }}</div>
            </div>
        </div>
    </div>

    {{-- Revenue --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="kpi-card">
                <div class="kpi-top"><div class="kpi-icon bg-tint-mint"><i class="bi bi-currency-rupee"></i></div></div>
                <div class="kpi-label">Today Estimated Revenue</div>
                <div class="kpi-value mono" style="font-size:1.55rem;">රු. {{ number_format($today_total_revenue, 2) }}</div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="kpi-card">
                <div class="kpi-top"><div class="kpi-icon bg-tint-caramel"><i class="bi bi-calendar-week"></i></div></div>
                <div class="kpi-label">This Week Revenue
                    <small class="d-block text-muted" style="text-transform:none; letter-spacing:0; font-size:.72rem;">{{ \Carbon\Carbon::parse($startOfThisWeek)->format('Y-m-d') }} to {{ \Carbon\Carbon::parse($endOfThisWeek)->format('Y-m-d') }}</small>
                </div>
                <div class="kpi-value mono" style="font-size:1.55rem;">රු. {{ number_format($thisWeek_total_revenue, 2) }}</div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="kpi-card">
                <div class="kpi-top"><div class="kpi-icon bg-tint-blueberry"><i class="bi bi-calendar-month"></i></div></div>
                <div class="kpi-label">This Month Revenue
                    <small class="d-block text-muted" style="text-transform:none; letter-spacing:0; font-size:.72rem;">{{ \Carbon\Carbon::parse($startOfThisMonth)->format('Y-m-d') }} to {{ \Carbon\Carbon::parse($endOfThisMonth)->format('Y-m-d') }}</small>
                </div>
                <div class="kpi-value mono" style="font-size:1.55rem;">රු. {{ number_format($lastMonth_total_revenue, 2) }}</div>
            </div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-6">
            <div class="panel h-100">
                <div class="panel-head">
                    <div><h2>Last 12 Months Revenue</h2><div class="sub">Monthly totals</div></div>
                </div>
                <canvas id="barChart"></canvas>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="panel h-100">
                <div class="panel-head">
                    <div><h2>Last 30 Days Revenue</h2><div class="sub">Daily totals</div></div>
                </div>
                <canvas id="past30DaysRevenueChart"></canvas>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="panel h-100">
                <div class="panel-head">
                    <div><h2>Best Selling Categories</h2><div class="sub">By quantity</div></div>
                </div>
                <canvas id="bestSellingProductCategories"></canvas>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="panel h-100">
                <div class="panel-head">
                    <div><h2>Best Selling Products</h2><div class="sub">Top 10 by quantity</div></div>
                </div>
                <canvas id="bestSellingProducts"></canvas>
            </div>
        </div>
    </div>

    {{-- Orders tables --}}
    <div class="row g-3">
        <div class="col-12 col-xl-6">
            <div class="panel h-100">
                <div class="panel-head"><div><h2>Recent Orders</h2><div class="sub">Latest 10</div></div></div>
                <div class="table-responsive">
                    <table class="table table-bakery">
                        <thead><tr><th>#</th><th>Order Id</th><th>Delivery</th><th>Created</th><th class="text-end">Amount</th></tr></thead>
                        <tbody>
                            @forelse ($latest_orders as $o)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="mono">{{ $o->unique_id }}</td>
                                    <td><span class="status-pill status-pending">{{ $o->time_period }}</span></td>
                                    <td class="mono" style="font-size:.8rem;">{{ $o->order_date }}</td>
                                    <td class="mono text-end">රු. {{ number_format($o->total_price, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted">No orders</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-6">
            <div class="panel h-100">
                <div class="panel-head"><div><h2>Top Orders (30 days)</h2><div class="sub">Highest value</div></div></div>
                <div class="table-responsive">
                    <table class="table table-bakery">
                        <thead><tr><th>#</th><th>Order Id</th><th>Delivery</th><th>Created</th><th class="text-end">Amount</th></tr></thead>
                        <tbody>
                            @forelse ($top_orders as $o)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="mono">{{ $o->unique_id }}</td>
                                    <td><span class="status-pill status-baking">{{ $o->time_period }}</span></td>
                                    <td class="mono" style="font-size:.8rem;">{{ $o->order_date }}</td>
                                    <td class="mono text-end">රු. {{ number_format($o->total_price, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted">No orders</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const c = window.pbChartColors ? window.pbChartColors() : { accent: '#B23A48', caramel: '#C98A3B', mint: '#4C7C6B', blueberry: '#5B7FA6', grid: '#E7D9C2', text: '#8A7660' };
            const pieColors = ['#B23A48', '#C98A3B', '#4C7C6B', '#5B7FA6', '#8A5A83', '#D97B4F', '#6FAF9B', '#84AAD6', '#C9AF95', '#E0576A'];

            function barOpts() {
                return {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, ticks: { color: c.text, font: { family: 'Inter' } } },
                        y: { beginAtZero: true, grid: { color: c.grid }, ticks: { color: c.text, font: { family: 'Inter' }, callback: v => 'Rs ' + Number(v).toLocaleString() } }
                    }
                };
            }

            // 12 months - shop uses year/month fields
            try {
                const raw12 = @json($last12montsrevenue);
                const labels12 = raw12.map(r => {
                    const m = String(r.month).padStart(2,'0');
                    return `${r.year}-${m}`;
                });
                const data12 = raw12.map(r => parseFloat(r.amount));
                const ctx = document.getElementById('barChart');
                if (ctx) new Chart(ctx.getContext('2d'), {
                    type: 'bar',
                    data: { labels: labels12, datasets: [{ label: 'Revenue', data: data12, backgroundColor: c.accent, borderRadius: 6, maxBarThickness: 34 }] },
                    options: barOpts()
                });
            } catch (e) { console.error('12m', e); }

            // 30 days
            try {
                const raw30 = @json($last30DaysRevenue);
                const labels30 = raw30.map(r => r.date);
                const data30 = raw30.map(r => parseFloat(r.amount));
                const ctx2 = document.getElementById('past30DaysRevenueChart');
                if (ctx2) new Chart(ctx2.getContext('2d'), {
                    type: 'bar',
                    data: { labels: labels30, datasets: [{ label: 'Revenue', data: data30, backgroundColor: c.caramel, borderRadius: 6, maxBarThickness: 20 }] },
                    options: barOpts()
                });
            } catch (e) { console.error('30d', e); }

            // Best selling categories - pie
            try {
                const cats = @json($bestSellingCategories);
                const catLabels = cats.map(c => c.category);
                const catData = cats.map(c => parseFloat(c.total_quantity_sold));
                const ctxC = document.getElementById('bestSellingProductCategories');
                if (ctxC) new Chart(ctxC.getContext('2d'), {
                    type: 'pie',
                    data: { labels: catLabels, datasets: [{ data: catData, backgroundColor: pieColors }] },
                    options: { responsive: true, plugins: { legend: { position: 'top', labels: { color: c.text, font: { family: 'Inter' } } } } }
                });
            } catch (e) { console.error('cats', e); }

            // Best selling products - bar
            try {
                const prods = @json($topSellingProducts);
                const prodLabels = prods.map(p => p.name_english || p.item_number);
                const prodData = prods.map(p => parseFloat(p.total_quantity_sold));
                const ctxP = document.getElementById('bestSellingProducts');
                if (ctxP) new Chart(ctxP.getContext('2d'), {
                    type: 'bar',
                    data: { labels: prodLabels, datasets: [{ label: 'Qty Sold', data: prodData, backgroundColor: c.mint, borderRadius: 6 }] },
                    options: {
                        responsive: true,
                        indexAxis: 'y',
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { beginAtZero: true, grid: { color: c.grid }, ticks: { color: c.text } },
                            y: { grid: { display: false }, ticks: { color: c.text, font: { family: 'Inter', size: 11 } } }
                        }
                    }
                });
            } catch (e) { console.error('prods', e); }
        });
    </script>
@endpush
