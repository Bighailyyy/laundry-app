@extends('layouts.app')
@section('title', 'Daftar Pesanan')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0"><i class="bi bi-receipt me-2 text-primary"></i>Manajemen Pesanan</h4>
        <small class="text-muted"></small>
    </div>
    <a href="{{ route('pesanan.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Tambah Pesanan
    </a>
</div>
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card shadow-sm p-3 text-center border-start border-primary border-4">
            <div class="fs-2 fw-bold text-primary">{{ $stats['total'] }}</div>
            <div class="text-muted small">Total Pesanan</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card shadow-sm p-3 text-center border-start border-warning border-4">
            <div class="fs-2 fw-bold text-warning">{{ $stats['menunggu'] }}</div>
            <div class="text-muted small">Menunggu</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card shadow-sm p-3 text-center border-start border-info border-4">
            <div class="fs-2 fw-bold text-info">{{ $stats['proses'] }}</div>
            <div class="text-muted small">Diproses</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card shadow-sm p-3 text-center border-start border-success border-4">
            <div class="fs-2 fw-bold text-success">Rp{{ number_format($stats['pendapatan'], 0, ',', '.') }}</div>
            <div class="text-muted small">Pendapatan</div>
        </div>
    </div>
</div>
<div class="card shadow-sm mb-4">
    <div class="card-body py-2">
        <form method="GET" action="{{ route('pesanan.index') }}" class="row g-2 align-items-end">
            <div class="col-md-5">
                <label class="form-label small mb-1">Cari Nama Pelanggan</label>
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Ketik nama..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label small mb-1">Filter Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">-- Semua Status --</option>
                    @foreach(['menunggu','proses','selesai','diambil'] as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm flex-grow-1"><i class="bi bi-search me-1"></i>Filter</button>
                <a href="{{ route('pesanan.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>
</div>
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <span class="fw-semibold">Daftar Pesanan <span class="badge bg-secondary ms-1">{{ $pesanans->count() }}</span></span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th><th>Pelanggan</th><th>Layanan</th><th>Berat</th>
                        <th>Total</th><th>Est. Selesai</th><th>Status</th><th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanans as $p)
                    <tr>
                        <td class="text-muted small">{{ $p->id }}</td>
                        <td>
                            <div class="fw-semibold">{{ $p->pelanggan->nama }}</div>
                            <small class="text-muted">{{ $p->pelanggan->no_telepon }}</small>
                        </td>
                        <td>
                            <div>{{ $p->layanan->nama_layanan }}</div>
                            <small class="text-muted">Rp{{ number_format($p->layanan->harga_per_kg, 0, ',', '.') }}/kg</small>
                        </td>
                        <td>{{ $p->berat }} kg</td>
                        <td class="fw-semibold">Rp{{ number_format($p->total_harga, 0, ',', '.') }}</td>
                        <td>{{ $p->estimasi_selesai->format('d M Y') }}</td>
                        <td><span class="badge badge-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('pesanan.show', $p) }}" class="btn btn-outline-secondary btn-sm" title="Detail"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('pesanan.edit', $p) }}" class="btn btn-outline-primary btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('pesanan.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pesanan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-muted py-5"><i class="bi bi-inbox fs-2 d-block mb-2"></i>Tidak ada pesanan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
