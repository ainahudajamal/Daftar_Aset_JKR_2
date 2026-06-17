@extends('layouts.app')

@section('title', 'Lihat Komponen Utama')

@section('content')

        <div class="card">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">BORANG PENGUMPULAN DATA DAFTAR ASET KHUSUS</h5>
                    <small>Peringkat Komponen Utama</small>
                </div>
                <div>
                    <a href="{{ route('main-components.edit', $mainComponent) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                                        <a href="{{ route('export.main-component.pdf', $mainComponent) }}" class="btn btn-danger">
                        <i class="bi bi-file-pdf"></i> Download PDF
                    </a>
                    <a href="{{ route('components.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">

                <!-- MAKLUMAT KOMPONEN UTAMA -->
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        MAKLUMAT KOMPONEN UTAMA
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <strong>Nama Premis:</strong>
                                <p class="mb-0">{{ $mainComponent->component->nama_premis ?? '-' }}</p>
                            </div>
                            <div class="col-md-4">
                                <strong>Nombor DPA:</strong>
                                <p class="mb-0">{{ $mainComponent->component->nombor_dpa ?? '-' }}</p>
                            </div>
                            <div class="col-md-4">
                                <strong>Kod Lokasi:</strong>
                                <p class="mb-0">{{ $mainComponent->kod_lokasi ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="card mb-3" style="background: #f8f9fa;">
                            <div class="card-header bg-dark text-white">
                                <strong>Maklumat Utama</strong>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <strong>Nama Komponen Utama:</strong>
                                        <p class="mb-0 text-primary fw-bold">{{ $mainComponent->nama_komponen_utama }}</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <strong>Sistem:</strong>
                                        <p class="mb-0">{{ $mainComponent->sistem ?? '-' }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>SubSistem:</strong>
                                        <p class="mb-0">{{ $mainComponent->subsistem ?? '-' }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Kuantiti:</strong>
                                        <p class="mb-0">{{ $mainComponent->kuantiti ?? 1 }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>No Perolehan (1GFMAS)</strong>
                                        <p class="mb-0">{{ $mainComponent->no_perolehan_1gfmas ?? '-' }}</p> 
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bidang Kejuruteraan -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <strong>Bidang Kejuruteraan Komponen:</strong>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $mainComponent->bidang_kejuruteraan_string ?: '-' }}</p>
                            </div>
                        </div>

                        @if($mainComponent->catatan)
                        <div class="mb-3">
                            <strong>Catatan:</strong>
                            <p class="mb-0">{{ $mainComponent->catatan }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- MAKLUMAT PEROLEHAN -->
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">
                        MAKLUMAT PEROLEHAN
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered table-sm">
                                    <tr>
                                        <td width="50%"><strong>Tarikh Perolehan</strong></td>
                                        <td>{{ $mainComponent->tarikh_perolehan?->format('d/m/Y') ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kos Perolehan/Kontrak</strong></td>
                                        <td>
                                        @php
                                            $kos = preg_replace('/[^0-9.]/', '', $mainComponent->kos_perolehan); // buang RM, koma, apa2 huruf
                                        @endphp

                                            {{ $kos !== '' ? 'RM ' . number_format((float)$kos, 2) : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>No. Pesanan Rasmi</strong></td>
                                        <td>{{ $mainComponent->no_pesanan_rasmi_kontrak ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kod PTJ</strong></td>
                                        <td>{{ $mainComponent->kod_ptj ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered table-sm">
                                    <tr>
                                        <td width="50%"><strong>Tarikh Dipasang</strong></td>
                                        <td>{{ $mainComponent->tarikh_dipasang?->format('d/m/Y') ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tarikh Waranti Tamat</strong></td>
                                        <td>
                                            {{ $mainComponent->tarikh_waranti_tamat?->format('d/m/Y') ?? '-' }}
                                            @if($mainComponent->is_warranty_expired)
                                                <span class="badge bg-danger">Tamat</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tarikh Tamat DLP</strong></td>
                                        <td>
                                            {{ $mainComponent->tarikh_tamat_dlp?->format('d/m/Y') ?? '-' }}
                                            @if($mainComponent->is_dlp_expired)
                                                <span class="badge bg-danger">Tamat</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jangka Hayat</strong></td>
                                        <td>{{ $mainComponent->jangka_hayat ? $mainComponent->jangka_hayat . ' Tahun' : '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Pengilang, Pembekal, Kontraktor -->
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header bg-light"><strong>Pengilang</strong></div>
                                    <div class="card-body">
                                        <p class="mb-0">{{ $mainComponent->nama_pengilang ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header bg-light"><strong>Pembekal</strong></div>
                                    <div class="card-body">
                                        <p class="mb-1"><strong>Nama:</strong> {{ $mainComponent->nama_pembekal ?? '-' }}</p>
                                        <p class="mb-1"><strong>Alamat:</strong> {{ $mainComponent->alamat_pembekal ?? '-' }}</p>
                                        <p class="mb-0"><strong>Tel:</strong> {{ $mainComponent->no_telefon_pembekal ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header bg-light"><strong>Kontraktor</strong></div>
                                    <div class="card-body">
                                        <p class="mb-1"><strong>Nama:</strong> {{ $mainComponent->nama_kontraktor ?? '-' }}</p>
                                        <p class="mb-1"><strong>Alamat:</strong> {{ $mainComponent->alamat_kontraktor ?? '-' }}</p>
                                        <p class="mb-0"><strong>Tel:</strong> {{ $mainComponent->no_telefon_kontraktor ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MAKLUMAT KOMPONEN -->
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">
                        MAKLUMAT KOMPONEN
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Deskripsi:</strong>
                                <p class="mb-0">{{ $mainComponent->deskripsi ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Status Komponen:</strong>
                                <p class="mb-0">
                                    @switch($mainComponent->status_komponen)
                                        @case('operational')
                                            <span class="badge bg-success">Beropreasi</span>
                                            @break
                                        @case('under_maintenance')
                                            <span class="badge bg-warning">Sedang Diselenggara</span>
                                            @break
                                        @case('rosak')
                                            <span class="badge bg-danger">Rosak</span>
                                            @break
                                        @case('retired')
                                            <span class="badge bg-secondary">Dilupuskan</span>
                                            @break
                                        @default
                                            <span class="badge bg-light text-dark">-</span>
                                    @endswitch
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Jenama:</strong>
                                <p class="mb-0">{{ $mainComponent->jenama ?? '-' }}</p>
                            </div>
                            <div class="col-md-4">
                                <strong>Model:</strong>
                                <p class="mb-0">{{ $mainComponent->model ?? '-' }}</p>
                            </div>
                            <div class="col-md-4">
                                <strong>No. Siri:</strong>
                                <p class="mb-0">{{ $mainComponent->no_siri ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <strong>No. Tag / Label:</strong>
                                <p class="mb-0">{{ $mainComponent->no_tag_label ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>No. Sijil Pendaftaran:</strong>
                                <p class="mb-0">{{ $mainComponent->no_sijil_pendaftaran ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MAKLUMAT ATRIBUT SPESIFIKASI -->
                <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    MAKLUMAT ATRIBUT SPESIFIKASI
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong>Jenis:</strong>
                        <p class="mb-0">{{ $mainComponent->jenis ?? '-' }}</p>
                        </div>
                <div class="col-md-3">
                    <strong>Bekalan Elektrik:</strong>
                    <p class="mb-0">{{ $mainComponent->bekalan_elektrik ?? '-' }}</p>
                        </div>
                <div class="col-md-3">
                    <strong>Bahan:</strong>
                    <p class="mb-0">{{ $mainComponent->bahan ?? '-' }}</p>
                </div>
                <div class="col-md-3">
                    <strong>Kaedah Pemasangan:</strong>
                    <p class="mb-0">{{ $mainComponent->kaedah_pemasangan ?? '-' }}</p>
                </div>
            </div>

                <!-- MEASUREMENTS - UPDATED TO USE NEW TABLE -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Saiz Fizikal:</strong>
                        @php
                            $saizMeasurements = $mainComponent->saizMeasurements ?? collect();
                        @endphp
                        @if($saizMeasurements->isNotEmpty())
                            <ul class="mb-0 ps-3">
                                @foreach($saizMeasurements as $measurement)
                                    <li>{{ $measurement->value }} {{ $measurement->unit }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="mb-0">-</p>
                        @endif
            </div>
            <div class="col-md-4">
                <strong>Kadaran:</strong>
                @php
                    $kadaranMeasurements = $mainComponent->kadaranMeasurements ?? collect();
                @endphp
                @if($kadaranMeasurements->isNotEmpty())
                    <ul class="mb-0 ps-3">
                        @foreach($kadaranMeasurements as $measurement)
                            <li>{{ $measurement->value }} {{ $measurement->unit }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="mb-0">-</p>
                @endif
            </div>
            <div class="col-md-4">
                <strong>Kapasiti:</strong>
                @php
                    $kapasitiMeasurements = $mainComponent->kapasitiMeasurements ?? collect();
                @endphp
                @if($kapasitiMeasurements->isNotEmpty())
                    <ul class="mb-0 ps-3">
                        @foreach($kapasitiMeasurements as $measurement)
                            <li>{{ $measurement->value }} {{ $measurement->unit }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="mb-0">-</p>
                @endif
            </div>
        </div>

        @if($mainComponent->catatan_atribut)
        <div class="mt-3">
            <strong>Catatan:</strong>
            <p class="mb-0">{{ $mainComponent->catatan_atribut }}</p>
        </div>
        @endif
    </div>
</div>

                <!-- KOMPONEN YANG BERHUBUNGKAIT -->
                @if($mainComponent->relatedComponents && $mainComponent->relatedComponents->count() > 0)
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">
                        KOMPONEN YANG BERHUBUNGKAIT
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Bil</th>
                                    <th>Nama Komponen</th>
                                    <th>No. DPA / Kod Ruang</th>
                                    <th>No. Tag / Label</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mainComponent->relatedComponents as $related)
                                <tr>
                                    <td>{{ $related->bil }}</td>
                                    <td>{{ $related->nama_komponen }}</td>
                                    <td>{{ $related->no_dpa_kod_ruang ?? '-' }}</td>
                                    <td>{{ $related->no_tag_label ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($mainComponent->catatan_komponen_berhubung)
                        <p class="mb-0"><strong>Catatan:</strong> {{ $mainComponent->catatan_komponen_berhubung }}</p>
                        @endif
                    </div>
                </div>
                @endif

                <!-- DOKUMEN BERKAITAN -->
                @if($mainComponent->relatedDocuments && $mainComponent->relatedDocuments->count() > 0)
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">
                        DOKUMEN BERKAITAN
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Bil</th>
                                    <th>Nama Dokumen</th>
                                    <th>No. Rujukan</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mainComponent->relatedDocuments as $doc)
                                <tr>
                                    <td>{{ $doc->bil }}</td>
                                    <td>{{ $doc->nama_dokumen }}</td>
                                    <td>{{ $doc->no_rujukan_berkaitan ?? '-' }}</td>
                                    <td>{{ $doc->catatan ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($mainComponent->catatan_dokumen)
                        <p class="mb-0"><strong>Catatan:</strong> {{ $mainComponent->catatan_dokumen }}</p>
                        @endif
                    </div>
                </div>
                @endif

                <!-- NOTA & STATUS -->
                <div class="row">
                    <div class="col-md-9">
                        @if($mainComponent->nota)
                        <strong>Nota Tambahan:</strong>
                        <p>{{ $mainComponent->nota }}</p>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <strong>Status:</strong>
                        <p>
                            @if($mainComponent->status == 'aktif')
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Tidak Aktif</span>
                            @endif
                        </p>
                    </div>
                </div>

                <!-- SUB COMPONENTS -->
                @if($mainComponent->subComponents && $mainComponent->subComponents->count() > 0)
                <div class="card mt-4">
                    <div class="card-header bg-info text-white">
                        <strong>SUB KOMPONEN ({{ $mainComponent->subComponents->count() }})</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nama Sub Komponen</th>
                                    <th>Jenama</th>
                                    <th>Model</th>
                                    <th>Status</th>
                                    <th>Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mainComponent->subComponents as $index => $sub)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $sub->nama_sub_komponen }}</td>
                                    <td>{{ $sub->jenama ?? '-' }}</td>
                                    <td>{{ $sub->model ?? '-' }}</td>
                                    <td>
                                        @if($sub->status == 'aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('sub-components.show', $sub) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection