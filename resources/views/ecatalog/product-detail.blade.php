<x-layouts.catalog>
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumb --}}
        <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-8">
            <a href="{{ route('ecatalog.index') }}" class="hover:text-blue-600">Katalog</a>
            <span>&gt;</span>
            <span class="text-gray-900">{{ $product->nama }}</span>
        </nav>

        {{-- Alert Messages --}}
        @if(session('success'))
            <div class="mb-6">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-8">
                {{-- Product Images --}}
                <div class="space-y-4">
                    <div class="aspect-w-1 aspect-h-1 bg-gray-200 rounded-lg overflow-hidden">
                        @if($product->foto)
                            <img src="{{ asset('storage/' . $product->foto) }}" 
                                 alt="{{ $product->nama }}" 
                                 class="w-full h-full object-center object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-500">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Product Info --}}
                <div class="space-y-6">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $product->nama }}</h1>
                    
                    <div class="flex items-baseline">
                        <p class="text-3xl font-bold text-green-600">
                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                        </p>
                        @if($product->old_price)
                            <p class="ml-4 text-lg text-gray-500 line-through">
                                Rp {{ number_format($product->old_price, 0, ',', '.') }}
                            </p>
                        @endif
                    </div>

                    {{-- Stock Status --}}
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->stok > 0 ? 'Stok Tersedia' : 'Stok Habis' }}
                        </span>
                        @if($product->stok > 0)
                            <span class="text-sm text-gray-500">
                                ({{ $product->stok }} unit)
                            </span>
                        @endif
                    </div>

                    {{-- Description --}}
                    <div class="prose prose-sm text-gray-500">
                        <h3 class="text-lg font-medium text-gray-900">Deskripsi Produk</h3>
                        <p>{{ $product->deskripsi ?: 'Tidak ada deskripsi produk.' }}</p>
                    </div>

                    {{-- Specifications --}}
                    @if($product->specifications)
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Spesifikasi</h3>
                        <div class="grid grid-cols-1 gap-4">
                            @foreach(json_decode($product->specifications) as $key => $value)
                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <dt class="font-medium text-gray-500">{{ $key }}</dt>
                                <dd class="col-span-2 text-gray-900">{{ $value }}</dd>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Action Buttons --}}
                    <div class="space-y-4 pt-6 border-t border-gray-200">
                        {{-- Quantity Selector --}}
                        <div class="flex items-center space-x-4">
                            <label for="quantity" class="text-sm font-medium text-gray-700">Jumlah:</label>
                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button type="button" class="p-2 text-gray-600 hover:text-gray-900" onclick="decrementQuantity()">-</button>
                                <input type="number" id="quantity" name="quantity" min="1" max="{{ $product->stok }}" value="1"
                                       class="w-16 text-center border-0 focus:ring-0">
                                <button type="button" class="p-2 text-gray-600 hover:text-gray-900" onclick="incrementQuantity()">+</button>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="quantity" id="cart-quantity" value="1">
                                <button type="submit"
                                        class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-3 rounded-lg transition duration-200 flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 7M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span>Tambah ke Keranjang</span>
                                </button>
                            </form>

                            <form action="{{ route('checkout.direct', $product->id) }}" method="GET" class="flex-1">
                                <input type="hidden" name="quantity" id="buy-quantity" value="1">
                                <button type="submit"
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition duration-200">
                                    Beli Sekarang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Related Products --}}
            @if(isset($relatedProducts) && $relatedProducts->count() > 0)
            <div class="border-t border-gray-200 px-8 py-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Produk Terkait</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                    <a href="{{ route('ecatalog.detail', $related->id) }}" class="group">
                        <div class="aspect-w-1 aspect-h-1 bg-gray-200 rounded-lg overflow-hidden">
                            @if($related->foto)
                                <img src="{{ asset('storage/' . $related->foto) }}" 
                                     alt="{{ $related->nama }}"
                                     class="w-full h-full object-center object-cover group-hover:opacity-75">
                            @endif
                        </div>
                        <div class="mt-4">
                            <h4 class="text-sm font-medium text-gray-900">{{ $related->nama }}</h4>
                            <p class="mt-1 text-sm font-medium text-green-600">Rp {{ number_format($related->harga, 0, ',', '.') }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </section>

    @push('scripts')
    <script>
        function incrementQuantity() {
            const input = document.getElementById('quantity');
            const maxStock = {{ $product->stok }};
            const currentValue = parseInt(input.value);
            if (currentValue < maxStock) {
                input.value = currentValue + 1;
                updateHiddenInputs(currentValue + 1);
            }
        }

        function decrementQuantity() {
            const input = document.getElementById('quantity');
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
                updateHiddenInputs(currentValue - 1);
            }
        }

        function updateHiddenInputs(value) {
            document.getElementById('cart-quantity').value = value;
            document.getElementById('buy-quantity').value = value;
        }

        // Update hidden inputs when quantity is manually changed
        document.getElementById('quantity').addEventListener('change', function(e) {
            const value = parseInt(e.target.value);
            const maxStock = {{ $product->stok }};
            if (value < 1) {
                e.target.value = 1;
                updateHiddenInputs(1);
            } else if (value > maxStock) {
                e.target.value = maxStock;
                updateHiddenInputs(maxStock);
            } else {
                updateHiddenInputs(value);
            }
        });
    </script>
    @endpush
</x-layouts.catalog> 