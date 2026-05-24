@extends('layouts.app')
@section('title', 'Detail Pesanan #' . $pesanan->id)
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('pesanan.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h4 class="fw-bold mb-0">Detail Pesanan #{{ $pesanan->id }}</h4>
        <small class="text-muted"></small>
    </div>
</div>
<div class="row g-4">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white fw-semibold py-3">Informasi Pesanan</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="text-muted small">Pelanggan</div>
                        <div class="fw-semibold">{{ $pesanan->pelanggan->nama }}</div>
                        <div class="small text-muted">{{ $pesanan->pelanggan->no_telepon }}</div>
                        <div class="small text-muted">{{ $pesanan->pelanggan->alamat }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted small">Jenis Layanan</div>
                        <div class="fw-semibold">{{ $pesanan->layanan->nama_layanan }}</div>
                        <div class="small text-muted">Rp{{ number_format($pesanan->layanan->harga_per_kg,0,',','.') }}/kg</div>
                    </div>
                    <div class="col-sm-4">
                        <div class="text-muted small">Berat</div>
                        <div class="fw-semibold">{{ $pesanan->berat }} kg</div>
                    </div>
                    <div class="col-sm-4">
                        <div class="text-muted small">Total Harga</div>
                        <div class="fw-semibold text-success fs-5">Rp{{ number_format($pesanan->total_harga,0,',','.') }}</div>
                    </div>
                    <div class="col-sm-4">
                        <div class="text-muted small">Estimasi Selesai</div>
                        <div class="fw-semibold">{{ $pesanan->estimasi_selesai->format('d M Y') }}</div>
                    </div>
                    @if($pesanan->catatan)
                    <div class="col-12">
                        <div class="text-muted small">Catatan</div>
                        <div>{{ $pesanan->catatan }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- UPDATE STATUS --}}
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold py-3">Update Status
                <small class="text-muted fw-normal ms-2">Eloquent update()</small>
            </div>
            <div class="card-body">
                <form action="{{ route('pesanan.updateStatus', $pesanan) }}" method="POST" class="d-flex gap-2 align-items-end">
                    @csrf @method('PATCH')
                    <div class="flex-grow-1">
                        <select name="status" class="form-select">
                            @foreach(['menunggu','proses','selesai','diambil'] as $s)
                                <option value="{{ $s }}" {{ $pesanan->status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-white fw-semibold py-3">Status Saat Ini</div>
            <div class="card-body text-center">
                <span class="badge badge-{{ $pesanan->status }} fs-6 px-3 py-2">{{ ucfirst($pesanan->status) }}</span>
                <div class="mt-3 text-muted small">Dibuat: {{ $pesanan->created_at->format('d M Y H:i') }}</div>
            </div>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-header bg-white fw-semibold py-3">Aksi</div>
            <div class="card-body d-grid gap-2">
                <a href="{{ route('pesanan.edit', $pesanan) }}" class="btn btn-outline-primary">
                    <i class="bi bi-pencil me-1"></i>Edit Pesanan
                </a>
                <form action="{{ route('pesanan.destroy', $pesanan) }}" method="POST"
                      onsubmit="return confirm('Hapus pesanan ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="bi bi-trash me-1"></i>Hapus Pesanan
                    </button>
                </form>
            </div>
        </div>

        {{-- RIWAYAT PESANAN (Relasi HasMany via where()) --}}
        @if($riwayat->count() > 0)
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold py-3">Pesanan Lain dari Pelanggan Ini
                <small class="text-muted fw-normal d-block">Eloquent where('pelanggan_id', ...)</small>
            </div>
            <div class="list-group list-group-flush">
                @foreach($riwayat as $r)
                <a href="{{ route('pesanan.show', $r) }}" class="list-group-item list-group-item-action">
                    <div class="d-flex justify-content-between">
                        <span class="small fw-semibold">#{{ $r->id }} — {{ $r->layanan->nama_layanan }}</span>
                        <span class="badge badge-{{ $r->status }}">{{ ucfirst($r->status) }}</span>
                    </div>
                    <div class="small text-muted">{{ $r->berat }} kg — Rp{{ number_format($r->total_harga,0,',','.') }}</div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
