@extends('layouts.admin')

@section('title', 'Peta Monitoring Setoran')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />

<style>
    /* ===== MAP PAGE STYLES ===== */
    .map-page {
        min-height: calc(100vh - 100px);
    }

    /* Page Header */
    .map-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 32px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--line);
        flex-wrap: wrap;
        gap: 16px;
    }
    
    .map-header .page-title {
        font-size: 28px;
        margin-bottom: 4px;
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .map-header .page-subtitle {
        font-size: 15px;
        color: var(--muted);
        max-width: 600px;
        line-height: 1.6;
    }

    /* Map Container */
    .map-container-wrapper {
        background: var(--white);
        border: 1px solid var(--line);
        border-radius: var(--radius);
        padding: 24px;
        box-shadow: var(--shadow-sm);
        margin-bottom: 32px;
    }
    
    .map-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--line);
        flex-wrap: wrap;
        gap: 16px;
    }
    
    .map-stats {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }
    
    .stat-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .stat-count {
        font-size: 24px;
        font-weight: 700;
        color: var(--ink);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    
    .stat-label {
        font-size: 14px;
        color: var(--muted);
        font-weight: 500;
    }

    /* Map Controls */
    .map-controls {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }
    
    .search-input {
        padding: 10px 16px;
        border: 1px solid var(--line);
        border-radius: var(--radius-sm);
        background: var(--white);
        color: var(--ink);
        font-size: 14px;
        min-width: 200px;
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
    
    .filter-select {
        padding: 10px 16px;
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

    /* Map */
    #map {
        height: 600px;
        border-radius: var(--radius);
        border: 1px solid var(--line);
        overflow: hidden;
        background: var(--bg);
    }

    /* Legend */
    .map-legend {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid var(--line);
    }
    
    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        background: var(--bg);
        border: 1px solid var(--line);
        border-radius: var(--radius-sm);
    }
    
    .legend-color {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: 2px solid var(--white);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .legend-label {
        font-size: 13px;
        color: var(--ink);
        font-weight: 500;
    }

    /* Info Panel */
    .info-panel {
        position: absolute;
        top: 100px;
        right: 40px;
        z-index: 1000;
        background: var(--white);
        border: 1px solid var(--line);
        border-radius: var(--radius);
        box-shadow: var(--shadow-lg);
        padding: 20px;
        min-width: 300px;
        max-width: 400px;
        display: none;
    }
    
    .info-panel.active {
        display: block;
        animation: slideInRight 0.3s ease-out;
    }
    
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    .info-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--line);
    }
    
    .info-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--ink);
    }
    
    .info-close {
        background: transparent;
        border: none;
        color: var(--muted);
        cursor: pointer;
        font-size: 18px;
        transition: var(--transition);
    }
    
    .info-close:hover {
        color: var(--ink);
    }
    
    .info-content {
        max-height: 400px;
        overflow-y: auto;
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
        margin-bottom: 4px;
    }
    
    .info-value {
        font-size: 15px;
        color: var(--ink);
        font-weight: 600;
    }
    
    .info-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 12px;
        margin-top: 8px;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 32px;
    }
    
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
    
    .btn-refresh {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        border-radius: var(--radius);
        background: var(--primary);
        color: var(--white);
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        border: 1px solid var(--primary);
        transition: var(--transition);
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
    }
    
    .btn-refresh:hover {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
    }

    /* Cluster Styling */
    .marker-cluster-small {
        background-color: rgba(16, 185, 129, 0.2) !important;
        border: 3px solid rgba(16, 185, 129, 0.3) !important;
    }
    
    .marker-cluster-small div {
        background-color: var(--primary) !important;
        color: var(--white) !important;
    }
    
    .marker-cluster-medium {
        background-color: rgba(16, 185, 129, 0.3) !important;
        border: 3px solid rgba(16, 185, 129, 0.4) !important;
    }
    
    .marker-cluster-medium div {
        background-color: var(--primary-dark) !important;
        color: var(--white) !important;
    }
    
    .marker-cluster-large {
        background-color: rgba(16, 185, 129, 0.4) !important;
        border: 3px solid rgba(16, 185, 129, 0.5) !important;
    }
    
    .marker-cluster-large div {
        background-color: var(--primary-dark) !important;
        color: var(--white) !important;
    }

    /* Loading Overlay */
    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2000;
        border-radius: var(--radius);
        backdrop-filter: blur(4px);
    }
    
    .loading-spinner {
        width: 40px;
        height: 40px;
        border: 3px solid var(--line);
        border-top-color: var(--primary);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .map-header {
            flex-direction: column;
            align-items: stretch;
        }
        
        .map-toolbar {
            flex-direction: column;
            align-items: stretch;
        }
        
        .map-stats {
            justify-content: space-between;
        }
        
        .map-controls {
            width: 100%;
        }
        
        .search-input,
        .filter-select {
            flex: 1;
            min-width: 0;
        }
        
        #map {
            height: 500px;
        }
        
        .info-panel {
            position: fixed;
            top: auto;
            bottom: 0;
            left: 0;
            right: 0;
            max-width: none;
            border-radius: var(--radius) var(--radius) 0 0;
            max-height: 60vh;
            overflow-y: auto;
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    }

    @media (max-width: 768px) {
        .map-container-wrapper {
            padding: 16px;
            margin-left: -16px;
            margin-right: -16px;
            border-radius: 0;
            border-left: none;
            border-right: none;
        }
        
        #map {
            height: 400px;
        }
        
        .legend-item {
            flex: 1;
            min-width: 140px;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-back,
        .btn-refresh {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .map-stats {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
        
        .stat-item {
            width: 100%;
            justify-content: space-between;
        }
        
        .map-controls {
            flex-direction: column;
        }
        
        .search-input,
        .filter-select {
            width: 100%;
        }
        
        .map-legend {
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="map-page">
    <!-- Page Header -->
    <div class="map-header">
        <div>
            <h1 class="page-title">Peta Monitoring Setoran</h1>
            <p class="page-subtitle">Pantau lokasi penjemputan dan pergerakan petugas secara real-time dalam satu tampilan peta interaktif.</p>
        </div>
    </div>

    <!-- Map Container -->
    <div class="map-container-wrapper">
        <div class="map-toolbar">
            <div class="map-stats">
                <div class="stat-item">
                    <div class="stat-count" id="totalPickups">0</div>
                    <div class="stat-label">Total Titik</div>
                </div>
                
                <div class="stat-item">
                    <div class="stat-count" id="activeTrucks">0</div>
                    <div class="stat-label">Petugas Aktif</div>
                </div>
                
                <div class="stat-item">
                    <div class="stat-count" id="pendingCount">0</div>
                    <div class="stat-label">Menunggu</div>
                </div>
            </div>
            
            <div class="map-controls">
                <input type="text" 
                       class="search-input" 
                       id="searchInput" 
                       placeholder="Cari pengguna atau alamat..." />
                
                <select class="filter-select" id="statusFilter">
                    <option value="all">Semua Status</option>
                    <option value="menunggu">Menunggu</option>
                    <option value="diproses">Diproses</option>
                    <option value="selesai">Selesai</option>
                    <option value="dibatalkan">Dibatalkan</option>
                </select>
                
                <select class="filter-select" id="typeFilter">
                    <option value="all">Semua Tipe</option>
                    <option value="jemput">Penjemputan</option>
                    <option value="antar">Antar Sendiri</option>
                </select>
            </div>
        </div>
        
        <div id="map"></div>
        
        <!-- Legend -->
        <div class="map-legend">
            <div class="legend-item">
                <div class="legend-color" style="background: var(--primary);"></div>
                <div class="legend-label">Menunggu</div>
            </div>
            
            <div class="legend-item">
                <div class="legend-color" style="background: #3b82f6;"></div>
                <div class="legend-label">Diproses</div>
            </div>
            
            <div class="legend-item">
                <div class="legend-color" style="background: #10b981;"></div>
                <div class="legend-label">Selesai</div>
            </div>
            
            <div class="legend-item">
                <div class="legend-color" style="background: #ef4444;"></div>
                <div class="legend-label">Dibatalkan</div>
            </div>
            
            <div class="legend-item">
                <div class="legend-color" style="background: #f59e0b; width: 20px; height: 20px;">
                    <i class="fa-solid fa-truck" style="color: white; font-size: 10px;"></i>
                </div>
                <div class="legend-label">Petugas Aktif</div>
            </div>
        </div>
    </div>

    <!-- Info Panel -->
    <div class="info-panel" id="infoPanel">
        <div class="info-header">
            <div class="info-title">Detail Setoran</div>
            <button class="info-close" id="closeInfoPanel">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
        
        <div class="info-content" id="infoContent">
            <!-- Content will be loaded dynamically -->
        </div>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="{{ route('admin.setoran.index') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Data Setoran</span>
        </a>
        
        <button class="btn-refresh" id="refreshMap">
            <i class="fa-solid fa-rotate"></i>
            <span>Refresh Peta</span>
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

<script>
    // Constants
    const DATA_URL = "{{ route('admin.map.data') }}";
    const DETAIL_URL_BASE = "{{ route('admin.setoran.index') }}";
    
    // Map initialization
    const map = L.map('map').setView([-7.2575, 112.7521], 13);
    
    // Tile layers
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    // Cluster group for markers
    const markersCluster = L.markerClusterGroup({
        maxClusterRadius: 40,
        iconCreateFunction: function(cluster) {
            const count = cluster.getChildCount();
            let size = 'small';
            if (count > 10) size = 'large';
            else if (count > 5) size = 'medium';
            
            return L.divIcon({
                html: `<div style="background: var(--primary); color: white; width: 40px; height: 40px; border-radius: 50%; display: grid; place-items: center; font-weight: 700; border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.3);">${count}</div>`,
                className: `marker-cluster-${size}`,
                iconSize: L.point(40, 40)
            });
        }
    });
    map.addLayer(markersCluster);
    
    // Truck markers layer
    const truckLayer = L.layerGroup().addTo(map);
    
    // Store markers
    const pickupMarkers = new Map();
    const truckMarkers = new Map();
    
    // Get color by status
    function getColorByStatus(status) {
        switch(status?.toLowerCase()) {
            case 'menunggu': return 'var(--primary)';
            case 'diproses': return '#3b82f6';
            case 'selesai': return '#10b981';
            case 'dibatalkan': return '#ef4444';
            default: return '#6b7280';
        }
    }
    
    // Get icon by status
    function getIconByStatus(status, isTruck = false) {
        if (isTruck) {
            return L.divIcon({
                html: `<div style="background: #3b82f6; width: 32px; height: 32px; border-radius: 50%; display: grid; place-items: center; color: white; border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.3); transform: rotate(45deg);"><i class="fa-solid fa-truck"></i></div>`,
                className: 'truck-marker',
                iconSize: [32, 32],
                iconAnchor: [16, 16]
            });
        }
        
        const color = getColorByStatus(status);
        return L.divIcon({
            html: `<div style="background: ${color}; width: 24px; height: 24px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.2);"></div>`,
            className: 'pickup-marker',
            iconSize: [24, 24],
            iconAnchor: [12, 12]
        });
    }
    
    // Create popup content
    function createPopupContent(data) {
        const status = data.status?.toUpperCase() || '-';
        const statusColor = getColorByStatus(data.status);
        
        return `
            <div style="min-width: 250px; font-family: 'Inter', sans-serif;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                    <div style="width: 12px; height: 12px; border-radius: 50%; background: ${statusColor};"></div>
                    <div style="font-weight: 700; font-size: 16px; color: var(--ink);">Setoran #${data.id}</div>
                </div>
                
                <div style="margin-bottom: 8px;">
                    <div style="font-size: 13px; color: var(--muted);">Pengguna</div>
                    <div style="font-size: 15px; font-weight: 600; color: var(--ink);">${data.user_name || '-'}</div>
                </div>
                
                <div style="margin-bottom: 8px;">
                    <div style="font-size: 13px; color: var(--muted);">Status</div>
                    <div style="font-size: 14px; font-weight: 600; color: ${statusColor};">${status}</div>
                </div>
                
                <div style="margin-bottom: 8px;">
                    <div style="font-size: 13px; color: var(--muted);">Alamat</div>
                    <div style="font-size: 14px; color: var(--ink);">${data.alamat || '-'}</div>
                </div>
                
                <div style="margin-bottom: 8px;">
                    <div style="font-size: 13px; color: var(--muted);">Petugas</div>
                    <div style="font-size: 14px; color: var(--ink);">${data.petugas_name || 'Belum ditugaskan'}</div>
                </div>
                
                <div style="margin-top: 16px; display: flex; gap: 8px;">
                    <a href="${DETAIL_URL_BASE}/${data.id}" 
                       style="flex: 1; text-align: center; padding: 8px 12px; background: var(--primary); color: white; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 13px;">
                        Detail
                    </a>
                    <a href="https://www.google.com/maps?q=${data.lat},${data.lng}" 
                       target="_blank"
                       style="flex: 1; text-align: center; padding: 8px 12px; background: var(--bg); color: var(--ink); border: 1px solid var(--line); border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 13px;">
                        Google Maps
                    </a>
                </div>
            </div>
        `;
    }
    
    // Update info panel
    function updateInfoPanel(data) {
        const panel = document.getElementById('infoPanel');
        const content = document.getElementById('infoContent');
        const statusColor = getColorByStatus(data.status);
        
        content.innerHTML = `
            <div class="info-item">
                <div class="info-label">ID Setoran</div>
                <div class="info-value">#${data.id}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Pengguna</div>
                <div class="info-value">${data.user_name || '-'}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Status</div>
                <div>
                    <div class="info-badge" style="background: ${statusColor}20; color: ${statusColor}; border: 1px solid ${statusColor}40;">
                        <i class="fa-solid fa-circle" style="font-size: 8px;"></i>
                        <span>${data.status?.toUpperCase() || '-'}</span>
                    </div>
                </div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Metode</div>
                <div class="info-value">
                    ${data.metode === 'jemput' ? '<i class="fa-solid fa-truck-pickup"></i> Penjemputan' : '<i class="fa-solid fa-box"></i> Antar Sendiri'}
                </div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Alamat</div>
                <div class="info-value">${data.alamat || '-'}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Koordinat</div>
                <div class="info-value">${data.lat?.toFixed(6)}, ${data.lng?.toFixed(6)}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Tanggal</div>
                <div class="info-value">${new Date(data.created_at).toLocaleDateString('id-ID', { 
                    weekday: 'long', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                })}</div>
            </div>
            
            ${data.petugas_name ? `
                <div class="info-item">
                    <div class="info-label">Petugas</div>
                    <div class="info-value">${data.petugas_name}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Terakhir Dilihat</div>
                    <div class="info-value">${data.petugas_last_seen || '-'}</div>
                </div>
            ` : ''}
            
            <div style="margin-top: 16px; display: flex; gap: 8px;">
                <a href="${DETAIL_URL_BASE}/${data.id}" 
                   class="btn-back" style="flex: 1; text-align: center; padding: 10px;">
                    <i class="fa-solid fa-eye"></i> Detail Lengkap
                </a>
            </div>
        `;
        
        panel.classList.add('active');
    }
    
    // Load and display data
    async function loadMapData() {
        try {
            document.getElementById('loadingOverlay').style.display = 'flex';
            
            const response = await fetch(DATA_URL);
            const data = await response.json();
            const items = data.items || [];
            
            // Update stats
            document.getElementById('totalPickups').textContent = items.length;
            document.getElementById('activeTrucks').textContent = items.filter(item => item.petugas_lat && item.petugas_lng).length;
            document.getElementById('pendingCount').textContent = items.filter(item => item.status?.toLowerCase() === 'menunggu').length;
            
            // Clear existing markers
            markersCluster.clearLayers();
            truckLayer.clearLayers();
            pickupMarkers.clear();
            truckMarkers.clear();
            
            // Add markers
            const bounds = [];
            items.forEach(item => {
                // Pickup marker
                const pickupIcon = getIconByStatus(item.status);
                const pickupMarker = L.marker([item.lat, item.lng], { icon: pickupIcon });
                
                pickupMarker.bindPopup(createPopupContent(item));
                pickupMarker.on('click', () => {
                    updateInfoPanel(item);
                });
                
                markersCluster.addLayer(pickupMarker);
                pickupMarkers.set(item.id, pickupMarker);
                bounds.push([item.lat, item.lng]);
                
                // Truck marker if available
                if (item.petugas_lat && item.petugas_lng) {
                    const truckIcon = getIconByStatus('diproses', true);
                    const truckMarker = L.marker([item.petugas_lat, item.petugas_lng], { icon: truckIcon });
                    
                    truckMarker.bindPopup(`
                        <div style="min-width: 200px;">
                            <div style="font-weight: 700; margin-bottom: 8px;">🚛 Petugas ${item.petugas_name || ''}</div>
                            <div style="font-size: 13px; color: var(--muted);">Mengambil setoran #${item.id}</div>
                            <div style="font-size: 13px; color: var(--muted); margin-top: 4px;">Terakhir dilihat: ${item.petugas_last_seen || '-'}</div>
                        </div>
                    `);
                    
                    truckLayer.addLayer(truckMarker);
                    truckMarkers.set(item.id, truckMarker);
                    bounds.push([item.petugas_lat, item.petugas_lng]);
                }
            });
            
            // Fit bounds if we have markers
            if (bounds.length > 0) {
                map.fitBounds(bounds, { padding: [50, 50] });
            }
            
        } catch (error) {
            console.error('Error loading map data:', error);
            alert('Gagal memuat data peta. Silakan coba lagi.');
        } finally {
            document.getElementById('loadingOverlay').style.display = 'none';
        }
    }
    
    // Filter markers
    function filterMarkers() {
        const statusFilter = document.getElementById('statusFilter').value;
        const typeFilter = document.getElementById('typeFilter').value;
        const searchQuery = document.getElementById('searchInput').value.toLowerCase();
        
        let visibleCount = 0;
        
        pickupMarkers.forEach((marker, id) => {
            const item = marker._popup ? JSON.parse(marker._popup.options.data || '{}') : {};
            
            const statusMatch = statusFilter === 'all' || item.status?.toLowerCase() === statusFilter;
            const typeMatch = typeFilter === 'all' || item.metode?.toLowerCase() === typeFilter;
            const searchMatch = !searchQuery || 
                (item.user_name?.toLowerCase().includes(searchQuery) || 
                 item.alamat?.toLowerCase().includes(searchQuery));
            
            const visible = statusMatch && typeMatch && searchMatch;
            
            if (visible) {
                marker.addTo(markersCluster);
                visibleCount++;
            } else {
                markersCluster.removeLayer(marker);
            }
            
            // Show/hide truck marker
            const truckMarker = truckMarkers.get(id);
            if (truckMarker) {
                if (visible) {
                    truckLayer.addLayer(truckMarker);
                } else {
                    truckLayer.removeLayer(truckMarker);
                }
            }
        });
        
        document.getElementById('totalPickups').textContent = visibleCount;
    }
    
    // Event Listeners
    document.getElementById('statusFilter').addEventListener('change', filterMarkers);
    document.getElementById('typeFilter').addEventListener('change', filterMarkers);
    document.getElementById('searchInput').addEventListener('input', filterMarkers);
    
    document.getElementById('refreshMap').addEventListener('click', loadMapData);
    
    document.getElementById('closeInfoPanel').addEventListener('click', () => {
        document.getElementById('infoPanel').classList.remove('active');
    });
    
    // Close info panel when clicking outside
    document.addEventListener('click', (e) => {
        const infoPanel = document.getElementById('infoPanel');
        if (infoPanel.classList.contains('active') && 
            !infoPanel.contains(e.target) && 
            !e.target.closest('.pickup-marker, .truck-marker')) {
            infoPanel.classList.remove('active');
        }
    });
    
    // Initial load
    loadMapData();
    
    // Auto refresh every 30 seconds
    setInterval(loadMapData, 30000);
</script>
@endpush