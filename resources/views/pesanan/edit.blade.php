@extends('layouts.app')
@section('title', 'Edit Pesanan #' . $pesanan->id)
@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('pesanan.show', $pesanan) }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
    <div>
        <h4 class="fw-bold mb-0">Edit Pesanan #{{ $pesanan->id }}</h4>
        <small class="text-muted"></small>
    </div>
</div>
<div class="card shadow-sm" style="max-width:700px">
    <div class="card-body p-4">
        <form action="{{ route('pesanan.update', $pesanan) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold">Pelanggan</label>
                <select name="pelanggan_id" class="form-select @error('pelanggan_id') is-invalid @enderror" required>
                    @foreach($pelanggans as $pl)
                        <option value="{{ $pl->id }}" {{ (old('pelanggan_id', $pesanan->pelanggan_id)) == $pl->id ? 'selected' : '' }}>
                            {{ $pl->nama }} ({{ $pl->no_telepon }})
                        </option>
                    @endforeach
                </select>
                @error('pelanggan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Jenis Layanan</label>
                <select name="layanan_id" id="layananSelect" class="form-select @error('layanan_id') is-invalid @enderror" required>
                    @foreach($layanans as $l)
                        <option value="{{ $l->id }}" data-harga="{{ $l->harga_per_kg }}"
                            {{ (old('layanan_id', $pesanan->layanan_id)) == $l->id ? 'selected' : '' }}>
                            {{ $l->nama_layanan }} — Rp{{ number_format($l->harga_per_kg,0,',','.') }}/kg
                        </option>
                    @endforeach
                </select>
                @error('layanan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Berat (kg)</label>
                    <input type="number" name="berat" id="beratInput" step="0.5" min="0.5"
                        class="form-control @error('berat') is-invalid @enderror"
                        value="{{ old('berat', $pesanan->berat) }}" required>
                    @error('berat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Est. Selesai</label>
                    <input type="date" name="estimasi_selesai"
                        class="form-control @error('estimasi_selesai') is-invalid @enderror"
                        value="{{ old('estimasi_selesai', $pesanan->estimasi_selesai->format('Y-m-d')) }}" required>
                    @error('estimasi_selesai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        @foreach(['menunggu','proses','selesai','diambil'] as $s)
                            <option value="{{ $s }}" {{ old('status', $pesanan->status) == $s ? 'selected' : '' }}>
                                {{ ucfirst($s) }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Catatan</label>
                <input type="text" name="catatan" class="form-control" value="{{ old('catatan', $pesanan->catatan) }}">
            </div>
            <div class="alert alert-light border mb-3">
                <strong>Total Baru:</strong>
                <span id="estimasiTotal" class="fs-5 fw-bold text-success ms-2">—</span>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan Perubahan</button>
                <a href="{{ route('pesanan.show', $pesanan) }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
function hitungTotal() {
    const sel = document.getElementById('layananSelect');
    const berat = parseFloat(document.getElementById('beratInput').value) || 0;
    const harga = parseFloat(sel.options[sel.selectedIndex]?.dataset?.harga) || 0;
    const total = harga * berat;
    document.getElementById('estimasiTotal').textContent =
        total > 0 ? 'Rp ' + total.toLocaleString('id-ID') : '—';
}
document.getElementById('layananSelect').addEventListener('change', hitungTotal);
document.getElementById('beratInput').addEventListener('input', hitungTotal);
hitungTotal();
</script>
@endsection
