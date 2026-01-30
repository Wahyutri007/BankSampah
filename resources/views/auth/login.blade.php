<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Masuk • SampahKu</title>

  <!-- Bootstrap 5 (CDN) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons (CDN) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root{
      --brand:#16a34a;
      --brand2:#0ea5e9;
      --ink:#0b1220;
      --muted:#6b7280;
      --line: rgba(15, 23, 42, .12);
      --shadow: 0 18px 60px rgba(2,6,23,.10);
      --radius: 16px;
    }

    html, body { height: 100%; }
    body{ margin:0; background:#f6f8fb; color: var(--ink); }

    /* top accent line like the sample */
    .top-accent{
      height: 4px;
      background: linear-gradient(90deg, var(--brand2), var(--brand), #ef4444);
    }

    .split{ min-height: calc(100vh - 4px); }

    /* LEFT: image hero */
    .hero{
      min-height: calc(100vh - 4px);
      position: relative;
      display:flex;
      align-items:center;
      justify-content:center;
      padding: clamp(22px, 4vw, 56px);
      overflow:hidden;

      /* GANTI GAMBAR DI SINI (taruh file di public/images/sampahku-bg.jpg) */
      background:
        linear-gradient(135deg, rgba(2,6,23,.78), rgba(2,6,23,.40)),
        url("{{ asset('images/sampahku-bg.jpg') }}");
      background-size: cover;
      background-position: center;
    }

    /* subtle diagonal overlay for professional look */
    .hero::after{
      content:"";
      position:absolute; inset:0;
      background:
        linear-gradient(135deg, rgba(255,255,255,.08), transparent 55%),
        radial-gradient(900px 500px at 15% 25%, rgba(14,165,233,.22), transparent 60%),
        radial-gradient(900px 500px at 85% 10%, rgba(22,163,74,.22), transparent 60%);
      pointer-events:none;
      mix-blend-mode: screen;
      opacity: .55;
    }

    .hero-inner{
      position: relative;
      z-index: 1;
      width: min(680px, 100%);
      color: #fff;
      text-align: center;
    }

    .brand-row{
      display:inline-flex;
      align-items:center;
      gap:.65rem;
      padding:.45rem .75rem;
      border-radius: 999px;
      background: rgba(255,255,255,.10);
      border: 1px solid rgba(255,255,255,.16);
      backdrop-filter: blur(6px);
    }
    .dot{
      width:10px; height:10px; border-radius:50%;
      background: linear-gradient(135deg, var(--brand), var(--brand2));
      box-shadow: 0 0 0 6px rgba(22,163,74,.18);
    }

    .hero-title{
      margin-top: 14px;
      font-weight: 800;
      letter-spacing: -.02em;
      line-height: 1.12;
      font-size: clamp(1.9rem, 3.1vw, 2.8rem);
    }
    .hero-sub{
      margin-top: 10px;
      color: rgba(255,255,255,.82);
      max-width: 54ch;
      margin-left:auto; margin-right:auto;
      font-size: 1.02rem;
    }

    /* feature chips like sample */
    .chips{
      margin-top: 22px;
      display:grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 12px;
    }
    .chip{
      display:flex;
      align-items:center;
      gap: 10px;
      padding: 12px 14px;
      border-radius: 12px;
      background: rgba(255,255,255,.10);
      border: 1px solid rgba(255,255,255,.18);
      backdrop-filter: blur(6px);
      text-align: left;
    }
    .chip i{
      width: 34px; height: 34px;
      display:grid; place-items:center;
      border-radius: 10px;
      background: rgba(22,163,74,.20);
      border: 1px solid rgba(255,255,255,.14);
      color: #d1fae5;
      font-size: 1.05rem;
      flex: 0 0 auto;
    }
    .chip b{
      display:block;
      font-size: .98rem;
      font-weight: 700;
      color: #fff;
    }
    .chip span{
      display:block;
      font-size: .88rem;
      color: rgba(255,255,255,.75);
      line-height: 1.2;
    }

    /* RIGHT: form panel */
    .form-side{
      min-height: calc(100vh - 4px);
      display:flex;
      align-items:center;
      justify-content:center;
      padding: clamp(20px, 3vw, 44px);
      background: #fff;
    }

    .form-card{
      width: min(520px, 100%);
      padding: clamp(18px, 3vw, 32px);
      border: 1px solid var(--line);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      background: #fff;
    }

    .form-title{
      font-weight: 800;
      letter-spacing: -.02em;
      margin: 0;
    }
    .form-title .accent{
      background: linear-gradient(90deg, var(--brand2), var(--brand));
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }
    .form-sub{
      margin-top: 6px;
      color: var(--muted);
      margin-bottom: 18px;
    }

    .form-label{ font-weight: 600; color: rgba(2,6,23,.80); }
    .input-group-text{
      background: #fff;
      border-color: rgba(15,23,42,.14);
      color: rgba(2,6,23,.55);
    }
    .form-control{
      border-color: rgba(15,23,42,.14);
    }
    .form-control:focus{
      border-color: rgba(22,163,74,.55);
      box-shadow: 0 0 0 .25rem rgba(22,163,74,.12);
    }

    .btn-brand{
      background: var(--brand);
      border-color: var(--brand);
      box-shadow: 0 12px 22px rgba(22,163,74,.18);
      padding: .75rem 1rem;
      font-weight: 700;
    }
    .btn-brand:hover{ filter: brightness(1.02); }

    .mini{
      font-size: .92rem;
      color: rgba(2,6,23,.55);
    }
    .link{
      color: rgba(2,6,23,.66);
      text-decoration: none;
      font-weight: 600;
    }
    .link:hover{ color: rgba(2,6,23,.88); text-decoration: underline; }

    .hr-soft{
      height:1px;
      background: rgba(15,23,42,.10);
      border:0;
      margin: 14px 0;
    }

    @media (max-width: 991.98px){
      .hero, .form-side{ min-height: auto; }
      .hero{ padding-top: 36px; padding-bottom: 36px; }
      .chips{ grid-template-columns: 1fr; }
      .hero-inner{ text-align: left; }
      .hero-sub{ margin-left:0; margin-right:0; }
    }
  </style>
</head>

<body>
  <div class="top-accent"></div>

  <div class="container-fluid split">
    <div class="row g-0">

      <!-- LEFT: image -->
      <section class="col-12 col-lg-7 hero">
        <div class="hero-inner">
          <div class="brand-row">
            <span class="dot"></span>
            <span class="fw-bold">SampahKu</span>
          </div>

          <div class="hero-title">Aplikasi Laporan Sampah</div>
          <div class="hero-sub">
            Catat & pantau laporan dengan cepat. Tampilan rapi, fokus ke hal penting.
          </div>

          <div class="chips">
            <div class="chip">
              <i class="bi bi-clipboard-check"></i>
              <div>
                <b>Laporan Harian</b>
                <span>Input cepat & jelas</span>
              </div>
            </div>
            <div class="chip">
              <i class="bi bi-graph-up"></i>
              <div>
                <b>Rekap Data</b>
                <span>Ringkas & mudah dibaca</span>
              </div>
            </div>
            <div class="chip">
              <i class="bi bi-geo-alt"></i>
              <div>
                <b>Lokasi / Area</b>
                <span>Tracking sederhana</span>
              </div>
            </div>
            <div class="chip">
              <i class="bi bi-shield-check"></i>
              <div>
                <b>Keamanan</b>
                <span>Akses berbasis akun</span>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- RIGHT: form -->
      <section class="col-12 col-lg-5 form-side">
        <div class="form-card">

          <h1 class="h4 form-title">Masuk ke <span class="accent">SampahKu</span></h1>
          <div class="form-sub">Silakan masuk dengan akun Anda.</div>

          <!-- Session Status -->
          @if (session('status'))
            <div class="alert alert-success bg-opacity-10 border border-success border-opacity-25 mb-3">
              <i class="bi bi-check-circle me-1"></i> {{ session('status') }}
            </div>
          @endif

          <!-- Errors -->
          @if ($errors->any())
            <div class="alert alert-danger bg-opacity-10 border border-danger border-opacity-25 mb-3">
              <div class="d-flex gap-2">
                <i class="bi bi-exclamation-triangle"></i>
                <div>
                  <div class="fw-semibold mb-1">Periksa kembali:</div>
                  <ul class="mb-0 small">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              </div>
            </div>
          @endif

          <form method="POST" action="{{ route('login') }}" novalidate>
            @csrf

            <div class="mb-3">
              <label for="email" class="form-label">Alamat Email <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input
                  id="email"
                  type="email"
                  name="email"
                  value="{{ old('email') }}"
                  class="form-control @error('email') is-invalid @enderror"
                  placeholder="nama@email.com"
                  required
                  autofocus
                  autocomplete="username"
                >
                @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="mini mt-1"><i class="bi bi-info-circle me-1"></i> Gunakan email yang terdaftar.</div>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Kata Sandi <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input
                  id="password"
                  type="password"
                  name="password"
                  class="form-control @error('password') is-invalid @enderror"
                  placeholder="Masukkan kata sandi"
                  required
                  autocomplete="current-password"
                >
                <button class="btn btn-outline-secondary" type="button" id="togglePassword" aria-label="Tampilkan password">
                  <i class="bi bi-eye"></i>
                </button>
              </div>
              @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>

            <hr class="hr-soft">

            <div class="d-flex align-items-center justify-content-between mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember_me" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label mini" for="remember_me">Ingat saya di perangkat ini</label>
              </div>

              @if (Route::has('password.request'))
                <a class="link mini" href="{{ route('password.request') }}">Lupa sandi?</a>
              @endif
            </div>

            <button type="submit" class="btn btn-brand text-white w-100">
              <i class="bi bi-box-arrow-in-right me-1"></i> Masuk ke Sistem
            </button>

            <div class="text-center mt-3 mini">
              @if (Route::has('register'))
                Belum punya akun? <a class="link" href="{{ route('register') }}">Daftar</a>
              @else
                © {{ date('Y') }} SampahKu. All rights reserved.
              @endif
            </div>
          </form>

        </div>
      </section>

    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const toggleBtn = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    if (toggleBtn && passwordInput) {
      toggleBtn.addEventListener('click', () => {
        const hidden = passwordInput.type === 'password';
        passwordInput.type = hidden ? 'text' : 'password';
        toggleBtn.innerHTML = hidden ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
      });
    }
  </script>
</body>
</html>
