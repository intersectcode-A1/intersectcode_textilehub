@extends('components.layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto mt-10 p-6 bg-white dark:bg-gray-800 shadow rounded-lg">
    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Laporan Keuangan & Analisis Penjualan</h2>
        
        <!-- Tab Navigation -->
        <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button onclick="showTab('laporan')" class="tab-button border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Laporan Keuangan
                </button>
                <button onclick="showTab('analisis')" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Analisis Penjualan
                </button>
            </nav>
        </div>
    </div>

    <!-- Laporan Keuangan Tab -->
    <div id="laporan-tab" class="tab-content">
        <form method="POST" action="{{ route('laporan.filter') }}" class="mb-6 space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-200">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="border border-gray-600 dark:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 p-2 w-full rounded" required>
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-200">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" class="border border-gray-600 dark:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 p-2 w-full rounded" required>
                </div>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">Tampilkan</button>
        </form>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 dark:bg-red-200 dark:text-red-800">{{ $errors->first() }}</div>
        @endif

        @if(isset($laporan))
            @if($laporan->isEmpty())
                <p class="text-gray-500 dark:text-gray-300">⚠️ Tidak ada data dalam rentang waktu yang dipilih.</p>
            @else
                <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
                    <table class="w-full table-auto text-left border border-gray-600 dark:border-gray-500 mt-4">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-sm uppercase text-gray-600 dark:text-gray-300">
                            <tr>
                                <th class="px-4 py-3 border border-gray-600 dark:border-gray-500">Tanggal</th>
                                <th class="px-4 py-3 border border-gray-600 dark:border-gray-500">Deskripsi</th>
                                <th class="px-4 py-3 border border-gray-600 dark:border-gray-500">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($laporan as $item)
                                <tr class="border border-gray-600 dark:border-gray-500">
                                    <td class="px-4 py-2 border border-gray-600 dark:border-gray-500">{{ $item->tanggal }}</td>
                                    <td class="px-4 py-2 border border-gray-600 dark:border-gray-500">{{ $item->deskripsi }}</td>
                                    <td class="px-4 py-2 border border-gray-600 dark:border-gray-500">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        @endif
    </div>

    <!-- Analisis Penjualan Tab -->
    <div id="analisis-tab" class="tab-content hidden">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Statistik Card -->
            <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">Total Penjualan</h3>
                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">Rp {{ number_format($totalPenjualan ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">Jumlah Transaksi</h3>
                <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $jumlahTransaksi ?? 0 }}</p>
            </div>
            <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">Rata-rata Transaksi</h3>
                <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">Rp {{ number_format($rataRataTransaksi ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Grafik -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Grafik Penjualan Harian</h3>
                <canvas id="penjualanHarianChart"></canvas>
            </div>
            <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Grafik Kategori Produk</h3>
                <canvas id="kategoriProdukChart"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });
    
    // Show selected tab content
    document.getElementById(tabName + '-tab').classList.remove('hidden');
    
    // Update tab button styles
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Style active tab button
    event.target.classList.remove('border-transparent', 'text-gray-500');
    event.target.classList.add('border-blue-500', 'text-blue-600');
}

// Inisialisasi grafik saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    // Data untuk grafik penjualan harian
    const ctxHarian = document.getElementById('penjualanHarianChart').getContext('2d');
    new Chart(ctxHarian, {
        type: 'line',
        data: {
            labels: {!! json_encode($labelsHarian ?? []) !!},
            datasets: [{
                label: 'Penjualan Harian',
                data: {!! json_encode($dataHarian ?? []) !!},
                borderColor: 'rgb(59, 130, 246)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });

    // Data untuk grafik kategori produk
    const ctxKategori = document.getElementById('kategoriProdukChart').getContext('2d');
    new Chart(ctxKategori, {
        type: 'pie',
        data: {
            labels: {!! json_encode($labelsKategori ?? []) !!},
            datasets: [{
                data: {!! json_encode($dataKategori ?? []) !!},
                backgroundColor: [
                    'rgb(59, 130, 246)',
                    'rgb(16, 185, 129)',
                    'rgb(245, 158, 11)',
                    'rgb(239, 68, 68)',
                    'rgb(139, 92, 246)'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                }
            }
        }
    });
});
</script>
@endpush
@endsection
