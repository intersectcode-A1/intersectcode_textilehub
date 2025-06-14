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
        form.querySelector('input[name=selected_variants]').value = selectedVariantIds.join(',');
        
        form.submit();
    }
}">
    <!-- Trigger Buttons -->
    <div class="flex space-x-3">
        <button @click="showModal = true; isCheckout = true" 
                class="flex-1 bg-blue-600 text-white px-4 py-2.5 rounded-lg hover:bg-blue-700 transition-all duration-200 transform hover:scale-105 shadow-md flex items-center justify-center">
            <i class="fas fa-shopping-cart mr-2"></i>Checkout
        </button>
        <button @click="showModal = true; isCheckout = false"
                class="flex-1 bg-yellow-500 text-white px-4 py-2.5 rounded-lg hover:bg-yellow-600 transition-all duration-200 transform hover:scale-105 shadow-md flex items-center justify-center">
            <i class="fas fa-cart-plus mr-2"></i>Keranjang
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
        <div class="flex items-center justify-center min-h-screen px-4">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showModal = false"></div>

            <!-- Modal Content -->
            <div class="relative bg-white rounded-xl max-w-md w-full p-6 shadow-2xl transform transition-all"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95">
                
                <!-- Close Button -->
                <button @click="showModal = false" 
                        class="absolute top-4 right-4 text-gray-400 hover:text-gray-500 p-2 rounded-full hover:bg-gray-100 transition-colors">
                    <i class="fas fa-times"></i>
                </button>

                <div class="space-y-6">
                    <!-- Product Title -->
                    <div class="text-center">
                        <h3 class="text-xl font-semibold text-gray-900">
                            {{ $product->nama }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">Pilih spesifikasi produk</p>
                    </div>

                    <!-- Stock Information -->
                    <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                        <p class="text-sm font-medium text-blue-800 mb-2">Informasi Stok:</p>
                        <template x-if="Object.keys(selectedVariants).length === 0">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-box text-blue-600"></i>
                                <p class="text-sm text-blue-700">Stok Total: {{ $product->stok }}</p>
                            </div>
                        </template>
                        <template x-if="Object.keys(selectedVariants).length > 0">
                            <div class="space-y-2">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-box text-blue-600"></i>
                                    <p class="text-sm text-blue-700">
                                        Stok Tersedia: <span x-text="currentStock"></span>
                                    </p>
                                </div>
                                <div class="pl-6 space-y-1">
                                    <template x-for="(variant, type) in selectedVariants" :key="type">
                                        <p class="text-xs text-blue-600 flex items-center space-x-1">
                                            <i class="fas fa-tag text-xs"></i>
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
                    <div class="flex items-center justify-center space-x-6">
                        <button @click="decrease()"
                                class="w-10 h-10 rounded-full border-2 border-gray-300 flex items-center justify-center hover:bg-gray-100 hover:border-blue-500 transition-colors">
                            <i class="fas fa-minus text-gray-600"></i>
                        </button>
                        <div class="w-16 text-center">
                            <span x-text="quantity" class="text-2xl font-semibold text-gray-800"></span>
                            <p class="text-xs text-gray-500 mt-1">Jumlah</p>
                        </div>
                        <button @click="increase()"
                                class="w-10 h-10 rounded-full border-2 border-gray-300 flex items-center justify-center hover:bg-gray-100 hover:border-blue-500 transition-colors">
                            <i class="fas fa-plus text-gray-600"></i>
                        </button>
                    </div>

                    <!-- Variants -->
                    @if($product->variants->isNotEmpty())
                        @php
                            $groupedVariants = $product->variants->groupBy('type');
                        @endphp

                        @foreach($groupedVariants as $type => $variants)
                            <div class="space-y-3">
                                <p class="font-medium text-gray-800 flex items-center">
                                    <i class="fas fa-{{ $type === 'color' ? 'palette' : 'ruler' }} mr-2 text-blue-600"></i>
                                    {{ $type === 'color' ? 'Pilih Warna' : 'Pilih Ukuran' }}
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
                                                    'ring-2 ring-blue-500 border-blue-300 bg-blue-50': selectedVariants['{{ $type }}']?.id === {{ $variant->id }},
                                                    'hover:border-blue-400 hover:bg-gray-50': selectedVariants['{{ $type }}']?.id !== {{ $variant->id }}
                                                }"
                                                class="p-3 border rounded-lg text-center transition-all duration-200">
                                            <p class="font-medium text-gray-800">{{ $variant->name }}</p>
                                            @if($variant->additional_price > 0)
                                                <div class="text-xs text-green-600 font-medium mt-1">
                                                    +{{ number_format($variant->additional_price, 0, ',', '.') }}
                                                </div>
                                            @endif
                                            <div class="text-xs text-gray-500 mt-1">
                                                Stok: {{ $variant->stock }}
                                            </div>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <!-- Total Price -->
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Total Harga:</p>
                        <p class="text-2xl font-bold text-blue-600">
                            Rp <span x-text="((quantity * {{ $product->harga }}) + (quantity * additionalPrice)).toLocaleString('id-ID')"></span>
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-3">
                        <button @click="showModal = false"
                                class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200 font-medium">
                            Batal
                        </button>
                        <button @click="submit()"
                                class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium flex items-center justify-center">
                            <i class="fas" :class="isCheckout ? 'fa-shopping-cart' : 'fa-cart-plus'"></i>
                            <span class="ml-2" x-text="isCheckout ? 'Checkout' : 'Tambah'"></span>
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