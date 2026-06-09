@extends('layouts.app')

@section('title', 'Konfigurasi Premis')

@section('content')
<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="bi bi-bank"></i> Konfigurasi Premis</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Premis</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.premis.create') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle"></i> Tambah Premis
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Table Premis -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="bi bi-list-ul"></i> Senarai Premis</h5>
        </div>
        <div class="card-body">

            @if($premis->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Bil</th>
                            <th>No. DPA</th>
                            <th>Nama Premis</th>
                            <th>Negeri</th>
                            <th>Status</th>
                            <th>Bil. Blok</th>
                            <th>Bil. Binaan Luar</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($premis as $index => $p)
                        <tr>
                            <td>{{ $premis->firstItem() + $index }}</td>
                            <td>
                                @if($p->no_dpa)
                                    <span class="badge bg-secondary">{{ $p->no_dpa }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.premis.show', $p->id) }}" class="fw-semibold text-decoration-none">
                                    {{ $p->nama_premis }}
                                </a>
                                @if($p->alamat_premis)
                                <br><small class="text-muted">{{ Str::limit($p->alamat_premis, 50) }}</small>
                                @endif
                            </td>
                            <td>{{ $p->negeri ?? '—' }}</td>
                            <td>
                                @if($p->status_premis == 'Aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td><span class="badge bg-primary">{{ $p->bil_blok_bangunan ?? 0 }}</span></td>
                            <td><span class="badge bg-info text-dark">{{ $p->bil_binaan_luar ?? 0 }}</span></td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.premis.show', $p->id) }}" class="btn btn-sm btn-outline-info" title="Lihat">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.premis.edit', $p->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="previewPdf({{ $p->id }}, '{{ $p->nama_premis }}')" title="Preview PDF">
                                        <i class="bi bi-file-pdf"></i>
                                    </button>
                                    <form action="{{ route('admin.premis.destroy', $p->id) }}" method="POST"
                                        onsubmit="return confirm('Padam premis {{ $p->nama_premis }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Padam">
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

            <!-- Pagination -->
            <div class="d-flex justify-content-end mt-3">
                {{ $premis->links() }}
            </div>

            @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-bank" style="font-size: 3rem;"></i>
                <p class="mt-3 mb-3">Tiada rekod premis dijumpai.</p>
                <a href="{{ route('admin.premis.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Premis Pertama
                </a>
            </div>
            @endif

        </div>
    </div>

</div>

<!-- Modal Preview PDF -->
<div class="modal fade" id="modalPDF" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPDFLabel">
                    <i class="bi bi-file-pdf text-danger"></i> Pratonton D.A.3 — <span id="modalPremisNama"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <iframe id="pdfFrame" src="" width="100%" height="650px" style="border: none;"></iframe>
            </div>
            <div class="modal-footer">
                <a id="pdfDownload" href="#" class="btn btn-success">
                    <i class="bi bi-download"></i> Muat Turun PDF
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function previewPdf(id, nama) {
    const url = `/admin/premis/${id}/export-pdf`;
    document.getElementById('pdfFrame').src = url;
    document.getElementById('pdfDownload').href = url;
    document.getElementById('modalPremisNama').textContent = nama;
    new bootstrap.Modal(document.getElementById('modalPDF')).show();
}
</script>
@endsection