@extends('layouts.app')
@section('title', 'Data Pelanggan')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0"><i class="bi bi-people me-2 text-primary"></i>Data Pelanggan</h4>
        <small class="text-muted"></small>
    </div>
    <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus me-1"></i>Tambah Pelanggan
    </a>
</div>
<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>#</th><th>Nama</th><th>No. Telepon</th><th>Alamat</th><th>Jml Pesanan</th><th class="text-end">Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($pelanggans as $pl)
                <tr>
                    <td class="text-muted small">{{ $pl->id }}</td>
                    <td><div class="fw-semibold">{{ $pl->nama }}</div></td>
                    <td>{{ $pl->no_telepon }}</td>
                    <td class="text-muted small">{{ $pl->alamat ?? '-' }}</td>
                    <td>
                        {{-- Menggunakan withCount() — relasi HasMany --}}
                        <span class="badge bg-primary">{{ $pl->pesanans_count }} pesanan</span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('pelanggan.show', $pl) }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('pelanggan.edit', $pl) }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('pelanggan.destroy', $pl) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus pelanggan ini beserta semua pesanannya?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-5">Belum ada pelanggan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
