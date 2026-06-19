<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- ✅ CSRF Token for AJAX requests --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Sistem Daftar Aset')</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/favicon.png') }}">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ========================================
   ASPIRA — Modern Government Design System
======================================== */

        /* ===== ROOT VARIABLES ===== */
        :root {
            --primary:        #2563eb;
            --primary-dark:   #1d4ed8;
            --primary-light:  #3b82f6;
            --primary-glow:   rgba(37, 99, 235, 0.15);
            --success:        #10b981;
            --info:           #06b6d4;
            --warning:        #f59e0b;
            --danger:         #ef4444;
            --sidebar-bg-top: #1e293b;
            --sidebar-bg-bot: #0f172a;
            --sidebar-width:  260px;
            --sidebar-collapsed-width: 70px;
            --topbar-height:  60px;
            --content-bg:     #f1f5f9;
            --card-radius:    14px;
            --border-color:   #e2e8f0;
            --text-primary:   #0f172a;
            --text-secondary: #64748b;
            --transition:     0.25s cubic-bezier(0.4, 0, 0.2, 1);
            --shadow-sm:      0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md:      0 4px 12px rgba(0,0,0,0.08), 0 2px 4px rgba(0,0,0,0.04);
            --shadow-lg:      0 10px 30px rgba(0,0,0,0.1), 0 4px 10px rgba(0,0,0,0.05);
        }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; } to { opacity: 1; }
        }
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-20px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes pulse-dot {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.4); opacity: 0.7; }
        }
        @keyframes shimmer {
            0%   { background-position: -200% 0; }
            100% { background-position:  200% 0; }
        }

        /* ===== GLOBAL RESET ===== */
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: var(--content-bg);
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
            overflow-x: hidden;
            color: var(--text-primary);
            font-size: 0.925rem;
            line-height: 1.6;
        }

        /* ===== PAGE ENTER ANIMATION ===== */
        .page-content {
            animation: fadeInUp 0.4s ease both;
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
            background: linear-gradient(180deg, var(--sidebar-bg-top) 0%, var(--sidebar-bg-bot) 100%);
            transition: width var(--transition), transform var(--transition);
            z-index: 1050;
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
            overflow-y: auto;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        .sidebar.collapsed { width: var(--sidebar-collapsed-width); }

        /* Subtle side accent line */
        .sidebar::after {
            content: '';
            position: absolute;
            right: 0; top: 0; bottom: 0; width: 1px;
            background: linear-gradient(to bottom, transparent, rgba(37,99,235,0.5), transparent);
            pointer-events: none;
        }

        /* Scrollbar */
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 4px; }

        /* ========== SIDEBAR HEADER ========== */
        .sidebar-header {
            height: 80px;
            padding: 0 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }

        .sidebar-brand {
            color: white;
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
        .sidebar-brand i { font-size: 1.2rem; flex-shrink: 0; }
        .sidebar-brand-text { transition: opacity var(--transition), width var(--transition); overflow: hidden; }
        .sidebar.collapsed .sidebar-brand-text { opacity: 0; width: 0; display: none; }
        .sidebar.collapsed .sidebar-brand i { opacity: 0; width: 0; display: none; }

        .toggle-sidebar {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.7);
            width: 34px; height: 34px;
            border-radius: 8px;
            cursor: pointer;
            transition: all var(--transition);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .toggle-sidebar:hover { background: rgba(255,255,255,0.15); color: white; }

        /* ========== USER INFO ========== */
        .sidebar-user {
            padding: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            flex-shrink: 0;
        }
        .user-info { display: flex; align-items: center; gap: 0.75rem; color: white; }

        .user-avatar {
            width: 40px; height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.9rem;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(37,99,235,0.4);
        }

        .user-details { overflow: hidden; transition: opacity var(--transition), width var(--transition); flex: 1; }
        .sidebar.collapsed .user-details { opacity: 0; width: 0; display: none; }

        .user-name { font-weight: 600; font-size: 0.85rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-role { font-size: 0.72rem; color: rgba(255,255,255,0.55); white-space: nowrap; display: flex; align-items: center; gap: 4px; margin-top: 2px; }

        /* Online dot */
        .status-dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: var(--success);
            box-shadow: 0 0 6px var(--success);
            animation: pulse-dot 2s ease-in-out infinite;
            display: inline-block;
        }

        /* ========== NAV SECTION LABEL ========== */
        .nav-section-label {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.3);
            padding: 0.75rem 1.5rem 0.25rem;
            white-space: nowrap;
            overflow: hidden;
        }
        .sidebar.collapsed .nav-section-label { opacity: 0; height: 0; padding: 0; }

        /* ========== NAVIGATION ========== */
        .sidebar-nav { padding: 0.5rem 0; flex: 1; }
        .nav-item { margin: 0.15rem 0.5rem; }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 1rem;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            border-radius: 10px;
            transition: all var(--transition);
            white-space: nowrap;
            position: relative;
            font-size: 0.88rem;
            font-weight: 500;
        }
        .nav-link:hover {
            background: rgba(255,255,255,0.08);
            color: white;
            transform: translateX(2px);
        }
        .nav-link.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 14px rgba(37,99,235,0.4);
        }
        .nav-link.active::before {
            content: '';
            position: absolute;
            left: -8px; top: 50%;
            transform: translateY(-50%);
            width: 3px; height: 60%;
            background: white;
            border-radius: 2px;
        }

        .nav-link i { font-size: 1.1rem; width: 22px; text-align: center; flex-shrink: 0; }
        .nav-link-text { transition: opacity var(--transition), width var(--transition); overflow: hidden; flex: 1; }

        .sidebar.collapsed .nav-link-text { opacity: 0; width: 0; display: none; }
        .sidebar.collapsed .nav-link { justify-content: center; padding: 0.75rem; gap: 0; }
        .sidebar.collapsed .nav-link::before { display: none; }

        /* Tooltip on collapse */
        .sidebar.collapsed .nav-link:hover::after {
            content: attr(data-title);
            position: absolute;
            left: calc(100% + 10px); top: 50%;
            transform: translateY(-50%);
            padding: 0.45rem 0.8rem;
            background: #1e293b;
            color: white;
            border-radius: 8px;
            white-space: nowrap;
            font-size: 0.8rem;
            font-weight: 500;
            box-shadow: var(--shadow-md);
            z-index: 9999;
            pointer-events: none;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .nav-divider { height: 1px; background: rgba(255,255,255,0.07); margin: 0.4rem 1rem; }

        /* ========== SIDEBAR FOOTER ========== */
        .sidebar-footer {
            margin-top: auto;
            padding: 0.75rem;
            border-top: 1px solid rgba(255,255,255,0.07);
            flex-shrink: 0;
            background: linear-gradient(to bottom, transparent, rgba(0,0,0,0.2));
        }

        .logout-link {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.65rem 1rem;
            color: #fca5a5;
            text-decoration: none;
            border-radius: 10px;
            transition: all var(--transition);
            white-space: nowrap;
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.15);
            width: 100%; cursor: pointer; text-align: left;
            font-size: 0.88rem; font-weight: 500;
            position: relative;
        }
        .logout-link:hover { background: rgba(239,68,68,0.18); color: #f87171; transform: translateX(2px); }
        .logout-link i { font-size: 1.1rem; width: 22px; text-align: center; flex-shrink: 0; }

        .sidebar.collapsed .logout-link { justify-content: center; padding: 0.75rem; gap: 0; border: none; background: rgba(239,68,68,0.08); }
        .sidebar.collapsed .logout-link .nav-link-text { opacity: 0; width: 0; display: none; }
        .sidebar.collapsed .logout-link:hover::after {
            content: "Log Keluar";
            position: absolute;
            left: calc(100% + 10px); top: 50%;
            transform: translateY(-50%);
            padding: 0.45rem 0.8rem;
            background: #1e293b; color: white;
            border-radius: 8px; white-space: nowrap;
            font-size: 0.8rem; font-weight: 500;
            box-shadow: var(--shadow-md); z-index: 9999;
            pointer-events: none;
            border: 1px solid rgba(255,255,255,0.1);
        }

        /* ========================================
   TOPBAR
======================================== */
        .topbar {
            background: white;
            height: var(--topbar-height);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
        }
        .topbar-left { display: flex; flex-direction: column; }
        .topbar-page-title { font-size: 0.95rem; font-weight: 700; color: var(--text-primary); line-height: 1.2; }
        .topbar-breadcrumb { font-size: 0.75rem; color: var(--text-secondary); }
        .topbar-right { display: flex; align-items: center; gap: 1rem; }
        .topbar-clock {
            font-size: 0.8rem;
            color: var(--text-secondary);
            font-weight: 500;
            background: var(--content-bg);
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            border: 1px solid var(--border-color);
            white-space: nowrap;
        }
        .topbar-user-chip {
            display: flex; align-items: center; gap: 0.5rem;
            font-size: 0.82rem; font-weight: 600;
            color: var(--text-primary);
        }
        .topbar-avatar {
            width: 32px; height: 32px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.8rem; font-weight: 700;
        }

        /* ========================================
   MAIN CONTENT AREA
======================================== */
        .main-content {
            margin-left: var(--sidebar-width);
            transition: margin-left var(--transition);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .main-content.expanded { margin-left: var(--sidebar-collapsed-width); }
        .main-content.no-sidebar { margin-left: 0 !important; }

        .content-wrapper {
            flex: 1;
            padding: 1.5rem;
        }

        /* ========================================
   ENHANCED CARD SYSTEM
======================================== */
        .card {
            border: 1px solid var(--border-color);
            border-radius: var(--card-radius);
            box-shadow: var(--shadow-sm);
            background: white;
            transition: box-shadow var(--transition), transform var(--transition);
        }
        .card:hover { box-shadow: var(--shadow-md); }
        .card-hover-lift:hover { transform: translateY(-3px); box-shadow: var(--shadow-lg); }

        .card-header {
            border-bottom: 1px solid var(--border-color);
            background: white;
            border-radius: var(--card-radius) var(--card-radius) 0 0 !important;
            padding: 1rem 1.25rem;
        }
        .card-header-accent {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
        }

        /* Stat Cards */
        .stat-card {
            border-radius: var(--card-radius);
            background: white;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            transition: all var(--transition);
            overflow: hidden;
            position: relative;
        }
        .stat-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); }
        .stat-card .stat-accent {
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 4px;
            border-radius: 4px 0 0 4px;
        }
        .stat-card .stat-body { padding: 1.25rem 1.25rem 1.25rem 1.5rem; }
        .stat-card .stat-label { font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: var(--text-secondary); margin-bottom: 0.4rem; white-space: nowrap; text-overflow: ellipsis; overflow: hidden; }
        .stat-card .stat-value { font-size: 2rem; font-weight: 800; line-height: 1; color: var(--text-primary); }
        .stat-card .stat-sub { font-size: 0.78rem; color: var(--text-secondary); margin-top: 0.4rem; }
        .stat-card .stat-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }
        .stat-card .stat-link { font-size: 0.78rem; font-weight: 600; color: var(--primary); text-decoration: none; display: flex; align-items: center; gap: 4px; }
        .stat-card .stat-link:hover { color: var(--primary-dark); }

        /* ========================================
   PAGE HEADER
======================================== */
        .page-header {
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.75rem;
        }
        .page-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--text-primary);
            margin: 0 0 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .page-title i { color: var(--primary); }

        /* ========================================
   BUTTONS
======================================== */
        .btn {
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }
        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
            box-shadow: 0 2px 8px rgba(37,99,235,0.3);
        }
        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            box-shadow: 0 4px 14px rgba(37,99,235,0.4);
            transform: translateY(-1px);
        }
        .btn-sm { padding: 0.35rem 0.75rem; font-size: 0.8rem; border-radius: 6px; }

        /* ========================================
   FORM CONTROLS
======================================== */
        .form-control, .form-select {
            border: 1.5px solid var(--border-color);
            border-radius: 8px;
            padding: 0.55rem 0.875rem;
            font-size: 0.9rem;
            transition: all var(--transition);
            background: white;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-glow);
        }
        .form-label { font-weight: 600; font-size: 0.82rem; color: var(--text-primary); margin-bottom: 0.4rem; }

        /* Filter Panel */
        .filter-panel {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: var(--card-radius);
            padding: 1.25rem;
            margin-bottom: 1.25rem;
            box-shadow: var(--shadow-sm);
        }
        .filter-panel-title {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-secondary);
            margin-bottom: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        /* ========================================
   TABLES
======================================== */
        .table {
            margin: 0;
            font-size: 0.875rem;
        }
        .table thead th {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--text-secondary);
            background: #f8fafc;
            border-bottom: 1px solid var(--border-color);
            padding: 0.75rem 1rem;
            white-space: nowrap;
        }
        .table tbody td {
            padding: 0.85rem 1rem;
            vertical-align: middle;
            border-color: var(--border-color);
            color: var(--text-primary);
        }
        .table tbody tr { transition: background var(--transition); }
        .table tbody tr:hover td { background: #f8fafc; }

        /* Avatar initials in tables */
        .avatar-initials {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 0.75rem; font-weight: 700;
            flex-shrink: 0;
        }

        /* ========================================
   BADGES
======================================== */
        .badge {
            font-weight: 600;
            font-size: 0.72rem;
            padding: 0.3em 0.7em;
            border-radius: 6px;
            letter-spacing: 0.02em;
        }
        .badge-status-active {
            background: rgba(16,185,129,0.12);
            color: #065f46;
            border: 1px solid rgba(16,185,129,0.25);
        }
        .badge-status-inactive {
            background: rgba(100,116,139,0.1);
            color: #475569;
            border: 1px solid rgba(100,116,139,0.2);
        }
        .badge-role-admin {
            background: rgba(239,68,68,0.1);
            color: #991b1b;
            border: 1px solid rgba(239,68,68,0.2);
        }
        .badge-role-user {
            background: rgba(37,99,235,0.1);
            color: #1e3a8a;
            border: 1px solid rgba(37,99,235,0.2);
        }

        /* ========================================
   ALERTS & FLASH MESSAGES
======================================== */
        .alert { border-radius: 10px; border: none; font-size: 0.875rem; font-weight: 500; }
        .alert-success { background: rgba(16,185,129,0.1); color: #065f46; border: 1px solid rgba(16,185,129,0.25); }
        .alert-danger  { background: rgba(239,68,68,0.1);  color: #991b1b; border: 1px solid rgba(239,68,68,0.25);  }

        /* ========================================
   EMPTY STATE
======================================== */
        .empty-state {
            text-align: center;
            padding: 3.5rem 1rem;
        }
        .empty-state-icon {
            width: 72px; height: 72px;
            border-radius: 20px;
            background: var(--content-bg);
            border: 2px dashed var(--border-color);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.75rem; color: var(--text-secondary);
            margin: 0 auto 1rem;
        }
        .empty-state h6 { font-weight: 700; color: var(--text-primary); margin-bottom: 0.25rem; }
        .empty-state p { font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 1rem; }

        /* ========================================
   BREADCRUMB
======================================== */
        .breadcrumb { margin: 0; font-size: 0.8rem; }
        .breadcrumb-item a { color: var(--primary); text-decoration: none; font-weight: 500; }
        .breadcrumb-item.active { color: var(--text-secondary); }
        .breadcrumb-item + .breadcrumb-item::before { color: var(--border-color); }

        /* ========================================
   SELECT2 OVERRIDES
======================================== */
        .select2-container--bootstrap-5 .select2-selection { min-height: 38px; border-radius: 8px; }
        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered { padding-left: 12px; }
        .input-group-text { background: #f8fafc; border-color: var(--border-color); }

        /* ========================================
   MOBILE RESPONSIVE
======================================== */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0 !important; }
            .mobile-toggle { display: flex !important; }
            .topbar-clock { display: none; }
        }

        /* Mobile Toggle */
        .mobile-toggle {
            display: none;
            position: fixed;
            bottom: 24px; right: 24px;
            width: 52px; height: 52px;
            border-radius: 14px;
            background: var(--primary);
            color: white;
            border: none;
            box-shadow: 0 6px 20px rgba(37,99,235,0.4);
            z-index: 1040;
            align-items: center; justify-content: center;
            font-size: 1.4rem;
        }

        /* Overlay */
        .overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.45);
            backdrop-filter: blur(2px);
            z-index: 1045;
        }
        .overlay.show { display: block; animation: fadeIn 0.2s ease; }

        /* Sidebar Logo */
        .sidebar-logo-img, .sidebar-brand-logo {
            width: 100%; height: 100%;
            object-fit: contain;
            mix-blend-mode: lighten;
            transform: scale(1.5);
            transition: all var(--transition);
        }
        .collapsed-logo-icon { display: none; font-size: 1.4rem; color: white; margin: 0 auto; }
        .sidebar.collapsed .sidebar-logo-img { display: none !important; }
        .sidebar.collapsed .collapsed-logo-icon { display: block !important; }
        .sidebar.collapsed .collapsed-logo-icon i { opacity: 1 !important; width: auto !important; display: inline-block !important; }
        .sidebar.collapsed .sidebar-brand { display: none !important; }
        .sidebar.collapsed .sidebar-header { justify-content: center; padding: 0 0.5rem; }

        /* ========================================
   END OF DESIGN SYSTEM
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
                {{-- Dynamic link based on role --}}
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
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div class="user-details">
                        <div class="user-name">{{ auth()->user()->name }}</div>
                        <div class="user-role">
                            <span class="status-dot"></span>
                            @if (auth()->user()->isAdmin())
                                Administrator
                            @else
                                Pengguna
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="sidebar-nav">
                {{-- USER DASHBOARD --}}
                @if (false) {{-- Hiding user function --}}
                    <div class="nav-section-label">Menu Utama</div>
                    <div class="nav-item">
                        <a href="{{ route('dashboard') }}"
                            class="nav-link {{ request()->routeIs('dashboard') || request()->routeIs('components.index') ? 'active' : '' }}"
                            data-title="Dashboard">
                            <i class="bi bi-house-door"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </div>
                @endif

                {{-- ADMIN DASHBOARD --}}
                @if (auth()->user()->isAdmin())
                    <div class="nav-section-label">Menu Utama</div>
                    <div class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                            class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                            data-title="Admin Dashboard">
                            <i class="bi bi-speedometer2"></i>
                            <span class="nav-link-text">Admin Dashboard</span>
                        </a>
                    </div>
                @endif

                {{-- BORANG (USER ONLY) --}}
                @if (false) {{-- Hiding user function --}}
                    <div class="nav-section-label">Borang</div>
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

                {{-- ADMIN MANAGEMENT --}}
                @if (auth()->user()->isAdmin())
                    <div class="nav-section-label">Pengurusan Data</div>
                    <div class="nav-item">
                        <a href="{{ route('admin.bidang.index') }}"
                            class="nav-link {{ request()->routeIs('admin.bidang.*') ? 'active' : '' }}"
                            data-title="Bidang">
                            <i class="bi bi-tags"></i>
                            <span class="nav-link-text">Pendaftaran Kod Bidang</span>
                        </a>
                    </div>
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

                    <div class="nav-section-label">Sistem</div>
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

            <!-- Logout Button -->
            <div class="sidebar-footer">
                <button type="button" class="logout-link" data-bs-toggle="modal" data-bs-target="#logoutConfirmModal">
                    <i class="bi bi-box-arrow-right"></i>
                    <span class="nav-link-text">Log Keluar</span>
                </button>
            </div>
        </aside>

        <!-- Mobile Toggle -->
        <button class="mobile-toggle" id="mobileToggle">
            <i class="bi bi-list"></i>
        </button>

        <!-- Overlay -->
        <div class="overlay" id="overlay"></div>

        <!-- Logout Confirmation Modal -->
        <div class="modal fade" id="logoutConfirmModal" tabindex="-1" aria-labelledby="logoutConfirmModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius:16px;overflow:hidden;">
                    <div class="modal-header border-0 pb-0" style="background:linear-gradient(135deg,#ef4444,#dc2626);padding:1.5rem 1.5rem 1rem;">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:42px;height:42px;background:rgba(255,255,255,0.2);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-box-arrow-right text-white fs-5"></i>
                            </div>
                            <div>
                                <h5 class="modal-title text-white mb-0 fw-700" id="logoutConfirmModalLabel">Log Keluar</h5>
                                <p class="text-white mb-0" style="font-size:0.78rem;opacity:0.8;">Sesi anda akan ditamatkan</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body text-center px-4 py-4">
                        <p class="text-secondary mb-0" style="font-size:0.9rem;">Adakah anda pasti ingin log keluar? Anda perlu log masuk semula untuk mengakses sistem.</p>
                    </div>
                    <div class="modal-footer border-0 px-4 pb-4 pt-0 gap-2">
                        <button type="button" class="btn btn-outline-secondary flex-fill" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Batal
                        </button>
                        <button type="button" class="btn btn-danger flex-fill" onclick="document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right"></i> Log Keluar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hidden Logout Form -->
        <form action="{{ route('logout') }}" method="POST" id="logout-form" class="d-none">
            @csrf
        </form>
    @endauth

    <!-- MAIN CONTENT -->
    <main class="main-content {{ auth()->check() ? '' : 'no-sidebar' }}" id="mainContent">
        @auth
        <!-- Topbar -->
        <div class="topbar">
            <div class="topbar-left">
                <div class="topbar-page-title">@yield('title', 'Sistem Daftar Aset')</div>
                <div class="topbar-breadcrumb">
                    <i class="bi bi-building me-1"></i> ASPIRA &mdash; Asset Project Integrated Record Application
                </div>
            </div>
            <div class="topbar-right">
                <div class="topbar-clock" id="topbarClock">
                    <i class="bi bi-clock me-1"></i> <span id="clockTime"></span>
                </div>
                <div class="topbar-user-chip">
                    <div class="topbar-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <span>{{ auth()->user()->name }}</span>
                </div>
            </div>
        </div>
        @endauth

        <div class="content-wrapper">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="page-content">
                @yield('content')
            </div>
        </div>
    </main>

    <!-- jQuery (required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <script>
        // CSRF Token
        $(function() {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });
        });

        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const toggleBtn = document.getElementById('toggleSidebar');
        const mobileToggle = document.getElementById('mobileToggle');
        const overlay = document.getElementById('overlay');

        // Restore sidebar state
        if (localStorage.getItem('sidebarCollapsed') === 'true') {
            sidebar && sidebar.classList.add('collapsed');
            mainContent && mainContent.classList.add('expanded');
        }

        if (toggleBtn && sidebar && mainContent) {
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
                localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
            });
        }

        if (mobileToggle && sidebar && overlay) {
            mobileToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            });
        }

        if (overlay && sidebar) {
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });
        }

        // Live Clock
        function updateClock() {
            const el = document.getElementById('clockTime');
            if (!el) return;
            const now = new Date();
            const days = ['Ahad','Isnin','Selasa','Rabu','Khamis','Jumaat','Sabtu'];
            const months = ['Jan','Feb','Mac','Apr','Mei','Jun','Jul','Ogos','Sep','Okt','Nov','Dis'];
            const d = days[now.getDay()];
            const date = String(now.getDate()).padStart(2,'0');
            const month = months[now.getMonth()];
            const year = now.getFullYear();
            const h = String(now.getHours()).padStart(2,'0');
            const m = String(now.getMinutes()).padStart(2,'0');
            const s = String(now.getSeconds()).padStart(2,'0');
            el.textContent = `${d}, ${date} ${month} ${year} | ${h}:${m}:${s}`;
        }
        if (document.getElementById('clockTime')) {
            updateClock();
            setInterval(updateClock, 1000);
        }
    </script>

    @stack('scripts')
    @yield('scripts')
</body>
</html>
