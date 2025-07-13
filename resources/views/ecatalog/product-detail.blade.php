<x-layouts.catalog>
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Tombol Kembali ke E-Catalog (paling atas) --}}
        <a href="/" class="inline-flex items-center mb-6 px-5 py-2 bg-blue-600 hover:bg-blue-800 text-white font-bold rounded-xl shadow-md hover:scale-105 transition-all duration-150">
            <svg class="w-5 h-5 mr-2 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
            Kembali ke E-Catalog
        </a>

        {{-- Breadcrumb --}}
        <nav class="flex items-center space-x-2 text-sm text-blue-500 mb-8">
            <a href="{{ route('ecatalog.index') }}" class="hover:text-blue-700 font-semibold">Katalog</a>
            <span class="text-blue-300">&gt;</span>
            <span class="text-blue-900 font-bold">{{ $product->nama }}</span>
        </nav>

        {{-- Alert Messages --}}
        @if(session('success'))
            <div class="mb-6">
                <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-900 px-6 py-4 rounded-xl shadow-md flex items-center gap-3">
                    <svg class="w-6 h-6 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6">
                <div class="bg-red-50 border-l-4 border-red-400 text-red-900 px-6 py-4 rounded-xl shadow-md flex items-center gap-3">
                    <svg class="w-6 h-6 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-semibold">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-md border border-blue-100 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-8">
                {{-- Product Images --}}
                <div class="space-y-4">
                    <div class="aspect-w-1 aspect-h-1 bg-blue-50 rounded-xl overflow-hidden border border-blue-100">
                        @if($product->foto)
                            <img src="{{ asset('storage/' . $product->foto) }}" 
                                 alt="{{ $product->nama }}" 
                                 class="w-full h-full object-center object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-blue-200">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Product Info --}}
                <div class="space-y-6">
                    <h1 class="text-3xl font-bold text-blue-900">{{ $product->nama }}</h1>
                    
                    <div class="flex items-baseline">
                        @if($product->discount && $product->discount > 0)
                            <p class="text-3xl font-bold text-blue-600">
                                Rp {{ number_format($product->harga_setelah_diskon, 0, ',', '.') }}
                            </p>
                            <p class="ml-4 text-lg text-blue-300 line-through">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </p>
                            <span class="ml-2 inline-block px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">-{{ number_format($product->discount, 1) }}%</span>
                        @else
                            <p class="text-3xl font-bold text-blue-600">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </p>
                        @endif
                    </div>

                    {{-- Stock Status --}}
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                            {{ $product->stok > 0 ? 'Stok Tersedia' : 'Stok Habis' }}
                        </span>
                        @if($product->stok > 0)
                            <span class="text-sm text-blue-300">/{{ $product->satuan }}</span>
                        @endif
                    </div>

                    {{-- Variant Info --}}
                    @if($product->variants && $product->variants->count() > 0)
                        <div class="border-t border-blue-100 pt-4">
                            <h3 class="text-lg font-medium text-blue-900 mb-2">Varian Produk</h3>
                            @php $groupedVariants = $product->variants->groupBy('type'); @endphp
                            @foreach($groupedVariants as $type => $variants)
                                <div class="mb-2">
                                    <span class="font-semibold text-blue-700">{{ ucfirst($type) }}</span>:
                                    @foreach($variants as $variant)
                                        <span class="inline-block bg-blue-50 border border-blue-200 rounded px-2 py-1 text-sm text-blue-800 mr-2 mb-1">
                                            {{ $variant->name }}
                                            @if($variant->additional_price > 0)
                                                <span class="text-blue-600">(+Rp {{ number_format($variant->additional_price, 0, ',', '.') }})</span>
                                            @endif
                                        </span>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="border-t border-blue-100 pt-4">
                            <span class="text-blue-300">Tidak ada varian untuk produk ini.</span>
                        </div>
                    @endif

                    {{-- Description --}}
                    <div class="prose prose-sm text-blue-700">
                        <h3 class="text-lg font-medium text-blue-900">Deskripsi Produk</h3>
                        <p>{{ $product->deskripsi ?: 'Tidak ada deskripsi produk.' }}</p>
                    </div>

                    {{-- Specifications --}}
                    @if($product->specifications)
                    <div class="border-t border-blue-100 pt-6">
                        <h3 class="text-lg font-medium text-blue-900 mb-4">Spesifikasi</h3>
                        <div class="grid grid-cols-1 gap-4">
                            @foreach(json_decode($product->specifications) as $key => $value)
                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <dt class="font-medium text-blue-400">{{ $key }}</dt>
                                <dd class="col-span-2 text-blue-900">{{ $value }}</dd>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Action Buttons --}}
                    <div class="space-y-4 pt-6 border-t border-blue-100">
                        {{-- Variant Selector --}}
                        @if($product->variants && $product->variants->count() > 0)
                            <div x-data="{ 
                                selectedVariants: {},
                                variantTypes: {{ json_encode($product->variants->pluck('type')->unique()) }},
                                additionalPrice: 0,
                                
                                updatePrice() {
                                    this.additionalPrice = Object.values(this.selectedVariants)
                                        .reduce((sum, variant) => sum + parseFloat(variant.additional_price), 0);
                                },
                                
                                isVariantAvailable(variantId) {
                                    const variant = this.selectedVariants[variantId];
                                    return variant ? variant.stock >= {{ $quantity ?? 1 }} : true;
                                },
                                
                                allVariantsSelected() {
                                    return this.variantTypes.every(type => 
                                        Object.values(this.selectedVariants).some(v => v.type === type)
                                    );
                                }
                            }" class="space-y-4">
                                {{-- Group variants by type --}}
                                @php
                                    $groupedVariants = $product->variants->groupBy('type');
                                @endphp

                                @foreach($groupedVariants as $type => $variants)
                                    <div class="space-y-2">
                                        <label class="block text-sm font-medium text-blue-700">
                                            {{ $type === 'color' ? 'Pilih Warna' : 'Pilih Ukuran' }}:
                                            <span class="text-rose-500">*</span>
                                        </label>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($variants as $variant)
                                                <button type="button"
                                                        @click="selectedVariants['{{ $type }}'] = {{ json_encode($variant) }}; updatePrice()"
                                                        :class="{
                                                            'ring-2 ring-blue-500 border-blue-500 bg-blue-50': selectedVariants['{{ $type }}']?.id === {{ $variant->id }},
                                                            'ring-1 ring-blue-100 opacity-50 cursor-not-allowed': !isVariantAvailable({{ $variant->id }}),
                                                            'ring-1 ring-blue-100 hover:border-blue-500 hover:bg-blue-50': isVariantAvailable({{ $variant->id }}) && selectedVariants['{{ $type }}']?.id !== {{ $variant->id }}
                                                        }"
                                                        :disabled="!isVariantAvailable({{ $variant->id }})"
                                                        class="px-4 py-2 rounded-lg bg-white border text-sm font-medium transition-all duration-200">
                                                    <div class="flex items-center space-x-2">
                                                        <span>{{ $variant->name }}</span>
                                                        @if($variant->additional_price > 0)
                                                            <span class="text-xs text-blue-600">(+{{ number_format($variant->additional_price, 0, ',', '.') }})</span>
                                                        @endif
                                                    </div>
                                                    <div class="text-xs text-blue-400 mt-1">
                                                        Stok: {{ $variant->stock }}
                                                    </div>
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach

                                {{-- Total Price Display --}}
                                <div class="mt-4 text-lg font-semibold text-blue-900">
                                    Total Harga: 
                                    <span x-text="'Rp ' + new Intl.NumberFormat('id-ID').format({{ $product->harga }} + additionalPrice)"></span>
                                </div>

                                {{-- Error message for variants --}}
                                <div x-show="!allVariantsSelected()" 
                                     class="text-sm text-rose-500 mt-2">
                                    Silakan pilih semua varian yang tersedia
                                </div>
                            </div>
                        @endif

                        {{-- Quantity Selector --}}
                        <div class="flex items-center space-x-4">
                            <label for="quantity" class="text-sm font-medium text-blue-700">Jumlah:</label>
                            <div class="flex items-center border border-blue-300 rounded-lg">
                                <button type="button" 
                                        class="p-2 text-blue-600 hover:text-blue-900 disabled:opacity-50" 
                                        onclick="decrementQuantity()"
                                        :disabled="!allVariantsSelected()">
                                    -
                                </button>
                                <input type="number" 
                                       id="quantity" 
                                       name="quantity" 
                                       min="1" 
                                       max="{{ $product->stok }}" 
                                       value="1"
                                       :disabled="!allVariantsSelected()"
                                       class="w-16 text-center border-0 focus:ring-0 disabled:opacity-50">
                                <button type="button" 
                                        class="p-2 text-blue-600 hover:text-blue-900 disabled:opacity-50" 
                                        onclick="incrementQuantity()"
                                        :disabled="!allVariantsSelected()">
                                    +
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1" x-data>
                                @csrf
                                <input type="hidden" name="quantity" id="cart-quantity" value="1">
                                <template x-if="selectedVariants">
                                    <input type="hidden" name="variants" :value="JSON.stringify(Object.values(selectedVariants))">
                                </template>
                                <button type="submit"
                                        :disabled="!allVariantsSelected()"
                                        :class="{'opacity-50 cursor-not-allowed': !allVariantsSelected()}"
                                        class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-3 rounded-lg transition duration-200 flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 7M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span>Tambah ke Keranjang</span>
                                </button>
                            </form>

                            <form action="{{ route('checkout.direct', $product->id) }}" method="GET" class="flex-1" x-data>
                                <input type="hidden" name="quantity" id="buy-quantity" value="1">
                                <template x-if="selectedVariants">
                                    <input type="hidden" name="variants" :value="JSON.stringify(Object.values(selectedVariants))">
                                </template>
                                <button type="submit"
                                        :disabled="!allVariantsSelected()"
                                        :class="{'opacity-50 cursor-not-allowed': !allVariantsSelected()}"
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