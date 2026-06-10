@extends('layouts.app')

@section('title', 'Konfigurasi Blok')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="bi bi-grid-3x3-gap"></i> Konfigurasi Blok</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Konfigurasi Blok</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.blok.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Blok
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            @if($kodBloks->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Bil</th>
                            <th>Kod</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kodBloks as $index => $blok)
                        <tr>
                            <td>{{ $kodBloks->firstItem() + $index }}</td>
                            <td><span class="badge bg-secondary">{{ $blok->kod }}</span></td>
                            <td>{{ $blok->nama }}</td>
                            <td>
                                @if($blok->is_active)
                                <span class="badge bg-success">Aktif</span>
                                @else
                                <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.blok.edit', $blok->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.blok.destroy', $blok->id) }}" method="POST"
                                        onsubmit="return confirm('Padam blok {{ $blok->kod }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-3">
                {{ $kodBloks->links() }}
            </div>
            @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-grid-3x3-gap" style="font-size: 3rem;"></i>
                <p class="mt-3">Tiada rekod blok dijumpai.</p>
                <a href="{{ route('admin.blok.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Tambah Blok
                </a>
            </div>
            @endif
        </div>
    </div>

</div>
@endsection