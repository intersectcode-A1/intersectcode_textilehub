@props(['cart'])

<x-layouts.catalog>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Tombol Kembali --}}
        <div class="mb-6">
            <a href="{{ route('ecatalog.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Katalog
            </a>
        </div>

        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-800">🛒 Keranjang Belanja</h1>
            <p class="text-gray-600 mt-2">Total Item: {{ array_sum(array_column($cart, 'quantity')) }}</p>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        @if(count($cart) > 0)
            <div class="space-y-4">
                @php $total = 0; @endphp

                @foreach($cart as $id => $item)
                    @php
                        $subtotal = $item['harga'] * $item['quantity'];
                        $total += $subtotal;
                    @endphp
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    @if($item['foto'])
                                        <img src="{{ asset('storage/' . $item['foto']) }}" 
                                             alt="{{ $item['nama'] }}"
                                             class="w-24 h-24 object-cover rounded-lg">
                                    @else
                                        <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <span class="text-gray-400">No Image</span>
                                        </div>
                                    @endif
                                    
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $item['nama'] }}</h3>
                                        <p class="text-gray-600">Rp {{ number_format($item['harga'], 0, ',', '.') }}/pcs</p>
                                        
                                        <div class="mt-4 flex items-center space-x-4">
                                            <div class="flex items-center border border-gray-300 rounded-lg">
                                                <button onclick="updateQuantity({{ $id }}, {{ $item['quantity'] - 1 }})"
                                                        class="px-3 py-1 text-gray-600 hover:bg-gray-100 {{ $item['quantity'] <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                        {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                                    -
                                                </button>
                                                <input type="number" 
                                                       value="{{ $item['quantity'] }}" 
                                                       min="1"
                                                       onchange="updateQuantity({{ $id }}, this.value)"
                                                       class="w-16 text-center border-x border-gray-300 py-1 focus:outline-none">
                                                <button onclick="updateQuantity({{ $id }}, {{ $item['quantity'] + 1 }})"
                                                        class="px-3 py-1 text-gray-600 hover:bg-gray-100">
                                                    +
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-right">
                                    <p class="text-lg font-semibold text-green-600">
                                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                                    </p>
                                    <form action="{{ route('cart.remove', $id) }}" 
                                          method="POST" 
                                          class="mt-2"
                                          onsubmit="return confirm('Yakin ingin menghapus produk ini dari keranjang?')">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="mt-8 bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-gray-600">Total Item: {{ array_sum(array_column($cart, 'quantity')) }}</p>
                                <h4 class="text-xl font-semibold text-gray-900 mt-1">Total Pembayaran</h4>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-blue-600">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('checkout.cart') }}" 
                               class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                Lanjut ke Pembayaran
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-xl shadow-sm">
                <div class="mb-4">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 7M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Keranjang Kosong</h3>
                <p class="mt-1 text-sm text-gray-500">Belum ada produk di keranjang belanja kamu.</p>
                <div class="mt-6">
                    <a href="{{ route('ecatalog.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Mulai Belanja
                    </a>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        function updateQuantity(productId, newQuantity) {
            if (newQuantity < 1) return;
            
            fetch(`/cart/update/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ quantity: newQuantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal mengupdate jumlah produk');
            });
        }
    </script>
    @endpush
</x-layouts.catalog>
