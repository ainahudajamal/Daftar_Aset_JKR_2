{{-- resources/views/admin/components/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Butiran Komponen')

@section('content')
<style>
    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .detail-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .detail-card h5 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e2e8f0;
    }

    .detail-row {
        display: flex;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        width: 200px;
        color: #64748b;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .detail-value {
        flex: 1;
        color: #1e293b;
        font-weight: 600;
    }

    .user-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .user-avatar-large {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        font-weight: 600;
        margin: 0 auto 1rem;
    }

    .action-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
    }

    .action-card h5 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e2e8f0;
    }
</style>

<!-- Header -->
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">Butiran Komponen</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.components.index') }}">Komponen</a></li>
                    <li class="breadcrumb-item active">{{ $component->nombor_dpa }}</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.components.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>



<div class="row">
    <!-- Main Content -->
    <div class="col-lg-8">
        <!-- Basic Info -->
        <div class="detail-card">
            <h5><i class="bi bi-info-circle"></i> Maklumat Asas</h5>
            
            <div class="detail-row">
                <div class="detail-label">Nombor DPA:</div>
                <div class="detail-value">
                    <span class="badge bg-secondary fs-6">{{ $component->nombor_dpa }}</span>
                </div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Nama Premis:</div>
                <div class="detail-value">{{ $component->nama_premis }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Status:</div>
                <div class="detail-value">
                    <span class="badge {{ $component->status === 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                        <i class="bi bi-{{ $component->status === 'aktif' ? 'check' : 'x' }}-circle"></i>
                        {{ ucwords(str_replace('_', ' ', $component->status)) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Blok Info -->
        @if($component->ada_blok)
        <div class="detail-card">
            <h5><i class="bi bi-building"></i> Maklumat Blok</h5>
            
            <div class="detail-row">
                <div class="detail-label">Kod Blok:</div>
                <div class="detail-value">{{ $component->kod_blok ?? '-' }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Nama Blok:</div>
                <div class="detail-value">{{ $component->nama_blok ?? '-' }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Kod Aras:</div>
                <div class="detail-value">{{ $component->kod_aras ?? '-' }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Nama Aras:</div>
                <div class="detail-value">{{ $component->nama_aras ?? '-' }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Kod Ruang:</div>
                <div class="detail-value">{{ $component->kod_ruang ?? '-' }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Nama Ruang:</div>
                <div class="detail-value">{{ $component->nama_ruang ?? '-' }}</div>
            </div>
            
            @if($component->catatan_blok)
            <div class="detail-row">
                <div class="detail-label">Catatan:</div>
                <div class="detail-value">{{ $component->catatan_blok }}</div>
            </div>
            @endif
        </div>
        @endif

        <!-- Binaan Luar Info -->
        @if($component->ada_binaan_luar)
        <div class="detail-card">
            <h5><i class="bi bi-house"></i> Maklumat Binaan Luar</h5>
            
            <div class="detail-row">
                <div class="detail-label">Kod Binaan Luar:</div>
                <div class="detail-value">{{ $component->kod_binaan_luar ?? '-' }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Nama Binaan Luar:</div>
                <div class="detail-value">{{ $component->nama_binaan_luar ?? '-' }}</div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Koordinat GPS:</div>
                <div class="detail-value">
                    @if($component->koordinat_x && $component->koordinat_y)
                        X: {{ $component->koordinat_x }}, Y: {{ $component->koordinat_y }}
                    @else
                        -
                    @endif
                </div>
            </div>
            
            @if($component->catatan_binaan)
            <div class="detail-row">
                <div class="detail-label">Catatan:</div>
                <div class="detail-value">{{ $component->catatan_binaan }}</div>
            </div>
            @endif
        </div>
        @endif

        <!-- Dimensi -->
        @if($component->dimensi_string)
        <div class="detail-card">
            <h5><i class="bi bi-rulers"></i> Dimensi</h5>
            
            <div class="detail-row">
                <div class="detail-label">Panjang × Lebar × Tinggi:</div>
                <div class="detail-value">{{ $component->dimensi_string }}</div>
            </div>
            
            @if($component->volum)
            <div class="detail-row">
                <div class="detail-label">Volum:</div>
                <div class="detail-value">{{ number_format($component->volum, 2) }} {{ $component->unit_ukuran }}³</div>
            </div>
            @endif
        </div>
        @endif

        <!-- Main Components -->
        @if($component->mainComponents->count() > 0)
        <div class="detail-card">
            <h5><i class="bi bi-layers"></i> Komponen Utama ({{ $component->mainComponents->count() }})</h5>
            
            <div class="list-group list-group-flush">
                @foreach($component->mainComponents as $mainComponent)
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $mainComponent->nama_komponen_utama }}</strong>
                            @if($mainComponent->jenama || $mainComponent->model)
                                <br><small class="text-muted">
                                    {{ $mainComponent->jenama }} {{ $mainComponent->model }}
                                </small>
                            @endif
                            @if($mainComponent->subComponents->count() > 0)
                                <br><small class="text-info">
                                    <i class="bi bi-diagram-3"></i> {{ $mainComponent->subComponents->count() }} sub komponen
                                </small>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Timestamp -->
        <div class="detail-card">
            <h5><i class="bi bi-clock-history"></i> Maklumat Tarikh</h5>
            
            <div class="detail-row">
                <div class="detail-label">Tarikh Dicipta:</div>
                <div class="detail-value">
                    {{ $component->created_at->format('d/m/Y h:i A') }}
                    <small class="text-muted">({{ $component->created_at->diffForHumans() }})</small>
                </div>
            </div>
            
            <div class="detail-row">
                <div class="detail-label">Tarikh Dikemaskini:</div>
                <div class="detail-value">
                    {{ $component->updated_at->format('d/m/Y h:i A') }}
                    <small class="text-muted">({{ $component->updated_at->diffForHumans() }})</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- User Info -->
        @if($component->user)
        <div class="user-card">
            <div class="user-avatar-large">
                {{ strtoupper(substr($component->user->name, 0, 1)) }}
            </div>
            
            <h5 class="mb-1">{{ $component->user->name }}</h5>
            <p class="text-muted mb-2">{{ $component->user->email }}</p>
            
            <div class="row g-2 mb-3">
                <div class="col-6">
                    <div class="p-2 bg-light rounded">
                        <small class="text-muted d-block">User ID</small>
                        <strong class="text-primary">{{ $component->user->id }}</strong>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-2 bg-light rounded">
                        <small class="text-muted d-block">Username</small>
                        <strong class="text-primary">{{ $component->user->username ?? '-' }}</strong>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-2 bg-light rounded">
                        <small class="text-muted d-block">Role</small>
                        <span class="badge bg-{{ $component->user->role === 'admin' ? 'danger' : 'info' }}">
                            {{ ucfirst($component->user->role) }}
                        </span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-2 bg-light rounded">
                        <small class="text-muted d-block">Status</small>
                        <span class="badge bg-{{ $component->user->is_active ? 'success' : 'secondary' }}">
                            {{ $component->user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </div>
                </div>
            </div>
            
            <hr>
            
            <div class="text-start small">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted"><i class="bi bi-box"></i> Jumlah Komponen:</span>
                    <strong>{{ $component->user->components->count() }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted"><i class="bi bi-calendar"></i> Tarikh Daftar:</span>
                    <strong>{{ $component->user->created_at->format('d/m/Y') }}</strong>
                </div>
            </div>
        </div>
        @else
        <div class="user-card border-danger">
            <i class="bi bi-person-x fs-1 text-muted mb-3"></i>
            <p class="text-muted mb-0">Pengguna telah dihapus</p>
        </div>
        @endif

        <!-- Actions -->
        <div class="action-card">
            <h5><i class="bi bi-gear"></i> Tindakan</h5>
            
            <div class="d-grid gap-2">
                <form action="{{ route('admin.components.toggle-status', $component) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn {{ $component->status === 'aktif' ? 'btn-warning' : 'btn-success' }} w-100">
                        <i class="bi bi-toggle-{{ $component->status === 'aktif' ? 'off' : 'on' }}"></i>
                        {{ $component->status === 'aktif' ? 'Nyahaktifkan' : 'Aktifkan' }}
                    </button>
                </form>
                
                <button type="button" class="btn btn-danger w-100" onclick="deleteComponent({{ $component->id }})">
                    <i class="bi bi-trash"></i> Padam Komponen
                </button>
                <form id="delete-form-{{ $component->id }}" 
                      action="{{ route('admin.components.destroy', $component) }}" 
                      method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                </form>
                
                <hr>
                
            </div>
        </div>
    </div>
</div>

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