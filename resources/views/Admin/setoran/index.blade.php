@extends('layouts.admin')

@section('title', 'Monitoring Setoran')

@push('styles')
<style>
    /* ===== PAGE SPECIFIC STYLES ===== */
    .monitoring-page {
        min-height: calc(100vh - 100px);
    }

    /* Page Header Enhancement */
    .page-header-monitoring {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 32px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--line);
        flex-wrap: wrap;
        gap: 16px;
    }
    
    .page-header-monitoring .page-title {
        font-size: 28px;
        margin-bottom: 4px;
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .page-header-monitoring .page-subtitle {
        font-size: 15px;
        color: var(--muted);
        max-width: 600px;
        line-height: 1.6;
    }

    /* Stats Summary Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }
    
    .stat-card {
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: var(--radius);
        padding: 20px;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }
    
    .stat-card:hover {
        box-shadow: var(--shadow);
        transform: translateY(-2px);
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(to bottom, var(--primary) 0%, var(--primary-dark) 100%);
    }
    
    .stat-card .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: var(--ink);
        line-height: 1;
        margin: 8px 0 4px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    
    .stat-card .stat-label {
        font-size: 14px;
        color: var(--muted);
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .stat-card .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: var(--radius);
        display: grid;
        place-items: center;
        background: var(--primary-light);
        color: var(--primary-dark);
        font-size: 18px;
        margin-bottom: 12px;
    }

    /* Filter & Toolbar */
    .filter-toolbar {
        background: var(--white);
        border: 1px solid var(--line);
        border-radius: var(--radius);
        padding: 16px 20px;
        margin-bottom: 24px;
        box-shadow: var(--shadow-sm);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }
    
    .filter-group {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }
    
    .filter-label {
        font-weight: 600;
        color: var(--ink);
        font-size: 14px;
        white-space: nowrap;
    }
    
    .filter-select {
        padding: 10px 14px;
        border: 1px solid var(--line);
        border-radius: var(--radius-sm);
        background: var(--white);
        color: var(--ink);
        font-weight: 500;
        font-size: 14px;
        cursor: pointer;
        min-width: 150px;
        transition: var(--transition);
    }
    
    .filter-select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 12px;
        align-items: center;
    }
    
    .btn-map {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: var(--radius);
        background: var(--primary);
        color: var(--white);
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        border: 1px solid var(--primary);
        transition: var(--transition);
        box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
    }
    
    .btn-map:hover {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
    }
    
    .btn-map i {
        font-size: 16px;
    }

    /* Data Table */
    .data-table-container {
        background: var(--white);
        border: 1px solid var(--line);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        margin-bottom: 32px;
        max-height: 500px;
        overflow-y: auto;
    }
    
    .data-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }
    
    .data-table thead {
        position: sticky;
        top: 0;
        z-index: 10;
    }
    
    .data-table thead tr {
        background: var(--primary-light);
        border-bottom: 2px solid var(--primary);
    }
    
    .data-table th {
        padding: 16px 20px;
        text-align: left;
        font-weight: 600;
        color: var(--primary-dark);
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        white-space: nowrap;
    }
    
    .data-table tbody tr {
        border-bottom: 1px solid var(--line);
        transition: var(--transition);
    }
    
    .data-table tbody tr:hover {
        background: var(--hover-bg);
    }
    
    .data-table td {
        padding: 16px 20px;
        vertical-align: middle;
        color: var(--ink);
        font-size: 14px;
    }
    
    .data-table .user-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .data-table .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--primary-light);
        display: grid;
        place-items: center;
        color: var(--primary-dark);
        font-weight: 600;
        font-size: 14px;
        flex: 0 0 auto;
    }

    /* Badge Styles */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 12px;
        letter-spacing: 0.02em;
        border: 1px solid transparent;
        white-space: nowrap;
    }
    
    .badge-pickup {
        background: #f0fdf4;
        color: #166534;
        border-color: #bbf7d0;
    }
    
    .badge-dropoff {
        background: #eff6ff;
        color: #1e40af;
        border-color: #bfdbfe;
    }
    
    .badge-processing {
        background: #fef3c7;
        color: #92400e;
        border-color: #fde68a;
    }
    
    .badge-completed {
        background: #f0fdf4;
        color: #166534;
        border-color: #bbf7d0;
    }
    
    .badge-cancelled {
        background: #fef2f2;
        color: #991b1b;
        border-color: #fecaca;
    }

    /* Action Buttons in Table */
    .action-cell {
        display: flex;
        gap: 8px;
    }
    
    .btn-detail {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: var(--radius-sm);
        background: transparent;
        border: 1px solid var(--line);
        color: var(--ink);
        font-weight: 500;
        font-size: 13px;
        text-decoration: none;
        transition: var(--transition);
        white-space: nowrap;
    }
    
    .btn-detail:hover {
        background: var(--primary);
        border-color: var(--primary);
        color: var(--white);
    }
    
    .btn-detail i {
        font-size: 12px;
    }

    /* Empty State */
    .empty-state {
        padding: 60px 20px;
        text-align: center;
        background: var(--bg);
        border-radius: var(--radius);
    }
    
    .empty-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        border-radius: 50%;
        background: var(--primary-light);
        display: grid;
        place-items: center;
        color: var(--primary);
        font-size: 32px;
    }
    
    .empty-text {
        font-size: 16px;
        color: var(--muted);
        margin-bottom: 8px;
        font-weight: 500;
    }
    
    .empty-subtext {
        font-size: 14px;
        color: var(--muted);
        max-width: 400px;
        margin: 0 auto;
    }

    /* Pagination Styling */
    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        border-top: 1px solid var(--line);
        background: var(--white);
        border-radius: 0 0 var(--radius) var(--radius);
        flex-wrap: wrap;
        gap: 16px;
    }
    
    .pagination-info {
        font-size: 14px;
        color: var(--muted);
        font-weight: 500;
    }
    
    .pagination {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    
    .pagination .page-link,
    .pagination a,
    .pagination span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 12px;
        border-radius: var(--radius-sm);
        border: 1px solid var(--line);
        background: var(--white);
        color: var(--ink);
        font-weight: 500;
        font-size: 14px;
        text-decoration: none;
        transition: var(--transition);
    }
    
    .pagination .page-item.active .page-link,
    .pagination .active span {
        background: var(--primary);
        border-color: var(--primary);
        color: var(--white);
    }
    
    .pagination .page-link:hover:not(.active) {
        background: var(--hover-bg);
        border-color: var(--primary);
        color: var(--primary);
    }
    
    .pagination .disabled span {
        background: var(--bg);
        color: var(--muted);
        cursor: not-allowed;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .page-header-monitoring {
            flex-direction: column;
            align-items: stretch;
        }
        
        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
        }
        
        .filter-toolbar {
            flex-direction: column;
            align-items: stretch;
        }
        
        .filter-group {
            flex-direction: column;
            align-items: stretch;
        }
        
        .filter-select {
            width: 100%;
        }
        
        .action-buttons {
            width: 100%;
            justify-content: flex-start;
        }
        
        .data-table-container {
            margin-left: -16px;
            margin-right: -16px;
            border-radius: 0;
            border-left: none;
            border-right: none;
        }
        
        .pagination-wrapper {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .data-table th,
        .data-table td {
            padding: 12px 16px;
        }
        
        .action-cell {
            flex-direction: column;
            gap: 6px;
        }
        
        .btn-detail {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="monitoring-page">
    <!-- Page Header -->
    <div class="page-header-monitoring">
        <div>
            <h1 class="page-title">Monitoring Setoran</h1>
            <p class="page-subtitle">Pantau semua setoran sampah, status pengambilan, dan kinerja petugas dalam satu dashboard terpusat.</p>
        </div>
        
        <a href="{{ route('admin.map') }}" class="btn-map">
            <i class="fa-solid fa-map-location-dot"></i>
            <span>Lihat Peta Setoran</span>
        </a>
    </div>

    <!-- Stats Summary -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-box-archive"></i>
            </div>
            <div class="stat-label">
                <span>Total Setoran</span>
                <i class="fa-solid fa-circle-info" title="Jumlah setoran keseluruhan"></i>
            </div>
            <div class="stat-value">{{ $totalSetoran ?? 0 }}</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-spinner"></i>
            </div>
            <div class="stat-label">
                <span>Dalam Proses</span>
                <i class="fa-solid fa-circle-info" title="Setoran yang sedang diproses"></i>
            </div>
            <div class="stat-value">{{ $inProcess ?? 0 }}</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-check-circle"></i>
            </div>
            <div class="stat-label">
                <span>Selesai</span>
                <i class="fa-solid fa-circle-info" title="Setoran yang sudah selesai"></i>
            </div>
            <div class="stat-value">{{ $completed ?? 0 }}</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fa-solid fa-coins"></i>
            </div>
            <div class="stat-label">
                <span>Estimasi Nilai</span>
                <i class="fa-solid fa-circle-info" title="Total estimasi nilai setoran"></i>
            </div>
            <div class="stat-value">Rp {{ number_format($totalValue ?? 0) }}</div>
        </div>
    </div>

    <!-- Filter Toolbar -->
    <div class="filter-toolbar">
        <div class="filter-group">
            <span class="filter-label">Filter Data:</span>
            
            <select class="filter-select" id="filterStatus">
                <option value="">Semua Status</option>
                <option value="menunggu">Menunggu</option>
                <option value="diproses">Diproses</option>
                <option value="selesai">Selesai</option>
                <option value="dibatalkan">Dibatalkan</option>
            </select>
            
            <select class="filter-select" id="filterMetode">
                <option value="">Semua Metode</option>
                <option value="jemput">Penjemputan</option>
                <option value="antar">Antar Sendiri</option>
            </select>
            
            <select class="filter-select" id="filterPetugas">
                <option value="">Semua Petugas</option>
                @foreach($petugasList ?? [] as $petugas)
                <option value="{{ $petugas->id }}">{{ $petugas->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="action-buttons">
            <button type="button" class="btn-detail" id="btnResetFilter">
                <i class="fa-solid fa-rotate-right"></i>
                <span>Reset Filter</span>
            </button>
            
            <button type="button" class="btn-detail" id="btnExport">
                <i class="fa-solid fa-file-export"></i>
                <span>Export Data</span>
            </button>
        </div>
    </div>

    <!-- Data Table -->
    <div class="data-table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pengguna</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Petugas</th>
                    <th>Total Estimasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $it)
                <tr>
                    <td class="nowrap">{{ $loop->iteration + ($items->currentPage()-1) * $items->perPage() }}</td>
                    
                    <td>
                        <div class="user-cell">
                            <div class="user-avatar">
                                {{ substr($it->user->name ?? 'U', 0, 1) }}
                            </div>
                            <div>
                                <div style="font-weight: 600;">{{ $it->user->name ?? '-' }}</div>
                                <div style="font-size: 12px; color: var(--muted);">{{ $it->created_at->format('d M Y') }}</div>
                            </div>
                        </div>
                    </td>
                    
                    <td>
                        @if($it->metode == 'jemput')
                        <span class="badge badge-pickup">
                            <i class="fa-solid fa-truck-pickup"></i>
                            Jemput
                        </span>
                        @else
                        <span class="badge badge-dropoff">
                            <i class="fa-solid fa-box"></i>
                            Antar
                        </span>
                        @endif
                    </td>
                    
                    <td>
                        @if($it->status == 'menunggu')
                        <span class="badge badge-processing">
                            <i class="fa-solid fa-clock"></i>
                            Menunggu
                        </span>
                        @elseif($it->status == 'diproses')
                        <span class="badge badge-processing">
                            <i class="fa-solid fa-spinner"></i>
                            Diproses
                        </span>
                        @elseif($it->status == 'selesai')
                        <span class="badge badge-completed">
                            <i class="fa-solid fa-check-circle"></i>
                            Selesai
                        </span>
                        @else
                        <span class="badge badge-cancelled">
                            <i class="fa-solid fa-times-circle"></i>
                            Dibatalkan
                        </span>
                        @endif
                    </td>
                    
                    <td>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            @if($it->petugas)
                            <div style="width: 28px; height: 28px; border-radius: 50%; background: var(--primary-light); display: grid; place-items: center; font-size: 12px; color: var(--primary-dark); font-weight: 600;">
                                {{ substr($it->petugas->name, 0, 1) }}
                            </div>
                            <span>{{ $it->petugas->name }}</span>
                            @else
                            <span style="color: var(--muted);">Belum ditugaskan</span>
                            @endif
                        </div>
                    </td>
                    
                    <td class="nowrap" style="font-weight: 600; color: var(--primary-dark);">
                        Rp {{ number_format($it->estimasi_total) }}
                    </td>
                    
                    <td>
                        <div class="action-cell">
                            <a href="{{ route('admin.setoran.show', $it->id) }}" class="btn-detail">
                                <i class="fa-solid fa-eye"></i>
                                <span>Detail</span>
                            </a>
                            
                            @if($it->status == 'menunggu')
                            <a href="{{ route('admin.setoran.edit', $it->id) }}" class="btn-detail" style="background: var(--primary-light); border-color: var(--primary-light); color: var(--primary-dark);">
                                <i class="fa-solid fa-edit"></i>
                                <span>Proses</span>
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fa-solid fa-box-open"></i>
                            </div>
                            <div class="empty-text">Belum ada data setoran</div>
                            <div class="empty-subtext">Setoran yang dilakukan oleh pengguna akan muncul di sini</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination-wrapper">
        <div class="pagination-info">
            Menampilkan {{ $items->firstItem() ?? 0 }} - {{ $items->lastItem() ?? 0 }} dari {{ $items->total() }} data setoran
        </div>
        
        <div class="pagination">
            {{ $items->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter functionality
        const filterStatus = document.getElementById('filterStatus');
        const filterMetode = document.getElementById('filterMetode');
        const filterPetugas = document.getElementById('filterPetugas');
        const btnResetFilter = document.getElementById('btnResetFilter');
        const btnExport = document.getElementById('btnExport');
        
        // Apply filters on change
        [filterStatus, filterMetode, filterPetugas].forEach(filter => {
            filter?.addEventListener('change', function() {
                applyFilters();
            });
        });
        
        // Reset filters
        btnResetFilter?.addEventListener('click', function() {
            filterStatus.value = '';
            filterMetode.value = '';
            filterPetugas.value = '';
            applyFilters();
        });
        
        // Export functionality
        btnExport?.addEventListener('click', function() {
            // Implement export logic here
            alert('Fitur export akan mengunduh data dalam format Excel.');
        });
        
        function applyFilters() {
            const params = new URLSearchParams(window.location.search);
            
            if (filterStatus.value) params.set('status', filterStatus.value);
            else params.delete('status');
            
            if (filterMetode.value) params.set('metode', filterMetode.value);
            else params.delete('metode');
            
            if (filterPetugas.value) params.set('petugas', filterPetugas.value);
            else params.delete('petugas');
            
            // Reset to page 1 when filtering
            params.set('page', '1');
            
            window.location.href = `${window.location.pathname}?${params.toString()}`;
        }
        
        // Preselect filters from URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('status')) filterStatus.value = urlParams.get('status');
        if (urlParams.get('metode')) filterMetode.value = urlParams.get('metode');
        if (urlParams.get('petugas')) filterPetugas.value = urlParams.get('petugas');
        
        // Add subtle animation to table rows
        const tableRows = document.querySelectorAll('.data-table tbody tr');
        tableRows.forEach((row, index) => {
            row.style.animationDelay = `${index * 0.05}s`;
            row.style.animation = 'fadeInUp 0.4s ease-out forwards';
            row.style.opacity = '0';
        });
        
        // Add CSS animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);
        
        // Search functionality integration
        const globalSearch = document.getElementById('globalSearch');
        if (globalSearch) {
            const urlSearch = urlParams.get('q');
            if (urlSearch) {
                globalSearch.value = urlSearch;
            }
        }
    });
</script>
@endpush