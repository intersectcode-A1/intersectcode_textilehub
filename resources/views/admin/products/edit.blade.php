@extends('components.layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-900 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-white">Edit Produk</h1>
                <p class="mt-1 text-sm text-gray-400">Perbarui informasi produk yang ada</p>
            </div>
            <a href="{{ route('products.index') }}" 
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-300 bg-gray-700 border border-gray-600 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-indigo-500 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Daftar
            </a>
        </div>

        @if($errors->any())
            <div class="mb-6">
                <div class="bg-red-900/50 border-l-4 border-red-500 text-red-200 p-4 rounded-r-lg" role="alert">
                    <p class="font-semibold">Terjadi Kesalahan</p>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="bg-gray-800 rounded-xl shadow-lg border border-gray-700 p-6">
            <form action="{{ route('products.update', $product) }}" 
                method="POST" 
                enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Produk -->
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-300">
                            Nama Produk <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input type="text" 
                                name="nama" 
                                id="nama" 
                                value="{{ old('nama', $product->nama) }}"
                                class="w-full rounded-lg bg-gray-700 border-gray-600 text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm @error('nama') border-red-500 @enderror"
                                required
                                placeholder="Masukkan nama produk">
                        </div>
                        @error('nama')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-300">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <select name="category_id" 
                                    id="category_id"
                                    class="w-full rounded-lg bg-gray-700 border-gray-600 text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm @error('category_id') border-red-500 @enderror"
                                    required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Harga -->
                    <div>
                        <label for="harga" class="block text-sm font-medium text-gray-300">
                            Harga <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-400 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" 
                                name="harga" 
                                id="harga" 
                                value="{{ old('harga', $product->harga) }}"
                                class="pl-12 w-full rounded-lg bg-gray-700 border-gray-600 text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm @error('harga') border-red-500 @enderror"
                                required
                                min="0"
                                step="1"
                                placeholder="0">
                        </div>
                        @error('harga')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stok -->
                    <div>
                        <label for="stok" class="block text-sm font-medium text-gray-300">
                            Stok <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input type="number" 
                                name="stok" 
                                id="stok" 
                                value="{{ old('stok', $product->stok) }}"
                                class="w-full rounded-lg bg-gray-700 border-gray-600 text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm @error('stok') border-red-500 @enderror"
                                required
                                min="0"
                                step="1"
                                placeholder="0">
                        </div>
                        @error('stok')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Satuan -->
                    <div>
                        <label for="satuan" class="block text-sm font-medium text-gray-300">
                            Satuan
                        </label>
                        <div class="mt-1">
                            <input type="text" 
                                name="satuan" 
                                id="satuan" 
                                value="{{ old('satuan', $product->satuan) }}"
                                class="w-full rounded-lg bg-gray-700 border-gray-600 text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm @error('satuan') border-red-500 @enderror"
                                placeholder="Contoh: pcs, kg, m, dll">
                        </div>
                        @error('satuan')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-300">
                        Deskripsi Produk
                    </label>
                    <div class="mt-1">
                        <textarea name="deskripsi" 
                                id="deskripsi" 
                                rows="4"
                                class="w-full rounded-lg bg-gray-700 border-gray-600 text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm @error('deskripsi') border-red-500 @enderror"
                                placeholder="Masukkan deskripsi produk">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                    </div>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Foto -->
                <div>
                    <label for="foto" class="block text-sm font-medium text-gray-300">
                        Foto Produk
                    </label>
                    <div class="mt-1">
                        <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-600 border-dashed rounded-lg hover:border-indigo-500 transition-colors duration-200">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-400">
                                    <label for="foto" class="relative cursor-pointer rounded-md font-medium text-indigo-400 hover:text-indigo-300 focus-within:outline-none">
                                        <span>Upload a file</span>
                                        <input id="foto" name="foto" type="file" class="sr-only" accept="image/*" onchange="previewImage(event)">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                            </div>
                        </div>
                    </div>
                    @error('foto')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror

                    <!-- Preview Foto -->
                    <div class="mt-4 flex gap-4">
                        @if($product->foto)
                            <div>
                                <p class="text-sm text-gray-400 mb-1">Foto Saat Ini:</p>
                                <img src="{{ asset('storage/' . $product->foto) }}" 
                                    alt="Preview" 
                                    class="w-32 h-32 object-cover rounded-lg shadow-sm border border-gray-600">
                            </div>
                        @endif
                        <div id="imagePreview" class="hidden">
                            <p class="text-sm text-gray-400 mb-1">Preview Foto Baru:</p>
                            <img id="preview" class="w-32 h-32 object-cover rounded-lg shadow-sm border border-gray-600">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-3 pt-4">
                    <a href="{{ route('products.index') }}" 
                    class="inline-flex justify-center py-2 px-4 border border-gray-600 shadow-sm text-sm font-medium rounded-lg text-gray-300 bg-gray-700 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-indigo-500 transition-colors duration-200">
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-indigo-500 transition-colors duration-200">
                        Perbarui Produk
                    </button>
                </div>
            </form>
        </div>
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
