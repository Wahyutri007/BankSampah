@extends('layouts.user')
@section('title', 'Peta Titik Jemput Saya')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800;900&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>

<style>
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
    --shadow:    0 12px 34px rgba(0,0,0,.10);

    --radius:16px;
  }

  body, .page, input, select, textarea, button, a{
    font-family: "Plus Jakarta Sans", system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
  }

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

  /* ===== HEADER ===== */
  .page-header{
    background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dark) 100%);
    padding: 18px 0 16px;
    color:#fff;
    margin-bottom: 14px;
    position:relative;
    overflow:hidden;
  }
  .page-header::before{
    content:"";
    position:absolute;
    inset:-90px -140px auto auto;
    width:340px;height:340px;
    background:rgba(255,255,255,.14);
    border-radius:999px;
    transform: rotate(18deg);
  }
  .page-header::after{
    content:"";
    position:absolute;
    inset:auto auto -140px -140px;
    width:300px;height:300px;
    background:rgba(0,0,0,.08);
    border-radius:999px;
  }
  .header-inner{
    position:relative;
    border-radius: var(--radius);
    padding: 18px;
    background: rgba(255,255,255,.10);
    border: 1px solid rgba(255,255,255,.18);
    box-shadow: 0 12px 30px rgba(0,0,0,.10);
    backdrop-filter: blur(10px);
  }
  @media (min-width:768px){
    .header-inner{ padding:22px; }
  }
  .title{
    margin:0;
    font-size: 1.35rem;
    font-weight: 900;
    letter-spacing:.2px;
    display:flex;
    align-items:center;
    gap:10px;
  }
  .subtitle{
    margin:6px 0 0;
    font-size:.95rem;
    opacity:.95;
    max-width: 900px;
  }

  /* ===== CARD ===== */
  .page{ padding-bottom: 18px; }
  .card{
    background: var(--card);
    border: 1px solid var(--line);
    border-radius: var(--radius);
    box-shadow: var(--shadow-sm);
    overflow:hidden;
  }
  .card-head{
    padding: 14px 16px;
    border-bottom: 1px solid var(--line);
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
    background:#fff;
  }
  .muted{ color: var(--muted); font-size:.875rem; font-weight:800; }

  .actions{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
  }

  .content{ padding: 16px; }

  /* ===== BUTTON ===== */
  .btnx{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    padding:10px 14px;
    border-radius: 12px;
    border:1px solid var(--line);
    background:#fff;
    color: var(--ink);
    text-decoration:none;
    cursor:pointer;
    font-size:.875rem;
    font-weight:900;
    box-shadow: var(--shadow-sm);
    transition:.2s;
    line-height:1;
    white-space:nowrap;
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
  .btnx-soft{
    background: var(--brand-soft);
    border-color: rgba(16,185,129,.22);
    color:#065f46;
  }

  /* ===== TOOLBAR ===== */
  .toolbar{
    display:flex;
    gap:12px;
    flex-wrap:wrap;
    align-items:center;
    justify-content:space-between;
    margin-bottom: 12px;
  }
  .toolbar-left{
    display:flex;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
  }
  .info-pill{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:8px 10px;
    border-radius: 999px;
    border: 1px solid rgba(16,185,129,.20);
    background: var(--brand-soft);
    color:#065f46;
    font-weight:900;
    font-size:.85rem;
  }

  .toolbar-right{
    display:flex;
    gap:10px;
    align-items:center;
    flex-wrap:wrap;
  }

  .selectx{
    padding:10px 12px;
    border-radius: 12px;
    border:1px solid var(--line);
    background:#fff;
    font-weight:900;
    outline:none;
    min-width: 200px;
  }
  .selectx:focus{
    border-color: rgba(16,185,129,.45);
    box-shadow: 0 0 0 3px rgba(16,185,129,.12);
  }

  /* ===== MAP ===== */
  #map{
    height: 600px;
    border: 1px solid var(--line);
    border-radius: var(--radius);
    overflow:hidden;
    background:#fff;
    box-shadow: 0 10px 24px rgba(0,0,0,.06);
  }

  /* ===== LEGEND ===== */
  .legend{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
    margin-top: 12px;
  }
  .chip{
    padding:8px 10px;
    border-radius:999px;
    border:1px solid var(--line);
    background:#fff;
    font-weight:900;
    display:flex;
    align-items:center;
    gap:8px;
    color: var(--ink);
    box-shadow: 0 6px 16px rgba(15,23,42,.05);
  }
  .dot{ width:10px;height:10px;border-radius:999px;display:inline-block; }
  .chip small{ font-weight:800; color: var(--muted); }

  /* Leaflet */
  .leaflet-control-attribution{ font-size: 11px; }
</style>
@endpush

@section('content')
<div class="page">

  {{-- HEADER --}}
  <div class="page-header">
    <div class="container-fluid">
      <div class="header-inner">
        <h2 class="title">
          <i class="fa-solid fa-map-location-dot"></i>
          Peta Titik Jemput Saya
        </h2>
        <p class="subtitle">
          Lihat status setoran jemput & posisi petugas realtime (jika tracking aktif). Kamu bisa filter status untuk fokus ke setoran tertentu.
        </p>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="card">
      <div class="card-head">
        <div class="muted">
          <i class="fa-solid fa-circle-info"></i>
          Monitoring jemput & tracking petugas.
        </div>
        <div class="actions">
          <a class="btnx" href="{{ route('user.dashboard') }}">
            <i class="fa-solid fa-house"></i> Dashboard
          </a>
          <a class="btnx btnx-soft" href="{{ route('user.setoran.index') }}">
            <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Setoran
          </a>
        </div>
      </div>

      <div class="content">

        <div class="toolbar">
          <div class="toolbar-left">
            <div class="info-pill" id="infoText">
              <i class="fa-solid fa-spinner fa-spin"></i> Memuat data...
            </div>
            <div class="muted">
              <i class="fa-solid fa-satellite-dish"></i> Update berkala
            </div>
          </div>

          <div class="toolbar-right">
            <span class="muted"><i class="fa-solid fa-filter"></i> Filter status</span>
            <select id="statusFilter" class="selectx">
              <option value="__all__">Semua</option>
              <option value="pending">PENDING</option>
              <option value="diambil">DIAMBIL</option>
              <option value="selesai">SELESAI</option>
              <option value="ditolak">DITOLAK</option>
            </select>
          </div>
        </div>

        <div id="map"></div>

        <div class="legend">
          <div class="chip"><span class="dot" style="background:#22c55e"></span> Titik Jemput</div>
          <div class="chip"><span class="dot" style="background:#f59e0b"></span> Pending</div>
          <div class="chip"><span class="dot" style="background:#3b82f6"></span> Diambil</div>
          <div class="chip"><span class="dot" style="background:#9ca3af"></span> Selesai</div>
          <div class="chip"><span class="dot" style="background:#ef4444"></span> Ditolak</div>
          <div class="chip">🚛 <small>= posisi petugas</small></div>
          <div class="chip">🧭 <small>= rute petugas → titik</small></div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
  const dataUrl = "{{ route('user.map.data') }}";
  const detailUrlBase = "{{ url('/user/setoran') }}";

  const map = L.map('map').setView([0.5071, 101.4478], 12);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);

  const pickupMarkers = new Map(); // id -> marker
  const truckMarkers  = new Map(); // id -> marker
  const routeLines    = new Map(); // id -> {outline, main}
  const routeCache    = new Map(); // id -> {fromLat, fromLng, at, routeInfo}

  const truckIcon = L.divIcon({ html: "🚛", className: "", iconSize: [28,28], iconAnchor:[14,14] });

  function colorByStatus(status){
    const s = String(status||'').toLowerCase();
    if(s === 'pending') return '#f59e0b';
    if(s === 'diambil') return '#3b82f6';
    if(s === 'selesai') return '#9ca3af';
    if(s === 'ditolak') return '#ef4444';
    return '#22c55e';
  }

  function circleIcon(color){
    return L.divIcon({
      className: "",
      html: `<div style="width:16px;height:16px;border-radius:999px;background:${color};
        border:3px solid rgba(255,255,255,.95);box-shadow:0 10px 24px rgba(0,0,0,.18);"></div>`,
      iconSize:[16,16], iconAnchor:[8,8]
    });
  }

  function fmtKm(m){ return (m/1000).toFixed(1) + " km"; }
  function fmtEta(seconds){
    const m = Math.round(seconds/60);
    if(m < 60) return m + " menit";
    const h = Math.floor(m/60);
    const r = m % 60;
    return h + " jam " + r + " menit";
  }

  function shouldShow(status, filter){
    if(filter === '__all__') return true;
    return String(status||'').toLowerCase() === filter;
  }

  function popupHtml(it, routeInfo){
    const s = String(it.status||'').toUpperCase();
    const addr = it.alamat ? it.alamat : '-';
    const seen = it.petugas_last_seen ? it.petugas_last_seen : '-';
    const hasPetugas = (it.petugas_id != null && it.petugas_id !== undefined && it.petugas_id !== '');
    const hasTruck = (it.petugas_lat != null && it.petugas_lat !== '' &&
                     it.petugas_lng != null && it.petugas_lng !== '' &&
                     !isNaN(Number(it.petugas_lat)) && !isNaN(Number(it.petugas_lng)) &&
                     Number(it.petugas_lat) !== 0 && Number(it.petugas_lng) !== 0);
    const petName = it.petugas_name || 'Petugas';

    const petugasInfo = hasTruck
      ? `🚛 ${petName} - Tracking aktif`
      : hasPetugas
        ? `${petName} - Belum mulai tracking`
        : 'Belum ada petugas';

    const routePart = routeInfo
      ? `<div style="margin-top:6px"><b>ETA:</b> ${routeInfo.eta} • <b>Jarak:</b> ${routeInfo.dist}</div>`
      : `<div style="margin-top:6px"><b>ETA/Jarak:</b> -</div>`;

    return `
      <div style="font-family:Plus Jakarta Sans, Arial;min-width:250px">
        <div style="font-weight:900;font-size:14px">Setoran #${it.id}</div>
        <div style="margin-top:6px"><b>Status:</b> ${s}</div>
        <div style="margin-top:6px"><b>Alamat:</b><br>${addr}</div>
        <div style="margin-top:6px"><b>Koordinat:</b> ${it.lat.toFixed(6)}, ${it.lng.toFixed(6)}</div>
        <div style="margin-top:6px"><b>Petugas:</b> ${petugasInfo}</div>
        <div style="margin-top:6px"><b>Last seen:</b> ${seen}</div>
        ${routePart}
        <div style="margin-top:10px;display:flex;gap:8px;flex-wrap:wrap">
          <a href="${detailUrlBase}/${it.id}" style="display:inline-block;padding:8px 10px;border:1px solid #e5e7eb;border-radius:10px;text-decoration:none;font-weight:900;color:#111827;background:#fff">Detail</a>
          <a target="_blank" href="https://www.google.com/maps?q=${it.lat},${it.lng}" style="display:inline-block;padding:8px 10px;border:1px solid rgba(16,185,129,.35);border-radius:10px;text-decoration:none;font-weight:900;color:#065f46;background:#ecfdf5">Maps</a>
        </div>
      </div>
    `;
  }

  function clearRoute(id){
    if(routeLines.has(id)){
      const r = routeLines.get(id);
      if(r.outline) map.removeLayer(r.outline);
      if(r.main) map.removeLayer(r.main);
      routeLines.delete(id);
    }
  }

  function setRoute(id, coordsLatLng){
    clearRoute(id);
    const outline = L.polyline(coordsLatLng, { weight: 11, opacity: 0.28 }).addTo(map);
    const main    = L.polyline(coordsLatLng, { weight: 7, opacity: 0.9 }).addTo(map);
    routeLines.set(id, { outline, main });
  }

  async function drawRouteIfNeeded(it){
    const hasTruck = (it.petugas_lat != null && it.petugas_lat !== '' &&
                     it.petugas_lng != null && it.petugas_lng !== '' &&
                     !isNaN(it.petugas_lat) && !isNaN(it.petugas_lng) &&
                     it.petugas_lat !== 0 && it.petugas_lng !== 0);
    if(!hasTruck){
      clearRoute(it.id);
      return null;
    }

    const now = Date.now();
    const cache = routeCache.get(it.id);

    const movedEnough = !cache
      ? true
      : (Math.abs(cache.fromLat - it.petugas_lat) + Math.abs(cache.fromLng - it.petugas_lng)) > 0.0002;

    const timeEnough = !cache ? true : (now - cache.at) > 7000; // 7 detik (lebih ringan)

    if(!movedEnough && !timeEnough){
      return cache?.routeInfo ?? null;
    }

    const url = `https://router.project-osrm.org/route/v1/driving/${it.petugas_lng},${it.petugas_lat};${it.lng},${it.lat}?overview=full&geometries=geojson`;

    try{
      const res = await fetch(url, { cache: "no-store" });
      const data = await res.json();
      if(!data.routes || !data.routes[0]) return null;

      const r = data.routes[0];
      const coords = r.geometry.coordinates.map(c => [c[1], c[0]]);
      setRoute(it.id, coords);

      const routeInfo = { eta: fmtEta(r.duration), dist: fmtKm(r.distance) };
      routeCache.set(it.id, { fromLat: it.petugas_lat, fromLng: it.petugas_lng, at: now, routeInfo });
      return routeInfo;
    }catch(e){
      return null;
    }
  }

  async function refresh(){
    try{
      const filter = document.getElementById('statusFilter').value;
      const res = await fetch(dataUrl, { cache: "no-store" });
      if(!res.ok) return;

      const data = await res.json();
      const items = data.items || [];

      const info = document.getElementById('infoText');
      info.innerHTML = `<i class="fa-solid fa-location-dot"></i> Total titik jemput: <b>${items.length}</b> • Realtime update`;

      let bounds = [];
      const alivePickup = new Set();
      const aliveTruck  = new Set();
      const aliveRoute  = new Set();

      for(const it of items){
        const ok = shouldShow(it.status, filter);
        alivePickup.add(it.id);

        const icon = circleIcon(colorByStatus(it.status));
        if(!pickupMarkers.has(it.id)){
          const m = L.marker([it.lat, it.lng], { icon }).addTo(map);
          pickupMarkers.set(it.id, m);
        }else{
          pickupMarkers.get(it.id).setLatLng([it.lat, it.lng]);
          pickupMarkers.get(it.id).setIcon(icon);
        }

        const routeInfo = await drawRouteIfNeeded(it);
        pickupMarkers.get(it.id).bindPopup(popupHtml(it, routeInfo));
        pickupMarkers.get(it.id).setOpacity(ok ? 1 : 0);
        if(ok) bounds.push([it.lat, it.lng]);

        const hasPetugas = (it.petugas_id != null && it.petugas_id !== undefined && it.petugas_id !== '');
        const hasTruck = (hasPetugas &&
          it.petugas_lat != null && it.petugas_lat !== '' &&
          it.petugas_lng != null && it.petugas_lng !== '' &&
          !isNaN(Number(it.petugas_lat)) && !isNaN(Number(it.petugas_lng)) &&
          Number(it.petugas_lat) !== 0 && Number(it.petugas_lng) !== 0);

        if(hasTruck){
          const petLat = Number(it.petugas_lat);
          const petLng = Number(it.petugas_lng);

          aliveTruck.add(it.id);
          if(!truckMarkers.has(it.id)){
            const tm = L.marker([petLat, petLng], { icon: truckIcon }).addTo(map);
            tm.bindPopup(`<b>🚛 Petugas</b><br>Setoran #${it.id}<br>Last seen: ${it.petugas_last_seen || '-'}`);
            truckMarkers.set(it.id, tm);
          }else{
            truckMarkers.get(it.id).setLatLng([petLat, petLng]);
            truckMarkers.get(it.id).setPopupContent(`<b>🚛 Petugas</b><br>Setoran #${it.id}<br>Last seen: ${it.petugas_last_seen || '-'}`);
          }

          truckMarkers.get(it.id).setOpacity(ok ? 1 : 0);
          if(ok) bounds.push([petLat, petLng]);

          if(ok) aliveRoute.add(it.id);
          else clearRoute(it.id);
        }else{
          if(truckMarkers.has(it.id)){
            map.removeLayer(truckMarkers.get(it.id));
            truckMarkers.delete(it.id);
          }
          clearRoute(it.id);
        }
      }

      for(const [id, m] of pickupMarkers){
        if(!alivePickup.has(id)){
          map.removeLayer(m);
          pickupMarkers.delete(id);
          clearRoute(id);
          if(truckMarkers.has(id)){
            map.removeLayer(truckMarkers.get(id));
            truckMarkers.delete(id);
          }
        }
      }
      for(const [id, m] of truckMarkers){
        if(!aliveTruck.has(id)){
          map.removeLayer(m);
          truckMarkers.delete(id);
        }
      }
      for(const [id] of routeLines){
        if(!aliveRoute.has(id)){
          clearRoute(id);
        }
      }

      if(bounds.length){
        map.fitBounds(L.latLngBounds(bounds).pad(0.2));
      }
    }catch(e){}
  }

  document.getElementById('statusFilter').addEventListener('change', refresh);

  refresh();

  // NOTE: 1 detik terlalu berat. 3 detik lebih aman untuk UX + server.
  setInterval(refresh, 3000);
</script>
@endpush
