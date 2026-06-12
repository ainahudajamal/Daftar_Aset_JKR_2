<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- ✅ CSRF Token for AJAX requests --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Sistem Daftar Aset')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />

    <style>
        /* ========================================
   SDAK - SISTEM DAFTAR ASET KHAS
   Custom Sidebar Layout CSS
======================================== */

        /* ===== ROOT VARIABLES ===== */
        :root {
            --primary-color: #2563eb;
            --success-color: #10b981;
            --info-color: #06b6d4;
            --danger-color: #ef4444;
            --dark-color: #1e293b;
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 70px;
        }

        /* ===== GLOBAL RESET ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* ========================================
   SIDEBAR CONTAINER
======================================== */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            transition: all 0.3s ease;
            z-index: 1050;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        /* Sidebar bila collapse */
        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        /* Custom scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        /* ========================================
   SIDEBAR HEADER (Logo & Toggle)
======================================== */
        .sidebar-header {
            height: 80px;
            padding: 0 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Brand/Logo */
        .sidebar-brand {
            color: white;
            font-size: 1.2rem;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 1;
            height: 80px;
            overflow: hidden;
            margin-right: 10px;
            white-space: nowrap;
        }

        .sidebar-brand i {
            font-size: 1.2rem;
            /* ✅ Dikecilkan dari 1.5rem */
            flex-shrink: 0;
        }

        .sidebar-brand-text {
            transition: opacity 0.3s ease, width 0.3s ease;
            overflow: hidden;
        }

        /* ✅ Hide text bila sidebar collapse */
        .sidebar.collapsed .sidebar-brand-text {
            opacity: 0;
            width: 0;
            display: none;
        }

        /* ✅ Hide icon building bila sidebar collapse */
        .sidebar.collapsed .sidebar-brand i {
            opacity: 0;
            width: 0;
            display: none;
        }

        /* Toggle Button */
        .toggle-sidebar {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-sidebar:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* ========================================
   USER INFO SECTION
======================================== */
        .sidebar-user {
            padding: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: white;
        }

        /* User Avatar Circle */
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), #1d4ed8);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            flex-shrink: 0;
        }

        /* User Details */
        .user-details {
            overflow: hidden;
            transition: opacity 0.3s ease, width 0.3s ease;
            flex: 1;
        }

        /* ✅ Hide user details bila collapse */
        .sidebar.collapsed .user-details {
            opacity: 0;
            width: 0;
            display: none;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.7);
            white-space: nowrap;
        }

        /* ========================================
   NAVIGATION MENU
======================================== */
        .sidebar-nav {
            padding: 1rem 0;
            flex: 1;
        }

        .nav-item {
            margin: 0.25rem 0.5rem;
        }

        /* Nav Links */
        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s;
            white-space: nowrap;
            position: relative;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .nav-link.active {
            background: var(--primary-color);
            color: white;
        }

        /* Nav Icons */
        .nav-link i {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
            flex-shrink: 0;
        }

        /* Nav Text */
        .nav-link-text {
            transition: opacity 0.3s ease, width 0.3s ease;
            overflow: hidden;
            flex: 1;
        }

        /* ✅ Hide text bila collapse */
        .sidebar.collapsed .nav-link-text {
            opacity: 0;
            width: 0;
            display: none;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 0.75rem;
            gap: 0;
        }

        /* ✅ Tooltip bila hover (sidebar collapse) */
        .sidebar.collapsed .nav-link:hover::after {
            content: attr(data-title);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            margin-left: 10px;
            padding: 0.5rem 0.75rem;
            background: #1e293b;
            color: white;
            border-radius: 6px;
            white-space: nowrap;
            font-size: 0.85rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            pointer-events: none;
        }

        /* Menu Divider */
        .nav-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 0.5rem 1rem;
        }

        /* ========================================
   SIDEBAR FOOTER (LOGOUT)
======================================== */
        .sidebar-footer {
            margin-top: auto;
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            position: sticky;
            bottom: 0;
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
        }

        /* Logout Button */
        .logout-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: #fca5a5;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s;
            white-space: nowrap;
            background: rgba(239, 68, 68, 0.1);
            border: none;
            width: 100%;
            cursor: pointer;
            text-align: left;
            justify-content: flex-start;
            position: relative;
        }

        .logout-link:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
        }

        .logout-link i {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
            flex-shrink: 0;
        }

        /* ✅ Hide logout text bila collapse */
        .sidebar.collapsed .logout-link {
            justify-content: center;
            padding: 0.75rem;
            gap: 0;
        }

        .sidebar.collapsed .logout-link .nav-link-text {
            opacity: 0;
            width: 0;
            display: none;
        }

        /* ✅ Logout tooltip bila collapse */
        .sidebar.collapsed .logout-link:hover::after {
            content: "Log Keluar";
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            margin-left: 10px;
            padding: 0.5rem 0.75rem;
            background: #1e293b;
            color: white;
            border-radius: 6px;
            white-space: nowrap;
            font-size: 0.85rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            pointer-events: none;
        }

        /* ========================================
   MAIN CONTENT AREA
======================================== */
        .main-content {
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease;
            min-height: 100vh;
        }

        /* Main content bila sidebar collapse */
        .main-content.expanded {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* ✅ Main content tanpa sidebar (guest / login page) */
        .main-content.no-sidebar {
            margin-left: 0 !important;
        }

        /* ========================================
   BOOTSTRAP COMPONENT OVERRIDES
======================================== */
        .card {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .card-header {
            border-bottom: 2px solid rgba(0, 0, 0, 0.05);
        }

        .btn {
            border-radius: 6px;
            font-weight: 500;
        }

        .form-control,
        .form-select {
            border-radius: 6px;
        }

        .alert {
            border-radius: 8px;
            border: none;
        }

        /* ========================================
   SELECT2 CUSTOM STYLES
======================================== */
        .select2-container--bootstrap-5 .select2-selection {
            min-height: 38px;
        }

        .input-group-text {
            background-color: #e9ecef;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            padding-left: 12px;
        }

        /* ========================================
   MOBILE RESPONSIVE
======================================== */
        @media (max-width: 768px) {

            /* Sidebar tersembunyi by default di mobile */
            .sidebar {
                transform: translateX(-100%);
            }

            /* Sidebar muncul bila diklik */
            .sidebar.show {
                transform: translateX(0);
            }

            /* ✅ Main content full width di mobile */
            .main-content {
                margin-left: 0 !important;
            }

            /* Tunjukkan mobile toggle button */
            .mobile-toggle {
                display: flex !important;
            }
        }

        /* Mobile Toggle Button (Floating) */
        .mobile-toggle {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            z-index: 1040;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        /* Overlay untuk mobile */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1045;
        }

        .overlay.show {
            display: block;
        }

        /* Sidebar Logo Styles */
        .sidebar-logo-img,
        .sidebar-brand-logo {
            width: 100%;
            height: 100%;
            object-fit: contain;
            mix-blend-mode: lighten;
            transform: scale(1.5);
            transition: all 0.3s ease;
        }

        .collapsed-logo-icon {
            display: none;
            font-size: 1.4rem;
            color: white;
            margin: 0 auto;
        }

        .sidebar.collapsed .sidebar-logo-img {
            display: none !important;
        }

        .sidebar.collapsed .collapsed-logo-icon {
            display: block !important;
        }

        .sidebar.collapsed .collapsed-logo-icon i {
            opacity: 1 !important;
            width: auto !important;
            display: inline-block !important;
        }

        /* Collapsed Sidebar Header/Brand adjustments */
        .sidebar.collapsed .sidebar-brand {
            display: none !important;
        }

        .sidebar.collapsed .sidebar-header {
            justify-content: center;
            padding: 0 0.5rem;
        }

        /* ========================================
   END OF STYLESHEET
======================================== */
    </style>

    @stack('styles')
    @yield('styles')
</head>

<body>
    @auth
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <!-- Header -->
            <div class="sidebar-header">
                {{-- ✅ Dynamic link based on role --}}
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                        <img src="{{ asset('assets/logo-card.png') }}" alt="ASPIRA Logo" class="sidebar-logo-img">
                        <span class="collapsed-logo-icon"><i class="bi bi-building"></i></span>
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="sidebar-brand">
                        <img src="{{ asset('assets/logo-card.png') }}" alt="ASPIRA Logo" class="sidebar-logo-img">
                        <span class="collapsed-logo-icon"><i class="bi bi-building"></i></span>
                    </a>
                @endif
                <button class="toggle-sidebar" id="toggleSidebar">
                    <i class="bi bi-list"></i>
                </button>
            </div>

            <!-- User Info -->
            <div class="sidebar-user">
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="user-details">
                        <div class="user-name">{{ auth()->user()->name }}</div>
                        <div class="user-role">
                            @if (auth()->user()->isAdmin())
                                <i class="bi bi-shield-check"></i> Administrator
                            @else
                                <i class="bi bi-person"></i> Pengguna
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="sidebar-nav">
                {{-- ✅ DASHBOARD - HANYA UNTUK USER BIASA --}}
                @if (!auth()->user()->isAdmin())
                    <div class="nav-item">
                        <a href="{{ route('dashboard') }}"
                            class="nav-link {{ request()->routeIs('dashboard') || request()->routeIs('components.index') ? 'active' : '' }}"
                            data-title="Dashboard">
                            <i class="bi bi-house-door"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </div>
                @endif

                {{-- ✅ ADMIN DASHBOARD - HANYA UNTUK ADMIN --}}
                @if (auth()->user()->isAdmin())
                    <div class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                            class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                            data-title="Admin Dashboard">
                            <i class="bi bi-speedometer2"></i>
                            <span class="nav-link-text">Admin Dashboard</span>
                        </a>
                    </div>
                @endif

                {{-- ✅ BORANG 1, 2, 3 - HANYA UNTUK USER BIASA --}}
                @if (!auth()->user()->isAdmin())
                    <div class="nav-divider"></div>

                    <div class="nav-item">
                        <a href="{{ route('components.create') }}"
                            class="nav-link {{ request()->routeIs('components.create') ? 'active' : '' }}"
                            data-title="Borang 1">
                            <i class="bi bi-box-seam"></i>
                            <span class="nav-link-text">Borang 1</span>
                        </a>
                    </div>

                    <div class="nav-item">
                        <a href="{{ route('main-components.create') }}"
                            class="nav-link {{ request()->routeIs('main-components.create') ? 'active' : '' }}"
                            data-title="Borang 2">
                            <i class="bi bi-layers"></i>
                            <span class="nav-link-text">Borang 2</span>
                        </a>
                    </div>

                    <div class="nav-item">
                        <a href="{{ route('sub-components.create') }}"
                            class="nav-link {{ request()->routeIs('sub-components.create') ? 'active' : '' }}"
                            data-title="Borang 3">
                            <i class="bi bi-diagram-3"></i>
                            <span class="nav-link-text">Borang 3</span>
                        </a>
                    </div>
                @endif

                {{-- ✅ MENU PENGURUSAN - HANYA UNTUK ADMIN --}}
                @if (auth()->user()->isAdmin())
                    <div class="nav-item">
                        <a href="{{ route('admin.sistem.index') }}"
                            class="nav-link {{ request()->routeIs('admin.sistem.*') ? 'active' : '' }}"
                            data-title="Sistem">
                            <i class="bi bi-gear"></i>
                            <span class="nav-link-text">Pendaftaran Sistem</span>
                        </a>
                    </div>

                     <div class="nav-item">
                        <a href="{{ route('admin.premis.index') }}"
                            class="nav-link {{ request()->routeIs('admin.premis.*') ? 'active' : '' }}"
                            data-title="Premis">
                           <i class="bi bi-file-earmark-text"></i>
                            <span class="nav-link-text">Borang D.A.3</span>
                        </a>
                    </div>

                    <div class="nav-item">
                        <a href="{{ route('admin.blok.index') }}"
                            class="nav-link {{ request()->routeIs('admin.blok.*') ? 'active' : '' }}" data-title="Blok">
                            <i class="bi bi-grid-3x3-gap-fill"></i>
                            <span class="nav-link-text">Borang D.A.4</span>
                        </a>
                    </div>

                    <div class="nav-item">
                        <a href="{{ route('admin.aras-ruang.index') }}"
                            class="nav-link {{ request()->routeIs('admin.aras-ruang.*') || request()->routeIs('admin.aras.*') || request()->routeIs('admin.ruang.*') ? 'active' : '' }}"
                            data-title="Aras dan Ruang">
                            <i class="bi bi-layers-half"></i>
                            <span class="nav-link-text">Borang D.A.5</span>
                        </a>
                    </div>

                    <div class="nav-item">
                        <a href="{{ route('admin.components.index') }}"
                            class="nav-link {{ request()->routeIs('admin.components.*') ? 'active' : '' }}"
                            data-title="Komponen">
                            <i class="bi bi-building"></i>
                            <span class="nav-link-text">Pendaftaran Komponen</span>
                            @if (\App\Models\Component::onlyTrashed()->count() > 0)
                                <span class="badge bg-danger ms-auto">
                                    {{ \App\Models\Component::onlyTrashed()->count() }}
                                </span>
                            @endif
                        </a>
                        
                    </div>

                    <div class="nav-divider"></div>
                    <div class="nav-item">
                        <a href="{{ route('admin.audit_log.index') }}"
                            class="nav-link {{ request()->routeIs('admin.audit_log.*') ? 'active' : '' }}"
                            data-title="Audit Log">
                            <i class="bi bi-journal-text"></i>
                            <span class="nav-link-text">Audit Log</span>
                        </a>
                    </div>

                    <div class="nav-item">
                        <a href="{{ route('admin.users.index') }}"
                            class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                            data-title="Pengguna">
                            <i class="bi bi-people"></i>
                            <span class="nav-link-text">Pengurusan Pengguna</span>
                        </a>
                    </div>
                  

                @endif
            </nav>

            <!-- ✅ LOGOUT BUTTON -->
            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST" id="logout-form">
                    @csrf
                    <button type="submit" class="logout-link">
                        <i class="bi bi-box-arrow-right"></i>
                        <span class="nav-link-text">Log Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Mobile Toggle -->
        <button class="mobile-toggle" id="mobileToggle">
            <i class="bi bi-list"></i>
        </button>

        <!-- ✅ OVERLAY - HANYA SATU SAHAJA -->
        <div class="overlay" id="overlay"></div>
    @endauth

    <!-- ✅ MAIN CONTENT - FIXED CLASS -->
    <main class="main-content {{ auth()->check() ? '' : 'no-sidebar' }}" id="mainContent">
        <div class="container-fluid p-4">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- jQuery (required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // ✅ CSRF Token Setup
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        @auth
        // ✅ IMPROVED SIDEBAR TOGGLE WITH SAFEGUARDS
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const toggleBtn = document.getElementById('toggleSidebar');
        const mobileToggle = document.getElementById('mobileToggle');
        const overlay = document.getElementById('overlay');

        // Desktop Toggle
        if (toggleBtn && sidebar && mainContent) {
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');

                // Save state to localStorage
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
            });
        }

        // Mobile Toggle
        if (mobileToggle && sidebar && overlay) {
            mobileToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            });
        }

        // Overlay Click
        if (overlay && sidebar) {
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });
        }

        // ✅ Restore sidebar state from localStorage (WITH SAFEGUARD)
        if (sidebar && mainContent) {
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            }
        }
        @endauth
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @stack('scripts')
    @yield('scripts')
</body>

</html>
