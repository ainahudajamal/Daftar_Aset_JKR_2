@extends('layouts.app')

@section('title', 'Audit Log')

@section('content')
<div class="container-fluid">

    {{-- Page Header --}}
    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-title"><i class="bi bi-journal-text"></i> Audit Log</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Audit Log</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Filters --}}
    <div class="filter-panel">
        <div class="filter-panel-title">
            <i class="bi bi-funnel-fill"></i> Tapis Rekod
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
                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="bi bi-funnel-fill"></i> Tapis
                    </button>
                    <a href="{{ route('admin.audit_log.index') }}" class="btn btn-outline-secondary flex-fill">
                        <i class="bi bi-x-circle"></i> Reset
                    </a>
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