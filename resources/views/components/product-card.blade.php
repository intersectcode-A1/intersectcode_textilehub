@props(['product'])

<article class="card card-hover product-card">
    <div class="relative">
        <img src="{{ asset('storage/' . $product->foto) }}" 
             alt="{{ $product->nama }}"
             class="w-full h-56 object-cover transition duration-300 ease-in-out transform group-hover:scale-105">
        
        <div class="absolute top-3 right-3">
            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium {{ $product->stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                Stok: {{ $product->stok }} {{ $product->satuan }}
            </span>
        </div>
    </div>

    <div class="p-6">
        @if($product->category)
            <span class="inline-block bg-primary-100 text-primary-800 text-xs px-3 py-1 rounded-full mb-3 font-medium">
                {{ $product->category->name }}
            </span>
        @endif

        <h3 class="text-xl font-semibold text-gray-900 mb-2 leading-tight">
            {{ $product->nama }}
        </h3>
        
        <p class="text-sm text-gray-600 mb-4 line-clamp-2">
            {{ Str::limit($product->deskripsi, 80) }}
        </p>

        <div class="mb-6">
            <span class="text-2xl font-bold text-primary-600">
                Rp {{ number_format($product->harga, 0, ',', '.') }}
            </span>
            <span class="text-sm text-gray-500">/{{ $product->satuan }}</span>
        </div>

        <div class="space-y-3">
            <a href="{{ route('ecatalog.show', $product->id) }}" 
               class="btn-secondary w-full flex items-center justify-center">
                <i class="fas fa-eye mr-2"></i>
                Lihat Detail
            </a>

            @if($product->stok > 0)
                <button type="button"
                        onclick="Livewire.emit('openModal', 'add-to-cart', {{ json_encode(['product' => $product->id]) }})"
                        class="btn-primary w-full">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    Tambah ke Keranjang
                </button>
                
                <button type="button"
                        onclick="Livewire.emit('openModal', 'buy-now', {{ json_encode(['product' => $product->id]) }})"
                        class="btn-secondary w-full">
                    <i class="fas fa-bolt mr-2"></i>
                    Beli Sekarang
                </button>
            @else
                <div class="bg-gray-100 text-gray-600 text-sm text-center py-3 rounded-lg font-medium">
                    Stok Habis
                </div>
            @endif
        </div>
    </div>
</article> 