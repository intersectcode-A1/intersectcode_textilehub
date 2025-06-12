@extends('components.layouts.admin')

@section('title', isset($product) ? 'Edit Produk' : 'Tambah Produk')

@section('content')
<div class="container px-6 mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            {{ isset($product) ? 'Edit Produk' : 'Tambah Produk Baru' }}
        </h1>
        <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    @if($errors->any())
        <div class="mb-6">
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                <p class="font-bold">Terjadi Kesalahan</p>
                <ul class="mt-2 list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ isset($product) ? route('products.update', $product) : route('products.store') }}" 
              method="POST" 
              enctype="multipart/form-data"
              class="space-y-6">
            @csrf
            @if(isset($product))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Produk -->
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Produk <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="nama" 
                           id="nama" 
                           value="{{ old('nama', $product->nama ?? '') }}"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('nama') border-red-300 @enderror"
                           required
                           placeholder="Masukkan nama produk">
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" 
                            id="category_id"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('category_id') border-red-300 @enderror"
                            required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Harga -->
                <div>
                    <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">
                        Harga <span class="text-red-500">*</span>
                    </label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">Rp</span>
                        </div>
                        <input type="number" 
                               name="harga" 
                               id="harga" 
                               value="{{ old('harga', $product->harga ?? '') }}"
                               class="pl-12 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('harga') border-red-300 @enderror"
                               required
                               min="0"
                               step="1"
                               placeholder="0">
                    </div>
                    @error('harga')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stok -->
                <div>
                    <label for="stok" class="block text-sm font-medium text-gray-700 mb-1">
                        Stok <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="stok" 
                           id="stok" 
                           value="{{ old('stok', $product->stok ?? '') }}"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('stok') border-red-300 @enderror"
                           required
                           min="0"
                           step="1"
                           placeholder="0">
                    @error('stok')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Satuan -->
                <div class="col-span-6 sm:col-span-3">
                    <label for="satuan" class="block text-sm font-medium text-gray-700 mb-1">
                        Satuan
                    </label>
                    <input type="text"
                        name="satuan"
                        id="satuan"
                        value="{{ old('satuan', $product->satuan ?? '') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('satuan') border-red-300 @enderror"
                        placeholder="Contoh: pcs, kg, meter">
                    @error('satuan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">
                    Deskripsi Produk
                </label>
                <textarea name="deskripsi" 
                          id="deskripsi" 
                          rows="4"
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('deskripsi') border-red-300 @enderror"
                          placeholder="Masukkan deskripsi produk">{{ old('deskripsi', $product->deskripsi ?? '') }}</textarea>
                @error('deskripsi')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Foto -->
            <div>
                <label for="foto" class="block text-sm font-medium text-gray-700 mb-1">
                    Foto Produk
                </label>
                <div class="mt-1 flex items-center">
                    <div class="space-y-2">
                        <input type="file" 
                               name="foto" 
                               id="foto" 
                               accept="image/*"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 @error('foto') border-red-300 @enderror"
                               onchange="previewImage(event)">
                        <p class="text-xs text-gray-500">Format: JPG, JPEG, PNG (Maks. 2MB)</p>
                    </div>
                </div>
                @error('foto')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- Preview Foto -->
                <div class="mt-4">
                    @if(isset($product) && $product->foto)
                        <div class="mb-2">
                            <p class="text-sm text-gray-500 mb-1">Foto Saat Ini:</p>
                            <img src="{{ asset('storage/' . $product->foto) }}" 
                                 alt="Preview" 
                                 class="w-32 h-32 object-cover rounded-lg shadow-sm">
                        </div>
                    @endif
                    <div id="imagePreview" class="hidden">
                        <p class="text-sm text-gray-500 mb-1">Preview Foto Baru:</p>
                        <img id="preview" class="w-32 h-32 object-cover rounded-lg shadow-sm">
                    </div>
                </div>
            </div>

            <!-- Variants Section -->
            <div class="border-t border-gray-300 mt-8 pt-8">
                <h3 class="text-lg font-medium text-gray-700 mb-4">Varian Produk</h3>
                <div x-data="{ variants: [] }">
                    <div class="mb-4">
                        <button type="button" 
                                @click="variants.push({type: '', name: '', stock: 0, additional_price: 0})"
                                class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Tambah Varian
                        </button>
                    </div>

                    <template x-for="(variant, index) in variants" :key="index">
                        <div class="bg-gray-50 p-4 rounded-lg mb-4">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <label :for="'variants['+index+'][type]'" class="block text-sm font-medium text-gray-700 mb-1">
                                        Tipe Varian
                                    </label>
                                    <select :name="'variants['+index+'][type]'" 
                                            :id="'variants['+index+'][type]'"
                                            x-model="variant.type"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <option value="">Pilih Tipe</option>
                                        <option value="color">Warna</option>
                                        <option value="size">Ukuran</option>
                                    </select>
                                </div>

                                <div>
                                    <label :for="'variants['+index+'][name]'" class="block text-sm font-medium text-gray-700 mb-1">
                                        Nama Varian
                                    </label>
                                    <input type="text" 
                                           :name="'variants['+index+'][name]'"
                                           :id="'variants['+index+'][name]'"
                                           x-model="variant.name"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                           placeholder="Contoh: Merah, XL, dll">
                                </div>

                                <div>
                                    <label :for="'variants['+index+'][stock]'" class="block text-sm font-medium text-gray-700 mb-1">
                                        Stok
                                    </label>
                                    <input type="number" 
                                           :name="'variants['+index+'][stock]'"
                                           :id="'variants['+index+'][stock]'"
                                           x-model="variant.stock"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                           min="0">
                                </div>

                                <div>
                                    <label :for="'variants['+index+'][additional_price]'" class="block text-sm font-medium text-gray-700 mb-1">
                                        Tambahan Harga
                                    </label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">Rp</span>
                                        </div>
                                        <input type="number" 
                                               :name="'variants['+index+'][additional_price]'"
                                               :id="'variants['+index+'][additional_price]'"
                                               x-model="variant.additional_price"
                                               class="pl-12 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                               min="0">
                                    </div>
                                </div>

                                <div class="md:col-span-4 flex justify-end">
                                    <button type="button" 
                                            @click="variants.splice(index, 1)"
                                            class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-md hover:bg-red-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus Varian
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- Existing Variants -->
                    @if(isset($product) && $product->variants)
                        @foreach($product->variants as $variant)
                            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Tipe Varian
                                        </label>
                                        <input type="text" 
                                               name="existing_variants[{{ $variant->id }}][type]" 
                                               value="{{ $variant->type }}"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                               readonly>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Nama Varian
                                        </label>
                                        <input type="text" 
                                               name="existing_variants[{{ $variant->id }}][name]"
                                               value="{{ $variant->name }}"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Stok
                                        </label>
                                        <input type="number" 
                                               name="existing_variants[{{ $variant->id }}][stock]"
                                               value="{{ $variant->stock }}"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                               min="0">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">
                                            Tambahan Harga
                                        </label>
                                        <div class="relative rounded-md shadow-sm">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">Rp</span>
                                            </div>
                                            <input type="number" 
                                                   name="existing_variants[{{ $variant->id }}][additional_price]"
                                                   value="{{ $variant->additional_price }}"
                                                   class="pl-12 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                   min="0">
                                        </div>
                                    </div>

                                    <div class="md:col-span-4 flex justify-end">
                                        <button type="button" 
                                                onclick="if(confirm('Apakah Anda yakin ingin menghapus varian ini?')) document.getElementById('delete-variant-{{ $variant->id }}').submit()"
                                                class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-md hover:bg-red-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus Varian
                                        </button>
                                        <form id="delete-variant-{{ $variant->id }}" 
                                              action="{{ route('product-variants.destroy', $variant) }}" 
                                              method="POST" 
                                              class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('products.index') }}" 
                   class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Batal
                </a>
                <button type="submit" 
                        class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    {{ isset($product) ? 'Perbarui Produk' : 'Simpan Produk' }}
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('imagePreview');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    } else {
        preview.src = '';
        previewContainer.classList.add('hidden');
    }
}
</script>
@endpush

@endsection 