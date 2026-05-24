<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelanggan extends Model
{
    protected $table = 'pelanggans';

    protected $fillable = [
        'nama',
        'no_telepon',
        'alamat',
    ];

    // Relasi: satu pelanggan memiliki banyak pesanan
    public function pesanans(): HasMany
    {
        return $this->hasMany(Pesanan::class, 'pelanggan_id');
    }

    // Accessor: total pesanan pelanggan
    public function getTotalPesananAttribute(): int
    {
        return $this->pesanans()->count();
    }
}
