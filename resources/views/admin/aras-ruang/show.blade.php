@php
    $da5_data = $record->toArray();
    if ($record->tarikh_siap_bina) {
        $da5_data['tarikh_siap_bina'] = $record->tarikh_siap_bina->format('d/m/Y');
    }
    if ($record->tarikh_penilaian) {
        $da5_data['tarikh_penilaian'] = $record->tarikh_penilaian->format('d/m/Y');
    }
@endphp
@extends('layouts.app')

@section('title', 'Borang D.A.5 - Butiran Maklumat')

@section('content')
<div class="container-fluid px-4">

    {{-- ===== PAGE HEADER ===== --}}
    <div class="d-flex justify-content-between align-items-start mb-4 pt-2">
        <div>
            <h2 class="mb-1 fw-bold text-dark">
                <i class="bi bi-layers-half me-2 text-primary"></i>Butiran Borang D.A.5
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.aras-ruang.index') }}">Borang D.A.5</a></li>
                    <li class="breadcrumb-item active">Butiran Maklumat</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            {{-- Preview PDF Button --}}
            <button type="button" class="btn btn-danger d-flex align-items-center gap-2 shadow-sm" 
                data-id="{{ $record->id }}" 
                data-nama="{{ $record->nama_premis ?? 'Manual' }}" 
                onclick="previewPdfFromBtn(this)">
                <i class="bi bi-file-pdf-fill"></i> Pratonton PDF
            </button>
            <a href="{{ route('admin.aras-ruang.edit', $record->id) }}" class="btn btn-warning d-flex align-items-center gap-2 shadow-sm">
                <i class="bi bi-pencil-fill"></i> Edit
            </a>
            <a href="{{ route('admin.aras-ruang.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2 shadow-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    {{-- ===== MAKLUMAT BORANG CARD ===== --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-dark d-flex align-items-center">
                <i class="bi bi-file-earmark-text-fill me-2 text-danger"></i>
                D.A.5 — KAD PENDAFTARAN ASET TAK ALIH (Blok / Binaan Luar)
            </h5>
        </div>
        <div class="card-body bg-light border-top">

            {{-- 1. MAKLUMAT PREMIS & BLOK --}}
            <div class="mb-4">
                <h6 class="fw-bold text-primary mb-3"><i class="bi bi-geo-alt-fill me-1"></i>1. Maklumat Premis & Blok / Binaan Luar</h6>
                <div class="table-responsive bg-white rounded-3 shadow-sm border">
                    <table class="table table-bordered mb-0 align-middle">
                        <tbody>
                            <tr>
                                <td width="20%" class="fw-semibold bg-light text-muted small">NAMA PREMIS</td>
                                <td width="30%">{{ $record->nama_premis ?? '—' }}</td>
                                <td width="20%" class="fw-semibold bg-light text-muted small">NO. DPA</td>
                                <td width="30%"><span class="font-monospace text-dark">{{ $record->no_dpa ?? '—' }}</span></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold bg-light text-muted small">KOD BLOK / BINAAN LUAR</td>
                                <td><span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle font-monospace px-3 py-1">{{ $record->kod_blok ?? '—' }}</span></td>
                                <td class="fw-semibold bg-light text-muted small">NAMA BLOK / BINAAN LUAR</td>
                                <td>{{ $record->nama_blok ?? '—' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold bg-light text-muted small">FUNGSI BINAAN (BLOK)</td>
                                <td>{{ $record->fungsi_binaan ?? '—' }}</td>
                                <td class="fw-semibold bg-light text-muted small">JENIS BINAAN LUAR</td>
                                <td>{{ $record->jenis_binaan ?? '—' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold bg-light text-muted small">KOORDINAT GPS</td>
                                <td colspan="3">
                                    <span class="text-muted">GPS X:</span> <strong>{{ $record->gps_x ?? '—' }}</strong> &nbsp;|&nbsp;
                                    <span class="text-muted">GPS Y:</span> <strong>{{ $record->gps_y ?? '—' }}</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <hr class="my-4">

            {{-- 2. KONTRAKTOR & JURU PERUNDING --}}
            <div class="mb-4">
                <div class="row g-4">
                    {{-- Kontraktor Column --}}
                    <div class="col-md-6">
                        <h6 class="fw-bold text-success mb-3"><i class="bi bi-people-fill me-1"></i>2.1 Kontraktor</h6>
                        <div class="bg-white rounded-3 shadow-sm border p-3">
                            <div class="mb-3">
                                <label class="text-muted small fw-semibold d-block">KONTRAKTOR UTAMA</label>
                                <span class="fw-bold text-dark fs-6">{{ $record->kontraktor_utama ?? '—' }}</span>
                                @if($record->bidang_kontraktor_utama)
                                    <small class="text-muted d-block">Bidang: {{ $record->bidang_kontraktor_utama }}</small>
                                @endif
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm mb-0">
                                    <thead class="table-light text-muted small">
                                        <tr>
                                            <th>Kontraktor (Tambahan)</th>
                                            <th style="width: 45%;">Bidang Kerja</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($record->kontraktor_list ?? [] as $k)
                                            @if(!empty($k['nama']) || !empty($k['bidang']))
                                                <tr>
                                                    <td class="small">{{ $k['nama'] ?? '—' }}</td>
                                                    <td class="small text-muted">{{ $k['bidang'] ?? '—' }}</td>
                                                </tr>
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center text-muted py-3 small">Tiada kontraktor tambahan didaftarkan</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Juru Perunding Column --}}
                    <div class="col-md-6">
                        <h6 class="fw-bold text-success mb-3"><i class="bi bi-people-fill me-1"></i>2.2 Juru Perunding</h6>
                        <div class="bg-white rounded-3 shadow-sm border p-3">
                            <div class="mb-3">
                                <label class="text-muted small fw-semibold d-block">JURU PERUNDING UTAMA</label>
                                <span class="fw-bold text-dark fs-6">{{ $record->juru_perunding_utama ?? '—' }}</span>
                                @if($record->bidang_juru_perunding_utama)
                                    <small class="text-muted d-block">Bidang: {{ $record->bidang_juru_perunding_utama }}</small>
                                @endif
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm mb-0">
                                    <thead class="table-light text-muted small">
                                        <tr>
                                            <th>Juru Perunding (Tambahan)</th>
                                            <th style="width: 45%;">Bidang Kerja</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($record->juru_perunding_list ?? [] as $jp)
                                            @if(!empty($jp['nama']) || !empty($jp['bidang']))
                                                <tr>
                                                    <td class="small">{{ $jp['nama'] ?? '—' }}</td>
                                                    <td class="small text-muted">{{ $jp['bidang'] ?? '—' }}</td>
                                                </tr>
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center text-muted py-3 small">Tiada juru perunding tambahan didaftarkan</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            {{-- 3. MAKLUMAT HELAIAN 1 (SPESIFIKASI & METADATA) --}}
            <div class="mb-4">
                <h6 class="fw-bold text-primary mb-3"><i class="bi bi-card-list me-1"></i>3. Spesifikasi & Butiran Fizikal</h6>
                <div class="table-responsive bg-white rounded-3 shadow-sm border">
                    <table class="table table-bordered mb-0 align-middle">
                        <tbody>
                            <tr>
                                <td width="20%" class="fw-semibold bg-light text-muted small">TAHUN SIAP BINA</td>
                                <td width="30%">{{ $record->tahun_siap_bina ?? '—' }}</td>
                                <td width="20%" class="fw-semibold bg-light text-muted small">TARIKH SIAP BINA</td>
                                <td width="30%">{{ $da5_data['tarikh_siap_bina'] ?? '—' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold bg-light text-muted small">FUNGSI ASAL</td>
                                <td>{{ $record->fungsi_asal ?? '—' }}</td>
                                <td class="fw-semibold bg-light text-muted small">JENIS STRUKTUR</td>
                                <td>{{ $record->jenis_struktur ?? '—' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold bg-light text-muted small">NO. SIRI PENDAFTARAN</td>
                                <td>{{ $record->no_siri_pendaftaran ?? '—' }}</td>
                                <td class="fw-semibold bg-light text-muted small">JANGKA HAYAT (TAHUN)</td>
                                <td>{{ $record->jangka_hayat ?? '—' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold bg-light text-muted small">KAPASITI PENGHUNI</td>
                                <td>{{ $record->kapasiti_penghuni ?? '—' }}</td>
                                <td class="fw-semibold bg-light text-muted small">KOS BINA ASAL</td>
                                <td>
                                    @if(isset($record->kos_bina_asal) && $record->kos_bina_asal !== '')
                                        <strong>RM {{ number_format((float)$record->kos_bina_asal, 2) }}</strong>
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold bg-light text-muted small">NILAI SEMASA ASET</td>
                                <td>
                                    @if(isset($record->nilai_semasa) && $record->nilai_semasa !== '')
                                        <strong>RM {{ number_format((float)$record->nilai_semasa, 2) }}</strong>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="fw-semibold bg-light text-muted small">TARIKH PENILAIAN ASET</td>
                                <td>{{ $da5_data['tarikh_penilaian'] ?? '—' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold bg-light text-muted small">SUMBER PEMBIAYAAN</td>
                                <td>{{ $record->sumber_pembiayaan ?? '—' }}</td>
                                <td class="fw-semibold bg-light text-muted small">KOD PTJ</td>
                                <td><span class="font-monospace text-dark">{{ $record->kod_ptj ?? '—' }}</span></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold bg-light text-muted small">PENGGUNAAN TENAGA (KWH)</td>
                                <td>
                                    @if(isset($record->penggunaan_tenaga) && $record->penggunaan_tenaga !== '')
                                        {{ number_format((float)$record->penggunaan_tenaga, 2) }} kWh
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="fw-semibold bg-light text-muted small">PENGGUNAAN AIR (M³)</td>
                                <td>
                                    @if(isset($record->penggunaan_air) && $record->penggunaan_air !== '')
                                        {{ number_format((float)$record->penggunaan_air, 2) }} m³
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold bg-light text-muted small">JENIS MILIKAN</td>
                                <td>{{ $record->jenis_milikan ?? '—' }}</td>
                                <td class="fw-semibold bg-light text-muted small">ASET WARISAN</td>
                                <td>
                                    @if($record->aset_warisan)
                                        <span class="badge bg-warning text-dark border border-warning px-3 py-1"><i class="bi bi-shield-fill-check me-1"></i>Ya</span>
                                    @else
                                        <span class="badge bg-light text-muted border px-3 py-1">Tidak</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold bg-light text-muted small">BIL. ARAS ATAS</td>
                                <td>{{ $record->bil_aras_atas ?? '—' }}</td>
                                <td class="fw-semibold bg-light text-muted small">BIL. ARAS BAWAH</td>
                                <td>{{ $record->bil_aras_bawah ?? '—' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold bg-light text-muted small">JUMLAH LUAS LANTAI (M²)</td>
                                <td>
                                    @if(isset($record->jumlah_luas_lantai) && $record->jumlah_luas_lantai !== '')
                                        {{ number_format((float)$record->jumlah_luas_lantai, 2) }} m²
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="fw-semibold bg-light text-muted small">LUAS TAPAK (M²)</td>
                                <td>
                                    @if(isset($record->luas_tapak) && $record->luas_tapak !== '')
                                        {{ number_format((float)$record->luas_tapak, 2) }} m²
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold bg-light text-muted small">STATUS BLOK</td>
                                <td colspan="3">
                                    @if($record->status_blok === 'aktif')
                                        <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1">
                                            <i class="bi bi-circle-fill me-1" style="font-size:.45rem;vertical-align:middle;"></i>Aktif
                                        </span>
                                    @else
                                        <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-3 py-1">
                                            <i class="bi bi-circle-fill me-1" style="font-size:.45rem;vertical-align:middle;"></i>Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <hr class="my-4">

            {{-- 4. GAMBAR BLOK/BINAAN LUAR --}}
            <div class="mb-4">
                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-image me-1"></i>4. Gambar Blok/Binaan Luar</h6>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card h-100 border shadow-sm">
                            <div class="card-header bg-light border-bottom text-muted py-2 small fw-semibold">GAMBAR SUDUT HADAPAN</div>
                            <div class="card-body text-center d-flex align-items-center justify-content-center" style="min-height: 220px; background-color: #fcfcfc;">
                                @if($record->gambar_hadapan)
                                    <img src="{{ asset('storage/' . $record->gambar_hadapan) }}" alt="Sudut Hadapan" style="max-height: 200px; max-width: 100%; object-fit: contain;" class="rounded shadow-sm">
                                @else
                                    <div class="text-muted py-4">
                                        <i class="bi bi-image fs-1 d-block mb-2 text-black-50"></i>
                                        Tiada Gambar Sudut Hadapan
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 border shadow-sm">
                            <div class="card-header bg-light border-bottom text-muted py-2 small fw-semibold">GAMBAR SUDUT BELAKANG</div>
                            <div class="card-body text-center d-flex align-items-center justify-content-center" style="min-height: 220px; background-color: #fcfcfc;">
                                @if($record->gambar_belakang)
                                    <img src="{{ asset('storage/' . $record->gambar_belakang) }}" alt="Sudut Belakang" style="max-height: 200px; max-width: 100%; object-fit: contain;" class="rounded shadow-sm">
                                @else
                                    <div class="text-muted py-4">
                                        <i class="bi bi-image fs-1 d-block mb-2 text-black-50"></i>
                                        Tiada Gambar Sudut Belakang
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            {{-- 5. SENARAI LUKISAN SIAP BINA --}}
            <div class="mb-2">
                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-pencil-square me-1"></i>5. Senarai Lukisan Siap Bina</h6>
                <div class="table-responsive bg-white rounded-3 shadow-sm border">
                    <table class="table table-bordered mb-0 align-middle">
                        <thead class="table-light text-muted small">
                            <tr>
                                <th style="width: 60px;" class="text-center">Bil</th>
                                <th style="width: 200px;">Bidang</th>
                                <th>Tajuk Lukisan</th>
                                <th style="width: 250px;">No. Rujukan</th>
                                <th style="width: 250px;">Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($record->lukisan_list ?? [] as $idx => $l)
                                @if(!empty($l['bidang']) || !empty($l['tajuk']) || !empty($l['no_rujukan']) || !empty($l['catatan']))
                                    <tr>
                                        <td class="text-center text-muted small">{{ $idx + 1 }}</td>
                                        <td class="small">{{ $l['bidang'] ?? '—' }}</td>
                                        <td class="small">{{ $l['tajuk'] ?? '—' }}</td>
                                        <td class="small text-muted font-monospace">{{ $l['no_rujukan'] ?? '—' }}</td>
                                        <td class="small text-muted">{{ $l['catatan'] ?? '—' }}</td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3 small">Tiada lukisan siap bina didaftarkan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="card-footer bg-white border-top py-3 d-flex justify-content-between align-items-center">
            <span class="text-muted small">Didaftar pada: {{ $record->created_at ? $record->created_at->format('d/m/Y h:i A') : '—' }}</span>
            <a href="{{ route('admin.aras-ruang.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Senarai
            </a>
        </div>
    </div>

    {{-- ===== TAB NAVIGATION (ARAS & RUANG) ===== --}}
    <div class="card border-0 shadow-sm mb-5">
        <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
            <ul class="nav nav-tabs card-header-tabs" id="arasRuangTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab === 'ruang' ? '' : 'active' }} fw-semibold px-4 py-2"
                        id="aras-tab" data-bs-toggle="tab" data-bs-target="#aras-panel" type="button" role="tab"
                        aria-controls="aras-panel" aria-selected="{{ $activeTab !== 'ruang' ? 'true' : 'false' }}">
                        <i class="bi bi-layers me-2 text-primary"></i>Aras Terlibat
                        <span class="badge bg-primary ms-2">{{ $arasPaginated->total() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab === 'ruang' ? 'active' : '' }} fw-semibold px-4 py-2"
                        id="ruang-tab" data-bs-toggle="tab" data-bs-target="#ruang-panel" type="button" role="tab"
                        aria-controls="ruang-panel" aria-selected="{{ $activeTab === 'ruang' ? 'true' : 'false' }}">
                        <i class="bi bi-door-open me-2 text-success"></i>Ruang Terlibat
                        <span class="badge bg-success ms-2">{{ $ruangsPaginated->total() }}</span>
                    </button>
                </li>
            </ul>
        </div>

        <div class="tab-content" id="arasRuangTabContent">

            {{-- TAB 1: ARAS --}}
            <div class="tab-pane fade {{ $activeTab === 'ruang' ? '' : 'show active' }}"
                id="aras-panel" role="tabpanel" aria-labelledby="aras-tab">
                <div class="card-body">
                    {{-- Filter Form --}}
                    <form action="{{ route('admin.aras-ruang.show', $record->id) }}" method="GET" class="row g-3 mb-4" id="arasFilterForm">
                        <input type="hidden" name="tab" value="aras">
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-semibold">CARI ARAS</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="text" name="aras_search" class="form-control border-start-0 ps-0"
                                    placeholder="Kod atau nama aras..." value="{{ request('aras_search') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-muted small fw-semibold">BLOK</label>
                            <select name="aras_blok_id" class="form-select">
                                <option value="">Semua Blok</option>
                                @foreach($bloks as $blok)
                                    <option value="{{ $blok->id }}" {{ request('aras_blok_id') == $blok->id ? 'selected' : '' }}>
                                        {{ $blok->kod }} - {{ $blok->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-muted small fw-semibold">STATUS</label>
                            <select name="aras_status" class="form-select">
                                <option value="">Semua</option>
                                <option value="active" {{ request('aras_status') === 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ request('aras_status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search me-1"></i> Cari
                            </button>
                            <a href="{{ route('admin.aras-ruang.show', $record->id) }}?tab=aras" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>
                        </div>
                    </form>

                    {{-- Aras Table (Read Only) --}}
                    <div class="table-responsive bg-white rounded shadow-sm border">
                        <table class="table table-hover align-middle mb-0" id="arasTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" width="60">#</th>
                                    <th>Blok</th>
                                    <th>Kod Aras</th>
                                    <th>Nama Aras</th>
                                    <th class="text-center" width="150">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($arasPaginated as $index => $item)
                                <tr>
                                    <td class="text-center text-muted small">
                                        {{ ($arasPaginated->currentPage() - 1) * $arasPaginated->perPage() + $loop->iteration }}
                                    </td>
                                    <td>
                                        @if($item->blok)
                                            <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle fw-semibold">
                                                <i class="bi bi-building me-1"></i>{{ $item->blok->kod }}
                                            </span>
                                            <span class="text-muted ms-1 small">{{ $item->blok->nama }}</span>
                                        @else
                                            <span class="text-muted small fst-italic">—</span>
                                        @endif
                                    </td>
                                    <td><span class="fw-bold font-monospace text-dark">{{ $item->kod }}</span></td>
                                    <td>{{ $item->nama }}</td>
                                    <td class="text-center">
                                        @if($item->is_active)
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1">
                                                <i class="bi bi-check-circle-fill me-1"></i>Aktif
                                            </span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-1">
                                                <i class="bi bi-x-circle-fill me-1"></i>Tidak Aktif
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-2 d-block mb-2 text-black-50"></i>
                                        Tiada rekod aras didaftarkan untuk blok ini
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Aras Pagination --}}
                    @if($arasPaginated->hasPages())
                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Menunjukkan {{ $arasPaginated->firstItem() }}–{{ $arasPaginated->lastItem() }}
                            daripada {{ $arasPaginated->total() }} rekod
                        </small>
                        <div>
                            {{ $arasPaginated->appends(['tab' => 'aras', 'aras_search' => request('aras_search'), 'aras_blok_id' => request('aras_blok_id'), 'aras_status' => request('aras_status')])->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- TAB 2: RUANG --}}
            <div class="tab-pane fade {{ $activeTab === 'ruang' ? 'show active' : '' }}"
                id="ruang-panel" role="tabpanel" aria-labelledby="ruang-tab">
                <div class="card-body">
                    {{-- Filter Form --}}
                    <form action="{{ route('admin.aras-ruang.show', $record->id) }}" method="GET" class="row g-3 mb-4" id="ruangFilterForm">
                        <input type="hidden" name="tab" value="ruang">
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-semibold">CARI RUANG</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="text" name="ruang_search" class="form-control border-start-0 ps-0"
                                    placeholder="Kod atau nama ruang..." value="{{ request('ruang_search') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-muted small fw-semibold">ARAS</label>
                            <select name="ruang_aras_id" class="form-select">
                                <option value="">Semua Aras</option>
                                @foreach($arasAll as $arasItem)
                                    <option value="{{ $arasItem->id }}" {{ request('ruang_aras_id') == $arasItem->id ? 'selected' : '' }}>
                                        {{ $arasItem->kod }} - {{ $arasItem->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-muted small fw-semibold">STATUS</label>
                            <select name="ruang_status" class="form-select">
                                <option value="">Semua</option>
                                <option value="active" {{ request('ruang_status') === 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ request('ruang_status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-search me-1"></i> Cari
                            </button>
                            <a href="{{ route('admin.aras-ruang.show', $record->id) }}?tab=ruang" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>
                        </div>
                    </form>

                    {{-- Ruang Table (Read Only) --}}
                    <div class="table-responsive bg-white rounded shadow-sm border">
                        <table class="table table-hover align-middle mb-0" id="ruangTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" width="60">#</th>
                                    <th>Aras</th>
                                    <th>Kod Ruang</th>
                                    <th>Nama Ruang</th>
                                    <th class="text-center">Kategori</th>
                                    <th class="text-center" width="150">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ruangsPaginated as $ruang)
                                <tr>
                                    <td class="text-center text-muted small">
                                        {{ ($ruangsPaginated->currentPage() - 1) * $ruangsPaginated->perPage() + $loop->iteration }}
                                    </td>
                                    <td>
                                        @if($ruang->aras)
                                            <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle fw-semibold">
                                                <i class="bi bi-layers me-1"></i>{{ $ruang->aras->kod }}
                                            </span>
                                            <span class="text-muted ms-1 small">{{ $ruang->aras->nama }}</span>
                                        @else
                                            <span class="text-muted small fst-italic">—</span>
                                        @endif
                                    </td>
                                    <td><span class="fw-bold font-monospace text-dark">{{ $ruang->kod }}</span></td>
                                    <td>{{ $ruang->nama }}</td>
                                    <td class="text-center">
                                        @if($ruang->kategori)
                                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-3">{{ $ruang->kategori }}</span>
                                        @else
                                            <span class="text-muted small">—</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($ruang->is_active)
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1">
                                                <i class="bi bi-check-circle-fill me-1"></i>Aktif
                                            </span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-1">
                                                <i class="bi bi-x-circle-fill me-1"></i>Tidak Aktif
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-2 d-block mb-2 text-black-50"></i>
                                        Tiada rekod ruang didaftarkan untuk blok ini
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Ruang Pagination --}}
                    @if($ruangsPaginated->hasPages())
                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Menunjukkan {{ $ruangsPaginated->firstItem() }}–{{ $ruangsPaginated->lastItem() }}
                            daripada {{ $ruangsPaginated->total() }} rekod
                        </small>
                        <div>
                            {{ $ruangsPaginated->appends(['tab' => 'ruang', 'ruang_search' => request('ruang_search'), 'ruang_aras_id' => request('ruang_aras_id'), 'ruang_status' => request('ruang_status')])->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

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
                    Pratonton D.A.5 —
                    <span id="modalDA5Nama" class="text-primary"></span>
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
document.addEventListener('DOMContentLoaded', function() {
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
    const url = `/admin/aras-ruang/${id}/export-pdf`;
    const frame = document.getElementById('pdfFrame');
    const downloadLink = document.getElementById('pdfDownload');
    const titleSpan = document.getElementById('modalDA5Nama');
    
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
