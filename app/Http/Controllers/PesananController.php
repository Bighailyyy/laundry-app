<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    /**
     * Menampilkan semua pesanan menggunakan Eloquent with() untuk eager loading relasi.
     * Menggunakan: Eloquent::latest(), ::with(), ::where()
     */
    public function index(Request $request)
    {
        // Eager loading relasi pelanggan & layanan (menghindari N+1 query)
        $query = Pesanan::with(['pelanggan', 'layanan'])->latest();

        // Filter berdasarkan status menggunakan where()
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan pencarian nama pelanggan (relasi)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('pelanggan', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            });
        }

        $pesanans = $query->get();

        $stats = [
            'total'      => Pesanan::count(),
            'menunggu'   => Pesanan::where('status', 'menunggu')->count(),
            'proses'     => Pesanan::where('status', 'proses')->count(),
            'selesai'    => Pesanan::where('status', 'selesai')->count(),
            'pendapatan' => Pesanan::where('status', '!=', 'menunggu')->sum('total_harga'),
        ];

        $layanans = Layanan::all();

        return view('pesanan.index', compact('pesanans', 'stats', 'layanans'));
    }

    /**
     * Form tambah pesanan baru
     */
    public function create()
    {
        $pelanggans = Pelanggan::orderBy('nama')->get();
        $layanans   = Layanan::orderBy('nama_layanan')->get();
        return view('pesanan.create', compact('pelanggans', 'layanans'));
    }

    /**
     * Menyimpan pesanan baru menggunakan Eloquent::create()
     */
    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id'     => 'required|exists:pelanggans,id',
            'layanan_id'       => 'required|exists:layanans,id',
            'berat'            => 'required|numeric|min:0.5',
            'estimasi_selesai' => 'required|date|after_or_equal:today',
            'catatan'          => 'nullable|string|max:255',
        ]);

        // Ambil harga dari model Layanan menggunakan find()
        $layanan = Layanan::find($request->layanan_id);

        // Simpan menggunakan Eloquent create()
        Pesanan::create([
            'pelanggan_id'     => $request->pelanggan_id,
            'layanan_id'       => $request->layanan_id,
            'berat'            => $request->berat,
            'total_harga'      => $layanan->harga_per_kg * $request->berat,
            'estimasi_selesai' => $request->estimasi_selesai,
            'status'           => 'menunggu',
            'catatan'          => $request->catatan,
        ]);

        return redirect()->route('pesanan.index')
            ->with('success', 'Pesanan berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail satu pesanan menggunakan Eloquent find() dengan relasi
     */
    public function show(Pesanan $pesanan)
    {
        // Eager load relasi untuk detail view
        $pesanan->load(['pelanggan', 'layanan']);

        // Ambil riwayat pesanan pelanggan yang sama menggunakan where()
        $riwayat = Pesanan::where('pelanggan_id', $pesanan->pelanggan_id)
            ->where('id', '!=', $pesanan->id)
            ->with('layanan')
            ->latest()
            ->take(5)
            ->get();

        return view('pesanan.show', compact('pesanan', 'riwayat'));
    }

    /**
     * Form edit pesanan
     */
    public function edit(Pesanan $pesanan)
    {
        $pesanan->load(['pelanggan', 'layanan']);
        $pelanggans = Pelanggan::orderBy('nama')->get();
        $layanans   = Layanan::orderBy('nama_layanan')->get();
        return view('pesanan.edit', compact('pesanan', 'pelanggans', 'layanans'));
    }

    /**
     * Memperbarui pesanan menggunakan Eloquent update()
     */
    public function update(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'pelanggan_id'     => 'required|exists:pelanggans,id',
            'layanan_id'       => 'required|exists:layanans,id',
            'berat'            => 'required|numeric|min:0.5',
            'estimasi_selesai' => 'required|date',
            'status'           => 'required|in:menunggu,proses,selesai,diambil',
            'catatan'          => 'nullable|string|max:255',
        ]);

        $layanan = Layanan::find($request->layanan_id);

        // Update menggunakan Eloquent update()
        $pesanan->update([
            'pelanggan_id'     => $request->pelanggan_id,
            'layanan_id'       => $request->layanan_id,
            'berat'            => $request->berat,
            'total_harga'      => $layanan->harga_per_kg * $request->berat,
            'estimasi_selesai' => $request->estimasi_selesai,
            'status'           => $request->status,
            'catatan'          => $request->catatan,
        ]);

        return redirect()->route('pesanan.show', $pesanan)
            ->with('success', 'Pesanan berhasil diperbarui!');
    }

    /**
     * Menghapus pesanan menggunakan Eloquent delete()
     */
    public function destroy(Pesanan $pesanan)
    {
        // Soft delete menggunakan Eloquent delete()
        $pesanan->delete();

        return redirect()->route('pesanan.index')
            ->with('success', 'Pesanan #' . $pesanan->id . ' berhasil dihapus.');
    }

    /**
     * Update status cepat (AJAX-friendly)
     */
    public function updateStatus(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'status' => 'required|in:menunggu,proses,selesai,diambil',
        ]);

        $pesanan->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pesanan diperbarui!');
    }
}
