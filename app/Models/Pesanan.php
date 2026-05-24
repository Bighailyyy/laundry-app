<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pesanan extends Model
{
    protected $table = 'pesanans';

    protected $fillable = [
        'pelanggan_id',
        'layanan_id',
        'berat',
        'total_harga',
        'estimasi_selesai',
        'status',
        'catatan',
    ];

    protected $casts = [
        'estimasi_selesai' => 'date',
        'berat'            => 'float',
        'total_harga'      => 'float',
    ];

    // Relasi: pesanan milik satu pelanggan
    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    // Relasi: pesanan menggunakan satu jenis layanan
    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }

    // Scope: filter berdasarkan status
    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    // Accessor: label warna status untuk badge Bootstrap
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'menunggu' => 'warning',
            'proses'   => 'primary',
            'selesai'  => 'success',
            'diambil'  => 'secondary',
            default    => 'light',
        };
    }
}
