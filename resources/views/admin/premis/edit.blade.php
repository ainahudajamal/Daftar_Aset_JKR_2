@extends('layouts.app')

@section('title', 'Edit Premis')

@section('styles')
<style>
    .tab-content > .tab-pane {
        display: none;
    }
    .tab-content > .active {
        display: block;
    }
    .nav-tabs .nav-link.active {
        color: var(--primary) !important;
        border-color: #dee2e6 #dee2e6 #fff !important;
        font-weight: 600;
    }
    .nav-tabs .nav-link {
        color: #6c757d;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1"><i class="bi bi-pencil"></i> Edit Premis</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.premis.index') }}">Premis</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.premis.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.premis.update', $premis->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Tab Navigation -->
                <ul class="nav nav-tabs mb-4" id="premisTab">
                    <li class="nav-item">
                        <a class="nav-link active" id="helaian1-tab" data-bs-toggle="tab" href="#helaian1">
                            <i class="bi bi-1-circle"></i> Helaian 1 — Maklumat Premis
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="helaian2-tab" data-bs-toggle="tab" href="#helaian2">
                            <i class="bi bi-2-circle"></i> Helaian 2 — Maklumat Tanah & Lukisan
                        </a>
                    </li>
                </ul>

                <div class="tab-content">

                    <!-- ==================== HELAIAN 1 ==================== -->
                    <div class="tab-pane fade show active" id="helaian1">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header text-white" style="background-color: var(--primary);">
                                <h5 class="mb-0">D.A.3 — KAD PENDAFTARAN ASET TAK ALIH (Premis Hak Milik)</h5>
                                <small>Helaian 1</small>
                            </div>
                            <div class="card-body">

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nama Premis <span class="text-danger">*</span></label>
                                        <input type="text" name="nama_premis" class="form-control" required value="{{ old('nama_premis', $premis->nama_premis) }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">**NO DPA</label>
                                        <div class="d-flex" style="border: 1px solid #dee2e6; width: fit-content;">
                                            @for ($i = 0; $i < 24; $i++)
                                                <input type="text" maxlength="1" class="dpa-box"
                                                    style="width: 30px; height: 38px; border: none; border-right: 1px solid #dee2e6; text-align: center; font-weight: bold; background: white; outline: none;"
                                                    value="{{ $premis->no_dpa ? mb_substr($premis->no_dpa, $i, 1) : '' }}">
                                            @endfor
                                        </div>
                                        <input type="hidden" name="no_dpa" id="no_dpa" value="{{ $premis->no_dpa }}">
                                        <small class="text-muted">** Nombor Daftar Premis Aset</small>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Alamat Premis</label>
                                        <textarea name="alamat_premis" class="form-control" rows="3">{{ old('alamat_premis', $premis->alamat_premis) }}</textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Poskod</label>
                                        <input type="text" name="poskod" class="form-control" value="{{ old('poskod', $premis->poskod) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Koordinat GPS — X</label>
                                        <input type="text" name="koordinat_x" class="form-control" value="{{ old('koordinat_x', $premis->koordinat_x) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Koordinat GPS — Y</label>
                                        <input type="text" name="koordinat_y" class="form-control" value="{{ old('koordinat_y', $premis->koordinat_y) }}">
                                    </div>
                                </div>

                                <hr>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Kumpulan Agensi</label>
                                        <input type="text" name="kumpulan_agensi" class="form-control" value="{{ old('kumpulan_agensi', $premis->kumpulan_agensi) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Daerah</label>
                                        <input type="text" name="daerah" class="form-control" value="{{ old('daerah', $premis->daerah) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Kementerian</label>
                                        <input type="text" name="kementerian" class="form-control" value="{{ old('kementerian', $premis->kementerian) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Mukim / Bandar</label>
                                        <input type="text" name="mukim_bandar" class="form-control" value="{{ old('mukim_bandar', $premis->mukim_bandar) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Jabatan</label>
                                        <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $premis->jabatan) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Kategori Premis</label>
                                        <input type="text" name="kategori_premis" class="form-control" value="{{ old('kategori_premis', $premis->kategori_premis) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Negara</label>
                                        <input type="text" name="negara" class="form-control" value="{{ old('negara', $premis->negara ?? 'Malaysia') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Sub Kategori</label>
                                        <input type="text" name="sub_kategori" class="form-control" value="{{ old('sub_kategori', $premis->sub_kategori) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Negeri</label>
                                        <input type="text" name="negeri" list="senarai-negeri" class="form-control" placeholder="Taip atau pilih negeri..." value="{{ old('negeri', $premis->negeri) }}">
                                        <datalist id="senarai-negeri">
                                            @foreach(['Johor','Kedah','Kelantan','Melaka','Negeri Sembilan','Pahang','Perak','Perlis','Pulau Pinang','Sabah','Sarawak','Selangor','Terengganu','Wilayah Persekutuan Kuala Lumpur','Wilayah Persekutuan Labuan','Wilayah Persekutuan Putrajaya'] as $negeri)
                                            <option value="{{ $negeri }}"></option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Jumlah Keluasan Premis</label>
                                        <input type="text" name="jumlah_keluasan" class="form-control" value="{{ old('jumlah_keluasan', $premis->jumlah_keluasan) }}">
                                    </div>
                                </div>

                                <hr>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Status Premis</label>
                                        <select name="status_premis" class="form-select">
                                            <option value="Aktif" {{ old('status_premis', $premis->status_premis) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="Tidak Aktif" {{ old('status_premis', $premis->status_premis) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Aset Warisan</label>
                                        <div class="form-check form-switch mt-2">
                                            <input class="form-check-input" type="checkbox" name="aset_warisan" id="aset_warisan" value="1" {{ old('aset_warisan', $premis->aset_warisan) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="aset_warisan">Ya</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Kos Siap Bina Asal (RM)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">RM</span>
                                            <input type="number" name="kos_siap_bina_asal" class="form-control" step="0.01" value="{{ old('kos_siap_bina_asal', $premis->kos_siap_bina_asal) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Sumber Pembiayaan</label>
                                        <input type="text" name="sumber_pembiayaan" class="form-control" value="{{ old('sumber_pembiayaan', $premis->sumber_pembiayaan) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">*Kos Tambahan PPUN (RM)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">RM</span>
                                            <input type="number" name="kos_tambahan_ppun" class="form-control" step="0.01" value="{{ old('kos_tambahan_ppun', $premis->kos_tambahan_ppun) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Kod PTJ</label>
                                        <input type="text" name="kod_ptj" class="form-control" value="{{ old('kod_ptj', $premis->kod_ptj) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Kos Keseluruhan Aset (RM)</label>
                                        <input type="number" name="kos_keseluruhan" class="form-control" step="0.01" value="{{ old('kos_keseluruhan', $premis->kos_keseluruhan) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nilai Semasa (RM)</label>
                                        <input type="number" name="nilai_semasa" class="form-control" step="0.01" value="{{ old('nilai_semasa', $premis->nilai_semasa) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Tarikh Siap Bina</label>
                                        <input type="date" name="tarikh_siap_bina" class="form-control" value="{{ old('tarikh_siap_bina', $premis->tarikh_siap_bina?->format('Y-m-d')) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Tarikh Penilaian</label>
                                        <input type="date" name="tarikh_penilaian" class="form-control" value="{{ old('tarikh_penilaian', $premis->tarikh_penilaian?->format('Y-m-d')) }}">
                                    </div>
                                    <div class="col-md-6 d-flex align-items-center">
                                        <small class="text-muted fst-italic">* Pemulihan, Pemuliharaan, Ubahsuai & Naiktaraf</small>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <label class="form-label fw-semibold">Bil. Blok Bangunan</label>
                                                <input type="number" name="bil_blok_bangunan" class="form-control" min="0" value="{{ old('bil_blok_bangunan', $premis->bil_blok_bangunan ?? 0) }}">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label fw-semibold">Bil. Binaan Luar</label>
                                                <input type="text" name="bil_binaan_luar" class="form-control" value="{{ old('bil_binaan_luar', $premis->bil_binaan_luar) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Catatan</label>
                                        <textarea name="catatan" class="form-control" rows="3">{{ old('catatan', $premis->catatan) }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Gambar Premis</label>
                                        @if($premis->gambar_premis)
                                            <div class="mb-2">
                                                <div class="position-relative d-inline-block">
                                                    <img src="{{ asset('storage/' . $premis->gambar_premis) }}"
                                                        alt="Gambar Premis" id="previewGambar"
                                                        style="max-height: 150px; border-radius: 6px; border: 1px solid #dee2e6;">
                                                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                                        onclick="padamGambar()" title="Padam Gambar">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </div>
                                                <input type="hidden" name="padam_gambar" id="padam_gambar" value="0">
                                            </div>
                                        @else
                                            <input type="hidden" name="padam_gambar" id="padam_gambar" value="0">
                                        @endif
                                        <input type="file" name="gambar_premis" class="form-control" accept="image/*">
                                        <small class="text-muted">Kosongkan jika tidak mahu tukar gambar</small>
                                    </div>
                                </div>



                                <div class="d-flex justify-content-end mt-4">
                                    <button type="button" class="btn btn-primary" onclick="nextTab()">
                                     Seterusnya <i class="bi bi-arrow-right"></i>
                                 </button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- ==================== HELAIAN 2 ==================== -->
                    <div class="tab-pane fade" id="helaian2">

                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header text-white" style="background-color: #334155;">
                            <h5 class="mb-0">Maklumat Tanah (jika ada)</h5>
                            <small>Helaian 2</small>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle" style="min-width:1100px;">
                                    <thead style="background-color: #334155; color: white;">
                                        <tr>
                                            <th style="width:40px;">Bil</th>
                                                <th style="min-width:90px;">No. Lot</th>
                                                <th style="min-width:170px;">Status Hak Milik Tanah</th>
                                                <th style="min-width:120px;">Keluasan Tanah</th>
                                                <th style="min-width:110px;">No. Hakmilik</th>
                                                <th style="min-width:120px;">Jenis Hakmilik</th>
                                                <th style="min-width:120px;">Kegunaan Tanah</th>
                                                <th style="min-width:130px;">Harga Perolehan (RM)</th>
                                                <th style="min-width:120px;">Harga Semasa (RM)</th>
                                                <th style="width:60px;">Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tanah-body">
                                            @forelse($premis->tanah as $index => $tanah)
                                            @php
                                                $statusTetap = ['Hakmilik','Rizab','Strata','Lain-lain'];
                                                $isLainLain = !in_array($tanah->status_hakmilik, $statusTetap);
                                            @endphp
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td><input type="text" name="tanah[{{ $index }}][no_lot]" class="form-control form-control-sm" value="{{ $tanah->no_lot }}"></td>
                                                <td>
                                                    <select name="tanah[{{ $index }}][status_hakmilik]" class="form-select form-select-sm status-hakmilik-select" onchange="toggleLainLain(this)">
                                                        <option value="">-- Pilih --</option>
                                                        @foreach($statusTetap as $s)
                                                        <option {{ (!$isLainLain && $tanah->status_hakmilik == $s) ? 'selected' : ($isLainLain && $s == 'Lain-lain' ? 'selected' : '') }}>{{ $s }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="text" name="tanah[{{ $index }}][status_hakmilik_lain]"
                                                        class="form-control form-control-sm mt-1 {{ $isLainLain ? '' : 'd-none' }}"
                                                        placeholder="Nyatakan..."
                                                        value="{{ $isLainLain ? $tanah->status_hakmilik : '' }}">
                                                </td>
                                                <td><input type="text" name="tanah[{{ $index }}][keluasan_tanah]" class="form-control form-control-sm" value="{{ $tanah->keluasan_tanah }}"></td>
                                                <td><input type="text" name="tanah[{{ $index }}][no_hakmilik]" class="form-control form-control-sm" value="{{ $tanah->no_hakmilik }}"></td>
                                                <td>
                                                    <select name="tanah[{{ $index }}][jenis_hakmilik]" class="form-select form-select-sm">
                                                        <option value="">-- Pilih --</option>
                                                        @foreach(['Kekal','Pajak'] as $j)
                                                        <option {{ $tanah->jenis_hakmilik == $j ? 'selected' : '' }}>{{ $j }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input type="text" name="tanah[{{ $index }}][kegunaan_tanah]" class="form-control form-control-sm" value="{{ $tanah->kegunaan_tanah }}"></td>
                                                <td><input type="number" name="tanah[{{ $index }}][harga_perolehan]" class="form-control form-control-sm" step="0.01" value="{{ $tanah->harga_perolehan }}"></td>
                                                <td><input type="number" name="tanah[{{ $index }}][harga_semasa]" class="form-control form-control-sm" step="0.01" value="{{ $tanah->harga_semasa }}"></td>
                                                <td class="text-center"><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td class="text-center">1</td>
                                                <td><input type="text" name="tanah[0][no_lot]" class="form-control form-control-sm"></td>
                                                <td>
                                                    <select name="tanah[0][status_hakmilik]" class="form-select form-select-sm status-hakmilik-select" onchange="toggleLainLain(this)">
                                                        <option value="">-- Pilih --</option>
                                                        <option>Hakmilik</option>
                                                        <option>Rizab</option>
                                                        <option>Strata</option>
                                                        <option>Lain-lain</option>
                                                    </select>
                                                    <input type="text" name="tanah[0][status_hakmilik_lain]" class="form-control form-control-sm mt-1 d-none" placeholder="Nyatakan...">
                                                </td>
                                                <td><input type="text" name="tanah[0][keluasan_tanah]" class="form-control form-control-sm"></td>
                                                <td><input type="text" name="tanah[0][no_hakmilik]" class="form-control form-control-sm"></td>
                                                <td>
                                                    <select name="tanah[0][jenis_hakmilik]" class="form-select form-select-sm">
                                                        <option value="">-- Pilih --</option>
                                                        <option>Kekal</option>
                                                        <option>Pajak</option>
                                                    </select>
                                                </td>
                                                <td><input type="text" name="tanah[0][kegunaan_tanah]" class="form-control form-control-sm"></td>
                                                <td><input type="number" name="tanah[0][harga_perolehan]" class="form-control form-control-sm" step="0.01"></td>
                                                <td><input type="number" name="tanah[0][harga_semasa]" class="form-control form-control-sm" step="0.01"></td>
                                                <td class="text-center"><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <button type="button" class="btn btn-success btn-sm mt-2" onclick="addTanahRow()">
                                    <i class="bi bi-plus-circle"></i> Tambah Baris
                                </button>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header text-white" style="background-color: #4a5568 !important;">
                                <h5 class="mb-0">Senarai Lukisan Siap Bina</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle" style="min-width:700px;">
                                        <thead style="background-color: #4a5568; color: white;">
                                            <tr>
                                                <th style="width:40px;">Bil</th>
                                                <th style="min-width:130px;">Bidang</th>
                                                <th style="min-width:180px;">Tajuk Lukisan</th>
                                                <th style="min-width:140px;">No. Rujukan</th>
                                                <th style="min-width:180px;">Catatan</th>
                                                <th style="width:60px;">Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="lukisan-body">
                                            @forelse($premis->lukisan as $index => $lukisan)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td><input type="text" name="lukisan[{{ $index }}][bidang]" class="form-control form-control-sm" value="{{ $lukisan->bidang }}"></td>
                                                <td><input type="text" name="lukisan[{{ $index }}][tajuk_lukisan]" class="form-control form-control-sm" value="{{ $lukisan->tajuk_lukisan }}"></td>
                                                <td><input type="text" name="lukisan[{{ $index }}][no_rujukan]" class="form-control form-control-sm" value="{{ $lukisan->no_rujukan }}"></td>
                                                <td><input type="text" name="lukisan[{{ $index }}][catatan]" class="form-control form-control-sm" value="{{ $lukisan->catatan }}"></td>
                                                <td class="text-center"><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td class="text-center">1</td>
                                                <td><input type="text" name="lukisan[0][bidang]" class="form-control form-control-sm"></td>
                                                <td><input type="text" name="lukisan[0][tajuk_lukisan]" class="form-control form-control-sm"></td>
                                                <td><input type="text" name="lukisan[0][no_rujukan]" class="form-control form-control-sm"></td>
                                                <td><input type="text" name="lukisan[0][catatan]" class="form-control form-control-sm"></td>
                                                <td class="text-center"><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <button type="button" class="btn btn-success btn-sm mt-2" onclick="addLukisanRow()">
                                    <i class="bi bi-plus-circle"></i> Tambah Baris
                                </button>
                            </div>
                        </div>
                        <div class="d-flex gap-2 justify-content-between mb-4">
                            <button type="button" class="btn btn-secondary" onclick="prevTab()">
                                <i class="bi bi-arrow-left"></i> Sebelumnya
                            </button>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Kemaskini Premis
                                </button>
                                <a href="{{ route('admin.premis.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Batal
                                </a>
                            </div>
                        </div>

                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let tanahCount = {{ $premis->tanah->count() ?: 1 }};
let lukisanCount = {{ $premis->lukisan->count() ?: 1 }};

function nextTab() {
    const tab = new bootstrap.Tab(document.getElementById('helaian2-tab'));
    tab.show();
}

function prevTab() {
    const tab = new bootstrap.Tab(document.getElementById('helaian1-tab'));
    tab.show();
}

function addTanahRow() {
    const tbody = document.getElementById('tanah-body');
    const row = `
        <tr>
            <td class="text-center">${tanahCount + 1}</td>
            <td><input type="text" name="tanah[${tanahCount}][no_lot]" class="form-control form-control-sm"></td>
            <td>
                <select name="tanah[${tanahCount}][status_hakmilik]" class="form-select form-select-sm status-hakmilik-select" onchange="toggleLainLain(this)">
                    <option value="">-- Pilih --</option>
                    <option>Hakmilik</option>
                    <option>Rizab</option>
                    <option>Strata</option>
                    <option>Lain-lain</option>
                </select>
                <input type="text" name="tanah[${tanahCount}][status_hakmilik_lain]" class="form-control form-control-sm mt-1 d-none" placeholder="Nyatakan...">
            </td>
            <td><input type="text" name="tanah[${tanahCount}][keluasan_tanah]" class="form-control form-control-sm"></td>
            <td><input type="text" name="tanah[${tanahCount}][no_hakmilik]" class="form-control form-control-sm"></td>
            <td>
                <select name="tanah[${tanahCount}][jenis_hakmilik]" class="form-select form-select-sm">
                    <option value="">-- Pilih --</option>
                    <option>Kekal</option>
                    <option>Pajak</option>
                </select>
            </td>
            <td><input type="text" name="tanah[${tanahCount}][kegunaan_tanah]" class="form-control form-control-sm"></td>
            <td><input type="number" name="tanah[${tanahCount}][harga_perolehan]" class="form-control form-control-sm" step="0.01"></td>
            <td><input type="number" name="tanah[${tanahCount}][harga_semasa]" class="form-control form-control-sm" step="0.01"></td>
            <td class="text-center"><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
        </tr>`;
    tbody.insertAdjacentHTML('beforeend', row);
    tanahCount++;
}

function toggleLainLain(select) {
    const input = select.nextElementSibling;
    if (select.value === 'Lain-lain') {
        input.classList.remove('d-none');
        input.required = true;
    } else {
        input.classList.add('d-none');
        input.required = false;
        input.value = '';
    }
}

function addLukisanRow() {
    const tbody = document.getElementById('lukisan-body');
    const row = `
        <tr>
            <td>${lukisanCount + 1}</td>
            <td><input type="text" name="lukisan[${lukisanCount}][bidang]" class="form-control form-control-sm"></td>
            <td><input type="text" name="lukisan[${lukisanCount}][tajuk_lukisan]" class="form-control form-control-sm"></td>
            <td><input type="text" name="lukisan[${lukisanCount}][no_rujukan]" class="form-control form-control-sm"></td>
            <td><input type="text" name="lukisan[${lukisanCount}][catatan]" class="form-control form-control-sm"></td>
            <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
        </tr>`;
    tbody.insertAdjacentHTML('beforeend', row);
    lukisanCount++;
}

function removeRow(btn) {
    btn.closest('tr').remove();
}

// Auto move DPA box
const dpaBoxes = document.querySelectorAll('.dpa-box');
dpaBoxes.forEach((box, index) => {
    box.addEventListener('input', function() {
        let dpaValue = '';
        dpaBoxes.forEach(b => dpaValue += b.value);
        document.getElementById('no_dpa').value = dpaValue.trim();

        if (this.value.length === 1 && index < dpaBoxes.length - 1) {
            dpaBoxes[index + 1].focus();
        }
    });
    box.addEventListener('keydown', function(e) {
        if (e.key === 'Backspace' && this.value === '' && index > 0) {
            dpaBoxes[index - 1].focus();
        }
    });
});

function padamGambar() {
    if (confirm('Padam gambar ini?')) {
        // Set hidden input value
        document.getElementById('padam_gambar').value = '1';
        // Sorok gambar dan button, tunjuk mesej
        const wrapper = document.querySelector('#previewGambar').closest('.position-relative');
        wrapper.innerHTML = '<p class="text-muted fst-italic mt-1"><i class="bi bi-image"></i> Gambar akan dipadam selepas simpan</p>';
    }
}
</script>
@endsection