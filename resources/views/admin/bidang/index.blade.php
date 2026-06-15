@extends('layouts.app')

@section('title', 'Pendaftaran Kod Bidang')

@section('content')
<div class="container-fluid">

    {{-- Page Header --}}
    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-title"><i class="bi bi-tags-fill"></i> Pendaftaran Kod Bidang</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Kod Bidang</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.bidang.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle-fill"></i> Tambah Kod Bidang
        </a>
    </div>

    {{-- Filters --}}
    <div class="filter-panel">
        <div class="filter-panel-title">
            <i class="bi bi-funnel-fill"></i> Tapis Bidang
        </div>
        <form action="{{ route('admin.bidang.index') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-7">
                    <label class="form-label">Cari Bidang</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Kod atau nama bidang"
                            value="{{ request('search') }}" style="border-left:none;">
                    </div>
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
                    <a href="{{ route('admin.bidang.index') }}" class="btn btn-outline-secondary" title="Reset">
                        <i class="bi bi-x-circle"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Bidang Cards --}}
    @if($bidangs->isEmpty())
    <div class="card">
        <div class="card-body">
            <div class="empty-state">
                <div class="empty-state-icon"><i class="bi bi-tags"></i></div>
                <h6>Tiada Kod Bidang Dijumpai</h6>
                <p>Cuba ubah penapis atau tambah kod bidang pertama anda</p>
                <a href="{{ route('admin.bidang.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle-fill"></i> Tambah Kod Bidang Pertama
                </a>
            </div>
        </div>
    </div>
    @else
    <div class="row g-3">
        @foreach($bidangs as $bidang)
        <div class="col-md-6 col-lg-4">
            <div class="card card-hover-lift h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#2563eb,#1d4ed8);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="bi bi-tag-fill text-white" style="font-size:1.1rem;"></i>
                            </div>
                            <div>
                                <div class="fw-700" style="font-size:1rem;">{{ $bidang->kod }}</div>
                                <div class="text-muted" style="font-size:0.8rem;">{{ Str::limit($bidang->nama, 30) }}</div>
                            </div>
                        </div>
                        @if($bidang->is_active)
                        <span class="badge badge-status-active">Aktif</span>
                        @else
                        <span class="badge badge-status-inactive">Tidak Aktif</span>
                        @endif
                    </div>

                    @if($bidang->keterangan)
                    <p class="small text-muted flex-grow-1 mb-3"
                        style="border-left:3px solid var(--primary);padding-left:0.75rem;line-height:1.6;">
                        {{ Str::limit($bidang->keterangan, 120) }}
                    </p>
                    @else
                    <div class="flex-grow-1"></div>
                    @endif

                    <div class="d-flex gap-2 mt-auto pt-3" style="border-top:1px solid var(--border-color);">
                        <a href="{{ route('admin.bidang.edit', $bidang) }}" class="btn btn-sm btn-outline-primary flex-fill">
                            <i class="bi bi-pencil-fill"></i> Edit
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteBidang({{ $bidang->id }})">
                            <i class="bi bi-trash-fill"></i> Padam
                        </button>
                    </div>

                    <form id="delete-form-{{ $bidang->id }}" action="{{ route('admin.bidang.destroy', $bidang) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($bidangs->hasPages())
    <div class="mt-4">
        {{ $bidangs->links('pagination::bootstrap-5') }}
    </div>
    @endif
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
