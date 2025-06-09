<x-layouts.catalog>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('cart.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Keranjang
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 md:p-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Checkout Keranjang</h1>
                <p class="mt-2 text-sm text-gray-600">Silakan lengkapi data pemesanan Anda</p>
            </div>

            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-600 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-600 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Daftar Item --}}
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Pesanan</h2>
                <div class="space-y-4">
                    @foreach($items as $item)
                        <div class="flex justify-between items-center border-b border-gray-200 pb-4">
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900">{{ $item['nama'] }}</h4>
                                <div class="mt-1 flex items-center text-sm text-gray-600">
                                    <span>{{ $item['quantity'] }} x </span>
                                    <span class="mx-1">Rp {{ number_format($item['harga'], 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-900">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                    
                    <div class="flex justify-between items-center pt-4 font-bold">
                        <span class="text-gray-900">Total Pembayaran</span>
                        <span class="text-blue-600 text-lg">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Form Checkout --}}
            <form action="{{ route('order.submit.cart') }}" method="POST" class="space-y-6">
                @csrf
                
                {{-- Data tersembunyi untuk items --}}
                <input type="hidden" name="total" value="{{ $total }}">
                @foreach($items as $item)
                    <input type="hidden" name="items[]" value="{{ json_encode($item) }}">
                @endforeach

                <!-- Informasi Pemesan -->
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
                <div class="flex items-center justify-end space-x-3 pt-6 border-t">
                    <a href="{{ route('cart.index') }}" 
                       class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Proses Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.catalog> 