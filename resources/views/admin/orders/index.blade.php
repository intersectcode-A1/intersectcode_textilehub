@extends('components.layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="mb-4 sm:mb-6">
    <h1 class="text-xl sm:text-2xl font-semibold text-gray-800 dark:text-white">Pesanan</h1>
    <nav class="text-xs sm:text-sm font-medium text-gray-500" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex flex-wrap">
            <li class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                <svg class="fill-current w-3 h-3 mx-2 sm:mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li class="flex items-center">
                <a href="#" class="text-gray-500 hover:text-gray-700">Pesanan</a>
                <svg class="fill-current w-3 h-3 mx-2 sm:mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li>
                <a href="#" class="text-gray-400" aria-current="page">Daftar Pesanan</a>
            </li>
        </ol>
    </nav>
</div>

<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-2 sm:mb-6 gap-2 sm:gap-3">
    <p class="text-xs sm:text-lg text-gray-600 dark:text-gray-400">Kelola semua pesanan pelanggan.</p>
    <a href="{{ route('orders.export') }}" class="inline-flex items-center px-3 sm:px-6 py-2 sm:py-3 bg-green-600 text-white text-xs sm:text-base font-medium rounded-lg sm:rounded-xl hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 shadow-sm w-full sm:w-auto justify-center">
        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        Export Excel
    </a>
</div>

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

<!-- Active Filters Indicator -->
@if(request('status') || request('date_from') || request('date_to'))
<div class="mb-4 sm:mb-6">
    <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-700 p-3 sm:p-4 rounded-r-lg">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"/>
                </svg>
                <span class="font-medium text-sm sm:text-base">Filter Aktif:</span>
            </div>
            <a href="{{ route('orders.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Hapus Semua Filter</a>
        </div>
        <div class="mt-2 flex flex-wrap gap-2">
            @if(request('status'))
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    Status: {{ ucfirst(request('status')) }}
                </span>
            @endif
            @if(request('date_from'))
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    Dari: {{ \Carbon\Carbon::parse(request('date_from'))->format('d M Y') }}
                </span>
            @endif
            @if(request('date_to'))
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    Sampai: {{ \Carbon\Carbon::parse(request('date_to'))->format('d M Y') }}
                </span>
            @endif
        </div>
    </div>
</div>
@endif

<!-- Filter Form -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 sm:p-6 mb-4 sm:mb-6">
    <form method="GET" action="{{ route('orders.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <div>
            <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-2">Status</label>
            <select name="status" class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Diproses</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
        </div>
        <div>
            <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-2">Dari Tanggal</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm">
        </div>
        <div>
            <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-2">Sampai Tanggal</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm">
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="flex-1 px-4 sm:px-6 py-2 sm:py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-all duration-200 flex items-center justify-center gap-2 text-sm">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Filter
            </button>
            <a href="{{ route('orders.index') }}" class="px-4 sm:px-6 py-2 sm:py-3 bg-gray-500 text-white font-semibold rounded-lg hover:bg-gray-600 transition-all duration-200 flex items-center justify-center gap-2 text-sm">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Clear
            </a>
        </div>
    </form>
</div>

<!-- Tabel Pesanan -->
<div class="bg-gradient-to-r from-blue-400 to-blue-200 rounded-t-xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-blue-200 text-xs sm:text-sm">
            <thead class="bg-gradient-to-r from-blue-50 to-indigo-100 dark:from-blue-900 dark:to-indigo-900 border-b-2 border-blue-200 dark:border-blue-700">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-blue-700 dark:text-blue-200 uppercase tracking-wider">No</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-blue-700 dark:text-blue-200 uppercase tracking-wider">Nama Pemesan</th>
                    <th class="hidden sm:table-cell px-6 py-4 text-left text-xs font-bold text-blue-700 dark:text-blue-200 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-blue-700 dark:text-blue-200 uppercase tracking-wider">Status</th>
                    <th class="hidden md:table-cell px-6 py-4 text-left text-xs font-bold text-blue-700 dark:text-blue-200 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-blue-700 dark:text-blue-200 uppercase tracking-wider w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-blue-100">
                @forelse($orders as $order)
                    <tr class="hover:bg-blue-50 transition-colors duration-150 align-top">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-block px-3 py-1 rounded-full bg-gradient-to-r from-blue-400 to-blue-300 text-white font-bold shadow">{{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-normal break-all max-w-xs">
                            <div class="font-medium text-gray-900">{{ $order->user->name ?? $order->user_name }}</div>
                            <div class="text-xs text-gray-500 sm:hidden">{{ $order->created_at->format('d M Y') }}</div>
                        </td>
                        <td class="hidden sm:table-cell px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold
                                @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                @elseif($order->status === 'completed') bg-green-100 text-green-800
                                @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap font-bold text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right w-32">
                            <div class="flex flex-row items-center justify-end space-x-2">
                                <a href="{{ route('orders.show', $order->id) }}" class="p-2 bg-blue-100 hover:bg-blue-400 text-blue-600 hover:text-white rounded-full shadow transition-all duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                @if($order->status === 'completed' || $order->payment_status === 'paid')
                                <a href="{{ route('orders.invoice', $order->id) }}" class="p-2 bg-green-100 hover:bg-green-400 text-green-600 hover:text-white rounded-full shadow transition-all duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6 2a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19z"/>
                                    </svg>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 sm:py-12">
                            <div class="text-gray-500 dark:text-gray-400">
                                <svg class="mx-auto h-8 w-8 sm:h-12 sm:w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-800 dark:text-white">Tidak ada pesanan</h3>
                                <p class="mt-1 text-xs sm:text-sm text-gray-500">Belum ada pesanan yang masuk.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($orders->total() > 0)
        <div class="flex items-center gap-3 px-6 py-2 bg-white dark:bg-gray-800 border-t border-blue-200 dark:border-blue-700">
            <span class="text-gray-600 dark:text-gray-300 text-sm">Halaman:</span>
            <span class="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-700 font-semibold text-sm">
                {{ $orders->currentPage() }} dari {{ $orders->lastPage() }}
            </span>
        </div>
        @if ($orders->hasPages())
            <div class="p-3 sm:p-6 bg-white border-t border-blue-200">
                {{ $orders->links('vendor.pagination.modern') }}
            </div>
        @endif
    @endif
</div>
@endsection

@section('scripts')
<script>lucide.createIcons();</script>
@endsection
