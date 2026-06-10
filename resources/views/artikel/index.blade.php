<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon/favicon.ico') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
  <title>Artikel | Kantin Kita</title>
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

      --fs-heading-lg: clamp(2rem, 2.6vw, 2.45rem);
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
      line-height: 1.55;
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

    /* ─── PAGE ─── */
    .page-hero {
      padding: 60px 24px 32px;
      max-width: 1180px;
      margin: 0 auto;
      text-align: center;
    }
    .page-hero h1 {
      font-family: var(--font-display);
      font-size: var(--fs-heading-lg);
      margin-bottom: 12px;
      color: var(--text-main);
    }
    .page-hero p {
      color: var(--text-muted);
      max-width: 640px;
      margin: 0 auto;
    }

    .artikel-grid {
      max-width: 1180px;
      margin: 0 auto;
      padding: 0 24px 80px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 24px;
    }

    .artikel-card {
      background: var(--bg-white);
      border-radius: var(--radius-md);
      overflow: hidden;
      box-shadow: 0 2px 14px var(--brown-10);
      display: flex;
      flex-direction: column;
      text-decoration: none;
      color: inherit;
      transition: transform .15s, box-shadow .15s;
    }

    .artikel-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 6px 22px var(--brown-10);
    }

    .artikel-cover {
      width: 100%;
      height: 200px;
      object-fit: cover;
      background: var(--surface-soft);
    }

    .artikel-cover-placeholder {
      width: 100%;
      height: 200px;
      background: var(--surface-soft);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--text-muted);
      font-size: 0.9rem;
    }

    .artikel-body {
      padding: 20px;
      display: flex;
      flex-direction: column;
      gap: 10px;
      flex: 1;
    }

    .artikel-kategori {
      display: inline-block;
      background: var(--surface-soft);
      color: var(--accent-dark);
      font-size: 0.75rem;
      padding: 4px 10px;
      border-radius: 999px;
      width: fit-content;
      text-transform: capitalize;
    }

    .artikel-judul {
      font-family: var(--font-display);
      font-size: 1.15rem;
      color: var(--text-main);
    }

    .artikel-ringkasan {
      color: var(--text-muted);
      font-size: 0.95rem;
      line-height: 1.55;
    }

    .artikel-meta {
      margin-top: auto;
      padding-top: 12px;
      color: var(--text-muted);
      font-size: 0.8rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .artikel-read-more {
      color: var(--accent);
      font-weight: 600;
      font-size: 0.85rem;
    }

    .empty-state {
      max-width: 640px;
      margin: 40px auto 80px;
      padding: 60px 24px;
      text-align: center;
      background: var(--bg-white);
      border-radius: var(--radius-md);
      box-shadow: 0 2px 14px var(--brown-10);
      color: var(--text-muted);
    }

    .pagination-wrap {
      max-width: 1180px;
      margin: 0 auto;
      padding: 0 24px 60px;
      display: flex;
      justify-content: center;
    }

    .pagination-wrap nav {
      display: flex;
      gap: 8px;
      align-items: center;
    }
    .pagination-wrap a, .pagination-wrap span {
      padding: 8px 14px;
      border-radius: 8px;
      text-decoration: none;
      color: var(--text-main);
      background: var(--bg-white);
      border: 1px solid var(--brown-10);
      font-size: 0.9rem;
    }
    .pagination-wrap a:hover { background: var(--surface-soft); }
    .pagination-wrap [aria-current="page"] span,
    .pagination-wrap .pagination-active {
      background: var(--accent);
      color: var(--bg-white);
      border-color: var(--accent);
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
    <section class="page-hero">
      <h1>Artikel Kantin Kita</h1>
      <p>Kabar terbaru, cerita, dan informasi seputar Kantin Kita serta para vendor di dalamnya.</p>
    </section>

    @if ($artikels->count() === 0)
      <div class="empty-state">
        <p>Belum ada artikel yang dipublikasikan.</p>
      </div>
    @else
      <div class="artikel-grid">
        @foreach ($artikels as $artikel)
          <a href="{{ route('artikel.show', $artikel->slug) }}" class="artikel-card">
            @if ($artikel->gambar_sampul)
              <img src="{{ asset('storage/' . $artikel->gambar_sampul) }}" alt="{{ $artikel->judul }}" class="artikel-cover" />
            @else
              <div class="artikel-cover-placeholder">Tanpa gambar</div>
            @endif
            <div class="artikel-body">
              <span class="artikel-kategori">{{ str_replace('-', ' ', $artikel->kategori) }}</span>
              <h2 class="artikel-judul">{{ $artikel->judul }}</h2>
              @if ($artikel->ringkasan)
                <p class="artikel-ringkasan">{{ $artikel->ringkasan }}</p>
              @endif
              <div class="artikel-meta">
                <span>{{ $artikel->published_at?->format('d M Y') }}</span>
                <span class="artikel-read-more">Baca &rarr;</span>
              </div>
            </div>
          </a>
        @endforeach
      </div>

      @if ($artikels->hasPages())
        <div class="pagination-wrap">
          {{ $artikels->links() }}
        </div>
      @endif
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
