@extends('layouts.app')

@section('title', 'Borang D.A.4')

@section('content')
<div class="container-fluid px-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4 pt-2">
        <div>
            <h2 class="mb-1 fw-bold" style="color: #1e293b;">
                <i class="bi bi-grid-3x3-gap-fill me-2" style="color: var(--primary);"></i>Borang D.A.4
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted">
                            <i class="bi bi-house-door me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item active fw-semibold" style="color: var(--primary);">Borang D.A.4</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.blok.create') }}" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm px-4">
            <i class="bi bi-plus-circle-fill"></i>
            <span>Tambah Baru</span>
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="card border-0 h-100" style="background: linear-gradient(135deg, rgba(37,99,235,0.12), rgba(37,99,235,0.05)); border-left: 4px solid var(--primary) !important;">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:52px;height:52px;background: rgba(37,99,235,0.15);">
                        <i class="bi bi-buildings fs-4" style="color: var(--primary);"></i>
                    </div>
                    <div>
                        <div class="text-uppercase fw-semibold mb-1" style="font-size:0.72rem;letter-spacing:.06em; color: var(--primary);">Premis Berdaftar</div>
                        <div class="fw-bold lh-1" style="font-size:2rem; color: var(--primary);">{{ $totalPremisDa4 ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0 h-100" style="background: linear-gradient(135deg, rgba(111,66,193,0.12), rgba(111,66,193,0.05)); border-left: 4px solid #6f42c1 !important;">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:52px;height:52px;background: rgba(111,66,193,0.15);">
                        <i class="bi bi-building fs-4" style="color: #6f42c1;"></i>
                    </div>
                    <div>
                        <div class="text-uppercase fw-semibold mb-1" style="font-size:0.72rem;letter-spacing:.06em; color: #6f42c1;">Jumlah Blok</div>
                        <div class="fw-bold lh-1" style="font-size:2rem; color: #6f42c1;">{{ $totalBlok ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0 h-100" style="background: linear-gradient(135deg, rgba(16,185,129,0.12), rgba(16,185,129,0.05)); border-left: 4px solid var(--success) !important;">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:52px;height:52px;background: rgba(16,185,129,0.15);">
                        <i class="bi bi-house-gear fs-4" style="color: var(--success);"></i>
                    </div>
                    <div>
                        <div class="text-uppercase fw-semibold mb-1" style="font-size:0.72rem;letter-spacing:.06em; color: var(--success);">Jumlah Binaan Luar</div>
                        <div class="fw-bold lh-1" style="font-size:2rem; color: var(--success);">{{ $totalBinaanLuar ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Panel --}}
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-2">
            <i class="bi bi-funnel text-muted"></i>
            <span class="fw-semibold text-dark">Tapisan & Carian</span>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.blok.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label text-muted small fw-semibold mb-1">Carian</label>
                        <input type="text" class="form-control" name="search"
                               placeholder="Nama premis atau No. DPA..."
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label text-muted small fw-semibold mb-1">Premis</label>
                        <select class="form-select" id="premis_id" name="premis_id">
                            <option value="">Semua Premis</option>
                            @foreach(\App\Models\Premis::whereHas('blok')->orWhereHas('binaanLuar')->orderBy('nama_premis')->get() as $p)
                                <option value="{{ $p->id }}" {{ request('premis_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_premis }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label text-muted small fw-semibold mb-1">Negeri</label>
                        <select class="form-select" id="negeri" name="negeri">
                            <option value="">Semua Negeri</option>
                            @foreach(\App\Models\Premis::whereNotNull('negeri')->where('negeri', '!=', '')->distinct()->orderBy('negeri')->pluck('negeri') as $n)
                                <option value="{{ $n }}" {{ request('negeri') == $n ? 'selected' : '' }}>{{ $n }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label text-muted small fw-semibold mb-1">Status</label>
                        <select class="form-select" name="status">
                            <option value="">Semua</option>
                            <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 mt-3 pt-3 border-top">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-funnel me-1"></i> Tapis
                    </button>
                    @if(request()->anyFilled(['search', 'premis_id', 'negeri', 'status']))
                        <a href="{{ route('admin.blok.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card border-0 shadow-sm rounded-3">

        {{-- Table Header --}}
        <div class="px-4 py-3 d-flex justify-content-between align-items-center border-bottom">
            <span class="fw-semibold text-muted small text-uppercase" style="letter-spacing:.04em;">
                Senarai Premis
            </span>
            <span class="badge bg-primary rounded-pill">{{ $bloks->total() }} rekod</span>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 0.9rem; min-width: 750px;">
                <thead style="background-color: #f8fafc;">
                    <tr>
                        <th class="ps-4 text-muted fw-semibold" style="width:55px; font-size:0.8rem;">BIL</th>
                        <th class="text-muted fw-semibold" style="font-size:0.8rem;">NAMA PREMIS</th>
                        <th class="text-muted fw-semibold" style="font-size:0.8rem;">NO. DPA</th>
                        <th class="text-center text-muted fw-semibold" style="font-size:0.8rem; width:90px;">BLOK</th>
                        <th class="text-center text-muted fw-semibold" style="font-size:0.8rem; width:110px;">BINAAN LUAR</th>
                        <th class="text-end pe-4 text-muted fw-semibold" style="font-size:0.8rem; width:180px;">TINDAKAN</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bloks as $index => $premis)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td class="ps-4 text-muted">{{ $bloks->firstItem() + $index }}</td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $premis->nama_premis }}</div>
                            @if($premis->negeri)
                                <small class="text-muted"><i class="bi bi-geo-alt me-1"></i>{{ $premis->negeri }}</small>
                            @endif
                        </td>
                        <td>
                            @if($premis->no_dpa)
                                <code class="text-muted" style="font-size:0.78rem; word-break:break-all;">{{ $premis->no_dpa }}</code>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge rounded-pill px-3 py-2"
                                  style="background-color: rgba(37,99,235,0.1); color: var(--primary); font-size:0.85rem; font-weight:600;">
                                {{ $premis->blok->count() }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge rounded-pill px-3 py-2"
                                  style="background-color: rgba(16,185,129,0.1); color: var(--success); font-size:0.85rem; font-weight:600;">
                                {{ $premis->binaanLuar->count() }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex gap-1 justify-content-end align-items-center">
                                <a href="{{ route('admin.blok.show', $premis->id) }}"
                                   class="btn btn-sm btn-outline-primary border-0 bg-primary bg-opacity-10" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.blok.edit', $premis->id) }}"
                                   class="btn btn-sm btn-outline-warning border-0 bg-warning bg-opacity-10" title="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger border-0 bg-danger bg-opacity-10"
                                    data-id="{{ $premis->id }}"
                                    data-nama="{{ $premis->nama_premis }}"
                                    onclick="previewPdfFromBtn(this)" title="PDF">
                                    <i class="bi bi-file-pdf-fill"></i>
                                </button>
                                <form action="{{ route('admin.blok.destroy', $premis->id) }}" method="POST"
                                    data-nama="{{ $premis->nama_premis }}"
                                    onsubmit="return confirm('Padam data DA4 untuk ' + this.dataset.nama + '?')" class="mb-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0 bg-danger bg-opacity-10" title="Padam">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="text-center py-5">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                     style="width:70px;height:70px; background: rgba(37,99,235,0.08);">
                                    <i class="bi bi-inbox fs-2" style="color: var(--primary);"></i>
                                </div>
                                <h6 class="text-muted fw-semibold">Tiada rekod dijumpai</h6>
                                <p class="text-muted small mb-3">Cuba ubah tapisan atau tambah rekod baru.</p>
                                @if(!request()->anyFilled(['search', 'negeri', 'status']))
                                    <a href="{{ route('admin.blok.create') }}" class="btn btn-primary btn-sm px-4">
                                        <i class="bi bi-plus-lg me-1"></i> Tambah Sekarang
                                    </a>
                                @else
                                    <a href="{{ route('admin.blok.index') }}" class="btn btn-outline-secondary btn-sm px-4">
                                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Carian
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination footer --}}
        @if($bloks->hasPages())
        <div class="card-footer bg-white border-top px-4 py-3 d-flex justify-content-between align-items-center">
            <small class="text-muted">
                Menunjukkan {{ $bloks->firstItem() }}–{{ $bloks->lastItem() }} daripada {{ $bloks->total() }} rekod
            </small>
            {{ $bloks->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

</div>

{{-- PDF Preview Modal --}}
<div class="modal fade" id="modalPDF" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header" style="background-color: var(--primary);">
                <h5 class="modal-title fw-bold text-white">
                    <i class="bi bi-file-pdf-fill me-2"></i>Pratonton — <span id="modalPremisNama"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0 bg-secondary">
                <iframe id="pdfFrame" src="" width="100%" style="border: none; height: 65vh; min-height: 450px;"></iframe>
            </div>
            <div class="modal-footer bg-light">
                <a id="pdfDownload" href="#" class="btn btn-danger">
                    <i class="bi bi-download me-1"></i> Muat Turun PDF
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#premis_id').select2({
        theme: 'bootstrap-5',
        placeholder: 'Semua Premis',
        allowClear: true
    });

    const modalEl = document.getElementById('modalPDF');
    if (modalEl) {
        document.body.appendChild(modalEl);
        modalEl.addEventListener('hidden.bs.modal', function() {
            document.getElementById('pdfFrame').src = '';
        });
    }
});

function previewPdf(id, nama) {
    const base = '{{ rtrim(url("/"), "/") }}';
    const url = `${base}/admin/blok/${id}/export-pdf`;
    document.getElementById('pdfFrame').src = url;
    document.getElementById('pdfDownload').href = url;
    document.getElementById('modalPremisNama').textContent = nama;
    const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalPDF'));
    modal.show();
}

function previewPdfFromBtn(btn) {
    previewPdf(btn.dataset.id, btn.dataset.nama);
}
</script>
@endpush