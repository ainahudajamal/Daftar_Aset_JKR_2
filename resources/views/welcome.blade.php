<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Daftar Aset JKR') }}</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/favicon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700|space-grotesk:500,700" rel="stylesheet" />

    <style>
        :root {
            --bg: #f4f1e8;
            --surface: rgba(255, 255, 255, 0.84);
            --surface-strong: #ffffff;
            --text: #142016;
            --muted: #5f6d60;
            --line: rgba(20, 32, 22, 0.12);
            --accent: #0f5e3a;
            --accent-2: #d4972f;
            --accent-3: #203c2b;
            --shadow: 0 28px 70px rgba(23, 33, 27, 0.14);
        }

        * { box-sizing: border-box; }

        html, body { min-height: 100%; }

        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(15, 94, 58, 0.18), transparent 36%),
                radial-gradient(circle at top right, rgba(212, 151, 47, 0.16), transparent 32%),
                linear-gradient(180deg, #faf8f2 0%, var(--bg) 100%);
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            pointer-events: none;
            background-image:
                linear-gradient(rgba(20, 32, 22, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(20, 32, 22, 0.04) 1px, transparent 1px);
            background-size: 48px 48px;
            mask-image: linear-gradient(180deg, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0));
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .page {
            position: relative;
            width: min(1200px, calc(100% - 32px));
            margin: 0 auto;
            padding: 28px 0 40px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 8px 0 28px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 14px;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .brand-mark {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, var(--accent), #0a3d27);
            color: #fff;
            box-shadow: 0 16px 30px rgba(15, 94, 58, 0.26);
            font-family: 'Space Grotesk', sans-serif;
            font-size: 20px;
        }

        .brand-copy {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }

        .brand-copy small {
            color: var(--muted);
            font-weight: 600;
            margin-top: 4px;
        }

        .nav {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .chip,
        .button,
        .ghost {
            border-radius: 999px;
            padding: 12px 18px;
            font-weight: 700;
            transition: transform 180ms ease, box-shadow 180ms ease, border-color 180ms ease, background 180ms ease;
        }

        .chip {
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid var(--line);
            color: var(--muted);
            box-shadow: 0 12px 30px rgba(24, 31, 26, 0.06);
        }

        .button {
            background: linear-gradient(135deg, var(--accent), #0b4b2f);
            color: #fff;
            box-shadow: 0 16px 34px rgba(15, 94, 58, 0.24);
        }

        .ghost {
            background: rgba(255, 255, 255, 0.68);
            border: 1px solid rgba(20, 32, 22, 0.12);
            color: var(--text);
        }

        .chip:hover,
        .button:hover,
        .ghost:hover,
        .stat-card:hover,
        .link-card:hover {
            transform: translateY(-2px);
        }

        .hero {
            display: grid;
            grid-template-columns: minmax(0, 1.18fr) minmax(320px, 0.82fr);
            gap: 24px;
            align-items: stretch;
        }

        .panel {
            position: relative;
            border: 1px solid rgba(20, 32, 22, 0.08);
            background: var(--surface);
            backdrop-filter: blur(16px);
            border-radius: 28px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .panel::after {
            content: '';
            position: absolute;
            inset: auto -10% -30% auto;
            width: 240px;
            height: 240px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(212, 151, 47, 0.18), transparent 70%);
            pointer-events: none;
        }

        .hero-main {
            padding: 36px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(15, 94, 58, 0.1);
            color: var(--accent);
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .eyebrow::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--accent-2);
            box-shadow: 0 0 0 5px rgba(212, 151, 47, 0.16);
        }

        h1 {
            margin: 18px 0 14px;
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(2.5rem, 4.8vw, 5rem);
            line-height: 0.96;
            letter-spacing: -0.04em;
        }

        .lede {
            max-width: 58ch;
            font-size: 1.05rem;
            line-height: 1.7;
            color: var(--muted);
            margin: 0;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 26px;
        }

        .hero-aside {
            display: grid;
            grid-template-rows: auto 1fr;
            gap: 16px;
            padding: 24px;
            background: linear-gradient(180deg, rgba(32, 60, 43, 0.98), rgba(15, 41, 29, 0.98));
            color: #f5f7f2;
        }

        .hero-aside h2,
        .section-title {
            margin: 0;
            font-family: 'Space Grotesk', sans-serif;
            letter-spacing: -0.02em;
        }

        .hero-aside h2 {
            font-size: 1.35rem;
        }

        .hero-aside p {
            margin: 10px 0 0;
            color: rgba(245, 247, 242, 0.78);
            line-height: 1.65;
        }

        .connection-box {
            border-radius: 22px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        .connection-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.16em;
            color: rgba(245, 247, 242, 0.66);
        }

        .connection-value {
            margin-top: 10px;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.45rem;
            line-height: 1.2;
        }

        .connection-meta {
            margin-top: 12px;
            display: grid;
            gap: 8px;
        }

        .meta-row {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            font-size: 14px;
            color: rgba(245, 247, 242, 0.78);
        }

        .meta-row strong {
            color: #fff;
            font-weight: 700;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 18px;
            margin-top: 22px;
        }

        .stat-card {
            grid-column: span 4;
            background: var(--surface-strong);
            border: 1px solid rgba(20, 32, 22, 0.08);
            border-radius: 22px;
            padding: 18px;
            box-shadow: 0 14px 34px rgba(26, 34, 28, 0.08);
            transition: transform 180ms ease;
        }

        .stat-card .label {
            color: var(--muted);
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .stat-card .value {
            margin-top: 10px;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 2rem;
            letter-spacing: -0.04em;
        }

        .stat-card .hint {
            margin-top: 8px;
            color: var(--muted);
            line-height: 1.5;
            font-size: 14px;
        }

        .modules {
            margin-top: 22px;
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 18px;
        }

        .module-head {
            grid-column: 1 / -1;
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 16px;
            flex-wrap: wrap;
        }

        .module-head p {
            margin: 8px 0 0;
            color: var(--muted);
            max-width: 62ch;
            line-height: 1.6;
        }

        .link-card {
            grid-column: span 3;
            background: rgba(255, 255, 255, 0.84);
            border: 1px solid rgba(20, 32, 22, 0.09);
            border-radius: 22px;
            padding: 18px;
            box-shadow: 0 12px 30px rgba(26, 34, 28, 0.07);
            transition: transform 180ms ease;
        }

        .link-card h3 {
            margin: 0;
            font-size: 1rem;
            font-family: 'Space Grotesk', sans-serif;
        }

        .link-card p {
            margin: 10px 0 16px;
            color: var(--muted);
            line-height: 1.6;
            font-size: 14px;
        }

        .inline-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--accent);
            font-weight: 800;
        }

        .inline-link::after {
            content: '→';
            transition: transform 180ms ease;
        }

        .inline-link:hover::after {
            transform: translateX(3px);
        }

        .footer-note {
            margin-top: 22px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
        }

        @media (max-width: 980px) {
            .hero {
                grid-template-columns: 1fr;
            }

            .stat-card,
            .link-card {
                grid-column: span 6;
            }
        }

        @media (max-width: 700px) {
            .page {
                width: min(100% - 20px, 1200px);
                padding-top: 16px;
            }

            .topbar {
                align-items: flex-start;
                flex-direction: column;
            }

            .hero-main,
            .hero-aside {
                padding: 22px;
            }

            .stat-card,
            .link-card {
                grid-column: 1 / -1;
            }

            .actions,
            .nav {
                width: 100%;
            }

            .button,
            .ghost,
            .chip {
                width: 100%;
                justify-content: center;
                display: inline-flex;
            }
        }
    </style>
</head>
<body>
    <main class="page">
        <header class="topbar">
            <div class="brand">
                <div class="brand-mark">A</div>
                <div class="brand-copy">
                    <span>{{ config('app.name', 'Sistem Daftar Aset JKR') }}</span>
                    <small>Frontend, backend, and database are live</small>
                </div>
            </div>

            <nav class="nav">
                <a class="chip" href="{{ url('/index.html') }}">index.html</a>
                @auth
                    <a class="chip" href="{{ route('dashboard') }}">Dashboard</a>
                    <a class="button" href="{{ route('components.index') }}">Buka Sistem</a>
                @else
                    <a class="chip" href="{{ route('login') }}">Log masuk</a>
                    <a class="button" href="{{ route('login') }}">Masuk ke sistem</a>
                @endauth
            </nav>
        </header>

        <section class="hero">
            <article class="panel hero-main">
                <div class="eyebrow">Laravel application connected</div>
                <h1>Daftar Aset JKR.</h1>
                <p class="lede">
                    Halaman ini menjadi pintu masuk frontend untuk sistem aset, dengan sambungan terus ke backend Laravel dan data pangkalan data yang sedang aktif.
                    Gunakan pautan di bawah untuk masuk ke modul pengguna atau pentadbir.
                </p>

                <div class="actions">
                    @auth
                        <a class="button" href="{{ route('dashboard') }}">Pergi ke Dashboard</a>
                        <a class="ghost" href="{{ route('components.index') }}">Komponen</a>
                        <a class="ghost" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                    @else
                        <a class="button" href="{{ route('login') }}">Log masuk untuk akses modul</a>
                        <a class="ghost" href="{{ url('/index.html') }}">Buka index.html</a>
                    @endauth
                </div>

                <div class="footer-note">
                    Laluan utama yang disediakan: <strong>/</strong>, <strong>/index.html</strong>, <strong>/login</strong>, dan <strong>/dashboard</strong>.
                </div>
            </article>

            <aside class="panel hero-aside">
                <div>
                    <h2>Connection status</h2>
                    <p>Data di bawah diambil secara langsung dari model Laravel, jadi ia akan berubah ikut rekod dalam database anda.</p>
                </div>

                <div class="connection-box">
                    <div class="connection-label">App URL</div>
                    <div class="connection-value">{{ config('app.url', 'http://localhost:8000') }}</div>

                    <div class="connection-meta">
                        <div class="meta-row"><span>Frontend</span><strong>Welcome page</strong></div>
                        <div class="meta-row"><span>Backend</span><strong>Laravel routes & controllers</strong></div>
                        <div class="meta-row"><span>Database</span><strong>Connected counts</strong></div>
                    </div>
                </div>
            </aside>
        </section>

        <section class="stats">
            @foreach ($stats as $stat)
                <article class="stat-card">
                    <div class="label">{{ $stat['label'] }}</div>
                    <div class="value">{{ number_format($stat['value']) }}</div>
                    <div class="hint">{{ $stat['hint'] }}</div>
                </article>
            @endforeach
        </section>

        <section class="modules panel" style="padding: 26px; margin-top: 22px;">
            <div class="module-head">
                <div>
                    <h2 class="section-title" style="font-size: 1.7rem;">Quick links</h2>
                    <p>
                        Pilih modul yang anda mahu buka. Akses penuh ke komponen, komponen utama, sub komponen, dan pentadbiran adalah melalui log masuk.
                    </p>
                </div>
                <a class="chip" href="{{ route('login') }}">Login screen</a>
            </div>

            <article class="link-card">
                <h3>Frontend index</h3>
                <p>Halaman utama untuk pengguna melihat status sambungan sistem dan masuk ke aplikasi.</p>
                <a class="inline-link" href="{{ url('/index.html') }}">Open index.html</a>
            </article>

            <article class="link-card">
                <h3>Authentication</h3>
                <p>Masuk ke backend Laravel dan gunakan peranan admin atau pengguna biasa.</p>
                <a class="inline-link" href="{{ route('login') }}">Open login</a>
            </article>

            <article class="link-card">
                <h3>User dashboard</h3>
                <p>Lihat paparan komponen, borang, dan rekod yang dipautkan ke pangkalan data.</p>
                <a class="inline-link" href="{{ route('dashboard') }}">Open dashboard</a>
            </article>

            <article class="link-card">
                <h3>Admin area</h3>
                <p>Pautan pengurusan untuk pengguna, sistem, blok, aras, ruang, dan audit log.</p>
                <a class="inline-link" href="{{ route('admin.dashboard') }}">Open admin dashboard</a>
            </article>
        </section>
    </main>
</body>
</html>