@extends('layouts.app')

@section('title', 'Konfigurasi Aras dan Ruang')

@section('content')
<div class="container-fluid">

    {{-- ===== PAGE HEADER ===== --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2 class="mb-1 fw-bold">
                <i class="bi bi-layers-half me-2 text-primary"></i>Konfigurasi Aras dan Ruang
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Konfigurasi Aras dan Ruang</li>
                </ol>
            </nav>
        </div>
        {{-- Dynamic Add button changes based on active tab --}}
        <div id="headerButtons">
            <button class="btn btn-primary" id="btnTambahAras" data-bs-toggle="modal" data-bs-target="#modalTambahAras">
                <i class="bi bi-plus-circle me-1"></i> Tambah Aras
            </button>
            <button class="btn btn-success d-none" id="btnTambahRuang" data-bs-toggle="modal" data-bs-target="#modalTambahRuang">
                <i class="bi bi-plus-circle me-1"></i> Tambah Ruang
            </button>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- ===== TAB NAVIGATION ===== --}}
    <div class="card border-0 shadow-sm mb-0">
        <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
            <ul class="nav nav-tabs card-header-tabs" id="arasRuangTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab === 'ruang' ? '' : 'active' }} fw-semibold px-4 py-2"
                        id="aras-tab" data-bs-toggle="tab" data-bs-target="#aras-panel" type="button" role="tab"
                        aria-controls="aras-panel" aria-selected="{{ $activeTab !== 'ruang' ? 'true' : 'false' }}">
                        <i class="bi bi-layers me-2 text-primary"></i>Aras
                        <span class="badge bg-primary ms-2">{{ $arasPaginated->total() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab === 'ruang' ? 'active' : '' }} fw-semibold px-4 py-2"
                        id="ruang-tab" data-bs-toggle="tab" data-bs-target="#ruang-panel" type="button" role="tab"
                        aria-controls="ruang-panel" aria-selected="{{ $activeTab === 'ruang' ? 'true' : 'false' }}">
                        <i class="bi bi-door-open me-2 text-success"></i>Ruang
                        <span class="badge bg-success ms-2">{{ $ruangsPaginated->total() }}</span>
                    </button>
                </li>
            </ul>
        </div>

        <div class="tab-content" id="arasRuangTabContent">

            {{-- ============================================================
                 TAB 1: ARAS
            ============================================================ --}}
            <div class="tab-pane fade {{ $activeTab === 'ruang' ? '' : 'show active' }}"
                id="aras-panel" role="tabpanel" aria-labelledby="aras-tab">

                <div class="card-body">
                    {{-- Filter Form --}}
                    <form action="{{ route('admin.aras-ruang.index') }}" method="GET" class="row g-3 mb-4" id="arasFilterForm">
                        <input type="hidden" name="tab" value="aras">
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-semibold">CARI ARAS</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="text" name="aras_search" class="form-control border-start-0 ps-0"
                                    placeholder="Kod atau nama aras..."
                                    value="{{ request('aras_search') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-muted small fw-semibold">BLOK</label>
                            <select name="aras_blok_id" class="form-select">
                                <option value="">Semua Blok</option>
                                @foreach($bloks as $blok)
                                <option value="{{ $blok->id }}" {{ request('aras_blok_id') == $blok->id ? 'selected' : '' }}>
                                    {{ $blok->kod }} - {{ $blok->nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-muted small fw-semibold">STATUS</label>
                            <select name="aras_status" class="form-select">
                                <option value="">Semua</option>
                                <option value="active" {{ request('aras_status') === 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ request('aras_status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="bi bi-search me-1"></i> Cari
                            </button>
                            <a href="{{ route('admin.aras-ruang.index') }}" class="btn btn-outline-secondary flex-fill">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                            </a>
                        </div>
                    </form>

                    {{-- Aras Table --}}
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="arasTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" width="60">#</th>
                                    <th>Blok</th>
                                    <th>Kod Aras</th>
                                    <th>Nama Aras</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" width="140">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($arasPaginated as $index => $item)
                                <tr>
                                    <td class="text-center text-muted small">
                                        {{ ($arasPaginated->currentPage() - 1) * $arasPaginated->perPage() + $loop->iteration }}
                                    </td>
                                    <td>
                                        @if($item->blok)
                                        <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle fw-semibold">
                                            <i class="bi bi-building me-1"></i>{{ $item->blok->kod }}
                                        </span>
                                        <span class="text-muted ms-1 small">{{ $item->blok->nama }}</span>
                                        @else
                                        <span class="text-muted small fst-italic">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fw-bold font-monospace text-dark">{{ $item->kod }}</span>
                                    </td>
                                    <td>{{ $item->nama }}</td>
                                    <td class="text-center">
                                        @if($item->is_active)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3">
                                            <i class="bi bi-check-circle-fill me-1"></i>Aktif
                                        </span>
                                        @else
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3">
                                            <i class="bi bi-x-circle-fill me-1"></i>Tidak Aktif
                                        </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-warning me-1"
                                            onclick="editAras({{ $item->id }}, '{{ addslashes($item->blok_id) }}', '{{ addslashes($item->kod) }}', '{{ addslashes($item->nama) }}', {{ $item->is_active ? 'true' : 'false' }})"
                                            title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="deleteAras({{ $item->id }}, '{{ addslashes($item->nama) }}')"
                                            title="Padam">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                        <form id="delete-aras-{{ $item->id }}" action="{{ route('admin.aras.destroy', $item) }}" method="POST" class="d-none">
                                            @csrf @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                        Tiada rekod aras dijumpai
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Aras Pagination --}}
                    @if($arasPaginated->hasPages())
                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Menunjukkan {{ $arasPaginated->firstItem() }}–{{ $arasPaginated->lastItem() }}
                            daripada {{ $arasPaginated->total() }} rekod
                        </small>
                        <div>
                            {{ $arasPaginated->appends(['tab' => 'aras', 'aras_search' => request('aras_search'), 'aras_blok_id' => request('aras_blok_id'), 'aras_status' => request('aras_status')])->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- ============================================================
                 TAB 2: RUANG
            ============================================================ --}}
            <div class="tab-pane fade {{ $activeTab === 'ruang' ? 'show active' : '' }}"
                id="ruang-panel" role="tabpanel" aria-labelledby="ruang-tab">

                <div class="card-body">
                    {{-- Filter Form --}}
                    <form action="{{ route('admin.aras-ruang.index') }}" method="GET" class="row g-3 mb-4" id="ruangFilterForm">
                        <input type="hidden" name="tab" value="ruang">
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-semibold">CARI RUANG</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="text" name="ruang_search" class="form-control border-start-0 ps-0"
                                    placeholder="Kod atau nama ruang..."
                                    value="{{ request('ruang_search') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-muted small fw-semibold">ARAS</label>
                            <select name="ruang_aras_id" class="form-select">
                                <option value="">Semua Aras</option>
                                @foreach($arasAll as $arasItem)
                                <option value="{{ $arasItem->id }}" {{ request('ruang_aras_id') == $arasItem->id ? 'selected' : '' }}>
                                    {{ $arasItem->kod }} - {{ $arasItem->nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-muted small fw-semibold">STATUS</label>
                            <select name="ruang_status" class="form-select">
                                <option value="">Semua</option>
                                <option value="active" {{ request('ruang_status') === 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ request('ruang_status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-success flex-fill">
                                <i class="bi bi-search me-1"></i> Cari
                            </button>
                            <a href="{{ route('admin.aras-ruang.index') }}?tab=ruang" class="btn btn-outline-secondary flex-fill">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                            </a>
                        </div>
                    </form>

                    {{-- Ruang Table --}}
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="ruangTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" width="60">#</th>
                                    <th>Aras</th>
                                    <th>Kod Ruang</th>
                                    <th>Nama Ruang</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" width="140">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ruangsPaginated as $ruang)
                                <tr>
                                    <td class="text-center text-muted small">
                                        {{ ($ruangsPaginated->currentPage() - 1) * $ruangsPaginated->perPage() + $loop->iteration }}
                                    </td>
                                    <td>
                                        @if($ruang->aras)
                                        <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle fw-semibold">
                                            <i class="bi bi-layers me-1"></i>{{ $ruang->aras->kod }}
                                        </span>
                                        <span class="text-muted ms-1 small">{{ $ruang->aras->nama }}</span>
                                        @else
                                        <span class="text-muted small fst-italic">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fw-bold font-monospace text-dark">{{ $ruang->kod }}</span>
                                    </td>
                                    <td>{{ $ruang->nama }}</td>
                                    <td class="text-center">
                                        @if($ruang->is_active)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3">
                                            <i class="bi bi-check-circle-fill me-1"></i>Aktif
                                        </span>
                                        @else
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3">
                                            <i class="bi bi-x-circle-fill me-1"></i>Tidak Aktif
                                        </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-warning me-1"
                                            onclick="editRuang({{ $ruang->id }}, '{{ addslashes($ruang->aras_id) }}', '{{ addslashes($ruang->kod) }}', '{{ addslashes($ruang->nama) }}', {{ $ruang->is_active ? 'true' : 'false' }})"
                                            title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="deleteRuang({{ $ruang->id }}, '{{ addslashes($ruang->nama) }}')"
                                            title="Padam">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                        <form id="delete-ruang-{{ $ruang->id }}" action="{{ route('admin.ruang.destroy', $ruang) }}" method="POST" class="d-none">
                                            @csrf @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                        Tiada rekod ruang dijumpai
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Ruang Pagination --}}
                    @if($ruangsPaginated->hasPages())
                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Menunjukkan {{ $ruangsPaginated->firstItem() }}–{{ $ruangsPaginated->lastItem() }}
                            daripada {{ $ruangsPaginated->total() }} rekod
                        </small>
                        <div>
                            {{ $ruangsPaginated->appends(['tab' => 'ruang', 'ruang_search' => request('ruang_search'), 'ruang_aras_id' => request('ruang_aras_id'), 'ruang_status' => request('ruang_status')])->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

        </div>{{-- end tab-content --}}
    </div>{{-- end card --}}
</div>


{{-- ================================================================
     MODAL: TAMBAH ARAS
================================================================ --}}
<div class="modal fade" id="modalTambahAras" tabindex="-1" aria-labelledby="modalTambahArasLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="modalTambahArasLabel">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Aras Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.aras.store') }}" method="POST" id="formTambahAras">
                @csrf
                <input type="hidden" name="_redirect_tab" value="aras">
                <div class="modal-body p-4">
                    {{-- ===== BORANG D.A 5 FORMAT - ARAS ===== --}}
                    <div class="border rounded-3 overflow-hidden mb-0">

                        {{-- Header Table --}}
                        <div class="bg-light border-bottom px-4 py-3">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="badge bg-primary fs-6 px-3 py-2 rounded-pill">D.A 5</span>
                                </div>
                                <div class="col text-center">
                                    <div class="fw-bold text-uppercase text-dark" style="letter-spacing:1px; font-size:0.85rem;">
                                        JABATAN KERJA RAYA MALAYSIA
                                    </div>
                                    <div class="text-muted small">Borang Konfigurasi Aras</div>
                                </div>
                                <div class="col-auto text-end">
                                    <small class="text-muted">JKR/DA5/ARAS</small>
                                </div>
                            </div>
                        </div>

                        {{-- Form Fields as table rows --}}
                        <table class="table table-bordered table-sm mb-0" style="font-size:0.9rem;">
                            <tbody>
                                <tr>
                                    <td class="bg-light fw-semibold align-middle" style="width:35%;">
                                        Blok <span class="text-danger">*</span>
                                    </td>
                                    <td>
                                        <select name="blok_id" class="form-select form-select-sm @error('blok_id') is-invalid @enderror" required>
                                            <option value="">— Pilih Blok —</option>
                                            @foreach($bloks as $blok)
                                            <option value="{{ $blok->id }}" {{ old('blok_id') == $blok->id ? 'selected' : '' }}>
                                                {{ $blok->kod }} — {{ $blok->nama }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('blok_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">
                                        Kod Aras <span class="text-danger">*</span>
                                    </td>
                                    <td>
                                        <input type="text" name="kod" class="form-control form-control-sm @error('kod') is-invalid @enderror"
                                            value="{{ old('kod') }}" required placeholder="Contoh: 01, 02, LG, G"
                                            style="text-transform:uppercase; font-family: monospace; font-size:1rem;">
                                        <small class="text-muted">Format: 01, 02, LG, G, B1</small>
                                        @error('kod')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">
                                        Nama Aras <span class="text-danger">*</span>
                                    </td>
                                    <td>
                                        <input type="text" name="nama" class="form-control form-control-sm @error('nama') is-invalid @enderror"
                                            value="{{ old('nama') }}" required placeholder="Contoh: Aras 1, Aras Bawah Tanah">
                                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">Status</td>
                                    <td>
                                        <div class="form-check form-switch mt-1">
                                            <input class="form-check-input" type="checkbox" name="is_active"
                                                id="tambah_aras_is_active" checked>
                                            <label class="form-check-label" for="tambah_aras_is_active">Aktif</label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i> Simpan Aras
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ================================================================
     MODAL: EDIT ARAS
================================================================ --}}
<div class="modal fade" id="modalEditAras" tabindex="-1" aria-labelledby="modalEditArasLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning">
                <h5 class="modal-title fw-bold text-dark" id="modalEditArasLabel">
                    <i class="bi bi-pencil-fill me-2"></i>Kemaskini Aras
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditAras" method="POST">
                @csrf @method('PUT')
                <input type="hidden" name="_redirect_tab" value="aras">
                <div class="modal-body p-4">
                    <div class="border rounded-3 overflow-hidden mb-0">
                        <div class="bg-light border-bottom px-4 py-3">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="badge bg-warning text-dark fs-6 px-3 py-2 rounded-pill">D.A 5</span>
                                </div>
                                <div class="col text-center">
                                    <div class="fw-bold text-uppercase text-dark" style="letter-spacing:1px; font-size:0.85rem;">
                                        JABATAN KERJA RAYA MALAYSIA
                                    </div>
                                    <div class="text-muted small">Borang Konfigurasi Aras — Kemaskini</div>
                                </div>
                                <div class="col-auto text-end">
                                    <small class="text-muted">JKR/DA5/ARAS</small>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-sm mb-0" style="font-size:0.9rem;">
                            <tbody>
                                <tr>
                                    <td class="bg-light fw-semibold align-middle" style="width:35%;">
                                        Blok <span class="text-danger">*</span>
                                    </td>
                                    <td>
                                        <select name="blok_id" id="edit_aras_blok_id" class="form-select form-select-sm" required>
                                            <option value="">— Pilih Blok —</option>
                                            @foreach($bloks as $blok)
                                            <option value="{{ $blok->id }}">{{ $blok->kod }} — {{ $blok->nama }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">
                                        Kod Aras <span class="text-danger">*</span>
                                    </td>
                                    <td>
                                        <input type="text" name="kod" id="edit_aras_kod" class="form-control form-control-sm"
                                            required placeholder="Contoh: 01"
                                            style="text-transform:uppercase; font-family: monospace; font-size:1rem;">
                                        <small class="text-muted">Format: 01, 02, LG, G, B1</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">
                                        Nama Aras <span class="text-danger">*</span>
                                    </td>
                                    <td>
                                        <input type="text" name="nama" id="edit_aras_nama" class="form-control form-control-sm"
                                            required placeholder="Contoh: Aras 1">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">Status</td>
                                    <td>
                                        <div class="form-check form-switch mt-1">
                                            <input class="form-check-input" type="checkbox" name="is_active"
                                                id="edit_aras_is_active">
                                            <label class="form-check-label" for="edit_aras_is_active">Aktif</label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-check-circle me-1"></i> Kemaskini Aras
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ================================================================
     MODAL: TAMBAH RUANG
================================================================ --}}
<div class="modal fade" id="modalTambahRuang" tabindex="-1" aria-labelledby="modalTambahRuangLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold" id="modalTambahRuangLabel">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Ruang Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.ruang.store') }}" method="POST" id="formTambahRuang">
                @csrf
                <input type="hidden" name="_redirect_tab" value="ruang">
                <div class="modal-body p-4">
                    <div class="border rounded-3 overflow-hidden mb-0">

                        {{-- Header --}}
                        <div class="bg-light border-bottom px-4 py-3">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="badge bg-success fs-6 px-3 py-2 rounded-pill">D.A 5</span>
                                </div>
                                <div class="col text-center">
                                    <div class="fw-bold text-uppercase text-dark" style="letter-spacing:1px; font-size:0.85rem;">
                                        JABATAN KERJA RAYA MALAYSIA
                                    </div>
                                    <div class="text-muted small">Borang Konfigurasi Ruang</div>
                                </div>
                                <div class="col-auto text-end">
                                    <small class="text-muted">JKR/DA5/RUANG</small>
                                </div>
                            </div>
                        </div>

                        <table class="table table-bordered table-sm mb-0" style="font-size:0.9rem;">
                            <tbody>
                                <tr>
                                    <td class="bg-light fw-semibold align-middle" style="width:35%;">
                                        Aras <span class="text-danger">*</span>
                                    </td>
                                    <td>
                                        <select name="aras_id" class="form-select form-select-sm @error('aras_id') is-invalid @enderror" required>
                                            <option value="">— Pilih Aras —</option>
                                            @foreach($arasAll as $arasItem)
                                            <option value="{{ $arasItem->id }}" {{ old('aras_id') == $arasItem->id ? 'selected' : '' }}>
                                                {{ $arasItem->kod }} — {{ $arasItem->nama }}
                                                @if($arasItem->blok) (Blok: {{ $arasItem->blok->kod }})@endif
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('aras_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">
                                        Kod Ruang <span class="text-danger">*</span>
                                    </td>
                                    <td>
                                        <input type="text" name="kod" class="form-control form-control-sm @error('kod') is-invalid @enderror"
                                            value="{{ old('kod') }}" required placeholder="Contoh: R01, R02"
                                            style="text-transform:uppercase; font-family: monospace; font-size:1rem;">
                                        <small class="text-muted">Format: R01, R02, BIL, JK</small>
                                        @error('kod')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">
                                        Nama Ruang <span class="text-danger">*</span>
                                    </td>
                                    <td>
                                        <input type="text" name="nama" class="form-control form-control-sm @error('nama') is-invalid @enderror"
                                            value="{{ old('nama') }}" required placeholder="Contoh: Bilik Mesyuarat">
                                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">Status</td>
                                    <td>
                                        <div class="form-check form-switch mt-1">
                                            <input class="form-check-input" type="checkbox" name="is_active"
                                                id="tambah_ruang_is_active" checked>
                                            <label class="form-check-label" for="tambah_ruang_is_active">Aktif</label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i> Simpan Ruang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ================================================================
     MODAL: EDIT RUANG
================================================================ --}}
<div class="modal fade" id="modalEditRuang" tabindex="-1" aria-labelledby="modalEditRuangLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning">
                <h5 class="modal-title fw-bold text-dark" id="modalEditRuangLabel">
                    <i class="bi bi-pencil-fill me-2"></i>Kemaskini Ruang
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditRuang" method="POST">
                @csrf @method('PUT')
                <input type="hidden" name="_redirect_tab" value="ruang">
                <div class="modal-body p-4">
                    <div class="border rounded-3 overflow-hidden mb-0">
                        <div class="bg-light border-bottom px-4 py-3">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="badge bg-warning text-dark fs-6 px-3 py-2 rounded-pill">D.A 5</span>
                                </div>
                                <div class="col text-center">
                                    <div class="fw-bold text-uppercase text-dark" style="letter-spacing:1px; font-size:0.85rem;">
                                        JABATAN KERJA RAYA MALAYSIA
                                    </div>
                                    <div class="text-muted small">Borang Konfigurasi Ruang — Kemaskini</div>
                                </div>
                                <div class="col-auto text-end">
                                    <small class="text-muted">JKR/DA5/RUANG</small>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-sm mb-0" style="font-size:0.9rem;">
                            <tbody>
                                <tr>
                                    <td class="bg-light fw-semibold align-middle" style="width:35%;">
                                        Aras <span class="text-danger">*</span>
                                    </td>
                                    <td>
                                        <select name="aras_id" id="edit_ruang_aras_id" class="form-select form-select-sm" required>
                                            <option value="">— Pilih Aras —</option>
                                            @foreach($arasAll as $arasItem)
                                            <option value="{{ $arasItem->id }}">
                                                {{ $arasItem->kod }} — {{ $arasItem->nama }}
                                                @if($arasItem->blok) (Blok: {{ $arasItem->blok->kod }})@endif
                                            </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">
                                        Kod Ruang <span class="text-danger">*</span>
                                    </td>
                                    <td>
                                        <input type="text" name="kod" id="edit_ruang_kod" class="form-control form-control-sm"
                                            required placeholder="Contoh: R01"
                                            style="text-transform:uppercase; font-family: monospace; font-size:1rem;">
                                        <small class="text-muted">Format: R01, R02, BIL, JK</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">
                                        Nama Ruang <span class="text-danger">*</span>
                                    </td>
                                    <td>
                                        <input type="text" name="nama" id="edit_ruang_nama" class="form-control form-control-sm"
                                            required placeholder="Contoh: Bilik Mesyuarat">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">Status</td>
                                    <td>
                                        <div class="form-check form-switch mt-1">
                                            <input class="form-check-input" type="checkbox" name="is_active"
                                                id="edit_ruang_is_active">
                                            <label class="form-check-label" for="edit_ruang_is_active">Aktif</label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-check-circle me-1"></i> Kemaskini Ruang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
// ===== TAB TOGGLE: Show correct Add button =====
const arasTab    = document.getElementById('aras-tab');
const ruangTab   = document.getElementById('ruang-tab');
const btnTambahAras  = document.getElementById('btnTambahAras');
const btnTambahRuang = document.getElementById('btnTambahRuang');

arasTab.addEventListener('shown.bs.tab', function () {
    btnTambahAras.classList.remove('d-none');
    btnTambahRuang.classList.add('d-none');
});
ruangTab.addEventListener('shown.bs.tab', function () {
    btnTambahAras.classList.add('d-none');
    btnTambahRuang.classList.remove('d-none');
});

// Init button state
@if($activeTab === 'ruang')
    btnTambahAras.classList.add('d-none');
    btnTambahRuang.classList.remove('d-none');
@endif

// ===== EDIT ARAS =====
function editAras(id, blokId, kod, nama, isActive) {
    document.getElementById('formEditAras').action = '/admin/aras/' + id;
    document.getElementById('edit_aras_blok_id').value = blokId;
    document.getElementById('edit_aras_kod').value = kod;
    document.getElementById('edit_aras_nama').value = nama;
    document.getElementById('edit_aras_is_active').checked = isActive;

    var modal = new bootstrap.Modal(document.getElementById('modalEditAras'));
    modal.show();
}

// ===== DELETE ARAS =====
function deleteAras(id, nama) {
    if (confirm('Adakah anda pasti ingin memadam aras "' + nama + '"?\n\nTindakan ini tidak boleh dibatalkan.')) {
        document.getElementById('delete-aras-' + id).submit();
    }
}

// ===== EDIT RUANG =====
function editRuang(id, arasId, kod, nama, isActive) {
    document.getElementById('formEditRuang').action = '/admin/ruang/' + id;
    document.getElementById('edit_ruang_aras_id').value = arasId;
    document.getElementById('edit_ruang_kod').value = kod;
    document.getElementById('edit_ruang_nama').value = nama;
    document.getElementById('edit_ruang_is_active').checked = isActive;

    var modal = new bootstrap.Modal(document.getElementById('modalEditRuang'));
    modal.show();
}

// ===== DELETE RUANG =====
function deleteRuang(id, nama) {
    if (confirm('Adakah anda pasti ingin memadam ruang "' + nama + '"?\n\nTindakan ini tidak boleh dibatalkan.')) {
        document.getElementById('delete-ruang-' + id).submit();
    }
}

// ===== AUTO-OPEN MODAL if validation failed =====
@if($errors->any())
    @if(old('_redirect_tab') === 'ruang' || session('_redirect_tab') === 'ruang')
        // Trigger ruang tab
        var ruangTabEl = document.getElementById('ruang-tab');
        bootstrap.Tab.getOrCreateInstance(ruangTabEl).show();

        @if(old('_form_type') === 'edit_ruang')
            // Re-open edit ruang modal (not needed as we redirect back)
        @else
            var modalEl = document.getElementById('modalTambahRuang');
            var modal = new bootstrap.Modal(modalEl);
            modal.show();
        @endif
    @else
        var modalEl = document.getElementById('modalTambahAras');
        var modal = new bootstrap.Modal(modalEl);
        modal.show();
    @endif
@endif

// Auto-uppercase kod inputs
document.querySelectorAll('input[name="kod"]').forEach(function(el) {
    el.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
});
</script>

<style>
/* Tab styling */
#arasRuangTabs .nav-link {
    border-radius: 0.5rem 0.5rem 0 0;
    border: 1px solid transparent;
    color: #6c757d;
    transition: all 0.2s;
}
#arasRuangTabs .nav-link.active {
    border-color: #dee2e6 #dee2e6 #fff;
    color: #2563eb;
    background: #fff;
}
#arasRuangTabs .nav-link:hover:not(.active) {
    background: #f8f9fa;
    border-color: #dee2e6;
    color: #495057;
}

/* Table improvements */
#arasTable th, #ruangTable th {
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    color: #6c757d;
}
#arasTable td, #ruangTable td {
    vertical-align: middle;
    font-size: 0.875rem;
}
#arasTable tbody tr:hover,
#ruangTable tbody tr:hover {
    background-color: #f8faff;
}

/* Modal form table */
.modal .table-bordered td {
    padding: 0.6rem 0.85rem;
}
.modal .table-bordered td:first-child {
    white-space: nowrap;
}

/* Badge subtle (Bootstrap 5.3 compatible fallback) */
.bg-primary-subtle  { background-color: #dbeafe !important; }
.bg-success-subtle  { background-color: #d1fae5 !important; }
.bg-secondary-subtle { background-color: #f1f5f9 !important; }
.text-primary { color: #2563eb !important; }
.text-success { color: #059669 !important; }
.border-primary-subtle  { border-color: #93c5fd !important; }
.border-success-subtle  { border-color: #6ee7b7 !important; }
.border-secondary-subtle { border-color: #cbd5e1 !important; }
</style>
@endsection
