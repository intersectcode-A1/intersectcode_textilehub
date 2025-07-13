@extends('components.layouts.admin')

@section('title', 'Detail Log Inventory')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Detail Log Inventory</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Informasi detail pergerakan stok</p>
        </div>
        <a href="{{ route('inventory-logs.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 mt-4 sm:mt-0">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Detail Card -->
    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <!-- Header Card -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-100 dark:from-blue-900/20 dark:to-indigo-900/20 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 {{ $log->type === 'in' ? 'bg-green-100 dark:bg-green-900/20' : 'bg-red-100 dark:bg-red-900/20' }} rounded-lg">
                            @if($log->type === 'in')
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                </svg>
                            @else
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                </svg>
                            @endif
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $log->type_label }}</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">ID: #{{ $log->id }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Tanggal</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $log->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Product Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            Informasi Produk
                        </h3>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Nama Produk</label>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $log->product->nama ?? 'Produk tidak ditemukan' }}</p>
                            </div>
                            
                            @if($log->product)
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Kategori</label>
                                    <p class="text-gray-900 dark:text-white">{{ $log->product->category->name ?? 'Tidak ada kategori' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Satuan</label>
                                    <p class="text-gray-900 dark:text-white">{{ $log->product->satuan }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Transaction Details -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                            Detail Transaksi
                        </h3>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Jumlah</label>
                                <p class="text-2xl font-bold {{ $log->type === 'in' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $log->formatted_quantity }}
                                </p>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Stok Sebelum</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ number_format($log->stock_before) }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Stok Sesudah</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ number_format($log->stock_after) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="mt-8 space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                        Informasi Tambahan
                    </h3>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Keterangan</label>
                                <p class="text-gray-900 dark:text-white">{{ $log->description ?? $log->reference_description ?? 'Tidak ada keterangan' }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Tipe Referensi</label>
                                <p class="text-gray-900 dark:text-white">{{ ucfirst($log->reference_type ?? 'Manual') }}</p>
                            </div>
                            
                            @if($log->reference_id)
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">ID Referensi</label>
                                <p class="text-gray-900 dark:text-white">#{{ $log->reference_id }}</p>
                            </div>
                            @endif
                        </div>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Dibuat Oleh</label>
                                <p class="text-gray-900 dark:text-white">{{ $log->user->name ?? 'System' }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Waktu Dibuat</label>
                                <p class="text-gray-900 dark:text-white">{{ $log->created_at->format('d/m/Y H:i:s') }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Terakhir Diupdate</label>
                                <p class="text-gray-900 dark:text-white">{{ $log->updated_at->format('d/m/Y H:i:s') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Information -->
                @if($log->reference_type === 'order' && $log->reference_id)
                <div class="mt-8 space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2">
                        Informasi Order Terkait
                    </h3>
                    
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Log ini terkait dengan order #{{ $log->reference_id }}. 
                            <a href="{{ route('orders.show', $log->reference_id) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                                Lihat detail order
                            </a>
                        </p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 