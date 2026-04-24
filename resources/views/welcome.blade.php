<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kantin Kita â€” Pesan Makanan Tanpa Antri</title>
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

      --fw-regular: 400;
      --fw-medium: 500;
      --fw-semibold: 600;
      --fw-bold: 700;

      --fs-display: clamp(2.35rem, 3.4vw, 3.5rem);
      --fs-heading-lg: clamp(2rem, 2.6vw, 2.45rem);
      --fs-heading-md: clamp(1.65rem, 2.1vw, 2rem);
      --fs-body-lg: 1.125rem;
      --fs-body: 1rem;
      --fs-caption: 0.875rem;

      --lh-tight: 1.15;
      --lh-normal: 1.55;
      --lh-relaxed: 1.72;

      --space-2: 8px;
      --space-3: 12px;
      --space-4: 16px;
      --space-5: 20px;
      --space-6: 24px;
      --space-7: 32px;
      --space-8: 40px;
      --space-9: 48px;
      --space-10: 64px;
      --space-11: 80px;

      --radius-soft: 16px;
      --radius-md: 18px;
      --radius-lg: 20px;
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
    input {
      font: inherit;
    }

    a,
    button {
      transition: transform 0.2s ease, box-shadow 0.2s ease, opacity 0.2s ease, background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
    }

    a:focus-visible,
    button:focus-visible,
    input:focus-visible {
      outline: 3px solid var(--focus-ring);
      outline-offset: 2px;
    }

    /* â”€â”€â”€ NAV â”€â”€â”€ */
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
    .nav-links a:focus-visible {
      color: var(--text-main);
    }

    .nav-links a:hover::after,
    .nav-links a:focus-visible::after {
      transform: scaleX(1);
    }

    .nav-links a:active {
      transform: translateY(1px);
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

    .btn-signup:active {
      transform: translateY(0);
      box-shadow: none;
    }

    /* â”€â”€â”€ HERO â”€â”€â”€ */
    .hero {
      background: var(--bg-light);
      min-height: auto;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 40px 40px 24px;
      position: relative;
      overflow-x: clip;
      overflow-y: visible;
    }

    .hero-bg-shapes {
      position: absolute;
      inset: 0;
      pointer-events: none;
      overflow: visible;
    }

    .hero-circle-right {
      position: absolute;
      width: clamp(450px, 30vw, 450px);
      height: auto;
      top: -20px;
      right: -30px;
      object-fit: contain;
      z-index: 1;
    }

    .hero-circle-left {
      position: absolute;
      width: 774px;
      height: 774px;
      top: auto;
      left: -387px;
      bottom: -387px;
      object-fit: cover;
      border-radius: 50%;
    }

    .hero-headline {
      font-family: var(--font-display);
      font-size: var(--fs-display);
      font-weight: var(--fw-semibold);
      color: var(--text-main);
      text-align: center;
      line-height: var(--lh-tight);
      letter-spacing: -0.02em;
      max-width: 820px;
      position: relative;
      z-index: 2;
    }

    .headline-brown {
      color: var(--text-main);
    }

    .headline-green {
      color: var(--accent);
    }

    .hero-subheadline {
      font-size: var(--fs-body-lg);
      font-weight: var(--fw-medium);
      color: var(--text-muted);
      text-align: center;
      margin-top: var(--space-6);
      max-width: 560px;
      line-height: var(--lh-relaxed);
      position: relative;
      z-index: 2;
    }

    .btn-primary {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: var(--accent);
      color: var(--bg-white);
      font-size: var(--fs-body);
      font-weight: var(--fw-bold);
      letter-spacing: 0.01em;
      font-family: var(--font-body);
      border: none;
      border-radius: var(--radius-md);
      padding: 0 42px;
      height: 58px;
      cursor: pointer;
      text-decoration: none;
      margin-top: var(--space-7);
      position: relative;
      z-index: 2;
      box-shadow: 0 10px 22px rgba(66, 118, 106, 0.28);
    }

    .btn-primary:hover {
      background: var(--accent-dark);
      transform: translateY(-2px);
      box-shadow: 0 14px 28px rgba(47, 90, 79, 0.34);
    }

    .btn-primary:active {
      transform: translateY(0);
      box-shadow: 0 6px 14px rgba(47, 90, 79, 0.26);
    }

    .hero-mockup {
      margin-top: var(--space-9);
      width: 800px;
      max-width: 100%;
      background: var(--bg-white);
      border: 1px solid rgba(116, 70, 34, 0.35);
      border-radius: var(--radius-lg);
      position: relative;
      z-index: 2;
      box-shadow: 0 18px 42px rgba(116, 70, 34, 0.14);
    }

    .mockup-bar {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 12px 18px;
      border-bottom: 1px solid rgba(116, 70, 34, 0.35);
    }

    .mockup-dot {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      border: 1px solid rgba(116, 70, 34, 0.45);
      background: transparent;
    }

    .mockup-body {
      height: 300px;
      overflow: hidden;
      border-radius: 0 0 calc(var(--radius-lg) - 1px) calc(var(--radius-lg) - 1px);
    }

    .mockup-img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      border-radius: inherit;
    }

    /* â”€â”€â”€ TESTIMONIAL â”€â”€â”€ */
    .testimonial {
      background: var(--bg-light);
      padding: 92px 40px 84px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 400px;
    }

    .testimonial figure {
      display: flex;
      flex-direction: column;
      align-items: center;
      max-width: 981px;
    }

    .testimonial-quote {
      font-size: clamp(1.4rem, 2vw, 1.8rem);
      font-weight: var(--fw-medium);
      color: var(--text-main);
      text-align: center;
      line-height: 1.5;
      font-style: normal;
      letter-spacing: -0.01em;
    }

    .testimonial figcaption {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      margin-top: var(--space-7);
    }

    .testimonial-avatar {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      object-fit: cover;
      margin-top: 0;
      flex-shrink: 0;
      box-shadow: 0 8px 20px rgba(66, 118, 106, 0.28);
    }

    .testimonial-role {
      font-size: 0.82rem;
      font-weight: var(--fw-medium);
      color: var(--accent);
    }

    .testimonial-author {
      font-size: 0.95rem;
      font-weight: var(--fw-semibold);
      color: var(--text-main);
      text-align: left;
      margin-top: 0;
      line-height: 1.45;
    }

    /* â”€â”€â”€ DARK FEATURE â”€â”€â”€ */
    .dark-feature {
      background: linear-gradient(135deg, var(--accent) 0%, var(--accent-dark) 100%);
      padding: 80px 100px;
      display: flex;
      align-items: center;
      gap: 72px;
      min-height: 580px;
      overflow: hidden;
    }

    .dark-feature-content {
      flex: 0 0 420px;
      max-width: 420px;
    }

    .dark-feature-title {
      font-family: var(--font-display);
      font-size: clamp(2.2rem, 3vw, 2.8rem);
      color: #fff;
      font-weight: var(--fw-bold);
      line-height: var(--lh-tight);
      letter-spacing: -0.02em;
    }

    .dark-feature-description {
      font-size: 1.2rem;
      color: rgba(255, 255, 255, 0.9);
      margin-top: var(--space-7);
      line-height: var(--lh-relaxed);
    }

    .dark-feature-testimonial {
      font-size: 1.05rem;
      color: rgba(255, 255, 255, 0.88);
      margin-top: var(--space-7);
      line-height: var(--lh-relaxed);
      font-style: italic;
      min-height: 80px;
      transition: opacity 0.4s ease;
    }

    .dark-feature-author {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-top: 12px;
      transition: opacity 0.4s ease;
    }

    .dark-feature-author-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      flex-shrink: 0;
      border: 2px solid rgba(255, 255, 255, 0.5);
    }

    .dark-feature-author-name {
      font-size: 0.95rem;
      font-weight: var(--fw-semibold);
      color: #fff;
    }

    .dark-feature-author-role {
      font-size: 0.82rem;
      font-weight: var(--fw-medium);
      color: rgba(255, 255, 255, 0.7);
      margin-top: 2px;
    }

    /* â”€â”€ Carousel Media â”€â”€ */
    .dark-feature-media {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      min-height: 420px;
      cursor: grab;
      user-select: none;
      -webkit-user-select: none;
    }

    .dark-feature-media:active {
      cursor: grabbing;
    }

    .carousel-track {
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      width: 100%;
      height: 420px;
    }

    .carousel-card {
      position: absolute;
      border-radius: var(--radius-lg);
      overflow: hidden;
      box-shadow: 0 16px 36px rgba(0, 0, 0, 0.25);
      transition: all 0.5s cubic-bezier(0.22, 1, 0.36, 1);
      cursor: pointer;
    }

    .carousel-card img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    .carousel-card.active {
      width: 280px;
      height: 380px;
      z-index: 3;
      transform: translateX(0) scale(1);
      box-shadow: 0 24px 48px rgba(0, 0, 0, 0.35);
    }

    .carousel-card.prev {
      width: 220px;
      height: 300px;
      z-index: 2;
      transform: translateX(-180px) scale(0.88);
      opacity: 0.7;
      filter: brightness(0.75);
    }

    .carousel-card.next {
      width: 220px;
      height: 300px;
      z-index: 2;
      transform: translateX(180px) scale(0.88);
      opacity: 0.7;
      filter: brightness(0.75);
    }

    .carousel-card.far-prev {
      width: 180px;
      height: 240px;
      z-index: 1;
      transform: translateX(-300px) scale(0.75);
      opacity: 0.35;
      filter: brightness(0.6);
    }

    .carousel-card.far-next {
      width: 180px;
      height: 240px;
      z-index: 1;
      transform: translateX(300px) scale(0.75);
      opacity: 0.35;
      filter: brightness(0.6);
    }

    .carousel-card.hidden {
      opacity: 0;
      pointer-events: none;
      transform: translateX(0) scale(0.6);
    }

    .carousel-dots {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-top: 24px;
    }

    .carousel-dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      border: 2px solid rgba(255, 255, 255, 0.5);
      background: transparent;
      cursor: pointer;
      transition: all 0.3s ease;
      padding: 0;
    }

    .carousel-dot.active {
      background: #fff;
      border-color: #fff;
      transform: scale(1.2);
    }

    .carousel-dot:hover {
      border-color: #fff;
    }

    /* â”€â”€â”€ FEATURE CARDS â”€â”€â”€ */
    .feature-cards {
      background: var(--bg-white);
      padding: 80px;
    }

    .section-header {
      text-align: center;
      margin-bottom: 48px;
    }

    .section-title {
      font-family: var(--font-display);
      font-size: var(--fs-heading-lg);
      font-weight: var(--fw-semibold);
      color: var(--text-main);
      line-height: var(--lh-tight);
      letter-spacing: -0.01em;
    }

    .section-tagline {
      font-size: var(--fs-body-lg);
      font-weight: var(--fw-medium);
      color: var(--text-muted);
      margin-top: 12px;
      font-style: italic;
      line-height: var(--lh-normal);
    }

    .cards-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 24px;
    }

    .card {
      background: var(--bg-white);
      border-radius: var(--radius-lg);
      overflow: hidden;
      box-shadow: 0 14px 32px rgba(116, 70, 34, 0.11);
      transition: transform 0.25s ease, box-shadow 0.25s ease;
      padding: 32px;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 24px;
      text-align: center;
    }

    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 22px 36px rgba(116, 70, 34, 0.18);
    }

    .feature-icon {
      width: 80px;
      height: 80px;
      border-radius: 20px;
      background: var(--accent-10);
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
    }

    .card:hover .feature-icon {
      background: var(--accent);
    }

    .card:hover .feature-icon svg path {
      fill: white;
    }

    .card-title {
      font-size: 1.15rem;
      font-weight: var(--fw-bold);
      color: var(--text-main);
      line-height: 1.35;
    }

    .card-desc {
      font-size: 1rem;
      font-weight: var(--fw-medium);
      color: var(--text-muted);
      line-height: var(--lh-normal);
    }

    /* â”€â”€â”€ POPULAR MENU â”€â”€â”€ */
    .menu-section {
      padding: 48px 48px;
      background: var(--bg-light);
    }

    .menu-section .section-header {
      padding: 0 40px;
      margin-bottom: 48px;
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      text-align: left;
    }

    .menu-header-text {
      text-align: left;
    }

    .btn-detail {
      font-size: 0.9rem;
      font-weight: var(--fw-bold);
      color: var(--accent);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 4px;
      transition: color 0.2s ease;
    }

    .btn-detail:hover {
      color: var(--accent-dark);
      text-decoration: underline;
    }

    .menu-card {
      background: var(--bg-white);
      border-radius: var(--radius-lg);
      overflow: hidden;
      box-shadow: 0 10px 24px rgba(116, 70, 34, 0.08);
      transition: all 0.3s ease;
      display: flex;
      flex-direction: column;
    }

    .menu-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 32px rgba(116, 70, 34, 0.12);
    }

    .menu-card-img {
      position: relative;
      height: 180px;
      overflow: hidden;
      background: var(--bg-light);
    }

    .menu-card-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }

    .menu-card:hover .menu-card-img img {
      transform: scale(1.08);
    }

    .menu-badge {
      position: absolute;
      top: 12px;
      right: 12px;
      padding: 6px 12px;
      border-radius: 12px;
      font-size: 0.8rem;
      font-weight: var(--fw-bold);
      color: var(--bg-white);
    }

    .badge-bestseller {
      background: var(--accent);
    }

    .badge-promo {
      background: var(--text-main);
    }

    .menu-card-body {
      padding: 20px;
      display: flex;
      flex-direction: column;
      gap: 12px;
      flex: 1;
    }

    .menu-card-header {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 8px;
    }

    .menu-card-name {
      font-size: 1.1rem;
      font-weight: var(--fw-bold);
      color: var(--text-main);
      line-height: 1.3;
    }

    .menu-rating {
      display: flex;
      align-items: center;
      gap: 4px;
      flex-shrink: 0;
    }

    .menu-rating svg {
      width: 14px;
      height: 14px;
      fill: var(--accent);
    }

    .rating-value {
      font-weight: var(--fw-bold);
      color: var(--accent);
      font-size: 0.9rem;
    }

    .menu-card-desc {
      font-size: 0.9rem;
      color: var(--text-muted);
      line-height: 1.4;
      flex: 1;
    }

    .menu-card-footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: 4px;
    }



    /* â”€â”€â”€ CHATBOT SECTION â”€â”€â”€ */
    .chatbot-section {
      padding: 96px 5%;
      background: var(--bg-white);
    }

    .chatbot-inner {
      max-width: var(--container-max);
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      gap: 24px;
    }

    .chatbot-shell {
      display: grid;
      grid-template-columns: 1fr 1.35fr;
      gap: 32px;
      align-items: stretch;
    }

    .chatbot-cta-card {
      border-radius: var(--radius-lg);
      padding: 48px 40px;
      background-image: linear-gradient(145deg, rgba(47, 90, 79, 0.85), rgba(66, 118, 106, 0.95)), url('https://images.unsplash.com/photo-1577563908411-5077b6dc7624?w=800&q=80&auto=format&fit=crop');
      background-size: cover;
      background-position: center;
      border: 1px solid rgba(116, 70, 34, 0.1);
      box-shadow: 0 14px 32px rgba(116, 70, 34, 0.11);
      display: flex;
      flex-direction: column;
      gap: 20px;
      position: relative;
      overflow: hidden;
      color: var(--bg-white);
    }

    .chatbot-cta-eyebrow {
      font-size: 0.95rem;
      font-weight: var(--fw-semibold);
      letter-spacing: -0.01em;
      color: var(--surface-soft);
      text-transform: uppercase;
      margin: 0;
    }

    .chatbot-cta-title {
      font-family: var(--font-display);
      font-size: var(--fs-heading-sm);
      font-weight: var(--fw-bold);
      color: var(--bg-white);
      letter-spacing: -0.02em;
      line-height: var(--lh-tight);
      margin: 0;
    }

    .chatbot-cta-copy {
      font-size: 1rem;
      font-weight: var(--fw-medium);
      color: rgba(255, 255, 255, 0.85);
      line-height: var(--lh-relaxed);
      margin: 0;
    }

    .chatbot-chip-list {
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      margin-top: 16px;
    }

    .chatbot-chip {
      border: none;
      border-radius: var(--radius-full);
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      color: var(--bg-white);
      font-size: 0.9rem;
      font-family: var(--font-body);
      font-weight: var(--fw-semibold);
      padding: 12px 20px;
      cursor: pointer;
      transition: all 0.25s ease;
      border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .chatbot-chip:hover {
      transform: translateY(-2px);
      background: rgba(255, 255, 255, 0.25);
      border-color: rgba(255, 255, 255, 0.5);
    }

    /* â”€â”€â”€ CHATBOT UI â”€â”€â”€ */
    .chatbot-panel {
      border-radius: var(--radius-lg);
      background: var(--surface-soft);
      border: 1px solid rgba(116, 70, 34, 0.15);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
      overflow: hidden;
      display: flex;
      flex-direction: column;
    }

    .chatbot-panel-head {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 20px 24px;
      background: var(--bg-white);
      border-bottom: 1px solid rgba(116, 70, 34, 0.15);
    }

    .chatbot-panel-title {
      font-size: 1.15rem;
      font-weight: var(--fw-bold);
      color: var(--text-main);
    }

    .chatbot-status {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-size: 0.9rem;
      font-weight: var(--fw-semibold);
      color: var(--accent-dark);
    }

    .chatbot-status-dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background: var(--accent);
      box-shadow: 0 0 0 4px var(--accent-10);
    }

    .chatbot-messages {
      display: flex;
      flex-direction: column;
      gap: 14px;
      padding: 24px;
      height: 320px;
      overflow-y: auto;
      background: linear-gradient(180deg, rgba(255, 255, 255, 0.6) 0%, rgba(245, 237, 217, 0.4) 100%);
    }

    .chatbot-bubble {
      max-width: 85%;
      border-radius: 16px;
      padding: 12px 16px;
      font-size: 0.95rem;
      line-height: 1.5;
      word-break: break-word;
    }

    .chatbot-bubble-user {
      align-self: flex-end;
      background: var(--accent);
      color: var(--bg-white);
      border-bottom-right-radius: 4px;
    }

    .chatbot-bubble-bot {
      align-self: flex-start;
      background: var(--bg-white);
      color: var(--text-main);
      border: 1px solid rgba(116, 70, 34, 0.15);
      border-bottom-left-radius: 4px;
    }

    .chatbot-form {
      display: grid;
      grid-template-columns: 1fr auto;
      gap: 12px;
      padding: 16px 20px 0;
      background: var(--bg-white);
    }

    .chatbot-input {
      border-radius: var(--radius-soft);
      border: 1px solid rgba(116, 70, 34, 0.2);
      background: var(--bg-white);
      padding: 12px 16px;
      font-size: 1rem;
      font-family: var(--font-body);
      color: var(--text-main);
      outline: none;
      transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .chatbot-input:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 3px var(--accent-10);
    }

    .chatbot-send {
      border: none;
      border-radius: var(--radius-soft);
      background: var(--accent);
      color: var(--bg-white);
      font-size: 1rem;
      font-weight: var(--fw-bold);
      padding: 0 24px;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .chatbot-send:hover {
      background: var(--accent-dark);
      transform: translateY(-1px);
    }

    .chatbot-send:disabled,
    .chatbot-input:disabled {
      opacity: 0.65;
      cursor: not-allowed;
      transform: none;
    }

    .chatbot-hint {
      font-size: 0.85rem;
      color: var(--text-muted);
      padding: 10px 20px 16px;
      background: var(--bg-white);
      margin: 0;
    }

    .chatbot-typing {
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }

    .chatbot-typing-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: var(--accent);
      opacity: 0.25;
      animation: chatbot-typing 1.2s ease-in-out infinite;
    }

    .chatbot-typing-dot:nth-child(2) {
      animation-delay: 0.15s;
    }

    .chatbot-typing-dot:nth-child(3) {
      animation-delay: 0.3s;
    }

    @keyframes chatbot-typing {

      0%,
      80%,
      100% {
        transform: translateY(0);
        opacity: 0.25;
      }

      40% {
        transform: translateY(-3px);
        opacity: 1;
      }
    }

    .chatbot-sr-only {
      position: absolute;
      width: 1px;
      height: 1px;
      padding: 0;
      margin: -1px;
      overflow: hidden;
      clip: rect(0, 0, 0, 0);
      border: 0;
      white-space: nowrap;
    }

    /* â”€â”€â”€ CTA FORM â”€â”€â”€ */
    .cta-form {
      background: var(--bg-light);
      padding: 80px 40px;
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 568px;
      justify-content: center;
    }

    .cta-form-title {
      font-family: var(--font-display);
      font-size: var(--fs-heading-md);
      font-weight: var(--fw-semibold);
      color: var(--text-main);
      line-height: var(--lh-tight);
      letter-spacing: -0.01em;
      text-align: center;
      margin-bottom: 40px;
    }

    .cta-form form {
      width: min(100%, 380px);
    }

    .form-input {
      width: 100%;
      height: 64px;
      border: 1px solid rgba(116, 70, 34, 0.42);
      border-radius: var(--radius-soft);
      background: var(--bg-white);
      padding: 0 24px;
      font-size: var(--fs-body-lg);
      font-weight: var(--fw-medium);
      font-family: var(--font-body);
      color: var(--text-main);
      margin-bottom: 16px;
      outline: none;
      display: block;
    }

    .form-input::placeholder {
      color: rgba(116, 70, 34, 0.56);
    }

    .form-input:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 4px var(--accent-10);
    }

    .btn-cta {
      width: 100%;
      height: 64px;
      background: var(--accent);
      color: var(--bg-white);
      font-size: var(--fs-body);
      font-weight: var(--fw-bold);
      letter-spacing: 0.01em;
      font-family: var(--font-body);
      border: none;
      border-radius: var(--radius-md);
      cursor: pointer;
      margin-top: 8px;
      box-shadow: 0 10px 22px rgba(66, 118, 106, 0.3);
    }

    .btn-cta:hover {
      background: var(--accent-dark);
      transform: translateY(-2px);
      box-shadow: 0 14px 28px rgba(47, 90, 79, 0.36);
    }

    .btn-cta:active {
      transform: translateY(0);
      box-shadow: none;
    }

    /* â”€â”€â”€ FOOTER â”€â”€â”€ */
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
      gap: 48px;
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

    .footer-nav-link:active {
      transform: translateY(1px);
    }

    .footer-divider {
      border: none;
      border-top: 1px solid rgba(255, 255, 255, 0.24);
      margin: 0 80px;
    }

    .footer-social {
      display: flex;
      justify-content: center;
      gap: 28px;
      padding: 40px 0;
    }

    .social-icon-placeholder {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: #fff;
    }

    .footer-legal {
      display: flex;
      justify-content: center;
      gap: 48px;
      padding-bottom: 32px;
    }

    .footer-legal-text {
      font-size: var(--fs-caption);
      font-weight: var(--fw-medium);
      color: #fff;
    }

    /* â”€â”€â”€ UTILITY COLORS â”€â”€â”€ */
    .text-green {
      color: var(--accent);
    }

    /* â”€â”€â”€ SOCIAL LINKS â”€â”€â”€ */
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

    /* footer decorative shapes */
    .footer-shapes {
      position: absolute;
      inset: 0;
      pointer-events: none;
      overflow: hidden;
    }

    .footer-shape {
      position: absolute;
    }

    /* â”€â”€â”€ HAMBURGER â”€â”€â”€ */
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

    .nav-mobile a:hover,
    .nav-mobile a:focus-visible {
      color: var(--text-main);
      text-decoration: underline;
      text-underline-offset: 4px;
    }

    .nav-mobile a:active {
      transform: translateY(1px);
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

    /* â”€â”€â”€ RESPONSIVE â”€â”€â”€ */
    @media (max-width: 1024px) {
      .cards-grid {
        grid-template-columns: repeat(2, 1fr);
      }

      .hero {
        min-height: 730px;
      }

      .hero-circle-left {
        width: 680px;
        height: 680px;
        left: -340px;
        bottom: -340px;
      }

      .dark-feature {
        flex-direction: column;
        padding: 60px;
        gap: 48px;
      }

      .dark-feature-content {
        max-width: 100%;
        flex: unset;
      }

      .carousel-card.active {
        width: 240px;
        height: 320px;
      }

      .carousel-card.prev,
      .carousel-card.next {
        width: 180px;
        height: 250px;
        transform: translateX(-140px) scale(0.85);
      }

      .carousel-card.next {
        transform: translateX(140px) scale(0.85);
      }

      .carousel-card.far-prev,
      .carousel-card.far-next {
        opacity: 0;
        pointer-events: none;
      }

      .chatbot-shell {
        grid-template-columns: 1fr;
      }

      .chatbot-cta-card {
        padding: 40px 32px;
      }
    }

    @media (max-width: 768px) {
      .nav {
        padding: 0 20px;
      }

      .nav-links {
        display: none;
      }

      .btn-signup {
        display: none;
      }

      .nav-toggle {
        display: flex;
      }

      .hero {
        padding: 56px 24px 0;
        min-height: 0;
      }

      .hero-headline {
        font-size: 2.1rem;
      }

      .hero-subheadline {
        font-size: 1rem;
        margin-top: 16px;
      }

      .btn-primary {
        height: 52px;
        font-size: 0.95rem;
        margin-top: 20px;
        border-radius: var(--radius-soft);
      }

      .hero-mockup {
        margin-top: 32px;
      }

      .mockup-body {
        height: 180px;
      }

      .hero-bg-shapes {
        display: none;
      }

      .testimonial {
        padding: 48px 24px;
        min-height: 0;
      }

      .testimonial-quote {
        font-size: 1.1rem;
      }

      .dark-feature {
        flex-direction: column;
        padding: 48px 24px;
        gap: 40px;
      }

      .dark-feature-content {
        max-width: 100%;
        flex: unset;
      }

      .dark-feature-title {
        font-size: 1.8rem;
      }

      .dark-feature-description {
        font-size: 1rem;
      }

      .dark-feature-media {
        min-height: 320px;
        width: 100%;
        justify-content: center;
        align-items: center;
      }

      .carousel-track {
        height: 320px;
        width: 100%;
        justify-content: center;
      }

      .carousel-card.active {
        width: 200px;
        height: 280px;
      }

      .carousel-card.prev,
      .carousel-card.next {
        width: 140px;
        height: 200px;
        transform: translateX(-110px) scale(0.82);
      }

      .carousel-card.next {
        transform: translateX(110px) scale(0.82);
      }

      .carousel-card.far-prev,
      .carousel-card.far-next {
        opacity: 0;
        pointer-events: none;
      }

      .feature-cards {
        padding: 48px 0;
      }

      .feature-cards .section-header,
      .menu-section .section-header {
        padding: 0 24px;
        margin-bottom: 24px;
      }

      .section-title {
        font-size: 1.9rem;
      }

      .section-tagline {
        font-size: 0.95rem;
      }

      .cards-grid {
        display: flex;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        padding: 12px 24px 32px;
        /* Bottom padding for scroll and shadow */
        gap: 16px;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
      }

      .cards-grid::-webkit-scrollbar {
        display: none;
      }

      .card,
      .menu-card {
        flex: 0 0 82%;
        scroll-snap-align: center;
      }

      .chatbot-section {
        padding: 64px 5%;
      }

      .chatbot-cta-card {
        padding: 32px 24px;
      }

      .chatbot-cta-title {
        font-size: 1.5rem;
      }

      .cta-form {
        padding: 48px 24px;
        min-height: 0;
      }

      .cta-form-title {
        font-size: 1.65rem;
        margin-bottom: 28px;
      }

      .form-input {
        width: 100%;
        max-width: 360px;
        font-size: 16px;
      }

      .btn-cta {
        width: 100%;
        max-width: 360px;
        font-size: 0.95rem;
        border-radius: var(--radius-soft);
      }

      .footer {
        padding: 48px 0 32px;
      }

      .footer-nav {
        flex-direction: column;
        gap: 24px;
        padding: 0 24px 32px;
      }

      .footer-nav-group {
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
      }

      .footer-divider {
        margin: 0 24px;
      }

      .footer-social {
        gap: 20px;
        padding: 28px 0;
      }

      .social-link {
        width: 36px;
        height: 36px;
      }

      .footer-legal {
        gap: 24px;
        flex-wrap: wrap;
        justify-content: center;
        padding: 0 24px 32px;
      }

      .footer-shapes {
        display: none;
      }
    }

    @media (max-width: 480px) {
      .hero-headline {
        font-size: 1.75rem;
      }
    }
  </style>
</head>

<body>

  <!-- NAV -->
  <header>
    <nav class="nav" aria-label="Navigasi utama">
      <a href="{{ route('home') }}" class="nav-logo"><img
          src="https://api.builder.io/api/v1/image/assets/TEMP/10a82c5c6d87de97d3583b6c8564df77f595f954?width=1114"
          alt="Logo" class="nav-logo-img" />Kantin Kita</a>
      <ul class="nav-links" role="list">
        <li><a href="{{ route('home') }}">Beranda</a></li>
        <li><a href="{{ route('home') }}#menu-title">Menu</a></li>
        <li><a href="{{ route('about') }}">Tentang</a></li>
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

    <!-- HERO -->
    <section class="hero" aria-labelledby="hero-title">
      <div class="hero-bg-shapes" aria-hidden="true">
        <img src="{{ asset('images/maskot.png') }}" class="hero-circle-right" alt="" />
        <img src="{{ asset('images/image-background.png') }}" class="hero-circle-left" alt="" />
      </div>
      <h1 class="hero-headline" id="hero-title"><span class="headline-brown">Pesan Makanan</span> <span
          class="headline-green">Tanpa Antri</span></h1>
      <p class="hero-subheadline">Nikmati hidangan lezat dari kantin kampus favorit kamu. Pesan sekarang, ambil nanti.
        Hemat waktu, lebih praktis!</p>
      <a href="{{ route('vendor') }}" class="btn-primary">Mulai Pesan</a>
      <div class="hero-mockup" role="img" aria-label="Pratinjau aplikasi Kantin Kita">
        <div class="mockup-bar" aria-hidden="true">
          <div class="mockup-dot"></div>
          <div class="mockup-dot"></div>
          <div class="mockup-dot"></div>
        </div>
        <div class="mockup-body"><img
            src="https://images.unsplash.com/photo-1512058564366-18510be2db19?w=800&q=80&auto=format&fit=crop"
            alt="Makanan lezat kantin kampus" class="mockup-img" /></div>
      </div>
    </section>

    <!-- TESTIMONIAL -->
    <section class="testimonial" aria-label="Testimoni pengguna">
      <figure>
        <blockquote class="testimonial-quote">
          "Aplikasi yang sangat membantu! Tidak perlu lagi antri panjang saat jam makan siang. Pesanan selalu siap tepat
          waktu."
        </blockquote>
        <figcaption>
          <img src="https://i.pravatar.cc/100?img=59" alt="Alfian Rasyid" class="testimonial-avatar" />
          <p class="testimonial-author">Alfian Rasyid<br><span class="testimonial-role">Mahasiswa Teknik
              Informatika</span></p>
        </figcaption>
      </figure>
    </section>

    <!-- DARK FEATURE / SOCIAL PROOF -->
    <section class="dark-feature" aria-labelledby="dark-feature-title">
      <div class="dark-feature-content">
        <h2 class="dark-feature-title" id="dark-feature-title">Kenapa Kantin Kita?</h2>
        <p class="dark-feature-description">Solusi praktis untuk makan siang yang sibuk di kampus.</p>
        <p class="dark-feature-testimonial" id="darkFeatureTestimonial">"Menu-nya lengkap dan harganya ramah kantong
          mahasiswa. Sistem pembayaran digital juga sangat praktis!"</p>
        <div class="dark-feature-author" id="darkFeatureAuthor">
          <img src="https://i.pravatar.cc/100?img=12" alt="" class="dark-feature-author-avatar"
            id="darkFeatureAvatar" />
          <div>
            <div class="dark-feature-author-name" id="darkFeatureName">Budi Santoso</div>
            <div class="dark-feature-author-role" id="darkFeatureRole">Mahasiswa Ekonomi</div>
          </div>
        </div>
      </div>
      <div class="dark-feature-media" id="darkFeatureCarousel">
        <div class="carousel-track" id="carouselTrack">
          <div class="carousel-card" data-index="0">
            <img src="https://i.pravatar.cc/600?img=12" alt="Budi Santoso" />
          </div>
          <div class="carousel-card" data-index="1">
            <img src="https://images.unsplash.com/photo-1609570324378-ec0c4c9b6ba8?w=500&q=80&auto=format&fit=crop"
              alt="Nasi Goreng Spesial" />
          </div>
          <div class="carousel-card" data-index="2">
            <img src="https://i.pravatar.cc/600?img=32" alt="Siti Nurhaliza" />
          </div>
          <div class="carousel-card" data-index="3">
            <img src="https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?w=500&q=80&auto=format&fit=crop"
              alt="Ayam Geprek" />
          </div>
          <div class="carousel-card" data-index="4">
            <img src="https://i.pravatar.cc/600?img=59" alt="Alfian Rasyid" />
          </div>
        </div>
        <div class="carousel-dots" id="carouselDots"></div>
      </div>
    </section>

    <!-- FEATURE CARDS -->
    <section class="feature-cards" aria-labelledby="cards-title">
      <header class="section-header">
        <h2 class="section-title" id="cards-title">Fitur Unggulan <span class="text-green">Kantin Kita</span></h2>
        <p class="section-tagline">Solusi praktis untuk makan siang yang sibuk di kampus</p>
      </header>
      <ul class="cards-grid" role="list">
        <li class="card">
          <div class="feature-icon" aria-hidden="true">
            <svg width="30" height="30" viewBox="0 0 23 30" fill="none">
              <path
                d="M0.9375 3.75C0.9375 1.68164 2.61914 0 4.6875 0H17.8125C19.8809 0 21.5625 1.68164 21.5625 3.75V26.25C21.5625 28.3184 19.8809 30 17.8125 30H4.6875C2.61914 30 0.9375 28.3184 0.9375 26.25V3.75ZM13.125 26.25C13.125 25.7527 12.9275 25.2758 12.5758 24.9242C12.2242 24.5725 11.7473 24.375 11.25 24.375C10.7527 24.375 10.2758 24.5725 9.92418 24.9242C9.57254 25.2758 9.375 25.7527 9.375 26.25C9.375 26.7473 9.57254 27.2242 9.92418 27.5758C10.2758 27.9275 10.7527 28.125 11.25 28.125C11.7473 28.125 12.2242 27.9275 12.5758 27.5758C12.9275 27.2242 13.125 26.7473 13.125 26.25ZM17.8125 3.75H4.6875V22.5H17.8125V3.75Z"
                fill="#42766A" />
            </svg>
          </div>
          <h3 class="card-title">Pesan Online</h3>
          <p class="card-desc">Pesan dari mana saja, kapan saja melalui aplikasi</p>
        </li>
        <li class="card">
          <div class="feature-icon" aria-hidden="true">
            <svg width="26" height="30" viewBox="0 0 27 30" fill="none">
              <path
                d="M20.4726 2.61332C20.8183 1.81059 20.5605 0.873089 19.8515 0.357464C19.1426-0.158161 18.1758-0.111286 17.5137 0.462932L2.51366 13.5879C1.92772 14.1036 1.71678 14.9297 1.99217 15.6563C2.26757 16.3829 2.97069 16.875 3.74999 16.875H10.2832L5.77733 27.3868C5.43163 28.1895 5.68944 29.127 6.39842 29.6426C7.10741 30.1582 8.07421 30.1114 8.73632 29.5372L23.7363 16.4122C24.3223 15.8965 24.5332 15.0704 24.2578 14.3438C23.9824 13.6172 23.2851 13.1309 22.5 13.1309H15.9668L20.4726 2.61332Z"
                fill="#42766A" />
            </svg>
          </div>
          <h3 class="card-title">Cepat &amp; Mudah</h3>
          <p class="card-desc">Proses pemesanan hanya dalam hitungan detik</p>
        </li>
        <li class="card">
          <div class="feature-icon" aria-hidden="true">
            <svg width="30" height="30" viewBox="0 0 30 30" fill="none">
              <path
                d="M3.75 1.875C1.68164 1.875 0 3.55664 0 5.625V24.375C0 26.4434 1.68164 28.125 3.75 28.125H26.25C28.3184 28.125 30 26.4434 30 24.375V11.25C30 9.18164 28.3184 7.5 26.25 7.5H4.6875C4.17188 7.5 3.75 7.07812 3.75 6.5625C3.75 6.04688 4.17188 5.625 4.6875 5.625H26.25C27.2871 5.625 28.125 4.78711 28.125 3.75C28.125 2.71289 27.2871 1.875 26.25 1.875H3.75ZM24.375 15.9375C24.8723 15.9375 25.3492 16.135 25.7008 16.4867C26.0525 16.8383 26.25 17.3152 26.25 17.8125C26.25 18.3098 26.0525 18.7867 25.7008 19.1383C25.3492 19.49 24.8723 19.6875 24.375 19.6875C23.8777 19.6875 23.4008 19.49 23.0492 19.1383C22.6975 18.7867 22.5 18.3098 22.5 17.8125C22.5 17.3152 22.6975 16.8383 23.0492 16.4867C23.4008 16.135 23.8777 15.9375 24.375 15.9375Z"
                fill="#42766A" />
            </svg>
          </div>
          <h3 class="card-title">Cashless</h3>
          <p class="card-desc">Pembayaran digital yang aman dan praktis</p>
        </li>
        <li class="card">
          <div class="feature-icon" aria-hidden="true">
            <svg width="30" height="30" viewBox="0 0 30 30" fill="none">
              <path
                d="M11.1621 4.03125L13.2012 7.5H8.90625C7.61133 7.5 6.5625 6.45117 6.5625 5.15625C6.5625 3.86133 7.61133 2.8125 8.90625 2.8125H9.03516C9.9082 2.8125 10.7227 3.27539 11.1621 4.03125ZM3.75 5.15625C3.75 6 3.95508 6.79688 4.3125 7.5H1.875C0.837891 7.5 0 8.33789 0 9.375V13.125C0 14.1621 0.837891 15 1.875 15H28.125C29.1621 15 30 14.1621 30 13.125V9.375C30 8.33789 29.1621 7.5 28.125 7.5H25.6875C26.0449 6.79688 26.25 6 26.25 5.15625C26.25 2.30859 23.9414 0 21.0938 0H20.9648C19.0957 0 17.3613 0.990234 16.4121 2.60156L15 5.00977L13.5879 2.60742C12.6387 0.990234 10.9043 0 9.03516 0H8.90625C6.05859 0 3.75 2.30859 3.75 5.15625ZM1.875 16.875V27.1875C1.875 28.7402 3.13477 30 4.6875 30H13.125V16.875H1.875ZM16.875 30H25.3125C26.8652 30 28.125 28.7402 28.125 27.1875V16.875H16.875V30Z"
                fill="#42766A" />
            </svg>
          </div>
          <h3 class="card-title">Promo Menarik</h3>
          <p class="card-desc">Dapatkan diskon dan reward setiap hari</p>
        </li>
      </ul>
    </section>

    <!-- POPULAR MENU -->
    <section class="menu-section" aria-labelledby="menu-title">
      <header class="section-header">
        <div class="menu-header-text">
          <h2 class="section-title" id="menu-title">Menu <span class="text-green">Populer</span></h2>
          <p class="section-tagline">Pilihan favorit mahasiswa setiap hari</p>
        </div>
      </header>

      <ul class="cards-grid" role="list">
        <!-- Nasi Goreng -->
        <li class="menu-card">
          <div class="menu-card-img">
            <img src="https://images.unsplash.com/photo-1609570324378-ec0c4c9b6ba8?q=80&w=2070&auto=format&fit=crop"
              alt="Nasi Goreng Special">
            <span class="menu-badge badge-bestseller">Terlaris</span>
          </div>
          <div class="menu-card-body">
            <div class="menu-card-header">
              <span class="menu-card-name">Nasi Goreng Special</span>
              <div class="menu-rating">
                <svg viewBox="0 0 16 14" fill="none">
                  <path
                    d="M8.66525 0.492188C8.52032 0.191406 8.21407 0 7.87775 0C7.54142 0 7.2379 0.191406 7.09025 0.492188L5.33204 4.10977L1.40548 4.68945C1.07736 4.73867 0.803918 4.96836 0.702746 5.28281C0.601574 5.59727 0.683605 5.94453 0.918761 6.17695L3.76798 8.99609L3.09532 12.9801C3.04064 13.3082 3.17736 13.6418 3.44806 13.8359C3.71876 14.0301 4.07696 14.0547 4.37228 13.8988L7.88048 12.0258L11.3887 13.8988C11.684 14.0547 12.0422 14.0328 12.3129 13.8359C12.5836 13.6391 12.7203 13.3082 12.6656 12.9801L11.9902 8.99609L14.8395 6.17695C15.0746 5.94453 15.1594 5.59727 15.0555 5.28281C14.9516 4.96836 14.6809 4.73867 14.3527 4.68945L10.4234 4.10977L8.66525 0.492188Z" />
                </svg>
                <span class="rating-value">4.9</span>
              </div>
            </div>
            <p class="menu-card-desc">Nasi goreng dengan ayam, telur mata sapi, dan sayuran segar</p>
            <div class="menu-card-footer">
              <a href="{{ route('vendor') }}" class="btn-detail">Lihat Detail &rarr;</a>
            </div>
          </div>
        </li>

        <!-- Mie Goreng -->
        <li class="menu-card">
          <div class="menu-card-img">
            <img src="https://images.unsplash.com/photo-1680675494363-75bbf9838a09?q=80&w=2070&auto=format&fit=crop"
              alt="Mie Goreng Jawa">
          </div>
          <div class="menu-card-body">
            <div class="menu-card-header">
              <span class="menu-card-name">Mie Goreng Jawa</span>
              <div class="menu-rating">
                <svg viewBox="0 0 16 14" fill="none">
                  <path
                    d="M8.66525 0.492188C8.52032 0.191406 8.21407 0 7.87775 0C7.54142 0 7.2379 0.191406 7.09025 0.492188L5.33204 4.10977L1.40548 4.68945C1.07736 4.73867 0.803918 4.96836 0.702746 5.28281C0.601574 5.59727 0.683605 5.94453 0.918761 6.17695L3.76798 8.99609L3.09532 12.9801C3.04064 13.3082 3.17736 13.6418 3.44806 13.8359C3.71876 14.0301 4.07696 14.0547 4.37228 13.8988L7.88048 12.0258L11.3887 13.8988C11.684 14.0547 12.0422 14.0328 12.3129 13.8359C12.5836 13.6391 12.7203 13.3082 12.6656 12.9801L11.9902 8.99609L14.8395 6.17695C15.0746 5.94453 15.1594 5.59727 15.0555 5.28281C14.9516 4.96836 14.6809 4.73867 14.3527 4.68945L10.4234 4.10977L8.66525 0.492188Z" />
                </svg>
                <span class="rating-value">4.8</span>
              </div>
            </div>
            <p class="menu-card-desc">Mie goreng dengan bumbu khas Jawa yang gurih dan pedas</p>
            <div class="menu-card-footer">
              <a href="{{ route('vendor') }}" class="btn-detail">Lihat Detail &rarr;</a>
            </div>
          </div>
        </li>

        <!-- Ayam Geprek -->
        <li class="menu-card">
          <div class="menu-card-img">
            <img src="https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?w=600&q=80&auto=format&fit=crop"
              alt="Ayam Geprek">
            <span class="menu-badge badge-promo">Promo</span>
          </div>
          <div class="menu-card-body">
            <div class="menu-card-header">
              <span class="menu-card-name">Ayam Geprek</span>
              <div class="menu-rating">
                <svg viewBox="0 0 16 14" fill="none">
                  <path
                    d="M8.66525 0.492188C8.52032 0.191406 8.21407 0 7.87775 0C7.54142 0 7.2379 0.191406 7.09025 0.492188L5.33204 4.10977L1.40548 4.68945C1.07736 4.73867 0.803918 4.96836 0.702746 5.28281C0.601574 5.59727 0.683605 5.94453 0.918761 6.17695L3.76798 8.99609L3.09532 12.9801C3.04064 13.3082 3.17736 13.6418 3.44806 13.8359C3.71876 14.0301 4.07696 14.0547 4.37228 13.8988L7.88048 12.0258L11.3887 13.8988C11.684 14.0547 12.0422 14.0328 12.3129 13.8359C12.5836 13.6391 12.7203 13.3082 12.6656 12.9801L11.9902 8.99609L14.8395 6.17695C15.0746 5.94453 15.1594 5.59727 15.0555 5.28281C14.9516 4.96836 14.6809 4.73867 14.3527 4.68945L10.4234 4.10977L8.66525 0.492188Z" />
                </svg>
                <span class="rating-value">4.7</span>
              </div>
            </div>
            <p class="menu-card-desc">Ayam crispy dengan sambal level pilihan dan nasi hangat</p>
            <div class="menu-card-footer">
              <a href="{{ route('vendor') }}" class="btn-detail">Lihat Detail &rarr;</a>
            </div>
          </div>
        </li>

        <!-- Soto Ayam Lamongan -->
        <li class="menu-card">
          <div class="menu-card-img">
            <img src="https://images.unsplash.com/photo-1652088079703-38f4a8d6b981?q=80&w=995&auto=format&fit=crop"
              alt="Soto Ayam Lamongan">
          </div>
          <div class="menu-card-body">
            <div class="menu-card-header">
              <span class="menu-card-name">Soto Ayam</span>
              <div class="menu-rating">
                <svg viewBox="0 0 16 14" fill="none">
                  <path
                    d="M8.66525 0.492188C8.52032 0.191406 8.21407 0 7.87775 0C7.54142 0 7.2379 0.191406 7.09025 0.492188L5.33204 4.10977L1.40548 4.68945C1.07736 4.73867 0.803918 4.96836 0.702746 5.28281C0.601574 5.59727 0.683605 5.94453 0.918761 6.17695L3.76798 8.99609L3.09532 12.9801C3.04064 13.3082 3.17736 13.6418 3.44806 13.8359C3.71876 14.0301 4.07696 14.0547 4.37228 13.8988L7.88048 12.0258L11.3887 13.8988C11.684 14.0547 12.0422 14.0328 12.3129 13.8359C12.5836 13.6391 12.7203 13.3082 12.6656 12.9801L11.9902 8.99609L14.8395 6.17695C15.0746 5.94453 15.1594 5.59727 15.0555 5.28281C14.9516 4.96836 14.6809 4.73867 14.3527 4.68945L10.4234 4.10977L8.66525 0.492188Z" />
                </svg>
                <span class="rating-value">4.9</span>
              </div>
            </div>
            <p class="menu-card-desc">Soto ayam khas Jawa Timur dengan kuah kuning yang segar</p>
            <div class="menu-card-footer">
              <a href="{{ route('vendor') }}" class="btn-detail">Lihat Detail &rarr;</a>
            </div>
          </div>
        </li>
      </ul>
    </section>

    <!-- CHATBOT SECTION -->
    <section class="chatbot-section" id="chatbot" aria-labelledby="chatbot-title">
      <div class="chatbot-inner">
        <header class="section-header">
          <h2 class="section-title" id="chatbot-title">Lanjut Chat Dengan Chatbot Moka</h2>
          <p class="section-tagline">Butuh rekomendasi menu atau bantuan pemesanan? Chat langsung dengan asisten Kantin
            Kita di sini.</p>
        </header>

        <div class="chatbot-shell">
          <aside class="chatbot-cta-card">
            <p class="chatbot-cta-eyebrow">Asisten Virtual Kantin Kita</p>
            <h3 class="chatbot-cta-title">Tanya apa saja, jawabannya datang dalam hitungan detik.</h3>
            <p class="chatbot-cta-copy">Mulai dari saran menu, jam operasional, hingga cara checkout. Pilih pertanyaan
              cepat di bawah atau ketik pertanyaanmu sendiri.</p>

            <div class="chatbot-chip-list">
              <button type="button" class="chatbot-chip" data-prompt="Menu terlaris hari ini apa saja?">Menu terlaris
                hari ini</button>
              <button type="button" class="chatbot-chip"
                data-prompt="Jam operasional kantin dimulai dari jam berapa?">Jam operasional kantin</button>
              <button type="button" class="chatbot-chip" data-prompt="Bagaimana cara pesan makanan tanpa antre?">Cara
                pesan tanpa antre</button>
              <button type="button" class="chatbot-chip"
                data-prompt="Ada rekomendasi menu di bawah 20 ribu?">Rekomendasi menu hemat</button>
            </div>
          </aside>

          <article class="chatbot-panel">
            <div class="chatbot-panel-head">
              <h3 class="chatbot-panel-title">Moka Chatbot Kantin Kita</h3>
              <span class="chatbot-status">
                <span class="chatbot-status-dot"></span>
                Online
              </span>
            </div>

            <div class="chatbot-messages" id="chatbotMessages" role="log" aria-live="polite"
              aria-label="Percakapan chatbot"></div>

            <form class="chatbot-form" id="chatbotForm">
              <label for="chatbotInput" class="chatbot-sr-only">Tulis pertanyaan untuk chatbot</label>
              <input id="chatbotInput" class="chatbot-input" type="text" maxlength="400" autocomplete="off"
                placeholder="Contoh: Menu pedas favorit apa?" required>
              <button type="submit" class="chatbot-send" id="chatbotSendButton">Kirim</button>
            </form>

            <p class="chatbot-hint">Tekan Enter untuk mengirim pesan.</p>
          </article>
        </div>
      </div>
    </section>

    <!-- CTA FORM -->
    <section class="cta-form" id="signup" aria-labelledby="cta-title">
      <p class="cta-form-title" id="cta-title">Daftar sekarang dan dapatkan <span class="text-green">voucher diskon
          20%</span> untuk pesanan pertama kamu!</p>
      <form action="{{ route('login') }}" method="get" id="ctaForm" novalidate>
        <label for="cta-email" class="visually-hidden">Alamat email</label>
        <input class="form-input" id="cta-email" type="email" placeholder="email kampus" autocomplete="email" />
        <label for="cta-password" class="visually-hidden">Kata sandi</label>
        <input class="form-input" id="cta-password" type="password" placeholder="kata sandi"
          autocomplete="new-password" />
        <button class="btn-cta" type="submit">Daftar Sekarang</button>
      </form>
    </section>

  </main>

  <!-- FOOTER -->
  <footer class="footer" aria-label="Footer situs">
    <div class="footer-shapes" aria-hidden="true">
      <div class="footer-shape" style="top:60px;right:60px;width:42px;height:42px;border-radius:50%;background:#fff;">
      </div>
      <svg class="footer-shape" style="bottom:0;right:160px;" width="180" height="180" viewBox="0 0 180 180" fill="none"
        xmlns="http://www.w3.org/2000/svg">
        <path d="M180 0L0 180L180 180Z" stroke="white" stroke-width="1.57" fill="none" />
      </svg>
      <div class="footer-shape"
        style="bottom:0;right:0;width:175px;height:175px;background:#fff;transform:translate(30%,30%);"></div>
      <svg class="footer-shape" style="bottom:0;left:0;" width="170" height="170" viewBox="0 0 170 170" fill="none"
        xmlns="http://www.w3.org/2000/svg">
        <path d="M0 170L170 0L170 170Z" fill="white" stroke="#744622" stroke-width="1.57" />
      </svg>
      <svg class="footer-shape" style="bottom:0;left:100px;" width="170" height="170" viewBox="0 0 170 170" fill="none"
        xmlns="http://www.w3.org/2000/svg">
        <path d="M170 170L0 0L0 170Z" stroke="white" stroke-width="1.57" fill="none" />
      </svg>
      <div class="footer-shape"
        style="bottom:0;left:0;width:186px;height:186px;border-radius:50%;border:1.57px solid #fff;transform:translate(-30%,20%);">
      </div>
      <svg class="footer-shape" style="bottom:0;right:80px;" width="180" height="180" viewBox="0 0 180 180" fill="none"
        xmlns="http://www.w3.org/2000/svg">
        <path d="M0 180L180 0L180 180Z" fill="white" stroke="#744622" stroke-width="1.57" />
      </svg>
    </div>
    <div class="footer-inner">
      <nav class="footer-nav" aria-label="Navigasi footer">
        <div class="footer-nav-group">
          <a href="{{ route('home') }}" class="footer-nav-link">Beranda</a>
          <a href="{{ route('home') }}#menu-title" class="footer-nav-link">Menu</a>
          <a href="home.html#signup" class="footer-nav-link">Promo</a>
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
        <span class="footer-legal-text">&copy; 2024 Kantin Kita</span>
        <span class="footer-legal-text">Privasi &mdash; Syarat</span>
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
    toggle.addEventListener('click', () => {
      const isOpen = mobileNav.classList.toggle('open');
      toggle.setAttribute('aria-expanded', String(isOpen));
    });

    // â”€â”€ Dark Feature Carousel â”€â”€
    (() => {
      const testimonials = [
        {
          quote: '"Menu-nya lengkap dan harganya ramah kantong mahasiswa. Sistem pembayaran digital juga sangat praktis!"',
          avatar: 'https://i.pravatar.cc/100?img=12',
          name: 'Budi Santoso',
          role: 'Mahasiswa Ekonomi'
        },
        {
          quote: '"Nasi goreng spesial Kantin Kita selalu jadi favorit saya. Porsinya banyak dan rasanya konsisten enak!"',
          avatar: '',
          name: 'Menu Favorit',
          role: 'Nasi Goreng Spesial'
        },
        {
          quote: '"Sangat membantu mahasiswa yang jadwalnya padat. Tinggal pesan lewat HP, makanan sudah siap!"',
          avatar: 'https://i.pravatar.cc/100?img=32',
          name: 'Siti Nurhaliza',
          role: 'Mahasiswa Kedokteran'
        },
        {
          quote: '"Ayam gepreknya level pedasnya pas banget! Harga mahasiswa tapi rasa restoran. Wajib coba!"',
          avatar: '',
          name: 'Menu Populer',
          role: 'Ayam Geprek'
        },
        {
          quote: '"Fitur pre-order sangat berguna, terutama saat jam makan siang yang ramai. Tidak perlu antri lagi!"',
          avatar: 'https://i.pravatar.cc/100?img=59',
          name: 'Alfian Rasyid',
          role: 'Mahasiswa Teknik Informatika'
        }
      ];

      const cards = document.querySelectorAll('.carousel-card');
      const dotsContainer = document.getElementById('carouselDots');
      const testimonialEl = document.getElementById('darkFeatureTestimonial');
      const avatarEl = document.getElementById('darkFeatureAvatar');
      const nameEl = document.getElementById('darkFeatureName');
      const roleEl = document.getElementById('darkFeatureRole');
      const authorEl = document.getElementById('darkFeatureAuthor');
      const carouselEl = document.getElementById('darkFeatureCarousel');

      if (!cards.length || !dotsContainer) return;

      let activeIndex = 0;
      const totalCards = cards.length;

      // Create dots
      for (let i = 0; i < totalCards; i++) {
        const dot = document.createElement('button');
        dot.className = 'carousel-dot' + (i === 0 ? ' active' : '');
        dot.setAttribute('aria-label', `Slide ${i + 1}`);
        dot.addEventListener('click', () => goToSlide(i));
        dotsContainer.appendChild(dot);
      }

      const dots = dotsContainer.querySelectorAll('.carousel-dot');

      function getPosition(index) {
        const diff = index - activeIndex;
        // Handle wrapping
        const wrappedDiff = ((diff + Math.floor(totalCards / 2)) % totalCards + totalCards) % totalCards - Math.floor(totalCards / 2);
        if (wrappedDiff === 0) return 'active';
        if (wrappedDiff === -1) return 'prev';
        if (wrappedDiff === 1) return 'next';
        if (wrappedDiff === -2) return 'far-prev';
        if (wrappedDiff === 2) return 'far-next';
        return 'hidden';
      }

      function updateCarousel() {
        cards.forEach((card, i) => {
          card.classList.remove('active', 'prev', 'next', 'far-prev', 'far-next', 'hidden');
          card.classList.add(getPosition(i));
        });

        dots.forEach((dot, i) => {
          dot.classList.toggle('active', i === activeIndex);
        });

        // Fade out, update text, fade in
        testimonialEl.style.opacity = '0';
        authorEl.style.opacity = '0';
        setTimeout(() => {
          const t = testimonials[activeIndex];
          testimonialEl.textContent = t.quote;
          nameEl.textContent = t.name;
          roleEl.textContent = t.role;
          if (t.avatar) {
            avatarEl.src = t.avatar;
            avatarEl.style.display = '';
          } else {
            avatarEl.style.display = 'none';
          }
          testimonialEl.style.opacity = '1';
          authorEl.style.opacity = '1';
        }, 250);
      }

      function goToSlide(index) {
        activeIndex = ((index % totalCards) + totalCards) % totalCards;
        updateCarousel();
      }

      // Click on card to activate it
      cards.forEach(card => {
        card.addEventListener('click', () => {
          const idx = parseInt(card.dataset.index, 10);
          if (idx !== activeIndex) goToSlide(idx);
        });
      });

      // Swipe / drag support
      let startX = 0;
      let isDragging = false;

      carouselEl.addEventListener('pointerdown', (e) => {
        startX = e.clientX;
        isDragging = true;
        carouselEl.setPointerCapture(e.pointerId);
      });

      carouselEl.addEventListener('pointermove', (e) => {
        if (!isDragging) return;
        // Prevent scroll while swiping
        e.preventDefault();
      });

      carouselEl.addEventListener('pointerup', (e) => {
        if (!isDragging) return;
        isDragging = false;
        const delta = e.clientX - startX;
        if (Math.abs(delta) > 50) {
          if (delta < 0) {
            goToSlide(activeIndex + 1);
          } else {
            goToSlide(activeIndex - 1);
          }
        }
      });

      carouselEl.addEventListener('pointercancel', () => {
        isDragging = false;
      });

      // Auto-play every 5s
      let autoplayInterval = setInterval(() => goToSlide(activeIndex + 1), 5000);

      carouselEl.addEventListener('pointerenter', () => clearInterval(autoplayInterval));
      carouselEl.addEventListener('pointerleave', () => {
        autoplayInterval = setInterval(() => goToSlide(activeIndex + 1), 5000);
      });

      // Initial layout
      updateCarousel();
    })();

    // Chatbot interaction
    const chatbotForm = document.getElementById('chatbotForm');
    if (chatbotForm) {
      const CHATBOT_ENDPOINT = @json(route('chatbot.respond', [], false));
      const CHATBOT_ERROR_MESSAGE = 'Maaf, chatbot sedang tidak tersedia. Coba lagi sebentar ya.';
      const chatbotMessages = document.getElementById('chatbotMessages');
      const chatbotInput = document.getElementById('chatbotInput');
      const chatbotSendButton = document.getElementById('chatbotSendButton');
      let isChatbotSending = false;

      const appendMessage = (role, text) => {
        const bubble = document.createElement('div');
        bubble.className = `chatbot-bubble ${role === 'user' ? 'chatbot-bubble-user' : 'chatbot-bubble-bot'}`;
        bubble.textContent = text;
        chatbotMessages.appendChild(bubble);
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
      };

      const showTyping = () => {
        const typingBubble = document.createElement('div');
        typingBubble.id = 'chatbotTyping';
        typingBubble.className = 'chatbot-bubble chatbot-bubble-bot';
        typingBubble.innerHTML = '<span class="chatbot-typing"><span class="chatbot-typing-dot"></span><span class="chatbot-typing-dot"></span><span class="chatbot-typing-dot"></span></span>';
        chatbotMessages.appendChild(typingBubble);
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
      };

      const hideTyping = () => {
        const typingBubble = document.getElementById('chatbotTyping');
        if (typingBubble) {
          typingBubble.remove();
        }
      };

      const setSendingState = (sending) => {
        isChatbotSending = sending;
        chatbotInput.disabled = sending;
        chatbotSendButton.disabled = sending;
      };

      const requestChatbotReply = async (prompt) => {
        const cleanedPrompt = prompt.trim();
        if (!cleanedPrompt || isChatbotSending) {
          return;
        }

        appendMessage('user', cleanedPrompt);
        chatbotInput.value = '';
        setSendingState(true);
        showTyping();

        const controller = new AbortController();
        const timeoutId = window.setTimeout(() => controller.abort(), 30000);

        try {
          const response = await fetch(CHATBOT_ENDPOINT, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({ prompt: cleanedPrompt }),
            signal: controller.signal
          });

          const payload = await response.json().catch(() => ({}));
          if (!response.ok) {
            throw new Error(payload.message || 'Permintaan gagal diproses.');
          }

          const botReply = typeof payload.result === 'string' && payload.result.trim()
            ? payload.result.trim()
            : CHATBOT_ERROR_MESSAGE;

          hideTyping();
          appendMessage('bot', botReply);
        } catch (error) {
          hideTyping();
          if (error.name === 'AbortError') {
            appendMessage('bot', 'Respon chatbot terlalu lama. Coba kirim ulang pertanyaanmu.');
          } else {
            appendMessage('bot', CHATBOT_ERROR_MESSAGE);
          }
        } finally {
          window.clearTimeout(timeoutId);
          setSendingState(false);
          chatbotInput.focus();
        }
      };

      chatbotForm.addEventListener('submit', (event) => {
        event.preventDefault();
        requestChatbotReply(chatbotInput.value);
      });

      const chatbotChips = document.querySelectorAll('.chatbot-chip');
      chatbotChips.forEach(chip => {
        chip.addEventListener('click', () => {
          const prompt = chip.getAttribute('data-prompt');
          if (prompt && !isChatbotSending) {
            chatbotInput.value = prompt;
            requestChatbotReply(prompt);
          }
        });
      });

      appendMessage('bot', 'Halo, aku Moka asisten Kantin Kita. Kamu bisa tanya menu, jam operasional, atau cara pesan tanpa antre.');
    }
  </script>
</body>

</html>
