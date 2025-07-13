@extends('components.layouts.admin')

@section('title', 'Edit Log Inventory')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Edit Log Inventory</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Perbarui data log pergerakan stok</p>
        </div>
        <a href="{{ route('inventory-logs.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 mt-4 sm:mt-0">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Form -->
    <div class="max-w-2xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <form method="POST" action="{{ route('inventory-logs.update', $log->id) }}">
                @csrf
                @method('PUT')

                <!-- Product Selection -->
                <div class="mb-6">
                    <label for="product_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Produk <span class="text-red-500">*</span>
                    </label>
                    <select name="product_id" id="product_id" required class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('product_id') border-red-500 @enderror">
                        <option value="">Pilih Produk</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id', $log->product_id) == $product->id ? 'selected' : '' }}>
                                {{ $product->nama }} (Stok: {{ $product->stok }})
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type Selection -->
                <div class="mb-6">
                    <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Tipe <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            <input type="radio" name="type" value="in" {{ old('type', $log->type) == 'in' ? 'checked' : '' }} class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <div class="ml-3">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                    </svg>
                                    <span class="font-medium text-gray-900 dark:text-white">Barang Masuk</span>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Menambah stok produk</p>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            <input type="radio" name="type" value="out" {{ old('type', $log->type) == 'out' ? 'checked' : '' }} class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <div class="ml-3">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                    </svg>
                                    <span class="font-medium text-gray-900 dark:text-white">Barang Keluar</span>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Mengurangi stok produk</p>
                            </div>
                        </label>
                    </div>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quantity -->
                <div class="mb-6">
                    <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Jumlah <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="quantity" id="quantity" min="1" value="{{ old('quantity', $log->quantity) }}" required class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('quantity') border-red-500 @enderror" placeholder="Masukkan jumlah">
                    @error('quantity')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Keterangan
                    </label>
                    <textarea name="description" id="description" rows="3" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror" placeholder="Contoh: Pembelian dari supplier, Penjualan, Penyesuaian stok, dll.">{{ old('description', $log->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Reference Type -->
                <div class="mb-6">
                    <label for="reference_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Tipe Referensi
                    </label>
                    <select name="reference_type" id="reference_type" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('reference_type') border-red-500 @enderror">
                        <option value="">Pilih Tipe Referensi</option>
                        <option value="purchase" {{ old('reference_type', $log->reference_type) == 'purchase' ? 'selected' : '' }}>Pembelian</option>
                        <option value="order" {{ old('reference_type', $log->reference_type) == 'order' ? 'selected' : '' }}>Penjualan</option>
                        <option value="adjustment" {{ old('reference_type', $log->reference_type) == 'adjustment' ? 'selected' : '' }}>Penyesuaian Stok</option>
                        <option value="return" {{ old('reference_type', $log->reference_type) == 'return' ? 'selected' : '' }}>Retur</option>
                    </select>
                    @error('reference_type')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Reference ID -->
                <div class="mb-6">
                    <label for="reference_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        ID Referensi
                    </label>
                    <input type="number" name="reference_id" id="reference_id" min="1" value="{{ old('reference_id', $log->reference_id) }}" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('reference_id') border-red-500 @enderror" placeholder="Contoh: ID Order, ID Pembelian, dll.">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Opsional. ID dari referensi terkait (order, pembelian, dll.)</p>
                    @error('reference_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('inventory-logs.index') }}" class="px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 