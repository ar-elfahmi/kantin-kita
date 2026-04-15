<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Your Cart — Kantin Kita</title>
    <link rel="icon" type="image/png" href="https://api.builder.io/api/v1/image/assets/TEMP/10a82c5c6d87de97d3583b6c8564df77f595f954?width=1114" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        /* ── Reset & Base ─────────────────────────────── */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --cream: #FBF5E8;
            --cream-mid: #F5EDD8;
            --brown: #744622;
            --brown-70: rgba(116, 70, 34, .70);
            --brown-60: rgba(116, 70, 34, .60);
            --brown-50: rgba(116, 70, 34, .50);
            --brown-10: rgba(116, 70, 34, .10);
            --brown-05: rgba(116, 70, 34, .05);
            --green: #42766A;
            --green-10: rgba(66, 118, 106, .10);
            --green-20: rgba(66, 118, 106, .20);
            --white: #FFFFFF;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, .05);
            --shadow-card: 0 4px 20px rgba(116, 70, 34, .08);
            --shadow-hover: 0 12px 40px rgba(116, 70, 34, .14);
            --shadow-btn: 0 4px 6px rgba(66, 118, 106, .20), 0 10px 15px rgba(66, 118, 106, .20);
            --radius-card: 24px;
            --radius-btn: 16px;
            --radius-sm: 12px;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--cream);
            color: var(--brown);
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
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

        /* ── Layout helpers ───────────────────────────── */
        .page-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container-wide {
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 32px;
        }

        /* ── Keyframe animations ──────────────────────── */
        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -400px 0;
            }

            100% {
                background-position: 400px 0;
            }
        }

        @keyframes pulseGlow {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(66, 118, 106, .3);
            }

            50% {
                box-shadow: 0 0 0 8px rgba(66, 118, 106, 0);
            }
        }

        /* ── Scroll-reveal utility ────────────────────── */
        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity .55s ease, transform .55s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ════════════════════════════════════════════════
           NAVBAR
        ═══════════════════════════════════════════════ */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255, 255, 255, .85);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            box-shadow: 0 1px 0 rgba(116, 70, 34, .08);
            height: 80px;
        }

        .navbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 80px;
        }

        /* Brand */
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon {
            width: 48px;
            height: 48px;
            background: var(--green);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .brand-icon:hover {
            transform: scale(1.08);
            box-shadow: 0 6px 18px var(--green-20);
        }

        .brand-name {
            font-size: 24px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -.5px;
            line-height: 1.3;
        }

        .brand-sub {
            font-size: 12px;
            font-weight: 400;
            color: var(--brown-60);
            letter-spacing: -.5px;
        }

        /* Nav links */
        .nav-links {
            display: flex;
            align-items: center;
            gap: 32px;
        }

        .nav-link {
            font-size: 16px;
            font-weight: 500;
            color: var(--brown-70);
            letter-spacing: -.5px;
            position: relative;
            padding-bottom: 6px;
            transition: color .2s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--green);
            transition: width .25s ease;
        }

        .nav-link:hover {
            color: var(--brown);
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-link.active {
            font-weight: 600;
            color: var(--brown);
        }

        .nav-link.active::after {
            width: 100%;
        }

        /* Nav actions */
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .notif-wrapper {
            position: relative;
        }

        .notif-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            width: 16px;
            height: 16px;
            background: var(--green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 600;
            color: #fff;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid var(--green-20);
            object-fit: cover;
            transition: transform .2s ease, border-color .2s ease;
        }

        .avatar:hover {
            transform: scale(1.05);
            border-color: var(--green);
        }

        /* ════════════════════════════════════════════════
           MAIN CONTENT
        ═══════════════════════════════════════════════ */
        .main-content {
            flex: 1;
            padding: 48px 0;
            animation: fadeIn .6s ease both;
        }

        /* Page header */
        .page-header {
            margin-bottom: 40px;
        }

        .page-header-top {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 8px;
        }

        .back-btn {
            width: 40px;
            height: 40px;
            background: var(--white);
            border-radius: var(--radius-btn);
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform .2s ease, box-shadow .2s ease;
            flex-shrink: 0;
        }

        .back-btn:hover {
            transform: translateX(-3px);
            box-shadow: 0 4px 12px rgba(116, 70, 34, .12);
        }

        .page-title {
            font-size: 36px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -.5px;
            line-height: 1.1;
        }

        .page-subtitle {
            font-size: 16px;
            color: var(--brown-60);
            letter-spacing: -.5px;
        }

        .page-subtitle strong {
            font-weight: 600;
            color: var(--brown);
        }

        /* Two-column layout */
        .checkout-grid {
            display: grid;
            grid-template-columns: 1fr 424px;
            gap: 32px;
            align-items: start;
        }

        /* ── Cards ──────────────────────────────────── */
        .card {
            background: var(--white);
            border-radius: var(--radius-card);
            box-shadow: var(--shadow-card);
            transition: box-shadow .3s ease, transform .3s ease;
        }

        .card:hover {
            box-shadow: var(--shadow-hover);
        }

        /* ── Cart items column ──────────────────────── */
        .cart-column {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .cart-items-list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* Vendor info */
        .vendor-card {
            padding: 24px;
        }

        .vendor-inner {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .vendor-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--green) 0%, rgba(66, 118, 106, .7) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .vendor-details {
            flex: 1;
        }

        .vendor-name {
            font-size: 20px;
            font-weight: 600;
            color: var(--brown);
            letter-spacing: -.5px;
        }

        .vendor-meta {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-top: 4px;
        }

        .vendor-rating {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 14px;
            font-weight: 500;
        }

        .star-icon {
            color: #EAB308;
        }

        .vendor-location {
            font-size: 14px;
            color: var(--brown-60);
        }

        .open-badge {
            padding: 8px 16px;
            border-radius: var(--radius-btn);
            background: var(--green-10);
            font-size: 14px;
            font-weight: 600;
            color: var(--green);
            letter-spacing: -.5px;
            flex-shrink: 0;
        }

        /* Cart item card */
        .cart-item-card {
            padding: 24px;
            overflow: hidden;
        }

        .cart-item-body {
            display: flex;
            align-items: flex-start;
            gap: 20px;
        }

        .cart-item-img-wrap {
            width: 112px;
            height: 112px;
            border-radius: 16px;
            background: var(--cream-mid);
            overflow: hidden;
            flex-shrink: 0;
            position: relative;
        }

        .cart-item-img-wrap::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 60%, rgba(116, 70, 34, .08));
            pointer-events: none;
        }

        .cart-item-photo {
            width: 112px;
            height: 112px;
            object-fit: cover;
            transition: transform .4s ease;
        }

        .cart-item-card:hover .cart-item-photo {
            transform: scale(1.06);
        }

        .cart-item-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .cart-item-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .cart-item-meta {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .cart-item-name {
            font-size: 18px;
            font-weight: 600;
            color: var(--brown);
            letter-spacing: -.5px;
        }

        .cart-item-desc {
            font-size: 14px;
            color: var(--brown-60);
            letter-spacing: -.5px;
        }

        .remove-btn {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-sm);
            background: var(--brown-05);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .2s ease, transform .2s ease;
            flex-shrink: 0;
        }

        .remove-btn:hover {
            background: rgba(220, 38, 38, .1);
            transform: scale(1.1);
        }

        .cart-item-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Quantity stepper */
        .qty-stepper {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--cream-mid);
            border-radius: var(--radius-btn);
            padding: 6px;
        }

        .qty-btn {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform .15s ease, box-shadow .15s ease;
        }

        .qty-btn:hover {
            transform: scale(1.12);
        }

        .qty-btn-minus {
            background: var(--white);
        }

        .qty-btn-plus {
            background: var(--green);
        }

        .qty-value {
            font-size: 16px;
            font-weight: 600;
            color: var(--brown);
            text-align: center;
            min-width: 32px;
        }

        /* Price display */
        .item-price-block {
            text-align: right;
        }

        .item-price {
            font-size: 20px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -.5px;
        }

        .item-unit-price {
            font-size: 12px;
            color: var(--brown-50);
            letter-spacing: -.5px;
        }

        /* Special instructions */
        .instructions-block {
            padding-top: 17px;
            border-top: 1px solid rgba(116, 70, 34, .05);
            margin-top: 0;
        }

        .instructions-label {
            font-size: 14px;
            font-weight: 500;
            color: var(--brown-70);
            letter-spacing: -.5px;
            margin-bottom: 8px;
        }

        .instructions-input {
            width: 100%;
            padding: 12px 16px;
            border-radius: var(--radius-btn);
            background: var(--cream-mid);
            border: 1.5px solid transparent;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            color: var(--brown);
            letter-spacing: -.5px;
            transition: border-color .2s ease, box-shadow .2s ease;
            outline: none;
        }

        .instructions-input::placeholder {
            color: var(--brown-50);
        }

        .instructions-input:focus {
            border-color: var(--green-20);
            box-shadow: 0 0 0 3px rgba(66, 118, 106, .1);
        }

        /* Add more button */
        .add-more-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: 100%;
            padding: 26px;
            border-radius: var(--radius-card);
            border: 2px dashed rgba(116, 70, 34, .20);
            background: var(--cream-mid);
            font-size: 16px;
            font-weight: 600;
            color: var(--brown);
            letter-spacing: -.5px;
            cursor: pointer;
            transition: background .25s ease, border-color .25s ease, transform .2s ease;
        }

        .add-more-btn:hover {
            background: #EEE4CB;
            border-color: rgba(116, 70, 34, .35);
            transform: translateY(-2px);
        }

        .add-more-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-btn);
            background: var(--green-10);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ════════════════════════════════════════════════
           ORDER SUMMARY (right column)
        ═══════════════════════════════════════════════ */
        .summary-card {
            position: sticky;
            top: 96px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .summary-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -.5px;
        }

        /* Line rows */
        .summary-rows {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .summary-row-label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 16px;
            font-weight: 400;
            color: var(--brown-70);
            letter-spacing: -.5px;
        }

        .summary-row-value {
            font-size: 16px;
            font-weight: 600;
            color: var(--brown);
            letter-spacing: -.5px;
        }

        .summary-divider {
            height: 1px;
            background: rgba(116, 70, 34, .10);
        }

        .summary-total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 4px;
        }

        .total-label {
            font-size: 16px;
            font-weight: 600;
            color: var(--brown);
            letter-spacing: -.5px;
        }

        .total-value {
            font-size: 20px;
            font-weight: 700;
            color: var(--green);
            letter-spacing: -.5px;
        }

        /* Promo code */
        .promo-row {
            display: flex;
            gap: 8px;
        }

        .promo-input {
            flex: 1;
            padding: 12px 16px;
            border-radius: var(--radius-btn);
            border: 1.5px solid var(--cream-mid);
            background: var(--white);
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            color: var(--brown);
            letter-spacing: -.5px;
            outline: none;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .promo-input::placeholder {
            color: var(--brown-50);
        }

        .promo-input:focus {
            border-color: var(--green-20);
            box-shadow: 0 0 0 3px rgba(66, 118, 106, .08);
        }

        .promo-apply-btn {
            padding: 12px 20px;
            border-radius: var(--radius-btn);
            background: var(--cream-mid);
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 600;
            color: var(--green);
            letter-spacing: -.5px;
            transition: background .2s ease, transform .15s ease;
        }

        .promo-apply-btn:hover {
            background: #E8DBBF;
            transform: scale(1.03);
        }

        /* Pickup time */
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            font-weight: 600;
            color: var(--brown);
            letter-spacing: -.5px;
        }

        .pickup-select {
            width: 100%;
            padding: 12px 16px;
            border-radius: var(--radius-btn);
            border: 1.5px solid var(--cream-mid);
            background: var(--white);
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            color: var(--brown);
            letter-spacing: -.5px;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg width='20' height='20' viewBox='0 0 20 20' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath fill-rule='evenodd' clip-rule='evenodd' d='M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z' fill='%23744622'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            cursor: pointer;
            outline: none;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .pickup-select:focus {
            border-color: var(--green-20);
            box-shadow: 0 0 0 3px rgba(66, 118, 106, .08);
        }

        /* Payment method */
        .payment-section {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .payment-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--brown);
            letter-spacing: -.5px;
        }

        .payment-options {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .payment-option {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 18px;
            border-radius: var(--radius-btn);
            border: 2px solid transparent;
            background: var(--cream-mid);
            cursor: pointer;
            transition: background .2s ease, border-color .2s ease, transform .15s ease;
        }

        .payment-option:hover {
            transform: translateY(-1px);
        }

        .payment-option.selected {
            background: var(--green-10);
            border-color: var(--green);
        }

        .payment-radio {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 1.5px solid #ccc;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: border-color .2s ease;
        }

        .payment-option.selected .payment-radio {
            border-color: #0075FF;
            background: #0075FF;
        }

        .payment-option.selected .payment-radio::after {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #fff;
        }

        .payment-label {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
        }

        .payment-name {
            font-size: 16px;
            font-weight: 500;
            color: var(--brown);
            letter-spacing: -.5px;
        }

        .wallet-balance {
            font-size: 14px;
            font-weight: 600;
            color: var(--green);
            margin-left: auto;
        }

        /* Place order button */
        .place-order-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 16px;
            border-radius: var(--radius-btn);
            background: var(--green);
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            letter-spacing: -.5px;
            box-shadow: var(--shadow-btn);
            transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
            animation: pulseGlow 3s infinite;
        }

        .place-order-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(66, 118, 106, .35), 0 16px 30px rgba(66, 118, 106, .2);
            background: #375f55;
            animation: none;
        }

        .place-order-btn:active {
            transform: translateY(0);
        }

        .order-legal {
            text-align: center;
            font-size: 12px;
            color: var(--brown-50);
            letter-spacing: -.5px;
            line-height: 1.6;
        }

        .order-legal a {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: var(--green);
            margin-top: 2px;
            transition: opacity .2s ease;
        }

        .order-legal a:hover {
            opacity: .75;
        }

        /* ════════════════════════════════════════════════
           YOU MIGHT ALSO LIKE
        ═══════════════════════════════════════════════ */
        .suggestions-section {
            margin-top: 48px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -.5px;
        }

        .view-all-link {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 16px;
            font-weight: 600;
            color: var(--green);
            letter-spacing: -.5px;
            transition: gap .2s ease;
        }

        .view-all-link:hover {
            gap: 10px;
        }

        .suggestions-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        .suggestions-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .suggestion-card {
            border-radius: var(--radius-card);
            overflow: hidden;
            cursor: pointer;
            position: relative;
        }

        .cart-item-index,
        .suggestion-index {
            display: none;
        }

        .suggestion-img-wrap {
            height: 192px;
            background: var(--cream-mid);
            overflow: hidden;
        }

        .suggestion-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .5s ease;
        }

        .suggestion-card:hover .suggestion-img {
            transform: scale(1.07);
        }

        .suggestion-card:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-4px);
        }

        .suggestion-body {
            padding: 20px;
        }

        .suggestion-name {
            font-size: 16px;
            font-weight: 600;
            color: var(--brown);
            letter-spacing: -.5px;
            margin-bottom: 4px;
        }

        .suggestion-desc {
            font-size: 14px;
            color: var(--brown-60);
            letter-spacing: -.5px;
            margin-bottom: 12px;
        }

        .suggestion-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .suggestion-price {
            font-size: 18px;
            font-weight: 700;
            color: var(--green);
            letter-spacing: -.5px;
        }

        .add-item-btn {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            background: var(--green);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .add-item-btn:hover {
            transform: scale(1.15) rotate(90deg);
            box-shadow: 0 4px 12px var(--green-20);
        }

        /* ════════════════════════════════════════════════
           FOOTER
        ═══════════════════════════════════════════════ */
        .footer {
            background: var(--white);
            margin-top: 64px;
            padding: 48px 0 0;
            border-top: 1px solid rgba(116, 70, 34, .06);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 280px 1fr 1fr 1fr;
            gap: 32px;
            padding-bottom: 40px;
        }

        .footer-brand-text {
            font-size: 14px;
            color: var(--brown-70);
            line-height: 1.6;
            letter-spacing: -.5px;
            margin-top: 12px;
        }

        .footer-col-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--brown);
            letter-spacing: -.5px;
            margin-bottom: 16px;
        }

        .footer-links {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .footer-link {
            font-size: 14px;
            color: var(--brown-70);
            letter-spacing: -.5px;
            transition: color .2s ease, padding-left .2s ease;
        }

        .footer-link:hover {
            color: var(--green);
            padding-left: 4px;
        }

        .social-icons {
            display: flex;
            gap: 10px;
            margin-top: 16px;
        }

        .social-btn {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-sm);
            background: var(--cream-mid);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .2s ease, transform .2s ease;
        }

        .social-btn:hover {
            background: var(--green-10);
            transform: translateY(-2px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(116, 70, 34, .10);
            padding: 20px 0;
            text-align: center;
            font-size: 14px;
            color: var(--brown-60);
            letter-spacing: -.5px;
        }

        /* ── Subtotal chevron button ─────────────────── */
        .subtotal-chevron {
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 16px;
            font-weight: 400;
            color: var(--brown-70);
            letter-spacing: -.5px;
            font-family: 'Poppins', sans-serif;
        }

        /* ════════════════════════════════════════════════
           RESPONSIVE
        ═══════════════════════════════════════════════ */
        @media (max-width: 1024px) {
            .checkout-grid {
                grid-template-columns: 1fr;
            }

            .summary-card {
                position: static;
            }

            .suggestions-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 640px) {
            .container-wide {
                padding: 0 16px;
            }

            .navbar {
                height: auto;
            }

            .navbar-inner {
                height: auto;
                min-height: 72px;
                padding: 10px 0;
                flex-wrap: wrap;
                row-gap: 10px;
            }

            .nav-links {
                display: flex;
                order: 3;
                width: 100%;
                gap: 8px;
                overflow-x: auto;
                white-space: nowrap;
                -webkit-overflow-scrolling: touch;
                padding-bottom: 4px;
            }

            .nav-links::-webkit-scrollbar {
                display: none;
            }

            .nav-link {
                flex: 0 0 auto;
                min-height: 34px;
                padding: 0 12px;
                border-radius: 999px;
                background: rgba(66, 118, 106, .12);
                color: var(--brown);
                font-size: 13px;
                font-weight: 600;
                line-height: 34px;
            }

            .nav-link::after {
                display: none;
            }

            .nav-link.active {
                background: var(--green);
                color: #fff;
            }

            .nav-actions {
                gap: 10px;
                margin-left: auto;
            }

            .brand-name {
                font-size: 20px;
            }

            .brand-sub {
                font-size: 10px;
            }

            .page-title {
                font-size: 28px;
            }

            .page-header-top {
                align-items: flex-start;
            }

            .vendor-inner {
                flex-direction: column;
                align-items: flex-start;
            }

            .vendor-meta {
                flex-wrap: wrap;
                gap: 10px;
            }

            .open-badge {
                align-self: flex-start;
            }

            .cart-item-card {
                padding: 16px;
                position: relative;
            }

            .cart-item-index {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                position: absolute;
                top: 10px;
                left: 10px;
                width: 24px;
                height: 24px;
                border-radius: 999px;
                background: rgba(66, 118, 106, .14);
                color: var(--green);
                font-size: 12px;
                font-weight: 700;
                z-index: 2;
            }

            .suggestions-grid {
                grid-template-columns: 1fr;
            }

            .suggestion-index {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                position: absolute;
                top: 10px;
                left: 10px;
                width: 24px;
                height: 24px;
                border-radius: 999px;
                background: rgba(255, 255, 255, .94);
                color: var(--brown);
                font-size: 12px;
                font-weight: 700;
                z-index: 2;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 18px;
                padding-bottom: 24px;
            }

            .footer {
                margin-top: 40px;
                padding: 28px 0 0;
            }

            .footer-col-title {
                margin-bottom: 10px;
                font-size: 15px;
            }

            .footer-brand-text,
            .footer-link {
                font-size: 13px;
                line-height: 1.45;
            }

            .social-icons {
                gap: 8px;
                margin-top: 12px;
            }

            .social-btn {
                width: 34px;
                height: 34px;
            }

            .footer-bottom {
                padding: 14px 0;
                font-size: 12px;
            }

            .cart-item-body {
                flex-direction: column;
            }

            .cart-item-img-wrap {
                width: 100%;
                height: 180px;
            }

            .cart-item-photo {
                width: 100%;
                height: 180px;
            }

            .cart-item-bottom {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .item-price-block {
                text-align: left;
            }

            .qty-stepper {
                width: 100%;
                justify-content: space-between;
            }

            .summary-card {
                padding: 20px;
                gap: 20px;
            }

            .place-order-btn {
                min-height: 48px;
            }
        }
    </style>
</head>

<body
    data-checkout-endpoint="/api/checkout"
    data-update-status-endpoint="/api/checkout/update-status"
    data-vendor-list-url="/vendor"
    data-menu-url-template="/vendor/__ID__/menu"
    data-server-vendor-id="{{ $vendor?->id ?? '' }}"
    data-server-vendor-name="{{ $vendor?->nama_vendor ?? '' }}"
    data-server-vendor-rating="{{ $vendor ? number_format((float) $vendor->rating, 1) : '' }}"
    data-server-vendor-lokasi="{{ $vendor?->lokasi ?? '' }}">
    <div class="page-wrapper">

        <!-- ══════════════════ NAVBAR ══════════════════ -->
        <header class="navbar">
            <div class="container-wide">
                <nav class="navbar-inner">
                    <a href="/" class="brand">
                        <div class="brand-icon">
                            <img src="https://api.builder.io/api/v1/image/assets/TEMP/10a82c5c6d87de97d3583b6c8564df77f595f954?width=1114" alt="Kantin Kita Logo" style="width:100%;height:100%;object-fit:cover;border-radius:inherit;" />
                        </div>
                        <div>
                            <div class="brand-name">Kantin Kita</div>
                            <div class="brand-sub">Campus Canteen</div>
                        </div>
                    </a>

                    <div class="nav-links">
                        <a href="/" class="nav-link">Home</a>
                        <a href="{{ route('vendor') }}" class="nav-link">Menu</a>
                        <a href="{{ route('checkout', ['vendor_id' => $vendor?->id]) }}" class="nav-link active">Cart</a>
                        <a href="{{ route('login') }}" class="nav-link">Orders</a>
                    </div>

                    <div class="nav-actions">
                        <div class="notif-wrapper">
                            <svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.74998 0C8.05858 0 7.49998.558594 7.49998 1.25V2C4.64842 2.57812 2.49998 5.10156 2.49998 8.125V8.85938C2.49998 10.6953 1.8242 12.4688.605453 13.8438L.316391 14.168C-.011734 14.5352-.0898591 15.0625.10936 15.5117C.308578 15.9609.757797 16.25 1.24998 16.25H16.25C16.7422 16.25 17.1875 15.9609 17.3906 15.5117C17.5937 15.0625 17.5117 14.5352 17.1836 14.168L16.8945 13.8438C15.6758 12.4688 15 10.6992 15 8.85938V8.125C15 5.10156 12.8515 2.57812 9.99998 2V1.25C9.99998.558594 9.44139 0 8.74998 0ZM10.5195 19.2695C10.9883 18.8008 11.25 18.1641 11.25 17.5H6.24998C6.24998 18.1641 6.5117 18.8008 6.98045 19.2695C7.4492 19.7383 8.08592 20 8.74998 20C9.41405 20 10.0508 19.7383 10.5195 19.2695Z" fill="#744622" />
                            </svg>
                            <span class="notif-badge">2</span>
                        </div>
                        <img class="avatar"
                            src="https://api.builder.io/api/v1/image/assets/TEMP/027b8f59f02131e9cd0e00db9c70ffe34d5a2a22?width=80"
                            alt="User avatar" />
                    </div>
                </nav>
            </div>
        </header>

        <!-- ══════════════════ MAIN ══════════════════ -->
        <main class="main-content">
            <div class="container-wide">

                <!-- Page header -->
                <div class="page-header reveal">
                    <div class="page-header-top">
                        <a href="{{ $vendor ? route('menu', ['id' => $vendor->id]) : route('vendor') }}" class="back-btn" aria-label="Go back" id="backToMenuBtn">
                            <svg width="14" height="14" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M.293701 7.29365C-.0969238 7.68428-.0969238 8.31865.293701 8.70928L5.2937 13.7093C5.68433 14.0999 6.3187 14.0999 6.70933 13.7093C7.09995 13.3187 7.09995 12.6843 6.70933 12.2937L3.41245 8.9999H13C13.5531 8.9999 14 8.55303 14 7.9999C14 7.44678 13.5531 6.9999 13 6.9999H3.41558L6.7062 3.70615C7.09683 3.31553 7.09683 2.68115 6.7062 2.29053C6.31558 1.8999 5.6812 1.8999 5.29058 2.29053L.290576 7.29053L.293701 7.29365Z" fill="#744622" />
                            </svg>
                        </a>
                        <h1 class="page-title">Your Cart</h1>
                    </div>
                    <p class="page-subtitle">Review your order from <strong id="vendorNameHeading">{{ $vendor?->nama_vendor ?? 'Pilih vendor' }}</strong></p>
                </div>

                <!-- Two-column checkout grid -->
                <div class="checkout-grid">

                    <!-- ── Left: Cart items ────────────────── -->
                    <div class="cart-column">

                        <div class="card vendor-card reveal">
                            <div class="vendor-inner">
                                <div class="vendor-icon">
                                    <svg width="27" height="24" viewBox="0 0 27 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M25.6688 4.86563L22.9828.614063C22.7438.234375 22.3172 0 21.8625 0H5.13752C4.68283 0 4.25627.234375 4.01721.614063L1.32658 4.86563C-.0609191 7.05938 1.16721 10.1109 3.75939 10.4625C3.94689 10.4859 4.13908 10.5 4.32658 10.5C5.55002 10.5 6.63752 9.96562 7.38283 9.14062C8.12814 9.96562 9.21564 10.5 10.4391 10.5C11.6625 10.5 12.75 9.96562 13.4953 9.14062C14.2406 9.96562 15.3281 10.5 16.5516 10.5C17.7797 10.5 18.8625 9.96562 19.6078 9.14062C20.3578 9.96562 21.4406 10.5 22.6641 10.5C22.8563 10.5 23.0438 10.4859 23.2313 10.4625C25.8328 10.1156 27.0656 7.06406 25.6735 4.86563H25.6688ZM23.4235 11.9484H23.4188C23.1703 11.9812 22.9172 12 22.6594 12C22.0781 12 21.5203 11.9109 21 11.7516V18H6.00002V11.7469C5.47502 11.9109 4.91252 12 4.33127 12C4.07346 12 3.81564 11.9812 3.56721 11.9484H3.56252C3.37033 11.9203 3.18283 11.8875 3.00002 11.8406V21C3.00002 22.6547 4.34533 24 6.00002 24H21C22.6547 24 24 22.6547 24 21V11.8406C23.8125 11.8875 23.625 11.925 23.4235 11.9484Z" fill="white" />
                                    </svg>
                                </div>
                                <div class="vendor-details">
                                    <div class="vendor-name" id="vendorNameCard">{{ $vendor?->nama_vendor ?? 'Pilih vendor' }}</div>
                                    <div class="vendor-meta">
                                        <div class="vendor-rating">
                                            <span class="star-icon">★</span>
                                            <span id="vendorRating">{{ $vendor ? number_format((float) $vendor->rating, 1) : '-' }}</span>
                                        </div>
                                        <span class="vendor-location" id="vendorLocation">{{ $vendor?->lokasi ?? 'Area Kantin UNAIR' }}</span>
                                    </div>
                                </div>
                                <div class="open-badge">Open</div>
                            </div>
                        </div>

                        <ol id="cartItemsContainer" class="cart-items-list"></ol>

                        <div class="card cart-item-card reveal" id="emptyCartCard" style="display:none;">
                            <div class="cart-item-body">
                                <div class="cart-item-info">
                                    <div class="cart-item-top">
                                        <div class="cart-item-meta">
                                            <div class="cart-item-name">Keranjang masih kosong</div>
                                            <div class="cart-item-desc">Tambahkan menu dari halaman vendor untuk melanjutkan checkout.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a class="add-more-btn reveal" id="addMoreBtn" href="{{ $vendor ? route('menu', ['id' => $vendor->id]) : route('vendor') }}">
                            <div class="add-more-icon">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.5.5C7.5-.0531 7.053-.5 6.5-.5C5.947-.5 5.5-.0531 5.5.5V5.5H.5C-.0531 5.5-.5 5.947-.5 6.5C-.5 7.053-.0531 7.5.5 7.5H5.5V12.5C5.5 13.053 5.947 13.5 6.5 13.5C7.053 13.5 7.5 13.053 7.5 12.5V7.5H12.5C13.053 7.5 13.5 7.053 13.5 6.5C13.5 5.947 13.053 5.5 12.5 5.5H7.5V.5Z" fill="#42766A" />
                                </svg>
                            </div>
                            Add More Items
                        </a>
                    </div>

                    <!-- ── Right: Order summary ─────────────── -->
                    <div>
                        <div class="card summary-card reveal">
                            <div class="summary-title">Order Summary</div>

                            <div class="summary-rows">
                                <div class="summary-row">
                                    <button class="subtotal-chevron" type="button">
                                        Subtotal (<span id="summaryItemCount">0 items</span>)
                                        <svg width="16" height="16" viewBox="0 0 30 30" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.845 10.815a.9.9 0 011.29.03L15 16.752l5.565-5.907a.9.9 0 011.275 1.26L15.81 19.155a.9.9 0 01-1.62 0L7.815 12.405a.9.9 0 01.03-1.59z" fill="#744622" />
                                        </svg>
                                    </button>
                                    <span class="summary-row-value" id="summarySubtotal">Rp 0</span>
                                </div>
                                <div class="summary-row">
                                    <span class="summary-row-label">Service Fee</span>
                                    <span class="summary-row-value" id="summaryServiceFee">Rp 0</span>
                                </div>
                                <div class="summary-row">
                                    <span class="summary-row-label">Tax</span>
                                    <span class="summary-row-value" id="summaryTax">Rp 0</span>
                                </div>
                            </div>

                            <div class="summary-divider"></div>

                            <div class="summary-total-row">
                                <span class="total-label">Total</span>
                                <span class="total-value" id="summaryTotal">Rp 0</span>
                            </div>

                            <div class="promo-row">
                                <input class="promo-input" type="text" id="customerNameInput" placeholder="Masukkan nama pemesan" />
                                <button class="promo-apply-btn" type="button">Nama</button>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8 0C10.1217 0 12.1566.842855 13.6569 2.34315C15.1571 3.84344 16 5.87827 16 8C16 10.1217 15.1571 12.1566 13.6569 13.6569C12.1566 15.1571 10.1217 16 8 16C5.87827 16 3.84344 15.1571 2.34315 13.6569C.842855 12.1566 0 10.1217 0 8C0 5.87827.842855 3.84344 2.34315 2.34315C3.84344.842855 5.87827 0 8 0ZM7.25 3.75V8C7.25 8.25 7.375 8.48438 7.58437 8.625L10.5844 10.625C10.9281 10.8562 11.3938 10.7625 11.625 10.4156C11.8562 10.0687 11.7625 9.60625 11.4156 9.375L8.75 7.6V3.75C8.75 3.33437 8.41562 3 8 3C7.58437 3 7.25 3.33437 7.25 3.75Z" fill="#42766A" />
                                    </svg>
                                    Pickup Time
                                </label>
                                <select class="pickup-select" id="pickupTimeSelect">
                                    <option value="asap">ASAP (15–20 mins)</option>
                                    <option value="30">In 30 minutes</option>
                                    <option value="45">In 45 minutes</option>
                                    <option value="60">In 1 hour</option>
                                </select>
                            </div>

                            <div class="payment-section">
                                <div class="payment-title">Payment Method</div>
                                <div class="payment-options">
                                    <label class="payment-option selected">
                                        <input type="radio" name="payment" value="midtrans" checked style="display:none" />
                                        <div class="payment-radio"></div>
                                        <div class="payment-label">
                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M2.25 1.125C1.00898 1.125 0 2.13398 0 3.375V14.625C0 15.866 1.00898 16.875 2.25 16.875H15.75C16.991 16.875 18 15.866 18 14.625V6.75C18 5.50898 16.991 4.5 15.75 4.5H2.8125C2.50312 4.5 2.25 4.24688 2.25 3.9375C2.25 3.62812 2.50312 3.375 2.8125 3.375H15.75C16.3723 3.375 16.875 2.87227 16.875 2.25C16.875 1.62773 16.3723 1.125 15.75 1.125H2.25ZM14.625 9.5625C14.9234 9.5625 15.2095 9.68103 15.4205 9.892C15.6315 10.103 15.75 10.3891 15.75 10.6875C15.75 10.9859 15.6315 11.272 15.4205 11.483C15.2095 11.694 14.9234 11.8125 14.625 11.8125C14.3266 11.8125 14.0405 11.694 13.8295 11.483C13.6185 11.272 13.5 10.9859 13.5 10.6875C13.5 10.3891 13.6185 10.103 13.8295 9.892C14.0405 9.68103 14.3266 9.5625 14.625 9.5625Z" fill="#42766A" />
                                            </svg>
                                            <span class="payment-name">Midtrans (QRIS / E-Wallet)</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <button class="place-order-btn" id="placeOrderBtn" type="button">
                                Place Order
                                <svg width="14" height="14" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.7063 8.70615C14.0969 8.31553 14.0969 7.68115 13.7063 7.29053L8.70625 2.29053C8.31563 1.8999 7.68125 1.8999 7.29063 2.29053C6.9 2.68115 6.9 3.31553 7.29063 3.70615L10.5875 6.9999H1C.446875 6.9999 0 7.44678 0 7.9999C0 8.55303.446875 8.9999 1 8.9999H10.5844L7.29375 12.2937C6.90312 12.6843 6.90312 13.3187 7.29375 13.7093C7.68437 14.0999 8.31875 14.0999 8.70938 13.7093L13.7094 8.70928L13.7063 8.70615Z" fill="white" />
                                </svg>
                            </button>

                            <div class="order-legal" id="checkoutMessage">
                                By placing order, you agree to our
                                <a href="{{ route('home') }}#contact">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ══════════════════ YOU MIGHT ALSO LIKE ══════════════════ -->
                <div class="suggestions-section">
                    <div class="section-header reveal">
                        <h2 class="section-title">You Might Also Like</h2>
                        <a href="{{ route('vendor') }}" class="view-all-link">
                            View All
                            <svg width="12" height="12" viewBox="0 0 13 14" fill="none">
                                <path d="M11.993 7.61807C12.3348 7.27627 12.3348 6.72119 11.993 6.3794L7.61797 2.00439C7.27617 1.6626 6.72109 1.6626 6.3793 2.00439C6.0375 2.34619 6.0375 2.90127 6.3793 3.24307L9.26406 6.1251H.875C.391016 6.1251 0 6.51611 0 7.0001C0 7.48408.391016 7.8751.875 7.8751H9.26133L6.38203 10.7571C6.04023 11.0989 6.04023 11.654 6.38203 11.9958C6.72383 12.3376 7.27891 12.3376 7.6207 11.9958L11.9957 7.6208L11.993 7.61807Z" fill="#42766A" />
                            </svg>
                        </a>
                    </div>

                    <ol class="suggestions-grid suggestions-list">
                        <!-- Bakso Komplit -->
                        <li class="card suggestion-card reveal">
                            <span class="suggestion-index">1</span>
                            <div class="suggestion-img-wrap">
                                <img class="suggestion-img"
                                    src="https://api.builder.io/api/v1/image/assets/TEMP/495775340130bd90fafed33c09c9a6c05e6c41e5?width=572"
                                    alt="Bakso Komplit" />
                            </div>
                            <div class="suggestion-body">
                                <div class="suggestion-name">Bakso Komplit</div>
                                <div class="suggestion-desc">Meatball soup special</div>
                                <div class="suggestion-footer">
                                    <span class="suggestion-price">Rp 15.000</span>
                                    <button class="add-item-btn" aria-label="Add Bakso Komplit to cart">
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                            <path d="M6.875.6875C6.875.203516 6.48398-.1875 6-.1875C5.51602-.1875 5.125.203516 5.125.6875V5.25H.5625C.078516 5.25-.3125 5.641-.3125 6.125C-.3125 6.609.078516 7 .5625 7H5.125V11.5625C5.125 12.0465 5.51602 12.4375 6 12.4375C6.48398 12.4375 6.875 12.0465 6.875 11.5625V7H10.5625C11.0465 7 11.4375 6.609 11.4375 6.125C11.4375 5.641 11.0465 5.25 10.5625 5.25H6.875V.6875Z" fill="white" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </li>

                        <!-- Gado-Gado -->
                        <li class="card suggestion-card reveal">
                            <span class="suggestion-index">2</span>
                            <div class="suggestion-img-wrap">
                                <img class="suggestion-img"
                                    src="https://api.builder.io/api/v1/image/assets/TEMP/ae58ea381450ff2555d5325e463f7d95a41ae88a?width=572"
                                    alt="Gado-Gado" />
                            </div>
                            <div class="suggestion-body">
                                <div class="suggestion-name">Gado-Gado</div>
                                <div class="suggestion-desc">Mixed vegetable salad</div>
                                <div class="suggestion-footer">
                                    <span class="suggestion-price">Rp 12.000</span>
                                    <button class="add-item-btn" aria-label="Add Gado-Gado to cart">
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                            <path d="M6.875.6875C6.875.203516 6.48398-.1875 6-.1875C5.51602-.1875 5.125.203516 5.125.6875V5.25H.5625C.078516 5.25-.3125 5.641-.3125 6.125C-.3125 6.609.078516 7 .5625 7H5.125V11.5625C5.125 12.0465 5.51602 12.4375 6 12.4375C6.48398 12.4375 6.875 12.0465 6.875 11.5625V7H10.5625C11.0465 7 11.4375 6.609 11.4375 6.125C11.4375 5.641 11.0465 5.25 10.5625 5.25H6.875V.6875Z" fill="white" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </li>

                        <!-- Pisang Goreng -->
                        <li class="card suggestion-card reveal">
                            <span class="suggestion-index">3</span>
                            <div class="suggestion-img-wrap">
                                <img class="suggestion-img"
                                    src="https://api.builder.io/api/v1/image/assets/TEMP/663335b04797e845e7a9041874c258b14fd8e919?width=572"
                                    alt="Pisang Goreng" />
                            </div>
                            <div class="suggestion-body">
                                <div class="suggestion-name">Pisang Goreng</div>
                                <div class="suggestion-desc">Crispy fried banana</div>
                                <div class="suggestion-footer">
                                    <span class="suggestion-price">Rp 8.000</span>
                                    <button class="add-item-btn" aria-label="Add Pisang Goreng to cart">
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                            <path d="M6.875.6875C6.875.203516 6.48398-.1875 6-.1875C5.51602-.1875 5.125.203516 5.125.6875V5.25H.5625C.078516 5.25-.3125 5.641-.3125 6.125C-.3125 6.609.078516 7 .5625 7H5.125V11.5625C5.125 12.0465 5.51602 12.4375 6 12.4375C6.48398 12.4375 6.875 12.0465 6.875 11.5625V7H10.5625C11.0465 7 11.4375 6.609 11.4375 6.125C11.4375 5.641 11.0465 5.25 10.5625 5.25H6.875V.6875Z" fill="white" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </li>

                        <!-- Es Jeruk Segar -->
                        <li class="card suggestion-card reveal">
                            <span class="suggestion-index">4</span>
                            <div class="suggestion-img-wrap">
                                <img class="suggestion-img"
                                    src="https://api.builder.io/api/v1/image/assets/TEMP/4adc7c1a7549ef3d9fb199db079b10f322afee23?width=572"
                                    alt="Es Jeruk Segar" />
                            </div>
                            <div class="suggestion-body">
                                <div class="suggestion-name">Es Jeruk Segar</div>
                                <div class="suggestion-desc">Fresh orange juice</div>
                                <div class="suggestion-footer">
                                    <span class="suggestion-price">Rp 5.000</span>
                                    <button class="add-item-btn" aria-label="Add Es Jeruk Segar to cart">
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                            <path d="M6.875.6875C6.875.203516 6.48398-.1875 6-.1875C5.51602-.1875 5.125.203516 5.125.6875V5.25H.5625C.078516 5.25-.3125 5.641-.3125 6.125C-.3125 6.609.078516 7 .5625 7H5.125V11.5625C5.125 12.0465 5.51602 12.4375 6 12.4375C6.48398 12.4375 6.875 12.0465 6.875 11.5625V7H10.5625C11.0465 7 11.4375 6.609 11.4375 6.125C11.4375 5.641 11.0465 5.25 10.5625 5.25H6.875V.6875Z" fill="white" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </li>
                    </ol>
                </div>

            </div><!-- /container-wide -->
        </main>

        <!-- ══════════════════ FOOTER ══════════════════ -->
        <footer class="footer">
            <div class="container-wide">
                <div class="footer-grid">
                    <!-- Brand -->
                    <div>
                        <a href="/" class="brand">
                            <div class="brand-icon">
                                <img src="https://api.builder.io/api/v1/image/assets/TEMP/10a82c5c6d87de97d3583b6c8564df77f595f954?width=1114" alt="Kantin Kita Logo" style="width:100%;height:100%;object-fit:cover;border-radius:inherit;" />
                            </div>
                            <div>
                                <div class="brand-name" style="font-size:20px">Kantin Kita</div>
                                <div class="brand-sub">Campus Canteen</div>
                            </div>
                        </a>
                        <p class="footer-brand-text">Delicious meals for our campus community, made with love and care.</p>
                        <div class="social-icons">
                            <a href="{{ route('home') }}" class="social-btn" aria-label="Instagram">
                                <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.00303 4.40635C5.01553 4.40635 3.4124 6.00947 3.4124 7.99697C3.4124 9.98447 5.01553 11.5876 7.00303 11.5876C8.99053 11.5876 10.5937 9.98447 10.5937 7.99697C10.5937 6.00947 8.99053 4.40635 7.00303 4.40635ZM13.9562 5.10947C13.903 3.9876 13.6468 2.99385 12.8249 2.1751C12.0062 1.35635 11.0124 1.1001 9.89053 1.04385C8.73428.978223 5.26865.978223 4.1124 1.04385C2.99365 1.09697 1.9999 1.35322 1.17803 2.17197C.356152 2.99072.103027 3.98447.0467773 5.10635C-.0188477 6.2626-.0188477 9.72822.0467773 10.8845C.0999023 12.0063.356152 13.0001 1.17803 13.8188C1.9999 14.6376 2.99053 14.8938 4.1124 14.9501C5.26865 15.0157 8.73428 15.0157 9.89053 14.9501C11.0124 14.897 12.0062 14.6407 12.8249 13.8188C13.6437 13.0001 13.8999 12.0063 13.9562 10.8845C14.0218 9.72822 14.0218 6.26572 13.9562 5.10947Z" fill="#744622" />
                                </svg>
                            </a>
                            <a href="{{ route('home') }}" class="social-btn" aria-label="Facebook">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.75 8C15.75 3.71875 12.2812.25 8 .25C3.71875.25.25 3.71875.25 8C.25 11.8681 3.08406 15.0744 6.78906 15.6562V10.2403H4.82031V8H6.78906V6.2925C6.78906 4.35031 7.94531 3.2775 9.71625 3.2775C10.5644 3.2775 11.4513 3.42875 11.4513 3.42875V5.335H10.4738C9.51125 5.335 9.21094 5.9325 9.21094 6.54531V8H11.3603L11.0166 10.2403H9.21094V15.6562C12.9159 15.0744 15.75 11.8681 15.75 8Z" fill="#744622" />
                                </svg>
                            </a>
                            <a href="{{ route('home') }}" class="social-btn" aria-label="Twitter">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M14.3553 4.741C14.3655 4.88313 14.3655 5.02529 14.3655 5.16741C14.3655 9.50241 11.066 14.4973 5.03553 14.4973C3.17766 14.4973 1.45178 13.9593 0 13.0253C.263969 13.0557.51775 13.0659.791875 13.0659C2.32484 13.0659 3.73603 12.5481 4.86294 11.6649C3.42131 11.6344 2.21319 10.6903 1.79694 9.39075C2 9.42119 2.20303 9.4415 2.41625 9.4415C2.71066 9.4415 3.00509 9.40088 3.27919 9.32985C1.77666 9.02525.649719 7.70547.649719 6.11157V6.07097C1.08625 6.31463 1.59391 6.46691 2.13194 6.48719C1.24869 5.89835.670031 4.89329.670031 3.75622C.670031 3.1471.832438 2.58872 1.11672 2.10141C2.73094 4.09125 5.15734 5.39072 7.87813 5.53288C7.82738 5.28922 7.79691 5.03544 7.79691 4.78163C7.79691 2.9745 9.25884 1.50244 11.0761 1.50244C12.0203 1.50244 12.873 1.89838 13.472 2.53797C14.2131 2.39585 14.9238 2.12172 15.5533 1.7461C15.3096 2.50754 14.7918 3.14713 14.1116 3.55319C14.7715 3.48216 15.4111 3.29938 15.9999 3.0456C15.5533 3.69532 14.9949 4.27397 14.3553 4.741Z" fill="#744622" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <div class="footer-col-title">Quick Links</div>
                        <div class="footer-links">
                            <a href="{{ route('home') }}" class="footer-link">Home</a>
                            <a href="{{ route('vendor') }}" class="footer-link">Menu</a>
                            <a href="{{ route('login') }}" class="footer-link">My Orders</a>
                            <a href="{{ route('login') }}" class="footer-link">Profile</a>
                        </div>
                    </div>

                    <!-- Support -->
                    <div>
                        <div class="footer-col-title">Support</div>
                        <div class="footer-links">
                            <a href="{{ route('home') }}#contact" class="footer-link">Help Center</a>
                            <a href="{{ route('home') }}#contact" class="footer-link">Terms &amp; Conditions</a>
                            <a href="{{ route('home') }}#contact" class="footer-link">Privacy Policy</a>
                            <a href="{{ route('home') }}#contact" class="footer-link">Contact Us</a>
                        </div>
                    </div>

                    <!-- Connect -->
                    <div>
                        <div class="footer-col-title">Connect With Us</div>
                        <p style="font-size:14px;color:rgba(116,70,34,.7);letter-spacing:-.5px;line-height:1.6;">
                            Follow us for daily specials and canteen updates.
                        </p>
                    </div>
                </div>

                <div class="footer-bottom">
                    &copy; 2024 Kantin Kita. All rights reserved.
                </div>
            </div>
        </footer>

    </div><!-- /page-wrapper -->

    @if (config('midtrans.client_key'))
    <script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
    @endif
    <script>
        const CART_KEY = 'kantin_cart';
        const CUSTOMER_NAME_KEY = 'kantin_customer_name';
        const PICKUP_TIME_KEY = 'kantin_pickup_time';
        const CHECKOUT_ENDPOINT = document.body.dataset.checkoutEndpoint || '/api/checkout';
        const UPDATE_STATUS_ENDPOINT = document.body.dataset.updateStatusEndpoint || '/api/checkout/update-status';
        const VENDOR_LIST_URL = document.body.dataset.vendorListUrl || '/vendor';
        const MENU_URL_TEMPLATE = document.body.dataset.menuUrlTemplate || '/vendor/__ID__/menu';
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const DEFAULT_MENU_IMAGE = 'https://images.pexels.com/photos/1640774/pexels-photo-1640774.jpeg?auto=compress&cs=tinysrgb&w=224&h=224&fit=crop';

        const serverVendorId = Number(document.body.dataset.serverVendorId || 0);
        const serverVendor = serverVendorId > 0 ? {
            id: serverVendorId,
            nama_vendor: document.body.dataset.serverVendorName || 'Vendor',
            rating: document.body.dataset.serverVendorRating || '-',
            lokasi: document.body.dataset.serverVendorLokasi || 'Area Kantin UNAIR',
        } : null;

        const state = {
            cart: null,
        };

        function formatRupiah(value) {
            return 'Rp ' + Number(value || 0).toLocaleString('id-ID');
        }

        function escapeHtml(text) {
            return String(text || '')
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');
        }

        function parseCart() {
            try {
                const raw = localStorage.getItem(CART_KEY);
                if (!raw) {
                    return null;
                }

                const parsed = JSON.parse(raw);
                if (!parsed || !Array.isArray(parsed.items)) {
                    return null;
                }

                return {
                    vendor_id: parsed.vendor_id ? Number(parsed.vendor_id) : null,
                    vendor_name: parsed.vendor_name || '',
                    items: parsed.items.map((item) => ({
                        menu_id: Number(item.menu_id),
                        nama_menu: item.nama_menu || 'Menu',
                        harga: Number(item.harga || 0),
                        jumlah: Math.max(1, Number(item.jumlah || 1)),
                        catatan: item.catatan || '',
                        path_gambar: item.path_gambar || '',
                    })).filter((item) => Number.isFinite(item.menu_id) && item.menu_id > 0),
                };
            } catch (error) {
                return null;
            }
        }

        function getDefaultCart() {
            return {
                vendor_id: serverVendor ? Number(serverVendor.id) : null,
                vendor_name: serverVendor ? serverVendor.nama_vendor : '',
                items: [],
            };
        }

        function persistCart() {
            localStorage.setItem(CART_KEY, JSON.stringify(state.cart));
        }

        function menuUrlByVendor(vendorId) {
            return MENU_URL_TEMPLATE.replace('__ID__', String(vendorId));
        }

        function resolveVendorContext() {
            if (state.cart?.vendor_id) {
                const sameAsServer = serverVendor && Number(serverVendor.id) === Number(state.cart.vendor_id);
                return {
                    id: Number(state.cart.vendor_id),
                    nama_vendor: state.cart.vendor_name || serverVendor?.nama_vendor || 'Vendor',
                    rating: sameAsServer ? serverVendor.rating : '-',
                    lokasi: sameAsServer ? (serverVendor.lokasi || 'Area Kantin UNAIR') : 'Area Kantin UNAIR',
                };
            }

            if (serverVendor) {
                return {
                    id: Number(serverVendor.id),
                    nama_vendor: serverVendor.nama_vendor,
                    rating: serverVendor.rating,
                    lokasi: serverVendor.lokasi || 'Area Kantin UNAIR',
                };
            }

            return {
                id: null,
                nama_vendor: 'Pilih vendor',
                rating: '-',
                lokasi: 'Area Kantin UNAIR',
            };
        }

        function setCheckoutMessage(message, isError = false) {
            const messageEl = document.getElementById('checkoutMessage');
            if (!messageEl) {
                return;
            }

            messageEl.textContent = message;
            messageEl.style.color = isError ? '#B91C1C' : 'rgba(116,70,34,.7)';
        }

        function renderVendorHeader() {
            const vendor = resolveVendorContext();
            const menuUrl = vendor.id ? menuUrlByVendor(vendor.id) : VENDOR_LIST_URL;

            document.getElementById('vendorNameHeading').textContent = vendor.nama_vendor;
            document.getElementById('vendorNameCard').textContent = vendor.nama_vendor;
            document.getElementById('vendorRating').textContent = vendor.rating;
            document.getElementById('vendorLocation').textContent = vendor.lokasi;

            document.getElementById('addMoreBtn').setAttribute('href', menuUrl);
            document.getElementById('backToMenuBtn').setAttribute('href', menuUrl);
        }

        function updateSummary() {
            const items = state.cart.items;
            const qty = items.reduce((sum, item) => sum + Number(item.jumlah), 0);
            const subtotal = items.reduce((sum, item) => sum + Number(item.harga) * Number(item.jumlah), 0);
            const serviceFee = 0;
            const tax = 0;
            const total = subtotal + serviceFee + tax;

            document.getElementById('summaryItemCount').textContent = `${qty} item${qty === 1 ? '' : 's'}`;
            document.getElementById('summarySubtotal').textContent = formatRupiah(subtotal);
            document.getElementById('summaryServiceFee').textContent = formatRupiah(serviceFee);
            document.getElementById('summaryTax').textContent = formatRupiah(tax);
            document.getElementById('summaryTotal').textContent = formatRupiah(total);

            return {
                qty,
                subtotal,
                total,
            };
        }

        function renderCartItems() {
            const container = document.getElementById('cartItemsContainer');
            const emptyCard = document.getElementById('emptyCartCard');
            const placeOrderBtn = document.getElementById('placeOrderBtn');

            if (!state.cart.items.length) {
                container.innerHTML = '';
                emptyCard.style.display = 'block';
                placeOrderBtn.disabled = true;
                placeOrderBtn.style.opacity = '0.6';
            } else {
                emptyCard.style.display = 'none';
                placeOrderBtn.disabled = false;
                placeOrderBtn.style.opacity = '1';

                container.innerHTML = state.cart.items.map((item, index) => {
                    const subtotal = Number(item.harga) * Number(item.jumlah);

                    return `
                        <li class="card cart-item-card reveal visible" data-menu-id="${item.menu_id}">
                            <span class="cart-item-index">${index + 1}</span>
                            <div class="cart-item-body">
                                <div class="cart-item-img-wrap">
                                    <img class="cart-item-photo" src="${escapeHtml(item.path_gambar || DEFAULT_MENU_IMAGE)}" alt="${escapeHtml(item.nama_menu)}" />
                                </div>
                                <div class="cart-item-info">
                                    <div class="cart-item-top">
                                        <div class="cart-item-meta">
                                            <div class="cart-item-name">${escapeHtml(item.nama_menu)}</div>
                                            <div class="cart-item-desc">Menu pilihan Anda</div>
                                        </div>
                                        <button class="remove-btn" type="button" data-action="remove" aria-label="Remove item">
                                            <svg width="13" height="14" viewBox="0 0 13 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M3.69687.483984L3.5.875H.875C.391016.875 0 1.26602 0 1.75C0 2.23398.391016 2.625.875 2.625H11.375C11.859 2.625 12.25 2.23398 12.25 1.75C12.25 1.26602 11.859.875 11.375.875H8.75L8.55312.483984C8.40547.185938 8.10195 0 7.77109 0H4.47891C4.14805 0 3.84453.185938 3.69687.483984ZM11.375 3.5H.875L1.45469 12.7695C1.49844 13.4613 2.07266 14 2.76445 14H9.48555C10.1773 14 10.7516 13.4613 10.7953 12.7695L11.375 3.5Z" fill="#744622" fill-opacity="0.6" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="cart-item-bottom">
                                        <div class="qty-stepper">
                                            <button class="qty-btn qty-btn-minus" type="button" data-action="decrease" aria-label="Decrease quantity">
                                                <svg width="12" height="2" viewBox="0 0 12 2" fill="none">
                                                    <path d="M11.375 1C11.375 1.48398 10.984 1.875 10.5 1.875H.875C.391016 1.875 0 1.48398 0 1C0 .516016.391016.125.875.125H10.5C10.984.125 11.375.516016 11.375 1Z" fill="black" />
                                                </svg>
                                            </button>
                                            <span class="qty-value">${item.jumlah}</span>
                                            <button class="qty-btn qty-btn-plus" type="button" data-action="increase" aria-label="Increase quantity">
                                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                                    <path d="M6.875.6875C6.875.203516 6.48398-.1875 6-.1875C5.51602-.1875 5.125.203516 5.125.6875V5.25H.5625C.078516 5.25-.3125 5.641-.3125 6.125C-.3125 6.609.078516 7 .5625 7H5.125V11.5625C5.125 12.0465 5.51602 12.4375 6 12.4375C6.48398 12.4375 6.875 12.0465 6.875 11.5625V7H10.5625C11.0465 7 11.4375 6.609 11.4375 6.125C11.4375 5.641 11.0465 5.25 10.5625 5.25H6.875V.6875Z" fill="white" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="item-price-block">
                                            <div class="item-price">${formatRupiah(subtotal)}</div>
                                            <div class="item-unit-price">${formatRupiah(item.harga)} each</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="instructions-block">
                                <div class="instructions-label">Special Instructions:</div>
                                <input class="instructions-input" type="text" data-action="note" value="${escapeHtml(item.catatan || '')}" placeholder="Add notes (e.g., less spicy, no onions)" />
                            </div>
                        </li>
                    `;
                }).join('');
            }

            updateSummary();
            renderVendorHeader();
        }

        function updateItem(menuId, updater) {
            const index = state.cart.items.findIndex((item) => Number(item.menu_id) === Number(menuId));
            if (index < 0) {
                return;
            }

            updater(state.cart.items[index], index);
            state.cart.items = state.cart.items.filter((item) => Number(item.jumlah) > 0);
            persistCart();
            renderCartItems();
        }

        function updateItemNote(menuId, noteValue) {
            const item = state.cart.items.find((entry) => Number(entry.menu_id) === Number(menuId));
            if (!item) {
                return;
            }

            item.catatan = noteValue;
            persistCart();
        }

        async function updatePaymentStatus(pesananId, status, result) {
            try {
                await fetch(UPDATE_STATUS_ENDPOINT, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                    },
                    body: JSON.stringify({
                        pesanan_id: pesananId,
                        transaction_id: result?.transaction_id || null,
                        payment_type: result?.payment_type || null,
                        status,
                        result,
                    }),
                });
            } catch (error) {
                // Keep UI responsive even if status callback fails.
            }
        }

        async function handleCheckout() {
            const placeOrderBtn = document.getElementById('placeOrderBtn');
            const customerNameInput = document.getElementById('customerNameInput');
            const pickupTimeSelect = document.getElementById('pickupTimeSelect');
            const vendor = resolveVendorContext();

            const customerName = (customerNameInput.value || '').trim();
            const pickupTime = (pickupTimeSelect?.value || '').trim();
            if (!customerName) {
                setCheckoutMessage('Nama pemesan wajib diisi.', true);
                customerNameInput.focus();
                return;
            }

            if (!state.cart.items.length || !vendor.id) {
                setCheckoutMessage('Keranjang kosong atau vendor belum dipilih.', true);
                return;
            }

            if (typeof window.snap === 'undefined') {
                setCheckoutMessage('Midtrans Snap belum terkonfigurasi. Periksa MIDTRANS_CLIENT_KEY.', true);
                return;
            }

            const payload = {
                nama_customer: customerName,
                vendor_id: Number(vendor.id),
                waktu_pengambilan: pickupTime || null,
                items: state.cart.items.map((item) => ({
                    menu_id: Number(item.menu_id),
                    jumlah: Number(item.jumlah),
                    catatan: item.catatan || null,
                })),
            };

            placeOrderBtn.disabled = true;
            placeOrderBtn.style.opacity = '0.6';
            const originalLabel = placeOrderBtn.innerHTML;
            placeOrderBtn.innerHTML = 'Processing...';
            setCheckoutMessage('Mempersiapkan pembayaran...');

            try {
                localStorage.setItem(CUSTOMER_NAME_KEY, customerName);
                if (pickupTime) {
                    localStorage.setItem(PICKUP_TIME_KEY, pickupTime);
                }

                const response = await fetch(CHECKOUT_ENDPOINT, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                    },
                    body: JSON.stringify(payload),
                });

                const data = await response.json();
                if (!response.ok) {
                    throw new Error(data.message || 'Checkout gagal diproses.');
                }

                const pesananId = data.pesanan_id;
                window.snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        updatePaymentStatus(pesananId, 'success', result).finally(() => {
                            localStorage.removeItem(CART_KEY);
                            state.cart = getDefaultCart();
                            renderCartItems();
                            setCheckoutMessage('Pembayaran berhasil. Pesanan Anda sedang diproses.');
                            placeOrderBtn.disabled = false;
                            placeOrderBtn.style.opacity = '1';
                            placeOrderBtn.innerHTML = originalLabel;
                        });
                    },
                    onPending: function(result) {
                        updatePaymentStatus(pesananId, 'pending', result).finally(() => {
                            setCheckoutMessage('Pembayaran pending. Selesaikan pembayaran untuk memproses pesanan.');
                            placeOrderBtn.disabled = false;
                            placeOrderBtn.style.opacity = '1';
                            placeOrderBtn.innerHTML = originalLabel;
                        });
                    },
                    onError: function(result) {
                        updatePaymentStatus(pesananId, 'error', result).finally(() => {
                            setCheckoutMessage('Pembayaran gagal. Silakan coba lagi.', true);
                            placeOrderBtn.disabled = false;
                            placeOrderBtn.style.opacity = '1';
                            placeOrderBtn.innerHTML = originalLabel;
                        });
                    },
                    onClose: function() {
                        setCheckoutMessage('Pembayaran dibatalkan sebelum selesai.', true);
                        placeOrderBtn.disabled = false;
                        placeOrderBtn.style.opacity = '1';
                        placeOrderBtn.innerHTML = originalLabel;
                    },
                });
            } catch (error) {
                setCheckoutMessage(error.message || 'Terjadi kesalahan saat checkout.', true);
                placeOrderBtn.disabled = false;
                placeOrderBtn.style.opacity = '1';
                placeOrderBtn.innerHTML = originalLabel;
            }
        }

        function initScrollReveal() {
            const revealEls = document.querySelectorAll('.reveal');
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => entry.target.classList.add('visible'), index * 60);
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.12,
            });

            revealEls.forEach((el) => revealObserver.observe(el));
        }

        function initPaymentToggle() {
            document.querySelectorAll('.payment-option').forEach((option) => {
                option.addEventListener('click', () => {
                    document.querySelectorAll('.payment-option').forEach((item) => item.classList.remove('selected'));
                    option.classList.add('selected');
                    const input = option.querySelector('input[type=radio]');
                    if (input) {
                        input.checked = true;
                    }
                });
            });
        }

        function initCartActions() {
            const container = document.getElementById('cartItemsContainer');

            container.addEventListener('click', (event) => {
                const actionButton = event.target.closest('[data-action]');
                if (!actionButton) {
                    return;
                }

                const card = actionButton.closest('[data-menu-id]');
                if (!card) {
                    return;
                }

                const menuId = Number(card.dataset.menuId);
                const action = actionButton.dataset.action;

                if (action === 'remove') {
                    updateItem(menuId, (item) => {
                        item.jumlah = 0;
                    });
                }

                if (action === 'increase') {
                    updateItem(menuId, (item) => {
                        item.jumlah = Number(item.jumlah) + 1;
                    });
                }

                if (action === 'decrease') {
                    updateItem(menuId, (item) => {
                        item.jumlah = Math.max(1, Number(item.jumlah) - 1);
                    });
                }
            });

            container.addEventListener('input', (event) => {
                const noteInput = event.target.closest('input[data-action="note"]');
                if (!noteInput) {
                    return;
                }

                const card = noteInput.closest('[data-menu-id]');
                if (!card) {
                    return;
                }

                const menuId = Number(card.dataset.menuId);
                updateItemNote(menuId, noteInput.value);
            });
        }

        function initSuggestionButtons() {
            document.querySelectorAll('.add-item-btn').forEach((button) => {
                button.addEventListener('click', function() {
                    this.style.background = '#2d5248';
                    setTimeout(() => {
                        this.style.background = '';
                    }, 300);
                });
            });
        }

        function initCustomerName() {
            const input = document.getElementById('customerNameInput');
            const cachedName = localStorage.getItem(CUSTOMER_NAME_KEY);
            if (input && cachedName) {
                input.value = cachedName;
            }
        }

        function initPickupTime() {
            const select = document.getElementById('pickupTimeSelect');
            const cachedPickupTime = localStorage.getItem(PICKUP_TIME_KEY);
            if (select && cachedPickupTime) {
                const hasOption = Array.from(select.options).some((option) => option.value === cachedPickupTime);
                if (hasOption) {
                    select.value = cachedPickupTime;
                }
            }
        }

        function init() {
            state.cart = parseCart() || getDefaultCart();
            renderCartItems();
            initScrollReveal();
            initPaymentToggle();
            initCartActions();
            initSuggestionButtons();
            initCustomerName();
            initPickupTime();

            document.getElementById('placeOrderBtn').addEventListener('click', handleCheckout);
        }

        init();
    </script>
</body>

</html>