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
