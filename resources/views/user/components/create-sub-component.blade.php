@extends('layouts.app')

@section('title', 'Borang 3: Sub Komponen')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">BORANG PENGUMPULAN DATA DAFTAR ASET KHUSUS</h5>
                <small>Peringkat Komponen Sub Komponen</small>
            </div>
            <div class="card-body">
                <form action="{{ route('sub-components.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- MAKLUMAT SUB KOMPONEN -->
                    <div class="card mb-4">
                        <div class="card-header bg-secondary text-white">
                            MAKLUMAT SUB KOMPONEN
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Komponen Utama <span class="text-danger">*</span></label>
                                    <select class="form-select @error('main_component_id') is-invalid @enderror" 
                                            name="main_component_id" id="mainComponentSelect" required>
                                        <option value="">-- Pilih Komponen Utama --</option>
                                        @foreach($mainComponents as $mainComp)
                                            <option value="{{ $mainComp->id }}" 
                                                    data-komponen="{{ $mainComp->component?->nama_premis }}"
                                                    {{ old('main_component_id') == $mainComp->id ? 'selected' : '' }}>
                                                {{ $mainComp->nama_komponen_utama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('main_component_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Id Komponen Utama</label>
                                    <input type="text" class="form-control" id="displayKomponen" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kod Lokasi</label>
                                    <input type="text" class="form-control" id="displayKodLokasi" readonly>
                                </div>
                            </div>

                            <div class="card mb-3" style="background: #f8f9fa;">
                                <div class="card-header bg-dark text-white">
                                    <strong>Maklumat Sub Komponen</strong>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Sub Komponen <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nama_sub_komponen') is-invalid @enderror" 
                                               name="nama_sub_komponen" value="{{ old('nama_sub_komponen') }}" required>
                                        @error('nama_sub_komponen')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi<span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Status Komponen <span class="text-danger">*</span></label>
                                            <select class="form-select" name="status_komponen">
                                                <option value="">-- Pilih Status --</option>
                                                <option value="operational" {{ old('status_komponen') == 'operational' ? 'selected' : '' }}>Beroperasi</option>
                                                <option value="under_maintenance" {{ old('status_komponen') == 'under_maintenance' ? 'selected' : '' }}>Sedang Diselenggara</option>
                                                <option value="rosak" {{ old('status_komponen') == 'rosak' ? 'selected' : '' }}>Rosak</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">No. Siri <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="no_siri" value="{{ old('no_siri') }}">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">No. Sijil Pendaftaran (Jika ada) </label>
                                            <input type="text" class="form-control" name="no_sijil_pendaftaran" value="{{ old('no_sijil_pendaftaran') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Jenama<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="jenama" value="{{ old('jenama') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Model<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="model" value="{{ old('model') }}">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Kuantiti (Sama Jenis) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="kuantiti" value="{{ old('kuantiti', 1) }}" min="1">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Catatan:</label>
                                        <textarea class="form-control" name="catatan" rows="2">{{ old('catatan') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Button untuk next section -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('components.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="button" class="btn btn-info text-white" onclick="showSpecificationSection()">
                            Seterusnya: Atribut Spesifikasi <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>

                    <!-- Hidden section for specifications -->
                    <div id="specificationSection" style="display: none;">
                        @include('user.components.partials.sub-component-specifications')
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script>
$(document).ready(function() {
    // ===========================
    // Auto-fill komponen name dan kod lokasi
    // ===========================
    $('#mainComponentSelect').on('change', function() {
        const selected = this.options[this.selectedIndex];
        const komponenName = selected.getAttribute('data-komponen');
        const kodLokasi = selected.getAttribute('data-kod-lokasi');
        
        // Set nama komponen
        $('#displayKomponen').val(komponenName || '');
        
        // Set kod lokasi
        if (kodLokasi) {
            $('#displayKodLokasi').val(kodLokasi);
        } else {
            // Generate kod lokasi jika tidak ada
            const mainCompId = $(this).val();
            if (mainCompId) {
                $('#displayKodLokasi').val('LOK-' + mainCompId.padStart(4, '0'));
            } else {
                $('#displayKodLokasi').val('');
            }
        }
    });

    // Trigger on page load jika ada value (untuk validation error)
    if ($('#mainComponentSelect').val()) {
        $('#mainComponentSelect').trigger('change');
    }
});

function showSpecificationSection() {
    document.getElementById('specificationSection').style.display = 'block';
    document.querySelector('button[onclick="showSpecificationSection()"]').style.display = 'none';
    document.getElementById('specificationSection').scrollIntoView({ behavior: 'smooth' });
}

// =====================================================
// FUNGSI UNTUK SUB-COMPONENT SPECIFICATIONS
// =====================================================
let categoryCounter = 0;

// ===========================================
// FUNGSI SPESIFIKASI (Saiz, Kadaran, Kapasiti)
// ===========================================
window.addSpesifikasi = function(type) {
    console.log('addSpesifikasi called for:', type);
    
    const card = document.querySelector(`.spesifikasi-card[data-type="${type}"]`);
    if (!card) {
        console.error(`Card untuk type "${type}" tidak dijumpai`);
        return;
    }
    
    const container = card.querySelector('.spesifikasi-rows');
    if (!container) {
        console.error('Container .spesifikasi-rows tidak dijumpai');
        return;
    }
    
    const newRow = document.createElement('div');
    newRow.className = 'row mb-2 spesifikasi-row';
    
    let placeholderValue = '';
    let placeholderUnit = '';
    
    if (type === 'saiz') {
        placeholderValue = 'Contoh: 1200x400x500 atau 1200';
        placeholderUnit = 'Unit (mm/cm/m)';
    } else if (type === 'kadaran') {
        placeholderValue = 'Nilai';
        placeholderUnit = 'Unit (kW/HP/A)';
    } else if (type === 'kapasiti') {
        placeholderValue = 'Nilai';
        placeholderUnit = 'Unit (L/kg/ton)';
    }
    
    newRow.innerHTML = `
        <div class="col-md-7">
            <input type="text" class="form-control" name="${type}[]" placeholder="${placeholderValue}">
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control" name="${type}_unit[]" placeholder="${placeholderUnit}">
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-sm btn-danger" onclick="removeSpesifikasi(this)">
                <i class="bi bi-x"></i>
            </button>
        </div>
    `;
    
    container.appendChild(newRow);
    console.log('Spesifikasi baru ditambah');
};

window.removeSpesifikasi = function(button) {
    button.closest('.spesifikasi-row').remove();
};

// ===========================================
// FUNGSI KATEGORI DOKUMEN
// ===========================================
window.addDocumentCategory = function() {
    categoryCounter++;
    const categoryName = 'kategori_' + categoryCounter;
    const container = document.getElementById('documentCategoriesContainer');
    
    if (!container) {
        console.error('documentCategoriesContainer tidak dijumpai');
        return;
    }
    
    const categoryCard = document.createElement('div');
    categoryCard.className = 'document-category-card card mb-3';
    categoryCard.setAttribute('data-category', categoryName);
    
    categoryCard.innerHTML = `
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <strong>Kategori:</strong>
                <input type="text" class="form-control form-control-sm d-inline-block" style="width: 200px;" 
                       name="doc_category[]" value="${categoryName}" placeholder="Nama Kategori">
            </div>
            <div>
                <button type="button" class="btn btn-sm btn-success me-2" onclick="addDocumentToCategory(this)">
                    <i class="bi bi-plus"></i> Tambah Dokumen
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeCategory(this)">
                    <i class="bi bi-x"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-sm">
                <thead class="table-light">
                    <tr>
                        <th width="5%">Bil</th>
                        <th width="35%">Nama Dokumen</th>
                        <th width="30%">No Rujukan</th>
                        <th width="25%">Catatan</th>
                        <th width="5%"></th>
                    </tr>
                </thead>
                <tbody class="documents-tbody">
                    <tr class="document-row">
                        <td><input type="number" class="form-control form-control-sm" name="doc_bil[${categoryName}][]" value="1"></td>
                        <td><input type="text" class="form-control form-control-sm" name="doc_nama[${categoryName}][]" placeholder="Nama Dokumen"></td>
                        <td><input type="text" class="form-control form-control-sm" name="doc_rujukan[${categoryName}][]" placeholder="No Rujukan"></td>
                        <td><input type="text" class="form-control form-control-sm" name="doc_catatan[${categoryName}][]" placeholder="Catatan"></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    `;
    
    container.appendChild(categoryCard);
    console.log('Kategori baru ditambah:', categoryName);
};

// ===========================================
// FUNGSI TAMBAH DOKUMEN DALAM KATEGORI
// ===========================================
window.addDocumentToCategory = function(button) {
    console.log('addDocumentToCategory called');
    
    const categoryCard = button.closest('.document-category-card');
    if (!categoryCard) {
        console.error('Kategori card tidak dijumpai');
        return;
    }
    
    const tbody = categoryCard.querySelector('.documents-tbody');
    if (!tbody) {
        console.error('tbody tidak dijumpai');
        return;
    }
    
    const categoryInput = categoryCard.querySelector('input[name="doc_category[]"]');
    const categoryName = categoryInput ? categoryInput.value : 'umum';
    
    const rowCount = tbody.querySelectorAll('.document-row').length;
    const newBil = rowCount + 1;
    
    const newRow = document.createElement('tr');
    newRow.className = 'document-row';
    newRow.innerHTML = `
        <td><input type="number" class="form-control form-control-sm" name="doc_bil[${categoryName}][]" value="${newBil}"></td>
        <td><input type="text" class="form-control form-control-sm" name="doc_nama[${categoryName}][]" placeholder="Nama Dokumen"></td>
        <td><input type="text" class="form-control form-control-sm" name="doc_rujukan[${categoryName}][]" placeholder="No Rujukan"></td>
        <td><input type="text" class="form-control form-control-sm" name="doc_catatan[${categoryName}][]" placeholder="Catatan"></td>
        <td>
            <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">
                <i class="bi bi-x"></i>
            </button>
        </td>
    `;
    
    tbody.appendChild(newRow);
    console.log('Dokumen baru ditambah ke kategori:', categoryName);
};

// ===========================================
// FUNGSI BUANG KATEGORI
// ===========================================
window.removeCategory = function(button) {
    if (confirm('Adakah anda pasti mahu membuang kategori dokumen ini?')) {
        button.closest('.document-category-card').remove();
    }
};
</script>
@endsection