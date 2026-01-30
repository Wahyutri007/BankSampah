@extends('layouts.user')

@section('title', 'Dashboard')

@php
  use Illuminate\Support\Str;

  $groups = $kategori->groupBy(function($k){
    return $k->masterKategori?->nama_kategori ?? 'Lainnya';
  });

  $totalCount = $kategori->count();

  $totalSetoran = (int) $setoranPerTahun->sum('total');

  $totalPendapatanTahun = (int) ($tahun
    ? optional($pendapatanPerTahun->firstWhere('tahun', $tahun))->total
    : $totalPendapatan
  );
@endphp

@push('styles')
<style>
  :root{
    --brand:#10b981;
    --brand-dark:#059669;
    --bg:#f9fafb;
    --line:#e5e7eb;
    --ink:#111827;
    --muted:#6b7280;
    --shadow: 0 10px 30px rgba(0,0,0,.08);
    --shadow-sm: 0 6px 18px rgba(15, 23, 42, 0.06);
    --radius: 16px;
  }

  /* ==== DASHBOARD STYLES ==== */
  .dashboard-container { width: 100%; }

  /* container full */
  .container-fluid {
    width: 100%;
    max-width: 100%;
    margin: 0 auto;
    padding-left: 16px;
    padding-right: 16px;
  }
  @media (min-width: 768px) {
    .container-fluid { padding-left: 24px; padding-right: 24px; }
  }

  /* HEADER SECTION (lebih cantik + radius) */
  .dashboard-header{
    background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dark) 100%);
    padding: 22px 0 18px;
    color: #fff;
    margin-bottom: 16px;
    position: relative;
    overflow: hidden;
  }
  .dashboard-header::before{
    content:"";
    position:absolute;
    inset:-80px -120px auto auto;
    width: 320px;
    height: 320px;
    background: rgba(255,255,255,.14);
    filter: blur(2px);
    border-radius: 999px;
    transform: rotate(18deg);
  }
  .dashboard-header::after{
    content:"";
    position:absolute;
    inset:auto auto -120px -120px;
    width: 260px;
    height: 260px;
    background: rgba(0,0,0,.08);
    border-radius: 999px;
    filter: blur(1px);
  }

  .hero-inner{
    position: relative;
    border-radius: var(--radius);
    padding: 18px 18px;
    background: rgba(255,255,255,.10);
    border: 1px solid rgba(255,255,255,.18);
    box-shadow: 0 12px 30px rgba(0,0,0,.10);
    backdrop-filter: blur(10px);
  }
  @media (min-width: 768px){
    .hero-inner{ padding: 22px 22px; }
  }

  .welcome-title { font-size: 1.75rem; font-weight: 800; margin-bottom: 8px; }
  .welcome-subtitle { font-size: .95rem; opacity: .95; max-width: 720px; margin-bottom: 0; }

  /* ===== Top Controls ===== */
  .top-row{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap: 12px;
    flex-wrap: wrap;
    margin: 14px 0 12px;
  }
  .top-left{
    display:flex;
    align-items:center;
    gap: 10px;
    flex-wrap: wrap;
  }
  .pill{
    display:inline-flex;
    align-items:center;
    gap: 8px;
    padding: 6px 12px;
    border-radius: 999px;
    background: #fff;
    border: 1px solid #eef2f7;
    box-shadow: var(--shadow-sm);
    color: #0f172a;
    font-weight: 700;
    font-size: .875rem;
  }
  .pill small{ font-weight: 700; color: var(--muted); }

  .year-select{
    appearance: none;
    border: 1px solid #e5e7eb;
    background: #fff;
    border-radius: 12px;
    padding: 10px 12px;
    min-width: 180px;
    font-weight: 700;
    color: #111827;
    box-shadow: var(--shadow-sm);
    cursor: pointer;
    outline: none;
  }
  .year-select:focus{
    border-color: var(--brand);
    box-shadow: 0 0 0 3px rgba(16,185,129,.16);
  }

  /* ======= STATS CARDS: HORIZONTAL STRIP (1 ROW) ======= */
  .stats-strip {
    display: flex;
    gap: 16px;
    flex-wrap: nowrap;           /* jangan turun */
    overflow-x: auto;            /* scroll ke samping kalau sempit */
    padding: 2px 2px 10px;
    margin-bottom: 14px;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
  }
  .stats-strip::-webkit-scrollbar { height: 8px; }
  .stats-strip::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 999px; }

  .stat-compact {
    scroll-snap-align: start;
    flex: 0 0 290px;
    background: #fff;
    border: 1px solid #eef2f7;
    border-radius: 14px;
    box-shadow: var(--shadow-sm);
    padding: 14px 14px;
    position: relative;
    overflow: hidden;
    min-height: 86px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
  }
  @media (min-width: 1200px) {
    .stat-compact { flex: 1 1 0; min-width: 240px; }
  }
  .stat-compact::before{
    content:"";
    position:absolute;
    left:0; top:0;
    width: 5px; height: 100%;
    background: var(--accent, var(--brand));
  }

  .stat-left { min-width: 0; }
  .stat-label {
    font-size: .72rem;
    letter-spacing: .08em;
    font-weight: 900;
    color: var(--accent, var(--brand));
    text-transform: uppercase;
    margin-bottom: 6px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 210px;
  }
  .stat-value {
    font-size: 1.35rem;
    font-weight: 900;
    color: var(--ink);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 220px;
  }
  .stat-sub {
    font-size: .8rem;
    color: var(--muted);
    margin-top: 4px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 220px;
  }

  .stat-icon-wrap{
    width: 44px;
    height: 44px;
    border-radius: 14px;
    background: #f3f4f6;
    color: #94a3b8;
    display:flex;
    align-items:center;
    justify-content:center;
    flex: 0 0 auto;
  }
  .stat-icon-wrap i{ font-size: 1.25rem; opacity:.95; }

  .accent-blue  { --accent: #3b82f6; }
  .accent-green { --accent: #10b981; }
  .accent-teal  { --accent: #06b6d4; }
  .accent-amber { --accent: #f59e0b; }

  /* ===== FILTER TABS (katalog) ===== */
  .filter-tabs {
    display: flex;
    gap: 8px;
    overflow-x: auto;
    padding: 4px 0;
    -webkit-overflow-scrolling: touch;
    margin: 6px 0 10px;
  }
  .filter-tab {
    flex-shrink: 0;
    padding: 8px 14px;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 999px;
    font-size: .875rem;
    font-weight: 800;
    color: #6b7280;
    cursor: pointer;
    transition: .2s;
    white-space: nowrap;
    box-shadow: 0 2px 8px rgba(0,0,0,.04);
  }
  .filter-tab:hover { border-color: var(--brand); color: var(--brand-dark); }
  .filter-tab.active { background: var(--brand); border-color: var(--brand); color: #fff; }
  .tab-count {
    background: rgba(255,255,255,.22);
    padding: 2px 7px;
    border-radius: 999px;
    font-size: .75rem;
    font-weight: 900;
    margin-left: 6px;
  }

  .catalog-head{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap: 12px;
    flex-wrap: wrap;
    margin: 10px 0 12px;
  }
  .section-title { font-size: 1.25rem; font-weight: 900; color: #1f2937; margin: 0; }
  .section-subtitle { font-size: .875rem; color: #6b7280; margin: 4px 0 0; }
  .info-text { font-size: .875rem; color: #6b7280; font-weight: 700; }

  /* PRODUCTS GRID */
  .products-grid{
    display:grid;
    grid-template-columns: repeat(1, 1fr);
    gap: 16px;
    margin-bottom: 36px;
  }
  @media (min-width: 640px) { .products-grid { grid-template-columns: repeat(2, 1fr); } }
  @media (min-width: 768px) { .products-grid { grid-template-columns: repeat(3, 1fr); } }
  @media (min-width: 1024px){ .products-grid { grid-template-columns: repeat(4, 1fr); } }

  .product-card{
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius: 16px;
    overflow:hidden; /* penting biar gambar ikut rounded */
    transition:.2s;
    display:flex;
    flex-direction:column;
    height:100%;
  }
  .product-card:hover{
    box-shadow: var(--shadow);
    transform: translateY(-2px);
    border-color: var(--brand);
  }

  /* ====== GAMBAR FULL LEBAR CARD ====== */
  .product-image{
    position: relative;
    width: 100%;
    aspect-ratio: 16 / 9;     /* konsisten tinggi mengikuti lebar */
    background: #f3f4f6;
    border-bottom: 1px solid #e5e7eb;
    overflow: hidden;
  }
  .product-image img{
    position:absolute;
    inset:0;
    width:100%;
    height:100%;
    display:block;
    object-fit: cover;        /* FULL memenuhi area */
    object-position: center;  /* fokus tengah */
  }
  .no-image{
    position:absolute;
    inset:0;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#9ca3af;
    font-size:.9rem;
    font-weight:800;
  }

  .product-info{
    padding: 16px;
    display:flex;
    flex-direction:column;
    flex:1;
  }
  .product-badge{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding: 5px 10px;
    border-radius: 999px;
    font-size: .75rem;
    font-weight: 900;
    color: #059669;
    background: #ecfdf5;
    border: 1px solid rgba(16,185,129,.18);
    width: fit-content;
    margin-bottom: 10px;
  }
  .product-title{
    font-size: 1rem;
    font-weight: 900;
    color:#1f2937;
    margin: 0 0 8px;
    line-height:1.3;
  }
  .product-description{
    font-size: .875rem;
    color:#6b7280;
    line-height:1.5;
    margin-bottom: 12px;
    flex:1;
  }

  .price-label{ font-size:.75rem; color:#6b7280; margin-bottom: 4px; font-weight:700; }
  .price-value{ font-size: 1.1rem; font-weight: 900; color:#059669; }
  .price-unit{ font-size:.75rem; color:#6b7280; margin-left:4px; font-weight:700; }

  .add-button{
    width:100%;
    background: var(--brand);
    color:#fff;
    border:none;
    border-radius: 12px;
    padding: 10px;
    font-size: .875rem;
    font-weight: 900;
    cursor:pointer;
    transition:.2s;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap: 8px;
    text-decoration:none;
    margin-top: 12px;
  }
  .add-button:hover{ background: var(--brand-dark); }

  /* EMPTY */
  .empty-state{
    text-align:center;
    padding: 40px 20px;
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius: 16px;
    box-shadow: var(--shadow-sm);
    grid-column: 1 / -1;
  }
  .empty-state-icon{ font-size: 3rem; margin-bottom: 16px; color:#9ca3af; }
  .empty-state-title{ font-size: 1.25rem; font-weight: 900; color:#1f2937; margin-bottom: 8px; }
  .empty-state-message{ color:#6b7280; max-width: 420px; margin: 0 auto; font-size:.875rem; font-weight: 700; }
</style>
@endpush

@section('content')
<div class="dashboard-container">

  <!-- HEADER -->
  <div class="dashboard-header">
    <div class="container-fluid">
      <div class="hero-inner">
        <h1 class="welcome-title">🌱 Selamat Datang di SampahKu</h1>
        <p class="welcome-subtitle">
          Kelola sampah Anda dengan mudah melalui sistem yang terintegrasi.
          Pantau pendapatan, setor sampah, dan lihat katalog item yang tersedia.
        </p>
      </div>
    </div>
  </div>

  <div class="container-fluid">

  

    <!-- FILTER TABS -->
  

    <!-- CATALOG HEADER + INFO -->
    <div class="catalog-head" id="productsHeader">
     
       <div class="filter-tabs" id="filterTabs">
      <button class="filter-tab active" data-filter="__all__" data-label="Semua">
        Semua Item <span class="tab-count">{{ $totalCount }}</span>
      </button>
      @foreach($groups as $gName => $list)
        @php $gKey = Str::slug($gName); @endphp
        <button class="filter-tab" data-filter="{{ $gKey }}" data-label="{{ $gName }}">
          {{ $gName }} <span class="tab-count">{{ $list->count() }}</span>
        </button>
      @endforeach
    </div>
    </div>

    <!-- PRODUCTS GRID -->
    <div class="products-grid" id="productsGrid">
      @forelse($kategori as $k)
        @php
          $gName = $k->masterKategori?->nama_kategori ?? 'Lainnya';
          $gKey  = Str::slug($gName);
        @endphp

        <div class="product-card" data-group="{{ $gKey }}" data-name="{{ Str::lower($k->nama_sampah) }}">
          <div class="product-image">
            @if(!empty($k->gambar_sampah))
              <img src="{{ asset('storage/'.$k->gambar_sampah) }}" alt="{{ $k->nama_sampah }}">
            @else
              <div class="no-image">🖼️ Tidak ada gambar</div>
            @endif
          </div>

          <div class="product-info">
            <span class="product-badge">📁 {{ $gName }}</span>

            <h3 class="product-title">{{ $k->nama_sampah }}</h3>

            <p class="product-description">
              {{ $k->deskripsi ? Str::limit($k->deskripsi, 80) : 'Tidak ada deskripsi.' }}
            </p>

            <div class="product-price">
              <div class="price-label">Harga Satuan</div>
              <div>
                <span class="price-value">
                  {{ $k->harga_satuan !== null ? 'Rp ' . number_format($k->harga_satuan, 0, ',', '.') : 'Rp 0' }}
                </span>
                <span class="price-unit">/ {{ $k->jenis_satuan ?? 'unit' }}</span>
              </div>
            </div>

            <a href="{{ route('user.setoran.create', ['kategori_sampah_id' => $k->id]) }}" class="add-button">
              <span>Tambah Setoran</span>
              <i class="bi bi-plus-lg"></i>
            </a>
          </div>
        </div>
      @empty
        <div class="empty-state">
          <div class="empty-state-icon">📦</div>
          <h3 class="empty-state-title">Belum ada data sampah</h3>
          <p class="empty-state-message">Admin belum menambahkan data sampah ke dalam sistem.</p>
        </div>
      @endforelse
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const filterTabs  = document.querySelectorAll('.filter-tab');
    const cards       = document.querySelectorAll('.product-card');
    const resultInfo  = document.getElementById('resultInfo');
    const headerEl    = document.getElementById('productsHeader');

    let activeFilter = '__all__';

    function applyFilter() {
      let visibleCount = 0;
      const visibleGroups = new Set();

      cards.forEach(card => {
        const g = card.dataset.group || '';
        const show = (activeFilter === '__all__') || (g === activeFilter);

        card.style.display = show ? '' : 'none';

        if (show) {
          visibleCount++;
          visibleGroups.add(g);
        }
      });

      if (resultInfo) {
        if (activeFilter === '__all__') {
          resultInfo.textContent = `Menampilkan ${visibleCount} item dari ${visibleGroups.size} kategori`;
        } else {
          const activeTab = document.querySelector(`.filter-tab[data-filter="${activeFilter}"]`);
          const label = activeTab ? activeTab.dataset.label : 'Kategori';
          resultInfo.textContent = `Menampilkan ${visibleCount} item untuk kategori: ${label}`;
        }
      }
    }

    filterTabs.forEach(tab => {
      tab.addEventListener('click', function() {
        activeFilter = this.dataset.filter || '__all__';

        filterTabs.forEach(t => t.classList.remove('active'));
        this.classList.add('active');

        applyFilter();

        if (headerEl) headerEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
    });

    applyFilter();
  });
</script>
@endpush
