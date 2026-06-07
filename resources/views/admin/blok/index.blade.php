@extends('layouts.app')

@section('title', 'Konfigurasi Blok & Binaan Luar')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-11">

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h2 class="mb-1"><i class="bi bi-building"></i> Konfigurasi Blok & Binaan Luar</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Konfigurasi Blok</li>
                            </ol>
                        </nav>
                    </div>
                    <a href="{{ route('admin.blok.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> Tambah Baru
                    </a>
                </div>

                {{-- Alert success --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- ══════════════════════════════════════
                     DUMMY DATA — nanti replace dengan @foreach($premisList as $premis)
                ══════════════════════════════════════ --}}

                {{-- Premis 1 --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header py-2 d-flex justify-content-between align-items-center"
                        style="background-color:#4a5568;">
                        <div>
                            <span class="text-white fw-semibold"><i class="bi bi-geo-alt-fill me-2"></i>PARLIMEN MALAYSIA</span>
                            <span class="badge bg-light text-dark ms-2">No. DPA: 11011 01MYS.140044.BD0001</span>
                        </div>
                        <div class="d-flex gap-2">
                            <span class="badge bg-primary">3 Blok</span>
                            <span class="badge bg-success">1 Binaan Luar</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width:50px;">Bil</th>
                                        <th>Jenis</th>
                                        <th>Nama</th>
                                        <th>Fungsi / Jenis Binaan</th>
                                        <th style="width:140px;">Luas Tapak (m²)</th>
                                        <th>Kod mySPATA</th>
                                        <th style="width:100px;" class="text-center">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Blok -->
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td><span class="badge" style="background-color:#0d6efd;">Blok</span></td>
                                        <td>DEWAN PERSIDANGAN</td>
                                        <td>DEWAN</td>
                                        <td>4,509.26</td>
                                        <td>F</td>
                                        <td class="text-center">
                                            <div class="d-flex gap-1 justify-content-center">
                                                <a href="/admin/blok/1/edit" class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm" title="Padam"
                                                    onclick="confirmPadam(this)" data-nama="DEWAN PERSIDANGAN">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">2</td>
                                        <td><span class="badge" style="background-color:#0d6efd;">Blok</span></td>
                                        <td>BLOK PEJABAT</td>
                                        <td>PEJABAT</td>
                                        <td>2,100.00</td>
                                        <td>A</td>
                                        <td class="text-center">
                                            <div class="d-flex gap-1 justify-content-center">
                                                <a href="#" class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm" title="Padam"
                                                    onclick="confirmPadam(this)" data-nama="BLOK PEJABAT">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">3</td>
                                        <td><span class="badge" style="background-color:#0d6efd;">Blok</span></td>
                                        <td>BLOK STOR</td>
                                        <td>STOR</td>
                                        <td>850.00</td>
                                        <td>B</td>
                                        <td class="text-center">
                                            <div class="d-flex gap-1 justify-content-center">
                                                <a href="#" class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm" title="Padam"
                                                    onclick="confirmPadam(this)" data-nama="BLOK STOR">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Binaan Luar -->
                                    <tr class="table-success bg-opacity-25">
                                        <td class="text-center">1</td>
                                        <td><span class="badge" style="background-color:#198754;">Binaan Luar</span></td>
                                        <td>PAGAR KAWASAN</td>
                                        <td>PAGAR</td>
                                        <td>320.00</td>
                                        <td>PG01</td>
                                        <td class="text-center">
                                            <div class="d-flex gap-1 justify-content-center">
                                                <a href="#" class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm" title="Padam"
                                                    onclick="confirmPadam(this)" data-nama="PAGAR KAWASAN">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Premis 2 --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header py-2 d-flex justify-content-between align-items-center"
                        style="background-color:#4a5568;">
                        <div>
                            <span class="text-white fw-semibold"><i class="bi bi-geo-alt-fill me-2"></i>PEJABAT JKR KUALA LUMPUR</span>
                            <span class="badge bg-light text-dark ms-2">No. DPA: 11011 01MYS.140044.BD0002</span>
                        </div>
                        <div class="d-flex gap-2">
                            <span class="badge bg-primary">2 Blok</span>
                            <span class="badge bg-secondary">Tiada Binaan Luar</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width:50px;">Bil</th>
                                        <th>Jenis</th>
                                        <th>Nama</th>
                                        <th>Fungsi / Jenis Binaan</th>
                                        <th style="width:140px;">Luas Tapak (m²)</th>
                                        <th>Kod mySPATA</th>
                                        <th style="width:100px;" class="text-center">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td><span class="badge" style="background-color:#0d6efd;">Blok</span></td>
                                        <td>BLOK UTAMA</td>
                                        <td>PEJABAT</td>
                                        <td>3,200.00</td>
                                        <td>A</td>
                                        <td class="text-center">
                                            <div class="d-flex gap-1 justify-content-center">
                                                <a href="#" class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm" title="Padam"
                                                    onclick="confirmPadam(this)" data-nama="BLOK UTAMA">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">2</td>
                                        <td><span class="badge" style="background-color:#0d6efd;">Blok</span></td>
                                        <td>BLOK BELAKANG</td>
                                        <td>STOR</td>
                                        <td>1,100.00</td>
                                        <td>C</td>
                                        <td class="text-center">
                                            <div class="d-flex gap-1 justify-content-center">
                                                <a href="#" class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm" title="Padam"
                                                    onclick="confirmPadam(this)" data-nama="BLOK BELAKANG">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Tiada data --}}
                {{-- Uncomment bila guna real data dan tiada rekod
                @if($premisList->isEmpty())
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="bi bi-inbox display-4 text-muted"></i>
                            <p class="mt-3 text-muted">Tiada rekod blok atau binaan luar dijumpai.</p>
                            <a href="{{ route('admin.blok.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-lg"></i> Tambah Sekarang
                            </a>
                        </div>
                    </div>
                @endif
                --}}

            </div>
        </div>
    </div>

    {{-- Modal Padam --}}
    <form id="formPadam" method="POST" action="">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('scripts')
    <script>
        function confirmPadam(btn) {
            const nama = btn.getAttribute('data-nama');
            if (confirm('Adakah anda pasti ingin memadam "' + nama + '"?')) {
                // nanti set action form padam dengan route betul
                // document.getElementById('formPadam').action = '/admin/blok/' + id;
                // document.getElementById('formPadam').submit();
                alert('Fungsi padam akan disambung selepas backend siap.');
            }
        }
    </script>
@endpush