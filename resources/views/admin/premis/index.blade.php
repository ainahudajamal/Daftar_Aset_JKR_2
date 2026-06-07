@extends('layouts.app')

@section('title', 'Konfigurasi Premis')

@section('content')
<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="bi bi-bank"></i> Konfigurasi
                 Premis</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Premis</li>
                </ol>
            </nav>
        </div>

        <div class="d-flex gap-2">
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalPDF">
                <i class="bi bi-file-pdf"></i> Preview PDF
            </button>
            <a href="{{ route('admin.premis.create') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-plus-circle"></i> Tambah Premis
            </a>
        </div>
    </div>

    <!-- Table Premis -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="bi bi-list-ul"></i> Senarai Premis</h5>
        </div>
        <div class="card-body">
            <div class="text-center py-5 text-muted">
                <i class="bi bi-bank" style="font-size: 3rem;"></i>
                <p class="mt-3 mb-3">Tiada rekod premis dijumpai.</p>
                <a href="{{ route('admin.premis.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Premis Pertama
                </a>
            </div>
        </div>
    </div>

</div>

<!-- Modal Preview PDF -->
<div class="modal fade" id="modalPDF" tabindex="-1" aria-labelledby="modalPDFLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPDFLabel">
                    <i class="bi bi-file-pdf text-danger"></i> Pratonton D.A.3 - Kad Pendaftaran Aset Tak Alih
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <iframe
                    src="{{ route('admin.premis.export-pdf') }}"
                    width="100%"
                    height="650px"
                    style="border: none;">
                </iframe>
            </div>
            <div class="modal-footer">
                <a href="{{ route('admin.premis.export-pdf') }}" class="btn btn-success">
                    <i class="bi bi-download"></i> Muat Turun PDF
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@endsection