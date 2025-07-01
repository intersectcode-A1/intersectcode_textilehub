@extends('components.layouts.admin')

@section('title', 'Edit Harga Produk')

@section('content')
<div class="mb-4 sm:mb-6">
    <h1 class="text-xl sm:text-2xl font-semibold text-gray-800 dark:text-white">Edit Harga Produk</h1>
    <nav class="text-xs sm:text-sm font-medium text-gray-500" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex flex-wrap">
            <li class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                <svg class="fill-current w-3 h-3 mx-2 sm:mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li class="flex items-center">
                <a href="{{ route('admin.harga-strategi.index') }}" class="text-gray-500 hover:text-gray-700">Strategi Harga</a>
                <svg class="fill-current w-3 h-3 mx-2 sm:mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li>
                <a href="#" class="text-gray-400" aria-current="page">Edit Harga</a>
            </li>
        </ol>
    </nav>
</div>

<div class="mb-4 sm:mb-6">
    <p class="text-sm sm:text-lg text-gray-600 dark:text-gray-400">Perbarui harga produk untuk strategi yang lebih optimal.</p>
</div>

            @if(session('success'))
    <div class="mb-4 sm:mb-6 animate-fade-in-down">
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 sm:p-4 rounded-r-lg" role="alert">
            <p class="font-medium text-sm sm:text-base">Sukses!</p>
            <p class="text-sm">{{ session('success') }}</p>
        </div>
    </div>
            @endif

            @if($errors->any())
    <div class="mb-4 sm:mb-6">
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 sm:p-4 rounded-r-lg" role="alert">
            <p class="font-semibold text-sm sm:text-base">Terjadi Kesalahan</p>
            <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
            </ul>
        </div>
                </div>
            @endif

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 sm:p-6 lg:p-8">
    <form method="POST" action="{{ route('admin.harga-strategi.update', $product->id) }}" class="space-y-4 sm:space-y-6">
                @csrf
        <div>
            <label class="block text-sm sm:text-base font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-2">Nama Produk</label>
            <input type="text" value="{{ $product->nama }}" class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 font-medium text-sm" readonly>
                </div>
        
        <div>
            <label class="block text-sm sm:text-base font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-2">Kategori</label>
            <input type="text" value="{{ $product->category->nama ?? '-' }}" class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 font-medium text-sm" readonly>
                </div>
        
        <div>
            <label class="block text-sm sm:text-base font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-2">Harga Lama</label>
            <input type="text" value="Rp {{ number_format($product->harga, 0, ',', '.') }}" class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-blue-600 dark:text-blue-400 font-semibold text-sm" readonly>
                    </div>
        
        <div>
            <label for="harga" class="block text-sm sm:text-base font-medium text-gray-700 dark:text-gray-300 mb-1 sm:mb-2">
                Harga Baru <span class="text-red-500">*</span>
            </label>
            <input type="number" 
                   name="new_price" 
                   id="harga" 
                   value="{{ old('new_price', $product->harga) }}" 
                   maxlength="19" 
                   min="0" 
                   class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm" 
                   required>
            <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-gray-500 dark:text-gray-400">Maksimal 19 digit angka</p>
                    @error('new_price')
                <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
        
        <div class="flex flex-col sm:flex-row justify-end gap-2 sm:gap-4 pt-4 sm:pt-6 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('admin.harga-strategi.index') }}" class="px-4 sm:px-6 py-2 sm:py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 text-sm text-center">
                Batal
            </a>
            <button type="submit" class="px-4 sm:px-6 py-2 sm:py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-all duration-200 text-sm">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection 