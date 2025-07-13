@extends('components.layouts.admin')

@section('title', 'Analisis Penjualan')

@section('content')
@if(session('success'))
<div class="mb-4 sm:mb-6 animate-fade-in-down">
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 sm:p-4 rounded-r-lg" role="alert">
        <p class="font-medium text-sm sm:text-base">Sukses!</p>
        <p class="text-sm">{{ session('success') }}</p>
    </div>
</div>
@endif

@if(session('error'))
<div class="mb-4 sm:mb-6 animate-fade-in-down">
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 sm:p-4 rounded-r-lg" role="alert">
        <p class="font-medium text-sm sm:text-base">Error!</p>
        <p class="text-sm">{{ session('error') }}</p>
    </div>
</div>
@endif
<div class="mb-4 sm:mb-6">
    <h1 class="text-xl sm:text-2xl font-semibold text-gray-800 dark:text-white">Penjualan</h1>
    <nav class="text-xs sm:text-sm font-medium text-gray-500" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex flex-wrap">
            <li class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                <svg class="fill-current w-3 h-3 mx-2 sm:mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li class="flex items-center">
                <a href="#" class="text-gray-500 hover:text-gray-700">Penjualan</a>
                <svg class="fill-current w-3 h-3 mx-2 sm:mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li>
                <a href="#" class="text-gray-400" aria-current="page">Analisis Penjualan</a>
            </li>
        </ol>
    </nav>
</div>

<!-- Filter Periode -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 sm:p-6 mb-4 sm:mb-6">
    <form method="GET" action="{{ route('admin.sales.analysis') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <div>
            <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-2">Periode</label>
            <select name="period" class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm">
                <option value="7" {{ request('period') == '7' ? 'selected' : '' }}>7 Hari Terakhir</option>
                <option value="30" {{ request('period') == '30' ? 'selected' : '' }}>30 Hari Terakhir</option>
                <option value="90" {{ request('period') == '90' ? 'selected' : '' }}>3 Bulan Terakhir</option>
                <option value="365" {{ request('period') == '365' ? 'selected' : '' }}>1 Tahun Terakhir</option>
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="flex-1 px-4 sm:px-6 py-2 sm:py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-all duration-200 text-sm">
                Terapkan
            </button>
            <a href="{{ route('admin.sales.analysis.export', ['period' => request('period', 7)]) }}" id="exportBtn" class="px-4 sm:px-6 py-2 sm:py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-all duration-200 flex items-center justify-center gap-2 text-sm">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span id="exportText">Export Excel</span>
            </a>
        </div>
    </form>
</div>

<!-- Statistik Utama -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
    @php
        $stats = [
            [
                'title' => 'Total Penjualan',
                'value' => 'Rp ' . number_format($totalPenjualan ?? 0, 0, ',', '.'),
                'growth' => number_format($persentasePertumbuhan ?? 0, 1),
                'color' => 'blue',
                'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
            ],
            [
                'title' => 'Jumlah Transaksi',
                'value' => $jumlahTransaksi ?? 0,
                'growth' => number_format($persentaseTransaksi ?? 0, 1),
                'color' => 'green',
                'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'
            ],
            [
                'title' => 'Rata-rata Transaksi',
                'value' => 'Rp ' . number_format($rataRataTransaksi ?? 0, 0, ',', '.'),
                'growth' => number_format($persentaseRataRata ?? 0, 1),
                'color' => 'purple',
                'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'
            ],
            [
                'title' => 'Produk Terlaris',
                'value' => $produkTerlaris ?? '-',
                'growth' => ($jumlahTerjual ?? 0) . ' unit',
                'color' => 'orange',
                'icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z'
            ]
        ];
    @endphp

    @foreach($stats as $stat)
        <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400">{{ $stat['title'] }}</p>
                    <p class="text-lg sm:text-2xl font-bold text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400">{{ $stat['value'] }}</p>
                </div>
                <div class="p-2 sm:p-3 bg-{{ $stat['color'] }}-100 dark:bg-{{ $stat['color'] }}-900 rounded-full">
                    <svg class="w-4 h-4 sm:w-6 sm:h-6 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-3 sm:mt-4">
                @if($stat['title'] !== 'Produk Terlaris')
                    <span class="text-xs sm:text-sm text-green-600 dark:text-green-400">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        {{ $stat['growth'] }}%
                    </span>
                    <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 ml-1 sm:ml-2">dari periode sebelumnya</span>
                @else
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">{{ $stat['growth'] }} terjual</p>
                @endif
            </div>
        </div>
    @endforeach
</div>

<!-- Grafik dan Analisis -->
<div class="grid grid-cols-1 lg:grid-cols-5 gap-4 sm:gap-6 mb-6 sm:mb-8">
    <!-- Grafik dan Analisis -->
    <div class="lg:col-span-3 grid grid-cols-1 gap-4 sm:gap-6">
        <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow-md">
            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-3 sm:mb-4">Tren Penjualan</h3>
            <div class="chart-container h-60 sm:h-80">
                @if(!empty($labelsHarian) && !empty($dataHarian))
                    <canvas id="penjualanChart"></canvas>
                @else
                    <div class="flex items-center justify-center h-full">
                        <div class="text-center">
                            <svg class="mx-auto h-8 w-8 sm:h-12 sm:w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <p class="mt-2 text-xs sm:text-sm text-gray-500 dark:text-gray-400">Tidak ada data penjualan untuk periode ini</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Penjualan per Kategori -->
    <div class="lg:col-span-2 grid grid-cols-1 gap-4 sm:gap-6">
        <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow-md">
            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-3 sm:mb-4">Penjualan per Kategori</h3>
            <div class="chart-container h-60 sm:h-80">
                @if(!empty($labelsKategori) && !empty($dataKategori))
                    <canvas id="kategoriChart"></canvas>
                @else
                    <div class="flex items-center justify-center h-full">
                        <div class="text-center">
                            <svg class="mx-auto h-8 w-8 sm:h-12 sm:w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                            </svg>
                            <p class="mt-2 text-xs sm:text-sm text-gray-500 dark:text-gray-400">Tidak ada data kategori untuk periode ini</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Tabel Produk Terlaris -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-6">
    <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white p-3 sm:p-6 border-b border-gray-200 dark:border-gray-700">Produk Terlaris</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs sm:text-sm">
            <thead class="bg-gradient-to-r from-blue-50 to-indigo-100 border-b-2 border-blue-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Produk</th>
                    <th class="hidden sm:table-cell px-6 py-4 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Terjual</th>
                    <th class="hidden md:table-cell px-6 py-4 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">Total Penjualan</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-blue-100">
                @forelse($produkTerlarisList ?? [] as $produk)
                <tr class="hover:bg-blue-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-normal break-all font-medium text-gray-900">
                        {{ $produk->nama }}
                        <div class="sm:hidden text-xs text-gray-500 mt-1">Kategori: {{ $produk->kategori }}</div>
                    </td>
                    <td class="hidden sm:table-cell px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">{{ $produk->kategori }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">{{ $produk->jumlah_terjual }}</td>
                    <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap font-bold text-gray-900">Rp {{ number_format($produk->total_penjualan, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-8 sm:py-12 text-gray-500 text-sm">
                        Tidak ada data produk terlaris untuk periode ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Log Barang Masuk dan Keluar -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Statistik Inventory -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 sm:p-6">
        <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-4">Statistik Inventory</h3>
        <div class="grid grid-cols-2 gap-4">
            <div class="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                    {{ number_format($inventorySummary['incoming'] ?? 0) }}
                </div>
                <div class="text-sm text-green-600 dark:text-green-400 font-medium">Barang Masuk</div>
            </div>
            <div class="text-center p-4 bg-red-50 dark:bg-red-900/20 rounded-lg">
                <div class="text-2xl font-bold text-red-600 dark:text-red-400">
                    {{ number_format($inventorySummary['outgoing'] ?? 0) }}
                </div>
                <div class="text-sm text-red-600 dark:text-red-400 font-medium">Barang Keluar</div>
            </div>
            <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                    {{ number_format($inventorySummary['net_change'] ?? 0) }}
                </div>
                <div class="text-sm text-blue-600 dark:text-blue-400 font-medium">Perubahan Net</div>
            </div>
            <div class="text-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                    {{ number_format($inventorySummary['total_transactions'] ?? 0) }}
                </div>
                <div class="text-sm text-purple-600 dark:text-purple-400 font-medium">Total Transaksi</div>
            </div>
        </div>
    </div>

    <!-- Grafik Inventory -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 sm:p-6">
        <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-4">Tren Inventory</h3>
        <div class="chart-container h-60">
            @if(!empty($inventoryChartData['labels']) && $inventoryChartData['labels']->count() > 0)
                <canvas id="inventoryChart"></canvas>
            @else
                <div class="flex items-center justify-center h-full">
                    <div class="text-center">
                        <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Tidak ada data inventory untuk periode ini</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Log Inventory Terbaru -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
    <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white p-3 sm:p-6 border-b border-gray-200 dark:border-gray-700">Log Inventory Terbaru</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs sm:text-sm">
            <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b-2 border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Produk</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tipe</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Stok Sebelum</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Stok Sesudah</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Keterangan</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($recentInventoryLogs ?? [] as $log)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                        {{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-normal break-all font-medium text-gray-900">
                        {{ $log->product->nama ?? 'Produk tidak ditemukan' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $log->type === 'in' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $log->type_label }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-xs sm:text-sm font-bold {{ $log->type === 'in' ? 'text-green-600' : 'text-red-600' }}">
                        {{ $log->formatted_quantity }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                        {{ number_format($log->stock_before) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                        {{ number_format($log->stock_after) }}
                    </td>
                    <td class="px-6 py-4 whitespace-normal text-xs sm:text-sm text-gray-900">
                        {{ $log->description ?? $log->reference_description }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-8 sm:py-12 text-gray-500 text-sm">
                        Tidak ada log inventory untuk periode ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
<style>
.chart-container {
    position: relative;
    width: 100%;
}

/* Responsive chart adjustments */
@media (max-width: 640px) {
    .chart-container {
        height: 250px !important;
    }
}

@media (min-width: 641px) and (max-width: 1024px) {
    .chart-container {
        height: 300px !important;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Export button loading state
    const exportBtn = document.getElementById('exportBtn');
    const exportText = document.getElementById('exportText');
    
    if (exportBtn) {
        exportBtn.addEventListener('click', function(e) {
            const originalText = exportText.textContent;
            const originalHref = exportBtn.href;
            
            // Show loading state
            exportBtn.classList.add('opacity-75', 'cursor-not-allowed');
            exportText.textContent = 'Mengexport...';
            exportBtn.href = '#';
            
            // Prevent multiple clicks
            e.preventDefault();
            
            // Simulate loading time and redirect
            setTimeout(() => {
                window.location.href = originalHref;
            }, 500);
        });
    }
    const formatCurrency = (value) => new Intl.NumberFormat('id-ID', { 
        style: 'currency', 
        currency: 'IDR', 
        minimumFractionDigits: 0, 
        maximumFractionDigits: 0 
    }).format(value);

    // Grafik Tren Penjualan
    const ctxPenjualan = document.getElementById('penjualanChart');
    if (ctxPenjualan && {!! json_encode($labelsHarian ?? []) !!}.length > 0) {
        new Chart(ctxPenjualan, {
            type: 'line',
            data: {
                labels: {!! json_encode($labelsHarian ?? []) !!},
                datasets: [{
                    label: 'Penjualan',
                    data: {!! json_encode($dataHarian ?? []) !!},
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'rgb(59, 130, 246)',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: { 
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 12,
                                weight: '600'
                            }
                        }
                    },
                    tooltip: { 
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: 'rgba(59, 130, 246, 0.5)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        callbacks: { 
                            label: (context) => formatCurrency(context.raw) 
                        } 
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        },
                        ticks: { 
                            callback: (value) => formatCurrency(value),
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuart'
                }
            }
        });
    }

    // Grafik Kategori
    const ctxKategori = document.getElementById('kategoriChart');
    if (ctxKategori && {!! json_encode($labelsKategori ?? []) !!}.length > 0) {
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
                    ],
                    borderColor: 'rgb(30, 41, 59)',
                    borderWidth: 2,
                    hoverOffset: 12,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 12,
                                weight: '600'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: 'rgba(255, 255, 255, 0.2)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        callbacks: {
                            label: (context) => {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.chart.getDataObjects().reduce((acc, obj) => acc + obj.data, 0);
                                const percentage = total > 0 ? (value / total * 100).toFixed(2) : 0;
                                return `${label}: ${formatCurrency(value)} (${percentage}%)`;
                            }
                        }
                    }
                },
                animation: {
                    animateRotate: true,
                    animateScale: true,
                    duration: 1500
                }
            }
        });
    }

    // Grafik Inventory
    const ctxInventory = document.getElementById('inventoryChart');
    if (ctxInventory && {!! json_encode($inventoryChartData['labels'] ?? []) !!}.length > 0) {
        new Chart(ctxInventory, {
            type: 'line',
            data: {
                labels: {!! json_encode($inventoryChartData['labels'] ?? []) !!},
                datasets: [
                    {
                        label: 'Barang Masuk',
                        data: {!! json_encode($inventoryChartData['barang_masuk'] ?? []) !!},
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: 'rgb(34, 197, 94)',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    },
                    {
                        label: 'Barang Keluar',
                        data: {!! json_encode($inventoryChartData['barang_keluar'] ?? []) !!},
                        borderColor: 'rgb(239, 68, 68)',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: 'rgb(239, 68, 68)',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: { 
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 12,
                                weight: '600'
                            }
                        }
                    },
                    tooltip: { 
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: 'rgba(255, 255, 255, 0.2)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        callbacks: { 
                            label: (context) => `${context.dataset.label}: ${context.raw} unit` 
                        } 
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        },
                        ticks: { 
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuart'
                }
            }
        });
    }
});
</script>
@endpush