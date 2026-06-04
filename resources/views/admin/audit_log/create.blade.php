@extends('layouts.app')

@section('title', 'Tambah Log')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Header -->
            <div class="mb-4">
                <h2 class="mb-1"><i class="bi bi-plus-circle"></i> Tambah Log Baru</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.audit_log.index') }}">Audit Log</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </nav>
            </div>

            <form action="{{ route('admin.audit_log.store') }}" method="POST">
                @csrf

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-info-circle"></i> Maklumat Log</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Komponen -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">Komponen</label>
                                <select name="component_id" class="form-select @error('component_id') is-invalid @enderror">
                                    <option value="">-- Pilih Komponen (Opsional) --</option>
                                    @foreach($components as $component)
                                    <option value="{{ $component->id }}" {{ old('component_id') == $component->id ? 'selected' : '' }}>
                                        {{ $component->id }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('component_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tajuk -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">Tajuk <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title') }}" required placeholder="Contoh: Pemeriksaan HVAC">
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Keterangan -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">Keterangan</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                          rows="5" placeholder="Masukkan keterangan log (opsional)">{{ old('description') }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2 mb-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Simpan Log
                    </button>
                    <a href="{{ route('admin.audit_log.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection