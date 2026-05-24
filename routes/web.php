<?php

use App\Http\Controllers\LayananController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PesananController;
use Illuminate\Support\Facades\Route;

// Redirect root ke pesanan
Route::get('/', fn() => redirect()->route('pesanan.index'));

// Resource routes: Pesanan (CRUD lengkap)
Route::resource('pesanan', PesananController::class);
Route::patch('/pesanan/{pesanan}/status', [PesananController::class, 'updateStatus'])
    ->name('pesanan.updateStatus');

// Resource routes: Pelanggan (CRUD lengkap)
Route::resource('pelanggan', PelangganController::class);

// Resource routes: Layanan (CRUD lengkap)
Route::resource('layanan', LayananController::class);
