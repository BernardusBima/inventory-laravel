<?php

namespace App\Http\Controllers;

use App\Models\PergerakanBarang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Import facade PDF

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman laporan dengan filter.
     */
    public function index(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');
    
        // Ambil data pergerakan sesuai filter (tetap sama)
        $pergerakan = PergerakanBarang::with('barang')
                        ->when($tanggalAwal, function ($query) use ($tanggalAwal) {
                            return $query->where('tanggal', '>=', $tanggalAwal);
                        })
                        ->when($tanggalAkhir, function ($query) use ($tanggalAkhir) {
                            return $query->where('tanggal', '<=', $tanggalAkhir);
                        })
                        ->orderBy('tanggal', 'desc')
                        ->get();
    
        // 👇 LOGIKA BARU: Hitung ringkasan dari data yang sudah difilter
        $totalMasuk = $pergerakan->where('tipe', 'masuk')->sum('jumlah');
        $totalKeluar = $pergerakan->where('tipe', 'keluar')->sum('jumlah');
        $perubahanBersih = $totalMasuk - $totalKeluar;
    
        // Kirim data ringkasan ke view
        return view('laporan.index', compact(
            'pergerakan', 
            'tanggalAwal', 
            'tanggalAkhir',
            'totalMasuk',       // <-- data baru
            'totalKeluar',      // <-- data baru
            'perubahanBersih'   // <-- data baru
        ));
    }

    /**
     * Mengekspor laporan ke format PDF.
     */
    public function exportPDF(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        $pergerakan = PergerakanBarang::with('barang')
                        ->when($tanggalAwal, function ($query) use ($tanggalAwal) {
                            return $query->where('tanggal', '>=', $tanggalAwal);
                        })
                        ->when($tanggalAkhir, function ($query) use ($tanggalAkhir) {
                            return $query->where('tanggal', '<=', $tanggalAkhir);
                        })
                        ->orderBy('tanggal', 'desc')
                        ->get();

        // Load view 'laporan.pdf' dan teruskan data
        $pdf = PDF::loadView('laporan.pdf', compact('pergerakan', 'tanggalAwal', 'tanggalAkhir'));

        // Download file PDF
        return $pdf->download('laporan-pergerakan-barang-'.date('Y-m-d').'.pdf');
    }
}