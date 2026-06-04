@extends('layouts.app')

@section('title', 'Butiran Log')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Header -->
            <div class="mb-4">
                <h2 class="mb-1"><i class="bi bi-journal-text"></i> Butiran Log</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.audit_log.index') }}">Audit Log</a></li>
                        <li class="breadcrumb-item active">Butiran</li>
                    </ol>
                </nav>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-info-circle"></i> Maklumat Log</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <td width="30%" class="fw-semibold">Pengguna</td>
                            <td>{{ $auditLog->user->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Tajuk</td>
                            <td>{{ $auditLog->title }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Keterangan</td>
                            <td>{{ $auditLog->description ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Komponen</td>
                            <td>{{ $auditLog->component_id ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Tarikh Dibuat</td>
                            <td>{{ $auditLog->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Tarikh Dikemaskini</td>
                            <td>{{ $auditLog->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.audit_log.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <button type="button" class="btn btn-danger" onclick="deleteLog({{ $auditLog->id }})">
                    <i class="bi bi-trash"></i> Padam
                </button>
            </div>

            <form id="delete-form-{{ $auditLog->id }}" action="{{ route('admin.audit_log.destroy', $auditLog) }}" method="POST" class="d-none">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function deleteLog(logId) {
    if (confirm('Adakah anda pasti ingin memadam log ini?')) {
        document.getElementById('delete-form-' + logId).submit();
    }
}
</script>
@endsection