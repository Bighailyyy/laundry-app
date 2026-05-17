<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BersihKilat Laundry</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f4f8; }
        .navbar-brand { font-weight: 700; font-size: 1.3rem; }
        .stat-card { border-radius: 12px; border: none; }
        .badge-menunggu  { background-color: #ffc107; color: #000; }
        .badge-proses    { background-color: #0d6efd; color: #fff; }
        .badge-selesai   { background-color: #198754; color: #fff; }
        .badge-diambil   { background-color: #6c757d; color: #fff; }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-dark bg-primary px-4 py-3">
    <span class="navbar-brand">🧺 BersihKilat Laundry</span>
    <span class="text-white small">Sistem Manajemen Pesanan</span>
</nav>

<div class="container py-4">

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ✅ {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- STATISTIK --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card stat-card bg-white shadow-sm p-3 text-center">
                <div class="fs-2 fw-bold text-primary">{{ $stats['total'] }}</div>
                <div class="text-muted small">Total Pesanan</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card bg-white shadow-sm p-3 text-center">
                <div class="fs-2 fw-bold text-warning">{{ $stats['menunggu'] }}</div>
                <div class="text-muted small">Menunggu</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card bg-white shadow-sm p-3 text-center">
                <div class="fs-2 fw-bold text-info">{{ $stats['proses'] }}</div>
                <div class="text-muted small">Diproses</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card bg-white shadow-sm p-3 text-center">
                <div class="fs-2 fw-bold text-success">Rp{{ number_format($stats['pendapatan'], 0, ',', '.') }}</div>
                <div class="text-muted small">Total Pendapatan</div>
            </div>
        </div>
    </div>

    {{-- FORM TAMBAH PESANAN --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white fw-semibold">➕ Tambah Pesanan Baru</div>
        <div class="card-body">
            <form action="{{ route('pesanan.store') }}" method="POST">
                @csrf
                <div class="row g-2">
                    <div class="col-md-3">
                        <label class="form-label small">Nama Pelanggan</label>
                        <input class="form-control @error('nama_pelanggan') is-invalid @enderror"
                               name="nama_pelanggan" placeholder="Nama lengkap" value="{{ old('nama_pelanggan') }}" required>
                        @error('nama_pelanggan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small">No. Telepon</label>
                        <input class="form-control @error('no_telepon') is-invalid @enderror"
                               name="no_telepon" placeholder="08xx" value="{{ old('no_telepon') }}" required>
                        @error('no_telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">Jenis Layanan</label>
                        <select class="form-select @error('jenis_layanan') is-invalid @enderror" name="jenis_layanan" required>
                            <option value="">-- Pilih Layanan --</option>
                            <option value="Cuci + Setrika" {{ old('jenis_layanan')=='Cuci + Setrika'?'selected':'' }}>Cuci + Setrika (Rp7.000/kg)</option>
                            <option value="Cuci Biasa"     {{ old('jenis_layanan')=='Cuci Biasa'?'selected':'' }}>Cuci Biasa (Rp5.000/kg)</option>
                            <option value="Setrika"        {{ old('jenis_layanan')=='Setrika'?'selected':'' }}>Setrika (Rp3.000/kg)</option>
                            <option value="Express"        {{ old('jenis_layanan')=='Express'?'selected':'' }}>Express (Rp12.000/kg)</option>
                            <option value="Dry Clean"      {{ old('jenis_layanan')=='Dry Clean'?'selected':'' }}>Dry Clean (Rp20.000/kg)</option>
                        </select>
                        @error('jenis_layanan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-1">
                        <label class="form-label small">Berat (kg)</label>
                        <input class="form-control @error('berat') is-invalid @enderror"
                               name="berat" type="number" placeholder="kg" min="0.5" step="0.5"
                               value="{{ old('berat') }}" required>
                        @error('berat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small">Estimasi Selesai</label>
                        <input class="form-control @error('estimasi_selesai') is-invalid @enderror"
                               name="estimasi_selesai" type="date" value="{{ old('estimasi_selesai') }}" required>
                        @error('estimasi_selesai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button class="btn btn-success w-100">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- TABEL PESANAN --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white fw-semibold">📋 Daftar Pesanan</div>
        <div class="card-body p-0">
            @if($pesanan->isEmpty())
                <div class="text-center text-muted py-5">Belum ada pesanan. Tambahkan pesanan pertama!</div>
            @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th>Berat</th>
                            <th>Total Harga</th>
                            <th>Estimasi Selesai</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($pesanan as $i => $p)
                    <tr>
                        <td class="text-muted">{{ $i + 1 }}</td>
                        <td>
                            <div class="fw-semibold">{{ $p->nama_pelanggan }}</div>
                            <small class="text-muted">{{ $p->no_telepon }}</small>
                        </td>
                        <td>{{ $p->jenis_layanan }}</td>
                        <td>{{ $p->berat }} kg</td>
                        <td class="fw-semibold text-success">Rp{{ number_format($p->total_harga, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->estimasi_selesai)->format('d M Y') }}</td>
                        <td>
                            <form action="{{ route('pesanan.update', $p->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                                    @foreach(['menunggu', 'proses', 'selesai', 'diambil'] as $s)
                                        <option value="{{ $s }}" {{ $p->status == $s ? 'selected' : '' }}>
                                            {{ ucfirst($s) }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('pesanan.destroy', $p->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('Yakin hapus pesanan ini?')">
                                    🗑 Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
