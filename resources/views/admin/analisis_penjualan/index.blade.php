@extends('components.layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto mt-10 p-6 bg-white dark:bg-gray-800 shadow rounded-lg">
    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Analisis Penjualan</h2>
        
        <!-- Filter Periode -->
        <div class="mb-6">
            <form method="GET" action="{{ route('admin.sales.analysis') }}" class="flex gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Periode</label>
                    <select name="period" class="border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="7">7 Hari Terakhir</option>
                        <option value="30">30 Hari Terakhir</option>
                        <option value="90">3 Bulan Terakhir</option>
                        <option value="365">1 Tahun Terakhir</option>
                    </select>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow-sm">
                    Terapkan
                </button>
            </form>
        </div>
    </div>

    <!-- Statistik Utama -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Penjualan</p>
                    <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">Rp {{ number_format($totalPenjualan ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-green-600 dark:text-green-400">
                    <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    {{ number_format($persentasePertumbuhan ?? 0, 1) }}%
                </span>
                <span class="text-sm text-gray-600 dark:text-gray-400 ml-2">dari periode sebelumnya</span>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Jumlah Transaksi</p>
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $jumlahTransaksi ?? 0 }}</p>
                </div>
                <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-green-600 dark:text-green-400">
                    <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    {{ number_format($persentaseTransaksi ?? 0, 1) }}%
                </span>
                <span class="text-sm text-gray-600 dark:text-gray-400 ml-2">dari periode sebelumnya</span>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Rata-rata Transaksi</p>
                    <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">Rp {{ number_format($rataRataTransaksi ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-full">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-sm text-green-600 dark:text-green-400">
                    <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    {{ number_format($persentaseRataRata ?? 0, 1) }}%
                </span>
                <span class="text-sm text-gray-600 dark:text-gray-400 ml-2">dari periode sebelumnya</span>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Produk Terlaris</p>
                    <p class="text-lg font-bold text-orange-600 dark:text-orange-400">{{ $produkTerlaris ?? '-' }}</p>
                </div>
                <div class="p-3 bg-orange-100 dark:bg-orange-900 rounded-full">
                    <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $jumlahTerjual ?? 0 }} unit terjual</p>
            </div>
        </div>
    </div>

    <!-- Grafik dan Analisis -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Grafik Penjualan -->
        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Tren Penjualan</h3>
            <canvas id="penjualanChart" height="300"></canvas>
        </div>

        <!-- Grafik Kategori -->
        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Penjualan per Kategori</h3>
            <canvas id="kategoriChart" height="300"></canvas>
        </div>
    </div>

    <!-- Tabel Produk Terlaris -->
    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Produk Terlaris</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 dark:bg-gray-800 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3 bg-gray-50 dark:bg-gray-800 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 bg-gray-50 dark:bg-gray-800 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Terjual</th>
                        <th class="px-6 py-3 bg-gray-50 dark:bg-gray-800 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Penjualan</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                    @foreach($produkTerlaris ?? [] as $produk)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $produk->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $produk->kategori }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $produk->jumlah_terjual }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">Rp {{ number_format($produk->total_penjualan, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Konfigurasi tooltip untuk format mata uang
    const formatCurrency = (value) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(value);
    };

    // Grafik Tren Penjualan
    const ctxPenjualan = document.getElementById('penjualanChart').getContext('2d');
    new Chart(ctxPenjualan, {
        type: 'line',
        data: {
            labels: {!! json_encode($labelsHarian ?? []) !!},
            datasets: [{
                label: 'Penjualan',
                data: {!! json_encode($dataHarian ?? []) !!},
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return formatCurrency(context.raw);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return formatCurrency(value);
                        }
                    }
                }
            }
        }
    });

    // Grafik Kategori
    const ctxKategori = document.getElementById('kategoriChart').getContext('2d');
    new Chart(ctxKategori, {
        type: 'doughnut',
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
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.raw;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${context.label}: ${formatCurrency(value)} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection