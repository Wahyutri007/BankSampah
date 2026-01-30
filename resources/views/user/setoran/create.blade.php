@extends('layouts.user')
@section('title', 'Buat Setoran')

@push('styles')
{{-- Font (seragam, modern) --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800;900&display=swap" rel="stylesheet">

{{-- Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

{{-- Leaflet --}}
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
    --radius-sm:12px;
  }

  body, .page, .card, input, select, textarea, button, a{
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
    font-size: 1.45rem;
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
    max-width: 760px;
  }

  /* ===== CARD ===== */
  .page{ width:100%; padding-bottom: 92px; } /* ruang untuk sticky action bar bawah */
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

  .muted{ color: var(--muted); font-size:.875rem; font-weight:700; }

  .actions{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
  }

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
    font-weight:800;
    box-shadow: var(--shadow-sm);
    transition:.2s;
    line-height:1;
    white-space:nowrap;
  }
  .btnx i{ font-size:.95rem; }
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
    color: #065f46;
  }
  .btnx-danger{
    background:#fff;
    border-color: rgba(239,68,68,.35);
    color:#b91c1c;
  }
  .btnx-danger:hover{ border-color: rgba(239,68,68,.55); }

  .alertx{
    margin: 12px 0 0;
    padding: 12px 14px;
    border-radius: 14px;
    border: 1px solid rgba(239,68,68,.25);
    background: #fef2f2;
    color: #991b1b;
    font-weight: 800;
  }
  .alertx ul{ margin:6px 0 0; padding-left:18px; }

  .content{ padding: 16px; }

  /* ===== FORM ===== */
  label{
    font-weight: 900;
    color: var(--ink);
    display:block;
    margin-bottom: 6px;
    font-size: .9rem;
  }
  input, select, textarea{
    width: 100%;
    padding: 10px 12px;
    border-radius: 12px;
    border:1px solid var(--line);
    background:#fff;
    outline:none;
    color: var(--ink);
    font-weight:700;
  }
  input:focus, select:focus, textarea:focus{
    border-color: rgba(16,185,129,.45);
    box-shadow: 0 0 0 3px rgba(16,185,129,.12);
  }
  textarea{ resize: vertical; }

  .row{ margin-bottom: 12px; }
  .grid2{
    display:grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
  }
  @media (max-width: 680px){ .grid2{ grid-template-columns: 1fr; } }

  .hint{
    margin-top:6px;
    color: var(--muted);
    font-size: .85rem;
    font-weight:700;
  }
  hr{
    border:none;
    border-top: 1px solid var(--line);
    margin: 16px 0;
  }

  /* ===== MAP ===== */
  #map{
    height: 340px;
    border-radius: var(--radius);
    border: 1px solid var(--line);
    overflow:hidden;
    box-shadow: 0 10px 24px rgba(0,0,0,.06);
  }
  .map-head{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
    margin-bottom: 10px;
  }
  .map-actions{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
  }

  /* ===== KPI ===== */
  .pill{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
    padding:10px 12px;
    border-radius: 14px;
    border:1px solid rgba(16,185,129,.18);
    background: var(--brand-soft);
    font-weight:900;
    color:#065f46;
  }
  .pill .label{
    font-weight: 1000;
    display:flex;
    align-items:center;
    gap:8px;
    white-space: nowrap;
  }
  .pill input{
    width: 100%;
    border: 1px solid var(--line);
    background: #fff;
    border-radius: 12px;
    padding: 8px 10px;
    font-weight: 900;
    color: var(--ink);
  }
  .status-good{ color:#065f46; font-weight:900; }
  .status-bad{ color:#b91c1c; font-weight:900; }

  /* ===== ITEMS SECTION (UX IMPROVED) ===== */
  .items-head{
    display:flex;
    justify-content:space-between;
    align-items:flex-end;
    gap:12px;
    flex-wrap:wrap;
    margin-bottom: 10px;
  }
  .items-title{
    margin:0;
    font-size: 1.05rem;
    font-weight: 900;
    color: var(--ink);
    display:flex;
    align-items:center;
    gap:10px;
  }

  /* CTA utama: Tambah Jenis */
  .btn-add{
    position: relative;
    padding: 12px 16px;
    border-radius: 14px;
    border: 1px solid rgba(16,185,129,.55) !important;
    background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dark) 100%) !important;
    color: #fff !important;
    box-shadow:
      0 14px 34px rgba(16,185,129,.28),
      0 10px 22px rgba(0,0,0,.10) !important;
  }
  .btn-add:hover{
    transform: translateY(-2px);
    box-shadow:
      0 20px 44px rgba(16,185,129,.32),
      0 14px 26px rgba(0,0,0,.12) !important;
  }
  .btn-add::before{
    content:"";
    position:absolute;
    inset:-7px;
    border-radius: 18px;
    background: radial-gradient(circle at 30% 30%, rgba(16,185,129,.35), transparent 55%);
    filter: blur(2px);
    opacity: .95;
    z-index: -1;
  }
  .btn-add .badge{
    display:inline-flex;
    align-items:center;
    gap:6px;
    margin-left:8px;
    padding:3px 8px;
    border-radius:999px;
    font-size:.72rem;
    font-weight:900;
    background: rgba(255,255,255,.18);
    border: 1px solid rgba(255,255,255,.22);
  }

  @keyframes pulseAddBtn{
    0%   { box-shadow: 0 14px 34px rgba(16,185,129,.22), 0 0 0 0 rgba(16,185,129,.35); }
    70%  { box-shadow: 0 14px 34px rgba(16,185,129,.30), 0 0 0 14px rgba(16,185,129,0); }
    100% { box-shadow: 0 14px 34px rgba(16,185,129,.24), 0 0 0 0 rgba(16,185,129,0); }
  }
  .btn-add.is-pulse{ animation: pulseAddBtn 1.25s ease-out 0s 3; }

  /* sticky mini bar untuk CTA tambah jenis (selalu kelihatan pas scroll tabel) */
  .add-sticky{
    position: sticky;
    top: 10px;
    z-index: 20;
    display:flex;
    justify-content:flex-end;
    margin: 0 0 10px;
  }

  /* ===== TABLE ===== */
  .table-wrap{
    overflow:auto;
    border: 1px solid var(--line);
    border-radius: var(--radius);
    background:#fff;
  }
  table{
    width:100%;
    border-collapse:separate;
    border-spacing:0;
    min-width: 820px;
  }
  thead th{
    text-align:left;
    font-size:.75rem;
    color: var(--muted);
    padding: 12px 14px;
    border-bottom: 1px solid var(--line);
    background: #f3f4f6;
    letter-spacing:.06em;
    text-transform: uppercase;
    font-weight: 900;
    white-space: nowrap;
    position: sticky;
    top: 0;
    z-index: 1;
  }
  tbody td{
    padding: 12px 14px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: top;
    font-size: .875rem;
    color: var(--ink);
    font-weight: 700;
  }
  tbody tr:hover td{ background:#fafafa; }
  .cell-center{ text-align:center; }
  .nowrap{ white-space:nowrap; }

  .total-box{
    margin-top: 12px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:10px;
    padding: 12px 14px;
    border-radius: 14px;
    border: 1px solid rgba(16,185,129,.18);
    background: var(--brand-soft);
    font-weight: 900;
    color: #065f46;
  }
  .total-box .left{ display:flex; align-items:center; gap:10px; }

  /* ===== STICKY ACTION BAR BAWAH (pojok kanan) ===== */
  .actionbar{
    position: fixed;
    left: 0;
    right: 0;
    bottom: 0;
    padding: 10px 0;
    background: rgba(249,250,251,.92);
    border-top: 1px solid var(--line);
    backdrop-filter: blur(10px);
    z-index: 50;
  }
  .actionbar .inner{
    display:flex;
    justify-content:flex-end; /* pojok kanan */
    align-items:center;
    gap:10px;
  }
  .actionbar .btnx{
    box-shadow: 0 10px 26px rgba(0,0,0,.10);
  }

  /* kecilin attribution leaflet */
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
          <i class="fa-solid fa-recycle"></i>
          Buat Setoran Sampah
        </h2>
        <p class="subtitle">
          Pilih metode setoran, lalu tambahkan beberapa jenis sampah sekaligus.
          Jika <b>Jemput</b>, pilih titik di peta agar alamat terisi otomatis.
        </p>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    @if ($errors->any())
      <div class="alertx">
        <div style="display:flex; align-items:flex-start; gap:10px;">
          <i class="fa-solid fa-triangle-exclamation" style="margin-top:2px;"></i>
          <div>
            <div><b>Periksa kembali:</b></div>
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    @endif

    <form method="POST" action="{{ route('user.setoran.store') }}">
      @csrf

      <div class="card">
        <div class="card-head">
          <div class="muted">
            <i class="fa-solid fa-circle-info"></i>
            Lengkapi data setoran kamu di bawah ini.
          </div>
          <div class="actions">
            <a class="btnx" href="{{ route('user.dashboard') }}">
              <i class="fa-solid fa-house"></i> Dashboard
            </a>
            <a class="btnx btnx-soft" href="{{ route('user.setoran.index') }}">
              <i class="fa-solid fa-clock-rotate-left"></i> Riwayat
            </a>
          </div>
        </div>

        <div class="content">
          {{-- METODE --}}
          <div class="row grid2">
            <div>
              <label><i class="fa-solid fa-truck-fast"></i> Metode *</label>
              <select name="metode" id="metodeSelect" required>
                <option value="antar" {{ old('metode','antar')=='antar'?'selected':'' }}>Antar sendiri</option>
                <option value="jemput" {{ old('metode')=='jemput'?'selected':'' }}>Jemput</option>
              </select>
              <div class="hint">Jika <b>Jemput</b>: klik peta / geser marker. Koordinat & alamat akan terisi otomatis.</div>
            </div>

            <div>
              <label><i class="fa-solid fa-calendar-day"></i> Jadwal Jemput (opsional)</label>
              <input type="datetime-local" name="jadwal_jemput" value="{{ old('jadwal_jemput') }}">
              <div class="hint">Boleh dikosongkan, nanti dijadwalkan oleh petugas.</div>
            </div>
          </div>

          {{-- JEMPUT --}}
          <div id="jemputFields" style="display:none;">
            <hr>

            <div class="row">
              <label><i class="fa-solid fa-location-dot"></i> Alamat (untuk jemput) *</label>
              <input type="text" name="alamat" id="alamatInput" value="{{ old('alamat') }}" placeholder="Alamat lengkap...">
              <div class="hint">Alamat akan terisi otomatis dari lokasi. Kamu tetap bisa edit manual.</div>
            </div>

            <div class="row" style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
              <button class="btnx" type="button" id="btnGps">
                <i class="fa-solid fa-crosshairs"></i> Pakai Lokasi Saya
              </button>
              <button class="btnx btnx-soft" type="button" id="btnAutoFill" title="Isi alamat dari titik saat ini">
                <i class="fa-solid fa-wand-magic-sparkles"></i> Isi Alamat Otomatis
              </button>
              <div class="muted" id="locStatus">
                <i class="fa-regular fa-hand-pointer"></i> Klik peta untuk memilih titik jemput.
              </div>
            </div>

            <div class="row grid2">
              <div class="pill">
                <div class="label"><i class="fa-solid fa-satellite"></i> Latitude</div>
                <input type="text" id="latView" readonly placeholder="—">
              </div>
              <div class="pill">
                <div class="label"><i class="fa-solid fa-satellite"></i> Longitude</div>
                <input type="text" id="lngView" readonly placeholder="—">
              </div>
            </div>

            <input type="hidden" name="latitude" id="latInput" value="{{ old('latitude') }}">
            <input type="hidden" name="longitude" id="lngInput" value="{{ old('longitude') }}">

            <div class="row" style="margin-top:10px;">
              <div class="map-head">
                <div class="muted">
                  <i class="fa-solid fa-map-location-dot"></i> <b>Peta Titik Jemput</b>
                </div>
                <div class="map-actions">
                  <a class="btnx btnx-soft" id="gmapsLink" href="#" target="_blank" rel="noopener">
                    <i class="fa-brands fa-google"></i> Buka Maps
                  </a>
                  <a class="btnx btnx-primary" id="gmapsDirLink" href="#" target="_blank" rel="noopener">
                    <i class="fa-solid fa-route"></i> Navigasi
                  </a>
                </div>
              </div>

              <div id="map"></div>

              <div class="hint" style="margin-top:10px">
                <b>Tips:</b> klik peta untuk pasang marker, lalu geser marker untuk posisi yang tepat.
              </div>
            </div>
          </div>

          <hr>

          {{-- ITEMS --}}
       

          {{-- Sticky CTA Tambah Jenis --}}
          <div class="add-sticky">
            <button class="btnx btn-add is-pulse" id="btnAddJenis" type="button" onclick="addRow()">
              <i class="fa-solid fa-circle-plus"></i> Tambah Jenis
            </button>
          </div>

          <div class="table-wrap">
            <table>
              <thead>
                <tr>
                  <th style="width:40%"><i class="fa-solid fa-box"></i> Jenis Sampah</th>
                  <th style="width:15%"><i class="fa-solid fa-scale-balanced"></i> Jumlah</th>
                  <th style="width:15%"><i class="fa-solid fa-ruler"></i> Satuan</th>
                  <th style="width:15%"><i class="fa-solid fa-tag"></i> Harga</th>
                  <th style="width:15%"><i class="fa-solid fa-calculator"></i> Subtotal</th>
                  <th class="cell-center" style="width:1%"><i class="fa-solid fa-trash"></i></th>
                </tr>
              </thead>
              <tbody id="itemsBody"></tbody>
            </table>
          </div>

          <div class="total-box">
            <div class="left">
              <i class="fa-solid fa-coins"></i>
              <div>Total Estimasi</div>
            </div>
            <div>Rp <span id="grandTotal">0</span></div>
          </div>

          <div class="row" style="margin-top:12px;">
            <label><i class="fa-solid fa-pen-to-square"></i> Catatan (opsional)</label>
            <textarea name="catatan" rows="3">{{ old('catatan') }}</textarea>
          </div>

        </div>
      </div>

      {{-- ACTION BAR BAWAH: pojok kanan --}}
      <div class="actionbar">
        <div class="container-fluid">
          <div class="inner">
            <a class="btnx" href="{{ route('user.dashboard') }}">
              <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
            <button class="btnx btnx-primary" type="submit">
              <i class="fa-solid fa-paper-plane"></i> Kirim Setoran
            </button>
          </div>
        </div>
      </div>

    </form>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

<script>
  // =========================
  // DATA ITEM
  // =========================
  const kategoriData = @json($kategoriData);
  const selectedId = @json((string)($selectedId ?? ''));

  function rupiah(n){
    try { return new Intl.NumberFormat('id-ID').format(n); }
    catch(e){ return n; }
  }

  function buildSelect(name, selectedValue=''){
    let html = `<select name="${name}" onchange="recalc()" required>`;
    html += `<option value="">-- pilih --</option>`;
    kategoriData.forEach(k => {
      const label = `${k.nama} (${k.kategori ?? '-'})`;
      const sel = (String(k.id) === String(selectedValue)) ? 'selected' : '';
      html += `<option value="${k.id}" data-harga="${k.harga}" data-satuan="${k.satuan}" ${sel}>${label}</option>`;
    });
    html += `</select>`;
    return html;
  }

  let rowIndex = 0;

  function addRow(prefillKategoriId = ''){
    const tbody = document.getElementById('itemsBody');
    const tr = document.createElement('tr');

    tr.innerHTML = `
      <td>${buildSelect(`items[${rowIndex}][kategori_sampah_id]`, prefillKategoriId)}</td>
      <td><input type="number" name="items[${rowIndex}][jumlah]" step="0.01" min="0.01" value="1" oninput="recalc()" required></td>
      <td class="satuanCell">-</td>
      <td class="hargaCell">-</td>
      <td class="subtotalCell">0</td>
      <td class="cell-center">
        <button type="button" class="btnx btnx-danger" onclick="removeRow(this)">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </td>
    `;

    tbody.appendChild(tr);
    rowIndex++;
    recalc();

    // UX: setelah tambah baris, scroll sedikit ke baris baru
    tr.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  }

  function removeRow(btn){
    btn.closest('tr').remove();
    recalc();
  }

  function recalc(){
    const rows = Array.from(document.querySelectorAll('#itemsBody tr'));
    let grand = 0;

    rows.forEach(tr => {
      const select = tr.querySelector('select');
      const jumlahInput = tr.querySelector('input[type="number"]');

      const opt = select.options[select.selectedIndex];
      const harga = parseInt(opt?.dataset?.harga || '0', 10);
      const satuan = opt?.dataset?.satuan || '';

      const jumlah = parseFloat(jumlahInput.value || '0');
      const subtotal = Math.round(jumlah * harga);

      tr.querySelector('.satuanCell').innerText = satuan || '-';
      tr.querySelector('.hargaCell').innerText = harga ? ('Rp ' + rupiah(harga)) : '-';
      tr.querySelector('.subtotalCell').innerText = rupiah(subtotal);

      grand += subtotal;
    });

    document.getElementById('grandTotal').innerText = rupiah(grand);
  }

  addRow(selectedId || '');

  // matikan pulse tombol tambah jenis setelah 5 detik (biar gak ganggu)
  setTimeout(() => {
    const btn = document.getElementById('btnAddJenis');
    if(btn) btn.classList.remove('is-pulse');
  }, 5000);

  // =========================
  // JEMPUT TOGGLE
  // =========================
  const metodeSelect = document.getElementById('metodeSelect');
  const jemputFields = document.getElementById('jemputFields');

  function toggleJemput(){
    const isJemput = metodeSelect.value === 'jemput';
    jemputFields.style.display = isJemput ? 'block' : 'none';
    if(isJemput) setTimeout(()=>{ if(map) map.invalidateSize(); }, 200);
  }
  metodeSelect.addEventListener('change', toggleJemput);
  toggleJemput();

  // =========================
  // MAP + AUTO ADDRESS
  // =========================
  let map, marker;
  let lastAutoAddress = '';

  const locStatus   = document.getElementById('locStatus');
  const latInput    = document.getElementById('latInput');
  const lngInput    = document.getElementById('lngInput');
  const latView     = document.getElementById('latView');
  const lngView     = document.getElementById('lngView');
  const alamatInput = document.getElementById('alamatInput');

  const gmapsLink    = document.getElementById('gmapsLink');
  const gmapsDirLink = document.getElementById('gmapsDirLink');

  const defaultLat = 0.5071;
  const defaultLng = 101.4478;

  function updateLinks(lat, lng){
    gmapsLink.href = `https://www.google.com/maps?q=${lat},${lng}`;
    gmapsDirLink.href = `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}&travelmode=driving`;
  }

  async function reverseGeocode(lat, lng){
    try{
      locStatus.innerHTML = `<span class="status-good"><i class="fa-solid fa-spinner fa-spin"></i> Mengambil alamat otomatis...</span>`;
      const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`;
      const res = await fetch(url, { headers: { 'Accept':'application/json', 'Accept-Language':'id' } });
      const data = await res.json();

      if(data && data.display_name){
        lastAutoAddress = data.display_name;
        if(!alamatInput.value || alamatInput.value.trim().length < 3){
          alamatInput.value = lastAutoAddress;
        }
        locStatus.innerHTML = `<span class="status-good"><i class="fa-solid fa-circle-check"></i> Alamat terisi otomatis. Kamu bisa edit jika perlu.</span>`;
      }else{
        locStatus.innerHTML = `<span class="status-bad"><i class="fa-solid fa-circle-xmark"></i> Alamat tidak ditemukan, isi manual.</span>`;
      }
    }catch(e){
      locStatus.innerHTML = `<span class="status-bad"><i class="fa-solid fa-circle-xmark"></i> Gagal ambil alamat otomatis, isi manual.</span>`;
    }
  }

  function setCoordinate(lat, lng, message){
    const latFixed = Number(lat);
    const lngFixed = Number(lng);

    latInput.value = latFixed;
    lngInput.value = lngFixed;

    latView.value = latFixed.toFixed(6);
    lngView.value = lngFixed.toFixed(6);

    locStatus.innerText = message;
    updateLinks(latFixed, lngFixed);

    if(!marker){
      marker = L.marker([latFixed, lngFixed], { draggable:true }).addTo(map);
      marker.on('dragend', function(e){
        const p = e.target.getLatLng();
        setCoordinate(p.lat, p.lng, 'Marker digeser. Memperbarui alamat...');
        reverseGeocode(p.lat, p.lng);
      });
    }else{
      marker.setLatLng([latFixed, lngFixed]);
    }

    map.setView([latFixed, lngFixed], 17);
    reverseGeocode(latFixed, lngFixed);
  }

  function initMap(){
    const oldLat = latInput.value;
    const oldLng = lngInput.value;

    const startLat = oldLat ? Number(oldLat) : defaultLat;
    const startLng = oldLng ? Number(oldLng) : defaultLng;

    map = L.map('map').setView([startLat, startLng], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom:19,
      attribution:'© OpenStreetMap'
    }).addTo(map);

    map.on('click', function(e){
      setCoordinate(e.latlng.lat, e.latlng.lng, 'Titik dipilih. Mengambil alamat...');
    });

    if(oldLat && oldLng){
      setCoordinate(Number(oldLat), Number(oldLng), 'Lokasi jemput sudah tersimpan. Memperbarui alamat...');
    }else{
      latView.value = '';
      lngView.value = '';
      updateLinks(startLat, startLng);
    }
  }
  initMap();

  // GPS
  document.getElementById('btnGps')?.addEventListener('click', useMyLocation);

  function useMyLocation(){
    if(!navigator.geolocation){
      locStatus.innerHTML = `<span class="status-bad"><i class="fa-solid fa-ban"></i> Browser tidak mendukung GPS.</span>`;
      return;
    }

    if(navigator.permissions && navigator.permissions.query){
      navigator.permissions.query({ name: 'geolocation' }).then(p => {
        if(p.state === 'denied'){
          locStatus.innerHTML =
            `<span class="status-bad"><i class="fa-solid fa-lock"></i> GPS diblokir browser. Izinkan Location di Site settings, atau pilih titik lewat peta.</span>`;
        }
      }).catch(()=>{});
    }

    locStatus.innerHTML = `<span class="status-good"><i class="fa-solid fa-spinner fa-spin"></i> Mengambil lokasi GPS...</span>`;

    navigator.geolocation.getCurrentPosition(
      (pos) => setCoordinate(pos.coords.latitude, pos.coords.longitude, 'Lokasi GPS dipakai. Mengambil alamat...'),
      (err) => {
        locStatus.innerHTML =
          `<span class="status-bad"><i class="fa-solid fa-circle-xmark"></i> GPS gagal (${err.message}). Kamu bisa pilih titik lewat peta.</span>`;
      },
      { enableHighAccuracy:true, timeout:12000, maximumAge:0 }
    );
  }

  // Button: gunakan alamat auto
  document.getElementById('btnAutoFill')?.addEventListener('click', () => {
    if(!lastAutoAddress){
      const lat = latInput.value, lng = lngInput.value;
      if(lat && lng) reverseGeocode(lat, lng);
      else alert('Pilih titik jemput dulu (klik peta / GPS).');
      return;
    }
    alamatInput.value = lastAutoAddress;
    locStatus.innerHTML = `<span class="status-good"><i class="fa-solid fa-circle-check"></i> Alamat otomatis dipakai. Kamu bisa edit jika perlu.</span>`;
  });

  // VALIDASI SUBMIT
  document.querySelector('form')?.addEventListener('submit', function(e){
    if(metodeSelect.value === 'jemput'){
      if(!latInput.value || !lngInput.value){
        e.preventDefault();
        alert('Silakan pilih titik jemput di peta (klik peta / geser marker).');
        return;
      }
      if(!alamatInput.value || alamatInput.value.trim().length < 3){
        e.preventDefault();
        alert('Alamat wajib diisi jika metode jemput.');
        return;
      }
    }
  });
</script>
@endpush
