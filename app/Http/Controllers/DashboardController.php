<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\PergerakanBarang;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // --- Statistik Kartu (Tetap Sama) ---
        $totalJenisBarang = Barang::count();
        $totalStok = Barang::sum('jumlah');
        $barangMasukBulanIni = PergerakanBarang::where('tipe', 'masuk')->whereMonth('tanggal', Carbon::now()->month)->sum('jumlah');
        $barangKeluarBulanIni = PergerakanBarang::where('tipe', 'keluar')->whereMonth('tanggal', Carbon::now()->month)->sum('jumlah');

        // --- Data untuk Grafik Batang (Baru) ---
        $labels = [];
        $dataMasuk = [];
        $dataKeluar = [];

        for ($i = 5; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);
            $labels[] = $bulan->format('M Y'); // Format: Aug 2025

            // Ambil data barang masuk per bulan
            $masuk = PergerakanBarang::where('tipe', 'masuk')
                ->whereMonth('tanggal', $bulan->month)
                ->whereYear('tanggal', $bulan->year)
                ->sum('jumlah');
            $dataMasuk[] = $masuk;

            // Ambil data barang keluar per bulan
            $keluar = PergerakanBarang::where('tipe', 'keluar')
                ->whereMonth('tanggal', $bulan->month)
                ->whereYear('tanggal', $bulan->year)
                ->sum('jumlah');
            $dataKeluar[] = $keluar;
        }

        // Ubah data menjadi format JSON untuk dikirim ke view
        $chartData = [
            'labels' => $labels,
            'dataMasuk' => $dataMasuk,
            'dataKeluar' => $dataKeluar,
        ];

        return view('dashboard', compact(
            'totalJenisBarang', 
            'totalStok', 
            'barangMasukBulanIni', 
            'barangKeluarBulanIni', 
            'chartData' // Kirim data grafik
        ));
    }
}