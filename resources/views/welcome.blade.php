<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK Stunting - Puskesmas Losari</title>
    <meta name="description" content="Sistem Pendukung Keputusan untuk pemantauan dan penilaian status gizi balita di Puskesmas Losari, membantu menemukan balita yang paling membutuhkan intervensi lebih awal.">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Ccircle cx='32' cy='32' r='32' fill='%230B2545'/%3E%3Cpath d='M14 34 L24 34 L28 24 L36 44 L40 34 L50 34' fill='none' stroke='%237AA9D6' stroke-width='4' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root {
            --deep-teal: #0B2545;
            --teal: #14487F;
            --teal-light: #4C7EB5;
            --sky: #7AA9D6;
            --sky-soft: #EAF3FC;
            --leaf: #2F9E6E;
            --leaf-light: #6BBF9A;
            --leaf-soft: #E7F5EE;
            --sage: #E9EFF7;
            --sand: #F6F8FB;
            --ink: #1F2937;
            --ink-soft: #5B6472;
            --line: #E4E9F0;
            --white: #FFFFFF;
            --radius-lg: 20px;
            --radius-md: 14px;
            --radius-sm: 10px;
            --shadow-soft: 0 4px 20px rgba(11, 37, 69, 0.06);
            --shadow-lift: 0 16px 36px rgba(11, 37, 69, 0.14);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--white);
            color: var(--ink);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        img, svg { max-width: 100%; display: block; }

        h1, h2, h3, h4,
        .display-font {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--deep-teal);
        }

        a { text-decoration: none; color: inherit; }

        .container-custom {
            max-width: 1180px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.76rem;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            color: var(--teal-light);
            margin-bottom: 14px;
        }

        .eyebrow::before {
            content: "";
            width: 18px;
            height: 2px;
            background: var(--leaf);
            display: inline-block;
        }

        .btn-nav {
            padding: 9px 18px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.88rem;
            transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
        }

        .btn-primary-nav {
            background-color: var(--teal);
            color: white;
        }
        .btn-primary-nav:hover { background-color: var(--deep-teal); color: white; }

        .btn-ghost-nav {
            border: 1px solid var(--line);
            color: var(--deep-teal);
        }
        .btn-ghost-nav:hover { background-color: var(--sage); }

        /* ---------------------------------- */
        /* Navbar                              */
        /* ---------------------------------- */
        .site-nav {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--line);
        }

        .site-nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 0;
        }

        .site-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--deep-teal);
        }

        .site-brand-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--sky-soft);
            color: var(--teal);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .site-brand small {
            display: block;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            font-size: 0.68rem;
            color: var(--ink-soft);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .nav-links a.nav-link-item {
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--ink-soft);
            transition: color 0.2s ease;
        }
        .nav-links a.nav-link-item:hover { color: var(--deep-teal); }

        .nav-actions { display: flex; align-items: center; gap: 10px; }

        .nav-toggle-btn {
            display: none;
            width: 40px; height: 40px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--line);
            background: white;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: var(--deep-teal);
            flex-shrink: 0;
            cursor: pointer;
        }

        /* Panel menu mobile - tersembunyi secara default */
        .mobile-menu-panel {
            display: none;
            flex-direction: column;
            gap: 4px;
            padding: 14px 0 18px;
            border-top: 1px solid var(--line);
        }

        .mobile-menu-panel.show { display: flex; }

        .mobile-menu-panel a.nav-link-item {
            padding: 10px 4px;
            font-size: 0.94rem;
            border-bottom: 1px solid var(--line);
        }

        .mobile-menu-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 12px;
        }

        .mobile-menu-actions .btn-nav {
            text-align: center;
            width: 100%;
        }

        /* ---------------------------------- */
        /* Hero                                */
        /* ---------------------------------- */
        .hero {
            position: relative;
            padding: 76px 0 90px;
            overflow: hidden;
            background: linear-gradient(180deg, var(--sky-soft) 0%, var(--white) 65%);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            gap: 56px;
            align-items: center;
        }

        .hero h1 {
            font-size: 2.7rem;
            font-weight: 800;
            line-height: 1.18;
            letter-spacing: -0.5px;
            margin-bottom: 18px;
        }

        .hero h1 .accent { color: var(--leaf); }

        .hero p.lead {
            font-size: 1.05rem;
            color: var(--ink-soft);
            max-width: 480px;
            margin-bottom: 32px;
        }

        .hero-actions { display: flex; gap: 14px; flex-wrap: wrap; margin-bottom: 30px; }

        .btn-hero-primary {
            background-color: var(--teal);
            color: white;
            padding: 13px 26px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.94rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.2s ease, transform 0.2s ease;
        }
        .btn-hero-primary:hover { background-color: var(--deep-teal); color: white; transform: translateY(-2px); }

        .btn-hero-secondary {
            border: 1.5px solid var(--line);
            color: var(--deep-teal);
            padding: 13px 26px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.94rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: border-color 0.2s ease, background-color 0.2s ease;
        }
        .btn-hero-secondary:hover { background-color: var(--sage); border-color: var(--sky); }

        .hero-trust {
            display: flex;
            gap: 22px;
            font-size: 0.82rem;
            color: var(--ink-soft);
            flex-wrap: wrap;
        }
        .hero-trust span { display: flex; align-items: center; gap: 6px; }
        .hero-trust span:first-child i { color: var(--teal-light); }
        .hero-trust span:last-child i { color: var(--leaf); }

        /* Signature visual: WHO-style growth curve chart, since stunting
           is literally diagnosed by tracking a child's height-for-age curve. */
        .hero-visual {
            position: relative;
            background: var(--white);
            border: 1px solid var(--line);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lift);
            padding: 28px 24px 20px;
        }

        .hero-visual-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
        }

        .hero-visual-title {
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--deep-teal);
        }

        .hero-visual-tag {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.4px;
            padding: 3px 10px;
            border-radius: 999px;
            background: var(--leaf-soft);
            color: var(--leaf);
        }

        .growth-chart-caption {
            font-size: 0.74rem;
            color: var(--ink-soft);
            margin-top: 6px;
        }

        .legend-row {
            display: flex;
            gap: 16px;
            margin-top: 14px;
            flex-wrap: wrap;
            font-size: 0.72rem;
            color: var(--ink-soft);
        }
        .legend-row span { display: flex; align-items: center; gap: 6px; }
        .legend-dot { width: 9px; height: 9px; border-radius: 50%; display: inline-block; }

        /* ---------------------------------- */
        /* Section shared                      */
        /* ---------------------------------- */
        .section { padding: 84px 0; }
        .section-alt { background-color: var(--sand); }

        .section-head {
            max-width: 620px;
            margin-bottom: 48px;
        }
        .section-head.center { margin-left: auto; margin-right: auto; text-align: center; }

        .section-head h2 {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.3px;
            margin-bottom: 12px;
        }
        .section-head p { color: var(--ink-soft); font-size: 1rem; }

        /* ---------------------------------- */
        /* Apa itu stunting                    */
        /* ---------------------------------- */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .info-card {
            background: white;
            border: 1px solid var(--line);
            border-radius: var(--radius-md);
            padding: 28px 24px;
            box-shadow: var(--shadow-soft);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .info-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-lift); }

        .info-card-icon {
            width: 46px; height: 46px;
            border-radius: 12px;
            background: var(--sky-soft);
            color: var(--teal);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem;
            margin-bottom: 16px;
        }

        .info-card:nth-child(2) .info-card-icon {
            background: var(--leaf-soft);
            color: var(--leaf);
        }

        .info-card h3 { font-size: 1.05rem; font-weight: 700; margin-bottom: 8px; }
        .info-card p { font-size: 0.9rem; color: var(--ink-soft); }

        /* ---------------------------------- */
        /* Cara kerja - real sequential steps  */
        /* ---------------------------------- */
        .steps-wrap { position: relative; }

        .steps-line {
            position: absolute;
            top: 26px;
            left: 6%;
            right: 6%;
            height: 2px;
            background: var(--line);
            z-index: 0;
        }

        .steps-grid {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        .step-item { text-align: center; }

        .step-num {
            width: 52px; height: 52px;
            border-radius: 50%;
            background: var(--teal);
            color: white;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 1.1rem;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 18px;
            box-shadow: 0 8px 18px rgba(20, 72, 127, 0.25);
        }

        .step-item:nth-child(even) .step-num {
            background: var(--leaf);
            box-shadow: 0 8px 18px rgba(47, 158, 110, 0.25);
        }

        .step-item h4 { font-size: 0.98rem; font-weight: 700; margin-bottom: 8px; }
        .step-item p { font-size: 0.86rem; color: var(--ink-soft); }

        /* ---------------------------------- */
        /* Fitur                               */
        /* ---------------------------------- */
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .feature-row {
            display: flex;
            gap: 16px;
            background: white;
            border: 1px solid var(--line);
            border-radius: var(--radius-md);
            padding: 22px;
        }

        .feature-row-icon {
            width: 42px; height: 42px;
            border-radius: 10px;
            background: var(--deep-teal);
            color: white;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.05rem;
            flex-shrink: 0;
        }

        .feature-row:nth-child(even) .feature-row-icon {
            background: var(--leaf);
        }

        .feature-row h4 { font-size: 0.96rem; font-weight: 700; margin-bottom: 4px; }
        .feature-row p { font-size: 0.86rem; color: var(--ink-soft); }

        /* ---------------------------------- */
        /* CTA banner                          */
        /* ---------------------------------- */
        .cta-banner {
            background: linear-gradient(135deg, var(--deep-teal) 0%, var(--teal) 55%, var(--leaf) 130%);
            border-radius: var(--radius-lg);
            padding: 56px 48px;
            color: white;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;
            flex-wrap: wrap;
        }

        .cta-banner::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 900 400' fill='none'%3E%3Cpath d='M-40 360 C 120 330, 200 240, 300 190 C 410 135, 430 60, 560 20 C 650 -10, 700 -20, 820 -50' stroke='%23FFFFFF' stroke-opacity='0.08' stroke-width='4'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right bottom;
            background-size: cover;
            pointer-events: none;
        }

        .cta-banner-text { position: relative; max-width: 480px; }
        .cta-banner-text h2 { color: white; font-size: 1.7rem; margin-bottom: 10px; }
        .cta-banner-text p { color: rgba(255,255,255,0.78); font-size: 0.95rem; }

        .cta-banner-actions { position: relative; display: flex; gap: 12px; flex-wrap: wrap; }

        .btn-cta-light {
            background: white;
            color: var(--deep-teal);
            padding: 12px 24px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.9rem;
            transition: transform 0.2s ease;
        }
        .btn-cta-light:hover { transform: translateY(-2px); }

        .btn-cta-outline {
            border: 1.5px solid rgba(255,255,255,0.4);
            color: white;
            padding: 12px 24px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.9rem;
            transition: border-color 0.2s ease, background-color 0.2s ease;
        }
        .btn-cta-outline:hover { background: rgba(255,255,255,0.1); border-color: white; }

        /* ---------------------------------- */
        /* Footer                              */
        /* ---------------------------------- */
        .site-footer {
            border-top: 1px solid var(--line);
            padding: 44px 0 26px;
        }

        .footer-top {
            display: flex;
            justify-content: space-between;
            gap: 30px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .footer-brand p {
            font-size: 0.86rem;
            color: var(--ink-soft);
            max-width: 320px;
            margin-top: 10px;
        }

        .footer-contact { font-size: 0.86rem; color: var(--ink-soft); }
        .footer-contact div { display: flex; align-items: center; gap: 8px; margin-bottom: 8px; }
        .footer-contact i { color: var(--teal-light); }

        .footer-bottom {
            border-top: 1px solid var(--line);
            padding-top: 20px;
            text-align: center;
            font-size: 0.8rem;
            color: var(--ink-soft);
        }

        /* ---------------------------------- */
        /* Responsive                          */
        /* ---------------------------------- */
        @media (max-width: 991.98px) {
            .hero-grid { grid-template-columns: 1fr; }
            .hero-visual { order: -1; }
            .info-grid { grid-template-columns: repeat(2, 1fr); }
            .steps-grid { grid-template-columns: repeat(2, 1fr); row-gap: 36px; }
            .steps-line { display: none; }
            .feature-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 767.98px) {
            .nav-links { display: none; }
            .nav-actions { display: none; }
            .nav-toggle-btn { display: flex; }

            .hero { padding: 48px 0 56px; }
            .hero h1 { font-size: 1.85rem; }
            .hero p.lead { font-size: 0.95rem; }
            .hero-actions { flex-direction: column; align-items: stretch; }
            .hero-actions a { justify-content: center; }
            .hero-trust { flex-direction: column; gap: 10px; }

            .hero-visual { padding: 20px 16px 16px; }

            .info-grid { grid-template-columns: 1fr; }
            .steps-grid { grid-template-columns: 1fr; }

            .cta-banner {
                padding: 30px 22px;
                flex-direction: column;
                align-items: flex-start;
            }
            .cta-banner-actions { width: 100%; }
            .cta-banner-actions a { flex: 1; text-align: center; }

            .footer-top { flex-direction: column; }

            .section { padding: 52px 0; }
            .section-head h2 { font-size: 1.55rem; }
        }

        @media (max-width: 420px) {
            .container-custom { padding: 0 16px; }
            .site-brand span > small { display: block; }
            .hero h1 { font-size: 1.6rem; }
            .cta-banner-actions { flex-direction: column; }
        }

        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            * { transition: none !important; }
        }

        a:focus-visible, button:focus-visible {
            outline: 2px solid var(--sky);
            outline-offset: 2px;
        }
    </style>
</head>
<body>

    <!-- ================= NAVBAR ================= -->
    <nav class="site-nav">
        <div class="container-custom">
            <div class="site-nav-inner">
                <div class="site-brand">
                    <span class="site-brand-icon"><i class="bi bi-activity"></i></span>
                    <span>
                        SPK Stunting
                        <small>Puskesmas Losari</small>
                    </span>
                </div>

                <div class="nav-links">
                    <a href="#tentang" class="nav-link-item">Tentang Stunting</a>
                    <a href="#cara-kerja" class="nav-link-item">Cara Kerja</a>
                    <a href="#fitur" class="nav-link-item">Fitur</a>
                </div>
                <button class="nav-toggle-btn" type="button" onclick="toggleMobileMenu()" aria-label="Buka menu" aria-expanded="false" id="navToggleBtn">
                    <i class="bi bi-list" id="navToggleIcon"></i>
                </button>
            </div>

            <!-- Panel menu khusus mobile -->
            <div class="mobile-menu-panel" id="mobileMenuPanel">
                <a href="#tentang" class="nav-link-item" onclick="closeMobileMenu()">Tentang Stunting</a>
                <a href="#cara-kerja" class="nav-link-item" onclick="closeMobileMenu()">Cara Kerja</a>
                <a href="#fitur" class="nav-link-item" onclick="closeMobileMenu()">Fitur</a>

                <div class="mobile-menu-actions">
                    <a href="{{ route('petugas.login') }}" class="btn-nav btn-ghost-nav">Login Petugas</a>
                    <a href="{{ route('petugas.register') }}" class="btn-nav btn-primary-nav">Daftar Petugas</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- ================= HERO ================= -->
    <header class="hero">
        <div class="container-custom hero-grid">
            <div>
                <span class="eyebrow">Sistem Pendukung Keputusan Gizi Balita</span>
                <h1>Menemukan balita yang <span class="">paling butuh bantuan</span>, lebih awal.</h1>
                <p class="lead">
                    SPK Stunting membantu Puskesmas Losari mendata, menilai, dan memprioritaskan balita berdasarkan risiko stunting, sehingga intervensi gizi bisa tepat sasaran dan tidak terlambat.
                </p>

                <div class="hero-actions">
                    <a href="{{ route('petugas.register') }}" class="btn-hero-primary">
                        <i class="bi bi-person-badge-fill"></i> Daftar Sebagai Petugas
                    </a>
                    <a href="{{ route('petugas.login') }}" class="btn-hero-secondary">
                        <i class="bi bi-box-arrow-in-right"></i> Login Petugas
                    </a>
                </div>

                <div class="hero-trust">
                    <span><i class="bi bi-shield-check"></i> Data balita tersimpan aman</span>
                    <span><i class="bi bi-graph-up-arrow"></i> Penilaian berbasis kriteria objektif</span>
                </div>
            </div>

            <!-- Signature visual: grafik kurva pertumbuhan, karena stunting
                 didiagnosis lewat kurva tinggi badan menurut usia -->
            <div class="hero-visual">
                <div class="hero-visual-header">
                    <span class="hero-visual-title">Kurva Tinggi Badan menurut Usia</span>
                    <span class="hero-visual-tag">Ilustrasi</span>
                </div>

                <svg viewBox="0 0 460 260" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 230 C 90 220, 180 205, 460 150 L 460 260 L 0 260 Z" fill="#FBEAEA" opacity="0.7"/>
                    <path d="M0 190 C 90 175, 180 150, 460 90 L 460 150 C 180 205, 90 220, 0 230 Z" fill="#EAF3FC"/>
                    <path d="M0 190 C 90 175, 180 150, 460 90 L 460 40 C 180 90, 90 110, 0 130 Z" fill="#E7F5EC" opacity="0.6"/>

                    <path d="M0 210 C 90 197, 180 177, 460 120" stroke="#B8C4D2" stroke-width="1.5" stroke-dasharray="4 4" fill="none"/>

                    <path d="M10 225 C 70 218, 120 200, 170 195 C 230 188, 280 165, 340 140 C 390 120, 420 105, 450 95"
                          stroke="#14487F" stroke-width="3.5" fill="none" stroke-linecap="round"/>

                    <circle cx="10" cy="225" r="4.5" fill="#14487F"/>
                    <circle cx="170" cy="195" r="4.5" fill="#14487F"/>
                    <circle cx="340" cy="140" r="4.5" fill="#14487F"/>
                    <circle cx="450" cy="95" r="5.5" fill="#2F9E6E" stroke="white" stroke-width="2"/>

                    <line x1="0" y1="0" x2="0" y2="248" stroke="#E4E9F0" stroke-width="1"/>
                    <line x1="0" y1="248" x2="460" y2="248" stroke="#E4E9F0" stroke-width="1"/>
                </svg>

                <p class="growth-chart-caption">Garis biru: pertumbuhan balita hasil pemantauan petugas. Titik hijau menandai capaian terbaru yang membaik.</p>

                <div class="legend-row">
                    <span><i class="legend-dot" style="background:#2F9E6E"></i> Di atas rata-rata</span>
                    <span><i class="legend-dot" style="background:#4C7EB5"></i> Normal</span>
                    <span><i class="legend-dot" style="background:#A32C2C"></i> Berisiko stunting</span>
                </div>
            </div>
        </div>
    </header>

    <!-- ================= TENTANG STUNTING ================= -->
    <section class="section" id="tentang">
        <div class="container-custom">
            <div class="section-head center">
                <span class="eyebrow" style="justify-content:center">Mengenal Stunting</span>
                <h2>Kondisi yang bisa dicegah, jika dikenali lebih awal</h2>
                <p>Stunting adalah gangguan tumbuh kembang pada anak akibat kekurangan gizi kronis, biasanya terjadi dalam 1.000 hari pertama kehidupan. Semakin cepat dikenali, semakin besar peluang untuk ditangani.</p>
            </div>

            <div class="info-grid">
                <div class="info-card">
                    <div class="info-card-icon"><i class="bi bi-rulers"></i></div>
                    <h3>Ditandai dari Tinggi Badan</h3>
                    <p>Anak dikatakan berisiko stunting bila tinggi badannya berada jauh di bawah standar untuk anak seusianya, berdasarkan kurva pertumbuhan WHO.</p>
                </div>
                <div class="info-card">
                    <div class="info-card-icon"><i class="bi bi-clock-history"></i></div>
                    <h3>Periode Emas 1.000 Hari</h3>
                    <p>Sejak masa kehamilan hingga anak berusia 2 tahun adalah periode paling menentukan untuk mencegah dampak jangka panjang stunting.</p>
                </div>
                <div class="info-card">
                    <div class="info-card-icon"><i class="bi bi-clipboard2-pulse"></i></div>
                    <h3>Butuh Pemantauan Rutin</h3>
                    <p>Pemeriksaan berkala di Posyandu dan Puskesmas membantu mendeteksi perubahan pertumbuhan sejak dini, sebelum kondisinya memburuk.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= CARA KERJA ================= -->
    <section class="section section-alt" id="cara-kerja">
        <div class="container-custom">
            <div class="section-head center">
                <span class="eyebrow" style="justify-content:center">Alur Sistem</span>
                <h2>Dari pendataan hingga prioritas penanganan</h2>
                <p>Empat langkah yang dijalankan sistem untuk membantu Puskesmas Losari menentukan balita mana yang paling perlu didahulukan.</p>
            </div>

            <div class="steps-wrap">
                <div class="steps-line"></div>
                <div class="steps-grid">
                    <div class="step-item">
                        <div class="step-num">1</div>
                        <h4>Petugas Mendata Balita</h4>
                        <p>Data dasar balita di wilayah kerja dicatat oleh petugas Puskesmas melalui sistem.</p>
                    </div>
                    <div class="step-item">
                        <div class="step-num">2</div>
                        <h4>Admin Menilai Kriteria</h4>
                        <p>Setiap balita dinilai berdasarkan kriteria gizi yang sudah ditetapkan, seperti berat dan tinggi badan.</p>
                    </div>
                    <div class="step-item">
                        <div class="step-num">3</div>
                        <h4>Sistem Menghitung Skor</h4>
                        <p>Nilai dari tiap kriteria diproses otomatis menggunakan metode perhitungan pembobotan.</p>
                    </div>
                    <div class="step-item">
                        <div class="step-num">4</div>
                        <h4>Hasil Prioritas Ditampilkan</h4>
                        <p>Ranking balita dengan risiko tertinggi ditampilkan agar penanganan bisa lebih terarah.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= FITUR ================= -->
    <section class="section" id="fitur">
        <div class="container-custom">
            <div class="section-head">
                <span class="eyebrow">Yang Bisa Dilakukan Sistem</span>
                <h2>Alat bantu kerja harian petugas dan admin</h2>
            </div>

            <div class="feature-grid">
                <div class="feature-row">
                    <div class="feature-row-icon"><i class="bi bi-person-lines-fill"></i></div>
                    <div>
                        <h4>Pendataan Balita Digital</h4>
                        <p>Catat data balita sekali, tersimpan rapi dan bisa diakses kembali kapan saja.</p>
                    </div>
                </div>
                <div class="feature-row">
                    <div class="feature-row-icon"><i class="bi bi-sliders"></i></div>
                    <div>
                        <h4>Kriteria Penilaian Fleksibel</h4>
                        <p>Admin dapat mengatur kriteria dan bobot penilaian sesuai kebutuhan Puskesmas.</p>
                    </div>
                </div>
                <div class="feature-row">
                    <div class="feature-row-icon"><i class="bi bi-bar-chart-line-fill"></i></div>
                    <div>
                        <h4>Hasil Ranking Otomatis</h4>
                        <p>Sistem menghitung dan mengurutkan balita berdasarkan tingkat risiko secara otomatis.</p>
                    </div>
                </div>
                <div class="feature-row">
                    <div class="feature-row-icon"><i class="bi bi-printer-fill"></i></div>
                    <div>
                        <h4>Laporan Siap Cetak</h4>
                        <p>Hasil penilaian dapat dicetak untuk keperluan pelaporan dan koordinasi lapangan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= CTA ================= -->
    <section class="section" style="padding-top:0;">
        <div class="container-custom">
            <div class="cta-banner">
                <div class="cta-banner-text">
                    <h2>Siap membantu memantau gizi balita di wilayah Anda?</h2>
                    <p>Daftar atau masuk sebagai petugas untuk mulai mendata balita dan memantau hasil penilaian gizi.</p>
                </div>
                <div class="cta-banner-actions">
                    <a href="{{ route('petugas.register') }}" class="btn-cta-light">Daftar Petugas</a>
                    <a href="{{ route('petugas.login') }}" class="btn-cta-outline">Login Petugas</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= FOOTER ================= -->
    <footer class="site-footer">
        <div class="container-custom">
            <div class="footer-top">
                <div class="footer-brand">
                    <div class="site-brand">
                        <span class="site-brand-icon"><i class="bi bi-activity"></i></span>
                        <span>SPK Stunting</span>
                    </div>
                    <p>Sistem pendukung keputusan untuk pemantauan dan penilaian status gizi balita, digunakan oleh Puskesmas Losari.</p>
                </div>

                <div class="footer-contact">
                    <div><i class="bi bi-geo-alt-fill"></i> Puskesmas Losari, Kabupaten setempat</div>
                    <div><i class="bi bi-telephone-fill"></i> (0231) 000-0000</div>
                    <div><i class="bi bi-envelope-fill"></i> info@puskesmaslosari.go.id</div>
                </div>
            </div>

            <div class="footer-bottom">
                &copy; 2026 Puskesmas Losari. Seluruh hak cipta dilindungi.
            </div>
        </div>
    </footer>
    <script>
        const mobileMenuPanel = document.getElementById('mobileMenuPanel');
        const navToggleBtn = document.getElementById('navToggleBtn');
        const navToggleIcon = document.getElementById('navToggleIcon');

        function toggleMobileMenu() {
            const isOpen = mobileMenuPanel.classList.toggle('show');
            navToggleBtn.setAttribute('aria-expanded', isOpen);
            navToggleIcon.classList.toggle('bi-list', !isOpen);
            navToggleIcon.classList.toggle('bi-x-lg', isOpen);
        }

        function closeMobileMenu() {
            mobileMenuPanel.classList.remove('show');
            navToggleBtn.setAttribute('aria-expanded', 'false');
            navToggleIcon.classList.add('bi-list');
            navToggleIcon.classList.remove('bi-x-lg');
        }

        window.addEventListener('resize', function () {
            if (window.innerWidth > 767.98) {
                closeMobileMenu();
            }
        });
    </script>
</body>
</html>