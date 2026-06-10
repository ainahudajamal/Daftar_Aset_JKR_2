@extends('layouts.app')

@section('title', 'Butiran Premis')

@section('content')
<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="bi bi-building"></i> Butiran Premis</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.premis.index') }}">Premis</a></li>
                    <li class="breadcrumb-item active">Butiran</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-danger"
                onclick="previewPdf({{ $premis->id }}, '{{ $premis->nama_premis }}')">
                <i class="bi bi-file-pdf"></i> PDF
            </button>
            <a href="{{ route('admin.premis.edit', $premis->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('admin.premis.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Helaian 1 -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">D.A.3 — KAD PENDAFTARAN ASET TAK ALIH (Premis Hak Milik)</h5>
            <small>Helaian 1</small>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <td width="25%" class="fw-semibold bg-light">Nama Premis</td>
                    <td>{{ $premis->nama_premis ?? '-' }}</td>
                    <td width="25%" class="fw-semibold bg-light">No. DPA</td>
                    <td>{{ $premis->no_dpa ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="fw-semibold bg-light">Alamat Premis</td>
                    <td colspan="3">{{ $premis->alamat_premis ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="fw-semibold bg-light">Poskod</td>
                    <td>{{ $premis->poskod ?? '-' }}</td>
                    <td class="fw-semibold bg-light">Koordinat GPS</td>
                    <td>X: {{ $premis->koordinat_x ?? '-' }} ; Y: {{ $premis->koordinat_y ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="fw-semibold bg-light">Kumpulan Agensi</td>
                    <td>{{ $premis->kumpulan_agensi ?? '-' }}</td>
                    <td class="fw-semibold bg-light">Daerah</td>
                    <td>{{ $premis->daerah ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="fw-semibold bg-light">Kementerian</td>
                    <td>{{ $premis->kementerian ?? '-' }}</td>
                    <td class="fw-semibold bg-light">Mukim / Bandar</td>
                    <td>{{ $premis->mukim_bandar ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="fw-semibold bg-light">Jabatan</td>
                    <td>{{ $premis->jabatan ?? '-' }}</td>
                    <td class="fw-semibold bg-light">Kategori Premis</td>
                    <td>{{ $premis->kategori_premis ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="fw-semibold bg-light">Negara</td>
                    <td>{{ $premis->negara ?? '-' }}</td>
                    <td class="fw-semibold bg-light">Sub Kategori</td>
                    <td>{{ $premis->sub_kategori ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="fw-semibold bg-light">Negeri</td>
                    <td>{{ $premis->negeri ?? '-' }}</td>
                    <td class="fw-semibold bg-light">Jumlah Keluasan Premis</td>
                    <td>{{ $premis->jumlah_keluasan ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="fw-semibold bg-light">Status Premis</td>
                    <td>
                        @if($premis->status_premis == 'Aktif')
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Tidak Aktif</span>
                        @endif
                    </td>
                    <td class="fw-semibold bg-light">Aset Warisan</td>
                    <td>{{ $premis->aset_warisan ? 'Ya' : 'Tidak' }}</td>
                </tr>
                <tr>
                    <td class="fw-semibold bg-light">Kos Siap Bina Asal</td>
                    <td>{{ $premis->kos_siap_bina_asal ? 'RM ' . number_format($premis->kos_siap_bina_asal, 2) : '-' }}</td>
                    <td class="fw-semibold bg-light">Sumber Pembiayaan</td>
                    <td>{{ $premis->sumber_pembiayaan ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="fw-semibold bg-light">Kos Tambahan (PPUN)</td>
                    <td>{{ $premis->kos_tambahan_ppun ? 'RM ' . number_format($premis->kos_tambahan_ppun, 2) : '-' }}</td>
                    <td class="fw-semibold bg-light">Kod PTJ</td>
                    <td>{{ $premis->kod_ptj ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="fw-semibold bg-light">Kos Keseluruhan Aset</td>
                    <td>{{ $premis->kos_keseluruhan ? 'RM ' . number_format($premis->kos_keseluruhan, 2) : '-' }}</td>
                    <td class="fw-semibold bg-light">Nilai Semasa</td>
                    <td>{{ $premis->nilai_semasa ? 'RM ' . number_format($premis->nilai_semasa, 2) : '-' }}</td>
                </tr>
                <tr>
                    <td class="fw-semibold bg-light">Tarikh Siap Bina</td>
                    <td>{{ $premis->tarikh_siap_bina ? $premis->tarikh_siap_bina->format('d/m/Y') : '-' }}</td>
                    <td class="fw-semibold bg-light">Tarikh Penilaian</td>
                    <td>{{ $premis->tarikh_penilaian ? $premis->tarikh_penilaian->format('d/m/Y') : '-' }}</td>
                </tr>
                <tr>
                    <td class="fw-semibold bg-light">Bil. Blok Bangunan</td>
                    <td>{{ $premis->bil_blok_bangunan ?? '0' }}</td>
                    <td class="fw-semibold bg-light">Bil. Binaan Luar</td>
                    <td>{{ $premis->bil_binaan_luar ?? '0' }}</td>
                </tr>
               <tr>
                    <td class="fw-semibold bg-light">Catatan</td>
                    <td colspan="3">{{ $premis->catatan ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="fw-semibold bg-light">Gambar Premis</td>
                    <td colspan="3">
                        @if($premis->gambar_premis)
                            <img src="{{ asset('storage/' . $premis->gambar_premis) }}"
                                alt="Gambar Premis" style="max-height: 200px; border-radius: 6px;">
                        @else
                            <span class="text-muted">Tiada gambar</span>
                        @endif
                    </td>
                </tr>
            </table>

            <!-- Tandatangan -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card border">
                        <div class="card-header bg-light fw-semibold">Pengumpul Data</div>
                        <div class="card-body">
                            <table class="table table-sm mb-0">
                                <tr>
                                    <td width="40%">Nama</td>
                                    <td>{{ $premis->pengumpul_nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Jawatan</td>
                                    <td>{{ $premis->pengumpul_jawatan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Tarikh</td>
                                    <td>{{ $premis->pengumpul_tarikh ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border">
                        <div class="card-header bg-light fw-semibold">Pengesah Data</div>
                        <div class="card-body">
                            <table class="table table-sm mb-0">
                                <tr>
                                    <td width="40%">Nama</td>
                                    <td>{{ $premis->pengesah_nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Jawatan</td>
                                    <td>{{ $premis->pengesah_jawatan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Tarikh</td>
                                    <td>{{ $premis->pengesah_tarikh ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Helaian 2 - Maklumat Tanah -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Maklumat Tanah</h5>
            <small>Helaian 2</small>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Bil</th>
                            <th>No. Lot</th>
                            <th>Status Hak Milik Tanah</th>
                            <th>Keluasan Tanah</th>
                            <th>No. Hakmilik</th>
                            <th>Jenis Hakmilik</th>
                            <th>Kegunaan Tanah</th>
                            <th>Harga Perolehan (RM)</th>
                            <th>Harga Semasa (RM)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($premis->tanah as $index => $tanah)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $tanah->no_lot ?? '-' }}</td>
                            <td>{{ $tanah->status_hakmilik ?? '-' }}</td>
                            <td>{{ $tanah->keluasan_tanah ?? '-' }}</td>
                            <td>{{ $tanah->no_hakmilik ?? '-' }}</td>
                            <td>{{ $tanah->jenis_hakmilik ?? '-' }}</td>
                            <td>{{ $tanah->kegunaan_tanah ?? '-' }}</td>
                            <td>{{ $tanah->harga_perolehan ? number_format($tanah->harga_perolehan, 2) : '-' }}</td>
                            <td>{{ $tanah->harga_semasa ? number_format($tanah->harga_semasa, 2) : '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Tiada maklumat tanah</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Senarai Lukisan Siap Bina -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Senarai Lukisan Siap Bina</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Bil</th>
                            <th>Bidang</th>
                            <th>Tajuk Lukisan</th>
                            <th>No. Rujukan</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($premis->lukisan as $index => $lukisan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $lukisan->bidang ?? '-' }}</td>
                            <td>{{ $lukisan->tajuk_lukisan ?? '-' }}</td>
                            <td>{{ $lukisan->no_rujukan ?? '-' }}</td>
                            <td>{{ $lukisan->catatan ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Tiada lukisan siap bina</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="d-flex gap-2 mb-4">
        <a href="{{ route('admin.premis.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

</div>

<!-- Modal Preview PDF -->
<div class="modal fade" id="modalPDF" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
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