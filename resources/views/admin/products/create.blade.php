@extends('components.layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
<div class="mb-4 sm:mb-6">
    <h1 class="text-2xl font-extrabold text-blue-900 dark:text-blue-200 mb-2">Tambah Produk Baru</h1>
    <nav class="text-xs sm:text-sm font-medium text-blue-700 dark:text-blue-300 bg-gradient-to-r from-blue-50 to-indigo-100 dark:from-blue-900 dark:to-indigo-900 rounded-xl px-4 py-2 shadow mb-2 inline-block glass">
        <ol class="list-none p-0 inline-flex flex-wrap">
            <li class="flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700">Home</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li class="flex items-center">
                <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-700">Produk</a>
                <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"/></svg>
            </li>
            <li>
                <a href="#" class="text-gray-400" aria-current="page">Tambah Produk</a>
            </li>
        </ol>
    </nav>
</div>
<p class="text-lg text-blue-700 dark:text-blue-300 mb-8">Isi detail produk di bawah ini.</p>

@if($errors->any())
    <div class="mb-6 animate-fade-in-down">
        <div class="bg-gradient-to-r from-red-100 to-pink-100 dark:from-red-900 dark:to-pink-900 border-l-4 border-red-500 text-red-800 dark:text-red-200 p-4 rounded-xl shadow-lg flex items-center gap-3">
            <svg class="w-6 h-6 text-red-500 dark:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-1.414 1.414A9 9 0 105.636 18.364l1.414-1.414A7 7 0 1116.95 7.05z"/></svg>
            <div>
                <p class="font-bold">Terjadi Kesalahan</p>
                <ul class="mt-2 list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

<div class="bg-white/70 dark:bg-gray-800/80 glass rounded-2xl shadow-2xl p-8 border border-white/20 dark:border-gray-700">
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nama Produk -->
            <div>
                <label for="nama" class="block text-base font-bold text-blue-900 dark:text-blue-200 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                    class="w-full px-4 py-3 rounded-xl bg-white/60 dark:bg-gray-900 border-2 border-blue-100 dark:border-gray-700 text-blue-900 dark:text-blue-100 placeholder-blue-300 dark:placeholder-blue-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 transition-all duration-200 shadow-sm"
                    required placeholder="Masukkan nama produk">
                @error('nama')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <!-- Kategori -->
            <div>
                <label for="category_id" class="block text-base font-bold text-blue-900 dark:text-blue-200 mb-1">Kategori <span class="text-red-500">*</span></label>
                <select name="category_id" id="category_id"
                    class="w-full px-4 py-3 rounded-xl bg-white/60 dark:bg-gray-900 border-2 border-blue-100 dark:border-gray-700 text-blue-900 dark:text-blue-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 transition-all duration-200 shadow-sm"
                    required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <!-- Harga -->
            <div>
                <label for="harga" class="block text-base font-bold text-blue-900 dark:text-blue-200 mb-1">Harga <span class="text-red-500">*</span></label>
                <input type="number" name="harga" id="harga" value="{{ old('harga') }}"
                    class="w-full px-4 py-3 rounded-xl bg-white/60 dark:bg-gray-900 border-2 border-blue-100 dark:border-gray-700 text-blue-900 dark:text-blue-100 placeholder-blue-300 dark:placeholder-blue-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 transition-all duration-200 shadow-sm"
                    required min="0" step="1000" placeholder="0">
                @error('harga')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <!-- Stok -->
            <div>
                <label for="stok" class="block text-base font-bold text-blue-900 dark:text-blue-200 mb-1">Stok <span class="text-red-500">*</span></label>
                <input type="number" name="stok" id="stok" value="{{ old('stok') }}"
                    class="w-full px-4 py-3 rounded-xl bg-white/60 dark:bg-gray-900 border-2 border-blue-100 dark:border-gray-700 text-blue-900 dark:text-blue-100 placeholder-blue-300 dark:placeholder-blue-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 transition-all duration-200 shadow-sm"
                    required min="0" step="1" placeholder="0">
                @error('stok')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <!-- Satuan -->
            <div>
                <label for="satuan" class="block text-base font-bold text-blue-900 dark:text-blue-200 mb-1">Satuan <span class="text-red-500">*</span></label>
                <input type="text" name="satuan" id="satuan" value="{{ old('satuan') }}"
                    class="w-full px-4 py-3 rounded-xl bg-white/60 dark:bg-gray-900 border-2 border-blue-100 dark:border-gray-700 text-blue-900 dark:text-blue-100 placeholder-blue-300 dark:placeholder-blue-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 transition-all duration-200 shadow-sm"
                    required placeholder="Contoh: Pcs, Lusin, Kg">
                @error('satuan')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <!-- Foto -->
        <div class="border-t-2 border-blue-100 dark:border-blue-900 pt-6 mt-6">
            <label for="foto" class="block text-base font-bold text-blue-900 dark:text-blue-200 mb-1">Foto Produk</label>
            <div class="mt-2 flex items-center gap-6">
                <input type="file" name="foto" id="foto" accept="image/*"
                    class="w-full text-sm text-blue-700 dark:text-blue-200 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-200">
            </div>
            @error('foto')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <!-- Deskripsi -->
        <div class="border-t-2 border-blue-100 dark:border-blue-900 pt-6 mt-6">
            <label for="deskripsi" class="block text-base font-bold text-blue-900 dark:text-blue-200 mb-1">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="4"
                class="w-full px-4 py-3 rounded-xl bg-white/60 dark:bg-gray-900 border-2 border-blue-100 dark:border-gray-700 text-blue-900 dark:text-blue-100 placeholder-blue-300 dark:placeholder-blue-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 transition-all duration-200 shadow-sm"
                placeholder="Masukkan deskripsi produk">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <!-- Varian Produk -->
        <div x-data="{ variants: [] }" class="border-t-2 border-blue-100 dark:border-blue-900 pt-6 mt-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-2 sm:gap-3">
                <h3 class="text-lg font-bold text-blue-900 dark:text-blue-200">Varian Produk</h3>
                <button type="button" @click="variants.push({type: '', name: '', stock: 0, additional_price: 0})"
                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-100 to-indigo-200 text-blue-700 dark:from-blue-900 dark:to-indigo-900 dark:text-blue-200 rounded-xl shadow hover:from-blue-200 hover:to-indigo-300 dark:hover:from-blue-800 dark:hover:to-indigo-800 transition-all duration-200 text-sm font-bold">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Varian
                </button>
            </div>
            <div>
                <template x-for="(variant, index) in variants" :key="index">
                    <div class="bg-white/60 dark:bg-gray-900 border border-blue-100 dark:border-blue-800 p-4 rounded-xl mb-4 shadow-sm glass">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Tipe Varian -->
                            <div>
                                <label :for="'variants['+index+'][type]'" class="block text-sm font-bold text-blue-900 dark:text-blue-200 mb-1">Tipe Varian</label>
                                <input type="text" :name="'variants['+index+'][type]'" :id="'variants['+index+'][type]'" x-model="variant.type"
                                    class="w-full px-4 py-2 rounded-xl bg-white/80 dark:bg-gray-800 border-2 border-blue-100 dark:border-blue-700 text-blue-900 dark:text-blue-100 placeholder-blue-300 dark:placeholder-blue-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 transition-all duration-200 shadow-sm"
                                    placeholder="Contoh: Panjang, Warna, dll">
                            </div>
                            <!-- Nama Varian -->
                            <div>
                                <label :for="'variants['+index+'][name]'" class="block text-sm font-bold text-blue-900 dark:text-blue-200 mb-1">Nama Varian</label>
                                <input type="text" :name="'variants['+index+'][name]'" :id="'variants['+index+'][name]'" x-model="variant.name"
                                    class="w-full px-4 py-2 rounded-xl bg-white/80 dark:bg-gray-800 border-2 border-blue-100 dark:border-blue-700 text-blue-900 dark:text-blue-100 placeholder-blue-300 dark:placeholder-blue-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 transition-all duration-200 shadow-sm"
                                    placeholder="Contoh: 2 Meter, Merah, XL">
                            </div>
                            <!-- Stok Varian -->
                            <div>
                                <label :for="'variants['+index+'][stock]'" class="block text-sm font-bold text-blue-900 dark:text-blue-200 mb-1">Stok</label>
                                <input type="number" :name="'variants['+index+'][stock]'" :id="'variants['+index+'][stock]'" x-model.number="variant.stock"
                                    class="w-full px-4 py-2 rounded-xl bg-white/80 dark:bg-gray-800 border-2 border-blue-100 dark:border-blue-700 text-blue-900 dark:text-blue-100 placeholder-blue-300 dark:placeholder-blue-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 transition-all duration-200 shadow-sm"
                                    min="0" placeholder="0">
                            </div>
                            <!-- Tambahan Harga -->
                            <div>
                                <label :for="'variants['+index+'][additional_price]'" class="block text-sm font-bold text-blue-900 dark:text-blue-200 mb-1">Tambahan Harga</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-blue-400 dark:text-blue-300">Rp</span>
                                    </div>
                                    <input type="number" :name="'variants['+index+'][additional_price]'" :id="'variants['+index+'][additional_price]'" x-model.number="variant.additional_price"
                                        class="w-full pl-12 pr-4 py-2 rounded-xl bg-white/80 dark:bg-gray-800 border-2 border-blue-100 dark:border-blue-700 text-blue-900 dark:text-blue-100 placeholder-blue-300 dark:placeholder-blue-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 transition-all duration-200 shadow-sm"
                                        min="0" step="1000" placeholder="0">
                                </div>
                            </div>
                        </div>
                        <!-- Tombol Hapus Varian -->
                        <div class="flex justify-end mt-4">
                            <button type="button" @click="variants.splice(index, 1)"
                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-100 to-pink-200 dark:from-red-900 dark:to-pink-900 text-red-700 dark:text-red-200 rounded-xl shadow hover:from-red-200 hover:to-pink-300 dark:hover:from-red-800 dark:hover:to-pink-800 transition-all duration-200 font-bold">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
        <!-- Tombol Aksi -->
        <div class="flex flex-col sm:flex-row justify-end gap-4 pt-8 border-t-2 border-blue-100 dark:border-blue-900 mt-8">
            <a href="{{ route('products.index') }}" class="px-6 py-3 bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-200 rounded-xl hover:bg-gray-300 dark:hover:bg-gray-700 transition-all duration-200 text-base font-bold text-center">Batal</a>
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold rounded-xl shadow-lg hover:scale-105 hover:shadow-xl transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-blue-400 text-base">Tambah Produk</button>
        </div>
    </form>
</div>
@endsection
