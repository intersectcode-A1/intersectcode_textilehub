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
        // Pastikan quantity tidak melebihi stok yang tersedia
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
    <div class="flex space-x-2">
        <button @click="showModal = true; isCheckout = true" 
                class="flex-1 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition flex items-center justify-center">
            <i class="fas fa-shopping-cart mr-2"></i>Checkout
        </button>
        <button @click="showModal = true; isCheckout = false"
                class="flex-1 bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition flex items-center justify-center">
            <i class="fas fa-cart-plus mr-2"></i>Keranjang
        </button>
    </div>

    <!-- Modal -->
    <div x-show="showModal" 
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black opacity-40" @click="showModal = false"></div>

            <!-- Modal Content -->
            <div class="relative bg-white rounded-lg max-w-md w-full p-6">
                <div class="absolute top-4 right-4">
                    <button @click="showModal = false" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-center text-gray-900">
                        {{ $product->nama }}
                    </h3>

                    <!-- Quantity Selector -->
                    <div class="flex items-center justify-center space-x-4">
                        <button @click="decrease()"
                                class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100">
                            <i class="fas fa-minus text-sm"></i>
                        </button>
                        <span x-text="quantity" class="text-xl font-medium w-12 text-center"></span>
                        <button @click="increase()"
                                class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-100">
                            <i class="fas fa-plus text-sm"></i>
                        </button>
                    </div>

                    <!-- Variants -->
                    @if($product->variants->isNotEmpty())
                        @php
                            $groupedVariants = $product->variants->groupBy('type');
                        @endphp

                        @foreach($groupedVariants as $type => $variants)
                            <div class="space-y-2">
                                <p class="font-medium text-gray-700">
                                    {{ $type === 'color' ? 'Pilih Warna' : 'Pilih Ukuran' }}
                                </p>
                                <div class="grid grid-cols-3 gap-2">
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
                                                    'ring-2 ring-blue-500': selectedVariants['{{ $type }}']?.id === {{ $variant->id }},
                                                    'hover:border-blue-500': selectedVariants['{{ $type }}']?.id !== {{ $variant->id }}
                                                }"
                                                class="p-2 border rounded-lg text-center transition-all">
                                            {{ $variant->name }}
                                            @if($variant->additional_price > 0)
                                                <div class="text-xs text-green-600">
                                                    +{{ number_format($variant->additional_price, 0, ',', '.') }}
                                                </div>
                                            @endif
                                            <div class="text-xs text-gray-500">
                                                Stok: {{ $variant->stock }}
                                            </div>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <!-- Total -->
                    <div class="text-center mb-4">
                        <p class="text-sm text-gray-600">Total:</p>
                        <p class="text-xl font-bold text-gray-900">
                            Rp <span x-text="((quantity * {{ $product->harga }}) + (quantity * additionalPrice)).toLocaleString('id-ID')"></span>
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-2">
                        <button @click="showModal = false"
                                class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                            Batal
                        </button>
                        <button @click="submit()"
                                class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            <span x-text="isCheckout ? 'Checkout' : 'Tambah'"></span>
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