@extends('layouts.bakery')

@section('title', 'Order Admin | Dashboard')

@section('content')

    {{-- Page header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-end mb-4 gap-2">
        <div>
            <h1 class="display-font page-title mb-1">{{ Auth::user()->name }} Dashboard 🥐</h1>
            <div class="page-sub">Here's what's rising in the bakery today — {{ now()->format('l, d F Y') }}</div>
        </div>
        @if (Auth::user()->role === 'o_admin')
            <button class="btn btn-accent btn-sm" onclick="loadDashboardData();" id="refreshDashBtn">
                <span id="rfs"><i class="bi bi-arrow-clockwise me-1"></i> Refresh dashboard</span>
                <span id="spn" style="display:none;"><span class="spinner-border spinner-border-sm me-1"></span> Loading…</span>
            </button>
        @endif
    </div>

    {{-- Alerts --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Admin quick actions --}}
    @if (Auth::user()->role === 'o_admin')
        <div class="panel mb-4">
            <div class="panel-head mb-2">
                <div>
                    <h2>Quick actions</h2>
                    <div class="sub">Google Sheet summaries & transfers</div>
                </div>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('morning-summary') }}" class="btn btn-soft btn-sm refresh-link">
                    <i class="bi bi-sunrise me-1"></i> Morning Summary
                </a>
                <a href="{{ route('evening-summary') }}" class="btn btn-soft btn-sm refresh-link">
                    <i class="bi bi-sunset me-1"></i> Evening Summary
                </a>
                <a href="{{ route('morning-shop-report') }}" class="btn btn-soft btn-sm refresh-link">
                    <i class="bi bi-clipboard-data me-1"></i> Morning Shop Report
                </a>
                <a href="{{ route('evening-shop-report') }}" class="btn btn-soft btn-sm refresh-link">
                    <i class="bi bi-clipboard-data-fill me-1"></i> Evening Shop Report
                </a>
                @if (Auth::user()->email === config('app.processing_transfer_email', 'adminkusaldilshan@gmail.com'))
                    <a href="/processing-transfer" class="btn btn-accent btn-sm refresh-link">
                        <i class="bi bi-arrow-right-circle me-1"></i> Processing to Completed
                    </a>
                @endif
            </div>
        </div>
    @endif

    {{-- KPI row : order counts --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="kpi-card">
                <div class="kpi-top">
                    <div class="kpi-icon bg-tint-caramel"><i class="bi bi-hourglass-split"></i></div>
                </div>
                <div class="kpi-label">Pending Orders</div>
                <div class="kpi-value" id="pending_orders_count">—</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="kpi-card">
                <div class="kpi-top">
                    <div class="kpi-icon bg-tint-blueberry"><i class="bi bi-arrow-repeat"></i></div>
                </div>
                <div class="kpi-label">Processing Orders</div>
                <div class="kpi-value" id="processing_orders_count">—</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="kpi-card">
                <div class="kpi-top">
                    <div class="kpi-icon bg-tint-mint"><i class="bi bi-check2-circle"></i></div>
                </div>
                <div class="kpi-label">Completed Orders</div>
                <div class="kpi-value" id="complete_orders_count">—</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="kpi-card">
                <div class="kpi-top">
                    <div class="kpi-icon bg-tint-accent"><i class="bi bi-search"></i></div>
                </div>
                <div class="kpi-label">Under Review</div>
                <div class="kpi-value" id="under_review_orders_count">—</div>
            </div>
        </div>
    </div>

    {{-- Revenue row --}}
    @if (Auth::user()->role != 'view')
        <div class="row g-3 mb-4">
            <div class="col-12 col-lg-4">
                <div class="kpi-card">
                    <div class="kpi-top">
                        <div class="kpi-icon bg-tint-mint"><i class="bi bi-cash-coin"></i></div>
                    </div>
                    <div class="kpi-label">Today Total Revenue</div>
                    <div class="kpi-value" id="today_total_revenue" style="font-size:1.5rem;">—</div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="kpi-card">
                    <div class="kpi-top">
                        <div class="kpi-icon bg-tint-caramel"><i class="bi bi-calendar-week"></i></div>
                    </div>
                    <div class="kpi-label">This Week Revenue <small class="mono" id="weeks_gap"></small></div>
                    <div class="kpi-value" id="last7Days_total_revenue" style="font-size:1.5rem;">—</div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="kpi-card">
                    <div class="kpi-top">
                        <div class="kpi-icon bg-tint-blueberry"><i class="bi bi-calendar-month"></i></div>
                    </div>
                    <div class="kpi-label">This Month Revenue <small class="mono" id="month_gap"></small></div>
                    <div class="kpi-value" id="lastMonth_total_revenue" style="font-size:1.5rem;">—</div>
                </div>
            </div>
        </div>
    @endif

    {{-- Revenue charts --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-6">
            <div class="panel h-100">
                <div class="panel-head">
                    <div>
                        <h2>Last 12 Months Revenue</h2>
                        <div class="sub">Monthly totals (Rs.)</div>
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
                        <div class="sub">Daily totals (Rs.)</div>
                    </div>
                </div>
                <canvas id="past30DaysRevenueChart"></canvas>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="panel h-100">
                <div class="panel-head">
                    <div>
                        <h2>Top 10 Best Selling Shops</h2>
                        <div class="sub">By total sales</div>
                    </div>
                </div>
                <canvas id="topSellingShopsChart"></canvas>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="panel h-100">
                <div class="panel-head">
                    <div>
                        <h2>Top 10 Best Selling Items</h2>
                        <div class="sub">By quantity sold</div>
                    </div>
                </div>
                <canvas id="topSellingItemsChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Rep performance --}}
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="panel">
                <div class="panel-head">
                    <div>
                        <h2>Top Best Selling Reps — All Time</h2>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-12 col-md-6"><canvas id="topSellingRepsAllTimeChart"></canvas></div>
                    <div class="col-12 col-md-6">
                        <div class="table-responsive">
                            <table class="table table-bakery">
                                <thead>
                                    <tr>
                                        <th>Rep Name</th>
                                        <th>Total Sales</th>
                                    </tr>
                                </thead>
                                <tbody id="topRepsTableBody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="panel">
                <div class="panel-head">
                    <div>
                        <h2>Top Best Selling Reps — Today</h2>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-12 col-md-6"><canvas id="topSellingRepsTodayChart"></canvas></div>
                    <div class="col-12 col-md-6">
                        <div class="table-responsive">
                            <table class="table table-bakery">
                                <thead>
                                    <tr>
                                        <th>Rep Name</th>
                                        <th>Total Sales</th>
                                    </tr>
                                </thead>
                                <tbody id="top_selling_reps_today"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="panel">
                <div class="panel-head">
                    <div>
                        <h2>Top Best Selling Reps — Last 30 Days</h2>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-12 col-md-6"><canvas id="topSellingRepsLast30DaysChart"></canvas></div>
                    <div class="col-12 col-md-6">
                        <div class="table-responsive">
                            <table class="table table-bakery">
                                <thead>
                                    <tr>
                                        <th>Rep Name</th>
                                        <th>Total Sales</th>
                                    </tr>
                                </thead>
                                <tbody id="top_selling_reps_last_30_days"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Orders tables --}}
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
                                <th>Outlet</th>
                                <th>Delivery</th>
                                <th>Created</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody id="latestOrdersBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-6">
            <div class="panel h-100">
                <div class="panel-head">
                    <div>
                        <h2>Top 10 Orders</h2>
                        <div class="sub">Highest value orders</div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bakery">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order Id</th>
                                <th>Outlet</th>
                                <th>Delivery</th>
                                <th>Created</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody id="top10OrdersBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        // Null-safe element getter: returns the element, or a detached dummy
        // so JS never crashes when an element is not rendered for some roles.
        function el(id) {
            return document.getElementById(id) || document.createElement('div');
        }

        function money(v) {
            return 'රු. ' + parseFloat(v).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        function barOptions(c, yLabel, xLabel) {
            return {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: c.text, font: { family: 'Inter' } },
                        title: xLabel ? { display: true, text: xLabel, color: c.text } : undefined
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: c.grid },
                        ticks: {
                            color: c.text,
                            font: { family: 'Inter' },
                            callback: function (value) {
                                return 'Rs ' + value.toLocaleString(undefined, { maximumFractionDigits: 2 });
                            }
                        },
                        title: yLabel ? { display: true, text: yLabel, color: c.text } : undefined
                    }
                }
            };
        }

        const pieColors = ['#B23A48', '#C98A3B', '#4C7C6B', '#5B7FA6', '#8A5A83',
                           '#D97B4F', '#6FAF9B', '#84AAD6', '#C9AF95', '#E0576A'];

        function initialLoad() {
            axios.get('{{ route('order-admin.first-load-data') }}')
                .then(res => {
                    const d = res.data;
                    el('pending_orders_count').innerHTML = d.stats.pending_orders_count;
                    el('processing_orders_count').innerHTML = d.stats.processing_orders_count;
                    el('complete_orders_count').innerHTML = d.stats.complete_orders_count;
                    el('under_review_orders_count').innerHTML = d.stats.under_review_orders_count;

                    el('today_total_revenue').innerHTML = money(d.stats.today_total_revenue);
                    el('weeks_gap').innerHTML = `(${d.stats.startOfThisWeek} — ${d.stats.endOfThisWeek})`;
                    el('last7Days_total_revenue').innerHTML = money(d.stats.last7Days_total_revenue);
                    el('month_gap').innerHTML = `(${d.stats.startOfThisMonth} — ${d.stats.endOfThisMonth})`;
                    el('lastMonth_total_revenue').innerHTML = money(d.stats.lastMonth_total_revenue);
                })
                .catch(err => {
                    console.error('Error fetching initial data:', err);
                });
        }

        function loadDashboardData() {
            el('rfs').style.display = 'none';
            el('spn').style.display = 'inline';
            axios.get('{{ route('api.order-admin.dashboard-data') }}')
                .then(res => {
                    const d = res.data.stats;
                    const c = window.pbChartColors();

                    // ── Stats ──
                    el('pending_orders_count').innerHTML = d.pending_orders_count;
                    el('processing_orders_count').innerHTML = d.processing_orders_count;
                    el('complete_orders_count').innerHTML = d.complete_orders_count;
                    el('under_review_orders_count').innerHTML = d.under_review_orders_count;

                    el('today_total_revenue').innerHTML = money(d.today_total_revenue);
                    el('weeks_gap').innerHTML = `(${d.startOfThisWeek} — ${d.endOfThisWeek})`;
                    el('last7Days_total_revenue').innerHTML = money(d.last7Days_total_revenue);
                    el('month_gap').innerHTML = `(${d.startOfThisMonth} — ${d.endOfThisMonth})`;
                    el('lastMonth_total_revenue').innerHTML = money(d.lastMonth_total_revenue);

                    // ── Last 12 months revenue (bar) ──
                    const months = d.last12montsrevenue.map(item => {
                        const date = new Date(item.month + '-01');
                        return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
                    });
                    const amounts = d.last12montsrevenue.map(item => parseFloat(item.amount));

                    if (window.myBarChart instanceof Chart) window.myBarChart.destroy();
                    window.myBarChart = new Chart(el('barChart').getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: months,
                            datasets: [{
                                label: 'Orders Amount (Rs)',
                                data: amounts,
                                backgroundColor: c.accent,
                                borderRadius: 6,
                                maxBarThickness: 34
                            }]
                        },
                        options: barOptions(c)
                    });

                    // ── Last 30 days revenue (bar) ──
                    const { labels: revenueLabels, data: revenueData } = d.revenueData;
                    if (window.rev30Chart instanceof Chart) window.rev30Chart.destroy();
                    window.rev30Chart = new Chart(el('past30DaysRevenueChart').getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: revenueLabels,
                            datasets: [{
                                label: 'Revenue (Rs)',
                                data: revenueData,
                                backgroundColor: c.caramel,
                                borderRadius: 6,
                                maxBarThickness: 20
                            }]
                        },
                        options: barOptions(c, 'Revenue (Rs)', 'Date')
                    });

                    // ── Top 10 shops (pie) ──
                    const { topSellingShops_labels, topSellingShops_data } = d.topSellingShops;
                    if (window.topShopsChart instanceof Chart) window.topShopsChart.destroy();
                    window.topShopsChart = new Chart(el('topSellingShopsChart').getContext('2d'), {
                        type: 'pie',
                        data: {
                            labels: topSellingShops_labels,
                            datasets: [{
                                label: 'Total Sales',
                                data: topSellingShops_data,
                                backgroundColor: pieColors,
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { position: 'top', labels: { color: c.text, font: { family: 'Inter' } } }
                            }
                        }
                    });

                    // ── Top 10 items (pie) ──
                    const { topItems_labels, topItems_data } = d.topSellingItems || {};
                    if (window.topItemsChart instanceof Chart) window.topItemsChart.destroy();
                    window.topItemsChart = new Chart(el('topSellingItemsChart').getContext('2d'), {
                        type: 'pie',
                        data: {
                            labels: topItems_labels,
                            datasets: [{
                                label: 'Total Quantity Sold',
                                data: topItems_data,
                                backgroundColor: pieColors,
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { position: 'top', labels: { color: c.text, font: { family: 'Inter' } } },
                                tooltip: {
                                    callbacks: {
                                        label: function (context) {
                                            return `${context.label || ''}: ${context.raw || 0} units`;
                                        }
                                    }
                                }
                            }
                        }
                    });

                    // ── Reps: all time ──
                    const { labels: repLabelsAllTime, data: repDataAllTime } = d.topSellingRepsAllTime.chartData;
                    if (window.repsAllTimeChart instanceof Chart) window.repsAllTimeChart.destroy();
                    window.repsAllTimeChart = new Chart(el('topSellingRepsAllTimeChart').getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: repLabelsAllTime,
                            datasets: [{
                                label: 'Total Sales (Rs)',
                                data: repDataAllTime,
                                backgroundColor: c.mint,
                                borderRadius: 6,
                                maxBarThickness: 34
                            }]
                        },
                        options: barOptions(c, 'Total Sales (Rs)', 'Rep Name')
                    });
                    fillRepTable('topRepsTableBody', d.topSellingRepsAllTime.tableData);

                    // ── Reps: today ──
                    const { labels: repLabelsToday, data: repDataToday } = d.topSellingRepsToday.chartData;
                    if (window.repsTodayChart instanceof Chart) window.repsTodayChart.destroy();
                    window.repsTodayChart = new Chart(el('topSellingRepsTodayChart').getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: repLabelsToday,
                            datasets: [{
                                label: 'Total Sales (Rs)',
                                data: repDataToday,
                                backgroundColor: c.blueberry,
                                borderRadius: 6,
                                maxBarThickness: 34
                            }]
                        },
                        options: barOptions(c, 'Total Sales (Rs)', 'Rep Name')
                    });
                    fillRepTable('top_selling_reps_today', d.topSellingRepsToday.tableData);

                    // ── Reps: last 30 days ──
                    const { labels: repLabels30Days, data: repData30Days } = d.topSellingRepsLast30Days.chartData;
                    if (window.reps30Chart instanceof Chart) window.reps30Chart.destroy();
                    window.reps30Chart = new Chart(el('topSellingRepsLast30DaysChart').getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: repLabels30Days,
                            datasets: [{
                                label: 'Total Sales (Rs)',
                                data: repData30Days,
                                backgroundColor: c.caramel,
                                borderRadius: 6,
                                maxBarThickness: 34
                            }]
                        },
                        options: barOptions(c, 'Total Sales (Rs)', 'Rep Name')
                    });
                    fillRepTable('top_selling_reps_last_30_days', d.topSellingRepsLast30Days.tableData);

                    // ── Recent orders table ──
                    fillOrdersTable('latestOrdersBody', d.latest_orders, 'id');

                    // ── Top 10 orders table ──
                    fillOrdersTable('top10OrdersBody', d.top_orders, 'unique_id');
                })
                .catch(err => {
                    console.error('Error loading dashboard data:', err);
                    alert('Failed to load dashboard data. Please try again.');
                })
                .finally(() => {
                    el('rfs').style.display = 'inline';
                    el('spn').style.display = 'none';
                });
        }

        function fillRepTable(bodyId, rows) {
            const tbody = el(bodyId);
            tbody.innerHTML = '';
            rows.forEach(rep => {
                const tr = document.createElement('tr');
                const nameTd = document.createElement('td');
                nameTd.textContent = rep.name;
                const salesTd = document.createElement('td');
                salesTd.className = 'mono';
                salesTd.textContent = 'Rs. ' + parseFloat(rep.total_sales).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                tr.appendChild(nameTd);
                tr.appendChild(salesTd);
                tbody.appendChild(tr);
            });
        }

        function fillOrdersTable(bodyId, orders, idField) {
            const tbody = el(bodyId);
            tbody.innerHTML = '';
            orders.forEach((order, index) => {
                const tr = document.createElement('tr');

                const idxTd = document.createElement('td');
                idxTd.textContent = index + 1;

                const orderIdTd = document.createElement('td');
                orderIdTd.className = 'mono';
                orderIdTd.textContent = order[idField];

                const outletTd = document.createElement('td');
                outletTd.textContent = order.shop_name || order.name || order.shop;

                const deliveryTd = document.createElement('td');
                deliveryTd.innerHTML = order.time_period
                    ? '<span class="status-pill status-pending">' + order.time_period + '</span>'
                    : 'N/A';

                const createdTd = document.createElement('td');
                createdTd.textContent = new Date(order.order_created_at).toLocaleString();

                const amountTd = document.createElement('td');
                amountTd.className = 'mono';
                amountTd.textContent = 'Rs. ' + parseFloat(order.total_price).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });

                tr.appendChild(idxTd);
                tr.appendChild(orderIdTd);
                tr.appendChild(outletTd);
                tr.appendChild(deliveryTd);
                tr.appendChild(createdTd);
                tr.appendChild(amountTd);
                tbody.appendChild(tr);
            });
        }

        // Disable any refresh link after it is clicked
        document.querySelectorAll('.refresh-link').forEach(function (link) {
            link.addEventListener('click', function () {
                this.classList.add('disabled');
            });
        });

        initialLoad();
    </script>
@endpush
