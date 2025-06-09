@extends('components.layouts.dashboard')

@section('content')
<div class="min-h-screen bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white">Tambah Produk Baru</h1>
            <p class="mt-2 text-lg text-gray-400">Isi form berikut untuk menambahkan produk baru ke katalog</p>
        </div>

        <div class="bg-gray-800 rounded-2xl shadow-xl border border-gray-700 overflow-hidden">
            <div class="p-8">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <!-- Nama Produk -->
                    <div>
                        <label for="nama" class="block text-base font-medium text-gray-300">
                            Nama Produk <span class="text-rose-500">*</span>
                        </label>
                        <div class="mt-2">
                            <input type="text" 
                                   name="nama" 
                                   id="nama" 
                                   value="{{ old('nama') }}" 
                                   class="w-full px-4 py-3 rounded-xl bg-gray-700/50 border-2 border-gray-600 text-gray-100 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-30 transition-all duration-200" 
                                   placeholder="Masukkan nama produk"
                                   required>
                        </div>
                        @error('nama')
                            <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Harga -->
                        <div>
                            <label for="harga" class="block text-base font-medium text-gray-300">
                                Harga <span class="text-rose-500">*</span>
                            </label>
                            <div class="mt-2 relative rounded-xl">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-gray-400">Rp</span>
                                </div>
                                <input type="number" 
                                       name="harga" 
                                       id="harga" 
                                       value="{{ old('harga') }}" 
                                       class="w-full pl-12 pr-4 py-3 rounded-xl bg-gray-700/50 border-2 border-gray-600 text-gray-100 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-30 transition-all duration-200" 
                                       placeholder="0"
                                       required>
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
                                       value="{{ old('stok') }}" 
                                       class="w-full px-4 py-3 rounded-xl bg-gray-700/50 border-2 border-gray-600 text-gray-100 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-30 transition-all duration-200" 
                                       placeholder="0"
                                       required>
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
                                       value="{{ old('satuan') }}"
                                       class="w-full px-4 py-3 rounded-xl bg-gray-700/50 border-2 border-gray-600 text-gray-100 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-30 transition-all duration-200"
                                       placeholder="Contoh: pcs, kg, m, dll">
                            </div>
                            @error('satuan')
                                <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="category_id" class="block text-base font-medium text-gray-300">
                            Kategori <span class="text-rose-500">*</span>
                        </label>
                        <div class="mt-2">
                            <select name="category_id" 
                                    id="category_id" 
                                    class="w-full px-4 py-3 rounded-xl bg-gray-700/50 border-2 border-gray-600 text-gray-100 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-30 transition-all duration-200" 
                                    required>
                                <option value="" disabled selected>-- Pilih Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('category_id')
                            <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsi" class="block text-base font-medium text-gray-300">
                            Deskripsi Produk
                        </label>
                        <div class="mt-2">
                            <textarea name="deskripsi" 
                                      id="deskripsi" 
                                      rows="4"
                                      class="w-full px-4 py-3 rounded-xl bg-gray-700/50 border-2 border-gray-600 text-gray-100 placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-30 transition-all duration-200"
                                      placeholder="Masukkan deskripsi produk">{{ old('deskripsi') }}</textarea>
                        </div>
                        @error('deskripsi')
                            <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Foto -->
                    <div>
                        <label for="foto" class="block text-base font-medium text-gray-300">
                            Foto Produk <span class="text-rose-500">*</span>
                        </label>
                        <div class="mt-2">
                            <div class="w-full flex flex-col items-center justify-center p-8 border-2 border-gray-600 border-dashed rounded-xl hover:border-indigo-500 hover:bg-gray-700/30 transition-all duration-300 cursor-pointer group" onclick="document.getElementById('foto').click()">
                                <!-- Area Upload -->
                                <div id="uploadIcon" class="text-center">
                                    <svg class="mx-auto h-16 w-16 text-gray-400 group-hover:text-indigo-400 transition-colors duration-300" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="mt-4">
                                        <span class="text-indigo-400 group-hover:text-indigo-300 text-lg font-medium transition-colors duration-300">Klik untuk upload gambar</span>
                                        <p class="text-sm text-gray-400 mt-2">PNG, JPG, JPEG (Maks. 2MB)</p>
                                    </div>
                                </div>

                                <!-- Preview Image -->
                                <div id="imagePreview" class="hidden w-full">
                                    <div class="relative w-full max-w-md mx-auto">
                                        <img id="preview" class="w-full h-80 object-contain rounded-lg" alt="Preview">
                                        <button type="button" 
                                                onclick="clearImage(event)" 
                                                class="absolute -top-2 -right-2 bg-rose-500 text-white rounded-full p-2 hover:bg-rose-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-rose-500 transition-all duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <p class="text-sm text-gray-400 mt-4 text-center" id="imageInfo"></p>
                                </div>

                                <input type="file" 
                                       id="foto" 
                                       name="foto" 
                                       class="hidden" 
                                       accept=".jpg,.jpeg,.png">
                            </div>
                        </div>
                        @error('foto')
                            <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center justify-end space-x-4 pt-6">
                        <a href="{{ route('products.index') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-600 rounded-xl text-base font-medium text-gray-300 bg-transparent hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-gray-500 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Batal
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-6 py-3 border-2 border-transparent rounded-xl text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-900 focus:ring-indigo-500 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('foto');
    fileInput.addEventListener('change', previewImage);
});

function previewImage(event) {
    const file = event.target.files[0];
    if (!file) return;

    // Validasi ukuran file (maksimal 2MB)
    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran file terlalu besar. Maksimal 2MB.');
        event.target.value = '';
        return;
    }

    // Validasi tipe file
    if (!['image/jpeg', 'image/jpg', 'image/png'].includes(file.type)) {
        alert('Tipe file tidak didukung. Gunakan JPG, JPEG, atau PNG.');
        event.target.value = '';
        return;
    }

    // Tampilkan preview
    const reader = new FileReader();
    reader.onload = function(e) {
        const uploadIcon = document.getElementById('uploadIcon');
        const imagePreview = document.getElementById('imagePreview');
        const preview = document.getElementById('preview');
        const imageInfo = document.getElementById('imageInfo');

        // Sembunyikan icon upload dan tampilkan preview
        uploadIcon.style.display = 'none';
        imagePreview.style.display = 'block';
        imagePreview.classList.remove('hidden');
        
        // Set gambar preview
        preview.src = e.target.result;
        
        // Tampilkan informasi file
        const fileSize = (file.size / 1024).toFixed(2);
        imageInfo.textContent = `${file.name} (${fileSize} KB)`;
    };
    reader.readAsDataURL(file);
}

function clearImage(event) {
    event.preventDefault();
    event.stopPropagation();

    const uploadIcon = document.getElementById('uploadIcon');
    const imagePreview = document.getElementById('imagePreview');
    const preview = document.getElementById('preview');
    const imageInfo = document.getElementById('imageInfo');
    const fileInput = document.getElementById('foto');

    // Reset semua elemen
    uploadIcon.style.display = 'block';
    imagePreview.style.display = 'none';
    imagePreview.classList.add('hidden');
    preview.src = '';
    imageInfo.textContent = '';
    fileInput.value = '';
}
</script>
@endpush

@endsection
