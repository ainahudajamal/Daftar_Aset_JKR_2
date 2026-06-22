<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ASPIRA — Sistem Pengurusan Aset JKR</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/favicon.png') }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800|space-grotesk:400,500,600,700" rel="stylesheet" />

    <style>
        /* ============================================
             ASPIRA — DESIGN TOKENS
             ============================================ */
        :root {
            --color-primary: #2563eb;
            --color-primary-dark: #1d4ed8;
            --color-primary-light: #eff6ff;
            --color-accent: #0284c7;
            --color-accent-dark: #0369a1;
            --color-accent-light: #f0f9ff;
            --color-surface: #ffffff;
            --color-surface-alt: #f8fafc;
            --color-text: #0f172a;
            --color-text-muted: #64748b;
            --color-border: rgba(37, 99, 235, 0.06);
            --color-border-strong: rgba(37, 99, 235, 0.15);
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            --radius-xl: 32px;
            --shadow-sm: 0 1px 3px rgba(15, 23, 42, 0.04);
            --shadow-md: 0 8px 30px rgba(15, 23, 42, 0.06);
            --shadow-lg: 0 20px 60px rgba(15, 23, 42, 0.08);
            --shadow-xl: 0 32px 80px rgba(15, 23, 42, 0.12);
            --transition: 200ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        * { box-sizing: border-box; }

        html, body {
            min-height: 100%;
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            color: var(--color-text);
            background-color: #fafbf9;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ============================================
             TYPOGRAPHY
             ============================================ */
        .heading-display {
            font-family: 'Space Grotesk', system-ui, sans-serif;
            font-weight: 700;
            letter-spacing: -0.04em;
            line-height: 1.05;
        }

        .heading-section {
            font-family: 'Space Grotesk', system-ui, sans-serif;
            font-weight: 600;
            letter-spacing: -0.03em;
        }

        /* ============================================
             BUTTONS
             ============================================ */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px 28px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.95rem;
            text-decoration: none;
            cursor: pointer;
            transition: all var(--transition);
            white-space: nowrap;
            border: none;
            outline: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark));
            color: #fff;
            box-shadow: 0 8px 28px rgba(10, 92, 54, 0.28);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 36px rgba(10, 92, 54, 0.36);
        }

        .btn-outline {
            background: var(--color-surface);
            color: var(--color-primary);
            border: 2px solid var(--color-border-strong);
        }

        .btn-outline:hover {
            border-color: var(--color-primary);
            background: var(--color-primary-light);
            transform: translateY(-2px);
        }

        .btn-ghost {
            background: transparent;
            color: var(--color-text-muted);
            font-weight: 600;
            padding: 10px 18px;
        }

        .btn-ghost:hover {
            color: var(--color-text);
            background: rgba(10, 92, 54, 0.06);
        }

        /* ============================================
             BADGE
             ============================================ */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 16px;
            border-radius: 999px;
            background: var(--color-primary-light);
            color: var(--color-primary);
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .badge::before {
            content: '';
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.18);
            animation: pulse-dot 2s ease-in-out infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(1.3); }
        }

        /* ============================================
             NAVIGATION
             ============================================ */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(250, 251, 249, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--color-border);
        }

        .navbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            max-width: 1280px;
            margin: 0 auto;
            padding: 14px 28px;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: inherit;
        }

        .navbar-logo {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, var(--color-primary), #1e3a8a);
            color: #fff;
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            font-size: 19px;
            letter-spacing: 0.04em;
            box-shadow: 0 10px 24px rgba(37, 99, 235, 0.18);
        }

        .navbar-title {
            font-weight: 800;
            font-size: 1.15rem;
            letter-spacing: 0.04em;
            color: var(--color-text);
        }

        .navbar-subtitle {
            font-size: 0.73rem;
            color: var(--color-text-muted);
            font-weight: 500;
        }

        .navbar-links {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ============================================
             HERO SECTION
             ============================================ */
        .hero-section {
            position: relative;
            max-width: 1280px;
            margin: 0 auto;
            padding: 80px 28px 88px;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }

        .hero-bg-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.45;
        }

        .hero-bg-orb--blue {
            width: 520px;
            height: 520px;
            top: -200px;
            right: -140px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.14), transparent);
        }

        .hero-bg-orb--cyan {
            width: 420px;
            height: 420px;
            bottom: -120px;
            left: -100px;
            background: radial-gradient(circle, rgba(6, 182, 212, 0.10), transparent);
        }

        .hero-bg-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(var(--color-border) 1px, transparent 1px),
                linear-gradient(90deg, var(--color-border) 1px, transparent 1px);
            background-size: 56px 56px;
            mask-image: radial-gradient(ellipse at center, rgba(0,0,0,0.12), transparent 70%);
            -webkit-mask-image: radial-gradient(ellipse at center, rgba(0,0,0,0.12), transparent 70%);
        }

        .hero-content {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 56px;
            align-items: center;
        }

        .hero-text {
            max-width: 600px;
        }

        .hero-title {
            font-size: clamp(2.8rem, 5.5vw, 4.2rem);
            margin: 20px 0 22px;
            line-height: 1.02;
        }

        .hero-title span {
            background: linear-gradient(135deg, var(--color-primary) 20%, #1d4ed8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-description {
            font-size: 1.1rem;
            line-height: 1.75;
            color: var(--color-text-muted);
            margin: 0 0 34px;
            max-width: 52ch;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 24px;
        }

        .hero-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 22px;
            font-size: 0.84rem;
            color: var(--color-text-muted);
        }

        .hero-meta span {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .hero-meta .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #22c55e;
        }

        /* Hero visual — Document management illustration */
        .hero-visual {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero-illustration {
            position: relative;
            width: 100%;
            max-width: 440px;
        }

        .hero-illustration svg {
            width: 100%;
            height: auto;
            display: block;
        }

        @keyframes float-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        @keyframes float-slower {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }

        .float-slow { animation: float-slow 4s ease-in-out infinite; }
        .float-slower { animation: float-slower 5s ease-in-out infinite; }

        /* ============================================
             FEATURES SECTION
             ============================================ */
        .section {
            max-width: 1280px;
            margin: 0 auto;
            padding: 80px 28px;
        }

        .section-header {
            text-align: center;
            margin-bottom: 56px;
        }

        .section-label {
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--color-primary);
            margin-bottom: 12px;
        }

        .section-title {
            font-size: clamp(2rem, 3.5vw, 2.8rem);
            margin: 0 0 16px;
        }

        .section-description {
            font-size: 1.08rem;
            color: var(--color-text-muted);
            line-height: 1.7;
            max-width: 56ch;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .feature-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            padding: 32px 28px;
            transition: all var(--transition);
        }

        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--color-border-strong);
        }

        .feature-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            font-size: 1.4rem;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .feature-icon--green {
            background: var(--color-primary-light);
            color: var(--color-primary);
        }

        .feature-icon--gold {
            background: var(--color-accent-light);
            color: var(--color-accent);
        }

        .feature-card h3 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.2rem;
            font-weight: 600;
            margin: 0 0 10px;
            letter-spacing: -0.02em;
        }

        .feature-card p {
            color: var(--color-text-muted);
            line-height: 1.7;
            margin: 0;
            font-size: 0.95rem;
        }

        .footer-text {
            font-size: 0.82rem;
            color: var(--color-text-muted);
        }

        /* ============================================
             RESPONSIVE
             ============================================ */
        .cta-section {
            background: linear-gradient(135deg, var(--color-primary-light), #f0f7ff);
            border-top: 1px solid var(--color-border);
            border-bottom: 1px solid var(--color-border);
        }

        .cta-inner {
            max-width: 640px;
            margin: 0 auto;
            text-align: center;
            padding: 72px 28px;
        }

        .cta-inner h2 {
            font-size: clamp(1.8rem, 3vw, 2.4rem);
            margin: 0 0 14px;
        }

        .cta-inner p {
            color: var(--color-text-muted);
            line-height: 1.7;
            font-size: 1.05rem;
            margin: 0 0 28px;
        }

        .cta-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            justify-content: center;
        }

        /* ============================================
             FOOTER
             ============================================ */
        .footer {
            background: var(--color-surface);
            border-top: 1px solid var(--color-border);
        }

        .footer-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 28px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--color-text);
        }

        .footer-logo {
            width: 32px;
            height: 32px;
            border-radius: 9px;
            background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark));
            display: grid;
            place-items: center;
            color: #fff;
            font-size: 14px;
            font-weight: 800;
            font-family: 'Space Grotesk', sans-serif;
            letter-spacing: 0.04em;
        }

        .footer-text {
            font-size: 0.82rem;
            color: var(--color-text-muted);
        }

        /* ============================================
             RESPONSIVE
             ============================================ */
        @media (max-width: 1024px) {
            .hero-content {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .hero-visual {
                order: -1;
            }

            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .navbar-inner {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
                padding: 12px 20px;
            }

            .navbar-links {
                width: 100%;
                flex-wrap: wrap;
            }

            .navbar-links .btn {
                flex: 1;
                min-width: 110px;
            }

            .hero-section {
                padding: 44px 20px 64px;
            }

            .hero-actions {
                flex-direction: column;
            }

            .hero-actions .btn {
                width: 100%;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .section {
                padding: 56px 20px;
            }

            .footer-inner {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 2.2rem;
            }
        }
    </style>
</head>
<body>
    {{-- ========== NAVIGATION ========== --}}
    <nav class="navbar">
        <div class="navbar-inner">
            <a href="{{ url('/') }}" class="navbar-brand">
                <div class="navbar-logo">
                    <svg viewBox="0 0 44 44" width="44" height="44" xmlns="http://www.w3.org/2000/svg">
                        <rect width="44" height="44" rx="14" fill="url(#navGrad)"/>
                        <defs><linearGradient id="navGrad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="var(--color-primary)"/><stop offset="100%" stop-color="var(--color-primary-dark)"/></linearGradient></defs>
                        <text x="22" y="29" text-anchor="middle" fill="white" font-family="'Space Grotesk', sans-serif" font-weight="700" font-size="17" letter-spacing="0.06em">JKR</text>
                    </svg>
                </div>
                <div>
                    <div class="navbar-title">ASPIRA</div>
                    <div class="navbar-subtitle">Sistem Pengurusan Aset JKR</div>
                </div>
            </a>

            <div class="navbar-links">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-ghost">Dashboard</a>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">Pentadbiran</a>
                @else
                    <a href="#features" class="btn btn-ghost">Ciri-Ciri</a>
                    <a href="{{ route('login') }}" class="btn btn-outline">Log Masuk</a>
                    <a href="{{ route('login') }}" class="btn btn-primary">Mulakan Sekarang →</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- ========== HERO SECTION ========== --}}
    <section class="hero-section">
        <div class="hero-bg">
            <div class="hero-bg-orb hero-bg-orb--blue"></div>
            <div class="hero-bg-orb hero-bg-orb--cyan"></div>
            <div class="hero-bg-grid"></div>
        </div>

        <div class="hero-content">
            <div class="hero-text">
                <div class="badge">Platform Pengurusan Aset</div>
                <h1 class="heading-display hero-title">
                    <span>ASPIRA</span> —Urus Aset Dengan Lebih Pintar
                </h1>
                <p class="hero-description">
                    Platform komprehensif untuk mengurus, memantau, dan mendokumentasikan 
                    keseluruhan aset kejuruteraan awam JKR dalam satu sistem bersepadu yang 
                    direka khas untuk Jabatan Kerja Raya Malaysia.
                </p>

                <div class="hero-actions">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">Pergi ke Dashboard</a>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">Panel Pentadbiran</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">Log Masuk ke ASPIRA</a>
                        <a href="#features" class="btn btn-outline">Ketahui Lebih Lanjut</a>
                    @endauth
                </div>

                <div class="hero-meta">
                    <span><span class="dot"></span> Sistem aktif & beroperasi</span>
                    <span>✓ Pangkalan data tersambung</span>
                    <span>✓ Infrastruktur Laravel</span>
                </div>
            </div>

            <div class="hero-visual">
                <div class="hero-illustration">
                    <svg viewBox="0 0 480 380" fill="none" xmlns="http://www.w3.org/2000/svg">
                        {{-- Background circle --}}
                        <circle cx="240" cy="190" r="170" fill="var(--color-primary-light)" opacity="0.6"/>
                        <circle cx="240" cy="190" r="140" fill="var(--color-primary-light)" opacity="0.4"/>

                        {{-- Desk / table --}}
                        <rect x="70" y="240" width="340" height="14" rx="7" fill="#cbd5e1"/>
                        <rect x="90" y="250" width="12" height="80" rx="4" fill="#94a3b8"/>
                        <rect x="378" y="250" width="12" height="80" rx="4" fill="#94a3b8"/>

                        {{-- Clipboard / Borang --}}
                        <g class="float-slow">
                            <rect x="160" y="70" width="160" height="190" rx="8" fill="white" stroke="var(--color-primary)" stroke-width="2"/>
                            {{-- Clipboard clip --}}
                            <rect x="210" y="62" width="60" height="16" rx="6" fill="var(--color-accent)"/>
                            <circle cx="240" cy="70" r="3" fill="#fff" opacity="0.8"/>
                            {{-- Form lines --}}
                            <rect x="178" y="100" width="60" height="8" rx="4" fill="var(--color-border-strong)"/>
                            <rect x="178" y="120" width="124" height="6" rx="3" fill="var(--color-border)"/>
                            <rect x="178" y="136" width="100" height="6" rx="3" fill="var(--color-border)"/>
                            {{-- Form field boxes --}}
                            <rect x="178" y="156" width="124" height="22" rx="4" fill="var(--color-surface-alt)" stroke="var(--color-border)" stroke-width="1"/>
                            <rect x="178" y="188" width="124" height="22" rx="4" fill="var(--color-surface-alt)" stroke="var(--color-border)" stroke-width="1"/>
                            <rect x="178" y="220" width="80" height="22" rx="4" fill="var(--color-surface-alt)" stroke="var(--color-border)" stroke-width="1"/>
                            {{-- Checkmark --}}
                            <circle cx="282" cy="167" r="10" fill="#22c55e"/>
                            <path d="M278 167l3 3 5-5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>

                        {{-- Floating document 1 --}}
                        <g class="float-slower">
                            <rect x="290" y="120" width="100" height="70" rx="6" fill="white" stroke="var(--color-accent)" stroke-width="1.5" transform="rotate(8 340 155)"/>
                            <rect x="302" y="133" width="50" height="5" rx="2.5" fill="var(--color-border-strong)" transform="rotate(8 340 155)"/>
                            <rect x="302" y="145" width="76" height="4" rx="2" fill="var(--color-border)" transform="rotate(8 340 155)"/>
                            <rect x="302" y="154" width="60" height="4" rx="2" fill="var(--color-border)" transform="rotate(8 340 155)"/>
                            <rect x="302" y="163" width="40" height="4" rx="2" fill="var(--color-border)" transform="rotate(8 340 155)"/>
                            <circle cx="380" cy="133" r="7" fill="var(--color-accent)" transform="rotate(8 340 155)"/>
                            <path d="M377 133l1.5 1.5 3-3" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" transform="rotate(8 340 155)"/>
                        </g>

                        {{-- Pencil --}}
                        <g class="float-slow">
                            <rect x="105" y="135" width="8" height="55" rx="3" fill="var(--color-accent)" transform="rotate(-15 109 162)"/>
                            <polygon points="109,80 105,95 113,95" fill="#f5deb3" transform="rotate(-15 109 162)"/>
                            <rect x="107" y="78" width="4" height="6" rx="1" fill="#333" transform="rotate(-15 109 162)"/>
                        </g>

                        {{-- Small floating doc --}}
                        <g class="float-slower">
                            <rect x="90" y="85" width="80" height="55" rx="5" fill="white" stroke="var(--color-primary)" stroke-width="1.5" transform="rotate(-5 130 112)"/>
                            <rect x="100" y="96" width="40" height="4" rx="2" fill="var(--color-border-strong)" transform="rotate(-5 130 112)"/>
                            <rect x="100" y="106" width="55" height="3" rx="1.5" fill="var(--color-border)" transform="rotate(-5 130 112)"/>
                            <rect x="100" y="114" width="35" height="3" rx="1.5" fill="var(--color-border)" transform="rotate(-5 130 112)"/>
                        </g>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    {{-- ========== FEATURES SECTION ========== --}}
    <section class="section" id="features">
        <div class="section-header">
            <div class="section-label">Platform ASPIRA</div>
            <h2 class="heading-section section-title">Ciri-Ciri Utama</h2>
            <p class="section-description">
                Direka khas untuk memenuhi keperluan pengurusan aset JKR — menggabungkan 
                data kejuruteraan dengan antara muka yang intuitif dan profesional.
            </p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon feature-icon--green">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                </div>
                <h3>Pengurusan Komponen</h3>
                <p>
                    Jejak dan urus komponen, komponen utama, dan sub-komponen 
                    aset kejuruteraan dengan hierarki yang teratur dan jelas.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon feature-icon--gold">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                </div>
                <h3>Data Premis & Blok</h3>
                <p>
                    Rekod lengkap premis, blok, aras, dan ruang — setiap aset 
                    mempunyai lokasi yang tepat dalam pangkalan data.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon feature-icon--green">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                </div>
                <h3>Laporan & Eksport</h3>
                <p>
                    Jana laporan terperinci dan eksport ke format PDF serta Excel 
                    untuk analisis data dan pelaporan lengkap.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon feature-icon--gold">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <h3>Kawalan Akses</h3>
                <p>
                    Sistem peranan pentadbir dan pengguna dengan kawalan capaian 
                    yang ketat untuk keselamatan data di setiap peringkat.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon feature-icon--green">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <h3>Dokumen Berkaitan</h3>
                <p>
                    Lampirkan dokumen sokongan kepada komponen dan sub-komponen — 
                    semua rekod dalam satu repositori terpusat.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon feature-icon--gold">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <h3>Audit Trail</h3>
                <p>
                    Setiap perubahan direkodkan dalam log audit yang komprehensif 
                    untuk pemantauan, ketelusan, dan pematuhan standard.
                </p>
            </div>
        </div>
    </section>

    {{-- ========== CTA SECTION ========== --}}
    <section class="cta-section">
        <div class="cta-inner">
            <h2 class="heading-section">Bersedia Untuk Bermula?</h2>
            <p>
                Log masuk ke ASPIRA sekarang dan urus aset kejuruteraan 
                awam anda dengan lebih cekap, teratur, dan profesional.
            </p>
            <div class="cta-actions">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Pergi ke Dashboard</a>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">Panel Pentadbiran</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Log Masuk Sekarang</a>
                    <a href="#features" class="btn btn-outline">Lihat Ciri-Ciri</a>
                @endauth
            </div>
        </div>
    </section>

    {{-- ========== FOOTER ========== --}}
    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-brand">
                <div class="footer-logo">
                    <svg viewBox="0 0 32 32" width="32" height="32" xmlns="http://www.w3.org/2000/svg">
                        <rect width="32" height="32" rx="9" fill="url(#ftrGrad)"/>
                        <defs><linearGradient id="ftrGrad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="var(--color-primary)"/><stop offset="100%" stop-color="var(--color-primary-dark)"/></linearGradient></defs>
                        <text x="16" y="22" text-anchor="middle" fill="white" font-family="'Space Grotesk', sans-serif" font-weight="700" font-size="13" letter-spacing="0.06em">JKR</text>
                    </svg>
                </div>
                ASPIRA — Sistem Pengurusan Aset JKR
            </div>
            <div class="footer-text">
                &copy; {{ date('Y') }} Jabatan Kerja Raya Malaysia. Hak Cipta Terpelihara.
            </div>
        </div>
    </footer>
</body>
</html>