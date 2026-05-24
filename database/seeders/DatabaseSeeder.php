<?php

namespace Database\Seeders;

use App\Models\Layanan;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Layanan
        $layanans = [
            ['nama_layanan' => 'Cuci + Setrika', 'harga_per_kg' => 7000,  'deskripsi' => 'Cuci dan setrika pakaian hingga rapi'],
            ['nama_layanan' => 'Cuci Biasa',     'harga_per_kg' => 5000,  'deskripsi' => 'Cuci pakaian tanpa setrika'],
            ['nama_layanan' => 'Setrika',         'harga_per_kg' => 3000,  'deskripsi' => 'Hanya setrika pakaian'],
            ['nama_layanan' => 'Express',         'harga_per_kg' => 12000, 'deskripsi' => 'Layanan kilat selesai dalam 5 jam'],
            ['nama_layanan' => 'Dry Clean',       'harga_per_kg' => 20000, 'deskripsi' => 'Cuci kering untuk bahan halus'],
        ];

        foreach ($layanans as $l) {
            Layanan::create($l);
        }

        // Seed Pelanggan
        $pelanggans = [
            ['nama' => 'Budi Santoso',   'no_telepon' => '081234567890', 'alamat' => 'Jl. Merdeka No. 10, Medan'],
            ['nama' => 'Siti Rahayu',    'no_telepon' => '082345678901', 'alamat' => 'Jl. Sudirman No. 5, Medan'],
            ['nama' => 'Ahmad Fauzi',    'no_telepon' => '083456789012', 'alamat' => 'Jl. Gatot Subroto No. 3, Medan'],
            ['nama' => 'Dewi Lestari',   'no_telepon' => '084567890123', 'alamat' => 'Jl. Imam Bonjol No. 7, Medan'],
            ['nama' => 'Rian Pratama',   'no_telepon' => '085678901234', 'alamat' => 'Jl. Diponegoro No. 15, Medan'],
        ];

        foreach ($pelanggans as $p) {
            Pelanggan::create($p);
        }

        // Seed Pesanan
        $statusList = ['menunggu', 'proses', 'selesai', 'diambil'];
        $layananAll = Layanan::all();
        $pelangganAll = Pelanggan::all();

        $samplePesanans = [
            ['pelanggan_id' => 1, 'layanan_id' => 1, 'berat' => 3.5, 'estimasi_selesai' => '2026-05-25', 'status' => 'menunggu', 'catatan' => ''],
            ['pelanggan_id' => 2, 'layanan_id' => 4, 'berat' => 2.0, 'estimasi_selesai' => '2026-05-24', 'status' => 'proses',   'catatan' => 'Harap cepat'],
            ['pelanggan_id' => 3, 'layanan_id' => 2, 'berat' => 5.0, 'estimasi_selesai' => '2026-05-26', 'status' => 'selesai',  'catatan' => ''],
            ['pelanggan_id' => 4, 'layanan_id' => 5, 'berat' => 1.5, 'estimasi_selesai' => '2026-05-23', 'status' => 'diambil',  'catatan' => 'Bahan sutra'],
            ['pelanggan_id' => 1, 'layanan_id' => 3, 'berat' => 4.0, 'estimasi_selesai' => '2026-05-27', 'status' => 'menunggu', 'catatan' => ''],
            ['pelanggan_id' => 5, 'layanan_id' => 1, 'berat' => 2.5, 'estimasi_selesai' => '2026-05-28', 'status' => 'proses',   'catatan' => ''],
        ];

        foreach ($samplePesanans as $p) {
            $layanan = Layanan::find($p['layanan_id']);
            Pesanan::create([
                'pelanggan_id'     => $p['pelanggan_id'],
                'layanan_id'       => $p['layanan_id'],
                'berat'            => $p['berat'],
                'total_harga'      => $layanan->harga_per_kg * $p['berat'],
                'estimasi_selesai' => $p['estimasi_selesai'],
                'status'           => $p['status'],
                'catatan'          => $p['catatan'],
            ]);
        }
    }
}
