@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="mb-4">
        <h2 class="mb-1"><i class="bi bi-person-plus"></i> Tambah Pengguna Baru</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Pengguna</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-8">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-info-circle"></i> Maklumat Asas</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Name -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Penuh <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Username -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" 
                                       value="{{ old('username') }}" required>
                                <small class="text-muted">Tanpa spasi, huruf kecil. Contoh: ahmad123</small>
                                @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email') }}" required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">No. Telefon</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone') }}" placeholder="03-12345678">
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Department -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">Jabatan</label>
                                <input type="text" name="department" class="form-control @error('department') is-invalid @enderror" 
                                       value="{{ old('department') }}" placeholder="IT & Pentadbiran">
                                @error('department')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="bi bi-shield-lock"></i> Keselamatan</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Password -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Kata Laluan <span class="text-danger">*</span></label>
                                <input type="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    autocomplete="new-password"
                                    required>
                                <small class="text-muted">Minimum 6 aksara</small>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Sahkan Kata Laluan <span class="text-danger">*</span></label>
                                <input type="password"
                                    name="password_confirmation"
                                    class="form-control"
                                    autocomplete="new-password"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-gear"></i> Tetapan</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Role -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                                <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                                    <option value="admin" selected>JKR</option>
                                </select>
                                <small class="text-muted">Semua pengguna baru didaftarkan dengan akses JKR secara lalai.</small>
                                @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Status Akaun</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                                    <label class="form-check-label" for="is_active">
                                        Akaun Aktif
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2 mb-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Simpan Pengguna
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Help Card -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-lightbulb"></i> Panduan</h5>
                </div>
                <div class="card-body">
                    <h6>Role Pengguna:</h6>
                    <ul class="small">
                        <li><strong>JKR:</strong> Akses penuh ke semua modul pengurusan premis, blok, aras, ruang dan komponen fizikal</li>
                    </ul>

                    <hr>

                    <h6>Tips Username:</h6>
                    <ul class="small">
                        <li>Guna huruf kecil tanpa spasi</li>
                        <li>Boleh guna nombor dan underscore</li>
                        <li>Contoh: ahmad_ibrahim, user123</li>
                    </ul>

                    <hr>

                    <h6>Keselamatan:</h6>
                    <ul class="small">
                        <li>Kata laluan minimum 6 aksara</li>
                        <li>Guna kombinasi huruf dan nombor</li>
                        <li>Pengguna boleh tukar kata laluan sendiri selepas login</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection