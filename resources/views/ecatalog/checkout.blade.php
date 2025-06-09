<x-layouts.catalog>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ url()->previous() }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 md:p-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Form Pemesanan</h1>
                <p class="mt-2 text-sm text-gray-600">Silakan lengkapi data pemesanan Anda</p>
            </div>

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-600 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('order.submit') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="product_id" value="{{ $productId }}">
                <input type="hidden" name="quantity" value="{{ $quantity }}">

                <!-- Order Summary -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Pesanan</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Produk</span>
                            <span class="font-medium text-gray-900">{{ $productName }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jumlah</span>
                            <span class="font-medium text-gray-900">{{ $quantity }} pcs</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Harga Satuan</span>
                            <span class="font-medium text-gray-900">Rp {{ number_format($price / $quantity, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between pt-2 border-t">
                            <span class="text-gray-900 font-medium">Total</span>
                            <span class="font-bold text-blue-600">Rp {{ number_format($price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold text-gray-900">Informasi Pemesan</h2>
                    
                    <!-- Nama -->
                    <div>
                        <label for="user_name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" 
                               name="user_name" 
                               id="user_name" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               value="{{ old('user_name', auth()->user()->name ?? '') }}" 
                               required>
                        @error('user_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               value="{{ old('email', auth()->user()->email ?? '') }}" 
                               required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No. Telepon -->
                    <div>
                        <label for="telepon" class="block text-sm font-medium text-gray-700">No. Telepon</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">+62</span>
                            </div>
                            <input type="tel" 
                                   name="telepon" 
                                   id="telepon" 
                                   class="pl-12 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   value="{{ old('telepon', auth()->user()->phone ?? '') }}"
                                   placeholder="8123456789"
                                   required>
                            @error('telepon')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Pengiriman</label>
                        <textarea name="alamat" 
                                  id="alamat" 
                                  rows="3" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                  required>{{ old('alamat', auth()->user()->address ?? '') }}</textarea>
                        @error('alamat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-3 pt-6">
                    <a href="{{ route('ecatalog.index') }}" 
                       class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Kirim Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.catalog>
