@extends('components.layouts.admin')

@section('title', 'Laporan Keuangan')

@section('content')
    <div class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">Laporan Keuangan</h1>
    <nav class="text-sm font-medium text-gray-500" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li>
                <a href="#" class="text-gray-400" aria-current="page">Laporan Keuangan</a>
            </li>
        </ol>
    </nav>
</div>
        
        <!-- Filter Periode -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
    <form method="POST" action="{{ route('laporan.filter') }}" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
            @csrf
                <div>
            <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal Mulai</label>
            <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ $startDate ?? '' }}" class="w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200" required>
                </div>
                <div>
            <label for="tanggal_akhir" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal Akhir</label>
            <input type="date" id="tanggal_akhir" name="tanggal_akhir" value="{{ $endDate ?? '' }}" class="w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200" required>
                </div>
        <div>
            <button type="submit" class="w-full px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-all duration-200">Tampilkan</button>
            </div>
        </form>
        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ $errors->first() }}</span>
        </div>
        @endif
</div>

        <!-- Ringkasan Keuangan -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    @php
        $summary = [
            ['title' => 'Total Pendapatan', 'value' => $totalPendapatan ?? 0, 'growth' => $persentasePendapatan ?? 0, 'color' => 'green'],
            ['title' => 'Total Pengeluaran', 'value' => $totalPengeluaran ?? 0, 'growth' => $persentasePengeluaran ?? 0, 'color' => 'red'],
            ['title' => 'Saldo', 'value' => $saldo ?? 0, 'growth' => $persentaseSaldo ?? 0, 'color' => 'blue']
        ];
    @endphp

    @foreach($summary as $item)
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ $item['title'] }}</p>
                <p class="text-2xl font-bold text-{{ $item['color'] }}-600 dark:text-{{ $item['color'] }}-400">Rp {{ number_format($item['value'], 0, ',', '.') }}</p>
            </div>
            <div class="p-3 bg-{{ $item['color'] }}-100 dark:bg-{{ $item['color'] }}-900 rounded-full">
                <svg class="w-6 h-6 text-{{ $item['color'] }}-600 dark:text-{{ $item['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="mt-4">
            <span class="text-sm {{ $item['growth'] >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                {{ number_format($item['growth'], 1) }}%
                    </span>
                    <span class="text-sm text-gray-600 dark:text-gray-400 ml-2">dari periode sebelumnya</span>
                </div>
            </div>
    @endforeach
        </div>

        <!-- Grafik Pendapatan dan Pengeluaran -->
<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md mb-8">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Grafik Pendapatan dan Pengeluaran</h3>
    <div style="height: 300px;">
        <canvas id="keuanganChart"></canvas>
    </div>
        </div>

        <!-- Tabel Transaksi -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white p-6 border-b border-gray-200 dark:border-gray-700">Daftar Transaksi</h3>
                    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Deskripsi</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah</th>
                                </tr>
                            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @if(isset($laporan) && !$laporan->isEmpty())
                                @foreach($laporan as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $item->deskripsi }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm {{ $item->jumlah >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                @else
                    <tr>
                        <td colspan="3" class="text-center py-12 text-gray-500 dark:text-gray-400">
                            {{ isset($laporan) ? 'Tidak ada data dalam rentang waktu yang dipilih.' : 'Silakan pilih rentang tanggal untuk menampilkan laporan.' }}
                        </td>
                    </tr>
                @endif
                            </tbody>
                        </table>
    </div>
</div>
@endsection

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
