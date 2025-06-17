@extends('components.layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto mt-10 p-6 bg-white dark:bg-gray-800 shadow rounded-lg">
    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Laporan Keuangan</h2>
        
        <!-- Filter Periode -->
        <form method="POST" action="{{ route('laporan.filter') }}" class="mb-6 space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-200">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" value="{{ $startDate ?? '' }}" class="border border-gray-600 dark:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 p-2 w-full rounded" required>
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 dark:text-gray-200">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" value="{{ $endDate ?? '' }}" class="border border-gray-600 dark:border-gray-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 p-2 w-full rounded" required>
                </div>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">Tampilkan</button>
        </form>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 dark:bg-red-200 dark:text-red-800">{{ $errors->first() }}</div>
        @endif

        <!-- Ringkasan Keuangan -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Pendapatan -->
            <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Pendapatan</p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm {{ ($persentasePendapatan ?? 0) >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                        <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        {{ number_format($persentasePendapatan ?? 0, 1) }}%
                    </span>
                    <span class="text-sm text-gray-600 dark:text-gray-400 ml-2">dari periode sebelumnya</span>
                </div>
            </div>

            <!-- Total Pengeluaran -->
            <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Pengeluaran</p>
                        <p class="text-2xl font-bold text-red-600 dark:text-red-400">Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-3 bg-red-100 dark:bg-red-900 rounded-full">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm {{ ($persentasePengeluaran ?? 0) <= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                        <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        {{ number_format($persentasePengeluaran ?? 0, 1) }}%
                    </span>
                    <span class="text-sm text-gray-600 dark:text-gray-400 ml-2">dari periode sebelumnya</span>
                </div>
            </div>

            <!-- Saldo -->
            <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Saldo</p>
                        <p class="text-2xl font-bold {{ ($saldo ?? 0) >= 0 ? 'text-blue-600 dark:text-blue-400' : 'text-red-600 dark:text-red-400' }}">
                            Rp {{ number_format($saldo ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="p-3 {{ ($saldo ?? 0) >= 0 ? 'bg-blue-100 dark:bg-blue-900' : 'bg-red-100 dark:bg-red-900' }} rounded-full">
                        <svg class="w-6 h-6 {{ ($saldo ?? 0) >= 0 ? 'text-blue-600 dark:text-blue-400' : 'text-red-600 dark:text-red-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm {{ ($persentaseSaldo ?? 0) >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                        <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        {{ number_format($persentaseSaldo ?? 0, 1) }}%
                    </span>
                    <span class="text-sm text-gray-600 dark:text-gray-400 ml-2">dari periode sebelumnya</span>
                </div>
            </div>
        </div>

        <!-- Grafik Pendapatan dan Pengeluaran -->
        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow mb-8">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Grafik Pendapatan dan Pengeluaran</h3>
            <canvas id="keuanganChart" height="300"></canvas>
        </div>

        <!-- Tabel Transaksi -->
        @if(isset($laporan))
            @if($laporan->isEmpty())
                <p class="text-gray-500 dark:text-gray-300">⚠️ Tidak ada data dalam rentang waktu yang dipilih.</p>
            @else
                <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Daftar Transaksi</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto text-left border border-gray-600 dark:border-gray-500">
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
                                        <td class="px-4 py-2 border border-gray-600 dark:border-gray-500">{{ Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                                        <td class="px-4 py-2 border border-gray-600 dark:border-gray-500">{{ $item->deskripsi }}</td>
                                        <td class="px-4 py-2 border border-gray-600 dark:border-gray-500 {{ $item->jumlah >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @endif
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

    // Grafik Keuangan
    const ctx = document.getElementById('keuanganChart').getContext('2d');
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
});
</script>
@endpush
@endsection
