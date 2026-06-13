@extends('layouts.app')

@section('title', 'Edit Komponen')

@section('styles')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<style>
.select2-container--bootstrap-5 .select2-selection {
    min-height: 38px;
}
.input-group-text {
    background-color: #e9ecef;
}
.new-tag-badge {
    background: #10b981;
    color: white;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 0.75rem;
    margin-left: 5px;
}
.existing-tag-badge {
    background: #3b82f6;
    color: white;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 0.75rem;
    margin-left: 5px;
}
.nama-field-wrapper {
    position: relative;
}
.nama-field-wrapper .autofill-indicator {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 0.875rem;
    color: #10b981;
}
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">EDIT BORANG PENGUMPULAN DATA DAFTAR ASET KHUSUS</h5>
                        <small class="text-white">Peringkat Komponen</small>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('components.update', $component) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Maklumat Lokasi Komponen -->
                    <div class="card mb-4">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0">MAKLUMAT LOKASI KOMPONEN</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Premis <span class="text-danger">*</span></label>
                                    <select class="form-select" name="nama_premis" id="selectPremis" required>
                                        <option value="">-- Pilih Premis --</option>
                                        @foreach ($premis as $p)
                                            <option value="{{ $p->nama_premis }}" data-dpa="{{ $p->no_dpa }}" data-id="{{ $p->id }}"
                                                {{ old('nama_premis', $component->nama_premis) == $p->nama_premis ? 'selected' : '' }}>
                                                {{ $p->nama_premis }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('nama_premis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nombor DPA <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nombor_dpa') is-invalid @enderror" 
                                           name="nombor_dpa" id="inputNoDpa" value="{{ old('nombor_dpa', $component->nombor_dpa) }}" 
                                           placeholder="Contoh: 1610MYS.140144.BD0001" readonly required>
                                    @error('nombor_dpa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Blok Section -->
                    <div class="card mb-4">
                        <div class="card-header" style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="ada_blok" 
                                       id="ada_blok" value="1" {{ old('ada_blok', $component->ada_blok) ? 'checked' : '' }}
                                       style="width: 20px; height: 20px; border: 2px solid #64748b; cursor: pointer;">
                                <label class="form-check-label fw-bold ms-2" for="ada_blok" style="cursor: pointer; font-size: 1rem;">
                                    Blok (Tandakan '√' jika berkenaan)
                                </label>
                            </div>
                        </div>
                        <div class="card-body" id="blok_section" style="display: {{ old('ada_blok', $component->ada_blok) ? 'block' : 'none' }};">
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th colspan="2" class="text-center">Maklumat Lokasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td width="30%">
                                            Kod Blok
                                            <span id="kod-blok-status" class="ms-2"></span>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <select class="form-select select2-blok" name="kod_blok" id="kod_blok">
                                                    <option value="">-- Pilih atau Taip Kod Blok --</option>
                                                    @foreach ($bloks as $blok)
                                                        <option value="{{ $blok->kod_blok_myspata }}"
                                                            data-nama="{{ $blok->nama_blok }}"
                                                            data-premis="{{ $blok->premis_id }}"
                                                            {{ old('kod_blok', $component->kod_blok) == $blok->kod_blok_myspata ? 'selected' : '' }}>
                                                            {{ $blok->nama_blok }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="nama-blok-row" style="display: {{ old('nama_blok', $component->nama_blok) ? 'table-row' : 'none' }};">
                                        <td>Nama Blok</td>
                                        <td>
                                            <div class="nama-field-wrapper">
                                                <input type="text" class="form-control" id="nama_blok" name="nama_blok" 
                                                       value="{{ old('nama_blok', $component->nama_blok) }}"
                                                       placeholder="Nama akan dijana automatik atau anda boleh edit">
                                                <span class="autofill-indicator" id="autofill-indicator-blok" style="display: none;">
                                                    <i class="bi bi-magic"></i> Auto
                                                </span>
                                            </div>
                                            <small class="text-success" id="nama-blok-hint"></small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Kod Aras
                                            <span id="kod-aras-status" class="ms-2"></span>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <select class="form-select select2-aras" name="kod_aras" id="kod_aras">
                                                    <option value="">-- Pilih atau Taip Kod Aras --</option>
                                                    @foreach($kodAras as $aras)
                                                        <option value="{{ $aras->kod }}" 
                                                                data-nama="{{ $aras->nama }}"
                                                                {{ old('kod_aras', $component->kod_aras) == $aras->kod ? 'selected' : '' }}>
                                                            {{ $aras->kod }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="nama-aras-row" style="display: {{ old('nama_aras', $component->nama_aras) ? 'table-row' : 'none' }};">
                                        <td>Nama Aras</td>
                                        <td>
                                            <div class="nama-field-wrapper">
                                                <input type="text" class="form-control" id="nama_aras" name="nama_aras" 
                                                       value="{{ old('nama_aras', $component->nama_aras) }}"
                                                       placeholder="Nama akan dijana automatik atau anda boleh edit">
                                                <span class="autofill-indicator" id="autofill-indicator-aras" style="display: none;">
                                                    <i class="bi bi-magic"></i> Auto
                                                </span>
                                            </div>
                                            <small class="text-success" id="nama-aras-hint"></small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kod Ruang</td>
                                        <td>
                                            <div class="input-group">
                                                <select class="form-select select2-ruang" name="kod_ruang" id="kod_ruang">
                                                    <option value="">-- Pilih atau Taip Kod Ruang --</option>
                                                    @foreach($kodRuangs as $ruang)
                                                        <option value="{{ $ruang->kod }}" 
                                                                data-nama="{{ $ruang->nama }}"
                                                                {{ old('kod_ruang', $component->kod_ruang) == $ruang->kod ? 'selected' : '' }}>
                                                            {{ $ruang->kod }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nama Ruang</td>
                                        <td>
                                            <div class="input-group">
                                                <select class="form-select select2-nama-ruang" name="nama_ruang" id="nama_ruang">
                                                    <option value="">-- Pilih atau Taip Nama Ruang --</option>
                                                    @foreach($namaRuangs as $nama)
                                                        <option value="{{ $nama->nama }}" 
                                                                data-kod="{{ $nama->kod }}"
                                                                {{ old('nama_ruang', $component->nama_ruang) == $nama->nama ? 'selected' : '' }}>
                                                            {{ $nama->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Catatan:</td>
                                        <td><textarea class="form-control" name="catatan_blok" rows="3">{{ old('catatan_blok', $component->catatan_blok) }}</textarea></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Binaan Luar Section -->
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="ada_binaan_luar" 
                                       id="ada_binaan_luar" value="1" {{ old('ada_binaan_luar', $component->ada_binaan_luar) ? 'checked' : '' }}
                                       style="width: 20px; height: 20px; border: 2px solid #64748b; cursor: pointer;">
                                <label class="form-check-label fw-bold" for="ada_binaan_luar">
                                    Binaan Luar (Tandakan '√' jika berkenaan)
                                </label>
                            </div>
                        </div>
                        <div class="card-body" id="binaan_section" style="display: {{ old('ada_binaan_luar', $component->ada_binaan_luar) ? 'block' : 'none' }};">
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th colspan="2" class="text-center">Maklumat Lokasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td width="30%">Kod Binaan Luar</td>
                                        <td>
                                            <div class="input-group">
                                                <select class="form-select select2-binaan-luar" name="kod_binaan_luar" id="kod_binaan_luar">
                                                    <option value="">-- Pilih atau Taip Kod Binaan Luar --</option>
                                                    @foreach($binaanLuars as $binaan)
                                                        <option value="{{ $binaan->kod_binaan_luar_myspata }}" 
                                                                data-nama="{{ $binaan->nama_binaan_luar }}"
                                                                data-premis="{{ $binaan->premis_id }}"
                                                                {{ old('kod_binaan_luar', $component->kod_binaan_luar) == $binaan->kod_binaan_luar_myspata ? 'selected' : '' }}>
                                                            {{ $binaan->kod_binaan_luar_myspata }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="30%">Nama Binaan Luar</td>
                                        <td><input type="text" class="form-control" name="nama_binaan_luar" id="nama_binaan_luar" 
                                                   value="{{ old('nama_binaan_luar', $component->nama_binaan_luar) }}" 
                                                   placeholder="Contoh: Kolam Renang A"></td>
                                    </tr>
                                    <tr>
                                        <td>Koordinat GPS (WGS 84)</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" name="koordinat_x" 
                                                           value="{{ old('koordinat_x', $component->koordinat_x) }}" placeholder="X: ( Cth 2.935905 )">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" name="koordinat_y" 
                                                           value="{{ old('koordinat_y', $component->koordinat_y) }}" placeholder="Y: ( Cth 101.700286)">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="fw-bold">Diisi Jika Binaan Luar Mempunyai Aras dan Ruang</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Kod Aras
                                            <span id="kod-aras-binaan-status" class="ms-2"></span>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <select class="form-select select2-aras-binaan" name="kod_aras_binaan" id="kod_aras_binaan">
                                                    <option value="">-- Pilih atau Taip Kod Aras --</option>
                                                    @foreach($kodAras as $aras)
                                                        <option value="{{ $aras->kod }}" 
                                                                data-nama="{{ $aras->nama }}"
                                                                {{ old('kod_aras_binaan', $component->kod_aras_binaan) == $aras->kod ? 'selected' : '' }}>
                                                            {{ $aras->kod }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="nama-aras-binaan-row" style="display: {{ old('nama_aras_binaan', $component->nama_aras_binaan) ? 'table-row' : 'none' }};">
                                        <td>Nama Aras</td>
                                        <td>
                                            <div class="nama-field-wrapper">
                                                <input type="text" class="form-control" id="nama_aras_binaan" name="nama_aras_binaan" 
                                                       value="{{ old('nama_aras_binaan', $component->nama_aras_binaan) }}"
                                                       placeholder="Nama akan dijana automatik atau anda boleh edit">
                                                <span class="autofill-indicator" id="autofill-indicator-aras-binaan" style="display: none;">
                                                    <i class="bi bi-magic"></i> Auto
                                                </span>
                                            </div>
                                            <small class="text-success" id="nama-aras-binaan-hint"></small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kod Ruang</td>
                                        <td>
                                            <div class="input-group">
                                                <select class="form-select select2-ruang-binaan" name="kod_ruang_binaan" id="kod_ruang_binaan">
                                                    <option value="">-- Pilih atau Taip Kod Ruang --</option>
                                                    @foreach($kodRuangs as $ruang)
                                                        <option value="{{ $ruang->kod }}" 
                                                                data-nama="{{ $ruang->nama }}"
                                                                {{ old('kod_ruang_binaan', $component->kod_ruang_binaan) == $ruang->kod ? 'selected' : '' }}>
                                                            {{ $ruang->kod }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nama Ruang</td>
                                        <td>
                                            <div class="input-group">
                                                <select class="form-select select2-nama-ruang-binaan" name="nama_ruang_binaan" id="nama_ruang_binaan">
                                                    <option value="">-- Pilih atau Taip Nama Ruang --</option>
                                                    @foreach($namaRuangs as $nama)
                                                        <option value="{{ $nama->nama }}" 
                                                                data-kod="{{ $nama->kod }}"
                                                                {{ old('nama_ruang_binaan', $component->nama_ruang_binaan) == $nama->nama ? 'selected' : '' }}>
                                                            {{ $nama->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Catatan:</td>
                                        <td><textarea class="form-control" name="catatan_binaan" rows="3">{{ old('catatan_binaan', $component->catatan_binaan) }}</textarea></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" name="status" required>
                            <option value="aktif" {{ old('status', $component->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="tidak_aktif" {{ old('status', $component->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Kemaskini Komponen
                        </button>
                        <a href="{{ route('components.show', $component) }}" class="btn btn-info">
                            <i class="bi bi-eye"></i> Lihat
                        </a>
                        <a href="{{ route('components.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // CSRF Token untuk AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Cache original options for Blok & Binaan Luar
    const originalBlokOptions = $('#kod_blok option').clone();
    const originalBinaanOptions = $('#kod_binaan_luar option').clone();

    function filterLocationOptions(premisId) {
        // Filter Blok options
        const selectedBlokValue = $('#kod_blok').val();
        $('#kod_blok').empty().append('<option value="">-- Pilih atau Taip Kod Blok --</option>');
        originalBlokOptions.each(function() {
            const blockPremisId = $(this).data('premis');
            const val = $(this).val();
            if (val !== '') {
                if (!premisId || !blockPremisId || blockPremisId == premisId) {
                    const opt = $(this).clone();
                    if (val === selectedBlokValue) {
                        opt.attr('selected', 'selected');
                    }
                    $('#kod_blok').append(opt);
                }
            }
        });
        $('#kod_blok').trigger('change');

        // Filter Binaan Luar options
        const selectedBinaanValue = $('#kod_binaan_luar').val();
        $('#kod_binaan_luar').empty().append('<option value="">-- Pilih atau Taip Kod Binaan Luar --</option>');
        originalBinaanOptions.each(function() {
            const binaanPremisId = $(this).data('premis');
            const val = $(this).val();
            if (val !== '') {
                if (!premisId || !binaanPremisId || binaanPremisId == premisId) {
                    const opt = $(this).clone();
                    if (val === selectedBinaanValue) {
                        opt.attr('selected', 'selected');
                    }
                    $('#kod_binaan_luar').append(opt);
                }
            }
        });
        $('#kod_binaan_luar').trigger('change');
    }

    // Auto-fill No DPA & filter lists bila pilih premis
    $('#selectPremis').on('change', function() {
        const selectedOption = $(this).find(':selected');
        const dpa = selectedOption.data('dpa') || '';
        const premisId = selectedOption.data('id') || '';
        
        $('#inputNoDpa').val(dpa);
        filterLocationOptions(premisId);
    });

    // Auto-fill Nama Binaan Luar bila pilih Kod Binaan Luar
    $('#kod_binaan_luar').on('select2:select change', function() {
        const selectedOption = $(this).find(':selected');
        const namaBinaan = selectedOption.data('nama') || '';
        if (namaBinaan) {
            $('#nama_binaan_luar').val(namaBinaan);
        }
    });

    // Initialize all Select2 dropdowns
    initializeSelect2();

    // ========================================
    // KOD BLOK - Auto Check & Save
    // ========================================
    let typingTimerBlok, saveTimerBlok;
    const doneTypingInterval = 500;

    $('#kod_blok').on('select2:select select2:unselect change', function(e) {
        clearTimeout(typingTimerBlok);
        const kodValue = $(this).val();
        
        if (!kodValue) {
            $('#nama-blok-row').hide();
            $('#kod-blok-status').html('');
            return;
        }

        typingTimerBlok = setTimeout(() => checkKodBlok(kodValue), doneTypingInterval);
    });

    function checkKodBlok(kod) {
        if (!kod) return;

        $('#kod-blok-status').html('<span class="badge bg-secondary">Menyemak...</span>');
        $('#nama-blok-row').show();
        $('#nama_blok').prop('readonly', true).val('Menyemak kod...');

        $.ajax({
            url: '{{ route("api.check-kod-blok") }}',
            method: 'POST',
            data: { kod: kod },
            success: function(response) {
                if (response.exists) {
                    $('#kod-blok-status').html('<span class="existing-tag-badge"><i class="bi bi-check-circle"></i> Sedia Ada</span>');
                    $('#nama_blok').val(response.data.nama).prop('readonly', true);
                    $('#nama-blok-hint').text('✓ Kod ini sudah wujud dalam database');
                    $('#autofill-indicator-blok').hide();
                } else {
                    $('#kod-blok-status').html('<span class="new-tag-badge"><i class="bi bi-sparkles"></i> Kod Baru</span>');
                    $('#nama_blok').val(response.suggestion).prop('readonly', false);
                    $('#nama-blok-hint').html('💡 Nama disarankan. <strong>Akan disimpan automatik</strong>.');
                    $('#autofill-indicator-blok').show();
                }
            },
            error: function() {
                $('#kod-blok-status').html('<span class="badge bg-danger">Ralat</span>');
                $('#nama_blok').val('').prop('readonly', false);
                $('#nama-blok-hint').text('');
            }
        });
    }

    $('#nama_blok').on('input', function() {
        const kodValue = $('#kod_blok').val();
        const namaValue = $(this).val().trim();
        
        clearTimeout(saveTimerBlok);
        const isNewCode = $('#kod-blok-status').find('.new-tag-badge').length > 0;
        
        if (isNewCode && kodValue && namaValue) {
            $('#nama-blok-hint').html('⏳ Menyimpan...');
            saveTimerBlok = setTimeout(() => saveToDatabase('blok', kodValue, namaValue), 1000);
        }
    });

    $('#nama_blok').on('focus', function() {
        $(this).prop('readonly', false);
        $('#autofill-indicator-blok').hide();
    });

    // ========================================
    // KOD ARAS (Blok Section) - Auto Check & Save
    // ========================================
    let typingTimerAras, saveTimerAras;

    $('#kod_aras').on('select2:select select2:unselect change', function(e) {
        clearTimeout(typingTimerAras);
        const kodValue = $(this).val();
        
        if (!kodValue) {
            $('#nama-aras-row').hide();
            $('#kod-aras-status').html('');
            return;
        }

        typingTimerAras = setTimeout(() => checkKodAras(kodValue, 'blok'), doneTypingInterval);
    });

    $('#nama_aras').on('input', function() {
        const kodValue = $('#kod_aras').val();
        const namaValue = $(this).val().trim();
        
        clearTimeout(saveTimerAras);
        const isNewCode = $('#kod-aras-status').find('.new-tag-badge').length > 0;
        
        if (isNewCode && kodValue && namaValue) {
            $('#nama-aras-hint').html('⏳ Menyimpan...');
            saveTimerAras = setTimeout(() => saveToDatabase('aras', kodValue, namaValue, 'blok'), 1000);
        }
    });

    $('#nama_aras').on('focus', function() {
        $(this).prop('readonly', false);
        $('#autofill-indicator-aras').hide();
    });

    // ========================================
    // KOD ARAS (Binaan Luar Section) - Auto Check & Save
    // ========================================
    let typingTimerArasBinaan, saveTimerArasBinaan;

    $('#kod_aras_binaan').on('select2:select select2:unselect change', function(e) {
        clearTimeout(typingTimerArasBinaan);
        const kodValue = $(this).val();
        
        if (!kodValue) {
            $('#nama-aras-binaan-row').hide();
            $('#kod-aras-binaan-status').html('');
            return;
        }

        typingTimerArasBinaan = setTimeout(() => checkKodAras(kodValue, 'binaan'), doneTypingInterval);
    });

    $('#nama_aras_binaan').on('input', function() {
        const kodValue = $('#kod_aras_binaan').val();
        const namaValue = $(this).val().trim();
        
        clearTimeout(saveTimerArasBinaan);
        const isNewCode = $('#kod-aras-binaan-status').find('.new-tag-badge').length > 0;
        
        if (isNewCode && kodValue && namaValue) {
            $('#nama-aras-binaan-hint').html('⏳ Menyimpan...');
            saveTimerArasBinaan = setTimeout(() => saveToDatabase('aras', kodValue, namaValue, 'binaan'), 1000);
        }
    });

    $('#nama_aras_binaan').on('focus', function() {
        $(this).prop('readonly', false);
        $('#autofill-indicator-aras-binaan').hide();
    });

    // ========================================
    // HELPER FUNCTIONS
    // ========================================
    function checkKodAras(kod, context) {
        if (!kod) return;

        const suffix = context === 'binaan' ? '-binaan' : '';
        const statusEl = `#kod-aras${suffix}-status`;
        const rowEl = `#nama-aras${suffix}-row`;
        const inputEl = `#nama_aras${suffix === '-binaan' ? '_binaan' : ''}`;
        const hintEl = `#nama-aras${suffix}-hint`;
        const indicatorEl = `#autofill-indicator-aras${suffix}`;

        $(statusEl).html('<span class="badge bg-secondary">Menyemak...</span>');
        $(rowEl).show();
        $(inputEl).prop('readonly', true).val('Menyemak kod...');

        $.ajax({
            url: '{{ route("api.check-kod-aras") }}',
            method: 'POST',
            data: { kod: kod },
            success: function(response) {
                if (response.exists) {
                    $(statusEl).html('<span class="existing-tag-badge"><i class="bi bi-check-circle"></i> Sedia Ada</span>');
                    $(inputEl).val(response.data.nama).prop('readonly', true);
                    $(hintEl).text('✓ Kod ini sudah wujud dalam database');
                    $(indicatorEl).hide();
                } else {
                    $(statusEl).html('<span class="new-tag-badge"><i class="bi bi-sparkles"></i> Kod Baru</span>');
                    $(inputEl).val(response.suggestion).prop('readonly', false);
                    $(hintEl).html('💡 Nama disarankan. <strong>Akan disimpan automatik</strong>.');
                    $(indicatorEl).show();
                }
            },
            error: function() {
                $(statusEl).html('<span class="badge bg-danger">Ralat</span>');
                $(inputEl).val('').prop('readonly', false);
                $(hintEl).text('');
            }
        });
    }

    function saveToDatabase(type, kod, nama, context = null) {
        const routes = {
            'blok': '{{ route("api.save-kod-blok") }}',
            'aras': '{{ route("api.save-kod-aras") }}'
        };

        const suffix = context === 'binaan' ? '-binaan' : '';
        const statusEl = type === 'blok' ? '#kod-blok-status' : `#kod-aras${suffix}-status`;
        const hintEl = type === 'blok' ? '#nama-blok-hint' : `#nama-aras${suffix}-hint`;

        $.ajax({
            url: routes[type],
            method: 'POST',
            data: { kod: kod, nama: nama },
            success: function(response) {
                if (response.success) {
                    if (response.action === 'created') {
                        $(statusEl).html('<span class="badge bg-success"><i class="bi bi-check-circle-fill"></i> Disimpan</span>');
                        $(hintEl).html('✅ Kod baru telah disimpan ke database!');
                        
                        setTimeout(function() {
                            $(statusEl).html('<span class="existing-tag-badge"><i class="bi bi-check-circle"></i> Sedia Ada</span>');
                            $(`#nama_${type}${suffix === '-binaan' ? '_binaan' : ''}`).prop('readonly', true);
                            $(hintEl).text('✓ Kod ini sudah wujud dalam database');
                        }, 2000);
                    } else {
                        $(hintEl).html('✅ Kod telah dikemaskini!');
                    }

                    // Show toast notification
                    showToast('success', response.message);
                }
            },
            error: function(xhr) {
                $(statusEl).html('<span class="badge bg-danger">Ralat Simpan</span>');
                $(hintEl).html('❌ Gagal menyimpan. Cuba lagi.');
                console.error('Error saving:', xhr.responseJSON);
            }
        });
    }

    function showToast(icon, title) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: icon,
                title: title,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        }
    }

    function initializeSelect2() {
        $('.select2-blok, .select2-aras, .select2-aras-binaan, .select2-binaan-luar').select2({
            theme: 'bootstrap-5',
            tags: true,
            placeholder: 'Pilih atau taip kod baru',
            allowClear: true,
            createTag: function (params) {
                var term = $.trim(params.term);
                if (term === '') return null;
                return { id: term, text: term, newTag: true }
            },
            templateResult: function(data) {
                if (data.newTag) {
                    return $('<span><i class="bi bi-plus-circle text-success"></i> ' + data.text + ' <span class="new-tag-badge">✨ Kod Baru</span></span>');
                }
                return data.text;
            }
        });

        $('.select2-ruang, .select2-nama-ruang, .select2-ruang-binaan, .select2-nama-ruang-binaan').select2({
            theme: 'bootstrap-5',
            tags: true,
            placeholder: 'Pilih atau taip nilai baru',
            allowClear: true,
            createTag: function (params) {
                var term = $.trim(params.term);
                if (term === '') return null;
                return { id: term, text: term + ' (Baru)', newTag: true }
            }
        });
    }

    // ========================================
    // Toggle sections
    // ========================================
    $('#ada_blok').on('change', function() {
        $('#blok_section').slideToggle(300);
    });

    $('#ada_binaan_luar').on('change', function() {
        $('#binaan_section').slideToggle(300);
    });

    // ========================================
    // Check on page load (for existing data & validation errors)
    // ========================================
    if ($('#ada_blok').is(':checked')) {
        $('#blok_section').show();
        
        const kodBlokValue = $('#kod_blok').val();
        if (kodBlokValue) {
            checkKodBlok(kodBlokValue);
        }
        
        const kodArasValue = $('#kod_aras').val();
        if (kodArasValue) {
            checkKodAras(kodArasValue, 'blok');
        }
    }
    
    if ($('#ada_binaan_luar').is(':checked')) {
        $('#binaan_section').show();
        
        const kodArasBinaanValue = $('#kod_aras_binaan').val();
        if (kodArasBinaanValue) {
            checkKodAras(kodArasBinaanValue, 'binaan');
        }
    }

    // Filter on page load if premis is pre-selected
    const initialPremisId = $('#selectPremis').find(':selected').data('id');
    if (initialPremisId) {
        filterLocationOptions(initialPremisId);
    }
});
</script>
@endsection