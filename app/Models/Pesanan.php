<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $fillable = [
        'nama_pelanggan',
        'no_telepon',
        'jenis_layanan',
        'berat',
        'total_harga',
        'estimasi_selesai',
        'status',
    ];

    protected $table = 'pesanans';
}
