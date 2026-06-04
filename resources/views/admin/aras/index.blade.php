@extends('layouts.app')

@section('title', 'Pengurusan Aras')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="bi bi-layers"></i> Konfigurasi Aras</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Aras</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.aras.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Aras
        </a>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.aras.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Cari Aras</label>
                    <input type="text" name="search" class="form-control" placeholder="Kod atau nama aras" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Blok</label>
                    <select name="blok_id" class="form-select">
                        <option value="">Semua Blok</option>
                        @foreach($bloks as $blok)
                        <option value="{{ $blok->id }}" {{ request('blok_id') == $blok->id ? 'selected' : '' }}>
                            {{ $blok->kod }} - {{ $blok->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    <a href="{{ route('admin.aras.index') }}" class="btn btn-secondary w-100">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                        </a>
                </div>
            </form>
        </div>
    </div>


     
    <!-- Aras Table -->
    <div class="row g-4">
        @forelse($aras as $item)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="mb-1">{{ $item->kod }}</h5>
                            <p class="text-muted mb-0 small">{{ $item->nama }}</p>
                        </div>
                        @if($item->is_active)
                        <span class="badge bg-success">Aktif</span>
                        @else
                        <span class="badge bg-secondary">Tidak Aktif</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <span class="badge bg-primary">
                            <i class="bi bi-building"></i>
                            {{ $item->blok ? $item->blok->kod . ' - ' . $item->blok->nama : 'Tiada Blok' }}
                        </span>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.aras.edit', $item) }}" class="btn btn-sm btn-warning flex-fill">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteAras({{ $item->id }})">
                            <i class="bi bi-trash"></i> Padam
                        </button>
                    </div>

                    <form id="delete-form-{{ $item->id }}" action="{{ route('admin.aras.destroy', $item) }}" method="POST" class="d-none">
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
                    <p class="text-muted mb-3">Tiada aras dijumpai</p>
                    <a href="{{ route('admin.aras.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Aras Pertama
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    @if($aras->hasPages())
    <div class="mt-4">
        {{ $aras->links() }}
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
function deleteAras(arasId) {
    if (confirm('Adakah anda pasti ingin memadam aras ini?')) {
        document.getElementById('delete-form-' + arasId).submit();
    }
}
</script>
@endsection