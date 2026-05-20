{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="bi bi-speedometer2"></i> Admin Dashboard</h2>
            <p class="text-muted mb-0">Selamat datang, {{ Auth::user()->name }}!</p>
        </div>
        <div>
            <span class="badge bg-danger fs-6">Administrator</span>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <!-- Users Stats -->
        <div class="col-md-3">
            <div class="card border-0 shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Jumlah Pengguna</p>
                            <h3 class="mb-0">{{ $stats['total_users'] }}</h3>
                            <small class="text-success">
                                <i class="bi bi-check-circle"></i> {{ $stats['active_users'] }} Aktif
                            </small>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="bi bi-people fs-3 text-primary"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('admin.users.index') }}" class="text-decoration-none small">
                        Urus Pengguna <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Sistem Stats -->
        <div class="col-md-3">
            <div class="card border-0 shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Sistem/Subsistem</p>
                            <h3 class="mb-0">{{ $stats['total_sistem'] }}/{{ $stats['total_subsistem'] }}</h3>
                            <small class="text-danger">
                                Total: {{ $stats['total_sistem'] + $stats['total_subsistem'] }}
                            </small>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-3 rounded">
                            <i class="bi bi-diagram-3 fs-3 text-danger"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('admin.sistem.index') }}" class="text-decoration-none small">
                        Urus Sistem <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- ✅ TAMBAH: Components Stats -->
        <div class="col-md-3">
            <div class="card border-0 shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Jumlah Komponen</p>
                            <h3 class="mb-0">{{ \App\Models\Component::count() }}</h3>
                            <small class="text-success">
                                <i class="bi bi-check-circle"></i> {{ \App\Models\Component::aktif()->count() }} Aktif
                            </small>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="bi bi-building fs-3 text-success"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('admin.components.index') }}" class="text-decoration-none small">
                        Urus Komponen <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- ✅ TAMBAH: Components in Archive -->
        <div class="col-md-3">
            <div class="card border-0 shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Arkib Komponen</p>
                            <h3 class="mb-0">{{ \App\Models\Component::onlyTrashed()->count() }}</h3>
                            <small class="text-warning">
                                <i class="bi bi-trash"></i> Dipadam
                            </small>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="bi bi-archive fs-3 text-warning"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('admin.components.trashed') }}" class="text-decoration-none small">
                        Lihat Arkib <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- User Activity -->
        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-activity"></i> Aktiviti Pengguna</h5>
                        <span class="badge bg-secondary">Top 10</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Pengguna</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th class="text-center">Komponen Didaftar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($userActivity as $activity)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                                <i class="bi bi-person-fill text-primary"></i>
                                            </div>
                                            <span class="fw-semibold">{{ $activity->name }}</span>
                                        </div>
                                    </td>
                                    <td><code>{{ $activity->username }}</code></td>
                                    <td>
                                        @if($activity->role === 'admin')
                                        <span class="badge bg-danger">Admin</span>
                                        @else
                                        <span class="badge bg-primary">User</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success fs-6">{{ $activity->total_components }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        Tiada data aktiviti
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Users & Quick Actions -->
        <div class="col-md-4">
            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0"><i class="bi bi-lightning"></i> Akses Pantas</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                            <i class="bi bi-person-plus"></i> Tambah Pengguna
                        </a>
                        <a href="{{ route('admin.sistem.create') }}" class="btn btn-success">
                            <i class="bi bi-plus-circle"></i> Tambah Sistem
                        </a>
                        <a href="{{ route('components.create') }}" class="btn btn-info text-white">
                            <i class="bi bi-box-seam"></i> Tambah Komponen
                        </a>
                        {{-- ✅ TAMBAH: Link ke Component Management --}}
                        <a href="{{ route('admin.components.index') }}" class="btn btn-outline-success">
                            <i class="bi bi-building"></i> Urus Komponen
                        </a>
                        <a href="{{ route('admin.components.statistics') }}" class="btn btn-outline-info">
                            <i class="bi bi-graph-up"></i> Statistik Komponen
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ TAMBAH: Recent Components Section -->
    <div class="row mt-4">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-building"></i> Komponen Terkini</h5>
                        <a href="{{ route('admin.components.index') }}" class="btn btn-sm btn-outline-primary">
                            Lihat Semua <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
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
                                        <span class="badge bg-secondary">{{ $component->nombor_dpa }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $component->nama_premis }}</strong>
                                        @if($component->ada_blok && $component->nama_blok)
                                            <br><small class="text-muted">
                                                <i class="bi bi-building"></i> {{ $component->nama_blok }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $component->kod_lokasi }}</span>
                                    </td>
                                    <td>
                                        @if($component->user)
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                                    <i class="bi bi-person-fill text-primary"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-semibold small">{{ $component->user->name }}</div>
                                                    <small class="text-muted">{{ $component->user->username ?? 'ID: '.$component->user->id }}</small>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $component->created_at->format('d/m/Y') }}<br>
                                            {{ $component->created_at->diffForHumans() }}
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge {{ $component->status === 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($component->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        Tiada komponen terkini
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

    <!-- Sistem Statistics -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0"><i class="bi bi-diagram-3"></i> Statistik Sistem & Subsistem</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @forelse($sistemStats as $sistem)
                        <div class="col-md-4">
                            <div class="border rounded p-3 h-100">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-0">{{ $sistem->kod }}</h6>
                                        <small class="text-muted">{{ $sistem->nama }}</small>
                                    </div>
                                    @if($sistem->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                    @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                    @endif
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-diagram-2 text-primary me-2"></i>
                                    <span>{{ $sistem->subsistems_count }} Subsistem</span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center text-muted py-4">
                            Tiada data sistem
                        </div>
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
    .card {
        transition: transform 0.2s;
    }
    
    .card:hover {
        transform: translateY(-2px);
    }
    
    .list-group-item {
        border-left: none;
        border-right: none;
    }
    
    .list-group-item:first-child {
        border-top: none;
    }
    
    .list-group-item:last-child {
        border-bottom: none;
    }
</style>
@endsection