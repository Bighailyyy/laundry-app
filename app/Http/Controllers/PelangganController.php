<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Menampilkan semua pelanggan beserta jumlah pesanannya (relasi HasMany)
     * Menggunakan: Eloquent::withCount(), ::latest()
     */
    public function index()
    {
        // withCount() untuk menghitung relasi tanpa N+1 problem
        $pelanggans = Pelanggan::withCount('pesanans')
            ->with(['pesanans' => function ($q) {
                $q->latest()->take(1);
            }])
            ->latest()
            ->get();

        return view('pelanggan.index', compact('pelanggans'));
    }

    /**
     * Form tambah pelanggan baru
     */
    public function create()
    {
        return view('pelanggan.create');
    }

    /**
     * Simpan pelanggan baru menggunakan Eloquent create()
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'       => 'required|string|max:100',
            'no_telepon' => 'required|string|max:20',
            'alamat'     => 'nullable|string|max:255',
        ]);

        Pelanggan::create($request->only(['nama', 'no_telepon', 'alamat']));

        return redirect()->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    /**
     * Detail pelanggan + riwayat pesanan (menampilkan relasi)
     * Menggunakan: find() + with()
     */
    public function show(Pelanggan $pelanggan)
    {
        // Eager load pesanan beserta layanannya (relasi nested)
        $pelanggan->load(['pesanans.layanan']);

        $stats = [
            'total'      => $pelanggan->pesanans->count(),
            'total_harga'=> $pelanggan->pesanans->sum('total_harga'),
            'selesai'    => $pelanggan->pesanans->where('status', 'selesai')->count(),
        ];

        return view('pelanggan.show', compact('pelanggan', 'stats'));
    }

    /**
     * Form edit pelanggan
     */
    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggan.edit', compact('pelanggan'));
    }

    /**
     * Update pelanggan menggunakan Eloquent update()
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $request->validate([
            'nama'       => 'required|string|max:100',
            'no_telepon' => 'required|string|max:20',
            'alamat'     => 'nullable|string|max:255',
        ]);

        $pelanggan->update($request->only(['nama', 'no_telepon', 'alamat']));

        return redirect()->route('pelanggan.show', $pelanggan)
            ->with('success', 'Data pelanggan diperbarui!');
    }

    /**
     * Hapus pelanggan menggunakan Eloquent delete()
     */
    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil dihapus.');
    }
}
