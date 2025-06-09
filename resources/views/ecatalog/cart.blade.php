<x-layouts.catalog>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if(count($cart) > 0)
            <div class="space-y-4">
                @php $total = 0; @endphp

                @foreach($cart as $id => $item)
                    @php
                        $subtotal = $item['harga'] * $item['quantity'];
                        $total += $subtotal;
                    @endphp
                    <div class="flex items-center justify-between bg-white p-4 rounded-xl shadow">
                        <div class="flex items-center gap-4">
                            @if($item['foto'])
                                <img src="{{ asset('storage/' . $item['foto']) }}" class="w-20 h-20 object-cover rounded">
                            @else
                                <div class="w-20 h-20 bg-gray-200 flex items-center justify-center">No Image</div>
                            @endif
                            <div>
                                <h2 class="font-semibold text-lg">{{ $item['nama'] }}</h2>
                                <p class="text-sm text-gray-600">Jumlah: {{ $item['quantity'] }}</p>
                                <p class="text-sm text-gray-800">Harga: Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-md font-bold text-green-600">Subtotal: Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                            <form action="{{ route('cart.remove', $id) }}" method="POST" class="mt-2" onsubmit="return confirm('Yakin ingin menghapus produk ini dari keranjang?');">
                                @csrf
                                <button class="text-red-600 hover:underline text-sm">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach

                <div class="mt-6 text-right">
                    <h3 class="text-xl font-bold text-gray-800">Total: Rp {{ number_format($total, 0, ',', '.') }}</h3>
                    <a href="{{ route('checkout.cart') }}" class="mt-4 inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                        Lanjut Checkout
                    </a>
                </div>
            </div>
        @else
            <div class="text-center">
                <p class="text-gray-500 mb-4">Keranjang belanja kamu kosong.</p>
                <a href="{{ route('ecatalog.index') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                    Kembali ke Katalog Produk
                </a>
            </div>
        @endif
    </div>
</x-layouts.catalog>
