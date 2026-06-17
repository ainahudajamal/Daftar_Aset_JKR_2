@extends('layouts.app')

@section('title', 'Edit Komponen Utama')

@section('styles')
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
    display: inline-block;
}
.existing-tag-badge {
    background: #3b82f6;
    color: white;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 0.75rem;
    margin-left: 5px;
    display: inline-block;
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
.fade-in {
    animation: fadeIn 0.3s ease-in;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">EDIT BORANG PENGUMPULAN DATA DAFTAR ASET KHUSUS</h5>
                <small>Peringkat Komponen Utama - {{ $mainComponent->nama_komponen_utama }}</small>
            </div>
            <div class="card-body">
                <form action="{{ route('main-components.update', $mainComponent) }}" method="POST" enctype="multipart/form-data" id="mainComponentForm">
                    @csrf
                    @method('PUT')

                    <!-- MAKLUMAT KOMPONEN UTAMA -->
                    <div class="card mb-4">
                        <div class="card-header bg-secondary text-white">
                            MAKLUMAT KOMPONEN UTAMA
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Nama Premis <span class="text-danger">*</span></label>
                                    <select class="form-select @error('component_id') is-invalid @enderror" name="component_id" id="component_id" required>
                                        <option value="">-- Pilih Komponen --</option>
                                        @foreach($components as $component)
                                            <option value="{{ $component->id }}" 
                                                data-dpa="{{ $component->nombor_dpa }}"
                                                {{ old('component_id', $mainComponent->component_id) == $component->id ? 'selected' : '' }}>
                                                {{ $component->nama_premis }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('component_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Nombor DPA</label>
                                    <input type="text" class="form-control bg-light" id="display_dpa" readonly 
                                           value="{{ $mainComponent->component->nombor_dpa ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Kod Lokasi <span class="text-danger">*</span></label>
                                    <input type="text" 
                                        class="form-control @error('kod_lokasi') is-invalid @enderror" 
                                        name="kod_lokasi" 
                                        id="kod_lokasi"
                                        value="{{ old('kod_lokasi', $mainComponent->kod_lokasi) }}" 
                                        required>
                                    @error('kod_lokasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="card mb-3" style="background: #f8f9fa;">
                                <div class="card-header bg-dark text-white">
                                    <strong>Maklumat Utama</strong>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Komponen Utama <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nama_komponen_utama') is-invalid @enderror" 
                                               name="nama_komponen_utama" value="{{ old('nama_komponen_utama', $mainComponent->nama_komponen_utama) }}" required>
                                        @error('nama_komponen_utama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>                   

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">
                                                Kod Sistem
                                                <span class="text-danger">*</span>
                                                <span id="kod-sistem-status" class="ms-2"></span>
                                            </label>
                                            <div class="input-group">
                                                <select class="form-select select2-sistem" name="sistem" id="sistem" required>
                                                    <option value="">-- Pilih atau Taip Kod Sistem --</option>
                                                    @foreach($sistems as $sistem)
                                                        <option value="{{ $sistem->kod }}" 
                                                            data-id="{{ $sistem->id }}"
                                                            data-nama="{{ $sistem->nama }}"
                                                            {{ old('sistem', $mainComponent->sistem) == $sistem->kod ? 'selected' : '' }}>
                                                            {{ $sistem->kod }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <label class="form-label">
                                                Kod SubSistem
                                                <span class="text-danger">*</span>
                                                <span id="kod-subsistem-status" class="ms-2"></span>
                                            </label>
                                            <div class="input-group">
                                                <select class="form-select select2-subsistem" name="subsistem" id="subsistem" required>
                                                    <option value="">-- Pilih atau Taip Kod SubSistem --</option>
                                                    @foreach($subsistems as $subsistem)
                                                        <option value="{{ $subsistem->kod }}" 
                                                            data-sistem-id="{{ $subsistem->sistem_id }}"
                                                            data-nama="{{ $subsistem->nama }}"
                                                            {{ old('subsistem', $mainComponent->subsistem) == $subsistem->kod ? 'selected' : '' }}>
                                                            {{ $subsistem->kod }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <label class="form-label">Kuantiti<span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" name="kuantiti" 
                                                value="{{ old('kuantiti', $mainComponent->kuantiti ?? 1) }}" min="1" required>
                                            <small class="form-text text-muted">(Komponen yang sama jenis)</small>
                                        </div>
                                    </div>

                                    <!-- Hidden row untuk Nama Sistem (auto-populated) -->
                                    <div class="row mb-3 fade-in" id="nama-sistem-row" style="display: none;">
                                        <div class="col-md-12">
                                            <div class="alert alert-info py-2 mb-2">
                                                <i class="bi bi-info-circle"></i> <strong>Kod Sistem Baru Dikesan!</strong> Sila masukkan nama untuk kod sistem ini.
                                            </div>
                                            <label class="form-label fw-bold">Nama Sistem <span class="text-danger">*</span></label>
                                            <div class="nama-field-wrapper">
                                                <input type="text" class="form-control" id="nama_sistem" name="nama_sistem" 
                                                    value="{{ old('nama_sistem', $mainComponent->nama_sistem ?? '') }}"
                                                    placeholder="Contoh: Sistem Penghawa Dingin dan Pengudaraan">
                                                <span class="autofill-indicator" id="autofill-indicator-sistem" style="display: none;">
                                                    <i class="bi bi-magic"></i> Cadangan Auto
                                                </span>
                                            </div>
                                            <small class="text-success" id="nama-sistem-hint"></small>
                                        </div>
                                    </div>

                                    <!-- Hidden row untuk Nama SubSistem (auto-populated) -->
                                    <div class="row mb-3 fade-in" id="nama-subsistem-row" style="display: none;">
                                        <div class="col-md-12">
                                            <div class="alert alert-info py-2 mb-2">
                                                <i class="bi bi-info-circle"></i> <strong>Kod SubSistem Baru Dikesan!</strong> Sila masukkan nama untuk kod subsistem ini.
                                            </div>
                                            <label class="form-label fw-bold">Nama SubSistem <span class="text-danger">*</span></label>
                                            <div class="nama-field-wrapper">
                                                <input type="text" class="form-control" id="nama_subsistem" name="nama_subsistem" 
                                                    value="{{ old('nama_subsistem', $mainComponent->nama_subsistem ?? '') }}"
                                                    placeholder="Contoh: Unit Pengendalian Udara">
                                                <span class="autofill-indicator" id="autofill-indicator-subsistem" style="display: none;">
                                                    <i class="bi bi-magic"></i> Cadangan Auto
                                                </span>
                                            </div>
                                            <small class="text-success" id="nama-subsistem-hint"></small>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">No. Perolehan (1GFMAS)<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="no_perolehan_1gfmas" 
                                                   value="{{ old('no_perolehan_1gfmas', $mainComponent->no_perolehan_1gfmas) }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Bidang Kejuruteraan — Dynamic dari Pendaftaran Kod Bidang -->
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <strong>Bidang Kejuruteraan Komponen: <span class="text-danger">*</span></strong>
                                </div>
                                <div class="card-body">
                                    @if($bidangs->isEmpty())
                                        <div class="alert alert-warning mb-0">
                                            <i class="bi bi-exclamation-triangle"></i>
                                            Tiada bidang kejuruteraan didaftarkan. Sila tambah bidang dalam
                                            <a href="{{ route('admin.bidang.create') }}" target="_blank">Pendaftaran Kod Bidang</a>.
                                        </div>
                                    @else
                                        <div class="row">
                                            @foreach($bidangs as $bidang)
                                                <div class="col-md-4 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                               name="bidang_id"
                                                               id="bidang_{{ $bidang->id }}"
                                                               value="{{ $bidang->id }}"
                                                               {{ old('bidang_id', $mainComponent->bidang_id) == $bidang->id ? 'checked' : '' }}
                                                               required>
                                                        <label class="form-check-label" for="bidang_{{ $bidang->id }}">
                                                            <span class="badge bg-secondary me-1">{{ $bidang->kod }}</span>
                                                            {{ $bidang->nama }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @error('bidang_id')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Catatan:</label>
                                <textarea class="form-control" name="catatan" rows="2">{{ old('catatan', $mainComponent->catatan) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- MAKLUMAT PEROLEHAN -->
                    <div class="card mb-4">
                        <div class="card-header bg-dark text-white">
                            MAKLUMAT PEROLEHAN
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td width="50%">Tarikh Perolehan</td>
                                            <td><input type="date" class="form-control form-control-sm" name="tarikh_perolehan" 
                                                value="{{ old('tarikh_perolehan', $mainComponent->tarikh_perolehan ? \Carbon\Carbon::parse($mainComponent->tarikh_perolehan)->format('Y-m-d') : '') }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Kos Perolehan/Kontrak (RM)</td>
                                            <td><input type="text" class="form-control form-control-sm" name="kos_perolehan" value="{{ old('kos_perolehan', $mainComponent->kos_perolehan) }}" placeholder="contoh: 20000.00"></td>
                                        </tr>
                                        <tr>
                                            <td>No. Pesanan Rasmi Kerajaan/Kontrak</td>
                                            <td><input type="text" class="form-control form-control-sm" name="no_pesanan_rasmi_kontrak" value="{{ old('no_pesanan_rasmi_kontrak', $mainComponent->no_pesanan_rasmi_kontrak) }}"></td>
                                        </tr>
                                        <tr>
                                            <td>Kod PTJ</td>
                                            <td><input type="text" class="form-control form-control-sm" name="kod_ptj" value="{{ old('kod_ptj', $mainComponent->kod_ptj) }}"></td> 
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td width="50%">Tarikh Dipasang</td>
                                            <td><input type="date" class="form-control form-control-sm" name="tarikh_dipasang" 
                                                value="{{ old('tarikh_dipasang', $mainComponent->tarikh_dipasang ? \Carbon\Carbon::parse($mainComponent->tarikh_dipasang)->format('Y-m-d') : '') }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tarikh Waranti Tamat</td>
                                            <td><input type="date" class="form-control form-control-sm" name="tarikh_waranti_tamat" 
                                                value="{{ old('tarikh_waranti_tamat', $mainComponent->tarikh_waranti_tamat ? \Carbon\Carbon::parse($mainComponent->tarikh_waranti_tamat)->format('Y-m-d') : '') }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tarikh Tamat DLP</td>
                                            <td><input type="date" class="form-control form-control-sm" name="tarikh_tamat_dlp" 
                                                value="{{ old('tarikh_tamat_dlp', $mainComponent->tarikh_tamat_dlp ? \Carbon\Carbon::parse($mainComponent->tarikh_tamat_dlp)->format('Y-m-d') : '') }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Jangka Hayat</td>
                                            <td><input type="text" class="form-control form-control-sm" name="jangka_hayat" value="{{ old('jangka_hayat', $mainComponent->jangka_hayat) }}" placeholder="Tahun"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Pengilang, Pembekal, Kontraktor -->
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <h6 class="fw-bold">Pengilang</h6>
                                    <div class="mb-2">
                                        <label class="form-label small">Nama: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" name="nama_pengilang" value="{{ old('nama_pengilang', $mainComponent->nama_pengilang) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="fw-bold">Pembekal</h6>
                                    <div class="mb-2">
                                        <label class="form-label small">Nama:<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" name="nama_pembekal" value="{{ old('nama_pembekal', $mainComponent->nama_pembekal) }}" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small">Alamat:<span class="text-danger">*</span></label>
                                        <textarea class="form-control form-control-sm" name="alamat_pembekal" rows="2" required>{{ old('alamat_pembekal', $mainComponent->alamat_pembekal) }}</textarea>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small">No. Telefon:<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" name="no_telefon_pembekal" value="{{ old('no_telefon_pembekal', $mainComponent->no_telefon_pembekal) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="fw-bold">Kontraktor</h6>
                                    <div class="mb-2">
                                        <label class="form-label small">Nama:<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" name="nama_kontraktor" value="{{ old('nama_kontraktor', $mainComponent->nama_kontraktor) }}" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small">Alamat:<span class="text-danger">*</span></label>
                                        <textarea class="form-control form-control-sm" name="alamat_kontraktor" rows="2" required>{{ old('alamat_kontraktor', $mainComponent->alamat_kontraktor) }}</textarea>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small">No. Telefon:<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" name="no_telefon_kontraktor" value="{{ old('no_telefon_kontraktor', $mainComponent->no_telefon_kontraktor) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <label class="form-label">Catatan:</label>
                                <textarea class="form-control" name="catatan_maklumat" rows="2">{{ old('catatan_maklumat', $mainComponent->catatan_maklumat) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- MAKLUMAT KOMPONEN -->
                    <div class="card mb-4">
                        <div class="card-header bg-dark text-white">
                            MAKLUMAT KOMPONEN
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Deskripsi<span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="deskripsi" rows="3" required>{{ old('deskripsi', $mainComponent->deskripsi) }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label">Status Komponen</label>
                                        <select class="form-select" name="status_komponen">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="operational" {{ old('status_komponen', $mainComponent->status_komponen) == 'operational' ? 'selected' : '' }}>Beroperasi</option>
                                            <option value="under_maintenance" {{ old('status_komponen', $mainComponent->status_komponen) == 'under_maintenance' ? 'selected' : '' }}>Sedang Diselenggara</option>
                                            <option value="rosak" {{ old('status_komponen', $mainComponent->status_komponen) == 'rosak' ? 'selected' : '' }}>Rosak</option>
                                            <option value="retired" {{ old('status_komponen', $mainComponent->status_komponen) == 'retired' ? 'selected' : '' }}>Dilupuskan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Jenama<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="jenama" value="{{ old('jenama', $mainComponent->jenama) }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Model<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="model" value="{{ old('model', $mainComponent->model) }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">No. Siri<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="no_siri" value="{{ old('no_siri', $mainComponent->no_siri) }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">No. Tag / Label (Jika berkenaan)</label>
                                    <input type="text" class="form-control" name="no_tag_label" value="{{ old('no_tag_label', $mainComponent->no_tag_label) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No Sijil Pendaftaran (Jika ada)</label>
                                    <input type="text" class="form-control" name="no_sijil_pendaftaran" value="{{ old('no_sijil_pendaftaran', $mainComponent->no_sijil_pendaftaran) }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Button to show attributes section -->
                    <div class="d-flex justify-content-between" id="mainButtons">
                        <a href="{{ route('components.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="button" class="btn btn-info text-white" onclick="showAttributesSection()">
                            Seterusnya: Atribut Spesifikasi <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>

                    <!-- Hidden section for attributes -->
                    <div id="attributesSection" style="display: none; margin-top: 20px;">
                        @include('user.components.partials.main-component-attributes')
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
function showAttributesSection() {
    document.getElementById('attributesSection').style.display = 'block';
    document.getElementById('mainButtons').style.display = 'none';
    document.getElementById('attributesSection').scrollIntoView({ behavior: 'smooth', block: 'start' });
}
</script>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // ===========================
    // CSRF Token untuk AJAX - ENHANCED
    // ===========================
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    
    if (!csrfToken) {
        console.error('CRITICAL: CSRF token not found in meta tag!');
        console.error('Please add this to your <head> section:');
        console.error('<meta name="csrf-token" content="{{ csrf_token() }}">');
    } else {
        console.log('✓ CSRF Token found:', csrfToken.substring(0, 10) + '...');
    }
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });

    // ===========================
    // DEBUG: Check if everything is loaded properly
    // ===========================
    console.log('=== SYSTEM CHECK ===');
    console.log('jQuery loaded:', typeof $ !== 'undefined');
    console.log('CSRF Token:', csrfToken ? '✓ Present' : '✗ MISSING');
    console.log('Base URL:', window.location.origin);
    console.log('API URL (Sistem):', window.location.origin + '/api/check-kod-sistem');
    console.log('API URL (SubSistem):', window.location.origin + '/api/check-kod-subsistem');

    // ===========================
    // IMPORTANT: Store current values BEFORE initializing Select2
    // ===========================
    var currentSistemValue = $('#sistem').val();
    var currentSubSistemValue = $('#subsistem').val();
    
    console.log('Current Sistem Value:', currentSistemValue);
    console.log('Current SubSistem Value:', currentSubSistemValue);

    // ===========================
    // Initialize Select2 untuk Sistem dengan Tags
    // ===========================
    $('.select2-sistem').select2({
        theme: 'bootstrap-5',
        tags: true,
        placeholder: 'Pilih atau taip kod baru',
        allowClear: true,
        createTag: function(params) {
            var term = $.trim(params.term);
            if (term === '') return null;
            
            return {
                id: term,
                text: term,
                newTag: true
            }
        },
        templateResult: function(data) {
            if (data.newTag) {
                return $('<span><i class="bi bi-plus-circle text-success"></i> ' + data.text + ' <span class="new-tag-badge">✨ Kod Baru</span></span>');
            }
            return data.text;
        }
    });

    // ===========================
    // RESTORE the value after Select2 initialization
    // ===========================
    if (currentSistemValue) {
        // Check if the value exists in options
        var optionExists = $('#sistem option[value="' + currentSistemValue + '"]').length > 0;
        
        if (!optionExists) {
            // Add it as a new option
            var newOption = new Option(currentSistemValue, currentSistemValue, true, true);
            $('#sistem').append(newOption);
            console.log('Added missing Sistem option:', currentSistemValue);
        }
        
        // Set the value
        $('#sistem').val(currentSistemValue).trigger('change');
        console.log('Restored Sistem value:', currentSistemValue);
    }

    // ===========================
    // Initialize Select2 untuk SubSistem dengan Tags
    // ===========================
    $('.select2-subsistem').select2({
        theme: 'bootstrap-5',
        tags: true,
        placeholder: 'Pilih atau taip kod baru',
        allowClear: true,
        createTag: function(params) {
            var term = $.trim(params.term);
            if (term === '') return null;
            
            return {
                id: term,
                text: term,
                newTag: true
            }
        },
        templateResult: function(data) {
            if (data.newTag) {
                return $('<span><i class="bi bi-plus-circle text-success"></i> ' + data.text + ' <span class="new-tag-badge">✨ Kod Baru</span></span>');
            }
            return data.text;
        }
    });

    // ===========================
    // RESTORE SubSistem value after Select2 initialization
    // ===========================
    if (currentSubSistemValue) {
        // Check if the value exists in options
        var optionExists = $('#subsistem option[value="' + currentSubSistemValue + '"]').length > 0;
        
        if (!optionExists) {
            // Add it as a new option
            var newOption = new Option(currentSubSistemValue, currentSubSistemValue, true, true);
            $('#subsistem').append(newOption);
            console.log('Added missing SubSistem option:', currentSubSistemValue);
        }
        
        // Set the value
        $('#subsistem').val(currentSubSistemValue).trigger('change');
        console.log('Restored SubSistem value:', currentSubSistemValue);
    }

    // ===========================
    // AUTOFILL MAGIC - Sistem
    // ===========================
    let typingTimerSistem;
    const doneTypingInterval = 500;

    $('#sistem').on('select2:select select2:unselect change', function(e) {
        clearTimeout(typingTimerSistem);
        
        const kodValue = $(this).val();
        
        if (!kodValue) {
            $('#nama-sistem-row').slideUp(300);
            $('#kod-sistem-status').html('');
            return;
        }

        typingTimerSistem = setTimeout(function() {
            checkKodSistem(kodValue);
        }, doneTypingInterval);
    });

    function checkKodSistem(kod) {
        if (!kod) return;

        console.log('Checking Kod Sistem:', kod);
        $('#kod-sistem-status').html('<span class="badge bg-secondary"><i class="bi bi-hourglass-split"></i> Menyemak...</span>');

        $.ajax({
            url: '/api/check-kod-sistem',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            },
            data: { 
                kod: kod,
                _token: csrfToken
            },
            success: function(response) {
                console.log('API Response for Sistem:', response);
                
                if (response.exists) {
                    $('#kod-sistem-status').html('<span class="existing-tag-badge"><i class="bi bi-check-circle"></i> Sedia Ada</span>');
                    $('#nama-sistem-row').slideUp(300);
                    $('#nama_sistem').val(response.data.nama);
                    console.log('Sistem exists:', response.data.nama);
                } else {
                    $('#kod-sistem-status').html('<span class="new-tag-badge"><i class="bi bi-sparkles"></i> Kod Baru</span>');
                    $('#nama_sistem').val(response.suggestion).prop('readonly', false).removeClass('bg-light');
                    $('#nama-sistem-hint').text('💡 ' + response.suggestion + ' (Anda boleh edit)');
                    $('#autofill-indicator-sistem').show();
                    $('#nama-sistem-row').slideDown(300);
                    console.log('Sistem is new, suggestion:', response.suggestion);
                }
            },
            error: function(xhr, status, error) {
                console.error('=== AJAX ERROR FOR SISTEM ===');
                console.error('Status:', status);
                console.error('Error:', error);
                console.error('Status Code:', xhr.status);
                console.error('Response Text:', xhr.responseText);
                
                $('#kod-sistem-status').html('<span class="badge bg-danger"><i class="bi bi-x-circle"></i> Ralat ' + xhr.status + '</span>');
                $('#nama_sistem').val('Sistem ' + kod).prop('readonly', false).removeClass('bg-light');
                $('#nama-sistem-hint').html('<span class="text-warning">⚠️ Tidak dapat menyemak database (Error ' + xhr.status + '). Sila masukkan nama sistem.</span>');
                $('#autofill-indicator-sistem').hide();
                $('#nama-sistem-row').slideDown(300);
            }
        });
    }

    $('#nama_sistem').on('focus', function() {
        $(this).prop('readonly', false);
        $('#autofill-indicator-sistem').fadeOut();
    });

    $('#nama_sistem').on('input', function() {
        if ($(this).val() !== '') {
            $('#autofill-indicator-sistem').hide();
        }
    });

    // ===========================
    // AUTOFILL MAGIC - SubSistem
    // ===========================
    let typingTimerSubSistem;

    $('#subsistem').on('select2:select select2:unselect change', function(e) {
        clearTimeout(typingTimerSubSistem);
        
        const kodValue = $(this).val();
        
        if (!kodValue) {
            $('#nama-subsistem-row').slideUp(300);
            $('#kod-subsistem-status').html('');
            return;
        }

        typingTimerSubSistem = setTimeout(function() {
            checkKodSubSistem(kodValue);
        }, doneTypingInterval);
    });

    function checkKodSubSistem(kod) {
        if (!kod) return;

        console.log('Checking Kod SubSistem:', kod);
        var sistemId = $('#sistem').find(':selected').data('id') || null;
        console.log('Selected Sistem ID:', sistemId);

        $('#kod-subsistem-status').html('<span class="badge bg-secondary"><i class="bi bi-hourglass-split"></i> Menyemak...</span>');

        $.ajax({
            url: '/api/check-kod-subsistem',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
            },
            data: { 
                kod: kod,
                sistem_id: sistemId,
                _token: csrfToken
            },
            success: function(response) {
                console.log('API Response for SubSistem:', response);
                
                if (response.exists) {
                    $('#kod-subsistem-status').html('<span class="existing-tag-badge"><i class="bi bi-check-circle"></i> Sedia Ada</span>');
                    $('#nama-subsistem-row').slideUp(300);
                    $('#nama_subsistem').val(response.data.nama);
                    console.log('SubSistem exists:', response.data.nama);
                } else {
                    $('#kod-subsistem-status').html('<span class="new-tag-badge"><i class="bi bi-sparkles"></i> Kod Baru</span>');
                    $('#nama_subsistem').val(response.suggestion).prop('readonly', false).removeClass('bg-light');
                    var hintText = '💡 ' + response.suggestion + ' (Anda boleh edit)';
                    $('#nama-subsistem-hint').text(hintText);
                    $('#autofill-indicator-subsistem').show();
                    $('#nama-subsistem-row').slideDown(300);
                    console.log('SubSistem is new, suggestion:', response.suggestion);
                }
            },
            error: function(xhr, status, error) {
                console.error('=== AJAX ERROR FOR SUBSISTEM ===');
                console.error('Status:', status);
                console.error('Error:', error);
                console.error('Status Code:', xhr.status);
                console.error('Response Text:', xhr.responseText);
                
                $('#kod-subsistem-status').html('<span class="badge bg-danger"><i class="bi bi-x-circle"></i> Ralat ' + xhr.status + '</span>');
                $('#nama_subsistem').val('SubSistem ' + kod).prop('readonly', false).removeClass('bg-light');
                $('#nama-subsistem-hint').html('<span class="text-warning">⚠️ Tidak dapat menyemak database (Error ' + xhr.status + '). Sila masukkan nama subsistem.</span>');
                $('#autofill-indicator-subsistem').hide();
                $('#nama-subsistem-row').slideDown(300);
            }
        });
    }

    $('#nama_subsistem').on('focus', function() {
        $(this).prop('readonly', false);
        $('#autofill-indicator-subsistem').fadeOut();
    });

    $('#nama_subsistem').on('input', function() {
        if ($(this).val() !== '') {
            $('#autofill-indicator-subsistem').hide();
        }
    });

    // ===========================
    // Filter SubSistem berdasarkan Sistem yang dipilih - ENHANCED
    // ===========================
    function filterSubSistemOptions() {
        var sistemId = $('#sistem').find(':selected').data('id');
        var $subsistem = $('#subsistem');
        var currentSubSistemValue = $subsistem.val();
        
        console.log('Filtering SubSistem for Sistem ID:', sistemId);
        console.log('Current SubSistem value:', currentSubSistemValue);
        
        // Destroy Select2 temporarily
        if ($subsistem.data('select2')) {
            $subsistem.select2('destroy');
        }
        
        if (sistemId) {
            // Show only related subsistems
            var hasVisibleOptions = false;
            $subsistem.find('option').each(function() {
                if ($(this).val() === '') {
                    // Always show the placeholder
                    $(this).prop('disabled', false).show();
                    return;
                }
                
                var optionSistemId = $(this).data('sistem-id');
                console.log('Option:', $(this).val(), 'Sistem ID:', optionSistemId);
                
                if (optionSistemId && optionSistemId == sistemId) {
                    $(this).prop('disabled', false).show();
                    hasVisibleOptions = true;
                } else {
                    $(this).prop('disabled', true).hide();
                }
            });
            
            // If current value is not in the filtered list, clear it
            var currentOption = $subsistem.find('option[value="' + currentSubSistemValue + '"]');
            var currentOptionSistemId = currentOption.data('sistem-id');
            
            if (currentSubSistemValue && currentOptionSistemId != sistemId) {
                console.log('Current SubSistem does not match selected Sistem, clearing...');
                $subsistem.val('');
                $('#kod-subsistem-status').html('');
                $('#nama-subsistem-row').slideUp(300);
            }
            
            if (!hasVisibleOptions) {
                console.log('No subsistems found for this sistem');
            }
        } else {
            // No sistem selected, show all options
            console.log('No Sistem selected, showing all SubSistem options');
            $subsistem.find('option').prop('disabled', false).show();
        }
        
        // Reinitialize Select2 with filtered options
        $subsistem.select2({
            theme: 'bootstrap-5',
            tags: true,
            placeholder: 'Pilih atau taip kod baru',
            allowClear: true,
            createTag: function(params) {
                var term = $.trim(params.term);
                if (term === '') return null;
                
                return {
                    id: term,
                    text: term,
                    newTag: true
                }
            },
            templateResult: function(data) {
                if (data.newTag) {
                    return $('<span><i class="bi bi-plus-circle text-success"></i> ' + data.text + ' <span class="new-tag-badge">✨ Kod Baru</span></span>');
                }
                return data.text;
            }
        });
        
        // Restore value if it's still valid
        if (currentSubSistemValue) {
            var isStillValid = $subsistem.find('option[value="' + currentSubSistemValue + '"]:not(:disabled)').length > 0;
            if (isStillValid) {
                $subsistem.val(currentSubSistemValue).trigger('change.select2');
                console.log('Restored SubSistem value:', currentSubSistemValue);
            }
        }
    }
    
    // Trigger filter on Sistem change
    $('#sistem').on('change', function() {
        filterSubSistemOptions();
    });

    // ===========================
    // Auto-fill DPA
    // ===========================
    $('#component_id').on('change', function() {
        var $selected = $(this).find(':selected');
        $('#display_dpa').val($selected.data('dpa') || '');
    });
    
    if ($('#component_id').val()) {
        $('#component_id').trigger('change');
    }

    // ===========================
    // FORMAT KOS PEROLEHAN
    // ===========================
    var kosInput = $('input[name="kos_perolehan"]');
    
    var initialValue = kosInput.val();
    if (initialValue) {
        var cleanValue = initialValue.replace(/RM\s*/g, '').replace(/,/g, '').trim();
        var number = parseFloat(cleanValue);
        
        if (!isNaN(number)) {
            var formatted = number.toLocaleString('en-MY', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            kosInput.val(formatted);
        }
    }

    kosInput.on('input', function() {
        let value = $(this).val();
        value = value.replace(/[^0-9.]/g, '');
        const parts = value.split('.');
        if (parts.length > 2) {
            value = parts[0] + '.' + parts.slice(1).join('');
        }
        $(this).val(value);
    });

    kosInput.on('blur', function() {
        let value = $(this).val();
        if (value) {
            value = value.replace(/RM\s*/g, '').trim();
            let number = parseFloat(value);
            if (!isNaN(number)) {
                let formatted = number.toLocaleString('en-MY', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                $(this).val(formatted);
            }
        }
    });

    kosInput.on('focus', function() {
        let value = $(this).val();
        if (value) {
            value = value.replace(/,/g, '');
            $(this).val(value);
        }
    });

    $('#mainComponentForm').on('submit', function(e) {
        let kosInput = $('input[name="kos_perolehan"]');
        let value = kosInput.val();
        if (value) {
            value = value.replace(/RM\s*/g, '').replace(/,/g, '');
            let number = parseFloat(value);
            if (!isNaN(number)) {
                kosInput.val('RM' + number.toFixed(2));
            }
        }
    });

    // ===========================
    // Check on page load for current values
    // ===========================
    if (currentSistemValue) {
        checkKodSistem(currentSistemValue);
    }

    if (currentSubSistemValue) {
        checkKodSubSistem(currentSubSistemValue);
    }

    // ===========================
    // Initial filter on page load
    // ===========================
    if ($('#sistem').val()) {
        filterSubSistemOptions();
    }
});
</script>
@endsection