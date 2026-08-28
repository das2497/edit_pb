@extends('layouts.bakery')

@section('title', 'Rep | Dashboard')

@section('content')

    {{-- Page header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-end mb-4 gap-2">
        <div>
            <h1 class="display-font page-title mb-1">{{ Auth::user()->name }} Dashboard 🥐</h1>
            <div class="page-sub">Rep overview — {{ now()->format('l, d F Y') }}</div>
        </div>
    </div>

    @include('components.bakery.alerts')

    {{-- KPI row : order counts --}}
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

    {{-- Revenue KPIs --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="kpi-card">
                <div class="kpi-top">
                    <div class="kpi-icon bg-tint-mint"><i class="bi bi-currency-rupee"></i></div>
                </div>
                <div class="kpi-label">Today Estimated Revenue</div>
                <div class="kpi-value mono" style="font-size:1.55rem;">රු. {{ number_format($today_total_revenue, 2) }}</div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="kpi-card">
                <div class="kpi-top">
                    <div class="kpi-icon bg-tint-caramel"><i class="bi bi-calendar-week"></i></div>
                </div>
                <div class="kpi-label">This Week Estimated Revenue
                    <small class="d-block text-muted" style="text-transform:none; letter-spacing:0; font-size:.72rem;">{{ \Carbon\Carbon::parse($startOfThisWeek)->format('Y-m-d') }} to {{ \Carbon\Carbon::parse($endOfThisWeek)->format('Y-m-d') }}</small>
                </div>
                <div class="kpi-value mono" style="font-size:1.55rem;">රු. {{ number_format($thisWeek_total_revenue, 2) }}</div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="kpi-card">
                <div class="kpi-top">
                    <div class="kpi-icon bg-tint-blueberry"><i class="bi bi-calendar-month"></i></div>
                </div>
                <div class="kpi-label">This Month Estimated Revenue
                    <small class="d-block text-muted" style="text-transform:none; letter-spacing:0; font-size:.72rem;">{{ \Carbon\Carbon::parse($startOfThisMonth)->format('Y-m-d') }} to {{ \Carbon\Carbon::parse($endOfThisMonth)->format('Y-m-d') }}</small>
                </div>
                <div class="kpi-value mono" style="font-size:1.55rem;">රු. {{ number_format($lastMonth_total_revenue, 2) }}</div>
            </div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-6">
            <div class="panel h-100">
                <div class="panel-head">
                    <div>
                        <h2>Last 12 Months Revenue</h2>
                        <div class="sub">Monthly totals</div>
                    </div>
                </div>
                <canvas id="barChart"></canvas>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="panel h-100">
                <div class="panel-head">
                    <div>
                        <h2>Last 30 Days Revenue</h2>
                        <div class="sub">Daily totals</div>
                    </div>
                </div>
                <canvas id="barChart2"></canvas>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="panel h-100">
                <div class="panel-head">
                    <div>
                        <h2>My Shops Revenues</h2>
                        <div class="sub">By shop</div>
                    </div>
                </div>
                <canvas id="revenuePieChart"></canvas>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="panel h-100">
                <div class="panel-head">
                    <div>
                        <h2>Quick Links</h2>
                        <div class="sub">Go to your tasks</div>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('rep.pending-order') }}" class="btn btn-soft btn-sm"><i class="bi bi-hourglass-split me-1"></i> Pending Orders</a>
                    <a href="{{ route('rep.processing-order') }}" class="btn btn-soft btn-sm"><i class="bi bi-arrow-repeat me-1"></i> Processing</a>
                    <a href="{{ route('rep.under-review-order') }}" class="btn btn-soft btn-sm"><i class="bi bi-search me-1"></i> Under Review</a>
                    <a href="{{ route('rep.complete-order') }}" class="btn btn-soft btn-sm"><i class="bi bi-check2-circle me-1"></i> Completed</a>
                    <a href="{{ route('rep.create-order') }}" class="btn btn-accent btn-sm"><i class="bi bi-plus-square me-1"></i> Create Order</a>
                    <a href="{{ route('rep.my-shops') }}" class="btn btn-soft btn-sm"><i class="bi bi-shop me-1"></i> My Shops</a>
                </div>
                <div class="mt-3">
                    <div class="page-sub">Total shops revenue pie shows how each shop contributes to your overall sales.</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tables: Recent & Top Orders --}}
    <div class="row g-3">
        <div class="col-12 col-xl-6">
            <div class="panel h-100">
                <div class="panel-head">
                    <div>
                        <h2>Recent Orders</h2>
                        <div class="sub">Latest 10 orders</div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bakery">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order Id</th>
                                <th>Shop</th>
                                <th>Delivery</th>
                                <th>Created</th>
                                <th class="text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($latest_orders as $latest_order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="mono">{{ $latest_order->unique_id }}</td>
                                    <td>{{ $latest_order->shop_name ?? $latest_order->shop }}</td>
                                    <td><span class="status-pill status-pending">{{ $latest_order->time_period }}</span></td>
                                    <td class="mono" style="font-size:.8rem;">{{ $latest_order->order_date }}</td>
                                    <td class="mono text-end">රු. {{ number_format($latest_order->total_price, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted">No orders yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-6">
            <div class="panel h-100">
                <div class="panel-head">
                    <div>
                        <h2>Top 10 Orders</h2>
                        <div class="sub">Highest value</div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bakery">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order Id</th>
                                <th>Shop</th>
                                <th>Delivery</th>
                                <th>Created</th>
                                <th class="text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($top_orders as $top_order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="mono">{{ $top_order->unique_id }}</td>
                                    <td>{{ $top_order->shop_name ?? $top_order->shop }}</td>
                                    <td><span class="status-pill status-baking">{{ $top_order->time_period }}</span></td>
                                    <td class="mono" style="font-size:.8rem;">{{ $top_order->order_date }}</td>
                                    <td class="mono text-end">රු. {{ number_format($top_order->total_price, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted">No orders yet</td></tr>
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
        function money(v) {
            return 'රු. ' + parseFloat(v).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const c = window.pbChartColors ? window.pbChartColors() : { accent: '#B23A48', caramel: '#C98A3B', mint: '#4C7C6B', blueberry: '#5B7FA6', grid: '#E7D9C2', text: '#8A7660' };
            const pieColors = ['#B23A48', '#C98A3B', '#4C7C6B', '#5B7FA6', '#8A5A83', '#D97B4F', '#6FAF9B', '#84AAD6', '#C9AF95', '#E0576A', '#D97B4F', '#6FAF9B'];

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

            // 12 months
            try {
                const months = @json($last12monthsRevenue->pluck('month'));
                const amounts = @json($last12monthsRevenue->pluck('amount')->map(fn($v) => (float)$v));
                const ctx = document.getElementById('barChart');
                if (ctx) {
                    new Chart(ctx.getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: months,
                            datasets: [{ label: 'Revenue (Rs)', data: amounts, backgroundColor: c.accent, borderRadius: 6, maxBarThickness: 34 }]
                        },
                        options: barOpts()
                    });
                }
            } catch (e) { console.error('12m chart error', e); }

            // 30 days
            try {
                const dates = @json($last30DaysRevenue->pluck('date'));
                const amounts30 = @json($last30DaysRevenue->pluck('amount')->map(fn($v) => (float)$v));
                const ctx2 = document.getElementById('barChart2');
                if (ctx2) {
                    new Chart(ctx2.getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: dates,
                            datasets: [{ label: 'Revenue (Rs)', data: amounts30, backgroundColor: c.caramel, borderRadius: 6, maxBarThickness: 20 }]
                        },
                        options: barOpts()
                    });
                }
            } catch (e) { console.error('30d chart error', e); }

            // Pie - shop revenues
            try {
                const revenues = @json($revenues);
                const labels = revenues.map(s => s.shop);
                const data = revenues.map(s => parseFloat(s.revenue));
                const ctxP = document.getElementById('revenuePieChart');
                if (ctxP) {
                    new Chart(ctxP.getContext('2d'), {
                        type: 'pie',
                        data: {
                            labels: labels,
                            datasets: [{ label: 'Revenue', data: data, backgroundColor: pieColors, borderWidth: 1 }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { position: 'top', labels: { color: c.text, font: { family: 'Inter' } } },
                                title: { display: true, text: 'Shop Revenues', color: c.text }
                            }
                        }
                    });
                }
            } catch (e) { console.error('pie chart error', e); }

            // Theme change -> redraw could be added, but keep simple for now
            document.addEventListener('pb:theme-changed', function () {
                // Optional: location.reload() or re-render charts with new colors
            });
        });
    </script>
@endpush
