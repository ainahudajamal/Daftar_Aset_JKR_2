@extends('layouts.app')

@section('title', 'Tambah Blok')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Header -->
            <div class="mb-4">
                <h2 class="mb-1"><i class="bi bi-plus-circle"></i> Tambah Blok Baru</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.blok.index') }}">Blok</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </nav>
            </div>

            <form action="{{ route('admin.blok.store') }}" method="POST">
                @csrf

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-info-circle"></i> Maklumat Blok</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Kod -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Kod Blok <span class="text-danger">*</span></label>
                                <input type="text" name="kod" class="form-control @error('kod') is-invalid @enderror"
                                       value="{{ old('kod') }}" required placeholder="Contoh: Blok A">
                                <small class="text-muted">Kod unik untuk blok. Contoh: Blok A, BLok B, BLOK C</small>
                                @error('kod')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
                                    <label class="form-check-label" for="is_active">
                                        Aktif
                                    </label>
                                </div>
                            </div>

                            <!-- Nama -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">Nama Blok <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                       value="{{ old('nama') }}" required placeholder="Contoh: Blok A">
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
                        <i class="bi bi-check-circle"></i> Simpan Blok
                    </button>
                    <a href="{{ route('admin.blok.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection