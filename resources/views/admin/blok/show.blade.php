@extends('layouts.app')

@section('title', 'Borang D.A.4 — ' . $premis->nama_premis)

@section('content')
<div class="container-fluid px-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2 class="mb-1 fw-bold text-dark">
                <i class="bi bi-grid-3x3-gap-fill me-2" style="color: var(--primary);"></i>Borang D.A.4
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.blok.index') }}">Borang D.A.4</a></li>
                    <li class="breadcrumb-item active">{{ $premis->nama_premis }}</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.blok.edit', $premis->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-1"></i> Edit
            </a>
            <button type="button" class="btn btn-danger"
                onclick="previewPdf({{ $premis->id }}, '{{ addslashes($premis->nama_premis) }}')">
                <i class="bi bi-file-pdf me-1"></i> PDF
            </button>
            <a href="{{ route('admin.blok.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    {{-- Premis Info Card --}}
    <div class="card border-0 shadow-sm mb-4" style="border-left: 4px solid var(--primary) !important;">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                             style="width:48px;height:48px;background: rgba(37,99,235,0.1);">
                            <i class="bi bi-buildings fs-4" style="color: var(--primary);"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-5">{{ $premis->nama_premis }}</div>
                            @if($premis->no_dpa)
                                <span class="badge bg-light text-dark border">No. DPA: {{ $premis->no_dpa }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-md-end mt-2 mt-md-0">
                    <span class="badge fs-6 me-2" style="background-color: rgba(37,99,235,0.1); color: var(--primary); border: 1px solid rgba(37,99,235,0.25);">
                        <i class="bi bi-building me-1"></i>{{ $premis->blok->count() }} Blok
                    </span>
                    <span class="badge fs-6" style="background-color: rgba(16,185,129,0.1); color: var(--success); border: 1px solid rgba(16,185,129,0.25);">
                        <i class="bi bi-house-gear me-1"></i>{{ $premis->binaanLuar->count() }} Binaan Luar
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Blok Table --}}
    @if($premis->blok->count() > 0)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header py-3" style="background-color: var(--primary);">
            <h6 class="mb-0 fw-semibold text-white">
                <i class="bi bi-building me-2"></i>Blok ({{ $premis->blok->count() }} rekod)
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead style="background-color: rgba(37,99,235,0.08);">
                        <tr>
                            <th class="text-center" style="width:50px;">Bil</th>
                            <th>Nama Blok</th>
                            <th>Fungsi Binaan</th>
                            <th style="width:160px;">Luas Tapak (m²)</th>
                            <th>Kod mySPATA</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($premis->blok as $index => $blok)
                        <tr>
                            <td class="text-center fw-semibold">{{ $index + 1 }}</td>
                            <td class="fw-semibold">{{ $blok->nama_blok }}</td>
                            <td>{{ $blok->fungsi_binaan ?? '-' }}</td>
                            <td>{{ $blok->luas_tapak ? number_format($blok->luas_tapak, 2) : '-' }}</td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">{{ $blok->kod_blok_myspata ?? '-' }}</span></td>
                            <td class="text-muted">{{ $blok->catatan ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- Binaan Luar Table --}}
    @if($premis->binaanLuar->count() > 0)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header py-3" style="background-color: #4a5568;">
            <h6 class="mb-0 fw-semibold text-white">
                <i class="bi bi-house-gear me-2"></i>Binaan Luar ({{ $premis->binaanLuar->count() }} rekod)
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead style="background-color: rgba(74,85,104,0.08);">
                        <tr>
                            <th class="text-center" style="width:50px;">Bil</th>
                            <th>Nama Binaan Luar</th>
                            <th>Jenis Binaan Luar</th>
                            <th style="width:160px;">Luas Tapak (m²)</th>
                            <th>Kod mySPATA</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($premis->binaanLuar as $index => $binaan)
                        <tr>
                            <td class="text-center fw-semibold">{{ $index + 1 }}</td>
                            <td class="fw-semibold">{{ $binaan->nama_binaan_luar }}</td>
                            <td>{{ $binaan->jenis_binaan_luar ?? '-' }}</td>
                            <td>{{ $binaan->luas_tapak ? number_format($binaan->luas_tapak, 2) : '-' }}</td>
                            <td><span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">{{ $binaan->kod_binaan_luar_myspata ?? '-' }}</span></td>
                            <td class="text-muted">{{ $binaan->catatan ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    @if($premis->blok->count() == 0 && $premis->binaanLuar->count() == 0)
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5">
            <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
            <h5 class="text-muted">Tiada rekod blok atau binaan luar.</h5>
            <a href="{{ route('admin.blok.edit', $premis->id) }}" class="btn btn-primary mt-2">
                <i class="bi bi-plus-lg me-1"></i> Tambah Sekarang
            </a>
        </div>
    </div>
    @endif

</div>

{{-- PDF Preview Modal --}}
<div class="modal fade" id="modalPDF" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header" style="background-color: var(--primary);">
                <h5 class="modal-title fw-bold text-white">
                    <i class="bi bi-file-pdf-fill me-2"></i>Pratonton PDF — <span id="modalPremisNama"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0 bg-secondary">
                <iframe id="pdfFrame" src="" width="100%" style="border:none; height:65vh; min-height:450px;"></iframe>
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
function previewPdf(id, nama) {
    const base = '{{ rtrim(url("/"), "/") }}';
    const url = `${base}/admin/blok/${id}/export-pdf`;
    document.getElementById('pdfFrame').src = url;
    document.getElementById('pdfDownload').href = url;
    document.getElementById('modalPremisNama').textContent = nama;
    const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalPDF'));
    modal.show();
}
document.getElementById('modalPDF').addEventListener('hidden.bs.modal', function() {
    document.getElementById('pdfFrame').src = '';
});
</script>
@endpush
