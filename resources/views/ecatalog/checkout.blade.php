@php
    $additionalPrice = 0;
    if (!empty($variants) && count($variants) > 0) {
        $additionalPrice = collect($variants)->sum('additional_price');
    }
    $subtotal = $price;
@endphp
<x-layouts.catalog>
    <div class="bg-white min-h-screen py-12 transition-colors duration-300">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Tombol Kembali ke E-Catalog (paling atas) --}}
            <a href="{{ route('ecatalog.index') }}" class="inline-flex items-center mb-6 px-5 py-2 bg-blue-600 hover:bg-blue-800 text-white font-bold rounded-xl shadow-md hover:scale-105 transition-all duration-150">
                <svg class="w-5 h-5 mr-2 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                Kembali ke E-Catalog
            </a>

            {{-- Breadcrumb & Back --}}
            <div class="mb-10 text-center">
                <h1 class="text-4xl font-extrabold text-blue-900 drop-shadow mb-2">🧾 Checkout</h1>
                <p class="text-blue-500 text-base sm:text-lg font-light">Isi data pengiriman & cek ringkasan pesanan Anda sebelum konfirmasi.</p>
            </div>

            {{-- Alerts --}}
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

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Form Checkout --}}
                <div>
                    <div class="bg-white/80 backdrop-blur-md border border-blue-100 shadow-2xl rounded-2xl p-8 animate-fadeIn">
                        <h2 class="text-lg font-bold text-blue-900 mb-6">Informasi Pengiriman</h2>
                        <form action="{{ route('order.submit') }}" method="POST" class="space-y-6">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $productId }}">
                            <input type="hidden" name="quantity" value="{{ $quantity }}">
                            @if(!empty($variants) && count($variants) > 0)
                                @foreach($variants as $variant)
                                    <input type="hidden" name="selected_variants[]" value="{{ $variant->id }}">
                                @endforeach
                            @endif
                            <div>
                                <label for="user_name" class="block text-sm font-semibold text-blue-800">Nama Lengkap</label>
                                <input type="text" name="user_name" id="user_name" value="{{ old('user_name', auth()->user()->name ?? '') }}" class="mt-1 block w-full rounded-xl border-blue-200 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                @error('user_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-semibold text-blue-800">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email ?? '') }}" class="mt-1 block w-full rounded-xl border-blue-200 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="telepon" class="block text-sm font-semibold text-blue-800">Nomor Telepon</label>
                                <input type="tel" name="telepon" id="telepon" value="{{ old('telepon', auth()->user()->phone ?? '') }}" class="mt-1 block w-full rounded-xl border-blue-200 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                @error('telepon')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="alamat" class="block text-sm font-semibold text-blue-800">Alamat Lengkap</label>
                                <textarea name="alamat" id="alamat" rows="4" class="mt-1 block w-full rounded-xl border-blue-200 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>{{ old('alamat', auth()->user()->address ?? '') }}</textarea>
                                @error('alamat')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex justify-end space-x-4 mt-8">
                                <a href="{{ route('ecatalog.show', $productId) }}" class="btn btn-secondary">Kembali ke Produk</a>
                                <button type="submit" class="btn btn-primary">Buat Pesanan</button>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- Ringkasan Pesanan --}}
                <div>
                    <div class="bg-white/80 backdrop-blur-md border border-blue-100 shadow-2xl rounded-2xl p-8 animate-fadeIn">
                        <h2 class="text-lg font-bold text-blue-900 mb-6">Ringkasan Pesanan</h2>
                        <div class="space-y-6">
                            <div class="flex items-start space-x-4 pb-4 border-b border-blue-100">
                                <div class="flex-1">
                                    <h3 class="text-base font-bold text-blue-900">{{ $productName }}</h3>
                                    @if(!empty($variants) && count($variants) > 0)
                                        <div class="mt-2 flex flex-wrap gap-2">
                                            @foreach($variants as $variant)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold uppercase tracking-wide bg-gradient-to-r from-blue-400 to-indigo-300 text-white shadow">
                                                    {{ ucfirst($variant->type) }}
                                                </span>
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-blue-50 text-xs text-blue-900 font-semibold border border-blue-100 shadow-sm">
                                                    {{ $variant->name }}
                                                    @if($variant->additional_price > 0)
                                                        <span class="ml-2 text-green-600 font-bold">+Rp {{ number_format($variant->additional_price, 0, ',', '.') }}</span>
                                                    @endif
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="mt-3 space-y-1 text-sm">
                                        <div class="text-gray-600">Harga satuan: Rp {{ number_format($price / $quantity, 0, ',', '.') }}
                                            @if(!empty($additionalPrice) && $additionalPrice > 0)
                                                <span class="text-xs text-gray-500">(termasuk tambahan varian)</span>
                                            @endif
                                        </div>
                                        <div class="text-gray-600">Jumlah: {{ $quantity }}</div>
                                        <div class="text-blue-900 font-bold">Subtotal: Rp {{ number_format($price, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>
                            {{-- Order Summary --}}
                            <div class="border-t border-blue-100 pt-4 mt-6">
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm text-blue-800">
                                        <span>Subtotal Produk</span>
                                        <span>Rp {{ number_format($price, 0, ',', '.') }}</span>
                                    </div>
                                    @isset($shipping_cost)
                                        @if($shipping_cost > 0)
                                            <div class="flex justify-between text-sm text-blue-800">
                                                <span>Biaya Pengiriman</span>
                                                <span>Rp {{ number_format($shipping_cost, 0, ',', '.') }}</span>
                                            </div>
                                        @endif
                                    @endisset
                                    <div class="flex justify-between text-xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 pt-2">
                                        <span>Total</span>
                                        <span>Rp {{ number_format(($price + ($shipping_cost ?? 0)), 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.catalog> 