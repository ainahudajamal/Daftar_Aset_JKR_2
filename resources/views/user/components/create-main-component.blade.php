@extends('layouts.app')

@section('title', 'Borang 2: Komponen Utama')

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
.status-checking {
    color: #6b7280;
    font-size: 0.875rem;
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
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">BORANG PENGUMPULAN DATA DAFTAR ASET KHUSUS</h5>
                <small>Peringkat Komponen Utama</small>
            </div>
            <div class="card-body">
                <form action="{{ route('main-components.store') }}" method="POST" enctype="multipart/form-data" id="mainComponentForm">
                    @csrf

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
                                                data-nama="{{ $component->nama_premis }}"
                                                {{ old('component_id') == $component->id ? 'selected' : '' }}>
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
                                    <input type="text" class="form-control bg-light" id="display_dpa" readonly placeholder="Auto-fill dari komponen">
                                    <small class="text-muted">Auto-fill berdasarkan komponen dipilih</small>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Kod Lokasi <span class="text-danger">*</span></label>
                                    <input type="text" 
                                    class="form-control @error('kod_lokasi') is-invalid @enderror" 
                                    name="kod_lokasi" 
                                    id="kod_lokasi"
                                    value="{{ old('kod_lokasi') }}" 
                                    placeholder="Contoh: KU-01-123"
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
                                               name="nama_komponen_utama" value="{{ old('nama_komponen_utama') }}" required>
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
                                                            {{ old('sistem') == $sistem->kod ? 'selected' : '' }}>
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
                                                            {{ old('subsistem') == $subsistem->kod ? 'selected' : '' }}>
                                                            {{ $subsistem->kod }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <label class="form-label">Kuantiti<span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" name="kuantiti" value="{{ old('kuantiti', 1) }}" min="1" required>
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
                                                    value="{{ old('nama_sistem') }}"
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
                                                    value="{{ old('nama_subsistem') }}"
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
                                            <input type="text" class="form-control" name="no_perolehan_1gfmas" value="{{ old('no_perolehan_1gfmas') }}" required>
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
                                                               {{ old('bidang_id') == $bidang->id ? 'checked' : '' }}
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
                                <textarea class="form-control" name="catatan" rows="2">{{ old('catatan') }}</textarea>
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
                                            <td><input type="date" class="form-control form-control-sm" name="tarikh_perolehan" value="{{ old('tarikh_perolehan') }}"></td>
                                        </tr>
                                        <tr>
                                            <td>Kos Perolehan/Kontrak (RM)</td>
                                            <td><input type="text" class="form-control form-control-sm" name="kos_perolehan" value="{{ old('kos_perolehan') }}" placeholder="contoh: 20000.00"></td>
                                        </tr>
                                        <tr>
                                            <td>No. Pesanan Rasmi Kerajaan/Kontrak</td>
                                            <td><input type="text" class="form-control form-control-sm" name="no_pesanan_rasmi_kontrak" value="{{ old('no_pesanan_rasmi_kontrak') }}"></td>
                                        </tr>
                                        <tr>
                                            <td>Kod PTJ</td>
                                            <td><input type="text" class="form-control form-control-sm" name="kod_ptj" value="{{ old('kod_ptj') }}"></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td width="50%">Tarikh Dipasang</td>
                                            <td><input type="date" class="form-control form-control-sm" name="tarikh_dipasang" value="{{ old('tarikh_dipasang') }}"></td>
                                        </tr>
                                        <tr>
                                            <td>Tarikh Waranti Tamat</td>
                                            <td><input type="date" class="form-control form-control-sm" name="tarikh_waranti_tamat" value="{{ old('tarikh_waranti_tamat') }}"></td>
                                        </tr>
                                        <tr>
                                            <td>Tarikh Tamat DLP</td>
                                            <td><input type="date" class="form-control form-control-sm" name="tarikh_tamat_dlp" value="{{ old('tarikh_tamat_dlp') }}"></td>
                                        </tr>
                                        <tr>
                                            <td>Jangka Hayat</td>
                                            <td><input type="text" class="form-control form-control-sm" name="jangka_hayat" value="{{ old('jangka_hayat') }}" placeholder="Tahun"></td>
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
                                        <input type="text" class="form-control form-control-sm" name="nama_pengilang" value="{{ old('nama_pengilang') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="fw-bold">Pembekal</h6>
                                    <div class="mb-2">
                                        <label class="form-label small">Nama:<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" name="nama_pembekal" value="{{ old('nama_pembekal') }}" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small">Alamat:<span class="text-danger">*</span></label>
                                        <textarea class="form-control form-control-sm" name="alamat_pembekal" rows="2" required>{{ old('alamat_pembekal') }}</textarea>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small">No. Telefon:<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" name="no_telefon_pembekal" value="{{ old('no_telefon_pembekal') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="fw-bold">Kontraktor</h6>
                                    <div class="mb-2">
                                        <label class="form-label small">Nama:<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" name="nama_kontraktor" value="{{ old('nama_kontraktor') }}" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small">Alamat:<span class="text-danger">*</span></label>
                                        <textarea class="form-control form-control-sm" name="alamat_kontraktor" rows="2" required>{{ old('alamat_kontraktor') }}</textarea>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small">No. Telefon:<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm" name="no_telefon_kontraktor" value="{{ old('no_telefon_kontraktor') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <label class="form-label">Catatan:</label>
                                <textarea class="form-control" name="catatan_maklumat" rows="2">{{ old('catatan_maklumat') }}</textarea>
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
                                    <textarea class="form-control" name="deskripsi" rows="3" required>{{ old('deskripsi') }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label">Status Komponen</label>
                                        <select class="form-select" name="status_komponen">
                                            <option value="">-- Pilih Status --</option>
                                            <option value="operational" {{ old('status_komponen') == 'operational' ? 'selected' : '' }}>Beroperasi</option>
                                            <option value="under_maintenance" {{ old('status_komponen') == 'under_maintenance' ? 'selected' : '' }}>Sedang Diselenggara</option>
                                            <option value="rosak" {{ old('status_komponen') == 'rosak' ? 'selected' : '' }}>Rosak</option>
                                            <option value="retired" {{ old('status_komponen') == 'retired' ? 'selected' : '' }}>Dilupuskan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Jenama<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="jenama" value="{{ old('jenama') }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Model<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="model" value="{{ old('model') }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">No. Siri<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="no_siri" value="{{ old('no_siri') }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">No. Tag / Label (Jika berkenaan)</label>
                                    <input type="text" class="form-control" name="no_tag_label" value="{{ old('no_tag_label') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No Sijil Pendaftaran (Jika ada)</label>
                                    <input type="text" class="form-control" name="no_sijil_pendaftaran" value="{{ old('no_sijil_pendaftaran') }}">
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
    // CSRF Token untuk AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Store original subsistem options
    let allSubsistemOptions = [];
    
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

    // Store all subsistem options on page load
    $('#subsistem option').each(function() {
        if ($(this).val() !== '') {
            allSubsistemOptions.push({
                value: $(this).val(),
                text: $(this).text(),
                sistemId: $(this).data('sistem-id'),
                nama: $(this).data('nama')
            });
        }
    });

    // ===========================
    // AUTOFILL MAGIC - Sistem
    // ===========================
    let typingTimerSistem;
    const doneTypingInterval = 500;

    $('#sistem').on('select2:select select2:unselect change', function(e) {
        clearTimeout(typingTimerSistem);
        
        const kodValue = $(this).val();
        const sistemId = $(this).find(':selected').data('id');
        
        if (!kodValue) {
            $('#nama-sistem-row').slideUp(300);
            $('#kod-sistem-status').html('');
            // Reset subsistem to show all when no sistem selected
            resetSubsistemOptions();
            return;
        }

        // Filter subsistem based on selected sistem
        if (sistemId) {
            filterSubsistemOptions(sistemId);
        } else {
            // If new sistem (no ID), show all subsistem for now
            resetSubsistemOptions();
        }

        typingTimerSistem = setTimeout(function() {
            checkKodSistem(kodValue);
        }, doneTypingInterval);
    });

    function checkKodSistem(kod) {
        if (!kod) return;

        $('#kod-sistem-status').html('<span class="badge bg-secondary"><i class="bi bi-hourglass-split"></i> Menyemak...</span>');

        $.ajax({
            url: '/api/check-kod-sistem',
            method: 'POST',
            data: { kod: kod },
            success: function(response) {
                if (response.exists) {
                    $('#kod-sistem-status').html('<span class="existing-tag-badge"><i class="bi bi-check-circle"></i> Sedia Ada</span>');
                    $('#nama-sistem-row').slideUp(300);
                    $('#nama_sistem').val(response.data.nama);
                    
                    // Filter subsistem based on the existing sistem
                    if (response.data.id) {
                        filterSubsistemOptions(response.data.id);
                    }
                } else {
                    $('#kod-sistem-status').html('<span class="new-tag-badge"><i class="bi bi-sparkles"></i> Kod Baru</span>');
                    $('#nama_sistem').val(response.suggestion).prop('readonly', false).removeClass('bg-light');
                    $('#nama-sistem-hint').text('💡 ' + response.suggestion + ' (Anda boleh edit)');
                    $('#autofill-indicator-sistem').show();
                    $('#nama-sistem-row').slideDown(300);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error checking kod sistem:', error);
                $('#kod-sistem-status').html('<span class="badge bg-danger"><i class="bi bi-x-circle"></i> Ralat</span>');
                $('#nama_sistem').val('Sistem ' + kod).prop('readonly', false).removeClass('bg-light');
                $('#nama-sistem-hint').html('<span class="text-warning">⚠️ Tidak dapat menyemak database. Sila masukkan nama sistem.</span>');
                $('#autofill-indicator-sistem').hide();
                $('#nama-sistem-row').slideDown(300);
            }
        });
    }

    // ===========================
    // FILTER SUBSISTEM FUNCTIONS
    // ===========================
    function filterSubsistemOptions(sistemId) {
        const $subsistem = $('#subsistem');
        const currentValue = $subsistem.val();
        
        // Clear current selection if it doesn't match the new sistem
        const currentOption = allSubsistemOptions.find(opt => opt.value === currentValue);
        if (currentOption && currentOption.sistemId != sistemId) {
            $subsistem.val('').trigger('change');
            $('#nama-subsistem-row').slideUp(300);
            $('#kod-subsistem-status').html('');
        }
        
        // Remove all options except the placeholder
        $subsistem.find('option:not([value=""])').remove();
        
        // Add only matching subsistem options
        const filteredOptions = allSubsistemOptions.filter(opt => opt.sistemId == sistemId);
        
        if (filteredOptions.length > 0) {
            filteredOptions.forEach(function(opt) {
                const newOption = new Option(opt.text, opt.value, false, false);
                $(newOption).data('sistem-id', opt.sistemId);
                $(newOption).data('nama', opt.nama);
                $subsistem.append(newOption);
            });
            
            $subsistem.prop('disabled', false);
            $subsistem.next('.select2-container').find('.select2-selection').removeClass('bg-light');
        } else {
            $subsistem.prop('disabled', false); // Still allow manual entry
            $subsistem.next('.select2-container').find('.select2-selection').removeClass('bg-light');
        }
        
        // Refresh Select2
        $subsistem.trigger('change.select2');
    }

    function resetSubsistemOptions() {
        const $subsistem = $('#subsistem');
        
        // Clear and reset
        $subsistem.val('').trigger('change');
        $subsistem.find('option:not([value=""])').remove();
        
        $subsistem.prop('disabled', true);
        $subsistem.next('.select2-container').find('.select2-selection').addClass('bg-light');
        $subsistem.trigger('change.select2');
        
        $('#nama-subsistem-row').slideUp(300);
        $('#kod-subsistem-status').html('');
    }

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

        var sistemId = $('#sistem').find(':selected').data('id') || null;

        $('#kod-subsistem-status').html('<span class="badge bg-secondary"><i class="bi bi-hourglass-split"></i> Menyemak...</span>');

        $.ajax({
            url: '/api/check-kod-subsistem',
            method: 'POST',
            data: { 
                kod: kod,
                sistem_id: sistemId
            },
            success: function(response) {
                if (response.exists) {
                    $('#kod-subsistem-status').html('<span class="existing-tag-badge"><i class="bi bi-check-circle"></i> Sedia Ada</span>');
                    $('#nama-subsistem-row').slideUp(300);
                    $('#nama_subsistem').val(response.data.nama);
                } else {
                    $('#kod-subsistem-status').html('<span class="new-tag-badge"><i class="bi bi-sparkles"></i> Kod Baru</span>');
                    $('#nama_subsistem').val(response.suggestion).prop('readonly', false).removeClass('bg-light');
                    
                    var hintText = '💡 ' + response.suggestion + ' (Anda boleh edit)';
                    $('#nama-subsistem-hint').text(hintText);
                    $('#autofill-indicator-subsistem').show();
                    $('#nama-subsistem-row').slideDown(300);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error checking kod subsistem:', error);
                $('#kod-subsistem-status').html('<span class="badge bg-danger"><i class="bi bi-x-circle"></i> Ralat</span>');
                $('#nama_subsistem').val('SubSistem ' + kod).prop('readonly', false).removeClass('bg-light');
                $('#nama-subsistem-hint').html('<span class="text-warning">⚠️ Tidak dapat menyemak database. Sila masukkan nama subsistem.</span>');
                $('#autofill-indicator-subsistem').hide();
                $('#nama-subsistem-row').slideDown(300);
            }
        });
    }

    // Allow user to edit auto-filled names
    $('#nama_sistem').on('focus', function() {
        $(this).prop('readonly', false);
        $('#autofill-indicator-sistem').fadeOut();
    });

    $('#nama_sistem').on('input', function() {
        if ($(this).val() !== '') {
            $('#autofill-indicator-sistem').hide();
        }
    });

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
    // Auto-fill DPA sahaja
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
    $('input[name="kos_perolehan"]').on('input', function() {
        let value = $(this).val();
        value = value.replace(/[^0-9.]/g, '');
        const parts = value.split('.');
        if (parts.length > 2) {
            value = parts[0] + '.' + parts.slice(1).join('');
        }
        $(this).val(value);
    });

    $('input[name="kos_perolehan"]').on('blur', function() {
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

    $('input[name="kos_perolehan"]').on('focus', function() {
        let value = $(this).val();
        if (value) {
            value = value.replace(/RM\s*/g, '').replace(/,/g, '');
            $(this).val(value);
        }
    });

    // ===========================
    // FORM SUBMIT
    // ===========================
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
    // Check on page load for old values
    // ===========================
    const sistemValue = $('#sistem').val();
    if (sistemValue) {
        checkKodSistem(sistemValue);
    } else {
        resetSubsistemOptions();
    }

    const subsistemValue = $('#subsistem').val();
    if (subsistemValue) {
        checkKodSubSistem(subsistemValue);
    }
});
</script>
@endsection