<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-primary shadow">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-box-seam me-2"></i>Total Jenis Barang</h5>
                    <p class="card-text fs-2 fw-bold">{{ $totalJenisBarang }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-success shadow">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-boxes me-2"></i>Total Stok Barang</h5>
                    <p class="card-text fs-2 fw-bold">{{ $totalStok }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-info shadow">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-arrow-down-square-fill me-2"></i>Barang Masuk (Bulan Ini)</h5>
                    <p class="card-text fs-2 fw-bold">{{ $barangMasukBulanIni }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-warning shadow">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-arrow-up-square-fill me-2"></i>Barang Keluar (Bulan Ini)</h5>
                    <p class="card-text fs-2 fw-bold">{{ $barangKeluarBulanIni }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Grafik Pergerakan Barang (6 Bulan Terakhir)</h4>
                </div>
                <div class="card-body">
                    <canvas id="pergerakanBarangChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Ambil data dari controller yang sudah di-encode ke JSON
        const chartData = @json($chartData);

        const ctx = document.getElementById('pergerakanBarangChart');
        new Chart(ctx, {
            type: 'bar', // Tipe grafik
            data: {
                labels: chartData.labels, // Label sumbu X (bulan)
                datasets: [{
                    label: 'Barang Masuk',
                    data: chartData.dataMasuk,
                    backgroundColor: 'rgba(40, 167, 69, 0.5)', // Hijau
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 1
                }, {
                    label: 'Barang Keluar',
                    data: chartData.dataKeluar,
                    backgroundColor: 'rgba(255, 193, 7, 0.5)', // Kuning
                    borderColor: 'rgba(255, 193, 7, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>