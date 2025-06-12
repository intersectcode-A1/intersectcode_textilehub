@extends('components.layouts.admin')

@section('title', 'Edit Produk')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-300">Edit Produk</h1>
            <a href="{{ route('products.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 border border-red-200 text-red-700 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-gray-800 rounded-xl shadow-lg p-6">
            <form action="{{ route('products.update', $data) }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Produk -->
                    <div>
                        <label for="nama" class="block text-base font-medium text-gray-300">
                            Nama Produk <span class="text-rose-500">*</span>
                        </label>
                        <div class="mt-2">
                            <input type="text" 
                                name="nama" 
                                id="nama" 
                                value="{{ old('nama', $data->nama) }}"
                                class="w-full px-4 py-3 rounded-xl bg-gray-700/50 border-2 border-gray-600 text-gray-100 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-30 transition-all duration-200"
                                required
                                placeholder="Masukkan nama produk">
                        </div>
                        @error('nama')
                            <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="category_id" class="block text-base font-medium text-gray-300">
                            Kategori <span class="text-rose-500">*</span>
                        </label>
                        <div class="mt-2">
                            <select name="category_id" 
                                    id="category_id" 
                                    class="w-full px-4 py-3 rounded-xl bg-gray-700/50 border-2 border-gray-600 text-gray-100 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-30 transition-all duration-200"
                                    required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id', $data->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('category_id')
                            <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Harga -->
                    <div>
                        <label for="harga" class="block text-base font-medium text-gray-300">
                            Harga <span class="text-rose-500">*</span>
                        </label>
                        <div class="mt-2">
                            <input type="number" 
                                name="harga" 
                                id="harga" 
                                value="{{ old('harga', $data->harga) }}"
                                class="w-full px-4 py-3 rounded-xl bg-gray-700/50 border-2 border-gray-600 text-gray-100 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-30 transition-all duration-200"
                                required
                                min="0"
                                step="1000"
                                placeholder="0">
                        </div>
                        @error('harga')
                            <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stok -->
                    <div>
                        <label for="stok" class="block text-base font-medium text-gray-300">
                            Stok <span class="text-rose-500">*</span>
                        </label>
                        <div class="mt-2">
                            <input type="number" 
                                name="stok" 
                                id="stok" 
                                value="{{ old('stok', $data->stok) }}"
                                class="w-full px-4 py-3 rounded-xl bg-gray-700/50 border-2 border-gray-600 text-gray-100 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-30 transition-all duration-200"
                                required
                                min="0"
                                step="1"
                                placeholder="0">
                        </div>
                        @error('stok')
                            <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Satuan -->
                    <div>
                        <label for="satuan" class="block text-base font-medium text-gray-300">
                            Satuan <span class="text-rose-500">*</span>
                        </label>
                        <div class="mt-2">
                            <input type="text" 
                                   name="satuan" 
                                   id="satuan" 
                                   value="{{ old('satuan', $data->satuan) }}"
                                   class="w-full px-4 py-3 rounded-xl bg-gray-700/50 border-2 border-gray-600 text-gray-100 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-30 transition-all duration-200"
                                   required
                                   placeholder="Contoh: Pcs, Lusin, Kg">
                        </div>
                        @error('satuan')
                            <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Foto -->
                    <div class="md:col-span-2">
                        <label for="foto" class="block text-base font-medium text-gray-300">
                            Foto Produk
                        </label>
                        <div class="mt-2">
                            <input type="file" 
                                name="foto" 
                                id="foto" 
                                accept="image/*"
                                class="w-full px-4 py-3 rounded-xl bg-gray-700/50 border-2 border-gray-600 text-gray-100 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                        @if($data->foto)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $data->foto) }}" 
                                     alt="Preview" 
                                     class="w-32 h-32 object-cover rounded-lg">
                            </div>
                        @endif
                        @error('foto')
                            <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="md:col-span-2">
                        <label for="deskripsi" class="block text-base font-medium text-gray-300">
                            Deskripsi
                        </label>
                        <div class="mt-2">
                            <textarea name="deskripsi" 
                                      id="deskripsi" 
                                      rows="4" 
                                      class="w-full px-4 py-3 rounded-xl bg-gray-700/50 border-2 border-gray-600 text-gray-100 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-30 transition-all duration-200"
                                      placeholder="Masukkan deskripsi produk">{{ old('deskripsi', $data->deskripsi) }}</textarea>
                        </div>
                        @error('deskripsi')
                            <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Varian Produk -->
                <div x-data="{ variants: {{ json_encode($data->variants) }} }" class="border-t-2 border-gray-700 pt-6 mt-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-300">Varian Produk</h3>
                        <button type="button" 
                                @click="variants.push({type: '', name: '', stock: 0, additional_price: 0})"
                                class="inline-flex items-center px-4 py-2 bg-indigo-500/20 text-indigo-300 rounded-xl hover:bg-indigo-500/30 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Tambah Varian
                        </button>
                    </div>

                    <div>
                        <template x-for="(variant, index) in variants" :key="variant.id || index">
                            <div class="bg-gray-700/30 p-4 rounded-xl mb-4">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <!-- Tipe Varian -->
                                    <div>
                                        <label :for="'variants['+index+'][type]'" class="block text-sm font-medium text-gray-300 mb-1">
                                            Tipe Varian
                                        </label>
                                        <select :name="'variants['+index+'][type]'" 
                                                :id="'variants['+index+'][type]'"
                                                x-model="variant.type"
                                                class="w-full px-4 py-2 rounded-xl bg-gray-700/50 border-2 border-gray-600 text-gray-100 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-30 transition-all duration-200">
                                            <option value="">Pilih Tipe</option>
                                            <option value="color">Warna</option>
                                            <option value="size">Ukuran</option>
                                        </select>
                                    </div>

                                    <!-- Nama Varian -->
                                    <div>
                                        <label :for="'variants['+index+'][name]'" class="block text-sm font-medium text-gray-300 mb-1">
                                            Nama Varian
                                        </label>
                                        <input type="text" 
                                               :name="'variants['+index+'][name]'"
                                               :id="'variants['+index+'][name]'"
                                               x-model="variant.name"
                                               class="w-full px-4 py-2 rounded-xl bg-gray-700/50 border-2 border-gray-600 text-gray-100 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-30 transition-all duration-200"
                                               placeholder="Contoh: Merah, XL, dll">
                                        <!-- Hidden input untuk ID jika varian sudah ada -->
                                        <template x-if="variant.id">
                                            <input type="hidden" :name="'variants['+index+'][id]'" :value="variant.id">
                                        </template>
                                    </div>

                                    <!-- Stok Varian -->
                                    <div>
                                        <label :for="'variants['+index+'][stock]'" class="block text-sm font-medium text-gray-300 mb-1">
                                            Stok
                                        </label>
                                        <input type="number" 
                                               :name="'variants['+index+'][stock]'"
                                               :id="'variants['+index+'][stock]'"
                                               x-model.number="variant.stock"
                                               class="w-full px-4 py-2 rounded-xl bg-gray-700/50 border-2 border-gray-600 text-gray-100 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-30 transition-all duration-200"
                                               min="0"
                                               placeholder="0">
                                    </div>

                                    <!-- Tambahan Harga -->
                                    <div>
                                        <label :for="'variants['+index+'][additional_price]'" class="block text-sm font-medium text-gray-300 mb-1">
                                            Tambahan Harga
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <span class="text-gray-400">Rp</span>
                                            </div>
                                            <input type="number" 
                                                   :name="'variants['+index+'][additional_price]'"
                                                   :id="'variants['+index+'][additional_price]'"
                                                   x-model.number="variant.additional_price"
                                                   class="w-full pl-12 pr-4 py-2 rounded-xl bg-gray-700/50 border-2 border-gray-600 text-gray-100 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-30 transition-all duration-200"
                                                   min="0"
                                                   step="1000"
                                                   placeholder="0">
                                        </div>
                                    </div>
                                </div>

                                <!-- Tombol Hapus Varian -->
                                <div class="flex justify-end mt-4">
                                    <button type="button" 
                                            @click="variants.splice(index, 1)"
                                            class="inline-flex items-center px-3 py-1 bg-rose-500/20 text-rose-300 rounded-lg hover:bg-rose-500/30 transition-all duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus Varian
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('products.index') }}" 
                       class="px-6 py-3 rounded-xl border-2 border-gray-600 text-gray-300 hover:bg-gray-700/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-3 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
