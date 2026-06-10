<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon/favicon.ico') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
  <title>{{ $artikel->judul }} | Kantin Kita</title>
  @if ($artikel->ringkasan)
    <meta name="description" content="{{ $artikel->ringkasan }}" />
  @endif
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap"
    rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --bg-light: #FBF5E8;
      --bg-white: #FFFFFF;
      --bg-dark: #42766A;
      --text-main: #744622;
      --text-muted: rgba(116, 70, 34, 0.72);
      --focus-ring: rgba(66, 118, 106, 0.28);
      --surface-soft: #F5EDD9;
      --accent: #42766A;
      --accent-dark: #2F5A4F;
      --accent-10: rgba(66, 118, 106, 0.12);
      --brown-10: rgba(116, 70, 34, 0.10);
      --brown-16: rgba(116, 70, 34, 0.16);

      --font-body: "Manrope", -apple-system, "Segoe UI", sans-serif;
      --font-display: "Space Grotesk", "Manrope", sans-serif;

      --fw-regular: 400;
      --fw-medium: 500;
      --fw-semibold: 600;
      --fw-bold: 700;

      --fs-body-lg: 1.125rem;
      --fs-body: 1rem;
      --fs-caption: 0.875rem;

      --space-2: 8px;
      --space-3: 12px;
      --space-4: 16px;
      --space-5: 20px;
      --space-6: 24px;
      --space-7: 32px;
      --space-8: 40px;
      --space-9: 48px;
      --space-10: 64px;

      --radius-soft: 16px;
      --radius-md: 18px;
    }

    body {
      font-family: var(--font-body);
      color: var(--text-main);
      background: var(--bg-light);
      line-height: 1.7;
      overflow-x: hidden;
      padding-top: 72px;
    }

    a, button, input { font: inherit; }

    a, button {
      transition: transform 0.2s ease, box-shadow 0.2s ease, opacity 0.2s ease, background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
    }

    a:focus-visible, button:focus-visible, input:focus-visible {
      outline: 3px solid var(--focus-ring);
      outline-offset: 2px;
    }

    /* ─── NAV ─── */
    .nav {
      width: 100%;
      min-height: 72px;
      background: rgba(251, 245, 232, 0.95);
      display: flex;
      align-items: center;
      padding: 0 var(--space-9);
      position: fixed;
      left: 0;
      right: 0;
      top: 0;
      z-index: 1000;
      border-bottom: 1px solid var(--brown-10);
      -webkit-backdrop-filter: blur(14px);
      backdrop-filter: blur(14px);
      transition: background-color 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
    }

    .nav.scrolled {
      background: rgba(251, 245, 232, 0.82);
      border-bottom-color: var(--brown-16);
      box-shadow: 0 6px 24px rgba(116, 70, 34, 0.12);
    }

    .nav-logo {
      font-family: var(--font-display);
      font-size: 1.75rem;
      font-weight: var(--fw-bold);
      line-height: 1;
      text-transform: uppercase;
      color: var(--text-main);
      text-decoration: none;
      margin-right: auto;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .nav-logo-img {
      width: 40px;
      height: 40px;
      border-radius: 12px;
      object-fit: cover;
      box-shadow: 0 4px 12px rgba(66, 118, 106, 0.25);
    }

    .nav-links {
      display: flex;
      gap: 36px;
      list-style: none;
      margin-right: 40px;
    }

    .nav-links a {
      font-size: var(--fs-body);
      font-weight: var(--fw-semibold);
      color: var(--text-muted);
      text-decoration: none;
      position: relative;
      padding-bottom: 4px;
    }

    .nav-links a::after {
      content: "";
      position: absolute;
      left: 0;
      bottom: 0;
      width: 100%;
      height: 2px;
      background: var(--text-main);
      transform: scaleX(0);
      transform-origin: center;
      transition: transform 0.2s ease;
    }

    .nav-links a:hover,
    .nav-links a:focus-visible,
    .nav-links a.active {
      color: var(--text-main);
    }

    .nav-links a:hover::after,
    .nav-links a:focus-visible::after,
    .nav-links a.active::after {
      transform: scaleX(1);
    }

    .nav-links a:active { transform: translateY(1px); }

    .btn-signup {
      font-size: var(--fs-body);
      font-weight: var(--fw-semibold);
      color: var(--text-main);
      border: 1px solid var(--text-main);
      border-radius: var(--radius-soft);
      padding: 10px 24px;
      background: transparent;
      cursor: pointer;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }

    .btn-signup:hover {
      background: var(--text-main);
      color: var(--bg-white);
      transform: translateY(-1px);
      box-shadow: 0 10px 20px rgba(116, 70, 34, 0.2);
    }

    .btn-signup:active { transform: translateY(0); box-shadow: none; }

    /* ─── HAMBURGER ─── */
    .nav-toggle {
      display: none;
      flex-direction: column;
      justify-content: center;
      gap: 5px;
      width: 36px;
      height: 36px;
      background: none;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      padding: 4px;
      margin-left: 16px;
    }

    .nav-toggle span {
      display: block;
      width: 100%;
      height: 2px;
      background: var(--text-main);
      border-radius: 2px;
    }

    .nav-mobile {
      display: none;
      flex-direction: column;
      background: rgba(251, 245, 232, 0.97);
      border-top: 1px solid var(--brown-10);
      padding: 16px 24px 24px;
      position: fixed;
      top: 72px;
      left: 0;
      right: 0;
      z-index: 999;
      -webkit-backdrop-filter: blur(10px);
      backdrop-filter: blur(10px);
      box-shadow: 0 16px 28px rgba(116, 70, 34, 0.12);
    }

    .nav-mobile.open { display: flex; }

    .nav-mobile a {
      font-size: var(--fs-body);
      font-weight: var(--fw-semibold);
      color: var(--text-main);
      text-decoration: none;
      padding: 12px 0;
      border-bottom: 1px solid var(--brown-10);
    }

    .nav-mobile a:hover,
    .nav-mobile a:focus-visible {
      color: var(--text-main);
      text-decoration: underline;
      text-underline-offset: 4px;
    }

    .nav-mobile a:active { transform: translateY(1px); }
    .nav-mobile a:last-child { border-bottom: none; }

    .nav-mobile-cta {
      margin-top: 16px;
      border: 1px solid var(--text-main) !important;
      border-radius: var(--radius-soft);
      text-align: center;
      padding: 12px 0 !important;
    }

    /* ─── ARTIKEL DETAIL ─── */
    .artikel-wrap {
      max-width: 780px;
      margin: 0 auto;
      padding: 40px 24px 80px;
    }

    .breadcrumb {
      font-size: 0.85rem;
      color: var(--text-muted);
      margin-bottom: 18px;
    }
    .breadcrumb a { color: var(--text-muted); text-decoration: none; }
    .breadcrumb a:hover { color: var(--accent); text-decoration: underline; }

    .artikel-header { margin-bottom: 28px; }

    .artikel-kategori {
      display: inline-block;
      background: var(--surface-soft);
      color: var(--accent-dark);
      font-size: 0.75rem;
      padding: 5px 12px;
      border-radius: 999px;
      text-transform: capitalize;
      margin-bottom: 14px;
    }

    .artikel-judul {
      font-family: var(--font-display);
      font-size: clamp(1.8rem, 3vw, 2.6rem);
      line-height: 1.2;
      margin-bottom: 14px;
    }

    .artikel-meta {
      color: var(--text-muted);
      font-size: 0.9rem;
      display: flex;
      gap: 16px;
      flex-wrap: wrap;
    }

    .artikel-cover-wrap {
      margin: 0 -24px 32px;
      border-radius: var(--radius-md);
      overflow: hidden;
    }
    .artikel-cover-wrap img {
      width: 100%;
      height: auto;
      max-height: 460px;
      object-fit: cover;
      display: block;
    }

    .artikel-ringkasan {
      font-size: 1.1rem;
      color: var(--text-main);
      background: var(--surface-soft);
      border-left: 4px solid var(--accent);
      padding: 16px 20px;
      border-radius: 8px;
      margin-bottom: 28px;
      font-style: italic;
    }

    .artikel-konten {
      font-size: 1.05rem;
      color: var(--text-main);
      word-wrap: break-word;
    }

    .artikel-konten p { margin-bottom: 1.2em; }
    .artikel-konten h2, .artikel-konten h3 {
      font-family: var(--font-display);
      color: var(--text-main);
      margin: 1.4em 0 0.6em;
    }
    .artikel-konten a { color: var(--accent); }

    .back-link {
      display: inline-block;
      margin-top: 40px;
      color: var(--accent);
      text-decoration: none;
      font-weight: 600;
    }
    .back-link:hover { text-decoration: underline; }

    .related-section {
      max-width: 1180px;
      margin: 0 auto;
      padding: 0 24px 80px;
    }
    .related-section h2 {
      font-family: var(--font-display);
      font-size: 1.4rem;
      margin-bottom: 20px;
    }
    .related-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 20px;
    }
    .related-card {
      background: var(--bg-white);
      border-radius: 14px;
      overflow: hidden;
      box-shadow: 0 2px 14px var(--brown-10);
      text-decoration: none;
      color: inherit;
      display: flex;
      flex-direction: column;
      transition: transform .15s;
    }
    .related-card:hover { transform: translateY(-3px); }
    .related-card img, .related-card .placeholder {
      width: 100%;
      height: 140px;
      object-fit: cover;
      background: var(--surface-soft);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--text-muted);
      font-size: 0.85rem;
    }
    .related-body { padding: 16px; }
    .related-body h3 {
      font-family: var(--font-display);
      font-size: 1rem;
      margin-bottom: 6px;
    }
    .related-body p {
      font-size: 0.85rem;
      color: var(--text-muted);
    }

    .site-footer {
      background: var(--accent);
      color: var(--bg-white);
      padding: 28px 24px;
      text-align: center;
      font-size: 0.9rem;
    }
    .site-footer a { color: var(--bg-white); text-decoration: none; margin: 0 12px; }
    .site-footer a:hover { text-decoration: underline; }

    @media (max-width: 768px) {
      .nav { padding: 0 20px; }
      .nav-links { display: none; }
      .btn-signup { display: none; }
      .nav-toggle { display: flex; }
      .artikel-cover-wrap { margin: 0 -16px 24px; border-radius: 0; }
    }
  </style>
</head>

<body>
  <header>
    <nav class="nav" aria-label="Navigasi utama">
      <a href="{{ route('home') }}" class="nav-logo">
        <img src="https://api.builder.io/api/v1/image/assets/TEMP/10a82c5c6d87de97d3583b6c8564df77f595f954?width=1114"
          alt="Logo" class="nav-logo-img" />Kantin Kita
      </a>
      <ul class="nav-links" role="list">
        <li><a href="{{ route('home') }}">Beranda</a></li>
        <li><a href="{{ route('home') }}#menu-title">Menu</a></li>
        <li><a href="{{ route('about') }}">Tentang</a></li>
        <li><a href="{{ route('artikel.index') }}" class="active">Artikel</a></li>
        <li><a href="{{ route('about') }}#kontak">Kontak</a></li>
      </ul>
      <a href="{{ route('login') }}" class="btn-signup">Login</a>
      <button class="nav-toggle" aria-label="Buka menu" aria-expanded="false" aria-controls="nav-mobile" id="nav-toggle">
        <span></span>
        <span></span>
        <span></span>
      </button>
    </nav>
    <div class="nav-mobile" id="nav-mobile" role="navigation" aria-label="Navigasi seluler">
      <a href="{{ route('home') }}">Beranda</a>
      <a href="{{ route('home') }}#menu-title">Menu</a>
      <a href="{{ route('about') }}">Tentang</a>
      <a href="{{ route('artikel.index') }}">Artikel</a>
      <a href="{{ route('about') }}#kontak">Kontak</a>
      <a href="{{ route('login') }}" class="nav-mobile-cta">Login</a>
    </div>
  </header>

  <main>
    <article class="artikel-wrap">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Beranda</a> &nbsp;/&nbsp;
        <a href="{{ route('artikel.index') }}">Artikel</a> &nbsp;/&nbsp;
        <span>{{ $artikel->judul }}</span>
      </nav>

      <header class="artikel-header">
        <span class="artikel-kategori">{{ str_replace('-', ' ', $artikel->kategori) }}</span>
        <h1 class="artikel-judul">{{ $artikel->judul }}</h1>
        <div class="artikel-meta">
          <span>{{ $artikel->published_at?->format('d M Y') }}</span>
          @if ($artikel->author)
            <span>oleh {{ $artikel->author->name }}</span>
          @endif
        </div>
      </header>

      @if ($artikel->gambar_sampul)
        <div class="artikel-cover-wrap">
          <img src="{{ asset('storage/' . $artikel->gambar_sampul) }}" alt="{{ $artikel->judul }}" />
        </div>
      @endif

      @if ($artikel->ringkasan)
        <div class="artikel-ringkasan">{{ $artikel->ringkasan }}</div>
      @endif

      <div class="artikel-konten">{!! nl2br(e($artikel->konten)) !!}</div>

      <a href="{{ route('artikel.index') }}" class="back-link">&larr; Kembali ke daftar artikel</a>
    </article>

    @if ($related->count() > 0)
      <section class="related-section" aria-labelledby="related-title">
        <h2 id="related-title">Artikel lainnya</h2>
        <div class="related-grid">
          @foreach ($related as $other)
            <a href="{{ route('artikel.show', $other->slug) }}" class="related-card">
              @if ($other->gambar_sampul)
                <img src="{{ asset('storage/' . $other->gambar_sampul) }}" alt="{{ $other->judul }}" />
              @else
                <div class="placeholder">Tanpa gambar</div>
              @endif
              <div class="related-body">
                <h3>{{ $other->judul }}</h3>
                <p>{{ $other->published_at?->format('d M Y') }}</p>
              </div>
            </a>
          @endforeach
        </div>
      </section>
    @endif
  </main>

  <footer class="site-footer">
    <div>
      <a href="{{ route('home') }}">Beranda</a>
      <a href="{{ route('about') }}">Tentang</a>
      <a href="{{ route('artikel.index') }}">Artikel</a>
      <a href="{{ route('about') }}#kontak">Kontak</a>
    </div>
    <div style="margin-top: 12px;">&copy; {{ date('Y') }} Kantin Kita</div>
  </footer>

  <script>
    const nav = document.querySelector('.nav');
    const updateNavOnScroll = () => {
      if (!nav) return;
      nav.classList.toggle('scrolled', window.scrollY > 18);
    };
    updateNavOnScroll();
    window.addEventListener('scroll', updateNavOnScroll, { passive: true });

    const toggle = document.getElementById('nav-toggle');
    const mobileNav = document.getElementById('nav-mobile');
    if (toggle && mobileNav) {
      toggle.addEventListener('click', () => {
        const isOpen = mobileNav.classList.toggle('open');
        toggle.setAttribute('aria-expanded', String(isOpen));
      });
    }
  </script>
</body>

</html>
