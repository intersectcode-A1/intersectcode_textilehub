<x-layouts.catalog>
    {{-- Page Header with Breadcrumb --}}
    <div class="bg-gradient-to-r from-blue-700 to-blue-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            {{-- Breadcrumb --}}
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center text-blue-100 hover:text-white transition duration-150">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-1 text-white font-medium md:ml-2">Kerajang Belanja</span>
                        </div>
                    </li>
                </ol>
            </nav>

            {{-- Page Title --}}
            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4 leading-tight">Keranjang Belanja</h1>
                <p class="text-xl text-blue-100 font-light">Kelola produk yang ingin Anda beli</p>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="max-w-3xl mx-auto py-10 px-2 sm:px-0">
        @if(count($cart) > 0)
            <div class="bg-white rounded-2xl shadow-lg divide-y divide-gray-100 overflow-hidden">
                @foreach($cart as $cartKey => $item)
                    <div class="flex items-start p-4 hover:bg-gray-50 transition duration-150">
                        {{-- Gambar Produk --}}
                        <div class="w-16 h-16 flex-shrink-0 rounded-xl overflow-hidden border border-gray-100 bg-white flex items-center justify-center shadow-sm">
                            <img src="{{ asset('storage/' . $item['foto']) }}" alt="{{ $item['nama'] }}" class="object-cover w-full h-full">
                        </div>
                        {{-- Info Produk --}}
                        <div class="flex-1 min-w-0 ml-4">
                            <div class="font-bold text-base text-gray-900 mb-1">{{ $item['nama'] }}</div>
                            @if(isset($item['variants']) && count($item['variants']) > 0)
                                <div class="mt-2 space-y-2">
                                    @php
                                        $groupedVariants = collect($item['variants'])->groupBy('type');
                                    @endphp
                                    @foreach($groupedVariants as $type => $variants)
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $type === 'color' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                                {{ $type === 'color' ? 'Warna' : 'Ukuran' }}
                                            </span>
                                            @foreach($variants as $variant)
                                                <div class="inline-flex items-center px-2 py-1 rounded-lg bg-gray-50 border border-gray-100">
                                                    <span class="text-xs font-medium text-gray-700">{{ $variant['name'] }}</span>
                                                    @if($variant['additional_price'] > 0)
                                                        <span class="ml-2 text-xs font-medium text-green-600">
                                                            +Rp {{ number_format($variant['additional_price'], 0, ',', '.') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        {{-- Harga dan Quantity --}}
                        <div class="ml-4 text-right">
                            <div class="space-y-1">
                                <div class="text-gray-600 text-xs">
                                    Harga satuan: Rp {{ number_format($item['harga'], 0, ',', '.') }}
                                </div>
                                @if(isset($item['additional_price']) && $item['additional_price'] > 0)
                                    <div class="text-gray-600 text-xs">
                                        Harga tambahan varian: +Rp {{ number_format($item['additional_price'], 0, ',', '.') }}
                                    </div>
                                @endif
                                <div class="text-gray-600 text-xs">
                                    Jumlah: {{ $item['quantity'] }}
                                </div>
                                <div class="text-gray-900 font-bold text-base">
                                    Subtotal: Rp {{ number_format(($item['harga'] + ($item['additional_price'] ?? 0)) * $item['quantity'], 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                        {{-- Tombol Hapus --}}
                        <form action="{{ route('cart.remove', $cartKey) }}" method="POST" class="ml-4">
                            @csrf
                            <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-full bg-red-50 hover:bg-red-100 text-red-500 transition duration-150">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
            {{-- Ringkasan dan Checkout --}}
            <div class="max-w-md mx-auto mt-8 bg-white rounded-2xl shadow-lg p-4">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-lg font-bold text-gray-900">Total Pembayaran</span>
                    @php
                        $subtotal = collect($cart)->sum(function($item) {
                            $basePrice = $item['harga'];
                            $additionalPrice = $item['additional_price'] ?? 0;
                            return ($basePrice + $additionalPrice) * $item['quantity'];
                        });
                    @endphp
                    <span class="text-xl font-bold text-green-600">Rp {{ number_format($subtotal + 10000, 0, ',', '.') }}</span>
                </div>
                <a href="{{ route('checkout.cart') }}" 
                   class="block w-full text-center py-3 rounded-xl bg-green-500 hover:bg-green-600 text-white font-bold text-base transition duration-150 shadow hover:shadow-md">
                    Selesaikan Pembayaran
                </a>
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-3xl shadow-xl">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-blue-50 mb-6">
                    <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 7M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Keranjang Belanja Kosong</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto text-lg">Anda belum menambahkan produk ke keranjang belanja. Mari mulai berbelanja untuk menemukan produk terbaik.</p>
                <a href="{{ route('ecatalog.index') }}" 
                   class="inline-flex items-center px-8 py-4 bg-blue-600 text-white rounded-xl font-bold text-lg hover:bg-blue-700 transition duration-150 shadow-lg hover:shadow-xl">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>
</x-layouts.catalog> 