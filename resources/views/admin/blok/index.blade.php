@extends('layouts.app')

@section('title', 'Konfigurasi Blok & Binaan Luar')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2 class="mb-1"><i class="bi bi-building"></i> Konfigurasi Blok & Binaan Luar</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Konfigurasi Blok</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.blok.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Baru
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @forelse($bloks as $premis)
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header py-2 d-flex justify-content-between align-items-center" style="background-color:#4a5568;">
            <div>
                <span class="text-white fw-semibold">
                    <i class="bi bi-geo-alt-fill me-2"></i>{{ $premis->nama_premis }}
                </span>
                @if($premis->no_dpa)
                <span class="badge bg-light text-dark ms-2">No. DPA: {{ $premis->no_dpa }}</span>
                @endif
            </div>
            <div class="d-flex gap-2 align-items-center">
                <span class="badge bg-primary">{{ $premis->blok->count() }} Blok</span>
                <span class="badge bg-success">{{ $premis->binaanLuar->count() }} Binaan Luar</span>
                <a href="{{ route('admin.blok.edit', $premis->id) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <button type="button" class="btn btn-danger btn-sm"
                    onclick="previewPdf({{ $premis->id }}, '{{ $premis->nama_premis }}')">
                    <i class="bi bi-file-pdf"></i> PDF
                </button>
                <form action="{{ route('admin.blok.destroy', $premis->id) }}" method="POST"
                    onsubmit="return confirm('Padam semua blok dan binaan luar untuk {{ $premis->nama_premis }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:50px;">Bil</th>
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
                            <td><span class="badge" style="background-color:#0d6efd;">Blok</span></td>
                            <td>{{ $blok->nama_blok }}</td>
                            <td>{{ $blok->fungsi_binaan ?? '-' }}</td>
                            <td>{{ $blok->luas_tapak ?? '-' }}</td>
                            <td>{{ $blok->kod_blok_myspata ?? '-' }}</td>
                        </tr>
                        @endforeach
                        @foreach($premis->binaanLuar as $index => $binaan)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td><span class="badge" style="background-color:#198754;">Binaan Luar</span></td>
                            <td>{{ $binaan->nama_binaan_luar }}</td>
                            <td>{{ $binaan->jenis_binaan_luar ?? '-' }}</td>
                            <td>{{ $binaan->luas_tapak ?? '-' }}</td>
                            <td>{{ $binaan->kod_binaan_luar_myspata ?? '-' }}</td>
                        </tr>
                        @endforeach
                        @if($premis->blok->count() == 0 && $premis->binaanLuar->count() == 0)
                        <tr>
                            <td colspan="6" class="text-center text-muted">Tiada data</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @empty
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5">
            <i class="bi bi-inbox display-4 text-muted"></i>
            <p class="mt-3 text-muted">Tiada rekod blok atau binaan luar dijumpai.</p>
            <a href="{{ route('admin.blok.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Tambah Sekarang
            </a>
        </div>
    </div>
    @endforelse

    <div class="d-flex justify-content-end mt-3">
        {{ $bloks->links() }}
    </div>

</div>

<!-- Modal Preview PDF -->
<div class="modal fade" id="modalPDF" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-file-pdf text-danger"></i> Pratonton Konfigurasi Blok — <span id="modalPremisNama"></span>
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

@push('scripts')
<script>
function previewPdf(id, nama) {
    const url = `/admin/blok/${id}/export-pdf`;
    document.getElementById('pdfFrame').src = url;
    document.getElementById('pdfDownload').href = url;
    document.getElementById('modalPremisNama').textContent = nama;
    new bootstrap.Modal(document.getElementById('modalPDF')).show();
}
</script>
@endpush