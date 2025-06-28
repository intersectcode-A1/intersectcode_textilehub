@extends('components.layouts.admin')

@section('content')
<div class="mb-4 sm:mb-6">
    <h1 class="text-xl sm:text-2xl font-semibold text-gray-800 dark:text-white">Tambah Produk Baru</h1>
    <nav class="text-xs sm:text-sm font-medium text-gray-500" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex flex-wrap">
            <li class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                <svg class="fill-current w-3 h-3 mx-2 sm:mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li class="flex items-center">
                <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-700">Produk</a>
                <svg class="fill-current w-3 h-3 mx-2 sm:mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li>
                <a href="#" class="text-gray-400" aria-current="page">Tambah Baru</a>
            </li>
        </ol>
    </nav>
        </div>
<p class="text-sm sm:text-lg text-gray-600 dark:text-gray-400 mb-6 sm:mb-8">Isi form berikut untuk menambahkan produk baru ke katalog.</p>

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

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
    <div class="p-3 sm:p-6 lg:p-8">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 sm:space-y-6">
            @csrf

            <!-- Nama Produk -->
            <div>
                <label for="nama" class="block text-sm sm:text-base font-medium text-gray-700 dark:text-gray-300">
                    Nama Produk <span class="text-red-500">*</span>
                </label>
                <div class="mt-1 sm:mt-2">
                    <input type="text" 
                           name="nama" 
                           id="nama" 
                           value="{{ old('nama') }}" 
                           class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm" 
                           placeholder="Masukkan nama produk"
                           required>
                </div>
                @error('nama')
                <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori -->
            <div>
                <label for="category_id" class="block text-sm sm:text-base font-medium text-gray-700 dark:text-gray-300">
                    Kategori <span class="text-red-500">*</span>
                </label>
                <div class="mt-1 sm:mt-2">
                    <select name="category_id" 
                            id="category_id" 
                            class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm" 
                            required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('category_id')
                <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6">
                <!-- Harga -->
                <div>
                    <label for="harga" class="block text-sm sm:text-base font-medium text-gray-700 dark:text-gray-300">
                        Harga <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1 sm:mt-2 relative rounded-lg">
                        <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                            <span class="text-gray-400 text-sm">Rp</span>
                        </div>
                        <input type="number" 
                               name="harga" 
                               id="harga" 
                               value="{{ old('harga') }}" 
                               class="w-full pl-10 sm:pl-12 pr-3 sm:pr-4 py-2 sm:py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm" 
                               placeholder="0"
                               min="0"
                               step="1000"
                               required>
                    </div>
                    @error('harga')
                    <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stok -->
                <div>
                    <label for="stok" class="block text-sm sm:text-base font-medium text-gray-700 dark:text-gray-300">
                        Stok <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1 sm:mt-2">
                        <input type="number" 
                               name="stok" 
                               id="stok" 
                               value="{{ old('stok') }}" 
                               class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm" 
                               placeholder="0"
                               min="0"
                               step="1"
                               required>
                    </div>
                    @error('stok')
                    <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Satuan -->
                <div>
                    <label for="satuan" class="block text-sm sm:text-base font-medium text-gray-700 dark:text-gray-300">
                        Satuan <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1 sm:mt-2">
                        <input type="text" 
                               name="satuan" 
                               id="satuan" 
                               value="{{ old('satuan') }}" 
                               class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm"
                               placeholder="Contoh: Pcs, Lusin, Kg"
                               required>
                    </div>
                    @error('satuan')
                    <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block text-sm sm:text-base font-medium text-gray-700 dark:text-gray-300">
                    Deskripsi Produk
                </label>
                <div class="mt-1 sm:mt-2">
                    <textarea name="deskripsi" 
                              id="deskripsi" 
                              rows="4"
                              class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-lg bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm"
                              placeholder="Masukkan deskripsi produk">{{ old('deskripsi') }}</textarea>
                </div>
                @error('deskripsi')
                <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Varian Produk -->
            <div x-data="{ variants: [] }" class="border-t-2 border-gray-200 dark:border-gray-700 pt-4 sm:pt-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2 sm:mb-4 gap-2 sm:gap-3">
                    <h3 class="text-base sm:text-lg font-medium text-gray-700 dark:text-gray-300">Varian Produk</h3>
                    <button type="button" 
                            @click="variants.push({type: '', name: '', stock: 0, additional_price: 0})"
                            class="inline-flex items-center px-3 sm:px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-all duration-200 text-xs sm:text-sm">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Tambah Varian
                    </button>
                </div>
                <div>
                    <template x-for="(variant, index) in variants" :key="index">
                        <div class="bg-gray-50 dark:bg-gray-700/50 p-2 sm:p-4 rounded-lg mb-2 sm:mb-4 border border-gray-200 dark:border-gray-700">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-4">
                                <!-- Tipe Varian -->
                                <div>
                                    <label :for="'variants['+index+'][type]'" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Tipe Varian
                                    </label>
                                    <select :name="'variants['+index+'][type]'" 
                                            :id="'variants['+index+'][type]'"
                                            x-model="variant.type"
                                            class="w-full px-3 sm:px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm">
                                        <option value="">Pilih Tipe</option>
                                        <option value="color">Warna</option>
                                        <option value="size">Ukuran</option>
                                    </select>
                                </div>

                                <!-- Nama Varian -->
                                <div>
                                    <label :for="'variants['+index+'][name]'" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Nama Varian
                                    </label>
                                    <input type="text" 
                                           :name="'variants['+index+'][name]'" 
                                           :id="'variants['+index+'][name]'"
                                           x-model="variant.name"
                                           class="w-full px-3 sm:px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm"
                                           placeholder="Contoh: Merah, XL">
                                </div>

                                <!-- Stok Varian -->
                                <div>
                                    <label :for="'variants['+index+'][stock]'" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Stok
                                    </label>
                                    <input type="number" 
                                           :name="'variants['+index+'][stock]'" 
                                           :id="'variants['+index+'][stock]'"
                                           x-model="variant.stock"
                                           class="w-full px-3 sm:px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm"
                                           placeholder="0"
                                           min="0">
                                </div>

                                <!-- Harga Tambahan -->
                                <div>
                                    <label :for="'variants['+index+'][additional_price]'" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Harga Tambahan
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-400 text-xs">Rp</span>
                                        </div>
                                        <input type="number" 
                                               :name="'variants['+index+'][additional_price]'" 
                                               :id="'variants['+index+'][additional_price]'"
                                               x-model="variant.additional_price"
                                               class="w-full pl-8 pr-3 sm:px-4 py-2 rounded-lg bg-white dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm"
                                               placeholder="0"
                                               min="0">
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Hapus Varian -->
                            <div class="mt-3 sm:mt-4 flex justify-end">
                                <button type="button" 
                                        @click="variants.splice(index, 1)"
                                        class="inline-flex items-center px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-all duration-200 text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="flex flex-col sm:flex-row justify-end gap-3 sm:gap-4 pt-4 sm:pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('products.index') }}" class="px-4 sm:px-6 py-2 sm:py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 text-sm text-center">
                    Batal
                </a>
                <button type="submit" class="px-4 sm:px-6 py-2 sm:py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-all duration-200 text-sm">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
