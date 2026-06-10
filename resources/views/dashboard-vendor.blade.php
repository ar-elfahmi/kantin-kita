<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Vendor | Kantin Kita</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* ─── CSS Variables ─────────────────────────────────── */
        :root {
            --cream: #FBF5E8;
            --brown: #744622;
            --brown-60: rgba(116, 70, 34, .6);
            --brown-70: rgba(116, 70, 34, .7);
            --brown-10: rgba(116, 70, 34, .1);
            --green: #42766A;
            --green-10: rgba(66, 118, 106, .1);
            --green-20: rgba(66, 118, 106, .2);
            --white: #ffffff;
            --shadow-sm: 0 1px 3px rgba(116, 70, 34, .08), 0 1px 2px rgba(116, 70, 34, .06);
            --shadow-md: 0 4px 16px rgba(116, 70, 34, .10), 0 2px 6px rgba(116, 70, 34, .06);
            --shadow-lg: 0 10px 40px rgba(116, 70, 34, .14), 0 4px 12px rgba(116, 70, 34, .08);
            --shadow-glow: 0 0 0 3px rgba(66, 118, 106, .18);
            --radius-sm: 12px;
            --radius-md: 16px;
            --radius-lg: 20px;
            --radius-pill: 9999px;
            --transition: .25s cubic-bezier(.4, 0, .2, 1);
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
            font-family: 'Poppins', sans-serif;
            background: var(--cream);
            color: var(--brown);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ─── Layout Shell ──────────────────────────────────── */
        .dashboard-shell {
            display: flex;
            min-height: 100vh;
        }



        /* ─── Main Content ───────────────────────────────────── */
        .main-content {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
        }

        /* ─── Header ────────────────────────────────────────── */
        .page-header {
            background: var(--white);
            border-bottom: 1px solid var(--brown-10);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: blur(8px);
            box-shadow: 0 1px 0 var(--brown-10);
        }

        .header-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -.5px;
        }

        .header-subtitle {
            font-size: 14px;
            font-weight: 400;
            color: var(--brown-60);
            letter-spacing: -.5px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
            position: relative;
        }

        .notif-btn {
            position: relative;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius-sm);
            background: transparent;
            border: none;
            cursor: pointer;
            transition: background var(--transition);
        }

        .notif-btn:hover {
            background: var(--cream);
        }

        .notif-dot {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            background: var(--green);
            border-radius: var(--radius-pill);
            border: 2px solid var(--white);
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.3);
                opacity: .7;
            }
        }

        .header-user-chip {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 16px;
            background: var(--cream);
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: background var(--transition), box-shadow var(--transition);
            border: 1px solid var(--brown-10);
        }

        .header-user-chip:hover {
            background: #f5ead6;
            box-shadow: var(--shadow-sm);
        }

        .header-avatar {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-pill);
            object-fit: cover;
        }

        .avatar-initial {
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--brown-10);
            color: var(--brown);
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
        }

        .header-username {
            font-size: 14px;
            font-weight: 600;
            color: var(--brown);
            letter-spacing: -.5px;
        }

        /* ─── User Dropdown ───────────────────────────────────── */
        .user-dropdown {
            position: absolute;
            top: calc(100% + 6px);
            right: 0;
            background: var(--white);
            border-radius: var(--radius-md);
            border: 1px solid var(--brown-10);
            box-shadow: var(--shadow-lg);
            min-width: 220px;
            z-index: 1000;
            overflow: hidden;
        }

        .user-dropdown-header {
            padding: 14px 16px;
        }

        .user-dropdown-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--brown);
            letter-spacing: -.5px;
        }

        .user-dropdown-email {
            font-size: 12px;
            font-weight: 400;
            color: var(--brown-60);
            letter-spacing: -.5px;
            margin-top: 2px;
        }

        .user-dropdown-divider {
            height: 1px;
            background: var(--brown-10);
        }

        .user-dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            font-size: 13px;
            font-weight: 500;
            color: var(--brown);
            cursor: pointer;
            transition: background var(--transition);
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            font-family: inherit;
            text-decoration: none;
        }

        .user-dropdown-item:hover {
            background: var(--cream);
        }

        .user-dropdown-logout {
            color: #B91C1C;
        }

        /* ─── Dashboard Body ─────────────────────────────────── */
        .dashboard-body {
            padding: 32px;
            display: flex;
            flex-direction: column;
            gap: 32px;
            animation: fade-in-up .5s ease both;
        }

        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ─── Stats Grid ─────────────────────────────────────── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        .stat-card {
            background: var(--white);
            border-radius: var(--radius-md);
            border: 1px solid var(--brown-10);
            padding: 25px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            box-shadow: var(--shadow-sm);
            transition: transform var(--transition), box-shadow var(--transition);
            position: relative;
            overflow: hidden;
            animation: fade-in-up .5s ease both;
        }

        .stat-card:nth-child(1) {
            animation-delay: .05s;
        }

        .stat-card:nth-child(2) {
            animation-delay: .1s;
        }

        .stat-card:nth-child(3) {
            animation-delay: .15s;
        }

        .stat-card:nth-child(4) {
            animation-delay: .2s;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: -10px;
            right: -10px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--green);
            opacity: 0;
            transition: opacity var(--transition), transform var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card:hover::before {
            opacity: .08;
            transform: scale(1);
        }

        .stat-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-icon.green-bg {
            background: var(--green-10);
        }

        .stat-icon.brown-bg {
            background: var(--brown-10);
        }

        .stat-icon.yellow-bg {
            background: #FEF3C7;
        }

        .stat-icon.blue-bg {
            background: #DBEAFE;
        }

        .stat-badge {
            padding: 4px 12px;
            border-radius: var(--radius-pill);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: -.5px;
        }

        .badge-green {
            background: var(--green-10);
            color: var(--green);
        }

        .badge-brown {
            background: var(--brown-10);
            color: var(--brown);
        }

        .badge-yellow {
            background: #FEF3C7;
            color: #D97706;
        }

        .badge-blue {
            background: #DBEAFE;
            color: #2563EB;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -.5px;
            line-height: 1.33;
        }

        .stat-label {
            font-size: 14px;
            font-weight: 500;
            color: var(--brown-60);
            letter-spacing: -.5px;
        }

        /* ─── Section Header ─────────────────────────────────── */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -.5px;
        }

        .section-subtitle {
            font-size: 14px;
            font-weight: 400;
            color: var(--brown-60);
            letter-spacing: -.5px;
            margin-top: 4px;
        }

        /* CTA Button */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: var(--green);
            color: var(--white);
            border-radius: var(--radius-md);
            font-size: 16px;
            font-weight: 600;
            letter-spacing: -.5px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .05), 0 4px 12px rgba(66, 118, 106, .3);
            transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
            white-space: nowrap;
        }

        .btn-primary:hover {
            background: #355f55;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(66, 118, 106, .45);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* ─── Product Cards ───────────────────────────────────── */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        .product-card {
            background: var(--white);
            border-radius: var(--radius-md);
            border: 1px solid var(--brown-10);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: var(--shadow-sm);
            transition: transform var(--transition), box-shadow var(--transition);
            animation: fade-in-up .5s ease both;
        }

        .product-card:nth-child(1) {
            animation-delay: .1s;
        }

        .product-card:nth-child(2) {
            animation-delay: .18s;
        }

        .product-card:nth-child(3) {
            animation-delay: .26s;
        }

        .product-card:nth-child(4) {
            animation-delay: .34s;
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-lg);
        }

        .product-image-wrap {
            position: relative;
            width: 100%;
            height: 192px;
            overflow: hidden;
        }

        .product-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .5s cubic-bezier(.4, 0, .2, 1);
        }

        .product-card:hover .product-img {
            transform: scale(1.08);
        }

        .product-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            padding: 4px 12px;
            border-radius: var(--radius-pill);
            font-size: 12px;
            font-weight: 600;
            color: var(--white);
            letter-spacing: -.5px;
            backdrop-filter: blur(4px);
        }

        .product-badge.green-badge {
            background: var(--green);
        }

        .product-badge.brown-badge {
            background: var(--brown);
        }

        .product-info {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            flex: 1;
        }

        .product-name {
            font-size: 18px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -.5px;
            line-height: 1.4;
        }

        .product-desc {
            font-size: 14px;
            font-weight: 400;
            color: var(--brown-60);
            letter-spacing: -.5px;
            line-height: 1.43;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            line-clamp: 2;
            overflow: hidden;
        }

        .product-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .product-price {
            font-size: 20px;
            font-weight: 700;
            color: var(--green);
            letter-spacing: -.5px;
        }

        .product-rating {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .rating-value {
            font-size: 14px;
            font-weight: 600;
            color: var(--brown);
            letter-spacing: -.5px;
        }

        .product-actions {
            display: flex;
            gap: 8px;
        }

        .btn-edit {
            flex: 1;
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            background: var(--green-10);
            color: var(--green);
            font-size: 14px;
            font-weight: 600;
            letter-spacing: -.5px;
            border: none;
            cursor: pointer;
            transition: background var(--transition), transform var(--transition);
        }

        .btn-edit:hover {
            background: var(--green-20);
            transform: translateY(-1px);
        }

        .btn-cetak {
            flex: 1;
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            background: var(--brown-10);
            color: var(--brown);
            font-size: 14px;
            font-weight: 600;
            letter-spacing: -.5px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: background var(--transition), transform var(--transition);
        }

        .btn-cetak:hover {
            background: var(--brown-20);
            transform: translateY(-1px);
        }
        /* ─── Bottom Grid ────────────────────────────────────── */
        .bottom-grid {
            display: grid;
            grid-template-columns: 1fr 347px;
            gap: 24px;
        }

        /* ─── Recent Orders ──────────────────────────────────── */
        .orders-panel {
            background: var(--white);
            border-radius: var(--radius-md);
            border: 1px solid var(--brown-10);
            padding: 25px;
            box-shadow: var(--shadow-sm);
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .orders-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .link-see-all {
            font-size: 14px;
            font-weight: 600;
            color: var(--green);
            text-decoration: none;
            letter-spacing: -.5px;
            position: relative;
            transition: color var(--transition);
        }

        .link-see-all::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--green);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform var(--transition);
        }

        .link-see-all:hover::after {
            transform: scaleX(1);
        }

        .orders-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .order-row {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px;
            border-radius: var(--radius-md);
            background: var(--cream);
            transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
            cursor: default;
        }

        .order-row:hover {
            background: #f5ead6;
            transform: translateX(3px);
            box-shadow: var(--shadow-sm);
        }

        .order-thumb {
            width: 64px;
            height: 64px;
            border-radius: var(--radius-sm);
            object-fit: cover;
            flex-shrink: 0;
            box-shadow: var(--shadow-sm);
        }

        .order-info {
            flex: 1;
            min-width: 0;
        }

        .order-name {
            font-size: 16px;
            font-weight: 600;
            color: var(--brown);
            letter-spacing: -.5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .order-qty {
            font-size: 14px;
            font-weight: 400;
            color: var(--brown-60);
            letter-spacing: -.5px;
            margin-top: 4px;
        }

        .order-right {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
            flex-shrink: 0;
        }

        .order-time {
            font-size: 12px;
            font-weight: 400;
            color: var(--brown-60);
            letter-spacing: -.5px;
        }

        .order-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            justify-content: flex-end;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: var(--radius-pill);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: -.5px;
        }

        .status-pending {
            background: #FEF3C7;
            color: #D97706;
        }

        .status-process {
            background: #DBEAFE;
            color: #2563EB;
        }

        .status-done {
            background: rgba(66, 118, 106, .12);
            color: var(--green);
        }

        .order-done-form {
            display: inline-flex;
        }

        .btn-mark-done {
            padding: 6px 12px;
            border-radius: var(--radius-pill);
            border: none;
            background: var(--green);
            color: var(--white);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: -.4px;
            transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
        }

        .btn-mark-done:hover {
            background: #355f55;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(66, 118, 106, .32);
        }

        .dashboard-alert {
            border-radius: var(--radius-md);
            padding: 12px 14px;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: -.4px;
        }

        .dashboard-alert-success {
            background: rgba(66, 118, 106, .12);
            color: var(--green);
            border: 1px solid rgba(66, 118, 106, .22);
        }

        .dashboard-alert-error {
            background: rgba(220, 38, 38, .10);
            color: #B91C1C;
            border: 1px solid rgba(220, 38, 38, .22);
        }

        /* ─── Sales Summary ───────────────────────────────────── */
        .summary-panel {
            background: var(--white);
            border-radius: var(--radius-md);
            border: 1px solid var(--brown-10);
            padding: 25px;
            box-shadow: var(--shadow-sm);
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .summary-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -.5px;
            margin-bottom: 20px;
        }

        .summary-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 0;
            border-bottom: 1px solid var(--brown-10);
            transition: background var(--transition);
        }

        .summary-row:last-of-type {
            border-bottom: none;
        }

        .summary-row-label {
            font-size: 14px;
            font-weight: 500;
            color: var(--brown-60);
            letter-spacing: -.5px;
        }

        .summary-row-value {
            font-size: 14px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -.5px;
        }

        .summary-progress-block {
            margin-top: 20px;
            background: var(--cream);
            border-radius: var(--radius-md);
            padding: 20px;
            text-align: center;
        }

        .progress-pct {
            font-size: 32px;
            font-weight: 800;
            color: var(--green);
            letter-spacing: -1px;
        }

        .progress-label {
            font-size: 13px;
            font-weight: 500;
            color: var(--brown-60);
            letter-spacing: -.5px;
            margin-top: 4px;
        }

        .progress-bar-outer {
            width: 100%;
            height: 8px;
            background: var(--brown-10);
            border-radius: var(--radius-pill);
            margin-top: 12px;
            overflow: hidden;
        }

        .progress-bar-inner {
            height: 100%;
            background: linear-gradient(90deg, var(--green), #5aaa9a);
            border-radius: var(--radius-pill);
            width: 0;
            transition: width 1.2s cubic-bezier(.4, 0, .2, 1);
        }

        /* ─── Scroll Fade-in Observer ────────────────────────── */
        .reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity .6s ease, transform .6s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ─── Responsive ─────────────────────────────────────── */
        @media (max-width: 1280px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .products-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .bottom-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 900px) {
            .stats-grid,
            .products-grid {
                grid-template-columns: 1fr 1fr;
            }

            .dashboard-body {
                padding: 20px;
            }

            .page-header {
                padding: 16px 20px;
            }
        }

        @media (max-width: 640px) {
            .dashboard-body {
                padding: 16px;
                gap: 20px;
            }

            .page-header {
                padding: 12px 16px;
            }

            .header-title {
                font-size: 20px;
            }

            .header-user-chip {
                padding: 6px 10px;
            }

            .header-username {
                display: none;
            }

            /* Stats as order-list on mobile */
            .stats-grid {
                display: flex;
                flex-direction: column;
                gap: 0;
                background: var(--white);
                border-radius: var(--radius-md);
                border: 1px solid var(--brown-10);
                box-shadow: var(--shadow-sm);
                overflow: hidden;
            }

            .stat-card {
                border-radius: 0;
                border: none;
                border-bottom: 1px solid var(--brown-10);
                box-shadow: none;
                padding: 14px 16px;
                gap: 0;
                flex-direction: row;
                align-items: center;
                animation: none;
            }

            .stat-card:last-child {
                border-bottom: none;
            }

            .stat-card::before {
                display: none;
            }

            .stat-card:hover {
                transform: none;
                box-shadow: none;
                background: #f5ead6;
            }

            .stat-card-top {
                flex-direction: row;
                align-items: center;
                gap: 12px;
                flex: 1;
            }

            .stat-icon {
                width: 40px;
                height: 40px;
                flex-shrink: 0;
                border-radius: var(--radius-sm);
            }

            .stat-value {
                font-size: 18px;
                line-height: 1.2;
                margin-left: auto;
                order: 3;
                white-space: nowrap;
            }

            .stat-label {
                font-size: 13px;
                flex: 1;
                order: 2;
            }

            .stat-badge {
                order: 4;
                margin-left: 8px;
            }

            .products-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
            }

            .orders-panel,
            .summary-panel {
                padding: 18px;
            }

            .orders-list {
                counter-reset: order-item;
            }

            .order-row {
                position: relative;
                padding: 12px 12px 12px 44px;
                align-items: flex-start;
                flex-direction: column;
                gap: 10px;
            }

            .order-row::before {
                counter-increment: order-item;
                content: counter(order-item) ".";
                position: absolute;
                left: 14px;
                top: 12px;
                font-size: 13px;
                font-weight: 700;
                color: var(--green);
            }

            .order-info {
                width: 100%;
            }

            .order-name {
                white-space: normal;
                overflow: visible;
                text-overflow: unset;
                line-height: 1.35;
            }

            .order-right {
                align-items: flex-start;
                width: 100%;
            }

            .order-actions {
                width: 100%;
                justify-content: flex-start;
                flex-wrap: wrap;
                gap: 8px;
            }

            .order-done-form,
            .btn-mark-done {
                width: auto;
                justify-content: flex-start;
                max-width: 100%;
            }

            .btn-mark-done {
                white-space: nowrap;
                padding: 7px 12px;
            }

            .stat-card,
            .product-card {
                animation: none;
            }
        }

    </style>
</head>

<body data-progress-percent="{{ $progressPersen }}">

    <div class="dashboard-shell">

        <!-- ═══════════════ SIDEBAR ═══════════════ -->
        @include('vendor._sidebar', ['vendor' => $vendor])

        <!-- ═══════════════ MAIN ═══════════════════ -->
        <div class="main-content">

            <!-- Header -->
            <header class="page-header">
                <div>
                    <div class="header-title">Dashboard Vendor</div>
                    <div class="header-subtitle">Kelola menu dan pesanan Anda</div>
                </div>
                <div class="header-right">
                    <button class="notif-btn" aria-label="Notifikasi">
                        <span class="notif-dot"></span>
                        <svg width="18" height="20" viewBox="0 0 18 20" fill="none">
                            <path d="M8.74998 0C8.05858 0 7.49998 0.558594 7.49998 1.25V2C4.64842 2.57812 2.49998 5.10156 2.49998 8.125V8.85938C2.49998 10.6953 1.8242 12.4688 0.605453 13.8438L0.316391 14.168C-0.011734 14.5352-0.0898591 15.0625 0.10936 15.5117C0.308578 15.9609 0.757797 16.25 1.24998 16.25H16.25C16.7422 16.25 17.1875 15.9609 17.3906 15.5117C17.5937 15.0625 17.5117 14.5352 17.1836 14.168L16.8945 13.8438C15.6758 12.4688 15 10.6992 15 8.85938V8.125C15 5.10156 12.8515 2.57812 9.99998 2V1.25C9.99998 0.558594 9.44139 0 8.74998 0ZM10.5195 19.2695C10.9883 18.8008 11.25 18.1641 11.25 17.5H6.24998C6.24998 18.1641 6.5117 18.8008 6.98045 19.2695C7.4492 19.7383 8.08592 20 8.74998 20C9.41405 20 10.0508 19.7383 10.5195 19.2695Z" fill="rgba(116,70,34,0.6)" />
                        </svg>
                    </button>
                    <div class="header-user-chip" id="headerUserChip">
                        <div class="header-avatar avatar-initial">{{ strtoupper(substr($vendor->nama_vendor, 0, 1)) }}</div>
                        <span class="header-username">{{ $vendor->nama_vendor }}</span>
                    </div>
                    <div class="user-dropdown" id="userDropdown" style="display:none;">
                        <div class="user-dropdown-header">
                            <div class="user-dropdown-name">{{ $vendor->nama_vendor }}</div>
                            <div class="user-dropdown-email">{{ auth()->user()?->email ?? 'vendor@kantinkita.id' }}</div>
                        </div>
                        <div class="user-dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="user-dropdown-item user-dropdown-logout">
                                <svg width="14" height="14" viewBox="0 0 16 16" fill="none">
                                    <path d="M11.8094 3.30938L15.6469 7.14687C15.8719 7.37187 16 7.68125 16 8C16 8.31875 15.8719 8.62812 15.6469 8.85312L11.8094 12.6906C11.6094 12.8906 11.3406 13 11.0594 13C10.475 13 10 12.525 10 11.9406V10H6C5.44688 10 5 9.55313 5 9V7C5 6.44688 5.44688 6 6 6H10V4.05937C10 3.475 10.475 3 11.0594 3C11.3406 3 11.6094 3.1125 11.8094 3.30938ZM5 3H3C2.44688 3 2 3.44688 2 4V12C2 12.5531 2.44688 13 3 13H5C5.55312 13 6 13.4469 6 14C6 14.5531 5.55312 15 5 15H3C1.34375 15 0 13.6562 0 12V4C0 2.34375 1.34375 1 3 1H5C5.55312 1 6 1.44687 6 2C6 2.55313 5.55312 3 5 3Z" fill="currentColor" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="dashboard-body">

                @if (session('orderSuccess'))
                <div class="dashboard-alert dashboard-alert-success">{{ session('orderSuccess') }}</div>
                @endif
                @if (session('orderError'))
                <div class="dashboard-alert dashboard-alert-error">{{ session('orderError') }}</div>
                @endif

                <!-- ── Stats ── -->
                <section class="stats-grid">

                    <!-- Pendapatan -->
                    <div class="stat-card">
                        <div class="stat-card-top">
                            <div class="stat-icon green-bg">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M2.5 2.5C2.5 1.80859 1.94141 1.25 1.25 1.25C0.558594 1.25 0 1.80859 0 2.5V15.625C0 17.3516 1.39844 18.75 3.125 18.75H18.75C19.4414 18.75 20 18.1914 20 17.5C20 16.8086 19.4414 16.25 18.75 16.25H3.125C2.78125 16.25 2.5 15.9688 2.5 15.625V2.5ZM18.3828 5.88281C18.8711 5.39453 18.8711 4.60156 18.3828 4.11328C17.8945 3.625 17.1016 3.625 16.6133 4.11328L12.5 8.23047L10.2578 5.98828C9.76953 5.5 8.97656 5.5 8.48828 5.98828L4.11328 10.3633C3.625 10.8516 3.625 11.6445 4.11328 12.1328C4.60156 12.6211 5.39453 12.6211 5.88281 12.1328L9.375 8.64453L11.6172 10.8867C12.1055 11.375 12.8984 11.375 13.3867 10.8867L18.3867 5.88672L18.3828 5.88281Z" fill="#42766A" />
                                </svg>
                            </div>
                            <span class="stat-badge badge-green">+12%</span>
                        </div>
                        <div class="stat-value">Rp {{ number_format((int) $totalHariIni, 0, ',', '.') }}</div>
                        <div class="stat-label">Pendapatan Hari Ini</div>
                    </div>

                    <!-- Pesanan Hari Ini -->
                    <div class="stat-card">
                        <div class="stat-card-top">
                            <div class="stat-icon brown-bg">
                                <svg width="15" height="20" viewBox="0 0 15 20" fill="none">
                                    <path d="M0.546875 0.0858922C0.878906-0.0664515 1.26953-0.011764 1.54688 0.226517L3.125 1.57808L4.70312 0.226517C5.05469-0.074264 5.57422-0.074264 5.92188 0.226517L7.5 1.57808L9.07812 0.226517C9.42969-0.074264 9.94922-0.074264 10.2969 0.226517L11.875 1.57808L13.4531 0.226517C13.7305-0.011764 14.1211-0.0664515 14.4531 0.0858922C14.7852 0.238236 15 0.570267 15 0.937455V19.0625C15 19.4296 14.7852 19.7617 14.4531 19.914C14.1211 20.0664 13.7305 20.0117 13.4531 19.7734L11.875 18.4218L10.2969 19.7734C9.94531 20.0742 9.42578 20.0742 9.07812 19.7734L7.5 18.4218L5.92188 19.7734C5.57031 20.0742 5.05078 20.0742 4.70312 19.7734L3.125 18.4218L1.54688 19.7734C1.26953 20.0117 0.878906 20.0664 0.546875 19.914C0.214844 19.7617 0 19.4296 0 19.0625V0.937455C0 0.570267 0.214844 0.238236 0.546875 0.0858922ZM3.75 5.62495C3.40625 5.62495 3.125 5.9062 3.125 6.24995C3.125 6.5937 3.40625 6.87495 3.75 6.87495H11.25C11.5938 6.87495 11.875 6.5937 11.875 6.24995C11.875 5.9062 11.5938 5.62495 11.25 5.62495H3.75ZM3.125 13.75C3.125 14.0937 3.40625 14.375 3.75 14.375H11.25C11.5938 14.375 11.875 14.0937 11.875 13.75C11.875 13.4062 11.5938 13.125 11.25 13.125H3.75C3.40625 13.125 3.125 13.4062 3.125 13.75ZM3.75 9.37495C3.40625 9.37495 3.125 9.6562 3.125 9.99995C3.125 10.3437 3.40625 10.625 3.75 10.625H11.25C11.5938 10.625 11.875 10.3437 11.875 9.99995C11.875 9.6562 11.5938 9.37495 11.25 9.37495H3.75Z" fill="#744622" />
                                </svg>
                            </div>
                            <span class="stat-badge badge-brown">+8%</span>
                        </div>
                        <div class="stat-value">{{ $jumlahPesananMasuk }}</div>
                        <div class="stat-label">Pesanan Hari Ini</div>
                    </div>

                    <!-- Pesanan Dibayar -->
                    <div class="stat-card">
                        <div class="stat-card-top">
                            <div class="stat-icon yellow-bg">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M10 0C12.6522 0 15.1957 1.05357 17.0711 2.92893C18.9464 4.8043 20 7.34784 20 10C20 12.6522 18.9464 15.1957 17.0711 17.0711C15.1957 18.9464 12.6522 20 10 20C7.34784 20 4.8043 18.9464 2.92893 17.0711C1.05357 15.1957 0 12.6522 0 10C0 7.34784 1.05357 4.8043 2.92893 2.92893C4.8043 1.05357 7.34784 0 10 0ZM9.0625 4.6875V10C9.0625 10.3125 9.21875 10.6055 9.48047 10.7812L13.2305 13.2812C13.6602 13.5703 14.2422 13.4531 14.5312 13.0195C14.8203 12.5859 14.7031 12.0078 14.2695 11.7188L10.9375 9.5V4.6875C10.9375 4.16797 10.5195 3.75 10 3.75C9.48047 3.75 9.0625 4.16797 9.0625 4.6875Z" fill="#D97706" />
                                </svg>
                            </div>
                            <span class="stat-badge badge-yellow">Aktif</span>
                        </div>
                        <div class="stat-value">{{ $pesananMasuk->count() }}</div>
                        <div class="stat-label">Pesanan Dibayar</div>
                    </div>

                    <!-- Rating -->
                    <div class="stat-card">
                        <div class="stat-card-top">
                            <div class="stat-icon blue-bg">
                                <svg width="22" height="20" viewBox="0 0 22 20" fill="none">
                                    <path d="M12.3789 0.703125C12.1719 0.273438 11.7344 0 11.2539 0C10.7734 0 10.3399 0.273438 10.1289 0.703125L7.6172 5.87109L2.00782 6.69922C1.53907 6.76953 1.14845 7.09766 1.00391 7.54688C0.859383 7.99609 0.97657 8.49219 1.31251 8.82422L5.38282 12.8516L4.42188 18.543C4.34376 19.0117 4.53907 19.4883 4.92579 19.7656C5.31251 20.043 5.82423 20.0781 6.2461 19.8555L11.2578 17.1797L16.2695 19.8555C16.6914 20.0781 17.2031 20.0469 17.5899 19.7656C17.9766 19.4844 18.1719 19.0117 18.0938 18.543L17.1289 12.8516L21.1992 8.82422C21.5352 8.49219 21.6563 7.99609 21.5078 7.54688C21.3594 7.09766 20.9727 6.76953 20.5039 6.69922L14.8906 5.87109L12.3789 0.703125Z" fill="#2563EB" />
                                </svg>
                            </div>
                            <span class="stat-badge badge-blue">Baik</span>
                        </div>
                        <div class="stat-value">{{ number_format((float) $vendor->rating, 1) }}</div>
                        <div class="stat-label">Rating Vendor</div>
                    </div>
                </section>

                <!-- ── Produk Terlaris ── -->
                <section class="reveal">
                    <div class="section-header">
                        <div>
                            <div class="section-title">Produk Terlaris</div>
                            <div class="section-subtitle">Menu favorit pelanggan minggu ini</div>
                        </div>

                    </div>

                    <div class="products-grid">
                        @forelse ($produkTerlaris as $produk)
                        <div class="product-card">
                            <div class="product-image-wrap">
                                @php
                                    $produkImgFallback = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='504' height='504'%3E%3Crect width='504' height='504' fill='%23FBF5E8'/%3E%3C/svg%3E";
                                    $produkImg = $produk->path_gambar
                                        ? (\Illuminate\Support\Str::startsWith($produk->path_gambar, ['http://', 'https://', '/']) ? $produk->path_gambar : asset('storage/' . $produk->path_gambar))
                                        : $produkImgFallback;
                                @endphp
                                <img class="product-img" src="{{ $produkImg }}" alt="{{ $produk->nama_menu }}">
                                @if ($loop->first)
                                <span class="product-badge green-badge">Best Seller</span>
                                @elseif ($produk->detail_pesanans_count > 0)
                                <span class="product-badge brown-badge">Populer</span>
                                @endif
                            </div>
                            <div class="product-info">
                                <div class="product-name">{{ $produk->nama_menu }}</div>
                                <div class="product-desc">{{ $produk->deskripsi ?: 'Menu andalan vendor dengan kualitas terbaik.' }}</div>
                                <div class="product-meta">
                                    <span class="product-price">Rp {{ number_format((int) $produk->harga, 0, ',', '.') }}</span>
                                    <div class="product-rating">
                                        <svg width="15" height="14" viewBox="0 0 16 14" fill="none">
                                            <path d="M8.66525 0.492188C8.52032 0.191406 8.21407 0 7.87775 0C7.54142 0 7.2379 0.191406 7.09025 0.492188L5.33204 4.10977L1.40548 4.68945C1.07736 4.73867 0.803918 4.96836 0.702746 5.28281C0.601574 5.59727 0.683605 5.94453 0.918761 6.17695L3.76798 8.99609L3.09532 12.9801C3.04064 13.3082 3.17736 13.6418 3.44806 13.8359C3.71876 14.0301 4.07696 14.0547 4.37228 13.8988L7.88048 12.0258L11.3887 13.8988C11.684 14.0547 12.0422 14.0328 12.3129 13.8359C12.5836 13.6391 12.7203 13.3082 12.6656 12.9801L11.9902 8.99609L14.8395 6.17695C15.0746 5.94453 15.1594 5.59727 15.0555 5.28281C14.9516 4.96836 14.6809 4.73867 14.3527 4.68945L10.4234 4.10977L8.66525 0.492188Z" fill="#F59E0B" />
                                        </svg>
                                        <span class="rating-value">{{ number_format((float) $vendor->rating, 1) }}</span>
                                    </div>
                                </div>
                                <div class="product-actions">
                                    <button class="btn-edit">{{ $produk->detail_pesanans_count }} terjual</button>
                                    <a href="{{ route('menu.price-tag', $produk) }}" class="btn-cetak">Cetak Tag Harga</a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="product-card">
                            <div class="product-info">
                                <div class="product-name">Belum ada data produk</div>
                                <div class="product-desc">Data produk terlaris akan tampil setelah ada pesanan yang sudah dibayar.</div>
                            </div>
                        </div>
                        @endforelse

                    </div>
                </section>

                <!-- ── Bottom Row ── -->
                <div class="bottom-grid reveal">

                    <!-- Pesanan Terbaru -->
                    <div class="orders-panel">
                        <div class="orders-header">
                            <div>
                                <div class="section-title">Pesanan Terbaru</div>
                                <div class="section-subtitle">Kelola pesanan masuk</div>
                            </div>
                            <a href="{{ route('dashboard') }}" class="link-see-all">Lihat Semua</a>
                        </div>
                        <ol class="orders-list">
                            @forelse ($pesananMasuk as $pesanan)
                            @php
                            $firstDetail = $pesanan->detailPesanans->first();
                            $firstMenu = $firstDetail?->menu;
                            $totalItem = $pesanan->detailPesanans->sum('jumlah');
                            $statusRaw = strtolower((string) $pesanan->status_pesanan);
                            $statusClass = match ($statusRaw) {
                            'diproses' => 'status-process',
                            'selesai' => 'status-done',
                            default => 'status-pending',
                            };
                            @endphp
                            <li class="order-row">
                                @php
                                    $orderThumbFallback = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='128' height='128'%3E%3Crect width='128' height='128' fill='%23FBF5E8'/%3E%3C/svg%3E";
                                    $firstMenuPath = $firstMenu?->path_gambar;
                                    $orderThumb = $firstMenuPath
                                        ? (\Illuminate\Support\Str::startsWith($firstMenuPath, ['http://', 'https://', '/']) ? $firstMenuPath : asset('storage/' . $firstMenuPath))
                                        : $orderThumbFallback;
                                @endphp
                                <img class="order-thumb" src="{{ $orderThumb }}" alt="{{ $firstMenu?->nama_menu ?: 'Pesanan' }}">
                                <div class="order-info">
                                    <div class="order-name">#{{ $pesanan->id }} - {{ $pesanan->nama_customer }}</div>
                                    <div class="order-qty">{{ $totalItem }}x &bull; Rp {{ number_format((int) $pesanan->total, 0, ',', '.') }}</div>
                                </div>
                                <div class="order-right">
                                    <div class="order-actions">
                                        <span class="status-badge {{ $statusClass }}">{{ ucfirst($statusRaw) }}</span>
                                        @if ($statusRaw === 'diproses')
                                        <form method="POST" action="{{ route('dashboard.orders.complete', ['pesanan' => $pesanan->id]) }}" class="order-done-form">
                                            @csrf
                                            <button type="submit" class="btn-mark-done">Selesaikan</button>
                                        </form>
                                        @endif
                                    </div>
                                    <span class="order-time">{{ $pesanan->created_at?->diffForHumans() }}</span>
                                </div>
                            </li>
                            @empty
                            <li class="order-row">
                                <div class="order-info">
                                    <div class="order-name">Belum ada pesanan dibayar</div>
                                    <div class="order-qty">Pesanan settlement akan tampil di sini.</div>
                                </div>
                            </li>
                            @endforelse

                        </ol>
                    </div>

                    <!-- Ringkasan Penjualan -->
                    <div class="summary-panel">
                        <div class="summary-title">Ringkasan Penjualan</div>
                        <div class="summary-row">
                            <span class="summary-row-label">Hari Ini</span>
                            <span class="summary-row-value">Rp {{ number_format((int) $totalHariIni, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-row-label">Minggu Ini</span>
                            <span class="summary-row-value">Rp {{ number_format((int) $totalMingguIni, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-row-label">Bulan Ini</span>
                            <span class="summary-row-value">Rp {{ number_format((int) $totalBulanIni, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-row-label">Target Bulan Ini</span>
                            <span class="summary-row-value">Rp {{ number_format((int) $targetBulanIni, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-progress-block">
                            <div class="progress-pct" id="progressPct">{{ $progressPersen }}%</div>
                            <div class="progress-label">Progress target tercapai</div>
                            <div class="progress-bar-outer">
                                <div class="progress-bar-inner" id="progressBar"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div><!-- /dashboard-body -->
        </div><!-- /main-content -->
    </div><!-- /dashboard-shell -->

    <!-- Scan Barcode Modal -->
    <div id="scanModal" class="scan-modal-overlay" style="display:none;">
        <div class="scan-modal">
            <div class="scan-modal-header">
                <h2>Scan Barcode Pesanan</h2>
                <button type="button" id="scanModalClose" class="scan-modal-close">&times;</button>
            </div>
            <div class="scan-modal-body">
                <div id="scannerContainer" style="width:100%;max-width:400px;margin:0 auto;"></div>
                <div id="scanResult" style="display:none;"></div>
                <div class="scan-manual-toggle">
                    <button type="button" id="manualToggle" class="scan-link-btn">Input Manual Order ID</button>
                </div>
                <div id="manualInput" style="display:none;margin-top:16px;">
                    <label style="display:block;font-size:13px;margin-bottom:6px;color:var(--brown-70);">Masukkan Order ID</label>
                    <div style="display:flex;gap:8px;">
                        <input type="text" id="manualOrderId" placeholder="KK-123-1713100800" style="flex:1;padding:10px 14px;border:1px solid var(--brown-10);border-radius:8px;font-family:inherit;font-size:14px;" />
                        <button type="button" id="manualLookupBtn" style="padding:10px 20px;background:var(--green);color:#fff;border:none;border-radius:8px;cursor:pointer;font-family:inherit;font-weight:600;font-size:14px;">Cari</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        /* ── Scan Barcode ── */
        (function() {
            const modal = document.getElementById('scanModal');
            const openBtn = document.getElementById('scanBarcodeBtn');
            const closeBtn = document.getElementById('scanModalClose');
            const scannerEl = document.getElementById('scannerContainer');
            const scanResultEl = document.getElementById('scanResult');
            const manualToggle = document.getElementById('manualToggle');
            const manualInput = document.getElementById('manualInput');
            const manualOrderId = document.getElementById('manualOrderId');
            const manualLookupBtn = document.getElementById('manualLookupBtn');

            let html5QrCode = null;
            let isScanning = false;

            function stopScanner() {
                if (html5QrCode && isScanning) {
                    try {
                        html5QrCode.stop().then(() => {
                            html5QrCode.clear();
                            isScanning = false;
                        }).catch(() => {});
                    } catch (e) {}
                }
            }

            function startScanner() {
                if (!html5QrCode) {
                    html5QrCode = new Html5Qrcode("scannerContainer");
                }
                const config = {
                    fps: 15,
                    qrbox: function(viewfinderWidth, viewfinderHeight) {
                        const minEdge = Math.min(viewfinderWidth, viewfinderHeight);
                        const size = Math.max(50, Math.floor(minEdge * 0.7));
                        return { width: size, height: Math.max(50, Math.floor(size * 0.6)) };
                    }
                };
                html5QrCode.start(
                    { facingMode: "environment" },
                    config,
                    onScanSuccess,
                    function(err) { /* ignore frame errors */ }
                ).then(() => {
                    isScanning = true;
                }).catch(function(err) {
                    scannerEl.innerHTML = '<div class="scan-error">Kamera tidak tersedia atau izin ditolak.</div>';
                });
            }

            function playBeep() {
                try {
                    var ctx = new (window.AudioContext || window.webkitAudioContext)();
                    var osc = ctx.createOscillator();
                    var gain = ctx.createGain();
                    osc.connect(gain);
                    gain.connect(ctx.destination);
                    osc.type = 'sine';
                    osc.frequency.value = 880;
                    gain.gain.value = 0.3;
                    osc.start();
                    gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.2);
                    osc.stop(ctx.currentTime + 0.2);
                } catch (e) {}
            }

            function onScanSuccess(decodedText) {
                playBeep();
                stopScanner();
                lookupOrder(decodedText.trim());
            }

            function lookupOrder(orderId) {
                scanResultEl.style.display = 'block';
                scanResultEl.innerHTML = '<div class="scan-loading">Mencari pesanan...</div>';

                fetch('/api/checkout/by-order-id/' + encodeURIComponent(orderId))
                .then(function(r) {
                    if (!r.ok) {
                        return r.json().then(function(d) { throw new Error(d.message || 'Pesanan tidak ditemukan'); });
                    }
                    return r.json();
                })
                .then(function(data) {
                    renderScanResult(data);
                })
                .catch(function(err) {
                    scanResultEl.innerHTML = '<div class="scan-error">' + err.message + '</div>';
                });
            }

            function renderScanResult(data) {
                var statusBadge = data.status_pesanan.charAt(0).toUpperCase() + data.status_pesanan.slice(1);
                var html = '<div class="scan-result-card">';
                html += '<h3>#' + data.pesanan_id + ' - ' + data.nama_customer + '</h3>';
                html += '<div class="scan-result-item"><span class="label">Vendor</span><span class="value">' + data.vendor_name + '</span></div>';
                html += '<div class="scan-result-item"><span class="label">Status</span><span class="value">' + statusBadge + '</span></div>';
                html += '<div class="scan-result-item"><span class="label">Total</span><span class="value">Rp ' + numberFormat(data.total) + '</span></div>';
                if (data.waktu_pengambilan) {
                    html += '<div class="scan-result-item"><span class="label">Waktu Ambil</span><span class="value">' + data.waktu_pengambilan + '</span></div>';
                }
                if (data.items && data.items.length) {
                    html += '<table class="scan-result-items-table"><thead><tr><th>Menu</th><th>Qty</th><th>Harga</th></tr></thead><tbody>';
                    data.items.forEach(function(item) {
                        html += '<tr><td>' + item.nama_menu + '</td><td>' + item.jumlah + '</td><td>Rp ' + numberFormat(item.subtotal) + '</td></tr>';
                    });
                    html += '</tbody></table>';
                }
                html += '</div>';
                scanResultEl.innerHTML = html;
            }

            function numberFormat(n) {
                return Number(n || 0).toLocaleString('id-ID');
            }

            /* ── Event listeners ── */
            openBtn.addEventListener('click', function() {
                modal.style.display = 'flex';
                scanResultEl.style.display = 'none';
                scanResultEl.innerHTML = '';
                manualInput.style.display = 'none';
                manualOrderId.value = '';
                startScanner();
            });

            closeBtn.addEventListener('click', function() {
                stopScanner();
                modal.style.display = 'none';
            });

            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    stopScanner();
                    modal.style.display = 'none';
                }
            });

            manualToggle.addEventListener('click', function() {
                var isVisible = manualInput.style.display === 'block';
                manualInput.style.display = isVisible ? 'none' : 'block';
                manualToggle.textContent = isVisible ? 'Input Manual Order ID' : 'Sembunyikan input manual';
                if (isVisible) {
                    stopScanner();
                    startScanner();
                } else {
                    stopScanner();
                }
            });

            manualLookupBtn.addEventListener('click', function() {
                var val = manualOrderId.value.trim();
                if (!val) return;
                stopScanner();
                lookupOrder(val);
            });

            manualOrderId.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    manualLookupBtn.click();
                }
            });
        })();

        /* ── Scroll reveal ── */
        const revealEls = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });
        revealEls.forEach((el) => observer.observe(el));

        /* ── Animated progress bar ── */
        const bar = document.getElementById('progressBar');
        const progressValue = Number(document.body.dataset.progressPercent || 0);
        setTimeout(() => {
            if (bar) {
                bar.style.width = `${progressValue}%`;
            }
        }, 600);
    </script>

</body>

</html>