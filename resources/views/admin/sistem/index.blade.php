@extends('layouts.app')

@section('title', 'Pengurusan Sistem')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="bi bi-diagram-3"></i> Pengurusan Sistem</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Sistem</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.sistem.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Sistem
        </a>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.sistem.index') }}" method="GET" class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Cari Sistem</label>
                    <input type="text" name="search" class="form-control" placeholder="Kod atau nama sistem" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Sistem Table -->
    <div class="row g-4">
        @forelse($sistems as $sistem)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="mb-1">{{ $sistem->kod }}</h5>
                            <p class="text-muted mb-0 small">{{ $sistem->nama }}</p>
                        </div>
                        @if($sistem->is_active)
                        <span class="badge bg-success">Aktif</span>
                        @else
                        <span class="badge bg-secondary">Tidak Aktif</span>
                        @endif
                    </div>

                    @if($sistem->keterangan)
                    <p class="small text-muted border-start border-3 border-primary ps-2 mb-3">
                        {{ Str::limit($sistem->keterangan, 100) }}
                    </p>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <i class="bi bi-diagram-2 text-primary"></i>
                            <span class="fw-semibold">{{ $sistem->subsistems_count }}</span> Subsistem
                        </div>
                        <a href="{{ route('admin.sistem.subsistems', $sistem) }}" class="btn btn-sm btn-outline-primary">
                            Lihat Subsistem
                        </a>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.sistem.edit', $sistem) }}" class="btn btn-sm btn-warning flex-fill">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteSistem({{ $sistem->id }})">
                            <i class="bi bi-trash"></i> Padam
                        </button>
                    </div>

                    <form id="delete-form-{{ $sistem->id }}" action="{{ route('admin.sistem.destroy', $sistem) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                    <p class="text-muted mb-3">Tiada sistem dijumpai</p>
                    <a href="{{ route('admin.sistem.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Sistem Pertama
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    @if($sistems->hasPages())
    <div class="mt-4">
        {{ $sistems->links() }}
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
function deleteSistem(sistemId) {
    if (confirm('Adakah anda pasti ingin memadam sistem ini?\n\nNota: Sistem tidak boleh dipadam jika masih mempunyai subsistem.')) {
        document.getElementById('delete-form-' + sistemId).submit();
    }
}
</script>
@endsection