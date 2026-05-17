<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggan');
            $table->string('no_telepon');
            $table->string('jenis_layanan');
            $table->decimal('berat', 5, 2);
            $table->decimal('total_harga', 10, 2);
            $table->date('estimasi_selesai');
            $table->enum('status', ['menunggu', 'proses', 'selesai', 'diambil'])->default('menunggu');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pesanans');
    }
};
