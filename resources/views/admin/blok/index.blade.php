@extends('layouts.app')

@section('title', 'Borang D.A.4')

@section('content')
<div class="container-fluid px-4">

    <div class="d-flex justify-content-between align-items-start mb-4 pt-2">
        <div>
            <h2 class="mb-1 fw-bold text-dark">
                <i class="bi bi-grid-3x3-gap-fill me-2" style="color: var(--primary-color) !important;"></i>Borang D.A.4
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                            <i class="bi bi-house-door me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-muted">Borang D.A.4</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.blok.create') }}" class="btn text-white d-flex align-items-center gap-2 shadow-sm" style="background-color: var(--primary-color); border-color: var(--primary-color);">
            <i class="bi bi-plus-circle-fill"></i>
            <span>Tambah Baru</span>
        </a>
    </div>



    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="card border-0 rounded-3 h-100" style="background: rgba(37, 99, 235, 0.1);">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:44px;height:44px;background: rgba(37, 99, 235, 0.2);">
                        <i class="bi bi-buildings fs-5" style="color: var(--primary-color) !important;"></i>
                    </div>
                    <div>
                        <div class="fw-semibold" style="font-size:0.75rem;letter-spacing:.04em; color: var(--primary-color) !important;">PREMIS BERDAFTAR</div>
                        <div class="fw-bold fs-4 lh-1 mt-1" style="color: var(--primary-color) !important;">{{ $totalPremisDa4 ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border-0 rounded-3 h-100" style="background: rgba(111, 66, 193, 0.1);">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:44px;height:44px;background: rgba(111, 66, 193, 0.2);">
                        <i class="bi bi-grid-fill fs-5" style="color: #6f42c1 !important;"></i>
                    </div>
                    <div>
                        <div class="fw-semibold" style="font-size:0.75rem;letter-spacing:.04em; color: #6f42c1 !important;">JUMLAH BLOK</div>
                        <div class="fw-bold fs-4 lh-1 mt-1" style="color: #6f42c1 !important;">{{ $totalBlok ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border-0 rounded-3 h-100" style="background: rgba(16, 185, 129, 0.1);">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:44px;height:44px;background: rgba(16, 185, 129, 0.2);">
                        <i class="bi bi-house-gear fs-5" style="color: var(--success-color) !important;"></i>
                    </div>
                    <div>
                        <div class="fw-semibold" style="font-size:0.75rem;letter-spacing:.04em; color: var(--success-color) !important;">JUMLAH BINAAN LUAR</div>
                        <div class="fw-bold fs-4 lh-1 mt-1" style="color: var(--success-color) !important;">{{ $totalBinaanLuar ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-2">
            <i class="bi bi-funnel text-muted"></i>
            <span class="fw-semibold text-dark">Tapisan & Carian</span>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.blok.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-md-3">
                        <label for="search" class="form-label text-muted small fw-semibold mb-1">Carian</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-search text-muted small"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0" id="search" name="search" 
                                   placeholder="No. DPA atau Nama Premis..." 
                                   value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <label for="premis_id" class="form-label text-muted small fw-semibold mb-1">Pilihan Premis</label>
                        <select class="form-select" id="premis_id" name="premis_id">
                            <option value="">Semua Premis</option>
                            @foreach(\App\Models\Premis::whereHas('blok')->orWhereHas('binaanLuar')->orderBy('nama_premis')->get() as $p)
                                <option value="{{ $p->id }}" {{ request('premis_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_premis }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-3">
                        <label for="negeri" class="form-label text-muted small fw-semibold mb-1">Negeri</label>
                        <select class="form-select" id="negeri" name="negeri">
                            <option value="">Semua Negeri</option>
                            @foreach(\App\Models\Premis::whereNotNull('negeri')->where('negeri', '!=', '')->distinct()->orderBy('negeri')->pluck('negeri') as $n)
                                <option value="{{ $n }}" {{ request('negeri') == $n ? 'selected' : '' }}>{{ $n }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-3">
                        <label for="status" class="form-label text-muted small fw-semibold mb-1">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Semua</option>
                            <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2 mt-3 pt-3 border-top">
                    <button type="submit" class="btn btn-dark px-4">
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

   @forelse($bloks as $premis)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
            <div>
                <span class="text-primary fw-semibold">
                    <i class="bi bi-geo-alt-fill me-2" style="color: var(--primary-color) !important;"></i>{{ $premis->nama_premis }}
                </span>
                @if($premis->no_dpa)
                <span class="badge bg-light text-dark ms-2 border">No. DPA: {{ $premis->no_dpa }}</span>
                @endif
            </div>
            <div class="d-flex gap-2 align-items-center">
                <span class="badge" style="background-color: rgba(37, 99, 235, 0.1) !important; color: var(--primary-color) !important; border: 1px solid rgba(37, 99, 235, 0.25) !important;">
                    {{ $premis->blok->count() }} Blok
                </span>
                <span class="badge" style="background-color: rgba(16, 185, 129, 0.1) !important; color: var(--success-color) !important; border: 1px solid rgba(16, 185, 129, 0.25) !important;">
                    {{ $premis->binaanLuar->count() }} Binaan Luar
                </span>
                <a href="{{ route('admin.blok.edit', $premis->id) }}" class="btn btn-sm btn-outline-warning border-0 bg-warning bg-opacity-10 text-warning" title="Edit">
                    <i class="bi bi-pencil"></i> <span class="d-none d-sm-inline">Edit</span>
                </a>
                <button type="button" class="btn btn-sm btn-outline-danger border-0 bg-danger bg-opacity-10 text-danger"
                    onclick="previewPdf({{ $premis->id }}, '{{ addslashes($premis->nama_premis) }}')" title="PDF">
                    <i class="bi bi-file-pdf"></i> <span class="d-none d-sm-inline">PDF</span>
                </button>
                <form action="{{ route('admin.blok.destroy', $premis->id) }}" method="POST"
                    onsubmit="return confirm('Padam semua blok dan binaan luar untuk {{ addslashes($premis->nama_premis) }}?')" class="mb-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger border-0 bg-danger bg-opacity-10 text-danger" title="Padam">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th style="width:50px;" class="text-center">Bil</th>
                            <th>Jenis</th>
                            <th>Nama</th>
                            <th>Fungsi / Jenis Binaan</th>
                            <th style="width:140px;">Luas Tapak (m²)</th>
                            <th>Kod mySPATA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($premis->blok as $index => $blok)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3">Blok</span>
                            </td>
                            <td>{{ $blok->nama_blok }}</td>
                            <td>{{ $blok->fungsi_binaan ?? '-' }}</td>
                            <td>{{ $blok->luas_tapak ?? '-' }}</td>
                            <td>{{ $blok->kod_blok_myspata ?? '-' }}</td>
                        </tr>
                        @endforeach
                        @foreach($premis->binaanLuar as $index => $binaan)
                        <tr>
                            <td class="text-center">{{ $premis->blok->count() + $index + 1 }}</td>
                            <td>
                                <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3">Binaan Luar</span>
                            </td>
                            <td>{{ $binaan->nama_binaan_luar }}</td>
                            <td>{{ $binaan->jenis_binaan_luar ?? '-' }}</td>
                            <td>{{ $binaan->luas_tapak ?? '-' }}</td>
                            <td>{{ $binaan->kod_binaan_luar_myspata ?? '-' }}</td>
                        </tr>
                        @endforeach
                        @if($premis->blok->count() == 0 && $premis->binaanLuar->count() == 0)
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Tiada rekod blok atau binaan luar didaftarkan untuk premis ini.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @empty
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body text-center py-5">
            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                <i class="bi bi-inbox fs-1 text-muted"></i>
            </div>
            <h5 class="text-muted">Tiada rekod blok atau binaan luar dijumpai.</h5>
            <p class="text-muted mb-4">Sila ubah tapisan anda atau tambah rekod baru.</p>
            @if(!request()->anyFilled(['search', 'negeri', 'status']))
                <a href="{{ route('admin.blok.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Sekarang
                </a>
            @else
                <a href="{{ route('admin.blok.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Carian
                </a>
            @endif
        </div>
    </div>
    @endforelse

    <div class="d-flex justify-content-end mt-3">
        {{ $bloks->appends(request()->query())->links() }}
    </div>

</div>

<div class="modal fade" id="modalPDF" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-file-pdf-fill text-danger me-2"></i>Pratonton Konfigurasi Blok — <span id="modalPremisNama" class="text-primary"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0 bg-secondary">
                <iframe id="pdfFrame" src="" width="100%" style="border: none; height: 60vh; min-height: 400px;"></iframe>
            </div>
            <div class="modal-footer bg-light">
                <a id="pdfDownload" href="#" class="btn btn-danger">
                    <i class="bi bi-download me-1"></i> Muat Turun PDF
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
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
        modalEl.addEventListener('hidden.bs.modal', function() {
            const frame = document.getElementById('pdfFrame');
            if (frame) frame.src = '';
        });
    }
});

function previewPdf(id, nama) {
    const url = `/admin/blok/${id}/export-pdf`;
    const frame = document.getElementById('pdfFrame');
    const downloadLink = document.getElementById('pdfDownload');
    const titleSpan = document.getElementById('modalPremisNama');
    
    if (frame) frame.src = url;
    if (downloadLink) downloadLink.href = url;
    if (titleSpan) titleSpan.textContent = nama;
    
    const modalEl = document.getElementById('modalPDF');
    if (modalEl) {
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    }
}
</script>
@endpush