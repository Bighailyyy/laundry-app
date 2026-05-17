<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::latest()->get();
        $stats = [
            'total'      => $pesanan->count(),
            'menunggu'   => $pesanan->where('status', 'menunggu')->count(),
            'proses'     => $pesanan->where('status', 'proses')->count(),
            'pendapatan' => $pesanan->sum('total_harga'),
        ];
        return view('pesanan.index', compact('pesanan', 'stats'));
    }

    public function store(Request $request)
    {
        $harga = [
            'Cuci + Setrika' => 7000,
            'Cuci Biasa'     => 5000,
            'Setrika'        => 3000,
            'Express'        => 12000,
            'Dry Clean'      => 20000,
        ];

        $request->validate([
            'nama_pelanggan'   => 'required|string|max:100',
            'no_telepon'       => 'required|string|max:20',
            'jenis_layanan'    => 'required|string',
            'berat'            => 'required|numeric|min:0.5',
            'estimasi_selesai' => 'required|date',
        ]);

        Pesanan::create([
            'nama_pelanggan'   => $request->nama_pelanggan,
            'no_telepon'       => $request->no_telepon,
            'jenis_layanan'    => $request->jenis_layanan,
            'berat'            => $request->berat,
            'total_harga'      => ($harga[$request->jenis_layanan] ?? 0) * $request->berat,
            'estimasi_selesai' => $request->estimasi_selesai,
            'status'           => $request->status ?? 'menunggu',
        ]);

        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil ditambahkan!');
    }

    public function update(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'status' => 'required|in:menunggu,proses,selesai,diambil',
        ]);

        $pesanan->update(['status' => $request->status]);

        return redirect()->route('pesanan.index')->with('success', 'Status diperbarui!');
    }

    public function destroy(Pesanan $pesanan)
    {
        $pesanan->delete();
        return redirect()->route('pesanan.index')->with('success', 'Pesanan dihapus.');
    }
}
