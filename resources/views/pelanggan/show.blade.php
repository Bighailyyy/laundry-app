@extends('layouts.app')
@section('title', 'Detail Pelanggan')
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('pelanggan.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h4 class="fw-bold mb-0">Detail Pelanggan: {{ $pelanggan->nama }}</h4>
        <small class="text-muted"></small>
    </div>
</div>
<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-white fw-semibold py-3">Info Pelanggan</div>
            <div class="card-body">
                <div class="mb-2"><span class="text-muted small d-block">Nama</span><strong>{{ $pelanggan->nama }}</strong></div>
                <div class="mb-2"><span class="text-muted small d-block">Telepon</span>{{ $pelanggan->no_telepon }}</div>
                <div class="mb-2"><span class="text-muted small d-block">Alamat</span>{{ $pelanggan->alamat ?? '-' }}</div>
            </div>
        </div>
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-white fw-semibold py-3">Statistik</div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Total Pesanan</span><strong>{{ $stats['total'] }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Selesai</span><strong>{{ $stats['selesai'] }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Total Belanja</span>
                    <strong class="text-success">Rp{{ number_format($stats['total_harga'],0,',','.') }}</strong>
                </div>
            </div>
        </div>
        <div class="d-grid gap-2">
            <a href="{{ route('pelanggan.edit', $pelanggan) }}" class="btn btn-outline-primary">
                <i class="bi bi-pencil me-1"></i>Edit Pelanggan
            </a>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold py-3">
                Riwayat Pesanan
                <small class="text-muted fw-normal ms-2">Relasi HasMany: pelanggan->pesanans->layanan</small>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr><th>#</th><th>Layanan</th><th>Berat</th><th>Total</th><th>Tgl Selesai</th><th>Status</th><th></th></tr>
                    </thead>
                    <tbody>
                        @forelse($pelanggan->pesanans as $p)
                        <tr>
                            <td class="text-muted small">{{ $p->id }}</td>
                            <td>
                                {{-- Nested relation: pesanan->layanan --}}
                                {{ $p->layanan->nama_layanan }}
                            </td>
                            <td>{{ $p->berat }} kg</td>
                            <td>Rp{{ number_format($p->total_harga,0,',','.') }}</td>
                            <td class="small">{{ $p->estimasi_selesai->format('d M Y') }}</td>
                            <td><span class="badge badge-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
                            <td>
                                <a href="{{ route('pesanan.show', $p) }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-eye"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Belum ada pesanan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
