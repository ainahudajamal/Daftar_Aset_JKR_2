{{-- resources/views/admin/components/statistics.blade.php --}}
@extends('layouts.app')

@section('title', 'Statistik Komponen')

@section('content')
<style>
    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .stats-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
        height: 100%;
        transition: all 0.2s;
    }

    .stats-card:hover {
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }

    .stats-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0.5rem 0;
    }

    .stats-label {
        color: #64748b;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .stats-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        margin-bottom: 1rem;
    }

    .chart-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .chart-card h5 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e2e8f0;
    }

    .list-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
    }

    .list-card-header {
        background: #f8fafc;
        padding: 1rem 1.5rem;
        border-bottom: 2px solid #e2e8f0;
        font-weight: 600;
        color: #1e293b;
    }

    .list-item {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.15s;
    }

    .list-item:last-child {
        border-bottom: none;
    }

    .list-item:hover {
        background: #f8fafc;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
        font-weight: 600;
    }

    .progress-bar-custom {
        height: 8px;
        border-radius: 4px;
        background: #e2e8f0;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #2563eb, #1d4ed8);
        transition: width 0.3s;
    }
</style>

<!-- Header -->
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title"><i class="bi bi-graph-up"></i> Statistik Komponen</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.components.index') }}">Komponen</a></li>
                    <li class="breadcrumb-item active">Statistik</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.components.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<!-- Main Stats -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card">
            <div class="stats-icon" style="background: #dbeafe; color: #2563eb;">
                <i class="bi bi-building"></i>
            </div>
            <div class="stats-number">{{ $stats['total_components'] }}</div>
            <div class="stats-label">Jumlah Komponen</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card">
            <div class="stats-icon" style="background: #d1fae5; color: #10b981;">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stats-number">{{ $stats['active_components'] }}</div>
            <div class="stats-label">Komponen Aktif</div>
            <small class="text-muted">
                {{ $stats['total_components'] > 0 ? round(($stats['active_components'] / $stats['total_components']) * 100, 1) : 0 }}% daripada jumlah
            </small>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card">
            <div class="stats-icon" style="background: #fef3c7; color: #f59e0b;">
                <i class="bi bi-x-circle"></i>
            </div>
            <div class="stats-number">{{ $stats['inactive_components'] }}</div>
            <div class="stats-label">Tidak Aktif</div>
            <small class="text-muted">
                {{ $stats['total_components'] > 0 ? round(($stats['inactive_components'] / $stats['total_components']) * 100, 1) : 0 }}% daripada jumlah
            </small>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stats-card">
            <div class="stats-icon" style="background: #fee2e2; color: #ef4444;">
                <i class="bi bi-trash"></i>
            </div>
            <div class="stats-number">{{ $stats['trashed_components'] }}</div>
            <div class="stats-label">Dipadam (Arkib)</div>
        </div>
    </div>
</div>

<!-- Additional Stats -->
<div class="row mb-4">
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="stats-card">
            <div class="stats-icon" style="background: #e0e7ff; color: #6366f1;">
                <i class="bi bi-people"></i>
            </div>
            <div class="stats-number">{{ $stats['total_users'] }}</div>
            <div class="stats-label">Pengguna Aktif</div>
            <small class="text-muted">Yang telah membuat komponen</small>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="stats-card">
            <div class="stats-icon" style="background: #d1fae5; color: #10b981;">
                <i class="bi bi-building"></i>
            </div>
            <div class="stats-number">{{ $stats['components_with_blok'] }}</div>
            <div class="stats-label">Komponen Blok</div>
            <small class="text-muted">
                {{ $stats['total_components'] > 0 ? round(($stats['components_with_blok'] / $stats['total_components']) * 100, 1) : 0 }}% daripada jumlah
            </small>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="stats-card">
            <div class="stats-icon" style="background: #cffafe; color: #06b6d4;">
                <i class="bi bi-house"></i>
            </div>
            <div class="stats-number">{{ $stats['components_with_binaan_luar'] }}</div>
            <div class="stats-label">Binaan Luar</div>
            <small class="text-muted">
                {{ $stats['total_components'] > 0 ? round(($stats['components_with_binaan_luar'] / $stats['total_components']) * 100, 1) : 0 }}% daripada jumlah
            </small>
        </div>
    </div>
</div>

<!-- Charts and Lists -->
<div class="row">
    <!-- Recent Components -->
    <div class="col-lg-6 mb-4">
        <div class="list-card">
            <div class="list-card-header">
                <i class="bi bi-clock-history"></i> Komponen Terkini
            </div>
            <div>
                @forelse($stats['recent_components'] as $component)
                    <div class="list-item">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <strong>{{ $component->nama_premis }}</strong>
                                <br>
                                <small class="text-muted">
                                    <i class="bi bi-hash"></i> {{ $component->nombor_dpa }}
                                    @if($component->user)
                                        · <i class="bi bi-person"></i> {{ $component->user->name }}
                                    @endif
                                </small>
                            </div>
                            <span class="badge {{ $component->status === 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucwords(str_replace('_', ' ', $component->status)) }}
                            </span>
                        </div>
                        <small class="text-muted">
                            <i class="bi bi-calendar"></i> {{ $component->created_at->format('d/m/Y h:i A') }}
                            ({{ $component->created_at->diffForHumans() }})
                        </small>
                    </div>
                @empty
                    <div class="list-item text-center text-muted">
                        Tiada komponen
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Top Users -->
    <div class="col-lg-6 mb-4">
        <div class="list-card">
            <div class="list-card-header">
                <i class="bi bi-trophy"></i> Pengguna Teratas
            </div>
            <div>
                @forelse($stats['top_users'] as $index => $user)
                    <div class="list-item">
                        <div class="d-flex align-items-center mb-2">
                            <div class="me-3">
                                <strong style="font-size: 1.5rem; color: {{ $index === 0 ? '#f59e0b' : ($index === 1 ? '#94a3b8' : '#cd7f32') }};">
                                    #{{ $index + 1 }}
                                </strong>
                            </div>
                            <div class="user-avatar me-3">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="flex-fill">
                                <div class="fw-semibold">{{ $user->name }}</div>
                                <small class="text-muted">
                                    @if($user->username)
                                        {{ $user->username }}
                                    @else
                                        {{ $user->email }}
                                    @endif
                                </small>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-primary" style="font-size: 1.25rem;">{{ $user->components_count }}</div>
                                <small class="text-muted">komponen</small>
                            </div>
                        </div>
                        <div class="progress-bar-custom">
                            <div class="progress-fill" 
                                 style="width: {{ $stats['top_users']->first()->components_count > 0 ? ($user->components_count / $stats['top_users']->first()->components_count) * 100 : 0 }}%">
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="list-item text-center text-muted">
                        Tiada data pengguna
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Status Overview -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="chart-card">
            <h5><i class="bi bi-pie-chart"></i> Ringkasan Status Komponen</h5>
            
            <div class="row text-center">
                <div class="col-md-3 mb-3">
                    <div class="p-3 rounded" style="background: #dbeafe;">
                        <div style="font-size: 2rem; font-weight: 700; color: #2563eb;">
                            {{ $stats['total_components'] }}
                        </div>
                        <div class="text-muted small mt-1">Jumlah Keseluruhan</div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="p-3 rounded" style="background: #d1fae5;">
                        <div style="font-size: 2rem; font-weight: 700; color: #10b981;">
                            {{ $stats['active_components'] }}
                        </div>
                        <div class="text-muted small mt-1">
                            Aktif ({{ $stats['total_components'] > 0 ? round(($stats['active_components'] / $stats['total_components']) * 100, 1) : 0 }}%)
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="p-3 rounded" style="background: #fef3c7;">
                        <div style="font-size: 2rem; font-weight: 700; color: #f59e0b;">
                            {{ $stats['inactive_components'] }}
                        </div>
                        <div class="text-muted small mt-1">
                            Tidak Aktif ({{ $stats['total_components'] > 0 ? round(($stats['inactive_components'] / $stats['total_components']) * 100, 1) : 0 }}%)
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="p-3 rounded" style="background: #fee2e2;">
                        <div style="font-size: 2rem; font-weight: 700; color: #ef4444;">
                            {{ $stats['trashed_components'] }}
                        </div>
                        <div class="text-muted small mt-1">Dipadam</div>
                    </div>
                </div>
            </div>

            <!-- Progress Bars -->
            <div class="mt-4">
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <small class="fw-semibold">Komponen Aktif</small>
                        <small class="text-muted">{{ $stats['active_components'] }} / {{ $stats['total_components'] }}</small>
                    </div>
                    <div class="progress" style="height: 12px;">
                        <div class="progress-bar bg-success" 
                             style="width: {{ $stats['total_components'] > 0 ? ($stats['active_components'] / $stats['total_components']) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <small class="fw-semibold">Komponen Tidak Aktif</small>
                        <small class="text-muted">{{ $stats['inactive_components'] }} / {{ $stats['total_components'] }}</small>
                    </div>
                    <div class="progress" style="height: 12px;">
                        <div class="progress-bar bg-warning" 
                             style="width: {{ $stats['total_components'] > 0 ? ($stats['inactive_components'] / $stats['total_components']) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>

                <div>
                    <div class="d-flex justify-content-between mb-1">
                        <small class="fw-semibold">Komponen Blok</small>
                        <small class="text-muted">{{ $stats['components_with_blok'] }} / {{ $stats['total_components'] }}</small>
                    </div>
                    <div class="progress" style="height: 12px;">
                        <div class="progress-bar bg-primary" 
                             style="width: {{ $stats['total_components'] > 0 ? ($stats['components_with_blok'] / $stats['total_components']) * 100 : 0 }}%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
