<div class="container-fluid py-4">
    <!-- Top Header & Filter Bar -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h2 class="fw-bold text-dark mb-1">Dashboard Overview</h2>
            <p class="text-muted mb-0">Real-time enterprise metrics and performance insights</p>
        </div>
        <div class="d-flex align-items-center gap-2 mt-3 mt-md-0">
            <!-- Custom Date Inputs -->
            <div class="input-group input-group-sm w-auto shadow-sm">
                <span class="input-group-text bg-white text-muted border-end-0">From</span>
                <input type="date" id="customFrom" class="form-control border-start-0 ps-0">
            </div>
            <div class="input-group input-group-sm w-auto shadow-sm">
                <span class="input-group-text bg-white text-muted border-end-0">To</span>
                <input type="date" id="customTo" class="form-control border-start-0 ps-0">
            </div>
            <button class="btn btn-sm btn-primary px-3 shadow-sm" id="applyCustomDate">
                <i class="bi bi-filter"></i> Apply
            </button>

            <!-- Dropdown Filter -->
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle bg-white shadow-sm px-3" type="button" id="dashboardFilter"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Custom: 1st - Today
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="dashboardFilter">
                    <li><a class="dropdown-item py-2" href="#" data-filter="custom"><i class="bi bi-calendar-range me-2 text-primary"></i>Custom (1st - Today)</a></li>
                    <li><a class="dropdown-item py-2" href="#" data-filter="week"><i class="bi bi-calendar-week me-2 text-primary"></i>This Week</a></li>
                    <li><a class="dropdown-item py-2" href="#" data-filter="month"><i class="bi bi-calendar-month me-2 text-primary"></i>This Month</a></li>
                    <li><a class="dropdown-item py-2" href="#" data-filter="year"><i class="bi bi-calendar-check me-2 text-primary"></i>This Year</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Advanced KPI Widgets -->
    <div class="row g-3 mb-4">
        <!-- Payments Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-4 position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-uppercase fw-semibold text-muted fs-7 tracking-wider">Total Sales</span>
                            <h3 id="paymentsTotal" class="fw-extrabold text-dark mt-1 mb-2">₹0</h3>
                        </div>
                        <div class="icon-shape bg-primary-subtle text-primary rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-currency-rupee fs-4"></i>
                        </div>
                    </div>
                    <div class="d-flex gap-3 mt-3 pt-2 border-top fs-7">
                        <span class="text-success fw-medium">Profit: <span id="paymentsProfit">₹0</span></span>
                        <span class="text-danger fw-medium">Cost: <span id="paymentsCost">₹0</span></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projects Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-4 position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-uppercase fw-semibold text-muted fs-7 tracking-wider">Active Projects</span>
                            <h3 id="projectsCount" class="fw-extrabold text-dark mt-1 mb-2">0</h3>
                        </div>
                        <div class="icon-shape bg-info-subtle text-info rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-briefcase fs-4"></i>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-top fs-7">
                        <span class="text-info fw-medium">Revenue: <span id="projectsRevenue">₹0</span></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-4 position-relative">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <span class="text-uppercase fw-semibold text-muted fs-7 tracking-wider">Total Tasks</span>
                            <h3 id="tasksCount" class="fw-extrabold text-dark mt-1 mb-0">0</h3>
                        </div>
                        <div class="icon-shape bg-success-subtle text-success rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-list-check fs-4"></i>
                        </div>
                    </div>
                    <div class="progress mt-3 rounded-pill bg-light" style="height:6px;">
                        <div id="tasksProgress" class="progress-bar bg-success rounded-pill" style="width:0%"></div>
                    </div>
                    <div class="d-flex justify-content-between mt-2 fs-7 text-muted">
                        <span id="tasksStatus">Completed: 0</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bugs Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-4 position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-uppercase fw-semibold text-muted fs-7 tracking-wider">System Bugs</span>
                            <h3 id="bugsCount" class="fw-extrabold text-dark mt-1 mb-2">0</h3>
                        </div>
                        <div class="icon-shape bg-warning-subtle text-warning rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-bug fs-4"></i>
                        </div>
                    </div>
                    <div class="d-flex gap-3 mt-3 pt-2 border-top fs-7">
                        <span class="text-warning fw-medium">Open: <span id="bugsOpen">0</span></span>
                        <span class="text-success fw-medium">Fixed: <span id="bugsFixed">0</span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enterprise Clients Table Section -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold mb-1 text-dark">Payments Status</h5>
                <p class="text-muted fs-7 mb-0">Filtered tracking log of active project and paid payments milestones and receipts</p>
            </div>
            <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill">Live Feed</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="enterpriseTable" class="table table-hover align-middle mb-0">
                    <thead class="table-light text-uppercase fs-8 text-secondary">
                        <tr>
                            <th class="ps-4 py-3">Project / Task details</th>
                            <th class="py-3">Amount (₹)</th>
                            <th class="py-3">Due Date</th>
                            <th class="pe-4 py-3 text-end">Status</th>
                        </tr>
                    </thead>
                    <tbody id="enterpriseBody" class="border-top-0">
                        <!-- Dynamic Rows Appended Here -->
                    </tbody>
                    <tfoot class="table-light border-top">
                        <tr>
                            <th class="ps-4 py-3 text-dark fw-bold">Grand Total:</th>
                            <th id="totalPayments" class="py-3 text-dark fw-bold">₹0.00</th>
                            <th class="py-3"></th>
                            <th class="pe-4 py-3"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row g-4">
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h6 class="fw-bold mb-0 text-dark">Payments Analytics Trend</h6>
                </div>
                <div class="card-body p-4">
                    <div id="paymentsChart"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h6 class="fw-bold mb-0 text-dark">Tasks Completion Rate</h6>
                </div>
                <div class="card-body p-4">
                    <div id="tasksChart"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function loadDashboard(filter = 'custom', labelText = '') {
        let url = 'model/dashboard.php?filter=' + filter;

        const customFrom = document.getElementById('customFrom').value;
        const customTo = document.getElementById('customTo').value;

        if (filter === 'custom') {
            let from, to;
            if (customFrom && customTo) {
                from = customFrom;
                to = customTo;
            } else {
                const now = new Date();
                const firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
                from = firstDay.toISOString().split('T')[0];
                to = now.toISOString().split('T')[0];
                
                document.getElementById('customFrom').value = from;
                document.getElementById('customTo').value = to;
            }
            url = `model/dashboard.php?filter=custom&from=${from}&to=${to}`;
            document.getElementById('dashboardFilter').innerText = `Custom: ${from} - ${to}`;
        } else {
            document.getElementById('dashboardFilter').innerText = labelText;
        }

        try {
            const res = await fetch(url);
            const data = await res.json();

            if (data.success) {
                const stats = data.data;

                // Payments summary
                document.getElementById('paymentsTotal').innerText = stats.sales;
                document.getElementById('paymentsProfit').innerText = stats.profit;
                document.getElementById('paymentsCost').innerText = stats.cost;

                // Projects summary
                document.getElementById('projectsCount').innerText = stats.projects;
                document.getElementById('projectsRevenue').innerText = stats.revenue;

                // Tasks summary
                const ts = stats.tasks_summary;
                document.getElementById('tasksCount').innerText = ts.tasks;
                document.getElementById('tasksProgress').style.width = ts.progress + '%';
                document.getElementById('tasksProgress').setAttribute('aria-valuenow', ts.progress);
                document.getElementById('tasksStatus').innerText = `Completed: ${ts.tasks_done} (${ts.progress}%)`;

                // Bugs summary
                document.getElementById('bugsCount').innerText = stats.bugs;
                document.getElementById('bugsOpen').innerText = stats.bugs_open;
                document.getElementById('bugsFixed').innerText = stats.bugs_fixed;

                // Charts
                renderPaymentsChart(stats);
                renderTasksChart(ts);

                // === Enterprise Clients Table Integration ===
                const tbody = document.getElementById('enterpriseBody');
                tbody.innerHTML = '';

                let totalPayments = 0;
                let totalInstallments = 0;

                if (stats.task_payments && stats.task_payments.length > 0) {
                    stats.task_payments.forEach(p => {
                        const amount = parseFloat(p.amount || 0);
                        totalPayments += amount;
                        totalInstallments += 1;

                        tbody.innerHTML += `
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="fw-bold text-dark"><a href="?page=projects&id=${p.project_id}" class="text-decoration-none text-dark">${p.project_name ?? 'N/A'}</a></div>
                                    <small class="text-muted"><a href="?page=tasks&project_id=${p.project_id}" class="text-decoration-none text-primary">${p.task_name ?? 'N/A'} (Inst #${p.installment_no})</a></small>
                                </td>
                                <td class="py-3 fw-semibold text-dark">₹${amount.toFixed(2)}</td>
                                <td class="py-3 text-secondary">${p.paid_date}</td>
                                <td class="pe-4 py-3 text-end"><span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">${p.paid_status}</span></td>
                            </tr>`;
                    });
                } else {
                    tbody.innerHTML = `<tr><td colspan="4" class="text-center py-4 text-muted">No records found for this range</td></tr>`;
                }

                // Totals in tfoot
                if (document.getElementById('totalPayments')) {
                    document.getElementById('totalPayments').innerText = '₹' + totalPayments.toFixed(2);
                }
            }
        } catch (error) {
            console.error("Failed to load dashboard data:", error);
        }
    }

    // Dropdown click handler
    document.querySelectorAll('.dropdown-menu a').forEach(item => {
        item.addEventListener('click', e => {
            e.preventDefault();
            const filter = e.target.getAttribute('data-filter');
            const labelText = e.target.innerText;
            loadDashboard(filter, labelText);
        });
    });

    // Apply custom date range button trigger
    document.getElementById('applyCustomDate').addEventListener('click', () => {
        loadDashboard('custom', 'Custom Range');
    });

    // Helper to safely parse currency strings to floats
    function parseCurrency(val) {
        if (!val) return 0;
        let cleanVal = String(val).replace(/[^\d.-]/g, '');
        return parseFloat(cleanVal) || 0;
    }

    // Charts Renderers
    function renderPaymentsChart(stats) {
        var options = {
            chart: { type: 'bar', height: 280, toolbar: { show: false } },
            series: [{
                name: 'Amount',
                data: [
                    parseCurrency(stats.sales),
                    parseCurrency(stats.profit),
                    parseCurrency(stats.revenue),
                    parseCurrency(stats.net_income)
                ]
            }],
            colors: ['#0d6efd'],
            plotOptions: { bar: { borderRadius: 6, columnWidth: '40%' } },
            xaxis: { categories: ['Sales', 'Profit', 'Revenue', 'Net Income'] }
        };
        document.querySelector("#paymentsChart").innerHTML = "";
        new ApexCharts(document.querySelector("#paymentsChart"), options).render();
    }

    function renderTasksChart(ts) {
        var progressVal = parseFloat(ts.progress) || 0;
        var options = {
            chart: { type: 'radialBar', height: 280 },
            series: [progressVal],
            colors: ['#198754'],
            labels: ['Completion Rate'],
            plotOptions: {
                radialBar: {
                    hollow: { size: '65%' },
                    dataLabels: {
                        show: true,
                        value: {
                            fontSize: '22px',
                            fontWeight: 'bold',
                            formatter: function (val) {
                                return val + "%";
                            }
                        }
                    }
                }
            }
        };
        document.querySelector("#tasksChart").innerHTML = "";
        new ApexCharts(document.querySelector("#tasksChart"), options).render();
    }

    // Initial load will always be 1st → Today
    document.addEventListener("DOMContentLoaded", () => {
        const now = new Date();
        const firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
        const from = firstDay.toISOString().split('T')[0];
        const to = now.toISOString().split('T')[0];

        document.getElementById('customFrom').value = from;
        document.getElementById('customTo').value = to;
        document.getElementById('dashboardFilter').innerText = `Custom: ${from} - ${to}`;

        loadDashboard('custom', `Custom: ${from} - ${to}`);
    });
</script>