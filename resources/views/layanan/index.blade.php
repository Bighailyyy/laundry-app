@extends('layouts.app')
@section('title', 'Data Layanan')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0"><i class="bi bi-tags me-2 text-primary"></i>Data Layanan</h4>
        <small class="text-muted"></small>
    </div>
    <a href="{{ route('layanan.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Tambah Layanan
    </a>
</div>
<div class="row g-3">
    @forelse($layanans as $l)
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="fw-bold">{{ $l->nama_layanan }}</h6>
                <div class="fs-5 fw-bold text-primary mb-1">Rp{{ number_format($l->harga_per_kg, 0, ',', '.') }}<span class="fs-6 text-muted fw-normal">/kg</span></div>
                <p class="text-muted small mb-3">{{ $l->deskripsi ?? '-' }}</p>
                <div class="d-flex justify-content-between align-items-center">
                    {{-- withCount relasi HasMany --}}
                    <span class="badge bg-light text-dark border">{{ $l->pesanans_count }} pesanan</span>
                    <div>
                        <a href="{{ route('layanan.edit', $l) }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('layanan.destroy', $l) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus layanan ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center text-muted py-5">Belum ada layanan.</div>
    @endforelse
</div>
@endsection
