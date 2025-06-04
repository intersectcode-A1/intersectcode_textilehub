<x-layouts.catalog>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Tombol Kembali --}}
        <div class="mb-6">
            <a href="{{ route('cart.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Keranjang
            </a>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-2xl font-bold mb-6">Checkout Keranjang</h2>

            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Daftar Item --}}
            <div class="mb-8">
                <h3 class="text-lg font-semibold mb-4">Daftar Produk</h3>
                <div class="space-y-4">
                    @foreach($items as $item)
                        <div class="flex justify-between items-center border-b pb-4">
                            <div>
                                <h4 class="font-medium">{{ $item['nama'] }}</h4>
                                <p class="text-sm text-gray-600">{{ $item['quantity'] }} x Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                    
                    <div class="flex justify-between items-center pt-4 font-bold text-lg">
                        <span>Total</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Form Checkout --}}
            <form action="{{ isset($is_direct) ? route('order.submit') : route('order.submit.cart') }}" method="POST" class="space-y-4">
                @csrf
                
                {{-- Data tersembunyi untuk items --}}
                @if(isset($is_direct))
                    <input type="hidden" name="product_id" value="{{ $items[0]['id'] }}">
                @else
                    <input type="hidden" name="total" value="{{ $total }}">
                    @foreach($items as $item)
                        <input type="hidden" name="items[]" value="{{ json_encode($item) }}">
                    @endforeach
                @endif

                {{-- Nama pengguna --}}
                <div>
                    <label for="user_name" class="block mb-1 font-medium">Nama</label>
                    <input id="user_name" type="text" name="user_name" value="{{ old('user_name') }}" required 
                        class="w-full border p-2 rounded @error('user_name') border-red-500 @enderror">
                    @error('user_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block mb-1 font-medium">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required 
                        class="w-full border p-2 rounded @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Alamat --}}
                <div>
                    <label for="alamat" class="block mb-1 font-medium">Alamat Pengiriman</label>
                    <textarea id="alamat" name="alamat" rows="3" required 
                        class="w-full border p-2 rounded @error('alamat') border-red-500 @enderror">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Telepon --}}
                <div>
                    <label for="telepon" class="block mb-1 font-medium">No. Telepon</label>
                    <input id="telepon" type="text" name="telepon" value="{{ old('telepon') }}" required 
                        class="w-full border p-2 rounded @error('telepon') border-red-500 @enderror">
                    @error('telepon')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol Submit --}}
                <div class="flex justify-between items-center pt-4">
                    <a href="{{ route('cart.index') }}" class="text-gray-600 hover:text-gray-800">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                        Proses Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.catalog> 