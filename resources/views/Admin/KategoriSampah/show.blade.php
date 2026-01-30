@extends('layouts.admin')

@section('title', 'Detail Kategori Sampah - ' . $item->nama_sampah)

@push('styles')
<style>
    /* ===== DETAIL PAGE STYLES ===== */
    .detail-page {
        min-height: calc(100vh - 100px);
    }

    /* Page Header */
    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 32px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--line);
        flex-wrap: wrap;
        gap: 16px;
    }
    
    .detail-header .page-title {
        font-size: 28px;
        margin-bottom: 4px;
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .detail-header .page-subtitle {
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

    /* Main Content Card */
    .detail-card {
        background: var(--white);
        border: 1px solid var(--line);
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
        padding: 32px;
        margin-bottom: 32px;
        overflow: hidden;
    }
    
    @media (max-width: 768px) {
        .detail-card {
            padding: 24px;
        }
    }

    /* Content Grid */
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 32px;
    }
    
    @media (max-width: 992px) {
        .detail-grid {
            grid-template-columns: 1fr;
            gap: 24px;
        }
    }

    /* Image Section */
    .image-section {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    
    .image-container {
        width: 100%;
        height: 280px;
        border-radius: var(--radius);
        border: 1px solid var(--line);
        background: var(--bg);
        overflow: hidden;
        position: relative;
    }
    
    .image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .image-container img:hover {
        transform: scale(1.02);
    }
    
    .image-container .no-image {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--muted);
        background: var(--primary-light);
    }
    
    .image-container .no-image i {
        font-size: 48px;
        margin-bottom: 12px;
        color: var(--primary);
    }
    
    .image-container .no-image span {
        font-size: 16px;
        font-weight: 600;
    }
    
    .image-meta {
        background: var(--bg);
        border: 1px solid var(--line);
        border-radius: var(--radius);
        padding: 16px;
    }
    
    .meta-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid var(--line);
    }
    
    .meta-item:last-child {
        border-bottom: none;
    }
    
    .meta-label {
        font-size: 13px;
        color: var(--muted);
        font-weight: 500;
    }
    
    .meta-value {
        font-size: 14px;
        color: var(--ink);
        font-weight: 600;
    }

    /* Information Section */
    .info-section {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    /* Info Card */
    .info-card {
        background: var(--bg);
        border: 1px solid var(--line);
        border-radius: var(--radius);
        padding: 20px;
    }
    
    .info-card .card-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--ink);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .info-card .card-title i {
        color: var(--primary);
    }

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
    
    @media (max-width: 576px) {
        .info-grid {
            grid-template-columns: 1fr;
        }
    }
    
    .info-item {
        padding: 12px 0;
        border-bottom: 1px solid var(--line);
    }
    
    .info-item:last-child {
        border-bottom: none;
    }
    
    .info-label {
        font-size: 13px;
        color: var(--muted);
        font-weight: 500;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .info-label i {
        width: 16px;
        text-align: center;
        color: var(--primary);
    }
    
    .info-value {
        font-size: 15px;
        color: var(--ink);
        font-weight: 600;
    }
    
    .info-value.big {
        font-size: 20px;
        color: var(--primary-dark);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    
    .info-value.muted {
        color: var(--muted);
        font-style: italic;
    }

    /* Description Card */
    .description-card {
        background: var(--bg);
        border: 1px solid var(--line);
        border-radius: var(--radius);
        padding: 20px;
        grid-column: 1 / -1;
    }
    
    .description-card .card-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--ink);
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .description-card .card-title i {
        color: var(--primary);
    }
    
    .description-content {
        padding: 12px;
        background: var(--white);
        border-radius: var(--radius-sm);
        border: 1px solid var(--line);
        color: var(--ink);
        line-height: 1.6;
        min-height: 80px;
    }
    
    .description-content.empty {
        color: var(--muted);
        font-style: italic;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Stats Card */
    .stats-card {
        background: var(--bg);
        border: 1px solid var(--line);
        border-radius: var(--radius);
        padding: 20px;
        grid-column: 1 / -1;
    }
    
    .stats-card .card-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--ink);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .stats-card .card-title i {
        color: var(--primary);
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
    }
    
    .stat-item {
        background: var(--white);
        border: 1px solid var(--line);
        border-radius: var(--radius-sm);
        padding: 16px;
        text-align: center;
    }
    
    .stat-label {
        font-size: 13px;
        color: var(--muted);
        font-weight: 500;
        margin-bottom: 8px;
    }
    
    .stat-value {
        font-size: 24px;
        font-weight: 700;
        color: var(--ink);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    
    .stat-unit {
        font-size: 14px;
        color: var(--muted);
        margin-left: 4px;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 16px;
        padding-top: 32px;
        border-top: 1px solid var(--line);
        flex-wrap: wrap;
    }
    
    .btn-edit {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 32px;
        border-radius: var(--radius);
        background: var(--primary);
        color: var(--white);
        font-weight: 600;
        font-size: 16px;
        text-decoration: none;
        border: 1px solid var(--primary);
        transition: var(--transition);
        box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
    }
    
    .btn-edit:hover {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
    }
    
    .btn-delete {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 32px;
        border-radius: var(--radius);
        background: #fef2f2;
        color: #dc2626;
        font-weight: 600;
        font-size: 16px;
        text-decoration: none;
        border: 1px solid #fecaca;
        transition: var(--transition);
        cursor: pointer;
    }
    
    .btn-delete:hover {
        background: #dc2626;
        color: white;
        border-color: #dc2626;
    }

    /* Badge */
    .category-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 20px;
        background: var(--primary-light);
        color: var(--primary-dark);
        font-weight: 600;
        font-size: 14px;
    }
    
    .category-badge i {
        font-size: 14px;
    }

    /* Price Tag */
    .price-tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: var(--radius);
        background: linear-gradient(135deg, var(--primary-light) 0%, #d1fae5 100%);
        color: var(--primary-dark);
        font-weight: 700;
        font-size: 18px;
        border: 2px solid rgba(16, 185, 129, 0.2);
    }
    
    .price-tag i {
        font-size: 16px;
    }

    /* Unit Indicator */
    .unit-indicator {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: var(--radius-sm);
        background: var(--bg);
        color: var(--ink);
        font-weight: 600;
        font-size: 14px;
        border: 1px solid var(--line);
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .detail-header {
            flex-direction: column;
            align-items: stretch;
        }
        
        .btn-back {
            width: 100%;
            justify-content: center;
        }
        
        .detail-grid {
            gap: 20px;
        }
        
        .image-container {
            height: 220px;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-edit,
        .btn-delete {
            width: 100%;
            justify-content: center;
        }
        
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .detail-card {
            padding: 20px;
            margin-left: -16px;
            margin-right: -16px;
            border-radius: 0;
            border-left: none;
            border-right: none;
        }
        
        .detail-header .page-title {
            font-size: 24px;
        }
        
        .image-container {
            height: 180px;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .btn-edit,
        .btn-delete {
            padding: 12px 24px;
            font-size: 15px;
        }
    }
</style>
@endpush

@section('content')
<div class="detail-page">
    <!-- Page Header -->
    <div class="detail-header">
        <div>
            <h1 class="page-title">Detail Kategori Sampah</h1>
            <p class="page-subtitle">Informasi lengkap tentang "{{ $item->nama_sampah }}" dalam sistem.</p>
        </div>
        
        <a href="{{ route('kategori_sampah.index') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    <!-- Main Content Card -->
    <div class="detail-card">
        <div class="detail-grid">
            <!-- Image Section -->
            <div class="image-section">
                <div class="image-container">
                    @if($item->gambar_sampah)
                        <img src="{{ asset('storage/'.$item->gambar_sampah) }}" 
                             alt="{{ $item->nama_sampah }}"
                             loading="lazy">
                    @else
                        <div class="no-image">
                            <i class="fa-solid fa-image"></i>
                            <span>Tidak Ada Gambar</span>
                        </div>
                    @endif
                </div>
                
                <div class="image-meta">
                    <div class="meta-item">
                        <span class="meta-label">ID Sampah</span>
                        <span class="meta-value">#{{ $item->id }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Tanggal Dibuat</span>
                        <span class="meta-value">{{ $item->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Terakhir Diperbarui</span>
                        <span class="meta-value">{{ $item->updated_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Information Section -->
            <div class="info-section">
                <!-- Basic Information Card -->
                <div class="info-card">
                    <div class="card-title">
                        <i class="fa-solid fa-circle-info"></i>
                        <span>Informasi Dasar</span>
                    </div>
                    
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fa-solid fa-tag"></i>
                                <span>Nama Sampah</span>
                            </div>
                            <div class="info-value">{{ $item->nama_sampah }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fa-solid fa-layer-group"></i>
                                <span>Kategori</span>
                            </div>
                            <div class="info-value">
                                @if($item->masterKategori)
                                <div class="category-badge">
                                    <i class="fa-solid fa-tag"></i>
                                    <span>{{ $item->masterKategori->nama_kategori }}</span>
                                </div>
                                @else
                                <span class="info-value muted">Tidak ada kategori</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fa-solid fa-coins"></i>
                                <span>Harga Satuan</span>
                            </div>
                            <div class="info-value">
                                @if($item->harga_satuan !== null)
                                <div class="price-tag">
                                    <i class="fa-solid fa-money-bill-wave"></i>
                                    <span>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</span>
                                </div>
                                @else
                                <span class="info-value muted">Belum ditentukan</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">
                                <i class="fa-solid fa-weight-scale"></i>
                                <span>Jenis Satuan</span>
                            </div>
                            <div class="info-value">
                                @if($item->jenis_satuan)
                                <div class="unit-indicator">
                                    <i class="fa-solid fa-ruler"></i>
                                    <span>{{ $item->jenis_satuan }}</span>
                                </div>
                                @else
                                <span class="info-value muted">Tidak ada satuan</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description Card -->
                <div class="description-card">
                    <div class="card-title">
                        <i class="fa-solid fa-file-alt"></i>
                        <span>Deskripsi</span>
                    </div>
                    
                    <div class="description-content {{ !$item->deskripsi ? 'empty' : '' }}">
                        @if($item->deskripsi)
                            {{ $item->deskripsi }}
                        @else
                            <span>Tidak ada deskripsi</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Card -->
        <div class="stats-card">
            <div class="card-title">
                <i class="fa-solid fa-chart-bar"></i>
                <span>Statistik Data</span>
            </div>
            
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-label">ID Data</div>
                    <div class="stat-value">{{ $item->id }}</div>
                </div>
                
                <div class="stat-item">
                    <div class="stat-label">Harga Satuan</div>
                    <div class="stat-value">
                        @if($item->harga_satuan !== null)
                            Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </div>
                </div>
                
                <div class="stat-item">
                    <div class="stat-label">Tanggal Dibuat</div>
                    <div class="stat-value">
                        {{ $item->created_at->format('d/m/Y') }}
                        <span class="stat-unit">{{ $item->created_at->format('H:i') }}</span>
                    </div>
                </div>
                
                <div class="stat-item">
                    <div class="stat-label">Status Data</div>
                    <div class="stat-value" style="font-size: 20px;">
                        <span style="color: var(--primary); font-weight: 600;">Aktif</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('kategori_sampah.edit', $item->id) }}" class="btn-edit">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Edit Data</span>
            </a>
            
            <button type="button" class="btn-delete" onclick="deleteItem()">
                <i class="fa-solid fa-trash"></i>
                <span>Hapus Data</span>
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image zoom functionality
        const imageContainer = document.querySelector('.image-container img');
        if (imageContainer) {
            imageContainer.addEventListener('click', function() {
                const src = this.src;
                
                // Create modal for image zoom
                const modal = document.createElement('div');
                modal.style.cssText = `
                    position: fixed;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background: rgba(0,0,0,0.9);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    z-index: 9999;
                    padding: 40px;
                    cursor: zoom-out;
                `;
                
                modal.innerHTML = `
                    <div style="max-width: 90vw; max-height: 90vh; position: relative;">
                        <img src="${src}" 
                             style="width: 100%; height: 100%; object-fit: contain; border-radius: var(--radius);"
                             alt="Zoomed image">
                        <button style="position: absolute; top: -20px; right: -20px; width: 40px; height: 40px; border-radius: 50%; background: white; border: none; color: var(--ink); font-size: 20px; cursor: pointer; display: grid; place-items: center; z-index: 10000;">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </div>
                `;
                
                document.body.appendChild(modal);
                document.body.style.overflow = 'hidden';
                
                // Close modal on button click
                modal.querySelector('button').addEventListener('click', function() {
                    document.body.removeChild(modal);
                    document.body.style.overflow = '';
                });
                
                // Close modal on background click
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        document.body.removeChild(modal);
                        document.body.style.overflow = '';
                    }
                });
                
                // Close modal on escape key
                document.addEventListener('keydown', function closeOnEscape(e) {
                    if (e.key === 'Escape') {
                        document.body.removeChild(modal);
                        document.body.style.overflow = '';
                        document.removeEventListener('keydown', closeOnEscape);
                    }
                });
            });
        }
        
        // Add subtle animation to cards
        const cards = document.querySelectorAll('.info-card, .description-card, .stats-card, .image-container');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.style.animation = 'fadeInUp 0.5s ease-out forwards';
            card.style.opacity = '0';
        });
        
        // Add CSS animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);
        
        // Add copy ID functionality
        const idElement = document.querySelector('.stat-item:first-child .stat-value');
        if (idElement) {
            idElement.style.cursor = 'pointer';
            idElement.title = 'Klik untuk menyalin ID';
            
            idElement.addEventListener('click', function() {
                const id = this.textContent;
                navigator.clipboard.writeText(id).then(() => {
                    // Show feedback
                    const originalText = this.textContent;
                    this.textContent = 'ID Disalin!';
                    this.style.color = 'var(--primary)';
                    
                    setTimeout(() => {
                        this.textContent = originalText;
                        this.style.color = '';
                    }, 2000);
                });
            });
        }
        
        // Add hover effect to image meta items
        const metaItems = document.querySelectorAll('.meta-item');
        metaItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.backgroundColor = 'var(--hover-bg)';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });
        
        // Auto-format price on hover
        const priceItems = document.querySelectorAll('.price-tag');
        priceItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                const priceSpan = this.querySelector('span');
                if (priceSpan) {
                    const priceText = priceSpan.textContent;
                    if (priceText.includes('Rp')) {
                        const priceNumber = priceText.replace('Rp ', '').replace(/\./g, '');
                        const formatted = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            minimumFractionDigits: 0
                        }).format(priceNumber);
                        
                        const tooltip = document.createElement('div');
                        tooltip.textContent = formatted;
                        tooltip.style.cssText = `
                            position: absolute;
                            background: var(--ink);
                            color: var(--white);
                            padding: 8px 12px;
                            border-radius: 6px;
                            font-size: 12px;
                            font-weight: 600;
                            z-index: 100;
                            white-space: nowrap;
                            transform: translateY(-40px);
                            box-shadow: var(--shadow);
                        `;
                        
                        this.style.position = 'relative';
                        this.appendChild(tooltip);
                        
                        setTimeout(() => {
                            if (this.contains(tooltip)) {
                                this.removeChild(tooltip);
                            }
                        }, 2000);
                    }
                }
            });
        });
    });
    
    // Delete item function
    function deleteItem() {
        if (confirm('Apakah Anda yakin ingin menghapus kategori sampah "{{ $item->nama_sampah }}"? Tindakan ini tidak dapat dibatalkan dan gambar terkait akan dihapus permanen.')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("kategori_sampah.destroy", $item->id) }}';
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'DELETE';
            
            form.appendChild(csrfToken);
            form.appendChild(method);
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endpush