<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Warung Bu Sari – Kantin Kita</title>
    <link rel="icon" type="image/png" href="https://api.builder.io/api/v1/image/assets/TEMP/10a82c5c6d87de97d3583b6c8564df77f595f954?width=1114" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        /* ─── Reset & Base ─────────────────────────────────────── */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --cream: #FBF5E8;
            --brown: #744622;
            --brown-light: #B8936A;
            --sage: #42766A;
            --sage-dark: #345f55;
            --white: #ffffff;
            --border: #E5E7EB;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, .05);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, .07), 0 10px 20px rgba(0, 0, 0, .06);
            --shadow-float: 0 4px 6px rgba(0, 0, 0, .10), 0 10px 15px rgba(0, 0, 0, .10);
            --radius-card: 20px;
            --radius-btn: 15px;
            --radius-pill: 9999px;
        }

        html,
        body {
            height: 100%;
            font-family: 'Poppins', sans-serif;
            background: var(--cream);
            color: var(--brown);
            -webkit-font-smoothing: antialiased;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button {
            cursor: pointer;
            font-family: inherit;
            border: none;
            background: none;
        }

        img {
            display: block;
            max-width: 100%;
        }

        /* ─── Scroll-reveal Utility ─────────────────────────────── */
        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity .55s ease, transform .55s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ─── Page Wrapper ──────────────────────────────────────── */
        .page-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ─── Navbar ────────────────────────────────────────────── */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: var(--white);
            border-bottom: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }

        .navbar-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 32px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        /* Brand */
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
            text-decoration: none;
        }

        .brand-icon {
            width: 48px;
            height: 48px;
            border-radius: 20px;
            background: var(--sage);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .brand:hover .brand-icon {
            transform: scale(1.08);
            box-shadow: 0 6px 16px rgba(66, 118, 106, .35);
        }

        .brand-text-name {
            font-size: 24px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -0.5px;
            line-height: 1.3;
        }

        .brand-text-sub {
            font-size: 14px;
            font-weight: 400;
            color: var(--brown-light);
            letter-spacing: -0.5px;
            line-height: 1.4;
        }

        /* Search */
        .search-wrapper {
            flex: 1;
            max-width: 448px;
            position: relative;
        }

        .search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .search-input {
            width: 100%;
            height: 42px;
            padding: 8px 16px 8px 40px;
            border-radius: var(--radius-pill);
            border: 1px solid var(--border);
            background: var(--cream);
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            font-weight: 400;
            color: var(--brown);
            letter-spacing: -0.5px;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .search-input::placeholder {
            color: var(--brown-light);
        }

        .search-input:focus {
            border-color: var(--sage);
            box-shadow: 0 0 0 3px rgba(66, 118, 106, .15);
        }

        /* Navbar Actions */
        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-shrink: 0;
        }

        .cart-btn {
            position: relative;
            width: 39px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform .2s;
        }

        .cart-btn:hover {
            transform: scale(1.1);
        }

        .cart-badge {
            position: absolute;
            top: 4px;
            right: -2px;
            width: 20px;
            height: 20px;
            border-radius: var(--radius-pill);
            background: var(--sage);
            color: var(--white);
            font-size: 12px;
            font-weight: 400;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-pill);
            background: var(--sage);
            overflow: hidden;
            flex-shrink: 0;
            cursor: pointer;
            transition: transform .2s, box-shadow .2s;
        }

        .user-avatar:hover {
            transform: scale(1.08);
            box-shadow: 0 4px 12px rgba(66, 118, 106, .3);
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* ─── Main Content ───────────────────────────────────────── */
        .main-content {
            max-width: 1280px;
            margin: 0 auto;
            padding: 32px;
            display: flex;
            flex-direction: column;
            gap: 32px;
            width: 100%;
        }

        /* ─── Vendor Header Card ─────────────────────────────────── */
        .vendor-card {
            background: var(--white);
            border-radius: var(--radius-card);
            box-shadow: var(--shadow-sm);
            padding: 32px;
            position: relative;
            overflow: hidden;
        }

        /* subtle top accent line */
        .vendor-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--sage) 0%, #6db89f 100%);
            border-radius: var(--radius-card) var(--radius-card) 0 0;
        }

        .vendor-card-inner {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .vendor-logo {
            width: 128px;
            height: 128px;
            border-radius: var(--radius-card);
            background: var(--sage);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 8px 24px rgba(66, 118, 106, .25);
        }

        .vendor-info {
            flex: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .vendor-details {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .vendor-name {
            font-size: 36px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -0.5px;
            line-height: 1.1;
        }

        .vendor-meta {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .vendor-rating,
        .vendor-time {
            display: flex;
            align-items: center;
            gap: 4px;
            color: var(--brown-light);
            font-size: 16px;
            letter-spacing: -0.5px;
        }

        .rating-value {
            font-weight: 500;
        }

        .rating-count {
            font-weight: 400;
        }

        .vendor-description {
            font-size: 16px;
            font-weight: 400;
            color: var(--brown);
            line-height: 1.5;
            letter-spacing: -0.5px;
            max-width: 700px;
        }

        .vendor-actions {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 12px;
            flex-shrink: 0;
        }

        .open-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 12px;
            border-radius: var(--radius-btn);
            background: #DCFCE7;
            color: #15803D;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: -0.5px;
        }

        .follow-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: var(--radius-btn);
            background: var(--sage);
            color: var(--white);
            font-size: 16px;
            font-weight: 400;
            letter-spacing: -0.5px;
            transition: background .2s, transform .2s, box-shadow .2s;
        }

        .follow-btn:hover {
            background: var(--sage-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(66, 118, 106, .35);
        }

        .follow-btn:active {
            transform: translateY(0);
        }

        /* ─── Category Filter ────────────────────────────────────── */
        .category-filter {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .category-btn {
            padding: 12px 24px;
            border-radius: var(--radius-btn);
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            font-weight: 500;
            letter-spacing: -0.5px;
            line-height: 24px;
            border: none;
            transition: background .2s, color .2s, transform .2s, box-shadow .2s;
        }

        .category-btn--inactive {
            background: var(--white);
            color: var(--brown);
        }

        .category-btn--inactive:hover {
            background: var(--cream);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .category-btn--active {
            background: var(--sage);
            color: var(--white);
            box-shadow: 0 4px 12px rgba(66, 118, 106, .3);
        }

        .category-btn--active:hover {
            background: var(--sage-dark);
            transform: translateY(-1px);
        }

        /* ─── Menu Grid ──────────────────────────────────────────── */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        /* ─── Menu Item Card ─────────────────────────────────────── */
        .menu-card {
            background: var(--white);
            border-radius: var(--radius-card);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform .3s ease, box-shadow .3s ease;
            cursor: pointer;
        }

        .menu-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-md);
        }

        .menu-card-image-wrap {
            position: relative;
            width: 100%;
            height: 208px;
            overflow: hidden;
            background: #f0ebe3;
        }

        .menu-card-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .45s ease;
        }

        .menu-card:hover .menu-card-image {
            transform: scale(1.06);
        }

        /* Overlay gradient for depth */
        .menu-card-image-wrap::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(116, 70, 34, .18) 0%, transparent 50%);
            pointer-events: none;
        }

        .wishlist-btn {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 32px;
            height: 32px;
            border-radius: var(--radius-pill);
            background: rgba(255, 255, 255, .9);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
            transition: transform .2s, background .2s, box-shadow .2s;
        }

        .wishlist-btn:hover {
            transform: scale(1.15);
            background: rgba(255, 255, 255, 1);
            box-shadow: 0 2px 8px rgba(0, 0, 0, .15);
        }

        .item-badge {
            position: absolute;
            bottom: 12px;
            left: 12px;
            padding: 4px 8px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 500;
            color: var(--white);
            letter-spacing: -0.5px;
            line-height: 16px;
            z-index: 2;
        }

        .badge--popular {
            background: var(--sage);
        }

        .badge--healthy {
            background: #22C55E;
        }

        .badge--hot {
            background: #F97316;
        }

        .badge--fresh {
            background: #3B82F6;
        }

        .menu-card-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            flex: 1;
        }

        .menu-item-name {
            font-size: 18px;
            font-weight: 600;
            color: var(--brown);
            letter-spacing: -0.5px;
            line-height: 1.55;
        }

        .menu-item-desc {
            font-size: 14px;
            font-weight: 400;
            color: var(--brown-light);
            letter-spacing: -0.5px;
            line-height: 1.43;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .menu-item-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: auto;
        }

        .menu-item-price {
            font-size: 20px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -0.5px;
            line-height: 1.4;
        }

        .add-to-cart-btn {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-btn);
            background: var(--sage);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: background .2s, transform .2s, box-shadow .2s;
        }

        .add-to-cart-btn:hover {
            background: var(--sage-dark);
            transform: scale(1.12) rotate(3deg);
            box-shadow: 0 4px 12px rgba(66, 118, 106, .4);
        }

        .add-to-cart-btn:active {
            transform: scale(.95);
        }

        /* ─── Load More ──────────────────────────────────────────── */
        .load-more-wrapper {
            display: flex;
            justify-content: center;
        }

        .load-more-btn {
            padding: 14px 32px;
            border-radius: var(--radius-card);
            border: 2px solid var(--sage);
            background: var(--white);
            color: var(--brown);
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            font-weight: 500;
            letter-spacing: -0.5px;
            line-height: 24px;
            transition: background .2s, color .2s, transform .2s, box-shadow .2s;
        }

        .load-more-btn:hover {
            background: var(--sage);
            color: var(--white);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(66, 118, 106, .3);
        }

        .load-more-btn:active {
            transform: translateY(0);
        }

        /* ─── Floating Cart ──────────────────────────────────────── */
        .floating-cart {
            position: fixed;
            bottom: 32px;
            right: 32px;
            z-index: 200;
        }

        .floating-cart-btn {
            width: 64px;
            height: 64px;
            border-radius: var(--radius-pill);
            background: var(--sage);
            box-shadow: var(--shadow-float);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: background .2s, transform .25s ease, box-shadow .25s ease;
        }

        .floating-cart-btn:hover {
            background: var(--sage-dark);
            transform: scale(1.1) translateY(-3px);
            box-shadow: 0 8px 24px rgba(66, 118, 106, .45);
        }

        .floating-cart-btn:active {
            transform: scale(.97);
        }

        .floating-cart-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            width: 24px;
            height: 24px;
            border-radius: var(--radius-pill);
            background: #F97316;
            color: var(--white);
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(249, 115, 22, .4);
        }

        /* ─── Responsive ─────────────────────────────────────────── */
        @media (max-width: 1024px) {
            .menu-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .vendor-name {
                font-size: 28px;
            }
        }

        @media (max-width: 768px) {
            .navbar-inner {
                padding: 0 20px;
            }

            .main-content {
                padding: 20px;
                gap: 24px;
            }

            .menu-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
            }

            .vendor-card-inner {
                flex-direction: column;
                align-items: flex-start;
            }

            .vendor-info {
                flex-direction: column;
                align-items: flex-start;
            }

            .vendor-name {
                font-size: 24px;
            }

            .vendor-logo {
                width: 80px;
                height: 80px;
            }

            .search-wrapper {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .menu-grid {
                grid-template-columns: 1fr;
            }

            .category-filter {
                gap: 10px;
            }

            .category-btn {
                padding: 10px 18px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

    <div class="page-wrapper">

        <!-- ── Navbar ── -->
        <header class="navbar">
            <div class="navbar-inner">
                <!-- Brand -->
                <a href="/" class="brand">
                    <div class="brand-icon">
                        <img src="https://api.builder.io/api/v1/image/assets/TEMP/10a82c5c6d87de97d3583b6c8564df77f595f954?width=1114" alt="Kantin Kita Logo" style="width:100%;height:100%;object-fit:cover;border-radius:inherit;" />
                    </div>
                    <div>
                        <div class="brand-text-name">Kantin Kita</div>
                        <div class="brand-text-sub">Campus Canteen</div>
                    </div>
                </a>

                <!-- Search -->
                <div class="search-wrapper">
                    <div class="search-icon">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <g clip-path="url(#si)">
                                <path d="M13 6.5C13 7.93437 12.5344 9.25938 11.75 10.3344L15.7063 14.2937C16.0969 14.6844 16.0969 15.3188 15.7063 15.7094C15.3156 16.1 14.6812 16.1 14.2906 15.7094L10.3344 11.75C9.25938 12.5375 7.93437 13 6.5 13C2.90937 13 0 10.0906 0 6.5C0 2.90937 2.90937 0 6.5 0C10.0906 0 13 2.90937 13 6.5ZM6.5 11C9.26142 11 11 9.26142 11 6.5C11 3.73858 9.26142 2 6.5 2C3.73858 2 2 3.73858 2 6.5C2 9.26142 3.73858 11 6.5 11Z" fill="#B8936A" />
                            </g>
                            <defs>
                                <clipPath id="si">
                                    <path d="M0 0H16V16H0V0Z" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                    <input type="text" class="search-input" placeholder="Search menu items..." />
                </div>

                <!-- Actions -->
                <div class="navbar-actions">
                    <button class="cart-btn" aria-label="View cart">
                        <svg width="23" height="20" viewBox="0 0 23 20" fill="none">
                            <g clip-path="url(#ci)">
                                <path d="M0 0.9375C0 0.417969 0.417969 0 0.9375 0H2.71484C3.57422 0 4.33594 0.5 4.69141 1.25H20.7461C21.7734 1.25 22.5234 2.22656 22.2539 3.21875L20.6523 9.16797C20.3203 10.3945 19.207 11.25 17.9375 11.25H6.66797L6.87891 12.3633C6.96484 12.8047 7.35156 13.125 7.80078 13.125H19.0625C19.582 13.125 20 13.543 20 14.0625C20 14.582 19.582 15 19.0625 15H7.80078C6.44922 15 5.28906 14.0391 5.03906 12.7148L3.02344 2.12891C2.99609 1.98047 2.86719 1.875 2.71484 1.875H0.9375C0.417969 1.875 0 1.45703 0 0.9375ZM5 18.125C5 17.0859 5.85547 16.25 6.875 16.25C7.89453 16.25 8.75 17.0859 8.75 18.125C8.75 19.1445 7.89453 20 6.875 20C5.85547 20 5 19.1445 5 18.125ZM18.125 16.25C19.1641 16.25 20 17.0859 20 18.125C20 19.1445 19.1641 20 18.125 20C17.1055 20 16.25 19.1445 16.25 18.125C16.25 17.0859 17.1055 16.25 18.125 16.25Z" fill="#744622" />
                            </g>
                            <defs>
                                <clipPath id="ci">
                                    <path d="M0 0H22.5V20H0V0Z" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                        <span class="cart-badge">3</span>
                    </button>
                    <div class="user-avatar">
                        <img src="https://api.builder.io/api/v1/image/assets/TEMP/4b742a08a0e2996ba119657d8de2de18ce6703b2?width=80" alt="User profile" />
                    </div>
                </div>
            </div>
        </header>

        <!-- ── Main ── -->
        <main class="main-content">

            <!-- Vendor Header -->
            <section class="vendor-card reveal">
                <div class="vendor-card-inner">
                    <div class="vendor-logo">
                        <svg width="41" height="36" viewBox="0 0 41 36" fill="none">
                            <path d="M38.5031 7.29844L34.4742 0.921094C34.1156 0.351562 33.4758 0 32.7938 0H7.70625C7.02422 0 6.38438 0.351562 6.02578 0.921094L1.98984 7.29844C-0.0914054 10.5891 1.75078 15.1664 5.63906 15.6937C5.92031 15.7289 6.20859 15.75 6.48984 15.75C8.325 15.75 9.95625 14.9484 11.0742 13.7109C12.1922 14.9484 13.8234 15.75 15.6586 15.75C17.4938 15.75 19.125 14.9484 20.243 13.7109C21.3609 14.9484 22.9922 15.75 24.8273 15.75C26.6695 15.75 28.2938 14.9484 29.4117 13.7109C30.5367 14.9484 32.1609 15.75 33.9961 15.75C34.2844 15.75 34.5656 15.7289 34.8469 15.6937C38.7492 15.1734 40.5984 10.5961 38.5102 7.29844H38.5031ZM35.1352 17.9227H35.1281C34.7555 17.9719 34.3758 18 33.9891 18C33.1172 18 32.2805 17.8664 31.5 17.6273V27H9V17.6203C8.2125 17.8664 7.36875 18 6.49688 18C6.11016 18 5.72344 17.9719 5.35078 17.9227H5.34375C5.05547 17.8805 4.77422 17.8313 4.5 17.7609V27V31.5C4.5 33.982 6.51797 36 9 36H31.5C33.982 36 36 33.982 36 31.5V27V17.7609C35.7188 17.8313 35.4375 17.8875 35.1352 17.9227Z" fill="white" />
                        </svg>
                    </div>

                    <div class="vendor-info">
                        <div class="vendor-details">
                            <h1 class="vendor-name">Warung Bu Sari</h1>
                            <div class="vendor-meta">
                                <div class="vendor-rating">
                                    <svg width="18" height="16" viewBox="0 0 18 16" fill="none">
                                        <g clip-path="url(#ri)">
                                            <path d="M9.90312 0.5625C9.7375 0.21875 9.3875 0 9.00313 0C8.61875 0 8.27187 0.21875 8.10312 0.5625L6.09375 4.69688L1.60625 5.35938C1.23125 5.41563 0.91875 5.67812 0.803125 6.0375C0.6875 6.39687 0.78125 6.79375 1.05 7.05937L4.30625 10.2812L3.5375 14.8344C3.475 15.2094 3.63125 15.5906 3.94062 15.8125C4.25 16.0344 4.65937 16.0625 4.99687 15.8844L9.00625 13.7437L13.0156 15.8844C13.3531 16.0625 13.7625 16.0375 14.0719 15.8125C14.3812 15.5875 14.5375 15.2094 14.475 14.8344L13.7031 10.2812L16.9594 7.05937C17.2281 6.79375 17.325 6.39687 17.2062 6.0375C17.0875 5.67812 16.7781 5.41563 16.4031 5.35938L11.9125 4.69688L9.90312 0.5625Z" fill="#EAB308" />
                                        </g>
                                        <defs>
                                            <clipPath id="ri">
                                                <path d="M0 0H18V16H0V0Z" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    <span class="rating-value">4.8</span>
                                    <span class="rating-count">(124 reviews)</span>
                                </div>
                                <div class="vendor-time">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <g clip-path="url(#ti)">
                                            <path d="M8 0C10.1217 0 12.1566 0.842855 13.6569 2.34315C15.1571 3.84344 16 5.87827 16 8C16 10.1217 15.1571 12.1566 13.6569 13.6569C12.1566 15.1571 10.1217 16 8 16C5.87827 16 3.84344 15.1571 2.34315 13.6569C0.842855 12.1566 0 10.1217 0 8C0 5.87827 0.842855 3.84344 2.34315 2.34315C3.84344 0.842855 5.87827 0 8 0ZM7.25 3.75V8C7.25 8.25 7.375 8.48438 7.58437 8.625L10.5844 10.625C10.9281 10.8562 11.3938 10.7625 11.625 10.4156C11.8562 10.0687 11.7625 9.60625 11.4156 9.375L8.75 7.6V3.75C8.75 3.33437 8.41562 3 8 3C7.58437 3 7.25 3.33437 7.25 3.75Z" fill="#42766A" />
                                        </g>
                                        <defs>
                                            <clipPath id="ti">
                                                <path d="M0 0H16V16H0V0Z" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    <span>15-25 min</span>
                                </div>
                            </div>
                            <p class="vendor-description">Authentic Indonesian cuisine with fresh ingredients and traditional recipes passed down through generations.</p>
                        </div>

                        <div class="vendor-actions">
                            <div class="open-badge">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                    <g clip-path="url(#oi)">
                                        <path d="M7 14C8.85652 14 10.637 13.2625 11.9497 11.9497C13.2625 10.637 14 8.85652 14 7C14 5.14348 13.2625 3.36301 11.9497 2.05025C10.637 0.737498 8.85652 0 7 0C5.14348 0 3.36301 0.737498 2.05025 2.05025C0.737498 3.36301 0 5.14348 0 7C0 8.85652 0.737498 10.637 2.05025 11.9497C3.36301 13.2625 5.14348 14 7 14ZM10.0898 5.71484L6.58984 9.21484C6.33281 9.47188 5.91719 9.47188 5.66289 9.21484L3.91289 7.46484C3.65586 7.20781 3.65586 6.79219 3.91289 6.53789C4.16992 6.28359 4.58555 6.28086 4.83984 6.53789L6.125 7.82305L9.16016 4.78516C9.41719 4.52812 9.83281 4.52812 10.0871 4.78516C10.3414 5.04219 10.3441 5.45781 10.0871 5.71211L10.0898 5.71484Z" fill="#15803D" />
                                    </g>
                                    <defs>
                                        <clipPath id="oi">
                                            <path d="M0 0H14V14H0V0Z" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                Open
                            </div>
                            <button class="follow-btn">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M1.4875 9.38742L7.13438 14.6593C7.36875 14.878 7.67812 14.9999 8 14.9999C8.32187 14.9999 8.63125 14.878 8.86563 14.6593L14.5125 9.38742C15.4625 8.50305 16 7.26242 16 5.96555V5.7843C16 3.59992 14.4219 1.73742 12.2688 1.37805C10.8438 1.14055 9.39375 1.60617 8.375 2.62492L8 2.99992L7.625 2.62492C6.60625 1.60617 5.15625 1.14055 3.73125 1.37805C1.57812 1.73742 0 3.59992 0 5.7843V5.96555C0 7.26242 0.5375 8.50305 1.4875 9.38742Z" fill="white" />
                                </svg>
                                Follow
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Category Filter -->
            <nav class="category-filter reveal" aria-label="Menu categories">
                <button class="category-btn category-btn--active">All Items</button>
                <button class="category-btn category-btn--inactive">Rice Dishes</button>
                <button class="category-btn category-btn--inactive">Noodles</button>
                <button class="category-btn category-btn--inactive">Snacks</button>
                <button class="category-btn category-btn--inactive">Beverages</button>
                <button class="category-btn category-btn--inactive">Desserts</button>
            </nav>

            <!-- Menu Grid -->
            <section class="menu-grid" aria-label="Menu items">

                <!-- Card 1: Nasi Gudeg Ayam -->
                <article class="menu-card reveal">
                    <div class="menu-card-image-wrap">
                        <img class="menu-card-image" src="https://api.builder.io/api/v1/image/assets/TEMP/b4868082f44d5fcae80353e16c295d3433235867?width=572" alt="Nasi Gudeg Ayam" />
                        <button class="wishlist-btn" aria-label="Add to wishlist">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M1.4875 9.38742L7.13438 14.6593C7.36875 14.878 7.67812 14.9999 8 14.9999C8.32187 14.9999 8.63125 14.878 8.86563 14.6593L14.5125 9.38742C15.4625 8.50305 16 7.26242 16 5.96555V5.7843C16 3.59992 14.4219 1.73742 12.2688 1.37805C10.8438 1.14055 9.39375 1.60617 8.375 2.62492L8 2.99992L7.625 2.62492C6.60625 1.60617 5.15625 1.14055 3.73125 1.37805C1.57812 1.73742 0 3.59992 0 5.7843V5.96555C0 7.26242 0.5375 8.50305 1.4875 9.38742Z" fill="#9CA3AF" />
                            </svg>
                        </button>
                        <span class="item-badge badge--popular">Popular</span>
                    </div>
                    <div class="menu-card-body">
                        <h3 class="menu-item-name">Nasi Gudeg Ayam</h3>
                        <p class="menu-item-desc">Traditional Javanese sweet jackfruit curry with tender chicken</p>
                        <div class="menu-item-footer">
                            <span class="menu-item-price">Rp 18,000</span>
                            <button class="add-to-cart-btn" aria-label="Add Nasi Gudeg Ayam to cart">
                                <svg width="13" height="14" viewBox="0 0 13 14" fill="none">
                                    <path d="M7 2.1875C7 1.70352 6.60898 1.3125 6.125 1.3125C5.64102 1.3125 5.25 1.70352 5.25 2.1875V6.125H1.3125C0.828516 6.125 0.4375 6.51602 0.4375 7C0.4375 7.48398 0.828516 7.875 1.3125 7.875H5.25V11.8125C5.25 12.2965 5.64102 12.6875 6.125 12.6875C6.60898 12.6875 7 12.2965 7 11.8125V7.875H10.9375C11.4215 7.875 11.8125 7.48398 11.8125 7C11.8125 6.51602 11.4215 6.125 10.9375 6.125H7V2.1875Z" fill="white" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Card 2: Mie Ayam Special -->
                <article class="menu-card reveal">
                    <div class="menu-card-image-wrap">
                        <img class="menu-card-image" src="https://api.builder.io/api/v1/image/assets/TEMP/e8073bad16f9206f6db4ed97a46992857a06c541?width=572" alt="Mie Ayam Special" />
                        <button class="wishlist-btn" aria-label="Add to wishlist">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M1.4875 9.38742L7.13438 14.6593C7.36875 14.878 7.67812 14.9999 8 14.9999C8.32187 14.9999 8.63125 14.878 8.86563 14.6593L14.5125 9.38742C15.4625 8.50305 16 7.26242 16 5.96555V5.7843C16 3.59992 14.4219 1.73742 12.2688 1.37805C10.8438 1.14055 9.39375 1.60617 8.375 2.62492L8 2.99992L7.625 2.62492C6.60625 1.60617 5.15625 1.14055 3.73125 1.37805C1.57812 1.73742 0 3.59992 0 5.7843V5.96555C0 7.26242 0.5375 8.50305 1.4875 9.38742Z" fill="#9CA3AF" />
                            </svg>
                        </button>
                    </div>
                    <div class="menu-card-body">
                        <h3 class="menu-item-name">Mie Ayam Special</h3>
                        <p class="menu-item-desc">Fresh noodles with seasoned chicken, vegetables and savory broth</p>
                        <div class="menu-item-footer">
                            <span class="menu-item-price">Rp 15,000</span>
                            <button class="add-to-cart-btn" aria-label="Add Mie Ayam Special to cart">
                                <svg width="13" height="14" viewBox="0 0 13 14" fill="none">
                                    <path d="M7 2.1875C7 1.70352 6.60898 1.3125 6.125 1.3125C5.64102 1.3125 5.25 1.70352 5.25 2.1875V6.125H1.3125C0.828516 6.125 0.4375 6.51602 0.4375 7C0.4375 7.48398 0.828516 7.875 1.3125 7.875H5.25V11.8125C5.25 12.2965 5.64102 12.6875 6.125 12.6875C6.60898 12.6875 7 12.2965 7 11.8125V7.875H10.9375C11.4215 7.875 11.8125 7.48398 11.8125 7C11.8125 6.51602 11.4215 6.125 10.9375 6.125H7V2.1875Z" fill="white" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Card 3: Gado-Gado -->
                <article class="menu-card reveal">
                    <div class="menu-card-image-wrap">
                        <img class="menu-card-image" src="https://api.builder.io/api/v1/image/assets/TEMP/90cd24b470a76a19da724907cb7eb0904ad6b86c?width=572" alt="Gado-Gado" />
                        <button class="wishlist-btn" aria-label="Add to wishlist">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M1.4875 9.38742L7.13438 14.6593C7.36875 14.878 7.67812 14.9999 8 14.9999C8.32187 14.9999 8.63125 14.878 8.86563 14.6593L14.5125 9.38742C15.4625 8.50305 16 7.26242 16 5.96555V5.7843C16 3.59992 14.4219 1.73742 12.2688 1.37805C10.8438 1.14055 9.39375 1.60617 8.375 2.62492L8 2.99992L7.625 2.62492C6.60625 1.60617 5.15625 1.14055 3.73125 1.37805C1.57812 1.73742 0 3.59992 0 5.7843V5.96555C0 7.26242 0.5375 8.50305 1.4875 9.38742Z" fill="#9CA3AF" />
                            </svg>
                        </button>
                        <span class="item-badge badge--healthy">Healthy</span>
                    </div>
                    <div class="menu-card-body">
                        <h3 class="menu-item-name">Gado-Gado</h3>
                        <p class="menu-item-desc">Fresh mixed vegetables with rich peanut sauce and crackers</p>
                        <div class="menu-item-footer">
                            <span class="menu-item-price">Rp 12,000</span>
                            <button class="add-to-cart-btn" aria-label="Add Gado-Gado to cart">
                                <svg width="13" height="14" viewBox="0 0 13 14" fill="none">
                                    <path d="M7 2.1875C7 1.70352 6.60898 1.3125 6.125 1.3125C5.64102 1.3125 5.25 1.70352 5.25 2.1875V6.125H1.3125C0.828516 6.125 0.4375 6.51602 0.4375 7C0.4375 7.48398 0.828516 7.875 1.3125 7.875H5.25V11.8125C5.25 12.2965 5.64102 12.6875 6.125 12.6875C6.60898 12.6875 7 12.2965 7 11.8125V7.875H10.9375C11.4215 7.875 11.8125 7.48398 11.8125 7C11.8125 6.51602 11.4215 6.125 10.9375 6.125H7V2.1875Z" fill="white" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Card 4: Sate Ayam -->
                <article class="menu-card reveal">
                    <div class="menu-card-image-wrap">
                        <img class="menu-card-image" src="https://api.builder.io/api/v1/image/assets/TEMP/a9bee7f0eaa15b4f21efae9546c2163920d61992?width=572" alt="Sate Ayam" />
                        <button class="wishlist-btn" aria-label="Remove from wishlist">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M1.4875 9.38742L7.13438 14.6593C7.36875 14.878 7.67812 14.9999 8 14.9999C8.32187 14.9999 8.63125 14.878 8.86563 14.6593L14.5125 9.38742C15.4625 8.50305 16 7.26242 16 5.96555V5.7843C16 3.59992 14.4219 1.73742 12.2688 1.37805C10.8438 1.14055 9.39375 1.60617 8.375 2.62492L8 2.99992L7.625 2.62492C6.60625 1.60617 5.15625 1.14055 3.73125 1.37805C1.57812 1.73742 0 3.59992 0 5.7843V5.96555C0 7.26242 0.5375 8.50305 1.4875 9.38742Z" fill="#EF4444" />
                            </svg>
                        </button>
                    </div>
                    <div class="menu-card-body">
                        <h3 class="menu-item-name">Sate Ayam</h3>
                        <p class="menu-item-desc">Grilled chicken skewers with spicy peanut sauce and rice cakes</p>
                        <div class="menu-item-footer">
                            <span class="menu-item-price">Rp 20,000</span>
                            <button class="add-to-cart-btn" aria-label="Add Sate Ayam to cart">
                                <svg width="13" height="14" viewBox="0 0 13 14" fill="none">
                                    <path d="M7 2.1875C7 1.70352 6.60898 1.3125 6.125 1.3125C5.64102 1.3125 5.25 1.70352 5.25 2.1875V6.125H1.3125C0.828516 6.125 0.4375 6.51602 0.4375 7C0.4375 7.48398 0.828516 7.875 1.3125 7.875H5.25V11.8125C5.25 12.2965 5.64102 12.6875 6.125 12.6875C6.60898 12.6875 7 12.2965 7 11.8125V7.875H10.9375C11.4215 7.875 11.8125 7.48398 11.8125 7C11.8125 6.51602 11.4215 6.125 10.9375 6.125H7V2.1875Z" fill="white" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Card 5: Es Teh Manis -->
                <article class="menu-card reveal">
                    <div class="menu-card-image-wrap">
                        <img class="menu-card-image" src="https://api.builder.io/api/v1/image/assets/TEMP/f54094bf7f4c4ebb7a73256c88f3d3e0bb240384?width=572" alt="Es Teh Manis" />
                        <button class="wishlist-btn" aria-label="Add to wishlist">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M1.4875 9.38767L7.13438 14.6595C7.36875 14.8783 7.67812 15.0002 8 15.0002C8.32187 15.0002 8.63125 14.8783 8.86563 14.6595L14.5125 9.38767C15.4625 8.50329 16 7.26267 16 5.96579V5.78454C16 3.60017 14.4219 1.73767 12.2688 1.37829C10.8438 1.14079 9.39375 1.60642 8.375 2.62517L8 3.00017L7.625 2.62517C6.60625 1.60642 5.15625 1.14079 3.73125 1.37829C1.57812 1.73767 0 3.60017 0 5.78454V5.96579C0 7.26267 0.5375 8.50329 1.4875 9.38767Z" fill="#9CA3AF" />
                            </svg>
                        </button>
                    </div>
                    <div class="menu-card-body">
                        <h3 class="menu-item-name">Es Teh Manis</h3>
                        <p class="menu-item-desc">Refreshing sweet iced tea, perfect companion for any meal</p>
                        <div class="menu-item-footer">
                            <span class="menu-item-price">Rp 5,000</span>
                            <button class="add-to-cart-btn" aria-label="Add Es Teh Manis to cart">
                                <svg width="13" height="14" viewBox="0 0 13 14" fill="none">
                                    <path d="M7 2.1875C7 1.70352 6.60898 1.3125 6.125 1.3125C5.64102 1.3125 5.25 1.70352 5.25 2.1875V6.125H1.3125C0.828516 6.125 0.4375 6.51602 0.4375 7C0.4375 7.48398 0.828516 7.875 1.3125 7.875H5.25V11.8125C5.25 12.2965 5.64102 12.6875 6.125 12.6875C6.60898 12.6875 7 12.2965 7 11.8125V7.875H10.9375C11.4215 7.875 11.8125 7.48398 11.8125 7C11.8125 6.51602 11.4215 6.125 10.9375 6.125H7V2.1875Z" fill="white" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Card 6: Bakso Special -->
                <article class="menu-card reveal">
                    <div class="menu-card-image-wrap">
                        <img class="menu-card-image" src="https://api.builder.io/api/v1/image/assets/TEMP/a4ff2add3eaa657d5f34fabe120343b77624de46?width=572" alt="Bakso Special" />
                        <button class="wishlist-btn" aria-label="Add to wishlist">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M1.4875 9.38767L7.13438 14.6595C7.36875 14.8783 7.67812 15.0002 8 15.0002C8.32187 15.0002 8.63125 14.8783 8.86563 14.6595L14.5125 9.38767C15.4625 8.50329 16 7.26267 16 5.96579V5.78454C16 3.60017 14.4219 1.73767 12.2688 1.37829C10.8438 1.14079 9.39375 1.60642 8.375 2.62517L8 3.00017L7.625 2.62517C6.60625 1.60642 5.15625 1.14079 3.73125 1.37829C1.57812 1.73767 0 3.60017 0 5.78454V5.96579C0 7.26267 0.5375 8.50329 1.4875 9.38767Z" fill="#9CA3AF" />
                            </svg>
                        </button>
                        <span class="item-badge badge--hot">Hot</span>
                    </div>
                    <div class="menu-card-body">
                        <h3 class="menu-item-name">Bakso Special</h3>
                        <p class="menu-item-desc">Hearty meatball soup with noodles and fresh vegetables</p>
                        <div class="menu-item-footer">
                            <span class="menu-item-price">Rp 16,000</span>
                            <button class="add-to-cart-btn" aria-label="Add Bakso Special to cart">
                                <svg width="13" height="14" viewBox="0 0 13 14" fill="none">
                                    <path d="M7 2.1875C7 1.70352 6.60898 1.3125 6.125 1.3125C5.64102 1.3125 5.25 1.70352 5.25 2.1875V6.125H1.3125C0.828516 6.125 0.4375 6.51602 0.4375 7C0.4375 7.48398 0.828516 7.875 1.3125 7.875H5.25V11.8125C5.25 12.2965 5.64102 12.6875 6.125 12.6875C6.60898 12.6875 7 12.2965 7 11.8125V7.875H10.9375C11.4215 7.875 11.8125 7.48398 11.8125 7C11.8125 6.51602 11.4215 6.125 10.9375 6.125H7V2.1875Z" fill="white" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Card 7: Pisang Goreng -->
                <article class="menu-card reveal">
                    <div class="menu-card-image-wrap">
                        <img class="menu-card-image" src="https://api.builder.io/api/v1/image/assets/TEMP/652fb0b468b9036c588a47020389155a651a3a58?width=572" alt="Pisang Goreng" />
                        <button class="wishlist-btn" aria-label="Add to wishlist">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M1.4875 9.38767L7.13438 14.6595C7.36875 14.8783 7.67812 15.0002 8 15.0002C8.32187 15.0002 8.63125 14.8783 8.86563 14.6595L14.5125 9.38767C15.4625 8.50329 16 7.26267 16 5.96579V5.78454C16 3.60017 14.4219 1.73767 12.2688 1.37829C10.8438 1.14079 9.39375 1.60642 8.375 2.62517L8 3.00017L7.625 2.62517C6.60625 1.60642 5.15625 1.14079 3.73125 1.37829C1.57812 1.73767 0 3.60017 0 5.78454V5.96579C0 7.26267 0.5375 8.50329 1.4875 9.38767Z" fill="#9CA3AF" />
                            </svg>
                        </button>
                    </div>
                    <div class="menu-card-body">
                        <h3 class="menu-item-name">Pisang Goreng</h3>
                        <p class="menu-item-desc">Crispy fried banana fritters, perfect sweet snack</p>
                        <div class="menu-item-footer">
                            <span class="menu-item-price">Rp 8,000</span>
                            <button class="add-to-cart-btn" aria-label="Add Pisang Goreng to cart">
                                <svg width="13" height="14" viewBox="0 0 13 14" fill="none">
                                    <path d="M7 2.1875C7 1.70352 6.60898 1.3125 6.125 1.3125C5.64102 1.3125 5.25 1.70352 5.25 2.1875V6.125H1.3125C0.828516 6.125 0.4375 6.51602 0.4375 7C0.4375 7.48398 0.828516 7.875 1.3125 7.875H5.25V11.8125C5.25 12.2965 5.64102 12.6875 6.125 12.6875C6.60898 12.6875 7 12.2965 7 11.8125V7.875H10.9375C11.4215 7.875 11.8125 7.48398 11.8125 7C11.8125 6.51602 11.4215 6.125 10.9375 6.125H7V2.1875Z" fill="white" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Card 8: Es Jeruk Segar -->
                <article class="menu-card reveal">
                    <div class="menu-card-image-wrap">
                        <img class="menu-card-image" src="https://api.builder.io/api/v1/image/assets/TEMP/a4ff2add3eaa657d5f34fabe120343b77624de46?width=572" alt="Es Jeruk Segar" />
                        <button class="wishlist-btn" aria-label="Add to wishlist">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M1.4875 9.38767L7.13438 14.6595C7.36875 14.8783 7.67812 15.0002 8 15.0002C8.32187 15.0002 8.63125 14.8783 8.86563 14.6595L14.5125 9.38767C15.4625 8.50329 16 7.26267 16 5.96579V5.78454C16 3.60017 14.4219 1.73767 12.2688 1.37829C10.8438 1.14079 9.39375 1.60642 8.375 2.62517L8 3.00017L7.625 2.62517C6.60625 1.60642 5.15625 1.14079 3.73125 1.37829C1.57812 1.73767 0 3.60017 0 5.78454V5.96579C0 7.26267 0.5375 8.50329 1.4875 9.38767Z" fill="#9CA3AF" />
                            </svg>
                        </button>
                        <span class="item-badge badge--fresh">Fresh</span>
                    </div>
                    <div class="menu-card-body">
                        <h3 class="menu-item-name">Es Jeruk Segar</h3>
                        <p class="menu-item-desc">Fresh squeezed orange juice with ice, vitamin-rich and refreshing</p>
                        <div class="menu-item-footer">
                            <span class="menu-item-price">Rp 8,000</span>
                            <button class="add-to-cart-btn" aria-label="Add Es Jeruk Segar to cart">
                                <svg width="13" height="14" viewBox="0 0 13 14" fill="none">
                                    <path d="M7 2.1875C7 1.70352 6.60898 1.3125 6.125 1.3125C5.64102 1.3125 5.25 1.70352 5.25 2.1875V6.125H1.3125C0.828516 6.125 0.4375 6.51602 0.4375 7C0.4375 7.48398 0.828516 7.875 1.3125 7.875H5.25V11.8125C5.25 12.2965 5.64102 12.6875 6.125 12.6875C6.60898 12.6875 7 12.2965 7 11.8125V7.875H10.9375C11.4215 7.875 11.8125 7.48398 11.8125 7C11.8125 6.51602 11.4215 6.125 10.9375 6.125H7V2.1875Z" fill="white" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </article>

            </section>

            <!-- Load More -->
            <div class="load-more-wrapper reveal">
                <button class="load-more-btn">Load More Items</button>
            </div>

        </main>

        <!-- Floating Cart -->
        <div class="floating-cart">
            <a class="floating-cart-btn" aria-label="Open cart" href="{{ route('checkout') }}">
                <svg width="23" height="20" viewBox="0 0 23 20" fill="none">
                    <g clip-path="url(#fci)">
                        <path d="M0 0.9375C0 0.417969 0.417969 0 0.9375 0H2.71484C3.57422 0 4.33594 0.5 4.69141 1.25H20.7461C21.7734 1.25 22.5234 2.22656 22.2539 3.21875L20.6523 9.16797C20.3203 10.3945 19.207 11.25 17.9375 11.25H6.66797L6.87891 12.3633C6.96484 12.8047 7.35156 13.125 7.80078 13.125H19.0625C19.582 13.125 20 13.543 20 14.0625C20 14.582 19.582 15 19.0625 15H7.80078C6.44922 15 5.28906 14.0391 5.03906 12.7148L3.02344 2.12891C2.99609 1.98047 2.86719 1.875 2.71484 1.875H0.9375C0.417969 1.875 0 1.45703 0 0.9375ZM5 18.125C5 17.0859 5.85547 16.25 6.875 16.25C7.89453 16.25 8.75 17.0859 8.75 18.125C8.75 19.1445 7.89453 20 6.875 20C5.85547 20 5 19.1445 5 18.125ZM18.125 16.25C19.1641 16.25 20 17.0859 20 18.125C20 19.1445 19.1641 20 18.125 20C17.1055 20 16.25 19.1445 16.25 18.125C16.25 17.0859 17.1055 16.25 18.125 16.25Z" fill="white" />
                    </g>
                    <defs>
                        <clipPath id="fci">
                            <path d="M0 0H22.5V20H0V0Z" fill="white" />
                        </clipPath>
                    </defs>
                </svg>
                <span class="floating-cart-badge">3</span>
            </a>
        </div>

    </div>

    <script>
        // ── Scroll-reveal ──────────────────────────────────────────
        (function() {
            const items = document.querySelectorAll('.reveal');

            const io = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry, i) => {
                        if (entry.isIntersecting) {
                            // Stagger cards in menu grid
                            const delay = entry.target.closest('.menu-grid') ?
                                Array.from(entry.target.parentElement.children).indexOf(entry.target) * 60 :
                                0;
                            setTimeout(() => entry.target.classList.add('visible'), delay);
                            io.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.1
                }
            );

            items.forEach(el => io.observe(el));
        })();

        // ── Category filter toggle ─────────────────────────────────
        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.category-btn').forEach(b => {
                    b.classList.remove('category-btn--active');
                    b.classList.add('category-btn--inactive');
                });
                btn.classList.remove('category-btn--inactive');
                btn.classList.add('category-btn--active');
            });
        });

        // ── Wishlist toggle ────────────────────────────────────────
        document.querySelectorAll('.wishlist-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const svg = btn.querySelector('path');
                const isLiked = svg.getAttribute('fill') === '#EF4444';
                svg.setAttribute('fill', isLiked ? '#9CA3AF' : '#EF4444');
            });
        });

        // ── Add-to-cart micro-animation ────────────────────────────
        document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                // Bounce the floating cart badge
                const badge = document.querySelector('.floating-cart-badge');
                badge.style.transform = 'scale(1.4)';
                setTimeout(() => {
                    badge.style.transform = 'scale(1)';
                    badge.style.transition = 'transform .2s';
                }, 150);
            });
        });
    </script>
</body>

</html>