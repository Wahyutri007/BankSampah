@extends('layouts.admin')

@section('title', 'Master Kategori Sampah')

@push('styles')
<style>
    /* ===== MASTER CATEGORY PAGE STYLES ===== */
    .master-category-page {
        min-height: calc(100vh - 100px);
    }

    /* Page Header */
    .master-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 32px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--line);
        flex-wrap: wrap;
        gap: 16px;
    }
    
    .master-header .page-title {
        font-size: 28px;
        margin-bottom: 4px;
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .master-header .page-subtitle {
        font-size: 15px;
        color: var(--muted);
        max-width: 600px;
        line-height: 1.6;
    }

    /* Back Button */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        border-radius: var(--radius);
        background: var(--white);
        color: var(--ink);
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        border: 1px solid var(--line);
        transition: var(--transition);
    }
    
    .btn-back:hover {
        background: var(--hover-bg);
        border-color: var(--primary);
        color: var(--primary);
    }

    /* Success Alert */
    .alert-success {
        background: var(--primary-light);
        border: 1px solid rgba(16, 185, 129, 0.3);
        border-radius: var(--radius);
        padding: 16px 20px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        color: var(--primary-dark);
        font-weight: 500;
        animation: slideIn 0.3s ease-out;
    }
    
    .alert-success i {
        color: var(--primary);
        font-size: 18px;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Main Card */
    .master-card {
        background: var(--white);
        border: 1px solid var(--line);
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        margin-bottom: 32px;
    }

    /* Toolbar */
    .master-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 24px;
        border-bottom: 1px solid var(--line);
        background: var(--white);
        flex-wrap: wrap;
        gap: 16px;
    }
    
    .toolbar-left,
    .toolbar-right {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    /* Add Button */
    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 20px;
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
    
    .btn-add:hover {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
    }

    /* Filter Badge */
    .filter-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 20px;
        background: var(--primary-light);
        color: var(--primary-dark);
        font-weight: 600;
        font-size: 13px;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    
    .filter-badge i {
        font-size: 12px;
    }

    /* Search Form */
    .search-form {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    
    .search-input {
        padding: 10px 16px;
        border: 1px solid var(--line);
        border-radius: var(--radius-sm);
        background: var(--white);
        color: var(--ink);
        font-size: 14px;
        min-width: 250px;
        transition: var(--transition);
    }
    
    .search-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
    
    .search-input::placeholder {
        color: var(--muted);
    }
    
    .btn-search {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: var(--radius-sm);
        background: var(--bg);
        color: var(--ink);
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        border: 1px solid var(--line);
        transition: var(--transition);
        cursor: pointer;
    }
    
    .btn-search:hover {
        background: var(--hover-bg);
        border-color: var(--primary);
        color: var(--primary);
    }
    
    .btn-reset {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: var(--radius-sm);
        background: transparent;
        color: var(--muted);
        font-weight: 500;
        font-size: 14px;
        text-decoration: none;
        border: 1px solid transparent;
        transition: var(--transition);
        cursor: pointer;
    }
    
    .btn-reset:hover {
        color: var(--primary);
        background: var(--primary-light);
    }

    /* Table Container */
    .table-container {
        overflow-x: auto;
        max-height: 500px;
        overflow-y: auto;
        background: var(--white);
    }
    
    /* Master Table */
    .master-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }
    
    .master-table thead {
        position: sticky;
        top: 0;
        z-index: 10;
    }
    
    .master-table thead tr {
        background: var(--primary-light);
        border-bottom: 2px solid var(--primary);
    }
    
    .master-table th {
        padding: 16px 20px;
        text-align: left;
        font-weight: 600;
        color: var(--primary-dark);
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        white-space: nowrap;
    }
    
    .master-table tbody tr {
        border-bottom: 1px solid var(--line);
        transition: var(--transition);
    }
    
    .master-table tbody tr:hover {
        background: var(--hover-bg);
    }
    
    .master-table td {
        padding: 20px;
        vertical-align: middle;
        color: var(--ink);
        font-size: 14px;
    }
    
    .master-table .row-number {
        color: var(--muted);
        font-weight: 500;
        font-variant-numeric: tabular-nums;
    }

    /* Category Name */
    .category-name {
        font-weight: 600;
        color: var(--ink);
        font-size: 16px;
    }
    
    .category-name i {
        color: var(--primary);
        margin-right: 10px;
        font-size: 18px;
    }

    /* Description Cell */
    .description-cell {
        color: var(--muted);
        line-height: 1.6;
        max-width: 400px;
    }
    
    .description-cell.empty {
        font-style: italic;
        color: var(--muted);
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
        align-items: center;
    }
    
    .btn-edit {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: var(--radius-sm);
        background: var(--primary-light);
        color: var(--primary-dark);
        font-weight: 500;
        font-size: 13px;
        text-decoration: none;
        border: 1px solid var(--primary-light);
        transition: var(--transition);
        white-space: nowrap;
    }
    
    .btn-edit:hover {
        background: var(--primary);
        color: var(--white);
        border-color: var(--primary);
    }
    
    .btn-delete {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: var(--radius-sm);
        background: #fef2f2;
        color: #dc2626;
        font-weight: 500;
        font-size: 13px;
        text-decoration: none;
        border: 1px solid #fecaca;
        transition: var(--transition);
        cursor: pointer;
        white-space: nowrap;
    }
    
    .btn-delete:hover {
        background: #dc2626;
        color: white;
        border-color: #dc2626;
    }

    /* Stats Card */
    .stats-card {
        background: var(--white);
        border: 1px solid var(--line);
        border-radius: var(--radius);
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: var(--shadow-sm);
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }
    
    .stat-item {
        text-align: center;
        padding: 20px;
        background: var(--bg);
        border-radius: var(--radius);
        border: 1px solid var(--line);
        transition: var(--transition);
    }
    
    .stat-item:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow);
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--primary-light);
        display: grid;
        place-items: center;
        margin: 0 auto 12px;
        color: var(--primary);
        font-size: 20px;
    }
    
    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: var(--ink);
        font-family: 'Plus Jakarta Sans', sans-serif;
        line-height: 1;
        margin-bottom: 4px;
    }
    
    .stat-label {
        font-size: 14px;
        color: var(--muted);
        font-weight: 500;
    }

    /* Empty State */
    .empty-state {
        padding: 80px 20px;
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
        font-size: 18px;
        color: var(--muted);
        margin-bottom: 8px;
        font-weight: 600;
    }
    
    .empty-subtext {
        font-size: 14px;
        color: var(--muted);
        max-width: 400px;
        margin: 0 auto;
    }

    /* Footer (Pagination & Info) */
    .table-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 24px;
        border-top: 1px solid var(--line);
        background: var(--white);
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
        .master-header {
            flex-direction: column;
            align-items: stretch;
        }
        
        .master-toolbar {
            flex-direction: column;
            align-items: stretch;
        }
        
        .toolbar-left,
        .toolbar-right {
            width: 100%;
        }
        
        .toolbar-left {
            justify-content: space-between;
        }
        
        .search-form {
            width: 100%;
        }
        
        .search-input {
            flex: 1;
            min-width: 0;
        }
        
        .master-table th,
        .master-table td {
            padding: 12px 16px;
        }
        
        .action-buttons {
            flex-direction: column;
            align-items: stretch;
            gap: 8px;
        }
        
        .btn-edit,
        .btn-delete {
            width: 100%;
            justify-content: center;
        }
        
        .table-footer {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .page-title {
            font-size: 24px;
        }
        
        .btn-add,
        .btn-back {
            width: 100%;
            justify-content: center;
        }
        
        .master-table {
            min-width: 600px;
        }
        
        .category-name {
            font-size: 14px;
        }
        
        .description-cell {
            font-size: 13px;
        }
    }
</style>
@endpush

@section('content')
<div class="master-category-page">
    <!-- Page Header -->
    <div class="master-header">
        <div>
            <h1 class="page-title">Master Kategori Sampah</h1>
            <p class="page-subtitle">Kelola kategori utama sampah seperti Plastik, Kertas, Logam, dll yang digunakan sebagai referensi saat membuat data sampah.</p>
        </div>
        
        <a href="{{ route('kategori_sampah.index') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Data Sampah</span>
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert-success">
            <i class="fa-solid fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Stats Overview -->
    <div class="stats-card">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <div class="stat-value">{{ $items->total() }}</div>
                <div class="stat-label">Total Kategori</div>
            </div>
            
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <div class="stat-value">{{ $activeItems ?? $items->count() }}</div>
                <div class="stat-label">Kategori Aktif</div>
            </div>
            
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fa-solid fa-file-alt"></i>
                </div>
                <div class="stat-value">{{ $itemsWithDescription ?? $items->whereNotNull('deskripsi')->count() }}</div>
                <div class="stat-label">Dengan Deskripsi</div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="master-card">
        <!-- Toolbar -->
        <div class="master-toolbar">
            <div class="toolbar-left">
                <a href="{{ route('master_kategori_sampah.create') }}" class="btn-add">
                    <i class="fa-solid fa-plus"></i>
                    <span>Tambah Kategori Master</span>
                </a>
                
                @if($q)
                    <div class="filter-badge">
                        <i class="fa-solid fa-filter"></i>
                        <span>Filter: "{{ $q }}"</span>
                    </div>
                @endif
            </div>
            
            <div class="toolbar-right">
                <form method="GET" action="{{ route('master_kategori_sampah.index') }}" class="search-form">
                    <input type="text" 
                           name="q" 
                           value="{{ $q }}" 
                           class="search-input" 
                           placeholder="Cari nama kategori..." 
                           aria-label="Search">
                    
                    <button type="submit" class="btn-search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>Cari</span>
                    </button>
                    
                    @if($q)
                        <a href="{{ route('master_kategori_sampah.index') }}" class="btn-reset">
                            <i class="fa-solid fa-rotate-left"></i>
                            <span>Reset</span>
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="table-container">
            <table class="master-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td class="row-number">
                            {{ $loop->iteration + ($items->currentPage()-1) * $items->perPage() }}
                        </td>
                        
                        <td>
                            <div class="category-name">
                                <i class="fa-solid fa-tag"></i>
                                <span>{{ $item->nama_kategori }}</span>
                            </div>
                        </td>
                        
                        <td>
                            <div class="description-cell {{ !$item->deskripsi ? 'empty' : '' }}">
                                @if($item->deskripsi)
                                    {{ Str::limit($item->deskripsi, 100) }}
                                @else
                                    Tidak ada deskripsi
                                @endif
                            </div>
                        </td>
                        
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('master_kategori_sampah.edit', $item->id) }}" class="btn-edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>Edit</span>
                                </a>
                                
                                <form method="POST"
                                      action="{{ route('master_kategori_sampah.destroy', $item->id) }}"
                                      onsubmit="return confirmDelete(event, '{{ addslashes($item->nama_kategori) }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">
                                        <i class="fa-solid fa-trash"></i>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fa-solid fa-layer-group"></i>
                                </div>
                                <div class="empty-text">Belum ada kategori master</div>
                                <div class="empty-subtext">
                                    @if($q)
                                        Tidak ditemukan hasil untuk "{{ $q }}". Coba kata kunci lain atau reset pencarian.
                                    @else
                                        Tambah kategori master pertama Anda untuk mulai mengorganisir data sampah.
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="table-footer">
            <div class="pagination-info">
                Menampilkan {{ $items->firstItem() ?? 0 }} - {{ $items->lastItem() ?? 0 }} dari {{ $items->total() }} data
            </div>
            
            <div class="pagination">
                {{ $items->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add confirmation for delete buttons
        const deleteForms = document.querySelectorAll('form[action*="destroy"]');
        deleteForms.forEach(form => {
            const button = form.querySelector('button[type="submit"]');
            if (button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Get category name from form onsubmit attribute
                    const formOnsubmit = form.getAttribute('onsubmit');
                    const categoryNameMatch = formOnsubmit.match(/'([^']+)'/);
                    const categoryName = categoryNameMatch ? categoryNameMatch[1] : 'kategori ini';
                    
                    // Create custom confirmation modal
                    const modal = document.createElement('div');
                    modal.style.cssText = `
                        position: fixed;
                        top: 0;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        background: rgba(0,0,0,0.5);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        z-index: 9999;
                        padding: 20px;
                    `;
                    
                    modal.innerHTML = `
                        <div style="background: white; border-radius: var(--radius); padding: 30px; max-width: 400px; width: 100%; box-shadow: var(--shadow-xl);">
                            <div style="margin-bottom: 20px;">
                                <div style="width: 60px; height: 60px; border-radius: 50%; background: #fef2f2; display: grid; place-items: center; margin: 0 auto 16px;">
                                    <i class="fa-solid fa-exclamation-triangle" style="color: #dc2626; font-size: 24px;"></i>
                                </div>
                                <div style="font-size: 18px; font-weight: 600; color: var(--ink); text-align: center; margin-bottom: 8px;">
                                    Hapus Kategori Master
                                </div>
                                <div style="font-size: 14px; color: var(--muted); text-align: center;">
                                    Apakah Anda yakin ingin menghapus kategori <strong>"${categoryName}"</strong>?<br>
                                    <span style="color: #dc2626; font-weight: 600;">Semua data sampah yang menggunakan kategori ini akan terpengaruh!</span>
                                </div>
                            </div>
                            <div style="display: flex; gap: 12px;">
                                <button type="button" id="cancelDelete" style="flex: 1; padding: 12px; border: 1px solid var(--line); background: var(--white); color: var(--ink); border-radius: var(--radius-sm); font-weight: 600; cursor: pointer;">
                                    Batal
                                </button>
                                <button type="button" id="confirmDelete" style="flex: 1; padding: 12px; border: 1px solid #dc2626; background: #dc2626; color: white; border-radius: var(--radius-sm); font-weight: 600; cursor: pointer;">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    `;
                    
                    document.body.appendChild(modal);
                    
                    // Handle cancel
                    modal.querySelector('#cancelDelete').addEventListener('click', function() {
                        document.body.removeChild(modal);
                    });
                    
                    // Handle confirm
                    modal.querySelector('#confirmDelete').addEventListener('click', function() {
                        form.submit();
                    });
                    
                    // Close on overlay click
                    modal.addEventListener('click', function(e) {
                        if (e.target === modal) {
                            document.body.removeChild(modal);
                        }
                    });
                });
            }
        });
        
        // Search input focus
        const searchInput = document.querySelector('.search-input');
        if (searchInput) {
            searchInput.addEventListener('focus', function() {
                this.parentElement.style.boxShadow = '0 0 0 3px rgba(16, 185, 129, 0.1)';
            });
            
            searchInput.addEventListener('blur', function() {
                this.parentElement.style.boxShadow = '';
            });
            
            // Auto-focus if there's a search query
            if (searchInput.value) {
                setTimeout(() => {
                    searchInput.focus();
                    searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
                }, 100);
            }
        }
        
        // Add subtle animation to table rows
        const tableRows = document.querySelectorAll('.master-table tbody tr');
        tableRows.forEach((row, index) => {
            if (!row.querySelector('.empty-state')) {
                row.style.animationDelay = `${index * 0.05}s`;
                row.style.animation = 'fadeInUp 0.4s ease-out forwards';
                row.style.opacity = '0';
            }
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
        
        // Highlight search results
        if ('{{ $q }}') {
            const searchTerm = '{{ $q }}'.toLowerCase();
            const categoryNames = document.querySelectorAll('.category-name span');
            const descriptions = document.querySelectorAll('.description-cell');
            
            // Highlight matching text in category names
            categoryNames.forEach(element => {
                const text = element.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    element.parentElement.style.backgroundColor = 'var(--primary-light)';
                    element.parentElement.style.padding = '8px 12px';
                    element.parentElement.style.borderRadius = '8px';
                    element.parentElement.style.border = '1px solid var(--primary)';
                }
            });
            
            // Highlight matching text in descriptions
            descriptions.forEach(element => {
                if (!element.classList.contains('empty')) {
                    const text = element.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        element.style.backgroundColor = 'var(--primary-light)';
                        element.style.padding = '8px 12px';
                        element.style.borderRadius = '8px';
                        element.style.border = '1px solid var(--primary)';
                    }
                }
            });
        }
        
        // Auto-hide success message after 5 seconds
        setTimeout(() => {
            const successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                successAlert.style.transition = 'opacity 0.5s ease';
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.remove(), 500);
            }
        }, 5000);
    });
    
    // Confirm delete function for inline onsubmit
    function confirmDelete(event, categoryName) {
        event.preventDefault();
        
        if (confirm(`Apakah Anda yakin ingin menghapus kategori "${categoryName}"?\n\nPERINGATAN: Semua data sampah yang menggunakan kategori ini akan terpengaruh!`)) {
            event.target.form.submit();
        }
        
        return false;
    }
</script>
@endpush