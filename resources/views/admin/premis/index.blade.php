@extends('layouts.app')

@section('title', 'Borang D.A.3')

@section('content')
<div class="container-fluid px-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-start mb-4 pt-2">
        <div>
            <h2 class="mb-1 fw-bold" style="color: #1e293b;">
                <i class="bi bi-file-earmark-text me-2" style="color: var(--primary);"></i>Borang D.A.3
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted">
                            <i class="bi bi-house-door me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item active fw-semibold" style="color: var(--primary);">Borang D.A.3</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.premis.create') }}" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm px-4">
            <i class="bi bi-plus-circle-fill"></i>
            <span>Tambah Premis</span>
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
                        <div class="text-uppercase fw-semibold mb-1" style="font-size:0.72rem;letter-spacing:.06em; color: var(--primary);">Jumlah Premis</div>
                        <div class="fw-bold lh-1" style="font-size:2rem; color: var(--primary);">{{ $totalPremis ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0 h-100" style="background: linear-gradient(135deg, rgba(16,185,129,0.12), rgba(16,185,129,0.05)); border-left: 4px solid var(--success) !important;">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:52px;height:52px;background: rgba(16,185,129,0.15);">
                        <i class="bi bi-check2-circle fs-4" style="color: var(--success);"></i>
                    </div>
                    <div>
                        <div class="text-uppercase fw-semibold mb-1" style="font-size:0.72rem;letter-spacing:.06em; color: var(--success);">Premis Aktif</div>
                        <div class="fw-bold lh-1" style="font-size:2rem; color: var(--success);">{{ $aktifPremis ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0 h-100" style="background: linear-gradient(135deg, rgba(239,68,68,0.12), rgba(239,68,68,0.05)); border-left: 4px solid var(--danger) !important;">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:52px;height:52px;background: rgba(239,68,68,0.15);">
                        <i class="bi bi-x-circle fs-4" style="color: var(--danger);"></i>
                    </div>
                    <div>
                        <div class="text-uppercase fw-semibold mb-1" style="font-size:0.72rem;letter-spacing:.06em; color: var(--danger);">Tidak Aktif</div>
                        <div class="fw-bold lh-1" style="font-size:2rem; color: var(--danger);">{{ $tidakAktifPremis ?? 0 }}</div>
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
                    <button type="submit" class="btn btn-primary px-4">
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

        {{-- Table header --}}
        <div class="px-4 py-3 d-flex justify-content-between align-items-center border-bottom">
            <span class="fw-semibold text-muted small text-uppercase" style="letter-spacing:.04em;">Senarai Premis</span>
            <span class="badge bg-primary rounded-pill">{{ $premis->total() }} rekod</span>
        </div>

        <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.88rem; min-width: 900px;">
                <thead style="background-color: var(--primary); color: white;">
                    <tr>
                        <th class="ps-4 py-3 fw-semibold" style="width:45px;">Bil</th>
                        <th class="py-3 fw-semibold" style="width:160px;">No. DPA</th>
                        <th class="py-3 fw-semibold">Nama Premis</th>
                        <th class="py-3 fw-semibold" style="width:120px;">Negeri</th>
                        <th class="py-3 fw-semibold text-center" style="width:110px;">Status</th>
                        <th class="py-3 fw-semibold" style="width:110px;">Tarikh Daftar</th>
                        <th class="pe-4 py-3 fw-semibold text-center" style="width:150px;">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($premis as $index => $p)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td class="ps-4 text-muted">{{ $premis->firstItem() + $index }}</td>

                        <td style="max-width:160px;">
                            @if($p->no_dpa)
                                <code class="text-muted d-block text-truncate" style="font-size:0.75rem;"
                                      title="{{ $p->no_dpa }}">{{ $p->no_dpa }}</code>
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
                                    <i class="bi bi-geo-alt me-1"></i>{{ Str::limit($p->alamat_premis, 40) }}
                                </small>
                            @endif
                        </td>

                        <td style="max-width:120px;">
                            <small class="text-dark d-block text-truncate" title="{{ $p->negeri ?? '' }}">{{ $p->negeri ?? '—' }}</small>
                        </td>

                        <td class="text-center">
                            @if($p->status_premis == 'Aktif')
                                <span class="badge bg-success px-3">Aktif</span>
                            @else
                                <span class="badge bg-secondary px-3">Tidak Aktif</span>
                            @endif
                        </td>

                        <td><small class="text-muted">{{ $p->created_at ? $p->created_at->format('d/m/Y') : '—' }}</small></td>

                        <td class="pe-4">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('admin.premis.show', $p->id) }}"
                                   class="btn btn-sm btn-primary px-2" title="Lihat">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.premis.edit', $p->id) }}"
                                   class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <button type="button"
                                    class="btn btn-sm btn-outline-danger"
                                    data-id="{{ $p->id }}"
                                    data-nama="{{ $p->nama_premis }}"
                                    onclick="previewPdfFromBtn(this)"
                                    title="PDF">
                                    <i class="bi bi-file-pdf-fill"></i>
                                </button>
                                <form action="{{ route('admin.premis.destroy', $p->id) }}" method="POST"
                                    data-nama="{{ $p->nama_premis }}"
                                    onsubmit="return confirm('Padam premis ' + this.dataset.nama + '?')" class="mb-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Padam">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="text-center py-5">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                     style="width:70px;height:70px; background: rgba(37,99,235,0.08);">
                                    <i class="bi bi-inbox fs-2" style="color: var(--primary);"></i>
                                </div>
                                <h6 class="text-muted fw-semibold">Tiada rekod dijumpai</h6>
                                <p class="text-muted small mb-3">Cuba ubah tapisan atau tambah premis baru.</p>
                                @if(!request()->anyFilled(['search','premis_id','negeri','status','tarikh_dari','tarikh_hingga']))
                                    <a href="{{ route('admin.premis.create') }}" class="btn btn-primary btn-sm px-4">
                                        <i class="bi bi-plus-lg me-1"></i> Tambah Premis
                                    </a>
                                @else
                                    <a href="{{ route('admin.premis.index') }}" class="btn btn-outline-secondary btn-sm px-4">
                                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Tapisan
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($premis->hasPages())
        <div class="card-footer bg-white border-top px-4 py-3 d-flex justify-content-between align-items-center rounded-bottom-3">
            <small class="text-muted">
                Menunjukkan <span class="fw-semibold text-dark">{{ $premis->firstItem() }}</span>–<span class="fw-semibold text-dark">{{ $premis->lastItem() }}</span>
                daripada <span class="fw-semibold text-dark">{{ $premis->total() }}</span> rekod
            </small>
            {{ $premis->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

</div>

{{-- PDF Preview Modal --}}
<div class="modal fade" id="modalPDF" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header" style="background-color: var(--primary);">
                <h5 class="modal-title fw-bold text-white d-flex align-items-center gap-2">
                    <i class="bi bi-file-pdf-fill"></i>
                    Pratonton D.A.3 — <span id="modalPremisNama"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0" style="background:#f0f0f0;">
                <iframe id="pdfFrame" src="" width="100%" style="border:none;display:block;height:65vh;min-height:450px;"></iframe>
            </div>
            <div class="modal-footer border-top px-4 bg-light rounded-bottom-3">
                <a id="pdfDownload" href="#" class="btn btn-danger d-flex align-items-center gap-2">
                    <i class="bi bi-download"></i> Muat Turun PDF
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
        document.body.appendChild(modalEl);
        modalEl.addEventListener('hidden.bs.modal', function() {
            const frame = document.getElementById('pdfFrame');
            if (frame) frame.src = '';
        });
    }
});

function previewPdf(id, nama) {
    const base = '{{ rtrim(url("/"), "/") }}';
    const url = `${base}/admin/premis/${id}/export-pdf`;
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

function previewPdfFromBtn(btn) {
    previewPdf(btn.dataset.id, btn.dataset.nama);
}
</script>
@endsection