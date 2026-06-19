<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Log Masuk - Asset Project Integrated Record Application</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/favicon.png') }}">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #0f5e3a; /* Dark green JKR style */
            --primary-light: #168a54;
            --primary-glow: rgba(15, 94, 58, 0.12);
            --dark: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --bg-right: #f8fafc;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-right);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        .split-layout {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* Left side: Branding / Hero with Dynamic Screen Borders */
        .branding-side {
            flex: 1.2;
            position: relative;
            background-repeat: no-repeat;
            background-position: center center;
            background-size: 100% 100%; /* Keep neon border perfectly aligned to the screen edges at all aspect ratios */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 50px;
            color: white;
            z-index: 1;
            overflow: hidden;
        }

        /* Overlay to darken and provide rich depth */
        .branding-side::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(13, 21, 14, 0.3) 0%, rgba(13, 21, 14, 0.85) 100%);
            z-index: -1;
        }

        /* Subtle grid overlay to match welcome.blade.php style */
        .branding-side::after {
            content: '';
            position: absolute;
            inset: 0;
            pointer-events: none;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.015) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.015) 1px, transparent 1px);
            background-size: 48px 48px;
            z-index: 0;
            opacity: 0.5;
        }

        .branding-header {
            position: relative;
            z-index: 2;
            align-self: flex-start;
        }

        .system-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 99px;
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: rgba(255, 255, 255, 0.85);
        }

        .system-badge::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981; /* Green status dot */
            box-shadow: 0 0 10px #10b981;
        }

        .branding-content-center {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            flex-grow: 1; /* Center vertically in remaining space */
            margin-bottom: 40px; /* Optical centering adjustment */
        }

        .branding-logo-img {
            max-height: 380px;
            max-width: 95%;
            object-fit: contain;
            filter: drop-shadow(0 0 25px rgba(59, 130, 246, 0.45)); /* Blue accent glow */
            margin-top: -80px;
            margin-bottom: -50px;
        }

        .branding-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(1.4rem, 2.2vw, 2.2rem);
            font-weight: 700;
            line-height: 1.4;
            max-width: 540px;
            letter-spacing: -0.01em;
            color: #ffffff;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.6);
        }

        /* Right side: Authentication Form */
        .auth-side {
            flex: 0.8;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            position: relative;
            box-shadow: -10px 0 30px rgba(0, 0, 0, 0.02);
            z-index: 2;
        }

        .auth-container {
            width: 100%;
            max-width: 440px;
        }

        .logo-wrapper {
            margin-bottom: 28px;
            text-align: center;
        }

        .logo-badge {
            display: inline-block;
            background-color: #0c150e; /* Dark theme backdrop for the white-logo */
            padding: 12px 28px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .logo-img {
            max-height: 150px;
            max-width: 100%;
            object-fit: contain;
            margin-top: -25px;
            margin-bottom: -25px;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .auth-header-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
            letter-spacing: -0.01em;
        }

        .auth-header-subtitle {
            font-size: 0.88rem;
            color: var(--text-muted);
            margin: 0;
            line-height: 1.5;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
            letter-spacing: 0.01em;
        }

        .input-group {
            position: relative;
            border-radius: 12px;
            transition: all 0.3s;
        }

        .input-group-text {
            background-color: #f8fafc;
            border: 2px solid var(--border);
            border-right: none;
            border-radius: 12px 0 0 12px;
            color: #94a3b8;
            padding-left: 16px;
            padding-right: 12px;
            transition: all 0.3s;
        }

        .form-control {
            border: 2px solid var(--border);
            border-left: none;
            border-radius: 0 12px 12px 0;
            padding: 14px 16px;
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--dark);
            transition: all 0.3s;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: var(--primary-light);
        }

        /* Glowing effect when focus */
        .input-group:focus-within {
            box-shadow: 0 0 0 4px var(--primary-glow);
        }

        .input-group:focus-within .input-group-text {
            border-color: var(--primary-light);
            color: var(--primary);
        }

        .input-group:focus-within .form-control {
            border-color: var(--primary-light);
        }

        .btn-toggle-pw {
            border: 2px solid var(--border);
            border-left: none;
            background: white;
            border-radius: 0 12px 12px 0;
            color: #94a3b8;
            padding-right: 16px;
            transition: all 0.3s;
        }

        .btn-toggle-pw:hover {
            color: var(--dark);
        }

        .btn-toggle-pw:focus {
            box-shadow: none;
        }

        /* Customize input value for password with hidden text to align with border */
        .input-group .password-input {
            border-right: none;
            border-radius: 0;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            border-radius: 6px !important;
            border: 2px solid var(--border);
            margin-top: 0.15em;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .form-check-label {
            font-size: 0.9rem;
            font-weight: 500;
            color: #475569;
            cursor: pointer;
            padding-left: 4px;
            user-select: none;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary) 0%, #0a3d27 100%);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: 0.02em;
            transition: all 0.3s;
            box-shadow: 0 10px 24px rgba(15, 94, 58, 0.15);
        }

        .btn-login:hover {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary) 100%);
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(15, 94, 58, 0.25);
            color: white;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Demo credentials block */
        .demo-box {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            padding: 16px;
            margin-top: 24px;
        }

        .demo-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: #166534;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .demo-item {
            font-size: 0.8rem;
            color: #1e3a1e;
            margin: 4px 0;
            font-family: monospace;
        }

        .demo-badge {
            display: inline-block;
            padding: 2px 6px;
            background-color: #dcfce7;
            border: 1px solid #bbf7d0;
            border-radius: 4px;
            font-weight: 600;
            color: #14532d;
            margin-right: 4px;
        }

        /* Error/success displays */
        .alert-custom {
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 0.88rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            border: none;
        }

        .alert-custom-success {
            background-color: #f0fdf4;
            color: #166534;
        }

        .invalid-feedback-custom {
            font-size: 0.8rem;
            font-weight: 600;
            color: #dc2626;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .hint-text {
            font-size: 0.8rem;
            color: #94a3b8;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .auth-footer {
            text-align: center;
            margin-top: 36px;
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        /* Responsiveness */
        @media (max-width: 991.98px) {
            .branding-side {
                display: none;
            }
            .auth-side {
                flex: 1;
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="split-layout">
        <!-- Left Side: Branding (Dynamic resizing) -->
        <div class="branding-side" data-bg="{{ asset('assets/hero-bg.jpg') }}">
            <!-- Top official system badge -->
            <div class="branding-header">
                <div class="system-badge">
                    Sistem Rasmi ASPIRA
                </div>
            </div>

            <!-- Centered content: Logo + System Name -->
            <div class="branding-content-center">
                <img src="{{ asset('assets/logo-white.png') }}" alt="ASPIRA Logo" class="branding-logo-img">
                <h1 class="branding-title">Asset Project Integrated Record Application</h1>
            </div>

            <!-- Empty bottom section to balance space alignment -->
            <div></div>
        </div>

        <!-- Right Side: Auth Form -->
        <div class="auth-side">
            <div class="auth-container">
                <!-- Logo -->
                <div class="logo-wrapper">
                    <img src="{{ asset('assets/logo-card.png') }}" alt="ASPIRA Logo" class="logo-img">
                </div>

                <!-- Header Title & Subtitle (NadiPutra Style) -->
                <div class="auth-header">
                    <h2 class="auth-header-title">Akses Pengguna</h2>
                    <p class="auth-header-subtitle">Log masuk dengan kredensial anda untuk mengakses sistem.</p>
                </div>

                <!-- Success Message -->
                @if(session('success'))
                <div class="alert alert-custom alert-custom-success mb-4">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>{{ session('success') }}</div>
                </div>
                @endif

                <!-- Form -->
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf

                    <!-- ID Pengguna -->
                    <div class="mb-4">
                        <label class="form-label" for="username">ID Pengguna</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-person"></i>
                            </span>
                            <input
                                type="text"
                                name="username"
                                id="username"
                                class="form-control @error('username') is-invalid @enderror"
                                placeholder="Masukkan username"
                                value="{{ old('username') }}"
                                required
                                autofocus
                            >
                        </div>
                        @error('username')
                        <div class="invalid-feedback-custom">
                            <i class="bi bi-exclamation-triangle"></i> {{ $message }}
                        </div>
                        @else
                        <div class="hint-text">
                            <i class="bi bi-lightbulb"></i> Contoh: admin atau user
                        </div>
                        @enderror
                    </div>

                    <!-- Kata Laluan -->
                    <div class="mb-4">
                        <label class="form-label" for="password">Kata Laluan</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control password-input @error('password') is-invalid @enderror"
                                placeholder="Masukkan kata laluan"
                                required
                            >
                            <button
                                class="btn btn-toggle-pw"
                                type="button"
                                id="togglePassword"
                            >
                                <i class="bi bi-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                        @error('password')
                        <div class="invalid-feedback-custom">
                            <i class="bi bi-exclamation-triangle"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Ingat Saya Checkbox -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="remember"
                                id="remember"
                            >
                            <label class="form-check-label" for="remember">
                                Ingat Saya
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-login">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Log Masuk
                        </button>
                    </div>
                </form>


                <div class="auth-footer">
                    <p class="mb-1">&copy; {{ date('Y') }} Kementerian Kerja Raya Malaysia</p>
                    <p class="text-muted" style="font-size: 0.75rem;">Sistem Selamat &amp; Terlindungi</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Password visibility toggle script -->
    <script>
        // Set background image from data attribute
        const brandingSide = document.querySelector('.branding-side');
        if (brandingSide) {
            brandingSide.style.backgroundImage = "url('" + brandingSide.dataset.bg + "')";
        }

        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            }
        });
    </script>
</body>
</html>
