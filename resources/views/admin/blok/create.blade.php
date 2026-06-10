@extends('layouts.app')

@section('title', 'Tambah Blok / Binaan Luar')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="mb-4">
                <h2 class="mb-1"><i class="bi bi-plus-circle"></i> Tambah Blok / Binaan Luar</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.blok.index') }}">Konfigurasi Blok</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </nav>
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

            <form action="{{ route('admin.blok.store') }}" method="POST" id="mainForm">
                @csrf

                <!-- Maklumat Premis -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header text-white py-2" style="background-color:#4a5568;">
                        <h6 class="mb-0"><i class="bi bi-geo-alt-fill me-2"></i>Maklumat Premis</h6>
                    </div>
                    <div class="card-body pt-3">
                        <div class="row g-3">
                            <div class="col-md-7">
                                <label class="form-label fw-semibold">Nama Premis <span class="text-danger">*</span></label>
                                <select name="premis_id" id="selectPremis"
                                    class="form-select @error('premis_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Premis --</option>
                                    @foreach($premis as $p)
                                    <option value="{{ $p->id }}"
                                        data-dpa="{{ $p->no_dpa }}"
                                        {{ old('premis_id') == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama_premis }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('premis_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-5">
                                <label class="form-label fw-semibold">Nombor DPA</label>
                                <input type="text" id="inputNoDpa" class="form-control bg-light"
                                    placeholder="Auto-isi selepas pilih premis" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bahagian A — Blok -->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header py-2" style="background-color:#0d6efd;">
                        <div class="form-check d-flex align-items-center gap-2 mb-0">
                            <input class="form-check-input mt-0 flex-shrink-0" type="checkbox"
                                name="ada_blok" id="chkBlok" value="1"
                                {{ old('ada_blok', true) ? 'checked' : '' }}
                                style="width:1.2rem;height:1.2rem;">
                            <label class="form-check-label fw-semibold mb-0 text-white d-flex align-items-center gap-2"
                                for="chkBlok" style="cursor:pointer;">
                                <i class="bi bi-building"></i> Blok
                            </label>
                        </div>
                    </div>
                    <div id="seksyenBlok" class="{{ old('ada_blok', true) ? '' : 'd-none' }}">
                        <div class="card-body">
                            <button type="button" class="btn btn-success btn-sm mb-3" id="btnTambahBlok">
                                <i class="bi bi-plus-lg"></i> Tambah Blok
                            </button>
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-2" id="tableBlok">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width:50px;">Bil</th>
                                            <th>Nama Blok <span class="text-danger">*</span></th>
                                            <th>Fungsi Binaan</th>
                                            <th style="width:160px;">Luas Tapak (m²)</th>
                                            <th>Kod Blok mySPATA</th>
                                            <th>Catatan</th>
                                            <th style="width:50px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="bodyBlok">
                                        <tr>
                                            <td class="text-center fw-semibold bil-blok">1</td>
                                            <td><input type="text" name="blok[0][nama_blok]" class="form-control form-control-sm"></td>
                                            <td><input type="text" name="blok[0][fungsi_binaan]" class="form-control form-control-sm"></td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <input type="number" name="blok[0][luas_tapak]" class="form-control form-control-sm" step="0.01" min="0">
                                                    <span class="input-group-text">m²</span>
                                                </div>
                                            </td>
                                            <td><input type="text" name="blok[0][kod_blok_myspata]" class="form-control form-control-sm"></td>
                                            <td><input type="text" name="blok[0][catatan]" class="form-control form-control-sm"></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger btn-sm btn-padam-blok">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bahagian B — Binaan Luar -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header py-2" style="background-color:#198754;">
                        <div class="form-check d-flex align-items-center gap-2 mb-0">
                            <input class="form-check-input mt-0 flex-shrink-0" type="checkbox"
                                name="ada_binaan_luar" id="chkBinaan" value="1"
                                {{ old('ada_binaan_luar') ? 'checked' : '' }}
                                style="width:1.2rem;height:1.2rem;">
                            <label class="form-check-label fw-semibold mb-0 text-white d-flex align-items-center gap-2"
                                for="chkBinaan" style="cursor:pointer;">
                                <i class="bi bi-sign-intersection"></i> Binaan Luar
                            </label>
                        </div>
                    </div>
                    <div id="seksyenBinaan" class="{{ old('ada_binaan_luar') ? '' : 'd-none' }}">
                        <div class="card-body">
                            <button type="button" class="btn btn-success btn-sm mb-3" id="btnTambahBinaan">
                                <i class="bi bi-plus-lg"></i> Tambah Binaan Luar
                            </button>
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-2" id="tableBinaan">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width:50px;">Bil</th>
                                            <th>Nama Binaan Luar <span class="text-danger">*</span></th>
                                            <th>Jenis Binaan Luar</th>
                                            <th style="width:160px;">Luas Tapak (m²)</th>
                                            <th>Kod Binaan Luar mySPATA</th>
                                            <th>Catatan</th>
                                            <th style="width:50px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="bodyBinaan">
                                        <tr>
                                            <td class="text-center fw-semibold bil-binaan">1</td>
                                            <td><input type="text" name="binaan_luar[0][nama_binaan_luar]" class="form-control form-control-sm"></td>
                                            <td><input type="text" name="binaan_luar[0][jenis_binaan_luar]" class="form-control form-control-sm"></td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <input type="number" name="binaan_luar[0][luas_tapak]" class="form-control form-control-sm" step="0.01" min="0">
                                                    <span class="input-group-text">m²</span>
                                                </div>
                                            </td>
                                            <td><input type="text" name="binaan_luar[0][kod_binaan_luar_myspata]" class="form-control form-control-sm"></td>
                                            <td><input type="text" name="binaan_luar[0][catatan]" class="form-control form-control-sm"></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger btn-sm btn-padam-binaan">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 mb-5">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-floppy"></i> Simpan
                    </button>
                    <a href="{{ route('admin.blok.index') }}" class="btn btn-secondary px-4">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Auto-fill No. DPA
    document.getElementById('selectPremis').addEventListener('change', function () {
        const dpa = this.options[this.selectedIndex].getAttribute('data-dpa') || '';
        document.getElementById('inputNoDpa').value = dpa;
    });

    // Toggle checkbox
    function bindToggle(checkboxId, seksyenId) {
        const chk = document.getElementById(checkboxId);
        const seksyen = document.getElementById(seksyenId);
        chk.addEventListener('change', function () {
            seksyen.classList.toggle('d-none', !this.checked);
        });
    }
    bindToggle('chkBlok', 'seksyenBlok');
    bindToggle('chkBinaan', 'seksyenBinaan');

    // Renumber bil
    function renumberBil(tbody, bilClass) {
        tbody.querySelectorAll('.' + bilClass).forEach(function (td, i) {
            td.textContent = i + 1;
        });
    }

    function renameIndexes(tbody) {
        tbody.querySelectorAll('tr').forEach(function (tr, i) {
            tr.querySelectorAll('input, textarea, select').forEach(function (el) {
                el.name = el.name.replace(/\[\d+\]/, '[' + i + ']');
            });
        });
    }

    // Blok: Tambah row
    document.getElementById('btnTambahBlok').addEventListener('click', function () {
        const tbody = document.getElementById('bodyBlok');
        const idx = tbody.querySelectorAll('tr').length;
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="text-center fw-semibold bil-blok">${idx + 1}</td>
            <td><input type="text" name="blok[${idx}][nama_blok]" class="form-control form-control-sm"></td>
            <td><input type="text" name="blok[${idx}][fungsi_binaan]" class="form-control form-control-sm"></td>
            <td>
                <div class="input-group input-group-sm">
                    <input type="number" name="blok[${idx}][luas_tapak]" class="form-control form-control-sm" step="0.01" min="0">
                    <span class="input-group-text">m²</span>
                </div>
            </td>
            <td><input type="text" name="blok[${idx}][kod_blok_myspata]" class="form-control form-control-sm"></td>
            <td><input type="text" name="blok[${idx}][catatan]" class="form-control form-control-sm"></td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm btn-padam-blok">
                    <i class="bi bi-x-lg"></i>
                </button>
            </td>`;
        tbody.appendChild(tr);
        bindPadamBlok(tr.querySelector('.btn-padam-blok'));
    });

    function bindPadamBlok(btn) {
        btn.addEventListener('click', function () {
            const tbody = document.getElementById('bodyBlok');
            if (tbody.querySelectorAll('tr').length <= 1) {
                alert('Sekurang-kurangnya satu baris blok diperlukan.');
                return;
            }
            this.closest('tr').remove();
            renumberBil(tbody, 'bil-blok');
            renameIndexes(tbody);
        });
    }
    document.querySelectorAll('#bodyBlok .btn-padam-blok').forEach(bindPadamBlok);

    // Binaan Luar: Tambah row
    document.getElementById('btnTambahBinaan').addEventListener('click', function () {
        const tbody = document.getElementById('bodyBinaan');
        const idx = tbody.querySelectorAll('tr').length;
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="text-center fw-semibold bil-binaan">${idx + 1}</td>
            <td><input type="text" name="binaan_luar[${idx}][nama_binaan_luar]" class="form-control form-control-sm"></td>
            <td><input type="text" name="binaan_luar[${idx}][jenis_binaan_luar]" class="form-control form-control-sm"></td>
            <td>
                <div class="input-group input-group-sm">
                    <input type="number" name="binaan_luar[${idx}][luas_tapak]" class="form-control form-control-sm" step="0.01" min="0">
                    <span class="input-group-text">m²</span>
                </div>
            </td>
            <td><input type="text" name="binaan_luar[${idx}][kod_binaan_luar_myspata]" class="form-control form-control-sm"></td>
            <td><input type="text" name="binaan_luar[${idx}][catatan]" class="form-control form-control-sm"></td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm btn-padam-binaan">
                    <i class="bi bi-x-lg"></i>
                </button>
            </td>`;
        tbody.appendChild(tr);
        bindPadamBinaan(tr.querySelector('.btn-padam-binaan'));
    });

    function bindPadamBinaan(btn) {
        btn.addEventListener('click', function () {
            const tbody = document.getElementById('bodyBinaan');
            if (tbody.querySelectorAll('tr').length <= 1) {
                alert('Sekurang-kurangnya satu baris binaan luar diperlukan.');
                return;
            }
            this.closest('tr').remove();
            renumberBil(tbody, 'bil-binaan');
            renameIndexes(tbody);
        });
    }
    document.querySelectorAll('#bodyBinaan .btn-padam-binaan').forEach(bindPadamBinaan);

    // Validate sebelum submit
    document.getElementById('mainForm').addEventListener('submit', function (e) {
        const chkBlok = document.getElementById('chkBlok');
        const chkBinaan = document.getElementById('chkBinaan');
        if (!chkBlok.checked && !chkBinaan.checked) {
            e.preventDefault();
            alert('Sila tandakan sekurang-kurangnya satu pilihan: Blok atau Binaan Luar.');
        }
    });

});
</script>
@endpush