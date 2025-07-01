@props(['product'])

<div x-data="{ 
    showModal: false, 
    quantity: 1,
    isCheckout: false,
    maxStock: {{ $product->stok }},
    selectedVariants: {},
    additionalPrice: 0,
    variantStocks: {},
    currentStock: {{ $product->stok }},
    
    decrease() { if (this.quantity > 1) this.quantity--; },
    increase() { if (this.quantity < this.currentStock) this.quantity++; },
    
    updatePrice() {
        this.additionalPrice = Object.values(this.selectedVariants)
            .reduce((sum, variant) => sum + parseFloat(variant.additional_price), 0);
    },
    
    updateStock() {
        if (Object.keys(this.selectedVariants).length > 0) {
            this.currentStock = Math.min(...Object.values(this.variantStocks));
        } else {
            this.currentStock = this.maxStock;
        }
        if (this.quantity > this.currentStock) {
            this.quantity = this.currentStock;
        }
    },
    
    submit() {
        const form = this.isCheckout ? 
            document.getElementById('checkout-form-' + {{ $product->id }}) : 
            document.getElementById('cart-form-' + {{ $product->id }});
            
        // Set quantity
        form.querySelector('input[name=quantity]').value = this.quantity;
        
        // Set selected variants
        const selectedVariantIds = Object.values(this.selectedVariants).map(v => v.id);
        // Jumlah varian yang harus dipilih
        const requiredVariants = {{ isset($groupedVariants) ? $groupedVariants->count() : 0 }};
        if (Object.keys(this.selectedVariants).length < requiredVariants) {
            alert('Pilih semua varian terlebih dahulu!');
            return;
        }
        form.querySelector('input[name=selected_variants]').value = selectedVariantIds.join(',');
        
        form.submit();
    }
}">
    <!-- Trigger Buttons -->
    <div class="flex space-x-3">
        <button @click="showModal = true; isCheckout = true" 
                class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-4 py-3 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl flex items-center justify-center font-semibold">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 7M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            Checkout
        </button>
        <button @click="showModal = true; isCheckout = false"
                class="flex-1 bg-gradient-to-r from-yellow-500 to-orange-500 text-white px-4 py-3 rounded-xl hover:from-yellow-600 hover:to-orange-600 transition-all duration-200 transform hover:-translate-y-0.5 shadow-lg hover:shadow-xl flex items-center justify-center font-semibold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
        </button>
    </div>

    <!-- Modal -->
    <div x-show="showModal" 
         class="fixed inset-0 z-50 overflow-y-auto"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 py-6">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showModal = false"></div>

            <!-- Modal Content -->
            <div class="relative bg-white rounded-2xl max-w-lg w-full p-8 shadow-2xl transform transition-all border border-gray-100"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 -translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 -translate-y-4">
                
                <!-- Close Button -->
                <button @click="showModal = false" 
                        class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <div class="space-y-6">
                    <!-- Product Title -->
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">
                            {{ $product->nama }}
                        </h3>
                        <p class="text-gray-500">Pilih spesifikasi produk</p>
                    </div>

                    <!-- Stock Information -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-4 border border-blue-200">
                        <div class="flex items-center mb-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <p class="font-semibold text-blue-800">Informasi Stok</p>
                        </div>
                        <template x-if="Object.keys(selectedVariants).length === 0">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <p class="text-sm text-blue-700 font-medium">Stok Total: {{ $product->stok }} {{ $product->satuan }}</p>
                            </div>
                        </template>
                        <template x-if="Object.keys(selectedVariants).length > 0">
                            <div class="space-y-2">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <p class="text-sm text-blue-700 font-medium">
                                        Stok Tersedia: <span x-text="currentStock"></span> {{ $product->satuan }}
                                    </p>
                                </div>
                                <div class="pl-6 space-y-1">
                                    <template x-for="(variant, type) in selectedVariants" :key="type">
                                        <p class="text-xs text-blue-600 flex items-center space-x-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                            </svg>
                                            <span x-text="type === 'color' ? 'Warna' : 'Ukuran'"></span>:
                                            <span x-text="variant.name" class="font-medium"></span>
                                            <span class="text-blue-500">(Stok: <span x-text="variantStocks[type]"></span>)</span>
                                        </p>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Quantity Selector -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <p class="text-center text-sm font-medium text-gray-700 mb-4">Pilih Jumlah</p>
                        <div class="flex items-center justify-center space-x-6">
                            <button @click="decrease()"
                                    class="w-12 h-12 rounded-full border-2 border-gray-300 flex items-center justify-center hover:bg-white hover:border-blue-500 hover:shadow-lg transition-all duration-200">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                </svg>
                            </button>
                            <div class="w-20 text-center">
                                <span x-text="quantity" class="text-3xl font-bold text-gray-800"></span>
                                <p class="text-xs text-gray-500 mt-1">{{ $product->satuan }}</p>
                            </div>
                            <button @click="increase()"
                                    class="w-12 h-12 rounded-full border-2 border-gray-300 flex items-center justify-center hover:bg-white hover:border-blue-500 hover:shadow-lg transition-all duration-200">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Variants -->
                    @if($product->variants && $product->variants->isNotEmpty())
                        @php
                            $groupedVariants = $product->variants->groupBy('type');
                        @endphp
                        @foreach($groupedVariants as $type => $variants)
                            <div class="space-y-3">
                                <p class="font-semibold text-gray-800 flex items-center">
                                    Pilih {{ ucfirst($type) }}
                                </p>
                                <div class="grid grid-cols-3 gap-3">
                                    @foreach($variants as $variant)
                                        <button type="button"
                                                @click="
                                                    if (selectedVariants['{{ $type }}']?.id === {{ $variant->id }}) {
                                                        delete selectedVariants['{{ $type }}'];
                                                    } else {
                                                        selectedVariants['{{ $type }}'] = {
                                                            id: {{ $variant->id }},
                                                            name: '{{ $variant->name }}',
                                                            type: '{{ $variant->type }}',
                                                            additional_price: {{ $variant->additional_price }}
                                                        };
                                                        variantStocks['{{ $type }}'] = {{ $variant->stock }};
                                                    }
                                                    updatePrice();
                                                    updateStock();
                                                "
                                                :class="{
                                                    'ring-2 ring-blue-500 border-blue-300 bg-blue-50 text-blue-700 shadow-lg': selectedVariants['{{ $type }}']?.id === {{ $variant->id }},
                                                    'hover:border-blue-400 hover:bg-gray-50 hover:shadow-md': selectedVariants['{{ $type }}']?.id !== {{ $variant->id }}
                                                }"
                                                class="p-4 border rounded-xl text-center transition-all duration-200 bg-white">
                                            <p class="font-semibold text-gray-800">{{ $variant->name }}</p>
                                            @if($variant->additional_price > 0)
                                                <div class="text-xs text-green-600 font-bold mt-1">
                                                    +{{ number_format($variant->additional_price, 0, ',', '.') }}
                                                </div>
                                            @endif
                                            <div class="text-xs text-gray-500 mt-2">
                                                Stok: {{ $variant->stock }}
                                            </div>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <!-- Total Price -->
                    <div class="text-center p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-200">
                        <p class="text-sm text-gray-600 mb-2 font-medium">Total Harga:</p>
                        <p class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            Rp <span x-text="((quantity * {{ $product->harga }}) + (quantity * additionalPrice)).toLocaleString('id-ID')"></span>
                        </p>
                        <p class="text-xs text-gray-500 mt-1">Untuk {{ $product->satuan }}</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-4">
                        <button @click="showModal = false"
                                class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-semibold border border-gray-200 hover:border-gray-300">
                            Batal
                        </button>
                        <button @click="submit()"
                                class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 font-semibold flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 7M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span x-text="isCheckout ? 'Checkout Sekarang' : 'Tambah ke Keranjang'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Forms -->
    <form id="checkout-form-{{ $product->id }}" 
          action="{{ route('checkout.direct', $product->id) }}" 
          method="GET" 
          class="hidden">
        <input type="hidden" name="quantity" value="1">
        <input type="hidden" name="selected_variants" value="">
    </form>

    <form id="cart-form-{{ $product->id }}"
          action="{{ route('cart.add', $product->id) }}"
          method="POST"
          class="hidden">
        @csrf
        <input type="hidden" name="quantity" value="1">
        <input type="hidden" name="selected_variants" value="">
    </form>
</div>