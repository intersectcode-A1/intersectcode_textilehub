@extends('components.layouts.admin')

@section('title', 'Laporan Keuangan')

@section('content')
    <div class="mb-4 sm:mb-6">
    <h1 class="text-xl sm:text-2xl font-semibold text-gray-800 dark:text-white">Laporan Keuangan</h1>
    <nav class="text-xs sm:text-sm font-medium text-gray-500" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex flex-wrap">
            <li class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                <svg class="fill-current w-3 h-3 mx-2 sm:mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li>
                <a href="#" class="text-gray-400" aria-current="page">Laporan Keuangan</a>
            </li>
        </ol>
    </nav>
</div>
        
        <!-- Filter Periode -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 sm:p-6 mb-4 sm:mb-6">
    <div class="flex flex-col sm:flex-row gap-4 items-end">
        <form method="POST" action="{{ route('laporan.filter') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6 items-end flex-1">
            @csrf
                <div>
            <label for="tanggal_mulai" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-2">Tanggal Mulai</label>
            <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ $startDate ?? '' }}" class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm" required>
                </div>
                <div>
            <label for="tanggal_akhir" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-2">Tanggal Akhir</label>
            <input type="date" id="tanggal_akhir" name="tanggal_akhir" value="{{ $endDate ?? '' }}" class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm" required>
                </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 px-4 sm:px-6 py-2 sm:py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-all duration-200 text-sm">Tampilkan</button>
            </div>
        </form>
        @if(isset($startDate) && isset($endDate))
        <form method="POST" action="{{ route('admin.laporan.export') }}" class="inline">
            @csrf
            <input type="hidden" name="tanggal_mulai" value="{{ $startDate }}">
            <input type="hidden" name="tanggal_akhir" value="{{ $endDate }}">
            <button type="submit" class="px-4 sm:px-6 py-2 sm:py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-all duration-200 text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export Excel
            </button>
        </form>
        @endif
    </div>
        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-3 sm:px-4 py-2 sm:py-3 rounded relative mt-3 sm:mt-4 text-sm" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ $errors->first() }}</span>
        </div>
        @endif
</div>

        <!-- Ringkasan Keuangan -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
    @php
        $summary = [
            ['title' => 'Total Pendapatan', 'value' => $totalPendapatan ?? 0, 'growth' => $persentasePendapatan ?? 0, 'color' => 'green', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['title' => 'Total Pengeluaran', 'value' => $totalPengeluaran ?? 0, 'growth' => $persentasePengeluaran ?? 0, 'color' => 'red', 'icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z'],
            ['title' => 'Total Profit', 'value' => $totalProfit ?? 0, 'growth' => $persentaseProfit ?? 0, 'color' => 'blue', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
            ['title' => 'Margin Profit', 'value' => number_format($marginProfit ?? 0, 1) . '%', 'growth' => 0, 'color' => 'purple', 'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6']
        ];
    @endphp

    @foreach($summary as $item)
    <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                <p class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400">{{ $item['title'] }}</p>
                <p class="text-lg sm:text-2xl font-bold text-{{ $item['color'] }}-600 dark:text-{{ $item['color'] }}-400">
                    @if(str_contains($item['title'], 'Margin'))
                        {{ $item['value'] }}
                    @else
                        Rp {{ number_format($item['value'], 0, ',', '.') }}
                    @endif
                </p>
            </div>
            <div class="p-2 sm:p-3 bg-{{ $item['color'] }}-100 dark:bg-{{ $item['color'] }}-900 rounded-full">
                <svg class="w-4 h-4 sm:w-6 sm:h-6 text-{{ $item['color'] }}-600 dark:text-{{ $item['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path></svg>
                    </div>
                </div>
                @if($item['growth'] != 0)
                <div class="mt-3 sm:mt-4">
            <span class="text-xs sm:text-sm {{ $item['growth'] >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                <svg class="w-3 h-3 sm:w-4 sm:h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                {{ number_format($item['growth'], 1) }}%
                    </span>
                    <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 ml-1 sm:ml-2">dari periode sebelumnya</span>
                </div>
                @endif
            </div>
    @endforeach
        </div>

        <!-- Grafik Pendapatan, Pengeluaran, dan Profit -->
<div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow-md mb-6 sm:mb-8">
            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-3 sm:mb-4">Grafik Keuangan</h3>
    <div class="chart-container h-60 sm:h-80">
        <canvas id="keuanganChart"></canvas>
    </div>
        </div>

        <!-- Analisis Profitabilitas -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Produk Terlaris -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white p-3 sm:p-6 border-b border-gray-200 dark:border-gray-700">Produk Terlaris</h3>
                <div class="p-3 sm:p-6">
                    @if(isset($produkTerlaris) && $produkTerlaris->count() > 0)
                        @foreach($produkTerlaris as $index => $produk)
                        <div class="flex items-center justify-between py-2 {{ $index > 0 ? 'border-t border-gray-100 dark:border-gray-700' : '' }}">
                            <div class="flex items-center">
                                <span class="w-6 h-6 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xs font-semibold mr-3">{{ $index + 1 }}</span>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $produk->nama }}</p>
                                    <p class="text-xs text-gray-500">{{ number_format($produk->total_terjual) }} terjual</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-green-600">Rp {{ number_format($produk->total_pendapatan, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="text-gray-500 text-sm text-center py-4">Tidak ada data produk terlaris</p>
                    @endif
                </div>
            </div>

            <!-- Kategori Terlaris -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white p-3 sm:p-6 border-b border-gray-200 dark:border-gray-700">Kategori Terlaris</h3>
                <div class="p-3 sm:p-6">
                    @if(isset($kategoriTerlaris) && $kategoriTerlaris->count() > 0)
                        @foreach($kategoriTerlaris as $index => $kategori)
                        <div class="flex items-center justify-between py-2 {{ $index > 0 ? 'border-t border-gray-100 dark:border-gray-700' : '' }}">
                            <div class="flex items-center">
                                <span class="w-6 h-6 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-xs font-semibold mr-3">{{ $index + 1 }}</span>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $kategori->kategori }}</p>
                                    <p class="text-xs text-gray-500">{{ number_format($kategori->total_terjual) }} terjual</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-green-600">Rp {{ number_format($kategori->total_pendapatan, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="text-gray-500 text-sm text-center py-4">Tidak ada data kategori terlaris</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Cash Flow Statement -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-6">
            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white p-3 sm:p-6 border-b border-gray-200 dark:border-gray-700">Cash Flow Statement</h3>
            <div class="p-3 sm:p-6">
                @if(isset($cashFlow))
                <div class="space-y-4">
                    <!-- Operating Activities -->
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Operating Activities</h4>
                        <div class="space-y-1 text-sm">
                            <div class="flex justify-between">
                                <span>Pendapatan Penjualan</span>
                                <span class="text-green-600">Rp {{ number_format($cashFlow['operating_activities']['pendapatan_penjualan'], 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Pengeluaran Operasional</span>
                                <span class="text-red-600">(Rp {{ number_format(abs($cashFlow['operating_activities']['pengeluaran_operasional']), 0, ',', '.') }})</span>
                            </div>
                            <div class="flex justify-between border-t pt-1 font-semibold">
                                <span>Net Cash from Operating</span>
                                <span class="{{ $cashFlow['operating_activities']['net_cash_operating'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    Rp {{ number_format($cashFlow['operating_activities']['net_cash_operating'], 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Investing Activities -->
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Investing Activities</h4>
                        <div class="space-y-1 text-sm">
                            <div class="flex justify-between">
                                <span>Pembelian Aset</span>
                                <span class="text-red-600">(Rp {{ number_format(abs($cashFlow['investing_activities']['pembelian_aset']), 0, ',', '.') }})</span>
                            </div>
                            <div class="flex justify-between border-t pt-1 font-semibold">
                                <span>Net Cash from Investing</span>
                                <span class="text-red-600">(Rp {{ number_format(abs($cashFlow['investing_activities']['net_cash_investing']), 0, ',', '.') }})</span>
                            </div>
                        </div>
                    </div>

                    <!-- Financing Activities -->
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Financing Activities</h4>
                        <div class="space-y-1 text-sm">
                            <div class="flex justify-between">
                                <span>Pinjaman</span>
                                <span class="text-green-600">Rp {{ number_format($cashFlow['financing_activities']['pinjaman'], 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Pembayaran Pinjaman</span>
                                <span class="text-red-600">(Rp {{ number_format(abs($cashFlow['financing_activities']['pembayaran_pinjaman']), 0, ',', '.') }})</span>
                            </div>
                            <div class="flex justify-between border-t pt-1 font-semibold">
                                <span>Net Cash from Financing</span>
                                <span class="{{ $cashFlow['financing_activities']['net_cash_financing'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    Rp {{ number_format($cashFlow['financing_activities']['net_cash_financing'], 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Net Change in Cash -->
                    @php
                        $netChange = $cashFlow['operating_activities']['net_cash_operating'] + 
                                    $cashFlow['investing_activities']['net_cash_investing'] + 
                                    $cashFlow['financing_activities']['net_cash_financing'];
                    @endphp
                    <div class="border-t pt-3">
                        <div class="flex justify-between font-bold text-base">
                            <span>Net Change in Cash</span>
                            <span class="{{ $netChange >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                Rp {{ number_format($netChange, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
                @else
                    <p class="text-gray-500 text-sm text-center py-4">Tidak ada data cash flow</p>
                @endif
            </div>
        </div>

        <!-- Kategori Pengeluaran -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-6">
            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white p-3 sm:p-6 border-b border-gray-200 dark:border-gray-700">Kategori Pengeluaran</h3>
            <div class="p-3 sm:p-6">
                @if(isset($kategoriPengeluaran) && count($kategoriPengeluaran) > 0)
                <div class="space-y-3">
                    @foreach($kategoriPengeluaran as $kategori => $jumlah)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-red-500 rounded-full mr-3"></div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $kategori }}</span>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-red-600">Rp {{ number_format($jumlah, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500">{{ number_format(($jumlah / $totalPengeluaran) * 100, 1) }}%</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                    <p class="text-gray-500 text-sm text-center py-4">Tidak ada data kategori pengeluaran</p>
                @endif
            </div>
        </div>

        <!-- Detail Data Pengeluaran -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-6">
            <div class="flex items-center justify-between p-3 sm:p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">Detail Data Pengeluaran</h3>
                <a href="{{ route('expenses.index') }}" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                    Lihat Semua →
                </a>
            </div>
            <div class="p-3 sm:p-6">
                @if(isset($expenses) && $expenses->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kategori</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah Transaksi</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">% dari Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($expenses as $expense)
                            <tr>
                                <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $expense->kategori }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-red-600 font-semibold">
                                    Rp {{ number_format($expense->total, 0, ',', '.') }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ number_format($expense->jumlah_transaksi) }}
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ number_format(($expense->total / $totalPengeluaran) * 100, 1) }}%
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    <div class="text-center py-8">
                        <div class="text-gray-400 mb-4">
                            <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-500 text-sm">Belum ada data pengeluaran untuk periode ini</p>
                        <a href="{{ route('expenses.create') }}" class="mt-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Tambah Pengeluaran
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Statistik Transaksi -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white p-3 sm:p-6 border-b border-gray-200 dark:border-gray-700">Statistik Transaksi</h3>
            <div class="p-3 sm:p-6">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-blue-600">{{ number_format($jumlahTransaksi ?? 0) }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Transaksi</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-green-600">Rp {{ number_format($rataRataTransaksi ?? 0, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Rata-rata Transaksi</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-purple-600">{{ number_format($marginProfit ?? 0, 1) }}%</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Margin Profit</p>
                    </div>
                </div>
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
    const formatCurrency = (value) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value);

    const ctx = document.getElementById('keuanganChart');
    if (ctx) {
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($labelsGrafik ?? []) !!},
            datasets: [
                {
                    label: 'Pendapatan',
                    data: {!! json_encode($dataPendapatan ?? []) !!},
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Pengeluaran',
                    data: {!! json_encode($dataPengeluaran ?? []) !!},
                    borderColor: 'rgb(239, 68, 68)',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Profit',
                    data: {!! json_encode($dataProfit ?? []) !!},
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
                maintainAspectRatio: false,
            plugins: {
                    legend: { position: 'top' },
                    tooltip: { callbacks: { label: (context) => formatCurrency(context.raw) } }
            },
            scales: {
                y: {
                    beginAtZero: true,
                        ticks: { callback: (value) => formatCurrency(value) }
                    }
                }
            }
        });
        }
});
</script>
@endpush
