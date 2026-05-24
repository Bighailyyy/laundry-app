@extends('layouts.app')
@section('title', 'Edit Layanan')
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('layanan.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h4 class="fw-bold mb-0">Edit Layanan</h4>
        <small class="text-muted"></small>
    </div>
</div>
<div class="card shadow-sm" style="max-width:500px">
    <div class="card-body p-4">
        <form action="{{ route('layanan.update', $layanan) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Layanan</label>
                <input type="text" name="nama_layanan" class="form-control @error('nama_layanan') is-invalid @enderror" value="{{ old('nama_layanan', $layanan->nama_layanan) }}" required>
                @error('nama_layanan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Harga per kg (Rp)</label>
                <input type="number" name="harga_per_kg" class="form-control @error('harga_per_kg') is-invalid @enderror" value="{{ old('harga_per_kg', $layanan->harga_per_kg) }}" min="1000" required>
                @error('harga_per_kg')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Deskripsi</label>
                <input type="text" name="deskripsi" class="form-control" value="{{ old('deskripsi', $layanan->deskripsi) }}">
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button>
                <a href="{{ route('layanan.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
