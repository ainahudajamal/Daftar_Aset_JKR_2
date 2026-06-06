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
                        <li class="breadcrumb-item"><a href="#">Premis</a></li>
                        <li class="breadcrumb-item active">Butiran</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2">
                <a href="#" class="btn btn-danger">
                    <i class="bi bi-file-pdf"></i> PDF
                </a>
                <a href="#" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="#" class="btn btn-secondary">
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
                        <td>-</td>
                        <td width="25%" class="fw-semibold bg-light">No. DPA</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold bg-light">Alamat Premis</td>
                        <td colspan="3">-</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold bg-light">Poskod</td>
                        <td>-</td>
                        <td class="fw-semibold bg-light">Koordinat GPS</td>
                        <td>X: - ; Y: -</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold bg-light">Kumpulan Agensi</td>
                        <td>-</td>
                        <td class="fw-semibold bg-light">Daerah</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold bg-light">Kementerian</td>
                        <td>-</td>
                        <td class="fw-semibold bg-light">Mukim / Bandar</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold bg-light">Jabatan</td>
                        <td>-</td>
                        <td class="fw-semibold bg-light">Kategori Premis</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold bg-light">Negara</td>
                        <td>-</td>
                        <td class="fw-semibold bg-light">Sub Kategori</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold bg-light">Negeri</td>
                        <td>-</td>
                        <td class="fw-semibold bg-light">Jumlah Keluasan Premis</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold bg-light">Status Premis</td>
                        <td>-</td>
                        <td class="fw-semibold bg-light">Aset Warisan</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold bg-light">Kos Siap Bina Asal</td>
                        <td>-</td>
                        <td class="fw-semibold bg-light">Sumber Pembiayaan</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold bg-light">Kos Tambahan (PPUN)</td>
                        <td>-</td>
                        <td class="fw-semibold bg-light">Kod PTJ</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold bg-light">Kos Keseluruhan Aset</td>
                        <td>-</td>
                        <td class="fw-semibold bg-light">Nilai Semasa</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold bg-light">Tarikh Siap Bina</td>
                        <td>-</td>
                        <td class="fw-semibold bg-light">Tarikh Penilaian</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold bg-light">Pemulihan / Pemuliharaan / Ubahsuai & Naiktaraf</td>
                        <td>-</td>
                        <td class="fw-semibold bg-light">Bil. Blok Bangunan</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold bg-light">Catatan</td>
                        <td colspan="3">-</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold bg-light">Bil. Binaan Luar</td>
                        <td colspan="3">-</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold bg-light">Gambar Premis</td>
                        <td colspan="3">-</td>
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
                                        <td width="40%">Tandatangan</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Nama</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Jawatan</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Tarikh</td>
                                        <td>-</td>
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
                                        <td width="40%">Tandatangan</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Nama</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Jawatan</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Tarikh</td>
                                        <td>-</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Helaian 2 -->
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
                            <tr>
                                <td colspan="9" class="text-center">Tiada maklumat tanah</td>
                            </tr>
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
                            <tr>
                                <td colspan="5" class="text-center">Tiada lukisan siap bina</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="d-flex gap-2 mb-4">
            <a href="#" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
@endsection
