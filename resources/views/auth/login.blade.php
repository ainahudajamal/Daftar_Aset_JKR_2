<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Sistem Daftar Aset Khusus</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1d4ed8;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }

        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .login-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .login-header p {
            font-size: 0.95rem;
            opacity: 0.9;
            margin: 0;
        }

        .login-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2.5rem;
        }

        .login-body {
            padding: 40px 30px;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e5e7eb;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.15);
        }

        .input-group-text {
            border-radius: 10px 0 0 10px;
            border: 2px solid #e5e7eb;
            border-right: none;
            background: #f9fafb;
            color: #6b7280;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
            color: white;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .demo-credentials {
            background: #f0f9ff;
            border: 1px solid #bfdbfe;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .demo-credentials h6 {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 10px;
        }

        .demo-credentials p {
            margin: 5px 0;
            font-size: 0.9rem;
            color: #1e40af;
        }

        .alert {
            border-radius: 10px;
            border: none;
        }

        .username-hint {
            font-size: 0.85rem;
            color: #6b7280;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <div class="login-icon">
                    <i class="bi bi-building"></i>
                </div>
                <h1>Sistem Daftar Aset JKR</h1>
                {{-- <p>Kementerian Kesihatan Malaysia</p> --}}
            </div>

            <!-- Body -->
            <div class="login-body">
                <!-- Success Message -->
                @if(session('success'))
                <div class="alert alert-success mb-3">
                    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                </div>
                @endif

                <!-- Demo Credentials -->
                <div class="demo-credentials">
                    <h6><i class="bi bi-info-circle-fill"></i> Akaun Percubaan:</h6>
                    <p><strong>Admin:</strong> username: <code>admin</code> / password: <code>P@ssw0rd</code></p>
                    <p><strong>User:</strong> username: <code>user</code> / password: <code>user123</code></p>
                </div>

                <!-- Login Form -->
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf

                    <!-- Username -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Username</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-person"></i>
                            </span>
                            <input 
                                type="text" 
                                name="username" 
                                class="form-control @error('username') is-invalid @enderror" 
                                placeholder="Masukkan username"
                                value="{{ old('username') }}"
                                required
                                autofocus
                            >
                        </div>
                        @error('username')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @else
                        <div class="username-hint">
                            <i class="bi bi-lightbulb"></i> Contoh: admin atau user
                        </div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kata Laluan</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input 
                                type="password" 
                                name="password" 
                                id="password"
                                class="form-control @error('password') is-invalid @enderror" 
                                placeholder="Masukkan kata laluan"
                                required
                            >
                            <button 
                                class="btn btn-outline-secondary" 
                                type="button" 
                                id="togglePassword"
                                style="border-radius: 0 10px 10px 0; border-left: none;"
                            >
                                <i class="bi bi-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                        @error('password')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check mb-4">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            name="remember" 
                            id="remember"
                        >
                        <label class="form-check-label" for="remember">
                            Ingat saya
                        </label>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="btn btn-login">
                        <i class="bi bi-box-arrow-in-right"></i> Log Masuk
                    </button>
                </form>

                <!-- Footer Text -->
                <div class="text-center mt-4">
                    <p class="text-muted mb-0" style="font-size: 0.85rem;">
                        <i class="bi bi-shield-check"></i> Sistem Selamat & Terlindungi
                    </p>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="text-center mt-4">
            <p class="text-white mb-0" style="font-size: 0.9rem;">
                &copy; {{ date('Y') }} Kementerian Kerja Raya Malaysia
            </p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toggle Password Visibility -->
    <script>
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