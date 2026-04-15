<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Select Your Vendor — Kantin Kita</title>
    <link rel="icon" type="image/png" href="https://api.builder.io/api/v1/image/assets/TEMP/10a82c5c6d87de97d3583b6c8564df77f595f954?width=1114" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        /* ─── Design Tokens ─────────────────────────────────── */
        :root {
            --cream: #FBF5E8;
            --brown: #744622;
            --brown-mid: #A67C52;
            --sage: #42766A;
            --sage-tint: rgba(66, 118, 106, 0.10);
            --white: #FFFFFF;
            --shadow-card: 0 2px 4px rgba(0, 0, 0, 0.10), 0 4px 6px rgba(0, 0, 0, 0.10);
            --shadow-lift: 0 8px 24px rgba(0, 0, 0, 0.14), 0 16px 32px rgba(0, 0, 0, 0.10);
            --radius-card: 24px;
            --radius-btn: 16px;
            --radius-pill: 9999px;
        }

        /* ─── Reset & Base ──────────────────────────────────── */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', -apple-system, sans-serif;
            background: var(--cream);
            color: var(--brown);
            min-height: 100vh;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button {
            cursor: pointer;
            border: none;
            background: none;
            font-family: inherit;
        }

        img {
            display: block;
        }

        /* ─── Scroll-reveal utility ─────────────────────────── */
        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.55s ease, transform 0.55s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .reveal-delay-1 {
            transition-delay: 0.10s;
        }

        .reveal-delay-2 {
            transition-delay: 0.20s;
        }

        .reveal-delay-3 {
            transition-delay: 0.30s;
        }

        /* ─── Header ────────────────────────────────────────── */
        .site-header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(116, 70, 34, 0.12);
            box-shadow: 0 8px 20px rgba(116, 70, 34, 0.08);
            height: 80px;
        }

        .header-inner {
            max-width: 1440px;
            margin: 0 auto;
            padding: 0 48px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Logo */
        .logo-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            width: 48px;
            height: 48px;
            background: var(--brown);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .logo-text-group {
            display: flex;
            flex-direction: column;
        }

        .logo-name {
            font-size: 24px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -0.5px;
            line-height: 32px;
        }

        .logo-tagline {
            font-size: 12px;
            font-weight: 400;
            color: var(--brown-mid);
            letter-spacing: -0.5px;
            line-height: 16px;
        }

        /* Nav */
        .main-nav {
            display: flex;
            align-items: center;
            gap: 32px;
        }

        .mobile-quick-links {
            display: none;
        }

        .nav-link {
            font-size: 16px;
            font-weight: 500;
            color: var(--brown);
            letter-spacing: -0.5px;
            line-height: 24px;
            position: relative;
            transition: color 0.2s;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--sage);
            border-radius: 2px;
            transition: width 0.25s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-link:hover {
            color: var(--sage);
        }

        /* Header actions */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .notif-btn {
            position: relative;
            width: 18px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s;
        }

        .notif-btn:hover {
            transform: scale(1.1);
        }

        .notif-badge {
            position: absolute;
            top: -4px;
            right: -6px;
            width: 20px;
            height: 20px;
            background: var(--sage);
            border-radius: var(--radius-pill);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 400;
            color: var(--white);
            letter-spacing: -0.5px;
        }

        .avatar-wrap {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-pill);
            border: 2px solid var(--sage);
            overflow: hidden;
            padding: 2px;
            transition: box-shadow 0.25s;
        }

        .avatar-wrap:hover {
            box-shadow: 0 0 0 3px rgba(66, 118, 106, 0.25);
        }

        .avatar-img {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-pill);
            object-fit: cover;
        }

        /* ─── Page Wrapper ──────────────────────────────────── */
        .page-body {
            max-width: 1440px;
            margin: 0 auto;
            padding: 64px 48px 80px;
            display: flex;
            flex-direction: column;
            gap: 40px;
        }

        /* ─── Page Header ───────────────────────────────────── */
        .page-header-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .back-btn {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-btn);
            background: var(--white);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: box-shadow 0.2s, transform 0.2s;
        }

        .back-btn:hover {
            box-shadow: var(--shadow-card);
            transform: translateX(-2px);
        }

        .page-title {
            font-size: 36px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -0.5px;
            line-height: 40px;
        }

        .page-subtitle {
            font-size: 14px;
            font-weight: 400;
            color: var(--brown-mid);
            letter-spacing: -0.5px;
            line-height: 20px;
        }

        /* ─── Search & Filter ───────────────────────────────── */
        .search-row {
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .search-field-wrap {
            position: relative;
            flex: 1;
        }

        .search-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .search-input {
            width: 100%;
            height: 60px;
            padding: 16px 24px 16px 56px;
            border-radius: var(--radius-btn);
            border: 2px solid transparent;
            background: var(--white);
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            font-weight: 400;
            color: var(--brown);
            letter-spacing: -0.5px;
            outline: none;
            transition: border-color 0.25s, box-shadow 0.25s;
        }

        .search-input::placeholder {
            color: var(--brown-mid);
        }

        .search-input:focus {
            border-color: var(--sage);
            box-shadow: 0 0 0 4px rgba(66, 118, 106, 0.12);
        }

        .filter-btn {
            height: 60px;
            padding: 0 28px;
            border-radius: var(--radius-btn);
            background: var(--white);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
            font-weight: 500;
            color: var(--brown);
            letter-spacing: -0.5px;
            white-space: nowrap;
            transition: background 0.2s, box-shadow 0.2s;
        }

        .filter-btn:hover {
            background: var(--cream);
            box-shadow: var(--shadow-card);
        }

        /* ─── Category Pills ────────────────────────────────── */
        .category-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .pill {
            height: 40px;
            padding: 0 24px;
            border-radius: var(--radius-pill);
            font-size: 14px;
            font-weight: 500;
            letter-spacing: -0.5px;
            line-height: 40px;
            cursor: pointer;
            border: none;
            transition: background 0.2s, color 0.2s, transform 0.15s, box-shadow 0.2s;
        }

        .pill-inactive {
            background: var(--white);
            color: var(--brown);
        }

        .pill-inactive:hover {
            background: var(--cream);
            box-shadow: var(--shadow-card);
            transform: translateY(-1px);
        }

        .pill-active {
            background: var(--sage);
            color: var(--white);
            box-shadow: 0 4px 12px rgba(66, 118, 106, 0.30);
        }

        .pill-active:hover {
            transform: translateY(-1px);
        }

        /* ─── Vendor Grid ───────────────────────────────────── */
        .vendors-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        /* ─── Vendor Card ───────────────────────────────────── */
        .vendor-card {
            background: var(--white);
            border-radius: var(--radius-card);
            box-shadow: var(--shadow-card);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: box-shadow 0.30s ease, transform 0.30s ease;
        }

        .vendor-card:hover {
            box-shadow: var(--shadow-lift);
            transform: translateY(-6px);
        }

        /* Card image */
        .card-image-wrap {
            position: relative;
            height: 256px;
            overflow: hidden;
        }

        .card-food-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.45s ease;
        }

        .vendor-card:hover .card-food-img {
            transform: scale(1.06);
        }

        /* Badge group over image */
        .card-badges {
            position: absolute;
            top: 16px;
            left: 16px;
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .badge-label {
            height: 28px;
            padding: 0 16px;
            border-radius: var(--radius-pill);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: -0.5px;
            line-height: 28px;
            white-space: nowrap;
            backdrop-filter: blur(4px);
        }

        .badge-green {
            background: var(--sage);
            color: var(--white);
        }

        .badge-rating {
            background: rgba(255, 255, 255, 0.95);
            color: var(--brown);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .badge-rating svg {
            flex-shrink: 0;
        }

        /* Wishlist button */
        .wishlist-btn {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 40px;
            height: 40px;
            border-radius: var(--radius-pill);
            background: rgba(255, 255, 255, 0.95);
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
            transition: background 0.2s, transform 0.2s;
        }

        .wishlist-btn:hover {
            background: var(--white);
            transform: scale(1.12);
        }

        .wishlist-btn.active svg path:last-child {
            fill: #ef4444;
        }

        /* Card body */
        .card-body {
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            flex: 1;
        }

        .vendor-name {
            font-size: 24px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -0.5px;
            line-height: 32px;
        }

        .vendor-location {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            font-weight: 400;
            color: var(--brown-mid);
            letter-spacing: -0.5px;
            line-height: 20px;
        }

        .vendor-tags {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .vendor-tag {
            height: 24px;
            padding: 0 12px;
            border-radius: var(--radius-pill);
            background: var(--cream);
            font-size: 12px;
            font-weight: 500;
            color: var(--brown);
            letter-spacing: -0.5px;
            line-height: 24px;
        }

        .vendor-desc {
            font-size: 14px;
            font-weight: 400;
            color: var(--brown-mid);
            letter-spacing: -0.5px;
            line-height: 20px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            line-clamp: 2;
            overflow: hidden;
        }

        .card-footer-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
        }

        .price-group {
            display: flex;
            flex-direction: column;
        }

        .price-label {
            font-size: 12px;
            font-weight: 400;
            color: var(--brown-mid);
            letter-spacing: -0.5px;
            line-height: 16px;
        }

        .price-value {
            font-size: 20px;
            font-weight: 700;
            color: var(--sage);
            letter-spacing: -0.5px;
            line-height: 28px;
        }

        .order-btn {
            height: 48px;
            padding: 0 24px;
            border-radius: var(--radius-btn);
            background: var(--sage);
            color: var(--white);
            font-size: 16px;
            font-weight: 600;
            letter-spacing: -0.5px;
            line-height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s, box-shadow 0.2s, transform 0.15s;
        }

        .order-btn:hover {
            background: #355e54;
            box-shadow: 0 6px 16px rgba(66, 118, 106, 0.35);
            transform: translateY(-1px);
        }

        .order-btn:active {
            transform: translateY(0);
        }

        /* ─── Quick Stats ───────────────────────────────────── */
        .stats-grid {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .stat-card {
            background: var(--white);
            border-radius: 18px;
            box-shadow: var(--shadow-card);
            padding: 16px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            border: 1px solid rgba(116, 70, 34, 0.08);
            transition: box-shadow 0.25s, transform 0.25s;
        }

        .stat-card:hover {
            box-shadow: var(--shadow-lift);
            transform: translateY(-2px);
        }

        .stat-icon-wrap {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: var(--sage-tint);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-content {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 12px;
            width: 100%;
        }

        .stat-number {
            font-size: 28px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -0.5px;
            line-height: 1.2;
        }

        .stat-label {
            font-size: 14px;
            font-weight: 500;
            color: var(--brown-mid);
            letter-spacing: -0.5px;
            line-height: 1.35;
            text-align: right;
        }

        /* ─── Footer ────────────────────────────────────────── */
        .site-footer {
            background: var(--white);
            border-top: 1px solid rgba(116, 70, 34, 0.10);
            padding: 48px 0 32px;
        }

        .footer-inner {
            max-width: 1440px;
            margin: 0 auto;
            padding: 0 48px;
            display: flex;
            flex-direction: column;
            gap: 32px;
        }

        .footer-cols {
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr 1fr;
            gap: 32px;
        }

        .footer-brand-col {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .footer-brand-top {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .footer-brand-desc {
            font-size: 14px;
            font-weight: 400;
            color: var(--brown-mid);
            letter-spacing: -0.5px;
            line-height: 20px;
        }

        .footer-col-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--brown);
            letter-spacing: -0.5px;
            line-height: 24px;
            margin-bottom: 16px;
        }

        .footer-links {
            display: flex;
            flex-direction: column;
            gap: 8px;
            list-style: none;
        }

        .footer-links a {
            font-size: 14px;
            font-weight: 400;
            color: var(--brown-mid);
            letter-spacing: -0.5px;
            line-height: 20px;
            transition: color 0.2s;
        }

        .footer-links a:hover {
            color: var(--sage);
        }

        .social-row {
            display: flex;
            gap: 12px;
        }

        .social-btn {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-pill);
            background: var(--cream);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s, transform 0.2s;
        }

        .social-btn:hover {
            background: var(--sage);
            transform: translateY(-2px);
        }

        .social-btn:hover svg path {
            fill: var(--white);
        }

        .footer-divider {
            border-top: 1px solid rgba(116, 70, 34, 0.10);
            padding-top: 24px;
            text-align: center;
            font-size: 14px;
            font-weight: 400;
            color: var(--brown-mid);
            letter-spacing: -0.5px;
        }

        /* ─── Responsive ────────────────────────────────────── */
        @media (max-width: 1024px) {

            .header-inner,
            .page-body,
            .footer-inner {
                padding: 0 24px;
            }

            .page-body {
                padding-top: 48px;
                padding-bottom: 48px;
            }

            .vendors-grid,
            .vendors-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-cols {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 640px) {
            .header-inner {
                padding: 0 16px;
            }

            .main-nav {
                display: none;
            }

            .mobile-quick-links {
                display: flex;
                gap: 8px;
                overflow-x: auto;
                white-space: nowrap;
                -webkit-overflow-scrolling: touch;
                padding: 8px 16px 10px;
                background: rgba(255, 255, 255, 0.9);
                border-bottom: 1px solid rgba(116, 70, 34, 0.10);
            }

            .mobile-quick-links::-webkit-scrollbar {
                display: none;
            }

            .mobile-quick-link {
                flex: 0 0 auto;
                min-height: 34px;
                padding: 0 14px;
                border-radius: var(--radius-pill);
                background: rgba(66, 118, 106, 0.12);
                color: var(--brown);
                font-size: 12px;
                font-weight: 600;
                letter-spacing: -0.3px;
                line-height: 34px;
            }

            .logo-text-group {
                display: none;
            }

            .header-actions {
                gap: 10px;
            }

            .page-body {
                padding: 32px 16px 48px;
                gap: 18px;
            }

            .vendors-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
            }

            .footer-cols {
                grid-template-columns: 1fr;
            }

            .page-title {
                font-size: 26px;
            }

            .search-row {
                flex-direction: column;
            }

            .filter-btn {
                width: 100%;
                justify-content: center;
            }

            .category-pills {
                flex-wrap: nowrap;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                gap: 10px;
                padding-bottom: 4px;
            }

            .category-pills::-webkit-scrollbar {
                display: none;
            }

            .pill {
                flex: 0 0 auto;
                white-space: nowrap;
                min-height: 38px;
                padding: 0 16px;
                font-size: 13px;
                line-height: 38px;
            }

            .card-image-wrap {
                height: 116px;
            }

            .card-badges {
                top: 8px;
                left: 8px;
                gap: 6px;
            }

            .badge-label {
                height: 22px;
                line-height: 22px;
                padding: 0 10px;
                font-size: 10px;
            }

            .wishlist-btn {
                top: 8px;
                right: 8px;
                width: 30px;
                height: 30px;
            }

            .card-body {
                padding: 12px;
                gap: 8px;
            }

            .vendor-name {
                font-size: 15px;
                line-height: 1.35;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                line-clamp: 2;
                overflow: hidden;
                min-height: 40px;
            }

            .vendor-location {
                font-size: 12px;
                line-height: 1.35;
            }

            .vendor-tags {
                gap: 6px;
            }

            .vendor-tag {
                height: 20px;
                line-height: 20px;
                padding: 0 8px;
                font-size: 10px;
            }

            .vendor-desc {
                display: none;
            }

            .card-footer-row {
                flex-direction: column;
                align-items: stretch;
                gap: 8px;
            }

            .price-group {
                display: none;
            }

            .order-btn {
                width: 100%;
                justify-content: center;
                min-height: 40px;
                font-size: 13px;
                padding: 0 10px;
            }

            .site-footer {
                padding: 32px 0 20px;
            }

            .footer-inner {
                padding: 0 16px;
                gap: 20px;
            }

            .footer-cols {
                gap: 20px;
            }

            .footer-brand-desc,
            .footer-links a {
                font-size: 13px;
                line-height: 1.45;
            }

            .footer-col-title {
                margin-bottom: 10px;
                font-size: 15px;
            }

            .social-btn {
                width: 34px;
                height: 34px;
            }

            .footer-divider {
                padding-top: 16px;
                font-size: 12px;
            }
        }
    </style>
</head>

<body>

    <!-- ═══════════════════════════════════════════ HEADER -->
    <header class="site-header">
        <div class="header-inner">

            <!-- Logo -->
            <a href="/" class="logo-group">
                <div class="logo-icon">
                    <img src="https://api.builder.io/api/v1/image/assets/TEMP/10a82c5c6d87de97d3583b6c8564df77f595f954?width=1114" alt="Kantin Kita Logo" style="width:100%;height:100%;object-fit:cover;border-radius:inherit;" />
                </div>
                <div class="logo-text-group">
                    <span class="logo-name">Kantin Kita</span>
                    <span class="logo-tagline">Campus Canteen</span>
                </div>
            </a>

            <!-- Navigation -->
            <nav class="main-nav">
                <a href="{{ route('home') }}" class="nav-link">Home</a>
                <a href="{{ route('vendor') }}" class="nav-link">Vendors</a>
                <a href="{{ route('login') }}" class="nav-link">My Orders</a>
                <a href="{{ route('login') }}" class="nav-link">Profile</a>
            </nav>

            <!-- Actions -->
            <div class="header-actions">
                <button class="notif-btn" aria-label="Notifications">
                    <span class="notif-badge">3</span>
                    <svg width="18" height="20" viewBox="0 0 18 20" fill="none">
                        <path d="M8.75002 0C8.05861 0 7.50001 0.558594 7.50001 1.25V2C4.64845 2.57812 2.50002 5.10156 2.50002 8.125V8.85938C2.50002 10.6953 1.82423 12.4688 0.605484 13.8438L0.316421 14.168C-0.0117035 14.5352-0.0898286 15.0625 0.10939 15.5117C0.308609 15.9609 0.757828 16.25 1.25002 16.25H16.25C16.7422 16.25 17.1875 15.9609 17.3906 15.5117C17.5938 15.0625 17.5117 14.5352 17.1836 14.168L16.8945 13.8438C15.6758 12.4688 15 10.6992 15 8.85938V8.125C15 5.10156 12.8516 2.57812 10 2V1.25C10 0.558594 9.44142 0 8.75002 0ZM10.5195 19.2695C10.9883 18.8008 11.25 18.1641 11.25 17.5H6.25001C6.25001 18.1641 6.51173 18.8008 6.98048 19.2695C7.44923 19.7383 8.08595 20 8.75002 20C9.41408 20 10.0508 19.7383 10.5195 19.2695Z" fill="#744622" />
                    </svg>
                </button>
                <div class="avatar-wrap">
                    <img src="https://api.builder.io/api/v1/image/assets/TEMP/0a270abbdf4371c1193a8877d596cf906b3bf52c?width=72" alt="Profile" class="avatar-img" />
                </div>
            </div>

        </div>
    </header>

    <nav class="mobile-quick-links" aria-label="Quick links">
        <a href="{{ route('home') }}" class="mobile-quick-link">Home</a>
        <a href="{{ route('vendor') }}" class="mobile-quick-link">Vendors</a>
        <a href="{{ route('login') }}" class="mobile-quick-link">My Orders</a>
        <a href="{{ route('login') }}" class="mobile-quick-link">Profile</a>
    </nav>

    <!-- ═══════════════════════════════════════════ MAIN -->
    <main>
        <div class="page-body">

            <!-- Page Header -->
            <div class="page-header-row reveal">
                <a href="/" class="back-btn" aria-label="Go back">
                    <svg width="16" height="18" viewBox="0 0 16 18" fill="none">
                        <path d="M0.330444 8.20542C-0.109009 8.64487-0.109009 9.35855 0.330444 9.798L5.95544 15.423C6.3949 15.8625 7.10857 15.8625 7.54802 15.423C7.98748 14.9835 7.98748 14.2699 7.54802 13.8304L3.83904 10.125H14.625C15.2472 10.125 15.75 9.62222 15.75 8.99995C15.75 8.37769 15.2472 7.87495 14.625 7.87495H3.84255L7.54451 4.16948C7.98396 3.73003 7.98396 3.01636 7.54451 2.5769C7.10505 2.13745 6.39138 2.13745 5.95193 2.5769L0.326929 8.2019L0.330444 8.20542Z" fill="#744622" />
                    </svg>
                </a>
                <div>
                    <h2 class="page-title">Select Your Vendor</h2>
                    <p class="page-subtitle">Choose from our premium campus vendors</p>
                </div>
            </div>

            <!-- Search & Filter -->
            <div class="reveal reveal-delay-1">
                <div class="search-row">
                    <div class="search-field-wrap">
                        <span class="search-icon">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M13 6.5C13 7.93437 12.5344 9.25938 11.75 10.3344L15.7063 14.2937C16.0969 14.6844 16.0969 15.3188 15.7063 15.7094C15.3156 16.1 14.6812 16.1 14.2906 15.7094L10.3344 11.75C9.25938 12.5375 7.93437 13 6.5 13C2.90937 13 0 10.0906 0 6.5C0 2.90937 2.90937 0 6.5 0C10.0906 0 13 2.90937 13 6.5ZM6.5 11C8.98528 11 11 8.98528 11 6.5C11 4.01472 8.98528 2 6.5 2C4.01472 2 2 4.01472 2 6.5C2 8.98528 4.01472 11 6.5 11Z" fill="#A67C52" />
                            </svg>
                        </span>
                        <input type="text" class="search-input" placeholder="Search vendors, cuisines, or dishes..." />
                    </div>
                    <button class="filter-btn">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M0.121864 1.71563C0.328114 1.27813 0.765614 1 1.24999 1H14.75C15.2344 1 15.6719 1.27813 15.8781 1.71563C16.0844 2.15313 16.0219 2.66875 15.7156 3.04375L9.99999 10.0281V14C9.99999 14.3781 9.78749 14.725 9.44686 14.8938C9.10624 15.0625 8.70311 15.0281 8.39999 14.8L6.39999 13.3C6.14686 13.1125 5.99999 12.8156 5.99999 12.5V10.0281L0.281239 3.04063C-0.0218857 2.66875-0.0875107 2.15 0.121864 1.71563Z" fill="#744622" />
                        </svg>
                        Filters
                    </button>
                </div>
            </div>

            <!-- Category Pills -->
            <div class="category-pills reveal reveal-delay-2">
                <button class="pill pill-active" data-category="all" onclick="setActive(this)">All Vendors</button>
                <button class="pill pill-inactive" data-category="indonesia" onclick="setActive(this)">Indonesian</button>
                <button class="pill pill-inactive" data-category="western" onclick="setActive(this)">Western</button>
                <button class="pill pill-inactive" data-category="asia" onclick="setActive(this)">Asian</button>
                <button class="pill pill-inactive" data-category="minuman" onclick="setActive(this)">Beverages</button>
                <button class="pill pill-inactive" data-category="snack" onclick="setActive(this)">Snacks</button>
            </div>

            <!-- Vendors Grid -->
            <div class="vendors-grid" id="vendorsGrid">
                @php
                $vendorImageFallbacks = [
                'Warung Nusantara' => 'https://images.pexels.com/photos/3590401/pexels-photo-3590401.jpeg?auto=compress&cs=tinysrgb&w=864&h=512&fit=crop',
                'The Burger Hub' => 'https://api.builder.io/api/v1/image/assets/TEMP/8eae28831fbb7d76231e72013a84088be8fb3d13?width=864',
                'Bubble Tea Corner' => 'https://api.builder.io/api/v1/image/assets/TEMP/b5ba4c85139506ab2fd522e5e767ae7d0ecbce34?width=864',
                'Ramen Station' => 'https://api.builder.io/api/v1/image/assets/TEMP/0c714eb1825d3dd142cfebe8527dc83ba75a69be?width=864',
                'Fresh & Healthy' => 'https://api.builder.io/api/v1/image/assets/TEMP/ececcd477fc1231e4bbe74a931558732204a0e78?width=864',
                'Campus Brew' => 'https://api.builder.io/api/v1/image/assets/TEMP/ae917f5edf17a276a169dc78fb9e5a9a81fa6485?width=864',
                'Warung Bu Sari' => 'https://images.pexels.com/photos/3590401/pexels-photo-3590401.jpeg?auto=compress&cs=tinysrgb&w=864&h=512&fit=crop',
                'Warung Mbok Sri' => 'https://images.pexels.com/photos/262978/pexels-photo-262978.jpeg?auto=compress&cs=tinysrgb&w=864&h=512&fit=crop',
                ];
                $defaultVendorImage = 'https://images.pexels.com/photos/1640774/pexels-photo-1640774.jpeg?auto=compress&cs=tinysrgb&w=864&h=512&fit=crop';
                @endphp

                @forelse ($vendors as $vendor)
                @php
                $vendorName = (string) $vendor->nama_vendor;
                $vendorCategory = (string) ($vendor->kategori ?: 'Lainnya');
                $vendorImage = $vendor->path_logo ?: ($vendorImageFallbacks[$vendorName] ?? $defaultVendorImage);
                @endphp
                <article class="vendor-card reveal reveal-delay-{{ ($loop->index % 3) + 1 }}"
                    data-vendor-name="{{ strtolower($vendorName) }}"
                    data-vendor-category="{{ strtolower($vendorCategory) }}">
                    <div class="card-image-wrap">
                        <img src="{{ $vendorImage }}" alt="{{ $vendorName }}" class="card-food-img" />
                        <div class="card-badges">
                            @if ($loop->first || (float) $vendor->rating >= 4.8)
                            <span class="badge-label badge-green">Popular</span>
                            @endif
                            <span class="badge-label badge-rating">
                                <svg width="13" height="12" viewBox="0 0 14 12" fill="none">
                                    <path d="M7.4274 0.421875C7.30318 0.164062 7.04068 0 6.7524 0C6.46412 0 6.20396 0.164062 6.0774 0.421875L4.57037 3.52266L1.20474 4.01953C0.923491 4.06172 0.689116 4.25859 0.602397 4.52812C0.515678 4.79766 0.585991 5.09531 0.787553 5.29453L3.22974 7.71094L2.65318 11.1258C2.6063 11.407 2.72349 11.693 2.95552 11.8594C3.18755 12.0258 3.49458 12.0469 3.74771 11.9133L6.75474 10.3078L9.76177 11.9133C10.0149 12.0469 10.3219 12.0281 10.554 11.8594C10.786 11.6906 10.9032 11.407 10.8563 11.1258L10.2774 7.71094L12.7196 5.29453C12.9211 5.09531 12.9938 4.79766 12.9047 4.52812C12.8157 4.25859 12.5836 4.06172 12.3024 4.01953L8.93443 3.52266L7.4274 0.421875Z" fill="#EAB308" />
                                </svg>
                                {{ number_format((float) $vendor->rating, 1) }}
                            </span>
                        </div>
                        <button class="wishlist-btn" aria-label="Add to wishlist">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M7.05625 14.6312L6.97813 14.5593L1.50312 9.47496C0.54375 8.58433 0 7.33433 0 6.02496V5.92183C0 3.72183 1.5625 1.83433 3.725 1.42183C4.95625 1.18433 6.21562 1.46871 7.21875 2.17496C7.5 2.37496 7.7625 2.60621 8 2.87183C8.13125 2.72183 8.27188 2.58433 8.42188 2.45621C8.5375 2.35621 8.65625 2.26246 8.78125 2.17496C9.78438 1.46871 11.0437 1.18433 12.275 1.41871C14.4375 1.83121 16 3.72183 16 5.92183V6.02496C16 7.33433 15.4563 8.58433 14.4969 9.47496L9.02188 14.5593L8.94375 14.6312C8.6875 14.8687 8.35 15.0031 8 15.0031C7.65 15.0031 7.3125 14.8718 7.05625 14.6312Z" fill="rgba(0,0,0,0.25)" />
                            </svg>
                        </button>
                    </div>
                    <div class="card-body">
                        <h3 class="vendor-name">{{ $vendorName }}</h3>
                        <div class="vendor-location">
                            <svg width="11" height="14" viewBox="0 0 11 14" fill="none">
                                <path d="M5.89805 13.65C7.30078 11.8945 10.5 7.63984 10.5 5.25C10.5 2.35156 8.14844 0 5.25 0C2.35156 0 0 2.35156 0 5.25C0 7.63984 3.19922 11.8945 4.60195 13.65C4.93828 14.0684 5.56172 14.0684 5.89805 13.65ZM5.25 3.5C5.71413 3.5 6.15925 3.68437 6.48744 4.01256C6.81563 4.34075 7 4.78587 7 5.25C7 5.71413 6.81563 6.15925 6.48744 6.48744C6.15925 6.81563 5.71413 7 5.25 7C4.78587 7 4.34075 6.81563 4.01256 6.48744C3.68437 6.15925 3.5 5.71413 3.5 5.25C3.5 4.78587 3.68437 4.34075 4.01256 4.01256C4.34075 3.68437 4.78587 3.5 5.25 3.5Z" fill="#42766A" />
                            </svg>
                            {{ $vendor->lokasi ?: 'Area Kantin UNAIR' }}
                        </div>
                        <div class="vendor-tags">
                            <span class="vendor-tag">{{ $vendorCategory }}</span>
                            <span class="vendor-tag">Open</span>
                        </div>
                        <p class="vendor-desc">{{ \Illuminate\Support\Str::limit($vendor->deskripsi ?: 'Vendor kampus dengan pilihan menu favorit mahasiswa.', 120) }}</p>
                        <div class="card-footer-row">
                            <div class="price-group">
                                <span class="price-label">Starting from</span>
                                <span class="price-value">
                                    @if (! is_null($vendor->menus_min_harga))
                                    Rp {{ number_format((int) $vendor->menus_min_harga, 0, ',', '.') }}
                                    @else
                                    Lihat menu
                                    @endif
                                </span>
                            </div>
                            <a class="order-btn" href="{{ route('menu', ['id' => $vendor->id]) }}">Order Now</a>
                        </div>
                    </div>
                </article>
                @empty
                <article class="vendor-card reveal reveal-delay-1">
                    <div class="card-body">
                        <h3 class="vendor-name">Belum ada vendor terbuka</h3>
                        <p class="vendor-desc">Coba lagi beberapa saat lagi atau hubungi pengelola kantin.</p>
                    </div>
                </article>
                @endforelse

            </div><!-- /vendors-grid -->

            <!-- Quick Stats -->
            <div class="stats-grid">

                <div class="stat-card reveal reveal-delay-1">
                    <div class="stat-icon-wrap">
                        <svg width="27" height="24" viewBox="0 0 27 24" fill="none">
                            <path d="M25.6688 4.86563L22.9828 0.614063C22.7438 0.234375 22.3172 0 21.8625 0H5.13752C4.68283 0 4.25627 0.234375 4.01721 0.614063L1.32658 4.86563C-0.0609191 7.05938 1.16721 10.1109 3.75939 10.4625C3.94689 10.4859 4.13908 10.5 4.32658 10.5C5.55002 10.5 6.63752 9.96562 7.38283 9.14062C8.12814 9.96562 9.21564 10.5 10.4391 10.5C11.6625 10.5 12.75 9.96562 13.4953 9.14062C14.2406 9.96562 15.3281 10.5 16.5516 10.5C17.7797 10.5 18.8625 9.96562 19.6078 9.14062C20.3578 9.96562 21.4406 10.5 22.6641 10.5C22.8563 10.5 23.0438 10.4859 23.2313 10.4625C25.8328 10.1156 27.0656 7.06406 25.6735 4.86563H25.6688ZM23.4235 11.9484H23.4188C23.1703 11.9812 22.9172 12 22.6594 12C22.0781 12 21.5203 11.9109 21 11.7516V18H6.00002V11.7469C5.47502 11.9109 4.91252 12 4.33127 12C4.07346 12 3.81564 11.9812 3.56721 11.9484H3.56252C3.37033 11.9203 3.18283 11.8875 3.00002 11.8406V18V21C3.00002 22.6547 4.34533 24 6.00002 24H21C22.6547 24 24 22.6547 24 21V18V11.8406C23.8125 11.8875 23.625 11.925 23.4235 11.9484Z" fill="#42766A" />
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number" data-target="{{ $vendors->count() }}">0+</div>
                        <div class="stat-label">Active Vendors</div>
                    </div>
                </div>

                <div class="stat-card reveal reveal-delay-2">
                    <div class="stat-icon-wrap">
                        <svg width="21" height="24" viewBox="0 0 21 24" fill="none">
                            <path d="M19.5 0C18.75 0 13.5 1.5 13.5 8.25V13.5C13.5 15.1547 14.8453 16.5 16.5 16.5H18V22.5C18 23.3297 18.6703 24 19.5 24C20.3297 24 21 23.3297 21 22.5V16.5V11.25V1.5C21 0.670312 20.3297 0 19.5 0ZM3 0.75C3 0.365625 2.71406 0.046875 2.32969 0.0046875C1.94531-0.0375 1.60313 0.215625 1.51875 0.585938L0.0984375 6.975C0.0328125 7.27031 0 7.57031 0 7.87031C0 10.0219 1.64531 11.7891 3.75 11.9813V22.5C3.75 23.3297 4.42031 24 5.25 24C6.07969 24 6.75 23.3297 6.75 22.5V11.9813C8.85469 11.7891 10.5 10.0219 10.5 7.87031C10.5 7.57031 10.4672 7.27031 10.4016 6.975L8.98125 0.585938C8.89688 0.210938 8.54531-0.0375 8.16562 0.0046875C7.78594 0.046875 7.5 0.365625 7.5 0.75V7.04062C7.5 7.29375 7.29375 7.5 7.04062 7.5C6.80156 7.5 6.60469 7.31719 6.58125 7.07812L5.99531 0.684375C5.9625 0.295313 5.63906 0 5.25 0C4.86094 0 4.5375 0.295313 4.50469 0.684375L3.92344 7.07812C3.9 7.31719 3.70312 7.5 3.46406 7.5C3.21094 7.5 3.00469 7.29375 3.00469 7.04062V0.75H3Z" fill="#42766A" />
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number" data-target="{{ (int) $vendors->sum('menus_count') }}">0+</div>
                        <div class="stat-label">Menu Items</div>
                    </div>
                </div>

                <div class="stat-card reveal reveal-delay-3">
                    <div class="stat-icon-wrap">
                        <svg width="30" height="24" viewBox="0 0 30 24" fill="none">
                            <path d="M6.75 0C7.74456 0 8.69839 0.395088 9.40165 1.09835C10.1049 1.80161 10.5 2.75544 10.5 3.75C10.5 4.74456 10.1049 5.69839 9.40165 6.40165C8.69839 7.10491 7.74456 7.5 6.75 7.5C5.75544 7.5 4.80161 7.10491 4.09835 6.40165C3.39509 5.69839 3 4.74456 3 3.75C3 2.75544 3.39509 1.80161 4.09835 1.09835C4.80161 0.395088 5.75544 0 6.75 0ZM24 0C24.9946 0 25.9484 0.395088 26.6516 1.09835C27.3549 1.80161 27.75 2.75544 27.75 3.75C27.75 4.74456 27.3549 5.69839 26.6516 6.40165C25.9484 7.10491 24.9946 7.5 24 7.5C23.0054 7.5 22.0516 7.10491 21.3484 6.40165C20.6451 5.69839 20.25 4.74456 20.25 3.75C20.25 2.75544 20.6451 1.80161 21.3484 1.09835C22.0516 0.395088 23.0054 0 24 0ZM0 14.0016C0 11.2406 2.24062 9 5.00156 9H7.00312C7.74844 9 8.45625 9.16406 9.09375 9.45469C9.03281 9.79219 9.00469 10.1438 9.00469 10.5C9.00469 12.2906 9.79219 13.8984 11.0344 15C11.025 15 11.0156 15 11.0016 15H0.998437C0.45 15 0 14.55 0 14.0016ZM18.9984 15C18.9891 15 18.9797 15 18.9656 15C20.2125 13.8984 20.9953 12.2906 20.9953 10.5C20.9953 10.1438 20.9625 9.79688 20.9062 9.45469C21.5438 9.15938 22.2516 9 22.9969 9H24.9984C27.7594 9 30 11.2406 30 14.0016C30 14.5547 29.55 15 29.0016 15H18.9984ZM10.5 10.5C10.5 9.30653 10.9741 8.16193 11.818 7.31802C12.6619 6.47411 13.8065 6 15 6C16.1935 6 17.3381 6.47411 18.182 7.31802C19.0259 8.16193 19.5 9.30653 19.5 10.5C19.5 11.6935 19.0259 12.8381 18.182 13.682C17.3381 14.5259 16.1935 15 15 15C13.8065 15 12.6619 14.5259 11.818 13.682C10.9741 12.8381 10.5 11.6935 10.5 10.5ZM6 22.7484C6 19.2984 8.79844 16.5 12.2484 16.5H17.7516C21.2016 16.5 24 19.2984 24 22.7484C24 23.4375 23.4422 24 22.7484 24H7.25156C6.5625 24 6 23.4422 6 22.7484Z" fill="#42766A" />
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number" data-target="5000">0+</div>
                        <div class="stat-label">Happy Students</div>
                    </div>
                </div>

            </div><!-- /stats-grid -->

        </div><!-- /page-body -->
    </main>

    <!-- ═══════════════════════════════════════════ FOOTER -->
    <footer class="site-footer">
        <div class="footer-inner">
            <div class="footer-cols">

                <!-- Brand -->
                <div class="footer-brand-col">
                    <div class="footer-brand-top">
                        <div class="logo-icon" style="width:48px;height:48px;flex-shrink:0;">
                            <img src="https://api.builder.io/api/v1/image/assets/TEMP/10a82c5c6d87de97d3583b6c8564df77f595f954?width=1114" alt="Kantin Kita Logo" style="width:100%;height:100%;object-fit:cover;border-radius:inherit;" />
                        </div>
                        <div class="logo-text-group">
                            <span style="font-size:20px;font-weight:700;color:var(--brown);letter-spacing:-0.5px;">Kantin Kita</span>
                            <span style="font-size:12px;color:var(--brown-mid);">Campus Canteen</span>
                        </div>
                    </div>
                    <p class="footer-brand-desc">Your favorite campus food destination, bringing quality and convenience together.</p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h5 class="footer-col-title">Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('vendor') }}">All Vendors</a></li>
                        <li><a href="{{ route('login') }}">My Orders</a></li>
                        <li><a href="{{ route('home') }}#contact">Help Center</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h5 class="footer-col-title">Support</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}#contact">FAQ</a></li>
                        <li><a href="{{ route('home') }}#contact">Contact Us</a></li>
                        <li><a href="{{ route('home') }}#contact">Terms of Service</a></li>
                        <li><a href="{{ route('home') }}#contact">Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Social -->
                <div>
                    <h5 class="footer-col-title">Connect With Us</h5>
                    <div class="social-row">
                        <!-- Instagram -->
                        <a href="{{ route('home') }}" class="social-btn" aria-label="Instagram">
                            <svg width="14" height="16" viewBox="0 0 14 16" fill="none">
                                <path d="M7.00315 4.40635C5.01565 4.40635 3.41252 6.00947 3.41252 7.99697C3.41252 9.98447 5.01565 11.5876 7.00315 11.5876C8.99065 11.5876 10.5938 9.98447 10.5938 7.99697C10.5938 6.00947 8.99065 4.40635 7.00315 4.40635ZM7.00315 10.3313C5.71877 10.3313 4.66877 9.28447 4.66877 7.99697C4.66877 6.70947 5.71565 5.6626 7.00315 5.6626C8.29065 5.6626 9.33752 6.70947 9.33752 7.99697C9.33752 9.28447 8.28752 10.3313 7.00315 10.3313ZM11.5781 4.25947C11.5781 4.7251 11.2031 5.09697 10.7407 5.09697C10.275 5.09697 9.90315 4.72197 9.90315 4.25947C9.90315 3.79697 10.2782 3.42197 10.7407 3.42197C11.2031 3.42197 11.5781 3.79697 11.5781 4.25947ZM13.9563 5.10947C13.9031 3.9876 13.6469 2.99385 12.825 2.1751C12.0063 1.35635 11.0125 1.1001 9.89065 1.04385C8.7344 0.978223 5.26877 0.978223 4.11252 1.04385C2.99377 1.09697 2.00002 1.35322 1.17815 2.17197C0.356274 2.99072 0.103149 3.98447 0.0468994 5.10635C-0.0187256 6.2626-0.0187256 9.72822 0.0468994 10.8845C0.100024 12.0063 0.356274 13.0001 1.17815 13.8188C2.00002 14.6376 2.99065 14.8938 4.11252 14.9501C5.26877 15.0157 8.7344 15.0157 9.89065 14.9501C11.0125 14.897 12.0063 14.6407 12.825 13.8188C13.6438 13.0001 13.9 12.0063 13.9563 10.8845C14.0219 9.72822 14.0219 6.26572 13.9563 5.10947ZM12.4625 12.1251C12.2188 12.7376 11.7469 13.2095 11.1313 13.4563C10.2094 13.822 8.0219 13.7376 7.00315 13.7376C5.9844 13.7376 3.79377 13.8188 2.87502 13.4563C2.26252 13.2126 1.79065 12.7407 1.54377 12.1251C1.17815 11.2032 1.26252 9.01572 1.26252 7.99697C1.26252 6.97822 1.18127 4.7876 1.54377 3.86885C1.78752 3.25635 2.2594 2.78447 2.87502 2.5376C3.7969 2.17197 5.9844 2.25635 7.00315 2.25635C8.0219 2.25635 10.2125 2.1751 11.1313 2.5376C11.7438 2.78135 12.2156 3.25322 12.4625 3.86885C12.8281 4.79072 12.7438 6.97822 12.7438 7.99697C12.7438 9.01572 12.8281 11.2063 12.4625 12.1251Z" fill="black" />
                            </svg>
                        </a>
                        <!-- Facebook -->
                        <a href="{{ route('home') }}" class="social-btn" aria-label="Facebook">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M15.75 8C15.75 3.71875 12.2812 0.25 8 0.25C3.71875 0.25 0.25 3.71875 0.25 8C0.25 11.8681 3.08406 15.0744 6.78906 15.6562V10.2403H4.82031V8H6.78906V6.2925C6.78906 4.35031 7.94531 3.2775 9.71625 3.2775C10.5644 3.2775 11.4513 3.42875 11.4513 3.42875V5.335H10.4738C9.51125 5.335 9.21094 5.9325 9.21094 6.54531V8H11.3603L11.0166 10.2403H9.21094V15.6562C12.9159 15.0744 15.75 11.8681 15.75 8Z" fill="black" />
                            </svg>
                        </a>
                        <!-- Twitter / X -->
                        <a href="{{ route('home') }}" class="social-btn" aria-label="Twitter">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M14.3553 4.741C14.3655 4.88313 14.3655 5.02529 14.3655 5.16741C14.3655 9.50241 11.066 14.4973 5.03553 14.4973C3.17766 14.4973 1.45178 13.9593 0 13.0253C0.263969 13.0557 0.51775 13.0659 0.791875 13.0659C2.32484 13.0659 3.73603 12.5481 4.86294 11.6649C3.42131 11.6344 2.21319 10.6903 1.79694 9.39075C2 9.42119 2.20303 9.4415 2.41625 9.4415C2.71066 9.4415 3.00509 9.40088 3.27919 9.32985C1.77666 9.02525 0.649719 7.70547 0.649719 6.11157V6.07097C1.08625 6.31463 1.59391 6.46691 2.13194 6.48719C1.24869 5.89835 0.670031 4.89329 0.670031 3.75622C0.670031 3.1471 0.832438 2.58872 1.11672 2.10141C2.73094 4.09125 5.15734 5.39072 7.87813 5.53288C7.82738 5.28922 7.79691 5.03544 7.79691 4.78163C7.79691 2.9745 9.25884 1.50244 11.0761 1.50244C12.0203 1.50244 12.873 1.89838 13.472 2.53797C14.2131 2.39585 14.9238 2.12172 15.5533 1.7461C15.3096 2.50754 14.7918 3.14713 14.1116 3.55319C14.7715 3.48216 15.4111 3.29938 15.9999 3.0456C15.5533 3.69532 14.9949 4.27397 14.3553 4.741Z" fill="black" />
                            </svg>
                        </a>
                    </div>
                </div>

            </div><!-- /footer-cols -->

            <div class="footer-divider">
                &copy; 2024 Kantin Kita. All rights reserved.
            </div>
        </div><!-- /footer-inner -->
    </footer>

    <!-- ═══════════════════════════════════════════ SCRIPTS -->
    <script>
        /* ── Category pill toggle ─────────────────────────── */
        let activeCategory = 'all';

        function setActive(btn) {
            document.querySelectorAll('.pill').forEach(p => {
                p.classList.remove('pill-active');
                p.classList.add('pill-inactive');
            });
            btn.classList.remove('pill-inactive');
            btn.classList.add('pill-active');

            activeCategory = (btn.dataset.category || 'all').toLowerCase();
            applyVendorFilters();
        }

        function normalizeText(value) {
            return (value || '').toLowerCase().trim();
        }

        function applyVendorFilters() {
            const query = normalizeText(document.querySelector('.search-input')?.value);
            const cards = document.querySelectorAll('#vendorsGrid .vendor-card[data-vendor-name]');

            cards.forEach(card => {
                const name = normalizeText(card.dataset.vendorName);
                const category = normalizeText(card.dataset.vendorCategory);

                const matchQuery = !query || name.includes(query) || category.includes(query);
                const matchCategory = activeCategory === 'all' || category.includes(activeCategory);

                card.style.display = matchQuery && matchCategory ? '' : 'none';
            });
        }

        /* ── Scroll-reveal observer ───────────────────────── */
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.12
        });

        document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

        const searchInput = document.querySelector('.search-input');
        if (searchInput) {
            searchInput.addEventListener('input', applyVendorFilters);
        }
        applyVendorFilters();

        /* ── Animated stat counters ───────────────────────── */
        function animateCounter(el) {
            const target = parseInt(el.dataset.target, 10);
            const suffix = target >= 1000 ? '+' : '+';
            const duration = 1400;
            const step = target / (duration / 16);
            let current = 0;
            const tick = () => {
                current = Math.min(current + step, target);
                el.textContent = Math.floor(current).toLocaleString() + suffix;
                if (current < target) requestAnimationFrame(tick);
            };
            tick();
        }

        const statObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    statObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.5
        });

        document.querySelectorAll('.stat-number[data-target]').forEach(el => statObserver.observe(el));

        /* ── Wishlist toggle ──────────────────────────────── */
        document.querySelectorAll('.wishlist-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                btn.classList.toggle('active');
                const path = btn.querySelector('svg path');
                if (btn.classList.contains('active')) {
                    path.setAttribute('fill', '#ef4444');
                } else {
                    path.setAttribute('fill', 'rgba(0,0,0,0.25)');
                }
            });
        });
    </script>

</body>

</html>