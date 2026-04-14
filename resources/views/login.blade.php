<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Masuk — Kantin Kita</title>
    <link rel="icon" type="image/png" href="https://api.builder.io/api/v1/image/assets/TEMP/10a82c5c6d87de97d3583b6c8564df77f595f954?width=1114" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <style>
        /* ─── Reset & Base ─────────────────────────────── */
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
            --brown-70: rgba(116, 70, 34, 0.70);
            --brown-60: rgba(116, 70, 34, 0.60);
            --brown-20: rgba(116, 70, 34, 0.20);
            --brown-10: rgba(116, 70, 34, 0.10);
            --sage: #42766A;
            --sage-dark: #325c52;
            --white: #FFFFFF;
            --radius-input: 16px;
            --radius-btn: 16px;
            --radius-card: 24px;
        }

        html,
        body {
            height: 100%;
            font-family: 'Poppins', sans-serif;
            background: var(--cream);
            color: var(--brown);
            -webkit-font-smoothing: antialiased;
        }

        /* ─── Page Layout ──────────────────────────────── */
        .login-page {
            display: flex;
            min-height: 100vh;
        }

        /* ─── LEFT — Hero Panel ────────────────────────── */
        .hero-panel {
            position: relative;
            flex: 0 0 60%;
            overflow: hidden;
            background: var(--brown-20);
        }

        .hero-bg-layer {
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse at 30% 40%, rgba(116, 70, 34, 0.18) 0%, transparent 60%),
                radial-gradient(ellipse at 75% 80%, rgba(66, 118, 106, 0.12) 0%, transparent 55%);
        }

        /* floating blobs for depth */
        .hero-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.35;
            animation: floatBlob 8s ease-in-out infinite alternate;
        }

        .hero-blob-1 {
            width: 420px;
            height: 420px;
            background: var(--brown);
            top: -100px;
            left: -80px;
            animation-delay: 0s;
        }

        .hero-blob-2 {
            width: 300px;
            height: 300px;
            background: var(--sage);
            bottom: 60px;
            right: 40px;
            animation-delay: 3s;
        }

        .hero-blob-3 {
            width: 200px;
            height: 200px;
            background: rgba(251, 245, 232, 0.6);
            top: 50%;
            left: 40%;
            animation-delay: 1.5s;
        }

        @keyframes floatBlob {
            from {
                transform: translate(0, 0) scale(1);
            }

            to {
                transform: translate(20px, -20px) scale(1.05);
            }
        }

        .hero-content {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            padding: 80px 48px;
            gap: 36px;
        }

        /* glassmorphism logo card */
        .hero-logo-card {
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.30);
            border-radius: 28px;
            padding: 40px 56px;
            box-shadow:
                0 8px 32px rgba(116, 70, 34, 0.18),
                0 2px 8px rgba(0, 0, 0, 0.10),
                inset 0 1px 0 rgba(255, 255, 255, 0.40);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            max-width: 500px;
            width: 100%;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }

        .hero-logo-card:hover {
            transform: translateY(-6px);
            box-shadow:
                0 20px 60px rgba(116, 70, 34, 0.22),
                0 4px 16px rgba(0, 0, 0, 0.12),
                inset 0 1px 0 rgba(255, 255, 255, 0.40);
        }

        .hero-logo-img {
            width: 100%;
            max-width: 340px;
            height: auto;
            border-radius: 16px;
            object-fit: cover;
            filter: drop-shadow(0 4px 12px rgba(116, 70, 34, 0.30));
        }

        .hero-brand-name {
            color: var(--white);
            font-size: 32px;
            font-weight: 700;
            letter-spacing: -0.5px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.20);
        }

        /* welcome badge */
        .hero-welcome-badge {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: var(--radius-card);
            padding: 24px 40px;
            text-align: center;
            max-width: 420px;
            box-shadow: 0 4px 20px rgba(116, 70, 34, 0.12);
        }

        .hero-welcome-text {
            color: var(--white);
            font-size: 30px;
            font-weight: 700;
            line-height: 1.3;
            letter-spacing: -0.5px;
            text-shadow: 0 2px 12px rgba(0, 0, 0, 0.18);
        }

        /* decorative dots pattern */
        .hero-dots {
            position: absolute;
            bottom: 40px;
            left: 40px;
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
            opacity: 0.20;
        }

        .hero-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--white);
        }

        /* ─── RIGHT — Form Panel ───────────────────────── */
        .form-panel {
            flex: 0 0 40%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 40px;
            background: var(--cream);
            position: relative;
            overflow-y: auto;
        }

        /* subtle top-right glow */
        .form-panel::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(66, 118, 106, 0.10) 0%, transparent 70%);
            pointer-events: none;
        }

        .form-wrapper {
            width: 100%;
            max-width: 448px;
            display: flex;
            flex-direction: column;
            gap: 40px;
            animation: fadeSlideUp 0.6s ease both;
        }

        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(28px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ─── Branding ─────────────────────────────────── */
        .form-branding {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
        }

        .brand-icon-wrap {
            width: 72px;
            height: 72px;
            border-radius: 20px;
            background: var(--sage);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow:
                0 4px 6px rgba(0, 0, 0, 0.10),
                0 10px 15px rgba(0, 0, 0, 0.10);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .brand-icon-wrap:hover {
            transform: rotate(-4deg) scale(1.08);
            box-shadow: 0 8px 24px rgba(66, 118, 106, 0.35);
        }

        .brand-title {
            font-size: 34px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: -0.5px;
            line-height: 1.2;
        }

        .brand-subtitle {
            font-size: 17px;
            font-weight: 500;
            color: var(--brown-70);
            letter-spacing: -0.3px;
        }

        /* ─── Form ─────────────────────────────────────── */
        .login-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .field-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .field-label {
            font-size: 15px;
            font-weight: 600;
            color: var(--brown);
            letter-spacing: -0.3px;
        }

        .field-input-wrap {
            position: relative;
        }

        .field-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            align-items: center;
            pointer-events: none;
            opacity: 0.5;
        }

        .field-input {
            width: 100%;
            height: 56px;
            padding: 0 48px 0 44px;
            border-radius: var(--radius-input);
            border: 2px solid var(--brown-10);
            background: var(--white);
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            font-weight: 400;
            color: var(--brown);
            letter-spacing: -0.3px;
            outline: none;
            transition: border-color 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
        }

        .field-input::placeholder {
            color: var(--brown-60);
            font-weight: 400;
        }

        .field-input:focus {
            border-color: var(--sage);
            background: var(--white);
            box-shadow:
                0 0 0 4px rgba(66, 118, 106, 0.12),
                0 2px 8px rgba(116, 70, 34, 0.06);
        }

        .field-input:hover:not(:focus) {
            border-color: var(--brown-20);
        }

        /* password eye toggle */
        .toggle-eye-btn {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            color: var(--brown);
            opacity: 0.45;
            border-radius: 6px;
            transition: opacity 0.2s ease, background 0.2s ease;
        }

        .toggle-eye-btn:hover {
            opacity: 0.80;
            background: var(--brown-10);
        }

        /* ─── Form Options Row ─────────────────────────── */
        .form-options-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            user-select: none;
        }

        .remember-checkbox {
            width: 17px;
            height: 17px;
            border-radius: 4px;
            border: 1.5px solid rgba(0, 0, 0, 0.30);
            appearance: none;
            -webkit-appearance: none;
            background: var(--white);
            cursor: pointer;
            position: relative;
            transition: border-color 0.2s ease, background 0.2s ease;
            flex-shrink: 0;
        }

        .remember-checkbox:checked {
            background: var(--sage);
            border-color: var(--sage);
        }

        .remember-checkbox:checked::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 5px;
            width: 5px;
            height: 9px;
            border: 2px solid white;
            border-top: none;
            border-left: none;
            transform: rotate(45deg);
        }

        .remember-text {
            font-size: 14px;
            font-weight: 500;
            color: var(--brown);
            letter-spacing: -0.3px;
        }

        .forgot-link {
            font-size: 14px;
            font-weight: 600;
            color: var(--sage);
            text-decoration: none;
            letter-spacing: -0.3px;
            transition: color 0.2s ease, text-decoration 0.2s ease;
        }

        .forgot-link:hover {
            color: var(--sage-dark);
            text-decoration: underline;
        }

        /* ─── Login Button ─────────────────────────────── */
        .btn-login {
            width: 100%;
            height: 56px;
            border-radius: var(--radius-btn);
            border: none;
            background: var(--sage);
            color: var(--white);
            font-family: 'Poppins', sans-serif;
            font-size: 17px;
            font-weight: 600;
            letter-spacing: -0.3px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.10), 0 10px 15px rgba(0, 0, 0, 0.10);
            transition: background 0.25s ease, transform 0.2s ease, box-shadow 0.25s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.12) 0%, transparent 60%);
            pointer-events: none;
        }

        .btn-login:hover {
            background: var(--sage-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(66, 118, 106, 0.35), 0 4px 8px rgba(0, 0, 0, 0.10);
        }

        .btn-login:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
        }

        /* ─── Divider ──────────────────────────────────── */
        .divider-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .divider-line {
            flex: 1;
            height: 1px;
            background: var(--brown-20);
        }

        .divider-text {
            font-size: 13px;
            font-weight: 500;
            color: var(--brown-60);
            letter-spacing: -0.3px;
            white-space: nowrap;
        }

        /* ─── Google Button ────────────────────────────── */
        .btn-google {
            width: 100%;
            height: 56px;
            border-radius: var(--radius-btn);
            border: 2px solid var(--brown-10);
            background: var(--white);
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            font-weight: 600;
            color: var(--brown);
            letter-spacing: -0.3px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            transition: border-color 0.25s ease, transform 0.2s ease, box-shadow 0.25s ease, background 0.25s ease;
        }

        .btn-google:hover {
            border-color: var(--brown-20);
            background: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(116, 70, 34, 0.12);
        }

        .btn-google:active {
            transform: translateY(0);
        }

        /* ─── Signup Link ──────────────────────────────── */
        .signup-section {
            border-top: 1px solid var(--brown-10);
            padding-top: 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }

        .signup-hint {
            font-size: 15px;
            font-weight: 400;
            color: var(--brown-70);
            letter-spacing: -0.3px;
        }

        .signup-link {
            font-size: 15px;
            font-weight: 600;
            color: var(--sage);
            text-decoration: none;
            letter-spacing: -0.3px;
            position: relative;
            transition: color 0.2s ease;
        }

        .signup-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--sage);
            border-radius: 2px;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.25s ease;
        }

        .signup-link:hover {
            color: var(--sage-dark);
        }

        .signup-link:hover::after {
            transform: scaleX(1);
        }

        /* ─── Responsive ───────────────────────────────── */
        @media (max-width: 900px) {
            .hero-panel {
                display: none;
            }

            .form-panel {
                flex: 1;
                padding: 40px 24px;
            }
        }

        @media (max-width: 480px) {
            .brand-title {
                font-size: 26px;
            }

            .form-panel {
                padding: 32px 20px;
            }
        }
    </style>
</head>

<body>
    <main class="login-page">

        <!-- ── LEFT HERO PANEL ── -->
        <section class="hero-panel">
            <div class="hero-bg-layer"></div>
            <div class="hero-blob hero-blob-1"></div>
            <div class="hero-blob hero-blob-2"></div>
            <div class="hero-blob hero-blob-3"></div>

            <div class="hero-content">
                <!-- glassmorphism card with logo -->
                <div class="hero-logo-card">
                    <img
                        class="hero-logo-img"
                        src="https://api.builder.io/api/v1/image/assets/TEMP/10a82c5c6d87de97d3583b6c8564df77f595f954?width=1114"
                        alt="Kantin Kita Logo" />
                    <span class="hero-brand-name">KantinKita</span>
                </div>

                <!-- welcome badge -->
                <div class="hero-welcome-badge">
                    <p class="hero-welcome-text">Selamat Datang di<br />Kantin Kita</p>
                </div>
            </div>

            <!-- decorative dot grid -->
            <div class="hero-dots">
                @for ($r = 0; $r < 4; $r++)
                    @for ($c=0; $c < 5; $c++)
                    <div class="hero-dot">
            </div>
            @endfor
            @endfor
            </div>
        </section>

        <!-- ── RIGHT FORM PANEL ── -->
        <section class="form-panel">
            <div class="form-wrapper">

                <!-- Branding -->
                <div class="form-branding">
                    <div class="brand-icon-wrap">
                        <img src="https://api.builder.io/api/v1/image/assets/TEMP/10a82c5c6d87de97d3583b6c8564df77f595f954?width=1114" alt="Kantin Kita Logo" style="width:100%;height:100%;object-fit:cover;border-radius:inherit;" />
                    </div>
                    <h1 class="brand-title">Kantin Kita</h1>
                    <p class="brand-subtitle">Masuk ke akun Anda</p>
                </div>

                <!-- Form -->
                <form class="login-form" method="POST" action="/login">
                    @csrf

                    <!-- Email / Username -->
                    <div class="field-group">
                        <label class="field-label" for="identifier">Email atau Username</label>
                        <div class="field-input-wrap">
                            <span class="field-icon">
                                <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 8C8.06087 8 9.07828 7.57857 9.82843 6.82843C10.5786 6.07828 11 5.06087 11 4C11 2.93913 10.5786 1.92172 9.82843 1.17157C9.07828 0.421427 8.06087 0 7 0C5.93913 0 4.92172 0.421427 4.17157 1.17157C3.42143 1.92172 3 2.93913 3 4C3 5.06087 3.42143 6.07828 4.17157 6.82843C4.92172 7.57857 5.93913 8 7 8ZM5.57188 9.5C2.49375 9.5 0 11.9937 0 15.0719C0 15.5844 0.415625 16 0.928125 16H13.0719C13.5844 16 14 15.5844 14 15.0719C14 11.9937 11.5063 9.5 8.42813 9.5H5.57188Z" fill="#744622" />
                                </svg>
                            </span>
                            <input
                                class="field-input"
                                id="identifier"
                                name="identifier"
                                type="text"
                                placeholder="Masukkan email atau username"
                                autocomplete="username"
                                required />
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="field-group">
                        <label class="field-label" for="password">Password</label>
                        <div class="field-input-wrap">
                            <span class="field-icon">
                                <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.5 4.5V6H9.5V4.5C9.5 3.11875 8.38125 2 7 2C5.61875 2 4.5 3.11875 4.5 4.5ZM2.5 6V4.5C2.5 2.01562 4.51562 0 7 0C9.48438 0 11.5 2.01562 11.5 4.5V6H12C13.1031 6 14 6.89687 14 8V14C14 15.1031 13.1031 16 12 16H2C0.896875 16 0 15.1031 0 14V8C0 6.89687 0.896875 6 2 6H2.5Z" fill="#744622" />
                                </svg>
                            </span>
                            <input
                                class="field-input"
                                id="password"
                                name="password"
                                type="password"
                                placeholder="Masukkan password"
                                autocomplete="current-password"
                                required />
                            <button type="button" class="toggle-eye-btn" id="togglePassword" aria-label="Tampilkan/sembunyikan password">
                                <svg id="eyeIcon" width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 1C6.475 1 4.45313 2.15 2.98125 3.51875C1.51875 4.875 0.540625 6.5 0.078125 7.61562C-0.025 7.8625 -0.025 8.1375 0.078125 8.38437C0.540625 9.5 1.51875 11.125 2.98125 12.4812C4.45313 13.85 6.475 15 9 15C11.525 15 13.5469 13.85 15.0188 12.4812C16.4813 11.1219 17.4594 9.5 17.925 8.38437C18.0281 8.1375 18.0281 7.8625 17.925 7.61562C17.4594 6.5 16.4813 4.875 15.0188 3.51875C13.5469 2.15 11.525 1 9 1ZM4.5 8C4.5 6.80653 4.97411 5.66193 5.81802 4.81802C6.66193 3.97411 7.80653 3.5 9 3.5C10.1935 3.5 11.3381 3.97411 12.182 4.81802C13.0259 5.66193 13.5 6.80653 13.5 8C13.5 9.19347 13.0259 10.3381 12.182 11.182C11.3381 12.0259 10.1935 12.5 9 12.5C7.80653 12.5 6.66193 12.0259 5.81802 11.182C4.97411 10.3381 4.5 9.19347 4.5 8ZM9 6C9 7.10313 8.10313 8 7 8C6.77813 8 6.56563 7.9625 6.36563 7.89687C6.19375 7.84062 5.99375 7.94688 6 8.12813C6.00938 8.34375 6.04063 8.55937 6.1 8.775C6.52813 10.375 8.175 11.325 9.775 10.8969C11.375 10.4688 12.325 8.82188 11.8969 7.22188C11.55 5.925 10.4031 5.05312 9.12813 5C8.94688 4.99375 8.84063 5.19062 8.89688 5.36562C8.9625 5.56562 9 5.77812 9 6Z" fill="#744622" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Options row -->
                    <div class="form-options-row">
                        <label class="remember-label">
                            <input class="remember-checkbox" type="checkbox" name="remember" />
                            <span class="remember-text">Ingat saya</span>
                        </label>
                        <a class="forgot-link" href="#">Lupa password?</a>
                    </div>

                    <!-- CTA button -->
                    <button class="btn-login" type="submit">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.66055 3.72305L11.9777 8.04023C12.2309 8.29336 12.375 8.64141 12.375 9C12.375 9.35859 12.2309 9.70664 11.9777 9.95977L7.66055 14.277C7.43555 14.502 7.1332 14.625 6.8168 14.625C6.15937 14.625 5.625 14.0906 5.625 13.4332V11.25H1.125C0.502734 11.25 0 10.7473 0 10.125V7.875C0 7.25273 0.502734 6.75 1.125 6.75H5.625V4.5668C5.625 3.90937 6.15937 3.375 6.8168 3.375C7.1332 3.375 7.43555 3.50156 7.66055 3.72305ZM12.375 14.625H14.625C15.2473 14.625 15.75 14.1223 15.75 13.5V4.5C15.75 3.87773 15.2473 3.375 14.625 3.375H12.375C11.7527 3.375 11.25 2.87227 11.25 2.25C11.25 1.62773 11.7527 1.125 12.375 1.125H14.625C16.4883 1.125 18 2.63672 18 4.5V13.5C18 15.3633 16.4883 16.875 14.625 16.875H12.375C11.7527 16.875 11.25 16.3723 11.25 15.75C11.25 15.1277 11.7527 14.625 12.375 14.625Z" fill="white" />
                        </svg>
                        Masuk
                    </button>

                    <!-- Divider -->
                    <div class="divider-row">
                        <div class="divider-line"></div>
                        <span class="divider-text">atau</span>
                        <div class="divider-line"></div>
                    </div>

                    <!-- Google Login -->
                    <button class="btn-google" type="button">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.25 8.18125C15.25 12.6031 12.2219 15.75 7.75 15.75C3.4625 15.75 0 12.2875 0 8C0 3.7125 3.4625 0.25 7.75 0.25C9.8375 0.25 11.5938 1.01562 12.9469 2.27813L10.8375 4.30625C8.07812 1.64375 2.94688 3.64375 2.94688 8C2.94688 10.7031 5.10625 12.8938 7.75 12.8938C10.8188 12.8938 11.9688 10.6938 12.15 9.55313H7.75V6.8875H15.1281C15.2 7.28437 15.25 7.66562 15.25 8.18125Z" fill="#EF4444" />
                        </svg>
                        Masuk dengan Google
                    </button>
                </form>

                <!-- Signup link -->
                <div class="signup-section">
                    <p class="signup-hint">Belum punya akun?</p>
                    <a class="signup-link" href="#">Daftar sekarang</a>
                </div>

            </div><!-- /form-wrapper -->
        </section>

    </main>

    <script>
        // Password visibility toggle
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        toggleBtn.addEventListener('click', () => {
            const isText = passwordInput.type === 'text';
            passwordInput.type = isText ? 'password' : 'text';
            toggleBtn.style.opacity = isText ? '0.45' : '0.80';
        });

        // Subtle parallax on hero blobs via mouse move
        const heroBlobEl1 = document.querySelector('.hero-blob-1');
        const heroBlobEl2 = document.querySelector('.hero-blob-2');
        const heroPanel = document.querySelector('.hero-panel');

        if (heroPanel) {
            heroPanel.addEventListener('mousemove', (e) => {
                const rect = heroPanel.getBoundingClientRect();
                const cx = (e.clientX - rect.left) / rect.width - 0.5;
                const cy = (e.clientY - rect.top) / rect.height - 0.5;
                heroBlobEl1.style.transform = `translate(${cx * 20}px, ${cy * 20}px)`;
                heroBlobEl2.style.transform = `translate(${cx * -15}px, ${cy * -15}px)`;
            });
            heroPanel.addEventListener('mouseleave', () => {
                heroBlobEl1.style.transform = '';
                heroBlobEl2.style.transform = '';
            });
        }
    </script>
</body>

</html>