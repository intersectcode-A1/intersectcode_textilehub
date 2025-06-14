<x-layouts.catalog>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow p-6">
            <!-- Detail Pesanan -->
            <div class="space-y-6">
                <div class="border-b pb-4">
                    <h2 class="text-xl font-semibold">Detail Pesanan</h2>
                </div>

                <!-- Product Info -->
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Produk:</span>
                        <span class="font-medium">{{ $productName }}</span>
                    </div>

                    <!-- Variants -->
                    @if(isset($variants) && count($variants) > 0)
                        @php
                            $groupedVariants = collect($variants)->groupBy('type');
                        @endphp

                        @foreach($groupedVariants as $type => $typeVariants)
                            @foreach($typeVariants as $variant)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">{{ $type === 'color' ? 'Warna' : 'Ukuran' }}:</span>
                                    <div class="text-right">
                                        <span class="font-medium">{{ $variant['name'] }}</span>
                                        @if($variant['additional_price'] > 0)
                                            <span class="text-gray-600 ml-2">
                                                (+Rp {{ number_format($variant['additional_price'], 0, ',', '.') }})
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    @endif

                    <div class="border-t pt-4 mt-4">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Jumlah:</span>
                            <span class="font-medium">{{ $quantity }} pcs</span>
                        </div>

                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Harga per Item:</span>
                            <span class="font-medium">
                                Rp {{ number_format($price / $quantity, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex justify-between pt-2 border-t">
                            <span class="text-lg font-medium">Total:</span>
                            <span class="text-lg font-bold text-blue-600">
                                Rp {{ number_format($price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Pemesanan -->
            <form action="{{ route('order.submit') }}" method="POST" class="mt-8">
                @csrf
                <input type="hidden" name="product_id" value="{{ $productId }}">
                <input type="hidden" name="quantity" value="{{ $quantity }}">
                @if(isset($selectedVariants))
                    <input type="hidden" name="selected_variants" value="{{ $selectedVariants }}">
                @endif

                <div class="border-t pt-6">
                    <h2 class="text-xl font-semibold mb-4">Informasi Pemesan</h2>
                    
                    <div class="space-y-4">
                        <!-- Nama -->
                        <div>
                            <label for="user_name" class="block text-gray-600 mb-1">Nama Lengkap</label>
                            <input type="text" 
                                   name="user_name" 
                                   id="user_name" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500"
                                   value="{{ old('user_name', auth()->user()->name ?? '') }}" 
                                   required>
                            @error('user_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-gray-600 mb-1">Email</label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500"
                                   value="{{ old('email', auth()->user()->email ?? '') }}" 
                                   required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- No. Telepon -->
                        <div>
                            <label for="telepon" class="block text-gray-600 mb-1">No. Telepon</label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-gray-500">+62</span>
                                <input type="tel" 
                                       name="telepon" 
                                       id="telepon" 
                                       class="w-full pl-12 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500"
                                       value="{{ old('telepon', auth()->user()->phone ?? '') }}"
                                       placeholder="8123456789"
                                       required>
                            </div>
                            @error('telepon')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat -->
                        <div>
                            <label for="alamat" class="block text-gray-600 mb-1">Alamat Pengiriman</label>
                            <textarea name="alamat" 
                                      id="alamat" 
                                      rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500"
                                      required>{{ old('alamat', auth()->user()->address ?? '') }}</textarea>
                            @error('alamat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-3 mt-6">
                    <a href="{{ route('ecatalog.index') }}" 
                       class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Kirim Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.catalog>
