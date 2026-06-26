{{-- resources/views/components/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Pengguna')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="bi bi-speedometer2"></i> Pendaftaran Komponen</h2>
            <p class="text-muted mb-0">Selamat datang, {{ Auth::user()->name }}!</p>
        </div>
        <div>
            @if(Auth::user()->role === 'admin')
                <span class="badge bg-danger fs-6">JKR</span>
            @else
                <span class="badge bg-primary fs-6">Pengguna</span>
            @endif
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <!-- Components Stats -->
        <div class="col-md-3">
            <div class="card border-0 shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Komponen</p>
                            <h3 class="mb-0">{{ $components->count() }}</h3>
                            <small class="text-success">
                                <i class="bi bi-check-circle"></i> {{ $components->where('status', 'aktif')->count() }} Aktif
                            </small>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="bi bi-box-seam fs-3 text-primary"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    {{-- ✅ FIXED: Changed from route('user.components.index') to route('components.create') --}}
                    <a href="{{ route('components.create') }}" class="text-decoration-none small">
                        Tambah Komponen <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Components Stats -->
        <div class="col-md-3">
            <div class="card border-0 shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Komponen Utama</p>
                            <h3 class="mb-0">{{ $components->sum(fn($c) => $c->mainComponents->count()) }}</h3>
                            <small class="text-success">
                                <i class="bi bi-layers"></i> Total
                            </small>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="bi bi-layers fs-3 text-success"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('main-components.create') }}" class="text-decoration-none small">
                        Tambah Komponen Utama <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Sub Components Stats -->
        <div class="col-md-3">
            <div class="card border-0 shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Sub Komponen</p>
                            <h3 class="mb-0">{{ $components->sum(fn($c) => $c->mainComponents->sum(fn($m) => $m->subComponents->count())) }}</h3>
                            <small class="text-info">
                                <i class="bi bi-diagram-3"></i> Total
                            </small>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="bi bi-diagram-3 fs-3 text-info"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('sub-components.create') }}" class="text-decoration-none small">
                        Tambah Sub Komponen <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Active/Inactive Ratio -->
        <div class="col-md-3">
            <div class="card border-0 shadow h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Status Komponen</p>
                            <h3 class="mb-0">
                                {{ $components->where('status', 'aktif')->count() }}/{{ $components->count() }}
                            </h3>
                            <small class="text-warning">
                                <i class="bi bi-activity"></i> Aktif/Total
                            </small>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="bi bi-activity fs-3 text-warning"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <span class="text-muted small">
                        {{ $components->where('status', 'tidak aktif')->count() }} Tidak Aktif
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0"><i class="bi bi-lightning"></i> Akses Pantas</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="{{ route('components.create') }}" class="action-card text-decoration-none">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                                        <i class="bi bi-plus-lg fs-3 text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Borang 1</h6>
                                        <small class="text-muted">Peringkat Komponen</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('main-components.create') }}" class="action-card text-decoration-none">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 p-3 rounded me-3">
                                        <i class="bi bi-plus-lg fs-3 text-success"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Borang 2</h6>
                                        <small class="text-muted">Peringkat Komponen Utama</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('sub-components.create') }}" class="action-card text-decoration-none">
                                <div class="d-flex align-items-center">
                                    <div class="bg-info bg-opacity-10 p-3 rounded me-3">
                                        <i class="bi bi-plus-lg fs-3 text-info"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">Borang 3</h6>
                                        <small class="text-muted">Peringkat Sub Komponen</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Components Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-building"></i> Senarai Komponen</h5>
                        <span class="badge bg-secondary">{{ $components->count() }} Komponen</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($components->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 data-table">
                            <thead class="table-light">
                                <tr>
                                    <th width="50"></th>
                                    <th>Komponen / Lokasi</th>
                                    <th>Status</th>
                                    <th>Nombor DPA</th>
                                    <th width="120">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($components as $component)
                                    <!-- Component Row -->
                                    <tr>
                                        <td>
                                            @if($component->mainComponents->count() > 0)
                                                <button class="expand-btn" onclick="toggleRow('comp-{{ $component->id }}', this)">
                                                    <i class="bi bi-chevron-right"></i>
                                                </button>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ $component->nama_premis }}</strong>
                                                <div class="location-info mt-1">
                                                    @if($component->kod_blok)
                                                        <i class="bi bi-building"></i> {{ $component->kod_blok }}
                                                    @endif
                                                    @if($component->nama_ruang)
                                                        · <i class="bi bi-door-open"></i> {{ $component->nama_ruang }}
                                                    @endif
                                                    @if($component->nama_binaan_luar)
                                                        · <i class="bi bi-geo-alt"></i> {{ $component->nama_binaan_luar }}
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge {{ $component->status == 'aktif' ? 'badge-status-active' : 'badge-status-inactive' }}">
                                                {{ $component->status == 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        </td>
                                        <td><span class="badge bg-secondary">{{ $component->nombor_dpa }}</span></td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('components.show', $component) }}" class="btn btn-outline-info btn-sm btn-icon" title="Lihat">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('components.edit', $component) }}" class="btn btn-outline-primary btn-sm btn-icon" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('components.delete', $component) }}" method="POST" 
                                                      onsubmit="return confirm('Padam komponen ini?')" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm btn-icon" title="Padam">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Main Components Nested Rows -->
                                    @foreach($component->mainComponents as $mainComponent)
                                        <tr class="nested-row" data-parent="comp-{{ $component->id }}">
                                            <td colspan="5">
                                                <table class="nested-table level-2">
                                                    <tr class="row-level-2">
                                                        <td width="50">
                                                            @if($mainComponent->subComponents->count() > 0)
                                                                <button class="expand-btn" onclick="toggleRow('main-{{ $mainComponent->id }}', this)">
                                                                    <i class="bi bi-chevron-right"></i>
                                                                </button>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div>
                                                                <span class="badge bg-success small me-2">Komponen Utama</span>
                                                                <strong>{{ $mainComponent->nama_komponen_utama }}</strong>
                                                                @if($mainComponent->jenama || $mainComponent->model)
                                                                    <div class="location-info mt-1">
                                                                        @if($mainComponent->jenama)
                                                                            <i class="bi bi-tag"></i> {{ $mainComponent->jenama }}
                                                                        @endif
                                                                        @if($mainComponent->model)
                                                                            · <i class="bi bi-box"></i> {{ $mainComponent->model }}
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </td>
                                                        <td width="100">
                                                            <span class="badge {{ $mainComponent->status == 'aktif' ? 'badge-status-active' : 'badge-status-inactive' }} small">
                                                                {{ $mainComponent->status == 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                                                            </span>
                                                        </td>
                                                        <td width="120"></td>
                                                        <td width="120">
                                                            <div class="d-flex gap-1">
                                                                <a href="{{ route('main-components.show', $mainComponent) }}" class="btn btn-outline-info btn-sm btn-icon" title="Lihat">
                                                                    <i class="bi bi-eye"></i>
                                                                </a>
                                                                <a href="{{ route('main-components.edit', $mainComponent) }}" class="btn btn-outline-primary btn-sm btn-icon" title="Edit">
                                                                    <i class="bi bi-pencil"></i>
                                                                </a>
                                                                <form action="{{ route('main-components.delete', $mainComponent) }}" method="POST"
                                                                      onsubmit="return confirm('Padam komponen utama ini?')" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-outline-danger btn-sm btn-icon" title="Padam">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- Sub Components Nested Rows -->
                                                    @foreach($mainComponent->subComponents as $subComponent)
                                                        <tr class="nested-row" data-parent="main-{{ $mainComponent->id }}">
                                                            <td colspan="5">
                                                                <table class="nested-table level-3">
                                                                    <tr class="row-level-3">
                                                                        <td width="50"></td>
                                                                        <td>
                                                                            <div>
                                                                                <span class="badge bg-info small me-2">Sub Komponen</span>
                                                                                <strong>{{ $subComponent->nama_sub_komponen }}</strong>
                                                                                @if($subComponent->jenama || $subComponent->model)
                                                                                    <div class="location-info mt-1">
                                                                                        @if($subComponent->jenama){{ $subComponent->jenama }}@endif
                                                                                        @if($subComponent->model) · {{ $subComponent->model }}@endif
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                        </td>
                                                                        <td width="100">
                                                                            <span class="badge {{ $subComponent->status == 'aktif' ? 'badge-status-active' : 'badge-status-inactive' }} small">
                                                                                {{ $subComponent->status == 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                                                                            </span>
                                                                        </td>
                                                                        <td width="120"></td>
                                                                        <td width="120">
                                                                            <div class="d-flex gap-1">
                                                                                <a href="{{ route('sub-components.show', $subComponent) }}" class="btn btn-outline-info btn-sm btn-icon" title="Lihat">
                                                                                    <i class="bi bi-eye"></i>
                                                                                </a>
                                                                                <a href="{{ route('sub-components.edit', $subComponent) }}" class="btn btn-outline-primary btn-sm btn-icon" title="Edit">
                                                                                    <i class="bi bi-pencil"></i>
                                                                                </a>
                                                                                <form action="{{ route('sub-components.delete', $subComponent) }}" method="POST"
                                                                                      onsubmit="return confirm('Padam sub komponen ini?')" class="d-inline">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit" class="btn btn-outline-danger btn-sm btn-icon" title="Padam">
                                                                                        <i class="bi bi-trash"></i>
                                                                                    </button>
                                                                                </form>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="bi bi-inbox"></i>
                        </div>
                        <h5>Tiada Data</h5>
                        <p class="text-muted mb-3">Belum ada komponen ditambah.</p>
                        <a href="{{ route('components.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambah Komponen
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleRow(parentId, button) {
    // Toggle button rotation
    button.classList.toggle('expanded');
    
    // Find all rows with matching parent
    const rows = document.querySelectorAll(`[data-parent="${parentId}"]`);
    
    rows.forEach(row => {
        row.classList.toggle('show');
        
        // If closing, also close all nested children
        if (!row.classList.contains('show')) {
            const nestedButtons = row.querySelectorAll('.expand-btn.expanded');
            nestedButtons.forEach(btn => {
                btn.classList.remove('expanded');
            });
            
            const childRows = row.querySelectorAll('.nested-row.show');
            childRows.forEach(child => {
                child.classList.remove('show');
            });
        }
    });
}
</script>

@endsection

@section('styles')
<style>
    .card {
        transition: transform 0.2s;
    }
    
    .card:hover {
        transform: translateY(-2px);
    }

    .action-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.25rem;
        transition: all 0.2s;
        display: block;
        color: inherit;
    }

    .action-card:hover {
        border-color: #2563eb;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }

    .data-table thead th {
        background: #f8fafc;
        color: #64748b;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
        padding: 1rem;
    }

    .data-table tbody tr {
        transition: background-color 0.15s;
    }

    .data-table tbody tr:hover {
        background: #f8fafc;
    }

    .data-table td {
        padding: 1rem;
        vertical-align: middle;
    }

    .expand-btn {
        background: none;
        border: none;
        cursor: pointer;
        color: #64748b;
        font-size: 1.1rem;
        padding: 0.25rem 0.5rem;
        transition: transform 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 4px;
    }

    .expand-btn:hover {
        background: #f1f5f9;
        color: #1e293b;
    }

    .expand-btn.expanded {
        transform: rotate(90deg);
    }

    .nested-row {
        display: none;
        background: #f8fafc;
    }

    .nested-row.show {
        display: table-row;
    }

    .nested-row td {
        padding: 0 !important;
        border: none;
    }

    .nested-table {
        width: 100%;
        margin: 0;
        background: #f8fafc;
    }

    .nested-table td {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e2e8f0;
        background: white;
    }

    .nested-table.level-2 td {
        padding-left: 3rem;
        background: #fefefe;
    }

    .nested-table.level-3 td {
        padding-left: 5rem;
        background: #f9fafb;
    }

    .row-level-2 {
        border-left: 3px solid #10b981;
    }

    .row-level-3 {
        border-left: 3px solid #06b6d4;
    }

    .btn-icon {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
    }

    .empty-icon {
        font-size: 3rem;
        color: #cbd5e1;
        margin-bottom: 1rem;
    }

    .location-info {
        font-size: 0.85rem;
        color: #64748b;
    }
</style>
@endsection