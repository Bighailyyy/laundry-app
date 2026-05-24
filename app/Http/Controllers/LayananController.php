<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index()
    {
        $layanans = Layanan::withCount('pesanans')->latest()->get();
        return view('layanan.index', compact('layanans'));
    }

    public function create()
    {
        return view('layanan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:100|unique:layanans',
            'harga_per_kg' => 'required|numeric|min:1000',
            'deskripsi'    => 'nullable|string|max:255',
        ]);

        Layanan::create($request->only(['nama_layanan', 'harga_per_kg', 'deskripsi']));

        return redirect()->route('layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan!');
    }

    public function edit(Layanan $layanan)
    {
        return view('layanan.edit', compact('layanan'));
    }

    public function update(Request $request, Layanan $layanan)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:100|unique:layanans,nama_layanan,' . $layanan->id,
            'harga_per_kg' => 'required|numeric|min:1000',
            'deskripsi'    => 'nullable|string|max:255',
        ]);

        $layanan->update($request->only(['nama_layanan', 'harga_per_kg', 'deskripsi']));

        return redirect()->route('layanan.index')
            ->with('success', 'Layanan berhasil diperbarui!');
    }

    public function destroy(Layanan $layanan)
    {
        $layanan->delete();
        return redirect()->route('layanan.index')
            ->with('success', 'Layanan berhasil dihapus.');
    }
}
