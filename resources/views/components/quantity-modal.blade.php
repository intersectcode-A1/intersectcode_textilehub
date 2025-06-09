@props(['product'])

<div x-data="{ 
    showModal: false, 
    quantity: 1,
    isCheckout: false,
    maxStock: {{ $product->stok }},
    price: {{ $product->harga }},
    total: {{ $product->harga }},
    decrease() { 
        if (this.quantity > 1) {
            this.quantity--;
            this.updateTotal();
        }
    },
    increase() { 
        if (this.quantity < this.maxStock) {
            this.quantity++;
            this.updateTotal();
        }
    },
    updateTotal() {
        this.total = this.quantity * this.price;
    },
    submit() {
        const form = this.isCheckout ? 
            document.getElementById('checkout-form-' + {{ $product->id }}) : 
            document.getElementById('cart-form-' + {{ $product->id }});
        form.querySelector('input[name=quantity]').value = this.quantity;
        form.submit();
    }
}" x-init="$watch('quantity', value => updateTotal())">
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
         style="display: none;"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="flex items-center justify-center min-h-screen px-4">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black opacity-40" @click="showModal = false"></div>

            <!-- Modal Content -->
            <div class="relative bg-white rounded-lg shadow-xl w-full max-w-xs mx-auto"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95">
                <div class="p-4">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <i class="fas fa-shopping-cart text-blue-600 mr-2"></i>
                            <span class="text-base font-medium">{{ $product->nama }}</span>
                        </div>
                        <button @click="showModal = false" class="text-gray-400 hover:text-gray-500">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <p class="text-sm text-gray-600 mb-4">Masukkan jumlah yang ingin dibeli</p>

                    <!-- Quantity Input -->
                    <div class="flex items-center justify-center space-x-4 mb-3">
                        <button @click="decrease()" 
                                :class="{'opacity-50 cursor-not-allowed': quantity <= 1}"
                                class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center hover:bg-gray-200">
                            <i class="fas fa-minus text-gray-600"></i>
                        </button>
                        <input type="number" 
                               x-model.number="quantity"
                               @input="updateTotal()"
                               class="w-16 text-center border-gray-300 rounded-lg"
                               min="1"
                               :max="maxStock">
                        <button @click="increase()"
                                :class="{'opacity-50 cursor-not-allowed': quantity >= maxStock}"
                                class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center hover:bg-gray-200">
                            <i class="fas fa-plus text-gray-600"></i>
                        </button>
                    </div>

                    <!-- Stock Info -->
                    <p class="text-sm text-gray-500 text-center mb-3">
                        Stok tersedia: {{ $product->stok }} pcs
                    </p>

                    <!-- Total -->
                    <div class="text-center mb-4">
                        <p class="text-sm text-gray-600">Total:</p>
                        <p class="text-xl font-bold text-blue-600">
                            Rp <span x-text="total.toLocaleString('id-ID')"></span>
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-2">
                        <button @click="showModal = false"
                                class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                            Batal
                        </button>
                        <button @click="submit()"
                                class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            <span x-text="isCheckout ? 'Checkout' : 'Tambah ke Keranjang'"></span>
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
        <input type="hidden" name="quantity" x-bind:value="quantity">
    </form>

    <form id="cart-form-{{ $product->id }}"
          action="{{ route('cart.add', $product->id) }}"
          method="POST"
          class="hidden">
        @csrf
        <input type="hidden" name="quantity" x-bind:value="quantity">
    </form>
</div> 