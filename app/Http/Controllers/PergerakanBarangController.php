<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\PergerakanBarang;
use Illuminate\Http\Request;

class PergerakanBarangController extends Controller
{
    //=====================================================
    // METHOD BARANG MASUK
    //=====================================================

    /**
     * Menampilkan form untuk mencatat barang masuk.
     */
    public function createMasuk()
    {
        $barangs = Barang::orderBy('nama_barang')->get();
        return view('barang.create_masuk', compact('barangs'));
    }

    /**
     * Menyimpan data barang masuk.
     */
    public function storeMasuk(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah_masuk' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        // 2. Ambil data barang
        $barang = Barang::findOrFail($request->barang_id);

        // 3. Tambah stok barang
        $barang->jumlah += $request->jumlah_masuk;
        $barang->save();

        // 4. Catat pergerakan barang
        PergerakanBarang::create([
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah_masuk,
            'tipe' => 'masuk',
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        // 5. Kembali ke dashboard dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Berhasil mencatat barang masuk.');
    }


    //=====================================================
    // METHOD BARANG KELUAR (YANG SUDAH ADA)
    //=====================================================
    
    /**
     * Menampilkan form untuk mencatat barang keluar.
     */
    public function createKeluar()
    {
        $barangs = Barang::orderBy('nama_barang')->get();
        return view('barang.create_keluar', compact('barangs'));
    }

    /**
     * Menyimpan data barang keluar.
     */
    public function storeKeluar(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah_keluar' => [
                'required', 'integer', 'min:1',
                function ($attribute, $value, $fail) use ($request) {
                    $barang = Barang::find($request->barang_id);
                    if ($barang && $value > $barang->jumlah) {
                        $fail("Jumlah keluar melebihi stok yang ada ({$barang->jumlah}).");
                    }
                },
            ],
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        // 2. Ambil data barang
        $barang = Barang::findOrFail($request->barang_id);

        // 3. Kurangi stok barang
        $barang->jumlah -= $request->jumlah_keluar;
        $barang->save();

        // 4. Catat pergerakan barang
        PergerakanBarang::create([
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah_keluar,
            'tipe' => 'keluar',
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        // 5. Kembali ke dashboard dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Berhasil mencatat barang keluar.');
    }
}