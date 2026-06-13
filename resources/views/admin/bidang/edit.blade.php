@extends('layouts.app')

@section('title', 'Edit Kod Bidang')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Header -->
            <div class="mb-4">
                <h2 class="mb-1"><i class="bi bi-pencil"></i> Edit Kod Bidang</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.bidang.index') }}">Kod Bidang</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>

            <form action="{{ route('admin.bidang.update', $bidang) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-info-circle"></i> Maklumat Kod Bidang</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Kod -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Kod Bidang <span class="text-danger">*</span></label>
                                <input type="text" name="kod" class="form-control @error('kod') is-invalid @enderror" 
                                       value="{{ old('kod', $bidang->kod) }}" required placeholder="Contoh: 01, ELEC, ME">
                                <small class="text-muted">Kod unik untuk bidang.</small>
                                @error('kod')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" 
                                           {{ old('is_active', $bidang->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Aktif
                                    </label>
                                </div>
                            </div>

                            <!-- Nama -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">Nama Bidang <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                                       value="{{ old('nama', $bidang->nama) }}" required placeholder="Contoh: Kejuruteraan Mekanikal">
                                @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Keterangan -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">Keterangan</label>
                                <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" 
                                          rows="4" placeholder="Masukkan keterangan kod bidang (opsional)">{{ old('keterangan', $bidang->keterangan) }}</textarea>
                                @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2 mb-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Kemaskini Kod Bidang
                    </button>
                    <a href="{{ route('admin.bidang.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
