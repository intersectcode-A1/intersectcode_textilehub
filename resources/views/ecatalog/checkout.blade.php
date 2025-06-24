<x-layouts.catalog>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-2xl font-bold text-gray-900 mb-8">Checkout</h1>

    @if(session('error'))
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Form Checkout --}}
        <div>
            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Informasi Pengiriman</h2>

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
                        <label for="user_name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" 
                               name="user_name" 
                               id="user_name" 
                               value="{{ old('user_name', auth()->user()->name ?? '') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                               required>
                        @error('user_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email', auth()->user()->email ?? '') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                               required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="telepon" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                        <input type="tel" 
                               name="telepon" 
                               id="telepon" 
                               value="{{ old('telepon', auth()->user()->phone ?? '') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                               required>
                        @error('telepon')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                        <textarea name="alamat" 
                                  id="alamat" 
                                  rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                  required>{{ old('alamat', auth()->user()->address ?? '') }}</textarea>
                        @error('alamat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('ecatalog.show', $productId) }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Kembali ke Produk
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Buat Pesanan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Ringkasan Pesanan --}}
        <div>
            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Ringkasan Pesanan</h2>

                <div class="space-y-4">
                    <div class="flex items-start space-x-4 pb-4 border-b border-gray-200">
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-gray-900">{{ $productName }}</h3>
                            @if(!empty($variants) && count($variants) > 0)
                                <div class="mt-2 text-sm text-gray-700">
                                    @foreach($variants as $variant)
                                        <div>{{ ucfirst($variant->type) }}: {{ $variant->name }}
                                            @if($variant->additional_price > 0)
                                                (+Rp {{ number_format($variant->additional_price, 0, ',', '.') }})
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            
                            {{-- Price breakdown --}}
                            <div class="mt-3 space-y-1 text-sm">
                                <div class="text-gray-600">
                                    Harga satuan: Rp {{ number_format($price / $quantity, 0, ',', '.') }}
                                    @if(!empty($additionalPrice) && $additionalPrice > 0)
                                        <span class="text-xs text-gray-500">(termasuk tambahan varian)</span>
                                    @endif
                                </div>
                                <div class="text-gray-600">
                                    Jumlah: {{ $quantity }}
                                </div>
                                <div class="text-gray-900 font-medium">
                                    Subtotal: Rp {{ number_format($price, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Order Summary --}}
                    <div class="border-t border-gray-200 pt-4 mt-6">
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Subtotal Produk</span>
                                <span>Rp {{ number_format($price, 0, ',', '.') }}</span>
                            </div>
                            @isset($shipping_cost)
                                @if($shipping_cost > 0)
                                    <div class="flex justify-between text-sm text-gray-600">
                                        <span>Biaya Pengiriman</span>
                                        <span>Rp {{ number_format($shipping_cost, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                            @endisset
                            <div class="flex justify-between text-base font-semibold text-gray-900 pt-2">
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
</x-layouts.catalog> 