@extends('layouts.app')

@section('title', 'Tambah Aras')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Header -->
            <div class="mb-4">
                <h2 class="mb-1"><i class="bi bi-plus-circle"></i> Tambah Aras Baru</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.aras.index') }}">Aras</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </nav>
            </div>

            <form action="{{ route('admin.aras.store') }}" method="POST">
                @csrf

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-info-circle"></i> Maklumat Aras</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Blok -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">Blok <span class="text-danger">*</span></label>
                                <select name="blok_id" class="form-select @error('blok_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Blok --</option>
                                    @foreach($bloks as $blok)
                                    <option value="{{ $blok->id }}" {{ old('blok_id') == $blok->id ? 'selected' : '' }}>
                                        {{ $blok->kod }} - {{ $blok->nama }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('blok_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kod -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Kod Aras <span class="text-danger">*</span></label>
                                <input type="text" name="kod" class="form-control @error('kod') is-invalid @enderror"
                                       value="{{ old('kod') }}" required placeholder="Contoh: 01">
                                <small class="text-muted">Contoh: 01, 02, LG, G</small>
                                @error('kod')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
                                    <label class="form-check-label" for="is_active">Aktif</label>
                                </div>
                            </div>

                            <!-- Nama -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">Nama Aras <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                       value="{{ old('nama') }}" required placeholder="Contoh: Aras 1">
                                @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2 mb-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Simpan Aras
                    </button>
                    <a href="{{ route('admin.aras.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection