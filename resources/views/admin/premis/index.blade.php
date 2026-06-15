@extends('layouts.app')

@section('title', 'Borang D.A.3')

@section('content')
<div class="container-fluid px-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4 pt-2">
        <div>
            <h2 class="mb-1 fw-bold text-dark">
                <i class="bi bi-file-earmark-text me-2" style="color: var(--primary-color) !important;"></i>Borang D.A.3
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                            <i class="bi bi-house-door me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item active text-muted">Borang D.A.3</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.premis.create') }}" class="btn text-white d-flex align-items-center gap-2 shadow-sm" style="background-color: var(--primary-color); border-color: var(--primary-color);">
            <i class="bi bi-plus-circle-fill"></i>
            <span>Tambah Premis</span>
        </a>
    </div>



    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="card border-0 rounded-3 h-100" style="background: rgba(37, 99, 235, 0.1);">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:44px;height:44px;background: rgba(37, 99, 235, 0.2);">
                        <i class="bi bi-buildings fs-5" style="color: var(--primary-color) !important;"></i>
                    </div>
                    <div>
                        <div class="fw-semibold" style="font-size:0.75rem;letter-spacing:.04em; color: var(--primary-color) !important;">JUMLAH PREMIS</div>
                        <div class="fw-bold fs-4 lh-1 mt-1" style="color: var(--primary-color) !important;">{{ $totalPremis ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border-0 rounded-3 h-100" style="background: rgba(16, 185, 129, 0.1);">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:44px;height:44px;background: rgba(16, 185, 129, 0.2);">
                        <i class="bi bi-check2-circle fs-5" style="color: var(--success-color) !important;"></i>
                    </div>
                    <div>
                        <div class="fw-semibold" style="font-size:0.75rem;letter-spacing:.04em; color: var(--success-color) !important;">PREMIS AKTIF</div>
                        <div class="fw-bold fs-4 lh-1 mt-1" style="color: var(--success-color) !important;">{{ $aktifPremis ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border-0 rounded-3 h-100" style="background: rgba(30, 41, 59, 0.1);">
                <div class="card-body d-flex align-items-center gap-3 p-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:44px;height:44px;background: rgba(30, 41, 59, 0.2);">
                        <i class="bi bi-x-circle fs-5" style="color: var(--dark-color) !important;"></i>
                    </div>
                    <div>
                        <div class="fw-semibold" style="font-size:0.75rem;letter-spacing:.04em; color: var(--dark-color) !important;">TIDAK AKTIF</div>
                        <div class="fw-bold fs-4 lh-1 mt-1" style="color: var(--dark-color) !important;">{{ $tidakAktifPremis ?? 0 }}</div>
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
            <form action="{{ route('admin.premis.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <label for="search" class="form-label text-muted small fw-semibold mb-1">Carian</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-search text-muted small"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0" id="search" name="search"
                                   placeholder="No. DPA atau Nama Premis..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="premis_id" class="form-label text-muted small fw-semibold mb-1">Pilihan Premis</label>
                        <select class="form-select" id="premis_id" name="premis_id">
                            <option value="">Semua Premis</option>
                            @foreach(\App\Models\Premis::orderBy('nama_premis')->get() as $p)
                                <option value="{{ $p->id }}" {{ request('premis_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_premis }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="negeri" class="form-label text-muted small fw-semibold mb-1">Negeri</label>
                        <select class="form-select" id="negeri" name="negeri">
                            <option value="">Semua Negeri</option>
                            @foreach(\App\Models\Premis::whereNotNull('negeri')->where('negeri', '!=', '')->distinct()->orderBy('negeri')->pluck('negeri') as $n)
                                <option value="{{ $n }}" {{ request('negeri') == $n ? 'selected' : '' }}>{{ $n }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="status" class="form-label text-muted small fw-semibold mb-1">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Semua</option>
                            <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="tarikh_dari" class="form-label text-muted small fw-semibold mb-1">Dari</label>
                        <input type="date" class="form-control" id="tarikh_dari" name="tarikh_dari"
                               value="{{ request('tarikh_dari') }}">
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="tarikh_hingga" class="form-label text-muted small fw-semibold mb-1">Hingga</label>
                        <input type="date" class="form-control" id="tarikh_hingga" name="tarikh_hingga"
                               value="{{ request('tarikh_hingga') }}">
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2 mt-3 pt-3 border-top">
                    <button type="submit" class="btn btn-dark px-4">
                        <i class="bi bi-funnel me-1"></i> Tapis
                    </button>
                    @if(request()->anyFilled(['search','premis_id','negeri','status','tarikh_dari','tarikh_hingga']))
                        <a href="{{ route('admin.premis.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-list-ul" style="color: var(--primary-color) !important;"></i>
                <span class="fw-semibold text-dark">Senarai Premis</span>
                @if($premis->total() > 0)
                    <span class="badge ms-1" style="background-color: rgba(37, 99, 235, 0.1) !important; color: var(--primary-color) !important; border: 1px solid rgba(37, 99, 235, 0.25) !important;">
                        {{ $premis->total() }} rekod
                    </span>
                @endif
            </div>
        </div>

        <div class="card-body p-0">
            @if($premis->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="min-width:800px;">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4 py-3" style="width:50px;">Bil</th>
                            <th class="py-3" style="width:130px;">No. DPA</th>
                            <th class="py-3">Nama Premis</th>
                            <th class="py-3" style="width:120px;">Negeri</th>
                            <th class="py-3 text-center" style="width:100px;">Status</th>
                            <th class="py-3" style="width:130px;">Tarikh Daftar</th>
                            <th class="py-3 text-center" style="width:80px;">Blok</th>
                            <th class="py-3 text-center" style="width:100px;">Binaan Luar</th>
                            <th class="pe-4 py-3 text-center" style="width:130px;">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($premis as $index => $p)
                        <tr>
                            <td class="ps-4 text-muted small">{{ $premis->firstItem() + $index }}</td>

                            <td>
                                @if($p->no_dpa)
                                    <span class="badge bg-light text-dark border fw-normal font-monospace">
                                        {{ $p->no_dpa }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('admin.premis.show', $p->id) }}"
                                   class="fw-semibold text-decoration-none text-dark d-block">
                                    {{ $p->nama_premis }}
                                </a>
                                @if($p->alamat_premis)
                                    <small class="text-muted d-block mt-1">
                                        <i class="bi bi-geo-alt me-1"></i>{{ Str::limit($p->alamat_premis, 55) }}
                                    </small>
                                @endif
                            </td>

                            <td>
                                <small class="text-dark">{{ $p->negeri ?? '—' }}</small>
                            </td>

                            <td class="text-center">
                                @if($p->status_premis == 'Aktif')
                                    <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3">
                                        <i class="bi bi-circle-fill me-1" style="font-size:.45rem;vertical-align:middle;"></i>Aktif
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-3">
                                        <i class="bi bi-circle-fill me-1" style="font-size:.45rem;vertical-align:middle;"></i>Tidak Aktif
                                    </span>
                                @endif
                            </td>

                            <td>
                                <small class="text-muted">
                                    {{ $p->created_at ? $p->created_at->format('d/m/Y') : '—' }}
                                </small>
                            </td>

                            <td class="text-center">
                                <span class="badge rounded-pill bg-primary">{{ $p->bil_blok_bangunan ?? 0 }}</span>
                            </td>

                            <td class="text-center">
                                <span class="badge rounded-pill bg-info text-dark">{{ $p->bil_binaan_luar ?? 0 }}</span>
                            </td>

                            <td class="pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('admin.premis.show', $p->id) }}"
                                       class="btn btn-sm btn-outline-primary border-0 bg-primary bg-opacity-10"
                                       title="Lihat">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.premis.edit', $p->id) }}"
                                       class="btn btn-sm btn-outline-warning border-0 bg-warning bg-opacity-10"
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button"
                                        class="btn btn-sm btn-outline-danger border-0 bg-danger bg-opacity-10"
                                        onclick="previewPdf({{ $p->id }}, '{{ addslashes($p->nama_premis) }}')"
                                        title="Preview PDF">
                                        <i class="bi bi-file-pdf"></i>
                                    </button>
                                    <form action="{{ route('admin.premis.destroy', $p->id) }}" method="POST"
                                        onsubmit="return confirm('Padam premis {{ addslashes($p->nama_premis) }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-danger border-0 bg-danger bg-opacity-10"
                                            title="Padam">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top bg-light rounded-bottom-3">
                <small class="text-muted">
                    Memaparkan <span class="fw-semibold text-dark">{{ $premis->firstItem() }}</span>
                    hingga <span class="fw-semibold text-dark">{{ $premis->lastItem() }}</span>
                    daripada <span class="fw-semibold text-dark">{{ $premis->total() }}</span> rekod
                </small>
                <div>
                    {{ $premis->appends(request()->query())->links() }}
                </div>
            </div>

            @else
            {{-- Empty State --}}
            <div class="text-center py-5 px-4">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 bg-light"
                     style="width:72px;height:72px;">
                    <i class="bi bi-search text-muted fs-2"></i>
                </div>
                <h5 class="text-muted fw-semibold">Tiada rekod dijumpai</h5>
                <p class="text-muted mb-4 small">Sila ubah carian anda atau tambah premis baru.</p>
                @if(!request()->anyFilled(['search','premis_id','negeri','status','tarikh_dari','tarikh_hingga']))
                    <a href="{{ route('admin.premis.create') }}" class="btn text-white" style="background-color: var(--primary-color); border-color: var(--primary-color);">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Premis
                    </a>
                @else
                    <a href="{{ route('admin.premis.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Tapisan
                    </a>
                @endif
            </div>
            @endif
        </div>
    </div>

</div>

{{-- PDF Preview Modal --}}
<div class="modal fade" id="modalPDF" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header border-bottom px-4">
                <h5 class="modal-title fw-semibold d-flex align-items-center gap-2">
                    <i class="bi bi-file-pdf-fill text-danger"></i>
                    Pratonton D.A.3 —
                    <span id="modalPremisNama" class="text-primary"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0" style="background:#f0f0f0;">
                <iframe id="pdfFrame" src="" width="100%" style="border:none;display:block;height:60vh;min-height:400px;"></iframe>
            </div>
            <div class="modal-footer border-top px-4 bg-light rounded-bottom-3">
                <a id="pdfDownload" href="#" class="btn btn-danger d-flex align-items-center gap-2">
                    <i class="bi bi-download"></i> Muat Turun PDF
                </a>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
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
    const url = `/admin/premis/${id}/export-pdf`;
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
@endsection