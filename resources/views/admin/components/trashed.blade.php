{{-- resources/views/admin/components/trashed.blade.php --}}
@extends('layouts.app')

@section('title', 'Arkib Komponen')

@section('content')
<style>
    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.5rem;
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
        opacity: 0.7;
    }

    .data-table tbody tr:hover {
        background: #fef2f2;
        opacity: 1;
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

    .deleted-badge {
        background: #fee2e2;
        color: #dc2626;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }
</style>

<!-- Header -->
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title"><i class="bi bi-trash"></i> Arkib Komponen</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.components.index') }}">Komponen</a></li>
                    <li class="breadcrumb-item active">Arkib</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.components.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>



<!-- Info Alert -->
<div class="alert alert-warning d-flex align-items-center mb-4" role="alert">
    <i class="bi bi-info-circle fs-4 me-3"></i>
    <div>
        <strong>Komponen Dipadam</strong><br>
        <small>Komponen di sini telah dipadam tetapi masih boleh dipulihkan. Untuk padam kekal, klik butang "Padam Kekal".</small>
    </div>
</div>

<!-- Filter -->
<div class="filter-card">
    <form action="{{ route('admin.components.trashed') }}" method="GET" class="row g-3">
        <div class="col-md-9">
            <label class="form-label">Cari Komponen Dipadam</label>
            <input type="text" name="search" class="form-control" 
                   placeholder="Nama premis, DPA..." 
                   value="{{ request('search') }}">
        </div>
        <div class="col-md-3 d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-primary flex-fill">
                <i class="bi bi-search"></i> Cari
            </button>
            <a href="{{ route('admin.components.trashed') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-clockwise"></i>
            </a>
        </div>
    </form>
</div>

<!-- Trashed Components Table -->
@if($components->count() > 0)
<div class="table-container">
    <table class="table data-table">
        <thead>
            <tr>
                <th width="10%">No. DPA</th>
                <th width="30%">Nama Premis / Lokasi</th>
                <th width="18%">Dicipta Oleh</th>
                <th width="12%">Tarikh Dicipta</th>
                <th width="12%">Tarikh Dipadam</th>
                <th width="8%">Status</th>
                <th width="10%" class="text-end">Tindakan</th>
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
                        <small class="text-danger fw-semibold">
                            <div><i class="bi bi-trash"></i> {{ $component->deleted_at->format('d/m/Y') }}</div>
                            <div>{{ $component->deleted_at->format('h:i A') }}</div>
                            <div class="text-muted">({{ $component->deleted_at->diffForHumans() }})</div>
                        </small>
                    </td>
                    <td>
                        <span class="deleted-badge">
                            <i class="bi bi-trash"></i> Dipadam
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1 justify-content-end">
                            <form action="{{ route('admin.components.restore', $component->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" 
                                        class="btn btn-success btn-sm btn-icon" 
                                        title="Pulihkan"
                                        onclick="return confirm('Pulihkan komponen ini?')">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </button>
                            </form>
                            <button type="button" 
                                    class="btn btn-danger btn-sm btn-icon" 
                                    onclick="forceDeleteComponent({{ $component->id }})" 
                                    title="Padam Kekal">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                            <form id="force-delete-form-{{ $component->id }}" 
                                  action="{{ route('admin.components.force-delete', $component->id) }}" 
                                  method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
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
            daripada {{ $components->total() }} komponen dipadam
        </small>
    </div>
@endif

@else
<!-- Empty State -->
<div class="empty-state">
    <div class="empty-icon">
        <i class="bi bi-trash"></i>
    </div>
    <h5>Tiada Komponen Dipadam</h5>
    <p class="text-muted mb-3">Arkib adalah kosong. Tiada komponen yang telah dipadam.</p>
    <a href="{{ route('admin.components.index') }}" class="btn btn-primary">
        <i class="bi bi-arrow-left"></i> Kembali ke Senarai Komponen
    </a>
</div>
@endif

@endsection

@section('scripts')
<script>
function forceDeleteComponent(componentId) {
    if (confirm('⚠️ AMARAN: Padam Kekal\n\nAdakah anda pasti ingin memadam komponen ini secara KEKAL?\n\nTindakan ini TIDAK BOLEH dikembalikan!')) {
        if (confirm('Pengesahan terakhir: Komponen akan dipadam KEKAL dari sistem. Teruskan?')) {
            document.getElementById('force-delete-form-' + componentId).submit();
        }
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