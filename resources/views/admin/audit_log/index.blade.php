@extends('layouts.app')

@section('title', 'Audit Log')

@section('content')
<div class="container-fluid">

    {{-- Page Header --}}
    <div class="page-header mb-3">
        <div class="page-header-left">
            <h1 class="page-title" style="font-size: 1.5rem; font-weight: 800; display: flex; align-items: center; gap: 0.5rem; color: #1e293b;">
                <i class="bi bi-clock-history text-primary"></i> Audit Log
            </h1>
            <div class="text-muted" style="font-size: 0.85rem; margin-top: 2px;">Rekod aktiviti pengguna dalam sistem</div>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <!-- Cipta -->
        <div class="col-6 col-md-3">
            <div class="stat-card card-hover-lift">
                <div class="stat-accent" style="background:#10b981;"></div>
                <div class="stat-body d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Cipta</div>
                        <div class="stat-value">{{ $ciptaLogs ?? 0 }}</div>
                        <div class="stat-sub">Rekod ditambah</div>
                    </div>
                    <div class="stat-icon" style="background:rgba(16,185,129,0.1);color:#10b981;">
                        <i class="bi bi-plus-circle-fill"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kemaskini -->
        <div class="col-6 col-md-3">
            <div class="stat-card card-hover-lift">
                <div class="stat-accent" style="background:#06b6d4;"></div>
                <div class="stat-body d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Kemaskini</div>
                        <div class="stat-value">{{ $kemaskiniLogs ?? 0 }}</div>
                        <div class="stat-sub">Rekod dikemaskini</div>
                    </div>
                    <div class="stat-icon" style="background:rgba(6,182,212,0.1);color:#06b6d4;">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Padam -->
        <div class="col-6 col-md-3">
            <div class="stat-card card-hover-lift">
                <div class="stat-accent" style="background:#ef4444;"></div>
                <div class="stat-body d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Padam</div>
                        <div class="stat-value">{{ $padamLogs ?? 0 }}</div>
                        <div class="stat-sub">Rekod dipadam</div>
                    </div>
                    <div class="stat-icon" style="background:rgba(239,68,68,0.1);color:#ef4444;">
                        <i class="bi bi-trash-fill"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Eksport -->
        <div class="col-6 col-md-3">
            <div class="stat-card card-hover-lift">
                <div class="stat-accent" style="background:#64748b;"></div>
                <div class="stat-body d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Eksport</div>
                        <div class="stat-value">{{ $eksportLogs ?? 0 }}</div>
                        <div class="stat-sub">Laporan dieksport</div>
                    </div>
                    <div class="stat-icon" style="background:rgba(100,116,139,0.1);color:#64748b;">
                        <i class="bi bi-download"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="filter-panel">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center gap-2" style="font-size: 0.95rem; font-weight: 700; color: #1e293b;">
                <i class="bi bi-funnel text-primary" style="font-size: 1.1rem;"></i> Penapis Carian
            </div>
            <a href="{{ route('admin.audit_log.index') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1" style="border-radius: 6px; padding: 0.25rem 0.75rem; font-size: 0.8rem; font-weight: 500; border-color: #d1d5db; color: #4b5563; background: white;">
                <i class="bi bi-arrow-counterclockwise"></i> Reset
            </a>
        </div>
        <form action="{{ route('admin.audit_log.index') }}" method="GET">
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Pengguna</label>
                    <select name="user_id" class="form-select select2-filter">
                        <option value="">Semua Pengguna</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->username }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tajuk Log</label>
                    <input type="text" name="title" class="form-control" placeholder="Cari tajuk log..."
                        value="{{ request('title') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Komponen</label>
                    <select name="component_id" class="form-select select2-filter">
                        <option value="">Semua Komponen</option>
                        @foreach($components as $component)
                        <option value="{{ $component->id }}" {{ request('component_id') == $component->id ? 'selected' : '' }}>
                            {{ $component->nama_premis }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tarikh Mula</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tarikh Tamat</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100" style="height: 38px; border-radius: 8px;">
                        <i class="bi bi-funnel-fill"></i> Tapis
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Log Table --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-700">
                <i class="bi bi-list-ul text-primary me-2"></i>Senarai Log
            </h6>
            <span class="badge" style="background:rgba(37,99,235,0.1);color:#2563eb;">
                {{ $logs->total() }} Rekod
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="50">#</th>
                            <th>Pengguna</th>
                            <th>Tajuk</th>
                            <th>Keterangan</th>
                            <th>Komponen</th>
                            <th>Tarikh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td>
                                <span style="font-size:0.78rem;color:var(--text-secondary);font-weight:600;">
                                    {{ ($logs->currentPage() - 1) * $logs->perPage() + $loop->iteration }}
                                </span>
                            </td>
                            <td>
                                @if($log->user)
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-initials" style="width:30px;height:30px;font-size:0.65rem;border-radius:8px;flex-shrink:0;">
                                        {{ strtoupper(substr($log->user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="fw-600" style="font-size:0.85rem;">{{ $log->user->name }}</div>
                                        <div class="text-muted" style="font-size:0.72rem;">{{ $log->user->username }}</div>
                                    </div>
                                </div>
                                @else
                                <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="fw-600" style="font-size:0.88rem;">{{ $log->title }}</span>
                            </td>
                            <td>
                                <span class="text-muted" style="font-size:0.83rem;">
                                    {{ Str::limit($log->description, 60) }}
                                </span>
                            </td>
                            <td>
                                @if($log->component)
                                <span class="badge" style="background:rgba(6,182,212,0.1);color:#0891b2;font-weight:600;">
                                    {{ Str::limit($log->component->nama_premis, 25) }}
                                </span>
                                @else
                                <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <div style="font-size:0.82rem;font-weight:600;">{{ $log->created_at->format('d/m/Y') }}</div>
                                <div class="text-muted" style="font-size:0.72rem;">{{ $log->created_at->format('H:i') }}</div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-state-icon"><i class="bi bi-journal-x"></i></div>
                                    <h6>Tiada Log Dijumpai</h6>
                                    <p>Cuba ubah penapis untuk melihat lebih banyak rekod</p>
                                    <a href="{{ route('admin.audit_log.index') }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-arrow-counterclockwise"></i> Reset Penapis
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($logs->hasPages())
        <div class="card-footer bg-transparent">
            {{ $logs->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('.select2-filter').select2({
        theme: 'bootstrap-5',
        width: '100%'
    });
});
</script>
@endsection