<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Admin | Dashboard</title>
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/circular-std/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome/css/fontawesome-all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/charts/chartist-bundle/chartist.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/charts/morris-bundle/morris.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/charts/c3charts/c3.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icon-css/flag-icon.min.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>

    <!-- header  -->
    @include('order-admin.components.header')
    <!-- /header  -->

    @if (Auth::user()->role === 'sales_admin')
        <!-- menu -->
        @include('order-admin.components.menu-sales-admin')
        <!-- /menu -->
    @else
        <!-- menu -->
        @include('order-admin.components.menu')
        <!-- /menu -->
    @endif

    <!-- content -->
    <div class="dashboard-wrapper">
        <div class="dashboard-ecommerce">
            <div class="container-fluid dashboard-content ">
                <!-- ============================================================== -->
                <!-- pageheader  -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title"> {{Auth::user()->name}} Dashboard </h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a>
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end pageheader  -->
                <!-- ============================================================== -->
                <div class="ecommerce-widget">

                    @if (Auth::user()->role === 'o_admin' && Auth::user()->email === config('app.processing_transfer_email', 'adminkusaldilshan@gmail.com'))
                        <div class="row mb-2 g-2">
                            <div class="col-12 col-lg-3 d-grid">
                                <a href="/processing-transfer" class="btn btn-danger mb-2 w-100 refresh-link">Processing to
                                    Completed</a> <!-- Added w-100 -->
                            </div>
                        </div>
                    @endif

                    @if (Auth::user()->role === 'o_admin')
                        <div class="row mb-2 g-2">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        @if (session('success'))
                                            <div class="alert alert-success">
                                                {{ session('success') }}
                                            </div>
                                        @endif
                                        @if (session('error'))
                                            <div class="alert alert-danger">
                                                {{ session('error') }}
                                            </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-12 col-lg-3 d-grid">
                                                <button class="btn btn-success mb-2 w-100" onclick="loadDashboardData();">
                                                    <span style="display: block;" id="rfs">
                                                        Refresh dashboard
                                                    </span>
                                                    <span style="display: none;" id="spn">
                                                        Loading...
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-3 d-grid">
                                                <a href="{{route('morning-summary')}}"
                                                    class="btn btn-primary mb-2 w-100 refresh-link">Refresh Morning Summary</a>
                                                <!-- Added w-100 -->
                                            </div>
                                            <div class="col-12 col-lg-3 d-grid">
                                                <a href="{{route('evening-summary')}}"
                                                    class="btn btn-primary mb-2 w-100 refresh-link">Refresh Evening Summary</a>
                                                <!-- Added w-100 -->
                                            </div>
                                            <div class="col-12 col-lg-3 d-grid">
                                                <a href="{{route('morning-shop-report')}}"
                                                    class="btn btn-primary mb-2 w-100 refresh-link">Refresh Morning Shop Report</a>
                                                <!-- Added w-100 -->
                                            </div>
                                            <div class="col-12 col-lg-3 d-grid">
                                                <a href="{{route('evening-shop-report')}}"
                                                    class="btn btn-primary mb-2 w-100 refresh-link">Refresh Evening Shop Report</a>
                                                <!-- Added w-100 -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endif


                    <div class="row">
                        <!-- ============================================================== -->
                        <!-- sales  -->
                        <!-- ============================================================== -->
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="card border-3 border-top border-top-primary">
                                <div class="card-body">
                                    <h5 class="text-muted">Pending Orders Count</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1" id="pending_orders_count">
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- end sales  -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- new customer  -->
                        <!-- ============================================================== -->
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="card border-3 border-top border-top-primary">
                                <div class="card-body">
                                    <h5 class="text-muted">Processing Orders Count</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1" id="processing_orders_count">
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- end new customer  -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- visitor  -->
                        <!-- ============================================================== -->
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="card border-3 border-top border-top-primary">
                                <div class="card-body">
                                    <h5 class="text-muted">Total Completed Orders Count</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1" id="complete_orders_count">
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- end visitor  -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- total orders  -->
                        <!-- ============================================================== -->
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="card border-3 border-top border-top-primary">
                                <div class="card-body">
                                    <h5 class="text-muted">Under Review Orders Count</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1" id="under_review_orders_count">
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- end total orders  -->
                        <!-- ============================================================== -->
                    </div>

                    @if (Auth::user()->role != 'view')
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">Today Total Revenue</h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1" id="today_total_revenue"></h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right font-weight-bold">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">This week Total Revenue <small class="alert-warning p-1"
                                                id="weeks_gap">
                                            </small></h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1" id="last7Days_total_revenue">
                                            </h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right text-success font-weight-bold">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted">This Month Total Revenue <small class="alert-warning p-1"
                                                id="month_gap"> </small></h5>
                                        <div class="metric-value d-inline-block">
                                            <h1 class="mb-1" id="lastMonth_total_revenue">
                                            </h1>
                                        </div>
                                        <div class="metric-label d-inline-block float-right text-primary font-weight-bold">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- --------------------------------------------------------------------------------------------------------------                     -->

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <h2 class="card-header">Last 12 Months Revenue</h2>
                                <div class="card-body">
                                    <canvas id="barChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <h2 class="card-header">Last 30 Days Revenue</h2>
                                <div class="card-body">
                                    <canvas id="past30DaysRevenueChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <h2 class="card-header">Top 10 Best Selling Shops</h2>
                                <div class="card-body">
                                    <canvas id="topSellingShopsChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <h2 class="card-header">Top 10 Best Selling Items</h2>
                                <div class="card-body">
                                    <canvas id="topSellingItemsChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <h2 class="card-header">Top Best Selling Reps All Time</h2>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <canvas id="topSellingRepsAllTimeChart"></canvas>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <table class="table">
                                                <thead class="table-info">
                                                    <tr>
                                                        <th>Rep Name</th>
                                                        <th>Total Sales</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="topRepsTableBody">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <h2 class="card-header">Top Best Selling Reps Today</h2>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <canvas id="topSellingRepsTodayChart"></canvas>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <table class="table">
                                                <thead class="table-info">
                                                    <tr>
                                                        <th>Rep Name</th>
                                                        <th>Total Sales</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="top_selling_reps_today">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <h2 class="card-header">Top Best Selling Reps Last 30 Days</h2>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <canvas id="topSellingRepsLast30DaysChart"></canvas>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <table class="table">
                                                <thead class="table-info">
                                                    <tr>
                                                        <th>Rep Name</th>
                                                        <th>Total Sales</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="top_selling_reps_last_30_days">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- -------------------------------------------------------------------------------------------------------------------                     -->

                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Recent Orders</h5>
                                <div class="card-body">
                                    <div class="table-responsive ">
                                        <table class="table">
                                            <thead class="bg-light">
                                                <tr class="border-0">
                                                    <th class="border-0">#</th>
                                                    <th class="border-0">Order Id</th>
                                                    <th class="border-0">Outlet</th>
                                                    <th class="border-0">Delivery time</th>
                                                    <th class="border-0">Order create time</th>
                                                    <th class="border-0">Estimate&nbsp;full&nbsp;amount</th>
                                                </tr>
                                            </thead>
                                            <tbody id="latestOrdersBody">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">Top 10 Orders</h5>
                                <div class="card-body">
                                    <div class="table-responsive ">
                                        <table class="table">
                                            <thead class="bg-light">
                                                <tr class="border-0">
                                                    <th class="border-0">#</th>
                                                    <th class="border-0">Order Id</th>
                                                    <th class="border-0">Outlet</th>
                                                    <th class="border-0">Delivery time</th>
                                                    <th class="border-0">Order create time</th>
                                                    <th class="border-0">Estimate&nbsp;full&nbsp;amount</th>
                                                </tr>
                                            </thead>
                                            <tbody id="top10OrdersBody">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end footer -->
        <!-- ============================================================== -->
    </div>

    <!-- jQuery 3.3.1 -->
    <script src="{{ asset('assets/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
    <!-- Bootstrap bundle JS -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <!-- SlimScroll JS -->
    <script src="{{ asset('assets/vendor/slimscroll/jquery.slimscroll.js') }}"></script>
    <!-- Main JS -->
    <script src="{{ asset('assets/libs/js/main-js.js') }}"></script>
    <!-- Chartist JS -->
    <script src="{{ asset('assets/vendor/charts/chartist-bundle/chartist.min.js') }}"></script>
    <!-- Sparkline JS -->
    <script src="{{ asset('assets/vendor/charts/sparkline/jquery.sparkline.js') }}"></script>
    <!-- Morris JS -->
    <script src="{{ asset('assets/vendor/charts/morris-bundle/raphael.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/charts/morris-bundle/morris.js') }}"></script>
    <!-- C3 Charts JS -->
    <script src="{{ asset('assets/vendor/charts/c3charts/c3.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/charts/c3charts/d3-5.4.0.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/charts/c3charts/C3chartjs.js') }}"></script>
    <!-- Dashboard E-commerce JS -->
    <script src="{{ asset('assets/libs/js/dashboard-ecommerce.js') }}"></script>
    <!-- Chart Bundle JS -->
    <script src="{{ asset('assets/vendor/charts/charts-bundle/Chart.bundle.js') }}"></script>
    <script src="{{ asset('assets/vendor/charts/charts-bundle/chartjs.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        // Null-safe element getter: returns the element, or a detached dummy
        // so JS never crashes when an element is not rendered for some roles.
        function el(id) {
            return document.getElementById(id) || document.createElement('div');
        }

        function initialLoad() {
            axios.get('{{ route("order-admin.first-load-data") }}')
                .then(res => {
                    const d = res.data;

                    // ── Dashboard stats ──
                    el('pending_orders_count').innerHTML = d.stats.pending_orders_count;
                    el('processing_orders_count').innerHTML = d.stats.processing_orders_count;
                    el('complete_orders_count').innerHTML = d.stats.complete_orders_count;
                    el('under_review_orders_count').innerHTML = d.stats.under_review_orders_count;

                    el('today_total_revenue').innerHTML =
                        'රු. ' + parseFloat(d.stats.today_total_revenue).toLocaleString('en-US', { minimumFractionDigits: 2 });

                    el('weeks_gap').innerHTML = `(${d.stats.startOfThisWeek} to ${d.stats.endOfThisWeek})`;
                    el('last7Days_total_revenue').innerHTML =
                        'රු. ' + parseFloat(d.stats.last7Days_total_revenue).toLocaleString('en-US', { minimumFractionDigits: 2 });

                    el('month_gap').innerHTML = `(${d.stats.startOfThisMonth} to ${d.stats.endOfThisMonth})`;
                    el('lastMonth_total_revenue').innerHTML =
                        'රු. ' + parseFloat(d.stats.lastMonth_total_revenue).toLocaleString('en-US', { minimumFractionDigits: 2 });
                })
                .catch(err => {
                    console.error('Error fetching initial data:', err);
                });
        }

        function loadDashboardData() {
            el('rfs').style.display = 'none';
            el('spn').style.display = 'block';
            axios.get('{{ route("api.order-admin.dashboard-data") }}')
                .then(res => {
                    const d = res.data.stats; // shortcut for easier access

                    // Update Stats
                    el('pending_orders_count').innerHTML = d.pending_orders_count;
                    el('processing_orders_count').innerHTML = d.processing_orders_count;
                    el('complete_orders_count').innerHTML = d.complete_orders_count;
                    el('under_review_orders_count').innerHTML = d.under_review_orders_count;

                    el('today_total_revenue').innerHTML =
                        'රු. ' + parseFloat(d.today_total_revenue).toLocaleString('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });

                    el('weeks_gap').innerHTML = `(${d.startOfThisWeek} to ${d.endOfThisWeek})`;
                    el('last7Days_total_revenue').innerHTML =
                        'රු. ' + parseFloat(d.last7Days_total_revenue).toLocaleString('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });

                    el('month_gap').innerHTML = `(${d.startOfThisMonth} to ${d.endOfThisMonth})`;
                    el('lastMonth_total_revenue').innerHTML =
                        'රු. ' + parseFloat(d.lastMonth_total_revenue).toLocaleString('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });

                    //--------------------------------------------------------------------------------------------------------------

                    // Fix: Correctly map months and amounts
                    const months = d.last12montsrevenue.map(item => {
                        const date = new Date(item.month + '-01');
                        return date.toLocaleDateString('en-US', {
                            month: 'short',
                            year: 'numeric'
                        });
                        // Example: "Jan 2025", "Feb 2025"
                    });

                    const amounts = d.last12montsrevenue.map(item => parseFloat(item.amount));

                    // Destroy previous chart if exists
                    if (window.myBarChart instanceof Chart) {
                        window.myBarChart.destroy();
                    }

                    const barCtx = el('barChart').getContext('2d');

                    window.myBarChart = new Chart(barCtx, {
                        type: 'bar',
                        data: {
                            labels: months,
                            datasets: [{
                                label: 'Orders Amount (Rs)',
                                data: amounts,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        // Format Y-axis values with commas and currency symbol
                                        callback: function (value, index, values) {
                                            return 'Rs ' + value.toLocaleString(undefined, {
                                                maximumFractionDigits: 2
                                            });
                                        }
                                    }
                                }
                            }
                        }
                    });

                    //--------------------------------------------------------------------------------------------------------------
                    // === TOP 10 SELLING SHOPS PIE CHART ===
                    const ctx = el('topSellingShopsChart').getContext('2d');
                    // Destroy previous chart if exists
                    if (window.topShopsChart instanceof Chart) {
                        window.topShopsChart.destroy();
                    }

                    const {
                        topSellingShops_labels,
                        topSellingShops_data
                    } = d.topSellingShops;

                    window.topShopsChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: topSellingShops_labels,
                            datasets: [{
                                label: 'Total Sales',
                                data: topSellingShops_data,
                                backgroundColor: [
                                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                                    '#FF9F40', '#E7E9ED', '#8C9EFF', '#00CC99', '#FF99CC'
                                ],
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: 'Top 10 Selling Shops'
                                },
                            }
                        }
                    });
                    //-------------------------------------------------------------------------------------------------------------
                    const ctxItems = el('topSellingItemsChart').getContext('2d');

                    // Safe destructuring with defaults
                    const {
                        topItems_labels,
                        topItems_data
                    } = d.topSellingItems || {};

                    // Destroy existing chart
                    if (window.topItemsChart instanceof Chart) {
                        window.topItemsChart.destroy();
                    }

                    window.topItemsChart = new Chart(ctxItems, {
                        type: 'pie',
                        data: {
                            labels: topItems_labels,
                            datasets: [{
                                label: 'Total Quantity Sold',
                                data: topItems_data,
                                backgroundColor: [
                                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                                    '#FF9F40', '#E7E9ED', '#8C9EFF', '#00CC99', '#FF99CC'
                                ],
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: 'Top 10 Selling Items'
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function (context) {
                                            const label = context.label || '';
                                            const value = context.raw || 0;
                                            return `${label}: ${value} units`;
                                        }
                                    }
                                }
                            }
                        }
                    });
                    //--------------------------------------------------------------------------------------------------------------
                    // last 30 days revenue chart update
                    const ctx30days = el('past30DaysRevenueChart').getContext('2d');
                    const {
                        labels: revenueLabels,
                        data: revenueData
                    } = d.revenueData;
                    // Destroy previous chart if exists
                    if (window.rev30Chart instanceof Chart) {
                        window.rev30Chart.destroy();
                    }
                    window.rev30Chart = new Chart(ctx30days, {
                        type: 'bar',
                        data: {
                            labels: revenueLabels,
                            datasets: [{
                                label: 'Revenue (Rs)',
                                data: revenueData,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false,
                                },
                                title: {
                                    display: true,
                                    text: 'Past 30 Days Revenue'
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Revenue (Rs)'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Date'
                                    }
                                }
                            }
                        }
                    });

                    //--------------------------------------------------------------------------------------------------------------
                    // Update Top Selling Reps all Time Chart
                    const ctxRepsAllTime = el('topSellingRepsAllTimeChart').getContext('2d');
                    const {
                        labels: repLabelsAllTime,
                        data: repDataAllTime
                    } = d.topSellingRepsAllTime.chartData;
                    // Destroy previous chart if exists
                    if (window.repsAllTimeChart instanceof Chart) {
                        window.repsAllTimeChart.destroy();
                    }
                    window.repsAllTimeChart = new Chart(ctxRepsAllTime, {
                        type: 'bar',
                        data: {
                            labels: repLabelsAllTime,
                            datasets: [{
                                label: 'Total Sales (Rs)',
                                data: repDataAllTime,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false,
                                },
                                title: {
                                    display: true,
                                    text: 'Top 10 Best-Selling Reps'
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Total Sales (Rs)'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Rep Name'
                                    }
                                }
                            }
                        }
                    });

                    const tableBody = el('topRepsTableBody');
                    // Clear existing table rows
                    tableBody.innerHTML = '';
                    // Populate table with new data
                    d.topSellingRepsAllTime.tableData.forEach(rep => {
                        const row = document.createElement('tr');
                        const nameCell = document.createElement('td');
                        nameCell.textContent = rep.name;
                        const salesCell = document.createElement('td');
                        salesCell.textContent = 'Rs.' + parseFloat(rep.total_sales).toLocaleString('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        row.appendChild(nameCell);
                        row.appendChild(salesCell);
                        tableBody.appendChild(row);
                    });
                    //-------------------------------------------------------------------------------------------------
                    // Update Top Selling Reps Today Chart
                    const ctxRepsToday = el('topSellingRepsTodayChart').getContext('2d');
                    const {
                        labels: repLabelsToday,
                        data: repDataToday
                    } = d.topSellingRepsToday.chartData;
                    // Destroy previous chart if exists
                    if (window.repsTodayChart instanceof Chart) {
                        window.repsTodayChart.destroy();
                    }
                    window.repsTodayChart = new Chart(ctxRepsToday, {
                        type: 'bar',
                        data: {
                            labels: repLabelsToday,
                            datasets: [{
                                label: 'Total Sales (Rs)',
                                data: repDataToday,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false,
                                },
                                title: {
                                    display: true,
                                    text: 'Top 10 Best-Selling Reps'
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Total Sales (Rs)'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Rep Name'
                                    }
                                }
                            }
                        }
                    });

                    // Update Top Selling Reps Today Table
                    const tableBodyToday = el('top_selling_reps_today');
                    // Clear existing table rows
                    tableBodyToday.innerHTML = '';
                    // Populate table with new data
                    d.topSellingRepsToday.tableData.forEach(rep => {
                        const row = document.createElement('tr');
                        const nameCell = document.createElement('td');
                        nameCell.textContent = rep.name;
                        const salesCell = document.createElement('td');
                        salesCell.textContent = 'Rs.' + parseFloat(rep.total_sales).toLocaleString('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        row.appendChild(nameCell);
                        row.appendChild(salesCell);
                        tableBodyToday.appendChild(row);
                    });

                    //-------------------------------------------------------------------------------------------------
                    // Update Top Selling Reps Last 30 Days Chart
                    const ctxReps30Days = el('topSellingRepsLast30DaysChart').getContext('2d');
                    const {
                        labels: repLabels30Days,
                        data: repData30Days
                    } = d.topSellingRepsLast30Days.chartData;
                    // Destroy previous chart if exists
                    if (window.reps30Chart instanceof Chart) {
                        window.reps30Chart.destroy();
                    }
                    window.reps30Chart = new Chart(ctxReps30Days, {
                        type: 'bar',
                        data: {
                            labels: repLabels30Days,
                            datasets: [{
                                label: 'Total Sales (Rs)',
                                data: repData30Days,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false,
                                },
                                title: {
                                    display: true,
                                    text: 'Top 10 Best-Selling Reps'
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Total Sales (Rs)'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Rep Name'
                                    }
                                }
                            }
                        }
                    });

                    // Update Top Selling Reps Last 30 Days Table
                    const tableBody30Days = el('top_selling_reps_last_30_days');
                    // Clear existing table rows
                    tableBody30Days.innerHTML = '';
                    // Populate table with new data
                    d.topSellingRepsLast30Days.tableData.forEach(rep => {
                        const row = document.createElement('tr');
                        const nameCell = document.createElement('td');
                        nameCell.textContent = rep.name;
                        const salesCell = document.createElement('td');
                        salesCell.textContent = 'Rs.' + parseFloat(rep.total_sales).toLocaleString('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        row.appendChild(nameCell);
                        row.appendChild(salesCell);
                        tableBody30Days.appendChild(row);
                    });

                    //-------------------------------------------------------------------------------------------------
                    // Update Latest Orders Table
                    const latestOrdersBody = el('latestOrdersBody');
                    // Clear existing table rows
                    latestOrdersBody.innerHTML = '';
                    // Populate table with new data
                    d.latest_orders.forEach((order, index) => {
                        const row = document.createElement('tr');
                        const indexCell = document.createElement('td');
                        indexCell.textContent = index + 1;
                        const orderIdCell = document.createElement('td');
                        orderIdCell.textContent = order.id;
                        const outletCell = document.createElement('td');
                        outletCell.textContent = order.shop_name || order.shop;
                        const deliveryTimeCell = document.createElement('td');
                        deliveryTimeCell.textContent = order.time_period || 'N/A';
                        const orderCreateTimeCell = document.createElement('td');
                        const createdAt = new Date(order.order_created_at);
                        orderCreateTimeCell.textContent = createdAt.toLocaleString();
                        const estimateAmountCell = document.createElement('td');
                        estimateAmountCell.textContent = 'Rs. ' + parseFloat(order.total_price).toLocaleString('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        row.appendChild(indexCell);
                        row.appendChild(orderIdCell);
                        row.appendChild(outletCell);
                        row.appendChild(deliveryTimeCell);
                        row.appendChild(orderCreateTimeCell);
                        row.appendChild(estimateAmountCell);
                        latestOrdersBody.appendChild(row);
                    });

                    //-------------------------------------------------------------------------------------------------
                    // Update Top 10 Orders Table
                    const top10OrdersBody = el('top10OrdersBody');
                    // Clear existing table rows
                    top10OrdersBody.innerHTML = '';
                    // Populate table with new data
                    d.top_orders.forEach((order, index) => {
                        const row = document.createElement('tr');
                        const indexCell = document.createElement('td');
                        indexCell.textContent = index + 1;
                        const orderIdCell = document.createElement('td');
                        orderIdCell.textContent = order.unique_id;
                        const outletCell = document.createElement('td');
                        outletCell.textContent = order.name || order.shop;
                        const deliveryTimeCell = document.createElement('td');
                        deliveryTimeCell.textContent = order.time_period || 'N/A';
                        const orderCreateTimeCell = document.createElement('td');
                        const createdAt = new Date(order.order_created_at);
                        orderCreateTimeCell.textContent = createdAt.toLocaleString();
                        const estimateAmountCell = document.createElement('td');
                        estimateAmountCell.textContent = 'Rs. ' + parseFloat(order.total_price).toLocaleString('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        row.appendChild(indexCell);
                        row.appendChild(orderIdCell);
                        row.appendChild(outletCell);
                        row.appendChild(deliveryTimeCell);
                        row.appendChild(orderCreateTimeCell);
                        row.appendChild(estimateAmountCell);
                        top10OrdersBody.appendChild(row);
                    });

                })
                .catch(err => {
                    console.error('Error loading dashboard data:', err);
                    alert('Failed to load dashboard data. Please try again.');
                })
                .finally(() => {
                    el('rfs').style.display = 'block';
                    el('spn').style.display = 'none';
                });
        }

        let intervalId;

        // document.addEventListener('DOMContentLoaded', function () {
        //     // Initial load
        //     loadDashboardData();

        //     // Refresh every 5 minutes (300000 milliseconds)
        //     intervalId = setInterval(loadDashboardData, 20000);
        // });

        // document.addEventListener('beforeunload', function () {
        //     clearInterval(intervalId);
        // });

        // Disable any refresh link after it is clicked (works for every link,
        // and safely does nothing for roles where these links are not rendered)
        document.querySelectorAll('.refresh-link').forEach(function (link) {
            link.addEventListener('click', function () {
                this.classList.add('disabled');
            });
        });

        initialLoad();
    </script>

</body>

</html>