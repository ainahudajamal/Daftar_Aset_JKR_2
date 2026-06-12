@extends('layouts.app')

@section('title', 'Borang D.A.4')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2 class="mb-1"><i class="bi bi-building"></i> Borang D.A.4</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Borang D.A.4</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.blok.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg"></i> Tambah Baru
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row g-3 mb-4 row-cols-1 row-cols-md-3">
        <div class="col">
            <div class="card bg-primary text-white h-100 border-0 shadow-sm rounded-3">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="bg-white bg-opacity-25 p-2 rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-bank fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="mb-0 text-white-50" style="font-size: 0.8rem;">Premis Berdaftar</h6>
                        <h4 class="mb-0 fw-bold">{{ $totalPremisDa4 ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card text-white h-100 border-0 shadow-sm rounded-3" style="background-color: #6f42c1;">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="bg-white bg-opacity-25 p-2 rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-grid-fill fs-4"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="mb-0 text-white-50" style="font-size: 0.8rem;">Jumlah Blok</h6>
                        <h4 class="mb-0 fw-bold">{{ $totalBlok ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card bg-info text-dark h-100 border-0 shadow-sm rounded-3">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="bg-dark bg-opacity-10 p-2 rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-house-gear fs-4 text-dark"></i>
                        </div>
                    </div>
                    <div>
                        <h6 class="mb-0 text-dark text-opacity-75" style="font-size: 0.8rem;">Jumlah Binaan Luar</h6>
                        <h4 class="mb-0 fw-bold">{{ $totalBinaanLuar ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-sm mb-4 border-0 bg-light">
        <div class="card-body p-4">
            <form action="{{ route('admin.blok.index') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="search" class="form-label text-muted small fw-semibold mb-1">Carian</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" class="form-control border-start-0" id="search" name="search" 
                                   placeholder="No. DPA atau Nama Premis..." 
                                   value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="negeri" class="form-label text-muted small fw-semibold mb-1">Negeri</label>
                        <select class="form-select" id="negeri" name="negeri">
                            <option value="">Semua Negeri</option>
                            @foreach(\App\Models\Premis::whereNotNull('negeri')->where('negeri', '!=', '')->distinct()->orderBy('negeri')->pluck('negeri') as $n)
                                <option value="{{ $n }}" {{ request('negeri') == $n ? 'selected' : '' }}>{{ $n }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="status" class="form-label text-muted small fw-semibold mb-1">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Semua</option>
                            <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-dark flex-grow-1">
                                <i class="bi bi-funnel"></i> Tapis
                            </button>
                            @if(request()->anyFilled(['search', 'negeri', 'status']))
                                <a href="{{ route('admin.blok.index') }}" class="btn btn-outline-secondary" title="Reset Tapisan">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

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
                    onclick="previewPdf({{ $premis->id }}, '{{ addslashes($premis->nama_premis) }}')">
                    <i class="bi bi-file-pdf"></i> PDF
                </button>
                <form action="{{ route('admin.blok.destroy', $premis->id) }}" method="POST"
                    onsubmit="return confirm('Padam semua blok dan binaan luar untuk {{ addslashes($premis->nama_premis) }}?')">
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
                            <td><span class="badge" style="background-color:#0d6efd;">Blok</span></td>
                            <td>{{ $blok->nama_blok }}</td>
                            <td>{{ $blok->fungsi_binaan ?? '-' }}</td>
                            <td>{{ $blok->luas_tapak ?? '-' }}</td>
                            <td>{{ $blok->kod_blok_myspata ?? '-' }}</td>
                        </tr>
                        @endforeach
                        @foreach($premis->binaanLuar as $index => $binaan)
                        <tr>
                            <td class="text-center">{{ $premis->blok->count() + $index + 1 }}</td>
                            <td><span class="badge" style="background-color:#198754;">Binaan Luar</span></td>
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
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-file-pdf-fill text-danger me-2"></i>Pratonton Konfigurasi Blok — <span id="modalPremisNama" class="text-primary"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0 bg-secondary">
                <iframe id="pdfFrame" src="" width="100%" height="650px" style="border: none;"></iframe>
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
function previewPdf(id, nama) {
    const url = `/admin/blok/${id}/export-pdf`;
    document.getElementById('pdfFrame').src = url;
    document.getElementById('pdfDownload').href = url;
    document.getElementById('modalPremisNama').textContent = nama;
    new bootstrap.Modal(document.getElementById('modalPDF')).show();
}
</script>
@endpush