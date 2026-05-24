@extends('layouts.app')
@section('title', 'Edit Pelanggan')
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('pelanggan.show', $pelanggan) }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h4 class="fw-bold mb-0">Edit Pelanggan</h4>
        <small class="text-muted"></small>
    </div>
</div>
<div class="card shadow-sm" style="max-width:500px">
    <div class="card-body p-4">
        <form action="{{ route('pelanggan.update', $pelanggan) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $pelanggan->nama) }}" required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">No. Telepon</label>
                <input type="text" name="no_telepon" class="form-control @error('no_telepon') is-invalid @enderror" value="{{ old('no_telepon', $pelanggan->no_telepon) }}" required>
                @error('no_telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Alamat</label>
                <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $pelanggan->alamat) }}">
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button>
                <a href="{{ route('pelanggan.show', $pelanggan) }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
