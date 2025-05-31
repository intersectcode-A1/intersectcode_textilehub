<x-layouts.catalog>
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
        <p class="text-center text-gray-500 mb-4">Keranjang belanja kamu kosong.</p>
        <div class="text-center">
            <a href="{{ route('ecatalog.index') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                Kembali ke Katalog Produk
            </a>
        </div>
    @endif
</x-layouts.catalog>
