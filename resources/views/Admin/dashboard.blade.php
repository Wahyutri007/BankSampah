@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@push('styles')
<style>
    :root {
        --primary: #10b981;
        --primary-dark: #059669;
        --primary-light: #d1fae5;
        --secondary: #3b82f6;
        --danger: #ef4444;
        --warning: #f59e0b;
        --info: #06b6d4;
        --white: #ffffff;
        --bg: #f9fafb;
        --ink: #111827;
        --muted: #6b7280;
        --line: #e5e7eb;
        --hover-bg: #f3f4f6;
        --radius: 12px;
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
        --shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.1);
        --transition: all 0.2s ease;
    }

    body {
        background-color: var(--bg);
        color: var(--ink);
    }

    /* Dashboard Container */
    .dashboard-container {
        padding: 24px;
        width: 100%;
        max-width: 100%;
    }

    /* Dashboard Header */
    .dashboard-header {
        margin-bottom: 32px;
    }
    
    .dashboard-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: var(--ink);
        margin-bottom: 8px;
    }
    
    .dashboard-header p {
        color: var(--muted);
        font-size: 15px;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }

    /* Stat Card */
    .stat-card {
        background: var(--white);
        border-radius: var(--radius);
        padding: 24px;
        box-shadow: var(--shadow);
        border: 1px solid var(--line);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }
    
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }
    
    .stat-card.primary {
        border-top: 4px solid var(--primary);
    }
    
    .stat-card.secondary {
        border-top: 4px solid var(--secondary);
    }
    
    .stat-card.danger {
        border-top: 4px solid var(--danger);
    }
    
    .stat-card.warning {
        border-top: 4px solid var(--warning);
    }
    
    .stat-card.info {
        border-top: 4px solid var(--info);
    }
    
    .stat-card-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    
    .stat-icon.primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: var(--white);
    }
    
    .stat-icon.secondary {
        background: linear-gradient(135deg, var(--secondary) 0%, #2563eb 100%);
        color: var(--white);
    }
    
    .stat-icon.danger {
        background: linear-gradient(135deg, var(--danger) 0%, #dc2626 100%);
        color: var(--white);
    }
    
    .stat-icon.warning {
        background: linear-gradient(135deg, var(--warning) 0%, #d97706 100%);
        color: var(--white);
    }
    
    .stat-icon.info {
        background: linear-gradient(135deg, var(--info) 0%, #0891b2 100%);
        color: var(--white);
    }
    
    .stat-numbers {
        flex: 1;
        margin-left: 16px;
    }
    
    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: var(--ink);
        line-height: 1.2;
    }
    
    .stat-label {
        font-size: 14px;
        color: var(--muted);
        margin-top: 4px;
        font-weight: 500;
    }
    
    .stat-change {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 12px;
        margin-top: 8px;
        font-weight: 500;
    }
    
    .stat-change.positive {
        color: var(--primary);
    }
    
    .stat-change.negative {
        color: var(--danger);
    }

    /* Charts Section */
    .charts-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }
    
    @media (max-width: 768px) {
        .charts-section {
            grid-template-columns: 1fr;
        }
    }

    /* Chart Card */
    .chart-card {
        background: var(--white);
        border-radius: var(--radius);
        padding: 24px;
        box-shadow: var(--shadow);
        border: 1px solid var(--line);
    }
    
    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    
    .chart-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--ink);
    }
    
    .chart-subtitle {
        font-size: 14px;
        color: var(--muted);
    }
    
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }

    /* Tables Section */
    .tables-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }
    
    @media (max-width: 768px) {
        .tables-section {
            grid-template-columns: 1fr;
        }
    }

    /* Table Card */
    .table-card {
        background: var(--white);
        border-radius: var(--radius);
        padding: 24px;
        box-shadow: var(--shadow);
        border: 1px solid var(--line);
        overflow: hidden;
    }
    
    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .table-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--ink);
    }
    
    .table-view-all {
        font-size: 14px;
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition);
    }
    
    .table-view-all:hover {
        color: var(--primary-dark);
    }
    
    .table-responsive {
        overflow-x: auto;
    }
    
    .table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .table thead {
        background-color: var(--primary-light);
    }
    
    .table th {
        padding: 12px 16px;
        text-align: left;
        font-size: 13px;
        font-weight: 600;
        color: var(--primary-dark);
        border-bottom: 2px solid var(--line);
        white-space: nowrap;
    }
    
    .table tbody tr {
        border-bottom: 1px solid var(--line);
        transition: var(--transition);
    }
    
    .table tbody tr:hover {
        background-color: var(--hover-bg);
    }
    
    .table td {
        padding: 14px 16px;
        font-size: 14px;
        color: var(--ink);
        vertical-align: middle;
    }
    
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-align: center;
        min-width: 80px;
    }
    
    .status-badge.pending {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .status-badge.dijemput {
        background-color: #dbeafe;
        color: #1e40af;
    }
    
    .status-badge.selesai {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .status-badge.ditolak {
        background-color: #fee2e2;
        color: #991b1b;
    }

    /* Progress Bars */
    .progress-container {
        margin-top: 8px;
    }
    
    .progress-label {
        display: flex;
        justify-content: space-between;
        margin-bottom: 4px;
        font-size: 12px;
        color: var(--muted);
    }
    
    .progress-bar {
        height: 6px;
        background-color: var(--line);
        border-radius: 3px;
        overflow: hidden;
    }
    
    .progress-fill {
        height: 100%;
        border-radius: 3px;
        transition: width 0.3s ease;
    }
    
    .progress-fill.primary {
        background: linear-gradient(90deg, var(--primary) 0%, var(--primary-dark) 100%);
    }
    
    .progress-fill.secondary {
        background: linear-gradient(90deg, var(--secondary) 0%, #2563eb 100%);
    }
    
    .progress-fill.danger {
        background: linear-gradient(90deg, var(--danger) 0%, #dc2626 100%);
    }
    
    .progress-fill.warning {
        background: linear-gradient(90deg, var(--warning) 0%, #d97706 100%);
    }

    /* Quick Stats */
    .quick-stats {
        background: var(--white);
        border-radius: var(--radius);
        padding: 24px;
        box-shadow: var(--shadow);
        border: 1px solid var(--line);
        margin-bottom: 32px;
    }
    
    .quick-stats-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--ink);
        margin-bottom: 20px;
    }
    
    .quick-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }
    
    .quick-stat-item {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .quick-stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        background: var(--primary-light);
        color: var(--primary);
    }
    
    .quick-stat-content h4 {
        font-size: 16px;
        font-weight: 600;
        color: var(--ink);
        margin-bottom: 2px;
    }
    
    .quick-stat-content p {
        font-size: 12px;
        color: var(--muted);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }
    
    .empty-state i {
        font-size: 48px;
        color: var(--line);
        margin-bottom: 16px;
    }
    
    .empty-state h3 {
        font-size: 18px;
        color: var(--ink);
        margin-bottom: 8px;
    }
    
    .empty-state p {
        color: var(--muted);
        font-size: 14px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 16px;
        }
        
        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }
        
        .stat-card {
            padding: 20px;
        }
        
        .stat-value {
            font-size: 24px;
        }
        
        .charts-section,
        .tables-section {
            gap: 16px;
        }
        
        .chart-card,
        .table-card {
            padding: 20px;
        }
        
        .chart-container {
            height: 250px;
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .stat-card-content {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .stat-numbers {
            margin-left: 0;
            margin-top: 16px;
            width: 100%;
        }
        
        .chart-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
    }
</style>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="dashboard-container">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1>Dashboard Admin</h1>
        <p>Selamat datang! Berikut adalah ringkasan aktivitas sistem pengelolaan sampah.</p>
    </div>

    <!-- Quick Stats (Today) -->
    <div class="quick-stats">
        <h3 class="quick-stats-title">Statistik Hari Ini</h3>
        <div class="quick-stats-grid">
            <div class="quick-stat-item">
                <div class="quick-stat-icon">
                    <i class="fa-solid fa-recycle"></i>
                </div>
                <div class="quick-stat-content">
                    <h4>{{ $todaySetoran }}</h4>
                    <p>Setoran Hari Ini</p>
                </div>
            </div>
            <div class="quick-stat-item">
                <div class="quick-stat-icon">
                    <i class="fa-solid fa-money-bill-wave"></i>
                </div>
                <div class="quick-stat-content">
                    <h4>Rp {{ number_format($todayRevenue, 0, ',', '.') }}</h4>
                    <p>Pendapatan Hari Ini</p>
                </div>
            </div>
            <div class="quick-stat-item">
                <div class="quick-stat-icon">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
                <div class="quick-stat-content">
                    <h4>{{ $todayUsers }}</h4>
                    <p>Pengguna Baru</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Stats Grid -->
    <div class="stats-grid">
        <!-- Total Users -->
        <div class="stat-card primary">
            <div class="stat-card-content">
                <div class="stat-icon primary">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div class="stat-numbers">
                    <div class="stat-value">{{ $totalUsers }}</div>
                    <div class="stat-label">Total Pengguna</div>
                    <div class="stat-change positive">
                        <i class="fa-solid fa-arrow-up"></i>
                        <span>{{ $totalNasabah }} Nasabah</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Setoran -->
        <div class="stat-card secondary">
            <div class="stat-card-content">
                <div class="stat-icon secondary">
                    <i class="fa-solid fa-truck"></i>
                </div>
                <div class="stat-numbers">
                    <div class="stat-value">{{ $totalSetoran }}</div>
                    <div class="stat-label">Total Setoran</div>
                    <div class="stat-change positive">
                        <i class="fa-solid fa-arrow-up"></i>
                        <span>{{ $totalSetoranSelesai }} Selesai</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="stat-card warning">
            <div class="stat-card-content">
                <div class="stat-icon warning">
                    <i class="fa-solid fa-money-bill-trend-up"></i>
                </div>
                <div class="stat-numbers">
                    <div class="stat-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                    <div class="stat-label">Total Pendapatan</div>
                    <div class="stat-change positive">
                        <i class="fa-solid fa-arrow-up"></i>
                        <span>Rp {{ number_format($monthlyRevenue, 0, ',', '.') }} Bulan Ini</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kategori & Jenis -->
        <div class="stat-card info">
            <div class="stat-card-content">
                <div class="stat-icon info">
                    <i class="fa-solid fa-tags"></i>
                </div>
                <div class="stat-numbers">
                    <div class="stat-value">{{ $totalJenisSampah }}</div>
                    <div class="stat-label">Jenis Sampah</div>
                    <div class="stat-change positive">
                        <i class="fa-solid fa-layer-group"></i>
                        <span>{{ $totalKategori }} Kategori</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-section">
        <!-- Setoran Status Distribution -->
        <div class="chart-card">
            <div class="chart-header">
                <div>
                    <h3 class="chart-title">Distribusi Status Setoran</h3>
                    <p class="chart-subtitle">Persentase berdasarkan status</p>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- User Role Distribution -->
        <div class="chart-card">
            <div class="chart-header">
                <div>
                    <h3 class="chart-title">Distribusi Peran Pengguna</h3>
                    <p class="chart-subtitle">Jumlah pengguna berdasarkan peran</p>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="roleChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tables Section -->
    <div class="tables-section">
        <!-- Recent Setoran -->
        <div class="table-card">
            <div class="table-header">
                <h3 class="table-title">Setoran Terbaru</h3>
               
            </div>
            <div class="table-responsive">
                @if($recentSetoran->count() > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nasabah</th>
                                <th>Petugas</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentSetoran as $setoran)
                            <tr>
                                <td>#{{ str_pad($setoran->id, 6, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $setoran->user->name ?? 'Tidak Diketahui' }}</td>
                                <td>{{ $setoran->petugas->name ?? 'Belum Ditugaskan' }}</td>
                                <td>
                                    <span class="status-badge {{ $setoran->status }}">
                                        {{ ucfirst($setoran->status) }}
                                    </span>
                                </td>
                                <td>{{ $setoran->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <i class="fa-solid fa-clipboard-list"></i>
                        <h3>Tidak Ada Setoran</h3>
                        <p>Belum ada data setoran sampah.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Top Kategori -->
        <div class="table-card">
            <div class="table-header">
                <h3 class="table-title">Kategori Populer</h3>
                <a href="{{ route('kategori_sampah.index') }}" class="table-view-all">
                    Lihat Semua <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
            <div class="table-responsive">
                @if($topKategori->count() > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th>Transaksi</th>
                                <th>Total Berat</th>
                                <th>Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topKategori as $kategori)
                            <tr>
                                <td>
                                    <div class="font-medium">{{ $kategori->nama_sampah }}</div>
                                    <div class="text-xs text-muted">{{ $kategori->masterKategori->nama_kategori ?? 'Tidak ada' }}</div>
                                </td>
                                <td>{{ $kategori->jumlah_transaksi ?? 0 }}</td>
                                <td>{{ number_format($kategori->total_berat ?? 0, 2) }} kg</td>
                                <td>Rp {{ number_format($kategori->total_pendapatan ?? 0, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <i class="fa-solid fa-tags"></i>
                        <h3>Tidak Ada Kategori</h3>
                        <p>Belum ada data kategori sampah.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Setoran Progress Bars -->
    <div class="chart-card">
        <div class="chart-header">
            <h3 class="chart-title">Progress Setoran</h3>
            <p class="chart-subtitle">Distribusi berdasarkan status</p>
        </div>
        <div style="padding: 20px 0;">
            @php
                $statuses = [
                    'pending' => ['label' => 'Pending', 'color' => 'warning', 'count' => $totalSetoranPending],
                    'dijemput' => ['label' => 'Dijemput', 'color' => 'secondary', 'count' => $totalSetoranDijemput],
                    'selesai' => ['label' => 'Selesai', 'color' => 'primary', 'count' => $totalSetoranSelesai],
                    'ditolak' => ['label' => 'Ditolak', 'color' => 'danger', 'count' => $totalSetoranDitolak],
                ];
                $totalAll = array_sum(array_column($statuses, 'count'));
            @endphp
            
            @foreach($statuses as $status => $data)
                @if($totalAll > 0)
                    @php
                        $percentage = $totalAll > 0 ? ($data['count'] / $totalAll) * 100 : 0;
                    @endphp
                    <div class="progress-container">
                        <div class="progress-label">
                            <span>{{ $data['label'] }}</span>
                            <span>{{ $data['count'] }} ({{ number_format($percentage, 1) }}%)</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill {{ $data['color'] }}" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Status Distribution Chart (Doughnut)
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        const statusChart = new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Dijemput', 'Selesai', 'Ditolak'],
                datasets: [{
                    data: [
                        {{ $setoranStatus['pending'] }},
                        {{ $setoranStatus['dijemput'] }},
                        {{ $setoranStatus['selesai'] }},
                        {{ $setoranStatus['ditolak'] }}
                    ],
                    backgroundColor: [
                        '#f59e0b', // warning
                        '#3b82f6', // secondary
                        '#10b981', // primary
                        '#ef4444'  // danger
                    ],
                    borderWidth: 0,
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.raw + ' setoran';
                                return label;
                            }
                        }
                    }
                }
            }
        });

        // User Role Distribution Chart (Bar)
        const roleCtx = document.getElementById('roleChart').getContext('2d');
        const roleChart = new Chart(roleCtx, {
            type: 'bar',
            data: {
                labels: ['Admin', 'Petugas', 'Nasabah'],
                datasets: [{
                    label: 'Jumlah Pengguna',
                    data: [
                        {{ $userRoleDistribution['admin'] }},
                        {{ $userRoleDistribution['petugas'] }},
                        {{ $userRoleDistribution['user'] }}
                    ],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(139, 92, 246, 0.7)'
                    ],
                    borderColor: [
                        'rgb(16, 185, 129)',
                        'rgb(59, 130, 246)',
                        'rgb(139, 92, 246)'
                    ],
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        },
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Update chart on window resize
        window.addEventListener('resize', function() {
            statusChart.resize();
            roleChart.resize();
        });

       

        // Format number function
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    });
</script>
@endpush
