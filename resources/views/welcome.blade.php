<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kantin Kita — Pesan Makanan Tanpa Antri</title>
    <link rel="icon" type="image/png" href="https://api.builder.io/api/v1/image/assets/TEMP/10a82c5c6d87de97d3583b6c8564df77f595f954?width=1114">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --cream: #FBF5E8;
            --cream-dark: #F5EDD9;
            --brown: #744622;
            --brown-60: rgba(116, 70, 34, 0.60);
            --brown-70: rgba(116, 70, 34, 0.70);
            --brown-80: rgba(116, 70, 34, 0.80);
            --brown-10: rgba(116, 70, 34, 0.10);
            --green: #42766A;
            --green-dark: #2F5A4F;
            --green-10: rgba(66, 118, 106, 0.10);
            --green-20: rgba(66, 118, 106, 0.20);
            --white: #FFFFFF;
            --shadow-sm: 0 4px 6px rgba(0, 0, 0, 0.07), 0 10px 15px rgba(0, 0, 0, 0.07);
            --shadow-md: 0 10px 30px rgba(0, 0, 0, 0.12);
            --shadow-lg: 0 25px 50px rgba(0, 0, 0, 0.18);
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', -apple-system, sans-serif;
            background: var(--cream);
            color: var(--brown);
            overflow-x: hidden;
        }

        /* ===================== NAVBAR ===================== */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 0 64px;
            height: 80px;
            display: flex;
            align-items: center;
            background: rgba(251, 245, 232, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--brown-10);
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            box-shadow: 0 4px 24px rgba(116, 70, 34, 0.08);
        }

        .navbar-inner {
            max-width: 1312px;
            width: 100%;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-icon {
            width: 48px;
            height: 48px;
            border-radius: 20px;
            background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
        }

        .brand-name {
            font-size: 24px;
            font-weight: 700;
            color: var(--brown);
            line-height: 1.33;
            letter-spacing: -0.5px;
        }

        .brand-tagline {
            font-size: 12px;
            font-weight: 400;
            color: var(--brown-60);
            letter-spacing: -0.3px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 40px;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            color: var(--brown-70);
            letter-spacing: -0.5px;
            transition: color 0.2s ease;
            position: relative;
            padding-bottom: 4px;
        }

        .nav-links a:hover {
            color: var(--brown);
        }

        .nav-links .nav-active {
            font-weight: 600;
            color: var(--brown);
            border-bottom: 2px solid var(--green);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .btn-login {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 20px;
            background: var(--white);
            color: var(--brown);
            font-size: 16px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            text-decoration: none;
            letter-spacing: -0.5px;
            transition: all 0.2s ease;
        }

        .btn-login:hover {
            box-shadow: 0 4px 12px var(--brown-10);
            transform: translateY(-1px);
        }

        .btn-register {
            padding: 12px 24px;
            border-radius: 20px;
            background: var(--green);
            color: var(--white);
            font-size: 16px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            text-decoration: none;
            letter-spacing: -0.5px;
            transition: all 0.2s ease;
        }

        .btn-register:hover {
            background: var(--green-dark);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(42, 118, 106, 0.35);
        }

        /* ===================== HERO ===================== */
        .hero-section {
            min-height: 100vh;
            padding: 80px 64px 0;
            background: linear-gradient(135deg, var(--cream) 0%, var(--cream-dark) 50%, rgba(116, 70, 34, 0.04) 100%);
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero-bg-glow {
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: var(--green-20);
            filter: blur(80px);
            right: -100px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            animation: pulse-glow 4s ease-in-out infinite;
        }

        @keyframes pulse-glow {

            0%,
            100% {
                transform: translateY(-50%) scale(1);
                opacity: 0.6;
            }

            50% {
                transform: translateY(-50%) scale(1.1);
                opacity: 1;
            }
        }

        .hero-inner {
            max-width: 1312px;
            width: 100%;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 48px;
            align-items: center;
            padding: 80px 0;
        }

        .hero-content {
            display: flex;
            flex-direction: column;
            gap: 32px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            padding: 10px 24px;
            border-radius: 9999px;
            background: var(--green-10);
            color: var(--green);
            font-size: 14px;
            font-weight: 600;
            letter-spacing: -0.3px;
            width: fit-content;
            animation: fade-in-up 0.6s ease both;
        }

        .hero-headline {
            display: flex;
            flex-direction: column;
            animation: fade-in-up 0.6s 0.1s ease both;
        }

        .hero-headline h1 {
            font-size: clamp(52px, 5vw, 72px);
            font-weight: 700;
            line-height: 1;
            letter-spacing: -1px;
        }

        .hero-headline .headline-white {
            color: var(--brown);
        }

        .hero-headline .headline-green {
            color: var(--green);
        }

        .hero-description {
            font-size: 20px;
            font-weight: 400;
            color: var(--brown-70);
            line-height: 1.6;
            letter-spacing: -0.3px;
            max-width: 560px;
            animation: fade-in-up 0.6s 0.2s ease both;
        }

        .hero-cta-group {
            display: flex;
            align-items: center;
            gap: 16px;
            animation: fade-in-up 0.6s 0.3s ease both;
        }

        .btn-cta-primary {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 18px 32px;
            border-radius: 20px;
            background: var(--green);
            color: var(--white);
            font-size: 18px;
            font-weight: 600;
            text-decoration: none;
            letter-spacing: -0.5px;
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-cta-primary::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), transparent);
            opacity: 0;
            transition: opacity 0.25s ease;
        }

        .btn-cta-primary:hover {
            background: var(--green-dark);
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(42, 118, 106, 0.40);
        }

        .btn-cta-primary:hover::before {
            opacity: 1;
        }

        .btn-cta-secondary {
            padding: 18px 32px;
            border-radius: 20px;
            background: var(--white);
            color: var(--brown);
            font-size: 18px;
            font-weight: 600;
            text-decoration: none;
            letter-spacing: -0.5px;
            border: 2px solid var(--brown-10);
            transition: all 0.25s ease;
        }

        .btn-cta-secondary:hover {
            border-color: var(--brown-10);
            box-shadow: var(--shadow-sm);
            transform: translateY(-2px);
        }

        .hero-stats {
            display: flex;
            align-items: center;
            gap: 32px;
            animation: fade-in-up 0.6s 0.4s ease both;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 20px;
            background: var(--green-10);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -0.5px;
        }

        .stat-label {
            font-size: 14px;
            font-weight: 400;
            color: var(--brown-60);
            letter-spacing: -0.3px;
        }

        /* Hero Image Column */
        .hero-visual {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: fade-in-up 0.6s 0.2s ease both;
        }

        .hero-blur-glow {
            position: absolute;
            width: 384px;
            height: 384px;
            border-radius: 50%;
            background: var(--green-20);
            filter: blur(48px);
            right: -40px;
            bottom: -40px;
            pointer-events: none;
        }

        .hero-card {
            width: 100%;
            max-width: 560px;
            background: var(--white);
            border-radius: 25px;
            padding: 24px;
            box-shadow: var(--shadow-lg);
            position: relative;
            z-index: 1;
            transition: transform 0.3s ease;
        }

        .hero-card:hover {
            transform: translateY(-6px);
        }

        .hero-card img {
            width: 100%;
            height: 320px;
            object-fit: cover;
            border-radius: 20px;
            display: block;
        }

        .floating-badge {
            position: absolute;
            bottom: -24px;
            left: -32px;
            background: var(--white);
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 8px 10px rgba(0, 0, 0, 0.08), 0 20px 25px rgba(0, 0, 0, 0.10);
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 2;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        .badge-icon {
            width: 48px;
            height: 48px;
            border-radius: 15px;
            background: var(--green);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .badge-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -0.3px;
        }

        .badge-sub {
            font-size: 14px;
            font-weight: 400;
            color: var(--brown-60);
        }

        /* ===================== FEATURES ===================== */
        .features-section {
            padding: 80px 64px;
            background: var(--white);
        }

        .features-inner {
            max-width: 1312px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 64px;
        }

        .section-header {
            text-align: center;
        }

        .section-title {
            font-size: 48px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -1px;
            line-height: 1;
        }

        .section-subtitle {
            font-size: 18px;
            font-weight: 400;
            color: var(--brown-70);
            margin-top: 16px;
            letter-spacing: -0.3px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 32px;
        }

        .feature-card {
            background: var(--cream);
            border-radius: 25px;
            padding: 32px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 24px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: default;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-md);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            background: var(--green-10);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            background: var(--green);
        }

        .feature-card:hover .feature-icon svg path {
            fill: white;
        }

        .feature-name {
            font-size: 20px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -0.5px;
        }

        .feature-desc {
            font-size: 16px;
            font-weight: 400;
            color: var(--brown-70);
            line-height: 1.5;
            letter-spacing: -0.3px;
        }

        /* ===================== MENU ===================== */
        .menu-section {
            padding: 80px 64px;
            background: var(--cream);
        }

        .menu-inner {
            max-width: 1312px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 48px;
        }

        .menu-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
        }

        .menu-header-text {}

        .menu-title {
            font-size: 48px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -1px;
            line-height: 1;
        }

        .menu-subtitle {
            font-size: 18px;
            font-weight: 400;
            color: var(--brown-70);
            margin-top: 16px;
            letter-spacing: -0.3px;
        }

        .btn-view-all {
            padding: 16px 32px;
            border-radius: 20px;
            background: var(--green);
            color: var(--white);
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            letter-spacing: -0.5px;
            white-space: nowrap;
            transition: all 0.25s ease;
        }

        .btn-view-all:hover {
            background: var(--green-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(42, 118, 106, 0.35);
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 32px;
        }

        .menu-card {
            background: var(--white);
            border-radius: 25px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .menu-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .menu-card-img {
            position: relative;
            height: 256px;
            overflow: hidden;
            background: var(--cream-dark);
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
            top: 16px;
            right: 16px;
            padding: 8px 16px;
            border-radius: 15px;
            font-size: 14px;
            font-weight: 600;
            color: var(--white);
            letter-spacing: -0.3px;
        }

        .badge-bestseller {
            background: var(--green);
        }

        .badge-promo {
            background: var(--brown);
        }

        .menu-card-body {
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .menu-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .menu-card-name {
            font-size: 20px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -0.5px;
        }

        .menu-rating {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .rating-value {
            font-size: 16px;
            font-weight: 600;
            color: var(--green);
            letter-spacing: -0.3px;
        }

        .menu-card-desc {
            font-size: 16px;
            font-weight: 400;
            color: var(--brown-70);
            line-height: 1.5;
            letter-spacing: -0.3px;
        }

        .menu-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .menu-price-block {
            display: flex;
            flex-direction: column;
        }

        .price-original {
            font-size: 14px;
            font-weight: 400;
            color: rgba(116, 70, 34, 0.50);
            text-decoration: line-through;
            letter-spacing: -0.3px;
        }

        .price-current {
            font-size: 24px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -0.5px;
        }

        .btn-order {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 15px;
            background: var(--green);
            color: var(--white);
            font-size: 16px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            text-decoration: none;
            letter-spacing: -0.3px;
            transition: all 0.25s ease;
        }

        .btn-order:hover {
            background: var(--green-dark);
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(42, 118, 106, 0.35);
        }

        /* ===================== CTA SECTION ===================== */
        .cta-section {
            padding: 96px 64px;
            background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%);
            position: relative;
            overflow: hidden;
        }

        .cta-bg-orb-1 {
            position: absolute;
            width: 256px;
            height: 256px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            filter: blur(40px);
            left: 40px;
            top: 40px;
            pointer-events: none;
        }

        .cta-bg-orb-2 {
            position: absolute;
            width: 384px;
            height: 384px;
            border-radius: 50%;
            background: rgba(251, 245, 232, 0.08);
            filter: blur(40px);
            right: -40px;
            bottom: -40px;
            pointer-events: none;
        }

        .cta-inner {
            max-width: 1312px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 48px;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .cta-content {
            display: flex;
            flex-direction: column;
            gap: 32px;
        }

        .cta-title {
            font-size: clamp(36px, 4vw, 48px);
            font-weight: 700;
            color: var(--white);
            letter-spacing: -1px;
            line-height: 1;
        }

        .cta-subtitle {
            font-size: 20px;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.90);
            line-height: 1.6;
            letter-spacing: -0.3px;
        }

        .cta-benefits {
            background: rgba(255, 255, 255, 0.10);
            border-radius: 25px;
            padding: 32px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            backdrop-filter: blur(10px);
        }

        .benefit-item {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .benefit-check {
            width: 48px;
            height: 48px;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.20);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .benefit-text {
            font-size: 18px;
            font-weight: 400;
            color: var(--white);
            letter-spacing: -0.3px;
        }

        .btn-cta-white {
            padding: 21px 40px;
            border-radius: 20px;
            background: var(--white);
            color: var(--green);
            font-size: 18px;
            font-weight: 700;
            text-decoration: none;
            letter-spacing: -0.5px;
            display: inline-block;
            transition: all 0.25s ease;
        }

        .btn-cta-white:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.20);
        }

        .cta-image-card {
            background: rgba(255, 255, 255, 0.10);
            border-radius: 25px;
            padding: 32px;
            backdrop-filter: blur(10px);
            overflow: hidden;
        }

        .cta-image-card img {
            width: 100%;
            height: 380px;
            object-fit: cover;
            border-radius: 20px;
            display: block;
        }

        /* ===================== TESTIMONIALS ===================== */
        .testimonials-section {
            padding: 80px 64px;
            background: var(--white);
        }

        .testimonials-inner {
            max-width: 1312px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 64px;
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 32px;
        }

        .testimonial-card {
            background: var(--cream);
            border-radius: 25px;
            padding: 32px;
            display: flex;
            flex-direction: column;
            gap: 24px;
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-md);
        }

        .stars {
            display: flex;
            gap: 4px;
        }

        .testimonial-text {
            font-size: 16px;
            font-weight: 400;
            color: var(--brown-80);
            line-height: 1.7;
            letter-spacing: -0.3px;
            flex: 1;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .author-avatar {
            width: 56px;
            height: 56px;
            border-radius: 20px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .author-name {
            font-size: 16px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -0.3px;
        }

        .author-role {
            font-size: 14px;
            font-weight: 400;
            color: var(--brown-60);
            letter-spacing: -0.3px;
        }

        /* ===================== FOOTER ===================== */
        .footer {
            background: var(--brown);
            padding: 64px;
        }

        .footer-inner {
            max-width: 1312px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 48px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr;
            gap: 48px;
        }

        .footer-brand {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .footer-brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .footer-brand-name {
            font-size: 24px;
            font-weight: 700;
            color: var(--white);
            letter-spacing: -0.5px;
        }

        .footer-brand-tagline {
            font-size: 12px;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.60);
            letter-spacing: -0.3px;
        }

        .footer-desc {
            font-size: 16px;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.70);
            line-height: 1.6;
            letter-spacing: -0.3px;
        }

        .footer-socials {
            display: flex;
            gap: 16px;
        }

        .social-btn {
            width: 40px;
            height: 40px;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.10);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .social-btn:hover {
            background: rgba(255, 255, 255, 0.20);
            transform: translateY(-2px);
        }

        .footer-col {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .footer-col-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--white);
            letter-spacing: -0.5px;
        }

        .footer-links {
            display: flex;
            flex-direction: column;
            gap: 12px;
            list-style: none;
        }

        .footer-links a {
            font-size: 16px;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.70);
            text-decoration: none;
            letter-spacing: -0.3px;
            transition: color 0.2s ease;
        }

        .footer-links a:hover {
            color: var(--white);
        }

        .footer-contact {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .contact-icon {
            flex-shrink: 0;
            margin-top: 2px;
        }

        .contact-text {
            font-size: 16px;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.70);
            line-height: 1.5;
            letter-spacing: -0.3px;
        }

        .footer-divider {
            border: none;
            border-top: 1px solid rgba(255, 255, 255, 0.10);
        }

        .footer-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .footer-copyright {
            font-size: 14px;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.60);
            letter-spacing: -0.3px;
        }

        .footer-legal {
            display: flex;
            gap: 24px;
        }

        .footer-legal a {
            font-size: 14px;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.60);
            text-decoration: none;
            letter-spacing: -0.3px;
            transition: color 0.2s ease;
        }

        .footer-legal a:hover {
            color: var(--white);
        }

        /* ===================== SCROLL ANIMATIONS ===================== */
        .reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .reveal-delay-1 {
            transition-delay: 0.1s;
        }

        .reveal-delay-2 {
            transition-delay: 0.2s;
        }

        .reveal-delay-3 {
            transition-delay: 0.3s;
        }

        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===================== RESPONSIVE ===================== */
        @media (max-width: 1024px) {
            .navbar {
                padding: 0 32px;
            }

            .hero-section {
                padding: 80px 32px 0;
            }

            .hero-inner {
                grid-template-columns: 1fr;
                padding: 80px 0 60px;
            }

            .hero-visual {
                display: none;
            }

            .features-section,
            .menu-section,
            .cta-section,
            .testimonials-section,
            .footer {
                padding: 60px 32px;
            }

            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .menu-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .testimonials-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .cta-inner {
                grid-template-columns: 1fr;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 32px;
            }

            .section-title {
                font-size: 36px;
            }

            .menu-title {
                font-size: 36px;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 0 20px;
            }

            .nav-links {
                display: none;
            }

            .hero-section {
                padding: 80px 20px 0;
            }

            .features-section,
            .menu-section,
            .cta-section,
            .testimonials-section,
            .footer {
                padding: 48px 20px;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .menu-grid {
                grid-template-columns: 1fr;
            }

            .menu-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }

            .testimonials-grid {
                grid-template-columns: 1fr;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }

            .footer-bottom {
                flex-direction: column;
                gap: 16px;
                text-align: center;
            }

            .hero-cta-group {
                flex-direction: column;
                align-items: flex-start;
            }

            .section-title,
            .menu-title,
            .cta-title {
                font-size: 32px;
            }
        }
    </style>
</head>

<body>

    <!-- ================ NAVBAR ================ -->
    <nav class="navbar" id="navbar">
        <div class="navbar-inner">
            <a href="#" class="brand">
                <div class="brand-icon">
                    <img src="https://api.builder.io/api/v1/image/assets/TEMP/10a82c5c6d87de97d3583b6c8564df77f595f954?width=1114" alt="Kantin Kita Logo" style="width:100%;height:100%;object-fit:cover;border-radius:inherit;" />
                </div>
                <div class="brand-text">
                    <span class="brand-name">Kantin Kita</span>
                    <span class="brand-tagline">Campus Canteen</span>
                </div>
            </a>

            <ul class="nav-links">
                <li><a href="#" class="nav-active">Beranda</a></li>
                <li><a href="#menu">Menu</a></li>
                <li><a href="#about">Tentang</a></li>
                <li><a href="#contact">Kontak</a></li>
            </ul>

            <div class="nav-actions">
                <a href="{{ route('login') }}" class="btn-login">
                    <svg width="14" height="16" viewBox="0 0 14 16" fill="none">
                        <path d="M7 8C8.06087 8 9.07828 7.57857 9.82843 6.82843C10.5786 6.07828 11 5.06087 11 4C11 2.93913 10.5786 1.92172 9.82843 1.17157C9.07828 0.421427 8.06087 0 7 0C5.93913 0 4.92172 0.421427 4.17157 1.17157C3.42143 1.92172 3 2.93913 3 4C3 5.06087 3.42143 6.07828 4.17157 6.82843C4.92172 7.57857 5.93913 8 7 8ZM5.57188 9.5C2.49375 9.5 0 11.9937 0 15.0719C0 15.5844 0.415625 16 0.928125 16H13.0719C13.5844 16 14 15.5844 14 15.0719C14 11.9937 11.5063 9.5 8.42813 9.5H5.57188Z" fill="#744622" />
                    </svg>
                    Masuk
                </a>
                <a href="#" class="btn-register">Daftar</a>
            </div>
        </div>
    </nav>

    <!-- ================ HERO ================ -->
    <section class="hero-section">
        <div class="hero-bg-glow"></div>
        <div class="hero-inner">
            <div class="hero-content">
                <span class="hero-badge">🎓 Khusus Mahasiswa & Staff</span>
                <div class="hero-headline">
                    <h1>
                        <span class="headline-white">Pesan Makanan</span><br>
                        <span class="headline-green">Tanpa Antri</span>
                    </h1>
                </div>
                <p class="hero-description">Nikmati hidangan lezat dari kantin kampus favorit kamu. Pesan sekarang, ambil nanti. Hemat waktu, lebih praktis!</p>
                <div class="hero-cta-group">
                    <a href="{{ route('vendor') }}" class="btn-cta-primary">
                        Mulai Pesan
                        <svg width="16" height="16" viewBox="0 0 16 18" fill="none">
                            <path d="M15.4195 9.79473C15.859 9.35527 15.859 8.6416 15.4195 8.20215L9.79453 2.57715C9.35508 2.1377 8.64141 2.1377 8.20195 2.57715C7.7625 3.0166 7.7625 3.73027 8.20195 4.16973L11.9109 7.8752H1.125C0.502734 7.8752 0 8.37793 0 9.0002C0 9.62246 0.502734 10.1252 1.125 10.1252H11.9074L8.20547 13.8307C7.76602 14.2701 7.76602 14.9838 8.20547 15.4232C8.64492 15.8627 9.35859 15.8627 9.79805 15.4232L15.423 9.79824L15.4195 9.79473Z" fill="white" />
                        </svg>
                    </a>
                    <a href="#menu" class="btn-cta-secondary">Lihat Menu</a>
                </div>
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M12 0C15.1826 0 18.2348 1.26428 20.4853 3.51472C22.7357 5.76516 24 8.8174 24 12C24 15.1826 22.7357 18.2348 20.4853 20.4853C18.2348 22.7357 15.1826 24 12 24C8.8174 24 5.76516 22.7357 3.51472 20.4853C1.26428 18.2348 0 15.1826 0 12C0 8.8174 1.26428 5.76516 3.51472 3.51472C5.76516 1.26428 8.8174 0 12 0ZM10.875 5.625V12C10.875 12.375 11.0625 12.7266 11.3766 12.9375L15.8766 15.9375C16.3922 16.2844 17.0906 16.1437 17.4375 15.6234C17.7844 15.1031 17.6437 14.4094 17.1234 14.0625L13.125 11.4V5.625C13.125 5.00156 12.6234 4.5 12 4.5C11.3766 4.5 10.875 5.00156 10.875 5.625Z" fill="#42766A" />
                            </svg>
                        </div>
                        <div>
                            <div class="stat-value">10 Min</div>
                            <div class="stat-label">Waktu Tunggu</div>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">
                            <svg width="27" height="24" viewBox="0 0 27 24" fill="none">
                                <path d="M14.8547 0.84375C14.6062 0.328125 14.0813 0 13.5047 0C12.9281 0 12.4078 0.328125 12.1547 0.84375L9.14062 7.04531L2.40938 8.03906C1.84688 8.12344 1.37813 8.51719 1.20469 9.05625C1.03125 9.59531 1.17187 10.1906 1.575 10.5891L6.45938 15.4219L5.30625 22.2516C5.2125 22.8141 5.44688 23.3859 5.91094 23.7188C6.375 24.0516 6.98906 24.0938 7.49531 23.8266L13.5094 20.6156L19.5234 23.8266C20.0297 24.0938 20.6437 24.0562 21.1078 23.7188C21.5719 23.3813 21.8063 22.8141 21.7125 22.2516L20.5547 15.4219L25.4391 10.5891C25.8422 10.1906 25.9875 9.59531 25.8094 9.05625C25.6312 8.51719 25.1672 8.12344 24.6047 8.03906L17.8688 7.04531L14.8547 0.84375Z" fill="#42766A" />
                            </svg>
                        </div>
                        <div>
                            <div class="stat-value">4.8</div>
                            <div class="stat-label">Rating</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hero-visual">
                <div class="hero-blur-glow"></div>
                <div class="hero-card">
                    <img src="https://images.unsplash.com/photo-1512058564366-18510be2db19?w=800&q=80&auto=format&fit=crop" alt="Makanan Lezat Kantin Kita">
                    <div class="floating-badge">
                        <div class="badge-icon">
                            <svg width="18" height="20" viewBox="0 0 18 20" fill="none">
                                <path d="M8.81641 16.25C9.80469 16.25 10.6797 15.9766 11.5039 15.4297C13.1484 14.2813 13.5898 11.9844 12.6016 10.1797C12.4258 9.82814 11.9766 9.8047 11.7227 10.1016L10.7383 11.2461C10.4805 11.543 10.0156 11.5352 9.77344 11.2266C9.12891 10.4063 7.97656 8.94142 7.32031 8.10939C7.07422 7.79689 6.60547 7.79298 6.35547 8.10548C5.03516 9.76563 4.37109 10.8125 4.37109 11.9883C4.375 14.6641 6.35156 16.25 8.81641 16.25Z" fill="white" />
                                <path d="M6.22266 0.210948C6.52734 -0.0742087 7 -0.0703025 7.30469 0.214854C8.38281 1.22657 9.39453 2.31642 10.3398 3.4961C10.7695 2.9336 11.2578 2.32032 11.7852 1.82032C12.0938 1.53126 12.5703 1.53126 12.8789 1.82423C14.2305 3.11329 15.375 4.81642 16.1797 6.4336C16.9727 8.02735 17.5 9.65626 17.5 10.8047C17.5 15.7891 13.6016 20 8.75 20C3.84375 20 0 15.7852 0 10.8008C0 9.30079 0.695313 7.46876 1.77344 5.65626C2.86328 3.81642 4.40234 1.89845 6.22266 0.210948Z" fill="white" />
                            </svg>
                        </div>
                        <div>
                            <div class="badge-title">Menu Terpopuler</div>
                            <div class="badge-sub">500+ Pesanan Hari Ini</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================ FEATURES ================ -->
    <section class="features-section" id="about">
        <div class="features-inner">
            <div class="section-header reveal">
                <h2 class="section-title">Kenapa Kantin Kita?</h2>
                <p class="section-subtitle">Solusi praktis untuk makan siang yang sibuk di kampus</p>
            </div>

            <div class="features-grid">
                <div class="feature-card reveal reveal-delay-1">
                    <div class="feature-icon">
                        <svg width="30" height="30" viewBox="0 0 23 30" fill="none">
                            <path d="M0.9375 3.75C0.9375 1.68164 2.61914 0 4.6875 0H17.8125C19.8809 0 21.5625 1.68164 21.5625 3.75V26.25C21.5625 28.3184 19.8809 30 17.8125 30H4.6875C2.61914 30 0.9375 28.3184 0.9375 26.25V3.75ZM13.125 26.25C13.125 25.7527 12.9275 25.2758 12.5758 24.9242C12.2242 24.5725 11.7473 24.375 11.25 24.375C10.7527 24.375 10.2758 24.5725 9.92418 24.9242C9.57254 25.2758 9.375 25.7527 9.375 26.25C9.375 26.7473 9.57254 27.2242 9.92418 27.5758C10.2758 27.9275 10.7527 28.125 11.25 28.125C11.7473 28.125 12.2242 27.9275 12.5758 27.5758C12.9275 27.2242 13.125 26.7473 13.125 26.25ZM17.8125 3.75H4.6875V22.5H17.8125V3.75Z" fill="#42766A" />
                        </svg>
                    </div>
                    <div class="feature-name">Pesan Online</div>
                    <p class="feature-desc">Pesan dari mana saja, kapan saja melalui aplikasi</p>
                </div>

                <div class="feature-card reveal reveal-delay-2">
                    <div class="feature-icon">
                        <svg width="26" height="30" viewBox="0 0 27 30" fill="none">
                            <path d="M20.4726 2.61332C20.8183 1.81059 20.5605 0.873089 19.8515 0.357464C19.1426-0.158161 18.1758-0.111286 17.5137 0.462932L2.51366 13.5879C1.92772 14.1036 1.71678 14.9297 1.99217 15.6563C2.26757 16.3829 2.97069 16.875 3.74999 16.875H10.2832L5.77733 27.3868C5.43163 28.1895 5.68944 29.127 6.39842 29.6426C7.10741 30.1582 8.07421 30.1114 8.73632 29.5372L23.7363 16.4122C24.3223 15.8965 24.5332 15.0704 24.2578 14.3438C23.9824 13.6172 23.2851 13.1309 22.5 13.1309H15.9668L20.4726 2.61332Z" fill="#42766A" />
                        </svg>
                    </div>
                    <div class="feature-name">Cepat & Mudah</div>
                    <p class="feature-desc">Proses pemesanan hanya dalam hitungan detik</p>
                </div>

                <div class="feature-card reveal reveal-delay-3">
                    <div class="feature-icon">
                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none">
                            <path d="M3.75 1.875C1.68164 1.875 0 3.55664 0 5.625V24.375C0 26.4434 1.68164 28.125 3.75 28.125H26.25C28.3184 28.125 30 26.4434 30 24.375V11.25C30 9.18164 28.3184 7.5 26.25 7.5H4.6875C4.17188 7.5 3.75 7.07812 3.75 6.5625C3.75 6.04688 4.17188 5.625 4.6875 5.625H26.25C27.2871 5.625 28.125 4.78711 28.125 3.75C28.125 2.71289 27.2871 1.875 26.25 1.875H3.75ZM24.375 15.9375C24.8723 15.9375 25.3492 16.135 25.7008 16.4867C26.0525 16.8383 26.25 17.3152 26.25 17.8125C26.25 18.3098 26.0525 18.7867 25.7008 19.1383C25.3492 19.49 24.8723 19.6875 24.375 19.6875C23.8777 19.6875 23.4008 19.49 23.0492 19.1383C22.6975 18.7867 22.5 18.3098 22.5 17.8125C22.5 17.3152 22.6975 16.8383 23.0492 16.4867C23.4008 16.135 23.8777 15.9375 24.375 15.9375Z" fill="#42766A" />
                        </svg>
                    </div>
                    <div class="feature-name">Cashless</div>
                    <p class="feature-desc">Pembayaran digital yang aman dan praktis</p>
                </div>

                <div class="feature-card reveal reveal-delay-3">
                    <div class="feature-icon">
                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none">
                            <path d="M11.1621 4.03125L13.2012 7.5H8.90625C7.61133 7.5 6.5625 6.45117 6.5625 5.15625C6.5625 3.86133 7.61133 2.8125 8.90625 2.8125H9.03516C9.9082 2.8125 10.7227 3.27539 11.1621 4.03125ZM3.75 5.15625C3.75 6 3.95508 6.79688 4.3125 7.5H1.875C0.837891 7.5 0 8.33789 0 9.375V13.125C0 14.1621 0.837891 15 1.875 15H28.125C29.1621 15 30 14.1621 30 13.125V9.375C30 8.33789 29.1621 7.5 28.125 7.5H25.6875C26.0449 6.79688 26.25 6 26.25 5.15625C26.25 2.30859 23.9414 0 21.0938 0H20.9648C19.0957 0 17.3613 0.990234 16.4121 2.60156L15 5.00977L13.5879 2.60742C12.6387 0.990234 10.9043 0 9.03516 0H8.90625C6.05859 0 3.75 2.30859 3.75 5.15625ZM1.875 16.875V27.1875C1.875 28.7402 3.13477 30 4.6875 30H13.125V16.875H1.875ZM16.875 30H25.3125C26.8652 30 28.125 28.7402 28.125 27.1875V16.875H16.875V30Z" fill="#42766A" />
                        </svg>
                    </div>
                    <div class="feature-name">Promo Menarik</div>
                    <p class="feature-desc">Dapatkan diskon dan reward setiap hari</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ================ MENU ================ -->
    <section class="menu-section" id="menu">
        <div class="menu-inner">
            <div class="menu-header reveal">
                <div class="menu-header-text">
                    <h2 class="menu-title">Menu Populer</h2>
                    <p class="menu-subtitle">Pilihan favorit mahasiswa setiap hari</p>
                </div>
                <a href="#" class="btn-view-all">Lihat Semua Menu</a>
            </div>

            <div class="menu-grid">
                <div class="menu-card reveal reveal-delay-1">
                    <div class="menu-card-img">
                        <img src="https://images.unsplash.com/photo-1609570324378-ec0c4c9b6ba8?q=80&w=2070&auto=format&fit=crop" alt="Nasi Goreng Special">
                        <span class="menu-badge badge-bestseller">Terlaris</span>
                    </div>
                    <div class="menu-card-body">
                        <div class="menu-card-header">
                            <span class="menu-card-name">Nasi Goreng Special</span>
                            <div class="menu-rating">
                                <svg width="16" height="14" viewBox="0 0 16 14" fill="none">
                                    <path d="M8.66525 0.492188C8.52032 0.191406 8.21407 0 7.87775 0C7.54142 0 7.2379 0.191406 7.09025 0.492188L5.33204 4.10977L1.40548 4.68945C1.07736 4.73867 0.803918 4.96836 0.702746 5.28281C0.601574 5.59727 0.683605 5.94453 0.918761 6.17695L3.76798 8.99609L3.09532 12.9801C3.04064 13.3082 3.17736 13.6418 3.44806 13.8359C3.71876 14.0301 4.07696 14.0547 4.37228 13.8988L7.88048 12.0258L11.3887 13.8988C11.684 14.0547 12.0422 14.0328 12.3129 13.8359C12.5836 13.6391 12.7203 13.3082 12.6656 12.9801L11.9902 8.99609L14.8395 6.17695C15.0746 5.94453 15.1594 5.59727 15.0555 5.28281C14.9516 4.96836 14.6809 4.73867 14.3527 4.68945L10.4234 4.10977L8.66525 0.492188Z" fill="#42766A" />
                                </svg>
                                <span class="rating-value">4.9</span>
                            </div>
                        </div>
                        <p class="menu-card-desc">Nasi goreng dengan ayam, telur mata sapi, dan sayuran segar</p>
                        <div class="menu-card-footer">
                            <div class="menu-price-block">
                                <span class="price-current">Rp 18.000</span>
                            </div>
                            <a href="#" class="btn-order">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                    <path d="M8 2.5C8 1.94687 7.55312 1.5 7 1.5C6.44688 1.5 6 1.94687 6 2.5V7H1.5C0.946875 7 0.5 7.44688 0.5 8C0.5 8.55312 0.946875 9 1.5 9H6V13.5C6 14.0531 6.44688 14.5 7 14.5C7.55312 14.5 8 14.0531 8 13.5V9H12.5C13.0531 9 13.5 8.55312 13.5 8C13.5 7.44688 13.0531 7 12.5 7H8V2.5Z" fill="white" />
                                </svg>
                                Pesan
                            </a>
                        </div>
                    </div>
                </div>

                <div class="menu-card reveal reveal-delay-2">
                    <div class="menu-card-img">
                        <img src="https://images.unsplash.com/photo-1680675494363-75bbf9838a09?q=80&w=2070&auto=format&fit=crop" alt="Mie Goreng Jawa">
                    </div>
                    <div class="menu-card-body">
                        <div class="menu-card-header">
                            <span class="menu-card-name">Mie Goreng Jawa</span>
                            <div class="menu-rating">
                                <svg width="16" height="14" viewBox="0 0 16 14" fill="none">
                                    <path d="M8.66522 0.492188C8.52029 0.191406 8.21404 0 7.87772 0C7.54139 0 7.23787 0.191406 7.09021 0.492188L5.33201 4.10977L1.40545 4.68945C1.07732 4.73867 0.803887 4.96836 0.702715 5.28281C0.601543 5.59727 0.683575 5.94453 0.918731 6.17695L3.76795 8.99609L3.09529 12.9801C3.04061 13.3082 3.17732 13.6418 3.44803 13.8359C3.71873 14.0301 4.07693 14.0547 4.37225 13.8988L7.88045 12.0258L11.3887 13.8988C11.684 14.0547 12.0422 14.0328 12.3129 13.8359C12.5836 13.6391 12.7203 13.3082 12.6656 12.9801L11.9902 8.99609L14.8394 6.17695C15.0746 5.94453 15.1594 5.59727 15.0554 5.28281C14.9515 4.96836 14.6808 4.73867 14.3527 4.68945L10.4234 4.10977L8.66522 0.492188Z" fill="#42766A" />
                                </svg>
                                <span class="rating-value">4.8</span>
                            </div>
                        </div>
                        <p class="menu-card-desc">Mie goreng dengan bumbu khas Jawa yang gurih dan pedas</p>
                        <div class="menu-card-footer">
                            <div class="menu-price-block">
                                <span class="price-current">Rp 15.000</span>
                            </div>
                            <a href="#" class="btn-order">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                    <path d="M8 2.5C8 1.94687 7.55312 1.5 7 1.5C6.44688 1.5 6 1.94687 6 2.5V7H1.5C0.946875 7 0.5 7.44688 0.5 8C0.5 8.55312 0.946875 9 1.5 9H6V13.5C6 14.0531 6.44688 14.5 7 14.5C7.55312 14.5 8 14.0531 8 13.5V9H12.5C13.0531 9 13.5 8.55312 13.5 8C13.5 7.44688 13.0531 7 12.5 7H8V2.5Z" fill="white" />
                                </svg>
                                Pesan
                            </a>
                        </div>
                    </div>
                </div>

                <div class="menu-card reveal reveal-delay-3">
                    <div class="menu-card-img">
                        <img src="https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?w=600&q=80&auto=format&fit=crop" alt="Ayam Geprek">
                        <span class="menu-badge badge-promo">Promo</span>
                    </div>
                    <div class="menu-card-body">
                        <div class="menu-card-header">
                            <span class="menu-card-name">Ayam Geprek</span>
                            <div class="menu-rating">
                                <svg width="16" height="14" viewBox="0 0 16 14" fill="none">
                                    <path d="M8.66522 0.492188C8.52029 0.191406 8.21404 0 7.87772 0C7.54139 0 7.23787 0.191406 7.09021 0.492188L5.33201 4.10977L1.40545 4.68945C1.07732 4.73867 0.803887 4.96836 0.702715 5.28281C0.601543 5.59727 0.683575 5.94453 0.918731 6.17695L3.76795 8.99609L3.09529 12.9801C3.04061 13.3082 3.17732 13.6418 3.44803 13.8359C3.71873 14.0301 4.07693 14.0547 4.37225 13.8988L7.88045 12.0258L11.3887 13.8988C11.684 14.0547 12.0422 14.0328 12.3129 13.8359C12.5836 13.6391 12.7203 13.3082 12.6656 12.9801L11.9902 8.99609L14.8394 6.17695C15.0746 5.94453 15.1594 5.59727 15.0554 5.28281C14.9515 4.96836 14.6808 4.73867 14.3527 4.68945L10.4234 4.10977L8.66522 0.492188Z" fill="#42766A" />
                                </svg>
                                <span class="rating-value">4.7</span>
                            </div>
                        </div>
                        <p class="menu-card-desc">Ayam crispy dengan sambal level pilihan dan nasi hangat</p>
                        <div class="menu-card-footer">
                            <div class="menu-price-block">
                                <span class="price-original">Rp 20.000</span>
                                <span class="price-current">Rp 17.000</span>
                            </div>
                            <a href="#" class="btn-order">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                    <path d="M8 2.5C8 1.94687 7.55312 1.5 7 1.5C6.44688 1.5 6 1.94687 6 2.5V7H1.5C0.946875 7 0.5 7.44688 0.5 8C0.5 8.55312 0.946875 9 1.5 9H6V13.5C6 14.0531 6.44688 14.5 7 14.5C7.55312 14.5 8 14.0531 8 13.5V9H12.5C13.0531 9 13.5 8.55312 13.5 8C13.5 7.44688 13.0531 7 12.5 7H8V2.5Z" fill="white" />
                                </svg>
                                Pesan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================ CTA ================ -->
    <section class="cta-section">
        <div class="cta-bg-orb-1"></div>
        <div class="cta-bg-orb-2"></div>
        <div class="cta-inner">
            <div class="cta-content reveal">
                <h2 class="cta-title">Siap Mulai Pesan?</h2>
                <p class="cta-subtitle">Daftar sekarang dan dapatkan voucher diskon 20% untuk pesanan pertama kamu!</p>

                <div class="cta-benefits">
                    <div class="benefit-item">
                        <div class="benefit-check">
                            <svg width="18" height="20" viewBox="0 0 18 20" fill="none">
                                <path d="M17.1328 4.11719C17.6211 4.60547 17.6211 5.39844 17.1328 5.88672L7.13281 15.8867C6.64453 16.375 5.85156 16.375 5.36328 15.8867L0.363281 10.8867C-0.125 10.3984 -0.125 9.60547 0.363281 9.11719C0.851562 8.62891 1.64453 8.62891 2.13281 9.11719L6.25 13.2305L15.3672 4.11719C15.8555 3.62891 16.6484 3.62891 17.1367 4.11719H17.1328Z" fill="white" />
                            </svg>
                        </div>
                        <span class="benefit-text">Gratis biaya layanan untuk mahasiswa</span>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-check">
                            <svg width="18" height="20" viewBox="0 0 18 20" fill="none">
                                <path d="M17.1328 4.11719C17.6211 4.60547 17.6211 5.39844 17.1328 5.88672L7.13281 15.8867C6.64453 16.375 5.85156 16.375 5.36328 15.8867L0.363281 10.8867C-0.125 10.3984 -0.125 9.60547 0.363281 9.11719C0.851562 8.62891 1.64453 8.62891 2.13281 9.11719L6.25 13.2305L15.3672 4.11719C15.8555 3.62891 16.6484 3.62891 17.1367 4.11719H17.1328Z" fill="white" />
                            </svg>
                        </div>
                        <span class="benefit-text">Poin reward setiap transaksi</span>
                    </div>
                    <div class="benefit-item">
                        <div class="benefit-check">
                            <svg width="18" height="20" viewBox="0 0 18 20" fill="none">
                                <path d="M17.1328 4.11719C17.6211 4.60547 17.6211 5.39844 17.1328 5.88672L7.13281 15.8867C6.64453 16.375 5.85156 16.375 5.36328 15.8867L0.363281 10.8867C-0.125 10.3984 -0.125 9.60547 0.363281 9.11719C0.851562 8.62891 1.64453 8.62891 2.13281 9.11719L6.25 13.2305L15.3672 4.11719C15.8555 3.62891 16.6484 3.62891 17.1367 4.11719H17.1328Z" fill="white" />
                            </svg>
                        </div>
                        <span class="benefit-text">Promo eksklusif setiap minggu</span>
                    </div>
                </div>

                <a href="#" class="btn-cta-white">Daftar Sekarang — Gratis!</a>
            </div>

            <div class="cta-image-card reveal reveal-delay-2">
                <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=800&q=80&auto=format&fit=crop" alt="Mahasiswa Kantin Kita">
            </div>
        </div>
    </section>

    <!-- ================ TESTIMONIALS ================ -->
    <section class="testimonials-section">
        <div class="testimonials-inner">
            <div class="section-header reveal">
                <h2 class="section-title">Kata Mereka</h2>
                <p class="section-subtitle">Pengalaman pengguna Kantin Kita</p>
            </div>

            <div class="testimonials-grid">
                <div class="testimonial-card reveal reveal-delay-1">
                    <div class="stars">
                        <svg width="18" height="16" viewBox="0 0 18 16" fill="none">
                            <path d="M9.90312 0.5625C9.7375 0.21875 9.3875 0 9.00313 0C8.61875 0 8.27187 0.21875 8.10312 0.5625L6.09375 4.69688L1.60625 5.35938C1.23125 5.41563 0.91875 5.67812 0.803125 6.0375C0.6875 6.39687 0.78125 6.79375 1.05 7.05937L4.30625 10.2812L3.5375 14.8344C3.475 15.2094 3.63125 15.5906 3.94062 15.8125C4.25 16.0344 4.65937 16.0625 4.99687 15.8844L9.00625 13.7437L13.0156 15.8844C13.3531 16.0625 13.7625 16.0375 14.0719 15.8125C14.3812 15.5875 14.5375 15.2094 14.475 14.8344L13.7031 10.2812L16.9594 7.05937C17.2281 6.79375 17.325 6.39687 17.2062 6.0375C17.0875 5.67812 16.7781 5.41563 16.4031 5.35938L11.9125 4.69688L9.90312 0.5625Z" fill="#42766A" />
                        </svg>
                        <svg width="18" height="16" viewBox="0 0 18 16" fill="none">
                            <path d="M9.90312 0.5625C9.7375 0.21875 9.3875 0 9.00313 0C8.61875 0 8.27187 0.21875 8.10312 0.5625L6.09375 4.69688L1.60625 5.35938C1.23125 5.41563 0.91875 5.67812 0.803125 6.0375C0.6875 6.39687 0.78125 6.79375 1.05 7.05937L4.30625 10.2812L3.5375 14.8344C3.475 15.2094 3.63125 15.5906 3.94062 15.8125C4.25 16.0344 4.65937 16.0625 4.99687 15.8844L9.00625 13.7437L13.0156 15.8844C13.3531 16.0625 13.7625 16.0375 14.0719 15.8125C14.3812 15.5875 14.5375 15.2094 14.475 14.8344L13.7031 10.2812L16.9594 7.05937C17.2281 6.79375 17.325 6.39687 17.2062 6.0375C17.0875 5.67812 16.7781 5.41563 16.4031 5.35938L11.9125 4.69688L9.90312 0.5625Z" fill="#42766A" />
                        </svg>
                        <svg width="18" height="16" viewBox="0 0 18 16" fill="none">
                            <path d="M9.90312 0.5625C9.7375 0.21875 9.3875 0 9.00313 0C8.61875 0 8.27187 0.21875 8.10312 0.5625L6.09375 4.69688L1.60625 5.35938C1.23125 5.41563 0.91875 5.67812 0.803125 6.0375C0.6875 6.39687 0.78125 6.79375 1.05 7.05937L4.30625 10.2812L3.5375 14.8344C3.475 15.2094 3.63125 15.5906 3.94062 15.8125C4.25 16.0344 4.65937 16.0625 4.99687 15.8844L9.00625 13.7437L13.0156 15.8844C13.3531 16.0625 13.7625 16.0375 14.0719 15.8125C14.3812 15.5875 14.5375 15.2094 14.475 14.8344L13.7031 10.2812L16.9594 7.05937C17.2281 6.79375 17.325 6.39687 17.2062 6.0375C17.0875 5.67812 16.7781 5.41563 16.4031 5.35938L11.9125 4.69688L9.90312 0.5625Z" fill="#42766A" />
                        </svg>
                        <svg width="18" height="16" viewBox="0 0 18 16" fill="none">
                            <path d="M9.90312 0.5625C9.7375 0.21875 9.3875 0 9.00313 0C8.61875 0 8.27187 0.21875 8.10312 0.5625L6.09375 4.69688L1.60625 5.35938C1.23125 5.41563 0.91875 5.67812 0.803125 6.0375C0.6875 6.39687 0.78125 6.79375 1.05 7.05937L4.30625 10.2812L3.5375 14.8344C3.475 15.2094 3.63125 15.5906 3.94062 15.8125C4.25 16.0344 4.65937 16.0625 4.99687 15.8844L9.00625 13.7437L13.0156 15.8844C13.3531 16.0625 13.7625 16.0375 14.0719 15.8125C14.3812 15.5875 14.5375 15.2094 14.475 14.8344L13.7031 10.2812L16.9594 7.05937C17.2281 6.79375 17.325 6.39687 17.2062 6.0375C17.0875 5.67812 16.7781 5.41563 16.4031 5.35938L11.9125 4.69688L9.90312 0.5625Z" fill="#42766A" />
                        </svg>
                        <svg width="18" height="16" viewBox="0 0 18 16" fill="none">
                            <path d="M9.90312 0.5625C9.7375 0.21875 9.3875 0 9.00313 0C8.61875 0 8.27187 0.21875 8.10312 0.5625L6.09375 4.69688L1.60625 5.35938C1.23125 5.41563 0.91875 5.67812 0.803125 6.0375C0.6875 6.39687 0.78125 6.79375 1.05 7.05937L4.30625 10.2812L3.5375 14.8344C3.475 15.2094 3.63125 15.5906 3.94062 15.8125C4.25 16.0344 4.65937 16.0625 4.99687 15.8844L9.00625 13.7437L13.0156 15.8844C13.3531 16.0625 13.7625 16.0375 14.0719 15.8125C14.3812 15.5875 14.5375 15.2094 14.475 14.8344L13.7031 10.2812L16.9594 7.05937C17.2281 6.79375 17.325 6.39687 17.2062 6.0375C17.0875 5.67812 16.7781 5.41563 16.4031 5.35938L11.9125 4.69688L9.90312 0.5625Z" fill="#42766A" />
                        </svg>
                    </div>
                    <p class="testimonial-text">"Aplikasi yang sangat membantu! Tidak perlu lagi antri panjang saat jam makan siang. Pesanan selalu siap tepat waktu."</p>
                    <div class="testimonial-author">
                        <img class="author-avatar" src="https://i.pravatar.cc/100?img=47" alt="Sarah Putri">
                        <div>
                            <div class="author-name">Sarah Putri</div>
                            <div class="author-role">Mahasiswa Teknik Informatika</div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card reveal reveal-delay-2">
                    <div class="stars">
                        <svg width="18" height="16" viewBox="0 0 18 16" fill="none">
                            <path d="M9.90312 0.5625C9.7375 0.21875 9.3875 0 9.00313 0C8.61875 0 8.27187 0.21875 8.10312 0.5625L6.09375 4.69688L1.60625 5.35938C1.23125 5.41563 0.91875 5.67812 0.803125 6.0375C0.6875 6.39687 0.78125 6.79375 1.05 7.05937L4.30625 10.2812L3.5375 14.8344C3.475 15.2094 3.63125 15.5906 3.94062 15.8125C4.25 16.0344 4.65937 16.0625 4.99687 15.8844L9.00625 13.7437L13.0156 15.8844C13.3531 16.0625 13.7625 16.0375 14.0719 15.8125C14.3812 15.5875 14.5375 15.2094 14.475 14.8344L13.7031 10.2812L16.9594 7.05937C17.2281 6.79375 17.325 6.39687 17.2062 6.0375C17.0875 5.67812 16.7781 5.41563 16.4031 5.35938L11.9125 4.69688L9.90312 0.5625Z" fill="#42766A" />
                        </svg>
                        <svg width="18" height="16" viewBox="0 0 18 16" fill="none">
                            <path d="M9.90312 0.5625C9.7375 0.21875 9.3875 0 9.00313 0C8.61875 0 8.27187 0.21875 8.10312 0.5625L6.09375 4.69688L1.60625 5.35938C1.23125 5.41563 0.91875 5.67812 0.803125 6.0375C0.6875 6.39687 0.78125 6.79375 1.05 7.05937L4.30625 10.2812L3.5375 14.8344C3.475 15.2094 3.63125 15.5906 3.94062 15.8125C4.25 16.0344 4.65937 16.0625 4.99687 15.8844L9.00625 13.7437L13.0156 15.8844C13.3531 16.0625 13.7625 16.0375 14.0719 15.8125C14.3812 15.5875 14.5375 15.2094 14.475 14.8344L13.7031 10.2812L16.9594 7.05937C17.2281 6.79375 17.325 6.39687 17.2062 6.0375C17.0875 5.67812 16.7781 5.41563 16.4031 5.35938L11.9125 4.69688L9.90312 0.5625Z" fill="#42766A" />
                        </svg>
                        <svg width="18" height="16" viewBox="0 0 18 16" fill="none">
                            <path d="M9.90312 0.5625C9.7375 0.21875 9.3875 0 9.00313 0C8.61875 0 8.27187 0.21875 8.10312 0.5625L6.09375 4.69688L1.60625 5.35938C1.23125 5.41563 0.91875 5.67812 0.803125 6.0375C0.6875 6.39687 0.78125 6.79375 1.05 7.05937L4.30625 10.2812L3.5375 14.8344C3.475 15.2094 3.63125 15.5906 3.94062 15.8125C4.25 16.0344 4.65937 16.0625 4.99687 15.8844L9.00625 13.7437L13.0156 15.8844C13.3531 16.0625 13.7625 16.0375 14.0719 15.8125C14.3812 15.5875 14.5375 15.2094 14.475 14.8344L13.7031 10.2812L16.9594 7.05937C17.2281 6.79375 17.325 6.39687 17.2062 6.0375C17.0875 5.67812 16.7781 5.41563 16.4031 5.35938L11.9125 4.69688L9.90312 0.5625Z" fill="#42766A" />
                        </svg>
                        <svg width="18" height="16" viewBox="0 0 18 16" fill="none">
                            <path d="M9.90312 0.5625C9.7375 0.21875 9.3875 0 9.00313 0C8.61875 0 8.27187 0.21875 8.10312 0.5625L6.09375 4.69688L1.60625 5.35938C1.23125 5.41563 0.91875 5.67812 0.803125 6.0375C0.6875 6.39687 0.78125 6.79375 1.05 7.05937L4.30625 10.2812L3.5375 14.8344C3.475 15.2094 3.63125 15.5906 3.94062 15.8125C4.25 16.0344 4.65937 16.0625 4.99687 15.8844L9.00625 13.7437L13.0156 15.8844C13.3531 16.0625 13.7625 16.0375 14.0719 15.8125C14.3812 15.5875 14.5375 15.2094 14.475 14.8344L13.7031 10.2812L16.9594 7.05937C17.2281 6.79375 17.325 6.39687 17.2062 6.0375C17.0875 5.67812 16.7781 5.41563 16.4031 5.35938L11.9125 4.69688L9.90312 0.5625Z" fill="#42766A" />
                        </svg>
                        <svg width="18" height="16" viewBox="0 0 18 16" fill="none">
                            <path d="M9.90312 0.5625C9.7375 0.21875 9.3875 0 9.00313 0C8.61875 0 8.27187 0.21875 8.10312 0.5625L6.09375 4.69688L1.60625 5.35938C1.23125 5.41563 0.91875 5.67812 0.803125 6.0375C0.6875 6.39687 0.78125 6.79375 1.05 7.05937L4.30625 10.2812L3.5375 14.8344C3.475 15.2094 3.63125 15.5906 3.94062 15.8125C4.25 16.0344 4.65937 16.0625 4.99687 15.8844L9.00625 13.7437L13.0156 15.8844C13.3531 16.0625 13.7625 16.0375 14.0719 15.8125C14.3812 15.5875 14.5375 15.2094 14.475 14.8344L13.7031 10.2812L16.9594 7.05937C17.2281 6.79375 17.325 6.39687 17.2062 6.0375C17.0875 5.67812 16.7781 5.41563 16.4031 5.35938L11.9125 4.69688L9.90312 0.5625Z" fill="#42766A" />
                        </svg>
                    </div>
                    <p class="testimonial-text">"Menu-nya lengkap dan harganya ramah kantong mahasiswa. Sistem pembayaran digital juga sangat praktis!"</p>
                    <div class="testimonial-author">
                        <img class="author-avatar" src="https://i.pravatar.cc/100?img=12" alt="Budi Santoso">
                        <div>
                            <div class="author-name">Budi Santoso</div>
                            <div class="author-role">Mahasiswa Ekonomi</div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card reveal reveal-delay-3">
                    <div class="stars">
                        <svg width="18" height="16" viewBox="0 0 18 16" fill="none">
                            <path d="M9.90312 0.5625C9.7375 0.21875 9.3875 0 9.00313 0C8.61875 0 8.27187 0.21875 8.10312 0.5625L6.09375 4.69688L1.60625 5.35938C1.23125 5.41563 0.91875 5.67812 0.803125 6.0375C0.6875 6.39687 0.78125 6.79375 1.05 7.05937L4.30625 10.2812L3.5375 14.8344C3.475 15.2094 3.63125 15.5906 3.94062 15.8125C4.25 16.0344 4.65937 16.0625 4.99687 15.8844L9.00625 13.7437L13.0156 15.8844C13.3531 16.0625 13.7625 16.0375 14.0719 15.8125C14.3812 15.5875 14.5375 15.2094 14.475 14.8344L13.7031 10.2812L16.9594 7.05937C17.2281 6.79375 17.325 6.39687 17.2062 6.0375C17.0875 5.67812 16.7781 5.41563 16.4031 5.35938L11.9125 4.69688L9.90312 0.5625Z" fill="#42766A" />
                        </svg>
                        <svg width="18" height="16" viewBox="0 0 18 16" fill="none">
                            <path d="M9.90312 0.5625C9.7375 0.21875 9.3875 0 9.00313 0C8.61875 0 8.27187 0.21875 8.10312 0.5625L6.09375 4.69688L1.60625 5.35938C1.23125 5.41563 0.91875 5.67812 0.803125 6.0375C0.6875 6.39687 0.78125 6.79375 1.05 7.05937L4.30625 10.2812L3.5375 14.8344C3.475 15.2094 3.63125 15.5906 3.94062 15.8125C4.25 16.0344 4.65937 16.0625 4.99687 15.8844L9.00625 13.7437L13.0156 15.8844C13.3531 16.0625 13.7625 16.0375 14.0719 15.8125C14.3812 15.5875 14.5375 15.2094 14.475 14.8344L13.7031 10.2812L16.9594 7.05937C17.2281 6.79375 17.325 6.39687 17.2062 6.0375C17.0875 5.67812 16.7781 5.41563 16.4031 5.35938L11.9125 4.69688L9.90312 0.5625Z" fill="#42766A" />
                        </svg>
                        <svg width="18" height="16" viewBox="0 0 18 16" fill="none">
                            <path d="M9.90312 0.5625C9.7375 0.21875 9.3875 0 9.00313 0C8.61875 0 8.27187 0.21875 8.10312 0.5625L6.09375 4.69688L1.60625 5.35938C1.23125 5.41563 0.91875 5.67812 0.803125 6.0375C0.6875 6.39687 0.78125 6.79375 1.05 7.05937L4.30625 10.2812L3.5375 14.8344C3.475 15.2094 3.63125 15.5906 3.94062 15.8125C4.25 16.0344 4.65937 16.0625 4.99687 15.8844L9.00625 13.7437L13.0156 15.8844C13.3531 16.0625 13.7625 16.0375 14.0719 15.8125C14.3812 15.5875 14.5375 15.2094 14.475 14.8344L13.7031 10.2812L16.9594 7.05937C17.2281 6.79375 17.325 6.39687 17.2062 6.0375C17.0875 5.67812 16.7781 5.41563 16.4031 5.35938L11.9125 4.69688L9.90312 0.5625Z" fill="#42766A" />
                        </svg>
                        <svg width="18" height="16" viewBox="0 0 18 16" fill="none">
                            <path d="M9.90312 0.5625C9.7375 0.21875 9.3875 0 9.00313 0C8.61875 0 8.27187 0.21875 8.10312 0.5625L6.09375 4.69688L1.60625 5.35938C1.23125 5.41563 0.91875 5.67812 0.803125 6.0375C0.6875 6.39687 0.78125 6.79375 1.05 7.05937L4.30625 10.2812L3.5375 14.8344C3.475 15.2094 3.63125 15.5906 3.94062 15.8125C4.25 16.0344 4.65937 16.0625 4.99687 15.8844L9.00625 13.7437L13.0156 15.8844C13.3531 16.0625 13.7625 16.0375 14.0719 15.8125C14.3812 15.5875 14.5375 15.2094 14.475 14.8344L13.7031 10.2812L16.9594 7.05937C17.2281 6.79375 17.325 6.39687 17.2062 6.0375C17.0875 5.67812 16.7781 5.41563 16.4031 5.35938L11.9125 4.69688L9.90312 0.5625Z" fill="#42766A" />
                        </svg>
                        <svg width="18" height="16" viewBox="0 0 18 16" fill="none">
                            <path d="M9.90312 0.5625C9.7375 0.21875 9.3875 0 9.00313 0C8.61875 0 8.27187 0.21875 8.10312 0.5625L6.09375 4.69688L1.60625 5.35938C1.23125 5.41563 0.91875 5.67812 0.803125 6.0375C0.6875 6.39687 0.78125 6.79375 1.05 7.05937L4.30625 10.2812L3.5375 14.8344C3.475 15.2094 3.63125 15.5906 3.94062 15.8125C4.25 16.0344 4.65937 16.0625 4.99687 15.8844L9.00625 13.7437L13.0156 15.8844C13.3531 16.0625 13.7625 16.0375 14.0719 15.8125C14.3812 15.5875 14.5375 15.2094 14.475 14.8344L13.7031 10.2812L16.9594 7.05937C17.2281 6.79375 17.325 6.39687 17.2062 6.0375C17.0875 5.67812 16.7781 5.41563 16.4031 5.35938L11.9125 4.69688L9.90312 0.5625Z" fill="#42766A" />
                        </svg>
                    </div>
                    <p class="testimonial-text">"Promo dan reward poin-nya bikin makin hemat. Aplikasi favorit untuk makan siang di kampus!"</p>
                    <div class="testimonial-author">
                        <img class="author-avatar" src="https://i.pravatar.cc/100?img=23" alt="Rina Wati">
                        <div>
                            <div class="author-name">Rina Wati</div>
                            <div class="author-role">Staff Administrasi</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================ FOOTER ================ -->
    <footer class="footer" id="contact">
        <div class="footer-inner">
            <div class="footer-grid">
                <div class="footer-brand">
                    <div class="footer-brand-logo">
                        <div class="brand-icon">
                            <img src="https://api.builder.io/api/v1/image/assets/TEMP/10a82c5c6d87de97d3583b6c8564df77f595f954?width=1114" alt="Kantin Kita Logo" style="width:100%;height:100%;object-fit:cover;border-radius:inherit;" />
                        </div>
                        <div>
                            <div class="footer-brand-name">Kantin Kita</div>
                            <div class="footer-brand-tagline">Campus Canteen</div>
                        </div>
                    </div>
                    <p class="footer-desc">Solusi praktis untuk makan siang yang sibuk di kampus. Pesan online, ambil langsung.</p>
                    <div class="footer-socials">
                        <a href="#" class="social-btn" aria-label="Instagram">
                            <svg width="14" height="16" viewBox="0 0 14 16" fill="none">
                                <path d="M7.00312 4.40586C5.01562 4.40586 3.4125 6.00898 3.4125 7.99648C3.4125 9.98398 5.01562 11.5871 7.00312 11.5871C8.99062 11.5871 10.5938 9.98398 10.5938 7.99648C10.5938 6.00898 8.99062 4.40586 7.00312 4.40586ZM7.00312 10.3309C5.71875 10.3309 4.66875 9.28398 4.66875 7.99648C4.66875 6.70898 5.71562 5.66211 7.00312 5.66211C8.29062 5.66211 9.3375 6.70898 9.3375 7.99648C9.3375 9.28398 8.2875 10.3309 7.00312 10.3309ZM11.5781 4.25898C11.5781 4.72461 11.2031 5.09648 10.7406 5.09648C10.275 5.09648 9.90312 4.72148 9.90312 4.25898C9.90312 3.79648 10.2781 3.42148 10.7406 3.42148C11.2031 3.42148 11.5781 3.79648 11.5781 4.25898ZM13.9563 5.10898C13.9031 3.98711 13.6469 2.99336 12.825 2.17461C12.0062 1.35586 11.0125 1.09961 9.89062 1.04336C8.73438 0.977734 5.26875 0.977734 4.1125 1.04336C2.99375 1.09648 2 1.35273 1.17812 2.17148C0.35625 2.99023 0.103125 3.98398 0.0468746 5.10586C-0.0187504 6.26211-0.0187504 9.72773 0.0468746 10.884C0.0999996 12.0059 0.35625 12.9996 1.17812 13.8184C2 14.6371 2.99062 14.8934 4.1125 14.9496C5.26875 15.0152 8.73438 15.0152 9.89062 14.9496C11.0125 14.8965 12.0062 14.6402 12.825 13.8184C13.6438 12.9996 13.9 12.0059 13.9563 10.884C14.0219 9.72773 14.0219 6.26523 13.9563 5.10898ZM12.4625 12.1246C12.2188 12.7371 11.7469 13.209 11.1313 13.4559C10.2094 13.8215 8.02187 13.7371 7.00312 13.7371C5.98438 13.7371 3.79375 13.8184 2.875 13.4559C2.2625 13.2121 1.79062 12.7402 1.54375 12.1246C1.17812 11.2027 1.2625 9.01523 1.2625 7.99648C1.2625 6.97773 1.18125 4.78711 1.54375 3.86836C1.7875 3.25586 2.25937 2.78398 2.875 2.53711C3.79687 2.17148 5.98438 2.25586 7.00312 2.25586C8.02187 2.25586 10.2125 2.17461 11.1313 2.53711C11.7438 2.78086 12.2156 3.25273 12.4625 3.86836C12.8281 4.79023 12.7437 6.97773 12.7437 7.99648C12.7437 9.01523 12.8281 11.2059 12.4625 12.1246Z" fill="white" />
                            </svg>
                        </a>
                        <a href="#" class="social-btn" aria-label="Facebook">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M15.75 8C15.75 3.71875 12.2812 0.25 8 0.25C3.71875 0.25 0.25 3.71875 0.25 8C0.25 11.8681 3.08406 15.0744 6.78906 15.6562V10.2403H4.82031V8H6.78906V6.2925C6.78906 4.35031 7.94531 3.2775 9.71625 3.2775C10.5644 3.2775 11.4513 3.42875 11.4513 3.42875V5.335H10.4738C9.51125 5.335 9.21094 5.9325 9.21094 6.54531V8H11.3603L11.0166 10.2403H9.21094V15.6562C12.9159 15.0744 15.75 11.8681 15.75 8Z" fill="white" />
                            </svg>
                        </a>
                        <a href="#" class="social-btn" aria-label="Twitter">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M14.3553 4.74149C14.3655 4.88362 14.3655 5.02577 14.3655 5.1679C14.3655 9.5029 11.066 14.4978 5.03553 14.4978C3.17766 14.4978 1.45178 13.9597 0 13.0258C0.263969 13.0562 0.51775 13.0664 0.791875 13.0664C2.32484 13.0664 3.73603 12.5486 4.86294 11.6654C3.42131 11.6349 2.21319 10.6907 1.79694 9.39124C2 9.42168 2.20303 9.44199 2.41625 9.44199C2.71066 9.44199 3.00509 9.40137 3.27919 9.33034C1.77666 9.02574 0.649719 7.70596 0.649719 6.11205V6.07146C1.08625 6.31512 1.59391 6.4674 2.13194 6.48768C1.24869 5.89884 0.670031 4.89377 0.670031 3.75671C0.670031 3.14759 0.832438 2.58921 1.11672 2.1019C2.73094 4.09174 5.15734 5.39121 7.87813 5.53337C7.82738 5.28971 7.79691 5.03593 7.79691 4.78212C7.79691 2.97499 9.25884 1.50293 11.0761 1.50293C12.0203 1.50293 12.873 1.89887 13.472 2.53846C14.2131 2.39634 14.9238 2.12221 15.5533 1.74659C15.3096 2.50802 14.7918 3.14762 14.1116 3.55368C14.7715 3.48265 15.4111 3.29987 15.9999 3.04609C15.5533 3.6958 14.9949 4.27446 14.3553 4.74149Z" fill="white" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="footer-col">
                    <h4 class="footer-col-title">Menu Cepat</h4>
                    <ul class="footer-links">
                        <li><a href="#">Beranda</a></li>
                        <li><a href="#menu">Menu</a></li>
                        <li><a href="#">Promo</a></li>
                        <li><a href="#">Tentang Kami</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4 class="footer-col-title">Bantuan</h4>
                    <ul class="footer-links">
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Cara Pesan</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4 class="footer-col-title">Kontak</h4>
                    <div class="footer-contact">
                        <div class="contact-item">
                            <svg class="contact-icon" width="12" height="16" viewBox="0 0 12 16" fill="none">
                                <path d="M6.74062 15.6C8.34375 13.5938 12 8.73125 12 6C12 2.6875 9.3125 0 6 0C2.6875 0 0 2.6875 0 6C0 8.73125 3.65625 13.5938 5.25938 15.6C5.64375 16.0781 6.35625 16.0781 6.74062 15.6ZM6 4C6.53043 4 7.03914 4.21071 7.41421 4.58579C7.78929 4.96086 8 5.46957 8 6C8 6.53043 7.78929 7.03914 7.41421 7.41421C7.03914 7.78929 6.53043 8 6 8C5.46957 8 4.96086 7.78929 4.58579 7.41421C4.21071 7.03914 4 6.53043 4 6C4 5.46957 4.21071 4.96086 4.58579 4.58579C4.96086 4.21071 5.46957 4 6 4Z" fill="#42766A" />
                            </svg>
                            <span class="contact-text">Gedung Kantin Lantai 1<br>Universitas Kita</span>
                        </div>
                        <div class="contact-item">
                            <svg class="contact-icon" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M5.15312 0.768478C4.9125 0.187228 4.27812-0.122147 3.67188 0.0434781L0.921875 0.793478C0.378125 0.943478 0 1.43723 0 1.99973C0 9.73098 6.26875 15.9997 14 15.9997C14.5625 15.9997 15.0563 15.6216 15.2063 15.0779L15.9563 12.3279C16.1219 11.7216 15.8125 11.0872 15.2312 10.8466L12.2312 9.5966C11.7219 9.3841 11.1313 9.53098 10.7844 9.9591L9.52188 11.4997C7.32188 10.4591 5.54063 8.67785 4.5 6.47785L6.04063 5.21848C6.46875 4.86848 6.61562 4.28098 6.40312 3.7716L5.15312 0.771603V0.768478Z" fill="#42766A" />
                            </svg>
                            <span class="contact-text">+62 812-3456-7890</span>
                        </div>
                        <div class="contact-item">
                            <svg class="contact-icon" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M1.5 2C0.671875 2 0 2.67188 0 3.5C0 3.97187 0.221875 4.41562 0.6 4.7L7.4 9.8C7.75625 10.0656 8.24375 10.0656 8.6 9.8L15.4 4.7C15.7781 4.41562 16 3.97187 16 3.5C16 2.67188 15.3281 2 14.5 2H1.5ZM0 5.5V12C0 13.1031 0.896875 14 2 14H14C15.1031 14 16 13.1031 16 12V5.5L9.2 10.6C8.4875 11.1344 7.5125 11.1344 6.8 10.6L0 5.5Z" fill="#42766A" />
                            </svg>
                            <span class="contact-text">info@kantinkita.ac.id</span>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="footer-divider">

            <div class="footer-bottom">
                <span class="footer-copyright">© 2024 Kantin Kita. All rights reserved.</span>
                <div class="footer-legal">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="#">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 20);
        });

        // Scroll reveal animation
        const revealEls = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.12,
            rootMargin: '0px 0px -40px 0px'
        });

        revealEls.forEach(el => observer.observe(el));

        // Parallax on hero glow
        window.addEventListener('scroll', () => {
            const glow = document.querySelector('.hero-bg-glow');
            if (glow) {
                glow.style.transform = `translateY(calc(-50% + ${window.scrollY * 0.15}px))`;
            }
        });
    </script>
</body>

</html>