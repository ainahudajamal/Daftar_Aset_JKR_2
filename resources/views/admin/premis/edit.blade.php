@extends('layouts.app')

@section('title', 'Edit Premis')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Header -->
            <div class="mb-4">
                <h2 class="mb-1"><i class="bi bi-pencil"></i> Edit Premis</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">Premis</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>

            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Helaian 1 -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">D.A.3 — KAD PENDAFTARAN ASET TAK ALIH (Premis Hak Milik)</h5>
                        <small>Helaian 1</small>
                    </div>
                    <div class="card-body">

                        <!-- Nama & Alamat -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Premis <span class="text-danger">*</span></label>
                                <input type="text" name="nama_premis" class="form-control" required value="{{ old('nama_premis', $premis->nama_premis ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">No. DPA</label>
                                <input type="text" name="no_dpa" class="form-control" value="{{ $premis->no_dpa ?? '' }}" readonly>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Alamat Premis <span class="text-danger">*</span></label>
                                <textarea name="alamat_premis" class="form-control" rows="3" required>{{ old('alamat_premis', $premis->alamat_premis ?? '') }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Poskod</label>
                                <input type="text" name="poskod" class="form-control" value="{{ old('poskod', $premis->poskod ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Koordinat GPS — X</label>
                                <input type="text" name="koordinat_x" class="form-control" value="{{ old('koordinat_x', $premis->koordinat_x ?? '') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Koordinat GPS — Y</label>
                                <input type="text" name="koordinat_y" class="form-control" value="{{ old('koordinat_y', $premis->koordinat_y ?? '') }}">
                            </div>
                        </div>

                        <hr>

                        <!-- Agensi & Lokasi -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Kumpulan Agensi</label>
                                <input type="text" name="kumpulan_agensi" class="form-control" value="{{ old('kumpulan_agensi', $premis->kumpulan_agensi ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Daerah</label>
                                <input type="text" name="daerah" class="form-control" value="{{ old('daerah', $premis->daerah ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Kementerian</label>
                                <input type="text" name="kementerian" class="form-control" value="{{ old('kementerian', $premis->kementerian ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Mukim / Bandar</label>
                                <input type="text" name="mukim_bandar" class="form-control" value="{{ old('mukim_bandar', $premis->mukim_bandar ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jabatan</label>
                                <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $premis->jabatan ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Kategori Premis</label>
                                <input type="text" name="kategori_premis" class="form-control" value="{{ old('kategori_premis', $premis->kategori_premis ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Negara</label>
                                <input type="text" name="negara" class="form-control" value="{{ old('negara', $premis->negara ?? 'Malaysia') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Sub Kategori</label>
                                <input type="text" name="sub_kategori" class="form-control" value="{{ old('sub_kategori', $premis->sub_kategori ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Negeri</label>
                                <select name="negeri" class="form-select">
                                    <option value="">-- Pilih Negeri --</option>
                                    @foreach(['Johor','Kedah','Kelantan','Melaka','Negeri Sembilan','Pahang','Perak','Perlis','Pulau Pinang','Sabah','Sarawak','Selangor','Terengganu','W.P. Kuala Lumpur','W.P. Labuan','W.P. Putrajaya'] as $negeri)
                                    <option value="{{ $negeri }}" {{ old('negeri', $premis->negeri ?? '') == $negeri ? 'selected' : '' }}>
                                        {{ $negeri }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jumlah Keluasan Premis</label>
                                <input type="text" name="jumlah_keluasan" class="form-control" value="{{ old('jumlah_keluasan', $premis->jumlah_keluasan ?? '') }}">
                            </div>
                        </div>

                        <hr>

                        <!-- Status & Kos -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Status Premis</label>
                                <select name="status_premis" class="form-select">
                                    <option value="aktif" {{ old('status_premis', $premis->status_premis ?? '') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="tidak_aktif" {{ old('status_premis', $premis->status_premis ?? '') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Aset Warisan</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="aset_warisan" id="aset_warisan" {{ old('aset_warisan', $premis->aset_warisan ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="aset_warisan">Ya</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Kos Siap Bina Asal (RM)</label>
                                <input type="number" name="kos_siap_bina" class="form-control" step="0.01" value="{{ old('kos_siap_bina', $premis->kos_siap_bina ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Sumber Pembiayaan</label>
                                <input type="text" name="sumber_pembiayaan" class="form-control" value="{{ old('sumber_pembiayaan', $premis->sumber_pembiayaan ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Kos Tambahan PPUN (RM)</label>
                                <input type="number" name="kos_tambahan_ppun" class="form-control" step="0.01" value="{{ old('kos_tambahan_ppun', $premis->kos_tambahan_ppun ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Kod PTJ</label>
                                <input type="text" name="kod_ptj" class="form-control" value="{{ old('kod_ptj', $premis->kod_ptj ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Kos Keseluruhan Aset (RM)</label>
                                <input type="number" name="kos_keseluruhan" class="form-control" step="0.01" value="{{ old('kos_keseluruhan', $premis->kos_keseluruhan ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nilai Semasa (RM)</label>
                                <input type="number" name="nilai_semasa" class="form-control" step="0.01" value="{{ old('nilai_semasa', $premis->nilai_semasa ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tarikh Siap Bina</label>
                                <input type="date" name="tarikh_siap_bina" class="form-control" value="{{ old('tarikh_siap_bina', $premis->tarikh_siap_bina ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tarikh Penilaian</label>
                                <input type="date" name="tarikh_penilaian" class="form-control" value="{{ old('tarikh_penilaian', $premis->tarikh_penilaian ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Pemulihan / Pemuliharaan / Ubahsuai & Naiktaraf</label>
                                <input type="text" name="pemulihan" class="form-control" value="{{ old('pemulihan', $premis->pemulihan ?? '') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Bil. Blok Bangunan</label>
                                <input type="number" name="bil_blok_bangunan" class="form-control" min="0" value="{{ old('bil_blok_bangunan', $premis->bil_blok_bangunan ?? 0) }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Bil. Binaan Luar</label>
                                <input type="number" name="bil_binaan_luar" class="form-control" min="0" value="{{ old('bil_binaan_luar', $premis->bil_binaan_luar ?? 0) }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Catatan</label>
                                <textarea name="catatan" class="form-control" rows="3">{{ old('catatan', $premis->catatan ?? '') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Gambar Premis</label>
                                <input type="file" name="gambar_premis" class="form-control" accept="image/*">
                                <small class="text-muted">Kosongkan jika tidak mahu tukar gambar</small>
                            </div>
                        </div>

                        <hr>

                        <!-- Tandatangan -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card border">
                                    <div class="card-header bg-light fw-semibold">Pengumpul Data</div>
                                    <div class="card-body">
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <label class="form-label">Nama</label>
                                                <input type="text" name="pengumpul_nama" class="form-control" value="{{ old('pengumpul_nama', $premis->pengumpul_nama ?? '') }}">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Jawatan</label>
                                                <input type="text" name="pengumpul_jawatan" class="form-control" value="{{ old('pengumpul_jawatan', $premis->pengumpul_jawatan ?? '') }}">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Tarikh</label>
                                                <input type="date" name="pengumpul_tarikh" class="form-control" value="{{ old('pengumpul_tarikh', $premis->pengumpul_tarikh ?? '') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border">
                                    <div class="card-header bg-light fw-semibold">Pengesah Data</div>
                                    <div class="card-body">
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <label class="form-label">Nama</label>
                                                <input type="text" name="pengesah_nama" class="form-control" value="{{ old('pengesah_nama', $premis->pengesah_nama ?? '') }}">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Jawatan</label>
                                                <input type="text" name="pengesah_jawatan" class="form-control" value="{{ old('pengesah_jawatan', $premis->pengesah_jawatan ?? '') }}">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Tarikh</label>
                                                <input type="date" name="pengesah_tarikh" class="form-control" value="{{ old('pengesah_tarikh', $premis->pengesah_tarikh ?? '') }}">
                                            </div>
                                        </div>
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
                        <button type="button" class="btn btn-sm btn-success" onclick="addTanahRow()">
                            <i class="bi bi-plus-circle"></i> Tambah Baris
                        </button>
                    </div>
                </div>

                <!-- Helaian 2 - Senarai Lukisan -->
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
                        <button type="button" class="btn btn-sm btn-success" onclick="addLukisanRow()">
                            <i class="bi bi-plus-circle"></i> Tambah Baris
                        </button>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2 mb-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Kemaskini Premis
                    </button>
                    <a href="#" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
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
</script>
@endsection