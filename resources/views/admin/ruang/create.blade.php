@extends('layouts.app')

@section('title', 'Tambah Ruang')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Header -->
            <div class="mb-4">
                <h2 class="mb-1"><i class="bi bi-plus-circle"></i> Tambah Ruang Baru</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.ruang.index') }}">Ruang</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </nav>
            </div>

            <form action="{{ route('admin.ruang.store') }}" method="POST">
                @csrf

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-info-circle"></i> Maklumat Ruang</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Aras -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">Aras <span class="text-danger">*</span></label>
                                <select name="aras_id" class="form-select @error('aras_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Aras --</option>
                                    @foreach($aras as $item)
                                    <option value="{{ $item->id }}" {{ old('aras_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->kod }} - {{ $item->nama }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('aras_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kod -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Kod Ruang <span class="text-danger">*</span></label>
                                <input type="text" name="kod" class="form-control @error('kod') is-invalid @enderror"
                                       value="{{ old('kod') }}" required placeholder="Contoh: R01">
                                <small class="text-muted">Contoh: R01, R02, BIL</small>
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
                                <label class="form-label fw-semibold">Nama Ruang <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                       value="{{ old('nama') }}" required placeholder="Contoh: Bilik Mesyuarat">
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
                        <i class="bi bi-check-circle"></i> Simpan Ruang
                    </button>
                    <a href="{{ route('admin.ruang.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection