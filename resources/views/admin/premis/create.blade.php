@extends('layouts.app')

@section('title', 'Tambah Premis')

@section('styles')
    <style>
        .tab-content>.tab-pane {
            display: none;
        }

        .tab-content>.active {
            display: block;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <!-- Header -->
                <div class="mb-4">
                    <h2 class="mb-1"><i class="bi bi-plus-circle"></i> Tambah Premis Baru</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.premis.index') }}">Premis</a></li>
                            <li class="breadcrumb-item active">Tambah</li>
                        </ol>
                    </nav>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.premis.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

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
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">KAD PENDAFTARAN ASET TAK ALIH (Premis Hak Milik)</h5>
                                </div>
                                <div class="card-body">

                                    <div class="row g-3 mb-3">
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Nama Premis <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="nama_premis" class="form-control" required
                                                placeholder="Contoh: PARLIMEN MALAYSIA" value="{{ old('nama_premis') }}">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Alamat Premis</label>
                                            <textarea name="alamat_premis" class="form-control" rows="3" placeholder="Masukkan alamat penuh">{{ old('alamat_premis') }}</textarea>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Poskod</label>
                                            <input type="text" name="poskod" class="form-control"
                                                placeholder="Contoh: 50480" value="{{ old('poskod') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Koordinat GPS — X</label>
                                            <input type="text" name="koordinat_x" class="form-control"
                                                placeholder="Contoh: 3.147" value="{{ old('koordinat_x') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Koordinat GPS — Y</label>
                                            <input type="text" name="koordinat_y" class="form-control"
                                                placeholder="Contoh: 101.694" value="{{ old('koordinat_y') }}">
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Kumpulan Agensi</label>
                                            <input type="text" name="kumpulan_agensi" class="form-control"
                                                value="{{ old('kumpulan_agensi') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Daerah</label>
                                            <input type="text" name="daerah" class="form-control"
                                                value="{{ old('daerah') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Kementerian</label>
                                            <input type="text" name="kementerian" class="form-control"
                                                value="{{ old('kementerian') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Mukim / Bandar</label>
                                            <input type="text" name="mukim_bandar" class="form-control"
                                                value="{{ old('mukim_bandar') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Jabatan</label>
                                            <input type="text" name="jabatan" class="form-control"
                                                value="{{ old('jabatan') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Kategori Premis</label>
                                            <input type="text" name="kategori_premis" class="form-control"
                                                value="{{ old('kategori_premis') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Negara</label>
                                            <input type="text" name="negara" class="form-control"
                                                value="{{ old('negara', 'Malaysia') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Sub Kategori</label>
                                            <input type="text" name="sub_kategori" class="form-control"
                                                value="{{ old('sub_kategori') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Negeri</label>
                                            <select name="negeri" class="form-select">
                                                <option value="">-- Pilih Negeri --</option>
                                                @foreach (['Johor', 'Kedah', 'Kelantan', 'Melaka', 'Negeri Sembilan', 'Pahang', 'Perak', 'Perlis', 'Pulau Pinang', 'Sabah', 'Sarawak', 'Selangor', 'Terengganu', 'W.P. Kuala Lumpur', 'W.P. Labuan', 'W.P. Putrajaya'] as $negeri)
                                                    <option value="{{ $negeri }}"
                                                        {{ old('negeri') == $negeri ? 'selected' : '' }}>
                                                        {{ $negeri }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Jumlah Keluasan Premis</label>
                                            <input type="text" name="jumlah_keluasan" class="form-control"
                                                placeholder="Contoh: 5000" value="{{ old('jumlah_keluasan') }}">
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Status Premis</label>
                                            <select name="status_premis" class="form-select">
                                                <option value="Aktif"
                                                    {{ old('status_premis') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="Tidak Aktif"
                                                    {{ old('status_premis') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak
                                                    Aktif</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Aset Warisan</label>
                                            <div class="form-check form-switch mt-2">
                                                <input class="form-check-input" type="checkbox" name="aset_warisan"
                                                    id="aset_warisan" value="1"
                                                    {{ old('aset_warisan') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="aset_warisan">Ya</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Kos Siap Bina Asal (RM)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">RM</span>
                                                <input type="number" name="kos_siap_bina_asal" class="form-control"
                                                    placeholder="0.00" step="0.01"
                                                    value="{{ old('kos_siap_bina_asal') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Sumber Pembiayaan</label>
                                            <input type="text" name="sumber_pembiayaan" class="form-control"
                                                value="{{ old('sumber_pembiayaan') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">*Kos Tambahan PPUN (RM)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">RM</span>
                                                <input type="number" name="kos_tambahan_ppun" class="form-control"
                                                    placeholder="0.00" step="0.01"
                                                    value="{{ old('kos_tambahan_ppun') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Kod PTJ</label>
                                            <input type="text" name="kod_ptj" class="form-control"
                                                value="{{ old('kod_ptj') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Kos Keseluruhan Aset (RM)</label>
                                            <input type="number" name="kos_keseluruhan" class="form-control"
                                                placeholder="0.00" step="0.01" value="{{ old('kos_keseluruhan') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Nilai Semasa (RM)</label>
                                            <input type="number" name="nilai_semasa" class="form-control"
                                                placeholder="0.00" step="0.01" value="{{ old('nilai_semasa') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Tarikh Siap Bina</label>
                                            <input type="date" name="tarikh_siap_bina" class="form-control"
                                                value="{{ old('tarikh_siap_bina') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Tarikh Penilaian</label>
                                            <input type="date" name="tarikh_penilaian" class="form-control"
                                                value="{{ old('tarikh_penilaian') }}">
                                        </div>
                                        <div class="col-md-6 d-flex align-items-center">
                                            <small class="text-muted fst-italic">* Pemulihan, Pemuliharaan, Ubahsuai &
                                                Naiktaraf</small>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row g-2">
                                                <div class="col-6">
                                                    <label class="form-label fw-semibold">Bil. Blok Bangunan</label>
                                                    <input type="number" name="bil_blok_bangunan" class="form-control"
                                                        min="0" value="{{ old('bil_blok_bangunan', 0) }}">
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label fw-semibold">Bil. Binaan Luar</label>
                                                    <input type="text" name="bil_binaan_luar" class="form-control"
                                                        value="{{ old('bil_binaan_luar') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Catatan</label>
                                            <textarea name="catatan" class="form-control" rows="3">{{ old('catatan') }}</textarea>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">Gambar Premis</label>
                                            <div class="alert alert-info py-2">
                                                <i class="bi bi-info-circle"></i> Pastikan gambar premis diambil dan dimuat
                                                naik ke dalam sistem pengurusan aset tak alih
                                            </div>
                                            <input type="file" name="gambar_premis" class="form-control"
                                                accept="image/*">
                                            <small class="text-muted">Format: JPG, PNG. Maksimum 2MB</small>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-semibold">**NO DPA</label>
                                            <div class="d-flex" style="border: 1px solid #dee2e6; width: fit-content;">
                                                @for ($i = 0; $i < 24; $i++)
                                                    <input type="text" maxlength="1" class="dpa-box"
                                                        style="width: 30px; height: 38px; border: none; border-right: 1px solid #dee2e6; text-align: center; font-weight: bold; background: white; outline: none;">
                                                @endfor
                                            </div>
                                            <input type="hidden" name="no_dpa" id="no_dpa">
                                            <small class="text-muted">** Nombor Daftar Premis Aset</small>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="card border">
                                                <div class="card-header bg-light fw-semibold text-center">PENGUMPUL DATA
                                                </div>
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Tandatangan</label>
                                                        <div
                                                            style="height: 80px; border: 1px solid #dee2e6; border-radius: 6px;">
                                                        </div>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label">Nama</label>
                                                        <input type="text" name="pengumpul_nama" class="form-control"
                                                            value="{{ old('pengumpul_nama') }}">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label">Jawatan</label>
                                                        <input type="text" name="pengumpul_jawatan"
                                                            class="form-control" value="{{ old('pengumpul_jawatan') }}">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label">Tarikh</label>
                                                        <input type="date" name="pengumpul_tarikh"
                                                            class="form-control" value="{{ old('pengumpul_tarikh') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card border">
                                                <div class="card-header bg-light fw-semibold text-center">PENGESAH DATA
                                                </div>
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Tandatangan</label>
                                                        <div
                                                            style="height: 80px; border: 1px solid #dee2e6; border-radius: 6px;">
                                                        </div>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label">Nama</label>
                                                        <input type="text" name="pengesah_nama" class="form-control"
                                                            value="{{ old('pengesah_nama') }}">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label">Jawatan</label>
                                                        <input type="text" name="pengesah_jawatan"
                                                            class="form-control" value="{{ old('pengesah_jawatan') }}">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label">Tarikh</label>
                                                        <input type="date" name="pengesah_tarikh" class="form-control"
                                                            value="{{ old('pengesah_tarikh') }}">
                                                    </div>
                                                </div>
                                            </div>
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
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="mb-0">Maklumat Tanah (jika ada)</h5>
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
                                                    <th>Tindakan</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tanah-body">
                                                <tr>
                                                    <td>1</td>
                                                    <td><input type="text" name="tanah[0][no_lot]"
                                                            class="form-control form-control-sm"></td>
                                                    <td>
                                                        <select name="tanah[0][status_hakmilik]"
                                                            class="form-select form-select-sm">
                                                            <option value="">-- Pilih --</option>
                                                            <option>Hakmilik</option>
                                                            <option>Rizab</option>
                                                            <option>Strata</option>
                                                            <option>Lain-lain</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="tanah[0][keluasan_tanah]"
                                                            class="form-control form-control-sm"></td>
                                                    <td><input type="text" name="tanah[0][no_hakmilik]"
                                                            class="form-control form-control-sm"></td>
                                                    <td>
                                                        <select name="tanah[0][jenis_hakmilik]"
                                                            class="form-select form-select-sm">
                                                            <option value="">-- Pilih --</option>
                                                            <option>Kekal</option>
                                                            <option>Pajak</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" name="tanah[0][kegunaan_tanah]"
                                                            class="form-control form-control-sm"></td>
                                                    <td><input type="number" name="tanah[0][harga_perolehan]"
                                                            class="form-control form-control-sm" step="0.01"></td>
                                                    <td><input type="number" name="tanah[0][harga_semasa]"
                                                            class="form-control form-control-sm" step="0.01"></td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            onclick="removeRow(this)">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-success mt-2" onclick="addTanahRow()">
                                        <i class="bi bi-plus-circle"></i> Tambah Baris
                                    </button>
                                </div>
                            </div>

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
                                                    <th>Tindakan</th>
                                                </tr>
                                            </thead>
                                            <tbody id="lukisan-body">
                                                <tr>
                                                    <td>1</td>
                                                    <td><input type="text" name="lukisan[0][bidang]"
                                                            class="form-control form-control-sm"></td>
                                                    <td><input type="text" name="lukisan[0][tajuk_lukisan]"
                                                            class="form-control form-control-sm"></td>
                                                    <td><input type="text" name="lukisan[0][no_rujukan]"
                                                            class="form-control form-control-sm"></td>
                                                    <td><input type="text" name="lukisan[0][catatan]"
                                                            class="form-control form-control-sm"></td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            onclick="removeRow(this)">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-success mt-2" onclick="addLukisanRow()">
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
                                        <i class="bi bi-check-circle"></i> Simpan Premis
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
        let tanahCount = 1;
        let lukisanCount = 1;

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
            <td>${tanahCount + 1}</td>
            <td><input type="text" name="tanah[${tanahCount}][no_lot]" class="form-control form-control-sm"></td>
            <td>
                <select name="tanah[${tanahCount}][status_hakmilik]" class="form-select form-select-sm">
                    <option value="">-- Pilih --</option>
                    <option>Hakmilik</option>
                    <option>Rizab</option>
                    <option>Strata</option>
                    <option>Lain-lain</option>
                </select>
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
            <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)"><i class="bi bi-trash"></i></button></td>
        </tr>`;
            tbody.insertAdjacentHTML('beforeend', row);
            tanahCount++;
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
                // Gabungkan semua nilai ke hidden input
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
    </script>
@endsection
