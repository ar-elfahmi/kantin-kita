<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Vendor – Kantin Kita</title>
    <link rel="icon" type="image/png" href="https://api.builder.io/api/v1/image/assets/TEMP/10a82c5c6d87de97d3583b6c8564df77f595f954?width=1114">
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

        /* ─── Sidebar ───────────────────────────────────────── */
        .sidebar {
            width: 288px;
            flex-shrink: 0;
            background: var(--white);
            border-right: 1px solid var(--brown-10);
            display: flex;
            flex-direction: column;
            padding: 24px;
            gap: 48px;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 100;
            box-shadow: 2px 0 20px rgba(116, 70, 34, .04);
        }

        /* Logo */
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .logo-icon {
            width: 48px;
            height: 48px;
            background: var(--green);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(66, 118, 106, .35);
            transition: transform var(--transition), box-shadow var(--transition);
        }

        .logo-icon:hover {
            transform: scale(1.07);
            box-shadow: 0 6px 20px rgba(66, 118, 106, .45);
        }

        .logo-text-primary {
            font-size: 24px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -.5px;
            line-height: 1.33;
        }

        .logo-text-secondary {
            font-size: 12px;
            font-weight: 500;
            color: var(--brown-60);
            letter-spacing: -.5px;
            line-height: 1.33;
        }

        /* Nav */
        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: var(--radius-md);
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            color: var(--brown-70);
            transition: background var(--transition), color var(--transition), transform var(--transition);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .nav-item::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--green-10);
            opacity: 0;
            transition: opacity var(--transition);
            border-radius: inherit;
        }

        .nav-item:hover::before {
            opacity: 1;
        }

        .nav-item:hover {
            color: var(--green);
            transform: translateX(3px);
        }

        .nav-item.active {
            background: var(--green-10);
            color: var(--green);
            font-weight: 600;
        }

        .nav-item.active::after {
            content: '';
            position: absolute;
            right: 0;
            top: 20%;
            height: 60%;
            width: 3px;
            background: var(--green);
            border-radius: 2px 0 0 2px;
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Sidebar Footer */
        .sidebar-footer {
            border-top: 1px solid var(--brown-10);
            padding-top: 24px;
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: var(--radius-md);
            transition: background var(--transition);
            cursor: pointer;
        }

        .sidebar-user:hover {
            background: var(--cream);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-pill);
            object-fit: cover;
            border: 2px solid var(--brown-10);
            flex-shrink: 0;
        }

        .user-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--brown);
            letter-spacing: -.5px;
            line-height: 1.43;
        }

        .user-email {
            font-size: 12px;
            font-weight: 400;
            color: var(--brown-60);
            letter-spacing: -.5px;
            line-height: 1.33;
        }

        .sidebar-logout {
            margin-left: auto;
            width: 16px;
            height: 16px;
            flex-shrink: 0;
            opacity: .6;
            transition: opacity var(--transition);
        }

        .sidebar-logout-btn {
            margin-left: auto;
            border: none;
            background: transparent;
            padding: 0;
            display: inline-flex;
            align-items: center;
            cursor: pointer;
        }

        .sidebar-user:hover .sidebar-logout {
            opacity: 1;
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

        .header-username {
            font-size: 14px;
            font-weight: 600;
            color: var(--brown);
            letter-spacing: -.5px;
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
            top: -40%;
            right: -20%;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: var(--cream);
            opacity: .6;
            transition: transform var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card:hover::before {
            transform: scale(1.3);
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

        .btn-detail {
            flex: 1;
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            background: var(--green);
            color: var(--white);
            font-size: 14px;
            font-weight: 600;
            letter-spacing: -.5px;
            border: none;
            cursor: pointer;
            transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
        }

        .btn-detail:hover {
            background: #355f55;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(66, 118, 106, .35);
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
            .dashboard-shell {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: static;
                padding: 14px 16px 12px;
                gap: 14px;
                border-right: none;
                border-bottom: 1px solid var(--brown-10);
                box-shadow: 0 2px 10px rgba(116, 70, 34, .08);
            }

            .sidebar-logo {
                justify-content: flex-start;
            }

            .sidebar-nav {
                flex-direction: row;
                overflow-x: auto;
                flex-wrap: nowrap;
                gap: 8px;
                padding-bottom: 4px;
            }

            .sidebar-nav::-webkit-scrollbar {
                display: none;
            }

            .nav-item {
                justify-content: flex-start;
                padding: 8px 12px;
                min-height: 36px;
                min-width: max-content;
                transform: none;
            }

            .nav-item::before,
            .nav-item.active::after {
                display: none;
            }

            .nav-item:hover {
                transform: none;
            }

            .nav-icon {
                width: 20px;
                height: 20px;
                border-radius: 0;
                background: transparent;
                border: none;
            }

            .nav-icon svg {
                width: 16px;
                height: 16px;
            }

            .nav-item .nav-icon svg path {
                fill: var(--brown) !important;
            }

            .nav-item.active {
                background: rgba(66, 118, 106, .14);
            }

            .nav-item.active .nav-icon svg path {
                fill: var(--green) !important;
            }

            .sidebar-user {
                padding: 10px 12px;
            }

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

            .sidebar {
                width: 100%;
                padding: 12px;
            }

            .sidebar-logo {
                gap: 8px;
            }

            .logo-text-primary {
                font-size: 18px;
            }

            .logo-text-secondary {
                display: none;
            }

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

            .stats-grid {
                grid-template-columns: 1fr;
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
        <aside class="sidebar">
            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="sidebar-logo">
                <div class="logo-icon">
                    <img src="https://api.builder.io/api/v1/image/assets/TEMP/10a82c5c6d87de97d3583b6c8564df77f595f954?width=1114" alt="Kantin Kita Logo" style="width:100%;height:100%;object-fit:cover;border-radius:inherit;" />
                </div>
                <div>
                    <div class="logo-text-primary">Kantin Kita</div>
                    <div class="logo-text-secondary">Vendor Dashboard</div>
                </div>
            </a>

            <!-- Navigation -->
            <nav class="sidebar-nav">
                <a href="{{ route('dashboard') }}" class="nav-item active">
                    <span class="nav-icon">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M4.89062 13.9906L4.49687 14.9125C3.9125 14.6156 3.375 14.25 2.8875 13.8219L3.59687 13.1125C3.9875 13.4531 4.42188 13.75 4.89062 13.9906ZM1.26875 8.5H0.265625C0.309375 9.1625 0.434375 9.80313 0.63125 10.4094L1.5625 10.0375C1.40937 9.54688 1.30625 9.03125 1.26875 8.5ZM1.26875 7.5C1.3125 6.9125 1.43125 6.34375 1.61563 5.80937L0.69375 5.41563C0.459375 6.07188 0.3125 6.77187 0.265625 7.5H1.26875ZM2.00938 4.89062C2.25313 4.425 2.54688 3.99062 2.8875 3.59375L2.17812 2.88438C1.75 3.37188 1.38125 3.90938 1.0875 4.49375L2.00938 4.89062ZM12.4062 13.1125C11.9719 13.4875 11.4875 13.8094 10.9656 14.0625L11.3375 14.9937C11.9844 14.6844 12.5813 14.2875 13.1156 13.8188L12.4062 13.1125ZM3.59375 2.8875C4.02813 2.5125 4.5125 2.19062 5.03438 1.9375L4.6625 1.00625C4.01562 1.31562 3.41875 1.7125 2.8875 2.18125L3.59375 2.8875ZM13.9906 11.1094C13.7469 11.575 13.4531 12.0094 13.1125 12.4062L13.8219 13.1156C14.25 12.6281 14.6188 12.0875 14.9125 11.5063L13.9906 11.1094ZM14.7312 8.5C14.6875 9.0875 14.5687 9.65625 14.3844 10.1906L15.3062 10.5844C15.5406 9.925 15.6875 9.225 15.7312 8.49687H14.7312V8.5ZM10.0375 14.4375C9.54688 14.5938 9.03125 14.6937 8.5 14.7312V15.7344C9.1625 15.6906 9.80313 15.5656 10.4094 15.3687L10.0375 14.4375ZM7.5 14.7312C6.9125 14.6875 6.34375 14.5687 5.80937 14.3844L5.41563 15.3062C6.075 15.5406 6.775 15.6875 7.50313 15.7312V14.7312H7.5ZM14.4375 5.9625C14.5938 6.45312 14.6937 6.96875 14.7312 7.5H15.7344C15.6906 6.8375 15.5656 6.19687 15.3687 5.59062L14.4375 5.9625ZM2.8875 12.4062C2.5125 11.9719 2.19062 11.4875 1.9375 10.9656L1.00625 11.3375C1.31562 11.9844 1.7125 12.5813 2.18125 13.1156L2.8875 12.4062ZM8.5 1.26875C9.0875 1.3125 9.65312 1.43125 10.1906 1.61563L10.5844 0.69375C9.92813 0.459375 9.22812 0.3125 8.5 0.265625V1.26875ZM5.9625 1.5625C6.45312 1.40625 6.96875 1.30625 7.5 1.26875V0.265625C6.8375 0.309375 6.19687 0.434375 5.59062 0.63125L5.9625 1.5625ZM13.8219 2.88438L13.1125 3.59375C13.4875 4.02813 13.8094 4.5125 14.0656 5.03438L14.9969 4.6625C14.6875 4.01562 14.2906 3.41875 13.8219 2.88438ZM12.4062 2.8875L13.1156 2.17812C12.6281 1.75 12.0906 1.38125 11.5063 1.0875L11.1125 2.00938C11.575 2.25313 12.0125 2.54688 12.4062 2.8875Z" fill="#42766A" />
                            <path d="M8 12.25C8.48325 12.25 8.875 11.8582 8.875 11.375C8.875 10.8918 8.48325 10.5 8 10.5C7.51675 10.5 7.125 10.8918 7.125 11.375C7.125 11.8582 7.51675 12.25 8 12.25Z" fill="#42766A" />
                            <path d="M8.24063 9.75H7.74062C7.53437 9.75 7.36562 9.58125 7.36562 9.375C7.36562 7.15625 9.78437 7.37812 9.78437 6.00625C9.78437 5.38125 9.22812 4.75 7.99062 4.75C7.08125 4.75 6.60625 5.05 6.14062 5.64687C6.01875 5.80312 5.79375 5.83438 5.63437 5.72188L5.225 5.43437C5.05 5.3125 5.00937 5.06562 5.14375 4.89687C5.80625 4.04687 6.59375 3.5 7.99375 3.5C9.62812 3.5 11.0375 4.43125 11.0375 6.00625C11.0375 8.11875 8.61875 7.99062 8.61875 9.375C8.61562 9.58125 8.44688 9.75 8.24063 9.75Z" fill="#42766A" />
                        </svg>
                    </span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('dashboard') }}" class="nav-item">
                    <span class="nav-icon">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M0 6C0 4.89687 0.896875 4 2 4C2.01562 4 2.03437 4 2.05 4C2.28125 2.85938 3.29063 2 4.5 2C4.96875 2 5.40625 2.12812 5.77812 2.35C6.19375 1.55 7.03438 1 8 1C8.96562 1 9.80625 1.55 10.2219 2.35C10.5938 2.12812 11.0312 2 11.5 2C12.7094 2 13.7188 2.85938 13.95 4C13.9656 4 13.9844 4 14 4C15.1031 4 16 4.89687 16 6C16 6.36562 15.9031 6.70625 15.7312 7H0.26875C0.096875 6.70625 0 6.36562 0 6ZM0 8.85625C0 8.38437 0.384375 8 0.85625 8H15.1438C15.6156 8 16 8.38437 16 8.85625C16 11.0594 14.6125 12.9406 12.6656 13.6719L12.6094 14.125C12.5469 14.625 12.1219 15 11.6156 15H4.38125C3.87812 15 3.45 14.625 3.3875 14.125L3.33125 13.675C1.3875 12.9406 0 11.0594 0 8.85625Z" fill="rgba(116,70,34,0.7)" />
                        </svg>
                    </span>
                    <span>Produk</span>
                </a>
                <a href="{{ route('dashboard') }}" class="nav-item">
                    <span class="nav-icon">
                        <svg width="12" height="16" viewBox="0 0 12 16" fill="none">
                            <path d="M0.4375 0.0687138C0.703125-0.0531612 1.01562-0.00941122 1.2375 0.181214L2.5 1.26246L3.7625 0.181214C4.04375-0.0594112 4.45938-0.0594112 4.7375 0.181214L6 1.26246L7.2625 0.181214C7.54375-0.0594112 7.95938-0.0594112 8.2375 0.181214L9.5 1.26246L10.7625 0.181214C10.9844-0.00941122 11.2969-0.0531612 11.5625 0.0687138C11.8281 0.190589 12 0.456214 12 0.749964V15.25C12 15.5437 11.8281 15.8093 11.5625 15.9312C11.2969 16.0531 10.9844 16.0093 10.7625 15.8187L9.5 14.7375L8.2375 15.8187C7.95625 16.0593 7.54062 16.0593 7.2625 15.8187L6 14.7375L4.7375 15.8187C4.45625 16.0593 4.04063 16.0593 3.7625 15.8187L2.5 14.7375L1.2375 15.8187C1.01562 16.0093 0.703125 16.0531 0.4375 15.9312C0.171875 15.8093 0 15.5437 0 15.25V0.749964C0 0.456214 0.171875 0.190589 0.4375 0.0687138ZM3 4.49996C2.725 4.49996 2.5 4.72496 2.5 4.99996C2.5 5.27496 2.725 5.49996 3 5.49996H9C9.275 5.49996 9.5 5.27496 9.5 4.99996C9.5 4.72496 9.275 4.49996 9 4.49996H3ZM2.5 11C2.5 11.275 2.725 11.5 3 11.5H9C9.275 11.5 9.5 11.275 9.5 11C9.5 10.725 9.275 10.5 9 10.5H3C2.725 10.5 2.5 10.725 2.5 11ZM3 7.49996C2.725 7.49996 2.5 7.72496 2.5 7.99996C2.5 8.27496 2.725 8.49996 3 8.49996H9C9.275 8.49996 9.5 8.27496 9.5 7.99996C9.5 7.72496 9.275 7.49996 9 7.49996H3Z" fill="rgba(116,70,34,0.7)" />
                        </svg>
                    </span>
                    <span>Pesanan</span>
                </a>
                <a href="{{ route('dashboard') }}" class="nav-item">
                    <span class="nav-icon">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M2 2C2 1.44687 1.55313 1 1 1C0.446875 1 0 1.44687 0 2V12.5C0 13.8813 1.11875 15 2.5 15H15C15.5531 15 16 14.5531 16 14C16 13.4469 15.5531 13 15 13H2.5C2.225 13 2 12.775 2 12.5V2ZM14.7063 4.70625C15.0969 4.31563 15.0969 3.68125 14.7063 3.29063C14.3156 2.9 13.6812 2.9 13.2906 3.29063L10 6.58437L8.20625 4.79063C7.81563 4.4 7.18125 4.4 6.79063 4.79063L3.29063 8.29062C2.9 8.68125 2.9 9.31563 3.29063 9.70625C3.68125 10.0969 4.31563 10.0969 4.70625 9.70625L7.5 6.91563L9.29375 8.70938C9.68437 9.1 10.3188 9.1 10.7094 8.70938L14.7094 4.70937L14.7063 4.70625Z" fill="rgba(116,70,34,0.7)" />
                        </svg>
                    </span>
                    <span>Statistik</span>
                </a>
                <a href="{{ route('dashboard') }}" class="nav-item">
                    <span class="nav-icon">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M2 1C0.896875 1 0 1.89688 0 3V13C0 14.1031 0.896875 15 2 15H14C15.1031 15 16 14.1031 16 13V6C16 4.89687 15.1031 4 14 4H2.5C2.225 4 2 3.775 2 3.5C2 3.225 2.225 3 2.5 3H14C14.5531 3 15 2.55313 15 2C15 1.44687 14.5531 1 14 1H2ZM13 8.5C13.2652 8.5 13.5196 8.60536 13.7071 8.79289C13.8946 8.98043 14 9.23478 14 9.5C14 9.76522 13.8946 10.0196 13.7071 10.2071C13.5196 10.3946 13.2652 10.5 13 10.5C12.7348 10.5 12.4804 10.3946 12.2929 10.2071C12.1054 10.0196 12 9.76522 12 9.5C12 9.23478 12.1054 8.98043 12.2929 8.79289C12.4804 8.60536 12.7348 8.5 13 8.5Z" fill="rgba(116,70,34,0.7)" />
                        </svg>
                    </span>
                    <span>Keuangan</span>
                </a>
                <a href="{{ route('dashboard') }}" class="nav-item">
                    <span class="nav-icon">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M15.4969 5.20625C15.5969 5.47813 15.5125 5.78125 15.2969 5.975L13.9438 7.20625C13.9781 7.46563 13.9969 7.73125 13.9969 8C13.9969 8.26875 13.9781 8.53438 13.9438 8.79375L15.2969 10.025C15.5125 10.2188 15.5969 10.5219 15.4969 10.7937C15.3594 11.1656 15.1938 11.5219 15.0031 11.8656L14.8562 12.1187C14.65 12.4625 14.4187 12.7875 14.1656 13.0938C13.9812 13.3188 13.675 13.3937 13.4 13.3062L11.6594 12.7531C11.2406 13.075 10.7781 13.3438 10.2844 13.5469L9.89375 15.3313C9.83125 15.6156 9.6125 15.8406 9.325 15.8875C8.89375 15.9594 8.45 15.9969 7.99687 15.9969C7.54375 15.9969 7.1 15.9594 6.66875 15.8875C6.38125 15.8406 6.1625 15.6156 6.1 15.3313L5.70937 13.5469C5.21562 13.3438 4.75312 13.075 4.33437 12.7531L2.59687 13.3094C2.32187 13.3969 2.01562 13.3188 1.83125 13.0969C1.57812 12.7906 1.34687 12.4656 1.14062 12.1219L0.99375 11.8687C0.803125 11.525 0.6375 11.1687 0.5 10.7969C0.4 10.525 0.484375 10.2219 0.7 10.0281L2.05312 8.79688C2.01875 8.53438 2 8.26875 2 8C2 7.73125 2.01875 7.46563 2.05312 7.20625L0.7 5.975C0.484375 5.78125 0.4 5.47813 0.5 5.20625C0.6375 4.83438 0.803125 4.47813 0.99375 4.13438L1.14062 3.88125C1.34687 3.5375 1.57812 3.2125 1.83125 2.90625C2.01562 2.68125 2.32187 2.60625 2.59687 2.69375L4.3375 3.24688C4.75625 2.925 5.21875 2.65625 5.7125 2.45312L6.10312 0.66875C6.16562 0.384375 6.38437 0.159375 6.67187 0.1125C7.10312 0.0375 7.54687 0 8 0C8.45312 0 8.89688 0.0375 9.32812 0.109375C9.61563 0.15625 9.83438 0.38125 9.89688 0.665625L10.2875 2.45C10.7812 2.65313 11.2438 2.92188 11.6625 3.24375L13.4031 2.69062C13.6781 2.60312 13.9844 2.68125 14.1687 2.90313C14.4219 3.20938 14.6531 3.53437 14.8594 3.87812L15.0063 4.13125C15.1969 4.475 15.3625 4.83125 15.5 5.20312L15.4969 5.20625ZM8 10.5C8.66304 10.5 9.29893 10.2366 9.76777 9.76777C10.2366 9.29893 10.5 8.66304 10.5 8C10.5 7.33696 10.2366 6.70107 9.76777 6.23223C9.29893 5.76339 8.66304 5.5 8 5.5C7.33696 5.5 6.70107 5.76339 6.23223 6.23223C5.76339 6.70107 5.5 7.33696 5.5 8C5.5 8.66304 5.76339 9.29893 6.23223 9.76777C6.70107 10.2366 7.33696 10.5 8 10.5Z" fill="rgba(116,70,34,0.7)" />
                        </svg>
                    </span>
                    <span>Pengaturan</span>
                </a>
            </nav>

            <!-- User Footer -->
            <div class="sidebar-footer">
                <div class="sidebar-user">
                    <img class="user-avatar" src="https://api.builder.io/api/v1/image/assets/TEMP/087ab2dd772577a5a55f3825b36f4260590b6776?width=80" alt="{{ $vendor->nama_vendor }}">
                    <div style="flex:1;min-width:0;">
                        <div class="user-name">{{ $vendor->nama_vendor }}</div>
                        <div class="user-email">{{ auth()->user()?->email ?? 'vendor@kantinkita.id' }}</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="sidebar-logout-btn">
                        @csrf
                        <button type="submit" class="sidebar-logout-btn" aria-label="Logout">
                            <svg class="sidebar-logout" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M11.8094 3.30938L15.6469 7.14687C15.8719 7.37187 16 7.68125 16 8C16 8.31875 15.8719 8.62812 15.6469 8.85312L11.8094 12.6906C11.6094 12.8906 11.3406 13 11.0594 13C10.475 13 10 12.525 10 11.9406V10H6C5.44688 10 5 9.55313 5 9V7C5 6.44688 5.44688 6 6 6H10V4.05937C10 3.475 10.475 3 11.0594 3C11.3406 3 11.6094 3.1125 11.8094 3.30938ZM5 3H3C2.44688 3 2 3.44688 2 4V12C2 12.5531 2.44688 13 3 13H5C5.55312 13 6 13.4469 6 14C6 14.5531 5.55312 15 5 15H3C1.34375 15 0 13.6562 0 12V4C0 2.34375 1.34375 1 3 1H5C5.55312 1 6 1.44687 6 2C6 2.55313 5.55312 3 5 3Z" fill="rgba(116,70,34,0.6)" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

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
                    <div class="header-user-chip">
                        <img class="header-avatar" src="https://api.builder.io/api/v1/image/assets/TEMP/d2809f4985ab877fe9cc63eb8ac265662cce04ff?width=64" alt="{{ $vendor->nama_vendor }}">
                        <span class="header-username">{{ $vendor->nama_vendor }}</span>
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
                        <button class="btn-primary">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M7 1C7 0.447715 6.55228 0 6 0C5.44772 0 5 0.447715 5 1V5H1C0.447715 5 0 5.44772 0 6C0 6.55228 0.447715 7 1 7H5V11C5 11.5523 5.44772 12 6 12C6.55228 12 7 11.5523 7 11V7H11C11.5523 7 12 6.55228 12 6C12 5.44772 11.5523 5 11 5H7V1Z" fill="white" />
                            </svg>
                            Tambah Produk
                        </button>
                    </div>

                    <div class="products-grid">
                        @forelse ($produkTerlaris as $produk)
                        <div class="product-card">
                            <div class="product-image-wrap">
                                <img class="product-img" src="{{ $produk->path_gambar ?: 'https://api.builder.io/api/v1/image/assets/TEMP/ba6382dc578b32751a4c6e03f2066fc64f93e8ce?width=504' }}" alt="{{ $produk->nama_menu }}">
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
                                    <button class="btn-detail">Detail</button>
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
                                <img class="order-thumb" src="{{ $firstMenu?->path_gambar ?: 'https://api.builder.io/api/v1/image/assets/TEMP/ba6382dc578b32751a4c6e03f2066fc64f93e8ce?width=128' }}" alt="{{ $firstMenu?->nama_menu ?: 'Pesanan' }}">
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

    <script>
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