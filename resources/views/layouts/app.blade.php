<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BersihKilat Laundry')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f0f4f8; }
        .sidebar { min-height: 100vh; background: #1a237e; width: 230px; flex-shrink: 0; }
        .sidebar .nav-link { color: rgba(255,255,255,.75); border-radius: 8px; margin: 2px 8px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #fff; background: rgba(255,255,255,.15); }
        .brand { font-weight: 800; font-size: 1.2rem; color: #fff; padding: 1.2rem 1rem; border-bottom: 1px solid rgba(255,255,255,.1); }
        .main-content { min-height: 100vh; flex-grow: 1; padding: 1.5rem; }
        .card { border: none; border-radius: 12px; }
        .badge-menunggu  { background-color: #ffc107!important; color: #000!important; }
        .badge-proses    { background-color: #0d6efd!important; color: #fff!important; }
        .badge-selesai   { background-color: #198754!important; color: #fff!important; }
        .badge-diambil   { background-color: #6c757d!important; color: #fff!important; }
        .table th { font-size: .8rem; text-transform: uppercase; letter-spacing: .5px; color: #6c757d; }
    </style>
</head>
<body>
<div class="d-flex">
    <div class="sidebar d-flex flex-column">
        <div class="brand">🧺 BersihKilat</div>
        <nav class="nav flex-column pt-2 flex-grow-1">
            <a class="nav-link py-2 {{ request()->routeIs('pesanan.*') ? 'active' : '' }}"
               href="{{ route('pesanan.index') }}">
                <i class="bi bi-receipt me-2"></i>Pesanan
            </a>
            <a class="nav-link py-2 {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}"
               href="{{ route('pelanggan.index') }}">
                <i class="bi bi-people me-2"></i>Pelanggan
            </a>
            <a class="nav-link py-2 {{ request()->routeIs('layanan.*') ? 'active' : '' }}"
               href="{{ route('layanan.index') }}">
                <i class="bi bi-tags me-2"></i>Layanan
            </a>
        </nav>
        <div class="p-3 text-white-50 small border-top border-white border-opacity-10">
            Laundry v2.0 &bull; Eloquent ORM
        </div>
    </div>

    <div class="main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
