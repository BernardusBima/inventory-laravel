<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\PergerakanBarang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
    
        $barangs = Barang::with(['kategori', 'supplier'])
                    ->when($search, function ($query, $search) {
                        return $query->where('nama_barang', 'like', '%' . $search . '%');
                    })
                    ->latest()
                    ->paginate(10); // Kita ubah menjadi paginate agar lebih rapi
    
        return view('barang.index', compact('barangs', 'search'));
    }

    public function store(Request $request)
    {
        // Validasi dengan field baru
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'required|numeric',
            'tanggal_masuk' => 'required|date',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
        ]);

        $barang = Barang::create($request->all());

        PergerakanBarang::create([
            'barang_id' => $barang->id,
            'jumlah' => $request->jumlah,
            'tipe' => 'masuk',
            'tanggal' => $request->tanggal_masuk,
            'keterangan' => 'Stok awal'
        ]);

        return redirect()->route('barang.index')
                         ->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show(Barang $barang)
{
    // Ambil riwayat pergerakan untuk barang ini saja
    $riwayat = PergerakanBarang::where('barang_id', $barang->id)
                                ->orderBy('tanggal', 'desc')
                                ->paginate(10);

    return view('barang.show', compact('barang', 'riwayat'));
}

    public function edit(Barang $barang)
    {
        // Ambil data untuk dropdown
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $suppliers = Supplier::orderBy('nama_supplier')->get();
        return view('barang.edit', compact('barang', 'kategoris', 'suppliers'));
    }

    public function update(Request $request, Barang $barang)
    {
        // Validasi dengan field baru
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer',
            'harga' => 'required|numeric',
            'tanggal_masuk' => 'required|date',
            'kategori_id' => 'nullable|exists:kategoris,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
        ]);

        $barang->update($request->all());

        return redirect()->route('barang.index')
                         ->with('success', 'Data barang berhasil diupdate.');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect()->route('barang.index')
                         ->with('success', 'Barang berhasil dihapus.');
    }
}