@extends('layouts.app')

@section('title', 'Pengurusan Pengguna')

@section('content')
<div class="container-fluid">

    {{-- Page Header --}}
    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-title"><i class="bi bi-people-fill"></i> Pengurusan Pengguna</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Pengguna</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus-fill"></i> Tambah Pengguna
        </a>
    </div>

    {{-- Filters --}}
    <div class="filter-panel">
        <div class="filter-panel-title">
            <i class="bi bi-funnel-fill"></i> Tapis Pengguna
        </div>
        <form action="{{ route('admin.users.index') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Cari</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Nama, username atau email"
                            value="{{ request('search') }}" style="border-left:none;">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary" title="Reset">
                        <i class="bi bi-x-circle"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Users Table --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-700">
                <i class="bi bi-list-ul text-primary me-2"></i>Senarai Pengguna
            </h6>
            <span class="badge" style="background:rgba(37,99,235,0.1);color:#2563eb;">
                {{ $users->total() }} Pengguna
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Pengguna</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Jabatan</th>
                            <th>Status</th>
                            <th>Login Terakhir</th>
                            <th class="text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-initials" style="flex-shrink:0;">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="fw-600" style="font-size:0.88rem;">{{ $user->name }}</div>
                                        @if($user->phone)
                                        <small class="text-muted"><i class="bi bi-telephone"></i> {{ $user->phone }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td><code class="text-primary" style="font-size:0.82rem;">{{ $user->username }}</code></td>
                            <td style="font-size:0.83rem;">{{ $user->email }}</td>
                            <td>
                                @if($user->role === 'admin')
                                <span class="badge badge-role-admin">Admin</span>
                                @else
                                <span class="badge badge-role-user">User</span>
                                @endif
                            </td>
                            <td style="font-size:0.83rem;">{{ $user->department ?? '—' }}</td>
                            <td>
                                @if($user->is_active)
                                <span class="badge badge-status-active">Aktif</span>
                                @else
                                <span class="badge badge-status-inactive">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                @if($user->last_login_at)
                                <div style="font-size:0.8rem;font-weight:600;">{{ $user->last_login_at->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $user->last_login_at->diffForHumans() }}</small>
                                @else
                                <small class="text-muted">Belum login</small>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-warning"
                                        data-id="{{ $user->id }}"
                                        onclick="toggleStatus(this.dataset.id)"
                                        title="{{ $user->is_active ? 'Nyahaktifkan' : 'Aktifkan' }}"
                                        {{ $user->id === Auth::id() ? 'disabled' : '' }}>
                                        <i class="bi bi-toggle-{{ $user->is_active ? 'on' : 'off' }}"></i>
                                    </button>
                                    <a href="{{ route('admin.users.reset-password', $user) }}"
                                        class="btn btn-sm btn-outline-info" title="Reset Password">
                                        <i class="bi bi-key-fill"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                        data-id="{{ $user->id }}"
                                        onclick="deleteUser(this.dataset.id)"
                                        {{ $user->id === Auth::id() ? 'disabled' : '' }}
                                        title="Padam">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </div>

                                <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <form id="toggle-form-{{ $user->id }}" action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <div class="empty-state-icon"><i class="bi bi-person-x"></i></div>
                                    <h6>Tiada Pengguna Dijumpai</h6>
                                    <p>Cuba ubah penapis atau tambah pengguna baru</p>
                                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-person-plus-fill"></i> Tambah Pengguna
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($users->hasPages())
        <div class="card-footer bg-transparent">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
function deleteUser(userId) {
    if (confirm('Adakah anda pasti ingin memadam pengguna ini?')) {
        document.getElementById('delete-form-' + userId).submit();
    }
}
function toggleStatus(userId) {
    if (confirm('Adakah anda pasti ingin mengubah status pengguna ini?')) {
        document.getElementById('toggle-form-' + userId).submit();
    }
}
</script>
@endsection