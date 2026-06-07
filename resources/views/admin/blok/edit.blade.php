@extends('layouts.app')

@section('title', 'Edit Blok / Binaan Luar')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <!-- Header -->
                <div class="mb-4">
                    <h2 class="mb-1"><i class="bi bi-pencil-square"></i> Edit Blok / Binaan Luar</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.blok.index') }}">Konfigurasi Blok</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </nav>
                </div>

                {{-- Nanti guna: route('admin.blok.update', $premis->id) --}}
                <form action="/admin/blok/1" method="POST" id="mainForm">
                    @csrf
                    @method('PUT')

                    {{-- ══════════════════════════════════════
                         MAKLUMAT PREMIS
                    ══════════════════════════════════════ --}}
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header text-white py-2" style="background-color:#4a5568;">
                            <h6 class="mb-0"><i class="bi bi-geo-alt-fill me-2"></i>Maklumat Premis</h6>
                        </div>
                        <div class="card-body pt-3">
                            <div class="row g-3">

                                {{-- Dropdown Nama Premis --}}
                                <div class="col-md-7">
                                    <label class="form-label fw-semibold">
                                        Nama Premis <span class="text-danger">*</span>
                                    </label>
                                    <select name="premis_id" id="selectPremis"
                                        class="form-select @error('premis_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Premis --</option>
                                        {{-- Dummy data dulu, nanti replace dengan @foreach ($premisList as $p) --}}
                                        <option value="1" data-dpa="11011 01MYS.14004 4.BD0001"
                                            {{ old('premis_id', 1) == 1 ? 'selected' : '' }}>
                                            PARLIMEN MALAYSIA
                                        </option>
                                        <option value="2" data-dpa="11011 01MYS.14004 4.BD0002"
                                            {{ old('premis_id', 1) == 2 ? 'selected' : '' }}>
                                            PEJABAT JKR KUALA LUMPUR
                                        </option>
                                        <option value="3" data-dpa="11011 01MYS.14004 4.BD0003"
                                            {{ old('premis_id', 1) == 3 ? 'selected' : '' }}>
                                            HOSPITAL KUALA LUMPUR
                                        </option>
                                        {{-- Nanti guna: {{ old('premis_id', $premis->id) == $p->id ? 'selected' : '' }} --}}
                                    </select>
                                    @error('premis_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- No. DPA — auto-fill, readonly --}}
                                <div class="col-md-5">
                                    <label class="form-label fw-semibold">Nombor DPA</label>
                                    <input type="text" id="inputNoDpa" name="no_dpa" class="form-control bg-light"
                                        {{-- Nanti guna: value="{{ old('no_dpa', $premis->no_dpa) }}" --}}
                                        value="11011 01MYS.14004 4.BD0001"
                                        placeholder="Auto-isi selepas pilih premis" readonly>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- ══════════════════════════════════════
                         BAHAGIAN A — BLOK (table dynamic)
                    ══════════════════════════════════════ --}}
                    <div class="card border-0 shadow-sm mb-3">

                        <div class="card-header py-2" style="background-color:#0d6efd;">
                            <div class="form-check d-flex align-items-center gap-2 mb-0">
                                <input class="form-check-input mt-0 flex-shrink-0" type="checkbox"
                                    name="ada_blok" id="chkBlok" value="1"
                                    {{-- Nanti guna: {{ old('ada_blok', $premis->bloks->count() > 0 ? '1' : '') ? 'checked' : '' }} --}}
                                    {{ old('ada_blok', '1') ? 'checked' : '' }}
                                    style="width:1.2rem;height:1.2rem;">
                                <label class="form-check-label fw-semibold mb-0 text-white d-flex align-items-center gap-2"
                                    for="chkBlok" style="cursor:pointer;">
                                    <i class="bi bi-building"></i>
                                    Blok
                                    <span class="fw-normal opacity-75">(Tandakan '√' jika berkenaan)</span>
                                </label>
                            </div>
                        </div>

                        <div id="seksyenBlok" class="{{ old('ada_blok', '1') ? '' : 'd-none' }}">
                            <div class="card-body">

                                <!-- Butang Tambah -->
                                <button type="button" class="btn btn-success btn-sm mb-3" id="btnTambahBlok">
                                    <i class="bi bi-plus-lg"></i> Tambah Blok
                                </button>

                                <!-- Table -->
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle mb-2" id="tableBlok">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width:50px;">Bil</th>
                                                <th>Nama Blok <span class="text-danger">*</span></th>
                                                <th>Fungsi Binaan <span class="text-danger">*</span></th>
                                                <th style="width:160px;">Luas Tapak (m²) <span class="text-danger">*</span></th>
                                                <th>Kod Blok mySPATA</th>
                                                <th style="width:50px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="bodyBlok">
                                            {{-- Dummy data — nanti replace dengan @foreach ($premis->bloks as $i => $blok) --}}
                                            <tr>
                                                <td class="text-center fw-semibold bil-blok">1</td>
                                                <td>
                                                    <input type="text" name="blok[0][nama]"
                                                        class="form-control form-control-sm"
                                                        value="DEWAN PERSIDANGAN">
                                                        {{-- Nanti: value="{{ old('blok.0.nama', $blok->nama) }}" --}}
                                                </td>
                                                <td>
                                                    <input type="text" name="blok[0][fungsi_binaan]"
                                                        class="form-control form-control-sm"
                                                        value="DEWAN">
                                                        {{-- Nanti: value="{{ old('blok.0.fungsi_binaan', $blok->fungsi_binaan) }}" --}}
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" name="blok[0][luas_tapak]"
                                                            class="form-control form-control-sm"
                                                            step="0.01" min="0"
                                                            value="4509.26">
                                                            {{-- Nanti: value="{{ old('blok.0.luas_tapak', $blok->luas_tapak) }}" --}}
                                                        <span class="input-group-text">m²</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="blok[0][kod_myspata]"
                                                        class="form-control form-control-sm"
                                                        value="F">
                                                        {{-- Nanti: value="{{ old('blok.0.kod_myspata', $blok->kod_myspata) }}" --}}
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-sm btn-padam-blok"
                                                        title="Padam baris">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center fw-semibold bil-blok">2</td>
                                                <td>
                                                    <input type="text" name="blok[1][nama]"
                                                        class="form-control form-control-sm"
                                                        value="BLOK PEJABAT">
                                                </td>
                                                <td>
                                                    <input type="text" name="blok[1][fungsi_binaan]"
                                                        class="form-control form-control-sm"
                                                        value="PEJABAT">
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" name="blok[1][luas_tapak]"
                                                            class="form-control form-control-sm"
                                                            step="0.01" min="0"
                                                            value="2100.00">
                                                        <span class="input-group-text">m²</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="blok[1][kod_myspata]"
                                                        class="form-control form-control-sm"
                                                        value="A">
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-sm btn-padam-blok"
                                                        title="Padam baris">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Catatan Blok -->
                                <div class="mt-2">
                                    <label class="form-label fw-semibold">Perihal / Catatan</label>
                                    <textarea name="catatan_blok" rows="2" class="form-control">{{ old('catatan_blok', 'Catatan blok dummy') }}</textarea>
                                    {{-- Nanti: {{ old('catatan_blok', $premis->catatan_blok) }} --}}
                                </div>

                            </div>
                        </div>

                    </div>{{-- /card Blok --}}

                    {{-- ══════════════════════════════════════
                         BAHAGIAN B — BINAAN LUAR (table dynamic)
                    ══════════════════════════════════════ --}}
                    <div class="card border-0 shadow-sm mb-4">

                        <div class="card-header py-2" style="background-color:#198754;">
                            <div class="form-check d-flex align-items-center gap-2 mb-0">
                                <input class="form-check-input mt-0 flex-shrink-0" type="checkbox"
                                    name="ada_binaan_luar" id="chkBinaan" value="1"
                                    {{-- Nanti guna: {{ old('ada_binaan_luar', $premis->binaanLuars->count() > 0 ? '1' : '') ? 'checked' : '' }} --}}
                                    {{ old('ada_binaan_luar') ? 'checked' : '' }}
                                    style="width:1.2rem;height:1.2rem;">
                                <label class="form-check-label fw-semibold mb-0 text-white d-flex align-items-center gap-2"
                                    for="chkBinaan" style="cursor:pointer;">
                                    <i class="bi bi-sign-intersection"></i>
                                    Binaan Luar
                                    <span class="fw-normal opacity-75">(Tandakan '√' jika berkenaan)</span>
                                </label>
                            </div>
                        </div>

                        <div id="seksyenBinaan" class="{{ old('ada_binaan_luar') ? '' : 'd-none' }}">
                            <div class="card-body">

                                <!-- Butang Tambah -->
                                <button type="button" class="btn btn-success btn-sm mb-3" id="btnTambahBinaan">
                                    <i class="bi bi-plus-lg"></i> Tambah Binaan Luar
                                </button>

                                <!-- Table -->
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle mb-2" id="tableBinaan">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width:50px;">Bil</th>
                                                <th>Nama Binaan Luar <span class="text-danger">*</span></th>
                                                <th>Jenis Binaan Luar <span class="text-danger">*</span></th>
                                                <th style="width:160px;">Luas Tapak (m²) <span class="text-danger">*</span></th>
                                                <th>Kod Binaan Luar mySPATA</th>
                                                <th style="width:50px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="bodyBinaan">
                                            {{-- Dummy data — nanti replace dengan @foreach ($premis->binaanLuars as $i => $binaan) --}}
                                            <tr>
                                                <td class="text-center fw-semibold bil-binaan">1</td>
                                                <td>
                                                    <input type="text" name="binaan[0][nama]"
                                                        class="form-control form-control-sm"
                                                        value="PAGAR KAWASAN">
                                                </td>
                                                <td>
                                                    <input type="text" name="binaan[0][jenis]"
                                                        class="form-control form-control-sm"
                                                        value="PAGAR">
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" name="binaan[0][luas_tapak]"
                                                            class="form-control form-control-sm"
                                                            step="0.01" min="0"
                                                            value="320.00">
                                                        <span class="input-group-text">m²</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="binaan[0][kod_myspata]"
                                                        class="form-control form-control-sm"
                                                        value="PG01">
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-sm btn-padam-binaan"
                                                        title="Padam baris">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Catatan Binaan Luar -->
                                <div class="mt-2">
                                    <label class="form-label fw-semibold">Perihal / Catatan</label>
                                    <textarea name="catatan_binaan" rows="2" class="form-control">{{ old('catatan_binaan') }}</textarea>
                                    {{-- Nanti: {{ old('catatan_binaan', $premis->catatan_binaan) }} --}}
                                </div>

                            </div>
                        </div>

                    </div>{{-- /card Binaan Luar --}}

                    {{-- ── BUTANG SUBMIT ── --}}
                    <div class="d-flex gap-2 mb-5">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-floppy"></i> Kemaskini
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

            // ── Auto-fill No. DPA ──────────────────────────────
            document.getElementById('selectPremis').addEventListener('change', function () {
                const dpa = this.options[this.selectedIndex].getAttribute('data-dpa') || '';
                document.getElementById('inputNoDpa').value = dpa;
            });

            // ── Toggle checkbox expand ──────────────────────────
            function bindToggle(checkboxId, seksyenId) {
                const chk = document.getElementById(checkboxId);
                const seksyen = document.getElementById(seksyenId);
                chk.addEventListener('change', function () {
                    seksyen.classList.toggle('d-none', !this.checked);
                });
            }
            bindToggle('chkBlok', 'seksyenBlok');
            bindToggle('chkBinaan', 'seksyenBinaan');

            // ── Dynamic table helper ────────────────────────────
            function renamberBil(tbody, bilClass) {
                tbody.querySelectorAll('.' + bilClass).forEach(function (td, i) {
                    td.textContent = i + 1;
                });
            }

            function renameIndexes(tbody, prefix) {
                tbody.querySelectorAll('tr').forEach(function (tr, i) {
                    tr.querySelectorAll('input, textarea, select').forEach(function (el) {
                        el.name = el.name.replace(/\[\d+\]/, '[' + i + ']');
                    });
                });
            }

            // ── BLOK: Tambah row ───────────────────────────────
            document.getElementById('btnTambahBlok').addEventListener('click', function () {
                const tbody = document.getElementById('bodyBlok');
                const idx = tbody.querySelectorAll('tr').length;

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="text-center fw-semibold bil-blok">${idx + 1}</td>
                    <td><input type="text" name="blok[${idx}][nama]" class="form-control form-control-sm"></td>
                    <td><input type="text" name="blok[${idx}][fungsi_binaan]" class="form-control form-control-sm"></td>
                    <td>
                        <div class="input-group input-group-sm">
                            <input type="number" name="blok[${idx}][luas_tapak]"
                                class="form-control form-control-sm" step="0.01" min="0">
                            <span class="input-group-text">m²</span>
                        </div>
                    </td>
                    <td><input type="text" name="blok[${idx}][kod_myspata]" class="form-control form-control-sm"></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm btn-padam-blok" title="Padam baris">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </td>`;
                tbody.appendChild(tr);
                bindPadamBlok(tr.querySelector('.btn-padam-blok'));
            });

            // ── BLOK: Padam row ────────────────────────────────
            function bindPadamBlok(btn) {
                btn.addEventListener('click', function () {
                    const tbody = document.getElementById('bodyBlok');
                    if (tbody.querySelectorAll('tr').length <= 1) {
                        alert('Sekurang-kurangnya satu baris blok diperlukan.');
                        return;
                    }
                    this.closest('tr').remove();
                    renamberBil(tbody, 'bil-blok');
                    renameIndexes(tbody, 'blok');
                });
            }
            document.querySelectorAll('#bodyBlok .btn-padam-blok').forEach(bindPadamBlok);

            // ── BINAAN LUAR: Tambah row ────────────────────────
            document.getElementById('btnTambahBinaan').addEventListener('click', function () {
                const tbody = document.getElementById('bodyBinaan');
                const idx = tbody.querySelectorAll('tr').length;

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="text-center fw-semibold bil-binaan">${idx + 1}</td>
                    <td><input type="text" name="binaan[${idx}][nama]" class="form-control form-control-sm"></td>
                    <td><input type="text" name="binaan[${idx}][jenis]" class="form-control form-control-sm"></td>
                    <td>
                        <div class="input-group input-group-sm">
                            <input type="number" name="binaan[${idx}][luas_tapak]"
                                class="form-control form-control-sm" step="0.01" min="0">
                            <span class="input-group-text">m²</span>
                        </div>
                    </td>
                    <td><input type="text" name="binaan[${idx}][kod_myspata]" class="form-control form-control-sm"></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm btn-padam-binaan" title="Padam baris">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </td>`;
                tbody.appendChild(tr);
                bindPadamBinaan(tr.querySelector('.btn-padam-binaan'));
            });

            // ── BINAAN LUAR: Padam row ─────────────────────────
            function bindPadamBinaan(btn) {
                btn.addEventListener('click', function () {
                    const tbody = document.getElementById('bodyBinaan');
                    if (tbody.querySelectorAll('tr').length <= 1) {
                        alert('Sekurang-kurangnya satu baris binaan luar diperlukan.');
                        return;
                    }
                    this.closest('tr').remove();
                    renamberBil(tbody, 'bil-binaan');
                    renameIndexes(tbody, 'binaan');
                });
            }
            document.querySelectorAll('#bodyBinaan .btn-padam-binaan').forEach(bindPadamBinaan);

            // ── Validate sebelum submit ────────────────────────
            document.getElementById('mainForm').addEventListener('submit', function (e) {
                const chkBlok = document.getElementById('chkBlok');
                const chkBinaan = document.getElementById('chkBinaan');
                if (!chkBlok.checked && !chkBinaan.checked) {
                    e.preventDefault();
                    alert('Sila tandakan sekurang-kurangnya satu pilihan: Blok atau Binaan Luar.');
                    chkBlok.focus();
                }
            });

        });
    </script>
@endpush