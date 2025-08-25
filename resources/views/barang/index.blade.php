<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Persediaan Barang
        </h2>
    </x-slot>

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Data Barang</h4>
                @if(auth()->user()->role == 'admin')
                <a href="{{ route('barang.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle-fill"></i> Tambah Barang
                </a>
                @endif
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('barang.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama barang..." value="{{ $search ?? '' }}">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Supplier</th>
                            <th>Jumlah</th>
                            <th>Harga (Rp)</th>
                            @if(auth()->user()->role == 'admin')
                            <th class="text-center">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($barangs as $barang)
                        <tr>
                            <th>{{ $loop->iteration + $barangs->firstItem() - 1 }}</th>
                            <td>
                                <a href="{{ route('barang.show', $barang->id) }}" class="text-decoration-none">{{ $barang->nama_barang }}</a>
                            </td>
                            <td>{{ $barang->kategori->nama_kategori ?? 'N/A' }}</td>
                            <td>{{ $barang->supplier->nama_supplier ?? 'N/A' }}</td>
                            <td>{{ $barang->jumlah }}</td>
                            <td>Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                            @if(auth()->user()->role == 'admin')
                            <td class="text-center">
                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('barang.destroy', $barang->id) }}" method="POST">
                                    <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i> EDIT</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash3-fill"></i> HAPUS</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <div class="alert alert-warning mb-0">
                                        Data barang tidak ditemukan.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $barangs->appends(['search' => $search])->links() }}
            </div>
        </div>
    </div>
</x-app-layout>