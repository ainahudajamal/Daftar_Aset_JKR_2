@extends('layouts.app')

@section('title', 'Tambah Premis')

@section('styles')
<style>
    .tab-content > .tab-pane {
        display: none;
    }
    .tab-content > .active {
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

            <form action="#" method="POST" enctype="multipart/form-data">
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
                                <h5 class="mb-0"> KAD PENDAFTARAN ASET TAK ALIH (Premis Hak Milik)</h5>
                            </div>
                            <div class="card-body">

                                <div class="row g-3 mb-3">
                                    <!-- 1. Nama Premis -->
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Nama Premis <span class="text-danger">*</span></label>
                                        <input type="text" name="nama_premis" class="form-control" required placeholder="Contoh: PARLIMEN MALAYSIA">
                                    </div>

                                    <!-- 2. Alamat Premis -->
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Alamat Premis <span class="text-danger">*</span></label>
                                        <textarea name="alamat_premis" class="form-control" rows="3" required placeholder="Masukkan alamat penuh"></textarea>
                                    </div>

                                    <!-- 3. Poskod + GPS -->
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Poskod</label>
                                        <input type="text" name="poskod" class="form-control" placeholder="Contoh: 50480">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Koordinat GPS — X</label>
                                        <input type="text" name="koordinat_x" class="form-control" placeholder="Contoh: 3.147">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold">Koordinat GPS — Y</label>
                                        <input type="text" name="koordinat_y" class="form-control" placeholder="Contoh: 101.694">
                                    </div>
                                </div>

                                <hr>

                                <!-- 4-8. Agensi & Lokasi -->
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Kumpulan Agensi</label>
                                        <input type="text" name="kumpulan_agensi" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Daerah</label>
                                        <input type="text" name="daerah" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Kementerian</label>
                                        <input type="text" name="kementerian" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Mukim / Bandar</label>
                                        <input type="text" name="mukim_bandar" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Jabatan</label>
                                        <input type="text" name="jabatan" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Kategori Premis</label>
                                        <input type="text" name="kategori_premis" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Negara</label>
                                        <input type="text" name="negara" class="form-control" value="Malaysia">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Sub Kategori</label>
                                        <input type="text" name="sub_kategori" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Negeri</label>
                                        <select name="negeri" class="form-select">
                                            <option value="">-- Pilih Negeri --</option>
                                            @foreach(['Johor','Kedah','Kelantan','Melaka','Negeri Sembilan','Pahang','Perak','Perlis','Pulau Pinang','Sabah','Sarawak','Selangor','Terengganu','W.P. Kuala Lumpur','W.P. Labuan','W.P. Putrajaya'] as $negeri)
                                            <option value="{{ $negeri }}">{{ $negeri }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Jumlah Keluasan Premis</label>
                                        <input type="text" name="jumlah_keluasan" class="form-control" placeholder="Contoh: 5000 m²">
                                    </div>
                                </div>

                                <hr>

                                <!-- 9-15. Status, Kos, Tarikh -->
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Status Premis</label>
                                        <select name="status_premis" class="form-select">
                                            <option value="aktif">Aktif</option>
                                            <option value="tidak_aktif">Tidak Aktif</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Aset Warisan <small class="text-muted">(tandakan jika Ya)</small></label>
                                        <div class="form-check form-switch mt-2">
                                            <input class="form-check-input" type="checkbox" name="aset_warisan" id="aset_warisan">
                                            <label class="form-check-label" for="aset_warisan">Ya</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Kos Siap Bina Asal (RM)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">RM</span>
                                            <input type="number" name="kos_siap_bina" class="form-control" placeholder="0.00" step="0.01">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Sumber Pembiayaan</label>
                                        <input type="text" name="sumber_pembiayaan" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">*Kos Tambahan PPUN (RM)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">RM</span>
                                            <input type="number" name="kos_tambahan_ppun" class="form-control" placeholder="0.00" step="0.01">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Kod PTJ</label>
                                        <input type="text" name="kod_ptj" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Kos Keseluruhan Aset (RM)</label>
                                        <input type="number" name="kos_keseluruhan" class="form-control" placeholder="0.00" step="0.01">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nilai Semasa (RM)</label>
                                        <input type="number" name="nilai_semasa" class="form-control" placeholder="0.00" step="0.01">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Tarikh Siap Bina</label>
                                        <input type="date" name="tarikh_siap_bina" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Tarikh Penilaian</label>
                                        <input type="date" name="tarikh_penilaian" class="form-control">
                                    </div>
                                    <div class="col-md-6 d-flex align-items-center">
                                        <small class="text-muted fst-italic">* Pemulihan, Pemuliharaan, Ubahsuai & Naiktaraf</small>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <label class="form-label fw-semibold">Bil. Blok Bangunan</label>
                                                <input type="number" name="bil_blok_bangunan" class="form-control" min="0" value="0">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label fw-semibold">Bil. Binaan Luar</label>
                                                <input type="number" name="bil_binaan_luar" class="form-control" min="0" value="0">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 16. Catatan -->
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Catatan</label>
                                        <textarea name="catatan" class="form-control" rows="3"></textarea>
                                    </div>

                                    <!-- 17. Gambar Premis -->
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Gambar Premis</label>
                                        <div class="alert alert-info py-2">
                                            <i class="bi bi-info-circle"></i> Pastikan gambar premis diambil dan dimuat naik ke dalam sistem pengurusan aset tak alih
                                        </div>
                                        <input type="file" name="gambar_premis" class="form-control" accept="image/*">
                                        <small class="text-muted">Format: JPG, PNG. Maksimum 2MB</small>
                                    </div>

                                    <!-- 18. No DPA -->
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">**NO DPA</label>
                                        <div class="d-flex" style="border: 1px solid #dee2e6; width: fit-content;">
                                            @for($i = 0; $i < 20; $i++)
                                            <input type="text" maxlength="1" class="dpa-box"
                                                style="width: 36px; height: 38px; border: none; border-right: 1px solid #dee2e6; text-align: center; font-weight: bold; background: white; outline: none;">
                                            @endfor
                                        </div>
        
                                    </div>
                                </div>

                                <hr>

                                <!-- 19. Tandatangan -->
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="card border">
                                            <div class="card-header bg-light fw-semibold text-center">PENGUMPUL DATA</div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Tandatangan</label>
                                                    <div style="height: 80px; border: 1px solid #dee2e6; border-radius: 6px;"></div>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Nama</label>
                                                    <input type="text" name="pengumpul_nama" class="form-control">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Jawatan</label>
                                                    <input type="text" name="pengumpul_jawatan" class="form-control">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Tarikh</label>
                                                    <input type="date" name="pengumpul_tarikh" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card border">
                                            <div class="card-header bg-light fw-semibold text-center">PENGESAH DATA</div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Tandatangan</label>
                                                    <div style="height: 80px; border: 1px solid #dee2e6; border-radius: 6px;"></div>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Nama</label>
                                                    <input type="text" name="pengesah_nama" class="form-control">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Jawatan</label>
                                                    <input type="text" name="pengesah_jawatan" class="form-control">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Tarikh</label>
                                                    <input type="date" name="pengesah_tarikh" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Next Button -->
                                <div class="d-flex justify-content-end mt-4">
                                    <button type="button" class="btn btn-primary" onclick="nextTab()">
                                        Seterusnya <i class="bi bi-arrow-right"></i>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- ==================== AKHIR HELAIAN 1 ==================== -->

                    <!-- ==================== HELAIAN 2 ==================== -->
                    <div class="tab-pane fade" id="helaian2">

                        <!-- Maklumat Tanah -->
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
                                                <td><input type="text" name="tanah[0][no_lot]" class="form-control form-control-sm"></td>
                                                <td>
                                                    <select name="tanah[0][status_hak_milik]" class="form-select form-select-sm">
                                                        <option value="">-- Pilih --</option>
                                                        <option>Hakmilik</option>
                                                        <option>Rizab</option>
                                                        <option>Strata</option>
                                                        <option>Lain-lain</option>
                                                    </select>
                                                </td>
                                                <td><input type="text" name="tanah[0][keluasan]" class="form-control form-control-sm"></td>
                                                <td><input type="text" name="tanah[0][no_hakmilik]" class="form-control form-control-sm"></td>
                                                <td>
                                                    <select name="tanah[0][jenis_hakmilik]" class="form-select form-select-sm">
                                                        <option value="">-- Pilih --</option>
                                                        <option>Kekal</option>
                                                        <option>Pajak</option>
                                                    </select>
                                                </td>
                                                <td><input type="text" name="tanah[0][kegunaan]" class="form-control form-control-sm"></td>
                                                <td><input type="number" name="tanah[0][harga_perolehan]" class="form-control form-control-sm" step="0.01"></td>
                                                <td><input type="number" name="tanah[0][harga_semasa]" class="form-control form-control-sm" step="0.01"></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">
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

                        <!-- Senarai Lukisan -->
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
                                                <td><input type="text" name="lukisan[0][bidang]" class="form-control form-control-sm"></td>
                                                <td><input type="text" name="lukisan[0][tajuk]" class="form-control form-control-sm"></td>
                                                <td><input type="text" name="lukisan[0][no_rujukan]" class="form-control form-control-sm"></td>
                                                <td><input type="text" name="lukisan[0][catatan]" class="form-control form-control-sm"></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">
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

                        <!-- Buttons -->
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
                    <!-- ==================== AKHIR HELAIAN 2 ==================== -->

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
                <select name="tanah[${tanahCount}][status_hak_milik]" class="form-select form-select-sm">
                    <option value="">-- Pilih --</option>
                    <option>Hakmilik</option>
                    <option>Rizab</option>
                    <option>Strata</option>
                    <option>Lain-lain</option>
                </select>
            </td>
            <td><input type="text" name="tanah[${tanahCount}][keluasan]" class="form-control form-control-sm"></td>
            <td><input type="text" name="tanah[${tanahCount}][no_hakmilik]" class="form-control form-control-sm"></td>
            <td>
                <select name="tanah[${tanahCount}][jenis_hakmilik]" class="form-select form-select-sm">
                    <option value="">-- Pilih --</option>
                    <option>Kekal</option>
                    <option>Pajak</option>
                </select>
            </td>
            <td><input type="text" name="tanah[${tanahCount}][kegunaan]" class="form-control form-control-sm"></td>
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
            <td><input type="text" name="lukisan[${lukisanCount}][tajuk]" class="form-control form-control-sm"></td>
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

// Auto move to next DPA box
const dpaBoxes = document.querySelectorAll('.dpa-box');
dpaBoxes.forEach((box, index) => {
    box.addEventListener('input', function() {
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