<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesananController;

Route::get('/', [PesananController::class, 'index'])->name('pesanan.index');
Route::post('/pesanan', [PesananController::class, 'store'])->name('pesanan.store');
Route::put('/pesanan/{pesanan}', [PesananController::class, 'update'])->name('pesanan.update');
Route::delete('/pesanan/{pesanan}', [PesananController::class, 'destroy'])->name('pesanan.destroy');
