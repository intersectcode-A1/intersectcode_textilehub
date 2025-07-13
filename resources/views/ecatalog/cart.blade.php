<x-layouts.catalog>
    <div class="bg-white min-h-screen py-12 transition-colors duration-300">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Tombol Kembali ke E-Catalog (paling atas) --}}
            <a href="{{ route('ecatalog.index') }}" class="inline-flex items-center mb-6 px-5 py-2 bg-blue-600 hover:bg-blue-800 text-white font-bold rounded-xl shadow-md hover:scale-105 transition-all duration-150">
                <svg class="w-5 h-5 mr-2 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                Kembali ke E-Catalog
            </a>

            <div class="mb-10 text-center">
                <h1 class="text-4xl font-extrabold text-blue-900 drop-shadow mb-2">🛒 Keranjang Belanja</h1>
                <p class="text-blue-500 text-base sm:text-lg font-light">Cek kembali produk yang ingin Anda beli sebelum checkout.</p>
            </div>

            {{-- Alerts --}}
            @if(session('success'))
                <div class="mb-6 animate-fadeIn">
                    <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-900 px-6 py-4 rounded-xl shadow-md flex items-center gap-3">
                        <svg class="w-6 h-6 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-semibold">{{ session('success') }}</span>
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 animate-fadeIn">
                    <div class="bg-red-50 border-l-4 border-red-400 text-red-900 px-6 py-4 rounded-xl shadow-md flex items-center gap-3">
                        <svg class="w-6 h-6 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-semibold">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @if(count($cart) > 0)
                <div class="space-y-8">
                    @php $total = 0; @endphp
                    @foreach($cart as $key => $item)
                        @php
                            $totalAdditionalPrice = !empty($item['variants']) ? collect($item['variants'])->sum('additional_price') : 0;
                            $subtotal = ($item['harga'] + $totalAdditionalPrice) * $item['quantity'];
                            $total += $subtotal;
                        @endphp
                        <div class="bg-white/70 backdrop-blur-md border border-blue-100 shadow-2xl rounded-2xl p-6 flex flex-col sm:flex-row sm:items-center gap-6 transition-all duration-300 hover:shadow-blue-200 hover:-translate-y-1 animate-fadeIn relative">
                            @if($item['foto'])
                                <img src="{{ asset('storage/' . $item['foto']) }}" alt="{{ $item['nama'] }}" class="w-full sm:w-32 h-48 sm:h-32 object-cover rounded-xl border-2 border-blue-200 shadow-md bg-white/40">
                            @else
                                <div class="w-full sm:w-32 h-48 sm:h-32 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-xl flex items-center justify-center border-2 border-blue-100">
                                    <span class="text-blue-400 text-sm">No Image</span>
                                </div>
                            @endif
                            <div class="flex-1 flex flex-col gap-2">
                                <div class="flex flex-col sm:flex-row sm:justify-between gap-2">
                                    <div class="w-full">
                                        <div class="flex items-center gap-3 mb-1">
                                            <h3 class="text-lg sm:text-xl font-extrabold text-blue-900 drop-shadow">{{ $item['nama'] }}</h3>
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white border-2 border-blue-400 text-blue-900 font-extrabold text-lg shadow text-center">{{ $item['quantity'] }}</span>
                                        </div>
                                        @if(!empty($item['variants']))
                                            <div class="flex flex-wrap gap-2 mb-1">
                                                @php $groupedVariants = collect($item['variants'])->groupBy('type'); @endphp
                                                @foreach($groupedVariants as $type => $variants)
                                                    <div class="flex items-center gap-1">
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold uppercase tracking-wide bg-blue-200 text-blue-900 shadow">
                                                            {{ ucfirst($type) }}
                                                        </span>
                                                        @foreach($variants as $variant)
                                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-blue-50 text-xs text-blue-800 font-semibold border border-blue-100 shadow-sm">
                                                                {{ $variant['name'] }}
                                                                @if($variant['additional_price'] > 0)
                                                                    <span class="ml-2 text-blue-600 font-bold">+Rp {{ number_format($variant['additional_price'], 0, ',', '.') }}</span>
                                                                @endif
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                            @if($totalAdditionalPrice > 0)
                                                <div class="text-xs text-blue-600 mb-1 font-semibold">Harga tambahan varian: +Rp {{ number_format($totalAdditionalPrice, 0, ',', '.') }}</div>
                                            @endif
                                        @endif
                                        <div class="text-xs text-blue-500">Harga satuan: Rp {{ number_format($item['harga'], 0, ',', '.') }}</div>
                                        <div class="text-base sm:text-lg font-bold text-blue-900 mt-1">Subtotal: Rp {{ number_format($subtotal, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="flex flex-col items-end gap-2 justify-between h-full">
                                        <form action="{{ route('cart.remove', $key) }}" method="POST" class="flex items-center gap-2 mt-2">
                                            @csrf
                                            <button type="submit"
                                                class="flex items-center gap-2 px-4 py-2 rounded-full bg-gradient-to-tr from-rose-500 to-pink-500 text-white font-bold shadow-lg hover:from-rose-600 hover:to-pink-600 hover:scale-105 transition-all duration-200 border-0 focus:ring-2 focus:ring-rose-300"
                                                aria-label="Hapus produk dari keranjang">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M8 7V5a2 2 0 012-2h2a2 2 0 012 2v2" />
                                                </svg>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- Order Summary --}}
                    <div class="bg-white/80 backdrop-blur-md border border-blue-200 shadow-2xl rounded-2xl p-8 mt-10 animate-fadeIn">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                            <div>
                                <p class="text-lg font-extrabold text-blue-900">Total</p>
                                <p class="text-sm text-blue-600">{{ count($cart) }} item</p>
                            </div>
                            <div class="text-left sm:text-right">
                                <p class="text-3xl font-black text-blue-700 drop-shadow">Rp {{ number_format($total, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="mt-8 flex flex-col sm:flex-row justify-end gap-4">
                            <a href="{{ route('ecatalog.index') }}" class="btn btn-secondary text-blue-900 border-blue-200 bg-white hover:bg-blue-50">Lanjut Belanja</a>
                            <a href="{{ route('checkout.cart') }}" class="btn btn-primary bg-blue-600 hover:bg-blue-700 text-white">Checkout</a>
                        </div>
                    </div>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-20 animate-fadeIn">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-blue-100 mb-6 shadow-lg">
                        <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-blue-900 mb-2">Keranjang Belanja Kosong</h3>
                    <p class="mb-6 text-sm sm:text-base text-blue-600">Belum ada produk yang ditambahkan ke keranjang.</p>
                    <a href="{{ route('ecatalog.index') }}" class="btn btn-primary bg-blue-600 hover:bg-blue-700 text-white">Mulai Belanja</a>
                </div>
            @endif
        </div>
    </div>
</x-layouts.catalog>
