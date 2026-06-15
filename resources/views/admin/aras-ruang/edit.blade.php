@php
    $da5_data = $record->toArray();
    if ($record->tarikh_siap_bina) {
        $da5_data['tarikh_siap_bina'] = $record->tarikh_siap_bina->format('Y-m-d');
    }
    if ($record->tarikh_penilaian) {
        $da5_data['tarikh_penilaian'] = $record->tarikh_penilaian->format('Y-m-d');
    }
@endphp
@extends('layouts.app')

@section('title', 'Borang D.A.5 - Kemaskini Maklumat')

@section('content')
<div class="container-fluid">

    {{-- ===== PAGE HEADER ===== --}}
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2 class="mb-1 fw-bold">
                <i class="bi bi-layers-half me-2 text-primary"></i>Borang D.A.5
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.aras-ruang.index') }}">Borang D.A.5</a></li>
                    <li class="breadcrumb-item active">Kemaskini Maklumat</li>
                </ol>
            </nav>
        </div>
        {{-- Dynamic Add button + Export PDF button --}}
        <div id="headerButtons" class="d-flex gap-2 align-items-center">
            <button class="btn btn-primary" id="btnTambahAras" data-bs-toggle="modal" data-bs-target="#modalTambahAras">
                <i class="bi bi-plus-circle me-1"></i> Tambah Aras
            </button>
            <button class="btn btn-success d-none" id="btnTambahRuang" data-bs-toggle="modal" data-bs-target="#modalTambahRuang">
                <i class="bi bi-plus-circle me-1"></i> Tambah Ruang
            </button>

            {{-- Preview PDF Button --}}
            <button type="button" class="btn btn-danger" onclick="previewPdf({{ $record->id }}, '{{ addslashes($record->nama_premis ?? 'Manual') }}')">
                <i class="bi bi-file-pdf"></i> Preview PDF
            </button>
        </div>
    </div>


    {{-- ===== COLLAPSIBLE D.A.5 FORM CARD ===== --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center" style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#collapseFormDA5">
            <h5 class="mb-0 fw-bold text-dark d-flex align-items-center">
                <i class="bi bi-file-earmark-text-fill me-2 text-danger"></i>Maklumat Borang D.A.5
            </h5>
            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                <i class="bi bi-chevron-down"></i> Klik untuk Papar/Sembunyi
            </span>
        </div>
        <div id="collapseFormDA5" class="collapse show">
            <form action="{{ route('admin.aras-ruang.update', $record->id) }}" method="POST" id="formDA5" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body bg-light border-top">

                    {{-- ── 1. MAKLUMAT PREMIS & BLOK ── --}}
                    <div class="mb-4">
                        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-geo-alt me-1"></i>1. Maklumat Premis & Blok / Binaan Luar</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-semibold">Nama Premis</label>
                                <select name="nama_premis_id" id="da5_nama_premis" class="form-select">
                                    <option value="">-- Pilih Premis --</option>
                                    <option value="manual" {{ old('nama_premis_id', $da5_data['nama_premis_id'] ?? '') === 'manual' ? 'selected' : '' }}>-- Isi Manual --</option>
                                    @foreach($premisList as $p)
                                    <option value="{{ $p->id }}" data-nama="{{ $p->nama_premis }}" {{ old('nama_premis_id', $da5_data['nama_premis_id'] ?? '') == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama_premis }}
                                    </option>
                                    @endforeach
                                    @if(empty(old('nama_premis_id', $da5_data['nama_premis_id'] ?? '')) && !empty(old('nama_premis', $da5_data['nama_premis'] ?? '')))
                                    <option value="{{ old('nama_premis', $da5_data['nama_premis'] ?? '') }}" selected>
                                        {{ old('nama_premis', $da5_data['nama_premis'] ?? '') }}
                                    </option>
                                    @endif
                                </select>
                                <input type="hidden" name="nama_premis" id="da5_nama_premis_hidden" value="{{ old('nama_premis', $da5_data['nama_premis'] ?? '') }}">

                                <div id="wrapper_nama_premis_manual" class="mt-2 {{ (old('nama_premis_id', $da5_data['nama_premis_id'] ?? '') === 'manual') ? '' : 'd-none' }}">
                                    <input type="text" name="nama_premis_manual" id="da5_nama_premis_manual" class="form-control" value="{{ old('nama_premis_manual', $da5_data['nama_premis_manual'] ?? ($da5_data['nama_premis'] ?? '')) }}" placeholder="Taip Nama Premis Manual di sini">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-semibold">No. DPA</label>
                                <input type="text" name="no_dpa" id="da5_no_dpa" class="form-control" value="{{ old('no_dpa', $da5_data['no_dpa'] ?? '') }}" placeholder="Contoh: 11011 01MYS.14004 4.BD0001">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-semibold">Kod Blok / Binaan Luar (Daripada Master Blok)</label>
                                <select name="kod_blok" id="da5_kod_blok" class="form-select">
                                    <option value="">-- Pilih Kod Blok --</option>
                                    @foreach($bloks as $b)
                                    <option value="{{ $b->kod }}" data-nama="{{ $b->nama }}" {{ old('kod_blok', $da5_data['kod_blok'] ?? '') === $b->kod ? 'selected' : '' }}>
                                        {{ $b->kod }} - {{ $b->nama }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-semibold">Nama Blok / Binaan Luar</label>
                                <input type="text" name="nama_blok" id="da5_nama_blok" class="form-control" value="{{ old('nama_blok', $da5_data['nama_blok'] ?? '') }}" placeholder="Auto-isi jika pilih kod blok">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-semibold">Fungsi Binaan (Blok)</label>
                                <input type="text" name="fungsi_binaan" id="da5_fungsi_binaan" class="form-control" value="{{ old('fungsi_binaan', $da5_data['fungsi_binaan'] ?? '') }}" placeholder="Contoh: DEWAN">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-semibold">Jenis Binaan Luar</label>
                                <input type="text" name="jenis_binaan" id="da5_jenis_binaan" class="form-control" value="{{ old('jenis_binaan', $da5_data['jenis_binaan'] ?? '') }}" placeholder="Contoh: PAGAR">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-semibold">Koordinat GPS X</label>
                                <input type="text" name="gps_x" id="da5_gps_x" class="form-control" value="{{ old('gps_x', $da5_data['gps_x'] ?? '') }}" placeholder="Contoh: 3.147">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-semibold">Koordinat GPS Y</label>
                                <input type="text" name="gps_y" id="da5_gps_y" class="form-control" value="{{ old('gps_y', $da5_data['gps_y'] ?? '') }}" placeholder="Contoh: 101.694">
                            </div>
                        </div>
                    </div>

                    <hr>

                    {{-- ── 2. KONTRAKTOR & JURU PERUNDING ── --}}
                    <div class="mb-4">
                        <div class="row g-4">

                            {{-- Kontraktor Column --}}
                            <div class="col-md-6 border-end">
                                <h6 class="fw-bold text-success mb-3"><i class="bi bi-people me-1"></i>2.1 Kontraktor</h6>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small fw-semibold">Kontraktor Utama</label>
                                        <input type="text" name="kontraktor_utama" id="da5_kontraktor_utama" class="form-control form-control-sm" value="{{ old('kontraktor_utama', $da5_data['kontraktor_utama'] ?? '') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small fw-semibold">Bidang Kerja (Utama)</label>
                                        <input type="text" name="bidang_kontraktor_utama" id="da5_bidang_kontraktor_utama" class="form-control form-control-sm" value="{{ old('bidang_kontraktor_utama', $da5_data['bidang_kontraktor_utama'] ?? '') }}">
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm align-middle" id="tableKontraktorList">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th>* Kontraktor (Tambahan)</th>
                                                <th>* Bidang Kerja</th>
                                                <th width="45"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="bodyKontraktorList">
                                            @php
                                                $kontraktors = old('kontraktor_list', $da5_data['kontraktor_list'] ?? []);
                                            @endphp
                                            @forelse($kontraktors as $idx => $k)
                                            <tr>
                                                <td><input type="text" name="kontraktor_list[{{ $idx }}][nama]" class="form-control form-control-sm" value="{{ $k['nama'] ?? '' }}"></td>
                                                <td><input type="text" name="kontraktor_list[{{ $idx }}][bidang]" class="form-control form-control-sm" value="{{ $k['bidang'] ?? '' }}"></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-outline-danger btn-sm btn-padam-row-kontraktor"><i class="bi bi-trash"></i></button>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td><input type="text" name="kontraktor_list[0][nama]" id="da5_kontraktor_1" class="form-control form-control-sm" placeholder="1."></td>
                                                <td><input type="text" name="kontraktor_list[0][bidang]" id="da5_bidang_kontraktor_1" class="form-control form-control-sm"></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-outline-danger btn-sm btn-padam-row-kontraktor"><i class="bi bi-trash"></i></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" name="kontraktor_list[1][nama]" id="da5_kontraktor_2" class="form-control form-control-sm" placeholder="2."></td>
                                                <td><input type="text" name="kontraktor_list[1][bidang]" id="da5_bidang_kontraktor_2" class="form-control form-control-sm"></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-outline-danger btn-sm btn-padam-row-kontraktor"><i class="bi bi-trash"></i></button>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <button type="button" class="btn btn-outline-success btn-sm" id="btnTambahRowKontraktor">
                                    <i class="bi bi-plus-lg"></i> Tambah Kontraktor
                                </button>
                            </div>

                            {{-- Perunding Column --}}
                            <div class="col-md-6">
                                <h6 class="fw-bold text-success mb-3"><i class="bi bi-people me-1"></i>2.2 Juru Perunding</h6>
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small fw-semibold">Juru Perunding Utama</label>
                                        <input type="text" name="juru_perunding_utama" id="da5_juru_perunding_utama" class="form-control form-control-sm" value="{{ old('juru_perunding_utama', $da5_data['juru_perunding_utama'] ?? '') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small fw-semibold">Bidang Kerja (Utama)</label>
                                        <input type="text" name="bidang_juru_perunding_utama" id="da5_bidang_juru_perunding_utama" class="form-control form-control-sm" value="{{ old('bidang_juru_perunding_utama', $da5_data['bidang_juru_perunding_utama'] ?? '') }}">
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm align-middle" id="tablePerundingList">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th>* Juru Perunding (Tambahan)</th>
                                                <th>* Bidang Kerja</th>
                                                <th width="45"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="bodyPerundingList">
                                            @php
                                                $perunding = old('juru_perunding_list', $da5_data['juru_perunding_list'] ?? []);
                                            @endphp
                                            @forelse($perunding as $idx => $p)
                                            <tr>
                                                <td><input type="text" name="juru_perunding_list[{{ $idx }}][nama]" class="form-control form-control-sm" value="{{ $p['nama'] ?? '' }}"></td>
                                                <td><input type="text" name="juru_perunding_list[{{ $idx }}][bidang]" class="form-control form-control-sm" value="{{ $p['bidang'] ?? '' }}"></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-outline-danger btn-sm btn-padam-row-perunding"><i class="bi bi-trash"></i></button>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td><input type="text" name="juru_perunding_list[0][nama]" id="da5_juru_perunding_1" class="form-control form-control-sm" placeholder="1."></td>
                                                <td><input type="text" name="juru_perunding_list[0][bidang]" id="da5_bidang_juru_perunding_1" class="form-control form-control-sm"></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-outline-danger btn-sm btn-padam-row-perunding"><i class="bi bi-trash"></i></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" name="juru_perunding_list[1][nama]" id="da5_juru_perunding_2" class="form-control form-control-sm" placeholder="2."></td>
                                                <td><input type="text" name="juru_perunding_list[1][bidang]" id="da5_bidang_juru_perunding_2" class="form-control form-control-sm"></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-outline-danger btn-sm btn-padam-row-perunding"><i class="bi bi-trash"></i></button>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <button type="button" class="btn btn-outline-success btn-sm" id="btnTambahRowPerunding">
                                    <i class="bi bi-plus-lg"></i> Tambah Juru Perunding
                                </button>
                            </div>

                        </div>
                    </div>

                    <hr>

                    {{-- ── 3. OPERASI, KEWANGAN & FIZIKAL ── --}}
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-currency-dollar me-1"></i>3. Maklumat Kewangan, Operasi & Fizikal</h6>
                        <div class="row g-3">
                            {{-- Left Column --}}
                            <div class="col-md-6">
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small fw-semibold">Tahun Siap Bina Asal</label>
                                        <select name="tahun_siap_bina" id="da5_tahun_siap_bina" class="form-select">
                                            <option value="">-- Pilih Tahun --</option>
                                            @for($y = date('Y'); $y >= 1950; $y--)
                                            <option value="{{ $y }}" {{ (old('tahun_siap_bina', $da5_data['tahun_siap_bina'] ?? '') == $y) ? 'selected' : '' }}>{{ $y }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small fw-semibold">Tarikh Siap Bina Asal</label>
                                        <input type="date" name="tarikh_siap_bina" id="da5_tarikh_siap_bina" class="form-control" value="{{ old('tarikh_siap_bina', $da5_data['tarikh_siap_bina'] ?? '') }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label text-muted small fw-semibold">Fungsi Asal</label>
                                        <input type="text" name="fungsi_asal" id="da5_fungsi_asal" class="form-control" value="{{ old('fungsi_asal', $da5_data['fungsi_asal'] ?? '') }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label text-muted small fw-semibold">Jenis Struktur (Blok)</label>
                                        <input type="text" name="jenis_struktur" id="da5_jenis_struktur" class="form-control" value="{{ old('jenis_struktur', $da5_data['jenis_struktur'] ?? '') }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label text-muted small fw-semibold">No. Siri Pendaftaran</label>
                                        <input type="text" name="no_siri_pendaftaran" id="da5_no_siri_pendaftaran" class="form-control" value="{{ old('no_siri_pendaftaran', $da5_data['no_siri_pendaftaran'] ?? '') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small fw-semibold">Jangka Hayat (Tahun)</label>
                                        <input type="number" name="jangka_hayat" id="da5_jangka_hayat" class="form-control" value="{{ old('jangka_hayat', $da5_data['jangka_hayat'] ?? '') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small fw-semibold">Kapasiti Penghuni Asal</label>
                                        <input type="number" name="kapasiti_penghuni" id="da5_kapasiti_penghuni" class="form-control" value="{{ old('kapasiti_penghuni', $da5_data['kapasiti_penghuni'] ?? '') }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label text-muted small fw-semibold">Kos Bina Asal (RM)</label>
                                        <input type="number" name="kos_bina_asal" id="da5_kos_bina_asal" class="form-control" value="{{ old('kos_bina_asal', $da5_data['kos_bina_asal'] ?? '') }}" step="0.01">
                                    </div>
                                </div>
                            </div>

                            {{-- Right Column --}}
                            <div class="col-md-6">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <label class="form-label text-muted small fw-semibold">Nilai Semasa (RM)</label>
                                        <input type="number" name="nilai_semasa" id="da5_nilai_semasa" class="form-control" value="{{ old('nilai_semasa', $da5_data['nilai_semasa'] ?? '') }}" step="0.01">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label text-muted small fw-semibold">Tahun Penilaian (Tarikh)</label>
                                        <input type="date" name="tarikh_penilaian" id="da5_tarikh_penilaian" class="form-control" value="{{ old('tarikh_penilaian', $da5_data['tarikh_penilaian'] ?? '') }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label text-muted small fw-semibold">Sumber Pembiayaan</label>
                                        <input type="text" name="sumber_pembiayaan" id="da5_sumber_pembiayaan" class="form-control" value="{{ old('sumber_pembiayaan', $da5_data['sumber_pembiayaan'] ?? '') }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label text-muted small fw-semibold">Kod PTJ</label>
                                        <input type="text" name="kod_ptj" id="da5_kod_ptj" class="form-control" value="{{ old('kod_ptj', $da5_data['kod_ptj'] ?? '') }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label text-muted small fw-semibold">Penggunaan Tenaga [(kiloWatt/jam)/tahun]</label>
                                        <input type="number" name="penggunaan_tenaga" id="da5_penggunaan_tenaga" class="form-control" value="{{ old('penggunaan_tenaga', $da5_data['penggunaan_tenaga'] ?? '') }}" step="0.01">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label text-muted small fw-semibold">Penggunaan Air (m³/tahun)</label>
                                        <input type="number" name="penggunaan_air" id="da5_penggunaan_air" class="form-control" value="{{ old('penggunaan_air', $da5_data['penggunaan_air'] ?? '') }}" step="0.01">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label text-muted small fw-semibold">Jenis Milikan</label>
                                        <select name="jenis_milikan" id="da5_jenis_milikan" class="form-select">
                                            <option value="">-- Pilih --</option>
                                            <option value="Pajakan" {{ old('jenis_milikan', $da5_data['jenis_milikan'] ?? '') === 'Pajakan' ? 'selected' : '' }}>Pajakan</option>
                                            <option value="Pegangan Bebas" {{ old('jenis_milikan', $da5_data['jenis_milikan'] ?? '') === 'Pegangan Bebas' ? 'selected' : '' }}>Pegangan Bebas</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    {{-- ── 4. HELAIAN 2 DATA FIELDS ── --}}
                    <div class="mb-2">
                        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-file-earmark-check me-1"></i>4. Maklumat Helaian 2</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <label class="form-label text-muted small fw-semibold">Aset Warisan</label>
                                        <div class="form-check form-switch mt-1">
                                            <input class="form-check-input" type="checkbox" name="aset_warisan" id="da5_aset_warisan" value="1" {{ old('aset_warisan', $da5_data['aset_warisan'] ?? '') == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label text-muted small" for="da5_aset_warisan">Tandakan jika Ya</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small fw-semibold">Bil. Aras Atas Tanah</label>
                                        <input type="number" name="bil_aras_atas" id="da5_bil_aras_atas" class="form-control" value="{{ old('bil_aras_atas', $da5_data['bil_aras_atas'] ?? '') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small fw-semibold">Bil. Aras Bawah Tanah</label>
                                        <input type="number" name="bil_aras_bawah" id="da5_bil_aras_bawah" class="form-control" value="{{ old('bil_aras_bawah', $da5_data['bil_aras_bawah'] ?? '') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <label class="form-label text-muted small fw-semibold">Status Blok/Binaan Luar</label>
                                        <select name="status_blok" id="da5_status_blok" class="form-select">
                                            <option value="">-- Pilih --</option>
                                            <option value="aktif" {{ old('status_blok', $da5_data['status_blok'] ?? '') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="tidak_aktif" {{ old('status_blok', $da5_data['status_blok'] ?? '') === 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small fw-semibold">Jumlah Luas Lantai Blok (m²)</label>
                                        <input type="number" name="jumlah_luas_lantai" id="da5_jumlah_luas_lantai" class="form-control" value="{{ old('jumlah_luas_lantai', $da5_data['jumlah_luas_lantai'] ?? '') }}" step="0.01">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small fw-semibold">Luas Tapak Blok/Binaan Luar (m²)</label>
                                        <input type="number" name="luas_tapak" id="da5_luas_tapak" class="form-control" value="{{ old('luas_tapak', $da5_data['luas_tapak'] ?? '') }}" step="0.01">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Image Upload & Preview Section --}}
                        <div class="mt-3 pt-3 border-top">
                            <label class="form-label text-dark fw-bold mb-1"><i class="bi bi-image me-1"></i>Gambar Blok/Binaan Luar</label>
                            <span class="text-muted small d-block mb-3">Sila muat naik gambar blok/binaan luar (maksimum 5MB setiap satu). Pastikan gambar diambil pada sudut hadapan dan sudut belakang.</span>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="gambar_hadapan" class="form-label text-muted small fw-semibold">Gambar Sudut Hadapan</label>
                                    @if($record->gambar_hadapan)
                                        <div class="mb-2 position-relative d-inline-block border rounded p-1 bg-white shadow-sm">
                                            <img src="{{ asset('storage/' . $record->gambar_hadapan) }}" alt="Sudut Hadapan" style="max-height: 120px; max-width: 100%; display: block;" class="rounded">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" name="padam_gambar_hadapan" id="padam_gambar_hadapan" value="1">
                                                <label class="form-check-label text-danger small fw-semibold" for="padam_gambar_hadapan">
                                                    Padam gambar ini
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                    <input type="file" name="gambar_hadapan" id="gambar_hadapan" class="form-control" accept="image/*">
                                    <div class="form-text small text-muted">Muat naik gambar baru untuk menggantikan gambar sedia ada. Format: JPG, JPEG, PNG, GIF (Maks 5MB).</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="gambar_belakang" class="form-label text-muted small fw-semibold">Gambar Sudut Belakang</label>
                                    @if($record->gambar_belakang)
                                        <div class="mb-2 position-relative d-inline-block border rounded p-1 bg-white shadow-sm">
                                            <img src="{{ asset('storage/' . $record->gambar_belakang) }}" alt="Sudut Belakang" style="max-height: 120px; max-width: 100%; display: block;" class="rounded">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" name="padam_gambar_belakang" id="padam_gambar_belakang" value="1">
                                                <label class="form-check-label text-danger small fw-semibold" for="padam_gambar_belakang">
                                                    Padam gambar ini
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                    <input type="file" name="gambar_belakang" id="gambar_belakang" class="form-control" accept="image/*">
                                    <div class="form-text small text-muted">Muat naik gambar baru untuk menggantikan gambar sedia ada. Format: JPG, JPEG, PNG, GIF (Maks 5MB).</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    {{-- ── 5. SENARAI LUKISAN SIAP BINA ── --}}
                    <div class="mb-2">
                        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-pencil-square me-1"></i>5. Senarai Lukisan Siap Bina</h6>
                        <span class="text-muted small d-block mb-3">Sila isi senarai lukisan siap bina (as-built drawings) bagi blok/binaan luar ini jika berkenaan.</span>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm align-middle" id="tableLukisanList">
                                <thead class="table-secondary">
                                    <tr>
                                        <th style="width: 50px;" class="text-center">Bil</th>
                                        <th style="width: 200px;">Bidang</th>
                                        <th>Tajuk Lukisan</th>
                                        <th style="width: 250px;">No. Rujukan</th>
                                        <th style="width: 250px;">Catatan</th>
                                        <th style="width: 45px;"></th>
                                    </tr>
                                </thead>
                                <tbody id="bodyLukisanList">
                                    @php
                                        $lukisan = old('lukisan_list', $record->lukisan_list ?? []);
                                    @endphp
                                    @forelse($lukisan as $idx => $l)
                                    <tr>
                                        <td class="text-center row-number-lukisan">{{ $idx + 1 }}</td>
                                        <td><input type="text" name="lukisan_list[{{ $idx }}][bidang]" class="form-control form-control-sm" value="{{ $l['bidang'] ?? '' }}"></td>
                                        <td><input type="text" name="lukisan_list[{{ $idx }}][tajuk]" class="form-control form-control-sm" value="{{ $l['tajuk'] ?? '' }}"></td>
                                        <td><input type="text" name="lukisan_list[{{ $idx }}][no_rujukan]" class="form-control form-control-sm" value="{{ $l['no_rujukan'] ?? '' }}"></td>
                                        <td><input type="text" name="lukisan_list[{{ $idx }}][catatan]" class="form-control form-control-sm" value="{{ $l['catatan'] ?? '' }}"></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-outline-danger btn-sm btn-padam-row-lukisan"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td class="text-center row-number-lukisan">1</td>
                                        <td><input type="text" name="lukisan_list[0][bidang]" class="form-control form-control-sm" placeholder="Contoh: Seni Bina / Struktur"></td>
                                        <td><input type="text" name="lukisan_list[0][tajuk]" class="form-control form-control-sm" placeholder="Contoh: Lukisan Pelan Tapak"></td>
                                        <td><input type="text" name="lukisan_list[0][no_rujukan]" class="form-control form-control-sm"></td>
                                        <td><input type="text" name="lukisan_list[0][catatan]" class="form-control form-control-sm"></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-outline-danger btn-sm btn-padam-row-lukisan"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-outline-success btn-sm mb-3" id="btnTambahRowLukisan">
                            <i class="bi bi-plus-lg"></i> Tambah Baris Lukisan
                        </button>
                    </div>
                                 {{-- Form Actions Footer --}}
                <div class="card-footer bg-white border-top py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-success small fw-semibold">
                            <i class="bi bi-check-circle-fill me-1"></i> Data Borang D.A.5 disimpan dalam pangkalan data.
                        </span>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-floppy me-1"></i> Kemaskini Maklumat D.A.5
                        </button>
                        <a href="{{ route('admin.aras-ruang.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ===== TAB NAVIGATION ===== --}}
    <div class="card border-0 shadow-sm mb-0">
        <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
            <ul class="nav nav-tabs card-header-tabs" id="arasRuangTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab === 'ruang' ? '' : 'active' }} fw-semibold px-4 py-2"
                        id="aras-tab" data-bs-toggle="tab" data-bs-target="#aras-panel" type="button" role="tab"
                        aria-controls="aras-panel" aria-selected="{{ $activeTab !== 'ruang' ? 'true' : 'false' }}">
                        <i class="bi bi-layers me-2 text-primary"></i>Aras
                        <span class="badge bg-primary ms-2">{{ $arasPaginated->total() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab === 'ruang' ? 'active' : '' }} fw-semibold px-4 py-2"
                        id="ruang-tab" data-bs-toggle="tab" data-bs-target="#ruang-panel" type="button" role="tab"
                        aria-controls="ruang-panel" aria-selected="{{ $activeTab === 'ruang' ? 'true' : 'false' }}">
                        <i class="bi bi-door-open me-2 text-success"></i>Ruang
                        <span class="badge bg-success ms-2">{{ $ruangsPaginated->total() }}</span>
                    </button>
                </li>
            </ul>
        </div>

        <div class="tab-content" id="arasRuangTabContent">

            {{-- ============================================================
                 TAB 1: ARAS
            ============================================================ --}}
            <div class="tab-pane fade {{ $activeTab === 'ruang' ? '' : 'show active' }}"
                id="aras-panel" role="tabpanel" aria-labelledby="aras-tab">

                <div class="card-body">
                    {{-- Filter Form --}}
                    <form action="{{ route('admin.aras-ruang.index') }}" method="GET" class="row g-3 mb-4" id="arasFilterForm">
                        <input type="hidden" name="tab" value="aras">
                        <div class="col-md-3">
                            <label class="form-label text-muted small fw-semibold">CARI ARAS</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="text" name="aras_search" class="form-control border-start-0 ps-0"
                                    placeholder="Kod atau nama aras..."
                                    value="{{ request('aras_search') }}">
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
                        <div class="col-md-4 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search me-1"></i> Cari
                            </button>
                            <a href="{{ route('admin.aras-ruang.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                            </a>
                            <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#modalTambahAras">
                                <i class="bi bi-plus-circle me-1"></i> Tambah Aras
                            </button>
                        </div>
                    </form>

                    {{-- Aras Table --}}
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="arasTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" width="60">#</th>
                                    <th>Blok</th>
                                    <th>Kod Aras</th>
                                    <th>Nama Aras</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" width="140">Tindakan</th>
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
                                    <td>
                                        <span class="fw-bold font-monospace text-dark">{{ $item->kod }}</span>
                                    </td>
                                    <td>{{ $item->nama }}</td>
                                    <td class="text-center">
                                        @if($item->is_active)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3">
                                            <i class="bi bi-check-circle-fill me-1"></i>Aktif
                                        </span>
                                        @else
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3">
                                            <i class="bi bi-x-circle-fill me-1"></i>Tidak Aktif
                                        </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-warning me-1"
                                            onclick="editAras({{ $item->id }}, '{{ addslashes($item->blok_id) }}', '{{ addslashes($item->kod) }}', '{{ addslashes($item->nama) }}', {{ $item->is_active ? 'true' : 'false' }})"
                                            title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="deleteAras({{ $item->id }}, '{{ addslashes($item->nama) }}')"
                                            title="Padam">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                        <form id="delete-aras-{{ $item->id }}" action="{{ route('admin.aras.destroy', $item) }}" method="POST" class="d-none">
                                            @csrf @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                        Tiada rekod aras dijumpai
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

            {{-- ============================================================
                 TAB 2: RUANG
            ============================================================ --}}
            <div class="tab-pane fade {{ $activeTab === 'ruang' ? 'show active' : '' }}"
                id="ruang-panel" role="tabpanel" aria-labelledby="ruang-tab">

                <div class="card-body">
                    {{-- Filter Form --}}
                    <form action="{{ route('admin.aras-ruang.index') }}" method="GET" class="row g-3 mb-4" id="ruangFilterForm">
                        <input type="hidden" name="tab" value="ruang">
                        <div class="col-md-3">
                            <label class="form-label text-muted small fw-semibold">CARI RUANG</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="text" name="ruang_search" class="form-control border-start-0 ps-0"
                                    placeholder="Kod atau nama ruang..."
                                    value="{{ request('ruang_search') }}">
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
                        <div class="col-md-4 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-search me-1"></i> Cari
                            </button>
                            <a href="{{ route('admin.aras-ruang.index') }}?tab=ruang" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                            </a>
                            <button type="button" class="btn btn-success ms-auto" data-bs-toggle="modal" data-bs-target="#modalTambahRuang">
                                <i class="bi bi-plus-circle me-1"></i> Tambah Ruang
                            </button>
                        </div>
                    </form>

                    {{-- Ruang Table --}}
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="ruangTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" width="60">#</th>
                                    <th>Aras</th>
                                    <th>Kod Ruang</th>
                                    <th>Nama Ruang</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" width="140">Tindakan</th>
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
                                    <td>
                                        <span class="fw-bold font-monospace text-dark">{{ $ruang->kod }}</span>
                                    </td>
                                    <td>{{ $ruang->nama }}</td>
                                    <td class="text-center">
                                        @if($ruang->is_active)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3">
                                            <i class="bi bi-check-circle-fill me-1"></i>Aktif
                                        </span>
                                        @else
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3">
                                            <i class="bi bi-x-circle-fill me-1"></i>Tidak Aktif
                                        </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $lk = $ruang->latestKemasan;
                                        @endphp
                                        <button type="button" class="btn btn-sm btn-outline-warning me-1"
                                            data-ruang-id="{{ $ruang->id }}"
                                            data-aras-id="{{ $ruang->aras_id }}"
                                            data-kod="{{ $ruang->kod }}"
                                            data-kod-sub-ruang="{{ $ruang->kod_sub_ruang }}"
                                            data-nama="{{ $ruang->nama }}"
                                            data-luas="{{ $ruang->luas }}"
                                            data-tinggi="{{ $ruang->tinggi }}"
                                            data-fungsi-ruang="{{ $ruang->fungsi_ruang }}"
                                            data-ada-kemasan="{{ $ruang->ada_kemasan ?? 'tiada' }}"
                                            data-is-active="{{ $ruang->is_active ? '1' : '0' }}"
                                            data-kemasan="{{ $lk ? json_encode(['blok'=>$lk->blok,'aras'=>$lk->aras,'nama_aras'=>$lk->nama_aras,'kod_ruang'=>$lk->kod_ruang,'kemasan_lantai'=>$lk->kemasan_lantai,'luas_lantai'=>$lk->luas_lantai,'kemasan_dinding'=>$lk->kemasan_dinding,'luas_dinding'=>$lk->luas_dinding,'kemasan_siling'=>$lk->kemasan_siling,'luas_siling'=>$lk->luas_siling]) : '' }}"
                                            onclick="editRuangFromBtn(this)"
                                            title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="deleteRuang({{ $ruang->id }}, '{{ addslashes($ruang->nama) }}')"
                                            title="Padam">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                        <form id="delete-ruang-{{ $ruang->id }}" action="{{ route('admin.ruang.destroy', $ruang) }}" method="POST" class="d-none">
                                            @csrf @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                        Tiada rekod ruang dijumpai
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

        </div>{{-- end tab-content --}}
    </div>{{-- end card --}}
</div>


{{-- ================================================================
     MODAL: TAMBAH ARAS
================================================================ --}}
<div class="modal fade" id="modalTambahAras" tabindex="-1" aria-labelledby="modalTambahArasLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="modalTambahArasLabel">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Aras Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.aras.store') }}" method="POST" id="formTambahAras">
                @csrf
                <input type="hidden" name="_redirect_tab" value="aras">
                <div class="modal-body p-4">
                    {{-- ===== BORANG D.A 5 FORMAT - ARAS ===== --}}
                    <div class="border rounded-3 overflow-hidden mb-0">

                        {{-- Header Table --}}
                        <div class="bg-light border-bottom px-4 py-3">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="badge bg-primary fs-6 px-3 py-2 rounded-pill">D.A 5</span>
                                </div>
                                <div class="col text-center">
                                    <div class="fw-bold text-uppercase text-dark" style="letter-spacing:1px; font-size:0.85rem;">
                                        JABATAN KERJA RAYA MALAYSIA
                                    </div>
                                    <div class="text-muted small">Borang Konfigurasi Aras</div>
                                </div>
                                <div class="col-auto text-end">
                                    <small class="text-muted">JKR/DA5/ARAS</small>
                                </div>
                            </div>
                        </div>

                        {{-- Form Fields as table rows --}}
                        <table class="table table-bordered table-sm mb-0" style="font-size:0.9rem;">
                            <tbody>
                                <tr>
                                    <td class="bg-light fw-semibold align-middle" style="width:35%;">
                                        Blok <span class="text-danger">*</span>
                                    </td>
                                    <td>
                                        <select name="blok_id" class="form-select form-select-sm @error('blok_id') is-invalid @enderror" required>
                                            <option value="">— Pilih Blok —</option>
                                            @foreach($bloks as $blok)
                                            <option value="{{ $blok->id }}" {{ old('blok_id') == $blok->id ? 'selected' : '' }}>
                                                {{ $blok->kod }} — {{ $blok->nama }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('blok_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">
                                        Kod Aras <span class="text-danger">*</span>
                                    </td>
                                    <td>
                                        <input type="text" name="kod" class="form-control form-control-sm @error('kod') is-invalid @enderror"
                                            value="{{ old('kod') }}" required placeholder="Contoh: 01, 02, LG, G"
                                            style="text-transform:uppercase; font-family: monospace; font-size:1rem;">
                                        <small class="text-muted">Format: 01, 02, LG, G, B1</small>
                                        @error('kod')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">
                                        Nama Aras <span class="text-danger">*</span>
                                    </td>
                                    <td>
                                        <input type="text" name="nama" class="form-control form-control-sm @error('nama') is-invalid @enderror"
                                            value="{{ old('nama') }}" required placeholder="Contoh: Aras 1, Aras Bawah Tanah">
                                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">Status</td>
                                    <td>
                                        <div class="form-check form-switch mt-1">
                                            <input class="form-check-input" type="checkbox" name="is_active"
                                                id="tambah_aras_is_active" checked>
                                            <label class="form-check-label" for="tambah_aras_is_active">Aktif</label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i> Simpan Aras
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ================================================================
     MODAL: EDIT ARAS
================================================================ --}}
<div class="modal fade" id="modalEditAras" tabindex="-1" aria-labelledby="modalEditArasLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning">
                <h5 class="modal-title fw-bold text-dark" id="modalEditArasLabel">
                    <i class="bi bi-pencil-fill me-2"></i>Kemaskini Aras
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditAras" method="POST">
                @csrf @method('PUT')
                <input type="hidden" name="_redirect_tab" value="aras">
                <div class="modal-body p-4">
                    <div class="border rounded-3 overflow-hidden mb-0">
                        <div class="bg-light border-bottom px-4 py-3">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="badge bg-warning text-dark fs-6 px-3 py-2 rounded-pill">D.A 5</span>
                                </div>
                                <div class="col text-center">
                                    <div class="fw-bold text-uppercase text-dark" style="letter-spacing:1px; font-size:0.85rem;">
                                        JABATAN KERJA RAYA MALAYSIA
                                    </div>
                                    <div class="text-muted small">Borang Konfigurasi Aras — Kemaskini</div>
                                </div>
                                <div class="col-auto text-end">
                                    <small class="text-muted">JKR/DA5/ARAS</small>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-sm mb-0" style="font-size:0.9rem;">
                            <tbody>
                                <tr>
                                    <td class="bg-light fw-semibold align-middle" style="width:35%;">
                                        Blok <span class="text-danger">*</span>
                                    </td>
                                    <td>
                                        <select name="blok_id" id="edit_aras_blok_id" class="form-select form-select-sm" required>
                                            <option value="">— Pilih Blok —</option>
                                            @foreach($bloks as $blok)
                                            <option value="{{ $blok->id }}">{{ $blok->kod }} — {{ $blok->nama }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">
                                        Kod Aras <span class="text-danger">*</span>
                                    </td>
                                    <td>
                                        <input type="text" name="kod" id="edit_aras_kod" class="form-control form-control-sm"
                                            required placeholder="Contoh: 01"
                                            style="text-transform:uppercase; font-family: monospace; font-size:1rem;">
                                        <small class="text-muted">Format: 01, 02, LG, G, B1</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">
                                        Nama Aras <span class="text-danger">*</span>
                                    </td>
                                    <td>
                                        <input type="text" name="nama" id="edit_aras_nama" class="form-control form-control-sm"
                                            required placeholder="Contoh: Aras 1">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">Status</td>
                                    <td>
                                        <div class="form-check form-switch mt-1">
                                            <input class="form-check-input" type="checkbox" name="is_active"
                                                id="edit_aras_is_active">
                                            <label class="form-check-label" for="edit_aras_is_active">Aktif</label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-check-circle me-1"></i> Kemaskini Aras
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ================================================================
     MODAL: TAMBAH RUANG
================================================================ --}}
<div class="modal fade" id="modalTambahRuang" tabindex="-1" aria-labelledby="modalTambahRuangLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold" id="modalTambahRuangLabel">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Ruang Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.ruang.store') }}" method="POST" id="formTambahRuang">
                @csrf
                <input type="hidden" name="_redirect_tab" value="ruang">
                <div class="modal-body p-4">
                    <div class="border rounded-3 overflow-hidden mb-0">

                        {{-- Header --}}
                        <div class="bg-light border-bottom px-4 py-3">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="badge bg-success fs-6 px-3 py-2 rounded-pill">D.A 5</span>
                                </div>
                                <div class="col text-center">
                                    <div class="fw-bold text-uppercase text-dark" style="letter-spacing:1px; font-size:0.85rem;">
                                        JABATAN KERJA RAYA MALAYSIA
                                    </div>
                                    <div class="text-muted small">Borang Konfigurasi Ruang</div>
                                </div>
                                <div class="col-auto text-end">
                                    <small class="text-muted">JKR/DA5/RUANG</small>
                                </div>
                            </div>
                        </div>

                        <table class="table table-bordered table-sm mb-0" style="font-size:0.9rem;">
                            <tbody>
                                {{-- ARAS --}}
                                <tr>
                                    <td class="bg-light fw-semibold align-middle" style="width:32%;">
                                        Aras <span class="text-danger">*</span>
                                    </td>
                                    <td>
                                        <select name="aras_id" id="tambah_ruang_aras_id" class="form-select form-select-sm @error('aras_id') is-invalid @enderror" required>
                                            <option value="">— Pilih Aras —</option>
                                            @foreach($arasAll as $arasItem)
                                            <option value="{{ $arasItem->id }}"
                                                data-blok-kod="{{ $arasItem->blok ? $arasItem->blok->kod : '' }}"
                                                data-aras-kod="{{ $arasItem->kod }}"
                                                data-nama="{{ $arasItem->nama }}"
                                                {{ old('aras_id') == $arasItem->id ? 'selected' : '' }}>
                                                {{ $arasItem->kod }} — {{ $arasItem->nama }}
                                                @if($arasItem->blok) (Blok: {{ $arasItem->blok->kod }})@endif
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('aras_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </td>
                                </tr>
                                {{-- KOD RUANG --}}
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">
                                        Kod Ruang <span class="text-danger">*</span>
                                    </td>
                                    <td>
                                        <input type="text" name="kod" id="tambah_ruang_kod" class="form-control form-control-sm @error('kod') is-invalid @enderror"
                                            value="{{ old('kod') }}" required placeholder="Contoh: R01, R02"
                                            style="text-transform:uppercase; font-family: monospace; font-size:1rem;">
                                        <small class="text-muted">Format: R01, R02, BIL, JK</small>
                                        @error('kod')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </td>
                                </tr>
                                {{-- KOD SUB RUANG --}}
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">Kod Sub Ruang</td>
                                    <td>
                                        <input type="text" name="kod_sub_ruang" class="form-control form-control-sm"
                                            value="{{ old('kod_sub_ruang') }}" placeholder="Contoh: SR01"
                                            style="text-transform:uppercase; font-family: monospace; font-size:1rem;">
                                    </td>
                                </tr>
                                {{-- NAMA RUANG --}}
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">
                                        Nama Ruang <span class="text-danger">*</span>
                                    </td>
                                    <td>
                                        <input type="text" name="nama" class="form-control form-control-sm @error('nama') is-invalid @enderror"
                                            value="{{ old('nama') }}" required placeholder="Contoh: Bilik Mesyuarat">
                                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </td>
                                </tr>
                                {{-- UKURAN RUANG --}}
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">Ukuran Ruang</td>
                                    <td>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <label class="form-label text-muted small mb-1">Luas (m²)</label>
                                                <input type="number" name="luas" class="form-control form-control-sm"
                                                    value="{{ old('luas') }}" placeholder="0.00" step="0.01" min="0">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label text-muted small mb-1">Tinggi (m)</label>
                                                <input type="number" name="tinggi" class="form-control form-control-sm"
                                                    value="{{ old('tinggi') }}" placeholder="0.00" step="0.01" min="0">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                {{-- FUNGSI RUANG --}}
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">Fungsi Ruang</td>
                                    <td>
                                        <input type="text" name="fungsi_ruang" class="form-control form-control-sm"
                                            value="{{ old('fungsi_ruang') }}" placeholder="Contoh: Bilik Pejabat, Dewan">
                                    </td>
                                </tr>
                                {{-- KEMASAN --}}
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">Kemasan</td>
                                    <td>
                                        <select name="ada_kemasan" id="tambah_ada_kemasan" class="form-select form-select-sm">
                                            <option value="tiada" {{ old('ada_kemasan','tiada') === 'tiada' ? 'selected' : '' }}>TIADA</option>
                                            <option value="ada" {{ old('ada_kemasan') === 'ada' ? 'selected' : '' }}>ADA</option>
                                        </select>
                                    </td>
                                </tr>

                                {{-- ===== KEMASAN SECTION (shown when ADA) ===== --}}
                                <tr class="tambah-kemasan-row" id="tambah_kemasan_header_row" style="display:none;">
                                    <td colspan="2" class="bg-success-subtle text-success fw-bold py-2 px-3">
                                        <i class="bi bi-grid-3x3-gap me-1"></i> Butiran Kemasan
                                    </td>
                                </tr>
                                <tr class="tambah-kemasan-row" style="display:none;">
                                    <td class="bg-light fw-semibold align-middle">Blok</td>
                                    <td>
                                        <input type="text" name="kemasan_blok" id="tambah_kemasan_blok" class="form-control form-control-sm bg-light"
                                            placeholder="Auto-isi dari Aras" readonly>
                                    </td>
                                </tr>
                                <tr class="tambah-kemasan-row" style="display:none;">
                                    <td class="bg-light fw-semibold align-middle">Aras</td>
                                    <td>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <label class="form-label text-muted small mb-1">Kod Aras</label>
                                                <input type="text" name="kemasan_aras" id="tambah_kemasan_aras" class="form-control form-control-sm bg-light" readonly placeholder="Auto-isi">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label text-muted small mb-1">Nama Aras</label>
                                                <input type="text" name="kemasan_nama_aras" id="tambah_kemasan_nama_aras" class="form-control form-control-sm bg-light" readonly placeholder="Auto-isi">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="tambah-kemasan-row" style="display:none;">
                                    <td class="bg-light fw-semibold align-middle">Kod Ruang</td>
                                    <td>
                                        <input type="text" name="kemasan_kod_ruang" id="tambah_kemasan_kod_ruang" class="form-control form-control-sm bg-light" readonly placeholder="Auto-isi dari Kod Ruang">
                                    </td>
                                </tr>
                                <tr class="tambah-kemasan-row" style="display:none;">
                                    <td class="bg-light fw-semibold align-middle">Kemasan Lantai</td>
                                    <td>
                                        <div class="row g-2">
                                            <div class="col-7">
                                                <input type="text" name="kemasan_lantai" class="form-control form-control-sm" placeholder="Contoh: Jubin Seramik">
                                            </div>
                                            <div class="col-5">
                                                <div class="input-group input-group-sm">
                                                    <input type="number" name="kemasan_luas_lantai" class="form-control form-control-sm" placeholder="0.00" step="0.01" min="0">
                                                    <span class="input-group-text">m²</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="tambah-kemasan-row" style="display:none;">
                                    <td class="bg-light fw-semibold align-middle">Kemasan Dinding</td>
                                    <td>
                                        <div class="row g-2">
                                            <div class="col-7">
                                                <input type="text" name="kemasan_dinding" class="form-control form-control-sm" placeholder="Contoh: Cat Emulsi">
                                            </div>
                                            <div class="col-5">
                                                <div class="input-group input-group-sm">
                                                    <input type="number" name="kemasan_luas_dinding" class="form-control form-control-sm" placeholder="0.00" step="0.01" min="0">
                                                    <span class="input-group-text">m²</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="tambah-kemasan-row" style="display:none;">
                                    <td class="bg-light fw-semibold align-middle">Kemasan Siling</td>
                                    <td>
                                        <div class="row g-2">
                                            <div class="col-7">
                                                <input type="text" name="kemasan_siling" class="form-control form-control-sm" placeholder="Contoh: Papan Gipsum">
                                            </div>
                                            <div class="col-5">
                                                <div class="input-group input-group-sm">
                                                    <input type="number" name="kemasan_luas_siling" class="form-control form-control-sm" placeholder="0.00" step="0.01" min="0">
                                                    <span class="input-group-text">m²</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                {{-- STATUS --}}
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">Status</td>
                                    <td>
                                        <div class="form-check form-switch mt-1">
                                            <input class="form-check-input" type="checkbox" name="is_active"
                                                id="tambah_ruang_is_active" checked>
                                            <label class="form-check-label" for="tambah_ruang_is_active">Aktif</label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i> Simpan Ruang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ================================================================
     MODAL: EDIT RUANG
================================================================ --}}
<div class="modal fade" id="modalEditRuang" tabindex="-1" aria-labelledby="modalEditRuangLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning">
                <h5 class="modal-title fw-bold text-dark" id="modalEditRuangLabel">
                    <i class="bi bi-pencil-fill me-2"></i>Kemaskini Ruang
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditRuang" method="POST">
                @csrf @method('PUT')
                <input type="hidden" name="_redirect_tab" value="ruang">
                <div class="modal-body p-4">
                    <div class="border rounded-3 overflow-hidden mb-0">
                        <div class="bg-light border-bottom px-4 py-3">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="badge bg-warning text-dark fs-6 px-3 py-2 rounded-pill">D.A 5</span>
                                </div>
                                <div class="col text-center">
                                    <div class="fw-bold text-uppercase text-dark" style="letter-spacing:1px; font-size:0.85rem;">
                                        JABATAN KERJA RAYA MALAYSIA
                                    </div>
                                    <div class="text-muted small">Borang Konfigurasi Ruang — Kemaskini</div>
                                </div>
                                <div class="col-auto text-end">
                                    <small class="text-muted">JKR/DA5/RUANG</small>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-sm mb-0" style="font-size:0.9rem;">
                            <tbody>
                                {{-- ARAS --}}
                                <tr>
                                    <td class="bg-light fw-semibold align-middle" style="width:32%;">
                                        Aras <span class="text-danger">*</span>
                                    </td>
                                    <td>
                                        <select name="aras_id" id="edit_ruang_aras_id" class="form-select form-select-sm" required>
                                            <option value="">— Pilih Aras —</option>
                                            @foreach($arasAll as $arasItem)
                                            <option value="{{ $arasItem->id }}"
                                                data-blok-kod="{{ $arasItem->blok ? $arasItem->blok->kod : '' }}"
                                                data-aras-kod="{{ $arasItem->kod }}"
                                                data-nama="{{ $arasItem->nama }}">
                                                {{ $arasItem->kod }} — {{ $arasItem->nama }}
                                                @if($arasItem->blok) (Blok: {{ $arasItem->blok->kod }})@endif
                                            </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                {{-- KOD RUANG --}}
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">
                                        Kod Ruang <span class="text-danger">*</span>
                                    </td>
                                    <td>
                                        <input type="text" name="kod" id="edit_ruang_kod" class="form-control form-control-sm"
                                            required placeholder="Contoh: R01"
                                            style="text-transform:uppercase; font-family: monospace; font-size:1rem;">
                                        <small class="text-muted">Format: R01, R02, BIL, JK</small>
                                    </td>
                                </tr>
                                {{-- KOD SUB RUANG --}}
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">Kod Sub Ruang</td>
                                    <td>
                                        <input type="text" name="kod_sub_ruang" id="edit_ruang_kod_sub_ruang" class="form-control form-control-sm"
                                            placeholder="Contoh: SR01"
                                            style="text-transform:uppercase; font-family: monospace; font-size:1rem;">
                                    </td>
                                </tr>
                                {{-- NAMA RUANG --}}
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">
                                        Nama Ruang <span class="text-danger">*</span>
                                    </td>
                                    <td>
                                        <input type="text" name="nama" id="edit_ruang_nama" class="form-control form-control-sm"
                                            required placeholder="Contoh: Bilik Mesyuarat">
                                    </td>
                                </tr>
                                {{-- UKURAN RUANG --}}
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">Ukuran Ruang</td>
                                    <td>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <label class="form-label text-muted small mb-1">Luas (m²)</label>
                                                <input type="number" name="luas" id="edit_ruang_luas" class="form-control form-control-sm" placeholder="0.00" step="0.01" min="0">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label text-muted small mb-1">Tinggi (m)</label>
                                                <input type="number" name="tinggi" id="edit_ruang_tinggi" class="form-control form-control-sm" placeholder="0.00" step="0.01" min="0">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                {{-- FUNGSI RUANG --}}
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">Fungsi Ruang</td>
                                    <td>
                                        <input type="text" name="fungsi_ruang" id="edit_ruang_fungsi_ruang" class="form-control form-control-sm"
                                            placeholder="Contoh: Bilik Pejabat, Dewan">
                                    </td>
                                </tr>
                                {{-- KEMASAN --}}
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">Kemasan</td>
                                    <td>
                                        <select name="ada_kemasan" id="edit_ada_kemasan" class="form-select form-select-sm">
                                            <option value="tiada">TIADA</option>
                                            <option value="ada">ADA</option>
                                        </select>
                                    </td>
                                </tr>

                                {{-- ===== KEMASAN SECTION (shown when ADA) ===== --}}
                                <tr class="edit-kemasan-row" id="edit_kemasan_header_row" style="display:none;">
                                    <td colspan="2" class="bg-warning-subtle text-warning-emphasis fw-bold py-2 px-3">
                                        <i class="bi bi-grid-3x3-gap me-1"></i> Butiran Kemasan
                                        <small class="fw-normal text-muted ms-2">(rekod baru akan ditambah untuk sejarah)</small>
                                    </td>
                                </tr>
                                <tr class="edit-kemasan-row" style="display:none;">
                                    <td class="bg-light fw-semibold align-middle">Blok</td>
                                    <td>
                                        <input type="text" name="kemasan_blok" id="edit_kemasan_blok" class="form-control form-control-sm bg-light" readonly placeholder="Auto-isi dari Aras">
                                    </td>
                                </tr>
                                <tr class="edit-kemasan-row" style="display:none;">
                                    <td class="bg-light fw-semibold align-middle">Aras</td>
                                    <td>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <label class="form-label text-muted small mb-1">Kod Aras</label>
                                                <input type="text" name="kemasan_aras" id="edit_kemasan_aras" class="form-control form-control-sm bg-light" readonly placeholder="Auto-isi">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label text-muted small mb-1">Nama Aras</label>
                                                <input type="text" name="kemasan_nama_aras" id="edit_kemasan_nama_aras" class="form-control form-control-sm bg-light" readonly placeholder="Auto-isi">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="edit-kemasan-row" style="display:none;">
                                    <td class="bg-light fw-semibold align-middle">Kod Ruang</td>
                                    <td>
                                        <input type="text" name="kemasan_kod_ruang" id="edit_kemasan_kod_ruang" class="form-control form-control-sm bg-light" readonly placeholder="Auto-isi dari Kod Ruang">
                                    </td>
                                </tr>
                                <tr class="edit-kemasan-row" style="display:none;">
                                    <td class="bg-light fw-semibold align-middle">Kemasan Lantai</td>
                                    <td>
                                        <div class="row g-2">
                                            <div class="col-7">
                                                <input type="text" name="kemasan_lantai" id="edit_kemasan_lantai" class="form-control form-control-sm" placeholder="Contoh: Jubin Seramik">
                                            </div>
                                            <div class="col-5">
                                                <div class="input-group input-group-sm">
                                                    <input type="number" name="kemasan_luas_lantai" id="edit_kemasan_luas_lantai" class="form-control form-control-sm" placeholder="0.00" step="0.01" min="0">
                                                    <span class="input-group-text">m²</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="edit-kemasan-row" style="display:none;">
                                    <td class="bg-light fw-semibold align-middle">Kemasan Dinding</td>
                                    <td>
                                        <div class="row g-2">
                                            <div class="col-7">
                                                <input type="text" name="kemasan_dinding" id="edit_kemasan_dinding" class="form-control form-control-sm" placeholder="Contoh: Cat Emulsi">
                                            </div>
                                            <div class="col-5">
                                                <div class="input-group input-group-sm">
                                                    <input type="number" name="kemasan_luas_dinding" id="edit_kemasan_luas_dinding" class="form-control form-control-sm" placeholder="0.00" step="0.01" min="0">
                                                    <span class="input-group-text">m²</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="edit-kemasan-row" style="display:none;">
                                    <td class="bg-light fw-semibold align-middle">Kemasan Siling</td>
                                    <td>
                                        <div class="row g-2">
                                            <div class="col-7">
                                                <input type="text" name="kemasan_siling" id="edit_kemasan_siling" class="form-control form-control-sm" placeholder="Contoh: Papan Gipsum">
                                            </div>
                                            <div class="col-5">
                                                <div class="input-group input-group-sm">
                                                    <input type="number" name="kemasan_luas_siling" id="edit_kemasan_luas_siling" class="form-control form-control-sm" placeholder="0.00" step="0.01" min="0">
                                                    <span class="input-group-text">m²</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                {{-- STATUS --}}
                                <tr>
                                    <td class="bg-light fw-semibold align-middle">Status</td>
                                    <td>
                                        <div class="form-check form-switch mt-1">
                                            <input class="form-check-input" type="checkbox" name="is_active"
                                                id="edit_ruang_is_active">
                                            <label class="form-check-label" for="edit_ruang_is_active">Aktif</label>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-check-circle me-1"></i> Kemaskini Ruang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Preview PDF -->
<div class="modal fade" id="modalPDF" tabindex="-1" aria-labelledby="modalPDFLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header border-bottom px-4">
                <h5 class="modal-title fw-semibold d-flex align-items-center gap-2" id="modalPDFLabel">
                    <i class="bi bi-file-pdf-fill text-danger"></i>
                    Pratonton D.A.5 &mdash;
                    <span id="modalDA5Nama" class="text-primary"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
    const modals = ['modalTambahAras', 'modalTambahRuang', 'modalEditAras', 'modalEditRuang', 'modalPDF'];
    modals.forEach(id => {
        const el = document.getElementById(id);
        if (el) document.body.appendChild(el);
    });
});

// ===== TAB TOGGLE: Show correct Add button =====
const arasTab    = document.getElementById('aras-tab');
const ruangTab   = document.getElementById('ruang-tab');
const btnTambahAras  = document.getElementById('btnTambahAras');
const btnTambahRuang = document.getElementById('btnTambahRuang');

arasTab.addEventListener('shown.bs.tab', function () {
    btnTambahAras.classList.remove('d-none');
    btnTambahRuang.classList.add('d-none');
});
ruangTab.addEventListener('shown.bs.tab', function () {
    btnTambahAras.classList.add('d-none');
    btnTambahRuang.classList.remove('d-none');
});

// Init button state
@if($activeTab === 'ruang')
    btnTambahAras.classList.add('d-none');
    btnTambahRuang.classList.remove('d-none');
@endif

// ===== EDIT ARAS =====
function editAras(id, blokId, kod, nama, isActive) {
    document.getElementById('formEditAras').action = '/admin/aras/' + id;
    document.getElementById('edit_aras_blok_id').value = blokId;
    document.getElementById('edit_aras_kod').value = kod;
    document.getElementById('edit_aras_nama').value = nama;
    document.getElementById('edit_aras_is_active').checked = isActive;

    var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalEditAras'));
    modal.show();
}

// ===== DELETE ARAS =====
function deleteAras(id, nama) {
    if (confirm('Adakah anda pasti ingin memadam aras "' + nama + '"?\n\nTindakan ini tidak boleh dibatalkan.')) {
        document.getElementById('delete-aras-' + id).submit();
    }
}

// ===== EDIT RUANG (reads from data attributes on the button) =====
function editRuangFromBtn(btn) {
    const id          = btn.dataset.ruangId;
    const arasId      = btn.dataset.arasId;
    const kod         = btn.dataset.kod;
    const kodSubRuang = btn.dataset.kodSubRuang || '';
    const nama        = btn.dataset.nama;
    const luas        = btn.dataset.luas || '';
    const tinggi      = btn.dataset.tinggi || '';
    const fungsiRuang = btn.dataset.fungsiRuang || '';
    const adaKemasan  = btn.dataset.adaKemasan || 'tiada';
    const isActive    = btn.dataset.isActive === '1';
    const kemasanRaw  = btn.dataset.kemasan;

    // Set form action
    document.getElementById('formEditRuang').action = '/admin/ruang/' + id;

    // Set basic fields
    document.getElementById('edit_ruang_aras_id').value       = arasId;
    document.getElementById('edit_ruang_kod').value           = kod;
    document.getElementById('edit_ruang_kod_sub_ruang').value = kodSubRuang;
    document.getElementById('edit_ruang_nama').value          = nama;
    document.getElementById('edit_ruang_luas').value          = luas;
    document.getElementById('edit_ruang_tinggi').value        = tinggi;
    document.getElementById('edit_ruang_fungsi_ruang').value  = fungsiRuang;
    document.getElementById('edit_ruang_is_active').checked   = isActive;

    // Set kemasan select
    const kemasanSelect = document.getElementById('edit_ada_kemasan');
    kemasanSelect.value = adaKemasan;
    toggleEditKemasan(adaKemasan === 'ada');

    // Pre-fill kemasan data from latest record
    if (adaKemasan === 'ada' && kemasanRaw) {
        try {
            const k = JSON.parse(kemasanRaw);
            document.getElementById('edit_kemasan_blok').value       = k.blok || '';
            document.getElementById('edit_kemasan_aras').value       = k.aras || '';
            document.getElementById('edit_kemasan_nama_aras').value  = k.nama_aras || '';
            document.getElementById('edit_kemasan_kod_ruang').value  = k.kod_ruang || '';
            document.getElementById('edit_kemasan_lantai').value     = k.kemasan_lantai || '';
            document.getElementById('edit_kemasan_luas_lantai').value= k.luas_lantai || '';
            document.getElementById('edit_kemasan_dinding').value    = k.kemasan_dinding || '';
            document.getElementById('edit_kemasan_luas_dinding').value= k.luas_dinding || '';
            document.getElementById('edit_kemasan_siling').value     = k.kemasan_siling || '';
            document.getElementById('edit_kemasan_luas_siling').value= k.luas_siling || '';
        } catch(e) {}
    } else if (adaKemasan !== 'ada') {
        // Reset kemasan fields if TIADA
        ['edit_kemasan_blok','edit_kemasan_aras','edit_kemasan_nama_aras','edit_kemasan_kod_ruang',
         'edit_kemasan_lantai','edit_kemasan_luas_lantai','edit_kemasan_dinding','edit_kemasan_luas_dinding',
         'edit_kemasan_siling','edit_kemasan_luas_siling'].forEach(function(fid) {
            const el = document.getElementById(fid);
            if (el) el.value = '';
        });
    }

    // Auto-fill kemasan Blok/Aras/Nama Aras from the currently selected Aras
    syncEditKemasanFromAras();
    // Also sync Kod Ruang
    document.getElementById('edit_kemasan_kod_ruang').value = kod;

    var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalEditRuang'));
    modal.show();
}

// Show/hide Kemasan rows in Edit modal
function toggleEditKemasan(show) {
    document.querySelectorAll('.edit-kemasan-row').forEach(function(row) {
        row.style.display = show ? '' : 'none';
    });
}

// Show/hide Kemasan rows in Tambah modal
function toggleTambahKemasan(show) {
    document.querySelectorAll('.tambah-kemasan-row').forEach(function(row) {
        row.style.display = show ? '' : 'none';
    });
}

// Sync Kemasan Blok/Aras/Nama Aras from the Edit Aras dropdown
function syncEditKemasanFromAras() {
    const sel = document.getElementById('edit_ruang_aras_id');
    if (!sel) return;
    const opt = sel.options[sel.selectedIndex];
    if (opt && opt.value) {
        document.getElementById('edit_kemasan_blok').value      = opt.dataset.blokKod || '';
        document.getElementById('edit_kemasan_aras').value      = opt.dataset.arasKod || '';
        document.getElementById('edit_kemasan_nama_aras').value = opt.dataset.nama || '';
    }
}

// Sync Kemasan Blok/Aras/Nama Aras from the Tambah Aras dropdown
function syncTambahKemasanFromAras() {
    const sel = document.getElementById('tambah_ruang_aras_id');
    if (!sel) return;
    const opt = sel.options[sel.selectedIndex];
    if (opt && opt.value) {
        document.getElementById('tambah_kemasan_blok').value      = opt.dataset.blokKod || '';
        document.getElementById('tambah_kemasan_aras').value      = opt.dataset.arasKod || '';
        document.getElementById('tambah_kemasan_nama_aras').value = opt.dataset.nama || '';
    }
}

// ===== DELETE RUANG =====
function deleteRuang(id, nama) {
    if (confirm('Adakah anda pasti ingin memadam ruang "' + nama + '"?\n\nTindakan ini tidak boleh dibatalkan.')) {
        document.getElementById('delete-ruang-' + id).submit();
    }
}

// ===== AUTO-OPEN MODAL if validation failed =====
@if($errors->any())
    @if(old('_redirect_tab') === 'ruang' || session('_redirect_tab') === 'ruang')
        // Trigger ruang tab
        var ruangTabEl = document.getElementById('ruang-tab');
        bootstrap.Tab.getOrCreateInstance(ruangTabEl).show();

        @if(old('_form_type') === 'edit_ruang')
            // Re-open edit ruang modal (not needed as we redirect back)
        @else
            var modalEl = document.getElementById('modalTambahRuang');
            var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        @endif
    @else
        var modalEl = document.getElementById('modalTambahAras');
        var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    @endif
@endif

// Auto-uppercase kod inputs
document.querySelectorAll('input[name="kod"]').forEach(function(el) {
    el.addEventListener('input', function() {
        this.value = this.value.toUpperCase();
    });
});

// ===== KEMASAN TOGGLE LISTENERS =====
document.addEventListener('DOMContentLoaded', function() {
    // Tambah modal – Kemasan select
    var tambahKemasan = document.getElementById('tambah_ada_kemasan');
    if (tambahKemasan) {
        tambahKemasan.addEventListener('change', function() {
            toggleTambahKemasan(this.value === 'ada');
        });
        // Run on page load if old value was 'ada'
        toggleTambahKemasan(tambahKemasan.value === 'ada');
    }

    // Edit modal – Kemasan select
    var editKemasan = document.getElementById('edit_ada_kemasan');
    if (editKemasan) {
        editKemasan.addEventListener('change', function() {
            toggleEditKemasan(this.value === 'ada');
            if (this.value === 'ada') syncEditKemasanFromAras();
        });
    }

    // Tambah modal – Aras changed → auto-fill Kemasan fields
    var tambahArasEl = document.getElementById('tambah_ruang_aras_id');
    if (tambahArasEl) {
        tambahArasEl.addEventListener('change', syncTambahKemasanFromAras);
    }

    // Edit modal – Aras changed → auto-fill Kemasan fields
    var editArasEl = document.getElementById('edit_ruang_aras_id');
    if (editArasEl) {
        editArasEl.addEventListener('change', function() {
            syncEditKemasanFromAras();
        });
    }

    // Tambah modal – Kod Ruang input → auto-fill Kemasan Kod Ruang
    var tambahKodEl = document.getElementById('tambah_ruang_kod');
    if (tambahKodEl) {
        tambahKodEl.addEventListener('input', function() {
            var km = document.getElementById('tambah_kemasan_kod_ruang');
            if (km) km.value = this.value.toUpperCase();
        });
    }

    // Edit modal – Kod Ruang input → auto-fill Kemasan Kod Ruang
    var editKodEl = document.getElementById('edit_ruang_kod');
    if (editKodEl) {
        editKodEl.addEventListener('input', function() {
            var km = document.getElementById('edit_kemasan_kod_ruang');
            if (km) km.value = this.value.toUpperCase();
        });
    }
});


// ===== D.A.5 FORM JAVASCRIPT LOGIC =====
document.addEventListener('DOMContentLoaded', function () {
    const bodyKontraktorList = document.getElementById('bodyKontraktorList');
    const btnTambahRowKontraktor = document.getElementById('btnTambahRowKontraktor');
    const bodyPerundingList = document.getElementById('bodyPerundingList');
    const btnTambahRowPerunding = document.getElementById('btnTambahRowPerunding');
    const da5_nama_premis = document.getElementById('da5_nama_premis');
    const da5_kod_blok = document.getElementById('da5_kod_blok');
    const btnClearDA5 = document.getElementById('btnClearDA5');

    // Dynamic Row addition for Kontraktor
    function reindexKontraktor() {
        const rows = bodyKontraktorList.querySelectorAll('tr');
        rows.forEach((row, index) => {
            const nameInput = row.querySelector('input[name*="[nama]"]');
            const bidangInput = row.querySelector('input[name*="[bidang]"]');
            if (nameInput) {
                nameInput.name = `kontraktor_list[${index}][nama]`;
                nameInput.placeholder = `${index + 1}.`;
            }
            if (bidangInput) {
                bidangInput.name = `kontraktor_list[${index}][bidang]`;
            }
        });
    }

    if (btnTambahRowKontraktor) {
        btnTambahRowKontraktor.addEventListener('click', function () {
            const idx = bodyKontraktorList.querySelectorAll('tr').length;
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td><input type="text" name="kontraktor_list[${idx}][nama]" class="form-control form-control-sm" placeholder="${idx + 1}."></td>
                <td><input type="text" name="kontraktor_list[${idx}][bidang]" class="form-control form-control-sm"></td>
                <td class="text-center">
                    <button type="button" class="btn btn-outline-danger btn-sm btn-padam-row-kontraktor"><i class="bi bi-trash"></i></button>
                </td>
            `;
            bodyKontraktorList.appendChild(tr);
        });
    }

    if (bodyKontraktorList) {
        bodyKontraktorList.addEventListener('click', function (e) {
            if (e.target.closest('.btn-padam-row-kontraktor')) {
                e.target.closest('tr').remove();
                reindexKontraktor();
            }
        });
    }

    // Dynamic Row addition for Juru Perunding
    function reindexPerunding() {
        const rows = bodyPerundingList.querySelectorAll('tr');
        rows.forEach((row, index) => {
            const nameInput = row.querySelector('input[name*="[nama]"]');
            const bidangInput = row.querySelector('input[name*="[bidang]"]');
            if (nameInput) {
                nameInput.name = `juru_perunding_list[${index}][nama]`;
                nameInput.placeholder = `${index + 1}.`;
            }
            if (bidangInput) {
                bidangInput.name = `juru_perunding_list[${index}][bidang]`;
            }
        });
    }

    if (btnTambahRowPerunding) {
        btnTambahRowPerunding.addEventListener('click', function () {
            const idx = bodyPerundingList.querySelectorAll('tr').length;
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td><input type="text" name="juru_perunding_list[${idx}][nama]" class="form-control form-control-sm" placeholder="${idx + 1}."></td>
                <td><input type="text" name="juru_perunding_list[${idx}][bidang]" class="form-control form-control-sm"></td>
                <td class="text-center">
                    <button type="button" class="btn btn-outline-danger btn-sm btn-padam-row-perunding"><i class="bi bi-trash"></i></button>
                </td>
            `;
            bodyPerundingList.appendChild(tr);
        });
    }

    if (bodyPerundingList) {
        bodyPerundingList.addEventListener('click', function (e) {
            if (e.target.closest('.btn-padam-row-perunding')) {
                e.target.closest('tr').remove();
                reindexPerunding();
            }
        });
    }

    // Dynamic Row addition for Lukisan
    const bodyLukisanList = document.getElementById('bodyLukisanList');
    const btnTambahRowLukisan = document.getElementById('btnTambahRowLukisan');

    function reindexLukisan() {
        if (!bodyLukisanList) return;
        const rows = bodyLukisanList.querySelectorAll('tr');
        rows.forEach((row, index) => {
            const numCell = row.querySelector('.row-number-lukisan');
            if (numCell) numCell.textContent = index + 1;

            const bidangInput = row.querySelector('input[name*="[bidang]"]');
            const tajukInput = row.querySelector('input[name*="[tajuk]"]');
            const refInput = row.querySelector('input[name*="[no_rujukan]"]');
            const catatanInput = row.querySelector('input[name*="[catatan]"]');

            if (bidangInput) bidangInput.name = `lukisan_list[${index}][bidang]`;
            if (tajukInput) tajukInput.name = `lukisan_list[${index}][tajuk]`;
            if (refInput) refInput.name = `lukisan_list[${index}][no_rujukan]`;
            if (catatanInput) catatanInput.name = `lukisan_list[${index}][catatan]`;
        });
    }

    if (btnTambahRowLukisan) {
        btnTambahRowLukisan.addEventListener('click', function () {
            const idx = bodyLukisanList.querySelectorAll('tr').length;
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="text-center row-number-lukisan">${idx + 1}</td>
                <td><input type="text" name="lukisan_list[${idx}][bidang]" class="form-control form-control-sm"></td>
                <td><input type="text" name="lukisan_list[${idx}][tajuk]" class="form-control form-control-sm"></td>
                <td><input type="text" name="lukisan_list[${idx}][no_rujukan]" class="form-control form-control-sm"></td>
                <td><input type="text" name="lukisan_list[${idx}][catatan]" class="form-control form-control-sm"></td>
                <td class="text-center">
                    <button type="button" class="btn btn-outline-danger btn-sm btn-padam-row-lukisan"><i class="bi bi-trash"></i></button>
                </td>
            `;
            bodyLukisanList.appendChild(tr);
        });
    }

    if (bodyLukisanList) {
        bodyLukisanList.addEventListener('click', function (e) {
            if (e.target.closest('.btn-padam-row-lukisan')) {
                e.target.closest('tr').remove();
                reindexLukisan();
            }
        });
    }

    // Keep a copy of the master blocks from the DOM
    const masterBlocks = [];
    if (da5_kod_blok) {
        da5_kod_blok.querySelectorAll('option').forEach(opt => {
            if (opt.value !== "") {
                masterBlocks.push({
                    value: opt.value,
                    text: opt.text,
                    nama: opt.getAttribute('data-nama') || ''
                });
            }
        });
    }

    function restoreMasterBlocks() {
        if (!da5_kod_blok) return;
        da5_kod_blok.innerHTML = '<option value="">-- Pilih Kod Blok --</option>';
        masterBlocks.forEach(b => {
            const opt = document.createElement('option');
            opt.value = b.value;
            opt.text = b.text;
            opt.setAttribute('data-nama', b.nama);
            da5_kod_blok.appendChild(opt);
        });
    }

    // Auto-fill template mappings (for demo compatibility)
    const templates = {
        "PARLIMEN MALAYSIA": {
            kontraktor_utama: "AZMAN HAMZAH SHAH SDN BHD",
            bidang_kontraktor_utama: "PEMBINAAN BANGUNAN",
            kontraktor_list: [
                { nama: "MECTEC ENGINEERING SDN BHD", bidang: "MEKANIKAL & ELEKTRIKAL" },
                { nama: "JAYA AC & VENTILATION LTD", bidang: "SISTEM PENYAMAN UDARA" }
            ],
            juru_perunding_utama: "ARKITEK JKR MALAYSIA",
            bidang_juru_perunding_utama: "REKABENTUK ARKITEK",
            juru_perunding_list: [
                { nama: "MAJU PERUNDING CIVIL S/B", bidang: "STRUKTUR & AWAL" },
                { nama: "PERUNDING ELEKTRIK BERSEKUTU", bidang: "ELEKTRIKAL" }
            ],
            fungsi_asal: "DEWAN PERSIDANGAN & PEJABAT",
            jenis_struktur: "KONKRIT BERTULANG & STRUKTUR BESI",
            no_siri_pendaftaran: "JKR/PARLIMEN/2013/001",
            jangka_hayat: "50",
            kapasiti_penghuni: "1000",
            penggunaan_tenaga: "120000",
            penggunaan_air: "4500",
            status_blok: "aktif",
            bil_aras_atas: "4",
            bil_aras_bawah: "1",
            jumlah_luas_lantai: "12500.50"
        },
        "PEJABAT JKR KUALA LUMPUR": {
            kontraktor_utama: "MUHIBBAH ENGINEERING BHD",
            bidang_kontraktor_utama: "PEMBINAAN AM",
            kontraktor_list: [
                { nama: "KEJURUTERAAN SINAR SDN BHD", bidang: "PENDAWAIAN ELEKTRIK" }
            ],
            juru_perunding_utama: "PERUNDING ALAM BINA",
            bidang_juru_perunding_utama: "ARKITEKTURAL",
            juru_perunding_list: [
                { nama: "SSP CONSULTING ENGINEERS", bidang: "AWAM & STRUKTUR" }
            ],
            fungsi_asal: "PEJABAT KERAJAAN",
            jenis_struktur: "KONKRIT BERTULANG",
            no_siri_pendaftaran: "JKR/PEJABAT-KL/2018/002",
            jangka_hayat: "40",
            kapasiti_penghuni: "500",
            penggunaan_tenaga: "85000",
            penggunaan_air: "2800",
            status_blok: "aktif",
            bil_aras_atas: "6",
            bil_aras_bawah: "0",
            jumlah_luas_lantai: "8900.00"
        },
        "HOSPITAL KUALA LUMPUR": {
            kontraktor_utama: "WCT HOLDINGS BERHAD",
            bidang_kontraktor_utama: "PEMBINAAN KHAS HOSPITAL",
            kontraktor_list: [
                { nama: "MEDIC-SYSTEMS (M) SDN BHD", bidang: "PERALATAN MEDIKAL" }
            ],
            juru_perunding_utama: "ARKITEK MINCONSULT",
            bidang_juru_perunding_utama: "ARKITEK DAN STRUKTUR",
            juru_perunding_list: [
                { nama: "MEP CONSULTANTS SDN BHD", bidang: "MEKANIKAL & ELEKTRIKAL" }
            ],
            fungsi_asal: "KAFETERIA & PUSAT SAJIAN",
            jenis_struktur: "RANGKA KONKRIT",
            no_siri_pendaftaran: "JKR/HKL-KAFE/2008/003",
            jangka_hayat: "50",
            kapasiti_penghuni: "350",
            penggunaan_tenaga: "45000",
            penggunaan_air: "1500",
            status_blok: "aktif",
            bil_aras_atas: "2",
            bil_aras_bawah: "0",
            jumlah_luas_lantai: "1500.00"
        }
    };

    function clearAllFields() {
        document.getElementById('da5_no_dpa').value = '';
        if (da5_kod_blok) da5_kod_blok.value = '';
        document.getElementById('da5_nama_blok').value = '';
        document.getElementById('da5_fungsi_binaan').value = '';
        document.getElementById('da5_jenis_binaan').value = '';
        document.getElementById('da5_gps_x').value = '';
        document.getElementById('da5_gps_y').value = '';
        document.getElementById('da5_kontraktor_utama').value = '';
        document.getElementById('da5_bidang_kontraktor_utama').value = '';
        document.getElementById('da5_juru_perunding_utama').value = '';
        document.getElementById('da5_bidang_juru_perunding_utama').value = '';
        document.getElementById('da5_tahun_siap_bina').value = '';
        document.getElementById('da5_tarikh_siap_bina').value = '';
        document.getElementById('da5_fungsi_asal').value = '';
        document.getElementById('da5_jenis_struktur').value = '';
        document.getElementById('da5_no_siri_pendaftaran').value = '';
        document.getElementById('da5_jangka_hayat').value = '';
        document.getElementById('da5_kapasiti_penghuni').value = '';
        document.getElementById('da5_kos_bina_asal').value = '';
        document.getElementById('da5_nilai_semasa').value = '';
        document.getElementById('da5_tarikh_penilaian').value = '';
        document.getElementById('da5_sumber_pembiayaan').value = '';
        document.getElementById('da5_kod_ptj').value = '';
        document.getElementById('da5_penggunaan_tenaga').value = '';
        document.getElementById('da5_penggunaan_air').value = '';
        document.getElementById('da5_jenis_milikan').value = '';
        document.getElementById('da5_aset_warisan').checked = false;
        document.getElementById('da5_status_blok').value = '';
        document.getElementById('da5_bil_aras_atas').value = '';
        document.getElementById('da5_bil_aras_bawah').value = '';
        document.getElementById('da5_jumlah_luas_lantai').value = '';
        document.getElementById('da5_luas_tapak').value = '';

        // Reset to 2 empty rows for contractors
        bodyKontraktorList.innerHTML = `
            <tr>
                <td><input type="text" name="kontraktor_list[0][nama]" class="form-control form-control-sm" placeholder="1."></td>
                <td><input type="text" name="kontraktor_list[0][bidang]" class="form-control form-control-sm"></td>
                <td class="text-center">
                    <button type="button" class="btn btn-outline-danger btn-sm btn-padam-row-kontraktor"><i class="bi bi-trash"></i></button>
                </td>
            </tr>
            <tr>
                <td><input type="text" name="kontraktor_list[1][nama]" class="form-control form-control-sm" placeholder="2."></td>
                <td><input type="text" name="kontraktor_list[1][bidang]" class="form-control form-control-sm"></td>
                <td class="text-center">
                    <button type="button" class="btn btn-outline-danger btn-sm btn-padam-row-kontraktor"><i class="bi bi-trash"></i></button>
                </td>
            </tr>
        `;

        // Reset to 2 empty rows for perundings
        bodyPerundingList.innerHTML = `
            <tr>
                <td><input type="text" name="juru_perunding_list[0][nama]" class="form-control form-control-sm" placeholder="1."></td>
                <td><input type="text" name="juru_perunding_list[0][bidang]" class="form-control form-control-sm"></td>
                <td class="text-center">
                    <button type="button" class="btn btn-outline-danger btn-sm btn-padam-row-perunding"><i class="bi bi-trash"></i></button>
                </td>
            </tr>
            <tr>
                <td><input type="text" name="juru_perunding_list[1][nama]" class="form-control form-control-sm" placeholder="2."></td>
                <td><input type="text" name="juru_perunding_list[1][bidang]" class="form-control form-control-sm"></td>
                <td class="text-center">
                    <button type="button" class="btn btn-outline-danger btn-sm btn-padam-row-perunding"><i class="bi bi-trash"></i></button>
                </td>
            </tr>
        `;
    }

    // Initialize Select2 on the premise dropdown
    if (da5_nama_premis) {
        $(da5_nama_premis).select2({
            theme: 'bootstrap-5',
            placeholder: '-- Pilih Premis --',
            allowClear: true,
            tags: true, // Enables typing custom tags directly
            createTag: function (params) {
                const term = $.trim(params.term);
                if (term === '') {
                    return null;
                }
                return {
                    id: term,
                    text: term,
                    newTag: true
                };
            }
        });
    }

    if (da5_nama_premis) {
        $(da5_nama_premis).on('change', function () {
            const selectedVal = this.value;
            const hiddenInput = document.getElementById('da5_nama_premis_hidden');
            const manualWrapper = document.getElementById('wrapper_nama_premis_manual');
            const manualInput = document.getElementById('da5_nama_premis_manual');

            if (selectedVal === "manual") {
                manualWrapper.classList.remove('d-none');
                hiddenInput.value = manualInput.value;
                clearAllFields();
                restoreMasterBlocks();
            } else if (selectedVal === "") {
                manualWrapper.classList.add('d-none');
                hiddenInput.value = "";
                clearAllFields();
                restoreMasterBlocks();
            } else if (!isNaN(selectedVal)) {
                // Numeric database ID
                manualWrapper.classList.add('d-none');
                const selectedOption = this.options[this.selectedIndex];
                const premisName = selectedOption ? selectedOption.getAttribute('data-nama') : '';
                hiddenInput.value = premisName;

                // Fetch data from database
                fetch(`/admin/aras-ruang/premis/${selectedVal}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            alert(data.error);
                            return;
                        }

                        // Populate D.A.3 premise fields
                        document.getElementById('da5_no_dpa').value = data.no_dpa || '';
                        document.getElementById('da5_gps_x').value = data.koordinat_x || '';
                        document.getElementById('da5_gps_y').value = data.koordinat_y || '';
                        document.getElementById('da5_kos_bina_asal').value = data.kos_siap_bina_asal || '';
                        document.getElementById('da5_nilai_semasa').value = data.nilai_semasa || '';
                        document.getElementById('da5_sumber_pembiayaan').value = data.sumber_pembiayaan || '';
                        document.getElementById('da5_kod_ptj').value = data.kod_ptj || '';
                        document.getElementById('da5_aset_warisan').checked = !!data.aset_warisan;

                        if (data.status_premis) {
                            document.getElementById('da5_status_blok').value = data.status_premis.toLowerCase() === 'aktif' ? 'aktif' : 'tidak_aktif';
                        } else {
                            document.getElementById('da5_status_blok').value = '';
                        }

                        // Handle ownership / milikan based on first tanah record
                        if (data.tanah && data.tanah.length > 0) {
                            const firstTanah = data.tanah[0];
                            const hakmilik = (firstTanah.jenis_hakmilik || firstTanah.status_hakmilik || '').toLowerCase();
                            if (hakmilik.includes('pajak')) {
                                document.getElementById('da5_jenis_milikan').value = 'Pajakan';
                            } else if (hakmilik.includes('bebas') || hakmilik.includes('kekal')) {
                                document.getElementById('da5_jenis_milikan').value = 'Pegangan Bebas';
                            } else {
                                document.getElementById('da5_jenis_milikan').value = '';
                            }
                        } else {
                            document.getElementById('da5_jenis_milikan').value = '';
                        }

                        // Parse and set tarikh/tahun siap bina
                        if (data.tarikh_siap_bina) {
                            const dateStr = data.tarikh_siap_bina.substring(0, 10);
                            document.getElementById('da5_tarikh_siap_bina').value = dateStr;
                            const yearStr = dateStr.substring(0, 4);
                            document.getElementById('da5_tahun_siap_bina').value = yearStr;
                        } else {
                            document.getElementById('da5_tarikh_siap_bina').value = '';
                            document.getElementById('da5_tahun_siap_bina').value = '';
                        }

                        // Parse and set tarikh penilaian
                        if (data.tarikh_penilaian) {
                            document.getElementById('da5_tarikh_penilaian').value = data.tarikh_penilaian.substring(0, 10);
                        } else {
                            document.getElementById('da5_tarikh_penilaian').value = '';
                        }

                        // Merge mock lists for pre-seeded premises, otherwise clear
                        const normalizedName = premisName.toUpperCase();
                        if (templates[normalizedName]) {
                            const t = templates[normalizedName];
                            // Populate remaining template details
                            document.getElementById('da5_kontraktor_utama').value = t.kontraktor_utama || '';
                            document.getElementById('da5_bidang_kontraktor_utama').value = t.bidang_kontraktor_utama || '';
                            document.getElementById('da5_juru_perunding_utama').value = t.juru_perunding_utama || '';
                            document.getElementById('da5_bidang_juru_perunding_utama').value = t.bidang_juru_perunding_utama || '';
                            document.getElementById('da5_fungsi_asal').value = t.fungsi_asal || '';
                            document.getElementById('da5_jenis_struktur').value = t.jenis_struktur || '';
                            document.getElementById('da5_no_siri_pendaftaran').value = t.no_siri_pendaftaran || '';
                            document.getElementById('da5_jangka_hayat').value = t.jangka_hayat || '';
                            document.getElementById('da5_kapasiti_penghuni').value = t.kapasiti_penghuni || '';
                            document.getElementById('da5_penggunaan_tenaga').value = t.penggunaan_tenaga || '';
                            document.getElementById('da5_penggunaan_air').value = t.penggunaan_air || '';
                            document.getElementById('da5_bil_aras_atas').value = t.bil_aras_atas || '';
                            document.getElementById('da5_bil_aras_bawah').value = t.bil_aras_bawah || '';
                            document.getElementById('da5_jumlah_luas_lantai').value = t.jumlah_luas_lantai || '';

                            // Populate dynamic contractors
                            bodyKontraktorList.innerHTML = '';
                            (t.kontraktor_list || []).forEach((item, idx) => {
                                const tr = document.createElement('tr');
                                tr.innerHTML = `
                                    <td><input type="text" name="kontraktor_list[${idx}][nama]" class="form-control form-control-sm" value="${item.nama}" placeholder="${idx + 1}."></td>
                                    <td><input type="text" name="kontraktor_list[${idx}][bidang]" class="form-control form-control-sm" value="${item.bidang}"></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-danger btn-sm btn-padam-row-kontraktor"><i class="bi bi-trash"></i></button>
                                    </td>
                                `;
                                bodyKontraktorList.appendChild(tr);
                            });

                            // Populate dynamic perundings
                            bodyPerundingList.innerHTML = '';
                            (t.juru_perunding_list || []).forEach((item, idx) => {
                                const tr = document.createElement('tr');
                                tr.innerHTML = `
                                    <td><input type="text" name="juru_perunding_list[${idx}][nama]" class="form-control form-control-sm" value="${item.nama}" placeholder="${idx + 1}."></td>
                                    <td><input type="text" name="juru_perunding_list[${idx}][bidang]" class="form-control form-control-sm" value="${item.bidang}"></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-danger btn-sm btn-padam-row-perunding"><i class="bi bi-trash"></i></button>
                                    </td>
                                `;
                                bodyPerundingList.appendChild(tr);
                            });
                        } else {
                            // Clear demo details for new premises
                            document.getElementById('da5_kontraktor_utama').value = '';
                            document.getElementById('da5_bidang_kontraktor_utama').value = '';
                            document.getElementById('da5_juru_perunding_utama').value = '';
                            document.getElementById('da5_bidang_juru_perunding_utama').value = '';
                            document.getElementById('da5_fungsi_asal').value = '';
                            document.getElementById('da5_jenis_struktur').value = '';
                            document.getElementById('da5_no_siri_pendaftaran').value = '';
                            document.getElementById('da5_jangka_hayat').value = '';
                            document.getElementById('da5_kapasiti_penghuni').value = '';
                            document.getElementById('da5_penggunaan_tenaga').value = '';
                            document.getElementById('da5_penggunaan_air').value = '';
                            document.getElementById('da5_bil_aras_atas').value = '';
                            document.getElementById('da5_bil_aras_bawah').value = '';
                            document.getElementById('da5_jumlah_luas_lantai').value = '';

                            // Reset contractor/consultant rows
                            bodyKontraktorList.innerHTML = `
                                <tr>
                                    <td><input type="text" name="kontraktor_list[0][nama]" class="form-control form-control-sm" placeholder="1."></td>
                                    <td><input type="text" name="kontraktor_list[0][bidang]" class="form-control form-control-sm"></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-danger btn-sm btn-padam-row-kontraktor"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="kontraktor_list[1][nama]" class="form-control form-control-sm" placeholder="2."></td>
                                    <td><input type="text" name="kontraktor_list[1][bidang]" class="form-control form-control-sm"></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-danger btn-sm btn-padam-row-kontraktor"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                            `;
                            bodyPerundingList.innerHTML = `
                                <tr>
                                    <td><input type="text" name="juru_perunding_list[0][nama]" class="form-control form-control-sm" placeholder="1."></td>
                                    <td><input type="text" name="juru_perunding_list[0][bidang]" class="form-control form-control-sm"></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-danger btn-sm btn-padam-row-perunding"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="juru_perunding_list[1][nama]" class="form-control form-control-sm" placeholder="2."></td>
                                    <td><input type="text" name="juru_perunding_list[1][bidang]" class="form-control form-control-sm"></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-danger btn-sm btn-padam-row-perunding"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                            `;
                        }

                        // Rebuild block dropdown options dynamically
                        if (da5_kod_blok) {
                            da5_kod_blok.innerHTML = '<option value="">-- Pilih Kod Blok --</option>';

                            // Add blocks
                            if (data.blok && data.blok.length > 0) {
                                data.blok.forEach(b => {
                                    const kod = b.kod_blok_myspata || b.bil || 'Blok';
                                    const opt = document.createElement('option');
                                    opt.value = kod;
                                    opt.text = `${kod} - ${b.nama_blok}`;
                                    opt.setAttribute('data-nama', b.nama_blok);
                                    opt.setAttribute('data-type', 'blok');
                                    opt.setAttribute('data-fungsi', b.fungsi_binaan || '');
                                    opt.setAttribute('data-luas', b.luas_tapak || '');
                                    da5_kod_blok.appendChild(opt);
                                });
                            }

                            // Add binaan luar
                            if (data.binaan_luar && data.binaan_luar.length > 0) {
                                data.binaan_luar.forEach(bl => {
                                    const kod = bl.kod_binaan_luar_myspata || bl.bil || 'BL';
                                    const opt = document.createElement('option');
                                    opt.value = kod;
                                    opt.text = `${kod} - ${bl.nama_binaan_luar}`;
                                    opt.setAttribute('data-nama', bl.nama_binaan_luar);
                                    opt.setAttribute('data-type', 'binaan_luar');
                                    opt.setAttribute('data-jenis', bl.jenis_binaan_luar || '');
                                    opt.setAttribute('data-luas', bl.luas_tapak || '');
                                    da5_kod_blok.appendChild(opt);
                                });
                            }

                            // If no blocks or binaan luar found, restore the master blocks
                            if ((!data.blok || data.blok.length === 0) && (!data.binaan_luar || data.binaan_luar.length === 0)) {
                                restoreMasterBlocks();
                            }
                        }

                        // Clear block/binaan luar inputs initially
                        document.getElementById('da5_nama_blok').value = '';
                        document.getElementById('da5_fungsi_binaan').value = '';
                        document.getElementById('da5_jenis_binaan').value = '';
                        document.getElementById('da5_luas_tapak').value = '';
                    })
                    .catch(err => {
                        console.error('Error fetching premise details:', err);
                    });
            } else {
                // String custom tag (typed name)
                manualWrapper.classList.add('d-none');
                hiddenInput.value = selectedVal;
                clearAllFields();
                restoreMasterBlocks();
            }
        });
    }

    // Handle manual premise text input change
    const da5_nama_premis_manual = document.getElementById('da5_nama_premis_manual');
    if (da5_nama_premis_manual) {
        da5_nama_premis_manual.addEventListener('input', function () {
            document.getElementById('da5_nama_premis_hidden').value = this.value;
        });
    }

    // On page load, check if a database premise is selected and fetch its blocks
    if (da5_nama_premis && da5_nama_premis.value && da5_nama_premis.value !== "manual" && !isNaN(da5_nama_premis.value)) {
        const selectedBlockVal = "{{ old('kod_blok', $da5_data['kod_blok'] ?? '') }}";
        fetch(`/admin/aras-ruang/premis/${da5_nama_premis.value}`)
            .then(response => response.json())
            .then(data => {
                if (da5_kod_blok) {
                    da5_kod_blok.innerHTML = '<option value="">-- Pilih Kod Blok --</option>';

                    // Add blocks
                    if (data.blok && data.blok.length > 0) {
                        data.blok.forEach(b => {
                            const kod = b.kod_blok_myspata || b.bil || 'Blok';
                            const opt = document.createElement('option');
                            opt.value = kod;
                            opt.text = `${kod} - ${b.nama_blok}`;
                            opt.setAttribute('data-nama', b.nama_blok);
                            opt.setAttribute('data-type', 'blok');
                            opt.setAttribute('data-fungsi', b.fungsi_binaan || '');
                            opt.setAttribute('data-luas', b.luas_tapak || '');
                            if (kod === selectedBlockVal) {
                                opt.selected = true;
                            }
                            da5_kod_blok.appendChild(opt);
                        });
                    }

                    // Add binaan luar
                    if (data.binaan_luar && data.binaan_luar.length > 0) {
                        data.binaan_luar.forEach(bl => {
                            const kod = bl.kod_binaan_luar_myspata || bl.bil || 'BL';
                            const opt = document.createElement('option');
                            opt.value = kod;
                            opt.text = `${kod} - ${bl.nama_binaan_luar}`;
                            opt.setAttribute('data-nama', bl.nama_binaan_luar);
                            opt.setAttribute('data-type', 'binaan_luar');
                            opt.setAttribute('data-jenis', bl.jenis_binaan_luar || '');
                            opt.setAttribute('data-luas', bl.luas_tapak || '');
                            if (kod === selectedBlockVal) {
                                opt.selected = true;
                            }
                            da5_kod_blok.appendChild(opt);
                        });
                    }

                    // If no blocks/binaan luar found, restore the master blocks
                    if ((!data.blok || data.blok.length === 0) && (!data.binaan_luar || data.binaan_luar.length === 0)) {
                        restoreMasterBlocks();
                        da5_kod_blok.value = selectedBlockVal;
                    }
                }
            })
            .catch(err => console.error('Error initializing blocks on load:', err));
    }

    // Auto-fill nama_blok and other attributes from selected kod_blok
    if (da5_kod_blok) {
        da5_kod_blok.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            if (!selectedOption || this.value === "") {
                document.getElementById('da5_nama_blok').value = '';
                document.getElementById('da5_fungsi_binaan').value = '';
                document.getElementById('da5_jenis_binaan').value = '';
                document.getElementById('da5_luas_tapak').value = '';
                return;
            }

            const namaBlok = selectedOption.getAttribute('data-nama') || '';
            const type = selectedOption.getAttribute('data-type') || '';
            const luas = selectedOption.getAttribute('data-luas') || '';

            document.getElementById('da5_nama_blok').value = namaBlok;
            document.getElementById('da5_luas_tapak').value = luas;

            if (type === 'blok') {
                const fungsi = selectedOption.getAttribute('data-fungsi') || '';
                document.getElementById('da5_fungsi_binaan').value = fungsi;
                document.getElementById('da5_jenis_binaan').value = '';
            } else if (type === 'binaan_luar') {
                const jenis = selectedOption.getAttribute('data-jenis') || '';
                document.getElementById('da5_fungsi_binaan').value = '';
                document.getElementById('da5_jenis_binaan').value = jenis || namaBlok;
            } else {
                // For master block codes
                document.getElementById('da5_fungsi_binaan').value = '';
                document.getElementById('da5_jenis_binaan').value = '';
            }
        });
    }

    // Clear data confirmation
    if (btnClearDA5) {
        btnClearDA5.addEventListener('click', function () {
            if (confirm('Adakah anda pasti ingin memadam data sesi D.A.5?')) {
                document.getElementById('clearFormDA5').submit();
            }
        });
    }

    const modalEl = document.getElementById('modalPDF');
    if (modalEl) {
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
</script>

<style>
/* Tab styling */
#arasRuangTabs .nav-link {
    border-radius: 0.5rem 0.5rem 0 0;
    border: 1px solid transparent;
    color: #6c757d;
    transition: all 0.2s;
}
#arasRuangTabs .nav-link.active {
    border-color: #dee2e6 #dee2e6 #fff;
    color: #2563eb;
    background: #fff;
}
#arasRuangTabs .nav-link:hover:not(.active) {
    background: #f8f9fa;
    border-color: #dee2e6;
    color: #495057;
}

/* Table improvements */
#arasTable th, #ruangTable th {
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    color: #6c757d;
}
#arasTable td, #ruangTable td {
    vertical-align: middle;
    font-size: 0.875rem;
}
#arasTable tbody tr:hover,
#ruangTable tbody tr:hover {
    background-color: #f8faff;
}

/* Modal form table */
.modal .table-bordered td {
    padding: 0.6rem 0.85rem;
}
.modal .table-bordered td:first-child {
    white-space: nowrap;
}

/* Badge subtle (Bootstrap 5.3 compatible fallback) */
.bg-primary-subtle  { background-color: #dbeafe !important; }
.bg-success-subtle  { background-color: #d1fae5 !important; }
.bg-secondary-subtle { background-color: #f1f5f9 !important; }
.text-primary { color: #2563eb !important; }
.text-success { color: #059669 !important; }
.border-primary-subtle  { border-color: #93c5fd !important; }
.border-success-subtle  { border-color: #6ee7b7 !important; }
.border-secondary-subtle { border-color: #cbd5e1 !important; }
</style>
@endsection
