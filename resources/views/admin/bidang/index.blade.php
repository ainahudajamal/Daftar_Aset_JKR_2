@extends('layouts.app')

@section('title', 'Pendaftaran Kod Bidang')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="bi bi-journal-bookmark"></i> Pendaftaran Kod Bidang</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Bidang</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.bidang.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Kod Bidang
        </a>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.bidang.index') }}" method="GET" class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Cari Bidang</label>
                    <input type="text" name="search" class="form-control" placeholder="Kod atau nama bidang" value="{{ request('search') }}">
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

    <!-- Bidang Table / Cards -->
    <div class="row g-4">
        @forelse($bidangs as $bidang)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="mb-1">{{ $bidang->kod }}</h5>
                            <p class="text-muted mb-0 small">{{ $bidang->nama }}</p>
                        </div>
                        @if($bidang->is_active)
                        <span class="badge bg-success">Aktif</span>
                        @else
                        <span class="badge bg-secondary">Tidak Aktif</span>
                        @endif
                    </div>

                    @if($bidang->keterangan)
                    <p class="small text-muted border-start border-3 border-primary ps-2 mb-4 flex-grow-1">
                        {{ Str::limit($bidang->keterangan, 150) }}
                    </p>
                    @else
                    <div class="flex-grow-1"></div>
                    @endif

                    <div class="d-flex gap-2 mt-auto pt-3 border-top">
                        <a href="{{ route('admin.bidang.edit', $bidang) }}" class="btn btn-sm btn-warning flex-fill">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteBidang({{ $bidang->id }})">
                            <i class="bi bi-trash"></i> Padam
                        </button>
                    </div>

                    <form id="delete-form-{{ $bidang->id }}" action="{{ route('admin.bidang.destroy', $bidang) }}" method="POST" class="d-none">
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
                    <p class="text-muted mb-3">Tiada kod bidang dijumpai</p>
                    <a href="{{ route('admin.bidang.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Kod Bidang Pertama
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    @if($bidangs->hasPages())
    <div class="mt-4">
        {{ $bidangs->links() }}
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
function deleteBidang(bidangId) {
    if (confirm('Adakah anda pasti ingin memadam kod bidang ini?')) {
        document.getElementById('delete-form-' + bidangId).submit();
    }
}
</script>
@endsection
