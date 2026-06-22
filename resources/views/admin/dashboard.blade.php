{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    
    {{-- ===== WELCOME BANNER ===== --}}
    <div class="welcome-banner mb-4">
        <div class="welcome-banner-inner">
            <div>
                <div class="welcome-label">Selamat Datang Kembali,</div>
                <h4 class="welcome-name">{{ Auth::user()->name }}</h4>
                <p class="welcome-sub mb-0">
                    <i class="bi bi-calendar3 me-1"></i>
                    {{ now()->locale('ms')->isoFormat('dddd, D MMMM YYYY') }}
                </p>
            </div>
            <div class="welcome-badge">
                <i class="bi bi-shield-fill-check"></i>
                <span>Administrator</span>
            </div>
        </div>
    </div>

    {{-- ===== STAT CARDS ===== --}}
    <div class="row g-3 mb-4">
        {{-- Users --}}
        <div class="col-6 col-md-3">
            <div class="stat-card card-hover-lift">
                <div class="stat-accent" style="background:#2563eb;"></div>
                <div class="stat-body d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Jumlah Pengguna</div>
                        <div class="stat-value counter" data-target="{{ $stats['total_users'] }}">0</div>
                        <div class="stat-sub">
                            <span style="color:var(--success);">
                                <i class="bi bi-circle-fill" style="font-size:0.5rem;"></i>
                                {{ $stats['active_users'] }} Aktif
                            </span>
                        </div>
                    </div>
                    <div class="stat-icon" style="background:rgba(37,99,235,0.1);color:#2563eb;">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
                <div class="stat-footer">
                    <a href="{{ route('admin.users.index') }}" class="stat-link">
                        Urus Pengguna <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Sistem/Subsistem --}}
        <div class="col-6 col-md-3">
            <div class="stat-card card-hover-lift">
                <div class="stat-accent" style="background:#ef4444;"></div>
                <div class="stat-body d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Sistem / Subsistem</div>
                        <div class="stat-value counter" data-target="{{ $stats['total_sistem'] + $stats['total_subsistem'] }}">0</div>
                        <div class="stat-sub">{{ $stats['total_sistem'] }} Sistem, {{ $stats['total_subsistem'] }} Subsistem</div>
                    </div>
                    <div class="stat-icon" style="background:rgba(239,68,68,0.1);color:#ef4444;">
                        <i class="bi bi-diagram-3-fill"></i>
                    </div>
                </div>
                <div class="stat-footer">
                    <a href="{{ route('admin.sistem.index') }}" class="stat-link">
                        Urus Sistem <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Komponen Aktif --}}
        <div class="col-6 col-md-3">
            <div class="stat-card card-hover-lift">
                <div class="stat-accent" style="background:#10b981;"></div>
                <div class="stat-body d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Jumlah Komponen</div>
                        <div class="stat-value counter" data-target="{{ \App\Models\Component::count() }}">0</div>
                        <div class="stat-sub">
                            <span style="color:var(--success);">
                                <i class="bi bi-circle-fill" style="font-size:0.5rem;"></i>
                                {{ \App\Models\Component::aktif()->count() }} Aktif
                            </span>
                        </div>
                    </div>
                    <div class="stat-icon" style="background:rgba(16,185,129,0.1);color:#10b981;">
                        <i class="bi bi-building-fill"></i>
                    </div>
                </div>
                <div class="stat-footer">
                    <a href="{{ route('admin.components.index') }}" class="stat-link">
                        Urus Komponen <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Arkib --}}
        <div class="col-6 col-md-3">
            <div class="stat-card card-hover-lift">
                <div class="stat-accent" style="background:#f59e0b;"></div>
                <div class="stat-body d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Arkib Komponen</div>
                        <div class="stat-value counter" data-target="{{ \App\Models\Component::onlyTrashed()->count() }}">0</div>
                        <div class="stat-sub" style="color:var(--warning);">
                            <i class="bi bi-archive-fill"></i> Dipadam / Diarkib
                        </div>
                    </div>
                    <div class="stat-icon" style="background:rgba(245,158,11,0.1);color:#f59e0b;">
                        <i class="bi bi-archive-fill"></i>
                    </div>
                </div>
                <div class="stat-footer">
                    <a href="{{ route('admin.components.trashed') }}" class="stat-link">
                        Lihat Arkib <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== CHARTS ROW ===== --}}
    <div class="row g-3 mb-4">
        {{-- Doughnut: Component Status --}}
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-700">
                        <i class="bi bi-pie-chart-fill text-primary me-2"></i>Status Komponen
                    </h6>
                    <span class="badge" style="background:rgba(37,99,235,0.1);color:#2563eb;">Infografik</span>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center" style="min-height:220px;">
                    <div style="max-width:200px;width:100%;position:relative;">
                        <canvas id="componentStatusChart"></canvas>
                        <div class="chart-center-label">
                            <div class="chart-center-value">{{ \App\Models\Component::count() }}</div>
                            <div class="chart-center-sub">Jumlah</div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <div class="d-flex justify-content-around">
                        <div class="text-center">
                            <div class="fw-700" style="color:#10b981;">{{ \App\Models\Component::aktif()->count() }}</div>
                            <div style="font-size:0.72rem;color:var(--text-secondary);">Aktif</div>
                        </div>
                        <div class="text-center">
                            <div class="fw-700" style="color:#64748b;">{{ \App\Models\Component::where('status','tidak_aktif')->count() }}</div>
                            <div style="font-size:0.72rem;color:var(--text-secondary);">Tidak Aktif</div>
                        </div>
                        <div class="text-center">
                            <div class="fw-700" style="color:#f59e0b;">{{ \App\Models\Component::onlyTrashed()->count() }}</div>
                            <div style="font-size:0.72rem;color:var(--text-secondary);">Arkib</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Horizontal Bar: Components by Sistem --}}
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-700">
                        <i class="bi bi-bar-chart-steps text-primary me-2"></i>Komponen Mengikut Sistem
                    </h6>
                    <span class="badge" style="background:rgba(16,185,129,0.1);color:#059669;">Taburan Sistem</span>
                </div>
                <div class="card-body" style="min-height:220px;">
                    @if($componentsBySistem->isEmpty())
                        <div class="empty-state">
                            <div class="empty-state-icon"><i class="bi bi-diagram-3"></i></div>
                            <p>Tiada data sistem</p>
                        </div>
                    @else
                        <div class="sistem-bar-list">
                            @php $maxComp = $componentsBySistem->max('components_count') ?: 1; @endphp
                            @foreach($componentsBySistem as $s)
                            @php
                                $barColors = ['linear-gradient(90deg,#2563eb,#60a5fa)', 'linear-gradient(90deg,#10b981,#34d399)', 'linear-gradient(90deg,#8b5cf6,#a78bfa)'];
                                $barGradient = $barColors[$loop->index % 3];
                                $barWidth = ($maxComp > 0) ? round(($s->components_count / $maxComp) * 100) : 0;
                            @endphp
                            <div class="sistem-bar-row">
                                <div class="sistem-bar-meta">
                                    <span class="sistem-bar-kod">{{ $s->kod }}</span>
                                    <span class="sistem-bar-nama">{{ Str::limit($s->nama, 30) }}</span>
                                    <span class="sistem-bar-count">{{ $s->components_count }}</span>
                                </div>
                                <div class="sistem-bar-track">
                                    <div class="sistem-bar-fill"
                                         data-width="{{ $barWidth }}"
                                         data-bg="{{ $barGradient }}">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ===== AUDIT LOG + USER OVERVIEW ===== --}}
    <div class="row g-3 mb-4">
        {{-- Recent Audit Log --}}
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-700">
                        <i class="bi bi-clock-history text-primary me-2"></i>Log Aktiviti Terkini
                    </h6>
                    <span class="badge" style="background:rgba(139,92,246,0.1);color:#7c3aed;">Masa Nyata</span>
                </div>
                <div class="card-body p-0">
                    @forelse($recentAuditLogs as $log)
                    @php
                        $logTitle = strtolower($log->title ?? '');
                        $isCreate = str_contains($logTitle, 'tambah') || str_contains($logTitle, 'cipta') || str_contains($logTitle, 'buat');
                        $isDelete = str_contains($logTitle, 'padam') || str_contains($logTitle, 'buang');
                        $isEdit   = str_contains($logTitle, 'kemaskini') || str_contains($logTitle, 'edit') || str_contains($logTitle, 'ubah');
                        $auditBg    = $isCreate ? 'rgba(16,185,129,0.1)' : ($isDelete ? 'rgba(239,68,68,0.1)' : ($isEdit ? 'rgba(245,158,11,0.1)' : 'rgba(37,99,235,0.1)'));
                        $auditColor = $isCreate ? '#10b981' : ($isDelete ? '#ef4444' : ($isEdit ? '#f59e0b' : '#2563eb'));
                        $auditIcon  = $isCreate ? 'bi-plus-lg' : ($isDelete ? 'bi-trash3' : ($isEdit ? 'bi-pencil' : 'bi-eye'));
                    @endphp
                    <div class="audit-row {{ !$loop->last ? 'audit-row-border' : '' }}">
                        <div class="audit-icon-wrap" data-bg="{{ $auditBg }}">
                            <i class="bi {{ $auditIcon }}" data-color="{{ $auditColor }}"></i>
                        </div>
                        <div class="audit-info">
                            <div class="audit-title">{{ $log->title }}</div>
                            @if($log->description)
                            <div class="audit-desc">{{ Str::limit($log->description, 60) }}</div>
                            @endif
                        </div>
                        <div class="audit-right">
                            @if($log->user)
                            <div class="audit-user">{{ $log->user->name }}</div>
                            @endif
                            <div class="audit-time">{{ $log->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state py-4">
                        <div class="empty-state-icon"><i class="bi bi-clock"></i></div>
                        <p>Tiada log aktiviti</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- User Role Breakdown --}}
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-700">
                        <i class="bi bi-people-fill text-primary me-2"></i>Pengguna Sistem
                    </h6>
                    <span class="badge" style="background:rgba(37,99,235,0.1);color:#2563eb;">Ringkasan</span>
                </div>
                <div class="card-body d-flex flex-column justify-content-center gap-3">
                    {{-- Admin --}}
                    <div class="user-role-block">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div class="d-flex align-items-center gap-2">
                                <div class="role-dot" style="background:#2563eb;"></div>
                                <span class="fw-600" style="font-size:0.88rem;">Administrator</span>
                            </div>
                            <span class="fw-700" style="color:#2563eb;font-size:1rem;">{{ $stats['admin_users'] }}</span>
                        </div>
                        <div class="role-progress-track">
                            <div class="role-progress-fill" style="background:#2563eb;"
                                 data-width="{{ $stats['total_users'] > 0 ? round(($stats['admin_users'] / $stats['total_users']) * 100) : 0 }}"></div>
                        </div>
                    </div>
                    {{-- Regular User --}}
                    <div class="user-role-block">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div class="d-flex align-items-center gap-2">
                                <div class="role-dot" style="background:#10b981;"></div>
                                <span class="fw-600" style="font-size:0.88rem;">Pengguna Biasa</span>
                            </div>
                            <span class="fw-700" style="color:#10b981;font-size:1rem;">{{ $stats['regular_users'] }}</span>
                        </div>
                        <div class="role-progress-track">
                            <div class="role-progress-fill" style="background:#10b981;"
                                 data-width="{{ $stats['total_users'] > 0 ? round(($stats['regular_users'] / $stats['total_users']) * 100) : 0 }}"></div>
                        </div>
                    </div>
                    {{-- Active --}}
                    <div class="user-role-block">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div class="d-flex align-items-center gap-2">
                                <div class="role-dot" style="background:#f59e0b;"></div>
                                <span class="fw-600" style="font-size:0.88rem;">Pengguna Aktif</span>
                            </div>
                            <span class="fw-700" style="color:#f59e0b;font-size:1rem;">{{ $stats['active_users'] }}</span>
                        </div>
                        <div class="role-progress-track">
                            <div class="role-progress-fill" style="background:#f59e0b;"
                                 data-width="{{ $stats['total_users'] > 0 ? round(($stats['active_users'] / $stats['total_users']) * 100) : 0 }}"></div>
                        </div>
                    </div>
                    <hr class="my-1">
                    <div class="d-flex justify-content-between align-items-center">
                        <span style="font-size:0.82rem;color:var(--text-secondary);">Jumlah Keseluruhan</span>
                        <span class="fw-700" style="font-size:1.2rem;color:var(--text-primary);">{{ $stats['total_users'] }}</span>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary mt-1">
                        <i class="bi bi-arrow-right me-1"></i>Urus Semua Pengguna
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== ACTIVITY + QUICK ACTIONS ===== --}}
    <div class="row g-3 mb-4">
        {{-- User Activity Table --}}
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-700">
                        <i class="bi bi-activity text-primary me-2"></i>Aktiviti Pengguna
                    </h6>
                    <span class="badge bg-secondary rounded-pill">Top 10</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Pengguna</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th class="text-center">Komponen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($userActivity as $activity)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-initials" style="font-size:0.7rem;">
                                                {{ strtoupper(substr($activity->name, 0, 2)) }}
                                            </div>
                                            <span class="fw-600">{{ $activity->name }}</span>
                                        </div>
                                    </td>
                                    <td><code class="text-primary">{{ $activity->username }}</code></td>
                                    <td>
                                        @if($activity->role === 'admin')
                                        <span class="badge badge-role-admin">Admin</span>
                                        @else
                                        <span class="badge badge-role-user">User</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="fw-700" style="color:var(--primary);">{{ $activity->total_components }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="empty-state">
                                            <div class="empty-state-icon"><i class="bi bi-inbox"></i></div>
                                            <h6>Tiada Data</h6>
                                            <p>Belum ada aktiviti pengguna</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <h6 class="mb-0 fw-700">
                        <i class="bi bi-lightning-fill text-warning me-2"></i>Akses Pantas
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                            <i class="bi bi-person-plus-fill"></i> Tambah Pengguna
                        </a>
                        <a href="{{ route('admin.sistem.create') }}" class="btn btn-success">
                            <i class="bi bi-plus-circle-fill"></i> Tambah Sistem
                        </a>
                        <a href="{{ route('components.create') }}" class="btn btn-info text-white">
                            <i class="bi bi-box-seam-fill"></i> Tambah Komponen
                        </a>
                        <a href="{{ route('admin.components.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-building"></i> Urus Komponen
                        </a>
                        <a href="{{ route('admin.components.statistics') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-graph-up"></i> Statistik Komponen
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== RECENT COMPONENTS ===== --}}
    <div class="row g-3 mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-700">
                        <i class="bi bi-building-fill text-primary me-2"></i>Komponen Terkini
                    </h6>
                    <a href="{{ route('admin.components.index') }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>No. DPA</th>
                                    <th>Nama Premis</th>
                                    <th>Lokasi</th>
                                    <th>Dicipta Oleh</th>
                                    <th>Tarikh</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $recentComponents = \App\Models\Component::with('user')
                                        ->orderBy('created_at', 'desc')
                                        ->limit(5)
                                        ->get();
                                @endphp
                                @forelse($recentComponents as $component)
                                <tr>
                                    <td>
                                        <span class="badge" style="background:rgba(37,99,235,0.1);color:#2563eb;font-weight:700;">{{ $component->nombor_dpa }}</span>
                                    </td>
                                    <td>
                                        <div class="fw-600">{{ $component->nama_premis }}</div>
                                        @if($component->ada_blok && $component->nama_blok)
                                            <small class="text-muted"><i class="bi bi-building"></i> {{ $component->nama_blok }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge" style="background:rgba(6,182,212,0.1);color:#0891b2;">{{ $component->kod_lokasi }}</span>
                                    </td>
                                    <td>
                                        @if($component->user)
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="avatar-initials" style="width:28px;height:28px;font-size:0.65rem;border-radius:7px;">
                                                    {{ strtoupper(substr($component->user->name, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <div class="fw-600" style="font-size:0.83rem;">{{ $component->user->name }}</div>
                                                    <div class="text-muted" style="font-size:0.72rem;">{{ $component->user->username }}</div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="font-size:0.82rem;font-weight:600;">{{ $component->created_at->format('d/m/Y') }}</div>
                                        <div class="text-muted" style="font-size:0.72rem;">{{ $component->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td>
                                        @if($component->status === 'aktif')
                                        <span class="badge badge-status-active">Aktif</span>
                                        @else
                                        <span class="badge badge-status-inactive">{{ ucfirst($component->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <div class="empty-state-icon"><i class="bi bi-inbox"></i></div>
                                            <h6>Tiada Komponen</h6>
                                            <p>Belum ada komponen didaftarkan</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== SISTEM STATISTICS ===== --}}
    <div class="row g-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0 fw-700">
                        <i class="bi bi-diagram-3-fill text-primary me-2"></i>Statistik Sistem &amp; Subsistem
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @forelse($sistemStats as $sistem)
                        <div class="col-md-4 col-sm-6">
                            <div class="sistem-stat-card">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <div class="fw-700" style="font-size:1rem;color:var(--text-primary);">{{ $sistem->kod }}</div>
                                        <div class="text-muted" style="font-size:0.8rem;">{{ $sistem->nama }}</div>
                                    </div>
                                    @if($sistem->is_active)
                                    <span class="badge badge-status-active">Aktif</span>
                                    @else
                                    <span class="badge badge-status-inactive">Tidak Aktif</span>
                                    @endif
                                </div>
                                <div class="d-flex align-items-center gap-2 mt-2">
                                    <i class="bi bi-diagram-2-fill text-primary"></i>
                                    <span style="font-size:0.83rem;font-weight:600;">{{ $sistem->subsistems_count }} Subsistem</span>
                                </div>
                                <div class="sistem-progress mt-2">
                                    <div class="sistem-progress-bar" data-width="{{ min(($sistem->subsistems_count / max($sistemStats->max('subsistems_count'), 1)) * 100, 100) }}"></div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center text-muted py-4">Tiada data sistem</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* ===== WELCOME BANNER ===== */
    .welcome-banner {
        background: linear-gradient(135deg, #1e40af 0%, #1e293b 60%, #0f172a 100%);
        border-radius: 16px;
        padding: 1.5rem;
        color: white;
        position: relative;
        overflow: hidden;
    }
    .welcome-banner::before {
        content: '';
        position: absolute; right: -40px; top: -40px;
        width: 180px; height: 180px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
    }
    .welcome-banner::after {
        content: '';
        position: absolute; right: 40px; bottom: -60px;
        width: 120px; height: 120px;
        border-radius: 50%;
        background: rgba(255,255,255,0.03);
    }
    .welcome-banner-inner {
        display: flex; justify-content: space-between; align-items: center;
        position: relative; z-index: 1;
    }
    .welcome-label { font-size: 0.78rem; opacity: 0.7; font-weight: 500; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.06em; }
    .welcome-name { font-size: 1.5rem; font-weight: 800; margin-bottom: 6px; }
    .welcome-sub { font-size: 0.82rem; opacity: 0.7; }
    .welcome-badge {
        display: flex; align-items: center; gap: 8px;
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 10px;
        padding: 0.5rem 1rem;
        font-size: 0.82rem; font-weight: 600;
        backdrop-filter: blur(4px);
    }

    /* ===== STAT CARD FOOTER ===== */
    .stat-footer {
        padding: 0.6rem 1.25rem 0.75rem 1.5rem;
        border-top: 1px solid var(--border-color);
    }
    .fw-600 { font-weight: 600; }
    .fw-700 { font-weight: 700; }

    /* ===== SISTEM BAR LIST ===== */
    .sistem-bar-list { display: flex; flex-direction: column; gap: 10px; padding: 4px 0; }
    .sistem-bar-row { display: flex; flex-direction: column; gap: 4px; }
    .sistem-bar-meta {
        display: flex; align-items: center; gap: 8px;
    }
    .sistem-bar-kod {
        font-size: 0.72rem; font-weight: 700;
        background: rgba(37,99,235,0.08); color: #2563eb;
        border-radius: 5px; padding: 1px 7px;
        white-space: nowrap;
    }
    .sistem-bar-nama {
        font-size: 0.82rem; font-weight: 600; color: var(--text-primary);
        flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .sistem-bar-count {
        font-size: 0.8rem; font-weight: 700; color: var(--text-secondary);
        margin-left: auto; white-space: nowrap;
    }
    .sistem-bar-track {
        height: 8px; border-radius: 8px;
        background: var(--border-color);
        overflow: hidden;
    }
    .sistem-bar-fill {
        height: 100%; border-radius: 8px;
        width: 0;
        transition: width 1s cubic-bezier(0.22,1,0.36,1);
    }

    /* ===== AUDIT LOG ===== */
    .audit-row {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 16px;
        transition: background 0.2s;
    }
    .audit-row:hover { background: var(--content-bg); }
    .audit-row-border { border-bottom: 1px solid var(--border-color); }
    .audit-icon-wrap {
        width: 34px; height: 34px; border-radius: 9px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.85rem;
    }
    .audit-info { flex: 1; min-width: 0; }
    .audit-title { font-size: 0.85rem; font-weight: 600; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .audit-desc { font-size: 0.76rem; color: var(--text-secondary); margin-top: 1px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .audit-right { text-align: right; flex-shrink: 0; }
    .audit-user { font-size: 0.76rem; font-weight: 600; color: var(--text-primary); }
    .audit-time { font-size: 0.72rem; color: var(--text-secondary); }

    /* ===== USER ROLE BREAKDOWN ===== */
    .role-dot { width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0; }
    .role-progress-track {
        height: 6px; border-radius: 6px; background: var(--border-color); overflow: hidden;
    }
    .role-progress-fill {
        height: 100%; border-radius: 6px; width: 0;
        transition: width 1s cubic-bezier(0.22,1,0.36,1);
        opacity: 0.75;
    }

    /* ===== CHART CENTER LABEL ===== */
    .chart-center-label {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        pointer-events: none;
    }
    .chart-center-value { font-size: 1.6rem; font-weight: 800; color: var(--text-primary); line-height: 1; }
    .chart-center-sub { font-size: 0.7rem; color: var(--text-secondary); font-weight: 600; text-transform: uppercase; }

    /* ===== SISTEM STAT CARD ===== */
    .sistem-stat-card {
        background: var(--content-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem;
        transition: all var(--transition);
    }
    .sistem-stat-card:hover {
        background: white;
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }
    .sistem-progress {
        height: 4px; border-radius: 4px;
        background: var(--border-color);
        overflow: hidden;
    }
    .sistem-progress-bar {
        height: 100%; border-radius: 4px;
        background: linear-gradient(90deg, var(--primary), var(--primary-light));
        transition: width 1s ease;
    }
</style>
@endsection

@section('scripts')
<script>
// ===== ANIMATED COUNTERS =====
document.querySelectorAll('.counter').forEach(el => {
    const target = parseInt(el.dataset.target, 10);
    const duration = 1200;
    const start = performance.now();
    function step(now) {
        const elapsed = now - start;
        const progress = Math.min(elapsed / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        el.textContent = Math.round(eased * target);
        if (progress < 1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
});

// ===== CHART.JS: COMPONENT STATUS =====
const donutCtx = document.getElementById('componentStatusChart').getContext('2d');
new Chart(donutCtx, {
    type: 'doughnut',
    data: {
        labels: ['Aktif', 'Tidak Aktif', 'Arkib'],
        datasets: [{
            data: [
                parseInt("{{ \App\Models\Component::aktif()->count() }}", 10),
                parseInt("{{ \App\Models\Component::where('status','tidak_aktif')->count() }}", 10),
                parseInt("{{ \App\Models\Component::onlyTrashed()->count() }}", 10)
            ],
            backgroundColor: ['#10b981', '#94a3b8', '#f59e0b'],
            borderWidth: 0,
            hoverOffset: 6
        }]
    },
    options: {
        cutout: '72%',
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => ` ${ctx.label}: ${ctx.parsed}`
                }
            }
        },
        animation: { duration: 900, easing: 'easeInOutQuart' }
    }
});

// ===== ANIMATE SISTEM BARS =====
window.addEventListener('load', () => {
    document.querySelectorAll('.sistem-bar-fill').forEach(el => {
        el.style.background = el.dataset.bg;
        el.style.width = (el.dataset.width || 0) + '%';
    });

    // ===== APPLY DYNAMIC AUDIT LOG STYLES =====
    document.querySelectorAll('.audit-icon-wrap').forEach(el => {
        if (el.dataset.bg) {
            el.style.background = el.dataset.bg;
        }
        const icon = el.querySelector('i');
        if (icon && icon.dataset.color) {
            icon.style.color = icon.dataset.color;
        }
    });

    // ===== ANIMATE ROLE PROGRESS BARS =====
    document.querySelectorAll('.role-progress-fill').forEach(el => {
        el.style.width = (el.dataset.width || 0) + '%';
    });

    // ===== ANIMATE SISTEM SECTION PROGRESS =====
    document.querySelectorAll('.sistem-progress-bar').forEach(el => {
        el.style.width = el.dataset.width + '%';
    });
});
</script>
@endsection