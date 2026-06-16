{{-- resources/views/admin/components/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Pendaftaran Komponen - Admin')

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
    }

    .stats-number {
        font-size: 2rem;
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
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .filter-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .table-container {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
    }

    .data-table {
        margin-bottom: 0;
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
        border-bottom: 1px solid #f1f5f9;
    }

    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .btn-icon {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .location-info {
        font-size: 0.85rem;
        color: #64748b;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
    }

    .empty-icon {
        font-size: 3rem;
        color: #cbd5e1;
        margin-bottom: 1rem;
    }
</style>

<!-- Header -->
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">Pendaftaran Komponen</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Komponen</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('components.index') }}" class="btn btn-outline-success">
                <i class="bi bi-plus-circle"></i> Tambah Komponen
            </a>
            <a href="{{ route('admin.components.statistics') }}" class="btn btn-outline-info">
                <i class="bi bi-graph-up"></i> Statistik
            </a>
            <a href="{{ route('export.borang-komponen.excel') }}" class="btn btn-success">
                <i class="bi bi-file-earmark-excel-fill"></i> Eksport Excel
            </a>
            <a href="{{ route('admin.components.trashed') }}" class="btn btn-outline-secondary">
                <i class="bi bi-trash"></i> Arkib ({{ \App\Models\Component::onlyTrashed()->count() }})
            </a>
        </div>
    </div>
</div>



<!-- Stats -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="stats-card">
            <div class="stats-icon" style="background: #dbeafe; color: #2563eb;">
                <i class="bi bi-building"></i>
            </div>
            <div class="stats-number">{{ \App\Models\Component::count() }}</div>
            <div class="stats-label">Jumlah Komponen</div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stats-card">
            <div class="stats-icon" style="background: #d1fae5; color: #10b981;">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stats-number">{{ \App\Models\Component::aktif()->count() }}</div>
            <div class="stats-label">Komponen Aktif</div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stats-card">
            <div class="stats-icon" style="background: #fef3c7; color: #f59e0b;">
                <i class="bi bi-x-circle"></i>
            </div>
            <div class="stats-number">{{ \App\Models\Component::tidakAktif()->count() }}</div>
            <div class="stats-label">Tidak Aktif</div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="stats-card">
            <div class="stats-icon" style="background: #e0e7ff; color: #6366f1;">
                <i class="bi bi-people"></i>
            </div>
            <div class="stats-number">{{ \App\Models\User::whereHas('components')->count() }}</div>
            <div class="stats-label">Pengguna Aktif</div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="filter-card">
    <form action="{{ route('admin.components.index') }}" method="GET" class="row g-3">
        <div class="col-md-3">
            <label class="form-label">Cari Komponen</label>
            <input type="text" name="search" class="form-control" 
                   placeholder="Nama premis, DPA, kod..." 
                   value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <label class="form-label">Pengguna</label>
            <select name="user_id" class="form-select">
                <option value="">Semua Pengguna</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Jenis</label>
            <select name="type" class="form-select">
                <option value="">Semua Jenis</option>
                <option value="blok" {{ request('type') === 'blok' ? 'selected' : '' }}>Blok</option>
                <option value="binaan_luar" {{ request('type') === 'binaan_luar' ? 'selected' : '' }}>Binaan Luar</option>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="tidak_aktif" {{ request('status') === 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-primary flex-fill">
                <i class="bi bi-search"></i> Cari
            </button>
            <a href="{{ route('admin.components.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-clockwise"></i>
            </a>
        </div>
    </form>
</div>

<!-- Components Table -->
@if($components->count() > 0)
<div class="table-container">
    <table class="table data-table">
        <thead>
            <tr>
                <th width="10%">No. DPA</th>
                <th width="25%">Nama Premis / Lokasi</th>
                <th width="20%">Dicipta Oleh</th>
                <th width="12%">Tarikh</th>
                <th width="8%">Status</th>
                <th width="15%" class="text-end">Tindakan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($components as $component)
                <tr>
                    <td>
                        <span class="badge bg-secondary">{{ $component->nombor_dpa }}</span>
                    </td>
                    <td>
                        <div>
                            <strong>{{ $component->nama_premis }}</strong>
                            <div class="location-info mt-1">
                                <span class="badge bg-info">{{ $component->kod_lokasi }}</span>
                                @if($component->ada_blok && $component->nama_blok)
                                    <br><i class="bi bi-building"></i> {{ $component->nama_blok }}
                                @endif
                                @if($component->ada_binaan_luar && $component->nama_binaan_luar)
                                    <br><i class="bi bi-house"></i> {{ $component->nama_binaan_luar }}
                                @endif
                                @if($component->main_components_count > 0)
                                    <br><i class="bi bi-box"></i> {{ $component->main_components_count }} komponen utama
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($component->user)
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-2">
                                    {{ strtoupper(substr($component->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold" style="font-size: 0.9rem;">{{ $component->user->name }}</div>
                                    <small class="text-muted">
                                        @if($component->user->username)
                                            {{ $component->user->username }}
                                        @else
                                            ID: {{ $component->user->id }}
                                        @endif
                                        @if($component->user->email)
                                            <br>{{ $component->user->email }}
                                        @endif
                                    </small>
                                </div>
                            </div>
                        @else
                            <span class="text-muted small">-</span>
                        @endif
                    </td>
                    <td>
                        <small class="text-muted">
                            <div>{{ $component->created_at->format('d/m/Y') }}</div>
                            <div>{{ $component->created_at->format('h:i A') }}</div>
                        </small>
                    </td>
                    <td>
                        <form action="{{ route('admin.components.toggle-status', $component) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="badge {{ $component->status === 'aktif' ? 'bg-success' : 'bg-secondary' }} border-0" 
                                    style="cursor: pointer;"
                                    title="Klik untuk tukar status">
                                {{ ucfirst($component->status) }}
                            </button>
                        </form>
                    </td>
                    <td>
                        <div class="d-flex gap-1 justify-content-end">
                            <a href="{{ route('admin.components.show', $component) }}" 
                               class="btn btn-info btn-sm btn-icon" 
                               title="Lihat">
                                <i class="bi bi-eye"></i>
                            </a>
                            <button type="button" 
                                    class="btn btn-danger btn-sm btn-icon" 
                                    onclick="deleteComponent({{ $component->id }})" 
                                    title="Padam">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                        <form id="delete-form-{{ $component->id }}" 
                              action="{{ route('admin.components.destroy', $component) }}" 
                              method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($components->hasPages())
    <div class="mt-3">
        {{ $components->links() }}
    </div>
@endif

<!-- Summary -->
@if($components->total() > 0)
    <div class="mt-3">
        <small class="text-muted">
            Menunjukkan {{ $components->firstItem() }} hingga {{ $components->lastItem() }} 
            daripada {{ $components->total() }} komponen
        </small>
    </div>
@endif

@else
<!-- Empty State -->
<div class="empty-state">
    <div class="empty-icon">
        <i class="bi bi-inbox"></i>
    </div>
    <h5>Tiada Komponen Dijumpai</h5>
    <p class="text-muted mb-0">Tiada komponen yang sepadan dengan carian anda.</p>
</div>
@endif

@endsection

@section('scripts')
<script>
function deleteComponent(componentId) {
    if (confirm('Adakah anda pasti ingin memadam komponen ini?\n\nKomponen akan dipindahkan ke arkib.')) {
        document.getElementById('delete-form-' + componentId).submit();
    }
}

// Auto-hide alerts
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>
@endsection