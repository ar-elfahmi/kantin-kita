<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kantin Kita - Tentang, FAQ, dan Kontak</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap"
    rel="stylesheet" />
<style>
      *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

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

      --fw-medium: 500;
      --fw-semibold: 600;
      --fw-bold: 700;

      --fs-display: clamp(2rem, 3vw, 3.2rem);
      --fs-heading-lg: clamp(1.8rem, 2.3vw, 2.4rem);
      --fs-heading-md: clamp(1.4rem, 1.9vw, 1.9rem);
      --fs-body-lg: 1.125rem;
      --fs-body: 1rem;
      --fs-caption: 0.875rem;

      --lh-tight: 1.15;
      --lh-normal: 1.55;
      --lh-relaxed: 1.72;

      --space-4: 16px;
      --space-5: 20px;
      --space-6: 24px;
      --space-7: 32px;
      --space-8: 40px;
      --space-9: 48px;
      --space-10: 64px;

      --radius-soft: 16px;
      --radius-md: 18px;
      --radius-lg: 20px;
    }

    html {
      scroll-behavior: smooth;
    }

    body {
      font-family: var(--font-body);
      color: var(--text-main);
      background: var(--bg-light);
      line-height: var(--lh-normal);
      overflow-x: hidden;
      padding-top: 72px;
    }

    a,
    button,
    input,
    textarea {
      font: inherit;
    }

    a,
    button {
      transition: transform 0.2s ease, box-shadow 0.2s ease, opacity 0.2s ease, background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
    }

    a:focus-visible,
    button:focus-visible,
    input:focus-visible,
    textarea:focus-visible {
      outline: 3px solid var(--focus-ring);
      outline-offset: 2px;
    }

    .section-shell {
      width: min(1120px, calc(100% - 48px));
      margin: 0 auto;
    }

    /* NAV */
    .nav {
      width: 100%;
      min-height: 72px;
      background: rgba(251, 245, 232, 0.95);
      display: flex;
      align-items: center;
      padding: 0 48px;
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
      font-size: 1.65rem;
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
      gap: 34px;
      list-style: none;
      margin-right: 36px;
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

    .nav-mobile.open {
      display: flex;
    }

    .nav-mobile a {
      font-size: var(--fs-body);
      font-weight: var(--fw-semibold);
      color: var(--text-main);
      text-decoration: none;
      padding: 12px 0;
      border-bottom: 1px solid var(--brown-10);
    }

    .nav-mobile a:last-child {
      border-bottom: none;
    }

    .nav-mobile-cta {
      margin-top: 16px;
      border: 1px solid var(--text-main) !important;
      border-radius: var(--radius-soft);
      text-align: center;
      padding: 12px 0 !important;
    }

    /* HERO TENTANG */
    .about-hero {
      padding: 56px 0 48px;
      background: radial-gradient(circle at 90% 0%, rgba(66, 118, 106, 0.18), transparent 34%),
        linear-gradient(145deg, var(--bg-light) 0%, var(--surface-soft) 62%, rgba(66, 118, 106, 0.1) 100%);
    }

    .about-hero-inner {
      width: min(1120px, calc(100% - 48px));
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1.1fr 0.9fr;
      gap: 36px;
      align-items: stretch;
    }

    .about-kicker {
      display: inline-flex;
      width: fit-content;
      border-radius: 999px;
      border: 1px solid rgba(66, 118, 106, 0.35);
      background: rgba(255, 255, 255, 0.68);
      color: var(--accent-dark);
      padding: 7px 14px;
      font-size: 0.86rem;
      font-weight: var(--fw-semibold);
      letter-spacing: 0.02em;
      text-transform: uppercase;
    }

    .about-title {
      margin-top: 18px;
      font-family: var(--font-display);
      font-size: var(--fs-display);
      line-height: var(--lh-tight);
      letter-spacing: -0.02em;
    }

    .about-title .accent {
      color: var(--accent);
    }

    .about-intro {
      margin-top: 18px;
      max-width: 58ch;
      font-size: var(--fs-body-lg);
      color: var(--text-muted);
      line-height: var(--lh-relaxed);
    }

    .about-stats {
      margin-top: 28px;
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 14px;
    }

    .stat {
      border-radius: 14px;
      background: rgba(255, 255, 255, 0.72);
      border: 1px solid rgba(116, 70, 34, 0.12);
      padding: 14px 16px;
    }

    .stat strong {
      display: block;
      font-size: 1.25rem;
      font-weight: var(--fw-bold);
      color: var(--text-main);
    }

    .stat span {
      font-size: 0.86rem;
      color: var(--text-muted);
    }

    .hero-photo-card {
      background: var(--bg-white);
      border: 1px solid rgba(116, 70, 34, 0.2);
      border-radius: var(--radius-lg);
      padding: 14px;
      box-shadow: 0 14px 34px rgba(116, 70, 34, 0.14);
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .hero-photo {
      width: 100%;
      aspect-ratio: 4 / 3;
      object-fit: cover;
      border-radius: 14px;
      display: block;
    }

    .photo-caption {
      font-size: 0.95rem;
      color: var(--text-muted);
      padding: 0 4px 4px;
    }

    /* TENTANG KAMI */
    .about-story {
      padding: 76px 0;
    }

    .about-story-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 36px;
      align-items: center;
    }

    .story-image {
      width: 100%;
      border-radius: var(--radius-lg);
      border: 1px solid rgba(116, 70, 34, 0.16);
      box-shadow: 0 16px 36px rgba(116, 70, 34, 0.12);
      display: block;
      aspect-ratio: 5 / 4;
      object-fit: cover;
    }

    .story-title {
      font-family: var(--font-display);
      font-size: var(--fs-heading-lg);
      line-height: var(--lh-tight);
      letter-spacing: -0.01em;
    }

    .story-copy {
      margin-top: 16px;
      color: var(--text-muted);
      line-height: var(--lh-relaxed);
      font-size: 1.03rem;
    }

    .mission-list {
      margin-top: 24px;
      display: grid;
      gap: 12px;
      list-style: none;
    }

    .mission-list li {
      background: var(--bg-white);
      border: 1px solid rgba(116, 70, 34, 0.14);
      border-radius: 14px;
      padding: 14px 16px;
      display: flex;
      gap: 12px;
      align-items: flex-start;
    }

    .mission-bullet {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background: var(--accent);
      margin-top: 8px;
      flex-shrink: 0;
    }

    .mission-list strong {
      display: block;
      font-size: 1rem;
      color: var(--text-main);
      margin-bottom: 2px;
    }

    .mission-list span {
      color: var(--text-muted);
      font-size: 0.94rem;
    }

    /* FAQ */
    .faq {
      background: var(--bg-white);
      padding: 76px 0;
      border-top: 1px solid rgba(116, 70, 34, 0.08);
      border-bottom: 1px solid rgba(116, 70, 34, 0.08);
    }

    .section-title {
      font-family: var(--font-display);
      font-size: var(--fs-heading-lg);
      line-height: var(--lh-tight);
      letter-spacing: -0.01em;
      text-align: center;
    }

    .section-subtitle {
      text-align: center;
      max-width: 64ch;
      margin: 14px auto 0;
      color: var(--text-muted);
      line-height: var(--lh-relaxed);
    }

    .faq-list {
      margin-top: 32px;
      display: grid;
      gap: 12px;
    }

    .faq-item {
      border: 1px solid rgba(116, 70, 34, 0.18);
      border-radius: 14px;
      overflow: clip;
      background: var(--bg-white);
    }

    .faq-question {
      width: 100%;
      border: none;
      background: transparent;
      color: var(--text-main);
      text-align: left;
      padding: 18px 18px;
      font-size: 1rem;
      font-weight: var(--fw-semibold);
      line-height: 1.45;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 16px;
      cursor: pointer;
    }

    .faq-icon {
      width: 22px;
      height: 22px;
      border-radius: 50%;
      border: 1px solid rgba(116, 70, 34, 0.25);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: var(--accent-dark);
      font-size: 1.1rem;
      flex-shrink: 0;
      transition: transform 0.2s ease;
    }

    .faq-answer {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.26s ease;
    }

    .faq-answer p {
      padding: 0 18px 18px;
      color: var(--text-muted);
      line-height: var(--lh-relaxed);
    }

    .faq-item.open {
      background: linear-gradient(180deg, rgba(66, 118, 106, 0.06), rgba(66, 118, 106, 0.02));
    }

    .faq-item.open .faq-icon {
      transform: rotate(45deg);
      background: rgba(66, 118, 106, 0.12);
    }

    /* KONTAK */
    .contact {
      padding: 76px 0 88px;
    }

    .contact-grid {
      margin-top: 34px;
      display: grid;
      grid-template-columns: 1.05fr 0.95fr;
      gap: 24px;
    }

    .contact-card,
    .contact-info {
      background: var(--bg-white);
      border: 1px solid rgba(116, 70, 34, 0.15);
      border-radius: var(--radius-lg);
      box-shadow: 0 12px 26px rgba(116, 70, 34, 0.1);
    }

    .contact-card {
      padding: 26px;
    }

    .contact-card h3,
    .contact-info h3 {
      font-family: var(--font-display);
      font-size: var(--fs-heading-md);
      line-height: 1.2;
      letter-spacing: -0.01em;
    }

    .contact-card p,
    .contact-info p {
      margin-top: 10px;
      color: var(--text-muted);
    }

    .contact-form {
      margin-top: 18px;
      display: grid;
      gap: 12px;
    }

    .contact-form input,
    .contact-form textarea {
      width: 100%;
      border-radius: 14px;
      border: 1px solid rgba(116, 70, 34, 0.25);
      padding: 13px 14px;
      background: var(--bg-white);
      color: var(--text-main);
      font-size: 0.98rem;
      resize: vertical;
    }

    .contact-form textarea {
      min-height: 140px;
    }

    .contact-submit {
      margin-top: 4px;
      border: none;
      border-radius: var(--radius-md);
      background: var(--accent);
      color: var(--bg-white);
      font-weight: var(--fw-bold);
      height: 52px;
      cursor: pointer;
      box-shadow: 0 10px 22px rgba(66, 118, 106, 0.3);
    }

    .contact-submit:hover {
      background: var(--accent-dark);
      transform: translateY(-1px);
    }

    .form-feedback {
      margin-top: 12px;
      font-size: 0.93rem;
      color: var(--accent-dark);
      font-weight: var(--fw-semibold);
      min-height: 22px;
    }

    .contact-info {
      padding: 26px;
      display: flex;
      flex-direction: column;
      gap: 18px;
    }

    .info-list {
      display: grid;
      gap: 10px;
      list-style: none;
    }

    .info-list li {
      border-radius: 12px;
      border: 1px solid rgba(116, 70, 34, 0.14);
      background: rgba(251, 245, 232, 0.7);
      padding: 12px 14px;
    }

    .info-list strong {
      display: block;
      font-size: 0.96rem;
      color: var(--text-main);
    }

    .info-list span {
      color: var(--text-muted);
      font-size: 0.92rem;
    }

    .map-placeholder {
      border-radius: 14px;
      min-height: 180px;
      border: 1px solid rgba(116, 70, 34, 0.14);
      background: #f1ead7;
      padding: 0;
      overflow: hidden;
    }

    .map-placeholder-img {
      width: 100%;
      height: 100%;
      min-height: 180px;
      display: block;
      object-fit: cover;
    }

    /* FOOTER */
    .footer {
      background: var(--text-main);
      color: var(--bg-white);
      position: relative;
      overflow: hidden;
      padding: 52px 0 36px;
    }

    .footer-inner {
      position: relative;
      z-index: 2;
    }

    .footer-nav {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 80px;
      padding: 0 40px 40px;
    }

    .footer-nav-group {
      display: flex;
      gap: 40px;
    }

    .footer-wordmark {
      font-family: var(--font-display);
      font-size: 1.7rem;
      font-weight: var(--fw-bold);
      color: #fff;
      text-decoration: none;
    }

    .footer-nav-link {
      font-size: 0.95rem;
      font-weight: var(--fw-semibold);
      color: #fff;
      text-decoration: none;
      opacity: 0.9;
      text-underline-offset: 4px;
    }

    .footer-nav-link:hover,
    .footer-nav-link:focus-visible {
      text-decoration: underline;
      opacity: 1;
    }

    .footer-divider {
      border: none;
      border-top: 1px solid rgba(255, 255, 255, 0.24);
      margin: 0 80px;
    }

    .footer-social {
      display: flex;
      justify-content: center;
      gap: 24px;
      padding: 34px 0;
    }

    .social-link {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.15);
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background-color 0.25s ease, transform 0.25s ease;
    }

    .social-link:hover {
      background: rgba(255, 255, 255, 0.3);
      transform: translateY(-3px);
    }

    .footer-legal {
      display: flex;
      justify-content: center;
      gap: 32px;
      padding-bottom: 32px;
      flex-wrap: wrap;
    }

    .footer-legal-text {
      font-size: var(--fs-caption);
      font-weight: var(--fw-medium);
      color: #fff;
    }

    /* RESPONSIVE */
    @media (max-width: 980px) {
      .about-hero-inner,
      .about-story-grid,
      .contact-grid {
        grid-template-columns: 1fr;
      }

      .about-stats {
        grid-template-columns: repeat(2, minmax(0, 1fr));
      }

      .footer-nav {
        flex-direction: column;
        gap: 22px;
      }

      .footer-nav-group {
        flex-wrap: wrap;
        justify-content: center;
        gap: 18px;
      }
    }

    @media (max-width: 768px) {
      .nav {
        padding: 0 20px;
      }

      .nav-links,
      .btn-signup {
        display: none;
      }

      .nav-toggle {
        display: flex;
      }

      .section-shell,
      .about-hero-inner {
        width: min(1120px, calc(100% - 32px));
      }

      .about-hero {
        padding-top: 40px;
      }

      .about-stats {
        grid-template-columns: 1fr;
      }

      .faq-question {
        padding: 16px;
      }

      .faq-answer p {
        padding: 0 16px 16px;
      }

      .contact-card,
      .contact-info {
        padding: 20px;
      }

      .footer {
        padding: 46px 0 32px;
      }

      .footer-divider {
        margin: 0 24px;
      }

      .footer-legal {
        padding: 0 20px 32px;
      }
    }
</style>
</head>

<body>
  <header>
    <nav class="nav" aria-label="Navigasi utama">
      <a href="{{ route('home') }}" class="nav-logo"><img
          src="https://api.builder.io/api/v1/image/assets/TEMP/10a82c5c6d87de97d3583b6c8564df77f595f954?width=1114"
          alt="Logo" class="nav-logo-img" />Kantin Kita</a>
      <ul class="nav-links" role="list">
        <li><a href="{{ route('home') }}">Beranda</a></li>
        <li><a href="{{ route('home') }}#menu-title">Menu</a></li>
        <li><a href="{{ route('about') }}" class="active">Tentang</a></li>
        <li><a href="{{ route('about') }}#kontak">Kontak</a></li>
      </ul>
      <a href="{{ route('login') }}" class="btn-signup">Daftar</a>
      <button class="nav-toggle" aria-label="Buka menu" aria-expanded="false" aria-controls="nav-mobile"
        id="nav-toggle">
        <span></span>
        <span></span>
        <span></span>
      </button>
    </nav>
    <div class="nav-mobile" id="nav-mobile" role="navigation" aria-label="Navigasi seluler">
      <a href="{{ route('home') }}">Beranda</a>
      <a href="{{ route('home') }}#menu-title">Menu</a>
      <a href="{{ route('about') }}">Tentang</a>
      <a href="{{ route('about') }}#kontak">Kontak</a>
      <a href="{{ route('login') }}" class="nav-mobile-cta">Daftar</a>
    </div>
  </header>

  <main>
    <section class="about-hero" id="tentang" aria-labelledby="about-title">
      <div class="about-hero-inner">
        <div>
          <span class="about-kicker">Tentang Kantin Kita</span>
          <h1 class="about-title" id="about-title">Membuat jam makan di kampus jadi <span class="accent">lebih cepat,
              nyaman, dan pasti</span>.</h1>
          <p class="about-intro">Kantin Kita hadir untuk membantu mahasiswa dan civitas kampus memesan makanan tanpa
            antre. Kami menghubungkan pelanggan dengan tenant kantin melalui alur pemesanan yang sederhana, transparan,
            dan ramah waktu.</p>
          <div class="about-stats" aria-label="Ringkasan layanan Kantin Kita">
            <div class="stat">
              <strong>40+</strong>
              <span>Tenant aktif di area kampus</span>
            </div>
            <div class="stat">
              <strong>9.500+</strong>
              <span>Pesanan selesai setiap minggu</span>
            </div>
            <div class="stat">
              <strong>4.8/5</strong>
              <span>Rata-rata penilaian pengguna</span>
            </div>
          </div>
        </div>
        <article class="hero-photo-card" aria-label="Suasana kantin kampus">
          <img class="hero-photo"
            src="https://images.unsplash.com/photo-1576866209830-589e1bfbaa4d?w=900&q=80&auto=format&fit=crop"
            alt="Suasana ramai kantin kampus" />
          <p class="photo-caption">Dari jam sibuk hingga sore santai, semua pesanan dikelola agar waktu makanmu lebih
            efisien.</p>
        </article>
      </div>
    </section>

    <section class="about-story" aria-labelledby="story-title">
      <div class="section-shell about-story-grid">
        <img class="story-image"
          src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=900&q=80&auto=format&fit=crop"
          alt="Tim pengelola Kantin Kita berdiskusi" />
        <div>
          <h2 class="story-title" id="story-title">Visi dan misi kami</h2>
          <p class="story-copy">Kami percaya pengalaman makan di kampus seharusnya tidak menghabiskan waktu untuk antre.
            Karena itu, Kantin Kita dibangun dengan fokus pada kecepatan layanan, kejelasan proses, dan kemudahan akses
            bagi mahasiswa maupun mitra tenant.</p>
          <ul class="mission-list" role="list">
            <li>
              <span class="mission-bullet" aria-hidden="true"></span>
              <div>
                <strong>Visi</strong>
                <span>Menjadi platform pemesanan makanan kampus paling tepercaya di Indonesia.</span>
              </div>
            </li>
            <li>
              <span class="mission-bullet" aria-hidden="true"></span>
              <div>
                <strong>Misi 1</strong>
                <span>Menyediakan pengalaman pesan-ambil yang cepat dan minim hambatan.</span>
              </div>
            </li>
            <li>
              <span class="mission-bullet" aria-hidden="true"></span>
              <div>
                <strong>Misi 2</strong>
                <span>Mendorong tenant lokal berkembang lewat sistem pemesanan digital.</span>
              </div>
            </li>
            <li>
              <span class="mission-bullet" aria-hidden="true"></span>
              <div>
                <strong>Misi 3</strong>
                <span>Meningkatkan transparansi menu, waktu siap, dan opsi pembayaran cashless.</span>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </section>

    <section class="faq" id="faq" aria-labelledby="faq-title">
      <div class="section-shell">
        <h2 class="section-title" id="faq-title">Pertanyaan yang sering ditanyakan</h2>
        <p class="section-subtitle">Berikut beberapa jawaban cepat terkait pemesanan, pembayaran, dan dukungan layanan
          Kantin Kita.</p>

        <div class="faq-list" role="list">
          <article class="faq-item" role="listitem">
            <button class="faq-question" type="button" aria-expanded="false">
              Bagaimana cara memesan makanan tanpa antre?
              <span class="faq-icon" aria-hidden="true">+</span>
            </button>
            <div class="faq-answer" aria-hidden="true">
              <p>Pilih tenant dan menu, tentukan waktu ambil, lalu selesaikan pembayaran. Saat datang ke kantin, kamu
                cukup menunjukkan nomor pesanan untuk mengambil makanan.</p>
            </div>
          </article>

          <article class="faq-item" role="listitem">
            <button class="faq-question" type="button" aria-expanded="false">
              Apakah saya bisa memesan untuk jam makan siang dari pagi hari?
              <span class="faq-icon" aria-hidden="true">+</span>
            </button>
            <div class="faq-answer" aria-hidden="true">
              <p>Bisa. Fitur pre-order memungkinkan pemesanan lebih awal. Tenant akan menyiapkan pesanan mendekati waktu
                ambil yang kamu pilih.</p>
            </div>
          </article>

          <article class="faq-item" role="listitem">
            <button class="faq-question" type="button" aria-expanded="false">
              Metode pembayaran apa yang tersedia?
              <span class="faq-icon" aria-hidden="true">+</span>
            </button>
            <div class="faq-answer" aria-hidden="true">
              <p>Kantin Kita mendukung pembayaran digital seperti QRIS, e-wallet, dan transfer bank. Beberapa tenant juga
                menyediakan opsi bayar di tempat.</p>
            </div>
          </article>

          <article class="faq-item" role="listitem">
            <button class="faq-question" type="button" aria-expanded="false">
              Bagaimana jika pesanan saya terlambat atau tidak sesuai?
              <span class="faq-icon" aria-hidden="true">+</span>
            </button>
            <div class="faq-answer" aria-hidden="true">
              <p>Hubungi tim dukungan melalui form kontak di bawah ini atau email resmi kami. Sertakan nomor pesanan agar
                tim dapat membantu lebih cepat.</p>
            </div>
          </article>
        </div>
      </div>
    </section>

    <section class="contact" id="kontak" aria-labelledby="contact-title">
      <div class="section-shell">
        <h2 class="section-title" id="contact-title">Hubungi tim Kantin Kita</h2>
        <p class="section-subtitle">Kami siap membantu pertanyaan kerja sama tenant, kendala pemesanan, atau masukan
          untuk pengembangan platform.</p>

        <div class="contact-grid">
          <article class="contact-card" aria-label="Formulir kontak">
            <h3>Kirim pesan</h3>
            <p>Isi formulir berikut dan tim kami akan merespons secepat mungkin pada jam kerja.</p>
            <form class="contact-form" id="contactForm" novalidate>
              <label for="nama" class="visually-hidden">Nama lengkap</label>
              <input id="nama" name="nama" type="text" placeholder="Nama lengkap" autocomplete="name" required />

              <label for="email" class="visually-hidden">Email</label>
              <input id="email" name="email" type="email" placeholder="Email aktif" autocomplete="email" required />

              <label for="pesan" class="visually-hidden">Pesan</label>
              <textarea id="pesan" name="pesan" placeholder="Tulis pertanyaan atau pesan Anda" required></textarea>

              <button class="contact-submit" type="submit">Kirim Pesan</button>
            </form>
            <p class="form-feedback" id="formFeedback" aria-live="polite"></p>
          </article>

          <aside class="contact-info" aria-label="Informasi kontak">
            <h3>Informasi kontak</h3>
            <p>Kontak di bawah ini dapat disesuaikan sesuai kebutuhan institusi atau pengelola kantin.</p>
            <ul class="info-list" role="list">
              <li>
                <strong>Email</strong>
                <span>halo@kantinkita.id</span>
              </li>
              <li>
                <strong>Telepon</strong>
                <span>+62 801 2345 6789</span>
              </li>
              <li>
                <strong>Lokasi</strong>
                <span>Area Kantin Pusat, Kampus UNAIR, Surabaya</span>
              </li>
            </ul>
            <div class="map-placeholder">
              <img src="{{ asset('images/map-placeholder.png') }}" alt="Peta lokasi Kantin Kita" class="map-placeholder-img" />
            </div>
          </aside>
        </div>
      </div>
    </section>
  </main>

  <footer class="footer" aria-label="Footer situs">
    <div class="footer-inner">
      <nav class="footer-nav" aria-label="Navigasi footer">
        <div class="footer-nav-group">
          <a href="{{ route('home') }}" class="footer-nav-link">Beranda</a>
          <a href="{{ route('home') }}#menu-title" class="footer-nav-link">Menu</a>
          <a href="{{ route('login') }}" class="footer-nav-link">Promo</a>
        </div>
        <a href="{{ route('home') }}" class="footer-wordmark">Kantin Kita</a>
        <div class="footer-nav-group">
          <a href="{{ route('about') }}" class="footer-nav-link">Tentang</a>
          <a href="{{ route('about') }}#faq" class="footer-nav-link">FAQ</a>
          <a href="{{ route('about') }}#kontak" class="footer-nav-link">Kontak</a>
        </div>
      </nav>
      <hr class="footer-divider" />
      <div class="footer-social" aria-label="Tautan media sosial">
        <a href="#" class="social-link" aria-label="Instagram"><svg width="20" height="20" viewBox="0 0 24 24"
            fill="none">
            <path
              d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"
              fill="white" />
          </svg></a>
        <a href="#" class="social-link" aria-label="Facebook"><svg width="20" height="20" viewBox="0 0 24 24"
            fill="none">
            <path
              d="M24 12c0-6.627-5.373-12-12-12S0 5.373 0 12c0 5.99 4.388 10.954 10.125 11.854V15.47H7.078V12h3.047V9.356c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.875V12h3.328l-.532 3.47h-2.796v8.385C19.612 22.954 24 17.99 24 12z"
              fill="white" />
          </svg></a>
        <a href="#" class="social-link" aria-label="Twitter"><svg width="20" height="20" viewBox="0 0 24 24"
            fill="none">
            <path
              d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"
              fill="white" />
          </svg></a>
      </div>
      <div class="footer-legal">
        <span class="footer-legal-text">&copy; 2026 Kantin Kita</span>
        <span class="footer-legal-text">Privasi - Syarat</span>
      </div>
    </div>
  </footer>

  <style>
    .visually-hidden {
      position: absolute;
      width: 1px;
      height: 1px;
      padding: 0;
      margin: -1px;
      overflow: hidden;
      clip: rect(0, 0, 0, 0);
      white-space: nowrap;
      border: 0;
    }
  </style>
    <script>
          const nav = document.querySelector('.nav');
    const updateNavOnScroll = () => {
      if (!nav) {
        return;
      }
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

      const mobileLinks = mobileNav.querySelectorAll('a');
      mobileLinks.forEach((link) => {
        link.addEventListener('click', () => {
          mobileNav.classList.remove('open');
          toggle.setAttribute('aria-expanded', 'false');
        });
      });
    }

    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach((item) => {
      const button = item.querySelector('.faq-question');
      const answer = item.querySelector('.faq-answer');
      if (!button || !answer) {
        return;
      }

      button.addEventListener('click', () => {
        const isOpen = item.classList.contains('open');

        faqItems.forEach((otherItem) => {
          const otherButton = otherItem.querySelector('.faq-question');
          const otherAnswer = otherItem.querySelector('.faq-answer');
          otherItem.classList.remove('open');
          if (otherButton) {
            otherButton.setAttribute('aria-expanded', 'false');
          }
          if (otherAnswer) {
            otherAnswer.style.maxHeight = '0px';
            otherAnswer.setAttribute('aria-hidden', 'true');
          }
        });

        if (!isOpen) {
          item.classList.add('open');
          button.setAttribute('aria-expanded', 'true');
          answer.style.maxHeight = `${answer.scrollHeight}px`;
          answer.setAttribute('aria-hidden', 'false');
        }
      });
    });

    const contactForm = document.getElementById('contactForm');
    const formFeedback = document.getElementById('formFeedback');

    if (contactForm && formFeedback) {
      contactForm.addEventListener('submit', (event) => {
        event.preventDefault();
        const formData = new FormData(contactForm);
        const name = String(formData.get('nama') || '').trim();
        const email = String(formData.get('email') || '').trim();
        const message = String(formData.get('pesan') || '').trim();

        if (!name || !email || !message) {
          formFeedback.textContent = 'Mohon lengkapi semua kolom sebelum mengirim pesan.';
          return;
        }

        formFeedback.textContent = 'Terima kasih. Pesan Anda sudah kami terima dan akan segera ditindaklanjuti.';
        contactForm.reset();
      });
    }
    </script>
</body>

</html>

