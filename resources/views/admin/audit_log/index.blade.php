@extends('layouts.app')

@section('title', 'Audit Log')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="bi bi-journal-text"></i> Audit Log</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Audit Log</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.audit_log.index') }}" method="GET" class="row g-3">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Pengguna</label>
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
                    <label class="form-label fw-semibold text-secondary">Tajuk</label>
                    <input type="text" name="title" class="form-control" placeholder="Cari tajuk log..."
                        value="{{ request('title') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Komponen</label>
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
                    <label class="form-label fw-semibold text-secondary">Tarikh Mula</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary">Tarikh Tamat</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel"></i> Tapis
                    </button>
                    <a href="{{ route('admin.audit_log.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Log Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
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
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $log->user->name ?? '-' }}</td>
                            <td>{{ $log->title }}</td>
                            <td>{{ Str::limit($log->description, 50) }}</td>
                            <td>{{ $log->component->nama_premis ?? '-' }}</td>
                            <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                Tiada log dijumpai
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($logs->hasPages())
            <div class="mt-3">
                {{ $logs->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>
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

function deleteLog(logId) {
    if (confirm('Adakah anda pasti ingin memadam log ini?')) {
        document.getElementById('delete-form-' + logId).submit();
    }
}
</script>
@endsection