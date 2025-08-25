<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Barang: {{ $barang->nama_barang }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header bg-white"><h4 class="mb-0">Informasi Detail</h4></div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Nama Barang</dt>
                        <dd class="col-sm-8">{{ $barang->nama_barang }}</dd>

                        <dt class="col-sm-4">Kategori</dt>
                        <dd class="col-sm-8">{{ $barang->kategori->nama_kategori ?? 'N/A' }}</dd>

                        <dt class="col-sm-4">Supplier</dt>
                        <dd class="col-sm-8">{{ $barang->supplier->nama_supplier ?? 'N/A' }}</dd>

                        <dt class="col-sm-4">Stok Saat Ini</dt>
                        <dd class="col-sm-8"><span class="badge bg-primary fs-6">{{ $barang->jumlah }}</span></dd>

                        <dt class="col-sm-4">Harga</dt>
                        <dd class="col-sm-8">Rp {{ number_format($barang->harga, 0, ',', '.') }}</dd>

                        <dt class="col-sm-4">Tgl. Dibuat</dt>
                        <dd class="col-sm-8">{{ $barang->tanggal_masuk ? \Carbon\Carbon::parse($barang->tanggal_masuk)->format('d M Y') : 'N/A' }}</dd>
                    </dl>
                    <a href="{{ route('barang.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar</a>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-header bg-white"><h4 class="mb-0">Riwayat Pergerakan</h4></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Tipe</th>
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayat as $item)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                                    <td>
                                        @if($item->tipe == 'masuk')
                                            <span class="badge bg-success">Masuk</span>
                                        @else
                                            <span class="badge bg-danger">Keluar</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>{{ $item->keterangan }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada riwayat pergerakan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $riwayat->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>