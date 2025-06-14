<div class="bg-white p-6 rounded-lg shadow-sm">
    <h3 class="text-lg font-semibold mb-4">{{ isset($variant) ? 'Edit Varian' : 'Tambah Varian Baru' }}</h3>

    <form action="{{ isset($variant) ? route('admin.variants.update', $variant->id) : route('admin.variants.store', $product->id) }}" 
          method="POST" 
          class="space-y-4">
        @csrf
        @if(isset($variant))
            @method('PUT')
        @endif

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Varian</label>
            <input type="text" 
                   name="name" 
                   id="name" 
                   value="{{ old('name', $variant->name ?? '') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                   required>
        </div>

        <div>
            <label for="type" class="block text-sm font-medium text-gray-700">Tipe Varian</label>
            <select name="type" 
                    id="type" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                    required>
                <option value="color" {{ (old('type', $variant->type ?? '') == 'color') ? 'selected' : '' }}>Warna</option>
                <option value="size" {{ (old('type', $variant->type ?? '') == 'size') ? 'selected' : '' }}>Ukuran</option>
            </select>
        </div>

        <div>
            <label for="stock" class="block text-sm font-medium text-gray-700">Stok</label>
            <input type="number" 
                   name="stock" 
                   id="stock" 
                   value="{{ old('stock', $variant->stock ?? 0) }}"
                   min="0"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                   required>
        </div>

        <div>
            <label for="additional_price" class="block text-sm font-medium text-gray-700">Harga Tambahan</label>
            <div class="mt-1 relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="text-gray-500 sm:text-sm">Rp</span>
                </div>
                <input type="number" 
                       name="additional_price" 
                       id="additional_price" 
                       value="{{ old('additional_price', $variant->additional_price ?? 0) }}"
                       min="0"
                       class="pl-12 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                       required>
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <button type="button" 
                    onclick="window.history.back()" 
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                Batal
            </button>
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                {{ isset($variant) ? 'Simpan Perubahan' : 'Tambah Varian' }}
            </button>
        </div>
    </form>
</div> 