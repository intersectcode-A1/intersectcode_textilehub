<x-layouts.catalog>
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 bg-gray-50">
        {{-- Breadcrumb --}}
        <nav class="flex items-center space-x-2 text-sm text-gray-600 mb-8">
            <a href="{{ route('ecatalog.index') }}" class="hover:text-indigo-600 transition-colors duration-200">Katalog</a>
            <span class="text-gray-400">/</span>
            <span class="font-medium text-gray-900">{{ $product->nama }}</span>
        </nav>

        {{-- Alert Messages --}}
        @if(session('success'))
            <div class="mb-6 animate-fade-in-down">
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg shadow-sm" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 animate-fade-in-down">
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg shadow-sm" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 p-8">
                {{-- Product Images --}}
                <div class="space-y-4">
                    <div class="aspect-w-1 aspect-h-1 bg-gray-100 rounded-xl overflow-hidden ring-1 ring-gray-200">
                        @if($product->foto)
                            <img src="{{ asset('storage/' . $product->foto) }}" 
                                 alt="{{ $product->nama }}" 
                                 class="w-full h-full object-center object-cover hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-50">
                                <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Product Info --}}
                <div class="space-y-8">
                    <div class="space-y-4">
                        <h1 class="text-3xl font-bold text-gray-900 leading-tight">{{ $product->nama }}</h1>
                        
                        <div class="flex items-baseline space-x-4">
                            <p class="text-3xl font-bold text-indigo-600">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </p>
                            @if($product->old_price)
                                <p class="text-lg text-gray-400 line-through">
                                    Rp {{ number_format($product->old_price, 0, ',', '.') }}
                                </p>
                            @endif
                        </div>

                        {{-- Stock Status --}}
                        <div class="flex items-center space-x-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $product->stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->stok > 0 ? 'Stok Tersedia' : 'Stok Habis' }}
                            </span>
                            @if($product->stok > 0)
                                <span class="text-sm text-gray-600">
                                    {{ $product->stok }} unit tersedia
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="prose prose-sm text-gray-600 max-w-none">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Deskripsi Produk</h3>
                        <p class="leading-relaxed">{{ $product->deskripsi ?: 'Tidak ada deskripsi produk.' }}</p>
                    </div>

                    {{-- Specifications --}}
                    @if($product->specifications)
                    <div class="border-t border-gray-100 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Spesifikasi</h3>
                        <div class="grid grid-cols-1 gap-4">
                            @foreach(json_decode($product->specifications) as $key => $value)
                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <dt class="font-medium text-gray-600">{{ $key }}</dt>
                                <dd class="col-span-2 text-gray-900">{{ $value }}</dd>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Action Buttons --}}
                    <div class="space-y-6 pt-6 border-t border-gray-100">
                        {{-- Quantity Selector --}}
                        <div class="flex items-center space-x-4">
                            <label for="quantity" class="text-sm font-medium text-gray-700">Jumlah:</label>
                            <div class="flex items-center border border-gray-200 rounded-lg shadow-sm">
                                <button type="button" 
                                        class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors duration-200" 
                                        onclick="decrementQuantity()">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                    </svg>
                                </button>
                                <input type="number" 
                                       id="quantity" 
                                       name="quantity" 
                                       min="1" 
                                       max="{{ $product->stok }}" 
                                       value="1"
                                       class="w-16 text-center border-x border-gray-200 focus:ring-0 focus:outline-none">
                                <button type="button" 
                                        class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors duration-200" 
                                        onclick="incrementQuantity()">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="quantity" id="cart-quantity" value="1">
                                <button type="submit"
                                        class="w-full bg-white border-2 border-indigo-600 text-indigo-600 hover:bg-indigo-50 font-semibold px-6 py-3 rounded-xl transition duration-200 flex items-center justify-center space-x-2 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 7M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span>Tambah ke Keranjang</span>
                                </button>
                            </form>

                            <form action="{{ route('checkout.direct', $product->id) }}" method="GET" class="flex-1">
                                <input type="hidden" name="quantity" id="buy-quantity" value="1">
                                <button type="submit"
                                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-xl transition duration-200 shadow-sm">
                                    Beli Sekarang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Related Products --}}
            @if(isset($relatedProducts) && $relatedProducts->count() > 0)
            <div class="border-t border-gray-100 px-8 py-8 bg-gray-50">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Produk Terkait</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                    <a href="{{ route('ecatalog.detail', $related->id) }}" class="group">
                        <div class="aspect-w-1 aspect-h-1 bg-white rounded-lg overflow-hidden shadow-sm ring-1 ring-gray-200">
                            @if($related->foto)
                                <img src="{{ asset('storage/' . $related->foto) }}" 
                                     alt="{{ $related->nama }}"
                                     class="w-full h-full object-center object-cover group-hover:scale-105 transition-transform duration-300">
                            @endif
                        </div>
                        <div class="mt-4 space-y-1">
                            <h4 class="text-sm font-medium text-gray-900 group-hover:text-indigo-600 transition-colors duration-200">{{ $related->nama }}</h4>
                            <p class="text-sm font-medium text-indigo-600">Rp {{ number_format($related->harga, 0, ',', '.') }}</p>
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