@extends('layouts.app')

@section('title', 'Kemaskini Pengguna')

@section('content')
<div class="container-fluid">

    <!-- Header -->
    <div class="mb-4">
        <h2 class="mb-1"><i class="bi bi-person-gear"></i> Kemaskini Pengguna</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Pengguna</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-8">

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- BASIC INFO -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-info-circle"></i> Maklumat Asas</h5>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">

                            <!-- Name -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Penuh <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $user->name) }}" required>

                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Username -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                                <input type="text" name="username"
                                       class="form-control @error('username') is-invalid @enderror"
                                       value="{{ old('username', $user->username) }}" required>

                                @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $user->email) }}" required>

                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">No. Telefon</label>
                                <input type="text" name="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone', $user->phone) }}">

                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Department -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">Jabatan</label>
                                <input type="text" name="department"
                                       class="form-control @error('department') is-invalid @enderror"
                                       value="{{ old('department', $user->department) }}">

                                @error('department')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>

                <!-- PASSWORD -->
                {{-- <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="bi bi-shield-lock"></i> Tukar Kata Laluan (Optional)</h5>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">

                            <!-- Password -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Kata Laluan Baru</label>
                                <input type="password"
                                       name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       autocomplete="new-password">

                                <small class="text-muted">Kosongkan jika tidak mahu tukar</small>

                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Sahkan Kata Laluan Baru</label>
                                <input type="password"
                                       name="password_confirmation"
                                       class="form-control"
                                       autocomplete="new-password">
                            </div>

                        </div>
                    </div>
                </div> --}}

                <!-- SETTINGS -->
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
                                <small class="text-muted">Peranan ditetapkan sebagai JKR untuk akses penuh sistem.</small>

                                @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Status Akaun</label>

                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="is_active"
                                           id="is_active"
                                           value="1"
                                           {{ old('is_active', $user->is_active) ? 'checked' : '' }}>

                                    <label class="form-check-label" for="is_active">
                                        Akaun Aktif
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- BUTTONS -->
                <div class="d-flex gap-2 mb-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Kemaskini
                    </button>

                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>

            </form>
        </div>

        <!-- HELP -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-lightbulb"></i> Panduan</h5>
                </div>

                <div class="card-body">
                    <ul class="small">
                        <li>Role menentukan akses sistem</li>
                        <li>Status aktif boleh disable user</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection