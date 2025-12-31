@extends('layouts.app')

@section('title', 'Dashboard Owner')
@section('subtitle', 'Ringkasan dan statistik bisnis Anda')

@section('content')
<div class="dashboard-container">
    <!-- Header Stats -->
    <div class="dashboard-header">
        <div class="welcome-section">
            <h2>Selamat datang, {{ Auth::user()->name }}! 👋</h2>
            <p>Berikut adalah ringkasan performa bisnis Anda hari ini</p>
        </div>
        <div class="date-info">
            <div class="current-date">
                <i class="fas fa-calendar-alt"></i>
                <span>{{ now()->translatedFormat('l, d F Y') }}</span>
            </div>
            <div class="current-time">
                <i class="fas fa-clock"></i>
                <span id="currentTime">{{ now()->format('H:i') }}</span>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <!-- Total Users -->
        <div class="stat-card">
            <div class="stat-icon users">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value">{{ $totalUsers }}</h3>
                <p class="stat-label">Total Pengguna</p>
                <div class="stat-trend positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+12% dari bulan lalu</span>
                </div>
            </div>
            <a href="{{ route('users.index') }}" class="stat-link">
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <!-- Total Products -->
        <div class="stat-card">
            <div class="stat-icon products">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value">{{ $totalProducts }}</h3>
                <p class="stat-label">Total Produk</p>
                <div class="stat-trend positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+5% dari bulan lalu</span>
                </div>
            </div>
            <a href="{{ route('products.index') }}" class="stat-link">
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <!-- Total Transactions -->
        <div class="stat-card">
            <div class="stat-icon transactions">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value">{{ $totalTransactions }}</h3>
                <p class="stat-label">Total Transaksi</p>
                <div class="stat-trend positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+18% dari bulan lalu</span>
                </div>
            </div>
            <a href="{{ route('transactions.index') }}" class="stat-link">
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <!-- Revenue -->
        <div class="stat-card">
            <div class="stat-icon revenue">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h3>
                <p class="stat-label">Total Pendapatan</p>
                <div class="stat-trend positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+22% dari bulan lalu</span>
                </div>
            </div>
            <a href="{{ route('reports.index') }}" class="stat-link">
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <!-- Average Transaction -->
        <div class="stat-card">
            <div class="stat-icon avg-transaction">
                <i class="fas fa-chart-bar"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value">Rp {{ number_format($avgTransaction ?? 0, 0, ',', '.') }}</h3>
                <p class="stat-label">Rata-rata Transaksi</p>
                <div class="stat-trend positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+8% dari bulan lalu</span>
                </div>
            </div>
            <a href="{{ route('reports.index') }}" class="stat-link">
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <!-- Today's Sales -->
        <div class="stat-card">
            <div class="stat-icon today-sales">
                <i class="fas fa-sun"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value">{{ $todayTransactions ?? 0 }}</h3>
                <p class="stat-label">Transaksi Hari Ini</p>
                <div class="stat-trend positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+15% dari kemarin</span>
                </div>
            </div>
            <a href="{{ route('transactions.index') }}" class="stat-link">
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Charts & Tables Section -->
    <div class="charts-grid">
        <!-- Sales Chart -->
        <div class="chart-card">
            <div class="chart-header">
                <h3>Grafik Penjualan 7 Hari Terakhir</h3>
                <select class="chart-period">
                    <option value="7">7 Hari</option>
                    <option value="30">30 Hari</option>
                    <option value="90">90 Hari</option>
                </select>
            </div>
            <div class="chart-container">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Top Products -->
        <div class="table-card">
            <div class="table-header">
                <h3>Produk Terlaris</h3>
                <a href="{{ route('products.index') }}" class="view-all">Lihat Semua</a>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Terjual</th>
                            <th>Pendapatan</th>
                            <th>Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topProducts ?? [] as $product)
                        <tr>
                            <td>
                                <div class="product-info">
                                    <div class="product-name">{{ $product->name }}</div>
                                    <small class="product-code">{{ $product->code ?? 'PRD-' . $product->id }}</small>
                                </div>
                            </td>
                            <td>{{ $product->category->name ?? '-' }}</td>
                            <td>
                                <span class="badge sales-count">{{ $product->total_sold ?? 0 }}</span>
                            </td>
                            <td>Rp {{ number_format($product->total_revenue ?? 0, 0, ',', '.') }}</td>
                            <td>
                                <div class="rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= ($product->avg_rating ?? 0) ? 'filled' : '' }}"></i>
                                    @endfor
                                    <span class="rating-value">{{ number_format($product->avg_rating ?? 0, 1) }}</span>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="empty-data">
                                <i class="fas fa-chart-line"></i>
                                <p>Belum ada data penjualan produk</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="recent-transactions">
        <div class="section-header">
            <h3>Transaksi Terbaru</h3>
            <a href="{{ route('transactions.index') }}" class="btn btn-primary">
                <i class="fas fa-list"></i>
                Lihat Semua Transaksi
            </a>
        </div>

        <div class="transactions-list">
            @forelse($recentTransactions ?? [] as $transaction)
            <div class="transaction-item">
                <div class="transaction-icon">
                    @if($transaction->payment_method === 'cash')
                        <i class="fas fa-money-bill-wave"></i>
                    @elseif($transaction->payment_method === 'debit_card')
                        <i class="fas fa-credit-card"></i>
                    @else
                        <i class="fas fa-wallet"></i>
                    @endif
                </div>
                <div class="transaction-info">
                    <h4>Transaksi #{{ $transaction->id }}</h4>
                    <p>{{ $transaction->customer_name ?? 'Pelanggan Umum' }} • {{ $transaction->created_at->format('d M Y H:i') }}</p>
                </div>
                <div class="transaction-amount">
                    <span class="amount">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                    <span class="status {{ $transaction->status }}">{{ ucfirst($transaction->status) }}</span>
                </div>
                <a href="{{ route('transactions.show', $transaction) }}" class="transaction-action">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
            @empty
            <div class="empty-state">
                <i class="fas fa-receipt"></i>
                <h4>Belum Ada Transaksi</h4>
                <p>Belum ada transaksi yang tercatat</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <h3>Quick Actions</h3>
        <div class="actions-grid">
            <a href="{{ route('transactions.index') }}" class="action-card">
                <div class="action-icon new-transaction">
                    <i class="fas fa-cash-register"></i>
                </div>
                <h4>Transaksi Baru</h4>
                <p>Buat transaksi penjualan baru</p>
            </a>

            <a href="{{ route('products.create') }}" class="action-card">
                <div class="action-icon new-product">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <h4>Tambah Produk</h4>
                <p>Tambah produk baru ke katalog</p>
            </a>

            <a href="{{ route('reports.index') }}" class="action-card">
                <div class="action-icon reports">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <h4>Lihat Laporan</h4>
                <p>Analisis data penjualan</p>
            </a>

            <a href="{{ route('users.create') }}" class="action-card">
                <div class="action-icon new-user">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h4>Tambah User</h4>
                <p>Tambah user baru ke sistem</p>
            </a>
        </div>
    </div>
</div>

<style>
    /* Dashboard Layout */
    .dashboard-container {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    /* Dashboard Header */
    .dashboard-header {
        background: white;
        border-radius: 12px;
        padding: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: var(--shadow);
        border: 1px solid var(--border);
    }

    .welcome-section h2 {
        font-size: 24px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 8px;
    }

    .welcome-section p {
        color: var(--text-light);
        font-size: 14px;
    }

    .date-info {
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: flex-end;
    }

    .current-date, .current-time {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--text-light);
        font-size: 14px;
    }

    .current-date i, .current-time i {
        color: var(--primary);
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
        display: flex;
        align-items: center;
        gap: 20px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary-light);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(to bottom, var(--primary), var(--primary-light));
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
        flex-shrink: 0;
    }

    .stat-icon.users {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    }

    .stat-icon.products {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .stat-icon.transactions {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .stat-icon.revenue {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    }

    .stat-icon.avg-transaction {
        background: linear-gradient(135deg, #ec4899, #db2777);
    }

    .stat-icon.today-sales {
        background: linear-gradient(135deg, #06b6d4, #0891b2);
    }

    .stat-content {
        flex: 1;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 4px;
        line-height: 1;
    }

    .stat-label {
        font-size: 14px;
        color: var(--text-light);
        margin-bottom: 8px;
    }

    .stat-trend {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 12px;
        font-weight: 600;
    }

    .stat-trend.positive {
        color: var(--success);
    }

    .stat-trend.negative {
        color: var(--danger);
    }

    .stat-link {
        width: 36px;
        height: 36px;
        background: var(--light);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .stat-link:hover {
        background: var(--primary);
        color: white;
        transform: translateX(3px);
    }

    /* Charts Grid */
    .charts-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
    }

    @media (max-width: 1200px) {
        .charts-grid {
            grid-template-columns: 1fr;
        }
    }

    .chart-card, .table-card {
        background: white;
        border-radius: 12px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .chart-header, .table-header {
        padding: 20px;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chart-header h3, .table-header h3 {
        font-size: 16px;
        font-weight: 600;
        color: var(--dark);
        margin: 0;
    }

    .chart-period {
        padding: 8px 12px;
        border: 1px solid var(--border);
        border-radius: 6px;
        background: white;
        color: var(--text);
        font-size: 14px;
        cursor: pointer;
    }

    .chart-period:focus {
        outline: none;
        border-color: var(--primary);
    }

    .chart-container {
        padding: 20px;
        height: 300px;
    }

    /* Table Card */
    .view-all {
        color: var(--primary);
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: color 0.2s ease;
    }

    .view-all:hover {
        color: var(--primary-dark);
    }

    .table-container {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: var(--light);
        padding: 12px 16px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid var(--border);
    }

    td {
        padding: 16px;
        border-bottom: 1px solid var(--border);
    }

    tr:hover {
        background: var(--light);
    }

    .product-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .product-name {
        font-weight: 600;
        color: var(--dark);
    }

    .product-code {
        font-size: 11px;
        color: var(--text-light);
    }

    .badge.sales-count {
        background: var(--success);
        color: white;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .rating {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .rating i {
        color: #e2e8f0;
        font-size: 12px;
    }

    .rating i.filled {
        color: #fbbf24;
    }

    .rating-value {
        font-size: 12px;
        color: var(--text-light);
        margin-left: 4px;
    }

    .empty-data {
        text-align: center;
        padding: 40px !important;
        color: var(--text-light);
    }

    .empty-data i {
        font-size: 32px;
        margin-bottom: 12px;
        color: var(--border);
    }

    .empty-data p {
        margin: 0;
    }

    /* Recent Transactions */
    .recent-transactions {
        background: white;
        border-radius: 12px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .section-header {
        padding: 20px;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .section-header h3 {
        font-size: 16px;
        font-weight: 600;
        color: var(--dark);
        margin: 0;
    }

    .transactions-list {
        padding: 0;
    }

    .transaction-item {
        display: flex;
        align-items: center;
        padding: 16px 20px;
        border-bottom: 1px solid var(--border);
        transition: background 0.2s ease;
    }

    .transaction-item:hover {
        background: var(--light);
    }

    .transaction-item:last-child {
        border-bottom: none;
    }

    .transaction-icon {
        width: 40px;
        height: 40px;
        background: var(--light);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 18px;
        margin-right: 16px;
    }

    .transaction-info {
        flex: 1;
    }

    .transaction-info h4 {
        font-size: 14px;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 4px;
    }

    .transaction-info p {
        font-size: 12px;
        color: var(--text-light);
        margin: 0;
    }

    .transaction-amount {
        text-align: right;
        margin-right: 20px;
    }

    .transaction-amount .amount {
        display: block;
        font-size: 16px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 4px;
    }

    .transaction-amount .status {
        font-size: 11px;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 12px;
        text-transform: uppercase;
    }

    .transaction-amount .status.completed {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success);
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .transaction-amount .status.pending {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning);
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .transaction-amount .status.failed {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger);
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .transaction-action {
        width: 36px;
        height: 36px;
        background: var(--light);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-light);
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .transaction-action:hover {
        background: var(--primary);
        color: white;
    }

    .empty-state {
        padding: 40px;
        text-align: center;
        color: var(--text-light);
    }

    .empty-state i {
        font-size: 48px;
        color: var(--border);
        margin-bottom: 16px;
    }

    .empty-state h4 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--text);
    }

    /* Quick Actions */
    .quick-actions {
        background: white;
        border-radius: 12px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
        padding: 30px;
    }

    .quick-actions h3 {
        font-size: 18px;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 20px;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
    }

    .action-card {
        background: var(--light);
        border-radius: 12px;
        padding: 24px;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 1px solid transparent;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .action-card:hover {
        background: white;
        border-color: var(--primary);
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
    }

    .action-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
        margin-bottom: 16px;
    }

    .action-icon.new-transaction {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .action-icon.new-product {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    }

    .action-icon.reports {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
    }

    .action-icon.new-user {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .action-card h4 {
        font-size: 16px;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 8px;
    }

    .action-card p {
        font-size: 13px;
        color: var(--text-light);
        margin: 0;
        line-height: 1.4;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .dashboard-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
        }

        .date-info {
            align-items: flex-start;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .charts-grid {
            grid-template-columns: 1fr;
        }

        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .transaction-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .transaction-amount {
            text-align: left;
            margin-right: 0;
        }

        .transaction-action {
            align-self: flex-end;
        }
    }
</style>

<script>
    // Update current time
    function updateTime() {
        const now = new Date();
        const timeElement = document.getElementById('currentTime');
        if (timeElement) {
            timeElement.textContent = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });
        }
    }

    // Initialize time and update every second
    updateTime();
    setInterval(updateTime, 1000);

    // Sample chart data (you should replace this with real data from your backend)
    document.addEventListener('DOMContentLoaded', function() {
        // Sales Chart
        const salesChartCtx = document.getElementById('salesChart');
        if (salesChartCtx) {
            // In production, you should fetch this data from your backend
            const salesData = {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                datasets: [{
                    label: 'Penjualan (Rp)',
                    data: [4500000, 5200000, 3800000, 6100000, 7200000, 4800000, 5500000],
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    borderColor: 'rgba(37, 99, 235, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            };

            new Chart(salesChartCtx, {
                type: 'line',
                data: salesData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endsection
