<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan Pergerakan Barang
        </h2>
    </x-slot>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h4 class="mb-0">Filter Laporan</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('laporan.index') }}" method="GET" class="row g-3">
                <div class="col-md-5">
                    <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                    <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" value="{{ $tanggalAwal }}">
                </div>
                <div class="col-md-5">
                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                    <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="{{ $tanggalAkhir }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100 me-2">Filter</button>
                    <a href="{{ route('laporan.export', request()->query()) }}" class="btn btn-success w-100" target="_blank">Export</a>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center text-white bg-info shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Masuk (Periode Ini)</h5>
                    <p class="fs-2 fw-bold">{{ $totalMasuk }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center text-white bg-warning shadow">
                <div class="card-body">
                    <h5 class="card-title">Total Keluar (Periode Ini)</h5>
                    <p class="fs-2 fw-bold">{{ $totalKeluar }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center text-white {{ $perubahanBersih >= 0 ? 'bg-success' : 'bg-danger' }} shadow">
                <div class="card-body">
                    <h5 class="card-title">Perubahan Stok Bersih</h5>
                    <p class="fs-2 fw-bold">{{ $perubahanBersih > 0 ? '+' : '' }}{{ $perubahanBersih }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h4 class="mb-0">Hasil Laporan</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Tipe</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pergerakan as $item)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                                <td>{{ $item->barang->nama_barang }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>
                                    @if($item->tipe == 'masuk')
                                        <span class="badge bg-success">Masuk</span>
                                    @else
                                        <span class="badge bg-danger">Keluar</span>
                                    @endif
                                </td>
                                <td>{{ $item->keterangan }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data untuk ditampilkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>