@extends('layouts.admin')

@section('title', 'Data Kategori Sampah')

@push('styles')
<style>
    /* ===== DATA SAMPAH PAGE STYLES ===== */
    .data-sampah-page {
        min-height: calc(100vh - 100px);
    }

    /* Page Header */
    .data-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 32px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--line);
        flex-wrap: wrap;
        gap: 16px;
    }
    
    .data-header .page-title {
        font-size: 28px;
        margin-bottom: 4px;
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .data-header .page-subtitle {
        font-size: 15px;
        color: var(--muted);
        max-width: 600px;
        line-height: 1.6;
    }

    /* Action Button */
    .btn-master {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        border-radius: var(--radius);
        background: var(--primary-light);
        color: var(--primary-dark);
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        border: 1px solid var(--primary);
        transition: var(--transition);
    }
    
    .btn-master:hover {
        background: var(--primary);
        color: var(--white);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(16, 185, 129, 0.2);
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
    .data-card {
        background: var(--white);
        border: 1px solid var(--line);
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        margin-bottom: 32px;
    }

    /* Toolbar */
    .data-toolbar {
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
    
    /* Data Table */
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
        padding: 20px;
        vertical-align: middle;
        color: var(--ink);
        font-size: 14px;
    }
    
    .data-table .row-number {
        color: var(--muted);
        font-weight: 500;
        font-variant-numeric: tabular-nums;
    }

    /* Image Thumbnail */
    .image-thumbnail {
        width: 60px;
        height: 60px;
        border-radius: var(--radius-sm);
        border: 1px solid var(--line);
        overflow: hidden;
        background: var(--bg);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .image-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .image-thumbnail.no-image {
        background: var(--primary-light);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    /* Category Badge */
    .category-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        background: var(--bg);
        color: var(--ink);
        font-weight: 500;
        font-size: 13px;
        border: 1px solid var(--line);
    }
    
    .category-badge i {
        color: var(--primary);
        font-size: 12px;
    }

    /* Price Cell */
    .price-cell {
        font-weight: 600;
        color: var(--primary-dark);
        font-variant-numeric: tabular-nums;
    }

    /* Unit Cell */
    .unit-cell {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: var(--radius-sm);
        background: var(--bg);
        color: var(--ink);
        font-weight: 500;
        font-size: 13px;
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

    /* Empty State */
    .empty-state {
        padding: 80px 20px;
        text-align: center;
        background: var(--bg);
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
        .data-header {
            flex-direction: column;
            align-items: stretch;
        }
        
        .data-toolbar {
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
        
        .data-table th,
        .data-table td {
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
    }

    @media (max-width: 576px) {
        .page-title {
            font-size: 24px;
        }
        
        .btn-add,
        .btn-master {
            width: 100%;
            justify-content: center;
        }
        
        .image-thumbnail {
            width: 50px;
            height: 50px;
        }
        
        .price-cell,
        .unit-cell {
            font-size: 12px;
        }
        
        .data-table {
            min-width: 600px;
        }
    }
</style>
@endpush

@section('content')
<div class="data-sampah-page">
    <!-- Page Header -->
    <div class="data-header">
        <div>
            <h1 class="page-title">Data Kategori Sampah</h1>
            <p class="page-subtitle">Kelola jenis sampah, kategori, harga, dan gambar referensi untuk sistem setoran sampah.</p>
        </div>
        
        <a href="{{ route('master_kategori_sampah.index') }}" class="btn-master">
            <i class="fa-solid fa-layer-group"></i>
            <span>Master Kategori</span>
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert-success">
            <i class="fa-solid fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Main Card -->
    <div class="data-card">
        <!-- Toolbar -->
        <div class="data-toolbar">
            <div class="toolbar-left">
                <a href="{{ route('kategori_sampah.create') }}" class="btn-add">
                    <i class="fa-solid fa-plus"></i>
                    <span>Tambah Kategori Sampah</span>
                </a>
            </div>
            
            <div class="toolbar-right">
                <form method="GET" action="{{ route('kategori_sampah.index') }}" class="search-form">
                    <input type="text" 
                           name="q" 
                           value="{{ $q }}" 
                           class="search-input" 
                           placeholder="Cari nama sampah atau kategori..." 
                           aria-label="Search">
                    
                    <button type="submit" class="btn-search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>Cari</span>
                    </button>
                    
                    @if($q)
                        <a href="{{ route('kategori_sampah.index') }}" class="btn-reset">
                            <i class="fa-solid fa-rotate-left"></i>
                            <span>Reset</span>
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Gambar</th>
                        <th>Nama Sampah</th>
                        <th>Kategori</th>
                        <th>Harga Satuan</th>
                        <th>Satuan</th>
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
                            <div class="image-thumbnail {{ !$item->gambar_sampah ? 'no-image' : '' }}">
                                @if($item->gambar_sampah)
                                    <img src="{{ asset('storage/'.$item->gambar_sampah) }}" 
                                         alt="{{ $item->nama_sampah }}"
                                         loading="lazy">
                                @else
                                    <i class="fa-solid fa-image"></i>
                                @endif
                            </div>
                        </td>
                        
                        <td>
                            <div style="font-weight: 600; color: var(--ink); margin-bottom: 4px;">
                                {{ $item->nama_sampah }}
                            </div>
                            @if($item->deskripsi)
                            <div style="font-size: 13px; color: var(--muted);">
                                {{ Str::limit($item->deskripsi, 50) }}
                            </div>
                            @endif
                        </td>
                        
                        <td>
                            @if($item->masterKategori)
                            <div class="category-badge">
                                <i class="fa-solid fa-tag"></i>
                                <span>{{ $item->masterKategori->nama_kategori }}</span>
                            </div>
                            @else
                            <span style="color: var(--muted); font-style: italic;">-</span>
                            @endif
                        </td>
                        
                        <td class="price-cell">
                            @if($item->harga_satuan !== null)
                                Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                            @else
                                <span style="color: var(--muted);">-</span>
                            @endif
                        </td>
                        
                        <td>
                            <div class="unit-cell">
                                @if($item->jenis_satuan)
                                    <i class="fa-solid fa-weight-scale"></i>
                                    <span>{{ $item->jenis_satuan }}</span>
                                @else
                                    <span style="color: var(--muted);">-</span>
                                @endif
                            </div>
                        </td>
                        
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('kategori_sampah.edit', $item->id) }}" class="btn-edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>Edit</span>
                                </a>
                                
                                <form method="POST"
                                      action="{{ route('kategori_sampah.destroy', $item->id) }}"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori sampah ini? Gambar dan semua data terkait akan dihapus permanen.')">
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
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fa-solid fa-trash"></i>
                                </div>
                                <div class="empty-text">Belum ada data sampah</div>
                                <div class="empty-subtext">
                                    @if($q)
                                        Tidak ditemukan hasil untuk "{{ $q }}". Coba kata kunci lain atau reset pencarian.
                                    @else
                                        Tambah data sampah pertama Anda untuk mulai mengelola kategori.
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
                                    Hapus Data Sampah
                                </div>
                                <div style="font-size: 14px; color: var(--muted); text-align: center;">
                                    Apakah Anda yakin ingin menghapus kategori sampah ini? Tindakan ini tidak dapat dibatalkan.
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
        
        // Add image preview on hover
        const imageThumbnails = document.querySelectorAll('.image-thumbnail img');
        imageThumbnails.forEach(img => {
            const originalSrc = img.src;
            
            img.addEventListener('mouseenter', function() {
                // Create preview overlay
                const preview = document.createElement('div');
                preview.style.cssText = `
                    position: fixed;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background: rgba(0,0,0,0.8);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    z-index: 10000;
                    padding: 40px;
                `;
                
                preview.innerHTML = `
                    <div style="max-width: 500px; max-height: 500px; width: 100%; height: 100%; position: relative;">
                        <img src="${originalSrc}" style="width: 100%; height: 100%; object-fit: contain; border-radius: var(--radius);">
                        <button style="position: absolute; top: -20px; right: -20px; width: 40px; height: 40px; border-radius: 50%; background: white; border: none; color: var(--ink); font-size: 18px; cursor: pointer; box-shadow: var(--shadow); display: grid; place-items: center;">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </div>
                `;
                
                document.body.appendChild(preview);
                
                // Close preview
                const closeBtn = preview.querySelector('button');
                closeBtn.addEventListener('click', function() {
                    document.body.removeChild(preview);
                });
                
                preview.addEventListener('click', function(e) {
                    if (e.target === preview) {
                        document.body.removeChild(preview);
                    }
                });
            });
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
</script>
@endpush