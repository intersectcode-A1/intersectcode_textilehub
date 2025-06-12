<x-layouts.catalog>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
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
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if(count($cart) > 0)
            <div class="space-y-4">
                @php $total = 0; @endphp

                @foreach($cart as $key => $item)
                    @php
                        $subtotal = $item['harga'] * $item['quantity'];
                        $total += $subtotal;
                    @endphp
                    <div class="bg-white p-6 rounded-xl shadow">
                        <div class="flex items-start space-x-6">
                            @if($item['foto'])
                                <img src="{{ asset('storage/' . $item['foto']) }}" 
                                     alt="{{ $item['nama'] }}" 
                                     class="w-24 h-24 object-cover rounded-lg">
                            @else
                                <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-500">No Image</span>
                                </div>
                            @endif

                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $item['nama'] }}</h3>
                                        
                                        {{-- Tampilkan varian jika ada --}}
                                        @if(!empty($item['variants']))
                                            <div class="mt-2 space-y-2">
                                                {{-- Group variants by type --}}
                                                @php
                                                    $groupedVariants = collect($item['variants'])->groupBy('type');
                                                @endphp

                                                @foreach($groupedVariants as $type => $variants)
                                                    <div class="flex items-center gap-2">
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $type === 'color' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                                            {{ $type === 'color' ? 'Warna' : 'Ukuran' }}
                                                        </span>
                                                        @foreach($variants as $variant)
                                                            <div class="inline-flex items-center px-2.5 py-1 rounded-lg bg-gray-100">
                                                                <span class="text-sm text-gray-700">{{ $variant['name'] }}</span>
                                                                @if($variant['additional_price'] > 0)
                                                                    <span class="ml-2 text-xs text-green-600">
                                                                        +Rp {{ number_format($variant['additional_price'], 0, ',', '.') }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach

                                                {{-- Total additional price from variants --}}
                                                @php
                                                    $totalAdditionalPrice = collect($item['variants'])->sum('additional_price');
                                                @endphp
                                                @if($totalAdditionalPrice > 0)
                                                    <div class="text-sm text-gray-600 mt-1">
                                                        Harga tambahan varian: +Rp {{ number_format($totalAdditionalPrice, 0, ',', '.') }}
                                                    </div>
                                                @endif
                                            </div>
                                        @endif

                                        {{-- Price calculation --}}
                                        <div class="mt-2">
                                            <div class="text-sm text-gray-600">
                                                Harga satuan: Rp {{ number_format($item['harga'], 0, ',', '.') }}
                                            </div>
                                            <div class="text-lg font-semibold text-gray-900 mt-1">
                                                Total: Rp {{ number_format($item['harga'] * $item['quantity'], 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Quantity controls --}}
                                    <div class="flex flex-col items-end space-y-2">
                                        <div class="flex items-center space-x-2">
                                            <button onclick="updateQuantity('{{ $key }}', -1)"
                                                    class="p-1 rounded-md hover:bg-gray-100">
                                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                                </svg>
                                            </button>
                                            <span class="text-gray-900 font-medium">{{ $item['quantity'] }}</span>
                                            <button onclick="updateQuantity('{{ $key }}', 1)"
                                                    class="p-1 rounded-md hover:bg-gray-100">
                                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <button onclick="removeFromCart('{{ $key }}')"
                                                class="text-sm text-rose-600 hover:text-rose-700">
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="mt-8 bg-white p-6 rounded-xl shadow">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-lg font-semibold text-gray-900">Total</p>
                            <p class="text-sm text-gray-600">{{ count($cart) }} item</p>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl font-bold text-primary-600">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-4">
                        <a href="{{ route('ecatalog.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Lanjut Belanja
                        </a>
                        <a href="{{ route('checkout.cart') }}" 
                           class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Checkout
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Keranjang Belanja Kosong</h3>
                <p class="mt-2 text-sm text-gray-600">Belum ada produk yang ditambahkan ke keranjang.</p>
                <div class="mt-6">
                    <a href="{{ route('ecatalog.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Mulai Belanja
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-layouts.catalog>
