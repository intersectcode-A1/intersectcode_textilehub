<x-layouts.catalog>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('cart.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Keranjang
            </a>
        </div>

        {{-- Checkout Header --}}
        <div class="flex items-center justify-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Form Pemesanan</h1>
        </div>

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-sm p-6">
            <form action="{{ route('order.submit.cart') }}" method="POST">
                @csrf

                {{-- Order Summary --}}
                <div class="mb-8">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Detail Pesanan</h2>
                    <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                        @foreach($cart as $id => $item)
                            <div class="flex justify-between items-center py-2">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ asset('storage/' . $item['foto']) }}" 
                                         alt="{{ $item['nama'] }}"
                                         class="w-12 h-12 object-cover rounded">
                                    <div>
                                        <h3 class="font-medium text-gray-900">{{ $item['nama'] }}</h3>
                                        <p class="text-sm text-gray-600">{{ $item['quantity'] }} x Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <p class="font-medium text-gray-900">
                                    Rp {{ number_format($item['harga'] * $item['quantity'], 0, ',', '.') }}
                                </p>
                            </div>
                        @endforeach
                        <div class="pt-3 border-t border-gray-200">
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-900">Total Pembayaran</span>
                                <span class="text-xl font-bold text-blue-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Customer Information --}}
                <div class="space-y-6">
                    <h2 class="text-lg font-medium text-gray-900">Informasi Pemesan</h2>
                    
                    <div class="grid grid-cols-1 gap-6">
                        {{-- Nama --}}
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

                        {{-- Email --}}
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

                        {{-- No. Telepon --}}
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

                        {{-- Alamat --}}
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
                </div>

                {{-- Submit Button --}}
                <div class="mt-8 flex justify-end">
                    <button type="submit" 
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Kirim Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.catalog>
