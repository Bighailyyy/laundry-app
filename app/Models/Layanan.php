<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Layanan extends Model
{
    protected $table = 'layanans';

    protected $fillable = [
        'nama_layanan',
        'harga_per_kg',
        'deskripsi',
    ];

    // Relasi: satu layanan digunakan di banyak pesanan
    public function pesanans(): HasMany
    {
        return $this->hasMany(Pesanan::class, 'layanan_id');
    }
}
