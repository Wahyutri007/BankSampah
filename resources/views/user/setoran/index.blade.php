@extends('layouts.user') {{-- sesuaikan nama layout user kamu --}}
@section('title', 'Riwayat Setoran')

@push('styles')
<style>
  /* ===== Samakan tema dengan Dashboard (putih + hijau) ===== */
  :root{
    --brand:#10b981;
    --brand-dark:#059669;
    --brand-soft:#ecfdf5;

    --bg:#f9fafb;
    --card:#ffffff;
    --ink:#111827;
    --muted:#6b7280;
    --line:#e5e7eb;

    --shadow-sm: 0 6px 18px rgba(15, 23, 42, 0.06);
    --shadow:    0 10px 30px rgba(0,0,0,.08);
    --radius:16px;
  }

  .page-wrap{
    width:100%;
  }

  /* container fluid yang sama */
  .container-fluid{
    width:100%;
    max-width:100%;
    margin:0 auto;
    padding-left:16px;
    padding-right:16px;
  }
  @media (min-width:768px){
    .container-fluid{ padding-left:24px; padding-right:24px; }
  }

  /* ===== Header: style sama kayak dashboard ===== */
  .page-header{
    background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dark) 100%);
    padding: 20px 0 18px;
    color:#fff;
    margin-bottom: 14px;
    position:relative;
    overflow:hidden;
  }
  .page-header::before{
    content:"";
    position:absolute;
    inset:-80px -120px auto auto;
    width:320px;height:320px;
    background:rgba(255,255,255,.14);
    border-radius:999px;
    transform: rotate(18deg);
  }
  .page-header::after{
    content:"";
    position:absolute;
    inset:auto auto -120px -120px;
    width:260px;height:260px;
    background:rgba(0,0,0,.08);
    border-radius:999px;
  }
  .header-inner{
    position:relative;
    border-radius: var(--radius);
    padding: 18px 18px;
    background: rgba(255,255,255,.10);
    border: 1px solid rgba(255,255,255,.18);
    box-shadow: 0 12px 30px rgba(0,0,0,.10);
    backdrop-filter: blur(10px);
  }
  @media (min-width:768px){
    .header-inner{ padding: 22px 22px; }
  }

  .title{
    margin:0;
    font-size: 1.5rem;
    font-weight: 900;
    letter-spacing: .2px;
  }
  .subtitle{
    margin:6px 0 0;
    font-size:.95rem;
    opacity:.95;
    max-width: 720px;
  }

  /* ===== Top actions ===== */
  .topbar{
    display:flex;
    justify-content:space-between;
    align-items:flex-end;
    gap:12px;
    flex-wrap:wrap;
    margin: 10px 0 12px;
  }
  .actions{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
  }

  .btnx{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:10px 14px;
    border-radius:12px;
    border:1px solid var(--line);
    background: var(--card);
    color: var(--ink);
    text-decoration:none;
    cursor:pointer;
    font-size: .875rem;
    font-weight: 900;
    box-shadow: var(--shadow-sm);
    transition: .2s;
  }
  .btnx:hover{
    transform: translateY(-1px);
    box-shadow: var(--shadow);
    border-color: rgba(16,185,129,.45);
  }
  .btnx-primary{
    background: var(--brand);
    border-color: var(--brand);
    color:#fff;
  }
  .btnx-primary:hover{
    background: var(--brand-dark);
    border-color: var(--brand-dark);
  }

  /* ===== Alert (samakan vibe) ===== */
  .alertx{
    margin: 10px 0 14px;
    padding: 12px 14px;
    border-radius: 14px;
    border: 1px solid rgba(16,185,129,.28);
    background: var(--brand-soft);
    color: #065f46;
    font-weight: 800;
    box-shadow: 0 6px 18px rgba(15,23,42,.05);
  }

  /* ===== Card table ===== */
  .cardx{
    background: var(--card);
    border: 1px solid var(--line);
    border-radius: var(--radius);
    box-shadow: var(--shadow-sm);
    overflow:hidden;
  }

  .toolbar{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
    flex-wrap:wrap;
    padding: 14px 16px;
    border-bottom: 1px solid var(--line);
    background: #fff;
  }
  .muted{ color: var(--muted); font-size:.875rem; font-weight:700; }

  .table-wrap{
    overflow:auto;
    max-height: 72vh;
    background:#fff;
  }

  table{
    width:100%;
    border-collapse:separate;
    border-spacing:0;
  }

  thead th{
    text-align:left;
    font-size: .75rem;
    color: var(--muted);
    padding: 12px 14px;
    border-bottom: 1px solid var(--line);
    background: #f3f4f6;
    position: sticky;
    top: 0;
    z-index: 1;
    letter-spacing: .06em;
    text-transform: uppercase;
    font-weight: 900;
    white-space: nowrap;
  }

  tbody td{
    padding: 12px 14px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: top;
    font-size: .875rem;
    color: var(--ink);
  }

  tbody tr:hover td{
    background: #fafafa;
  }

  .pill{
    display:inline-flex;
    align-items:center;
    padding: 6px 10px;
    border-radius: 999px;
    border: 1px solid rgba(16,185,129,.20);
    background: var(--brand-soft);
    color: #065f46;
    font-size: .75rem;
    font-weight: 900;
    letter-spacing: .04em;
    text-transform: uppercase;
    white-space: nowrap;
  }

  .row-item{
    margin-bottom:6px;
  }
  .row-item .small-muted{
    color: var(--muted);
    font-weight: 700;
  }

  .cell-actions{
    display:flex;
    gap:8px;
    flex-wrap:wrap;
  }

  .footer{
    padding: 12px 16px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:10px;
    border-top: 1px solid var(--line);
    background:#fff;
  }

  /* Pagination (laravel default) */
  .pagination { display:flex; gap:8px; flex-wrap:wrap; margin:0; }
  .pagination .page-link, .pagination a, .pagination span{
    color: var(--ink) !important;
    background: #fff !important;
    border: 1px solid var(--line) !important;
    border-radius: 12px;
    padding: 8px 12px;
    text-decoration:none;
    font-weight: 900;
    box-shadow: 0 2px 10px rgba(15,23,42,.04);
  }
  .pagination .active span{
    background: var(--brand) !important;
    border-color: var(--brand) !important;
    color: #fff !important;
  }

  .empty{
    padding: 28px 14px;
    text-align:center;
    color: var(--muted);
    font-weight: 800;
  }

  .nowrap{ white-space: nowrap; }
</style>
@endpush

@section('content')
<div class="page-wrap">

  <!-- HEADER -->
  <div class="page-header">
    <div class="container-fluid">
      <div class="header-inner">
        <h2 class="title">📦 Riwayat Setoran</h2>
        <p class="subtitle">Riwayat setoran kamu beserta status, total estimasi, dan detail itemnya.</p>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="topbar">
      <div class="muted">
        Menampilkan {{ $items->firstItem() ?? 0 }} - {{ $items->lastItem() ?? 0 }} dari {{ $items->total() }} data
      </div>

      <div class="actions">
        <a class="btnx" href="{{ route('user.dashboard') }}">🏠 Dashboard</a>
        <a class="btnx btnx-primary" href="{{ route('user.setoran.create') }}">➕ Buat Setoran</a>
      </div>
    </div>

    @if(session('success'))
      <div class="alertx">
        ✅ {{ session('success') }}
      </div>
    @endif

    <div class="cardx">
      <div class="toolbar">
        <div class="muted">
          Menampilkan {{ $items->firstItem() ?? 0 }} - {{ $items->lastItem() ?? 0 }} dari {{ $items->total() }} data
        </div>
        <div></div>
      </div>

      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th class="nowrap">#</th>
              <th>Item</th>
              <th class="nowrap">Metode</th>
              <th class="nowrap">Total</th>
              <th class="nowrap">Status</th>
              <th>Lokasi</th>
              <th class="nowrap">Aksi</th>
            </tr>
          </thead>

          <tbody>
            @forelse($items as $it)
              <tr>
                <td class="nowrap">
                  {{ $loop->iteration + ($items->currentPage()-1)*$items->perPage() }}
                </td>

                <td>
                  @forelse($it->items as $d)
                    <div class="row-item">
                      - {{ $d->kategori->nama_sampah ?? '-' }}
                      <span class="small-muted">
                        ({{ $d->kategori->masterKategori->nama_kategori ?? '-' }})
                      </span>
                      : {{ $d->jumlah }} {{ $d->satuan ?? '' }}
                      <span class="small-muted">(Rp {{ number_format($d->subtotal) }})</span>
                    </div>
                  @empty
                    <span class="muted">-</span>
                  @endforelse
                </td>

                <td class="nowrap">
                  <span class="pill">{{ strtoupper($it->metode) }}</span>
                </td>

                <td class="nowrap">
                  Rp {{ number_format($it->estimasi_total) }}
                </td>

                <td class="nowrap">
                  <span class="pill">{{ strtoupper($it->status) }}</span>
                </td>

                <td>
                  @if($it->metode === 'jemput' && $it->latitude && $it->longitude)
                    <div class="cell-actions">
                      <a class="btnx" target="_blank"
                         href="https://www.google.com/maps?q={{ $it->latitude }},{{ $it->longitude }}">
                        🗺️ Lihat Map
                      </a>
                      <a class="btnx" target="_blank"
                         href="https://www.google.com/maps/dir/?api=1&destination={{ $it->latitude }},{{ $it->longitude }}&travelmode=driving">
                        🚗 Navigasi
                      </a>
                    </div>
                  @else
                    <span class="muted">-</span>
                  @endif
                </td>

                <td class="nowrap">
                  <a class="btnx btnx-primary" href="{{ route('user.setoran.show', $it->id) }}">Detail</a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="empty">Belum ada setoran.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="footer">
        <div class="muted">
          Menampilkan {{ $items->firstItem() ?? 0 }} - {{ $items->lastItem() ?? 0 }} dari {{ $items->total() }} data
        </div>
        <div>{{ $items->links() }}</div>
      </div>
    </div>
  </div>
</div>
@endsection
